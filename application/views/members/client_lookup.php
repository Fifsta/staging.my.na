<?php
$getstr = '';
if ($getstr = $this->input->get())
{
    $getstr = '?'.http_build_query($getstr);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register - My Nmaibia&trade;">
    <meta name="author" content="My Namibia">
    <link rel="icon" href="<?php echo base_url('/');?>favicon.ico">
	<base href="<?php echo base_url('/');?>"/>
    <title>Client lookup - Register - My Namibia&trade;</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/');?>bootstrap/css/bootstrap.min.css?v1" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="//getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
 	<link rel="stylesheet" href="<?php echo base_url('/');?>css/animate_test.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
		body{overflow-x:hidden}
		#pre_load {
			width: 100%;
			height: 100%;
			position: fixed;
			top: 0;
			left: 0;
			background:  rgba(255,153,0,0.9);
			z-index: 10;
			color: #fff;}
		.slogo{
			position: absolute;
			display:inline-block;
			width: 220px;
			height: 60px;
			z-index: 15;
			top: 45%;
			left: 50%;
			margin: -30px 0 0 -110px;

		}
		.slogo a{display:block; margin-bottom:5px}
		/*.slogo img{height:50px; width:auto; display:block}*/
		.slogo div{color:#fff; display:block; text-align:center; font-size:120%; white-space:nowrap}


	</style>
  </head>
<body>

	<div id="pre_load" class="text-center" style="margin:auto;vertical-align:center">
		<div class="slogo animated pulse infinite">
			<a href="javascript:void();"><img src="img/logo-main.png"></a>
			<div>find &#183; list &#xb7; buy &middot; sell<br><br>TOUCH HERE</div>
		</div>
	</div>


	<div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 text-right">
            <p>&nbsp;</p>
            	<a href="<?php echo current_url('/').$getstr;?>" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
            </div>
         </div>
    </div>                
    <div class="container"  id="client_lookup">
    		
          <div class="row">
            	<div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                	<h1 class="na_script">Lookup Client <small>Find Your account</small><a data-current="client_lookup" class="switch_view btn btn-default pull-right">
                    							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> New Account</a></h1>
                	<form class="" id="member-lookup">
                           <div class="input-group">
                              <input type="text" class="form-control keyboard-normal" name="fname" id="user_name_srch"  placeholder="Name, Email, Cellphone">
                              <span class="input-group-btn">
                                <button class="btn btn-default" id="go_btn" type="button">Go!</button>
                              </span>
                            </div><!-- /input-group -->
                    </form>
                </div>

         </div>
     	 <div class="row">
                 <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1" style="max-height:350px; overflow-y:scroll">
                	
                	<table class="table table-striped table-responsive" style="display:none">
                    	<thead>
                        	<tr>
                            	<th style="width:30%">Name</th>
                                <th style="width:30%">Email</th>
                                <th style="width:30%">CellPhone</th>
                                <th style="width:10%"></th>
                            </tr>
                        </thead>
                        <tbody id="add_user_div" >
                           <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>
                        </tbody>
                    </table>
                    
                </div>
         
         </div>
     </div>
      <div class="container hide" id="register_u">   
          <div class="row">
          		<div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                	<h1 class="na_script">Register Client <small>Create Your account</small>
                    	<a  data-current="register_u" class="switch_view btn btn-default pull-right">
                        	<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Client Lookup</a></h1>
                    
                 </div>   
                    							
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                	<form class="form-horizontal" action="<?php echo site_url('/');?>nmh/register_me/" id="member-register">
                    	<input type="hidden" name="country" value="<?php echo $country;?>">
                        <input type="hidden" name="city" value="<?php echo $city;?>">
                        <input type="hidden" name="suburb" value="">
                        <input type="hidden" name="register_ref" value="nmh_classifieds">
                    	<div class="form-group  has-feedback">
                            <label for="fname" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control keyboard-normal" name="fname" id="fname"  placeholder="First Name">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                          <div class="form-group  has-feedback">
                            <label for="lname" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control keyboard-normal" name="lname" id="lname" placeholder="Last Name">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                         
                          <div class="form-group  has-feedback">
                             <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                              <input type="email" class="form-control keyboard-email" id="email" name="email" placeholder="Email">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                              <span class="help-block" style="font-size:11px" id="email_help_div">This is your accounts unique identifier, must be unique</span>
                            </div>
                          </div>
                          <div class="form-group  has-feedback">
                            <label for="cell" class="col-sm-2 col-xs-12 control-label">Mobile</label>
                            <div class="col-sm-3 col-xs-4">
                            <?php echo $this->my_na_model->get_countries(0,false,false);?>

                            </div>
                            <div class="col-sm-7 col-xs-8">
                              <input type="text" class="form-control keyboard-numbers  keyboard-numbers" id="cell" autocomplete="off" onkeypress="return isNumberKey(event)"  name="cell" placeholder="Cellphone Number">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                          
                          <div class="form-group  has-feedback">
                            <label for="pass" class="col-sm-2 control-label ">Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control keyboard-normal" id="pass" name="pass" placeholder="Password">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                          
                           <div class="form-group">
                            <label  class="col-sm-2 control-label"></label>
                            <div class="col-sm-10">
                              <?php 
                                   $this->my_na_model->build_captcha();
                                            
                                 ?>
                            </div>
                          </div>
                          
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                              <div class="checkbox">
                                <label>
                                  <input type="checkbox" id="terms"> I Agree to the Terms and Conditions
                                  <span id="check_me" class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                                </label>
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-2">
                              <button type="submit" id="butt" class="btn btn-default">Register</button>
                            </div>
                            <div class="col-sm-8" id="result_msg">
                              
                            </div>
                          </div>
                      </form>
                
                </div>
          		
          </div>
    
    </div><!-- /.container -->

	<div class="container" style="position:fixed; bottom:10px;margin: 0 auto; text-align:center">

				<img src="img/nmh_brands.jpg?v1">

	</div>




	<div class="modal fade" tabindex="-1" role="dialog" id="acount_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">


        <form class="form-inline">
	        <input type="hidden" id="client_id" name="client_id" value="">
	        <input type="hidden" id="client_verfied" name="client_verfied" value="">
	        <input type="hidden" id="client_link" name="client_link" value="">
	        <div  id="verify_me">

		        <div id="verify_1">
			        <p><i class="glyphicon glyphicon-lock pull-left" style="font-size:50px; margin:0 10px 0 0" aria-hidden="true"></i><strong>Please verify your account</strong><br />
				        To verify your account and confirm your mobile number below and send a 4 digit code for verification. (Only Namibian numbers allowed)</p>
			        <div class="form-group">
				        <label class="sr-only" for="cellnumber"></label>
				        <div class="input-group">
					        <div class="input-group-addon"><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span></div>
					        <input type="text" class="form-control keyboard-numbers" id="cellnumber" name="cellnumber" placeholder="0811234444">

				        </div>
				        <a class="btn btn-default" data-loading-text="Sending..." onclick="send_verify_code();">Send Code</a>
				        <p class="help-block">please enter only 081 123 4444 (10 digits)</p>
			        </div>

		        </div>
		        <div id="verify_2" class="hide">
			        <p><strong>Please verify your account</strong></p>
			        <p>To verify your account and setusase confirm your mobile number below and send a 4 digit code for verification. (Only Namibian numbers allowed)</p>
			        <div class="form-group">
				        <label class="sr-only" for="verify_code"></label>
				        <div class="input-group">
					        <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
					        <input type="text" class="form-control keyboard-numbers" id="verify_code" name="verify_code" placeholder="1234">

				        </div>
			        </div>
			        <a class="btn btn-default" data-loading-text="Verifying..." onclick="verify_code();">Verify Code</a>
			        <a class="btn btn-sml" data-loading-text="Verifying..." onclick="swap_verify();">Resend</a>

		        </div>
		        <div id="verify_3" class="hide">
			        <p><strong>Please enter the One Time PIN</strong></p>
			        <p>Keeping your account secure is our utmost priority. To verify your selection we have sent an OTP. Please enter it below to use the account.</p>
			        <div class="form-group">
				        <label class="sr-only" for="otp_verify_code"></label>
				        <div class="input-group">
					        <div class="input-group-addon"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></div>
					        <input type="text" class="form-control keyboard-numbers" id="otp_verify_code" name="otp_verify_code" placeholder="1234">

				        </div>
			        </div>
			        <a class="btn btn-default" data-loading-text="Verifying..." onclick="otp_verify_code();">Verify Code</a>
		        </div>

		    </div>
        </form>
	      <br />
		<p id="res_msg"></p>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary hide" id="use_me_btn">Yes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

</body>



<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>bootstrap/js/bootstrap.min.js?v1"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>
<!--<script type="text/javascript" src="//select2.github.io/dist/js/select2.full.js"></script>-->
<!--<script src="<?php echo base_url('/'); ?>js/custom/fb.js"></script>-->
<?php
//TEMP PATCH FOR NMH LISTING CLASSIFIEDS
if($this->input->get('nmh_classifieds')){ ?>
	<link rel="stylesheet" href="<?php echo base_url('/');?>keyboard/css/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>keyboard/css/keyboard.css">
	<style type="text/css">
		.navbar,.footer,#back_to_all{display:none}
		
	</style>
    <script src="<?php echo base_url('/');?>keyboard/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('/');?>keyboard/js/jquery.keyboard.js"></script>
	<script>
	function init_keyboard(){
			$('.keyboard-numbers').keyboard({
				layout: 'custom',
				autoAccept : true,
				customLayout: {
					'default' : [
						'7 8 9',
						'4 5 6',
						'1 2 3',
						'0',
						'{bksp} {accept}'
					]
				},
				accepted : function(event, keyboard, el) {
                    console.log('The content "' + el.value + '" was accepted!');
					otp_verify_code();
                },
			});
			$('.keyboard-email').keyboard({
				layout: 'custom',
				autoAccept : true,
				customLayout: {
					'default' : [
						'1 2 3 4 5 6 7 8 9 0 {bksp}',
						'q w e r t y u i o p',
						'a s d f g h j k l',
						'z x c v b n m @ .',
						'{space} .com .com.na _ - {accept}'
					]
				}
			});
			$('.keyboard-normal').keyboard({
				layout: 'custom',
				autoAccept : true,
				customLayout: {
					'default' : [
						'1 2 3 4 5 6 7 8 9 0',
						'q w e r t y u i o p',
						'a s d f g h j k l {bksp}',
						'{shift} z x c v b n m {shift}',
						'{space} - {accept}'
					],
					'shift' : [
						'Q W E R T Y U I O P',
						'A S D F G H J K L {bksp}',
						'{shift} Z X C V B N M {shift}',
						'{space} - {accept}'
					]
				},
				accepted : function(event, keyboard, el) {
                    console.log('The content "' + el.value + '" was accepted!');
					$("#go_btn").click();
                },
			});
	}
	
	</script>
<?php } else{ ?>
	<script>
	function init_keyboard(){
			
	}
	
	</script>
	
<?php } ?>
<script type="text/javascript">

    $(document).ready(function(){


	    $('#pre_load').on('click', function(e){

		    $(this).fadeOut();
	    });



	    //$('#acount_modal').modal('show');
		init_keyboard();
        $('#butt').on('click',function(e) {
            e.preventDefault();
			var check = $('#terms'), btn = $(this);
			if(check.prop('checked') == true) {
			
				 var frm = $('#member-register');
				//frm.submit();
				btn.html('Working...');
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('/').'nmh/register_me/';?>' ,
					data: frm.serialize(),
					dataType: 'json',
					success: function (data) {
	
						if(data['success']){
							
							btn.html('Register');
							$('#result_msg').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">�</button>Registered successfuly, please lookup your account</div>');

							window.location.reload();

						}else{
							$('#result_msg').html(data['html']);
							grecaptcha.reset();
							btn.html('Register');
						}
					}
				});
			}else{
				btn.html('Register');
				$('#check_me').removeClass('text-success hide glyphicon-ok').addClass('text-danger glyphicon-remove');
				
				
			}
        });

		$("#terms").change(function() {
			if(this.checked) {
				$('#check_me').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
			}else{
				$('#check_me').removeClass('text-success hide glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
		});
		$('#email').on("change keyup", function() {

            var str = $(this), div = $('#email_help_div'), email = $('#email').val();
            if(str.val().length > 3 ){

                if(validateEmail(str.val())){

                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url('/').'members/validate_user_email';?>' ,
                        dataType: 'json',
                        data: {'email': email},
                        success: function (data) {
                            

                            if(data.success){
								div.html('<span class="text-success">'+data.msg+'</span>');
								str.siblings('span.glyphicon').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
                            }else{
								div.html('<span class="text-danger">'+data.msg+'</span>');
								str.siblings('span.glyphicon').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
                            }
                        }
                    });

                }else{

					str.siblings('span.glyphicon').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
                    div.html('<span class="alert-danger">Not a valid email format...</span>');
                }

            }else{
				
				str.siblings('span.glyphicon').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}

        });
		
		$('#fname').on("change keyup", function() {
			var str = $(this)
			if(str.val().length > 3){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
		});
		$('#lname').on("change keyup", function() {
			var str = $(this)
			if(str.val().length > 3){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
		});

		$('#pass').on("change keyup", function() {
			var str = $(this)
			if(str.val().length > 3){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
		});

		//reloadSearch();
					  
		$("#go_btn").on('click',function(e){
			e.preventDefault();
			isDirty = true;
			reloadSearch();
		});
		
		$('.switch_view').on('click',function(e){
			
			var cur = $(this).data('current');
			console.log(cur);
			if(cur == 'client_lookup'){
				
				
				$('#'+cur).addClass('animated slideOutRight');
				window.setTimeout(function(){
					$('#register_u').addClass('animated slideInLeft').removeClass('hide');
					$('#'+cur).addClass('hide').removeClass('animated slideOutRight');
				}, 500);
				
				
			}else{
				
			
				$('#'+cur).addClass('animated slideOutLeft ');
				window.setTimeout(function(){
					$('#client_lookup').addClass('animated slideInRight ').removeClass('hide');
					$('#'+cur).addClass('hide').removeClass('animated slideOutLeft');
				}, 500);
			}
				
		});
		
    });
	

	
	
	var delay = 1000;
	var isLoading = false;
	var isDirty = false;
	function reloadSearch() {
	  if(!isLoading){
		  var q = $("#user_name_srch").val();
		   if (q.length >= 3) {
			  isLoading = true;
			   var div = $("#add_user_div");
			   div.parent('table').fadeOut();
			   div.html('');

			   $.getJSON("<?php echo  site_url('/') . 'sell/find_client/';?>?q="+encodeURIComponent(q), function(data) {

				   console.log(data);
				  if(data.success){
					  	var obj = data.result;
						obj.forEach(function(item, index){
								
								var row = render_member(item);
								div.append(row);
								//console.log(item.FNAME+' ' +index);
							
						}); 
						//isLoading=false; 
				  }
				  //div.html(data);
				  div.parent('table').fadeIn();
				  //div.removeClass("hide");
				});
			   
			   // enforce the delay
			   setTimeout(function(){
				 isLoading=false;
				 if(isDirty){
				   isDirty = false;
				   
				 }
			   }, delay);
		   }
		 }
	};

    function render_member(obj) {
        
		
		var res = '<tr><td>'+obj.FNAME+' '+obj.SNAME+'</td><td>'+scramble(obj.EMAIL)+'</td><td>'+scramble(obj.CELL)+'</td><td class="text-right"><a href="javascript:use_account('+"'"+obj.ACC_link+"'"+",'"+obj.VERIFIED+"','"+obj.CELL+"'"+",'"+obj.ID+"'"+');" class="btn btn-default btn-md">Use</a></td></tr>';
		return res;
		
    }
	function scramble(txt) {
        
		if(txt != '' && txt != null){
			
			var len = txt.toString().length;
			var chars = Math.round(len / 4);
			var emailstart = '', email = '';
			
			var patt = new RegExp("@");
			//EMAIL
			if(patt.test(txt) === true){
				
				emailstart = txt.substr(0, txt.indexOf('@',0));
				email = txt.substr(0, txt.indexOf('@',0));
				var match_ = email.substr(chars, chars);
				var replace_ = '';
				for (i = 0; i < chars; i++) { 
					replace_ += "*";
				}
				txt = txt.replace(match_, replace_);
			//CELL + OTHERS
			}else{
				
				var match_ = txt.substr(chars, chars);
				var replace_ = '';
				for (i = 0; i < chars; i++) { 
					replace_ += "*";
				}
				txt = txt.replace(match_, replace_);
				
			}
			//console.log(match_+' ' +replace_+' length: '+len+' chars: '+chars);
			return txt;
			
		}else{
			return '';
		}
		
		
    }


	function use_account(idlink,verified, cell, id){
		
		$('#acount_modal').on('show.bs.modal', function (event) {

			  var modal = $(this)
			  var btn = $('#use_me_btn');
			  modal.find('.modal-title').text('Please confirm the below is you')
			  modal.find('.modal-body #client_id').val(id);
			  modal.find('.modal-body #cellnumber').val(cell.replace(/\D/g,''));
			  modal.find('.modal-body #client_verified').val(verified);
			  modal.find('.modal-body #client_link').val(idlink);
			  var vblock1 = $('#verify_1'), vblock2 = $('#verify_2');
			  if(verified == 'Y'){
				  //send OTP
				  vblock2.removeClass('hide');
				  vblock1.addClass('hide');
				  send_otp();
			  }else{
				  //VERIFY CLIENT
				  vblock1.removeClass('hide');
				  vblock2.addClass('hide');

			  }

			  btn.html('Yes, Use Me').addClass('animated pulse infinite');
			  
			  btn.on('click', function(e){
				  btn.button('loading')
				  e.preventDefault();
				  $.getJSON('<?php echo site_url('/');?>sell/use_account/?link='+idlink, function(data) {

						  if(data.success){
							  btn.html('Redirecting').removeClass('pulse animated');
							 window.location.href = '<?php echo site_url('/');?>sell/classifieds/?nmh_classifieds=true';
						  }else{
							  
							  
						  }
				  });
				  
				  
			  });
			  
		});
		
		$('#acount_modal').modal({show : true, backdrop: 'static', keyboard: false});
		
	}


    function swap_verify(){

	    var vblock1 = $('#verify_1'), vblock2 = $('#verify_2');
	    vblock1.toggleClass('hide');
	    vblock2.toggleClass('hide');

    }

    function send_verify_code(){


	    var cell = $('#cellnumber').val();
	    $('.btn-default').button('loading');

	    if(cell.length > 8){

		    var client_id = $('#client_id').val();
		    var client_link = $('#client_link').val();
		    var vblock1 = $('#verify_1'), vblock2 = $('#verify_2');
		    $.getJSON('<?php echo site_url('/');?>clients/send_mobile_code_plain/?link='+client_link+'&client_id='+client_id+'&number='+cell, function(data) {

			    if(data.success){

				    //window.location.href = '<?php echo site_url('/');?>sell/index/?nmh_classifieds=true';
				    $('#res_msg').html(data.msg);
				    vblock1.addClass('hide');
				    vblock2.removeClass('hide');
			    }else{

					$('#res_msg').html(data.msg);
			    }
			    $('.btn-default').button('reset');
		    });



	    }else{




	    }


    }



    function verify_code(){

	    console.log('going');
	    var code = $('#verify_code').val();

	    if(code.length > 2){
		    $('.btn-default').button('loading');
		    var client_id = $('#client_id').val();
		    var client_link = $('#client_link').val();
		    var vblock1 = $('#verify_1'), vblock2 = $('#verify_2');
		    $.getJSON('<?php echo site_url('/');?>clients/verify_mobile_code_plain/?link='+client_link+'&client_id='+client_id+'&code='+code, function(data) {

			    if(data.success){

				    //window.location.href = '<?php echo site_url('/');?>sell/index/?nmh_classifieds=true';
				    $('#res_msg').html(data.msg);
				    vblock1.addClass('hide');
				    vblock2.addClass('hide');
				    $('#use_me_btn').removeClass('hide').fadeIn().addClass('animated pulse infinite');
			    }else{
				    vblock1.removeClass('hide');
				    vblock2.addClass('hide');
				    $('#res_msg').html(data.msg);
			    }
			    $('.btn-default').button('reset');
		    });



	    }else{




	    }


    }



    function send_otp(){

	    //console.log('going');
	    var cell = $('#cellnumber').val();

	    if(cell.length > 8){
		    $('.btn-default').button('loading');
		    var client_id = $('#client_id').val();
		    var client_link = $('#client_link').val();
		    var vblock1 = $('#verify_1'), vblock2 = $('#verify_2'), vblock3 = $('#verify_3');
		    $.getJSON('<?php echo site_url('/');?>clients/send_mobile_otp_code/?link='+client_link+'&client_id='+client_id+'&number='+cell, function(data) {

			    if(data.success){

				    //window.location.href = '<?php echo site_url('/');?>sell/index/?nmh_classifieds=true';
				    $('#res_msg').html(data.msg);
				    vblock1.addClass('hide');
				    vblock2.addClass('hide');
				    vblock3.removeClass('hide');
			    }else{

				    $('#res_msg').html(data.msg);
			    }
			    $('.btn-default').button('reset');
		    });



	    }else{




	    }


    }

    function otp_verify_code(){

	    var code = $('#otp_verify_code').val();

	    if(code.length > 2){
		    $('.btn-default').button('loading');
		    var client_id = $('#client_id').val();
		    var client_link = $('#client_link').val();
		    var vblock1 = $('#verify_1'), vblock2 = $('#verify_2'), vblock3 = $('#verify_3');
		    $.getJSON('<?php echo site_url('/');?>clients/verify_mobile_otp_code/?link='+client_link+'&client_id='+client_id+'&code='+code, function(data) {

			    if(data.success){

				    //window.location.href = '<?php echo site_url('/');?>sell/index/?nmh_classifieds=true';
				    $('#res_msg').html(data.msg);
				    vblock1.addClass('hide');
				    vblock2.addClass('hide');
				    vblock3.addClass('hide');
				    $('#use_me_btn').removeClass('hide').fadeIn().addClass('animated pulse infinite');
			    }else{
				    vblock1.addClass('hide');
				    vblock2.addClass('hide');
				    $('#res_msg').html(data.msg);
			    }
			    $('.btn-default').button('reset');
		    });



	    }else{




	    }


    }



    function validateEmail(email) {
        // http://stackoverflow.com/a/46181/11236

        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

   
    function isNumberKey(evt){
        var str = $("#cell");
		var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}else{
			
			if(str.val().length >= 9){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				if(str.val().length > 10){
					return false;	
				}
			}else if(str.val().length > 10){
				
				return false;
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
			return true;
			
		} 
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
	
	
	
    </script>
</html>