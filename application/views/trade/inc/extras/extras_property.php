<style>

#map-canvas{min-width:100%; height:250px}
#pac-input{min-width:100%;}

</style>

<?php 

$existing = $this->trade_model->get_extras($product_id);
$adjustment = test_extras($existing ,'adjustment', $product_id,  'output');
//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS SELECT
//++++++++++++++++++++++++++
function test_extras($existing, $extra, $product_id, $type){

	if($existing != ''){
		 
	    foreach($existing as $row => $value){

			// if Array
			if(is_array($value)){

				foreach($value as $finalrow => $final_val){
					
					if($final_val == $extra){
					  
					  	//if Output selected , value or checked
					    if($type == 'output'){
							
							echo $final_val;
							
						}else{
							
							 echo $type; 
							
						}
					 
						  
					}
					
				}

			}else{
		
				if($value == $extra){
						  
					//if Output selected , value or checked
				    if($type == 'output'){
						
						echo $value;
						
					}else{
						
						echo $type; 
						
					}
							  
				}

			}

	    }

	}

}

//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS SELECT SIZE
//++++++++++++++++++++++++++
function test_extras_size($existing, $val , $extra, $product_id, $type){

    if($existing != ''){

        foreach($existing as $row => $value){

            if($row == $val){


                if(strstr($value,$extra)){

                    echo $type;

                }

            }

        }

    }

}



//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS
//++++++++++++++++++++++++++

function test_extras_output($existing, $extra, $product_id, $type){

	if($existing != ''){
		 
		if(array_key_exists($extra, $existing)){
				
			//if Output selected , value or checked
			if($type == 'output'){
				
				if($extra == 'erf_size' || $extra == 'house_size' || $extra == 'property_size' ){

                    echo substr($existing[$extra],0, strpos($existing[$extra], ' '));

                }else{

                    echo $existing[$extra];

                }

				
			}else{
				
				echo $type; 
				
			}	
			
		}

	}

}


//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS
//++++++++++++++++++++++++++
function test_map($existing, $extra, $product_id, $type){

	if($existing != ''){
		 
		if(array_key_exists($extra, $existing)){
			
			//if Output selected , value or checked
			if($existing[$extra] == $type){
				
				echo 'btn-success active';
				
			}
			
		}

	}else{
		
		if($type == 'N'){
			
			echo 'btn-success active';	

		}
		  
	}

}


	
//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS
//++++++++++++++++++++++++++
function test_extras_map($existing, $extra){

	if($existing != ''){
		 
		if(array_key_exists($extra, $existing)){
				
			//if Output selected , value or checked
			//if($existing[$extra] == 'Y'){
				
				echo 'Y';
				
			//}
				
		}else{
			
			echo 'N';
		
		}
	
	
	}else{
		  
		echo 'N';
		  
	}

}
	



function get_map_co($existing ,$type, $product_id){
	
	if($existing != ''){
		 
		if(array_key_exists($type, $existing)){
				
			//if Output selected , value or checked
			//if($existing[$extra] == 'Y'){
				
				echo $existing[$type];
				
			//}
				
		}else{
			
			if($type == 'prop_lon'){

				echo '17.1500';
				
			}else{

				echo '-22.5667';
				
			}
			
		}
	
	}else{
		  
		if($type == 'prop_lon'){

			echo '17.1500';
			
		}else{

			echo '-22.5667';
			
		}

	}
		
}
	
?>

<div class="control-group">

   <label class="control-label" for="location"><strong>Address</strong></label>
   <div class="controls">
        <input id="pac-input" style="position:relative" class="form-control" name="address" type="text" value="<?php test_extras_output($existing ,'location', $product_id,  'output');?>" placeholder="32 Sam Nujoma Drive Windhoek Namibia">
  		<span class="help-block" style="font-size:11px">The physical address and location of the property.  Start typing to see suggestions from Google.</span>
  </div>
</div>
<br>

<div class="control-group">
	<div class="controls">     
        <div id="map-canvas" style="min-width:100%; min-height:100%" class="img-thumbnail loading_img"></div>     
        <input type="hidden" id="prop_lat" name="prop_lat" value="<?php get_map_co($existing['extras'] ,'prop_lat', $product_id);?>" />
        <input type="hidden" id="prop_lng" name="prop_lon" value="<?php get_map_co($existing['extras'] ,'prop_lon', $product_id);?>" />
	</div>
</div>
<br>

<div class="control-group">
<label class="control-label" for="toggle_map"><strong>Show Map</strong></label>
    <div class="controls">
        <div class="btn-group" data-toggle="buttons-radio">
          <button type="button" id="map_yes_btn" onclick="javascript:toggleextra('Y', 'map');" class="btn <?php test_map($existing['extras'] ,'toggle_map', $product_id,  'Y');?>">Yes</button>
          <button type="button" id="map_no_btn" onclick="javascript:toggleextra('N', 'map');" class="btn <?php test_map($existing['extras'] ,'toggle_map', $product_id,  'N');?>">No</button>
          
        </div>
        <input type="hidden" name="toggle_map" id="toggle_map" value="<?php test_extras_map($existing['extras'] ,'toggle_map');?>" />
        <span class="help-block" style="font-size:11px">Do you want to show a map of the location</span>
        <div id="map_container" class="alert hide">The map will be shown on the property listing page</div> 
    </div>
