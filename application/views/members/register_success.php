 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 <!-- Facebook Conversion Code for Registrations - My Namibia Adverts 1 -->
 <script>(function() {
		 var _fbq = window._fbq || (window._fbq = []);
		 if (!_fbq.loaded) {
			 var fbds = document.createElement('script');
			 fbds.async = true;
			 fbds.src = '//connect.facebook.net/en_US/fbds.js';
			 var s = document.getElementsByTagName('script')[0];
			 s.parentNode.insertBefore(fbds, s);
			 _fbq.loaded = true;
		 }
	 })();
	 window._fbq = window._fbq || [];
	 window._fbq.push(['track', '6020352503573', {'value':'50.00','currency':'ZAR'}]);
 </script>
 <noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6020352503573&amp;cd[value]=0.00&amp;cd[currency]=ZAR&amp;noscript=1" /></noscript>
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 $this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">

      <div class="container" style="padding-top:200px; text-align:center;">
		
      <div class="row">
        <div class="span12">
        <section>
        
                  <h1>Thanks for registering at My.Namibia<small>&trade;</small> </h1>
                  <p>You have just become an official ambassador of My Namibia. Please check your inbox for the verification link.</p>
        			<img src="<?php echo base_url('/');?>img/bground/my-na-700-silver.png" alt="My Namibia"/>
                  <p></p>
          	
         </section> 
        </div>
       
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:85px;"></div>

   

 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
 </div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


</body>
</html>