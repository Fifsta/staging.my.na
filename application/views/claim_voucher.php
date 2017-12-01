<!DOCTYPE HTML>
<html>
<head>
  <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet" />
</head>
<body>

	<br/>

	<div class="container">
		<div class="row">
			<div class="span12">
				<!--<form>
					<input
						type="text"
						class="span6 typeahead"
						placeholder="Who was your favorite James Bond?"
						autocomplete="off"
						data-provide="typeahead"
					/>
					<br/>
					<input type="text" class="span1" name="bondId" id="bondId" value="" />
				</form>-->
			</div>
		</div>
		<div class="row">
			<div class="span12">
				<h1>NTE 2016 Claim Voucher System</h1>
				<p>Type Unique code here</p>
					<form id="vouch_frm">

						<input type="text" id="vouch_code" name="vouch_code">
						<input type="hidden" id="voucher_id" name="voucher_id">
						<button id="butt" class="btn">Get Voucher</button>
						<button id="butt2" class="btn hide">Claim Voucher Now</button>
					</form>
					<div id="msg"></div>
				<p>
					Type in the voucher number presented.
				</p>
			</div>
		</div>
	</div>


	<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>


	<script type="text/javascript">
		$(function(){

			$('#butt').on('click', function(e){

				e.preventDefault();
				var frm = $('#vouch_frm');
				$('#butt').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Claiming...');
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('/').'scan/claim_voucher/';?>' ,
					data: frm.serialize(),
					dataType:"json",
					success: function (data) {

						$('#butt').html('Get Voucher');

						if(data.success){

							$('#butt2').removeClass('hide');
							$('#voucher_id').val(data.voucher_id)
							$('#msg').html('<div class="alert alert-success">'+data.msg+'</div>');
						}else{

							$('#msg').html('<div class="alert alert-danger">'+data.msg+'</div>');
						}
						console.log(data);


					}
				});



			});


			$('#butt2').on('click', function(e){

				e.preventDefault();
				var frm = $('#vouch_frm');
				$('#butt2').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Claiming...');
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('/').'scan/claim_voucher_do/';?>' ,
					data: frm.serialize(),
					dataType:"json",
					success: function (data) {

						$('#butt2').html('Claim Voucher');

						if(data.success){

							$('#butt2').removeClass('hide');
							$('#msg').html('<div class="alert alert-success">'+data.msg+'</div>');

							window.setTimeout(function(e){

								window.location.reload();

							}, 3000);

						}else{
							$('#msg').html('<div class="alert alert-danger">'+data.msg+'</div>');

						}
						console.log(data);


					}
				});



			});


		});
	</script>
</body>
</html>