</div>
<br>

<div class="control-group">
	<label class="control-label" for="valuation"><strong>Valuation</strong></label>
	<div class="controls">
        <input type="text" class="form-control" value="<?php test_extras_output($existing['extras'] ,'valuation', $product_id,  'output');?>" onkeypress="return isNumberKey(event)" name="valuation" placeholder="N$">
        <span class="help-block" style="font-size:11px">The current valuation the property received</span>
	</div>
</div>
<br>

<div class="">

	<div class="col-md-4">
	    <div class="form-check">
			<input type="checkbox" class="form-check-input" name="sole_mandate" value="Sole Mandate" <?php test_extras_output($existing['extras'] ,'sole_mandate', $product_id,  'checked'); ?>> 
			<label class="form-check-label" for="sole_mandate">Sole Mandate</label>   
	    </div>
	</div>

	<div class="col-md-4">
	    <div class="form-check">
			<input type="checkbox" class="form-check-input" name="cc_registered" value="cc Registered" <?php test_extras_output($existing['extras'] ,'cc_registered', $product_id,  'checked'); ?>>
			<label class="form-check-label" for="cc_registered">cc Registered</label>
	    </div>
	</div>

	<div class="col-md-4">
	    <div class="form-check">
			<input type="checkbox" class="form-check-input" name="PTY_Ltd" value="PTY (Ltd)" <?php test_extras_output($existing['extras'] ,'PTY_Ltd', $product_id,  'checked'); ?>>
			<label class="form-check-label" for="PTY_Ltd">PTY (Ltd)</label>
	    </div>
	</div>

</div>


<div class="">

	<div class="col-md-4">
	    <div class="form-check">
	        <input type="checkbox" class="form-check-input" name="vat_inclusive" value="Vat Inclusive" <?php test_extras_output($existing['extras'] ,'vat_inclusive', $product_id,  'checked'); ?>>
	        <label class="form-check-label" for="vat_inclusive">Vat inclusive</label>
	    </div>
	</div>

	<div class="col-md-4">
	    <div class="form-check">
			<input type="checkbox" class="form-check-input" name="negotiable" value="Negotiable" <?php test_extras_output($existing['extras'] ,'negotiable', $product_id,  'checked'); ?>>
			<label class="form-check-label" for="negotiable">Negotiable</label>
	    </div>
	</div>

	<div class="col-md-4">
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="transfer_costs_included" value="Sole Mandate" <?php test_extras_output($existing['extras'] ,'transfer_costs_included', $product_id,  'checked');?>>
        </div>
        <label class="form-check-label" for="transfer_costs_included">Transfer Costs included</label>
	</div>

</div>

<br>
<div class="control-group">
	<label class="control-label" for=""></label>
	<div class="controls">
	        <span class="help-block" style="font-size:11px">What pricing extras and options are included in the property?</span>
	</div>
</div>

<?php
//COMMERCIAL OR RESIDENTIAL ROOM TYPES 
//if($sub_sub_cat_id == 3412 || $sub_sub_cat_id == 3452 || $sub_sub_cat_id == 3436 ||  $sub_sub_cat_id == 3453){

?>	 



