<?php echo $this->load->view('career/inc/header'); ?>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<div class="container-fluid" style="margin:0px; padding:0px">

	<?php // echo $this->load->view('inc/progress'); ?>

	<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
		<?php echo $this->load->view('career/inc/nav_main'); ?>
	</div>
	<div class="col-md-9 col-sm-9">
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Languages</h1></div>
		<hr />

		<div class="row-fluid">
			<button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#my-languages">Add Language</button>
			<pre style="padding:0px">
			<table class="table table-striped table-responsive" style="margin:0px">
				<thead>
				<tr>
					<th>Language</th>
					<th>Read</th>
					<th>Write</th>
					<th>Speak</th>
					<th>First Language</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php echo $this->vacancy_model->get_languages(); ?>
				</tbody>
			</table>
			</pre>
		</div>

	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="my-languages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Upload Language</h4>
			</div>
			<div class="modal-body">
				<form action="<?php echo site_url('/')?>vacancy/add_language/" method="post" enctype="multipart/form-data" name="add-language" id="add-language">
					<div class="form-group">
						<label for="language">Language</label>
						<select class="form-control" name="language" id="language">
							<option value="">Choose a Option</option>
							<?php echo $this->vacancy_model->get_language_list(); ?>
						</select>
					</div>

					<div class="form-group">
						<label for="position">Proficiency</label><br />
						<input name="read" class="group-control" type="checkbox" value="Y" /> Read<br />
						<input name="write" type="checkbox" value="Y" /> Write<br />
						<input name="speak" type="checkbox" value="Y" /> Speak
					</div>

					<div class="form-group">
						<label for="bus_type">First Language</label><br />
						<input name="first_lang" type="checkbox" value="Y" />
					</div>

					<hr />
					<div id="result_msg"></div>
					<button type="submit" class="btn btn-primary" id="lang-submit">Add Entry</button>
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
			$('#add-language').on('submit', function (e) {

				e.preventDefault();

				$('#lang-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

				if($('#language').val().length == 0){

					$('#language').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name of Language", content:"Please supply a Language"});
					$('#language').popover('show');
					$('#language').focus();

					var form_val = false;


				}  else {

					$('#language').popover('hide');
					var form_val = true;

				}

				if(form_val == true) {

					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_language/',
						data: $('#add-language').serialize(),
						success: function (data) {

							$('#lang-submit').html('Add Entry');

							if(data == 'Success') {
								location.reload();
							}
						}
					});

				} else {

					$('#lang-submit').html('Add Entry');

				}

			});
		});


	});

	$(".remove-itm").click(function(){


		var val = (this.value);

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>vacancy/delete_language/'+val,
			success: function (data) {

				$("#row-"+val).closest('tr').remove();

			}
		});

	});
</script>

</body>
</html>