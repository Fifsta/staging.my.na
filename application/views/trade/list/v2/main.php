<?php
$getstr = '';
if ($getstr = $this->input->get())
{
    $getstr = '?'.http_build_query($getstr);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register - My Namibia&trade;">
    <meta name="author" content="My Namibia">
    <link rel="icon" href="<?php echo base_url('/');?>favicon.ico">
    <base href="<?php echo base_url('/');?>"/>
    <title>List an Item - My Namibia&trade;</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/');?>bootstrap/css/bootstrap.min.css?v1" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="//getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/animate_test.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        
		body{overflow-x:hidden}

		.pub_select img{max-width:80px}
		
		.pub_selected img{border:3px solid #009900;padding:3px}
        .tt-dropdown-menu {
            position: absolute;
            width: 100%;
            display: none;
            background-color: #fff;
            opacity: 0.9;
            margin-top: 0px;
            z-index: 1099;
            padding: 0px;
            -moz-box-shadow: 0 0 5px #666;
            -webkit-box-shadow: 0 0 5px #666;
            box-shadow: 0 0 5px #666;
            -moz-border-radius: 0px 0px 5px 5px;
            -webkit-border-radius: 0px 0px 5px 5px;
            border-radius: 0px 0px 5px 5px;
            -khtml-border-radius: 0px 0px 5px 5px;
        }
        .tt-dropdown-menu a{font-size:12px; line-height:20px; text-decoration:none;color:#000}
        .tt-dropdown-menu p{vertical-align:top;clear:both;}
        .tt-dropdown-menu a span.bold{margin:0px;font-weight:bold;font-size:16px; line-height:14px;padding-top:5px;display: table-cell; text-decoration:none}
        .tt-dropdown-menu a span.muted{font-size:12px; padding:2px 0px;}
        .tt-dropdown-menu a p img{display: table-cell;float:left; clear:right; margin:5px}
        .tt-dropdown-menu .alert{font-size:12px; padding:2px;margin:10px;text-align:center}
        .tt-hint, .typeahead, .twitter-typeahead {
            margin:0px;

        }
        .tt-dropdown-menu a:hover,.tt-dropdown-menu a:hover span ,.tt-dropdown-menu a.bold:hover{color:#fff;background-color: #FF9F01;}

        .tt-dropdown-menu a.bold p{line-height:30px; font-size:16px; margin:5px}


        .tt-suggestion:hover {
            cursor: pointer;
            color: #fff;
            background-color: #FF9F01;
        }

        .tt-suggestion.tt-cursor {
            color: #fff;
            background-color: #FF9F01;

        }
		.ui-widget-content,#item_content{box-shadow:none; !important}

        .list_btn:hover{text-decoration:none}
		.thumbnail a{display:none}
    </style>

    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/'); ?>bootstrap/js/bootstrap.min.js?v1"></script>
<?php
//TEMP PATCH FOR NMH LISTING CLASSIFIEDS
$qstr = '';
$link_str = '';
if($this->input->get('nmh_classifieds')){

    $qstr = '&nmh_classifieds=true';
    $link_str = "+'&nmh_classifieds=true'";
}
//TEMP PATCH FOR NMH LISTING CLASSIFIEDS
if($this->input->get('nmh_classifieds')){ ?>
	<link rel="stylesheet" href="<?php echo base_url('/');?>keyboard/css/jquery-ui.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>keyboard/css/keyboard.css">
	<style type="text/css">
		.navbar,.footer,#back_to_all{display:none}
        #select_cats{}
	</style>
    <script src="<?php echo base_url('/');?>keyboard/js/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('/');?>keyboard/js/jquery.keyboard.js"></script>
	<script>
	function init_keyboard(){
			$('#item_content').show().css({'background-color':'#fff', 'color':'#333', 'border':'1px solid #ccc'});
			$('.redactor-toolbar ,.redactor-editor').hide();
			$('.keyboard-numbers').keyboard({
				layout: 'custom',
				autoAccept : true,
                usePreview : false,
                userClosed: false,
				customLayout: {
					'default' : [
						'7 8 9',
						'4 5 6',
						'1 2 3',
						'0',
						'{bksp} {accept}'
					]
				},
				change: function(event, keyboard, el) {
				  var money_pre = $('#money-preview');
				  var temp = parseFloat($('#price_c').val() + '.' + $('#price_c').val());
           		  money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));
                }
			});
			$('.keyboard-email').keyboard({
				layout: 'custom',
				autoAccept : true,
                usePreview : false,
                userClosed: false,
				customLayout: {
					'default' : [
						'1 2 3 4 5 6 7 8 9 0 {bksp}',
						'q w e r t y u i o p',
						'a s d f g h j k l',
						'z x c v b n m @ . {shift}',
						'{space} .com .com.na _ - {accept}'
					],
                    'shift': [
                        '~ ! @ # $ % ^ & * ( ) _ + ',
                        'Q W E R T Y U I O P { } |',
                        'A S D F G H J K L : " {enter}',
                        '{shift} Z X C V B N M < > ? {shift}',
                        '{accept} {space} {cancel} {bksp} {extender}'
                    ]
				}
			});
			$('.keyboard-normal').keyboard({
				layout: 'custom',
				autoAccept : true,
                usePreview : false,
                userClosed: false,
				customLayout: {
					'default' : [
						'1 2 3 4 5 6 7 8 9 0',
						'q w e r t y u i o p',
						'a s d f g h j k l {bksp}',
						'{shift} z x c v b n m {shift}',
						', . {space} - {accept}'
					],
                    'shift': [
                        '~ ! @ # $ % ^ & * ( ) _ + ',
                        'Q W E R T Y U I O P { } |',
                        'A S D F G H J K L : " {enter}',
                        '{shift} Z X C V B N M < > ? . {shift}',
                        '{accept} {space} {cancel} {bksp} {extender}'
                    ]
				}
			});
            $('.keyboard-normal-cat').keyboard({
                layout: 'custom',
                autoAccept : true,
                usePreview : false,
                userClosed: false,
                //stayOpen: true,
                accepted : function(event, keyboard, el) {
                    console.log('The content "' + el.value + '" was accepted!');
                    $('#search_category').eq(0).val(el.value).trigger("input");
					$('#search_cat_classified').eq(0).val(el.value).trigger("input");
                },
                change: function(event, keyboard, el) {
                    $('#search_category').eq(0).val(el.value).trigger("input");
					$('#search_cat_classified').eq(0).val(el.value).trigger("input");
                },
                /*beforeClose: function(e, keyboard, el, accepted){
                    var txt = "Virtual Keyboard for " + el.id + " is about to close, and it's contents were ";
                    txt += (accepted ? 'accepted' : 'ignored');
                    txt += '. Current content = ' + el.value;
                    txt += '. Original content = ' + keyboard.originalContent;
                    console.log(txt);
                },*/
/*                visible: function(event, keyboard, el) {
                    // the "change" event is not fired on the preview input, use "input" instead
                    $('#search_category_keyboard').css({top:'120px'});
                },*/
                position : {
                    //my : 'center top',
                    //at : 'center top',
                    at2: 'center top',
                    //collision: 'flipfit flipfit'
                },
                customLayout: {
                    'default' : [
                        '1 2 3 4 5 6 7 8 9 0',
                        'q w e r t y u i o p',
                        'a s d f g h j k l {bksp}',
                        '{shift} z x c v b n m {shift}',
                        '{space} - {accept}'
                    ],
                    'shift': [
                        '~ ! @ # $ % ^ & * ( ) _ + ',
                        'Q W E R T Y U I O P { } |',
                        'A S D F G H J K L : " {enter}',
                        '{shift} Z X C V B N M < > ? {shift}',
                        '{accept} {space} {cancel} {bksp} {extender}'
                    ]
                }
            });
            //$('#search_category_keyboard').css({top:'120px'});
            // Using triggered events - set up to target all inputs on the page!
           /* $('.keyboard-normal-cat').bind('keyboardChange', function(e, keyboard, el){
               console.log('Input ID of ' + el.id + ' has the accepted content of ' + el.value);
                $('#search_category').eq(0).val(el.value).trigger("input");
            });*/





	}
    function close_keyboard(){

        /*var keyboard = $('.keyboard-normal-cat').keyboard().getkeyboard();
        keyboard.toggle();*/
    }
	</script>
<?php } else{ ?>
	<script>
	function init_keyboard(){
			
	}
	function close_keyboard(){



    }
	</script>
	
<?php }
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>


	<style type="text/css">
        #res_msg{position:fixed; left:50px; right:50px; bottom:20px;height:auto; padding:10px;display:none}
		div.thumbnail:hover{opacity:0.9; cursor:pointer; border:4px solid #093;margin-top:-3px}
		strong.text-danger{color:#BD362F;}
		div#home_container{min-height:500px}
        #search-cat_b .tt-dropdown-menu{max-height:300px;overflow-y: scroll}
        .tt-menu { display: block !important; }

        #pre_load {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background:  rgba(255,153,0,0.9);
            z-index: 10;
            color: #fff;}
        .slogo{
            position: absolute;
            display:inline-block;
            width: 220px;
            height: 60px;
            z-index: 15;
            top: 45%;
            left: 50%;
            margin: -30px 0 0 -110px;

        }
        .slogo a{display:block; margin-bottom:5px}
        /*.slogo img{height:50px; width:auto; display:block}*/
        .slogo div{color:#fff; display:block; text-align:center; font-size:120%; white-space:nowrap}

	</style>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui-noscript.css"></noscript>
    <script data-cfasync="false" type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places" ></script>  
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = '';
 //$this->load->view('inc/navigation', $nav);
 
 $full = '';
 if($step == 'step0'){
	 
	$full = '-fluid'; 
 }

 //SERVICE URL
 if(isset($type) && $type != ''){


     $data['type'] = $type;
     $type_str = '&type='.$type;
 }else{
     $type = 'general';
     $data['type'] = $type;
     $type_str = '&type=general';
 }

 $str = '';
 if(isset($bus_id) && $bus_id != 0){

     $str = ' for Business';

 }

 $auction_str = '&auction='.$auction;
 if(!isset($auction)){

     $auction_str = '';
     $auction = 'false';
 }


 ?>


    <div id="pre_load" class="text-center" style="margin:auto;vertical-align:center">
        <div class="slogo animated pulse infinite">
            <a onclick="return false;"><img src="img/logo-main.png"></a>
            <div>find &#183; list &#xb7; buy &middot; sell<br><br>LOADING...</div>
        </div>
    </div>


    <div style="position:fixed; top:20px;right:20px">
        <a href="<?php echo current_url('/').$getstr;?>" class="btn btn-default"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
    </div>

    <div class="container top" >

        <div class="row text-center">

            <?php  //+++++++++++++++++
            //LOAD SEARCH BOX
            //+++++++++++++++++
            $data['bus_id'] = $bus_id;
            $type_str = '';
            if($step == 'step0'){

                if($type == 'auction'){
                    echo '<h1>Create an Auction as</h1>';
                    $type_str = '&type=auction';

                }elseif($type == 'motor'){
                    $type_str = '&type=motor';
                    echo '<h1>List Anything Automotive as</h1>';

                }elseif($type == 'property'){
                    $type_str = '&type=property';
                    echo '<h1>List a Property as</h1>';

                }elseif($type == 'service'){
                    $type_str = '&type=service';
                    echo '<h1>List a Business Service as</h1>';

                }else{
                    $type_str = '&type=general';
                    echo '<h1>List an Item as</h1>';

                }


            }?>

        </div>

    </div>
    <div class="container top" id="step">

        <div class="row text-center">

                <?php $this->load->view('trade/list/v2/listing_select');?>

        </div>

    </div>

    <div class="container <?php if($bus_id  == ''){ echo 'hide';}?> slide" id="step1">

        <div class="row">
            <div class="col-lg-12">
                <?php $this->load->view('trade/list/v2/step1');?>

            </div>

        </div>

    </div>

    <div class="container hide slide" id="step2">

        <div class="row">
            <div class="col-lg-12">
                <?php $this->load->view('trade/list/v2/step2');?>

            </div>

        </div>

    </div>
    <div class="container hide slide" id="step3">

        <div class="row">
            <div class="col-lg-12">

                <?php $this->load->view('trade/list/v2/step3');?>
            </div>

        </div>

    </div>
    <div class="container hide slide" id="step4">

        <div class="row">
            <div class="col-lg-12">

				<?php $this->load->view('trade/list/v2/step4');?>
            </div>

        </div>

    </div>
    <div class="container hide slide" id="step0">

        <div class="row">
            <div class="col-lg-12">

				<?php $this->load->view('trade/list/v2/classified');?>
            </div>

        </div>

    </div>    
    <div class="container hide slide" id="step-1">

        <div class="row">
            <div class="col-lg-12">

				<?php $this->load->view('trade/list/v2/classified_images');?>
            </div>

        </div>

    </div>
    <div class="container hide slide" id="step-2">

        <div class="row">
            <div class="col-lg-12">

                    <div class="col-lg-10 col-lg-offset-1">
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <p>Your item has been listed for free.</p>
                        <h1 style="text-transform: uppercase">Do you want to <strong>FEATURE</strong> your item Online?</h1>
                        <h5 style="text-transform:uppercase">For only N$350 per month, let over a  <strong>million</strong> people see your item online through all our partner sites. </h5>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <p class="text-right"><a class="btn upsell" onclick="finish_up(false, 'classifieds');">No, I don't</a>
                        <a class="btn btn-primary animated pulse infinite upsell" onclick="finish_up(true, 'classifieds');">Yes, Feature Me!</a></p>
                         
                        <div class="clearfix" style="height:280px">&nbsp;</div>

                    </div>
                      <p class="text-center">
                            <img src="img/nmh_brands.jpg?v1"  class="img-responsive">
                     </p>
            </div>

        </div>

    </div>
    <div class="container hide slide" id="step5">

        <div class="row">
            <div class="col-lg-12">

					<div class="col-lg-10 col-lg-offset-1">
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <h4>Your item has been listed for free.</h4>
                        <h1 style="text-transform: uppercase">Do you want to <strong>FEATURE</strong> your item Online?</h1>
                        <h5 style="text-transform:uppercase">For only N$350 per month, let over a  <strong>million</strong> people see your item online through all our partner sites. </h5>
                        <div class="clearfix">&nbsp;</div>
                        <div class="clearfix">&nbsp;</div>
                        <p class="text-right"><a class="btn upsell" onclick="finish_up(false, 'products');">No, I don't</a>
                        <a class="btn btn-primary animated pulse infinite upsell" onclick="finish_up(true, 'products');">Yes, Feature Me!</a></p>

                        <div class="clearfix" style="height:280px">&nbsp;</div>

                    </div>
                    <p class="text-center">
                            <img src="img/nmh_brands.jpg?v1" class="img-responsive">
                     </p>
            </div>

        </div>

    </div>

    <div id="res_msg">


    </div>



    <div class="modal fade" tabindex="-1" role="dialog" id="finish_modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <h3>Great, Item Listed!</h3>
                    <div id="finish_body">


                    </div>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-primary animate pulse infinite" href="<?php echo site_url('/');?>sell/lookup/?nmh_classifieds=true">Finish up</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

 
<div class="modal fade" tabindex="-1" role="dialog" id="acount_modal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
		<h3>Are you still there?</h3>
        <p>To continue please click on proceed below. If we do not receive a response we will refresh the session.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary  animate pulse infinite" data-dismiss="modal">Proceed</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
   
    
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>
<script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
<script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
  
<script type="text/javascript">

    var type = "<?php echo $type;?>", type_str = "<?php echo $type_str;?>", auction = <?php echo $auction;?>;
    var pub_sel = [];
    $(document).ready(function(){

        $('#pre_load').fadeOut();
        //$('#finish_modal').modal({show : true, backdrop: 'static', keyboard: false});

        $('[rel=tooltip]').tooltip();
		  //window.scrollTo(0,$('#anchor_me').offset().top);
		init_keyboard();
		
		<?php if($step == 0){
			
			echo "	var contM = $('#home_container');
					contM.addClass('container-fluid').removeClass('container');
					";
					
			
			}?>



        //PATCH BUSINESS SSELECT
        $('#sel_bus_yes ul.dropdown-menu li a').each(function(e){
            var unit = $(this);
            var href = unit.attr('href');

            var temp = href.replace('sell/index/', 'sell/classifieds/')<?php echo $link_str;?>;
            console.log(temp);
            unit.attr('href', temp);

        });


        var contM = $('#home_container'), cont = $('#admin_content');
        cont.removeClass('slideLeft').addClass('loading_img');
        contM.removeClass('container-fluid').addClass('container');


        var cats = new Bloodhound({
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            //local:statess,
            //remote: '<?php echo site_url('/');?>my_na/build_typehead/business/?query=%QUERY',
            prefetch :  '<?php echo site_url('/');?>trade/build_typehead/<?php echo $bus_id.'/'.$type;?>',
            limit: 20
        });
        cats.initialize();
        $('#search_category').typeahead({
            minLength: 0,
            highlight: true
        }, {
            name: 'cats',
            displayKey: 'value',
            limit: 20,
            source: cats.ttAdapter(),
            highlight: true,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any category',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}"><p style="padding:0px 10px"><span class="bold">{{value}}</span><span>{{body}}</span></p></a>')
            }
        })
		$('#search_category').on('blur', function () {
            ev = $.Event("keydown");
            ev.keyCode = ev.which = 40;
            $('#search_category').trigger(ev);
            return true;
        })
		$('#search_category').on('select', function () {
            console.log('typhead select');
            //$('#search_category').trigger(ev);
            //return true;
        });

        $('#search-cat_b .twitter-typeahead').css("width", "100%");
        $('#search_category').on('click', function(e){

            $('#search_category_test').focus();

        });

        console.log('type '+type+ 'auction: '+auction);
        //show price
        //money-preview
		//init_keyboard();
        format_money();
		
		
        if (auction) {

            $('#listing_sel_type').fadeOut();
            $('#quantity_group').fadeOut();
            $('#auction_pricing').fadeIn();
            $('#fixed_pricing').fadeOut();
            $('#listing_type').val('A');
        }
       
        //$('#dpstart').datepicker()

        //$('#dpend').datepicker()
        <?php
         /**
        * ++++++++++++++++++++++++++++++++++++++++++++
        * //SUBMIT STEP 3
        * ++++++++++++++++++++++++++++++++++++++++++++
         */
         ?>
        $('#add_item_btn').bind('click', function (e) {

            e.preventDefault();
            var cont = $('#admin_content').addClass('slideLeft'), frm = $('#item-add'), btn = $(this);
            btn.html('Working...');
            //cont.addClass('loading_img');
            $.ajax({
                type: 'post',
                cache: false,
                data: frm.serialize(),
                url: '<?php echo site_url('/').'products_api/add_product/';?>',
                success: function (data) {
                    
					if(data.success){
						
						btn.html('<i class="icon-chevron-right icon-white"></i> Update Item');
						cont.empty().removeClass('slideLeft');
						cont.html(data);
						$("input[name='product_id']").val(data.product_id);
						slide_to(4);
					}else{

                        window.setTimeout(function(){
                            $('#res_msg').delay(100).fadeOut();
                        }, 3000);
						$('#res_msg').html('<div class="alert alert-danger">'+data.msg+'</div>').fadeIn();
						btn.html('<i class="icon-chevron-right icon-white"></i> Add Item');
						
					}


                }
            });
        });
		
		
		        <?php
         /**
        * ++++++++++++++++++++++++++++++++++++++++++++
        * //SUBMIT STEP 3
        * ++++++++++++++++++++++++++++++++++++++++++++
         */
         ?>
        $('#add_classified_btn').bind('click', function (e) {

            e.preventDefault();
            var cont = $('#admin_content').addClass('slideLeft'), frm = $('#classified-add'), btn = $(this);
            btn.html('Working...');
            $('#res_msg').empty();
            //cont.addClass('loading_img');
            $.ajax({
                type: 'post',
                cache: false,
                data: frm.serialize(),
                url: '<?php echo site_url('/').'products_api/add_classified/';?>',
                success: function (data) {
                    
					if(data.success){
						
						btn.html('<i class="icon-chevron-right icon-white"></i> Update Item');
						cont.empty().removeClass('slideLeft');
						cont.html(data);
						$("input[name='product_id']").val(data.classified_id);
						slide_to(-1);
					}else{

                        window.setTimeout(function(){
                            $('#res_msg').delay(100).fadeOut();
                        }, 3000);
                        $('#res_msg').html('<div class="alert alert-danger">'+data.msg+'</div>').fadeIn();
						btn.html('<i class="icon-chevron-right icon-white"></i> Add Item');
						
					}


                }
            });
        });
		
		$('.pub_select').on('click', function(e){
			var me = $(this);
			var pub_id = me.data('pub'),ed_id = me.data('edid'), pub_bus_id = me.data('bus-id');
            //console.log(pub_sel);

            if(me.hasClass('pub_selected')){

                me.removeClass('pub_selected');
                var i = pub_sel.indexOf(pub_bus_id);

                console.log(i);
                if (i != -1) {
                    pub_sel.splice(i, 1);
                }
            }else{
                pub_sel.push(pub_bus_id);
                me.addClass('pub_selected');
            }

			$('#pub_id').val(pub_id);
			$('#ed_id').val(ed_id);
			$('#pub_bus_id').val(pub_sel.toString());
			//$('.pub_select').removeClass('pub_selected');

			
			console.log( pub_sel.toString());
			
		});
		
		
		 //Increment the idle time counter every minute.
		var idleInterval = setInterval(timerIncrement, 3000); // 1 minute
	
		//Zero the idle timer on mouse movement.
		$(this).mousemove(function (e) {
			idleTime = 0;
		});
		$(this).keypress(function (e) {
			idleTime = 0;
		});
		$('body').on("tap",function(){
			idleTime = 0;
			console.log('touch!!!!');
		});
		

        var ccats = new Bloodhound({
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            //local:statess,
            //remote: '<?php echo site_url('/');?>my_na/build_typehead/business/?query=%QUERY',
            prefetch :  '<?php echo site_url('/');?>sell/build_typehead/<?php echo $bus_id.'/'.$type;?>',
            limit: 20
        });
        ccats.initialize();
        $('#search_cat_classified').typeahead({
            minLength: 0,
            highlight: true
        }, {
            name: 'ccats',
            displayKey: 'value',
            limit: 20,
            source: ccats.ttAdapter(),
            highlight: true,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any category',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}"><p style="padding:0px 10px"><span class="bold">{{value}}</span><span>{{body}}</span></p></a>')
            }
        })
		$('#search_cat_classified').on('blur', function () {
            ev = $.Event("keydown");
            ev.keyCode = ev.which = 40;
            $('#search_cat_classified').trigger(ev);
            return true;
        })
		$('#search_cat_classified').on('select', function () {
            console.log('typhead classified select');
            //$('#search_category').trigger(ev);
            //return true;
        });

        
        $('#search_cat_classified').on('click', function(e){

            $('#search_cat_classified_test').focus();

        });
        $('#classified-add .twitter-typeahead').css("width", "100%");


    });

    Number.prototype.formatMoney = function (c, d, t) {
        var n = this,
            c = isNaN(c = Math.abs(c)) ? 2 : c,
            d = d == undefined ? "." : d,
            t = t == undefined ? "," : t,
            s = n < 0 ? "-" : "",
            i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
            j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    };

    var idleTime = 0;

    function timerIncrement() {
        idleTime = idleTime + 1;
        console.log('timing '+ idleTime);
        if (idleTime > 30) { // 20 minutes
            //window.location.reload();
            window.location.href = '<?php echo site_url('/'). 'sell/lookup/?nmh_classifieds=true';  ?>';

        }else if(idleTime > 10) { //5 minutes

            check_user();
        }
    }



	function check_user(){
		
		$('#acount_modal').on('show.bs.modal', function (event) {
	
			 
		});
		
		$('#acount_modal').modal({show : true, backdrop: 'static', keyboard: false});
		
	}

function format_money(){
	
	 var money_pre = $('#money-preview');
        $('#price').on('change', function () {

            var temp = parseFloat($(this).val() + '.' + $('#price_c').val());
            money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));

        });
        $('#price_c').on('change', function () {

            var temp = parseFloat($('#price').val() + '.' + $(this).val());
            money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));

        });	
	
}
function populateSuburb(cityID)
  {
	  $("#suburb_div").html('<div class="col-lg-8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div>');
	  $.ajax({
		 url: "<?php echo site_url('/');?>trade/populate_suburb_name/"+cityID+"/0",
		success: function(data) {
		  $("#suburb_div").html(data);
		  
		}
	  });	
  }


