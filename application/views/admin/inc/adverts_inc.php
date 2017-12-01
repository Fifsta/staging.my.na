<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" /> 
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<div id="add_advert_cont" style="display<?php if (isset($advert_id)){echo ':block;';}else{ echo ':none;';}?>">
    
    <div class="row-fluid">
    	<?php if (isset($advert_id)){echo '<h4 >Update Advert <small>Update the advert</small></h4>';}else{ echo '<h4 >Add New Advert <small>Submit new advert for review</small></h4>';}?>
       
     
    	<div class="clearfix" style="height:10px;"></div>
    </div>
    
    <div class="row-fluid">
    	
    	<div class="span8">

            <form id="advert-add" name="advert-add" method="post" action="<?php echo site_url('/');?>adverts/add_advert" class="form-horizontal">
                             <fieldset>
                             		      <input type="hidden" name="advert_id" id="advert_id" value="<?php if (isset($advert_id)){echo $advert_id;}else{ echo '0';}?>" />
    									  <input type="hidden" name="bus_id_advert" id="bus_id_advert" value="<?php //echo $bus_id;?>" />
                                          <div class="control-group">
                                            <label class="control-label" for="advert_title">Advert</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="advert_title" name="advert_title" placeholder="Advert title" value="<?php if (isset($title)){echo $title;}?>">
                                                    <span class="help-block" style="font-size:11px">A few words about your amazing offer. eg: Buy 1 get 1 FREE</span>
                                            </div>
                                          </div>
                             			  
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Duration</label>
                                            <div class="controls">
                                                   	  <div class="input-append date span6" id="dpstart" data-date="102/2012" data-date-format="yyyy-mm-dd" data-date-minviewmode="months">
                                                        <input class="span9" size="16" type="text" name="dpstart" value="<?php if (isset($start)){echo date('Y-m-d',strtotime($start));}else{ echo date('Y-m-d');}?>" readonly="">
                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                      </div>
                                                      <div class="input-append date span6" id="dpend" data-date="102/2012" data-date-format="yyyy-mm-dd"  data-date-minviewmode="months">
                                                        <input class="span9" size="16" type="text" name="dpend" value="<?php if (isset($end)){echo date('Y-m-d',strtotime($end));}else{ echo date('Y-m-d');}?>" readonly="">
                                                        <span class="add-on"><i class="icon-calendar"></i></span>
                                                      </div> 
                                                      <span class="help-block" style="font-size:11px">From when to when is the promotion available</span>   
                                            </div>
                                          </div>
                              			 
                                         <div class="control-group">
                                            <label class="control-label" for="advert_link">URL / Link</label>
                                            <div class="controls">          
                                                <input type="text" class="span12" id="advert_link" name="advert_link" placeholder="http://example.com" value="<?php if (isset($link)){echo $link;}?>">
                                                <span class="help-block" style="font-size:11px">The link the advert redirects to</span>
                   
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                           <label class="control-label" for="advert_type">Advert Type</label>
                                                <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" onclick="javascript:togglecheck('B');" class="btn btn-inverse 
                                                      <?php if(isset($advert_type) && ($advert_type == 'B')){ echo 'active';}elseif(!isset($advert_type)){ echo 'active';};?>">Business</button>
                                                      <button type="button" onclick="javascript:togglecheck('P');" class="btn btn-inverse 
                                                      <?php if(isset($advert_type) && ($advert_type == 'P')){ echo 'active';}?>">Products</button>
                                                      
                                                    </div>
                                                    <input type="hidden" name="advert_type" id="advert_type" value="<?php if(isset($advert_type)){ echo $advert_type;}else{ echo 'B';}?>" />
                                                    <span class="help-block" style="font-size:11px">What kind of advert it is. For Business Pages or Product pages</span> 
                                                </div>
                                          </div>
										  
                                          <div class=" <?php if(isset($advert_type) && ($advert_type == 'B')){ echo 'hide';}?>" id="prod_cat_sel">				
                                               <div class="control-group">
                                                <label class="control-label" for="advert_cat">Product Category</label>
                                                <div class="controls">
                                                        
                                                            <select class="span12" id="product_cat" name="product_cat" placeholder="Category">
                                                              <option value="0">Select category</option>
                                                             <?php $cats = $this->advert_model->get_product_categories();
                                                                    foreach($cats->result() as $row){
                                                                        
                                                                        if(isset($main_cat_id) && $main_cat_id == $row->cat_id){
                                                                            
                                                                            echo '<option value="'.$row->cat_id.'" selected="selected">'.$row->category_name.'</option>';	
                                                                                
                                                                        }else{
                                                                            
                                                                            echo '<option value="'.$row->cat_id.'">'.$row->category_name.'</option>';	
                                                                            
                                                                        }	
                                                                        
                                                                    }
                                                             
                                                             ?>
                                                            </select>
                                                            
                                                            <span class="help-block" style="font-size:11px">Please select a product category for the advert</span>
                                                       
                                                </div>
                                              </div>
                                              
                                               <div class="control-group">
                                                                 
                                                <label class="control-label" for="advert_cat_sub">Product Sub Category </label>
                                                <div class="controls">
                                                        
                                                            <select id="advert_cat_sub" name="advert_cat_sub[]"  data-placeholder="Please Select" class="extra_slect span12" multiple="" size="6">
                                                              
                                                             <?php $this->advert_model->get_product_categories_sub($main_cat_id, $sub_cat_id);
                                                                    
                                                             
                                                             ?>
                                                            </select>
                                                            
                                                            <span class="help-block" style="font-size:11px">Please select a product sub category for the advert</span>
                                                       
                                                </div>
                                              </div>        
                                              
                                               <div class="control-group">
                                                                 
                                                <label class="control-label" for="advert_cat_sub_sub">Product Sub Sub Category </label>
                                                <div class="controls">
                                                        
                                                            <select id="advert_cat_sub_sub" name="advert_cat_sub_sub[]"  data-placeholder="Please Select" class="extra_slect span12" multiple="" size="6">
                                                              
                                                             <?php $this->advert_model->get_product_categories_sub_sub($sub_sub_cat_id);
                                                                    
                                                             
                                                             ?>
                                                            </select>
                                                            
                                                            <span class="help-block" style="font-size:11px">Please select a product sub sub category for the advert</span>
                                                       
                                                </div>
                                              </div> 
                                              
                                              
										   </div>

                                           <div class="control-group <?php if(isset($advert_type) && ($advert_type == 'P')){ echo 'hide';}?>" id="bus_cat_sel">
                                            <label class="control-label" for="advert_cat">Business Category</label>
                                            <div class="controls">
                                                    
                                                        <select class="span12" id="advert_cat" name="advert_cat" placeholder="Category">
                                                          <option value="0">Select category</option>
                                                         <?php $cats = $this->advert_model->get_main_categories();
														 		foreach($cats->result() as $row){
																	
																	if(isset($cat_advert) && $cat_advert == $row->ID){
																		
																		echo '<option value="'.$row->ID.'" selected="selected">'.$row->CATEGORY_NAME.'</option>';	
																			
																	}else{
																		
																		echo '<option value="'.$row->ID.'">'.$row->CATEGORY_NAME.'</option>';	
																		
																	}	
																	
																}
														 
														 ?>
                                                        </select>
                                                        
                                                        <span class="help-block" style="font-size:11px">Please select a business category for the advert</span>
                                                   
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                            <label class="control-label" for="advert_loc">Location</label>
                                            <div class="controls">
                                                    
                                                        <select class="span12" id="advert_loc" name="advert_loc" placeholder="Location">
                                                          <option>Select location</option>
                                                          <option value="0">National</option>
                                                         <?php $cities = $this->advert_model->get_cities();
														 		foreach($cities->result() as $row2){
																	
																	if(isset($advert_loc) && $advert_loc == $row2->ID){
																		
																		echo '<option value="'.$row2->ID.'" selected="selected">'.$row2->MAP_LOCATION.'</option>';	
																			
																	}else{
																		
																		echo '<option value="'.$row2->ID.'">'.$row2->MAP_LOCATION.'</option>';	
																		
																	}	
																	
																}
														 
														 ?>
                                                        </select>
                                                        
                                                        <span class="help-block" style="font-size:11px">Please select a location for the advert</span>
                                                   
                                            </div>
                                          </div>
    
                                          <div class="control-group">
                                                <label class="control-label" for="advert_content">Advert Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="advert_content" class="advert_editor" name="advert_content" style="display:block"><?php if (isset($body)){echo $body;}?></textarea> 
                                                    <span class="help-block"  style="font-size:11px">
                                                    Please describe the advert or promotion. Terms and conditions should be mentioned if there are</span>
                                                </div>
                                           </div>

                                           
										   <div id="advert_msg"></div>
                                           <?php 
											if(isset($advert_id) && $is_active == 'N'){
												
												
												echo '<a onclick="make_live('.$advert_id.')" class="btn btn-inverse pull-right" style="margin-left:10px;display:block" id="btn_submit_advert">
												  <i class="icon-play icon-white"></i> Make Live</a>';
													
											}elseif(isset($advert_id)){
												
												echo '<a onclick="make_live('.$advert_id.')" class="btn btn-inverse pull-right" style="margin-left:10px;" id="btn_submit_advert">
												  <i class="icon-pause icon-white"></i> Pause Advert</a>';
												
											
											}else{
												
												
												
											}
											?>
                                           
                                           
                                            
                                          <button type="submit" class="btn btn-inverse pull-right" id="add_advert_btn"><?php if (isset($advert_id)){echo 'Update Advert';}else{ echo 'Add Advert';}?></button>
                                           
                               </fieldset> 
                             </form>
        </div>
        <div class="span4">
            <?php 
			    if(isset($advert_id)){
					if ($img_file == 'NULL'){
					
						echo '<div id="advert_img"></div><a onclick="add_advert_image()" class="btn btn-block" style="display:none" id="btn_add_advert_img"><i class="icon-picture"></i> Add Advert Graphic</a>
							  ';
						
					}else{ 
					
						echo '<div id="advert_img">'.$this->advert_model->show_advert_img($advert_id).'</div><a onclick="add_advert_image()" class="btn btn-block clearfix" style="display:block;" id="btn_add_advert_img"><i class="icon-picture"></i> Update Advert Graphic</a>
							  ';
						
					}
				}else{
					
					echo '<div id="advert_img"></div><a onclick="add_advert_image()" class="btn btn-block" style="display:none" id="btn_add_advert_img"><i class="icon-picture"></i> Add Advert Graphic</a>
						  ';
					
				}
				?>
           
        </div>
        
     </div>

	<div class="row-fluid">
    
    	<div class="span12">
        
         
        </div>
    
    
    </div>



