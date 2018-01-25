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
 <style type="text/css">
 #deal_content div.span3{
	 
	-webkit-transition: margin 100ms ease-in-out;
    -moz-transition: margin 100ms ease-in-out;
    -o-transition: margin 100ms ease-in-out;
	 
 }

 
 #deal_content div.white_box:hover{

  -moz-box-shadow:      0 0 10px #000;
	-webkit-box-shadow:  0 0 10px #000;
	box-shadow:         0 0 10px #000;
	
 }

ul.breadcrumb li.current{color:#FFF;text-shadow:none; }
 
 </style>
 <link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
 <link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
 <link rel="canonical" href="<?php $this->trade_model->build_canonical();?>" />
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
        
 		<div class="row-fluid">
        	<div class="span12">
                    <ul id="myTab" class="nav nav-pills nav-inverse">
                          <li class="active"><a href="#filtertb" data-toggle="tab"><i class="icon-search"></i> <span class="hidden-phone">Finder</span></a></li>
                          <li class=""><a href="#categorytb" data-toggle="tab"><i class="icon-list"></i> <span class="hidden-phone">Categories</span></a></li>
						  <li class=""><a href="#listtb" data-toggle="tab"><i class="icon-plus"></i> <span class="hidden-phone">Sell Your Stuff</span></a></li>
                          <li class="pull-right"><a href="#hidetb" data-toggle="tab"><i class="icon-chevron-up"></i> <span class="hidden-phone">Hide</span></a></li>
                    </ul>
             </div>
             <!--  <div class="span6 text-right">
                  <div class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-cog"></i></a>
                      <ul class="dropdown-menu pull-right" role="menu" aria-labelledby="dLabel">
                        <li><a tabindex="-1" href="#">Action</a></li>
                        <li><a tabindex="-1" href="#">Another action</a></li>
                        <li><a tabindex="-1" href="#">Something else here</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="#">Separated link</a></li>
                      </ul>
                    </div>
             	
             </div> -->          
        </div>
        
 		<div class="row-fluid">
        	<div class="span12">
                       <div id="myTabContent" class="tab-content">
                              <div class="tab-pane fade in active" id="filtertb">
								<?php 
                               //+++++++++++++++++
                               //FILTERS
                               //+++++++++++++++++
                               $this->load->view('trade/inc/filter/filter_'.$group);
                               ?>
                              </div>
                              <div class="tab-pane fade" id="categorytb">
                              
                                <div class="row-fluid">
                                    <div class="span7">
										<?php
                                       //+++++++++++++++++
                                       //LOAD CATEGORIES
                                       //+++++++++++++++++
                                       echo $this->trade_model->show_popular_cats($main_cat_id, 'main', $location);
                                       
                                       if(isset($sub_cat_id) && $sub_cat_id > 0){
                                           
                                            echo $this->trade_model->show_popular_cats($sub_cat_id, 'sub', $location);
                                            
                                       }
                                       if(isset($sub_sub_cat_id) && $sub_sub_cat_id > 0){
                                           
                                            echo $this->trade_model->show_popular_cats($sub_sub_cat_id, 'sub_sub', $location);
                                            
                                       }
                        
                                       
                                       ?>
                                    </div>
                                    <div class="span5 text-right">
										<?php 
                      
                                       //+++++++++++++++++
                                       //LOAD LOCATION LINKS
                                       //+++++++++++++++++
                                       echo $this->trade_model->show_location_items($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location, $suburb);
                                     
                        
                                       
                                       ?>
                                    </div> 
                                </div>
                             </div>
                             
                             <div class="tab-pane fade" id="listtb">
                             	<div class="row-fluid">
                                    <div class="span12 text-center">
                                    	<img src="<?php echo base_url('/');?>img/buttons/namibia_deals.png" alt="My Namibia Trade"/>
                                    </div>
                                </div>      
                                <div class="row-fluid">
                                    <div class="span6 text-right">
                                        <h3>Make some Cash</h3>
                                        <p>List an item in a few easy steps and turn them into hard CASH. <br />Your junk is another man's gold. Why not try it yourself today?</p>
                                        <?php if($this->session->userdata('id')){ ?>
                                        	<a href="<?php echo site_url('/').'sell/';?>" class="btn btn-success btn-large"><i class="icon-gift icon-white"></i> List an Item FREE</a>
                                    	<?php }else{ ?>
										
											<a href="<?php echo site_url('/').'members/register/';?>" class="btn btn-success btn-large"><i class="icon-plus-sign icon-white"></i> List an Item FREE</a>
										<?php } ?>
                                    </div>
                                    <div class="span6">
                                        <h3>Start an online Auction</h3>
                                        <p>Namibias first and only real online auction system. Set a starting bid and <br />reserve and watch the bids come flying in.</p>
                                        <?php if($this->session->userdata('id')){ ?>
                                        	<a href="<?php echo site_url('/').'sell/';?>" class="btn btn-success btn-large"><i class="icon-plus-sign icon-white"></i> Start an Auction</a>
										<?php }else{ ?>
											
											<a href="<?php echo site_url('/').'members/register/';?>" class="btn btn-success btn-large"><i class="icon-plus-sign icon-white"></i> Start an Auction</a>
										<?php } ?>
                                    </div>
                                 </div>   
                             </div>
                            
                            <div class="tab-pane fade" id="hidetb">
                            
                            
                            </div> 
                    </div>

            </div>
		</div>
          

 		<div class="clearfix">&nbsp;</div>
        <div class="row-fluid">
             <div class="span12">
                 <ul class="breadcrumb btn-inverse">
                    <?php $this->trade_model->show_categories_breadcrumb($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location, $suburb);
                        
                    ?>
                    <li class="active current"><?php echo $title;?></li>
                 </ul>
            </div>
        </div>
        <div class="row-fluid" id="feature_content">
            <div class="span12">
                <div class="product_ribbon_sml"><small>My Namibia &trade;</small> FEATURED LISTINGS<span></span></div>  
                <iframe src="<?php echo HUB_URL;?>main/products/" allowtransparency="1" frameborder="0" style="width:100%; min-height: 290px; overlow:hidden"></iframe>
			       <?php 
             //+++++++++++++++++
             //SHOW FEATURE SLIDER
             //+++++++++++++++++
      			 if(!$this->uri->segment(6)){
      				
      			 	//echo $this->trade_model->show_feature($main_cat_id, 'main');
      			 }
             ?>
            </div>
        </div>


        <div class="row-fluid">
                  
         	 	<?php 
				/*SIDEBAR
				span 3 for Sidebar content
				*/
				
				?> 
				 <div class="span12">
  
                 	<div id="deal_content">
					<?php 
                        /*Search Results
                        Loop through the search results in the query array
                        */	
                                
                           $this->trade_model->get_products($query, $main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $count, $offset, $title, $amt = '', $advert = TRUE, $pages);
    											
                        
                        //LOAD PAGINATION
                    ?> 
               		</div>               
					<div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
              		
              
         		</div>
               
               
                
         </div> 
         <div id="map_array"></div>
         <?php //LOAD MAP VIEW ?>
         <div class="row" id="map_container" style="display:none;">
             
            <div class="results_div" style="display:block;position:relative;background:url(<?php echo base_url('/');?>img/loading.gif) no-repeat center center #fff;height:550px;width:100%;max-width:none">
              <div id="map" style="display:block;position:relative;width:100%;height:100%;max-width:none"></div>
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
<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>    
<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>
<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('[rel=tooltip]').tooltip();
		
		var progress = $('#feat_progress'),
		slideshow = $( '.feature-cycle-slideshow' ).cycle();
	
		slideshow.on( 'cycle-initialized cycle-before', function( e, opts ) {
			progress.stop(true).css( 'width', 0 );
		});
		
		slideshow.on( 'cycle-initialized cycle-after', function( e, opts ) {
			if ( ! slideshow.is('.cycle-paused') )
				progress.animate({ width: '100%' }, opts.timeout, 'linear' );
		});
		
		slideshow.on( 'cycle-paused', function( e, opts ) {
		   progress.stop(); 
		});
		
		slideshow.on( 'cycle-resumed', function( e, opts, timeoutRemaining ) {
			progress.animate({ width: '100%' }, timeoutRemaining, 'linear' );
		});
	});
 
	function initiate_slides(){
		// Cycle plugin
	
		// Pause & play on hover
		var c = $('.cycle-slideshow').cycle('pause');
		c.hover(function () {
			//mouse enter - Resume the slideshow
			$(this).cycle('resume');
		},
		function () {
			//mouse leave - Pause the slideshow
			$(this).cycle('pause');
		});
		
		//$("input .star").rating();					

		window.setTimeout(initiate_rating, 100);

	}

	function initiate_rating(){
		
		$.getScript("<?php echo base_url('/')?>js/jquery.rating.pack.js", function(){
			 
		 	$("input .star").rating();
		 
		});
		
		
	}

	function initiate_pagination(){
		
		//PAGINATION
		$('div.pagination ul li a').bind('click', function(e){
			
			e.preventDefault();
			var pre = $('#pre_loader');
			pre.removeClass('hidden');
			$('div.pagination ul').find('li.active').removeClass('active');
			$(this).closest( "li" ).addClass('active');
			$.ajax({
					 url: $(this).attr('href'),
					 success: function(data) {
						 pre.addClass('hidden');
						 $("#deal_content").append(data);
						 initiate_slides();
					}
			 });
			
			
		});
		
	}


</script>
</body>
</html>