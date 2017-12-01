<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register - My Nmaibia&trade;">
    <meta name="author" content="My Namibia">
    <link rel="icon" href="<?php echo base_url('/');?>favicon.ico">

    <title>Register - My Namibia&trade;</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/');?>bootstrap/css/bootstrap.min.css?v1" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="//getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>

    <div class="container">
      	  <div class="row">
          		
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1 text-right">
                
               		 <a href="<?php echo site_url('/');?>nmh/register/" class="btn btn-default" style="margin-top:10px;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                    
                </div>
           </div>  
           <p>&nbsp;</p>   
          <div class="row">
          		
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">
                	
                	<form class="form-horizontal" action="<?php echo site_url('/');?>nmh/register_me/" id="member-register">
                    	<input type="hidden" name="country" value="<?php echo $country;?>">
                        <input type="hidden" name="city" value="<?php echo $city;?>">
                        <input type="hidden" name="suburb" value="">
                    	<div class="form-group  has-feedback">
                            <label for="fname" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="fname" id="fname"  placeholder="First Name">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                          <div class="form-group  has-feedback">
                            <label for="lname" class="col-sm-2 control-label">Last Name</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" name="lname" id="lname" placeholder="Last Name">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                         
                          <div class="form-group  has-feedback">
                             <label for="email" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                              <input type="email" class="form-control" id="email" name="email" placeholder="Email">
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
                              <input type="text" class="form-control" id="cell" autocomplete="off" onkeypress="return isNumberKey(event)"  name="cell" placeholder="Cellphone Number">
                              <span class="glyphicon glyphicon-ok form-control-feedback hide text-success" aria-hidden="true"></span>
                            </div>
                          </div>
                          
                          <div class="form-group  has-feedback">
                            <label for="pass" class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="pass" name="pass" placeholder="Password">
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
                            <div class="col-sm-8">
                                <p class="mute">Already have an account? <a target="_self" href="<?php echo site_url('/');?>members/">Sign in here</a></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="col-sm-12"  id="result_msg">


                            </div>
                         </div>
                      </form>
                
                </div>
          		
          </div>
    
    </div><!-- /.container -->

</body>



<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>bootstrap/js/bootstrap.min.js?v1"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>
<!--<script type="text/javascript" src="//select2.github.io/dist/js/select2.full.js"></script>-->
<!--<script src="<?php echo base_url('/'); ?>js/custom/fb.js"></script>-->

<script type="text/javascript">

    $(document).ready(function(){
		
		$('#fl_select').on('click', function(e){
			
			e.preventDefault();
		});

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
							$('#result_msg').html(data['html']);
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


    });


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