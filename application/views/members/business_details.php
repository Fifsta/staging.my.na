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

$bus_id = $bus_details['ID'];
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
  
  $img_str =  'assets/business/photos/logo-placeholder.jpg';
  $img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');

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

</div><link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.css"/>

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
                <li><a href="#Details" data-icon="fa-envelope text-dark">Details</a></li>
                <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
                <li><a href="#Analytics" data-icon="fa-bar-chart text-dark">Analytics</a></li>
                <li><a href="#Latest" data-icon="fa-briefcase text-dark">Products</a></li>
                <li><a href="#Users" data-icon="fa-users text-dark">Users</a></li>
              </ul>
            </div>


            <div class="list-map">
              <div class="list-map-left" style="background:#ccc; position:relative">
                  <img src="<?php echo $cover_url; ?>" class="img-fluid">

                  <form action="<?php echo site_url('/')?>members/add_cover/<?php echo $bus_id;?>" method="post" accept-charset="utf-8" id="add-cover" name="add-cover" enctype="multipart/form-data"> 
                    <input type="file" style="width:0px; height:0px;" id="cover_file" name="userfile1">
                    <input type="hidden" id="cover_msg" name="" value="">
                    <input type="hidden" id="id1" name="id1" value="<?php echo $this->session->userdata('admin_id');?>">
                    <input type="hidden" id="bus_id1" name="bus_id1" value="<?php echo $bus_id;?>">
                    <input type="hidden" id="bus_name1" name="bus_name1" value="<?php echo $name;?>">

                    <button type="submit" style="margin:5px"  class="btn btn-dark pull-right" id="coverbut"><i class="fa fa-picture"></i> <?php if($cover_img != ''){ echo 'Upload New Cover';}else{ echo 'Add Cover';} ?></button>
                    <a class="btn btn-dark pull-right" rel="tooltip" title="Cover Image 750 pixels x 300 pixels" style="margin:5px" onclick="select_cover()" href="javascript:void(0)"><i class="fa fa-search"></i> Browse Cover</a>


                  </form>

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
            <h1 style="font-size:16px; border-bottom:1px solid #999; margin-top:30px; margin-bottom:30px"><strong>MANAGE DETAILS</strong></h1>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Details" class="nav-link active" aria-controls="Details" role="tab" data-toggle="tab" data-icon="fa-pencil-square-o text-dark">Details</a></li>
              <li role="presentation" class="nav-item"><a href="#Description" class="nav-link" aria-controls="Description" role="tab" data-toggle="tab" data-icon="fa-file-text-o text-dark">Description</a></li>
              <li role="presentation" class="nav-item"><a href="#Gallery" class="nav-link" aria-controls="Gallery" role="tab" data-toggle="tab" data-icon="fa-file-image-o text-dark">Gallery</a></li>
              <li role="presentation" class="nav-item"><a href="#Categories" class="nav-link" aria-controls="Categories" role="tab" data-toggle="tab" data-icon="fa-list text-dark">Categories</a></li>
              <li role="presentation" class="nav-item"><a href="#Map" onClick="initialise_map()" class="nav-link" aria-controls="Categories" role="tab" data-toggle="tab" data-icon="fa-map-marker text-dark">Map</a></li>
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
                  <?php //$this->load->view('members/inc/business_categories_inc', $bus_details);?>
                </div>
              </section>

              <section role="tabpanel" class="tab-pane" id="Map">
                <h2 class="tab-head">Business Map</h2>
                <div class="row" id="map-tab">
                  <?php $this->load->view('members/inc/business_map_inc', $bus_details);?>
                </div>
              </section>              

              <div class="clear:both"> </div>

            </div>
            <!--tabs business details-->


            <!--tabs review/rating details-->
            <h1 style="font-size:16px; border-bottom:1px solid #999; margin-top:30px; margin-bottom:30px"><strong>MANAGE RATINGS & REVIEWS</strong></h1>
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
                <?php //$this->load->view('members/inc/business_reviews', $bus_details);?>
              </section>

              <section role="tabpanel" class="tab-pane" id="QR">
                <h2 class="tab-head">QR Code</h2>
                <div id="load_qr"></div>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--tabs review/rating details-->


            <!--tabs products-->
            <h1 style="font-size:16px; border-bottom:1px solid #999; margin-top:30px; margin-bottom:30px"><strong>MANAGE BUSINESS PRODUCTS</strong></h1>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Latest" data-type="live" data-bus="<?php echo $bus_id; ?>" class="nav-link active pbtn" aria-controls="Rating" role="tab" data-toggle="tab" data-icon="fa-clock-o text-dark">Latest Items</a></li>
              <li role="presentation" class="nav-item"><a href="#Sold" data-type="sold" data-bus="<?php echo $bus_id; ?>" class="nav-link pbtn" aria-controls="Reviews" role="tab" data-toggle="tab" data-icon="fa-exclamation-circle text-dark">Sold Items</a></li>
              <li role="presentation" class="nav-item"><a href="#Deals" data-type="deals" data-bus="<?php echo $bus_id; ?>" class="nav-link pbtn" aria-controls="QR" role="tab" data-toggle="tab" data-icon="fa-tags text-dark">Deals</a></li>
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


            <!--tabs analytics -->
            <h1 style="font-size:16px; border-bottom:1px solid #999; margin-top:30px; margin-bottom:30px"><strong>MANAGE ANALYTICS</strong></h1>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Analytics" class="nav-link active" aria-controls="Analytics" role="tab" data-toggle="tab" data-icon="fa-pencil-square-o text-dark">Analytics</a></li>

            </ul>

            <div class="tab-content">

              <section role="tabpanel" class="tab-pane active" id="Analytics">
                <h2 class="tab-head">Analytics</h2>
                <div id="analytics-div"></div>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--tabs analytics -->   


            <!--tabs users-->
            <h1 style="font-size:16px; border-bottom:1px solid #999; margin-top:30px; margin-bottom:30px"><strong>MANAGE BUSINESS USERS</strong></h1>
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="nav-item"><a href="#Users" class="nav-link active" aria-controls="Users" role="tab" data-toggle="tab" data-icon="fa-users text-dark">Users</a></li>

            </ul>

            <div class="tab-content">

              <section role="tabpanel" class="tab-pane active" id="Users">
                <h2 class="tab-head">YOUR CURRENT BUSINESS LISTING USERS</h2>
                <?php $dat['bus_id'] = $bus_id; $this->load->view('members/inc/business_users', $dat); ?>
                <div id='usr-result'></div>
              </section>

              <div class="clear:both"> </div>

            </div>
            <!--tabs users-->                        

            
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.16/datatables.min.js"></script>
<script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
<script src="<?php echo base_url('/');?>js/custom/members_home.js"></script>
 <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

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

  load_products_do(<?php echo $bus_id; ?>, 'live');


  var url = window.URL || window.webkitURL;

  $("#cover_file").change(function(e) {

    var str1 = '' ;  

    if( this.disabled ){

      str1 = 'Your browser does not support File upload.';

    }else{

      var chosen = this.files[0];
      var image = new Image();

      image.onload = function() {

        var Ow = this.width, Oh = this.height, Filsesize = Math.round(chosen.size/1024);
        $("#cover_msg").val(validate_image('cover', Ow, Oh, 300, 750, 7000, 7000));

        if(Filsesize > 8000){

          $("#cover_msg").val('Your image size '+Math.round(Filsesize/1024)+ ' MB is too big. Maximum size allowed is 8 Megabytes.');

        }

      };

      image.onerror = function() {
        str1 = 'PLease choose an image file, not a '+chosen.type+' extension';
      };

      image.src = url.createObjectURL(chosen);                    
    }

  });


  $("#logo_file").change(function(e) {

    var str1 = '' ; 

    if( this.disabled ){

      str1 = 'Your browser does not support File upload.';

    }else{

      var chosen = this.files[0];
      var image = new Image();

      image.onload = function() {

        var Ow = this.width, Oh = this.height, Filsesize = Math.round(chosen.size/1024);

        $("#logo_msg").val(validate_image('logo', Ow, Oh, 250, 250, 6000, 6000));

      };

      image.onerror = function() {

        str1 = 'PLease choose an image file, not a '+chosen.type+' extension. Please choose a .jpg, .png or .gif image';

      };

      image.src = url.createObjectURL(chosen); 

    }

  });


  $('#coverbut').bind('click', function(e) {
    
    //e.preventDefault();
    var msg = $("#cover_msg").val();
    
    console.log(msg);
    
    if(msg.length != 0){
      e.preventDefault();
      $('#avatar_msg').html("<div class='alert alert-error'>"+msg+"</div>");
    
    }else{



      $('#avatar_msg').html("");
      
          var avataroptions = { 
          target:        '#avatar_msg',
          url:           '<?php echo site_url('/').'members/add_cover';?>' ,
          beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
          uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    probar.width(percentVal)
                    
                  },
           complete: function(xhr) {
                    procover.hide();
                    probar.width('0%');
                     $('#avatar_msg').html(xhr.responseText);
                     //console.log(xhr.responseText);
                     $('#coverbut').html('<i class="icon-picture icon-white"></i> Update Cover');
                  }       
      
        }; 
      
        var frm = $('#add-cover');
        var probar = $('#procover .bar');
        var procover = $('#procover');
      
        $('#coverbut').html('<img src="<?php echo base_url('/').'images/load.gif';?>" /> Uploading...');
        procover.show();
        frm.ajaxForm(avataroptions);    
      
      
    }
    
  
    
      
  });


  
});


