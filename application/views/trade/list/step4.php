<?php
//+++++++++++++++++++++++++++++++++
//STEP 4 Extras
//+++++++++++++++++++++++++++++++++

	$str = '';
	if(isset($bus_id) && $bus_id != 0){
		
		$str = ' for Business';
			
	}
?>
	<div id="anchor_me"></div>


<div class="col-md-12">
    <div class="heading">
        <h2 data-icon="fa-list">Select <strong>Product Extras</strong></h2>
        <ul class="options">

        </ul>
    </div>
</div>


<div class="col-md-12">
    <div class="card">
        <div class="card-body">
	        <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="icon-ok icon-white"></i></a> 
	        <a href="<?php echo site_url('/').'sell/update_product/'.$product_id.'/';?>" class="btn btn-warning disabled  step2" style="margin:5px"> 2 Details <i class="icon-ok icon-white"></i></a>
	        <a href="<?php echo site_url('/').'sell/step3/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-warning disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-ok icon-white"></i></a>
	        <a href="<?php echo site_url('/').'sell/step4/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-success btn-large step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
	        <a href="<?php echo site_url('/').'sell/step5/'.$product_id.'/'.$bus_id.'/';?>" class="btn btn-dark disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>
	        <hr>
        <?php 
        //IF EXTRAS 
        if($has_extras){
            echo $group;
            $this->load->view($group); 
        
        //NO EXTRAS
        }else{

        ?>
            <div class="alert">
                <h4>No extras available for the selected category</h4>
                There are no extras available to set for the selected category. Please make sure the product description describes the product to its fullest
            </div>
            <div>
               <a href="javascript:void(0)" onclick="proceed_to_5()" id="proceed_to_5" class="btn btn-success pull-right">Next</a>
               <a href="<?php echo site_url('/').'members/business/'.$bus_id.'/';?>" onclick="back_to_all();" id="back_to_all" class="btn btn-dark pull-right" style="margin-right:5px">All Products</a>
               <a href="javascript:void(0)"onclick="back_to_3()" id="back_to_3" class="btn btn-warning pull-right" style="margin-right:5px">Back</a>
           		<div class="clearfix">&nbsp;</div>	
            </div>
            
        <?php } ?>

        </div>
    </div>
</div>


    
    <script data-cfasync="false" type="text/javascript">
	
	$(document).ready(function(e) {

		//window.scrollTo(0,$('#anchor_me').offset().top);
		<?php
		 /**
		++++++++++++++++++++++++++++++++++++++++++++
		//SUBMIT STEP 3
		++++++++++++++++++++++++++++++++++++++++++++	
		 */
		 ?> 
		
		$('#add_extras_btn').bind('click', function(e){ 
			
			e.preventDefault();
			var cont = $('#admin_content').addClass('slideLeft'), frm = $('#item-add'), btn = $(this);
			btn.html('Working...');
			//cont.addClass('loading_img'); 
			$.ajax({
					type: 'post',
					cache: false,
					data: frm.serialize(),
					url: '<?php echo site_url('/').'trade/add_extras';?>' ,
					success: function (data) {
						    btn.html('Update Item <i class="icon-chevron-right icon-white"></i>');
							cont.removeClass('slideLeft'); 
							cont.html(data);
							proceed_to_5();
							
					}
				});
		});		
		
    });

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//EXTRAS
++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 	  
	  
	function proceed_to_5(){
		
			var cont = $('#admin_content').addClass('slideLeft');
			  $.get('<?php echo site_url('/'). 'sell/step5/'.$product_id.'/'. $bus_id;?>', function(data) {
					cont.removeClass('slideLeft').html(data);
					
			  });
		
	}
	
	<?php
	   /**
	  ++++++++++++++++++++++++++++++++++++++++++++
	  //BACK
	  ++++++++++++++++++++++++++++++++++++++++++++	
	   */
	   ?> 
	  
	  function back_to_3(){
		  
			  var cont = $('#admin_content').addClass('slideLeft'), btn = $('#back_to_3');
			  btn.html('Working...');
			  $.get('<?php echo site_url('/'). 'sell/step3/'.$product_id .'/'. $bus_id ;?>', function(data) {
					cont.removeClass('slideLeft').html(data);
					btn.html('<i class="icon-chevron-left icon-white"></i> Back');
					
			  });
		  
	  }


	</script>
