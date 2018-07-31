<?php
//+++++++++++++++++
//My.Na Navigation
//+++++++++++++++++
//Roland Ihms
?>
<div class="navbar navbar-fixed-top navbar-inverse" id="navbar" role="navigation">

    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo site_url('/'); ?>">
                <div class="logo"></div>
            </a>

            <form class="navbar-form pull-left" id="search-main" name="search-main" method="post"
                  action="<?php echo site_url('/'); ?>my_na/search">
                <input type="hidden" value="<?php if (isset($type)) {
                    echo $type;
                } else {
                    echo 'none';
                } ?>" name="type">
                <input type="hidden" value="<?php if (isset($location)) {
                    echo $location;
                } else {
                    echo 'national';
                } ?>" name="location">
                <input type="hidden" value="<?php if (isset($main_cat_id)) {
                    echo $main_cat_id; 
                } else {
                    echo '0';
                } ?>" id="main_cat_id" name="main_cat_id">
                <input type="hidden" value="<?php if (isset($sub_cat_id)) {
                    echo $sub_cat_id;
                } else {
                    echo '0';
                } ?>" id="sub_cat_id" name="sub_cat_id">


                <input type="text" class="span4 typeahead" name="srch_bar" type="text"
                       value="<?php if (isset($str)) {
                           echo htmlspecialchars($str);
                       } else {
                           echo '';
                       } ?>" autocomplete="off" 
                       placeholder="Search Anything Namibian">
                <button class="btn btn-inverse" type="submit" id="btn_find"><i class="icon-search icon-white"></i> <span
                        class="hidden-phone">Find</span></button>

            </form>
            <div class="nav-collapse collapse main_nav">
                <ul class="nav">
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            Browse
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li class="nav-header">Find Anything</li>
                            <li class="dropdown-submenu">
                                <a tabindex="-1" href="#">Business</a>
                                <ul class="dropdown-menu">
                                    <li class="nav-header">Find Local Businesses</li>
                                    <?php
                                    $this->my_na_model->show_popular_cats($t = true);
                                    ?>
                                </ul>
                            </li>
                            <!--<li <?php if ($section == 'tourism') {
                                echo 'class="active"';
                            } ?>><a href="http://tourism.my.na/"><strong class="white">Tourism</strong></a></li>-->
                            <li <?php if ($section == 'property') {
                                echo 'class="active"';
                            } ?>><a href="<?php echo site_url('/'); ?>buy/property/">Property</a></li>
                            <li <?php if ($section == 'cars') {
                                echo 'class="active"';
                            } ?>><a href="<?php echo site_url('/'); ?>buy/car-bikes-and-boats/">Cars</a></li>
                            <!--              <li <?php if ($section == 'classifieds') {
                                echo 'class="active"';
                            } ?>><a href="http://classifieds.my.na/">Classifieds</a></li>
	                     <li <?php if ($section == 'jobs') {
                                echo 'class="active"';
                            } ?>><a href="http://jobs.my.na/">Jobs</a></li>-->
                            <li <?php if ($section == 'deals') {
                                echo 'class="active"';
                            } ?>><a href="<?php echo site_url('/'); ?>deals/">Deals</a></li>
                            <li><a href="<?php echo site_url('/'); ?>trade/">All products</a></li>
                            <li><a href="<?php echo site_url('/'); ?>trade/auctions/">Auctions</a></li>
                            <li><a href="<?php echo site_url('/'); ?>map/">Map</a></li>
                            <li><a href="http://blog.my.na/">Blog</a></li>
                            <?php if ($this->session->userdata('id')) { ?>
                                <li <?php if ($section == 'events') {
                                    echo 'class="active"';
                                } ?>><a href="<?php echo site_url('/'); ?>members/add_business/">Add Business</a></li>
                            <?php } else { ?>
                                <li><a href="<?php echo site_url('/'); ?>members/register/">Join</a></li>
                                <li><a href="<?php echo site_url('/'); ?>members/add_business/">Add Business</a></li>
                            <?php } ?>

                        </ul>

                    </li>


                    <li class="dropdown">


                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <span class="notification-small btn-success">New!</span>List Anything
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li class="nav-header">Sell Anything</li>
                            <li><a href="<?php echo site_url('/'); ?>sell/index/0/?type=service">List a Business Service<br>
                                    <span style="font-size:10px;">List your great business service for FREE</span></a>
                            </li>
                            <li><a href="<?php echo site_url('/'); ?>members/add_business/">List Business<br>
                                    <span style="font-size:10px;">Advertise your business for FREE</span></a></li>
                            <li><a href="<?php echo site_url('/'); ?>sell/index/0/?type=motor">Sell a Car<br>
                                    <span style="font-size:10px;">List a vehicle and sell it online, in no time.</span></a>
                            </li>
                            <li><a href="<?php echo site_url('/'); ?>sell/index/0/?type=property">Sell a Property<br>
                                    <span style="font-size:10px;">List and sell your property today.</span></a></li>
                            <li><a href="<?php echo site_url('/'); ?>sell/index/0">Sell Anything<br>
                                    <span style="font-size:10px;">Have you got any unwanted items?</span></a></li>
                            <li><a href="<?php echo site_url('/'); ?>sell/index/0/?auction=true">Create an Auction<br>
                                    <span style="font-size:10px;">Set a reserve value and see what you could get.</span></a>
                            </li>
                        </ul>

                    </li>

                </ul>


                <ul class="nav pull-right">

                    <li>
                        <a id="acc_btn" style="cursor:pointer" class="dropdown-toggle">My Account <b class="caret"></b></a>
                        <ul class="dropdown-menu" id="acc_ul" style="display:none">
                            <a class="close" style="margin-right:10px;cursor:pointer"
                               onclick="$('#acc_ul').fadeToggle('fast');">&times;</a>
                            <li class="nav-header">Login to Account</li>
                            <li style="width:290px" class="clearfix">
                                <div style="padding:20px">
                                    <form class="form-signin" method="post"
                                          action="<?php echo site_url('/'); ?>members/login/">
                                        <input type="hidden" name="redirect" id="redirect"
                                               value="<?php echo site_url('/') . uri_string(); ?>">
                                        <input type="text" class="input-block-level" name="email" id="email_lgn"
                                               placeholder="Email address">
                                        <input type="password" class="input-block-level" name="pass" id="pass_lgn"
                                               placeholder="Password">
                                        <label class="checkbox">
                                            <input type="checkbox" value="remember-me"> Remember me
                                        </label>

                                        <div class="fb-login-button" data-max-rows="1" data-size="medium"
                                             data-show-faces="false" data-scope="email" onlogin="checkLoginState()"
                                             data-auto-logout-link="false"></div>
                                        <button class="btn btn-inverse pull-right" type="submit"><i
                                                class="icon-lock icon-white"></i> <b>Sign in</b></button>
                                        <small>
                                            <a href="<?php echo site_url('/'); ?>members/"
                                               class="pull-left muted">Forgot Password?</a>
                                        </small>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-header">Create Free account</li>
                            <li>
                                <div style="padding:5px 20px">
                                    <a class="btn btn-block btn-inverse"
                                       href="<?php echo site_url('/'); ?>members/register"><b>Join</b> <img
                                            src="<?php echo base_url('/'); ?>img/icons/my-na-favicon.png"></a>
                                </div>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
