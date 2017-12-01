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
 
 <link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>css/jquery.countdown.css" >
 <link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
 <link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>

</head>

<body>
 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
  $subnav['subsection'] = 'myinfo';
 
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
     <!-- Begin page content -->
       <div class="container" id="home_container">
       	 <div class="clearfix"></div>
		 <div class="row">
				 <?php 
                 //+++++++++++++++++
                 //LOAD DEAL SEARCH BOX
                 //+++++++++++++++++
                 
                 $this->load->view('inc/home_search');
                 
                 //HEading Box
                 ?>
         </div>
         
         <div class="row-fluid">
             <div class="span12">
                <h1 id="fb-welcome"></h1>
                <div class="fb-login-button" data-max-rows="1" data-size="large" data-show-faces="false" data-scope="email" onlogin="checkLoginState()" style="margin-top:-5px;padding:10px 0;" data-auto-logout-link="false"></div>
                dsd
                <!--<div class="fb-login-button pull-right" data-max-rows="1" data-size="large" data-show-faces="false" data-auto-logout-link="false"></div>-->
         	 </div>
         </div>
          
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
         <div class="clearfix hidden-phone" style="height:80px;"></div>
         <div class="row-fluid">
                     
                  <div id="pop_cats" class="hide text-center">
                       <h3>Browse business categories</h3>
                      <?php        
                          //$this->search_model->show_popular_cats();
                       ?>
    
                  </div>
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
	// MY.NA FB SDk
	  // This is called with the results from from FB.getLoginStatus().
	  function statusChangeCallback(response) {
		// The response object is returned with a status field that lets the
		// app know the current login status of the person.
		// Full docs on the response object can be found in the documentation
		// for FB.getLoginStatus().
		if (response.status === 'connected') {
		  // Logged into your app and Facebook.
		  console.log('statusChangeCallback connected');
		  goregister(response);
		} else if (response.status === 'not_authorized') {
		  // The person is logged into Facebook, but not your app.
		  //document.getElementById('msg').innerHTML = 'Please log ' +
			console.log('statusChangeCallback not_authorized');
		} else {
		  // The person is not logged into Facebook, so we're not sure if
		  // they are logged into this app or not.
		  ///document.getElementById('msg').innerHTML = 'Please log ' +
			//'into Facebook.';
			console.log('statusChangeCallback login_facebook');
		}
	  }
	
	  // This function is called when someone finishes with the Login
	  // Button.  See the onlogin handler attached to it in the sample
	  // code below.
	  function checkLoginState() {
		console.log('checkLoginState()');
		FB.getLoginStatus(function(response) {
		  statusChangeCallback(response);
		});
	  }

	  
      window.fbAsyncInit = function() {
			FB.init({
				//1504517666462894
				//287335411399195
			  appId      : '287335411399195',
			  xfbml      : true,
			  cookie     : true,
			  status     : true,  
			  version    : 'v2.1'
			});
	
			// ADD ADDITIONAL FACEBOOK CODE HERE
			function onLogin(response) {
			  console.log('onLogin');
			  if (response.status == 'connected') {
				FB.api('/me', function(data) {
					console.log(data);
					gologin(response);
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
				//FB.login(function(response) {
//				  onLogin(response);
//				}, {scope: 'user_friends, email,user_birthday'});
			  }
			});
		
		
   	  };//fbAsync
	
	 (function(d, s, id){
		 var js, fjs = d.getElementsByTagName(s)[0];
		 if (d.getElementById(id)) {return;}
		 js = d.createElement(s); js.id = id;
		 js.src = "//connect.facebook.net/en_US/sdk.js";
		 fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));

	
  
	  
	  function goregister(response){
		console.log('register');
		console.log(response);
		FB.api('/me', function(response) {
				$.ajax({
					type: 'POST',
					data: response,
					cache: false,
					url: 'https://www.my.na/fb/login2/register/?redirect='+document.URL,
					success: function (data) {
						console.log(data);
						if(data == 'TRUE'){
							
							window.location.reload();
							
						}   	
					}
				});
		});
		
		  
	  }


	  function gologin(response){
		console.log('login');
		
		FB.api('/me', function(response) {
				$.ajax({
					type: 'POST',
					data: response,
					cache: false,
					url: 'https://www.my.na/fb/login2/?redirect='+document.URL,
					success: function (data) {
						
						console.log(data);
						if(data == 'TRUE'){
							
							window.location.reload();
							
						}
					}
				});
		});
		  
	  }
	  
	 
    </script>
	



</body>
</html>