<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class BuyPropertiesController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 4); // Default 4 per page
        $query = Properties::where('purpose', 0)->where('status', 1);
        $properties = $query->paginate($perPage);
        $total = $properties->total();

        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();

        // Fetch Residential (main_type = 0)
        $residentialTypes = PropertyType::where('main_type', 0)
            ->where('status', 1)
            ->get();

        // Fetch Commercial (main_type = 1)
        $commercialTypes = PropertyType::where('main_type', 1)
            ->where('status', 1)
            ->get();

        return view('frontend.pages.buy-properties', compact(
            'properties',
            'locationObj',
            'propertyTypeObj',
            'residentialTypes',
            'commercialTypes',
            'total',
            'perPage'
        ));
    }

    public function search(Request $request)
    {
        $perPage = $request->get('perPage', 4);

        $query = Properties::where('purpose', 0)->where('status', 1);

        // ✅ Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // ✅ Filter by property type (optional)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // ✅ Filter by location (optional)
        if ($request->filled('location')) {
            $query->where('location_id', $request->location);
        }

        $properties = $query->paginate($perPage);
        $total = $properties->total();

        // ✅ Fetch data needed by view (same as index)
        $locationObj = Location::select('id', 'name')->where('status', 1)->get();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();

        $residentialTypes = PropertyType::where('main_type', 0)->where('status', 1)->get();
        $commercialTypes = PropertyType::where('main_type', 1)->where('status', 1)->get();

        return view('frontend.pages.buy-properties', compact(
            'properties',
            'locationObj',
            'propertyTypeObj',
            'residentialTypes',
            'commercialTypes',
            'total',
            'perPage'
        ));
    }
}
