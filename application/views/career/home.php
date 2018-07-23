<?php 

$header['title'] = 'Careers - My Namibia';
$header['metaD'] =  'Careers on My Namibia';
 
//BUILD OPEN GRAPH
$header['og'] ='
<meta property="fb:app_id" content="287335411399195"> 
<meta property="og:type"        content="MyNamibia:business"> 
<meta property="og:url"         content="'.site_url('/').'vacancy/"> 
<meta property="og:title"       content="'.$header['title'].'"> 
<meta property="og:description" content="'.$header['metaD'].'">'; 

$this->load->view('inc/header');

?>

<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/> 

</head>

<body id="top"> 

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
  <div class="container">
    <ol class="breadcrumb">
       <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>" itemprop="url"><span itemprop="title">My</span></a></li>
       <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>careers" itemprop="url"><span itemprop="title">Careers</span></a> </li>    
       <li class="breadcrumb-item active">Career Profile</li>
    </ol>
  </div>
</nav>

<div class="container">

  <div class="row">

      <div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">

        <?php $this->load->view('inc/login'); ?>
        <?php $this->load->view('inc/weather');?>
        <?php $this->load->view('inc/adverts');?>

      </div>

      <div class="col-sm-8 col-md-8 col-lg-9 col-xl-9 order-md-1 order-sm-2">


          <?php $this->load->view('career/inc/profile');?>


      </div>

  </div>  
  
</div>
  
<div class="spacer"></div>  
  
<?php $this->load->view('inc/footer');?>  

<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 

<script  type="text/javascript">

    //Toggle Disadvatage
    $("#disabled").change(function() {
        if(this.checked) {
            $("#d_toggle").toggle();
        } else {
            $("#d_toggle").toggle();
        }
    });


    //Toggle Drivers
    $("#drivers").change(function() {
        if(this.value == 'Y') {
            $("#dr_toggle").toggle();
        } else {
            $("#dr_toggle").toggle();
        }
    });


</script> 

<script type="application/ld+json">
{
  "@context" : "http://schema.org",
  "@type" : "Organization", 
  "name" : "<?php echo $name; ?>",
  "description" : "<?php echo strip_tags($description); ?>",
  "brand" : { 
      "@type": "brand",
    "image" : "<?php echo $img_url; ?>"
  },
  "contactPoint": {
      "@type": "ContactPoint",
      "contactType" : "Customer service" ,
      "telephone" : "<?php echo $tel; ?>" ,
      "faxNumber" : "<?php echo $fax; ?>" ,
      "email" : "<?php echo $email; ?>" ,
      "url" : "<?php echo $website; ?>"
  },
  "address": {
      "@type": "PostalAddress",
      "streetAddress": "<?php echo $address; ?>"
  } ,
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "<?php echo $rating; ?>",
    "ratingCount": "<?php echo $rating_count; ?>"
  }
}

</script>

<script type="application/ld+json">

{
  "@context" : "http://schema.org",
  "@type" : "GeoCoordinates", 
  "latitude" : "<?php echo $latitude; ?>",
  "longitude" : "<?php echo $longitude; ?>"                      
} 

</script>


</body>
</html>