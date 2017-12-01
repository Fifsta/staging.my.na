  <?php 
 //+++++++++++++++++
 //My.Na Main Header
 //+++++++++++++++++
 //Roland Ihms
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title><?php if(isset($title)){echo $title;}else{ echo 'My Namibia &trade;';}?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="<?php if(isset($metaD)){echo $metaD;}else{ echo 'My Namibia - Scratch &amp; Win';}?>">
	<meta name="author" content="My Namibia">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css">
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">
	<link href='//fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
    <!-- Scratch Card depends on jquery 1.7 -->
 	<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
    
    <style type="text/css">
	
		.white_content_box {
			background-color:rgba(255,255,255,0.7);
		}
		
		.hidden {
			display: none;
		}
		
		.shadow1light {
			-webkit-box-shadow: 1px 1px 2px #222;
			-moz-box-shadow: 1px 1px 2px #222;
			box-shadow: 1px 1px 2px #222;
		}
		
		.card_border {
			border: 2px solid yellow;
		}
		
		.card {
			position:relative;
			cursor: crosshair;
			
			cursor: url(<?php echo S3_URL;?>scratch_card/images/cursor.png) 25 25, crosshair;
		}
		
		
		
		.done_scratch { position: absolute; bottom: 23px; left: 50px; }
</style>

<!--[if IE]>
<style type="text/css">	
.card {
  position:relative;
  cursor: crosshair;
  cursor: url(<?php echo S3_URL;?>scratch_card/images/cursor.cur),default;
}
</style>
<![endif]-->
 	<!-- js -->
    <script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/jquery_1.7.1.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url('/');?>js/jquery.lazyload.min.js"></script>

<style type="text/css">

 .vertical .carousel-inner {
  height: 100%;
}

.carousel.vertical .item {
  -webkit-transition: 0.6s ease-in-out top;
     -moz-transition: 0.6s ease-in-out top;
      -ms-transition: 0.6s ease-in-out top;
       -o-transition: 0.6s ease-in-out top;
          transition: 0.6s ease-in-out top;
}

.carousel.vertical .active {
  top: 0;
}

.carousel.vertical .next {
  top: 100%;
}

.carousel.vertical .prev {
  top: -100%;
}

.carousel.vertical .next.left,
.carousel.vertical .prev.right {
  top: 0;
}

.carousel.vertical .active.left {
  top: -100%;
}

.carousel.vertical .active.right {
  top: 100%;
}

.carousel.vertical .item {
    left: 0;
}​
 
 </style>  
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $subnav['subsection'] = 'scratch';
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 ?>

    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
		<div class="container">
         	<div class="clearfix hidden-phone" style="height:100px;"></div>
		 		<div class="row" id="members_search">
				<?php 
                 //+++++++++++++++++
                 //LOAD HOME SEARCH BOX
                 //+++++++++++++++++
                 
                 //$this->load->view('inc/home_search');
                 ?>

         		</div>
       </div>

      <!-- Begin page content -->
      <div class="container white_box padding10">
      
	  <div class="row">

        <div class="span12">
            <div class="na_points"></div>
          <img src="<?php echo $this->my_na_model->get_user_avatar_str('60','60');?>" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid pull-left" /> 	
          <h3><?php echo $this->session->userdata('u_name');?></h3><?php echo date('l F jS');?>
          <div class="clearfix" style="height:10px"></div> 
             <ul class="breadcrumb">
              <li><a href="<?php echo  site_url('/');?>members/home">My Account</a> <span class="divider">/</span></li>
              <li>Scratch &amp; Win<span class="divider">/</span></li>
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
                    
                    <li <?php if ($subnav['subsection'] == 'scratch') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>win/scratch_and_win/"><i class="icon-barcode"></i> Scratch &amp; Win</a></li>
                   <li class="msgs"><a href="#enquiries"  onClick="load_ajax('msgs')" data-toggle="tab"><div class="notification_member_msg_count">
                    <?php $this->my_na_model->msg_notifications_member();?></div>
                    <i class="icon-envelope"></i> Messages</a></li>
                    <li id="news_btn" class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i> My News <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="nav-header">My News</li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'top')">News of the World</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'politics')">Politics</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'business')">Business</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'health')">Health</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'sport')">Sports News</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'africa')">African News</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'afrikaans')">Afrikaans News</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'german')">German News</a></li>
                          <li><a href="javascript:void(0)" onclick="load_news(0, 6,'environmental')">Environmental News</a></li>
                      </ul>
                    </li>
                     <li id="sport_btn" class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-star-empty"></i> My Sports <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li class="nav-header">My Sports</li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'premier_league')">Premier League</a></li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'rugby')">Rugby</a></li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'super_rugby')">Super Rugby</a></li>
                          <li><a href="javascript:void(0)" onClick="load_sky_news(0, 8,'formula1')">Formula 1</a></li>
                      </ul>
                    </li>
                    <li class="entertainment_btn"><a href="javascript:void(0)" onClick="load_entertainment(0, 8 , 'all')"><i class="icon-star"></i> Entertainment</a></li>
                    <li class="deals"><a href="javascript:void(0)" onclick="load_deals(0, 10 , 'all')"><i class="icon-certificate"></i> My Deals</a></li>
                    <li class="trade"><a href="javascript:void(0)" class="disabled" onclick="soon()"><i class="icon-shopping-cart"></i> Buy/Sell</a></li>
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
      
     	   <!-- <iframe src="http://my.na/clients/shellscratchcard/" allowtransparency="true" frameborder="0" style="margin-left:20px" width="1130" height="900"></iframe>-->
           <div class="span3">
         <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 
				 $this->load->view('members/inc/account_nav', $subnav);
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
             ?>
           </div>
       
           <div class="span9">
           
              
           
              <div id="admin_content" style="width:100%; min-height:300px">
             	  <div id="msg"></div>
                  <h3>Play Scratch &amp; Win<small> My Namibia &trade;</small></h3>
                  
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
                    <div class="row-fluid">
                        <div class="span12">
                        
                            <div class="alert alert-block">
                              <button type="button" class="close" data-dismiss="alert">&times;</button>
                              <h4>How to Play?</h4>
                              Move your mouse over the scratchable area. Click while moving the mouse over the area you want to scratch. Match three images to WIN!<br />Terms and Conditions Appy
                            </div>
                        
                        </div>
                    </div>
                    <div class="row-fluid">    
                        <div class="span4">
                        <?php $this->scratch_model->get_prize_slider();?>
                         
                        </div>
                        
                        <div class="span8">

                    	  <div id="scratch_content" style="min-height:300px;width:100%" class="loading_img">
                           <img src="<?php echo base_url('/');?>img/bground/scratch_win.png" rel="tooltip" title="Play Scratch and win" /> <br /><br />
                            <a onClick="" class="btn btn-large pull-right" id="play"><i class="icon-play"></i> Scratch Now</a>
                           <?php //$this->load->view('members/inc/scratch_win_inc');?>
                           </div> 
                        </div>
                         
                    </div>
                       
                  
                  	
                  
              </div>
          </div>  
           
           </div>
      </div>
     	<div class="clearfix" style="height:80px;"></div>
	 
     <!-- /container - end content --> 


 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
    </div>

