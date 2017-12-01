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
	<meta content="yes" name="apple-mobile-web-app-capable" />
 	<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
	<link rel="stylesheet" href="<?php echo base_url('/');?>scratch_card/expo2013/css/bootstrap.min.css">
	
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">
	<!--<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
    <!-- Scratch Card depends on jquery 1.7 -->
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
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
			
			cursor: url(<?php echo base_url('/');?>scratch_card/images/cursor.png) 25 25, crosshair;
		}
	  html,
      body {
        height: 100%;
		margin: 0 auto -550px;
			background-color: #FF9F01;
			background-image: -moz-linear-gradient(#FF9F01, #FC6002);
			background-image: -webkit-gradient(linear, left top, left bottom, from(#FF9F01), to(#FC6002));    
			background-image: -webkit-linear-gradient(#FF9F01, #FC6002);
			background-image: -o-linear-gradient(#FF9F01, #FC6002);
			background-image: -ms-linear-gradient(#FF9F01, #FC6002);
			background-image: linear-gradient(#FF9F01, #FC6002);   
	
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
  cursor: url(<?php echo base_url('/');?>scratch_card/images/cursor.cur),default;
}
</style>
<![endif]-->
 	<!-- js -->

    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script>
<?php if(isset($rep_id)){ $rep_id = $rep_id;}else{ $rep_id = 0;} ?>
 
</head>
<body>


    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
    	
       <img src="<?php echo base_url('/');?>scratch_card/expo2013/images/cymot.png" style="position:fixed; right:10px; bottom:10px" />
		<div class="container">
         	<div class="clearfix" style="height:20px;"></div>
		 		<div class="row text-center">
				   <div id="spinner">
                   		 <h1 style="font-size:90px;line-height:120px;margin-top:50px">Choosing Winner</h1>
                  		 <img src="<?php echo base_url('/');?>scratch_card/expo2013/images/loader.gif" style="" />
				   </div>
                   
                   <div id="result" class="hide">
                   	
                    	<h1 style="font-size:90px;line-height:120px;margin-top:150px">Congratulations<br /><?php echo ucwords($CLIENT_NAME) . ' ' . ucwords($CLIENT_SURNAME) . '<br />'.$CLIENT_CELLPHONE;?></h1>
                   	</div>
                    
                 </div>
                   
                   
         		</div>
       </div>
	 </div> 
     <!-- /container - end content --> 

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



<script type="text/javascript">

var base =  "<?php echo site_url('/');?>", step1 = $("#game_stp1"), step2 = $("#game_stp2"),step3 = $("#game_stp3"),step4 = $("#game_stp4"), close_key =$('#close_key');

 var spinner = $('#spinner'), winner = $('#result');	

$(document).ready(function() {
  	
		 
		 setTimeout(show_wimnner , 10000);

});

function show_wimnner(){
	
	spinner.fadeOut();
	winner.fadeIn();
	
}

</script>

</body>
</html>