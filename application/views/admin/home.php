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
 <link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
  <link href="<?php echo base_url('/');?>css/jplayer/jplayer.pink.flag.css" rel="stylesheet" type="text/css" /> 
 <link href="<?php echo base_url('/');?>css/datatables.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
 #loading_img{position:relative;min-height:600px}
 .loading_img{min-height:400px;width:100%;position:relative;top:0;left:0;right:0;bottom:0; z-index: 1040;
  background-color: #FFF; background: url("<?php echo base_url('/');?>img/load.gif") no-repeat center center;
    opacity: 0.8;
  filter: alpha(opacity=80);}
 .container-fluid{max-width:1400px; margin:0 auto}
 </style> 
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">

      <!-- Begin page content -->
      <div id="container-body" class="container-fluid white_box padding10"  style="margin-top:80px;">
      
	  <div class="row-fluid">
      	
        <div class="span12">
     <!--   	<object id="MediaPlayer" width="250" height="70" 
            	classid="clsid:6bf52a52-394a-11d3-b153-00c04f79faa6" codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=5,1,52,701" 
                bgcolor="darkblue">
                <param name="filename" value="http://80.237.158.41:8000">
                <param name="autoStart" value="false">
                <param name="TransparentAtStart" value="false">
                <param name="AnimationatStart" value="false">
                <param name="ShowStatusBar" value="true">
                <param name="ShowControls" value="true">
                <param name="autoSize" value="false">
                <param name="displaySize" value="false">
                <param name="ShowAudioControls" value="true">
                <param name="ShowPositionControls" value="false">
                <param name="url" value="http://80.237.158.41:8000">
                <param name="pluginspage" value="http://microsoft.com/windows/mediaplayer/en/download/">
                <param name="displaysize" value="4"><param name="autosize" value="-1">
                <param name="showcontrols" value="true"><param name="showtracker" value="-1">
                <param name="showdisplay" value="0"><param name="showstatusbar" value="-1">
                <param name="videoborder3d" value="-1"><param name="autostart" value="false">
                <param name="designtimesp" value="5311"><param name="loop" value="loop">
                <param name="transparentatstart" value="false">  
                <param name="animationatstart" value="false">
                <param name="showaudiocontrols" value="true">
                <param name="showpositioncontrols" value="false">
                <param name="url" value="http://80.237.158.41:8000">
                <embed id="MediaPlayer" width="250" height="70" type="application/x-mplayer2" 
                src="http://80.237.158.41:8000" filename="http://80.237.158.41:8000" autostart="false"
                 transparentatstart="false" animationatstart="false" showstatusbar="true" showcontrols="true" 
                 autosize="false" displaysize="false" showaudiocontrols="true" showpositioncontrols="false" 
                 url="http://80.237.158.41:8000" pluginspage="http://microsoft.com/windows/mediaplayer/en/download/" 
                 showtracker="-1" showdisplay="0" videoborder3d="-1" designtimesp="5311" loop="loop" bgcolor="darkblue">
            </object>-->
            
        <!--   <script type="text/javascript" src="http://player.wavestreamer.com/cgi-bin/swf.js?id=8YJM1UIBKRS4RL8L"></script>
			<script type="text/javascript" src="http://player.wavestreaming.com/?id=8YJM1UIBKRS4RL8L"></script>-->
            
         <!--<div id="jquery_jplayer_1" class="jp-jplayer"></div>

            <div id="jp_container_1" class="jp-audio-stream">
                <div class="jp-type-single">
                    <div class="jp-gui jp-interface">
                        <ul class="jp-controls">
                            <li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
                            <li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
                            <li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
                            <li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
                            <li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
                        </ul>
                        <div class="jp-volume-bar">
                            <div class="jp-volume-bar-value"></div>
                        </div>
                    </div>
                    <div class="jp-title">
                        <ul>
                            <li>ABC Jazz</li>
                        </ul>
                    </div>
                    <div class="jp-no-solution">
                        <span>Update Required</span>
                        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                    </div>
                </div>
            </div>-->


		  <!-- <audio controls>
             
             <source src="http://80.237.158.41:8000" type="audio/mpeg" />
             <source src="http://80.237.158.41:8000" type="audio/ogg" />
            </audio>-->

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
      
      	
      <div class="row-fluid">
      
       <div class="span3">
            <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 $subnav['subsection'] = 'myinfo';
				 $this->load->view('admin/inc/admin_nav', $subnav);
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
          <div id="loading_img">
              <div id="msg"></div>     
              <div id="admin_content">
               <div class="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Please Note!</strong> The navigation is not finished 100% please select the section you want to administer. You might have to click twice on the registered Users and  		 					business section
                </div>
              </div>
          </div>  

        </div>
       <div class="clearfix" style="height:30px;"></div>
       
       
      </div><!--end Row -->
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      <div id="push"></div>
    </div>
 <?php 
 //+++++++++++++++++
 //MODAL HTML
 //+++++++++++++++++
 ?>  
   
