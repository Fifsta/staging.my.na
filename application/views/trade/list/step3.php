<?php
//+++++++++++++++++++++++++++++++++
//STEP 3 Photos
//+++++++++++++++++++++++++++++++++

$str = '';
if (isset($bus_id) && $bus_id != 0) {

    $str = ' for Business';

    $all_link = site_url('/') . 'members/business/' . $bus_id . '/';

} else {

    $all_link = site_url('/') . 'members/my_products/';

}
?>
<div id="anchor_me"></div>

<div class="spacer"></div>


    <div class="heading">
        <h2 data-icon="fa-list">Product <strong>Photos</strong></h2>
        <ul class="options">
            <small class="clearfix">Please add some photos</small>
        </ul>
    </div>
    <br>


    <div class="card">
        <div class="card-body">
            <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i class="fa fa-check text-dark"></i></a>
            <a href="<?php echo site_url('/') . 'sell/update_product/' . $product_id . '/'; ?>" class="btn btn-warning disabled step2" style="margin:5px"> 2 Details <i class="fa fa-check text-dark"></i></a>
            <a href="<?php echo site_url('/') . 'sell/step3/' . $product_id . '/' . $bus_id . '/'; ?>" class="btn btn-success btn-large step3" style="margin:5px"> 3 Attach Photos  <i class="fa fa-chevron-right text-light"></i></a>
            <a href="<?php echo site_url('/') . 'sell/step4/' . $product_id . '/' . $bus_id . '/'; ?>" class="btn btn-dark disabled step4" style="margin:5px"> 4 Extras <i class="fa fa-chevron-right text-light"></i></a>
            <a href="<?php echo site_url('/') . 'sell/step5/' . $product_id . '/' . $bus_id . '/'; ?>" class="btn btn-dark disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="fa fa-chevron-right text-light"></i></a>

            <hr>

            <!-- The file upload form used as target for the file upload widget -->
            <form id="fileupload" action="<?php echo site_url('/') ?>trade/add_product_images/" method="POST" enctype="multipart/form-data">

                <div class="alert alert-secondary"><i class="fa fa-question-circle-o pull-right text-dark"></i><strong>Why Photos?</strong> Items
                    with a proper description and detailed photos sell far quicker than ones without because the buyer can see
                    what the product looks like
                </div>

                <!-- Redirect browsers with JavaScript disabled to the origin page -->
                <noscript><input type="hidden" name="redirect" value=""></noscript>

                <input type="hidden" name="bus_id" value="<?php if (isset($bus_id)) { echo $bus_id; } else { echo '0'; } ?>">

                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="col-md-7">
                        <!-- The fileinput-button span is used to style the file input field as button -->

                        <span class="btn btn-dark fileinput-button">
                            <i class="fa fa-plus text-light"></i>
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

                        <!-- The global file processing state -->
                        <span class="fileupload-process"></span>
                    </div>
                    <hr>
                    <!-- The global progress state -->
                    <div class="col-md-5 fileupload-progress fade">

                        <!-- The global progress bar -->
                        <!--<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="bar bar-warning" style="width:0%;"></div>
                        </div>-->

                        <div class="progress">
                          <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <!-- The extended global progress state -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>

                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-responsive">
                    <tbody class="files"></tbody>
                </table>


                <h4 style="font-size:18px"><strong>Existing Photos</strong></h4>
                <div id="product_gallery_msg"></div>
                <div class="col-md-12"><div id="item_photos"><?php $this->trade_model->show_all_product_images($product_id); ?></div></div>
                <div class="clearfix">&nbsp;</div>
                <div class="alert alert-secondary"><i class="fa fa-question-circle-o pull-right text-dark"></i> <strong>Featured Image?</strong> 
                    To set the primary image for the product please click on the image itself and see the green check icon appear.
                </div>
            </form>

            <hr>
            <a href="javascript:void(0);" onclick="proceed_to_4();" id="proceed_to_4" class="btn btn-lg btn-success pull-right">Next <i class="fa fa-chevron-right text-light"></i></a>
            <a href="<?php echo $all_link; ?>" id="back_to_all" class="btn btn-lg btn-dark pull-right" style="margin-right:5px">All Products</a>
            <a href="javascript:void(0);" onclick="back_to_2();" id="back_to_2" class="btn btn-lg btn-warning pull-right" style="margin-right:5px"><i class="fa fa-chevron-left text-dark"></i> Back</a>

            <div class="clearfix">&nbsp;</div>

        </div>
    </div>

<?php
/**
 * ++++++++++++++++++++++++++++++++++++++++++++
 * //DELETE GALLERY IMAGE MODAL
 * //Functions
 * ++++++++++++++++++++++++++++++++++++++++++++
 */
?>


<div class="modal fade" id="modal-product-img-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Image</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to completely remove this photo?</p>
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn">Close</button>
        <button class="btn btn-primary img-del">Remove</button>
      </div>
    </div>
  </div>
</div>

<!-- The template to display files available for upload -->
<script data-cfasync="false" id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-upload">
            <td>
                <span class="preview"></span>
            </td>
            <td>
                <p class="name">{%=file.name%}</p>
                <strong class="error text-danger"></strong>
            </td>
            <td>
                <p class="size">Processing...</p>
                <!--<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-warning" style="width:0%;"></div></div>-->
  
            </td>
            <td style="text-align:right;">
                {% if (!i && !o.options.autoUpload) { %}
                    <button class="btn btn-success start" disabled>
                        <i class="fa fa-upload"></i>
                        <span>Start</span>
                    </button>
                {% } %}
                {% if (!i) { %}
                    <button class="btn btn-danger cancel">
                        <i class="fa fa-ban"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}

                   <div class="progress">
                  <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                </div>               
            </td>
        </tr>

    {% } %}


