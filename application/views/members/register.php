<?php $this->load->view('inc/header'); ?>


<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/bootstrap-image-gallery.min.css">
<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
<link href="<?php echo base_url('/'); ?>css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url('/'); ?>css/select/select2.css" rel="stylesheet" type="text/css" />
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

			<div class="heading">
				<h2 data-icon="fa-pencil">Join <strong>Ny Namibia</strong></h2>
				<p>Already registered with your e-mail address? You will not be able to register again.</p>
				<ul class="options">

				</ul>
			</div>
			<br>

            <p>
	        	All your information is stored securely and confidentially.
	            By joining My Namibia you will have access your personal  membership console.
	            Here you will be able to manage your business listing as well as , list anything from products , deals , cars or property to jobs.
	            You will be kept up to date with the latest news and listings, that fit your profile.
            </p>

            <ul id="myTab2" class="nav nav-pills">
                <li class="nav-item"><a class="btn btn-dark nav-link" href="#regtb" data-toggle="tab"><i class="icon-lock"></i> <span class="hidden-phone">Register with my.na</span></a></li>
                <li class="nav-item"><a class="nav-link"><strong>OR</strong></a></li>
                <li class="nav-item">
                    <div class="fb-login-button" data-max-rows="1" onlogin="checkLoginState()" data-size="large" style="margin-top:5px" data-show-faces="false" data-auto-logout-link="false"></div>
                </li>
            </ul>

            <!-- Start Registration Process -->
            <div>


                <div class="spacer"></div>

                <form id="member-register" name="member-register" method="post" action="<?php echo site_url('/');?>members/register_do" class="form-horizontal">
	                
	                <!--step 1 -->
	                <div id="step1" class="<?php if(isset($semi)){echo 'd-none';}?>">

						<div class="heading">
							<h2 data-icon="fa-pencil">Step <strong>One</strong></h2>
							<p>Please complete the form below</p>
							<ul class="options">

							</ul>
						</div>
						<br>

						<div class="form-group row">
						    <label for="fname" class="col-sm-1 col-form-label">Name</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" value="<?php if(isset($fname)){echo $fname;}?>">
						    </div>
						</div>

						<div class="form-group row">
						    <label for="sname" class="col-sm-1 col-form-label">Surname</label>
						    <div class="col-sm-10">
						      <input type="text" class="form-control" id="sname" name="sname" placeholder="Surname" value="<?php if(isset($sname)){echo $sname;}?>">
						    </div>
						</div>

						<div class="form-group row">
						    <label for="email" class="col-sm-1 col-form-label">Email</label>
						    <div class="col-sm-10">
						      <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
						      <span class="help-block" style="font-size:11px" id="email_help_div">This is your accounts unique identifier, must be unique</span>
						    </div>
						</div>

	                </div>
	                <!-- end step1 -->


	                <!--step 2 -->
	                <div id="step2" class="<?php if(!isset($semi)){echo 'd-none';} ?>">


						<div class="heading">
							<h2 data-icon="fa-pencil">Step <strong>two</strong></h2>
							<p>Please set your personal and security credentials</p>
							<ul class="options">

							</ul>
						</div>
						<br>

						<div class="form-group row">
						    <label for="email" class="col-sm-1 col-form-label">Country</label>
						    <div class="col-sm-10">
						      <select onchange="populateRegion(this.value);" id="country" name="country"" class="form-control">
									<option value="0" selected="selected">Select a Country</option>
                                        <?php
                                        if(!$country = $this->session->userdata('country')){

                                            $country = '';

                                        }
                                        if(!$city = $this->session->userdata('city')){

                                            $city = '';

                                        }

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
                                                    if($country1 == $country){ $x = 'selected="selected"';}else{ $x = '';}
                                                }else{
                                                    $x ='';
                                                }
                                                ?>

                                                <option <?php echo $x;?> value="<?php echo $ID; ?>"><?php echo $country1; ?></option>

                                            <?php
                                            }//end foreach loop
                                        } //end if rows for countries ?>
						      </select>
						    </div>
						</div>


                        <?php //POPULATE REGION PLACEHOLDER ?>
                        <div id="region_div"></div>

                        <?php //POPULATE SUBURB PLACEHOLDER ?>
                        <div id="suburb_div"></div>

						<div class="form-group row">
						    <label for="dob" class="col-sm-1 col-form-label">Date of Birth</label>
						    <div class="col-sm-3">
                                <input type="text" class="form-control" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="dob"  name="dob" value="<?php if (isset($dob)){echo date('Y-m-d',strtotime($dob));}else{ echo '1985-10-19';}?>" readonly>
                                <span class="add-on"><i class="icon-calendar"></i></span>
						    </div>
						</div>

						<div class="form-group row">
						    <label for="gender" class="col-sm-1 col-form-label">Gender</label>
						    <div class="col-sm-10">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button type="button" id="male_click" onclick="javascript:togglecheck('M');" class="btn btn-dark active">Male</button>
                                    <button type="button" id="female_click" onclick="javascript:togglecheck('F');" class="btn btn-dark">Female</button>
                                </div>
                                <input type="hidden" name="gender" id="gender" value="M" />
                                <span class="help-block" style="font-size:11px">Are you male or female?</span>
						    </div>
						</div>		


						<div class="form-group row">
						    <label for="cell" class="col-sm-1 col-form-label">Cellphone</label>
						    <div class="col-sm-10  ">
                                <div class="btn-group input-group">
                                    <?php echo $this->my_na_model->get_countries(0,false,false);?>
                                    <input type="text" id="cell"  name="cell" autocomplete="off" onkeypress="return isNumberKey(event)" class="form-control  input-sm" bfh-countries" placeholder="eg: 0811234567" value="<?php if(isset($cell)){echo $cell;}?>">
                                    
                                </div>
                                <span class="help-block" style="font-size:11px">Please only give us your complete cellular number without any prefixes or dialling codes.</span>
						    </div>
						</div>


	                </div>	
	                <!-- end step2 -->

                    <input type="hidden" id="client_id" name="client_id" value="<?php echo $client_id;?>"/>
                    <input type="hidden" id="email_" name="email_" value="<?php echo $email;?>"/>

                    <div class="control-group <?php if(isset($semi)){echo 'hide';}?>">
                        <label class="control-label" for="i_agree">Accept T&amp;C's</label>
                        <div class="controls">
                            <input type="checkbox" id="i_agree" name="i_agree">

                            <span class="help-block" style="font-size:11px">By joining My Namibia&trade; you agree to our Terms and Conditions. All rights reserved</span>
                        </div>
                    </div>                    

                     <div class="control-group">
                        <label class="control-label"></label>
                        <div class="controls">
                            <div id="result_msg"></div>
                            <button type="submit" class="btn  btn-dark" name="submit" id="but<?php if(!isset($semi)){echo '_step1';}?>"><?php if(!isset($semi)){echo 'Go To Next Step';}else{ echo 'Proceed';}?></button>
                        </div>
                    </div>                   

            	</form>
            </div>
            <!-- End Registration Process -->

        </div>
    </div>  
