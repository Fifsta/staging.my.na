<section id="news">

	<div class="heading">
		<h2 data-icon="fa-newspaper-o">Todays <strong>Headlines</strong></h2>
		<ul class="options">
			<li><a href="#" data-icon="fa fa-edit text-dark">List my own</a></li>
			<li><a href="#" data-icon="fa fa-bullhorn text-dark">Alert me</a></li>
		</ul>
	</div>
    
    <div>
		<?php  echo $this->my_model->get_items('news'); ?>
	</div>
                     
</section>