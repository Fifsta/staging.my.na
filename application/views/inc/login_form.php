
    <form class="card-block" method="post" action="<?php echo site_url('/').'members/login/';?>">

        <div class="row">
        	<div class="col-lg-6" style="margin-top:10px">
                <input type="hidden"  name="redirect" id="redirect-2" value="<?php echo site_url(). $_SERVER['REQUEST_URI'];?>">
                <input type="text" class="form-control" name="email" placeholder="Email">
            </div>
            <div class="col-lg-6" style="margin-top:10px">
            	<input type="password" name="pass"  class="form-control" placeholder="Password">
            </div>
            
        </div>
       
        <p class="pull-right" style="margin-top:10px"><button type="submit" class="btn btn-dark"><i class="fa fa-lock"></i> Sign in</button>
        &nbsp;<a class="btn btn-dark" href="<?php echo site_url('/').'members/register/';?>"><i class="fa fa-star"></i> Join My Namibia</a> 
        </p>
        <p class="clearfix">&nbsp;</p>

    </form>
