
	  
<div class="row-fluid">
     <div class="span12">

        <form id="reviewfrm" name="reviewfrm" enctype="application/x-www-form-urlencoded" method="post" action="<?php echo site_url('/').'trade/review_participant_do/';?>/">
        <input type="hidden" name="client_id" value="<?php echo $client_id;?>"/>
            <input type="hidden" name="buy_now_id" value="<?php echo $buy_now_id;?>"/>
            <input type="hidden" name="seller_id" value="<?php echo $seller_id;?>"/>
        <input type="hidden" name="bus_id" value="<?php echo $bus_id;?>"/>
        <input type="hidden" name="product_id" value="<?php echo $product_id;?>"/>
        <input type="hidden" name="type" value="<?php echo $type;?>"/>
            <div class="controls">

                    <p>Review the <?php echo $type;?> (On a scale of 1 to 5, with 5 being the best)</p>

                    <input name="star1" type="radio" value="1" class="star hide"/>
                    <input name="star1" type="radio" value="2" class="star hide"/>
                    <input name="star1" type="radio" value="3" class="star hide"/>
                    <input name="star1" type="radio" value="4" class="star hide"/>
                    <input name="star1" type="radio" value="5" class="star hide"/>

                    <br />
                    <span class="help-block" style="font-size:11px">Please provide us with honest feedback. Things to consider are communication, response times and professionalism.</span>

                    <textarea rows="3" class="redactor span12" id="reviewtxt" name="reviewtxt"  placeholder="Review the <?php echo $type; ?> here"></textarea>
                    <span class="help-block" style="font-size:11px">Share your trading experience with us. Please notify us of any strange behavious and suspicous activity.</span>
                    <br />
                    <button type="submit" id="review_p_but" class="btn pull-right btn-inverse"><i class="icon-comment icon-white"></i> Submit Review</button>

                    <div class="clearfix" style="height:35px;"></div>
                    <div id="review_p_msg"></div>

            </div>


        </form>
     </div>
</div>

<script data-cfasync="false" type="text/javascript">


$(document).ready(function(){
    //$("input .star").rating();
    $("#review_p_but").on("click", function(e) {
        e.preventDefault();
        var frm = $("#reviewfrm");
        console.log(frm);
        $("#review_p_but").html("Working...");
        $.ajax({
            type: "POST",
            url: "<?php echo site_url("/");?>trade/review_participant_do/<?php echo $buy_now_id.'/'.rand(9999,99999);?>" ,
            data: frm.serializeArray(),
            success: function (data) {
                $("#review_p_msg").html(data);
                $("#review_p_but").html('<i class="icon-comment icon-white"></i> Submit Review');
                $("input .star").rating().fadeIn();
            }
        });
    });


    $.getScript("<?php echo base_url('/');?>js/jquery.rating.pack.js", function ()
    {
        //console.log('poes');
        $("input .star").rating().fadeIn();

    });
});

</script>