<?php

namespace App\Http\Controllers;

use App\Models\Person;

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
    $allproperties = getPropertiesByType(['sell', 'rent'], 6);
    $saleProperties = getPropertiesByType('sell', 6);

    return view('home', compact('allproperties', 'saleProperties'));
}

    }
