  <?php 
 //+++++++++++++++++
 //LOAD PROPERTY FILTER
 //+++++++++++++++++
 ?>


<form class="form-inline" name="search" action="<?php echo site_url('/');?>trade/search" method="post" enctype="multipart/form-data"> 
<div class="row-fluid">
			<div class="span4">
				<small>&nbsp;What<i class="icon-question-sign pull-right" rel="tooltip" title="Start your search with a top level category, like Cars or Property"></i></small>
                <select name="main_cat_id" id="sel_main_cat_id" class="span12">
					<?php 
					if(isset($main_cat_id)){ }else{ $main_cat_id = 0;}
					$this->trade_model->get_categories_select('cat_id', '0', $main_cat_id);?>
                </select>	
			</div>	
			<div class="span4">
				<small>&zwnj;<i class="icon-question-sign pull-right" rel="tooltip" title="Filter sub level categories like cars or type of job"></i></small>
                <select name="sub_cat_id" id="sel_sub_cat_id" class="span12" <?php if(!isset($sub_cat_id) || $sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
                    <?php 
					if(isset($main_cat_id) && $main_cat_id != 0){
						$this->trade_model->get_categories_select('main_cat_id', $main_cat_id, $sub_cat_id);
					}else{
						
						echo '<option value="0">Please Select</option>';
					}
						
					?>
                </select>	
			</div>
			<div class="span4">
				<small>&nbsp;Type<i class="icon-question-sign pull-right" rel="tooltip" title="Now you can specifically select what type of car or brand"></i></small>
				
                <select name="sub_sub_cat_id" id="sel_sub_sub_cat_id" class="span12" <?php if(!isset($sub_cat_id)  || $sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
                    <?php 
					if(isset($sub_cat_id) && $sub_cat_id != 0){
						$this->trade_model->get_categories_select('sub_cat_id', $sub_cat_id, $sub_sub_cat_id);
					}else{
						
						echo '<option value="0">Please Select</option>';
					}
						
					?>
                </select>
				
			</div>
</div> 
<div class="row-fluid">
	
			<div class="span4">
				<small>&zwnj;<i class="icon-question-sign pull-right" rel="tooltip" title="Now you can specifically select model of a brand"></i></small>
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

			<div class="span3">
				<small>&nbsp;Location <i class="icon-question-sign pull-right" rel="tooltip" title="Where do you want to find the item? Select a city"></i></small>
				<?php $this->trade_model->populate_city($location);?>	
			</div>
            
			<div class="span3">
				<small>&nbsp;Suburb <i class="icon-question-sign pull-right" rel="tooltip" title="Where do you want to find the item? Select a city"></i></small>
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


<!--			<div class="span2">
				<div class="row-fluid">
                	<div class="span6">
                        <small>&nbsp;From(N$)</small>
                        <input name="price_from" type="text" class="span12">		 	
					</div>
                    <div class="span6">
                        <small>&nbsp;To(N$)</small>
                        <input name="price_to" type="text" class="span12">
                    </div>
                </div>        		 	
			</div>-->
						
			<div class="span2">
           		 <small>&nbsp;</small>
                 <input type="hidden" name="sort" value="">
                 <input type="hidden" name="offset" value="0">
                 <input type="hidden" name="limit" value="15">
				<button class="btn btn-inverse btn-block" type="submit" id="search_submit"><i class="icon-search icon-white"></i> Search</button>
			</div>
			
		</div>
</form>        



<script type="text/javascript">

$(document).ready(function(){
	
	$('#sel_main_cat_id').bind('change', function(){
			$.get("<?php echo site_url('/');?>trade/get_categories_select/main_cat_id/"+$(this).val()  , function(data){
				  $("#sel_sub_cat_id").html( data ).prop("disabled", false); 
				  $("#sel_sub_sub_cat_id").html( data ).prop("disabled", true);
				  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true);   
			});	
	});	
	$('#sel_sub_cat_id').bind('change', function(){
			$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_cat_id/"+$(this).val()  , function(data){
				  $("#sel_sub_sub_cat_id").html( data ).prop("disabled", false);
				  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true);   
			});	
	});
	
	$('#sel_sub_sub_cat_id').bind('change', function(){
			$.get("<?php echo site_url('/');?>trade/get_categories_select/sub_sub_cat_id/"+$(this).val()  , function(data){
				  $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", false);
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
	
	
});





</script>
            