</div>

<form action="<?php echo site_url('/')?>adverts/add_advert_img" method="post" accept-charset="utf-8" id="add-gallery" enctype="multipart/form-data" name="add-gallery" > 
<div id="modal-advert-img" class="modal hide fade">

    <div class="modal-header">
      <a href="#" onclick="javascript:$('#modal-advert-img').modal('hide')" class="close">&times;</a>
      <h3>Add a Advert Graphic</h3>
    </div>
    <div class="modal-body">
     <p>Please select the images you want to accompany the Advert</p>
	 
 		<div class="control-group">
      		<div class="controls">
           <input type="hidden" id="advert_id_advert_img"  name="advert_id_advert_img" value="<?php if (isset($advert_id)){echo $advert_id;}else{echo '0';}?>" />
    	   <input type="hidden" id="bus_id_advert_img" name="bus_id_advert_img" value="<?php //echo $bus_id;?>" />
           <input type="file" class="btn btn-link" name="userfile" >
           <span class="help-inline">Select Graphic</span>
           <span class="help-block"  style="font-size:11px">
             Image dimensions required 300px wide by 430px in height</span>
           <div id="result_advert_img"></div>
             <div class="progress progress-striped active" id="gal-cover" style="display:none">
                <div class="bar" style="width: 0%;"></div>
            </div>
        </div>
         
      </div>
	  
      
    </div>
    <div class="modal-footer">
      <input type="submit" class="btn btn-primary" style="border:none;" value="Add Graphic">  
      <a href="#" onclick="javascript:$('#modal-advert-img').modal('hide')" class="btn secondary">No</a>
    </div>
 
