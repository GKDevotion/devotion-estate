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
    $query = Properties::where('purpose', 0)->where('status', 1);
    $properties = $query->paginate($perPage);
    $total = $properties->total();

    return view('frontend.pages.buy-properties', compact('properties', 'total', 'perPage'));
}

}
