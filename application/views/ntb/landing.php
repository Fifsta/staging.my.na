 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $_uname = '';
 if($this->session->userdata('u_name')){ $_uname = ' - '.ucfirst($this->session->userdata('u_name'));}
 $header['title'] = $_uname;
 $header['metaD'] = 'NTB Home feed for '. $_uname;
 $this->load->view('members/inc/header_old', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />  
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
  $subnav['subsection'] = 'myinfo';
 
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
    
      <!-- Begin page content -->
       <div class="container" id="home_container">

		 <div class="row" id="members_search" style="min-height:40px;width:100%">
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
        <a class="start_wiz pull-right" href="javascript:void(0)" onClick="site_wizard()"><i class="icon-question-sign"></i></a>
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
      
      	 <div class="navbar span12">
            <div class="navbar-inner" style="margin:0;padding:0">
              <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </a>
                
                <div class="nav-collapse navbar-responsive-collapse in collapse" style="height: auto;">
                  <ul class="nav">
                    <li class="home <?php if ($subnav['subsection'] == 'myinfo') {  echo 'active'; }?>"><a href="<?php echo site_url('/');?>members/home/"><i class="icon-home"></i> Dashboard</a></li>
                    <!--<li class="general"><a href="javascript:load_ajax('general')"><i class="icon-info-sign"></i> General Info</a></li>-->
                    
                    <li <?php if ($subnav['subsection'] == 'scratch') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>win/scratch_and_win/"><i class="icon-barcode"></i> Scratch &amp; Win</a></li>
                    <li class="msgs"><a href="#enquiries"  onClick="load_ajax('msgs')" data-toggle="tab"><div class="notification_member_msg_count">
                    <?php $this->my_na_model->msg_notifications_member();?></div>
                    <i class="icon-envelope"></i> Messages</a></li>
                    <li id="news_btn" class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i> My News <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="nav-header">My News</li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'top')">News of the World</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'politics')">Politics</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'business')">Business</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'health')">Health</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'sport')">Sports News</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'africa')">African News</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'afrikaans')">Afrikaans News</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'german')">German News</a></li>
                          <li><a href="javascript:void(0)" onClick="load_news(0, 6,'environmental')">Environmental News</a></li>
                         
                      </ul>
                    </li>
                    
                    <li id="sky_news_btn" class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-star-empty"></i> My Sports <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="nav-header">My Sports</li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'premier_league')">Premier League</a></li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'rugby')">Rugby</a></li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'super_rugby')">Super Rugby</a></li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'formula1')">Formula 1</a></li>
                      </ul>
                    </li>
                    <li class="deals"><a href="javascript:void(0)" onClick="load_deals(0, 10 , 'all')"><i class="icon-barcode"></i> My Deals</a></li>
                    <li class="entertainment_btn"><a href="javascript:void(0)" onClick="load_entertainment(0, 8 , 'all')"><i class="icon-star"></i> Entertainment</a></li>
                    <?php if($this->session->userdata('id') == '1806'){ ?>
                    <li id="trade_btn" class="dropdown trade">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-shopping-cart"></i> Buy/Sell <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="nav-header">My Buy and Sell</li>
                          <li><a href="javascript:void(0)" onClick="load_trade('watch_list')">Watchlist</a></li>
                          <li><a href="javascript:void(0)" onClick="load_trade('sell')">Sell an Item</a></li>
                          <li><a href="javascript:void(0)" onClick="load_trade('products')">My Items</a></li>
                         
                         
                      </ul>
                    </li>
                    <?php } ?>
                    <!--<li class="trade"><a href="javascript:void(0)" class="disabled" onClick="soon()"><i class="icon-shopping-cart"></i> Buy/Sell</a></li> -->
                  </ul>
				  <ul class="nav pull-right">
                  	<li><a href="javascript:void(0)" class="disabled" onClick="find_bus()"><i class="icon-search"></i> Find</a></li>
                  </ul>
                </div><!-- /.nav-collapse -->
              </div>
            </div><!-- /navbar-inner -->
          </div>
          <div class="clearfix" style="height:20px"></div> 
      
      </div>
      	
      <div class="row-fluid">
      
       <div class="span3">
            
			<?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                
				 $this->load->view('members/inc/account_nav', $subnav);
				 
				 ?>
             
             <div class="row-fluid clearfix">
                 <?php
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
				//LOAD WEATHER
				$this->load->view('members/inc/weather_inc', $subnav);
             ?>
             </div>
       	 
        </div>
      
      
        <div class="span9">
       			
        	
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
                   
                      <div id="admin_content" style="min-height:300px;width:100%">
                         <img src="<?php echo base_url('/');?>img/icons/ntb-sml.png" class="pull-right clearfix"/>
                         <h3><span class="na_script" style="font-size:25px; line-height:22px;">Dear NTB Member</span></h3>
                         <p>Welcome to your My Namibia personal profile page. As an NTB member you can start administrating your business details from here.</p> 
							
						 <?php
						  //GET ALL BUSINESSES FOR USER
						  $query = $this->members_model->get_businesses($id);
						  if($query != ''){
								
								 echo '<h4><span class="na_script" style="font-size:25px; line-height:22px;">Your Business</span></h4><p>Just click on the business listed below to start managing your business details that are displayed on the NTB website .</p>
									 '; 
								
								foreach($query as $row){
									
									$img = $row['BUSINESS_LOGO_IMAGE_NAME'];
									if($img != ''){
						
										if(strpos($img,'.') == 0){
								
											$format = '.jpg';
											$img_str = base_url('/').'img/timbthumb.php?w=60&h=60&src='.S3_URL.'assets/business/photos/'.$img . $format;
											
										}else{
											
											$img_str =  base_url('/').'img/timbthumb.php?w=60&h=60&src='.S3_URL.'assets/business/photos/'.$img;
											
										}
										
									}else{
										
										$img_str = base_url('/').'img/timbthumb.php?w=60&h=60&src='.base_url('/').'img/bus_blank.png';	
										
									}
									$str = '';
									
									
									echo '<div class="media">
						  				    <div class="well well-mini">
											  <a class="pull-left" href="#" title="'.$row['BUSINESS_NAME'].'" rel="tooltip">
												<span class="avatar-overlay60"></span>
												<img class="media-object" style="border:1px solid #333333;width:60px; margin-right:10px; height:60px" src="'.$img_str.'" >
											  </a>
											  
											  <div class="media-body">
												<h4>'.$row['BUSINESS_NAME'].'</h4>
											  	<div style="margin-bottom:0px;font-size:14px;">'.substr($row['BUSINESS_DESCRIPTION'], 0, 210) .'</div>
											 
											  <div class="clearfix"></div>
											  	<a class="btn btn-inverse pull-right" href="' . site_url('/') .'members/business/' . $row['BUSINESS_ID'] . '/#info/">Update</a>
											  
											  </div>

											  </div>
										  </div>';	
									
									
								}  
							  
						  }else{
							  
								echo '
										<h3><span class="na_script" style="font-size:25px; line-height:22px;">Claim your Business</span></h3>If your business is not listed below please type
										 the business name in the Claim Tab . The business should automatically appear whilst you are typing in the details .
										  Please select the business and fill in the security question , then click on the claim business tab in the right hand corner . 
											You can now login again within 12-24 hours and your business will appear below .
									 
								 <div class="container" style="width:100%; margin-top:20px;">
									<div class="row-fluid">
									   <div class="span12 well well-mini" id="claim_b_ntb">';
										$this->load->view('ntb/inc/business_claim_inc');
							    		
								echo '</div>
									</div>
									<div class="row-fluid">
									  <div class="span12 well well-mini hide" id="add_b_ntb">';
										$this->load->view('ntb/inc/add_business');
								
								echo '</div>		
									</div>
								  </div>
								</div> ';							  
						  }
						  ?>
                  
                      </div>
                      <div id="feed_loader" style="min-height:50px;width:100%;"></div>
                     
                  </div>  

        </div>
       
       
       
      </div>
     </div>	

     <!-- /container - end content --> 


    </div>
	    <div class="clearfix" style="height:40px;"></div>
	    <?php
	    //+++++++++++++++++
	    //LOAD FOOTER
	    //+++++++++++++++++
	    $footer['foo'] = '';
	    $this->load->view('inc/footer', $footer);

	    ?>
 </div>
 
 <div id="modal-claim" class="modal hide fade">
        <div class="modal-header">
          <a href="javascript:void(0)" onClick="'.$exit_str1.'" class="close">&times;</a>
          <h3>Claim a business listing</h3>
       </div>
       <div class="modal-body" >
       		<div id="claim_modal" class="loading_img span5" style="min-height:300px"></div>
       
       </div>
       
       <div class="modal-footer">
        <a href="javascript:void(0)" onClick="javascript:$('#modal-claim').modal('hide')" class="btn btn-secondary">Cancel</a>
      </div>
 </div>
 
  <div id="modal-delete" class="modal hide fade">
        <div class="modal-header">
          <a href="javascript:void(0)"  class="close">&times;</a>
          <h3>Delete Messages</h3>
       </div>
       <div class="modal-body" style="overflow:hidden; padding-bottom:50px;width:100%">
       <p> Are you sure you want to delete the selected messages? This cannot be undone!</p>
       
       </div>
       
       <div class="modal-footer">
        <a href="javascript:void(0)" onClick="javascript:$('#modal-delete').modal('hide')" class="btn btn-secondary">Cancel</a>
        <a href="javascript:void(0)" class="btn btn-primary">Delete</a>
      </div>
 </div>
 


    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
    <script type="text/javascript" src="<?php echo base_url('/');?>js/custom/members_home.js"></script>  
	<script type="text/javascript">
    var base_ =  "<?php echo base_url('/');?>";
    var base =  "<?php echo site_url('/');?>";
    $(document).ready(function(){
        $('[rel=tooltip]').tooltip();
        
        <?php 

         //IF FIRTS LOGIN
         if($this->session->flashdata('first_login')){ ?>
        
            site_wizard();
    
     <?php }?> 
    });
    
    
    
    
    <?php
    
    
    if(isset($redirect) && $redirect != 'message'){
        
    echo "$(function() {
        
            load_ajax('".$redirect."');
        
         });";
        
    }
    if(isset($msg_id)){
        
    echo "$(function() {
        
            load_msg(".$msg_id.",0, 'unread')
        
         });";
        
    }
     
     ?>
    
        
    function switch_claim(){
		
		$('#add_b_ntb').slideToggle();
		$('#claim_b_ntb').slideToggle().delay(220);	
		
	}
    
      
     
        
    </script>

</body>
</html>