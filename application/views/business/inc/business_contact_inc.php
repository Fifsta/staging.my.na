<div class="heading">
	<h2 data-icon="fa-envelope-o">Contact <strong>Agency</strong></h2>
</div>

<section role="tabpanel" class="tab-pane active" id="Contact-Agent">
	<div class="row">
		<div class="col-xl-4 col-lg-4">
			<div>
			<address>
			  <br>	
		      <strong><?php echo ucwords($BUSINESS_NAME);?></strong><br>
		      <?php echo $BUSINESS_PHYSICAL_ADDRESS;?><br />
		      <abbr title="Phone">P:</abbr> <?php echo $BUSINESS_TELEPHONE;?><br />
		      <abbr title="Cellphone">C:</abbr> <?php echo $BUSINESS_CELLPHONE;?><br />
		      <abbr title="Fax">F:</abbr> <?php echo $BUSINESS_FAX;?><br />
		    </address>
			</div>
			<hr>
			<?php echo $this->business_model->get_qr_vcard($ID,'220','220');?>
		</div>

		<div class="col-xl-8 col-lg-8">
			<form action="<?php echo site_url('/')?>business/contact/<?php echo $ID;?>" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">

				  <div class="form-group">
				    <label for="name">Full Name</label>
				    <input type="text" class="form-control" name="name" id="name" placeholder="eg: John Smith">
				  </div>

				 <div class="form-group">
				    <label for="email">Email address</label>
				    <input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
				    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				 </div>

				  <div class="form-group">
				    <label for="exampleTextarea">Message/Enquiry:</label>
				    <textarea class="form-control" id="msg" name="msg" rows="3"></textarea>
				  </div>

				<!--ROBOT CAPTCHA!!!-->
				<button type="submit" class="btn btn-primary btn-lg" id="contactbut" data-icon="fa-envelope-o">Send Message</button>
					
				<div class="spacer"></div>
			</form>
		</div>
	
	</div>

</section>



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
