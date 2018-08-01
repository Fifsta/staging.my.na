<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
require APPPATH.'/libraries/REST_Controller.php';

class Products_api extends REST_Controller{

	/**
	 * REST Controller for My.na App.
	 *
	 * Roland Ihms
	 */
	//++++++++++++++++++++++++++++++++++++++++
	//PRE FLIGHT OPTIONS REQUEST
	public function index_options() {
		return $this->response(NULL, 200);
	}


	public function index_get()
	{

		$this->response('Going Nowhere Slowly!!', 200);
	}

	public function index_post()
	{

		$this->response('Going Nowhere Slowly!!', 200);
	}
	
	
	
	public function towns_get() {
		
		
		$country_id = $this->get('country_id');
		
		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_api_towns($country_id);

		$this->response($o, 200);
		
	}
	
	public function suburbs_get() {
		
		
		$town_id = $this->get('town_id');
		
		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_api_suburbs($town_id);

		$this->response($o, 200);
		
	}	
	
	
	
	//+++++++++++++++++++++++++++
	//TRADE/SEARCH - Find Products POST
	//++++++++++++++++++++++++++
	public function search_post()
	{
		//VALIDATE PAGINATION INPUT
		if(!$limit = $this->post('limit'))
		{
			$limit = 10;

		}
		if(!$offset = $this->post('offset'))
		{
			$offset = 0;

		}

		//VALIDATE CATEGORIES INPUT
		if(!$main_cat_id = $this->post('main_cat_id'))
		{
			$main_cat_id = 0;
			$main_cat = 'no-name';
		}
		if(!$sub_cat_id = $this->post('sub_cat_id'))
		{
			$sub_cat_id = 0;
			$sub_cat = 'no-name';
		}
		if(!$sub_sub_cat_id = $this->post('sub_sub_cat_id'))
		{
			$sub_sub_cat_id = 0;
			$sub_sub_cat = 'no-name';
		}
		if(!$sub_sub_sub_cat_id = $this->post('sub_sub_sub_cat_id'))
		{
			$sub_sub_sub_cat_id = 0;
			$sub_sub_sub_cat = 'no-name';
		}

		//VALIDATE LOCATION INPUT
		if(!$location = $this->post('location'))
		{
			$location = 'national';
		}
		if(!$suburb = $this->post('suburb'))
		{
			$suburb = 'all';
		}
		//VALIDATE PRICE INPUT
		if(!$price_from = $this->post('price_from'))
		{
			$price_from = 'n';
		}
		if(!$price_to = $this->post('price_to'))
		{
			$price_to = 'n';
		}

		//VALIDATE SORTING INPUT
		if(!$sort = $this->post('sort'))
		{
			$sort = 'sort';
		}
		if(!$sort_by = $this->post('sort_by'))
		{
			$price_to = 'n';
		}

		//VALIDATE INPUT KEY STRING
		if(!$q = $this->post('q'))
		{
			$q = 'all';
		}

		//VALIDATE BUSINESS ID's
		if(!$bus_id = $this->post('bus_id'))
		{
			$bus_id = '0';
		}

		//VALIDATE EXTRAS
		if(!$extras = $this->post('extras'))
		{
			$extras = '';
		}
		//VALIDATE CERTIFIED
		if(!$certified = $this->get('certified'))
		{
			$certified = '';
		}

		//VALIDATE AUTOHAUS
		if(!$autohaus = $this->get('autohaus'))
		{
			$autohaus = '';
		}

		//VALIDATE REFERENCE
		if(!$reference = $this->get('reference'))
		{
			$reference = '';
		}


		//VALIDATE FEATURES
		if(!$features = $this->post('features'))
		{
			$features = '';
		}

		//VALIDATE PROPERTY PARAMETERS
		if(!$bedrooms = $this->post('bedrooms'))
		{
			$bedrooms = '';
		}
		if(!$bathrooms = $this->post('bathrooms'))
		{
			$bathrooms = '';
		}

		if(!$q = urldecode($this->post('q')))
		{
			$q = '';
		}


		/*$extras = '?';
		if($this->input->get()){
			$extras = $this->input->get();

			//exclude service and auction parameters
			unset($extras['service']);
			unset($extras['auction']);
		}*/

		$this->load->model('trade_search_model');
		
		$o = $this->trade_search_model->get_api_query($main_cat = '', $sub_cat = '', $sub_sub_cat = '', $sub_sub_sub_cat = '', $location, $suburb, $price_from, $price_to ,$main_cat_id  ,$sub_cat_id , $sub_sub_cat_id , $sub_sub_sub_cat_id, $q, $extras,$certified, $autohaus, $reference, $sort, $q, $bus_id, $limit, $offset);

		echo $this->response($o, 200);


	}