<script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        var wait = 0;
        /*$.getScript('
        <?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
         $('input').placeholder();

         });*/

        $('#btn_find').bind('click', function (e) {
            e.preventDefault();
            if ($('.twitter-typeahead').text() != '') {

                $(this).addClass('disabled');
                $('#search-main').submit();
            }

        });

        go_search(<?php if(isset($main_cat_id) && $main_cat_id != 0){ echo $main_cat_id; }else{ echo '0';}?>, <?php if(isset($sub_cat_id) && $sub_cat_id != 0){ echo $sub_cat_id;}else{ echo '0';}?>);


    });

    function go_search(main_cat_id, sub_cat_id) {

        var myna = new Bloodhound({
            //datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            prefetch: '<?php echo site_url('/');?>my_na/typehead/location/',
            //remote: '<?php echo site_url('/');?>my_na/ajax_search_json/<?php if(isset($main_cat_id) && $main_cat_id != 0){ echo '?main_cat_id='.$main_cat_id.'&';}else{ echo '?';}if(isset($sub_cat_id) && $sub_cat_id != 0){ echo 'sub_cat_id='.$sub_cat_id.'&';} ?>query=%QUERY'
            remote: {
                url: '<?php echo site_url('/');?>my_na/ajax_search_json/?main_cat_id=' + main_cat_id + '&sub_cat_id=' + sub_cat_id + '&query=%QUERY',
                wildcard: '%QUERY'
            },
            limit: 10

        });

        myna.initialize();

        $('#search-main input.typeahead').typeahead({
            minLength: 1,
            highlight: true
        }, {
            name: 'my-na',
            displayKey: 'value',
            source: myna.ttAdapter(),
            highlight: true,
            limit: 10,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any results that match the current query',
                    '</div>'
                ].join('\n'),
                footer: [
                    '<a href="javascript:search_more();" class="btn btn-block white_back" style="border:none">',
                    '<p class="bold text-center"><i class="icon-search"></i> More Results</p>',
                    '</a>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}"><p><img class="img-polaroid" src="{{image}}" /><span class="bold">{{value}}</span><span class="muted hidden-phone ">{{body}}</span></p>{{link2}}</a>')
            }
        });
        //$('.tt-hint').addClass('form-control');
    }
    function search_more() {

        //var str = $('#search-main input.typeahead').typeahead('val'));
        if ($('.twitter-typeahead').text() != '') {

            //$(this).addClass('disabled');
            $('#search-main').submit();
        }
    }
    function clear_cat(type) {

        if (type == 'main') {
            $('#in_d').hide();
        }
        $('#' + type + '_cat_id').val(0);
        $('#' + type + '_cat_indicator').fadeOut();
        //go_search(0, 0);
    }

    function go_url(url) {

        if (url != '') {
            window.location = url;
        } else {


        }


    }


</script>
