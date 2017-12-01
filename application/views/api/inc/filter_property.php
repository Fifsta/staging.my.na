  <?php 
 //+++++++++++++++++
 //LOAD PROPERTY FILTER
 //+++++++++++++++++
 ?>

<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<form class="form-inline" name="search" id="search_frm" action="<?php echo site_url('/');?>trade/search" method="post" enctype="multipart/form-data"> 

<div class="row-fluid">

			<div class="span2">
            	<div class="clearfix">&nbsp;</div>
                <div class="btn-group" data-toggle="buttons-radio">
                  <button type="button" onclick="javascript:togglecheck(3409);" class="btn btn-inverse <?php if(isset($sub_cat_id) && $sub_cat_id != 0){ if($sub_cat_id == '3409'){echo 'active';}}else{ echo 'active';}?>"><i class="icon-home icon-white"></i> Sale</button>
                  <button type="button" onclick="javascript:togglecheck(3410);" class="btn btn-inverse <?php if(isset($sub_cat_id)){ if($sub_cat_id == '3410'){echo 'active';}}else{ echo '';}?>"><i class="icon-share icon-white"></i> Rent</button>
                  
                </div>
				<input type="hidden" name="bus_id" value="<?php echo $bus_id;?>" >
                <input type="hidden" name="main_cat_id" value="3408" >
                <input type="hidden" name="sub_cat_id" id="sub_cat_id_" value="<?php echo $sub_cat_id;?>" >
                
                
			</div>			
			
			<div class="span3">
            	<small>&nbsp;Land Type<i class="icon-question-sign pull-right" rel="tooltip" title="The property sectional type"></i></small>
                <select name="sub_sub_cat_id" id="sel_sub_sub_cat_id" class="span12" <?php if(!isset($sub_sub_cat_id) || $sub_sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
                	<?php 
					if($sub_cat_id != 0){
						 $this->trade_model->get_categories_select('sub_cat_id', $sub_cat_id, $sub_sub_cat_id);
						 
					}else{
						
						
					}
						 ?>
                </select>
			</div>
            <div class="span3">
            	<small>&nbsp;Property Type<i class="icon-question-sign pull-right" rel="tooltip" title="The type of property"></i></small>
				<select name="sub_sub_sub_cat_id" id="sel_sub_sub_sub_cat_id" class="span12" <?php if(!isset($sub_sub_sub_cat_id) || $sub_sub_sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
                	<?php 
					if($sub_sub_cat_id != 0){
						$this->trade_model->get_categories_select('sub_sub_cat_id', $sub_sub_cat_id, $sub_sub_sub_cat_id);
						
					}else{
						
						
					}
					?>
                </select>
			</div>
            
                <div class="span2 room_div">
                		<small>&nbsp;Bedrooms<i class="icon-question-sign pull-right" rel="tooltip" title="The number of bedrooms"></i></small>
                        <select class="span12" name="bedrooms">
                            <option value="">Bedrooms</option>
                            <option value="1 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 1);?>>1 Bedroom</option>
                            <option value="2 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 2);?>>2 Bedroom</option>
                            <option value="3 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 3);?>>3 Bedroom</option>
                            <option value="4 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 4);?>>4 Bedroom</option>
                            <option value="5 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 5);?>>5 Bedroom</option>
                            <option value="6 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 6);?>>6 Bedroom</option>
                            <option value="7 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 7);?>>7 Bedroom</option>
                            <option value="8 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 8);?>>8 Bedroom</option>
                            <option value="9 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 9);?>>9 Bedroom</option>
                            <option value="10 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 10);?>>10 Bedrooms</option>
                        </select>
                </div>
                <div class="span2 room_div">
                	  <small>&nbsp;Bathrooms<i class="icon-question-sign pull-right" rel="tooltip" title="The number of bathrooms"></i></small>
                      <select class="span12" name="bathrooms">
                          <option value="">Bathrooms</option>
                          <option value="1 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 1);?>>1 Bathroom</option>
                          <option value="2 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 2);?>>2 Bathroom</option>
                          <option value="3 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 3);?>>3 Bathroom</option>
                          <option value="4 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 4);?>>4 Bathroom</option>
                          <option value="5 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 5);?>>5 Bathroom</option>
                          <option value="6 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 6);?>>6 Bathroom</option>
                          <option value="7 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 7);?>>7 Bathroom</option>
                          <option value="8 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 8);?>>8 Bathroom</option>
                          <option value="9 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 9);?>>9 Bathroom</option>
                          <option value="10 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 10);?>>10 Bathrooms</option>
                      </select>
                </div>
              
</div>


    
    <div class="row-fluid <?php if(!is_array($extras)){ echo 'hide';}?>" id="extra_div_toggle">	
			<div class="span12">
            	  <div class="clearfix">&nbsp;</div>
                  <select name="features[]" data-placeholder="Type Property Features" class="extra_slect span12" multiple="" size="6">
                      <option value="Scullery" <?php $this->trade_model->test_extras($extras ,'Scullery','selected', 'Scullery');?>>Scullery</option>
                      <option value="Gym" <?php $this->trade_model->test_extras($extras ,'Gym','selected', 'Gym');?>>Gym</option>
                      <option value="Lapa" <?php $this->trade_model->test_extras($extras ,'Lapa','selected', 'Lapa');?>>Lapa</option>
                      <option value="Swimming-pool" <?php $this->trade_model->test_extras($extras ,'Swimming-pool','selected', 'Swimming-pool');?>>Swimming-pool</option>
                      <option value="Braai" <?php $this->trade_model->test_extras($extras ,'Braai','selected', 'Braai');?>>Braai</option>
                      <option value="Wine Cellar" <?php $this->trade_model->test_extras($extras ,'Wine Cellar','selected', 'Wine Cellar');?>>Wine Cellar</option>
                      <option value="Jaccuzzi" <?php $this->trade_model->test_extras($extras ,'Jaccuzzi','selected', 'Jaccuzzi');?>>Jaccuzzi</option>
                      <option value="Airconditioning" <?php $this->trade_model->test_extras($extras ,'Airconditioning','selected', 'Airconditioning');?>>Airconditioning</option>
                      <option value="Sauna" <?php $this->trade_model->test_extras($extras ,'Sauna','selected', 'Sauna');?>>Sauna</option>
                      <option value="Bar area" <?php $this->trade_model->test_extras($extras ,'Bar area','selected', 'Bar area');?>>Bar area</option>
                      <option value="Garden" <?php $this->trade_model->test_extras($extras ,'Garden','selected', 'Garden');?>>Garden</option>
                      <option value="Entertainment Area" <?php $this->trade_model->test_extras($extras ,'Entertainment Area','selected', 'Entertainment Area');?>>Entertainment Area</option>
                      <option value="DSTV dish" <?php $this->trade_model->test_extras($extras ,'DSTV dish','selected', 'DSTV dish');?>>DSTV dish</option>
                      <option value="Solar Geyser" <?php $this->trade_model->test_extras($extras ,'Solar Geyser','selected', 'Solar Geyser');?>>Solar Geyser</option>
                      <option value="Walk-in-Wardrobe" <?php $this->trade_model->test_extras($extras ,'Walk-in-Wardrobe','selected', 'Walk-in-Wardrobe');?>>Walk-in-Wardrobe</option>
                      <option value="Study" <?php $this->trade_model->test_extras($extras ,'Study','selected', 'Study');?>>Study</option>
                      <option value="Skylight" <?php $this->trade_model->test_extras($extras ,'Skylight','selected', 'Skylight');?>>Skylight</option>
                      <option value="Home automation" <?php $this->trade_model->test_extras($extras ,'Home automation','selected', 'Home automation');?>>Home automation</option>
                      <option value="Electric gates" <?php $this->trade_model->test_extras($extras ,'Electric gates','selected', 'Electric gates');?>>Electric gates</option>
                      <option value="Skylight" <?php $this->trade_model->test_extras($extras ,'Skylight','selected', 'Skylight');?>>Skylight</option>
                      <option value="Alarm System" <?php $this->trade_model->test_extras($extras ,'Alarm System','selected', 'Alarm System');?>>Alarm System</option>
                      <option value="Intercom" <?php $this->trade_model->test_extras($extras ,'Intercom','selected', 'Intercom');?>>Intercom</option>
                      <option value="Electrical fencing" <?php $this->trade_model->test_extras($extras ,'Electrical fencing','selected', 'Electrical fencing');?>>Electrical fencing</option>
                      <option value="Fireplace" <?php $this->trade_model->test_extras($extras ,'Fireplace','selected', 'Fireplace');?>>Fireplace</option>
                      <option value="Workshop" <?php $this->trade_model->test_extras($extras ,'Workshop','selected', 'Workshop');?>>Workshop</option>
                      <option value="Staff Quarters" <?php $this->trade_model->test_extras($extras ,'Staff Quarters','selected', 'Staff Quarters');?>>Staff Quarters</option>
                  </select>
			</div>
	</div>
    

<!--<hr />
<div class="row-fluid">

      <div class="span1">
			<input type="checkbox" name="sole_mandate" value="Sole Mandate">
      </div>
      <div class="span3">
      <label class="control-label" for="sole_mandate">Sole Mandate</label>
      </div>
      <div class="span1">
			<input type="checkbox" name="cc_registered" value="cc Registered">
      </div>
      <div class="span3">
          <label class="control-label" for="cc_registered">cc Registered</label>
      </div>
      <div class="span1">
			<input type="checkbox" name="PTY_Ltd" value="PTY (Ltd)">
      </div> 
      <div class="span3">
      		<label class="control-label" for="PTY_Ltd">PTY (Ltd)</label>
      </div>

</div>
<hr />-->

<div class="clearfix">&nbsp;</div>
<div class="row-fluid">	

			<div class="span3">
				<div class="row-fluid">
                	<div class="span6">
                        <div class="input-prepend input-append">
                          <span class="add-on btn-inverse"><i class="icon-minus icon-white"></i></span>
                          <input name="price_from" type="text"  rel="tooltip" title="The minimum amount in N$" class="span9" value="<?php if($price_from != 'n' && is_numeric($price_from)){ echo number_format($price_from);}?>">
                        </div>
                        		 	
					</div>
                    <div class="span6">
                        <div class="input-append input-prepend">
                          <input name="price_to" type="text"  rel="tooltip" title="The maximum amount to search for" class="span9" value="<?php if($price_to != 'n' && is_numeric($price_to)){ echo number_format($price_to);}?>">
                          <span class="add-on btn-inverse"><i class="icon-plus icon-white"></i></span>
                        </div>
                    </div>
                </div>        		 	
			</div>
						
			<div class="span4">
				<?php $this->trade_model->populate_city($location);?>	
			</div>
			<div class="span3">
				
				<div id="suburb_div">
				<?php 	if($suburb != 'all'){
							echo $this->trade_model->populate_suburb_name($location ,$suburb);
						}else{
							echo '<input type="hidden" name="suburb" value="all">
								<select id="suburb" class="span12" disabled="disabled"></select>';

						}
                ?>
                </div>
			</div>
			<div class="span2 text-right">
                 <input type="hidden" name="sort" value="">
                 <input type="hidden" name="offset" value="0">
                 <input type="hidden" name="limit" value="15">
                <div class="btn-group">
                  <button class="btn btn-inverse" type="button" id="toggle_feat_btn" rel="tooltip" title="Toggle Extra Property Filters"><i class=" icon-chevron-down icon-white"></i></button>
                  <button class="btn btn-inverse" type="submit" id="btn_go"><i class="icon-search icon-white"></i> Search</button>
                </div>
					
			</div>
            
			
</div>

</form>



<script type="text/javascript" data-cfasync="false" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	
	$('#sel_sub_cat_id').bind('change', function(){
			$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_cat_id/"+$(this).val()  , function(data){
				  $("#sel_sub_sub_cat_id").html( data ).prop("disabled", false);
				  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true);   
			});	
	});
	
	$('#sel_sub_sub_cat_id').bind('change', function(){
			var val = $(this).val();
			if(val == 3411 || val == 3435){
				$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_sub_cat_id/"+val  , function(data){
					  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", false);
					  $('.room_div').slideDown();
				});	
			}else{
				$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_sub_cat_id/"+val  , function(data){
					  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", false);
					  $('.room_div').slideUp();
				});	
			}

	});


	$('#location_slct').on('change', function(){
		  $("#suburb_div").html('Getting Suburbs...');
		  
		  $.ajax({
			 url: "<?php echo site_url('/');?>trade/populate_suburb_name/"+$(this).val()+"/<?php echo $suburb;?>/",
			success: function(data) {
			  $("#suburb_div").html(data);
			  
			}
		  });
	});  

	$('select.extra_slect').css('margin-left', '0px').select2({
                placeholder: "Please Select",
                allowClear: true
          
	});
	
	$('#toggle_feat_btn').bind('click', function(e){
		
		if($('#extra_div_toggle').is(":visible")){
			
			$(this).html('<i class=" icon-chevron-up icon-white"></i>');
			
		}else{
			$(this).html('<i class=" icon-chevron-down icon-white"></i>');
			
		}
		
		$('#extra_div_toggle').slideToggle();	
		
	});
	
	
	$('#btn_go').bind('click', function(e){
		 
		 	e.preventDefault();
		  
			var frm = $('#search_frm'), btn = $(this), results = $('#my_na_results'), slider = $('.feat_slider'), others = $('.step2');
			//frm.submit();
			slider.fadeOut();
			results.empty().addClass('loading_img');
			$(this).html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				crossDomain:true,
				url: '<?php echo site_url('/').'api/search';?>' ,
				data: frm.serialize(),
				success: function (data) {
					 btn.html('Search');
					 results.html(data).removeClass('loading_img');
					 others.hide();
					 // Cycle plugin
					  $(".slides").cycle({
						  fx:     "fade",
						  speed:   400,
						  timeout: 200,
					  }).cycle("pause");
				  
					  // Pause & play on hover
					  $(".slideshow-block").hover(function(){
			  
						  $(this).find(".slides").addClass("active").cycle("resume");
						  $(this).find(".slides li img").each(function (e) {
							  $(this).attr("src", $(this).attr("data-original"));
						  });
			  
					  }, function(){
						  $(this).find(".slides").removeClass("active").cycle("pause");
					  });
					
				}
			});	
		  
		  
	});
	
	
});

function show_features(){
	
	$('#extra_div_toggle').slideToggle();	
	return false;
}

function togglecheck(id){
	
	$('#sub_cat_id_').val(id);
	$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_cat_id/"+id  , function(data){
		  $("#sel_sub_sub_cat_id").html( data ).prop("disabled", false);
		  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true);   
	});
	
	
}

</script>
            