<?php //} ?>
<div class="row">
  <div class="col-md-6">
      <label class="control-label" for="bedrooms"><strong>Bedrooms</strong></label>
      <div class="controls">
          <select class="form-control" name="bedrooms">
              <option value="">Select if Relevant</option>
              <option value="1 bedrooms" <?php test_extras($existing['extras'] ,'1 bedrooms', $product_id,  'selected');?>>1 Bedroom</option>
              <option value="2 bedrooms" <?php test_extras($existing['extras'] ,'2 bedrooms', $product_id,  'selected');?>>2 Bedroom</option>
              <option value="3 bedrooms" <?php test_extras($existing['extras'] ,'3 bedrooms', $product_id,  'selected');?>>3 Bedroom</option>
              <option value="4 bedrooms" <?php test_extras($existing['extras'] ,'4 bedrooms', $product_id,  'selected');?>>4 Bedroom</option>
              <option value="5 bedrooms" <?php test_extras($existing['extras'] ,'5 bedrooms', $product_id,  'selected');?>>5 Bedroom</option>
              <option value="6 bedrooms" <?php test_extras($existing['extras'] ,'6 bedrooms', $product_id,  'selected');?>>6 Bedroom</option>
              <option value="7 bedrooms" <?php test_extras($existing['extras'] ,'7 bedrooms', $product_id,  'selected');?>>7 Bedroom</option>
              <option value="8 bedrooms" <?php test_extras($existing['extras'] ,'8 bedrooms', $product_id,  'selected');?>>8 Bedroom</option>
              <option value="9 bedrooms" <?php test_extras($existing['extras'] ,'9 bedrooms', $product_id,  'selected');?>>9 Bedroom</option>
              <option value="10 bedrooms" <?php test_extras($existing['extras'] ,'10 bedrooms', $product_id,  'selected');?>>10 Bedrooms</option>
          </select>

          <span class="help-block" style="font-size:11px">How many bedrooms does the property have</span>
      </div>
  </div>
  <div class="col-md-6">
      <label class="control-label" for="bathrooms"><strong>Bathrooms</strong></label>
      <div class="controls">
          <select class="form-control" name="bathrooms">
              <option value="">Select if Relevant</option>
              <option value="1 bathroom" <?php test_extras($existing['extras'] ,'1 bathroom', $product_id,  'selected');?>>1 Bathroom</option>
              <option value="2 bathrooms" <?php test_extras($existing['extras'] ,'2 bathrooms', $product_id,  'selected');?>>2 Bathroom</option>
              <option value="3 bathrooms" <?php test_extras($existing['extras'] ,'3 bathrooms', $product_id,  'selected');?>>3 Bathroom</option>
              <option value="4 bathrooms" <?php test_extras($existing['extras'] ,'4 bathrooms', $product_id,  'selected');?>>4 Bathroom</option>
              <option value="5 bathrooms" <?php test_extras($existing['extras'] ,'5 bathrooms', $product_id,  'selected');?>>5 Bathroom</option>
              <option value="6 bathrooms" <?php test_extras($existing['extras'] ,'6 bathrooms', $product_id,  'selected');?>>6 Bathroom</option>
              <option value="7 bathrooms" <?php test_extras($existing['extras'] ,'7 bathrooms', $product_id,  'selected');?>>7 Bathroom</option>
              <option value="8 bathrooms" <?php test_extras($existing['extras'] ,'8 bathrooms', $product_id,  'selected');?>>8 Bathroom</option>
              <option value="9 bathrooms" <?php test_extras($existing['extras'] ,'9 bathrooms', $product_id,  'selected');?>>9 Bathroom</option>
              <option value="10 bathrooms" <?php test_extras($existing['extras'] ,'10 bathrooms', $product_id,  'selected');?>>10 Bathrooms</option>
          </select>

          <span class="help-block" style="font-size:11px">How many bathrooms does the property have</span>
      </div>
  </div>
</div>
<p>&nbsp;</p>
<div class="row">
  <div class="col-md-6">
      <label class="control-label" for="offices"><strong>Offices</strong></label>
      <div class="controls">
          <select class="form-control" name="offices">
              <option value="">Select if Relevant</option>
              <option value="1 offices" <?php test_extras($existing['extras'] ,'1 offices', $product_id,  'selected');?>>1 Offices</option>
              <option value="2 offices" <?php test_extras($existing['extras'] ,'2 offices', $product_id,  'selected');?>>2 Offices</option>
              <option value="3 offices" <?php test_extras($existing['extras'] ,'3 offices', $product_id,  'selected');?>>3 Offices</option>
              <option value="4 offices" <?php test_extras($existing['extras'] ,'4 offices', $product_id,  'selected');?>>4 Offices</option>
              <option value="5 offices" <?php test_extras($existing['extras'] ,'5 offices', $product_id,  'selected');?>>5 Offices</option>
              <option value="6 offices" <?php test_extras($existing['extras'] ,'6 offices', $product_id,  'selected');?>>6 Offices</option>
              <option value="7 offices" <?php test_extras($existing['extras'] ,'7 offices', $product_id,  'selected');?>>7 Offices</option>
              <option value="8 offices" <?php test_extras($existing['extras'] ,'8 offices', $product_id,  'selected');?>>8 Offices</option>
              <option value="9 offices" <?php test_extras($existing['extras'] ,'9 offices', $product_id,  'selected');?>>9 Offices</option>
              <option value="10 offices" <?php test_extras($existing['extras'] ,'10 offices', $product_id,  'selected');?>>10 Offices</option>
          </select>

          <span class="help-block" style="font-size:11px">How many offices does the property have</span>
      </div>
  </div>
  <div class="col-md-6">
      <label class="control-label" for="garages"><strong>Garages</strong></label>
      <div class="controls">
          <select class="form-control" name="garages">
              <option value="">Select if Relevant</option>
              <option value="1 garages" <?php test_extras($existing['extras'] ,'1 garages', $product_id,  'selected');?>>1 Garages</option>
              <option value="2 garages" <?php test_extras($existing['extras'] ,'2 garages', $product_id,  'selected');?>>2 Garages</option>
              <option value="3 garages" <?php test_extras($existing['extras'] ,'3 garages', $product_id,  'selected');?>>3 Garages</option>
              <option value="4 garages" <?php test_extras($existing['extras'] ,'4 garages', $product_id,  'selected');?>>4 Garages</option>
              <option value="5 garages" <?php test_extras($existing['extras'] ,'5 garages', $product_id,  'selected');?>>5 Garages</option>
              <option value="6 garages" <?php test_extras($existing['extras'] ,'6 garages', $product_id,  'selected');?>>6 Garages</option>
              <option value="7 garages" <?php test_extras($existing['extras'] ,'7 garages', $product_id,  'selected');?>>7 Garages</option>
              <option value="8 garages" <?php test_extras($existing['extras'] ,'8 garages', $product_id,  'selected');?>>8 Garages</option>
              <option value="9 garages" <?php test_extras($existing['extras'] ,'9 garages', $product_id,  'selected');?>>9 Garages</option>
              <option value="10 garages" <?php test_extras($existing['extras'] ,'10 garages', $product_id,  'selected');?>>10 Garages</option>
          </select>

          <span class="help-block" style="font-size:11px">How many garages does the property have</span>
      </div>
  </div>
