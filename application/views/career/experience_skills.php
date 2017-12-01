<?php echo $this->load->view('career/inc/header'); ?>

<style type="text/css">
	.typeahead, .tt-query, .tt-hint {
		background:#FFF;
		width: 400px;
	}

	.typeahead:focus {
		border: 2px solid #0097CF;
	}
	.tt-query {
		box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
	}
	.tt-hint {
		color: #fff;
	}
	.tt-dropdown-menu {
		background-color: #FFFFFF;
		border: 1px solid rgba(0, 0, 0, 0.2);
		border-radius: 2px;
		margin-top: 12px;
		padding: 8px 0;
		width: 422px;
		z-index:9999;
	}
	.tt-suggestion {
		font-size: 16px;
		line-height: 16px;
		padding: 3px 20px;
	}
	.tt-suggestion.tt-is-under-cursor {
		background-color: #0097CF;
		color: #FFFFFF;
	}
	.tt-suggestion p {
		margin: 0;
	}
</style>

<script type='text/javascript' src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<div class="container-fluid" style="margin:0px; padding:0px">


	<?php //echo $this->load->view('inc/progress'); ?>

	<div class="col-sm-3 col-md-3 sidebar" style="padding-left:0px">
		<?php echo $this->load->view('career/inc/nav_main'); ?>
	</div>
	<div class="col-md-9 col-sm-9">
		<div class="row-fluid hidden-sm hidden-xs"><h1>My Profile - Experience & Skills</h1></div>
		<hr />
		<div class="row-fluid">
			<h4>My Disciplines</h4>
			<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myDisc" style="margin-bottom:5px">Add Discipline</button>
			<div id="app-dis">
				<?php $this->vacancy_model->get_app_disciplines(); ?>
			</div>
		</div>
		<hr />
		<div class="row-fluid">
			<h4>My Experience Categories</h4>
			<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myCat" style="margin-bottom:5px">Add Category</button>
			<div id="app-cats">
				<?php $this->vacancy_model->get_app_categories(); ?>
			</div>
		</div>
		<hr />
		<div class="row-fluid">
			<h4>My Skills</h4>
			<form action="<?php echo site_url('/')?>vacancy/add_skill/" method="post" enctype="multipart/form-data" name="add-skill" id="add-skill" >
				<input type="text" name="skill" id="skill" class="typeahead form-control">
				<button type="submit" class="btn btn-primary btn-sm" data-toggle="modal" id="skill-submit">Add Skill</button>
			</form>
			<div id="app-skills" style="margin-top:10px;">
				<?php $this->vacancy_model->get_app_skills(); ?>
			</div>
		</div>
	</div>

