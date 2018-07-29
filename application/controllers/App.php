<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
require APPPATH.'/libraries/REST_Controller.php';

class App extends REST_Controller{

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


	//+++++++++++++++++++++++++++
	//USERS - FIND USERS GET
	//++++++++++++++++++++++++++
	public function find_client_get()
	{
		if($str = $this->get('q', TRUE)){
			
			$this->load->model('sell_model');
			$o = $this->app_model->find_users(urldecode($str));	
		}else{
			
			$o['success'] = false;
				
		}
		$this->response($o, 200);
	}




	//+++++++++++++++++++++++++++
	//REGISTER TOURISM FUNCTIONS
	//++++++++++++++++++++++++++
	function register_tourism_post()
	{
		//VALIDATE INPUT
		$o['success'] = false;
		if(!$fname = $this->post('firstname'))
		{
			$o['success'] = false;
			$o['msg'] = 'PLease provide us with your Full Name';
			$this->response($o, 200);
		}
		if(!$sname = $this->post('lastname'))
		{
			$sname = '';
		}
		if(!$pass = $this->post('password'))
		{
			$o['msg'] = 'PLease provide us with your secure password';
			$this->response($o, 200);
		}
		if(!$cell = $this->post('cellphone'))
		{
			$cell = '';
		}
		if(!$dial_code = $this->post('dial_code'))
		{
			$dial_code = '';
		}
		if(!$email = $this->post('email'))
		{
			$o['msg'] = 'PLease provide us with your email address';
			$this->response($o, 200);
		}
		if(!$company = $this->post('company'))
		{
			$o['msg'] = 'PLease provide us with your company';
			$this->response($o, 200);
		}
		if(!$title = $this->post('title'))
		{
			$o['msg'] = 'PLease provide us with your occupation title';
			$this->response($o, 200);
		}
		if(!$workshop = $this->post('workshop'))
		{
			$o['msg'] = 'PLease provide us with a workshop';
			$this->response($o, 200);
		}

		$this->load->model('app_model');
		$o = $this->app_model->register_tourism($email, $fname, $sname, $dial_code, $cell, $pass, $company, $title, $workshop);
		$this->response($o, 200);
		
	} 
 
 


