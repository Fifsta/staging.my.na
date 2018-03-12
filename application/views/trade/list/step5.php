<?php
//+++++++++++++++++++++++++++++++++
//STEP 5 Confirm
//+++++++++++++++++++++++++++++++++

	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}

	$fb_btn = '<a href="javascript:void(0)" onclick="publish_facebook_page()" id="pub_fb_btn" class="btn btn-success " rel="tooltip" title="Publish this item to the My Namibia Facebook Page" style="text-shadow:0;margin-right:5px"><i class="icon-share icon-white"></i> Share on Facebook</a>';
	if($fb_post_id != 0){

		$l1 = str_replace("_", "/posts/", $fb_post_id);
		$fb_btn = '<a href="https://www.facebook.com/'.$l1.'/" target="_blank" class="btn btn-success " rel="tooltip" title="View the link on the My Namibia Facebook Page" style="text-shadow:0;margin-right:5px"><i class="icon-search icon-white"></i> View on Facebook</a>';
	}

?>
<div id="anchor_me"></div>

<div class="col-md-12">
    <div class="heading">
        <h2 data-icon="fa-list">Publish the <strong>Product</strong></h2>
        <ul class="options">

        </ul>
    </div>
</div>

<div class="col-md-12">
    <div class="card">
        <div class="card-body">
	        <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="icon-ok icon-white"></i></a> 
	        <a href="<?php echo site_url('/').'sell/update_product/'.$product_id.'/';?>" class="btn btn-warning disabled  step2" style="margin:5px"> 2 Details <i class="icon-ok icon-white"></i></a>
	        <a href="<?php echo site_url('/').'sell/step3/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-warning disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-ok icon-white"></i></a>
	        <a href="<?php echo site_url('/').'sell/step4/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-warning disabled step4" style="margin:5px"> 4 Extras <i class="icon-ok icon-white"></i></a>
	        <a href="<?php echo site_url('/').'sell/step5/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-success btn-large step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
	        <hr>

		<?php if($is_active != 'Y'){ ?>
            <div class="alert alert-block">
                <h2>Publish your item</h2>
                Please publish your item so we can approve it and make it live.</div>
            <div>
           <a href="javascript:void(0)" onclick="publish()" class="btn btn-success pull-right">Publish <i class="icon-chevron-right icon-white"></i></a>
        <?php }else{ ?>
	        <iframe class="loading_img" style="width:100%; min-height:400px" id="advert_content"></iframe>
            <div class="alert alert-block">

	            <h2>Item is Live</h2>
                <p>The product is live and showing on the website. You can automatically publish the item to the My Namibia facebook page to get that extra exposure.</p>
	            <div class="clearfix">&nbsp;</div>
	            <?php echo $fb_btn;?>
	            <div class="btn btn-warning fb-share-button" data-href="<?php echo site_url('/').'product/'.$product_id; ?>/" data-layout="button_count"></div>
	            <a href="<?php echo site_url('/').'product/'.$product_id;?>/" class="btn btn-dark clearfix"  target="_blank">Preview <?php echo $title;?></a>

            </div>

           <div>
       <?php }?>

	       <a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/';?>" id="back_to_all" class="btn btn-dark pull-right" style="margin-right:5px">All Products</a>

           <a href="javascript:void(0)" onclick="back_to_4()" id="back_to_4" class="btn btn-warning pull-right" style="margin-right:5px">Back</a>

        </div>
    </div>    
</div>

<script data-cfasync="false" type="text/javascript">

	$(document).ready(function(e) {
		//window.scrollTo(0,$('#anchor_me').offset().top);
		var ad = $('#advert_content');
		ad.removeClass('loading_img').attr("src", '<?php echo site_url('/'). 'adverts/buy_sell/';?>');


	});

	function publish(){

			var cont = $('#admin_content');
			  $.get('<?php echo site_url('/'). 'trade/publish_item/'.$product_id.'/'.$bus_id;?>', function(data) {
					cont.removeClass('slideLeft').html(data);

			  });

	}


	function publish_facebook_page(){


		//frm.submit();
		$('#pub_fb_btn').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'fb/post_product_to_my_page/'.$product_id.'/';?>',
			success: function (data) {

				$('#result_msg').html(data);
				$('#pub_fb_btn').html('<i class="icon-share icon-search"></i> View on Facebook').attr("href", data);

			}
		});

	}

<?php
   /**
  ++++++++++++++++++++++++++++++++++++++++++++
  //BACK
  ++++++++++++++++++++++++++++++++++++++++++++	
   */
   ?> 
  
  function back_to_4(){
	  
		  var cont = $('#admin_content').addClass('slideLeft'), btn = $('#back_to_4');
		  btn.html('Working...');
		  $.get('<?php echo site_url('/'). 'sell/step4/'.$product_id.'/'.$bus_id;?>', function(data) {
				cont.removeClass('slideLeft').html(data);
				btn.html('<i class="icon-chevron-left icon-white"></i> Back');
		  });
	  
  }
</script>
<script src="<?php echo base_url('/');?>js/custom/fb.js"></script>

