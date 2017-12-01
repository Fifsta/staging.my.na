<?php

$data['section'] = '';
$data['heading'] = $heading;
$data['title'] = $title;
$data['metaD'] = $metaD;
$this->load->view('inc/header', $data);
$this->load->view('inc/navigation', $data);

?>
<div id="wrap">
    <div class="container" id="home_container">
            <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

            <div class="row-fluid">
                <div class="span2 text-right">

                    <img src="<?php echo base_url('/');?>img/bground/couch_idea_stickman_2.png" alt="List and buy anything namibian" />
                </div>
                <div class="span9">

                    <h1 class=" text-center"> Do You <span class="na_script big_icon yellow">Need</span> Need Some Extra <span class="na_script yellow big_icon">Cash ?</span></h1>
                    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>
                    <div class="row-fluid">

                        <div class="span4">
                            <h3 class="upper">Sell Your 2nd hand Stuff Now</h3>
                            <p>List an item in a few <span class="yellow upper">easy</span> steps and turn them into hard <span class="yellow upper">CASH</span>. Your junk is another man's <span class="yellow upper">gold</span>. Why not try it yourself today?</p>
                            <img src="<?php echo base_url('/');?>img/icons/arrow_right.png" class="pull-right" align="center" alt="As cool as" />

                        </div>
                        <div class="span3 text-center">
                            <img src="<?php echo base_url('/');?>img/bground/stick_man_money_ipad.png" alt="List and buy anything namibian" />
                        </div>
                        <div class="span5">
                            <div class="row-fluid">
                                <div class="span12" style="min-height:80px">
                                    <h3 class="upper">And Be as cool as this Dude</h3>
                                    <p>Sell your junk for hard cash and you can really be as cool as this bra.</p>
                                    <p>Give it a try, its absolutely <span class="yellow upper">FREE!</span></p>
                                    <img src="<?php echo base_url('/');?>img/icons/arrow_right.png" class="pull-right" alt="As cool as" />
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="span1">

                    <img src="<?php echo base_url('/');?>img/bground/stick_man.png" alt="List and buy anything namibian" />
                </div>
            </div>
        <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>
            <div class="row-fluid">
                <div class="span5 text-right">
                    <a class="btn btn-large btn-inverse" href="<?php echo site_url('/');?>members/register/">Join <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" > Today</a>
                </div>
                <div class="span2 text-center" style="margin-top:10px">
                    <span class="upper big_icon na_script">OR</span>
                </div>
                <div class="span5 text-left">
                    
                    <div class="fb-login-button" data-max-rows="1" onlogin="checkLoginState()" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false"></div>
                </div>
            </div>

    </div>

    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

    <div class="container-fluid footer">


        <div class="row-fluid">
            <div class="container">

                <div class="row-fluid white">
                    <div class="span1 text-right">


                    </div>
                    <div class="span7">

                        <h1 class=""><span class="na_script big_icon yellow">How</span> can I <span class="na_script big_icon yellow">make</span> some extra <span class="na_script big_icon yellow">money?</span></h1>
                        <div class="row-fluid">

                            <div class="span6">
                                <h3 class="upper">How it Works...</h3>
                                <ul>
                                    <li>1. Find an Item to sell.</li>
                                    <li>2. Take some pictures</li>
                                    <li>3. Login to My.na</li>
                                </ul>

                            </div>
                            <div class="span6">
                                <h3 class="upper">&nbsp;</h3>

                                <ul>
                                    <li>4. Upload the item details and photos</li>
                                    <li>5. Share it with Your Friends</li>
                                    <li>6. Sell it!</li>
                                </ul>

                            </div>
                        </div>
                    </div>
                    <div class="span4">
                        <img src="<?php echo base_url('/');?>img/icons/stick_man_moola.png" alt="List and buy anything namibian" />

                    </div>
                </div>

            </div>
        </div>

    </div>



    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>

    <div class="container">
        <?php $this->load->view('adverts/video_buy_sell');?>

    </div>

    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>



    <div class="container-fluid footer text-center">

        <div class="row-fluid">
            <div class="container white text-left">
                <?php $this->load->view('adverts/video_auction');?>
            </div>
        </div>

    </div>
    <div class="clearfix"><p>&nbsp;</p><p>&nbsp;</p></div>


    <div class="container hide">

        <div class="row-fluid ">
            <div class="span12">
                <?php
                //+++++++++++++++++
                //LOAD FORM
                //+++++++++++++++++
                //$this->load->view('inc/register_form');
                ?>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row-fluid text-center">
            <div class="span9">
                <h1 class=""><span class="na_script yellow">JOIN</span> today and enjoy <span class="na_script yellow">trading in namibia</span> for FREE Today!</h1>

            </div>
            <div class="span3 text-left">

                <a class="btn btn-large btn-inverse pull-right" href="<?php echo site_url('/');?>members/register/">Join <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" > Today</a>
            </div>
        </div>
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

