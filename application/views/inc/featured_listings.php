<section id="feat_list">

	<div class="heading">
		<h2 data-icon="fa-newspaper-o">Featured <strong>Listings</strong></h2>
		<p>Browse all featured product listings here.</p>

	</div>

    <div id="owl-prod">

    
    </div>
                     
</section>

<script>


	$('document').ready(function(){

		load_my_na_products();

		// INITIALIZE OWL
		$('#feat-carousel').owlCarousel({
		    loop:false,
		    lazyLoad: true,
		    navRewind:false,
		    margin:10,
		    nav: true,
		    navText : ["<button class='btn owl-prev-next-button previous'></button>","<button class='btn owl-prev-next-button next'></button>"],
		    responsiveClass:true,
		    responsive:{
		        0:{
		            items:1,
		            nav:true
		        },
		        600:{
		            items:1,
		            nav:true
		        },
		        1000:{
		            items:2,
		            nav:true,
		            loop:false
		        },

		        1600:{
		            items:3,
		            nav:true,
		            loop:false
		        }		        
		    }
		});		

	});


	function load_my_na_products(){

		var link = '<?php echo site_url('/');?>my_na/get_feature_products/Y/false/false/20/0/';
		$.getJSON( link, function( data ) {

			$('#owl-prod').html(data);
			initialise_feat_owl();

		});

	}

</script>