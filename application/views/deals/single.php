 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = $SPECIALS_HEADER . ' - My Namibia';
	 $header['metaD'] = substr(strip_tags($SPECIALS_CONTENT),0, 180). '. - My Namibia Deals';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = $SPECIALS_HEADER . ' - My Namibia';
	 $header['metaD'] = substr(strip_tags($SPECIALS_CONTENT),0, 180). '. - My Namibia Deals';
	 $header['section'] = '';
	 
 }
 
 $img_str = base_url('/').'assets/deals/images/'.$SPECIALS_IMAGE_NAME;
 
  //BUILD OPEN GRAPH
  $header['og'] ='
  <meta property="fb:app_id" content="287335411399195"> 
  <meta property="og:type"        content="MyNamibia:Deals"> 
  <meta property="og:url"         content="'.site_url('/').'deal/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/"> 
  <meta property="og:title"       content="'.$header['title'].'"> 
  <meta property="og:description" content="'.$header['metaD'].'"> 
  <meta property="og:image"       content="'.$img_str.'">
  '; 
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

                  
         </div>

        </section>

    </div>

  </div>  
  
</div>
 
<div class="spacer"></div>  

<?php $this->load->view('inc/footer');?>  

<script type="text/javascript">
 

</script>

</body>
</html>