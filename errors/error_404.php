 <?php 
 //+++++++++++++++++
 //My.Na Main Header
 //+++++++++++++++++
 //Roland Ihms
  $base = 'https://my.na/NEW/';
  $site = 'https://my.na/';
  $section = '';
 ?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<title>404 Page Not Found</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="oops 404 error">
	<meta name="author" content="My Namibia">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="<?php echo $base;?>css/bootstrap.min.css?v=1">
	<link rel="stylesheet" href="<?php echo $base;?>css/skin1-front.css?v=1">
	<link rel="shortcut icon" href="<?php echo $base;?>favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo $base;?>img/icons/my_na_[144x144].png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo $base;?>img/icons/my_na_[114x114].png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo $base;?>img/icons/my_na_[72x72].png">
    <link rel="apple-touch-icon-precomposed" href="<?php echo $base;?>img/icons/my_na_[57x57].png">
	<link href='//fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo $base;?>js/bootstrap.min.js"></script>
   
</head>
<body>

 <div class="navbar navbar-fixed-top navbar-inverse">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="<?php echo $site;?>"><div class="logo"></div></a>
          <div class="nav-collapse collapse">
           <ul class="nav">
 
            <li><a href="<?php echo $site;?>buy/property/">Property</a></li>
            <li><a href="<?php echo $site;?>buy/car-bikes-and-boats/">Cars</a></li>
             
            <li><a href="<?php echo $site;?>deals/">Deals</a></li>
            <li><a href="http://blog.my.na/">Blog</a></li>
            <li><a href="<?php echo $site;?>members/add_business/">Add Business</a></li>
           </ul>
           
          </div><!--/.nav-collapse -->
          
        </div>
      </div>
    </div>
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
    
      <!-- Begin page content -->
       <div class="container" id="home_container">
		 <div class="row" style="height:auto;">

            		  <div class="clearfix" style="height:80px;"></div>
					  <div style='text-align:center'>
							  <h1 style="font-size:50px;"><span style="font-size:70px;">Ooops</span>, something went wrong</h1>
                              <h2><?php //echo $heading; ?></h2>
							  <p><?php echo $message; ?></p>
								<img src="<?php echo $base;?>img/bground/my-na-700-silver.png" alt='My Namibia'/>
							  <p></p>
					  </div>
         </div>
    
    
     
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>

