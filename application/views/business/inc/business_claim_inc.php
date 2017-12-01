
<?php $x = rand(1,9);
	  $y = rand(1,9);
?>	  
  
 <div class="span5">
 <p>To claim this business listing please tell us how you are associated with the business. Our team of human reviewers will
 process your claim and contact you.</p>
   <form action="<?php echo site_url('/')?>business/claim/<?php echo $bus_id;?>" method="post" accept-charset="utf-8" id="claim-us" name="claim-us">
    <input type="hidden" name="claim_x" value="<?php echo $x;?>"/>
    <input type="hidden" name="claim_y" value="<?php echo $y;?>"/>
    <input type="hidden" name="claim_client_id" value="<?php echo $this->session->userdata('id');?>"/>
   		
       <div class="control-group">
        <label class="control-label" for="claim_msg">Message/Enquiry:</label>
        <div class="controls">
          <textarea rows="3"  class="redactor" id="claim_msg" name="claim_msg"></textarea>
        </div>
      </div>
      
      <div class="control-group">
       
          
          <label class="control-label" for="claim_captcha">Security question: (<?php echo $x . ' + ' . $y ; ?>)</label>
           <div class="controls">
          	 <input type="text" id="claim_captcha" class="span1 pull-right" name="claim_captcha" placeholder="<?php echo $x . ' + ' . $y . ' ='; ?>">
           </div>
          <span class="help-block" style="font-size:11px">To keep automated bots and trawlers from filling the form<br /> please answer the simple security question</span>
          <button type="submit" id="claimbut" class="btn pull-right"><i class="icon-envelope"></i> Claim Business</button>
          <div class="clearfix" style="height:40px;"></div>
          <div id="b_claim_msg"></div>
      </div>
    </form>
 	
    
    
 </div>
<script type="text/javascript">

$('#claimbut').unbind('click').click(function(e) {
		
		e.preventDefault();
		var frm = $('#claim-us');
		//frm.submit();
		$('#claimbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Claiming...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'business/claim/'.$bus_id.'/';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#b_claim_msg').html(data);
				 $('#claimbut').html('<i class="icon-envelope"></i> Claim Business');
				 
				 
			}
		});	

});
</script>