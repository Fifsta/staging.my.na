 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = $heading . ' - My Namibia';
	 $header['metaD'] = $heading. '. Find ' . $heading .' online - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = '';
	 $header['metaD'] = '';
	 $header['section'] = '';
	 
 }
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 
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
    <div id="wrap">
    
      <!-- Begin page content -->
       <div class="container" id="home_container">
       	 <div class="clearfix" style="height:20px;"></div>
		 <div class="row">
         
         
			  <?php 
             //+++++++++++++++++
             //LOAD DEAL SEARCH BOX
             //+++++++++++++++++
             
             $this->load->view('deals/inc/deal_search');
			 
			 //HEading Box
             ?>
             <div class="span8">
                 <h1><?php echo $heading;?> <small><?php //echo $count;?></small></h1>
             </div>
             <div class="span4">
                 <div class="btn-group pull-right">
                 	  <!--<?php //Store search variables for Map ?>
                      <form id="map_search" name="map_search">
                      <input name="catM" id="categoryM" style="padding:11px;" type="hidden" value="<?php if($catM){ echo $catM;}else{ echo '0';}?>"/>
                      <input name="locM" id="locationM" style="padding:11px;" type="hidden" value="<?php if($locM){ echo $locM;}else{ echo '0';}?>"/>
                 	  <input name="busM" id="businessM" style="padding:11px;" type="hidden" value="<?php if($busM){ echo $busM;}else{ echo '0';}?>"/>
                 	   <?php //MAIN CATEGORY SEARCH ?>
                      <input name="MAINlocM" id="MAINlocM" style="padding:11px;" type="hidden" value="<?php if($MAINlocM){ echo $MAINlocM;}else{ echo '0';}?>"/>
                 	  <input name="MAINcatM" id="MAINcatM" style="padding:11px;" type="hidden" value="<?php if($MAINcatM){ echo $MAINcatM;}else{ echo '0';}?>"/>
                      
                      <button id="btn_list_view" style="margin-right:5px" class="btn btn-large disabled"><i class="icon-list"></i> List View</button>
                      <button id="btn_map_view" class="btn btn-large"><i class="icon-map-marker"></i> Map View</button>
                      </form>-->
                </div>
             </div>
        </div>
        <div class="row">
                  
         	 	<?php 
				/*SIDEBAR
				span 3 for Sidebar content
				*/
				
				?> 
				 <div class="span9">
                  <div class="results_div" style="padding-bottom:1px;">
                        <div class="alert alert-block">
                        <h3>What is My Namibia <span class="na_script" style="font-size:40px">Deals</span>?</h3>
                        <p>My Namibia deals finds Namibia’s best deals and shares them with the My Namibian Member . 
                        My Namibia deals is a direct marketing platform and not an online purchasing platform. This means no money is payed via the website.
                        A person interested in a deal has to be a My Namibia member to grab a deal . To list a deal , your business has to be listed on the My Namibia business directory . </p>
                        
                        <p>How does My Namibia Deals work ?</p>
                        <ol>
                          <li>Register as a My Namibia Member</li> 
                          <li>Click – “Grab deal “ button</li> 
                          <li>Confirm – Grab deal “</li>
                          <li>Receive your unique voucher with terms and conditions.</li> 
                          Note : Payments can be done be done by Cash , EFT or direct debit at the deal vendor .
                       </ol>
                        <a href="<?php echo site_url('/');?>members/" class="btn btn-inverse pull-right">List Your Own Deal</a>
                        <div class="clearfix" style="height:30px"></div>
                       </div>
                      
                 </div>   
                 <div id="deal_content" class="loadin_img" style="min-height:900px;width:100%">
					<?php 
                        /*Search Results
                        Loop through the search results in the query array
                        */	
                                
                            $this->deal_model->show_deals($query);
    
                        
                        //LOAD PAGINATION
                    ?> 
               		</div>               

              		<?php if(isset($pages)){ 
                            	echo $pages ;} 
                    ?>  
              
         		</div>
                <div class="span3">
                    
                    
                    
                    <div class="results_div">    
                    <h5>Deals by category</h5>
                    <?php 
                    /*Refine Search
                    Loop through categories
                    */
                    
                    $this->deal_model->show_sidebar();
                    ?> 
                   </div> 
                   
                   
                    
                    <?php 
                    /*Refine Search
                    Show register btn
                    */
                     if($this->session->userdata('id')){
						
					
					}else{
						 
						 echo '<div class="results_div">
						 		<h4>How to Redeem</h4>
                                <ul>
                                	<li>Create a FREE my.na Account</li>
									<li>Claim the Deal</li>
									<li>Receive your unique code</li>
									<li>Follow instructions</li>
                                </ul>
						 	   </div>';
						
					}
                   
                    ?> 
                               
                </div>
            	
               
                
         </div> 
         <div id="map_array"></div>
         <?php //LOAD MAP VIEW ?>
         <div class="row" id="map_container" style="display:none;">
             
            <div class="results_div" style="display:block;position:relative;background:url(<?php echo base_url('/');?>img/loading.gif) no-repeat center center #fff;height:550px;width:100%;max-width:none">
                    <div id="map" style="display:block;position:relative;width:100%;height:100%;max-width:none"></div>
             </div>      
         	
         </div>
               	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:100px;"></div>

  

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
  </div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

 <!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>-->
 <script type="text/javascript" src="<?php echo base_url('/');?>js/markerclusterer.js"></script>
 <script type="text/javascript" src="<?php echo  base_url('/');?>js/cluster-styles.js"></script>
 <script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('[rel=tooltip]').tooltip();
	
	load_deals();	
});


