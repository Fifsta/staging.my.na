<?php
if(isset($html) && $html === true){?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# website: http://ogp.me/ns/website#">
	<title><?php if(isset($title)){echo $title;}else{ echo 'My Namibia &trade;';}?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="<?php if(isset($metaD)){echo $metaD;}else{ echo 'My Namibia - the Free business portal in Namibia';}?>">
	<meta name="author" content="My Namibia">
	<!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
	<meta content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" name="viewport" />
	<meta name="apple-mobile-web-app-capable" content="yes">

    <?php } ?>
    <?php
        if(isset($bootstrap) && $bootstrap === true){?>
        <link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">


        <style type="text/css">
            body,html{background:#fff;max-width:1200px}
			.popover-title{background: #040404; color:#fff;text-transform: uppercase;font-size:16px;    -moz-border-radius: 0px;
				-webkit-border-radius: 0px;
				border-radius: 0px;
				-khtml-border-radius: 0px; border-top:2px solid #FF9F01; border-bottom:2px solid #FF9F01}
			.popover{    -moz-border-radius: 0px;
				-webkit-border-radius: 0px;
				border-radius: 0px;
				-khtml-border-radius: 0px;padding:0; }
			.popover-content{border-color:#000}.popover-content p{line-height:15px;margin:0 }
			.modal-backdrop {background:#ffffff}
			.navbar-inner{border:none;box-shadow:none; -wbkit-box-shadow:none; }
			<?php
        	if(isset($overflow)){ echo ' body,html{overflow:hidden}';}?>
            ::-webkit-scrollbar {
                height: 10px;
                overflow: visible;
                width: 10px;
                background: #fff;
            }
            ::-webkit-scrollbar-button {
                display: none;
                height:0;
                width: 0;
            }
            ::-webkit-scrollbar-track {
                -moz-background-clip: border;
                -webkit-background-clip: border;
                background-clip: border-box;
                border-width: 0 0 0 4px;
                border: solid transparent;
            }
            ::-webkit-scrollbar-track:hover {
                background-color:rgba(0,0,0,.05);
                -moz-box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
                -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
                box-shadow: inset 1px 0 0 rgba(0,0,0,.1);
            }
            ::-webkit-scrollbar-track:active {
                background-color:rgba(0,0,0,.05);
                -moz-box-shadow: inset 1px 0 0 rgba(0,0,0,.14), inset -1px 0 0 rgba(0,0,0,.07);
                -webkit-box-shadow: inset 1px 0 0 rgba(0,0,0,.14), inset -1px 0 0 rgba(0,0,0,.07);
                box-shadow: inset 1px 0 0 rgba(0,0,0,.14), inset -1px 0 0 rgba(0,0,0,.07);
            }
            ::-webkit-scrollbar-track:horizontal {
                border-width: 4px 0 0;
            }
            ::-webkit-scrollbar-track:horizontal:hover {
                -moz-box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
                -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
                box-shadow: inset 0 1px 0 rgba(0,0,0,.1);
            }
            ::-webkit-scrollbar-track:horizontal:active {
                -moz-box-shadow: inset 0 1px 0 rgba(0,0,0,.14), inset 0 -1px 0 rgba(0,0,0,.07);
                -webkit-box-shadow: inset 0 1px 0 rgba(0,0,0,.14), inset 0 -1px 0 rgba(0,0,0,.07);
                box-shadow: inset 0 1px 0 rgba(0,0,0,.14), inset 0 -1px 0 rgba(0,0,0,.07);
            }
            ::-webkit-scrollbar-thumb {
                -moz-background-clip: border;
                -webkit-background-clip: border;
                background-clip: border-box;
                background-color: rgba(0,0,0,.2);
                /*border-width: 1px 1px 1px 6px;
                border: solid transparent;*/
                -moz-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
                -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
                box-shadow: inset 1px 1px 0 rgba(0,0,0,.1),inset 0 -1px 0 rgba(0,0,0,.07);
                min-height: 28px;
                padding: 100px 0 0;
            }
            ::-webkit-scrollbar-thumb:hover {
                background-color:rgba(0,0,0,.4);
                -moz-box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
                -webkit-box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
                box-shadow: inset 1px 1px 1px rgba(0,0,0,.25);
            }
            ::-webkit-scrollbar-thumb:active {
                background-color:rgba(0,0,0,0.5);
                -moz-box-shadow: inset 1px 1px 3px rgba(0,0,0,0.35);
                -webkit-box-shadow: inset 1px 1px 3px rgba(0,0,0,0.35);
                box-shadow: inset 1px 1px 3px rgba(0,0,0,0.35);
            }
            ::-webkit-scrollbar-thumb:horizontal {
                border-width: 6px 1px 1px;
                -moz-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.07);
                -webkit-box-shadow: inset 1px 1px 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.07);
                box-shadow: inset 1px 1px 0 rgba(0,0,0,.1), inset -1px 0 0 rgba(0,0,0,.07);
                padding: 0 0 0 100px;
            }
            ::-webkit-scrollbar-corner {
                background: transparent;
            }
            .yellow{color:#FF9F01}.yellow_back{background: #FF9F01}
            @media (max-width: 767px) {

                #reviewfrm .row-fluid{width:inherit; }
                #reviewfrm .row-fluid .span5{width:inherit;min-width:200px; float:left}
                #reviewfrm .row-fluid .span7{width:inherit; }
				.media-object{float:left;}
                .mobile_small{min-width:120px; margin-left:15%}
				.table tr td{font-size:10px}
                .captcha_review{padding-left:10%}
            }


        </style>
    <?php }elseif(isset($html) && $html == true) { ?>

			


   <?php }else{?>
            <link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap_rate_external.css?v6">

    <?php }?>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/jquery.rating.css">

    <?php
    if(isset($html) && $html === true){?>
	<link rel="shortcut icon" href="<?php echo base_url('/');?>favicon.ico">

	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo base_url('/');?>img/icons/my_na_[144x144].png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo base_url('/');?>img/icons/my_na_[114x114].png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo base_url('/');?>img/icons/my_na_[72x72].png">
	<link rel="apple-touch-icon-precomposed" href="<?php echo base_url('/');?>img/icons/my_na_[57x57].png">

    <?php } ?>
    <link href='//fonts.googleapis.com/css?family=Yanone+Kaffeesatz' rel='stylesheet' type='text/css'>
	<style type="text/css">

		/*.container-fluid{max-width:340px;max-height:450px;}*/
		/*body,html{max-width:800px;}*/
		.text-right{text-align:right}
		textarea{width:95%}
		.container-fluid::-webkit-scrollbar {
			width: 0.5em;
		}
        body,html{padding:0;margin:0;overflow-x: hidden}
        .container-fluid,.span12{overflow-x: hidden}
        h1,h2,h3,h4,h5{font-family: 'Yanone Kaffeesatz', sans-serif;text-transform:uppercase}

	</style>
	<script type="text/javascript">
var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    height = (w.innerHeight|| e.clientHeight|| g.clientHeight) - 100;
	console.log(height+'----');
		if (typeof jQuery == 'undefined') {



			(function () {

				function loadScript(url, callback) {

					var script = document.createElement("script")
					script.type = "text/javascript";

					if (script.readyState) { //IE
						script.onreadystatechange = function () {
							if (script.readyState == "loaded" || script.readyState == "complete") {
								script.onreadystatechange = null;
								callback();

							}
						};
					} else { //Others
						script.onload = function () {
							callback();

						};
					}

					script.src = url;
					document.getElementsByTagName("head")[0].appendChild(script);
				}

				loadScript("//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js", function () {

					load_jq();

				});


			})();

		}else{

			$(document).ready(function(){

				$.getScript("<?php echo base_url('/');?>js/jquery.rating.pack.js", function ()
				{

					$("input .star").rating().fadeIn();

				});
                <?php if(isset($bootstrap) && $bootstrap === true){?>
                    $.getScript("<?php echo base_url('/');?>js/bootstrap.min.js?v=1", function ()
                    {
						
						$('.cont_height_d').css("height",height+'px');

                    });
                 <?php } ?>
				//btn_action();

			});

		}

		function load_jq(){

			$.getScript("<?php echo base_url('/');?>js/jquery.rating.pack.js", function ()
			{

				$("input .star").rating().fadeIn();

			});

            <?php
            if(isset($bootstrap) && $bootstrap === true){?>
                $.getScript("<?php echo base_url('/');?>js/bootstrap.min.js?v=1", function ()
                {
					
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

                });
				$('.cont_height_d').css("height",height+'px');
            <?php } ?>
			//btn_action();


		}




	</script>
    <?php
    if(isset($html) && $html === true){?>
</head>

<html>
<body>
    <?php } ?>