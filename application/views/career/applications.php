<?php echo $this->load->view('career/inc/header'); ?>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<div class="container-fluid" style="margin:0px; padding:0px">

	<?php //echo $this->load->view('inc/progress'); ?>

	<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
		<?php echo $this->load->view('career/inc/nav_main'); ?>
	</div>
	<div class="col-md-9 col-sm-9">
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Applications</h1></div>
		<hr />

		<div class="row-fluid">
			<pre style="padding:0px">
			<table class="table table-striped table-responsive" style="margin:0px">
				<thead>
				<tr>
					<th>Application</th>
					<th>listing_date</th>
					<th>Status</th>
				</tr>
				</thead>
				<tbody>
				<?php echo $this->vacancy_model->get_applications(); ?>
				</tbody>
			</table>
			</pre>
		</div>

	</div>

</div>


<?php echo $this->load->view('career/inc/footer'); ?>
<script type="text/javascript" src="<?php echo base_url('/');?>bootstrap/js/bootstrap.js"></script>
<script>
	$( document ).ready(function() {

		$(".remove-itm").click(function(){


			var val = (this.value);

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/delete_application/'+val,
				success: function (data) {

					$("#row-"+val).closest('tr').remove();

				}
			});

		});

	});
</script>

</body>
</html>