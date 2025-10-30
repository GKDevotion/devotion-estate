<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class BuyPropertiesController extends Controller
{
    //
public function index(Request $request)
{
    $perPage = $request->get('perPage', 4); // Default 4 per page (can be adjusted)

    // ✅ Fetch only active sale properties (purpose = 0, status = 1)
    $properties = Properties::where('purpose', 0)
        ->where('status', 1)
        ->paginate($perPage);

    // ✅ Count only active sale properties
    $total = Properties::where('purpose', 0)
        ->where('status', 1)
        ->count();

    return view('frontend.pages.buy-properties', compact('properties', 'total', 'perPage'))
        ->with('type', 'sale');
}

}
