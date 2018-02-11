<?php 



$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
$width = 800;

$height = 450;

if(!$bus_details){ show_404(); }

$name =  $bus_details['BUSINESS_NAME'];
$email = $bus_details['BUSINESS_EMAIL'];
$tel = '+'.$bus_details['TEL_DIAL_CODE'].' '.$bus_details['BUSINESS_TELEPHONE'];
$fax = '+'.$bus_details['FAX_DIAL_CODE'].' '.$bus_details['BUSINESS_FAX'];
$cell = '+'.$bus_details['CEL_DIAL_CODE'].' '.$bus_details['BUSINESS_CELLPHONE'];
$description = $bus_details['BUSINESS_DESCRIPTION'];
$pobox = $bus_details['BUSINESS_POSTAL_BOX'];
$website = $bus_details['BUSINESS_URL']; 
$address = $bus_details['BUSINESS_PHYSICAL_ADDRESS'];
$city = $bus_details['city'];
$region = $bus_details['region'];
$latitude = $bus_details['latitude'];
$longitude = $bus_details['longitude'];
$startdate = $bus_details['BUSINESS_DATE_CREATED'];
//$city = $bus_details['CLIENT_CITY'];
$img = $bus_details['BUSINESS_LOGO_IMAGE_NAME'];
$vt = $bus_details['BUSINESS_VIRTUAL_TOUR_NAME'];
$advertorial = $bus_details['ADVERTORIAL'];
//Get categories
$cats = $this->business_model->get_current_categories($bus_id);
$rand = rand(0,9999);
//Build image string
$format = substr($img,(strlen($img) - 4),4);
$str = substr($img,0,(strlen($img) - 4));



if($img != ''){
	
	if(strpos($img,'.') == 0){

		$format = '.jpg';
		$img_str = 'assets/business/photos/'.$img . $format;
		$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
		
	}else{
		
		$img_str = 'assets/business/photos/'.$img;
		$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,300,300, $crop = '');
		
	}
	
}else{
	
	$img_url =  base_url('/').'images/bus_blank.png';	
	
}

//COVER IMAGE
$cover_img = $bus_details['BUSINESS_COVER_PHOTO'];

if($cover_img != ''){
	
	if(strpos($cover_img,'.') == 0){

		$format2 = '.jpg';
		$cover_str = 'assets/business/photos/'.$cover_img . $format2.'?='.$rand;
		$cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory,$cover_str,$width,$height, $crop = '');
		
	}else{
		
		$cover_str =  'assets/business/photos/'.$cover_img.'?='.$rand;
		$cover_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory,$cover_str,$width,$height, $crop = '');
		
	}
	
}else{
	
	$cover_url = base_url('/').'images/business_cover_blank.jpg';	
	
}


	



$header['title'] = $name. ' - My Namibia';
$header['metaD'] =  strip_tags(implode(' ',$cats['links'])) . ' - ' .$name. ' - a business listed on My Namibia';
$header['section'] = 'home';
 
//BUILD OPEN GRAPH
$header['og'] ='
<meta property="fb:app_id" content="287335411399195"> 
<meta property="og:type"        content="MyNamibia:business"> 
<meta property="og:url"         content="'.site_url('/').'b/'.$bus_id.'/'.$this->uri->segment(3).'/"> 
<meta property="og:title"       content="'.$header['title'].'"> 
<meta property="og:description" content="'.$header['metaD'].'"> 
<meta property="og:image"       content="'.$img_str.'">'; 

$this->load->view('inc/header');

?>

<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
<link href='<?php echo base_url('/');?>css/jquery.rating.css' type="text/css" rel="stylesheet"/> 

</head>

<body id="top">

<?php $this->load->view('inc/top_bar');?>

