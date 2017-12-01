

    <form action="<?php echo site_url('/')?>business/submit_review_response/<?php echo $BUSINESS_ID;?>" style="margin-bottom:0; padding-bottom:0" id="respond_review" name="respond_review">
      <div class="modal-header">
        <a href="javascript:void(0)" onclick="$('#modal-respond').modal('hide')" class="close">&times;</a>
        <h3>Respond to the review</h3>
      </div>
       <div class="modal-body">
         <div class="span5">
    
            <input type="hidden" name="bus_id" value="<?php echo $BUSINESS_ID;?>"/>
        	<input type="hidden" name="client_id" value="<?php echo $CLIENT_ID;?>"/>
            <input type="hidden" name="review_id" value="<?php echo $ID;?>"/>
                
             <div class="control-group">
                <label class="control-label" for="claim_msg">Response:</label>
                <div class="controls">
                  <textarea rows="3"  class="redactor" id="response_msg" name="response_msg"></textarea>
                </div>
              </div>
              
              <div class="control-group">

                  <div class="clearfix" style="height:40px;"></div>
                  <div id="b_claim_msg"></div>
              </div>
              
            
         </div>
       </div>
      <div class="modal-footer">
        <button type="submit" id="respondbut" class="btn"><i class="icon-comment"></i> Respond</button>
          <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
      </div>
     </form>  

  
 
 						
<script data-cfasync="false" type="text/javascript">

$(document).ready(function(){
	
	$('.redactor').redactor({ 	
				
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|']
	});

    $('#respondbut').bind('click' ,function(e) {

        e.preventDefault();
        var frm = $('#respond_review');
        //frm.submit();
        $('#respondbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Responding...');
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('/').'business/submit_review_response/'.$ID.'/';?>' ,
            data: frm.serialize(),
            success: function (data) {
                $('#respondbut').html('<i class="icon-envelope"></i> Respond');
                $('#b_claim_msg').html(data);



            }
        });

    });


});


</script>