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
    <meta name="description" content="<?php if(isset($metaD)){echo $metaD;}else{ echo 'My Namibia - the Free business portal in Namibia';}?>">
	<meta name="author" content="My Namibia">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css">
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
<!--<link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://ebooks.my-child.co.nz/144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://ebooks.my-child.co.nz/114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://ebooks.my-child.co.nz/72.png">
    <link rel="apple-touch-icon-precomposed" href="https://ebooks.my-child.co.nz/57.png">-->
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <!-- Scratch Card depends on jquery 1.7 -->
	
    <link rel="stylesheet" type="text/css" href="<?php echo S3_URL;?>scratch_card/css/style.css" />
 	<!-- js -->
    <script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/jquery_1.7.1.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>

<style type="text/css">
.loading{background:url(<?php echo base_url('/');?>img/load.gif) no-repeat center center;display:inline-block;}
 #loading_img{position:relative;min-height:600px}
 .loading_img{min-height:400px;width:100%;position:relative;top:0;left:0;right:0;bottom:0; z-index: 1040;
  background-color: #FFF;
    opacity: 0.8;
  filter: alpha(opacity=80);}

 
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
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
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
      <div id="container-body" class="container">
      
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
      
     	   <!-- <iframe src="http://my.na/clients/shellscratchcard/" allowtransparency="true" frameborder="0" style="margin-left:20px" width="1130" height="900"></iframe>-->
           <div class="span3">
         <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                 $subnav['subsection'] = 'scratch';
				 $this->load->view('members/inc/account_nav', $subnav);
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
             ?>
           </div>
       
           <div class="span9">
           
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
                              <li class="home <?php if ($subnav['subsection'] == 'myinfo') {  echo 'active'; }?>"><a href="<?php echo site_url('/');?>members/home/"><i class="icon-home"></i> Home</a></li>
                              <li class="general"><a href="javascript:load_ajax('general')"><i class="icon-info-sign"></i> General Info</a></li>
                              <li <?php if ($subnav['subsection'] == 'scratch') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>win/scratch_and_win/"><i class="icon-barcode"></i> Scratch &amp; Win</a></li>
                              <li class="msgs"><a href="javascript:load_ajax('msgs')"><div class="notification_member_msg_count">
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
                              <li class="deals"><a href="javascript:void(0)" onclick="load_deals(0, 10 , 'all')"><i class="icon-certificate"></i> My Deals</a></li>
                              <li class="trade"><a href="javascript:void(0)" class="disabled" onclick="soon()"><i class="icon-shopping-cart"></i> Buy/Sell</a></li>
                            </ul>
                          </div><!-- /.nav-collapse -->
                        </div>
                      </div><!-- /navbar-inner -->
                    </div>
                <div class="clearfix" style="height:20px"></div>  
           
              <div id="loading_img">
             	  <div id="msg"></div>
                  <div id="admin_content">
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
                            <h4>Current Prizes</h4>
                               <div id="prizeCarousel" style="padding:30px 0px 0px 60px;text-align:center; margin-left:auto; margin-right:auto" class="carousel slide vertical">
                        
                                  <!-- Carousel items -->
                                  <div class="carousel-inner" style="text-align:center;height:250px">
                                    <div class="active item" style="text-align:center"><img src="<?php echo S3_URL;?>scratch_card/images/prizes/raw/price_win_shirt_o.png" /></div>
                                    <div class="item" style="text-align:center"><img src="<?php echo S3_URL;?>scratch_card/images/prizes/raw/price_win_coke_o.png" /></div>
                                    <div class="item" style="text-align:center"><img src="<?php echo S3_URL;?>scratch_card/images/prizes/raw/price_win_money_o.png" /></div>
                                  </div>
                                  <!-- Carousel nav -->
                                  <!--<a class="carousel-control left" href="#prizeCarousel" data-slide="prev">&lsaquo;</a>
                                  <a class="carousel-control right" href="#prizeCarousel" data-slide="next">&rsaquo;</a>-->
                                </div>
                            
                             
                            </div>
                            
                            <div class="span8">
    
                               <div id="scratch_content">
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
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      <div id="push"></div>
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
 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/custom/members_home.js"></script>
<script type="text/javascript">

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
		
			removeBtn = $(this).find('.btn-primary');
				
			removeBtn.unbind('click').click(function(e) { 
				e.preventDefault();	
				var loading = $('#loading_img');	
				loading.addClass('loading_img');
				removeBtn.html('Loading...');
				$.ajax({
					  type: "post",
					  cache: false,
					  url: "<?php echo site_url('/');?>win/load_scratch_win/",
					  success: function(data) {
						$('#modal-play').modal('hide');
						removeBtn.html('Yes Play'); 
						loading.removeClass('loading_img');
						$('#scratch_content').html(data);
						load_points();
					  }
				});
				
			});
	}).modal({ backdrop:false });
		   
		    
});


	
function load_ajax(str){
		
		window.location = '<?php echo site_url('/');?>members/home/'+str;
} 

	
</script>

</body>
</html>