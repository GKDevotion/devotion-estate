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
    $query = Properties::where('purpose', 1)->where('status', 1);
    $properties = $query->paginate($perPage);
    $total = $properties->total();

    return view('frontend.pages.rent-properties', compact('properties', 'total', 'perPage'));//->with('type', 'rent');
}

}
