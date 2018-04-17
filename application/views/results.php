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
        <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">My.na</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $heading; ?></li>
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

      <section id="results">
            <div class="heading">
              <h2 data-icon="fa-folder-open-o"><?php echo $heading; ?></h2>
              <p>Want to list your business here? <a href="#">Try it out for free!</a></p>
                <a class="btn btn-dark pull-right" style="margin-top:5px; margin-right:5px;" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample" rel="tooltip" title="" data-original-title="Show business categories">
                  <i class="fa fa-folder"></i>
                </a>
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
  
<?php $this->load->view('inc/footer');?>  

<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script type="text/javascript" src="<?php echo  base_url('/');?>js/custom/results_page.js?v2"></script>



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