 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] =  $heading . ' - My Namibia &trade;';
 $header['metaD'] = $metaD;
 $header['section'] = 'home';
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
   
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 $this->load->view('inc/navigation', $nav);
 ?>
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
    
      <!-- Begin page content -->
       <div class="container" id="home_container">
       	 <div class="clearfix" style="height:20px;"></div>
		 <div class="row" style="height:auto;">
         	<div class="span12">
        		<h1><?php echo $heading;?> <small>My Namibia &trade;</small></h1>
            </div>
            <div class="clearfix" style="height:80px;"></div>
			
         </div>
    
     <!-- Example row of columns -->
      <div class="row">
        
        <div class="span12">
         	<div class="results_div">
         		<?php echo $body;?>
       		</div>
        </div>
        
        
      </div>
     
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:90px;"></div>
     	<!-- /home-bak  -->

  

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
  </div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript">
$('[rel=tooltip]').tooltip();

function load_sub_cats(id){
	 
	$('#pop_cats').html('<div style="text-align:center;padding-top:45%"><img src="<?php echo base_url('/');?>img/load.gif" /><br /><b>Loading...</b></div>');
	$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'my_na/get_sub_cats/';?>'+id ,
			success: function (data) {
				
				 $('#pop_cats').fadeIn().html(data);
				
				
			}
		});	
	
}

$('#reload_main').live('click',function(){

	$('#pop_cats').html('<div style="text-align:center;padding-top:45%"><img src="<?php echo base_url('/');?>img/load.gif" /><br /><b>Reloading...</b></div>');
	$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'my_na/reload_main_cats/';?>',
			success: function (data) {
				
				 $('#pop_cats').fadeIn().html(data);
				
				
			}
		});	
});
</script>

</body>
</html>