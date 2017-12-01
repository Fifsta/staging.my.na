 <?php 
 	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}
 
 ?>
<div class="well well-mini text-center">
	<h3>List an Item <?php echo $str;?></h3>
    <a href="#" class="btn btn-inverse disabled step1" style="margin:5px"> 1 Select Category <i class="icon-chevron-right icon-white"></i></a> 
	<a href="#" class="btn btn-inverse disabled step2" style="margin:5px"> 2 Details <i class="icon-chevron-right icon-white"></i></a>
    <a href="#" class="btn btn-inverse disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-chevron-right icon-white"></i></a>
	<a href="#" class="btn btn-inverse disabled step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
    <a href="#" class="btn btn-inverse disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>

</div>

<div class="row-fluid">
	<div class="span4 white_box" >
          <div><img src="<?php echo base_url('/');?>img/buttons/general_item.jpg" />
                  <p>
                  
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List any item you want to sell. eg: electronics, garments, TV's</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('general');" class="btn btn-block btn-inverse"> List Now</a></div>
                  </p>
          </div>			
	</div>
	<div class="span4 white_box" >
          <div><img src="<?php echo base_url('/');?>img/buttons/car_boat_bike.jpg" />
                  <p>
  
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List any motor powered device like a car bike or boat</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('motor');" class="btn btn-block btn-inverse"> List Now</a></div>
                  </p>
          </div>			
	</div>
	<div class="span4 white_box" >
          <div><img src="<?php echo base_url('/');?>img/buttons/property.jpg" />
                  <p>

                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List a Property for sale or for rent. Commercial or residential</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('property');" class="btn btn-block btn-inverse"> List now</a></div>
                  </p>
          </div>			
	</div>
</div>
<div class="row-fluid">    
	<div class="span4 white_box" >
          <div><img src="<?php echo base_url('/');?>img/buttons/business_service.jpg" />
                  <p>
       
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List any Business Service</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('service');" class="btn btn-block btn-inverse disabled"> Coming Soon</a></div>
                  </p>
          </div>			
	</div>
	<div class="span4 white_box" >
          <div><img src="<?php echo base_url('/');?>img/buttons/job.jpg" />
                  <p>
                  <div class="clearfix" style="height:5px;"></div>
                  <div style="font-size:13px;margin-bottom:10px;">List a Job position available</div>
                  <div><a href="javascript:void(0)" onclick="go_step_1('job');" class="btn btn-block btn-inverse disabled"> Coming Soon</a></div>
                  </p>
          </div>			
	</div>
</div>

<div class="clearfix" style="height:200px;"></div>
<script type="text/javascript">

function go_step_1(str){
	
	var cont = $('#admin_content');
	cont.addClass('loading_img');
	if(str == 'general'){
		
		$.get('<?php echo site_url('/'). 'trade/list_general_step1/'.$bus_id.'/';?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  
		});
		
	}else if(str == 'motor'){
		
		$.get('<?php echo site_url('/'). 'trade/list_general_step1/'.$bus_id.'/';?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  load_ajax_product_cat(348, 'Car bikes & boats  ', 0, '_' , 0, '_' , 0, '_');
			  
		});
		
		
		
	}else if(str == 'property'){
		
		$.get('<?php echo site_url('/'). 'trade/list_general_step1/'.$bus_id.'/';?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  load_ajax_product_cat(3408, 'Real Estate', 0, '_' , 0, '_' , 0, '_');
			  
		});
		
	}else if(str == 'service'){
	
	
	}else if(str == 'job'){	
		
		
	}
	
}



</script>
