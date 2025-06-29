<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactRequest;
use Illuminate\Http\Request;

class ContactRequestController extends Controller
{
    public function index()
    {
        $requests = ContactRequest::latest()->paginate(10);
        return view('admin.contact-requests.index', compact('requests'));
    }

    public function show(ContactRequest $contactRequest)
    {
        return view('admin.contact-requests.show', compact('contactRequest'));
    }

    public function destroy(ContactRequest $contactRequest)
    {
        $contactRequest->delete();
        return back()->with('success', 'Požadavek byl smazán.');
    }
}
