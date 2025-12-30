<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Banner;
use App\Models\Location;
use App\Models\Properties;
use App\Models\PropertyFeature;
use App\Models\PropertyType;
use Exception;
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
        // $location = Location::select('id', 'name')->where('status', 1)->get();
         $location = Location::select('id', 'name')
        ->where('status', 1)
        ->orderBy('name', 'asc')  // sorted alphabetically
        ->get();
        // Fetch Residential (main_type = 0)
        $residentialTypes = PropertyType::where('main_type', 1)
            ->where('status', 1)
            ->get();

        // Fetch Commercial (main_type = 1)
        $commercialTypes = PropertyType::where('main_type', 2)
            ->where('status', 1)
            ->get();
        $propertyTypeObj = PropertyType::select('id', 'name', 'main_type')->orderBy('name')->get();
        $bannerObjs = Banner::where('status', 1)->orderBy('id', 'DESC')->get();
        $awardObjs = Award::where('status', 1)->orderBy('id', 'DESC')->get();

        return view('frontend.pages.home' , compact('location','bannerObjs','propertyTypeObj','residentialTypes','commercialTypes', 'awardObjs'));
    }

    /**
     *
     */
    public function setSqlStatement(){

        $sqlArr = [
            "ALTER TABLE `property_contact` ADD `property_name` VARCHAR(255) NOT NULL COMMENT 'Reference from the properties table' AFTER `property_id`;",
            "ALTER TABLE `property_contact` ADD `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:is_read , 1:is_unread' AFTER `message`;",
            "ALTER TABLE `property_contact` CHANGE `is_read` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:Read , 1:UnRead';",
            "ALTER TABLE `property_contact` CHANGE `is_read` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:UnRead , 1:Read';",
            "ALTER TABLE `notifications` CHANGE `description` `message` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'notification message';",
            "ALTER TABLE `notifications` CHANGE `status` `is_read` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0: Un-Read, 1: Read';",
            "ALTER TABLE `notifications` ADD `status` TINYINT(1) NOT NULL DEFAULT '0' COMMENT '0:Disabled, 1:Enabled' AFTER `type`;",
            "ALTER TABLE `designations` CHANGE `sort_order` `sort_order` TINYINT NOT NULL DEFAULT '0' COMMENT 'sort ordering';",
            "ALTER TABLE `designations` CHANGE `sort_order` `sort_order` SMALLINT NOT NULL DEFAULT '0' COMMENT 'sort ordering';",
            "ALTER TABLE `banners` ADD `link` VARCHAR(255) NOT NULL AFTER `image`;",
            "ALTER TABLE `property_image_map` ADD `sort_order` TINYINT NOT NULL DEFAULT '0' AFTER `filename`;",
            "ALTER TABLE `properties` CHANGE `status` `status` TINYINT(1) NULL DEFAULT '0' COMMENT '0: Disabled, 1: Enabled, 2: Deleted';",
            "ALTER TABLE `property_variants` CHANGE `unit` `bed` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;",
        ];

        foreach ($sqlArr as $sql) {
            try {
                DB::statement($sql);
                echo "Executed: $sql<br>";
            } catch ( Exception $e ) {
                // echo "Skipped (error): $sql<br>";
            }
        }
    }

}
