<?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
 $this->load->view('members/inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 <link href="<?php echo base_url('/');?>css/datatables.css" rel="stylesheet" type="text/css" /> 
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />   
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
	?>	
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
		<div class="container">
         	<div class="clearfix" style="height:100px;"></div>
		 		<div class="row">
				<?php 
                 //+++++++++++++++++
                 //LOAD HOME SEARCH BOX
                 //+++++++++++++++++
                 
                 $this->load->view('inc/home_search');
                 ?>

         		</div>
       </div>

      <!-- Begin page content -->
      <div class="container white_box padding10">
      
	   <div class="row">
      	
        <div class="span12">
        	
          <img src="<?php echo $this->my_na_model->get_user_avatar_str('60','60');?>" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid pull-left" /> 	
          <h3><?php echo $this->session->userdata('u_name');?></h3><?php echo date('l F jS');?>
          <div class="clearfix" style="height:10px"></div> 
             <ul class="breadcrumb">
              <li><a href="#">My Account</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
       
      <div class="row-fluid">
      
      	   <div class="popover top" id="map_info" style="margin:90px 0px 0px 41%">
                  <div class="arrow"></div>
                    <h3 class="popover-title">Update your map<i class="icon-info-sign" style="float:right"></i></h3>
                    <div class="popover-content">
                      <p>You have not set your map yet. Please click on the map tab and pinpoint your location</p>
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
					  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-star-empty"></i> General <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="nav-header">Business Info</li>
                          <li><a href="<?php echo site_url('/').'members/business/'.$bus_id.'/#info';?>">General Info</a></li>
                          <li><a href="#map-tab" onClick="initialise_map()" data-toggle="tab">Map</a></li>
                          <li><a href="#categories" data-toggle="tab">Categories</a></li>
                          <li class="divider"></li>
                          <li class="nav-header">Media</li>
                          <li><a href="#gallery" data-toggle="tab">Gallery</a></li>
                          <li><a href="#info" data-toggle="tab">Logo</a></li>
                        </ul>
                      </li>
                      <li><a href="#analytics" onClick="load_analytics(<?php echo $bus_id;?>, 'MONTH')" data-toggle="tab"><i class="icon-random"></i> Analytics</a></li>
                      <li><a href="#load_qr" onClick="load_tab(<?php echo $bus_id;?>,'load_qr')" data-toggle="tab"><i class="icon-qrcode"></i> QR code</a></li>
                      <li><a href="#enquiries"  onClick="load_mail(<?php echo $bus_id;?>,'all')" data-toggle="tab"><div class="notification_bus_msg_count">
					  <?php $this->my_na_model->msg_notifications_business($bus_id);?></div>
                      <i class="icon-envelope"></i> Enquiries</a></li>
                      <li class="dropdown active">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-thumbs-up"></i> <font class="na_script" style="font-size:20px">!na</font> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                          <li class="nav-header">My <font class="na_script" style="font-size:20px">!na</font></li>
                          <li><a href="#load_tna" onClick="load_tab(<?php echo $bus_id;?>,'load_tna')" data-toggle="tab"> My <font class="na_script" style="font-size:20px">!na</font>'s</a></li>
                     	  <li  class="active"><a href="#load_tna_mail" data-toggle="tab"><font class="na_script" style="font-size:20px">!na</font> - mail</a></li>
                          <li class="divider"></li>
                          <li class="nav-header">Messages</li>
                          <li class="dropdown-submenu">
                            <a tabindex="-1" href="#">Folders</a>
                            <ul class="dropdown-menu">
                              <li><a onClick="load_mail(<?php echo $bus_id;?>,'all')"><i class="icon-inbox"></i> Inbox</a></li>
                              <li><a onClick="load_mail(<?php echo $bus_id;?>,'trash')"><i class="icon-trash"></i> Trash</a></li>
                              <li><a onClick="load_mail(<?php echo $bus_id;?>,'sent')"><i class="icon-share"></i> Sent Mail</a></li>  
                            </ul>
                          </li>
						  <li><a href="#enquiries" onClick="load_mail(<?php echo $bus_id;?>,'all')" data-toggle="tab"><i class="icon-envelope"></i> Inbox</a></li>
                        </ul>
                      </li>
                      <li><a href="#deals" onClick="load_tab(<?php echo $bus_id;?>, 'deals')" data-toggle="tab"><i class="icon-certificate"></i> Deals</a></li>
                      <li><a href="#users" onClick="load_tab(<?php echo $bus_id;?>, 'users')" data-toggle="tab"><i class="icon-user"></i> Users</a></li>
                      <li><a href="#reviews" onClick="load_tab(<?php echo $bus_id;?>, 'reviews')" data-toggle="tab"><i class="icon-comment"></i> Reviews</a></li>
                      
                      <?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
              		  <li><a href="#han_evaluations" onClick="load_tab(<?php echo $bus_id;?>, 'han_evaluations')" data-toggle="tab"><i class="icon-list-alt"></i> HAN Evaluations</a></li>
             		  <?php } ?>	
                    </ul>
                   
                    
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div>
      
      </div> 
       
       	
      <div class="row">
      
       <div class="span3">
            <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 $subnav['subsection'] = 'add_bus';
				 $this->load->view('members/inc/account_nav', $subnav);
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
             ?>
       
       	 
        </div>
      
      
        <div class="span9">
            
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
            <div class="clearfix" style="height:30px;"></div>
            <div class="tab-content">
              <div class="tab-pane" id="info"></div>
              <div class="tab-pane" id="map-tab"><?php $this->load->view('members/inc/business_map_inc', $bus_details);?></div>
              <div class="tab-pane" id="categories"><?php $this->load->view('members/inc/business_categories_inc', $bus_details);?></div>
              <div class="tab-pane" id="gallery"><?php $this->load->view('members/inc/business_gallery', $bus_details);?></div>
              <div class="tab-pane" id="analytics" style="min-height:500px;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center"><h3>Analytics <small><?php echo $name;?></small></h3>
				<div class="clearfix"></div>
                <div id="analytics_div" style="height:auto;background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center"></div>
              </div>
              <div class="tab-pane loading_img" style="min-height:300px;" id="load_tna"></div>
              <div class="tab-pane  active" id="load_tna_mail"><?php $this->load->view('members/inc/build_mail_inc', $bus_details);?></div>
              <div class="tab-pane loading_img" style="min-height:300px;" id="load_qr"></div>
              <div class="tab-pane loading_img" style="min-height:300px;" id="enquiries"></div>
              <div class="tab-pane loading_img <?php if(isset($section) && $section == 'deals'){ echo 'active';}?>" style="min-height:300px;" id="deals"></div>
              <div class="tab-pane loading_img <?php if(isset($section) && $section == 'users'){ echo 'active';}?>" style="min-height:300px;" id="users"></div>
              <div class="tab-pane loading_img" id="reviews" style="min-height:300px;width:100%"></div>
              <div class="tab-pane loading_img" id="han_evaluations"></div>
            </div>
        </div>
       
       
       
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>





  <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
 </div><!-- /wrap--> 
