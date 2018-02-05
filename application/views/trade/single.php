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
      $img_str = S3_URL.'assets/business/photos/'.$img . $format;
      
    }else{
      
      $img_str = S3_URL.'assets/business/photos/'.$img;
      
    }
    
  }else{
    
    $img_str = base_url('/').'images/bus_blank.png';  
    
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
    
    $cover_str = base_url('/').'images/bus_blank.jpg';  
    
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

<div class="container-fluid">

  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-2 order-md-2 order-sm-1 order-lg-2" id="sidebar">
      
      <?php $this->load->view('inc/weather'); ?>
      
      <?php $this->load->view('inc/adverts'); ?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-10 order-md-1 order-sm-2">

      <section id="listing">

        <div class="heading">
          <h2 data-icon="fa-briefcase"><?php echo $title; ?></h2>
          <ul class="options">    
            <li><a href="#Contact-Agent" data-icon="fa-envelope text-dark">Contact Agency</a></li>
            <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
            <li><a href="#Agency-Products" data-icon="fa-shopping-basket text-dark">Agency Products</a></li>
            <li><a href="#" data-icon="fa-facebook text-dark"></a></li>
            <li><a href="#" data-icon="fa-twitter text-dark"></a></li>
            <li><a href="#" data-icon="fa-bookmark text-dark"></a></li>
          </ul>
        </div>

        <!--banner-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-7 col-xl-6">
               <?php echo $this->trade_model->show_images($product_id); ?>
            </div>
            
            <div class="col-sm-12 col-md-12 col-lg-5 col-xl-6" style="padding:20px">
              <img src="<?php echo base_url('/') ?>images/map-temp.jpg" style="width:100%">
            </div>
          </div>
        </div>
        <!--banner-->

        <!--details-->
        <div class="details">
          <div class="details-left">

            <figure>
              <a href="#"><img src="<?php echo $img_str; ?>"></a>
            </figure>

            <div class="rating">
              <span></span><span></span><span class="active"></span><span></span><span></span>
              <a class="#">8 Reviews</a>
            </div>
          </div>
          <div class="details-right" style="background: #fff">

            <div class="spacer"></div>
               <div class="pull-right">
                <a href="javascript:void(0);" title="Print this Page" rel="tooltip" class="btn btn-dark btnPrint"><i class="fa fa-print text-light"></i></a>
               <?php $this->trade_model->watch_list_test($product_id);?>
               </div>                             
             <?php $this->trade_model->show_product($product_id); ?>
             <div class="spacer"></div>
          </div>
        </div>
        <!--details-->


      </section>  

      <div class="row">
        <div class="col-xl-6">

          <!--Review Include-->
          <div class="tab-content loading_img col-md-11" id="reviews_div">
            
          </div> 

        </div>  

        <div class="col-xl-6">
          
          <!--Question Include-->
          <div class="tab-content loading_img col-md-11" id="question_div">
             
          </div> 

        </div>  
      </div>
    </div>
  </div>  
</div>

<?php $this->load->view('inc/footer');?>  
<script src="<?php echo base_url('/');?>js/print_page.js"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>


<script type="text/javascript">
$(document).ready(function(){

    //PRINT PAGE//
    $(".btnPrint").printPage({
      url: "<?php echo site_url('/');?>trade/print_product/"+<?php print $product_id; ?>,
      attr: "href",
      message:"Your document is being created"
    });


    window.setTimeout(load_review, 3000);
    window.setTimeout(load_reviews, 2000);
    window.setTimeout(load_questions, 1000);


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


function load_review(){
    
    var cont = $('#review_div');
    
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
    
    var cont = $('#reviews_div');
    
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


function load_questions(){
    
    var cont = $('#question_div');
    
    $.ajax({
      type: 'POST',
      dataType: 'json',
      data: {product_id: <?php echo $product_id; ?>, product_title: '<?php echo $title; ?>'},
      url: '<?php echo site_url('/'); ?>trade/get_product_questions/',
      success: function (data) {  
        
        cont.html(data.questions);
        cont.removeClass('loading_img');
      }
    }); 

}


</script>

</body>
</html>