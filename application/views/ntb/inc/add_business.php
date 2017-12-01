<div class="span12">
    <form id="business-add" name="business-add" method="post" action="<?php echo site_url('/');?>ntb/add_business_do_ajax" class="form-horizontal">
     <button type="button" class="close pull-right" onclick="switch_claim()" data-dismiss="alert">&times;</button>
     <fieldset>
     
        <legend>Add Your Business Details</legend>

                  <div class="control-group">
                    <label class="control-label" for="name">Business Name</label>
                    <div class="controls">
                            <input type="text" class="span8" id="name" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
                    </div>
                  </div>
                  
                   <div class="control-group">
                    <label class="control-label" for="ntb_reg">NTB registration No:</label>
                    <div class="controls">
                      <input type="text" class="span8" id="ntb_teg" name="ntb_teg" value="" placeholder="eg: NTB08226 "/>
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                             <input type="text" class="span8" id="email" name="email" placeholder="Email" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">   
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="tel">Telephone</label>
                    <div class="controls">
                            <input type="text" id="tel" class="span8" name="tel" placeholder="eg: 061231234" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="fax">Fax</label>
                    <div class="controls">

                            <input type="text" id="fax" class="span8" name="fax" placeholder="eg: 061231234" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>"> 
                    </div>
                  </div>

                  
                  <div class="control-group">
                    <label class="control-label" for="cell">Cellphone</label>
                    <div class="controls">
                            <input type="text" id="cell" class="span8" name="cell" placeholder="eg: 0811234567" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>"> 
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="url">Website</label>
                    <div class="controls">
                            <input type="text" id="url" class="span8" name="url" placeholder="eg: www.example.com.na" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
                    </div>
                  </div>
                   
                    <div class="control-group">
                    <label class="control-label" for="pobox">PO BOX</label>
                    <div class="controls">
                            <input type="text" id="pobox" class="span8" name="pobox" placeholder="eg: 9012 Windhoek" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="address">Physical Address</label>
                    <div class="controls">
                        
                            <input type="text" id="address" class="span8" name="address" placeholder="eg: 12 Sam Nujoma Drive" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>"/>
                    </div>
                  </div>
                   <legend>Add Your Business Description</legend>
                   
                  <textarea class="redactor" id="redactor_content" name="content" style="display:none" ><?php if(isset($BUSINESS_DESCRIPTION)){echo $BUSINESS_DESCRIPTION;}?></textarea>
             
                  
                 <div style="height:20px; clear:both"></div>
                  <input type="hidden" name="id" value="<?php echo $this->session->userdata('id');?>">
                  <div id="result_msg"></div>
                  <div style="height:20px; clear:both"></div>
                  <button type="submit" class="btn-large btn pull-right" name="submit" id="but"><b>Add</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
                   
       </fieldset> 
     </form>

			
         </div> 
       

 
<script type="text/javascript">


$('#but').click(function(e) {
	
	e.preventDefault();
	
	var cell =  document.getElementById("cell").value;
	
	
	//Validate
	if(($('#name').val().length == 0)){
		
		var x = $('#name');
		x.focus();
			x.popover({ 
			 placement:"top",html: true,trigger: "manual",
			 title:"Business name required", content:"Please provide us with your full business name"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
			 
	}else if($('#email').val().length == 0){
		
    	var x = $('#email');
		x.focus();
			x.popover({ 
			 placement:"top",html: true,trigger: "manual",
			 title:"Business email required", content:"Please provide us with a unique business email address"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);	
	}else if($('#ntb_teg').val().length == 0){
		
    	var x = $('#ntb_teg');
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
	
	}else if($('#address').val().length < 6){
		
    	var x = $('#address');
		x.focus();
			x.popover({ 
			 placement:"top",html: true,trigger: "manual",
			 title:"Address required", content:"Where is your business located."});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
		
	}else{
		
		//var frm = $('#business-add');
		//frm.submit();
		submit_form();
		
	}
});


function submit_form(){
		
		var frm = $('#business-add');
		//frm.submit();
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'ntb/add_business_do_ajax';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#but').html('<b>Add</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}

function redirectbusiness(id,msg){
	
	$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Redirecting...');
	
		setTimeout(function() {
		  window.location.href = "<?php echo site_url('/');?>members/business/"+id+"/"+msg;
		}, 2000);
	
}


function checkCellphoneValidity()
	{
		var str1 = $('#cell').val();
		var str2 = str1.split(' ').join('');
		var cellNum = str2.substring(0, 3);
		//alert(cellphoneNumber.substring(0, 3));
		switch(cellNum)
		{
		case '081':
		  
		  return false;
		  break;
		case '085':
		 
		  return false;
		  break;
		case '060':
		  
		  return false;
		  break;
		default:
		  return true;
		}
		
	}


<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//FIRE EDITOR
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
  
$(document).ready(
	function()
	{
		$('.redactor').redactor({ 	

				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				'video', 'table','|',
				 'alignment', '|', 'horizontalrule']
		});
		$('[rel=tooltip]').tooltip();
	 
	}
);

<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//TIMELINE SCROLL SPY
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>

</script>
