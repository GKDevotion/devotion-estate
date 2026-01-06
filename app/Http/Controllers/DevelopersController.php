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

        $developers = Developer::withCount('properties')->where('status', 1)->orderBy('name', 'asc')->latest()->paginate(8); // 8 per page

        return view('frontend.pages.developers', compact('developers'));
    }


    public function search(Request $request)
    {
        $query = trim($request->q);

        if (!$query) {
            return '';
        }

        $developers = Developer::withCount('properties') // ✅ IMPORTANT 
            ->where('name', 'LIKE', "%{$query}%")
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        return view('frontend.layouts.partials.developer-list', compact('developers'))->render();
    }
    
    public function ajaxIndex()
    {
        $developers = Developer::withCount('properties')
            ->orderBy('name')
            ->where('status', 1)
            ->latest()
            ->paginate(8); // page 1 automatically
            
        return view('frontend.layouts.partials.developer-list', compact('developers'))->render();
    }
}
