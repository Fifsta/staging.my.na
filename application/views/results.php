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

<div class="container-fluid">

  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-2 order-md-2 order-sm-1 order-lg-2" id="sidebar">
      
      <?php $this->load->view('inc/weather');?>
      
      <?php $this->load->view('inc/adverts');?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-10 order-md-1 order-sm-2">

        <!--SEARCH/FILTER SECTION -->
        <?php //$this->load->view('trade/inc/filter/filter_'.$group); ?>

        <div class="spacer"></div>

        <hr>
        <section id="results" id="normal_results_div">
          
         <div class="col-md-12">

            <?php $this->search_model->show_results($query, $main_c_id, $main_category, $category); ?> 
            
            <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
                  
         </div>

        </section>

    </div>

  </div>  
  
</div>
  
<?php $this->load->view('inc/footer');?>  

<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>

<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
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
</script>

</body>
</html>