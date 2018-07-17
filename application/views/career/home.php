<?php $this->load->view('inc/header'); ?>
 
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


                </div>
            </div>
        </div>
    </div>  
</div>
    
<?php $this->load->view('inc/footer');?>    

<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>


<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization",
  "name" : "My Namibia",
  "description" : "The biggest online portal for Namibians to find the Careers they are lookin for.",
  "brand" : { 
        "@type": "brand",
        "image" : "https://my.na/images/logo-main.png"
  },
  "sameAs": [
    "https://www.facebook.com/mynamibia/",
    "https://twitter.com/MyNamibia"
  ],  
  "address": {
        "@type": "PostalAddress",
        "streetAddress": "11B Genl. Murtala Muhammed Ave Windhoek, Namibia"
  },  
  "contactPoint": {
        "@type": "ContactPoint",
        "contactType" : "customer service",
        "email" : "info@my.na",
        "url" : "https://www.my.na",
        "telephone" : "+264 61 309 591"
  }
}

</script>

<script type="application/ld+json">

{
  "@context" : "http://schema.org",
  "@type" : "GeoCoordinates", 
  "latitude" : "-22.5480965",
  "longitude" : "17.0872937"                      
} 

</script>

</body>
</html>