function togglecheck(val){
			
	var chk = $('#listing_type');
	chk.val(val);
	if(val == 'A'){
		$('#sale_click').removeClass('btn-success');
		$('#auction_click').addClass('btn-success');
		$('#auction_pricing').slideDown();	
		$('#fixed_pricing').slideUp();
	}else{
		$('#sale_click').addClass('btn-success');
		$('#auction_click').removeClass('btn-success');
		$('#auction_pricing').slideUp();	
		$('#fixed_pricing').slideDown();
	}
}

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//LOAD CATEGORIES
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 


function load_ajax_product_cat(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name, bus_id, typel){
		
		var n = $('#select_cats');
		n.html('<div class="span3" style="text-align:center;margin-top:125px;width:100%"><img src="<?php echo base_url('/').'img/load.gif';?>" /><br /> Getting Categories...</div>');

		$.ajax({
			type: 'post',
			data:{	cat1: cat1, cat1name: cat1name, 
					cat2: cat2, cat2name: cat2name,
					cat3: cat3, cat3name: cat3name,
					cat4: cat4, cat4name: cat4name, type: typel},
			cache: false,
			url: '<?php echo site_url('/').'trade/load_product_categories/'.$bus_id.'/?type=';?>'+typel ,
			success: function (data) {	
				
				n.html(data).fadeIn('300');
                //close keyboard
                close_keyboard();
				$('#cat1').val(cat1);
				$('#cat1name').val(cat1name);
				$('#cat2').val(cat2);
				$('#cat2name').val(cat2name);
				$('#cat3').val(cat3);
				$('#cat4name').val(cat3name);
				$('#cat4').val(cat4);
				$('#cat4name').val(cat4name);
			}
		});	

}


    function go_step_1(str){

        var cont = $('#step2');
		
		if(str == 'classified'){
			
			slide_to(0);
		}else{
			
			slide_to(2);
		}

        



    }

