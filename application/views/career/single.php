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
$width = 826;
$height = 466;

$l_width = 400;
$l_height = 400;


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
	
				<!--banner-->
		        <div class="list-map">
		          <div class="list-map-left">
		              <img src="<?php echo $cover_url; ?>" class="img-fluid">
		          </div>
		          
		          <div class="list-map-right" id="map_container">
		          	<iframe src="<?php echo site_url('/'); ?>business/load_business_map/<?php echo $row->bus_id; ?>" frameborder="0" allowtransparency="true"></iframe>
		          </div>
		        </div>
		        <!--banner-->
 
				<!--details-->
				<div class="details">
					<div class="details-left">

						<figure>
							<img src="<?php echo $logo_url; ?>">
						</figure>

					</div>
					<div class="details-right">
  					<?php 
					
					$fb = "postToFeed(" . $row->vacancy_id . ", '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_na_model->shorten_string(strip_tags($this->my_na_model->clean_url_str($row->body, " ", " ")), 50)))) . "', '" . site_url('/') . 'careers/job/' . $row->vacancy_id . '/' . trim($this->my_na_model->clean_url_str($row->title)) . "')";
					$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
					$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->my_na_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
					
					echo'<div class="row">
								<div class="col-md-12">
									<form action="'.site_url('/').'vacancy/apply_do/" method="post" enctype="multipart/form-data" name="apply" id="apply" class="form-horizontal">
									<input name="vid" type="hidden" value="'.$row->vacancy_id.'">
									<input name="bus_id" type="hidden" value="'.$row->bus_id.'">
									<input name="title" type="hidden" value="'.$row->title.'">
									<input name="ref_no" type="hidden" value="'.$row->ref_no.'">
									<br>
									<h3>'.$row->title.'</h3>
									<p><i class="fa fa-map-marker text-dark"></i> <em>'. $row->location.' - '.$row->BUSINESS_NAME.'</em></p>
									<div>'.$row->body.'</div>
									'.$row->sub_cat. ' ' .$row->sub_sub_cat.'
									<hr>
									<div class="text-right" id="app-box">
										'.$this->vacancy_model->check_apply($row->vacancy_id).'
									</div>
									</form>
							   </div>
						  </div>';
						  
					?>                      

					</div>
				</div>
				<!--details-->

		</div>

	</div>	
	
</div>
	
<?php $this->load->view('inc/footer');?>	
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>

</body>
</html>