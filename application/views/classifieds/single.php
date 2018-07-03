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

</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
	<div class="container">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="<?php echo site_url('/');?>">My</a></li>
		    <li class="breadcrumb-item"><a href="<?php echo site_url('/');?>classifieds/">Calssifieds</a></li>
		    <li class="breadcrumb-item active"><?php echo $row->title;?></li>
		  </ol>
	</div>
</nav>

<div class="container">

	<div class="row">

		<div class="col-sm-4 col-md-4 col-lg-3 col-xl-3 order-md-2 order-sm-1 order-lg-3 order-xl-3" id="sidebar">
			<?php $this->load->view('inc/login'); ?>
			<?php $this->load->view('inc/weather'); ?>
			<?php $this->load->view('inc/adverts'); ?>
		</div>

		<div class="col-sm-8 col-md-8 col-lg-9 col-xl-9 order-md-1 order-sm-2">
			<div class="row" style="margin-bottom:50px">
				<div class="col-md-12">

					<?php 

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

					echo '
					<section id="classified_header" style="margin-bottom:10px">
				        <div class="heading">
				        <h2 data-icon="fa-newspaper-o">'.$row->cat_name.' <strong>'.date('jS \of F Y',strtotime($row->listing_date)).'</strong></h2>
				        <p><strong>'.$row->title.'</strong></p>
				        <div class="pull-right" style="padding:4px;"><a onClick="' . $fb . '" class="facebook pull-right"></a>' . anchor_popup('https://twitter.com/share?url=' . trim($tweet_url), ' ', $tweet) . '</div>
			        </section>
					';

					echo ' 
					<figure>
						<div class="col-md-12">
							<div class="">
								'.$b.'
								'.$loc.'
								<div>'.$row->content.'</div>
								<span class="badge badge-dark">'.$row->cat_name. '</span>
								<p class="muted pull-right">'.$row->adbooking_id.'</p>
								<hr>

								<div class="row">
									<div class="col-md-12 text-left">'.$subs.'</div>
								</div>
						   </div>

						</div>   
					</figure>
					';	  

					?>

					<div class="spacer"></div>
					<?php $this->load->view('inc/classifieds'); ?>	
					
				</div>	

			</div>
					
		</div>

	</div>	
	
</div>
	
<?php $this->load->view('inc/footer');?>	
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>

</body>
</html>