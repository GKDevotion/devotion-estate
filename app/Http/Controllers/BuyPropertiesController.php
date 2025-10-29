<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Http\Request;

class BuyPropertiesController extends Controller
{
    //
    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 4); // 12 for sale
        $properties = Properties::where('purpose', 0)->paginate($perPage);
        $total = Properties::where('purpose', 0)->count();

        return view('frontend.pages.buy-properties', compact('properties', 'total', 'perPage'))
            ->with('type', 'sale');
    }
}
