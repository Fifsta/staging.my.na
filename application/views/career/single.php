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