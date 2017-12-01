


<?php
//+++++++++++++++++++++++++++++++++
//STEP 1 Categories
//+++++++++++++++++++++++++++++++++
if($step == '1'){
	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}

?>
        <div class="well well-mini text-center">
            <h3>List an Item <?php echo $str;?></h3>
            <a href="#" class="btn btn-inverse disabled btn-large step1" style="margin:5px"> 1 Select Category <i class="icon-chevron-right icon-white"></i></a> 
            <a href="#" class="btn btn-inverse disabled step2" style="margin:5px"> 2 Details <i class="icon-chevron-right icon-white"></i></a>
            <a href="#" class="btn btn-inverse disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-chevron-right icon-white"></i></a>
            <a href="#" class="btn btn-inverse disabled step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
            <a href="#" class="btn btn-inverse disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
        
        </div>
        <h3>Please choose a category</h3>
        <div id="select_cats">
        <?php $this->trade_model->load_product_categories(0,'_', 0,'_', 0,'_', 0,'_', $bus_id);?>
        </div>
<?php 
}
?>


<?php
//+++++++++++++++++++++++++++++++++
//STEP 2 Details
//+++++++++++++++++++++++++++++++++
if($step == '2'){
	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}
?>
	<div id="anchor_me"></div>
    <div class="well well-mini text-center">
        <h3>List an Item <?php echo $str;?></h3>
        <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="icon-ok icon-white"></i></a> 
        <a href="#" class="btn btn-inverse disabled btn-large step2" style="margin:5px"> 2 Details <i class="icon-chevron-right icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-chevron-right icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
    
    </div>
   
    <h3>Item details</h3>
    <div id="item_details">
     
     <div class="row-fluid">
    	
    	<div class="span10">
        <form id="item-add" name="item-add" method="post" action="<?php echo site_url('/');?>trade/add_general_item" class="form-horizontal">
                         <fieldset>
                                      <input type="hidden" name="cat1" id="cat1" value="<?php echo $cat1;?>" />
                                      <input type="hidden" name="cat1name" id="cat1name" value="<?php echo $cat1name;?>" />
                                      <input type="hidden" name="cat2" id="cat2" value="<?php echo $cat2;?>" />
                                      <input type="hidden" name="cat2name" id="cat2name" value="<?php echo $cat2name;?>" />
                                      <input type="hidden" name="cat3" id="cat3" value="<?php echo $cat3;?>" />
                                      <input type="hidden" name="cat3name" id="cat3name" value="<?php echo $cat3name;?>" />
                                      <input type="hidden" name="cat4" id="cat4" value="<?php echo $cat4;?>" />
                                      <input type="hidden" name="cat4name" id="cat4name" value="<?php echo $cat4name;?>" />
                                      <input type="hidden" name="bus_id" id="bus_id" value="<?php if(isset($bus_id)){ echo $bus_id; }else{ echo '0';}?>" />
                                      <input type="hidden" name="product_id" id="product_id" value="<?php if(isset($product_id)){ echo $product_id; }else{ echo '0';}?>" />
                                      <div class="control-group">
                                        <label class="control-label" for="category">Category</label>
                                        <div class="controls">
                                                <input type="text" class="span12" value="<?php echo $catname; ?>" disabled>
                                                <span class="help-block" style="font-size:11px">Listed in which category.</span>
                                        </div>
                                      </div>
                                      
                                      <div class="control-group">
                                        <label class="control-label" for="title">Item</label>
                                        <div class="controls">
                                                <input type="text" class="span12" id="item_title" name="item_title" placeholder="Item title" value="<?php if (isset($title)){echo $title;}?>">
                                                <span class="help-block" style="font-size:11px">The product title. Be specific, if it is a BMW a good title will be BMW 3 Series 320i</span>
                                        </div>
                                      </div>
                                      
                                      <div class="control-group">
                                            <label class="control-label" for="item_content">Item Description:</label>
                                            <div class="controls">
                                                
                                                <textarea id="item_content" class="item_editor" name="item_content" style="display:block"><?php if (isset($description)){echo $description;}?></textarea> 
                                                <span class="help-block"  style="font-size:11px">
                                                Please describe the item or product. Please provide specific detail here. Condition and relevant specifications</span>
                                            </div>
                                       </div>
                                      

                                      
                                      <div class="control-group">
                                        <label class="control-label" for="item_loc">Location</label>
                                        <div class="controls">
                                                
                                                    <select onchange="populateSuburb(this.value);" class="span12" id="item_loc" name="item_loc" placeholder="Location">
                                                      <option value="National">National</option>
                                                     <?php $cities = $this->trade_model->get_cities();
                                                            foreach($cities->result() as $row2){
                                                                
                                                                if(isset($location) && $location == $row2->MAP_LOCATION){
                                                                    
                                                                    echo '<option value="'.$row2->MAP_LOCATION.'" selected="selected">'.$row2->MAP_LOCATION.'</option>';	
                                                                        
                                                                }else{
                                                                    
                                                                    echo '<option value="'.$row2->MAP_LOCATION.'">'.$row2->MAP_LOCATION.'</option>';	
                                                                    
                                                                }	
                                                                
                                                            }
                                                     
                                                     ?>
                                                    </select>
                                                    
                                                    <span class="help-block" style="font-size:11px">Please select a location for the item</span>
                                               
                                        </div>
                                      </div>

                                      <div class="control-group">
                                        <label class="control-label" for="item_suburb">Suburb</label>
                                        <div class="controls">
                                                
													<?php //POPULATE SUBURB PLACEHOLDER ?>
                                                   <div id="suburb_div">
                                                   	<?php 	if(isset($location)){
																echo $this->trade_model->populate_suburb_name($location ,$suburb);
															
															}else{
																
																echo $this->trade_model->populate_suburb_name($location = '' ,$suburb = '');
																
																
															}
															?>
                                                   </div>
                                                                
                                                    <span class="help-block" style="font-size:11px">Please select a suburb if available</span>
                                               
                                        </div>
                                      </div>


                                      
                                      
                                      <div class="control-group">
                                       <label class="control-label" for="gender">Listing Type</label>
                                            <div class="controls">
                                                <div class="btn-group" data-toggle="buttons-radio">
                                                  <button type="button" id="sale_click" onclick="javascript:togglecheck('S');" class="btn 
												  <?php if(isset($listing_type) && ($listing_type == 'S')){ echo 'btn-success active';}elseif(!isset($listing_type)){ echo 'btn-success active';};?>">Fixed Price</button>
                                                  <button type="button" id="auction_click" onclick="javascript:togglecheck('A');" class="btn
                                                  <?php if(isset($listing_type) && ($listing_type == 'A')){ echo 'btn-success active';}?>">Auction</button>
                                                  
                                                </div>
                                                <input type="hidden" name="listing_type" id="listing_type" value="<?php if(isset($listing_type)){ echo $listing_type;}else{ echo 'S';}?>" />
                                                <span class="help-block" style="font-size:11px">Do you want to have a fixed price for the item or put it on auction.</span> 
                                            </div>
                                      </div>
									 <!-- Fixed Pricing -->
                                     <div id="fixed_pricing" <?php if(isset($listing_type) && ($listing_type == 'A')){ echo 'class="hide"';}?>>
                                      
                                              <div class="control-group">
                                                <label class="control-label" for="price_u">Price</label>
                                                <div class="controls">
                                                        <div class="span6">
                                                            
                                                             <input type="text" class="span12" id="price" name="price" onkeypress="return isNumberKey(event)" placeholder="Fixed Price" value="<?php if (isset($sale_price)){echo $sale_price;}?>">
                                                            <span class="help-block" style="font-size:11px">What is the fixed price of the item/product in N$</span>
                                                        </div>
                                                       
                                                </div>
                                              </div>
                                      			
 
                                                
									  </div> <!--  End Auction Pricing -->
                                       
                                       
                                     <!-- Auction Pricing -->
                                     <div id="auction_pricing" <?php if(isset($listing_type) && ($listing_type == 'A')){ echo '';}else{ echo 'class="hide"';}?> >
                                      
                                              <div class="control-group">
                                                <label class="control-label" for="start_price">Start Price</label>
                                                <div class="controls">
                                                        <div class="span6">
                                                            
                                                             <input type="text" class="span12" id="start_price" name="start_price" onkeypress="return isNumberKey(event)" placeholder="Start Price" value="<?php if (isset($start_price)){echo $start_price;}?>">
                                                            <span class="help-block" style="font-size:11px">What is the normal value of the item/promotion in N$</span>
                                                        </div>
                                                        
                                                        <div class="span6">
                                                             <input type="text" class="span12" id="reserve" name="reserve" onkeypress="return isNumberKey(event)" placeholder="Reserve" value="<?php if (isset($reserve)){echo $reserve;}?>">
                                                            <span class="help-block" style="font-size:11px">What is the reserve value? If the reserve bid hasnt been matched at the end of the auction the item is not sold.</span>
                                                        </div>
                                                       
                                                </div>
                                              </div>
                                              
                                             <div class="control-group">
                                                <label class="control-label" for="slug">Duration</label>
                                                <div class="controls">
                                                          <div class="input-append date span6" id="dpstart" data-date="102/2012" data-date-format="yyyy-mm-dd" data-date-minviewmode="months">
                                                            <input class="span9" size="16" type="text" name="dpstart" value="<?php if (isset($start_date)){echo date('Y-m-d',strtotime($start_date));}else{ echo date('Y-m-d');}?>" readonly="">
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                          </div>
                                                          <div class="input-append date span6" id="dpend" data-date="102/2012" data-date-format="yyyy-mm-dd"  data-date-minviewmode="months">
                                                            <input class="span9" size="16" type="text" name="dpend" value="<?php if (isset($end_date)){echo date('Y-m-d',strtotime($end_date));}else{ echo date('Y-m-d');}?>" readonly="">
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                          </div> 
                                                          <span class="help-block" style="font-size:11px">From when to when is the listing available</span>   
                                                </div>
                                              </div> 
                                              
                                      
									  </div> <!--  End Auction Pricing --> 
                                       
                                       <!--<div class="control-group">
                                            <label class="control-label" for="deal_quantity">Quantity</label>
                                            <div class="controls">          
                                                <input type="text" class="span6" id="deal_quantity" name="deal_quantity" placeholder="0" value="<?php if (isset($quantity)){echo $quantity;}?>">
                                                <span class="help-block" style="font-size:11px">How many deals/promotions are available Leave 0 if limitless</span>
                   
                                            </div>
                                       </div>-->
                                       
                                       
                                       <div class="control-group">
                                            <label class="control-label" for="item_email">Payment Instructions:</label>
                                            <div class="controls">
                                                
                                                <textarea id="item_email" class="item_editor" name="item_email" style="display:block"><?php if (isset($email_instructions)){echo $email_instructions;}?></textarea> 
                                                <span class="help-block"  style="font-size:11px">
                                                Please provide us with special instructions on how to claim the item. This will be sent in the email which the item recipient receives.</span>
                                            </div>
                                       </div>
                                       
                                       <div id="item_msg"></div>
                                       <?php 
                                        if(isset($product_id) && $is_active == 'N'){
                                            
                                            
                                            //echo '<a onclick="submit_item('.$product_id.')" class="btn btn-inverse pull-right" style="margin-left:10px;display:block" id="btn_submit_item">
                                              //<i class="icon-play icon-white"></i> Publish Item</a>';
                                                
                                            
                                        }else{
                                            
                                           // echo '<a class="btn btn-inverse pull-right" style="margin-left:10px;display:none" id="btn_submit_item">
                                            //  <i class="icon-play icon-white"></i> Publish Item</a>';
                                            
                                        }
                                        ?>
                                       
                                       
                                      <div id="msg_step2"></div>
                                      <button type="submit" class="btn btn-inverse pull-right" id="add_item_btn"><?php if (isset($product_id)){echo 'Update Item';}else{ echo 'Add Item';}?> <i class="icon-chevron-right icon-white"></i></button>
                                      <?php   if(isset($product_id)){ 
									  			
												    $str = 'disabled';
													$java = '';
														
											  }else{
												  
													$str = '';
													$java = 'onclick="back_to_1()"';   
											  }
									  ?>
                                      <a href="javascript:void(0)" onclick="back_to_all();" id="back_to_all" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a> 
                                      <a href="javascript:void(0)" <?php echo $java;?> class="btn btn-inverse pull-right <?php echo $str;?>" style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>  
                           </fieldset> 
                         </form>
       
				</div>
			</div>
    </div>
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>    
    
