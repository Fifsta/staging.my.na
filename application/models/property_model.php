<?php
class Property_model extends CI_Model{
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function property_model(){
  		//parent::CI_model();
		self::__construct();	
 	}


	//+++++++++++++++++++++++++++
	//GET Property for Home Page
	//++++++++++++++++++++++++++
	public function get_random_properties(){
		
		$db2 = $this->connect_property_db();
		$query = $db2->query("SELECT u_property_residential.ID , u_property_residential.DESCRIPTION, u_property_residential.SALE_PRICE, u_property_residential.RENT_PRICE, u_property_residential.BEDROOMS,
						u_property_residential.BATHROOMS, u_property_residential.GARAGE, u_property_residential.IS_SOLE_MANDATE, 
						u_property_image.IMAGE_FILE_NAME  
						FROM u_property_residential JOIN u_property_image ON u_property_residential.ID = u_property_image.PROPERTY_ID
						WHERE IS_ACTIVE = 'Y' ORDER BY RAND() LIMIT 3 ", FALSE);
		
		if($query->result()){
			
			echo '<div id="property_slider" class="">';
			
			
			$x = 0;
			foreach($query->result() as $row){
				
				$description = $this->shorten_string(strip_tags($row->DESCRIPTION), 50);
				if($row->SALE_PRICE == 0){
					
					$price = $this->smooth_price(substr($row->RENT_PRICE, 0,  strpos($row->RENT_PRICE, '.'))) .'<font style="font-size:12px"> p.m</font>';
					
				}else{
					
					$price = $this->smooth_price(substr($row->SALE_PRICE, 0,  strpos($row->SALE_PRICE, '.')));
					
				}
				
				if($row->IMAGE_FILE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = base_url('/').'img/timbthumb.php?w=140&h=120&src=http://property.my.na/uploads/images/property/listing/residential/fullsize/'.$row->IMAGE_FILE_NAME;
					
				}
				
				$fb = "postToFeed(".$row->ID.", '". substr($description,0,50) ."', '".$row->IMAGE_FILE_NAME."', '".substr($description,0,50) ." - My Namibia','".$description."', '".$this->clean_url_str(substr($description,0,50))."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
				
					
			   $btn = '<a id="prop_btn'.$row->ID.'"  class="btn btn-large pull-right btn-warning">
						<i class="icon-star-empty icon-white"></i> View
						</a>';
				
					
			
				$active = '';
				if($x == 0){
					$active = 'active';	
				}
				$tweet_url = 'http://my.na/deal/'.$this->clean_url_str(substr($description,0,50)).'&text='.substr($description,0,50).'&via=MyNamibia';
				

				echo '<div class="media white_box">
						  <a class="pull-left" href="#">
							<img class="img-polaroid" style="width:140px; max-height:120px" alt="'.substr($description,0,20).'" src="'.$img.'" />
						  </a>
						  <div class="media-body">
							<h4 class="media-heading">'.substr($description,0,20).'</h4>
							<div style="height:70px; ">'.substr($description,0,75).'</div>
							<div class="clearfix"></div>
							<div class="clearfix" style="float:right;margin-left:5px">
								
								<a class="btn btn-inverse" target="_blank" href="http://property.my.na/detail.php?tId=1&pId='.$row->ID.'" > View</a>		
							</div>
							<h3 style="font-size:20px;line-height:15px;height:15px;color:#FF9F01;"><font style=" font-size:12px">N$</font>'.$price.'</h3>
						  </div>
						  
					  </div>';
				
				$x ++;
			}
			
			echo '
				</div>';
		}
		
		
	}

    //Shorten Price
	function smooth_price($price) {
		
		
   		if(strlen($price) > 8){
			
		   //$price = number_format($price, 2, ',', ' ');
			$price1 = substr(number_format($price), 0 ,5). ' million';
		
		}elseif(strlen($price) > 7){
			
			$price1 = substr(number_format($price), 0 ,4). ' million';
		
		}elseif(strlen($price) > 6){	
			
			$price1 = substr(number_format($price), 0 ,3). ' million';
		
		}elseif(strlen($price) > 5){
		
		  $price1 = substr(number_format($price), 0 ,3);
		
		}elseif(strlen($price) > 3){
			
			 $price1 = number_format($price);
			
		}else{
			
			 $price1 = number_format($price);	
		}
		return $price1;
	}
	

	
	//connect to tourism db
	function connect_property_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'mypr0pna_mynaprp';
		$config_db['password'] = '8UR3pD8Cnz1f3';
		$config_db['database'] = 'mypr0pna_property';
		
		//$config_db['username'] = 'root';
	    //$config_db['password'] = '';
		//$config_db['database'] = 'my_na';
		
		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
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