	//+++++++++++++++++++++++++++
	//TRADE/SEARCH - Find Products GET
	//++++++++++++++++++++++++++
	public function search_get()
	{
		//VALIDATE PAGINATION INPUT
		if(!$limit = $this->get('limit'))
		{
			$limit = 10;

		}
		if(!$offset = $this->get('offset'))
		{
			$offset = 0;

		}

		//VALIDATE CATEGORIES INPUT
		if(!$main_cat_id = $this->get('main_cat_id'))
		{
			$main_cat_id = 0;
			$main_cat = 'no-name';
		}
		if(!$sub_cat_id = $this->get('sub_cat_id'))
		{
			$sub_cat_id = 0;
			$sub_cat = 'no-name';
		}
		if(!$sub_sub_cat_id = $this->get('sub_sub_cat_id'))
		{
			$sub_sub_cat_id = 0;
			$sub_sub_cat = 'no-name';
		}
		if(!$sub_sub_sub_cat_id = $this->get('sub_sub_sub_cat_id'))
		{
			$sub_sub_sub_cat_id = 0;
			$sub_sub_sub_cat = 'no-name';
		}

		//VALIDATE LOCATION INPUT
		if(!$location = $this->get('location'))
		{
			$location = 'national';
		}
		if(!$suburb = $this->get('suburb'))
		{
			$suburb = 'all';
		}
		//VALIDATE PRICE INPUT
		if(!$price_from = $this->get('price_from'))
		{
			$price_from = 'n';
		}
		if(!$price_to = $this->get('price_to'))
		{
			$price_to = 'n';
		}

		//VALIDATE SORTING INPUT
		if(!$sort = $this->get('sort'))
		{
			$sort = '';
		}




		//VALIDATE INPUT KEY STRING
		if(!$q = urldecode($this->get('q')))
		{
			$q = 'all';
		}

		//VALIDATE BUSINESS ID's
		if(!$bus_id = $this->get('bus_id'))
		{
			$bus_id = '0';
		}

		//VALIDATE EXTRAS
		if(!$extras = $this->get('extras'))
		{
			$extras = '';
		}


		//VALIDATE CERTIFIED
		if(!$certified = $this->get('certified'))
		{
			$certified = '';
		}

		//VALIDATE AUTOHAUS
		if(!$autohaus = $this->get('autohaus'))
		{
			$autohaus = '';
		}

		//VALIDATE REFERENCE
		if(!$reference = $this->get('reference'))
		{
			$reference = '';
		}

		//VALIDATE FEATURES
		if(!$features = $this->get('features'))
		{
			$features = '';
		}

		//VALIDATE PROPERTY PARAMETERS
		if(!$bedrooms = $this->get('bedrooms'))
		{
			$bedrooms = '';
		}
		if(!$bathrooms = $this->get('bathrooms'))
		{
			$bathrooms = '';
		}

		if(!$q = $this->get('q'))
		{
			$q = '';
		}


		/*$extras = '?';
		if($this->input->get()){
			$extras = $this->input->get();

			//exclude service and auction parameters
			unset($extras['service']);
			unset($extras['auction']);
		}*/

		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_api_query($main_cat = '', $sub_cat = '', $sub_sub_cat = '', $sub_sub_sub_cat = '', $location, $suburb, $price_from, $price_to ,$main_cat_id  ,$sub_cat_id , $sub_sub_cat_id , $sub_sub_sub_cat_id, $q, $extras,$certified, $autohaus, $reference, $sort, $q, $bus_id, $limit, $offset);
		echo $this->response($o, 200);


	}
	//+++++++++++++++++++++++++++
	//TRADE/LIST - ADD Products POST
	//++++++++++++++++++++++++++
	public function add_product_post()
	{

		//VALIDATE BUSINESS ID's
		if(!$data['client_id'] = $this->post('client_id'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a client';
			$this->response($o, 200);
		}
		//VALIDATE BUSINESS ID's
		if(!$data['bus_id'] = $this->post('bus_id'))
		{
			$data['bus_id'] = '0';
		}
		//VALIDATE TITLE
		if(!$data['title'] = $this->post('item_title'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a title';
			$this->response($o, 200);
		}
		//VALIDATE CATEGORY
		if(!$data['cat1'] = $this->post('cat1'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a category';
			$this->response($o, 200);
		}
		//VALIDATE CATEGORY
		if(!$data['cat2'] = $this->post('cat2'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a category';
			$this->response($o, 200);
		}
		//VALIDATE CATEGORY
		if(!$data['cat3'] = $this->post('cat3'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a category';
			$this->response($o, 200);
		}
		//VALIDATE CATEGORY
		if(!$data['cat4'] = $this->post('cat4'))
		{
			$data['cat4'] = 0;
		}
		//VALIDATE BODY
		if(!$data['body'] = $this->post('item_content'))
		{
			$data['body'] = '';
		}
		//VALIDATE EXTRAS
		if(!$data['extras'] = $this->post('extras'))
		{
			$data['extras'] = '';
		}

		//VALIDATE FEATURES
		if(!$data['features'] = $this->post('features'))
		{
			$data['features'] = '';
		}

		//VALIDATE PROPERTY PARAMETERS
		if(!$data['sale_price'] = $this->post('price'))
		{
			$data['sale_price'] = '';
		}
		if(!$data['cents'] = $this->post('price_c'))
		{
			$data['cents'] = '';
		}
		if(!$data['location'] = $this->post('location'))
		{
			$data['location'] = '';
		}
		if(!$data['suburb'] = $this->post('suburb'))
		{
			$data['suburb'] = '';
		}
		if(!$data['quantity'] = $this->post('quantity'))
		{
			$data['quantity'] = 1;
		}
		if(!$data['start'] = $this->post('dpstart'))
		{
			$data['start'] = '';
		}
		if(!$data['end'] = $this->post('dpend'))
		{
			$data['end'] = '';
		}
		if(!$data['listing_ref'] = $this->post('listing_ref'))
		{
			$data['listing_ref'] = '';
		}
		$this->load->model('product_model');
		$o = $this->product_model->add_product($data);
		$this->response($o, 200);
	}
	
	//+++++++++++++++++++++++++++
	//TRADE/LIST - ADD Classifed POST
	//++++++++++++++++++++++++++
	public function add_classified_post()
	{

		//VALIDATE BUSINESS ID's
		if(!$data['client_id'] = $this->post('client_id'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a client';
			$this->response($o, 200);
		}
		//VALIDATE BUSINESS ID's
		if(!$data['bus_id'] = $this->post('bus_id'))
		{
			$data['bus_id'] = '0';
		}
		//VALIDATE TITLE
		if(!$data['title'] = $this->post('item_title'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a title';
			$this->response($o, 200);
		}
		
		//VALIDATE BODY
		if(!$data['body'] = $this->post('item_content'))
		{
			$data['body'] = '';
		}
		//VALIDATE PUBLICATIONS
		if(!$data['pub_id'] = $this->post('pub_id'))
		{
			$data['pub_id'] = '';
		}
		//VALIDATE PUBLICATIONS
		if(!$data['ed_id'] = $this->post('ed_id'))
		{
			$data['ed_id'] = '';
		}
		//VALIDATE PUBLICATIONS
		if(!$data['pub_bus_id'] = $this->post('pub_bus_id'))
		{
			$data['pub_bus_id'] = '';
		}
		
		if(!$data['cl_cat_id'] = $this->post('cl_cat_id'))
		{
			$data['cl_cat_id'] = '';
		}
		if(!$data['location'] = $this->post('location'))
		{
			$data['location'] = '';
		}
		if(!$data['suburb'] = $this->post('suburb'))
		{
			$data['suburb'] = '';
		}
		
		if(!$data['start'] = $this->post('dpstart'))
		{
			$data['start'] = '';
		}
		if(!$data['end'] = $this->post('dpend'))
		{
			$data['end'] = '';
		}
		$this->load->model('classified_model');
		$o = $this->classified_model->add_classified($data);
		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//TRADE/CATEGORIES - GET ALL
	//++++++++++++++++++++++++++
	public function categories_get()
	{
		//MAIN CAT
		if(!$data['main_cat_id'] = $this->get('main_cat_id'))
		{

		}
		//SUB CAT
		if(!$data['sub_cat_id'] = $this->get('sub_cat_id'))
		{

		}
		//MAIN CAT
		if(!$data['sub_sub_cat_id'] = $this->get('sub_sub_cat_id'))
		{

		}
		//MAIN CAT
		if(!$data['sub_sub_sub_cat_id'] = $this->get('sub_sub_sub_cat_id'))
		{

		}
		
		//CAT
		if(!$data['cat_id'] = $this->get('cat_id'))
		{

		}

		$this->load->model('product_model');
		$o = $this->product_model->get_categories($data);
		$this->response($o, 200);



	}


	//+++++++++++++++++++++++++++
	//TRADE/CATEGORIES - GET ALL
	//++++++++++++++++++++++++++
	public function category_get()
	{

		
		//CAT
		$data['cat_id'] = $this->get('cat_id');

		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_category($data);
		$this->response($o, 200);



	}	
	
	
	function agents_get() {

		//BUS ID
		$bus_id = $this->get('bus_id');
		
		//VALIDATE PAGINATION INPUT
		if(!$user_array = $this->get('user_array'))
		{
			$user_array = '';

		} else {
			
			$user_array = $this->get('user_array');
			
		}
		
		if(!$client_id = $this->get('client_id'))
		{
			$client_id = '';

		} else {
			
			$client_id = $this->get('client_id');
			
		}
		
		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_api_agents($bus_id,$user_array,$client_id);

		echo $this->response($o, 200);				
		
	}


	function product_get() {

		$product_id = $this->get('product_id');

		$bus_id = $this->get('bus_id');

		if(isset($bus_id)) {

			$bus_id = $this->get('bus_id');

		} else {

			$bus_id = 'null';

		}

		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_api_product($product_id, $bus_id);

		$this->response($o, 200);

	}



	function business_get() {

		$bus_id = $this->get('bus_id');

		$this->load->model('trade_search_model');
		$o = $this->trade_search_model->get_api_businesses($bus_id);

		$this->response($o, 200);

	}
	
	

	//+++++++++++++++++++++++++++
	//USERS - FIND USERS GET
	//++++++++++++++++++++++++++
	public function find_client_get()
	{
		if($str = $this->get('q', TRUE)){
			
			$this->load->model('sell_model');
			$o = $this->sell_model->find_users(urldecode($str));	
		}else{
			
			$o['success'] = false;
				
		}
		$this->response($o, 200);
	}



	//+++++++++++++++++++++++++++
	//USERS - FIND USERS GET
	//++++++++++++++++++++++++++
	public function find_business_get()
	{
		if($str = $this->get('q', TRUE)){

			$this->load->model('sell_model');
			$o = $this->sell_model->find_business(urldecode($str));
		}else{

			$o['success'] = false;

		}
		$this->response($o, 200);
	}



	//+++++++++++++++++++++++++++
	//TRADE/LIST - ADD Products OPTIONS
	//++++++++++++++++++++++++++
	public function add_product_image_options()
	{
		$this->output->set_header("Access-Control-Allow-Origin: https://nmh.my.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: *' );
		$this->output->set_content_type( 'text/html' );
		$this->output->_display();
	}
	//+++++++++++++++++++++++++++
	//TRADE/LIST - ADD Products POST
	//++++++++++++++++++++++++++
	public function add_product_image_head()
	{
		
	}
	//+++++++++++++++++++++++++++
	//TRADE/LIST - ADD Products POST
	//++++++++++++++++++++++++++
	public function add_product_image_get()
	{
		
	}
	
	//+++++++++++++++++++++++++++
	//TRADE/LIST - REMOVE PRODUCT IMAGE
	//++++++++++++++++++++++++++
	public function remove_product_image_get()
	{
		
		
	}
	//+++++++++++++++++++++++++++
	//TRADE/LIST - REMOVE PRODUCT IMAGE
	//++++++++++++++++++++++++++
	public function remove_product_image_post()
	{
		//VALIDATE BUSINESS ID's
		if(!$data['type'] = $this->post('type'))
		{
			$data['type'] = 'classifieds';
		}
		//VALIDATE BUSINESS ID's
		if(!$data['type_id'] = $this->post('type_id'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a product';
			$this->response($o, 200);
		}
		
		if($data['type'] == 'product'){
			

			$this->load->model('product_model');
			$o = $this->product_model->delete_product_image($data['type_id']);
		}else{
			$this->load->model('classified_model');
			$o = $this->classified_model->delete_classified_image($data['type_id']);
		}
		
		$this->response($o, 200);
		
	}
	//+++++++++++++++++++++++++++
	//TRADE/LIST - REMOVE PRODUCT IMAGE
	//++++++++++++++++++++++++++
	public function remove_product_post()
	{
		//VALIDATE BUSINESS ID's
		if(!$data['type'] = $this->post('type'))
		{
			$data['type'] = 'classifieds';
		}
		//VALIDATE BUSINESS ID's
		if(!$data['type_id'] = $this->post('type_id'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a product';
			$this->response($o, 200);
		}
		
		if($data['type'] == 'product'){
			

			$this->load->model('product_model');
			$o = $this->product_model->delete_product($data['type_id']);
		}else{
			$this->load->model('classified_model');
			$o = $this->classified_model->delete_classified($data['type_id']);
		}
		
		$this->response($o, 200);
		
	}
	
	//+++++++++++++++++++++++++++
	//TRADE/LIST - ADD Products POST
	//++++++++++++++++++++++++++
	public function add_product_image_post()
	{
		//VALIDATE BUSINESS ID's
		if(!$data['type'] = $this->post('type'))
		{
			$data['type'] = 'product';
		}
		//VALIDATE BUSINESS ID's
		if(!$data['type_id'] = $this->post('type_id'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a product';
			$this->response($o, 200);
		}else{
			
			if($data['type'] == 'product'){
				
				$_POST['product_id'] = $data['type_id'];
			}else{
				
				$_POST['product_id'] = $data['type_id'];
			}
			
		}

		/*//VALIDATE TITLE
		if(!$data['img_file'] = $this->post('img_file'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide a image';
			$this->response($o, 200);
		}*/
		//VALIDATE sequence
		/*if(!$data['sequence'] = $this->post('sequence'))
		{
			$data['sequence'] = 0;
		}*/
		
		$this->load->model('trade_model');
		$o = $this->trade_model->add_product_images();
		$this->response($o, 200);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */