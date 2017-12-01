<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_index extends CI_Controller {

	/**
	 * Search index Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function __construct()
	{
		parent::__construct();
		
	}
	
	
	public function index()
	{
		
	}

	public function build_index()
	{

		ini_set('memory_limit','512M');
		set_time_limit(7200);
		//CLEAN INDEX
		/*$this->db->empty_table('search_index'); 
		$this->build_business();
		echo 'Business Index Updated<br />';
		$this->build_products();
		echo 'Products Index Updated<br />';
		$this->build_product_categories();
		echo 'Product Category Index Updated<br />';
		$this->build_product_locations();
		echo 'Product Locations Index Updated<br />';
		$this->build_business_categories();
		echo 'Business Categories and Locations built<br />';
		$this->build_deals();
		echo 'Deals built<br />';
		$this->build_classifieds();
		echo 'Classifieds built<br />';
		$this->build_careers();
		echo 'Careers built<br />';*/
		$this->load->dbutil();
		if ($this->dbutil->optimize_table('search_index'))
		{
			echo 'Database Optimization Success!';
		}
			
	}

	public function optimize_index()
	{

		ini_set('memory_limit','512M');
		set_time_limit(7200);
		$this->load->dbutil();
		if ($this->dbutil->optimize_table('search_index'))
		{
			echo 'Database Optimization Success!';
		}
			
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN CLASSIFIEDS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_classifieds()
	{
		
		//EMPTY TABLE
		$this->db->where('type' , 'classified');
		$this->db->delete('search_index');
		
		
		$class = $this->db->query("SELECT classifieds.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			cat.cat_name ,a_map_location.MAP_LOCATION as location,a_map_location.ID as location_id
		 			FROM classifieds 
		 			LEFT JOIN u_business ON u_business.ID = classifieds.bus_id
					LEFT JOIN classifieds_categories as cat ON cat.cl_cat_id = classifieds.cl_cat_id
					LEFT JOIN a_map_location ON a_map_location.ID = classifieds.location_id
					LEFT JOIN classifieds_publication_int as pub ON pub.classified_id = classifieds.classified_id
		 			WHERE status = 'live' AND classifieds.listing_date > DATE_SUB(NOW(), INTERVAL 6 MONTH)
					ORDER BY classifieds.listing_date DESC
					");
		
		if($class->result()){
			$insertA = array();
			foreach($class->result() as $row){
				
				//BUILD INPUT
				$city = '';$suburb = '';
				if($row->location != null){
					$city = $row->location;
				}
				
				$title =  html_entity_decode($row->title);
				$body = trim(str_replace(","," ",$row->cat_name).' '.html_entity_decode(strip_tags(trim($title. ' '.str_replace($title, ' ',$row->content. ' '.$city. ' '.$row->adbooking_id)))));
				$insert['title'] = $title;
				$insert['body'] =  preg_replace('/\s+/', ' ', $body);
				$insert['type'] = 'classified';
				$insert['type_id'] = $row->classified_id;
				$insert['link'] = 'classifieds/view/'.$row->classified_id.'/'.$this->clean_url_str($title).'/';
				$insert['img_file'] = 'img/bus_blank.jpg';
				if($row->LOGO != ''){
					if(strpos($row->LOGO, '.')){
						$insert['img_file'] = 'assets/business/photos/'.$row->LOGO;
					}else{
						$insert['img_file'] = 'assets/business/photos/'.$row->LOGO.'.jpg';
					}
				}
				
				array_push($insertA, $insert);
				
				//UPDATE OR ADD
/*				$this->db->where('type_id', $row->classified_id);
				$this->db->where('type', 'classified');
				$existing = $this->db->get('search_index');
				
				if($existing->result()){
					
					$this->db->where('type_id', $row->classified_id);
					$this->db->where('type', 'classified');
					$this->db->update('search_index', $insert);
					
				}else{
					$this->db->insert('search_index', $insert);
					
				}*/
				
				
				
			}
			
			//insert batch
			//var_dump($insertA);
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}
		
		
	}
	

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN CLASSIFIEDS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_careers()
	{
		//EMPTY TABLE
		$this->db->where('type' , 'vacancy');
		$this->db->delete('search_index');
		
		$career = $this->db->query("SELECT vacancies.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			maincat.category_name as main_cat, subcat.category_name as sub_cat,subsubcat.category_name as sub_sub_cat,subsubsubcat.category_name as sub_sub_sub_cat
		 			FROM vacancies 
		 			LEFT JOIN u_business ON u_business.ID = vacancies.bus_id
					LEFT JOIN product_categories as maincat ON maincat.cat_id = vacancies.main_cat_id
					LEFT JOIN product_categories as subcat ON subcat.cat_id = vacancies.sub_cat_id
					LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = vacancies.sub_sub_cat_id
					LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = vacancies.sub_sub_sub_cat_id
		 			WHERE status = 'live' AND type != 'internal' AND start_date < NOW() AND end_date >= NOW()
					
					");
		
		if($career->result()){
			$insertA = array();
			foreach($career->result() as $row){
				
				//BUILD INPUT
				/*$city = '';$suburb = '';
				if($row->location != null){
					$city = $row->location;
				}*/
				$cat = $row->main_cat. ' '.$row->sub_cat. ' '.$row->sub_sub_cat. ' '.$row->sub_sub_cat;
				$title =  html_entity_decode($row->title);
				$body = trim(str_replace(","," ",$cat).' '.html_entity_decode(strip_tags(trim($title. ' '.str_replace($title, ' ',$row->body. ' ')))));
				$insert['title'] = $title;
				$insert['body'] =  preg_replace('/\s+/', ' ', $body);
				$insert['type'] = 'vacancy';
				$insert['type_id'] = $row->vacancy_id;
				$insert['link'] = 'careers/job/'.$row->vacancy_id.'/'.$this->clean_url_str($title).'/';
				$insert['img_file'] = 'img/bus_blank.jpg';
				if($row->LOGO != ''){
					if(strpos($row->LOGO, '.')){
						$insert['img_file'] = 'assets/business/photos/'.$row->LOGO;
					}else{
						$insert['img_file'] = 'assets/business/photos/'.$row->LOGO.'.jpg';
					}
				}
				
				array_push($insertA, $insert);
				//UPDATE OR ADD
				/*$this->db->where('type_id', $row->vacancy_id);
				$this->db->where('type', 'vacancy');
				$existing = $this->db->get('search_index');
				
				if($existing->result()){
					
					$this->db->where('type_id', $row->vacancy_id);
					$this->db->where('type', 'vacancy');
					$this->db->update('search_index', $insert);
					
				}else{
					$this->db->insert('search_index', $insert);
					
				}*/
				
				
				
			}
			
			//insert batch
			//var_dump($insertA);
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}

			
		}
		
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_business()
	{

		//EMPTY TABLE
		$this->db->where('type' , 'business');
		$this->db->delete('search_index');
		
		$business = $this->db->query("SELECT u_business.*, group_concat(a_tourism_category_sub.CATEGORY_NAME) as cats, a_map_location.MAP_LOCATION, a_map_suburb.SUBURB_NAME
										FROM u_business
										LEFT JOIN i_tourism_category ON i_tourism_category.BUSINESS_ID = u_business.ID
										LEFT JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
										LEFT JOIN a_map_suburb ON a_map_suburb.ID = u_business.BUSINESS_SUBURB_ID
										WHERE u_business.ISACTIVE = 'Y'
										GROUP BY i_tourism_category.BUSINESS_ID
									");
		
		if($business->result()){
			$insertA = array();
			foreach($business->result() as $row){
				
				//BUILD INPUT
				$city = '';$suburb = '';
				if($row->MAP_LOCATION != null){
					$city = $row->MAP_LOCATION;
				}
				if($row->SUBURB_NAME != null){
					$suburb = $row->SUBURB_NAME;
				}
				$title =  html_entity_decode($row->BUSINESS_NAME);
				$body = trim(str_replace(","," ",$row->cats).' '.html_entity_decode(strip_tags(trim($title. ' '.str_replace($title, ' ',$row->BUSINESS_DESCRIPTION. ' '.$suburb.' '.$city)))));
				$insert['title'] = $title;
				$insert['body'] =  preg_replace('/\s+/', ' ', $body);
				$insert['type'] = 'business';
				$insert['type_id'] = $row->ID;
				$insert['link'] = 'b/'.$row->ID.'/'.$this->clean_url_str($title).'/';
				$insert['img_file'] = 'img/bus_blank.jpg';
				if($row->BUSINESS_LOGO_IMAGE_NAME != ''){
					if(strpos($row->BUSINESS_LOGO_IMAGE_NAME, '.')){
						$insert['img_file'] = 'assets/business/photos/'.$row->BUSINESS_LOGO_IMAGE_NAME;
					}else{
						$insert['img_file'] = 'assets/business/photos/'.$row->BUSINESS_LOGO_IMAGE_NAME.'.jpg';
					}
				}
				
				array_push($insertA, $insert);
				//UPDATE OR ADD
				/*$this->db->where('type_id', $row->ID);
				$this->db->where('type', 'business');
				$existing = $this->db->get('search_index');
				
				if($existing->result()){
					
					$this->db->where('type_id', $row->ID);
					$this->db->where('type', 'business');
					$this->db->update('search_index', $insert);
					
				}else{
					$this->db->insert('search_index', $insert);
					
				}*/
				
				
				
			}
			//insert batch
			//var_dump($insertA);
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
		}
		
			
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN PRODUCTS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function build_products()
	{
		
		
		//EMPTY TABLE
		$this->db->where('type' , 'product');
		$this->db->delete('search_index');
		
		//$this->db->where('is_active', 'Y');
		//$products = $this->db->query('products');
		
		$products = $this->db->query("SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, 
                                          u_business.BUSINESS_NAME, maincat.category_name as main_cat,subcat.category_name as sub_cat,
										  subsubcat.category_name as sub_sub_cat, subsubsubcat.category_name as sub_sub_sub_cat,
										  u_business.BUSINESS_TELEPHONE,product_images.img_file
                                          
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
										  LEFT JOIN product_categories as maincat ON maincat.cat_id = products.main_cat_id
										  LEFT JOIN product_categories as subcat ON subcat.cat_id = products.sub_cat_id
										  LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = products.sub_sub_cat_id
										  LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = products.sub_sub_sub_cat_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_images ON products.product_id = product_images.product_id
										  WHERE products.is_active = 'Y' AND products.end_date > DATE_SUB(NOW(), INTERVAL 5 YEAR)
                                          GROUP BY products.product_id
                                         ");
		
		
		
		$this->load->model('trade_model');
		if($products->result()){
			$insertA = array();
			foreach($products->result() as $row){

				if($row->listing_type == 'S'){
					if($row->sale_price == 0){

						$price = '';
					}else{

						$price = ' N$ '.$this->trade_model->smooth_price($row->sale_price);
					}

					if ($row->status == 'sold')
					{
						$price = ' Sold';
					}
					else
					{
						if ($row->sub_cat_id == 3410)
						{
							$price = ' N$ '.$this->trade_model->smooth_price($row->sale_price). ' p.m';
						}
						else
						{
							$price = ' N$ '.$this->trade_model->smooth_price($row->sale_price);
						}
						if ($row->por == 'Y')
						{

							$price = ' POR';

						}
					}

				}else{

					$price = ' Auction';
				}

				//BUILD INPUT
				$insert['title'] = $this->trade_model->shorten_string(ucwords($row->title), 5).$price;
				$insert['body'] =  '';
				$insert['type'] = 'product';
				$insert['type_id'] = $row->product_id;
				$insert['link'] = 'product/'.$row->product_id.'/'.$this->clean_url_str($row->title).'/';
				$insert['img_file'] = 'img/product_blank.jpg';
				$insert['main_cat_id'] = $row->main_cat_id;
				$insert['sub_cat_id'] = $row->sub_cat_id;
				$insert['sub_sub_cat_id'] = $row->sub_sub_cat_id;
				$insert['sub_sub_sub_cat_id'] = $row->sub_sub_sub_cat_id;
				$insert['location'] = $row->location;
				$insert['suburb'] = $row->suburb;
				//get images
				if($row->img_file != null){

					$insert['img_file'] = 'assets/products/images/'.$row->img_file;
				}
				$location = $row->location;
				if($row->suburb != 0 && $row->suburb != ''){
					$location = $row->suburb. ' ' . $row->location;

				}
				//GET PRODUCT CATEGORIES
				$insert['body'] .= ' '.$row->main_cat . ' ' .$row->sub_cat.' '.$row->sub_sub_cat. ' ' .$row->sub_sub_sub_cat. ' in ' . $location;

				//GET PRODUCT EXTRAS
				$exA = (array)json_decode($row->extras);
				if(count($exA) > 0){
					
					$extrarow = $exA;
					$extra_array = $exA;
					//var_dump($exA);
					//echo 'poes   ';
					if(is_array($extra_array)){
						//echo 'poes   ';
						//LOOP EACH EXTRA
						foreach($extra_array as $row_extra => $value){
							
							if(is_array($value)){
								
									foreach($value as $finalrow => $final_val){

											$insert['body'] .= $final_val.' , ';
											
									}	
								
							}else{

								if($row_extra == 'prop_lat' || $row_extra == 'prop_lon' || $row_extra == 'toggle_map' || $row_extra == 'autohaus' || $row_extra == 'agency' || $row_extra == 'product_id' || $row_extra == 'bus_id')
								{

								}else{

									$insert['body'] .= trim($value). ' ';
								}

								
							}
								
						}
					}
					
					
				}
				echo $insert['body'];
				$insert['body'] .= ' '. $row->description;
				
				array_push($insertA, $insert);
				
				//UPDATE OR ADD
				/*$this->db->where('type_id', $row->product_id);
				$this->db->where('type', 'product');
				$existing = $this->db->get('search_index');
				
				
				if($existing->result()){
					
					$this->db->where('type_id', $row->product_id);
					$this->db->where('type', 'product');
					$this->db->update('search_index', $insert);
					
				}else{
					$this->db->insert('search_index', $insert);
					
				}*/
				echo $insert['title'] . ' ' .$insert['body'].'<br />'.site_url('/').$insert['link'].'<br /><br />';
			}//end foreach product
			
				
			//insert batch
			//var_dump($insertA);
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}
		
			
	}
	
		
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS CATEGORIES TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_business_categories()
	{
		
		
		//EMPTY TABLE
		$this->db->where('type' , 'business_category');
		$this->db->delete('search_index');
		
		//MAIN CATEGORIES
		$main_cats = $this->db->query("SELECT DISTINCT(CATEGORY_ID), COUNT(i_tourism_category.BUSINESS_ID) as count_ ,a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME,
											a_tourism_category_sub.CATEGORY_NAME, i_tourism_category.BUSINESS_ID ,a_tourism_category_sub.CATEGORY_TYPE_ID
											FROM i_tourism_category 
											JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
											JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID

											GROUP BY a_tourism_category_sub.ID ", FALSE);
		
		$this->load->model('search_model');
		if($main_cats->result()){
			$insertA = array();
			foreach($main_cats->result() as $main_row){
				$name  = $main_row->CATEGORY_NAME;
				//BUILD INPUT
				$insert['title'] = $main_row->CATEGORY_NAME . '';
				$insert['body'] =  $main_row->count_. ' results found for: '.$main_row->CATEGORY_NAME ;
				$insert['type'] = 'business_category';
				$insert['type_id'] = $main_row->CATEGORY_ID;
				$insert['link'] = 'a/show/'.$main_row->CATEGORY_TYPE_ID.'/'.$this->search_model->url_encode($main_row->MAIN_CAT_NAME).'/'.$main_row->CATEGORY_ID.'/'.$this->search_model->url_encode($main_row->CATEGORY_NAME).'';
				$insert['img_file'] = 'img/bus_blank.jpg';
				$insert['main_cat_id'] = 0;
				$insert['sub_cat_id'] = 0;
				$insert['sub_sub_cat_id'] = 0;
				$insert['sub_sub_sub_cat_id'] = 0;
				$insert['location'] = '';
				$insert['suburb'] = '';
				
				echo $insert['title']. ' ' .$insert['link'].'<br />';
				//IF NON EXISTS
				if($insert['title'] != '0'){
					
					array_push($insertA, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $main_row->CATEGORY_ID);
					$this->db->where('type', 'business_category');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $main_row->CATEGORY_ID);
						$this->db->where('type', 'business_category');
						$this->db->update('search_index', $insert);
						
					}else{
						$this->db->insert('search_index', $insert);
						
					}*/
				}
			}//end foreach main_cat
	
			//insert batch
			//var_dump($insertA);
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}
		
		//MAIN CATEGORIES
		$location_cats = $this->db->query("SELECT u_business.ID, COUNT(  i_tourism_category.CATEGORY_ID) as count_, a_map_location.MAP_LOCATION ,  a_map_location.ID as MAP_ID , 
											a_tourism_category_sub.CATEGORY_NAME,a_tourism_category_sub.CATEGORY_TYPE_ID,a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME ,a_tourism_category_sub.ID as CAT_ID
											FROM u_business 
											JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
											JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
											JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID  
											JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID 
											GROUP BY i_tourism_category.CATEGORY_ID  
											 ", FALSE);
		
		if($location_cats->result()){

			$this->db->where('type' , 'business_location');
			$this->db->delete('search_index');
			
			$insertB = array();
			//$insert = '';
			foreach($location_cats->result() as $location_row){
				
				//TEST IF BUSINESS EXIST IN LOCATION
				$cities = $this->db->get('a_map_location');
				
				if($location_row->CATEGORY_NAME == null){
					continue;	
				}
				
				$name  = $location_row->CATEGORY_NAME;
				//BUILD INPUT
				$insert['title'] = $location_row->CATEGORY_NAME . ' in ' .$location_row->MAP_LOCATION;
				$insert['body'] =  $location_row->count_. ' results for ' .$location_row->CATEGORY_NAME . ' in ' .$location_row->MAP_LOCATION;
				$insert['type'] = 'business_location';
				$insert['type_id'] = $location_row->ID;
				
				$insert['link'] = 'a/show/'.$location_row->CATEGORY_TYPE_ID.'/'.$this->search_model->url_encode($location_row->MAIN_CAT_NAME).'/'.$location_row->CAT_ID.'/'.$this->search_model->url_encode($location_row->CATEGORY_NAME).'/'.$location_row->MAP_ID.'/'.$this->search_model->url_encode($location_row->MAP_LOCATION).'/';
				$insert['img_file'] = 'img/markers/map_marker.png';
				$insert['main_cat_id'] = 0;
				$insert['sub_cat_id'] = 0;
				$insert['sub_sub_cat_id'] = 0;
				$insert['sub_sub_sub_cat_id'] = 0;
				$insert['location'] = $location_row->MAP_LOCATION;
				$insert['suburb'] = '';
				
				echo $insert['title']. ' ' .$insert['link'].'<br />';
				//IF NON EXISTS
				if($insert['title'] != '0'){
					
					array_push($insertB, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $location_row->ID);
					$this->db->where('type', 'business_location');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $location_row->ID);
						$this->db->where('type', 'business_location');
						$this->db->update('search_index', $insert);
						
					}else{
						$this->db->insert('search_index', $insert);
						
					}*/
				}
				echo $insert['title'] . ' ' .$insert['body'].'<br />'.site_url('/').$insert['link'].'<br /><br />';
			}//end foreach main_cat
			
			if($this->db->insert_batch('search_index', $insertB)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
		}
		
		
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN PRODUCTS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_product_categories()
	{
		
		
		//EMPTY TABLE
		$this->db->where('type' , 'product_category');
		$this->db->delete('search_index');
		
		//MAIN CATEGORIES
		
		$main_cats = $this->db->query("SELECT DISTINCT(products.main_cat_id),products.main_cat_id, products.sub_cat_id,products.sub_sub_cat_id, 
										  products.sub_sub_sub_cat_id, maincat.category_name as main_cat,subcat.category_name as sub_cat,
										  subsubcat.category_name as sub_sub_cat, subsubsubcat.category_name as sub_sub_sub_cat,products.location, products.suburb 
										FROM products
										LEFT JOIN product_categories as maincat ON maincat.cat_id = products.main_cat_id
										LEFT JOIN product_categories as subcat ON subcat.cat_id = products.sub_cat_id
										LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = products.sub_sub_cat_id
										LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = products.sub_sub_sub_cat_id
										GROUP BY products.main_cat_id
										", FALSE);
		
		if($main_cats->result()){
			$insertA = array();
			foreach($main_cats->result() as $main_row){
				
				//BUILD INPUT
				$insert['title'] = $main_row->main_cat;
				$insert['body'] =  $main_row->main_cat;
				$insert['type'] = 'product_category';
				$insert['type_id'] = $main_row->main_cat_id;
				$insert['link'] = 'buy/'.$this->encode_url($main_row->main_cat).'/';
				$insert['img_file'] = 'img/product_blank.jpg';
				$insert['main_cat_id'] = $main_row->main_cat_id;
				$insert['sub_cat_id'] = $main_row->sub_cat_id;
				$insert['sub_sub_cat_id'] = $main_row->sub_sub_cat_id;
				$insert['sub_sub_sub_cat_id'] = $main_row->sub_sub_sub_cat_id;
				$insert['location'] = $main_row->location;
				$insert['suburb'] = $main_row->suburb;
				//IF NON EXISTS
				if($insert['title'] != '0'){
					
					array_push($insertA, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $main_row->main_cat_id);
					$this->db->where('type', 'product_category');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $main_row->main_cat_id);
						$this->db->where('type', 'product_category');
						$this->db->update('search_index', $insert);
						
					}else{
						$this->db->insert('search_index', $insert);
						
					}*/
				}
				echo $insert['title'] . ' ' .$insert['body'].'<br />'.site_url('/').$insert['link'].'<br /><br />';
			}//end foreach main_cat
			
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
		}
		echo '<br /><br />END 1</br ></br >';
		//SUB CATEGORIES
		$sub_cats = $this->db->query("SELECT DISTINCT(products.sub_cat_id),products.main_cat_id, products.sub_cat_id,products.sub_sub_cat_id, 
										  products.sub_sub_sub_cat_id, maincat.category_name as main_cat,subcat.category_name as sub_cat,
										  subsubcat.category_name as sub_sub_cat, subsubsubcat.category_name as sub_sub_sub_cat,products.location, products.suburb 
										FROM products
										LEFT JOIN product_categories as maincat ON maincat.cat_id = products.main_cat_id
										LEFT JOIN product_categories as subcat ON subcat.cat_id = products.sub_cat_id
										LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = products.sub_sub_cat_id
										LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = products.sub_sub_sub_cat_id
										GROUP BY products.sub_cat_id", FALSE);
		
		if($sub_cats->result()){
			$insertB = array();
			foreach($sub_cats->result() as $sub_row){
				
				//BUILD INPUT
				$insert2['title'] = $sub_row->sub_cat . ' '.$sub_row->main_cat;
				$insert2['body'] =  $sub_row->sub_cat . ' '.$sub_row->main_cat;
				$insert2['type'] = 'product_category';
				$insert2['type_id'] = $sub_row->sub_cat_id;
				$insert2['link'] = strtolower('buy/'.$this->encode_url($sub_row->main_cat).'/'.$this->encode_url($sub_row->sub_cat).'/');
				$insert2['img_file'] = 'img/product_blank.jpg';
				$insert2['main_cat_id'] = $sub_row->main_cat_id;
				$insert2['sub_cat_id'] = $sub_row->sub_cat_id;
				$insert2['sub_sub_cat_id'] = $sub_row->sub_sub_cat_id;
				$insert2['sub_sub_sub_cat_id'] = $sub_row->sub_sub_sub_cat_id;
				$insert2['location'] = $sub_row->location;
				$insert2['suburb'] = $sub_row->suburb;
				//IF NON EXISTS
				if($insert2['title'] != '0'){
					
					array_push($insertB, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $sub_row->sub_cat_id);
					$this->db->where('type', 'product_category');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $sub_row->sub_cat_id);
						$this->db->where('type', 'product_category');
						$this->db->update('search_index', $insert2);
						
					}else{
						$this->db->insert('search_index', $insert2);
						
					}*/
				}
				echo $insert2['title'] . ' ' .$insert2['body'].'<br />'.site_url('/').$insert2['link'].'<br /><br />';
			}//end foreach sub_cat
			if($this->db->insert_batch('search_index', $insertB)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}	
		echo '<br /><br />END 2</br ></br >';
		//SUB SUB CATEGORIES
		$sub_sub_cats = $this->db->query("SELECT DISTINCT(products.sub_sub_cat_id),products.main_cat_id, products.sub_cat_id,products.sub_sub_cat_id, 
										  products.sub_sub_sub_cat_id, maincat.category_name as main_cat,subcat.category_name as sub_cat,
										  subsubcat.category_name as sub_sub_cat, subsubsubcat.category_name as sub_sub_sub_cat,products.location, products.suburb 
										FROM products
										LEFT JOIN product_categories as maincat ON maincat.cat_id = products.main_cat_id
										LEFT JOIN product_categories as subcat ON subcat.cat_id = products.sub_cat_id
										LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = products.sub_sub_cat_id
										LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = products.sub_sub_sub_cat_id
										GROUP BY products.sub_sub_cat_id", FALSE);
		
		if($sub_sub_cats->result()){
			$insertC = array();
			foreach($sub_sub_cats->result() as $sub_sub_row){
				
				//BUILD INPUT
				$insert3['title'] = $sub_sub_row->sub_sub_cat . ' '.$sub_sub_row->main_cat;
				$insert3['body'] =  $sub_sub_row->main_cat. ' '.$sub_sub_row->sub_cat. ' '.$sub_sub_row->sub_sub_cat;
				$insert3['type'] = 'product_category';
				$insert3['type_id'] = $sub_sub_row->sub_sub_cat_id;
				$insert3['link'] = strtolower('buy/'.$this->encode_url($sub_sub_row->main_cat).'/'.$this->encode_url($sub_sub_row->sub_cat).'/'.$this->encode_url($sub_sub_row->sub_sub_cat).'/');
				$insert3['img_file'] = 'img/product_blank.jpg';
				$insert3['main_cat_id'] = $sub_sub_row->main_cat_id;
				$insert3['sub_cat_id'] = $sub_sub_row->sub_cat_id;
				$insert3['sub_sub_cat_id'] = $sub_sub_row->sub_sub_cat_id;
				$insert3['sub_sub_sub_cat_id'] = $sub_sub_row->sub_sub_sub_cat_id;
				$insert3['location'] = $sub_sub_row->location;
				$insert3['suburb'] = $sub_sub_row->suburb;
				//IF NON EXISTS
				if($insert3['title'] != '0'){
					array_push($insertC, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $sub_sub_row->sub_sub_cat_id);
					$this->db->where('type', 'product_category');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $sub_sub_row->sub_sub_cat_id);
						$this->db->where('type', 'product_category');
						$this->db->update('search_index', $insert3);
						
					}else{
						$this->db->insert('search_index', $insert3);
						
					}*/
					echo $insert3['title'] . ' ' .$insert3['body'].'<br />'.site_url('/').$insert3['link'].'<br /><br />';
				}
				
			}//end foreach sub_sub_cat
			if($this->db->insert_batch('search_index', $insertC)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}
		echo '<br /><br />END 3</br ></br >';
		//SUB SUB SUB CATEGORIES
		$sub_sub_sub_cats = $this->db->query("SELECT DISTINCT(products.sub_sub_sub_cat_id),products.main_cat_id, products.sub_cat_id,products.sub_sub_cat_id, 
										  products.sub_sub_sub_cat_id, maincat.category_name as main_cat,subcat.category_name as sub_cat,
										  subsubcat.category_name as sub_sub_cat, subsubsubcat.category_name as sub_sub_sub_cat,products.location, products.suburb 
										FROM products
										LEFT JOIN product_categories as maincat ON maincat.cat_id = products.main_cat_id
										LEFT JOIN product_categories as subcat ON subcat.cat_id = products.sub_cat_id
										LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = products.sub_sub_cat_id
										LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = products.sub_sub_sub_cat_id
										GROUP BY products.sub_sub_sub_cat_id", FALSE);
		
		if($sub_sub_sub_cats->result()){
			$insertD = array();
			foreach($sub_sub_sub_cats->result() as $sub_sub_sub_row){
				
				//BUILD INPUT
				$insert4['title'] = $sub_sub_sub_row->sub_cat. ' '. $sub_sub_sub_row->sub_sub_sub_cat;
				$insert4['body'] =  $sub_sub_sub_row->main_cat. ' '.$sub_sub_sub_row->sub_cat. ' '. $sub_sub_sub_row->sub_sub_sub_cat;
				$insert4['type'] = 'product_category';
				$insert4['type_id'] = $sub_sub_sub_row->sub_sub_sub_cat_id;
				$insert4['link'] = strtolower('buy/'.$this->encode_url($sub_sub_sub_row->main_cat).'/'.$this->encode_url($sub_sub_sub_row->sub_cat).'/'.$this->encode_url($sub_sub_sub_row->sub_sub_cat).'/'.$this->encode_url($sub_sub_sub_row->sub_sub_sub_cat).'/');
				$insert4['img_file'] = 'img/product_blank.jpg';
				$insert4['main_cat_id'] = $sub_sub_sub_row->main_cat_id;
				$insert4['sub_cat_id'] = $sub_sub_sub_row->sub_cat_id;
				$insert4['sub_sub_cat_id'] = $sub_sub_sub_row->sub_sub_cat_id;
				$insert4['sub_sub_sub_cat_id'] = $sub_sub_sub_row->sub_sub_sub_cat_id;
				$insert4['location'] = $sub_sub_sub_row->location;
				$insert4['suburb'] = $sub_sub_sub_row->suburb;
				//IF NON EXISTS
				if($insert4['title'] != '0'){
					array_push($insertD, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $sub_sub_sub_row->sub_sub_sub_cat_id);
					$this->db->where('type', 'product_category');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $sub_sub_sub_row->sub_sub_sub_cat_id);
						$this->db->where('type', 'product_category');
						$this->db->update('search_index', $insert4);
						
					}else{
						$this->db->insert('search_index', $insert4);
						
					}*/
			
					echo $insert4['title'] . ' ' .$insert4['body'].'<br />'.site_url('/').$insert4['link'].'<br /><br />';
				}
		
			}//end foreach sub_sub_sub_cat
			if($this->db->insert_batch('search_index', $insertD)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}
		echo '<br /><br />END 4</br ></br >';

	
	}	


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN PRODUCTS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_product_locations()
	{
		
		//EMPTY TABLE
		$this->db->where('type' , 'product_location');
		$this->db->delete('search_index');
		
		//CITIES
		$main_cats = $this->db->query("SELECT DISTINCT(location), main_cat_id,  sub_cat_id, sub_sub_cat_id, sub_sub_sub_cat_id,  suburb FROM products WHERE location != 'Select Location' AND sub_sub_sub_cat_id != 0 GROUP BY location", FALSE);
		
		if($main_cats->result()){
			$insertA = array();
			foreach($main_cats->result() as $main_row){
				
				//BUILD INPUT
				$insert['title'] = $this->get_category_name($main_row->main_cat_id) .' ' . $this->get_category_name($main_row->sub_cat_id).' in '.$main_row->location;
				$insert['body'] =  $this->get_category_name($main_row->main_cat_id) .' ' . $this->get_category_name($main_row->sub_cat_id).' in '.$main_row->location;
				$insert['type'] = 'product_location';
				$insert['type_id'] = $main_row->main_cat_id;
				$insert['link'] = strtolower('buy/'.$this->encode_url($this->get_category_name($main_row->main_cat_id)).'/'.$this->encode_url($this->get_category_name($main_row->sub_cat_id)).'/'.$this->encode_url($this->get_category_name($main_row->sub_sub_cat_id)).'/'.$this->encode_url($this->get_category_name($main_row->sub_sub_sub_cat_id)).'/'.$this->encode_url($main_row->location).'/');
				$insert['img_file'] = 'img/markers/map_marker.png';
				$insert['main_cat_id'] = $main_row->main_cat_id;
				$insert['sub_cat_id'] = $main_row->sub_cat_id;
				$insert['sub_sub_cat_id'] = $main_row->sub_sub_cat_id;
				$insert['sub_sub_sub_cat_id'] = $main_row->sub_sub_sub_cat_id;
				$insert['location'] = $main_row->location;
				$insert['suburb'] = $main_row->suburb;
				//IF NON EXISTS
				if($insert['title'] != '0'){
					
					array_push($insertA, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $main_row->main_cat_id);
					$this->db->where('type', 'product_location');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $main_row->main_cat_id);
						$this->db->where('type', 'product_location');
						$this->db->update('search_index', $insert);
						
					}else{
						$this->db->insert('search_index', $insert);
						
					}*/
				}
				echo $insert['title'].' -- ' .$insert['link'].'<br />';
			}//end foreach main_cat
			
			
			if($this->db->insert_batch('search_index', $insertA)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
			
		}
		//SUBURBS
		$sub_cats = $this->db->query("SELECT DISTINCT(suburb), sub_cat_id, main_cat_id, sub_sub_cat_id, sub_sub_sub_cat_id, location FROM products WHERE location != 'Select Location' AND sub_sub_sub_cat_id != 0 AND suburb != '' AND suburb != '0' GROUP BY suburb", FALSE);
		
		if($sub_cats->result()){
			$insertB = array();
			foreach($sub_cats->result() as $sub_row){
				
				//BUILD INPUT
				$insert2['title'] = $this->get_category_name($sub_row->sub_cat_id) . ' '.$this->get_category_name($sub_row->main_cat_id) . ' in '.$sub_row->suburb .' ' .$sub_row->location ;
				$insert2['body'] =  $this->get_category_name($sub_row->sub_cat_id) . ' '. $this->get_category_name($sub_row->main_cat_id). ' in '.$sub_row->suburb .' ' .$sub_row->location ;
				$insert2['type'] = 'product_location';
				$insert2['type_id'] = $sub_row->sub_cat_id;
				$insert2['link'] = strtolower('buy/'.$this->encode_url($this->get_category_name($sub_row->main_cat_id)).'/'.$this->encode_url($this->get_category_name($sub_row->sub_cat_id)).'/'.$this->encode_url($this->get_category_name($sub_row->sub_sub_cat_id)).'/'.$this->encode_url($this->get_category_name($sub_row->sub_sub_sub_cat_id)).'/'.$this->encode_url($sub_row->location).'/'.$this->encode_url($sub_row->suburb).'/');
				$insert2['img_file'] = 'img/product_blank.jpg';
				$insert2['main_cat_id'] = $sub_row->main_cat_id;
				$insert2['sub_cat_id'] = $sub_row->sub_cat_id;
				$insert2['sub_sub_cat_id'] = $sub_row->sub_sub_cat_id;
				$insert2['sub_sub_sub_cat_id'] = $sub_row->sub_sub_sub_cat_id;
				$insert2['location'] = $sub_row->location;
				$insert2['suburb'] = $sub_row->suburb;
				//IF NON EXISTS
				if($insert2['title'] != '0'){
					
					array_push($insertB, $insert);
					//UPDATE OR ADD
					/*$this->db->where('type_id', $sub_row->sub_cat_id);
					$this->db->where('type', 'product_location');
					$existing = $this->db->get('search_index');
					
					
					if($existing->result()){
						
						$this->db->where('type_id', $sub_row->sub_cat_id);
						$this->db->where('type', 'product_location');
						$this->db->update('search_index', $insert2);
						
					}else{
						$this->db->insert('search_index', $insert2);
						
					}*/
				}
				echo $insert2['title'].' -- ' .$insert2['link'].'<br />';
			}//end foreach sub_cat
			
			
			if($this->db->insert_batch('search_index', $insertB)){
				
				echo 'Done';
			}else{
				
				echo 'Fail';	
			
			}
		}	


	
	}	

	
	//++++++++++++++++++++++++++++++++++++
	//GET CATEGORY NAMES
	//++++++++++++++++++++++++++++++++++++
	public function get_category_name($id)
	{
		$this->db->where('cat_id', $id);
		$categories = $this->db->get('product_categories');
		if($categories->result()){
			$categories = $categories->row();
			return $categories->category_name;
			
		}else{
			
			return 0;
		}

			
	}
	//++++++++++++++++++++++++++++++++++++
	//GET PRODUCT CATEGORY NAMES
	//++++++++++++++++++++++++++++++++++++
	public function get_product_categories($row)
	{

			$cats = '';
			if($row->main_cat_id == 0){
				
				return $cats;
				
			}else{
				
				//MAIN_ID 
				$this->db->where('cat_id', $row->main_cat_id);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				$cats .=  $res['category_name'] .' , ';
				
				//SUB_ID
				$this->db->where('cat_id', $row->sub_cat_id);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				$cats .=  $res['category_name'].' , ';
				
				//SUB_SUB_ID
				$this->db->where('cat_id', $row->sub_sub_cat_id);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				$cats .=  $res['category_name'].' , ';
				
				//SUB_SUB_SUB_ID
				$this->db->where('cat_id', $row->sub_sub_sub_cat_id);
				$query = $this->db->get('product_categories');
				if($query->result()){
					$res = $query->row_array();
					$cats .=  $res['category_name'].' , ';
				}
				
			}
			return $cats;	
			
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS INDEX TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function build_deals()
	{
		
				//EMPTY TABLE
		$this->db->where('type' , 'deal');
		$this->db->delete('search_index');
		
		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW()" ,FALSE);
		if($query->result()){
			
			foreach($query->result() as $row){
				
				//BUILD INPUT
				$insert2['title'] = $row->SPECIALS_HEADER;
				$insert2['body'] =  $row->SPECIALS_HEADER . ' in '. $this->get_location_value($row->LOCATION). ' ' .$row->SPECIALS_CONTENT;
				$insert2['type'] = 'deal';
				$insert2['type_id'] = $row->ID;
				$insert2['link'] = strtolower('deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER).'/');
				$insert2['img_file'] = 'img/product_blank.jpg';
				if($row->SPECIALS_IMAGE_NAME != ''){
					
					$insert2['img_file'] = 'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
				}
				
				
				$insert2['main_cat_id'] = 0;
				$insert2['sub_cat_id'] = 0;
				$insert2['sub_sub_cat_id'] = 0;
				$insert2['sub_sub_sub_cat_id'] = 0;
				$insert2['location'] = $this->get_location_value($row->LOCATION);
				$insert2['suburb'] = '';

				//UPDATE OR ADD
				$this->db->where('type_id', $row->ID);
				$this->db->where('type', 'deal');
				$existing = $this->db->get('search_index');
				
				
				if($existing->result()){
					
					$this->db->where('type_id', $row->ID);
					$this->db->where('type', 'deal');
					$this->db->update('search_index', $insert2);
					
				}else{
					$this->db->insert('search_index', $insert2);
					
				}

				
			}
				
			
		}
		
		
	}
	
	
		
	//+++++++++++++++++++++++++++
	//GET LOCATIO N FRO ID
	//++++++++++++++++++++++++++
	public function get_location_value($id)
	{
		
			$this->db->where('ID', $id);
			$query = $this->db->get('a_map_location');
			
			if($query->num_rows() > 0){
				
				$row = $query->row();
				return $row->MAP_LOCATION;
				
			}else{
			
				return 'n';
			}
		
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN BUSINESS IMAGES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function clean_business()
	{


		//BUILD CITY ARRAY
		$city = $this->db->get('a_map_location');
		$cities = array();
		foreach($city->result() as $crow){

			$cities[$crow->ID] = $crow->MAP_LOCATION;
			//array_push($cities, $crow->MAP_LOCATION);



		}
		print_r($cities);
		//BUILD SUBURB ARRAY
		$suburb = $this->db->get('a_map_suburb');
		$suburbs = array();
		foreach($suburb->result() as $srow){

			$suburbs[ $srow->ID] = $srow->SUBURB_NAME;
			//array_push($suburbs, $srow->SUBURB_NAME);

		}
		print_r($suburbs);


		$business = $this->db->get('u_business');
		$x = 0; $x1 =0;
		$c1 = 0;$c2 = 0; $c3 = 0;$c =0; $c4 = 0;$u = 0;$u3 = 0;

		if($business->result()){

			foreach($business->result() as $row){

				$do = false;
				//TEST IMAGES
				$insert['img_file'] = 'img/bus_blank.jpg';

				if($row->BUSINESS_LOGO_IMAGE_NAME != ''){
					if(strpos($row->BUSINESS_LOGO_IMAGE_NAME, '.')){
						$insert['img_file'] = 'assets/business/photos/'.$row->BUSINESS_LOGO_IMAGE_NAME;
					}else{
						$insert['img_file'] = 'assets/business/photos/'.$row->BUSINESS_LOGO_IMAGE_NAME.'.jpg';
					}
				}

				$file = BASE_URL.$insert['img_file'];

				if(file_exists($file)){



				}else{

					$data['BUSINESS_LOGO_IMAGE_NAME'] = '';
					$do = true;

					$x1 ++;
				}
				echo $row->ID. ' '.$row->BUSINESS_NAME.'<br />';

				//TEST LOCATION
				if($row->BUSINESS_PHYSICAL_ADDRESS != ''){

					//echo $row->BUSINESS_PHYSICAL_ADDRESS.'<br />';
					$c ++;
				}

				//echo $row->BUSINESS_COUNTRY_ID .'<br />';

				//TEST LOCATION
				if($row->BUSINESS_COUNTRY_ID == '' || $row->BUSINESS_COUNTRY_ID == '0' ){

					echo 'No Country ';
					$c1 ++;

				}

				if(is_null($row->BUSINESS_MAP_CITY_ID) || $row->BUSINESS_MAP_CITY_ID == '' || $row->BUSINESS_MAP_CITY_ID == '0'){

					//echo 'No City ';
					$c2 ++;

					//MATCH CITY IN PHYSICAL ADDRESS
					if(strpos($row->BUSINESS_PHYSICAL_ADDRESS, 'windhoek') !== false || strpos($row->BUSINESS_PHYSICAL_ADDRESS, 'Windhoek') !== false){
						//$do = true;
						//$data['BUSINESS_MAP_CITY_ID'] = 12;

						$u ++;
					}

					//MATCH CITY ARRAY
					//CREATE ARRAY FROM ADDRESS
					$_ar = explode(" ", $row->BUSINESS_PHYSICAL_ADDRESS);

					foreach($_ar as $rrow){

						if(in_array($rrow, $cities)){
							$key = array_search($rrow, $cities);
							echo '<br /> City update: '.$rrow.' '.$key. '<br />';
							$do = true;
							$data['BUSINESS_MAP_CITY_ID'] = $key;
							$u3 ++;
						}



					}




				}
				if(is_null($row->BUSINESS_SUBURB_ID) || $row->BUSINESS_SUBURB_ID == 0 || $row->BUSINESS_SUBURB_ID == ''){

					//echo 'No Suburb ';
					$c3 ++;

					//MATCH SUBURB ARRAY
					//CREATE ARRAY FROM ADDRESS
					$_sr = explode(" ", $row->BUSINESS_PHYSICAL_ADDRESS);

					foreach($_sr as $rsrow){

						if(in_array($rsrow, $suburbs)){
							$key2 = array_search($rsrow, $suburbs);
							echo 'Suburb Updated'. $rsrow . ' = '.$key2;
							$do = true;
							$data['BUSINESS_SUBURB_ID'] = $key2;
							$c4 ++;
						}
					}

				}

				if($do){

					//UPDATE
					$this->db->where('ID', $row->ID);
					$this->db->update('u_business', $data);

				}


				$x ++;

			}


		}

		echo $c3 .'('.$c4.') Suburbs Missing; '. $c2 .'  Cities Missing;' . $c1 .' Countries Missing; '.$x1 .' Faulty images ' . $c .' Physical addresses avaialbe -- of '.$x .'records<br />

		     '.$u.' ('.$u3.') Cities updated';
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
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN URL
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function encode_url($str, $replace=array()) {
		
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = str_replace(" ", '-', $clean);
		$clean = strtolower(trim($clean));
		$clean = str_replace("&", 'and',$clean);
	
		return $clean;
	}
	//setlocale(LC_ALL, 'en_US.UTF8');
	function decode_url($str, $replace=array()) {
		
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = str_replace("-", ' ', $clean);
		$clean = str_replace("and", '&',$clean);
		$clean = ucwords(trim($clean));
		
	
		return $clean;
	}
	function url_encode($string){
        return urlencode(utf8_encode(  str_replace('(','_', str_replace(')','~',$string))));
    }
    
    function url_decode($string){
        return utf8_decode(urldecode(str_replace('_','(', str_replace('~',')',$string))));
    }
	
	//connect to tourism db
	function connect_tourism_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'hannamib_mynatour_user';
		$config_db['password'] = 'UI5TrephoWC0';
		$config_db['database'] = 'hannamib_mynatour_devdb';
		
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
	function connect_intouch_db(){
		
		//connect to main database
		$config_db['hostname'] = '65.98.90.82';
		$config_db['username'] = 'ntouchim_admin';
		$config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
		$config_db['database'] = 'ntouchim_debmarine';
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


	
}
/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */?>