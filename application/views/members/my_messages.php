<?php 
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++

$header['title'] = '';
$header['metaD'] = '';
$this->load->view('members/inc/header', $header);

$bus_details = $this->members_model->get_business_details($id);
$name = filter_var(utf8_decode($bus_details['BUSINESS_NAME']), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
$email = $bus_details['BUSINESS_EMAIL'];
$tel = $bus_details['BUSINESS_TELEPHONE'];
$fax = $bus_details['BUSINESS_FAX'];
$cell = $bus_details['BUSINESS_CELLPHONE'];
$description = $bus_details['BUSINESS_DESCRIPTION'];
$pobox = $bus_details['BUSINESS_POSTAL_BOX'];
$website = $bus_details['BUSINESS_URL']; 
$address = $bus_details['BUSINESS_PHYSICAL_ADDRESS'];
$startdate = $bus_details['BUSINESS_DATE_CREATED'];
//$city = $bus_details['CLIENT_CITY'];
$img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag
?>

<link href="<?php echo base_url('/');?>css/datatables.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />  
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

          <section id="inbox">
            <div class="heading" style="margin-bottom:15px;">
              <h2 data-icon="fa-newspaper-o">!NA <strong>Inbox</strong></h2>
              <p>Inbox of private member messages</p>
              <ul class="options">

              </ul>
            </div>

            <div id="message-block">
              <?php $this->load->view('members/inc/member_inbox_inc'); ?>
            </div>

          </section> 

        </div> 

      </div>
    </div>
  </div>  
</div>
  
<?php $this->load->view('inc/footer');?>  

<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster --> 
<script src="<?php echo base_url('/');?>js/jquery.filestyle.js" type="text/javascript"></script>
<script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url('/');?>js/custom/members_home.js?v2"></script>

<script data-cfasync="false" type="text/javascript">
 

</script>


</body>
</html>