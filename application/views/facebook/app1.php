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
 $nav['section'] = '';
 //$this->load->view('inc/navigation', $nav);
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
                          $this->search_model->show_popular_cats();
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
    <script src='<?php echo base_url('/')?>js/jquery.cycle.all.min.js' type="text/javascript" language="javascript"></script>
	<script type="text/javascript">
    var site = '<?php echo site_url('/');?>';
    var base = '<?php echo base_url('/');?>';
    $(document).ready(function(){
		$('[rel=tooltip]').tooltip();
		
	});
	
    window.fbAsyncInit = function() {
		FB.init({
		  appId      : '287335411399195',
		  xfbml      : true,
		  version    : 'v2.1'
		});

    // ADD ADDITIONAL FACEBOOK CODE HERE
   };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
	function onLogin(response) {
	  if (response.status == 'connected') {
		FB.api('/me?fields=first_name', function(data) {
		  var welcomeBlock = document.getElementById('fb-welcome');
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
		}, {scope: 'user_friends, email'});
	  }
	});
	
	 
    </script>
	
    <script type="text/javascript" src="<?php echo  base_url('/');?>js/custom/home1.js?=v2"></script>
	<script src='<?php echo base_url('/')?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>


</body>
</html>