</div>
<p>&nbsp;</p>

<?php
//FARMS CATLLE,GAME ETC SPECIFICS
if($sub_sub_cat_id == 3413){
?>

  <div class="control-group">
      <label class="control-label" for="farm_size">Farm Size</label>
      <div class="controls">
          <input type="text" class="form-control" name="farm_size" onkeypress="return isNumberKey(event)" placeholder="450" value="<?php test_extras_output($existing['extras'] ,'farm_size', $product_id,  'output');?>">
          <!--<select name="farm_size_type">

              <option value="ha" <?php //test_extras_size($existing['extras'], 'farm_size' ,'ha', $product_id,  'selected');?>>Hectares</option>
          </select>-->
          <span class="help-block" style="font-size:11px">The Farm size in hectares</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="farm_location"><strong>Location</strong></label>
      <div class="controls">
          <textarea name="farm_location" class="form-control" placeholder="Location"><?php test_extras_output($existing['extras'] ,'farm_location', $product_id,  'output');?></textarea>
          <span class="help-block"  style="font-size:11px">Describe the farm location</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="farm_house"><strong>Farm house</strong></label>
      <div class="controls">
        <textarea name="farm_house" class="form-control" placeholder="Farm house"><?php test_extras_output($existing['extras'] ,'farm_house', $product_id,  'output');?></textarea>
        <span class="help-block"  style="font-size:11px"> Describe the farm house</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="guest_facilities"><strong>Guest Facilities</strong></label>
      <div class="controls">
        <textarea name="guest_facilities" class="form-control" placeholder="Guest Facilities"><?php test_extras_output($existing['extras'] ,'guest_facilities', $product_id,  'output');?></textarea>
        <span class="help-block"  style="font-size:11px">Describe the Guest utilities</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="outbuildings"><strong>Outbuildings</strong></label>
      <div class="controls">
        <textarea name="outbuildings" class="form-control" placeholder="Outbuildings"><?php test_extras_output($existing['extras'] ,'outbuildings', $product_id,  'output');?></textarea>
        <span class="help-block"  style="font-size:11px">Describe the farm Outbuildings</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="staff_quarters"><strong>Staff Quarters</strong></label>
      <div class="controls">
        <textarea name="staff_quarters" class="form-control" placeholder="Staff Quarters"><?php test_extras_output($existing['extras'] ,'staff_quarters', $product_id,  'output');?></textarea>
        <span class="help-block"  style="font-size:11px">Describe the Staff Quarters</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="electricity_supply"><strong>Electricity Supply</strong></label>
      <div class="controls">
          <select class="form-control" name="electricity_supply">
              <option value="">Select if Relevant</option>
              <option value="Nampower" <?php test_extras($existing['extras'] ,'Nampower', $product_id,  'selected');?>>Nampower</option>
              <option value="Solar" <?php test_extras($existing['extras'] ,'Solar', $product_id,  'selected');?>>Solar</option>
              <option value="Genset" <?php test_extras($existing['extras'] ,'Genset', $product_id,  'selected');?>>Genset</option>
          </select>
          <span class="help-block" style="font-size:11px">What power/electricity Supply does the farm have.</span>
      </div>
  </div>
  <br>

  <div class="row">
      <div class="col-md-6">
          <div class="control-group">
              <label class="control-label" for="boreholes"><strong>No of Boreholes</strong></label>

              <div class="controls">
                  <input type="number" class="form-control" id="boreholes" name="boreholes" placeholder="1" value="<?php test_extras_output($existing['extras'] ,'boreholes', $product_id,  'output');?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <span class="help-block" style="font-size:11px">How many boreholes are available on the farm.</span>
              </div>
          </div>
      </div>
      <div class="col-md-6">
          <div class="control-group">
              <label class="control-label" for="camps"><strong>No of Camps</strong></label>
              <div class="controls">
                  <input type="number" class="form-control" id="camps" name="camps" placeholder="1" value="<?php test_extras_output($existing['extras'] ,'camps', $product_id,  'output');?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                  <span class="help-block" style="font-size:11px">How many camps are available on the farm.</span>
              </div>
          </div>
      </div>
  </div>
  <br>


  <div class="">
      <div class="col-md-6">
          <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" name="game_camp" value="Game Camp" <?php test_extras_output($existing['extras'] ,'game_camp', $product_id,  'checked');?>>
              <label class="form-check-label" for="game_camp">Game Camp?</label>
          </div>
      </div>
      <div class="col-md-6">
          <div class="form-check form-check-inline">
              <input type="checkbox" class="form-check-input" name="waiver" value="Has a Waiver" <?php test_extras_output($existing['extras'] ,'waiver', $product_id,  'checked');?>>
              <label class="form-check-label" for="waiver">Has a Waiver</label>
          </div>
      </div>
      <span class="help-block" style="font-size:11px">Does the farm have a game camp? And does the Farm come with a Waiver?</span>
  </div>


  <br>
  <div class="row">
      <div class="col-md-6">

          <div class="control-group">
              <label class="control-label" for="external_fencing"><strong>External Fencing</strong></label>

              <div class="controls">
                  <select class="form-control" name="external_fencing">
                      <option value="Game_Proof" <?php test_extras($existing['extras'] ,'Game_Proof', $product_id,  'selected');?>>Game Proof</option>
                      <option value="Stock_Proof" <?php test_extras($existing['extras'] ,'Stock_Proof', $product_id,  'selected');?>>Stock Proof</option>
                      <option value="Jackal_Proof" <?php test_extras($existing['extras'] ,'Jackal_Proof', $product_id,  'selected');?>>Jackal Proof</option>
                  </select>

              </div>
          </div>
      </div>

      <div class="col-md-6">
          <div class="control-group">
              <label class="control-label" for="internal_fencing"><strong>Internal Fencing</strong></label>

              <div class="controls">
                  <select class="form-control" name="internal_fencing">
                      <option value="Game Proof" <?php test_extras($existing['extras'] ,'Game Proof', $product_id,  'selected');?>>Game Proof</option>
                      <option value="Stock Proof" <?php test_extras($existing['extras'] ,'Stock Proof', $product_id,  'selected');?>>Stock Proof</option>
                      <option value="Jackal Proof" <?php test_extras($existing['extras'] ,'Jackal Proof', $product_id,  'selected');?>>Jackal Proof</option>
                  </select>

              </div>
          </div>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="game_type"><strong>What type of Game</strong></label>
      <div class="controls">
        <textarea name="game_type" class="form-control" placeholder="Game Situation"><?php test_extras_output($existing['extras'] ,'game_type', $product_id,  'output');?></textarea>
        <span class="help-block"  style="font-size:11px">
        Describe the Game situation on the farm</span>
      </div>
  </div>
  <br>

  <div class="control-group">
      <label class="control-label" for="price_per_ha"><strong>Price per HA</strong></label>
      <div class="controls">
        <input type="number" name="price_per_ha" class="form-control" placeholder="" value="<?php test_extras_output($existing['extras'] ,'price_per_ha', $product_id,  'output');?>">
        <span class="help-block"  style="font-size:11px">
        What is the evaluated price per hectare?</span>
      </div>
  </div>
  <br>

<?php
//COMMERCIAL OR RESIDENTIAL OR PLOT OR NoRMAL PROPERTIES
}else{ 
?>

<div class="control-group">
	<label class="control-label" for="erf_size"><strong>Erf Size</strong></label>
	<div class="form-row">
        <div class="col-md-9"><input type="text" class="form-control" name="erf_size" onkeypress="return isNumberKey(event)" placeholder="450" value="<?php test_extras_output($existing['extras'] ,'erf_size', $product_id,  'output');?>"></div>
        <div class="col-md-3">
	        <select name="erf_size_" class="form-control">
	            <option value="m<sup>2</sup>" <?php test_extras_size($existing['extras'], 'erf_size' ,'m<sup>2</sup>', $product_id,  'selected');?>>Metres Squared</option>
	            <option value="ha" <?php test_extras_size($existing['extras'], 'erf_size' ,'ha', $product_id,  'selected');?>>Hectares</option>
	        </select>
    	</div>
	</div>
	<span class="help-block" style="font-size:11px">The Erf size in square metres m<sup>2</sup> or hectares</span>
</div>
<br>

<div class="control-group">
	<label class="control-label" for="house_size"><strong>House Size</strong></label>
	<div class="form-row">
        <div class="col-md-9"><input type="text" class="form-control" name="house_size" onkeypress="return isNumberKey(event)" placeholder="350" value="<?php test_extras_output($existing['extras'] ,'house_size', $product_id,  'output');?>"></div>
        <div class="col-md-3">
	        <select class="form-control" name="house_size_">
	            <option value="m<sup>2</sup>" <?php test_extras_size($existing['extras'], 'house_size' ,'m<sup>2</sup>', $product_id,  'selected');?>>Metres Squared</option>
	            <option value="ha" <?php test_extras_size($existing['extras'], 'house_size' ,'ha', $product_id,  'selected');?>>Hectares</option>
	        </select>
    	</div>
	</div>
	<span class="help-block" style="font-size:11px">Optional, the house size in square metres m<sup>2</sup> or hectares</span>
</div>
<br>

<div class="control-group">
  <label class="control-label" for="property_size"><strong>Property Size</strong></label>
  <div class="form-row">
      <div class="col-md-9"><input type="text" class="form-control" name="property_size" onkeypress="return isNumberKey(event)" placeholder="350" value="<?php test_extras_output($existing['extras'] ,'property_size', $product_id,  'output');?>"></div>
      <div class="col-md-3">
	      <select class="form-control" name="property_size_">
	          <option value="m<sup>2</sup>" <?php test_extras_size($existing['extras'], 'property_size' ,'m<sup>2</sup>', $product_id,  'selected');?>>Metres Squared</option>
	          <option value="ha" <?php test_extras_size($existing['extras'], 'property_size' ,'ha', $product_id,  'selected');?>>Hectares</option>
	      </select>
	  </div>
	  
  </div>
  <span class="help-block" style="font-size:11px">The property size in square metres m<sup>2</sup> or hectares</span>

</div>
<br>

<div class="control-group">
	<label class="control-label" for="parking"><strong>Parking and Garage</strong></label>
	<div class="controls">
	    <input class="form-control" type="text" name="parking" placeholder="2 Garages and outside parking" value="<?php test_extras_output($existing['extras'] ,'parking', $product_id,  'output');?>">
	    <span class="help-block" style="font-size:11px">Please describe the garage and parking situation</span>
	</div>
</div>
<br>

<div class="control-group">
    <label class="control-label" for="agency"><strong>Property Reference</strong></label>
    <div class="controls">
        <input type="text" class="form-control" name="agency" value="<?php test_extras_output($existing['extras'] ,'agency', $product_id,  'output');?>" placeholder="Pam Golding">
        <span class="help-block" style="font-size:11px">Your personal or private property reference. Unique property identification number eg: #REF453</span>
    </div>
</div>
<br>

<div class="control-group">
    <label class="control-label" for="location_amenities"><strong>Location Amenities</strong></label>
    <div class="controls">
		<textarea name="location_amenities" class="form-control" placeholder="Location Amenities"><?php test_extras_output($existing['extras'] ,'location_amenities', $product_id,  'output');?></textarea>
        <span class="help-block"  style="font-size:11px">What amenities are located in the area? Shopping mall, bakery etc.</span>
    </div>
</div>
<br>

<div class="control-group">
    <label class="control-label" for="features"><strong>Property Features</strong></label>
    <div class="controls">
        <select name="features[]" data-placeholder="Please Select" class="extra_slect" style="width:100%" multiple="" size="6">
            <option value="">None</option>
            <option value="Scullery" <?php test_extras($existing['extras'] ,'Scullery', $product_id,  'selected');?>>Scullery</option>
            <option value="Gym" <?php test_extras($existing['extras'] ,'Gym', $product_id,  'selected');?>>Gym</option>
            <option value="Lapa" <?php test_extras($existing['extras'] ,'Lapa', $product_id,  'selected');?>>Lapa</option>
            <option value="Swimming-pool" <?php test_extras($existing['extras'] ,'Swimming-pool', $product_id,  'selected');?>>Swimming-pool</option>
            <option value="Braai" <?php test_extras($existing['extras'] ,'Braai', $product_id,  'selected');?>>Braai</option>
            <option value="Wine Cellar" <?php test_extras($existing['extras'] ,'Wine Cellar', $product_id,  'selected');?>>Wine Cellar</option>
            <option value="Jaccuzzi" <?php test_extras($existing['extras'] ,'Jaccuzzi', $product_id,  'selected');?>>Jaccuzzi</option>
            <option value="Airconditioning" <?php test_extras($existing['extras'] ,'Airconditioning', $product_id,  'selected');?>>Airconditioning</option>
            <option value="Sauna" <?php test_extras($existing['extras'] ,'Sauna', $product_id,  'selected');?>>Sauna</option>
            <option value="Bar area" <?php test_extras($existing['extras'] ,'Bar area', $product_id,  'selected');?>>Bar area</option>
            <option value="Garden" <?php test_extras($existing['extras'] ,'Garden', $product_id,  'selected');?>>Garden</option>
            <option value="Entertainment Area" <?php test_extras($existing['extras'] ,'Entertainment Area', $product_id,  'selected');?>>Entertainment Area</option>
            <option value="DSTV dish" <?php test_extras($existing['extras'] ,'DSTV dish', $product_id,  'selected');?>>DSTV dish</option>
            <option value="Solar Geyser" <?php test_extras($existing['extras'] ,'Solar Geyser', $product_id,  'selected');?>>Solar Geyser</option>
            <option value="Walk-in-Wardrobe" <?php test_extras($existing['extras'] ,'Walk-in-Wardrobe', $product_id,  'selected');?>>Walk-in-Wardrobe</option>
            <option value="Study" <?php test_extras($existing['extras'] ,'Study', $product_id,  'selected');?>>Study</option>
            <option value="Skylight" <?php test_extras($existing['extras'] ,'Skylight', $product_id,  'selected');?>>Skylight</option>
			<option value="Home automation" <?php test_extras($existing['extras'] ,'Home automation', $product_id,  'selected');?>>Home automation</option>
            <option value="Electric gates" <?php test_extras($existing['extras'] ,'Electric gates', $product_id,  'selected');?>>Electric gates</option>
            <option value="Skylight" <?php test_extras($existing['extras'] ,'Skylight', $product_id,  'selected');?>>Skylight</option>
            <option value="Alarm System" <?php test_extras($existing['extras'] ,'Alarm System', $product_id,  'selected');?>>Alarm System</option>
            <option value="Intercom" <?php test_extras($existing['extras'] ,'Intercom', $product_id,  'selected');?>>Intercom</option>
            <option value="Electrical fencing" <?php test_extras($existing['extras'] ,'Electrical fencing', $product_id,  'selected');?>>Electrical fencing</option>
            <option value="Fireplace" <?php test_extras($existing['extras'] ,'Fireplace', $product_id,  'selected');?>>Fireplace</option>
            <option value="Workshop" <?php test_extras($existing['extras'] ,'Workshop', $product_id,  'selected');?>>Workshop</option>
            <option value="Staff Quarters" <?php test_extras($existing['extras'] ,'Staff Quarters', $product_id,  'selected');?>>Staff Quarters</option>
            <option value="Old World Charm" <?php test_extras($existing['extras'] ,'Old World Charm', $product_id,  'selected');?>>Old World Charm</option>
            <option value="Very Modern" <?php test_extras($existing['extras'] ,'Very Modern', $product_id,  'selected');?>>Very Modern</option>
            <option value="Newly Renovated" <?php test_extras($existing['extras'] ,'Newly Renovated', $product_id,  'selected');?>>Newly Renovated</option>
            <option value="Laundry" <?php test_extras($existing['extras'] ,'Laundry', $product_id,  'selected');?>>Laundry</option>
            <option value="Open Plan" <?php test_extras($existing['extras'] ,'Open Plan', $product_id,  'selected');?>>Open Plan</option>
            <option value="Bachelor Flat" <?php test_extras($existing['extras'] ,'Bachelor Flat', $product_id,  'selected');?>>Bachelor Flat</option>
            <option value="1 Bedroom Flat" <?php test_extras($existing['extras'] ,'1 Bedroom Flat', $product_id,  'selected');?>>1 Bedroom Flat</option>
            <option value="2 Bedroom Flat" <?php test_extras($existing['extras'] ,'2 Bedroom Flat', $product_id,  'selected');?>>2 Bedroom Flat</option>
            <option value="Outstanding View" <?php test_extras($existing['extras'] ,'Outstanding View', $product_id,  'selected');?>>Outstanding View</option>
            <option value="North Facing" <?php test_extras($existing['extras'] ,'North Facing', $product_id,  'selected');?>>North Facing</option>
            <option value="Water Cooler" <?php test_extras($existing['extras'] ,'Water Cooler', $product_id,  'selected');?>>Water Cooler</option>
            <option value="Guest Toilette" <?php test_extras($existing['extras'] ,'Guest Toilette', $product_id,  'selected');?>>Guest Toilette</option>
        </select>
        <span class="help-block" style="font-size:11px">What kind of features does the house have</span>
    </div>
</div>
<br>

<?php 
//END COMMERCIAL OR RESIDENTIAL OR PLOT OR NoRMAL PROPERTIES 
} ?>

