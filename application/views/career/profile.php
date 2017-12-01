<?php $this->load->view('career/inc/header');?>


<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
<div class="container-fluid" style="margin:0px; padding:0px">


		<?php //echo $this->load->view('career/inc/progress'); ?>


		<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
			<?php echo $this->load->view('career/inc/nav_main'); ?>
		</div>
		<div class="col-lg-3 col-md-3 profile-progress">
			<div class="row-fluid">
				<?php $this->vacancy_model->get_avatar(); ?>
				<hr />
			</div>
			<div class="row-fluid">
				<h4>My CV Document</h4>
				<small>Please select a file form your desktop <span style="color:#C00">(Note: Only word or pdf files allowed)</span></small>
				<?php $this->vacancy_model->get_cv_document(); ?>
				<hr>
			</div>
			<div class="row-fluid">
				<h4>My ID Document</h4>
				<small>Please select a file form your desktop <span style="color:#C00">(Note: Only pdf or jpg files allowed)</span></small>
				<?php $this->vacancy_model->get_id_document(); ?>
				<hr>
			</div>
			<div class="row-fluid">
				<h4>My Drivers License Document</h4>
				<small>Please select a file form your desktop <span style="color:#C00">(Note: Only pdf or jpg files allowed)</span></small>
				<?php $this->vacancy_model->get_license_document(); ?>
				<hr>
			</div>

		</div>



		<div class="col-lg-6 col-md-6">

			<div class="row-fluid hidden-sm hidden-xs"><h1><span class="glyphicon glyphicon-user" aria-hidden="true"></span> My Resume</h1></div>
			<hr />
			<div class="row-fluid">

				<h4>My Biography</h4>
				<div id="myBio"><div id="bioBody"><?php echo $biography; ?></div>  <a href="javascript:void(0);" onclick="edit_bio()" class="btn btn-sm btn-primary"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></div>
				<div id="editBio" style="display:none">
					<form action="<?php echo site_url('/')?>vacancy/add_bio/" method="post" enctype="multipart/form-data" name="bio" id="bio">
						<div class="form-group row-fluid">
							<textarea name="content" class="form-control" style="display:block;"><?php if(isset($biography)){echo $biography;}?></textarea>
							<button type="submit" id="form-submit" class="btn btn-primary" style="margin-top:10px">Update Biography</button>
						</div>
					</form>
				</div>

			</div>
			<hr />
			<div class="row-fluid">
				<h4>My Details</h4>
				<table class="table table-striped">
					<tr><td><strong>Name: </strong> <?php echo $CLIENT_NAME .' '. $CLIENT_SURNAME; ?> (<?php echo $CLIENT_GENDER; ?>)</td></tr>
					<tr><td><strong>Date of Birth: </strong> <?php echo date('d M Y', strtotime($CLIENT_DATE_OF_BIRTH)); ?></td></tr>
					<tr><td><strong>Email: </strong> <?php echo $CLIENT_EMAIL; ?></td></tr>
					<tr><td><strong>Tel: </strong> <?php echo $CLIENT_TELEPHONE; ?></td></tr>
					<tr><td><strong>Cell: </strong> <?php echo $CLIENT_CELLPHONE; ?></td></tr>
					<tr><td><strong>Nationality: </strong> <?php echo $nationality; ?></td></tr>
					<tr><td><strong>Country: </strong> <?php echo $COUNTRY_NAME; ?></td></tr>
					<tr><td><strong>Region: </strong> <?php echo $REGION_NAME; ?></td></tr>
					<tr><td><strong>City: </strong> <?php echo $MAP_LOCATION; ?></td></tr>
					<tr><td><strong>Drivers Licence: </strong> <?php echo $drivers; if($drivers == 'Y') { echo ' ('.$drivers_type.')'; } ?></td></tr>
				</table>
				<a href="<?php echo site_url('/'); ?>vacancy/general_details" class="btn btn-sm btn-primary">Update General Info >></a>
			</div>
			<hr />
			<div class="row-fluid">
				<h4>My Job Applications</h4>
				<?php echo $this->vacancy_model->get_my_vacancies(); ?>
			</div>

		</div>


</div>


<?php echo $this->load->view('career/inc/footer'); ?>


<script>

	$( document ).ready(function() {

		$(function() {
			$('#bio').on('submit', function (e) {

				e.preventDefault();

				$('#form-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				var form_val = true;



				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_bio/',
						data: $('#bio').serialize(),
						success: function (data) {

							$('#form-submit').html('Update Biography');
							$('#result_msg').html(data);

							if(data == 'Success') {


								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/')?>main/get_biography/',
									success: function (data) {

										$('#bioBody').html(data);
										$('#myBio').show();
										$('#editBio').hide();

									}
								});

							}
						}
					});

				} else {

					$('#form-submit').html('Update Biography');

				}
			});
		});



		//Featured CV Document
		$('#docbut').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg2',
				url:       	   '<?php echo site_url('/').'vacancy/add_cv_document';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg2').html(xhr.responseText);

					$('#docbut').html('ADD CV Document');
				}

			};

			var frm = $('#add-doc');
			var probar = $('#procover2 .progress-bar');
			var procover = $('#procover2');

			$('#docbut').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});


		//Featured ID Document
		$('#iddocbut').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg3',
				url:       	   '<?php echo site_url('/').'vacancy/add_id_document';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg3').html(xhr.responseText);

					$('#iddocbut').html('Add ID Document');
				}

			};

			var frm = $('#add-id-doc');
			var probar = $('#procover3 .progress-bar');
			var procover = $('#procover3');

			$('#iddocbut').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});




		//Featured LICENCE Document
		$('#licensedocbut').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg6',
				url:       	   '<?php echo site_url('/').'vacancy/add_license_document';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg6').html(xhr.responseText);

					$('#licensedocbut').html('Add License Document');
				}

			};

			var frm = $('#add-license-doc');
			var probar = $('#procover6 .progress-bar');
			var procover = $('#procover6');

			$('#licensedocbut').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});





		//Featured ID Document
		$('#avatarbut').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg4',
				url:       	   '<?php echo site_url('/').'vacancy/add_avatar_pic';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg4').html(xhr.responseText);

					$('#avatarbut').html('Upload');
				}

			};

			var frm = $('#add-avatar-pic');
			var probar = $('#procover4 .progress-bar');
			var procover = $('#procover4');

			$('#avatarbut').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});


	});

	function edit_bio() {

		var bio = '';

		$('#myBio').hide();
		$('#editBio').show();

	}



</script>

</body>
</html>