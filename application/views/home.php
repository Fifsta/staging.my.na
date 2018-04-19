<?php $this->load->view('inc/header'); ?>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
	<div class="container">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="#">My.na</a></li>
		  </ol>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-3" id="sidebar">
			<?php $this->load->view('inc/login'); ?>
		
			<?php $this->load->view('inc/adverts'); ?>
		</div>

		<div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">
			<div class="row">
				<div class="col-md-12">

					<?php $this->load->view('inc/banners');?>

					  <div class="btn-group" role="group" aria-label="First group">
					    <button type="button" class="btn btn-dark"><i class="fa fa-briefcase"></i> Business Directory</button>
					    <button type="button" class="btn btn-dark"><i class="fa fa-newspaper-o"></i> Classifieds</button>
					    <button type="button" class="btn btn-dark"><i class="fa fa-home"></i> Properties</button>
					    <button type="button" class="btn btn-dark"><i class="fa fa-car"></i> Vehicles</button>
					    <button type="button" class="btn btn-dark"><i class="fa fa-gavel"></i> Auctions</button>
					    <button type="button" class="btn btn-dark"><i class="fa fa-newspaper-o"></i> Vacancies</button>
					    <button type="button" class="btn btn-dark"><i class="fa fa-newspaper-o"></i> Latest News</button>
					  </div>

					<div class="spacer"></div>





		 			<?php //$this->load->view('inc/featured_business');?>
					<!--<div class="spacer"></div>-->
					<?php //$this->load->view('inc/featured_listings');?>
					<!--<div class="spacer"></div>-->
					<?php $this->load->view('inc/categories');?>
					<div class="spacer"></div>
					<?php $this->load->view('inc/classifieds');?>
					<div class="spacer"></div>
					<?php $prop['type'] = '3408'; $this->load->view('inc/products', $prop);?>
					<div class="spacer"></div>
					<?php $cars['type'] = '348'; $this->load->view('inc/products', $cars);?>
					<div class="spacer"></div>
					<?php $this->load->view('inc/auctions');?>					
					<div class="spacer"></div>
					<?php $this->load->view('inc/news');?>	
					<div class="spacer"></div>
				</div>	
			</div>
		</div>
	</div>	
</div>
	
<?php $this->load->view('inc/footer');?>	

<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>

<script type="text/javascript">

	$(document).ready(function(){	

		// INITIALIZE OWL
		$('#owl-banners').owlCarousel({
		    loop:false,
		    lazyLoad: true,
		    navRewind:false,
		    margin:10,
		    nav: true,
		    navText : ["<button class='btn owl-prev-next-button previous'></button>","<button class='btn owl-prev-next-button next'></button>"],
		    responsiveClass:true,
		    responsive:{
		        0:{
		            items:1,
		            nav:false,
		            loop:true
		        },
		        600:{
		            items:1,
		            nav:false,
		            loop:true
		        },
		        1000:{
		            items:1,
		            nav:true,
		            loop:true
		        },

		        1600:{
		            items:1,
		            nav:true,
		            loop:true
		        }		        
		    }
		});


		slideshow = $( '.feature-cycle-slideshow' ).cycle();

	    slideshow.on( 'cycle-initialized cycle-before', function( e, opts ) {
	      progress.stop(true).css( 'width', 0 );
	    });
	    
	    slideshow.on( 'cycle-initialized cycle-after', function( e, opts ) {
	      if ( ! slideshow.is('.cycle-paused') )
	        progress.animate({ width: '100%' }, opts.timeout, 'linear' );
	    });
	    
	    slideshow.on( 'cycle-paused', function( e, opts ) {
	       progress.stop(); 
	    });
	    
	    slideshow.on( 'cycle-resumed', function( e, opts, timeoutRemaining ) {
	      progress.animate({ width: '100%' }, timeoutRemaining, 'linear' );
	    });

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

		initialise_owl();	
		
	});


  function initiate_slides(){

    // Cycle plugin
    // Pause & play on hover
    var c = $('.cycle-slideshow').cycle('pause');
    c.hover(function () {
      //mouse enter - Resume the slideshow
      $(this).cycle('resume');
    },

    function () {
      //mouse leave - Pause the slideshow
      $(this).cycle('pause');
    });
    
    //$("input .star").rating();          

  }	

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
	
	


</script>


</body>
</html>