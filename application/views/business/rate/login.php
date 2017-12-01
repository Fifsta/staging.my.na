<?php if(isset($reviews) && $reviews != ''){?>
<div class="container-fluid">

	<div class="row-fluid">

		<div class="span12">

			<?php echo $reviews;?>
		</div>
	</div>
</div>
<?php } ?>
<div class="container-fluid" style="position:relative;z-index:999;padding-top:0px">

        <ul  class="nav nav-pills">      
          <li class=" pull-right"><a href="#my_na_login"  data-toggle="tab">My.Na Account</a></li>
		  <li class="active pull-right"><a href="#rateme" data-toggle="tab">Leave Review</a></li>
        </ul>
        
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane fade in active" id="rateme">
          		<h4><span class="yellow">Step 1:</span> Your Details</h4>
                <form id="new_user_cred" class="form-horizontal">
				    <div class="control-group">
                        <label class="control-label" for="fname">Name</label>
                        <div class="controls">
                            <input type="hidden" value="<?php echo $client_id;?>" name="client_id" id="client_id_s" />
                            <input type="text" id="new_user_credfname" name="fname" placeholder="First name" value="<?php if(isset($fname)){echo $fname;}?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="sname">Surname</label>
                        <div class="controls">
                            <input type="text" id="new_user_credsname" name="sname" placeholder="Surname" value="<?php if(isset($sname)){echo $sname;}?>">
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="signup_email">Email</label>
                        <div class="controls">
                            <input type="text" id="new_user_credsignup_email" name="signup_email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
                            <span class="help-block" style="font-size:11px">This is your unique identifier, must be a valid email address</span>
                        </div>

                    </div>

                    <div class="row-fluid">
                        
                        <div class="span2 hidden-phone">

                        </div>
                        <div class="span10 captcha_review">

                            <?php
                            $this->my_na_model->build_captcha();

                            ?>
                            <span class="help-block" style="font-size:11px">Please prove you are human by clicking the box</span>
                        </div>
                    </div>
                     
                    
                </form>              
            <?php echo $rateHTML;?>
          </div>
          <div class="tab-pane fade" id="my_na_login">
					 <?php echo form_open(site_url('/').'rate/login', array('class' => 'form-signin', 'id' => 'login_frm'));?>
                    <h1><img src="<?php echo base_url('/');?>img/icons/affiliation.png" title="Proudly Partnered With" rel="tooltip"/></h1>
                    <h4>Please log in to Review</h4>
                    <div id="msg" style="position:absolute; margin-top:-40px">
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
                                 <?php if($this->session->flashdata('msg')){ ?>
                                <div class="alert  alert-success">
                                 <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo $error; ?>
                                </div>
                                <?php
                                }//end error
                                if($this->session->flashdata('error')){ ?>
                                <div class="alert alert-error">
                                 <button type="button" class="close" data-dismiss="alert">×</button>
                                    <?php echo $this->session->flashdata('error'); ?>
                                </div>
                                <?php
                                }
                     ?>
                    </div>
                    <input type="text" class="input-block-level" name="email" id="email" placeholder="Email address">
                    <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
                    <input type="hidden" name="first_log" value="<?php if (isset($first)){ echo $first;}else{ echo 'N';}?>" />
                    <?php if (isset($redirect)){ ?>
                        <input type="hidden" name="redirect" value="<?php echo str_replace('/NEW/', '/',$redirect);?>" />
                    <?php } ?>
                    <label class="checkbox">
                      <input type="checkbox" value="remember-me"> Remember me
                    </label>
                    <button class="btn btn-inverse" type="submit" id="btn_submit"><i class="icon-lock icon-white"></i> Sign in</button>
                    <div class="fb-login-button pull-right" data-max-rows="1" 
                    			data-size="large" data-show-faces="false" data-scope="email" 
                            	onlogin="checkLoginState()" style="float:right;margin-top:-5px;padding:10px 0;" 
                                data-auto-logout-link="false"></div>
                    <div class="clearfix">&nbsp;</div>
                         <p>
                             <small>
                                 <a href="javascript:void(0);" onclick="signup()" id="reg_btn" class="muted">No Account? Create one now.</a>
                             </small>
                         </p>
                         <p>
                             <small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right muted">Forgot Password?</a>
                                 <a href="<?php echo site_url('/');?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
                             </small>
            
                         </p>
            
                  </form>
                    <?php if($this->input->get('debug')){
            
                        $this->enable_profiler(TRUE);
                    }?>
                    
                    <?php //if(isset($pass_update)){?>
                      <div class="tab-pane <?php if(isset($pass_update)){ echo '';}else{ echo 'hide';}?>" id="pass_update">
                       <?php echo form_open(site_url('/').'members/pass_update_one', array('class' => 'form-signin white_box', 'name' => 'formpass0'));?>		
                        <div class="alert alert-warning" >
                         <button type="button" class="close" data-dismiss="alert">×</button>
                           <h4>Generate a new password</h4>
                           Please provide us with your email address to generate a new password
                        </div>
                           
                          <input type="text" class="input-block-level" placeholder="Email" name="passemail" value="<?php if (isset($email)) { echo $email; }?>"  />
                          <button class="btn btn-inverse" type="submit"><b>Proceed</b></button>
                          <div class="clearfix" style="height:10px"></div>
                             <small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right muted">Login?</a>
                                    <a href="<?php echo site_url('/');?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
                             </small>
                        </form>
                      </div>
                    <?php //} ?>
                    
                    
                    <?php if(isset($step1)){?>
                      <div class="tab-pane" id="pass_update2">
                       <?php echo form_open(site_url('/').'members/pass_update_three', array('class' => 'form-signin white_box', 'name' => 'formpass0'));?>		
                        <div class="alert alert-warning" >
                           <h4>Set a new password</h4>
                           Please set your new password and confirm it below.
                        </div>
                           
                          <input type="password" class="input-block-level" name="pass1" value=""  />
                          <input type="hidden" name="token" value="<?php echo $token;?>"  />
                          <input type="hidden" name="client_id" value="<?php echo $client_id;?>"  />
                          <button class="btn btn-inverse" type="submit"><b>Set new password</b></button>
                          <div class="clearfix" style="height:10px"></div>
                             <small>
                                    <a href="<?php echo site_url('/');?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
                             </small>
                        </form>
                      </div>
                    <?php } ?>
                   
                   
                   <?php if(isset($unsubscribe_daily)){?>
                      <div class="tab-pane form-signin" style="display:block">
                        <div class="alert alert-warning" >
                           <h4>Unsubscribe from My Na Daily</h4>
                          To stop receiving the my daily email please login and update your preferences under the My Profile tab.
                        </div>
                    
                          
                      </div>
                    <?php } ?>
          
          
          </div>
        
        </div>
            
            

       
       </div> <!-- /container -->

 <div id="anchor"></div>

