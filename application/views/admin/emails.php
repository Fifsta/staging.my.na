<?php
//+++++++++++++++++
//LOAD HEADER
//Prepare Variables array to pass into header
//+++++++++++++++++
$header['title'] = '';
$header['metaD'] = '';
$this->load->view('admin/inc/header', $header);

//ADDITIONAL RESOURCES
//add css, IE7 js files here before the head tag

?>
<link rel="stylesheet" href="<?php echo base_url('/'); ?>redactor/redactor/redactor.css"/>
<link href="<?php echo base_url('/'); ?>css/datatables.min.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
    #loading_img {
        position: relative;
        min-height: 600px
    }

    .loading_img {
        min-height: 400px;
        width: 100%;
        position: relative;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1040;
        background-color: #FFF;
        opacity: 0.8;
        filter: alpha(opacity=80);
    }

    #example_length label {
        margin-top: 20px;
    }

</style>

</head>
<body>

<?php
//+++++++++++++++++
//LOAD NAVIGATION
//+++++++++++++++++
$nav['section'] = 'account';
$this->load->view('inc/navigation', $nav);
?>

<!-- END Navigation -->
<!-- Part 1: Wrap all content here -->
<div id="wrap">

    <!-- Begin page content -->
    <div id="container-body" class="container-fluid white_box padding10" style="margin-top:80px;">

        <div class="row-fluid">

            <div class="span12">

                <div class="btn-group pull-right">
                    <button class="btn btn-large"><i class="icon-fire"></i> Admin Account</button>
                    <button class="btn dropdown-toggle btn-large" data-toggle="dropdown">
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li class="nav-header">Admin Navigation</li>
                        <li><a href="<?php echo site_url('/'); ?>my_admin/">Home</a></li>
                        <li><a href="">Spare</a></li>
                        <li class="nav-header">Logout of Account</li>
                        <li><a href="<?php echo site_url('/'); ?>my_admin/logout">Logout</a></li>
                    </ul>
                </div>

                <h1>My Namibia Admin
                    <small>Compose a Newsletter</small>
                </h1>
                <ul class="breadcrumb">
                    <li><a href="<?php echo site_url('/'); ?>my_admin/">My Admin</a> <span class="divider">/</span></li>
                    <li><a href="#">Build Newsletter</a> <span class="divider">/</span></li>
                    <li><?php if ($this->session->userdata('u_name')) {
                            echo ucfirst($this->session->userdata('u_name'));
                        } ?></li>
                </ul>
            </div>

        </div>


        <div class="row-fluid">
            <form id="sendmail" target="load_frame" name="sendmail" method="post"
                  action="<?php echo site_url('/'); ?>my_admin/send_email">
                <div class="span4">


                    <div>
                        <ul class="nav nav-tabs nav-stacked">
                            <li class="nav-header">My Admin</li>
                            <li><a href="<?php echo site_url('/'); ?>my_admin/home/">General Info<i
                                        class="icon-chevron-right pull-right"></i></a></li>

                            <li class="nav-header">Communicate</li>
                            <li><a href="<?php echo site_url('/'); ?>my_admin/build_mail/">Compose Newsletter<i
                                        class="icon-chevron-right pull-right"></i></a></li>
                            <li class="active"><a href="<?php echo site_url('/'); ?>my_admin/emails/">Newsletters<i
                                        class="icon-chevron-right pull-right"></i></a></li>
                            <li class="nav-header">Select recipients</li>

                        </ul>

                    </div>

                    <div id="div_recipients">
                        <?php //$this->admin_model->show_email_recipients('business');?>
                    </div>
                </div>


                <div class="span8">


                    <?php if (isset($error)) { ?>
                        <div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?php echo $error; ?>
                        </div>
                    <?php
                    }//end error
                    if (isset($basicmsg)) { ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?php echo $basicmsg; ?>
                        </div>
                    <?php
                    }
                    ?>

                    <div class="loading_img" id="loading_img">
                        <div id="msg"></div>


                        <h3>My Namibia Admin
                            <small>Newsletters</small>
                        </h3>


                        <div style="height:20px;" class="clearfix"></div>
						<div class="row-fluid">

                            <div class="span12">
                               <table class="table">
                                  <thead>
                                    <tr>
                                      <th>#</th>
                                      <th>Last 7 Days</th>
                                      <th>Last 30 Days</th>
                                      <th>Last 90 Days</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr>
                                      <td>Sends</td>
                                      <td class="7_day_sends"></td>
                                      <td class="30_day_sends"></td>
                                      <td class="90_day_sends"></td>
                                    </tr>
                                    <tr>
                                      <td>Opens</td>
                                      <td class="7_day_opens"></td>
                                      <td class="30_day_opens"></td>
                                      <td class="90_day_opens"></td>
                                    </tr>
                                    <tr>
                                      <td>Clicks</td>
                                      <td class="7_day_clicks"></td>
                                      <td class="30_day_clicks"></td>
                                      <td class="90_day_clicks"></td>
                                    </tr>
                                  </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row-fluid">

                            <div class="span12" id="content_div">
                                <?php $this->admin_model->get_emails(''); ?>
                            </div>

                        </div>

                        <iframe allowtransparency="true" name="load_frame" id="load_frame" frameborder="0" src=""
                                style="width:100%;display:none"></iframe>
                    </div>


                </div>
                <div class="clearfix" style="height:30px;"></div>

            </form>
        </div>
        <!--end Row -->
        <div class="row-fluid" id="logs">


        </div>

        <div class="row-fluid">
            <div id='response'></div>


        </div>




    </div>
    <!-- /container - end content -->
    <div class="clearfix" style="height:40px;"></div>
    <div id="push"></div>
