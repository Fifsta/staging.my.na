<?php
class Api_model extends CI_Model{
		
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	//self::__construct();
	
 	function api_model(){
  		//parent::CI_model();
		self::__construct();
 	}


	//+++++++++++++++++++++++++++
	//GET FEATURE SLIDER
	//++++++++++++++++++++++++++
	public function get_featured_slider($bus_id, $url){
		
		$output = '';
		if($bus_id == 0){
			
				//Get FEATURED PRODUCTS
				$main = $this->db->query("SELECT products.*, product_extras.*, product_images.img_file, product_images.sequence  FROM products 
											JOIN product_extras ON products.product_id = product_extras.product_id 
											JOIN product_images ON products.product_id = product_images.product_id
											GROUP BY products.product_id WHERE product.extras.featured = 'Y'
											ORDER BY product_images.sequence ASC											
											  LIMIT 5");
											  
				$link = site_url('/');
		}else{
			
				//Get FEATURED PRODUCTS
				$main = $this->db->query("SELECT products.*, product_extras.*, product_images.img_file, product_images.sequence  FROM products 
											JOIN product_extras ON products.product_id = product_extras.product_id 
											JOIN product_images ON products.product_id = product_images.product_id
											WHERE products.bus_id = '".$bus_id."' AND product_extras.featured = 'Y' 
											GROUP BY products.product_id
											ORDER BY product_images.sequence ASC											
											  LIMIT 5");
				
				//PROPRTY BROKERS
				if($bus_id == 8966){
					
					$link = 'http://whkproperty.com/concept/new/view-property.php';
					
				}else{
					
					$link = site_url('/');
					
				}
		}
		
		if($main->result()){
			$x = 0;
			
			$output .= '<div id="featureCarousel" class="carousel slide">
					<div class="carousel-inner">';
			foreach($main->result() as $row){
				
				$active = '';
				if($x == 0){
					
					$active = 'active';
				}
				
				$fb = "postToFeed(".$row->product_id.", '". $row->title ."', '".$row->title."', '".$row->title ." - My Namibia','".$this->trade_model->shorten_string(strip_tags($row->description), 50)."', '".$this->trade_model->clean_url_str($row->title)."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
			
				$tweet_url = $this->trade_model->clean_url_str($row->title).'&text='.substr(strip_tags($row->title . ' ' . $row->description) ,0, 60).' ' .site_url('/').'product/'.$row->product_id.'&via=MyNamibia';

				if($row->listing_type == 'S'){
					
					if($row->status == 'sold'){
						$price['str'] = ' Sold';
					}else{
						if($row->sub_cat_id == 3410){
							$price['str'] = '<font style=" font-size:12px">N$</font> '.$this->trade_model->smooth_price($row->sale_price). ' pm';
						}else{
							$price['str'] = '<font style=" font-size:12px">N$</font> '.$this->trade_model->smooth_price($row->sale_price);	
						}

					}
					
				}else{
					
					$price = $this->trade_model->get_current_bid($row->product_id);	
					
				}        
				//get REVIEWS
				$rating = $this->trade_model->get_rating($row->product_id);
				
				//onclick="window.top.location = my.na"
				
				
				
				$output .= '<div class="item '.$active.'">
					   <img src="'.prep_url($url).'img/timbthumb.php?src='.base_url('/').'assets/products/images/'.$row->img_file.'&w=960&h=400" />
					   <div class="carousel-caption" style="width:250px;margin-left:600px">
							<h3 style="font-size:20px;line-height:25px;height:25px;overflow:hidden">'.$this->trade_model->shorten_string($row->title, 5).'</h3>
							<h4 style="font-size:17px;height:15px;">'.$price['str'].'</h4>
							<p>'.$this->trade_model->show_extras_short($row->extras).'</p>
							'.$this->trade_model->get_review_stars_show($rating,$row->product_id, rand(1000,9999)).'
							<a href="javascript:void(0)" onclick="'.$tweet_url.'" class="twitter"></a>
							<a href="javascript:void(0)" onclick="'.$fb.'" class="facebook"></a>
							<a target="_top" href="'.$link.'?id='.$row->product_id.'&'.$this->trade_model->clean_url_str($row->title).'/" class="btn btn-inverse pull-right" ><i class="icon-share icon-white"></i> View</a>
					  		<div class="clearfix">&nbsp;</div>
						</div>	
					 </div>';
				
				$x ++;
			}
			
			$output .= '</div>
				  <a class="carousel-control left" href="#featureCarousel" data-slide="prev">&lsaquo;</a>
				  <a class="carousel-control right" href="#featureCarousel" data-slide="next">&rsaquo;</a>
				</div>';
		
		}else{
			
				
			
		}
		return $output;
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
								
	public function get_products($bus_id, $query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = '', $offset = 0, $title = '',$amt = '', $advert = TRUE){
		
		//PROPRTY BROKERS
		if($bus_id == 8966){
			
			$url = 'http://whkproperty.com/concept/new/view-property.php';
			
		}else{
			
			$url = 'http://whkproperty.com/concept/new/view-property.php';
			
		}
		
		if($query == ''){
			//$query = $this->db->query("SELECT * FROM products WHERE is_active = 'Y' ORDER BY listing_date DESC" ,FALSE);
			$query = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE products.bus_id = '".$bus_id."' ORDER BY listing_date DESC LIMIT 30" ,FALSE);
		}else{
			//$query = $this->db->query($query, FALSE);	
		}

		$span = $amt - 1;
		if($amt == ''){
			$span = '3';	
			$amt = 3;	
		}
		if($query->result()){
			$sorting = '';

			$current = $query->num_rows();
			$count = '<strong>'.$offset. ' - '.($offset + $query->num_rows()).'</strong> Results shown of <strong>'.(int)$count.'</strong>';
				
			if($advert){
				$priceD = '';
				if(strstr(current_url('/'), '/priceD')){
					$priceD = ' active';
				}
				$priceA = '';
				if(strstr(current_url('/'), '/priceA')){
					$priceA = ' active';
				}
				$sorting = /*'<div class="row-fluid">
								<div class="span8">	
									<h1>'.$title.'</h1>
								</div>
								<div class="span4 text-right">
								<p><a href="'.site_url('/').'trade/sortby/price/priceD/?url='.$this->uri->uri_string().'/?'.urlencode(json_encode($this->input->get())).'" class="btn btn-inverse '.$priceD.'"><i class="icon-arrow-up icon-white"></i> Highest Price First</a>
								<a href="'.site_url('/').'trade/sortby/price/priceA/?url='.$this->uri->uri_string().'/?'.urlencode(json_encode($this->input->get())).'" class="btn btn-inverse'.$priceA.'"><i class="icon-arrow-down icon-white"></i> Lowest Price First</a></p>
								<p>'.$count.'</p>
								</div>
							</div>'*/'';
				
			}
			echo $sorting .'
				<div class="row-fluid">	  
			 		<div class="thumbnails">
			';
			$x2 = 0;
			foreach($query->result() as $row){
				
				//get images
				$this->db->where('product_id', $row->product_id);
				$this->db->limit('5');
				$this->db->order_by('sequence', 'ASC');
				$images = $this->db->get('product_images');
				$this->db->close();
				//$images = $this->db->query("SELECT * FROM product_images WHERE product_id = '".$row->product_id."' ORDER BY sequence ASC LIMIT 5");
				$xx = 0;
				$img = array();
				if($images->result()){
					foreach($images->result_array() as $imgR){
						$lazy = '';
						if($xx == 0){
							$lazy = 'lazy active';
						}
						$img[$xx] = '<li><img class="'.$lazy.' vignette" src="'.base_url('/').'img/deal_place_load.gif" alt="'.strip_tags($row->title).'" data-original="'.
										base_url('/').'img/timbthumb.php?src='. base_url('/').'assets/products/images/'.$imgR['img_file'].'&w=300&h=200"/></li>';
						$xx ++;
					}

					
				}else{
					
					$img[0] = '<li><img class="lazy vignette active" src="'.base_url('/').'img/deal_place_load.gif" alt="'.strip_tags($row->title).'" data-original="'.
								base_url('/').'img/timbthumb.php?src='.base_url('/').'img/product_blank.jpg&w=300&h=200" /></li>';
				}
				
				//CHECK IF AGENCY PROPERTY LISTING
				$b_logo = '';
/*				if($row->main_cat_id == 3408 && $row->property_agent != 0){
					
					$this->db->select('BUSINESS_NAME, BUSINESS_LOGO_IMAGE_NAME');
					$this->db->where('ID', $row->bus_id);
					$b = $this->db->get('u_business');
					if($b->result()){
						$b_row = $b->row();
						if(trim($b_row->BUSINESS_LOGO_IMAGE_NAME) != ''){
							$b_logo = '<img style="margin-top:-90px;z-index:1;position:relative" src="'.base_url('/').'img/timbthumb.php?w=70&h=70&src='.base_url('/').'assets/business/photos/'.$b_row->BUSINESS_LOGO_IMAGE_NAME.'" alt="'.$b_row->BUSINESS_NAME.'" class="img-polaroid pull-right" />';
						}else{
							$b_logo = '<img style="margin-top:-90px;z-index:1;position:relative" src="'.base_url('/').'img/timbthumb.php?w=70&h=70&src='.base_url('/').'img/bus_blank.jpg" alt="'.$b_row->BUSINESS_NAME.'" class="img-polaroid pull-right" />';
						}							
					}
				}*/
				$btn_txt = 'Buy Now';
				if($row->main_cat_id == 3408){
					
					$btn_txt = 'Enquire Now';
						
				}
				//Check Price
				//Fixed price
				if($row->listing_type == 'S'){
					
					$type_btn = '
								<a href="'.$url.'?id='.$row->product_id.'&'.$this->trade_model->clean_url_str($row->title).'/" class="btn btn-inverse pull-right" style="margin-right:5px">View</a>';
					
					if($row->sub_cat_id == 3410){
						$price = '<span style=" font-size:18px">N$</span> '. $this->trade_model->smooth_price($row->sale_price).' pm';
					}else{
						$price = '<span style=" font-size:18px">N$</span> '. $this->trade_model->smooth_price($row->sale_price);
					}
					
				//Auction	
				}else{
					
					//$price = '<span style=" font-size:18px">N$</span> '.$this->trade_model->smooth_price($row->sale_price);
					$price = $this->trade_model->get_current_bid($row->product_id);
					if($price['str'] != 'No Bids'){
						$price = '<span style=" font-size:10px">CURRENT BID</span> '.$price['str'];
						
					}else{
						$price = $price['str'];	
					}
					
					$type_btn = '<a href="'.$url.'?id='.$row->product_id.'&'.$row->product_id.'/'.$this->trade_model->clean_url_str($row->title).'/" class="btn btn-inverse pull-right" style="margin-right:5px">View</a>';
					
					
				}
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter');
				$tweet_url = 'https://twitter.com/share?url='.site_url('/').$this->trade_model->clean_url_str($row->title).'&text='.trim(str_replace("'"," ",substr(strip_tags($row->title ) ,0, 100))).'&via=MyNamibia';
				

				
				//get REVIEWS
				$rating = $this->trade_model->get_rating($row->product_id);
					  
				if ($x2 % $amt == 0) {
				   $ad = '';
				   if($advert){
						 if($x2 != 0){
							  $ad = '<div class="span3">'.$this->my_na_model->show_trade_advert($row->main_cat_id ,$row->sub_cat_id, $sub_sub_cat_id , $sub_sub_sub_cat_id).'</div>';
						 }
				   }
				   echo $ad.'
				   </div>
				   <div class="row-fluid">
				   ';
				}
				
				$ribbon = $this->trade_model->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');
				echo ' <div class="span'.$span.' white_box">
							'.$ribbon.'
							<div class="slideshow-block">
								<a href="#" class="link"></a>
								<ul class="slides">
									'.implode($img).'
								</ul>
							</div>
							<div class="padding10">
								
								<div class="price_label">'.$price.'</div>
								<span class="pull-right" style="margin-top:10px">
									'.anchor_popup('https://twitter.com/share?url='.trim($tweet_url), ' ', $tweet).'
								</span>
								<h3 style="font-size:12px;line-height:20px;height:auto;">'.$this->trade_model->shorten_string($row->title, 8). '</h3>
								
								<div class="clearfix" style="height:5px;"></div>
								<div style="font-size:13px;margin-bottom:10px;width:100%;min-height:90px;max-height:150px; overflow:hidden;">'.$this->trade_model->shorten_string(strip_tags($row->description), 10).
								
									$this->trade_model->show_extras_short($row->extras).
								'</div>
								'.$b_logo. '
								<div class="clearfix"></div>
								<p>'.$type_btn. '</p>
								<div class="clearfix"></div>
							</div>			
					  </div>
					  ';
				
				$x2 ++;  
					  
					  
					  
			}
			
	
			echo '</div>
				</div>
			
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
						
					$(document).ready(function(){
							$("img.lazy").lazyload({
								  effect : "fadeIn"
							  });
							$("[rel=tooltip]").tooltip();	

					});
				</script>';
			
		 }else{
			

			//$ad = $this->my_na_model->show_trade_advert($main_cat_id , $sub_cat_id, $sub_sub_cat_id , $sub_sub_sub_cat_id);
			echo '<div class="row-fluid">
					<div class="span12">
						<div class="alert">
						 <h2>No matches found!</h2> We could not find any matching items for the current search criteria.
						 <p>Please refine your search by changing the search criteria above.</p>
						 <h3>but here are some similar items...</h3>
						</div>
					</div>
				 
				 </div>

				 ';
				 $query = $this->db->query("SELECT * FROM products JOIN product_extras ON products.product_id = product_extras.product_id WHERE main_cat_id = '".$main_cat_id."' AND products.bus_id = '".$bus_id."' ORDER BY listing_date DESC LIMIT 9");
				 $this->get_products($bus_id, $query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = '', $offset = 0, $title = '', $amt = 4, FALSE);
			 						
		 }
		  	  
		
	}

		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SINGLE PRODUCT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_product($product_id){
			
		//Get Main
		
		$query = $this->db->query("SELECT products.*, product_extras.extras FROM products LEFT JOIN product_extras on products.product_id = product_extras.product_id WHERE products.product_id = '".$product_id."'", FALSE);
		if($query->result()){

			$row = $query->row();
			
			
			echo '
				  <div id="fb-root"></div>
    			  <script src="https://connect.facebook.net/en_US/all.js"></script>
				  <div id="product_msg_"></div>';
	
			$fb = "postToFeed(".$row->product_id.", '". $row->title ."', '".$row->title."', '".$row->title ." - My Namibia','".$this->trade_model->shorten_string(strip_tags($row->description), 50)."', '".$this->trade_model->clean_url_str($row->title)."')";
			$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
			);
		
			$btn = '<a onclick="claim_deal_un('.$row->product_id.');" href="javascript:void(0)" id="claim_btn'.$row->product_id.'"  class="btn btn-large pull-right btn-inverse">
				<i class="icon-star-empty icon-white"></i> Grab Product
				</a>';
			//IF LOGGED IN
			if($this->session->userdata('id')){
				
				
				$btn = '<a onclick="claim_deal_un('.$row->product_id.');" href="javascript:void(0)" id="claim_btn'.$row->product_id.'"  class="btn btn-large pull-right btn-inverse">
								<i class="icon-star-empty icon-white"></i> Grab Product
								</a>';
			}
		
		
			$tweet_url = $this->trade_model->clean_url_str($row->title).'&text='.substr(strip_tags($row->title . ' ' . $row->description) ,0, 60).' ' .site_url('/').'product/'.$row->product_id.'&via=MyNamibia';
			$c = '';
			
			//STOCK TICKER
			if($row->quantity > 1){
				
				$stock_ticker = '
				    <div class="progress progress-striped progress-warning" title="'.$row->quantity.' Products Available" rel="tooltip">
					  <div class="bar" title="% of the deals are taken" rel="tooltip" style="width:%"></div>
					</div><div class="clearfix" style="height:20px;"></div>';
				
			}else{
				
				$stock_ticker = '';
			}

			//IF BUY NOW
			if($row->listing_type == 'S'){

				$count = ''; 
				$reserve = '';
				
				if($row->status == 'sold'){
					$price['str'] = ' Sold';
				}else{
					if($row->sub_cat_id == 3410){
						$price['str'] = '<font style=" font-size:12px">N$</font><span itemprop="price"> '.$this->trade_model->smooth_price($row->sale_price).'</span> pm';
					}else{
						$price['str'] = '<font style=" font-size:12px">N$</font><span itemprop="price"> '.$this->trade_model->smooth_price($row->sale_price).'</span>';	
					}
				}
				$btn_txt = 'Buy Now';
				if($row->main_cat_id == 3408){
					
					$btn_txt = 'Enquire Now';
						
				}
				//SEE IF OWN PRODUCT
				if($row->client_id == $this->session->userdata('id')){
				

					$btn = '<div class="pull-left"  rel="tooltip" title="Sorry, this is your item!">
							  <form id="buy_now_frm" method="post">
								   <input type="hidden" name="product_id" value="'.$product_id.'" />
								  <input type="hidden" name="bus_id" value="'.$row->bus_id.'" />
								  <input type="hidden" name="amount" value="'.$row->sale_price.'" />
								  <button class="btn btn-inverse btn-large" type="submit" disabled="disabled">'.$btn_txt.'</button>
							  </form>
							</div>';
				}else{
					
					$btn = '<div class="pull-left">
							  <form action="'.site_url('/').'trade/buy_now/" id="buy_now_frm" method="post">
								   <input type="hidden" name="product_id" value="'.$product_id.'" />
								  <input type="hidden" name="bus_id" value="'.$row->bus_id.'" />
								  <input type="hidden" name="title" value="'.$row->title.'" />
								  <input type="hidden" name="seller_id" value="'.$row->client_id.'" />
								  <input type="hidden" name="amount" value="'.$row->sale_price.'" />
								  <button class="btn btn-inverse btn-large" id="buy_now_btn" type="submit">'.$btn_txt.'</button>
							  </form>
							</div>';
					
				}
			//AUCTION	
			}else{
				
				echo '<link rel="stylesheet" type="text/css" href="'.base_url('/').'css/jquery.countdown.css">
				 	  <script type="text/javascript" src="'.base_url('/').'js/jquery.countdown.min.js"></script>';
					  
				$count = '<div id="ctdwn_'.$product_id.'"></div>';  
				$reserve = '<div class="well well-mini text-center"><font style=" font-size:12px">Reserve</font> <font style=" font-size:12px">N$</font> <br /><font style="font-size:20px;color:#FF9F01; font-weight:bold;">'.$row->reserve.'</font></div>';
				$price = $this->trade_model->get_current_bid($row->product_id);
				
				//SEE IF OWN PRODUCT
				if($row->client_id == $this->session->userdata('id')){
					
					$btn = '<div class="input-append">
							  <form action="'.current_url().'" id="auction_frm" method="post"  rel="tooltip" title="Sorry, this is your item!">
								  <input class="span4" type="text" onkeypress="return isNumberKey(event)" style="height:45px;font-size:16px;color:#FF9F01;font-weight:bold" name="bid_amount" value="Not Allowed"  disabled>
								  <input type="hidden" name="product_id" value="'.$product_id.'" />
								  <input type="hidden" name="bus_id" value="'.$row->bus_id.'" />
								  <input type="hidden" name="reserve" value="'.$row->reserve.'" />
								  <input type="hidden" name="current_bid" value="'.$price['current'].'" />
								  <button class="btn btn-inverse btn-large disabled" id="auction_btn1" type="submit">N$ Bid Now</button>
							  </form>
							</div>';	
				}else{
			
					$btn = '<div style="min-height:100px; ">
								
								<div class="row-fluid">
									<div class="span8">
										<div class="input-append" id="bid_box">
										  <form action="'.site_url('/').'trade/place_bid/" id="auction_frm" method="post">
											  <input class="span3" type="text" onkeypress="return isNumberKey(event)" style="height:45px;font-size:16px;color:#FF9F01;font-weight:bold; width:30%" name="bid_amount" value="'.$price['price'].'">
											  <input type="hidden" name="product_id" value="'.$product_id.'" />
											  <input type="hidden" name="bus_id" value="'.$row->bus_id.'" />
											  <input type="hidden" name="reserve" value="'.$row->reserve.'" />
											  <input type="hidden" name="title" value="'.$row->title.'" />
											  <input type="hidden" name="auto_bid" value="0" />
											  <input type="hidden" name="seller_id" value="'.$row->client_id.'" />
											  <input type="hidden" name="current_bid" value="'.$price['current'].'" />
											  <button class="btn btn-inverse btn-large" id="auction_btn" type="submit">N$ Bid Now</button>
										  </form>
										</div>
	
										<div class="input-append hide" id="auto_bid_box">
										  <form action="'.site_url('/').'trade/place_bid/" id="auction_frm_auto" method="post">
											  <input class="span3" type="text" onkeypress="return isNumberKey(event)" style="height:45px;font-size:16px;color:#FF9F01;font-weight:bold;width:30%" name="bid_amount" value="'.$price['price'].'">
											  <input type="hidden" name="product_id" value="'.$product_id.'" />
											  <input type="hidden" name="bus_id" value="'.$row->bus_id.'" />
											  <input type="hidden" name="reserve" value="'.$row->reserve.'" />
											  <input type="hidden" name="title" value="'.$row->title.'" />
											  <input type="hidden" name="auto_bid" value="1" />
											  <input type="hidden" name="seller_id" value="'.$row->client_id.'" />
											  <input type="hidden" name="current_bid" value="'.$price['current'].'" />
											  <button class="btn btn-inverse btn-large" id="auction_btn_auto" type="submit">N$ Auto Bid</button>
										</div>
									</div>
									<div class="span4">
										<a href="javascript:void(0)" onClick="switch_auto_bid()" class="btn btn-inverse pull-right">Auto Bid</a>
									</div>
								</div>
								<div class="alert alert-block clearfix hide" id="auto_help_txt"><strong>Please Note:</strong> Auto bid will automatically place your bid until your auto bid value is met.</div>
						   </div> 
							';
				}
				 
				$btn .=	$this->trade_model->get_bid_history($row->product_id);	
				
			}
			  $buy_now_btn = "<a href='javascript:void(0)' id='buy_now_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Buy Now</a>";
			  $bid_btn = "<a href='javascript:void(0)' id='bid_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Place My Bid</a>";
			  $my_link = '<a href="'.site_url('/').'product/'.$product_id.'/'.$this->trade_model->encode_url($row->title).'/" style="color:transparent; font-size:6px">'.$row->title.'</a>';
			  echo '<div itemscope itemtype="http://data-vocabulary.org/Product">
						<div style="float:right">'.$reserve.'</div>
						<h1 style="font-size:50px;height:40px;">'.$price['str'].'</h1>	
						<h3 style="font-size:20px;line-height:20px;height:25px;">'.$row->title.'</h3>
						<div class="clearfix" style="height:5px;"></div>
						<span itemprop="description">
							<p>'.$row->description.'</p><p>'.$this->trade_model->trade_model->show_extras($row->extras).'</p>
						</span>	
						'.$count.'
	
						<div class="clearfix" style="height:15px;"></div>
						'.$stock_ticker.'
						 <div class="clearfix"></div>
						 <div id="product_msg"></div>
						 <div class="clearfix"></div>
						
						
						<!--<div class="price_label">'.$price['str'].'</div>-->
						<div class="clearfix" style="height:45px;"></div>
					</div>'.$my_link;

					//ENDING DATE
					$listE = new DateTime(date('Y-m-d H:i:s', strtotime($row->end_date)));

					echo'	
					<script type="text/javascript">';

					if($row->listing_type == 'A'){
						
						echo '	$(function () {
							
								ctdwn_'.$product_id.' = new Date('.($listE->format('Y')).', '.($listE->format('m') -1).', ' .($listE->format('d')).', ' .($listE->format('H')).', ' .($listE->format('i')).');
								$("#ctdwn_'.$product_id.'").countdown({until: ctdwn_'.$product_id.'});
								
							});';
					}
					
					echo '	$("#auction_btn").bind("click", function(e){
		
								e.preventDefault();
								var x = $(this);
								x.popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />'.$bid_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);
								 $("#bid_btn_do").attr("href", "javascript:place_bid()");
						});
					
