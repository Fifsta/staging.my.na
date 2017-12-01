 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = strip_tags($heading) . ' - My Namibia';
	 $header['metaD'] = strip_tags($heading). '. Find ' . strip_tags($heading) .' online - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = '';
	 $header['metaD'] = '';
	 $header['section'] = '';
	 
 }
 $this->load->view('inc/header', $header);
 
 //GET BUSINESS DETAILS
 $name =  $bus_details['BUSINESS_NAME'];
 $email = $bus_details['BUSINESS_EMAIL'];
 $tel = '+'.$bus_details['TEL_DIAL_CODE'] . $bus_details['BUSINESS_TELEPHONE'];
 $fax = '+'.$bus_details['FAX_DIAL_CODE'] . $bus_details['BUSINESS_FAX'];
 $cell = '+'.$bus_details['CEL_DIAL_CODE'] . $bus_details['BUSINESS_CELLPHONE'];
 $description = $bus_details['BUSINESS_DESCRIPTION'];
 $pobox = $bus_details['BUSINESS_POSTAL_BOX'];
 $website = $bus_details['BUSINESS_URL']; 
 $address = $bus_details['BUSINESS_PHYSICAL_ADDRESS'];
 $startdate = $bus_details['BUSINESS_DATE_CREATED'];
 $vt = $bus_details['BUSINESS_VIRTUAL_TOUR_NAME'];
 $advertorial = $bus_details['ADVERTORIAL'];
 $img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];
 $rand = rand(0,9999); 
 if($img != ''){
		
		if(strpos($img,'.') == 0){
	
			$format = '.jpg';
			$img_str = base_url('/').'img/timbthumb.php?w=200&h=200&src='.S3_URL.'assets/business/photos/'.$img . $format;
			
		}else{
			
			$img_str =  base_url('/').'img/timbthumb.php?w=200&h=200&src='.S3_URL.'assets/business/photos/'.$img;
			
		}
		
 }else{
		
		$img_str = base_url('/').'img/timbthumb.php?w=200&h=200&src='.base_url('/').'img/bus_blank.png';	
		
 }
  //COVER IMAGE
  $cover_img = $bus_details['BUSINESS_COVER_PHOTO'];
	
 if(trim($cover_img) != ''){
		
			if(strpos($cover_img,'.') == 0){
	
				$format2 = '.jpg';
				$cover_str = S3_URL.'assets/business/photos/'.$cover_img . $format2.'?='.$rand;
				
			}else{
				
				$cover_str =  S3_URL.'assets/business/photos/'.$cover_img.'?='.$rand;
				
			}
		
 }else{
		
		$cover_str = base_url('/').'img/business_cover_blank.jpg';	
		
 }
 	 
 $UAtel = 'href="javascript:void(0)"';
 $UAcell = 'href="javascript:void(0)"';
 if($this->agent->is_mobile()){
	
	$UAtel = 'href="tel:'.substr($tel,0,8).substr($tel,8,strlen($tel)).'"';
	$UAcell = 'href="tel:'.substr($cell,0,8).substr($cell,8,strlen($cell)).'"';
 }
 
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 <style type="text/css">
 .white_box{
	 
	-webkit-transition: margin 100ms ease-in-out;
    -moz-transition: margin 100ms ease-in-out;
    -o-transition: margin 100ms ease-in-out;
	 
 }
 
 #deal_content  .white_box:hover{

	margin-top:-2px;


    -moz-box-shadow:      0 0 10px #000;
	-webkit-box-shadow:  0 0 10px #000;
	box-shadow:         0 0 10px #000;
	
	 
 }
 
 
 </style>
 <link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
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
		 <div class="row">
         
         	
			  <?php 
             //+++++++++++++++++
             //LOAD SEARCH BOX
             //+++++++++++++++++
             
             $this->load->view('inc/home_search');
			 
			 //HEading Box
             ?>
             
        </div>
    	<!-- Listing content 2 column -->
        <div class="row-fluid">

            <!-- Left column -->
            <div class="span8 white_box padding10">
                 <div class="corner_ribbon" style="position:absolute">
                	<div id="<?php echo $bus_id;?>" class="my_na_c"></div>
             	 </div>
                 <div class="row-fluid vignette" style="min-height:300px;background:url(<?php echo $cover_str;?>) no-repeat;background-size: auto auto;z-index:88; position:relative">

                       <div class="row-fluid " style="height:250px;">
                                 		
                            <div class="span8">
                            
                            
                            </div>
                            
                            <div class="span4">
                            
                            
                            </div>
                       
                  
                 	  </div>
                 </div>
                 <div class="row-fluid" style="margin-top:-100px;z-index:99; position:relative">
                                 		
                            <div class="span1">
                            
                            </div>
                            <div class="span3">

                                    <img class="img-polaroid" src="<?php echo $img_str;?>" alt="<?php echo $name;?>" style="width: 150px; height:150px;">
                     
                            </div>
                            
                            <div class="span8">
                            
                            	 <div class="media">
                                    <div class="row-fluid" style="min-height:80px;">
                                    
                                        <div class="span6">
                                        <?php if(strlen($tel) > 5){ ?>
                                        <a class="btn btn-inverse" onClick="phone_click($(this),'phone')" <?php echo $UAtel;?> style="margin:5px 0;" rel="tooltip" title="click to view the full telephone number"> <abbr title="Phone">P:</abbr> <span itemprop="tel"><?php echo substr($tel,0,7);?><font style="display:none"><?php echo substr($tel,7,strlen($tel));?></font></span></a><br />
                                        <?php } ?>
                                        <?php if(strlen($cell) > 5){ ?>
                                        <a class="btn btn-inverse " onClick="phone_click($(this),'cell')" <?php echo $UAcell;?> style="margin:5px 0;" rel="tooltip" title="click to view cellular number"><abbr title="Cellular">C:</abbr> <?php echo substr($cell,0,8);?><font style="display:none"><?php echo substr($cell,8,strlen($cell));?></font></a><br />
                                        <?php } ?>
                                        </div>
                                        <div class="span6">
                                                               
                                         <?php if(strlen($fax) > 5){ ?>
                                        <a class="btn btn-inverse" onClick="phone_click($(this),'fax')" style="margin:5px 0;" rel="tooltip" title="click to view fax number"><abbr title="Fax">F:</abbr>  <?php echo substr($fax,0,8);?><font style="display:none"><?php echo substr($fax,8,strlen($fax));?></font></a><br />
                                        <?php } ?>
                                        <?php  if(strlen($website) > 5){ ?>
                                        <a class="btn btn-inverse" href="<?php  echo  prep_url($website);?>" target="_blank" style="margin:5px 0;" rel="nofollow" itemprop="url" title="Visit Website"><i class="icon-globe icon-white"></i> <?php echo substr( prep_url($website),0,20 );?>...</a><br />
                                        <?php } ?>
                                        </div>                           
                                    
                                    </div>
                                    <div itemscope style="display:none;padding:0;margin:0" itemtype="http://data-vocabulary.org/Organization"> 
                                    <span itemprop="name"><?php echo $name;?></span></div>

                                    <h1 style="font-size:150%"><?php echo $name;?></h1>
                                    <i class="icon-map-marker"></i>
                                    <span itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address"><?php echo $address ;?></span>   
                       			 </div>

                            </div>
  
                </div><!-- row -->
				<div class="row-fluid">
                                 		
                        <div class="span12">
                        <div class="clearfix" style="height:20px;"></div>
                            <ul class="breadcrumb">
                              <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>"  itemprop="url"><span itemprop="title">My</span></a> <span class="divider">/</span></li>
                              <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>a/show/all/all/all/none/" itemprop="url"><span itemprop="title">Businesses</span></a> <span class="divider">/</span></li>
                              <?php echo  implode(' ',$cats['breadcrumb']);?>
                              <li class="active"><?php echo $name;?></li>
                            </ul>
                        </div>
                       
                  
               </div>
               <div class="row-fluid">
                                 		
                        <div class="span6">
                         <?php 
						 echo '<p>'. implode(' ',$cats['links']).'</p>';
						 ?>
                        <div class="clearfix"></div>
						<?php if($bus_details['IS_NTB_MEMBER'] == 'Y'){ ?>
                        <img src="<?php echo base_url('/');?>img/icons/ntb_sml.png" alt="<?php echo $name;?> - NTB Member" />
                        
                        <?php } ?>
                        <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
                        <img src="<?php echo base_url('/');?>img/icons/han_sml.png" alt="<?php echo $name;?> - HAN Member" />
                        
                        <?php } ?>
                        </div>
                        
                        <div class="span6">
                        
                        <?php echo $this->business_model->get_review_stars_show($rating,$bus_id);?>

                        </div>
                       
                  
               </div>
            </div><!-- span 8 -->
            
            <div class="span4">
				<div class="row-fluid">
                	
					<?php 
                    if(!$business){
                        
                        echo $this->trade_model->show_estate_agent($agent_id, $bus_id, $name, TRUE);	
                        
					}else{


                        $advert = $this->my_na_model->show_trade_advert($main_cat_id, $sub_cat_id = 0, $sub_sub_cat_id = 0);
                        $n = rand(0, ($advert['count'] - 1));
                        echo '
								<div class="span9 offset3">'.$advert[0].'</div>

							 ';
					}
                    ?>
                   
				</div>
            </div>
        </div>


        <div class="row-fluid">
                  
         	 	<?php 
				/*SIDEBAR
				span 3 for Sidebar content
				*/
				
				?> 
				 <div class="span12">
                     <ul class="breadcrumb" style="background:transparent">
                        <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="badge badge-inverse" href="<?php echo site_url('/');?>" itemprop="url"><span itemprop="title">My</span></span></a><span class="divider">/</span></li>	
                        <li class="active" style="color:#000"><?php echo $heading;?></li>
                     </ul>
                     <h1><?php echo $title;?></h1>
                 	<div id="deal_content">
					<?php 
                        /*Search Results
                        Loop through the search results in the query array
                        */	
                                
                          $this->trade_model->get_products($query, $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 15, $offset = 0, $title = '',$amt = 4, $advert = FALSE);
    
                        
                        //LOAD PAGINATION
                    ?> 
               		</div>               

              		<?php if(isset($pages)){ 
                            	echo $pages ;} 
                    ?>  
              
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
 ?>  
 </div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>
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
		
		$('.my_na_c').addClass('loading_img');
	    //load_similar();
		my_na(<?php echo $bus_id;?>);
		
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
						 //initiate_slides();
					}
			 });
			
			
		});
		
	}
	
	
	function my_na(id){
			
			var n = $('#'+id);
			var place = 'left';  
			$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'business/my_na/';?>'+id+'/'+place+'/' ,
				success: function (data) {	
					
					n.html(data);
					$('[rel=tooltip]').tooltip();
					my_na_effect(id);
					n.removeClass('loading_img');
				}
			});	
			
	}
	
	function my_na_yes(id){
			
			var n = $('#'+id);
			n.find(".my_na").hide();
			n.addClass('loading_img');
			n.popover('destroy');
	
			var place = 'left'; 
			$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'business/my_na_click/';?>'+id+'/'+place+'/' ,
				success: function (data) {	
					
					n.html(data);
					$('[rel=tooltip]').tooltip();
					my_na_effect(id);
					n.removeClass('loading_img');
					n.find(".my_na").show();
				}
			});	
	
	}
	
	function my_na_effect(id){
		
			$(function() {
				$("#"+id)
				.find("span")
				.hide()
				.end()
				.hover(function() {
					$(this).find("span").stop(true, true).fadeIn();
					
				}, function(){
					$(this).find("span").stop(true, true).fadeOut();
					
				});
			});	
		
	}
	function phone_click(n,type){
			
			var num = n.find('font');
			num.slideDown();
			 
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'business/add_business_phone_click/'.$bus_id.'/';?>'+type ,
				success: function (data) {	
					
				}
			});	
	
	}
       
</script>

</body>
</html>