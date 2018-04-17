<?php 
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++

$_uname = '';
if($this->session->userdata('u_name')){ $_uname = ' - '.ucfirst($this->session->userdata('u_name'));}
$header['title'] = $_uname;
$header['metaD'] = 'Home feed for '. $_uname;
$this->load->view('members/inc/header', $header);


//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag
?>

<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">

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

    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-3" id="sidebar">
      <?php $this->load->view('inc/login'); ?>
      <?php $this->load->view('inc/weather'); ?>
      <?php $this->load->view('inc/adverts'); ?>
    </div>

    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">
      <div class="row">
        <div class="col-md-12">
          <section id="listing">


          </section>
        </div>
      </div>
    </div>
  </div>
</div>
  
<?php $this->load->view('inc/footer');?>  

<script data-cfasync="false" type="text/javascript">

  $(document).ready(function(){
    
   
  });

</script>


</body>
</html>