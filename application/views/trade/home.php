<?php 

//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
if(isset($title)){

 $header['title'] = $title . ' - My Namibia';
 $header['metaD'] = 'Buy or Sell '.$title. '. Find ' . $title .' online - My Namibia';
 $header['section'] = '';
 
}else{

 $header['title'] = '';
 $header['metaD'] = '';
 $header['section'] = '';
 
}

$this->load->view('inc/header', $header);

?>

<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<link rel="canonical" href="<?php $this->trade_model->build_canonical();?>" />

</head>

<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Library</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data</li>
      </ol>
  </div>
</nav>

<div class="container">

  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-4" id="sidebar">

      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather');?>
      <?php $this->load->view('inc/adverts');?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">

        <!--SEARCH/FILTER SECTION -->
        <?php // $this->load->view('trade/inc/filter/filter_'.$group); ?> 

        <!--<div class="spacer"></div>-->

        <br>
        <section id="products">
          
         <div class="col-md-12">

            <div id="deal_content">  

              <?php 
              /*Search Results
              Loop through the search results in the query array
              */  
              $this->trade_model->get_products($query , $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 15, $offset = 0, $title);
              //LOAD PAGINATION
              ?> 

            </div>   


            <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
                  
         </div>

        </section>

    </div>

  </div>  
  
</div>
  
<?php $this->load->view('inc/footer');?>  

<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>    
<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=5"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('[rel=tooltip]').tooltip();
    
    var progress = $('#feat_progress'),
    slideshow = $( '.feature-cycle-slideshow' ).cycle();
  
    slideshow.on( 'cycle-initialized cycle-before', function( e, opts ) {
      progress.stop(true).css( 'width', 0 );
    });
    
    slideshow.on( 'cycle-initialized cycle-after', function( e, opts ) {
      if ( ! slideshow.is('.cycle-paused') )
        progress.animate({ width: '100%' }, opts.timeout, 'linear' );
    });
    
    slideshow.on( 'cycle-paused', function( e, opts ) {
       progress.stop(); 
    });
    
    slideshow.on( 'cycle-resumed', function( e, opts, timeoutRemaining ) {
      progress.animate({ width: '100%' }, timeoutRemaining, 'linear' );
    });
  });
 
  function initiate_slides(){

    // Cycle plugin
    // Pause & play on hover
    var c = $('.cycle-slideshow').cycle('pause');
    c.hover(function () {
      //mouse enter - Resume the slideshow
      $(this).cycle('resume');
    },

    function () {
      //mouse leave - Pause the slideshow
      $(this).cycle('pause');
    });
    
    //$("input .star").rating();          

    window.setTimeout(initiate_rating, 100);

  }

  function initiate_rating(){
    
    $.getScript("<?php echo base_url('/')?>js/jquery.rating.pack.js", function(){
       
      $("input .star").rating();
     
    });
       
  }

  /*function initiate_pagination(){
    
    //PAGINATION
    $('.page-link').bind('click', function(e){
      
      e.preventDefault();
      var pre = $('#pre_loader');
      pre.removeClass('hidden');
      $('.page-link').find('li.active').removeClass('active');
      $(this).closest( "li" ).addClass('active');
      $.ajax({
           url: $(this).attr('href'),
           success: function(data) {
             pre.addClass('hidden');
             $("#deal_content").append(data);
             initiate_slides();
          }
       });
            
    });
    
  }*/


</script>

</body>
</html>