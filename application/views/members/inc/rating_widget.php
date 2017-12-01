<?php
$atts = array(
	'width'      => '800',
	'height'     => '600',
	'scrollbars' => 'yes',
	'status'     => 'yes',
	'resizable'  => 'yes',
	'screenx'    => '0',
	'screeny'    => '0',
	'class'      => 'btn',
	'title'      => 'Preview your personal widget',
	'rel'        => 'tooltip'
);
$atts2 = array(
	'width'      => '800',
	'height'     => '600',
	'scrollbars' => 'yes',
	'status'     => 'yes',
	'resizable'  => 'yes',
	'screenx'    => '0',
	'screeny'    => '0',
	'class'      => 'btn',
	'title'      => 'View your unique rating code',
	'rel'        => 'tooltip'
);
?>

<div class="well well-mini">
	<button type="button" class="close" data-dismiss="well" onclick="$(this).parent().hide();">&times;</button>
	<h4>Official Namibian Rating Widget! <img src="<?php echo base_url('/');?>img/icons/fnb_irate.png" style="width:90px" class="pull-right" /></h4>

	<p class="muted">Get more valuable feedback and allow your clients to rate and review your business service or product online.
	</p>
	<strong>Option: 1</strong>
	<textarea class="span12 code"  onclick="this.focus();this.select()"><script src="<?php echo base_url('/')?>js/rating/widget.js?v1.1&bus_id=<?php echo $bus_id;?>&embed=plugin&external=true" id="myna"></script></textarea>
	<p><small small class="muted">Copy the code above and insert it into your website to include your personal rating widget.</small></p>
	<strong>Option: 2</strong>
	<textarea class="span12 code"  onclick="this.focus();this.select()"><iframe src="https://www.my.na/rate/rateme/<?php echo $bus_id;?>/embed/external" allowtransparency="true" frameborder="0" style="width:100%; min-height:600px;"></iframe></textarea>
	<small class="muted">This option can be embedded anywhere in any website. Simply copy the code and paste it into the HTML of the page you want.</small>
	<p><small class="muted">
			Not computer savy? Simply copy the code/text above and forward it to your web designer or company.</small></p>
	<p>
		<?php echo anchor_popup(site_url('/').'rate/preview/'.$bus_id, '<span class="notification-small btn-success">New!</span><i class="icon-search"></i> Preview Widget', $atts);?>
		<?php echo anchor_popup(site_url('/').'my_images/qr/business/'.$bus_id, '<i class="icon-qrcode"></i> Get Your Code', $atts2);?>
		<a href="javascript:void(0)" onClick="copyToClipboard()" class="btn">Unique Rating Link</a>
		<img src="<?php echo base_url('/');?>img/icons/affiliation.png" class="pull-right" title="Proudly Partnered With" rel="tooltip"/>
	</p>


</div>