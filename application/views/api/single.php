 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = $title . ' - My Namibia';
	 $header['metaD'] = substr(strip_tags($description),0, 180). '. - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = $title . ' - My Namibia';
	 $header['metaD'] = substr(strip_tags($description),0, 180). '. - My Namibia';
	 $header['section'] = '';
	 
 }
 

  /*
  Get product Images
  */	        
  $images = $this->trade_model->show_images($product_id, $size = 'big');

  
  $product['product_id'] = $product_id;
  $product['bus_id'] = $bus_id;
  $product['client_id'] = $client_id;
  $product['product_title'] = $title;
  
  $img_str = $images['single'];
 
  //BUILD OPEN GRAPH
  $header['og'] =''; 
 //$this->load->view('api/inc/header_api', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script> 
 <link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css"> 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>css/jquery.countdown.css" >
 <link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
 <link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
 <style type="text/css">
	#prod_carousel .item {max-height:550px;overflow:hidden;}
	#prod_carousel .item img{width:100%; height:auto;}
	#printMessageBox{z-index:9999};
	textarea.redactor, #msg{width:100%}
	.carousel-caption{ background:rgba(255, 255, 255, 0.75)}
			   .btn-inverse, .btn-group, .add-on, .btn{ background:#00155F; color:#fff}
			   .badge, .badge.badge-inverse, .label{ background:#00155F; color:#fff}
			   .btn-inverse.active{ background:#110042} .btn-inverse:hover, .btn-inverse:focus{ background:#110042}
			  
				h1,h2,h3,h4,h5, .carousel-caption > h4{color:#00155F}
				td{font-size:12px}
	a.btn.btn-inverse{color:#fff}
 </style>
</head>

<body>


    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
     <!-- Begin page content -->
       <div class="container-fluid">
        <div class="row-fluid">
             <div class="span12">
               <h1 class="na_script"><?php echo $title;?></h1>
             </div>
        </div>
<!--        <div class="row-fluid">
             <div class="span12">
                 <ul class="breadcrumb" style="background:transparent">
                    <?php $this->trade_model->show_categories_breadcrumb($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id);?>
                    <li class="active" style="color:#000"><?php echo $title;?></li>
                 </ul>
             </div>
        </div> -->

        <div class="row-fluid">
                  
               <div class="span7">

                
                    <?php 
                        /*
                        GET RIBBON
                        */	        
                        echo $this->trade_model->get_product_ribbon($product_id, $extras, $featured, $listing_type, $start_price, $sale_price, $start_date, $end_date, $listing_date, $status);

                    ?>
                  
                    <?php 
                        /*
                        SHOW single product Images
                        */	        
                        echo $images['images'];

                    ?>
                </div>  
    
			   <div class="span5">
                     <div class="results_div">
                        <div id="product_details" style="width:100%">
                    	
						<?php 
						  /*
						  SHOW single product details
						  */	        
						  $this->api_model->show_product($product_id);
                                
                          ?>
                        </div>
                     </div>

 					<div class="clearfix">&nbsp;</div>
                    <div class="results_div">
                        
                       <?php 
                       //+++++++++++++++++
                       //LOAD REVIEW INC
                       //+++++++++++++++++

    				   $this->trade_model->show_reviews($product_id);
                       ?> 
                    </div>   
         		</div>
         	
               
                
         </div> 
       
       <div class="row-fluid">
                <div id="map_container">
  					 <?php 
                        /*
                        SHOW MAP
                        */	        
                        echo $this->trade_model->get_product_map($product_id, $extras);

                    ?>
               </div>
       </div>

       
       <div class="row-fluid">
       		<div class="span6">
            
                 <div class="results_div">    
                      
                         <h5 class="na_script">Ask Question</h5>
                         <?php 
                         //+++++++++++++++++
                         //LOAD CONTACT INC
                         //+++++++++++++++++
                         
                         $this->load->view('trade/inc/contact_inc', $product);
    
                         ?> 
                         
                 </div>
            
            </div>
            
       		<div class="span6">
						 <div class="clearfix">
                         <?php 
    
    				
						  /*
						  SHOW Company Info
						  */
						  echo $this->trade_model->show_estate_agent($property_agent, $bus_id , '', TRUE);	        
                          ?>
                          </div>
                          <div class="clearfix">&nbsp;</div>
                          <?php 
                         //+++++++++++++++++
                         //GET QUESTIONS
                         //+++++++++++++++++
                         
                         $this->trade_model->get_product_questions($product_id);    
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
 //$this->load->view('inc/footer', $footer);
  //$this->output->enable_profiler(TRUE);
 
 ?>  
 </div><!-- /wrap  -->
 
 <div class="modal hide fade in" id="img_modal_div" style="width:auto">
 	<img style="display*: inline;display:inline-block" src="<?php echo base_url('/');?>img/deal_place_load.gif" id="img_modal" />
 </div>   
    
    
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script data-cfasync="false" src='<?php echo base_url('/')?>js/jquery.cycle.all.min.js' type="text/javascript" language="javascript"></script>
<script data-cfasync="false" src="<?php echo base_url('/');?>js/jquery.rating.pack.js" type="text/javascript"></script>
<!--<script data-cfasync="false" src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>-->
<script data-cfasync="false" src="<?php echo base_url('/');?>js/print_page.js"></script>
<script data-cfasync="false" type="text/javascript">
$(document).ready(function(){
	$('[rel=tooltip]').tooltip();
/*	$('.redactor').redactor({ 	
				
				buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				 'alignment', '|', 'horizontalrule']
	});*/
	$("img.lazy").lazyload();
	$('#prod_carousel').carousel();
	$('#prod_carousel').on("slid", function(e) {
			//CURRENT ITEM
			var currItem = $('.active.item', this);
			//Get image selector
			currImage = currItem.find('img');
			//Remove class to not load again - probably unnecessary
			if(currImage.hasClass('lazy')){
				currImage.removeClass('lazy');
				currImage.attr('src', currImage.attr('data-original'));
			}
			//SCROLLING LEFT
			var prevItem = $('.active.item', this).prev('.item');
			//Account for looping to LAST image
			if(!prevItem.length){
				prevItem = $('.active.item', this).siblings(":last");
			}
			//Get image selector
			prevImage = prevItem.find('img');
			//Remove class to not load again - probably unnecessary
			if(prevImage.hasClass('lazy')){
				prevImage.removeClass('lazy');
				prevImage.attr('src', prevImage.attr('data-original'));
			}
			
			//SCROLLING RIGHT
			var nextItem = $('.active.item', this).next('.item');
			
			//Account for looping to FIRST image
			if(!nextItem.length){
				nextItem = $('.active.item', this).siblings(":first");
			}
	
			//Get image selector
			nextImage = nextItem.find('img');
			
			//Remove class to not load again - probably unnecessary
			if(nextImage.hasClass('lazy')){
				nextImage.removeClass('lazy');
				nextImage.attr('src', nextImage.attr('data-original'));
			}
			
    });
	$('#watch_btn').bind('click', function(e){
			e.preventDefault();
			save_watchlist();
			
	});

	<!-- Print Page -->
/*	$(".btnPrint").printPage({
	  url: "<?php echo site_url('/');?>trade/print_product/"+<?php print $product_id; ?>,
	  attr: "href",
	  message:"Your document is being created"
	});*/
	

	
	//window.setTimeout(load_similar, 2000);
});

window.fbAsyncInit = function() {
		
		FB.init({appId  : "287335411399195",status : true,cookie : true });
		
};

function img_show(str){
		
		var cont = $('#img_modal');
		$('#img_modal_div').bind('show', function() {
			//var id = $(this).data('id'),
			cont.attr('src','<?php echo base_url('/');?>assets/products/images/'+str); 	
				
				
		}).modal({ backdrop: true });

}
function load_similar(){
		
		var cont = $('#similar_div');
		
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/get_similar_products/'.$main_cat_id.'/'.$sub_cat_id.'/' .$product_id;?>' ,
			success: function (data) {	
				
				cont.html(data);
				cont.removeClass('loading_img');
			}
		});	

}
function load_product_details(){
		
		var cont = $('#product_details');
		cont.empty().hide();
		cont.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/show_product/' .$product_id;?>' ,
			success: function (data) {	
				
				cont.html(data).fadeIn();
				cont.removeClass('loading_img').fadeIn();
			}
		});	

}


function postToFeed(id, name, pic, caption, body, linkt) {
  
  var obj = {
	method: "feed",
	//redirect_uri: "'.site_url('/').'deals/encfb/'.$fb_share_key.'",
	link: "<?php echo site_url('/');?>product/"+id+"/"+linkt,
	picture: pic,
	name: name,
	caption: caption,
	description: body
  };
  function callback(response) {
	document.getElementById("msg").innerHTML = "Post ID: " + response["post_id"];
  }

  FB.ui(obj, callback);
}


function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function save_watchlist(){
	
		var btn = $('#watch_btn');
		btn.html('Saving...');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/add_watchlist/' .$product_id;?>' ,
			success: function (data) {	
				btn.html('<i class="icon-remove-circle icon-white"></i> Watching');
				
			}
		});	
	
}

function switch_auto_bid(){

	$("#bid_box").toggle();
	$("#auto_bid_box").delay(100).toggle();
	$("#auto_help_txt").fadeToggle();
}
</script>

</body>
</html>