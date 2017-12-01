<?php

$rateF = 'none';
$rateR = 'block';
if($rate_active == 'active'){

	$rateF = 'block';
	$rateR = 'none';
}

?>

<div class="navbar">
	<div class="navbar-inner">

		<ul class="nav">
			<!--<li><a href="#"><i class="icon-comment"></i></a></li>-->
            <li style="list-style: none; float:left;" ><a href="javascript:minimizeme('max')" ><img src="<?php echo base_url('/');?>img/icons/affiliation.png" style="margin-left:-10px;padding:0;height:auto;width:150px;"/></a></li>
			<li style="list-style: none; padding-left:10px"><a href="javascript:toggle_widget('rating')" id="widget_toggle_btn" style="margin-left:-20px">Rating &amp; Reviews</a></li>
			

		</ul>
		<a href="javascript:minimizeme('max')"  class="widget_btn_min" style="float:right;margin:0 "></a>
	</div>
</div>
<div class="container-fluid" id="plugin_myna_reviews" style="display:<?php echo $rateR;?>;padding:10px;margin-top:-20px;padding:10px 0px 10px 10px;margin:-20px 0px 0px 0px; overflow:hidden">
	<div class="row-fluid">

		<div class="span12 cont_height_d" id="plugin_myna_content" style="overflow-y: scroll">

			<?php echo $reviews;?>
		</div>
	</div>
</div>
<div class="container-fluid" id="plugin_myna_rating" style="display:<?php echo $rateF;?>;padding:10px 0px 10px 10px;margin:-20px 0px 0px 0px;overflow:hidden">
	<div class="row-fluid">

		<div class="span12 cont_height_d" id="plugin_myna_content_rate" style="height:300px; overflow: scroll; ">

			<?php echo $rate;?>
		</div>
	</div>
</div>
<div class="navbar">
	<div class="navbar-inner">

		<ul class="nav" style="list-style: none">
			<!--<li><a href="#"><i class="icon-comment"></i></a></li>-->
			<li style="list-style: none;padding-left:10px"><a href="javascript:toggle_widget('reviews')"><i class="icon-comment"></i> Reviews</a></li>
			<li style="list-style: none;padding-left:10px"><a href="javascript:toggle_widget('rating')"><i class="icon-thumbs-up"></i> Rate</a></li>

		</ul>

	</div>
</div>