</script>
<!-- The template to display files available for download -->
<script data-cfasync="false" id="template-download" type="text/x-tmpl">
</script>
<script type="text/javascript">
    $(function () {

        //window.scrollTo(0,0);

        $('.files').html('<tr class="drag_drop text-center"><td colspan="4"><div class="alert alert-info text-center"><p>&nbsp;</p><p>&nbsp;</p><h4>Drag and Drop Images Here</h4>Simply select images to upload and drag them onto this block<p>&nbsp;</p><p>&nbsp;</p></div></td></tr>');


        'use strict';

        // Initialize the jQuery File Upload widget:
        $('#fileupload').fileupload({
            // Uncomment the following to send cross-domain cookies:
            //xhrFields: {withCredentials: true},
            url: '<?php echo site_url('/');?>trade/add_product_images',

            stop: function (e) {
                $('div.fileupload-progress').fadeOut();
                show_images(<?php echo $product_id;?>);
            },

        });

        // Enable iframe cross-domain access via redirect option:
        $('#fileupload').fileupload(
            'option',
            'redirect',
            window.location.href.replace(
                /\/[^\/]*$/,
                '<?php echo site_url('/');?>js/blueimp/result.html?%s'
            )
        );

        $('#fileupload').fileupload('option', {
            url: '<?php echo site_url('/');?>trade/add_product_images',
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
                url: '<?php echo site_url('/');?>trade/add_product_images',
                type: 'HEAD'
            }).fail(function () {
                $('<div class="alert alert-danger"/>')
                    .text('Upload server currently unavailable - ' +
                    new Date())
                    .appendTo('#fileupload');
            });
        }

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


        $('#fileupload').bind('fileuploadadd', function (e, data) {

            $('.drag_drop').fadeOut();
        });


    });


    function proceed_to_4() {

        var img = $('#item_photos'), pre = $('td span.preview');

        if (img.find('img').length == 0) {
            if (pre.find('canvas').length == 0) {

                var x = $('.fileinput-button');
                x.focus();
                /*x.popover({
                    placement: "top",
                    html: true,
                    trigger: "manual",
                    title: "No Images Added",
                    content: "Please select some photos here and upload them. <br /><br /><p class='text-center'><a href='javascript:void(0);' class='btn btn-block btn-mini btn-inverse' onclick='proceed_to_4_go()'>Skip For now</a></p>"
                });
                x.popover('show');
                setTimeout(function () {
                    x.popover('hide');
                }, 4000);
                $('html, body').animate({
                    scrollTop: (x.offset().top - 200)
                }, 300);*/
                proceed_to_4_go();

            } else {

                /*var x = $('#start_up');
                x.focus();
                x.popover({
                    placement: "top",
                    html: true,
                    trigger: "manual",
                    title: "No Images Uploaded",
                    content: "The images have not been uploaded. Please click here to upload <br /><br /><p class='text-center'><a href='javascript:void(0);' class='btn btn-mini btn-inverse' onclick='proceed_to_4_go()'>Skip For now</a></p>"
                });
                x.popover('show');
                setTimeout(function () {
                    x.popover('hide');
                }, 4000);
                $('html, body').animate({
                    scrollTop: (x.offset().top - 200)
                }, 300);*/
                proceed_to_4_go();

            }

        }else if(pre.find('canvas').length > 0){
            /*var x = $('#start_up');
            x.focus();
            x.popover({
                placement: "top",
                html: true,
                trigger: "manual",
                title: "No Images Uploaded",
                content: "The images have not been uploaded. Please click here to upload <br /><br /><p class='text-center'><a href='javascript:void(0);' class='btn btn-mini btn-inverse' onclick='proceed_to_4_go()'>Skip For now</a></p>"
            });
            x.popover('show');
            setTimeout(function () {
                x.popover('hide');
            }, 4000);
            $('html, body').animate({
                scrollTop: (x.offset().top - 200)
            }, 300);*/

            proceed_to_4_go();

        }
        else
        {


            proceed_to_4_go();


        }

    }


    function proceed_to_4_go(){

        var cont = $('#admin_content').addClass('slideLeft'), btn = $('#proceed_to_4');
        btn.html('Working...');
        $.get('<?php echo site_url('/'). 'sell/step4/'.$product_id.'/'. $bus_id;?>', function (data) {
            cont.removeClass('slideLeft').html(data);
            btn.html('Next <i class="icon-chevron-right icon-white"></i>');
        });


    }


    <?php
       /**
      * ++++++++++++++++++++++++++++++++++++++++++++
      * //BACK
      * ++++++++++++++++++++++++++++++++++++++++++++
       */
       ?>

    function back_to_2() {

        var cont = $('#admin_content').addClass('slideLeft'), btn = $('#back_to_2');
        btn.html('Working...');
        $.get('<?php echo site_url('/'). 'sell/update_product/'.$product_id;?>', function (data) {
            cont.removeClass('slideLeft').html(data);
            btn.html('<i class="icon-chevron-left icon-white"></i> Back');
            $('[rel=tooltip]').tooltip();
            //window.scrollTo(0,$('#anchor_me').offset().top);

        });

    }
</script>
 
    