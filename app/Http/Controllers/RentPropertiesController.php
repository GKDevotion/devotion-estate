<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class RentPropertiesController extends Controller
{
    //

public function index(Request $request)
{
    $perPage = $request->get('perPage', 4); // Default 4 per page

    // ✅ Fetch only active rent properties (purpose = 1, status = 1)
    $properties = Properties::where('purpose', 1)
        ->where('status', 1)
        ->paginate($perPage);

    // ✅ Count only active rent properties
    $total = Properties::where('purpose', 1)
        ->where('status', 1)
        ->count();

    return view('frontend.pages.rent-properties', compact('properties', 'total', 'perPage'))
        ->with('type', 'rent');
}

}