<nav id="bread">
	<div class="container">
		<ol class="breadcrumb">
		   <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>"  itemprop="url"><span itemprop="title">My</span></a></li>
		   <li class="breadcrumb-item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo site_url('/');?>a/show/all/all/all/none/" itemprop="url"><span itemprop="title">Businesses</span></a> </li>
		   <?php echo implode(' ',$cats['breadcrumb']); ?>
		   <li class="breadcrumb-item active"><?php echo $name;?></li>
		</ol>
	</div>
</nav>

<div class="container">

	<div class="row">

	    <div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-4" id="sidebar">

	      <?php $this->load->view('inc/login'); ?>
	      <?php $this->load->view('inc/weather');?>
	      <?php $this->load->view('inc/adverts');?>

	    </div>

	    <div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">

	    	<section id="listing">

		        <div class="heading" style="margin-bottom:15px">
		          <h2 data-icon="fa-briefcase"><?php echo $name; ?></h2>
		          <ul class="options">    
		            <li><a href="#Contact-Agent" data-icon="fa-envelope text-dark">Contact Agency</a></li>
		            <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
		            <li><a href="#" data-icon="fa-facebook text-dark"></a></li>
		            <li><a href="#" data-icon="fa-twitter text-dark"></a></li>
		            <li><a href="#" data-icon="fa-bookmark text-dark"></a></li>
		          </ul>
		        </div>

				<!--banner-->
		        <div class="list-map">
		          <div class="list-map-left" style="background:#ccc; position:relative">
		              <div class="asso static-banner">
						<?php if($bus_details['IS_NTB_MEMBER'] == 'Y'){ ?>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/ntb.png"></a>
						<?php } ?>

						<?php if($bus_details['IS_HAN_MEMBER'] == 'Y'){ ?>
						<a href="#" data-toggle="tooltip" data-placement="top" title="Message"><img src="images/han.png"></a>
						<?php } ?>
		              </div>
		              <img src="<?php echo $cover_url; ?>" class="img-fluid">
		          </div>
		          
		          <div class="list-map-right" id="map_container">
		          	<?php //$this->load->view('business/inc/business_map_inc', $bus_details);?>
		          </div>
		        </div>
		        <!--banner-->

				<!--details-->
				<div class="details">
					<div class="details-left">
						<figure>
							<a href="#"><img src="<?php echo $img_url; ?>"></a>
						</figure>
						<div class="rating">
							<span></span><span></span><span class="active"></span><span></span><span></span>
							<a class="#">8 Reviews</a>
						</div>
					</div>
					<div class="details-right">
						<h2><?php echo $address ;?><a href="#" data-toggle="tooltip" title="Find out more about getting featured"><span>Featured</span></a></h2>
						<div itemprop="address" itemscope itemtype="http://data-vocabulary.org/Address">
                             <span itemprop="street-address"><i class="fa fa-map-marker text-dark"></i> <?php echo $address ;?></span>
                             <span itemprop="locality"><?php echo $city ;?></span>
                             <span itemprop="region"><?php echo $region ;?></span>
                             <span itemprop="country-name">Namibia</span>
                         </div>
						<p class="desc"><?php echo $description; ?></p>
						<div class="cate">Categories: 
							<a href="#">Campsite Camping and Caravan</a>
							<a href="#">Lodge</a>
							<a href="#">Hotel Resort and Casino</a>
							<a href="#">Guest Farm</a>
							<a href="#">Hotel Resort and Casino</a>
							<a href="#">Hotel Resort and Casino</a>
						</div>
						<div class="row reveal">
							<div class="col-sm-12 col-md-6">
								<p data-icon="fa-phone"><button class="btn btn-default"><!--T: --><?php echo $tel; ?></button></p>
								<p data-icon="fa-fax"><button class="btn btn-default"><!--F: --><?php echo $fax; ?></button></p>
							</div>
							<div class="col-sm-12 col-md-6">
								<p data-icon="fa-tablet"><button class="btn btn-default"><!--C: -->+<?php echo $cell; ?></button></p>
								<p data-icon="fa-globe"><a href="http://www.website.com.na" class="btn btn-default" target="_blank"><!--W: --><?php echo $email; ?></a></p>
							</div>
						</div>
					</div>
				</div>
				<!--details-->		        	

	    	</section>	

		</div>

	</div>	
	
