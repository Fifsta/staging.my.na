<?php 

//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] =  $sub_cat_name.' Careers in '.$location.' - My Namibia &trade;';
$header['metaD'] =  $sub_cat_name.' Careers in '.$location.'. The biggest career and vacancy platform in Namibia. Find that best next ' .$sub_cat_name.' Careers in '.$location.' today. Find What you !na';
$header['section'] = 'home';
$this->load->view('inc/header', $header);

?>

<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>

</head>

<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
  <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Careers</li>
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


        <section id="products">

  				<div class="heading">
					<h2 data-icon="fa-briefcase" itemprop="description">Featured <strong>Vacancies</strong></h2>
					<p>Browse all listed featured vacancies here.</p>
					<ul class="options">
						<!--<li><a href="https://nmh.my.na/main/subscribe/?type=featured_business" target="_blank"><i class="fa fa-edit text-dark"></i> Feature my Business</a></li>-->
					</ul>
				</div>      	
          



			<?php if(isset($html)){ echo $html;}

				//echo $pages;	
			?>   

            <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
            <div class="spacer"></div>	      


	        </section>

	          <section id="classifieds" style="margin-bottom:25px">

		        <div class="heading">
		        <h2 data-icon="fa-search">Find Jobs <strong>in Namibia</strong></h2>
		        <p>Browse all vacancy listings here</p>

		        </div>

		         <?php
			        //++++++++++++++++++++++
			        //LOAD CAREER SEARCH BOX
			        //++++++++++++++++++++++
			        $this->load->view('career/inc/filter');
		         ?>
		         <div class="spacer"></div>
		         <div class="row">
		         	<div class="col-md-12">
		         		<div class="card">
		         			<div class="card-body">
		         				<div class="row">
						         	<div class="col-md-4 text-center">
										<h3 class="upper na_script">Featured<br><span class="na_script yellow ">Jobs </span></h3>
					                    <p>The best career opportunities are right here. Browse our wide range of jobs and stay updated with the latest jobs currently on offer.</p>       		
						         	</div>

						         	<div class="col-md-4 text-center">        		
					                    <h3 class="upper na_script">Looking for <span class="na_script yellow "><br>Work?</span></h3>
					                    <p>Are you ready to face the working market? Don't worry! With us you need to look no further. With the latest, 
					                    hottest vacancies on our our site, you are sure to find your dream job.</p>	 		                            		
						         	</div>

						         	<div class="col-md-4 text-center">   		
					                    <h3 class="upper na_script ">Your<br><span class="na_script yellow">CV?</span></h3>
					                    <p>Create an impressive CV online, quick and easy with our ONLINE CV GENERATOR.</p> 		         		
						         	</div>

						         	<div class="col-md-12">
					                    <a href="<?php echo site_url('/');?>vacancy/" class="btn btn-dark btn-block">Get Started Now</a>	         		
						         	</div>
						         </div>	
		         			</div>
		         		</div>		
		         	</div>      	
		         </div>	
	                     
	        </section>      

    </div>

  </div>  
  
</div>
  
<?php $this->load->view('inc/footer');?>  
<script src="<?php echo base_url('/');?>js/custom/fb.js?v=1"></script>
<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!--<script src="<?php echo base_url('/');?>js/jquery.inview.js" type="text/javascript"></script>
<script src="<?php // echo base_url('/');?>video/video/eh5v.files/html5video/html5ext.js" type="text/javascript"></script>-->
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


		initialise_career_owl();

        $('[rel=tooltip]').tooltip();

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

	function initialise_career_owl() {

		// INITIALIZE OWL
		$('#career-carousel').owlCarousel({
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
		            items:2,
		            nav:true,
		            loop:false
		        },

		        1600:{
		            items:3,
		            nav:true,
		            loop:false
		        }		        
		    }
		});

	}


</script>

<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=2"></script>
<script src='<?php echo base_url('/') ?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>

</body>
</html>