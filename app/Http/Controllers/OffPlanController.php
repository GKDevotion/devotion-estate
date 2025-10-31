<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class OffPlanController extends Controller
{
    //
public function index(Request $request)
{
    $perPage = $request->get('perPage', 4);

    $query = Properties::where('is_complete', 3)->where('status', 1);
    $properties = $query->paginate($perPage);
    $total = $properties->total();

    return view('frontend.pages.off-plan', compact('properties', 'total', 'perPage'));
}

    public function show($slug)
    {
        $property = Properties::where('slug', $slug)
            ->with(['location', 'feature', 'single_image', 'images'])
            ->firstOrFail();

        return view('frontend.pages.off-plan-detail', compact('property'));
    }


}
