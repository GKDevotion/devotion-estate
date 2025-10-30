<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class HotOfferController extends Controller
{
    //

public function index(Request $request)
{
        $perPage = $request->get('perPage', 4);

        // Fetch only active luxury properties (is_luxury_property = 1)
        $properties = Properties::whereIn('purpose', [0, 1])
            ->where('status', 1)
            ->where('is_hot_offer', 1) // ✅ Only luxury ones
            ->paginate($perPage);

        // Count total luxury properties
        $total = Properties::whereIn('purpose', [0, 1])
            ->where('status', 1)
            ->where('is_hot_offer', 1) // ✅ Count only luxury ones
            ->count();

        return view('frontend.pages.hot-offer', compact('properties', 'total', 'perPage'))
        ->with('type', 'luxury');
}


}
