<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trade extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 *
	 */
    public function __construct()
    {
         //echo "OldClass constructor\n";
		 parent::__construct();

		$this->load->model('trade_model'); 
		$this->load->model('business_model'); 
		$this->load->model('my_na_model');  
		$this->load->model('search_model');  
    }


	public function load_product_map($pid) {

		$data['ID'] = $pid;

		$this->load->view('trade/inc/product_map_inc.php', $data);

	}



	//+++++++++++++++++++++++++++
	//TRADE/INDEX
	//++++++++++++++++++++++++++
	public function index($main_cat = '', $sub_cat = '', $sub_sub_cat = '' , $sub_sub_sub_cat = '' , $price_from = '', $price_to = '', $main_cat_id = 0,$sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $location = '', $suburb = '',$sort ='',$key = '')
	{

		$data['query'] = '';
		$data['heading'] = 'Latest Listings';
		$data['title'] = 'Latest Listings';
		$data['top_title'] = '<h1 class=" text-center">Buy &amp; Sell <span class="na_script yellow">ANYTHING</span> IN <span class="na_script">NAMIBIA</span></h1>';
		$data['location'] = 'natonal';
		$data['suburb'] = 'all';
		$data['main_cat_id'] = $main_cat_id;
		$data['sub_cat_id'] = $sub_cat_id;
		$data['sub_sub_cat_id'] = $sub_sub_cat_id;
		$data['sub_sub_sub_cat_id'] = $sub_sub_sub_cat_id;
		if($this->session->userdata('id')){

			$this->load->view('trade/home', $data);

		}else{
			$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

			if ( ! $output = $this->cache->get('trade/index'))
			{
					$output = $this->load->view('trade/home', $data, TRUE);
					$this->cache->save('trade/index', $output, 3600);

			}
			//$this->output->set_output($output);
			echo $output;
		}
        //$this->output->enable_profiler(TRUE);
	}

	//+++++++++++++++++++++++++++
	//TRADE/ AUCTIONS LANDING
	//++++++++++++++++++++++++++
	public function auctions($main_cat = '', $sub_cat = '', $sub_sub_cat = '' , $sub_sub_sub_cat = '' , $price_from = '', $price_to = '', $main_cat_id = 0,$sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $location = '', $suburb = '',$sort ='',$key = '')
	{

		$data['query'] = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
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

                                        WHERE products.listing_type = 'A' AND products.is_active = 'Y' AND products.status != 'moderate'
                                        GROUP BY products.product_id
                                        ORDER BY end_date DESC, listing_date DESC LIMIT 30");
		$data['heading'] = 'Latest Listings on Auction';
		$data['title'] = 'Latest Listings on Auction';
		$data['top_title'] = '<h1 class=" text-center">Latest <span class="na_script yellow">Listings</span> on <span class="na_script">Auction</span></h1>';
		$data['location'] = 'natonal';
		$data['suburb'] = 'all';
		$data['main_cat_id'] = $main_cat_id;
		$data['sub_cat_id'] = $sub_cat_id;
		$data['sub_sub_cat_id'] = $sub_sub_cat_id;
		$data['sub_sub_sub_cat_id'] = $sub_sub_sub_cat_id;
		/*if($this->session->userdata('id')){

			$this->load->view('trade/home', $data);

		}else{*/
			$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

			//if ( ! $output = $this->cache->get('trade/index'))
			//{
				$output = $this->load->view('trade/home', $data, TRUE);
				//$this->cache->save('trade/index', $output, 3600);

			//}
			//$this->output->set_output($output);
			echo $output;
		//}
		//$this->output->enable_profiler(TRUE);
	}

	//+++++++++++++++++++++++++++
	//MAIN SEARCH
	//++++++++++++++++++++++++++
	public function search() {

		$this->load->model('trade_search_model');
		$url_string = $this->trade_search_model->search();

		redirect('/buy/'.$url_string, 301);

	}

	//+++++++++++++++++++++++++++
	//PST RESULT REDIRECT my.na/buy/
	//++++++++++++++++++++++++++	

	public function results($main_cat = '', $sub_cat = '', $sub_sub_cat = '' , $sub_sub_sub_cat = '', $location = '', $suburb = '' , $price_from = '', $price_to = '', $main_cat_id = 0,$sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0,$sort = '' ,$key = '' ,  $bus_id = 0 , $limit = 40 ,$offset = 0)
	{
        $this->load->model('trade_search_model');
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
		if(strlen(trim($location)) == 0){
			$location = 'national';
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
		$extras = '?';
		if($this->input->get()){
			$extras = $this->input->get();

			//exclude service and auction parameters
			unset($extras['service']);
			unset($extras['auction']);
		}

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		//if ( ! $q = $this->cache->get('product_results_'.$main_cat.'_'.$sub_cat.'_'.$sub_sub_cat.'_'.$sub_sub_sub_cat))
		//{

			$q = $this->trade_search_model->get_query($main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $location, $suburb, $price_from, $price_to ,$main_cat_id  ,$sub_cat_id , $sub_sub_cat_id , $sub_sub_sub_cat_id, $key, $extras, $sort,  $bus_id, $limit, $offset);

			//$this->cache->save('product_results_'.$main_cat.'_'.$sub_cat.'_'.$sub_sub_cat.'_'.$sub_sub_sub_cat, $q, 600);

		//}

		//echo $q['debug'];
		//PAGINATION
		$this->load->library('pagination');

		$config['base_url'] = site_url('/'). 'buy/'.$main_cat.'/'.$sub_cat.'/'.$sub_sub_cat.'/'.$sub_sub_sub_cat.'/'.$location.'/'.$suburb.'/'.$price_from.'/'.$price_to.'/'.$main_cat_id.'/'.$sub_cat_id.'/'.$sub_sub_cat_id.'/'.$sub_sub_sub_cat_id.'/'.$sort.'/'. $key. '/'.$bus_id.'/'.$limit.'/';
		$config['total_rows'] = $q['count'];
		$config['per_page'] = $limit;
		$config['num_links'] = 3;

		//echo $config['base_url'];
		//Styling
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-chevron-left text-dark"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right text-dark"></i>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="page-item bg-light text"><a href="#" class="page-link bg-light text-dark">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 18;
		$this->pagination->initialize($config);

		$data['pages'] = $this->pagination->create_links();

		$data['query'] = $q['query'];
		$data['count'] = $q['count'];
		$data['offset'] = $offset;
		$data['limit'] = 50;
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

		if($this->input->is_ajax_request()){
			$this->trade_model->get_products($data['query'], $data['main_cat_id'], $data['sub_cat_id'], $data['sub_sub_cat_id'], $data['sub_sub_sub_cat_id'], $data['count'], $data['offset'], $data['title'], $amt = '', $advert = TRUE, $data['pages']);
		}else{
			$this->load->view('trade/results', $data);
		}


	} 

	public function home()
	{

		$data['query'] = '';
		$data['heading'] = 'Latest Listings';
		$data['location'] = 'natonal';
		$data['suburb'] = 'all';
		$this->load->view('trade/home', $data);
	}
	
	//+++++++++++++++++++++++++++
	//SORTBY POSTBACK
	//++++++++++++++++++++++++++
	public function sortby($type, $val)
	{

		$url = $this->input->get('url');

		if(strpos($url, "?")){
			$extras = urldecode( substr($url, strpos($url, '?', 0), strlen($url)));
			$arr = (array)(json_decode($extras));
		}else{
			$extras = '';
			$arr = '';
		}
		if($extras == '?false'){
			$extras = '';
		}
		$arr = (array)(json_decode($extras));

		//echo ($extras) . '   <br />';
		$path =  parse_url($url, PHP_URL_PATH);
		$url = explode('/', trim($path, '/'));
		//var_dump($url);
		//$extras = '?';

		if(count($arr) > 0){
			$ex = 0;
			$extras = '';
			foreach($arr as $row => $value){
				$temp = '&';
				if($ex == 0){
					$temp = '?';
				}

				$extras .= $temp.$row.'='.$value;
				$ex ++;
			}

		}
		//echo 'Extras: ' .$extras;
		$offset = '0';
		if(isset($url[16])){

			$key = $url[16];
		}
		$limit = '15';
		if(isset($url[15])){

			$limit = $url[15];
		}
		$key = 'all';
		if(isset($url[14])){

			$key = $url[14];
		}
		$sort = 'sort';
		if(isset($url[13])){

			$sort = $url[13];
		}
		$sub_sub_sub_cat_id = '0';
		if(isset($url[12])){

			$sub_sub_sub_cat_id = $url[12];
		}
		$sub_sub_cat_id = '0';
		if(isset($url[11])){

			$sub_sub_cat_id = $url[11];
		}
		$sub_cat_id = '0';
		if(isset($url[10])){

			$sub_cat_id = $url[10];
		}
		$main_cat_id = '0';
		if(isset($url[9])){

			$main_cat_id = $url[9];
		}
		$price_to = 'n';
		if(isset($url[8])){

			$price_to = $url[8];
		}
		$price_from = 'n';
		if(isset($url[7])){

			$price_from = $url[7];
		}
		$suburb = 'all';
		if(isset($url[6])){

			$suburb = $url[6];
		}
		$location = 'national';
		if(isset($url[5])){

			$location = $url[5];
		}

		$main_cat = 'no-name';
		if(isset($url[1])){
			if(!isset($url[9])){

				$main_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($url[1]), 'main', '0');

			}
			$main_cat = $url[1];
		}


		$sub_cat = 'no-name';
		if(isset($url[2])){
			if(!isset($url[10])){

				$sub_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($url[2]), 'sub', $main_cat_id);

			}
			$sub_cat = $url[2];
		}

		$sub_sub_cat = 'no-name';
		if(isset($url[3])){
			if(!isset($url[11])){

				$sub_sub_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($url[3]), 'sub_sub', $sub_cat_id);

			}
			$sub_sub_cat = $url[3];
		}

		$sub_sub_sub_cat = 'no-name';
		if(isset($url[4])){
			if(!isset($url[12])){

				$sub_sub_sub_cat_id = $this->trade_model->get_category_id($this->trade_model->decode_url($url[4]), 'sub_sub_sub', $sub_sub_cat_id);

			}
			$sub_sub_sub_cat = $url[4];
		}


		//echo 'buy/'.$main_cat.'/'.$sub_cat.'/'.$sub_sub_cat.'/'.$sub_sub_sub_cat.'/'.$location.'/'.$suburb.'/'.$price_from.'/'.$price_to.'/'.$main_cat_id.'/'.$sub_cat_id.'/'.$sub_sub_cat_id.'/'.$sub_sub_sub_cat_id.'/'.$val.'/'.$key.'/'.$limit.'/'.$offset.'/'.$extras;			
		//$this->results($main_cat,$sub_cat,$sub_sub_cat,$sub_sub_sub_cat,$location,$suburb,$price_from,$price_to,$main_cat_id,$sub_cat_id,$sub_sub_cat_id,$sub_sub_sub_cat_id,$val,$key,$limit,$offset,$extras);
		redirect(site_url('/').'buy/'.$main_cat.'/'.$sub_cat.'/'.$sub_sub_cat.'/'.$sub_sub_sub_cat.'/'.$location.'/'.$suburb.'/'.$price_from.'/'.$price_to.'/'.$main_cat_id.'/'.$sub_cat_id.'/'.$sub_sub_cat_id.'/'.$sub_sub_sub_cat_id.'/'.$val.'/'.$key.'/'.$limit.'/'.$offset.'/'.$extras, 301);

	}
	//+++++++++++++++++++++++++++
	//SORTBY POSTBACK
	//++++++++++++++++++++++++++
	public function sortby1($type)
	{
		$url = $this->input->get('url');
		//var_dump($this->uri->segment_array($url));

		$path =  parse_url($url, PHP_URL_PATH);
		$url = explode('/', trim($path, '/'));

		print_r($url);
		if($val == 'priceD'){

			$final1 = str_replace("/priceA/", "/".$val."/", $url);
			$final = str_replace("/sort/", "/".$val."/", $final1);

		}else{

			$final1 = str_replace("/priceD/", "/".$val."/", $url);
			$final = str_replace("/sort/", "/".$val."/", $final1);

		}
       //print_r(parse_url($url));

	   //echo parse_url($url, PHP_URL_PATH);

		//redirect( $final, 301);
	}


	//+++++++++++++++++++++++++++
	//PROPERTY SEARCH
	//++++++++++++++++++++++++++
	public function property_search() {

		$this->load->model('trade_search_model');
		$url_string = $this->trade_search_model->property_search();

		redirect('/trade/buy/property/'.$url_string, 301);

	}

	//+++++++++++++++++++++++++++
	//PROPERTY SEARCH
	//++++++++++++++++++++++++++
	public function property($status = '', $type = '', $sub_type = '', $area = '', $price_f = '', $price_t = '', $s = '', $t = '', $st = '') {



	}
	//+++++++++++++++++++++++++++
	//VIEW ALL AGENT PROPERTIES
	//++++++++++++++++++++++++++
	public function agent( $bus_id, $agent_id, $agency, $name = '')
	{

		$this->load->model('image_model'); 

		$this->load->library('thumborp');

		if($agent_id == '0'){

			$this->load->model('business_model');


			//Temp redirect for NMH print edition
			if($bus_id == 12694){
				$name = $this->business_model->clean_url_str($this->business_model->get_business_name($bus_id));
				//redirect('/trade/agent/'.$bus_id.'/0/'.$name.'/','location',301);
				redirect(site_url('/').'trade/agent/9318/0/'.$name, 'location', 301);
			}


            $data['query'] =  $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                        group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
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
										WHERE products.is_active = 'Y' AND products.bus_id = '".$bus_id."'
										GROUP BY products.product_id
										ORDER BY products.listing_date DESC LIMIT 30");

            $data['heading'] = $this->trade_model->decode_url($agency) . ' - Products';
			$data['title'] =  $this->trade_model->decode_url($agency) . ' - Products';
			$data['location'] = 'natonal';
			$data['suburb'] = 'all';
			$data['business'] = TRUE;
			$data['bus_id'] = $bus_id;
			$data['agent_id'] = $agent_id;
			$data['main_cat_id'] = 3408;
			$data['main_cat'] = 'Property';
			$data['bus_details'] = $this->business_model->get_business_details($bus_id);
			$data['cats'] = $this->business_model->get_current_categories($bus_id);
			//get RATING
			$data['rating'] = $this->business_model->get_rating($bus_id);


			$this->load->view('trade/business_products', $data);

		}else{

			$this->load->model('business_model');

            $data['query'] =  $this->db->query("SELECT   products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                        group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
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
										WHERE products.is_active = 'Y' AND products.bus_id = '".$bus_id."' AND product_extras.property_agent = '".$agent_id."'
										GROUP BY products.product_id
										ORDER BY products.listing_date DESC LIMIT 30");

            $data['heading'] = $this->trade_model->decode_url($name).'<small> '.$this->trade_model->decode_url($agency). '</small> - Products';
			$data['title'] =  $this->trade_model->decode_url($name).'<small> '.$this->trade_model->decode_url($agency). '</small> - Products';
			$data['location'] = 'natonal';
			$data['suburb'] = 'all';
			$data['business'] = FALSE;
			$data['bus_id'] = $bus_id;
			$data['agent_id'] = $agent_id;
			$data['main_cat_id'] = 3408;
			$data['main_cat'] = 'Property';
			$data['bus_details'] = $this->business_model->get_business_details($bus_id);
			$data['cats'] = $this->business_model->get_current_categories($bus_id);
			//get RATING
			$data['rating'] = $this->business_model->get_rating($bus_id);
			$this->db->close();
			$this->load->view('trade/business_products', $data);

		}

	}
	//+++++++++++++++++++++++++++
	//SINGLE PRODUCT
	//++++++++++++++++++++++++++
	public function product($id)
	{

		$this->load->model('image_model'); 

		$this->load->library('thumborp');

		$output = '';

		//redirect SEO friendly url
		if($this->uri->segment(2) == ''){

			redirect('/trade/','location',301);

		}elseif($this->uri->segment(1) == 'trade' && $this->uri->segment(3) != ''){

			redirect('/product/'.$this->uri->segment(3).'/','location',301);

		}else{


			if($this->uri->segment(3) != ''){

				$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

				if ( ! $output = $this->cache->get('single_product_'.$id))
				{

					$row = '';
						  /*$this->db->select('*');
						  $this->db->where('products.product_id', $id);
						  $this->db->join('product_extras','product_extras.product_id = products.product_id', 'left');
					      $this->db->join('product_images','product_images.product_id = products.product_id', 'left');
						  $query = $this->db->get('products');*/




						  $query = $this->db->query("SELECT products.*, product_extras.extras, u_business.*, a_map_location.MAP_LOCATION as city, a_map_region.REGION_NAME as region,
						  							(SELECT img_file FROM product_images WHERE product_id = ".$id." ORDER by sequence ASC LIMIT 1) as img_file,
                                                     MAX(product_auction_bids.bid_id) as max_bid, MAX(product_auction_bids.amount) as amount, product_extras.featured, product_extras.property_agent,


                                   					AVG(u_business_vote.RATING) as TOTAL,
			                                        (
			                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
			                                        ) as TOTAL_REVIEWS

                                                    FROM products
			    

                                                    LEFT JOIN u_business on products.bus_id = u_business.ID
                                                    LEFT JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
                                                    LEFT JOIN a_map_region ON a_map_location.MAP_REGION_ID = a_map_region.ID

													LEFT JOIN product_extras on products.product_id = product_extras.product_id
													LEFT JOIN product_images on products.product_id = product_images.product_id
													LEFT JOIN product_auction_bids ON products.product_id = product_auction_bids.product_id AND product_auction_bids.type = 'bid'
			                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
			                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'	

													WHERE products.product_id = ".$id."
													GROUP BY products.product_id
													ORDER BY product_auction_bids.datetime DESC
													LIMIT 1", FALSE);
                         
				

						  if($query->result()){

								$row = $query->row_array();
								$row['image'] = $row['img_file'];
                                $row['current_bid'] = $row['amount'];
                                $row['bid_id'] = $row['max_bid'];
								$row['main_cat'] = $this->trade_model->get_category_name($row['main_cat_id']);
								$row['sub_cat'] = $this->trade_model->get_category_name($row['sub_cat_id']);
								$row['sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_cat_id']);
								$row['sub_sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_sub_cat_id']);

						  }
					  

						   $output = $row;

						   $this->cache->save('single_product_'.$id, $output, 3600);
	
				}		  

				
				echo $this->load->view('trade/single', $output, TRUE);

			}else{

				$name = $this->trade_model->clean_url_str($this->trade_model->get_product_name($id));
				redirect(site_url('/').'product/'.$id.'/'.$name.'/','location',301);   

			}
            //$this->output->enable_profiler(TRUE);

		}
	}
    //+++++++++++++++++++++++++++
	//LOAD PRODUCT DETAILS
	//++++++++++++++++++++++++++
	public function show_product($id)
	{
		$this->load->library('user_agent');
		if($this->agent->is_robot()){
			
			redirect(site_url('/').'product/'.$id.'/', 301);
			
		}else{
			
			$this->trade_model->show_product($id);
		}
 		


	}

    //+++++++++++++++++++++++++++
    //SHARE PRODUCT INTO FB GROUP
    //++++++++++++++++++++++++++
    public function share_product_group($id)
    {
        $this->load->model('fb_model');
        $o = $this->fb_model->post_product_to_my_group($id);
        //sleep(5);
        // $o['msg'] = 'wohoo';
        echo json_encode($o);

    }
    //+++++++++++++++++++++++++++
    //SHARE PRODUCT INTO FB PAGE
    //++++++++++++++++++++++++++
    public function share_product_page($id)
    {

        $this->load->model('fb_model');
        $o = $this->fb_model->post_product_to_my_page($id);
        //sleep(5);
        ///$o['msg'] = 'wohoo';
        echo json_encode($o);

    }
    //+++++++++++++++++++++++++++
	//LOAD PRODUCT IMAGES
	//++++++++++++++++++++++++++
	public function show_images($product_id)
	{

		  /*
		  Get product Images
		  */
		  $this->load->library('user_agent');
		  if ($this->agent->is_mobile()) {
			$images = $this->trade_model->show_images($product_id, $size = 'big');
		  }else{

			 $images = $this->trade_model->show_images($product_id, $size = 'big');
		  }
		  echo $images['images'];

	}
	//+++++++++++++++++++++++++++
	//PRODUCT CATEGORIES
	//++++++++++++++++++++++++++
	public function cat($type, $id)
	{

		if($this->uri->segment(3) == ''){

			redirect('/trade/', 301);

		}elseif($this->uri->segment(4) != ''){

			  if($type == 1){

				  $data['query'] = "SELECT * FROM products WHERE main_cat_id = '".$id."'";

			  }elseif($type == 2){

				  $data['query'] = "SELECT * FROM products WHERE sub_cat_id = '".$id."'";

			  }elseif($type == 3){

				  $data['query'] = "SELECT * FROM products WHERE sub_sub_cat_id = '".$id."'";

			  }elseif($type == 4){

				  $data['query'] = "SELECT * FROM products WHERE sub_sub_sub_cat_id = '".$id."'";
			  }

			  $data['title'] = ucwords(str_replace('-',' ',$this->uri->segment(4)));
			  $data['heading'] = $data['title'];
			  $data['group'] = $id;
			  $this->load->view('trade/results', $data);


		}else{

			$name = $this->trade_model->clean_url_str($this->trade_model->get_category_name($id));
			redirect('/cat/'.$type.'/'.$id.'/'.$name.'/','location',301);

		}

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET CATEGORIES FOR FILTER
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_categories_select($type, $id, $current_id){

		header("Access-Control-Allow-Origin: *");
		$this->trade_model->get_categories_select($type, $id, $current_id);

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET CLIENT PRODUCTS FOR EDIT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function ajax_load_products($bus_id){

		$this->products($bus_id, 'live');

	}
	public function products($bus_id, $section){


		$this->trade_model->get_client_products($bus_id, $section);

	}
	//LOAD RESOURCES WITH AJAX
	public function ajax_load_watch_list(){

		$this->watch_list($bus_id = 0);

	}
	//WATCHLIST
	public function watch_list( $section)
	{
		$bus_id = 0;
		$this->trade_model->load_watchlist($bus_id = 0);

	}

	//BOUGHT LIST
	public function bought_list($section)
	{
		$bus_id = 0;
		$this->trade_model->get_client_products($bus_id, $section);

	}
		//LOAD RESOURCES WITH AJAX
	public function ajax_load_sell($bus_id){

		$this->sell( $bus_id, 'sell');

	}
	//LOAD RESOURCES WITH AJAX 
	//SELL AN ITEM
	public function sell($bus_id, $section)
	{

		$data['bus_id'] = $bus_id;
		$data['section'] = $section;
		$this->load->view('trade/inc/list_groups' , $data);

	}
	//++++++++++++++++++++++++++++++++++++
	//GENRAL ITEM STEP 1 AN ITEM
	//++++++++++++++++++++++++++
	//STEP 1
	//++++++++++++++++++++++++++++++++++++
	public function list_general_step1($bus_id)
	{
		$data['step'] = 1;
		$data['bus_id'] = $bus_id;
		$this->load->view('trade/inc/sell_general_item', $data);

	}
	//++++++++++++++++++++++++++++++++++++
	//STEP 2
	//++++++++++++++++++++++++++++++++++++
	public function list_general_step2($bus_id)
	{
		$cat1 = $this->input->post('cat1');
		$cat1name = $this->input->post('cat1name');
		$cat2 = $this->input->post('cat2');
		$cat2name = $this->input->post('cat2name');
		$cat3 = $this->input->post('cat3');
		$cat3name = $this->input->post('cat3name');
		$cat4 = $this->input->post('cat4');
		$cat4name = $this->input->post('cat4name');

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
		$this->load->view('trade/inc/sell_general_item', $data);

	}

	//++++++++++++++++++++++++++++++++++++
	//STEP 3 Add item details
	//++++++++++++++++++++++++++++++++++++
	public function add_general_item()
	{

		if($this->session->userdata('id')){
			$data = $this->trade_model->add_general_item();
			if($data['bool']){
				if($this->input->is_ajax_request()){


					$this->load->view('trade/inc/sell_general_item', $data);

				}else{

					$this->load->view('trade/list/step1', $data);

				}
			}else{
				if($this->input->is_ajax_request()){


					$this->load->view('trade/inc/sell_general_item', $data);
					$str =  '<div class="alert alert-error">'.$data['error'].'</div>';
					echo "<script type='text/javascript'>
							$('#msg_step2').html('".$str."');
								  $('.item_editor').redactor({ 	
				  
								  buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
								  'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
								   'alignment', '|', 'horizontalrule']
							  });
						  </script>";

				}else{
					$data['error'] =  '<div class="alert alert-error">'.$data['error'].'</div>';
					$this->load->view('trade/list/step1', $data);

				}


			}
		}

	}

	//++++++++++++++++++++++++++++++++++++
	//STEP 3 Add item Photos
	//++++++++++++++++++++++++++++++++++++
	public function list_general_step3($product_id, $bus_id)
	{
		$data['product_id'] = $product_id;
		$data['step'] = 3;
		$data['bus_id'] = $bus_id;
		$this->load->view('trade/inc/sell_general_item', $data);

	}

	//++++++++++++++++++++++++++++++++++++
	//STEP 4 Extras
	//++++++++++++++++++++++++++++++++++++
	public function list_general_step4($product_id, $bus_id)
	{

		$data['product_id'] = $product_id;
		$data['step'] = 4;
		$data['group'] = '<div class="alert">No extras available for the item you have added please proceed to the next step</div>';
		$data['has_extras'] = FALSE;
		$data['sub_cat_id'] = 0;
		$data['bus_id'] = $bus_id;
		//GET CATEGORIES
		$this->db->select('main_cat_id, sub_cat_id, sub_sub_cat_id, sub_sub_sub_cat_id');
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


		$this->load->view('trade/inc/sell_general_item', $data);

	}
	//++++++++++++++++++++++++++++++++++++
	//STEP 5 Publish
	//++++++++++++++++++++++++++++++++++++
	public function list_general_step5($product_id, $bus_id)
	{


		$this->db->where('product_id', $product_id);
		$row = $this->db->get('products');
		$data = $row->row_array();
		$data['bus_id'] = $bus_id;
		$data['step'] = 5;
		$this->load->view('trade/inc/sell_general_item', $data);

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PUBLISH DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function publish_item($id, $bus_id){

		$this->trade_model->publish_item($id, $bus_id);

	}


	 //+++++++++++++++++++++++++++
	//UPLOAD PRODUCT IMAGES     
	//++++++++++++++++++++++++++

	function add_product_images()
	{

		$this->trade_model->add_product_images();

	}


	 //+++++++++++++++++++++++++++
	//MAKE PRIMARY IMAGE  
	//++++++++++++++++++++++++++

	function make_primary_image($product_id, $img_id)
	{

		$this->trade_model->make_primary_image($product_id, $img_id);

	}

	 //+++++++++++++++++++++++++++
	//UPLOAD PRODUCT IMAGES    TEST  
	//++++++++++++++++++++++++++

	function blueimp()
	{

		$this->load->view('trade/inc/uploader');

	}
	 //+++++++++++++++++++++++++++
	//UPLOAD PRODUCT IMAGES  BLUEIMP   
	//++++++++++++++++++++++++++

	function add_product_images_blueimp()
	{
		$this->load->model('upload_model');
		$options['upload_dir'] = BASE_URL.'assets/products/images/';
		//$options['script_url'] = 'POES';

		$this->upload_model->initialize($options);
		//$this->upload_model->add_product_images_blueimp();

	}
	//SHOW ALL PRODUCT IMAGES IMAGE MANAGER		
	function show_all_product_images($product_id)
	{

		$this->trade_model->show_all_product_images($product_id);

	}
	//GET PRODUCT CATEGORIES
	function load_product_categories($bus_id = 0, $type = ''){

		$query = $this->trade_model->load_product_categories($bus_id, $type);


	}

	//DELETE PRODUCT CATEGORIES	
	function product_img_delete(){

		$img_id = $this->input->post('img_id', TRUE);

		$query = $this->trade_model->product_img_delete($img_id);

 
	}

	//++++++++++++++++++++++++++++++++++++
	//UPDATE Product
	//++++++++++++++++++++++++++++++++++++
	public function update_product($product_id)
	{
		if($this->session->userdata('id')){

			$this->db->where('product_id', $product_id);
			$query = $this->db->get('products');

			if($query->result()){

				$row = $query->row_array();

				if($row['bus_id'] != 0){
					$this->load->model('members_model');
					if(!$this->members_model->check_business_user($row['bus_id'])) {
						$data['error'] = 'Sorry, please login to continue';
						$this->load->view('login' , $data);
						return;
					}
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

				$this->load->view('trade/inc/sell_general_item', $row);

			}else{

			}

		}else{

			$data['redirect'] = current_url('/');
			$data['error'] = 'Sorry, please login to continue';
			$this->load->view('login' , $data);

		}
	}

	//+++++++++++++++++++++++
	//DELETE PRODUCT AND IMAGES
	//+++++++++++++++++++++++
	function delete_product()
	{

		$id = $this->input->post('id', TRUE);

		if($this->session->userdata('id') || $this->session->userdata('admin_id')){

			$this->db->where('product_id' , $id);
			$product = $this->db->get('products');

			//IF exists
			if($product->result()){

				$rowP = $product->row();
				if($rowP->bus_id != 0){
					$this->load->model('members_model');
					if(!$this->members_model->check_business_user($rowP->bus_id)){
						$data['error'] = 'Sorry, please login to continue';
						$this->load->view('login' , $data);
						return;
					}
				}
				$count = 0;
				//get images
				$this->db->where('product_id' , $id);
				$query = $this->db->get('product_images');

				//if images
				if($query->result()){

					foreach($query->result() as $row){

						$file_large = BASE_URL.'assets/products/images/'.$row->img_file;
						if(file_exists($file_large)) {

							if(unlink($file_large)){



							}

					   }
					  //delete image
					  $this->db->where('img_id' , $row->img_id);
					  $this->db->delete('product_images');

					  $count ++;

					}
				}

				//EXTRAS
				$this->db->where('product_id' , $id);
				$extras = $this->db->get('product_extras');

				if($extras->result()){

					$this->db->where('product_id' , $id);
					$this->db->delete('product_extras');

				}

				//DELETE PRODUCT
				$this->db->where('product_id' , $id);

				if($this->db->delete('products')){

					if($this->input->is_ajax_request()){
						echo
							'<div class="alert alert-success">
							    <button type="button" class="close" data-dismiss="alert">×</button><p>Product deleted, along with '.$count.' images and extras.</p>
							 </div>';
					}else{

						$this->session->set_flashdata('msg','<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button><p>Product deleted, along with '.$count.' images and extras.</p>
							 </div>');


					}
				}


			}else{

				echo
						'<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button><p>Product doesnt exist!</p>
						 </div>';

			}
		}else{
				$data['redirect'] = current_url('/');
				$data['error'] = 'Sorry, please login to continue';
				$this->load->view('login' , $data);
		}

	}

	//++++++++++++++++++++++++++++++++++++
	//ADD EXTRAS
	//++++++++++++++++++++++++++++++++++++
	public function add_extras()
	{

		$array[] = '';
		$features['features'] = array();
		$autohaus['autohaus'] = array();

/*		//CAR SPECIFIC FEATURES
		if($this->input->post('kilometres')){
			if($this->input->post('kilometres') != ''){
				array_push($features['features'],   $this->input->post('kilometres'));
			}

		}*/
		foreach($_POST as $key => $value){

			//if not empty
			if(!empty($value)){

				//GENRAL FEATURES
				if($key == 'features'){


						foreach($_POST['features'] as $key2 => $value1) {

								array_push($features['features'],   $value1);

						}
				//AUTOHAUS SPECIFICS
				}elseif($key == 'autohaus'){

						foreach($_POST['autohaus'] as $key3 => $value2) {

								array_push($autohaus['autohaus'],   $value2);

						}

				//PROPERTY CONTACT
				}elseif($key == 'seller_contact'){

				//PROPERTY SPECIFICS
				}elseif($key == 'property_agent'){

					$data['property_agent'] = $this->input->post('property_agent', TRUE);
					$data['featured'] = $this->input->post('featured', TRUE);

				//PROPERTY SIZE SPECIFICS
				}elseif($key == 'erf_size' || $key == 'erf_size_' || $key == 'house_size' || $key == 'house_size_' || $key == 'property_size' || $key == 'property_size_'){

					$array['erf_size'] = $this->input->post('erf_size', TRUE). ' '. $this->input->post('erf_size_', TRUE);
					$array['house_size'] = $this->input->post('house_size', TRUE). ' '.$this->input->post('house_size_', TRUE);
					$array['property_size'] = $this->input->post('property_size', TRUE). ' '.$this->input->post('property_size_', TRUE);

				//FEATURED ITEM
				}elseif($key == 'featured'){
					$data['featured'] = $this->input->post('featured', TRUE);
				//ADJUSTED ITEM
				}elseif($key == 'adjustment'){
					$data['adjustment'] = $this->input->post('adjustment', TRUE);

				}else{

						$array[$key] = $value;
						//echo "POST field info #". $key ." = ". ${$key}."<br />";

				}

			}//END IF NOT EMPTY

		}//END FOREACH POST ITEM

		//only add autohaus if full
		if((count($autohaus) > 0) && (count($features) > 0)){

			$final = array_merge($array, $features, $autohaus);

		}elseif(count($autohaus) > 0){

			$final = array_merge($array, $autohaus);

		}elseif(count($features) > 0){

			$final = array_merge($array, $features);
		}else{

			$final = array_merge($array, $features);
		}

		if($this->input->post('property_agent')){

			$data['property_agent'] = $this->input->post('property_agent', TRUE);
		}else{

			$data['property_agent'] = 0;
		}
		if($this->input->post('seller_contact')){

			$data['seller_contact'] = $this->input->post('seller_contact', TRUE);
		}else{

			$data['seller_contact'] = '';
		}



		$data['product_id'] = $this->input->post('product_id', TRUE);
		$data['extras'] = json_encode($final);

		//CHECK EXISTING RECORD
		$this->db->where('product_id', $data['product_id']);
		$has = $this->db->get('product_extras');

		if($has->result()){

			//UPDATE
			$this->db->where('product_id', $data['product_id']);
			$this->db->update('product_extras', $data);

			//DELETE CACHE
			$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));
			if($this->cache->get('trade/single_'.$data['product_id'])){

				$this->cache->delete('trade/single_'.$data['product_id']);
			}

		}else{

			//INSERT NEW
			$this->db->insert('product_extras', $data);

		}

		if($this->input->is_ajax_request()){



		}else{

			redirect(site_url('/').'sell/step5/'.$data['product_id'].'/'.$this->input->post('bus_id', TRUE), 301);

		}
		//var_dump(json_decode($data['extras'], true));				

	}


	//++++++++++++++++++++++++++++++++++++
	//GET CATEGORY NAMES
	//++++++++++++++++++++++++++++++++++++
	public function get_cat_names($row)
	{

			if($row['main_cat_id'] == 0){
				$catname = '';
				$cat1name = '';

			}elseif($row['sub_cat_id'] == 0){

				$this->db->where('cat_id', $row['main_cat_id']);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				return $res['category_name'];

			}elseif($row['sub_sub_cat_id'] == 0){

				$this->db->where('cat_id', $row['sub_cat_id']);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				return $res['category_name'];

			}elseif($row['sub_sub_sub_cat_id'] == 0){

				$this->db->where('cat_id', $row['sub_sub_cat_id']);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				return $res['category_name'];

			}elseif($row['sub_sub_sub_cat_id'] > 0){

				$this->db->where('cat_id', $row['sub_sub_sub_cat_id']);
				$query = $this->db->get('product_categories');
				$res = $query->row_array();
				return $res['category_name'];
			}


	}


	 //+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS BVY NAME
	//++++++++++++++++++++++++++
	public function populate_suburb_name($reg_id,$suburb)
	{
		header("Access-Control-Allow-Origin: *");
		$this->trade_model->populate_suburb_name($reg_id, $suburb);
	}

	//+++++++++++++++++++++++++++
	//PLACE AUCTION BID
	//++++++++++++++++++++++++++
	public function place_bid_ajax()
	{

 		$this->trade_model->place_bid_ajax();


	}
	//+++++++++++++++++++++++++++
	//PLACE AUCTION BID
	//++++++++++++++++++++++++++
	public function place_bid()
	{

		$this->trade_model->place_bid();

	}
	//+++++++++++++++++++++++++++
	//BUY NOW BUTTON
	//++++++++++++++++++++++++++
	public function buy_now()
	{

		$this->trade_model->buy_now();

	}
	//+++++++++++++++++++++++++++
	//ORDER NOW BUTTON
	//++++++++++++++++++++++++++
	public function order_now()
	{

		$this->trade_model->order_now();

	}
	//+++++++++++++++++++++++++++
	//ASK Question
	//++++++++++++++++++++++++++
	public function contact()
	{
		$this->trade_model->ask_question();

	}
	//+++++++++++++++++++++++++++
	//Answer Question
	//++++++++++++++++++++++++++
	public function answer()
	{
		if ($this->session->userdata('id')){


			  $answer = $this->input->post('answer', TRUE);
			  $question_id = $this->input->post('question_id', TRUE);
			  $product_id = $this->input->post('product_id', TRUE);
			  $client_id = $this->input->post('client_id', TRUE);
			  $asking_client_id = $this->input->post('asking_client_id', TRUE);
			  $product_title = $this->input->post('product_title', TRUE);
			  $question = $this->input->post('question', TRUE);

				  //GET SENDER EMAIL
				  $this->db->where('ID' , $asking_client_id);
				  $this->db->from('u_client');
				  $sender_query = $this->db->get();
				  $row = $sender_query->row_array();

				  //BUILD BODY
				  $body = 'Hi '.$row['CLIENT_NAME'] .',<br /><br />
						  Your question regarding the product '.$product_title . ' listed on My Namibia&trade; trade has been answered.<br /><br />
						  <strong>Question:</strong> ' .$question.'<br /><br />
						  <strong>Answer:</strong> '.$answer.'<br /><br />
						  <a href="'.site_url('/').'product/'.$product_id.'/">View '.$product_title .'</a><br /><br />
						  Please have a look at the updated product listing page, and good luck purchasing.<br /><br />
						  Have a !tna day!<br />
						  My Namibia';

				  $data_view['body'] = $body;
				  $body_final = $this->load->view('email/body_news',$data_view,true);
				  $subject = 'Answer regarding '.$product_title;
				  $emailTO = array(array('email' => $row['CLIENT_EMAIL'] ));
				  $fromEMAIL = 'no-reply@my.na';
				  $fromNAME = 'My Namibia Trade';
				 $TAG = array('tags' => 'trade_question' );


				  //SEND EMAIL LINK
				  $this->load->model('email_model');
				  $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
				  //send_mail($HTML, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG)

				  //UPDATE QUESTIONS
				  $data1 = array(
						'answer' => $answer,
						'status'=> 'live'
					  );

				  $this->db->where('question_id', $question_id);
				  $this->db->update('product_questions',$data1);

				  $data['basicmsg'] = 'Thanks, You have succesfully answered the question.' ;
				  echo '<div class="well well-mini">
				  		  '.$answer.'
						  <div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  '.$data['basicmsg'].'</div>
						  </div>
						  <script type="text/javascript">
						  $(".redactor").redactor("set", "");
						  </script>
						  ';



		  }else{

			  echo '<div class="alert alert-error">Please log in or register to answer a question</div>';

		  }

	}
	//+++++++++++++++++++++++++++
	//SHOW QUESTIONS ADMIN
	//++++++++++++++++++++++++++
	public function product_questions($product_id)
	{

		$data['q'] = $this->db->query("SELECT * FROM product_questions JOIN products ON product_questions.product_id = products.product_id WHERE product_questions.product_id ='". $product_id. "'", FALSE);

		$this->load->view('trade/inc/questions_admin', $data);

	}

	//+++++++++++++++++++++++++++
	//SUBMIT REVIEW
	//++++++++++++++++++++++++++
	public function submit_review($product_id)
	{
		$rating = $this->input->post('star1', TRUE);
		$review = strip_tags($this->input->post('reviewtxt', TRUE));
		$IP = $this->input->ip_address();
		$client_id = $this->session->userdata('id');


		//VALIDATE INPUT
		if($review == ''){
			$val = FALSE;
			$error = 'Please provide us with a review';

		}elseif(str_word_count($review) <= 10){
			$val = FALSE;
			$error = 'Please provide us with a informative review. Must be more than 10 words and no spelling mistakes are accepted!';


		}elseif($rating == ''){
			$val = FALSE;
			$error = 'Please provide us with your star rating of 1-5.';

		}else{
			$val = TRUE;
		}


		//IF VALIDATED
		if($val == TRUE){

			$query = $this->db->query("SELECT * FROM `u_business_vote` WHERE PRODUCT_ID = '".$product_id."' AND (CLIENT_ID = '".$client_id."' OR IP = '".$IP."')");
			$row = $query->num_rows();


			//IF CLIENT NOT ALREADY REVIEWED BUSINESS
			if($row == 0){

					$data1 = array(
					  'PRODUCT_ID'=> $product_id ,
					  'CLIENT_ID'=> $client_id ,
					  'IP'=> $IP ,
					  'RATING'=> $rating,
					  'REVIEW'=> $review,
					  'REVIEW_TYPE' => 'product_review'
					);

				//INSERT INTO DB
				$this->db->insert('u_business_vote', $data1);

				 //BUILD BODY
				 $body = 'Hi ,<br /><br />
						  A product has been reviewed on My Namibia&trade; trade.<br /><br />
						  Review: ' .$review.'<br /><br />
						
						  Please have a look and moderate the review. Make sure it is publishable<br /><br />
						  Have a !tna day!<br />
						  My Namibia';

				  $data_view['body'] = $body;
				  $body_final = $this->load->view('email/body_news',$data_view,true);
				  $subject = 'Product has been reviewed';
				  //$emailTO = array(array('email' => 'roland@my.na'), array('email' => 'info@my.na'), array('email' => 'rolandihms@gmail.com'));
				  $emailTO = array(array('email' => 'roland@my.na'), array('email' => 'info@my.na'), array('email' => 'ernst@my.na'));
				  $fromEMAIL = 'no-reply@my.na';
				  $fromNAME = 'My Namibia Trade';
				  $TAG = array('tags' => 'product_review' );


				  //SEND EMAIL TO OFFICE
				  $this->load->model('email_model');
				  $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
				//EMAIL BUSINESS	
				//$this->email_model->send_review_notification_business($data1);
				//UPDATE CLIENT POINTS
				//$this->business_model->update_client_point($client_id, '3', $bus_id, 'review');
				//NA BUSINESS
				//$this->business_model->my_na_click($bus_id, $client_id, 'right');


				$data['basicmsg'] = 'Thanks! We have succesfully submitted your review. You will receive your points as soon as the review has been approved' ;
				echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$data['basicmsg'].'</div>
						<script type="text/javascript">
							 $(".redactor").redactor("set", "");
							
						</script>
						';


			//IF CLIENT ALREADY REVIEWED BUSINESS
			}else{



				$data['error'] = 'Sorry, it seems like you have already reviewed this product, or someone from your current IP address: '. $IP ;
				echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								'.$data['error'].'</div>';


			}

		//IF NOT VALIDATED
		}else{


			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';

		}


	}



	//+++++++++++++++++++++++++++
	//ADD TO WATHCLIST 
	//++++++++++++++++++++++++++	
	function add_watchlist($product_id){


		 $this->trade_model->add_watchlist($product_id);

    }

	//+++++++++++++++++++++++++++
	//GET SIMILAR PRODUCTS
	//++++++++++++++++++++++++++	
	function get_similar_products($cat1, $cat2, $product_id){


		 $this->trade_model->get_similar_products($cat1, $cat2, $product_id);

    }

	//+++++++++++++++++++++++++++
	//UPDATE PRODUCT STATUS
	//++++++++++++++++++++++++++
	function update_product_status(){

	    $id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);	

		if($this->session->userdata('id') || $this->session->userdata('admin_id')){

			$data['status'] = trim($type);
			$this->db->where('product_id', $id);
			$this->db->update('products', $data);

		}

	}

	//+++++++++++++++++++++++++++
	//ACTIVATE PRODUCT STATUS
	//++++++++++++++++++++++++++
	function activate_product_status(){

		$id = $this->input->post('id', TRUE);
		$str = $this->input->post('str', TRUE);

		if($this->session->userdata('id') || $this->session->userdata('admin_id')){

			//$data['end_date'] = date('Y-m-d', strtotime("+30 days"));
			$data['is_active'] = ucwords(trim($str));
			$this->db->where('product_id', $id);
			$this->db->update('products', $data);

		}

	}

    //+++++++++++++++++++++++++++
    //EXTEND PRODUCT STATUS BY 30 DAYS
    //++++++++++++++++++++++++++
    function extend_product_status(){

    	$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);

        if($this->session->userdata('id') || $this->session->userdata('admin_id')){

            $data['end_date'] = date('Y-m-d', strtotime("+30 days"));
            if($type == 'A'){

                $data['end_date'] = date('Y-m-d', strtotime("+7 days"));

            }

            $this->db->where('product_id', $id);
            $this->db->update('products', $data);

        }

    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //RATE SELLER BUYER
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++

    function review_participant($id){

        $this->trade_model->review_participant($id);

    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //RATE SELLER BUYER
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++

    function review_participant_do(){

        $this->trade_model->review_participant_do();

    }


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//RATING WIDGET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function rate_product($product_id){

		$this->trade_model->rate_product($product_id);

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//Show Reviews FRONT END
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_reviews($product_id){

		$this->trade_model->show_reviews($product_id);

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT QUESTIONS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_product_questions(){

		$this->load->view('trade/inc/questions');

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCT MAP
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_product_map($product_id, $extras){


		$this->trade_model->get_product_map($product_id, $extras);

	}

	public function clean_extras()
	{

	   $q = $this->db->get('products');
	   $x = 0;
	   foreach($q->result() as $row){

		   $this->db->where('product_id', $row->product_id);
		   $ex = $this->db->get('product_extras');

		   if($ex->result()){



		   }else{

				$data['product_id'] = $row->product_id;
				$this->db->insert('product_extras', $data);

		   }


		   $x ++;
	   }

		echo $x;
	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+BUILD CATEGORY SEARCH
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function build_typehead($bus_id, $type){


		$this->trade_model->build_typehead($bus_id, $type);

	}


	//PRINT PRODUCT
	function print_product($product_id){

		$this->load->model('print_model');
		$data['product_id'] = $product_id;
		$this->db->select('*');
		$this->db->where('products.product_id', $product_id);
		$this->db->join('product_extras','product_extras.product_id = products.product_id');
		$query = $this->db->get('products');

		if($query->result()){

			$row = $query->row_array();
			$row['query'] = $query;
			$row['main_cat'] = $this->trade_model->get_category_name($row['main_cat_id']);
			$row['sub_cat'] = $this->trade_model->get_category_name($row['sub_cat_id']);
			$row['sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_cat_id']);
			$row['Ptitle'] = '';
			$row['bus_id'] = $row['bus_id'];
			$row['agent_id'] = $row['property_agent'];
			$row['sub_sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_sub_cat_id']);
			$this->load->view('trade/print_product', $row);
		}else{

			echo 'None';
		}



    }

	//PRINT PRODUCT 2
	function print_product2($product_id){

		$this->load->model('print_model');
		$data['product_id'] = $product_id;
		$this->db->select('*');
		$this->db->where('products.product_id', $product_id);
		$this->db->join('product_extras','product_extras.product_id = products.product_id');
		$query = $this->db->get('products');

		if($query->result()){

			$row = $query->row_array();
			$row['query'] = $query;
			$row['main_cat'] = $this->trade_model->get_category_name($row['main_cat_id']);
			$row['sub_cat'] = $this->trade_model->get_category_name($row['sub_cat_id']);
			$row['sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_cat_id']);
			$row['Ptitle'] = '';
			$row['bus_id'] = $row['bus_id'];
			$row['agent_id'] = $row['property_agent'];
			$row['sub_sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_sub_cat_id']);
			$this->load->view('trade/print_product2', $row);
		}else{

			echo 'None';
		}



	}


	function gd_test(){

		var_dump(gd_info());

	}

	//PRINT PRODUCTS
	function print_pdf($product_id, $style = ''){

		//error_reporting(0);
		error_reporting(E_ALL);

		ini_set('memory_limit','512M');

		$this->load->model('print_model');

		$data['product_id'] = $product_id;
		
		$this->db->select('*');
		$this->db->where('products.product_id', $product_id);
		$this->db->join('product_extras','product_extras.product_id = products.product_id');
		$query = $this->db->get('products');

		if($query->result()){
			$row = $query->row_array();
			// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
			$pdfFilePath = BASE_URL."assets/products/pdf/".$product_id.'_'.$style.".pdf";
			$data['page_title'] = $row['title']; // pass data to the view

			/*if (file_exists($pdfFilePath) == FALSE)
			{*/
				//ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">

				$row['query'] = $query;
				$row['main_cat'] = $this->trade_model->get_category_name($row['main_cat_id']);
				$row['sub_cat'] = $this->trade_model->get_category_name($row['sub_cat_id']);
				$row['sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_cat_id']);
				$row['Ptitle'] = '';
				$row['bus_id'] = $row['bus_id'];
				$row['agent_id'] = $row['property_agent'];
				$row['sub_sub_sub_cat'] = $this->trade_model->get_category_name($row['sub_sub_sub_cat_id']);

				$html = $this->load->view('trade/print_pdf'.$style, $row, true);// render the view into HTML


				$this->load->library('pdf');
				$pdf = $this->pdf->load();
				$stylecss = file_get_contents( base_url('/').'css/bootstrap.min.css');
				$pdf->SetProtection(array('print'));
				$pdf->SetTitle("My namibia - ".$row['title']." PDF");
				$pdf->SetAuthor("My Namibia TM");
				//$pdf->SetWatermarkText("Paid");
				//$pdf->showWatermarkText = true;
				//$pdf->watermark_font = 'DejaVuSansCondensed';
				//$pdf->watermarkTextAlpha = 0.1;
				$pdf->SetDisplayMode('fullpage');
				
				//$pdf->debug = true;
				$pdf->WriteHTML($stylecss,1);
				$pdf->WriteHTML($html,2); // write the HTML into the PDF
				//$pdf->Output($pdfFilePath, 'F'); // save to file because we can
				$pdf->Output();
				exit;
			/*}*/

			//redirect(base_url('/')."assets/products/pdf/".$product_id.'_'.$style.".pdf");

		}



    }
	//PRINT PRODUCTS
	function print_products($bus_id, $section,  $agent_id = 0){

		if($this->session->userdata('id'))
		{
			$id = $this->session->userdata('id');

			if ($section == '')
			{
				$section = 'live';
			}

			//JOUBERT BALT PRIVATE
			$strSQL = '';
			if ($bus_id == 8848)
			{

				$strSQL = " AND products.client_id = '" . $id . "'";

			}
			if ($bus_id == 0)
			{
				$col4H = '<th style="width:12%">Q</th>';
				$bstr = '';
				$query = $this->db->query("SELECT * FROM products
											WHERE client_id = '" . $id . "' AND bus_id = '0'
											AND status = '" . $section . "' ORDER BY product_id DESC ", false);

			}
			elseif ($section == 'live_agent')
			{
				$col4H = '<th style="width:12%">Agent</th>';
				$bstr = 'Agency';
				$query = $this->db->query("SELECT * FROM products
											JOIN product_extras ON products.product_id = product_extras.product_id
											WHERE product_extras.property_agent = '" . $id . "' AND products.bus_id = '" . $bus_id . "'
											AND products.status = 'live' ORDER BY products.product_id DESC ", false);

			}
			elseif ($section == 'sold_agent')
			{
				$col4H = '<th style="width:12%">Agent</th>';
				$bstr = 'Agency';
				$query = $this->db->query("SELECT * FROM products
											JOIN product_extras ON products.product_id = product_extras.product_id
											WHERE product_extras.property_agent = '" . $id . "' AND products.bus_id = '" . $bus_id . "'
											AND products.status = 'sold' ORDER BY products.product_id DESC ", false);

			}
			else
			{
				$col4H = '<th style="width:12%">Agent</th>';
				$bstr = 'Business';
				$query = $this->db->query("SELECT * FROM products
											JOIN product_extras ON products.product_id = product_extras.product_id
											WHERE products.bus_id = '" . $bus_id . "' AND products.status = '" . $section . "' " . $strSQL . "
											ORDER BY products.product_id DESC", false);
			}


			if ($query->result())
			{
				$this->load->model('print_model');
				$row['query'] = $query;
				$row['main_cat'] = 'na-name';
				$row['sub_cat'] = 'na-name';
				$row['sub_sub_cat'] = 'na-name';
				$row['sub_sub_sub_cat'] = 'na-name';
				$row['Ptitle'] = '';
				$row['bus_id'] = $bus_id;
				$row['agent_id'] = $agent_id;
				$row['property_agent'] = $agent_id;
				$this->load->view('trade/print_products', $row);
			}
		}
    }

		//PRINT PRODUCTS
	function print_pdfs($bus_id, $section,  $agent_id = 0){

		if($this->session->userdata('id')){

			$id = $this->session->userdata('id');

			if($section == ''){
				$section = 'live';
			}

			//JOUBERT BALT PRIVATE
			$strSQL = '';
			if($bus_id == 8848){

				$strSQL= " AND products.client_id = '".$id."'";

			}
			if($bus_id == 0){
				$col4H = '<th style="width:12%">Q</th>';
				$bstr = '';
				$query = $this->db->query("SELECT * FROM products
										WHERE client_id = '".$id."' AND bus_id = '0'
										AND status = '".$section."' ORDER BY product_id DESC " ,FALSE);

			}elseif($section == 'live_agent'){
				$col4H = '<th style="width:12%">Agent</th>';
				$bstr = 'Agency';
				$query = $this->db->query("SELECT * FROM products
										JOIN product_extras ON products.product_id = product_extras.product_id
										WHERE product_extras.property_agent = '".$id."' AND products.bus_id = '".$bus_id."'
										AND products.status = 'live' ORDER BY products.product_id DESC " ,FALSE);

			}elseif($section == 'sold_agent'){
				$col4H = '<th style="width:12%">Agent</th>';
				$bstr = 'Agency';
				$query = $this->db->query("SELECT * FROM products
										JOIN product_extras ON products.product_id = product_extras.product_id
										WHERE product_extras.property_agent = '".$id."' AND products.bus_id = '".$bus_id."'
										AND products.status = 'sold' ORDER BY products.product_id DESC " ,FALSE);

			}else{
				$col4H = '<th style="width:12%">Agent</th>';
				$bstr = 'Business';
				$query = $this->db->query("SELECT * FROM products
										JOIN product_extras ON products.product_id = product_extras.product_id
										WHERE products.bus_id = '".$bus_id."' AND products.status = '".$section."' ".$strSQL."
										ORDER BY products.product_id DESC" ,FALSE);
			}


			if($query->result()){
				$this->load->model('print_model');
				// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
				$pdfFilePath = BASE_URL."assets/products/pdf/b_".$bus_id.'_c_'.$id.'_'.$section.".pdf";
				$data['page_title'] = 'Hello world'; // pass data to the view

				if (file_exists($pdfFilePath) == FALSE)
				{
					ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
					$row['query'] = $query;
					$row['main_cat'] = 'na-name';
					$row['sub_cat'] = 'na-name';
					$row['sub_sub_cat'] = 'na-name';
					$row['sub_sub_sub_cat'] = 'na-name';
					$row['Ptitle'] = '';
					$row['bus_id'] = $bus_id;
					$row['agent_id'] = $agent_id;
					$row['property_agent'] = $agent_id;
					$html = $this->load->view('trade/print_products', $row, true);// render the view into HTML

					$this->load->library('pdf');
					$pdf = $this->pdf->load();
					$pdf->SetFooter($_SERVER['HTTP_HOST'].'|{PAGENO}|'.date(DATE_RFC822)); // Add a footer for good measure <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">
					$pdf->WriteHTML($html); // write the HTML into the PDF
					$pdf->Output($pdfFilePath, 'F'); // save to file because we can
				}

				//redirect(base_url('/')."assets/products/pdf/b_".$bus_id.'_c_'.$client_id.'_'.$section.".pdf");
				$this->load->helper('download');
				$data = file_get_contents($pdfFilePath); // Read the file's contents
				$name = "b_".$bus_id.'_c_'.$id.'_'.$section.".pdf";
				force_download($name, $data);
			}

		}

    }



	//CLEAN CATEGORIES	
	function clean_categories(){

		$query = $this->db->get('product_categories');

		foreach($query->result() as $row){

			$new['category_name'] = trim(str_replace(","," ",$row->category_name), "'");

			$this->db->where('cat_id', $row->cat_id);
			$this->db->update('product_categories', $new);

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