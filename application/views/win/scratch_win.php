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
	<title><?php if(isset($title)){echo $title;}else{ echo 'DTS Volleyball For All - My Namibia &trade;';}?></title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
	<meta name="author" content="My Namibia">
	<meta content="yes" name="apple-mobile-web-app-capable" />
 	<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
	<link rel="stylesheet" href="<?php echo S3_URL;?>scratch_card/volleyball/css/bootstrap.min.css">
	
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">


    <style type="text/css">
	    
		form input[type=text],form input[type=password],form input[type=tel],form input[type=email] {height:50px;font-size:20px; line-height:50px}
		.big_btn{padding:30px 100px; font-size:2em}
	
		.white_content_box {
			background-color:rgba(255,255,255,0.7);
			padding:10px;
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
	  html,
      body {
        height: 100%;
		margin: 0 auto -550px;
			background-color: #FF9F01;

	
        /* The html and body elements cannot have any padding or margin. */
      }
		 #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
		
        /* Negative indent footer by it's height */
            
			  }
		
		.done_scratch { position: absolute; bottom: 23px; left: 50px; }
</style>

<!--[if IE]>
<style type="text/css">	
.card {
  position:relative;
  cursor: crosshair;
  cursor: url(<?php echoS3_URL;?>scratch_card/images/cursor.cur),default;
}
</style>
<![endif]-->
 	<!-- js -->
    <script type="text/javascript" src="<?php echo S3_URL;?>scratch_card/js/jquery_1.7.1.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>
<?php if(isset($rep_id)){ $rep_id = $rep_id;}else{ $rep_id = 0;} ?>
 
</head>
<body>


    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
    	<a href="<?php echo site_url('/');?>volleyball/"><img src="<?php echo S3_URL;?>scratch_card/expo2013/images/refresh.png" style="position:fixed; right:20px; top:20px" /></a>
        <img src="<?php echo S3_URL;?>scratch_card/expo2013/images/keyboard_close.png" class="hide" id="close_key" style="position:fixed; right:40px; top:20px; cursor:pointer" />
  
		<div class="container">
         	<div class="clearfix" style="height:20px;"></div>
		 		<div class="row">
				   

         		</div>
       </div>

      <!-- Begin game content -->
      <div id="game_stp1" class="container">
            <div class="row-fluid">

              	  <div class="span12 text-center">
                     <img src="<?php echo S3_URL;?>scratch_card/volleyball/images/front_dts.jpg" style="margin-top:-20px" />
                  </div> 
           </div>    	
            <div class="row-fluid">

              	  <div class="span6 text-center"  style="margin-top:10px">
                     <div class="clearfix"></div>
                      <a class="btn  btn-inverse btn-block btn-large" id="btn_login"> Login</a>  
                  </div>
               
              	  <div class="span6 text-center"  style="margin-top:10px">
                     <div class="clearfix"></div>
                      <a class="btn  btn-inverse btn-block btn-large" id="btn_register"> Register</a> 
                  </div> 
           </div>
     </div>
     <!-- end game -->



      <!-- Begin login -->
      <div id="game_stp2" class="container hide">
    	
            <div class="row-fluid">
          
                   <div class="span3">
                     
                   </div>  
                   <div class="span6 text-center">
                   
                 		<?php $this->load->view('expo/login');?>
        
                   </div>
               
                   <div class="span3">
                     
                   </div>  
               
           </div>
     </div>
     <!-- end game -->


      <!-- Begin register -->
      <div id="game_stp3" class="container hide">
    	
           <div class="row-fluid">
          
                   <div class="span3">
                     
                   </div>  
                   <div class="span6 text-center" id="reg_form">
                   		
                 		<?php 
						
						$reg_data['rep_id'] = $rep_id;
						$this->load->view('win/register' , $reg_data);?>
        
                   </div>
               
                   <div class="span3">
                     
                   </div>  
               
           </div>
     </div>
     <!-- end game -->




      <!-- Begin game content -->
      <div id="game_stp4" class="container hide">
    	
            <div class="row-fluid">
          
                   <div class="span1">
                    
                  </div>
                   <div class="span10">
                   <img src="<?php echo S3_URL;?>scratch_card/expo2013/images/play.png" />
                     
                       <div id="admin_content" style="width:100%; min-height:300px">

                          <div id="scratch_content" style="width:100%" class="loading_img">
                           <img src="<?php echo S3_URL;?>scratch_card/expo2013/scratch_front_expo.png" style="width:100%" rel="tooltip" title="Play Scratch and win"/> 
                          </div> 

                       </div>
                       <div class="clearfix"></div>
               		  <!-- <img src="<?php echo S3_URL;?>scratch_card/expo2013/expo_logo.jpg"/>
                       <a href="#" id="play" class="btn btn-large btn-block btn-inverse"><i class="icon-play icon-white"></i> Scratch Now</a> --> 	
                   <div class="span1">
                     
                  </div>  
               
           </div>
           <div class="row-fluid">

              	  <div class="span12 text-center"  style="margin-top:10px">
                   <img src="<?php echo S3_URL;?>scratch_card/volleyball/images/won_prize.png" />
                  </div> 
           </div>
     </div>
     <!-- end game -->
     
     <div class="clearfix" style="height:80px;"></div>
	 </div> 
     <!-- /container - end content --> 
		
      <div id="push"></div>
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
 //$this->load->view('inc/footer', $footer);
 ?>  

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script> 


<script type="text/javascript">

var base =  "<?php echo site_url('/');?>", step1 = $("#game_stp1"), step2 = $("#game_stp2"),step3 = $("#game_stp3"),step4 = $("#game_stp4"), close_key =$('#close_key');



$(document).ready(function() {
  	
		  var loading = $('#scratch_content');	
		  loading.empty();
		  $.ajax({
				type: "post",
				cache: false,
				
				url: "<?php echo site_url('/');?>volleyball/load_game/<?php echo $promo_id;?>",
				success: function(data) {
				  $('#modal-play').modal('hide');      
				  loading.removeClass('loading_img');
				  loading.html(data);
				  
				  
				}
		  });
			

			
/*			$('body').keyboard({keyboard: 'qwerty', plugin: 'form'});
				$('input').bind('change', function() {
					$('body').keyboard('keyboard', $(this).val());
					close_key.removeClass('hide');
					
			});*/
		

});


$("#btn_login").bind("click touch", function(){ 
	
	step1.hide();
	step2.slideDown('fast');

});


$("#btn_register").bind("click touch", function(){ 
	
			step1.hide();
			step3.slideDown('fast');
});

$(".but_back").bind("click touch", function(){ 
	
			step3.hide();
			step2.hide();
			step1.slideDown('fast');
});


$("#btn_sign_in").bind("click touch", function(e){ 
	
	$(this).html('Working...');
	e.preventDefault();
	var frm = $('#form-signin');
	$.ajax({
			  type: "post",
			  cache: false,
			  data: frm.serialize(),
			  url: "<?php echo site_url('/');?>volleyball/login/",
			  success: function(data) {
					$("#btn_sign_in").html('Sign in');
					$('#login_msg').html(data);
			  }
	});
	
});

close_key.bind('click', function(){
	
	$(".keyboard > ul").slideDown();	
	close_key.addClass('hide');
});




 function testCanvas() {
        return !!document.createElement('canvas').getContext;
    };

function pass_update(){
			 
		 	$('#pass_update').slideToggle();
		 
		}
	
</script>

</body>
</html>