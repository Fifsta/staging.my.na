 <?php 
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++

//+++++++++++++++++
//My.Na Business Detailsb
//+++++++++++++++++
//Roland Ihms
//Get Business Details

$bus_id =  $bus_details['ID'];
$name =  $bus_details['BUSINESS_NAME'];
$email = $bus_details['BUSINESS_EMAIL'];
$tel = '+'.$bus_details['TEL_DIAL_CODE'].' '.$bus_details['BUSINESS_TELEPHONE'];
$fax = '+'.$bus_details['FAX_DIAL_CODE'].' '.$bus_details['BUSINESS_FAX'];
$cell = '+'.$bus_details['CEL_DIAL_CODE'].' '.$bus_details['BUSINESS_CELLPHONE'];
$description = $bus_details['BUSINESS_DESCRIPTION'];
$pobox = $bus_details['BUSINESS_POSTAL_BOX'];
$website = $bus_details['BUSINESS_URL']; 
$address = $bus_details['BUSINESS_PHYSICAL_ADDRESS'];
$city = $bus_details['city'];
$region = $bus_details['region'];
$latitude = $bus_details['latitude'];
$longitude = $bus_details['longitude'];
$startdate = $bus_details['BUSINESS_DATE_CREATED'];
//$city = $bus_details['CLIENT_CITY'];
$img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];
$vt = $bus_details['BUSINESS_VIRTUAL_TOUR_NAME'];
$advertorial = $bus_details['ADVERTORIAL'];
//Get categories
$cats = $this->business_model->get_current_categories($bus_id);
$rand = rand(0,9999);
//Build image string
//$city = $bus_details['CLIENT_CITY'];
$img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];

$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
$width = 800;

$height = 450;

if($img != ''){
  
  if(strpos($img,'.') == 0){

    $format = '.jpg';
    $img_str = 'assets/business/photos/'.$img . $format;
    $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
    
  }else{
    
    $img_str = 'assets/business/photos/'.$img;
    $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
    
  }
  
}else{
  
  $img_url =  'assets/business/photos/listing-placeholder.jpg';
  
}

//COVER IMAGE
$cover_img = $bus_details['BUSINESS_COVER_PHOTO'];

if($cover_img != ''){
  
  if(strpos($cover_img,'.') == 0){

    $format2 = '.jpg';
    $cover_str = 'assets/business/photos/'.$cover_img . $format2;
    $cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory,$cover_str,$width,$height, $crop = '');
    
  }else{
    
    $cover_str =  'assets/business/photos/'.$cover_img;
    $cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory,$cover_str,$width,$height, $crop = '');
    
  }
  
}else{
  
  $cover_str =  'assets/business/photos/listing-placeholder.jpg';
  $cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');
  
}



//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = $name. ' - Business Dashboard';
$header['metaD'] = '';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag
?>

