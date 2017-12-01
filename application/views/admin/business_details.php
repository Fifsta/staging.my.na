<?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
 $this->load->view('admin/inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
<link href="<?php echo base_url('/');?>css/datatables.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
<style type="text/css">
	#loading_img{position:relative;min-height:600px}
	.loading_img{min-height:400px;width:100%;position:relative;top:0;left:0;right:0;bottom:0; z-index: 1040;
		background-color: #FFF; background: url("<?php echo base_url('/');?>img/load.gif") no-repeat center center;
		opacity: 0.8;
		filter: alpha(opacity=80);}

</style>
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 
   //+++++++++++++++++
   //My.Na Business Details
   //+++++++++++++++++
   //Roland Ihms
   //Get Business Details
  $bus_details = $this->admin_model->get_business_details($bus_id);
  $name = $bus_details['BUSINESS_NAME'];
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
  $vt = $bus_details['BUSINESS_VIRTUAL_TOUR_NAME'];
  $img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];
  $estate_a = $bus_details['IS_ESTATE_AGENT'];
	?>	
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div id="container-body" class="container white_box padding10" style="margin-top:80px;">
      
	   <div class="row">
      	
        <div class="span12">
        	<div class="btn-group pull-right">
            <button class="btn btn-large"><i class="icon-fire"></i> Admin Account</button>
            <button class="btn dropdown-toggle btn-large" data-toggle="dropdown">
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
              <li class="nav-header">Admin Navigation</li>
              <li><a href="<?php echo site_url('/');?>my_admin/">Home</a></li>
              <li><a href="">Spare</a></li>
              <li class="nav-header">Logout of Account</li>
              <li><a href="<?php echo site_url('/');?>my_admin/logout">Logout</a></li>
            </ul>
          </div>
          <h1>My Namibia Admin</h1>  
             <ul class="breadcrumb">
              <li><a href="#">My Account</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
       	
      <div class="row">
      
       <div class="span3">
            <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 $subnav['subsection'] = 'add_bus';
				 $this->load->view('admin/inc/admin_nav', $subnav);
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
             ?>
       
       	 
        </div>
      
      
        <div class="span9">
        
        	 <div class="popover top" id="map_info" style="margin:90px 0px 0px 41%">
                  <div class="arrow"></div>
                    <h3 class="popover-title">Update your map<i class="icon-info-sign" style="float:right"></i></h3>
                    <div class="popover-content">
                      You have not set your map yet. Please click on the map tab and pinpoint your location
                 </div>
              </div>
			
			<ul class="nav nav-tabs" id="bus_tabs">
              <li class="active"><a href="#info" data-toggle="tab">General Info</a></li>
              <li><a href="#map-tab" onClick="initialise_map()" data-toggle="tab">Map</a></li>
              <li><a href="#categories" data-toggle="tab">Categories</a></li>
              <li><a href="#amenities"  data-toggle="tab">Amenities</a></li>
              <li><a href="#gallery" data-toggle="tab">Gallery</a></li>
              <li><a href="#analytics" onClick="load_analytics(<?php echo $bus_id;?>, 'MONTH')" data-toggle="tab">Analytics</a></li>
              <li><a href="#business_users" onClick="load_tab(<?php echo $bus_id;?>, 'business_users')" data-toggle="tab"> Users</a></li>
              <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
              <li><a href="#han_evaluations" onClick="load_tab(<?php echo $bus_id;?>, 'han_evaluations')" data-toggle="tab"> HAN Evaluations</a></li>
              <?php } ?>
              
              <li><a href="#advertorial" data-toggle="tab"> Advertorial</a></li>
              		
            </ul>
             <?php if(isset($error)){ ?>
              <div class="alert alert-error">
               <button type="button" class="close" data-dismiss="alert">×</button>
                  <?php echo $error; ?>
              </div>
              <?php
              }//end error
              if(isset($basicmsg)){ ?>
              <div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert">×</button>
                  <?php echo $basicmsg; ?>
              </div>
              <?php
              }
              ?>
               <?php if($this->session->flashdata('error')){ ?>
                    <div class="alert alert-error">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                    <?php
                    }//end error
                    if($this->session->flashdata('msg')){ ?>
                    <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $this->session->flashdata('msg'); ?>
                    </div>
                    <?php
                    }
                    ?>
            <div class="tab-content">
              <div class="tab-pane active" id="info"><?php $this->load->view('admin/inc/business_details', $bus_details);?></div>
              <div class="tab-pane" id="map-tab"><?php $this->load->view('admin/inc/business_map_inc', $bus_details);?></div>
              <div class="tab-pane" id="categories"><?php $this->load->view('admin/inc/business_categories_inc', $bus_details);?></div>
              <div class="tab-pane" id="amenities"><?php $this->load->view('admin/inc/business_amenities_inc', $bus_details);?></div>
              <div class="tab-pane" id="gallery"><?php $this->load->view('admin/inc/business_gallery', $bus_details);?></div>
              <div class="tab-pane" id="analytics"><h3>Analytics <small><?php echo $name;?></small></h3>
				<div class="clearfix"></div>
                <div id="analytics_div" style="height:auto;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center"></div>
              </div>
              <div class="tab-pane" id="business_users"></div>
              <div class="tab-pane" id="han_evaluations"></div>
              <div class="tab-pane" id="advertorial"><?php $this->load->view('admin/inc/business_advertorial', $bus_details);?></div>
            </div>
        </div>
       
       
       
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      <div id="push"></div>
    </div>

 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('admin/inc/footer_backend', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
     <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
	 <script src="<?php echo base_url('/')?>redactor/redactor/video.js"></script>
	 <script src="<?php echo base_url('/')?>redactor/redactor/table.js"></script>
<script type="text/javascript">
<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//FIRE EDITOR
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
  
$(document).ready(function(){
		$('.redactor').redactor({
				imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
				imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/<?php echo $bus_id;?>',
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				'video','image', 'table','|',
				 'alignment', '|', 'horizontalrule'],
				plugins: ['table', 'video']
			});
		$('[rel=tooltip]').tooltip();

		$('select#city').removeClass('span8');
		$('select#suburb').removeClass('span8');
	 
});

function load_ajax(str){
		
		window.location = '<?php echo site_url('/');?>my_admin/home/'+str;
} 
 

 function load_analytics(id,period){
	 
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'members/get_business_analytics/';?>'+id+'/'+period ,
			success: function (data) {

				     $('#analytics_div').html(data);	   	
			}
		});	 
	 
 }
  function load_analytics_30(id){
	 
	$('#analytics_div').html('');	  
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'members/get_business_analytics_month/';?>'+id ,
			success: function (data) {

				     $('#analytics_div').html(data);	   	
			}
		});	 
	 
 }
 
   function load_tab(id, str){
	var cont = $('#'+str);  
	cont.addClass('loading_img'); 
	cont.empty();	  
	$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'my_admin/';?>'+str+'/'+id ,
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
</script>

</body>
</html>