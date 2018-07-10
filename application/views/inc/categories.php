<section id="categories">


	<div class="heading">
		<h2 data-icon="fa-briefcase"><strong>Business</strong> Directory</h2>
		<p></p>
		<ul class="options">
            <!--<button class="btn btn-dark pull-right t-map" id="btn_map_view" style="" rel="tooltip" title="" data-original-title="Show Map View">
              <i class="fa fa-map-marker"></i> MAP VIEW
            </button>-->			
		</ul>
	</div>

	<div class="row" style="margin-top:20px" id="cat-box">

		<?php $this->my_na_model->home_categories('dark'); ?>

	</div>
	<button class="btn btn-default btn-block cat-slide"><i class="fa fa-angle-double-down text-dark"></i> load more categories <i class="fa fa-angle-double-down text-dark"></i></button>
</section>