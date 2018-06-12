 <?php 
 //+++++++++++++++++
 //My.Na Business GAllery
 //+++++++++++++++++
 //Roland Ihms
 ?>
 
<h3>Gallery <small><?php echo $BUSINESS_NAME;?></small></h3>
      <div class="clearfix"></div>
<?php
 //Get GALLERY
$gal_details = $this->members_model->get_gallery($ID);

 ?>
<form action="<?php echo site_url('/')?>members/add_gallery_images/" method="post" accept-charset="utf-8" id="add-gal" name="add-gal" enctype="multipart/form-data">  
 <fieldset>
 <legend>Add gallery images</legend>
      <div class="control-group">
      <div class="controls">
         <?php if(strpos($BUSINESS_LOGO_IMAGE_NAME,'.') == 0 && strlen($BUSINESS_LOGO_IMAGE_NAME) > 4){
					
					$format = '.jpg';
					$fake_file = base_url('/').'img/timbthumb.php?w=200&h=200&src='.S3_URL.'assets/business/photos/'.$BUSINESS_LOGO_IMAGE_NAME . $format;
				
			   }elseif($BUSINESS_LOGO_IMAGE_NAME != ''){
				
					$fake_file =  base_url('/').'img/timbthumb.php?w=200&h=200&src='.S3_URL.'assets/business/photos/'.$BUSINESS_LOGO_IMAGE_NAME;
				
			   }else{ 
					$fake_file =  base_url('/').'img/bus_blank.jpg';
		
			   } ?>
 
           <input type="hidden" id="user_id" name="user_id" value="<?php echo $this->session->userdata('id');?>">
           <input type="hidden" id="bus_id_gal" name="bus_id_gal" value="<?php echo $ID;?>">
            <input type="hidden" id="bus_name_gal" name="bus_name_gal" value="<?php echo $BUSINESS_NAME;?>">

           
           <div class="row">
               <div style="height:100px;" class="col-md-2">
                  <span class="avatar-overlay100"></span>
                   <img id="avatar" src="<?php echo $fake_file;?>" style="float:left;position:absolute;border:1px solid #333333;width:100px; height:100px" />
               	   <input type="file" class="btn btn-link" id="gal_file_btn" style="display:none" name="files[]" multiple >
                   
               </div>
               <div class="col-md-10"> 
               		<a class="btn btn-large" onclick="$('#gal_file_btn').click();">Browse</a>
               </div>
            </div>
            
        </div>
        <button type="submit"  class="btn btn pull-right" id="galbut"><i class="icon-tags"></i> Add Images</button>
        
      </div>
      </fieldset>
</form>
           <div id="gallery_msg"></div>
             <div class="progress progress-striped active" id="galcover" style="display:none">
                  <div class="bar bar-warning" style="width: 0%;"></div>
              </div> 
 
 <div class="gallery">
 <?php
 //Get GALLERY
if($gal_details->result()){

	$this->members_model->show_all_gallery_images($bus_id);
	
	
}else{
	
	echo '<div class="alert alert-block">
         	<button type="button" class="close" data-dismiss="alert">×</button>
            <h4>No Gallery Images Added</h4>
			Please add some gallery images to enhance your business listing by clicking on the select images button below
		</div>';

}
	

 ?>
 </div>
 
 
 <?php 
   /**
++++++++++++++++++++++++++++++++++++++++++++
//DELETE GALLERY IMAGE MODAL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 
<div class="modal hide fade" style="z-index:1066" id="modal-img-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete Image</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to completely remove this photo?</p>
  </div>
  <div class="modal-footer">
    <a onclick="$('#modal-img-delete').modal('hide');" class="btn">Close</a>
    <a href="#" id="delete_img_confirm" class="btn btn-primary">Remove</a>
  </div>
</div>

 <script type="text/javascript">

function delete_gallery_img(id){
	
	$('#modal-img-delete').appendTo("body").unbind('show').bind('show', function() {
		    var removeBtn = $('#delete_img_confirm'),
			href = removeBtn.attr('href');
			removeBtn.attr('href','javascript:delete_gallery_img_do('+id+')');		
			removeBtn.click(function(e) { 
				
				removeBtn.html('Removing');
				
			});
	}).modal({ backdrop: true });
}

function delete_gallery_img_do(id){	 
	 //gallery images
	  $.post('<?php echo site_url('/')?>members/gallery_img_delete/'+id , { cache: false } ,  function(data) {
			var removeBtn = $('#delete_img_confirm');
			removeBtn.html('Remove');	 
			$('#gallery_msg').html(data);
			$('#modal-img-delete').modal('hide');		 
		});
}
 

$('#galbut').click(function() {
	
	var avataroptions = { 
        target:        '#gallery_msg',
        url:       	   '<?php echo site_url('/').'members/add_gallery_images';?>' ,
		beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
		uploadProgress: function(event, position, total, percentComplete) {
                            var percentVal = percentComplete + '%';
                            probar.width(percentVal)
                            
                        },
		 complete: function(xhr) {
							procover.hide();
							probar.width('0%');
							 $('#gallery_msg').html(xhr.responseText);
							 console.log(xhr.responseText);
							 $('#galbut').html('<i class="icon-user"></i> Add images');
                        }				

    }; 

	var frm = $('#add-gal');
	var probar = $('#galcover .bar');
	var procover = $('#galcover');

	$('#galbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Uploading...');
	procover.show();
	frm.ajaxForm(avataroptions);
});
 
//Show gallery after upload success
function show_gallery(){

		$.ajax({
			type: 'get',
			cache:false,
			url: '<?php echo site_url('/')?>members/show_all_gallery_images/<?php echo $ID;?>' ,
			
			success: function (data) {
				
				 $('.gallery').html(data);
				
				
			}
		});	
		
}


</script> 