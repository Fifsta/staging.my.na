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
 <link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
 <link href="<?php echo base_url('/');?>css/datatables.min.css" rel="stylesheet" type="text/css" />
 <style type="text/css">
 #loading_img{position:relative;min-height:600px}
 .loading_img{min-height:400px;width:100%;position:relative;top:0;left:0;right:0;bottom:0; z-index: 1040;
  background-color: #FFF;
    opacity: 0.8;
  filter: alpha(opacity=80);}
 
 #example_length label{margin-top:20px;}
 
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
              <li><a href="<?php echo site_url('/');?>my_admin/">Home</a></li>
              <li><a href="">Spare</a></li>
              <li class="nav-header">Logout of Account</li>
              <li><a href="<?php echo site_url('/');?>my_admin/logout">Logout</a></li>
            </ul>
          </div>
          
          <h1>My Namibia Admin <small>Compose a SMS</small></h1>
             <ul class="breadcrumb">
              <li><a href="<?php echo site_url('/');?>my_admin/">My Admin</a> <span class="divider">/</span></li>
              <li><a href="#">Build Newsletter</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
      
      	
      <div class="row-fluid">
      <form id="sendmail" target="load_frame"  name="sendmail" method="post" action="<?php echo site_url('/');?>my_admin/send_sms" >
       <div class="span4">
           

                <div>
                    <ul class="nav nav-tabs nav-stacked">
                    <li class="nav-header">My Admin</li>
                          <li><a href="<?php echo site_url('/');?>my_admin/home/">General Info<i class="icon-chevron-right pull-right"></i></a></li>

                          <li class="nav-header">Communicate</li>
                          <li class="active"><a href="<?php echo site_url('/');?>my_admin/build_mail/">Compose Newsletter<i class="icon-chevron-right pull-right"></i></a></li>
                          <li><a href="<?php echo site_url('/');?>my_admin/emails/">Newsletters<i class="icon-chevron-right pull-right"></i></a></li>
                          <li><a href="<?php echo site_url('/');?>my_admin/sms/">SMS Service<i class="icon-chevron-right pull-right"></i></a></li>
                          <li class="nav-header">Select recipients</li>
                   
                    </ul>
                    
                </div>

       		<div id="div_recipients">
            <?php //$this->admin_model->show_email_recipients('business');?>
       	 	</div>
        </div>
      
      
        <div class="span8">
       
        	
                  <?php if(isset($error)){ ?>
                    <div class="alert alert-error">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error; ?>
                    </div>
                    <?php
                    }//end error
                    if(isset($basicmsg)){ ?>
                    <div class="alert alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $basicmsg; ?>
                    </div>
                    <?php
                    }
                    ?>
                
          <div class="loading_img" id="loading_img">
              <div id="msg"></div>
                   
              
              <h3>My Namibia Admin <small>Compose a SMS</small></h3>
                    
                    <div class="alert alert-block">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>Notice!</h4>
                 Remember you only have 160 characters in an SMS message
                </div>
                <div class="btn-group">
                  <button class="btn">Recipients</button>
                  <button class="btn dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu">
                    <li><a tabindex="-1" onClick="select_rec('users');" href="javascript:void(0);">Users</a></li>
                    <li><a tabindex="-2" onClick="select_rec('business');" href="javascript:void(0);">Businesses</a></li>
                    <li><a tabindex="-3" onClick="select_rec('ntb');" href="javascript:void(0);">NTB Members</a></li>
                    <li><a tabindex="-4" onClick="select_rec('han');" href="javascript:void(0);">HAN Members</a></li>

                  </ul>
                </div>

                <div style="height:20px;" class="clearfix"></div>

                  <div class="row-fluid">

                      <div class="span6">

                      </div>
                      <div class="span6">

                      </div>

                  </div>


               <div id="admin_content">    
                    
                      <input type="text" class="span8" style="font-size:22px;line-height:32px;height:40px;padding:5px" onKeyDown="$('#title').popover('destroy');" id="number" name="number" value="<?php if(isset($title)){ echo $title;}else{ echo '';}?>" placeholder="Number...0811237777" />
                      <input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
                      <input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
                      <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $this->session->userdata('admin_id');?>">
                      <input type="hidden" id="email_id" name="email_id" value="<?php if(isset($email_id)){ echo $email_id;}else{ echo '0';}?>">
                      <input type="hidden" id="bus_id" name="bus_id" value="<?php if(isset($bus_id)){ echo $bus_id;}else{ echo '0';}?>">
                      <textarea id="redactor_content" style="width:98%;min-height:50px" rows="3" name="content"><?php if(isset($body)){ echo $body;}else{ echo '';}?></textarea>
                      <div class="badge" id="text_count">0/160</div>
                      <br />
                      <button type="submit" id="send_mail_btn" class="btn btn-large pull-right"><i class="icon-envelope"></i> Send SMS</button>
                      <a href="javascript:preview();" class="btn btn-large pull-right" style="margin-right:10px;"><i class="icon-check"></i> Preview</a>
              		
              </div>
              <iframe  allowtransparency="true" name="load_frame" id="load_frame" frameborder="0" src="" style="width:100%;display:none"></iframe>
          </div>

            <div class="row-fluid" id="logs">



            </div>




        </div>
       <div class="clearfix" style="height:30px;"></div>
       
       </form>
      </div><!--end Row -->
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      <div id="push"></div>
    </div>
 <a id="preview_button" style="display:none;position:fixed;top:20px;z-index:99999;clear:both; right:50px;" onClick="javascript:$('#preview').slideUp();$('#admin_content').slideDown();$('#preview_button').hide()" class="btn pull-right"><i class="icon-remove"></i> Close Preview</a>
 <iframe id="preview" style="display:none;position:fixed;top:40px;bottom:0;left:0;right:0;z-index:9999; background:#fff; width:100%; height:100%" allowtransparency="true" frameborder="0"></iframe>
 <?php 
 //+++++++++++++++++
 //MODAL HTML
 //+++++++++++++++++
 ?>  
   
