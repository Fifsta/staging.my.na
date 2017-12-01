 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	
	 $header['metaD'] = $heading. '. Find ' . $heading .' online - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 
	 $header['metaD'] = '';
	 $header['section'] = '';
	 
 }
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
	<style type="text/css">
		.dataTables_paginate {text-align:right}
		div.thumbnail:hover{opacity:0.9; cursor:pointer; border:4px solid #093;margin-top:-3px}
		strong.text-danger{color:#BD362F;}
        .popover-content p{padding:5px 0; line-height:15px}
		
	</style>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui-noscript.css"></noscript> 
    <script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/jquery.rating.css">
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
       <div class="container-fluid" id="home_container">
       	 <div class="clearfix" style="height:20px;"></div>
 		 <div class="row-fluid" >
         		 <div class="span12">
                     <div class="row-fluid">

                         <div class="text-center">
                             <?php
                             //+++++++++++++++++
                             //LOAD SEARCH BOX
                             //+++++++++++++++++
                             $data['bus_id'] = $bus_id;

                             //BUSINESS OR PRIVATE
                             if($bus_id == 0){

                                 echo '<div style="min-height:90px"  id="select_holder">';

                                 $selB = $this->my_na_model->get_businesses(0, 'my_trade');
                                 echo '<div class="row-fluid" id="sel_bus_none">

                                            <div class="span12 text-left">

                                                <img src="'. $this->my_na_model->get_user_avatar_str('60','60').'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse">'. $this->session->userdata('u_name').'</a>
                                                <a href="javascript:void(0)" onclick="change_select()"><i class="icon-pencil"></i></a>
                                            </div>

                                       </div>
                                ';

                                 echo '<div class="row-fluid hide" id="sel_bus_yes">
                                        <div class="span5 text-right">

                                            <img src="'. $this->my_na_model->get_user_avatar_str('60','60').'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                            <a class="btn btn-inverse" onclick="change_select()">'. $this->session->userdata('u_name').'</a>
                                        </div>
                                        <div class="span2">
                                            <h1 style="margin-top:20px">OR</h1>
                                        </div>
                                        <div class="span5 text-left">
                                            '.$selB.'
                                        </div>
                                    </div>
                                ';

                                 echo '</div>';

                             }else{

                                 echo '<div style="min-height:90px" id="select_holder">';

                                 $selB = $this->my_na_model->get_businesses($bus_id, 'my_trade');
                                 echo '<div class="row-fluid" id="sel_bus_none">

                                            <div class="span12 text-left">

                                                <img src="'. $this->my_na_model->get_business_logo($bus_id, 60, 60, $logo).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-inverse">'. $business_name.'</a>
                                                <a href="javascript:void(0)" onclick="change_select()"><i class="icon-pencil"></i></a>
                                            </div>

                                       </div>
                                ';

                                 echo '<div class="row-fluid hide" id="sel_bus_yes">
                                        <div class="span5 text-right">

                                            <img src="'. $this->my_na_model->get_user_avatar_str('60','60').'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                            <a class="btn btn-inverse" href="'.site_url('/').'sell/my_trade/0/">'. $this->session->userdata('u_name').'</a>
                                        </div>
                                        <div class="span2">
                                            <h1 style="margin-top:20px">OR</h1>
                                        </div>
                                        <div class="span5 text-left">
                                            '. $selB.'
                                        </div>
                                    </div>
                                ';

                                 echo '</div>';




                             }



                             //HEading Box

                             ?>
                         </div>
                     </div>



                        <ul class="breadcrumb">
                            <li><a href="<?php echo site_url('/');?>members/">My Account</a> <span class="divider">/</span></li>
                            <li><a href="<?php echo site_url('/');?>members/home/"><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></a> <span class="divider">/</span></li>
                            <li><a href="<?php echo site_url('/');?>sell/my_trade/<?php echo $bus_id;?>/">My Buy and Sell</a></li>
                            <?php if($bus_id != 0 && $business_name != ''){?>
                            <li><span class="divider">/</span> <?php echo $business_name;?></li>

                            <?php }?>
                        </ul>

                 </div>


         </div>

	     <div class="row-fluid">

		     <div class="span3">
			     <h2 class="upper na_script">My Buy and Sell</h2>
		     </div>
		     <div class="span9">
			     <div class="navbar">
				     <div class="navbar-inner" style="margin:0;padding:0">
					     <div class="container">
						     <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
							     <span class="icon-bar"></span>
							     <span class="icon-bar"></span>
							     <span class="icon-bar"></span>
						     </a>

						     <div class="nav-collapse navbar-responsive-collapse in collapse" style="height: auto;">
							     <ul class="nav">
								     <!-- .nav, .navbar-search, .navbar-form, etc -->

								     <!--<li><a href="#load_qr" onClick="load_tab(<?php /*echo $bus_id;*/?>,'load_qr')" data-toggle="tab" title="Utilize your quick response code" rel="tooltip"><i class="icon-qrcode"></i> QR code</a></li>-->
								     <li><a href="#enquiries"  onClick="load_mail(<?php echo $bus_id;?>,'all')" data-toggle="tab" title="Go to your message inbox" rel="tooltip"><div class="notification_bus_msg_count">
											<?php if($bus_id != 0){ $this->my_na_model->msg_notifications_business($bus_id);}?></div>
										     <i class="icon-envelope"></i> Enquiries</a></li>
								     <li><a href="<?php echo site_url('/').'sell/index/'.$bus_id;?>" title="List a new product" rel="tooltip"><i class="icon-plus"></i> <span class="notification-small btn-success">New!</span>List an Item</a></li>
								 </ul>

						     </div>
					     </div>
				     </div>
			     </div>
	        </div>
	     </div>

		 <div class="row-fluid">
         		<div class="span3">
                	<div class="padding10">
                    <ul class="nav nav-tabs nav-stacked">
        				<li class="nav-header">My Buy and Sell</li>
                        <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/live/';?>">All Items <i class="icon-chevron-right pull-right"></i></a></li>
                        <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/sold/';?>">Sold Items <i class="icon-chevron-right pull-right"></i></a></li>
                        <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/bought/';?>">Items Ive bought <i class="icon-chevron-right pull-right"></i></a></li>

        				<li class="nav-header">Add a new Item</li>
                        <li><a href="<?php echo site_url('/').'sell/index/'.$bus_id;?>"><span class="notification-small btn-success">New!</span>List a new Item <i class="icon-chevron-right pull-right"></i></a></li>
                        
                        <?php if($bus_id == 0){?>
                        	
                            <li class="nav-header">Watchlist</li>
                            <li><a href="<?php echo site_url('/').'sell/my_trade/'.$bus_id.'/watchlist/';?>">My watchlist <i class="icon-chevron-right pull-right"></i></a></li>
                            <li class="nav-header">Dashboard</li>
                            <li><a href="<?php echo site_url('/').'members/';?>">Dashboard <i class="icon-chevron-right pull-right"></i></a></li>
                        <?php }else{ ?>
							<li class="nav-header">Dashboard</li>
							<li><a href="<?php echo site_url('/').'members/business/'.$bus_id;?>">Dashboard <i class="icon-chevron-right pull-right"></i></a></li>
							
						<?php }?>
                    </ul>    
                    </div>
                </div>
                <div class="span9">

                    <div class="padding10 white_box" id="admin_content">
                    
                      <?php 
                     
                    		if($section == 'watchlist'){
								$this->trade_model->load_watchlist();
								
							}else{
								$this->sell_model->get_client_products($bus_id, $section);
								
							}
										 
                     //HEading Box
                     ?>
                  </div>
               </div>   
        </div>
 		 <div class="row-fluid" >
         
             
        </div>        	   


        <div class="row-fluid">
 
				 <div class="span12">
                     
         		</div> 
         </div>

         
               	
	 </div> 
     <!-- /container - end content --> 
	 <div class="clearfix" style="height:100px;"></div>

	    <div class="modal hide fade" id="modal-product-question">
		    <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			    <h3>Product Questions</h3>
		    </div>
		    <div class="modal-body" id="product_q_div">

		    </div>
		    <div class="modal-footer">
			    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

		    </div>
	    </div>

 <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?> 
     <div class="msg_div" id="msg"></div>
      
 </div>
 <iframe id="export_frame" allowtransparency="1" frameborder="0" style="width:0;height:0"></iframe>
    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<link href="<?php echo base_url('/');?>css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" /> 
<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" src="<?php echo base_url('/');?>js/bootstrap-datepicker.js" ></script>
<script src="<?php echo base_url('/');?>js/print_page.js"></script>  
<script type="text/javascript">
	$(document).ready(function()
    {
        $('[rel=tooltip]').tooltip();
        $.getScript("<?php echo base_url('/');?>js/jquery.rating.pack.js", function ()
        {
            //console.log('poes');
            $("input .star").rating().fadeIn();

        });
        //window.scrollTo(0,$('#anchor_me').offset().top);
        $('.item_editor').redactor({

            buttons: [
                'formatting', '|', 'bold', 'italic', 'deleted', '|',
                'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
                'alignment', '|', 'horizontalrule'
            ]
        });

        <!-- Print Page -->
        $(".btnPrint").printPage({

            url: "<?php echo site_url('/');?>trade/print_products/"+<?php echo $bus_id; ?>+
            "/"+$(".btnPrint").attr('data-section'),
            attr: "href",
            message: "Your document is being created"
        });

        <!-- Print Single Page -->
        $(".btnPrint_single").printPage({

                //url: "<?php echo site_url('/');?>trade/print_product/" + $(this).data('id'),
                attr: "href",
                message: "Your document is being created"
        });




        $('.btnExport').bind('click', function(){

	        $('#export_frame').attr("src", "<?php echo site_url('/');?>trade/print_pdfs/"+<?php echo $bus_id; ?>+"/"+$(".btnExport").attr('data-section'));

        });

	    $('.btnCsv').bind('click', function(){

				$('#export_frame').attr("src", "<?php echo site_url('/');?>csv/export_products/"+<?php echo $bus_id; ?>+"/"+$(".btnCsv").attr('data-section'));

	    });

       /* $('.review_p_btn').on('mouseover',function(e){

            var x = $(this);
            x.focus();
            x.popover({
                placement:"top",html: true,trigger: "manual",
                title: x.data('title'), content:x.data('content')});
            x.popover('show');
            setTimeout(function() {
                x.popover('hide');
            }, 3000);
           *//* $('html, body').animate({
                scrollTop: (x.offset().top - 200)
            }, 300);*//*
        });*/

        $('#product_table tbody tr').hover(function(e){

            var x = $(this);
            var bbody = '<div><img src="'+x.data('image')+'"><strong>'+x.data('title')+'</strong><p>'+x.data('content')+'</p></div>';


            x.focus();
            x.popover({
                placement:"top",html: true, trigger: "manual",
                title: x.data('title'), content:bbody});
            x.popover('show');
           /* setTimeout(function() {
                x.popover('hide');
            }, 3000);*/


        },function(){
            $(this).popover('hide');
        });




        $('.review_p_btn').hover(

            function(e){
                var x = $(this);
                x.focus();
                x.popover({
                    placement:"top",html: true, trigger: "manual",
                    title: x.data('title'), content:x.data('content')});
                x.popover('show');
                setTimeout(function() {
                    x.popover('hide');
                }, 3000);
            },
            function(e){
                $('.popover',this).css({display: 'none'});
            }

        );

	});
	function load_msg(id,bus_id,status){
		var div = $('#admin_content');
		div.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'tna_mail/view_msg_business/';?>'+id+'/'+bus_id+'/'+status ,
			success: function (data) {
				div.removeClass('loading_img');
				div.html(data);
			}
		});

	}


	function load_mail(bus_id,str){
		var x = $('#admin_content');
		x.empty();
		x.addClass('loading_img');
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'tna_mail/load_mail/';?>'+bus_id+'/'+str ,
			success: function (data) {
				x.removeClass('loading_img');
				x.html(data);
				$('#example1').dataTable( {
					"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_"
					},
					"aaSorting":[],
					"bSortClasses": false

				} );
				load_notification();
			}
		});

	}

    function change_select1(){

        $('#select_holder').fadeToggle();
        //$('#sel_bus_yes').delay(500).fadeToggle();

    }

    function change_select(){

        $('#sel_bus_none').fadeToggle();
        $('#sel_bus_yes').delay(500).fadeToggle();

    }
</script>


</body>
</html>