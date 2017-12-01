
                      
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
						
					 setMarkers(map, beaches);     
       
                }
                

               function setMarkers(map, locations) {
					
					infowindow = new google.maps.InfoWindow({

							content: "holding..." , maxWidth: "430px"
					});
					
					var image = new google.maps.MarkerImage(
					  '<?php echo base_url('/');?>img/markers/image.png',
					  new google.maps.Size(46,46),
					  new google.maps.Point(0,0),
					  new google.maps.Point(23,46)
					);
					
					var shadow = new google.maps.MarkerImage(
					  '<?php echo base_url('/');?>img/markers/shadow.png',
					  new google.maps.Size(72,46),
					  new google.maps.Point(0,0),
					  new google.maps.Point(23,46)
					);
					
					var shape = {
					  coord: [10,1,40,2,43,3,44,4,44,5,44,6,44,7,45,8,45,9,45,10,44,11,43,12,40,13,35,14,35,15,35,16,35,17,35,18,35,19,35,20,34,21,34,22,33,23,32,24,32,25,31,26,31,27,31,28,31,29,31,30,31,31,31,32,31,33,31,34,31,35,31,36,31,37,31,38,30,39,30,40,29,41,28,42,27,43,20,43,16,42,15,41,14,40,13,39,13,38,12,37,12,36,12,35,12,34,11,33,11,32,11,31,10,30,10,29,10,28,10,27,9,26,9,25,9,24,9,23,8,22,8,21,7,20,6,19,5,18,5,17,4,16,4,15,3,14,2,13,1,12,0,11,0,10,0,9,0,8,1,7,1,6,1,5,1,4,1,3,2,2,5,1,10,1],
					  type: 'poly'
					};
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
						  zIndex: beach[3]
					  });
					  
					   google.maps.event.addListener(marker, 'click', function () {
							
							infowindow.setContent(this.html);
							
							infowindow.open(map, this); 
						});
					}
					
					
			}  
			
			//initialise_map();

                