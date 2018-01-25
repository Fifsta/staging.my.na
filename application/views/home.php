<?php 

$this->load->view('inc/header');

?>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
	<div class="container">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="#">Home</a></li>
		    <li class="breadcrumb-item"><a href="#">Library</a></li>
		    <li class="breadcrumb-item active" aria-current="page">Data</li>
		  </ol>
	</div>
</nav>
<div class="container-fluid">

	<div class="row">

		<div class="col-sm-4 col-md-4 col-lg-2 order-md-2 order-sm-1 order-lg-2" id="sidebar">
	    
			
			<?php $this->load->view('inc/weather');?>
			
			<?php $this->load->view('inc/adverts');?>

		</div>

		<div class="col-sm-8 col-md-8 col-lg-10 order-md-1 order-sm-2">

 			<?php $this->load->view('inc/business');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/near_you');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/categories');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/classifieds');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/map');?>
			<div class="spacer"></div>
			<?php $prop['type'] = '3408'; $this->load->view('inc/products', $prop);?>
			<div class="spacer"></div>
			<?php $cars['type'] = '348'; $this->load->view('inc/products', $cars);?>
			<div class="spacer"></div>
			<?php //$this->load->view('inc/deals');?>
			<div class="spacer"></div>
			<?php $this->load->view('inc/auctions');?>
			<div class="spacer"></div>
			<?php //$this->load->view('inc/news');?>	
			<div class="spacer"></div>	
			<?php //$this->load->view('inc/trending');?>
			<div class="spacer"></div>

		</div>

	</div>	
	
</div>
	
<?php $this->load->view('inc/footer');?>	

	<script type="text/javascript">
		$(document).ready(function(){

			$.ajax({
	            url: '<?php echo site_url('/');?>classifieds/get_latest/',
	            success: function(data) {
					var pre = $("#classifieds_content");
	                pre.removeClass('loading_img min400');
	                pre.append(data);
	                
	            }
	        });


			$('.owl-carousel').owlCarousel({
			    loop:true,
			    margin:10,
			    nav: true,
			    navText : ["<button class='btn owl-prev-next-button previous'></button>","<button class='btn owl-prev-next-button next'></button>"],
			    responsiveClass:true,
			    responsive:{
			        0:{
			            items:1,
			            nav:true
			        },
			        600:{
			            items:3,
			            nav:true
			        },
			        1000:{
			            items:4,
			            nav:true,
			            loop:false
			        }
			    }
			});

			
			get_wethear('na','windhoek');
			//THUMBS
			$('figure .cycle-slideshow').cycle('pause');
			$('figure .cycle-slideshow').mouseenter(function() {
				$(this).cycle('resume').cycle('goto',0);
				$('.reveal', this).each(function() {
					var reveal = $(this).attr('data-src');
					$(this).fadeIn(500).attr('src',reveal);
				});
			}).mouseleave(function() {
				var shown = $('.shown', this).attr('src');
				$(this).cycle('pause').cycle('goto',0);
				$('.reveal', this).each(function() {
					$(this).stop().fadeOut(200).attr('src',shown);
				});
			});
			
		});
	
		//RESOLUTION
		function windowResize(){
			windowWidth = $(window).width();
			windowHeight = $(window).height();
			$('#resolution').text(windowWidth+' x '+windowHeight);
		};
		$(window).resize(windowResize);
		
		//PRELOAD
		window.onload = showBody;
		function showBody(){
			windowResize();
			swipeHeight();
			$('#pre_load').fadeOut();
		}
		
		
		function get_wethear(cunt,city){
	
			$.getJSON( "<?php echo HUB_URL;?>weather/display_block/"+cunt+"/"+city, function( data ) {
	
				if(data.success){
	
					$('#weather_cont').html(data.html);
					$('.city-weather').unbind('click').bind('click', function(e){
						var city = $(this).data('location');
						//console.log(city);
						get_wethear('na', city);
					});
				}
	
			});
	
		}

	
	</script>


</body>
</html>