<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MortgageController extends Controller
{
    public function index()
    {
        
        return view('frontend.layouts.partials.mortgage');
    }

}
