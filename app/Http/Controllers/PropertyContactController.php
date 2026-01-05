<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\PropertyContact;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use Stevebauman\Location\Facades\Location;

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

        // PropertyContact::create([
        //     'property_id' => $request->property_id,
        //     'property_name' => $request->property_name,
        //     'property_unique_id' => $request->property_unique_id,
        //     'website_id'  => $request->website_id ?? 1,
        //     'name'        => $request->name,
        //     'email'       => $request->email,
        //     'mobile_number'  => $request->mobile_number,
        //     'message'      => $request->message,

        // ]);

           // 3. Get user IP
        $ip = "122.173.87.53";//$request->ip();

        if ($ip != "127.0.0.1" && strlen($ip) > 7) {
                $locationPosition = Location::get($ip);
                $locationPosition = json_encode($locationPosition);
                $locationPosition = json_decode($locationPosition, 1);

                $propertyContact = new PropertyContact();
                $propertyContact->property_id = $request->property_id;
                $propertyContact->property_name = $request->property_name;
                $propertyContact->property_unique_id = $request->property_unique_id;
                $propertyContact->website_id  = $reques->website_id ?? 1;
                $propertyContact->name        = $request->name;
                $propertyContact->email       = $request->email;
                $propertyContact->mobile_number  = $request->mobile_number;
                $propertyContact->message      = $request->message;
                
                $propertyContact->areaCode = $locationPosition['areaCode'];
                $propertyContact->cityName = $locationPosition['cityName'];
                $propertyContact->countryCode = $locationPosition['countryCode'];
                $propertyContact->countryName = $locationPosition['countryName'];
                $propertyContact->ip = $locationPosition['ip'];
                $propertyContact->isoCode = $locationPosition['isoCode'];
                $propertyContact->latitude = $locationPosition['latitude'];
                $propertyContact->longitude = $locationPosition['longitude'];
                $propertyContact->metroCode = $locationPosition['metroCode'];
                $propertyContact->postalCode = $locationPosition['postalCode'];
                $propertyContact->regionCode = $locationPosition['regionCode'];
                $propertyContact->regionName = $locationPosition['regionName'];
                $propertyContact->zipCode     = $locationPosition['zipCode'];
                $propertyContact->save();
            }

        if( getConfigurationField( "IS_SEND_MAIL" ) ){
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

                if( false ){
                    Mail::send('frontend.emails.contactSellerMail', $data, function($message) use ($data){
                        $message->to('admin@devotionestate.com')
                            ->cc('gk@devotiontech.io') // Add CC email here
                            ->subject('New Property Contact Seller Message');
                    });
                }

                if( true ){
                    $mail = new PHPMailer(true);

                    // SERVER SETTINGS (GoDaddy shared hosting)
                    $mail->isSMTP();
                    // $mail->Host = "relay-hosting.secureserver.net";
                    // $mail->Port = 25;
                    // $mail->SMTPAuth = false;
                    // $mail->SMTPSecure = false;

                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'admin@devotionestate.com';
                    $mail->Password   = 'kyke pskc xxqa qbqv';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port       = 587;


                    // SENDER DETAILS
                    $mail->setFrom('admin@devotionestate.com', 'Devotion Estate');

                    // RECEIVER + CC
                    $mail->addAddress('admin@devotionestate.com');
                    $mail->addCC('gk@devotiontech.io');

                    // SUBJECT
                    $mail->Subject = "New Property Contact Us Message";

                    // BODY (HTML view)
                    $html = view('frontend.emails.contactSellerMail', $data)->render();
                    $mail->isHTML(true);
                    $mail->Body = $html;

                    // SEND
                    $mail->send();
                }

            } catch( Exception $e ){
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

        // return back()->with('success', 'Your Contact Data has been submitted successfully!');
    }
}
