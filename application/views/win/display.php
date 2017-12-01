  <?php 
 //+++++++++++++++++
 //My.Na Main Header
 //+++++++++++++++++
 //Roland Ihms
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title><?php if(isset($title)){echo $title;}else{ echo 'DTS Volleyball For All - My Namibia &trade;';}?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
	<meta name="author" content="My Namibia">
	<meta content="yes" name="apple-mobile-web-app-capable" />
 	<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
	<link rel="stylesheet" href="<?php echo S3_URL;?>scratch_card/volleyball/css/bootstrap.min.css">
	
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">

    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>revolution_slider/css/fullwidth.css" media="screen" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>revolution_slider/rs-plugin/css/settings.css" media="screen" />


    <script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/jquery_1.7.1.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>
     <!-- jQuery KenBurn Slider  -->
    <script type="text/javascript" src="<?php echo base_url('/');?>revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <style type="text/css">

	
		.white_content_box {
			background-color:rgba(255,255,255,0.7);
			padding:10px;
		}

	  html,
      body {
        height: 100%;
		margin: 0 auto -550px;
			background-color: #FF9F01;

	
        /* The html and body elements cannot have any padding or margin. */
      }
		 #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
		
        /* Negative indent footer by it's height */
            
			  }
	.large_text{ font-size:50px; color:#fff}
</style>


<?php if(isset($rep_id)){ $rep_id = $rep_id;}else{ $rep_id = 0;} ?>
 
</head>
<body>
			<div class="fullwidthbanner-container">
					<div class="fullwidthbanner">
						<ul>
							<!-- THE FIRST SLIDE -->

							<li data-transition="slideleft" data-slotamount="1" data-masterspeed="300" data-thumb="images/thumbs/thumb5.jpg">
									<img src="<?php echo base_url('/');?>revolution_slider/images/slides/transparent.png" style="background-color: transparent" >
                                    <div class="caption randomrotate"
										 data-x="30"
										 data-y="74"
										 data-speed="800"
										 data-start="800"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/my_namibia.png" alt="Image 1"></div>
									

									<div class="caption randomrotate"
										 data-x="79"
										 data-y="192"
										 data-speed="300"
										 data-start="1800"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/presents.png" alt="Image 2"></div>

									<div class="caption large_text sfr"
										 data-x="128"
										 data-y="258"
										 data-speed="300"
										 data-start="2600"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/the.png" alt="Image 3"></div>

									<div class="caption lfl"
										 data-x="300"
										 data-y="32"
										 data-speed="300"
										 data-start="3600"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/volleball2014.png" alt="Image 4"></div>

									<div class="caption lfl"
										 data-x="653"
										 data-y="122"
										 data-speed="300"
										 data-start="4500"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/scratch_win.png" alt="Image 5"></div>

									<div class="caption lfl"
										 data-x="622"
										 data-y="213"
										 data-speed="300"
										 data-start="4700"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/game.png" alt="Image 5"></div>
							</li>


							<!-- THE FIFTH SLIDE -->
							<li data-transition="flyin" data-slotamount="2" data-masterspeed="300" data-thumb="images/thumbs/thumb6.jpg">
								
									<img src="<?php echo base_url('/');?>revolution_slider/images/slides/transparent.png" style="background-color: transparent" >
                                    <div class="caption randomrotate"
										 data-x="140"
										 data-y="74"
										 data-speed="800"
										 data-start="800"
										 data-easing="easeOutExpo"><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/win.png" alt="Image 1"></div>
									

									<div class="caption randomrotate"
										 data-x="409"
										 data-y="172"
										 data-speed="300"
										 data-start="1800"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/great.png" alt="Image 2"></div>
									<div class="caption randomrotate"
										 data-x="529"
										 data-y="172"
										 data-speed="300"
										 data-start="2200"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/prizes.png" alt="Image 2"></div>
									<div class="caption large_text sfr"
										 data-x="468"
										 data-y="258"
										 data-speed="300"
										 data-start="3000"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/today.png" alt="Image 3"></div>
									<div class="caption large_text sfr"
										 data-x="208"
										 data-y="328"
										 data-speed="300"
										 data-start="3200"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/only.png" alt="Image 3"></div>
	
							</li>
							<li data-transition="flyin" data-slotamount="2" data-masterspeed="300" data-thumb="images/thumbs/thumb6.jpg">
								
									<img src="<?php echo base_url('/');?>revolution_slider/images/slides/transparent.png" style="background-color: transparent" >
                                    <div class="caption randomrotate"
										 data-x="30"
										 data-y="74"
										 data-speed="800"
										 data-start="800"
										 data-easing="easeOutExpo"><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/play_only.png" alt="Image 1"></div>
									

									<div class="caption randomrotate"
										 data-x="219"
										 data-y="50"
										 data-speed="300"
										 data-start="1500"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/now.png" alt="Image 2"></div>
									<div class="caption randomrotate"
										 data-x="19"
										 data-y="200"
										 data-speed="300"
										 data-start="2200"
										 data-easing="easeOutExpo"  ><img src="<?php echo S3_URL;?>scratch_card/volleyball/images/url.png" alt="Image 2"></div>
									

	
							</li>
						</ul>

						<div class="tp-bannertimer tp-bottom"></div>
					</div>
				</div>





    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
  
		<div class="container">
         		<div class="clearfix" style="height:20px;"></div>
		 		<div class="row-fluid">
				   

         		</div>
       </div>

     <!-- /container - end content --> 
		
      <div id="push"></div>
</div>




    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->




<script type="text/javascript">
				var tpj=jQuery;
				tpj.noConflict();

				tpj(document).ready(function() {

				if (tpj.fn.cssOriginal!=undefined)
					tpj.fn.css = tpj.fn.cssOriginal;

					var api = tpj('.fullwidthbanner').revolution(
						{
							delay:6000,
							startwidth:960,
							startheight:500,

				// Enable Swipe Function : on/off


							stopAtSlide:-1,							// Stop Timer if Slide "x" has been Reached. If stopAfterLoops set to 0, then it stops already in the first Loop at slide X which defined. -1 means do not stop at any slide. stopAfterLoops has no sinn in this case.
							stopAfterLoops:-1,						// Stop Timer if All slides has been played "x" times. IT will stop at THe slide which is defined via stopAtSlide:x, if set to -1 slide never stop automatic

							hideCaptionAtLimit:0,					// It Defines if a caption should be shown under a Screen Resolution ( Basod on The Width of Browser)
							hideAllCaptionAtLilmit:0,				// Hide all The Captions if Width of Browser is less then this value
							hideSliderAtLimit:0,					// Hide the whole slider, and stop also functions if Width of Browser is less than this value


							fullWidth:"off",

							shadow:1								//0 = no Shadow, 1,2,3 = 3 Different Art of Shadows -  (No Shadow in Fullwidth Version !)

						});

	

						// END OF THE SECTION, HIDE MY ARROWS SEPERATLY FROM THE BULLETS

			});

</script>

</body>
</html>