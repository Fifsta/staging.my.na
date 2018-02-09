<div class="row"><div class="col-md-12"><h2 class="tab-head">Asked Questions</h2></div></div>
<div class="row">
  <div class="col-sm-8">
    
    <?php echo $this->trade_model->get_product_questions($product_id); ?>
    
  </div>

  <div class="col-sm-4">

    <?php if($this->session->userdata('id')) { ?>
    <form action="<?php echo site_url('/')?>trade/contact/" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">
      <input type="hidden" name="product_title" value="<?php echo $product_title;?>"/>
      <input type="hidden" name="client_id" value="<?php echo $client_id;?>"/>
      <input type="hidden" name="bus_id" value="<?php echo $bus_id;?>"/>
      <input type="hidden" name="product_id" value="<?php echo $product_id;?>"/>

      <h2 class="tab-head">Ask the Seller a Question</h2>
      <div class="form-group">
        <label for="FullName">Full Name</label>
        <input id="FullName" name="name" class="form-control input-sm" placeholder="Full Name">
      </div>
      <div class="form-group">
        <label for="EmailAddress">Email Address</label>
        <input id="EmailAddress" name="email" class="form-control input-sm" placeholder="Email Address">
      </div>
      <div class="form-group">
        <label for="msg">Message / Enquiry</label>
        <textarea rows="3" class="form-control" id="msg" name="msg" placeholder="Ask your Question here."></textarea>
      </div>
      <!--
      <label for="EmailAddress">Security</label>
      ROBOT CAPTCHA!!!
    -->
      <button type="submit" class="btn btn-primary btn-block" id="contactbut" data-icon="fa-envelope-o">Send</button>
    </form>
    <?php } else { ?>

      <div class="alert alert-warning"><h4><strong>Please login to submit a question</strong></h4> Only My.na users can ask questions. Please register or log in to ask a question.</div>

    <?php } ?>

  </div>
</div>

<script data-cfasync="false" type="text/javascript">

  $(document).ready(function(){

    $('#contactbut').click(function(e) {

      e.preventDefault();
      var frm = $('#contact-us');
      //frm.submit();
      $('#contactbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
      $.ajax({
        type: 'post',
        url: '<?php echo site_url('/').'trade/contact/';?>' ,
        data: frm.serialize(),
        success: function (data) {

          $('#contact_msg').html(data);
          $('#contactbut').html('<i class="icon-envelope"></i> Ask Question');


        }
      });

    });

  });


</script>