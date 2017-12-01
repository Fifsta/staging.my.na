<?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag


 ?>
 <link href="<?php echo base_url('/');?>css/datatables.min.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css?v=1" />
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
  $bus_details = $this->members_model->get_business_details($bus_id);
  $name = ucwords($bus_details['BUSINESS_NAME']);
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
	?>	
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
		<div class="container-fluid" id="home_container">
         	<div class="clearfix" style="height:30px;"></div>
		 		<div class="row">
				<?php 
                 //+++++++++++++++++
                 //LOAD HOME SEARCH BOX
                 //+++++++++++++++++
                 
                 //$this->load->view('inc/home_search');
                 ?>

         		</div>

      <!-- Begin page content -->
      <div class="padding10">
      
	   <div class="row-fluid">
      	
        <div class="span12">

          <img src="<?php echo $this->my_na_model->get_user_avatar_str('60','60');?>" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid pull-left" />

          <h3 class="upper na_script"><?php echo $this->session->userdata('u_name');?></h3><?php echo date('l F jS');?>
          <div class="clearfix" style="height:10px"></div> 
             <ul class="breadcrumb">
              <li><a href="<?php echo site_url('/');?>members/home/">My Account</a> <span class="divider">/</span></li>
               <li><a href="<?php echo site_url('/');?>members/business/<?php echo $bus_id;?>/"><?php echo $name;?> </a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
      
      <div class="row-fluid">
      
              	<div class="popover top" id="map_info" style="margin:90px 0px 0px 41%">
                  <div class="arrow"></div>
                    <h3 class="popover-title">Update your map<i class="icon-info-sign" style="float:right"></i></h3>
                    <div class="popover-content">
                      You have not set your map yet. Please click on the map tab and pinpoint your location
                 </div>
              </div>
			
             <div class="navbar">
              <div class="navbar-inner" style="margin:0;padding:0">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  
                  <div class="nav-collapse navbar-responsive-collapse in collapse" style="height: auto;">
                    <ul class="nav">
					  <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Maintain your business info" rel="tooltip"><i class="icon-star-empty"></i> General <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="nav-header">Business Info</li>
                          <li class="active"><a href="#info" data-toggle="tab">General Info</a></li>
                          <li><a href="#map-tab" onClick="initialise_map()" data-toggle="tab">Map</a></li>
                          <li><a href="#categories" data-toggle="tab">Categories</a></li>
                          <li><a href="#amenities" data-toggle="tab">Amenities</a></li>
                          <li class="divider"></li>
                          <li class="nav-header">Media</li>   
                          <li><a href="#gallery" data-toggle="tab">Gallery</a></li>
                          <li><a href="#info" data-toggle="tab">Logo</a></li>
                        </ul>
                      </li>
                      <li><a href="#analytics" onClick="load_analytics(<?php echo $bus_id;?>, 'MONTH')" data-toggle="tab" title="View the statistics of your listing" rel="tooltip"><i class="icon-random"></i> Analytics</a></li>
                      <li><a href="#load_qr" onClick="load_tab(<?php echo $bus_id;?>,'load_qr')" data-toggle="tab" title="Utilize your quick response code" rel="tooltip"><i class="icon-qrcode"></i> QR code</a></li>
                      <li><a href="#enquiries"  onClick="load_mail(<?php echo $bus_id;?>,'all')" data-toggle="tab" title="Go to your message inbox" rel="tooltip"><div class="notification_bus_msg_count">
					  <?php $this->my_na_model->msg_notifications_business($bus_id);?></div>
                      <i class="icon-envelope"></i> Enquiries</a></li>
                      <li class="dropdown" title="Connect with your fans and check your messages" rel="tooltip">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" ><i class="icon-thumbs-up"></i> <span class="na_script" style="font-size:15px">!na</span> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="nav-header">My !na</li>
                          <li><a href="#load_tna" onClick="load_tab(<?php echo $bus_id;?>,'load_tna')" data-toggle="tab"><i class="icon-glass"></i> My <span class="na_script" style="font-size:20px">!na</span>'s</a></li>
                     	  <li><a href="<?php echo site_url('/').'members/tna_mail/'.$bus_id.'/';?>"><i class="icon-glass"></i> <span class="na_script" style="font-size:20px">!na</span> - mail</a></li>
                          <li class="divider"></li>
                          <li class="nav-header">Messages</li>
						  <li><a href="#enquiries"  onClick="load_mail(<?php echo $bus_id;?>,'all')" data-toggle="tab"><i class="icon-envelope"></i> Inbox</a></li>
                        </ul>
                      </li>
                      <?php if($bus_details['IS_ESTATE_AGENT'] == 'Y' ||  $bus_id == '9333' || $bus_id == '9228' || $bus_id == '1290' || $bus_id == '2666' || $bus_id == '8226' || $bus_id == '1807' || $bus_id == '8785' || $bus_id == '8842' || $bus_id == '8840' || $bus_id == '8848' || $bus_id == '8966' || $bus_id == '8974' || $bus_id == '980' || $bus_id == '2706' || $bus_id == '9014' || $bus_id == '9015' || $bus_id == '9016' || $bus_id == '4608' || $bus_id == '5959' || $bus_id == '9123' || $bus_id == '9120'){ ?>
                        <li id="trade_btn" class="dropdown trade">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-shopping-cart"></i> Buy/Sell <b class="caret"></b></a>
                          <ul class="dropdown-menu" style="width:290px;">
                            
                            <?php if($bus_details['IS_ESTATE_AGENT'] == 'Y'){ ?>
                             <li class="nav-header">My Properties</li>
                              <li><a href="<?php echo site_url('/').'sell/index/'.$bus_id.'/';?>"><i class="icon-home"></i> List a Agency Product <span style="font-size:10px;"><br> List products you want to sell</span></a></li>
                              <?php // JOUBERT BALT IS PRIVATE
                              		if($bus_id != 8848){?>
                              			<li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/live/';?>"><i class="icon-hdd"></i> Agency Products <span style="font-size:10px;"><br> Items listed under the agency</span></a></li>
                              <?php } ?>
                              <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/live_agent/';?>" ><i class="icon-user"></i> My Products <span style="font-size:10px;"><br> Items you are currently selling</span></a></li>
                              <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/sold_agent/';?>"><i class="icon-flag"></i> Items I've Sold <span style="font-size:10px;"><br> Find the items you have sold</span></a></li>
						      <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/';?>">New Dashboard <i class="icon-flag"></i><span style="font-size:10px;"><br> Check out the new Buy and Sell Dashboard</span></a></li>
                             <?php }else{ ?>
                             <li class="nav-header">Company Products</li>
                              <li><a href="<?php echo site_url('/').'sell/index/'.$bus_id.'/';?>">Sell an Item <span style="font-size:10px;"><br> List items you want to sell</span></a></li>
                              <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/live/';?>">My Items <span style="font-size:10px;"><br> Items you are currently selling</span></a></li>
                             <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/sld/';?>">Items I've Sold <span style="font-size:10px;"><br> Find the items you have sold</span></a></li>
                             <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/';?>">New Dashboard <i class="icon-flag"></i><span style="font-size:10px;"><br> Check out the new Buy and Sell Dashboard</span></a></li>
                            <?php } ?>
                          </ul>
                        </li>
                        <?php }?>
                       <li><a href="#deals" onClick="load_tab(<?php echo $bus_id;?>, 'deals')" data-toggle="tab" title="Maintain your business deals" rel="tooltip"><i class="icon-certificate"></i> Deals</a></li>
                       <li><a href="#users" onClick="load_tab(<?php echo $bus_id;?>, 'users')" data-toggle="tab" title="Manage your listing administrators" rel="tooltip"><i class="icon-user"></i> Users</a></li>
                       <li><a href="#reviews" onClick="load_tab(<?php echo $bus_id;?>, 'reviews')" data-toggle="tab" title="Monitor your business reviews" rel="tooltip"><i class="icon-comment"></i> Reviews</a></li>

                       <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
              			<li><a href="#han_evaluations" onClick="load_tab(<?php echo $bus_id;?>, 'han_evaluations')" data-toggle="tab" title="View your HAN evaluations" rel="tooltip"><i class="icon-list-alt"></i> HAN Evaluations</a></li>
             		   <?php } ?>	
                       <?php if($bus_details['IS_CMS'] == 'Y'){ ?>
              			<li><a href="#my_cms" onClick="load_tab(<?php echo $bus_id;?>, 'my_cms')" data-toggle="tab" title="Update your website" rel="tooltip"><i class="icon-wrench"></i> My CMS</a></li>
             		   <?php } ?>	
                        					  
                    </ul>
                   
                    
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>
      
      </div>
      
      
       	
      <div class="row-fluid">
      
       <div class="span3">
            <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 $subnav['subsection'] = 'add_bus';
				 $this->load->view('members/inc/account_nav', $subnav);

				
             ?>
       
       	 
        </div>
      
      
        <div class="span9">

	        <?php
	        $atts = array(
		        'width'      => '800',
		        'height'     => '600',
		        'scrollbars' => 'yes',
		        'status'     => 'yes',
		        'resizable'  => 'yes',
		        'screenx'    => '0',
		        'screeny'    => '0',
		        'class'      => 'btn',
		        'title'      => 'Preview your personal widget',
		        'rel'        => 'tooltip'
	        );
	        $atts2 = array(
		        'width'      => '800',
		        'height'     => '600',
		        'scrollbars' => 'yes',
		        'status'     => 'yes',
		        'resizable'  => 'yes',
		        'screenx'    => '0',
		        'screeny'    => '0',
		        'class'      => 'btn',
		        'title'      => 'View your unique rating code',
		        'rel'        => 'tooltip'
	        );
	        ?>

	        <div class="well well-mini"><h4>Official Namibian Rating Widget! <img src="<?php echo base_url('/');?>img/icons/fnb_irate.png" style="width:90px" class="pull-right" /></h4>

		        <p><small class="muted">Get more valuable feedback and allow your clients to rate and review your business service or product online.</small>
			        </p>
		        <textarea class="span12"><script src="<?php echo base_url('/')?>js/rating/widget.js?v1.1&bus_id=<?php echo $bus_id;?>&embed=plugin&external=true" id="myna"></script></textarea>
		        <p><small class="muted">Copy the code above and insert it into your website to include your personal rating widget.
				        Not computer savy? Simply copy the code/text above and forward it to your web designer or company.</small></p>
				<p>
					<?php echo anchor_popup(site_url('/').'rate/preview/'.$bus_id, '<span class="notification-small btn-success">New!</span><i class="icon-search"></i> Preview Widget', $atts);?>
					<?php echo anchor_popup(site_url('/').'my_images/qr/business/'.$bus_id, '<i class="icon-qrcode"></i> Get Your Code', $atts2);?>
                    <a href="javascript:void(0)" onClick="copyToClipboard()" class="btn">Unique Rating Link</a>
					<img src="<?php echo base_url('/');?>img/icons/affiliation.png" class="pull-right" title="Proudly Partnered With" rel="tooltip"/>
				</p>


	        </div>



             <div class="alert alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <h4><span class="na_script" style="font-size:20px">My Business Dashboard</span></h4> 
                    This is the administration dashboard for <?php echo $name;?>. You can manage all business details, update the business location on the map, view business
                    analytics, publish deals, send customised business emails to every user who has <span class="na_script">!na'd</span> your business and manage users who have access.
             </div>   


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
             
                <div class="clearfix" style="height:5px;"></div>
                <div class="tab-content">
                  <div class="tab-pane<?php if($section != 'message'){ echo ' active';}?>" id="info">
                  	  <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
                        <img src="<?php echo base_url('/');?>img/icons/han_sml.png" title="Proud HAN Member" rel="tooltip" class="pull-right" />
                      <?php } ?>
                      <?php if($bus_details['IS_NTB_MEMBER'] == 'Y'){ ?>
                        <img src="<?php echo base_url('/');?>img/icons/ntb_sml.png" title="Namibia Tourism Board Member" rel="tooltip" class="pull-right" />
                      <?php } ?>
					  <?php $this->load->view('members/inc/business_details', $bus_details);?></div>
                  <div class="tab-pane" id="map-tab"><?php $this->load->view('members/inc/business_map_inc', $bus_details);?></div>
                  <div class="tab-pane" id="categories"><?php $this->load->view('members/inc/business_categories_inc', $bus_details);?></div>
                   <div class="tab-pane" id="amenities"><?php $this->load->view('admin/inc/business_amenities_inc', $bus_details);?></div>
                  <div class="tab-pane" id="gallery"><?php $this->load->view('members/inc/business_gallery', $bus_details);?></div>
                  <div class="tab-pane" id="analytics" style="min-height:500px;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center"><h3>Analytics <small><?php echo $name;?></small></h3>
                    <div class="clearfix"></div>
                    <div id="analytics_div" style="height:auto;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center"></div>
                  </div>
                  <div class="tab-pane loading_img" style="min-height:300px;" id="admin_content"></div>
                  <div class="tab-pane loading_img" style="min-height:300px;" id="load_tna"></div>
                  <div class="tab-pane" id="load_tna_mail"></div>
                  <div class="tab-pane loading_img" style="min-height:300px;" id="load_qr"></div>
                  <div class="tab-pane loading_img <?php if(isset($section) && $section == 'message'){ echo 'active';}?>" style="min-height:300px;width:100%" id="enquiries"></div>
                  <div class="tab-pane loading_img <?php if(isset($section) && $section == 'deals'){ echo 'active';}?>" style="min-height:300px;width:100%" id="deals"></div>
                  <div class="tab-pane loading_img <?php if(isset($section) && $section == 'users'){ echo 'active';}?>" style="min-height:300px;width:100%" id="users"></div>
                  <div class="tab-pane loading_img" id="reviews" style="min-height:300px;width:100%"></div>
                  <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
              	  <div class="tab-pane loading_img" id="han_evaluations"></div>
             	  <?php } ?>	
                  <?php if($bus_details['IS_CMS'] == 'Y'){ ?>
              	  <div class="tab-pane loading_img" id="my_cms"></div>
             	  <?php } ?>	
                </div>
              
        </div>
       
       
       
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      
     </div><!-- /bak--> 
   

 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
