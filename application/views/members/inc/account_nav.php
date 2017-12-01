<div id="timeline-anchor"></div>
  <div id="timeline" style="margin:0;padding:0">
    <div>
        <ul class="nav nav-tabs nav-stacked">
        <li class="nav-header">My Account</li>
              <li class="home" <?php if ($subsection == 'myinfo') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>members/home/">Dashboard<i class="icon-chevron-right pull-right"></i></a></li>
              <li class="general"><a  href="javascript:load_ajax('general')">My Profile<i class="icon-chevron-right pull-right"></i></a></li>
        <li class="nav-header">Scratch &amp; Win</li>
              <li id="general_scratch" <?php if ($subsection == 'scratch') {  echo 'class="active"'; }?>>
              <a href="<?php echo site_url('/');?>win/scratch_and_win/">
              <img src="<?php echo base_url('/');?>img/scratch_n_win_sml.png" style="width:100%"/></a></li>
             <?php echo $this->my_na_model->get_businesses_nav();?>
              <li <?php if ($subsection == 'add_business') {  echo 'class="active"'; }?>><a href="<?php echo site_url('/');?>members/add_business/">Add a business<i class="icon-chevron-right pull-right"></i></a></li>
       		  <li><a href="javascript:void(0);" onclick="claim_a_business()">Claim a business<i class="icon-chevron-right pull-right"></i></a></li>
        </ul>
        
	</div>
  </div>
  <div class="clearfix" style="height:10px;"></div>