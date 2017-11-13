<?php $this->load->view('inc/header');?>
<?php $this->load->view('inc/top_bar');?>

<div class="container-fluid">

	<div class="row">

		<div class="col-sm-4 col-md-4 col-lg-2 order-md-2 order-sm-1 order-lg-2">
	    
			<?php $this->load->view('inc/profile');?>
			
			<?php $this->load->view('inc/weather');?>
			
			<!--adverts-->
			<div class="adverts">
				<div><a href="#"><img src="images/advert-sample.png" class="img-fluid"></a></div>
				<div><a href="#"><img src="images/advert-sample.png"></a></div>
				<div><a href="#"><img src="images/advert-sample.png"></a></div>
				<div><a href="#"><img src="images/advert-sample.png"></a></div>
			</div>
			<!--adverts-->
		</div>

		<div class="col-sm-8 col-md-8 col-lg-10 order-md-1 order-sm-2">

 			<?php $this->load->view('inc/business');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/near_you');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/categories');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/map');?>
			<div class="spacer"></div>
			<?php $prop['type'] = '3408'; $this->load->view('inc/products', $prop);?>
			<div class="spacer"></div>
			<?php $cars['type'] = '348'; $this->load->view('inc/products', $cars);?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/deals');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/auctions');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/news');?>	
			<div class="spacer"></div>	
			<?php $this->load->view('inc/trending');?>
			<div class="spacer"></div>

		</div>

	</div>	
	
</div>
	
	
<?php $this->load->view('inc/footer');?>	


	<!-- Bootstrap -->
	<script src="bootstrap/js/popper.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script src="bootstrap/js/bootstrap.bundle.min.js"></script>

	<link href="https://s3.amazonaws.com/mynamibia/packages/css/weather-icons.min.css" rel="stylesheet" type="text/css">
	<!-- Calatz -->
	<!-- The "browse to" file input fields -->
	<script src="js/jquery.fileInput.js"></script>

	<script src="js/owl.carousel.js"></script>


	<script src="js/jquery.cycle.min.js"></script>
	<script src="js/jquery.lazysizes.min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	<script src="js/jquery.datatables.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>

	<!-- Datepicker -->
	<script src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	
	<!-- Custom Js -->
	<script src="js/jquery.custom.js"></script>

    <script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
    <script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
     <script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
     <script src="<?php echo base_url('/');?>js/geolocationmarker-compiled.js"></script>
     <script src="<?php echo base_url('/');?>js/markerclusterer.js"></script>
	
	
	<script type="text/javascript">
		$(document).ready(function(){


			$('.owl-carousel').owlCarousel({
			    loop:true,
			    margin:10,
			    nav: true,
			    navText : ["<button class='btn owl-prev-next-button previous'></button>","<button class='btn owl-prev-next-button next'></button>"],
			    responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			            nav:true
			        },
			        600:{
			            items:3,
			            nav:true
			        },
			        1000:{
			            items:4,
			            nav:true,
			            loop:false
			        }
			    }
			});

			
			get_wethear('na','windhoek');
			//THUMBS
			$('figure .cycle-slideshow').cycle('pause');
			$('figure .cycle-slideshow').mouseenter(function() {
				$(this).cycle('resume').cycle('goto',0);
				$('.reveal', this).each(function() {
					var reveal = $(this).attr('data-src');
					$(this).fadeIn(500).attr('src',reveal);
				});
			}).mouseleave(function() {
				var shown = $('.shown', this).attr('src');
				$(this).cycle('pause').cycle('goto',0);
				$('.reveal', this).each(function() {
					$(this).stop().fadeOut(200).attr('src',shown);
				});
			});
			
		});
	
		//RESOLUTION
		function windowResize(){
			windowWidth = $(window).width();
			windowHeight = $(window).height();
			$('#resolution').text(windowWidth+' x '+windowHeight);
		};
		$(window).resize(windowResize);
		
		//PRELOAD
		window.onload = showBody;
		function showBody(){
			windowResize();
			swipeHeight();
			$('#pre_load').fadeOut();
		}
		
		
		function get_wethear(cunt,city){
	
			$.getJSON( "<?php echo HUB_URL;?>weather/display_block/"+cunt+"/"+city, function( data ) {
	
				if(data.success){
	
					$('#weather_cont').html(data.html);
					$('.city-weather').unbind('click').bind('click', function(e){
						var city = $(this).data('location');
						//console.log(city);
						get_wethear('na', city);
					});
				}
	
			});
	
	
		}


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

        //map_search();
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
	  script.src = "http://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&callback=initialise_map";
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
