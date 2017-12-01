 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 if(isset($heading)){
 
	 $header['title'] = $heading . ' - My Namibia';
	 $header['metaD'] = $heading. '. Find ' . $heading .' online - My Namibia';
	 $header['section'] = '';
	 
 }else{
	
	 $header['title'] = '';
	 $header['metaD'] = '';
	 $header['section'] = '';
	 
 }
 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
 	<link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="<?php echo base_url('/');?>css/blueimp/jquery.fileupload-ui-noscript.css"></noscript> 
    
	 <style type="text/css">
     .white_box{
         
        -webkit-transition: margin 100ms ease-in-out;
        -moz-transition: margin 100ms ease-in-out;
        -o-transition: margin 100ms ease-in-out;
         
     }
     
     #deal_content  .white_box:hover{
    
        margin-top:-2px;
    
    
        -moz-box-shadow:      0 0 10px #000;
        -webkit-box-shadow:  0 0 10px #000;
        box-shadow:         0 0 10px #000;
        
         
     }
     
     
     </style>
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
         
         	
			  <?php 
             //+++++++++++++++++
             //LOAD SEARCH BOX
             //+++++++++++++++++
             
             $this->load->view('inc/home_search_new');
			 
			 //HEading Box
             ?>
             
        </div>
        
        
        <div class="row-fluid">
			  <?php 
             //+++++++++++++++++
             //SHOW FEATURE SLIDER
             //+++++++++++++++++
			 //$this->trade_model->show_feature(0, 'main');

             ?>
         	   
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
			    

        </div>
		
   
      
        
        <div class="row">
                  
         	 	<?php 
				/*SIDEBAR
				span 3 for Sidebar content
				*/
				
				?> 
				 <div class="span9 white_box">

        				<!-- The file upload form used as target for the file upload widget -->
                        <form id="fileupload" action="<?php echo site_url('/')?>trade/add_product_images_blueimp/" method="POST" enctype="multipart/form-data">
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                            <noscript><input type="hidden" name="redirect" value=""></noscript>
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="row-fluid fileupload-buttonbar">
                                <div class="span7">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-success fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Add files...</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                    <button type="submit" class="btn btn-primary start">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Start upload</span>
                                    </button>
                                    <button type="reset" class="btn btn-warning cancel">
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                        <span>Cancel upload</span>
                                    </button>
                                    <button type="button" class="btn btn-danger delete">
                                        <i class="glyphicon glyphicon-trash"></i>
                                        <span>Delete</span>
                                    </button>
                                    <input type="checkbox" class="toggle">
                                    <!-- The global file processing state -->
                                    <span class="fileupload-process"></span>
                                </div>
                                <!-- The global progress state -->
                                <div class="span5 fileupload-progress fade">
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <!-- The extended global progress state -->
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
                        </form>

         		</div>
                <div class="span3">
                    
                    
                 </div>
                
         </div> 
        
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:100px;"></div>
     	<!-- /home-bak  -->
 
      <div id="push"></div>
    </div>

    <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  

    <!-- The template to display files available for upload -->
    <script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
            </td>
            <td>
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-primary start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-warning cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
    </script>
    <!-- The template to display files available for download -->
    <script id="template-download" type="text/x-tmpl">
    </script>
    
    <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
    <script src="<?php echo base_url('/');?>js/blueimp/vendor/jquery.ui.widget.js"></script>
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
	<script type="text/javascript">
		$(function () {
			'use strict';
		
			// Initialize the jQuery File Upload widget:
			$('#fileupload').fileupload({
				// Uncomment the following to send cross-domain cookies:
				//xhrFields: {withCredentials: true},
				url: 'http://localhost/clients.my.na/trade/add_product_images'
			});
		
			// Enable iframe cross-domain access via redirect option:
			$('#fileupload').fileupload(
				'option',
				'redirect',
				window.location.href.replace(
					/\/[^\/]*$/,
					'/cors/result.html?%s'
				)
			);
		
		
				// Load existing files:
				$('#fileupload').addClass('fileupload-processing');
				$.ajax({
					// Uncomment the following to send cross-domain cookies:
					//xhrFields: {withCredentials: true},
					url: $('#fileupload').fileupload('option', 'url'),
					dataType: 'json',
					context: $('#fileupload')[0]
				}).always(function () {
					$(this).removeClass('fileupload-processing');
				}).done(function (result) {
					$(this).fileupload('option', 'done')
						.call(this, $.Event('done'), {result: result});
				});
		   
		
		});
    
           
    </script>

</body>
</html>