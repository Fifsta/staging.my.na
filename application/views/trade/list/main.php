 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	
	 $header['metaD'] = $heading. '. Find ' . $heading .' online - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 
	 $header['metaD'] = '';
	 $header['section'] = '';
	 
 }
 $this->load->view('inc/header', $header);

//TEMP PATCH FOR NMH LISTING CLASSIFIEDS
if($this->input->get('nmh_classifieds')){ ?>
	<link rel="stylesheet" href="<?php echo base_url('/');?>keyboard/css/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>keyboard/css/keyboard.css">
	<style type="text/css">
		.navbar,.footer,#back_to_all{display:none}
        #select_cats{}
	</style>
    <script src="<?php echo base_url('/');?>keyboard/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('/');?>keyboard/js/jquery.keyboard.js"></script>
	<script>
	function init_keyboard(){
			$('#item_content').show().css({'background-color':'#fff', 'color':'#333', 'border':'1px solid #ccc'});
			$('.redactor-toolbar ,.redactor-editor').hide();
			$('.keyboard-numbers').keyboard({
				layout: 'custom',
				autoAccept : true,
				customLayout: {
					'default' : [
						'7 8 9',
						'4 5 6',
						'1 2 3',
						'0',
						'{bksp} {accept}'
					]
				}
			});
			$('.keyboard-email').keyboard({
				layout: 'custom',
				autoAccept : true,
				customLayout: {
					'default' : [
						'1 2 3 4 5 6 7 8 9 0 {bksp}',
						'q w e r t y u i o p',
						'a s d f g h j k l',
						'z x c v b n m @ .',
						'{space} .com .com.na _ - {accept}'
					]
				}
			});
			$('.keyboard-normal').keyboard({
				layout: 'custom',
				autoAccept : true,
				customLayout: {
					'default' : [
						'1 2 3 4 5 6 7 8 9 0',
						'q w e r t y u i o p',
						'a s d f g h j k l {bksp}',
						'{shift} z x c v b n m {shift}',
						'{space} - {accept}'
					],
					'shift' : [
						'Q W E R T Y U I O P',
						'A S D F G H J K L {bksp}',
						'{shift} Z X C V B N M {shift}',
						'{space} - {accept}'
					]
				}
			});
	}
	
	</script>
<?php } else{ ?>
	<script>
	function init_keyboard(){
			
	}
	
	</script>
	
<?php }
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>


	<style type="text/css">
		
		div.thumbnail:hover{opacity:0.9; cursor:pointer; border:4px solid #093;margin-top:-3px}
		strong.text-danger{color:#BD362F;}
		div#home_container{min-height:500px}
        #search-cat_b .tt-dropdown-menu{max-height:300px;overflow-y: scroll}
	</style>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/animate_test.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui-noscript.css"></noscript>
    <script data-cfasync="false" type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places" ></script>  
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 $this->load->view('inc/navigation', $nav);
 
 $full = '';
 if($step == 'step0'){
	 
	$full = '-fluid'; 
 }

 //SERVICE URL
 if(isset($type) && $type != ''){


     $data['type'] = $type;
     $type_str = '&type='.$type;
 }else{
     $type = 'general';
     $data['type'] = $type;
     $type_str = '&type=general';
 }

 ?>
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">  
    
      <!-- Begin page content -->
       <div class="container" id="home_container">
       	 <div class="clearfix">&nbsp;</div>
		 <div class="row-fluid">
                <div class="span12">
                    <div class="row-fluid">

                        <div class="text-center">

                            <?php

                            //+++++++++++++++++
                            //LOAD SEARCH BOX
                            //+++++++++++++++++
                            $data['bus_id'] = $bus_id;

                            if($step == 'step0'){

                                if($type == 'auction'){
                                    echo '<h1>Create an Auction as</h1>';
                                    $type_str = '&type=auction';

                                }elseif($type == 'motor'){
                                    $type_str = '&type=motor';
                                    echo '<h1>List Anything Automotive as</h1>';

                                }elseif($type == 'property'){
                                    $type_str = '&type=property';
                                    echo '<h1>List a Property as</h1>';

                                }elseif($type == 'service'){
                                    $type_str = '&type=service';
                                    echo '<h1>List a Business Service as</h1>';

                                }else{
                                    $type_str = '&type=general';
                                    echo '<h1>List an Item as</h1>';

                                }


                            }
                            $next_hide = 'hide';
                            // PRIVATE
                            if($bus_id == 0 && $private == 'yes') {

                                echo '<div style="min-height:90px">';
                                $next_hide = '';
                                $selB = $this->my_na_model->get_businesses($bus_id, $typestr ='', $type = $type_str);
                                echo '<div class="row-fluid" id="sel_bus_none">
                                            <div class="span4">
                                            </div>
                                            <div class="span4 text-center">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse">' . $this->session->userdata('u_name') . '</a>
                                                <a href="javascript:void(0)" onclick="change_select(2)"><i class="icon-pencil"></i></a>
                                            </div>
                                            <div class="span4">
                                            </div>
                                       </div>
                                ';

                                echo '<div class="row-fluid hide" id="sel_bus_yes">
                                        <div class="row-fluid">
                                            <div class="span5 text-right">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse" onclick="change_select(0)">' . $this->session->userdata('u_name') . '</a>
                                            </div>
                                            <div class="span2">
                                                <h1 style="margin-top:20px">OR</h1>
                                            </div>
                                            <div class="span5 text-left">
                                                ' . $selB . '
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span8 offset2">
                                                <div class="alert clearfix">
                                                    <h3>List Your Product Privately or Under Business?</h3>
                                                    <p>There are two different ways to list a product. You can list a product privately or under a business you manage.</p>
                                                    <p>Please select if you want to proceed listing a product privately or under a business.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';

                                echo '</div>';
                            //BUSINESS OR PRIVATE
                            }elseif($bus_id == 0){

                                echo '<div style="min-height:90px">';

                                $selB = $this->my_na_model->get_businesses($bus_id,  $typestr ='', $type = $type_str);
                                echo '<div class="row-fluid hide" id="sel_bus_none">
                                            <div class="span4">
                                            </div>
                                            <div class="span4 text-center">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse">' . $this->session->userdata('u_name') . '</a>
                                                <a href="javascript:void(0)" onclick="change_select(2)"><i class="icon-pencil"></i></a>
                                            </div>
                                            <div class="span4">
                                            </div>
                                       </div>
                                ';

                                echo '<div id="sel_bus_yes">
                                        <div class="row-fluid">
                                            <div class="span5 text-right">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse" onclick="change_select(0)">' . $this->session->userdata('u_name') . '</a>
                                            </div>
                                            <div class="span2">
                                                <h1 style="margin-top:20px">OR</h1>
                                            </div>
                                            <div class="span5 text-left">
                                                ' . $selB . '
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span8 offset2">
                                                <div class="alert clearfix">
                                                    <h3>List Your Product Privately or Under Business?</h3>
                                                    <p>There are two different ways to list a product. You can list a product privately or under a business you manage.</p>
                                                    <p>Please select if you want to proceed listing a product privately or under a business.</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                ';

                                echo '</div>';

                            //BUSINESS
                            }else{

                                $next_hide = '';
                                echo '<div style="min-height:90px">';

                                $selB = $this->my_na_model->get_businesses($bus_id, $typestr ='',  $type = $type_str);
                                echo '<div class="row-fluid" id="sel_bus_none">
                                            <div class="span4">
                                            </div>
                                            <div class="span4 text-center">

                                                <img src="'. $this->my_na_model->get_business_logo($bus_id, 60, 60, $logo).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse">'. $business_name.'</a>
                                                <a href="javascript:void(0)" onclick="change_select(2)"><i class="icon-pencil"></i></a>
                                            </div>
                                            <div class="span4">
                                            </div>
                                       </div>
                                ';

                                echo '<div class="hide" id="sel_bus_yes">
                                        <div class="row-fluid">
                                            <div class="span5 text-right">


                                                <a class="btn btn-inverse" href="'.site_url('/').'sell/index/0/?private=true'.$type_str.'" >'. $this->session->userdata('u_name').'</a>
                                                <img src="'. $this->my_na_model->get_user_avatar_str('60','60').'" style="width:60px;height:60px;margin:10px 0px 10px 10px" class="img-polaroid img-circle" />
                                            </div>
                                            <div class="span2">
                                                <h1 style="margin-top:20px">OR</h1>
                                            </div>
                                            <div class="span5 text-left">
                                                '. $selB.'
                                            </div>
                                        </div>
                                        <div class="row-fluid">
                                            <div class="span8 offset2">
                                                <div class="alert clearfix">
                                                    <h3>List Your Product Privately or Under Business?</h3>
                                                    <p>There are two different ways to list a product. You can list a product privately or under a business you manage.</p>
                                                    <p>Please select if you want to proceed listing a product privately or under a business.</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                ';

                                echo '</div>';




                            }



                            //HEading Box

                            ?>
                        </div>
                    </div>

                    <div class="padding10 row-fluid <?php echo $next_hide;?>" id="admin_content">

                        <?php  $this->load->view('trade/list/step'.$step, $data);?>

                    </div>
               </div>
 
              <div class="clearfix" style="height:100px;"></div>   
        </div>
        

               
 		<div class="row-fluid" >
				 <div class="span12">
<!--					<a class="btn test-animate">Test</a>
                    <a class="btn test-animate2">Test</a>-->
         		</div> 
        </div>        	   


        <div class="row-fluid">
 
				 <div class="span12">
                     
         		</div> 
         </div>

         
               	
	 </div> 
     <!-- /container - end content --> 
   

    <?php 
	if(isset($error)){
		echo '<div class="msg_div" id="msg">'.$error.'</div>';
	}
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
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />

 <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>

  
<script type="text/javascript">

    var type = "<?php echo $type;?>", type_str = "<?php echo $type_str;?>", auction = <?php echo $auction;?>;
    $(document).ready(function(){
		  $('[rel=tooltip]').tooltip();
		  //window.scrollTo(0,$('#anchor_me').offset().top);
		init_keyboard();
		
		<?php if($step == 0){
			
			echo "	var contM = $('#home_container');
					contM.addClass('container-fluid').removeClass('container');
					";
					
			
			}?>
		$('.test-animate').bind('click', function(e){
			var contM = $('#admin_content');
			contM.addClass('slideLeft');
				
		});
		$('.test-animate2').bind('click', function(e){
			var contM = $('#admin_content');
			contM.removeClass('slideIn');
				
		});
	});

function populateSuburb(cityID)
  {
	  $("#suburb_div").html('<div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div>');
	  $.ajax({
		 url: "<?php echo site_url('/');?>trade/populate_suburb_name/"+cityID+"/0",
		success: function(data) {
		  $("#suburb_div").html(data);
		  
		}
	  });	
  }


function togglecheck(val){
			
	var chk = $('#listing_type');
	chk.val(val);
	if(val == 'A'){
		$('#sale_click').removeClass('btn-success');
		$('#auction_click').addClass('btn-success');
		$('#auction_pricing').slideDown();	
		$('#fixed_pricing').slideUp();
	}else{
		$('#sale_click').addClass('btn-success');
		$('#auction_click').removeClass('btn-success');
		$('#auction_pricing').slideUp();	
		$('#fixed_pricing').slideDown();
	}
}

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//LOAD CATEGORIES
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 


function load_ajax_product_cat(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name, bus_id, typel){
		
		var n = $('#select_cats');
		n.html('<div class="span3" style="text-align:center;margin-top:125px;width:100%"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Getting Categories...</div>');

		$.ajax({
			type: 'post',
			data:{	cat1: cat1, cat1name: cat1name, 
					cat2: cat2, cat2name: cat2name,
					cat3: cat3, cat3name: cat3name,
					cat4: cat4, cat4name: cat4name, type: typel},
			cache: false,
			url: '<?php echo site_url('/').'trade/load_product_categories/'.$bus_id.'/?type=';?>'+typel ,
			success: function (data) {	
				
				n.html(data).fadeIn('300');
				
				
			}
		});	

}


function go_step_3(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name,bus_id, typel){
	
	var cont = $('#admin_content');
	cont.html('<div class="span3" style="text-align:center;margin-top:125px;width:100%"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Loading...</div>');
	
		//console.log(cat1+"-"+cat2+"-"+ cat3+"-"+cat4);
		$.ajax({
			type: 'post',
			data:{	cat1: cat1,  cat1name: cat1name,  
					cat2: cat2,  cat2name: cat2name, 
					cat3: cat3,  cat3name: cat3name, 
					cat4: cat4,  cat4name: cat4name , type: typel},
			cache: false,
			url: '<?php echo site_url('/').'sell/step2/'.$bus_id.'/';?>' ,
			success: function (data) {	
				
				cont.html(data).fadeIn('300');
				init_keyboard();
			}
		});	
	
}

function add_categories(cat1, cat2, cat3, cat4){
	
	console.log(cat1+"-"+cat2+"-"+ cat3+"-"+cat4);
	
}




<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//BACK
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 


function back_(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name, ltype){
	
	if(cat4 > 0){
		
		load_ajax_product_cat(cat1, cat1name, cat2, cat2name, cat3, cat3name , 0 ,'_',<?php echo $bus_id;?>, ltype);
		
	}else if(cat3 > 0){
		
		load_ajax_product_cat(cat1, cat1name, cat2, cat2name,0 ,'_', 0 ,'_',<?php echo $bus_id;?>, ltype);
		
	}else if(cat2 > 0){
		
		load_ajax_product_cat(cat1, cat1name,0 ,'_', 0 ,'_',0 ,'_',<?php echo $bus_id;?>, ltype);
		
	}else if(cat1 > 0){
	
		load_ajax_product_cat(0,'_', 0,'_', 0,'_', 0,'_',<?php echo $bus_id;?>, ltype);
	}else{
		
		load_ajax_product_cat(0,'_', 0,'_', 0,'_', 0,'_',<?php echo $bus_id;?>, ltype);
	}
	
}

function back_to_all(){
	
	var btn = $('#back_to_all');
	btn.html('Working...');
	load_ajax('load_products');
	
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



  function populateSuburb(cityID)
  {
	  $("#suburb_div").html('<div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div>');
	  $.ajax({
		 url: "<?php echo site_url('/');?>trade/populate_suburb_name/"+cityID+"/0",
		success: function(data) {
		  $("#suburb_div").html(data);
		  
		}
	  });	
  }

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//BACK
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

function back_to_1(){
	
		var cont = $('#admin_content');
		$.get('<?php echo site_url('/'). 'sell/step1/'.$bus_id.'/?'.$type_str;?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  
		});
	
}



<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//PHOTOS
++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

			 
	  //Show gallery after upload success
	  function make_primary(id){
	  
			  $.ajax({
				  type: 'get',
				  cache:false,
				  url: '<?php echo site_url('/')?>trade/make_primary_image/<?php echo $product_id;?>/'+id ,
				  success: function (data) {
					   
					   $('#item_photos').find('a.btn-success').addClass('hide');
					   $('#img_'+id).append('<a class="btn btn-mini btn-success" style="margin:5px 5px 0 0;"><i class="icon-ok icon-white"></i> FEATURED</a>');
  
				  }
			  });	
			  
	  }	 
		 
	  //Show gallery after upload success
	  function show_images(id){
	  
			  $.ajax({
				  type: 'get',
				  cache:false,
				  url: '<?php echo site_url('/')?>trade/show_all_product_images/'+id ,
				  success: function (data) {
					  
					   $('#item_photos').html(data);
					  
					  
				  }
			  });	
			  
	  }

	function delete_product_img(id){
	  
		$('#modal-product-img-delete').appendTo("body").unbind('show').bind('show', function() {
			//var id = $(this).data('id'),
				removeBtn = $(this).find('.btn-primary'),
				href = removeBtn.attr('href');
				removeBtn.attr('href','javascript:delete_product_img_do('+id+')');		
				removeBtn.click(function(e) { 
				
				});
		}).modal({ backdrop: true });
	}
	
	function delete_product_img_do(id){	 
		 //gallery images
		  $.post('<?php echo site_url('/')?>trade/product_img_delete/'+id , { cache: false } ,  function(data) {
					 
				
				$('#product_gallery_msg').html(data);
				$('#modal-product-img-delete').modal('hide');
				$('#img_'+id).hide();
				
						 
			});
	}
	
	function rotate_img(angle, filename, id, str){
			
			$("#rotate_btn_"+id).addClass('disabled');
            $('#pro_img_att_'+id).attr('src', '<?php echo base_url('/');?>img/deal_place_load.gif').css('height','130px');
            if(str == ''){
				final1 = 'src=<?php echo base_url('/').'assets/products/images/';?>'+filename+'&w=190&h=130';
				delete_thumb_cache(final1);
			}else{
				
				final1 = 'src=<?php echo base_url('/').'assets/products/images/';?>'+filename+'&w=190&h=130&ed='+str;
				delete_thumb_cache(final1);
				
			}
			
			final = 'src=<?php echo base_url('/').'assets/products/images/';?>'+filename+'&w=190&h=130';
			delete_thumb_cache(final);

			$.ajax({
				type: 'get',
           		url: '<?php echo site_url('/').'my_images/rotate_trade/';?>'+angle+'/'+filename+'/'+str ,
				success: function (data) {
					var obj = jQuery.parseJSON( data );
					$('#pro_img_att_'+id).attr('src', obj.src);
					$("#rotate_btn_"+id).attr("onclick", "rotate_img(90, '"+obj.new_filename+"', "+id+", '"+obj.old+"')").removeClass('disabled');
				}
			});	
	}
		
	function delete_thumb_cache(str){
		
				
				$.ajax({
					type: 'get',
					url: '<?php echo base_url('/').'img/delete_thumb.php?';?>'+str ,
					success: function (data) {
						
						$('#msg').html(data);
						
					}
				});	
	}

    function change_select(id){

        if(id == 0){

            $('#admin_content').removeClass('hide').slideDown();
            $('#sel_bus_yes').fadeOut();
            $('#sel_bus_none').delay(500).fadeIn();

        }else if(id == 1){

            $('#sel_bus_none').fadeOut();
            $('#sel_bus_yes').delay(500).fadeIn();
            $('#admin_content').removeClass('hide').slideDown();

        //CHANGE TO SELECT
        }else if(id == 2){

            $('#sel_bus_none').fadeToggle();
            $('#sel_bus_yes').delay(500).fadeToggle();
            $('#admin_content').slideUp().delay(500).addClass('hide animated');


        }



    }



	  
	  
	  
</script>

    
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo base_url('/');?>js/blueimp/vendor/jquery.ui.widget.js" ></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="<?php echo base_url('/');?>js/blueimp/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="<?php echo base_url('/');?>js/blueimp/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="<?php echo base_url('/');?>js/blueimp/canvas-to-blob.min.js"></script>

    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-ui.js"></script>

    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="<?php echo base_url('/');?>js/blueimp/cors/jquery.xdr-transport.js"></script>
    <![endif]-->


</body>
</html>