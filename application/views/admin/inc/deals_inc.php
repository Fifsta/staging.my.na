<div id="add_deal_cont" style="display<?php if (isset($deal_id)){echo ':block;';}else{ echo ':none;';}?>">
    
    <div class="row-fluid">
    	<?php if (isset($deal_id)){echo '<h4 >Update Deal <small>Update the deal</small></h4>';}else{ echo '<h4 >Add New Deal <small>Submit new deal for review</small></h4>';}?>
       
     
    	<div class="clearfix" style="height:10px;"></div>
    </div>
    
    <div class="row-fluid">
    	
    	<div class="span8">

            <form id="deal-add" name="deal-add" method="post" action="<?php echo site_url('/');?>deals/add_deal" class="form-horizontal">
                             <fieldset>
                             		      <input type="hidden" name="deal_id" id="deal_id" value="<?php if (isset($deal_id)){echo $deal_id;}else{ echo '0';}?>" />
    									  <input type="hidden" name="bus_id_deal" id="bus_id_deal" value="<?php echo $bus_id;?>" />
                                          <div class="control-group">
                                            <label class="control-label" for="title">Deal</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="deal_title" name="deal_title" placeholder="Deal title" value="<?php if (isset($title)){echo $title;}?>">
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
				                             <label class="control-label" for="gender">Special or Deal</label>
				                             <div class="controls">
					                             <div class="btn-group" data-toggle="buttons-radio">
						                             <button type="button" id="deal_click" onclick="javascript:togglecheck('deal');" class="btn
																  <?php if(isset($special_type) && ($special_type == 'deal')){ echo 'btn-success active';}elseif(!isset($special_type)){ echo 'btn-success active';};?>">Deal</button>
						                             <button type="button" id="special_click" onclick="javascript:togglecheck('special');" class="btn
				                                                  <?php if(isset($special_type) && ($special_type == 'special')){ echo 'btn-success active';}?>">Special</button>

					                             </div>
					                             <input type="hidden" name="special_type" id="special_type" value="<?php if(isset($special_type)){ echo $special_type;}else{ echo 'deal';}?>" />
					                             <span class="help-block" style="font-size:11px">Is this a physical deal with set quantities or is it a special promotion?</span>
				                             </div>
			                             </div>

	                                      <div class="control-group <?php if(isset($special_type) && ($special_type == 'special')){ echo ' hide';}?>" id="quantity_div">
                                            <label class="control-label" for="deal_quantity">Quantity</label>
                                            <div class="controls">          
                                                <input type="text" class="span6" id="deal_quantity" name="deal_quantity" placeholder="0" value="<?php if (isset($quantity)){echo $quantity;}?>">
                                                <span class="help-block" style="font-size:11px">How many deals/promotions are available Leave 0 if limitless</span>
                   
                                            </div>
                                          </div>
                                          
                                           <div class="control-group">
                                            <label class="control-label" for="deal_cat">Category</label>
                                            <div class="controls">
                                                    
                                                        <select class="span12" id="deal_cat" name="deal_cat" placeholder="Category">
                                                          <option value="0">Select category</option>
                                                         <?php $cats = $this->deal_model->get_main_categories();
														 		foreach($cats->result() as $row){
																	
																	if(isset($cat_deal) && $cat_deal == $row->ID){
																		
																		echo '<option value="'.$row->ID.'" selected="selected">'.$row->CATEGORY_NAME.'</option>';	
																			
																	}else{
																		
																		echo '<option value="'.$row->ID.'">'.$row->CATEGORY_NAME.'</option>';	
																		
																	}	
																	
																}
														 
														 ?>
                                                        </select>
                                                        
                                                        <span class="help-block" style="font-size:11px">Please select a category for the deal</span>
                                                   
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                            <label class="control-label" for="deal_loc">Location</label>
                                            <div class="controls">
                                                    
                                                        <select class="span12" id="deal_loc" name="deal_loc" placeholder="Location">
                                                          <option>Select location</option>
                                                          <option value="0">National</option>
                                                         <?php $cities = $this->deal_model->get_cities();
														 		foreach($cities->result() as $row2){
																	
																	if(isset($deal_loc) && $deal_loc == $row2->ID){
																		
																		echo '<option value="'.$row2->ID.'" selected="selected">'.$row2->MAP_LOCATION.'</option>';	
																			
																	}else{
																		
																		echo '<option value="'.$row2->ID.'">'.$row2->MAP_LOCATION.'</option>';	
																		
																	}	
																	
																}
														 
														 ?>
                                                        </select>
                                                        
                                                        <span class="help-block" style="font-size:11px">Please select a location for the deal</span>
                                                   
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="price_u">Normal Price</label>
                                            <div class="controls">
                                            		<div class="span6">
                                                        
                                                         <input type="text" class="span12" id="price_u" name="price_u" placeholder="Ususal Price" value="<?php if (isset($price_u)){echo $price_u;}?>">
                                                        <span class="help-block" style="font-size:11px">What is the normal value of the deal/promotion in N$</span>
                                                    </div>
                                                    
                                                    <div class="span6">
                                                         <input type="text" class="span12" id="price" name="price" placeholder="Special price" value="<?php if (isset($price)){echo $price;}?>">
                                                        <span class="help-block" style="font-size:11px">How much is the promotion price in N$</span>
                                                    </div>
                                                   
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                                <label class="control-label" for="deal_content">Deal Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="deal_content" class="deal_editor" name="deal_content" style="display:block"><?php if (isset($body)){echo $body;}?></textarea> 
                                                    <span class="help-block"  style="font-size:11px">
                                                    Please describe the deal or promotion. Terms and conditions should be mentioned if there are</span>
                                                </div>
                                           </div>
                                           
                                           <div class="control-group">
                                                <label class="control-label" for="deal_email">Email Instructions:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="deal_email" class="deal_editor" name="deal_email" style="display:block"><?php if (isset($bodyemail)){echo $bodyemail;}?></textarea> 
                                                    <span class="help-block"  style="font-size:11px">
                                                    Please provide us with special instructions on how to claim the deal. This will be sent in the email which the deal recipient receives.</span>
                                                </div>
                                           </div>
                                           
										   <div id="deal_msg"></div>
                                           <?php 
											if(isset($deal_id) && $is_active == 'N'){
												
												
												echo '<a onclick="make_live('.$deal_id.')" class="btn btn-inverse pull-right" style="margin-left:10px;display:block" id="btn_submit_deal">
												  <i class="icon-play icon-white"></i> Make Live</a>';
													
												
											}else{
												
												echo '<a onclick="make_live('.$deal_id.')" class="btn btn-inverse pull-right" style="margin-left:10px;" id="btn_submit_deal">
												  <i class="icon-pause icon-white"></i> Pause Deal</a>';
												
											}
											?>
                                           
                                           
                                            
                                          <button type="submit" class="btn btn-inverse pull-right" id="add_deal_btn"><?php if (isset($deal_id)){echo 'Update Deal';}else{ echo 'Add Deal';}?></button>
                                           
                               </fieldset> 
                             </form>
        </div>
        <div class="span4">
            <?php 
			    if(isset($deal_id)){
					if ($img_file == 'NULL'){
					
						echo '<div id="deal_img"></div><a onclick="add_deal_image()" class="btn btn-block" style="display:none" id="btn_add_deal_img"><i class="icon-picture"></i> Add Deal Graphic</a>
							  ';
						
					}else{ 
					
						echo '<div id="deal_img">'.$this->deal_model->show_deal_img($deal_id).'</div><a onclick="add_deal_image()" class="btn btn-block clearfix" style="display:block;" id="btn_add_deal_img"><i class="icon-picture"></i> Update Deal Graphic</a>
							  ';
						
					}
				}else{
					
					echo '<div id="deal_img"></div><a onclick="add_deal_image()" class="btn btn-block" style="display:none" id="btn_add_deal_img"><i class="icon-picture"></i> Add Deal Graphic</a>
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

<form action="<?php echo site_url('/')?>deals/add_deal_img" method="post" accept-charset="utf-8" id="add-gallery" enctype="multipart/form-data" name="add-gallery" > 
<div id="modal-deal-img" class="modal hide fade">

    <div class="modal-header">
      <a href="#" onclick="javascript:$('#modal-deal-img').modal('hide')" class="close">&times;</a>
      <h3>Add a Deal Graphic</h3>
    </div>
    <div class="modal-body">
     <p>Please select the images you want to accompany the Deal</p>
	 
 		<div class="control-group">
      		<div class="controls">
           <input type="hidden" id="deal_id_deal_img"  name="deal_id_deal_img" value="<?php if (isset($deal_id)){echo $deal_id;}else{echo '0';}?>" />
    	   <input type="hidden" id="bus_id_deal_img" name="bus_id_deal_img" value="<?php echo $bus_id;?>" />
           <input type="file" class="btn btn-link" name="userfile" >
           <span class="help-inline">Select Graphic</span>
           <span class="help-block"  style="font-size:11px">
             Image dimensions required 900px wide by 300px in height</span>
           <div id="result_deal_img"></div>
             <div class="progress progress-striped active" id="gal-cover" style="display:none">
                <div class="bar" style="width: 0%;"></div>
            </div>
        </div>
         
      </div>
	  
      
    </div>
    <div class="modal-footer">
      <input type="submit" class="btn btn-primary" style="border:none;" value="Add Graphic">  
      <a href="#" onclick="javascript:$('#modal-deal-img').modal('hide')" class="btn secondary">No</a>
    </div>
 
</div>
</form> 

<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/jquery.form.min.js" ></script>
<script data-cfasync="false" type="text/javascript">



$(document).ready(function(){

	$('#add_deal_btn').click(function(e){

			e.preventDefault();
			if($('#deal_title').val().length == 0){
				var x = $('#deal_title');
				x.popover({  delay: { show: 100, hide: 3000 },
				 placement:"top",html: true,trigger: "manual",
				 title:"Deal Title required", content:"Please give the deal a valid and enticing subject line."});
				x.popover('show');
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);

			}else{
				var frm = $('#deal-add');
				$('#add_deal_btn').html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> Processing...');
				$.ajax({
					type: 'post',
					cache: false,
					data:frm.serialize(),
					url: '<?php echo site_url('/').'deals/add_deal/';?>' ,
					success: function (data) {
						$('#deal_msg').html(data);
						$('#add_deal_btn').html('Update Deal');


					}
			});

			}

	});

});

