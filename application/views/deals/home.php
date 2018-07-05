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

<script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>

<script type="text/javascript">
 

</script>

</body>
</html>