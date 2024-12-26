<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        // Validate the email input
        $validated = $request->validate([
            'email' => 'required|email|unique:subscribers,email', // Example validation
        ]);

        // Save the email to the database (assuming you have a Subscriber model and table)
        \App\Models\Subscriber::create([
            'email' => $validated['email'],
        ]);

        // Redirect with a success message
        return redirect()->back()->with('success', 'You have successfully subscribed!');
    }
}
