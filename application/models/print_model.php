<?php
class Print_model extends CI_Model{

	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	/*function print_model(){
  		//parent::CI_model();
		self::__construct();	
 	}*/


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//PRINT
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



	//+++++++++++++++++++++++++++
	//GET COMPANY DETAILS
	//++++++++++++++++++++++++++
	public function show_company($bus_id, $client_id)
	{
		

		$this->load->model('image_model'); 

		$this->load->library('thumborp');

		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();


		if($bus_id != 0){
			
			$this->db->where('ID', $bus_id);
			$bus = $this->db->get('u_business');
			
			if($bus->result()){
				
				$row = $bus->row();
				$img = $row->BUSINESS_LOGO_IMAGE_NAME;
				  //Build image string
				$format = substr($img,(strlen($img) - 4),4);
				$str = substr($img,0,(strlen($img) - 4));
				
				if($img != ''){
					
					if(strpos($img,'.') == 0){
			
						$format = '.jpg';
						$img_str = 'assets/business/photos/'.$img . $format;
						$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'200','200', $crop = '');
						
					}else{
						
						$img_str =  'assets/business/photos/'.$img;
						$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'200','200', $crop = '');
						
					}
					
				}else{
					
					$img_str = base_url('/').'images/bus_blank.png';	
					
				}
				//COVER IMAGE
				$cover_img = $row->BUSINESS_COVER_PHOTO;
			
				if($cover_img != ''){
					
						if(strpos($cover_img,'.') == 0){
				
							$format2 = '.jpg';
							$cover_str = 'assets/business/photos/'.$cover_img . $format2;
							$cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'800','600', $crop = '');
							
						}else{
							
							$cover_str =  'assets/business/photos/'.$cover_img;
							$cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'800','600', $crop = '');
							
						}
					
				}else{
					
					$cover_str = base_url('/').'img/business_cover_blank.jpg';	
					
				}
				$link = site_url('/').'b/'.$bus_id.'/'.$this->trade_model->encode_url($row->BUSINESS_NAME).'/';
				$agent = '<a href="'.$link.'" class="btn btn-inverse pull-right"><i class="icon-share icon-white"></i> View Details</a>';
				if($row->IS_ESTATE_AGENT == 'Y' && $client_id != 0){
					
					$agent = $this->show_estate_agent($client_id, $bus_id, $row->BUSINESS_NAME);
						
				}
				
				echo '<table class="table" border="0">
						<tr>
							<td colspan="1" style="width:120px;padding:10px 0px"><img class="img-polaroid" src="'.$img_url.'" alt="'.$row->BUSINESS_NAME.'" style="width: 110px; height:110px;"></td>
							<td colspan="2" style="width:280px;"><div itemscope style="display:none;padding:0;margin:0" itemtype="http://data-vocabulary.org/Organization">
								<span itemprop="name">'.$row->BUSINESS_NAME.'</span></div>
								<h4>'.$row->BUSINESS_NAME.'</h4>
								<p><span itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">'.$row->BUSINESS_PHYSICAL_ADDRESS.'</span></p>
								<p><span itemprop="phone" itemscope itemtype="http://data-vocabulary.org/Address">'.$row->BUSINESS_TELEPHONE.'</span></p>
							</td>
							<td colspan="2" align="right" style="padding:10px 0px"><img class="img-thumbnail" src="'.$cover_url.'" style="width:auto; height:110px;"></td>

						</tr>
						<tr>
							<td  style="border:none"></td>
						</tr>
					 </table>';	
						
						
			
			}else{
				
				
				
				
			}
				
			
			
		}
		
	}
	

	//+++++++++++++++++++++++++++
	//GET ESTATE AGENT
	//++++++++++++++++++++++++++
	public function show_estate_agent($client_id, $bus_id, $bus_name, $val = FALSE)
	{


		$this->load->model('image_model'); 

		$this->load->library('thumborp');

		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 200;
		$height = 200;


		$agent = $this->db->where('ID', $client_id);
		$agent = $this->db->get('u_client');
		$res = '';
		if($agent->result()){
			
			$row = $agent->row();
			$img_file = $row->CLIENT_PROFILE_PICTURE_NAME;
			
			if($img_file != ''){ 
			
				$img_str = 'assets/users/photos/'.$img_file;
				$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');
				
			}else{
				
				$img_url = 'images/user_blank.jpg';
				
			}

				
				
			$res = '<table class="table table-striped" border="0"  style="border:none">
						<tr>
							<td colspan="1"  class="text-right" style="text-align:right">
								<h4>'.ucwords($row->CLIENT_NAME. ' ' .$row->CLIENT_SURNAME).'</h4>
								<p>'.$row->CLIENT_CELLPHONE.'</p>
								<p>'.$row->CLIENT_EMAIL.'</p>
							</td>
							<td colspan="1" style="width:110px">
								<img src="'.$img_url.'" style="width:100px;height:100px;margin-left:0px;float:right" class="img-thumbnail pull-right" />
							</td>
						</tr>
					</table>';

		}
		return $res;
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PRINT PRODUCTS MULTI
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function print_product_multi($product_id, $property_agent = 0,  $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat){

		//echo $this->show_images_print($product_id, $size = '');
		$query = $this->db->query("SELECT products.*, product_extras.property_agent, product_extras.extras FROM products LEFT JOIN product_extras on products.product_id = product_extras.product_id WHERE products.product_id = '".$product_id."'", FALSE);
		if($query->result())
		{

			$row = $query->row();
			$product = $this->show_product($row,  $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, TRUE);

			if($sub_sub_sub_cat == '0'){
				$sub_sub_sub_cat = '';
			}

			//EXTRA REFERENCE
			$property_ref = '';
			if(is_array(json_decode($row->extras)) && array_key_exists('agency', json_decode($row->extras))){
				$artemp = (array)json_decode($row->extras);
				if($artemp['agency'] != ''){
					$property_ref = 'Ref: '.$artemp['agency'];
				}
			}
			echo '<h1 style="font-size:20px;margin-top:-20px;height:15px;line-height:20px;">' . $row->title . '<span class="pull-right" style="font-size:15px">'.$property_ref .'</span></h1>
				  <p style="margin-top:2px;line-height:15px;"><strong>'.$sub_sub_cat.' '. $sub_sub_sub_cat.'</strong></p>';

			echo '<table class="table table-striped each" border="0"  style="border:none;margin-top:-10px; background:#fff;height:200px;padding:0 auto;margin:0;overflow:hidden; ">
						<tr class="extras">
							<td style="width250px;background:#fff">
								' . $this->show_images_print($product_id, $size = 'sml', $limit = 1) . '
							</td>
							<td class="extras"  style="width:430px; background:#fff">' .
								$product . '
							</td>
						</tr>

				</table>';

//			if($row->property_agent != '0'){
//
//				$agent = $this->show_estate_agent($row->property_agent, $row->bus_id, '');
//				echo '<table class="table" border="0"  style="border:none;margin-top:-75px;">
//							<tr>
//								<td colspan="1" style="vertical-align:bottom;height:90px;">
//									<img src="'. base_url('/').'img/my-na-logo-black.png" style="width:90px;height:auto;float:left"/>
//								</td>
//								<td colspan="1" style="width:380px;height:90px;">' .
//					$agent . '
//								</td>
//							</tr>
//					  </table>';
//			}


			/*echo '<div class="row-fluid">
					 <div class="span12">
					   ' .
						$this->trade_model->get_product_questions($product_id) . '
					 </div>
				</div>


				<div class="row-fluid">
					 <div class="span12">
						   ' .
						$this->trade_model->show_reviews($product_id)
				. '
					 </div>
				</div>
				<footer></footer>';*/

		}
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PRINT PRODUCT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function print_product($product_id, $property_agent = 0,  $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat){
		
		//echo $this->show_images_print($product_id, $size = '');
		$query = $this->db->query("SELECT products.*, product_extras.property_agent, product_extras.extras FROM products LEFT JOIN product_extras on products.product_id = product_extras.product_id WHERE products.product_id = '".$product_id."'", FALSE);
		if($query->result())
		{

			$row = $query->row();
			$product = $this->show_product($row,  $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $multi = FALSE);

			if($sub_sub_sub_cat == '0'){
				$sub_sub_sub_cat = '';
			}

			//EXTRA REFERENCE
			$property_ref = '';
			if(is_array(json_decode($row->extras)) && array_key_exists('agency', json_decode($row->extras))){
				$artemp = (array)json_decode($row->extras);
				if($artemp['agency'] != ''){
					$property_ref = 'Ref: '.$artemp['agency'];
				}
			}
			echo '<h1 style="font-size:25px;margin-top:-25px;height:20px;line-height:20px;">' . $row->title . '<span class="pull-right" style="font-size:18px">'.$property_ref .'</span></h1>
				  <p style="margin-top:2px;line-height:15px;"><strong>'.$sub_sub_cat.' '. $sub_sub_sub_cat.'</strong></p>';



			echo '<div style="width:100%">
					<div style="width:55%; float:left;">
						' . $this->show_images_print($product_id, $size = '', $limit = 7) . '
					</div>
					<div style="width:40%;float:right">
						'.$product . '
					</div>
				</div>

				';


			if($row->property_agent != '0'){

				$agent = $this->show_estate_agent($row->property_agent, $row->bus_id, '');


				echo '<div style="width:100%">
						<div style="width:55%;float:left;">
							<br/><br/><br/><br/><br/>
							<img src="'. base_url('/').'img/my-na-logo-black.png" style="width:90px;height:auto;float:left;page-break-inside:avoid;"/>
						</div>
						<div style="width:40%;float:right">
							'.$agent . '
						</div>
					</div>

					';


			}


			/*echo '<div class="row-fluid">
					 <div class="span12">
					   ' .
						$this->trade_model->get_product_questions($product_id) . '
					 </div>
				</div>      
					  
	
				<div class="row-fluid">
					 <div class="span12">
						   ' .
						$this->trade_model->show_reviews($product_id)
				. '
					 </div>
				</div>
				<footer></footer>';*/

		}
	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//PRINT PRODUCT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function print_product2($product_id, $property_agent = 0,  $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat){

		//echo $this->show_images_print($product_id, $size = '');
		$query = $this->db->query("SELECT products.*, product_extras.property_agent, product_extras.extras FROM products LEFT JOIN product_extras on products.product_id = product_extras.product_id WHERE products.product_id = '".$product_id."'", FALSE);
		if($query->result())
		{

			$row = $query->row();
			$product = $this->show_product2($row,  $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $multi = FALSE);

			if($sub_sub_sub_cat == '0'){
				$sub_sub_sub_cat = '';
			}

			//EXTRA REFERENCE
			$property_ref = '';
			if(is_array(json_decode($row->extras)) && array_key_exists('agency', json_decode($row->extras))){
				$artemp = (array)json_decode($row->extras);
				if($artemp['agency'] != ''){
					$property_ref = 'Ref: '.$artemp['agency'];
				}
			}
			echo '<h1 style="font-size:25px;margin-top:-25px;height:20px;line-height:20px;text-align:center">' . $row->title . '<span class="pull-right" style="font-size:18px">'.$property_ref .'</span></h1>
				  <p style="margin-top:2px;line-height:15px;"><strong>'.$sub_sub_cat.' '. $sub_sub_sub_cat.'</strong></p>';


			//get images
			$images = $this->db->order_by('sequence', 'ASC');
			$images = $this->db->where('product_id', $product_id);
			$images = $this->db->limit(1);


			$images = $this->db->get('product_images');

			//GET MAIN IMAGE
			if($images->result())
			{

				$imgrow = $images->row();

				echo '<div style="width:100%">
						<img class="img-polaroid" src="'.base_url('/').'img/timbthumb.php?src='.S3_URL.'assets/products/images/'.$imgrow->img_file.'&w=800&h=400&q=100" style="width:800px;height:400px">
					  </div>';

			}



			echo '<div style="width:100%">
					<div style="width:100%;">
						'.$product.'
					</div>
				</div>';

			if($row->property_agent != '0'){

				$agent = $this->show_estate_agent($row->property_agent, $row->bus_id, '');

				echo '<div style="width:100%">
						<div style="width:55%;float:left;">
							<br/><br/><br/><br/><br/>
							<img src="'. base_url('/').'img/my-na-logo-black.png" style="width:90px;height:auto;"/>
						</div>
						<div style="width:40%;float:right">
							'.$agent . '
						</div>
					</div>

					';
			}


			/*echo '<div class="row-fluid">
					 <div class="span12">
					   ' .
						$this->trade_model->get_product_questions($product_id) . '
					 </div>
				</div>


				<div class="row-fluid">
					 <div class="span12">
						   ' .
						$this->trade_model->show_reviews($product_id)
				. '
					 </div>
				</div>
				<footer></footer>';*/

		}
	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SINGLE PRODUCT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_product($row, $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $multi = FALSE)
	{

		//Get Main
		$output = '';


		$fb = "postToFeed(" . $row->product_id . ", '" . $row->title . "', '" . $row->title . "', '" . $row->title . " - My Namibia','" . $this->trade_model->shorten_string(strip_tags($row->description), 50) . "', '" . $this->trade_model->clean_url_str($row->title) . "')";
		$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
		);

		$btn = '<a onclick="claim_deal_un(' . $row->product_id . ');" href="javascript:void(0)" id="claim_btn' . $row->product_id . '"  class="btn btn-large pull-right btn-inverse">
			<i class="icon-star-empty icon-white"></i> Grab Product
			</a>';
		//IF LOGGED IN
		if ($this->session->userdata('id'))
		{


			$btn = '<a onclick="claim_deal_un(' . $row->product_id . ');" href="javascript:void(0)" id="claim_btn' . $row->product_id . '"  class="btn btn-large pull-right btn-inverse">
							<i class="icon-star-empty icon-white"></i> Grab Product
							</a>';
		}


		$tweet_url = $this->trade_model->clean_url_str($row->title) . '&text=' . substr(strip_tags($row->title . ' ' . $row->description), 0, 60) . ' ' . site_url('/') . 'product/' . $row->product_id . '&via=MyNamibia';
		$c = '';

		//STOCK TICKER
		if ($row->quantity > 1)
		{

			$stock_ticker = '
			    <div class="progress progress-striped progress-warning" title="' . $row->quantity . ' Products Available" rel="tooltip">
				  <div class="bar" title="% of the deals are taken" rel="tooltip" style="width:%"></div>
				</div><div class="clearfix" style="height:20px;"></div>';

		}
		else
		{

			$stock_ticker = '';
		}

		//IF BUY NOW
		if ($row->listing_type == 'S')
		{

			$count = '';
			$reserve = '';

			if ($row->status == 'sold')
			{
				$price['str'] = ' Sold';
			}
			else
			{
				if ($row->sub_cat_id == 3410)
				{
					$price['str'] = '<span style=" font-size:18px">N$</span><span itemprop="price" style=" font-size:28px"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span> pm';
				}
				else
				{
					$price['str'] = '<span style=" font-size:18px">N$</span><span itemprop="price" style=" font-size:28px"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span>';
				}
			}
			$btn_txt = 'Buy Now';
			if ($row->main_cat_id == 3408)
			{

				$btn_txt = 'Enquire Now';

			}

			//AUCTION
		}
		else
		{

			$output .= '<link rel="stylesheet" type="text/css" href="' . base_url('/') . 'css/jquery.countdown.css">
			      <script type="text/javascript" src="' . base_url('/') . 'js/jquery.countdown.min.js"></script>';

			$count = '<div id="ctdwn_' . $row->product_id . '"></div>';
			$reserve = '<div class="well well-mini text-center"><font style=" font-size:12px">Reserve</font> <font style=" font-size:12px">N$</font> <br /><font style="font-size:20px;color:#FF9F01; font-weight:bold;">' . $row->reserve . '</font></div>';
			$price = $this->get_current_bid($row->product_id);

			//SEE IF OWN PRODUCT
			if ($row->client_id == $this->session->userdata('id'))
			{

				$btn = '';
			}
			else
			{

				$btn = '';
			}

			$btn .= $this->trade_model->get_bid_history($row->product_id);

		}
		$extras = $this->show_extras($row->extras);
		$descr = '<p>' . $row->description . '</p>';
		if($multi){

			$extras = $this->show_extras($row->extras);
			$descr = '';
		}

		$suburb = $row->suburb;
		if($row->suburb == '0'){
			$suburb = '';
		}
		$buy_now_btn = "<a href='javascript:void(0)' id='buy_now_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Buy Now</a>";
		$bid_btn = "<a href='javascript:void(0)' id='bid_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Place My Bid</a>";
		$output .= '<div itemscope itemtype="http://data-vocabulary.org/Product">
					<div style="float:right">' . $reserve . '</div>
					<h1 style="height:30px;color:#FF9F01;margin:0 0 20px 15px">' . $price['str'] . '</h1>

					<div itemprop="description">

						<div style="height:15px"><img style="width:15px;height:15px;" src="'.base_url('/').'img/icons/trade/icn_map.png"/>'.$row->location.' '. $suburb.'</div>
						'.$descr.'
						'.$extras['extras'].'
					</div>
					' . $count . '
					<div class="clearfix" style="height:0px;"></div>

				</div>';

		//ENDING DATE
		$listE = new DateTime(date('Y-m-d H:i:s', strtotime($row->end_date)));


		return $output;


	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SINGLE PRODUCT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_product2($row, $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat, $multi = FALSE)
	{

		//Get Main
		$output = '';
		$btn ='';

		$c = '';

		//STOCK TICKER
		if ($row->quantity > 1)
		{

			$stock_ticker = '
			    <div class="progress progress-striped progress-warning" title="' . $row->quantity . ' Products Available" rel="tooltip">
				  <div class="bar" title="% of the deals are taken" rel="tooltip" style="width:%"></div>
				</div><div class="clearfix" style="height:20px;"></div>';

		}
		else
		{

			$stock_ticker = '';
		}

		//IF BUY NOW
		if ($row->listing_type == 'S')
		{

			$count = '';
			$reserve = '';

			if ($row->status == 'sold')
			{
				$price['str'] = ' Sold';
			}
			else
			{
				if ($row->sub_cat_id == 3410)
				{
					$price['str'] = '<span style=" font-size:18px">N$</span><span itemprop="price" style=" font-size:28px"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span> pm';
				}
				else
				{
					$price['str'] = '<span style=" font-size:18px">N$</span><span itemprop="price" style=" font-size:28px"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span>';
				}
			}
			$btn_txt = 'Buy Now';
			if ($row->main_cat_id == 3408)
			{

				$btn_txt = 'Enquire Now';

			}

			//AUCTION
		}
		else
		{


			$count = '<div id="ctdwn_' . $row->product_id . '"></div>';
			$reserve = '<div class="well well-mini text-center"><font style=" font-size:12px">Reserve</font> <font style=" font-size:12px">N$</font> <br /><font style="font-size:20px;color:#FF9F01; font-weight:bold;">' . $row->reserve . '</font></div>';
			$price = $this->get_current_bid($row->product_id);

			//SEE IF OWN PRODUCT
			if ($row->client_id == $this->session->userdata('id'))
			{

				$btn = '';
			}
			else
			{

				$btn = '';
			}

			//$btn .= $this->trade_model->get_bid_history($row->product_id);

		}
		$extras = $this->show_extras($row->extras);
		$descr =  $row->description ;
		if($multi){

			$extras = $this->trade_model->show_extras_short($row->extras);
			$descr = '';
		}

		$suburb = $row->suburb;
		if($row->suburb == '0'){
			$suburb = '';
		}
		$buy_now_btn = "<a href='javascript:void(0)' id='buy_now_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Buy Now</a>";
		$bid_btn = "<a href='javascript:void(0)' id='bid_btn_do'  class='btn btn-large btn-block btn-inverse'>Yes Place My Bid</a>";



		$output .= '<div class="row-fluid" style="width:100%; height:auto;">
						<div class="span8" style="width:69%;height:auto;float:left;">
							<h1 style="height:30px;color:#FF9F01;margin:0 0 20px 15px">' . $price['str'] . '</h1>
						</div>
						<div class="span4 text-right" style="width:25%;height:auto;float:left;">
							' . $reserve . '
						</div>
					</div>
					<div class="row-fluid" style="width:100%;height:auto">
						<div class="span7" style="width:69%;height:auto;float:left;">
							<p style="height:15px">'.$row->location.' '. $suburb.'</p>
							'.$descr.'
							' .$extras['features'] . '
						</div>
						<div class="span5" style="width:25%;height:auto;float:right;">
							' .$extras['extras'] . '
						</div>
					</div>';

		//ENDING DATE
		$listE = new DateTime(date('Y-m-d H:i:s', strtotime($row->end_date)));


		return $output;


	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW EXTRAS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_extras($extras){

		$extras = json_decode($extras , true);
		$output = '';$output2 = '<table style="page-break-inside:avoid;" class="table table-striped table-condensed">
					   	<thead>
							<tr>
								<th style="width:30%"></th>
								<th style="width:70%"></th>
							</tr>
						</thead>
						<tbody>';
		if($extras != NULL){

			$output .='<table style="page-break-inside:avoid;" class="table table-striped table-condensed">
					   	<thead>
							<tr>
								<th style="width:30%"></th>
								<th style="width:70%"></th>
							</tr>
						</thead>
						<tbody>
						';

			foreach($extras as $row => $value){

				// if Array
				if(is_array($value)){

					//AUTOHAUS + MZ
					if($row == 'mz_motors' || $row == 'autohaus'){

						//if not empty
					}elseif(count($value) > 0){


						$output2 .='<table style="page-break-inside:avoid;" class="table table-striped table-condensed">
					   	<thead>
							<tr>
								<th style="width:30%"></th>
								<th style="width:70%"></th>
							</tr>
						</thead>
						<tbody>
						';
						$output2 .= '<tr>
												<td>
												'.ucfirst(str_replace('_', ' ',$row)).'

												</td>
												<td>
												';
						foreach($value as $finalrow => $final_val){

							$output2 .= '<span class="badge">'.$final_val .'</span> ';

						}
						$output2 .= '	</td>
											</tr>
											';
					}

				}elseif($row == 'product_id'){

					//SKIP FEATURES KEY
				}elseif($row == 'featured'){

				}elseif($row == 'bus_id'){

				}elseif($row == 'features'){

				}elseif($row == 'seller_contact'){



				}else{

					//MAP FUNCTIONS
					if($row == 'prop_lat' || $row == 'prop_lon' || $row == 'toggle_map' || $row == 'address' || $row == 'location'){



						//INVESTMENT FETAURES PROPERTY
					}elseif($row == 'sole_mandate' || $row == 'cc_registered' || $row == 'PTY_Ltd' || $row == 'negotiable' || $row == 'transfer_costs_included' || $row == 'vat_inclusive' || $row == 'warranty'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_chk.png" style="width:20px;height:20px">
											'.ucfirst(str_replace('_', ' ',$row)).'
											</td>
										</tr>
										';
						//AGENCY
					}elseif($row == 'agency'){


						//SIZES PROPERTY
					}elseif($row == 'erf_size' || $row == 'house_size' ||  $row == 'property_size' ||$row == 'building_size'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_size.png" style="width:20px;height:20px" >
											'.ucfirst(str_replace('_', ' ',$row)). ' '.ucfirst(number_format((int)$value)) .' m<sup>2</sup>
											</td>
										</tr>
										';
						//BEDROOMS PROPERTY
					}elseif($row == 'bedrooms' || $row == 'offices'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_beds.png" style="width:20px;height:20px">
											'.ucwords($value).' '.'
											</td>
										</tr>
										';

						//BATHROOMA PROPERTY
					}elseif($row == 'bathrooms'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_baths.png" style="width:20px;height:20px" >
											'.ucwords($value).' ' .'
											</td>
										</tr>
										';

						//PARKIN PROPERTY
					}elseif($row == 'parking' || $row == 'garages' ){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_park.png" style="width:20px;height:20px" >
											'.ucwords($value).' ' .'
											</td>
										</tr>
										';



						////METRES Squared
					}elseif($row == 'erf_size' || $row == 'house_size'){

						$output .= '<tr>
											<td>
											'.ucfirst(str_replace('_', ' ',$row)).'

											</td>
											<td>
											'.ucfirst(number_format((int)$value)) .' m<sup>2</sup>
											</td>
										</tr>
										';
						//CAR SPECIFIC - doors
					}elseif($row == 'doors'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_doors.png" style="width:20px;height:20px" >
											'.ucfirst(number_format((int)$value)) .' '.$row.'
											</td>
										</tr>
										';
						//CAR SPECIFIC - body style
					}elseif($row == 'body_style'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_body.png" style="width:20px;height:20px" >
											'.ucfirst($value) .'
											</td>
										</tr>
										';
						//CAR SPECIFIC - fuel tyoe
					}elseif($row == 'fuel_type'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_petrol.png" style="width:20px;height:20px" >
											'.ucfirst($value) .'
											</td>
										</tr>
										';
						//CAR SPECIFIC - transmission
					}elseif($row == 'transmission'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_transmission.png" style="width:20px;height:20px" >
											'.ucfirst($value) .'
											</td>
										</tr>
										';


						//CAR SPECIFIC - transmission
					}elseif($row == 'cylinders'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_cylinders.png"style="width:20px;height:20px" >
											'.ucfirst(number_format((int)$value)) .' '.$row.'
											</td>
										</tr>
										';
						//CAR SPECIFIC - engine size
					}elseif($row == 'engine_size'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_engine.png" style="width:20px;height:20px" >
											'.ucfirst(number_format((int)$value)) .' '.$row.'
											</td>
										</tr>
										';
						//CAR SPECIFIC - year make
					}elseif($row == 'year'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_year.png" style="width:20px;height:20px" >
											'.ucfirst((int)$value) .' model
											</td>
										</tr>
										';
						//CAR SPECIFIC - kilometres
					}elseif($row == 'kilometres'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_kilometers.png" style="width:20px;height:20px" >
											'.ucfirst(number_format((int)$value)) .' km
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}elseif($row == 'color'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_color.png" style="width:20px;height:20px" >
											'.ucfirst($value).'
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}elseif($row == '4wd'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_4x4.png" style="width:20px;height:20px" >
											'.ucfirst($value).'
											</td>
										</tr>
										';
						//CAR SPECIFIC - color
					}elseif($row == 'owners'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_car_owner.png" style="width:20px;height:20px" >
											'.ucfirst($value).'
											</td>
										</tr>
										';
						//MONEY FORMAT
					}elseif($row == 'valuation'){

						$output .= '<tr>
											<td colspan="2">
											<img src="'.base_url('/').'img/icons/trade/icn_cash.png" style="width:20px;height:20px" >
											N$ '.ucfirst(number_format((int)$value)) .'
											</td>
										</tr>
										';


					}else{

						$output .= '<tr>
											<td>
											'.ucfirst(str_replace('_', ' ',$row)).'

											</td>
											<td>
											'.ucfirst($value) .'
											</td>
										</tr>
										';

					}


				}


			}
			$output .='</tbody>
			   			</table>';
			//return $output;
			$output2 .='</tbody>
			   			</table>';
		}

		$data['extras'] = $output;
		$data['features'] =  $output2;
		return $data;
		//var_dump($extras);
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET CURRENT BID
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_current_bid($product_id){

		$this->db->where('product_id', $product_id);
		$this->db->where('type', 'bid');
		$this->db->order_by('amount', 'DESC');
		$this->db->limit('1');
		$bid = $this->db->get('product_auction_bids');

		if($bid->result()){

			$row = $bid->row();
			$data['current'] = $row->amount;
			$data['price'] = $row->amount + 5;
			$data['str'] = '<font style=" font-size:30px">N$</font><span itemprop="price"> '. $this->trade_model->smooth_price($row->amount).'</span>';
			return $data;

		}else{

			$data['current'] = 0;
			$data['price'] = 5;
			$data['str'] = 'No Bids';
			return $data;

		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET IMAGES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function show_images_print($product_id, $size, $limit){
		
			$this->load->model('image_model'); 

			$this->load->library('thumborp');

			$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();

			$width = 400;
			$height = 200;


			//get images
			$this->db->order_by('sequence', 'ASC');
			$this->db->where('product_id', $product_id);
			if($limit == 1){
				$this->db->limit(1);
			}else{
				$this->db->limit(7);

			}

			$images = $this->db->get('product_images');

			//GET MAIN IMAGE				
			if($images->result()){
				
				//SHOW MAIN PIC
				$x = 0;
				
				$str = '';
				foreach($images->result() as $row){

					//IF IMAGE IS EDITED
					$rand = '';$temp = '';
					if($row->edited != 'N'){
						$rand = '?ed='.$row->edited;
						$temp = $row->edited;
					}

					$img_str = 'assets/products/images/'.$row->img_file;

					if($size != ''){

						$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'400','200', $crop = '');
						$str .= '<img alt="" class="img-thumbnail" src="'.$img_url.'" style="width: 250px; height: 150px; ">';

					}else{
						//FIRST BIG SPAN
						if($x == 0){

							$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'330','250', $crop = '');
							$str .= '<div><img class="img-thumbnail" src="'.$img_url.'" style="width: 330px; height: 250px; margin-right:20px"></div>';

						}elseif($x % 2 == 0){

							$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'150','120', $crop = '');
							$str .= '<img class="img-thumbnail" src="'.$img_url.'" style="width: 150px; height: 120px; margin-top:5px;margin-right:0px"><br />';

						}else{

							$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'150','120', $crop = '');
							$str .= '<img class="img-thumbnail" src="'.$img_url.'" style="width: 150px; height: 120px; margin-top:5px;margin-right:16px">';

						}

					}

					
					$x ++;
				}
				$str .= '';
			
			}else{
				if($size != ''){

					$str = '<img alt="" class="white_box padding2 img-thumbnail" src="'.base_url('/').'img/product_blank.jpg" style="width: 250x; height: 150px; float:left;margin-right:20px">';
				}else{

					$str = '<img alt="" class="white_box padding2 img-thumbnail" src="'.base_url('/').'img/product_blank.jpg" style="width: 325px; height: 250px; float:left;margin-right:20px">';
				}

				
			}
			return $str;
	}	

}
?>