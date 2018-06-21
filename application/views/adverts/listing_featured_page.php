<?php 

//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
if(isset($title)){

   $header['metaD'] = $heading. '. Find ' . $heading .' online - My Namibia';
   $header['section'] = '';
 
}else{

   $header['metaD'] = '';
   $header['section'] = '';
 
}

$this->load->view('inc/header', $header);

?>

<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<link rel="canonical" href="<?php $this->trade_model->build_canonical();?>" />

<style type="text/css">
    #form_frame{height:770px;}

    /* Small Devices, Tablets */
    @media only screen and (max-width : 768px) {
        #form_frame{height:1100px;}
    }
</style>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?php echo site_url('/'); ?>">Home</a></li>
        <li class="breadcrumb-item">Feature your listing</li>
      </ol>
  </div>
</nav>

<div class="container">

  <div class="row">

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-4" id="sidebar">

      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather');?>
      <?php $this->load->view('inc/adverts');?>

    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">

        <section id="list">

          <div class="heading" style="margin-bottom:15px">
            <h2 data-icon="fa-briefcase"><?php echo $title; ?></h2>
            <ul class="options">    
              <li><a href="#Form" data-icon="fa-edit text-dark">Feature listing now</a></li>
            </ul>
          </div>

          <div class="row">

              <div class="col-md-9">
                  <img src="<?php echo base_url('/');?>images/adverts/feature_your_products.png" />

              </div>
              <div class="col-md-3">
                <div class="card">
                  <img class="card-img-top" src="<?php echo base_url('/');?>images/adverts/ad1/2.png" alt="Card image cap" style="padding:10px">
                  <div class="card-body">
                    <p><strong>Reach More Than 1 Million Unique Visitors</strong> on all our platforms. Your product gets the normal classifieds exposure in our national publications and newspapers.</p>
                    <p>Manage your product listing online, view stats on views enquiries and hits. Fast and effective email and SMS alerts are included at no extra cost.</p>
                    <p class="muted">All For only</p>
                    <h1 class="na_script big_icon yellow"><small class="yellow">N$</small> 99 </h1>
                    <p class="muted"><small>once off for 30 days</small></p>
                    <p><strong>Offer only valid until<br></strong> <?php echo date('F jS, Y', strtotime("+2 days"));?></p>
                </div>
                </div>  
              </div>
              
          </div>


        </section>

        <div class="spacer"></div>

        <section id="Form">

          <div class="heading" style="margin-bottom:15px">
            <h2 data-icon="fa-briefcase">Feature Your Product Online</h2>
            <ul class="options">    
              
            </ul>
          </div>

          <div class="row">

              <div class="col-md-9">


                 <iframe id="form_frame" style="width:100%;overflow: hidden" src="<?php echo HUB_URL;?>main/subscribe/?type=featured_product" allowtransparency="true" frameborder="0"></iframe>                


              </div>

              <div class="col-md-3">

                <div class="card">
                  <img class="card-img-top" src="<?php echo base_url('/');?>images/adverts/ad1/3.png" alt="Card image cap" style="padding:10px">
                  <div class="card-body">
                    <h5 class="card-title"><strong>How it Works...</strong></h3>
                      
                        <p>
                        1. Find an Item to sell.<br>
                        2. Take some pictures<br>
                        3. Upload it yourself or Send it to us
                        </p>
    
                        <p>  
                        4. Upload the item details<br>
                        5. Submit a Feature Request below<br>
                        6. Wait for buyers to contact you!<br>
                        </p>
                      

                  </div>
                </div>

              </div>
              
          </div>


        </section>

        <div class="spacer"></div>

    </div>

  </div>  
  
</div>

<?php $this->load->view('inc/footer'); ?>  

<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>

<script type="text/javascript">



</script>

</body>
</html>