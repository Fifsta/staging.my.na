<div class="container-fluid">
	<?php if(isset($reviews) && $reviews != ''){?>

		<div class="row-fluid">

			<div class="span12">

				<?php echo $reviews;?>
			</div>
		</div>

	<?php }
	$h2 = '';
	if(!$logged_in){

		$h2 = '<span class="yellow">Step 2:</span> ';
	}
	?>

	<div class="row-fluid">

		<div class="span12">
			<h4><?php echo $h2;?> Your Rating</h4>
			<form id="reviewfrm" name="reviewfrm" method="post" action="<?php echo site_url('/');?>rate/submit_review/<?php echo $bus_id;?>">
				<div class="row-fluid">
					<div class="span5 text-right">

						Wow Factor

					</div>
					<div class="span7">

						<input name="WOW_FACTOR" type="radio" value="1" class="star hide"/>
						<input name="WOW_FACTOR" type="radio" value="2" class="star hide"/>
						<input name="WOW_FACTOR" type="radio" value="3" class="star hide"/>
						<input name="WOW_FACTOR" type="radio" value="4" class="star hide"/>
						<input name="WOW_FACTOR" type="radio" value="5" class="star hide"/>

					</div>
				</div>

				<div class="row-fluid">
					<div class="span5 text-right">

						Value For Money

					</div>
					<div class="span7">

						<input name="VALUE_FOR_MONEY" type="radio" value="1" class="star hide"/>
						<input name="VALUE_FOR_MONEY" type="radio" value="2" class="star hide"/>
						<input name="VALUE_FOR_MONEY" type="radio" value="3" class="star hide"/>
						<input name="VALUE_FOR_MONEY" type="radio" value="4" class="star hide"/>
						<input name="VALUE_FOR_MONEY" type="radio" value="5" class="star hide"/>

					</div>
				</div>

				<div class="row-fluid">
					<div class="span5 text-right">

						Location

					</div>
					<div class="span7">

						<input name="LOCATION" type="radio" value="1" class="star hide"/>
						<input name="LOCATION" type="radio" value="2" class="star hide"/>
						<input name="LOCATION" type="radio" value="3" class="star hide"/>
						<input name="LOCATION" type="radio" value="4" class="star hide"/>
						<input name="LOCATION" type="radio" value="5" class="star hide"/>

					</div>
				</div>

				<p class="muted"><small>Share your experience in a couple of words</small></p>
				<input type="hidden" value="<?php echo $client_id;?>" name="client_id" />
				<input type="hidden" value="<?php echo $type;?>" name="type" />
				<textarea rows="3"  class="redactor" id="reviewtxt" name="reviewtxt"></textarea>
				<br />
				<div id="review_msg"></div>
				<div class="row-fluid">
					<div class="span5 text-right">

						<img src="<?php echo base_url('/');?>img/icons/affiliation.png" title="Proudly Partnered With" rel="tooltip"/>


					</div>
					<div class="span7">

						<a href="javascript:void(0)" id="reviewbut" onclick="submit_review()" class="btn pull-right"><i class="icon-comment"></i> Submit Review</a>

					</div>
				</div>

			</form>
			<div class="clearfix" style="height:5px;"></div>
		</div>
	</div>
</div>
<script type="text/javascript">

	window.setTimeout(function(){
		btn_action();
	},1000);
	function btn_action(){


		$("#btn_submit").click(function(e) {
			e.preventDefault();
			var frm = $("#login_frm");
			$(this).html("Processing...");
			$.ajax({
				type: "post",
				url: "<?php echo site_url('/');?>members/login/" ,
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