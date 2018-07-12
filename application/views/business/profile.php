<?php 

$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
$width = 826;

$height = 466;

if(!$bus_details){ show_404(); }

$bus_id =  $bus_details['ID'];
$name =  $bus_details['BUSINESS_NAME'];
$email = $bus_details['BUSINESS_EMAIL'];
$tel = '+'.$bus_details['TEL_DIAL_CODE'].' '.$bus_details['BUSINESS_TELEPHONE'];
$fax = '+'.$bus_details['FAX_DIAL_CODE'].' '.$bus_details['BUSINESS_FAX'];
$cell = '+'.$bus_details['CEL_DIAL_CODE'].' '.$bus_details['BUSINESS_CELLPHONE'];
$description = $bus_details['BUSINESS_DESCRIPTION'];
$pobox = $bus_details['BUSINESS_POSTAL_BOX'];
$website = $bus_details['BUSINESS_URL']; 
$address = $bus_details['BUSINESS_PHYSICAL_ADDRESS'];
$city = $bus_details['city']; 
$region = $bus_details['region'];
$latitude = $bus_details['latitude']; 
$longitude = $bus_details['longitude'];
$startdate = $bus_details['BUSINESS_DATE_CREATED'];
//$city = $bus_details['CLIENT_CITY'];
$img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];
$vt = $bus_details['BUSINESS_VIRTUAL_TOUR_NAME'];
$advertorial = $bus_details['ADVERTORIAL'];
//Get categories
$cats = $this->business_model->get_current_categories($bus_id);
$rand = rand(0,9999);
//Build image string
$format = substr($img,(strlen($img) - 4),4);
$str = substr($img,0,(strlen($img) - 4));


if($img != ''){
	
	if(strpos($img,'.') == 0){

		$format = '.jpg';
		$img_str = 'assets/business/photos/'.$img . $format;
		$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
		
	}else{
		
		$img_str = 'assets/business/photos/'.$img;
		$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
		
	}
	
}else{
	
	$img_str =  'assets/business/photos/logo-placeholder.jpg';
	$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
	
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
	
	$cover_str =  'assets/business/photos/listing-placeholder.jpg';
	$cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');
	
}


$header['title'] = $name. ' - My Namibia';
$header['metaD'] =  strip_tags(implode(' ',$cats['links'])) . ' - ' .$name. ' - a business listed on My Namibia';
$header['section'] = 'home';
 
//BUILD OPEN GRAPH
$header['og'] ='
<meta property="fb:app_id" content="287335411399195"> 
<meta property="og:type"        content="MyNamibia:business"> 
<meta property="og:url"         content="'.site_url('/').'b/'.$bus_id.'/'.$this->uri->segment(3).'/"> 
<meta property="og:title"       content="'.$header['title'].'"> 
<meta property="og:description" content="'.$header['metaD'].'"> 
<meta property="og:image"       content="'.$img_url.'">'; 

$this->load->view('inc/header');

?>

<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/> 

</head>

<body id="top"> 

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
	<div class="container">
		<ol class="breadcrumb">
		   <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>"  itemprop="url"><span itemprop="title">My</span></a></li>
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
		            <li><a href="#Enquiry-Form" data-icon="fa-envelope text-dark">Contact Agency</a></li>
		            <li><a href="#Gallery" data-icon="fa-file-image-o text-dark" onClick="load_gallery();">Gallery</a></li>
		            <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
		            <li><a href="#QR" data-icon="fa-qrcode text-dark">QR Code</a></li>
		          </ul>
		        </div>

				<!--banner-->
		        <div class="list-map">
		          <div class="list-map-left">
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
							<img src="<?php echo $img_url; ?>">
						</figure>
						<div style="" class="text-center"><?php echo $this->business_model->get_review_stars_show($rating,$bus_id);?></div>	
				 
					</div>
					<div class="details-right">
						<h2><?php echo $address ;?></h2>
						<div itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                            <span itemprop="street-address"><i class="fa fa-map-marker text-dark"></i> <?php echo $address ;?></span>
                            <span itemprop="locality"><?php echo $city ;?></span>
                            <span itemprop="region"><?php echo $region ;?></span>
                            <span itemprop="country-name">Namibia</span>
                        </div>
                        <?php
							echo '<p>'. implode(' ',$cats['links']).'</p>';
						?>
						<div class="row reveal">
							<div class="col-sm-12 col-md-6 col-lg-4">
								<p data-icon="fa-phone text-dark"><button class="btn btn-default"><!--T: --><?php echo $tel; ?></button></p>
								<p data-icon="fa-fax text-dark"><button class="btn btn-default"><!--F: --><?php echo $fax; ?></button></p>								
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<p data-icon="fa-tablet text-dark"><button class="btn btn-default"><!--C: --><?php echo $cell; ?></button></p>
								<p data-icon="fa-envelope text-dark"><button class="btn btn-default"><!--E: --><?php echo $email; ?></button></p>								
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<?php if($website) { ?>
								<p data-icon="fa-globe text-dark"><button class="btn btn-default"><!--W: --><?php echo $website; ?></button></p>
								<?php } ?>
							</div>							
						</div>

						<?php if($bus_details['IS_NTB_MEMBER'] == 'Y'){ ?>
							<a href="#" data-toggle="tooltip" data-placement="top" title="NTB Member"><img src="images/ntb.png" alt="<?php echo $name;?> - NTB Member" class="img-thumbnail"></a>
						<?php } ?>

						<?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
							<a href="#" data-toggle="tooltip" data-placement="top" title="HAN Member"><img src="images/han.png" alt="<?php echo $name;?> - HAN Member" class="img-thumbnail"></a>
						<?php } ?>

					</div>
				</div>
				<!--details-->

				<div class="spacer"></div>

				<!--tabs-->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="nav-item"><a href="#About" class="nav-link active" aria-controls="About" role="tab" data-toggle="tab" data-icon="fa-info"><span class="d-sm-none">About</span></a></li>
					<li role="presentation" class="nav-item"><a href="#Enquiry-Form" class="nav-link" aria-controls="Enquiry-Form" role="tab" data-toggle="tab" data-icon="fa-envelope-o"><span class="d-sm-none">Enquiry Form</span></a></li>
					<!--<li role="presentation" class="nav-item"><a href="#Deals" class="nav-link" aria-controls="Deals" role="tab" data-toggle="tab" data-icon="fa-certificate text-dark">Deals</a></li>-->
					<li role="presentation" class="nav-item"><a href="#Gallery" onClick="load_gallery();" class="nav-link" aria-controls="Gallery" role="tab" data-toggle="tab" data-icon="fa-file-image-o"><span class="d-sm-none">Gallery</span></a></li>
					<?php if($vt != ''){ ?>
					<li role="presentation" class="nav-item"><a href="#VT" onClick="load_vt();" class="nav-link" aria-controls="VT" role="tab" data-toggle="tab" data-icon="fa-refresh"><span class="d-sm-none">Virtual Tour</span></a></li>
					<?php } ?>
					<li role="presentation" class="nav-item"><a href="#QR" class="nav-link" aria-controls="QR" role="tab" data-toggle="tab" data-icon="fa-qrcode"><span class="d-sm-none">QR Code</span></a></li>
				</ul>
				<div class="tab-content">
					<section role="tabpanel" class="tab-pane active" id="About">
						<h2 class="tab-head">About</h2>
						<p id="b-about"><?php echo $description; ?></p>

					</section>
					<section role="tabpanel" class="tab-pane" id="Enquiry-Form">
						<?php $this->load->view('business/inc/business_contact_inc', $bus_details);?>
					</section>

					<section role="tabpanel" class="tab-pane" id="VT">
						<h2 class="tab-head">Virtual Tour</h2>
						<div class="row" id="virtual_tour">
						</div>
					</section> 

					<section role="tabpanel" class="tab-pane" id="Gallery">
						<h2 class="tab-head">Gallery</h2>
						<div class="row" id="bus_gallery">
							<?php //$this->business_model->show_gallery($bus_id);?>
						</div>
					</section>

					<section role="tabpanel" class="tab-pane" id="QR">
						<h2 class="tab-head">QR Code</h2>
						<div class="row"> 
							<div class="col-lg-4 col-md-8 col-sm-12 col-xs-12">
								<?php echo $this->business_model->get_qr_vcard($bus_id,'220','220');?> 
							</div>
						</div>
					</section>				


				</div>
				<!--tabs-->

				<div class="spacer"></div>
				
				<!--tabs-->
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="nav-item"><a href="#Reviews" class="nav-link active" aria-controls="Reviews" role="tab" data-toggle="tab" data-icon="fa-star-o"><span class="d-sm-none">Reviews</span></a></li>
					<li role="presentation" class="nav-item"><a href="#Submit-Review" class="nav-link" aria-controls="Submit-Review" role="tab" data-toggle="tab" data-icon="fa-star"><span class="d-sm-none">Submit Review</span></a></li>
				</ul>
				<div class="tab-content">
				
					<section role="tabpanel" class="tab-pane active" id="Reviews">
						<!--<h2 class="tab-head">Awards</h2>
						<div class="row">
							<div class="alert alert-warning">
								<h4><strong>No Reviews Added</strong></h4>
								No Reviews have been added for the current product.
							  </div>
						</div>-->
						
						<h2 class="tab-head">Reviews</h2>
						<?php echo $this->rating_model->show_reviews($bus_id);?>

					</section>
					
					<section role="tabpanel" class="tab-pane" id="Submit-Review">
						<?php $this->rating_model->rate_business($bus_id);?>
					
					</section>
					
				</div>
				<!--tabs-->

	    	</section>	

			<?php if($query->result()){ ?>

				<div class="spacer"></div>

				<section>
					<div class="heading">
						<h2 data-icon="fa-newspaper-o">Business <strong>Product Listings</strong></h2>
					</div>
					<div id="products_div">
						<?php echo $this->product_model->get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 15, $offset = 0, $title = '',$amt = 4, $advert = FALSE); ?>
					</div> 
				</section>

			<?php } ?>

			<div class="spacer"></div>

			<section>
				<div class="heading">
					<h2 data-icon="fa-newspaper-o">Similar <strong>Business Listings</strong></h2>
				</div>
				<div id="similar_div">

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


		$('#b-about img').addClass('img-fluid');

		$("a.fancy-images").fancybox({
			'transitionIn'	:	'elastic',
			'transitionOut'	:	'elastic',
			'speedIn'		:	600, 
			'speedOut'		:	200, 
			'overlayShow'	:	false,
			'cyclic'		:   true,
			'showNavArrows'	:   true
		});

		
		$('.redactor').redactor({ 	
				
			buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
			'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
			'alignment', '|', 'horizontalrule']

		});
		
		
		$('[rel=tooltip]').tooltip();
		//$('.carousel').carousel();
		
		
		//$(".my_na").popover({ placement:"left",trigger: "hover", title:"tebhdjsbdjsbd", content:"shnaksbnjkabnsabnsksbnkabns"});  
		$('.my_na_c').addClass('loading_img');

	    load_similar();


		$('.popovers').popover({
			placement : 'right',
			html : true,
			trigger : 'hover', //<--- you need a trigger other than manual
			delay: { 
			   show: "500", 
			   hide: "100"
			},
			content: function() {
			
				return $(this).find('span.popover-content').html();
			}
		});
		
	});


	function load_similar(){
		
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'business/load_similar/'.$bus_id.'/';?>' ,
			success: function (data) {

				 $('#similar_div').html(data);
 
				 initialise_owl();

			}
		});	
	 
	}


	/*function load_deals(){

		var x = $('#deals_inc');
		x.addClass('loading_img');	

		$.ajax({
			type: 'get',
			url: '<?php //echo site_url('/').'business/show_business_deal/'.$bus_id.'/';?>' ,
			success: function (data) {
				
				 x.html(data);
				
			}
		});	

	}*/


	function load_vt() {

		var x = $('#virtual_tour');
		var loader = '<img src="<?php echo base_url('/'); ?>images/load.gif"/>';
		x.html(loader);
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'business/load_virtual_tour/'.$bus_id.'/';?>' ,
			success: function (data) {
				
				 x.html(data);
				
			}
		});	

	}


	function load_gallery() {

		var x = $('#bus_gallery');
		var loader = '<img src="<?php echo base_url('/'); ?>images/load.gif"/>';
		x.html(loader);
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'business/load_gallery/'.$bus_id.'/';?>' ,
			success: function (data) {
				
				 x.html(data);
				 initialise_owl();
				
			}
		});	

	}	


	function reload_reviews(){
		
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'business/reload_reviews/'.$bus_id.'/';?>' ,
			success: function (data) {
				
				 $('#reviews').html(data);
				 $("input .star").rating();
			}
		});

	}



	function my_na(id){
		
		var n = $('#'+id);
		var place = 'right'; 
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'business/my_na/';?>'+id+'/'+place+'/' ,
			success: function (data) {	
				
				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect();
				n.removeClass('loading_img');
			}
		});	
		
	}


	function my_na_yes(id){
		
		var n = $('#'+id);
		n.find(".my_na").hide();
		n.addClass('loading_img');
		n.popover('destroy');
		var place = 'right';
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'business/my_na_click/';?>'+id+'/'+place+'/',
			success: function (data) {	
				
				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect();
				n.removeClass('loading_img');
				n.find(".my_na").show();
			}
		});	

	}


</script>

	
</body>
</html>
