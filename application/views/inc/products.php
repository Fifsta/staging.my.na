<?php

if($type == '3408') {
	$title = 'Properties';
	$section = 'properties';
	$link = 'buy/property';
}

if($type == '348') {
	$title = 'Cars, Bikes & Boats';
	$section = 'cars';
	$link = 'buy/car-bikes-and-boats';
}

?>
<section id="<?php echo $section; ?>">
	
	<div class="heading">
		<h2 data-icon="fa-bed"><a href="#"><strong><?php echo $title; ?></strong></a></h2>
		<p><?php echo $title ?> listings in Namibia</p>
		<ul class="options">
			<li><a href="#" data-icon="fa fa-edit text-dark">List my own</a></li>
			<li><a href="#" data-icon="fa fa-bullhorn text-dark">Alert me</a></li>
			<li><a href="<?php echo site_url('/').$link; ?>" data-icon="fa fa-chevron-right text-dark">More classifieds</a></li>
		</ul>
	</div>
	
	<div>
		<?php echo $this->my_model->get_items('product', $type); ?>
	</div>

	<a href="<?php echo site_url('/').$link; ?>" class="btn btn-dark pull-right" title="More <?php echo $title; ?>" rel="tooltip" ><i class="icon icon-plus icon-white"></i>View More <?php echo $title; ?></a>

</section>