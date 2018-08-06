<section id="auctions">
	
	<div class="heading">
		<h2 data-icon="fa-gavel"><a href="#"><strong>Auctions</strong></a></h2>
		<p></p>
		<ul class="options">
			<li><a href="<?php echo site_url('/'); ?>sell/index/o/auction" data-icon="fa fa-edit text-dark">List my own</a></li>
			<li><a href="<?php echo site_url('/'); ?>trade/auctions/" data-icon="fa fa-chevron-right text-dark">All auctions</a></li>
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