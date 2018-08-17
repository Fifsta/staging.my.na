<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('members_model');	
		$this->load->model('business_model');
		$this->load->model('trade_model');	
	    $this->section_1 = $this->uri->segment(1);
	    $this->section_2 = $this->uri->segment(2);
	    		
	}


	public function memtest()
	{

		$this->load->view('memtest');

	}



function get_all_cache() {

		// Load the memcached library config
		$o['memcached'] = '';
		$o['file_cache'] = '';
		$o['success'] = false;
		$o['error'] = '';
		$mem = array();
		$file = array();
		$this->load->config('memcached');
		$this->config->item('memcached');

		$c = $this->config->item('memcached');
		$host = $c['servers']['default']['host'];

		$memcache = new Memcached;
		$memcache->connect($host, 11211)
		or $o['error'] = "Could not connect to memcache server";

		$list = array();
		$allSlabs = $memcache->getExtendedStats('slabs');
		$items = $memcache->getExtendedStats('items');
		$xx = 0;
		foreach($allSlabs as $server => $slabs) {
			foreach($slabs AS $slabId => $slabMeta) {
				$cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
				foreach($cdump AS $keys => $arrVal) {
					if (!is_array($arrVal)) continue;
					foreach($arrVal AS $k => $v) {
						//echo $k .'<br>';
						$t =  array(0 => $k, 1 => $v);
						//$tt = 
						array_push($mem, $t);
						$xx ++;
					}
				}
			}
		}
		$o['success'] = true;

		$o['memcached'] = $mem;

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));
		$ci = $this->cache->cache_info();

		$o['file_cache'] = $ci;

		echo json_encode($o);

	}
	function delete_all_cache() {

		// Load the memcached library config
		$this->load->config('memcached');
		$this->config->item('memcached');

		$c = $this->config->item('memcached');
		$host = $c['servers']['default']['host'];

		$memcache = new Memcache;
		$memcache->connect($host, 11211)
		or die ("Could not connect to memcache server");

		$list = array();
		$allSlabs = $memcache->getExtendedStats('slabs');
		$items = $memcache->getExtendedStats('items');
		foreach($allSlabs as $server => $slabs) {
			foreach($slabs AS $slabId => $slabMeta) {
				$cdump = $memcache->getExtendedStats('cachedump',(int)$slabId);
				foreach($cdump AS $keys => $arrVal) {
					if (!is_array($arrVal)) continue;
					foreach($arrVal AS $k => $v) {
						echo $k .'<br>';
						$this->main_model->delete_memcache($k);
						
					}
				}
			}
		}
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));
		$this->cache->clean();
	}

	
	public function index()
	{ 
		
		$this->load->library('encrypt');

		if($id = $this->session->userdata('id')){

		 	//REDIRECT AUTH
			if($url = $this->input->get('redirect_url')){

				$d['section_1'] = $this->section_1;
				$d['section_2'] = $this->section_2;
				$d['my_na_id'] = $id;
				$d['u_name'] = $this->session->userdata('u_name');
				$d['u_email'] = $this->session->userdata('u_email');
				$d['img_file'] = $this->session->userdata('img_file');
				$d['city'] = $this->session->userdata('city');
				$d['country'] = $this->session->userdata('country');
				$d['points'] = $this->session->userdata('points');
				$d['register_date'] = $this->session->userdata('register_date');
				echo "<script>window.location.href = '".$url.'&sess='.$this->encrypt->encode(json_encode($d))."';</script>";
				
				//echo $url.'&sess='.$this->encrypt->encode(json_encode($d))."&url=";
				
				//var_dump($this->input->get());
				die();
			}
			
			$data['id'] = $id;
			$this->load->view('members/home', $data);	
		
		}else{ 

			if($data['redirect'] = $this->input->get('redirect_url')){
				 

			}
			$data['error'] = 'Please login below';
		    $this->load->view('login', $data);
		 }
	}
	
	//+++++++++++++++++++++++++++
	//MEMBERS HOME
	//++++++++++++++++++++++++++
	public function home()
	{
		
		//var_dump($_SERVER['REQUEST_URI']);
		//echo $_SERVER['REQUEST_URI'];
		//var_dump(uri_string());
		//echo $this->uri->uri_string();
		if($this->session->userdata('id')){
				
			//echo 'Logged in: '.$this->session->userdata('id'); 
			$redirect = $this->un_clean_url($this->uri->segment(3));
			
			if($redirect != ''){
				$data['redirect'] = $redirect;
			}
			
			if($redirect == 'message'){
				
				$data['msg_id'] = $this->uri->segment(4);	
			}

			
			$data['id'] = $this->session->userdata('id');
			$this->load->view('members/home', $data);
				
		/*}elseif($this->session->userdata('session_id')){
			 	
			echo 'Yes: '.$this->session->userdata('session_id');*/
		
		}else{
			
			//echo 'No: Nothing exists';
		
				$data['error'] = 'Please login below';
			    $this->load->view('login', $data);
			  
		 }	
	}


	//+++++++++++++++++++++++++++
	//MEMBERS PROFILE
	//++++++++++++++++++++++++++
	public function my_profile()
	{
		
		if($this->session->userdata('id')){
				
			$redirect = $this->un_clean_url($this->uri->segment(3));
			
			if($redirect != ''){
				$data['redirect'] = $redirect;
			}
			
			if($redirect == 'message'){
				
				$data['msg_id'] = $this->uri->segment(4);	
			}

			
			$data['id'] = $this->session->userdata('id');
			$this->load->view('members/my_profile', $data);
				
		}else{
			
			$data['error'] = 'Please login below';
		    $this->load->view('login', $data);
			  
		 }
			
	}


	//+++++++++++++++++++++++++++
	//My Products
	//++++++++++++++++++++++++++
	public function my_products()
	{
		
		if($this->session->userdata('id')){
				
			$redirect = $this->un_clean_url($this->uri->segment(3));
			
			if($redirect != ''){
				$data['redirect'] = $redirect;
			}
			
			$data['id'] = $this->session->userdata('id');
			$this->load->view('members/my_products', $data);
				
		}else{
			
			$data['error'] = 'Please login below';
		    $this->load->view('login', $data);
			  
		 }
			
	}



	//+++++++++++++++++++++++++++
	//MEMBERS MESSAGES
	//++++++++++++++++++++++++++
	public function my_messages()
	{
		
		if($this->session->userdata('id')){
				
			$redirect = $this->un_clean_url($this->uri->segment(3));
			
			if($redirect != ''){
				$data['redirect'] = $redirect;
			}
			
			if($redirect == 'message'){
				
				$data['msg_id'] = $this->uri->segment(4);	
			}
			
			$data['id'] = $this->session->userdata('id');
			$this->load->view('members/my_messages', $data);
				
		}else{
			
			$data['error'] = 'Please login below';
		    $this->load->view('login', $data);
			  
		 }
			
	}







	//+++++++++++++++++++++++++++
	//POPULATE MESSAGES
	//++++++++++++++++++++++++++
	public function populate_inbox()
	{
		
		if($this->session->userdata('id')){
				
			$redirect = $this->un_clean_url($this->uri->segment(3));
			
			if($redirect != ''){
				$data['redirect'] = $redirect;
			}
			
			if($redirect == 'message'){
				
				$data['msg_id'] = $this->uri->segment(4);	
			}
			
			$id = $this->session->userdata('id');
			$status = $this->input->post('status', TRUE);
			
			$this->load->model('email_model');	

			$o = $this->email_model->get_member_messages($id,$status);

			$this->output
		       ->set_content_type('application/json')
		       ->set_output(json_encode(array('inbox' => $o)));			
				
		} else {
			
			$data['error'] = 'Please login below';
		    $this->load->view('login', $data);
			  
		}
			
	}	


	//+++++++++++++++++++++++++++
	//LOAD MEMBERS HOME DIREWCTORY SEARCH
	//++++++++++++++++++++++++++
	public function load_search()
	{
		$this->load->view('inc/home_search');
	}
	
	//+++++++++++++++++++++++++++
	//LOAD HOME FEED
	//++++++++++++++++++++++++++
	public function load_home_feed($x=0)
	{
		//IF fisrt load
		if($x == 0){
				echo '<link rel="stylesheet" type="text/css" href="'.base_url('/').'css/jquery.countdown.css">
					  <script data-cfasync="false" type="text/javascript" src="'.base_url('/').'js/jquery.countdown.min.js"></script>
					  <div id="deal_msg_"></div>
					 ';
				$this->load->model('advert_model');
				$this->advert_model->show_sdvert($query = '');
				$this->load->model('trade_model');

            $query2 =  $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                            u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                            MAX(product_auction_bids.amount) as current_bid,
                                            AVG(u_business_vote.RATING) as TOTAL,
                                            (
                                            SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                            ) as TOTAL_REVIEWS

                                            FROM products
                                            JOIN product_extras ON products.product_id = product_extras.product_id
                                            LEFT JOIN u_business ON u_business.ID = products.bus_id
                                            JOIN product_images ON products.product_id = product_images.product_id
                                            LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                            LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                            AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                            WHERE  products.is_active = 'Y' AND products.main_cat_id = 348
                                            GROUP BY products.product_id
                                            ORDER BY products.listing_date DESC LIMIT 3
											");


            $this->trade_model->get_products($query2, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 3, $offset = 0, $title = '', $amt = 5 , FALSE);

            $query =  $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                            u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                            MAX(product_auction_bids.amount) as current_bid,
                                            AVG(u_business_vote.RATING) as TOTAL,
                                            (
                                            SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                            ) as TOTAL_REVIEWS

                                            FROM products
                                            JOIN product_extras ON products.product_id = product_extras.product_id
                                            LEFT JOIN u_business ON u_business.ID = products.bus_id
                                            JOIN product_images ON products.product_id = product_images.product_id
                                            LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                            LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                            AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                            WHERE products.is_active = 'Y' AND products.main_cat_id = 3408
                                            GROUP BY products.product_id
                                            ORDER BY products.listing_date DESC LIMIT 3");
				$this->trade_model->get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 3, $offset = 0, $title = '', $amt = 5 , FALSE);
		}
		
		$this->load->model('deal_model');
		$this->load->model('news_model');

		$this->deal_model->get_homefeed_deals($x);
		//$this->news_model->get_namibian($x, '3', 'namibian');
		$this->news_model->get_namibian($x, '3', 'new_era');
		$this->news_model->get_world_news($x, '3', 'world');
	}
	
	//+++++++++++++++++++++++++++
	//LOAD NEWS
	//++++++++++++++++++++++++++
	public function load_world_news($x, $limit ,$type)
	{

		$this->load->model('news_model');
		$this->news_model->get_world_news($x, $limit ,$type);
	}
   	//+++++++++++++++++++++++++++
	//LOAD SKY NEWS
	//++++++++++++++++++++++++++
	public function load_sky_sports_news($x, $limit ,$type)
	{

		$this->load->model('news_model');
		$this->news_model->get_sky_sports_news($x, $limit ,$type);
	}
	//+++++++++++++++++++++++++++
	//LOAD ENTERTAINMENT
	//++++++++++++++++++++++++++
	public function load_entertainment($x, $limit ,$type)
	{

		$this->load->model('news_model');
		$this->news_model->get_entertainment($x, $limit ,$type);
	}
	//+++++++++++++++++++++++++++
	//LOAD DEALS
	//++++++++++++++++++++++++++
	public function load_deals($x, $limit ,$type)
	{

		$this->load->model('deal_model');
		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 10" ,FALSE);
		$this->deal_model->show_deals($query );
	}

	//+++++++++++++++++++++++++++
	//LOAD BUSINESS PRODUCTS
	//++++++++++++++++++++++++++
	public function load_bus_products()
	{ 
		$bus_id = trim($this->input->post('bus_id', TRUE));
		$section = trim($this->input->post('section', TRUE));

		$this->load->model('sell_model');

		$o = $this->sell_model->get_client_products($bus_id, $section); 

 
	}



	//+++++++++++++++++++++++++++
	//SCRATCH & WIN
	//++++++++++++++++++++++++++
	public function scratch_and_win()
	{
		
		if($this->session->userdata('id')){
			 	
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/scratch_win', $data);	
		
		}else{
			
				$this->logout();
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//LOAD
	public function load_scratch_win()
	{
		
		if($this->session->userdata('id')){
			 	
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/inc/scratch_win_inc', $data);	
		
		}else{
			
				$this->logout();
			  
		 }
		
		
	}

	//+++++++++++++++++++++++++++
	//LOAD GENERAL INFO
	public function load_ajax_general()
	{

		if($this->session->userdata('id')){
			 	
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/inc/my_account', $data);
		
		}else{
			
				$this->logout();
			  
		 }
		
	}
	
	//+++++++++++++++++++++++++++
	//LOAD WORLD NEW
	public function load_ajax_news_world()
	{

		$this->load->model('feed_model');
		$this->feed_model->get_world_news(0, 4);
		
	}
	//+++++++++++++++++++++++++++
	//LOAD BUY/ SEL NA TRADE
	public function load_ajax_trade()
	{

		
		
	}

    //+++++++++++++++++++++++++++
    //VALIDATE USER EMAIL ON DEMAND
    public function validate_user_email()
    {
        $data['success'] = false;
        $data['msg'] = 'No Input';
        if($email = $this->input->post('email')){

            $this->db->where('CLIENT_EMAIL', $email);
            $q = $this->db->get('u_client');

            if($q->result()){

                $data['success'] = false;

                $data['msg'] = ' The email already exists in the system. <a href="'.site_url('/').'members/">Forgot Password</a>';
            }else{

                $data['success'] = true;

                $data['msg'] = ' The email is valid and not in use';

            }

        }

        echo json_encode($data);

    }


	public function register()
	{

		$this->load->model('my_na_model');

        $data = $this->my_na_model->get_ip_location();

        $data['client_id'] = 0;
        $data['email'] = '';
        ///$data['semi'] = false;
        if($this->session->userdata('semi')){

            $data['email'] = $this->session->userdata('email');
            $data['fname'] = $this->session->userdata('fname');
            $data['sname'] = $this->session->userdata('sname');
            $data['client_id'] = $this->session->userdata('client_id');
            $data['semi'] = true;

        }

        $this->load->view('members/register', $data);

        //var_dump($data);
        //$this->output->enable_profiler(TRUE);
		
	}
	
	//+++++++++++++++++++++++++++
	//REGISTER MEMBER WITHOUT JAVA
	//++++++++++++++++++++++++++
	function register_do()
	{
          	$email = trim($this->input->post('email', TRUE));
			$fname = $this->input->post('fname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$cell = $this->input->post('cell', TRUE);
			$pass1 = $this->input->post('pass1', TRUE);
			$pass2 = $this->input->post('pass2', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('dob', TRUE);
			$security = $this->input->post('security', TRUE);
			$x = $this->input->post('x', TRUE);
			$y = $this->input->post('y', TRUE);
			$dial_code = $this->input->post('dial_code', TRUE);

			if(!$email = $this->session->userdata('email')){

				$email = $this->input->post('email_', TRUE);
			}
			if(!$client_id = $this->session->userdata('client_id')){

				$client_id = trim($this->input->post('client_id', TRUE));
			}
			//VALIDATE INPUT
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';	
				
			}elseif(($fname == '') || ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			
			}elseif(($pass1 != $pass2)){
				$val = FALSE;
				$error = 'Your password is not matching';
					
			}elseif((strlen($pass1) < 3)){
				$val = FALSE;
				$error = 'Your password is not strong enough';		
				
			}elseif(($cell == '') || (!is_numeric($cell))){
				$val = FALSE;
				$error = 'Please provide us with your cellular number.';	
				
			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';	

							
			}else{
				$val = TRUE;
			}
				
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);

			$first = substr($cell ,0,1);
			if($first == 0)
			{
				$cell = substr($cell, 1, strlen($cell));
			}

			//alert(cellphoneNumber.substring(0, 3));
			if(($dial_code == '264')) {
				switch ($cellNum) {
					case '081':

						$val = TRUE;
						break;
					case '085':

						$val = TRUE;
						break;
					case '060':

						$val = TRUE;
						break;
					default:
						$val = FALSE;
						$error = 'Your cell number is not valid. A 081/085/060 number is required!';

				}
			}

			
			if($val == TRUE){
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->platform() .' '.$this->agent->browser().' ver : '.$this->agent->version();
				$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
				
					
				$insertdata = array(
							  'CLIENT_NAME'=> $fname ,
							  'CLIENT_SURNAME'=> $sname ,
							   'CLIENT_EMAIL'=> $email,
							   'CLIENT_CELLPHONE'=> $cell,
							  'DIAL_CODE' => $dial_code,
							   'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
							   'CLIENT_GENDER'=> $gender,
							  'CLIENT_DATE_OF_BIRTH'=> $dob,
							  'CLIENT_COUNTRY' => $country,
							  'CLIENT_CITY' => $city,
							  'CLIENT_SUBURB' => $suburb,
							  'CLIENT_UA' => $agent,
							  'CLIENT_IP' => $IP,
							  'IS_ACTIVE' => 'N'
				);
				
				$this->db->where('CLIENT_EMAIL' , $email);
				$this->db->from('u_client');
				$query = $this->db->get();
			
				
				//IF email already exists
				if($query->num_rows() > 0){
					
					//fill array to populate fields on form
					$data['fname'] = $fname;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['pass1'] = $pass1;
					$data['cell'] = $cell;
					$data['country'] = $country;
					$data['dob'] = $dob;
					$data['error'] = 'A member with the email address ' . $email . ' already exists!';
					$this->load->view('members/register',$data);	
					
				}else{
					
					$this->db->insert('u_client', $insertdata);
					//get ID
					$this->db->where('CLIENT_EMAIL' , $email);
					$this->db->from('u_client');
					$query = $this->db->get();
					$row = $query->row_array();
					$member_id = $row['ID'];	
					
					//BUILD ARRAY 4 email		
					
					$data['fname'] = $fname;
					$data['img'] = '0';
					$data['member_id'] = $member_id;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['cell'] = $cell;
					$data['pass1'] = $pass1;
					$data['dob'] = $dob;
                    $data['agent'] = $agent;
                    $data['IP'] = $IP;
					$data['base'] = base_url('/');
					$data['confirm_link'] = site_url('/') . 'members/activate/'.$member_id;
					//SEND EMAIL LINK
					$this->load->model('email_model');	
					$this->email_model->send_register_link($data);
					//success redirect	
					$data['basicmsg'] = 'Thank you, ' . $fname .' you have successfully registered.';
					//echo $data['basicmsg'];
					$this->load->view('members/register_success',$data);
				}
			
			}else{
					//fill array to populate fields on form
					$data['fname'] = $fname;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['pass1'] = $pass1;
                    $data['cell'] = $cell;
                    if($cell == 'international'){

                        $data['cell'] = '';
                    }

					$data['country'] = $country;
					$data['dob'] = $dob;
					$data['error'] = $error;
                    $data['client_id'] = 0;
                    $data['c_code'] = $this->session->userdata('c_code');
                    ///$data['semi'] = false;
                    if($this->session->userdata('semi')){

                        $data['email'] = $this->session->userdata('email');
                        $data['fname'] = $this->session->userdata('fname');
                        $data['sname'] = $this->session->userdata('sname');
                        $data['c_code'] = $this->session->userdata('c_code');
                        $data['client_id'] = $this->session->userdata('client_id');
                        $data['semi'] = true;

                    }
					$this->load->view('members/register',$data);	
			
			}
	}
    //+++++++++++++++++++++++++++
	//REGISTER MEMBER WITHOUT AJAX
	//++++++++++++++++++++++++++
	function register_do_ajax()
	{

			$gender = $this->input->post('gender', TRUE);

            if(!$email = $this->session->userdata('email')){

                $email = $this->input->post('email_', TRUE);
            }
            if(!$client_id = $this->session->userdata('client_id')){

                $client_id = trim($this->input->post('client_id', TRUE));
            }

			$cell = $this->input->post('cell', TRUE);
			$pass1 = $this->input->post('pass1', TRUE);
			$pass2 = $this->input->post('pass2', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('dob', TRUE);
			$security = $this->input->post('security', TRUE);
			$dial_code = $this->input->post('dial_code', TRUE);
			//$dob = strtotime($new_date_format); 

			//VALIDATE INPUT
			if(($pass1 != $pass2)){
				$val = FALSE;
				$error = 'Your password is not matching';
					
			}elseif((strlen($pass1) < 3))
			{
				$val = false;
				$error = 'Your password is not strong enough';

			}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))) {

				$val = FALSE;
				$error = 'Please provide us with a valid cellular number.Digits only';


			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';	
				

			}else{
				$val = TRUE;
			}
				
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			//alert(cellphoneNumber.substring(0, 3));
			$first = substr($cell ,0,1);
			if($first == 0)
			{
				$cell = substr($cell, 1, strlen($cell));
			}
            if($dial_code == '264') {
                switch ($cellNum) {
                    case '081':

                        $val = TRUE;
                        break;
                    case '085':

                        $val = TRUE;
                        break;
                    case '060':

                        $val = TRUE;
                        break;
                    default:
                        $val = FALSE;
                        $error = 'Your namibian cell number is not valid. A 081/085/060 number is required!';

                }
            }


			if($val == TRUE){
				

					
				$insertdata = array(

							   'CLIENT_CELLPHONE'=> $cell,
							   'DIAL_CODE' => $dial_code,
							   'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
							  'CLIENT_GENDER'=> $gender,
							  'CLIENT_DATE_OF_BIRTH'=> $dob,
							  'CLIENT_COUNTRY' => $country,
							  'CLIENT_CITY' => $city,
							  'CLIENT_SUBURB' => $suburb


				);
				
				$this->db->where('ID' , $client_id);
				$query = $this->db->update('u_client', $insertdata);

                //success redirect
                $data['basicmsg'] = 'Thank you,  you have successfully registered.';

                $result['success'] = true;

                $result['html'] =   '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        '.$data['basicmsg'].'</div>';

                echo json_encode($result);


			}else{
					
					$data['error'] = $error;

                    $result['success'] = false;

                    $result['html'] = '<div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    '.$data['error'].'</div>';

                    echo json_encode($result);
			}
	}




    //+++++++++++++++++++++++++++
    //REGISTER STEP 1
    //++++++++++++++++++++++++++
    function register_1_do_ajax()
    {

        $email = trim($this->input->post('email', TRUE));
        $fname = $this->input->post('fname', TRUE);
        $sname = $this->input->post('sname', TRUE);
        //TEST IF ROBOT
        if ($this->agent->is_robot())
        {

            $result['success'] = false;

            $result['html'] =   '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		Sorry, only humans can submit an enquiry!</div>';

            echo json_encode($result);
            //IS HUMAN
        }else {

            $this->load->library('recaptcha');
            $bool = json_decode($this->recaptcha->recaptcha_check_answer());

            //var_dump ($bool);
            //CAPTCHA FALSE
            if (!$bool->success) {

                $data['error'] = 'Are you a robot? PLease click on I am not a robot above.';

                $result['success'] = false;

                $result['html'] =  '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								' . $data['error'] . '</div>';

                echo json_encode($result);
            } else {

                //$dob = strtotime($new_date_format);

                //VALIDATE INPUT
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $val = FALSE;
                    $error = 'Email address is not valid.';

                } elseif (($fname == '') || ($sname == '')) {
                    $val = FALSE;
                    $error = 'Please provide us with your full name.';

                } else {
                    $val = TRUE;
                }


                if ($val == TRUE) {

                    $this->load->library('user_agent');
                    $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
                    $IP = $this->input->ip_address();

                    $insertdata = array(
                        'CLIENT_NAME' => $fname,
                        'CLIENT_SURNAME' => $sname,
                        'CLIENT_EMAIL' => $email,
                        'CLIENT_UA' => $agent,
                        'CLIENT_IP' => $IP,
                        'IS_ACTIVE' => 'N'
                    );

                    $this->db->where('CLIENT_EMAIL', $email);
                    $this->db->from('u_client');
                    $query = $this->db->get();


                    //IF email already exists
                    if ($query->num_rows() > 0) {

                        $data['error'] = 'A member with the email address ' . $email . ' already exists!';

                        $result['success'] = false;

                        $result['html'] =  '<div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['error'] . '</div>';

                        echo json_encode($result);


                    } else {

                        $this->db->insert('u_client', $insertdata);
                        //get ID
                        $this->db->where('CLIENT_EMAIL', $email);
                        $this->db->from('u_client');
                        $query = $this->db->get();
                        $row = $query->row_array();
                        $member_id = $row['ID'];

                        //BUILD ARRAY 4 email

                        $data['fname'] = $fname;
                        $data['img'] = '0';
                        $data['member_id'] = $member_id;
                        $data['email'] = $email;
                        $data['sname'] = $sname;

                        $data['base'] = base_url('/');
                        $data['confirm_link'] = site_url('/') . 'members/activate/' . $member_id;
                        //SEND EMAIL LINK
                        $this->load->model('email_model');

                        $data['fname'] = $fname;
                        $data['img'] = '0';
                        $data['member_id'] = $member_id;
                        $data['email'] = $email;
                        $data['sname'] = $sname;
/*                        $data['cell'] = $cell;
                        $data['pass1'] = $pass1;
                        $data['dob'] = $dob;*/
                        $data['agent'] = $agent;
						$data['IP'] = $IP;
                        $data['base'] = base_url('/');
                        $data['confirm_link'] = site_url('/') . 'members/activate/'.$member_id;
                        //SEND EMAIL LINK
                        $this->load->model('email_model');
                        $this->email_model->send_register_link($data);
                        /*//BUILD BODY
                        $body = 'Hi ' . $fname . ',<br /><br />
                                            <p>You have successfully created your My.Na account and are now an official ambassador of Namibia.</p>
                                                <p>To verify your email address and activate your account please click on the link below or copy and paste it into the address bar of your browser.</p>
                                                <p></p>
                                                <p>' . $data['confirm_link'] . '</p>
                                                <p>If you have any questions please email us at info@my.na.</p>
                                                <p>Have a !na day</p>
                                                <br /><br />
                                                My Namibia';

                        $data_view['body'] = $body;
                        $body_final = $this->load->view('email/body_news', $data_view, true);
                        $subject = 'Your Account Verification Link';
                        $fromEMAIL = 'no-reply@my.na';
                        $fromNAME = 'My Namibia';
                        $TAG = array('tags' => 'member_registration');
                        $emailTO = array(array('email' => $email));

                        //SEND EMAIL LINK
                        $this->load->model('email_model');
                        $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);*/

                        //success redirect
                        $data['basicmsg'] = 'Thank you ' . $fname . ', please complete the form above to complete your registration.';

                        //SET SEMI SESSION
                        $sess = array(

                            'fname' => $fname,
                            'sname' => $sname,
                            'semi' => true,
                            'email' => $email,
                            'client_id' => $member_id

                        );
                        $this->session->set_userdata($sess);

                        $result['success'] = true;
                        $result['client_id'] = $member_id;
                        $result['email'] = $email;
                        $result['html'] = '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['basicmsg'] . '</div>';

                        echo json_encode($result);

                    }

                } else {

                    $data['error'] = $error;
                    $result['success'] = false;

                    $result['html'] =  '<div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['error'] . '</div>';

                   echo json_encode($result);

                }
            }
        }
    }

    //+++++++++++++++++++++++++++
	//UPDATE ACCOUNT
	//++++++++++++++++++++++++++	
	function update_do()
	{
			$email = trim($this->input->post('email', TRUE));
			$fname = $this->input->post('fname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$cell = $this->input->post('cell', TRUE);
			$pass1 = $this->input->post('pass1', TRUE);
			$pass2 = $this->input->post('pass2', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('dob', TRUE);
			$id = $this->input->post('id', TRUE);
			$daily_mail = $this->input->post('daily_mail', TRUE);
			$cell_verified = $this->input->post('cell_verified', TRUE);
			$dial_code = $this->input->post('dial_code', TRUE);
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';	


				
			}elseif(($fname == '') && ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			
			}elseif(($pass1 != $pass2)){
				$val = FALSE;
				$error = 'Your password is not matching';
							

				
			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';

			/*}elseif($this->validate_cell($cellNum)){

				if($cell_verified == 'Y'){

					$val = TRUE;

				}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
					$val = FALSE;
					$error = 'Please provide us with a valid cellular number.';

				}else{

					$val = FALSE;
					$error = 'Your cell number is not valid. A 081/085/060 number is required!';

				}*/


			}else{
				$val = TRUE;
			}
			//$str1 = str_replace(' ', '',$cell);
			
			//alert(cellphoneNumber.substring(0, 3));
			$first = substr($str1 ,0,1);
			if($first == 0)
			{
				$cell = substr($cell, 1, strlen($cell));
			}else{
				
				$str1 = '0'.$str1;
				
			}
			$cellNum = substr($str1,0,3);
			if($dial_code == '264' && $cell_verified != 'Y') {
				switch ($cellNum) {
					case '081':

						$val = TRUE;
						break;
					case '81':

						$val = TRUE;
						break;	
					case '085':

						$val = TRUE;
						break;
					case '85':

						$val = TRUE;
						break;
					case '060':

						$val = TRUE;
						break;
					default:
						$val = FALSE;
						$error = 'Your namibian cell number is not valid. A 081/085/060 number is required!';

				}
			}


		//CHECK IF NEW PASSWORD
			if(($pass1 == $pass2) && ($pass1 != '')){
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'CLIENT_NAME'=> $fname ,
								  'CLIENT_SURNAME'=> $sname ,
								   'CLIENT_EMAIL'=> $email,
								   'CLIENT_CELLPHONE'=> $cell, 
								  'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
								  'CLIENT_GENDER'=> $gender,
								  'CLIENT_DATE_OF_BIRTH'=> $dob,
								  'CLIENT_COUNTRY' => $country,
								  'CLIENT_CITY' => $city,
								  'CLIENT_SUBURB' => $suburb,
								  'CLIENT_UA' => $agent,
								  'EMAIL_NOTIFICATION' => $daily_mail,
								  'CLIENT_IP' => $IP
					);

				if($cell_verified == 'Y'){

					unset($insertdata['CLIENT_CELLPHONE']);
				}

			
			}else{
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'CLIENT_NAME'=> $fname ,
								  'CLIENT_SURNAME'=> $sname ,
								   'CLIENT_EMAIL'=> $email,
								   'CLIENT_CELLPHONE'=> $cell, 
								  'CLIENT_GENDER'=> $gender,
								  'CLIENT_DATE_OF_BIRTH'=> $dob,
								  'CLIENT_COUNTRY' => $country,
								  'CLIENT_CITY' => $city,
								  'CLIENT_SUBURB' => $suburb,
								  'CLIENT_UA' => $agent,
								   'EMAIL_NOTIFICATION' => $daily_mail,
								  'CLIENT_IP' => $IP
					);

				if($cell_verified == 'Y'){

					unset($insertdata['CLIENT_CELLPHONE']);
				}
			}
			
			if($val == TRUE){
				
					$this->db->where('ID' , $id);
					$this->db->update('u_client', $insertdata);
					//success redirect	
					//success redirect	
					//$this->session->set_flashdata('msg', 'Your account has been updated successfully');
					echo '<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong> Member account has been updated successfully
						  </div>';
			}else{
					echo '<div class="alert alert-error">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong>'.$error.'
						  </div>';
				
			}
	}
	
	
	public function register_success()
	{
		$this->load->view('members/register_success');
	}
	
	public function activate($id)
	{
		$this->db->where('ID' , $id);
		$this->db->where('IS_ACTIVE' , 'N');
		$this->db->from('u_client');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$update['IS_ACTIVE'] = 'Y';
			$this->db->where('ID', $id);
			$this->db->update('u_client', $update); 
			
			//GIVE CLIENT 10 FREE POINTS
			$this->load->model('business_model');
			$this->business_model->update_client_point($row['ID'], '15', 0, 'sign_up');


            //BUILD BODY
            $body = 'Hi ' . $row['CLIENT_NAME'] . ',<br /><br />
                                <p><img src="'.base_url('/').'img/email/money_eddie.png" style="width:580px" width="580"></p>
                                <p>You have successfully created your My.Na account and are now an official ambassador of Namibia.</p>
                                    <p>To login to your account please follow the link below.</p>
                                    <p></p>
                                    <p style="text-align:center"><a href="' .site_url('/') . '/members/" class="btn">Explore Now</a></p>
                                    <p>You can now customize your account and start exploring the My namibia portal.</p>
                                    <p>Have you got a business? List it for free and enjoy great online exposure and advertising.</p>
                                    <p>If you have any questions please email us at info@my.na.</p>
                                    <p>Have a !na day</p>
                                    <br /><br />
                                    My Namibia
                                    <p><img src="'.base_url('/').'img/email/anything_namibia.png" style="width:580px" width="580"></p>
                                    ';

            $data_view['body'] = $body;
            $body_final = $this->load->view('email/body_news', $data_view, true);
            $subject = 'Your Account is now active';
            $fromEMAIL = 'no-reply@my.na';
            $fromNAME = 'My Namibia';
            $TAG = array('tags' => 'member_welcome');
            $emailTO = array(array('email' => $row['CLIENT_EMAIL'] ));

            //SEND EMAIL LINK
            $this->load->model('email_model');
            $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);



			//Redirect to home page
			$data['basicmsg'] = 'Thank you, we have verified your account. Please login below';
			$data['id'] = $id;
			$data['first'] = 'Y';
			$this->load->view('login',$data);
			
		}else{
			
			$data['error'] = 'The link is expired and your account is already active.';
			$this->load->view('members/register',$data);	
			
		}
		
	}	
	//+++++++++++++++++++++++++++
	//UPLOAD AVATAR
	//++++++++++++++++++++++++++
	
	public function add_avatar()
	{
		//MEMBER LOGGED IN
		if($this->session->userdata('id')){
			 	
				$this->members_model->add_avatar();
				$data['basicmsg'] = 'Avatar added successfully!';
				redirect('/members/home/');
		
		//ADMIN LOGGED IN
		}elseif($this->session->userdata('admin_id')){
			 	
				$this->members_model->add_avatar();
				echo '<div class="alert">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  Avatar added successfully!
					  </div>';
		
		}else{
				
				$data['error'] = 'Sorry, you have been logged out of My.Na';
				$this->load->view('login' , $data);
			  
		 }
		
		 
	}
	 //+++++++++++++++++++++++++++
	//UPLOAD AVATAR AJAX
	//++++++++++++++++++++++++++
	
	public function add_avatar_ajax()
	{
		//MEMBER LOGGED IN
		if($this->session->userdata('id')){
			 	
				$this->members_model->add_avatar_ajax();
				$data['basicmsg'] = 'Avatar added successfully!';
				
		
		//ADMIN LOGGED IN
		}elseif($this->session->userdata('admin_id')){
			 	
				$this->members_model->add_avatar_ajax();
				$data['basicmsg'] = 'Avatar added successfully!';
				
		
		}else{
				
				$data['error'] = 'Sorry, you have been logged out of My.Na';
				$this->load->view('login' , $data);
			  
		 }
		
		
	}
	
	 //+++++++++++++++++++++++++++
	//POPULATE REGIONS FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_region($cunt_id)
	{
		$this->members_model->populate_region($cunt_id);
	}
	//+++++++++++++++++++++++++++
	//POPULATE CITIES FOR COUNTRIES
	//++++++++++++++++++++++++++ 
	public function populate_city($cunt_id, $city)
	{
		$this->members_model->populate_city($cunt_id, $city);
	}
	
	 //+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS BY ID
	//++++++++++++++++++++++++++
	public function populate_suburb($reg_id,$suburb)
	{
		
		$this->members_model->populate_suburb($reg_id, $suburb);
	}
	
	 //+++++++++++++++++++++++++++
	//POPULATE SUB CATEGORIES
	//++++++++++++++++++++++++++
	public function get_sub_categories($cat_id)
	{
		$cats = $this->members_model->get_sub_categories($cat_id);
		if($cats->result()){
		
			echo '<select id="sub_cats_select" onchange="add_sub_cats(this.value)" name="sub_cats_select" style="float:right;height:300px;" class="span4" multiple="multiple">';
			
				foreach($cats->result() as $row){
					
					$cat_name = $row->CATEGORY_NAME;
					$cat_id = $row->ID;
					
					
					echo '<option onclick="add_sub_cats(this.value)" value="'.$cat_id.'" >'.$cat_name.'</option>';
						  
					
					
				}
		   echo '</select>';
		}else{
		
		return;
		}
		
		
	}
	 //+++++++++++++++++++++++++++
	//ADD CATEGORY
	//++++++++++++++++++++++++++
	public function add_category($cat_id, $bus_id)
	{
		//ADD
		$this->members_model->add_new_category($cat_id, $bus_id);
		
		
		$cats = $this->members_model->get_current_categories($bus_id);
		if($cats->result()){
		
			echo '<div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert">×</button>
                 Category Added succesfully!
              </div>';
			
				 foreach($cats->result() as $row1){
        
						$cat_id_cur = $row1->CATEGORY_ID;
						echo '<a href="javascript:void(0)" style="margin-bottom:5px;" onclick="delete_cat('.$cat_id_cur.','.$bus_id.')" class="btn del_cat" rel="tooltip" title="Remove '.$this->members_model->get_category_name($cat_id_cur).' category" >'.$this->members_model->get_category_name($cat_id_cur).' <i class="icon-remove"></i></a> ';
            
   				 }
		
		}else{
		
		return;
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY
	//++++++++++++++++++++++++++
	public function delete_category($cat_id, $bus_id)
	{
		//DELETE
		$val = $this->members_model->delete_category($cat_id, $bus_id);
		
		if($val == 'redirect'){
		//redirect browser - no java	
			
		}else{
		//ajax message and load categories	
		
			$cats = $this->members_model->get_current_categories($bus_id);
			if($cats->result()){
			
				echo '<div class="alert alert-success">
				   			<button type="button" class="close" data-dismiss="alert">×</button>
					 		Category deleted succesfully!
				 	 </div>';
				
					 foreach($cats->result() as $row1){
			
							$cat_id_cur = $row1->CATEGORY_ID;
							echo '<a href="javascript:void(0)" onclick="delete_cat('.$cat_id_cur.','.$bus_id.')" style="margin-bottom:5px;" class="btn del-cat" rel="tooltip" title="Remove '.$this->members_model->get_category_name($cat_id_cur).' category" >'
							.$this->members_model->get_category_name($cat_id_cur).' <i class="icon-remove"></i></a> ';
				
					 }
			
			}else{
			
			return;
			}
		
			
		}
		
		
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//TNA MAIL
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//+++++++++++++++++++++++++++
	//BUILD MAIL
	//++++++++++++++++++++++++++
	public function tna_mail($bus_id)
	{
		
		if($this->members_model->check_business_user($bus_id)){
			 	
				$msg = $this->un_clean_url($this->uri->segment(4));
				
				$data['id'] = $this->session->userdata('id');
				$data['bus_id'] = $bus_id;
				if($msg != ''){
					$data['basicmsg'] = $msg;
				}
				$this->load->view('members/build_mail', $data);	
		
		}else{
			
				$this->load->view('login');
			  
		 }
	
	}
	
	//+++++++++++++++++++++++++++
	//PREVIEW MESSAGE
	//++++++++++++++++++++++++++	
	function preview_message()
	{	
		$data['preview'] = 'true';
		$data['body'] = $this->input->post('mailbody',TRUE);
		//$data['body'] = urldecode($body);
		
		$this->load->view('email/body_news', $data);	

		
	}	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//BUSINESS 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//+++++++++++++++++++++++++++ 
	//BUSINESS DETAILS EDIT
	//++++++++++++++++++++++++++
	public function business($bus_id, $section = '',$msg_id = '')
	{
 
		
		if($this->members_model->check_business_user($bus_id)){
				
				$data['id'] = $this->session->userdata('id');
				$data['bus_id'] = $bus_id;
				$data['msg_id'] = $msg_id;
				$data['section'] = $section;

			$this->load->model('image_model'); 

			$this->load->library('thumborp');


				$this->load->model('rating_model');
				$data['bus_id'] = $bus_id;
				$this->load->model('trade_model');
				//ADD a VIEW LISTING COUNTER
				$this->business_model->add_business_view($bus_id);

				$data['bus_details'] = $this->business_model->get_business_details($bus_id);
				$data['cats'] = $this->business_model->get_current_categories($bus_id);
				//get RATING
				$data['rating'] = $this->business_model->get_rating($bus_id);
				//$this->load->view('trade/business_products', $data);

				if($bus_id == '0') {

					$this->load->view('members/my_products', $data);

				} else {

					$this->load->view('members/business_details', $data);

				}
					
		
		}else{
				
				$this->load->view('login');
			  
		 }
	

	}
	
	
    //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++	
	function update_business_do()
	{
			



			$this->output->set_header("Access-Control-Allow-Origin: http://cms.my.na");
			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$telcode = $this->input->post('tel_dial_code', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$faxcode = $this->input->post('fax_dial_code', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$cellcode = $this->input->post('cell_dial_code', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			//$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);

			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';
					
		//	}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required! ' . $cellNum;
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	

        	}elseif(preg_match('(abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)', strtolower($name)) === 1){
                $val = FALSE;
                $error = 'Your listing name contains one or more illegal words which we do not allow. 
                        (abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)';   				
		//	}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($web != ''){
						
				if(!filter_var($web, FILTER_VALIDATE_URL)){
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				}else{
				   $val = TRUE;	
				}
			
			}
			
		
			
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'BUSINESS_NAME'=> $name ,
								  'BUSINESS_TELEPHONE'=> $tel2 ,
								  'TEL_DIAL_CODE'=> $telcode ,
								  'BUSINESS_EMAIL'=> $email,
								  'CEL_DIAL_CODE'=> $cellcode,
								  'BUSINESS_CELLPHONE'=> $cell,
								  'FAX_DIAL_CODE'=> $faxcode,
								  'BUSINESS_FAX'=> $fax2,
								  'BUSINESS_POSTAL_BOX'=> $pobox,
								  'BUSINESS_URL' => $web,
								  'BUSINESS_COUNTRY_ID' => $country,
								  'BUSINESS_MAP_CITY_ID' => $city,
								  'BUSINESS_SUBURB_ID' => $suburb
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('ID' , $bus_id);
					$this->db->update('u_business', $insertdata);
					//$this->sync_tourism_db($insertdata, $bus_id);
					//success redirect	
					$data['bus_id'] = $bus_id;
					$data['id'] = $this->session->userdata('id');
					$data['basicmsg'] = $name . ' has been updated successfully';
					redirect('/members/business/'.$bus_id.'/'.$this->clean_url($data['basicmsg']));
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					$this->load->view('members/business_details',$data);
				
			}
	}
	
    //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++	
	function business_update_do_ajax()
	{
			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$telcode = $this->input->post('tel_dial_code', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$faxcode = $this->input->post('fax_dial_code', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$cellcode = $this->input->post('cell_dial_code', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			//$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	

        	}elseif(preg_match('(abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)', strtolower($name)) === 1){
                $val = FALSE;
                $error = 'Your listing name contains one or more illegal words which we do not allow. 
                        (abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)';   					
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($web != ''){
						
				if(!filter_var($web, FILTER_VALIDATE_URL)){
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				}else{
				   $val = TRUE;	
				}
			
			}
			
		
			
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'BUSINESS_NAME'=> $name ,
								  'BUSINESS_TELEPHONE'=> $tel2 ,
								  'TEL_DIAL_CODE'=> $telcode ,
								  'BUSINESS_EMAIL'=> $email,
								  'CEL_DIAL_CODE'=> $cellcode,
								  'BUSINESS_CELLPHONE'=> $cell,
								  'FAX_DIAL_CODE'=> $faxcode,
								  'BUSINESS_FAX'=> $fax2,
								  'BUSINESS_POSTAL_BOX'=> $pobox,
								  'BUSINESS_URL' => $web,
								  'BUSINESS_PHYSICAL_ADDRESS' => $address,
								  'BUSINESS_COUNTRY_ID' => $country,
								  'BUSINESS_MAP_CITY_ID' => $city,
								  'BUSINESS_SUBURB_ID' => $suburb
					);
			
	
			
			if($val == TRUE){
				
				$this->db->where('ID' , $bus_id);
				$this->db->update('u_business', $insertdata);
				
				//$this->sync_tourism_db($insertdata, $bus_id);
				//success redirect	
				$data['bus_id'] = $bus_id;
				$data['id'] = $this->session->userdata('id');
				$data['basicmsg'] = $name . ' has been updated successfully';
				echo '<div class="alert alert-success">
     			<button type="button" class="close" data-dismiss="alert">×</button>
        		'.$data['basicmsg'].'</div>';
				$this->output->set_header("HTTP/1.0 200 OK");

			}else{

				$data['id'] = $this->session->userdata('id');
				$data['bus_id'] = $bus_id;
				$data['error'] = $error;
				echo '<div class="alert alert-danger">
     			<button type="button" class="close" data-dismiss="alert">×</button>
        		'.$data['error'].'</div>';
				$this->output->set_header("HTTP/1.0 200 OK");
	
			}
	}


   //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++	
	function business_desc_update_do_ajax()
	{
			$name = $this->input->post('name', TRUE);
			$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);
			
			//VALIDATE INPUT
			if($description == ''){
				$val = FALSE;
				$error = 'Please provide us with your business description.';	

        	}else{
        		$val = TRUE;
        	}
			
				
			$insertdata = array(
				'BUSINESS_DESCRIPTION'=> $description
			);
		
	
			
			if($val == TRUE){
				
				$this->db->where('ID' , $bus_id);
				$this->db->update('u_business', $insertdata);
				
				//$this->sync_tourism_db($insertdata, $bus_id);
				//success redirect	
				$data['bus_id'] = $bus_id;
				$data['id'] = $this->session->userdata('id');
				$data['basicmsg'] = $name . 'description has been updated successfully';
				echo '<div class="alert alert-success">
     			<button type="button" class="close" data-dismiss="alert">×</button>
        		'.$data['basicmsg'].'</div>';
				$this->output->set_header("HTTP/1.0 200 OK");

			}else{

				$data['id'] = $this->session->userdata('id');
				$data['bus_id'] = $bus_id;
				$data['error'] = $error;
				echo '<div class="alert alert-danger">
     			<button type="button" class="close" data-dismiss="alert">×</button>
        		'.$data['error'].'</div>';
				$this->output->set_header("HTTP/1.0 200 OK");
	
			}
	}



		
	//+++++++++++++++++++++++++++
	//SYNC HAN/TOURISM LISTING
	//++++++++++++++++++++++++++	
	public function sync_tourism_db($data, $bus_id)
	{
		$insertdata = array(
								  'BUSINESS_NAME'=> $data['BUSINESS_NAME'] ,
								  'BUSINESS_TELEPHONE'=> '+264 ' .$data['BUSINESS_TELEPHONE'] ,
								   'BUSINESS_EMAIL'=> $data['BUSINESS_EMAIL'],
								   'BUSINESS_CELLPHONE'=> '+264 ' .$data['BUSINESS_CELLPHONE'], 
								  'BUSINESS_FAX'=> '+264 ' .$data['BUSINESS_FAX'],
								  'BUSINESS_DESCRIPTION'=> $data['BUSINESS_DESCRIPTION'],
								  'BUSINESS_POSTAL_BOX'=> $data['BUSINESS_POSTAL_BOX'],
								  'BUSINESS_URL' => $data['BUSINESS_URL'],
								  'BUSINESS_MAP_CITY_ID' => $data['BUSINESS_MAP_CITY_ID'],
								  'BUSINESS_PHYSICAL_ADDRESS' => $data['BUSINESS_PHYSICAL_ADDRESS']
					);
		
		$db2 = $this->connect_tourism_db();
		$db2->where('ID', $bus_id);
		$test = $db2->get('u_business');
		
		if($test->result()){
			
			$db2->where('ID', $bus_id);
			$db2->update('u_business', $insertdata);
			
		}else{
			
			$insertdata['ID'] = $bus_id;
			$db2->insert('u_business', $insertdata);
			
			
		}
		
		

	
	} 
	
	
	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS
	//++++++++++++++++++++++++++	
	public function add_business()
	{
		
		if($this->session->userdata('id')){
			 	
			$msg = $this->un_clean_url($this->uri->segment(4));
			
			$data['id'] = $this->session->userdata('id');
			
			if($msg != ''){
				$data['basicmsg'] = $msg;
			}

			$this->load->view('members/add_business', $data);	
		
		}else{
			
			$this->load->view('login');
			  
		 }
	
	} 
	
	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS
	//++++++++++++++++++++++++++	
	function add_business_do()
	{
			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$telcode = $this->input->post('tel_dial_code', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$faxcode = $this->input->post('fax_dial_code', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$cellcode = $this->input->post('cell_dial_code', TRUE);
			$web = $this->input->post('url', TRUE);
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);

			if(isset($suburb) && $suburb != '') {

				$suburb = $suburb;

			} else {


				$suburb = 0;

			}
			
			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';
					
//			}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
				
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	

			}elseif(preg_match('(abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)', strtolower($name)) === 1){
				$val = FALSE;
				$error = 'Your listing name contains one or more illegal words which we do not allow. 
						(abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)';	
			
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
//			
//			//}elseif(isset($web) && (!filter_var(prep_url($web), FILTER_VALIDATE_URL))){
////						
////				$val = FALSE;
////				$error = 'Please provide us with a valid website address or URL';
//						
//			}elseif(str_word_count($description) < 70){
//				$val = FALSE;
//				$error = 'Please provide a minimum of 70 words for your business description. Currently: '.str_word_count($description).' words.';	
				
			}else{
				$val = TRUE;
			}
				
			
			//Test if Email Exists
			/*$test = $this->db->where('BUSINESS_EMAIL', $email);
			$test = $this->db->get('u_business');
			if($test->num_rows() > 0){
				
				$val = FALSE;
				$error = 'The email address '.$email .' is already in use for another business. Please use a unique email.';
			}*/
				
			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
			$IP = $this->input->ip_address();
			$insertdata = array(
							  'BUSINESS_NAME'=> $name ,
							  'BUSINESS_EMAIL'=> $email,
							  'BUSINESS_TELEPHONE'=> $tel2 ,
							  'TEL_DIAL_CODE'=> $telcode ,
							  'CEL_DIAL_CODE'=> $cellcode,
							  'BUSINESS_CELLPHONE'=> $cell,
							  'FAX_DIAL_CODE'=> $faxcode,
							  'BUSINESS_FAX'=> $fax2,
							  'BUSINESS_DESCRIPTION'=> $description,
							  'BUSINESS_POSTAL_BOX'=> $pobox,
							  'BUSINESS_URL' => $web,
							  'BUSINESS_PHYSICAL_ADDRESS' => $address,
							  'BUSINESS_COUNTRY_ID' => $country,
							  'BUSINESS_MAP_CITY_ID' => $city,
							  'BUSINESS_SUBURB_ID' => $suburb,
							  'BUSINESS_DATE_CREATED' => date('Y-m-d H:i:s')
				);
			
	
			
			if($val == TRUE){
				
					//insert
					$this->db->insert('u_business', $insertdata);

					//success redirect	
					$data['bus_id'] = $this->db->insert_id();
					$data['id'] = $this->session->userdata('id');

					//Get Business ID
					$test = $this->db->where('ID', $data['bus_id'] );
					$test = $this->db->get('u_business');
					$brow = $test->row_array();	

					//insert into intersection table
					$this->members_model->add_business_member($data['bus_id'],$data['id']);
					
					//SEND EMAIL 
					$this->add_business_email($brow);

					$data['basicmsg'] = $name . ' has been registered successfully';
					redirect('/members/business/'.$brow['ID'].'/'.$this->clean_url($data['basicmsg']));
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['BUSINESS_NAME'] = $name;
					$data['BUSINESS_TELEPHONE'] = $tel2;
					$data['BUSINESS_EMAIL'] = $email;
					$data['BUSINESS_FAX'] = $fax2;
					$data['BUSINESS_DESCRIPTION'] = $description;
					$data['BUSINESS_POSTAL_BOX'] = $pobox;
					$data['BUSINESS_URL'] = $web;
					$data['BUSINESS_PHYSICAL_ADDRESS'] = $address;
					$data['BUSINESS_CELLPHONE'] = $cell;
					$data['error'] = $error;
					$this->load->view('members/add_business',$data);
				
			}
	}

	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS EMAIL
	//++++++++++++++++++++++++++	
	function add_business_email($row)
	{
		
		//send email
		$body = '<h2>Hi Admin Team,</h2>
				
				A new business has been listed from a client. PLease checkout the listed business in the HUB and approve if OK.
				<strong>Business Details</strong>
				<ul>
					<li><strong>Name: </strong> ' .$row['BUSINESS_NAME'].'</li>
					<li><strong>Email: </strong> '.$row['BUSINESS_EMAIL'].'</li>
					<li><strong>Tel: </strong> '.$row['TEL_DIAL_CODE'].' ' .$row['BUSINESS_TELEPHONE'].'</li>
					<li><strong>Description: </strong> '.$row['BUSINESS_DESCRIPTION'].'</li>
					
				</ul>
				<strong>Client Details</strong>
				<ul>
					<li><strong>Name: </strong> '.$this->session->userdata('u_name').'</li>
					<li><strong>Email: </strong> '.$this->session->userdata('u_email').'</li>
					
				</ul>


				Please follow the link below:<br /><br />
				<a href="'.site_url('/').'u/b/'.$row['ID'].'/" title="Checkout Business">'.site_url('/').'u/b/'.$row['ID'].'</a>
				<br /><br />
				If you have any questions or need help please contact us.
				Have a !tna day!<br />
				My Namibia';
				
     	$data_view['body'] = $body;
		$body_final = $this->load->view('email/body_news',$data_view, true);
		
		$emailTO = array(array('email' => 'info@my.na'));
		$subject = 'New Business Listed: '.$row['BUSINESS_NAME'];
		$fromEMAIL = 'no-reply@my.na';
		$fromNAME = 'My Namibia';
		$TAG = array('tags' => 'add_business' );
		//SEND EMAIL LINK 
		$this->load->model('email_model');	
		$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
		return;	

	}
	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS
	//++++++++++++++++++++++++++	
	function add_business_do_ajax()
	{
			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$telcode = $this->input->post('tel_dial_code', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$faxcode = $this->input->post('fax_dial_code', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$cellcode = $this->input->post('cell_dial_code', TRUE);
			$web = $this->input->post('url', TRUE);
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description = $this->input->post('content', TRUE);
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);


			if(isset($suburb) && $suburb != '') {

				$suburb = $suburb;

			} else {


				$suburb = 0;

			}			

			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
				
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
			
			}elseif(preg_match('(abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)', strtolower($name)) === 1){
				$val = FALSE;
				$error = 'Your listing name contains one or more illegal words which we do not allow. 
						(abortion|illuminaty|pills|penis|viagra|illuminatie|sex|spells)';	

			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
			
			//}elseif(isset($web) && (!filter_var(prep_url($web), FILTER_VALIDATE_URL))){
//						
//				$val = FALSE;
//				$error = 'Please provide us with a valid website address or URL';
						
			//}elseif(str_word_count($description) < 70){
//				$val = FALSE;
//				$error = 'Please provide a minimum of 70 words for your business description. Currently: '.str_word_count(strip_tags($description)).' words.';	
				
			}else{
				$val = TRUE;
			}
				
			
			//Test if Email Exists
			/*$test = $this->db->where('BUSINESS_EMAIL', $email);
			$test = $this->db->get('u_business');
			if($test->num_rows() > 0){
				
				$val = FALSE;
				$error = 'The email address '.$email .' is already in use. Please use a unique email.';
			}*/
				
			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
			$IP = $this->input->ip_address();
			$insertdata = array(
							  'BUSINESS_NAME'=> $name ,
							  'BUSINESS_EMAIL'=> $email,
							  'BUSINESS_TELEPHONE'=> $tel2 ,
							  'TEL_DIAL_CODE'=> $telcode ,
							  'CEL_DIAL_CODE'=> $cellcode,
							  'BUSINESS_CELLPHONE'=> $cell,
							  'FAX_DIAL_CODE'=> $faxcode,
							  'BUSINESS_FAX'=> $fax2,
							  'BUSINESS_DESCRIPTION'=> $description,
							  'BUSINESS_POSTAL_BOX'=> $pobox,
							  'BUSINESS_URL' => $web,
							  'BUSINESS_PHYSICAL_ADDRESS' => $address,
							  'BUSINESS_COUNTRY_ID' => $country,
							  'BUSINESS_MAP_CITY_ID' => $city,
							  'BUSINESS_SUBURB_ID' => $suburb,
							  'BUSINESS_DATE_CREATED' => date('Y-m-d H:i:s')
				);
		
	
			
			if($val == TRUE){
				
					//insert
					$this->db->insert('u_business', $insertdata);

					//success redirect	
					$data['bus_id'] = $this->db->insert_id();
					$data['id'] = $this->session->userdata('id');

					//Get Business ID
					$test = $this->db->where('ID', $data['bus_id'] );
					$test = $this->db->get('u_business');
					$brow = $test->row_array();	

					
					$this->members_model->add_business_member($data['bus_id'],$data['id']);

					//SEND EMAIL 
					$this->add_business_email($brow);

					$data['basicmsg'] = 'Thank you ' . $name .' has been successfully registered';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					redirectbusiness('.$brow['ID'].',"'.$this->clean_url($data['basicmsg']).'");
					</script>
					';
					$this->output->set_header("HTTP/1.0 200 OK");
			}else{
					$data['id'] = $this->session->userdata('id');
					
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
    //+++++++++++++++++++++++++++
	//UPLOAD LOGO
	//++++++++++++++++++++++++++
	
	public function add_logo($bus_id)
	{

		   if($this->session->userdata('admin_id')){
				
			  $this->members_model->add_logo();
			  $data['basicmsg'] = 'Logo added successfully';
			  redirect('/members/business/'.$bus_id.'/'.$this->clean_url($data['basicmsg']));
			
		 }elseif($this->session->userdata('id')){

			  $this->members_model->add_logo();
			  $data['basicmsg'] = 'Logo added successfully';
			  redirect('/members/business/'.$bus_id.'/'.$this->clean_url($data['basicmsg']));
			 
		 }else{
			
			echo 'Please Log in to update the business';  
		
		 }				

	}
	 //+++++++++++++++++++++++++++
	//UPLOAD LOGO AJAX
	//++++++++++++++++++++++++++
	
	public function add_logo_ajax()
	{
			 	
		  if($this->session->userdata('admin_id')){
				  
			  $this->output->set_header("Access-Control-Allow-Origin: http://cms.my.na");
			  $this->members_model->add_logo_ajax();
			  $data['basicmsg'] = 'Logo added successfully';	
			  
		   }elseif($this->session->userdata('id')){

			  $this->output->set_header("Access-Control-Allow-Origin: http://cms.my.na");
			  $this->members_model->add_logo_ajax();
			  $data['basicmsg'] = 'Logo added successfully';	
			   
		   }else{
			  
			  echo 'Please Log in to update the business';  
		  
		   }
		
	}

    //+++++++++++++++++++++++++++
	//UPLOAD COVER IMAGE
	//++++++++++++++++++++++++++
	
	public function add_cover()
	{
			 if($this->session->userdata('admin_id')){ 
				 	
				$this->output->set_header("Access-Control-Allow-Origin: http://cms.my.na");
				$this->members_model->add_cover();
				$data['basicmsg'] = 'Cover Image added successfully';
				
			 }elseif($this->session->userdata('id')){

				$this->output->set_header("Access-Control-Allow-Origin: http://cms.my.na");
				$this->members_model->add_cover();
				$data['basicmsg'] = 'Cover Image added successfully'; 
				 
			 }else{
				
				echo 'Please Log in to update the business';  
			
			 }

	}

    //+++++++++++++++++++++++++++
	//UPLOAD MAP COORDINATES
	//++++++++++++++++++++++++++
	
	public function update_map_coordinates($bus_id)
	{
		
		if($this->session->userdata('id')){
			 	
				$this->members_model->update_map_coordinates();
				$data['basicmsg'] = 'Co-ordinates updated successfully';
				$data['bus_id'] = $bus_id;
				$data['id'] = $this->session->userdata('id');
				redirect('/members/business/'.$bus_id.'/'.$this->clean_url($data['basicmsg']).'/#Map', '301');
		
		}else{
				
				$data['error'] = 'Sorry, you have been logged out of My.Na';
				$this->load->view('login' , $data);
			  
		 }
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPLOAD MAP COORDINATES
	//++++++++++++++++++++++++++
	
	public function load_map_ajax($bus_id)
	{
		
		if($this->session->userdata('id')){
			 	
				$map_details = $this->members_model->get_map_details($ID);
				if(count($map_details) > 0){
				
					$map['lat'] = $map_details['BUSINESS_MAP_LATITUDE'];
					$map['long'] = $map_details['BUSINESS_MAP_LONGITUDE'];
					$map['zoom'] = $map_details['BUSINESS_MAP_ZOOM_LEVEL'];
					
				}else{
					
					$map['lat'] = '-22.583741';
					$map['long'] = '17.093782';
					$map['zoom'] = '7';
					/*?>echo '<script type="text/javascript">$("#map_info").slideDown();</script>';<?php */
				}
				$this->load->view('members/inc/business_map_inc_ajax' , $map);
		
		}else{
				
				$data['error'] = 'Sorry, you have been logged out of My.Na';
				$this->load->view('login' , $data);
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//LOAD REVIEWS
	public function reviews($bus_id)
	{
		 
		if($this->members_model->check_business_user($bus_id)){
			 	
				$this->load->model('rating_model');
				echo '<link href="'. base_url('/').'css/jquery.rating.css" type="text/css" rel="stylesheet"/>
					  <script data-cfasync="false" src="'. base_url('/').'js/jquery.rating.pack.js" type="text/javascript"></script>';
				$this->rating_model->show_reviews_edit($bus_id);
				//$str = "";

				
		}else{
			
				$data['error'] = 'Please login below';
			    $this->load->view('login', $data);
			  
		 }
		
		
	}
	
	//+++++++++++++++++++++++++++
	//LOAD DEALS
	public function deals($bus_id)
	{
		 
		if($this->members_model->check_business_user($bus_id)){
			 	$this->load->model('deal_model');
				$data['bus_id'] = $bus_id;
				$this->deal_model->get_business_deals($bus_id);
				$this->load->view('members/inc/deals_inc', $data);	
		
		}else{ 
			
				$data['error'] = 'Please login below';
			    $this->load->view('login', $data);
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//LOAD USERS FOR THE BUSINESS
	//++++++++++++++++++++++++++
	public function users($bus_id)
	{
		 
		if($this->members_model->check_business_user($bus_id)){
			 	
				$data['bus_id'] = $bus_id;
				$this->members_model->get_business_users($bus_id);
				
		
		}else{
			
				$this->logout();
			  
		 }
		
		
	}
	
	//+++++++++++++++++++++++++++
	//DEL:ETE USERS FOR THE BUSINESS
	//++++++++++++++++++++++++++
	public function delete_user_business()
	{
		 

		$id = $this->input->post('user_id', TRUE); 
		$bus_id = $this->input->post('bus_id', TRUE); 

		if($this->members_model->check_business_user($bus_id)){
			 	
				$this->db->where('ID', $id);
				$this->db->delete('i_client_business');
		
		}elseif($this->session->userdata('admin_id')){
				$this->db->where('ID', $id);
				$this->db->delete('i_client_business');
		}else{
			
				$this->logout();
			  
		 }
		
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD USERS FOR THE BUSINESS
	//++++++++++++++++++++++++++
	public function add_user_business($bus_id,$id)
	{
		 
		if($this->members_model->check_business_user($bus_id)){
			 	
				$this->db->where('CLIENT_ID' , $id);
				$this->db->where('BUSINESS_ID' , $bus_id);
				$query = $this->db->get('i_client_business');
				if($query->result()){
					
					echo '<div class="alert alert-success">User already added</div>';
					
				}else{
					
					$data['CLIENT_ID'] = $id;
					$data['BUSINESS_ID'] = $bus_id;
					$data['USER_TYPE'] = 'EMPLOYEE';
					$this->db->insert('i_client_business', $data);
					
					//GET CLIENT
					$this->db->where('ID' , $id);
					$this->db->from('u_client');
					$client = $this->db->get();
					$client_row = $client->row();
					//GET BUSINESS
					$this->db->where('ID' , $bus_id);
					$this->db->from('u_business');
					$business = $this->db->get();
					$business_row = $business->row();
					//send email
					$body = '<h2>Hi '.$client_row->CLIENT_NAME .',</h2>
							
							<h3>You have now got access to <strong>'.$business_row->BUSINESS_NAME.'</strong></h3>
							You have now got access to the '.$business_row->BUSINESS_NAME.' website admin panel . 
							Your My Namibia ™ account is now linked to the  Namibia Tourism Board website and you will be able to 
							update all your business information accross online platforms in Namibia. 
							These platforms include Team Namibia, Namibian Chamber of Commerce and Industry, the Hospitality Association of Namibia and the Namibian Tourism Board. 
							
							<br /><br />
							Please login to your account and find '.$business_row->BUSINESS_NAME.' under the My Business section in your <a href="'.site_url('/').'members/">dashboard</a>
							<br /><br />
							Please follow the link below:<br /><br />
							<a href="'.site_url('/').'members/" title="activate membership">'.site_url('/').'members/</a>
							<br /><br />
							If you have any questions or need help please contact us.
							Have a !tna day!<br />
							My Namibia';
							
			     	$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news',$data_view, true);
					
					$emailTO = array(array('email' => $client_row->CLIENT_EMAIL));
					$subject = 'You have Access Rights: '.$business_row->BUSINESS_NAME;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = 'My Namibia';
					$TAG = array('tags' => 'add_user' );
					//SEND EMAIL LINK 
					$this->load->model('email_model');	
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	

					echo '<div class="alert alert-success">User added</div>';

				}
				
				
		
		}elseif($this->session->userdata('admin_id')){
			
				$this->db->where('CLIENT_ID' , $id);
				$this->db->where('BUSINESS_ID' , $bus_id);
				$query = $this->db->get('i_client_business');
				if($query->result()){
					
					echo '<div class="alert">User already added</div>';
					
				}else{
					
					$data['CLIENT_ID'] = $id;
					$data['BUSINESS_ID'] = $bus_id;
					$data['USER_TYPE'] = 'EMPLOYEE';
					$this->db->insert('i_client_business', $data);
					//GET CLIENT
					$this->db->where('ID' , $id);
					$this->db->from('u_client');
					$client = $this->db->get();
					$client_row = $client->row();
					//GET BUSINESS
					$this->db->where('ID' , $bus_id);
					$this->db->from('u_business');
					$business = $this->db->get();
					$business_row = $business->row();
					//send email
					$body = '<h2>Hi '.$client_row->CLIENT_NAME .',</h2>
							
							<h3>You have now got access to <strong>'.$business_row->BUSINESS_NAME.'</strong></h3>
							You have now got access to the '.$business_row->BUSINESS_NAME.' website admin panel . 
							Your My Namibia ™ account is now linked to the  Namibia Tourism Board website and you will be able to 
							update all your business information accross online platforms in Namibia. 
							These platforms include Team Namibia, Namibian Chamber of Commerce and Industry, the Hospitality Association of Namibia and the Namibian Tourism Board. 
							
							<br /><br />
							Please login to your account and find '.$business_row->BUSINESS_NAME.' under the My Business section in your <a href="'.site_url('/').'members/">dashboard</a>
							<br /><br />
							Please follow the link below:<br /><br />
							<a href="'.site_url('/').'members/" title="activate membership">'.site_url('/').'members/</a>
							<br /><br />
							If you have any questions or need help please contact us.
							Have a !tna day!<br />
							My Namibia';
							
			     	$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news',$data_view, true);
					
					$emailTO = array(array('email' => $client_row->CLIENT_EMAIL));
					$subject = 'You have Access Rights: '.$business_row->BUSINESS_NAME;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = 'My Namibia';
					$TAG = array('tags' => 'add_user' );
					//SEND EMAIL LINK 
					$this->load->model('email_model');	
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	
				}
			  
		 }else{
			$this->logout(); 
			 
		 }
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE HAN EVALUATION STATUS
	//++++++++++++++++++++++++++	
	function set_eval_status($id, $status, $bus_id)
	{	
		
		if($this->members_model->check_business_user($bus_id)){
			 	
				$this->load->model('han_model');
				$this->han_model->set_eval_status($id, $status);
		
		}else{
			
				echo '<div class="aler">You do not have access to that business</div>';
			  
		 }
		
	}
	
	//GET HAN EVALUATIONS
	function han_evaluations($bus_id){
		
		if($this->members_model->check_business_user($bus_id)){
			
			$this->load->model('han_model');
			$this->han_model->han_evaluations($bus_id);
			
		}else{
			
			echo '<div class="aler">You do not have access to that business</div>';
		}


	}
	//GET SINGLE HAN EVALUATIONS
	function load_han_evaluation($id, $user_id, $bus_id){
		
		if($this->members_model->check_business_user($bus_id)){
			
			$this->load->model('han_model');
			$this->han_model->load_han_evaluation($id, $user_id, $bus_id);
	
		}else{
			
			echo '<div class="aler">You do not have access to that business</div>';
		}
	}
	
	//GET USER DROPDOWN
	public function instant_user($key)
	{
			
			$this->members_model->search_ajax_user($key);
			
	}
	
	
    //+++++++++++++++++++++++++++
	//UPLOAD GALLERY IMAGES     
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		 $this->load->library('image_lib');	
		 $this->load->library('upload');  // NOTE: always load the library outside the loop
		 $bus_id = $this->input->post('bus_id_gal', TRUE);
		 $id = $this->input->post('user_id', TRUE);
		 
		 if(isset($_FILES['files']['name'])){
				$this->total_count_of_files = count($_FILES['files']['name']);
				/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
		 
				 for($i=0; $i<$this->total_count_of_files; $i++)
				 {
				
				   $_FILES['userfile']['name']    = $_FILES['files']['name'][$i];
				   $_FILES['userfile']['type']    = $_FILES['files']['type'][$i];
				   $_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
				   $_FILES['userfile']['error']       = $_FILES['files']['error'][$i];
				   $_FILES['userfile']['size']    = $_FILES['files']['size'][$i];
				
				   
				   $config['upload_path'] = BASE_URL.'assets/business/gallery/';
				   $config['allowed_types'] = 'jpg|jpeg|gif|png';
				   $config['overwrite']     = FALSE;
				   $config['max_size']	= '0';
				   $config['max_width']  = '8324';
				   $config['max_height']  = '8550';
				   $config['min_width']  = '200';
				   $config['min_height']  = '200';
				   $config['remove_spaces']  = TRUE;
				   $config['encrypt_name']  = TRUE;
				   
				
				  $this->upload->initialize($config);
				
					  if($this->upload->do_upload())
					  {
						//$file = array('upload_data'
						  $data = array('upload_data' => $this->upload->data());
						  $file =  $this->upload->file_name;
						  $width = $this->upload->image_width;
						  $height = $this->upload->image_height;	
						  //delete old photo
						  //$this->delete_old_child_photo($child_id,$pro_id);
						  //$this->update_pro_book_image($child_id,$pro_id,$file);
								   
							  if (($width > 850) || ($height > 700)){
									   
									  $str = 'children';	 
									  $this->members_model->downsize_gallery_image($file);
											  
							  }
							//WATERMARK IMAGE	
							$this->members_model->watermark_gallery_image($file);	
							  
							  //populate array with values
							  $data = array(
								  'BUSINESS_ID' => $bus_id,  
								  'GALLERY_PHOTO_NAME'=> $file
							   
							  );
							 
							//insert into database
							 $this->db->insert('u_gallery_component',$data);
							 
							 if ($this->is_han_member($bus_id)){
								 
								  //Tourism DB
								 //$db2 = $this->connect_tourism_db();
								// $db2->insert('u_gallery_component',$data);
								 
							 }


							  //SEND TO BUCKET
							  //$this->load->model('gcloud_model');
							  //$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/business/gallery/');

							 //crop
							  $data['filename'] = $file;
							  $data['width'] = $this->upload->image_width;
							  $data['height'] = $this->upload->image_height;
							  $val = TRUE;
							  $image = CDN_URL . 'assets/business/gallery/'.$file;

							  $folder_path = 'assets/business/gallery/'.$file;
							  $this->load->model('cron_model');
							  //UPLOAD S3
							  if(file_exists(BASE_URL.$folder_path)){

								  $data['out'] = $this->cron_model->upload_s3($folder_path);
							  }else{

								  $data['out'] = 'Not Uploaded';

							  }

							  //$this->output->set_header("HTTP/1.0 200 OK");
						
						
					  }else{
						//ERROR
							$val = FALSE;
							$data['error'] =  $this->upload->display_errors();
							 
						
					  }
				 }
				 //redirect
				 if($val == TRUE){
					  
				 $data['basicmsg'] = $i .' Photos added successfully!';
				 echo '<div class="alert alert-success">
						 <button type="button" class="close" data-dismiss="alert">×</button>
						'. $data['basicmsg'].'
						 </div>
					<script type="text/javascript">
						show_gallery();
					</script>';
					
				 }else{
					 
					 echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>'
							 . $data['error'].'
							 </div><script type="text/javascript">
								console.log("error");
								
							</script>';
				 }
		 }else{
			  echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						 No Files Selected - Please select some files and try again
						 </div><script type="text/javascript">
							console.log("error");
							
						</script>';
			 
		 }
	}

	//SHOW ALL IMAGES IMAGE MANAGER		
	function show_all_gallery_images($bus_id)
	{
			
			$this->members_model->show_all_gallery_images($bus_id);
			
		
	}
	//DELETE GALLERY IMAGE
	function gallery_img_delete($img_id)
	{
		 
			$this->db->where('ID' , $img_id);
			$query = $this->db->get('u_gallery_component');
			$row = $query->row_array();
			
			$img_file = $row['GALLERY_PHOTO_NAME'];
			$bus_id = $row['BUSINESS_ID'];
			
			if($row['GALLERY_PHOTO_NAME'] != '0'){
				
					   $file_large = BASE_URL .'assets/business/gallery/' . $img_file; # build the full path		
		
					   if (file_exists($file_large)) {
							
							if(unlink($file_large)){
													
									//delete image
												
									$this->db->where('ID' , $img_id);
									$this->db->delete('u_gallery_component');
									//Tourism DB
									/*$db2 = $this->connect_tourism_db();
									$db2->where('GALLERY_PHOTO_NAME' , $img_file);
									$db2->delete('u_gallery_component');*/
									
									echo 
									'<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">×</button><p>Image Deleted successfully!</p>
									 </div><script type="text/javascript">
										show_gallery();
									</script>';	
								
							
							}
						
						
						}else{
							
							//delete image
												
									$this->db->where('ID' , $img_id);
									$this->db->delete('u_gallery_component');
									//Tourism DB
									/*$db2 = $this->connect_tourism_db();
									$db2->where('GALLERY_PHOTO_NAME' , $img_file);
									$db2->delete('u_gallery_component');*/
							
							echo 
									'<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">×</button><p>Image Deleted successfully</p>
									 </div>
									 <script type="text/javascript">
										show_gallery();
									</script>';	
							
						}
 
						
				
			//no existing image	
			}else{
				
				echo 
						'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Image could not be deleted!</p>
						 </div><script type="text/javascript">
							show_gallery();
						</script>'; 
			}			
	
	}


	//++++++++++++++++++++++++++++++++++++++++++++
	//IS HAN MEMBER
	//++++++++++++++++++++++++++++++++++++++++++++	

	function is_han_member($bus_id){

		$this->db->where('ID', $bus_id);
		$this->db->where('IS_HAN_MEMBER', 'Y');
		$query = $this->db->get('u_business');
		
		if($query->result()){
			
			return TRUE;
		
		}else{
			
			return FALSE;
				
		}
		
	}	

	//++++++++++++++++++++++++++++++++++++++++++++
	//CLAIM A BUSINESS
	//++++++++++++++++++++++++++++++++++++++++++++	

	function claim_business(){

		$this->members_model->claim_business();
	}
	//++++++++++++++++++++++++++++++++++++++++++++
	// LOAD CLAIM A BUSINESS
	//++++++++++++++++++++++++++++++++++++++++++++	

	function load_claim_business(){

		$this->members_model->load_claim_business();
	}
	//++++++++++++++++++++++++++++++++++++++++++++
	// CMS LOGIN
	//++++++++++++++++++++++++++++++++++++++++++++	
	function my_cms($bus_id){
		
		if($this->members_model->check_business_user($bus_id)){
			$data['bus_id'] = $bus_id;
			$this->load->view('business/inc/login_cms', $data);
		}else{
			
			echo '<div class="aler">You do not have access to that business</div>';
		}


	}
	//++++++++++++++++++++++++++++++++++++++++++++
	// CMS LOGIN DO
	//++++++++++++++++++++++++++++++++++++++++++++	
	function my_cms_login(){
		
		$db = $this->connect_my_cms_db();
		

	}
/**
++++++++++++++++++++++++++++++++++++++++++++
//BUSINESS ANALYTICS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	function get_business_analytics($bus_id,$period){
		
		$data['bus_id'] = $bus_id;
		$data['period'] = $period; 
		$this->load->view('members/inc/business_analytics',$data);
		
		
	}
	function get_business_analytics_month($bus_id){
		
		$data['bus_id'] = $bus_id;
		$this->load->view('members/inc/business_analytics_month',$data);
		
		
	}
		
/**
++++++++++++++++++++++++++++++++++++++++++++
//PHONE NUMBER VALIDATIONS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
  //+++++++++++++++++++++++++++
	//PREPEND CELL
	//++++++++++++++++++++++++++	
	function clean_contact($nr)
	{	
		//$nr = '+264 (0) 8171717 23';
		//remove ' ' , (, ), +
		$str1 = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('+','',$nr))));
		//get 1st 3 digits
		$str2 = substr($str1,0,3);
		
		if($str2 == '264'){

			$str3 = str_replace("264","",$str1);
			
		}else{

			$str3 = $str1;
		}
		
		return $str3;
		
		
	}		
    //+++++++++++++++++++++++++++
	//VALIDATE CELL
	//++++++++++++++++++++++++++	
	function validate_cell($nr)
	{
		switch($nr)
			{
			case '081':
			  
			  $val = FALSE;
			  return $val;
			  break;
			case '085':
			 
			 $val = FALSE;
			 return $val;
			 break;
			case '060':
			  
			 $val = FALSE;
			 return $val;
			 break;
			default:
			  $val = TRUE;
			  return $val;
			  
			}	
	}
/**
++++++++++++++++++++++++++++++++++++++++++++
//VALIDATE EMAIL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function CheckAndValidateEmail($mail){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        // ok
        //list($user,$domaine)=split("@",$mail,2);
        //if(!checkdnsrr($domaine,"MX")&& !checkdnsrr($domaine,"A")){
            return FALSE;
        //}
       // else {
           // return FALSE;
        //}
    }
    else {
        return TRUE;
    }
}


/**
++++++++++++++++++++++++++++++++++++++++++++
//CLEAN URLS 4 MESSAGING
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function clean_url($str)
	{
		$str2 = str_replace(' ','-',str_replace("'","_",$str));
		return $str2;
	}
	
function un_clean_url($str)
	{
		$str2 = str_replace('-',' ',str_replace("_","'",$str));
		return $str2;
	}			

		
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login()
	{

			$this->load->library('encrypt');

			if($email = trim($this->input->post('email', TRUE))){
				

					$first = $this->input->post('first_log', TRUE);
					$pass = $this->input->post('pass', TRUE);
					$sess = $this->input->post('rememberme', TRUE);
					$redirect = $this->input->post('redirect', TRUE);
		
					/*if($this->input->get('redirect', TRUE)){
		
						$redirect = $this->input->get('redirect', TRUE);
					}*/
		
					//MATCH CREDENTIALS
					$row = $this->members_model->validate_password($email,$pass);
					if($row['bool'] == 'YES'){
							
							//HASH PASSWORD AGAIN
							$pass_new = $this->members_model->hash_password($email,$pass);
							//create user array
							 $data = array(
							   'CLIENT_UA' => $this->agent->browser() . ' ver ' . $this->agent->version(),
							   'CLIENT_IP' => $this->input->ip_address(),
							   'LAST_LOGIN' => date("Y-m-d H:i:s"),
							   'CLIENT_PASSWORD' => $pass_new
							);
							
							//GET ALL PUB SUBSCRIPTIONS
							$subA = array();
							/*$sub = $this->db->where('client_id', $row['ID']);
							$sub = $this->db->get('u_client_subscription');
							$subA = array();
							if($sub->result()){
								
								foreach($sub->result() as $subrow){
									
									if(date('Y-m-d', strtotime($subrow->subscribed_until)) > date('Y-m-d')){
										
										$subA[$subrow->pub_bus_id] = $subrow->subscribed_until;
										//array_push($subA, array('bus_id' => $subrow->pub_bus_id, 'until' => $subrow->subscribed_until));
										
									}
									
									
								}
							}*/
							
							
							if ($sess == TRUE) {
							//$this->session->cookie_monster();	
							}
							/*$this->session->set_userdata('id', $row['ID']);
							$this->session->set_userdata('u_name', $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] );
							$this->session->set_userdata('fb_id', $row['FB_ID']);
							$this->session->set_userdata('img_file', $row['CLIENT_PROFILE_PICTURE_NAME']);
							$this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));
							$this->session->set_flashdata('login', 'yes');*/
		
							$this->load->model('my_na_model');

							$sess = array(
		
								'id' => $row['ID'],
								'u_name' => $row['CLIENT_NAME'],
								'u_email' => $row['CLIENT_EMAIL'],
								'fb_id' => $row['FB_ID'],
								'img_file' => $row['CLIENT_PROFILE_PICTURE_NAME'],
								'points' => $this->my_na_model->count_points($row['ID']),
								'login' => 'yes',
								'subscriptions' => $subA,
								'register_date' => $row['REGISTER_DATE']
		
							);

							$this->session->set_userdata($sess);
							$this->session->set_flashdata('login', 'Y');
		
							$this->db->where('ID', $row['ID']);
							$this->db->update('u_client', $data); 
							//SEE IF 1st Login
							if($first == 'Y'){
								
								$this->session->set_flashdata('first_login', 'Y');
									
							}
		
		
							if($this->input->is_ajax_request())
							{
								echo '<script type="text/javascript">
										window.location.reload();
									  </script>';
		
							}else{
		
								//--------------
								//Redirect
								if(strlen($redirect) > 2){
									
									if(strstr($redirect,'check_me_back')){
										
										$d['my_na_id'] = $row['ID'];
										$d['u_name'] = $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'];
										$d['u_email'] = $row['CLIENT_EMAIL'];
										$d['img_file'] = $row['CLIENT_PROFILE_PICTURE_NAME'];
										$d['city'] = $this->session->userdata('city');
										$d['country'] = $this->session->userdata('country');
										$d['points'] = $sess['points'];
										$d['subscriptions'] = $subA;
										$d['register_date'] = $row['REGISTER_DATE'];
										$redirect = $redirect.'&sess='.$this->encrypt->encode(json_encode($d));
									}
									redirect($redirect, 301);
									
								}elseif($row['VERIFIED'] == 'N'){
		
									redirect('/clients/verify/');
									
								}else{
		
									redirect(site_url('/'), 'refresh');
		
								}
		
							}
		
						
					}elseif($row['bool'] == 'NO'){
						$data['redirect'] = $redirect;
						$data['error'] = 'Your password did not match our records! Please update your password for '.$email;
						//echo $this->encode($pass) .' ' ;
		
						if($this->input->is_ajax_request()){
							echo '<div class="alert alert-error">'.$data['error'].'</div>';
		
						}else{
		
							$this->load->view('login' , $data);
		
						}

						
					//NO MATCHING CREDENTIALS
					}else{
						
						$data['redirect'] = $redirect;
						$data['error'] = 'Your credentials did not match. Please ensure you have the correct email address and password.';
						//echo $this->encode($pass) .' ' ;
						if($this->input->is_ajax_request()){
		
							echo '<div class="alert alert-error">'.$data['error'].'</div>';
						}else{
		
							$this->load->view('login' , $data);
		
						}
					
					}
								//NO MATCHING CREDENTIALS
			}else{
				

				$data['redirect'] = '';
				$this->load->view('login' , $data);
				
			}
	}


	function logout($referer = ''){

		//$this->session->sess_destroy();  
		//redirect(site_url('/'),'refresh');
		//if user clicks logout
		if($this->input->get('redirect')){
			
			$log['FB_LOGOUT'] = 'Y';
			$this->db->where('ID', $this->session->userdata('id'));
			$this->db->update('u_client', $log);
			
			$this->session->sess_destroy();
			
			$data['redirect'] = $this->input->get('redirect');
			if($data['redirect'] == ''){
				
				redirect(site_url('/'), 301);
			}else{
				
				redirect($data['redirect'], 301);
			}
			
		
		//if session expired	
		}elseif($referer != ''){
			
			$data['redirect'] =  $referer;
			/*$this->session->unset_userdata('id');
			$this->session->unset_userdata('u_name');
			$this->session->unset_userdata('last_login');
			$this->session->unset_userdata('img_file');
			$this->session->unset_userdata('points');*/
			$this->session->sess_destroy();
			$data['basicmsg'] = 'Please log in below!';
			$this->load->view('login' , $data);
			
		}else{
			
			$this->session->sess_destroy();
			redirect(site_url('/'), 301);
			
		}
		

		
	}

	

	function logout2($referer = ''){

		//$this->session->sess_destroy();  
		//redirect(site_url('/'),'refresh');
		//if user clicks logout
		if($this->input->post('redirect')){
			
			$log['FB_LOGOUT'] = 'Y';
			$this->db->where('ID', $this->session->userdata('id'));
			$this->db->update('u_client', $log);
			
			$this->session->sess_destroy();
			
			$data['redirect'] = $this->input->post('redirect');
			if($data['redirect'] == ''){
				redirect(site_url('/'), 301);
			}else{
				redirect($data['redirect'], 301);
			}
			
		
		//if session expired	
		}elseif($referer != ''){
			
			$data['redirect'] =  $referer;
			$this->session->sess_destroy();
			$data['basicmsg'] = 'Please log in below!';
			$this->load->view('login' , $data);
			
		}else{
			
			$this->session->sess_destroy();
			redirect(site_url('/'), 301);
			
		}
	}


	function forgot_password(){

		$this->load->view('login' , $data);
	}
	
	function unsubscribe_daily($id = ''){

		$data['unsubscribe_daily'] = 'Y';
		$this->load->view('login' , $data);
	}
	
	public function encrypt()
	{
		//$str = str_replace('_-_','@',$str);
		$str = 'roland@intouch.com.na';
		$pass = '123';
		echo $this->members_model->hash_password($str,$pass);	
		
	}
	
	public function decrypt()
	{
		
		$str = 'roland@my-child.co.nz';
		$pass = '123';
		
		$row = $this->members_model->validate_password($str,$pass);
		if($this->members_model->validate_password($str,$pass)){
			
			echo 'YES';
		
		}else{
			
			echo 'No';
			
		}
		
	}

//++++++++++++++++++++++++++++++++++++++++++++
////LOAD TABS
////Functions
//++++++++++++++++++++++++++++++++++++++++++++

	public function load_tna($bus_id)
	{
		
		$this->members_model->get_business_tna($bus_id);
		
	}
	
	public function load_qr($bus_id)
	{
		$this->load->model('business_model');

		echo $this->load->view('members/inc/business_qr_code', $bus_id);
			
	}
	
	public function download_load_qr($bus_id)
	{
		$this->load->model('business_model');
		$this->load->helper('download');
		$data = file_get_contents($this->business_model->get_qr_vcard_src($bus_id)); // Read the file's contents
		$name = 'My_Namibia_QR.jpg';

		force_download($data);
		
	}
	
	public function load_tna_mail($bus_id)
	{
		
		$this->members_model->get_business_tna_mail($bus_id);
		
	}
	
	public function enquiries($bus_id, $status = '')
	{
		if($status == ''){
			
			$status = 'all';
				
		}
		$this->members_model->get_business_enquiries_status($bus_id ,$status);
		
	}
	
	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//AMENITIES
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
	 */	
	function update_amenities()
	{
		
		$bus_id = $this->input->post('bus_id');
		
		if($this->session->userdata('admin_id')){
			
			$this->members_model->update_amenities($bus_id);
			
		}elseif($this->session->userdata('id')){
			
			
			if($this->members_model->check_business_user($bus_id)){
			
				$this->members_model->update_amenities($bus_id);
			
			}else{
			
				echo 'You do not have access to that business!';	
				
			}
			
			
		}else{
			
			redirect('/members/logout/', 301);	
			
		}

	}
	
	function amenities($bus_id)
	{
		
		$this->db->where('ID', $bus_id);
		$bus_details = $this->db->get('u_business');
		$bus_details = $bus_details->row_array();

		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/inc/business_amenities_inc', $bus_details);
			
		}elseif($this->session->userdata('id')){
			
			
			if($this->members_model->check_business_user($bus_id)){
			
				$this->load->view('admin/inc/business_amenities_inc', $bus_details);
			
			}else{
			
				echo 'You do not have access to that business!';	
				
			}
			
			
		}else{
			
			redirect('/members/logout/', 301);	
			
		}

	}
				
/**
++++++++++++++++++++++++++++++++++++++++++++
//FORGOT PASSWORD
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	

	function pass_update_external($email)
	{
			$this->output->set_header("Access-Control-Allow-Origin: https://events.my.na");
			$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
			$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
			$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
			$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
			$clean = urldecode($email);
			
			
			$this->db->where('CLIENT_EMAIL',trim($clean));
			$test = $this->db->get('u_client');
			
			if($test->num_rows() > 0){
				 
				 $this->load->model('my_na_model');	
				 $row = $test->row_array();
				 $this->new_password_email($row);
				
				 $data['basicmsg'] = 'We have sent an email with the password link to: ' .$email;
				 
				 $result = array('result' => "success", 'user'=>$row['CLIENT_NAME'] .' ' .$row['CLIENT_SURNAME'], 'user_id'=> $row['ID'], 'points'=> $this->my_na_model->count_points($row['ID']));
				 echo json_encode($result);
				
			}else{
				
				 
				 $data['error'] = 'No records found for ' .$email .'. Please create a new user account <a href="'.site_url('/').'members/register/">here</a>' ;
				 $result = array('result' => "failure");
				 echo json_encode($result);
				
			}
        
		
	}

	function pass_update_one()
	{
		if($this->input->post('passemail')){
			$email = $this->input->post('passemail', TRUE);
	
			$this->db->where('CLIENT_EMAIL',$email);
			$test = $this->db->get('u_client');
			
			if($test->num_rows() > 0){
				
				 $row = $test->row_array();
				 $this->new_password_email($row);
				
				 $data['basicmsg'] = 'We have sent an email with the password link to: ' .$email;
				 $this->load->view('login', $data); 
				
				
			}else{
				
				 
				 $data['error'] = 'No records found for ' .$email .'. Please create a new user account <a href="'.site_url('/').'members/register/">here</a>' ;
				  
				 $this->load->view('login', $data);
			}
        
		}else{
			
			$this->load->view('login');
		}

	}
	
	function pass_update_two($token)
	{
	
		$this->db->where('token',$token);
		$this->db->where('type','password');
		$test = $this->db->get('password_links');
		if($test->num_rows() > 0){
				
				$row = $test->row_array();
			    $data['step1'] = 'true';
				$data['token'] = $token;
				$data['client_id'] = $row['client_id'];
				$this->load->view('login', $data);
			
		}else{
			 
			 $data['type'] = 'teacher';
			 $data['error'] = 'Sorry that link has expired';
			 $this->load->view('login', $data); 
			
		}   

	}
	
	
	function pass_update_three()
	{
		$client_id = $this->input->post('id', TRUE);
		$pass = $this->input->post('pass1', TRUE);
		$token = $this->input->post('token', TRUE);
		//get details
		$this->db->where('token', $token);
		$query = $this->db->get('password_links');
		
		if($query->result()){
			
			$row = $query->row_array();
			$email = $row['email']; 
			//Update Profile table
			$new = $this->members_model->hash_password($email,$pass);
			$data['CLIENT_PASSWORD'] = $new;
			$this->db->where('ID',$row['client_id']);
			$this->db->update('u_client',$data);
			
			//DELETE link
			$this->db->where('token',$token);
			$this->db->where('type','password');
			$this->db->delete('password_links');
		   
			$data['basicmsg'] = 'Your password has been reset. Please login';
			$data['client_id'] = $client_id;
			$this->load->view('login', $data); 	
			
			
		}else{
			
			$this->load->view('login', $data); 
		}    

	}

	function new_password_email($row)
	{


		$this->load->library('user_agent');
		$this->load->library('encrypt');

		if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){

			if(!$IP = $_SERVER['HTTP_CF_CONNECTING_IP']){

				$IP = $this->input->ip_address();
			}

		}else{
			$IP = $this->input->ip_address();

		}


		$client = $this->agent->browser().' '.$this->agent->version();
		//$data['referrer'] = $this->agent->referrer();

		//create key
		//$token = $this->encrypt->sha256($row['ID']);
		$token = hash( "sha256", $row['ID'] );
		
		//insert data
		$link = '<a href="'.site_url('/').'members/pass_update_two/'.$token.'" >Reset Password Here</a>';
		$link2 = site_url('/').'members/pass_update_two/'.$token;
		$data['client_id'] = $row['ID'];
		$data['email'] = $row['CLIENT_EMAIL'];
		$data['name'] = $row['CLIENT_NAME'];
		$data['link'] = $link;
		$data['type'] = 'password';
		$data['token'] = $token;
		$this->db->insert('password_links',$data);
		

		$data2['link'] = site_url('/').'members/pass_update_two/'.$token;
		$data2['custom'] = $link;
		$data2['name'] = $row['CLIENT_NAME'];
		  
		//$body1 = $this->load->view('email/body_email_password',$data2,true);

		$body1 = '<p>Hi '.$row['CLIENT_NAME'].',</p>
                <p>We have received a request to generate a new password for your<br /> My Namibia account.
                If you have not requested a new password please ignore this email. </p>
                <p>
                If you have lost your password and wish to set a new one please click on the link below.</p>
                <p>'.$link2.'</p>
                <p>If you cannot click on the link above please copy and paste it into your browser.</p>
                <p>Have a great day.</p>
                <p>My Namibia</p>
                <p>This email was sent From '.$this->session->userdata('country').' '.$this->session->userdata('city').' IP: '.$IP.' via '.$client.'</p>';

		$emailTO = array(array('email' => $row['CLIENT_EMAIL']));
		$subject = 'New Password Request Alert- My Namibia';
		$fromEMAIL = 'account-request@my.na';
		$fromNAME = 'My Namibia';
		$TAG = array('tags' => 'password_reset' );
			
		$this->load->model('email_model');
									
		$this->email_model->send_mail($body1, $subject, $emailTO, $fromEMAIL , $fromNAME, $TAG,$important = true, $global_merge = '', $merge = '', $from = 'account-request');
		
		
	}
	
	//connect to tourism db
	function connect_tourism_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'hannamib_devuser';
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
	
	   	//connect to tourism db
	function connect_my_cms_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'cmsmy_user';
		$config_db['password'] = '6kT{#rpx@}R.';
		$config_db['database'] = 'cmsmy_db';
		
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */