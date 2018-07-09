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
        <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">My.na</a></li>
        <li class="breadcrumb-item">Buy or Sell anything in Namibia</li>
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

        <section style="margin-bottom:20px">
            <div class="heading">
                <h2 data-icon="fa-money" itemprop="description">Buy & Sell <strong>anything in Namibia</strong></h2>
                <p></p>
                <ul class="options">
                    <!--<li><a href="https://nmh.my.na/main/subscribe/?type=featured_business" target="_blank"><i class="fa fa-edit text-dark"></i> Feature my Business</a></li>-->
                </ul>
            </div> 
        </section>  

        <section id="products">
          
          <div class="col-md-12">

            <section id="sell">

              <?php $this->load->view('adverts/video_buy_sell');?>
              <hr>
              <?php $this->load->view('adverts/video_auction');?>

            </section> 
                  
          </div>

        </section>

    </div>

  </div>  
  
</div>
 
<div class="spacer"></div>  

<?php $this->load->view('inc/footer');?>  

<script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>

<script type="text/javascript">



</script>

</body>
</html>