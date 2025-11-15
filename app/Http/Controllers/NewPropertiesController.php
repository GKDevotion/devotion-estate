<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class NewPropertiesController extends Controller
{
    //

public function index(Request $request)
{
        $perPage = $request->get('perPage', 4);

        $query = Properties::where('is_new_property', 1)->where('status', 1);
        $properties = $query->paginate($perPage);
        $total = $properties->total();

        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();

        // Fetch Residential (main_type = 1)
        $residentialTypes = PropertyType::where('main_type', 1)
            ->where('status', 1)
            ->get();

        // Fetch Commercial (main_type = 2)
        $commercialTypes = PropertyType::where('main_type', 2)
            ->where('status', 1)
            ->get();

        return view('frontend.pages.new-properties', compact(
            'properties',
            'locationObj',
            'propertyTypeObj',
            'residentialTypes',
            'commercialTypes',
            'total',
            'perPage'
        ))
        ->with('type', 'luxury');
}


}
