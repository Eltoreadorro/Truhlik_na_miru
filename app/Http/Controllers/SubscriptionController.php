<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email'
        ]);

        Subscriber::create([
            'email' => $request->email,
            'is_active' => true
        ]);

        return back()->with('success', 'Děkujeme za váš zájem! Nyní budete dostávat naše novinky.');
    }
}