</div>
</form> 

<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/jquery.form.min.js" ></script>

<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">


	$(document).ready(function(){

		 $('#product_cat').on('change', function(e){
			 
			 $.get('<?php echo site_url('/');?>adverts/get_product_categories_sub/'+$(this).val()+'/').done(function(e){
					 
				$('#advert_cat_sub').html(e);
				
			});
				 
		 });
		 
		 
		 $('select.extra_slect').css('margin-top', '-10px').select2({
                placeholder: "Please Select",
                allowClear: true
          
		 });
		$('#add_advert_btn').click(function(e){ 
				
				e.preventDefault();
				if($('#advert_title').val().length == 0){
					var x = $('#advert_title');
					x.popover({  delay: { show: 100, hide: 3000 },
					 placement:"top",html: true,trigger: "manual",
					 title:"Advert Title required", content:"Please give the advert a valid and enticing subject line."});
					x.popover('show');
					$('html, body').animate({
						 scrollTop: (x.offset().top - 200)
					 }, 300);
						
				}else{
					var frm = $('#advert-add');
					$('#add_advert_btn').html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> Processing...');
					$.ajax({
						type: 'post',
						cache: false,
						data:frm.serialize(),
						url: '<?php echo site_url('/').'adverts/add_advert/';?>' ,
						success: function (data) {
							$('#advert_msg').html(data);
							$('#add_advert_btn').html('Update Advert');
		
							
						}
				});	
						
				}			
			
		});
	});
	
