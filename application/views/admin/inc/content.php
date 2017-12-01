<?php //IF TESTER STUDENT 

//$content = $this->admin_model->get_content($id, $type);

$cov = 'background:url('.base_url('/').'img/business_cover_blank.jpg) no-repeat;';
//COVER STR
if($cover != ''){

	$cov = 'background:url('.base_url('/').'assets/content/photos/'. $cover.') no-repeat;';

}

if($this->session->userdata('u_position') == 'Tester'){
	
?>




	
<?php	
}else{
?>
<h2><?php echo ucwords($type);?></h2>
<a href="javascript:void(0)" class="btn pull-right" onclick="javascript:load_ajax('content/<?php echo $type;?>')"><i class="icon-chevron-left"></i> Back</a>
<p class="clearfix">&nbsp;</p>
<?php if($id != 0){;?>
<div class="row-fluid" id="cover_div" style="height:300px; <?php echo $cov;?>background-size:100% auto">

	<div class="row-fluid" style="height:70%;">
		<form action="<?php echo site_url('/')?>my_images/add_cover/" method="post" accept-charset="utf-8" id="add-cover" name="add-cover" enctype="multipart/form-data">
			<fieldset>
				<div class="span6">
					<?php if($cover != ''){ ?>

						<a class="btn btn-inverse" rel="tooltip" title="Edit the Current Image" id="btn_edit_cover" target="_blank" style="margin:5px" href="<?php echo site_url('/').'my_images/edit_image/'. urlencode($this->encrypt->encode('assets/content/photos/'.$cover,  $this->config->item('encryption_key'), TRUE));?>"><i class="icon-pencil icon-white"></i> Edit Image</a>

					<?php	  }else{

						echo '';

					} ?>

				</div>

				<div class="span6">
					<input type="hidden" id="cover_msg" name="" value="">
					<input type="file"  class="hide" id="userfile1" name="userfile1">
					<input type="hidden" name="id" value="<?php echo $id;?>">
					<input type="hidden" name="type" value="<?php echo $type;?>">

					<button type="submit" style="margin:5px"  class="btn btn-inverse pull-right" id="coverbut"><i class="icon-picture icon-white"></i> <?php if($cover != ''){ echo 'Update Cover';}else{ echo 'Add Cover';} ?></button>
					<a class="btn btn-inverse pull-right" rel="tooltip" title="Cover Image 750 pixels x 300 pixels" style="margin:5px" onclick="$('#userfile1').click();">Browse Cover</a>
				</div>

			</fieldset>
		</form>
	</div>
</div>
<?php } ?>

	<div id="avatar_msg"></div>
	<div class="progress progress-striped active hide" id="procover">
		<div class="bar bar-warning" style="width: 0%;"></div>
	</div>

<form id="content-update" name="content-update" method="post" action="<?php echo site_url('/');?>my_admin/update_content_do" class="form-horizontal">
	<fieldset>
		<legend>Update Content details</legend>

		<div class="control-group">
			<label class="control-label" for="title">Title</label>
			<div class="controls">
				<input type="text" class="span4" id="title" name="title" placeholder="Title" value="<?php if(isset($title)){echo $title;}?>">
			</div>
		</div>
		<?php //ANIMALS
		if($type == 'animals' || $type == 'birds')
		{
		?>
			<div class="control-group">
				<label class="control-label" for="deal_cat">Category</label>
				<div class="controls">

					<select class="span12" id="deal_cat" name="deal_cat" placeholder="Category">
						<option value="0">Select category</option>
						<?php $cats = $this->admin_model->get_main_categories_db();
						foreach($cats->result() as $row){

							if(isset($cat_deal) && $cat_deal == $row->ID){

								echo '<option value="'.$row->ID.'" selected="selected">'.$row->CATEGORY_NAME.'</option>';

							}else{

								echo '<option value="'.$row->ID.'">'.$row->CATEGORY_NAME.'</option>';

							}

						}

						?>
					</select>

					<span class="help-block" style="font-size:11px">Please select a category for the content</span>

				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="sname">Scientific Name</label>
				<div class="controls">
					<input type="text" class="span4" id="sname" name="sname" placeholder="Scientific Name" value="<?php if(isset($sname)){echo $sname;}?>">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="dtext">Danger Text</label>
				<div class="controls">
					<input type="text" class="span4" id="dtext" name="dtext" placeholder="Danger Text" value="<?php if(isset($dtext)){echo $dtext;}?>">
				</div>
			</div>

			<div class="control-group">
				<label class="control-label" for="diet">Diet</label>
				<div class="controls">
					<input type="text" class="span4" id="diet" name="diet" placeholder="Diet" value="<?php if(isset($diet)){echo $diet;}?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="size">Size</label>
				<div class="controls">
					<input type="text" class="span4" id="size" name="size" placeholder="Size" value="<?php if(isset($size)){echo $size;}?>">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="weight">Weight</label>
				<div class="controls">
					<input type="text" class="span4" id="weight" name="weight" placeholder="Weight" value="<?php if(isset($weight)){echo $weight;}?>">
				</div>
			</div>
		<?php //end ANIMALS
		}?>
		<!--<div class="control-group">
			<label class="control-label" for="sname">Title</label>
			<div class="controls">
				<input type="text" class="span4" id="sname" name="sname" placeholder="Surname" value="<?php /*if(isset($title)){echo $title;}*/?>">
			</div>
		</div>-->

		<!--<div class="control-group">
			<label class="control-label" for="dob">Date of Birth</label>
			<div class="controls">
				<input type="text" id="dob" name="dob" class="span4" placeholder="YYYY-MM-DD" value="<?php /*if(isset($dob)){echo $dob;}*/?>">
			</div>
		</div>-->

		<div class="control-group">

			<label class="control-label" for="content">Content Info</label>
			<div class="controls">
				<textarea id="redactor_content" name="content" style="display:block" class="redactor"><?php if(isset($body)){ echo $body;}?></textarea>
			</div>
		</div>

		<!--<div class="control-group">
			<label class="control-label" for="daily_mail">My Na Daily</label>
			<div class="controls">
				<div class="btn-group" data-toggle="buttons-radio">
					<button type="button" id="daily_y" onclick="javascript:toggle_note_check('Y');" class="btn btn-inverse <?php /*if(isset($daily_mail)){ if($daily_mail == 'Y'){echo 'active';}}else{ echo '';}*/?>">Yes</button>
					<button type="button" id="daily_n" onclick="javascript:toggle_note_check('N');" class="btn btn-inverse <?php /*if(isset($daily_mail)){ if($daily_mail == 'N'){echo 'active';}}else{ echo '';}*/?>">No</button>

				</div>
				<input type="hidden" name="daily_mail" id="daily_mail" value="<?php /*//echo $daily_mail;*/?>" />
				<span class="help-block" style="font-size:11px">Do you want to receive the daily my na email?</span>
			</div>
		</div>-->
		<input type="hidden" name="id" value="<?php echo $id;?>">
		<input type="hidden" name="type" value="<?php echo $type;?>">
		<div id="result_msg"></div>
		<?php if($id == 0){;?>
			<a href="" class="btn btn pull-right" id="butt">Add</a>
		<?php }else{?>
			<a href="" class="btn btn pull-right" id="butt">Update</a>

		<?php }?>
	</fieldset>
</form>
	<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
	<script src="<?php echo base_url('/')?>redactor/redactor/video.js"></script>
	<script src="<?php echo base_url('/')?>redactor/redactor/table.js"></script>
<script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
<script type="text/javascript">


	$(document).ready(function(e)
	{

		$('#redactor_content').redactor({
			imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
			imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
			buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				'video','image', 'table','|',
				'alignment', '|', 'horizontalrule'],
			cleanOnPaste: true,
			plugins: ['table', 'video']
		});
		$('[rel=tooltip]').tooltip();


		$('#butt').bind('click', function (e)
		{


			e.preventDefault();
			//Validate
			if ($('#title').val().length == 0)
			{

				$('#title').focus();



			} else
			{

				submit_form();

			}
		});


		var url = window.URL || window.webkitURL;

		$("#cover_file").change(function (e)
		{


			var str1 = '';
			if (this.disabled)
			{
				str1 = 'Your browser does not support File upload.';
			} else
			{
				var chosen = this.files[0];
				var image = new Image();

				image.onload = function ()
				{

					var Ow = this.width, Oh = this.height, Filsesize = Math.round(chosen.size / 1024);
					$("#cover_msg").val(validate_image('cover', Ow, Oh, 300, 750, 7000, 7000));
					//console.log(validate_image('cover', Ow, Oh, 300, 900, 7000, 7000));
					//str1 = validate_image('cover', Ow, Oh, 300, 900, 7000, 7000);

				};
				image.onerror = function ()
				{
					str1 = 'PLease choose an image file, not a ' + chosen.type + ' extension';
				};
				image.src = url.createObjectURL(chosen);
			}

			//console.log($("#cover_msg").val());
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
					url:       	   '<?php echo site_url('/').'my_images/add_cover';?>' ,
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


	function submit_form(){

		var frm = $('#content-update');
		//frm.submit();
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'my_admin/update_content_do';?>' ,
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


</script>



<?php	
}
?>

