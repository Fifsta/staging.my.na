<?php $this->load->view('inc/header'); ?>
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

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">My.na</a></li>
      </ol>
  </div>
</nav>
 
<div class="container"> 
  <div class="row">
    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">
      <?php $this->load->view('inc/login'); ?>
    
      <?php $this->load->view('inc/adverts'); ?>
    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-9 order-md-1 order-sm-2">
      <div class="row">
        <div class="col-md-12">
            <h1>Thanks for registering at My.Namibia<small>&trade;</small> </h1>
            <p>You have just become an official ambassador of My Namibia. Please check your inbox for the verification link.</p>
            <img src="<?php echo base_url('/');?>img/bground/my-na-700-silver.png" alt="My Namibia"/>
            <p></p>
    
        </div>
      </div>
    </div>
  </div>  
</div>
<div class="spacer"></div>
  
<?php $this->load->view('inc/footer');?>  


</body>
</html>