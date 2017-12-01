<?php defined('BASEPATH') OR exit('No direct script access allowed');


#namespace JeroenDesloovere\Geolocation;

/**
 * Geolocation GEO IP
 *
 * 
 *
 * https://github.com/maxmind/GeoIP2-php
 */
		//include_once APPPATH.'/third_party/mpdf60/mpdf.php';
		require( BASE_URL . '/vendor/autoload.php');
		use GeoIp2\Database\Reader;
class GeoIP
{

    function geoip()
    {
       
	    $CI = & get_instance();
        log_message('Debug', 'mPDF class is loaded.');
		

    }
 
    function load($param=NULL)
    {
         

		 $reader = new Reader(BASE_URL."geoip/GeoLiteCity.dat");
   		 
		// This creates the Reader object, which should be reused across
		// lookups.
		
        $record = $reader->city('128.101.101.101');

		print($record->country->isoCode . "\n"); // 'US'
		print($record->country->name . "\n"); // 'United States'
		print($record->country->names['zh-CN'] . "\n"); // '美国'
		
		print($record->mostSpecificSubdivision->name . "\n"); // 'Minnesota'
		print($record->mostSpecificSubdivision->isoCode . "\n"); // 'MN'
		
		print($record->city->name . "\n"); // 'Minneapolis'
		
		print($record->postal->code . "\n"); // '55455'
		
		print($record->location->latitude . "\n"); // 44.9733
		print($record->location->longitude . "\n"); // -93.2323
        return $reader;
    }
    
}

