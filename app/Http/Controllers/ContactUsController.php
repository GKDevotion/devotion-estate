<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\PropertyType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    //

    public function index()
    {
        // Fetch property types from DB
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();
        return view('frontend.pages.contact-us', compact('propertyTypeObj')); // assuming your blade file is buy-properties.blade.php
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validate Input
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|email',
            'comment' => 'required|string',
        ]);

        // ✅ Step 2: Store Data
        ContactUs::create([
            'website_id'     => $request->website_id ?? 1,   // Default website_id = 1
            'name'           => $request->name,
            'type'           => $request->type,
            'sub_type'       => $request->sub_type,
            'email'          => $request->email,
            'ip_address'     => $request->ip(),              // User IP
            'comment'        => $request->comment,
        ]);

        // EMAIL DETAILS
        $data = [
            'website_id'     => $request->website_id ?? 1,
            'name'    => $request->name,
            'type'    => $request->type,
            'sub_type'    => $request->sub_type,
            'email'   => $request->email,
            'comment'     => $request->comment,
        ];

        try {
            // SEND MAIL
            Mail::send('frontend.emails.contactMail', $data, function ($message) use ($data) {
                $message->to('admin@devotionestate.com')
                    ->subject('New Contact Us Message');
            });
        } catch (Exception $e) {
        }

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);

        // // ✅ Step 3: Return with Success Message
        // return back()->with('success', 'Your message has been sent successfully!');
    }
}