<link href="<?php echo base_url('/');?>css/datatables.min.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css?v=1" />
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


            <div class="heading" style="margin-bottom:15px">
              <h2 data-icon="fa-briefcase"><?php echo $name; ?></h2>
              <ul class="options"> 
                <li><a href="#Contact-Agent" data-icon="fa-envelope text-dark">Details</a></li>
                <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
                <li><a href="#Analytics" data-icon="fa-briefcase text-dark">Analytics</a></li>
                <li><a href="#Products" data-icon="fa-graph text-dark">Products</a></li>
              </ul>
            </div>


            <div class="list-map">
              <div class="list-map-left" style="background:#ccc; position:relative">
                  <img src="<?php echo $cover_url; ?>" class="img-fluid">
              </div>
              
              <div class="list-map-right" id="map_container">
           
              </div>
            </div>

            <!--details-->
            <div class="details">
              <div class="details-left">
                <figure>
                  <a href="#"><img src="<?php echo $img_url; ?>"></a>
                  
                </figure>

                <div style="" class="text-center"><?php echo $this->business_model->get_review_stars_show($rating,$bus_id);?></div>
                 
              </div>
              <div class="details-right">
                <h2><?php echo $address ;?></h2>
                <div itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                                 <span itemprop="street-address"><i class="fa fa-map-marker text-dark"></i> <?php echo $address ;?></span>
                                 <span itemprop="locality"><?php echo $city ;?></span>
                                 <span itemprop="region"><?php echo $region ;?></span>
                                 <span itemprop="country-name">Namibia</span>
                             </div>
                             <?php 
                 echo '<p>'. implode(' ',$cats['links']).'</p>';
                 ?>
                <div class="row reveal">
                  <div class="col-sm-12 col-md-6 col-lg-4">
                    <p data-icon="fa-phone text-dark"><button class="btn btn-default"><!--T: --><?php echo $tel; ?></button></p>
                    <p data-icon="fa-fax text-dark"><button class="btn btn-default"><!--F: --><?php echo $fax; ?></button></p>
                    
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-4">
                    <p data-icon="fa-tablet text-dark"><button class="btn btn-default"><!--C: --><?php echo $cell; ?></button></p>
                    <p data-icon="fa-envelope text-dark"><button class="btn btn-default"><!--E: --><?php echo $email; ?></button></p>
                    
                  </div>
                  <div class="col-sm-12 col-md-6 col-lg-4">
                    <p data-icon="fa-globe text-dark"><button class="btn btn-default"><!--W: --><?php echo $website; ?></button></p>
                  </div>              
                </div>

                <?php if($bus_details['IS_NTB_MEMBER'] == 'Y'){ ?>
                <a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/icons/ntb_sml.png" alt="<?php echo $name;?> - NTB Member"></a>
                <?php } ?>

                <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
                <a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/icons/han_sml.png" alt="<?php echo $name;?> - HAN Member"></a>
                <?php } ?>

              </div>
            </div>
            <!--details-->   


            <!--tabs business details-->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Details" class="nav-link active" aria-controls="Details" role="tab" data-toggle="tab" data-icon="fa-pencil-square-o text-dark">Details</a></li>
              <li role="presentation" class="nav-item"><a href="#Description" class="nav-link" aria-controls="Description" role="tab" data-toggle="tab" data-icon="fa-file-text-o text-dark">Description</a></li>
              <li role="presentation" class="nav-item"><a href="#Gallery" class="nav-link" aria-controls="Gallery" role="tab" data-toggle="tab" data-icon="fa-file-image-o text-dark">Gallery</a></li>
              <li role="presentation" class="nav-item"><a href="#Categories" class="nav-link" aria-controls="Categories" role="tab" data-toggle="tab" data-icon="fa-list text-dark">Categories</a></li>
            </ul>

            <div class="tab-content">

              <section role="tabpanel" class="tab-pane active" id="Details">
                <h2 class="tab-head">Manage Business Details</h2>
                <?php $this->load->view('members/inc/business_details', $bus_details);?>
              </section>

              <section role="tabpanel" class="tab-pane" id="Description">
                <h2 class="tab-head">Manage Business Description</h2>
                <?php $this->load->view('members/inc/business_description', $bus_details);?>
              </section>

              <section role="tabpanel" class="tab-pane" id="Gallery">
                <h2 class="tab-head">Gallery</h2>
                <div class="row">
                  <?php $this->business_model->show_gallery($bus_id);?>
                </div>
              </section>


              <section role="tabpanel" class="tab-pane" id="Categories">
                <h2 class="tab-head">Categories</h2>
                <div class="row">
                  <?php $this->load->view('members/inc/business_categories_inc', $bus_details);?>
                </div>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--tabs business details-->


            <!--tabs review/rating details-->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Rating" class="nav-link active" aria-controls="Rating" role="tab" data-toggle="tab" data-icon="fa-pencil-square-o text-dark">Rating Widget</a></li>
              <li role="presentation" class="nav-item"><a href="#Reviews" class="nav-link" aria-controls="Reviews" role="tab" data-toggle="tab" data-icon="fa-file-text-o text-dark">Reviews</a></li>
              <li role="presentation" class="nav-item"><a href="#QR" class="nav-link" aria-controls="QR" role="tab" data-toggle="tab" data-icon="fa-file-text-o text-dark">QR Code</a></li>
            </ul>

            <div class="tab-content">

              <section role="tabpanel" class="tab-pane active" id="Rating">
                <h2 class="tab-head">Official Namibian Rating Widget</h2>
                <?php $this->load->view('members/inc/rating_widget', $bus_details);?>
              </section>

              <section role="tabpanel" class="tab-pane" id="Reviews">
                <h2 class="tab-head">Business Reviews</h2>
              </section>

              <section role="tabpanel" class="tab-pane active" id="QR">
                <h2 class="tab-head">QR Code</h2>
                <?php $this->load->view('members/inc/business_qr_code', $bus_details);?>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--tabs review/rating details-->


            <!--tabs review/rating details-->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Analytics" class="nav-link active" aria-controls="Analytics" role="tab" data-toggle="tab" data-icon="fa-pencil-square-o text-dark">Analytics</a></li>

            </ul>

            <div class="tab-content">

              <section role="tabpanel" class="tab-pane active" id="Analytics">
                <h2 class="tab-head">Analytics</h2>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--tabs review/rating details-->            

            
          </section>          

        </div> 

      </div>
    </div>
  </div>  
</div>
  
<?php $this->load->view('inc/footer');?>  

<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script src="<?php echo base_url('/')?>redactor/redactor/video.js"></script>
<script src="<?php echo base_url('/')?>redactor/redactor/table.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
<script src="<?php echo base_url('/');?>js/custom/members_home.js"></script>

<script data-cfasync="false" type="text/javascript">

$(document).ready(function(){
 
  $('#redactor_content').redactor({   
    imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
    imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/<?php echo $bus_id;?>',
    buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
    'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
    'video','image', 'table','|',
    'alignment', '|', 'horizontalrule'],
    cleanOnPaste: true,
    plugins: ['table', 'video']
  });
  $('[rel=tooltip]').tooltip(); 
  
});

</script>


</body>
</html>