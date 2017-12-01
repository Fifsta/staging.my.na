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
	<title>My Namibia ADMIN</title>
	<meta name="viewport" content="width=device-width">
 
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css">
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
<!--    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://ebooks.my-child.co.nz/144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://ebooks.my-child.co.nz/114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://ebooks.my-child.co.nz/72.png">
    <link rel="apple-touch-icon-precomposed" href="https://ebooks.my-child.co.nz/57.png">-->
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>

    <style type="text/css">
      body {
        padding-top: 0px;
       
        background-color: #f5f5f5;
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

	
    <div id="home-bak" style="padding-top:0;width:100%;height:100%;bottom:0">
         <div class="container" style="position:relative;z-index:999">
                        
              <form style="margin-top:15%;" class="form-signin" method="post" action="<?php echo site_url('/');?>my_admin/login/">
                <h4 class="form-signin-heading">Please sign into the Admin Section</h4>
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
                <input type="text" class="input-block-level" name="email" id="email" placeholder="Email address">
                <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
                <label class="checkbox">
                  <input type="checkbox" value="remember-me"> Remember me
                </label>
                <button class="btn btn-large btn" type="submit"><b>Sign in</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png"/></button>
              </form>
        
            </div> <!-- /container -->
		</div>
      
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


</body>
</html>