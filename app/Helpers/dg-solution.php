<?php

use App\Models\AdminMenu;
use App\Models\City;
use App\Models\Configuration;
use App\Models\Continent;
use App\Models\Country;
use App\Models\State;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;

/**
 * Undocumented function
 *
 * @param [type] $key
 * @return void
 */
function getConfigurationfield($key) {
     $client = Configuration::where('key', $key)->first();
     if( $client ) {
         return $client->value;
     } else {
         return false;
     }
}

/**
 * @Function:        <getAdminSideMenu>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <24-11-2021>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function work for get admin panel side bar menu.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
function getAdminSideMenu(){
    $parentArr = AdminMenu::select('id', 'name', 'parent_id', 'group_name', 'class_name', 'icon' )
        ->where( ['parent_id' => 0, 'status' => 1 ] )
        ->orderBy( 'sort_order', 'ASC' )
        ->get();

    if( COUNT( $parentArr ) >0 ){
        foreach( $parentArr as $k=>$parent ){
            $parentArr[$k]['childArr'] = AdminMenu::select('id', 'name', 'parent_id', 'group_name', 'class_name', 'icon')->
                where( [
                'parent_id' => $parent->id,
                'status' => 1
            ] )
            ->orderBy( 'sort_order', 'ASC' )
            ->get();
        }
    }

    return $parentArr;
}

/**
 *
 */
function createTinyUrl(){
	// if( isset( $_GET['create'] ) && $_GET['create'] == 1 ){
	// 	$blogArr = Blogs::select('id')->get();
	// 	foreach( $blogArr as $ar ){
	// 		$short_url = _en( $ar->id );
	// 		Blogs::where( [ "id" => $ar->id ] )->update( [ "short_url" => $short_url ] );
	// 	}
	// }
}

/**
 *
 */
if ( !function_exists('format_number_in_k_notation') ) {
    function format_number_in_k_notation(int $number): string
    {
        $suffixByNumber = function () use ($number) {
            if ($number < 1000) {
                return sprintf('%d', $number);
            }

            if ($number < 1000000) {
                return sprintf('%d%s', floor($number / 1000), 'K+');
            }

            if ($number >= 1000000 && $number < 1000000000) {
                return sprintf('%d%s', floor($number / 1000000), 'M+');
            }

            if ($number >= 1000000000 && $number < 1000000000000) {
                return sprintf('%d%s', floor($number / 1000000000), 'B+');
            }

            return sprintf('%d%s', floor($number / 1000000000000), 'T+');
        };

        return $suffixByNumber();
    }
}

/**
 * To generate a random hex color code in PHP, you can use the following function:
 */
function generateRandomHexColor() {
    $randomColor = '';
    for ($i = 0; $i < 6; $i++) {
        $randomColor .= dechex(rand(0, 15));
    }
    return $randomColor;
}

/**
 * To update or convert a hex color code to its RGB equivalent in PHP, you can use the following function:
 */
function hexToRgb( $hex ) {
    // Remove the leading # if it is present
    $hex = ltrim($hex, '#');

    // Convert 3-digit hex to 6-digit hex
    if (strlen($hex) == 3) {
        $hex = str_repeat($hex[0], 2) . str_repeat($hex[1], 2) . str_repeat($hex[2], 2);
    }

    // Split the hex code into its components
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return $r.", ".$g.", ".$b;
}

/**
 * get country random data
 */
function getRandomContinent(){
    //get random continent
    $continentObj = Continent::select('id')->where( 'status', 1 )->inRandomOrder()->limit(1)->get();

    //get random country by continent
    $countryObj = Country::select('id')->where( ['status' => 1, 'continent_id' => $continentObj[0]->id ] )->inRandomOrder()->limit(1)->get();

    if( isset( $countryObj[0] ) ){
        //get random state by country
        $stateObj = State::select('id')->where( ['status' => 1, 'country_id' => $countryObj[0]->id ] )->inRandomOrder()->limit(1)->get();

        if( isset( $stateObj[0] ) ){
            //get random state by country
            $cityObj = City::select('id')->where( ['status' => 1, 'state_id' => $stateObj[0]->id ] )->inRandomOrder()->limit(1)->get();

            if( isset( $cityObj[0] ) ){
                return ['continent_id' => $continentObj[0]->id, 'country_id' => $countryObj[0]->id, 'state_id' => $stateObj[0]->id, 'city_id' => $cityObj[0]->id ];
            } else {
                return getRandomContinent();
            }
        } else {
            return getRandomContinent();
        }
    } else {
        return getRandomContinent();
    }
}

/**
 *
 */
function getMultiLevelAdminMenuDropdown( $parent = 0, $menuArr = [ '0' => '-- Select Parent Menu --' ], $i = -1 )
{
	$res = AdminMenu::select('id', 'name')->where( ['parent_id' => $parent, 'status' => 1 ] )->orderBy( 'sort_order' )->get()->toArray();

	if( count( $res ) > 0 )
	{
		$i++;
		foreach( $res as $r ){
            $menuArr[$r['id']] = str_repeat(' - ',$i).$r['name'];
			$menuArr = getMultiLevelAdminMenuDropdown( $r['id'], $menuArr, $i );
		}
		return $menuArr;
	} else {
		return $menuArr;
    }
}

/**
 *
 */
function convertAmountToWords($amount) {
    $dollars = floor($amount);
    $cents = round(($amount - $dollars) * 100);

    $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
    $dollarsWords = ucfirst($f->format($dollars));// . " dollars";
    $centsWords = $f->format($cents) . " cents";

    return $cents > 0 ? "$dollarsWords and $centsWords" : $dollarsWords;
}

/**
 *
 */
function getIdBaseValue( $table, $where, $select ){
    $result = DB::table($table)->where( $where )->first();
    return $result->$select;
}

/**
 *
 */
function getSegmentList(){
    return [
        1 => 'Demographics',
        2 => 'Behavior',
        3 => 'Preferences',
        4 => 'Business',
        5 => 'Project',
        6 => 'Software',
        7 => 'Databases',
        8 => 'Website',
        9 => 'Application',
        10 => 'Tourism',
        11 => 'IT Technology',
        12 => 'Fintech'
    ];
}
