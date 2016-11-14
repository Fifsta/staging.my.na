<?php
class Product_model extends CI_Model{
	
 	function product_model(){
  		//parent::CI_model();
			
 	}

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+ADD NEW ITEM
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function add_product($data){

        //DATA
		$insertdata = array(
			'bus_id'             => $data['bus_id'],
			'is_active'          => 'N',
			'title'              => $data['title'],
			'description'        => $data['body'],
			'sale_price'         => $data['sale_price'],
			'por'                => 'N',
			'start_price'        => 0,
			'reserve'            => 0,
			'start_date'         => $data['start'],
			'listing_type'       => 'S',
			'location'           => $data['location'],
			'suburb'             => $data['suburb'],
			'quantity'           => $data['quantity'],
			'main_cat_id'        => $data['cat1'],
			'sub_cat_id'         => $data['cat2'],
			'sub_sub_cat_id'     => $data['cat3'],
			'sub_sub_sub_cat_id' => $data['cat4']
		);
		$insertdata['client_id'] = $data['client_id'];
		$insertdata['total_quantity'] = $data['quantity'];
		$bus_id = $data['bus_id'];
		//EXPIRY DATES auction none; sale = 30 days 1 month
		if ($bus_id == '2666' || $bus_id == '8785' || $bus_id == '2706')
		{
			//YEARLY EXPIRY
			$insertdata['end_date'] = date('Y-m-d', strtotime("+360 days"));

		}
		elseif ($bus_id != 0)
		{

			$insertdata['end_date'] = date('Y-m-d', strtotime("+91 days"));
		}
		else
		{
			$insertdata['status'] = 'moderate';
			$insertdata['end_date'] = date('Y-m-d', strtotime("+31 days"));
		}
		


		//INSERT
		$this->db->insert('products', $insertdata);
		if($o['product_id'] = $this->db->insert_id()){
					//PRODUXCT EXTRA DATA
			$extradata = array(
				'product_id'     => $o['product_id'],
				'property_agent' => $data['client_id']
	
			);
			$this->db->insert('product_extras', $extradata);
			$o['success'] = true;
			
			
		}else{
			
			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}

		return $o;

    }


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET PRODUCT CATEGORIES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_categories($data){


		if($data['sub_sub_sub_cat_id']){

			$this->db->where('sub_sub_sub_cat_id', $data['sub_sub_sub_cat_id']);


		}elseif($data['sub_sub_cat_id']){

			$this->db->where('sub_sub_cat_id', $data['sub_sub_cat_id']);
			$this->db->where('sub_sub_sub_cat_id', 0);


		}elseif($data['sub_cat_id']){

			$this->db->where('sub_cat_id', $data['sub_cat_id']);
			$this->db->where('sub_sub_cat_id', 0);
			$this->db->where('sub_sub_sub_cat_id', 0);

		}elseif($data['main_cat_id']){

			$this->db->where('main_cat_id', $data['main_cat_id']);
			$this->db->where('sub_cat_id', 0);
			$this->db->where('sub_sub_cat_id', 0);
			$this->db->where('sub_sub_sub_cat_id', 0);
		}

		//GET
		$q = $this->db->get('product_categories');
		if($q->result()){

			$o['categories'] = $q->result();


		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}

		return $o;

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND PRODUCT LINK AFTER LISTING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function send_user_product_link($product_id){

		
		//GET
		$q = $this->db->query("SELECT products.*,u_client.*, product_images.img_file  FROM products
								JOIN u_client ON products.client_id = u_client.ID
								LEFT JOIN product_extras on products.product_id = product_extras.product_id
								LEFT JOIN product_images on products.product_id = product_images.product_id
								WHERE products.product_id = ".$product_id."");
		if($q->result()){

			$row = $q->row();
			$image = '';
			$out_img = '';
			if(strlen($row->img_file) > 1){
				
				$image = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/products/images/'.$row->img_file.'&w=580&h=300';
				$image = '<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
										 <tr>
											<td style="width:100%" class="white_box"><img src="'. $image.'" alt="download picture sto view"></td>
										 </tr>
						  </table><br />';
				$out_img = '<img src="'. $image.'" alt="download picture sto view" style="max-width:250px" class="img-responsive pull-right">';
	
			}
			$emailTO =  array(array('email' => $row->CLIENT_EMAIL) , array('email' => 'info@my.na'));
			$emailFROM = 'no-reply@my.na';
			$name = 'My Namibia Trade';
			$subject = 'Your Listing - '.$this->trade_model->shorten_string($row->title, 4);
			$body = 'Hi '.$row->CLIENT_NAME.', <br /><br />
								Your classified listing '.$row->title.' on My Namibia &trade; is live. Please review it online, add further detail
								and upload some images. Items that have images sell better.
								<br /><br />
								<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">I am Online</h1>
								'.$image.'
								<br />
								<strong>'.$row->title.'</strong>
								<p>'.$row->description.'</p>
								<br />
								Manage your Listing <a href="'.site_url('/').'sell/update_product/'.$row->product_id.'/"> here</a>
								or visit your <a href="'.site_url('/').'sell/update_product/'.$row->product_id.'/">Classifieds dashboard here</a> 
								to manage, list and sell anything in Namibia.<br /><br />
								
								Have a !tna day!<br />
								My Namibia';
			$data_view['body'] = $body;
			$body_final = $this->load->view('email/body_news',$data_view,true);
			$TAGS = array('tags' => 'product_listing_upgrade');
			$this->load->model('email_model');
			$this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);

			$o['title'] = $row->title;
			$o['body'] = $row->body;
			$o['word_count'] = str_word_count($row->body);
			$o['images'] = $row->img_file;
			$o['success'] = true;
			$o['msg'] = 'Email Sent!';
			$o['html'] = $out_img.'<strong>'.$row->title.'</strong><br /><p>'.$row->body.'</p><ul><li><strong>Words:</strong> '.$o['word_count'] .'</li></ul><p><strong>Please proceed to counter for Payment</strong></p>';
		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}

		return $o;

	}


 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+ADD NEW ITEM
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function add_image($data){

        //DATA
		$insertdata = array(
			'img_file'             => $data['bus_id'],
			'product_id'          => $data['product_id'],
			'sequence'              => $data['sequence'],
			
		);
		
		//INSERT
		$this->db->insert('product_images', $insertdata);
		if($o['img_id'] = $this->db->insert_id()){
					
			$o['success'] = true;
			
			
		}else{
			
			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}

		return $o;

    }
	//+++++++++++++++++++++++
	//DELETE PRODUCT AND IMAGES
	//+++++++++++++++++++++++
	function delete_product($id)
	{

		$this->db->where('product_id' , $id);
		$product = $this->db->get('products');
	
		//IF exists
		if($product->result()){
	
			$rowP = $product->row();
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
					
					$o['msg'] = 'Product deleted, along with '.$count.' images and extras.';
						
				}else{
					
					$o['msg'] = 'Product deleted, along with '.$count.' images and extras.';
					
	
				}
				$o['success'] = true;
			}
	
	
		}else{
			$o['success'] = false;
			$o['msg'] = 'Product doesnt exist!';
	
		}
		
