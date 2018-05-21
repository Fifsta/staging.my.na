<?php
//+++++++++++++++++
//PROFILE INCLUDE
//+++++++++++++++++


$uris = explode('/', $url);

$section_1 = '';
$section_2 = '';

if(isset($uris[2])) {
	$section_1 = $uris[2];
}

if(isset($uris[3])) {
	$section_2 = $uris[3];
}


//Toggle My Account
if($section_1 == 'members' && ($section_2 == 'home' || $section_2 == 'my_profile' || $section_2 == 'my_messages' || $section_2 == '')) { $my_account = 'show'; } else { $my_account = ''; }

//Toggle My Business
if($section_1 == 'members' && $section_2 == 'business') { $my_bus = 'show'; } else { $my_bus = ''; }

?>

<section class="sidenav" id="my_profile">
	<nav class="profile">
		<a href="#" class="pic"><?php echo $this->my_na_model->get_user_avatar('25', '25'); ?></a>
		<a href="#" class="name"><?php echo $this->session->userdata('u_name'); ?></a>
		<ul>
			<li class="nav-item dropdown">
				<a href="#" data-icon="fa-bookmark text-dark" class="nav-link">
				<i class="fa fa-bookmark text-dark"></i>
				</a><span><?php $this->my_na_model->show_points_sml(); ?></span>
			</li>

			<li><a href="<?php echo site_url('/'); ?>members/my_messages" data-icon="fa fa-envelope text-dark"><i class="fa fa-envelope text-dark"></i></a><span><?php $this->my_na_model->msg_notifications_count(); ?></span></li>
			<li><a href="<?php echo site_url('/'); ?>members/logout" data-icon="fa fa-cog text-dark"><i class="fa fa-sign-out text-dark"></i></a></li>
		</ul>

	</nav>
	
	<div class="panel-group" id="profile-accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#MyAccount" aria-expanded="false" aria-controls="MyAccount" data-icon="fa-list-alt">My Account</a></h3>
			</div>
			<div id="MyAccount" class="panel-collapse collapse <?php echo $my_account; ?>" role="tabpanel" aria-labelledby="MyAccount">
				<div class="panel-body">
					<ul>
						<!--<li><a href="<?php //echo site_url('/');?>members/home/">My Dashboard</a> <span>My account overview</span></li>-->
						<li><a href="<?php echo site_url('/');?>members/my_profile/">My Profile</a> <span>Change my profile information.</span></li>
						<li><a href="<?php echo site_url('/');?>members/my_messages/">My Messages</a> <span>All my.na messages</span></li>
						<li><a href="<?php echo site_url('/');?>members/my_products/">My Products</a> <span>All my private products</span></li>
					</ul>
				</div>
			</div>
		</div> 
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#MyBusiness" aria-expanded="false" aria-controls="MyBusiness" data-icon="fa-edit">My Business</a></h3>
			</div>
			<div id="MyBusiness" class="panel-collapse collapse <?php echo $my_bus; ?>" role="tabpanel" aria-labelledby="MyBusiness">
				<div class="panel-body">
					<ul>
						<li><a href="<?php echo site_url('/'); ?>members/add_business"><strong>+ Add a Business</strong></a></li>
						<?php echo $this->my_na_model->get_businesses_nav(); ?>
					</ul>
				</div>
			</div>
		</div>	
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#MyProducts" aria-expanded="false" aria-controls="MyProducts" data-icon="fa-edit">My Products</a></h3>
			</div>
			<div id="MyProducts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyProducts">
				<div class="panel-body">
					<ul>
						<li><a href="<?php echo site_url('/'); ?>sell/index/0/motor">Sell a Car</a></li>
						<li><a href="<?php echo site_url('/'); ?>sell/index/0/property">Sell a Property</a></li>
						<li><a href="<?php echo site_url('/'); ?>sell/index/0/general">Sell Anything</a></li>
						<li><a href="<?php echo site_url('/'); ?>sell/index/0/auction">Create an Auction</a></li>
					</ul>
				</div>
			</div>
		</div>	

		<!--<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#NamibiaMap" aria-expanded="false" aria-controls="NamibiaMap" data-icon="fa-map-marker">Namibia Map</a></h3>
			</div>
			<div id="NamibiaMap" class="panel-collapse collapse" role="tabpanel" aria-labelledby="NamibiaMap">
				<div class="panel-body">
					<ul>
						<li><a href="#">Namibia Map</a> <span>Browse all business locations</span></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">

				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#EventsCalendar" aria-expanded="false" aria-controls="EventsCalendar" data-icon="fa-calendar">Events</a></h3>
			</div>
			<div id="EventsCalendar" class="panel-collapse collapse" role="tabpanel" aria-labelledby="EventsCalendar">
				<div class="panel-body">
					<ul>
						<li><a href="#">Link</a></li>
					</ul>
				</div>
			</div>
		</div>-->
	</div>
</section>
<!--profile-->