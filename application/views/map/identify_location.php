
<div id="map"></div>

    <!--<script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
    <script src="<?php /*echo base_url('/');*/?>js/geolocationmarker-compiled.js"></script>-->

	<script type="text/javascript">

	var base = '<?php echo site_url('/');?>';
	var base_ = '<?php echo base_url('/');?>';

	var geocoder;
	var map;
	var markers = [];
    $(document).ready(function(e) {

		//loadScript();
        loadScript();
		/*window.setInterval(function(){
		  //geolocate(map);
		}, 5000);*/

    });

    function loadScript() {
        var script = document.createElement("script");
        script.type = "text/javascript";
        script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true&callback=initialise_map";
        document.body.appendChild(script);
    }

	function initialise_map() {

			  geocoder = new google.maps.Geocoder();

			 //geolocate(map);
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
			 //setMarkers(map, locations);

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

                update_location(results[1]);
				//alert(results[1].formatted_address);
				//infowindow.open(map, marker);
			  } else {
				alert('No results found');
			  }
			} else {
			  alert('Geocoder failed due to: ' + status);
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

		  $("#msg").html('There was an error obtaining your position. Message: ' + e.message).fadeIn().delay(5000).fadeOut();
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
	  	$("#msg").html(content).fadeIn().delay(5000).fadeOut();
	}

    //PUSh to server
    function update_location(locale) {

        $.ajax({
            'async': true,
            'type': "post",
            'data': {
                        'city_sub' : locale['address_components'][0]['long_name'],'city' : locale['address_components'][1]['long_name'],
                        'region' : locale['address_components'][2]['long_name'],'country' : locale['address_components'][3]['long_name'],
                        'c_code' :  locale['address_components'][3]['short_name']
            },
            'url': "<?php echo site_url('/').'map/update_location/';?>",
            'success': function (data) {

                weather_report();
                local_links();

            }
        });


    }




    </script>
