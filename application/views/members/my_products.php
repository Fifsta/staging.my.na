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

              <div class="heading">
                <h2 data-icon="fa-user">My Products</h2>
                <p>A list of private products</p>
              </div>
              <br>

            <!--tabs products-->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Latest" data-type="live" data-bus="0" class="nav-link active pbtn" aria-controls="Rating" role="tab" data-toggle="tab" data-icon="fa-clock-o text-dark">Latest Items</a></li>
              <li role="presentation" class="nav-item"><a href="#Sold" data-type="sold" data-bus="0" class="nav-link pbtn" aria-controls="Reviews" role="tab" data-toggle="tab" data-icon="fa-exclamation-circle text-dark">Sold Items</a></li>
              <li role="presentation" class="nav-item"><a href="#Deals" data-type="deals" data-bus="0" class="nav-link pbtn" aria-controls="QR" role="tab" data-toggle="tab" data-icon="fa-tags text-dark">Deals</a></li>
            </ul>

            <div class="tab-content">

              <section role="tabpanel" class="tab-pane active" id="Latest" style="overflow: visible">
                <h2 class="tab-head">Latest Products</h2>
                <div id="products-result-live"></div>
              </section>

              <section role="tabpanel" class="tab-pane" id="Sold">
                <h2 class="tab-head">Sold Products</h2>
                <div id="products-result-sold"></div>
              </section>

              <section role="tabpanel" class="tab-pane" id="Deals">
                <h2 class="tab-head">Deals</h2>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--products -->                    


          </section>
        </div>
      </div>
    </div>
  </div>
</div>
  
<?php $this->load->view('inc/footer');?>  

<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
<script src="<?php echo base_url('/');?>js/custom/members_home.js"></script>
<script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<script data-cfasync="false" type="text/javascript">

  $(document).ready(function(){

    load_products_do('0', 'live');

    $(document).on('click', '.pbtn', function(e) {

        var section = $(this).attr("data-type");
        var bus_id = $(this).attr("data-bus");

        load_products_do(bus_id, section);

    });   
  
  });



function load_products_do(bus_id, section) {

    $('#products-result-'+section).html("<img src='<?php echo base_url('/').'images/load.gif';?>'>");

    $.ajax({
        type: "POST",
        url: '<?php echo site_url('/');?>members/load_bus_products/', 
        cache: false,
        data: { 
          'bus_id': bus_id,
          'section': section
        },  
        success: function (result) {

          $('#products-result-'+section).html(result);
          $('.datatable').DataTable();
           
        },
        error: function (err) {
            
        }
    });

}


</script>


</body>
</html>