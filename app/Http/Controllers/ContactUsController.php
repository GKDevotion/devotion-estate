<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\PropertyType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Stevebauman\Location\Facades\Location;

class ContactUsController extends Controller
{
    //

    public function index()
    {
        // Fetch property types from DB
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->where('status', 1)->orderBy('name')->get();
          // Generate 6 digit code
        $code = strtoupper(Str::random(6));
        Session::put('contact_verification_code', $code);

        return view('frontend.pages.contact-us', compact('propertyTypeObj', 'code')); // assuming your blade file is buy-properties.blade.php
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validate Input
        $request->validate([
            'name' => 'required|string|max:25',
            'email' => 'required|email',
            'comment' => 'required|string',
             'verification_code' => 'required'
        ]);

        
        if ($request->verification_code !== Session::get('contact_verification_code')) {
            return back()->withErrors([
                'verification_code' => 'Invalid verification code'
            ])->withInput();
        }

        // Clear code after success
        Session::forget('contact_verification_code');

        // // ✅ Step 2: Store Data
        // ContactUs::create([
        //     'website_id'     => $request->website_id ?? 1,   // Default website_id = 1
        //     'name'           => $request->name,
        //     'type'           => $request->type,
        //     'sub_type'       => $request->sub_type,
        //     'email'          => $request->email,
        //     'ip_address'     => $request->ip(),              // User IP
        //     'comment'        => $request->comment,
        // ]);

            $ip = "122.173.87.53";//$request->ip();

        if ($ip != "127.0.0.1" && strlen($ip) > 7) {
                $locationPosition = Location::get($ip);
                $locationPosition = json_encode($locationPosition);
                $locationPosition = json_decode($locationPosition, 1);

                $ContactUs = new ContactUs(); 
                $ContactUs->website_id  = $reques->website_id ?? 1;
                $ContactUs->name        = $request->name;
                $ContactUs->email       = $request->email;
                $ContactUs->type        = $request->type; 
                $ContactUs->sub_type    = $request->sub_type;
                $ContactUs->ip_address = $request->ip();                
                $ContactUs->comment      = $request->comment;
                
                $ContactUs->areaCode = $locationPosition['areaCode'];
                $ContactUs->cityName = $locationPosition['cityName'];
                $ContactUs->countryCode = $locationPosition['countryCode'];
                $ContactUs->countryName = $locationPosition['countryName'];
                 
                $ContactUs->isoCode = $locationPosition['isoCode'];
                $ContactUs->latitude = $locationPosition['latitude'];
                $ContactUs->longitude = $locationPosition['longitude'];
                $ContactUs->metroCode = $locationPosition['metroCode'];
                $ContactUs->postalCode = $locationPosition['postalCode'];
                $ContactUs->regionCode = $locationPosition['regionCode'];
                $ContactUs->regionName = $locationPosition['regionName'];
                $ContactUs->zipCode     = $locationPosition['zipCode'];
                $ContactUs->save();
            }

        if( getConfigurationField( "IS_SEND_MAIL" ) ){
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
                        ->cc('gk@devotiontech.io') // Add CC email here
                        ->subject('New Contact Us Message');
                });
            } catch (Exception $e) {
                Log::error('Error occurred: ' . $e->getMessage(), [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString(),
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);

        // // ✅ Step 3: Return with Success Message
        // return back()->with('success', 'Your message has been sent successfully!');
    }
}
