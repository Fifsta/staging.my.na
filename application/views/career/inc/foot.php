<div class="container-fluid" style="position:relative">
<img src="<?php echo base_url('/'); ?>graphics/nav_shade_iv.png" style="width:100%; height:25px;" />
</div>
<div class="container-fluid" style="background:#E5E5E5;">
	<div class="container" style="margin-bottom:50px;">
		<div class="row-fluid" style="margin-top:30px; text-align:center">
		<h2>Our Sponsors</h2><hr />
			<?php echo $this->main_model->get_sponsor_images(); ?>
		</div>
	</div>
</div>