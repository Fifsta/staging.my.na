<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] =  $cat_name.' Classifieds in '.$location.' - My Namibia &trade;';
$header['metaD'] =  $cat_name.' Classifieds in '.$location.'. The biggest career and vacancy platform in Namibia. Find that best next ' .$cat_name.' Classifieds in '.$location.' today. Find What you !na';
$header['section'] = 'home';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/'); ?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<style type="text/css">

	.product_ribbon_sml,.facebook,.twitter{z-index:1 !important}
	.twitter-typeahead,.tt-dataset-business{z-index:1099}
	#side_block_1 > aside{ border:1px solid #999;padding:4px; background: #fff; margin-bottom: 15px; text-align: center;}
	#side_block_1 > aside h2{ font-size: 100%; font-family:"Font-Bold"; color:#fff; margin:0; padding: 10px}
	#side_block_1 > aside img{margin:20px 0 px}
    #news_slide > div.clearfix a{display:none}
	.bottom-black{background-color: white;
box-shadow: inset 0 -180px 50px -50px rgba(0,0,0,0.7) /* IE6-9 */
	}
	.blogo{max-width:70px;}
	.vlogo{margin-top:10%}
	.vtitle{margin-top:10%; }
	.vtitle h3{font-size:130%;clear:both; line-height:20px;margin-left:10px}
	.vtitle p,.vtitle em{line-height:10px;margin-left:10px}
	@media (min-width: 768px) and (max-width: 979px) {
		.vtitle h3,.vtitle p{display:none}
	}
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

                 <h1 class=" text-center"> FIND <?php echo $cat_name;?> <span class="na_script yellow big_icon">Classifieds </span> IN <span class="na_script big_icon"><?php echo $location ;?></span></h1>
                 <?php 
                 //+++++++++++++++++
                 //LOAD CAREER SEARCH BOX
                 //+++++++++++++++++
                 
                 $this->load->view('classifieds/inc/filter');
                 //$this->load->view('inc/home_search_bak');
                 //HEading Box
                 ?>
             </div>

            <div class="clearfix hidden-phone" style="height:20px;"></div>
        </div>

        <!-- /container - end content -->
        <div class="container-fluid">
        	 <div class="row-fluid">
             	&nbsp;
             </div>
 		     <div class="row-fluid">
                <div class="span10" data-display="0">
                    
					<?php if(isset($html)){ echo $html;}
					
						echo $pages;	
					?>
                </div>
                <div class="span2 adverts" id="side_block_1">
                    
					
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

		/*$('#sub_cat_id').select2().on('change', function(e){
			
			console.log(this.value);
				
		});*/        

   		load_yzx('all', 8, 'side_block_1');
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
	function load_yzx(q, l, b){

		$.getJSON( "<?php echo HUB_URL;?>main/get_adverts/"+q+"/"+l+"/?bus_id=0<?php //echo BUS_ID;?>&keywords="+encodeURI(keywords)+"&category="+encodeURI(category), function( data ) {

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
