
 <script src="<?php echo base_url('/');?>js/jquery.filestyle.js" type="text/javascript"></script>
 <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
 <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
 
 <h2><?php echo $BUSINESS_NAME;?></h2>
      <div class="clearfix"></div>


 <legend>Update the Business Graphics</legend>
      <div class="control-group">
      <div class="controls">
        
  <?php
    $rand = rand(0,9999);
    //LOGO IMAGE
	$img = $BUSINESS_LOGO_IMAGE_NAME;

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

	$cover_img = $BUSINESS_COVER_PHOTO;

	if($cover_img != ''){
		
			if(strpos($cover_img,'.') == 0){
	
				$format2 = '.jpg';
				$cover_str = S3_URL.'assets/business/photos/'.$cover_img . $format2.'?='.$rand;;
				
			}else{
				
				$cover_str = S3_URL.'assets/business/photos/'.$cover_img.'?='.$rand;;
				
			}
		
	}else{
		
		$cover_str = base_url('/').'img/business_cover_blank.jpg';	
		
	}
	?>
  
 

            
            <div class="row-fluid" id="cover_div" style="height:300px;background:url(<?php echo$cover_str;?>) no-repeat; background-size:100% auto">
               
               <div class="row-fluid" style="height:70%;">
               <form action="<?php echo site_url('/')?>members/add_cover/<?php echo $ID;?>" method="post" accept-charset="utf-8" id="add-cover" name="add-cover" enctype="multipart/form-data">  
 					<fieldset>               		
                    <div class="span6">
                     <?php if($BUSINESS_COVER_PHOTO != ''){ ?>
							
								<a class="btn btn-inverse" rel="tooltip" title="Edit the Current Image" id="btn_edit_cover" style="margin:5px" href="<?php echo site_url('/').'my_images/edit_image/'. urlencode($this->encrypt->encode('assets/business/photos/'.$BUSINESS_COVER_PHOTO,  $this->config->item('encryption_key'), TRUE));?>"><i class="icon-pencil icon-white"></i> Edit Image</a>';
							
					<?php	  }else{ 
						  
						  		echo '';
								
						   } ?>
                    
                    </div>
                    
                    <div class="span6">
                    <input type="hidden" id="cover_msg" name="" value="">
                    <input type="file"  class="hide" id="userfile1" name="userfile1">
                    <input type="hidden" id="id1" name="id1" value="<?php echo $this->session->userdata('admin_id');?>">
           			<input type="hidden" id="bus_id1" name="bus_id1" value="<?php echo $ID;?>">
                    <input type="hidden" id="bus_name1" name="bus_name1" value="<?php echo $BUSINESS_NAME;?>">
                     
                    <button type="submit" style="margin:5px"  class="btn btn-inverse pull-right" id="coverbut"><i class="icon-picture icon-white"></i> <?php if($BUSINESS_COVER_PHOTO != ''){ echo 'Update Cover';}else{ echo 'Add Cover';} ?></button>
                    <a class="btn btn-inverse pull-right" rel="tooltip" title="Cover Image 750 pixels x 300 pixels" style="margin:5px" onclick="$('#userfile1').click();">Browse Cover</a>
                    </div>
               
                  </fieldset>
			  </form>
              </div>
               
              <div class="row-fluid">
              <form action="<?php echo site_url('/')?>members/add_logo/<?php echo $ID;?>" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
 					<fieldset>
                     <div class="span1">
                    
                    
                    </div> 
               
                   <div style="height:100px;" class="span2">
                     
                      <span class="avatar-overlay100" ></span>
                       <img id="avatar" class="img-polaroid" src="<?php echo $img_str;?>" style="float:left;position:absolute;width:100px; height:100px" />
                        <input type="file" class="" id="userfile" style="display:none" name="userfile"> 
                        <input type="hidden" id="logo_msg" name="" value="">
                        <input type="hidden" id="id" name="id" value="<?php echo $this->session->userdata('admin_id');?>">
           				<input type="hidden" id="bus_id" name="bus_id" value="<?php echo $ID;?>">
                        <input type="hidden" id="bus_name" name="bus_name" value="<?php echo $BUSINESS_NAME;?>">
                   </div>
                   <div class="span9">
                        <h3><?php echo $BUSINESS_NAME;?></h3> 
                        <a class="btn btn-inverse" rel="tooltip" title="Cover Image 250 pixels x 250 pixels" onclick="$('#userfile').click();">Browse Logo</a>
                        <button type="submit"  class="btn btn-inverse" id="imgbut"><i class="icon-tags icon-white"></i> <?php if($BUSINESS_LOGO_IMAGE_NAME != ''){ echo 'Update Logo';}else{ echo 'Add Logo';} ?></button>
                   </div>
                  </fieldset>
			   </form>
              </div>
              
           </div>
        </div>
        
        
      </div>

