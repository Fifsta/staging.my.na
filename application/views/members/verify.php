<!doctype html>
<html lang="en">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
<meta name="apple-mobile-web-app-capable" content="yes">

<meta name="google-site-verification" content="MMMMMMMMMMMMMMMMMM">

<meta name="author" content="My Namibia">

<base href="<?php echo base_url('/');?>" target="_self">

<!--<meta name="csrf-token" content="{{ csrf_token() }}">-->

<title><?php if(isset($title)){echo $title;}else{ echo 'My Namibia &trade;';}?></title>
<meta name="description" content="<?php if(isset($metaD)){echo $metaD;}else{ echo 'My Namibia - the Free business portal in Namibia';}?>">

<link rel="shortcut icon" type="image/ico" href="favicon.ico">

  <?php if(isset($og)){ echo $og;}?>
<link rel="publisher" href="https://plus.google.com/103433975350364100667">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
  <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">

  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>

<!--<link rel="icon" type="image/gif" href="animated_favicon.gif">-->

<!--[if lt IE 8]>
<script src="js/jquery-1.11.1.min.js"></script>
<link href="css/ie7.css" rel="stylesheet" type="text/css">
<script src="js/ie7.js"></script>
<![endif]-->

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

<!--[if lt IE 10]>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/modernizr.js"></script>
<![endif]-->

<!--[if (gte IE 9) | (!IE)]><!-->
<script src="js/jquery-2.1.1.min.js"></script>
<!--<![endif]-->
<!-- css -->

<link href="bootstrap/css/bootstrap.css?v=2" rel="stylesheet">

<link href="css/owl.carousel.min.css" rel="stylesheet" type="text/css">
<link href="css/owl.theme.default.min.css" rel="stylesheet" type="text/css">
<link href="css/style.combo.css" rel="stylesheet" type="text/css">
<link href="css/icons.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url('/'); ?>css/style.css?v=3" rel="stylesheet" type="text/css">

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/popper.min.js"></script>

<script src="js/jquery.lazyload.min.js"></script>

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

	<?php
	if ($VERIFIED == 'Y')
	{

		$verifiedHTML = '<button id="verify_btn" class="btn btn-success pull-right"><i class="icon-ok icon-white"></i> Verified</button>';

	}
	else
	{

		$verifiedHTML = '<buttons id="verify_btn" onclick="do_verify()" class="btn btn-danger  pull-right"><i class="icon-refresh icon-white"></i> Send Code</button>';

	}
	?>

