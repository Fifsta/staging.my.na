 <?php 
 //+++++++++++++++++
 //My.Na DEAL Search
 //+++++++++++++++++
 //Roland Ihms
 ?>
 <form id="search-deal" name="search-deal" method="post" action="<?php echo site_url('/');?>deals/search/" class="form-horizontal">
     <fieldset>
            <div class="row-fluid">


                <div class="span8">
                      <input type="hidden" name="sortby" id="sortby" value="<?php if(isset($sortby)){ echo $sortby;}else{ echo '';}?>" />
                      <input class="span12 search_input" name="broad" onkeyup="load_deal_search(this.value)" type="text" value="<?php if(isset($catM)){ echo $catM;}else{ echo '';}?>" autocomplete="off" placeholder="Find Deals: Accommodation Deals">
                      <div id="instant_deal" class="popover loading_img"></div>
                      <span class="help-block" ><i class="icon-question-sign icon-white" rel="tooltip" title="Select What sort of deal you are looking for eg: Accommodation, Electrician"></i></span>
                      <div id="typehead_div"></div>
                </div>
                <div class="span4">

                      <input class="span12 search_input" name="location" type="text" value="<?php if(isset($locM)){ echo $locM;}else{ echo '';}?>" autocomplete="off" placeholder="Where? eg: In Windhoek">
                      <span class="help-block" ><i class="icon-question-sign icon-white" rel="tooltip" title="Select where in Namibia you are looking for eg: Windhoek, Swakopmund"></i></span>

                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                      <div class="clearfix" style="height:5px;"></div>
                      <button type="submit" id="btn_find" class="btn btn-large btn-inverse pull-right"><b>Find</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
                </div>
            </div>
     </fieldset>
 </form>

 <script type="text/javascript">
	
	function load_deal_search(str){
		
		if(str !=''){
			var div = $('#instant_deal');
			div.fadeIn();
			var input = $('#broad');
			div.addClass('loading_img');	
	
			$.get('<?php echo site_url('/'). 'deals/instant_deal/';?>'+encodeURIComponent(str), function(data) {
				  $('#instant_deal').html(data);
				  div.removeClass('loading_img');
				});
		}else{
			
			$('#instant_deal').empty().hide();
			
		}
		
	}
	
	$(document).ready(function() {
		
			
			$.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
			  $('input').placeholder(); 
			  
			});
			
	
			$.get('<?php echo site_url('/'). 'deals/ajax_load_deal/';?>', function(data) {
			  $('#typehead_div').html(data);
			  
			});

            $('#btn_find').live('click', function(){

                $('#btn_find').html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> <b>Finding...</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" >');
                $('#search-deal').delay(200).submit();


            });
	});



 </script>