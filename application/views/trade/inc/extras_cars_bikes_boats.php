<?php


 $subdata['product_id'] = $product_id;
 

 
 ?>
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<div class="row">
    	
    	<div class="col-md-10">
        <form id="item-add" name="item-add" method="post" action="<?php echo site_url('/');?>trade/add_extras" class="form-horizontal">
	        <fieldset>
	                     
			<input type="hidden" name="product_id" id="product_id" value="<?php if(isset($product_id)){ echo $product_id; }else{ echo '0';}?>" />

			<?php 
			//CHECK WETHER BOAT, BIKE or CAR
			//car
			if($sub_cat_id == 352){

			$this->load->view('trade/inc/extras/extras_cars', $subdata);

			//boats	   
			}elseif($sub_cat_id == 350){


			}

			?>
               
               
              
              <button type="submit" class="btn btn-dark pull-right" id="add_extras_btn"><?php if (isset($product_id)){echo 'Update Item';}else{ echo 'Add Item';}?> <i class="icon-chevron-right icon-white"></i></button>
              <?php   if(isset($product_id)){ 
			  			
						    $str = '';
							$java = 'onclick="back_to_3()"';
								
					  }else{
						  
							$str = '';
							$java = 'onclick="back_to_3()"';   
					  }
			  ?>
              <a href="javascript:void(0)" onclick="back_to_all();" class="btn btn-dark pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a> 
              <a href="javascript:void(0)" <?php echo $java;?> class="btn btn-dark pull-right <?php echo $str;?>" style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>  
	        </fieldset> 
	    </form>
       
			</div>
	</div>
  <script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">


	$(document).ready(function(){

		  $('select.extra_slect').css('margin-top', '-10px').select2({
                placeholder: "Please Select",
                allowClear: true
          
		 });
	
		
	});
	
	


</script>           