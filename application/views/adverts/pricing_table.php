<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = 'Advertising Pricing Table - My Namibia &trade;';
$header['metaD'] = 'Advertise on My Namibia. Advertising options and pricing structures. List Your product or Business for Free';
$header['section'] = 'home';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<link rel="stylesheet" href="<?php echo base_url('/');?>css/animate.css">
<link rel="stylesheet" href="<?php echo base_url('/');?>css/pricing_table.css">
<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<style type="text/css">

    p{font-size:110%}

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
            <div class="row-fluid">
                <div class="span12">
                    <p>&nbsp;</p>
                    <h1 class="text-center">Advertise Your <span class="na_script yellow big_icon">PRODUCT</span> OR <span class="na_script yellow big_icon">BUSINESS</span> in NAMIBIA</h1>
                    <p>&nbsp;</p>
                </div>

            </div>
            <div class="row-fluid">
                <div class="span12">
                    <h2>Main Product &amp; Business <span class="yellow">Advertising options</span></h2>
                </div>

            </div>

            <div class="plans row-fluid">


                <div class="span3 plan  wow slideInLeft" data-wow-delay="2">
                    <h3 class="plan-title">FREE LISTING</h3>
                    <p><span class="plan-feature-name">Free Product/Business Listing</span></p>
                    <p class="plan-price">FREE <span class="plan-unit">always</span></p>
                    <ul class="plan-features">
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">enquiries</span></li>
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">traffic</span></li>
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">images</span></li>
                        <li class="plan-feature">5  <span class="plan-feature-name">categories</span></li>
                        <li class="plan-feature">1 <span class="plan-feature-name">user</span></li>
                        <li class="plan-feature">1 <span class="plan-feature-name">map</span></li>
                        <!--<li class="plan-feature"><span class="plan-feature-name">reporting tools</span></li>-->
                    </ul>
                    <a href="#" class="plan-button">List Now</a>
                </div>
                <div class="span3 plan wow slideInLeft"  data-wow-delay="1">
                    <h3 class="plan-title">PAID BUSINESS </h3>
                    <p><span class="plan-feature-name">Premium Paid Business Listing</span></p>
                    <p class="plan-price">N$ 550 <span class="plan-unit">per month</span></p>
                    <p><span class="plan-feature-name">I want my business/product featured across a sub category - eg -
                                Accommodation / Hotel
                                e.g A Hotel features under Hotel in the sub Category section
                        </span>
                    </p>
                    <ul class="plan-features">

                        <li class="plan-feature">&infin; <span class="plan-feature-name">virtual tour</span></li>
                        <li class="plan-feature">&infin; <span class="plan-feature-name">advertorial</span></li>
                        <li class="plan-feature">&infin; <span class="plan-feature-name">reporting tools</span></li>
                    </ul>
                    <a href="#" class="plan-button">Upgrade Today</a>
                </div>
                <div class="plan plan-highlight span3  wow zoomIn"  data-wow-delay="3">
                    <p class="plan-recommended">Recommended</p>
                    <h3 class="plan-title">PRIME EXPOSURE</h3>
                    <p><span class="plan-feature-name">Business <strong>OR</strong> Product</span></p>

                    <p class="plan-price">N$ 1500 <span class="plan-unit">per month</span></p>
                    <p><span class="plan-feature-name">Prime Product/Business Listing</span></p>
                    <p><span class="plan-feature-name">I want my Business/Product Featured across a main business/Product category & related
                                                        sub categories</span></p>
                    <ul class="plan-features">
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">impressions</span></li>
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">clicks</span></li>
                        <li class="plan-feature">&infin; <span class="plan-feature-name">reporting tools</span></li>
                    </ul>
                    <a href="#" class="plan-button">Yes Activate Me</a>
                </div>
                <div class="plan span3 wow slideInRight" data-wow-delay="2">

                    <h3 class="plan-title">MAXIMUM EXPOSURE</h3>
                    <p><span class="plan-feature-name">Business <strong>OR</strong> Product</span></p>

                    <p class="plan-price">N$ 5000 <span class="plan-unit">per month</span></p>
                    <p><span class="plan-feature-name">Main Category Advert (300 x 430 px) </span></p>
                    <p><span class="plan-feature-name">Advert appears across a specific Main business category & all related sub categories </span></p>
                    <ul class="plan-features">
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">impressions</span></li>
                        <li class="plan-feature">&infin;  <span class="plan-feature-name">clicks</span></li>
                        <li class="plan-feature">&infin; <span class="plan-feature-name">reporting tools</span></li>
                    </ul>
                    <a href="#" class="plan-button">Get Maximum</a>
                </div>

            </div>
            <div class="row-fluid">

                <p>&nbsp;</p>
                <p>&nbsp;</p>

            </div>
            <div class="row-fluid">
                <div class="plan span3  wow zoomIn">
                    <h3 class="plan-title">Keyword Exposure</h3>
                    <p><span class="plan-feature-name">Business</p>
                    <p class="plan-price">N$ 50 <span class="plan-unit">per keyword per month</span></p>
                    <ul class="plan-features">
                        <li class="plan-feature">1<span class="plan-feature-unit">KW</span> <span class="plan-feature-name"> </span></li>

                    </ul>
                    <a href="#" class="plan-button">Choose Keywords</a>
                </div>
                <div class="span9  wow zoomInRight">
                    <h2>Per Keyword <span class="yellow">Advertising</span> For Business</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc metus quam, rhoncus sit amet erat et, sollicitudin
                        vehicula neque. Donec vitae dui id nisi placerat sagittis. Vestibulum est orci, maximus nec tempus vel, viverra ut
                        sapien. Suspendisse dapibus sem id tortor ornare, a tempus neque sodales. Integer maximus, arcu sed accumsan commodo,
                        augue risus ullamcorper tellus, dictum consequat erat tortor ac orci. Aenean in ligula id leo eleifend consequat
                        sed vehicula mauris. Aliquam suscipit leo justo, quis facilisis libero vulputate tempor. Duis vitae ligula ante.
                        Donec in gravida felis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.
                        Suspendisse velit felis, vehicula ac cursus eu, dignissim vitae risus. Integer nec magna risus. Ut suscipit nisi in libero
                        pellentesque rhoncus. Nam laoreet gravida ultricies. Nam vitae lobortis magna, id hendrerit ipsum. Morbi et eros interdum,
                        sodales diam sed, ultrices augue.</p>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span9 text-right  wow slideInLeft">
                    <h2>Get Your <span class="yellow">Business Featured</span> with an Advertorial </h2>
                    <p>Are you a small business owner who has exhausted the use of press releases, feature story ideas,
                        and direct-mail packages? We understand. It's time to employ the marketing tool that generates
                        the hottest leads and has the power to push your profits to the next level. Advertising.
                    </p>
                    <p>But you don't want to go crazy. The advertising experts at MyNa suggest you think response.
                        Instead of the typical ads that you see in most publications--newspapers and magazines--think advertorial,
                        the kind of ad that actually looks like a real news story or other editorial matter.
                        Advertorials have a very good track record. They are to print what Infomercials are to TV.
                        They may be corny to the uninformed but, like the TV infomercials, they are amazingly successful.
                    </p>

                </div>
                <div class="plan span3  wow slideInRight">
                    <h3 class="plan-title">Advertorial</h3>
                    <p><span class="plan-feature-name">Business</p>
                    <p class="plan-price">N$ 5000 <span class="plan-unit">once off</span></p>
                    <ul class="plan-features">
                        <li class="plan-feature">800<span class="plan-feature-unit">words</span> <span class="plan-feature-name"></span></li>
                    </ul>
                    <a href="#" class="plan-button">Get Featured </a>
                </div>
            </div>

        <div class="row-fluid">

            <p>&nbsp;</p>


        </div>
        <div class="row-fluid">
            <div class="span8  wow slideInLeft">
                <h2>Why <span class="yellow">List On</span> My Namibia</h2>
                <p>We are one of Namibia's most trafficked sites, with a unique audience well over 1.8 million visiting the site each
                    month. Whether you're promoting a product, a service, or a brand, MYNA delivers the reach and coverage you need
                    to get in front of key consumers across our beloved country.</p>
                <p>
                We are NAMIBIAS Number 1 online marketplace with over 9000 listed businesses. Why are we so popular? With My Namibia,
                    you never miss out on any great deals, and you can sell all your unwanted stuff. Plus, we help you get things done quicker,
                    with instant notifications that keep you up to date.</p>
                <p>
                Want more reasons? We offer professional looking listings with options for gallery images, banners and content that will capture attention and make you look your very best. </p>

            </div>
            <div class="span4  wow slideInRight">

                <div class="easyhtml5video white_box" style="position:relative;max-width:1280px;margin-top:20px">


                    <video controls="controls"  poster="<?php echo base_url('/');?>video/video/business_stick_man.jpg" style="width:100%" title="business_stick_man">
                        <source src="<?php echo base_url('/');?>video/video/business_stick_man.m4v" type="video/mp4" />
                        <source src="<?php echo base_url('/');?>video/video/business_stick_man.webm" type="video/webm" />
                        <source src="<?php echo base_url('/');?>video/video/business_stick_man.ogv" type="video/ogg" />
                        <source src="<?php echo base_url('/');?>video/video/business_stick_man.mp4" />
                        <object type="application/x-shockwave-flash" data="<?php echo base_url('/');?>video/video/eh5v.files/html5video/flashfox.swf" width="1280" height="720" style="position:relative;">
                            <param name="movie" value="<?php echo base_url('/');?>video/video/eh5v.files/html5video/flashfox.swf" />
                            <param name="allowFullScreen" value="true" />
                            <param name="flashVars" value="autoplay=false&controls=true&fullScreenEnabled=true&posterOnEnd=true&loop=false&poster=<?php echo base_url('/');?>video/video/business_stick_man.jpg&src=<?php echo base_url('/');?>video/video/business_stick_man.m4v" />
                            <embed src="eh5v.files/html5video/flashfox.swf" width="1280" height="720" style="position:relative;"  flashVars="autoplay=false&controls=true&fullScreenEnabled=true&posterOnEnd=true&loop=false&poster=<?php echo base_url('/');?>video/video/business_stick_man.jpg&src=<?php echo base_url('/');?>video/video/business_stick_man.m4v"	allowFullScreen="true" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.adobe.com/go/getflashplayer_en" />
                            <img alt="business_stick_man" src="<?php echo base_url('/');?>video/video/business_stick_man.jpg" style="position:absolute;left:0;" width="100%" title="Video playback is not supported by your browser" />
                        </object>
                    </video>


                </div>

            </div>

        </div>
        <div class="row-fluid">
            <p>&nbsp;</p>

        </div>
        <div class="row-fluid wow slideInLeft" >

            <div class="plan span4">

                <h3 class="plan-title">Last 24 Hours</h3>

                <p class="plan-price"><?php echo $unique24;?> <span class="plan-unit">unique visitors</span></p>
                <p><span class="plan-feature-name"> </span></p>
                <p class="plan-price"><?php echo $pageviews24;?> <span class="plan-unit">pageviews</span></p>
                <p><span class="plan-feature-name"> </span></p>
            </div>
            <div class="plan span4">

                <h3 class="plan-title">Last 7 days</h3>

                <p class="plan-price"><?php echo $unique7;?> <span class="plan-unit">unique visitors</span></p>
                <p><span class="plan-feature-name"> </span></p>
                <p class="plan-price"><?php echo $pageviews7;?> <span class="plan-unit">pageviews</span></p>
                <p><span class="plan-feature-name"> </span></p>

            </div>
            <div class="plan span4">

                <h3 class="plan-title">Last 30 days</h3>

                <p class="plan-price"><?php echo $unique30;?> <span class="plan-unit">unique visitors</span></p>
                <p><span class="plan-feature-name"> </span></p>
                <p class="plan-price"><?php echo $pageviews30;?> <span class="plan-unit">pageviews</span></p>
                <p><span class="plan-feature-name"> </span></p>

            </div>

        </div>
        <div class="row-fluid">

            <p class="text-right muted"><small><em>Data from Cloudflare inc. Refreshed every hour</em></small></p>


        </div>
        <div class="row-fluid">

            <p>&nbsp;</p>


        </div>
    </div>

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

<script src="<?php echo base_url('/');?>video/video/eh5v.files/html5video/html5ext.js" type="text/javascript"></script>
<script src='<?php echo base_url('/') ?>js/jquery.cycle2.min.js' type="text/javascript"></script>
<script src="<?php echo base_url('/') ?>js/wow.min.js"></script>
<script>

</script>
<script type="text/javascript">
    var site = '<?php echo site_url('/');?>';
    var base = '<?php echo base_url('/');?>';
    $(document).ready(function () {
        $('[rel=tooltip]').tooltip();
        new WOW().init();
    });

</script>


<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=2"></script>

</body>
</html>