<div class="modal hide fade" id="modal-cat-add-main">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Add a Main Category</h3>
  </div>
  <div class="modal-body">
    <div class="alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
 		 <strong>Please Note!</strong> Please give the category a meaningful name and DO NOT use any special characters such as : <code>!@#$%^</code>
	</div>
    <form id="add_main_cat_frm" method="post" action="">
         <input type="text" style="font-size:16px;line-height:22px;height:30px;padding:5px;width:98%" id="main_cat_name" name="main_cat_name" placeholder="Category Name..." />
   </form>
  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Add category</a>
  </div>
</div>

<div class="modal hide fade" id="modal-update-cat">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Update Category</h3>
  </div>
  <div class="modal-body" id="update_cat_content">
    
    
    
  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a class="btn btn-primary">Update category</a>
  </div>
</div>


<div class="modal hide fade" id="modal-cat-add-sub">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Add a Sub Category</h3>
  </div>
  <div class="modal-body">
    <div class="alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
 		 <strong>Please Note!</strong> Please give the category a meaningful name and DO NOT use any special characters such as : <code>!@#$%^</code>
	</div>
    <form id="add_sub_cat_frm" method="post" action="">
         <input type="text" style="font-size:16px;line-height:22px;height:30px;padding:5px;width:98%" id="sub_cat_name" name="sub_cat_name" placeholder="Sub Category Name..." />
   </form>
  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Add category</a>
  </div>
</div>


<div class="modal hide fade" id="modal-cat-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete the Category</h3>
  </div>
  <div class="modal-body">
    <div class="alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
 		 <strong>Please Note!</strong> Are you sure you want to delete the current category? All associated sub categories will be deleted aswell.
	</div>

  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Delete Category</a>
  </div>
</div>


<div class="modal hide fade" id="modal-review">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Moderate the review</h3>
  </div>
  <div class="modal-body">
  <p id="review_msg"></p>
    <div class="alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
 		 <strong>Please Note!</strong> Are you sure you want to change the status of the current review?
	</div>

  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Update review</a>
  </div>
</div>


<div class="modal hide fade" id="modal-member-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete the Member</h3>
  </div>
  <div class="modal-body">
    Are you sure you want to delete the current member? This process is not reversible!
  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Delete Member</a>
  </div>
</div>



<div class="modal hide fade" id="modal-page-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete the Page</h3>
  </div>
  <div class="modal-body">
    <div class="alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
 		 <strong>Please Note!</strong> Are you sure you want to delete the current page? All page details will be removed. This proces is not reversible.
	</div>

  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Delete Page</a>
  </div>
</div>


<div class="modal hide fade" id="modal-bus-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete the Business</h3>
  </div>
  <div class="modal-body">
    <div class="alert">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
 		 <strong>Please Note!</strong> Are you sure you want to delete the current business? All associated resources will be deleted aswell.
	</div>

  </div>
  <div class="modal-footer">
	  <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <a href="#" class="btn btn-primary">Delete Business</a>
  </div>
