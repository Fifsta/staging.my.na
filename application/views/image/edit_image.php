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

$data['width'] = $width;
$data['height'] = $height;
$data['type'] = $type;
$data['attr'] = $attr;
$data['filename'] = base_url('/').$img;
$data['img'] = $img;
$data['url'] = $url;
$data['image'] = $_SERVER['DOCUMENT_ROOT'] . '/'.$img;
		
							
		
 ?>

</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 
   //+++++++++++++++++
   //My.Na Update Image
   //+++++++++++++++++
   //Roland Ihms
   //Get Business Details

	?>	
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
    <div id="results-top"></div> 
		<div class="container" id="home_container">
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
      <div class="white_box padding10">
      
	   <div class="row-fluid">
      	
        <div class="span12">

          <img src="<?php echo $this->my_na_model->get_user_avatar_str('60','60');?>" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid pull-left" /> 	
          <h3><?php echo $this->session->userdata('u_name');?></h3><?php echo date('l F jS');?>
          <div class="clearfix" style="height:10px"></div> 
             <ul class="breadcrumb">
              <li><a href="#">My Account</a> <span class="divider">/</span></li>
              <li><a href="#">Update Image</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
       	
      <div class="row-fluid">
      
		 		<ul class="nav nav-tabs" id="myTab">
                      <li class="active"><a href="#crop" data-toggle="tab">Crop Photo</a></li>
                      <li><a href="#rotate" data-toggle="tab">Rotate Photo</a></li>
                      <li><a href="#effects" data-toggle="tab">Photo effects</a></li>
        
                </ul>
                 
                <div class="tab-content">
                  
                    <div class="tab-pane active" id="crop"><?php $this->load->view('image/crop_cover', $data);?></div>
      				<div class="tab-pane" id="rotate"><?php $this->load->view('image/image_rotation', $data);?></div>
     				<div class="tab-pane" id="effects">
                    	<div class="alert alert-block">
                        	<h3>Coming Soon</h3>
                    		Add some personality to your photos by adding great image effects and filters right from your my.na dashboard.
                            come back soon.
                            </div>
                    </div>
       		   
               </div>
       
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      <div id="push"></div>
    </div>
   </div> 
 <?php /**
++++++++++++++++++++++++++++++++++++++++++++
//DELETE IMAGE MODAL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 
<div class="modal hide fade" id="modal-delete">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Delete Messages</h3>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to completely remove the selected messages?</p>
  </div>
  <div class="modal-footer">
    <a href="javascript:$('#modal-delete').modal('hide');" class="btn">Close</a>
    <a href="#" class="btn btn-primary">Remove</a>
  </div>
</div>
 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 //$this->load->view('inc/footer', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript">
<?php 


  /**
++++++++++++++++++++++++++++++++++++++++++++
//FIRE EDITOR
++++++++++++++++++++++++++++++++++++++++++++	
 */
   
 ?>
  
$(document).ready(

	

);



</script>

</body>
</html>