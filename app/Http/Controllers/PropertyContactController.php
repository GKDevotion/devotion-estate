<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\PropertyContact;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;

class PropertyContactController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:25',
            'email'       => 'nullable|email',
            'mobile_number'  => 'nullable|string|max:20',
            'message'      => 'required|string',
        ]);

        PropertyContact::create([
            'property_id' => $request->property_id,
            'property_unique_id' => $request->property_unique_id,
            'website_id'  => $request->website_id ?? 1,
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile_number'  => $request->mobile_number,
            'message'      => $request->message,

        ]);

        // EMAIL DETAILS
        $data = [
            'propertyid' => $request->property_unique_id,
            'propertyname' => Properties::where('id', $request->property_id)->value('name'),
            'name'    => $request->name,
            'mobile'    => $request->mobile_number,
            'email'   => $request->email,
            'msg'     => $request->message,
        ];


        try{
            // SEND MAIL
            // Mail::send('frontend.emails.contactSellerMail', $data, function($message) use ($data){
            //     $message->to('admin@devotionestate.com')
            //         ->cc('gk@devotiontech.io') // Add CC email here
            //         ->subject('New Contact Seller Message');
            // });

            $mail = new PHPMailer(true);

            // SERVER SETTINGS (GoDaddy shared hosting)
            $mail->isSMTP();
            $mail->Host = "relay-hosting.secureserver.net";
            $mail->Port = 25;
            $mail->SMTPAuth = false;
            $mail->SMTPSecure = false;

            // SENDER DETAILS
            $mail->setFrom('admin@devotionestate.com', 'Devotion Estate');

            // RECEIVER + CC
            $mail->addAddress('admin@devotionestate.com');
            $mail->addCC('gk@devotiontech.io');

            // SUBJECT
            $mail->Subject = "New Contact Us Message";

            // BODY (HTML view)
            $html = view('frontend.emails.contactSellerMail', $data)->render();
            $mail->isHTML(true);
            $mail->Body = $html;

            // SEND
            $mail->send();

        } catch( Exception $e ){
            Log::error('Error occurred: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);

        // return back()->with('success', 'Your Contact Data has been submitted successfully!');
    }
}
