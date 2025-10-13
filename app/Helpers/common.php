<?php

use App\Http\Resources\PositionResource;
use App\Mail\ClientOnBoardMail;
use App\Models\Address;
use App\Models\AdminLog;
use App\Models\City;
use App\Models\Continent;
use App\Models\Country;
use App\Models\Customer;
use App\Models\Religion;
use App\Models\ScheduleList;
use App\Models\SocialMediaPlatform;
use App\Models\State;
use App\Services\ActivityLogService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
/*
++++++++++++++++++++++++++++++++++++++++++++++
	display pagetitle and header title on browser
++++++++++++++++++++++++++++++++++++++++++++++
*/
function pgTitle($pgName)
{
	return ucwords(str_replace(array(0=>'-',1=>'_'),' ',$pgName));
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for @abstact function will check if form is posted>
 */
function isPost()
{
	if( $_SERVER['REQUEST_METHOD'] == "POST" || !empty($_POST) )
		return true;
	else
		return false;
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for >
 * This function decode ids and return in array.
 *basically it will decode using base64 algo.
 */
function _de($id)
{
	return decrypt($id);
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for >
 *	This function encode ids and return in array.
 *	basically it will encode using base64 algo.
 */
function _en($id)
{
	return encrypt($id);
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for >
 *	Load image from url. if not file exist then
 *	it will load default selected image.
 *	@params : $url -> URL of image [url will be relative].
 *			  $fl -> Flag stand for return image path only.
 *	@returrn : Path of image
 */
function load_image($url='')
{
	if( $url != '' && file_exists('./'.$url) )
		return url($url);
	else
		return url("public/images/no-image.jpg");
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for @abstract function will convert timein seconds to string>
 */
function time2string($time)
{
    $second = 1;
    $minute = 60*$second;
    $hour   = 60*$minute;
    $day    = 24*$hour;

    $ans[0] = floor($time/$day);
    $ans[1] = floor(($time%$day)/$hour);
    $ans[2] = floor((($time%$day)%$hour)/$minute);
    $ans[3] = floor(((($time%$day)%$hour)%$minute)/$second);

    return ( !empty($ans[0]) ? $ans[0].' Day ': '' ).( !empty($ans[1]) ? $ans[1].' Hr ': '' ).( !empty($ans[2]) ? $ans[2].' Min ': '' ).( !empty($ans[3]) ? $ans[3].' Sec': '' );
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for @abstract fetch string within specified start and end>
 */
function fetchSubStr( $str, $start, $end, &$offsetI=0 )
{
	$pos1 = strpos( $str, $start );
	if( $pos1 !== FALSE )
	{
		$pos1 = $pos1 + strlen( $start );

		$pos2 = FALSE;
		if( !empty( $end ) )
			$pos2 = strpos( $str, $end, $pos1 );

		if( $pos2 !== FALSE )
		{
			$offsetI = $pos2;
			return substr( $str, $pos1, ( $pos2 - $pos1 ) );
		}
		else
		{
			$offsetI = $pos1;
			return substr( $str, $pos1 );
		}
	}
}

/**
 * @Function:        <login>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <10-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function for @abstract fetch last substring within specified start and end>
 */
function fetchLastSubStr( $str, $start, $end, &$offsetI=0 )
{
	$pos1 = strrpos( $str, $start );
	if( $pos1 !== FALSE )
	{
		$pos1 = $pos1 + strlen( $start );

		$pos2 = FALSE;
		if( !empty( $end ) )
			$pos2 = strpos( $str, $end, $pos1 );

		if( $pos2 !== FALSE )
		{
			$offsetI = $pos2;
			return substr( $str, $pos1, ( $pos2 - $pos1 ) );
		}
		else
		{
			$offsetI = $pos1;
			return substr( $str, $pos1 );
		}
	}
}

/**
 * @Function:        <cmn_getURL>
 * @Author:          Gautam Kakadiya
 * @Created On:      <07-02-2020>
 * @Last Modified By:
 * @Last Modified:
 * @Description:     <This methode create proper browser URL>
 */
function cmn_getURL( $url = "" )
{
    if ( strpos( $url, 'http://') !== false) {
        //
    }
    else if ( strpos( $url, 'https://') !== false) {
        //
    }
    else
        $url = "http://".$url;

    return $url;
}

/**
 * @Function:        <startQueryLog>
 * @Author:          Gautam Kakadiya
 * @Created On:      <27-02-2020>
 * @Last Modified By:
 * @Last Modified:
 * @Description:     <This methode start query log>
 */
function startQueryLog()
{
    DB::enableQueryLog();
}

/**
 * @Function:        <displayQueryResult>
 * @Author:          Gautam Kakadiya
 * @Created On:      <27-02-2020>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:
 * @Description:     <This methode create result array>
 */
function displayQueryResult()
{
    $query = DB::getQueryLog();
    pr($query);
}

/**
 * Most cards use the Luhn algorithm for checksums:
 * check_cc() will return false if the card number isn’t valid and if it is valid, will return a string containing the type of card matched.
 */
function check_cc($cc, $extra_check = false){
    $cards = array(
        "visa" => "(4\d{12}(?:\d{3})?)",
        "amex" => "(3[47]\d{13})",
        "jcb" => "(35[2-8][89]\d\d\d{10})",
        "maestro" => "((?:5020|5038|6304|6579|6761)\d{12}(?:\d\d)?)",
        "solo" => "((?:6334|6767)\d{12}(?:\d\d)?\d?)",
        "mastercard" => "(5[1-5]\d{14})",
        "switch" => "(?:(?:(?:4903|4905|4911|4936|6333|6759)\d{12})|(?:(?:564182|633110)\d{10})(\d\d)?\d?)",
    );
    $names = array("Visa", "American Express", "JCB", "Maestro", "Solo", "Mastercard", "Switch");
    $matches = array();
    $pattern = "#^(?:".implode("|", $cards).")$#";
    $result = preg_match($pattern, str_replace(" ", "", $cc), $matches);
    if($extra_check && $result > 0){
        $result = (validatecard($cc))?1:0;
    }
    return ($result>0)?$names[sizeof($matches)-2]:false;
}

/**
 * Most cards use the Luhn algorithm for checksums:
 */
function validatecard($cardnumber) {
    $cardnumber=preg_replace("/\D|\s/", "", $cardnumber);  # strip any non-digits
    $cardlength=strlen($cardnumber);
    $parity=$cardlength % 2;
    $sum=0;
    for ($i=0; $i<$cardlength; $i++) {
      $digit=$cardnumber[$i];
      if ($i%2==$parity) $digit=$digit*2;
      if ($digit>9) $digit=$digit-9;
      $sum=$sum+$digit;
    }
    $valid=($sum%10==0);
    return $valid;
}

/**
 *
 */
function getField($table, $field, $value, $where)
{
    $result = DB::table($table)->where($field, $where)->first();
    return $result->$value;
}

/**
 *
 */
function fireBaseServerKey()
{
    return 'AAAA6CPQreA:APA91bGuCeFMECxwKX4Rx9A5DxKqXa2I3ds9LYri_caVDYze7lUfQm4y2zDvUCe7rsbV0kaX7vBgkPkcZu7Q0dUPKctkmHJ43Yt5-YRH1mk6BXbcr7S_qLsP_lX31KBp0vayb7SIpgkb';
}

/**
 * convert string in to proper format
 */
function convertStringToSlug( $str='', $replace=['-'] )
{
	$slug = preg_replace( ['/-+/'], $replace, preg_replace( ['/[^a-z0-9-]+/'], $replace, trim( strtolower( $str ) ) ) );

    if ( str_ends_with( $slug, '-' ) ) {
        $slug = rtrim( $slug, '-');
    }

    return $slug;
}

/**
 * Say you were displaying the size of a file in PHP. You obviously get the file size in Bytes by using filesize().
 * Here is a simple function to convert Bytes to KB, MB, GB, TB :
 * @param [type] $size
 * @return void
 */
function convertToReadableSize($size){
	$base = log($size) / log(1024);
	$suffix = array("", "KB", "MB", "GB", "TB");
	$f_base = floor($base);
	return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
}

/**
 * Undocumented function
 *
 * @param string $title
 * @param string $message
 * @return void
 */
function sendAndroidNotification( $title="Notification", $message=""){

    $deviceIds = Customer::whereNotNull('notification_token')->get()->pluck('notification_token')->toArray();

    $url = 'https://fcm.googleapis.com/fcm/send';

    $apiKey = fireBaseServerKey();

    $fields = array (
        'registration_ids' => $deviceIds,
        'data' => array (
            "message" => $message,
            "title" => $title
        ),
        'notification' => array (
            "message" => $message,
            "title" => $title,
        )
    );

    $headers = array(
        'Content-Type:application/json',
        'Authorization:key='.$apiKey
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);

    if ($result === FALSE) {
        die('FCM Send Error: ' . curl_error($ch));
    }
    curl_close($ch);
    return $result;
}

/**
 * Undocumented function
 *
 * @param string $title
 * @param string $message
 * @return void
 */
function sendIOSNotification( $title="Notification", $body="" )
{
    $url = 'https://fcm.googleapis.com/fcm/send';
    $serverKey = fireBaseServerKey();
    $headers = array();
    $headers[] = 'Content-Type: application/json';
    $headers[] = 'Authorization: key='. $serverKey;
    $notification = array('title' =>$title , 'text' => $body, 'sound' => 'default', 'badge' => '1');

    $deviceIds = Customer::whereNotNull('notification_token')->get()->pluck('notification_token')->toArray();
    if( COUNT( $deviceIds ) > 0 )
    {
        foreach( $deviceIds as $token )
        {
            $arrayToSend = array('to' => $token, 'notification' => $notification,'priority'=>'high');
            $json = json_encode($arrayToSend);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
            //Send the request
            $response = curl_exec($ch);
            //Close request
            // if ($response === FALSE) {
            //     die('FCM Send Error: ' . curl_error($ch));
            // }
            curl_close($ch);
        }
    }
}

/**
 * get Religions
 */
function getReligions(){

    $response = [
        'success' => true,
        'data'    => Religion::where( [ 'status' => 1] )->orderBy( 'name', 'ASC' )->get()->toArray(),
        'message' => "Retrive Religion successfully",
    ];

    return response()->json($response, 200);
}

/**
 * get country dropdown by continent id
 */
function getContinents(){

    $response = [
        'success' => true,
        'data'    => Continent::where( [ 'status' => 1] )->orderBy( 'name', 'ASC' )->get()->toArray(),
        'message' => "Retrive Continent successfully",
    ];

    return response()->json($response, 200);
}

/**
 * get country by continent id
 */
function getCountryByContinentID( $continent_id = null ){

    if( $continent_id ){
        $continentObj = Continent::select('name')->find( $continent_id );
        $response = [
            'success' => true,
            'data'    => Country::where( [ 'continent_id' => $continent_id, 'status' => 1] )->orderBy( 'name', 'ASC' )->get()->toArray(),
            'message' => "Retrive ".$continentObj->name." successfully",
        ];
    } else {
        $response = [
            'success' => true,
            'data'    => Country::orderBy( 'name', 'ASC' )->get()->toArray(),
            'message' => "Retrive all data successfully",
        ];
    }

    return response()->json($response, 200);
}

/**
 * get state by country id
 */
function getStateByCountryID( $country_id = null ){

    if( $country_id ){
        $countryObj = Country::select('name')->find( $country_id );
        $response = [
            'success' => true,
            'data'    => State::where( [ 'country_id' => $country_id, 'status' => 1] )->orderBy( 'name', 'ASC' )->get()->toArray(),
            'message' => "Retrive ".$countryObj->name." successfully",
        ];
    } else {
        $response = [
            'success' => true,
            'data'    => State::orderBy( 'name', 'ASC' )->get()->toArray(),
            'message' => "Retrive all data successfully",
        ];
    }

    return response()->json($response, 200);
}

/**
 * get state by country id
 */
function getCityByStateByID( $state_id = null ){

    if( $state_id ){
        $stateObj = State::select('name')->find( $state_id );
        $response = [
            'success' => true,
            'data'    => City::where( [ 'state_id' => $state_id, 'status' => 1] )->orderBy( 'name', 'ASC' )->get()->toArray(),
            'message' => "Retrive ".$stateObj->name." successfully",
        ];
    } else {
        $response = [
            'success' => true,
            'data'    => City::orderBy( 'name', 'ASC' )->get()->toArray(),
            'message' => "Retrive all data successfully",
        ];
    }

    return response()->json($response, 200);
}

/**
 * get state by country id
 */
function getSocialMediaPlatform(){

    $response = [
        'success' => true,
        'data'    => SocialMediaPlatform::where( ['status' => 1] )->orderBy( 'name', 'ASC' )->get()->toArray(),
        'message' => "Retrive Social Medias successfully",
    ];

    return response()->json($response, 200);
}

/**
 *
 */
function getTimeDifference( $startTime=null)
{
    // Get the current time
    $currentTime = Carbon::now();

    if( !$startTime ){ // Get the time for 12:00 AM today
        $startTime = Carbon::today();
    }

    // Calculate the difference
    $timeDifference = $currentTime->diff( $startTime );

    // Output the difference in hours, minutes, and seconds
    return $timeDifference->format('%H Hr %I Min %S Sec');
}

/**
 *
 */
function convertCarbonDateFormat( $datetimeString ){
    try{
        return Carbon::createFromFormat('d/m/Y H:i', $datetimeString);
    }catch( Exception $e ){
        log::info( $datetimeString." ".$e->getMessage() );
    }
}

/**
 *
 */
function convertCarbonTimeFormat( $datetimeString ){
    return Carbon::createFromFormat('H:i', $datetimeString);
}

/**
 * get logos
 */
function getLogos(){

    $response = [
        'success' => true,
        'data'    => [
            'back_white' => url( 'public/img/devotion-trusted-real-estate.png' ),
            'back_transparent' => url( 'public/img/devotion-trusted-real-estate.png' ),
            'splash' => url( 'public/img/devotion-group-favicon.png' ),
            'favicon' => url( 'public/img/devotion-group-favicon-64X64.png' ),
        ],
        'message' => "Retrive logo successfully",
    ];

    return response()->json($response, 200);
}

/**
 * If you're using CKEditor to input rich text (HTML), and you want to save that content as a .doc (Microsoft Word) file in Laravel,
 * here's how you can do it properly:
 */
function saveCkeditorContentAsDoc( $title, $htmlContent, $folderName='board-meeting-docs' )
{
    // Create a safe filename
    $safeTitle = Str::slug($title);
    $filename = $safeTitle . '.doc';
    $path = $folderName.'/' . $filename;

    // Wrap the HTML content in a basic Word-compatible HTML structure
    $docContent = '
        <html xmlns:o="urn:schemas-microsoft-com:office:office"
              xmlns:w="urn:schemas-microsoft-com:office:word"
              xmlns="http://www.w3.org/TR/REC-html40">
        <head><meta charset="utf-8"></head>
        <body>' . $htmlContent . '</body>
        </html>';

    // Save to storage (e.g., storage/app/docs/)
    Storage::put($path, $docContent);

    return 'app/' . $path;
}