<div id="modal-email" class="modal hide fade">
    <div class="modal-header">
      <a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="close">&times;</a>
      <h3>Send Emails?</h3>
    </div>
    <div class="modal-body">
     Are you sure you want to send the email to the selected recipients?
     <div id="result_cover"></div>
        	<p id="result_msg"></p> 
            <div class="progress progress-striped active" id="barcover" style="display:none">
                <div class="bar bar-warning" id="barProgress" style="width: 0%;"></div>
     		</div>
    </div>
    <div class="modal-footer">
      <a href="#" id="send_email_yes" class="btn btn-primary">Yes, Send</a>
      <a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="btn secondary">Close</a>
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
    <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
<script type="text/javascript" language="javascript" src="<?php echo base_url('/');?>js/jquery.dataTables.min.js"></script>
    
<script data-cfasync="false" type="text/javascript">
var save = true;
$(document).ready(
	function()
	{
		/*$('#redactor_content').redactor({


                buttons: [
                    'html', '|'
                ],

                focus: true

		});*/
		$('[rel=tooltip]').tooltip();
	 	var loading = $('#loading_img');
		loading.removeClass('loading_img');

//        /select_rec('business');


        $('#send_mail_btn').bind('click', function(e){

            e.preventDefault();
            if(!$('#number').val().length == 0){

                $('#modal-email').bind('show', function() {

                    $('#send_email_yes').unbind('click').click( function() {

                        var bar = $('#barcover .bar'),  loading = $('#loading_img');
                        var barcover = $('#barcover');
                        var frm = $('#sendmail');
                        barcover.show();

                        $('#send_email_yes').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');

                        $.ajax({
                            type: 'post',
                            cache: false,
                            data: frm.serialize(),
                            dataType: 'json',
                            url: '<?php echo site_url('/').'my_admin/send_sms/';?>' ,
                            success: function (data) {
                                //barcover.hide();
                                if(data.success){

                                    $('#result_cover').html(data.success);
                                    $('#send_email_yes').html('Send');
                                }else{

                                    $('#result_cover').html(data.error);
                                    $('#send_email_yes').html('Send');
                                }

                            }
                        });

                    });

                })
                    .modal({ backdrop: true });
            }else{

                $('#number').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Number Required", content:"Please provide a Namibian number."});
                $('#number').popover('show');
                $('#number').focus();

            }

        });
        $('#sendmail :input').change(function() {

            save = false;
            console.log(save);
        });
        $('#redactor_content').live('click', function() {

            save = false;
            console.log(save);
        });
        $('#redactor_content').keyup( function() {

            save = false;
            console.log(save);
        });

        $('#redactor_content').on('keyup', function() {

            count_chars();
            console.log('wohoo');
        });

        //count_chars();

    }
);