</div><!-- /wrap-->

 <?php /**
++++++++++++++++++++++++++++++++++++++++++++
//DELETE IMAGE MODAL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?>

 <div id="modal-respond" class="modal fade">
    <div class="loading_img"></div>
 </div>
 <div id="modal-claim" class="modal hide fade">
     <div class="modal-header">
         <a href="javascript:void(0)" onClick="javascript:$('#modal-claim').modal('hide')" class="close">&times;</a>
         <h3>Claim a business listing</h3>
     </div>

     <div class="modal-body" >
         <div id="claim_modal" class="loading_img" style="width:100%; min-height:300px"></div>

     </div>

     <div class="modal-footer">
         <a href="javascript:void(0)" onClick="javascript:$('#modal-claim').modal('hide')" class="btn btn-secondary">Cancel</a>
     </div>
 </div>

 <div class="modal hide fade" id="modal-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete Messages</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to completely remove the selected messages?</p>
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Remove</a>
  </div>
</div>

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
	 <script src="<?php echo base_url('/')?>redactor/redactor/video.js"></script>
	 <script src="<?php echo base_url('/')?>redactor/redactor/table.js"></script>
     <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
     <script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
    <script src="<?php echo base_url('/');?>js/custom/members_home.js"></script>
<script type="text/javascript">
<?php 


  /**
++++++++++++++++++++++++++++++++++++++++++++
//FIRE EDITOR
++++++++++++++++++++++++++++++++++++++++++++	
 */
   
 ?>
  
