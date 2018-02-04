<?php
class Weather_model extends CI_Model{
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function weather_model(){
  		//parent::CI_model();
		self::__construct();	
 	}



    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET WEATHER REPORT
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_weather($location, $c_code, $time = ''){

        if(trim($location) == ''){

            $location = 'Windhoek';
            $c_code = 'NA';
        }

        $url = 'http://api.openweathermap.org/data/2.5/weather?units=metric&q='.$location.','.$c_code.'&appid=647d4f786c37bda6702048da56ded170';

        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('weather_'.str_replace(",","_",$location.','.$c_code)))
        {
            $output = file_get_contents($url);
			$this->cache->save('weather_'.str_replace(",","_",$location.','.$c_code), $output, 3600);
        }
        //echo $output;
		
		$array = json_decode($output);
		//return $array;
		//echo $array->main->temp. ' ' .$array->weather[0]->description;

		if($time == ''){
            $now = date('G');

        }else{

            $now = $time;

        }
		//Check Namibian Time

		if ($now < 7 || $now > 19) {
			$time = 'night';
			$timeT = 'Clear night skies are common';
		} else {
			$time = 'day';
			$timeT = 'The sun just keeps shining';
		}
		$output = '<p><span title="'. $timeT.' - '.$array->weather[0]->main.' ' .$location.'">'.$this->get_condition_icon($array->weather[0]->main, $time).'</span>
					<span class="med_icon pull-right">'.round($array->main->temp).'<i class="wi wi-celsius"></i></span>
					<strong>'.$location.'</strong> <br/><small> '.
					  $array->weather[0]->description
					.'&nbsp;&nbsp;</small><br/><small>High</small> '.round($array->main->temp_max).'<i class="wi wi-celsius"></i> <small>Low</small> '.round($array->main->temp_min).'<i class="wi wi-celsius"></i> </p>';
		
		return $output;



    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET WEATHER REPORT
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_condition_icon($c, $time = 'day'){

        switch ($c) {
            case 'Sky is Clear':
                if($time == 'day'){
                    $i = '<i class="wi wi-'.$time.'-sunny big_icon pull-right"></i>';
                }else{
                    $i = '<i class="wi med_icon wi-stars pull-right"></i><i class="wi wi-'.$time.'-clear big_icon pull-right"></i>';
                }
                break;
            case 'Clear':
                if($time == 'day'){
                    $i = '<i class="wi wi-'.$time.'-sunny big_icon pull-right"></i>';
                }else{
                    $i = '<i class="wi med_icon wi-stars pull-right"></i><i class="wi wi-'.$time.'-clear big_icon pull-right"></i>';
                }
                break;
            case 'Clouds':

                if($time == 'day'){
                    $i = '<i class="wi wi-'.$time.'-sunny-overcast big_icon pull-right"></i>';
                }else{
                    $i = '<i class="wi med_icon wi-stars pull-right"></i><i class="wi wi-'.$time.'-cloudy big_icon pull-right"></i>';
                }
                break;
            case 'Scattered Clouds':

                $i = '<i class="wi wi-'.$time.'-cloudy big_icon pull-right"></i>';
                break;
            case 'Broken Clouds':
                $i = '<i class="wi wi-'.$time.'-cloudy-windy big_icon pull-right"></i>';
                break;
            case 'Shower Rain':
                $i = '<i class="wi wi-'.$time.'-rain-mix big_icon pull-right"></i>';
                break;
            case 'Rain':
                $i = '<i class="wi wi-'.$time.'-rain big_icon pull-right"></i>';
                break;
            case 'Thunderstorm':
                $i = '<i class="wi wi-'.$time.'-thunderstorm big_icon pull-right"></i>';
                break;
            case 'Snow':
                $i = '<i class="wi wi-'.$time.'-snow big_icon pull-right"></i>';
                break;
            case 'Mist':
                $i = '<i class="wi wi-'.$time.'-fog big_icon pull-right"></i>';
                break;

            default:
                $i = '<i class="wi wi-day-sunny"></i>';
        }

        return $i;
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //CACHE FEED FILE
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    function cacheObject($url,$name,$age = 86400)
    {
        // directory in which to store cached files
        $cacheDir = BASE_URL."application/cache/weather/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
            $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {

            if ( copy($url, $filename) ) {
                // update timestamp to now
                touch($filename);
            }else{
                echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
            }

        }
        // return the cache filename
        return $filename;
    }

}
?>