<?php
class My_na_model extends CI_Model{

    public function __construct()
    {
  		//parent::CI_model();
			
 	}


    function get_location_select() {

        
    }



    //+++++++++++++++++++++++++++
    //PRODUCTS WIDGET
    //++++++++++++++++++++++++++    
    public function get_feature_products($featured,$cat1,$cat2, $limit, $offset)
    {
        

        $this->load->model('image_model'); 
        $this->load->library('thumborp');

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 360;
        $height = 230;

        $l_width = 60;
        $l_height = 60;

        $likeSQL = '';
        $featSQL = '';

        $res = '';

        if($featured == 'Y'){
            $featSQL = "AND products.is_featured = 'Y' AND products.featured_until > NOW() ";
        }

        $sql = "SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                    u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                    group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
                                    MAX(product_auction_bids.amount) as current_bid,products_buy_now.amount,
                                    AVG(u_business_vote.RATING) as TOTAL,
                                    (
                                      SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                    ) as TOTAL_REVIEWS,
                                    main_cat.category_name as maincat,sub_cat.category_name as subcat,
                                    sub_sub_cat.category_name as subsubcat,sub_sub_sub_cat.category_name as subsubsubcat

                                    FROM products
                                    JOIN product_extras ON products.product_id = product_extras.product_id
                                    LEFT JOIN product_categories main_cat on main_cat.cat_id = products.main_cat_id AND main_cat.main_cat_id = 0
                                    LEFT JOIN product_categories sub_cat on sub_cat.cat_id = products.sub_cat_id AND sub_cat.sub_cat_id = 0
                                    LEFT JOIN product_categories sub_sub_cat on sub_sub_cat.cat_id = products.sub_sub_cat_id AND sub_sub_cat.sub_sub_cat_id = 0
                                    LEFT JOIN product_categories sub_sub_sub_cat on sub_sub_sub_cat.cat_id = products.sub_sub_sub_cat_id AND sub_sub_sub_cat.sub_sub_sub_cat_id = 0
                                    LEFT JOIN u_business ON u_business.ID = products.bus_id
                                    LEFT JOIN product_images ON products.product_id = product_images.product_id
                                    LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                    LEFT JOIN products_buy_now ON products_buy_now.product_id = products.product_id
                                    LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                          AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                    WHERE products.is_active = 'Y' AND products.status = 'live' ".$featSQL."
                                    GROUP BY products.product_id
                                    ORDER BY RAND() LIMIT ".$limit." OFFSET ".$offset."";


        $my = $this->db->query($sql, TRUE);
        

        if($my->result()){
            
            $res .= '<div class="owl-carousel" id="prod-carousel" style="margin-top:20px">';

            foreach ($my->result() as $row)
            {

                //get images
                $xx = 0;
                $img = array();
                $img_Cycle = '';
                if ($row->images != null)
                {

                    $imgA = explode(',', $row->images);
                    $imgAa = array();

                    foreach ($imgA as $imgR)
                    {
                        $lazy = '';
                        if ($xx == 0)
                        {
                            $lazy = 'lazy active';
                            $img_str = 'assets/products/images/' . $imgR;

                            $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                            $img[$xx] = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/"><img class="pic" src="'.$img_url.'" alt="' . strip_tags($row->title) . '" data-original="'.$img_url.'" style="width:100%"/></a>';
                        }
                        else
                        {

                            $at = '<img class="vignette" alt="' . strip_tags($row->title) . '" src="'.$img_url.'"/>';
                            array_push($imgAa, $at);

                        }


                        $xx++;
                    }

                    $img_Cycle = '<script id="images_' . $row->product_id . '" type="text/cycle">' . json_encode($imgAa) . '</script>';

                }
                else
                {


                    $img_str = 'assets/products/images/product_blank.jpg';

                    $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                    $img[0] = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/"><img class="pic" src="'.$img_url.'" alt="' . strip_tags($row->title) . '" data-original="'.$img_url.'" style="width:100%"/></a>';
                    
                }

                //CHECK IF AGENCY PROPERTY LISTING
                $b_logo = '';
                if ($row->IS_ESTATE_AGENT == 'Y')
                {
                    if (trim($row->BUSINESS_LOGO_IMAGE_NAME) != '')
                    {
                        $img_str = 'assets/business/photos/' . $row->BUSINESS_LOGO_IMAGE_NAME;
                        $img_bus_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $img_bus_url . '" alt="' . $row->BUSINESS_NAME . '" class="pull-right img-thumbnail" />';
                    }
                    else
                    {
                        $img_str = 'assets/business/photos/bus_blank.jpg';
                        $img_bus_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $img_bus_url . '" alt="' . $row->BUSINESS_NAME . '" class="pull-right img-thumbnail" />';
                    }
                }

                $btn_txt = 'Buy Now';
                if ($row->main_cat_id == 3408)
                {
                    $btn_txt = 'Enquire Now';
                }

                //Check Price
                //Fixed price
                if ($row->listing_type == 'S')
                {

                    $type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-dark pull-right">' . $btn_txt . '</a>&nbsp;
                                <a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';

                    if ($row->sub_cat_id == 3410)
                    {
                        $price = 'N$ ' . $this->smooth_price($row->sale_price) . ' pm';
                    }
                    else
                    {
                        $price = 'N$ ' . $this->smooth_price($row->sale_price);
                    }
                    if ($row->por == 'Y')
                    {

                        $price = 'POR:Price On Request';

                    }
                    //Auction   
                }
                elseif ($row->listing_type == 'A')
                {

                    //$price = '<span style=" font-size:18px">N$</span> '.$this->smooth_price($row->sale_price);
                    $price = $this->get_current_bid($row->current_bid);

                    if ($price['str'] != 'No Bids')
                    {
                        $price = 'BID: ' . $price['str'];

                    }
                    else
                    {
                        $price = $price['str'];
                    }

                    $type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-dark pull-right">Place Bid</a>&nbsp;
                                <a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';


                    //SERVICE
                }
                elseif ($row->listing_type == 'C')
                {

                    $btn = '';
                    $reserve = '';
                    $count = '';


                    if ($row->sub_cat_id == 3410)
                    {
                        $price = 'N$ <div itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</div> pm';
                    }
                    else
                    {
                        $price = 'N$ <div itemprop="price"> ' . $this->smooth_price($row->sale_price) . '</div>';
                    }
                    if ($row->por == 'Y')
                    {

                        $price = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

                    }

                    $btn_txt = 'Order Now';


                    $type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-dark pull-right">' . $btn_txt . '</a>&nbsp;
                                <a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';
                }

                $private = '';
                if ($row->bus_id == 0)
                {

                    $private = '<span class="private" rel="tooltip" title="This item is listed Privately"><i class="icon-star"></i></span>';

                }

                $fb = "postToFeed(" . $row->product_id . ", '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . "','" . trim($img_str) . "', '" . ucwords(trim($this->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->shorten_string(strip_tags($this->clean_url_str($row->description, " ", " ")), 50)))) . "', '" . site_url('/') . 'product/' . $row->product_id . '/' . trim($this->clean_url_str($row->title)) . "')";

                $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
                $tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';


                //LOCATION
                $location = '';
                if ($row->location != '')
                {

                    $location = '<div itemprop="address">' . $row->location . '</div>';

                    if ($row->suburb != 0 && $row->suburb != '')
                    {
                        $location = '<div itemprop="address" >' . $row->location . ' / ' . $row->suburb . '</div>';
                    }

                }

                //get REVIEWS
                $rating = 0;
                $total_reviews = 0;
                if ($row->TOTAL != null)
                {

                    $rating = $row->TOTAL;
                    if (isset($row->TOTAL_REVIEWS))
                    {
                        $total_reviews = $row->TOTAL_REVIEWS;
                    }
                    else
                    {
                        $total_reviews = 0;
                    }

                }

                $a_count = 0;
                if (isset($advert['count']))
                {
                    $a_count = $advert['count'];
                }

                //$ribbon = $this->trade_model->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');
                $res .= ' <div>
                            <figure class="loader">

                                <div class="ribbon-wrapper">
                                    <div class="product_ribbon_ft"><small style="color:#ff9900; font-size:14px">'.$price.'</small>'.$location.'</div>
                                    <div class="product_ribbon_ft_orng"><small>'.$row->subcat.' '.$row->subsubsubcat.'</small></div>
                                </div>                        
                                <div class="slideshow-block">
                                    <a href="#" class="link"></a>
                                    <div class="cycle-slideshow cycle-paused" data-cycle-speed="500" data-cycle-timeout="500" data-cycle-loader=true data-cycle-progressive="#images_' . $row->product_id . '" data-cycle-slides="> li">
                                    ' .implode($img). '
                                    </div>
                                    ' .$img_Cycle. '
                                </div> 

                                <div>
                                
                                    <a href="'.site_url('/').'b/'.$row->ID.'/'.$this->clean_url_str($row->BUSINESS_NAME).'">'. $b_logo . '</a>

                                </div>
                            </figure>           
                      </div>
                      ';

            }

            $res .= '</div>';


        }else{
            
                
        }

        return $res;
    } 