<div class="container-fluid  footer">
	<div class="clearfix" style="height:30px;">&nbsp;</div>
    <div class="row-fluid">
        <div class="span2">
        	
        </div>
        <div class="span2">
        	<div style="font-size:10em ;margin:60px 0px 0px 0px" class="clearfix na_script">!na</div>
        </div>
        <div class="span4">
                <h4>My Namibia</h4>
                <p>My Namibia also known as MY.NA is an online business and product networking platform for Namibians .
                    Buy and Sell anything Namibian on this site , from , cars and property to any second hand product or service you can think off .
                    List your product , business , service  or Job here for FREE today and get maximum exposure online in Namibia . 
                    Namibian business's  can feature in our state of the art business directory, giving your business the best exposure and visibility online.</p>
        </div>
        <div class="span3">
               
                  <p><a href="https://twitter.com/MyNamibia"><img src="<?php echo $base;?>img/icons/twitter_icon.png" alt="follow us on Twitter" style="border:none" title="Follow My Namibia on Twitter" rel="tooltip" /></a></p>
                  <p><a href="https://www.facebook.com/mynamibia"><img src="<?php echo $base;?>img/icons/facebook_icon.png" alt="Friend us on Facebook" style="border:none" title="My Namibia on Facebook" rel="tooltip" /></a></p>
                  <p><a href="https://www.youtube.com/user/mynamibiatourism"><img src="<?php echo $base;?>img/icons/youtube_icon.png" alt="Subscribe to Our Channel" style="border:none" title="Watch our videos" rel="tooltip" /></a></p>
 
        </div>
        <div class="span2">
        
        </div>
    
    </div>
    <div class="row-fluid">
        <div class="span2">
        
        </div>
        <div class="span3">
 				  <h4>Let us help you find</h4>
                  <a href="<?php echo $site;?>a/d/3/accommodation/namibia/" title="Browse accommodation providers" rel="tooltip"><span style="margin:5px;" class="label">Accommodation in Namibia</span></a>
                  <a href="<?php echo $site;?>a/cat/8/lodge-in-namibia/" title="Find lodges in Namibia" rel="tooltip"><span style="margin:5px;"  class="label">Lodges in Namibia</span></a>
                  <a href="<?php echo $site;?>a/cat/2/backpackers/" title="Looking for Backpackers in Namibia" rel="tooltip"><span style="margin:5px;"  class="label">Backpackers in Namibia</span></a>
                  <a href="<?php echo $site;?>a/d/6/bars-restaurants-and-nightlife/windhoek/" title="What to do in Windhoek" rel="tooltip"><span style="margin:5px;"  class="label">Bars Restaurant Nightlife in Windhoek</span></a> 
                  <a href="<?php echo $site;?>a/d/4/activities-adventures-and-tours/swakopmund/" title="Adveture tours and activities in Swakopmund" rel="tooltip"><span style="margin:5px;"  class="label">Swakopmund activities and adventure tours</span></a> 
                  <a href="<?php echo $site;?>a/cat/5/guest-farm/" title="Guest farms in Namibia" rel="tooltip"><span style="margin:5px;"  class="label">Namibia Guest Farms</span></a>
                  <a href="<?php echo $site;?>a/cat/58/car-rental-and-breakdown/" title="Car rantals and 4x4 Hire Namibia" rel="tooltip"><span style="margin:5px;"  class="label">Car Hire Namibia</span></a>
                  <a href="<?php echo $site;?>a/c/2/flights-and-transport-in-namibia" title="Transport services in Namibia" rel="tooltip"><span style="margin:5px;"  class="label">Transport Services</span></a>
                  <a href="<?php echo $site;?>a/cat/78/emergency-services/" title="Namibian emergency services" rel="tooltip"><span style="margin:5px;"  class="label">Namibia Emergency Services</span></a>
                  <a href="<?php echo $site;?>a/d/6/bars-restaurants-and-nightlife/windhoek" title="Locate restaurants in Windhoek" rel="tooltip"><span style="margin:5px;"  class="label">Restaurants in Windhoek</span></a>
                  <a href="<?php echo $site;?>a/d/6/bars-restaurants-and-nightlife/swakopmund" title="Where to eat in Swakopmund" rel="tooltip"><span style="margin:5px;"  class="label">Restaurants in Swakopmund</span></a>
                      
        </div>
        <div class="span3">
         	<img src="<?php echo $base;?>img/buttons/namibia_deals.png" style="margin:70px 0px 0px 0px" alt="My Namibia Deals"/>
        </div>
        <div class="span2 text-right">
				<div class="clearfix" style="height:60px;"></div>
                <iframe src="//www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fmynamibia&amp;width=270&amp;height=62&amp;show_faces=false&amp;colorscheme=light&amp;stream=false&amp;border_color&amp;header=false&amp;appId=251565804971014" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:230px; height:62px;" allowTransparency="true"></iframe> 
        </div>
        <div class="span2">
        
        </div>
  
    </div>
    

</div>
    <div class="row-fluid" id="disclaimer">
    	<div class="clearfix" style="height:10px;"></div>
        <ul class="nav nav-pills nav-inverse">
          <li class="disabled span2"></li>
          <li class="span2"><a href="<?php echo $site;?>page/terms-and-conditions/">Terms &amp; Conditions</a></li>
          <li class="span2"><a href="mailto:info@my.na?subject=Get in touch">Contact Us</a></li>
          <li class="span2"><a href="<?php echo $site;?>page/terms-and-conditions/">Privacy policy</a></li>
          <li class="span2"><a href="<?php echo $site;?>"><?php echo date('Y');?> &copy; My Namibia &trade;</a></li>
          <li class="disabled span2"></li>
        </ul>
        
    </div>

 </div>

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript">
$('[rel=tooltip]').tooltip();

function load_sub_cats(id){
	 
	$('#pop_cats').html('<div style="text-align:center;padding-top:45%"><img src="<?php echo $base;?>img/load.gif" /><br /><b>Loading...</b></div>');
	$.ajax({
			type: 'get',
			url: '<?php echo $site .'my_na/get_sub_cats/';?>'+id ,
			success: function (data) {
				
				 $('#pop_cats').fadeIn().html(data);
				
				
			}
		});	
	
}

$('#reload_main').live('click',function(){

	$('#pop_cats').html('<div style="text-align:center;padding-top:45%"><img src="<?php echo $base;?>img/load.gif" /><br /><b>Reloading...</b></div>');
	$.ajax({
			type: 'get',
			url: '<?php echo $site.'my_na/reload_main_cats/';?>',
			success: function (data) {
				
				 $('#pop_cats').fadeIn().html(data);
				
				
			}
		});	
});
</script>

</body>
</html>