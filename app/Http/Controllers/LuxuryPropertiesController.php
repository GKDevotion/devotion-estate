<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class LuxuryPropertiesController extends Controller
{
    //

public function index(Request $request)
{
        $perPage = $request->get('perPage', 4);

        $query = Properties::where('is_laxury_property', 1)->where('status', 1);
        $properties = $query->paginate($perPage);
        $total = $properties->total();

        return view('frontend.pages.luxury-properties', compact('properties', 'total', 'perPage'))
        ->with('type', 'luxury');
}


}
