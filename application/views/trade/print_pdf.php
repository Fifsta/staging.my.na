<html>
<head>

</head>
<body>


		   <?php 
              /*
              SHOW Company Info
              */	        

		   if($bus_id == 0){

			?>
			   <table class="table" border="0" style="border:none;width:100%">
				   <tr>
					   <td style="width:70%; border:none"><h1 class="na_script"><?php echo $Ptitle;?></h1></td>
					   <td style="width:30%; text-align:right; border:none"></td>
				   </tr>
			   </table>
		   <?php
		   }elseif($bus_id != 0){
                    
            ?>

              
				 <?php
	                /*
	                SHOW Company Info
	                */
	                $this->print_model->show_company($bus_id, $property_agent);

	              ?>
				
            <?php }?>
<?php 
			/*
			LOOP EACH PROIDUCT
			*/	
			
			if($query->result()){
				foreach($query->result_array() as $row){
					$this->print_model->print_product($row['product_id'], $row['property_agent'], $main_cat, $sub_cat, $sub_sub_cat, $sub_sub_sub_cat);
				}
			}



			?>

</body>
</html>

