<?php echo $this->load->view('career/inc/header'); ?>
<link href="<?php echo base_url('/'); ?>css/datepicker.css" rel="stylesheet" type="text/css"/>
<style>
	.datepicker{z-index:1151 !important;}
</style>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<div class="container-fluid" style="margin:0px; padding:0px">


		<?php //echo $this->load->view('inc/progress'); ?>

			<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
				<?php echo $this->load->view('career/inc/nav_main'); ?>
			</div>
			<div class="col-md-9 col-sm-9">
				<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Education & Courses</h1></div>
				<hr />
				<div class="row-fluid">
					<h4>Secondary Education</h4>
					<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-secondary-education">Add Secondary Education</button>
					<pre style="padding:0px">
					<table class="table table-striped table-responsive" style="margin:0px">
						<thead>
						<tr>
							<th>Name of School</th>
							<th>Duration</th>
							<th>Highest Grade Passed</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php echo $this->vacancy_model->get_education('secondary'); ?>
						</tbody>
					</table>
					</pre>
				</div>
				<hr />
				<div class="row-fluid">
					<h4>Tertiary Education</h4>
					<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-tertiary-education">Add Tertiary Education</button>
					<pre style="padding:0px">
					<table class="table table-striped table-responsive" style="margin:0px">
						<thead>
						<tr>
							<th>Name of Institution</th>
							<th>Field of Study</th>
							<th>Duration</th>
							<th>Highest Qualification</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php echo $this->vacancy_model->get_education('tertiary'); ?>
						</tbody>
					</table>
					</pre>
				</div>
				<hr />
				<div class="row-fluid">
					<h4>Courses</h4>
					<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-course-education">Add Course</button>
					<pre style="padding:0px">
					<table class="table table-striped table-responsive" style="margin:0px">
						<thead>
						<tr>
							<th>Name of Course</th>
							<th>Duration</th>
							<th>Institution</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						<?php echo $this->vacancy_model->get_education('course'); ?>
						</tbody>
					</table>
					</pre>
				</div>
			</div>


</div>