</div>


	<!-- Modal -->
	<div class="modal fade" id="myDisc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Disciplines</h4>
				</div>

				<div class="modal-body">

					<form action="<?php echo site_url('/')?>main/add_app_dis/" method="post" enctype="multipart/form-data" name="disciplines" id="disciplines" >

						<div class="control-group">
							<label class="control-label" for="discipline">Select Discipline</label>
							<div class="controls">
								<select name="discipline" id="discipline" class="form-control" style="margin-bottom:5px;">
									<option value="" class="form-control">Select a Discipline</option>
									<?php echo $this->vacancy_model->get_discipline_select(); ?>
								</select>
							</div>
						</div>


						<div class="control-group" id="exp">
							<label class="control-label" for="experience">Select Years of Experience</label>
							<div class="controls">
								<select name="experience" class="form-control">
									<option value="">Choose a Option</option>
									<option value="3 Months">3 Months</option>
									<option value="1 Year">1 Year</option>
									<option value="2 Years">2 Years</option>
									<option value="3 Years">3 Years</option>
									<option value="5 Years">5 Years</option>
									<option value="7 Years">7 Years</option>
									<option value="8 Years">8 Years</option>
									<option value="10 Years">10 Years</option>
								</select>
							</div>
						</div>

						<button type="submit" class="btn btn-primary" id="dis-submit" style="margin-top:10px">Add Discipline</button>
					</form>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>

			</div>
		</div>
	</div>




	<!-- Modal -->
	<div class="modal fade" id="myCat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Experience Categories</h4>
				</div>
				<div class="modal-body">
					<form action="<?php echo site_url('/')?>vacancy/add_app_cat/" method="post" enctype="multipart/form-data" name="categories" id="categories" >
						<div class="control-group">
							<label class="control-label" for="pub_date">Select Main Category</label>
							<div class="controls">
								<select name="main_cats" id="main-cats" class="form-control" style="margin-bottom:5px;">
									<option value="0" class="form-control">Select a Main Category</option>
									<?php echo $this->vacancy_model->get_main_categories_select(); ?>
								</select>
							</div>
						</div>

						<div class="control-group" id="sub-cats-div" style="display:none">
							<label class="control-label" for="pub_date">Select Sub Category</label>
							<div class="controls" id="sub-cats-body">
								<select name="sub_cats" id="sub-cats" class="form-control" style="margin-bottom:5px;">
								</select>
							</div>
						</div>

						<div class="control-group" id="sub-sub-cats-div" style="display:none">
							<label class="control-label" for="pub_date">Select Sub Sub Category</label>
							<div class="controls" id="sub-cats-body">
								<select name="sub_sub_cats" id="sub-sub-cats" class="form-control" style="margin-bottom:5px;">
								</select>
							</div>
						</div>

						<div class="control-group" id="exp">
							<label class="control-label" for="experience">Select Years of Experience</label>
							<div class="controls">
								<select name="experience" class="form-control">
									<option value="">Choose a Option</option>
									<option value="3 Months">3 Months</option>
									<option value="1 Year">1 Year</option>
									<option value="2 Years">2 Years</option>
									<option value="3 Years">3 Years</option>
									<option value="5 Years">5 Years</option>
									<option value="7 Years">7 Years</option>
									<option value="8 Years">8 Years</option>
									<option value="10 Years">10 Years</option>
								</select>
							</div>
						</div>


						<div id="result_msg"></div>
						<button type="submit" class="btn btn-primary" id="cat-submit" style="margin-top:10px">Add Category</button>
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
	<script src="<?php echo base_url('/');?>js/bootstrap-typeahead.min.js"></script>

	<script>

		$( document ).ready(function() {


			$('.typeahead').typeahead({
				name: 'skills',
				local: [<?php echo $this->vacancy_model->get_skills(); ?>]
			});

			$(function() {
				$('#add-skill').on('submit', function (e) {

					e.preventDefault();

					$('#skill-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');

					if($('#skill').val().length == 0){

						$('#skill').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Skill Required", content:"Please supply Skill"});
						$('#skill').popover('show');
						$('#skill').focus();

						var form_val = false;


					}  else {

						$('#skill').popover('hide');
						var form_val = true;

					}

					if(form_val == true) {

						$.ajax({
							type: 'post',
							url: '<?php echo site_url('/')?>vacancy/add_skill/',
							data: $('#add-skill').serialize(),
							success: function (data) {

								$('#skill-submit').html('Add Skill');

								if(data == 'Success') {

									reload_skills();

								}
							}
						});

					} else {

						$('#skill-submit').html('Add Skill');

					}

				});
			});




			$(function() {
				$('#disciplines').on('submit', function (e) {

					e.preventDefault();

					$('#dis-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');


					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_app_dis/',
						data: $('#disciplines').serialize(),
						success: function (data) {

							$('#dis-submit').html('Add Discipline');
							$('#result_msg4').html(data);

							if(data == 'Success') {

								$('#myDisc').modal('toggle');
								reload_app_dis();


							} else {



							}

						}
					});

				});
			});





			$(function() {
				$('#categories').on('submit', function (e) {

					e.preventDefault();

					$('#cat-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');


					$.ajax({
						type: 'post',
						url: '<?php echo site_url('/')?>vacancy/add_app_cat/',
						data: $('#categories').serialize(),
						success: function (data) {

							$('#cat-submit').html('Add Category');
							$('#result_msg').html(data);

							if(data == 'Success') {

								$('#myCat').modal('toggle');
								$('#main-cats').prop('selectedIndex',0);
								$('#sub-cats').prop('selectedIndex',0);
								$('#sub-sub-cats').prop('selectedIndex',0);

								$('#sub-cats-div').hide();
								$('#sub-sub-cats-div').hide();
								$('#result_msg').hide();

								reload_app_cats();


							} else {

								$('#myCat').modal('toggle');
								$('#main-cats').prop('selectedIndex',0);
								$('#sub-cats').prop('selectedIndex',0);
								$('#sub-sub-cats').prop('selectedIndex',0);

								$('#sub-cats-div').hide();
								$('#sub-sub-cats-div').hide();
								$('#result_msg').hide();

								reload_app_cats();

							}

						}
					});

				});
			});


		});


		$(document).ready(function(){

			$("#main-cats").change(function() {

				$('#sub-cats').prop('selectedIndex',0);
				$('#sub-sub-cats').prop('selectedIndex',0);
				$("#sub-cats-div").hide("slow");
				$("#sub-sub-cats-div").hide("slow");

				if($(this).val() != '0') {

					$.ajax({
						type: 'get',
						url: '<?php echo site_url('/'); ?>vacancy/get_sub_category_select/'+$(this).val(),
						success: function (data) {

							$('#sub-cats-div').show('slow');
							$('#sub-cats').html(data);

						}
					});

				} else {

					$('#sub-cats').prop('selectedIndex',0);
					$('#sub-sub-cats').prop('selectedIndex',0);
					$("#sub-cats-div").hide("slow");
					$("#sub-sub-cats-div").hide("slow");

				}

			});

			$("#sub-cats").change(function() {

				if($(this).val() != '0') {

					$.ajax({
						type: 'get',
						url: '<?php echo site_url('/'); ?>vacancy/get_sub_sub_category_select/'+$(this).val(),
						success: function (data) {

							$('#sub-sub-cats-div').show('slow');
							$('#sub-sub-cats').html(data);

						}
					});

				} else {


					$('#sub-sub-cats').prop('selectedIndex',0);
					$("#sub-sub-cats-div").hide("slow");

				}

			});


		});

		function remove_skill(id) {

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/delete_skill/'+id,
				success: function (data) {

					reload_skills();

				}
			});

		};


		function reload_skills() {

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/reload_skills/',
				success: function (data) {

					$('#app-skills').html(data);
					var form = document.getElementById("add-skill");
					form.reset();
				}
			});

		}



		function reload_app_cats() {

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/reload_app_cat/',
				success: function (data) {

					$('#app-cats').html(data);

				}
			});

		}

		function remove_app_cat(id) {

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/remove_app_cat/'+id,
				success: function (data) {

					$('#app-cats').html(data);
					reload_app_cats();

				}
			});
		}


		function reload_app_dis() {

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/reload_app_dis/',
				success: function (data) {

					$('#app-dis').html(data);

				}
			});

		}

		function remove_app_dis(id) {

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/'); ?>vacancy/remove_app_dis/'+id,
				success: function (data) {

					$('#app-dis').html(data);
					reload_app_dis();

				}
			});
		}


	</script>

	</body>
	</html>