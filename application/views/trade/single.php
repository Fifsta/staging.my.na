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

  
  $product['product_id'] = $product_id;
  $product['bus_id'] = $bus_id;
  $product['client_id'] = $client_id;
  $product['product_title'] = $title;
  
  $img_str = S3_URL.'assets/products/images/'.$image;
 
  //BUILD OPEN GRAPH <meta property="og:image:secure_url" content="'.$img_str.'" />
  $header['og'] ='
  <meta property="fb:app_id" content="287335411399195">
  <meta property="og:site_name" content="My Namibia"/>
  <meta property="og:type"        content="website">
  <meta property="og:url"         content="'.site_url('/').'product/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/"> 
  <meta property="og:title"       content="'.$header['title'].'"> 
  <meta property="og:description" content="'.$header['metaD'].'"> 
  <meta property="og:image"       content="'.str_replace('https://','http://',$img_str).'">';

 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag

//EXTRA REFERENCE
$property_ref = '';
if(is_array(json_encode($extras)) && array_key_exists('agency', json_decode($extras))){
   $artemp = (array)json_decode($extras);
   if($artemp['agency'] != ''){
	  $property_ref = 'Ref: '.$artemp['agency']; 
   }  
}

 ?>
 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>css/jquery.countdown.css" >
<!-- <link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />-->
 <link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
 <link rel="stylesheet" href="<?php echo base_url('/');?>js/prettyPhoto_3.1.5/prettyPhoto.css" type="text/css" media="screen">


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
               //LOAD DEAL SEARCH BOX
               //+++++++++++++++++
               
               $this->load->view('inc/home_search');
               
               //HEading Box
               ?>
         </div>
        <div class="row-fluid">
             <div class="span12">
               <h1 class="upper na_script"><?php echo $title;?><span class="pull-right"><?php echo $property_ref;?></span></h1>
             </div>
        </div>
        <div class="row-fluid">
             <div class="span12">
                 <ul class="breadcrumb btn-inverse">
                    <?php $this->trade_model->show_categories_breadcrumb($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location, $suburb);
                        
                    ?>
                    <li class="active current"><?php echo $title;?></li>
                    <li class="hidden-phone pull-right"><span class="label label-warning"><?php echo $property_ref;?></span></li>
                 </ul>
            </div>
        </div> 

        <div class="row-fluid">


		        <div class="span5">
			        <div class="white_box  padding10">
				        <div id="product_details">

					        <?php
					        /*
							  SHOW single product details
							  */
					        $this->trade_model->show_product($product_id);

					        ?>
				        </div>
			        </div>

			        <div>
				        <?php
				        /*
						SHOW Company Info
						*/
				        $this->trade_model->show_company($bus_id, $property_agent, $sub_cat_id);

				        ?>
			        </div>

			        <div class="results_div">
				        <h3 class="na_script">Review the Product</h3>

				        <div class="loading_img span11" id="review_div">
					        <?php
					        //+++++++++++++++++
					        //LOAD REVIEW INC
					        //+++++++++++++++++

					        //$this->trade_model->rate_product($product_id);

					        ?>
				        </div>
				        <div class="loading_img span11" id="reviews_div">

					        <?php
					        //+++++++++++++++++
					        //SHOW REVIEWS
					        //+++++++++++++++++

					        //$this->trade_model->show_reviews($product_id);
					        ?>
				        </div>
				        <div class="clearfix">&nbsp;</div>
			        </div>
		        </div>
               <div class="span7">
                    <div class="white_box padding10" style="min-height:32px;">
                        &nbsp;
                        <?php
                        //Sharing buttons
                        $fb2 = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=<?php echo rawurlencode(str_replace('NEW/', '',current_url('/'))) ;?>', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%');";
                        $fb = "postToFeed(".$product_id.", '". trim($this->trade_model->clean_url_str($title)) ."','".trim($img_str)."', '".trim($this->trade_model->clean_url_str($title)) ." - My Namibia','".preg_replace("/[^0-9a-zA-Z -]/", "", trim($this->trade_model->shorten_string(strip_tags($description), 50)))."', '".site_url('/').'product/'.$product_id.'/'.trim($this->trade_model->clean_url_str($title))."')";
                        
                        $tweet_url = trim($this->trade_model->clean_url_str($title)).'&text='.trim(substr(strip_tags($title . ' ' . $title) ,0, 60)).' ' .site_url('/').'product/'.$product_id.'&via=MyNamibia';
                        
                        ?>
                        <a href="javascript:void(0);" 
                        onclick="window.open('https://twitter.com/share?url=<?php echo $tweet_url;?>&amp;via=MyNamibia', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%');" class="twitter"></a>
                        <a onclick="<?php echo $fb;?>"
	                        class="facebook" href="javascript:void(0);" style="margin-left:5px"></a>
                        <div class="pull-right">
							<a href="javascript:void(0);" title="Print this Page" rel="tooltip" class="btn btn-inverse btnPrint"><i class="icon-print icon-white"></i></a>
                            <?php $this->trade_model->watch_list_test($product_id);?>
                           
                        </div>
                    </div>
                    
                    	<?php 
							/*
							GET RIBBON
							*/	        
							echo $this->trade_model->get_product_ribbon($product_id, $extras, $featured, $listing_type, $start_price, $sale_price, $start_date, $end_date, $listing_date, $status);
	
						?>
                     <div id="product_images" class="loading_img" style="width:100%">
                    	<?php 
							/*
							SHOW single product Images
							*/	        
							//echo $images['images'];
	
						?>
                    </div>
                    <div class="row-fluid">
                       
                        <?php
				        /*
                        SHOW ADVERTS
                        */
                        if($main_cat_id == '3408') {

                            $advert = $this->my_na_model->show_trade_advert($main_cat_id , $sub_cat_id, $sub_sub_cat_id , 0, 1);
                            $n = rand(0, ($advert['count'] - 1));
                            echo '
								<div class="span5 ">'.$advert[0].'</div>
								<div class="span5 offset2 hidden-phone">
								    <div class="white_box">
								        <a href="https://www.my.na/adverts/track/57/54922948/" target="_blank">
								            <img class="lazy" alt="List your Properties for FREE" src="'.S3_URL.'assets/adverts/images/0f6a8b13fecffa4a5cae5d891b33abbf.jpg">
								        </a>
								     </div>
                                </div>
							 ';

                        }elseif($main_cat_id == '348'){

                            $advert = $this->my_na_model->show_trade_advert($main_cat_id , $sub_cat_id, 0 , 0, 2);
                            $n = rand(0, ($advert['count'] - 1));
                            echo '
								<div class="span5 ">'.$advert[0].'</div>
								<div class="span5 offset2 hidden-phone">
								  '.$advert[$n].'
                                </div>
							 ';

                        }else{

                            $advert = $this->my_na_model->show_trade_advert($main_cat_id , $sub_cat_id, 0 , 0, 2);
                            $n = rand(0, ($advert['count'] - 1));
                            echo '
								<div class="span5 ">'.$advert[0].'</div>
								<div class="span5 offset2 hidden-phone">
								  '.$advert[$n].'
                                </div>
							 ';

                        }



                   		?>
                        
                    </div>    

                    <div id="map_container">
  					 <?php 
                        /*
                        SHOW MAP
                        */	        
                        echo $this->trade_model->get_product_map($product_id, $extras);

                    ?>
                	</div>

                    <div class="results_div" id="contact_anchor">     
                            <div class="clearfix">&nbsp;</div>
                        
                            <h3 class="na_script">Ask Seller a Question</h3>
                           
                           
                               <div class="loading_img span11" id="question_div">
                               <?php 
                               //+++++++++++++++++
                               //GET QUESTIONS
                               //+++++++++++++++++
                               
                               //$this->trade_model->get_product_questions($product_id);
          
                               ?> 
                               </div>
                           <div class="clearfix">&nbsp;</div>     
   					 </div>

               </div>
    

         	
               
                
         </div> 
       
       <div class="row-fluid">
                  
         	 	<?php 
				/*SIDEBAR
				span 3 for Sidebar content
				*/
				
				?> 
				 <div class="span12 loading_img" id="similar_div">
                     
					 <?php 
                        /*
                        get similar products
                        */
						//$cat2 = $sub_cat_id;
						//$cat1 = $main_cat_id;
								        
                        //$this->trade_model->get_similar_products($cat1, $cat2, $product_id);
                        
                    ?>

         		</div>

         </div> 
       	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:100px;"></div>
     	
      	

   
  <div class="msg_div" id="msg"></div>
    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
  //$this->output->enable_profiler(TRUE);
 
 ?>  
 </div><!-- /wrap  -->
 
 <div class="modal hide fade in" id="img_modal_div" style="width:auto">
 	<img style="display*: inline;display:inline-block" src="<?php echo base_url('/');?>img/deal_place_load.gif" id="img_modal" />
 </div>

 <div class="modal hide fade" id="notification_modal">

     <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin:5px 10px 0 0">&times;</button>
     <div class="modal-body" id="notification_modal_body">

            <img src="<?php echo base_url('/');?>img/bground/stick_man.png" class="pull-right" alt="List and buy anything namibian" />
            <h2>New Bid</h2>
            <p>A new bid has just been placed. Act quick to avoid disappointment</p>
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="span10">
                        <div class="CT-tmer"></div>
                        <p>Current Bid is: </p>
                        <div id="current_bid_div"><h1 class="yellow big_icon"><small class="yellow">N$ </small></h1></div>
                    </div>

                </div>

            </div>


     </div>

 </div>
    
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>
<!--<script src="<?php /*echo base_url('/');*/?>js/jquery.rating.pack.js" type="text/javascript"></script>-->
<!--<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>-->
<script src="<?php echo base_url('/');?>js/print_page.js"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>
<script src="<?php echo base_url('/');?>js/prettyPhoto_3.1.5/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
$(document).ready(function(){


	/*$.getScript("<?php echo base_url('/');?>js/jquery.rating.pack.js", function(){

		$("input .star").rating();

	});*/
	//
	$('[rel=tooltip]').tooltip();
    /*	$('.redactor').redactor({
				
				buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				 'alignment', '|', 'horizontalrule']
	});*/
	$('#watch_btn').bind('click', function(e){
			e.preventDefault();
			save_watchlist();
			
	});

	<!-- Print Page -->
	$(".btnPrint").printPage({
	  url: "<?php echo site_url('/');?>trade/print_product/"+<?php print $product_id; ?>,
	  attr: "href",
	  message:"Your document is being created"
	});

	window.setTimeout(load_similar, 4000);
	window.setTimeout(load_review, 3000);
	window.setTimeout(load_reviews, 2000);
	window.setTimeout(load_questions, 1000);
	window.setTimeout(load_product_images, 100);


    $(".carousel-inner").cycle({
        fx:     "scrollHorz",
        timeout: 3000,
        speed: 300
        // choose your transition type, ex: fade, scrollUp, shuffle, etc...
    });

});


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
				$("img.lazy").lazyload();
			}
		});	

}

