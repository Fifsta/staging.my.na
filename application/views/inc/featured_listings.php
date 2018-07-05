<section id="feat_list">

	<div class="heading">
		<h2 data-icon="fa-newspaper-o">Featured <strong>Listings</strong></h2>
		<p>Browse all featured product listings here.</p>

	</div>

    <div id="owl-prod">

    
    </div>
                     
</section>

<script type="text/javascript">


$('document').ready(function(){

	load_my_na_products();

});


function load_my_na_products(){

	var link = '<?php echo site_url('/');?>my_na/get_feature_products/Y/false/false/20/0/';
	$.getJSON( link, function( data ) {

		$('#owl-prod').html(data);
		initialise_prod_owl();

	});

}


</script>