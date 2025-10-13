<?php
/*
* @Function:        <pr>
* @Author:          Gautam Kakadiya
* @Created On:      <07-03-2019>
* @Last Modified By:
* @Last Modified:
* @Description:     <This methode print data in array formate>
*/

use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Date;

/*---------------------------------------------
   get secon parameter if you want to die code
 ----------------------------------------------*/
function pr($data , $die = false)
{
    echo "<pre>";
    print_r($data);
}

/*
* @Function:        <unsetData>
* @Author:          Gautam Kakadiya
* @Created On:      <07-03-2019>
* @Last Modified By:
* @Last Modified:
* @Description:     <This methode unsetdata from 'From' request>
*/
function unsetData($dataArray = array(), $unsetDataArray = array())
{
    return array_diff_key($dataArray, array_flip($unsetDataArray));
}

/*
* @Function:        <generateCSV>
* @Author:          Gautam Kakadiya
* @Created On:      <13-03-2019>
* @Last Modified By: Gautam Kakadiya
* @Last Modified:   <13-03-2019>
* @Description:     <For Ganerate CSV>
* @Returns:         <   >
*/
function generateCSV($header, $data, $fileName)
{
    ob_start();
    $fp = fopen('php://output', 'w');
    fprintf($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));

    header('Content-type: application/xlsx');
    header('Content-Disposition: attachment; filename=' . $fileName);

    fputcsv($fp, $header);

    foreach ($data as $singleRecord) {
        fputcsv($fp, $singleRecord);
    }

    fclose($fp);
    ob_flush();
}

/**
 * Getting cookies data set by javascript.
 * @param $name
 * @return mixed|string
 */
function getCookie($name)
{
    if (isset($_COOKIE[$name]))
        return $_COOKIE[$name];

    return '';
}

/**
 * delete cookie
 * @param $name
 * @param $path
 */
function unsetCookie($name, $path)
{
    setcookie($name, '', 1, $path);
}

/**
 * @Function:        <formatDate>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <17-10-2021>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function is Converting database format date to convienant form >
 * @params :
 * @date : Date which you get from database.
 * @format : Format you want to retrieve.
 * @return :
 *		- Formatted date.
 */
function formatDate($format = '',$date = '', $isProperFormat=false)
{
    if( $isProperFormat )
    {
        $dateArr = explode("/", $date);

        if( isset( $dateArr[1] ) ){
            if( strlen( $dateArr[0] ) == 4 )
                return $date;
            else
                return Carbon::createFromFormat( 'd/m/Y', $date )->format( 'Y-m-d' );
        }
        else
            return $date;
    }
	else if($format)
		return date($format,strtotime($date));
	else
		return date('Y-m-d H:i:s');
}

/**
 * @Function:        <formatTime>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <28-10-2021>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function is Converting database format time to convienant form >
 * @params :
 * @date : Date which you get from database.
 * @format : Format you want to retrieve.
 * @return :
 *		- Formatted date.
 */
function formatTime($format = '',$time = '', $isProperFormat=false)
{
    if( $isProperFormat )
    {
        $timeArr = explode(":", $time);
        if( $timeArr[2] == "00" )
            return $time;
        else {
            return date('h:i A', strtotime($time));// DateTime::createFromFormat( 'h:i A', str_ireplace( " ", "", $time ) )->format( 'H:i:s' );
        }
    }
    else if($format)
        return date($format,strtotime($time));
    else
        return date('H:i:s');
}

/**
 * @Function:        <generateRandomString>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <28-10-2021>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function is Converting random string format to convienant form >
 * @params :
 * @date : Date which you get from database.
 * @format : Format you want to retrieve.
 * @return :
 *		- Formatted date.
 */
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/**
 * @Function:        <strip_quotes>
 * @Author:          Gautam Kakadiya( ShreeGurave Dev Team )
 * @Created On:      <28-10-2021>
 * @Last Modified By:Gautam Kakadiya
 * @Last Modified:   Gautam Kakadiya
 * @Description:     <This function is strip leading/trailing single or double quotes from a string, including guillemets! >
 * @params :
 * @date : Date which you get from database.
 * @format : Format you want to retrieve.
 * @return :
 *		- Formatted date.
 */
function strip_quotes($data)
{
    if( is_array($data) ) {
        foreach($data as $k => $v) {
            $data[$k] = strip_quotes($data[$k]);
        }
       return $data;
    } else{
        return stripslashes($data);
    }
}

/**
 * Create URL Title
 *
 * Takes a "title" string as input and creates a
 * human-friendly URL string with a "separator" string
 * as the word separator.
 *
 * @access	public
 * @param	string	the string
 * @param	string	the separator
 * @return	string
 */
if ( ! function_exists('url_title'))
{
	function url_title($str, $separator = '-', $lowercase = FALSE )
	{
		if ($separator == 'dash')
		{
			$separator = '-';
		}
		else if ($separator == 'underscore')
		{
			$separator = '_';
		}

		$q_separator = preg_quote($separator);

		$trans = array(
				'&.+?;'                 => '',
				'[^a-z0-9 _-]'          => '',
				'\s+'                   => $separator,
				'('.$q_separator.')+'   => $separator
		);

		$str = strip_tags($str);

		foreach ($trans as $key => $val)
		{
			$str = preg_replace("#".$key."#i", $val, $str);
		}

		if ($lowercase === TRUE)
		{
			$str = strtolower($str);
		}

		return trim($str, $separator);
	}
}

/**
 * Convert decimal time into time in the format hh:mm:ss
 *
 * @param integer The time as a decimal value.
 *
 * @return string $time The converted time value.
 */
function decimal_to_time($decimal) {
    $hours = floor($decimal / 60);
    $minutes = floor($decimal % 60);
    $seconds = $decimal - (int)$decimal;
    $seconds = round($seconds * 60);

    return str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" . str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":" . str_pad($seconds, 2, "0", STR_PAD_LEFT);
}

/**
 * Properly Format a Number With Leading Zeros in PHP
 */
function leadingPrefix( $number, $length=7 ){
    return substr(str_repeat(0, $length).$number, - $length);
}
