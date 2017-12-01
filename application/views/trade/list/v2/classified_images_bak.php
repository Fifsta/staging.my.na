<?php
//+++++++++++++++++++++++++++++++++
//STEP 3 Photos
//+++++++++++++++++++++++++++++++++

$str = '';
if (isset($bus_id) && $bus_id != 0) {

    $str = ' for Business';

}
?>
<div id="anchor_me"></div>
<div class="text-center">

   
    <a href="<?php echo site_url('/') . 'sell/update_product/' . $product_id . '/'; ?>"
       class="btn  btn-success disabled step2" style="margin:5px"> 1 Details <i class="icon-ok icon-white"></i></a>
    <a href="<?php echo site_url('/') . 'sell/step3/' . $product_id . '/' . $bus_id . '/'; ?>"
       class="btn btn-success disabled btn-large step3" style="margin:5px"> 2 Attach Photos/Files <i
            class="icon-chevron-right icon-white"></i></a>
 
    <a href="<?php echo site_url('/') . 'sell/step5/' . $product_id . '/' . $bus_id . '/'; ?>"
       class="btn btn-inverse disabled step5" style="margin:5px"> 3 Confirm and Publish <i
            class="icon-chevron-right icon-white"></i></a>

</div>
<div class="clearfix">&nbsp;</div>
<h4>
    <small class="clearfix">Please add some photos</small>
    CLASSIFIEDS PHOTOS<span></span></h4>
<div class="white_box padding10">
   

    <!-- The file upload form used as target for the file upload widget 
    action="<?php echo site_url('/') ?>trade/add_product_images/?classifieds=true" -->
    <form id="fileupload2" action="<?php echo $s3FormDetails['url']; ?>"  method="POST"
          enctype="multipart/form-data">
        
        <div class="alert alert-warning"><i class="icon-question-sign pull-right icon-white"></i><strong>Why Photos?</strong> Items
            with a proper description and detailed photos sell far quicker than ones without because the buyer can see
            what the product looks like
        </div>
        
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value=""></noscript>
       <!-- <input type="hidden" name="bus_id" value="<?php if (isset($bus_id)) {
            echo $bus_id;
        } else {
            echo '0';
        } ?>">-->
        <!--<input type="hidden" name="product_id" value="">-->
 		<?php foreach ($s3FormDetails['inputs'] as $name => $value) { ?>
            <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
         <?php } ?>
         <input type="hidden" name="key" value="">
         
         
        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row-fluid fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-default fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Add files...</span>
                        <input type="file" name="file" multiple>
                    </span>
                <button type="submit" class="btn btn-success start" id="start_up">
                    <i class="icon-upload icon-white"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-danger cancel">
                    <i class="icon-ban-circle icon-white"></i>
                    <span>Cancel upload</span>
                </button>
                <!--<button type="button" class="btn btn-danger delete">
                    <i class="icon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">-->
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="span5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">

                    <div class="bar bar-warning" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-responsive">
            <tbody class="files"></tbody>
        </table>


       
    </form>
    <hr/>
    <a href="javascript:void(0);" onclick="finish_classifieds();" id="proceed_to_6" class="btn btn-success pull-right animated pulse infinite">Finish Up <i
            class="icon-chevron-right icon-white"></i></a>
    <a href="<?php echo site_url('/') . 'sell/my_trade/' . $bus_id . '/'; ?>" onclick="back_to_all();" id="back_to_all"
       class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a>
    <a href="javascript:void(0);" onclick="back_to_2();" id="back_to_2" class="btn btn-warning pull-right"
       style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>

    <div class="clearfix">&nbsp;</div>
</div>



<!-- The template to display files available for upload -->
<script data-cfasync="false" id="template-upload2" type="text/x-tmpl">
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
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-warning" style="width:0%;"></div></div>
            </td>
            <td style="text-align:right;">
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-success start" disabled>
                        <i class="glyphicon glyphicon-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-danger cancel">
                        <i class="glyphicon glyphicon-ban-circle"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}

