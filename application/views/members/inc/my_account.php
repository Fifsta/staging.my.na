<?php 
 //+++++++++++++++++
 //My.Na Account Update
 //+++++++++++++++++
 //Roland Ihms
 //Get Account Details
 $acc_details = $this->members_model->get_my_account($id);
$fname = $acc_details['CLIENT_NAME'];
$sname = $acc_details['CLIENT_SURNAME'];
$email = $acc_details['CLIENT_EMAIL'];
$gender = $acc_details['CLIENT_GENDER'];
$cell = $acc_details['CLIENT_CELLPHONE'];
$dob = $acc_details['CLIENT_DATE_OF_BIRTH'];
$country = $acc_details['CLIENT_COUNTRY'];
$suburb = $acc_details['CLIENT_SUBURB'];
$city = $acc_details['CLIENT_CITY'];
$img = $acc_details['CLIENT_PROFILE_PICTURE_NAME'];
$daily_mail = $acc_details['EMAIL_NOTIFICATION'];
$d_code = $acc_details['DIAL_CODE'];

$verified = $acc_details['VERIFIED'];

if($verified == 'Y'){

	$lock = 'disabled';
	$verifiedHTML ='<button id="verify_btn" onclick="return false;" class="btn btn-success" readonly><i class="icon-ok icon-white"></i> Verified</button>';

}else{

	$lock = '';
	$verifiedHTML = '<a href="'.site_url('/').'clients/verify/" target="_blank" id="verify_btn"  class="btn btn-danger"><i class="icon-remove icon-white"></i> Verify</a>';

}

?>
 <link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
 <script data-cfasync="false" src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

 <h2>General Info</h2>
      <div class="clearfix"></div>
          <p>Welcome to your My.Namibia account. Please update your account details.</p>

<form action="<?php echo site_url('/')?>members/add_avatar" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
 <fieldset>
 <legend>Update Your Avatar</legend>
      <div class="control-group">
      <div class="controls">
        
  <?php 
  		if(strstr($img, "http")){
			$fake_file = $img.'?type=large';
		}elseif($img != ''){
	  		$fake_file = CDN_URL.'assets/users/photos/'.$img;	   //$fake_file = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/users/photos/'.$img .'&w=100&h=100&q=100';
	    }else{ 
			$fake_file =  base_url('/').'img/user_blank.jpg';
	    } ?>
           <input type="hidden" id="id" name="id" value="<?php echo $this->session->userdata('id');?>">
           
           <div class="row-fluid">
               <div style="height:100px;" class="span2">
                  <span class="avatar-overlay100"></span>
                   <img id="avatar" src="<?php echo $fake_file;?>" style="float:left;position:absolute;border:1px solid #333333;width:100px; height:100px" />
               	   <input type="file" class="btn btn-link" id="userfile" name="userfile" style="display:none" >
                   
               </div>
               <div class="span10"> 
               		<a class="btn btn-large" onclick="$('#userfile').click();">Browse</a>
               </div>
            </div>
            
           

        </div>
        <button type="submit"  class="btn btn pull-right" id="imgbut"><i class="icon-user"></i> <?php if($img != ''){ echo 'Update Avatar';}else{ echo 'Add Avatar';} ?></button>
        
      </div>
      </fieldset>
</form>
           <div id="avatar_msg"></div>
             <div class="progress progress-striped active" id="procover" style="display:none">
                  <div class="bar bar-warning" style="width: 0%;"></div>
              </div>
