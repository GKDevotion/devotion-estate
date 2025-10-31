<?php

namespace App\Http\Controllers;

class InvestmentAdvisoryController extends Controller
{
    public function index()
    {
        // If you later connect to database, fetch properties here
        // Example: $properties = Property::all();

        return view('frontend.pages.investment-advisory'); // assuming your blade file is buy-properties.blade.php
    }
}
