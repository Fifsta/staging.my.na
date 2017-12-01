<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = 'Namibia on a Map - My Namibia &trade;';
$header['metaD'] = 'Find Business, Products and Services on a interactive map of Namibia. Find What you !na';
$header['section'] = 'home';
$this->load->view('inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
 <style type="text/css">
 #navbar{z-index:99}
 #map{z-index:0;height:100%;background:url(<?php echo base_url('/');?>img/orange_loader.gif) no-repeat center center #fff;}
#map_container{-webkit-box-shadow: inset 2px 1px 5px -1px rgba(0,0,0,0.75);
-moz-box-shadow: inset 2px 1px 5px -1px rgba(0,0,0,0.75);
box-shadow: inset 2px 1px 5px -1px rgba(0,0,0,0.75);padding:2px 0 0 2px}
 .row-fluid .span2,.row .span2{z-index:1;position:relative;padding-left:30px}.row{padding:0;margin:0} 
 #geo_msg{position:fixed; top:20%;right:5%}
 .full_width{min-width:100%;padding:70px 0 0 0;margin:0; overflow:hidden}
 .cnav{position:absolute; border:1px solid #060}

 .cnav_close li a, .cnav_close h1, .cnav_close p{display:none;}
 .cnav_close button{display:none}
  .cnav_close li a{display:none;}
 #nav_slide{position:fixed;left:5px;top:60px;width:35px;height:30px}
 .cnav_open{margin:10px -30px 0px 0px}
 #wrap{background:#fff;}
 .accordion > .accordion-group > .accordion-heading  a.accordion-toggle{font-size:90%}
 .accordion > .accordion-group > .accordion-heading  a.accordion-toggle:hover, .accordion > .accordion-group > .accordion-heading  a.accordion-toggle:active{text-decoration: none}
 .accordion > .count-res{margin:0 0 0 80% }
 .accordion > .accordion-group > .accordion-body > .accordion-inner > ul.nav > li > a span.count-res-sml{margin:0 0 0 80% ;}
 .row-fluid{width:100%; margin:0; padding: 0}.row-fluid .span2 {padding: 0 0 0 10px; margin:0 0 0 5px;}
 .accordion-heading .accordion-toggle{padding: 5px 8px}
 @media (min-width: 768px) and (max-width: 1150px) {

     .full_width{min-width:100%;padding:0px 0 0 0;margin:0; overflow:hidden}
 }

 @media (max-width: 480px) {

 }
 @media (max-width:767px){


	 
}
 @media (max-width:1000px){

     ul.nav li a{font-size: 10px}

 }
 </style>

</head>
<body>  

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 //$this->load->view('inc/navigation', $nav);
 ?>
    <!-- END Navigation -->
<div id="wrap">    
   <!-- Part 1: Wrap all content here -->
   <!-- Begin page content -->
	<div class="container-fluid full_width">
        
    	<div class="row-fluid">
        	
        	<div class="span2" id="sidebar" >
            	<a class="btn btn-mini white_back cnav_open pull-right" onClick="toggleNav(1)"><i class="icon-chevron-left"></i></a>
                 <h3 class="na_script upper hide">Navigation</h3>
                 <p class="clearfix">&nbsp;</p>
                    <form>
                        <fieldset>
                            <input class="span12" name="srch_category" id="srch_category"  type="text" value="<?php if(isset($catM)){ echo $catM;}else{ echo '';}?>" autocomplete="off" placeholder="Looking for eg: Plumber">
                            <label>Find Businesses</label>
                            <div id="category_t">
                                <input type="text" class="span12 typeahead" autocomplete="off" style="width:100%" placeholder="Find businesses">
                            </div>
                        </fieldset>
                    </form>
                    <ul class="nav nav-tabs nav-stacked">
                        <li class="nav-header" >Business Services</li>
                        <?php
                        //$this->map_model->show_popular_cats($t = 'map_nav');
                        ?>
                    </ul>

                 <p>&nbsp;</p>
            </div>
            
            <div class="span10" id="map-container">

                    <div id="map_container">
                        <div id="map"></div>
                    </div>

            </div>
        </div>
        
    </div>
	
    <div id="nav_slide" class="nav_slide hide"><a class="btn btn-mini white_back" onClick="toggleNav(0)"><i class="icon-chevron-right"></i></a></div>
	<div class="alert alert-danger hide" id="geo_msg"></div>
     <!-- /container - end content --> 

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 //$this->load->view('inc/footer');
 ?>  
</div>
    <!-- JAvascript
    ================================================== -->


    <!--<script src="https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>-->
    <script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
    <script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
     <!--<script src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
     <script src="<?php /*echo base_url('/');*/?>js/geolocationmarker-compiled.js"></script>
     <script src="<?php /*echo base_url('/');*/?>js/markerclusterer.js"></script>-->
	<script type="text/javascript">

	var base = '<?php echo site_url('/');?>';
	var base_ = '<?php echo base_url('/');?>';

    function go_search(main_cat_id, sub_cat_id) {

        var myna2 = new Bloodhound({
            //datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: '<?php echo site_url('/');?>map/category_typehead/',
            remote: '<?php echo site_url('/');?>map/ajax_search_json/?main_cat_id=' + main_cat_id + '&sub_cat_id=' + sub_cat_id + '&query=%QUERY',

        });

        myna2.initialize();

        $('#category_t input.span12').typeahead(null, {
            name: 'my-na2',
            displayKey: 'value',
            source: myna2.ttAdapter(),
            highlight: true,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any results that match the current query',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}">{{value}}</a>')
            }
        });
        //$(".tt-hint");

    }



    $(document).ready(function(e) {
        <?php //echo $this->map_model->load_category_typehead();?>

        //$('#srch_category').typeahead({source: subjects});

        go_search(0,0);

    });

    </script>

</body>
</html>