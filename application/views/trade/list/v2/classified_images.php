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
   

    <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload2" action="<?php echo site_url('/') ?>trade/add_product_images/?classifieds=true" method="POST"
          enctype="multipart/form-data">
        
        <div class="alert alert-warning"><i class="icon-question-sign pull-right icon-white"></i><strong>Why Photos?</strong> Items
            with a proper description and detailed photos sell far quicker than ones without because the buyer can see
            what the product looks like
        </div>
        <!-- Redirect browsers with JavaScript disabled to the origin page -->
        <noscript><input type="hidden" name="redirect" value=""></noscript>
        <input type="hidden" name="bus_id" value="<?php if (isset($bus_id)) {
            echo $bus_id;
        } else {
            echo '0';
        } ?>">
        <input type="hidden" name="product_id" value="">

        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row-fluid fileupload-buttonbar">
            <div class="span7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-default fileinput-button">
                        <i class="icon-plus icon-white"></i>
                        <span>Add files...</span>
                        <input type="file" name="files[]" multiple>
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
                <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    
                  </div>
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
    <div id="citem_photos"></div>
    <hr/>
    <a href="javascript:void(0);" onclick="slide_to(-2)" id="proceed_to_6" class="btn btn-success pull-right animated pulse infinite">Next <i
            class="fa fa-chevron-right icon-white"></i></a>
    <a href="<?php echo site_url('/') . 'sell/my_trade/' . $bus_id . '/'; ?>" onclick="back_to_all();" id="back_to_all"
       class="btn btn-inverse pull-right" style="margin-right:5px"><i class="icon-list icon-white"></i> All Products</a>
    <a href="javascript:void(0);" onclick="back_to_2();" id="back_to_2" class="btn hide btn-warning pull-right"
       style="margin-right:5px"><i class="icon-chevron-left icon-white"></i> Back</a>

    <div class="clearfix">&nbsp;</div>
</div>



<!-- The template to display files available for upload -->
<script data-cfasync="false" id="template-upload2" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload2 fade">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <div class="progress">
                  <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    
                  </div>
                </div>
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


        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#fileupload2').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '<?php echo site_url('/');?>trade/add_product_images?classifieds=true',

            stop: function (e) {
                $('div.fileupload-progress').fadeOut();
                show_images($('#product_id').val(), 'classifieds');
            },

        });

        // Enable iframe cross-domain access via redirect option:
        $('#fileupload2').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '<?php echo site_url('/');?>js/blueimp/result.html?%s'
            )
        );

        $('#fileupload2').fileupload('option', {
            url: '<?php echo site_url('/');?>trade/add_product_images?classifieds=true',
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
        });
        // Upload server status check for browsers with CORS support:
        if ($.support.cors) {
            $.ajax({
                url: '<?php echo site_url('/');?>trade/add_product_images?classifieds=true',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                    new Date())
                    .appendTo('#fileupload2');
            });
        }

        // Load existing files:
        $('#fileupload2').addClass('fileupload-processing');
        $.ajax({
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

        });


        $('#fileupload2').bind('fileuploadadd', function (e, data) {

            $('.drag_drop').fadeOut();
        });


    });



</script>
 
    