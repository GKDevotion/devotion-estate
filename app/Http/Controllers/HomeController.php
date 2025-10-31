<?php

namespace App\Http\Controllers;

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

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */



    public function index()
    {
        return view('frontend.pages.home');
    }

    public function showNew($slug)
    {
        $property = Properties::with(['location', 'feature', 'single_image', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.pages.new-properties-detail', compact('property'));
    }

    public function showSale($slug)
    {
        $property = Properties::with(['location', 'feature', 'single_image', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.pages.sale-properties-detail', compact('property'));
    }

}
