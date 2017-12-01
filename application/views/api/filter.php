<?php 
//LOAD HEADER	
 $this->load->view('api/inc/header_api');	

?>

 		<div class="row-fluid">
        	<div class="span12">
				<div class="padding10">
					<?php 
                   //+++++++++++++++++
                   //FILTERS
                   //+++++++++++++++++
                   $this->load->view('api/inc/filter_property');
                   ?>
                </div>
            </div>
		</div>

 		<div class="row-fluid">
        	<div class="span12">
				<div class="" id="my_na_results">
					<?php 	
                        /*Search Results
                        Loop through the search results in the query array
                        */	
                    
                          // $this->api_model->get_products($bus_id, $query, $main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $count, $offset, $title, $amt = 4, FALSE);
                    
                        
                        //LOAD PAGINATION
                    ?>
    
                </div>
            </div>
		</div>
<script src="<?php echo base_url('/')?>js/jquery.cycle.all.min.js" type="text/javascript" ></script>
<script type="text/javascript" >
	$(document).ready(function(){
		$('[rel=tooltip]').tooltip();

		// Cycle plugin
		$('.slides').cycle({
			fx:     'fade',
			speed:   400,
			timeout: 200,
		}).cycle("pause");
	
		// Pause & play on hover
		$('.slideshow-block').hover(function(){

			$(this).find('.slides').addClass('active').cycle('resume');
			$(this).find('.slides li img').each(function (e) {
				$(this).attr('src', $(this).attr('data-original'));
			});

		}, function(){
			$(this).find('.slides').removeClass('active').cycle('pause');
		});
	}); 
</script>
