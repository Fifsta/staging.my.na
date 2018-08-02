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
	<title>Namibia Tourism Board - Login</title>
	<meta name="viewport" content="width=device-width">
 
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css">
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>

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
   .form-signin-ntb{
	   border:none;
	   background:none;

		margin-bottom:10px;
		 
	}
	.container{
		
		position:relative;z-index:999;padding-top:180px; background:url(<?php echo base_url('/');?>img/icons/ntb_big_blank.png) no-repeat top center; height:100%	
		
		
	}
	@media (max-width: 480px) {
		
		body{padding:0px;}	
		
		.container{position:relative;z-index:999;padding-top:150px; background:url(<?php echo base_url('/');?>img/icons/ntb_big_blank.png) no-repeat top center; background-size:180% auto; height:100%	}
	}
	
    </style>
</head>

<body>

	
   
         <div class="container">
            
             <div class="row-fluid">
           		<div class="span12 text-center">
                	<img src="<?php echo base_url('/');?>images/icons/ntb-sml.png" />
           		</div>
           </div>              
		<?php echo form_open(site_url('/').'ntb/login_do/', array('class' => 'form-signin form-signin-ntb'));?>		
     
      
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
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        <button class="btn btn-large btn-inverse" type="submit"><b>Sign in</b></button>
        <a href="<?php echo site_url('/');?>ntb/register/" class="btn btn-inverse pull-right">Create Account</a>
        <div class="clearfix" style="height:10px"></div>
         <small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right muted">Forgot Password?</a>
         		<a href="<?php echo site_url('/');?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
         </small>
      </form>
		
		
		<?php //if(isset($pass_update)){?>
          <div class="tab-pane" id="pass_update" style="display:<?php if(isset($pass_update)){ echo 'block;';}else{ echo 'none;';}?>">
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
          <div class="tab-pane" id="pass_update2" style="display:block">
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
       
           <div class="row-fluid">
           		<div class="span12 text-center">
                	<!--<img src="<?php echo base_url('/');?>img/icons/ntb_big.png" />-->
           		</div>
           </div>
       </div> <!-- /container -->

      
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript">
		
		$(document).ready(function(){
			$.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
			  $('input').placeholder(); 
			  
			});
			
		});
	 	function pass_update(){
			 
		 	$('#pass_update').slideToggle();
		 
		}
	
	</script>

</body>
</html>