</div>
<a id="preview_button" style="display:none;position:fixed;top:20px;z-index:99999;clear:both; right:50px;"
   onClick="javascript:$('#preview').slideUp();$('#admin_content').slideDown();$('#preview_button').hide()"
   class="btn pull-right"><i class="icon-remove"></i> Close Preview</a>
<iframe id="preview"
        style="display:none;position:fixed;top:40px;bottom:0;left:0;right:0;z-index:9999; background:#fff; width:100%; height:100%"
        allowtransparency="true" frameborder="0"></iframe>
<?php
//+++++++++++++++++
//MODAL HTML
//+++++++++++++++++
?>


<div id="modal-email-delete" class="modal hide fade">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Delete Email?</h3>
    </div>
    <div class="modal-body">
        Are you sure you want to delete the email?

    </div>
    <div class="modal-footer">
        <a href="#" id="delete_email_yes" class="btn btn-primary">Yes, Delete</a>
        <a data-dismiss="modal" aria-hidden="true" class="btn secondary">Close</a>
    </div>
</div>


<?php
//+++++++++++++++++
//LOAD FOOTER
//+++++++++++++++++
$footer['foo'] = '';
$this->load->view('members/inc/footer_backend', $footer);
?>

<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php echo base_url('/') ?>redactor/redactor/redactor.min.js?v=1"></script>
<script type="text/javascript" language="javascript"
        src="<?php echo base_url('/'); ?>js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url('/');?>js/jquery.knob.js" type="text/javascript"></script>
            <script type='text/javascript' src='https://mandrillapp.com/api/docs/js/mandrill.js'></script>
            <script type='text/javascript'>
				$(document).ready(function(e) {
                    search_m("174");
                });
                function show_tag_stats(arr, tag) {
					console.log('messages search');
                    $('#response').append('<h2>' + JSON.stringify(arr.length) + ' messages match your search</h2>');
                    if (arr.length >= 1) {
                        for (var i=0; i < arr.length; i++) {
                            console.log(arr);
							console.log('<h3>Message ' + (i+1) + ': ' + JSON.stringify(arr[i].email) + '</h3><ol>');
                            /*$('#response').append('<h3>Message ' + (i+1) + ': ' + JSON.stringify(arr[i].email) + '</h3><ol>');
                            $('#response').append('<li>Date: ' + Date(JSON.stringify(arr[i].ts) * 1000).toString() + '</li>');
                            $('#response').append('<li>Subject: ' + JSON.stringify(arr[i].subject) + '</li>');
                            $('#response').append('<li>State: ' + JSON.stringify(arr[i].state) + '</li></ol>');*/
                        }
                    }
                }
 				function load_per_tag(arr, tag) {
						 console.log(arr);
						 var x = 0, sends = 0, sbounces = 0,hbounces = 0, opens = 0, clicks = 0;
						if (arr.length >= 1) {
							for (var i=0; i < arr.length; i++) {
								var tag = arr[i].tag;
								$("#sends-"+tag).html(arr[i].sent);
								$("#opens-"+tag).html(arr[i].unique_opens);
								$("#clicks-"+tag).html(arr[i].unique_clicks);
								$("#bounces-"+tag).html(arr[i].hard_bounces);
                                $("#complaints-"+tag).html(arr[i].complaints);
                                $("#unsubs-"+tag).html(arr[i].unsubs);
							}
						}
 						
						
				}
				
				function load_totals(obj) {
					console.log(obj);

					$(".7_day_sends").html(JSON.stringify(obj.stats.last_7_days.sent));
					$(".30_day_sends").html(JSON.stringify(obj.stats.last_30_days.sent));
					$(".90_day_sends").html(JSON.stringify(obj.stats.last_90_days.sent));
					$(".7_day_opens").html(JSON.stringify(obj.stats.last_7_days.opens));
					$(".30_day_opens").html(JSON.stringify(obj.stats.last_30_days.opens));
					$(".90_day_opens").html(JSON.stringify(obj.stats.last_90_days.opens));
					$(".7_day_clicks").html(JSON.stringify(obj.stats.last_7_days.clicks));
					$(".30_day_clicks").html(JSON.stringify(obj.stats.last_30_days.clicks));
					$(".90_day_clicks").html(JSON.stringify(obj.stats.last_90_days.clicks));
				}
				
                function onErrorLog(obj) {
                    $('#response').text(JSON.stringify(obj));
                }

                // create a new instance of the Mandrill class with your API key
                var m = new mandrill.Mandrill('d3tAlotpZNobGiCfRk3Miw');

                params = {

                        "limit":"1000",
                        
                };
                // get the results for messages.search using the parameters from above

				function search_m(tag){
					console.log('going searching');
					 params = {
						"tag":tag,
                        "limit":"1000",
                        
                	};
					m.tags.list(params, function(res) {
							load_per_tag(res, tag);
						}, function(err) {
							onErrorLog(err);
						}
					);
				}
                uparams = {

                        "limit":"1000",
                       
                };
				m.users.info(uparams, function(res) {
						load_totals(res);
					}, function(err) {
						onErrorLog(err);
					}
				);
				
				
            </script>
