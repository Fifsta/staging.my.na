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
 <style type="text/css">
 #loading_img{position:relative;min-height:600px}
 .loading_img{min-height:400px;width:100%;position:relative;top:0;left:0;right:0;bottom:0; z-index: 1040;
  background-color: #FFF;
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
                 $subnav['subsection'] = 'myusers';
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
              <a onClick="add_sys_user()" class="btn pull-right">Add System User</a>
              <?php $this->admin_model->get_sys_users(); ?>
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
    <a onClick="$('#modal-cat-add-main').modal('hide');" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Add category</a>
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
    <a onClick="$('#modal-cat-add-sub').modal('hide');" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Add category</a>
  </div>
</div>

<div class="modal hide fade" id="modal-member-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete System user</h3>
  </div>
  <div class="modal-body">
    Are you sure you want to delete the current System user? This process is not reversible!
  </div>
  <div class="modal-footer">
    <a onClick="$('#modal-member-delete').modal('hide');" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Delete User</a>
  </div>
</div>


<div class="modal hide fade" id="modal-add">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Add System user</h3>
  </div>
  <div class="modal-body">
    <form id="user-add" name="user-add" method="post" action="<?php echo site_url('/');?>my_admin/add_sys_user_do" class="form-horizontal">
    
    <div class="control-group">
          <label class="control-label" for="name">User Name</label>
        <div class="controls">
           <input type="text" id="name" name="name" placeholder="User Name" value="">                    
        </div>
     </div>
      <div class="control-group">
          <label class="control-label" for="position">User Position</label>
        <div class="controls">
          	<select name="position" id="position">
              <option value="Super Admin">Super Admin</option>
              <option value="Tester">Tester - Student</option>
             
            </select>                    
        </div>
     </div>
     <div class="control-group">
          <label class="control-label" for="email">User Email</label>
        <div class="controls">
           <input type="text" id="email" name="email" placeholder="User Email" value="">                    
        </div>
     </div>
     <div class="control-group">
          <label class="control-label" for="userpass">User Password</label>
        <div class="controls">
           <input type="password" id="userpass" name="userpass" placeholder="User Password" value="">                    
        </div>
     </div>  
       
        
    </form>
  </div>
  <div class="modal-footer">
    <a onClick="$('#modal-add').modal('hide');" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Add user</a>
  </div>
</div>


<div class="modal hide fade" id="modal-update">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Update System user</h3>
  </div>
  <div class="modal-body" id="update_content">
	
  </div>
  <div class="modal-footer">
    <a onClick="$('#modal-update').modal('hide');" class="btn">Close</a>
    <a onClick="update_sys_user_do()" class="btn btn-primary">Update user</a>
  </div>
</div>


 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('members/inc/footer_backend', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    
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
$(document).ready(function() {


});

function add_sys_user(){
	
	$('#modal-add').bind('show', function() {
			
			var removeBtn = $(this).find('.btn-primary');
			
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();
				var frm = $('#user-add');
	
				$.ajax({
				  type: "post",
				  data: frm.serialize(),
				  url: "<?php echo site_url('/');?>my_admin/add_sys_user_do",
				  success: function(data) {
					
					$('#msg').html(data);
					$('#modal-add').modal('hide');
					window.location = '<?php echo site_url('/');?>my_admin/sys_users';
				  }
				});
				
			});
	}).modal({ backdrop: true });
	
}			

function update_sys_user(id){
	
	$('#modal-update').bind('show', function() {
			
				$.ajax({
				  type: "get",
				  url: "<?php echo site_url('/');?>my_admin/get_sys_user/"+id,
				  success: function(data) {
					
					$('#update_content').html(data);
				  }
				});
				
		
	}).modal({ backdrop: true });
	
}


function update_sys_user_do(){
	
		  var frm = $('#user-update');

		  $.ajax({
			type: "post",
			data: frm.serialize(),
			url: "<?php echo site_url('/');?>my_admin/update_sys_user_do",
			success: function(data) {
			  
			  $('#msg').html(data);
			  $('#modal-update').modal('hide');
			  window.location = '<?php echo site_url('/');?>my_admin/sys_users';
			}
		  });
		
	
}

function delete_user(id){
	  
	$('#modal-member-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_sys_user/"+id+"/",
				  success: function(data) {
					
					$("#msg_admin").html(data);
					$('#modal-member-delete').modal('hide');
					window.location = '<?php echo site_url('/');?>my_admin/sys_users';
		
				  }
				});
				
			});
	}).modal({ backdrop: true });
}

<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//TIMELINE SCROLL SPY
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
//TimeLine Navigation
//function moveScroller() {
//
//		var move = function() {
//			var st = $(window).scrollTop();
//			var ot = $("#timeline-anchor").offset().top;
//			var s = $("#timeline");
//			if($(window).width() < 770){
//					
//			}else{
//				if(st > ot) {
//					
//					s.css({
//						position: "fixed",
//						top: "80px"
//						
//					});
//				
//					
//				} else {
//					if(st <= ot) {
//						s.css({
//							position: "relative",
//							top: ""
//						});
//					}
//				}
//			}
//    };
//$(window).scroll(move);
//    move();
//}
//
// $(function() {
//    moveScroller();
//    $('[rel=tooltip]').tooltip();
//    
//  });
  	

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




</script>

</body>
</html>