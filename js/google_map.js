// © copyright & intellectual property of Intouch Interactive Marketing - Carl-Heinz Benseler

//GOOGLE MAPS
function initGoogleMaps(){
	var map;
		var mapOptions = {
			center: new google.maps.LatLng(-22.619874, 17.090803),
			zoom: 6,
			zoomControl: true,
			zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL,
			},
			disableDoubleClickZoom: true,
			mapTypeControl: true,
			mapTypeControlOptions: {
				style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
			},
			scaleControl: true,
			scrollwheel: false,
			panControl: true,
			streetViewControl: false,
			draggable : true,
			overviewMapControl: true,
			overviewMapControlOptions: {
				opened: false,
			},
			mapTypeId: google.maps.MapTypeId.ROADMAP,
			//styles: [{"featureType":"all","elementType":"all","stylers":[{"saturation":-100},{"gamma":0.9}]}],

		}
		var mapElement = document.getElementById('map_iframe');
		map = new google.maps.Map(mapElement, mapOptions);
		var locations = [
			['Cajaka Furniture', 'Shop 29, Grove Mega Centre, <br> Chasie Street, Windhoek, Namibia', '+264 (0)81 822 5252', 'info@cajaka.com.na', -22.619874, 17.090803]
		];
		for (i = 0; i < locations.length; i++) {
			if (locations[i][1] =='undefined'){ var address ='';} else { var address = locations[i][1];}
			if (locations[i][2] =='undefined'){ var tel ='';} else { var tel = locations[i][2];}
			if (locations[i][3] =='undefined'){ var email ='';} else { var email = locations[i][3];}
			
			var image = new google.maps.MarkerImage(
				'http://intouch.com.na/clients/temp_myna/images/map_marker.png',
				new google.maps.Size(40,60),	// size of the image
				new google.maps.Point(0,0), 	// origin, in this case top-left corner
				new google.maps.Point(20,60)	// anchor, i.e. the point half-way along the bottom of the image
			);
			
			marker = new google.maps.Marker({
				icon: image,
				anchorPoint: new google.maps.Point(0, 0),
				position: new google.maps.LatLng(locations[i][4], locations[i][5]),
				map: map,
				title: locations[i][0],
				address: address,
				tel: tel,
				email: email
			});
			bindInfoWindow(marker, map, locations[i][0], address, tel, email);
		}
function bindInfoWindow(marker, map, title, address, tel, email) {
	
	google.maps.event.addListener(marker, 'click', function() {
		var html= "<div class='map_pop'><p class='head'>"+title+"</h2><p><strong>Address:</strong> "+address+"</p><p><strong>Tel:</strong> "+tel+"</p><p><strong>Email:</strong> <a href='mailto:"+email+"'>"+email+"</a></p></div>";
			iw = new google.maps.InfoWindow({content:html});
			iw.open(map,marker);
		});
	
	}
}
// © copyright & intellectual property of Intouch Interactive Marketing - Carl-Heinz Benseler