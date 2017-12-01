<?php echo $this->load->view('career/inc/header'); ?>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<div class="container-fluid" style="margin:0px; padding:0px">

	<?php //echo $this->load->view('inc/progress'); ?>

	<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
		<?php echo $this->load->view('career/inc/nav_main'); ?>
	</div>
	<div class="col-md-9 col-sm-9">
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - References</h1></div>
		<hr />

		<div class="row-fluid">
			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-references">Add Reference</button>
			<pre style="padding:0px">
			<table class="table table-striped table-responsive" style="margin:0px">
				<thead>
				<tr>
					<th>Name</th>
					<th>Organisation</th>
					<th>Contact Number</th>
					<th>Contact Email</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php echo $this->vacancy_model->get_references(); ?>
				</tbody>
			</table>
			</pre>
		</div>

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="my-references" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Reference</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('/')?>vacancy/add_reference/" method="post" enctype="multipart/form-data" name="add-reference" id="add-reference">
					<div class="form-group">
						<label for="fname">First Name</label>
						<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name">
					</div>

					<div class="form-group">
						<label for="lname">Last Name</label>
						<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name">
					</div>

					<div class="form-group">
						<label for="institution">Organisation</label>
						<input type="text" class="form-control" name="organisation" id="organisation" placeholder="Enter Organisation">
					</div>

					<div class="form-group">
						<label for="tel">Contact Number</label>
						<input type="text" class="form-control" name="tel" id="tel" placeholder="Enter Contact Number">
					</div>

					<div class="form-group">
						<label for="email">Contact Email</label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Enter Contact Email">
					</div>
					<div class="form-group">
						<label for="bus_type">I have permission to add the following referee</label>
						<input name="permission" id="permission" type="checkbox" value="Y" />
					</div>
					<hr />
					<div id="result_msg"></div>
					<button type="submit" class="btn btn-primary" id="ref-submit">Add Entry</button>
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
<script>
	$( document ).ready(function() {


		$(function() {
			$('#add-reference').on('submit', function (e) {

				e.preventDefault();

				$('#ref-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				var permission = $('#permission').prop('checked');

				console.log(permission);

				if(permission == true){

					$('#permission').popover('hide');
					var form_val = true;


				}  else {

					$('#permission').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Referee Check", content:"Please check to continue"});
					$('#permission').popover('show');
					$('#permission').focus();

					var form_val = false;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_reference/',
						data: $('#add-reference').serialize(),
						success: function (data) {

							$('#ref-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#ref-submit').html('Add Entry');

				}

			});
		});


	});

	$(".remove-itm").click(function(){


		var val = (this.value);

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>vacancy/delete_reference/'+val,
			success: function (data) {

				$("#row-"+val).closest('tr').remove();

			}
		});

	});
</script>

</body>
</html>