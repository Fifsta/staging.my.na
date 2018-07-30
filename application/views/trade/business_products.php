 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){ 
 
	 $header['title'] = strip_tags($heading) . ' - My Namibia';
	 $header['metaD'] = strip_tags($heading). '. Find ' . strip_tags($heading) .' online - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = '';
	 $header['metaD'] = '';
	 $header['section'] = '';
	 
 }
 $this->load->view('inc/header', $header);
  
 //GET BUSINESS DETAILS
 $name =  $bus_details['BUSINESS_NAME'];
 $email = $bus_details['BUSINESS_EMAIL'];
 $tel = '+'.$bus_details['TEL_DIAL_CODE'] . $bus_details['BUSINESS_TELEPHONE'];
 $fax = '+'.$bus_details['FAX_DIAL_CODE'] . $bus_details['BUSINESS_FAX'];
 $cell = '+'.$bus_details['CEL_DIAL_CODE'] . $bus_details['BUSINESS_CELLPHONE'];
 $description = $bus_details['BUSINESS_DESCRIPTION'];
 $pobox = $bus_details['BUSINESS_POSTAL_BOX'];
 $website = $bus_details['BUSINESS_URL']; 
 $address = $bus_details['BUSINESS_PHYSICAL_ADDRESS'];
 $startdate = $bus_details['BUSINESS_DATE_CREATED'];
 $vt = $bus_details['BUSINESS_VIRTUAL_TOUR_NAME'];
 $advertorial = $bus_details['ADVERTORIAL'];
 $img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];
 $rand = rand(0,9999); 

$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
$width = 800;

$height = 450;

 if($img != ''){
		
		if(strpos($img,'.') == 0){
	
			$format = '.jpg';
			$img_str = 'assets/business/photos/'.$img . $format;
			$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
			
		}else{
			
			$img_str = 'assets/business/photos/'.$img;
			$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
			
		}
		
 }else{
		
		$img_url = base_url('/').'images/bus_blank.png';	
		
 }

//COVER IMAGE
$cover_img = $bus_details['BUSINESS_COVER_PHOTO'];

if($cover_img != ''){
	
	if(strpos($cover_img,'.') == 0){

		$format2 = '.jpg';
		$cover_str = 'assets/business/photos/'.$cover_img . $format2;
		$cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory,$cover_str,$width,$height, $crop = '');
		
	}else{
		
		$cover_str =  'assets/business/photos/'.$cover_img;
		$cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory,$cover_str,$width,$height, $crop = '');
		
	}
	
}else{
	
	$cover_url = base_url('/').'images/business_cover_blank.jpg';	
	
}
 	 
 $UAtel = 'href="javascript:void(0)"';
 $UAcell = 'href="javascript:void(0)"';
 if($this->agent->is_mobile()){
	
	$UAtel = 'href="tel:'.substr($tel,0,8).substr($tel,8,strlen($tel)).'"';
	$UAcell = 'href="tel:'.substr($cell,0,8).substr($cell,8,strlen($cell)).'"';
 }
 
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 <style type="text/css">
 .white_box{
	 
	-webkit-transition: margin 100ms ease-in-out;
    -moz-transition: margin 100ms ease-in-out;
    -o-transition: margin 100ms ease-in-out;
	 
 }
 
 #deal_content  .white_box:hover{

	margin-top:-2px;


    -moz-box-shadow:      0 0 10px #000;
	-webkit-box-shadow:  0 0 10px #000;
	box-shadow:         0 0 10px #000;
	
	 
 }
 
 
 </style>
 <link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
</head>
<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
	<div class="container">
		<ol class="breadcrumb">
		   <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>" itemprop="url"><span itemprop="title">My</span></a></li>
		   <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>a/show/all/all/all/none/" itemprop="url"><span itemprop="title">Businesses</span></a> </li>
		   <li class="breadcrumb-item active"><?php echo $name;?></li>
		</ol>
	</div>
</nav>

