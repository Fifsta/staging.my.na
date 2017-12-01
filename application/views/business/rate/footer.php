<script  type="text/javascript">

    <?php //test QUERY STRING
    $qstr = '';
    if($qstr = $this->input->get()){
        $qstr = http_build_query($qstr);
    }
    ?>
	$(document).ready( function(){
			<!--NAVIGATION-->
			$.get( "<?php echo site_url('/');?>my_na/nav/?url=<?php echo site_url('/'). uri_string().'/?'.$qstr;?>", function( data ) {
			  	if(data == 'FALSE'){

				}else{

					$('#navbar').html( data );
				}

			});
	});

</script>

<script>

var base_url = "<?php echo base_url('/');?>";

var bus_id = "<?php echo $bus_id;?>";
    function clearme(x){
        x.value = '';
    }

    function show_reviews(){

        var reviews = $('#plugin_myna_reviews').fadeIn();
        var rating = $('#plugin_myna_rating').fadeOut();
        var container = $('#place_hold_div_my_na').css("height", "360px");
        var minbtn = $('#widget_btn_min');


    }

    function toggle_widget(str){


        if(str == 'reviews'){

            var rating = $('#plugin_myna_rating').hide();
            var reviews = $('#plugin_myna_reviews').fadeIn();
            var minbtn = $('#widget_toggle_btn').attr("href","javascript:toggle_widget('rating')");

        }else{

            var reviews = $('#plugin_myna_reviews').hide();
            var rating = $('#plugin_myna_rating').fadeIn();
            var minbtn = $('#widget_toggle_btn').attr("href","javascript:toggle_widget('reviews')");

        }


    }

    function show_rating(){

        var reviews = $('#plugin_myna_reviews').fadeOut();
        var rating = $('#plugin_myna_rating').fadeIn();
        var container = $('#place_hold_div').css("height", "410px");

    }

    function btn_action(){



        $("#btn_submit").click(function(e) {
            e.preventDefault();
            var frm = $("#login_frm");
            $(this).html("Processing...");
            $.ajax({
                type: "post",
                url: base_url+"rate/login/" ,
                data: frm.serialize(),
                success: function (data) {
                    $("#msg").html(data);
                    $("#btn_submit").html('<i class="icon-lock icon-white"></i> Sign in');

                }
            });
        });

    }



    function submit_review(){

		var  c_id = $('#client_id_s');
		console.log('footer submit: Client ID: '+c_id.val());
		if(c_id.val() == 0){
			
			var name = $('#new_user_credfname'), email = $('#new_user_credsignup_email');
			
			var v = grecaptcha.getResponse();
			if(v.length == 0)
			{
				$("#review_msg").html('<div class="alert alert-danger">Are you a robot? Please complete the captcha above.</div>');
				return false;
			}else{
				
				if(name.val().length < 2){
					var x = name;
					x.focus();
					x.popover({
						placement:"top",html: true,trigger: "manual",
						title:"Full name required", content:"Please provide us with your full name"});
					x.popover('show');
					setTimeout(function() {
						x.popover('hide');
					}, 3000);
					$('html, body').animate({
						scrollTop: (x.offset().top - 200)
					}, 300);
					
				}else if(email.val().length == 0){
					
					var x = email;
					x.focus();
					x.popover({
						placement:"top",html: true,trigger: "manual",
						title:"Email required", content:"Please provide us with a valid email address"});
					x.popover('show');
					setTimeout(function() {
						x.popover('hide');
					}, 3000);
					$('html, body').animate({
						scrollTop: (x.offset().top - 200)
					}, 300);
					
				}else{
					  var frm = $("#reviewfrm, #new_user_cred");
					  $('#email_').val(email);
					  $("#reviewbut").html("Processing...");
					  $.ajax({
						  type: "post",
						  url: "<?php echo site_url('/');?>rate/submit_review_ajax/<?php echo $bus_id;?>/" ,
						  data: frm.serialize(),
						  success: function (data) {
							  $("#review_msg").html(data);
							  $("#reviewbut").html('<i class="icon-comment"></i> Submit Review');
							  $("input .star").rating().fadeIn();
						  }
					  });
					
					
				}
				
			}
			
			
		}else{
			  var frm = $("#reviewfrm");
			  $("#reviewbut").html("Processing...");
			  $.ajax({
				  type: "post",
				  url: "<?php echo site_url('/');?>rate/submit_review_ajax/<?php echo $bus_id;?>/" ,
				  data: frm.serialize(),
				  success: function (data) {
					  $("#review_msg").html(data);
					  $("#reviewbut").html('<i class="icon-comment"></i> Submit Review');
					  $("input .star").rating().fadeIn();
				  }
			  });
			
		}


    }

    function pass_update(){

        $('#pass_update').slideToggle();
        window.setTimeout(scroller(), 1000)


    }
    function scroller(){

        window.scrollTo(0,$('#anchor').offset().top);
    }

</script>

</body>
</html>