function toggle_advert_add(){
	
	var x = $('#add_advert_cont');
	x.slideToggle();
	$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
	$('.advert_editor').redactor();	
	$('#dpend').datepicker();
	$('#dpstart').datepicker();
}

function initialise(){
	
	$('#dpend').datepicker();
	$('#dpstart').datepicker();
	$('.advert_editor').redactor();	
	
}





function add_advert_image(){
	
	
	$('#modal-advert-img').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
			
			var frm = $('#add-gallery');
			var probar = $('#gal-cover .bar');
			var procover = $('#gal-cover');

			removeBtn.click(function(e) {
				//e.preventDefault();
				procover.show();
				frm.ajaxForm({
                        beforeSend: function() {
                            var percentVal = '0%';
                            probar.width(percentVal)
                           
                        },
                        uploadProgress: function(event, position, total, percentComplete) {
                            var percentVal = percentComplete + '%';
                            probar.width(percentVal)
                            
                        },
                        complete: function(xhr) {
							procover.hide();
							$('#result_advert_img').html(xhr.responseText)
							probar.width('0%');
							
							$('#modal-advert-img').modal('hide');
                        }
                    });
	
		});
	}).modal({ backdrop: true });
}


function togglecheck(val){
			
	var chk = $('#advert_type');
	chk.val(val);
	
	if(val == 'P'){
		
		$("#bus_cat_sel").slideUp();
		$("#prod_cat_sel").slideDown();	
	}else{
		$("#bus_cat_sel").slideDown();
		$("#prod_cat_sel").slideUp();	
		
	}
	
}


//Show gallery after upload success
function show_advert_img(advert_id){
		 
		 var cont = $('#advert_img'),submit_btn = $('#btn_submit_advert');
		 cont.empty();
		 cont.addClass('loading_img');
		 $.get('<?php echo site_url('/')?>adverts/show_advert_img/'+advert_id, { cache: false } ,  function(data) {
			 cont.removeClass('loading_img');
			 cont.html(data);
			 $("#btn_add_advert_img").popover('destroy');	
			 
			 
			  submit_btn.attr('onclick','submit_advert('+advert_id+')');
			  submit_btn.fadeIn();
			
			  submit_btn.popover({  delay: { show: 100, hide: 3000 },
				 placement:"top",html: true,trigger: "manual",
				 title:"Publish your Advert", content:"Submit the advert for approval. My Namibia will approve the advert within 24 hours"});
			  submit_btn.popover('show');
				$('html, body').animate({
					 scrollTop: (submit_btn.offset().top - 200)
				 }, 300);
		});
		
}




function update_advert(id){
	
	var cont = $('#admin_content');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'adverts/update_advert/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					
			}
		});	 
	
}

function make_live(id){
	
	var cont = $('#admin_content');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'adverts/set_status/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					setTimeout("load_ajax('adverts')",100); 
					
			}
		});	 
	
}


function advert_stats(id){
	
	var cont = $('#admin_content');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'adverts/advert_stats/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					
			}
		});	 
	
}

</script>