<div class="text-center roiw-fluid">
<div class="alert"><h4>My Namibia &trade; CMS</h4>
Login to your website dashboard to update and maintain your website content. See your web traffic statistics and see if any new enquiries have been made</div>
<div class="clearfix" style="height:40px;">&nbsp;</div>
	<div class="span3">&nbsp;</div>
    	<div class="span6">   
           <form class="form-signin white_box" style="max-width:320px" target="_blank" method="post" action="http://cms.my.na/admin/login">
              
              <h5 class="form-signin-heading text-left">Please sign in</h5>
                <?php if(isset($error)){ ?>
                  <div class="alert alert-error">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                      <?php echo $error; ?>
                  </div>
                  <?php
                  }//end error
                  if(isset($basicmsg)){ ?>
                  <div class="alert alert-success">
                   <button type="button" class="close" data-dismiss="alert">×</button>
                      <?php echo $basicmsg; ?>
                  </div>
                  <?php
                  }
                  ?>                  
              <input type="text" class="input-block-level" name="email" id="email" placeholder="Email address">
              <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
              <label class="checkbox  text-left">
                <input type="checkbox" value="remember-me"> Remember me
              </label>
              <div class="clearfix" id="login_msg"></div>
              <button class="btn btn-inverse pull-right" id="loginbut" type="submit"><i class="icon-lock icon-white"></i> Sign in</button>
              <div class="clearfix" style="height:40px;">&nbsp;</div>
            </form>
        </div>  
    <div class="span3">&nbsp;</div>  
</div>                  
<script type="text/javascript">

/*$('#loginbut').unbind('click').click(function(e) {
		
		e.preventDefault();
		var frm = $('#claim-us');
		//frm.submit();
		$('#loginbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Logging in...');
		$.ajax({
			type: 'post',
			url: 'http://cms.my.na/admin/login' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#login_msg').html(data);
				 $('#loginbut').html('<i class="icon-lock icon-white"></i> Sign In');
				 
				 
			}
		});	

});
*/</script>