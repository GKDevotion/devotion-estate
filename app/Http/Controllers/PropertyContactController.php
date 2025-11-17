<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\PropertyContact;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            Mail::send('frontend.emails.contactSellerMail', $data, function($message) use ($data){
                $message->to('admin@devotionestate.com')
                        ->subject('New Contact Seller Message');
            });
        } catch( Exception $e ){

        }

        // $to = "admin@devotionestate.com";
        // $subject = "New Contact Seller Message";

        // $message = "
        // <html>
        // <body>
        // <h3>New Contact Message</h3>
        // <p><strong>Property:</strong> ".$data['propertyname']." (".$data['propertyid'].")</p>
        // <p><strong>Name:</strong> ".$data['name']."</p>
        // <p><strong>Mobile:</strong> ".$data['mobile']."</p>
        // <p><strong>Email:</strong> ".$data['email']."</p>
        // <p><strong>Message:</strong> ". $data['msg']."</p>
        // </body>
        // </html>
        // ";

        // $headers  = "MIME-Version: 1.0" . "\r\n";
        // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        // $headers .= "From: Devotion Estate <admin@devotionestate.com>" . "\r\n";

        // $emailmsg = "";
        // if(mail($to, $subject, $message, $headers)){
        //     $emailmsg = "Email sent successfully";
        // }else{
        //     $emailmsg = "Email sending failed";
        // }

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);

        // return back()->with('success', 'Your Contact Data has been submitted successfully!');
    }
}
