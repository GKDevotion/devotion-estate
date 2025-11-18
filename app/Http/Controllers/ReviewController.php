<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Review;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReviewController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:25',
            'email'       => 'nullable|email',
            'contact_no'  => 'nullable|string|max:20',
            'property_id' => 'required|exists:properties,unique_id',
            'review'      => 'required|string',
        ]);

        Review::create([
            'property_id' => Properties::where('unique_id', $request->property_id)->value('id'),
            'admin_id'     => $request->admin_id ?? 1,
            'name'        => $request->name,
            'email'       => $request->email,
            'contact_no'  => $request->contact_no,
            'review'      => $request->review,
            'status'      => 1, 
        ]);

           // EMAIL DETAILS
        $data = [
            'propertyname' => Properties::where('id', $request->property_id)->value('name'),
            'name'    => $request->name,
            'contact_no'    => $request->contact_no,
            'email'   => $request->email,
            'review'     => $request->review,
        ];


        try{
            // SEND MAIL
            Mail::send('frontend.emails.reviewMail', $data, function($message) use ($data){
                $message->to('admin@devotionestate.com')
                        ->subject('New Property Review Message');
            });
        } catch( Exception $e ){

        }

        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);
        // return back()->with('success', 'Your review has been submitted successfully!');
    }
}
