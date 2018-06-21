<section id="bus_list">

	<div class="heading">
		<h2 data-icon="fa-newspaper-o">Featured <strong>Businesses</strong></h2>
		<p>Browse all listed featured business entries here.</p>
		<ul class="options">
			<li><a href="#" data-icon="fa-edit">Feature my Business</a></li>
		</ul>
	</div>

    <div id="owl-bus">

    
    </div>
                     
</section>

<script>

	$('document').ready(function(){

		load_my_na_business();

	});


	function load_my_na_business(){

		var link = '<?php echo site_url('/');?>my_na/get_feature_business/Y/false/false/20/0/';
		$.getJSON( link, function( data ) {

			$('#owl-bus').html(data);
			initialise_owl();

		});

	}

</script>