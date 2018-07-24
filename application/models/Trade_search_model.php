<?php
class Trade_search_model extends CI_Model{
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function trade_search_model(){
  		//parent::CI_model();
		self::__construct();	
 	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_business_deals(){
		

		
		
	}
	
	
	public function get_api_towns($country_id) {
		
		$temp = $this->db->query("SELECT ID, MAP_LOCATION FROM a_map_location WHERE COUNTRY_ID = '".$country_id."' ", TRUE);
			
		$query['success'] =	false;
		
		if($temp->result_array()){
			
			$query['success'] =	true;
			
		}
		$query['query'] = $temp->result_array();

		return $query;		
		
	}
	
	
	 public function get_api_suburbs($town) {
		
		$temp = $this->db->query("SELECT A.ID, A.SUBURB_NAME FROM a_map_suburb AS A LEFT JOIN a_map_location AS B ON A.CITY_ID = B.ID WHERE B.MAP_LOCATION = '".$town."' ", TRUE);
			
		$query['success'] =	false;
		
		if($temp->result_array()){
			
			$query['success'] =	true;
			
		}
		$query['query'] = $temp->result_array();

		return $query;		
		
	}
	
	
	public function get_api_agents($bus_id,$user_array,$client_id) {
		
		
		if($user_array != '') {
		
		$data_string = implode(",", $user_array);
			
		$qry = "ORDER BY FIELD(A.CLIENT_ID, ".$data_string.")";
			
		} else {
			
			$qry = "ORDER BY A.SEQUENCE ASC";
			
		}
		
		if($client_id != ''){
			
			$qry2 = "AND A.CLIENT_ID = '".$client_id."'";
			
		} else {
			
			$qry2 = '';
			
		}
		
		$temp = $this->db->query("SELECT * FROM i_client_business AS A left join u_client AS B ON A.CLIENT_ID = B.ID WHERE A.BUSINESS_ID = '".$bus_id."' ".$qry2." ".$qry." ", TRUE);

		$query['success'] =	false;
		
		if($temp->result_array()){
			
			$query['success'] =	true;
			
		}
		$query['query'] = $temp->result_array();

		return $query;
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//PROPERTY SEARCH
	//++++++++++++++++++++++++++
	public function search() {
		
		//SORTING
		$sort = 'sort';$sortURL = 'sort';
		if($this->input->post('sort')){
			$sortURL = $this->input->post('sort');

		}
		//BUSINESS FILTER
		$bus_id = 0;
		if($this->input->post('bus_id')){
			if($this->input->post('bus_id') != ''){
				
				$bus_id = $this->input->post('bus_id');
				
			}else{
				
				$bus_id = 0;
			}
		}
		//PAGEINATION
		$offset = $this->input->post('offset');
		$limit = $this->input->post('limit');
		//GET CATEGORIES
		$main_cat_id  = $this->input->post('main_cat_id', TRUE);
		if($this->input->post('main_cat_id') == ''){
			
			$main_cat_id = 0;
			
		}
		$sub_cat_id  = $this->input->post('sub_cat_id', TRUE);
		if($this->input->post('sub_cat_id') == ''){
			
			$sub_cat_id = 0;
			
		}
		$sub_sub_cat_id  = $this->input->post('sub_sub_cat_id', TRUE);
		if($this->input->post('sub_sub_cat_id') == ''){
			
			$sub_sub_cat_id = 0;
			
		}
		$sub_sub_sub_cat_id = $this->input->post('sub_sub_sub_cat_id', TRUE);
		if($this->input->post('sub_sub_sub_cat_id') == ''){
			
			$sub_sub_sub_cat_id = 0;
			
		}
		
		//GET EXTRAS
		$extras = '?';
		if($this->input->post('bedrooms')){
			$bedrooms = $this->input->post('bedrooms', TRUE);	
			$extras .= 'bedrooms='.trim(str_replace("bedrooms","", $bedrooms)).'&';
		}
		if($this->input->post('bathrooms')){
			$bathrooms = $this->input->post('bathrooms', TRUE);	
			$extras .= 'bathrooms='.trim(str_replace("bathrooms","", $bathrooms)).'&';
		}
		if($this->input->post('features')){
			$features = array();
			$c = 0;
			foreach($this->input->post('features') as $row){
				
				if($c == 0){
					array_push($features, $row);
					//$features .= ''.$row;	
				}else{
					array_push($features, $row);
					//$features .= ''.$row;						
				}

				$c ++;
			}
			 
			$extras .= 'features='.trim(json_encode($features)).'&';
		}

		//CARS BODY STYLE
		if($this->input->post('body_style') != ''){

			$extras .= 'body_style='.$this->encode_url($this->input->post('body_style')).'&';
		}
		//NEW USED
		if($this->input->post('owners') == 'New'){

			$extras .= 'owners=New&';
		}
		
		//BUILD EXTRAS STRING
		
		//gGET KEYWORD
		$keyURL = 'all';
		if($this->input->post('keyword')){
			$keyURL = $this->encode_url($this->input->post('keyword',TRUE));
		}
		
		//GET LOCATION	
		$location  = $this->input->post('location', TRUE);
		//GET SUBURB
		if($this->input->post('suburb')){
			$suburb  = $this->input->post('suburb', TRUE);

			if($suburb != 'all' && $suburb != ''){
				$suburbURL = $this->encode_url($suburb);	
			}else{
				
				$suburbURL = 'all';
			}
			
		}else{
			
			$suburbURL = 'all';		
		}
	
		//GET PRICE FILTERS
		$price_from = preg_replace("/[^0-9]/","",$this->input->post('price_from', TRUE));
		$price_to = preg_replace("/[^0-9]/","",$this->input->post('price_to', TRUE));
		

		//CLEAN URLS
		$main_cat = $this->trade_model->get_category_name($main_cat_id);
		$main_catURL =  $this->encode_url($main_cat);

		$sub_cat = $this->trade_model->get_category_name($sub_cat_id);
		$sub_catURL =  $this->encode_url($sub_cat);
		
		$sub_sub_cat = $this->trade_model->get_category_name($sub_sub_cat_id);
		$sub_sub_catURL =  $this->encode_url($sub_sub_cat);
		
		$sub_sub_sub_cat = $this->trade_model->get_category_name($sub_sub_sub_cat_id);
		$sub_sub_sub_catURL =  $this->encode_url($sub_sub_sub_cat);
		
		if($location == 'national'){
			$locationURL =  'national';
		}else{
			//$location = $this->trade_model->get_location_value($location_id);
			$locationURL =  $this->encode_url($location);
		}

		$price_f = $this->encode_url($price_from);	

		$price_t = $this->encode_url($price_to);
		
		if($price_f == "") { $price_f = 'n'; }
		if($price_t == "") { $price_t = 'n'; }		
		
		$url_string = $main_catURL . '/' . $sub_catURL . '/' . $sub_sub_catURL . '/' . $sub_sub_sub_catURL .'/'.$locationURL. '/'.$suburbURL.'/' . $price_f . '/' . $price_t . '/' . $main_cat_id . '/' . $sub_cat_id . '/' .$sub_sub_cat_id . '/' . $sub_sub_sub_cat_id.'/'.$sortURL.'/'.$keyURL.'/'.$bus_id.'/'.$limit.'/'.$offset.'/'.$extras;		
		//echo $url_string;
		return $url_string;		
		
	}
	
	//+++++++++++++++++++++++++++
	//PRODUCT SEARCH GET QUERY
	//++++++++++++++++++++++++++
	
	public function get_query($main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $location, $suburb, $price_from, $price_to ,$main_cat_id  ,$sub_cat_id , $sub_sub_cat_id , $sub_sub_sub_cat_id, $key, $extras, $sort,  $bus_id = 0, $limit, $offset) {
		
		$query['group'] = 'all';
		$query['heading'] = '';
		$query['title'] = '';
		$qstr = '';
		
		//GET GROUP FILTERS			
		if($main_cat_id == '3408'){
				
			$query['group'] = 'property';
			
		}elseif($main_cat_id == '348'){
			
			$query['group'] = 'cars';
			
		}else{
			
			$query['group'] = 'all';
		}
		
		//PAGEINATION
		//$limit = 15;
		$pageSQL = "";
		//if(!is_numeric($offset)){
			
			if($offset != ''){
				
				$pageSQL = " LIMIT ".$limit." OFFSET ".$offset." ";	
				
			}else{
				if($limit != 0){
					$pageSQL = " LIMIT ".$limit." ";
				}
					
			}
			
				
		//}
		

		//SORTING
		if($sort == 'dateDESC'){
			
			$sortSQL = ' ORDER BY products.listing_date DESC ';
			
		}elseif($sort == 'priceA'){
			
			$sortSQL = ' ORDER BY products.sale_price ASC ';

		}elseif($sort == 'priceD'){
			
			$sortSQL = ' ORDER BY products.sale_price DESC ';
		}else{
			
			$sortSQL = ' ORDER BY products.listing_date DESC ';
			
		}
		
		//VALIDATE CAT
		if($sub_sub_sub_cat_id != 0){
			
			$query['title'] = ucwords($this->decode_url($sub_sub_cat). ' '. $this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ' );
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."' AND products.sub_sub_cat_id = '".$sub_sub_cat_id."' AND products.sub_sub_sub_cat_id = '".$sub_sub_sub_cat_id."'";
			
			
		}elseif($sub_sub_cat_id != 0){
			
			$query['title'] = ucwords($this->decode_url($sub_sub_cat). ' '. $this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."' AND products.sub_sub_cat_id = '".$sub_sub_cat_id."'";
				
		}elseif($sub_cat_id != 0){
			
			$query['title'] = ucwords($this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."'";
		
		}elseif($main_cat_id != 0 && $main_cat_id != ''){
					
			$query['title'] = ucwords( $this->decode_url($main_cat).' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."'";

		}else{
			$query['title'] = 'Products ';
			$qstr = " WHERE products.is_active = 'Y' ";
			
		}
		
		//BUSINESS SPECIFIC
		$busSQL = "";
		if($bus_id != '0' && is_numeric($bus_id)){
			
			if(trim($qstr) != ''){
				$busSQL = " AND products.bus_id = '".$bus_id."' ";
			
			}else{
				
				$busSQL = " WHERE products.bus_id = '".$bus_id."' ";
			}
			
			
		}

		
		
		//LOCATION SUBURB
		$localSUBURB = '';
		$suburb_title = ' in '; 
		if($suburb != 'all' && $suburb != ''){
			
			$localSUBURB = " AND products.suburb = '".$this->decode_url($suburb)."'";
			$suburb_title = ' in '.ucwords( $this->decode_url($suburb));
		}
		
		//LOCATION CITY
		$localCITY = ''; 
		$city_title = ' Namibia';
		if($location != 'national' && $location != ''){
			
			if(trim($qstr) != ''){
				$localCITY = " AND products.location = '".ucwords($this->decode_url($location))."'";
				
			}else{
				$localCITY = " WHERE products.location = '".ucwords($this->decode_url($location))."'";
				
			}
			$city_title = ' '.ucwords( $this->decode_url($location)) . ' Namibia';	
			
		}
		$query['title'] = $query['title'] . ' ' .$suburb_title . ' ' .$city_title;

		//PRICE FILTERS
		$priceSQL = ''; 
		if($price_from != 'n' && $price_from != 0){
			
			$priceSQL .= " AND products.sale_price >= ".$price_from." ";
			
		}
		if($price_to != 'n' && $price_to != 0){
			
			$priceSQL .= " AND products.sale_price <= ".$price_to." ";
			
		}
		//EXTRAS
		//exclude auction, service parameter
		$extrasSQL = "";
		if(count($extras) > 0 && is_array($extras)){
			
			foreach($extras as $key => $value){
				
				//FEATURES
				if($key == 'features'){
					
					if(is_array(json_decode($value))){
						
						foreach(json_decode($value) as $subkey){
							
							$tempstr = '"'.$subkey.'"'; 
							$extrasSQL .= " AND product_extras.extras LIKE '%".$tempstr."%' ";
								
						}
						
					}
				//NEW USED
				}elseif($key == 'owners'){
					
					$extrasSQL .= " AND product_extras.extras LIKE '%". '"owners"'.':"New"'."%' ";
				//BODY_STYLE
				}elseif($key == 'body_style'){
					
					$extrasSQL .= " AND product_extras.extras LIKE '%". '"body_style"'.':"'.$value.'"'."%' ";
				}else{
					
					$tempstr = '"'.$key.'":"'.$value .' '.$key; 
					$extrasSQL .= " AND product_extras.extras LIKE '%".$tempstr."%' ";
					
				}
				

				
			}
			
		}


		if($certified = $this->input->get('certified')) {

			if($certified == 'certified') {

				$certiSQL = " AND product_extras.extras LIKE '%Certified_pre_owned%'";

			}

			if($certified == 'non-certified') {

				$certiSQL = " AND product_extras.extras NOT LIKE '%Certified_pre_owned%' AND product_extras.extras NOT LIKE '%New_demo%'";

			}


			if($certified == 'new-demo') {

				$certiSQL = " AND product_extras.extras LIKE '%New_demo%'";
			}

		} else {

			$certiSQL = '';

		}


		$typeSQL = '';
		if($service = $this->input->get('service')){

			$typeSQL = " AND products.listing_type = 'C'";

		}elseif($auction = $this->input->get('auction')){

			$typeSQL = " AND products.listing_type = 'A'";

		}elseif(!$this->input->get('auction') && !$this->input->get('service')){

			$typeSQL = " ";
		}else{

			$typeSQL = " AND products.listing_type = 'S'";

		}

		//debug
		$debug = "SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                          u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_PHYSICAL_ADDRESS, u_business.BUSINESS_TELEPHONE, u_business.BUSINESS_COVER_PHOTO, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                          MAX(product_auction_bids.amount) as current_bid,
                                          AVG(u_business_vote.RATING) as TOTAL,
                                          (
                                             SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                          ) as TOTAL_REVIEWS
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                          LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                          ".$qstr . $busSQL . $localCITY. $localSUBURB. $extrasSQL. $priceSQL.$typeSQL.$certiSQL.'
                                         GROUP BY products.product_id
                                         '.$sortSQL.$pageSQL;
		
		$query['query'] = $this->db->query("SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                          u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_PHYSICAL_ADDRESS, u_business.BUSINESS_TELEPHONE, u_business.BUSINESS_COVER_PHOTO, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                          group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
                                          MAX(product_auction_bids.amount) as current_bid,
                                          AVG(u_business_vote.RATING) as TOTAL,
                                          (
                                             SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                          ) as TOTAL_REVIEWS
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_images ON products.product_id = product_images.product_id
                                          LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                          LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                         ".$qstr . $busSQL . $localCITY. $localSUBURB. $extrasSQL. $priceSQL.$typeSQL.$certiSQL.'
                                         GROUP BY products.product_id
                                         '.$sortSQL.$pageSQL);

		$query['count'] = $this->db->query("SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                          u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_PHYSICAL_ADDRESS, u_business.BUSINESS_TELEPHONE, u_business.BUSINESS_COVER_PHOTO, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                          MAX(product_auction_bids.amount) as current_bid,
                                          AVG(u_business_vote.RATING) as TOTAL,
                                          (
                                             SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                          ) as TOTAL_REVIEWS
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_images ON products.product_id = product_images.product_id
                                          LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                          LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                          ".$qstr . $busSQL . $localCITY. $localSUBURB. $extrasSQL. $priceSQL.$typeSQL.$certiSQL.'
                                         GROUP BY products.product_id
                                         '.$sortSQL);




		$query['offset'] = $offset;
		//GET TOTAL RESULTS FOR PAGHINATION
		$query['count'] = $query['count']->num_rows();
		$query['debug'] = $debug;
		//echo $debug ;
		return $query;
		
	}





	//+++++++++++++++++++++++++++
	//PRODUCT SEARCH GET QUERY
	//++++++++++++++++++++++++++

	public function get_api_query($main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $location, $suburb, $price_from, $price_to ,$main_cat_id  ,$sub_cat_id , $sub_sub_cat_id , $sub_sub_sub_cat_id, $key, $extras, $certified, $autohaus, $reference, $sort, $q, $bus_id = 0, $limit, $offset) {

		$query['group'] = 'all';
		$query['heading'] = '';
		$query['title'] = '';
		$qstr = '';

		//GET GROUP FILTERS
		if($main_cat_id == '3408'){

			$query['group'] = 'property';

		}elseif($main_cat_id == '348'){

			$query['group'] = 'cars';

		}else{

			$query['group'] = 'all';
		}
		
		//PAGEINATION
		//$limit = 15;
		$pageSQL = "";
		//if(!is_numeric($offset)){

		if($offset != 0){

			$pageSQL = " LIMIT ".$limit." OFFSET ".$offset." ";

		}else{
			if($limit != 0){
				$pageSQL = " LIMIT ".$limit." ";
			}

		}


		//}


		//SORTING
		if($sort == 'date_desc'){

			$sortSQL = ' ORDER BY products.listing_date DESC ';

		}elseif($sort == 'date_asc'){

			$sortSQL = ' ORDER BY products.listing_date ASC ';

		}elseif($sort == 'price_asc'){

			$sortSQL = ' ORDER BY products.sale_price ASC ';

		}elseif($sort == 'price_desc'){

			$sortSQL = ' ORDER BY products.sale_price DESC ';
		}else{
			
			$sortSQL = ' ORDER BY products.is_featured DESC, products.listing_date DESC ';
		}



		//VALIDATE CAT
		/*if($sub_sub_sub_cat_id != 0){

			//$query['title'] = ucwords($this->decode_url($sub_sub_cat). ' '. $this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ' );
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."' AND products.sub_sub_cat_id = '".$sub_sub_cat_id."' AND products.sub_sub_sub_cat_id = '".$sub_sub_sub_cat_id."'";


		}elseif($sub_sub_cat_id != 0){

			//$query['title'] = ucwords($this->decode_url($sub_sub_cat). ' '. $this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."' AND products.sub_sub_cat_id = '".$sub_sub_cat_id."'";

		}elseif($sub_cat_id != 0){

			//$query['title'] = ucwords($this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."'";

		}elseif($main_cat_id != 0 && $main_cat_id != ''){

			//$query['title'] = ucwords( $this->decode_url($main_cat).' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."'";

		}else{
			//$query['title'] = 'Products ';
			$qstr = " WHERE products.is_active = 'Y' ";

		}*/

		if($sub_sub_sub_cat_id != 0){

			//$query['title'] = ucwords($this->decode_url($sub_sub_cat). ' '. $this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ' );
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_sub_sub_cat_id = '".$sub_sub_sub_cat_id."'";


		}elseif($sub_sub_cat_id != 0){

			//$query['title'] = ucwords($this->decode_url($sub_sub_cat). ' '. $this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_sub_cat_id = '".$sub_sub_cat_id."'";

		}elseif($sub_cat_id != 0){

			//$query['title'] = ucwords($this->decode_url($main_cat).' '. $this->decode_url($sub_cat) . ' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."' AND products.sub_cat_id = '".$sub_cat_id."'";

		}elseif($main_cat_id != 0 && $main_cat_id != ''){

			//$query['title'] = ucwords( $this->decode_url($main_cat).' ');
			$qstr = " WHERE products.is_active = 'Y' AND products.main_cat_id = '".$main_cat_id."'";

		}else{
			//$query['title'] = 'Products ';
			$qstr = " WHERE products.is_active = 'Y' ";

		}

		//BUSINESS SPECIFIC
		$busSQL = "";
		//echo $bus_id;
		if($bus_id != '0' && is_numeric($bus_id)){

			if(trim($qstr) != ''){

				$busSQL = " AND products.bus_id = '".$bus_id."' ";

			}else{

				$busSQL = " WHERE products.bus_id = '".$bus_id."' ";

			}


		} elseif(is_array($bus_id)) {

			if(trim($qstr) != '') {
				$busSQL = "AND products.bus_id IN (".implode(",",array_map("intval",$bus_id)).")";
			} else {
				$busSQL = "WHERE products.bus_id IN (".implode(",",array_map("intval",$bus_id)).")";
			}

		}

		//LISTING TYPE
		/*if($listing_type != 0){
			
			$qstr .= " AND products.listing_type = '".$listing_type."' ";
			
		}*/

		//LOCATION SUBURB
		$localSUBURB = '';
		$suburb_title = ' in ';
		if($suburb != 'all' && $suburb != ''){

			$localSUBURB = " AND products.suburb = '".$this->decode_url($suburb)."'";
			$suburb_title = ' in '.ucwords( $this->decode_url($suburb));
		}

		//LOCATION CITY
		$localCITY = '';
		$city_title = ' Namibia';
		if($location != 'national' && $location != ''){

			if(trim($qstr) != ''){
				$localCITY = " AND products.location = '".ucwords($this->decode_url($location))."'";

			}else{
				$localCITY = " WHERE products.location = '".ucwords($this->decode_url($location))."'";

			}
			$city_title = ' '.ucwords( $this->decode_url($location)) . ' Namibia';

		}
		$query['title'] = $query['title'] . ' ' .$suburb_title . ' ' .$city_title;

		//PRICE FILTERS
		$priceSQL = '';
		if($price_from != 'n' && $price_from != 0){

			$priceSQL .= " AND products.sale_price >= ".$price_from." ";

		}

		if($price_to != 'n' && $price_to != 0){

			$priceSQL .= " AND products.sale_price <= ".$price_to." ";

		}



		//SEARCH STRING

		$stringSQL = '';
		$q = trim($q);
		if($q != '' && $q != 0){

			if(str_word_count($q) > 1) {

				$keys = str_replace(" ", "+", trim($q));
				$keyA = explode("+", $keys);

				$i = 1;
				foreach($keyA as $r){
					if(strlen($r) > 3){

						if($i == 1) {

							$stringSQL.= " AND (product_extras.extras LIKE '%".$r."%' OR products.description LIKE '%".$r."%' OR products.title LIKE '%".$r."%' OR products.location LIKE '%".$r."%' OR products.suburb LIKE '%".$r."%') ";

						} else {

							$stringSQL.= " AND (product_extras.extras LIKE '%".$r."%' OR products.description LIKE '%".$r."%' OR products.title LIKE '%".$r."%' OR products.location LIKE '%".$r."%' OR products.suburb LIKE '%".$r."%')";
						}

					}
				$i++;
				}

			} else {

				$stringSQL.= " AND (product_extras.extras LIKE '%".$q."%' OR products.description LIKE '%".$q."%' OR products.title LIKE '%".$q."%') ";

			}

		}


		if($certified = $this->input->get('certified')) {

			if($certified == 'certified') {

				$certiSQL = " AND product_extras.extras LIKE '%Certified_pre_owned%'";

			}

			if($certified == 'non-certified') {

				$certiSQL = " AND product_extras.extras NOT LIKE '%Certified_pre_owned%' AND product_extras.extras NOT LIKE '%New_demo%'";

			}


			if($certified == 'new-demo') {

				$certiSQL = " AND product_extras.extras LIKE '%New_demo%'";
			}

		} else {

			$certiSQL = '';

		}

		if($autohaus = $this->input->get('autohaus')) {

			if($autohaus == 'Mastercars') {
				$autoSQL = " AND product_extras.extras LIKE '%".$autohaus."%'";
			}

			if($autohaus == 'Used') {
				$autoSQL = " AND product_extras.extras NOT LIKE '%New%' AND product_extras.extras NOT LIKE '%Mastercars%'";
			}

		} else {

			$autoSQL = '';

		}

		if($reference = $this->input->get('reference')) {


				$refSQL = " AND product_extras.extras LIKE '%".$reference."%'";


		} else {

			$refSQL = '';

		}


		//EXTRAS
		//exclude auction, service parameter
		$extrasSQL = "";
		if(count($extras) > 0 && is_array($extras)){

			foreach($extras as $key => $value){

				//FEATURES
				if($key == 'features'){

					if(is_array(json_decode($value))){

						foreach(json_decode($value) as $subkey){

							$tempstr = '"'.$subkey.'"';
							$extrasSQL .= " AND product_extras.extras LIKE '%".$tempstr."%' ";

						}

					}
					//NEW USED
				}elseif($key == 'owners'){

					$extrasSQL .= " AND product_extras.extras LIKE '%". '"owners"'.':"New"'."%' ";
					//BODY_STYLE
				}elseif($key == 'body_style'){

					$extrasSQL .= " AND product_extras.extras LIKE '%". '"body_style"'.':"'.$value.'"'."%' ";
				}else{

					$tempstr = '"'.$key.'":"'.$value .' '.$key;
					$extrasSQL .= " AND product_extras.extras LIKE '%".$tempstr."%' ";

				}



			}

		}






		$typeSQL = '';
		if($service = $this->input->get_post('service')){

			$typeSQL = " AND products.listing_type = 'C'";

		}elseif($auction = $this->input->get_post('auction')){

			$typeSQL = " AND products.listing_type = 'A'";
			$query['group'] .= ' auctions'; 
		}elseif(!$this->input->get_post('auction') && !$this->input->get_post('service')){

			$typeSQL = " ";
		}else{

			$typeSQL = " AND products.listing_type = 'S'";

		}

		//debug
		$debug = "SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                          u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_PHYSICAL_ADDRESS, u_business.BUSINESS_TELEPHONE, u_business.BUSINESS_COVER_PHOTO, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                          group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
                                          MAX(product_auction_bids.amount) as current_bid,
                                          AVG(u_business_vote.RATING) as TOTAL,
                                          (
                                             SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                          ) as TOTAL_REVIEWS
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                          LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                          ". $qstr . $busSQL . $localCITY . $localSUBURB . $extrasSQL . $priceSQL . $typeSQL . $stringSQL . $certiSQL . $autoSQL . $refSQL .'
                                         GROUP BY products.product_id
                                         '.$sortSQL.$pageSQL;

		$temp = $this->db->query("SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                          u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_PHYSICAL_ADDRESS, u_business.BUSINESS_TELEPHONE, u_business.BUSINESS_COVER_PHOTO, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                          group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
                                          agents.CLIENT_EMAIL, agents.CLIENT_PROFILE_PICTURE_NAME, agents.CLIENT_NAME, agents.CLIENT_SURNAME, agents.CLIENT_CELLPHONE,
                                          MAX(product_auction_bids.amount) as current_bid,
                                          AVG(u_business_vote.RATING) as TOTAL,
                                          (
                                             SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                          ) as TOTAL_REVIEWS
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_images ON products.product_id = product_images.product_id
                                          LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                          LEFT JOIN u_client AS agents ON product_extras.property_agent = agents.ID
                                          LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                              AND products.status = 'live' AND products.is_active = 'Y'
                                         ". $qstr . $busSQL . $localCITY . $localSUBURB . $extrasSQL . $priceSQL . $typeSQL . $stringSQL . $certiSQL . $autoSQL . $refSQL ."
                                         GROUP BY products.product_id
                                         ".$sortSQL.$pageSQL, TRUE);

		$query['count'] = $this->db->query("SELECT  products.product_id
                                          FROM products
                                          JOIN product_extras ON products.product_id = product_extras.product_id
                                          LEFT JOIN u_business ON u_business.ID = products.bus_id
                                          LEFT JOIN product_images ON products.product_id = product_images.product_id
                                          LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                          LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                              AND products.status = 'live' AND products.is_active = 'Y'
                                          ". $qstr . $busSQL . $localCITY . $localSUBURB . $extrasSQL . $priceSQL . $typeSQL . $stringSQL . $certiSQL . $autoSQL . $refSQL .'
                                         GROUP BY products.product_id
                                         '.$sortSQL);
		
		
		$query['success'] =	false;
		if($temp->result_array()){
			
			$query['success'] =	true;
			
		}
		$query['query'] = $temp->result_array();
		$query['offset'] = $offset;
		$query['limit'] = $limit;
		//GET TOTAL RESULTS FOR PAGHINATION
		$query['count'] = $query['count']->num_rows();
		
		//$query['debug'] = $debug;
		//echo $debug ;
		return $query;

	}




	function get_api_product($product_id, $bus_id) {


		if($bus_id != 'null') {

			$qry = " AND products.bus_id = '".$bus_id."'";

		} else {

			$qry = '';

		}


		$temp = $this->db->query("SELECT  products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
								  u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
								  agents.CLIENT_EMAIL, agents.CLIENT_PROFILE_PICTURE_NAME, agents.CLIENT_NAME, agents.CLIENT_SURNAME, agents.CLIENT_CELLPHONE, agents.CLIENT_TELEPHONE,
								  MAX(product_auction_bids.amount) as current_bid,
								  AVG(u_business_vote.RATING) as TOTAL,
								  (
									 SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
								  ) as TOTAL_REVIEWS
								  FROM products
								  JOIN product_extras ON products.product_id = product_extras.product_id
								  LEFT JOIN u_business ON u_business.ID = products.bus_id
								  LEFT JOIN product_images ON products.product_id = product_images.product_id
								  LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
								  LEFT JOIN u_client AS agents ON product_extras.property_agent = agents.ID
								  LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
									  AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
									  AND products.status = 'live' AND products.is_active = 'Y'
								 WHERE products.product_id = '".$product_id."' ".$qry."
								 GROUP BY products.product_id
								 ", TRUE);

		if($temp->result()) {

			$query['query'] = $temp->row();
			$o['success'] = true;
			$o['product'] = $temp->row();

		} else {
			$o['success'] = false;
			$o['msg'] = 'Could not find the product';
		}

		return $o;
	}




	function get_api_businesses($bus_id) {

		$temp = $this->db->query("SELECT ID, BUSINESS_LOGO_IMAGE_NAME, BUSINESS_NAME, BUSINESS_SLUG, BUSINESS_EMAIL, BUSINESS_TELEPHONE, BUSINESS_FAX, BUSINESS_CELLPHONE, BUSINESS_DESCRIPTION  FROM u_business WHERE ISACTIVE = 'Y' AND ID IN (".implode(",",array_map("intval",$bus_id)).")", TRUE);

		if($temp->result()) {

			$query['query'] = $temp->result_array();

			//$o['success'] = true;
			$o['business'] = $temp->result_array();

		} else {
			//$o['success'] = false;
			$o['msg'] = 'Could not find the business';
		}

		return $o;
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
	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//ENCODING ENCRYPTION 
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++ */	
	 

	public  function decrypt($string) {
		$this->load->library('encrypt');
        $data =  str_replace('_-_','/', str_replace('-_-','+', str_replace('-a-','=',($this->encrypt->decode($string)))));
		//$data =  $this->encrypt->decode($string);
        return $data;
    }
	public  function encrypt($string) {
        $this->load->library('encrypt');
		
		$data = str_replace('/','_-_',  str_replace('+','-_-',  str_replace('=','-a-',($this->encrypt->encode($string)))));
		//$data = $this->encrypt->encode($string);
        return $data;
    }


	

}
?>