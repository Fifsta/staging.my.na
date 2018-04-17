<h2 class="tab-head">Enquiry Form</h2>
<form action="<?php echo site_url('/')?>business/contact/<?php echo $ID;?>" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">
	<div class="row">
		<div class="col-sm-4">
			<div class="form-group">
				<label for="FullName">Full Name</label>
				<input id="FullName" name="name" id="name" class="form-control input-sm" placeholder="Full Name">
			</div>
			<div class="form-group">
				<label for="EmailAddress">Email Address</label>
				<input id="EmailAddress" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label for="Enquiry">Message / Enquiry</label>
				<textarea id="msg" name="msg" class="form-control input-sm" rows="5"></textarea>
			</div>
		</div>
		<div class="col-sm-4">
			
		   <div class="form-group">
		   		<label for="EmailAddress">Security</label>
			   <div class="controls">
				   <?php $this->my_na_model->build_captcha();?>
			   </div>
		   </div>

			<button type="submit" class="btn btn-primary btn-block" id="contactbut" data-icon="fa-envelope-o">Send</button>
		</div>
		<div class="alert alert secondary" id="contact_msg"></div>
	</div>
</form>

<script type="text/javascript">

	$('#contactbut').click(function(e) {
			
		e.preventDefault();
		var frm = $('#contact-us');
		//frm.submit();
		$('#contactbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'business/contact_ajax/'.$ID.'/';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#contact_msg').html(data);
				 $('#contactbut').html('<i class="icon-envelope"></i> Send Message');
				 
				 
			}
		});	

	});

</script>