function go_step_3(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name,bus_id, typel){

    //init_keyboard();
    slide_to(3);
	
}

function add_categories(cat1, cat2, cat3, cat4){
	
	console.log(cat1+"-"+cat2+"-"+ cat3+"-"+cat4);
	
}




<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//BACK
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 


function back_(cat1, cat1name, cat2, cat2name, cat3, cat3name , cat4, cat4name, ltype){
	
	if(cat4 > 0){
		
		load_ajax_product_cat(cat1, cat1name, cat2, cat2name, cat3, cat3name , 0 ,'_',<?php echo $bus_id;?>, ltype);
		
	}else if(cat3 > 0){
		
		load_ajax_product_cat(cat1, cat1name, cat2, cat2name,0 ,'_', 0 ,'_',<?php echo $bus_id;?>, ltype);
		
	}else if(cat2 > 0){
		
		load_ajax_product_cat(cat1, cat1name,0 ,'_', 0 ,'_',0 ,'_',<?php echo $bus_id;?>, ltype);
		
	}else if(cat1 > 0){
	
		load_ajax_product_cat(0,'_', 0,'_', 0,'_', 0,'_',<?php echo $bus_id;?>, ltype);
	}else{
		
		load_ajax_product_cat(0,'_', 0,'_', 0,'_', 0,'_',<?php echo $bus_id;?>, ltype);
	}
	
}