function load_review(){
		
		var cont = $('#review_div');
		
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/rate_product/' .$product_id;?>' ,
			success: function (data) {	
				$.getScript( "<?php echo base_url('/');?>js/jquery.rating.pack.js" )
				  .done(function( script, textStatus ) {
					
				  });
				cont.html(data);
				cont.removeClass('loading_img');
			}
		});	

}

function load_reviews(){
		
		var cont = $('#reviews_div');
		
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/show_reviews/' .$product_id;?>' ,
			success: function (data) {	
				
				cont.html(data);
				cont.removeClass('loading_img');
				$.getScript( "<?php echo base_url('/');?>js/jquery.rating.pack.js" )
				  .done(function( script, textStatus ) {
					
				  });
			}
		});	

}


function load_questions(){
		
		var cont = $('#question_div');
		
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/get_product_questions/' .$product_id.'/?'.http_build_query($product);?>',
			success: function (data) {	
				
				cont.html(data);
				cont.removeClass('loading_img');
			}
		});	

}

function load_product_images()
{

	var images = $('#product_images');

	$.ajax({
		type: 'get',
		cache: false,
		url: '<?php echo site_url('/').'trade/show_images/' .$product_id;?>' ,
		success: function (data) {
			images.html(data);
			images.removeClass('loading_img');
			$("a[rel^='prettyPhoto']").prettyPhoto(

				{social_tools: false}
			);

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

		}
	});


}


	function load_product_details(){
		
		var cont = $('#product_details');
		
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'trade/show_product/' .$product_id;?>' ,
			success: function (data) {	
				
				cont.html(data);
				cont.removeClass('loading_img');
			}
		});	
		

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



