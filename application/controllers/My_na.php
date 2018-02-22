<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_na extends CI_Controller {

	/**
	 * Index Controller for My.na.
	 *
	 * Roland Ihms
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('my_na_model');
	
	}
	

	
	public function index()
	{
	
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));
					
		if ( ! $output = $this->cache->get('home'))
		{
			$output = $this->load->view('home', '',true);
			//$this->cache->save('home', $output, 172800);
		}
		
		echo $output;

	}


	public function home2()
	{

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));
					
		if ( ! $output = $this->cache->get('home'))
		{
			$output = $this->load->view('home2', '',true);
			//$this->cache->save('home', $output, 172800);
		}
		
		echo $output;
			
	}


	public function nav()
	{
		
		if($this->session->userdata('id') === null){

			echo 'FALSE';
			
		}else{
			$data['url'] = $type = $this->input->post('url', TRUE);;

			if($str = $this->input->get('srch_bar')){

				$data['str'] = urldecode($str);
			}


			$this->load->view('inc/profile', $data);
				
		}

	}	


	public function demo()
	{
		//$this->load->driver('cache', array('adapter' => 'file'));
		$this->load->model('search_model');
		$this->load->view('home_new');			

	}	

	public function clean_cats()
	{
		
		$query = $this->db->get('i_tourism_category');
		foreach($query->result() as $row){
			
			$res = $this->db->where('ID', $row->CATEGORY_ID);	
			$res = $this->db->get('a_tourism_category_sub');
			
			echo 'Row: '.$row->ID.' ';	
			
			//IF SUB CAT EXISTS
			if($res->result()){
				
				echo ' Not Deleted <br />';
				
			}else{
				
				//NO ROWS, DELETE INTERSECTION
				//$this->db->where('ID', $row->ID);
				//$this->db->delete('i_tourism_category');	
				
				echo ' Yes Deleted <br />';
				
			}
			
			
		}
		
	}	
		
	public function email_news()
	{
		
		$data['body'] = 'Testing';
		$this->load->view('email/body_news', $data);
		
	}

    public function pricing()
    {
        /*$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('pricing_table'))
        {*/

            $this->config->load('cloudflare');
            $today = date('Y-m-d',strtotime("- 1 days")).'T12:23:00Z';
            $days7 = date('Y-m-d', strtotime("- 7 days")).'T12:23:00Z';
            $days24 = date('Y-m-d', strtotime("- 2 days")).'T12:23:00Z';
            $days30 = date('Y-m-d', strtotime("- 30 days")).'T12:23:00Z';

            $headers = array(

                'X-Auth-Key: '.$this->config->item('cloudflare_api_key'),
                'X-Auth-Email: '.$this->config->item('cloudflare_email'),
                'Content-Type: application/json'
            );
            
            $url7 = 'https://api.cloudflare.com/client/v4/zones/'.$this->config->item('zone_id').'/analytics/dashboard?since='.$days7.'&until='.$today.'';
            $url24 = 'https://api.cloudflare.com/client/v4/zones/'.$this->config->item('zone_id').'/analytics/dashboard?since='.$days24.'&until='.$today.'';
            $url30 = 'https://api.cloudflare.com/client/v4/zones/'.$this->config->item('zone_id').'/analytics/dashboard?since='.$days30.'&until='.$today.'';
            $data = array(

                'since' => '2015-01-01',
                'until' => '2015-01-02',

            );

            $this->load->model('cron_model');

            $response7 = $this->cron_model->cloudflare_stats($headers, $url7);
            $response24 = $this->cron_model->cloudflare_stats($headers, $url24);
            $response30 = $this->cron_model->cloudflare_stats($headers, $url30);
            //var_dump($out);
            // echo $response['query']['since'];
            $A7 = json_decode($response7);
            $data['unique7'] = $A7->result->totals->uniques->all;
            $data['pageviews7'] = $A7->result->totals->pageviews->all;
            $A24 = json_decode($response24);
            $data['unique24'] = $A24->result->totals->uniques->all;
            $data['pageviews24'] = $A24->result->totals->pageviews->all;
            $A30 = json_decode($response30);
            $data['unique30'] = $A30->result->totals->uniques->all;
            $data['pageviews30'] = $A30->result->totals->pageviews->all;
            //echo $url.' Unique : '.$data['unique7']. ' Pageviews: '.$data['pageviews7'];

            $output = $this->load->view('adverts/pricing_table', $data, TRUE);
            $this->cache->save('pricing_table', $output, 86400);
       // }

        echo $output;

    }

	public function test()
	{
		
		$this->load->view('test');
	}
	public function home()
	{
		$this->load->model('search_model');
		$this->load->view('home_clean');
	}
	//PAGES
	public function pages($slug)
	{
		
		$this->db->where('slug',$slug);
		$page = $this->db->get('pages');
		
		if($page->num_rows() > 0){
			$this->load->model('search_model');
			$page = $page->row_array();
		    $this->load->view('page', $page);
		
		}else{
			
			redirect(site_url('/'),'location',301);
			
		}
		
	}
	
	//LOAD RESOURCES WITH AJAX AFTER PAGE LOAD
	public function ajax_load_home()
	{
			$this->load->model('search_model');
			//LOAD TYPEHEAD AFTER PAGE LOAD
			echo   "<script type='text/javascript'>".
						
						$this->search_model->load_category_typehead().
						$this->search_model->load_city_typehead().
						$this->search_model->load_business_typehead()."
			
					$('#srch_category').typeahead({source: subjects}) 
					$('#srch_location').typeahead({source: subjects_location}) 
 					$('#srch_business').typeahead({source: subjects_business})
					</script>";
			
	}



	//LOAD RANDOM ADVERT
	public function load_advert($q = '')
	{
			echo $this->my_na_model->show_advert($q);
			
	}
	//LOAD RESOURCES WITH AJAX AFTER PAGE LOAD
	public function load_slide()
	{
			echo $this->my_na_model->scratch_win_img();
			
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET WEATHER
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_weather_report($time = ''){

        echo $this->my_na_model->get_weather_report($time);


    }
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET WEATHER
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function test_news($time = ''){
		error_reporting(E_ALL);
		$this->load->model('news_model');
		echo $this->news_model->get_home_news(0);


	}

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET LOCALIZED LINKS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_local_links(){

		if($url = $this->input->get('url')){

			$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

			if ( ! $output = $this->cache->get($url))
			{

				$t = file_get_contents($url);
				$output = str_replace('&', '&amp;', $t);

				$this->cache->save($url, $output, 3600);
			}
			echo $output;


		}


    }
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET NAMIBIAN NES URL LINK
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function local_news_copy(){



	}
	//LOAD DEALS HOME PAGE
	public function load_deals_home()
	{

            $this->load->model('deal_model');
            echo '<div class="row-fluid">
                    <div class="span6">
                        <h3 class="na_script upper">Latest Specials and Deals</h3>

                    </div>
                    <div class="span6 text-right">
                        <a href="'.site_url('/').'deals/" class="btn btn-inverse" title="More Properties" rel="tooltip"  style="margin-top:15px;"><i class="icon icon-plus icon-white"></i> More Deals &amp Specials</a>

                    </div>
                  </div>';
			echo $this->deal_model->show_deals_hm();

			
	}
    //LOAD ADVERT_VIDEO
    public function load_auction_video_home()
    {

        $footer['foo'] = '';
        $this->load->view('adverts/video', $footer);
    }
	//LOAD NEWS HOME PAGE
	public function load_news_home()
	{
		$this->load->model('news_model');
		echo ' <h3 class="na_script upper">Current News Headlines</h3>';
		//echo $this->news_model->get_home_news($offset = 0, $limit = 4, 'namibian', 3);
		echo $this->news_model->get_namibian(0, '3', 'new_era');
		echo $this->news_model->get_world_news(0, '3', 'world');
	}

	//LOAD NAMIBIA NEWS
	public function get_namibian_stories()
	{
		error_reporting(E_ALL);
		$this->my_na_model->get_namibian_stories();
	}
	//LOAD DEALS HOME PAGE
	public function load_properties_home()
	{
			echo '<div class="row-fluid">
                    <div class="span6">
                        <h3 class="na_script upper">Latest Properties</h3>

                    </div>
                    <div class="span6 text-right">
                        <a href="'.site_url('/').'buy/property/" class="btn btn-inverse" title="More Properties" rel="tooltip"  style="margin-top:15px;"><i class="icon icon-plus icon-white"></i> More Properties</a>

                    </div>
                  </div>';

			$this->load->model('trade_model');
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

                                        WHERE products.main_cat_id = 3408 AND products.is_active = 'Y'
                                        GROUP BY products.product_id
                                        ORDER BY listing_date DESC LIMIT 4");

			$this->trade_model->get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 3, $offset = 0, $title = '', $amt = 4 , FALSE);

	}
	//LOAD LATEST AUCTIONS
	public function load_auctions_home()
	{
        
			$this->load->model('trade_model');
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

                                        WHERE products.listing_type = 'A' AND products.is_active = 'Y'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 4");
		 $o = $this->trade_model->get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 3, $offset = 0, $title = '', $amt = 4 , FALSE);

		 $this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode(array('auctions' => $o)));			
			
	}
	//LOAD TRADE HOME PAGE
	public function load_trade_home()
	{
			echo '<h2 class="na_script upper">Latest Products</h2>';
			$this->load->model('trade_model');
			$query = "SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
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

                                        WHERE products.is_active = 'Y'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 4";
			$this->trade_model->get_products($query, 4);
			
	}

	//LOAD TRADE HOME PAGE
	public function load_auction_home()
	{
			echo '<h2 class="na_script upper">Latest Auctions</h2>';
			$this->load->model('trade_model');
			$query = "SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
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

                                        WHERE products.is_active = 'Y' AND products.listing_type = 'A'
                                        GROUP BY products.product_id
                                        ORDER BY products.end_date DESC LIMIT 4";
                                        
			$this->trade_model->get_products($query, 4);
			
	}

	//LOAD PROPERTIES HOME PAGE
	public function load_properties_new_home()
	{
			echo '<h2 class="na_script upper">Latest Properties</h2>';
			$this->load->model('trade_model');
			$query = "SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
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

                                        WHERE products.is_active = 'Y' AND products.main_cat_id = '1820'
                                        GROUP BY products.product_id
                                        ORDER BY products.end_date DESC LIMIT 4";
			$this->trade_model->get_products($query, 4);
			
	}
	
	//LOAD CARS HOME PAGE
	public function load_cars_home()
	{
			$this->load->model('trade_model');
			echo '<h3 class="na_script upper">Latest Cars Bikes and Boats</h3>';
			$query2 =  $this->db->query("SELECT   products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
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
										WHERE products.is_active = 'Y' AND products.status = 'live' AND products.main_cat_id = 348
										GROUP BY products.product_id
										ORDER BY products.listing_date DESC LIMIT 4");

			$this->trade_model->get_products($query2, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 3, $offset = 0, $title = '', $amt = 4 , FALSE);
	
	
	}
	
	//LOAD RESOURCES WITH AJAX AFTER PAGE LOAD
	public function get_sub_cats($id)
	{
			$this->load->model('search_model');
			
			$id = substr($id,0,strpos($id,'-'));

			$this->search_model->show_sub_cats($id);
			
	}
	//LOAD RESOURCES WITH AJAX AFTER PAGE LOAD
	public function reload_main_cats()
	{
			$this->load->model('search_model');
			
			$this->search_model->show_popular_cats();
			
	}


	//LOAD RESOURCES FOR MAP SEARCH
	public function load_map_view()
	{
			$this->load->view('business/inc/map_search');
			
			
	}
	//LOAD RESOURCES FOR MAP SEARCH
	public function show_na_count()
	{
			$this->my_na_model->show_na_count();
			
			
	}
	//++++++++++++++++++++++++++++++
	//Instant Search 
	//++++++++++++++++++++++++++++++
	public function ajax_search()
	{
			$this->my_na_model->instant_search(FALSE);
			
	}

	//++++++++++++++++++++++++++++++
	//Instant Search 
	//++++++++++++++++++++++++++++++
	public function ajax_search_json()
	{
			$this->my_na_model->instant_search_json();
			
	}
	//++++++++++++++++++++++++++++++
	//PREFETCH USER TYPEHEAD
	//++++++++++++++++++++++++++++++
	public function typehead_users()
	{
		$this->my_na_model->typehead_users();
	}

	//++++++++++++++++++++++++++++++
	//PREFETCH TYPEHEAD
	//++++++++++++++++++++++++++++++
	public function typehead($type = '', $cat = '')
	{
		/*$url =(site_url('/')."my_na/build_typehead/".$type."/".$cat);



		$res = $this->my_na_model->cacheObject($url,'typehead.json',7200);

		echo file_get_contents($res);*/
		echo $this->my_na_model->load_typehead($type, $cat);
		$this->output->set_content_type('application/json');	
	}
	
	//++++++++++++++++++++++++++++++
	//PREFETCH TYPEHEAD
	//++++++++++++++++++++++++++++++
	public function build_typehead($type = '', $cat = '')
	{
		echo $this->my_na_model->load_typehead($type, $cat);

	}
	
	//++++++++++++++++++++++++++++++
	//GLOBAL Search 
	//++++++++++++++++++++++++++++++
	public function search()
	{
		$type = $this->input->post('type', TRUE);
		$location = $this->input->post('location', TRUE);
		$main_cat_id = $this->input->post('main_cat_id', TRUE);
		$sub_cat_id = $this->input->post('sub_cat_id', TRUE);
		$sub_sub_cat_id = $this->input->post('sub_sub_cat_id', TRUE);
		$sub_sub_sub_cat_id = $this->input->post('sub_sub_sub_cat_id', TRUE);

 		$q = $this->input->post('srch_bar',TRUE);

		$data['title'] = rawurldecode($q);
		$data['key'] = $data['title'];
		$data['str'] = $q;
		$this->load->view('results_index', $data);

	}
	//++++++++++++++++++++++++++++++
	//GLOBAL RESULTS
	//++++++++++++++++++++++++++++++
	public function results()
	{



 		$q = $this->input->get('srch_bar',TRUE);

		$data['title'] = rawurldecode($q);
		$data['key'] = $data['title'];
		$data['str'] = $q;
		$this->load->view('results_index', $data);
 	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */