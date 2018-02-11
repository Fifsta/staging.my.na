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
              <h2 data-icon="fa-folder-open-o">Accommodation</h2>
              <p>Want to list your business here? <a href="#">Try it out for free!</a></p>
            </div>    
          

            
            <div class="sub well card bg-faded" style="background-color:#f5f5f5;">
              <p><a href="#" class="btn btn-default" data-icon="fa-angle-double-left">Go back to: Home</a></p>
              <ul class="row">
                <li class="col-sm-6 col-lg-4"><a href="#">Accounting <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Business and Society <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Cooperatives <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Customer Service <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">E-Commerce <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Education and Training <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Employment <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Human Resources <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Information Services <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">International Business and Trade <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Investing <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Major Companies <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Management <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Marketing and Advertising <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Opportunities <span class="badge">12</span></a></li>
                <li class="col-sm-6 col-lg-4"><a href="#">Small Business <span class="badge">12</span></a></li>
              </ul>
            </div>
          
            <div id="filter" class="col-sm-12">
              <form class="input-group input-group-lg">
                <div class="input-group-addon">Find:</div>
                <input type="text" class="form-control" id="exampleInputAmount" placeholder="Pizza, Lodge, Plumbing, ... etc">
                <div class="input-group-addon">Categories:</div>
                <select class="selectpicker form-control" multiple data-live-search="true" data-none-selected-text="Select categories">
                  <option>Jaccuzzi</option>
                  <option>Study</option>
                  <option>Library</option>
                  <option>Jaccuzzi</option>
                  <option>Study</option>
                  <option>Library</option>
                </select>
                <div class="input-group-addon">Near:</div>
                <input type="text" class="form-control" id="exampleInputAmount" placeholder="Windhoek">
                <span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search"></button></span>
              </form>
            </div>

            <div class="results-head col-sm-12">
              <span><strong>105</strong> Results</span>
              Sort by:
              <button class="btn btn-default btn-sm">Alphabet <i class="fa fa-sort"></i></button>
              <button class="btn btn-default btn-sm">Rating <i class="fa fa-sort"></i></button>
            </div>
            
            <div class="results-list">
            
              <?php $this->search_model->show_results($query, $main_c_id, $main_category, $category); ?>
              
            </div>
            
          
          
        
        </section>      

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