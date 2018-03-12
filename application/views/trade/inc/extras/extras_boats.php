
<?php 
	$existing = $this->trade_model->get_extras($product_id);
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
	//TEST PRODUCT EXTRAS
	//++++++++++++++++++++++++++
	function test_extras_output($existing, $extra, $product_id, $type){

		  if($existing != ''){
			 
				if(array_key_exists($extra, $existing)){
					
					//if Output selected , value or checked
					if($type == 'output'){
						
						echo $existing[$extra];
						
					}else{
						
						 echo $type; 
						
					}	
					
				}

		
		
		  }
 	}	
	
    ?>

                                      <div class="control-group">
                                        <label class="control-label" for="year">Year</label>
                                        <div class="controls">
                                                <input type="text" class="form-control" value="<?php test_extras_output($existing ,'year', $product_id,  'output');?>" name="year" placeholder="Year make of the boat">
                                                <span class="help-block" style="font-size:11px">What year model is the boat? What year was it built</span>
                                        </div>
                                      </div>

                                      <div class="control-group">
                                        <label class="control-label" for="length">Length</label>
                                        <div class="controls">
                                                <input type="text" class="form-control" name="length" placeholder="Length" value="<?php test_extras_output($existing ,'length', $product_id,  'output');?>">
                                                <span class="help-block" style="font-size:11px">The boats’s length in metres. </span>
                                        </div>
                                      </div>
                                      
                                      <div class="control-group">
                                            <label class="control-label" for="color">Color</label>
                                            <div class="controls">
                                                
                                                <input type="text" class="form-control" name="color" value="<?php test_extras_output($existing ,'color', $product_id,  'output');?>" placeholder="Color"> 
                                                <span class="help-block"  style="font-size:11px">
                                                What colour is the item? eg: blue, red, metallic silver</span>
                                            </div>
                                       </div>
                                      <div class="control-group">
                                            <label class="control-label" for="engine_type">Engine Type</label>
                                            <div class="controls">
                                                <select name="engine_type" data-placeholder="Please Select" class="extra_slect form-control">
                                                    <option value="" <?php test_extras($existing ,'Dont Know', $product_id,  'selected');?>>Dont Know</option>
                                                    <option value="Outboard" <?php test_extras($existing ,'Outboard', $product_id,  'selected');?>>Outboard</option>
                                                    <option value="Inboard" <?php test_extras($existing ,'Inboard', $product_id,  'selected');?>>Inboard</option>
                                                    <option value="Twin outboard" <?php test_extras($existing ,'Twin outboard', $product_id,  'selected');?>>Twin outboard</option>
                                                    <option value="Twin inboard" <?php test_extras($existing ,'Twin inboard', $product_id,  'selected');?>>Twin inboard</option>
                                                    <option value="Jet" <?php test_extras($existing ,'Jet', $product_id,  'selected');?>>Jet</option>
                                                    <option value="None" <?php test_extras($existing ,'None', $product_id,  'selected');?>>None</option>
                                                    <option value="Other" <?php test_extras($existing ,'Other', $product_id,  'selected');?>>Other</option>
                                                </select>
                                                <span class="help-block"  style="font-size:11px">
                                                What type of engine powers the boat?</span>
                                            </div>
                                       </div>
                                      <div class="control-group">
                                            <label class="control-label" for="engine_hours">Engine hours</label>
                                            <div class="controls">
                                                
                                                <input type="text" class="form-control" name="engine_hours" value="<?php test_extras_output($existing ,'engine_hours', $product_id,  'output');?>" placeholder="Color"> 
                                                <span class="help-block"  style="font-size:11px">
                                                How many hours has the engine run?</span>
                                            </div>
                                       </div>
	  
                                      <div class="control-group">
                                            <label class="control-label" for="engine_size">Engine Size</label>
                                            <div class="controls">
                                                
                                                <input class="form-control" type="text" name="engine_size" value="<?php test_extras_output($existing ,'engine_size', $product_id,  'output');?>" placeholder="Engine Size cc"> 
                                                <span class="help-block"  style="font-size:11px">
                                                How much cubic capacity is the engine in HP</span>
                                            </div>
                                       </div>

                                      <div class="control-group">
                                            <label class="control-label" for="warranty">Warranty</label>
                                            <div class="controls">
												<input type="checkbox" name="warranty" value="Warranty" <?php test_extras_output($existing ,'warranty', $product_id,  'checked');?>>
                                                <span class="help-block"  style="font-size:11px">
                                               Does the vehicle come with a warranty</span>
                                            </div>
                                       </div>
                                       <div class="control-group">
                                            <label class="control-label" for="owners">Number of Owners</label>
                                            <div class="controls">
                                                <select name="owners" data-placeholder="Please Select" class="extra_slect form-control">
                                                    <option selected="selected" value="">Don't Know</option>
                                                    <option value="New" <?php test_extras($existing ,'New', $product_id,  'selected');?>>New</option>
                                                    <option value="1 owner" <?php test_extras($existing ,'1 owner', $product_id,  'selected');?>>1 owner</option>
                                                    <option value="2 owners" <?php test_extras($existing ,'2 owners', $product_id,  'selected');?>>2 owners</option>
                                                    <option value="3 owners" <?php test_extras($existing ,'3 owners', $product_id,  'selected');?>>3 owners</option>
                                                    <option value="4 owners" <?php test_extras($existing ,'4 owners', $product_id,  'selected');?>>4 owners</option>
                                                    <option value="5 owners or more" <?php test_extras($existing ,'5 owners or more', $product_id,  'selected');?>>5 owners or more</option>
                                                </select>
                                                <span class="help-block"  style="font-size:11px">
                                               How many people have owned the boat</span>
                                            </div>
                                       </div> 

                                       <?php //TEST IF AUTOHAUS - SHOW SPECIFICS
									   
									   	if($bus_id == 2666){
										?>	
											
                                      <div class="control-group">
                                            <label class="control-label" for="autohaus">Autohaus Windhoek</label>
                                            <div class="controls">
                                                <select name="autohaus[]" data-placeholder="Please Select" class="extra_slect form-control" multiple="" size="6">
                                                    
                                                    <option value="Mastercars" <?php test_extras($existing ,'Mastercars', $product_id,  'selected');?>>Mastercars</option>
                                                    <option value="New" <?php test_extras($existing ,'New', $product_id,  'selected');?>>New</option>
                                                    <option value="Audi Pre-owned" <?php test_extras($existing ,'Audi Pre-owned', $product_id,  'selected');?>>Audi Pre-owned</option>
                                                    <option value="Used" <?php test_extras($existing ,'Used', $product_id,  'selected');?>>Used</option>
                                                    <option value="Factory Warranty" <?php test_extras($existing ,'Factory Warranty', $product_id,  'selected');?>>Factory Warranty</option>
                                                    <option value="Service Plan" <?php test_extras($existing ,'Service Plan', $product_id,  'selected');?>>Service Plan</option>
                                                    <option value="Motor Plan" <?php test_extras($existing ,'Motor Plan', $product_id,  'selected');?>>Motor Plan</option>
                                                    <option value="Motorite" <?php test_extras($existing ,'Motorite', $product_id,  'selected');?>>Motorite</option>
                                                    <option value="Optimum Warranty" <?php test_extras($existing ,'Optimum Warranty', $product_id,  'selected');?>>Optimum Warranty</option>
                                                    <option value="Remainder of Service Plan" <?php test_extras($existing ,'Remainder of Service Plan', $product_id,  'selected');?>>Remainder of Service Plan</option>
                                                    <option value="Remainder of Motor Plan" <?php test_extras($existing ,'Remainder of Motor Plan', $product_id,  'selected');?>>Remainder of Motor Plan</option>
                                                  
                                                </select>
												
                                                <span class="help-block"  style="font-size:11px">
                                               Please select specific Autohaus Windhoek features</span>
                                              
                                            </div>
                                       </div>    
											
										<?php	
										}
									   
									   ?>
                                       
                                                                            