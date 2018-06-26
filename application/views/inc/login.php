<?php if($this->session->userdata('id') === NULL) { ?>
<!--login-->
<section class="sidenav" id="my_login">

    <div style="padding:10px">
        <div class="form-group" style="font-size:16px">
            <strong>My Account</strong>
            <a data-toggle="collapse" href="#collapse_login" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-chevron-down text-dark pull-right"></i></a>
        </div>
        <div class="collapse show" id="collapse_login">
            <form class="form-signin" method="post" action="<?php echo site_url('/'); ?>members/login/">
                <input type="hidden" name="redirect" id="redirect" value="<?php echo site_url('/') . uri_string(); ?>">

    			<div class="form-group">
    				<strong>Login to your Account</strong>
                    <input type="text" class="form-control" name="email" id="email_lgn" placeholder="Email address">
                </div>

                <div class="form-group">   
                     <input type="password" class="form-control" name="pass" id="pass_lgn" placeholder="Password">
                </div>

                <label class="checkbox"> <input type="checkbox" value="remember-me"> Remember me </label>
    			
    			<div class="form-group" style="position:relative"> 
                    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-scope="email"  data-auto-logout-link="false"></div>
                    <button class="btn btn-dark pull-right" type="submit"><i class="fa fa-lock text-white"></i> <b>Sign in</b></button>
    			</div>

    			<div class="form-group"> 
                	
            	</div>
                
                <small><a href="<?php echo site_url('/'); ?>members/" class="pull-left muted">Forgot Password?</a></small>
            </form>
        </div>
    </div>
    <hr>
    <div>
        <a class="btn btn-block btn-dark" href="<?php echo site_url('/'); ?>members/register"><b class="text-light">Join</b> <img src="<?php echo base_url('/'); ?>images/icons/my-na-favicon.png"></a>
    </div>    
</section>
<!--login-->
<?php } ?>