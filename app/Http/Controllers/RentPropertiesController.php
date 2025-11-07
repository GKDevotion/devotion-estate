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
    $query = Properties::where('purpose', 2)->where('status', 1);
    $properties = $query->paginate($perPage);
    $total = $properties->total();

    return view('frontend.pages.rent-properties', compact('properties', 'total', 'perPage'));//->with('type', 'rent');
}

    public function show($slug)
    {
        $property = Properties::where('slug', $slug)
            ->with(['location', 'feature', 'single_image', 'images'])
            ->firstOrFail();

        return view('frontend.pages.buy-properties-detail', compact('property'));
    }

}
