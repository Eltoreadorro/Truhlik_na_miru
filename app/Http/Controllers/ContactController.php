<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomOrderMail;
use Illuminate\Support\Facades\Http;
use App\Models\ContactRequest;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

   public function sendCustomOrder(Request $request)
{
    Log::info('Contact form submitted', $request->all());

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'details' => 'required|string|max:2000',
        'g-recaptcha-response' => 'sometimes|required'
    ]);

    // Отладка reCAPTCHA
    if (config('services.recaptcha.enabled')) {
        Log::debug('Validating reCAPTCHA');
        $recaptchaResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip()
        ]);

        if (!$recaptchaResponse->json()['success']) {
            Log::warning('reCAPTCHA failed', $recaptchaResponse->json());
            return back()->with('error', 'Potvrďte prosím, že nejste robot.');
        }
    }

    try {
        // Сохранение в базу - используем ТОЧНО те имена полей, что в БД
        $contact = ContactRequest::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? null,
            'details' => $validatedData['details'], // Используем details вместо message
            'ip_address' => $request->ip()
        ]);

        Log::info('Contact saved to DB', ['id' => $contact->id]);

        // Отправка письма
        Mail::to('truhliknamiru@gmail.com')->send(new CustomOrderMail([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'] ?? 'Nezadáno',
            'details' => $validatedData['details']
        ]));

        return back()->with('success', 'Děkujeme za váš požadavek!');

    } catch (\Exception $e) {
        Log::error('Error saving contact', [
            'error' => $e->getMessage(),
            'data' => $validatedData
        ]);
        return back()->with('error', 'Došlo k chybě: ' . $e->getMessage());
    }
}
}
