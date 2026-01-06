<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Banner;
use App\Models\Developer;
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
    public function __construct() {}

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

        $developer = Developer::select('id', 'name', 'image')
            ->where('status', 1)
            ->orderBy('name', 'asc')  // sorted alphabetically
            ->get();

        $developerImages = Developer::where('status', 1)
            ->orderBy('sort_order', 'asc')   // controls image order
            ->whereNotNull('image')
            ->get(['id', 'image']);

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

        return view('frontend.pages.home', compact('location', 'bannerObjs', 'propertyTypeObj', 'residentialTypes', 'developer', 'developerImages', 'commercialTypes', 'awardObjs'));
    }

    /**
     *
     */
    public function setSqlStatement()
    {

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
            "ALTER TABLE `property_variants` ADD `related_id` TEXT NOT NULL AFTER `property_id`;",
            "ALTER TABLE `property_variants` ADD `property_type` TEXT NOT NULL AFTER `price`;",
            "ALTER TABLE `developers` ADD `image` VARCHAR(255) NOT NULL AFTER `name`;",
            "ALTER TABLE `developers` ADD `sort_order` SMALLINT NOT NULL DEFAULT '0' COMMENT 'sort ordering' AFTER `image`;",
            "ALTER TABLE `developers` ADD `description` LONGTEXT NOT NULL AFTER `image`;",
            "ALTER TABLE `developers` ADD `sub_title` TEXT NOT NULL AFTER `image`;",
            "ALTER TABLE `developers` CHANGE `description` `description` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;",
            "ALTER TABLE `property_contact` ADD `areaCode` VARCHAR(4) NULL DEFAULT NULL AFTER `message`, ADD `cityName` VARCHAR(30) NULL DEFAULT NULL AFTER `areaCode`, ADD `countryCode` VARCHAR(4) NULL DEFAULT NULL AFTER `cityName`, ADD `ip` VARCHAR(20) NULL DEFAULT NULL AFTER `countryCode`, ADD `isoCode` VARCHAR(5) NULL DEFAULT NULL AFTER `ip`, ADD `latitude` VARCHAR(10) NULL DEFAULT NULL AFTER `isoCode`, ADD `longitude` VARCHAR(10) NULL DEFAULT NULL AFTER `latitude`, ADD `metroCode` VARCHAR(5) NULL DEFAULT NULL AFTER `longitude`, ADD `postalCode` VARCHAR(10) NULL DEFAULT NULL AFTER `metroCode`, ADD `regionCode` VARCHAR(5) NULL DEFAULT NULL AFTER `postalCode`, ADD `regionName` VARCHAR(100) NULL DEFAULT NULL AFTER `regionCode`, ADD `zipCode` VARCHAR(10) NULL DEFAULT NULL AFTER `regionName`;",
            "ALTER TABLE `property_contact` CHANGE `countryName` `countryName` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL;",
            "ALTER TABLE `developers` CHANGE `sub_title` `short_description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;",
            "ALTER TABLE `developers` CHANGE `image` `image` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;",
            "ALTER TABLE `developers` CHANGE `short_description` `short_description` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;"
        ];

        foreach ($sqlArr as $sql) {
            try {
                DB::statement($sql);
                echo "Executed: $sql<br>";
            } catch (Exception $e) {
                // echo "Skipped (error): $sql<br>";
            }
        }
    }
}
