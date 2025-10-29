<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class BuyPropertiesController extends Controller
{
    //
      public function index(Request $request)
    {
        // If you later connect to database, fetch properties here
        // Example: $properties = Property::all();
  // Get per-page value (default 4)
        $perPage = $request->get('perPage', 4);

        // Fetch properties with pagination
        $properties = Properties::paginate($perPage);

        // Total property count
        $total = Properties::count();
        
        return view('frontend.pages.buy-properties', compact('properties', 'total', 'perPage')); // assuming your blade file is buy-properties.blade.php
    }
}
