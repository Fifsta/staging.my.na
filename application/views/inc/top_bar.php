<!--<div id="pre_load">
	<div>
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
	</div>
</div>-->
<header id="header" class="grad-orange">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<div class="slogo">
					<a href="#"><img src="images/logo-main.png"></a>
					<div>find • list • buy • sell</div>
				</div>
			</div>
			<div class="col-sm-8">
			
                <form class="input-group input-group-lg" id="search-main" name="search-main" method="post" action="<?php echo site_url('/'); ?>my_na/search">

                    <div class="find input-group-addon">Find:</div>
                    <input type="text" class="form-control typeahead" name="srch_bar" type="text" value="<?php if (isset($str)) { echo htmlspecialchars($str); } else { echo ''; } ?>" autocomplete="off" placeholder="Search Anything Namibian">

                    <input type="hidden" value="<?php if (isset($type)) { echo $type; echo 'none'; } ?>" name="type">
                    <input type="hidden" value="<?php if (isset($location)) { echo $location; } else { echo 'national'; } ?>" name="location">
                    <input type="hidden" value="<?php if (isset($main_cat_id)) { echo $main_cat_id; } else { echo '0'; } ?>" id="main_cat_id" name="main_cat_id">
                    <input type="hidden" value="<?php if (isset($sub_cat_id)) { echo $sub_cat_id; } else { echo '0'; } ?>" id="sub_cat_id" name="sub_cat_id">

					<div class="near input-group-addon">Near:</div>
					<input type="text" class="near form-control" id="search-main2" placeholder="Windhoek">
					<span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search" role="button"></button></span>
    			    

                    
                </form>
				
				<div class="history">Search history: <a href="#">pizza</a>, <a href="#">lodge</a>, <a href="#">plumbing</a>, <a href="#">paper towels</a>, <a href="#">shoes</a>,</div>
			</div>
			<div class="col-sm-2 text-right">
				<div class="dropdown">

				  <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    My Account
				  </button>
				  
                  <?php if($this->session->userdata('id')){ ?>

                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="acc_ul">
                            <li style="width:290px" class="clearfix">
                               <a href="<?php echo site_url('/').'members/logout'; ?>">Logout</a>
                            </li>
                      </div>

                  <?php } else { ?>
                  
    				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="acc_ul">
    						<li style="width:290px" class="clearfix">
                                <div style="padding:20px">
                                    <form class="form-signin" method="post" action="<?php echo site_url('/'); ?>members/login/">
                                        <input type="hidden" name="redirect" id="redirect" value="<?php echo site_url('/') . uri_string(); ?>">

    									<div class="form-group">
    										<li class="nav-header">Login to Account</li>
                                            <input type="text" class="form-control" name="email" id="email_lgn" placeholder="Email address">
                                        </div>

                                        <div class="form-group">   
                                                <input type="password" class="form-control" name="pass" id="pass_lgn" placeholder="Password">
                                        </div>

                                        <label class="checkbox"> <input type="checkbox" value="remember-me"> Remember me </label>
    									
    									<div class="form-group">
                                                <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-scope="email" onlogin="checkLoginState()" data-auto-logout-link="false"></div>
    									</div>

                                        <button class="btn btn-dark pull-right" type="submit"><i class="fa fa-lock text-white"></i> <b>Sign in</b></button>
                                        
                                        <small><a href="<?php echo site_url('/'); ?>members/" class="pull-left muted">Forgot Password?</a></small>
                                    </form>
                                </div>
                            </li>
                            <li>
                                <div style="padding:5px 20px">
                                    <a class="btn btn-block btn-dark" href="<?php echo site_url('/'); ?>members/register"><b class="text-light">Join</b> <img src="<?php echo base_url('/'); ?>images/icons/my-na-favicon.png"></a>
                                </div>
                            </li>
    				  </div>

                  <?php } ?>


				</div>
			</div>
		</div>
	</div>
</header>

<script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
<script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=2"></script>

<script type="text/javascript">

    $(document).ready(function () {
        var wait = 0;
        /*$.getScript('
        <?php echo base_url('/'). 'js/jquery.placeholder.min.js'; ?>', function(data) {
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

        /*var myna = new Bloodhound({
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
        });*/
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
