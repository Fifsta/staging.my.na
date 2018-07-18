<?php

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


$this->load->model('image_model'); 
$this->load->library('thumborp');

$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
$width = 360;
$height = 230;

$l_width = 100;
$l_height = 100;


if($row->COVER != '' && $row->COVER != null){
					
					
if(strpos($row->COVER, '.')){

    $cover_str = 'assets/business/photos/' . $row->COVER;
    $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');						
	
}else{

    $cover_str = 'assets/business/photos/' . $row->COVER.'.jpg';
    $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');	
	
}

}else{
    $cover_str = 'assets/business/photos/listing-placeholder.jpg';
    $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');
}

if($row->LOGO != '' && $row->LOGO != null){

if(strpos($row->LOGO, '.')){

    $logo_str = 'assets/business/photos/' . $row->LOGO;
    $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
     $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';                       

	
}else{
	

    $logo_str = 'assets/business/photos/' . $row->LOGO.'.jpg';
    $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
    $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';                        
	
}


}else{


    $logo_str = 'assets/business/photos/bus_logo.png';
    $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
    $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';
}



?>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
	<div class="container">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?php echo site_url('/');?>">My</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo site_url('/');?>careers/">Careers</a></li>
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
		          <h2 data-icon="fa-briefcase"><?php echo $row->title; ?></h2>
		          <ul class="options">    
		            <li><a href="#Enquiry-Form" data-icon="fa-envelope text-dark">Contact Agency</a></li>
		          </ul>
		        </div>
	


		</div>

	</div>	
	
</div>
	
<?php $this->load->view('inc/footer');?>	
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>

</body>
</html>