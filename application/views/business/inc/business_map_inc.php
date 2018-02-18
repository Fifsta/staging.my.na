 <?php 
 //+++++++++++++++++
 //My.Na Business map
 //+++++++++++++++++
 //Roland Ihms
 //Get Map Details
$map_details = $this->business_model->get_map_details($ID);
if(count($map_details) > 0){
	
	if($map_details['BUSINESS_MAP_LATITUDE'] == ''){
		
		$lat = '-22.583741';
		$long = '17.093782';
		$zoom = '7';
		echo '<script type="text/javascript">$("#map_info").slideDown();</script>';
		
	}else{
		
		$lat = $map_details['BUSINESS_MAP_LATITUDE'];
		$long = $map_details['BUSINESS_MAP_LONGITUDE'];
		$zoom = $map_details['BUSINESS_MAP_ZOOM_LEVEL'];
		
	}

	
}else{
	
	$lat = '-22.583741';
	$long = '17.093782';
	$zoom = '7';
	echo '<script type="text/javascript">$("#map_info").slideDown();</script>';
}
 ?>
    
<!--<script src="http://maps.google.com/maps?file=api&v=2&key=AIzaSyAhEmO7n-f7JDcSWdmRncZ6JfN3z2FHkTQ" type="text/javascript"></script>-->
<script data-cfasync="false" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
  	  
var geocoder;
var map;
	  
function initialise_map() {
	
	setTimeout(function() {
			
		  geocoder = new google.maps.Geocoder();
		  var myLatlng = new google.maps.LatLng(<?php echo $lat . ',' . $long; ?>);
		 
		  var myOptions = {
			zoom:<?php echo $zoom;?>,
			center: myLatlng,
			mapTypeControl: true,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		  }
		  var map = new google.maps.Map(document.getElementById("map"), myOptions);
			
		  var marker = new google.maps.Marker({
				position: myLatlng,
				map: map,
				animation: google.maps.Animation.DROP
			
		  });
					
	},700);
	
}

	
</script>