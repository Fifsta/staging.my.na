<?php



	  $x = rand(1,9);
	  $y = rand(1,9);
?>	  
  
           
             <p>To maintain a business listing under your account please start typing the business name below.</p>
             <p>If your business name does not appear please click on the add business button</p>
             <p> Our team of human reviewers will process your claim and contact you. </p>
         
               <form action="<?php echo site_url('/')?>ntb/claim_blank/" method="post" accept-charset="utf-8" id="claim-us" name="claim-us">
                <input type="hidden" name="claim_x" value="<?php echo $x;?>"/>
                <input type="hidden" name="claim_y" value="<?php echo $y;?>"/>
                <input type="hidden" name="claim_client_id" value="<?php echo $this->session->userdata('id');?>"/>
                   <div class="control-group">
                    <label class="control-label" for="business">Select a Business:</label>
                    <div class="controls">
                      <input type="text" class="span8" id="Cbusiness" autocomplete="off" name="Cbusiness" value="" placeholder="Type business name"/>
                    </div>
                  </div>
                   <div class="control-group">
                    
                    <div class="controls">
                      <div class="alert">
                      <h4>Please Note!</h4>
                          If your business is not found please click on the button to add a business
                          <a href="javascript:void(0)" onclick="switch_claim()" class="btn btn-inverse pull-right">Add Your Business</a>
                          <div class="clearfix" style="height:20px"></div>
                      </div>
                    </div>
                  </div>
                   <div class="control-group">
                    <label class="control-label" for="ntb_reg">NTB registration No:</label>
                    <div class="controls">
                      <input type="text" class="span8" id="ntb_reg" name="ntb_reg" value="" placeholder="eg: NTB08226 "/>
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
		
		if($('#ntb_reg').val().trim().length == 0){
		
			var x = $('#ntb_reg');
			x.focus();
				x.popover({ 
				 placement:"top",html: true,trigger: "manual",
				 title:"NTB Registration required", content:"Please provide us with your unique registration number from the NTB"});
				x.popover('show');
				setTimeout(function() {
					x.popover('hide');
				}, 3000);
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);
		}else{
			
			var frm = $('#claim-us');
			//frm.submit();
			$('#claimbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Claiming...');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/').'ntb/claim_blank/';?>' ,
				data: frm.serialize(),
				success: function (data) {
					
					 $('#claimbut').html('<i class="icon-envelope"></i> Claim Business');
					 $('#b_claim_msg').html(data);
					
					 
					 
				}
			});	
		}
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
