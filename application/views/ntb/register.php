 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = 'Create an Account - My Namibia &trade;';
 $header['metaD'] = '';
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap-image-gallery.min.css">
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<style type="text/css">

.help-block{color:#fff}

form input[type=text],form input[type=password],form input[type=tel],form input[type=email]{height:40px;font-size:20px; line-height:30px;margin-top:-10px;}
label{font-size:15px; font-weight:bold}
select{height:45px;font-size:20px; line-height:40px;margin-top:-10px;}
</style> 
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = 'account';
 //$this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div class="clearfix" style="height:10px;"></div>
      <div class="container" id="home_container">

      <div class="row-fluid">
           		
               
                <div class="span8">
                	<h1 class="na_script" style="font-size:80px;margin-top:20px;line-height:90px">Dear NTB Industry Partner</h1>
                   <p style=" font-size:16px;">
                    This is the official NTB industry partner registration page .<br /><br />
                    If you do not already have a My Namibia personal profile please register below and complete all fields in order to register successfully . 
                    Please note that once you have registered you will receive a confirmation e-mail from My Namibia with your login details as well as a e-mail confirmation link . <br /><br />
                    You will then be able to login with your e-mail address as username and registered password . 
                    NB : Your personal profile will not automatically have your business profile linked to it .
                    Please click on the claim business tab in the left hand corner of your personal profile and select your business when typing in the name within the selection box . It will take 12 - 24 hours before your business is successfully linked to your personal profile
                  </p>
                  <h1 class="na_script">1. <font size="5">Create a My.na Personal Account</font></h1>
                  <h1 class="na_script">2. <font size="5">Find your NTB registered business via My.Na or Add the business</font></h1>
                  <h1 class="na_script">3. <font size="5">Wait for authorization and Update your Business!</font></h1>
           		</div>
                <div class="span4">

                   <img src="<?php echo base_url('/');?>img/icons/ntb_big.png" />
           		</div> 
      </div>

      
<!--      <div class="row-fluid">
           		
                <div class="span8">
                	<h1 class="na_script" style="font-size:80px;line-height:90px">Manage Reviews and HAN Evaluations</h1>
                   <p>Manage all your Hospitality Association of Namibia reviews and evaluations right here.</p>
           		</div>                
                <div class="span4 text-center">
                	<img src="<?php echo base_url('/');?>img/icons/han_big.png" />
           		</div>
      </div>-->	
      
   	
      <div class="row">
        <div class="span12">
        	<h2 class="na_script" style="font-size:50px;line-height:90px">Register Below</h2>
        <div>
 			
            <div class="clearfix"></div>
                  
                  
                  <p>Please complete all fields below in order to complete your registration. If you have already registered with your e-mail address you will not be able to register again.</p>
        
                  
                  <?php if(isset($error)){ ?>
                    <div class="alert alert-error">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error; ?>
                    </div>
                    <?php
                    }//end error
                    if(isset($basicmsg)){ ?>
                    <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $basicmsg; ?>
                    </div>
                    <?php
                    }
                    ?>
                 <?php 

				 //+++++++++++++++++
				 //My.Na Registration Form
				 //+++++++++++++++++
				 //Roland Ihms
				 //Security Questions
				 $z = rand(1,9);
				 $y = rand(1,9);
				 ?>
				
				
				<form id="member-register" name="member-register" method="post" action="<?php echo site_url('/');?>ntb/register_do_ajax" class="form-horizontal">
				 <fieldset>
						<div class="clearfix" style="height:40px;"></div>
                              <div class="control-group">
                              	 <div class="controls">
                                 	<h5>Business Details</h5>
                                 </div>
                               </div>     
                              <div class="control-group">
                                <label class="control-label" for="bname">Business Name</label>
                                <div class="controls">
                                        <input type="text" class="span8" id="bname" name="bname" autocomplete="off" placeholder="eg: Hotel Thule" value="<?php if(isset($bname)){echo $bname;}?>">
                                </div>
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="ntb_reg">NTB Registration Number</label>
                                <div class="controls">
                                        <input type="text" class="span8" id="ntb_reg" name="ntb_reg" placeholder="eg:NTB156772" value="<?php if(isset($bname)){echo $bname;}?>">
                                </div>
                              </div> 
                              <div class="control-group">
                              	 <div class="controls">
                                 	<h5>Personal Details</h5>
                                 </div>
                               </div>      
                              <div class="control-group">
								<label class="control-label" for="fname">Name</label>
								<div class="controls">
										<input type="text" class="span8" id="fname" name="fname" placeholder="First name" value="<?php if(isset($fname)){echo $fname;}?>">
								</div>
							  </div>
				
							  <div class="control-group">
								<label class="control-label" for="sname">Surname</label>
								<div class="controls">
										<input type="text" class="span8" id="sname" name="sname" placeholder="Surname" value="<?php if(isset($sname)){echo $sname;}?>">
								</div>
							  </div>
							  
							  
							  <div class="control-group">
								<label class="control-label" for="email">Email</label>
								<div class="controls">
										 <input type="text" class="span8" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
										<span class="help-block" style="font-size:11px">This is your accounts unique identifier, must be unique</span> 
								</div>
								
							  </div>
							  
							  <div class="control-group">
							   <label class="control-label" for="gender">Gender</label>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons-radio">
										  <button type="button" id="male_click" onClick="javascript:togglecheck('M');" class="btn btn-large btn-inverse active">Male</button>
										  <button type="button" id="female_click" onClick="javascript:togglecheck('F');" class="btn btn-large btn-inverse">Female</button>
										  
										</div>
										<input type="hidden" name="gender" id="gender" value="M" />
										<span class="help-block" style="font-size:11px">Are you male or female?</span> 
									</div>
							  </div>


							  <div class="control-group">
								<label class="control-label" for="pass1">Password</label>
								<div class="controls">
										<input type="password" class="span8" id="pass1" name="pass1" placeholder="Password">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="pass2">Confirm</label>
								<div class="controls">
										<input type="password" class="span8" id="pass2" name="pass2" placeholder="Confirm Password">
										<span class="help-block" style="font-size:11px">Confirm your password and choose a safe combination<br /> of letters, symbols and numbers</span> 
								</div>
							  </div>
							  
							  
							  <div class="control-group">
								<label class="control-label" for="cell">Cellphone</label>
								<div class="controls">
										<input type="text" id="cell" class="span8" name="cell" placeholder="eg: 0811234567" value="<?php if(isset($cell)){echo $cell;}?>">
										<span class="help-block" style="font-size:11px">Please only give us your complete cellular number without<br /> any prefixes or dialling codes.</span>
								</div>
							   
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="country">Country</label>
								<div class="controls">
									 
										<select onChange="populateRegion(this.value);" id="country" name="country" class="span8">  
										 <option value="0" selected="selected">Select a Country</option>
									  <?php 
									  //Get all countries and loop through them
									  //for the select box
									  $countries = $this->members_model->get_countries();
									  if ($countries->num_rows() != 0 ) { 
										  foreach($countries->result() as $row){
											  $country1 = $row->COUNTRY_NAME;
											  $code = $row->COUNTRY_CODE;
											  $ID = $row->ID;
												  //see if country has been selected
												   if(isset($country)){
												   if($country1 == $country){ $x = 'selected="selected"';}else{ $x = '';}}else{ $x ='';}
									  ?>
											
												 <option <?php echo $x;?> value="<?php echo $ID; ?>"><?php echo $country1; ?></option>
									   
									  <?php 
										  }//end foreach loop
									  } //end if rows for countries ?>
							  
									 </select>
								  <span class="help-block" style="font-size:11px">Please select you current country of residence</span>
								</div>
							  </div>
							  
							  <?php //POPULATE REGION PLACEHOLDER ?>
							  <div id="region_div"></div>
							  
							   <?php //POPULATE SUBURB PLACEHOLDER ?>
							  <div id="suburb_div"></div>
				
				
							  <div class="control-group">
								<label class="control-label" for="dob">Date of Birth</label>
								<div class="controls">
										 <div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
										  <input type="text"  name="dob" id="dobtxt" value="<?php if (isset($dob)){echo date('Y-m-d',strtotime($dob));}else{ echo '1985-10-19';}?>" readonly>
										  <span class="add-on" style="padding:0px 10px 28px 10px; margin-top:-10px;"><i style="margin-top:15px;" class="icon-calendar"></i></span>
										</div> 
										<span class="help-block" style="font-size:11px">Select your date of birth by clicking on the calendar icon</span>
								</div>
								
							   
								
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="security">Security (<?php echo $z . ' + ' . $y;?>)</label>
								<div class="controls">
										<input type="text" id="security" name="security" class="span3" placeholder="What is the sum of <?php echo $z . ' + ' . $y;?>">
										<span class="help-block" style="font-size:11px">To keep automated bots and trawlers from filling the form<br /> please answer the simple security question</span>   
								</div>
							  </div>
							  <input type="hidden" id="x" name="x" value="<?php echo $z;?>"/>
							  <input type="hidden" id="y" name="y" value="<?php echo $y;?>"/>
							  <div id="result_msg"></div>
							  <button type="submit" class="btn-large btn-inverse pull-right" name="submit" id="but"><b>Join</b> </button>
							   
				   </fieldset> 
				 </form>

               
          
          </div>
      
        </div>
       
       
       
      </div>
     </div>
	  
    <!-- /container - end content --> 
		<div class="clearfix" style="height:290px;"></div>




<div id="modal-video" class="modal hide fade modal-fullscreen" tabindex="-1">
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a> 
    </div>
    <div class="modal-body" style="overflow:hidden">
    	   <iframe width="560" height="400" src="http://www.youtube.com/embed/qDWLFsX-xNA?rel=0" frameborder="0" allowfullscreen></iframe>
   </div>
   
</div>

 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>
</div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>  
 <script type="text/javascript">



<?php
//LOAD BUSINESS TYPEHEAD 
//Get Business Typehead

$test = $this->db->get('u_business');

$result = 'var subjects_business = [';
$x = 0;
foreach($test->result() as $row){
	
	$id = $row->ID;
	$name = str_replace("'",' ',preg_replace("[^A-Za-z0-9]", '', $row->BUSINESS_NAME));
	
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


$(document).ready(function(){
	
	$('#dob').datepicker()	
	$('#bname').typeahead({source: subjects_business})
});


function togglecheck(val){
			
	var chk = $('#gender');
	chk.val(val);
}

$('#but').click(function(e) {
	
	ans = document.getElementById("security").value; 
	x = document.getElementById("x").value;
	y = document.getElementById("y").value;
	var cell =  document.getElementById("cell").value;
	
	z = ( parseInt(x) +  parseInt(y));
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
	
	}else if($('#email').val().length == 0){
		
    	var x = $('#email');
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
	
	}else if(($('#pass1').val().length == 0) || ($('#pass2').val().length == 0)){
		
    	var x = $('#pass1');
		x.focus();
			x.popover({
			 placement:"top",html: true,trigger: "hover",
			 title:"Password required", content:"Please set a strong password and confirm it"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
			 
	}else if($('#pass1').val() != $('#pass2').val()){
		
    	var x = $('#pass2');
		x.focus();
			x.popover({
			 placement:"top",html: true,trigger: "hover",
			 title:"Password doesnt match", content:"Please make sure your password is matching"});
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
		
	}else if(document.getElementById('country').selectedIndex == 0 ){
		
    	var x = $('#country');
			x.focus();
				x.popover({
				 placement:"top",html: true,trigger: "manual",
				 title:"Country Required", content:"We need your current country of residence"});
				x.popover('show');
				setTimeout(function() {
					x.popover('hide');
				}, 3000);
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);
		
	}else if($('#dobtxt').val().length == 0){
		
    	var x = $('#dobtxt');
			x.focus();
				x.popover({ 
				 placement:"top",html: true,trigger: "manual",
				 title:"Date of birth required", content:"When where you born. to provide you with age specific deals we require this information"});
				x.popover('show');
				setTimeout(function() {
					x.popover('hide');
				}, 3000);
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);
		
	}else if($('#security').val().length == 0){
		
    	var x = $('#security');
			x.focus();
				x.popover({ 
				 placement:"top",html: true,trigger: "manual",
				 title:"Security question required", content:"Please answer the security question below"});
				x.popover('show');
				setTimeout(function() {
					x.popover('hide');
				}, 3000);
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);					
		
	}else if(ans != z){
		
		var x = $('#security');
			x.focus();
				x.popover({ 
				 placement:"top",html: true,trigger: "manual",
				 title:"No match!", content:"Your answer does not match. Please add <?php echo $x . ' + ' . $y;?> together and try again"});
				x.popover('show');
				setTimeout(function() {
					x.popover('hide');
				}, 3000);
				$('html, body').animate({
					 scrollTop: (x.offset().top - 200)
				 }, 300);		
		
	}else{
		
		submit_form();
		
	}
});


function submit_form(){
		
		var frm = $('#member-register');
		//frm.submit();
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'ntb/register_do_ajax';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#but').html('<b>Join</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}

function redirectpreview(){
	
	$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Redirecting...');
	
		setTimeout(function() {
		  window.location.href = "<?php echo site_url('/');?>ntb/";
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
	

	function populateRegion(countryID)
	{	
		
		if(countryID == 151){
		$("#region_div").html('<div class="control-group"><div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div></div>');
		}
		$.ajax({
		  url: "<?php echo site_url('/');?>members/populate_city/"+countryID+"/0/",
		  success: function(data) {
			$("#region_div").html(data);
			//includeJS('js/microsite.show.js');
		  }
		});	
	}
	
	function populateSuburb(cityID)
	{
		$("#suburb_div").html('<div class="control-group"><div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div></div>');
		$.ajax({
		   url: "<?php echo site_url('/');?>members/populate_suburb/"+cityID+"/0",
		  success: function(data) {
			$("#suburb_div").html(data);
			//includeJS('js/microsite.show.js');
		  }
		});	
	}
</script>

</body>
</html>