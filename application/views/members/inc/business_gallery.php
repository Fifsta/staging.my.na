 <?php 
 //+++++++++++++++++
 //My.Na Business GAllery
 //+++++++++++++++++
 //Roland Ihms
 ?>
 

<?php
 //Get GALLERY
$gal_details = $this->members_model->get_gallery($ID);

?>
<div class="col-md-12">
<form action="<?php echo site_url('/')?>members/add_gallery_images/" method="post" accept-charset="utf-8" id="add-gal" name="add-gal" enctype="multipart/form-data">

	<input type="hidden" id="user_id" name="user_id" value="<?php echo $this->session->userdata('id');?>">
	<input type="hidden" id="bus_id_gal" name="bus_id_gal" value="<?php echo $ID;?>">
	<input type="hidden" id="bus_name_gal" name="bus_name_gal" value="<?php echo $BUSINESS_NAME;?>">

	<div class="row">
		<div class="col-md-2">

		   <input type="file" class="btn btn-link" id="gal_file_btn" name="files[]" multiple >

		</div>
		<div class="col-md-10">
			<button type="submit" class="btn btn-dark" id="galbut"><i class="icon-tags"></i> Add Images</button>
		</div>	
	</div>
	
</form>
</div> 

<div class="clearfix"></div>

<div id="gallery_msg"></div>
<div class="progress progress-striped active" id="galcover" style="display:none">
  <div class="bar bar-warning" style="width: 0%;"></div>
</div>

<div class="row gallery">

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
 
<div class="modal" tabindex="-1" role="dialog" id="modal-img-delete">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to completely remove this photo?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="#" type="button" class="btn btn-dark" id="delete_img_confirm">Remove</a>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">

/*function delete_gallery_img(id){

	$('#modal-img-delete').appendTo("body").unbind('show').bind('show', function() {

			console.log('hi');

		    var removeBtn = $('#delete_img_confirm');

			removeBtn.attr('data-id', id);

			removeBtn.click(function(e) { 
				
			removeBtn.html('Removing');

				
			});
	}).modal({ backdrop: true });
}*/



$(document).on('click', '.gal-link', function(e) {

		var id = $(this).attr("data-id");

});



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

	$('#galbut').html('<img src="<?php echo base_url('/').'images/load.gif';?>" /> Uploading...');
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