<script type="text/javascript">

$(document).ready(function(){
	  window.scrollTo(0,$('#anchor_me').offset().top);
	  $('.item_editor').redactor({ 	
		  
		  buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
		  'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
		   'alignment', '|', 'horizontalrule']
	  });
	
	
    $('#dpstart').datepicker()
	
	$('#dpend').datepicker()
		<?php
	 /**
	++++++++++++++++++++++++++++++++++++++++++++
	//SUBMIT STEP 3
	++++++++++++++++++++++++++++++++++++++++++++	
	 */
	 ?> 
	$('#add_item_btn').bind('click', function(e){ 
		
		e.preventDefault();
		var cont = $('#admin_content'), frm = $('#item-add'), btn = $(this);
		btn.html('Working...');
		cont.addClass('loading_img'); 
		$.ajax({
				type: 'post',
				cache: false,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'trade/add_general_item';?>' ,
				success: function ( data ) {
					    btn.html('<i class="icon-chevron-right icon-white"></i> Update Item');
						cont.removeClass('loading_img'); 
						cont.html( data );
												
				}
			});
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

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//BACK
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

function back_to_1(){
	
		var cont = $('#admin_content');
		$.get('<?php echo site_url('/'). 'trade/list_general_step1/'.$bus_id.'/';?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  
		});
	
}

</script>    

    
    
<?php 
}
?>




<?php
//+++++++++++++++++++++++++++++++++
//STEP 3 Photos
//+++++++++++++++++++++++++++++++++
if($step == '3'){
	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}
?>
	<div id="anchor_me"></div>
    <div class="well well-mini text-center">
        <h3>List an Item <?php echo $str;?></h3>
        <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="icon-ok icon-white"></i></a> 
        <a href="#" class="btn btn-warning disabled  step2" style="margin:5px"> 2 Details <i class="icon-ok icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled btn-large step3" style="margin:5px"> 3 Attach Photos <i class="icon-chevron-right icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
    
    </div>
    
    <div>
	<style type="text/css">
		
		div.thumbnail:hover{opacity:0.9; cursor:pointer; border:4px solid #093;margin-top:-3px}
		strong.text-danger{color:#BD362F;}
		
	</style>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui-noscript.css"></noscript>    
    
        <!-- The file upload form used as target for the file upload widget -->
        <form id="fileupload" action="<?php echo site_url('/')?>trade/add_product_images/" method="POST" enctype="multipart/form-data">
        <legend>Add some photos</legend>
        <div class="alert"><i class="icon-question-sign pull-right icon-white"></i><strong>Why Photos?</strong> Items with a proper description and detailed photos sell far quicker than ones without because the buyer can see what the product looks like</div>
            <!-- Redirect browsers with JavaScript disabled to the origin page -->
            <noscript><input type="hidden" name="redirect" value=""></noscript>
            <input type="hidden" name="bus_id" value="<?php if(isset($bus_id)){ echo $bus_id;}else{ echo '0';}?>">
            <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
            
            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
            <div class="row-fluid fileupload-buttonbar">
                <div class="span7">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-inverse fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Add files...</span>
                        <input type="file" name="files[]" multiple>
                    </span>
                    <button type="submit" class="btn btn-success start">
                        <i class="icon-upload icon-white"></i>
                        <span>Start upload</span>
                    </button>
                    <button type="reset" class="btn btn-danger cancel">
                        <i class="icon-ban-circle icon-white"></i>
                        <span>Cancel upload</span>
                    </button>
    <!--                <button type="button" class="btn btn-danger delete">
                        <i class="icon-trash"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" class="toggle">-->
                    <!-- The global file processing state -->
                    <span class="fileupload-process"></span>
                </div>
                <!-- The global progress state -->
                <div class="span5 fileupload-progress fade">
                    <!-- The global progress bar -->
                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                        <div class="bar bar-warning" style="width:0%;"></div>
                    </div>
                    <!-- The extended global progress state -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            </div>
            <!-- The table listing the files available for upload/download -->
            <table role="presentation" class="table table-striped table-responsive"><tbody class="files"></tbody></table>
        
        
            <legend>Existing Photos</legend>
            <div id="product_gallery_msg"></div>
            <div id="item_photos"><?php $this->trade_model->show_all_product_images($product_id);?></div>
            <div class="clearfix">&nbsp;</div>
            <div class="alert"><i class="icon-question-sign pull-right icon-white"></i> <strong>Featured Image?</strong> To set the primary image for the product please click on the image itself and see the green check icon appear.</div>
       </form>
       <hr />
       <a href="javascript:void(0)" onclick="proceed_to_4()" id="proceed_to_4" class="btn btn-inverse pull-right">Next <i class="icon-chevron-right icon-white"></i></a>
       <a href="javascript:void(0)" onclick="back_to_all();" id="back_to_all" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a> 
       <a href="javascript:void(0)" onclick="back_to_2()" id="back_to_2" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>
    </div>
    
     <?php 
	   /**
	++++++++++++++++++++++++++++++++++++++++++++
	//DELETE GALLERY IMAGE MODAL
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
	 */
	 ?> 
	<div class="modal hide fade" id="modal-product-img-delete">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Delete Image</h3>
	  </div>
	  <div class="modal-body">
		<p>Are you sure you want to completely remove this photo?</p>
	  </div>
	  <div class="modal-footer">
		<a href="" data-dismiss="modal" class="btn">Close</a>
		<a href="#" class="btn btn-primary">Remove</a>
	  </div>
	</div>
    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-warning" style="width:0%;"></div></div>
            </td>
            <td style="text-align:right;">
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-success start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-danger cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
    </script>
    
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo base_url('/');?>js/blueimp/vendor/jquery.ui.widget.js"></script>
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
	<script type="text/javascript">
		$(function () {
			
			window.scrollTo(0,$('#anchor_me').offset().top);
			
			'use strict';
		
			// Initialize the jQuery File Upload widget:
			$('#fileupload').fileupload({
				// Uncomment the following to send cross-domain cookies:
				//xhrFields: {withCredentials: true},
				url: '<?php echo site_url('/');?>trade/add_product_images',

				stop:function (e) {
					$('div.fileupload-progress').fadeOut();
					show_images(<?php echo $product_id;?>);
				},
			
			});
		
			// Enable iframe cross-domain access via redirect option:
			$('#fileupload').fileupload(
				'option',
				'redirect',
				window.location.href.replace(
					/\/[^\/]*$/,
					'<?php echo site_url('/');?>js/blueimp/result.html?%s'
				)
			);
			
			$('#fileupload').fileupload('option', {
				url: '<?php echo site_url('/');?>trade/add_product_images',
				// Enable image resizing, except for Android and Opera,
				// which actually support image resizing, but fail to
				// send Blob objects via XHR requests:
				disableImageResize: /Android(?!.*Chrome)|Opera/
        			.test(window.navigator && navigator.userAgent),
    			imageMaxWidth: 1000,
   				imageMaxHeight: 1000,
				//imageCrop: true ,// Force cropped images,
				maxNumberOfFiles: 20,
				maxFileSize: 5000000,
				acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
			});
			// Upload server status check for browsers with CORS support:
			if ($.support.cors) {
				$.ajax({
					url: '<?php echo site_url('/');?>trade/add_product_images',
					type: 'HEAD'
				}).fail(function () {
					$('<div class="alert alert-danger"/>')
						.text('Upload server currently unavailable - ' +
								new Date())
						.appendTo('#fileupload');
				});
			}
		
			// Load existing files:
			$('#fileupload').addClass('fileupload-processing');
			$.ajax({
				// Uncomment the following to send cross-domain cookies:
				//xhrFields: {withCredentials: true},
				url: $('#fileupload').fileupload('option', 'url'),
				dataType: 'json',
				context: $('#fileupload')[0]
			}).always(function () {
				$(this).removeClass('fileupload-processing');
			}).done(function (result) {
				$(this).fileupload('option', 'done')
					.call(this, $.Event('done'), {result: result});
				
			});
		   
		
		});

		 
			 
	  //Show gallery after upload success
	  function make_primary(id){
	  
			  $.ajax({
				  type: 'get',
				  cache:false,
				  url: '<?php echo site_url('/')?>trade/make_primary_image/<?php echo $product_id;?>/'+id ,
				  success: function (data) {
					  
					   show_images(<?php echo $product_id;?>);
					  
					  
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
					$("#rotate_btn_"+id).attr("onclick", "rotate_img(90, '"+filename+"', "+id+", '"+obj.old+"')");
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
	
	function proceed_to_4(){
		
			var cont = $('#admin_content'), btn = $('#proceed_to_4');
			btn.html('Working...');
			  $.get('<?php echo site_url('/'). 'trade/list_general_step4/'.$product_id.'/'. $bus_id;?>', function(data) {
					cont.removeClass('loading_img').html(data);
					btn.html('Next <i class="icon-chevron-right icon-white"></i>');
			  });
		
	}
	
	<?php
	   /**
	  ++++++++++++++++++++++++++++++++++++++++++++
	  //BACK
	  ++++++++++++++++++++++++++++++++++++++++++++	
	   */
	   ?> 
	  
	  function back_to_2(){
		  
			  var cont = $('#admin_content'), btn = $('#back_to_2');
			  btn.html('Working...');
			  $.get('<?php echo site_url('/'). 'trade/update_product/'.$product_id;?>', function(data) {
					cont.removeClass('loading_img').html(data);
					btn.html('<i class="icon-chevron-left icon-white"></i> Back');
					
			  });
		  
	  }
	</script>
    
    
<?php 
}
?>



<?php
//+++++++++++++++++++++++++++++++++
//STEP 4 Extras
//+++++++++++++++++++++++++++++++++
if($step == '4'){
	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}
?>
	<div id="anchor_me"></div>
    <div class="well well-mini text-center">
        <h3>List an Item <?php echo $str;?></h3>
        <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="icon-ok icon-white"></i></a> 
        <a href="#" class="btn btn-warning disabled  step2" style="margin:5px"> 2 Details <i class="icon-ok icon-white"></i></a>
        <a href="#" class="btn btn-warning disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-ok icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled btn-large step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
    
    </div>
    
    <h4>Extras</h4>
    
    <?php 
	//IF EXTRAS 
	if($has_extras){
		
		$this->load->view($group); 
	
	//NO EXTRAS
	}else{
	?>
        <div class="alert">
        	<h4>No extras available for the selected category</h4>
            There are no extras available to set for the selected category. Please make sure the product description describes the product to its fullest
        </div>
        <div>
           <a href="javascript:void(0)" onclick="proceed_to_5()" id="proceed_to_5" class="btn btn-inverse pull-right">Next <i class="icon-chevron-right icon-white"></i></a>
           <a href="javascript:void(0)" onclick="back_to_all();" id="back_to_all" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a> 
           <a href="javascript:void(0)"onclick="back_to_3()" id="back_to_3" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>
        </div>
        
    <?php
	}?>

    <script type="text/javascript">
	
	$(document).ready(function(e) {
        
		window.scrollTo(0,$('#anchor_me').offset().top);
		<?php
		 /**
		++++++++++++++++++++++++++++++++++++++++++++
		//SUBMIT STEP 3
		++++++++++++++++++++++++++++++++++++++++++++	
		 */
		 ?> 
		
		$('#add_extras_btn').bind('click', function(e){ 
			
			e.preventDefault();
			var cont = $('#admin_content'), frm = $('#item-add'), btn = $(this);
			btn.html('Working...');
			cont.addClass('loading_img'); 
			$.ajax({
					type: 'post',
					cache: false,
					data: frm.serialize(),
					url: '<?php echo site_url('/').'trade/add_extras';?>' ,
					success: function (data) {
						    btn.html('Update Item <i class="icon-chevron-right icon-white"></i>');
							cont.removeClass('loading_img'); 
							cont.html(data);
							proceed_to_5();
							
					}
				});
		});		
		
    });


	function proceed_to_5(){
		
			var cont = $('#admin_content');
			  $.get('<?php echo site_url('/'). 'trade/list_general_step5/'.$product_id.'/'. $bus_id;?>', function(data) {
					cont.removeClass('loading_img').html(data);
					
			  });
		
	}
	
	<?php
	   /**
	  ++++++++++++++++++++++++++++++++++++++++++++
	  //BACK
	  ++++++++++++++++++++++++++++++++++++++++++++	
	   */
	   ?> 
	  
	  function back_to_3(){
		  
			  var cont = $('#admin_content'), btn = $('#back_to_3');
			  btn.html('Working...');
			  $.get('<?php echo site_url('/'). 'trade/list_general_step3/'.$product_id .'/'. $bus_id ;?>', function(data) {
					cont.removeClass('loading_img').html(data);
					btn.html('<i class="icon-chevron-left icon-white"></i> Back');
					
			  });
		  
	  }
	</script>
    
    
<?php 
}
?>


<?php
//+++++++++++++++++++++++++++++++++
//STEP 5 Confirm
//+++++++++++++++++++++++++++++++++
if($step == '5'){
	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}
?>
	<div id="anchor_me"></div>
    <div class="well well-mini text-center">
        <h3>List an Item <?php echo $str;?></h3>
        <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="icon-ok icon-white"></i></a> 
        <a href="#" class="btn btn-warning disabled  step2" style="margin:5px"> 2 Details <i class="icon-ok icon-white"></i></a>
        <a href="#" class="btn btn-warning disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-ok icon-white"></i></a>
        <a href="#" class="btn btn-warning disabled step4" style="margin:5px"> 4 Extras <i class="icon-ok icon-white"></i></a>
        <a href="#" class="btn btn-inverse disabled btn-large step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
    
    </div>
   

   	<?php if($is_active != 'Y'){ ?>
        <div class="alert alert-block">
            <h4>Publish your item</h4>
            Please publish your item so we can approve it and make it live.</div>
  	    <div>
       <a href="javascript:void(0)" onclick="publish()" class="btn btn-inverse pull-right">Publish <i class="icon-chevron-right icon-white"></i></a>
    <?php }else{ ?>
        <div class="alert alert-block">
            <h4>Item is Live</h4>
            The product is live and showing on the website <a href="<?php echo site_url('/').'product/'.$product_id;?>/" class="btn btn-inverse pull-right clearfix" style="margin-top:-10px" target="_blank">Preview <?php echo $title;?></a></div>
       <div>
   <?php }?>
       <a href="javascript:void(0)" onclick="back_to_all();" id="back_to_all" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a> 
       <a href="javascript:void(0)"onclick="back_to_4()" id="back_to_4" class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>
    </div>
    

    <script type="text/javascript">
	
	$(document).ready(function(e) {
		window.scrollTo(0,$('#anchor_me').offset().top);
	});

	function publish(){
		
			var cont = $('#admin_content');
			  $.get('<?php echo site_url('/'). 'trade/publish_item/'.$product_id.'/'.$bus_id;?>', function(data) {
					cont.removeClass('loading_img').html(data);
					
			  });
		
	}
	
	<?php
	   /**
	  ++++++++++++++++++++++++++++++++++++++++++++
	  //BACK
	  ++++++++++++++++++++++++++++++++++++++++++++	
	   */
	   ?> 
	  
	  function back_to_4(){
		  
			  var cont = $('#admin_content'), btn = $('#back_to_4');
			  btn.html('Working...');
			  $.get('<?php echo site_url('/'). 'trade/list_general_step4/'.$product_id.'/'.$bus_id;?>', function(data) {
					cont.removeClass('loading_img').html(data);
					btn.html('<i class="icon-chevron-left icon-white"></i> Back');
			  });
		  
	  }
	</script>
    
    
<?php 
}
?>




<div class="clearfix" style="height:200px;"></div>
<script type="text/javascript">


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


function load_ajax_product_cat(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name){
		
		var n = $('#select_cats');
		n.html('<div class="span3" style="text-align:center;margin-top:125px;width:100%"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Getting Categories...</div>');
		
		$.ajax({
			type: 'post',
			data:{	cat1: cat1, cat1name: cat1name, 
					cat2: cat2, cat2name: cat2name,
					cat3: cat3, cat3name: cat3name,
					cat4: cat4, cat4name: cat4name},
			cache: false,
			url: '<?php echo site_url('/').'trade/load_product_categories/'.$bus_id.'/';?>' ,
			success: function (data) {	
				
				n.html(data).fadeIn('300');
				
				
			}
		});	

}


function go_step_3(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name){
	
	var cont = $('#admin_content');
	cont.html('<div class="span3" style="text-align:center;margin-top:125px;width:100%"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Loading...</div>');
	
		//console.log(cat1+"-"+cat2+"-"+ cat3+"-"+cat4);
		$.ajax({
			type: 'post',
			data:{	cat1: cat1,  cat1name: cat1name,  
					cat2: cat2,  cat2name: cat2name, 
					cat3: cat3,  cat3name: cat3name, 
					cat4: cat4,  cat4name: cat4name },
			cache: false,
			url: '<?php echo site_url('/').'trade/list_general_step2/'.$bus_id.'/';?>' ,
			success: function (data) {	
				
				cont.html(data).fadeIn('300');
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


function back_(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name){
	
	if(cat4 > 0){
		
		load_ajax_product_cat(cat1, cat1name, cat2, cat2name, cat3, cat3name , 0 ,'_');
		
	}else if(cat3 > 0){
		
		load_ajax_product_cat(cat1, cat1name, cat2, cat2name,0 ,'_', 0 ,'_');
		
	}else if(cat2 > 0){
		
		load_ajax_product_cat(cat1, cat1name,0 ,'_', 0 ,'_',0 ,'_');
		
	}else if(cat1 > 0){
	
		load_ajax_product_cat(0,'_', 0,'_', 0,'_', 0,'_');
	}else{
		
		load_ajax_product_cat(0,'_', 0,'_', 0,'_', 0,'_');
	}
	
}

function back_to_all(){
	
	var btn = $('#back_to_all');
	btn.html('Working...');
	<?php 
	//IF ADMIN
	if($this->session->userdata('admin_id')){
		
		echo "load_ajax('load_products');";
		
	}elseif($this->session->userdata('id')){
		
		echo "load_trade('products', 'live');";
		
	}?>
	
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

</script>
