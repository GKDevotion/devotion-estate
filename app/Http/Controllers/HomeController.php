<?php

namespace App\Http\Controllers;

use App\Models\Properties;
use Illuminate\Support\Facades\DB;

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

    /**
     *
     */
    public function setSqlStatement(){

        $sqlArr = [
            "ALTER TABLE `users` CHANGE `designtation_id` `designation_id` INT NULL DEFAULT '0' COMMENT 'reference for the designation table';",
            "ALTER TABLE `properties` CHANGE `is_laxury_Property` `is_luxury_property` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: No, 1: Yes';"
        ];

        foreach( $sqlArr as $sql ){
            DB::statement( $sql );
        }
    }

}
