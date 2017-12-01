 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $_uname = '';
 if($this->session->userdata('u_name')){ $_uname = ' - '.ucfirst($this->session->userdata('u_name'));}
 $header['title'] = $_uname;
 $header['metaD'] = 'Home feed for '. $_uname;
 $this->load->view('members/inc/header', $header);
 
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

	   <div class="row" id="members_search" style="min-height:40px;">
				<?php 
                 //+++++++++++++++++
                 //LOAD HOME SEARCH BOX
                 //+++++++++++++++++
                 
                 //$this->load->view('inc/home_search');
                 ?>

       </div>
      <!-- Begin page content -->
      <div class=" padding10">
     
	  <div class="row-fluid">
      	
        <div class="span12">
        <a class="start_wiz pull-right" href="javascript:void(0)" onClick="site_wizard()"><i class="icon-question-sign"></i></a>
        <img src="<?php echo $this->my_na_model->get_user_avatar_str('60','60');?>" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid pull-left" /> 	
          <h3 class="upper na_script"><?php echo $this->session->userdata('u_name');?></h3><?php echo date('l F jS');?>
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
                    <?php if($this->session->userdata('id') == '1806' || $this->session->userdata('id') =='1816' || $this->session->userdata('id') == '1512' || $this->session->userdata('id') == '1815'){ ?>
                    <li id="trade_btn" class="dropdown trade">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-shopping-cart"></i> Buy/Sell <b class="caret"></b></a>
                      <ul class="dropdown-menu" style="width:290px;">
                        <li class="nav-header">Selling</li>
                          <li><a href="<?php echo site_url('/').'sell/';?>" >Sell an Item <font style="font-size:10px;"><br> List items you want to sell</font></a></li>
                          <li><a href="<?php echo site_url('/').'sell/my_trade/0/live/';?>">My Items <font style="font-size:10px;"><br> Items you are currently selling</font></a></li>
                          <li><a href="<?php echo site_url('/').'sell/my_trade/0/sold/';?>" >Items I've Sold <font style="font-size:10px;"><br> Find the items you have sold</font></a></li>
                        <li class="nav-header">Buying</li> 
                          <li><a href="<?php echo site_url('/').'sell/my_trade/0/watchlist/';?>">My Watchlist <font style="font-size:10px;"><br> Items you have saved to your watchlist</font></a></li>
                          <li><a href="<?php echo site_url('/').'sell/my_trade/0/bought/';?>" >Items I've Bought <font style="font-size:10px;"><br> View the items you have bought</font></a></li>				 
                          <li><a href="<?php echo site_url('/').'sell/my_trade/';?>"><i class="icon-flag"></i> New Dashboard <font style="font-size:10px;"><br> Check out the new Buy and Sell Dashboard</font></a></li>
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
                      
                      <div class="alert alert-block">
                      	  <button type="button" class="close" data-dismiss="alert">×</button> 
                          <h4><span class="na_script" style="font-size:20px">My Dashboard</span></h4> - Get your dose of daily updates here... 
                          From news and weather , to events ,targeted promotions as well as top saving deals !!!
                      </div>    
                      <div id="admin_content" class="row-fluid" style="min-height:300px;">
                      
                      <?php 
						 //+++++++++++++++++
						 //LOAD MY ACCOUNT SECTION
						 //+++++++++++++++++
						 //$data['id'] = $id;
						 //$this->load->view('members/inc/my_account_home');
						 ?>      
                      </div>
                      <div id="feed_loader" style="min-height:50px;width:100%;"></div>
                     
                  </div>  

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
    <script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>
    <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/');?>js/custom/members_home.js?v2"></script>
    <script src="<?php echo base_url('/');?>js/custom/fb.js?v=2"></script>
	<script type="text/javascript">
    var base_ =  "<?php echo base_url('/');?>";
    var base =  "<?php echo site_url('/');?>";
    $(document).ready(function(){
        $('[rel=tooltip]').tooltip();
        
        <?php 
        //ONLY SHOW NEWS FEED ON HOME PAGE
        if ($subnav['subsection'] == 'myinfo') {  echo '
        
        
        load_home_feed(0);
        
        '; 
        
        }?>
            
        
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
    
        
      
    
      
     
        
    </script>

</body>
</html>