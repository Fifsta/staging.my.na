<?php


 $subdata['product_id'] = $product_id;
 

 
 ?>
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />

        <form id="item-add" name="item-add" method="post" action="<?php echo site_url('/');?>trade/add_extras" class="form-horizontal">
         <fieldset>
         <div class="row">
            <div class="col-md-12">         
                      <input type="hidden" name="product_id" id="product_id" value="<?php if(isset($product_id)){ echo $product_id; }else{ echo '0';}?>" />
					  <input type="hidden" name="bus_id" id="bus_id" value="<?php if(isset($bus_id)){ echo $bus_id; }else{ echo '0';}?>" />


                      <?php
					    //++++++++++++++++++++++++++++++++++++ 
					    //CHECK WETHER BOAT, BIKE or CAR
						//+++++++++++++++++++++++++++++++++++
						 
						$sub_data['bus_id'] = $bus_id;
						
						//CARS
						if($sub_cat_id == 352){
							
					   		$this->load->view('trade/inc/extras/extras_cars', $subdata);
							
						//BIKES
						}elseif($sub_cat_id == 358){
							
							$this->load->view('trade/inc/extras/extras_bikes', $subdata);
						
						//BOATS
						}elseif($sub_cat_id == 350){	
							
							$this->load->view('trade/inc/extras/extras_boats', $subdata);
							
						
					    //++++++++++++++++++++++++++++++++++++ 
					    //CHECK PROPERTY 
						//+++++++++++++++++++++++++++++++++++
						}elseif($main_cat_id == 3408){
							
							$this->load->view('trade/inc/extras/extras_property', $subdata);
						}
                        ?>

                    </div>
                          
                    <div class="span2">
                    
                    </div>
              </div>
              <div class="row-fluid">
            		<div class="span12">
                      <button type="submit" class="btn btn-success pull-right" id="add_extras_btn"><?php if (isset($product_id)){echo 'Update Item';}else{ echo 'Add Item';}?> <i class="icon-chevron-right icon-white"></i></button>
                      <?php   if(isset($product_id)){ 
					  			
								    $str = '';
									$java = 'onclick="back_to_3()"';
										
							  }else{
								  
									$str = '';
									$java = 'onclick="back_to_3()"';   
							  }
					  ?>
                      <a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/#Latest';?>" onclick="back_to_all();" class="btn btn-dark pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a> 
                      <a href="javascript:void(0)" <?php echo $java;?> class="btn btn-warning pull-right <?php echo $str;?>" style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>  
           			</div>
           </div>
           </fieldset> 
         </form>
       
			

<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">


	$(document).ready(function(){

		  $('select.extra_slect').css('margin-top', '-10px').select2({
                placeholder: "Please Select",
                allowClear: true
          
		 });
	
		
	});
	




</script>           