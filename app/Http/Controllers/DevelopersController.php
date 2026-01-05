<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyType;
use Illuminate\Http\Request;

class DevelopersController extends Controller
{
    //
    public function index(Request $request)
    {

        $developers = Developer::latest()->paginate(8); // 8 per page
   
        return view('frontend.pages.developers', compact(
           
            'developers'
            
        ));
    }

    
    public function search(Request $request)
    {
        $query = $request->get('q');

        $developers = Developer::where('name', 'LIKE', "%{$query}%")
            ->orderBy('name')
            ->get();

        return view('frontend.layouts.partials.developer-list', compact('developers'))->render();
    }
}
