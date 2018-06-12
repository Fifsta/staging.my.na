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
            <form id="fileupload" action="<?php echo site_url('/') ?>trade/add_product_images/" method="POST" enctype="multipart/form-data">

                <div class="alert alert-secondary"><i class="fa fa-question-circle-o pull-right text-dark"></i><strong>Why Photos?</strong> Items
                    with a proper description and detailed photos sell far quicker than ones without because the buyer can see
                    what the product looks like
                </div>

                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                <noscript><input type="hidden" name="redirect" value=""></noscript>

                <input type="hidden" name="bus_id" value="<?php if (isset($bus_id)) { echo $bus_id; } else { echo '0'; } ?>">

                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-md-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->

                        <span class="btn btn-dark fileinput-button">
                            <i class="fa fa-plus text-light"></i>
                            <span>Add files...</span>
                            <input type="file" name="files[]" multiple>
                        </span>

                        <button type="submit" class="btn btn-success start" id="start_up">
                            <i class="icon-upload icon-white"></i>
                            <span>Start upload</span>
                        </button>

                        <button type="reset" class="btn btn-danger cancel">
                            <i class="icon-ban-circle icon-white"></i>
                            <span>Cancel upload</span>
                        </button>

                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <hr>
                    <!-- The global progress state -->
                    <div class="col-md-5 fileupload-progress fade">

                        <!-- The global progress bar -->
                        <!--<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="bar bar-warning" style="width:0%;"></div>
                        </div>-->

                        <div class="progress">
                          <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>

                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-responsive">
                    <tbody class="files"></tbody>
                </table>


                <h4 style="font-size:18px"><strong>Existing Photos</strong></h4>
                <div id="product_gallery_msg"></div>
                <div class="col-md-12"><div id="item_photos"><?php //$this->trade_model->show_all_product_images($product_id); ?></div></div>
                <div class="clearfix">&nbsp;</div>
                <div class="alert alert-secondary"><i class="fa fa-question-circle-o pull-right text-dark"></i> <strong>Featured Image?</strong> 
                    To set the primary image for the product please click on the image itself and see the green check icon appear.
                </div>
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