<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\PropertyContact;
use App\Models\Review;
use Illuminate\Http\Request;

class PropertyContactController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:25',
            'email'       => 'nullable|email',
            'mobile_number'  => 'nullable|string|max:20',
            'property_id' => 'required|exists:properties,unique_id',
            'message'      => 'required|string',
        ]);

        PropertyContact::create([
            'property_id' => Properties::where('unique_id', $request->property_id)->value('unique_id'),
            'website_id'     => $request->website_id ?? 1,
            'name'        => $request->name,
            'email'       => $request->email,
            'mobile_number'  => $request->mobile_number,
            'message'      => $request->message,
          
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Your message has been sent successfully!'
        ]);

        // return back()->with('success', 'Your Contact Data has been submitted successfully!');
    }
}