<!-- Modal -->
<div class="modal fade" id="my-secondary-education" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Secondary Education</h4>
			</div>
			<div class="modal-body">


				<form action="<?php echo site_url('/')?>vacancy/add_education/" method="post" enctype="multipart/form-data" name="add-secondary-education" id="add-secondary-education">
					<input name="education_type" type="hidden" value="secondary" />
					<input name="qualification_type" type="hidden" id="qt" value="" />

					<div id="step1">
						<h5>Please Fill out the following Info</h5>
						<div class="form-group">
							<label for="institution">School</label>
							<input type="text" class="form-control" name="institution" id="institution" placeholder="Enter Name of School">
						</div>

						<div class="form-group">
							<label for="dur_from">Duration From</label>
							<input class="form-control" name="dur_from" id="dur_from" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
						</div>

						<div class="form-group">
							<label for="dur_to">Duration To</label>
							<input class="form-control" name="dur_to" id="dur_to" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
						</div>

						<div class="form-group">
							<label for="qualification">Highest Grade Passed</label>
							<select class="form-control" name="qualification" id="qualify">
								<option value="">Choose a Option</option>
								<?php echo $this->vacancy_model->get_qualifications('secondary'); ?>
							</select>
						</div>

						<hr />
						<div id="result_msg"></div>
						<button type="button" class="btn btn-primary" id="next-step" disabled>Next Step</button>

					</div>

					<div id="step2" style="display:none">
						<h5>Pleass specify your Subjects and Scores</h5>
						<div class="row form-group">
							<div class="col-sm-6">
								<label for="subject1">Subject 1</label>
								<input type="text" class="form-control" name="subject1" id="subject1" placeholder="Subject">
							</div>
							<div class="col-sm-6">
								<label for="score1">Score</label>
								<select name="score1" class="form-control">
									<option value="">Please select a grade</option>
									<option value="A" class="ls1">A</option>
									<option value="B" class="ls1">B</option>
									<option value="C" class="ls1">C</option>
									<option value="D" class="ls1">D</option>
									<option value="E" class="ls1">E</option>
									<option value="F" class="ls1">F</option>
									<option value="G" class="ls1">G</option>
									<option value="1" class="ls2">1</option>
									<option value="2" class="ls2">2</option>
									<option value="3" class="ls2">3</option>
									<option value="4" class="ls2">4</option>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-6">
								<label for="subject2">Subject 2</label>
								<input type="text" class="form-control" name="subject2" id="subject2" placeholder="Subject">
							</div>
							<div class="col-sm-6">
								<label for="score2">Score</label>
								<select name="score2" class="form-control">
									<option value="">Please select a grade</option>
									<option value="A" class="ls1">A</option>
									<option value="B" class="ls1">B</option>
									<option value="C" class="ls1">C</option>
									<option value="D" class="ls1">D</option>
									<option value="E" class="ls1">E</option>
									<option value="F" class="ls1">F</option>
									<option value="G" class="ls1">G</option>
									<option value="1" class="ls2">1</option>
									<option value="2" class="ls2">2</option>
									<option value="3" class="ls2">3</option>
									<option value="4" class="ls2">4</option>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-6">
								<label for="subject3">Subject 3</label>
								<input type="text" class="form-control" name="subject3" id="subject3" placeholder="Subject">
							</div>
							<div class="col-sm-6">
								<label for="score3">Score</label>
								<select name="score3" class="form-control">
									<option value="">Please select a grade</option>
									<option value="A" class="ls1">A</option>
									<option value="B" class="ls1">B</option>
									<option value="C" class="ls1">C</option>
									<option value="D" class="ls1">D</option>
									<option value="E" class="ls1">E</option>
									<option value="F" class="ls1">F</option>
									<option value="G" class="ls1">G</option>
									<option value="1" class="ls2">1</option>
									<option value="2" class="ls2">2</option>
									<option value="3" class="ls2">3</option>
									<option value="4" class="ls2">4</option>
								</select>
							</div>
						</div>



						<div class="row form-group">
							<div class="col-sm-6">
								<label for="subject4">Subject 4</label>
								<input type="text" class="form-control" name="subject4" id="subject4" placeholder="Subject">
							</div>
							<div class="col-sm-6">
								<label for="score4">Score</label>
								<select name="score4" class="form-control">
									<option value="">Please select a grade</option>
									<option value="A" class="ls1">A</option>
									<option value="B" class="ls1">B</option>
									<option value="C" class="ls1">C</option>
									<option value="D" class="ls1">D</option>
									<option value="E" class="ls1">E</option>
									<option value="F" class="ls1">F</option>
									<option value="G" class="ls1">G</option>
									<option value="1" class="ls2">1</option>
									<option value="2" class="ls2">2</option>
									<option value="3" class="ls2">3</option>
									<option value="4" class="ls2">4</option>
								</select>
							</div>
						</div>

						<div class="row form-group">
							<div class="col-sm-6">
								<label for="subject5">Subject 5</label>
								<input type="text" class="form-control" name="subject5" id="subject5" placeholder="Subject">
							</div>
							<div class="col-sm-6">
								<label for="score5">Score</label>
								<select name="score5" class="form-control">
									<option value="">Please select a grade</option>
									<option value="A" class="ls1">A</option>
									<option value="B" class="ls1">B</option>
									<option value="C" class="ls1">C</option>
									<option value="D" class="ls1">D</option>
									<option value="E" class="ls1">E</option>
									<option value="F" class="ls1">F</option>
									<option value="G" class="ls1">G</option>
									<option value="1" class="ls2">1</option>
									<option value="2" class="ls2">2</option>
									<option value="3" class="ls2">3</option>
									<option value="4" class="ls2">4</option>
								</select>
							</div>
						</div>



						<div id="grd" style="display:none">

							<div class="row form-group">
								<div class="col-sm-6">
									<label for="subject6">Subject 6</label>
									<input type="text" class="form-control" name="subject6" id="subject6" placeholder="Subject">
								</div>
								<div class="col-sm-6">
									<label for="score6">Score</label>
									<select name="score6" class="form-control">
										<option value="">Please select a grade</option>
										<option value="A" class="ls1">A</option>
										<option value="B" class="ls1">B</option>
										<option value="C" class="ls1">C</option>
										<option value="D" class="ls1">D</option>
										<option value="E" class="ls1">E</option>
										<option value="F" class="ls1">F</option>
										<option value="G" class="ls1">G</option>
										<option value="1" class="ls2">1</option>
										<option value="2" class="ls2">2</option>
										<option value="3" class="ls2">3</option>
										<option value="4" class="ls2">4</option>
									</select>
								</div>
							</div>

							<div class="row form-group">
								<div class="col-sm-6">
									<label for="subject7">Subject 7</label>
									<input type="text" class="form-control" name="subject7" id="subject7" placeholder="Subject">
								</div>
								<div class="col-sm-6">
									<label for="score7">Score</label>
									<select name="score7" class="form-control">
										<option value="">Please select a grade</option>
										<option value="A" class="ls1">A</option>
										<option value="B" class="ls1">B</option>
										<option value="C" class="ls1">C</option>
										<option value="D" class="ls1">D</option>
										<option value="E" class="ls1">E</option>
										<option value="F" class="ls1">F</option>
										<option value="G" class="ls1">G</option>
										<option value="1" class="ls2">1</option>
										<option value="2" class="ls2">2</option>
										<option value="3" class="ls2">3</option>
										<option value="4" class="ls2">4</option>
									</select>
								</div>
							</div>

						</div>

						<hr />
						<button type="button" class="btn btn-primary" id="back">Back</button>
						<button type="submit" class="btn btn-primary" id="edu-sec-submit">Submit</button>
					</div>

				</form>

				<div id="step1">

				</div>


			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="my-tertiary-education" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Tertiary Education</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('/')?>vacancy/add_education/" method="post" enctype="multipart/form-data" name="add-tertiary-education" id="add-tertiary-education">
					<input name="education_type" type="hidden" value="tertiary" />
					<div class="form-group">
						<label for="institution">Institution</label>
						<input type="text" class="form-control" name="institution" id="institution2" placeholder="Enter Name of Institution">
					</div>
					<div class="form-group">
						<label for="institution">Field of Study</label>
						<input type="text" class="form-control" name="study_field" id="study_field" placeholder="Enter Field of Study">
					</div>
					<div class="form-group">
						<label for="dur_from">Duration From</label>
						<input class="form-control" name="dur_from" id="dur_from2" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<div class="form-group">
						<label for="dur_to">Duration To</label>
						<input class="form-control" name="dur_to" id="dur_to2" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<div class="form-group">
						<label for="qualification">Enter Degree, Diploma etc</label>
						<input type="text" class="form-control" name="qualification" placeholder="Qualification">
					</div>
					<hr />
					<div id="result_msg"></div>
					<button type="submit" class="btn btn-primary" id="edu-sec-submit">Add Entry</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="my-course-education" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload a completed Course</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('/')?>vacancy/add_education/" method="post" enctype="multipart/form-data" name="add-course-education" id="add-course-education">
					<input name="education_type" type="hidden" value="course" />
					<div class="form-group">
						<label for="institution">Course</label>
						<input type="text" class="form-control" name="study_field" id="study_field2" placeholder="Enter Field of Study">
					</div>
					<div class="form-group">
						<label for="institution">Institution</label>
						<input type="text" class="form-control" name="institution" id="institution" placeholder="Enter Name of Institution">
					</div>
					<div class="form-group">
						<label for="dur_from">Duration From</label>
						<input class="form-control" name="dur_from" id="dur_from3" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<div class="form-group">
						<label for="dur_to">Duration To</label>
						<input class="form-control" name="dur_to" id="dur_to3" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<hr />
					<div id="result_msg"></div>
					<button type="submit" class="btn btn-primary" id="edu-crs-submit">Add Entry</button>
				</form>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('/');?>bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>