		return $o;
	}
	//+++++++++++++++++++++++
	//DELETE PRODUCT IMAGES
	//+++++++++++++++++++++++
	function delete_product_image($id)
	{

		$this->db->where('img_id' , $id);
		$product = $this->db->get('product_images');
	
		//IF exists
		if($product->result()){
	
			$rowP = $product->row();
			$count = 0;
	
			foreach($product->result() as $row){

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
		
	
		}else{
			$o['success'] = false;
			$o['msg'] = 'Product image doesnt exist!';
	
		}
		
		return $o;
	}
	
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = '', $offset = 0, $title = '', $amt = '', $advert = true, $pages = '', $limit = 4)
	{

		if ($query == '')
		{	
			$this->load->database();
			//$query = $this->db->query("SELECT * FROM products WHERE is_active = 'Y' ORDER BY listing_date DESC" ,FALSE);
			$query = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        MAX(product_auction_bids.amount) as current_bid,products_buy_now.amount,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        LEFT JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN products_buy_now ON products_buy_now.product_id = products.product_id
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        WHERE products.is_active = 'Y' AND products.status = 'live'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT ".$limit." OFFSET ".$offset, true);

			//$query = $this->db->query("SELECT AVG(RATING)as TOTAL FROM u_business_vote WHERE PRODUCT_ID ='".$id."' AND IS_ACTIVE = 'Y' AND TYPE = 'review' ORDER BY TOTAL ");

		}
		else
		{
			$query = $query;
		}

		$span = $amt - 1;
		if ($amt == '')
		{
			$span = '3';
			$amt = 3;
		}
		if ($query->result())
		{

			$sorting = '';

			$current = $query->num_rows();
			$count = '<strong>' . $offset . ' - ' . ($offset + $query->num_rows()) . '</strong> Results shown of <strong>' . (int) $count . '</strong>';

			if ($advert)
			{
				$priceD = '';
				if (strstr(current_url('/'), '/priceD'))
				{
					$priceD = ' active';
				}
				$priceA = '';
				if (strstr(current_url('/'), '/priceA'))
				{
					$priceA = ' active';
				}
				$sorting = '<div class="row-fluid">
								<div class="span8">	
									<h2 class="upper na_script">' . $title . '</h2>
								</div>
								 
								<div class="span4 text-right">
								 <div class="btn-group text-left">
									<button class="btn btn-inverse"><i class="icon-resize-vertical icon-white"></i> Sort By</button>
									<button class="btn btn-inverse dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
									<ul class="dropdown-menu pull-right">
									  <li><a href="' . site_url('/') . 'trade/sortby/price/priceD/?url=' . $this->uri->uri_string() . '/?' . urlencode(json_encode($this->input->get())) . '" class=" ' . $priceD . '"><i class="icon-arrow-up"></i> Highest Price First</a></li>
									  <li><a href="' . site_url('/') . 'trade/sortby/price/priceA/?url=' . $this->uri->uri_string() . '/?' . urlencode(json_encode($this->input->get())) . '" class="' . $priceA . '"><i class="icon-arrow-down"></i> Lowest Price First</a></li>
									  <li class="divider"></li>
									  
									</ul>
								  </div>
								
								
								<p>' . $count . '</p>
								</div>
							</div>';

				//$advert = $this->my_na_model->show_trade_advert($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, 10);

			}
			else
			{

				$advert = '';

			}
			$flikstr = '{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }';
			$output = $sorting . '<div class="row item-list swipe js-flickity" data-flickity-options='."'".$flikstr."'".'>';
			$x2 = 0;

			// var_dump($advert);
			foreach ($query->result() as $row)
			{
				//var_dump($row);
				//get images

				//$images = $this->db->query("SELECT * FROM product_images WHERE product_id = '".$row->product_id."' ORDER BY sequence ASC LIMIT 5");
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
							$lazy = 'lazyload';
							$img_str = CDN_URL . 'assets/products/images/' . $imgR;
							$img[$xx] = '<img class="' . $lazy . ' vignette" src="' . base_url('/') . 'img/deal_place_load.gif" alt="' . strip_tags($row->title) . '" data-src="' .
								CDN_URL . 'img/timbthumb.php?src=' . CDN_URL . 'assets/products/images/' . $imgR . '&w=360&h=230"/>';
						}
						else
						{

							$at = '<img alt="' . strip_tags($row->title) . '" src="' .
								CDN_URL . 'img/timbthumb.php?src=' . CDN_URL. 'assets/products/images/' . $imgR . '&w=360&h=230"/>';
							array_push($imgAa, $at);

						}
						/*$img[$xx] = '<li><img class="'.$lazy.' vignette" src="'.base_url('/').'img/deal_place_load.gif" alt="'.strip_tags($row->title).'" data-original="'.
										base_url('/').'img/timbthumb.php?src='. base_url('/').'assets/products/images/'.$imgR.'&w=340&h=200"/></li>';*/


						$xx++;
					}

					$img_Cycle = '<script id="images_' . $row->product_id . '" type="text/cycle">
								' . json_encode($imgAa) . '
						 </script>';

				}
				else
				{

					$img[0] = '<img class="lazyload" src="' . CDN_URL . 'img/deal_place_load.gif" alt="' . strip_tags($row->title) . '" data-src="' .
						base_url('/') . 'img/timbthumb.php?src=' .CDN_URL. 'img/product_blank.jpg&w=360&h=230" />';
					$img_str = base_url('/') . 'img/product_blank.jpg';
				}

				//CHECK IF AGENCY PROPERTY LISTING
				$b_logo = '';
				if ($row->IS_ESTATE_AGENT == 'Y')
				{

					if (trim($row->BUSINESS_LOGO_IMAGE_NAME) != '')
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . base_url('/') . 'img/timbthumb.php?w=50&h=50&src=' . CDN_URL . 'assets/business/photos/' . $row->BUSINESS_LOGO_IMAGE_NAME . '" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
					}
					else
					{
						$b_logo = '<img title="Product is listed by ' . $row->BUSINESS_NAME . '" rel="tooltip" style="margin-top:-70px;z-index:1;position:relative" src="' . base_url('/') . 'img/timbthumb.php?w=50&h=50&src=' . CDN_URL . 'img/bus_blank.jpg" alt="' . $row->BUSINESS_NAME . '" class="img-polaroid pull-right" />';
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

					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">' . $btn_txt . '</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';

					if ($row->sub_cat_id == 3410)
					{
						$price = '<span style=" font-size:18px">N$</span> ' . $this->smooth_price($row->sale_price) . ' pm';
					}
					else
					{
						$price = '<span style=" font-size:18px">N$</span> ' . $this->smooth_price($row->sale_price);
					}
					if ($row->por == 'Y')
					{

						$price = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

					}
					//Auction	
				}
				elseif ($row->listing_type == 'A')
				{

					//$price = '<span style=" font-size:18px">N$</span> '.$this->smooth_price($row->sale_price);
					$price = $this->get_current_bid($row->current_bid);

					if ($price['str'] != 'No Bids')
					{
						$price = '<span style=" font-size:10px">BID</span> ' . $price['str'];

					}
					else
					{
						$price = $price['str'];
					}

					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">Place Bid</a>&nbsp;
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
						$price = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->my_model->smooth_price($row->sale_price) . '</span> pm';
					}
					else
					{
						$price = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->my_model->smooth_price($row->sale_price) . '</span>';
					}
					if ($row->por == 'Y')
					{

						$price = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

					}

					$btn_txt = 'Order Now';


					$type_btn = '<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-inverse pull-right">' . $btn_txt . '</a>&nbsp;
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '/" class="btn btn-warning pull-right" style="margin-right:5px">View</a>';
				}

				$private = '';
				if ($row->bus_id == 0)
				{

					$private = '<span class="private" rel="tooltip" title="This item is listed Privately"><i class="icon-star"></i></span>';

				}

				$fb = "postToFeed(" . $row->product_id . ", '" . ucwords(trim($this->my_model->clean_url_str($row->title, " ", " "))) . "','" . trim($img_str) . "', '" . ucwords(trim($this->my_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_model->shorten_string(strip_tags($this->my_model->clean_url_str($row->description, " ", " ")), 50)))) . "', '" . site_url('/') . 'product/' . $row->product_id . '/' . trim($this->my_model->clean_url_str($row->title)) . "')";


				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
				$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->my_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';


				//LOCATION
				$location = '';
				if ($row->location != '')
				{

					$location = '<span  itemprop="address">' . $row->location . '</span>';

					if ($row->suburb != 0 && $row->suburb != '')
					{
						$location = '<span  itemprop="address" >' . $row->location . ' / ' . $row->suburb . '</span>';
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


				/*$ribbon = $this->trade_model->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');*/
				
				$output .= '<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Properties</a></p>
								<a href="' . site_url('/') . 'product/' . $row->product_id . '/' . $this->my_model->clean_url_str($row->title) . '" class="cycle-slideshow cycle-paused" data-cycle-speed="500" data-cycle-timeout="500" data-cycle-progressive="#images_' . $row->product_id . '">
									' . implode($img) . '
								</a>
								
								<div class="more">
									<p class="price">' . $price . '</p>
									<p class="social">
										<a onClick="'.$fb.'" data-icon="fa-facebook"></a>
										<a href="'.$tweet_url.'" target="_blank" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">' . ucwords(strtolower($this->my_model->shorten_string($row->title, 6))) . '</a></h2>
								<p class="date">Listed: '.$this->my_model->time_passed(strtotime($row->listing_date)).'</p>
								<div class="details">
									'.$this->get_extras($row->extras).' 
									<p>'. ucwords(strtolower($this->my_model->shorten_string(strip_tags($row->description), 6))) . '</p>
								</div>
							</div>
						</article>';
				$x2++;


			}
			$output .= '</div>';

		}
		else
		{


			
		}
		return $output;

	}
	
	//+++++++++++++++++++++++++++
	//RENDER PRODUCT EXTRAS
	//++++++++++++++++++++++++++
	function get_extras($extras, $limit = 4){

		$extras = json_decode($extras, true);

		//var_dump($extras);
		$x = 0;
		$o = '';
		if ($extras != null)
		{
			unset($extras['bus_id']);unset($extras['product_id']);unset($extras['agency']);
			unset($extras['prop_lat']);unset($extras['prop_lon']);unset($extras['toggle_map']);
			$extras = array_filter($extras);
			$o .= '';
			foreach ($extras as $row => $value)
			{
				if(!is_array($value)){

					if($x < $limit ){
						$o .= '<p><span>'.ucwords(str_replace('_',' ',$row)).'</span>
							<strong>'.ucwords($value).'</strong></p>';
						$x ++;
					}

				}


			}
			if(isset($extras['features'])){
				foreach ($extras['features'] as $row => $value)
				{
					if($x < $limit ){
						$o .= '<p><span>'.ucwords(str_replace('_',' ',$row)).'</span>
							<strong>'.ucwords($value).'</strong></p>';
						$x ++;
					}
				}
			}

			if(isset($extras['autohaus'])){
				foreach ($extras['autohaus'] as $row => $value)
				{
					if($x < $limit ){
						$o .= '<p><span>'.ucwords(str_replace('_',' ',$row)).'</span>
							<strong>'.ucwords($value).'</strong></p>';
						$x ++;
					}
				}
			}

			$o .= '';
		}
		return $o;
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET CURRENT BID
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_current_bid($bid)
	{

		if ($bid)
		{


			$data['current'] = $bid;
			$data['price'] = $bid + 5;
			$data['str'] = '<span style=" font-size:18px">N$</span><span itemprop="price"> ' . $this->smooth_price($bid) . '</span>';

			return $data;

		}
		else
		{

			$data['current'] = 0;
			$data['price'] = 5;
			$data['str'] = 'No Bids';

			return $data;

		}

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
	
}
?>