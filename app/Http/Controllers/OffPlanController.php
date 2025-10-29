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

    // Fetch both rent (0) and sale (1) properties
    $properties = Properties::whereIn('purpose', [0, 1])->paginate($perPage);

    // Count total of both
    $total = Properties::whereIn('purpose', [0, 1])->count();

    return view('frontend.pages.off-plan', compact('properties', 'total', 'perPage'))
        ->with('type', 'all'); // optional flag
}



}
