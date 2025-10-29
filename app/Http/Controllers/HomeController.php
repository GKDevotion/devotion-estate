<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Properties;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    // public function redirectAdmin()
    // {
    //     return redirect()->route('admin.dashboard');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
 


public function index()
{
    $perPage = 6; // Set number of properties per page

    // Fetch properties with their image relationship
    $properties = Properties::with('image')->paginate($perPage);

    // Other property data
    $allproperties = getPropertiesByType(['sell', 'rent'], 6);
    $saleProperties = getPropertiesByType('sell', 6);

    // Pass all to the view
    return view('home', compact('allproperties', 'saleProperties', 'properties'));
}


    }
