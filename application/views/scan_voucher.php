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
				<h1>NTE 2016 Voucher Scanner</h1>
				<p>Type Unique code here</p>
					<form id="vouch_frm">

						<input type="text" id="vouch_code" name="vouch_code" class="disabled">
						<input type="hidden" id="voucher_id" name="voucher_id">
						<button id="butt" class="btn">Get Voucher</button>
						<button id="butt2" class="btn hide">Claim Voucher Now</button>
					</form>
					<div id="msg"></div>
				<p>
					Use the barcode scanner to scan the voucher QR code.
				</p>
			</div>
		</div>
	</div>


	<script src="//code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>


	<script type="text/javascript">

		/*var BarcodeScanerEvents = function() {
			this.initialize.apply(this, arguments);
		};

		BarcodeScanerEvents.prototype = {
			initialize: function ()
			{
				$(document).on({
					keyup: $.proxy(this._keyup, this)
				});
			},
			_timeuotHandler: 0,
			_inputString: '',
			_keyup: function (e)
			{
				if (this._timeuotHandler)
				{
					clearTimeout(this._timeuotHandler);
					this._inputString += String.fromCharCode(e.which);
				}

				this._timeuotHandler = setTimeout($.proxy(function ()
				{
					if (this._inputString.length <= 3)
					{
						this._inputString = '';
						return;
					}

					$(document).trigger('onbarcodescaned', this._inputString);

					this._inputString = '';

				}, this), 20);
			}

		}
*/

		// only init when the page has loaded
		$(document).ready(function() {
			// variable to ensure we wait to check the input we are receiving
			// you will see how this works further down
			var pressed = false;
			// Variable to keep the barcode when scanned. When we scan each
			// character is a keypress and hence we push it onto the array. Later we check
			// the length and final char to ensure it is a carriage return - ascii code 13
			// this will tell us if it is a scan or just someone writing on the keyboard
			var chars = [];
			// trigger an event on any keypress on this webpage
			$(window).keypress(function(e) {
				// check the keys pressed are numbers
				if (e.which >= 48 && e.which <= 57) {
					// if a number is pressed we add it to the chars array
					chars.push(String.fromCharCode(e.which));
				}
				// debug to help you understand how scanner works
				console.log(e.which + ":" + chars.join("|"));
				// Pressed is initially set to false so we enter - this variable is here to stop us setting a
				// timeout everytime a key is pressed. It is easy to see here that this timeout is set to give
				// us 1 second before it resets everything back to normal. If the keypresses have not matched
				// the checks in the readBarcodeScanner function below then this is not a barcode
				if (pressed == false) {
					// we set a timeout function that expires after 1 sec, once it does it clears out a list
					// of characters
					setTimeout(function(){
						// check we have a long length e.g. it is a barcode
						if (chars.length >= 10) {
							// join the chars array to make a string of the barcode scanned
							var barcode = chars.join("");
							// debug barcode to console (e.g. for use in Firebug)
							console.log("Barcode Scanned: " + barcode);
							// assign value to some input (or do whatever you want)
							$("#vouch_code").val(barcode);
						}
						chars = [];
						pressed = false;
					},500);
				}
				// set press to true so we do not reenter the timeout function above
				pressed = true;
			});
		});
		// this bit of code just ensures that if you have focus on the input which may be in a form
		// that the carriage return does not cause your form to be submitted. Some scanners submit
		// a carriage return after all the numbers have been passed.
		$("#vouch_code").keypress(function(e){

			if ( e.which === 13 ) {
				console.log("Prevent form submit.");
				e.preventDefault();
			}
		});


		$(function(){


			$("#vouch_code").focus();

			$('#butt').on('click', function(e){

				e.preventDefault();
				var frm = $('#vouch_frm');
				$('#butt').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Claiming...');
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('/').'scan/claim_voucher_scan/';?>' ,
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