<?php
class Deal_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function deal_model(){
  		//parent::CI_model();
		self::__construct();	
 	} 


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BUSINESS DEALS FOR EDIT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_business_deals($bus_id){
		
		
		$query = $this->db->query("SELECT * FROM u_special_component WHERE BUSINESS_ID = '".$bus_id."'" ,FALSE);
		if($query->result()){
			echo '<a onclick="toggle_deal_add()" class="btn pull-right"><i class="icon-plus-sign"></i> Add New Deal</a>';
			$add_str = $bus_id."','add_deal'";
			echo'
			
			<h4>Deals<small> Your current deals</small></h4>
			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="deal_tbl" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%;">Image</th>
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:25%">Title</th>
						<th style="width:10%">Price</th>
						<th style="width:12%">Start</th>
						<th style="width:13%">End</th>
						<th style="width:5%">Q</th>
						<th style="width:5%">Claims</th>
						<th style="width:20%;min-width:100px"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				$no_img = '<span class="badge badge-danger">No</span>';
				if($row->SPECIALS_IMAGE_NAME == ''){

					$img = base_url('/').'img/user_blank.jpg';
					$no_img = '<span class="badge badge-danger">No</span>';
				}else{

					$img = CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;

					$imgP = CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					if(file_exists($imgP)){

						$no_img = '<span class="badge badge-success">Yes</span>';

					}


				}
				
				if($row->IS_ACTIVE == 'Y'){
					
					$active = '<a class="btn btn-mini btn-success" title="Deal is live" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					
				}else{
					
					$active = '<a class="btn btn-mini btn-warning" title="Not approved" rel="tooltip"><i class="icon-time icon-white"></i></a>';
					
				}
				
				if(date('Y-m-d',strtotime($row->SPECIALS_EXPIRE_DATE)) < date('Y-m-d')){
					
					$active = '<a class="btn btn-mini btn-warning" title="Deal is expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					
				}
						
				echo '<tr>
						<td style="width:5%;min-width:40px"><img src="'.$img.'" 
							alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:5%">'.$no_img .'</td>
						<td style="width:25%">'.$row->SPECIALS_HEADER .'</td>
						<td style="width:10%">N$ '.$row->SPECIALS_PRICE .'</td>
						<td style="width:12%">'.date('Y-m-d',strtotime($row->SPECIALS_STARTING_DATE)) .'</td>
						<td style="width:13%">'.date('Y-m-d',strtotime($row->SPECIALS_EXPIRE_DATE)).'</td>
						<td style="width:5%">'.$row->QUANTITY.'</td>
						<td style="width:5%"><span class="badge">'.$this->count_claims($row->ID).'</span></td>
					  	<td style="width:20%;min-width:100px;text-align:right">  
							'.$active.'
							<a onclick="deal_stats('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-cog icon-white"></i></a>
							<a onclick="update_deal('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-pencil icon-white"></i></a> 
							<a onclick="delete_deal('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			$tbl = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script data-cfasync="false" type="text/javascript">
					$("[rel=tooltip]").tooltip();		
					$("#deal_tbl").dataTable( {
							
							"sPaginationType": "bootstrap",
							"oLanguage": {
								"sLengthMenu": "_MENU_"
							},
							"aaSorting":[],
							"bSortClasses": false
	
						} );
				</script>';
			
		 }else{
			
			echo '<div class="alert">
				<a onclick="toggle_deal_add()" class="btn pull-right"><i class="icon-plus-sign"></i> Add New Deal</a>
				 <h4>No Deals added</h4> No deals have been added.
				 
				</div>'; 
			 
			 
		 }
		  	  
		
	}
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BUSINESS DEALS FOR HOME FEED
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_homefeed_deals($x){
		
		$limit = 1;
		//$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY SPECIALS_EXPIRE_DATE DESC LIMIT ".$limit." OFFSET ".$x."" ,FALSE);
		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() ASC LIMIT ".$limit." OFFSET ".$x."" ,FALSE);
		if($query->result()){
			
			
			foreach($query->result() as $row){
				
				if($row->SPECIALS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					
				}
				$blogo = '';
				//CYMOT
				if($row->BUSINESS_ID == '514'){
					
					$blogo = '<img src="'.base_url('/').'img/icons/cymot_logo.png" class="pull-right img-responsive" alt="Cymot Namibia Specials" width="100" title="Brought to you by Cymot" rel="tooltip"/>';	
				}

				//IF LOGGED IN
				if($this->session->userdata('id')){

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal'){
						//IF ALREADY CLAIMED
						if($this->is_deal_claimed($row->ID)){

							$btn = '
									<a id="claim_btn'.$row->ID.'"  class="btn pull-right btn-warning">
									<i class="icon-star-empty icon-white"></i> Deal Claimed
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px">
									View</a>';

						}else{
							$btn = '
									<a onclick="claim_deal_1('.$row->ID.');" href="javascript:void(0)" id="claim_btn_1'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> Grab Deal
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px"">
									View</a>';

						}
						$ribbon = '<div class="product_ribbon_sml"><small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span></div>';
						//NO DEAL
					}else{

						$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special</a>';


						$ribbon = '<div class="product_ribbon_sml"><small>Save Huge</small> ON THIS SPECIAL<span></span></div>';
					}



				}else{

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal')
					{
						$ribbon = '<div class="product_ribbon_sml"><small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span></div>';
						$btn = '<a onclick="claim_deal_un(' . $row->ID . ');" href="javascript:void(0)" id="claim_btn' . $row->ID . '"  class="btn pull-right btn-inverse">
										<i class="icon-star-empty icon-white"></i> Grab Deal
										</a>';

					}else{
						$ribbon = '<div class="product_ribbon_sml"><small>Save Huge</small> ON THIS SPECIAL<span></span></div>';
						$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special</a>';

					}
				}

				$cleanT = preg_replace("/[^a-z0-9.]+/i", "",$row->SPECIALS_HEADER);
				
				$cleanD = preg_replace("/[^a-z0-9.]+/i", "", $row->SPECIALS_CONTENT);
				
				$fb = "postToFeed(".$row->ID.", '". $cleanT ."', '".$img."', '".$cleanT ." - My Namibia','".$this->shorten_string($cleanD, 50)."', '".site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($cleanT)."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
				
				$tweet_url = 'https://my.na/deal/'.$this->clean_url_str($row->SPECIALS_HEADER).'&text='.$this->shorten_string(trim($cleanD), 12).'&via=MyNamibia';
				$c = 0;
				if($row->QUANTITY != 0){
					$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				}
				echo ' <div class="row-fluid">
							<div class="span12  results_div">
							<div class="span8">
								<img class="lazy'.$x.'" src="'.base_url('/').'img/timbthumb.php?src='.$img.'&w=780&h=540&q=15" alt="'.strip_tags($cleanT).'" data-original="'.$img.'" />
							</div>
							<div class="span4">
									<div style="width:100%;height:190px;">
									<div style="float:right;">
										<a onclick="'.$fb.'" class="facebook"></a>
										'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
									</div>
									<h1 class="upper na_script" style="color:#FF9F01;"><span style=" font-size:12px">N$</span>'.$row->SPECIALS_PRICE.'</h1>
									<h4 class="upper na_script">'.$row->SPECIALS_HEADER.'</h4>
									<div class="clearfix" style="height:5px;"></div>
									<div style="font-size:10px;">'.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 40).'</div>
									'.$blogo.'
									</div>
									<div class="clearfix" style="height:20px;"></div>
									<div  id="ctdwn_'.$row->ID.'"></div>
									<div class="clearfix" style="height:15px;"></div>
									<div class="progress progress-striped progress-warning" title="'.($row->QUANTITY - $this->count_claims($row->ID)).' Deals Available" rel="tooltip">
									  <div class="bar" title="'.$c.'% of the deals are taken" rel="tooltip" style="width:'.$c.'%"></div>
									</div>
									<div class="clearfix" style="height:20px;"></div>

									'.$btn.'
									<div class="clearfix" style="height:20px;"></div>
								</div>
						</div>	
					  </div>
					  
					  ';
				
			}
			
			if($x == 0){
				$fb_share_key = '';//$this->encrypt('fb_share');
				$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
				$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
				$claim_btn = "<a href='javascript:void(0)' id='claim_btn_do'  class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";
				echo ' <script data-cfasync="false" type="text/javascript">
	  						
							 $(function () {
								
								ctdwn_'.$row->ID.' = new Date('.date('Y',strtotime($row->SPECIALS_EXPIRE_DATE)).', '.(date('m',strtotime($row->SPECIALS_EXPIRE_DATE)) - 1).', ' .date('d',strtotime($row->SPECIALS_EXPIRE_DATE)).');
								$("#ctdwn_'.$row->ID.'").countdown({until: ctdwn_'.$row->ID.'});
								
							});

							$(document).ready(function(){
								
								$("[rel=tooltip]").tooltip(); 
							
								
								$(window)
									.off("scroll", ScrollHandlerf)
									.on("scroll", ScrollHandlerf);
								 
							});

						  
							
							function claim_deal(id){
								var x = $("#claim_btn_1"+id);
								x.html("'.$load_img.' Claiming...");
								
								$.ajax({
									type: "get",
									cache: false,
									url: "'.site_url('/').'deals/claim_deal/"+id ,
									success: function (data) {
									   
									   $("#deal_msg_").html(data);
									   
											
									}
								});	 
									
							}
							
						 function claim_deal_1(id){
								var x = $("#claim_btn_1"+id);
								
								x.popover({  delay: { show: 100, hide: 3000 },
								 placement:"top",html: true,trigger: "manual",
								 title:"Are You Sure?", content:"Are you sure you want to Grab this deal? By clicking Yes -you will be charged according to the value of the deal! Payment instructions will follow in an e-mail shortly! <br /><br />'.$claim_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);
								 $("#claim_btn_do").attr("href", "javascript:claim_deal("+id+")");
						  }
							
						  function claim_deal_un(id){
								var x = $("#claim_btn"+id);
								
								x.popover({  delay: { show: 100, hide: 3000 },
								 placement:"top",html: true,trigger: "manual",
								 title:"Please register", content:"To claim this amazing deal please create a FREE account. Pay nothing and receive fantastic benefits. <br /><br />'.$register_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);
									 
									
							}
							
							function ScrollHandlerf(e) {
								//throttle event:
								clearTimeout(_throttleTimer);
								_throttleTimer = setTimeout(function () {
								
								
									//do work
									if ($(window).scrollTop() + $(window).height() > getDocHeight() - 600) {
										load_home_feed(_scroll_feed);
										
									}
							
								}, _throttleDelay);
							}
							
							function getDocHeight() {
								var D = document;
								return Math.max(
									Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
									Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
									Math.max(D.body.clientHeight, D.documentElement.clientHeight)
								);
							}
							
							
						  </script>';
			}
			
			echo 
			'<script data-cfasync="false" type="text/javascript">
				    $("img.lazy'.$x.'").lazyload({
						 effect : "fadeIn"
					});
					
			</script>';	
			
		 }else{
			
			
			echo 
			'<script data-cfasync="false" type="text/javascript">
					$("img.lazy'.$x.'").lazyload({
						 effect : "fadeIn"
					});
					
			</script>';	
			 
		 }
	
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET DEALS BOXES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function show_deals_hm(){


		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 4" ,FALSE);
		if($query->result()){
			echo '<div id="deal_slider" class="">


				 ';
			$x = 0;
			foreach($query->result() as $row){

				if($row->SPECIALS_IMAGE_NAME == ''){

					$img = base_url('/').'img/user_blank.jpg';

				}else{

					$img = base_url('/').'img/timbthumb.php?w=300&h=200&src='.CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;

				}

				$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$img."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER)."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);

				//PRICE
				$price = '<span style=" font-size:12px">N$</span> '.$row->SPECIALS_PRICE.'';
				if($row->NORMAL_PRICE > 0){

					$price = '<span style=" font-size:12px">N$</span> '.$row->SPECIALS_PRICE.' <span style=" font-size:12px">N$</span> <span style="text-decoration: line-through;font-size:15px">'.$row->NORMAL_PRICE.'</span>';
				}

				$price_l = '<div class="price_label">'.$price.'</div>';
				//IF LOGGED IN
				if($this->session->userdata('id')){

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal'){
						//IF ALREADY CLAIMED
						if($this->is_deal_claimed($row->ID)){

							$btn = '
									<a id="claim_btn'.$row->ID.'"  class="btn pull-right btn-warning">
									<i class="icon-star-empty icon-white"></i> Deal Claimed
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px">
									View</a>';

						}else{
							$btn = '
									<a onclick="claim_deal_1('.$row->ID.');" href="javascript:void(0)" id="claim_btn_1'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> Grab Deal
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px"">
									View</a>';

						}
						$ribbon = '<div class="product_ribbon_sml"><small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span></div>';
						//NO DEAL
					}else{

						$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special</a>';


						$ribbon = '<div class="product_ribbon_sml"><small>Save Huge</small> ON THIS SPECIAL<span></span></div>';
					}



				}else{

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal')
					{
						$ribbon = '<div class="product_ribbon_sml"><small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span></div>';
						$btn = '<a onclick="claim_deal_un(' . $row->ID . ');" href="javascript:void(0)" id="claim_btn' . $row->ID . '"  class="btn pull-right btn-inverse">
										<i class="icon-star-empty icon-white"></i> Grab Deal
										</a>';

					}else{
						$ribbon = '<div class="product_ribbon_sml"><small>Save Huge</small> ON THIS SPECIAL<span></span></div>';
						$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special</a>';

					}
				}
				$active = '';
				if($x == 0){
					$active = 'active';
				}

				$c = 0;
				if($row->QUANTITY != 0){
					$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				}
				$fb = "postToFeed(".$row->ID.", '". ucwords(trim($this->clean_url_str($row->SPECIALS_HEADER, " ", " "))) ."','".trim($img)."', '".ucwords(trim($this->clean_url_str($row->SPECIALS_HEADER, " ", " "))) ." - My Namibia','".preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->shorten_string(strip_tags($this->clean_url_str($row->SPECIALS_CONTENT," "," ")), 50))))."', '".site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER))."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter');
				$tweet_url = 'https://twitter.com/share?url='.site_url('/').$this->clean_url_str($row->SPECIALS_HEADER).'&text='.trim(str_replace("'"," ",substr(strip_tags($row->SPECIALS_HEADER ) ,0, 100))).'&via=MyNamibia';

				$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
				$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
				$claim_btn = "<a href='javascript:void(0)' id='claim_btn_do'  class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";
				echo ' <div class="span3 white_box">
							'.$ribbon.'
							<div class="slideshow-block">
								<a href="#" class="link"></a>
								<ul class="cycle-slideshow">
									<li class=""vignette"><img alt="'.strip_tags($row->SPECIALS_HEADER).'" src="'.$img.'"/></li>
								</ul>
							</div>
							<div class="padding10">

								'.$price_l.'
								<span class="pull-right" style="margin-top:-55px">
									<a onClick="'. $fb.'" class="facebook"></a>
									'.anchor_popup('https://twitter.com/share?url='.trim($tweet_url), ' ', $tweet).'
								</span>
								<h4 class="upper na_script">'.$this->shorten_string($row->SPECIALS_HEADER, 8). '</h4>

								<div class="clearfix" style="height:5px;"></div>
								<div style="font-size:13px;margin-bottom:10px;width:100%;min-height:90px;max-height:150px; overflow:hidden;">'
								.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 10).'
								</div>
								<div class="clearfix"></div>
								<p>'.$btn.'</p>
								<div class="clearfix"></div>
							</div>
					  </div>
					  ';

				$x ++;
			}

			echo '
				</div>

				<script data-cfasync="false">

						function claim_deal(id){
								var x = $("#claim_btn_1"+id);
								x.html("'.$load_img.' Claiming...");

								$.ajax({
									type: "get",
									cache: false,
									url: "'.site_url('/').'deals/claim_deal/"+id ,
									success: function (data) {

									   $("#deal_msg_").html(data);


									}
								});

							}

						function claim_deal_1(id){
								var x = $("#claim_btn_1"+id);

								x.popover({  delay: { show: 100, hide: 3000 },
								 placement:"top",html: true,trigger: "manual",
								 title:"Are You Sure?", content:"Are you sure you want to Grab this deal? By clicking Yes -you will be charged according to the value of the deal! Payment instructions will follow in an e-mail shortly! <br /><br />'.$claim_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);
								 $("#claim_btn_do").attr("href", "javascript:claim_deal("+id+")");
						}

						function claim_deal_un(id){
								var x = $("#claim_btn"+id);

								x.popover({  delay: { show: 100, hide: 3000 },
								 placement:"top",html: true,trigger: "manual",
								 title:"Please register", content:"To claim this amazing deal please create a FREE account. Pay nothing and receive fantastic benefits. <br /><br />'.$register_btn.'"});
								x.popover("show");
								$("html, body").animate({
									 scrollTop: (x.offset().top - 300)
								 }, 300);


						}

				</script>

				';

		}

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BUSINESS DEALS 
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_deals($query, $advert = FALSE){
		

		$this->load->model('image_model'); 

		$this->load->library('thumborp');
		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 360;
		$height = 230;

		$l_width = 60;
		$l_height = 60;


		if($query == ''){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 24" ,FALSE);

		}else{


		}

		if($query->result()){
			echo '
				  <div id="fb-root"></div>
				  <div id="deal_msg_"></div> ';
			echo '<div id="deal_slider" class="">';
			$x = 0;
			foreach($query->result() as $row){

				if($row->SPECIALS_IMAGE_NAME == ''){


					$img = base_url('/').'img/user_blank.jpg';

				}else{

					$img_str = 'assets/deals/images/' . $row->SPECIALS_IMAGE_NAME;

					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

				}

				$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$row->SPECIALS_IMAGE_NAME."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER)."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);

				//PRICE
				$price = 'N$ '.$row->SPECIALS_PRICE.'';
				if($row->NORMAL_PRICE > 0){

					$price = 'N$ '.$row->SPECIALS_PRICE.' / was N$'.$row->NORMAL_PRICE;
				}

				$price_l = '<div class="price_label">'.$price.'</div>';
				//IF LOGGED IN
				if($this->session->userdata('id')){

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal'){
						//IF ALREADY CLAIMED
						if($this->is_deal_claimed($row->ID)){

							$btn = '
									<a id="claim_btn'.$row->ID.'"  class="btn pull-right btn-warning">
									<i class="icon-star-empty icon-white"></i> Deal Claimed
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px">
									View</a>';

						}else{
							$btn = '
									<a onclick="claim_deal_1('.$row->ID.');" href="javascript:void(0)" id="claim_btn_1'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> Grab Deal
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px"">
									View</a>';

						}
						$ribbon = '<div class="product_ribbon_sml"><small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span></div>';
						//NO DEAL
					}else{

						$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special </a>';


						$ribbon = '<small>Save Huge</small> ON THIS SPECIAL<span></span>';
					}



				}else{

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal')
					{
						$ribbon = '<small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span>';
						$btn = '<a onclick="claim_deal_un(' . $row->ID . ');" href="javascript:void(0)" id="claim_btn' . $row->ID . '"  class="btn pull-right btn-inverse">
										<i class="icon-star-empty icon-white"></i> Grab Deal
										</a>';

					}else{
						$ribbon = '<div class="product_ribbon_sml"><small>Save Huge</small> ON THIS SPECIAL<span></span></div>';
						$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special</a>';

					}
				}
				$active = '';
				if($x == 0){
					$active = 'active';
				}

				$c = 0;
				if($row->QUANTITY != 0){
					$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				}
				$fb = "postToFeed(".$row->ID.", '". ucwords(trim($this->clean_url_str($row->SPECIALS_HEADER, " ", " "))) ."','".trim($img_url)."', '".ucwords(trim($this->clean_url_str($row->SPECIALS_HEADER, " ", " "))) ." - My Namibia','".preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->shorten_string(strip_tags($this->clean_url_str($row->SPECIALS_CONTENT," "," ")), 50))))."', '".site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER))."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter');
				$tweet_url = 'https://twitter.com/share?url='.site_url('/').$this->clean_url_str($row->SPECIALS_HEADER).'&text='.trim(str_replace("'"," ",substr(strip_tags($row->SPECIALS_HEADER ) ,0, 100))).'&via=MyNamibia';

				$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
				$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
				$claim_btn = "<a href='javascript:void(0)' id='claim_btn_do'  class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";

				if ($x % 4 == 0) {
					$ad = '';
					if($advert){
						if($x != 0){
							$ad = '<div class="span3">'.$this->my_na_model->show_advert().'</div>';
						}
					}
					echo $ad.'
				   </div>
				   <div class="row">
				   ';
				}

				echo ' <div class="col-sm-12 col-md-6 col-lg-4 col-xl-4">
							<figure class="loader">
								<div class="product_ribbon_sml"><small style="color:#ff9900; font-size:14px">'.$ribbon.'</small>'.$price.'</div>
								<div class="slideshow-block">
									<a href=""><img alt="'.strip_tags($row->SPECIALS_HEADER).'" src="'.$img_url.'"/>
									'.$btn.'
								</div> 
							</figure>			
					  </div>
					  ';				

				/*echo ' <div class="span3 white_box">
							'.$ribbon.'
							<div class="slideshow-block">
								<a href="#" class="link"></a>
								<ul class="cycle-slideshow">
									<li class=""vignette"><img alt="'.strip_tags($row->SPECIALS_HEADER).'" src="'.$img.'"/></li>
								</ul>
							</div>
							<div class="padding10">

								'.$price_l.'
								<span class="pull-right" style="margin-top:-55px">
									<a onClick="'. $fb.'" class="facebook"></a>
									'.anchor_popup('https://twitter.com/share?url='.trim($tweet_url), ' ', $tweet).'
								</span>
								<h4 class="upper na_script">'.$this->shorten_string($row->SPECIALS_HEADER, 8). '</h4>

								<div class="clearfix" style="height:5px;"></div>
								<div style="font-size:13px;margin-bottom:10px;width:100%;max-height:150px;height:auto; overflow:hidden;">'
									.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 10).'
								</div>
								<div id="ctdwn_'.$row->ID.'"></div>
								<p class="clearfix">&nbsp;</p>
								<div class="clearfix"></div>
								<p>'.$btn.'</p>
								<div class="clearfix"></div>
							</div>
					  </div>
					  ';*/

				$x ++;

					/*echo '<script data-cfasync="false" type="text/javascript">
					    $(document).ready(function () {

							ctdwn_'.$row->ID.' = new Date('.date('Y',strtotime($row->SPECIALS_EXPIRE_DATE)).', '.(date('m',strtotime($row->SPECIALS_EXPIRE_DATE)) - 1).', ' .date('d',strtotime($row->SPECIALS_EXPIRE_DATE)).');
							$("#ctdwn_'.$row->ID.'").countdown({until: ctdwn_'.$row->ID.'});

						});

					  </script>';*/

			}
			echo '</div>';
			$fb_share_key = '';//$this->encrypt('fb_share');
			$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
			$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
			$claim_btn = "<a onclick='' href='javascript:void(0)' id='claim_btn_do' class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";
			echo ' <script data-cfasync="false" type="text/javascript">
  


					  
					  	function claim_deal_1(id){
							var x = $("#claim_btn_1"+id);
							
							//document.getElementById("claim_btn_do").onclick = function (){claim_deal(id);};
							x.popover({  delay: { show: 100, hide: 3000 },
							 placement:"top",html: true,trigger: "manual",
							 title:"Are You Sure?", content:"Are you sure you want to Grab this deal? By clicking Yes - you will be charged according to the value of the deal! Payment instructions will follow in an e-mail shortly! <br /><br />'.$claim_btn.'"});
							x.popover("show");
							$("html, body").animate({
								 scrollTop: (x.offset().top - 300)
							 }, 300);
							 $("#claim_btn_do").attr("href", "javascript:claim_deal("+id+")");
								
						}
						
						function claim_deal(id){
							var x = $("#claim_btn_1"+id);
							x.html("'.$load_img.' Claiming...");
							
							$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'deals/claim_deal/"+id ,
								success: function (data) {
								   
								   $("#deal_msg_").html(data);
								   
								      	
								}
							});	 
								
						}
					  function claim_deal_un(id){
							var x = $("#claim_btn"+id);
							
							x.popover({  delay: { show: 100, hide: 3000 },
							 placement:"top",html: true,trigger: "manual",
							 title:"Please register", content:"To claim this amazing deal please create a FREE account. Pay nothing and receive fantastic benefits. <br /><br />'.$register_btn.'"});
							x.popover("show");
							$("html, body").animate({
								 scrollTop: (x.offset().top - 300)
							 }, 300);
								 
								
						}

					  </script>';
			
			
		 }else{
			
				echo "<div class='alert' style='text-align:center'>
							  <h1>Ooops, no results found</h1>
							  <p>Sorry, there are no current deals up for grabs. Please come by later</p>
							  <p><img src='".base_url('/')."img/bground/my-na-700-silver.png' alt='My Namibia'/></p>
					  </div>
					  >
					  <div id='no_results'></div>
					  <script data-cfasync='false' type='text/javascript'>
					  
					  function reload(){
							
							var cont = $('#no_results');
							cont.html('');
							cont.addClass('loading_img');
							$.ajax({
								type: 'get',
								cache: false,
								url: '". site_url('/')."members/load_home_feed/0' ,
								success: function (data) {	
									
									cont.html(data).fadeIn('300');
									cont.removeClass('loading_img');
								}
							});	

						}
					  $(document).ready(function(){
					  	setTimeout(reload(), 1000);
						$('#deal_content').removeClass('loading_img');
					  });
					  </script>
					  "
					  
					  ;
			 
		 }
	
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BUSINESS DEALS BIG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function show_deals_big($query){


		//$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 5" ,FALSE);
		if($query->result()){
			echo '<link rel="stylesheet" type="text/css" href="'.base_url('/').'css/jquery.countdown.css">
				  <script data-cfasync="false" type="text/javascript" src="'.base_url('/').'js/jquery.countdown.min.js"></script>
				  <div id="fb-root"></div>
    			  <script src="https://connect.facebook.net/en_US/all.js"></script>
				  <div id="deal_msg_"></div>
				 ';

			foreach($query->result() as $row){

				if($row->SPECIALS_IMAGE_NAME == ''){

					$img = base_url('/').'img/user_blank.jpg';

				}else{

					$img = CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;

				}

				$blogo = '';
				//CYMOT
				if($row->BUSINESS_ID == '514'){

					$blogo = '<img src="'.base_url('/').'img/icons/cymot_logo.png" class="pull-right img-responsive" alt="Cymot Namibia Specials" width="100" title="Brought to you by Cymot" rel="tooltip"/>';
				}

				$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$img."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".$this->clean_url_str($row->SPECIALS_HEADER)."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
				//IF DEAL
				if($row->SPECIAL_TYPE == 'deal'){
					//IF ALREADY CLAIMED
					if($this->is_deal_claimed($row->ID)){

						$btn = '
									<a id="claim_btn'.$row->ID.'"  class="btn pull-right btn-warning">
									<i class="icon-star-empty icon-white"></i> Deal Claimed
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px">
									View</a>';

					}else{
						$btn = '
									<a onclick="claim_deal_1('.$row->ID.');" href="javascript:void(0)" id="claim_btn_1'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> Grab Deal
									</a><a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'"  class="btn btn-inverse pull-right" style="margin-right:5px"">
									View</a>';

					}
					$ribbon = '<div class="product_ribbon_sml"><small>Hurry up</small> SAVE N$ '.number_format($row->NORMAL_PRICE - $row->SPECIALS_PRICE).' TODAY<span></span></div>';
					//NO DEAL
				}else{

					$btn = '<a href="'.site_url('/').'deal/'.$row->ID.'/'.trim($this->clean_url_str($row->SPECIALS_HEADER)).'" id="claim_btn'.$row->ID.'"  class="btn pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> View Special</a>';


					$ribbon = '<div class="product_ribbon_sml"><small>Save Huge</small> ON THIS SPECIAL<span></span></div>';
				}


				$tweet_url = 'http://my.na/deal/'.$this->clean_url_str($row->SPECIALS_HEADER).'&text='.trim(str_replace("'"," ",substr(strip_tags($row->SPECIALS_HEADER . ' ' . $row->SPECIALS_CONTENT) ,0, 100))).'&via=MyNamibia';
				$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				echo '<div class="row-fluid">
							'.$ribbon.'
							<div class="span12  results_div">
							<div class="span8">
								<img class="lazy" src="'.base_url('/').'img/timbthumb.php?src='.$img.'&w=780&h=540&q=15" alt="'.strip_tags($row->SPECIALS_HEADER).'" data-original="'.$img.'" />
							</div>
							<div class="span4">
									<div style="width:100%;height:190px;">
									<div style="float:right;">
										<a onclick="'.$fb.'" class="facebook"></a>
										'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
									</div>
									<h1 style="font-size:50px;height:40px;color:#FF9F01;"><font style=" font-size:12px">N$</font>'.$row->SPECIALS_PRICE.'</h1>
									<h3 style="font-size:16px;line-height:20px;height:40px;">'.$row->SPECIALS_HEADER.'</h3>
									<div class="clearfix" style="height:5px;"></div>
									<div style="font-size:10px;">'.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 37).'</div>
									'.$blogo.'
									</div>
									<div class="clearfix" style="height:20px;"></div>
									<div  id="ctdwn_'.$row->ID.'"></div>
									<div class="clearfix" style="height:15px;"></div>
									<div class="progress progress-striped progress-warning" title="'.($row->QUANTITY - $this->count_claims($row->ID)).' Deals Available" rel="tooltip">
									  <div class="bar" title="'.$c.'% of the deals are taken" rel="tooltip" style="width:'.$c.'%"></div>
									</div>

									<div class="clearfix" style="height:20px;"></div>
									<a class="btn btn-warning" href="'.site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER).'/" > View Deal</a>
									'.$btn.'
									<div class="clearfix" style="height:20px;"></div>
								</div>
						</div>
					  </div>
					  ';

					/*<script data-cfasync="false" type="text/javascript">
					$(document).ready(function () {

						ctdwn_'.$row->ID.' = new Date('.date('Y',strtotime($row->SPECIALS_EXPIRE_DATE)).', '.(date('m',strtotime($row->SPECIALS_EXPIRE_DATE)) - 1).', ' .date('d',strtotime($row->SPECIALS_EXPIRE_DATE)).');
								$("#ctdwn_'.$row->ID.'").countdown({until: ctdwn_'.$row->ID.'});

							});

					  </script>*/
			}
			$fb_share_key = '';//$this->encrypt('fb_share');
			$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
			$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
			$claim_btn = "<a onclick='' href='javascript:void(0)' id='claim_btn_do' class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";
			echo ' <script data-cfasync="false" type="text/javascript">

						 $(document).ready(function(){

							$("[rel=tooltip]").tooltip();
							$("img.lazy").lazyload({
								  effect : "fadeIn",
								  skip_invisible : false
							});

						});

					  	function claim_deal_1(id){
							var x = $("#claim_btn_1"+id);

							//document.getElementById("claim_btn_do").onclick = function (){claim_deal(id);};
							x.popover({  delay: { show: 100, hide: 3000 },
							 placement:"top",html: true,trigger: "manual",
							 title:"Are You Sure?", content:"Are you sure you want to Grab this deal? By clicking Yes - you will be charged according to the value of the deal! Payment instructions will follow in an e-mail shortly! <br /><br />'.$claim_btn.'"});
							x.popover("show");
							$("html, body").animate({
								 scrollTop: (x.offset().top - 300)
							 }, 300);
							 $("#claim_btn_do").attr("href", "javascript:claim_deal("+id+")");

						}

						function claim_deal(id){
							var x = $("#claim_btn_1"+id);
							x.html("'.$load_img.' Claiming...");

							$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'deals/claim_deal/"+id ,
								success: function (data) {

								   $("#deal_msg_").html(data);


								}
							});

						}
					  function claim_deal_un(id){
							var x = $("#claim_btn"+id);

							x.popover({  delay: { show: 100, hide: 3000 },
							 placement:"top",html: true,trigger: "manual",
							 title:"Please register", content:"To claim this amazing deal please create a FREE account. Pay nothing and receive fantastic benefits. <br /><br />'.$register_btn.'"});
							x.popover("show");
							$("html, body").animate({
								 scrollTop: (x.offset().top - 300)
							 }, 300);


						}

					  </script>';


		}else{

			echo "<div class='alert' style='text-align:center'>
							  <h1>Ooops, no results found</h1>
							  <p>Sorry, there are no current deals up for grabs. Please come by later</p>
							  <p><img src='".base_url('/')."img/bground/my-na-700-silver.png' alt='My Namibia'/></p>
					  </div>
					  >
					  <div id='no_results'></div>
					  <script data-cfasync='false' type='text/javascript'>

					  function reload(){

							var cont = $('#no_results');
							cont.html('');
							cont.addClass('loading_img');
							$.ajax({
								type: 'get',
								cache: false,
								url: '". site_url('/')."members/load_home_feed/0' ,
								success: function (data) {

									cont.html(data).fadeIn('300');
									cont.removeClass('loading_img');
								}
							});

						}
					  $(document).ready(function(){
					  	setTimeout(reload(), 1000);
						$('#deal_content').removeClass('loading_img');
					  });
					  </script>
					  "

			;

		}

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+ADD DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function add_deal($bus_id){
		
		$deal_id = $this->input->post('deal_id',TRUE);
		$title = $this->input->post('deal_title',TRUE);
		$start = $this->input->post('dpstart',TRUE);
		$end = $this->input->post('dpend',TRUE);
		$cont = $this->input->post('deal_content',TRUE);
		$price = $this->input->post('price',TRUE);
		$price_u = $this->input->post('price_u',TRUE);
		$category = $this->input->post('deal_cat',TRUE);
		$quantity = $this->input->post('deal_quantity',TRUE);
		$deal_loc = $this->input->post('deal_loc',TRUE);
		$deal_email = $this->input->post('deal_email',TRUE);
		$special_type = $this->input->post('special_type',TRUE);
		$cymot_cat = $this->input->post('cymot_cat',TRUE);
		
		//IF NEW DEAL
		if($deal_id == '0'){
			//CYMOT
			$active = 'N';
			if($bus_id == 514){
				
				$active = 'Y';
			}
			
			//INSERT
			$insertdata = array(
				'BUSINESS_ID'=> $bus_id ,
				'SPECIALS_HEADER'=> $title ,
				 'SPECIALS_CONTENT'=> $cont,
				 'SPECIALS_PRICE'=> $price, 
				'SPECIALS_STARTING_DATE'=> $start,
				'SPECIALS_EXPIRE_DATE'=> $end,
				'SPECIAL_TYPE'=> $special_type,
				'NORMAL_PRICE'=> $price_u,
				'IS_ACTIVE' => $active,
				'CATEGORY_SUB_ID'=> $category,
				'CYMOT_CAT'=> $cymot_cat,
				'LOCATION' => $deal_loc,
				'EMAIL_INSTRUCTIONS' => $deal_email,
				'QUANTITY' => $quantity
			);
			
			$this->db->insert('u_special_component', $insertdata);
			
			//GET NEW DEAL ID
			$this->db->select_max('ID');
			$this->db->where('BUSINESS_ID',$bus_id);
			$query = $this->db->get('u_special_component');
			$row = $query->row_array();
			$deal_id =  $row['ID'];
			
			echo '<div class="alert alert-success">Deal saved</div>
			<script  data-cfasync="false" type="text/javascript">
				$("#btn_add_deal_img").fadeIn();
				$("#deal_id").val('.$deal_id.');
				$("#deal_id_deal_img").val('.$deal_id.');
				
				var x = $("#btn_add_deal_img");
						x.popover({  delay: { show: 100, hide: 3000 },
						 placement:"top",html: true,trigger: "manual",
						 title:"Add a Graphic", content:"Great, deal has been added. Please upload the deal graphic"});
						x.popover("show");
						$("html, body").animate({
							 scrollTop: (x.offset().top - 200)
						 }, 300);
			</script>'
			;
			
			
		}else{
			
			//UPDATE
			$insertdata = array(
				'BUSINESS_ID'=> $bus_id ,
				'SPECIALS_HEADER'=> $title ,
				 'SPECIALS_CONTENT'=> $cont,
				 'SPECIALS_PRICE'=> $price,
				 'SPECIAL_TYPE'=> $special_type,
				'SPECIALS_STARTING_DATE'=> $start,
				'SPECIALS_EXPIRE_DATE'=> $end,
				'NORMAL_PRICE'=> $price_u,
				'CATEGORY_SUB_ID'=> $category,
				'CYMOT_CAT'=> $cymot_cat,
				'LOCATION' => $deal_loc,
				'EMAIL_INSTRUCTIONS' => $deal_email,
				'QUANTITY' => $quantity
			);
			
			$this->db->where('ID', $deal_id);
			$this->db->update('u_special_component', $insertdata);

			echo '<div class="alert alert-success">Deal updated</div>
			<script  data-cfasync="false" type="text/javascript">
				$("#btn_add_deal_img").fadeIn();
				$("#deal_id").val('.$deal_id.');
				$("#deal_id_deal_img").val('.$deal_id.');
			
			</script>'
			;			
		}

		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SIDEBAR - LOOP THROUGH CATEGORIES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_sidebar(){
			
		//Get Main
		$main = $this->db->query("SELECT * FROM u_special_component JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID 
								WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW() GROUP BY u_special_component.CATEGORY_SUB_ID", TRUE);	
		
		echo '<div class="accordion" id="category_acc">';
			
		foreach($main->result() as $row){
		
			$main_id = $row->ID;
			$main_name = $row->CATEGORY_NAME;
			
			echo '<div class="accordion-group">
						<div class="accordion-heading">
						  <a class="accordion-toggle" style="text-decoration:none" data-toggle="collapse" data-parent="#category_acc" href="#cat'.$main_id.'">
							'.$this->shorten_string($main_name, 3).' 
						  </a>
				  </div>
				  <div id="cat'.$main_id.'" class="accordion-body collapse">
                      <div class="accordion-inner">
                        <table class="table table-hover">';
						$sub = $this->db->query("SELECT * FROM u_special_component WHERE CATEGORY_SUB_ID = '".$main_id."' AND IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW()", TRUE);
						$x = 0;
						foreach($sub->result() as $sub_row){
							if($sub_row->SPECIALS_IMAGE_NAME == ''){
					
								$img = base_url('/').'img/user_blank.jpg';
								
							}else{
								
								$img = CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
								
							}
							$sub_id = $sub_row->ID;
							$sub_name = $sub_row->SPECIALS_HEADER;
							$str = '';
							if($x == 0){
								$str = ' style="border:0"';	
							}
							echo '<tr>
									<td '.$str.'>
									<a style="text-decoration:none;height:100%;width:100%" href="'.site_url('/').'deal/'.$sub_id.'/'.$this->clean_url_str($sub_name).'/"><div>
										<img src="'.$img.'" class="img-polaroid pull-left" style="width:20px;height:20px;margin-right:10px;"> '.$this->shorten_string($sub_name ,5).'</div> 
									</a>
									</td>
								 </tr>';
							//echo '<li><a href="'.site_url('/').'a/cat/'.$sub_id.'/">'.$sub_name.'</a></li>';
							$x ++;
						}
				echo ' </table>
                      </div>
                    </div>
				  </div>';		
	
			
		}
		echo '</div>';
			
			
	}
	
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SINGLE DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_deal($deal_id){
			
		//Get Main
		$this->db->where('ID', $deal_id);
		$query = $this->db->get('u_special_component');
		if($query->result()){
			$row = $query->row();
			
			echo '<script type="text/javascript" src="'.base_url('/').'js/jquery.countdown.min.js"></script>
				  <div id="fb-root"></div>
    			  <script  src="https://connect.facebook.net/en_US/all.js"></script>
				  <div id="deal_msg_"></div>';
			if($row->SPECIALS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = CDN_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					
				}
				$blogo ='';
				//CYMOT
				if($row->BUSINESS_ID == '514'){

					$blogo = '<img src="'.base_url('/').'img/icons/cymot_logo.png" class="pull-right img-responsive" alt="Cymot Namibia Specials" width="100" title="Brought to you by Cymot" rel="tooltip"/>';
				}
				$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$img."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER)."')";
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);

				$ribbon = '';
				if($row->NORMAL_PRICE > 0 || $row->NORMAL_PRICE == null){

					$ribbon = '<div class="product_ribbon"><small>Hurry up</small> SAVE N$ '.number_format($row->SPECIALS_PRICE - $row->NORMAL_PRICE).' TODAY<span></span></div>';
				}else{

					$ribbon = '<div class="product_ribbon"><small>Hurry up</small> SAVE HUGE TODAY<span></span></div>';
				}
				//IF LOGGED IN
				if($this->session->userdata('id')){

					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal')
					{

						//IF ALREADY CLAIMED
						if ($this->is_deal_claimed($row->ID))
						{

							$btn = '<a id="claim_btn' . $row->ID . '"  class="btn btn-large pull-right btn-warning">
										<i class="icon-star-empty icon-white"></i> Deal Claimed
										</a>';

						}
						else
						{
							$btn = '<a onclick="claim_deal_1(' . $row->ID . ');" href="javascript:void(0)" id="claim_btn_1' . $row->ID . '"  class="btn btn-large pull-right btn-inverse">
										<i class="icon-star-empty icon-white"></i> Grab Deal
										</a>';

						}
					}else{

						$btn = '';

					}

				}else{
					//IF DEAL
					if($row->SPECIAL_TYPE == 'deal')
					{
						$btn = '<a onclick="claim_deal_un(' . $row->ID . ');" href="javascript:void(0)" id="claim_btn' . $row->ID . '"  class="btn btn-large pull-right btn-inverse">
									<i class="icon-star-empty icon-white"></i> Grab Deal
									</a>';
					}else{
						$btn = '';

					}
				}
				
				
				$tweet_url = site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER).'&text='.trim(str_replace("'"," ",substr(strip_tags($row->SPECIALS_HEADER . ' ' . $row->SPECIALS_CONTENT) ,0, 100))).'&via=MyNamibia';
				$c = 0;
				if($row->QUANTITY != 0){
					$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				}

				echo ''.$ribbon.'
						<div class="row-fluid">

							<div class="span12  white_box padding10">
								<div class="span8">
									<img src="'.$img.'" alt="" />
								</div>
								<div class="span4">
									<div style="width:100%;height:190px;">
									<div style="float:right;">
										<a onclick="'.$fb.'" class="facebook"></a>
										'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
									</div>
									<h1 style="font-size:50px;height:40px;color:#FF9F01;"><font style=" font-size:12px">N$</font>'.$row->SPECIALS_PRICE.'</h1>	
									<h3 style="font-size:16px;line-height:20px;height:40px;">'.$row->SPECIALS_HEADER.'</h3>
										<div class="clearfix" style="height:5px;"></div>
										<div style="font-size:10px;">'.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 40).'</div>
										'.$blogo .'
									</div>

									<div class="clearfix">&nbsp;</div>

									<div  id="ctdwn_'.$row->ID.'"></div>
									<div class="clearfix" style="height:15px;"></div>
									<div class="progress progress-striped progress-warning" title="'.($row->QUANTITY - $this->count_claims($row->ID)).' Deals Available" rel="tooltip">
									  <div class="bar" title="'.$c.'% of the deals are taken" rel="tooltip" style="width:'.$c.'%"></div>
									</div>
									
									<div class="clearfix" style="height:20px;"></div>
									'.$btn.'
									<div class="clearfix" style="height:50px;"></div>
								</div>
							</div>
						</div>	
					 
					  <script type="text/javascript">
					  $(function () {
							$("[rel=tooltip]").tooltip();
							ctdwn_'.$row->ID.' = new Date('.date('Y',strtotime($row->SPECIALS_EXPIRE_DATE)).', '.(date('m',strtotime($row->SPECIALS_EXPIRE_DATE)) - 1).', ' .date('d',strtotime($row->SPECIALS_EXPIRE_DATE)).');
							$("#ctdwn_'.$row->ID.'").countdown({until: ctdwn_'.$row->ID.'});
							
							var int=self.setInterval(function(){claimbar('.$row->ID.')},15000);
							function claimbar(id)
							{
							  $.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'deals/count_claims/"+id ,
								success: function (data) {
								   
								   $(".bar").css({
									   width: data+"%"});
								   
								      	
								}
							});	 
							  
							}
						});
						
					  </script>';
					$fb_share_key = '';//$this->encrypt('fb_share');
					$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
					$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
					$claim_btn = "<a onclick='claim_deal(".$row->ID.")' href='javascript:void(0)' id='claim_btn".$row->ID."' class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";
			echo ' <script type="text/javascript">
  
						

					  	
						function claim_deal_1(id){
							var x = $("#claim_btn_1"+id);
							
							x.popover({  delay: { show: 100, hide: 3000 },
							 placement:"top",html: true,trigger: "manual",
							 title:"Are You Sure?", content:"Are you sure you want to Grab this deal? By clicking Yes - you will be charged according to the value of the deal! Payment instructions will follow in an e-mail shortly! <br /><br />'.$claim_btn.'"});
							x.popover("show");
							$("html, body").animate({
								 scrollTop: (x.offset().top - 300)
							 }, 300);
								
						}

						
						function claim_deal(id){
							var x = $("#claim_btn_1"+id);
							x.html("'.$load_img.' Claiming...");
							
							$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'deals/claim_deal/"+id ,
								success: function (data) {
								   
								   $("#deal_msg_").html(data);
								   
								      	
								}
							});		
						}
					   function claim_deal_un(id){
							var x = $("#claim_btn"+id);
							
							x.popover({  delay: { show: 100, hide: 3000 },
							 placement:"top",html: true,trigger: "manual",
							 title:"Please register", content:"To claim this amazing deal please create a FREE account. Pay nothing and receive fantastic benefits. <br /><br />'.$register_btn.'"});
							x.popover("show");
							$("html, body").animate({
								 scrollTop: (x.offset().top - 300)
							 }, 300);
								 
								
						}
					  </script>';
			
		}else{
			
			
		}
		
		
			
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD DEAL IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function add_deal_img()
	{
		    $img = $this->input->post('userfile', TRUE);
			$deal_id = $this->input->post('deal_id_deal_img', TRUE);
			$bus_id = $this->input->post('bus_id_deal_img', TRUE);
			//CHECK IF NEW OR UPDATE
			if($deal_id != '0'){
				$this->db->where('ID', $deal_id);
				$query = $this->db->get('u_special_component');
				if($query->result()){
					
					$row = $query->row_array();
					
					$img_file = $row['SPECIALS_IMAGE_NAME'];
					
					if($img_file != ''){
						
							$file_large =  BASE_URL.'assets/deals/images/' . $img_file; # build the full path		
			
						   if (file_exists($file_large)) {
								unlink($file_large);
							}
					}
						
				}
			}
			//upload file
			
			$config['upload_path'] = BASE_URL.'assets/deals/images/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>'
           			 . $data['error'].'
       				 </div><script data-cfasync="false" type="text/javascript">
					 	$("#gal-cover").hide();
				    </script>'; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
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
						
						 $this->downsize_image($file);
								
				}


			   //populate array with values
				$data = array(
					
			     	'SPECIALS_IMAGE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID',$deal_id);
				$this->db->update('u_special_component',$data);

				//SEND TO BUCKET
				$this->load->model('gcloud_model');
				$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/deals/images/');


				$image = base_url('/') . 'assets/deals/images/'.$file;
			   //redirect 
			    $data['basicmsg'] = 'Graphic added successfully!';
				echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'. $data['basicmsg'].'
       				 </div>
					 <script data-cfasync="false" type="text/javascript">
					 show_deal_img("'.$deal_id.'");
					 </script>
					 ';
			
		}
	}	
	
	function show_deal_img($id)
	{
		$this->db->where('ID', $id);
		$query = $this->db->get('u_special_component');
		if($query->result()){
			
			$row = $query->row_array();
			
			$var = '<img src="'.CDN_URL.'assets/deals/images/'.$row['SPECIALS_IMAGE_NAME'].'" class="img-polaroid" style="width:95%;margin-bottom:20px"/>';
			return $var;
			
		}
		
	}	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DOWNSIZE DEAL IMAGE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file){
		$this->load->library('image_lib');
		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => (BASE_URL .'assets/deals/images/'. $file),
		   'master_dim' => 'auto',
		   'width' => '800',
		   'height' => '800',
		   'maintain_ratio' => true
		  ); 
		 
		 
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['gallmsg'] = $this->image_lib->display_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
	}
	
		
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN CYMOT DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function clean_cymot(){
		

		$deals = $this->db->query('SELECT * FROM `u_special_component` WHERE BUSINESS_ID = 514 AND SPECIALS_EXPIRE_DATE < NOW()');
		$x = 0;
		if($deals->result()){
		
				foreach( $deals->result_array() as $row){
			
						

						
						//DELETE IMAGE
						//$this->delete_deal_img($img_file);	
										
						$this->db->where('ID' , $row['ID']);
						$this->db->delete('u_special_component');
						$row['ID'] = NULL;	
						//ARCHIVE DEAL
						$this->db->insert('u_special_component_archive', $row);
						echo $row['SPECIALS_HEADER'] . '<br />';
						$x ++;
						$img_file = $row['SPECIALS_IMAGE_NAME'];
						$bus_id = $row['BUSINESS_ID'];
						
						echo
						'<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Deal archived successfully!</p>
						 </div>
						 <script data-cfasync="false" type="text/javascript">
							
						</script>';

				}
					//no existing deal	
	    }else{

			  echo
					  '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">×</button><p>Deal could not be archived!</p></div>
					   </div>
					   <script data-cfasync="false" type="text/javascript">

					  </script>';
	    }
		echo $x . 'Deals<br />';
	}	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function delete_deal(){
		
		$id = $this->input->post('deal_id',TRUE);
		
			$this->db->where('ID' , $id);
			$query = $this->db->get('u_special_component');
			
			if($query->result()){
				$row = $query->row_array();
				
				$img_file = $row['SPECIALS_IMAGE_NAME'];
				$bus_id = $row['BUSINESS_ID'];
				
				//DELETE IMAGE
				$this->delete_deal_img($img_file);	
									
				  $this->db->where('ID' , $id);
				  $this->db->delete('u_special_component');
				  echo 
				  '<div class="alert alert-success">
				  <button type="button" class="close" data-dismiss="alert">×</button><p>Deal deleted successfully!</p>
				   </div>
				   <script data-cfasync="false" type="text/javascript">
					  
				  </script>'; 
						
				
			//no existing deal	
			}else{
				
				echo 
						'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Deal could not be deleted!</p></div>
						 </div><script type="text/javascript">
							
						</script>'; 
			}			
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE DEAL IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function delete_deal_img($img_file){
		
							
		  $file_large =  BASE_URL.'assets/deals/images/' . $img_file; # build the full path		
  
				 if (file_exists($file_large)) {
					  unlink($file_large);
				  }

	}	
	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//PUBLISH DEAL
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function publish_deal($id){
		
		$this->load->model('email_model');
		
		$query = $this->db->query("SELECT * FROM `u_special_component` JOIN u_business on u_special_component.BUSINESS_ID 
		= u_business.ID WHERE u_special_component.ID = '".$id."'",FALSE);
		if($query->result()){
			
			$row = $query->row_array();
			$emailTO = 'roland@my.na';
			$emailFROM = $row['BUSINESS_EMAIL'];
			$name = $row['BUSINESS_EMAIL'];
			$subject = 'New Deal Published - '.$row['BUSINESS_NAME'];
			$body = 'Hi, <br /><br /> A new deal has been published by '.$row['BUSINESS_NAME'].'('.$row['BUSINESS_EMAIL'].'). Please review the deal and approve it in the Admin section. http://my.na/my_admin/
			
			<br /><br /><br />
			My Namibia Deals
			';
			
			
			$this->email_model->send_email($emailTO, $emailFROM , $name , $body , $subject );
			
			echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Deal will be reviewed and approved within 24 hours</p></div>
				  <script type="text/javascript">
							
				  </script>';
		}else{
			
			echo '<div class="alert">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Deal not found</p></div>
				  <script type="text/javascript">
							
				  </script>';
				
		}
		
		
	}
	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//GET DEAL DETAILS
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function get_deal_json($id){
		
		$this->db->where('ID', $id);
		$query = $this->db->get('u_special_component');
		$row = $query->row_array();
		
		$arr = array('method' => 'feed', 'redirect_uri' => 'http://my.na/index.php'	, 'link' => 'https://developers.facebook.com/docs/reference/dialogs/',
					 'picture' => 'http://fbrell.com/f8.jpg', 'name' => 'Facebook Dialogs', 'caption' => 'Reference Documentation', 'description' => 'Using Dialogs to interact with users.');
		return json_encode($arr);
	}
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//CLAIM DEAL
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function claim_deal($id){
		
		//CHECK SESSION
		if($this->session->userdata('id')){
		
			//TEST IF ALREADY CLAIMED THE DEAL
			$client_id = $this->session->userdata('id');
			$this->db->where('client_id',$client_id );
			$this->db->where('deal_id',$id);
			$query = $this->db->get('u_special_claims');
			if($query->num_rows() == 0){
				//GET QUANTITY AND NUMBER OF CLAIMS
				$query = $this->db->query("SELECT * FROM `u_special_claims` JOIN u_special_component 
										 ON u_special_component.ID = u_special_claims.deal_id WHERE 
										 u_special_claims.deal_id = '".$id."'", FALSE);
				if($query->result()){
					
					$row = $query->row_array();
					$count = $query->num_rows();
					$quantity = $row['QUANTITY'];
					$name = $row['SPECIALS_HEADER'];
					
				}else{
					
					$query = $this->db->query("SELECT * FROM `u_special_component` WHERE ID = '".$id."'", FALSE);
					$row = $query->row_array();
					$count = '0';
					$quantity = $row['QUANTITY'];
					$name = $row['SPECIALS_HEADER'];
				}
				
				//BUILD COUPON
				$coupon = $row['BUSINESS_ID'].'_'.$client_id .$quantity.'_'.$count;
				$data['deal_id'] = $id;
				$data['client_id'] = $client_id ;
				$data['coupon'] = $coupon;
				$deal_img = CDN_URL.'assets/deals/images/'.$row['SPECIALS_IMAGE_NAME'];
				$this->db->insert('u_special_claims', $data);
				
				//NA THE BUSINESS
				$query2 = $this->db->query("select * FROM u_business_na  
				           WHERE CLIENT_ID = '".$client_id."' AND BUSINESS_ID = '".$row['BUSINESS_ID']."'");
						   
				if($query2->num_rows() == 0){		   
						
						$data = array(
								
								'BUSINESS_ID' => $row['BUSINESS_ID'],
								'CLIENT_ID' => $client_id
							);
						
						$this->db->insert('u_business_na',$data);
						
				}
				
				//TEST DEAL QUANTITY
				$claimed = $this->db->query("select deal_id FROM u_special_claims
				           WHERE deal_id = '".$id."'");
				
						   
				if($claimed->num_rows() == $quantity){		   
						
						$qdata = array(
								
								'IS_ACTIVE' => 'N'
							);
						$this->db->where('ID',$id);
						$this->db->update('u_special_component',$qdata);
						
				}
				
				$this->sendDealNotifications($id, $row['BUSINESS_ID'], $client_id, $coupon, $deal_img, $name, $row['EMAIL_INSTRUCTIONS']);	
				
				$this->session->set_flashdata('msg','Deal Claimed, please check your inbox');
				
				echo '<div class="alert alert-block alert-success">
						<h3 class="na_script">Wohoo! Deal Claimed!</h4>
						You have justed claimed a deal. An email with further instructions has been sent to your inbox.
					  </div>
					 
					  <script data-cfasync="false" type="text/javascript">
					  setTimeout(load_home_feed, 4000);
					  $("#claim_btn'.$row['ID'].'").html("Deal Claimed");
					  $("html, body").animate({
						 scrollTop: ($("#deal_msg_").offset().top - 200)
					  }, 300);
					  </script>';	
				
			}else{
				
				$query = $this->db->query("SELECT * FROM `u_special_component` WHERE ID = '".$id."'", FALSE);
				$row = $query->row_array();
				echo '<div class="alert">Deal already claimed</div>
					  <script data-cfasync="false" type="text/javascript">
					  $("#claim_btn'.$row['ID'].'").html("Already Claimed");
					  </script>';		
			}
		//LOGOUT
		}else{
			echo '<div class="alert">Please Login</div>
					  <script data-cfasync="false" type="text/javascript">
					  window.location = "'.site_url('/').'members/logout/";
					  </script>';
			
		}
	}
	//+++++++++++++++++++++++++++
	//SEND DEAL CLAIM NOTIFICATIONS
	//++++++++++++++++++++++++++
    public function sendDealNotifications($deal_id, $bus_id, $client_id, $coupon, $deal_img, $name, $email_instructions)
    {
        //GET WINNER DETAILS
		$user = $this->getUser($client_id);
		
		//GET PROMOTION BUSINESS DETAILS
		$business = $this->getBusiness($bus_id);
		$img = $business['BUSINESS_LOGO_IMAGE_NAME'];
		if($img != ''){
		
			if(strpos($img,'.') == 0){
	
				$format = '.jpg';
				$img_str = S3_URL.'assets/business/photos/'.$img . $format;
				
			}else{
				
				$img_str =  S3_URL.'assets/business/photos/'.$img;
				
			}
		
		}else{
			
			$img_str = base_url('/').'img/bus_blank.png';	
			
		}
		
		$str = '';
		if(isset($email_instructions)){
			$str = '<h5>Special Instructions</h5>' .$email_instructions;
		}
		//SEND CLAIM DEAL EMAIL
		//build body
		$body = '
				Hi ' . $user['CLIENT_NAME'].', <br /><br />You have claimed this deal on My Namibia. Congratulations!
				<h4>'. $name.'</h4>
				<img src="'.$deal_img.'" alt="Download Images to view Deal" style="width:600px;margin-left:auto;margin-right:auto"/><br /><br /><br />
				Here is your unique coupon code which you will need to claim the deal from '. $business['BUSINESS_NAME'].'. <br /><br /><font style="text-align:center;font-size:22px;font-style:italic">'.
				$coupon . '</font>
				'.$str.'
				<br /><br />
				Have a !na day<br /><br /> <h3>'. $business['BUSINESS_NAME'].' 
				<img src="'.$img_str.'" alt="Download Images to view Deal" style="border:3px solid #666;margin-right:10px;width:120px;float:left" alt="'.$business['BUSINESS_NAME'].'"/></h3>
				<strong>P:</strong>'.$business['BUSINESS_TELEPHONE'].'<br /><strong>E:</strong>'.$business['BUSINESS_EMAIL']; 
		$emailTO = $user['CLIENT_EMAIL'];
		$name    = $user['CLIENT_NAME'];
		$emailFROM = $business['BUSINESS_EMAIL'];
		$subject = $user['CLIENT_NAME']. ' Here is your Deal';		
		
		$this->send_email($emailTO, $emailFROM , $name , $body , $subject );
		//INSERT INTO MESSAGES FOLDER
		$data_inbox['client_id'] = $client_id;
		$data_inbox['bus_id'] = $bus_id; 
		$data_inbox['bus_id_logo'] = $bus_id;
		$data_inbox['nameTO'] = $user['CLIENT_NAME'];
		$data_inbox['nameFROM'] = $business['BUSINESS_NAME'];
		$data_inbox['email'] = $business['BUSINESS_EMAIL'];
		$data_inbox['emailTO'] = $user['CLIENT_EMAIL'];
		$data_inbox['body'] = $body;
		$data_inbox['subject'] = $subject;
		$data_inbox['status'] = 'sent';
		$data_inbox['status_client'] = 'unread';
	   
		$this->db->insert('u_business_messages',$data_inbox);	
		
		//SEND CLAIM DEAL BUSINESS
		//build body
		$body1 = '
				Hi, <br /><br />'. ucwords($name).' at My Namibia has just claimed your deal '. $name.'. 
				<br /><br /><img src="'.$deal_img.'" alt="Download Images to view Deal" style="width:600px;margin-left:auto;margin-right:auto"/><br /><br /><br />
				Here is the unique coupon code which you will need to verify when '. $user['CLIENT_NAME'].' comes to claim his deal <br /><br /><font style="font-size:12px;font-style:italic">'.
				$coupon . '</font><br /><br /> You can contact the winner by replying to this email or by contacting them at <em>'.$user['CLIENT_EMAIL'].'</em> <br /><br />
				Have a !na day<br /><br /> My Namibia'; 
		$emailTO1 = $business['BUSINESS_EMAIL'];
		$name1    = $business['BUSINESS_NAME'];
		$emailFROM1 = $user['CLIENT_EMAIL'];
		$subject1 = $user['CLIENT_NAME']. ' has claimed your Deal';		
		
		$this->send_email($emailTO1, $emailFROM1 , $name1 , $body1 , $subject1 );
		
    }



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //HTML 
	function send_email($emailTO, $emailFROM , $name , $body , $subject )
	{
			$this->load->model('email_model');
			$this->email_model->send_email($emailTO, $emailFROM , $name , $body , $subject);
		
	}
	
	//+++++++++++++++++++++++++++
	//GET DEAL STATS
	//++++++++++++++++++++++++++
    public function deal_stats($deal_id)
    {
       $query = $this->db->query("SELECT u_client.ID, u_client.CLIENT_EMAIL,u_client.CLIENT_GENDER,u_client.CLIENT_OCCUPATION, u_special_claims.claim_id as claim_id, u_special_claims.coupon as COUPON, 
	   								u_special_claims.status as STATUS, u_special_claims.datetime as TIME,
									 u_client.CLIENT_CELLPHONE, CONCAT(u_client.CLIENT_NAME, ' ', u_client.CLIENT_SURNAME) as NAME, 
									u_client.CLIENT_PROFILE_PICTURE_NAME,IFNULL(u_client.CLIENT_DATE_OF_BIRTH,0) as DOB FROM u_client
									JOIN u_special_claims ON u_client.ID = u_special_claims.client_id
									WHERE u_special_claims.deal_id = '".$deal_id."'" ,FALSE);
		if($query->result()){
		  echo'<h3>Track Your Deal <small>A list of who has claimed the deal</small></h3>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="claim_list" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:25%">Full Name </th>
						<th style="width:10%;">Status</th>
						<th style="width:15%">Claim Code </th>
						<th style="width:15%">Grab Date </th>
						<th style="width:10%">DOB</th>
						
						<th style="width:20%; text-align:right">Action</th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$dob = '';
				if($row->DOB != '0'){
				
					$dob = date('Y-m-d',strtotime($row->STATUS));
				
				}
				$status = '<span class="badge badge-important" title="Not claimed" rel="tooltip">'.$row->STATUS.'</span>';
				if($row->STATUS == 'claimed'){
				
					$status = '<span class="label label-success" title="Claimed" rel="tooltip">'.$row->STATUS.'</span>';
				
				}
				$claimed = "'claimed'";$unclaimed = "'unclaimed'";
				echo '<tr>
						<td style="width:5%;min-width:40px"><img src="'.$this->get_avatar($row->ID).'" alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:25%">'.$row->NAME .'</td>
						<td style="width:10%;">'.$status. '</td>
						<td style="width:15%">'.$row->COUPON .'</td>
						<td style="width:15%">'.date('Y-m-d',strtotime($row->TIME)) .'</td>
						<td style="width:10%">'.$dob.'</td>
					  	<td style="width:20%; text-align:right">
						<a onclick="set_deal_status('.$row->claim_id.','.$claimed.')" id="claimed_'.$row->claim_id.'" href="javascript:void(0)" class="btn btn-mini btn-success" title="Mark as Claimed" rel="tooltip"><i class="icon-thumbs-up icon-white"></i> </a> 
						<a onclick="set_deal_status('.$row->claim_id.','.$unclaimed.')"  id="unclaimed_'.$row->claim_id.'" href="javascript:void(0)" class="btn btn-mini btn-danger"><i class="icon-thumbs-down icon-white"></i> </a>
						<a onclick="delete_claim('.$row->claim_id.')" id="delete_'.$row->claim_id.'" href="javascript:void(0)" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> </a>
						</td>
					  </tr>';
			
			}
			$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
			$tablestr = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:5px;"></div>
				
			    <script data-cfasync="false" type="text/javascript">
					$(document).ready(function(){   
						    $("[rel=tooltip]").tooltip();
							$("#claim_list").dataTable( {
									"sDom": "'.$tablestr.'",
									"sPaginationType": "bootstrap",
									"oLanguage": {
										"sLengthMenu": "_MENU_"
									},
									"aaSorting":[],
									"bSortClasses": false
			
							} );
					} );
					
					function set_deal_status(id, status){
							$("#"+status+"_"+id).html("'.$load_img.'");
							$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'deals/deal_status/"+id+"/"+status ,
								success: function (data) {
								   
								   $("#deal_msg_").html(data);
								   deal_stats('.$deal_id.');
								      	
								}
							});	 
							
								
					}	
					
					function delete_claim(id){
							$("#delete_"+id).html("'.$load_img.'");
							$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'deals/delete_claim/"+id+"/" ,
								success: function (data) {
								   
								   $("#deal_msg_").html(data);
								   deal_stats('.$deal_id.');
								      	
								}
							});	 
							
								
					}	
				</script>';
			
		}else{
			
			echo '<h4>Track Your Deal <small>A list of who has claimed the deal</small></h4>
				<div class="alert">
					<h4>Nobody has claimed the deal</h4> Nobody has claimed the deal up to this point</div>';
			
		}	
		
    }

	
	
	//+++++++++++++++++++++++++++
	//GET USER DETAILS
	//++++++++++++++++++++++++++
    public function getUser($id)
    {
        //GET WINNER DETAILS
		$this->db->where('ID',$id);
		$query = $this->db->get('u_client');
		return $query->row_array();
		
		
    }

	//+++++++++++++++++++++++++++
	//GET USER DETAILS
	//++++++++++++++++++++++++++
    public function getBusiness($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('ID',$id);
		$query = $this->db->get('u_business');
		return $query->row_array();
		
		
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
	//+++++++++++++++++++++++++++
	//SET DEAL STATUS
	//++++++++++++++++++++++++++
    public function set_deal_status($id, $str)
    {
        $data['status'] = $str;
		$this->db->where('claim_id',$id);
		$this->db->update('u_special_claims',$data);
		echo 'Deal updated';
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
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET USER AVATAR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_avatar($id){
		
		$this->db->select('ID , CLIENT_PROFILE_PICTURE_NAME as PIC');
		$this->db->where('ID',$id);
		$query = $this->db->get('u_client');
		$row = $query->row_array();
		
		if($row['PIC'] != '' || $row['PIC'] != NULL){
			
			//Build image string
			$format = substr($row['PIC'],(strlen($row['PIC']) - 4),4);
			$str = substr($row['PIC'],0,(strlen($row['PIC']) - 4));
			
			if(strpos($row['PIC'],'.') == 0){
	
				$format = '.jpg';
				$avatar = CDN_URL.'assets/users/photos/'.$row['PIC'] . $format;
				
			}else{
				
				$avatar =  CDN_URL.'assets/users/photos/'.$row['PIC'];
				
			}
			
			
		}else{
			
			$avatar = base_url('/').'img/user_blank.jpg';
			
		}
		
		return $avatar;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS CATEGORIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
    //Get Main Categories
	function get_main_categories(){
      	
		$test = $this->db->get('a_tourism_category');
		return $test;	  
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET CITIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
    //Get Main Categories
	function get_cities(){
      	
		$test = $this->db->get('a_map_location');
		return $test;	  
    }
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET ONLY KEWYWORD SEARCH
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
    
	function get_only_key($key ,$limit, $offset){

		$key = $this->db->escape_like_str($key);
		//MORE THAN 2 WoRDS
		if(str_word_count($key) > 1){
			
			$str1 = explode(" ", $key);
			//echo var_dump($str1);
			
			$str2 = '';
			$c = 0;
			foreach($str1 as $keys){
				if(count($str1) -1  == $c){
					$end = '';	
				}else{
					$end = ' AND ';	
					
				}
				$str2 .= " u_special_component.SPECIALS_CONTENT like '%".$keys."%' OR u_special_component.SPECIALS_HEADER like '%".$keys."%' ".$end;
				$c ++;	
			}
			$test = $this->db->query("SELECT * 
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() AND (". $str2."
							 OR a_tourism_category.CATEGORY_NAME like '%".$key."%') LIMIT ".$limit." OFFSET ".$offset."", TRUE);
							 
		}else{
			
		
			$test = $this->db->query("SELECT * 
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() AND (SPECIALS_CONTENT like '%".$key."%' 
							OR SPECIALS_HEADER like '%".$key."%'
							 OR a_tourism_category.CATEGORY_NAME like '%".$key."%') LIMIT ".$limit." OFFSET ".$offset."", TRUE);
			
		}
		
		return $test;	  
    }
	function Cget_only_key($key){
//MORE THAN 2 WoRDS
		if(str_word_count($key) > 1){
			
			$str1 = explode(" ", $key);
			//echo var_dump($str1);
			
			$str2 = '';
			$c = 0;
			foreach($str1 as $keys){
				if(count($str1) -1  == $c){
					$end = '';	
				}else{
					$end = ' AND ';	
					
				}
				$str2 .= " u_special_component.SPECIALS_CONTENT like '%".$keys."%' OR u_special_component.SPECIALS_HEADER like '%".$keys."%' ".$end;
				$c ++;	
			}
			$test = $this->db->query("SELECT * 
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() AND (". $str2."
							 OR a_tourism_category.CATEGORY_NAME like '%".$key."%') ", TRUE);
							 
		}else{
			
		
			$test = $this->db->query("SELECT * 
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() AND (SPECIALS_CONTENT like '%".$key."%' 
							OR SPECIALS_HEADER like '%".$key."%'
							 OR a_tourism_category.CATEGORY_NAME like '%".$key."%') ", TRUE);
			
		}
		
	  
		return $test->num_rows();	  
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET ONLY LOCATION SEARCH
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
   
	function get_only_location($location ,$limit, $offset){
      	
		$test = $this->db->query("SELECT * FROM u_special_component 
				JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW() AND (a_map_location.MAP_LOCATION like '%".$location."%') LIMIT ".$limit." OFFSET ".$offset."", TRUE);
		
		return $test;	  
    }
	function Cget_only_location($location){
      	
		$test = $this->db->query("SELECT u_special_component.IS_ACTIVE FROM u_special_component 
				LEFT JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW() AND (a_map_location.MAP_LOCATION like '%".$location."%')", TRUE);
		
		return $test->num_rows();		  
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET LOCATION AND KEY SEARCH
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
   
	function get_loc_key($location,$key ,$limit, $offset){
      	
		$test = $this->db->query("SELECT * FROM u_special_component 
				LEFT JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW() AND (u_special_component.SPECIALS_CONTENT like '%".$key."%' OR u_special_component.SPECIALS_HEADER like '%".$key."%') AND (a_map_location.MAP_LOCATION like '%".$location."%') LIMIT ".$limit." OFFSET ".$offset."", TRUE);
		
		return $test;	  
    }
	function Cget_loc_key($location,$key){
      	
		$test = $this->db->query("SELECT u_special_component.IS_ACTIVE FROM u_special_component 
				LEFT JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
				WHERE u_special_component.IS_ACTIVE = 'Y' AND u_special_component.SPECIALS_EXPIRE_DATE > NOW() AND (u_special_component.SPECIALS_CONTENT like '%".$key."%' OR u_special_component.SPECIALS_HEADER like '%".$key."%') AND (a_map_location.MAP_LOCATION like '%".$location."%')", TRUE);
		
		return $test->num_rows();		  
    }



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET DELAS PAGE BREADCRUMBS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function show_deals_breadcrumb($cat = '', $loc = '', $key = ''){
		
		echo '<li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'" itemprop="url"><span itemprop="title">My Namibia</span></a><span class="divider"></span></li>';

		if($cat == '' && $loc == '' && $key == ''){

			echo '<li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/" itemprop="url"><span itemprop="title">Deals</span></a></li>';
		}else{

			if($loc == ''){

				echo '<li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/" itemprop="url"><span itemprop="title">Deals</span></a><span class="divider"></span></li>';
			}else{

				echo '<li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/" itemprop="url"><span itemprop="title">Deals</span></a><span class="divider"></span></li>
				<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/" itemprop="url"><span itemprop="title">'.ucwords($loc).'</span></a></li>';
			}

		}



		/*if($cat != ''){

			echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'/"  itemprop="url"><span itemprop="title">'.$cat.'</span></a><span class="divider">/</span></li>';*/

			if($key != ''){
				if($loc != '' && $loc != 0)
				{
					echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/results/'.$key.'/0/"  itemprop="url"><span itemprop="title">'.$key.'</span></a><span class="divider">/</span></li>';

				}else{
					echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/results/'.$key.'/0/"  itemprop="url"><span itemprop="title">'.$key.'</span></a></li>';


				}

			}
			if($loc != '' && $loc != 0){

				echo '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'deals/results/'.$key.'/'.$loc.'"  itemprop="url"><span itemprop="title">in '.$loc.'</span></a></li>';


			}
		/*}*/


	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES FOR TYPEHEAD
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function load_category_typehead(){
      	
		$test = $this->db->query("SELECT u_special_component.SPECIALS_HEADER as name,u_special_component.SPECIALS_CONTENT as body, a_tourism_category.CATEGORY_NAME as cat 
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW()", TRUE);
							
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			
			$cat = $row->cat;
			$name = $row->name;
			$body = $row->body;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
			
			$body2 = strip_tags(mysql_real_escape_string ($body)); 
			$body1 = trim( preg_replace(
				"/[^a-z0-9']+([a-z0-9']{1,4}[^a-z0-9']+)*/i",
				" ",
				" $body2 "
			) );
			$body = preg_replace("/(\S+)\s/", "$1','", $body1);
				
			//$result .= "'".$cat."','".$name."','".$body."' ". $str;
			$result .= "'".$body."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES FOR TYPEHEAD
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function search_ajax_deal($key){
      	
		$key = $this->db->escape_like_str(urldecode($key));
		//MORE THAN 2 WoRDS
		if(str_word_count($key) > 1){
			
			$str1 = explode(" ", $key);
			//echo var_dump($str1);
			
			$str2 = '';
			$c = 0;
			foreach($str1 as $keys){
				if(count($str1) -1  == $c){
					$end = '';	
				}else{
					$end = ' AND ';	
					
				}
				$str2 .= " u_special_component.SPECIALS_CONTENT like '%".$keys."%' OR u_special_component.SPECIALS_HEADER like '%".$keys."%' ".$end;
				$c ++;	
			}
			$test = $this->db->query("SELECT u_special_component.ID as ID, u_special_component.SPECIALS_HEADER as NAME, u_special_component.SPECIALS_IMAGE_NAME as IMG
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() AND (". $str2."
							 OR a_tourism_category.CATEGORY_NAME like '%".$key."%') LIMIT 5 ", TRUE);
			
		}else{
			
			
			$test = $this->db->query("SELECT u_special_component.ID as ID, u_special_component.SPECIALS_HEADER as NAME, u_special_component.SPECIALS_IMAGE_NAME as IMG
							 FROM u_special_component
							 LEFT JOIN a_tourism_category ON u_special_component.CATEGORY_SUB_ID = a_tourism_category.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() AND (u_special_component.SPECIALS_CONTENT like '%".$key."%' OR u_special_component.SPECIALS_HEADER like '%".$key."%'
							 OR a_tourism_category.CATEGORY_NAME like '%".$key."%') LIMIT 5 ", TRUE);
		}
		
							
		if($test->result()){
		 		
				echo '<div style="padding:10px 10px 0px 10px"><table class="table table-striped table-hover">';
				$x = 0;
				foreach($test->result() as $row){
	
							if($row->IMG == ''){
					
								$img = base_url('/').'img/user_blank.jpg';
								
							}else{
								
								$img = CDN_URL.'assets/deals/images/'.$row->IMG;
								
							}
							$sub_id = $row->ID;
							$sub_name = $row->NAME;
							$str = '';
							if($x == 0){
								$str = ' style="border:0"';	
							}
							echo '<tr>
									<td '.$str.'>
									<a style="text-decoration:none;height:100%;width:100%;display:inline-block;" href="'.site_url('/').'deal/'.$sub_id.'/'.$this->clean_url_str($sub_name).'/"><div style="font-size:16px;color:#333;font-weight:bold">
										<img src="'.$img.'" class="img-polaroid pull-left" style="width:20px;height:20px;margin-right:10px"> '.$sub_name.'</div> 
									</a>
									</td>
								 </tr>';
							//echo '<li><a href="'.site_url('/').'a/cat/'.$sub_id.'/">'.$sub_name.'</a></li>';
							$x ++;
		
				}
				echo ' </table></div>';
			
		}
		
		
    }	
	
	//Get Main Categories
	function load_city_typehead(){
      	
		$test = $this->db->query("SELECT u_special_component.SPECIALS_HEADER as name, a_map_location.MAP_LOCATION as location 
							 FROM u_special_component
							 JOIN a_map_location ON u_special_component.LOCATION = a_map_location.ID
							 WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW()", TRUE);
		
		
		$result = 'var subjects_location = [';
		$x = 0;
		$result .= "'all of Namibia',";
		foreach($test->result() as $row){
			
			
			$cat = $row->location;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$cat."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
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
	
/**
++++++++++++++++++++++++++++++++++++++++++++
//ENCODING ENCRYPTION 
//Functions
++++++++++++++++++++++++++++++++++++++++++++ */	
 

	public  function decrypt($string) {
		$this->load->library('encrypt');
        $data =  str_replace('_-_','/', str_replace('-_-','+', str_replace('-a-','=',($this->encrypt->decode($string)))));
		//$data =  $this->encrypt->decode($string);
        return $data;
    }
	public  function encrypt($string) {
        $this->load->library('encrypt');
		
		$data = str_replace('/','_-_',  str_replace('+','-_-',  str_replace('=','-a-',($this->encrypt->encode($string)))));
		//$data = $this->encrypt->encode($string);
        return $data;
    }


	function connect_ext_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'ntouchim_admin';
		$config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
		$config_db['database'] = 'ntouchim_debmarine';
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
?>