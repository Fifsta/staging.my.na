<?php echo $this->load->view('career/inc/header'); ?>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
<link href="<?php echo base_url('/'); ?>css/datepicker.css" rel="stylesheet" type="text/css"/>
<style>
	.datepicker{z-index:1151 !important;}
</style>

<div class="container-fluid" style="margin:0px; padding:0px">

	<?php //echo $this->load->view('inc/progress'); ?>

	<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
		<?php echo $this->load->view('career/inc/nav_main'); ?>
	</div>
	<div class="col-md-9 col-sm-9">
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Employment History</h1></div>
		<hr />

		<div class="row-fluid">
			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-employments">Add Employment</button>
			<pre style="padding:0px">
			<table class="table table-striped table-responsive" style="margin:0px">
				<thead>
				<tr>
					<th>Company</th>
					<th>Position</th>
					<th>Business Type</th>
					<th>Job level</th>
					<th>Job Type</th>
					<th>Salary Type</th>
					<th>Salary</th>
					<th>Frequency</th>
					<th>Benefits</th>
					<th>Duration</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php echo $this->vacancy_model->get_employments(); ?>
				</tbody>
			</table>
			</pre>
		</div>

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="my-employments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Employment</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('/')?>vacancy/add_employment/" method="post" enctype="multipart/form-data" name="add-employment" id="add-employment">
					<h4>Job Details</h4>
					<div class="form-group">
						<label for="company">Company</label>
						<input type="text" class="form-control" name="company" id="company" placeholder="Enter Company Name">
					</div>

					<div class="form-group">
						<label for="position">Position</label>
						<input type="text" class="form-control" name="position" id="position" placeholder="Enter Position">
					</div>

					<div class="form-group">
						<label for="bus_type">Business Type</label>
						<input type="text" class="form-control" name="bus_type" id="bus_type" placeholder="Enter Business Type">
					</div>

					<div class="form-group">
						<label for="level">Job Level</label>
						<select name="level" class="form-control">
							<option value="Entry">Entry</option>
							<option value="Student">Student</option>
							<option value="Junior">Junior</option>
							<option value="Skilled">Skilled</option>
							<option value="Senior">Senior</option>
							<option value="Management">Management</option>
							<option value="Executive">Executive</option>
						</select>
					</div>

					<div class="form-group">
						<label for="type">Job Type</label>
						<select name="type" class="form-control">
							<option value="Permanent">Permanent</option>
							<option value="Contract">Contract</option>
							<option value="Temporary">Temporary</option>
						</select>
					</div>
					<hr />
					<h4>Renumeration</h4>
					<div class="form-group">
						<label for="salary_type">Salary Type</label>
						<select name="salary_type" class="form-control">
							<option value="Structure ">Structure</option>
							<option value="Commission">Commission Only</option>
							<option value="Basic & Commision">Basic & Commision</option>
							<option value="Basic Salary">Basic Salary</option>
							<option value="Cost to Company">Cost to Company</option>
							<option value="On target earnings">On target earnings</option>
						</select>
					</div>

					<div class="form-group">
						<label for="frequency">Frequency</label>
						<select name="frequency" class="form-control">
							<option value="Annually">Annually</option>
							<option value="Per month">Per month</option>
							<option value="Per week">Per week</option>
							<option value="Per day">Per day</option>
							<option value="Per hour">Per hour</option>
							<option value="Once off">Once off</option>
						</select>
					</div>

					<div class="form-group">
						<label for="salary">Salary (N$)</label>
						<input type="text" class="form-control" name="salary" id="salary" placeholder="Enter Salary">
					</div>

					<div class="form-group">
						<label for="benefits">Benefits</label>
						<textarea class="form-control" name="benefits" id="benefits" placeholder="Enter Benefits"></textarea>
					</div>

					<hr />
					<h4>Duration</h4>
					<div class="form-group">
						<label for="dur_from">Duration From</label>
						<input class="form-control" name="dur_from" id="dur_from" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<div class="form-group">
						<label for="dur_to">Duration To</label>
						<input class="form-control" name="dur_to" id="dur_to" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<div class="form-group">
						<label for="why_leave">Reasons for leaving</label>
						<textarea class="form-control" name="why_leave" id="why_leave" placeholder="Reasons for leaving"></textarea>
					</div>


					<hr />
					<div id="result_msg"></div>
					<button type="submit" class="btn btn-primary" id="employ-submit">Add Entry</button>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<?php echo $this->load->view('career/inc/footer'); ?>
<script type="text/javascript" src="<?php echo base_url('/');?>bootstrap/js/bootstrap.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>
<script>
	$( document ).ready(function() {

		$('#dur_from').datepicker();
		$('#dur_to').datepicker();

		$(function() {
			$('#add-employment').on('submit', function (e) {

				e.preventDefault();

				$('#employ-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				if($('#company').val().length == 0){

					$('#company').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name of Company", content:"Please supply Company Name"});
					$('#company').popover('show');
					$('#company').focus();

					var form_val = false;


				}  else {

					$('#company').popover('hide');
					var form_val = true;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_employment/',
						data: $('#add-employment').serialize(),
						success: function (data) {

							$('#employ-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#employ-submit').html('Add Entry');

				}

			});
		});


	});

	$(".remove-itm").click(function(){


		var val = (this.value);

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>vacancy/delete_employment/'+val,
			success: function (data) {

				$("#row-"+val).closest('tr').remove();

			}
		});

	});
</script>

</body>
</html>