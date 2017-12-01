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
 if(isset($page_id)){
 $data['page_id'] = $page_id;
 }else{
	$data['page_id'] = ''; 
 }

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
               <?php $this->load->view('admin/inc/'.$content, $data);?>
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
    <a onClick="$('#modal-page-delete').modal('hide');" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Delete Page</a>
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
    <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 

    
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
	 
	}
);
function delete_page(id){
	  
	$('#modal-page-delete').bind('show', function() {
		//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				$.ajax({
				  url: "<?php echo site_url('/');?>my_admin/delete_page/"+id+"/",
				  success: function(data) {
					
					$('#msg').html(data);
					$('#modal-page-delete').modal('hide');
					
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
		
		window.location = '<?php echo site_url('/');?>my_admin/home/'+str;
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
					
					$('#msg').html(data);
					$('#modal-cat-delete').modal('hide');
				  }
				});
				
			});
	}).modal({ backdrop: true });
}




</script>

</body>
</html>