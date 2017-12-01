 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = 'Facebook App - My Namibia';
	 $header['metaD'] = 'Facebook App - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = 'Facebook App - My Namibia';
	 $header['metaD'] = 'Facebook App - My Namibia';
	 $header['section'] = '';
	 
 }
  $this->load->view('inc/header', $header);

 ?>
 <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


</head>

<body style="overflow:hidden">

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 //$this->load->view('inc/navigation', $nav);
 ?>
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
     <!-- Begin page content -->
       <div class="container" id="home_container">
       	 <div class="clearfix"></div>
		  <div class="row hidden-phone">
              <div class="span12 text-center">
                  <h1>FIND WHAT YOU <span class="na_script" style="font-size:66px">!na</span> | <span class="na_script" style="font-size:66px">!na</span> WHAT YOU FIND</h1>
              </div>
         </div>
         <div class="row">
				 <?php 
                 //+++++++++++++++++
                 //LOAD DEAL SEARCH BOX
                 //+++++++++++++++++
                 
                 $this->load->view('inc/home_search');
                 
                 //HEading Box
                 ?>
         </div>
		 <div class="row hidden-phone">
              <div class="span12 text-center">
                  <h2>SELL WHAT YOU DON'T <span class="na_script" style="font-size:56px">!na</span> | <span class="na_script" style="font-size:56px">!na</span> WHAT YOU BUY</h2>
                  
              </div>
        </div>
         <div class="clearfix">&nbsp;</div>
		 <div class="row hidden-phone">
              <div class="span12 text-center">
                  <h1>CREATE A <span class="na_script" style="font-size:56px">FREE</span> ACCOUNT AND START SELLING YOUR <span class="na_script" style="font-size:56px">STUFF</span></h1>
                  
              </div>
        </div>
		
         
        <div class="row-fluid">
            <div class="span6 text-right">
                <h3>Use Facebook</h3>
                <p>Use your facebook account to register your details</p>
                    
                    <div class="fb-login-button padding5" data-size="xlarge" data-scope="public_profile,email,user_birthday" data-max-rows="1" data-size="medium" data-show-faces="false" onClick="checkLoginState()" data-auto-logout-link="false"></div>
                   
                    <div id="status"></div>
            </div>
            <div class="span6">
                <h3>Use My Namibia</h3>
                <p>Register your details using the standard way</p>
 				<a href="<?php echo site_url('/').'members/register/';?>" class="btn btn-success btn-large"><i class="fa fa-cloud-upload fa-lg"></i> Register</a>
            </div>
         </div>
 		 <div class="clearfix">&nbsp;</div>
		 <div class="row hidden-phone">
              <div class="span12 text-center">
                  <i class="fa fa-arrow-circle-down fa-4x"></i>
                  
              </div>
        </div>

        <div class="row-fluid">
            <div class="span6 text-right">
                <h3>Make some Cash  <i class="fa fa-money fa-lg"></i></h3>
                <p>List an item in a few easy steps and turn them into hard CASH. Your junk is another <br />man's gold. Why not try it yourself tody?</p>
                    <a href="<?php echo site_url('/').'members/register/';?>" class="btn btn-success btn-large"><i class="fa fa-money fa-lg"></i> List an Item FREE</a>
     
            </div>
            <div class="span6">
                <h3><i class="fa fa-gavel fa-lg"></i>  Start an online Auction</h3>
                <p>Namibias first and only real online auction system. Set a starting bid and reserve and watch <br />the bids come flying in.</p>
                    <a href="<?php echo site_url('/').'members/register/';?>" class="btn btn-success btn-large"><i class="fa fa-gavel fa-lg"></i> Start an Auction</a>

            </div>
         </div>

         <div class="clearfix">&nbsp;</div>
         
         <div class="row-fluid">
                <div class="span3">
                    <a id="pop_cats_bt" class="btn btn-inverse btn-block">Business Categories <i class="icon-chevron-right icon-white"></i></a>
                    <div class="clearfix padding2"></div>
               </div>
                <div class="span3">
                    <a href="<?php echo site_url('/');?>trade/" class="btn btn-inverse btn-block">Buy &amp; Sell <i class="icon-chevron-right icon-white"></i></a>
                    <div class="clearfix padding2"></div>
               </div>
                <div class="span3">
                    <a href="<?php echo site_url('/');?>buy/property/" class="btn btn-inverse btn-block">Property <i class="icon-chevron-right icon-white"></i></a>
                    <div class="clearfix padding2"></div>
               </div>
                <div class="span3">
                    <a href="<?php echo site_url('/');?>buy/car-bikes-and-boats/" class="btn btn-inverse btn-block">Cars <i class="icon-chevron-right icon-white"></i></a>
                    <div class="clearfix padding2"></div>
               </div>
    
         </div>
        
         <div class="row-fluid">
			
         </div>


       	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:100px;"></div>
     	
      	

   
  <div class="msg_div" id="msg"></div>
    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 //$this->load->view('inc/footer', $footer);
  //$this->output->enable_profiler(TRUE);
 
 ?>  
 </div><!-- /wrap  -->
 
 <div class="modal hide fade in" id="img_modal_div" style="width:auto">
 	<img style="display*: inline;display:inline-block" src="<?php echo base_url('/');?>img/deal_place_load.gif" id="img_modal" />
 </div>   
    
    
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

	<script type="text/javascript">
    var site = '<?php echo site_url('/');?>';
    var base = '<?php echo base_url('/');?>';
	
    $(document).ready(function(){
		$('[rel=tooltip]').tooltip();
		
		
	});
	
	  // This is called with the results from from FB.getLoginStatus().
	  function statusChangeCallback(response) {
		// The response object is returned with a status field that lets the
		// app know the current login status of the person.
		// Full docs on the response object can be found in the documentation
		// for FB.getLoginStatus().
		if (response.status === 'connected') {
		  // Logged into your app and Facebook.
		  testAPI();
		} else if (response.status === 'not_authorized') {
		  // The person is logged into Facebook, but not your app.
		  document.getElementById('msg').innerHTML = 'Please log ' +
			'into this app.';
		} else {
		  // The person is not logged into Facebook, so we're not sure if
		  // they are logged into this app or not.
		  document.getElementById('msg').innerHTML = 'Please log ' +
			'into Facebook.';
		}
	  }
	
	  // This function is called when someone finishes with the Login
	  // Button.  See the onlogin handler attached to it in the sample
	  // code below.
	  function checkLoginState() {
		FB.getLoginStatus(function(response) {
		  statusChangeCallback(response);
		});
	  }


      window.fbAsyncInit = function() {
			FB.init({
			  appId      : '287335411399195',
			  xfbml      : true,
			  cookie     : true,  
			  version    : 'v2.1'
			});
	
			// ADD ADDITIONAL FACEBOOK CODE HERE
			function onLogin(response) {
			  if (response.status == 'connected') {
				FB.api('/me?fields=first_name', function(data) {
				  var welcomeBlock = document.getElementById('msg');
				  welcomeBlock.innerHTML = 'Hello, ' + data.first_name + '!';
				});
			  }
			}
			
			FB.getLoginStatus(function(response) {
			  // Check login status on load, and if the user is
			  // already logged in, go directly to the welcome message.
			  if (response.status == 'connected') {
				onLogin(response);
			  } else {
				// Otherwise, show Login dialog first.
				FB.login(function(response) {
				  onLogin(response);
				}, {scope: 'user_friends, email,user_birthday'});
			  }
			});

   	  };
	
	 (function(d, s, id){
		 var js, fjs = d.getElementsByTagName(s)[0];
		 if (d.getElementById(id)) {return;}
		 js = d.createElement(s); js.id = id;
		 js.src = "//connect.facebook.net/en_US/sdk.js";
		 fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));

	
	 // Here we run a very simple test of the Graph API after login is
	  // successful.  See statusChangeCallback() for when this call is made.
	  function testAPI() {
		console.log('Welcome!  Fetching your information.... ');
		FB.api('/me', function(response) {
		  console.log('Successful login for: ' + response.name);
		  document.getElementById('msg').innerHTML =
			'Thanks for logging in, ' + response.name + '!';
			goregister(response);
			
		});
	  }
	  
	  
	  function goregister(response){
		console.log(response);  
		$.ajax({
				type: 'POST',
				data: response,
				cache: false,
				url: '<?php echo site_url('/').'fb/login/';?>',
				success: function (data) {
	
						 $('#result').html(data);	   	
				}
			});
		  
	  }
	  
	  
	  
</script>

	
    <!--<script type="text/javascript" src="<?php echo  base_url('/');?>js/custom/home1.js?=v2"></script>-->
	


</body>
</html>