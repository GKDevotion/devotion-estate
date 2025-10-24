<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsConditionController extends Controller
{
    //

               public function index()
    {
        // If you later connect to database, fetch properties here
        // Example: $properties = Property::all();

        return view('frontend.pages.terms-condition'); // assuming your blade file is privacy-policy.blade.php
    }
}