function back_to_all(){
	
	var btn = $('#back_to_all');
	btn.html('Working...');
	load_ajax('load_products');
	
}

function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}



  function populateSuburb(cityID)
  {
	  $("#suburb_div").html('<div class="col-lg-8" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div>');
	  $.ajax({
		 url: "<?php echo site_url('/');?>trade/populate_suburb_name/"+cityID+"/0",
		success: function(data) {
		  $("#suburb_div").html(data);
		  
		}
	  });	
  }

<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//BACK
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

function back_to_1(){
	
		var cont = $('#admin_content');
		$.get('<?php echo site_url('/'). 'sell/step1/'.$bus_id.'/?'.$type_str;?>', function(data) {
			  cont.removeClass('loading_img').html(data);
			  
		});
	
}



<?php
 /**
++++++++++++++++++++++++++++++++++++++++++++
//PHOTOS
++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++	
 */
 ?> 

			 
	  //Show gallery after upload success
	  function make_primary(id){
	  
			  $.ajax({
				  type: 'get',
				  cache:false,
				  url: '<?php echo site_url('/')?>trade/make_primary_image/<?php echo $product_id;?>/'+id ,
				  success: function (data) {
					   
					   $('#item_photos').find('a.btn-success').addClass('hide');
					   $('#img_'+id).append('<a class="btn btn-mini btn-success" style="margin:5px 5px 0 0;"><i class="icon-ok icon-white"></i> FEATURED</a>');
  
				  }
			  });	
			  
	  }	 
		 
	  //Show gallery after upload success
	  function show_images(id , str){

          if(str == 'products'){
              $.ajax({
                  type: 'get',
                  cache:false,
                  url: '<?php echo site_url('/')?>trade/show_all_product_images/'+id +'',
                  success: function (data) {

                      $('#item_photos').html(data);


                  }
              });


          }else{

              $.ajax({
                  type: 'get',
                  cache:false,
                  url: '<?php echo site_url('/')?>trade/show_all_product_images/'+id +'?classifieds=true',
                  success: function (data) {

                      $('#citem_photos').html(data);


                  }
              });
          }

			  
	  }

	function delete_product_img(id){
	  
		$('#modal-product-img-delete').appendTo("body").unbind('show').bind('show', function() {
			//var id = $(this).data('id'),
				removeBtn = $(this).find('.btn-primary'),
				href = removeBtn.attr('href');
				removeBtn.attr('href','javascript:delete_product_img_do('+id+')');		
				removeBtn.click(function(e) { 
				
				});
		}).modal({ backdrop: true });
	}
	
	function delete_product_img_do(id){	 
		 //gallery images
		  $.post('<?php echo site_url('/')?>trade/product_img_delete/'+id , { cache: false } ,  function(data) {
					 
				
				$('#product_gallery_msg').html(data);
				$('#modal-product-img-delete').modal('hide');
				$('#img_'+id).hide();
				
						 
			});
	}
	