</head>
<body>


	<div id="home-bak" style="padding-top:0;width:100%;height:100%;bottom:0;">
		<div class="container" style="position:relative;z-index:999;">

			<div class="hidden-desktop" style="height:40px;">&nbsp;</div>

			<?php echo form_open(site_url('/') . 'clients/verify_mobile/', array('class' => 'form-signin white_box', 'id' => 'form-verify')); ?>

			<h2>Verify your Account</h2>

			<p>Keep your account secure by completing this 2 step mobile phone verification.
				<ol>
					<li>We will send you a SMS with a 4 digit code</li>
					<li>Once received please enter the code and click verify</li>
				</ol>
			</p>

			<div class="alert alert-warning">
				<strong>Please note!</strong> Mobile phone verification is only required for Namibian residents wanting to transact on our trade platform.
				<a href="<?php echo site_url('/'); ?>members/" class="">Skip</a> this step.
			</div>


			<div id="result_msg"></div>
			<?php if (isset($error))
			{ ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<?php echo $error; ?>
				</div>
				<?php
			}//end error
			if (isset($basicmsg))
			{ ?>
				<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<?php echo $basicmsg; ?>
				</div>
				<?php
			}
			?>
			<?php if ($this->session->flashdata('msg'))
			{ ?>
				<div class="alert  alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<?php echo $error; ?>
				</div>
				<?php
			}//end error
			if ($this->session->flashdata('error'))
			{ ?>
				<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php
			}
			?>
			<input type="hidden" name="url" value="<?php echo $this->agent->referrer(); ?>">

			<div class="control-group">
				<?php echo $this->my_na_model->get_countries($DIAL_CODE, false, false, $class = '', $id = '');?>
				<input type="text" id="cell" name="number" style="margin-top:10px; width:95%" class="form-control" placeholder="eg: 0811234567" value="<?php if (isset($CLIENT_CELLPHONE))
				{
					echo $CLIENT_CELLPHONE;
				} ?>">

				<?php echo $verifiedHTML; ?>
			</div>
			<p class="clearfix">&nbsp;</p>
			<p class="clearfix">
				<small>Verifying your cellular number helps us keep our platform and you as the end-user safe. This information will help you recover your account</small>
			</p>
			<small>
				<a href="<?php echo site_url('/'); ?>members/" class="pull-right muted">Skip</a>
				<a href="<?php echo site_url('/'); ?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
			</small>
			</form>


			<?php //if(isset($pass_update)){?>
			<div class="tab-pane <?php if (isset($pass_update))
			{
				echo '';
			}
			else
			{
				echo 'hide';
			} ?>" id="pass_update">
				<?php echo form_open(site_url('/') . 'members/pass_update_one', array('class' => 'form-signin white_box', 'name' => 'formpass0')); ?>
				<div class="alert alert-warning">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h4>Generate a new password</h4>
					Please provide us with your email address to generate a new password
				</div>

				<input type="text" class="iform-control" placeholder="Email" name="passemail" value="<?php if (isset($email))
				{
					echo $email;
				} ?>"/>
				<button class="btn btn-inverse" type="submit"><b>Proceed</b></button>
				<div class="clearfix" style="height:10px"></div>
				<small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right muted">Login?</a>
					<a href="<?php echo site_url('/'); ?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
				</small>
				</form>
			</div>
			<?php //} ?>


			<?php if (isset($step1))
			{ ?>
				<div class="tab-pane" id="pass_update2">
					<?php echo form_open(site_url('/') . 'members/pass_update_three', array('class' => 'form-signin white_box', 'name' => 'formpass0')); ?>
					<div class="alert alert-warning">
						<h4>Set a new password</h4>
						Please set your new password and confirm it below.
					</div>

					<input type="password" class="form-control" name="pass1" value=""/>
					<input type="hidden" name="token" value="<?php echo $token; ?>"/>
					<input type="hidden" name="client_id" value="<?php echo $client_id; ?>"/>
					<button class="btn btn-inverse" type="submit"><b>Set new password</b></button>
					<div class="clearfix" style="height:10px"></div>
					<small>
						<a href="<?php echo site_url('/'); ?>page/terms-and-conditions/" class="pull-left muted">My Na Terms</a>
					</small>
					</form>
				</div>
			<?php } ?>


			<?php if (isset($unsubscribe_daily))
			{ ?>
				<div class="tab-pane form-signin" style="display:block">
					<div class="alert alert-warning">
						<h4>Unsubscribe from My Na Daily</h4>
						To stop receiving the my daily email please login and update your preferences under the My Profile tab.
					</div>


				</div>
			<?php } ?>

		</div>
		<!-- /container -->
	</div>
	<div id="anchor"></div>
	<!-- Le javascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url('/'); ?>js/custom/fb.js"></script>
	<script type="text/javascript">

		$(document).ready(function ()
		{
			$.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function (data)
			{
				$('input').placeholder();

			});


		});
		function pass_update()
		{

			$('#pass_update').slideToggle();
			window.setTimeout(scroller(), 1000)


		}
		function scroller()
		{

			window.scrollTo(0, $('#anchor').offset().top);
		}

		function do_verify()
		{

			var frm = $('#form-verify');
			//frm.submit();
			$('#verify_btn').html('Verifying...');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/').'clients/verify_mobile';?>',
				data: frm.serialize(),
				dataType: 'json',
				success: function (data)
				{
					if(data.success){


						$('.add-on').html('<i class="icon-lock"></i>');
						$('#result_msg').html(data.html);
						$('#cell').val('').attr('placeholder', 'eg: 0000');
						$('#verify_btn').html('Enter Code').removeClass('btn-danger').addClass('btn-inverse').attr('onclick', 'do_unlock()');

					}else{

						$('#result_msg').html(data.html);
						$('#verify_btn').html('<i class="icon-refresh icon-white"></i> Send Code');

					}


				}
			});

		}


		function do_unlock()
		{

			var frm = $('#form-verify');
			//frm.submit();
			$('#verify_btn').html('Verifying...');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/').'clients/verify_mobile_lock';?>',
				data: frm.serialize(),
				success: function (data)
				{

					$('#result_msg').html(data);


				}
			});

		}

	</script>

</body>
</html>