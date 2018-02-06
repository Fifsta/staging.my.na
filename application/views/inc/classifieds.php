<section id="classifieds">
	<div class="heading" style="margin-bottom:10px">
		<h2 data-icon="fa-newspaper-o">Latest <strong>Classifieds</strong></h2>
		<p>Browse all latest classified listings here</p>
		<ul class="options">
			<li><a href="#" data-icon="fa fa-edit text-dark">List my own</a></li>
			<li><a href="#" data-icon="fa fa-bullhorn text-dark">Alert me</a></li>
			<li><a href="#" data-icon="fa fa-chevron-right text-dark">More classifieds</a></li>
		</ul>
	</div>
	
	<div id="classifieds_content" class=""></div>

	<a href="<?php echo site_url('/'); ?>classifieds/" class="btn btn-dark pull-right" title="More Classifieds" rel="tooltip"  style="margin-top:5px;"><i class="icon icon-plus icon-white"></i>View More Classifieds</a>
	
</section> 

<script>
	$(document).ready(function(){

		// LOAD CLASSIFIEDS
		$.ajax({
            url: '<?php echo site_url('/');?>classifieds/get_latest/',
            dataType: "json",
            type: "GET",
            success: function(data) {
				var pre = $("#classifieds_content");
                pre.removeClass('loading_img min400');
                pre.append(data.classifieds);

                initialise_owl();
            }
        });
	});	
</script>