function rotate_img(angle, filename, id, str){
            
            $("#rotate_btn_"+id).addClass('disabled');
            $('#pro_img_att_'+id).attr('src', '<?php echo base_url('/');?>img/deal_place_load.gif').css('height','130px');
            if(str == ''){
                final1 = 'src=<?php echo base_url('/').'assets/products/images/';?>'+filename+'&w=190&h=130';
                delete_thumb_cache(final1);
            }else{
                
                final1 = 'src=<?php echo base_url('/').'assets/products/images/';?>'+filename+'&w=190&h=130&ed='+str;
                delete_thumb_cache(final1);
                
            }
            
            final = 'src=<?php echo base_url('/').'assets/products/images/';?>'+filename+'&w=190&h=130';
            delete_thumb_cache(final);

            $.ajax({
                type: 'get',
                url: '<?php echo site_url('/').'my_images/rotate_trade/';?>'+angle+'/'+filename+'/'+str ,
                success: function (data) {
                    var obj = jQuery.parseJSON( data );
                    $('#pro_img_att_'+id).attr('src', obj.src);
                    $("#rotate_btn_"+id).attr("onclick", "rotate_img(90, '"+filename+"', "+id+", '"+obj.old+"')").removeClass('disabled');
                }
            }); 
    }
	function delete_thumb_cache(str){
		
				
				$.ajax({
					type: 'get',
					url: '<?php echo base_url('/').'img/delete_thumb.php?';?>'+str ,
					success: function (data) {
						
						$('#msg').html(data);
						
					}
				});	
	}

    function change_select(id){

        if(id == 0){

            //$('#sel_bus_yes').fadeOut();
            //$('#sel_bus_none').delay(500).fadeIn();
            slide_to(1);

        }else if(id == 1){

           // $('#sel_bus_none').fadeOut();
            //$('#sel_bus_yes').delay(500).fadeIn();
            slide_to(1);
        //CHANGE TO SELECT
        }else if(id == 2){

            $('#sel_bus_none').fadeOut();
            $('#sel_bus_yes').delay(500).fadeIn();



        }



    }


    function slide_to(step){

        var minstep = step - 1;
        var maxstep = step + 1;
		//$('.slide').addClass('animated slideOutLeft');
        $('#step'+minstep).addClass('animated slideOutLeft').fadeOut();
        $('#step'+maxstep).addClass('animated slideOutLeft').fadeOut();
        if(step == 5){
			$('.top').slideUp();
		}
		
		if(minstep > 0 || minstep == -1)
        {	
			$('#step'+maxstep).addClass('animated slideOutLeft');
            $('.help-text').delay(500).fadeOut();
			
		}else if(step == -2 || step == 5){
			$('#step0').addClass('animated slideOutLeft');
			$('.help-text').delay(500).fadeOut();
			$('.top').delay(500).slideUp();
        }else if(minstep == 0){
			
			$('.help-text').fadeIn();
		}

        window.setTimeout(function(){
            $('#step'+step).addClass('animated slideInRight').removeClass('hide');
            $('#step'+minstep).addClass('hide').removeClass('animated slideOutLeft');
            $('#step'+maxstep).addClass('hide').removeClass('animated slideOutLeft');
			//$('.slide').removeClass('animated slideOutLeft');
        }, 1000);
		console.log(step+' '+ minstep+' '+maxstep);
    }



    function load_ajax_classified_cat(id, name ,bus_id, type){
		
		$('#cl_cat_id').val(id);	
	
	}

    function finish_up(v,str) {
		
		if(str == 'classifieds'){
			$('.upsell').html('Finalizing').addClass('disabled');
			$.getJSON('<?php echo site_url('/'). 'sell/finish_classifieds/';?>'+$('#product_id').val(), function (data) {
			   if(data.success){
	
	
				   $('#finish_modal').on('show.bs.modal', function (event) {
	
					   $('#finish_body').html(data.html);
	
						window.setTimeout(function(){
	
							window.location.href = '<?php echo site_url('/'). 'sell/lookup/?nmh_classifieds=true';  ?>';
	
						}, 5000);
	
	
	
				   });
	
				   $('#finish_modal').modal({show : true, backdrop: 'static', keyboard: false});
	
	
	
			   }
			}); 
			
		}else{
			
			$('.upsell').html('Finalizing').addClass('disabled');

			$.getJSON('<?php echo site_url('/'). 'sell/finish_classifieds_product/';?>'+$('#product_id').val(), function (data) {
			   if(data.success){
	
				   $('#finish_modal').on('show.bs.modal', function (event) {
	
					   $('#finish_body').html(data.html);
	
					   window.setTimeout(function(){
	
						   window.location.href = '<?php echo site_url('/'). 'sell/lookup/?nmh_classifieds=true';  ?>';
	
					   }, 5000);
	
	
	
				   });
	
				   $('#finish_modal').modal({show : true, backdrop: 'static', keyboard: false});
				   
			   }
			});

			
			
		}

    }


    window.onbeforeunload = function() {

        show_loading();

    };

    function show_loading(){

        $('#pre_load').fadeIn();

    }

