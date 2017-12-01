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
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Achievements</h1></div>
		<hr />

		<div class="row-fluid">
			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-achievements">Add Achievement</button>
			<pre style="padding:0px">
			<table class="table table-striped table-responsive" style="margin:0px">
				<thead>
				<tr>
					<th>Achievement</th>
					<th>Organisation</th>
					<th>Receive date</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php echo $this->vacancy_model->get_achievements(); ?>
				</tbody>
			</table>
			</pre>
		</div>

	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="my-achievements" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Achievement</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('/')?>vacancy/add_achievement/" method="post" enctype="multipart/form-data" name="add-achievement" id="add-achievement">
					<div class="form-group">
						<label for="institution">Achievement</label>
						<input type="text" class="form-control" name="achievement" id="achievement" placeholder="Enter Achievement">
					</div>

					<div class="form-group">
						<label for="institution">Organisation</label>
						<input type="text" class="form-control" name="organisation" id="organisation" placeholder="Enter Organisation">
					</div>

					<div class="form-group">
						<label for="dur_from">Received on:</label>
						<input class="form-control" name="received" id="received" data-date-format="dd-mm-yyyy" placeholder="eg dd-mm-yyyy" style="width:100%">
					</div>

					<hr />
					<div id="result_msg"></div>
					<button type="submit" class="btn btn-primary" id="achieve-submit">Add Entry</button>
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

		$('#received').datepicker();


		$(function() {
			$('#add-achievement').on('submit', function (e) {

				e.preventDefault();

				$('#achieve-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				if($('#achievement').val().length == 0){

					$('#achievement').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name of Achievement", content:"Please supply Achievement"});
					$('#achievement').popover('show');
					$('#achievement').focus();

					var form_val = false;


				}  else {

					$('#achievement').popover('hide');
					var form_val = true;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_achievement/',
						data: $('#add-achievement').serialize(),
						success: function (data) {

							$('#achieve-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#achieve-submit').html('Add Entry');

				}

			});
		});


	});

	$(".remove-itm").click(function(){


		var val = (this.value);

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>vacancy/delete_achievement/'+val,
			success: function (data) {

				$("#row-"+val).closest('tr').remove();

			}
		});

	});
</script>

</body>
</html>