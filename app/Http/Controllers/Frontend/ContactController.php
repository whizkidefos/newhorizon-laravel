<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ContactFormRequest;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(ContactFormRequest $request)
    {
        try {
            // Store the contact message
            $contactMessage = ContactMessage::create($request->validated());

            // Send email notification
            Mail::to(config('mail.contact.address', 'info@newhorizon.com'))
                ->send(new ContactFormSubmission($contactMessage));

            // Log successful submission
            Log::info('Contact form submitted', [
                'contact_id' => $contactMessage->id,
                'email' => $contactMessage->email
            ]);

            return back()->with('success', 'Thank you for your message. We will be in touch shortly.');
        } catch (\Exception $e) {
            // Log the error
            Log::error('Contact form submission failed', [
                'error' => $e->getMessage(),
                'data' => $request->except('_token')
            ]);

            return back()
                ->withInput()
                ->with('error', 'Sorry, there was a problem sending your message. Please try again later.');
        }
    }
}