<section id="bus_list">

	<div class="heading">
		<h2 data-icon="fa-newspaper-o" itemprop="description">Featured <strong>Businesses</strong></h2>
		<p>Browse all listed featured business entries here.</p>
		<ul class="options">
			<li><a href="https://nmh.my.na/main/subscribe/?type=featured_business" target="_blank"><i class="fa fa-edit text-dark"></i> Feature my Business</a></li>
		</ul>
	</div> 

    <div id="owl-bus">

    
    </div>
                     
</section>

<script type="text/javascript">

	$('document').ready(function(){

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

		load_my_na_business();

	});


	function load_my_na_business(){

		var link = '<?php echo site_url('/');?>my_na/get_feature_business/Y/false/false/20/0/';
		$.getJSON( link, function( data ) {

			$('#owl-bus').html(data);
			initialise_feat_owl();

		});

	}




</script>