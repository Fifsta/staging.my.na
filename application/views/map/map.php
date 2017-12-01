<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = 'Namibia on a Map - My Namibia &trade;';
$header['metaD'] = 'Find Business, Products and Services on a interactive map of Namibia. Find What you !na';
$header['section'] = 'home';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
 <style type="text/css">
 #navbar{z-index:99}
 #map{z-index:0;height:100%;background:url(<?php echo base_url('/');?>img/orange_loader.gif) no-repeat center center #fff;}
#map_container{-webkit-box-shadow: inset 2px 1px 5px -1px rgba(0,0,0,0.75);
-moz-box-shadow: inset 2px 1px 5px -1px rgba(0,0,0,0.75);
box-shadow: inset 2px 1px 5px -1px rgba(0,0,0,0.75);padding:2px 0 0 2px}
 .row-fluid .span2,.row .span2{z-index:1;position:relative;padding-left:30px}.row{padding:0;margin:0} 
 #geo_msg{position:fixed; top:20%;right:5%}
 .full_width{min-width:100%;padding:70px 0 0 0;margin:0; overflow:hidden}
 .cnav{position:absolute; border:1px solid #060}

 .cnav_close li a, .cnav_close h1, .cnav_close p{display:none;}
 .cnav_close button{display:none}
  .cnav_close li a{display:none;}
 #nav_slide{position:fixed;left:5px;top:60px;width:35px;height:30px}
 .cnav_open{margin:10px -30px 0px 0px}
 #wrap{background:#fff;}
 .accordion > .accordion-group > .accordion-heading  a.accordion-toggle{font-size:90%}
 .accordion > .accordion-group > .accordion-heading  a.accordion-toggle:hover, .accordion > .accordion-group > .accordion-heading  a.accordion-toggle:active{text-decoration: none}
 .accordion > .count-res{margin:0 0 0 80% }
 .accordion > .accordion-group > .accordion-body > .accordion-inner > ul.nav > li > a span.count-res-sml{margin:0 0 0 80% ;}
 .row-fluid{width:100%; margin:0; padding: 0}.row-fluid .span2 {padding: 0 0 0 10px; margin:0 0 0 5px;}
 .accordion-heading .accordion-toggle{padding: 5px 8px}

 #category_t .tt-dropdown-menu{margin-top:-10px}
 @media (min-width: 768px) and (max-width: 1150px) {

     .full_width{min-width:100%;padding:0px 0 0 0;margin:0; overflow:hidden}
 }

 @media (max-width: 480px) {

 }
 @media (max-width:767px){


	 
}
 @media (max-width:1000px){

     ul.nav li a{font-size: 10px}

 }
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
<div id="wrap">    
   <!-- Part 1: Wrap all content here -->
   <!-- Begin page content -->
	<div class="container-fluid full_width">
        
    	<div class="row-fluid">
        	
        	<div class="span2" id="sidebar" >
            	<a class="btn btn-mini white_back cnav_open pull-right" onClick="toggleNav(1)"><i class="icon-chevron-left"></i></a>
                 <h3 class="na_script upper hide">Navigation</h3>
                 <p class="clearfix">&nbsp;</p>
                    <form>
                        <fieldset>

                            <label class="nav-header">Find Businesses</label>
                            <div id="category_t">
                                <input type="text" class="span12" autocomplete="off" style="width:100%" placeholder="Find businesses">
                            </div>
                        </fieldset>
                    </form>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="nav-header" >Business Services</li>
                        <?php
                        $this->map_model->show_popular_cats($t = 'map_nav');
                        ?>
                    </ul>

                 <p>&nbsp;</p>
            </div>
            
            <div class="span10" id="map-container">

                    <div id="map_container">
                        <div id="map"></div>
                    </div>

            </div>
        </div>
        
    </div>
	
    <div id="nav_slide" class="nav_slide hide"><a class="btn btn-mini white_back" onClick="toggleNav(0)"><i class="icon-chevron-right"></i></a></div>
	<div class="alert alert-danger hide" id="geo_msg"></div>
     <!-- /container - end content --> 

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $this->load->view('inc/footer');
 ?>  
</div>
    <!-- JAvascript
    ================================================== -->



    <script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
    <script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
     <script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
     <script src="<?php echo base_url('/');?>js/geolocationmarker-compiled.js"></script>
     <script src="<?php echo base_url('/');?>js/markerclusterer.js"></script>
	<script type="text/javascript">

	var base = '<?php echo site_url('/');?>';
	var base_ = '<?php echo base_url('/');?>';

    function map_search() {

        var myna2 = new Bloodhound({
            //datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo site_url('/');?>map/category_typehead/',
            remote: '<?php echo site_url('/');?>map/ajax_search_json/?main_cat_id=0&sub_cat_id=0&query=%QUERY',

        });

        myna2.initialize();

        $('#category_t input.span12').typeahead(null, {
            name: 'my-na2',
            displayKey: 'value',
            source: myna2.ttAdapter(),
            highlight: true,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any results that match the current query',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}" class="bold"><p>{{value}}</p></a>')

            }
        });
        $("#category_t .twitter-typeahead").css("width", "100%");

    }



	var geocoder;
	var map;
	var markers = [];
    $(document).ready(function(e) {

        map_search();
		//loadScript();
		initialise_map();
		/*window.setInterval(function(){
		  //geolocate(map);
		}, 5000);*/

		$(window).resize(function () {
			var h = $(window).height(),
				offsetTop = 60; // Calculate the top offset

			$('#map').css('height', (h - offsetTop));

		}).resize();




    });

	function toggleNav(v) {

	  if(v){
		$('#map-container').removeClass('span10').addClass('span12');
		$('#sidebar').addClass('cnav_close hide').removeClass('span2');
		$('#nav_slide').removeClass('hide');

	  }else{
		$('#map-container').removeClass('span12').addClass('span10');
		$('#sidebar').addClass('span2').removeClass('cnav_close hide');
		$('#nav_slide').addClass('hide');

	  }


	}


	function loadScript() {
	  var script = document.createElement("script");
	  script.type = "text/javascript";
	  script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&callback=initialise_map";
	  document.body.appendChild(script);
	}

	var locations = (function () {
    	var json = null;
		$.ajax({
			'async': false,
			'type': "get",
			'url': "<?php echo site_url('/').'map/results/';?>",
			'dataType': "json",
			'success': function (data) {
				json = data;
			}
		});
		return json;
	})();


	function initialise_map() {

			  geocoder = new google.maps.Geocoder();
			  var myLatlng = new google.maps.LatLng(-22.583741,17.093782);

			  var myOptions = {
				zoom:12,
				center: myLatlng,
				mapTypeControl: true,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			  }
			 map = new google.maps.Map(document.getElementById("map"), myOptions);

			 geolocate(map);
       		   // Try HTML5 geolocation
			 if(navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
				  var pos = new google.maps.LatLng(position.coords.latitude,
												   position.coords.longitude);

				  //Get location name
				  codeLatLng(position.coords.latitude,position.coords.longitude);

				}, function() {
				  handleNoGeolocation(true);
				});
			  } else {
				// Browser doesn't support Geolocation

			  }
			 setMarkers(map, locations);

		}


	   function setMarkers(map, locations) {

			infowindow = new google.maps.InfoWindow();

			//var bounds = new google.maps.LatLngBounds();

           //LOOP EACH JSON RESULT
			for (var i = 0; i < locations.length; i++) {

                 //identify marker
                  var dataM = identify_marker(locations[i]['STAR_RATING']);
                  var myLatLng = new google.maps.LatLng(locations[i]['LAT'],locations[i]['LON']);
                  var marker = new google.maps.Marker({
                      position: myLatLng,
                      map: map,
                      html: parseInt(locations[i]['ID']),
                      clickable:  true,
                      shadow: dataM[1],
                      icon: dataM[0],
                      shape: dataM[2],
                      title: locations[i]['BUSINESS_NAME'],
                      zIndex: i,
                      animation: google.maps.Animation.DROP
                  });
                  markers.push(marker);
                  marker.setMap(map);

                  //bounds.extend(myLatLng);


                  google.maps.event.addListener(marker, 'click', function () {
                        infowindow.setContent('<img src="'+base_+'img/orange_loader.gif"/>');
                        infowindow.open(map, this);
                        //console.log(this.html);
                            $.ajax({
                                  url: base+'map/show_map_info/'+ this.html,
                                  cache:false,
                                  success: function (data) {
                                      infowindow.setContent(data);

                                  }
                              });
                    });
			}//END loop
          // map.fitBounds(bounds);
           var clusterStyles = [
               {
                   textColor: 'white',
                   url: base_+'img/markers/v1/cluster1.png',
                   height: 50,
                   width: 50
               },
               {
                   textColor: 'white',
                   url: base_+'img/markers/v1/cluster2.png',
                   height: 50,
                   width: 50
               },
               {
                   textColor: 'white',
                   url: base_+'img/markers/v1/cluster3.png',
                   height: 60,
                   width: 60
               }
           ];

           var mcOptions = {
               gridSize: 80,
               styles: clusterStyles,
               maxZoom: 15
           };
           //mc = new MarkerClusterer(map, markers, mcOptions);
          // mc = new MarkerClusterer(map);
	}


    function identify_marker(str){

        var data = new Array( );
        if(str == null){

            data[0] = new google.maps.MarkerImage(
                base_+'img/markers/v1/dot/image.png',
                new google.maps.Size(10,10),
                new google.maps.Point(0,0),
                new google.maps.Point(15,10)
            );

            data[1] = new google.maps.MarkerImage(
                base_+'img/markers/v1/dot/shadow.png',
                new google.maps.Size(15,10),
                new google.maps.Point(0,20),
                new google.maps.Point(5,0)
            );
            data[2] = {
                coord: [7,0,8,1,9,2,9,3,9,4,9,5,9,6,9,7,8,8,7,9,2,9,1,8,0,7,0,6,0,5,0,4,0,3,0,2,1,1,2,0],
                type: 'poly'
            };


        }else{

            data[0] = new google.maps.MarkerImage(
                base_+'img/markers/v1/image.png?v1',
                new google.maps.Size(40,52),
                new google.maps.Point(0,0),
                new google.maps.Point(20,52)
            );

            data[1] = new google.maps.MarkerImage(
                base_+'img/markers/v1/shadow.png',
                new google.maps.Size(66,52),
                new google.maps.Point(0,20),
                new google.maps.Point(20,52)
            );

            data[2] = {
                coord: [17,0,19,1,20,2,21,3,22,4,23,5,24,6,24,7,25,8,25,9,25,10,25,11,25,12,25,13,25,14,25,15,24,16,24,17,23,18,23,19,22,20,22,21,21,22,21,23,20,24,19,25,19,26,18,27,18,28,17,29,17,30,16,31,15,32,15,33,14,34,14,35,11,35,11,34,10,33,10,32,9,31,8,30,8,29,7,28,7,27,6,26,6,25,5,24,4,23,4,22,3,21,3,20,2,19,2,18,1,17,1,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,0,8,1,7,2,6,2,5,3,4,4,3,5,2,6,1,8,0],
                type: 'poly'
            };


        }
        return data;

    }



	//REVERSE GEOCODE
	function codeLatLng(lat1,lon) {
		  //var input = latlon;
		  //var latlngStr = input.split(',', 2);
		  var lat = parseFloat(lat1);
		  var lng = parseFloat(lon);
		  var latlng = new google.maps.LatLng(lat, lng);
		  geocoder.geocode({'latLng': latlng}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
			  if (results[1]) {

				//alert(results[1].formatted_address);
				//infowindow.open(map, marker);
			  } else {
				//alert('No results found');
			  }
			} else {
			  //alert('Geocoder failed due to: ' + status);
			}
		  });
	}
	// Try HTML5 geolocation
	function geolocate(map){

		GeoMarker = new GeolocationMarker();
        GeoMarker.setCircleOptions({fillColor: '#808080'});

        google.maps.event.addListenerOnce(GeoMarker, 'position_changed', function() {
          map.setCenter(this.getPosition());
		  //console.log(this.getPosition()+'ddd')
          //map.fitBounds(this.getBounds());
        });

        google.maps.event.addListener(GeoMarker, 'geolocation_error', function(e) {

		  $("#geo_msg").html('There was an error obtaining your position. Message: ' + e.message).fadeIn().delay(5000).fadeOut();
        });

        GeoMarker.setMap(map);

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


	//loadresults
	function load_results(type,cat) {

	 	$.ajax({
			'async': false,
			'type': "get",
			'url': "<?php echo site_url('/').'map/results/';?>"+cat+'/'+type,
			'dataType': "json",
			'success': function (data) {

				 locations = data;
				 deleteMarkers();
				 //geolocate(map);

				 setMarkers(map, locations);

			}
		});


	}

	// Sets the map on all markers in the array.
	function setAllMap(map) {
	  for (var i = 0; i < markers.length; i++) {
		markers[i].setMap(map);
	  }
	}
	// Removes the markers from the map, but keeps them in the array.
	function clearMarkers() {
	  setAllMap(null);
	}

	// Shows any markers currently in the array.
	function showMarkers() {
	  setAllMap(map);
	}

	// Deletes all markers in the array by removing references to them.
	function deleteMarkers() {
	  clearMarkers();
	  markers = [];
	}

    </script>

</body>
</html>