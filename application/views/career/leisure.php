<?php echo $this->load->view('career/inc/header'); ?>
<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<div class="container-fluid" style="margin:0px; padding:0px">

	<?php //echo $this->load->view('inc/progress'); ?>

	<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
		<?php echo $this->load->view('career/inc/nav_main'); ?>
	</div>
	<div class="col-md-9 col-sm-9">
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Leisure / Interests</h1></div>
		<hr />

		<div class="row-fluid">
			<form action="<?php echo site_url('/')?>vacancy/update_leisure/" method="post" enctype="multipart/form-data" name="update-leisure" id="update-leisure" class="">
				<div class="form-group col-md-12">
				<textarea class="form-control" id="" name="leisure" cols="" rows="6"><?php echo $leisure ?></textarea>
					<hr />
					<button type="submit" class="btn btn-primary" id="leisure-submit">Update Entry</button>
				</div>

			</form>
		</div>

	</div>

</div>


<?php echo $this->load->view('career/inc/footer'); ?>

<script>
	$( document ).ready(function() {



		$(function() {
			$('#update-leisure').on('submit', function (e) {

				e.preventDefault();

				$('#leisure-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');


				$.ajax({
					type: 'post',
					url: '<?php echo site_url('/')?>vacancy/update_leisure/',
					data: $('#update-leisure').serialize(),
					success: function (data) {

						$('#leisure-submit').html('Update Entry');

						if(data == 'Success') {
							location.reload();
						}
					}
				});



			});
		});


	});


</script>

</body>
</html>