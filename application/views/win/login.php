<?php echo form_open(site_url('/').'expo/login', array('class' => 'form-signin', 'id' => 'form-signin'));?>		
     
       <img src="<?php echo S3_URL;?>scratch_card/expo2013/images/login.png" />
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
                     <?php if($this->session->flashdata('msg')){ ?>
                    <div class="alert  alert-success">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $error; ?>
                    </div>
                    <?php
                    }//end error
                    if($this->session->flashdata('error')){ ?>
                    <div class="alert alert-error">
                     <button type="button" class="close" data-dismiss="alert">×</button>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                    <?php
                    }
                    ?>
        <input type="email" class="input-block-level" name="email" id="email" placeholder="Email address">
        <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
        <input type="hidden" name="first_log" value="<?php if (isset($first)){ echo $first;}else{ echo 'N';}?>" />
        <a class="btn btn-large btn-inverse pull-left but_back" ><i class="icon-chevron-left icon-white"></i> Back </a>
        <button class="btn btn-large btn-inverse pull-right" type="button" id="btn_sign_in">Sign In</button>
        <div class="clearfix" style="height:60px"></div>
         <small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right white">Forgot Password?</a>
         		
         </small>
         
      </form>
		<div id="login_msg"></div>
        
        
	  <?php //if(isset($pass_update)){?>
        <div class="tab-pane" id="pass_update" style="display:<?php if(isset($pass_update)){ echo 'block;';}else{ echo 'none;';}?>">
         <?php echo form_open(site_url('/').'members/pass_update_one', array('class' => 'form-signin', 'name' => 'formpass0'));?>		
          <div class="alert alert-warning" >
           <button type="button" class="close" data-dismiss="alert">×</button>
             <h4>Generate a new password</h4>
             Please provide us with your email address to generate a new password
          </div>
             
            <input type="text" class="input-block-level" placeholder="Email" name="passemail" value="<?php if (isset($email)) { echo $email; }?>"  />
            <button class="btn btn-inverse pull-right" type="submit"><b>Proceed</b></button>
            <div class="clearfix" style="height:10px"></div>
               <small><a href="javascript:void(0)" onClick="pass_update()" class="pull-right muted">Login?</a>
                     
               </small>
          </form>
        </div>
      <?php //} ?>
        