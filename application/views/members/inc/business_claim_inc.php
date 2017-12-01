<?php



	  $x = rand(1,9);
	  $y = rand(1,9);
?>	  
  
           
             <p>To claim a business listing please start typing the business name below and tell us how you are associated with the business. Our team of human reviewers will
             process your claim and contact you.</p>
               <form action="<?php echo site_url('/')?>business/claim_blank/" method="post" accept-charset="utf-8" id="claim-us" name="claim-us">
                <input type="hidden" name="claim_x" value="<?php echo $x;?>"/>
                <input type="hidden" name="claim_y" value="<?php echo $y;?>"/>
                <input type="hidden" name="claim_client_id" value="<?php echo $this->session->userdata('id');?>"/>
                   <div class="control-group">
                    <label class="control-label" for="business">Select a Business:</label>
                    <div class="controls">
                      <input type="text" class="span5" id="Cbusiness" name="Cbusiness" value="" placeholder="Type business name"/>
                    </div>
                  </div>
                  
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
                
        
         
           
<script type="text/javascript">


<?php
//LOAD BUSINESS TYPEHEAD 
//Get Business Typehead
	
$test = $this->db->where('ISACTIVE','Y');
$test = $this->db->get('u_business');

$result = 'var subjects_business = [';
$x = 0;
foreach($test->result() as $row){
	
	$id = $row->ID;
	$name = str_replace("'",' ',preg_replace("[^A-Za-z0-9]", '', $row->BUSINESS_NAME)) . ' ~ ' . $row->ID;
	
	if($x == ($test->num_rows()-1)){
		
		$str = '';
		
	}else{
		
		$str = ' , ';
		
	}
		
	$result .= "'".$name."' ". $str;
	$x ++; 
	
}

$result .= '];';
echo $result;
?>



$('#claimbut').unbind('click').click(function(e) {
		
		e.preventDefault();
		var frm = $('#claim-us');
		//frm.submit();
		$('#claimbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Claiming...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'business/claim_blank/';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#b_claim_msg').html(data);
				 $('#claimbut').html('<i class="icon-envelope"></i> Claim Business');
				 
				 
			}
		});	

});

$(document).ready(function(){
	
		$.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
			  $('input').placeholder(); 
			  
		});
		
		$('#Cbusiness').typeahead({source: subjects_business})
	
		$('.redactor').redactor({ 	
				
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				 'alignment', '|', 'horizontalrule']
			});	
	
});
</script>
