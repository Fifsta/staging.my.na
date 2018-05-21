<?php 
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++

$_uname = '';
if($this->session->userdata('u_name')){ $_uname = 'My Namibia Profile - '.ucfirst($this->session->userdata('u_name'));}
$header['title'] = $_uname;
$header['metaD'] = 'Home feed for '. $_uname;
$this->load->view('members/inc/header', $header);

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

if(strstr($img, "http")){

  $fake_file = $img.'?type=large';

}elseif($img != ''){

  $fake_file = S3_URL.'assets/users/photos/'.$img; 
 
}else{ 

  $fake_file =  base_url('/').'images/user_blank.jpg';

}

$verified = $acc_details['VERIFIED'];

if($verified == 'Y'){

  $lock = 'disabled';
  $verifiedHTML ='<button id="verify_btn" onclick="return false;" class="btn btn-success" readonly><i class="fa fa-check text-light"></i> Verified</button>';

}else{

  $lock = '';
  $verifiedHTML = '<a href="'.site_url('/').'clients/verify/" target="_blank" id="verify_btn" class="btn btn-danger"><i class="fa fa-times-circle-o text-light"></i> Verify</a>';

}

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag
?>

<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
</head>
<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">My.na</a></li>
      </ol>
  </div>
</nav>

<div class="container">
  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-3" id="sidebar">
      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather'); ?>
      <?php $this->load->view('inc/adverts'); ?>
    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">
      <div class="row">
        <div class="col-md-12">

          <section id="listing">

              <div class="heading" style="margin-bottom:15px">
                <h2 data-icon="fa-user">My Profile</h2>
              </div>
            
              <section class="results-item">

                <form action="<?php echo site_url('/')?>members/add_avatar" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">
                <div>

                  <figure>
                    <a href="#"><img src="<?php echo $fake_file; ?>" class="img-responsive"></a>

                  </figure>
                    <div class="more">
                      <p>
                        <input type="file" id="userfile" name="userfile" style="" >
                        <button class="btn btn-default" id="imgbut" data-icon="fa-upload text-dark"></button>
                      </p>
                    </div>
                </div>
                </form>

                <div>
                  <form id="member-register" name="member-register" method="post"  class="form-horizontal">
                    <input type="hidden" id="id" name="id" value="<?php echo $this->session->userdata('id');?>">
                  <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control input-sm" id="fname" name="fname" placeholder="First Name" value="<?php echo $fname; ?>">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control input-sm" id="sname" name="sname" placeholder="Last Name" value="<?php echo $sname; ?>"> 
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control input-sm" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>"> 
                      </div>
                    </div>        

                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <label>Date of Birth</label>
                      <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar text-dark"></i></span>
                        <input type="text" id="dob" class="form-control" name="dob" id="dobtxt" value="<?php if (isset($dob)){echo date('Y-m-d',strtotime($dob));}else{ echo '1985-10-19';}?>" aria-describedby="dob">
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>Gender</label>
                        <select class="form-control" name="gender" id="gender">
                          <option value="M" <?php if(isset($gender)) { if($gender == 'M') { echo 'selected';} } ?>>Male</option>
                          <option value="M" <?php if(isset($gender)) { if($gender == 'F') { echo 'selected';} } ?>>Female</option> 
                        </select>  
                      </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <label>Mobile Number</label>
                      <div class="form-group input-group">
                      
                        <?php echo $this->my_na_model->get_countries($d_code, false, false, $class = '', $id = '');?> 
                        <input type="text" class="form-control input-sm" id="cell" name="cell" placeholder="+264 81 293 4355"  value="<?php if(isset($cell)){echo $cell;}?>" <?php echo $lock;?>> 
                        <?php echo $verifiedHTML; ?>

                        <input type="hidden" id="cell_verified" name="cell_verified" value="<?php echo $verified;?>">
             
                      </div>
                      <div class="form-group">
                          <span class="help-block" style="font-size:11px">Please only give us your complete cellular number withoutany prefixes or dialling codes.</span>
                      </div>  
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>Country</label>
                        <select onchange="populateRegion(this.value);" id="country" name="country" class="form-control">
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

                    <div class="col-sm-12 col-md-6 col-lg-4" id="region_div">
                        <?php //POPULATE REGION PLACEHOLDER 
                          if(isset($city)){
                            $this->members_model->populate_city($country, $city);
                          }
                        ?>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4" id="suburb_div">
                        <?php //POPULATE SUBURB PLACEHOLDER
                          if(isset($suburb)){
                            $this->members_model->populate_suburb($city ,$suburb);
                          }
                        ?>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control input-sm" placeholder="Password" id="pass1" name="pass1">
                      </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4">
                      <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control input-sm" placeholder="Confirm Password" id="pass2" name="pass2"> 
                      </div>
                    </div>    

                    <div class="col-sm-12 col-md-12 col-lg-12">
                      <label>My Na Daily</label>
                      <div class="form-group">
                        
                        <div class="btn-group" data-toggle="buttons-radio">
                          <button type="button" id="daily_y" onclick="javascript:toggle_note_check('Y');" class="btn btn-dark <?php if(isset($daily_mail)){ if($daily_mail == 'Y'){echo 'active';}}else{ echo '';}?>">Yes</button>
                          <button type="button" id="daily_n" onclick="javascript:toggle_note_check('N');" class="btn btn-dark  <?php if(isset($daily_mail)){ if($daily_mail == 'N'){echo 'active';}}else{ echo '';}?>">No</button>
                        </div>
                        <input type="hidden" name="daily_mail" id="daily_mail" value="<?php echo $daily_mail;?>" />

                      </div>
                      <div class="form-group">
                        <span class="help-block" style="font-size:11px">Do you want to receive the daily my na email?</span> 
                      </div>  
                    </div>                                    

                    <div class="col-sm-12">
                      <div class="form-group">
                        <button class="btn btn-primary btn-lg" id="but">Update Info</button>
                      </div>
                    </div>

                  </div>

                  <div id="result_msg"></div>
                </form>
                </div>
              </section>
            
          </section>          

        </div> 

      </div>
    </div>
  </div>  
</div>
  
<?php $this->load->view('inc/footer');?>  

<script data-cfasync="false" type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>

<script data-cfasync="false" type="text/javascript">

$(document).ready(function(){
  

  $('#dob').datepicker();

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
//          $('#pass1').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Password Required", content:"Please supply us with a secure password"});
//      $('#pass1').popover('show');
//      $('#pass1').focus();

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

    }else if($('#dob').val().length == 0){

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
      url:           '<?php echo site_url('/').'members/add_avatar_ajax';?>' ,
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
    $('#but').html('<img src="<?php echo base_url('/').'images/load.gif';?>" /> Working...');
    $.ajax({
      type: 'post',
      data: frm.serialize(),
      url: '<?php echo site_url('/').'members/update_do';?>' ,
      success: function (data) {
        
         $('#result_msg').html(data);
         $('#but').html('Update Info');
        
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
  
  function populateRegion(countryID)
  { 
    
    if(countryID == 151){
    $("#region_div").html('<div class="col-md-12" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div>');
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
    $("#suburb_div").html('<div class="col-md-12" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div>');
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


</body>
</html>