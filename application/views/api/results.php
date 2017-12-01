<?php 
//LOAD HEADER	
 $this->load->view('api/inc/header_api');	
?>


 		<div class="row-fluid">
        	<div class="span12">
				<div class="padding10" id="my_na_results">
					<?php 	
                        /*Search Results
                        Loop through the search results in the query array
                        */	
                    
                           $this->api_model->get_products($bus_id, $query, $main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $count, $offset, $title, $amt = 4, FALSE);
                    
                        
                        //LOAD PAGINATION
                    ?>
    
                </div>
            </div>
		</div>

