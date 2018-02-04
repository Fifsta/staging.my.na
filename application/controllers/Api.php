<?php header("Access-Control-Allow-Origin: http://whkproperty.com");
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api extends CI_Controller {

	/**
	 * Index Page for this controller.
	 * API FOR TRADE SECTION AND EXTERNAL SITES
	 */
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('api_model');
		
	}
	//+++++++++++++++++++++++++++
	//TRADE/INDEX
	//++++++++++++++++++++++++++
	public function index($bus_id, $main_cat = '', $sub_cat = '', $sub_sub_cat = '' , $sub_sub_sub_cat = '' , $price_from = '', $price_to = '', $main_cat_id = 0,$sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $location = '', $suburb = '',$sort ='',$key = '')
	{
		
		//$this->output->set_header("Access-Control-Allow-Origin: http://whkproperty.com");
		header("Access-Control-Allow-Origin: http://whkproperty.com");
		$this->load->model('trade_model');
		$data['query'] = '';		
		$data['heading'] = 'Latest Listings';
		$data['title'] = 'Latest Listings';
		$data['location'] = 'natonal';
		$data['suburb'] = 'all';
		$data['count'] = 0;
		$data['offset'] = 0; 
		$data['main_cat_id'] = $main_cat_id;
		$data['sub_cat_id'] = $sub_cat_id;
		$data['sub_sub_cat_id'] = $sub_sub_cat_id;
		$data['sub_sub_sub_cat_id'] = $sub_sub_sub_cat_id; 
		$data['extras'] = '';
		$data['price_from'] = '';
		$data['price_to'] = '';
		$data['bus_id'] = $bus_id;
		$this->load->view('api/home', $data);	
			
	
		
	}
	//+++++++++++++++++++++++++++
	//TRADE/INDEX
	//++++++++++++++++++++++++++
	public function find($bus_id, $type)
	{
		
		//$this->output->set_header("Access-Control-Allow-Origin: http://whkproperty.com");
		header("Access-Control-Allow-Origin: http://whkproperty.com");
		$this->load->model('trade_model');
		//FOR SALE
		if($type == 'sale'){
			$data['query'] = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id 
								WHERE products.bus_id = '".$bus_id."' AND main_cat_id = '3408' AND sub_cat_id = '3409'");
			
		}elseif($type == 'rent'){
			
			$data['query'] = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id 
								WHERE products.bus_id = '".$bus_id."' AND main_cat_id = '3408' AND sub_cat_id = '3410'");
			
		}elseif($type == 'development'){
			
			$data['query'] = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id 
								WHERE products.bus_id = '".$bus_id."' AND main_cat_id = '3408' AND sub_sub_cat_id = '3414'");
			
		}else{
				
			$data['query'] = '';
		}
				
		$data['heading'] = 'Latest Listings';
		$data['title'] = 'Latest Listings';
		$data['location'] = 'natonal';
		$data['suburb'] = 'all';
		$data['count'] = 0;
		$data['offset'] = 0; 
		$data['main_cat_id'] = 0;
		$data['sub_cat_id'] = 0;
		$data['sub_sub_cat_id'] = 0;
		$data['sub_sub_sub_cat_id'] = 0; 
		$data['extras'] = '';
		$data['price_from'] = '';
		$data['price_to'] = '';
		$data['bus_id'] = $bus_id;
		$this->load->view('api/home', $data);	
			
	
		
	}
	
	
	//+++++++++++++++++++++++++++
	//TRADE/INDEX
	//++++++++++++++++++++++++++
	public function filter($bus_id, $main_cat = '', $sub_cat = '', $sub_sub_cat = '' , $sub_sub_sub_cat = '' , $price_from = '', $price_to = '', $main_cat_id = 0,$sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $location = '', $suburb = '',$sort ='',$key = '')
	{
		
		//$this->output->set_header("Access-Control-Allow-Origin: http://whkproperty.com");
		header("Access-Control-Allow-Origin: http://whkproperty.com");
		$this->load->model('trade_model');
		$data['query'] = '';		
		$data['heading'] = 'Latest Listings';
		$data['title'] = 'Latest Listings';
		$data['location'] = 'natonal';
		$data['suburb'] = 'all';
		$data['count'] = 0;
		$data['offset'] = 0; 
		$data['main_cat_id'] = $main_cat_id;
		$data['sub_cat_id'] = $sub_cat_id;
		$data['sub_sub_cat_id'] = $sub_sub_cat_id;
		$data['sub_sub_sub_cat_id'] = $sub_sub_sub_cat_id; 
		$data['extras'] = '';
		$data['price_from'] = '';
		$data['price_to'] = '';
		$data['bus_id'] = $bus_id;
		$this->load->view('api/filter', $data);	
			
	
		
	}
	//+++++++++++++++++++++++++++
	//MAIN SEARCH
	//++++++++++++++++++++++++++
	public function search() {
		
		header("Access-Control-Allow-Origin: http://whkproperty.com");
		
		$this->output->set_header("Access-Control-Allow-Origin: http://whkproperty.com");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		
		$this->output->set_content_type( 'application/x-www-form-urlencoded' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';
			
		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			
			$this->load->model('trade_search_model');
			$this->load->model('trade_model');
			$url_string = $this->trade_search_model->search(); 
			$temp = str_replace("?", "", str_replace("/",",",$url_string));
			$temp2 = substr($temp, 0, strlen(trim($temp)) - 1);
			$arr = explode(",",$temp2);
			
			//GET query string
			$qstr = str_replace("?features=", "", substr($url_string, strpos($url_string, "?"), strlen($url_string)));
			
			$featureA['features'] = 
			
			$extras['features'] = str_replace("&", "",$qstr);
			//$featureA['features'] =  $extras;
			//var_dump($extras);
			//echo '<br />Original:'.$url_string;
			//echo '<br />Q string:'.$qstr;
			//echo '<br />Array: '.$arr[0].' '. $arr[1].' '. $arr[2].' '. $arr[3].' '. $arr[4].' '. $arr[5].' '. $arr[6].' '. $arr[7].' '. $arr[8].' '. $arr[9].' '. $arr[10].' '. $arr[11].' '. $arr[12].' '. $arr[13].' '. $arr[14].' '. $arr[15].' '. $arr[16];
			//redirect('/api/results/'.$url_string);
			$this->results($arr[0], $arr[1], $arr[2], $arr[3], $arr[4], $arr[5], $arr[6], $arr[7], $arr[8], $arr[9], $arr[10], $arr[11], $arr[12], $arr[13], $arr[14], $arr[15], $arr[16], $extras);
		}
	
	}
																																																														
	public function results($main_cat = '', $sub_cat = '', $sub_sub_cat = '' , $sub_sub_sub_cat = '', $location = '', $suburb = '' , $price_from = '', $price_to = '', $main_cat_id = 0,$sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0,$sort = '' ,$key = '' , $limit = 15 ,$offset = 0, $bus_id = 0, $extras)
	{
        header("Access-Control-Allow-Origin: http://whkproperty.com");
		$this->load->model('trade_search_model');
		$this->load->model('trade_model');
		//See if top-level category
		if(strlen(trim($main_cat)) != 0 && trim($main_cat) != 'no-name'){
				
			$main_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($main_cat), 'main', $main_cat_id);
			
		}else{
			$main_cat_id = 0;$main_cat = 'no-name';
		}
		if(strlen(trim($sub_cat)) != 0 && trim($sub_cat) != 'no-name'){
			
			$sub_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($sub_cat), 'sub', $main_cat_id);
			
		}else{
			$sub_cat_id = 0;$sub_cat = 'no-name';
		}
		if(strlen(trim($sub_sub_cat)) != 0 && trim($sub_sub_cat) != 'no-name'){
			
			$sub_sub_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($sub_sub_cat), 'sub_sub', $sub_cat_id);
			
		}else{
			$sub_sub_cat_id = 0;$sub_sub_cat = 'no-name';
		}
		if(strlen(trim($sub_sub_sub_cat)) != 0 && trim($sub_sub_sub_cat) != 'no-name'){
			
			$sub_sub_sub_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($sub_sub_sub_cat), 'sub_sub_sub', $sub_sub_cat_id);
			
		}else{
			$sub_sub_sub_cat_id = 0; $sub_sub_sub_cat = 'no-name';
		}		
		if(strlen(trim($location)) == 0 || $location == 'National'){
			$location = '';
			
		}
		if(strlen(trim($suburb)) == 0){
			$suburb = 'all';
		}
		if(strlen(trim($price_to)) == 0){
			$price_to = 'n';
		}
		if(strlen(trim($price_from)) == 0){
			$price_from = 'n';
		}
		if(strlen(trim($sort)) == 0){
			$sort = 'sort';
		}
		if(strlen(trim($key)) == 0){
			$key = 'all';
		}			
		//EXTRAS
		if(count($extras) != 0){
			$extras = $extras;
			
		}else{
			$extras = '?';
			
		}
		
		$q = $this->trade_search_model->get_query($main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $location, $suburb, $price_from, $price_to ,$main_cat_id  ,$sub_cat_id , $sub_sub_cat_id , $sub_sub_sub_cat_id, $key, $extras, $sort, $limit, $offset, $bus_id);
		
		
		//echo $q['debug'];
		
		//PAGINATION
		$this->load->library('pagination');
		
		$config['base_url'] = site_url('/'). 'api/results/'.$main_cat.'/'.$sub_cat.'/'.$sub_sub_cat.'/'.$sub_sub_sub_cat.'/'.$location.'/'.$suburb.'/'.$price_from.'/'.$price_to.'/'.$main_cat_id.'/'.$sub_cat_id.'/'.$sub_sub_cat_id.'/'.$sub_sub_sub_cat_id.'/'.$key.'/'. $sort. '/'.$limit.'/';
		$config['total_rows'] = $q['count'];
		$config['per_page'] = $limit; 
		$config['num_links'] = 3; 
		
		//echo $config['base_url'];
		//Styling
		$config['full_tag_open'] = '<div class="pagination pull-right"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-chevron-left icon-white"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-chevron-right icon-white"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 18;
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
										
		$data['query'] = $q['query'];
		$data['count'] = $q['count'];
		$data['offset'] = $offset;		
		$data['limit'] = $limit;
		$data['sort'] = $sort;		
		$data['title'] = $q['title'];
		$data['heading'] = $q['heading'];
		$data['group'] = $q['group'];
		$data['main_cat_id'] = $main_cat_id;
		$data['sub_cat_id'] = $sub_cat_id;
		$data['sub_sub_cat_id'] = $sub_sub_cat_id;
		$data['sub_sub_sub_cat_id'] = $sub_sub_sub_cat_id;
		$data['main_cat'] = $this->trade_model->decode_url($main_cat);
		$data['sub_cat'] = $this->trade_model->decode_url($sub_cat);
		$data['sub_sub_cat'] = $this->trade_model->decode_url($sub_sub_cat);
		$data['sub_sub_sub_cat'] = $this->trade_model->decode_url($sub_sub_sub_cat);
		$data['location'] = $location;
		$data['suburb'] = $suburb;
		$data['extras'] = $extras;
		$data['key'] = $key;
		$data['price_to'] = $price_to; 
		$data['price_from'] = $price_from; 
		$data['bus_id'] = $bus_id;   
		//var_dump($data);
		
		$this->load->view('api/results', $data);	
	}
	
	
	
	public function get_featured_slider($bus_id)
	{
		$this->load->model('trade_model');
		$data['bus_id'] = $bus_id;
		$output = $this->load->view('api/inc/header_api',$data, TRUE);
		
		//WHK PROPERTY BROKERS
		if($bus_id == 8966 || $bus_id == 980){
			
			//CUSTOM STYLEs
			$output .= '<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
						<script src="'.base_url('/').'js/bootstrap.min.js"></script>
						<style type="text/css">
						body,wrap,html{background:#FFF}
						 .carousel-caption{ background:rgba(255, 255, 255, 0.75)}
						 .btn-inverse{ background:#00155F}
						  h1,h2,h3,h4,h5, .carousel-caption > h4{color:#00155F}
						  td{font-size:12px}
						</style>
				
					</head>
				<body>';
			$output .= $this->api_model->get_featured_slider($bus_id, $url = 'http://whkproperty.com/');
			$output .= '<script> 	$(document).ready(function(){
										
										$("#featureCarousel").carousel();
									});
									
						</script>			
						<script src="'.base_url('/').'js/jquery.rating.pack.js" type="text/javascript"></script>
					</body>
				</html>';	
			
		}
		echo $output;
	}


	//+++++++++++++++++++++++++++
	//SINGLE PRODUCT
	//++++++++++++++++++++++++++
	public function product($id)
	{
		  header("Access-Control-Allow-Origin: http://whkproperty.com");
		  $this->load->model('trade_model');
		  $this->db->select('*');		
		  $this->db->where('products.product_id', $id);
		  $this->db->join('product_extras','product_extras.product_id = products.product_id');
		  $query = $this->db->get('products');  
		  
		  if($query->result()){
			  
			  $row = $query->row_array(); 
			  $row['main_cat'] = $this->trade_model->get_category_name($row['main_cat_id']);
			  $row['sub_cat'] = $this->trade_model->get_category_name($row['sub_cat_id']);
			  $row['sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_cat_id']);
			  $row['sub_sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_sub_cat_id']);
			  $this->load->view('api/single', $row); 
			  
		  }else{
		  



		}
	}

	public function home()
	{
		$this->load->view('template');
	}



	function vcard_user($id = '')
	{
		//error_reporting(E_ALL);
		$this->load->library('ciqrcode');

		//GET EVENT
		$this->db->where('ID', $id);
		$subscr = $this->db->get('u_client');
		if($subscr->result()){

			$subscr_row = $subscr->row();
			$link = base_url('/').'assets/users/qr/'.$id.'_vcard.jpg';

			$url = site_url('/').'vcard/'.$subscr_row->CLIENT_NAME.' ' .$subscr_row->CLIENT_SURNAME.'/'.$id.'/';
			//CHECK IF EXISTING FILE EXISTS
			if (file_exists( $link )) {

				$vcard2 = $link;

			} else {
				//BUILD DATA
				$web = '';$tel = '';
				if($subscr_row->CLIENT_TELEPHONE != ''){

					$tel = 'TEL;WORK;VOICE:' . trim($subscr_row->CLIENT_TELEPHONE) . "\n";

				}
				if($subscr_row->CLIENT_CELLPHONE != ''){

					$tel = 'TEL;WORK;VOICE:' . trim($subscr_row->CLIENT_CELLPHONE) . "\n";

				}
				// here our data

				$vcard1 = 'BEGIN:VCARD'."\n";
				$vcard1 .= 'N:' . ucwords(trim($subscr_row->CLIENT_NAME.' ' .$subscr_row->CLIENT_SURNAME)) . "\n";
				$vcard1 .= 'EMAIL:' . trim($subscr_row->CLIENT_EMAIL) . "\n";
				$vcard1 .= $tel;
				$vcard1 .= 'END:VCARD';

				$params['data'] = $vcard1;
				$params['level'] = 'H';
				$params['size'] = 5;
				$params['savename'] = BASE_URL .'assets/users/qr/'.$id.'_vcard.jpg';
				$this->ciqrcode->generate($params);

				$vcard2 = $link;

			}

			redirect($link, 301);

		}
		//echo $vcard1;
//		$file = $vcard2;
//
//		$type = 'image/jpeg';
//		header('Content-Type:'.$type);
//		header('Content-Length: ' . filesize($file));
//		readfile($file);
//		//echo $vcard2;

	}



	public function test_()
	{
		error_reporting(E_ALL);
		$this->load->library('curl');
		$this->load->library('rest', array(
			'server' => 'http://sms.my.na/api/sms/',
			'http_user' => 'myna_ma$ster',
			'http_pass' => '#$5_jh56_hdgd',
			'http_auth' => 'basic' // or 'digest'
		));

		$user = $this->rest->get('send', array('number' => '264818863437', 'msg' => 'Perfect, here is your code.'), 'json');

		echo json_encode($user);
		//var_dump($user);
	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */