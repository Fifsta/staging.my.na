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

$rating_count = $this->business_model->get_rating_count($bus_id);


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

 
//BUILD OPEN GRAPH
$header['og'] ='
<meta property="fb:app_id" content="287335411399195"> 
<meta property="og:type"        content="MyNamibia:business"> 
<meta property="og:url"         content="'.site_url('/').'b/'.$bus_id.'/'.$this->uri->segment(3).'/"> 
<meta property="og:title"       content="'.$header['title'].'"> 
<meta property="og:description" content="'.$header['metaD'].'"> 
<meta property="og:image"       content="'.$img_url.'">'; 


//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = $row->title.' - My Namibia &trade;';
$header['metaD'] = $this->my_na_model->shorten_string(strip_tags($row->body), 30).'. My Namibia Classifieds - Find What you !na';
$header['section'] = 'careers';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
	<div class="container">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?php echo site_url('/');?>">My</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo site_url('/');?>classifieds/">Calssifieds</a></li>
		    <li class="breadcrumb-item active"><?php echo $row->title;?></li>
		  </ol>
	</div>
</nav>

<div class="container">

	<div class="row">

		<div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">
			<?php $this->load->view('inc/login'); ?>
			<?php $this->load->view('inc/weather'); ?>
			<?php $this->load->view('inc/adverts'); ?>
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
						<div itemprop="address">
                            <span><i class="fa fa-map-marker text-dark"></i> <?php echo $address ;?></span>
                            <span><?php echo $city ;?></span>
                            <span><?php echo $region ;?></span>
                            <span>Namibia</span>
                        </div>

                        <?php echo '<p>'. implode(' ',$cats['links']).'</p>'; ?>
                        
						<div class="row reveal">
							<div class="col-sm-12 col-md-6 col-lg-4">
								<p data-icon="fa-phone text-dark"><button onClick="phone_click($(this),'phone')" class="btn btn-default"><!--T: --><span><?php echo $tel; ?></span></button></p>
								<p data-icon="fa-fax text-dark"><button onClick="phone_click($(this),'fax')" class="btn btn-default"><!--F: --><span><?php echo $fax; ?></span></button></p>								
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<p data-icon="fa-tablet text-dark"><button onClick="phone_click($(this),'cell')" class="btn btn-default"><!--C: --><span><?php echo $cell; ?></span></button></p>
								<p data-icon="fa-envelope text-dark"><button class="btn btn-default"><!--E: --><span><?php echo $email; ?></span></button></p>								
							</div>
							<div class="col-sm-12 col-md-6 col-lg-4">
								<?php if($website) { ?>
								<p data-icon="fa-globe text-dark"><button class="btn btn-default"><!--W: --><a href="<?php echo $website; ?>" target="blank"><span><?php echo $website; ?></span></a></button></p>
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
			</section>	

		</div>

	</div>	
	
</div>
	
<?php $this->load->view('inc/footer');?>	
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>

</body>
</html>