$(document).on('click', '.pbtn', function(e) {

    var section = $(this).attr("data-type");
    var bus_id = $(this).attr("data-bus");

    load_products_do(bus_id, section);

});


function load_products_do(bus_id, section) {

    $('#products-result-'+section).html("<img src='<?php echo base_url('/').'images/load.gif';?>'>");

    $.ajax({
        type: "POST",
        url: base+'members/load_bus_products/', 
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



function load_tab(id, str){

  var cont = $('#'+str);

    if(str == 'reviews'){

          $.getScript('<?php echo base_url('/');?>js/jquery.knob.js', function(){
              setTimeout(load_review_report(id, str), 300);
          });

    }else{

        cont.addClass('loading_img');
        cont.empty();
        $.ajax({
            type: 'get',
            cache: false,
            url: '<?php echo site_url('/').'members/';?>'+str+'/'+id ,
            success: function (data) {
                cont.removeClass('loading_img');
                cont.html(data);

                if(str == 'han_evaluations'){
                    $('#example').dataTable( {
                        "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                        "sPaginationType": "bootstrap",
                        "oLanguage": {
                            "sLengthMenu": "_MENU_"
                        },
                        "aaSorting":[],
                        "bSortClasses": false

                    } );
                }

            }
        });

    }
   
 }


function cover_upload_success(url, btn_link){
  
  $('#cover_div').css({background: 'url('+url+')'});
  $('#btn_edit_cover').removeClass('hide').attr("href",btn_link);
   
} 
 
function logo_upload_success(url){
  
  $('#avatar').attr('src', url); 
   
}

function validate_image(type, Ow, Oh,  minH ,minW ,maxH , maxW){
  
    var str = '';
    if(Ow < minW) {
      
      str = 'The image width is too small. Minimum width is '+minW+' pixels';
      
    }else if(Oh < minH){
      
      str = 'The image height is too small .Minimum height is '+minH+' pixels';
      
    }
    
    if(Ow > maxW) {
      
      str = 'The image width is too big. Maximum width is '+ maxW +' pixels';
      
    }else if(Oh > maxH){
      
      str = 'The image height is too big. Maximum height is '+ maxH +' pixels';
      
    }
      
    $("#"+type+"_msg").val(str);

   return str;

}


function select_logo(){
  
  var sel = $('#logo_file');
  sel.show();
  sel.focus();
  sel.click();
  //sel.hide();

}

function select_cover(){
  
  var sel = $('#cover_file');
  sel.show();
  sel.focus();
  sel.click();
  //sel.hide();

}


function load_analytics(id,period){
 
$.ajax({
    type: 'get',
    cache: false,
    url: '<?php echo site_url('/').'members/get_business_analytics/';?>'+id+'/'+period ,
    success: function (data) {

           $('#analytics-div').html(data);      
    }
  });  
 
}

</script>


</body>
</html>