  <?php 
 //+++++++++++++++++
 //LOAD PROPERTY FILTER
 //+++++++++++++++++
 ?>

<form class="form-inline" name="search" action="<?php echo site_url('/');?>trade/search" method="post" enctype="multipart/form-data"> 
<div class="clearfix"><strong>Find the perfect Car</strong></div>

<div class="row-fluid">
			<div class="span2">
                <div class="clearfix">&nbsp;</div>
                <div class="btn-group" data-toggle="buttons-radio">
                  <button type="button" onclick="javascript:togglecheck('new');" class="btn btn-inverse <?php if($this->trade_model->test_extras($extras,'owners',  'active', 'New')== 'active'){ echo 'active';}?>"><i class="icon-tag icon-white"></i> New</button>
                  <button type="button" onclick="javascript:togglecheck('used');" class="btn btn-inverse <?php if($this->trade_model->test_extras($extras,'owners',  'active', 'New') != 'active'){ echo 'active';}?>"><i class="icon-tags icon-white"></i> Used</button>
                  
                </div>
				<input type="hidden" id="owners" name="owners" value="" >
                <input type="hidden" name="main_cat_id" value="348" >   
			</div>	
			<div class="span2">
            	<small>&nbsp;Vehicle Type<i class="icon-question-sign pull-right" rel="tooltip" title="The type of vehicle"></i></small>
                <select name="sub_cat_id" id="sel_sub_cat_id" class="span12">
					<?php $this->trade_model->get_categories_select('main_cat_id', 348, $sub_cat_id);?>
                </select>	
			</div>

			<div class="span2">
            	<small>&nbsp;Manufacturer<i class="icon-question-sign pull-right" rel="tooltip" title="What car manufacturer"></i></small>
                <select name="sub_sub_cat_id" id="sel_sub_sub_cat_id" class="span12" <?php if(!isset($sub_cat_id) || $sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
                	<?php 
					if(isset($sub_cat_id) && $sub_cat_id != 0){
						$this->trade_model->get_categories_select('sub_cat_id', $sub_cat_id, $sub_sub_cat_id);
					}else{
						
						echo '<option value="0">Please Select</option>';
					}
						
					?>
                </select>
			</div>
            <div class="span2">
            	<small>&nbsp;Model<i class="icon-question-sign pull-right" rel="tooltip" title="The specific model"></i></small>
				<select name="sub_sub_sub_cat_id" id="sel_sub_sub_sub_cat_id" class="span12" <?php if(!isset($sub_sub_cat_id) || $sub_sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
                	<?php 
					if(isset($sub_sub_cat_id) && $sub_sub_cat_id != 0){
						$this->trade_model->get_categories_select('sub_sub_cat_id', $sub_sub_cat_id, $sub_sub_sub_cat_id);
					}else{
						
						echo '<option value="0">Please Select</option>';
					}
						
					?>
                </select>
			</div>
            <div class="span2">
            	<small>&nbsp;Body Style<i class="icon-question-sign pull-right" rel="tooltip" title="The body style of the car or vehicle"></i></small>
                <select name="body_style" class="span12 used_div" data-placeholder="Body Style">
                    <option value="" <?php $this->trade_model->test_extras($extras,'body_style',  'selected', 'Dont know');?>>Any Body Style</option>
                    <option value="Convertible" <?php $this->trade_model->test_extras($extras ,'body_style', 'selected', 'convertible');?>>Convertible</option>
                    <option value="Coupe" <?php $this->trade_model->test_extras($extras,'body_style', 'selected', 'Coupe');?>>Coupe</option>
                    <option value="Hatchback" <?php $this->trade_model->test_extras($extras,'body_style', 'selected', 'hatchback');?>>Hatchback</option>
                    <option value="Sedan" <?php $this->trade_model->test_extras($extras ,'body_style', 'selected', 'sedan');?>>Sedan</option>
                    <option value="Station Wagon" <?php $this->trade_model->test_extras($extras ,'body_style', 'selected', 'station wagon');?>>Station Wagon</option>
                    <option value="RV/SUV" <?php $this->trade_model->test_extras($extras ,'body_style', 'selected', 'rv/suv');?>>RV/SUV</option>
                    <option value="Bakkie" <?php $this->trade_model->test_extras($extras ,'body_style', 'selected', 'bakkie');?>>Bakkie</option>
                    <option value="Panel Van" <?php $this->trade_model->test_extras($extras ,'body_style',  'selected', 'panel van');?>>Panel Van</option>
                    <option value="Other" <?php $this->trade_model->test_extras($extras ,'body_style',  'selected', 'other');?>>Other</option>
                </select>
			</div>
            
            <div class="span1">
            	<small>&nbsp;Year<i class="icon-question-sign pull-right" rel="tooltip" title="Oldest Year model"></i></small>
                <select name="year_from" class="span12  used_div">
                    <option value="0">Year</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1990">1990</option>
                    <option value="1980">1980</option>
                    <option value="1970">1970</option>
                    <option value="1960">1960</option>
                    <option value="1950">1950</option>
                    <option value="1900">1900</option>
                </select>
            </div>    
            <div class="span1">
            	<small>&nbsp;Year<i class="icon-question-sign pull-right" rel="tooltip" title="Newest year model"></i></small>    
                <select name="year_to" class="span12  used_div">
                    <option value="0">Year</option>
                    <option value="2015">2015</option>
                    <option value="2014">2014</option>
                    <option value="2013">2013</option>
                    <option value="2012">2012</option>
                    <option value="2011">2011</option>
                    <option value="2010">2010</option>
                    <option value="2009">2009</option>
                    <option value="2008">2008</option>
                    <option value="2007">2007</option>
                    <option value="2006">2006</option>
                    <option value="2005">2005</option>
                    <option value="2004">2004</option>
                    <option value="2003">2003</option>
                    <option value="2002">2002</option>
                    <option value="2001">2001</option>
                    <option value="2000">2000</option>
                    <option value="1990">1990</option>
                    <option value="1980">1980</option>
                    <option value="1970">1970</option>
                    <option value="1960">1960</option>
                    <option value="1950">1950</option>
                    <option value="1900">1900</option>
                </select>
			</div>
  
</div>
 
    <div class="row-fluid  <?php if($extras == '?'){ echo 'hide';}elseif(is_array($extras)){ if(!array_key_exists('features', $extras)){ echo 'hide';}}?>" id="extra_div_toggle">	
			<div class="span12">
            	  <div class="clearfix">&nbsp;</div>
                    <select name="features[]" data-placeholder="Type Extras Features" class="extra_slect span12" multiple="" size="6">
                        
                        <option value="ABS brakes" <?php $this->trade_model->test_extras($extras ,'ABS brakes',   'selected','ABS brakes');?>>ABS brakes</option>
                        <option value="Air conditioning" <?php $this->trade_model->test_extras($extras,'Air conditioning',   'selected','Air conditioning');?>>Air conditioning</option>
                        <option value="Alloy wheels" <?php $this->trade_model->test_extras($extras,'Alloy wheels',   'selected','Alloy wheels');?>>Alloy wheels</option>
                        <option value="Central locking" <?php $this->trade_model->test_extras($extras,'Central locking',   'selected','Central locking');?>>Central locking</option>
                        <option value="Driver airbag" <?php $this->trade_model->test_extras($extras,'Driver airbag',   'selected','Driver airbag');?>>Driver airbag</option>
                        <option value="Passenger airbag" <?php $this->trade_model->test_extras($extras,'Passenger airbag',   'selected','Passenger airbag');?>>Passenger airbag</option>
                        <option value="Sunroof" <?php $this->trade_model->test_extras($extras,'Sunroof',   'selected','Sunroof');?>>Sunroof</option>
                        <option value="Power steering" <?php $this->trade_model->test_extras($extras,'Power Steering',   'selected','Power Steering');?>>Power steering</option>
                        <option value="Towbar" <?php $this->trade_model->test_extras($extras,'Towbar',   'selected','Towbar');?>>Towbar</option>
                        <option value="Alarm" <?php $this->trade_model->test_extras($extras,'Alarm',   'selected','Alarm');?>>Alarm</option>
                        <option value="PDC" <?php $this->trade_model->test_extras($extras,'PDC',   'selected','PDC');?>>PDC</option>
                        <option value="TPMS" <?php $this->trade_model->test_extras($extras,'TPMS',   'selected', 'TPMS');?>>TPMS</option>
                        <option value="Xenon Lights" <?php $this->trade_model->test_extras($extras,'Xenon Lights',   'selected','Xenon Lights');?>>Xenon Lights</option>
                        <option value="Navigation System" <?php $this->trade_model->test_extras($extras,'Navigation System',   'selected','Navigation System');?>>Navigation System</option>
                        <option value="Leather Seats" <?php $this->trade_model->test_extras($extras,'Leather Seats',   'selected','Leather Seats');?>>Leather Seats</option>
                        <option value="CD Changer" <?php $this->trade_model->test_extras($extras,'CD Changer',   'selected','CD Changer');?>>CD Changer</option>
                        <option value="Climate Control" <?php $this->trade_model->test_extras($extras,'Climate Control',   'selected','Climate Control');?>>Climate Control</option>
                        <option value="Cruise Control" <?php $this->trade_model->test_extras($extras,'Cruise Control',   'selected','Cruise Control');?>>Cruise Control</option>
                        <option value="Electronic Stability Control" <?php $this->trade_model->test_extras($extras,'Electronic Stability Control',   'selected','Electronic Stability Control');?>>Electronic Stability Control</option>
                        <option value="Multi Function Steering" <?php $this->trade_model->test_extras($extras,'Multi Function Steering',   'selected', 'Multi Function Steering');?>>Multi Function Steering</option>
                        <option value="Fog Lamps" <?php $this->trade_model->test_extras($extras,'Fog Lamps',   'selected', 'Fog Lamps');?>>Fog Lamps</option>
                        <option value="Electric Seats" <?php $this->trade_model->test_extras($extras,'Electric Seats',   'selected', 'Electric Seats');?>>Electric Seats</option>
                        <option value="Rear Diff Lock" <?php $this->trade_model->test_extras($extras,'Rear Diff Lock',   'selected', 'Rear Diff Lock');?>>Rear Diff Lock</option>
                        <option value="Adaptive Cruise Control" <?php $this->trade_model->test_extras($extras,'Adaptive Cruise Control',   'selected', 'Adaptive Cruise Control');?>>Adaptive Cruise Control</option>
                        <option value="Keyless Entry" <?php $this->trade_model->test_extras($extras,'Keyless Entry',   'selected', 'Keyless Entry');?>>Keyless Entry</option>
                        <option value="Rear Mount Spare" <?php $this->trade_model->test_extras($extras,'Rear Mount Spare',   'selected' ,'Rear Mount Spare');?>>Rear Mount Spare</option>
                        <option value="Bang Olufsen Sound" <?php $this->trade_model->test_extras($extras,'Bang Olufsen Sound',   'selected', 'Bang Olufsen Sound');?>>Bang Olufsen Sound</option>
                        <option value="Blue Tooth" <?php $this->trade_model->test_extras($extras,'Blue Tooth',   'selected', 'Blue Tooth');?>>Blue Tooth</option>
                        <option value="3 Row Seats" <?php $this->trade_model->test_extras($extras,'3 Row Seats',   'selected', '3 Row Seats');?>>3 Row Seats</option>
                        <option value="Sport Pack" <?php $this->trade_model->test_extras($extras,'Sport Pack',   'selected', 'Sport Pack');?>>Sport Pack</option>
                        <option value="Full Spare Wheel" <?php $this->trade_model->test_extras($extras,'Full Spare Wheel',   'selected', 'Full Spare Wheel');?>>Full Spare Wheel</option>
                        <option value="Bull Bar" <?php $this->trade_model->test_extras($extras,'Bull Bar',   'selected', 'Bull Bar');?>>Bull Bar</option>
                        <option value="Tow Bar" <?php $this->trade_model->test_extras($extras,'Tow Bar',   'selected', 'Tow Bar');?>>Tow Bar</option>
                        <option value="Canopy" <?php $this->trade_model->test_extras($extras,'Canopy',   'selected', 'Canopy');?>>Canopy</option>
                        <option value="Spotlights" <?php $this->trade_model->test_extras($extras,'Spotlights',   'selected', 'Spotlights');?>>Spotlights</option>
                        <option value="IPOP Kit" <?php $this->trade_model->test_extras($extras,'IPOP Kit',   'selected', 'IPOP Kit');?>>IPOP Kit</option>
                        <option value="Mud Flaps" <?php $this->trade_model->test_extras($extras,'Mud Flaps',   'selected', 'Mud Flaps');?>>Mud Flaps</option>
                        <option value="Nudge Bar" <?php $this->trade_model->test_extras($extras,'Nudge Bar', 'selected', 'Nudge Bar');?>>Nudge Bar</option>
                        <option value="Running Boards" <?php $this->trade_model->test_extras($extras,'Running Boards',   'selected','Running Boards');?>>Running Boards</option>
                        <option value="Tralies" <?php $this->trade_model->test_extras($extras,'Tralies',   'selected', 'Tralies');?>>Tralies</option>
                        <option value="Tinted Windows" <?php $this->trade_model->test_extras($extras,'Tinted Windows',   'selected', 'Tinted Windows');?>>Tinted Windows</option>
                        <option value="After Market Bumper" <?php $this->trade_model->test_extras($extras,'After Market Bumper', 'selected','After Market Bumper');?>>After Market Bumper</option>
                        <option value="Auto Armor" <?php $this->trade_model->test_extras($extras ,'Auto Armor',  'selected', 'Auto Armor');?>>Auto Armor</option>
                        <option value="VPS" <?php $this->trade_model->test_extras($extras,'VPS','selected', 'VPS');?>>VPS</option>
                        <option value="Park Assist" <?php $this->trade_model->test_extras($extras,'Park Assist', 'selected','Park Assist');?>>Park Assist</option>
                        <option value="Keyless Start" <?php $this->trade_model->test_extras($extras,'Keyless Start', 'selected','Keyless Start');?>>Keyless Start</option>
                        <option value="Front Camera" <?php $this->trade_model->test_extras($extras,'Front Camera','selected','Front Camera');?>>Front Camera</option>
                        <option value="Rear Camera" <?php $this->trade_model->test_extras($extras,'Rear Camera', 'selected','Rear Camera');?>>Rear Camera</option>

                        <option value="EBD Electronic Brake-Pressure Distribution" <?php $this->trade_model->test_extras($extras,'EBD Electronic Brake-Pressure Distribution','selected','EBD Electronic Brake-Pressure Distribution');?>>EBD Electronic Brake-Pressure Distribution</option>
                        <option value="ESP Electronic Stability Programme" <?php $this->trade_model->test_extras($extras,'ESP Electronic Stability Programme','selected', 'ESP Electronic Stability Programme');?>>ESP Electronic Stability Programme</option>
                        <option value="ASR Anti Spin Regulation" <?php $this->trade_model->test_extras($extras,'ASR Anti Spin Regulation','selected', 'ASR Anti Spin Regulation');?>>ASR Anti Spin Regulation</option>
                        <option value="EDL Electronic Differential lock" <?php $this->trade_model->test_extras($extras,'EDL Electronic Differential lock','selected', 'EDL Electronic Differential lock');?>>EDL Electronic Differential lock</option>
                        <option value="Disc Brakes" <?php $this->trade_model->test_extras($extras,'Disc Brakes','selected', 'Disc Brakes');?>>Disc Brakes</option>
                        <option value="Keyless Access" <?php $this->trade_model->test_extras($extras,'Keyless Access','selected', 'Keyless Access');?>>Keyless Access</option>
                        <option value="Bluemotion Technology" <?php $this->trade_model->test_extras($extras,'Bluemotion Technology','selected','Bluemotion Technology' );?>>Bluemotion Technology</option>
                        <option value="Climate Control" <?php $this->trade_model->test_extras($extras,'Climate Control','selected', 'Climate Control');?>>Climate Control</option>
                        <option value="Sport Seats" <?php $this->trade_model->test_extras($extras,'Sport Seats','selected',  'Sport Seats');?>>Sport Seats</option>
                    </select>
			</div>
	</div>
    

<div class="clearfix">&nbsp;</div>
<div class="row-fluid">	

			<div class="span3">
				<div class="row-fluid">
                	<div class="span6">
                        <div class="input-prepend input-append">
                          <span class="add-on btn-inverse"><i class="icon-minus icon-white"></i></span>
                          <input name="price_from" type="text"  placeholder="N$"  rel="tooltip" title="The minimum amount in N$" class="span9" value="<?php if($price_from != 'n' && is_numeric($price_from)){ echo number_format($price_from);}?>">
                        </div>
                        		 	
					</div>
                    <div class="span6">
                        <div class="input-append input-prepend">
                          <input name="price_to" type="text" placeholder="N$"   rel="tooltip" title="The maximum amount to search for" class="span9" value="<?php if($price_to != 'n' && is_numeric($price_to)){ echo number_format($price_to);}?>">
                          <span class="add-on btn-inverse"><i class="icon-plus icon-white"></i></span>
                        </div>
                    </div>
                </div>        		 	
			</div>
						
			<div class="span3">
            <small class="hidden-desktop hidden-tablet">&nbsp;Location <i class="icon-question-sign pull-right" rel="tooltip" title="Where do you want to find the item? Select a city"></i></small>
				<?php $this->trade_model->populate_city($location);?>	
			</div>
			<div class="span3">
				<small class="hidden-desktop hidden-tablet">&nbsp;Suburb <i class="icon-question-sign pull-right" rel="tooltip" title="Where do you want to find the item? Select a city"></i></small>
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
			<div class="span3 text-right">
                 <input type="hidden" name="sort" value="">
                 <input type="hidden" name="offset" value="0">
                 <input type="hidden" name="limit" value="15">
                <div class="btn-group">
                  <button class="btn btn-inverse" type="button" id="toggle_feat_btn" ><i class=" icon-chevron-down icon-white"></i></button>
                  <button class="btn btn-inverse" type="submit" id="search_submit"><i class="icon-search icon-white"></i> Search</button>
                </div>
					
			</div>
            
			
</div>

</form>


<script type="text/javascript">

$(document).ready(function(){
	
	$('#sel_sub_cat_id').bind('change', function(){
			if($(this).val() != 352){
				 $('.used_div').prop("disabled", true);
			}else{
				$('.used_div').prop("disabled", false);
			}
			$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_cat_id/"+$(this).val()  , function(data){
					  $("#sel_sub_sub_cat_id").html( data ).prop("disabled", false);
					  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true); 
					   
			});
	});
	
	$('#sel_sub_sub_cat_id').bind('change', function(){
			var val = $(this).val();
			$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_sub_cat_id/"+val  , function(data){
				  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", false);
				  $('.used_div').prop("disabled",false);
			});	
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

	$('select').select2({
                placeholder: "Please Select",
                allowClear: true,
				width: "95%"
          
	});
	
	$('#toggle_feat_btn').bind('click', function(e){
		
		if($('#extra_div_toggle').is(":visible")){
			
			$(this).html('<i class=" icon-chevron-up icon-white"></i>');
			
		}else{
			$(this).html('<i class=" icon-chevron-down icon-white"></i>');
			
		}
		
		$('#extra_div_toggle').slideToggle();	
		
	});
	
});

function show_features(){
	
	$('#extra_div_toggle').slideToggle();	
	return false;
}

function togglecheck(id){
	
	if(id == 'new'){
		$('#owners').val('New');
		$('.used_div').prop("disabled", true);;
		$('.new_div').slideDown();
	}else{
		$('#owners').val('');
		$('.used_div').prop("disabled", false);;
		$('.new_div').slideUp();
	}
	
	
}

</script>
            