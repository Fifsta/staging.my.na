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
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<title><?php if(isset($title)){echo $title;}else{ echo 'My Namibia &trade;';}?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="<?php if(isset($metaD)){echo $metaD;}else{ echo 'My Namibia - the Free business portal in Namibia';}?>">
	<meta name="author" content="My Namibia">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">

    <link href="<?php echo base_url('/');?>css/jquery.rating.css" type="text/css" rel="stylesheet"/>
<!--    <script type="text/javascript">
		if( ! window.$){
		   var script = document.createElement('script');
		   script.type = "text/javascript";
		   script.src = "//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js";
		   document.getElementsByTagName('head')[0].appendChild(script);
		}
	</script>-->	
	
    <style type="text/css">
		
		
		 ul.slides {list-style:none;margin:0;padding:0;}
		 .slideshow-block{
			position: relative;
			height:180px;
			overflow:hidden;
		}
		a.link{
		 position:absolute;  
		  
		}
		a.link:hover{
			
		}
		.slides{
			z-index:0;
			visibility:visible;
		}
		.slides li img,.slides.active li img{
		   width:100%;height:auto;
		}
		.slides.active{
			visibility:visible;
		}
	</style>
 <?php 
 	    if($bus_id == 980 || $bus_id == 8966){
	  
	  //CUSTOM STYLEs
	  echo '
	  		<style type="text/css">
			
			   .carousel-caption{ background:rgba(255, 255, 255, 0.75)}
			   .btn-inverse, .btn-group, .add-on, .btn{ background:#00155F; color:#fff}
			   .btn-inverse.active{ background:#110042} .btn-inverse:hover, .btn-inverse:focus{ background:#110042; color:#fff}
			  
				h1,h2,h3,h4,h5, .carousel-caption > h4{color:#00155F}
				td{font-size:12px}
				.facebook{

					
					display:block;
					background-position:99px 0px;	
					width:34px;
					height:39px;
					float:left;
					position:relative;
					cursor:pointer;
					overflow:hidden;
					z-index:999 !important;
							 transition: background .25s ease-in-out;
					-moz-transition: background .25s ease-in-out;
					-webkit-transition: background .25s ease-in-out;
					
					}
					.facebook:hover{
					
					background-position:99px 39px;	
					}
					.twitter{
					
					
					display:block;
					background-position:0px 0px;
					width:34px;
					height:39px;
					float:left;
					position:relative;
					cursor:pointer;
					overflow:hidden;
					z-index:999 !important;
							 transition: background .25s ease-in-out;
					-moz-transition: background .25s ease-in-out;
					-webkit-transition: background .25s ease-in-out;
					
					}
					.twitter:hover{
					
					background-position:0px 39px;	
					}
			  </style>
	  
			  </head>
		  <body>';
  	}
   ?>