<?php //TEST IF ESTATE AGENT

$agents = $this->trade_model->property_agents($bus_id,  $existing['property_agent']);

if($agents != FALSE) { 	?>

	<div class="control-group">
		<label class="control-label" for="featured"><strong>Is the Property Featured</strong></label>
	    <div class="controls">
	        <div class="btn-group" data-toggle="buttons-radio">
	          <button type="button" onclick="javascript:toggleextra('Y', 'featured');" class="btn yes-feature <?php if($existing['featured'] == 'Y'){ echo 'btn-success active';}?>">Yes</button>
	          <button type="button" onclick="javascript:toggleextra('N', 'featured');" class="btn no-feature <?php if($existing['featured'] == 'N'){ echo 'btn-success active';}?>">No</button>
	        </div>
	        <input class="form-control" type="hidden" name="featured" id="toggle_featured" value="<?php if( $existing['featured'] == '0'){ echo 'N';} else{ echo $existing['featured'];}?>" />
	        <span class="help-block" style="font-size:11px">Should the property be displayed as a featured property?</span>
	    </div>
	</div>
	<br>

	<div class="control-group">
	    <label class="control-label" for="adjustment"><strong>Price Adjustment</strong></label>
	  	<div class="controls">
	        <div class="btn-group" data-toggle="buttons-radio">
	          <button type="button" onclick="javascript:toggleextra('Y', 'adjustment');" class="btn yes-adjustment <?php if($existing['adjustment'] == 'Y'){ echo 'btn-success active';}?>">Yes</button>
	          <button type="button" onclick="javascript:toggleextra('N', 'adjustment');" class="btn no-adjustment <?php if($existing['adjustment'] == 'N'){ echo 'btn-success active';}?>">No</button>
	        </div>
	        <input type="hidden" class="form-control" name="adjustment" id="toggle_adjustment" value="<?php if( $existing['adjustment'] == '0'){ echo 'N';} else{ echo $existing['adjustment'];}?>" />
	        <span class="help-block" style="font-size:11px">Should the property be marked as a recent price adjustment</span>
	  	</div>
	</div>
	<br>

	<div class="control-group">
	    <label class="control-label" for="seller_contact"><strong>Internal Notes</strong></label>
	    <div class="controls">
			<textarea class="form-control" name="seller_contact" placeholder="Sellers Contact Details" cols="2" rows="4"><?php echo $existing['seller_contact'];?></textarea>
	        <span class="help-block"  style="font-size:11px">The sellers contact details and other notes. NB only for your Reference!</span>
	    </div>
	</div>

<?php } ?>	

									
<script type="text/javascript">

	function toggleextra(val, id){
				
		var chk = $('#toggle_'+id);
		chk.val(val);
		
		//show map
		if(id == 'map'){
			
			if(val == 'Y'){
				$('#map_yes_btn').addClass('btn-success');
				$('#map_no_btn').removeClass('btn-success');
				$('#map_container').slideDown();
				
			}else{
				$('#map_no_btn').addClass('btn-success');
				$('#map_yes_btn').removeClass('btn-success');
				$('#map_container').slideUp();
				
			}	
		}

        if(id == 'featured'){

            if(val == 'Y'){
                $('.yes-feature').addClass('btn-success');
                $('.no-feature').removeClass('btn-success');

            }else{
                $('.no-feature').addClass('btn-success');
                $('.yes-feature').removeClass('btn-success');

            }
        }

        if(id == 'adjustment'){

            if(val == 'Y'){
                $('.yes-adjustment').addClass('btn-success');
                $('.no-adjustment').removeClass('btn-success');

            }else{
                $('.no-adjustment').addClass('btn-success');
                $('.yes-adjustment').removeClass('btn-success');

            }

        }

        console.log(id + ' ' + val);
	}	
	  
  
	function load_maps_js(){
		
		<?php 

			if($this->uri->segment(1) != 'sell'){
				if($bus_id == 0){
				
					echo "$.getScript('//maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places&callback=initialize').done(function(){
						 
					});";
				
				}else{
					
					echo "initialize();";
					
				}
			}else{
					
				echo "initialize();";
					
			}

		?>
		
	}


	function initialize() {
		
		var map, markers = [], myLatlng = new google.maps.LatLng( <?php get_map_co($existing['extras'] ,'prop_lat', $product_id);?> , <?php get_map_co($existing['extras'] ,'prop_lon', $product_id);?> );
		var mapOptions = {
			zoom: 7,
			mapTypeControl: true,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		  };
		  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
			  
			  
			var marker = new google.maps.Marker({
				position: myLatlng, 
				map: map, // handle of the map 
				draggable:true
			});
			
			google.maps.event.addListener(
				marker,
				'drag',
				function() {
					document.getElementById('prop_lat').value = marker.position.lat();
					document.getElementById('prop_lng').value = marker.position.lng();
				}
			);
			
			// Create the search box and link it to the UI element.
			var input = /** @type {HTMLInputElement} */(
			  document.getElementById('pac-input'));
			
			
			var searchBox = new google.maps.places.SearchBox(
				/** @type {HTMLInputElement} */(input));
			
			  // Listen for the event fired when the user selects an item from the
			  // pick list. Retrieve the matching places for that item.
			  google.maps.event.addListener(searchBox, 'places_changed', function() {
				var places = searchBox.getPlaces();

				// For each place, get the icon, place name, and location.
				//markers = [];
				//var bounds = new google.maps.LatLngBounds();
				for (var i = 0, place; place = places[i]; i++) {
				  
				  marker.setPosition(place.geometry.location);
				  map.setCenter(place.geometry.location);
				  
				  document.getElementById('prop_lat').value = marker.position.lat();
				  document.getElementById('prop_lng').value = marker.position.lng();
				 // console.log(place.geometry.location.ob);
				  //markers.push(marker);
			
				  //bounds.extend(place.geometry.location);
				}
			
				//map.fitBounds(bounds);
			  });
			
			  // Bias the SearchBox results towards places that are within the bounds of the
			  // current map's viewport.
			  google.maps.event.addListener(map, 'bounds_changed', function() {
				var bounds = map.getBounds();
				searchBox.setBounds(bounds);
			  });
			  

	}
	
	$('body').bind("keyup keypress", function(e) {
	  var code = e.keyCode || e.which; 
	  if (code  == 13) {               
		e.preventDefault();
		return false;
	  }
	});
	
	load_maps_js();	

</script>