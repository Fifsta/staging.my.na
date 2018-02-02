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

<?php $this->load->view('inc/top_bar'); ?>

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

    <div class="col-sm-4 col-md-4 col-lg-4 col-xl-2 order-md-2 order-sm-1 order-lg-2" id="sidebar">
      
      <?php $this->load->view('inc/weather');?>
      
      <?php $this->load->view('inc/adverts');?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-8 col-xl-10 order-md-1 order-sm-2">

        <section id="results" id="">
           <div class="row">     

             <div class="col-md-12">

              <div class="heading">
                <h2 data-icon="fa-newspaper-o">Find Businesses<strong> in Namibia </strong></h2>
                <p>Browse all business listings here</p>
                <ul class="options">
                  <li><a href="#" data-icon="fa-edit">List my own</a></li>
                  <li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
                </ul>
              </div>

              <!--<h1 class="upper text-center"> FIND <span class="na_script yellow big_icon"><?php //echo $businessT;?></span> IN <span class="na_script big_icon"><?php //echo $locationT;?></span></h1>-->
              <div class="spacer"></div>  

                <div class="container-fluid">
                  <div class="row">

                    <div class="col-md-12">
                    <!--SEARCH/FILTER SECTION -->
                    <?php $this->load->view('business/inc/filter'); ?>
                    </div>
                      
                    <div class="col-md-6">
                      <h1 class="upper na_script"><?php echo $heading;?> <small> Results: <?php echo $count;?></small></h1>
                    </div>

                    <div class="col-md-6 text-right">

                      <div class="btn-group" data-toggle="buttons-radio">
                        <button type="button" id="sort_desc" class="btn btn-dark <?php if($sortby == 'DESC'){ echo ' active';}?>"><i class="fa fa-arrow-up text-light"></i> Z - A</button>
                        <button type="button" id="sort_asc" class="btn btn-dark <?php if($sortby == 'ASC'){ echo ' active';}?>"><i class="fa fa-arrow-down text-light"></i> A - Z</button>
                        <button type="button" id="sort_rate" class="btn btn-dark <?php if($sortby == ''){ echo ' active';}?>"><i class="fa fa-star text-light"></i></button>
                      </div>
                    </div>

                  </div><hr>
                  <div class="row">

                    <div class="col-md-4">
                      <div class="white_box">
                          <?php
                          /*Refine Search
                          Loop through categories
                          */

                          $this->search_model->show_sidebar($query);
                          ?>
                     </div>
                    </div> 

                    <div class="col-md-8">

                      <!--SEARCH RESULT SECTION -->
                      <?php $this->search_model->show_results($query, $main_c_id, $main_category, $category); ?>

                      

                      <?php 
                        //LOAD PAGINATION
                        if(isset($pages)){  echo $pages ;} 
                      ?>   

                    </div>
                  </div>
                </div>
                
                <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
            </div> 

        </div>
        </section>

        <div class="spacer"></div>

    </div>

  </div>  
  
</div>
  
<?php $this->load->view('inc/footer');?>  

<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/custom/results_page.js?v2"></script>


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