function load_deals(){
		
		var cont = $('#deal_content');
		cont.html('');
		cont.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'members/load_deals/0/10/all';?>',
			success: function (data) {	
				
				cont.html(data).fadeIn('300');
				cont.removeClass('loading_img');
			}
		});	

}
function load_home_feed(){
		
		var cont = $('#deal_content');
		cont.html('');
		cont.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'members/load_deals/0/10/all';?>' ,
			success: function (data) {	
				
				cont.html(data).fadeIn('300');
				cont.removeClass('loading_img');
			}
		});	

}
$(function() {
	
    $('.my_na_c').addClass('loading_img');
	$('[rel=tooltip]').tooltip();
	$('.my_na_c').each(function(e){
		
		my_na(this.id);

 	});
 	
});


$('#btn_map_view').live('click', function(e){
	
	e.preventDefault();
	var frm = $('#map_search');
		
	$('#results_row_list').slideUp('300');
	$('#map_container').fadeIn('400');
	$('#btn_map_view').addClass('disabled');
	$('#btn_list_view').removeClass('disabled');
		
		$.ajax({
			type: 'post',
			cache: false,
			url: '<?php echo site_url('/').'a/results_map/';?>' ,
			data: frm.serialize(),
			success: function (data) {

				     $('#map_array').html(data);	   	
			}
		});	
 
});


function loadScript() {
  var script = document.createElement("script");
  script.type = "text/javascript";
  script.src = "https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&callback=initialise_map";
  document.body.appendChild(script);
}

 

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
					
					infowindow = new google.maps.InfoWindow();
					
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
					
					//mc = new MarkerClusterer(map, markers, { maxZoom: 12, gridSize: 50});
					mc = new MarkerClusterer(map);

					var bounds = new google.maps.LatLngBounds();

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
					  
					  mc.addMarker(marker);
					  bounds.extend(myLatLng);
					  map.fitBounds(bounds);

					   google.maps.event.addListener(marker, 'click', function () {
							
							infowindow.setContent(this.html);
							
							infowindow.open(map, this); 
						});
					}
					
					
			} 
 
 $('#btn_list_view').live('click', function(e){
	 
	 e.preventDefault();
	 $('#btn_map_view').removeClass('disabled');
     $('#btn_list_view').addClass('disabled');		
   	 $('#results_row_list').slideDown('600');
	 $('#map_container').slideUp('300');
	 
 });


 $('#sort_asc').live('click', function(e){
	
	$('#sortby').val('ASC'); 
	var frm = $('#search-main');
	
	 frm.serialize();
	 frm.submit();
	 
	 
 });
  $('#sort_desc').live('click', function(e){
	
	$('#sortby').val('DESC'); 
	var frm = $('#search-main');
	
	 frm.serialize();
	 frm.submit();
	 
	 
 });
   $('#sort_rate').live('click', function(e){
	
	$('#sortby').val(''); 
	var frm = $('#search-main');
	
	 frm.serialize();
	 frm.submit();
	 
	 
 });
 

function my_na(id){
		
		var n = $('#'+id);
		var place = 'left';  
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'business/my_na/';?>'+id+'/'+place+'/' ,
			success: function (data) {	
				
				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect(id);
				n.removeClass('loading_img');
			}
		});	
		
}

function my_na_yes(id){
		
		var n = $('#'+id);
		n.find(".my_na").hide();
		n.addClass('loading_img');
		n.popover('destroy');

		var place = 'left'; 
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'business/my_na_click/';?>'+id+'/'+place+'/' ,
			success: function (data) {	
				
				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect(id);
				n.removeClass('loading_img');
				n.find(".my_na").show();
			}
		});	

}

function my_na_effect(id){
	
		$(function() {
			$("#"+id)
			.find("span")
			.hide()
			.end()
			.hover(function() {
				$(this).find("span").stop(true, true).fadeIn();
				
			}, function(){
				$(this).find("span").stop(true, true).fadeOut();
				
			});
		});	
	
}
       
</script>

</body>
</html>