<form id="member-register" name="member-register" method="post" action="<?php echo site_url('/');?>rate/register_1_do_ajax" class="form-horizontal">
<div class="modal hide fade" id="modal-register">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Who Are You?</h3>
    </div>

    <div class="modal-body" style="height:60%; overflow-y: scroll">

            <fieldset>

                <div id="step1" class="<?php if(isset($semi)){echo 'hide';}?>">

                    <div class="control-group">
                        <label class="control-label" for="fname">Name</label>
                        <div class="controls">
                            <input type="text" id="fname" name="fname" placeholder="First name" value="<?php if(isset($fname)){echo $fname;}?>">
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="sname">Surname</label>
                        <div class="controls">
                            <input type="text" id="sname" name="sname" placeholder="Surname" value="<?php if(isset($sname)){echo $sname;}?>">
                        </div>
                    </div>


                    <div class="control-group">
                        <label class="control-label" for="signup_email">Email</label>
                        <div class="controls">
                            <input type="text" id="signup_email" name="signup_email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
                            <span class="help-block" style="font-size:11px">This is your accounts unique identifier, must be unique</span>
                        </div>

                    </div>

                    <input type="hidden" id="email_" name="email_" value="<?php if(isset($email)){ echo $email;}?>"/>


                </div><!-- end step1-->

                <div id="step2" class="hide">
                    <div class="row-fluid">

                        <div style="width:30%; float: left" class="hidden-phone">
                            <label style="margin-top:5px"></label>
                        </div>
                        <div style="width:70% ;float: left" id="g_captcha" data-size="compact" >
                            <?php if(!isset($semi)){
                                //$this->my_na_model->build_captcha();
                            }
                            ?>
                            <span class="help-block muted" style="font-size:11px">By joining My Namibia&trade; you agree to our Terms and Conditions. All rights reserved</span>
                        </div>
                    </div>

                </div>

                 
                <div id="result_msg" style="position:absolute; width:100%;"></div>

            </fieldset>


    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        <a class="btn  btn-info hide" id="but_step_back">Back</a>
        <a onclick="bind_signup()" class="btn  btn-inverse" id="but_step1">Next</a>
    </div>
