<?php
class My_model extends CI_Model{
	
 	function my_model(){
  		//parent::CI_model();
			
 	}
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET ITEMS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 public function get_items($type = '', $main_id = 0,$sub_id = 0 ){

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('namibian_news_'.$type))
        {
			
			if($type == 'product'){
				
				$this->load->model('product_model');
				$data = $this->product_model->get_product_parameters();
				
				if($main_id != 0){
					
					$data['main_cat_id'] = $main_id;
				}
				$output = $this->product_model->get_products($query = '', $data['main_cat_id'] , $data['sub_cat_id'] , $data['sub_sub_cat_id'], $data['sub_sub_sub_cat_id'] , $data['offset'] , $title = '', $amt = '', $data['limit'] ,$data['q'], $data['location_id'], $data['suburb_id']);
				
			}elseif($type == 'news'){
				
				$this->load->model('news_model');
				
				$output = $this->news_model->get_nmh_news();
				
			}
			
				
			///$this->cache->save('namibian_news_'.$type, $output, 3600);
			
           
			
		}
		 echo $output;
	
	}
	 
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET TIME PAST
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function time_passed($timestamp)
	{
		//type cast, current time, difference in timestamps
		$timestamp = (int) $timestamp;
		$current_time = time();
		$diff = $current_time - $timestamp;

		//intervals in seconds
		$intervals = array(
			'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute' => 60
		);

		//now we just find the difference
		if ($diff == 0)
		{
			return 'just now';
		}

		if ($diff < 60)
		{
			return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
		}

		if ($diff >= 60 && $diff < $intervals['hour'])
		{
			$diff = floor($diff / $intervals['minute']);

			return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
		}

		if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
		{
			$diff = floor($diff / $intervals['hour']);

			return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
		}

		if ($diff >= $intervals['day'] && $diff < $intervals['week'])
		{
			$diff = floor($diff / $intervals['day']);

			return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
		}

		if ($diff >= $intervals['week'] && $diff < $intervals['month'])
		{
			$diff = floor($diff / $intervals['week']);

			return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
		}

		if ($diff >= $intervals['month'] && $diff < $intervals['year'])
		{
			$diff = floor($diff / $intervals['month']);

			return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
		}

		if ($diff >= $intervals['year'])
		{
			$diff = floor($diff / $intervals['year']);

			return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
		}
	}
	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
	
}
?>