  <div class="row">
     <div class="col-md-12">
       <form action="<?php echo site_url('/')?>trade/contact/" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">
        <input type="hidden" id="x" name="x" value="<?php echo $x;?>"/>
        <input type="hidden" id="y" name="y" value="<?php echo $y;?>"/>
        <input type="hidden" name="product_title" value="<?php echo $product_title;?>"/>
        <input type="hidden" name="client_id" value="<?php echo $client_id;?>"/>
        <input type="hidden" name="bus_id" value="<?php echo $bus_id;?>"/>
        <input type="hidden" name="product_id" value="<?php echo $product_id;?>"/>
           <div class="control-group">
            <label class="control-label" for="msg">Message/Enquiry:</label>
            <div class="controls">
              <textarea rows="3"  class="form-control" id="msg" name="msg" placeholder="Ask your Question here."></textarea>
            </div>
          </div>
          
          <div class="control-group">
           
              <span class="help-block" style="font-size:11px">To keep automated bots and trawlers from filling the form<br /> please answer the simple security question</span>
              <label class="checkbox">
                    <input type="checkbox" id="chk_human" value="remember-me"> Are you human?
              </label>
              <span class="help-block" style="font-size:11px">Please check the box to activate the form and block out robots</span>
              <button type="submit" id="contactbut" class="btn btn-dark pull-right" disabled><i class="fa fa-envelope text-light"></i> Ask Question</button>
            
          </div>
        </form>
        <div class="clearfix" style="height:30px;"></div>
        <div id="contact_msg"></div>
        
     </div>
</div>
 
<script data-cfasync="false" type="text/javascript">

	$(document).ready(function(){

		$('#contactbut').click(function(e) {

			e.preventDefault();
			var frm = $('#contact-us');
			//frm.submit();
			$('#contactbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/').'trade/contact/';?>' ,
				data: frm.serialize(),
				success: function (data) {

					$('#contact_msg').html(data);
					$('#contactbut').html('<i class="icon-envelope"></i> Ask Question');


				}
			});

		});

		$('#chk_human').bind('click', function(){

			var chk = $('#contactbut');
			if(chk.prop('disabled') == true){
				chk.prop('disabled',false);
			}else{
				chk.prop('disabled',true);
			}


		});

	});


</script>


