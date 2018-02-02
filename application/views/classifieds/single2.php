<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = $row->title.' - My Namibia &trade;';
$header['metaD'] = $this->my_na_model->shorten_string(strip_tags($row->content), 30).'. My Namibia Classifieds - Find What you !na';
$header['section'] = 'careers';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag


?>
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/'); ?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
<style type="text/css">
	/*.product_ribbon_sml{margin-left:-15px}*/
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
                                <a class="label label-warning" href="<?php echo site_url('/');?>classifieds/" itemprop="url"><span itemprop="title">Classifieds</span></a><span class="divider">/</span>
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
					$b = $this->classifieds_model->render_business($row);
					
					$fb = "postToFeed(" . $row->classified_id . ", '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_na_model->shorten_string(strip_tags($this->my_na_model->clean_url_str($row->content, " ", " ")), 50)))) . "', '" . site_url('/') . 'classifieds/view/' . $row->classified_id . '/' . trim($this->my_na_model->clean_url_str($row->title)) . "')";
	
					//$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";
	
					$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
					$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . 'classifieds/view/' . $row->classified_id . '/' .$this->my_na_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
									$loc = '';
					if(is_numeric($row->location_id)){
						
						$loc .= '<p><i class="icon-map-marker"></i><em>'. $row->location;
						
					}else{
						
						$loc .=	'<p><em>';
					}
					
					if($row->BUSINESS_NAME != ''){
						
						$loc .= ' - '.$row->BUSINESS_NAME.'</em></p>';
					}else{
						
						$loc .=  '</em></p>';
					}
					$subs = '';
					//PUBLICATIONS
					if(strlen($row->pubs) > 0){
						
						$pubA = explode(',',$row->pubs);
						foreach($pubA as $prow){
							
								if($prow != 0 || $prow != 1 || $prow != 2){
							
									$subs .= '<img src="'.HUB_URL.'img/publications/'.$prow.'.png" style="width:25px;height:25px; margin:2px" width="25">';
								}
							
						}
						
					}
	
					echo'<div class="row-fluid">
								<div class="span12">
									<div class="product_ribbon_sml"><small>'.$row->cat_name.' &nbsp;</small>'.date('jS \of F Y',strtotime($row->listing_date)).'<span></span></div>
									<div class="white_box padding10">
										
										'.$b.'

										<h2 class="text-right">'.$row->title.' ' .$row->location_id.'</h2>
										
										'.$loc.'
										<div>'.$row->content.'</div>
										<span class="badge badge-inverse">'.$row->cat_name. '</span>
										<p class="muted pull-right">'.$row->adbooking_id.'</p>
										<hr>
										<p>
											<div class="pull-left">'.$subs.'</div>
											<span class="pull-right" style="margin-top:0px">
												<a onClick="' . $fb . '" class="facebook"></a>
												' . anchor_popup('https://twitter.com/share?url=' . trim($tweet_url), ' ', $tweet) . '
											</span>
											&nbsp;
										</p>
								   </div>
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