    //+++++++++++++++++++++++++++
    //BUSINESS WIDGET
    //++++++++++++++++++++++++++    
    public function get_feature_businesses($featured,$cat1,$cat2, $limit, $offset)
    {
        
        $this->load->model('image_model'); 
        $this->load->library('thumborp');

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 360;
        $height = 230;

        $l_width = 100;
        $l_height = 100;
        
        $likeSQL = '';
        $sql = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats, city.MAP_LOCATION as city_name,
                            country.COUNTRY_NAME as country_name
                            FROM u_business
                            LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
                            JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
                            JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
                            JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
                            LEFT JOIN a_map_location AS city ON city.ID = u_business.BUSINESS_MAP_CITY_ID
                            LEFT JOIN a_country AS country ON country.ID = u_business.BUSINESS_COUNTRY_ID
                        WHERE u_business.ISACTIVE = 'Y' ".$likeSQL." AND u_business.PAID_STATUS > 0
                        GROUP BY u_business.ID  ORDER BY RAND() LIMIT ".$limit." OFFSET ".$offset." ";
        $my = $this->db->query($sql, TRUE);
        
        if($my->result()){
       
            $res = '<div class="owl-carousel bus-carousel" id="bus-carousel" style="margin-top:20px">';

            foreach($my->result() as $row){

                $name = $row->BUSINESS_NAME;
                $logo = $row->BUSINESS_LOGO_IMAGE_NAME;
                $cover = $row->BUSINESS_COVER_PHOTO;
                $id = $row->ID;
                $email = $row->BUSINESS_EMAIL;
                $tel = $row->BUSINESS_TELEPHONE;
                $description = $row->BUSINESS_DESCRIPTION;
                $url = $row->BUSINESS_URL;
                $address = $row->BUSINESS_PHYSICAL_ADDRESS;

                if ($logo != '')
                {

                    if (strpos($logo, '.') == 0)
                    {

                        $format = '.jpg';
                        $logo_str = 'assets/business/photos/' . $logo . $format;
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $name . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $name . '" class="pull-right img-thumbnail" />';
                    }
                    else
                    {

                        $logo_str = 'assets/business/photos/' . $logo;
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $name . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $name . '" class="pull-right img-thumbnail" />';

                    }

                }
                else
                {
                    $logo_url = base_url('/').'images/bus_blank.png';
                    $b_logo = '<img title="' . $name . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $name . '" class="pull-right img-thumbnail" />';

                }


                if ($cover != '')
                {

                    if (strpos($cover, '.') == 0)
                    {

                        $format = '.jpg';
                        $cover_str = 'assets/business/photos/' . $cover . $format;
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');

                    }
                    else
                    {

                        $cover_str = 'assets/business/photos/' . $cover;
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');

                    }

                }
                else
                {
                    $cover_str = 'assets/business/photos/listing-placeholder.jpg';
                    $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');
                }


                list($first, $last) = explode(",", $row->cats);


                $res .= '
                <div> 
                    <figure class="loader">
                        <div class="ribbon-wrapper">
                            <div class="product_ribbon_ft"><small style="color:#ff9900; font-size:14px">'.$name.'</small>'.$row->city_name.'</div>
                            <div class="product_ribbon_ft_orng"><small>'.$first.'</small></div>
                        </div>

                        <div class="slideshow-block">
                            <a href="' . site_url('/') . 'b/' . $id . '/' . $this->clean_url_str($name) . '/"><img class="" src="' . $cover_url . '" alt="' . $name . '"></a>
                        </div>

                        <div>
                        
                            '.$b_logo.'  

                        </div>
                    </figure>           
                </div>
                ';

            }     


            $res .= '</div>';

        }else{
            

                
        }

        return $res;
    } 



    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //GET HOME CATEGORIES
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++     
    function home_categories($typ){
            
        //Get Main
        $main = $this->db->query("SELECT i_tourism_category.CATEGORY_ID, COUNT(i_tourism_category.CATEGORY_ID) as num,
                                a_tourism_category_sub.*,a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME,a_tourism_category.CATEGORY_ICON as CAT_ICON,
                                group_concat(DISTINCT(sub_table.ID),'_-_',sub_table.CATEGORY_NAME) as cats
                                FROM i_tourism_category 
                                JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID 
                                JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
                                LEFT JOIN a_tourism_category_sub as sub_table ON sub_table.CATEGORY_TYPE_ID = a_tourism_category.ID  
                                GROUP BY a_tourism_category_sub.CATEGORY_TYPE_ID ORDER BY num DESC LIMIT 12", FALSE);
        
            
        foreach($main->result() as $row){
        
            $main_id = $row->CATEGORY_TYPE_ID;
            $main_name = $row->MAIN_CAT_NAME;
            $icon = $row->CAT_ICON;

            $subs = $this->show_sub_cats($main_id);
            
            echo '
            <div class="col-xs-6 col-sm-6 col-md-4 category">
                <a href="#" data-icon="'.$icon.' text-'.$typ.'"></a>
                <h3>'.$row->MAIN_CAT_NAME.'</h3>
                <p>'.$subs.'</p>
            </div>
            ';
            
        }
                    
    }


    //SHOW SUB CATEGORIES ON HOME PAGE
    function show_sub_cats($id){
            
        $o = '';    
        $sub = $this->get_sub_categories($id);  
            
            $i = 1;
            foreach($sub->result() as $sub_row){
                
                if($i==5) { $comma = ''; }else{ $comma = ', '; }

                $sub_id = $sub_row->ID;
                $sub_name = $sub_row->CATEGORY_NAME;

                $o .= '<a href="'.site_url('/').'a/cat/'.$sub_id.'/'.$this->clean_url_str($sub_name).'">'.$sub_name.'</a>'.$comma.' ';
                $i++;
            }

         return $o;   
            
    }    


    //GEt sub Categories
    function get_sub_categories($cat_id){
        
        $test = $this->db->query("SELECT a_tourism_category_sub.CATEGORY_NAME, a_tourism_category_sub.ID
                                    FROM a_tourism_category_sub
                                    JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
                                    WHERE a_tourism_category_sub.CATEGORY_TYPE_ID = '".$cat_id."' LIMIT 5", FALSE);
        return $test;
                  
    }    
 


	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET NAMIBIAN NEWS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 public function get_namibian_stories($offset = 0, $limit = 10, $type = ''){

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('namibian_news_'.$type))
        {
			$this->load->model('news_model');
			if($output = $this->news_model->get_namibian_stories($offset = 0, $limit = 10, $type = '')){
				
				$this->cache->save('namibian_news_'.$type, $output, 3600);
			}else{
				
				
			}
		}

		echo $output;
	
	}
	
	
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET LOCATION FROM IP
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 public function get_ip_location(){


            if($country = $this->session->userdata('country')){
				
				$data['city'] = $this->session->userdata('city');
				$data['c_code'] = $this->session->userdata('c_code');
                $data['lat'] = $this->session->userdata('lat');
                $data['lon'] = $this->session->userdata('lon');
				$data['country'] = $country;
				return $data;
				
			}else{

                if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){

                    $IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
                }else{

                    $IP = '41.182.24.129'; // Windhoek
                    //$IP = '105.232.202.207'; //Swakop;
                }
				include(BASE_URL."geoip/geoipcity.inc");
	
				include(BASE_URL."geoip/geoipregionvars.php");
	
				$gi = geoip_open(BASE_URL."geoip/GeoLiteCity.dat",GEOIP_STANDARD,GEOIP_MEMORY_CACHE);

				$record = geoip_record_by_addr($gi,$IP);
                //var_dump($record);
                //echo $IP;
				$data['city'] = $record->city;
				$data['c_code'] = $record->country_code;
				$data['country'] = $record->country_name;
                if($record->country_code == 'na' && $record->city != null){

                    $data['lon'] = $record->longitude;
                    $data['lat'] = $record->latitude;

                }else{
                    $data['lon'] = null;
                    $data['lat'] = null;

                }

				$this->session->set_userdata($data);
				return $data;
				
			}
 
		
	}

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET WEATHER
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_weather_report($time = ''){

        	
			$location = $this->get_ip_location();
            $this->load->model('weather_model');
            return $this->weather_model->get_weather($location['city'], $location['c_code'], $time);
            
       
    }
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET LOCAL LINKS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_local_links(){

			
			$location = $this->get_ip_location();
			$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

			
            //LOCAL IS LEKKER
/*			if($location['lat'] != null && $location['lon'] != null && $location['c_code'] == 'NA') {
                // if (!$output = $this->cache->get('local_results_' . $location['city'])) {
                //echo $location['city'];

                    $output = $location['lat'] .' '. $location['lon'];

                    $SQL = "SELECT *,(((acos(sin((" . $location['lat'] . "*pi()/180)) *
                                                    sin((BUSINESS_MAP_LATITUDE*pi()/180))+cos((" . $location['lat'] . "*pi()/180)) * cos((BUSINESS_MAP_LATITUDE*pi()/180)) * cos(((" . $location['lon'] . " - BUSINESS_MAP_LONGITUDE)*pi()/180))))*180/pi())*60*1.1515)
                                                    as distance
                                                    FROM u_business
                                                    JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
                                                    HAVING distance < 20
                                                    ORDER by distance";
                    $main = $this->db->query("SELECT u_business.*,(((acos(sin((" . $location['lat'] . "*pi()/180)) *
                                                    sin((BUSINESS_MAP_LATITUDE*pi()/180))+cos((" . $location['lat'] . "*pi()/180)) * cos((BUSINESS_MAP_LATITUDE*pi()/180)) * cos(((" . $location['lon'] . " - BUSINESS_MAP_LONGITUDE)*pi()/180))))*180/pi())*60*1.1515)
                                                    as distance
                                                    FROM u_business
                                                    JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
                                                    HAVING distance < 1
                                                    ORDER by distance LIMIT 10", FALSE);


                    $output .= $SQL.'<h4 class="yellow na_script upper">Current Location Not Found</h4>';




                //$this->cache->save('local_results_' . $location['city'], $output, 3600);
                //}

            //CITY
            }else*/

            if($location['country'] == 'Namibia' && $location['city'] != null){



                if (!$output = $this->cache->get('local_results_' . $location['city'])) {
                    //echo $location['city'];
                    $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), u_business.BUSINESS_NAME,
										COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category_sub.*
										FROM i_tourism_category
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN u_business ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
										WHERE a_map_location.MAP_LOCATION LIKE '%" . $location['city'] . "'
										GROUP BY i_tourism_category.CATEGORY_ID
										ORDER BY num DESC
										LIMIT 5", FALSE);
                    $output = '';
                    if ($main->result()) {
                        $output .= '<h4 class="yellow na_script upper">Local Results in ' . $location['city'] . '</h4>';
                        foreach ($main->result() as $row) {
                            $output .= '<a class="btn white_back na_script upper"
								href="' . site_url('/') . 'a/d/' . $row->CATEGORY_TYPE_ID . '/' . $this->clean_url_str($row->CATEGORY_NAME) . '/' . $location['city'] . '" style="margin:5px">
								 ' . $row->CATEGORY_NAME . ' <i class="icon-chevron-right"></i></a>';


                        }
                    }
                    $output .= '<a class="btn white_back na_script upper"
                                href="javascript:void(0)" onclick="locate_me()" style="margin:5px">
                                Locate Me <i class="icon-map-marker"></i></a>';
                    $this->cache->save('local_results_' . $location['city'], $output, 3600);
                }


            //NATIONAL
            }elseif($location['c_code'] == 'NA'){

                if (!$output = $this->cache->get('local_results_' . $location['c_code'])) {
                    //echo $location['city'];
                    $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), u_business.BUSINESS_NAME,
										COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category_sub.*
										FROM i_tourism_category
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN u_business ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
										WHERE a_map_location.MAP_LOCATION LIKE '%" . $location['city'] . "'
										GROUP BY i_tourism_category.CATEGORY_ID
										ORDER BY num DESC
										LIMIT 5", FALSE);
                    $output = '';
                    if ($main->result()) {
                        $output .= '<h4 class="yellow na_script upper">Local Results in Namibia</h4>';
                        foreach ($main->result() as $row) {
                            $output .= '<a class="btn white_back na_script upper"
								href="' . site_url('/') . 'a/d/' . $row->CATEGORY_TYPE_ID . '/' . $this->clean_url_str($row->CATEGORY_NAME) . '/' . $location['city'] . '" style="margin:5px">
								 ' . $row->CATEGORY_NAME . ' <i class="icon-chevron-right"></i></a>';


                        }
                    }
                    $output .= '<a class="btn white_back na_script upper"
                                href="javascript:void(0)" onclick="locate_me()" style="margin:5px">
                                Locate Me <i class="icon-map-marker"></i></a>';
                    $this->cache->save('local_results_' . $location['c_code'], $output, 3600);
                }