<div id="avatar_msg"></div>
 <div class="progress progress-striped active hide" id="procover">
      <div class="bar bar-warning" style="width: 0%;"></div>
  </div>
 <div style="height:10px; clear:both"></div>             
<form id="business-update" name="business-update" method="post" action="<?php echo site_url('/');?>members/update_business_do_ajax" class="form-horizontal">
 <fieldset>
    <legend>Update Your Business Details</legend>
    		  
              <div class="control-group">
                <label class="control-label" for="fname">Business Name</label>
                <div class="controls">

                        <input type="text" class="span4" id="name" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
                  
                </div>
              </div>

		
              <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">

                 		 <input type="text" class="span4" id="email" name="email" placeholder="Email" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">
                        
                </div>
              </div>

                 <div class="control-group">
                     <label class="control-label" for="tel">Telephone</label>
                     <div class="controls">
                         <?php echo $this->my_na_model->get_countries($TEL_DIAL_CODE, true, true, $class = 'span2', $id = 'tel_dial_code');?>
                         <input  onkeypress="return isNumberKey(event)" type="text" id="tel" class="span4" name="tel" placeholder="eg: 061231234" maxlength="12" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>">
                     </div>
                 </div>

                 <div class="control-group">
                     <label class="control-label" for="fax">Fax</label>
                     <div class="controls">
                         <?php echo $this->my_na_model->get_countries($FAX_DIAL_CODE, true, true, $class = 'span2', $id = 'fax_dial_code');?>
                         <input  onkeypress="return isNumberKey(event)" type="text" id="fax" class="span4" name="fax" placeholder="eg: 061231234" maxlength="12" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>">
                     </div>
                 </div>

                 <div class="popover top" id="cell_err" style="margin:700px 0px 0px 53%">
                     <div class="arrow"></div>
                     <h3 class="popover-title">Cellular reqiuired<i class="icon-info-sign" style="float:right"></i></h3>
                     <div class="popover-content" id="cell_err_msg">
                         <p>We require your unique cell number to send you periodic updates, specials and announcements</p>
                     </div>
                 </div>

                 <div class="control-group">
                     <label class="control-label" for="cell">Cellphone</label>
                     <div class="controls">

                         <?php echo $this->my_na_model->get_countries($CEL_DIAL_CODE, true, true, $class = 'span2', $id = 'cell_dial_code');?>
                         <input  onkeypress="return isNumberKey(event)" type="text" id="cell" class="span4"  name="cell" placeholder="eg: 0811234567" maxlength="12" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>">


                         <input type="hidden" id="cell_verified" name="cell_verified" value="">
                         <span class="help-block" style="font-size:11px">Please only give us your complete cellular number without<br /> any prefixes or dialling codes.</span>
                     </div>
                 </div>


                <div class="control-group">
                <label class="control-label" for="url">Website</label>
                <div class="controls">

                  		<input type="text" id="url" class="span4" name="url" placeholder="eg: www.example.com.na" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
                    
                </div>
              </div>
               
                <div class="control-group">
                <label class="control-label" for="pobox">PO BOX</label>
                <div class="controls">

                  		<input type="text" id="pobox" class="span4" name="pobox" placeholder="eg: 9012 Windhoek" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">
                   
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="address">Physical Address</label>
                <div class="controls">
                    
                  		<input type="text" id="address" class="span4" name="address" placeholder="eg: 12 Sam Nujoma Drive" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>"/>
                   
                </div>
              </div>
              <div class="control-group">
               <label class="control-label" for="isactive">IS ACTIVE</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" onclick="javascript:togglecheckACTIVE('Y');" class="btn btn-inverse <?php if(isset($ISACTIVE)){ if($ISACTIVE == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" onclick="javascript:togglecheckACTIVE('N');" class="btn btn-inverse <?php if(isset($ISACTIVE)){ if($ISACTIVE == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                          
                        </div>
                        <input type="hidden" name="isactive" id="isactive" value="<?php if(isset($ISACTIVE)){echo $ISACTIVE;}else{ echo 'N';}?>" />
                        <span class="help-block" style="font-size:11px">Is the Business a HAN Member</span> 
					</div>
              </div>
              <div class="control-group">
               <label class="control-label" for="han">HAN Member</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" onclick="javascript:togglecheckHAN('Y');" class="btn btn-inverse <?php if(isset($IS_HAN_MEMBER)){ if($IS_HAN_MEMBER == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" onclick="javascript:togglecheckHAN('N');" class="btn btn-inverse <?php if(isset($IS_HAN_MEMBER)){ if($IS_HAN_MEMBER == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                          
                        </div>
                        <input type="hidden" name="han" id="han" value="<?php if(isset($IS_HAN_MEMBER)){echo $IS_HAN_MEMBER;}else{ echo 'N';}?>" />
                        <span class="help-block" style="font-size:11px">Is the Business a HAN Member</span> 
					</div>
              </div>
              
              <div class="control-group">
               <label class="control-label" for="ntb">NTB Member</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" onclick="javascript:togglecheckNTB('Y');" class="btn btn-inverse <?php if(isset($IS_NTB_MEMBER)){ if($IS_NTB_MEMBER == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" onclick="javascript:togglecheckNTB('N');" class="btn btn-inverse <?php if(isset($IS_NTB_MEMBER)){ if($IS_NTB_MEMBER == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                          
                        </div>
                        <input type="hidden" name="ntb" id="ntb" value="<?php if(isset($IS_NTB_MEMBER)){echo $IS_NTB_MEMBER;}else{ echo 'N';}?>" />
                        <span class="help-block" style="font-size:11px">Is the Business a NTB Member</span> 
					</div>
              </div>

              <div class="control-group">
               <label class="control-label" for="ncci">NCCI Member</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" onclick="javascript:togglecheckNCCI('Y');" class="btn btn-inverse <?php if(isset($IS_NCCI_MEMBER)){ if($IS_NCCI_MEMBER == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" onclick="javascript:togglecheckNCCI('N');" class="btn btn-inverse <?php if(isset($IS_NCCI_MEMBER)){ if($IS_NCCI_MEMBER == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                          
                        </div>
                        <input type="hidden" name="ncci" id="ncci" value="<?php if(isset($IS_NCCI_MEMBER)){echo $IS_NCCI_MEMBER;}else{ echo 'N';}?>" />
                        <span class="help-block" style="font-size:11px">Is the Business a NCCI Member</span> 
					</div>
              </div>

              <div class="control-group">
               <label class="control-label" for="teamnam">Team Namibia Member</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" onclick="javascript:togglecheckTEAM('Y');" class="btn btn-inverse <?php if(isset($IS_TEAMNAM_MEMBER)){ if($IS_TEAMNAM_MEMBER == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" onclick="javascript:togglecheckTEAM('N');" class="btn btn-inverse <?php if(isset($IS_TEAMNAM_MEMBER)){ if($IS_TEAMNAM_MEMBER == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                          
                        </div>
                        <input type="hidden" name="teamnam" id="teamnam" value="<?php if(isset($IS_TEAMNAM_MEMBER)){echo $IS_TEAMNAM_MEMBER;}else{ echo 'N';}?>" />
                        <span class="help-block" style="font-size:11px">Is the Business a Team Namibia Member</span> 
					</div>
              </div>

              <div class="control-group">
               <label class="control-label" for="estate_a">Is Agency</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" onclick="javascript:togglecheckESTATE('Y');" class="btn btn-inverse <?php if(isset($IS_ESTATE_AGENT)){ if($IS_ESTATE_AGENT == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" onclick="javascript:togglecheckESTATE('N');" class="btn btn-inverse <?php if(isset($IS_ESTATE_AGENT)){ if($IS_ESTATE_AGENT == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                          
                        </div>
                        <input type="hidden" name="estate_a" id="estate_a" value="<?php if(isset($IS_ESTATE_AGENT)){echo $IS_ESTATE_AGENT;}else{ echo 'N';}?>" />
                        <span class="help-block" style="font-size:11px">Is the Business a Namibian Estate Agency</span> 
					</div>
              </div>


             <div class="control-group">
                 <label class="control-label" for="paid">Paid Listing</label>
                 <div class="controls">
                     <div class="btn-group" data-toggle="buttons-radio">
                         <button type="button" onclick="javascript:togglecheckPAID('1');" class="btn btn-inverse <?php if(isset($PAID_STATUS)){ if($PAID_STATUS == '1'){echo 'active';}}else{ echo '';}?>">Yes</button>
                         <button type="button" onclick="javascript:togglecheckPAID('0');" class="btn btn-inverse <?php if(isset($PAID_STATUS)){ if($PAID_STATUS == '0'){echo 'active';}}else{ echo '';}?>">No</button>

                     </div>
                     <input type="hidden" name="paid" id="paid" value="<?php if(isset($PAID_STATUS)){echo $PAID_STATUS;}else{ echo '0';}?>" />
                     <span class="help-block" style="font-size:11px">What is the Payment status of the business</span>
                 </div>
             </div>


              <div class="control-group">
                <label class="control-label" for="vt">Virtual Tour Path</label>
                <div class="controls">

                  		<input type="text" id="vt" class="span4" name="vt" placeholder="" value="<?php if(isset($BUSINESS_VIRTUAL_TOUR_NAME)){echo $BUSINESS_VIRTUAL_TOUR_NAME;}?>"/>
	                   <br /><br />
	                    <div class="well well-mini container-fluid">
		                    <?php if(isset($BUSINESS_VIRTUAL_TOUR_NAME) && $BUSINESS_VIRTUAL_TOUR_NAME != ''){?>

			                <textarea style="width: 100%"><iframe allowtransparency="true" frameborder="0" style="width:100%; min-height:350px" src="<?php echo site_url('/').'business/load_virtual_tour/'.$ID.'/';?>"></iframe></textarea>


		                    <?php }?>

		                    <span class="help-block" style="font-size:11px">Copy the complete embed code and adjust the width and height accordingly.</span>
		                </div>
                </div>


              </div>


			 <div class="control-group">
				 <label class="control-label" for="rt">Rating Widget</label>
				 <div class="controls">


					 <?php
					 $atts = array(
						 'width'      => '800',
						 'height'     => '600',
						 'scrollbars' => 'yes',
						 'status'     => 'yes',
						 'resizable'  => 'yes',
						 'screenx'    => '0',
						 'screeny'    => '0',
						 'class'      => 'btn',
						 'title'      => 'Preview your personal widget',
						 'rel'        => 'tooltip'
					 );

					 ?>

					 <div class="well well-mini container-fluid"><h4>Official Namibian Rating Widget! <img src="<?php echo base_url('/');?>img/icons/fnb_irate.png" style="width:90px" class="pull-right" /></h4>

						 <p><small class="muted">Get more valuable feedback and allow your clients to rate and review your business service or product online.</small>
						 </p>
						 <textarea style="width: 100%"><script src="<?php echo base_url('/')?>js/rating/widget.js?v1.1&bus_id=<?php echo $ID;?>&embed=plugin&external=true" id="myna"></script></textarea>
						 <p><small class="muted">Copy the code above and insert it into your website to include your personal rating widget.
								 Not computer savy? Simply copy the code/text above and forward it to your web designer or company.</small></p>
						 <p>
							 <?php echo anchor_popup(site_url('/').'rate/preview/'.$ID, '<span class="notification-small btn-success">New!</span><i class="icon-search"></i> Preview Widget', $atts);?>

							 <img src="<?php echo base_url('/');?>img/icons/affiliation.png" class="pull-right" title="Proudly Partnered With" rel="tooltip"/>
						 </p>


					 </div>

					 <span class="help-block" style="font-size:11px">Copy the complete embed code and adjust the width and height accordingly.</span>
				 </div>


			 </div>

              <div class="control-group">
                <label class="control-label" for="country">Country</label>
                <div class="controls">
               		 
                		<select onchange="populateRegion(this.value);" id="country" name="country" class="span4">  
                		 <option value="0">Select a Country</option>
					  <?php 
                      //Get all countries and loop through them
                      //for the select box
                      $countries = $this->members_model->get_countries();
                      if ($countries->num_rows() != 0 ) { 
                          foreach($countries->result() as $row){
                              $country1 = $row->COUNTRY_NAME;
                              $code = $row->COUNTRY_CODE;
                              
                                  //see if country has been selected
                                  
                                   if($row->ID == $BUSINESS_COUNTRY_ID){ $x = 'selected="selected"';}else{ $x = '';}
                      ?>
                            
                                 <option <?php echo $x;?> value="<?php echo $row->ID ; ?>"><?php echo $country1; ?></option>
                       
                      <?php 
                          }//end foreach loop
                      } //end if rows for countries ?>
              
               		 </select>
                  <span class="help-block" style="font-size:11px">Please select you current country of residence</span>
                </div>
              </div>
              
              
              <?php //POPULATE REGION PLACEHOLDER ?>
              <div id="region_div">
              	<?php echo $this->members_model->populate_city($BUSINESS_COUNTRY_ID, $BUSINESS_MAP_CITY_ID);?>
              </div>
              
               <?php //POPULATE SUBURB PLACEHOLDER ?>
              <div id="suburb_div">
             	 <?php echo $this->members_model->populate_suburb($BUSINESS_MAP_CITY_ID, $BUSINESS_SUBURB_ID);?>
              </div>


              
              <div class="control-group">
              <legend>Update Your Business Description</legend>
                <label class="control-label" for="content">Business Info</label>
                <div class="controls">
                    
                  		
              			<textarea id="redactor_content" name="content" style="display:block" class="redactor"><?php echo $BUSINESS_DESCRIPTION;?></textarea>
                </div>
              </div>
         
              <input type="hidden" name="bus_id" value="<?php echo $ID;?>"> 
              <input type="hidden" name="id" value="<?php echo $this->session->userdata('admin_id');?>">
              <div style="height:10px; clear:both"></div>
              <div id="result_msg"></div>
              <div style="height:10px; clear:both"></div>
              <button type="submit" class="btn-large btn pull-right" name="submit" id="but"><b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
               
   </fieldset> 
 </form>
 <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
 <script type="text/javascript">


$(document).ready(function(e) {

	$('#but').bind('click',function(e) {
		
	
		var cell =  document.getElementById("cell").value;
	
		e.preventDefault();
		//Validate
		if($('#name').val().length == 0){
			
			$('#name').focus();
			$('#name_err').slideDown().delay(4000).slideUp();
		
		}else if($('#email').val().length == 0){
			
			$('#email').focus();
			$('#email_err').slideDown().delay(4000).slideUp();
		
		//}else if($('#cell').val().length < 10){
	//		
	//    	$('#cell').focus();
	//		$('#cell_err_msg').html('Your cellular number is less than 10 digits long!');
	//		$('#cell_err').slideDown().delay(4000).slideUp();
			
		}else if($('#address').val().length < 10){
			
			$('#address').focus();
			$('#address_err').slideDown().delay(4000).slideUp();
	
			
		}else{
			
			submit_form();
			
		}
	});



	var url = window.URL || window.webkitURL;
	
	$("#cover_file").change(function(e) {
		
		
		var str1 = '' ;         
		if( this.disabled ){
			str1 = 'Your browser does not support File upload.';
		}else{
			var chosen = this.files[0];
			var image = new Image();
			
			image.onload = function() {
				
				var Ow = this.width, Oh = this.height, Filsesize = Math.round(chosen.size/1024);
				$("#cover_msg").val(validate_image('cover', Ow, Oh, 300, 750, 7000, 7000));
				//console.log(validate_image('cover', Ow, Oh, 300, 900, 7000, 7000));
				//str1 = validate_image('cover', Ow, Oh, 300, 900, 7000, 7000);
				
			};
			image.onerror = function() {
				str1 = 'PLease choose an image file, not a '+chosen.type+' extension';
			};
			image.src = url.createObjectURL(chosen);                    
		 }
		 
		//console.log($("#cover_msg").val());
	});
 
 	$("#logo_file").change(function(e) {
		
		
		var str1 = '' ;         
		if( this.disabled ){
			str1 = 'Your browser does not support File upload.';
		}else{
			var chosen = this.files[0];
			var image = new Image();
			
			image.onload = function() {
				
				var Ow = this.width, Oh = this.height, Filsesize = Math.round(chosen.size/1024);
				$("#logo_msg").val(validate_image('logo', Ow, Oh, 250, 250, 6000, 6000));
				//console.log(validate_image('cover', Ow, Oh, 300, 900, 7000, 7000));
				//str1 = validate_image('cover', Ow, Oh, 300, 900, 7000, 7000);
				
			};
			image.onerror = function() {
				str1 = 'PLease choose an image file, not a '+chosen.type+' extension. Please choose a .jpg, .png or .gif image';
			};
			image.src = url.createObjectURL(chosen);                    
		 }
		 
		//console.log($("#cover_msg").val());
	});

	$('#imgbut').bind('click', function(e) {
		
		//e.preventDefault();
		var msg = $("#logo_msg").val();
		
		console.log(msg);
		
		if(msg.length != 0){
			e.preventDefault();
			$('#avatar_msg').html("<div class='alert alert-error'>"+msg+"</div>");
		
		}else{
		
			var avataroptions = { 
				target:        '#avatar_msg',
				url:       	   '<?php echo site_url('/').'members/add_logo_ajax';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
									var percentVal = percentComplete + '%';
									probar.width(percentVal)
									
								},
				 complete: function(xhr) {
									procover.hide();
									probar.width('0%');
									 $('#avatar_msg').html(xhr.responseText);
									 console.log(xhr.responseText);
									 $('#imgbut').html('<i class="icon-tags icon-white"></i> Update Logo');
								}				
		
			}; 
		
			var frm = $('#add-img');
			var probar = $('#procover .bar');
			var procover = $('#procover');
		
			$('#imgbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
		}
	});
	 
	
	 
	 
	$('#coverbut').bind('click', function(e) {
		
		//e.preventDefault();
		var msg = $("#cover_msg").val();
		
		console.log(msg);
		
		if(msg.length != 0){
			e.preventDefault();
			$('#avatar_msg').html("<div class='alert alert-error'>"+msg+"</div>");
		
		}else{
			
			$('#avatar_msg').html("");
			
				  var avataroptions = { 
				  target:        '#avatar_msg',
				  url:       	   '<?php echo site_url('/').'members/add_cover';?>' ,
				  beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				  uploadProgress: function(event, position, total, percentComplete) {
									  var percentVal = percentComplete + '%';
									  probar.width(percentVal)
									  
								  },
				   complete: function(xhr) {
									  procover.hide();
									  probar.width('0%');
									   $('#avatar_msg').html(xhr.responseText);
									   //console.log(xhr.responseText);
									   $('#coverbut').html('<i class="icon-picture icon-white"></i> Update Cover');
								  }				
			
			  }; 
			
			  var frm = $('#add-cover');
			  var probar = $('#procover .bar');
			  var procover = $('#procover');
			
			  $('#coverbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Uploading...');
			  procover.show();
			  frm.ajaxForm(avataroptions);		
			
			
		}
		
	
		
			
	});


});
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



function togglecheckACTIVE(val){
			
	var chk = $('#isactive');
	chk.val(val);
}
function togglecheckHAN(val){
			
	var chk = $('#han');
	chk.val(val);
}

function togglecheckNTB(val){
			
	var chk = $('#ntb');
	chk.val(val);
}
function togglecheckNCCI(val){
			
	var chk = $('#ncci');
	chk.val(val);
}
function togglecheckTEAM(val){
			
	var chk = $('#teamnam');
	chk.val(val);
}

function togglecheckESTATE(val){
			
	var chk = $('#estate_a');
	chk.val(val);
}

function togglecheckPAID(val){

    var chk = $('#paid');
    chk.val(val);

}



function submit_form(){
		
		var frm = $('#business-update');
		//frm.submit();
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'my_admin/business_update_do_ajax';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#but').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}

 

 function cover_upload_success(url, btn_link){
	
	$('#cover_div').css({background: 'url('+url+')'});
	$('#btn_edit_cover').attr("href",btn_link);
	 
 } 
 
  function logo_upload_success(url){
	
	$('#avatar').attr('src', url); 
	 
 }
function validate_image(type, Ow, Oh,  minH ,minW ,maxH , maxW){
	
	  var str = '';
	  if(Ow < minW) {
		  
		  str = 'The image width is too small. Minimum width is '+minW+' pixels';
		  
	  }else if(Oh < minH){
		  
		  str = 'The image height is too small .Minimum height is '+minH+' pixels';
		  
	  }
	  
	  if(Ow > maxW) {
		  
		  str = 'The image width is too big. Maximum width is '+ maxW +' pixels';
		  
	  }else if(Oh > maxH){
		  
		  str = 'The image height is too big. Maximum height is '+ maxH +' pixels';
		  
	  }
			
	  $("#"+type+"_msg").val(str);
	  //$("#"+type+"_msg").val(str);
	 return str;
}

	function populateRegion(countryID)
	{	
		
		if(countryID == 151){
		$("#region_div").html('<div class="control-group"><div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div></div>');
		}
		$.ajax({
		  url: "<?php echo site_url('/');?>members/populate_city/"+countryID+"/0/",
		  success: function(data) {
			$("#region_div").html(data);
			//includeJS('js/microsite.show.js');
		  }
		});	
	}
	
	function populateSuburb(cityID)
	{
		$("#suburb_div").html('<div class="control-group"><div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div></div>');
		$.ajax({
		   url: "<?php echo site_url('/');?>members/populate_suburb/"+cityID+"/0",
		  success: function(data) {
			$("#suburb_div").html(data);
			
		  }
		});	
	}


</script>