<script data-cfasync="false" type="text/javascript">
    var save = true;
    $(document).ready(
        function () {
            $('#redactor_content').redactor({
                imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
                buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
                    'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
                    'video', 'image', 'table', '|',
                    'alignment', '|', 'horizontalrule']
            });
            $('[rel=tooltip]').tooltip();
            var loading = $('#loading_img');
            loading.removeClass('loading_img');

//        /select_rec('business');


        }
    );

    function compose_email(id) {

        if (test_save()) {

            $('#content_div').html('').addClass('loading_img');

            $.get('<?php echo site_url('/'). 'my_admin/compose_email/';?>' + id, function (data) {

                $('#content_div').html(data).removeClass('loading_img');
                $("[rel='tooltip']").tooltip();
            });
        } else {

            $('#save_btn').popover({
                delay: {show: 100, hide: 3000},
                placement: "top",
                html: true,
                trigger: "manual",
                title: "PLease Save your Work",
                content: "Do not loose your work by saving your work below."
            });
            $('#save_btn').popover('show');
            $('#save_btn').focus();

        }

    }

    function test_save() {

        if (save === true) {

            return true;

        } else {


            return false;

        }

    }

    function add_content(type, id) {

        var editor = $('.redactor-editor'), loading = $('#' + type + '_it-' + id);
        loading.addClass('loading_img');
        //build content
        $.ajax({
            type: 'get',
            cache: false,
            url: '<?php echo site_url('/').'my_admin/build_email_content/';?>' + type + '/' + id,
            success: function (data) {
                //barcover.hide();

                editor.append(data);
                loading.removeClass('loading_img');
            }
        });


    }


    function load_logs(str) {
        $('#logs').html('').addClass('loading_img');
        $.ajax({
            type: 'post',
            cache: false,
            data: {mailbody: str},
            url: '<?php echo site_url('/').'my_admin/load_email_logs/';?>' + str,
            success: function (data) {

                $('#logs').html(data);
                $('#logs').removeClass('loading_img');
                $("[rel='tooltip']").tooltip();

                $('#email_logs_tbl').dataTable({
                    "sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
                    "sPaginationType": "bootstrap",
                    "oLanguage": {
                        "sLengthMenu": "_MENU_ "
                    },
                    "aaSorting": [],
                    "bSortClasses": false

                });
                $('.dataTables_paginate').parent().removeClass('span6').addClass('span12');
                $('#subscriber_table_length').find('select').addClass('span6');
                $('#subscriber_table_length').parent().removeClass('span6').addClass('span4');
                $('#subscriber_table_filter').parent().removeClass('span6').addClass('span8');
            }
        });


    }
    function delete_email(id) {


        $('#modal-email-delete').bind('show', function () {

            $('#delete_email_yes').unbind('click').click(function () {

                $('#delete_email_yes').html('Deleting...');

                $.ajax({
                    type: 'get',
                    cache: false,
                    url: '<?php echo site_url('/').'my_admin/delete_email/';?>' + id,
                    success: function (data) {
                        //barcover.hide();
                        $('#tr-' + id).hide();
                        $('#delete_email_yes').html('Deleted');
                        $('#modal-email-delete').modal('hide');
                    }
                });

            });

        }).modal({backdrop: true});


    }


    function save_work() {
        var frm = $('#sendmail'), btn = $('#save_btn');
        btn.html('Working...');
        $.ajax({
            type: 'POST',
            cache: false,
            data: frm.serialize(),
            url: '<?php echo site_url('/').'my_admin/save_email/';?>',
            success: function (data) {
                btn.html('<i class="icon-share"></i> Save Email');
                $('#email_preview').html(data);
                save = true;
            }
        });

    }
    function get_emails(str) {

        if (test_save()) {

            $('#content_div').html('').addClass('loading_img');

            $.get('<?php echo site_url('/'). 'my_admin/get_emails/';?>' + str, function (data) {

                $('#content_div').html(data).removeClass('loading_img');
                $("[rel='tooltip']").tooltip();
            });

        } else {

            $('#save_btn').popover({
                delay: {show: 100, hide: 3000},
                placement: "top",
                html: true,
                trigger: "manual",
                title: "PLease Save your Work",
                content: "Do not loose your work by saving your work below."
            });
            $('#save_btn').popover('show');
            $('#save_btn').focus();

        }


    }
    function add_image(str) {

        var editor = $('.redactor-editor');
        //loading.addClass('loading_img');
        var str = '<img src="<?php echo base_url('/');?>img/email/' + str + '" width="580" height="500" alt="Download images to View"/>';
        editor.append(str);
        //loading.removeClass('loading_img');

    }

    /*$('#send_mail_btn').click(function(e){

     e.preventDefault();
     if(!$('#title').val().length == 0){

     $('#modal-email').bind('show', function() {

     $('#send_email_yes').unbind('click').click( function() {

     var bar = $('#barcover .bar');
     var barcover = $('#barcover');
     var frm = $('#sendmail');
     barcover.show();
     $('#send_email_yes').html('<img src="<?php //echo base_url('/').'img/load.gif';?>" /> Sending...');
     frm.attr('action','<?php //echo site_url('/').'my_admin/send_email/';?>');

     $.ajax({
     type: 'post',
     data:	frm.serialize(),
     url: frm.attr( 'action' ),
     success: function(data) {
     $('#result_cover').html(data);

     $('#send_email_yes').html('Sent');
     barcover.hide();
     }
     });

     });

     })
     .modal({ backdrop: true });
     }else{

     $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Subject Required", content:"Please give the newsletter a valid and enticing subject line."});
     $('#title').popover('show');
     $('#title').focus();

     }

     });*/




    <?php   /**
    * ++++++++++++++++++++++++++++++++++++++++++++
    * //TIMELINE SCROLL SPY
    * //Functions
    * ++++++++++++++++++++++++++++++++++++++++++++
     */
     ?>
    //TimeLine Navigation


</script>

</body>
</html>