var current_bid = <?php if($current_bid != ''){echo $current_bid;}else{echo '0';}?>;
var bid_id = <?php if($bid_id != ''){echo $bid_id;}else{echo '0';}?>;
//SERVER EVENTS TO CHANGE CONTENT
if(typeof(EventSource) !== "undefined") {

    var source = new EventSource("<?php echo site_url('/');?>sse/product/<?php echo $product_id;?>/"+bid_id);

    // NEW BID PLACED
    source.addEventListener('new_bid', function(e)
    {
        var data = JSON.parse(e.data);
        //console.log(e.data);
        //console.log(current_bid+' Wohooooo '+data.max_bid);
        if(data){
            //NEW BID
            if(data.max_bid > current_bid){


                $('#current_bid_div').html('<h1 class="yellow big_icon"><small class="yellow">N$ </small> '+data.amount+'</h1>');
                $('#notification_modal').modal('show');
                load_product_details();
            }
            current_bid = data.max_bid;
        }


    }, false);

    <?php //IF EXPIRED
     $now = date('Y-m-d H:i:s');
     $end = date('Y-m-d H:i:s', strtotime($end_date));
     if($end > $now){ ?>

        // ENDING SOON
        source.addEventListener('ending_soon', function(e)
        {
            var data = JSON.parse(e.data);
            console.log('ended');

            if(data){
                window.location.reload();
            }


        }, false);
    <?php } ?>
   

    } else {
        // Sorry! No server-sent events support..
    }




</script>

</body>
</html>