</div>

    
<?php $this->load->view('inc/footer');?>    

<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>

<!-- JAvascript

================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="https://select2.github.io/dist/js/select2.full.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url('/'); ?>js/custom/fb.js"></script>
<script src="<?php echo S3_URL;?>video/video/eh5v.files/html5video/html5ext.js" type="text/javascript"></script>

<script type="text/javascript">


    



    $(document).ready(function(){

        <?php
        $city_id = 0;
        if($country == 'Namibia') {

            echo 'populateRegion(151);';
            if($city == 'Windhoek') {

                $city_id = 16;
                echo 'populateSuburb(16);';
            }else{



            }
        }

		if(isset($semi) && $semi){
				echo "$('#but').attr('id', 'but_step1');";
				echo 'next_step();';
		}
        ?>
        $('#dob').datepicker();

		$('#fl_select').on('click', function(e){
			
			e.preventDefault();
		});
		
        $('#but_step1').click(function(e) {
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

            }else if(!$('#i_agree').is(":checked")){

                var x = $('#i_agree');
                x.focus();
                x.popover({
                    placement:"top",html: true,trigger: "manual",
                    title:"PLease Accept", content:"Please accept our Terms and Conditions"});
                x.popover('show');
                setTimeout(function() {
                    x.popover('hide');
                }, 3000);
                $('html, body').animate({
                    scrollTop: (x.offset().top - 200)
                }, 300);

            }else{

                submit_form_step1();

            }
        });



        $('#email').on("change keyup", function() {

            var str = $(this).val(), div = $('#email_help_div'), email = $('#email').val();
            if(str.length > 3 ){

                if(validateEmail(str)){

                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url('/').'members/validate_user_email';?>' ,
                        dataType: 'json',
                        data: {'email': email},
                        success: function (data) {
                            

                            if(data.success){
								div.html('<span class="alert alert-success">'+data.msg+'</span>');
                            }else{
								div.html('<span class="alert alert-danger">'+data.msg+'</span>');
                            }
                        }
                    });

                }else{


                    div.html('<span class="alert-danger">Not a valid email format...</span>');
                }

            }

        });

    });


    function validateEmail(email) {
        // http://stackoverflow.com/a/46181/11236

        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }



    function togglecheck(val){

    	if(val == 'M') {  $('#male_click').addClass("active"); $('#female_click').removeClass("active"); }
    	if(val == 'F') {  $('#female_click').addClass("active"); $('#male_click').removeClass("active"); }

        var chk = $('#gender');
        chk.val(val);
    }



    function submit_form(){

        var frm = $('#member-register');
        //frm.submit();
        $('#but_step1').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('/').'members/register_do_ajax';?>' ,
            dataType: 'json',
            data: frm.serialize(),
            success: function (data) {

                $('#result_msg').html(data['html']);

                if(data['success']){
                    $('#but_step1').html('Join <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
                    redirectpreview();
                }else{
                    grecaptcha.reset();
                    $('#but_step1').html('Go To Next Step');
                }
            }
        });

    }

    function submit_form_step1(){

        var frm = $('#member-register');
        //frm.submit();
        $('#but_step1').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('/').'members/register_1_do_ajax';?>' ,
            data: frm.serialize(),
            dataType: 'json',
            success: function (data) {

                $('#result_msg').html(data['html']);

                if(data['success']){
                    $('#but_step1').html('Join <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
                    $('#email_').val(data['email']);
                    $('#client_id').val(data['client_id']);
                    next_step();

                }else{
                    grecaptcha.reset();
                    $('#but_step1').html('Go To Next Step');
                }


            }
        });

    }


    function next_step(){

        
        $('#Gcaptcha').hide();
        $('#step1').slideUp();
        $('#step2').removeClass('hide');
        //$('#but_step1').attr('id', 'but');

        $('#but_step1').unbind().bind('click', function(e) {
            e.preventDefault();
			$('#but').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Redirecting...');
            var cell =  document.getElementById("cell").value;

            //Validate
            if(($('#pass1').val().length == 0) || ($('#pass2').val().length == 0)){

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

            }else if($('#cell').val().length < 8){

                var x = $('#cell');
                x.focus();
                x.popover({
                    placement:"top",html: true,trigger: "manual",
                    title:"Valid cellphone number", content:"Your cellphone number is less than 8 digits"});
                x.popover('show');
                setTimeout(function() {
                    x.popover('hide');
                }, 3000);
                $('html, body').animate({
                    scrollTop: (x.offset().top - 200)
                }, 300);
            <?php if(isset($c_code) && $c_code == 'NA'){ ?>
            /*}else if(checkCellphoneValidity()){

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
                }, 300);*/
            <?php } ?>
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

            }else if($('#dob').val().length == 0){

                var x = $('#dob');
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

            }else{

                submit_form();

            }
        });


    }

    function redirectpreview(){

        $('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Redirecting...');

        setTimeout(function() {
            window.location.href = "<?php echo site_url('/');?>members/register_success/";
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
            $("#region_div").html('<div class="control-group"><div style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div></div>');
            $("#suburb_div").addClass('disabled');
        }
        $.ajax({
            url: "<?php echo site_url('/');?>members/populate_city/"+countryID+"/<?php echo $city_id;?>/",
            success: function(data) {
                $("#region_div").html(data);
                //includeJS('js/microsite.show.js');
            }
        });
    }

    function populateSuburb(cityID)
    {
        $("#suburb_div").html('<div class="control-group"><div class="span4" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div></div>');
        $.ajax({
            url: "<?php echo site_url('/');?>members/populate_suburb/"+cityID+"/0",
            success: function(data) {
                $("#suburb_div").html(data);
            }
        });
    }

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    </script>


</body>
</html> 