</div>


 <div class="modal hide fade" id="modal-approve-product">
     <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
         <h3>Approve the Product</h3>
     </div>
     <div class="modal-body" id="approve_product_body">
         <div class="alert">
             <button type="button" class="close" data-dismiss="alert">&times;</button>
             <strong>Please Note!</strong> Upon approval you will get sharing options into facebok. The user will also receive a confirmation email.
         </div>

     </div>
     <div class="modal-footer">
         <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
         <a href="#" class="btn btn-primary">Approve</a>
     </div>
 </div>

 <iframe id="export_frame" allowtransparency="1" frameborder="0" style="width:0;height:0"></iframe>
 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('admin/inc/footer_backend', $footer);
 ?>
 <div class="modal hide fade" id="modal-product-question">
	 <div class="modal-header">
		 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 <h3>Product Questions</h3>
	 </div>
	 <div class="modal-body" id="product_q_div">

	 </div>
	 <div class="modal-footer">
		 <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

	 </div>
 </div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="<?php echo base_url('/');?>js/jplayer/jquery.jplayer.min.js"></script>
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('/');?>js/print_page.js"></script>

 <script type="text/javascript">
//IF REDIRECT
//LOAD AJAX CONTENT
<?php

if(isset($redirect)){
	
echo "$(function() {
    
		load_ajax('".$redirect."');
    
 	 });";
	
}

?>



function delete_member(id){
	  
	$('#modal-member-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_member/"+id+"/",
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-member-delete').modal('hide');
					load_ajax('users');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}



function delete_business(id, str){
	  
	$('#modal-bus-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_business/"+id+"/",
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-bus-delete').modal('hide');
					load_ajax(str);
				  }
				});
				
			});
	}).modal({ backdrop: true });
}


function load_content(str){

	var n = $('#admin_content');
	n.fadeOut();
	var loading = $('#loading_img');
	loading.addClass('loading_img');
	$.ajax({
		type: 'get',
		cache: false,
		url: '<?php echo site_url('/').'my_admin/content/';?>'+str+'/' ,
		success: function (data) {

			n.html(data).delay('300').fadeIn('300');

			if(str != 'scratch'){
				$('#example').dataTable( {
					"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_ records per page"
					},
					"aaSorting":[],
					"bSortClasses": false

				} );
			}
			loading.removeClass('loading_img');
		}
	});

}
function add_content(type){

    var n = $('#admin_content');
    //frm.submit();
    //$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
    $.ajax({
        type: 'get',
        url: '<?php echo site_url('/').'my_admin/add_content_single/';?>'+type ,

        success: function (data) {

            n.html(data);
            //$('#but').html('<b>Update</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');

        }
    });

}

function load_ajax(str){
		
		var n = $('#admin_content');
		n.fadeOut();
		var loading = $('#loading_img');
		loading.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'my_admin/';?>'+str+'/' ,
			success: function (data) {	
				
				n.html(data).delay('300').fadeIn('300');
				
				if(str != 'scratch'){
					$('#example').dataTable( {
					  "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
					  "sPaginationType": "bootstrap",
					  "oLanguage": {
						  "sLengthMenu": "_MENU_ records per page"
					  },
					  "aaSorting":[],
					  "bSortClasses": false
	
					} );
				}
				loading.removeClass('loading_img');
			}
		});	

}
function load_ajax_cat_sub(id){
		
		var n = $('#admin_content');
		n.fadeOut();
		var loading = $('#loading_img');
		loading.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'my_admin/categories_sub/';?>'+id+'/' ,
			success: function (data) {	
				
				n.html(data).delay('300').fadeIn('300');
				$('#example').dataTable( {
					  	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ records per page"
						},
						"aaSorting":[],
						"bSortClasses": false

					} );
				loading.removeClass('loading_img');
			}
		});	

}