</script>


    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo base_url('/');?>js/blueimp/vendor/jquery.ui.widget.js" ></script>
    <!-- The Templates plugin is included to render the upload/download listings -->
    <script src="<?php echo base_url('/');?>js/blueimp/tmpl.min.js"></script>
    <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
    <script src="<?php echo base_url('/');?>js/blueimp/load-image.min.js"></script>
    <!-- The Canvas to Blob plugin is included for image resizing functionality -->
    <script src="<?php echo base_url('/');?>js/blueimp/canvas-to-blob.min.js"></script>

    <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.iframe-transport.js"></script>
    <!-- The basic File Upload plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload.js"></script>
    <!-- The File Upload processing plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-process.js"></script>
    <!-- The File Upload image preview & resize plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-image.js"></script>
    <!-- The File Upload audio preview plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-audio.js"></script>
    <!-- The File Upload video preview plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-video.js"></script>
    <!-- The File Upload validation plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-validate.js"></script>
    <!-- The File Upload user interface plugin -->
    <script src="<?php echo base_url('/');?>js/blueimp/jquery.fileupload-ui.js"></script>

    <!-- The XDomainRequest Transport is included for cross-domain file deletion for IE 8 and IE 9 -->
    <!--[if (gte IE 8)&(lt IE 10)]>
    <script src="<?php echo base_url('/');?>js/blueimp/cors/jquery.xdr-transport.js"></script>
    <![endif]-->


</body>
</html>