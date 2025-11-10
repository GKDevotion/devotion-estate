<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
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
        $location = Location::select('id', 'name')->where('status', 1)->get();
        // Fetch Residential (main_type = 0)
        $residentialTypes = PropertyType::where('main_type', 1)
            ->where('status', 1)
            ->get();

        // Fetch Commercial (main_type = 1)
        $commercialTypes = PropertyType::where('main_type', 2)
            ->where('status', 1)
            ->get();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();
        return view('frontend.pages.home' , compact('location','propertyTypeObj','residentialTypes','commercialTypes'));
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
