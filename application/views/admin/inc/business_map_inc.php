 <?php 
 //+++++++++++++++++
 //My.Na Business map
 //+++++++++++++++++
 //Roland Ihms
 //Get Map Details

$map_details = $this->admin_model->get_map_details($ID);
if(count($map_details) > 0){

	$lat = $map_details['BUSINESS_MAP_LATITUDE'];
	$long = $map_details['BUSINESS_MAP_LONGITUDE'];
	$zoom = $map_details['BUSINESS_MAP_ZOOM_LEVEL'];
	
	if($map_details['BUSINESS_MAP_LATITUDE'] == ''){
		
		$lat = '-22.583741';
		
	}else{
		
		 $lat = $map_details['BUSINESS_MAP_LATITUDE'];
	
	}
	
	if($map_details['BUSINESS_MAP_LONGITUDE'] == ''){
		
		$long = '17.093782';
		
	}else{
		
		 $long = $map_details['BUSINESS_MAP_LONGITUDE'];
	
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
				animation: google.maps.Animation.DROP,
				draggable:true

		  });
					
 		google.maps.event.addListener(marker, 'dragend', function(evt){
				
				document.getElementById("lat").value = evt.latLng.lat().toFixed(6);
				document.getElementById("lng").value = evt.latLng.lng().toFixed(6);
				console.log('lat: '+evt.latLng.lat().toFixed(6));	
				console.log('long: '+evt.latLng.lng().toFixed(6));
		});
	 
	},700);
	
}

	function codeAddress() {
        var address = document.getElementById('address_lookup').value;
        geocoder.geocode( { 'address': address}, function(results, status) {
			  if (status == google.maps.GeocoderStatus.OK) {
				
					var myOptions = {
						zoom: 14,
						center: results[0].geometry.location,
						mapTypeId: google.maps.MapTypeId.ROADMAP
					}
						map = new google.maps.Map(document.getElementById("map"), myOptions);
				
					var marker = new google.maps.Marker({
							map: map,
							position: results[0].geometry.location,
							animation: google.maps.Animation.DROP,
							draggable:true
					});
						
					var loc=[];
					loc[0]=results[0].geometry.location.lat();
					loc[1]=results[0].geometry.location.lng();
					
					document.getElementById("lat").value = loc[0].toFixed(6);
					document.getElementById("lng").value = loc[1].toFixed(6);	
					
					google.maps.event.addListener(marker, 'dragend', function(evt){
				
							document.getElementById("lat").value = evt.latLng.lat().toFixed(6);
							document.getElementById("lng").value = evt.latLng.lng().toFixed(6);

					});
					
				
			  } else {
					alert('Geocode was not successful for the following reason: ' + status);
			  }
        });
      }
</script>

<h2>Update your Map</h2>


	
	<p><span class="mark">*</span><strong>How to add your GPS coordinates:</strong></p>
	<p><strong>STEP1:</strong> Do a quick search for the street you are in.</p>
	<p><strong>STEP2:</strong> Drag the map or the arrow until you precisely pinpointed your location. <br />
		You may also switch to satelite view to see the buildings in a street.</p>
	
    <div class="input-append">
      <input class="span7" type="text" id="address_lookup" placeholder="- quick search your street -" value="<?PHP if(isset($BUSINESS_PHYSICAL_ADDRESS)){ echo $BUSINESS_PHYSICAL_ADDRESS;}?>">
      <input class="btn" type="button" onclick="codeAddress()" value="Search!"/>
	</div>

	<p id="helpText" class="help_block">&nbsp;</p>

	<p>NOTE: Double (<strong>left mouse</strong>) click to <strong>ZOOM IN</strong> | Double (<strong>right mouse</strong>) click to <strong>ZOOM OUT</strong></p>



<form method="post" action="<?php echo site_url('/');?>my_admin/update_map_coordinates/<?php echo $ID;?>/" name="ItineraryCreator" id="form_example" style="margin:0; padding:0" enctype="multipart/form-data">
	
		<div style="display:block;position:relative;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center;height:350px;width:100%;max-width:none">
		    <div id="map" style="display:block;position:relative;width:100%;height:100%;max-width:none"></div>
        </div>
			<input id="lat" name="lat" type="hidden">			
			<input id="lng" name="lng" type="hidden">
            <input id="bus_id" name="bus_id" type="hidden" value="<?php echo $ID;?>">
            <input id="id" name="id" type="hidden" value="<?php echo $this->session->userdata('admin_id');?>">		
			<input readonly="readonly" id="zoom" name="zoom" type="hidden">			
	
	
	
	<div style="clear: both; color:gray; font-size: 10px;">
   	  <strong>Note:</strong> Once you have clicked the save button, please be patient while your files are uploaded to the server.Depending on your connection speed and the size of<br /> 
      the file(s) selected, it could take a couple of mintues.
    </div>
		
        <input id="ftoken_id" name="ftoken_id" type="hidden" value="" />
        <input id="entity_id" name="entity_id" type="hidden" value="" />
		<button type="submit" class="btn btn-large pull-right" name="submit" id="btn_save"><i class="icon-road"></i> Update Map</button>
			
	<div class="clearfix" style="height:80px;"></div>
</form>
