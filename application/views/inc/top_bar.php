<!--<div id="pre_load">
	<div>
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
	</div>
</div>-->
<header id="header" class="grad-orange">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<div class="slogo">
					<a href="#"><img src="images/logo-main.png"></a>
					<div>find • list • buy • sell</div>
				</div>
			</div>
			<div class="col-sm-8">
			
				<form class="input-group input-group-lg">
					<div class="find input-group-addon">Find:</div>
					<input type="text" class="form-control" id="exampleInputAmount" placeholder="Pizza, Lodge, Plumbing, ... etc">
					<div class="near input-group-addon">Near:</div>
					<input type="text" class="near form-control" id="exampleInputAmount" placeholder="Windhoek">
					<span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search" role="button"></button></span>
				</form>
				
				<div class="history">Search history: <a href="#">pizza</a>, <a href="#">lodge</a>, <a href="#">plumbing</a>, <a href="#">paper towels</a>, <a href="#">shoes</a>,</div>
			</div>
			<div class="col-sm-2 text-right">
				<div class="dropdown">
				  <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    My Account
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
							<li style="width:290px" class="clearfix">
                                <div style="padding:20px">
                                    <form class="form-signin" method="post"
                                          action="<?php echo site_url('/'); ?>members/login/">
                                        <input type="hidden" name="redirect" id="redirect"
                                               value="<?php echo site_url('/') . uri_string(); ?>">
                                        <input type="text" class="input-block-level" name="email" id="email_lgn"
                                               placeholder="Email address">
                                        <input type="password" class="input-block-level" name="pass" id="pass_lgn"
                                               placeholder="Password">
                                        <label class="checkbox">
                                            <input type="checkbox" value="remember-me"> Remember me
                                        </label>

                                        <div class="fb-login-button" data-max-rows="1" data-size="medium"
                                             data-show-faces="false" data-scope="email" onlogin="checkLoginState()"
                                             data-auto-logout-link="false"></div>
                                        <button class="btn btn-inverse pull-right" type="submit"><i
                                                class="icon-lock icon-white"></i> <b>Sign in</b></button>
                                        <small>
                                            <a href="<?php echo site_url('/'); ?>members/"
                                               class="pull-left muted">Forgot Password?</a>
                                        </small>
                                    </form>
                                </div>
                            </li>
                            <li class="nav-header">Create Free account</li>
                            <li>
                                <div style="padding:5px 20px">
                                    <a class="btn btn-block btn-inverse"
                                       href="<?php echo site_url('/'); ?>members/register"><b>Join</b> <img
                                            src="<?php echo base_url('/'); ?>img/icons/my-na-favicon.png"></a>
                                </div>
                            </li>
				  </div>
				</div>
			</div>
		</div>
	</div>
</header>
