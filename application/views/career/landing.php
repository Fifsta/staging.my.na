<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = 'Jobs in Namibia - My Namibia &trade;';
$header['metaD'] = 'The biggest career and vacancy platform in Namibia. Find that best next job today. Find What you !na';
$header['section'] = 'home';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>

<link href="<?php echo base_url('/');?>css/flickity.min.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/'); ?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<style type="text/css">
    #news_slide > div.clearfix a{display:none}
	.bottom-black{background-color: white;
box-shadow: inset 0 -180px 50px -50px rgba(0,0,0,0.7) /* IE6-9 */
	}
	.blogo{max-width:80px}
	.vlogo{margin-top:10%}
	.vtitle{margin-top:10%; }
	.vtitle h3{font-size:130%;clear:both; line-height:20px}
	.vtitle p{line-height:10px}
	@media (max-width: 767px) {
		
		.blogo{max-width:50px;}
		.vtitle h3, .vtitle p{padding-right:10px;}
		.vtitle{margin-top:0px;padding-left:25px}
		.vlogo img{ margin-top:0%;}
		.vlogo{margin-top:5%}
	}

</style>
</head>
<body>

<?php
//+++++++++++++++++
//LOAD NAVIGATION
//+++++++++++++++++
$nav['section'] = '';
$this->load->view('inc/navigation', $nav);
?>
<!-- END Navigation -->
<!-- Part 1: Wrap all content here -->
<div id="wrap">

    <!-- Begin page content -->
    <div class="container" id="home_container">
        	<div class="clearfix hidden-phone" style="height:40px;"></div>
       
        	<div class="row-fluid">

                 <h1 class=" text-center"> FIND <?php echo $sub_cat_name;?> <span class="na_script yellow big_icon">Jobs </span> IN <span class="na_script big_icon"><?php echo $location ;?></span></h1>
                 <?php 
                 //+++++++++++++++++
                 //LOAD CAREER SEARCH BOX
                 //+++++++++++++++++
                 
                 $this->load->view('career/inc/filter');
                 //$this->load->view('inc/home_search_bak');
                 //HEading Box
                 ?>
             </div>

            <div class="clearfix hidden-phone" style="height:20px;"></div>
        </div>
        <!-- /container - end content -->
        <div class="container">
        	 <div class="row-fluid">
             	&nbsp;
             </div>
 		     <div class="row-fluid">
                <div class="span6" data-display="0">
                    
					<?php if(isset($html)){ echo $html;}?>
                </div>
                <div class="span6" data-display="0">
                    
					<h3 class="upper na_script">Featured <span class="na_script yellow ">Jobs </span></h3>
                    <p>The best career opportunities are right here. Browse our wide range of jobs and stay updated with the latest jobs currently on offer.</p>
                    <h3 class="upper na_script">Looking for <span class="na_script yellow ">Work? </span></h3>
                    <p>Are you ready to face the working market? Don't worry! With us you need to look no further. With the latest, 
                    hottest vacancies on our our site, you are sure to find your dream job.</p>
                     <h3 class="upper na_script "><span class="na_script yellow">Your</span> CV? </h3>
                    <p>Create an impressive CV online, quick and easy with our ONLINE CV GENERATOR.</p>
                    <p><a href="<?php echo site_url('/');?>vacancy/" class="btn btn-inverse">Get Started Now</a></p>
                </div>
            </div>
    	</div>
        
        <!-- /container - end content -->
        <div class="container">
        	
 		     <div class="row-fluid">
                <div class="span9" data-display="0">
                    
					<?php ?>
                </div>
                <div class="span3 adverts">
                    
					
                </div>
            </div>
    	</div>
        
		<div class="clearfix" style="height:40px;"></div>
        <!-- /container - end content -->
        <div class="container-fluid footer text-center">


            <div class="row-fluid">
                <div class="container-fluid">
                    <ul class="big_nav">
                        <li><a id="pop_cats_bt">Business </a></li>
                        <li><a href="<?php echo site_url('/'); ?>trade/">Buy &amp; Sell </a></li>
                        <li><a href="<?php echo site_url('/'); ?>buy/property/">Property </a></li>
                        <li><a href="<?php echo site_url('/'); ?>deals/">Deals </a></li>
                        <li><a href="<?php echo site_url('/'); ?>buy/car-bikes-and-boats/">Cars &amp; Boats </a></li>
                        <li><a href="<?php echo site_url('/'); ?>map/">Map </a></li>
                        <li><a href="<?php echo site_url('/'); ?>careers/">Jobs </a></li>
                    </ul>
                </div>
            </div>


        </div>

    <div class="clearfix" style="height:40px;"></div>
    <div class="container">

        <div class="row-fluid inview" data-type="job_video" data-display="1">

            <div class="span12">
                <div id="job_video_slide" class="loading_img  min400" ></div>

            </div>

        </div>

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
<!-- /wrap  -->


<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('/');?>js/jquery.inview.js" type="text/javascript"></script>
<script src="<?php echo base_url('/');?>video/video/eh5v.files/html5video/html5ext.js" type="text/javascript"></script>
<script src='<?php echo base_url('/') ?>js/jquery.cycle2.min.js' type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/jquery.flickity.min.js"></script>

<script type="text/javascript">
    var site = '<?php echo site_url('/');?>';
    var base = '<?php echo base_url('/');?>';
    var _throttleTimer = 0,_throttleDelay = 0;
	var category = "<?php if(isset($categories)){echo $categories;}?>";
	var keywords = "<?php if(isset($keywords)){echo $keywords;}?>";
	var adverts = [];
	var agent = '';
    $(document).ready(function () {
        $('[rel=tooltip]').tooltip();

		$('.slider').flickity();

		/*$('#sub_cat_id').select2().on('change', function(e){
			
			console.log(this.value);
				
		});*/        
		
		
		$('.inview').bind('inview', function (event, visible) {
			var type = $(this).data('type');
			var tt = $(this).data('display');
	
			if (visible == true) {
				if(tt == 0){
				}else{
	
					setTimeout(function(){
	
						load_ajax_home(type);
					},500)
					$(this).data('display', 0);
	
				}
	
			} else {
				// element has gone out of viewport
			}
		});
		
		//load_ads('all', 8, 'ad_block_1');
    });

	function load_ajax_home(str){
	
		$.ajax({
				type: 'get',
				url: '<?php echo site_url('/');?>my_na/load_'+str+'_home/',
				success: function (data) {
					
					 $('#'+str+'_slide').html(data).removeClass('loading_img');
					 
					
				}
			});	
	}
	function load_ads(q, l, b){

		$.getJSON( "<?php echo HUB_URL;?>main/get_adverts/"+q+"/"+l+"/?bus_id=<?php echo BUS_ID;?>&keywords="+encodeURI(keywords)+"&category="+encodeURI(category), function( data ) {

			var adb = $('#'+b), xx = 0;
			for(var i = 0; i < data.length; i++) {
				var obj = data[i];
				adb.append(obj.body);
				adverts.push(obj);
				agent = obj.user_agent;
			}

			//MOBILE FIX
			if(agent == 'mobile'){

				for(var ii = 0; ii < data.length; ii++) {
					var obj = data[ii];

					$('#adholder_'+ii).html(obj.body);

				}

			}
			//load_content_ads();
		});


	}
</script>

<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=2"></script>
<script src='<?php echo base_url('/') ?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
</body>
</html>
