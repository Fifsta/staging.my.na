<h4>Contact us</h4>
<?php $x = rand(1,5);
	  $y = rand(1,5);
	  
	  if($x == 1){
		$x_1 = 'one';  
	  }elseif($x == 2){
		$x_1 = 'two';   
	  }elseif($x == 3){
		$x_1 = 'three';   
	  }elseif($x == 4){
		$x_1 = 'four'; 
	  }elseif($x == 5){
		$x_1 = 'five';   
	  }
	  
	  if($y == 1){
		$y_1 = 'one';  
	  }elseif($y == 2){
		$y_1 = 'two';   
	  }elseif($y == 3){
		$y_1 = 'three';   
	  }elseif($y == 4){
		$y_1 = 'four'; 
	  }elseif($y == 5){
		$y_1 = 'five';   
	  }	    
  
	  
?>	  
	  
	  	
 <div class="span4">
	<address>
      <strong><?php echo ucwords(filter_var(utf8_decode($BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));?></strong><br>
      <?php echo $BUSINESS_PHYSICAL_ADDRESS;?><br />
      <abbr title="Phone">P:</abbr> <?php echo $BUSINESS_TELEPHONE;?><br />
      <abbr title="Cellphone">C:</abbr> <?php echo $BUSINESS_CELLPHONE;?><br />
      <abbr title="Fax">F:</abbr> <?php echo $BUSINESS_FAX;?><br />
    </address>
    <?php echo $this->business_model->get_qr_vcard($ID,'220','220');?>
        
 </div>
 <div class="span7">
   <form action="<?php echo site_url('/')?>business/contact/<?php echo $ID;?>" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">
    <input type="hidden" id="x" name="x" value="<?php echo $x;?>"/>
    <input type="hidden" id="y" name="y" value="<?php echo $y;?>"/>
    <div class="control-group">
        <label class="control-label" for="name">Full Name</label>
        <div class="controls">
          <input type="text" class="span12" id="name" name="name" placeholder="eg: John Smith">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">Email Address</label>
        <div class="controls">
          <input type="text" class="span12" id="email" name="email" placeholder="eg: john@example.com">
        </div>
      </div>
       <div class="control-group">
        <label class="control-label" for="msg">Message/Enquiry:</label>
        <div class="controls">
          <textarea rows="3"  class="redactor" id="msg" name="msg"></textarea>
        </div>
      </div>
      
      <div class="control-group">
       
          
          <label class="control-label" for="captcha">Security question: (<?php echo $x_1 . ' + ' . $y_1 ; ?>)</label>
           <div class="controls">
          	 <input type="text" id="captcha" class="span1 pull-right" name="captcha" placeholder="<?php echo $x . ' + ' . $y . ' ='; ?>">
     
           </div>
          <span class="help-block" style="font-size:11px">To keep automated bots and trawlers from filling the form<br /> please answer the simple security question</span>
          <label class="checkbox">
                <input type="checkbox" id="chk_human" value="remember-me"> Are you human?
          </label>
 		  <span class="help-block" style="font-size:11px">Please check the box to activate the form and block out robots</span>
          <button type="submit" id="contactbut" class="btn pull-right" disabled><i class="icon-envelope"></i> Send Message</button>
        
      </div>
    </form>
 	<div class="clearfix" style="height:30px;"></div>
    <div id="contact_msg"></div>
    
 </div>
<script type="text/javascript">

$('#contactbut').click(function(e) {
		
		e.preventDefault();
		var frm = $('#contact-us');
		//frm.submit();
		$('#contactbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'business/contact_ajax/'.$ID.'/';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#contact_msg').html(data);
				 $('#contactbut').html('<i class="icon-envelope"></i> Send Message');
				 
				 
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

</script>