<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
if(isset($heading)){

	$header['title'] = $heading . ' - My Namibia';
	$header['metaD'] = $heading. '. Find ' . $heading .' online - My Namibia';
	$header['section'] = '';

}else{

	$header['title'] = '';
	$header['metaD'] = '';
	$header['section'] = '';

}
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<style type="text/css">
	.white_box{

		-webkit-transition: margin 100ms ease-in-out;
		-moz-transition: margin 100ms ease-in-out;
		-o-transition: margin 100ms ease-in-out;

	}

	#deal_content  .white_box:hover{

		margin-top:-2px;


		-moz-box-shadow:      0 0 10px #000;
		-webkit-box-shadow:  0 0 10px #000;
		box-shadow:         0 0 10px #000;


	}
	ul.breadcrumb li.current{color:#FFF;text-shadow:none; }

</style>

<link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>css/jquery.countdown.css">
<script type="text/javascript" src="<?php echo base_url('/');?>js/jquery.countdown.min.js"></script>
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
		<div class="clearfix" style="height:20px;"></div>
		<div class="row-fluid">


			<?php
			//+++++++++++++++++
			//LOAD SEARCH BOX
			//+++++++++++++++++

			$this->load->view('deals/inc/deal_search');

			//HEading Box
			?>

		</div>


		<div class="row-fluid">
			<?php
			//+++++++++++++++++
			//LOAD SUB NAV
			//+++++++++++++++++
			//$this->load->view('trade/inc/group_search');

			?>

		</div>



		<div class="row-fluid">
			<?php
			//+++++++++++++++++
			//LOAD SUB CATEGORY NAV
			//+++++++++++++++++

			//echo $this->trade_model->show_popular_cats();
			?>

		</div>


		<div class="clearfix">&nbsp;</div>
		<div class="row-fluid">

			<?php
			/*SIDEBAR
			span 3 for Sidebar content
			*/

			?>
			<div class="span12">
				<ul class="breadcrumb btn-inverse">
					<?php $this->deal_model->show_deals_breadcrumb($cat = '', $location, $key);?>
				</ul>

				<div id="deal_content">
					<?php
					/*Search Results
					Loop through the search results in the query array
					*/

					$this->deal_model->show_deals($query);


					//LOAD PAGINATION
					?>

				</div>

				<?php if(isset($pages)){
					echo $pages ;}
				?>

			</div>



		</div>

		<div id="map_array"></div>
		<?php //LOAD MAP VIEW ?>
		<div class="row" id="map_container" style="display:none;">

			<div class="results_div" style="display:block;position:relative;background:url(<?php echo base_url('/');?>img/loading.gif) no-repeat center center #fff;height:550px;width:100%;max-width:none">
				<div id="map" style="display:block;position:relative;width:100%;height:100%;max-width:none"></div>
			</div>

		</div>

	</div>
	<!-- /container - end content -->
	<div class="clearfix" style="height:100px;"></div>



	<?php
	//+++++++++++++++++
	//LOAD FOOTER
	//+++++++++++++++++
	$footer['foo'] = '';
	$this->load->view('inc/footer', $footer);
	?>
</div>
<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('[rel=tooltip]').tooltip();

	});



	function initiate_slides(){
		// Cycle plugin
		$('.slides').cycle({
			fx:     'fade',
			speed:   400,
			timeout: 200,
		}).cycle("pause");

		// Pause & play on hover
		$('.slideshow-block').hover(function(){

			$(this).find('.slides').addClass('active').cycle('resume');
			$(this).find('.slides li img').each(function (e) {
				$(this).attr('src', $(this).attr('data-original'));
			});

		}, function(){
			$(this).find('.slides').removeClass('active').cycle('pause');
		});

		//$("input .star").rating();					
		$("[rel=tooltip]").tooltip();
		window.setTimeout(initiate_rating, 100);

	}

	function initiate_rating(){

		$.getScript("<?php echo base_url('/')?>js/jquery.rating.pack.js", function(){

			$("input .star").rating();

		});


	}

	function initiate_pagination(){

		//PAGINATION
		$('div.pagination ul li a').bind('click', function(e){

			e.preventDefault();
			var pre = $('#pre_loader');
			pre.removeClass('hidden');
			$('div.pagination ul').find('li.active').removeClass('active');
			$(this).closest( "li" ).addClass('active');
			$.ajax({
				url: $(this).attr('href'),
				success: function(data) {
					pre.addClass('hidden');
					$("#deal_content").append(data);
					//initiate_slides();
				}
			});


		});

	}



	function my_na(id){

		var n = $('#'+id);
		var place = 'left';
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'business/my_na/';?>'+id+'/'+place+'/' ,
			success: function (data) {

				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect(id);
				n.removeClass('loading_img');
			}
		});

	}

	function my_na_yes(id){

		var n = $('#'+id);
		n.find(".my_na").hide();
		n.addClass('loading_img');
		n.popover('destroy');

		var place = 'left';
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'business/my_na_click/';?>'+id+'/'+place+'/' ,
			success: function (data) {

				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect(id);
				n.removeClass('loading_img');
				n.find(".my_na").show();
			}
		});

	}

	function my_na_effect(id){

		$(function() {
			$("#"+id)
				.find("span")
				.hide()
				.end()
				.hover(function() {
					$(this).find("span").stop(true, true).fadeIn();

				}, function(){
					$(this).find("span").stop(true, true).fadeOut();

				});
		});

	}


</script>

</body>
</html>