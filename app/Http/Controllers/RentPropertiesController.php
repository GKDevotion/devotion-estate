<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class RentPropertiesController extends Controller
{
    //

      public function index(Request $request)
  {
    $perPage = $request->get('perPage', 4); // 12 for sale
    $properties = Properties::where('purpose', 1)->paginate($perPage);
    $total = Properties::where('purpose', 1)->count();

    return view('frontend.pages.rent-properties', compact('properties', 'total', 'perPage'))
        ->with('type', 'rent');
}

}
