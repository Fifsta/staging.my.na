 <?php 
 //+++++++++++++++++
 //My.Na Business map
 //+++++++++++++++++
 //Roland Ihms
 //Get Map Details
?>

<script type="text/javascript">

function initialise_map() {
	
	
	setTimeout(function() {
		
		if (GBrowserIsCompatible()) {
			
			
			var map = new GMap2(document.getElementById("map"));
			map.addControl(new GSmallMapControl());
			map.addControl(new GMapTypeControl());
			var center = new GLatLng(<?php echo $lat;?>,<?php echo $long;?>);
			map.setCenter(center, <?php echo $zoom;?>);
			geocoder = new GClientGeocoder();
			var marker = new GMarker(center, {draggable: true});  
			map.addOverlay(marker);
			document.getElementById("lat").value = center.lat().toFixed(6);
			document.getElementById("lng").value = center.lng().toFixed(6);
			GEvent.addListener(marker, "dragend", function() {
				var point = marker.getPoint();
				map.panTo(point);
				document.getElementById("lat").value = point.lat().toFixed(6);
				document.getElementById("lng").value = point.lng().toFixed(6);
	
			});
			
			
	
			GEvent.addListener(map, "moveend", function() {
				map.clearOverlays();
				var center = map.getCenter();
				var marker = new GMarker(center, {draggable: true});
				map.addOverlay(marker);
				document.getElementById("lat").value = center.lat().toFixed(6);
				document.getElementById("lng").value = center.lng().toFixed(6);
	
				GEvent.addListener(marker, "dragend", function() {
					var point =marker.getPoint();
					map.panTo(point);
					
					
					document.getElementById("lat").value = point.lat().toFixed(6);
					document.getElementById("lng").value = point.lng().toFixed(6);
	
				});

		});
		GEvent.trigger(map, 'resize');
		//google.maps.event.trigger(map, 'resize');
	}
	 
	}, 700);
	
}

function showAddress(address) {
	var map = new GMap2(document.getElementById("map"));
	map.addControl(new GSmallMapControl());
	map.addControl(new GMapTypeControl());
	if (geocoder) {
		geocoder.getLatLng(
			address,
			function(point) {
				if (!point) {
					alert(address + " not found");
				} else {
					document.getElementById("lat").value = point.lat().toFixed(6);
					document.getElementById("lng").value = point.lng().toFixed(6);
					map.clearOverlays()
					map.setCenter(point, 14);
					var marker = new GMarker(point, {draggable: true});  
					map.addOverlay(marker);
					
					GEvent.addListener(marker, "dragend", function() {
						var pt = marker.getPoint();
						map.panTo(pt);
						document.getElementById("lat").value = pt.lat().toFixed(6);
						document.getElementById("lng").value = pt.lng().toFixed(6);
						
					});
			

					GEvent.addListener(map, "moveend", function() {
						map.clearOverlays();
						var center = map.getCenter();
						var marker = new GMarker(center, {draggable: true});
						map.addOverlay(marker);
						document.getElementById("lat").value = center.lat().toFixed(6);
						document.getElementById("lng").value = center.lng().toFixed(6);
                       
						GEvent.addListener(marker, "dragend", function() {
							var pt = marker.getPoint();
							map.panTo(pt);
							document.getElementById("lat").value = pt.lat().toFixed(6);
							document.getElementById("lng").value = pt.lng().toFixed(6);
							
						});

					});

				}
			}
		);
	}
}
</script>
<script type="application/javascript">
// BEGIN NEW CODE TO AVOID USING BODY TAG FOR LOAD/UNLOAD

//function addLoadEvent(func) {
//  var oldonload = window.onload;
//  if (typeof window.onload != 'function') {
//   window.onload = func;
//  } else {
//    window.onload = function() {
//      if (oldonload) {
//        oldonload();
//      }
//     func();
//    }
//  }
//}
//
//addLoadEvent(initialise_map);
////
// //arrange for our onunload handler to 'listen' for onunload events
//if (window.attachEvent) {
//        window.attachEvent("onunload", function() {
//                GUnload();      // Internet Explorer
//        });
//} else {
//
//        window.addEventListener("unload", function() {
//                GUnload(); // Firefox and standard browsers
//        }, false);
//
//}
</script>
<h2>Update your Map</h2>

<form action="#" onsubmit="showAddress(this.address.value); return false">
	
	<p><span class="mark">*</span><strong>How to add your GPS coordinates:</strong></p>
	<p><strong>STEP1:</strong> Do a quick search for the street you are in.</p>
	<p><strong>STEP2:</strong> Drag the map or the arrow until you precisely pinpointed your location. <br />
		You may also switch to satelite view to see the buildings in a street.</p>
	
    <div class="input-append">
      <input class="span7" type="text" name="address" placeholder="- quick search your street -" value="<?PHP if(isset($BUSINESS_PHYSICAL_ADDRESS)){ echo $BUSINESS_PHYSICAL_ADDRESS;}?>">
      <input class="btn" type="submit" value="Search!"/>
	</div>

	<p id="helpText" class="help_block">&nbsp;</p>

	<p>NOTE: Double (<strong>left mouse</strong>) click to <strong>ZOOM IN</strong> | Double (<strong>right mouse</strong>) click to <strong>ZOOM OUT</strong></p>
</form>


<form method="post" action="<?php echo site_url('/');?>members/update_map_coordinates/<?php echo $ID;?>/" name="ItineraryCreator" id="form_example" style="margin:0; padding:0" enctype="multipart/form-data">
	
		<div style="display:block;position:relative;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center;height:350px;" id="map_container">
		    <div id="map" style="display:block;position:relative;width:100%;height:100%"></div>
        </div>
			<input id="lat" name="lat" type="hidden">			
			<input id="lng" name="lng" type="hidden">
            <input id="bus_id" name="bus_id" type="hidden" value="<?php echo $ID;?>">
            <input id="id" name="id" type="hidden" value="<?php echo $this->session->userdata('id');?>">		
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
