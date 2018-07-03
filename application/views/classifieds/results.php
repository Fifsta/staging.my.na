<?php 

//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] =  $cat_name.' Classifieds in '.$location.' - My Namibia &trade;';
$header['metaD'] =  $cat_name.' Classifieds in '.$location.'. The biggest career and vacancy platform in Namibia. Find that best next ' .$cat_name.' Classifieds in '.$location.' today. Find What you !na';
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
        <li class="breadcrumb-item active" aria-current="page">Classifieds</li>
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

		<div class="card text-center">
			<a href="<?php echo site_url('/'); ?>sell/featured"><img alt="Feature Your Listing Online" src="https://www.my.na/img/adverts/featured_listing_banner.png" class="img-fluid"></a>	
		</div>

        <div class="spacer"></div>

        <section id="classifieds" style="margin-bottom:25px">

	        <div class="heading">
	        <h2 data-icon="fa-newspaper-o">Find Classified <strong>in Namibia</strong></h2>
	        <p>Browse all classified listings here</p>

	        </div>

	         <?php
		        //++++++++++++++++++++++
		        //LOAD CAREER SEARCH BOX
		        //++++++++++++++++++++++
		        $this->load->view('classifieds/inc/filter');
	         ?>
                     
        </section>
        
        <section id="products" style="margin-top:10px">
          
         <div class="col-md-12">

            <div id="deal_content" data-display="0">

            </div>   

			<?php if(isset($html)){ echo $html;}
				echo $pages;	
			?>   

            <div class="loading_img hidden" style="width:100%" id="pre_loader"></div>
            <div class="spacer"></div>	      
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