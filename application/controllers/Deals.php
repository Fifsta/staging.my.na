<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Deals extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	
    public function __construct()
    {
  		parent::__construct();
  		$this->load->model('deal_model');
			
 	}	
	
	public function index()
	{

		$this->load->library('pagination');
		//Get Input
		$limit = 52;

		//echo 'BOTH';
		$data['query'] = $this->db->query("SELECT * FROM u_special_component
				LEFT JOIN a_map_location ON u_special_component.CATEGORY_SUB_ID = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW()  ORDER BY u_special_component.SPECIALS_EXPIRE_DATE ASC LIMIT ".$limit." OFFSET 0 ", TRUE);



		$test = $this->db->query("SELECT u_special_component.IS_ACTIVE FROM u_special_component
				LEFT JOIN a_map_location ON u_special_component.CATEGORY_SUB_ID = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW()", TRUE);

		$count =  $test->num_rows();

		$data['heading'] = 'Deals and Specials in Namibia' ;
		$base = 'deals/results/all/0/';

		//PAGINATION
		$config['base_url'] = site_url('/'). $base;
		$config['total_rows'] = $count;
		$config['per_page'] = $limit;
		$config['num_links'] = 2;
		//Styling
		$config['full_tag_open'] = '<div class="pagination pull-right"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);

		$data['pages'] = $this->pagination->create_links();
		$data['count'] = $count;



		$this->load->view('deals/home', $data);

	}
	//LOAD RESOURCES WITH AJAX AFTER PAGE LOAD
	public function ajax_load_deal()
	{
			
			//LOAD TYPEHEAD AFTER PAGE LOAD
			echo   "<script type='text/javascript'>".
						
						$this->deal_model->load_city_typehead().
						"
					
					$('#location').typeahead({source: subjects_location}) 
 					
					</script>";
			
	}
	//LOAD RESOURCES WITH AJAX AFTER PAGE LOAD
	public function instant_deal($key)
	{
			
		$this->deal_model->search_ajax_deal($key);
			
	}

	//+++++++++++++++++++++++++++
	//GET DEAL
	public function show($deal_id)
	{
		 
        //redirect SEO friendly url
		
		$this->db->where('u_special_component.ID', $deal_id);
		$this->db->join('a_map_location', 'a_map_location.ID = u_special_component.LOCATION', 'left');
		$query = $this->db->get('u_special_component');  
		  
		if($query->result()){
			  
			$row = $query->row_array();
			$row['ID'] = $deal_id;
			$this->load->view('deals/single', $row);
			  
		  }else{
			  
			$data['heading'] = 'Deals in Namibia';
			//$data['id'] = $this->session->userdata('id');
			$this->load->view('deals/results', $data);	
			  
		}	  	
	}
		
	//+++++++++++++++++++++++++++
	//GET DEAL
	public function load_single($deal_id)
	{
		 
		$this->deal_model->show_deal($deal_id);
		
		  	
	}
	//+++++++++++++++++++++++++++
	//ADD NEW DEAL
	public function add_deal()
	{
		$bus_id = $this->input->post('bus_id_deal',TRUE);
		$this->load->model('members_model');
		if($this->members_model->check_business_user($bus_id)){
			 	
				$this->load->model('deal_model');
				$this->deal_model->add_deal($bus_id);

		
		}elseif($this->session->userdata('admin_id')){
			
				$this->load->model('deal_model');
				$this->deal_model->add_deal($bus_id);
			  
		 }else{
			
				redirect('/my_admin/logout/');
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//UPDATE DEAL
	public function update_deal($deal_id)
	{
		$this->load->model('deal_model');
		$this->db->where('ID', $deal_id);
		$query = $this->db->get('u_special_component');
		if($query->result()){
			$row = $query->row_array();
			
			$data['bus_id'] = $row['BUSINESS_ID'];
			$data['title'] = $row['SPECIALS_HEADER'];
			$data['start'] = $row['SPECIALS_STARTING_DATE'];
			$data['end'] = $row['SPECIALS_EXPIRE_DATE'];
			$data['body'] = $row['SPECIALS_CONTENT'];
			$data['quantity'] = $row['QUANTITY'];
			$data['price'] = $row['SPECIALS_PRICE'];
			$data['special_type'] = $row['SPECIAL_TYPE'];
			$data['price_u'] = $row['NORMAL_PRICE'];
			$data['img_file'] = $row['SPECIALS_IMAGE_NAME'];
			$data['deal_id'] = $deal_id;
			$data['cat_deal'] = $row['CATEGORY_SUB_ID'];
			$data['is_active'] = $row['IS_ACTIVE'];
			$data['deal_loc'] = $row['LOCATION'];
			$data['bodyemail'] = $row['EMAIL_INSTRUCTIONS'];
			$data['cymot_cat'] = $row['CYMOT_CAT'];
			$this->load->view('members/inc/deals_inc', $data);
			echo '<script data-cfasync="false" type="text/javascript">
					$(document).ready(function(){
						
						initialise();
					});
					
					
				  </script>';	
			
		}else{
			
			echo '<div class="alert">
					<h3>Deal not found</h3> The deal could not be found</div>';
			
		}
	 	

		
	}
	
	//+++++++++++++++++++++++++++
	//DEAL STATS
	public function deal_stats($deal_id)
	{
		
		$this->deal_model->deal_stats($deal_id);
	 	
	
	}
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//ADD DEAL IMAGE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function add_deal_img()
	{
	
		$this->deal_model->add_deal_img();
	}	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//SHOW DEAL IMAGE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_deal_img($id)
	{
		
		echo $this->deal_model->show_deal_img($id);
		
	}	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DELETE DEAL IMAGE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function delete_deal(){
		
		$this->deal_model->delete_deal();
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN CYMOT DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function clean_cymot(){
		if($this->session->userdata('admin_id'))
		{
			$this->deal_model->clean_cymot();

		}else{

			echo 'Sorry, not authorized';

		}
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN CYMOT DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//downsize image
	function set_cymot_specials(){
		if($this->session->userdata('admin_id'))
		{

			$this->db->query("UPDATE u_special_component SET SPECIAL_TYPE = 'special' WHERE BUSINESS_ID = 514");


		}else{

			echo 'Sorry, not authorized';

		}
	}
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //EXTEND CYMOT DEALS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //downsize image
    function extend_cymot_deals(){
        if($this->session->userdata('admin_id'))
        {

            $this->db->query("UPDATE u_special_component SET SPECIALS_EXPIRE_DATE = CURDATE() + INTERVAL 1 WEEK WHERE BUSINESS_ID = 514");


        }else{

            echo 'Sorry, not authorized';

        }
    }
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN CYMOT DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//downsize image
	function set_cymot_images(){
		if($this->session->userdata('admin_id'))
		{

			$query = $this->db->query("SELECT * FROM u_special_component WHERE BUSINESS_ID = 514");
			foreach($query->result() as $row)
			{
				if($row->SPECIALS_IMAGE_NAME == ''){


				}else{

					$img = base_url('/').'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;

					$imgP = BASE_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					if(file_exists($imgP)){

						//IT EXISTS

					}else{

						$d['IS_ACTIVE'] = 'N';
						$this->db->where('ID', $row->ID);
						$this->db->update('u_special_component', $d);

					}



				}


			}

		}else{

			echo 'Sorry, not authorized';

		}
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD DEAL IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function test_deals()
	{
		$q =  $this->db->query("SELECT * FROM u_special_component WHERE BUSINESS_ID = 514");

		foreach($q->result() as $row){

			echo $row->CYMOT_CAT. '<br />';


		}

		echo '<br />+++++++++++++++++++++++TOTAL ROWS: '.$q->num_rows();

	}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//PUBLISH DEAL
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	


	function publish_deal($id){
		
		$this->deal_model->publish_deal($id);
		
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAKE DEAL LIVE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	


	function set_status($id){
		
		$this->db->where('ID', $id);
		$query = $this->db->get('u_special_component');
		
		if($query->result()){
			
			$row = $query->row_array();
			if($row['IS_ACTIVE'] == 'Y'){
				
				$data['IS_ACTIVE'] = 'N';
				$this->db->where('ID', $id);
				$this->db->update('u_special_component', $data);
				
			}else{
				
				$data['IS_ACTIVE'] = 'Y';
				$this->db->where('ID', $id);
				$this->db->update('u_special_component', $data);
				
			}
			
		}
		
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET DEAL DETAILS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function get_deal_json($id){
		
		$this->deal_model->get_deal_json($id);
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET DEAL DETAILS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function count_claims($id){
		
		$this->deal_model->count_claims($id);
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET DEAL DETAILS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function delete_claim($id){
		
		$this->db->where('claim_id', $id);
		$this->db->delete('u_special_claims');
		echo '<div class="alert">
					<h3>Claim Deleted</h3> The deal claim has been removed</div>';
		
	}
	//+++++++++++++++++++++++++++
	//CLAIM DEAL
	//++++++++++++++++++++++++++
	public function claim_deal($id)
	{
		
		
		$this->deal_model->claim_deal($id);
		
	}
	
	 
	//+++++++++++++++++++++++++++
	//UPDATE DEAL STATUS
	//++++++++++++++++++++++++++
	public function deal_status($id,$str)
	{
		
		
		$this->deal_model->set_deal_status($id,$str);
		
	}
	//+++++++++++++++++++++++++++
	//SHARE FACEBOOK LINK POINTS
	//++++++++++++++++++++++++++
	public function encfb($str)
	{
		
		if($this->session->userdata('id')){
			//if($str == str_replace('/','_-_', $this->deal_model->encrypt('fb_share'))){	 	
					$client_id = $this->session->userdata('id');
					$this->db->where('CLIENT_ID',$client_id);
		   
					
					$data = array(
							
							'BUSINESS_ID' => '0',
							'POINTS' => '5',
							'TYPE' => 'fb_share',
							'CLIENT_ID' => $client_id
						);
					
					$this->db->insert('u_client_points',$data);
					
					//UPDATE SUMMARY TABLE
					$this->update_client_point_summary($client_id, '5');
		    //}
		}
	}
	
		//+++++++++++++++++++++++++++
	//SHARE FACEBOOK LINK POINTS
	//++++++++++++++++++++++++++
	public function encrypt($str)
	{
		echo $this->deal_model->encrypt($str);
		echo '<br/>';
		
		echo $this->deal_model->decrypt($this->deal_model->encrypt($str));
		
	}
	//UPDATE USER POINTS SUMMARY
	function update_client_point_summary($client_id, $points) {
		
		$this->db->where('CLIENT_ID',$client_id);
		$query = $this->db->get('u_client_points_summary');
						   
		if($query->num_rows() == 0){		   
				
				if($points < 0){
					
					$points = 0;
				
				}
				$data = array(
						
						'POINTS' => $points,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_client_points_summary',$data);
				
				
		}else{

			
			$query = $this->db->query("UPDATE u_client_points_summary SET POINTS = GREATEST(POINTS + ".$points." ,0) WHERE CLIENT_ID = '".$client_id."'");
		}	
		$this->session->set_userdata('points',$points);
		
	}
		
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
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAIN SEARCH FUNCTION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function search($offset = '')
	{
		$key = $this->input->post('broad',TRUE);
		$location = $this->input->post('location',TRUE);
		$limit = 52;
		if($offset == ''){ 
			$offset = '0';
		}
		//BOTH PROVIDED
		if($location != '' && $key != ''){
			
			//echo 'BOTH';
			redirect('/deals/results/'.$this->url_encode($key).'/'.$this->url_encode($location).'/','refresh');
		//LOCATION	
		}elseif($location != ''){
			//echo 'LOC';
			//echo 'key';
			$key = '0';
			redirect('/deals/results/0/'.$this->url_encode($location).'/','refresh');

		//NO KEY
		}elseif($key == 'all'){

			//echo 'key';
			$location = '0';
			redirect('/deals/results/all/'.$this->url_encode($location).'/','refresh');

		//KEY
		}elseif($key != ''){
			
			//echo 'key';
			$location = '0';
			redirect('/deals/results/'.$this->url_encode($key).'/'.$this->url_encode($location).'/','refresh');
		
		//NOTHING	
		}else{
			
			//echo 'NONE';
			redirect('/deals/','refresh');
		}
		
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAIN SEARCH POST FUNCTION PAGINATION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function results($offset = '')
	{
		$this->load->library('pagination');
		//Get Input
		$limit = 52;
  		$offset = ($this->uri->segment(5));
		$key = $this->url_decode($this->uri->segment(3));
		$location = $this->url_decode($this->uri->segment(4));
		
		if($offset == ''){ 
			$offset = '0';
		}
		//BOTH PROVIDED
		if($location != '0' && $key != '0'){
			
			//echo 'BOTH';
			$data['query'] = $this->deal_model->get_loc_key($location,$key ,$limit, $offset);
			$count = $this->deal_model->Cget_loc_key($location, $key);
			$data['heading'] = 'Deals: '.$key .' in '.$location ;  
			$base = 'deals/results/'.$this->url_encode($key).'/'.$this->url_encode($location).'/';
		//LOCATION	
		}elseif($location != '0'){
			
			//echo 'LOC';
			$data['query'] = $this->deal_model->get_only_location($location ,$limit, $offset);
			$count = $this->deal_model->Cget_only_location($location);
			$data['heading'] = 'Deals in '.$location ;  
			$base = 'deals/results/0/'.$this->url_encode($location).'/';

		//NO KEY
		}elseif($key == 'all'){

			//echo 'BOTH';
			$data['query'] = $this->db->query("SELECT u_special_component.* FROM u_special_component
				LEFT JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW()  ORDER BY u_special_component.SPECIALS_EXPIRE_DATE ASC LIMIT ".$limit." OFFSET ".$offset."", TRUE);

			$test = $this->db->query("SELECT u_special_component.IS_ACTIVE FROM u_special_component
				LEFT JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW()", TRUE);

			$count =  $test->num_rows();
			$data['heading'] = 'All Deals and Specials in namibia | Page '.($offset / $limit);
			$base = 'deals/results/all/0/';

		//KEY
		}elseif($key != '0'){
			
			//echo 'key';
			$data['query'] = $this->deal_model->get_only_key($key ,$limit, $offset);
			$count = $this->deal_model->Cget_only_key($key);
			$data['heading'] = 'Deals like: '.$key ;  
			$base = 'deals/results/'.$this->url_encode($key).'/0/';
			
		//NOTHING	
		}else{
			
			echo 'NONE';
			
		}
		
		
		
		//PAGINATION
		$config['base_url'] = site_url('/'). $base;
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 2;

		//Styling
		$config['full_tag_open'] = '<div class="pagination pull-right"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
		$data['count'] = $count;
		$data['key'] = $key;
		$data['location'] = $location;
		//echo $this->db->last_query();

		$this->load->view('deals/results', $data);

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//APPROVE CYMOT DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function approve($offset = '')
	{
		$this->db->where('BUSINESS_ID', 514);
		$deals = $this->db->get('u_special_component');
		$x = 0;
		if($deals->result()){
			
			foreach($deals->result() as $row){
				
				echo $row->SPECIALS_HEADER. '  ' . date('Y-M-d', strtotime($row->SPECIALS_STARTING_DATE)). '   ' . $row->IS_ACTIVE.'<br /> ';	
				//UPDATE ACTIVE
				$data['IS_ACTIVE'] = 'Y';
				$this->db->where('ID', $row->ID);
				$this->db->update('u_special_component', $data);
				$x ++;
			}
			
		}
		echo 'TOTALS: '.$x;
			
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