</div>
</form>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
<script>

    window.setTimeout(function(){

        btn_action();
    }, 2000);

    function bind_signup(){

            //Validate
            if(($('#fname').val().length == 0) || ($('#sname').val().length == 0)){

                var x = $('#fname');
                x.focus();
                x.popover({
                    placement:"bottom",html: true,trigger: "manual",
                    title:"Full name required", content:"Please provide us with your full name"});
                x.popover('show');
                setTimeout(function() {
                    x.popover('hide');
                }, 3000);
                $('html, body').animate({
                    scrollTop: (x.offset().top - 200)
                }, 300);



            }else if($('#signup_email').val().length == 0){

                var x = $('#signup_email');
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


            }else{

                submit_form_step1();

            }


    }

    function submit_form_step2(){
		console.log('step2');
        var frm = $('#member-register');
        //frm.submit();
        $('#but_step1').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');
        $.ajax({
            type: 'post',
            url: '<?php echo site_url('/').'rate/register_1_do_ajax';?>' ,
            data: frm.serialize(),
            dataType: 'json',
            success: function (data) {

                $('#result_msg').html(data['html']);

                if(data['success']){
                    $('#but_step1').html('Join <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
                    $('#email_').val(data['email']);
                    $('#client_id').val(data['client_id']);
                    window.location.reload();

                }else{
                    grecaptcha.reset();
                    $('#but_step1').html('Let Me Review');
                }


            }
        });

    }


    function submit_form_step1(){
		console.log('step1');
       $('#step1').slideUp();
       $('#step2').slideDown();
	   
	   $('#but_step_back').fadeIn().attr("onclick", "javascript:go_to_step1(0);");
       $('#but_step1').html('Let Me Review').attr("onclick", "javascript:submit_form_step2(0);").attr("href","javascript:void(0)");
	   $('#rc-imageselect').css("display", "none");

    }
	function go_to_step1(){
		console.log('back');
       $('#step1').slideDown();
       $('#step2').slideUp();
	   $('#but_step_back').fadeOut();
       $('#but_step1').html('Next').attr("onclick", "javascript:bind_signup(0);").attr("href","javascript:void(0)");

    }
	
	function btn_action(){



        $("#btn_submit").click(function(e) {
            e.preventDefault();
            var frm = $("#login_frm");
            $(this).html("Processing...");
            $.ajax({
                type: "post",
                url: "https://www.my.na/rate/login/" ,
                data: frm.serialize(),
                success: function (data) {
                    $("#msg").html(data);
                    $("#btn_submit").html('<i class="icon-lock icon-white"></i> Sign in');

                }
            });
        });

    }

    function signup(){


        $('#modal-register').bind('show', function() {


            //var id = $(this).data('id'),
            removeBtn = $(this).find('.btn-primary');

            removeBtn.unbind('click').click(function(e) {
                submit_form_step1();

            });
        }).modal({ backdrop: true });

    }
</script>