<div class="container">

	<div class="row">

	    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">

	      <?php $this->load->view('inc/login'); ?>
	      <?php $this->load->view('inc/weather');?>
	      <?php $this->load->view('inc/adverts');?>

	    </div>

	    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-9 order-md-1 order-sm-2">

	    	<section id="listing">

		        <div class="heading" style="margin-bottom:15px">
		          <h2 data-icon="fa-briefcase"><?php echo $name; ?></h2>
		          <ul class="options">    
		            <li><a href="#" data-icon="fa-facebook text-dark"></a></li>
		            <li><a href="#" data-icon="fa-twitter text-dark"></a></li>
		            <li><a href="#" data-icon="fa-bookmark text-dark"></a></li>
		          </ul>
		        </div>

				<!--banner-->
		        <div class="list-map">
		          <div class="list-map-left" style="background:#ccc; position:relative">
		              <div class="asso static-banner">
						<?php if($bus_details['IS_NTB_MEMBER'] == 'Y'){ ?>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/ntb.png"></a>
						<?php } ?>

						<?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/han.png"></a>
						<?php } ?>
		              </div>
		              <img src="<?php echo $cover_url; ?>" class="img-fluid">
		          </div>
		          
		          <div class="list-map-right" id="map_container">
		          	<iframe src="<?php echo site_url('/'); ?>business/load_business_map/<?php echo $bus_id; ?>" frameborder="0" allowtransparency="true"></iframe>
		          </div>
		        </div>
		        <!--banner-->

				<!--details-->
				<div class="details">
					<div class="details-left">
						<figure>
							<a href="<?php echo site_url('/') . 'b/' . $bus_id . '/' . $this->trade_model->encode_url($name) . '/'; ?>"><img src="<?php echo $img_url; ?>"></a>
							
						</figure>

						<div style="" class="text-center"><?php echo $this->business_model->get_review_stars_show($rating,$bus_id);?></div>
						 
					</div>
					<div class="details-right">
						<h2><?php echo $address ;?><a href="#" data-toggle="tooltip" title="Find out more about getting featured"><span>Featured</span></a></h2>
						<div itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                             <span itemprop="street-address"><i class="fa fa-map-marker text-dark"></i> <?php echo $address ;?></span>
                         </div>
                         <?php 
						 echo '<p>'. implode(' ',$cats['links']).'</p>';
						 ?>
						<div class="row reveal">
							<div class="col-sm-12 col-md-6 col-lg-4">
								<p data-icon="fa-phone text-dark"><button onClick="phone_click('phone')" class="btn btn-default"><!--T: --><span><?php echo $tel; ?></span></button></p>
								<p data-icon="fa-fax text-dark"><button onClick="phone_click('fax')" class="btn btn-default"><!--F: --><span><?php echo $fax; ?></span></button></p>								
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<p data-icon="fa-tablet text-dark"><button onClick="phone_click('cell')" class="btn btn-default"><!--C: --><span><?php echo $cell; ?></span></button></p>
								<p data-icon="fa-envelope text-dark"><button class="btn btn-default"><!--E: --><span><?php echo $email; ?></span></button></p>								
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<?php if($website) { ?>
								<p data-icon="fa-globe text-dark"><button class="btn btn-default"><!--W: --><a href="<?php echo $website; ?>" target="blank"><span><?php echo $website; ?></span></a></button></p>
								<?php } ?>
							</div>							
						</div>
					</div>
				</div>
				<!--details-->

	    	</section>	

	    	<?php if(!$business){ ?>
	        <!--tabs-->
	        <ul class="nav nav-tabs" role="tablist">
	          <li class="nav-item" role="presentation"><a href="#Contact-Agent" class="nav-link active" aria-controls="Contact-Agent" role="tab" data-toggle="tab" data-icon="fa fa-envelope-o text-light">Contact Agent</a></li>
	        </ul>
	        <div class="tab-content">
	          <section role="tabpanel" class="tab-pane active" id="Contact-Agent">

	            <?php $this->trade_model->show_company($bus_id, $agent_id, $sub_cat_id = 0); ?>

	          </section>
	        </div>
	        <?php } ?>
	          
	    	<div class="spacer"></div>

	        <section id="products">
	          
	        <div class="heading" style="margin-bottom:15px">
	          <h2 data-icon="fa-briefcase"><?php echo $title;?></h2>
	          <ul class="options">    
	          </ul>
	        </div>

	         <div class="col-md-12">

	            <div id="deal_content">

	              <?php 
	              /*Search Results
	              Loop through the search results in the query array
	              */  

	              $this->trade_model->get_agency_products($bus_id, $query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 15, $offset = 0, $title = '',$amt = 4, $advert = FALSE, $pages = '');
    
	              ?> 

	            </div>   

	            <?php 
	              //LOAD PAGINATION
	              if(isset($pages)){ echo $pages; } 
	            ?>    

	            <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
	                  
	         </div>

	        </section>


		</div>
	</div>	
</div>
<div class="spacer"></div>	
	
<?php $this->load->view('inc/footer');?>	

<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
<script src="<?php echo base_url('/');?>js/jquery.rating.pack.js" type="text/javascript"></script> 

<script type="text/javascript">
	$(document).ready(function(){
		$('[rel=tooltip]').tooltip();

	
		
		$('.my_na_c').addClass('loading_img');
	    //load_similar();
		my_na(<?php echo $bus_id;?>);
		
	});



	function initiate_rating(){
		
		$.getScript("<?php echo base_url('/')?>js/jquery.rating.pack.js", function(){
			 
		 	$("input .star").rating();
		 
		});
		
	}

	function initiate_pagination(){
		
		//PAGINATION
		$('div.pagination ul li a').bind('click', function(e){
			
			e.preventDefault();
			var pre = $('#pre_loader');
			pre.removeClass('hidden');
			$('div.pagination ul').find('li.active').removeClass('active');
			$(this).closest( "li" ).addClass('active');
			$.ajax({
					 url: $(this).attr('href'),
					 success: function(data) {
						 pre.addClass('hidden');
						 $("#deal_content").append(data);
						 //initiate_slides();
					}
			 });
			
			
		});
		
	}
	
	
	function my_na(id){
			
			var n = $('#'+id);
			var place = 'left';  
			$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'business/my_na/';?>'+id+'/'+place+'/' ,
				success: function (data) {	
					
					n.html(data);
					$('[rel=tooltip]').tooltip();
					my_na_effect(id);
					n.removeClass('loading_img');
				}
			});	
			
	}
	
	function my_na_yes(id){
			
			var n = $('#'+id);
			n.find(".my_na").hide();
			n.addClass('loading_img');
			n.popover('destroy');
	
			var place = 'left'; 
			$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'business/my_na_click/';?>'+id+'/'+place+'/' ,
				success: function (data) {	
					
					n.html(data);
					$('[rel=tooltip]').tooltip();
					my_na_effect(id);
					n.removeClass('loading_img');
					n.find(".my_na").show();
				}
			});	
	
	}
	
	function my_na_effect(id){
		
			$(function() {
				$("#"+id)
				.find("span")
				.hide()
				.end()
				.hover(function() {
					$(this).find("span").stop(true, true).fadeIn();
					
				}, function(){
					$(this).find("span").stop(true, true).fadeOut();
					
				});
			});	
		
	}
	function phone_click(type){
			
			//var num = n.find('font');
			//num.slideDown();
			 
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'business/add_business_phone_click/'.$bus_id.'/';?>'+type ,
				success: function (data) {	
					
				}
			});	
	
	}
       
</script>

	
</body>
</html>
