 <?php 
 //+++++++++++++++++
 //My.Na PRODUCT Search
 //+++++++++++++++++
 //Roland Ihms
 ?>
 <form id="search-product" name="search-product" method="post" action="<?php echo site_url('/');?>trade/search/" class="form-horizontal">
	 <fieldset>
        <div class="span8">
			  <input type="hidden" name="sortby" id="sortby" value="<?php if(isset($sortby)){ echo $sortby;}else{ echo '';}?>" />
              <input class="span8" name="broad" id="broad" onkeyup="load_product_search(this.value)" style="padding:11px;" type="text" value="<?php if(isset($catM)){ echo $catM;}else{ echo '';}?>" autocomplete="off" placeholder="Find Products: Accommodation Products">
              <div id="instant_product" class="popover loading_img"></div>
              <span class="help-block" ><i class="icon-question-sign icon-white" rel="tooltip" title="Select What sort of product you are looking for eg: Accommodation, Electrician"></i></span>
        
        </div>
        <div class="span4">
        
              <input class="span4" name="location" id="location" style="padding:11px;" type="text" value="<?php if(isset($locM)){ echo $locM;}else{ echo '';}?>" autocomplete="off" placeholder="Where? eg: In Windhoek">
              <span class="help-block" ><i class="icon-question-sign icon-white" rel="tooltip" title="Select where in Namibia you are looking for eg: Windhoek, Swakopmund"></i></span>
        
        </div>
        
        <div class="span12">
        	  <div class="clearfix" style="height:20px;"></div>
        	  <button type="submit" id="btn_find" class="btn btn-large pull-right"><b>Find Product</b></button>
              
        </div>
     </fieldset>   
 </form>    
 <div id="typehead_div"></div>
 <script type="text/javascript">
	
	function load_product_search(str){
		
		if(str !=''){
			var div = $('#instant_product');
			div.fadeIn();
			var input = $('#broad');
			div.addClass('loading_img');	
	
			$.get('<?php echo site_url('/'). 'products/instant_product/';?>'+encodeURIComponent(str), function(data) {
				  $('#instant_product').html(data);
				  div.removeClass('loading_img');
				});
		}else{
			
			$('#instant_product').empty().hide();
			
		}
		
	}
	
	$(document).ready(function() {
		
			
			$.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
			  $('input').placeholder(); 
			  
			});
			
	
			/*$.get('<?php echo site_url('/'). 'trade/ajax_load_product/';?>', function(data) {
			  $('#typehead_div').html(data);
			  
			});*/
	});
	$('#btn_find').live('click', function(){
		 
		 $('#btn_find').html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> <b>Finding...</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" >');
		 $('#search-product').delay(200).submit();
	     
	  
	});


 </script>