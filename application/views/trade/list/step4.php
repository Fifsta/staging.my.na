<?php
	//+++++++++++++++++++++++++++++++++
	//STEP 4 Extras
	//+++++++++++++++++++++++++++++++++

	$str = '';
	if (isset($bus_id) && $bus_id != 0) {

	    $str = ' for Business';

	    $all_link = site_url('/') . 'members/business/' . $bus_id . '/';

	} else {

	    $all_link = site_url('/') . 'members/my_products/';

	}

?>
<div id="anchor_me"></div>

<div class="spacer"></div>

<div class="heading">
    <h2 data-icon="fa-list">Select <strong>Product Extras</strong></h2>
    <ul class="options">

    </ul>
</div>
<br>

<div class="card">
    <div class="card-body">
        <a href="#" class="btn btn-warning disabled step1" style="margin:5px"> 1 Select Category <i class="fa fa-check text-dark"></i></a> 
        <a href="<?php echo site_url('/').'sell/update_product/'.$product_id.'/';?>" class="btn btn-warning disabled  step2" style="margin:5px"> 2 Details <i class="fa fa-check text-dark"></i></a>
        <a href="<?php echo site_url('/').'sell/step3/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-warning disabled step3" style="margin:5px"> 3 Attach Photos <i class="fa fa-check text-dark"></i></a>
        <a href="<?php echo site_url('/').'sell/step4/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-success btn-large step4" style="margin:5px"> 4 Extras <i class="fa fa-chevron-right text-light"></i></a>
        <a href="<?php echo site_url('/').'sell/step5/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-dark disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="fa fa-chevron-right text-light"></i></a>
        <hr>

	    <?php 
	    //IF EXTRAS 
	    if($has_extras){
	    	
	    	$data['all_link'] = $all_link;
	        $this->load->view($group, $data); 
	 
	    //NO EXTRAS
	    }else{

	    ?>

	        <div class="alert">
	            <h4>No extras available for the selected category</h4>
	            There are no extras available to set for the selected category. Please make sure the product description describes the product to its fullest
	        </div>
	        <div>
	           <a href="javascript:void(0)" onclick="proceed_to_5()" id="proceed_to_5" class="btn btn-success btn-lg pull-right">Next <i class="fa fa-chevron-right text-light"></i></a>
	           <a href="<?php echo $all_link; ?>#Latest" id="back_to_all" class="btn btn-lg btn-dark pull-right" style="margin-right:5px">All Products</a>
	           <a href="javascript:void(0)"onclick="back_to_3()" id="back_to_3" class="btn btn-lg btn-warning pull-right" style="margin-right:5px"><i class="fa fa-chevron-left text-dark"></i> Back</a>
	       	   <div class="clearfix">&nbsp;</div>	
	        </div>
        
    	<?php } ?>

    </div>
</div>
<div class="spacer"></div>

<script data-cfasync="false" type="text/javascript">
	
	$(document).ready(function(e) {
		
		$('#add_extras_btn').bind('click', function(e){ 
			
			e.preventDefault();
			var cont = $('#admin_content').addClass('slideLeft'), frm = $('#item-add'), btn = $(this);
			btn.html('Working...');
			//cont.addClass('loading_img'); 
			$.ajax({
				type: 'post',
				cache: false,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'trade/add_extras';?>' ,
				success: function (data) {
					    btn.html('Update Item <i class="icon-chevron-right icon-white"></i>');
						cont.removeClass('slideLeft'); 
						cont.html(data);
						proceed_to_5();
						
				}
			});
		});				
    });

    
	function proceed_to_5(){

		var cont = $('#admin_content').addClass('slideLeft');
		$.get('<?php echo site_url('/'). 'sell/step5/'.$product_id.'/'. $bus_id;?>', function(data) {
			cont.removeClass('slideLeft').html(data);
		});

	}


	function back_to_3(){

		var cont = $('#admin_content').addClass('slideLeft'), btn = $('#back_to_3');
		btn.html('Working...');
		$.get('<?php echo site_url('/'). 'sell/step3/'.$product_id .'/'. $bus_id ;?>', function(data) {
			cont.removeClass('slideLeft').html(data);
			btn.html('<i class="icon-chevron-left icon-white"></i> Back');
		});

	}

</script>