$(document).ready(function(){
		
		//REDIRECT MESSAGES
		<?php if(isset($section)){
			
				if($section == 'message'){
				
					echo "load_msg(".$msg_id.",".$bus_id.",'unread');";
				
				}elseif($section == 'deals'){
					
					echo "load_tab(".$bus_id.",'deals');";
					
				}
			
			}
		?>

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
	 
	}
);


   function load_trade(str, bus_id, section){
	   
	   // home_feed = false;
		var n =$('#admin_content');
		n.empty().addClass('loading_img');		  
		$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/');?>trade/'+str+'/'+bus_id+"/"+section ,
				success: function (data) {
					n.removeClass('loading_img');	
					n.html(data);	
						
				}
			});	 
	 
 }

 function copyToClipboard() {
	var txt = 'https://www.my.na/rate/rateme/<?php echo $bus_id;?>/plugin/external';
    window.prompt("Copy to clipboard: Ctrl+C, Enter", txt);
  }


function load_ajax(str){
		
		window.location = '<?php echo site_url('/');?>members/home/'+str;
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
	
	$('#analytics').addClass('loading'); 
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
 
   function load_msg(id,bus_id,status){
		$('#enquiries').addClass('loading_img');		  
		$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'tna_mail/view_msg_business/';?>'+id+'/'+bus_id+'/'+status ,
				success: function (data) {
					$('#enquiries').removeClass('loading_img');	
					$('#enquiries').html(data);	
				}
			});	 
		 
 }
 
 
    function load_mail(bus_id,str){
		var x = $('#enquiries');
		x.empty();
		x.addClass('loading_img');		  
		$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'tna_mail/load_mail/';?>'+bus_id+'/'+str ,
				success: function (data) {
					x.removeClass('loading_img');	
					x.html(data);	
					$('#example1').dataTable( {
								"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
								"sPaginationType": "bootstrap",
								"oLanguage": {
									"sLengthMenu": "_MENU_"
								},
								"aaSorting":[],
								"bSortClasses": false
		
							} );
					load_notification();		
				}
			});	 
	 
 }
 
 function load_notification(){
	 
	 $.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'tna_mail/reload_notify_count/';?>',
				success: function (data) {
					$('.notification_msg_count').html(data);	
					
				}
			});
			
		 $.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'tna_mail/reload_notify_count_business/'.$bus_id;?>',
				success: function (data) {
					$('.notification_bus_msg_count').html(data);	
					
				}
			});	
				 
 }
 
function delete_msg(){
	
	$('#modal-delete').bind('show', function() {

			var removeBtn = $(this).find('.btn-primary');
				
			removeBtn.click(function(e) { 
					
				e.preventDefault();

						var postdata = $("input[type=checkbox]").serialize();
						$.ajax({
							type: 'post',
							url: '<?php echo site_url('/').'tna_mail/delete_msg/';?>' ,
							data: postdata,
							success: function (data) {
								 
								 $('#modal-delete').modal('hide');
								 $('#inbox_msg').html(data);
								 load_mail(<?php echo $bus_id;?>,'all');
							}
						});
			});
			
	}).modal({ backdrop: true });	
	
}

</script>

</body>
</html>