function toggle_deal_add(){

	var x = $('#add_deal_cont');
	x.slideToggle();
	$('html, body').animate({
		scrollTop: (x.offset().top - 200)
	}, 300);
	//initialise();

}

function togglecheck(val){

	var chk = $('#special_type');
	chk.val(val);
	if(val == 'special'){
		$('#deal_click').removeClass('btn-success');
		$('#special_click').addClass('btn-success');
		$('#quantity_div').slideUp();
		$('#deal_quantity').val(0);
	}else{
		$('#deal_click').addClass('btn-success');
		$('#special_click').removeClass('btn-success');
		$('#quantity_div').slideDown();

	}
}

function add_deal_image(){
	
	
	$('#modal-deal-img').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary'),
			href = removeBtn.attr('href');
			var frm = $('#add-gallery');
			var probar = $('#gal-cover .bar');
			var procover = $('#gal-cover');

			removeBtn.click(function() {
				//removeBtn.val('Uploading...');
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
							$('#result_deal_img').html(xhr.responseText)
							probar.width('0%');
							
							$('#modal-deal-img').modal('hide');
                        }
                    });
	
		});
	}).modal({ backdrop: true });
}

//Show gallery after upload success
function show_deal_img(deal_id){
		 
		 var cont = $('#deal_img'),submit_btn = $('#btn_submit_deal');
		 cont.empty();
		 cont.addClass('loading_img');
		 $.get('<?php echo site_url('/')?>deals/show_deal_img/'+deal_id, { cache: false } ,  function(data) {
			 cont.removeClass('loading_img');
			 cont.html(data);
			 $("#btn_add_deal_img").popover('destroy');	
			 
			 
			  submit_btn.attr('onclick','submit_deal('+deal_id+')');
			  submit_btn.fadeIn();
			
			  submit_btn.popover({  delay: { show: 100, hide: 3000 },
				 placement:"top",html: true,trigger: "manual",
				 title:"Publish your Deal", content:"Submit the deal for approval. My Namibia will approve the deal within 24 hours"});
			  submit_btn.popover('show');
				$('html, body').animate({
					 scrollTop: (submit_btn.offset().top - 200)
				 }, 300);
		});
		
}




function update_deal(id){
	
	var cont = $('#deals');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'deals/update_deal/';?>'+id ,
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
			url: '<?php echo site_url('/').'deals/set_status/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					setTimeout("load_ajax('deals')",100); 
					
			}
		});	 
	
}


function deal_stats(id){
	
	var cont = $('#deals');
	cont.empty();
	cont.addClass('loading_img'); 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'deals/deal_stats/';?>'+id ,
			success: function (data) {
					cont.removeClass('loading_img'); 
				    cont.html(data);
					
			}
		});	 
	
}

</script>