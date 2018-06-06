<h2 class="tab-head">Submit Review</h2>

<form id="reviewfrm" name="reviewfrm" method="post" action="<?php echo site_url('/');?>rate/submit_review/<?php echo $bus_id;?>">

	<input type="hidden" value="<?php echo $client_id;?>" name="client_id" />
	<input type="hidden" value="<?php echo $type;?>" name="type" />

	<div class="row">
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Service</h4>
			<input name="SERVICE" type="radio" value="1" class="star hide"/>
			<input name="SERVICE" type="radio" value="2" class="star hide"/>
			<input name="SERVICE" type="radio" value="3" class="star hide"/>
			<input name="SERVICE" type="radio" value="4" class="star hide"/>
			<input name="SERVICE" type="radio" value="5" class="star hide"/>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Value For Money</h4>
			<input name="VALUE_FOR_MONEY" type="radio" value="1" class="star hide"/>
			<input name="VALUE_FOR_MONEY" type="radio" value="2" class="star hide"/>
			<input name="VALUE_FOR_MONEY" type="radio" value="3" class="star hide"/>
			<input name="VALUE_FOR_MONEY" type="radio" value="4" class="star hide"/>
			<input name="VALUE_FOR_MONEY" type="radio" value="5" class="star hide"/>
		</div>	
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Sleep Quality</h4>
			<input name="SLEEP_QUALITY" type="radio" value="1" class="star hide"/>
			<input name="SLEEP_QUALITY" type="radio" value="2" class="star hide"/>
			<input name="SLEEP_QUALITY" type="radio" value="3" class="star hide"/>
			<input name="SLEEP_QUALITY" type="radio" value="4" class="star hide"/>
			<input name="SLEEP_QUALITY" type="radio" value="5" class="star hide"/>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Cleanliness</h4>
			<input name="CLEANLINESS" type="radio" value="1" class="star hide"/>
			<input name="CLEANLINESS" type="radio" value="2" class="star hide"/>
			<input name="CLEANLINESS" type="radio" value="3" class="star hide"/>
			<input name="CLEANLINESS" type="radio" value="4" class="star hide"/>
			<input name="CLEANLINESS" type="radio" value="5" class="star hide"/>
		</div>	
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Location</h4>
			<input name="LOCATION" type="radio" value="1" class="star hide"/>
			<input name="LOCATION" type="radio" value="2" class="star hide"/>
			<input name="LOCATION" type="radio" value="3" class="star hide"/>
			<input name="LOCATION" type="radio" value="4" class="star hide"/>
			<input name="LOCATION" type="radio" value="5" class="star hide"/>
		</div>	
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Rooms</h4>
			<input name="ROOMS" type="radio" value="1" class="star hide"/>
			<input name="ROOMS" type="radio" value="2" class="star hide"/>
			<input name="ROOMS" type="radio" value="3" class="star hide"/>
			<input name="ROOMS" type="radio" value="4" class="star hide"/>
			<input name="ROOMS" type="radio" value="5" class="star hide"/>
		</div>	
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Food &amp; Beverage</h4>
			<input name="FOOD_N_BEVERAGES" type="radio" value="1" class="star hide"/>
			<input name="FOOD_N_BEVERAGES" type="radio" value="2" class="star hide"/>
			<input name="FOOD_N_BEVERAGES" type="radio" value="3" class="star hide"/>
			<input name="FOOD_N_BEVERAGES" type="radio" value="4" class="star hide"/>
			<input name="FOOD_N_BEVERAGES" type="radio" value="5" class="star hide"/>
		</div>
		<div class="col-xs-6 col-sm-4 col-md-3">
			<h4>Facilities</h4>
			<input name="FACILITIES" type="radio" value="1" class="star hide"/>
			<input name="FACILITIES" type="radio" value="2" class="star hide"/>
			<input name="FACILITIES" type="radio" value="3" class="star hide"/>
			<input name="FACILITIES" type="radio" value="4" class="star hide"/>
			<input name="FACILITIES" type="radio" value="5" class="star hide"/>
		</div>												
	</div>
	<hr> 
	<div class="row">
		<div class="col-sm-12 col-md-6">
			<strong>Share your experience in a couple of words</strong>
			<textarea class="form-control" id="reviewtxt" name="reviewtxt" rows="5"></textarea>
			<button type="button" class="btn btn-primary btn-block" id="reviewbut" onclick="submit_review()" data-icon="fa-comment-o">Submit Review</button>
		</div>
		<div class="col-sm-12 col-md-6">
			<strong>Make sure your review will be approved</strong>
			<div class="well well-sm">
				<ul>
					<li>be clear & concise</li>
					<li>if you had a bad experience, try to offer constructive suggestions – remember everyone has a bad day</li>
					<li>refrain from using peoples names</li>
					<li>refrain from swearing</li>
				</ul>
			</div>
			<img src="<?php echo base_url('/');?>images/icons/affiliation.png" title="Proudly Partnered With" rel="tooltip"/>
		</div>
		
		<div id="review_msg"></div>
	</div>

</form>

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