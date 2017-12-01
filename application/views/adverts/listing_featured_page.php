<?php

$data['section'] = '';
$data['heading'] = $heading;
$data['title'] = $title;
$data['metaD'] = $metaD;
$this->load->view('inc/header', $data);
$this->load->view('inc/navigation', $data);

?>
<style type="text/css">
    #form_frame{height:770px;}

    /* Small Devices, Tablets */
    @media only screen and (max-width : 768px) {
        #form_frame{height:1100px;}
    }
</style>
<div id="wrap">
    <div class="container" id="home_container">
            <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

            <div class="row-fluid">
                <div class="span1 text-right">

                   
                </div>
                <div class="span10">

                    <h1 class=" text-center"> <span class="na_script big_icon yellow">FEATURE Your</span> Listing for that <span class="na_script yellow big_icon">Extra Exposure</span></h1>
                    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>
                    <img src="<?php echo base_url('/');?>img/adverts/feature_your_products.png" />
                    <div class="row-fluid">
                        <div class="span8">
                            <p>Reach More Than 1 Million Unique Visitors on all our platforms. Your product gets the normal classifieds exposure in our national publications and newspapers.</p>
                            <p>Manage your product listing online, view stats on views enquiries and hits. Fast and effective email and SMS alerts are included at no extra cost.</p>

                        </div>
                        <div class="span4 text-right">
                            <p class="muted">All For only</p>
                            <h1 class="na_script big_icon yellow"><small class="yellow">N$</small> 99 </h1>
                            <p class="muted"><small>once off for 30 days</small></p>
                            <p><strong>Offer only valid until </strong> <?php echo date('F jS, Y', strtotime("+2 days"));?></p>
                        </div>
                    </div>
                   

                </div>
                <div class="span1">

                   
                </div>
            </div>


    </div>

    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

    <div class="container-fluid footer">


        <div class="row-fluid">
            <div class="container">

                <div class="row-fluid white">
                    <div class="span2 text-right">


                    </div>
                    <div class="span7">

                        <h1 class=""><span class="na_script big_icon yellow">How</span> do I <span class="na_script big_icon yellow">Feature</span> my <span class="na_script big_icon yellow">Listing?</span></h1>
                        <div class="row-fluid">

                            <div class="span6">
                                <h3 class="upper">How it Works...</h3>
                                <ul>
                                    <li>1. Find an Item to sell.</li>
                                    <li>2. Take some pictures</li>
                                    <li>3. Upload it yourself or Send it to us</li>
                                </ul>

                            </div>
                            <div class="span6">
                                <h3 class="upper">&nbsp;</h3>

                                <ul>
                                    <li>4. Upload the item details and photos</li>
                                    <li>5. Submit a Feature Request below</li>
                                    <li>6. Wait for buyers to contact you!</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="span3">
                        <img src="<?php echo base_url('/');?>img/icons/stick_man_moola.png" alt="List and buy anything namibian" />

                    </div>
                </div>

            </div>
        </div>

    </div>

    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

    <div class="container">

        <div class="row-fluid ">
            <div class="span12">
                <iframe id="form_frame" style="width:100%;overflow: hidden" src="<?php echo HUB_URL;?>main/subscribe/?type=featured_product" allowtransparency="true" frameborder="0"></iframe>
            </div>
        </div>
    </div>

    <div class="container">

       <!--  <div class="row-fluid text-center">
            <div class="span9">
                <h1 class=""><span class="na_script yellow">JOIN</span> today and enjoy <span class="na_script yellow">trading in namibia</span> for FREE Today!</h1>

            </div>
            <div class="span3 text-left">

                <a class="btn btn-large btn-inverse pull-right" href="<?php echo site_url('/');?>members/register/">Join <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" > Today</a>
            </div>
        </div> -->
    </div>
    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

    <?php
    //+++++++++++++++++
    //LOAD FOOTER
    //+++++++++++++++++
    $footer['foo'] = '';
    $this->load->view('inc/footer', $footer);


    ?>

</div>
<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<script src="<?php echo S3_URL;?>video/video/eh5v.files/html5video/html5ext.js" type="text/javascript"></script>
<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=2"></script>
</body>
</html>

