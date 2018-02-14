<section id="auctions">
	
	<div class="heading">
		<h2 data-icon="fa-gavel"><a href="#"><strong>Auctions</strong></a></h2>
		<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
		<ul class="options">
			<li><a href="#" data-icon="fa-edit">List my own</a></li>
			<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
		</ul>
	</div>

	<div>
		<?php echo $this->my_model->get_items('product', $type); ?>
	</div>

	<a href="" class="btn btn-dark pull-right" title="More Auction Items" rel="tooltip" ><i class="icon icon-plus icon-white"></i>View More Products</a>	
		
</section>