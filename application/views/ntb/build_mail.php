<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
//$header['title'] = '';
//$header['metaD'] = '';
// $this->load->view('admin/inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<!DOCTYPE html>
<!--[if lt IE 7]>
<html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>
<html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>
<html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title><?php if (isset($title))
		{
			echo $title;
		}
		else
		{
			echo 'My Namibia &trade;';
		} ?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="<?php if (isset($metaD))
	{
		echo $metaD;
	}
	else
	{
		echo 'My Namibia - the Free business portal in Namibia';
	} ?>">
	<meta name="author" content="My Namibia">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/bootstrap.min.css">

	<link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="<?php echo base_url('/'); ?>js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url('/'); ?>redactor/redactor/redactor.css"/>
	<link href="<?php echo base_url('/'); ?>css/datatables.css" rel="stylesheet" type="text/css"/>
	<style type="text/css">
		#loading_img {
			position: relative;
			min-height: 600px
		}

		.loading_img {
			min-height: 400px;
			width: 100%;
			position: relative;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: 1040;
			background-color: #FFF;
			opacity: 0.8;
			filter: alpha(opacity=80);
		}

		#example_length label {
			margin-top: 20px;
		}

		body {
			background-color: #fff;
		}
	</style>

</head>
<body>


	<!-- END Navigation -->


	<!-- Begin page content -->
	<div id="container-body" class="container" style="margin-top:80px;">

		<div class="row">

			<div class="span12">


				<h1>NTB
					<small>Compose a Newsletter</small>
				</h1>

			</div>

		</div>


		<div class="row">
			<form id="sendmail" target="load_frame" name="sendmail" method="post" action="<?php echo site_url('/'); ?>ntb/send_email">
				<div class="span4">
					<ul class="nav nav-tabs nav-stacked">

						<li class="nav-header">Communicate</li>
						<li class="active"><a href="<?php echo site_url('/'); ?>ntb/build_mail/">Compose Newsletter<i
									class="icon-chevron-right pull-right"></i></a></li>
						<li><a href="<?php echo site_url('/'); ?>ntb/emails/">Newsletters<i
									class="icon-chevron-right pull-right"></i></a></li>
						<li class="nav-header">Select recipients</li>

					</ul>
					<div id="div_recipients">
						<?php $this->ntb_model->show_email_recipients('ntb'); ?>
					</div>
				</div>


				<div class="span8">


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

					<div class="loading_img" id="loading_img">
						<div id="msg"></div>


						<h3>NTB
							<small>Compose a Newsletter</small>
						</h3>

						<div class="alert alert-block">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<h4>Notice!</h4>
							The US CAN-SPAM Act bans false or misleading header information (e.g. "From" and "To" emails).
							It also bans deceptive or misleading subject lines.
						</div>
						<div class="btn-group">
							<button class="btn">Recipients</button>
							<button class="btn dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a tabindex="-1" onClick="select_rec('ntb');" href="javascript:void(0);">All NTB Members</a></li>
                                <li><a tabindex="-2" onClick="select_rec('ntb_subscribers');" href="javascript:void(0);">All NTB Email Subscribers</a></li>
								<li><a tabindex="-3" onClick="select_rec('accommodation');" href="javascript:void(0);">Accommodation Establishments</a></li>
								<li><a tabindex="-4" onClick="select_rec('industry');" href="javascript:void(0);">Tourism Industry Operators</a></li>

							</ul>
						</div>
						<a id="preview_button" style="display:none;margin-bottom:10px;clear:both" onClick="javascript:$('#preview').slideUp();$('#admin_content').slideDown();$('#preview_button').hide()" class="btn pull-right"><i class="icon-remove"></i> Close Preview</a>

						<div style="height:20px;" class="clearfix"></div>
						<div id="preview" style="display:none;background-color:#FF7401">


						</div>
						<iframe allowtransparency="true" name="load_frame" id="load_frame" frameborder="0" src="" style="width:100%;display:none"></iframe>

						<div id="admin_content">

							<input type="text" class="span8" style="font-size:22px;line-height:32px;height:40px;padding:5px" onKeyDown="$('#title').popover('destroy');" id="title" name="title" placeholder="Subject..." value="<?php if(isset($title)){ echo $title;}else{ echo '';}?>"/>
							<input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
							<input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
							<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id = 0; ?>">
							<input type="hidden" id="email_id" name="email_id" value="<?php if(isset($email_id)){ echo $email_id;}else{ echo '0';}?>">
							<input type="hidden" id="bus_id" name="bus_id" value="<?php if(isset($bus_id)){ echo $bus_id;}else{ echo '0';}?>">
							<textarea id="redactor_content" style="display:none" name="content"><?php if(isset($body)){ echo $body;}else{ echo '';}?></textarea>
							<br/>
							<button type="submit" id="send_mail_btn" class="btn btn-large pull-right">
								<i class="icon-envelope"></i> Send Newsletter
							</button>
							<a href="javascript:preview();" class="btn btn-large pull-right" style="margin-right:10px;"><i class="icon-check"></i> Preview</a>

						</div>
					</div>


				</div>
				<div class="clearfix" style="height:30px;"></div>

			</form>
		</div>
		<!--end Row -->

	</div>
	<!-- /container - end content -->
	<div class="clearfix" style="height:40px;"></div>

	<?php
	//+++++++++++++++++
	//MODAL HTML
	//+++++++++++++++++
	?>

	<div id="modal-email" class="modal hide fade">
		<div class="modal-header">
			<a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="close">&times;</a>

			<h3>Send Emails?</h3>
		</div>
		<div class="modal-body">
			Are you sure you want to send the email to the selected recipients?
			<div id="result_cover"></div>
			<p id="result_msg"></p>

			<div class="progress progress-striped active" id="barcover" style="display:none">
				<div class="bar bar-warning" id="barProgress" style="width: 0%;"></div>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" id="send_email_yes" class="btn btn-primary">Yes, Send</a>
			<a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="btn secondary">Close</a>
		</div>
	</div>


	<!-- JAvascript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url('/') ?>redactor/redactor/redactor.min.js?v=1"></script>
	<script type="text/javascript" language="javascript" src="<?php echo base_url('/'); ?>js/jquery.dataTables.min.js"></script>

	<script type="text/javascript">

		$(document).ready(
			function ()
			{
				$('#redactor_content').redactor({
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: [
						'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
						'video', 'image', 'table', '|',
						'alignment', '|', 'horizontalrule'
					]
				});
				$('[rel=tooltip]').tooltip();
				var loading = $('#loading_img');
				loading.removeClass('loading_img');


			}
		);


		function select_rec(str)
		{

			var content = $('#div_recipients');
			content.fadeOut();
			content.addClass('loading_img');

			$.ajax({
				type: 'post',
				cache: false,
				data: {mailbody: str},
				url: '<?php echo site_url('/').'ntb/show_email_recipients/';?>' + str,
				success: function (data)
				{

					content.html(data);
					content.removeClass('loading_img');
					content.fadeIn();
				}
			});

		}


		function preview()
		{

			var content = $('#admin_content'), str = $('#redactor_content').val(), loading = $('#loading_img'), preview = $('#preview');
			content.slideUp();
			loading.addClass('loading_img');

			$.ajax({
				type: 'post',
				cache: false,
				data: {mailbody: str},
				url: '<?php echo site_url('/').'ntb/preview_news/';?>',
				success: function (data)
				{
					$('#preview_button').show();
					preview.html(data);
					loading.removeClass('loading_img');
					preview.slideDown();
				}
			});

		}

		/*$('#send_mail_btn').click(function(e){

		 e.preventDefault();
		 if(!$('#title').val().length == 0){

		 $('#modal-email').bind('show', function() {

		 $('#send_email_yes').unbind('click').click( function() {

		 var bar = $('#barcover .bar');
		 var barcover = $('#barcover');
		 var frm = $('#sendmail');
		 barcover.show();
		 $('#send_email_yes').html('<img src="<?php //echo base_url('/').'img/load.gif';?>" /> Sending...');
		 frm.attr('action','<?php //echo site_url('/').'ntb/send_email/';?>');

		 $.ajax({
		 type: 'post',
		 data:	frm.serialize(),
		 url: frm.attr( 'action' ),
		 success: function(data) {
		 $('#result_cover').html(data);

		 $('#send_email_yes').html('Sent');
		 barcover.hide();
		 }
		 });

		 });

		 })
		 .modal({ backdrop: true });
		 }else{

		 $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Subject Required", content:"Please give the newsletter a valid and enticing subject line."});
		 $('#title').popover('show');
		 $('#title').focus();

		 }

		 });*/

		$('#send_mail_btn').click(function (e)
		{

			e.preventDefault();
			if (!$('#title').val().length == 0)
			{

				$('#modal-email').bind('show', function ()
				{

					$('#send_email_yes').unbind('click').click(function ()
					{

						var bar = $('#barcover .bar'), loading = $('#loading_img');
						var barcover = $('#barcover');
						var frm = $('#sendmail');
						barcover.show();
						frm.attr('action', '<?php echo site_url('/').'ntb/send_email/';?>');
						frm.attr('target', 'load_frame');
						$('#send_email_yes').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');

						$.ajax({
							type: 'post',
							cache: false,
							data: frm.serialize(),
							url: '<?php echo site_url('/').'ntb/send_email/';?>',
							success: function (data)
							{
								//barcover.hide();

								$('#result_cover').html(data);
							}
						});

					});

				})
					.modal({backdrop: true});
			} else
			{

				$('#title').popover({
					delay: {show: 100, hide: 3000},
					placement: "top",
					html: true,
					trigger: "manual",
					title: "Subject Required",
					content: "Please give the newsletter a valid and enticing subject line."
				});
				$('#title').popover('show');
				$('#title').focus();

			}

		});


		<?php   /**
		* ++++++++++++++++++++++++++++++++++++++++++++
		* //TIMELINE SCROLL SPY
		* //Functions
		* ++++++++++++++++++++++++++++++++++++++++++++
		 */
		 ?>
		//TimeLine Navigation


	</script>

</body>
</html>