	//+++++++++++++++++++++++++++
	//CLIENT LOOKUP
	//++++++++++++++++++++++++++
	function client_get()
	{

		if(!$a['client_id'] = $this->get('client_id'))
		{
			$a['client_id'] = 0;
		}

		if(!$a['number'] = $this->get('number'))
		{
			$a['number'] = null;
		}
		$this->load->model('app_model');
		$o = $this->app_model->client_get($a);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//FORGOT PASSWORD
	//++++++++++++++++++++++++++
	function forgot_password_get()
	{
		//error_reporting(E_ALL);

		if(!$email = $this->get('email')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid email';
			
			$this->response($o, 200);

		}
		$this->load->model('app_model');
		$o = $this->app_model->forgot_password($email);

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//FORGOT PASSWORD
	//++++++++++++++++++++++++++
	function forgot_password_post()
	{
		//error_reporting(E_ALL);

		if(!$email = $this->post('email')){

			$o['success'] = false;
			$o['msg'] = 'Please provide us with a valid email';

			$this->response($o, 200);

		}
		$this->load->model('app_model');
		$o = $this->app_model->forgot_password($email);

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function test_get()
	{
		error_reporting(E_ALL);
		$this->load->model('app_model');
		$db = $this->app_model->connect_nmh_db();
		
		$this->response('Wohooo', 200);

	}
	//+++++++++++++++++++++++++++
	//GET COUNTRIES
	//++++++++++++++++++++++++++
	function countries_get()
	{

		$q = $this->db->get('a_country');
		$o = $q->result();

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET COUNTRIES
	//++++++++++++++++++++++++++
	function countries_post()
	{

		$q = $this->db->get('a_country');
		$o = $q->result();

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET COUNTRIES
	//++++++++++++++++++++++++++
	function cities_post()
	{

		if(!$client_id = $this->post('client_id'))
		{
			$client_id = 0;
		}
		if(!$country_id = $this->post('country_id'))
		{
			$country_id = 151;
		}
		$q = $this->db->select('ID,MAP_LOCATION,COUNTRY_ID,MAP_LATITUDE,MAP_LONGITUDE');
		$q = $this->db->where('COUNTRY_ID', $country_id);
		$q = $this->db->get('a_map_location');
		$o = $q->result();

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET COUNTRIES
	//++++++++++++++++++++++++++
	function cities_get()
	{


		if(!$client_id = $this->get('client_id'))
		{
			$client_id = 0;
		}
		if(!$country_id = $this->get('country_id'))
		{
			$country_id = 151;
		}
		$q = $this->db->select('ID,MAP_LOCATION,COUNTRY_ID,MAP_LATITUDE,MAP_LONGITUDE');
		$q = $this->db->where('COUNTRY_ID', $country_id);
		$q = $this->db->get('a_map_location');
		$o = $q->result();

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET COUNTRIES
	//++++++++++++++++++++++++++
	function suburbs_post()
	{


		if(!$client_id = $this->post('client_id'))
		{
			$client_id = 0;
		}
		if(!$city_id = $this->post('city_id'))
		{
			$city_id = 16;
		}
		$q = $this->db->select('ID,SUBURB_NAME,SUBURB_LATITUDE,SUBURB_LONGITUDE');
		$q = $this->db->where('CITY_ID', $city_id);
		$q = $this->db->get('a_map_suburb');
		$o = $q->result();

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//GET COUNTRIES
	//++++++++++++++++++++++++++
	function suburbs_get()
	{


		if(!$client_id = $this->get('client_id'))
		{
			$client_id = 0;
		}
		if(!$city_id = $this->get('city_id'))
		{
			$city_id = 16;
		}
		$q = $this->db->select('ID,SUBURB_NAME,SUBURB_LATITUDE,SUBURB_LONGITUDE');
		$q = $this->db->where('CITY_ID', $city_id);
		$q = $this->db->get('a_map_suburb');
		$o = $q->result();

		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//REGISTER FUNCTIONS
	//++++++++++++++++++++++++++
	function register_post()
	{
		//VALIDATE INPUT
		$o['success'] = false;
		if(!$fname = $this->post('firstname'))
		{
			$o['success'] = false;
			$o['msg'] = 'PLease provide us with your Full Name';
			$this->response($o, 200);
		}
		if(!$sname = $this->post('lastname'))
		{
			$sname = '';
		}

		if(!$pass = $this->post('password'))
		{
			$o['msg'] = 'PLease provide us with your secure password';
			$this->response($o, 200);
		}
		if(!$cell = $this->post('cellphone'))
		{
			$cell = '';

		}
		if(!$dial_code = $this->post('dial_code'))
		{
			$dial_code = '';
		}
		if(!$email = $this->post('email'))
		{
			$o['msg'] = 'PLease provide us with your email address';
			$this->response($o, 200);
		}
		$this->load->model('app_model');
		$o = $this->app_model->register($email, $fname, $sname, $dial_code,$cell,$pass);
		$this->response($o, 200);
		
	}

	//+++++++++++++++++++++++++++
	//REGISTER FUNCTIONS
	//++++++++++++++++++++++++++
	function update_client_post()
	{
		error_reporting(E_ALL);
		//VALIDATE INPUT
		$o['success'] = false;
		if(!$client_id = $this->post('client_id'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide us with your account alias';
			$this->response($o, 200);
		}
		if(!$fname = $this->post('firstname'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide us with your Full Name';
			$this->response($o, 200);
		}
		if(!$email = $this->post('email'))
		{
			$o['success'] = false;
			$o['msg'] = 'Please provide us with your Email';
			$this->response($o, 200);
		}
		$this->load->model('app_model');
		$this->load->model('members_model');									//$client_id, $email, $fname, $sname,$gender, $dial_code,$cell, $dob, $med, $contact,$location,$occupation ,$pass, $pass_new
		$o = $this->app_model->update_client($client_id, $email,  $fname);
		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login_post()
	{
		$this->load->model('app_model');

		$o['success'] = false;
		$o['error'] = true;
		//VALIDATE INPUT
		if(!$uname = $this->post('username'))
		{
			$o['msg'] = 'PLease provide us with your credentials';
			$this->response($o, 200);
		}
		if(!$pass = $this->post('password'))
		{
			$o['msg'] = 'PLease provide us with your credentials';
			$this->response($o, 200);
		}

		$o = $this->app_model->login($uname, $pass);
		$this->response($o, 200);

	}
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login_get()
	{

		$o['success'] = false;
		$o['error'] = true;
		//VALIDATE INPUT
		if(!$uname = $this->get('username'))
		{
			$o['msg'] = 'PLease provide us with your credentials';
			$this->response($o, 200);
		}
		if(!$pass = $this->get('password'))
		{
			$o['msg'] = 'PLease provide us with your credentials';
			$this->response($o, 200);
		}

		$o = $this->app_model->login($uname, $pass);

		$this->response($o, 200);


	}

	//+++++++++++++++++++++++++++
	//GET EMERGANCY CONTACTS
	//++++++++++++++++++++++++++
	function contacts_get()
	{

		if(!$client_id = $this->get('client_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid client_id';

			$this->response($o, 200);

		}
		//GET CLIENT FULL DETAILS AND CONTACT
		$user = $this->db->query("SELECT * FROM u_client_contacts WHERE client_id = '".$client_id."' ORDER BY sequence ASC");

		if($user->result()){

			$o['success'] = true;
			$o['msg'] = '';
			$o['contacts'] = $user->result_array();


		}else{

			$o['success'] = true;
			$o['msg'] = 'No Contacts Added';

		}

		$this->response($o, 200);
	}

	//+++++++++++++++++++++++++++
	//GET EMERGANCY CONTACTS
	//++++++++++++++++++++++++++
	function contacts_post()
	{
		if(!$client_id = $this->post('client_id')){

			$o['success'] = false;
			$o['msg'] = 'PLease provide us with a valid client_id';

			$this->response($o, 200);

		}
		//GET CLIENT FULL DETAILS AND CONTACT
		$user = $this->db->query("SELECT * FROM u_client_contacts WHERE client_id = '".$client_id."' ORDER BY sequence ASC");

		if($user->result()){

			$o['success'] = true;
			$o['msg'] = '';
			$o['contacts'] = $user->result_array();


		}else{

			$o['success'] = true;
			$o['msg'] = 'No Contacts Added';

		}
		$this->response($o, 200);
	}


	//+++++++++++++++++++++++++++
	//PUBLICATIONS
	//++++++++++++++++++++++++++
	function publications_get()
	{
		
		
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_nmh_db();
		
		$q = $db->select('pub_id, title, edition_id, bus_id');
		$q = $db->get('publications');
		
		if($q->result()){
			
			$this->response($q->result(), 200);
		}else{
			
			$this->response('No Publications', 200);	
		}
		

	}
	
	//+++++++++++++++++++++++++++
	//INTERESTS GET
	//++++++++++++++++++++++++++
	function interests_get()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->get('client_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$id = 0;
		}
		$this->load->model('nmh_model');
		$this->load->model('app_model');
		$o = $this->app_model->get_interests($id);

		$this->response($o, 200);
	}
		
	//+++++++++++++++++++++++++++
	//INTERESTS POST
	//++++++++++++++++++++++++++
	function interests_post()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->post('client_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$id = 0;
		}
		$this->load->model('nmh_model');
		$this->load->model('app_model');
		$o = $this->app_model->get_interests($id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//UPADET INTERESTS
	//++++++++++++++++++++++++++
	function update_interests_post()
	{
		//VALIDATE INPUT
		$o['success'] = false;
		if(!$id = $this->post('client_id'))
		{
			$o['msg'] = 'No CLient specified';
			$this->response($o, 200);
		}
		//VALIDATE INPUT
		if(!$publications = $this->post('publications'))
		{
			$o['msg'] = 'No Publications specified';
			$this->response($o, 200);
		}
		//VALIDATE INPUT
		if(!$categories = $this->post('categories'))
		{
			$o['msg'] = 'No Categories specified';
			$this->response($o, 200);
		}
		//CLEAN CURRENT
		$i = $this->db->query("DELETE FROM my_na_interests WHERE client_id = '".$id."'",TRUE);
		if(is_array($publications)){
			$pubs = $publications;
		}else{
			$pubs = explode(',',$publications);
		}

		
		if(count($pubs) > 0){
			
			foreach($pubs as $row){
				
				$insertdata = array(
					'client_id' => $id,
					'type' => 'publications',
					'type_id' => (int)$row,
					'created_at' => date('Y-m-d H;i:s'),
				
				);
				$this->db->insert('my_na_interests', $insertdata);
			}
			
		}
		
		if(is_array($categories)){
			$cats = $categories;
		}else{
			$cats = explode(',',$categories);
		}
		if(count($cats) > 0){
			
			foreach($cats as $crow){
				
				$insertdata = array(
					'client_id' => $id,
					'type' => 'categories',
					'type_id' => $crow,
					'created_at' => date('Y-m-d H;i:s'),
				
				);
				$this->db->insert('my_na_interests', $insertdata);
			}
			
		}
		$o['success'] = true;
		$o['msg'] = 'Thanks, we have received your interests.';
		
		$this->response($o, 200);
		
		
	}


	//+++++++++++++++++++++++++++
	//CATEGORIES CONTENT GET
	//++++++++++++++++++++++++++
	function category_content_get()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->get('cat_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$id = 0;
		}
		if(!$title_group = $this->get('title_group'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$title_group = '';
		}
		//VALIDATE INPUT
		if(!$pub_id = $this->get('pub_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$pub_id = 0;
		}
		if(!$limit = $this->get('limit'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$limit = 10;
		}
		if(!$offset = $this->get('offset'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$offset = 0;
		}
		if(!$post_id = $this->get('post_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$post_id = null;
		}
		$this->load->model('nmh_model');
		$this->load->model('app_model');
		$o = $this->app_model->get_category_content($id,$pub_id, $limit , $offset,$title_group, $post_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//CATEGORIES CONTENT POST
	//++++++++++++++++++++++++++
	function category_content_post()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->post('cat_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$id = 0;
		}
		if(!$title_group = $this->post('title_group'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$title_group = '';
		}
		//VALIDATE INPUT
		if(!$pub_id = $this->post('pub_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$pub_id = 0;
		}

		if(!$limit = $this->post('limit'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$limit = 10;
		}
		if(!$offset = $this->post('offset'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$offset = 0;
		}
		$this->load->model('nmh_model');
		$this->load->model('app_model');
		$o = $this->app_model->get_category_content($id,$pub_id, $limit , $offset, $title_group, $post_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//PUBLICATION CONTENT GET
	//++++++++++++++++++++++++++
	function publication_content_get()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->get('pub_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$id = 0;
		}
		if(!$limit = $this->get('limit'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$limit = 10;
		}
		if(!$offset = $this->get('offset'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$offset = 0;
		}
		$this->load->model('nmh_model');
		$this->load->model('app_model');
		$o = $this->app_model->get_publication_content($id, $limit , $offset);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//PUBLICATION CONTENT POST
	//++++++++++++++++++++++++++
	function publication_content_post()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->post('pub_id'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$id = 0;
		}
		if(!$limit = $this->post('limit'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$limit = 10;
		}
		if(!$offset = $this->post('offset'))
		{
			//$o['msg'] = 'No CLient specified';
			//$this->response($o, 200);
			$offset = 0;
		}
		$this->load->model('nmh_model');
		$this->load->model('app_model');
		$o = $this->app_model->get_publication_content($id, $limit , $offset);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//NA CONTENT POST
	//++++++++++++++++++++++++++
	function na_content_post()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->post('type_id'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No Content identifier specified';
			$this->response($o, 200);
			
		}
		if(!$type = $this->post('type'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No Type specified';
			$this->response($o, 200);
			
		}
		if(!$client_id = $this->post('client_id'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No CLient specified';
			$this->response($o, 200);
			
		}
		$this->load->model('nmh_model');
		//$this->load->model('app_model');
		$o = $this->nmh_model->na_content($id, $type, $client_id);

		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//NA CONTENT GET
	//++++++++++++++++++++++++++
	function na_content_get()
	{
		//error_reporting(E_ALL);
		//VALIDATE INPUT
		if(!$id = $this->get('type_id'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No Content identifier specified';
			$this->response($o, 200);
			
		}
		if(!$social_type = $this->get('social_type'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No Social identifier specified';
			$this->response($o, 200);
			
		}
		if(!$type = $this->get('type'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No Type specified';
			$this->response($o, 200);
			
		}
		if(!$client_id = $this->get('client_id'))
		{
			$o['msg'] = false;
			$o['msg'] = 'No CLient specified';
			$this->response($o, 200);
			
		}
		$this->load->model('nmh_model');
		//$this->load->model('app_model');
		$o = $this->nmh_model->na_content($id, $type, $client_id,$social_type);

		$this->response($o, 200);
	}


	//+++++++++++++++++++++++++++
	//GET ALL CURRENT PROMOTIONS
	//+++++++++++++++++++++++++++
	public function current_promotions_get()
	{

		$uSQL = '';
		$user_id = 0;
		if(!$user_id = $this->get('client_id')){
			$o['success'] = false;
			$o['msg'] = 'There are no current active clients';
			$this->response($o, 200);
		}
		$this->load->model('app_model');
		$o = $this->app_model->current_promotions($user_id);
		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET ALL CURRENT PROMOTIONS POST
	//+++++++++++++++++++++++++++
	public function current_promotions_post()
	{

		$uSQL = '';
		$user_id = 0;
		if(!$user_id = $this->post('client_id')){
			$o['success'] = false;
			$o['msg'] = 'There are no current active clients';
			$this->response($o, 200);
		}

		$this->load->model('app_model');
		$o = $this->app_model->current_promotions($user_id);
		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET ALL CURRENT PROMOTIONS POST
	//+++++++++++++++++++++++++++
	public function current_vouchers_get()
	{

		$uSQL = '';

		if(!$user_id = $this->get('client_id')){
			$o['success'] = false;
			$o['msg'] = 'No Client specified';
			$this->response($o, 200);
		}

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();


		$query = $db->query("SELECT scratch_promotion_vouchers.*,scratch_prizes.IMAGE_URL as voucher_prize_img,scratch_promotion.APP_VOUCHER_ICON as voucher_icon,
						images.img_file,
						scratch_promotion.END_DATE as end_date, 
						scratch_promotion.NAME as title, scratch_promotion.BODY as body
						FROM scratch_promotion_vouchers
						JOIN scratch_promotion ON scratch_promotion.ID = scratch_promotion_vouchers.promotion_id
						LEFT JOIN scratch_winners ON scratch_winners.ID = scratch_promotion_vouchers.win_id
						LEFT JOIN scratch_prizes ON scratch_prizes.ID = scratch_winners.PRIZE_ID
						LEFT JOIN images ON images.type_id = scratch_promotion.ID AND images.type = 'promotion_icon'
						WHERE scratch_promotion_vouchers.claimed = 'N' AND scratch_promotion_vouchers.client_id = ".$user_id." AND scratch_promotion.END_DATE > CURRENT_DATE()
						ORDER BY scratch_promotion_vouchers.voucher_id ASC
						");

		if($query->result()){
			$a = array();
			foreach($query->result() as $row){
				
				if($row->voucher_prize_img != NULL){
					
					$row->voucher_icon = EVENTS_URL.'assets/prizes/'.$row->voucher_prize_img;
					
				}else{

					$row->voucher_icon = EVENTS_URL.'assets/images/'.$row->img_file;
				}
				array_push($a,$row);	
				
			}

			$o['vouchers'] = $a;
			$o['success'] = true;


		}else{

			$o['success'] = false;
			$o['msg'] = 'You have no active vouchers';


		}
		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET ALL CURRENT PROMOTIONS POST
	//+++++++++++++++++++++++++++
	public function current_vouchers_post()
	{

		$uSQL = '';

		if(!$user_id = $this->post('client_id')){
			$o['success'] = false;
			$o['msg'] = 'No Client specified';
			$this->response($o, 200);
		}

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();


		$query = $db->query("SELECT scratch_promotion_vouchers.*,scratch_prizes.IMAGE_URL as voucher_prize_img,scratch_promotion.APP_VOUCHER_ICON as voucher_icon,
						images.img_file,
						scratch_promotion.END_DATE as end_date,
						scratch_promotion.NAME as title, scratch_promotion.BODY as body
						FROM scratch_promotion_vouchers
						JOIN scratch_promotion ON scratch_promotion.ID = scratch_promotion_vouchers.promotion_id
						LEFT JOIN scratch_winners ON scratch_winners.ID = scratch_promotion_vouchers.win_id
						LEFT JOIN scratch_prizes ON scratch_prizes.ID = scratch_winners.PRIZE_ID
						LEFT JOIN images ON images.type_id = scratch_promotion.ID AND images.type = 'promotion_icon'
						WHERE scratch_promotion_vouchers.claimed = 'N' AND scratch_promotion_vouchers.client_id = ".$user_id." AND scratch_promotion.END_DATE > CURRENT_DATE()
						ORDER BY scratch_promotion_vouchers.voucher_id ASC
						");

		if($query->result()){
			$a = array();
			foreach($query->result() as $row){

				if($row->voucher_prize_img != NULL){

					$row->voucher_icon = EVENTS_URL.'assets/prizes/'.$row->voucher_prize_img;

				}else{

					$row->voucher_icon = EVENTS_URL.'assets/images/'.$row->img_file;
				}

				array_push($a,$row);	
				
			}

			$o['vouchers'] = $a;
			$o['success'] = true;



		}else{

			$o['success'] = false;
			$o['msg'] = 'You have no active vouchers';


		}
		$this->response($o, 200);
	}

	//+++++++++++++++++++++++++++
	//SUBMIT EVENT RATING
	//+++++++++++++++++++++++++++
	public function submit_rating_post()
	{

		$uSQL = '';
		$bus_id = 2713;
		if(!$client_id = $this->post('client_id')){
			$o['success'] = false;
			$o['msg'] = 'No Client identifier specified';
			$this->response($o, 200);
		}

		if(!$event_id = $this->post('event_id')){
			$o['success'] = false;
			$o['msg'] = 'No Event identifier specified';
			$this->response($o, 200);
		}

		if(!$exhibitor_id = $this->post('exhibitor_id')){
			$o['success'] = false;
			$o['msg'] = 'No Exhibitor identifier specified';
			$this->response($o, 200);
		}
		if(!$promotion_id = $this->post('promotion_id')){
			//BiltongFees Touch n Win
			$promotion_id = 18;
		}
		$feedback = $this->post('rate-feedback');

		$rating_1 = $this->post('rating-label-result-1');
		$rating_2 = $this->post('rating-label-result-2');
		$rating_3 = $this->post('rating-label-result-3');

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();

		//TEST IF USER RATED EXHIBITOR
		$exist = $db->where('event_id', $event_id);
		$exist = $db->where('user_id', $client_id);
		$exist = $db->where('exhibitor_id', $exhibitor_id);
		$exist = $db->get('exhibitor_ratings');

		if($exist->result()){

			$o['success'] = false;
			$o['msg'] = 'You have already rated this exhibitor';
			$this->response($o, 200);
		}else{

			//GET PROMOTION ID
			$event = $db->where('event_id', $event_id);
			$event = $db->get('calendar_events');

			if($event->result()){
				$eventrow = $event->row();
				$promotion_id = $eventrow->promotion_id;
			}

			$rating_hash = md5(strtotime("now") . $client_id . rand(0, 999));
			for ($i=1; $i < 4; $i++) {
					$label = "Interactive & Engaging";
					$value = $rating_1;
				if($i == 2) {
					$feedback = "";
					$label = "Visual Appeal";
					$value = $rating_2;
				} else if($i == 3) {
					$feedback = "";
					$label = "Wow Factor";
					$value = $rating_3;
				}

				$in = array(

					'user_id' => $client_id,
					'event_id' => $event_id,
					'exhibitor_id' => $exhibitor_id,
					'bus_id' => $bus_id,
					'rating_hash' => $rating_hash,
					'rating_label' => $label,
					'rating_value' => $value,
					'rating_feedback' => $feedback,
					'created_at' => 'NOW()',
					'promotion_id' => $promotion_id,
				);


				$db->insert('exhibitor_ratings', $in);
				

			}
			
			$insert = array(
					'promo_id' => $promotion_id,
					'client_id' => $client_id
			);
			$db->insert('scratch_promotion_scans', $insert);
			$this->load->model('app_model');
			$this->app_model->rating_vouchers_badges($client_id, $promotion_id);

			$o['success'] = true;
			$o['msg'] = 'Thanks, you have rated successfully.';

		}

		$this->response($o, 200);
	}

	//+++++++++++++++++++++++++++
	//SCAN PROMOTION QR CODE
	//+++++++++++++++++++++++++++
	public function scan_promo_get()
	{
		
		if(!$client_id = $this->get('client_id')){
			$o['success'] = false;
			$o['msg'] = 'No Client identifier specified';
			$this->response($o, 200);
		}
		if(!$promo_id = $this->get('promo_id')){
			$o['success'] = false;
			$o['msg'] = 'No Promo ID specified';
			$this->response($o, 200);
		}
		$this->load->model('app_model');
		$o = $this->app_model->scan_promo($client_id, $promo_id);
		$this->response($o, 200);
	}

	//+++++++++++++++++++++++++++
	//CLAIM VOUCHER
	//+++++++++++++++++++++++++++
	public function claim_voucher_post()
	{
		//error_reporting(E_ALL);
		$uSQL = '';
		$bus_id = 2713;
		$points = 0;
		if(!$client_id = $this->post('client_id')){
			$o['success'] = false;
			$o['msg'] = 'No Client identifier specified';
			$this->response($o, 200);
		}
		if(!$voucher_id = $this->post('voucher_id')){
			$o['success'] = false;
			$o['msg'] = 'No Voucher ID specified';
			$this->response($o, 200);
		}
		if(!$voucher = $this->post('voucher')){
			$o['success'] = false;
			$o['msg'] = 'No Voucher specified';
			$this->response($o, 200);
		}
		if(!$type = $this->post('type')){
			$o['success'] = false;
			$o['msg'] = 'No Voucher Type specified';
			$this->response($o, 200);
		}
		if(!$promotion_id = $this->post('promotion_id')){
			$promotion_id = 14;
		}
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();
	
		//SEE IF VOUCHER CLAIMED
		$db->where('voucher_id', $voucher_id);
		$p = $db->get('scratch_promotion_vouchers');
		if($p->result()){
			$row = $p->row();
			//SEE IF ALREADY CLAIMED
			if($row->claimed == 'N'){
				//TEST VOUCHER TYE
				if($type == 'touch_n_win'){
					
					//TEST IF ALRADY PLAYED
					if($row->played_at == null){
						
						//LOAD GAME LOGIC/Results
						if($o = file_get_contents('https://events.my.na/game/load_game_app/'.$promotion_id.'/'.$client_id.'/'.$points.'/'.$voucher.'/'.$voucher_id.'/?=29129129/')){
							
							$o = (array)json_decode($o);
							//$o['link'] = 'https://events.my.na/game/load_game_app/'.$promotion_id.'/'.$client_id.'/'.$points.'/'.$voucher.'/?=29129129/';
							if($o['bool'] == TRUE){
						  
								  //WON PRIZE
								 
								 $update['win_id'] = $o['win_id'];
								  
							 }else{
								 $update['claimed'] = 'Y';
								 
							 }
							
							//UPDATE VOCUHER
							$update['played_at'] = date('y-m-d G:i:s', time());
							$db->where('voucher_id', $voucher_id);
							$db->update('scratch_promotion_vouchers', $update);
							
							//SEND WIN NOTIFICATIONS
							
						}else{
							//EVENTS MIGHT BE DOWN
							$o['msg'] = 'The Touch and Win Server is unavailable. Please try again shortly.';
							$o['success'] = false;
							
						}
					//WON A PRIZE QR CODE	
					}elseif($row->win_id != 0){
						
						 //GAME PRIZE VOUCHER
						$this->load->model('app_model');
						$qr = $this->app_model->get_qrcode('game_voucher', $row);
						$prize = $this->app_model->get_prize($row->win_id);
						$o['html'] = $qr.$prize;
						$o['msg'] = 'Here is your voucher';
						$o['success'] = true;
						
					}else{
						
						//EVENTS MIGHT BE DOWN
						$o['msg'] = 'Better luck next time';
						$o['success'] = false;
						
					}
					
				}else{
					
					//NORMAL VOUCHER
					$this->load->model('app_model');
					$qr = $this->app_model->get_qrcode('voucher', $row);
					$prize = $this->app_model->get_voucher_image($promotion_id);
					$o['msg'] = 'Here is your voucher';
					$o['success'] = false;
					$o['html'] = $qr. $prize;
				}
				
				if($o['success'] == true){
					//RESERVE
				}
			}else{
				$o['msg'] = 'Voucher Already claimed';
				$o['success'] = false;
				
			}
			
			
		}else{
			$o['msg'] = 'Voucher doesnt exist';
			$o['success'] = false;
			
		}
	
		//var_dump((array)json_decode($o));
		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//CLAIM VOUCHER
	//+++++++++++++++++++++++++++
	public function claim_voucher_get()
	{

		$uSQL = '';
		$bus_id = 2713;
		$points = 0;
		if(!$client_id = $this->get('client_id')){
			$o['success'] = false;
			$o['msg'] = 'No Client identifier specified';
			$this->response($o, 200);
		}
		if(!$voucher_id = $this->get('voucher_id')){
			$o['success'] = false;
			$o['msg'] = 'No Voucher ID specified';
			$this->response($o, 200);
		}
		if(!$voucher = $this->get('voucher')){
			$o['success'] = false;
			$o['msg'] = 'No Voucher specified';
			$this->response($o, 200);
		}
		if(!$type = $this->get('type')){
			$o['success'] = false;
			$o['msg'] = 'No Voucher Type specified';
			$this->response($o, 200);
		}
		if(!$promotion_id = $this->get('promotion_id')){
			$promotion_id = 14;
		}
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();
		
		//SEE IF VOUCHER CLAIMED
		$db->where('voucher_id', $voucher_id);
		$p = $db->get('scratch_promotion_vouchers');
		if($p->result()){
			$row = $p->row();
			
			//SEE IF ALREADY CLAIMED
			if($row->claimed == 'N'){
				//TEST VOUCHER TYE
				if($type == 'touch_n_win'){
					
					//TEST IF ALRADY PLAYED
					if($row->played_at == null){
						
						//LOAD GAME LOGIC/Results
						if($o = file_get_contents('https://events.my.na/game/load_game_app/'.$promotion_id.'/'.$client_id.'/'.$points.'/'.$voucher.'/?=29129129/')){
							
							$o = (array)json_decode($o);

							if($o['bool'] == TRUE){
						  
								  //WON PRIZE
								 
								  $update['win_id'] =$o['bool'];
								  
							 }
							
							//UPDATE VOCUHER
							$update['played_at'] = date('Y-md H:i:s');
							$db->where('voucher_id', $voucher_id);
							$db->update('scratch_promotion_vouchers', $update);
						}else{
							//EVENTS MIGHT BE DOWN
							$o['msg'] = 'The Tocuh and Win Server is unavailable. Please try again shortly.';
							$o['success'] = false;
							
						}
					//WON A PRIZE QR CODE	
					}elseif($row->win_id != 0){
						
						 //GAME PRIZE VOUCHER
						$this->load->model('app_model');
						$qr = $this->app_model->get_qrcode('game_voucher', $row);
						$prize = $this->app_model->get_prize($row->win_id);
						$o['html'] = $qr.$prize;
						$o['msg'] = 'Here is your voucher';
						$o['success'] = true;
						
					}else{
						
						//EVENTS MIGHT BE DOWN
						$o['msg'] = 'Better luck next time';
						$o['success'] = false;
						
					}
					
				}else{
					
					//NORMAL VOUCHER
					$this->load->model('app_model');
					$qr = $this->app_model->get_qrcode('voucher', $row);
					
					$o['msg'] = 'Here is your voucher';
					$o['success'] = true;
					$o['html'] = $qr;
				}
				
				if($o['success'] == true){
					//RESERVE
				}
			}else{
				$o['msg'] = 'Voucher Already claimed';
				$o['success'] = false;
				
			}
			
			
			
		}else{
			$o['msg'] = 'Voucher doesnt exist';
			$o['success'] = false;
			
		}
	
		//var_dump((array)json_decode($o));
		$this->response($o, 200);
	}

	//+++++++++++++++++++++++++++
	//2016 COKE NTE promotion
	//++++++++++++++++++++++++++
	function submit_town_post()
	{
		
		$this->load->library('user_agent');
		$agent = $agent = $this->agent->platform() .' '.$this->agent->browser().' ver : '.$this->agent->version();
		
		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){
			
			$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}else{
			
			$IP = $this->input->ip_address();
		}
		$town = $this->post('selected_town');
		$client_id = 0;
		if(!$client_id = $this->post('client_id')){

			$o['success'] = false;
			$o['msg'] = 'Who are you?';
			$this->response($o, 200);
		}
		$promotion_id = 0;
		if(!$promotion_id = $this->post('promotion_id')){
			$o['success'] = false;
			$o['msg'] = 'What promotion are you using?';
			$this->response($o, 200);
		}
		$location = '';
		if($this->post('location')){
			$location = $this->post('location');
		}
		$this->load->model('app_model');
		//TEST IF ALREADY SUBMITTED
		$temp = $this->app_model->single_vouchers_badges($client_id, $promotion_id);
		
		if(!$temp['success']){
			
			$o['success'] = false;
			$o['msg'] = $temp['msg'];
			
		}else{
			$this->load->model('nmh_model');
			$db = $this->nmh_model->connect_nmh_db();
			$input = array(
			
				'client_id' => $client_id,
				'promotion_id' => $promotion_id,
				'type' => 'scan',
				'location' => urldecode($location),
				'user_agent' => $agent,
				'ip_address' => $IP,
				'value' => $town
			);
			$db->insert('promotion_scans', $input);
			
			$o['success'] = true;
			$o['msg'] = 'Thanks, we have received your entry';
			
			
		}
		
		$this->response($o, 200);
		
	}
	//+++++++++++++++++++++++++++
	//2016 BILTONGFEES ARTISTS
	//++++++++++++++++++++++++++
	function submit_artist_post()
	{

		$this->load->library('user_agent');
		$agent = $agent = $this->agent->platform() .' '.$this->agent->browser().' ver : '.$this->agent->version();

		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){

			$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}else{

			$IP = $this->input->ip_address();
		}
		$artist = $this->post('selection');
		$client_id = 0;
		if(!$client_id = $this->post('client_id')){
			//$client_id = 1806;
			$o['success'] = false;
			$o['msg'] = 'Who are you?';
			$this->response($o, 200);
		}
		$promotion_id = 0;
		if(!$promotion_id = $this->post('promotion_id')){
			$o['success'] = false;
			$o['msg'] = 'What promotion are you using?';
			$this->response($o, 200);
		}
		$location = '';
		if($this->post('location')){
			$location = $this->post('location');
		}
		$this->load->model('app_model');
		//TEST IF ALREADY SUBMITTED
		$temp = $this->app_model->single_vouchers_badges($client_id, $promotion_id);

		if(!$temp['success']){

			$o['success'] = false;
			$o['msg'] = $temp['msg'];

		}else{
			$this->load->model('nmh_model');
			$db = $this->nmh_model->connect_nmh_db();
			$input = array(

				'client_id' => $client_id,
				'promotion_id' => $promotion_id,
				'type' => 'scan',
				'location' => urldecode($location),
				'user_agent' => $agent,
				'ip_address' => $IP,
				'value' => $artist
			);
			$db->insert('promotion_scans', $input);

			$o['success'] = true;
			$o['msg'] = 'Thanks, we have received your entry';


		}

		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//2016 COKE NTE promotion
	//++++++++++++++++++++++++++
	function submit_wine_post()
	{

		$this->load->library('user_agent');
		$agent = $agent = $this->agent->platform() .' '.$this->agent->browser().' ver : '.$this->agent->version();

		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){

			$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
		}else{

			$IP = $this->input->ip_address();
		}
		$selection = $this->post('selection');
		$category = $this->post('category');
		$client_id = 0;
		if(!$client_id = $this->post('client_id')){

			$client_id = 1806;

			/*$o['success'] = false;
			$o['msg'] = 'Who are you?';
			$this->response($o, 200);*/
		}
		$promotion_id = 0;
		if(!$promotion_id = $this->post('promotion_id')){
			$o['success'] = false;
			$o['msg'] = 'What promotion are you using?';
			$this->response($o, 200);
		}
		$location = '';
		if($this->post('location')){
			$location = $this->post('location');
		}
		$this->load->model('app_model');
		//TEST IF ALREADY SUBMITTED
		$this->load->model('nmh_model');
		//$db = $this->nmh_model->connect_nmh_db();

		$exist = $this->db->where('promotion_id', $promotion_id);
		$exist = $this->db->where('client_id', $client_id);
		$exist = $this->db->where('category', $category);
		$exist = $this->db->get('promotion_scans');


		if($exist->result()){

			$o['success'] = false;
			$o['msg'] = 'We have already received your vote for the category '.$category.' wines.';

		}else{

			$input = array(

				'client_id' => $client_id,
				'promotion_id' => $promotion_id,
				'type' => 'scan',
				'category' => $category,
				'location' => urldecode($location),
				'user_agent' => $agent,
				'ip_address' => $IP,
				'value' => $selection
			);
			$this->db->insert('promotion_scans', $input);

			$o['success'] = true;
			$o['msg'] = 'Thanks, we have received your entry';


		}

		$this->response($o, 200);

	}



	//+++++++++++++++++++++++++++
	//GET UNIQUE CODE - QR CODE
	//++++++++++++++++++++++++++
	function user_code_post()
	{
		
		if(!$id = $this->post('client_id')){

			$o['success'] = false;
			$o['msg'] = 'Who are you?';
			$this->response($o, 200); 
		}
		$this->load->model('app_model');
		$o = $this->app_model->get_qrcode_user($id);
		$this->response($o, 200);
		
	}

	//+++++++++++++++++++++++++++
	//GET UNIQUE CODE - QR CODE
	//++++++++++++++++++++++++++
	function user_code_get()
	{
		
		//error_reporting(E_ALL);
		
		if(!$id = $this->get('client_id')){

			$o['success'] = false;
			$o['msg'] = 'Who are you?';
			$this->response($o, 200);
		}
		$this->load->model('app_model');
		$o = $this->app_model->get_qrcode_user($id);
		$this->response($o, 200);
		
	}

	//+++++++++++++++++++++++++++
	//GET UNIQUE CODE - QR CODE
	//++++++++++++++++++++++++++
	function user_code_tourism_get()
	{
		
		//error_reporting(E_ALL);
		
		if(!$id = $this->get('client_id')){

			$o['success'] = false;
			$o['msg'] = 'Who are you?';
			$this->response($o, 200);
		}
		$this->load->model('app_model');
		$o = $this->app_model->get_qrcode_tourism_user($id);
		$this->response($o, 200);
		
	}


	//+++++++++++++++++++++++++++
	//GET ADVERTS
	//++++++++++++++++++++++++++
	function adverts_get()
	{

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_nmh_db();

		if(!$id = $this->get('client_id')){
			/*AND publication_content_int.bus_id = '".BUS_ID."'*/

			$query = $db->query("SELECT adverts.*, images.img_file,categories.cat_name as cat_name, group_concat(DISTINCT(keywords.keyword)) as keywords
										FROM adverts
										JOIN images ON adverts.advert_id = images.type_id AND images.type = 'advert'
										LEFT JOIN advert_cat_int ON advert_cat_int.advert_id = adverts.advert_id
										LEFT JOIN categories ON advert_cat_int.cat_id = categories.cat_id
										LEFT JOIN keyword_content_int ON keyword_content_int.type_id = adverts.advert_id AND keyword_content_int.type = 'advert'
										LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id

										WHERE adverts.status = 'live' AND adverts.start_date < NOW() AND adverts.end_date > NOW()
										AND adverts.my_info_app = 'Y'
										GROUP BY adverts.advert_id
										ORDER BY RAND() LIMIT 20", false);


		}else{
			/*AND publication_content_int.bus_id = '".BUS_ID."'*/
			$query = $db->query("SELECT adverts.*, images.img_file,categories.cat_name as cat_name, group_concat(DISTINCT(keywords.keyword)) as keywords
										FROM adverts
										JOIN images ON adverts.advert_id = images.type_id AND images.type = 'advert'
										LEFT JOIN advert_cat_int ON advert_cat_int.advert_id = adverts.advert_id
										LEFT JOIN categories ON advert_cat_int.cat_id = categories.cat_id
										LEFT JOIN keyword_content_int ON keyword_content_int.type_id = adverts.advert_id AND keyword_content_int.type = 'advert'
										LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id

										WHERE adverts.status = 'live' AND adverts.start_date < NOW() AND adverts.end_date > NOW()
										AND adverts.my_info_app = 'Y'
										GROUP BY adverts.advert_id
										ORDER BY RAND() LIMIT 20", false);



		}


		if($query->result()){

			$o['success'] = true;
			$o['adverts'] = $query->result();

		}else{

			$o['success'] = false;
			$o['msg'] = 'No live adverts';

		}


		$this->response($o, 200);

	}

	//+++++++++++++++++++++++++++
	//GET ADVERTS
	//++++++++++++++++++++++++++
	function adverts_post()
	{

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_nmh_db();

		if(!$id = $this->post('client_id')){

			$query = $db->query("SELECT adverts.*, images.img_file,categories.cat_name as cat_name, group_concat(DISTINCT(keywords.keyword)) as keywords
										FROM adverts
										JOIN images ON adverts.advert_id = images.type_id AND images.type = 'advert'
										LEFT JOIN advert_cat_int ON advert_cat_int.advert_id = adverts.advert_id
										LEFT JOIN categories ON advert_cat_int.cat_id = categories.cat_id
										LEFT JOIN keyword_content_int ON keyword_content_int.type_id = adverts.advert_id AND keyword_content_int.type = 'advert'
										LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id

										WHERE adverts.status = 'live' AND adverts.start_date < NOW() AND adverts.end_date > NOW()
										AND adverts.my_info_app = 'Y'
										GROUP BY adverts.advert_id
										ORDER BY RAND() LIMIT 20", false);


		}else{
			/*AND publication_content_int.bus_id = '".BUS_ID."'*/
			$query = $db->query("SELECT adverts.*, images.img_file,categories.cat_name as cat_name, group_concat(DISTINCT(keywords.keyword)) as keywords
										FROM adverts
										JOIN images ON adverts.advert_id = images.type_id AND images.type = 'advert'
										LEFT JOIN advert_cat_int ON advert_cat_int.advert_id = adverts.advert_id
										LEFT JOIN categories ON advert_cat_int.cat_id = categories.cat_id
										LEFT JOIN keyword_content_int ON keyword_content_int.type_id = adverts.advert_id AND keyword_content_int.type = 'advert'
										LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id

										WHERE adverts.status = 'live' AND adverts.start_date < NOW() AND adverts.end_date > NOW()
										AND adverts.my_info_app = 'Y'
										GROUP BY adverts.advert_id
										ORDER BY RAND() LIMIT 20", false);

		}


		if($query->result()){

			$o['success'] = true;
			$o['adverts'] = $query->result();

		}else{

			$o['success'] = false;
			$o['msg'] = 'No live adverts';

		}


		$this->response($o, 200);

	}


	//+++++++++++++++++++++++++++
	//SEARCH API for My.na/NMH
	//++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//POST
	//++++++++++++++++++++++++++
	function search_post()
	{

		if(!$type = $this->post('type')){

			$type = '';
		}
		if(!$limit = $this->post('limit')){

			$limit = 20;
		}
		if(!$offset = $this->post('offset')){

			$offset = 0;
		}

		if($q = $this->post('q'))
		{
			$this->load->model('app_model');
			$o = $this->app_model->search($q, $type, $limit, $offset);
		}else{

			$o['success'] = false;
			$o['msg'] = 'No search term provided';

		}


		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++
	function search_get()
	{
		if(!$type = $this->get('type')){

			$type = '';
		}
		if(!$limit = $this->get('limit')){

			$limit = 20;
		}
		if(!$offset = $this->get('offset')){

			$offset = 0;
		}
		if($q = $this->get('q'))
		{
			$this->load->model('app_model');
			$o = $this->app_model->search($q, $type, $limit, $offset);
		}else{

			$o['success'] = false;
			$o['msg'] = 'No search term provided';

		}


		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++
	function product_get()
	{

		if($id = $this->get('product_id'))
		{
			$this->load->model('app_model');
			$o = $this->app_model->product($id);
		}else{

			$o['success'] = false;
			$o['msg'] = 'No id provided';

		}


		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++
	function product_post()
	{

		if($id = $this->post('product_id'))
		{
			$this->load->model('app_model');
			$o = $this->app_model->product($id);
		}else{

			$o['success'] = false;
			$o['msg'] = 'No id provided';

		}


		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//PRODUCT CATEGORIES
	//++++++++++++++++++++++++++
	function product_category_get()
	{
		if(!$main_id = $this->get('main_cat_id')){

			$o['success'] = false;
			$o['msg'] = 'No Main category Passed';
			$this->response($o, 200);
		}
		if(!$sub_id = $this->get('sub_cat_id')){
			$sub_id = 0;
		}
		if(!$sub_sub_id = $this->get('sub_sub_cat_id')){
			$sub_sub_id = 0;
		}
		if(!$sub_sub_sub_id = $this->get('sub_sub_sub_cat_id')){
			$sub_sub_sub_id = 0;
		}
		if(!$limit = $this->get('limit')){
			$limit = 10;
		}
		if(!$offset = $this->get('offset')){
			$offset = 0;
		}
		$this->load->model('app_model');
		$o = $this->app_model->product_category($main_id, $sub_id, $sub_sub_id,$sub_sub_sub_id , $limit , $offset );
		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//BSUINESS GET
	//++++++++++++++++++++++++++
	function business_get()
	{

		if($id = $this->get('bus_id'))
		{
			$this->load->model('app_model');
			$o = $this->app_model->business($id);
		}else{

			$o['success'] = false;
			$o['msg'] = 'No id provided';

		}


		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//BUSINESS POST
	//++++++++++++++++++++++++++
	function business_post()
	{

		if($id = $this->post('bus_id'))
		{
			$this->load->model('app_model');
			$o = $this->app_model->business($id);
		}else{

			$o['success'] = false;
			$o['msg'] = 'No id provided';

		}


		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//TRIGGER EMERGENCY
	//++++++++++++++++++++++++++
	function emergency_get()
	{
		error_reporting(E_ALL);
		$this->load->model('app_model');
		$o = $this->app_model->emergency();
		$this->response($o, 200);
	}
	//+++++++++++++++++++++++++++
	//TRIGGER EMERGENCY
	//++++++++++++++++++++++++++
	function emergency_post()
	{
		$this->load->model('app_model');
		$o = $this->app_model->emergency();
		$this->response($o, 200);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */