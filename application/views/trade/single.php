<?php 

 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = $title . ' - My Namibia';
	 $header['metaD'] = substr(strip_tags($description),0, 180). '. - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = $title . ' - My Namibia';
	 $header['metaD'] = substr(strip_tags($description),0, 180). '. - My Namibia';
	 $header['section'] = '';
	 
 }

  $product['product_id'] = $product_id;
  $product['bus_id'] = $bus_id;
  $product['client_id'] = $client_id;
  $product['product_title'] = $title;

  $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();

  $name =  $BUSINESS_NAME;
  $email = $BUSINESS_EMAIL;
  $tel = '+'.$TEL_DIAL_CODE.' '.$BUSINESS_TELEPHONE;
  $fax = '+'.$FAX_DIAL_CODE.' '.$BUSINESS_FAX;
  $cell = '+'.$CEL_DIAL_CODE.' '.$BUSINESS_CELLPHONE;
  $description = $BUSINESS_DESCRIPTION;
  $pobox = $BUSINESS_POSTAL_BOX;
  $website = $BUSINESS_URL; 
  $address = $BUSINESS_PHYSICAL_ADDRESS;
  $city = $city;
  $region = $region;
  $startdate = $BUSINESS_DATE_CREATED;
  //$city = $bus_details['CLIENT_CITY'];
  $img = $BUSINESS_LOGO_IMAGE_NAME;
  $vt = $BUSINESS_VIRTUAL_TOUR_NAME;
  $advertorial = $ADVERTORIAL;
  //Get categories

  $rand = rand(0,9999);
  //Build image string
  $format = substr($img,(strlen($img) - 4),4);
  $str = substr($img,0,(strlen($img) - 4));
  
  $img_str = S3_URL.'assets/products/images/'.$image;

  if($img != ''){
    
    if(strpos($img,'.') == 0){

      $format = '.jpg';
      $img_str = 'assets/business/photos/'.$img . $format;
      $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
      
      
    }else{
      
      $img_str = 'assets/business/photos/'.$img;
      $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
      
      
    }
    
  }else{
      
      $img_str = 'assets/business/photos/images/bus_blank.png';
      $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');   
    
  }

  //COVER IMAGE
  $cover_img = $BUSINESS_COVER_PHOTO;

  if($cover_img != ''){
    
    if(strpos($cover_img,'.') == 0){

      $format2 = '.jpg';
      $cover_str = S3_URL.'assets/business/photos/'.$cover_img . $format2.'?='.$rand;
      
    }else{
      
      $cover_str =  S3_URL.'assets/business/photos/'.$cover_img.'?='.$rand;
      
    }
    
  }else{
    
    $cover_str = S3_URL.'assets/business/photos/bus_blank.jpg';  
    
  }

 
  //BUILD OPEN GRAPH <meta property="og:image:secure_url" content="'.$img_str.'" />
  $header['og'] ='
  <meta property="fb:app_id" content="287335411399195">
  <meta property="og:site_name" content="My Namibia"/>
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="'.site_url('/').'product/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/"> 
  <meta property="og:title"       content="'.$header['title'].'"> 
  <meta property="og:description" content="'.$header['metaD'].'"> 
  <meta property="og:image"       content="'.str_replace('https://','http://',$img_str).'">';

  $this->load->view('inc/header', $header);
   
  //ADDITIONAL RESOURCES
  //add css, IE7 js files here before the head tag

  //EXTRA REFERENCE
  $property_ref = '';
  if(is_array(json_encode($extras)) && array_key_exists('agency', json_decode($extras))){
     $artemp = (array)json_decode($extras);
     if($artemp['agency'] != ''){
  	  $property_ref = 'Ref: '.$artemp['agency']; 
     }  
  }

?>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>css/jquery.countdown.css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet" />
</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
  <div class="container">
    <ol class="breadcrumb">
       <?php $this->trade_model->show_categories_breadcrumb($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location, $suburb); ?>
       <li class="breadcrumb-item active"><?php echo $title;?></li>
    </ol>
  </div>
</nav>

<div class="container">

  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-3" id="sidebar">
      
      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather'); ?>
      <?php $this->load->view('inc/adverts'); ?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">

       <section id="listing">

        <div class="heading" style="margin-bottom:15px">
          <h2 data-icon="fa-briefcase"><?php echo $title; ?></h2>
          <ul class="options">    
            <li><a href="#Contact-Agent" data-icon="fa-envelope text-dark">Contact Agent</a></li>
            <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
            <li><a href="#" data-icon="fa-facebook text-dark"></a></li>
            <li><a href="#" data-icon="fa-twitter text-dark"></a></li>
            <li><a href="#" data-icon="fa-bookmark text-dark"></a></li>
          </ul>
        </div>

        <!--banner-->
        <div class="list-map">
          <div class="list-map-left" style="background:#ccc; position:relative">
              <div class="asso static-banner">
                <!--<a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/han.png"></a>
                <a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/ntb.png"></a>-->
              </div>
              <?php echo $this->trade_model->show_images($product_id);?>
          </div>
          
          <div class="list-map-right" id="map_container">
            <?php echo $this->trade_model->get_product_map($product_id, $extras); ?>
          </div>
        </div>
        <!--banner-->

        <!--details-->
            <?php $this->trade_model->show_product($product_id,$img_url); ?>
        <!--details-->

        <div class="spacer"></div>

        <!--tabs-->
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item" role="presentation"><a href="#Contact-Agent" class="nav-link active" aria-controls="Contact-Agent" role="tab" data-toggle="tab" data-icon="fa fa-envelope-o text-dark">Contact Agent</a></li>
        </ul>
        <div class="tab-content">
          <section role="tabpanel" class="tab-pane active" id="Contact-Agent">

            <?php $this->trade_model->show_company($bus_id, $property_agent, $sub_cat_id); ?>

            <?php $this->load->view('trade/inc/contact_inc'); ?>

          </section>
        </div>
        <!--tabs-->   

        <div class="spacer"></div>

        <!--tabs-->
        <ul class="nav nav-tabs" role="tablist">
          <li role="reviews" class="nav-item"><a href="#Reviews" class="nav-link active" aria-controls="Reviews" role="tab" data-toggle="tab" data-icon="fa fa-star-o text-dark">Reviews</a></li>
          <li role="submit-review" class="nav-item"><a href="#Submit-Review" class="nav-link" aria-controls="Submit-Review" role="tab" data-toggle="tab" data-icon="fa fa-star text-dark">Submit Review</a></li>
          <li role="question" class="nav-item"><a href="#Questions" class="nav-link" aria-controls="Question" role="tab" data-toggle="tab" data-icon="fa fa-question text-dark">Ask a Question</a></li>
        </ul>
        <div class="tab-content">
        
          <section role="tabpanel" class="tab-pane active" id="Reviews"></section>
          
          <section role="tabpanel" class="tab-pane" id="Submit-Review"></section>
          
          <section role="tabpanel" class="tab-pane" id="Questions">
            <?php 

              $pdat['product_id'] = $product_id;
              $pdat['product_title'] = $title;
              $pdat['client_id'] = $client_id;
              $pdat['bus_id'] = $bus_id;

              $this->load->view('trade/inc/questions', $pdat); 

            ?>
          </section>
          
        </div>

       </section>

       <div class="spacer"></div>

       <section>
        <!--tabs-->
        <div class="heading">
          <h2 data-icon="fa-newspaper-o">Similar <strong>Listings</strong></h2>
        </div>
        <div id="similar_div">

        </div>
       </section>

    </div>
  </div>  
</div>

 <div class="modal hide fade in" id="img_modal_div" style="width:auto">
    <img style="display*: inline;display:inline-block" src="<?php echo base_url('/');?>images/deal_place_load.gif" id="img_modal" />
 </div>

 <div class="modal hide fade" id="notification_modal">

     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin:5px 10px 0 0">&times;</button>
     <div class="modal-body" id="notification_modal_body">

          <img src="<?php echo base_url('/');?>images/bground/stick_man.png" class="pull-right" alt="List and buy anything namibian" />
          <h2>New Bid</h2>
          <p>A new bid has just been placed. Act quick to avoid disappointment</p>
          <div class="container-fluid">
              <div class="row-fluid">
                  <div class="col-md-10">
                      <div class="CT-tmer"></div>
                      <p>Current Bid is: </p>
                      <div id="current_bid_div"><h1 class="yellow big_icon"><small class="yellow">N$ </small></h1></div>
                  </div>
              </div>
          </div>

     </div>

 </div>
<div class="spacer"></div>

<?php $this->load->view('inc/footer');?>  
<script src="<?php echo base_url('/');?>js/print_page.js"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>


<script type="text/javascript">
$(document).ready(function(){


    $('#watch_btn').bind('click', function(e){
        e.preventDefault();
        save_watchlist();
        
    });

    //PRINT PAGE//
    $(".btnPrint").printPage({
      url: "<?php echo site_url('/');?>trade/print_product/"+<?php print $product_id; ?>,
      attr: "href",
      message:"Your document is being created"
    });

    window.setTimeout(load_similar, 4000);
    window.setTimeout(load_review, 3000);
    window.setTimeout(load_reviews, 2000);

    //window.setTimeout(load_questions, 1000);


    $('#owl-gallery').owlCarousel({
        loop:true,
        margin:10,
        lazyLoad: true,
        navRewind:false,
        nav: true,
        navText : ["<button class='btn owl-prev-next-button previous'></button>","<button class='btn owl-prev-next-button next'></button>"],
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:1,
                nav:true
            },
            1000:{
                items:1,
                nav:true,
                loop:false
            }
        }
    });

});


function save_watchlist(){
  
    var btn = $('#watch_btn');
    btn.html('Saving...');
    $.ajax({
      type: 'get',
      cache: false,
      url: '<?php echo site_url('/').'trade/add_watchlist/' .$product_id;?>' ,
      success: function (data) {  
        btn.html('<i class="icon-remove-circle icon-white"></i> Watching');
        
      }
    }); 
  
}


function initialise_similar_owl() {

    $('#similar').owlCarousel({
        loop:false,
        lazyLoad: true,
        navRewind:false,
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
                items:1,
                nav:true
            },
            1000:{
                items:3,
                nav:true,
                loop:false
            },

            1600:{
                items:4,
                nav:true,
                loop:false
            }           
        }
    });

}

function load_review(){
    
    var cont = $('#Submit-Review');
    
    $.ajax({
      type: 'get',
      cache: false,
      url: '<?php echo site_url('/').'trade/rate_product/'.$product_id; ?>' ,
      success: function (data) {  
        $.getScript( "<?php echo base_url('/');?>js/jquery.rating.pack.js" )
          .done(function( script, textStatus ) {
          
          });
        cont.html(data);
        cont.removeClass('loading_img');
      }
    }); 

}

function load_reviews(){
    
    var cont = $('#Reviews');
    
    $.ajax({
      type: 'get',
      cache: false,
      url: '<?php echo site_url('/').'trade/show_reviews/'.$product_id; ?>' ,
      success: function (data) {  
        
        cont.html(data);
        cont.removeClass('loading_img');
        $.getScript( "<?php echo base_url('/'); ?>js/jquery.rating.pack.js" )
          .done(function( script, textStatus ) {
          
          });
      }
    }); 

}

function load_similar(){ 
    
    var cont = $('#similar_div');
    
    $.ajax({
      type: 'get',
      cache: false,
      url: '<?php echo site_url('/').'trade/get_similar_products/'.$main_cat_id.'/'.$sub_cat_id.'/' .$product_id;?>' ,
      success: function (data) {  
        
        cont.html(data);
        cont.removeClass('loading_img');

        initialise_similar_owl();

      }
    }); 

}


function save_watchlist(){
  
    var btn = $('#watch_btn');
    btn.html('Saving...');
    $.ajax({
      type: 'get',
      cache: false,
      url: '<?php echo site_url('/').'trade/add_watchlist/' .$product_id;?>' ,
      success: function (data) {  

        if(data == 'add') {

          btn.html('<i class="fa fa-plus-circle text-light"></i> Watchlist');

        }

        if(data == 'remove') {

          btn.html('<i class="fa fa-times-circle text-light"></i> Watching');

        }        
        
      }
    }); 
  
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function switch_auto_bid(){
  $("#bid_box").toggle();
  $("#auto_bid_box").delay(100).toggle();
  $("#auto_help_txt").fadeToggle();
}


var current_bid = <?php if($current_bid != ''){ echo $current_bid; }else{ echo '0'; } ?>;

var bid_id = <?php if($bid_id != ''){ echo $bid_id;}else{ echo '0'; } ?>;

//SERVER EVENTS TO CHANGE CONTENT
if(typeof(EventSource) !== "undefined") {

    var source = new EventSource("<?php echo site_url('/');?>sse/product/<?php echo $product_id; ?>/"+bid_id);

    // NEW BID PLACED
    source.addEventListener('new_bid', function(e)
    {
        var data = JSON.parse(e.data);
        //console.log(e.data);
        //console.log(current_bid+' Wohooooo '+data.max_bid);
        if(data){
            //NEW BID
            if(data.max_bid > current_bid){

                $('#current_bid_div').html('<h1 class="yellow big_icon"><small class="yellow">N$ </small> '+data.amount+'</h1>');
                $('#notification_modal').modal('show');
                load_product_details();
            }
            current_bid = data.max_bid;
        }


    }, false);

<?php //IF EXPIRED

$now = date('Y-m-d H:i:s');
$end = date('Y-m-d H:i:s', strtotime($end_date));
if($end > $now){ ?>

  // ENDING SOON
  source.addEventListener('ending_soon', function(e)
  {
      var data = JSON.parse(e.data);
      console.log('ended');

      if(data){
          window.location.reload();
      }


  }, false);
  
<?php } ?>


} else {
  // Sorry! No server-sent events support..
}


</script>

</body>
</html>