						function place_bid(){
							
							
								var frm = $("#auction_frm"), btn = $("#auction_btn");
								btn.html("Adding Bid...");
								$.ajax({
									type: "post",
									cache: false,
									url: "'. site_url("/").'trade/place_bid_ajax/" ,
									data: frm.serialize(),
									success: function (data) {	
										btn.html("Bid Now");
										$("#product_msg").html(data);
										
									}
								});	
							
						}
						
							$("#auction_btn_auto").bind("click", function(e){
		
								e.preventDefault();
								var x = $(this);
								x.popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />'.$bid_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);
								 $("#bid_btn_do").attr("href", "javascript:place_bid_auto()");
						});
						function place_bid_auto(){
							
							
								var frm = $("#auction_frm_auto"), btn = $("#auction_btn_auto");
								btn.html("Adding Bid...");
								$.ajax({
									type: "post",
									cache: false,
									url: "'. site_url("/").'trade/place_bid_ajax/" ,
									data: frm.serialize(),
									success: function (data) {	
										btn.html("Bid Now");
										$("#product_msg").html(data);
										
									}
								});	
							
						}
						$("#buy_now_btn").bind("click", function(e){
		
								e.preventDefault();
								var x = $(this);
								x.popover({  delay: { show: 100, hide: 3000 },
								 placement:"top",html: true,trigger: "manual",title:"Are You Sure?", content:"<p>Please confirm!</p><br />'.$buy_now_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);
								 $("#buy_now_btn_do").attr("href", "javascript:buy_now()");
						});
						
						function buy_now(){
							
							
								var frm = $("#buy_now_frm"), btn = $("#buy_now_btn");
								btn.html("Purchasing...");
								$.ajax({
									type: "post",
									cache: false,
									url: "'. site_url("/").'trade/buy_now/" ,
									data: frm.serialize(),
									success: function (data) {	
										btn.html("Buy Now");
										$("#product_msg").html(data);
										
									}
								});	
							
						}
						
					</script>
					';		
					
			
		}else{
			
			echo 'Product Not Found';	
		
		
		}
		
		
			
	}
	

	
	
}
?>