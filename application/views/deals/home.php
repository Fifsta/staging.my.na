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

</head>

<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
          <?php $this->deal_model->show_deals_breadcrumb($cat = '', $loc = '', $key = '');?>
      </ol>
  </div>
</nav>

<div class="container">

  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">

      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather');?>
      <?php $this->load->view('inc/adverts');?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-9 order-md-1 order-sm-2">

        <!--SEARCH/FILTER SECTION -->
        <?php // $this->load->view('trade/inc/filter/filter_'.$group); ?> 

        <!--<div class="spacer"></div>-->

        <section style="margin-bottom:20px">
			<div class="heading">
				<h2 data-icon="fa-star-o" itemprop="description">Current <strong>Deals</strong></h2>
				<p></p>
				<ul class="options">
					<!--<li><a href="https://nmh.my.na/main/subscribe/?type=featured_business" target="_blank"><i class="fa fa-edit text-dark"></i> Feature my Business</a></li>-->
				</ul>
			</div> 
        </section>	

        <section id="products">
          
         <div class="col-md-12">

            <div id="deal_content">

              <?php 
              /*Search Results
              Loop through the search results in the query array
              */  
              $this->deal_model->show_deals($query = '');
              //LOAD PAGINATION
              ?> 

            </div>   

            <?php 
              //LOAD PAGINATION
              if(isset($pages)){ echo $pages; } 
            ?>    

            <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
                  
         </div>

        </section>

    </div>

  </div>  
  
</div>
 
<div class="spacer"></div>  

<?php $this->load->view('inc/footer');?>  

<script type="text/javascript">
  $(document).ready(function(){
    $('[rel=tooltip]').tooltip();

  });


  function initiate_slides(){
    // Cycle plugin
    $('.slides').cycle({
      fx:     'fade',
      speed:   400,
      timeout: 200,
    }).cycle("pause");

    // Pause & play on hover
    $('.slideshow-block').hover(function(){

      $(this).find('.slides').addClass('active').cycle('resume');
      $(this).find('.slides li img').each(function (e) {
        $(this).attr('src', $(this).attr('data-original'));
      });

    }, function(){
      $(this).find('.slides').removeClass('active').cycle('pause');
    });

    //$("input .star").rating();          
    $("[rel=tooltip]").tooltip();
    window.setTimeout(initiate_rating, 100);

  }

  function initiate_rating(){

    $.getScript("<?php echo base_url('/')?>js/jquery.rating.pack.js", function(){

      $("input .star").rating();

    });


  }

  function initiate_pagination(){

    //PAGINATION
    $('div.pagination ul li a').bind('click', function(e){

      e.preventDefault();
      var pre = $('#pre_loader');
      pre.removeClass('hidden');
      $('div.pagination ul').find('li.active').removeClass('active');
      $(this).closest( "li" ).addClass('active');
      $.ajax({
        url: $(this).attr('href'),
        success: function(data) {
          pre.addClass('hidden');
          $("#deal_content").append(data);
          //initiate_slides();
        }
      });


    });

  }



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