</div>
	
	
<?php $this->load->view('inc/footer');?>	

<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
<script src="<?php echo base_url('/');?>js/jquery.rating.pack.js" type="text/javascript"></script> 

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

$(document).ready(
function()
{
	$('.redactor').redactor({ 	
			
			buttons: ['formatting', '|', 'bold', 'italic', 'deleted', '|', 
			'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
			 'alignment', '|', 'horizontalrule']
		});
	
	
	$('[rel=tooltip]').tooltip();
	$('.carousel').carousel();
	
	
	//$(".my_na").popover({ placement:"left",trigger: "hover", title:"tebhdjsbdjsbd", content:"shnaksbnjkabnsabnsksbnkabns"});  
	$('.my_na_c').addClass('loading_img');
    load_similar();
	my_na(<?php echo $bus_id;?>);
	load_advert();
	
	$('.popovers').popover({
					placement : 'right',
					html : true,
					trigger : 'hover', //<--- you need a trigger other than manual
					delay: { 
					   show: "500", 
					   hide: "100"
					},
					content: function() {
					
						return $(this).find('span.popover-content').html();
					}
	});
	
}
);

function load_advert(){
	
	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'my_na/load_advert/';?>' ,
		success: function (data) {
			
			 $('#advert_big').html(data);
			
		}
	});	

}

function load_similar(){
	
	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'business/load_similar/'.$bus_id.'/';?>' ,
		success: function (data) {
			
			 $('#similar_div').html(data);
			 load_deals();
		}
	});	

}

function load_deals(){
var x = $('#deals_inc');
x.addClass('loading_img');	
	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'business/show_business_deal/'.$bus_id.'/';?>' ,
		success: function (data) {
			
			 x.html(data);
			
		}
	});	

}

function load_vt(){
var x = $('#virtual_tour');
x.addClass('loading_img');	
	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'business/load_virtual_tour/'.$bus_id.'/';?>' ,
		success: function (data) {
			
			 x.html(data);
			
		}
	});	

}
function reload_reviews(){
	
	/*$.ajax({
		type: 'post',
		url: '<?php echo site_url('/').'business/reload_reviews/'.$bus_id.'/';?>' ,
		success: function (data) {
			
			 $('#reviews').html(data);
			 $("input .star").rating();
		}
	});*/	

}
function phone_click(n,type){
	
	var num = n.find('font');
	num.slideDown();
	 
	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'business/add_business_phone_click/'.$bus_id.'/';?>'+type ,
		success: function (data) {	
			
		}
	});	

}

function my_na(id){
	
	var n = $('#'+id);
	var place = 'right'; 
	$.ajax({
		type: 'get',
		cache: false,
		url: '<?php echo site_url('/').'business/my_na/';?>'+id+'/'+place+'/' ,
		success: function (data) {	
			
			n.html(data);
			$('[rel=tooltip]').tooltip();
			my_na_effect();
			n.removeClass('loading_img');
		}
	});	
	
}

function my_na_yes(id){
	
	var n = $('#'+id);
	n.find(".my_na").hide();
	n.addClass('loading_img');
	n.popover('destroy');
	var place = 'right';
	$.ajax({
		type: 'get',
		cache: false,
		url: '<?php echo site_url('/').'business/my_na_click/';?>'+id+'/'+place+'/',
		success: function (data) {	
			
			n.html(data);
			$('[rel=tooltip]').tooltip();
			my_na_effect();
			n.removeClass('loading_img');
			n.find(".my_na").show();
		}
	});	

}

function my_na_effect(){

	//$('.my_na_c').removeClass('loading_img');
	$(function() {
		$(".my_na")
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
