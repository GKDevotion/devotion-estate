<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class RentPropertiesController extends Controller
{
    //

    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 4); // Default 4 per page
        $query = Properties::where('purpose', 2)->where('status', 1);
        $properties = $query->paginate($perPage);
        $total = $properties->total();

        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();

        // Fetch Residential (main_type = 0)
        $residentialTypes = PropertyType::where('main_type', 1)
            ->where('status', 1)
            ->get();

        // Fetch Commercial (main_type = 1)
        $commercialTypes = PropertyType::where('main_type', 2)
            ->where('status', 1)
            ->get();



        return view('frontend.pages.rent-properties', compact(
            'properties',
            'total',
            'locationObj',
            'propertyTypeObj',
            'residentialTypes',
            'commercialTypes',
            'perPage'
        )); //->with('type', 'rent');
    }
    
}