<form id="member-register" name="member-register" method="post" action="<?php echo site_url('/');?>members/update_do" class="form-horizontal">
 <fieldset>
    <legend>Update Your Account details</legend>

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
                 		 <input type="text" class="span8 disabled" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>" readonly>
                </div>
              </div>
               <div class="control-group">
               <label class="control-label" for="gender">Gender</label>
                    <div class="controls">
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" id="male_click" onclick="javascript:togglecheck('M');" class="btn btn-inverse <?php if(isset($gender)){ if($gender == 'M'){echo 'active';}}else{ echo '';}?>">Male</button>
                          <button type="button" id="female_click" onclick="javascript:togglecheck('F');" class="btn btn-inverse <?php if(isset($gender)){ if($gender == 'F'){echo 'active';}}else{ echo '';}?>">Female</button>
                          
                        </div>
                        <input type="hidden" name="gender" id="gender" value="<?php if(isset($gender)){echo $gender;}else{ echo 'M';}?>" />
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
                </div>
              </div>
            
              
              <div class="control-group">
                  <label class="control-label" for="cell">Cellphone</label>
	              <div class="controls">

		              <?php echo $this->my_na_model->get_countries($d_code, false, false, $class = '', $id = '');?>
		              <input type="text" id="cell"  name="cell" placeholder="eg: 0811234567" value="<?php if(isset($cell)){echo $cell;}?>" <?php echo $lock;?>>
		              <?php echo $verifiedHTML;?>

		              <input type="hidden" id="cell_verified" name="cell_verified" value="<?php echo $verified;?>">
		              <span class="help-block" style="font-size:11px">Please only give us your complete cellular number without<br /> any prefixes or dialling codes.</span>
	              </div>
              </div>

              
              <div class="control-group">
                <label class="control-label" for="country">Country</label>
                <div class="controls">
               		
                		 <select onchange="populateRegion(this.value);" id="country" name="country" class="span8">
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
                                   if($ID == $country){ $x = 'selected="selected"';}else{ $x = '';}}else{ $x ='';}
                      ?>
                            
                                 <option onclick="populateRegion(<?php echo $ID; ?>);" <?php echo $x;?> value="<?php echo $ID; ?>"><?php echo $country1; ?></option>
                       
                      <?php 
                          }//end foreach loop
                      } //end if rows for countries ?>
              
               		 </select>
                  
                </div>
              </div>
              <div id="region_div">
              <?php //POPULATE REGION PLACEHOLDER 
			  if(isset($city)){
				
				if($country == '151'){
				}
				    $this->members_model->populate_city($country, $city);
			    }
			  ?>
              </div>
              
              <div id="suburb_div">
               <?php //POPULATE SUBURB PLACEHOLDER 
			   if(isset($suburb)){
				
				if($city == '16'){
				}
				    $this->members_model->populate_suburb($city ,$suburb);
			    }
			   
			   ?>
              </div>
        
              <div class="control-group">
                <label class="control-label" for="dob">Date of Birth</label>
                <div class="controls">
                 		<div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                          <input type="text"  name="dob" id="dobtxt" value="<?php if (isset($dob)){echo date('Y-m-d',strtotime($dob));}else{ echo '1985-10-19';}?>" readonly>
                          <span class="add-on"><i class="icon-calendar"></i></span>
                        </div> 
                </div>
              </div>
              
                 <div class="control-group">
                     <label class="control-label" for="daily_mail">My Na Daily</label>
                          <div class="controls">
                              <div class="btn-group" data-toggle="buttons-radio">
                                <button type="button" id="daily_y" onclick="javascript:toggle_note_check('Y');" class="btn btn-inverse <?php if(isset($daily_mail)){ if($daily_mail == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                                <button type="button" id="daily_n" onclick="javascript:toggle_note_check('N');" class="btn btn-inverse <?php if(isset($daily_mail)){ if($daily_mail == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                                
                              </div>
                              <input type="hidden" name="daily_mail" id="daily_mail" value="<?php echo $daily_mail;?>" />
                              <span class="help-block" style="font-size:11px">Do you want to receive the daily my na email?</span> 
                          </div>
                 </div>
              
              <input type="hidden" name="id" value="<?php echo $this->session->userdata('id');?>">
              <div id="result_msg"></div>
              <button type="submit" class="btn btn-inverse btn-large btn pull-right" name="submit" id="but"><b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
               
   </fieldset> 
 </form>
 
 
 
 
 <script data-cfasync="false" type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>
 <script data-cfasync="false" type="text/javascript">

$(document).ready(function(){
	
	$('#dob').datepicker()

	$('#fl_select').on('click', function(e){
		e.preventDefault();
		console.log($(this).next('.dropdown-toggle'));
		$(this).next('.dropdown-toggle').click();
	});

	$('#but').bind('click', function(e) {

		var cell =  document.getElementById("cell").value;

		e.preventDefault();
		//Validate
		if(($('#fname').val().length == 0) || ($('#sname').val().length == 0)){

			$('#fname').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a full name, Name and Surname."});
			$('#fname').popover('show');
			$('#fname').focus();

		}else if($('#email').val().length == 0){

			$('#email').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Email Required", content:"Please supply us with your unique email address so we can communicate with you"});
			$('#email').popover('show');
			$('#email').focus();

			//}else if(($('#pass1').val().length == 0) || ($('#pass2').val().length == 0)){
//
//    	    $('#pass1').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Password Required", content:"Please supply us with a secure password"});
//			$('#pass1').popover('show');
//			$('#pass1').focus();

		}else if($('#cell').val().length < 8){

			$('#cell').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Cellphone Required", content:"Your cellular number is less than 10 digits long! We require your unique cell number to send you periodic updates, specials and announcements"});
			$('#cell').popover('show');
			$('#cell').focus();


		}else if(checkCellphoneValidity()){

			$('#cell').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Valid Cellphone", content:"Your cellular number does not have a correct prefix. Cellular numbers must begin with a 081/085 or 060!"});
			$('#cell').popover('show');
			$('#cell').focus();

		}else if(document.getElementById('country').selectedIndex == 0 ){

			$('#country').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Country Required", content:"We need to know where you live. Please select your country of residence below."});
			$('#country').popover('show');
			$('#country').focus();

		}else if($('#dobtxt').val().length == 0){

			$('#dob').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"DOB Required", content:"Please tell us your date of birth so we can categorise your profile and send you special offers in the future"});
			$('#dob').popover('show');
			$('#dob').focus();
		}else{

			submit_form();

		}
	});




	$('#imgbut').bind('click', function() {

		var avataroptions = {
			target:        '#avatar_msg',
			url:       	   '<?php echo site_url('/').'members/add_avatar_ajax';?>' ,
			beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				probar.width(percentVal)

			},
			complete: function(xhr) {
				procover.hide();
				probar.width('0%');
				$('#avatar_msg').html(xhr.responseText);
				console.log(xhr.responseText);
				$('#imgbut').html('<i class="icon-user"></i> Update Avatar');
			}

		};

		var frm = $('#add-img');
		var probar = $('#procover .bar');
		var procover = $('#procover');

		$('#imgbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Uploading...');
		procover.show();
		frm.ajaxForm(avataroptions);
	});

});

