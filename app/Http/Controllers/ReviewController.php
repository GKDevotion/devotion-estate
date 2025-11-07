<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:25',
            'email'       => 'nullable|email',
            'contact_no'  => 'nullable|string|max:20',
            'rating'      => 'required|numeric|min:1|max:5',
            'property_id' => 'required|exists:properties,unique_id',
            'review'      => 'required|string',
        ]);

        Review::create([
            'property_id' => Properties::where('unique_id', $request->property_id)->value('id'),
            'admin_id'     => $request->admin_id ?? 1,
            'name'        => $request->name,
            'email'       => $request->email,
            'contact_no'  => $request->contact_no,
            'rating'      => $request->rating,
            'review'      => $request->review,
        ]);


        return back()->with('success', 'Your review has been submitted successfully!');
    }
}