             //INTERNATIONAL
			}else{
				
				if ( ! $output = $this->cache->get('international_results_'))
				{
				
					$main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), u_business.BUSINESS_NAME,
										COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category_sub.* 
										FROM i_tourism_category 
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN u_business ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID  
										GROUP BY i_tourism_category.CATEGORY_ID 
										ORDER BY num DESC 
										LIMIT 5", FALSE);
					$output = '';
					 if($main->result()){
							$output .= '<h4 class="yellow na_script upper">Local Results</h4>'; 
							foreach($main->result() as $row){
								$output .= '<a class="btn white_back na_script upper" 
								href="'.site_url('/').'a/cat/'.$row->CATEGORY_TYPE_ID.'/'.$this->clean_url_str($row->CATEGORY_NAME).'/'.'" 
								style="margin:5px">
								 '.$row->CATEGORY_NAME.' <i class="icon-chevron-right"></i></a>';
								
								
							}
					 }
					
									
					$this->cache->save('international_results_', $output, 3600);
				}
				
				
			}
		echo $output;
       
    }


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET POPULAR CATS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function show_popular_cats($type){

        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('popular_cats_'.$type))
        {
            
			$this->load->model('search_model');
			//$output = '';
            $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME,
                                    a_tourism_category_sub.* FROM i_tourism_category 
									JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID 
									JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID 
									GROUP BY i_tourism_category.CATEGORY_ID ORDER BY num DESC LIMIT 20", FALSE);


            foreach($main->result() as $row){

                    $main_id = $row->CATEGORY_TYPE_ID;
					$cat_id = $row->ID;
					$cat_name = $row->CATEGORY_NAME;
                    $main_name = $row->MAIN_CAT_NAME;
                    if($type === true) {

                        $output .= '<li><a href="' . site_url('/') . 'a/show/' . $main_id . '/' . $this->search_model->clean_url_str($main_name) . '/'. $cat_id . '/' . $this->search_model->clean_url_str($cat_name) . '"> ' . $cat_name . '</a></li>';


                    }else{
                        $output .= '<a class="btn white_back na_script upper" href="'. site_url('/') . 'a/show/' . $main_id . '/' . $this->search_model->clean_url_str($main_name) . '/'. $cat_id . '/' . $this->search_model->clean_url_str($cat_name) . '" style="margin:5px" id="'.$main_id.'-m_cat"> '.$cat_name.' <i class="icon-chevron-right"></i></a>';


                    }
                    //echo '<a class="btn" onclick="load_sub_cats('.$row->ID.')" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';

            }

            $this->cache->save('popular_cats_'.$type, $output, 172800);
        }else{

            echo $output;

        }
        //return $this->output->set_output($output);
        //echo $output;

    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET USER AVATAR
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_countries($selected = '', $tel = false, $select = false, $class = '', $id = '')
    {

        $q = $this->db->get('country');

        if($select){

            if($tel){

                echo '<select class="form-control col-md-2" name="'.$id.'" id="'.$id.'">';
                foreach($q->result() as $row){


                    if($selected == $row->phonecode){
                        echo '<option value="'.strtolower($row->phonecode).'" selected>'.$row->nicename.' +'.$row->phonecode.'</option>';
                    }else{
                        echo '<option value="'.strtolower($row->phonecode).'">'.$row->nicename.' +'.$row->phonecode.'</option>';
                    }

                }
                echo '</select>';

            }else{
                echo '<select class="form-control '.$class.'"  id="'.$id.'">';
                foreach($q->result() as $row){


                    echo '<option value="'.strtolower($row->iso).'">'.$row->nicename.'</option>';

                }
                echo '</select>';


            }


        }else{

            $code = $this->session->userdata('c_code');
            //echo $code;
            if($code == ''){

                $code = 'NA';
            }
            $found = false;
            //BUILD CURRENT VALUE
            foreach($q->result() as $row1){

                //OVERRIDE FOR PROVIDED C_CODE
                if($selected != '' && $selected != 0){

                    if($selected == $row1->phonecode )
                    {

                        echo '<input type="hidden" id="dial_code"  name="dial_code"  value="' . $row1->phonecode . '">
                            <div class="btn-group">
                              <button class="btn btn-secondary" id="fl_select"><img src="' . base_url('/') . 'images/blank.gif" class="flag flag-' . strtolower($row1->iso) . '" > +' . $row1->phonecode . ' </button>
                              <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" style="max-height:200px;overflow-y: scroll; overflow-x: hidden" role="menu" aria-labelledby="dLabel">';
                        $found = true;

                    }
                }elseif($row1->iso == $code){
                   
                    echo '<input type="hidden" id="dial_code"  name="dial_code"  value="'.$row1->phonecode.'">
                            <div class="btn-group">
                              <button class="btn btn-secondary" id="fl_select"><img src="'.base_url('/').'images/blank.gif" class="flag flag-'.strtolower($row1->iso).'" > +'.$row1->phonecode.' </button>
                              <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" style="max-height:200px;overflow-y: scroll; overflow-x: hidden" role="menu" aria-labelledby="dLabel">';
                    $found = true;

                }



            }

            if(!($found)){
                echo '<input type="hidden" id="dial_code" name="dial_code" value="264">
                        <div class="btn-group">
                              <button class="btn" id="fl_select">+264 <img src="'.base_url('/').'images/blank.gif" class="flag flag-na" ></button>
                              <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" style="max-height:200px;overflow-y: scroll; overflow-x: hidden" role="menu" aria-labelledby="dLabel">';

            }

            foreach($q->result() as $row){


                echo '<li role="presentation">
                            <a id="fl_select_'.$row->id.'" href="javascript:select_country('.$row->id.');" data-phone="'.$row->phonecode.'" data-code="'.strtolower($row->iso).'" tabindex="-1">
                                <img src="'.base_url('/').'images/blank.gif" class="flag flag-'.strtolower($row->iso).'" > '.$row->nicename.' +' .$row->phonecode.'
                            </a>
                      </li>';

            }
            echo '</ul>
                </div>
                <script>

                    function select_country(id){


                        var sl = document.getElementById("fl_select_"+id),
                        but = document.getElementById("fl_select"),
                        dial = document.getElementById("dial_code"),
                        code = sl.getAttribute("data-code"),
                        phone = sl.getAttribute("data-phone"),
                        out = "<img src='."'".base_url('/')."images/blank.gif' class='flag flag-".'"+code+"'."'".'> +"+phone;
                        but.innerHTML = out;
                        dial.value = phone;



                    }
                </script>
                ';

        }



    }
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER AVATAR
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_user_avatar($w, $h){
		
		 if($this->session->userdata('id')){ 
			 		
				$img_file = $this->session->userdata('img_file');
				
				if(strstr($img_file, "http")){
					
					$img = $img_file;
				
				}elseif($img_file != ''){ 
				
					$img = S3_URL.'assets/users/photos/'.$img_file;
					
				}else{
					
					$img = S3_URL.'img/user_blank.jpg';
					
				}
				
				//$avatar = '<img src="'.base_url('/').'img/timbthumb.php?src='.base_url('/').$img.'&q=100&w='.$w.'&h='.$h.'" class="img-polaroid" />';
				$avatar = '<img src="'.$img.'"  class="img-polaroid pull-left" />';
				return $avatar;
		 }
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER AVATAR URL STRING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_user_avatar_str($w, $h){
		
        $this->load->model('image_model'); 
        $this->load->library('thumborp'); 

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();  

		 if($this->session->userdata('id')){ 
			 		
				$img_file = $this->session->userdata('img_file');
				
				if(strstr($img_file, "http")){
					
					$img_url = $img_file.'?width='.$w.'&height='.$h;
				
				}elseif($img_file != ''){ 
				
					$img_str = 'assets/users/photos/'.$img_file;
                    $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$w,$h, $crop = '');
					
				}else{
					
					$img_str = 'assets/users/photosuser_blank.jpg';
                    $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$w,$h, $crop = '');
					
				}
				
				//$avatar = base_url('/').'img/timbthumb.php?src='.base_url('/').$img.'&q=100&w='.$w.'&h='.$h;
				$avatar = $img_url;
				return $avatar;
		 }
		
	}
    
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER AVATAR URL STRING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_user_avatar_id($id ,$w, $h, $img = ''){


            $this->load->model('image_model'); 

            $this->load->library('thumborp');
            $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
            $width = $w;
            $height = $h;


			if($img == ''){


				$this->db->from('u_client');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();

				if($query->result())
				{
					$img_file = $row['CLIENT_PROFILE_PICTURE_NAME'];
				}else{

					$img_file = '';
				}

			}else{
				$img_file = $img;
			}

			if(strstr($img_file, "http")){

                $img_url = $img_file;
                //$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');


			}elseif($img_file != ''){

				$img_str = 'assets/users/photos/'.$img_file;
                $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');              

			}else{

                $img_str = 'assets/users/photos/user_blank.jpg';
                $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');                   

			}

			//$avatar = base_url('/').'img/timbthumb.php?src='.base_url('/').$img.'&q=100&w='.$w.'&h='.$h;
			$avatar = $img_url;
			return $avatar;


	}

    //++++++++++++++++++++++++++++++++++++++++++++
    //
    //GET BUSINESSESES
    //++++++++++++++++++++++++++++++++++++++++++++


    function get_businesses($current = 0, $typestr ='', $auction = '', $selected = '')
    {
        $id = $this->session->userdata('id');
        //
        $query = $this->db->query("SELECT u_business.*,i_client_business.CLIENT_ID FROM u_business
                                    JOIN i_client_business ON u_business.ID = i_client_business.BUSINESS_ID
                                    WHERE i_client_business.CLIENT_ID = '".$id."'
                                    ");
        $type ='sell/index/';
        if($typestr == 'my_trade'){

            $type ='sell/my_trade/';

        }

        if($selected == 'Yes') { $sel = 'selected'; } else { $sel = ''; }

        $output = '';
        $c = false;
        if($query->result()){
            $x = 0;$x1 = 0;$x2 = 0;

            foreach($query->result_array() as $row1) {

                if($current == $row1['ID']){

                    $output .= '<img src="'. $this->my_na_model->get_business_logo($row1['ID'], 60, 60, $row1['BUSINESS_LOGO_IMAGE_NAME']).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-thumbnail" />
                                      ';

                    $output .= '<div class="btn-group">
                                  <a class="btn dropdown-toggle btn-dark" data-toggle="dropdown" href="#">
                                     '.$row1['BUSINESS_NAME'].'
                                    <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu text-left">';

                    $c = true;
                }

                $x1 ++;
            }

            if($c === false){
                foreach($query->result_array() as $row2) {

                    if($x2 == 0){

                        $output .= '<img src="'. $this->my_na_model->get_business_logo($row2['ID'], 60, 60, $row2['BUSINESS_LOGO_IMAGE_NAME']).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-thumbnail" />
                                      ';

                        $output .= '<div class="btn-group">
                                  <a class="btn dropdown-toggle btn-dark" data-toggle="dropdown" href="#">
                                     '.$row2['BUSINESS_NAME'].'
                                    <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu text-left">';

                    }

                    $x2 ++;
                }


            }

            foreach($query->result_array() as $row){

                //$output .= '<li><a href="javascript:void(0)" onclick="">'.$row['BUSINESS_NAME'].'</a></li>';

                $output .= '<li><a href="'.site_url('/').$type.$row['ID'].'/?'.$auction.'" onclick="">'.$row['BUSINESS_NAME'].'</a></li>';


                $x++;

            }
            $output .= '</ul>
                     </div> ';



        }else{


           $output .= '<img src="'. base_url('/').'img/bus_blank.jpg" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                        <div class="btn-group">
                            <a class="btn btn-inverse">
                             No Businesses
                            </a>
                        </div>
                            ';


        }
        return $output;

    }

    //++++++++++++++++++++++++++++++++++++++++++++
    //GET BUSINESSESES DROPDOWN MENU
    //++++++++++++++++++++++++++++++++++++++++++++


    function get_businesses_nav()
    {
        $id = $this->session->userdata('id');

        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('clients/business_nav'.$id)) {
                $query = $this->db->query("SELECT u_business.*,i_client_business.CLIENT_ID FROM u_business
                                            JOIN i_client_business ON u_business.ID = i_client_business.BUSINESS_ID
                                            WHERE i_client_business.CLIENT_ID = '" . $id . "'
                                            ");

                $output = '';

                if ($query->result()) {
                    $x = 0;
                    $x1 = 0;
                    $x2 = 0;
                    foreach ($query->result_array() as $row) {
                        $output .= '<li><a href="' . site_url('/') . 'members/business/' . $row['ID'] . '/?">' . $this->shorten_string($row['BUSINESS_NAME'], 5) . '</a></li>';
                        $x++;
                    }

                }
                $this->cache->save('clients/business_nav'.$id, $output, 3600);
        }
        return $output;

    }

	//++++++++++++++++++++++++++++++++++++++++++++
	//GET BUSINESS LOGO
	//++++++++++++++++++++++++++++++++++++++++++++

	function get_business_logo($id, $w, $h, $img){

        $this->load->model('image_model'); 
        $this->load->library('thumborp'); 

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 60;
        $height = 60;           

		if($id != '0'){

			if($img == ''){

				$this->db->from('u_business');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();

				if($query->result())
				{

					$img = $row['BUSINESS_LOGO_IMAGE_NAME'];
					$data['name'] = $row['BUSINESS_NAME'];
				}else
				{

					$img = '';
				}

			}else{

				$img = $img;

			}

			//Build image string
			$format = substr($img,(strlen($img) - 4),4);
			$str = substr($img,0,(strlen($img) - 4));

			if($img != ''){

				if(strpos($img,'.') == 0){

					$format = '.jpg';
					$img_str = 'assets/business/photos/'.$img . $format;
                    $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

				}else{

					$img_str = 'assets/business/photos/'.$img;
                    $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

				}

			}else{

				$img_str = 'assets/business/photos/bus_blank.png';
                $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

			}


			return $img_url;

		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS COUNT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function msg_notifications_count(){
		
		//GET ALL MESSAGES FOR USER
		$x = 0;
		$query1 = $this->db->query("SELECT COUNT(*) as TOTAL FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' AND status_client = 'unread'",FALSE); 
	    $row1 = $query1->row_array();
		$x = $x + $row1['TOTAL'];
		//GET ALL BUSINESSES FOR USER
	   	$this->db->where('CLIENT_ID' , $this->session->userdata('id'));
		$query = $this->db->get('i_client_business');
		
		if($query->num_rows() > 0){
			
			foreach($query->result() as $row){
				
				$bus_id = $row->BUSINESS_ID;
				//GET ALL MESSAGES PER BUSINESS
				$query = $this->db->query("SELECT COUNT(*) as TOTAL FROM u_business_messages WHERE bus_id = '".$bus_id."' AND status = 'unread'",FALSE);
				$row2 = $query->row_array();
				
				
				$x = $x + $row2['TOTAL'];
				
			}
			
			
		}else{
	
				
		}
	   
	   
		if($x == 0){
				echo '';
		}else{
				echo '<span class="notification-small yellow">'.$x.'</span>';
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS ALL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function msg_notifications(){
		
		//GET ALL MESSAGES FOR USER
		$x = 0;
		$query1 = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' AND status_client = 'unread' LIMIT 3",FALSE); 
	   
		
		
		if($query1->result()){
			
			foreach($query1->result() as $row_user){
				
				echo '<li style="border-bottom:1px solid #f1f1f1"><a href="'.site_url('/').'members/home/message/'.$row_user->msg_id.'"><i class="icon-envelope"></i> '.$row_user->nameFROM.'<font style="font-size:10px;"><br /> '.substr(strip_tags(str_replace('-','',$row_user->body)),0,50).'</font></a></li>';
				
			}
		}
		
		//GET ALL BUSINESSES FOR BUSINESS
		$this->db->where('CLIENT_ID' , $this->session->userdata('id'));
		$query = $this->db->get('i_client_business');
		
		if($query->num_rows() > 0){
			
			foreach($query->result() as $row){
				
				$bus_id = $row->BUSINESS_ID;
				//GET ALL MESSAGES PER BUSINESS
				$query = $this->db->query("SELECT * FROM u_business_messages WHERE bus_id = '".$bus_id."' AND status = 'unread' LIMIT 3",FALSE);
				
				foreach($query->result() as $row2){
					
					echo '<li style="border-bottom:1px solid #f1f1f1"><a href="'.site_url('/').'members/business/'.$bus_id.'/message/'.$row2->msg_id.'"><i class="icon-envelope"></i> '.$row2->nameFROM.'<font style="font-size:10px;"><br /> '.substr(strip_tags(str_replace('-','',$row2->body)),0,50).'</font></a></li>';	
					
				}
				
				
			}
			
			
		}
	   
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS  PER BUSINESS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function msg_notifications_business($bus_id){
		
			//GET ALL MESSAGES PER BUSINESS
			$query = $this->db->query("SELECT * FROM u_business_messages WHERE bus_id = '".$bus_id."' AND status = 'unread'",FALSE);
			
			if($query->num_rows() == 0){
				echo '';
			}else{
					echo '<span class="notification-small yellow">'.$query->num_rows().'</span>';
			}

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS FOR USER
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function msg_notifications_member(){
		
			//GET ALL MESSAGES PER BUSINESS
			$query = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' AND status_client = 'unread'",FALSE);
			
			if($query->num_rows() == 0){
				echo '';
			}else{
					echo '<span class="notification-small yellow">'.$query->num_rows().'</span>';
			}

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_points(){
		
		$this->db->where('CLIENT_ID', $this->session->userdata('id'));
		$query = $this->db->get('u_client_points_summary');
		if($query->result()){
			
			$row = $query->row_array();
			
            $max = $row['POINTS'] * 1.9;               
                
			echo '<div class="circleStats pull-right"><div class="circleStatsItem orange">
					<a href="'.site_url('/').'win/scratch_and_win/" >
					<i class="icon-na"></i><input type="text" id="member_points" value="" class="orangeCircle" /></div></a></div>
						
					<script type="text/javascript">
					$(document).ready(function() {
						$("#member_points").val('.$row['POINTS'].');
						$(".orangeCircle").knob({
										"min":0,
										"max":'. $max.',
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.2,
										"tickColorizeValues": true,
										"skin":"tron"
									})
						});
						$(".na_points").mouseover(function(){ 
	
						  $(this).popover({ placement:"left",html: true, title:"Your My Namibia Points", 
						  content:"These are your current accumulated points. To earn more points you can review businesses and connect with businesses"});
						  $(this).popover("show");
						  }).mouseout(function(){
				  
						  $(this).popover("destroy");
						});
					
					</script>';
			
			
		}else{
			
			echo '<div class="circleStats pull-right"><div class="circleStatsItem orange">
					<a href="'.site_url('/').'win/scratch_and_win/" >
					<i class="icon-na"></i><input type="text" id="member_points" value="" class="orangeCircle" /></div></a></div>
						
					<script type="text/javascript">
					$(document).ready(function() {
						$("#member_points").val(0);
						$(".orangeCircle").knob({
										"min":0,
										"max":10,
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.2,
										"tickColorizeValues": true,
										"skin":"tron"
									})
						});
						$(".na_points").mouseover(function(){ 
	
						  $(this).popover({ placement:"left",html: true, title:"No Points", 
						  content:"You have gained no points. Review some companies and connect to earn points"});
						  $(this).popover("show");
						  }).mouseout(function(){
				  
						  $(this).popover("destroy");
						});
					
					</script>';
			
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_points_sml(){
		
		$this->db->where('CLIENT_ID', $this->session->userdata('id'));
		$query = $this->db->get('u_client_points_summary');
		if($query->result()){
			
			$row = $query->row_array();
			
            $max = $row['POINTS'] * 1.9;               
                
			echo ''.$row['POINTS'].'';
				
			
		}else{
			
			echo '';
			
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+COUNT USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function count_points($id = ''){
		
		if($id == ''){
			
			$id = $this->session->userdata('id');	
		}
		$this->db->where('CLIENT_ID', $id);
		$query = $this->db->get('u_client_points_summary');
		 if($query->result()){
			$row = $query->row_array();
			return $row['POINTS'];
		 }else{
			 
			return '0'; 
		 }
	}
	
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+COUNT USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function scratch_win_slide(){
		
		echo '<h3>Play Scratch & Win</h3>';
		
		if($this->session->userdata('id')){
		
			$link = site_url('/').'win/scratch_and_win/';
			
		}else{
			
			$link = site_url('/').'members/register/';
			
		}
		 echo   '<div id="scratch_slider" class="carousel slide">
					  <div class="carousel-inner">
						<div class="active item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_1a.png" /></a></div>
						<div class="item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_2a.png" /></a></div>
						<div class="item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_3a.png" /></a></div>
					  </div>
					</div>';		
		 echo ' <script type="text/javascript">
		  $(document).ready(function(){
			  
				$("#scratch_slider").carousel()
			  
		  });
		    
		  </script>
		  ';
		  
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Scratch AND WIN IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function scratch_win_img(){
		
		echo '<h3>Play Scratch & Win</h3>';
		
		if($this->session->userdata('id')){
		
			$link = site_url('/').'win/scratch_and_win/';
			
		}else{
			
			$link = site_url('/').'members/register/';
			
		}
		 echo   '<div id="scratch_slider" class="carousel slide">
					  <div class="carousel-inner">
						<div class="active item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_1a.png" /></a></div>
						
					  </div>
					</div>';		
 
	}

	
	
    //+++++++++++++++++++++++++++
	//SHOW NA CONNECTIONS
	//++++++++++++++++++++++++++
    public function show_na_count()
    {
        //GET NA COUNT DETAILS	
		//$query = $this->db->limit('100');		
		$query = $this->db->query("SELECT COUNT(*) as total from u_business_na");
		if($query->result()){
		   
		   echo '<h2 class="total-na-counter">';
				$row = $query->row();
				$total = $row->total;
			
				$strlen = strlen( trim($total) );
				for( $i = 0; $i <= $strlen; $i++ ) {
					$char = substr( $total, $i, 1 );
					if($char == ''){
						
					}else{
						echo '<span>'.$char.'</span>';
						
					}
					
					// $char contains the current character, so do your processing here
				}

		  echo '</h2><h2 class="na_script">Business Connections Made</h2>';
		   
		}else{
			return '';
		}		
    }
    //+++++++++++++++++++++++++++
	//SHOW SCRATCH WINNER COUNT
	//++++++++++++++++++++++++++
    public function show_winner_count()
    {
        //GET NA COUNT DETAILS			
		$query = $this->db->query("SELECT COUNT(*) as total from scratch_winners");
		if($query->result()){
		   
		   echo '<h2 class="total-na-counter">';

				$row = $query->row();
				$total = $row->total;
			
				$strlen = strlen( trim($total) );
				for( $i = 0; $i <= $strlen; $i++ ) {
					$char = substr( $total, $i, 1 );
					if($char == ''){
						
					}else{
						echo '<span>'.$char.'</span>';
						
					}
					
					// $char contains the current character, so do your processing here
				}

		  echo '</h2><h2 class="na_script">Scratch and Win Winners</h2>';
		   
		}else{
			return '';
		}		
    }
	
	    //+++++++++++++++++++++++++++
	//SHOW SCRATCH WINNER COUNT
	//++++++++++++++++++++++++++
    public function show_review_count()
    {
        //GET NA COUNT DETAILS			
		$query = $this->db->query("SELECT COUNT(*) as total from u_business_vote");
		if($query->result()){
		   
		   echo '<h2 class="total-na-counter">';

				$row = $query->row();
				$total = $row->total;
			
				$strlen = strlen( trim($total) );
				for( $i = 0; $i <= $strlen; $i++ ) {
					$char = substr( $total, $i, 1 );
					if($char == ''){
						
					}else{
						echo '<span>'.$char.'</span>';
						
					}
					
					// $char contains the current character, so do your processing here
				}

		  echo '</h2><h2 class="na_script">Business Reviews Made</h2>';
		   
		}else{
			return '';
		}		
    }
	//+++++++++++++++++++++++++++
	//IS THE DEAL CLAIMED?
	//++++++++++++++++++++++++++
    public function count_claims($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('deal_id',$id);
		$query = $this->db->get('u_special_claims');
		if($query->result()){
		    return $query->num_rows;	
		}else{
			return 0;
		}		
    }
	//+++++++++++++++++++++++++++
	//IS THE DEAL CLAIMED?
	//++++++++++++++++++++++++++
    public function is_deal_claimed($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('deal_id',$id);
		$query = $this->db->where('client_id',$this->session->userdata('id'));
		$query = $this->db->get('u_special_claims');
		if($query->result()){
		    return TRUE;	
		}else{
			return FALSE;
		}		
    }
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET RANDOM ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_advert($query = ''){
		
 
        $this->load->model('image_model'); 
        $this->load->library('thumborp');

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 307;
        $height = 440;

		$x = 3;
		$query = $this->db->query("SELECT * FROM adverts WHERE IS_ACTIVE = 'Y' AND TYPE = 'P' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 6", false);

		if($query->result()){ 

			$count = 0;

			foreach($query->result() as $row){
				
					
				$img_str= 'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;
                $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');
					
				
				if($row->URL == ''){
					
					$link1 = '';
					$link2 = '';
					
				}else{
					
					$link1 = '<a href="'.site_url('/').'adverts/track/'.$row->ID.'/'.rand(99999, 99999999).'/" target="_blank">';
					$link2 = '</a>';

				}


				echo    '<div class="row" style="margin-bottom:40px">
    					    <div class="col-md-12">
    							'.$link1.'<img class="lazy" style="width:100%" alt="'.strip_tags($row->ADVERTS_HEADER).'" src="'.$img_url.'" />'.$link2.'
    					    </div>
					    </div>
				        ';

				$count ++;

			}

			$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";

		 }else{
		
		 }
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET RANDOM ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_trade_advert($main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $limit = 1){
		
		$result = array();
		if($sub_sub_sub_cat_id != 0){
			//echo "SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%[".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT 1" ;
			//$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID = '0' AND SUB_SUB_SUB_CAT_ID LIKE '%[".'"'.$sub_sub_sub_cat_id.'"'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 1" ,FALSE);
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%[".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT ".$limit."" ,FALSE);
			
		}elseif($sub_sub_cat_id != 0){
			//echo "SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT 1";
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
			
		}elseif($sub_cat_id != 0){	
			//echo 'Sub Cat Advert'.$main_cat_id.' - '. $sub_cat_id .' - '.$sub_sub_cat_id .' - '.$sub_sub_sub_cat_id .'<br />';
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND (MAIN_CAT_ID = '".$main_cat_id."' OR SUB_CAT_ID LIKE '%".'"'.$sub_cat_id.'"%'."') AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
		
		}elseif($main_cat_id != 0){
			//echo '1 Top Level Advert'.$main_cat_id.' - '. $sub_cat_id .' - '.$sub_sub_cat_id .' - '.$sub_sub_sub_cat_id ;
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID = '".$main_cat_id."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
			
		}else{
			//echo '2 Top Level Advert'.$main_cat_id.' - '. $sub_cat_id .' - '.$sub_sub_cat_id .' - '.$sub_sub_sub_cat_id ;
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID != '0' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
			
		}
	    $x = 0;
        //echo $this->db->last_query();
		if($query->result()){

            foreach($query->result() as $row){

                $result[$x] = $this->load_adverts($row);
                $x ++;
            }



		}else{
			 
			//echo '<br />No Advert -> Fallback to Top Level';
		 	
			$query2 = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID != '0' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT ".$limit."" ,FALSE);

			if($query2->result()){


                foreach($query2->result() as $row){

                    $result[$x] = $this->load_adverts($row);
                    $x ++;
                }


			}
				
			
		}
        $result['count'] = $x;
        //echo $this->db->last_query();

		return $result;
	}	
	
	
	

	//++++++++++++++++++++++++++++++
	//Process ADVERT
	//++++++++++++++++++++++++++++++
	public function load_adverts($row)
	{

		$result = '';	
				
        if($row->ADVERTS_IMAGE_NAME == ''){

            $img = base_url('/').'img/user_blank.jpg';

        }else{

            $img = base_url('/').'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;

        }

        if($row->URL == ''){

            $link1 = '';
            $link2 = '';

        }else{

            $link1 = '<a href="'.site_url('/').'adverts/track/'.$row->ID.'/'.rand(99999, 99999999).'/" target="_blank">';
            $link2 = '</a>';

        }

        $result =  '<div class="white_box">'.$link1.'<img class="lazy" style="width:100%" alt="'.strip_tags($row->ADVERTS_HEADER).'" src="'.$img.'" />'.$link2.'</div>';
	
		return $result;
		
	}
	

	//++++++++++++++++++++++++++++++
	//Instant Search 
	//++++++++++++++++++++++++++++++
	public function instant_search($key , $limit = 10)
	{

        $this->load->model('image_model'); 

        $this->load->library('thumborp');
        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 300;
        $height = 300;
		
		if($limit == 100){
			$key = rawurldecode($key);

		}else{

			$key = preg_replace('/[^a-z0-9\.]/i', '', $this->db->escape_like_str(rawurldecode($key)));
		}

		
		if($this->input->get('location') != 'national'){
			$locationSQL = " AND location = '".$this->input->get('location')."' ";	
		}
		$strSQL = '';
		if($this->input->get('sub_cat_id') != 0){
			$strSQL = " sub_cat_id = '".$this->input->get('sub_cat_id')."' ";	
		}
		
		if($this->input->get('main_cat_id') != 0){
			if($strSQL == ''){
				
				$strSQL = " main_cat_id = '".$this->input->get('main_cat_id')."' AND ";	
			}else{
				$strSQL = $strSQL. " AND main_cat_id = '".$this->input->get('main_cat_id')."' AND ";		
			}
			
		}
		
		$query = $this->db->query("SELECT title ,link, type, img_file ,body FROM search_index WHERE " . $strSQL . " title LIKE '%" . $key . "%' OR body LIKE '%" . $key . "%' ORDER BY title ASC LIMIT " . $limit . "", false);
	
		if($query){ 

			foreach($query->result() as $row){
				$wordsArray = array();
				$markedWords = array();
                $key1 = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $key);
                $body = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $row->body);

				$wordsArray = explode(' ', $key1);
                $bodyArray = explode(' ', $body);
				foreach ($wordsArray as $k => $word) {
				  $markedWords[$k]='<strong class="yellow">'.strtolower($word).'</strong>';
				}

				$text = str_ireplace($wordsArray, $markedWords, $body);
				
                $img_str = $row->img_file;
                $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                echo '
                <section class="results-item">
                    <div>
                        <figure>
                            <a href="'.site_url('/').$row->link.'"><img class="rounded" src="'.$img_url.'" alt="'.$row->title.'"></a>
                        </figure>
                    </div>
                    <div>
                        <h2><a href="'.site_url('/').$row->link.'/">'.$row->title.'</a></h2>
                        <p class="desc">'.$this->shorten_string($text, 40).'</p>
                        <p><span class="badge badge-secondary">'.ucwords(str_replace("_"," ",$row->type)).'</span></p>
                        <a class="btn btn-dark btn-sm" href="'.site_url('/').$row->link.'/" style="margin-bottom:5px" rel="tooltip" title="View: '.$row->title.'"><i class="fa fa-info text-light"></i>  View '.ucwords(str_replace("_"," ",$row->type)).'</a>
                    </div>
                </section>
                ';

			}		
		}
	}
	

	//++++++++++++++++++++++++++++++
	//Instant Search 
	//++++++++++++++++++++++++++++++
    public function instant_search_json($type,$mid,$sid,$query)
    { 

        $this->load->model('image_model'); 

        $this->load->library('thumborp');
        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 20;
        $height = 20;

        if($type != 'all') {

            if($type == 'business') { $s_type = 'business'; }

            if($type == 'vehicle') { $s_type = 'product'; $mid = '348'; }

            if($type == 'property') { $s_type = 'product'; $mid = '3408'; }

            if($type == 'for-sale') { $s_type = 'product'; $mid = '3409'; }

            if($type == 'to-rent') { $s_type = 'product'; $mid = '3410'; }

            if($type == 'car') { $s_type = 'product'; $mid = '3410'; }

            if($type == 'boat') { $s_type = 'product'; $mid = '3410'; }

            if($type == 'bike') { $s_type = 'product'; $mid = '3410'; }

            //if($type == 'auction') { $s_type = 'product'; }

            if($type == 'classified') { $s_type = 'classified'; }



            $strType = " type = '".$s_type."' AND ";

        } else {

            $strType = "";

        }

        $out = array();
        
        if($str = $query){

                    /*if($this->input->get('location') != 'national'){
                        $locationSQL = " AND location = '".$this->input->get('location')."' ";  
                    }*/
                    $strSQL = '';
                    if($sid != 0){
                        $strSQL = " sub_cat_id = '".$sid."' ";   
                    }
                    
                    if($sid != 0){
                        if($strSQL == ''){
                            
                            $strSQL = " main_cat_id = '".$mid."' AND "; 
                        }else{
                            $strSQL = $strSQL. " AND main_cat_id = '".$mid."' AND ";        
                        }
                        
                    }

                    $key = $this->db->escape_like_str(urldecode($str));

                    //INSERT TERM FOR CAPTURE
                    if(strlen($key) > 15){

                        if(str_word_count($key) > 1) {
                            $idata = array(

                                'client_id' => $this->session->userdata('id'),
                                'search_term' => $key,
                                'tokens' => '',
                                'location' => $this->session->userdata('country')

                            );
                            $this->db->insert('search_terms', $idata);
                        }
                    }
 
                    //MORE THAN 1 WORD
                    if(str_word_count($key) > 1){

                        $keys = str_replace(" ", "+", trim($key));
                        $keyA = explode("+", $keys);
                        $keyF = '';
                        foreach($keyA as $r){
                            if(strlen($r) >= 3){
                                $keyF .= '+'.$r.' ';
                            }
                        }

                        $tq1 = "SELECT title ,link, type, img_file ,body,
                                MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance,
                                MATCH(title) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance2
                                FROM search_index
                                WHERE ".$strType." MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE) 
                                ORDER BY relevance2 DESC, relevance DESC LIMIT 8";
                        //echo $tq1;
                        $query = $this->db->query($tq1, FALSE);
                        $go = true;


                        //BIGGER THAN 3 CHARS
                    }elseif(str_word_count($key) == 1 && strlen($key) > 3){
                        $tq1 = "SELECT title ,link, type, img_file ,body FROM search_index WHERE ".$strType." ".$strSQL." body LIKE '%".$key."%' OR title LIKE '%".$key."%' ORDER BY title ASC LIMIT 8";
                        $query = $this->db->query($tq1, FALSE);
                        $go = true;
                        //BIGGER THAN 2 CHARS
                    }elseif(strlen($key) > 2){
                        $tq1 = "SELECT title ,link, type, img_file ,body FROM search_index WHERE ".$strType." ".$strSQL." body LIKE '%".$key."%' OR title LIKE '%".$key."%' ORDER BY title ASC LIMIT 8";
                        $query = $this->db->query($tq1, FALSE);
                        $go = true;
                    }else{
                        $tq1 = '';
                        $query = false;
                        $go = false;
                    }
                                       

                    $x = 1;
                    if($go) {
                        if ($query->result()) {

                            foreach ($query->result() as $row) {

                            $img_str = 'assets/products/images/' . $row->img_file;

                            $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');


                                $name = $row->title;
                                $body = $this->shorten_string(strip_tags(str_replace($name, " ", $row->body)), 7);
                                $array = explode(" ", $name . " " . $body);
                                $temp = implode('","', $array);
                                //$link1 = "<a href='".site_url('/').$row->link.'">';
                                $t = array(

                                    "year" => $x,
                                    "type" => $type,
                                    "body" => $body,
                                    "link1" => "javascript:go_url('" . site_url('/') . $row->link . "')",
                                    "value" => $name,
                                    "tokens" => $array

                                );
                                array_push($out, $t);

                                $x++;
                            }

                        }
                    }

        
            if($query){
                //var_dump($arr);
                //echo json_encode($arr);
                //echo json_encode($out);
            }

            echo json_encode($out);
            
            $this->output->set_content_type('application/json');
        }
    }
		

	//+++++++++++++++++++++++++++
	//BUILD CAPTCHA
	//++++++++++++++++++++++++++
	function build_captcha(){
		
		$this->load->library('recaptcha');
		if (empty($_SERVER['HTTPS'])) {
			
			echo $this->recaptcha->recaptcha_get_html($error = null, FALSE);	
			
		}else{
			
			echo $this->recaptcha->recaptcha_get_html($error = null, TRUE);	
			
		}
		
		

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//PREFETCH TYEHEAD
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function load_typehead($type, $cat){


        $this->load->model('image_model'); 
        $this->load->library('thumborp');

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 20;
        $height = 20;


        $str = array();
        if($type == 'location'){

            $test = $this->db->get('a_map_location');

            $x = 1;
            //$str .= '[';
            if($test->result()){

                foreach($test->result() as $row){


                    $img_str = 'assets/images/map_marker.png';
                    $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                    $name =  $row->MAP_LOCATION;
                    $array = explode(" ",$name);
                    $temp = implode('","' , $array);
                    $t = array(

                        "year" => $x,
                        "image" => '',
                        "type" => "City",
                        "body" => $name,
                        "link1" => "javascript:void(0)",
                        "value" => $name,
                        "tokens" => $array

                    );
                    array_push($str, $t);

                    $x ++;
                }

            }
        }elseif($type == 'business'){

            $test2 = $this->db->where('ISACTIVE', 'Y');
            $test2 = $this->db->get('u_business');
            $x2 = 1;
            if($test2->result()){

                foreach($test2->result() as $row2){

                    $name2 =  $row2->BUSINESS_NAME;
                    $array2 = explode(" ",$name2);
                    $temp2 = implode('","' , $array2);
                    $link = site_url('/').'b/'.$row2->ID;
                    $img = $row2->BUSINESS_LOGO_IMAGE_NAME;
                    //Build image string
                    $format = substr($img,(strlen($img) - 4),4);
                    $strT = substr($img,0,(strlen($img) - 4));

                    if($img != ''){

                        if(strpos($img,'.') == 0){

                            $format = '.jpg';
                            $img_str = 'assets/business/photos/'.$img . $format;
                            $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');


                        }else{

                            $img_str = 'assets/business/photos/'.$img;
                            $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                        }

                    }else{

                        $img_str = 'assets/business/photos/logo-placeholder.jpg';
                        $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                    }


                    $t = array(

                        "year" => $x2,
                        "image" => '',
                        "type" => "Business",
                        "body" => $name2,
                        "link1" => "javascript:go_url('".$link."')",
                        "value" => $name2,
                        "tokens" => $array2

                    );
                    array_push($str, $t);

                    $x2 ++;
                }

            }


        }elseif($type == 'category'){

            //$test2 = $this->db->where('type', 'business_location');
            $test2 = $this->db->get('a_tourism_category');
            $x2 = 1;
            if($test2->result()){

                foreach($test2->result() as $row2){


                    $img_str = 'assets/images/map_marker.png';
                    $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');


                    $name2 =  trim(preg_replace("/[^a-z0-9.]+/i", " ", $row2->CATEGORY_NAME));
                    $array2 = explode(" ",$name2);
                    $temp2 = implode('","' , $array2);
                    $t = array(

                        "year" => $x2,
                        "image" => '',
                        "type" => "Category",
                        "body" => $name2,
                        "link1" => "javascript:go_url('".site_url('/').$row2->link."')",
                        "value" => $name2,
                        "tokens" => $array2

                    );
                    array_push($str, $t);

                    $x2 ++;
                }

            }


        }elseif($type == 'business_location'){

            $test2 = $this->db->where('type', 'business_location');
            $test2 = $this->db->get('search_index');
            $x = 1;
            if($test2->result()){

                foreach($test2->result() as $row2){

                    $img_str = 'assets/images/map_marker.png';
                    $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                    $name2 =  trim(preg_replace("/[^a-z0-9.]+/i", " ", $row2->title));
                    $array2 = explode(" ",$name2);
                    $temp2 = implode('","' , $array2);

                    $t = array(

                        "year" => $x,
                        "image" => '',
                        "type" => "Business Location",
                        "body" => $name2,
                        "link1" => "javascript:void(0)",
                        "value" => $name2,
                        "tokens" => $array2

                    );
                    array_push($str, $t);


                    $x ++;
                }

            }

        }


        echo json_encode($str);

		$this->output->set_content_type('application/json');
			  
    }

    //++++++++++++++++++++++++++++++
    //PREFETCH USER TYPEHEAD
    //++++++++++++++++++++++++++++++
    public function typehead_users()
    {

        $this->load->model('image_model'); 
        $this->load->library('thumborp');


        $test2 = $this->db->where('client_id', $this->session->userdata('id'));
        $test2 = $this->db->distinct();
        $test2 = $this->db->group_by('search_term');
        $test2 = $this->db->order_by('created_at', 'DESC');
        $test2 = $this->db->limit(3);
        $test2 = $this->db->get('search_terms');
        $x = 1;
        $str = array();
        if($test2->result()){

            foreach($test2->result() as $row2){

                $name2 =  trim( $row2->search_term);
                $array2 = explode(" ",$name2);
                $temp2 = implode('","' , $array2);

                $t = array(

                    "year" => $x,
                    "image" => '',
                    "type" => "Business Location",
                    "body" => $name2,
                    "link1" => "javascript:void(0)",
                    "value" => $name2,
                    "tokens" => $array2

                );
                array_push($str, $t);


                $x ++;
            }

        }


        echo json_encode($str);

        $this->output->set_content_type('application/json');

    }

//Shorten Price
    function smooth_price($price)
    {

        if (strpos($price, '.00'))
        {

            $price = str_replace('.00', '', $price);
        }

        if (strlen(trim($price)) > 8)
        {

            //$price = number_format($price, 2, ',', ' ');
            $price1 = number_format($price, 2);

        }
        elseif (strlen($price) > 7)
        {

            $price1 = number_format($price, 2);

        }
        elseif (strlen($price) > 6)
        {

            $price1 = number_format($price, 2);

        }
        elseif (strlen($price) > 5)
        {

            $price1 = number_format($price, 2);

        }
        elseif (strlen($price) > 3)
        {

            $price1 = number_format($price, 2);

        }
        else
        {

            $price1 = number_format($price, 2);
        }

        return $price1;
    }


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CACHE FEED FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function cacheObject($url,$name,$age = 86400)
    { 
        // directory in which to store cached files
        $cacheDir = BASE_URL."cache/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
          $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {
		  
		    if ( copy($url, $filename) ) {
				 // update timestamp to now
         		 touch($filename);
			}else{
				echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
			}
         
        }
        // return the cache filename
        return $filename;
    } 

	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
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
	
}
?>