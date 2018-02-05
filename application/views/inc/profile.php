<?php
//+++++++++++++++++
//PROFILE INCLUDE
//+++++++++++++++++

$section = $this->uri->segment(1);
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
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#MyDashboard" aria-expanded="false" aria-controls="MyDashboard" data-icon="fa-list-alt">My Dashboard</a></h3>
			</div>
			<div id="MyDashboard" class="panel-collapse collapse" role="tabpanel" aria-labelledby="MyDashboard">
				<div class="panel-body">
					<ul>
						<li><a href="#" data-icon="fa-user">My Profile</a> <span>Change my profile information.</span></li>
						<li><a href="#" data-icon="fa-money">My For Sale Items</a> <span>All my item listings.</span></li>
						<li><a href="#" data-icon="fa-arrow-circle-o-up">My Sold Items</a> <span>All my sold listings.</span></li>
						<li><a href="#" data-icon="fa-arrow-circle-o-down">Items Ive Bought</a> <span>All my sold listings.</span></li>
						<li><a href="#" data-icon="fa-briefcase">Manage my busninesses</a> <span>Add, delete and manage my businesses.</span></li>
						<li><a href="#" data-icon="fa-bullhorn">Manage my alerts</a> <span>Manage how you would like to be alerted.</span></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" role="tab">
				<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#profile-accordion" href="#ListAnything" aria-expanded="false" aria-controls="ListAnything" data-icon="fa-edit">List Anything</a></h3>
			</div>
			<div id="ListAnything" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ListAnything">
				<div class="panel-body">
					<ul>
						<li><a href="#">List a Business Service</a> <span>List your great business service for FREE.</span></li>
						<li><a href="#">List Business</a> <span>Advertise your business for FREE.</span></li>
						<li><a href="#">Sell a Car</a> <span>List a vehicle and sell it online, in no time.</span></li>
						<li><a href="#">Sell a Property</a> <span>List and sell your property today.</span></li>
						<li><a href="#">Sell Anything</a> <span>Have you got any unwanted items?</span></li>
						<li><a href="#">Create an Auction</a> <span>Set a reserve value and see what you could get.</span></li>
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