<?php echo $this->load->view('career/inc/footer'); ?>
<script>
	$( document ).ready(function() {


		$('#qualify').on('change', function() {
			var val = this.value; // or $(this).val()


			if(val == 'GRADE 10 JSC' || val == 'STD. 8 (HG)' || val == 'STD. 8 (SG)' || val == 'STD. 8 (LG)') {
				$("#grd").show();
				$("#qt").val(10);
			} else {
				$("#grd").hide();
				$("#qt").val(12);
			}

			if(val == 'HIGCSE') {
				$('.ls1').hide();
				$('.ls1 option:eq(1)').prop('selected', true)
			} else {
				$('.ls2').hide();
				$('.ls2 option:eq(1)').prop('selected', true)
			}


			if(val != '') {
				$("#next-step").removeAttr("disabled");
			} else {
				$("#next-step").prop('disabled', true);
			}
		});


		$("#next-step").click(function(){
			$("#step1").hide();
			$("#step2").show();
		});

		$("#back").click(function(){
			$("#step2").hide();
			$("#step1").show();
		});


		$('#dur_from').datepicker();
		$('#dur_to').datepicker();

		$('#dur_from2').datepicker();
		$('#dur_to2').datepicker();

		$('#dur_from3').datepicker();
		$('#dur_to3').datepicker();

		$(function() {
			$('#add-secondary-education').on('submit', function (e) {

				e.preventDefault();

				$('#edu-sec-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				if($('#institution').val().length == 0){

					$('#institution').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name of School Required", content:"Please supply School Name"});
					$('#institution').popover('show');
					$('#institution').focus();

					var form_val = false;


				}  else {

					$('#institution').popover('hide');
					var form_val = true;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_education/',
						data: $('#add-secondary-education').serialize(),
						success: function (data) {

							$('#edu-sec-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#edu-sec-submit').html('Add Entry');

				}

			});
		});


		$(function() {
			$('#add-tertiary-education').on('submit', function (e) {

				e.preventDefault();

				$('#edu-tert-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				if($('#institution2').val().length == 0){

					$('#institution2').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name of Institution Required", content:"Please supply Institution Name"});
					$('#institution2').popover('show');
					$('#institution2').focus();

					var form_val = false;


				}  else {

					$('#institution2').popover('hide');
					var form_val = true;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_education/',
						data: $('#add-tertiary-education').serialize(),
						success: function (data) {

							$('#edu-tert-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#edu-tert-submit').html('Add Entry');

				}

			});
		});

		$(function() {
			$('#add-course-education').on('submit', function (e) {

				e.preventDefault();

				$('#edu-crs-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				if($('#study_field2').val().length == 0){

					$('#study_field2').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name of Course Required", content:"Please supply Course Name"});
					$('#study_field2').popover('show');
					$('#study_field2').focus();

					var form_val = false;


				}  else {

					$('#study_field2').popover('hide');
					var form_val = true;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_education/',
						data: $('#add-course-education').serialize(),
						success: function (data) {

							$('#edu-crs-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#edu-crs-submit').html('Add Entry');

				}

			});
		});


	});

	$(".remove-itm").click(function(){


		var val = (this.value);

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>vacancy/delete_education/'+val,
			success: function (data) {

				$("#row-"+val).closest('tr').remove();

			}
		});

	});
</script>

</body>
</html>