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
       	 <div class="clearfix"></div>
		 <div class="row">

			  <?php 
             //+++++++++++++++++
             //LOAD SEARCH BOX
             //+++++++++++++++++
             
             $this->load->view('inc/home_search');
			 
			 //HEading Box
             ?>

        </div>

        <div class="clearfix">&nbsp;</div>     


        
        <div class="row-fluid">
        	<div class="span7">
				<h1>Search Index for <?php echo $title;?></h1>
            </div>
        	<div class="span5 text-right">
			
            </div> 
        </div> 
        <div class="row-fluid">
             <div class="span12">
                 <ul class="breadcrumb" style="background:transparent">
                	<li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                    	<a class="badge badge-inverse" href="<?php echo site_url('/');?>" itemprop="url"><span itemprop="title">My</span></a><span class="divider">/</span></li>
                    <li class="active" style="color:#000"><?php echo $title;?></li>
                 </ul>
             </div>
        </div>	   
        <div class="row-fluid">

        	<div class="span9">
				<?php 
              
			   //+++++++++++++++++
               //LOAD LOCATION LINKS
               //+++++++++++++++++
               $this->my_na_model->instant_search($key, '100');
			 

			   
               ?>
            </div>
            <div class="span3">
            	<?php $this->my_na_model->show_advert('');?>
            </div>
             
        </div>      	
	 </div> 
     <!-- /container - end content --> 
	 <div class="clearfix" style="height:100px;"></div>


    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
$this->load->view('inc/footer', $footer);
 //$this->output->enable_profiler(TRUE);
 ?>  
 <!-- /home-bak  -->
</div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src='<?php echo base_url('/')?>js/jquery.cycle.all.min.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
 <script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('[rel=tooltip]').tooltip();

		// Cycle plugin
		$('.slides').cycle({
			fx:     'fade',
			speed:   400,
			timeout: 200
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
	});      
</script>
</body>
</html>