function add_cat_main(){
	
	$('#modal-cat-add-main').bind('show', function() {
		    
			var removeBtn = $(this).find('.btn-primary');
			
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();
				var name = $('#main_cat_name').val();	
				$.ajax({
				  type: "post",
				  data: {main_cat_name: name},
				  url: "<?php echo site_url('/');?>my_admin/add_category_main/",
				  success: function(data) {
					load_ajax('categories');
					$("#msg_admin").html(data);
					$('#modal-cat-add-main').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });

	
}

function add_cat_sub(main_id){
	
	$('#modal-cat-add-sub').bind('show', function() {
			
			var removeBtn = $(this).find('.btn-primary');
			
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();
				console.log(main_id);
				var name = $('#sub_cat_name').val();	
				$.ajax({
				  type: "post",
				  data: {cat_name: name, main_cat_id: main_id },
				  url: "<?php echo site_url('/');?>my_admin/add_category_sub/",
				  success: function(data) {
					load_ajax_cat_sub(main_id);
					$("#msg_admin").html(data);
					$('#modal-cat-add-sub').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });
	
}
//MAIN CAT
function update_cat_main(id){
	
	$('#modal-update-cat').bind('show', function() {
		
		   var removeBtn = $(this).find('.btn-primary');
		   removeBtn.attr('onClick', 'update_cat_main_do('+id+')');
				$.ajax({
				  type: "get",
				  url: "<?php echo site_url('/');?>my_admin/update_category_main/"+id,
				  success: function(data) {
					
					$('#update_cat_content').html(data);
					
				  }
				});
				
		
	}).modal({ backdrop: true });
	
}
//MAIN CAT
function update_cat_main_do(id){
	
			var frm = $('#main-cat-update');
	
			$.ajax({
			  type: "post",
			  data: frm.serialize(),
			  url: "<?php echo site_url('/');?>my_admin/update_cat_main_do",
			  success: function(data) {
				load_ajax('categories');
				$("#msg_admin").html(data);
				$('#modal-update-cat').modal('hide');
				
			  }
			});
		
	
}

//SUB CAT
function update_cat_sub(id){
	
	$('#modal-update-cat').bind('show', function() {
		
		   var removeBtn = $(this).find('.btn-primary');
		   removeBtn.attr('onClick', 'update_cat_sub_do('+id+')');
				$.ajax({
				  type: "get",
				  url: "<?php echo site_url('/');?>my_admin/update_category_sub/"+id,
				  success: function(data) {
					
					$('#update_cat_content').html(data);
					
				  }
				});
				
		
	}).modal({ backdrop: true });
	
}

//MAIN CAT
function update_cat_sub_do(id){
	
			var frm = $('#sub-cat-update');
	
			$.ajax({
			  type: "post",
			  data: frm.serialize(),
			  url: "<?php echo site_url('/');?>my_admin/update_cat_sub_do",
			  success: function(data) {
				load_ajax('categories');
				$("#msg_admin").html(data);
				$('#modal-update-cat').modal('hide');
				
			  }
			});
		
	
}

function delete_cat(id, str){
	  
	$('#modal-cat-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_category/"+id+"/"+str+"/",
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-cat-delete').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}


function approve_review(id, str, type){
	  
	$('#modal-review').bind('show', function() {
		//var id = $(this).data('id'),
			if(str == 'yes'){
				$('#review_msg').html('Set the current review status to <span class="label label-success">Approved</span>?<br /><em>Review:</em><br />');
			}else{
				$('#review_msg').html('Set the current review status to <span class="label label-important">Banned</span>?<br /><em>Review:</em><br />');
			}
			
			removeBtn = $(this).find('.btn-primary');
			
			removeBtn.unbind('click').click(function(e) { 
			
				e.preventDefault();	
				removeBtn.html('Working...');
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/update_review/"+id+"/"+str+"/",
				  success: function(data) {
					load_ajax(type);
					$("#msg_admin").html(data);
					$('#modal-review').modal('hide');
					removeBtn.html('Update Review');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}


function delete_review(id){
	  
	$('#modal-review').bind('show', function() {
		//var id = $(this).data('id'),
			
			$('#review_msg').html('Are you sure you want to delete the review?');
			
			
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				removeBtn.html('Working...');
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_review/"+id,
				  success: function(data) {
					load_ajax('reviews');
					$("#msg_admin").html(data);
					$('#modal-review').modal('hide');
					
					removeBtn.html('Delete Review');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}

function delete_page(id){
	  
	$('#modal-page-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_page/"+id+"/",
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-page-delete').modal('hide');
					
				  }
				});
				
			});
	}).modal({ backdrop: true });
}




function approve_product_do(id, str){

	$("#approve_product_body").html('<div class="alert"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Please Note!</strong> Upon approval you will get sharing options into facebok. The user will also receive a confirmation email.</div>');
	
    $('#modal-approve-product').unbind('show').bind('show', function() {
        //var id = $(this).data('id'),
        removeBtn = $(this).find('.btn-primary'),cont = $("#approve_product_body");;

        removeBtn.unbind('click').click(function(e) {
            cont.addClass("loading_img").css("width","90%");
            e.preventDefault();
            $.ajax({
                dataType: 'json',
                url: "<?php echo site_url('/');?>my_admin/approve_product/"+id+"/"+str,
                success: function(data) {

                    //console.log(data);

                    $("#approve_product_body").html(data.msg);
                    //$('#modal-approve-product').modal('hide');
                    cont.removeClass("loading_img");
                }
            });

        });
    }).modal({ backdrop: true });
}


function share_product_group(id){

    var cont = $("#approve_product_body");

    cont.addClass("loading_img").css("width","90%");
    $.ajax({
        type: "get",
        cache: false,
        dataType: 'json',
        url: "<?php echo site_url('/');?>trade/share_product_group/"+id+"/" ,
        success: function (data) {
            //cont.removeClass("loading_img");
            $('a.group_').attr(
                {'onclick': '','target':'_blank','href':'https://facebook.com/'+data.id}
            ).html('View Group Post');
            //cont.append(data);
           // load_ajax("load_products");
            cont.removeClass("loading_img");
        }
    });

}

function share_product_page(id){

    var cont = $("#approve_product_body");

    cont.addClass("loading_img").css("width","90%");
    $.ajax({
        type: "get",
        cache: false,
        dataType: 'json',
        url: "<?php echo site_url('/');?>trade/share_product_page/"+id+"/" ,
        success: function (data) {
            //cont.removeClass("loading_img");

            $('a.page_').attr(
                {'onclick': '','target':'_blank','href':'https://facebook.com/'+data.id}
            ).html('View Page Post');
           // load_ajax("load_products");
            cont.removeClass("loading_img");
        }
    });

}

/*$(document).ready(function(){

	var stream = {
		title: "ABC Jazz",
		mp3: "http://77.68.106.224:8018;stream/1"
	};

	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			ready = true;
			$(this).jPlayer("setMedia", stream);
		},
		pause: function() {
			$(this).jPlayer("clearMedia");
		},
		error: function(event) {
			if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
				// Setup the media stream again and play it.
				$(this).jPlayer("setMedia", stream).jPlayer("play");
			}
		},
		swfPath: "<?php echo base_url('/');?>js/jplayer/",
		supplied: "mp3",
		preload: "none",
		wmode: "window",
		keyEnabled: true,
		volume: 0.8,
 		muted: false,
		cssSelector: {
		  videoPlay: '.jp-video-play',
		  play: '.jp-play',
		  pause: '.jp-pause',
		  stop: '.jp-stop',
		  seekBar: '.jp-seek-bar',
		  playBar: '.jp-play-bar',
		  mute: '.jp-mute',
		  unmute: '.jp-unmute',
		  volumeBar: '.jp-volume-bar',
		  volumeBarValue: '.jp-volume-bar-value',
		  volumeMax: '.jp-volume-max',
		  currentTime: '.jp-current-time',
		  duration: '.jp-duration',
		  fullScreen: '.jp-full-screen',
		  restoreScreen: '.jp-restore-screen',
		  repeat: '.jp-repeat',
		  repeatOff: '.jp-repeat-off',
		  gui: '.jp-gui',
		  noSolution: '.jp-no-solution'
		 },
		errorAlerts: true,
		warningAlerts: true
	});


	
});*/


//<![CDATA[
/*$(document).ready(function(){

	var stream = {
		title: "ABC Jazz",
		mp3: "http://listen.radionomy.com/abc-jazz"
	},
	ready = false;

	$("#jquery_jplayer_1").jPlayer({
		ready: function (event) {
			ready = true;
			$(this).jPlayer("setMedia", stream);
		},
		pause: function() {
			$(this).jPlayer("clearMedia");
		},
		error: function(event) {
			if(ready && event.jPlayer.error.type === $.jPlayer.error.URL_NOT_SET) {
				// Setup the media stream again and play it.
				$(this).jPlayer("setMedia", stream).jPlayer("play");
			}
		},
		swfPath: "<?php echo base_url('/');?>js/jplayer/",
		supplied: "mp3",
		preload: "none",
		wmode: "window",
		keyEnabled: true
		//errorAlerts: true,
		//warningAlerts: true
	});


	//$("#footer").jPlayerInspector({jPlayer:$("#jquery_jplayer_1")});
});*/
//]]>

</script>

</body>
</html>