 <?php 
 //+++++++++++++++++
 //My.Na Registration Form
 //+++++++++++++++++
 //Roland Ihms
 //Security Questions

 ?>

<div class="clearfix"></div>

<form id="member-register" name="member-register" method="post" action="<?php echo site_url('/');?>volleyball/register_do_ajax" >
 <fieldset style="border:none;">
  		<input type="hidden" name="rep_id" id="rep_id" value="<?php if(isset($rep_id)){ echo $rep_id;}else{ echo '0';} ?>" />
    	<div class="clearfix" ></div>
              <div class="control-group">
				<img src="<?php echo S3_URL;?>scratch_card/expo2013/images/register.png" />
                <div class="controls">
                        <input type="text" class="span12" id="fname" name="fname" placeholder="First name" value="<?php if(isset($fname)){echo $fname;}?>">
                </div>
              </div>

              <div class="control-group">
             
                <div class="controls">
                 	    <input type="text" class="span12" id="sname" name="sname" placeholder="Surname" value="<?php if(isset($sname)){echo $sname;}?>">
                </div>
              </div>
              
              
              <div class="control-group">
               
                <div class="controls">
                 		 <input type="email" class="span12" id="emailc" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
                		
                </div>
                
              </div>
              
             <!-- <div class="control-group">
            
                <div class="controls">
                 		
                          <input type="text" class="span12"  name="dob" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years" value="" placeholder="Date Of Birth" readonly="">
                          
                         
                        
                </div>
 
              </div>-->
              
<!--              <div class="control-group">

                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" id="male_click" onclick="javascript:togglecheck('M');" class="btn btn-inverse active big_btn">Male</button>
                          <button type="button" id="female_click" onclick="javascript:togglecheck('F');" class="btn btn-inverse big_btn">Female</button>
                          
                        </div>
                        <input type="hidden" name="gender" id="gender" value="M" />

					</div>
              </div>-->
 
               
              
              <div class="control-group">
              <div style="height:10px;" class="clearfix"></div>
                <div class="controls">
                  		<input type="tel" id="cell" class="span12" name="cell" placeholder="eg: 0811234567" value="<?php if(isset($cell)){echo $cell;}?>">
                       
                </div>
               
              </div>

				<div class="row-fluid">
                	<div class="span4" style="margin-top:5px;">
                    <button type="button" class="btn btn-large btn-block btn-inverse" name="submit" id="but" value="Join">Join My Na</button>
                    
                    </div>
                	<div class="span8"  style="margin-top:5px;">
                    <a class="btn btn-large btn-inverse but_back"><i class="icon-chevron-left icon-white"></i> Back </a>
                    </div>
                </div>

             
              
            
              <div id="result_msg"></div>
              
              
              
              
   </fieldset> 
 </form>
 <script type="text/javascript">

$(document).ready(function(){
	
	$('#dob').datepicker()	

});



function togglecheck(val){
			
	var chk = $('#gender');
	chk.val(val);
}

$('#but').bind("click touch",function(e) {
	
    
	//var cell =  document.getElementById("cell").value;
	
	e.preventDefault();
	//Validate
	if(($('#fname').val().length == 0) || ($('#sname').val().length == 0)){
		
		var x = $('#fname');
		x.focus();
			x.popover({ 
			 placement:"top",html: true,trigger: "manual",
			 title:"Full name required", content:"Please provide us with your full name"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
	
	}else if($('#emailc').val().length == 0){
		
    	var x = $('#emailc');
		x.focus();
			x.popover({ 
			 placement:"top",html: true,trigger: "manual",
			 title:"email required", content:"Please provide us with a working email address"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
	
	
	}else if($('#cell').val().length < 10){
		
    	var x = $('#cell');
		x.focus();
			x.popover({ 
			 placement:"top",html: true,trigger: "manual",
			 title:"Valid cellphone number", content:"Your cellphone number is less than 10 digits"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
	
	}else if(checkCellphoneValidity()){
	
		var x = $('#cell');
			x.focus();
				x.popover({
				 placement:"top",html: true,trigger: "manual",
				 title:"Valid cellphone number", content:"Your cellular number does not have a correct prefix. Cellular numbers must begin with a 081/085 or 060!"});
				x.popover('show');
				setTimeout(function() {
					x.popover('hide');
				}, 3000);
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);
	
	//}else if($('#dob').val().length == 0){
//		
//    	var x = $('#dob');
//			x.focus();
//				x.popover({ 
//				 placement:"top",html: true,trigger: "manual",
//				 title:"Date of birth required", content:"When where you born. to provide you with age specific deals we require this information"});
//				x.popover('show');
//				setTimeout(function() {
//					x.popover('hide');
//				}, 3000);
//				$('html, body').animate({
//					 scrollTop: (x.offset().top - 200)
//				 }, 300);
//		
//	
		
	}else{
		
		submit_form();
		
	}
});


function submit_form(){
		
		var frm = $('#member-register');
		//frm.submit();
		$('#but').html('Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'volleyball/register_do_ajax';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#but').html('Join My Na');
				
			}
		});	

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
	

	
</script>