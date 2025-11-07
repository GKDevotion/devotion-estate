<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\User;

class PropertySendMailController extends Controller{

public function sendMail($agent_id)
{
    $agent = User::where('id', $agent_id)
        ->where('status', 1)
        ->where('type', 4)
        ->firstOrFail();

    $subject = 'Property Inquiry';
    $messageBody = "Hello {$agent->first_name},\n\nI am interested in one of your properties. Please share more details.";

    try {
        Mail::raw($messageBody, function ($message) use ($agent, $subject) {
            $message->to($agent->email_id)
                    ->subject($subject)
                    ->from('support@devotionestate.com', 'Devotion Estate');
        });

        return back()->with('success', 'Inquiry email sent successfully to the agent!');
    } catch (\Exception $e) {
        return back()->with('error', 'Failed to send email. Please try again later.');
    }
}

}