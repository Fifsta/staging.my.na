<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<title>Fuel Stations Accepting Debit Cards - My Namibia &trade;</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="Fuel Stations Accepting Debit Cards - My Namibia &trade;">
	<meta name="author" content="My Namibia">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
    <meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta name="apple-mobile-web-app-capable" content="yes">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css">
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
    <?php if(isset($og)){ echo $og;}?>
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">
	<!--<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>-->

 <style type="text/css">
 
 html, body,.container-fluid { height: 100%;margin:0;padding:0 }
 #map_container{		  -moz-box-shadow:      0 0 10px #666;
		   -webkit-box-shadow:  0 0 10px #666;
		   box-shadow:         0 0 10px #666;top:50px;display:block;position:relative;background:url(<?php echo base_url('/');?>img/orange_loader.gif) no-repeat center center #fff;height:95%;width:100%;max-width:none
		   
 }
 #geo_msg{position:fixed; top:20%;right:5%}
 @media (max-width: 480px) {
	 #fnb{width:80px;}
	 html, body,.container-fluid { height: 100%; margin:0;padding:0; top:0px}	 
	  #map_container{margin-top:0;top:-30px;}
 }
 @media (max-width:767px){body{padding-left:0px;padding-right:0px;margin:0} .navbar-fixed-top,.navbar-fixed-bottom,.navbar-static-top{margin-left:0px;margin-right:0px;} #map_container{margin-top:0;top:-30px;}}
 </style>
</head>
<body>  

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 $this->load->view('inc/navigation', $nav);
 ?>
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->

      <!-- Begin page content -->
      

        <div id="map_container">
            <div id="map" style="display:block;position:fixed;width:100%;height:100%;max-width:none"></div>
        </div> 
		<img id="fnb" style="position:fixed; bottom:10px; right:20px;" src="<?php echo base_url('/');?>/img/fnb_logo_300.gif" />
	  	<div class="alert alert-danger hide" id="geo_msg"></div>
     <!-- /container - end content --> 

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
// $this->load->view('inc/footer', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->

 	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>
	<script type="text/javascript">
	
	var base = '<?php echo site_url('/');?>';
	var base_ = '<?php echo base_url('/');?>'; 
	
    $(document).ready(function(e) {
        
		loadScript();
		window.setInterval(function(){
		  //geolocate(map);
		}, 5000);
    });
	

	function loadScript() {
	  var script = document.createElement("script");
	  script.type = "text/javascript";
	  script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&callback=initialise_map";
	  document.body.appendChild(script);
	}
	
	var beaches = [
					['Bach Street Service Station', -22.564312, 17.066894,0,'8227'],
				  	['CJ Service Station',-20.461889, 16.650682,1,'8239'],
					['Kunene MiniMarket',-17.43716,14.36375,2,'8228'],
					['Oasis Camp Site',-24.486641, 15.801129,3,'8229'],
					['Pionierspark Service Station',-22.598928, 17.069495,4,'8230'],
					['Riverside Service Station',-22.522770,17.077364,5,'8231'],
					['Solitaire Desert farms',-23.893629, 16.005377,6,'8232'],
					['Van der Walt Motors',-22.572380, 17.101846,7,'8233'],
					['Wika Service Station',-22.570172, 17.081747,8,'2908'],
					/*['NWR Okaukuejo',,,,9''],
					['NWR Halali',,,10,''],
					['NWR Namutoni',,,11,''],
					['NWR Waterberg',,,12,''],*/
					['Walters motors',-22.584148, 17.065515,13,'2823'],
					['Khan Service Station',-22.000779, 15.582847,14,'8234'],
					['Grobler Motor Hentiesbay',-22.117346, 14.283798,15,'8235'],
					['Engen Fuel Shop Swakopmund',-22.677549, 14.531807,16,'8236'],
					['Luderitz Coastways Service Station',-26.653420, 15.157372,17,'8237']
/*					['',,,,''],
					['',,,,'']*/
				  ];
	
		var geocoder;
		var map;
			  
		function initialise_map() {

			  geocoder = new google.maps.Geocoder();
			  var myLatlng = new google.maps.LatLng(-22.583741,17.093782);
			 
			  var myOptions = {
				zoom:12,
				center: myLatlng,
				mapTypeControl: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			  }
			  var map = new google.maps.Map(document.getElementById("map"), myOptions);
			
			geolocate(map);
			setMarkers(map, beaches);  

		}
		

	   function setMarkers(map, locations) {
			
			infowindow = new google.maps.InfoWindow();
			
			var image = new google.maps.MarkerImage(
			  base_+'img/markers/petrol/image.png',
			  new google.maps.Size(40,52),
			  new google.maps.Point(0,0),
			  new google.maps.Point(20,52)
			);
			
			var shadow = new google.maps.MarkerImage(
			  base_+'img/markers/petrol/shadow.png',
			  new google.maps.Size(66,52),
			  new google.maps.Point(0,20),
			  new google.maps.Point(20,52)
			);
			
			var shape = {
			  coord: [36,1,38,2,38,3,39,4,39,5,39,6,39,7,39,8,39,9,39,10,39,11,39,12,39,13,39,14,39,15,39,16,39,17,39,18,39,19,39,20,39,21,39,22,39,23,39,24,39,25,39,26,39,27,39,28,39,29,39,30,39,31,39,32,39,33,39,34,39,35,39,36,39,37,38,38,38,39,36,40,25,41,25,42,24,43,23,44,23,45,22,46,22,47,21,48,20,49,20,50,18,50,18,49,17,48,16,47,16,46,15,45,15,44,14,43,13,42,13,41,3,40,1,39,1,38,0,37,0,36,0,35,0,34,0,33,0,32,0,31,0,30,0,29,0,28,0,27,0,26,0,25,0,24,0,23,0,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,0,8,0,7,0,6,0,5,0,4,1,3,1,2,3,1],
			  type: 'poly'
			};
			
			//mc = new MarkerClusterer(map, markers, { maxZoom: 12, gridSize: 50});
			//mc = new MarkerClusterer(map);

			//var bounds = new google.maps.LatLngBounds();

			for (var i = 0; i < locations.length; i++) {
			  var beach = locations[i];
			  var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
			  var marker = new google.maps.Marker({
				  position: myLatLng,
				  map: map,
				  html: beach[4],
				  clickable:  true,
				  shadow: shadow,
				  icon: image,
				  shape: shape,
				  title: beach[0],
				  zIndex: beach[3],
				  animation: google.maps.Animation.DROP
			  });
			  
			 // mc.addMarker(marker);
			  //bounds.extend(myLatLng);
			 // map.fitBounds(bounds);

				 google.maps.event.addListener(marker, 'click', function () {
					infowindow.setContent('<img src="'+base_+'img/orange_loader.gif" style="margin:40px 0px 20px 100px"/>');
					infowindow.open(map, this);
					//console.log(this.html);
						$.ajax({
							  url: base+'a/show_map_info/'+ this.html,
							  cache:false,
							  success: function (data) {	
								  infowindow.setContent(data);
								  
							  }
						  });	
				});
			}
			
			
	} 
	// Try HTML5 geolocation
	function geolocate(map){	
				
			 if(navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
				  	var pos = new google.maps.LatLng(position.coords.latitude,
												   position.coords.longitude);
					var image_me = new google.maps.MarkerImage(
				  		  base_+'img/markers/petrol/you_sml1.png',
						  new google.maps.Size(25,24),
						  new google.maps.Point(0,0),
						  new google.maps.Point(13,24)
					);
						
					var shadow_me = new google.maps.MarkerImage(
							  base_+'img/markers/petrol/shadow.png',
							  new google.maps.Size(37,24),
							  new google.maps.Point(0,20),
							  new google.maps.Point(13,24)
					);
							
					var shape_me = {
							  coord: [16,0,18,1,19,2,20,3,21,4,22,5,23,6,23,7,23,8,24,9,24,10,24,11,24,12,24,13,24,14,23,15,23,16,22,17,21,18,21,19,20,20,18,21,17,22,14,23,10,23,7,22,6,21,4,20,3,19,3,18,2,17,1,16,1,15,1,14,0,13,0,12,0,11,0,10,0,9,1,8,1,7,1,6,2,5,3,4,4,3,5,2,6,1,8,0],
							  type: 'poly'
					}
				  	var infowindow = new google.maps.Marker({
						map: map,
						position: pos,
						content: 'You are here',
						clickable:  true,
						shadow: shadow_me,
						icon: image_me,
						shape: shape_me,
						title: 'You are Here',
						html: 'You are Here',
						animation: google.maps.Animation.BOUNCE
				  	});
				  
				  map.setCenter(pos);
				}, function() {
				  handleNoGeolocation(true);
				});
			  } else {
				// Browser doesn't support Geolocation
				handleNoGeolocation(false);
			  }	
	}
	
	//Handle geolocate
	function handleNoGeolocation(errorFlag) {
	  if (errorFlag) {
		var content = 'Error: The Geolocation service failed.';
	  } else {
		var content = 'Error: Your browser doesn\'t support geolocation.';
	  }
		console.log(errorFlag+ " " +content);
	  	$("#geo_msg").html(content).fadeIn().delay(5000).fadeOut();	
	}	
	
	
    </script>
       

</body>
</html>