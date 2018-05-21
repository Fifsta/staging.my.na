<section id="auctions">
	
	<div class="heading">
		<h2 data-icon="fa-gavel"><a href="#"><strong>Auctions</strong></a></h2>
		<p></p>
		<ul class="options">
			<!--<li><a href="#" data-icon="fa-edit">List my own</a></li>
			<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>-->
		</ul>
	</div>

	<div id="auctions_slide">
		
	</div>

</section>

<script>
	$(document).ready(function(){

		// LOAD CLASSIFIEDS
		$.ajax({
            url: '<?php echo site_url('/');?>my_na/load_auctions_home/',
            dataType: "json",
            type: "GET",
            success: function(data) {
				var pre = $("#auctions_slide");
                pre.removeClass('loading_img min400');
                pre.append(data.auctions);
                //pre.html(data.auctions);

                initialise_owl();
            }
        });
	});	
</script> 