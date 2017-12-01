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
          
          <h1>My Namibia Admin <small>Compose a Newsletter</small></h1>  
             <ul class="breadcrumb">
              <li><a href="<?php echo site_url('/');?>my_admin/">My Admin</a> <span class="divider">/</span></li>
              <li><a href="#">Build Newsletter</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
      
      	
      <div class="row-fluid">
      <form id="sendmail" target="load_frame"  name="sendmail" method="post" action="<?php echo site_url('/');?>my_admin/send_email" >
       <div class="span4">
           

                <div>
                    <ul class="nav nav-tabs nav-stacked">
                    <li class="nav-header">My Admin</li>
                          <li><a href="<?php echo site_url('/');?>my_admin/home/">General Info<i class="icon-chevron-right pull-right"></i></a></li>

                          <li class="nav-header">Communicate</li>
                          <li class="active"><a href="<?php echo site_url('/');?>my_admin/build_mail/">Compose Newsletter<i class="icon-chevron-right pull-right"></i></a></li>
                          <li><a href="<?php echo site_url('/');?>my_admin/emails/">Newsletters<i class="icon-chevron-right pull-right"></i></a></li>
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
                   
              
              <h3>My Namibia Admin <small>Compose a Newsletter</small></h3>  
                    
                    <div class="alert alert-block">
                  <button type="button" class="close" data-dismiss="alert">&times;</button>
                  <h4>Notice!</h4>
                  The US CAN-SPAM Act bans false or misleading header information (e.g. "From" and "To" emails).
                    It also bans deceptive or misleading subject lines.
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
                    <li><a tabindex="-5" onClick="select_rec('han_ntb');" href="javascript:void(0);">HAN &amp; NTB Members</a></li>

                  </ul>
                </div>

                <div style="height:20px;" class="clearfix"></div>

                  <div class="row-fluid">

                      <div class="span6">
                          <strong>Include Email Images</strong>
                          <ul class="nav nav-pills " >
                              <li><a onclick="add_image('buy_house.png')"><img src="<?php echo base_url('/');?>img/email/buy_house.png" style="width:170px"></a></li>
                              <li><a onclick="add_image('nice_ride.png')"><img src="<?php echo base_url('/');?>img/email/nice_ride.png" style="width:170px"></a></a></li>
                              <li><a onclick="add_image('sel_old_couch.png')"><img src="<?php echo base_url('/');?>img/email/sel_old_couch.png" style="width:170px"></a></a></li>
                              <li><a onclick="add_image('sell_scooter_buy_car.png')"><img src="<?php echo base_url('/');?>img/email/sell_scooter_buy_car.png" style="width:170px"></a></a></li>
                          </ul>
                      </div>
                      <div class="span6">
                          <strong>Include Email Content</strong>
                          <ul class="nav nav-tabs" id="myTab">
                              <li><a href="#business"  data-toggle="tab">Business</a></li>
                              <li><a href="#products"  data-toggle="tab">Products</a></li>
                              <li><a href="#deals" data-toggle="tab">Deals</a></li>
                              <li><a href="#settings" data-toggle="tab">Settings</a></li>
                          </ul>

                          <div class="tab-content">
                              <div class="tab-pane" id="business"></div>
                              <div class="tab-pane active" id="products">

                                  <?php $this->admin_model->get_email_content('products');?>
                              </div>
                              <div class="tab-pane" id="deals"> <?php $this->admin_model->get_email_content('deals');?></div>

                          </div>
                      </div>

                  </div>


               <div id="admin_content">    
                    
                      <input type="text" class="span8" style="font-size:22px;line-height:32px;height:40px;padding:5px" onKeyDown="$('#title').popover('destroy');" id="title" name="title" value="<?php if(isset($title)){ echo $title;}else{ echo '';}?>" placeholder="Subject..." />
                      <input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
                      <input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
                      <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id?>">
                      <input type="hidden" id="email_id" name="email_id" value="<?php if(isset($email_id)){ echo $email_id;}else{ echo '0';}?>">
                      <input type="hidden" id="bus_id" name="bus_id" value="<?php if(isset($bus_id)){ echo $bus_id;}else{ echo '0';}?>">
                      <textarea id="redactor_content" style="display:none" name="content"><?php if(isset($body)){ echo $body;}else{ echo '';}?></textarea>
                      <br />
                      <button type="submit" id="send_mail_btn" class="btn btn-large pull-right"><i class="icon-envelope"></i> Send Newsletter</button>
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

$(document).ready(
	function()
	{
		$('#redactor_content').redactor({ 	
				imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				'video','image', 'table','|',
				 'alignment', '|', 'horizontalrule']
			});
		$('[rel=tooltip]').tooltip();
	 	var loading = $('#loading_img');
		loading.removeClass('loading_img');

//        /select_rec('business');


        $('#send_mail_btn').click(function(e){

            e.preventDefault();
            if(!$('#title').val().length == 0){

                $('#modal-email').bind('show', function() {

                    $('#send_email_yes').unbind('click').click( function() {

                        var bar = $('#barcover .bar'),  loading = $('#loading_img');
                        var barcover = $('#barcover');
                        var frm = $('#sendmail');
                        barcover.show();
                        frm.attr('action','<?php echo site_url('/').'my_admin/send_email/';?>');
                        frm.attr('target','load_frame');
                        $('#send_email_yes').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');

                        $.ajax({
                            type: 'post',
                            cache: false,
                            data: frm.serialize(),
                            url: '<?php echo site_url('/').'my_admin/send_email/';?>' ,
                            success: function (data) {
                                //barcover.hide();

                                $('#result_cover').html(data);
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

        });


    }
);

function add_content(type, id){

    var editor = $('.redactor-editor'), loading = $('#'+type+'_it-'+id);
    loading.addClass('loading_img');
    //build content
    $.ajax({
        type: 'get',
        cache: false,
        url: '<?php echo site_url('/').'my_admin/build_email_content/';?>'+type+'/'+id ,
        success: function (data) {
            //barcover.hide();

            editor.append(data);
            loading.removeClass('loading_img');
        }
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