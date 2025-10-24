<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BuyerGuideController extends Controller
{
    //

          public function index()
    {
        // If you later connect to database, fetch properties here
        // Example: $properties = Property::all();

        return view('frontend.pages.buyer-guide'); // assuming your blade file is buy-properties.blade.php
    }
}