function count_chars(){

    var leng = $('#redactor_content'), div = $('#text_count');
    console.log(leng.html().length);
    var lc = leng.val().replace('/^[a-z0-9]+$/i','').length;
    if(lc > 160){

        leng.popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Too many Characters", content:"There are only 160 characters to utilize in a SMS."});
        leng.popover('show');
        leng.focus();
        div.html(lc+' /160').addClass('badge-important');

    }else{
        div.html(lc+' /160').removeClass('badge-important');
        leng.popover('destroy');
    }


}


function strip_tags(input, allowed) {
    //  discuss at: http://phpjs.org/functions/strip_tags/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Luke Godfrey
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    //    input by: Pul
    //    input by: Alex
    //    input by: Marc Palau
    //    input by: Brett Zamir (http://brett-zamir.me)
    //    input by: Bobby Drake
    //    input by: Evertjan Garretsen
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Onno Marsman
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Eric Nagel
    // bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Tomasz Wesolowski
    //  revised by: Rafał Kukawski (http://blog.kukawski.pl/)
    //   example 1: strip_tags('<p>Kevin</p> <br /><b>van</b> <i>Zonneveld</i>', '<i><b>');
    //   returns 1: 'Kevin <b>van</b> <i>Zonneveld</i>'
    //   example 2: strip_tags('<p>Kevin <img src="someimage.png" onmouseover="someFunction()">van <i>Zonneveld</i></p>', '<p>');
    //   returns 2: '<p>Kevin van Zonneveld</p>'
    //   example 3: strip_tags("<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>", "<a>");
    //   returns 3: "<a href='http://kevin.vanzonneveld.net'>Kevin van Zonneveld</a>"
    //   example 4: strip_tags('1 < 5 5 > 1');
    //   returns 4: '1 < 5 5 > 1'
    //   example 5: strip_tags('1 <br/> 1');
    //   returns 5: '1  1'
    //   example 6: strip_tags('1 <br/> 1', '<br>');
    //   returns 6: '1 <br/> 1'
    //   example 7: strip_tags('1 <br/> 1', '<br><br/>');
    //   returns 7: '1 <br/> 1'

    allowed = (((allowed || '') + '')
        .toLowerCase()
        .match(/<[a-z][a-z0-9]*>/g) || [])
        .join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
    var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
        commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
    return input.replace(commentsAndPhpTags, '')
        .replace(tags, function($0, $1) {
            return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
        });
}


function select_rec(str){
	
	    var content = $('#div_recipients');
		content.fadeOut();
		content.addClass('loading_img');
	
		$.ajax({
			type: 'post',
			cache: false,
			data:{mailbody: str},
			url: '<?php echo site_url('/').'my_admin/show_email_recipients/';?>'+str ,
			success: function (data) {
				
				content.html(data);
				content.removeClass('loading_img');
				content.fadeIn();
			}
		});	
	
}


function preview(){
	
	    var content = $('#admin_content'), str = $('#redactor_content').val(), loading = $('#loading_img'), preview = $('#preview');
		content.slideUp();
		loading.addClass('loading_img');

        //preview.attr('src', "<?php echo site_url('/').'my_admin/preview_news/?mailbody=';?>"+encodeURIComponent(str));
       // preview.slideDown();
        //$('#preview_button').fadeToggle();

        loading.removeClass('loading_img');
		$.ajax({
         type: 'post',
         cache: false,
         data:{mailbody: str},
         url: '<?php echo site_url('/').'my_admin/preview_news/?mailbody=';?>' ,
         success: function (data) {
             $('#preview_button').show();
             //preview.attr('src', data);
             //loading.removeClass('loading_img');
             preview.slideDown();

             var doc = document.getElementById('preview').contentWindow.document;
             doc.open();
             doc.write(data);
             doc.close();

             }
         });
	
}


function add_image(str){

    var editor = $('.redactor-editor');
    //loading.addClass('loading_img');
    var str = '<img src="<?php echo base_url('/');?>img/email/'+str+'" width="580" height="500" alt="Download images to View"/>';
    editor.append(str);
    //loading.removeClass('loading_img');

}





<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//TIMELINE SCROLL SPY
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
//TimeLine Navigation

  	
</script>

</body>
</html>