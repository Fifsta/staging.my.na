 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
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
	   
    <div id="home-bak">
    
      <!-- Begin page content -->
       <div class="container" id="home_container">
       	 <div class="clearfix" style="height:20px;"></div>
		 <div class="row" style="height:auto;">
         	<div class="span12">
        		<h1>Heading <small>My Namibia &trade;</small></h1>
            </div>
            <div class="clearfix" style="height:80px;"></div>
			
         </div>
    
     <!-- Example row of columns -->
      <div class="row">
        <div class="span4">
          <h3>Browse popular categories</h3>
          <div id="pop_cats" style="min-height:400px;">
          <?php 
                    /*Search Popular Cats
                    */
                    
                    $this->search_model->show_popular_cats();
                    ?> 
          </div>          
        </div>
        <div class="span8">
         
       </div>
        <div class="span4">
          <h3>List your Business</h3>
          <p>Get your business for FREE and get in front of thousands of people everyday. Let Namibians do business with you and join the my.na revolution.</p>
          <p><a class="btn" href="#">Register &raquo;<?php echo $this->session->userdata('id');?></a></p>
        </div>
         <div class="span4">
         
       </div>
        <div class="span4">
          <h3>Play Scratch & Win</h3>
          <p>Create a free user account and stand a chance to win great prizes.</p>
          <p><a class="btn" href="#">Register &raquo;<?php echo $this->session->userdata('id');?></a></p>
        </div>
      </div>
     
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
     	<!-- /home-bak  -->
      	
        </div> 
      <div id="push"></div>
    </div>

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  

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