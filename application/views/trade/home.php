<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
if (isset($heading)) {

    $header['title'] = $heading . ' - My Namibia';
    $header['metaD'] = $heading . '. Find ' . $heading . ' online - My Namibia';
    $header['section'] = '';

} else {

    $header['title'] = '';
    $header['metaD'] = '';
    $header['section'] = '';

}
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<style type="text/css">
    .white_box {

        -webkit-transition: margin 100ms ease-in-out;
        -moz-transition: margin 100ms ease-in-out;
        -o-transition: margin 100ms ease-in-out;

    }

    #deal_content .white_box:hover {

        margin-top: -2px;

        -moz-box-shadow: 0 0 10px #000;
        -webkit-box-shadow: 0 0 10px #000;
        box-shadow: 0 0 10px #000;

    }

    ul.breadcrumb li.current {
        color: #FFF;
        text-shadow: none;
    }

</style>
<link href="<?php echo base_url('/'); ?>css/select/select2.css" rel="stylesheet" type="text/css"/>
<link href='<?php echo base_url('/'); ?>css/jquery.rating.css' type="text/css" rel="stylesheet"/>
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
        <div class="row">

            <?php echo $top_title;?>

        </div>


        <div class="row-fluid" id="feature_content">
            <div class="span12">
                <div class="product_ribbon_sml"><small>My Namibia &trade;</small> FEATURED LISTINGS<span></span></div>  
                <iframe src="<?php echo HUB_URL;?>main/products/" allowtransparency="1" frameborder="0" style="width:100%; min-height: 290px; overlow:hidden"></iframe>



                <?php
                //+++++++++++++++++
                //SHOW FEATURE SLIDER
                //+++++++++++++++++
                //$this->trade_model->show_feature(0, 'main');

                ?>
            </div>
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
    </div>
    <div class="container-fluid">
            <div class="row-fluid">
                <div class="container">
                    <div class="row-fluid">
                        <div class="span7">
                            <h4 class="upper">Start Your Search here</h4>
                            <?php
                            //+++++++++++++++++
                            //LOAD SUB NAV
                            //+++++++++++++++++
                            $this->load->view('trade/inc/filter/filter_all');
                            ?>
                        </div>
                        <div class="span5 text-right">
                            <?php
                            //+++++++++++++++++
                            //LOAD SUB NAV
                            //+++++++++++++++++
                            echo $this->trade_model->show_popular_cats();
                            ?>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="container">
        <div class="clearfix">&nbsp;</div>
        <div class="row-fluid">

            <?php
            /*SIDEBAR
            span 3 for Sidebar content
            */

            ?>
            <div class="span12">
                <ul class="breadcrumb btn-inverse">
                    <?php $this->trade_model->show_categories_breadcrumb($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id, $location, $suburb);

                    ?>
                    <li class="active current"><?php echo $title; ?></li>
                </ul>

                <div id="deal_content">
                    <?php
                    /*Search Results
                    Loop through the search results in the query array
                    */

                    $this->trade_model->get_products($query , $main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $count = 15, $offset = 0, $title);


                    //LOAD PAGINATION
                    ?>
                </div>

                <?php if (isset($pages)) {
                    echo $pages;
                }
                ?>

            </div>


        </div>

        <div id="map_array"></div>
        <?php //LOAD MAP VIEW ?>
        <div class="row" id="map_container" style="display:none;">

            <div class="results_div"
                 style="display:block;position:relative;background:url(<?php echo base_url('/'); ?>img/loading.gif) no-repeat center center #fff;height:550px;width:100%;max-width:none">
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
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/select2.min.js"></script>
<script src='<?php echo base_url('/') ?>js/jquery.cycle2.min.js' type="text/javascript"
        language="javascript"></script>
<script src='<?php echo base_url('/') ?>js/jquery.rating.pack.js' type="text/javascript" language="javascript"></script>
<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=1"></script>
<script src="<?php echo base_url('/');?>js/prettyPhoto_3.1.5/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('[rel=tooltip]').tooltip();
		var progress = $('#feat_progress'),
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
    });


    function initiate_slides() {
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
        $("[rel=tooltip]").tooltip();
        window.setTimeout(initiate_rating, 100);

    }

    function initiate_rating() {

        $.getScript("<?php echo base_url('/')?>js/jquery.rating.pack.js", function () {

            $("input .star").rating();

        });


    }

    function initiate_pagination() {

        //PAGINATION
        $('div.pagination ul li a').bind('click', function (e) {

            e.preventDefault();
            var pre = $('#pre_loader');
            pre.removeClass('hidden');
            $('div.pagination ul').find('li.active').removeClass('active');
            $(this).closest("li").addClass('active');
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    pre.addClass('hidden');
                    $("#deal_content").append(data);
                    //initiate_slides();
                }
            });


        });

    }


    function my_na(id) {

        var n = $('#' + id);
        var place = 'left';
        $.ajax({
            type: 'get',
            cache: false,
            url: '<?php echo site_url('/').'business/my_na/';?>' + id + '/' + place + '/',
            success: function (data) {

                n.html(data);
                $('[rel=tooltip]').tooltip();
                my_na_effect(id);
                n.removeClass('loading_img');
            }
        });

    }

    function my_na_yes(id) {

        var n = $('#' + id);
        n.find(".my_na").hide();
        n.addClass('loading_img');
        n.popover('destroy');

        var place = 'left';
        $.ajax({
            type: 'get',
            cache: false,
            url: '<?php echo site_url('/').'business/my_na_click/';?>' + id + '/' + place + '/',
            success: function (data) {

                n.html(data);
                $('[rel=tooltip]').tooltip();
                my_na_effect(id);
                n.removeClass('loading_img');
                n.find(".my_na").show();
            }
        });

    }

    function my_na_effect(id) {

        $(function () {
            $("#" + id)
                .find("span")
                .hide()
                .end()
                .hover(function () {
                    $(this).find("span").stop(true, true).fadeIn();

                }, function () {
                    $(this).find("span").stop(true, true).fadeOut();

                });
        });

    }


</script>

</body>
</html>