</script>
<!-- The template to display files available for download -->
<script data-cfasync="false" id="template-download2" type="text/x-tmpl">
</script>
<script type="text/javascript">
    $(function () {

        //window.scrollTo(0,0);

        $('.files').html('<tr class="drag_drop text-center"><td colspan="4"><div class="alert alert-info text-center"><p>&nbsp;</p><p>&nbsp;</p><h4>Drag and Drop Images Here</h4>Simply select images to upload and drag them onto this block<p>&nbsp;</p><p>&nbsp;</p></div></td></tr>');

// Assigned to variable for later use.
		var form = $('#fileupload2');
		var filesUploaded = [];

		// Place any uploads within the descending folders
		// so ['test1', 'test2'] would become /test1/test2/filename
		var folders = [];

		form.fileupload({
			url: form.attr('action'),
			type: form.attr('method'),
			datatype: 'json',
			add: function (event, data) {

				// Show warning message if your leaving the page during an upload.
				window.onbeforeunload = function () {
					return 'You have unsaved changes.';
				};

				// Give the file which is being uploaded it's current content-type (It doesn't retain it otherwise)
				// and give it a unique name (so it won't overwrite anything already on s3).
				var file = data.files[0];
				var filename = file.name;
				form.find('input[name="Content-Type"]').val(file.type);
				form.find('input[name="key"]').val('assets/'+filename);

				// Actually submit to form to S3.
				data.submit();

				// Show the progress bar
				// Uses the file size as a unique identifier
				var bar = $('<div class="progress" data-mod="'+file.size+'"><div class="bar"></div></div>');
				$('.progress-bar-area').append(bar);
				bar.slideDown('fast');
			},
			progress: function (e, data) {
				// This is what makes everything really cool, thanks to that callback
				// you can now update the progress bar based on the upload progress.
				var percent = Math.round((data.loaded / data.total) * 100);
				$('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', percent + '%').html(percent+'%');
			},
			fail: function (e, data) {
				// Remove the 'unsaved changes' message.
				window.onbeforeunload = null;
				$('.progress[data-mod="'+data.files[0].size+'"] .bar').css('width', '100%').addClass('red').html('');
			},
			done: function (event, data) {
				window.onbeforeunload = null;

				// Upload Complete, show information about the upload in a textarea
				// from here you can do what you want as the file is on S3
				// e.g. save reference to your server using another ajax call or log it, etc.
				var original = data.files[0];
				var s3Result = data.result.documentElement.children;
				filesUploaded.push({
					"original_name": original.name,
					"s3_name": s3Result[2].innerHTML,
					"size": original.size,
					"url": s3Result[0].innerHTML
				});
				console.log('done');
				update_img_db_classifieds(filesUploaded);
				
				//$('#uploaded').html(JSON.stringify(filesUploaded, null, 2));
			},
			success: function (event, data) {
				
				console.log('done');
				//update_img_db_classifieds(filesUploaded);
				
				//$('#uploaded').html(JSON.stringify(filesUploaded, null, 2));
			}
		});




        //'use strict';

         //Initialize the jQuery File Upload widget:
        /*$('#fileupload2').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            //url: '<?php echo site_url('/');?>trade/add_product_images?classifieds=true',
			url: '<?php echo $s3FormDetails['url']; ?>',
            stop: function (e) {
                //$('progress').fadeOut();
                //show_images($('#product_id').val());
            },

        });*/

        // Enable iframe cross-domain access via redirect option:
       /* $('#fileupload2').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '<?php echo site_url('/');?>js/blueimp/result.html?%s'
            )
        );*/

       /* $('#fileupload2').fileupload('option', {
            url: '<?php echo $s3FormDetails['url']; ?>',
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator && navigator.userAgent),
            imageMaxWidth: 1000,
            imageMaxHeight: 1000,
            imageMinWidth: 300,
            imageMinHeight: 200,
            //imageCrop: true ,// Force cropped images,
            maxNumberOfFiles: 20,
            maxFileSize: 5000000,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
        });*/
        // Upload server status check for browsers with CORS support:
        /*if ($.support.cors) {
            $.ajax({
                url: '<?php echo $s3FormDetails['url']; ?>',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                    new Date())
                    .appendTo('#fileupload2');
            });
        }*/

        // Load existing files:
        $('#fileupload2').addClass('fileupload-processing');
        /*$.ajax({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: $('#fileupload2').fileupload('option', 'url'),
            dataType: 'json',
            context: $('#fileupload2')[0]
        }).always(function () {
            $(this).removeClass('fileupload-processing');
        }).done(function (result) {
            $(this).fileupload('option', 'done')
                .call(this, $.Event('done'), {result: result});

        });*/


        $('#fileupload2').bind('fileuploadadd', function (e, data) {

            $('.drag_drop').fadeOut();
        });


    });


    function finish_classifieds() {

        $('#proceed_to_6').html('Finalizing').addClass('disabled');
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

    }
	
	 function update_img_db_classifieds(res) {
		 
		console.log(res);
       
        $.getJSON('<?php echo site_url('/'). 'sell/update_classified_img/?res=';?>'+res+'&product_id='+$('#product_id').val(), function (data) {
           if(data.success){
				console.log(data.data);
		   }
        }); 

    }
	
</script>
 
    