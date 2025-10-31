<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use App\Models\Review;
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

    public function show($slug)
    {
        $property = Properties::where('slug', $slug)
            ->with(['location', 'feature', 'single_image', 'images'])
            ->firstOrFail();

        return view('frontend.pages.buy-properties-detail', compact('property'));
    }
}
