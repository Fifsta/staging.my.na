<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = $row->title.' - My Namibia &trade;';
$header['metaD'] = $this->my_na_model->shorten_string(strip_tags($row->body), 30).'. My Namibia Jobs - Find What you !na';
$header['section'] = 'careers';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/'); ?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<style type="text/css">
	#side_block_1 > aside{ border:1px solid #999;padding:4px; background: #fff; margin-bottom: 15px; text-align: center;}
	#side_block_1 > aside h2{ font-size: 100%; font-family:"Font-Bold"; color:#fff; margin:0; padding: 10px}
	#side_block_1 > aside img{margin:20px 0 px}
    #news_slide > div.clearfix a{display:none}
	.bottom-black{background-color: white;
box-shadow: inset 0 -180px 50px -50px rgba(0,0,0,0.7) /* IE6-9 */
	}
	.blogo{max-width:100px}
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
            <div class="clearfix hidden-phone" style="height:20px;"></div>
       
        </div>

        <!-- /container - end content -->
        <div class="container">
        	 <div class="row-fluid">
             	 <h1><?php echo $row->title;?> <small class="na_script yellow"><?php echo $row->BUSINESS_NAME;?> </small> </h1>
                    <ul class="breadcrumb btn-inverse">
                            <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a class="label label-warning" href="<?php echo site_url('/');?>" itemprop="url"><span itemprop="title">My</span></a><span class="divider">/</span>
                            </li>
                            <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a class="label label-warning" href="<?php echo site_url('/');?>careers/" itemprop="url"><span itemprop="title">Jobs</span></a><span class="divider">/</span>
                            </li>
      <!--                      <li itemscope="" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <a class="label label-warning" href="<?php echo site_url('/');?>careers/?location_id=" itemprop="url"><span itemprop="title">Jobs</span></a><span class="divider">/</span>
                            </li>-->
                            <li itemscope="" class="active current" itemtype="http://data-vocabulary.org/Breadcrumb">
                                <?php echo $row->title;?>
                            </li>
                     </ul>
             </div>
 		     <div class="row-fluid">
                <div class="span9" data-display="0">
                    
					<?php 
					//if(isset($html)){ echo $html;}
					$b = $this->vacancy_model->render_business($row);
					
					$fb = "postToFeed(" . $row->vacancy_id . ", '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_na_model->shorten_string(strip_tags($this->my_na_model->clean_url_str($row->body, " ", " ")), 50)))) . "', '" . site_url('/') . 'careers/job/' . $row->vacancy_id . '/' . trim($this->my_na_model->clean_url_str($row->title)) . "')";
	
					//$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";
	
					$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
					$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->my_na_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
					
	
					echo'<div class="row-fluid">
								<div class="span12 white_box padding10">
									<form action="'.site_url('/').'vacancy/apply_do/" method="post" enctype="multipart/form-data" name="apply" id="apply" class="form-horizontal">
									<input name="vid" type="hidden" value="'.$row->vacancy_id.'">
									<input name="bus_id" type="hidden" value="'.$row->bus_id.'">
									<input name="title" type="hidden" value="'.$row->title.'">
									<input name="ref_no" type="hidden" value="'.$row->ref_no.'">
									'.$b.'
									<h4>'.$row->title.'</h4>
									<p><i class="icon-map-marker"></i><em>'. $row->location.' - '.$row->BUSINESS_NAME.'</em></p>
									<div>'.$row->body.'</div>
									'.$row->sub_cat. ' ' .$row->sub_sub_cat.'
									<hr>
									<div class="text-right" id="app-box">
										'.$this->vacancy_model->check_apply($row->vacancy_id).'

									</div>
									</form>
							   </div>
						  </div>';
						  
					//print_r($row);
					?>
                </div>
                <div class="span3" id="side_block_1">
                    
					
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
		
		$('#apply').on('submit', function (e) {

			e.preventDefault();

			$('#form-submit').html('<img src="<?php echo base_url('/').'img/load_black.gif';?>" /> Working...');


			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/')?>vacancy/apply_do/',
				data: $('#apply').serialize(),
				success: function (data) {

					$('#form-submit').html('Apply');
					$('#app-box').html(data);


				}
			});


		});
		load_yzx('all', 4, 'side_block_1');
    });

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