<?php 
 //+++++++++++++++++
 //MODAL HTML
 //+++++++++++++++++
 ?>  
   
<div id="modal-email" class="modal hide fade">
    <div class="modal-header">
      <a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="close">&times;</a>
      <h3>Send Messages? <small> <font class="na_script" style="font-size:20px">!na</font> Mail</small></h3>
    </div>
    <div class="modal-body">
      <img src="<?php echo base_url('/');?>img/na_mail.png" class="pull-right" style="margin-left:10px"/>
      Please make sure you do not have any spelling mistakes and the message has been proofread.
      Your clients do not want to receive junk mail.<br /><br /><br />
      Are you sure you want to send the email to the selected recipients?
     <div id="result_cover"></div>
        	<p id="result_msg"></p> 
            <div class="progress progress-striped active" id="barcover" style="display:none">
                <div class="bar bar-warning" id="barProgress" style="width: 0%;"></div>
     		</div>
    </div>
    <div class="modal-footer">
      <a href="#" id="send_email_yes" class="btn btn-primary">Yes, Send</a>
      <a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="btn secondary">Close</a>
    </div>
</div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster --> 
	 <script src="<?php echo base_url('/');?>js/jquery.filestyle.js" type="text/javascript"></script>
     <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
     <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
     <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script> 
<script type="text/javascript">
<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//FIRE EDITOR
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
  
$(document).ready(
	function()
	{
		$('#redactor_content').redactor({ 	
				
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				'video', 'table','|',
				 'alignment', '|', 'horizontalrule']
			});
		$('[rel=tooltip]').tooltip();
		 $(".carousel").carousel({
							interval: 5000
		});
		
	 	
	}
);


function load_ajax(str){
		
		window.location = '<?php echo site_url('/');?>members/home/'+str;
}

 $("input[type=file]").filestyle({ 
     image: "<?php echo base_url('/').'img/fake_file.jpg';?>",
     imageheight :100,
     imagewidth :150,
     width :120
 });
 
 
 
function preview(){
	
	    var content = $('#admin_content'), str = $('#redactor_content').val(), loading = $('#loading_img'), preview = $('#preview');
		content.slideUp();
		loading.addClass('loading_img');
	
		$.ajax({
			type: 'post',
			cache: false,
			data:{mailbody: str},
			url: '<?php echo site_url('/').'tna_mail/preview_message/'.$bus_id;?>' ,
			success: function (data) {
				$('#preview_button').show();	
				preview.html(data);
				loading.removeClass('loading_img');
				preview.slideDown();
			}
		});	
	
}


$('#send_mail_btn').click(function(e){ 
		
		e.preventDefault();
		if(!$('#title').val().length == 0){
			
				$('#modal-email').bind('show', function() {
						
						$('#send_email_yes').unbind('click').click( function() { 	

								var bar = $('#barcover .bar'),  loading = $('#loading_img');
								var barcover = $('#barcover');
								var frm = $('#sendmail');
								barcover.show();
								frm.attr('action','<?php echo site_url('/').'tna_mail/send_email/';?>');
								frm.attr('target','load_frame');
								$('#send_email_yes').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
									
									$.ajax({
										type: 'post',
										cache: false,
										data: frm.serialize(),
										url: '<?php echo site_url('/').'tna_mail/send_email/';?>' ,
										success: function (data) {
											//barcover.hide();
											
											$('#result_cover').html(data);
										}
									});	
								
						});		
						
					})
					.modal({ backdrop: true });	
		}else{
			
			$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Subject Required", content:"Please give the newsletter a valid and enticing subject line."});
			$('#title').popover('show');
			$('#title').focus();
				
		}			
	
});

   function load_msg(id, bus_id, status){
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
		$('#enquiries').addClass('loading_img');		  
		$.ajax({
				type: 'get',
				cache: false,
				url: '<?php echo site_url('/').'tna_mail/load_mail/';?>'+bus_id+'/'+str ,
				success: function (data) {
					$('#enquiries').removeClass('loading_img');	
					$('#enquiries').html(data);	
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
					
					if(str != 'load_qr' ||  str != 'deals'){
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