<div class="modal hide fade" id="modal-play">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Play Scratch and Win</h3>
  </div>
  <div class="modal-body">
    <p><img src="<?php echo base_url('/');?>img/logo_scratch.png" class="pull-right clearfix"/>You are about to play Scratch and Win.<br /> Each game costs 10 points.<br /> 
    By clicking Yes Play you will commit 10 points.</p>
    
    <p>Are you sure you want to play?</p>
    <br />   
   <p style="font-size:10px; font-style:italic" class="clearfix">Brought to you by My Namibia &trade; Scratch and Win. Terms and Conditions Apply.</p>
  </div>
  <div class="modal-footer">
    <a onClick="$('#modal-play').modal('hide');" class="btn">Cancel</a>
    <a href="#" class="btn btn-primary">Yes Play</a>
  </div>
</div>


<div class="modal hide fade" id="modal-win">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="win_msg_head">Congratulations</h3>
  </div>
  <div class="modal-body" >
    <p id="win_msg"></p>
   <img src="<?php echo base_url('/');?>img/logo.png" class="pull-right clearfix"/>
   <p style="font-size:10px; font-style:italic" class="clearfix">Brought to you by My Namibia &trade; Scratch and Win. Terms and Conditions Apply.</p>
  </div>
  <div class="modal-footer">
    <a class="btn">OK, Thanks</a>
    
  </div>
</div>

 <div id="modal-claim" class="modal hide fade">
        <div class="modal-header">
          <a href="javascript:void(0)" onClick="'.$exit_str1.'" class="close">&times;</a>
          <h3>Claim a business listing</h3>
       </div>
       <div class="modal-body loading_img" id="claim_modal" style="overflow:hidden; padding-bottom:50px;width:100%"></div>
       
       <div class="modal-footer">
        <a href="javascript:void(0)" onClick="javascript:$('#modal-claim').modal('hide')" class="btn btn-secondary">Cancel</a>
      </div>
 </div>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/custom/members_home.js"></script>
    <script src="<?php echo base_url('/');?>js/custom/fb.js"></script>
<script type="text/javascript">
var base =  "<?php echo site_url('/');?>";
$(document).ready(function() {
  	
	load_points();
	
			
	$('#prizeCarousel').carousel({
						interval: 3000
	});

});


function load_points(){
	
	var cont = $('.na_points');
	//LOAD POINTS
	cont.addClass('loading');
	$.getScript('<?php echo base_url('/');?>js/jquery.knob.js', function(){do_load()});
	
	
	
}


function do_load(){

		$.ajax({
				  type: "get",
				  cache: false,
				  url: "<?php echo site_url('/');?>win/get_points/<?php echo $this->session->userdata('id');?>",
				  success: function(data) {
					
					$('.na_points').html(data);
					$('.na_points').removeClass('loading');
				  }
			});	
}

$("#play").live("click", function(){ 
     		
		  $('#modal-play').bind('show', function() {
			var removeBtn = $(this).find('.btn-primary');
			
			if (testCanvas()) {
			  
				  removeBtn.unbind('click').click(function(e) { 
					var cct = '<?php echo $this->security->get_csrf_hash(); ?>';
					e.preventDefault();	
					var loading = $('#scratch_content');	
					loading.empty();
					removeBtn.html('Preparing game...');
					$.ajax({
						  type: "post",
						  cache: false,
						  data: {'csrf_token_name': cct},
						  url: "<?php echo site_url('/');?>win/load_scratch_win/",
						  success: function(data) {
							$('#modal-play').modal('hide');
							removeBtn.html('Yes Play'); 
							loading.removeClass('loading_img');
							loading.html(data);
							load_points();
						  }
					});
					
				});
			  
			} else {
			   var content = $(this).find('.modal-body');
			  content.html('Your browser is not supported. Please upgrade to a newer browser to play.');
			  removeBtn.hide();
			   $('#lamebrowser').show(); 
			}
				
			
	}).modal({ backdrop:true });
		   
		    
});

 function testCanvas() {
        return !!document.createElement('canvas').getContext;
    };
	
//function load_ajax(str){
//		
//		window.location = '<?php echo site_url('/');?>members/home/'+str;
//} 

	
</script>

</body>
</html>