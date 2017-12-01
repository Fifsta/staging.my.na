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
<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/bootstrap-image-gallery.min.css">
<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
<link href="<?php echo base_url('/'); ?>css/datepicker.css" rel="stylesheet" type="text/css"/>
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo base_url('/'); ?>css/select/select2.css" rel="stylesheet" type="text/css" />

</head>
<body>

<?php
//+++++++++++++++++
//LOAD NAVIGATION
//+++++++++++++++++
$nav['section'] = 'account';
$this->load->view('inc/navigation', $nav);
?>

<!-- END Navigation -->
<!-- Part 1: Wrap all content here -->
<div id="wrap">
    <!-- Begin page content -->
    <div class="clearfix" style="height:40px;"></div>
    <div class="container" id="home_container">
        <div class="row">
            <div class="span8">

                <h1 class="na_script upper big_icon">Join <span class="na_script yellow big_icon">My</span> <span class="na_script yellow big_icon">Na</span>mibia&trade;</h1>

                   Already registered with your e-mail address? You will not be able to register again.</p>

                <p>All your information is stored securely and confidentially .
                    By joining My Namibia you will have access your personal  membership console .
                    Here you will be able to manage your business listing as well as , list anything from products , deals , cars or property to jobs.
                    You will be kept up to date with the latest news and listings, that fit your profile.</p>
            </div>
            <div class="span4">
                <img src="<?php echo base_url('/');?>img/bground/stick_man_couch_2.png" class="pull-right" alt="Join the biggest Namibian online portal" />
            </div>
            <div class="clearfix" style="height:40px"></div>

        </div>
    </div>
    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>
    <div class="container-fluid footer">


        <div class="row-fluid">
            <div class="container">

                <div class="row-fluid white">
                    <div class="span12">

                        <h2>Join the biggest Namibian Online Network for FREE</h2>
                    </div>

                </div>

            </div>
        </div>

    </div>

    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>
    <div class="container">
        <div class="row">
            <div class="span8">

                <div class="clearfix"></div>

                <?php if (isset($error)) { ?>
                    <div class="alert alert-error">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error; ?>
                    </div>
                <?php
                }//end error
                if (isset($basicmsg)) { ?>
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $basicmsg; ?>
                    </div>
                <?php
                }
                ?>

                <ul id="myTab2" class="nav nav-pills">
                    <li class="active"><a href="#regtb" data-toggle="tab"><i class="icon-lock"></i> <span
                                class="hidden-phone">Register with my.na</span></a></li>
                    <li><a><strong>OR</strong></a></li>
                    <!--<li><a href="#fbtb" data-toggle="tab"> <i class="fa fa-facebook"></i> <span class="hidden-phone">Login with facebook</span></a></li>-->
                    <li>

                        <div class="fb-login-button" data-max-rows="1" onlogin="checkLoginState()" data-size="large" style="margin-top:5px" data-show-faces="false" data-auto-logout-link="false"></div>
                    </li>
                </ul>

                <div id="myTabContent2" class="tab-content">
                    <div class="tab-pane fade in active" id="regtb">
                        <?php
                        //+++++++++++++++++
                        //LOAD FORM
                        //+++++++++++++++++

                        if(isset($semi) && $semi){

                            echo '<div class="alert"><h4>Hi '.$fname.',</h4>We can see you have previously completed the first registration step.
                                    Please Complete the 2nd step to get you my.na account up and running.
                                    </div>';
                        }

                        //+++++++++++++++++
                        //My.Na Registration Form
                        //+++++++++++++++++
                        //Roland Ihms
                        //Security Questions
                        $z = rand(1,9);
                        $y = rand(1,9);
                        ?>


                        <form id="member-register" name="member-register" method="post" action="<?php echo site_url('/');?>members/register_do" class="form-horizontal">
                            <fieldset>
                                <div class="clearfix" style="height:40px;"></div>

                                <div id="step1" class="<?php if(isset($semi)){echo 'hide';}?>">

                                    <div class="row-fluid">
                                        <div class="span2">
                                            <span class="upper na_script round_number">1</span>
                                        </div>
                                        <div class="span10">
                                            <strong>Step 1</strong>
                                           <p>Please complete the form below</p>
                                        </div>
                                    </div>
                                    <div class="clearfix"><p>&nbsp;</p></div>


                                    <?php //$this->load->view('inc/countries_cell');?>

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
                                            <span class="help-block" style="font-size:11px" id="email_help_div">This is your accounts unique identifier, must be unique</span>
                                        </div>

                                    </div>
                                </div><!-- end step1-->
                                <div id="step2" class="<?php if(!isset($semi)){echo 'hide';}?>">

                                    <div class="row-fluid">
                                        <div class="span2">
                                            <span class="upper na_script round_number">2</span>
                                        </div>
                                        <div class="span10">
                                            <strong>Step 2</strong>
                                            <p>Please set your personal and security credentials</p>
                                        </div>
                                    </div>

                                    <div class="clearfix"><p>&nbsp;</p></div>
                                    <div class="control-group">
                                        <label class="control-label" for="country">Country</label>
                                        <div class="controls">

                                            <select onchange="populateRegion(this.value);" id="country" name="country" class="span4">
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
                                            <div class="input-append date">
                                                <input type="text" class="span3" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="dob"  name="dob"  value="<?php if (isset($dob)){echo date('Y-m-d',strtotime($dob));}else{ echo '1985-10-19';}?>" readonly>
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                            </div>
                                            <span class="help-block" style="font-size:11px">Select your date of birth by clicking on the calendar icon</span>
                                        </div>

                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="gender">Gender</label>
                                        <div class="controls">
                                            <div class="btn-group" data-toggle="buttons-radio">
                                                <button type="button" id="male_click" onclick="javascript:togglecheck('M');" class="btn btn-inverse active">Male</button>
                                                <button type="button" id="female_click" onclick="javascript:togglecheck('F');" class="btn btn-inverse">Female</button>

                                            </div>
                                            <input type="hidden" name="gender" id="gender" value="M" />
                                            <span class="help-block" style="font-size:11px">Are you male or female?</span>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="cell">Cellphone</label>

                                        <div class="controls">
                                            <?php echo $this->my_na_model->get_countries(0,false,false);?>
                                            <input type="text" id="cell"  name="cell" autocomplete="off" onkeypress="return isNumberKey(event)" class="span3 bfh-countries" placeholder="eg: 0811234567" value="<?php if(isset($cell)){echo $cell;}?>">
                                            <!--<input type="hidden" id="dial_code"  name="dial_code"  value="264">-->
                                            <span class="help-block" style="font-size:11px">Please only give us your complete cellular number without<br /> any prefixes or dialling codes.</span>
                                        </div>

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
                                            <span class="help-block" style="font-size:11px">Confirm your password and choose a safe combination<br /> of letters, symbols and numbers</span>
                                        </div>
                                    </div>

                                </div><!-- end step2-->

                                <div class="control-group <?php if(isset($semi)){echo 'hide';}?>" id="Gcaptcha" >
                                    <label class="control-label"></label>
                                    <div class="controls">
                                        <?php if(!isset($semi)){
                                                $this->my_na_model->build_captcha();
                                              }
                                        ?>
                                    </div>
                                </div>
                                <input type="hidden" id="x" name="x" value="<?php echo $z;?>"/>
                                <input type="hidden" id="y" name="y" value="<?php echo $y;?>"/>
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
                                        <button type="submit" class="btn  btn-inverse" name="submit" id="but<?php if(!isset($semi)){echo '_step1';}?>"><?php if(!isset($semi)){echo 'Go To Next Step';}else{ echo 'Proceed';}?></button>
                                    </div>
                                </div>


                            </fieldset>
                        </form>

                    </div>
                    <!--                      <div class="tab-pane fade" id="fbtb">
                                               <div class="">
                                                    <h3>Create a Account using facebook.com</h3>
                                                    <p>We can quickly register your details using facebook.</p>
                                                    <div class="fb-login-button pull-right" data-max-rows="1" data-theme="dark" data-size="xlarge" data-show-faces="true" data-auto-logout-link="false"></div>
                                                    <div class="fb-login-button" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"></div>
                                                </div>
                                          </div>-->
                </div>

            </div>

            <div class="span4">
                <h3>Business Services</h3>

                <div class="white_box">
                    <video controls preload="none" poster="<?php echo S3_URL; ?>video/video/business_stick_man.jpg"
                           style="width:100%" title="business_stick_man">
                        <source src="<?php echo S3_URL; ?>video/video/business_stick_man.m4v" type="video/mp4"/>
                        <source src="<?php echo S3_URL; ?>video/video/business_stick_man.webm"
                                type="video/webm"/>
                        <source src="<?php echo S3_URL; ?>video/video/business_stick_man.ogv" type="video/ogg"/>
                        <source src="<?php echo S3_URL; ?>video/video/business_stick_man.mp4"/>
                        <object type="application/x-shockwave-flash"
                                data="<?php echo S3_URL; ?>video/video/eh5v.files/html5video/flashfox.swf"
                                width="1280" height="720" style="position:relative;">
                            <param name="movie"
                                   value="<?php echo S3_URL; ?>video/video/eh5v.files/html5video/flashfox.swf"/>
                            <param name="allowFullScreen" value="true"/>
                            <param name="flashVars"
                                   value="autoplay=false&controls=true&fullScreenEnabled=true&posterOnEnd=true&loop=false&poster=<?php echo base_url('/'); ?>video/video/business_stick_man.jpg&src=<?php echo S3_URL; ?>video/video/business_stick_man.m4v"/>
                            <embed src="eh5v.files/html5video/flashfox.swf" width="1280" height="720"
                                   style="position:relative;"
                                   flashVars="autoplay=false&controls=true&fullScreenEnabled=true&posterOnEnd=true&loop=false&poster=<?php echo base_url('/'); ?>video/video/business_stick_man.jpg&src=<?php echo S3_URL; ?>video/video/business_stick_man.m4v"
                                   allowFullScreen="true" wmode="transparent" type="application/x-shockwave-flash"
                                   pluginspage="http://www.adobe.com/go/getflashplayer_en"/>
                            <img alt="business_stick_man"
                                 src="<?php echo S3_URL; ?>video/video/business_stick_man.jpg"
                                 style="position:absolute;left:0;" width="100%"
                                 title="Video playback is not supported by your browser"/>
                        </object>
                    </video>
                </div>
                <h3>Buy &amp; Sell in Namibia</h3>

                <div class="white_box">
                    <video controls preload="none" poster="<?php echo S3_URL; ?>video/video/buy_sell_stick_man.jpg"
                           style="width:100%" title="buy_sell_stick_man">
                        <source src="<?php echo S3_URL; ?>video/video/buy_sell_stick_man.m4v" type="video/mp4"/>
                        <source src="<?php echo S3_URL; ?>video/video/buy_sell_stick_man.webm"
                                type="video/webm"/>
                        <source src="<?php echo S3_URL; ?>video/video/buy_sell_stick_man.ogv" type="video/ogg"/>
                        <source src="<?php echo S3_URL; ?>video/video/buy_sell_stick_man.mp4"/>
                        <object type="application/x-shockwave-flash"
                                data="<?php echo S3_URL; ?>video/video/eh5v.files/html5video/flashfox.swf"
                                width="1280" height="720" style="position:relative;">
                            <param name="movie"
                                   value="<?php echo S3_URL; ?>video/video/eh5v.files/html5video/flashfox.swf"/>
                            <param name="allowFullScreen" value="true"/>
                            <param name="flashVars"
                                   value="autoplay=false&controls=true&fullScreenEnabled=true&posterOnEnd=true&loop=false&poster=<?php echo S3_URL; ?>video/video/buy_sell_stick_man.jpg&src=<?php echo S3_URL; ?>video/video/buy_sell_stick_man.m4v"/>
                            <embed src="eh5v.files/html5video/flashfox.swf" width="1280" height="720"
                                   style="position:relative;"
                                   flashVars="autoplay=false&controls=true&fullScreenEnabled=true&posterOnEnd=true&loop=false&poster=<?php echo S3_URL; ?>video/video/buy_sell_stick_man.jpg&src=<?php echo S3_URL; ?>video/video/buy_sell_stick_man.m4v"
                                   allowFullScreen="true" wmode="transparent" type="application/x-shockwave-flash"
                                   pluginspage="http://www.adobe.com/go/getflashplayer_en"/>
                            <img alt="buy_sell_stick_man"
                                 src="<?php echo S3_URL; ?>video/video/buy_sell_stick_man.jpg"
                                 style="position:absolute;left:0;" width="100%"
                                 title="Video playback is not supported by your browser"/>
                        </object>
                    </video>
                </div>

            </div>

        </div>

    </div>
    <!-- /container - end content -->


    <?php
    //+++++++++++++++++
    //LOAD FOOTER
    //+++++++++++++++++
    $footer['foo'] = '';
    $this->load->view('inc/footer', $footer);
    ?>
</div>
<!-- /wrap  -->

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



       /* function formatState (state) {
            console.log(state.element+'sasas');
            if (!state.id) { return state.text; }
            var $state = $(
                '<span><img src="vendor/images/flags/' + state.element.value.toLowerCase() + '.png" class="img-flag" />'+state.element.text+'</span>'
            );

            return $state;
        };
        function format(state) {
            if (!state.id) return state.text; // optgroup
            return "<img class='flag' src='images/flags/" + state.id.toLowerCase() + ".png'/>" + state.text;
        }
        $(".country").select2({
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function(m) { return m; }
        });*/



    });


    function validateEmail(email) {
        // http://stackoverflow.com/a/46181/11236

        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }



    function togglecheck(val){

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
            $("#region_div").html('<div class="control-group"><div class="span4" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div></div>');
            $("#suburb_div").addClass('disabled');
        }
        $.ajax({
            url: "<?php echo site_url('/');?>members/populate_city/"+countryID+"/<?php echo $city_id;?>/",
            success: function(data) {
                $("#region_div").html(data);
                $('select').removeClass('span8').addClass('span4');
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
                $('select').removeClass('span8').addClass('span4');
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