<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RentPropertiesController extends Controller
{
    //

          public function index()
    {
        // If you later connect to database, fetch properties here
        // Example: $properties = Property::all();

        return view('frontend.pages.rent-properties'); // assuming your blade file is buy-properties.blade.php
    }
}
