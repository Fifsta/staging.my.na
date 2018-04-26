<?php 

//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
if(isset($heading)){

 $header['title'] = ucwords($heading) . ' - My Namibia';
 $header['metaD'] = ucwords($heading). '. Find ' . ucwords($heading) .' online - My Namibia';
 $header['section'] = '';

}else{
 
 $header['title'] = '';
 $header['metaD'] = '';
 $header['section'] = '';
 
}
$this->load->view('inc/header', $header);

?>

<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link rel="canonical" href="<?php $this->search_model->build_canonical();?>" />

<style type="text/css">
  #map-top{
  width:100%;
  min-height:500px;
  margin-right:-100px;
  }

  .fullwidth{padding:0; margin:0;max-width:100%;width:100%}
  .fullwidth .row-fluid{padding:0;margin:0;width:100%}
  .fullwidth .row-fluid .span8, .fullwidth .row-fluid{padding:0;margin:0;}
  #map_container .row-fluid{padding:0;margin:0;width:100%}
  #btn_list_view2{}
  #map_results_div{padding-left:40px;overflow-y:scroll}
  .gm-style-iw {
  width: 320px;
  min-height: 150px;
  }
</style>

</head>
<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">My.na</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $heading; ?></li>
      </ol>
  </div>
</nav>

<div class="container" id="home_container">


  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-4" id="sidebar">

      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather');?>
      <?php $this->load->view('inc/adverts');?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">

      <section id="results">
            <div class="heading">
              <h2 data-icon="fa-folder-open-o"><?php echo $heading; ?></h2>
              <p>Want to list your business here? <a href="#">Try it out for free!</a></p>
                <a class="btn btn-dark pull-right" style="margin-top:5px; margin-right:5px;" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" rel="tooltip" title="" data-original-title="Show business categories">
                  <i class="fa fa-folder"></i>
                </a>
                <button class="btn btn-dark pull-right t-map" id="btn_map_view" style="margin-top:5px; margin-right:5px;" rel="tooltip" title="" data-original-title="Show Map View">
                  <i class="fa fa-map-marker"></i> MAP VIEW
                </button>                
            </div>    

            <div class="collapse" id="collapseExample">
              <div class="sub well card bg-faded" style="background-color:#f5f5f5;">
                <div class="row" style="padding:10px">
                  <?php $this->search_model->bus_categories($query); ?>
                </div>
              </div> 
            </div>          

            <?php $this->load->view('business/inc/filter'); ?>   


            <div class="results-head">
              <span><strong><?php echo $count;?></strong> Results</span>
              Sort by:
              <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" id="sort_desc" class="btn btn-dark <?php if($sortby == 'DESC'){ echo ' active';}?>"><i class="fa fa-arrow-up text-light"></i> Z - A</button>
                <button type="button" id="sort_asc" class="btn btn-dark <?php if($sortby == 'ASC'){ echo ' active';}?>"><i class="fa fa-arrow-down text-light"></i> A - Z</button>
                <button type="button" id="sort_rate" class="btn btn-dark <?php if($sortby == ''){ echo ' active';}?>"><i class="fa fa-star text-light"></i></button>
              </div>
            </div>


            <div class="results-list">
            
              <?php $this->search_model->show_results($query, $main_c_id, $main_category, $category); ?>
              
            </div>

            <?php
              //LOAD PAGINATION
              if(isset($pages)){  echo $pages ;} 
            ?>   

        </section>  

        <div class="spacer"></div>

    </div>

  </div>  
  
</div>

 <div class="container" id="map_container" style="display:none ">
    
      <div class="heading">
        <h2 data-icon="fa-map-marker"> <a href="#">Namibia <strong>Map</strong></a></h2>
        <p>To benefit from this, make sure that you have location services enabled for this website.</p>
        <button id="btn_list_view2" style="margin-top:5px; margin-right:5px;" class="btn btn-dark t-list pull-right"><i class="fa fa-list"></i> List View</button>
      </div>
      <br>

        <!--Namibia Map-->
        <section id="namibia-map"> 
            <button id="map-toggle" class="btn btn-primary"><i class="fa fa-angle-double-right"></i></button>
            <div class="namibia-map">
              <div class="map-left">

                <?php echo $this->search_model->show_sidebar($query); ?>

              </div>
              <div class="map-right">
                <div id="map-top"></div>
              </div>
            </div>
        </section>
        <!--Namibia Map-->
    
 </div>
  
<?php $this->load->view('inc/footer');?>  

<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script src="<?php echo base_url('/');?>js/geolocationmarker-compiled.js"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/custom/results_page.js?v2"></script>


<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>

<script type="text/javascript">

var base = '<?php echo site_url('/');?>';
var base_ = '<?php echo base_url('/');?>';


$(function() {
  
  $('.my_na_c').addClass('loading_img');
  $('[rel=tooltip]').tooltip();
  $('.my_na_c').each(function(e){
    
    //my_na(this.id);

  });

  //setTimeout(initialise_map("map-side"),2000);

  <?php 
  if($c_type != 'main'){
    $d = "".$c_id."/sub/".$l_id;
    //echo 'load_results("sub","'.$c_id.'")';
    
  }else{
    $d = "".$main_c_id."/main/".$l_id;
    //echo 'load_results("main","'.$main_c_id.'")';
    
  }
  
  ?>
  
});

        var gicons = [];


        gicons["hover"] = new google.maps.MarkerImage(
            base_+'images/markers/v1/image.png?v1',
            new google.maps.Size(40,52),
            new google.maps.Point(0,0),
            new google.maps.Point(20,42)
        );

        gicons["dot"] = new google.maps.MarkerImage(
            base_+'images/markers/v1/dot/image.png?v1',
            new google.maps.Size(10,10),
            new google.maps.Point(0,0),
            new google.maps.Point(15,10)
        );



    function initialise_map(id) {

    var geocoder;
      var map;
      var markers = [];
      var locations = (function () { 

          var json = null;
          $.ajax({
            'async': false,
            'type': "get",
            'url': "<?php echo site_url('/').'map/results/'.$d;?>",
            'dataType': "json",
            'success': function (data) {
              json = data;
            }
          });

        return json;
      })(); 



        var side_bar_html = "";


        //geocoder = new google.maps.Geocoder();
        var myLatlng = new google.maps.LatLng(-22.583741,17.093782);

        var myOptions = {
        zoom:12,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        scrollwheel: false,
        zoomControl: true,
        zoomControlOptions: {
          style: google.maps.ZoomControlStyle.LARGE,
          position: google.maps.ControlPosition.LEFT_CENTER
        },
        streetViewControl:true,
        scaleControl:false,
        zoom: 14,
                //styles: styles
        }
       map = new google.maps.Map(document.getElementById(id), myOptions);

       geolocate(map);
             // Try HTML5 geolocation
      /* if(navigator.geolocation) {
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

        }*/
       setMarkers(map, locations);
       //document.getElementById("side_bar").innerHTML = side_bar_html;

    }


     function setMarkers(map, locations) {

          var infowindow = new google.maps.InfoWindow({
               maxWidth: 340
          });

         var bounds = new google.maps.LatLngBounds();

         //LOOP EACH JSON RESULT
        for (var i = 0; i < locations.length; i++) {

                   //identify marker
                    var bus_id = locations[i]['ID'];
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
                        animation: google.maps.Animation.DROP,
                        id: parseInt(locations[i]['ID'])
                    });
                    //var temp[bus_id] = marker;
                    markers[bus_id] = marker;
                    //markers.push(temp);
                    marker.setMap(map);

                    bounds.extend(myLatLng);


                    google.maps.event.addListener(marker, 'click', function () {
                          infowindow.setContent('<img src="'+base_+'images/load.gif"/>');
                          infowindow.open(map, this);
                          //console.log(this.html);
                              $.ajax({
                                    url: base+'map/show_map_info/'+ this.html+'/small/',
                                    cache:false,
                                    success: function (data) {
                                        infowindow.setContent(data);

                                    }
                                });
                    });

                  $('#business_result_'+marker.id).attr({"onmouseover":"markers["+marker.id+"].setIcon( gicons.hover)","onmouseout":"markers["+marker.id+"].setIcon(gicons.dot)"});


          }//END loop


          map.fitBounds(bounds);
           var clusterStyles = [
               {
                   textColor: 'white',
                   url: base_+'images/markers/v1/cluster1.png',
                   height: 50,
                   width: 50
               },
               {
                   textColor: 'white',
                   url: base_+'images/markers/v1/cluster2.png',
                   height: 50,
                   width: 50
               },
               {
                   textColor: 'white',
                   url: base_+'images/markers/v1/cluster3.png',
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

            data[0] = gicons["dot"];

            data[1] = new google.maps.MarkerImage(
                base_+'images/markers/v1/dot/shadow.png',
                new google.maps.Size(15,10),
                new google.maps.Point(0,20),
                new google.maps.Point(5,0)
            );
            data[2] = {
                coord: [7,0,8,1,9,2,9,3,9,4,9,5,9,6,9,7,8,8,7,9,2,9,1,8,0,7,0,6,0,5,0,4,0,3,0,2,1,1,2,0],
                type: 'poly'
            };


        }else{

            data[0] = gicons["dot"];

/*            data[1] = new google.maps.MarkerImage(
                base_+'img/markers/v1/shadow.png',
                new google.maps.Size(66,52),
                new google.maps.Point(0,20),
                new google.maps.Point(20,52)
            );*/
            data[1] = new google.maps.MarkerImage(
                base_+'images/markers/v1/dot/shadow.png',
                new google.maps.Size(15,10),
                new google.maps.Point(0,20),
                new google.maps.Point(5,0)
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
    function over_marker(id) {

        markers[id].setIcon({
            url: base_+'img/markers/v1/image.png',
            point: 0,
            coord: [17,0,19,1,20,2,21,3,22,4,23,5,24,6,24,7,25,8,25,9,25,10,25,11,25,12,25,13,25,14,25,15,24,16,24,17,23,18,23,19,22,20,22,21,21,22,21,23,20,24,19,25,19,26,18,27,18,28,17,29,17,30,16,31,15,32,15,33,14,34,14,35,11,35,11,34,10,33,10,32,9,31,8,30,8,29,7,28,7,27,6,26,6,25,5,24,4,23,4,22,3,21,3,20,2,19,2,18,1,17,1,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,0,8,1,7,2,6,2,5,3,4,4,3,5,2,6,1,8,0],
            type: 'poly',
            size: {"width": 40, "height":52},
            anchor:{"x": 20, "y":42}
        });

    }

    //loadresults
    function out_marker(id) {

        markers[id].setIcon({
            url: base_+'img/markers/v1/dot/image.png',
            point: 0,
            coord: [7,0,8,1,9,2,9,3,9,4,9,5,9,6,9,7,8,8,7,9,2,9,1,8,0,7,0,6,0,5,0,4,0,3,0,2,1,1,2,0],
            type: 'poly',
            size: {"width": 10, "height":10},
            anchor:{"x": 15, "y":10}
        });


    }

  //loadresults
  function load_results(type,cat) {

    $.ajax({
      'async': false,
      'type': "POST",
      'url': "<?php echo site_url('/').'map/result_ajax/';?>",
      'data': { 
        'cat': cat,
        'type': type
       },        
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


    var styles = [{"featureType":"administrative","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#fcfcfc"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#fcfcfc"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#eeeeee"}]},{"featureType":"water","elementType":"geometry","stylers":[{"visibility":"simplified"},{"color":"#dddddd"}]}];

</script>

</body>
</html>