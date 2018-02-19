<?php
//+++++++++++++++++
//PROFILE INCLUDE
//+++++++++++++++++

$section_1 = $this->uri->segment(1);
$section_2 = $this->uri->segment(2);

//echo $section_2;

echo $section_1;

if($section_1 == 'members') {

	echo 'hello';

}


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

			<li><a href="#" data-icon="fa fa-envelope text-dark"><i class="fa fa-envelope text-dark"></i></a><span><?php $this->my_na_model->msg_notifications_count(); ?></span></li>
			<li><a href="#" data-icon="fa fa-cog text-dark"><i class="fa fa-cog text-dark"></i></a><span>2</span></li>
		</ul>
		<button id="profile-toggle" class="btn btn-default btn-block" data-icon="fa-angle-double-down">My Account</button>
	</nav>
	
	<div class="panel-group" id="profile-accordion" role="tablist" aria-multiselectable="true">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#MyAccount" aria-expanded="false" aria-controls="MyAccount" data-icon="fa-list-alt">My Account</a></h3>
			</div>
			<div id="MyAccount" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyAccount">
				<div class="panel-body">
					<ul>
						<li><a href="#">My Dashboard</a> <span>My account overview</span></li>
						<li><a href="#">My Profile</a> <span>Change my profile information.</span></li>
						<li><a href="#">My Deals</a> <span>Add, delete and manage my deals.</span></li>
						<li><a href="#">Scratch & Win</a> <span>Win great prizes with my.na</span></li>
						<li><a href="#">Messages</a> <span>All my my.na messages</span></li>
						<li><a href="#">My Sports</a> <span>My sport news.</span></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#MyBusiness" aria-expanded="false" aria-controls="MyBusiness" data-icon="fa-edit">My Business</a></h3>
			</div>
			<div id="MyBusiness" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyBusiness">
				<div class="panel-body">
					<ul>
						<?php echo $this->my_na_model->get_businesses_nav(); ?>
					</ul>
				</div>
			</div>
		</div>		
		<div class="panel panel-default">
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
		</div>
	</div>
</section>
<!--profile-->