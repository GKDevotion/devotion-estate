<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class DeveloperPropertiesController extends Controller
{
    //
    public function index(Request $request, $id)
    {
        $developerId = $id;

        $perPage = $request->get('perPage', 4);

        $properties = Properties::where('developer_id', $developerId)
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);

        $total = $properties->total();

        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $developerObj = Developer::select('id', 'name', 'description')->where('id', $developerId)->where('status', 1)->first();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();

        $residentialTypes = PropertyType::where('main_type', 1)->where('status', 1)->get();
        $commercialTypes = PropertyType::where('main_type', 2)->where('status', 1)->get();

        return view('frontend.pages.developer-properties', compact(
            'properties',
            'locationObj',
            'propertyTypeObj',
            'residentialTypes',
            'developerObj',
            'commercialTypes',
            'total',
            'perPage',
            'developerId'
        ));
    }
}
