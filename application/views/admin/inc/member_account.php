 <?php 
 //+++++++++++++++++
 //My.Na Account Update
 //+++++++++++++++++
 //Roland Ihms
 //Get Account Details
 $acc_details = $this->admin_model->get_client_row($id);
 
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
 ?>
 <script src="<?php echo base_url('/');?>js/jquery.filestyle.js" type="text/javascript"></script>
 <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

 <h3>User info <small><?php echo $fname . ' ' . $sname; ?></small></h3>
      <div class="clearfix"></div>

<form action="<?php echo site_url('/')?>members/add_avatar" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
 <fieldset>
 <legend>Update Avatar</legend>
      <div class="control-group">
      <div class="controls">
        
  <?php if($img != ''){
	  $fake_file = base_url('/').'assets/users/photos/'.$img;
	   //$fake_file = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/users/photos/'.$img .'&w=100&h=100&q=100';
	   ?>
  
  
    <?php }else{ 
	$fake_file =  base_url('/').'img/user_blank.jpg';
	?>
  
  <?php } ?>
           <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
           <div style="height:100px">
           <span class="avatar-overlay100"></span>
           <img id="avatar" src="<?php echo $fake_file;?>" style="float:left;clear:none;position:absolute;border:1px solid #333333;width:100px; height:100px" />
             <input type="file" class="btn btn-link img-polaroid" id="userfile" name="userfile">
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
<form id="member-update" name="member-update" method="post" action="<?php echo site_url('/');?>my_admin/update_member_do" class="form-horizontal">
 <fieldset>
    <legend>Update Account details</legend>

              <div class="control-group">
                <label class="control-label" for="fname">Name</label>
                <div class="controls">
                        <input type="text" class="span4" id="fname" name="fname" placeholder="First name" value="<?php if(isset($fname)){echo $fname;}?>">
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="sname">Surname</label>
                <div class="controls">
                 	    <input type="text" class="span4" id="sname" name="sname" placeholder="Surname" value="<?php if(isset($sname)){echo $sname;}?>">  
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                 		 <input type="text" class="span4" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>"> 
                </div>
              </div>
              <div class="control-group">
               <label class="control-label" for="radio">Gender</label>
              	<label class="radio">
                  <div class="controls">
                      <input type="radio" name="gender" value="M" <?php if(isset($gender)){ if($gender == 'M'){echo 'checked';}}else{ echo 'checked';}?>>
                      Male
                  </div>
                </label>
                <label class="radio">
                  <div class="controls">
                      <input type="radio" name="gender" value="F" <?php if(isset($gender)){ if($gender == 'F'){echo 'checked';}}?>>
                      Female
                  </div>
              	</label>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="pass1">Password</label>
                <div class="controls">
                        <input type="password" class="span4" id="pass1" name="pass1" placeholder="Password">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="pass2">Confirm</label>
                <div class="controls">
                 		<input type="password" class="span4" id="pass2" name="pass2" placeholder="Confirm Password">  
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="cell">Cellphone</label>
                <div class="controls">
                  		<input type="text" id="cell" class="span4" name="cell" placeholder="eg: 0811234567" value="<?php if(isset($cell)){echo $cell;}?>">
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="country">Country</label>
                <div class="controls">
               		 
                		<select onchange="populateRegion(this.value);" id="country" name="country" class="span4">  
                		 <option value="0" selected="selected">Select a Country</option>
					  <?php 
                      //Get all countries and loop through them
                      //for the select box
                      $countries = $this->admin_model->get_countries();
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
				    $this->admin_model->populate_city($country, $city);
			    }
			  ?>
              </div>
              
              <div id="suburb_div">
               <?php //POPULATE SUBURB PLACEHOLDER 
			   if(isset($suburb)){
				
				if($city == '16'){
				}
				    $this->admin_model->populate_suburb($city ,$suburb);
			    }
			   
			   ?>
              </div>
              
              <div class="control-group">
                <label class="control-label" for="dob">Date of Birth</label>
                <div class="controls">
                 		<input type="text" id="dob" name="dob" class="span4" placeholder="YYYY-MM-DD" value="<?php if(isset($dob)){echo $dob;}?>">   
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
              <input type="hidden" name="id" value="<?php echo $id;?>">
              <div id="result_msg"></div>
              <button type="submit" class="btn-large btn pull-right" id="butt"><b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
               
   </fieldset> 
 </form>
 <script type="text/javascript">

function toggle_note_check(val){
			
	var chk = $('#daily_mail');
	chk.val(val);
}

$('#butt').click(function(e) {
	
	var cell =  document.getElementById("cell").value;
	
	e.preventDefault();
	//Validate
	if(($('#fname').val().length == 0) || ($('#sname').val().length == 0)){
			
		    $('#fname').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a full name, Name and Surname."});
			$('#fname').popover('show');
			$('#fname').focus();
	
	}else if($('#email').val().length == 0){
		
    	    $('#email').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Email Required", content:"Please supply us with a valid email address"});
			$('#email').popover('show');
			$('#email').focus();
	
	//}else if(($('#pass1').val().length == 0) || ($('#pass2').val().length == 0)){
//		
//    	    $('#pass1').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Password Required", content:"Please supply us with a secure password"});
//			$('#pass1').popover('show');
//			$('#pass1').focus();
	
	/*}else if($('#cell').val().length < 10){

	    	$('#cell').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Cellphone Required", content:"Your cellular number is less than 10 digits long!"});
			$('#cell').popover('show');
			$('#cell').focus();

	
	}else if(checkCellphoneValidity()){

		    $('#cell').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Valid Cellphone", content:"Your cellular number does not have a correct prefix. Cellular numbers must begin with a 081/085 or 060!"});
			$('#cell').popover('show');
			$('#cell').focus();
		
	}else if(document.getElementById('country').selectedIndex == 0 ){
		
		    $('#country').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Country Required", content:"Please select your country of residence"});
			$('#country').popover('show');
			$('#country').focus();
		
	}else if($('#dob').val().length == 0){
		
		    $('#dob').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"DOB Required", content:"Please provide us with your date of birth"});
			$('#dob').popover('show');
			$('#dob').focus();*/
		
		
	}else{
		
		submit_form();
		
	}
});


function submit_form(){
		
		var frm = $('#member-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'my_admin/update_member_do';?>' ,
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#butt').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
				
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
	
 $("input[type=file]").filestyle({ 
     image: "<?php echo base_url('/').'img/fake_file.jpg';?>",
     imageheight :100,
     imagewidth :150,
     width :110
 });
 

$('#imgbut').click(function() {
	
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
 
 function avatar_upload_success(url){
	
	$('#avatar').attr('src', url); 
	 
 }
 

</script>