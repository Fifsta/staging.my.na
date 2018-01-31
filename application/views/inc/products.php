<?php

if($type == '3408') {
	$title = 'Properties';
	$section = 'properties';
}

if($type == '348') {
	$title = 'Cars, Bikes & Boats';
	$section = 'cars';
}

?>
<section id="<?php echo $section; ?>">
	
	<div class="heading">
		<h2 data-icon="fa-bed"><a href="#"><strong><?php echo $title; ?></strong></a></h2>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<ul class="options">
			<li><a href="#" data-icon="fa-edit">List my own</a></li>
			<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
		</ul>
	</div>
	
	<div>
		<?php echo $this->my_model->get_items('product', $type); ?>
	</div>

</section>