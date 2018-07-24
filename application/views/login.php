<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
  <meta name="author" content="">
  <title>My Namibia</title>
  <meta name="viewport" content="width=device-width">
 
  <link rel="stylesheet" href="<?php echo base_url('/');?>bootstrap_old/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css">
  <link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>images/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>images/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>images/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>images/icons/my_na_[57x57].png">
  <link href='//fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>bootstrap_old/js/bootstrap.js"></script>

    <style type="text/css">
      body {
        padding-top: 0px;

      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
   .form-signin{background-color:#fff;
    margin-bottom:10px;
      background:#fff;
    -moz-box-shadow:      0 0 10px #666;
     -webkit-box-shadow:  0 0 10px #666;
     box-shadow:         0 0 10px #666;
     -moz-border-radius: 5px;
    -webkit-border-radius: 5px;
    border-radius: 5px; /* future proofing */
    -khtml-border-radius: 5px; /* for old Konqueror browsers */
  }}
    </style>
</head>

<body>

  
    <div id="wrap" style="padding-top:0;width:100%;height:100%;bottom:0; min-height:100%;">
         <div class="container" style="position:relative;z-index:999;padding-top:100px">
                        
    <?php 


          if(isset($password_update)){ 
            $array = array('class' => 'form-signin white_box hide', 'id' =>'form_login');
          }else{ 
            $array = array('class' => 'form-signin white_box', 'id' =>'form_login');
          }
          echo form_open(
            site_url('/').'members/login', 
            $array );

    ?>    
     
        <h2 class="form-signin-heading">Please sign in</h2>
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
        <input type="text" class="input-block-level" name="email" id="email" placeholder="Email address">
        <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
        <input type="hidden" name="first_log" value="<?php if (isset($first)){ echo $first;}else{ echo 'N';}?>" />
    <?php if (isset($redirect)){ ?>
          <input type="hidden" name="redirect" value="<?php echo str_replace('/NEW/', '/',$redirect);?>" />
        <?php } ?>
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-inverse" type="submit"><i class="icon-lock icon-white"></i> Sign in</button>
        <div class="fb-login-button pull-right" data-max-rows="1" data-size="large" data-show-faces="false" data-scope="email" onlogin="checkLoginState()" style="margin-top:-5px;padding:10px 0;" data-auto-logout-link="false"></div>
        <div class="clearfix">&nbsp;</div>
           <p>
             <small>
               <a href="<?php echo site_url('/');?>members/register/" class="muted">No Account? Create one now.</a>
             </small>
           </p>
           <p>
             <small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right muted">Forgot Password?</a>
               <a href="<?php echo site_url('/');?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
             </small>
           </p>

      </form>
    
    
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

            <p>
                <small>
                  <a href="<?php echo site_url('/');?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
                </small>
              </p>

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
       
       </div> <!-- /container -->
</div>
 <div id="anchor"></div>     
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/');?>js/custom/fb.js?v44"></script>
  <script type="text/javascript">
    
    $(document).ready(function(){
      $.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
        $('input').placeholder(); 
        
      });
      
    });
    function pass_update(){
      
      $('#pass_update').slideToggle();
      $('#form_login').fadeToggle();

      window.setTimeout(scroller(), 1000)
       
     
    }
    function scroller(){
      
      window.scrollTo(0,$('#anchor').offset().top);
    }
  
  </script>

</body>
</html>