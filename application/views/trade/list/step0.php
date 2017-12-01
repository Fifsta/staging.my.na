 <?php 
 	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}

    $auction_str = '&auction='.$auction;
    if(!isset($auction)){

        $auction_str = '';
        $auction = 'false';
    }

 ?>
<div class="text-center">

    <a href="#" class="btn btn-inverse disabled step1" style="margin:5px"> 1 Select Category <i class="icon-chevron-right icon-white"></i></a> 
	<a href="#" class="btn btn-inverse disabled step2" style="margin:5px"> 2 Details <i class="icon-chevron-right icon-white"></i></a>
    <a href="#" class="btn btn-inverse disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-chevron-right icon-white"></i></a>
	<a href="#" class="btn btn-inverse disabled step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
    <a href="#" class="btn btn-inverse disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>

</div>
<div class="clearfix">&nbsp;</div>
<div class="row-fluid text-center">
	<div class="span1" >
        		
	</div>
    <div class="span2 white_box" >
          <div class=" padding10"><img src="<?php echo base_url('/');?>img/buttons/general_item.jpg" class="general"/>
                  <p>
                  
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List any item you want to sell. eg: electronics, garments, TV's</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('general');" class="btn btn-block btn-inverse"> List Now</a></div>
                  </p>
          </div>			
	</div>
	<div class="span2 white_box " >
          <div class=" padding10"><img src="<?php echo base_url('/');?>img/buttons/car_boat_bike.jpg" class="motor"/>
                  <p>
  
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List any motor powered device like a car bike or boat</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('motor');" class="btn btn-block btn-inverse"> List Now</a></div>
                  </p>
          </div>			
	</div>
	<div class="span2 white_box " >
          <div class=" padding10"><img src="<?php echo base_url('/');?>img/buttons/property.jpg" class="property"/>
                  <p>

                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List a Property for sale or for rent. Commercial or residential</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('property');" class="btn btn-block btn-inverse"> List now</a></div>
                  </p>
          </div>			
	</div>

	<div class="span2" >
          <div class=" white_box  padding10"><img src="<?php echo base_url('/');?>img/buttons/business_service.jpg" class="service"/>
                  <p>
       
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List any Business Service you have on offer</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('service');" class="btn btn-block btn-inverse"> List Now</a></div>
                  </p>
          </div>			
	</div>
    <div class="span2 white_box " >
        <div class=" padding10"><img src="<?php echo base_url('/');?>img/buttons/job.jpg" class="job"/>
            <p>
            <div class="clearfix" style="height:5px;"></div>
            <div style="font-size:13px;margin-bottom:10px;">List a Job position available, Careers &amp; Vacancies</div>
            <div><a href="javascript:void(0)" onclick="go_step_1('job');" class="btn btn-block btn-inverse disabled"> Coming Soon</a></div>
            </p>
        </div>
    </div>
	<div class="span1" >
        		
	</div>
    
</div>
<div class="row-fluid  text-center"> 




</div>

<div class="clearfix" style="height:200px;"></div>
<script data-cfasync="false" type="text/javascript">

<?php if($type != ''){ ?>

    $(document).ready(function(){

        $('.<?php echo $type;?>').addClass('animated infinite pulse');

    });

<?php } ?>


function go_step_1(str){
	
	var cont = $('#admin_content');
	cont.addClass('slideLeft');
	if(str == 'general'){
		
		$.get('<?php echo site_url('/'). 'sell/step1/'.$bus_id.'/?type=general'.$auction_str;?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  
		});
		
	}else if(str == 'motor'){
		
		$.get('<?php echo site_url('/'). 'sell/step1/'.$bus_id.'/?type=motor'.$auction_str;?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  load_ajax_product_cat(348, 'Car bikes & boats  ', 0, '_' , 0, '_' , 0, '_', <?php echo $bus_id;?>, 'motor');
			  
		});
		
		
		
	}else if(str == 'property'){
		
		$.get('<?php echo site_url('/'). 'sell/step1/'.$bus_id.'/?type=property'.$auction_str;?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  load_ajax_product_cat(3408, 'Real Estate', 0, '_' , 0, '_' , 0, '_',<?php echo $bus_id;?>, 'property');
			  
		});
		
	}else if(str == 'service'){
        $.get('<?php echo site_url('/'). 'sell/step1/'.$bus_id.'/?type=service'.$auction_str;?>', function(data) {
            cont.removeClass('loading_img').html(data);

        });
	
	}else if(str == 'job'){	
		
		
	}



}



</script>