function togglecheck(val){
			
	var chk = $('#gender');
	chk.val(val);
}
function toggle_note_check(val){
			
	var chk = $('#daily_mail');
	chk.val(val);
}



function submit_form(){
		
		var frm = $('#member-register');
		//frm.submit();
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'members/update_do';?>' ,
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#but').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
			}
		});	

}
function checkCellphoneValidity()
	{
		console.log($('#dial_code').val() );
		if($('#dial_code').val() == '264'){
			var str1 = $('#cell').val();
			var str2 = str1.split(' ').join('');
			var cellNum = str2.substring(0, 2);
			//alert(cellphoneNumber.substring(0, 3));
			switch(cellNum)
			{
				case '08':

					return false;
					break;
				case '81':

					return false;
					break;
				case '08':

					return false;
					break;
				case '85':

					return false;
					break;
				case '60':

					return false;
					break;
				case '06':

					return false;
					break;
				default:
					return true;
			}

		}else{

			return false;
		}


		
	}
	
	//window.onload = function(){
//		new JsDatePick({
//			useMode:2,
//			target:"inputField",
//			dateFormat:"%Y-%m-%d",
//			limitToToday:true
//			/*selectedDate:{				This is an example of what the full configuration offers.
//				day:5,						For full documentation about these settings please see the full version of the code.
//				month:9,
//				year:2006
//			},
//			yearsRange:[1978,2020],
//			
//			cellColorScheme:"beige",
//			dateFormat:"%m-%d-%Y",
//			imgPath:"img/",
//			weekStartDay:1*/
//		});
//	};
	
	function populateRegion(countryID)
	{	
		
		if(countryID == 151){
		$("#region_div").html('<div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div>');
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
		$("#suburb_div").html('<div class="span8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div>');
		$.ajax({
		   url: "<?php echo site_url('/');?>members/populate_suburb/"+cityID+"/0/",
		  success: function(data) {
			$("#suburb_div").html(data);
			//includeJS('js/microsite.show.js');
		  }
		});	
	}

 

 
 function avatar_upload_success(url){
	
	$('#avatar').attr('src', url); 
	 
 }
 

</script>