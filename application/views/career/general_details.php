<?php echo $this->load->view('career/inc/header'); ?>
<link href="<?php echo base_url('/'); ?>css/datepicker.css" rel="stylesheet" type="text/css"/>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
<div class="container-fluid" style="margin:0px; padding:0px">



		<?php //echo $this->load->view('inc/progress'); ?>


			<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
				<?php echo $this->load->view('career/inc/nav_main'); ?>
			</div>
			<div class="col-md-9 col-sm-9">
				<div class="row-fluid hidden-sm hidden-xs"; style="padding-left:15px"><h1>My Profile - General Details</h1></div>
				<hr />
				<div class="row-fluid">
					<form action="<?php echo site_url('/')?>main/update_general_details/" method="post" enctype="multipart/form-data" name="update-details" id="update-details" >
						<div class="form-group col-md-6">
							<label for="name">Name</label>
							<input
								type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $CLIENT_NAME; ?>">
						</div>
						<div class="form-group col-md-6">
							<label for="surname">Surname</label>
							<input type="text" class="form-control" name="surname" id="surname" placeholder="Enter Surname" value="<?php echo $CLIENT_SURNAME; ?>" >
						</div>

						<div class="form-group col-md-6">
							<label for="surname">Gender</label>
							<select class="form-control" name="gender">
								<option value="">Choose a Gender</option>
								<option value="M" <?php if($CLIENT_GENDER == 'M') { echo 'selected="selected"'; }?>>Male</option>
								<option value="F" <?php if($CLIENT_GENDER == 'F') { echo 'selected="selected"'; }?>>Female</option>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label for="dob">Date of Birth</label>
							<input class="form-control" name="dob" id="dob" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y', strtotime($CLIENT_DATE_OF_BIRTH)); ?>">

						</div>

						<div class="form-group col-md-6">
							<label for="marital">Marital Status</label>
							<select class="form-control" name="marital">
								<option value="">Choose a Option</option>
								<option value="Single" <?php if($marital_status == 'Single') { echo 'selected'; }?>>Single</option>
								<option value="Married" <?php if($marital_status == 'Married') { echo 'selected'; }?>>Married</option>
								<option value="Divorced" <?php if($marital_status == 'Divorced') { echo 'selected'; }?>>Divorced</option>
								<option value="Common Law" <?php if($marital_status == 'Common Law') { echo 'selected'; }?>>Common Law</option>
								<option value="Widow" <?php if($marital_status == 'Widow') { echo 'selected'; }?>>Widow</option>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label for="id_number">ID Number</label>
							<input type="text" class="form-control" name="id_number" id="id_number" placeholder="Enter ID Number" value="<?php echo $id_number; ?>">
						</div>

						<div class="form-group col-md-12">
							<label for="email">Email</label>
							<input type="email" class="form-control" name="email" id="email" placeholder="Enter Email" value="<?php echo $CLIENT_EMAIL; ?>" disabled>
						</div>
						<div class="form-group col-md-6">
							<label for="tel">Telephone</label>
							<input type="text" class="form-control" name="tel" id="tel" placeholder="Enter Telephone" value="<?php echo $CLIENT_TELEPHONE; ?>">
						</div>

						<div class="form-group col-md-6">
							<label for="cell">Cellphone</label>
							<input type="text" class="form-control" name="cell" id="cell" placeholder="Enter Cellphone" value="<?php echo $CLIENT_CELLPHONE; ?>">
						</div>

						<div class="form-group col-md-6">
							<label for="nationality">Nationality</label>
							<input type="text" class="form-control" name="nationality" id="nationality" placeholder="Enter Nationality" value="<?php echo $nationality; ?>">
						</div>

						<div class="form-group col-md-6">
							<label for="country">Country</label>
							<select class="form-control" name="country">
								<option value="">Select a Country</option>
								<?php echo $this->vacancy_model->get_country_select($CLIENT_COUNTRY); ?>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label for="region">Region</label>
							<select class="form-control" name="region">
								<option value="">Select a Region</option>
								<?php echo $this->vacancy_model->get_region_select($CLIENT_REGION); ?>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label for="city">City</label>
							<select class="form-control" name="city" id="city">
								<option value="">Select a City</option>
								<?php echo $this->vacancy_model->get_city_select($CLIENT_CITY); ?>
							</select>
						</div>

						<div class="form-group col-md-6">
							<label for="address">Physical Address</label>
							<textarea name="address" cols="" rows="" class="form-control"><?php echo $address; ?></textarea>
						</div>

						<div class="form-group col-md-6">
							<label for="box_address">Postal Address</label>
							<textarea name="box_address" cols="" rows="" class="form-control"><?php echo $box_address; ?></textarea>
						</div>



						<div class="form-group col-md-12" style="margin-bottom:20px">
							<label for="bee">Are You:</label><br />
							<input name="bee" type="radio" value="RDA" <?php if($bee == 'RDA') { echo 'checked'; } ?>/> Racially Disadvantaged<br />
							<input name="bee" type="radio" value="RA"  <?php if($bee == 'RA') { echo 'checked'; } ?>/> Racially Advantaged
						</div>

						<div class="form-group col-md-12" style="margin-bottom:20px">
							<label for="bee">Are You Disabled?</label><br />
							<input name="disabled" id="dis" type="checkbox" value="Y" <?php if($disabled == 'Y') { echo 'checked'; } ?> /> Check if Yes

							<?php if($disabled != 'Y') { $dis_stl = 'style="display:none"'; }  else { $dis_stl =''; } ?>

							<div class="row-fluid" id="d_toggle" <?php echo $dis_stl; ?>>
								<label for="disability">What is the nature of your disability?</label>
								<textarea name="disability" cols="" rows="" class="form-control disability"><?php echo $disability; ?></textarea>
							</div>
						</div>

						<div class="form-group col-md-12" style="margin-bottom:20px">
							<label for="drivers">Do you have a Drivers License?</label><br />
							<input name="drivers" id="drv" type="checkbox" value="Y" <?php if($drivers == 'Y') { echo 'checked'; } ?> /> Check if Yes

							<?php if($drivers != 'Y') { $drv_stl = 'style="display:none"'; }  else { $drv_stl =''; } ?>

							<div class="row-fluid" id="dr_toggle" <?php echo $drv_stl; ?>>
								<label for="drivers_type">What type of License do you have?</label>
								<select class="form-control" name="drivers_type">
									<option value="B" <?php if($drivers_type == 'B') { echo 'selected'; }?>>B</option>
									<option value="BE" <?php if($drivers_type == 'BE') { echo 'selected'; }?>>BE</option>
									<option value="C" <?php if($drivers_type == 'C') { echo 'selected'; }?>>C</option>
									<option value="C1" <?php if($drivers_type == 'C1') { echo 'selected'; }?>>C1</option>
									<option value="C1E" <?php if($drivers_type == 'C1E') { echo 'selected'; }?>>C1E</option>
									<option value="CE" <?php if($drivers_type == 'CE') { echo 'selected'; }?>>CE</option>
									<option value="PDP <?php if($drivers_type == 'PDP') { echo 'selected'; }?>">PDP</option>
								</select>
							</div>
						</div>


						<div class="form-group col-md-12" id="tmp_toggle">
							<label for="temp_work">Are you registering for temporary work?</label><br />

							<input name="temp_work" id="tmp" type="checkbox" value="Y" <?php if($temp_work == 'Y') { echo 'checked'; } ?> /> Check if Yes

						</div>


						<div class="form-group col-md-12">
							<button type="submit" id="form-submit" class="btn btn-primary btn-block" style="margin-bottom:20px">Update Details</button>
						</div>
					</form>

				</div>

			</div>



</div>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>

<?php echo $this->load->view('career/inc/footer'); ?>
<script>
	$( document ).ready(function() {

		$("#dis").change(function() {
			if(this.checked) {
				$("#d_toggle").toggle();
			} else {
				$("#d_toggle").toggle();
			}
		});

		$("#drv").change(function() {
			if(this.checked) {
				$("#dr_toggle").toggle();
			} else {
				$("#dr_toggle").toggle();
			}
		});



		$('#dob').datepicker();

		$(function() {
			$('#update-details').on('submit', function (e) {

				e.preventDefault();

				$('#form-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				var form_val = true;

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/update_general_details/',
						data: $('#update-details').serialize(),
						success: function (data) {

							$('#form-submit').html('Update Details');
							$('#result_msg').html(data);

							location.reload();
						}
					});

				} else {

					$('#form-submit').html('Update Details');

				}

			});
		});
	});
</script>

</body>
</html>