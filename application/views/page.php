 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] =  $heading . ' - My Namibia &trade;';
 $header['metaD'] = $metaD;
 $header['section'] = 'home';
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
		    <li class="breadcrumb-item"><a href="#">My.na</a></li>
		    <li class="breadcrumb-item"><?php echo $heading; ?></li>
		  </ol>
	</div>
</nav>
 
<div class="container"> 
	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">
			<?php $this->load->view('inc/login'); ?>
		
			<?php $this->load->view('inc/adverts'); ?>
		</div>

		<div class="col-sm-8 col-md-8 col-lg-9 col-xl-9 order-md-1 order-sm-2">
			<div class="row">
				<div class="col-md-12">

					<section id="classifieds">
						<div class="heading" style="margin-bottom:10px">
							<h2 data-icon="fa-newspaper-o"><?php echo $heading;?> <strong>My Namibia &trade;</strong></h2>
							<ul class="options">

							</ul>
						</div>
						
						<div id="classifieds_content" class=""></div>
						
					</section> 

		         	<div class="results_div">
		         		<div class="spacer"></div>
		         		<?php echo $body;?>
		       		</div>

				</div>
			</div>
		</div>
	</div>	
</div>

<div class="spacer"></div>

<?php $this->load->view('inc/footer');?>	


<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "My Namibia",
  "description" : "The biggest online portal for Namibians to find what they are lookin for. Business, Products, Services. Find What you !na.",
  "brand" : { 
  		"@type": "brand",
		"image" : "https://my.na/images/logo-main.png"
  },
  "sameAs": [
    "https://www.facebook.com/mynamibia/",
    "https://twitter.com/MyNamibia"
  ],  
  "address": {
	    "@type": "PostalAddress",
	    "streetAddress": "11B Genl. Murtala Muhammed Ave Windhoek, Namibia"
  },  
  "contactPoint": {
	    "@type": "ContactPoint",
	    "contactType" : "customer service",
	    "email" : "info@my.na",
	    "url" : "https://www.my.na",
	    "telephone" : "+264 61 309 591"
  }
}

</script>

<script type="application/ld+json">

{
  "@context" : "http://schema.org",
  "@type" : "GeoCoordinates", 
  "latitude" : "-22.5480965",
  "longitude" : "17.0872937"                      
} 

</script>

</body>
</html>