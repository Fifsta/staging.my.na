<link rel="stylesheet" href="<?php echo base_url('/');?>css/animate.css">
<style>

    .footer-modal{
        width:100%;
        background-color: #000;
        opacity:1;
        height:100px;
        z-index: 9999;
        bottom:0;
        position: fixed;
        display:none;
    }

    .betamyna{
        position:absolute;
        bottom:0;
        display:none;
        width:250px;
        box-shadow: 5px 10px #888888;
    }

</style>

<footer id="footer">
	<div class="container-fluid">
		<a href="#" class="logo-footer"><img src="images/logo-footer.png"></a>
		<div class="row">
			<aside class="col-sm-3 col-md-3 col-lg-4">
				<h2>About My Namibia</h2>
				<p>My Namibia also known as MY.NA is an online business and product networking platform for Namibians . Buy and Sell anything Namibian on this site , from , cars and property to any second hand product or service you can think off . List your product , business , service or Job here for FREE today and get maximum exposure online in Namibia . Namibian business's can feature in our state of the art business directory, giving your business the best exposure and visibility online. From Namibia for Namibia.</p>
			</aside>
			
			<aside class="col-sm-9 col-md-9 col-lg-8">
				<h2>Let us help you find</h2>		
				<div class="row">
					<?php $this->my_na_model->home_categories('light'); ?>
				</div>
			</aside>
		</div>
	</div>
	<div class="footer-end">
		<div class="container">
			<a href="#" class="logo-bookmark"><img src="images/footer-end.png"></a>
			<ul>
				<li><a href="#" data-icon="fa-facebook text-dark"></a></li>
				<li><a href="#" data-icon="fa-twitter text-dark"></a></li>
				<li><li><a href="#" data-icon="fa-youtube text-dark"></a></li>
			</ul>
			<small><a href="#">Terms & Conditions</a> | <a href="#">Contact Us</a> | <a href="#">Privacy policy</a> | <?php echo date('Y'); ?> © My Namibia ™</small>
		</div>
	</div>
</footer>

<div class="row-fluid footer-modal animate bounce">
    <div class="container">
        <div class="row text center text-light" style="padding:20px;">
        	<strong>Notice</strong>
			This website or its third-party tools use cookies, which are necessary to its functioning and required to achieve the purposes illustrated in the cookie policy. If you want to know more or withdraw your consent to all or some of the cookies, please refer to the cookie policy.
			By closing this banner, scrolling this page, clicking a link or continuing to browse otherwise, you agree to the use of cookies.
        </div>    
    </div>
</div> 


<?php //$this->output->enable_profiler(true); ?>


<script  type="text/javascript">

<?php 
	
    $qstr = '';
    if($qstr = $this->input->get()){
        $qstr = http_build_query($qstr);
    }
    
?>


$(document).ready( function(){

	$('.footer-modal').show();
    $('.footer-modal').addClass('animated slideInUp');
	
	// Call weather function
	get_weather('na','windhoek');

	// Prepend user profile after login
	/*$.get( "<?php echo site_url();?>my_na/nav/?url=<?php echo $_SERVER['REQUEST_URI']; ?>", function( data ) {
	  
	  	if(data == 'FALSE'){

		}else{

			$('#sidebar').prepend( data );
		}

	});*/

	$.post('<?php echo site_url();?>my_na/nav/', { url: "<?php echo $_SERVER['REQUEST_URI']; ?>"}, function(data){


	  	if(data == 'FALSE'){

		}else{

			$('#sidebar').prepend( data );
		}

	});


});

//Call weather from NMH HUB
function get_weather(cont,city){

	$.getJSON( "<?php echo HUB_URL;?>weather/display_block/"+cont+"/"+city, function( data ) {

		if(data.success){

			//$('#weather_cont').html(data.html);
			$('.city-weather').unbind('click').bind('click', function(e){
				var city = $(this).data('location');

				get_weather('na', city);
			});
		}

	});

}


function initialise_owl() {

	// INITIALIZE OWL
	$('.owl-carousel').owlCarousel({
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
	            nav:true
	        },
	        600:{
	            items:1,
	            nav:true
	        },
	        1000:{
	            items:3,
	            nav:true,
	            loop:false
	        },

	        1600:{
	            items:4,
	            nav:true,
	            loop:false
	        }		        
	    }
	});



	}


</script>

 <?php

	if($this->session->flashdata('login')){

		echo "<script data-cfasync='false'  type='text/javascript'>

		 		$(document).ready(function(){
					
					$.getScript('".base_url('/')."js/jquery.knob.js', function(){setTimeout(do_load, 300);});
					var cont = $('.na_points');
					//LOAD POINTS
					cont.addClass('loading');
					
					cont.removeClass('loading');
		       });
			   
			    function do_load(){
				   
					$.ajax({
						type:'get',
						cache: false,
						url: '".site_url('/')."win/get_points/".$this->session->userdata('id')."',
						success: function(data) {
							$('.na_points').html(data);
						}
					});  
			  	}
			 </script>

		<div class='na_points' id='na_points_msg'></div>
		";
 	}
 ?> 


<!-- Bootstrap -->
<link href="https://s3.amazonaws.com/mynamibia/packages/css/weather-icons.min.css" rel="stylesheet" type="text/css">

<!-- Calatz -->
<!-- The "browse to" file input fields -->

<script src="js/jquery.fileInput.js"></script>
<script src="js/owl.carousel.js"></script>

<script src="js/jquery.lazysizes.min.js"></script>
<script src="js/jquery.fancybox.min.js"></script>
<script src="js/bootstrap-select.min.js"></script>


<!-- Datepicker -->
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datetimepicker.min.js"></script>

<!-- Custom Js -->
<script src="js/jquery.custom.js"></script>