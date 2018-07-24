<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sell extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 public function __construct()
    {
         //echo "OldClass constructor\n";
		 parent::__construct();
		 $this->load->model('sell_model');
		 $this->load->model('members_model');
		 $this->load->model('trade_model');
		
    }
	
	public function Sell()
	{
		//
		//self::__construct(); 
		//parent::__construct();
		$this->CI_Controller();

	} 
	
	
	//+++++++++++++++++++++++++++
	//SELL/INDEX
	//++++++++++++++++++++++++++
	public function index($bus_id = 0, $type = '')
	{
		if($this->session->userdata('id'))
		{

			$this->load->model('members_model');
			$data = $this->members_model->get_my_account($this->session->userdata('id'));

			if($data['VERIFIED'] == 'Y'){

				$data['step'] = 0;
				$data['bus_id'] = $bus_id;
				$data['product_id'] = 0;

                if($bus_id != 0){

                    $this->db->where('ID', $bus_id);
                    $q = $this->db->get('u_business');

                    $row = $q->row_array();

                    $data['business_name'] = $row['BUSINESS_NAME'];
                    $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                    $data['cover'] = $row['BUSINESS_COVER_PHOTO'];
                }

                $data['private'] = 'no';
                if($this->input->get('private')){

                    $data['private'] = 'yes';
                }

                $data['type'] = $type;


				if($type == 'auction'){

					$data['auction'] = 'true';

				} else {

					$data['auction'] = 'false';

				}

                $this->load->view('trade/list/main', $data);

			}else{

				$data['error'] = 'Please verify your account to continue';
				$this->load->view('members/verify', $data);

			}



		}else{


            $data['error'] = 'Sorry, please login to continue';
            $data['title'] = 'Buy and Sell Anything in Namibia';
            $data['heading'] = 'Buy and Sell Anything in Namibia';
            $data['metaD'] = 'Need some extra Cash? The Buy and Sell platform from My Namibia will help you turn junk into cash - Try it today.';
            $this->load->view('adverts/listing_landing_page', $data);

			//$this->load->view('login' , $data);

		}
		
	}
	//+++++++++++++++++++++++++++
	//SELL FEATURED LISTIN @ N$ 99 
	//++++++++++++++++++++++++++
	public function featured($bus_id = 0)
	{
		if($this->session->userdata('id'))
		{
            $data['title'] = 'Feature your listing';
            $data['heading'] = 'Feature your listing to get more exposure';
            $data['metaD'] = 'Feature your product listing - Try it today.';
            $this->load->view('adverts/listing_featured_page', $data);
			$this->load->view('adverts/listing_featured_page', $data);

		}else{


            //$data['error'] = 'Sorry, please login to continue';
            $data['title'] = 'Feature your listing';
            $data['heading'] = 'Feature your listing to get more exposure';
            $data['metaD'] = 'Feature your product listing - Try it today.';
            $this->load->view('adverts/listing_featured_page', $data);

			//$this->load->view('login' , $data);

		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+BUILD CLASSIFIEDCATEGORY SEARCH
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function build_typehead($bus_id, $type){

		$this->load->model('classified_model');
		$this->classified_model->build_typehead($bus_id, $type);

	}
	//+++++++++++++++++++++++++++
	//SELL/INDEX
	//++++++++++++++++++++++++++
	public function classifieds($bus_id = 0)
	{

		if($client_id = $this->session->userdata('id'))
		{
			
			$this->load->model(array('members_model','s3_model'));
			$data = $this->members_model->get_my_account($client_id);
	
			if($data['VERIFIED'] == 'Y'){
	
				$data['step'] = 0;
				$data['bus_id'] = $bus_id;
				$data['product_id'] = 0;
				$data['client_id'] = $client_id;
	
				if($bus_id != 0){
	
					$this->db->where('ID', $bus_id);
					$q = $this->db->get('u_business');
	
					$row = $q->row_array();
	
					$data['business_name'] = $row['BUSINESS_NAME'];
					$data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
					$data['cover'] = $row['BUSINESS_COVER_PHOTO'];
				}
				$data['private'] = 'no';
				if($this->input->get('private')){
	
					$data['private'] = 'yes';
				}
				$data['type'] = '';
				if($this->input->get('type')){
	
					$data['type'] = $this->input->get('type');
				}
	
				if(!$data['auction'] = $this->input->get('auction')){
	
					$data['auction'] = 'false';
				}
				
				$data['s3FormDetails'] = $this->s3_model->getS3Details('mynamibia-eu', 'eu-west-1', 'public-read');
				
				$this->load->view('trade/list/v2/main', $data);
	
			}else{
	
				$data['error'] = 'Please verify your account to continue';
				$this->load->view('members/verify', $data);
	
			}
		}else{

			redirect(site_url('/').'sell/lookup/?nmh_classifieds=true', 301);
			
		}


	}

	//++++++++++++++++++++++++++++++
	//INSERT IMAGE DB AFTER UPLOAD
	//++++++++++++++++++++++++++++++
	public function update_classified_img()
	{
		if($id = $this->input->get('product_id')){
			
			$data = $this->input->get('res');
			$o['data'] = $data;
			
			$o['success'] = true;
			
		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}


		echo json_encode($o);
	}
	//++++++++++++++++++++++++++++++
	//NMH ADVERTISING USER SELECTION
	//++++++++++++++++++++++++++++++
	public function finish_classifieds_product($product_id, $val)
	{
		if($product_id != 0){
			
			$this->load->model('product_model');
			$o = $this->product_model->send_user_product_link($product_id);
			//UPDATE FEATURED COLUMN
			$data['is_featured'] = 'R';
			$data['featured_until'] = date('Y-m-d',  strtotime("+30 days"));
			$this->db->where('product_id', $product_id);
			$this->db->update('products', $data);
			$this->session->sess_destroy();
		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}


		echo json_encode($o);
	}
	//++++++++++++++++++++++++++++++
	//NMH ADVERTISING USER SELECTION
	//++++++++++++++++++++++++++++++
	public function finish_classifieds($product_id, $val)
	{
		if($product_id != 0){
			
			$this->load->model('classified_model');

			//UPDATE FEATURED COLUMN
			$data['featured'] = 'R';
			$data['featured_until'] = date('Y-m-d',  strtotime("+30 days"));
			$this->db->where('classified_id', $product_id);
			$this->db->update('classifieds', $data);

			$o = $this->classified_model->send_user_classifieds_link($product_id);
			$this->session->sess_destroy();
			
		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}


		echo json_encode($o);
	}
	//++++++++++++++++++++++++++++++
	//NMH ADVERTISING USER SELECTION
	//++++++++++++++++++++++++++++++
	public function lookup($bus_id = 0)
	{
		$this->session->sess_destroy();
		$data = $this->my_na_model->get_ip_location();
		$this->load->view('members/client_lookup', $data);
	}
	//++++++++++++++++++++++++++++++
	//NMH ADVERTISING USER SELECTION
	//++++++++++++++++++++++++++++++
	public function find_client($str = '')
	{
		if($str = $this->input->get('q', TRUE)){
			
			$data = $this->sell_model->find_users(urldecode($str));	
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//USE LOOKUP ACCOUNT
	//++++++++++++++++++++++++++
	public function use_account($id = '')
	{
		if($id = $this->input->get('link')){
			
			$this->load->library('encrypt');
			$row = json_decode($this->encrypt->decode($id));
			//$this->session->unset_userdata();
			$sess = array(

				'id' => $row->ID,
				'u_name' => $row->FNAME. ' ' .$row->SNAME,
				'img_file' => $row->IMG,
				'points' => $this->my_na_model->count_points($row->ID),
				'login' => 'yes'
	
			);
			//$this->session->set_userdata($sess);
			$this->session->set_userdata($sess);
				
			$o['success'] = true;
			$o['msg'] = 'Success';
			
			//var_dump($this->session->all_userdata());
		}else{
			$o['msg'] = 'Link Not Supplied';
			$o['success'] = false;	
		}
		echo json_encode($o);
	}
	//+++++++++++++++++++++++++++
	//NMH ADVERTISING
	//++++++++++++++++++++++++++
	public function nmh($bus_id = 0)
	{
		
	}
	//++++++++++++++++++++++++++++++++++++
	//MY PRODUCTS
	//++++++++++++++++++++++++++
	//HOME
	//++++++++++++++++++++++++++++++++++++
	public function my_trade($bus_id = 0, $section = '')
	{ 
		if($this->session->userdata('id')){
			$data['business_name'] = '';
			if($bus_id != 0){
				if(!$row = $this->members_model->check_business_user($bus_id)){
					$data['error'] = 'Sorry, please login to continue';
					$this->load->view('login' , $data);
					return;
				}else{

					$data['business_name'] = $row['BUSINESS_NAME'];
                    $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                    $data['cover'] = $row['BUSINESS_COVER_PHOTO'];
				}
			}
			
			$data['bus_id'] = $bus_id;
			$data['section'] = $section;
			
			$this->load->view('trade/my_trade', $data);	
		}else{
			
				$data['error'] = 'Sorry, please login to continue';
				$this->load->view('login' , $data);
		}
	}
	
	//++++++++++++++++++++++++++++++++++++
	//GENRAL ITEM STEP 1 AN ITEM
	//++++++++++++++++++++++++++
	//STEP 1
	//++++++++++++++++++++++++++++++++++++
	public function step1($bus_id = 0)
	{
		if($this->session->userdata('id')){
			$data['step'] = 1;
			$data['bus_id'] = $bus_id;
			$data['product_id'] = 0;
            $data['private'] = 'no';

			if(!$data['type'] = $this->input->get('type')){

				$data['type'] = 'general';
			}

			if(!$data['auction'] = $this->input->get('auction')){

				$data['auction'] = 'false';
			}
			if($this->input->is_ajax_request()){
				
				$this->load->view('trade/list/step1', $data);
				
			}else{

                if($bus_id != 0){

                    $this->db->where('ID', $bus_id);
                    $q = $this->db->get('u_business');

                    $row = $q->row_array();

                    $data['business_name'] = $row['BUSINESS_NAME'];
                    $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                    $data['cover'] = $row['BUSINESS_COVER_PHOTO'];
                }

				$this->load->view('trade/list/main', $data);
				
			}
		}else{
				$data['redirect'] = current_url('/');
				$data['error'] = 'Sorry, please login to continue';
				$this->load->view('login' , $data);
		}
	}
	//++++++++++++++++++++++++++++++++++++
	//STEP 2
	//++++++++++++++++++++++++++++++++++++
	public function step2($bus_id)
	{



		if($this->session->userdata('id') || $this->session->userdata('admin_id')){
			
			$cat1 = $this->input->post('cat1');
			$cat1name = $this->input->post('cat1name');
			$cat2 = $this->input->post('cat2');
			$cat2name = $this->input->post('cat2name');
			$cat3 = $this->input->post('cat3');
			$cat3name = $this->input->post('cat3name');
			$cat4 = $this->input->post('cat4');
			$cat4name = $this->input->post('cat4name');

			$data['type'] = '';
			if(!$type = $this->input->post('type')){

				if(!$type = $this->input->get('type')){

					$data['type'] = $type;
				}else{

					$data['type'] = $type;

				}

			}else{
				$data['type'] = $type;

			}
			$data['auction'] = 'false';
			if(!$data['auction'] = $this->input->post('auction')) {
				if (!$data['auction'] = $this->input->get('auction')) {

					$data['auction'] = 'false';
				}
			}
			if($cat1 == 0){
				$catname = 'Please select category';
				$cat1name = '';
			}elseif($cat2 == 0){
				$catname = $cat1name;
				$cat2name = '';
			}elseif($cat3 == 0){
				$catname = $cat2name;
				$cat3name = '';
			}elseif($cat4 == 0){
				$catname = $cat3name;	
				$cat4name = '';
			}elseif($cat4 > 0){
				$catname = $cat4name;	
				
			}
			$data['step'] = 2;
			$data['cat1'] = $cat1;
			$data['cat1name'] = $cat1name;
			$data['cat2'] = $cat2;
			$data['cat2name'] = $cat2name;
			$data['cat3'] = $cat3;
			$data['cat3name'] = $cat3name;
			$data['cat4'] = $cat4;
			$data['cat4name'] = $cat4name;
			
			$data['catname'] = $catname;
			$data['bus_id'] = $bus_id;
            $data['private'] = 'yes';
            
            if($bus_id != 0){
                $data['private'] = 'no';
                $this->db->where('ID', $bus_id);
                $q = $this->db->get('u_business');

                $row = $q->row_array();

                $data['business_name'] = $row['BUSINESS_NAME'];
                $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                $data['cover'] = $row['BUSINESS_COVER_PHOTO'];
            }

			$this->load->view('trade/list/step2', $data);
		}else{
			
			$data['redirect'] = current_url('/');
			$data['error'] = 'Sorry, please login to continue';
			$this->load->view('login' , $data);
		}
			
	}
	//++++++++++++++++++++++++++++++++++++
	//STEP 3 Add item Photos
	//++++++++++++++++++++++++++++++++++++
	public function step3($product_id, $bus_id)
	{
		if($this->session->userdata('id') || $this->session->userdata('admin_id')){

			$data['product_id'] = $product_id;
			$data['step'] = 3;
			$data['bus_id'] = $bus_id;

			if($bus_id != 0){

				if($this->session->userdata('admin_id')){

                    $this->db->where('ID', $bus_id);
                    $q = $this->db->get('u_business');

                    $row = $q->row_array();

                    $data['business_name'] = $row['BUSINESS_NAME'];
                    $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                    $data['cover'] = $row['BUSINESS_COVER_PHOTO'];

				}else
				{
					if (!$data1 = $this->members_model->check_business_user($bus_id))
					{
						$data['error'] = 'Sorry, please login to continue';
						$this->load->view('login', $data);

						return;
					}else{

                        $data['business_name'] = $data1['BUSINESS_NAME'];
                        $data['logo'] = $data1['BUSINESS_LOGO_IMAGE_NAME'];
                        $data['cover'] = $data1['BUSINESS_COVER_PHOTO'];

                    }
				}
                $data['private'] = 'no';
			}else{
                $data['private'] = 'yes';
				if($this->session->userdata('admin_id')){


				}else
				{

					$this->db->select('main_cat_id, sub_cat_id, sub_sub_cat_id, sub_sub_sub_cat_id, client_id');
					$this->db->where('product_id', $product_id);
					$cat = $this->db->get('products');
					$row = $cat->row();
					//OWNER ONLY
					if ($this->session->userdata('id') != $row->client_id)
					{
						$data['redirect'] = current_url('/');
						$data['error'] = 'Sorry, not your item';
						$this->load->view('login' , $data);
						return;

					}
				}

			}

			$data['auction'] = 'false';
			$data['type'] = '';
			if($this->input->is_ajax_request()){
				
				$this->load->view('trade/list/step3', $data);
				
			}else{
				
				$this->load->view('trade/list/main', $data);
				
			}
			
		}else{
			
			  $data['redirect'] = current_url('/');
			  $data['error'] = 'Sorry, please login to continue';
			  $this->load->view('login' , $data);
			  return;	
		}	
	}	
	
	//++++++++++++++++++++++++++++++++++++
	//STEP 4 Extras
	//++++++++++++++++++++++++++++++++++++
	public function step4($product_id, $bus_id)
	{
		if($this->session->userdata('id') || $this->session->userdata('admin_id')){

			$data['product_id'] = $product_id;
			$data['step'] = 4;
			$data['group'] = '<div class="alert">No extras available for the item you have added please proceed to the next step</div>';
			$data['has_extras'] = FALSE;
			$data['sub_cat_id'] = 0;
			$data['bus_id'] = $bus_id;
			//GET CATEGORIES
			$this->db->select('main_cat_id, sub_cat_id, sub_sub_cat_id, sub_sub_sub_cat_id, client_id, listing_type');
			$this->db->where('product_id', $product_id);
			$cat = $this->db->get('products');
			$data['has_extras'] = FALSE;
			if($cat->result()){

				$row = $cat->row();
				if($row->main_cat_id == '3408' || $row->sub_cat_id == '350' || $row->sub_cat_id == '352' || $row->sub_cat_id == '358'){
					$data['group'] = 'trade/inc/extras_identify';
					$data['main_cat_id'] = $row->main_cat_id;
					$data['sub_cat_id'] = $row->sub_cat_id;
					$data['sub_sub_cat_id'] = $row->sub_sub_cat_id;
					$data['sub_sub_sub_cat_id'] = $row->sub_sub_sub_cat_id;
					$data['has_extras'] = TRUE;
				}
			}

			if($bus_id != 0){

				if($this->session->userdata('admin_id')){

                    $this->db->where('ID', $bus_id);
                    $q = $this->db->get('u_business');

                    $row = $q->row_array();

                    $data['business_name'] = $row['BUSINESS_NAME'];
                    $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                    $data['cover'] = $row['BUSINESS_COVER_PHOTO'];
				}else
				{
					if (!$data1 = $this->members_model->check_business_user($bus_id))
					{
						$data['redirect'] = current_url('/');
						$data['error'] = 'Sorry, please login to continue';
						$this->load->view('login', $data);

						return;
                    }else{

                        $data['business_name'] = $data1['BUSINESS_NAME'];
                        $data['logo'] = $data1['BUSINESS_LOGO_IMAGE_NAME'];
                        $data['cover'] = $data1['BUSINESS_COVER_PHOTO'];

                    }
				}
                $data['private'] = 'no';

			}else{

				if($this->session->userdata('admin_id')){


				}else
				{
					//OWNER ONLY
					if ($this->session->userdata('id') != $row->client_id)
					{
						$data['redirect'] = current_url('/');
						$data['error'] = 'Sorry, not your item';
						$this->load->view('login' , $data);
						return;

					}
				}
                $data['private'] = 'yes';
			}


			if($row->listing_type == 'A'){

				$data['auction'] = 'true';
				$data['type'] = 'general';

			}elseif($row->listing_type == 'C'){
				$data['auction'] = 'false';
				$data['type'] = 'service';

			}else{

				$data['auction'] = 'false';
				$data['type'] = 'general';

			}

			
			if($this->input->is_ajax_request()){
				
				$this->load->view('trade/list/step4', $data);
				
			}else{
				
				$this->load->view('trade/list/main', $data);
				
			}
		}else{
			
			  $data['redirect'] = current_url('/');
			  $data['error'] = 'Sorry, please login to continue';
			  $this->load->view('login' , $data);
			  return;	
		}
			
	}
	//++++++++++++++++++++++++++++++++++++
	//STEP 5 Publish
	//++++++++++++++++++++++++++++++++++++
	public function step5($product_id, $bus_id)
	{
		if($this->session->userdata('id') || $this->session->userdata('admin_id')){

			$this->db->where('product_id', $product_id);
			$row = $this->db->get('products');
			$data = $row->row_array();
			$data['bus_id'] = $bus_id;
			$data['fb_post_id'] = $data['fb_post_id'];
			$data['step'] = 5;

			if($bus_id != 0){

				if($this->session->userdata('admin_id')){

                    $this->db->where('ID', $bus_id);
                    $q = $this->db->get('u_business');

                    $row = $q->row_array();

                    $data['business_name'] = $row['BUSINESS_NAME'];
                    $data['logo'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
                    $data['cover'] = $row['BUSINESS_COVER_PHOTO'];
				}else
				{
					if (!$data1 = $this->members_model->check_business_user($bus_id))
					{
						$data['error'] = 'Sorry, please login to continue';
						$this->load->view('login', $data);

						return;
                    }else{

                        $data['business_name'] = $data1['BUSINESS_NAME'];
                        $data['logo'] = $data1['BUSINESS_LOGO_IMAGE_NAME'];
                        $data['cover'] = $data1['BUSINESS_COVER_PHOTO'];

                    }
				}
                $data['private'] = 'no';
			}else{

				if($this->session->userdata('admin_id')){


				}else
				{
					//OWNER ONLY
					if ($this->session->userdata('id') != $data['client_id'])
					{
						$data['redirect'] = current_url('/');
						$data['error'] = 'Sorry, not your item';
						$this->load->view('login' , $data);
						return;

					}
				}
                $data['private'] = 'yes';
			}

			if($data['listing_type'] == 'A'){

				$data['auction'] = 'true';
				$data['type'] = 'general';

			}elseif($data['listing_type'] == 'C'){
				$data['auction'] = 'false';
				$data['type'] = 'service';

			}else{

				$data['auction'] = 'false';
				$data['type'] = 'general';

			}
			if($this->input->is_ajax_request()){
				
				$this->load->view('trade/list/step5', $data);
				
			}else{
				
				$this->load->view('trade/list/main', $data);
				
			}
		}else{
			
			  $data['redirect'] = current_url('/');
			  $data['error'] = 'Sorry, please login to continue';
			  $this->load->view('login' , $data);
			  return;	
		}
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PUBLISH DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function publish_item($id, $bus_id){
		
		$this->trade_model->publish_item($id, $bus_id);
		
	}

	//++++++++++++++++++++++++++++++++++++
	//STEP 3 Add item details
	//++++++++++++++++++++++++++++++++++++
	public function add_general_item()
	{
		if($this->session->userdata('id') || $this->session->userdata('admin_id')){
			$data = $this->trade_model->add_general_item();
			if($data['bool']){
				if($this->input->is_ajax_request()){
					$this->load->view('trade/list/step3', $data);
				}else{
					$this->load->view('trade/list/main', $data);
					
				}
			}else{
				if($this->input->is_ajax_request()){
					$this->load->view('trade/list/step2', $data);
					$str =  '<div class="alert alert-danger">'.$data['error'].'</div>';
					echo "<script type='text/javascript'>
							$('#msg_step2').html('".$str."');
						  </script>";
				}else{
					$data['error'] =  '<div class="alert alert-danger">'.$data['error'].'</div>';
					$this->load->view('trade/list/main', $data);
				}
			}
		}	
	}


	//++++++++++++++++++++++++++++++++++++
	//UPDATE Product
	//++++++++++++++++++++++++++++++++++++
	public function update_product($product_id)
	{
		

		if($this->session->userdata('id') || $this->session->userdata('admin_id')){
			
			$this->db->where('product_id', $product_id);
			$query = $this->db->get('products');
			
			if($query->result()){
	
				$row = $query->row_array();

				if($row['bus_id'] != 0){

					if($this->session->userdata('admin_id')){

                        $this->db->where('ID', $row['bus_id']);
                        $q = $this->db->get('u_business');

                        $drow = $q->row_array();

                        $row['business_name'] = $drow['BUSINESS_NAME'];
                        $row['logo'] = $drow['BUSINESS_LOGO_IMAGE_NAME'];
                        $row['cover'] = $drow['BUSINESS_COVER_PHOTO'];

					}else{

						if(!$BB = $this->members_model->check_business_user($row['bus_id'])){
							$data['error'] = 'Sorry, please login to continue';
							$this->load->view('login' , $data);
							return;
                        }else{

                            $row['business_name'] = $BB['BUSINESS_NAME'];
                            $row['logo'] = $BB['BUSINESS_LOGO_IMAGE_NAME'];
                            $row['cover'] = $BB['BUSINESS_COVER_PHOTO'];

                        }

					}
                    $row['private'] = 'no';

					
				}else{

                    $row['private'] = 'yes';
                }

				if($row['listing_type'] == 'A'){

					$row['auction'] = 'true';
					$row['type'] = 'general';

				}elseif($row['listing_type'] == 'C'){
					$row['auction'] = 'false';
					$row['type'] = 'service';

				}else{

					$row['auction'] = 'false';
					$row['type'] = 'general';

				}

				$row['step'] = 2;
				$row['cat1'] = $row['main_cat_id'];
				$row['cat1name'] = '';
				$row['cat2'] = $row['sub_cat_id'];
				$row['cat2name'] = '';
				$row['cat3'] = $row['sub_sub_cat_id'];
				$row['cat3name'] = '';
				$row['cat4'] = $row['sub_sub_sub_cat_id'];
				$row['cat4name'] = '';
	
				$row['catname'] = $this->trade_model->get_cat_names($row);
				
				if($this->input->is_ajax_request()){
					
					$this->load->view('trade/list/step2', $row);
					
				}else{
					
					$this->load->view('trade/list/main', $row);
					
				}
				
				
					
			}else{
				
				
				
			}
		}else{
				$data['redirect'] = current_url('/');
				$data['error'] = 'Sorry, please login to continue';
				$this->load->view('login' , $data);
			
		}
	}


	function url_encode($string){
        return str_replace('+','-',urlencode(utf8_encode($string)));
    }

    
    function url_decode($string){
        return str_replace('-',' ',utf8_decode(urldecode($string)));
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */