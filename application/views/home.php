<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">

	<meta name="google-site-verification" content="MMMMMMMMMMMMMMMMMM">

	<meta name="author" content="Intouch Interactive Marketing">

	<base href="<?php echo base_url('/');?>" target="_self">

	<meta name="og:title" content="My Namibia - find • list • buy • sell">
	<meta name="og:description" content="My Namibia - find • list • buy • sell">
	<meta name="og:image" content="images/fb_image.jpg">

	<!--<meta name="csrf-token" content="{{ csrf_token() }}">-->

	<title>My Namibia - find • list • buy • sell</title>
	<meta name="description" content="My Namibia - find • list • buy • sell">

	<link rel="shortcut icon" type="image/ico" href="favicon.ico">
	<!--<link rel="icon" type="image/gif" href="animated_favicon.gif">-->

	<!--[if lt IE 8]>
	<script src="js/jquery-1.11.1.min.js"></script>
	<link href="css/ie7.css" rel="stylesheet" type="text/css">
	<script src="js/ie7.js"></script>
	<![endif]-->
	
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<!--[if lt IE 10]>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/modernizr.js"></script>
	<![endif]-->
	
	<!--[if (gte IE 9) | (!IE)]><!-->
	<script src="js/jquery-2.1.1.min.js"></script>
	<!--<![endif]-->

	<!-- Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- css -->
	<link href="css/style.combo.css" rel="stylesheet" type="text/css">
	<link href="css/icons.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
</head>

<body id="top">

	<div id="resolution" style="position:fixed; top:0; left:0; z-index:100; font-size:80%; color:#000"></div>
	<div id="pre_load">
		<div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
		</div>
	</div>
	
	<header id="header" class="grad-orange">
		<h1 class="hidden">My Namibia - find • list • buy • sell</h1>
		<div class="container">
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
						<span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search"></button></span>
					</form>
					
					<div class="history">Search history: <a href="#">pizza</a>, <a href="#">lodge</a>, <a href="#">plumbing</a>, <a href="#">paper towels</a>, <a href="#">shoes</a>,</div>
				</div>
				<div class="col-sm-2 text-right">
					<nav id="menu" class="btn-group">
						<h2 class="hidden">Main Navigation</h2>
						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-icon="fa-bars"></button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li class="dropdown-header">My Namibia Menu</li>
							<li><a href="#">Templates</a>
								<ul>
									<li><a href="index.php">Home</a></li>
									<li><a href="dashboard.php">Dashboard</a></li>
									<li><a href="directory-category.php">Directory category</a></li>
									<li><a href="directory-category-item.php">Directory item</a></li>
									<li><a href="directory-things-to-do.php">Things To Do category</a></li>
									<li><a href="directory-things-to-do-item.php">Things To Do item</a></li>
									<li><a href="buy-cars.php">Car search and filters</a></li>
									<li><a href="directory-car-item.php">Car Item</a></li>
								</ul>
							</li>
							<li><a href="#">About</a>
								<ul>
									<li><a href="#">Our Goal</a></li>
									<li><a href="#">Contact</a></li>
								</ul>
							</li>
							<li role="separator" class="divider"></li>
							<li class="dropdown-header">My Profile</li>
							<li><a href="#" data-icon="fa-list">My Dashboard</a>
								<ul>
									<li><a href="#">My Profile</a></li>
									<li><a href="#">Manage my listings</a></li>
									<li><a href="#">Manage my businesses</a></li>
									<li><a href="#">Manage my alerts</a></li>
								</ul>
							</li>
							<li><a href="#" data-icon="fa-edit">List Anything</a>
								<ul>
									<li><a href="#">List a Business Service</a></li>
									<li><a href="#">List a Business</a></li>
									<li><a href="#">Sell a Car, Bike or Boat</a></li>
									<li><a href="#">Sell a Property</a></li>
									<li><a href="#">Sell Anything Else</a></li>
									<li><a href="#">Create an Auction</a></li>
								</ul>
							</li>
							<li><a href="#" data-icon="fa-map-marker">Namibia Map</a></li>
							<li><a href="#" data-icon="fa-calendar">Events</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</header>
	<nav id="bread">
		<h2 class="hidden">Breadcrumb Navigation</h2>
		<div class="container">
			<ol class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li><a href="#">Library</a></li>
				<li class="active">Data</li>
			</ol>
		</div>
	</nav>
	<div class="container">
		<div class="row content">
			
			<!--RIGHT-->
			<div class="right col-sm-4 col-md-3 pull-right">
				
				<!--profile-->
				<section class="sidenav">
					<h2 class="hidden">My Profile</h2>
					<nav class="profile">
						<h2 class="hidden">Individual Navigation</h2>
						<a href="#" class="pic"><img src="images/profile-pic.jpg"></a>
						<a href="#" class="name">Carl-Heinz Benseler Benseler</a>
						<ul>
							<li><a href="#" data-icon="fa-bookmark-o"></a><span>10</span></li><!--
							--><li><a href="#" data-icon="fa-envelope-o"></a><span>5</span></li><!--
							--><li><a href="#" data-icon="fa-cog"></a><span>2</span></li>
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
				
				<!--weather-->
				<section class="weather">
					<h2 class="hidden">Weather</h2>
					<div class="form-group">
						<select class="selectpicker form-control" data-live-search="true" data-none-selected-text="Select your City / Town" data-width="80%"><!--data-actions-box="true"-->
							<option>Windhoek</option>
							<option>Study</option>
							<option>Library</option>
							<option>Jaccuzzi</option>
							<option>Study</option>
							<option>Library</option>
						</select>
					</div>
					<div class="title">
						<div>Swakopmund <span>18</span>&deg;C</div>
						<div>Mon, 18 Sep 2016</div>
					</div><!--
					--><div class="icon"><i class="we we-sunny"></i></div><!--
					--><div class="high-low">
						<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
						<i class="fa fa-long-arrow-down"></i> 5&deg;C
					</div>
					<table>
						<tr>
							<td>
								<div class="day">Mon</div>
								<div class="icon"><i class="we we-sunny"></i></div>
								<div class="high-low">
									<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
									<i class="fa fa-long-arrow-down"></i> 5&deg;C
								</div>
							</td>
							<td>
								<div class="day">Tue</div>
								<div class="icon"><i class="we we-sunny"></i></div>
								<div class="high-low">
									<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
									<i class="fa fa-long-arrow-down"></i> 5&deg;C
								</div>
							</td>
							<td>
								<div class="day">Wed</div>
								<div class="icon"><i class="we we-sunny"></i></div>
								<div class="high-low">
									<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
									<i class="fa fa-long-arrow-down"></i> 5&deg;C
								</div>
							</td>
							<td>
								<div class="day">Thu</div>
								<div class="icon"><i class="we we-sunny"></i></div>
								<div class="high-low">
									<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
									<i class="fa fa-long-arrow-down"></i> 5&deg;C
								</div>
							</td>
							<td>
								<div class="day">Fri</div>
								<div class="icon"><i class="we we-sunny"></i></div>
								<div class="high-low">
									<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
									<i class="fa fa-long-arrow-down"></i> 5&deg;C
								</div>
							</td>
							<td>
								<div class="day">Sat</div>
								<div class="icon"><i class="we we-sunny"></i></div>
								<div class="high-low">
									<i class="fa fa-long-arrow-up"></i> 18&deg;C <br>
									<i class="fa fa-long-arrow-down"></i> 5&deg;C
								</div>
							</td>
						</tr>
					</table>
				</section>
				<!--weather-->
				
				<!--adverts-->
				<div class="adverts">
					<div><a href="#"><img src="images/advert-sample.png"></a></div>
					<div><a href="#"><img src="images/advert-sample.png"></a></div>
					<div><a href="#"><img src="images/advert-sample.png"></a></div>
					<div><a href="#"><img src="images/advert-sample.png"></a></div>
					<div><a href="#"><img src="images/advert-sample.png"></a></div>
					<div><a href="#"><img src="images/advert-sample.png"></a></div>
				</div>
				<!--adverts-->
			</div>
			<!--RIGHT-->
		
			<!--LEFT-->
			<div class="left col-sm-8 col-md-9">
			
				<section id="nearyou">
				
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-street-view"><strong>Near</strong> You</h2>
							<p>To benefit from this, make sure that you have location services enabled for this website.</p>
						</div>
					</div>
					
					<div class="row item-list swipe js-flickity" data-flickity-options='{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }'>
					
						<article class="swipe-item col-sm-6 col-md-3 col-lg-2">
							<figure>
								<p class="list-category"><a href="#">All Events</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
								<div class="more">
									<p data-icon="fa-clock-o">12:15, Today</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">The egg race through the desert</a></h2>
								<p class="date"><a href="#" data-icon="fa-map-marker">Eros, Windhoek</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3 col-lg-2">
							<figure>
								<p class="list-category"><a href="#">Food &amp; Wine</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
							</figure>
							<div>
								<h2><a href="#">The egg race through the desert</a></h2>
								<p class="date"><a href="#" data-icon="fa-map-marker">Eros, Windhoek</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3 col-lg-2">
							<figure>
								<p class="list-category"><a href="#">Things To Do</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
							</figure>
							<div>
								<h2><a href="#">The egg race through the desert</a></h2>
								<p class="date"><a href="#" data-icon="fa-map-marker">Eros, Windhoek</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3 col-lg-2">
							<figure>
								<p class="list-category"><a href="#">Shopping</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
							</figure>
							<div>
								<h2><a href="#">The egg race through the desert</a></h2>
								<p class="date"><a href="#" data-icon="fa-map-marker">Eros, Windhoek</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3 col-lg-2">
							<figure>
								<p class="list-category"><a href="#">Accommodation</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
							</figure>
							<div>
								<h2><a href="#">The egg race through the desert</a></h2>
								<p class="date"><a href="#" data-icon="fa-map-marker">Eros, Windhoek</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						
					</div>
				</section>
			
				<section id="categories">
				
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-briefcase"><strong>Business</strong> Directory</h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
							</ul>
						</div>
					</div>
					
					
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-briefcase"></a>
							<h3><a href="#">Business</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-bed"></a>
							<h3><a href="#">Accommodation</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-bicycle"></a>
							<h3><a href="#">Things To Do</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-graduation-cap"></a>
							<h3><a href="#">Education</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-birthday-cake"></a>
							<h3><a href="#">Wedding</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-comments-o"></a>
							<h3><a href="#">Functions &amp; Conferences</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-cutlery"></a>
							<h3><a href="#">Food &amp; Wine</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-heartbeat"></a>
							<h3><a href="#">Real Estate</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#"><i class="fa fa-heartbeat"></i></a>
							<h3><a href="#">Health, Sport &amp; Fitness</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-shopping-cart"></a>
							<h3><a href="#">Shopping</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-users"></a>
							<h3><a href="#">Community</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-bus"></a>
							<h3><a href="#">Transport</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
					</div>
				</section>
				
				<section id="namibia-map">
					
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-map-marker"><a href="#">Namibia <strong>Map</strong></a></h2>
							<p>To benefit from this, make sure that you have location services enabled for this website.</p>
						</div>
					</div>
					
					<div class="row" style="position:relative">
						<button id="map-toggle" class="btn btn-primary"><i class="fa fa-angle-double-right"></i></button>
						<div class="namibia-map">
							<div class="map-left">
								<div class="form-group">
									<select class="selectpicker form-control" multiple data-live-search="true" data-none-selected-text="Filter markers according to ..."><!--data-actions-box="true"-->
										<optgroup data-icon="fa-briefcase" label="Business">
											<option>Jaccuzzi</option>
											<option>Study</option>
											<option>Library</option>
										</optgroup>
										<optgroup data-icon="fa-briefcase" label="Business">
											<option>Jaccuzzi</option>
											<option>Study</option>
											<option>Library</option>
										</optgroup>
									</select>
								</div>
								<div class="panel-group" id="map-accordion" role="tablist" aria-multiselectable="true">
									<div class="panel panel-default">
										<div class="panel-heading" role="tab">
											<h3 class="panel-title"><a class="" role="button" data-toggle="collapse" data-parent="#map-accordion" href="#Business" aria-expanded="true" aria-controls="Business">Business</a></h3>
										</div>
										<div id="Business" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="Business">
											<div class="panel-body">
												<ul>
													<li><span>1245</span> <a href="#">All</a></li>
													<li><span>1245</span> <a href="#">Lodge</a></li>
													<li><span>1245</span> <a href="#">Guest Farm</a></li>
													<li><span>1245</span> <a href="#">Guest House</a></li>
													<li><span>1245</span> <a href="#">Bed and Breakfast</a></li>
													<li><span>1245</span> <a href="#">Campsite Camping and Camping Campsite</a></li>
													<li><span>1245</span> <a href="#">Self Catering and Catering Self</a></li>
													<li><span>1245</span> <a href="#">Rest Camp</a></li>
													<li><span>1245</span> <a href="#">Hotel Resort and Gold Course</a></li>
													<li><span>1245</span> <a href="#">Hotel</a></li>
													<li><span>1245</span> <a href="#">Tented Camp</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab">
											<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#map-accordion" href="#Accommodation" aria-expanded="false" aria-controls="Accommodation">Accommodation</a></h3>
										</div>
										<div id="Accommodation" class="panel-collapse collapse" role="tabpanel" aria-labelledby="Accommodation">
											<div class="panel-body">
												<ul>
													<li><span>1245</span> <a href="#">All</a></li>
													<li><span>1245</span> <a href="#">Lodge</a></li>
													<li><span>1245</span> <a href="#">Guest Farm</a></li>
													<li><span>1245</span> <a href="#">Guest House</a></li>
													<li><span>1245</span> <a href="#">Bed and Breakfast</a></li>
													<li><span>1245</span> <a href="#">Campsite Camping and Camping Campsite</a></li>
													<li><span>1245</span> <a href="#">Self Catering and Catering Self</a></li>
													<li><span>1245</span> <a href="#">Rest Camp</a></li>
													<li><span>1245</span> <a href="#">Hotel Resort and Gold Course</a></li>
													<li><span>1245</span> <a href="#">Hotel</a></li>
													<li><span>1245</span> <a href="#">Tented Camp</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab">
											<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#map-accordion" href="#ThingsToDo" aria-expanded="false" aria-controls="ThingsToDo">Things To Do</a></h3>
										</div>
										<div id="ThingsToDo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="ThingsToDo">
											<div class="panel-body">
												<ul>
													<li><span>1245</span> <a href="#">All</a></li>
													<li><span>1245</span> <a href="#">Lodge</a></li>
													<li><span>1245</span> <a href="#">Guest Farm</a></li>
													<li><span>1245</span> <a href="#">Guest House</a></li>
													<li><span>1245</span> <a href="#">Bed and Breakfast</a></li>
													<li><span>1245</span> <a href="#">Campsite Camping and Camping Campsite</a></li>
													<li><span>1245</span> <a href="#">Self Catering and Catering Self</a></li>
													<li><span>1245</span> <a href="#">Rest Camp</a></li>
													<li><span>1245</span> <a href="#">Hotel Resort and Gold Course</a></li>
													<li><span>1245</span> <a href="#">Hotel</a></li>
													<li><span>1245</span> <a href="#">Tented Camp</a></li>
												</ul>
											</div>
										</div>
									</div>
									<div class="panel panel-default">
										<div class="panel-heading" role="tab">
											<h3 class="panel-title"><a class="collapsed" role="button" data-toggle="collapse" data-parent="#map-accordion" href="#Education" aria-expanded="false" aria-controls="Education">Education</a></h3>
										</div>
										<div id="Education" class="panel-collapse collapse" role="tabpanel" aria-labelledby="Education">
											<div class="panel-body">
												<ul>
													<li><span>1245</span> <a href="#">All</a></li>
													<li><span>1245</span> <a href="#">Lodge</a></li>
													<li><span>1245</span> <a href="#">Guest Farm</a></li>
													<li><span>1245</span> <a href="#">Guest House</a></li>
													<li><span>1245</span> <a href="#">Bed and Breakfast</a></li>
													<li><span>1245</span> <a href="#">Campsite Camping and Camping Campsite</a></li>
													<li><span>1245</span> <a href="#">Self Catering and Catering Self</a></li>
													<li><span>1245</span> <a href="#">Rest Camp</a></li>
													<li><span>1245</span> <a href="#">Hotel Resort and Gold Course</a></li>
													<li><span>1245</span> <a href="#">Hotel</a></li>
													<li><span>1245</span> <a href="#">Tented Camp</a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						<div class="map-right">
							<iframe src="google_map.html" frameborder="0" allowtransparency="true"></iframe>
						</div>
					</div>
					</div>
				</section>
				
				<section id="properties">
					
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-bed"><a href="#"><strong>Properties</strong></a></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
								<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
							</ul>
						</div>
					</div>
					
					<div class="row item-list swipe js-flickity" data-flickity-options='{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }'>
					
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Properties</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Properties</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Properties</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Properties</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<h2 class="hidden">Load More</h2>
							<figure>
								<a class="load-more" href="#">
									<img src="images/load-more.png">
								</a>
							</figure>
						</article>
						
					</div>
					
				</section>
				
				<section id="cars">
					
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-car"><a href="#"><strong>Cars, Bikes and Boats</strong></a></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
								<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
							</ul>
						</div>
					</div>
					
					<div class="row item-list swipe js-flickity" data-flickity-options='{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }'>
					
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Cars, Bikes and Boats</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Cars, Bikes and Boats</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Cars, Bikes and Boats</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Cars, Bikes and Boats</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<h2 class="hidden">Load More</h2>
							<figure>
								<a class="load-more" href="#">
									<img src="images/load-more.png">
								</a>
							</figure>
						</article>
						
					</div>
					
				</section>
				
				<section id="deals">
					
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-certificate"><a href="#"><strong>Deals</strong></a></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
								<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
							</ul>
						</div>
					</div>
					
					<div class="row item-list swipe js-flickity" data-flickity-options='{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }'>
					
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Deals</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Deals</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Deals</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Deals</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<h2 class="hidden">Load More</h2>
							<figure>
								<a class="load-more" href="#">
									<img src="images/load-more.png">
								</a>
							</figure>
						</article>
						
					</div>
					
				</section>
				
				<section id="auctions">
					
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-gavel"><a href="#"><strong>Auctions</strong></a></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
								<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
							</ul>
						</div>
					</div>
					
					<div class="row item-list swipe js-flickity" data-flickity-options='{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }'>
					
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Auctions</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Auctions</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Auctions</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Auctions</a></p>
								<a href="#" class="cycle-slideshow" data-cycle-speed="500" data-cycle-timeout="500">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
									<img class="reveal" src="images/16x9.png" data-src="images/sample2.jpg">
									<img class="reveal" src="images/16x9.png" data-src="images/sample3.jpg">
								</a>
								<div class="more">
									<p class="price">N$99 999 999</p>
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-bookmark"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Audi A3</a></h2>
								<p class="date">Listed: 12hours ago</p>
								<div class="details">
									<p><span>Year:</span> <strong>Late 2013</strong></p>
									<p><span>Mileage:</span> <strong>31246</strong></p>
									<p><span>Fuel:</span> <strong>Diesel</strong></p>
									<p><span>Transmission:</span> <strong>Manual</strong></p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<h2 class="hidden">Load More</h2>
							<figure>
								<a class="load-more" href="#">
									<img src="images/load-more.png">
								</a>
							</figure>
						</article>
						
					</div>
					
				</section>
				
				<section id="news">
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-newspaper-o">Todays <strong>Headlines</strong></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
							<ul class="options">
								<li><a href="#" data-icon="fa-edit">List my own</a></li>
								<li><a href="#" data-icon="fa-bullhorn">Alert me</a></li>
							</ul>
						</div>
					</div>
					<div class="row item-list news swipe js-flickity" data-flickity-options='{ "cellSelector":".swipe-item", "wrapAround": false, "lazyLoad":true, "prevNextButtons":true, "pageDots":false, "cellAlign":"left", "contain":true }'>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Republikein</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
								<div class="more">
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-star-o"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Ondangwa is verre Noorde se gunsteling</a></h2>
								<p class="date">Listed: 12hours ago | <a href="#">Category</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Republikein</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
								<div class="more">
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-star-o"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Ondangwa is verre Noorde se gunsteling</a></h2>
								<p class="date">Listed: 12hours ago | <a href="#">Category</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Republikein</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
								<div class="more">
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-star-o"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Ondangwa is verre Noorde se gunsteling</a></h2>
								<p class="date">Listed: 12hours ago | <a href="#">Category</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
						<article class="swipe-item col-sm-6 col-md-3">
							<figure>
								<p class="list-category"><a href="#">Republikein</a></p>
								<a href="#">
									<img class="shown lazyload" data-src="images/sample1.jpg" src="images/16x9.png">
								</a>
								<div class="more">
									<p class="social">
										<a href="#" data-icon="fa-facebook"></a>
										<a href="#" data-icon="fa-twitter"></a>
										<a href="#" data-icon="fa-star-o"></a>
									</p>
								</div>
							</figure>
							<div>
								<h2><a href="#">Ondangwa is verre Noorde se gunsteling</a></h2>
								<p class="date">Listed: 12hours ago | <a href="#">Category</a></p>
								<div class="details">
									<p>Namibiërs het Ondangwa as die verre Noorde se finalis vir die volgende aflewering van Namibia Media Holdings se Dorp van die Jaar-kompetisie (NTY2017) aangewys. My.NA Search Oshakati was tweede en Oshikuku derde. NMH bedank elkeen van die 15 deelnemende dorpe in hierdie uitdun­rondte asook almal wat ge­stem het. Ons vennote vir NTY2017 is Nedbank Namibia, Coca-­Cola, die Africa Leader­ship Insitute (ALI), Pupkewitz Nissan, Vivo Energy/Shell, Kanaal 7, Waltons en Mondi Rotatrim.</p>
								</div>
							</div>
						</article>
					</div>
				</section>
				
				<section id="trending">
					
					<div class="row">
						<div class="heading">
							<h2 data-icon="fa-hand-pointer-o"><strong>Trending</strong></h2>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
						</div>
					</div>
					
					<div class="row trending">
					
						<aside class="col-sm-6 col-md-3">
							<h2>Top 10 in <strong>Things To Do</strong></h2>
							<ol>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
							</ol>
						</aside>
					
						<aside class="col-sm-6 col-md-3">
							<h2>Top 10 in <strong>Businesses</strong></h2>
							<ol>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
							</ol>
						</aside>
					
						<aside class="col-sm-6 col-md-3">
							<h2>Top 10 in <strong>Accommodation</strong></h2>
							<ol>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
							</ol>
						</aside>
					
						<aside class="col-sm-6 col-md-3">
							<h2>Top 10 in <a href="#"><strong>Food & Wine</strong></a></h2>
							<ol>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
								<li>
									<a href="#">SWA Safaris (Pty) Ltd</a>
									found in <a href="#">Category Name</a>
								</li>
							</ol>
						</aside>
						
					</div>
					
				</section>
					
			</div>
			<!--LEFT-->
		</div>
	</div>
	
	<footer id="footer">
		<div class="container">
			<a href="#" class="logo-footer"><img src="images/logo-footer.png"></a>
			<div class="row">
				<aside class="col-sm-3 col-md-3 col-lg-4">
					<h2>About My Namibia</h2>
					<p>My Namibia also known as MY.NA is an online business and product networking platform for Namibians . Buy and Sell anything Namibian on this site , from , cars and property to any second hand product or service you can think off . List your product , business , service or Job here for FREE today and get maximum exposure online in Namibia . Namibian business's can feature in our state of the art business directory, giving your business the best exposure and visibility online. From Namibia for Namibia.</p>
				</aside>
				
				<aside class="col-sm-9 col-md-9 col-lg-8">
					<h2>Let us help you find</h2>
					<div class="row">
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-briefcase"></a>
							<h3><a href="#">Business</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-bed"></a>
							<h3><a href="#">Accommodation</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-bicycle"></a>
							<h3><a href="#">Things To Do</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-graduation-cap"></a>
							<h3><a href="#">Education</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-birthday-cake"></a>
							<h3><a href="#">Wedding</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-comments-o"></a>
							<h3><a href="#">Functions &amp; Conferences</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-cutlery"></a>
							<h3><a href="#">Food &amp; Wine</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-heartbeat"></a>
							<h3><a href="#">Real Estate</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#"><i class="fa fa-heartbeat"></i></a>
							<h3><a href="#">Health, Sport &amp; Fitness</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-shopping-cart"></a>
							<h3><a href="#">Shopping</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-users"></a>
							<h3><a href="#">Community</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 category">
							<a href="#" data-icon="fa-bus"></a>
							<h3><a href="#">Transport</a></h3>
							<p><a href="#">Property</a>, <a href="#">Cars</a>, <a href="#">Services</a>, <a href="#">Building</a>, <a href="#">Architect</a>, <a href="#">Internet</a>, <a href="#">Finance</a>, <a href="#">Labelling Services</a>, </p>
						</div>
					</div>
				</aside>
			</div>
		</div>
		<div class="footer-end">
			<div class="container">
				<a href="#" class="logo-bookmark"><img src="images/footer-end.png"></a>
				<ul>
					<li><a href="#" data-icon="fa-facebook"></a></li>
					<li><a href="#" data-icon="fa-twitter"></a></li>
					<li><li><a href="#" data-icon="fa-youtube"></a></li>
				</ul>
				<small><a href="#">Terms & Conditions</a> | <a href="#">Contact Us</a> | <a href="#">Privacy policy</a> | 2016 © My Namibia ™</small>
			</div>
		</div>
	</footer>
	
	<div class="overlay-search animate display-table">
		<div>
			<div class="slogo">
				<a href="#"><img src="images/logo-main.png"></a>
				<div>find • list • buy • sell</div>
			</div>
			<form class="input-group input-group-lg">
				<div class="find input-group-addon">Find:</div>
				<input type="text" class="form-control" id="exampleInputAmount" placeholder="Pizza, Lodge, Plumbing, ... etc">
				<div class="near input-group-addon">Near:</div>
				<input type="text" class="near form-control" id="exampleInputAmount" placeholder="Windhoek">
				<span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search"></button></span>
			</form>
			
			<div class="history">Search history: <a href="#">pizza</a>, <a href="#">lodge</a>, <a href="#">plumbing</a>, <a href="#">paper towels</a>, <a href="#">shoes</a>,</div>
			
			<a href="#" class="expose" data-icon="fa-angle-double-down"></a>
		</div>
	</div>
	
	


	<!-- Bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	
	<!-- Calatz -->
	<!-- The "browse to" file input fields -->
	<script src="js/jquery.fileInput.js"></script>
	<script src="js/jquery.flickity.min.js"></script>
	<script src="js/jquery.cycle.min.js"></script>
	<script src="js/jquery.lazysizes.min.js"></script>
	<script src="js/jquery.fancybox.min.js"></script>
	<script src="js/jquery.datatables.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<!-- Datepicker -->
	<script src="js/moment.min.js"></script>
	<script src="js/bootstrap-datetimepicker.min.js"></script>
	
	<!-- Custom Js -->
	<script src="js/jquery.custom.js"></script>
	
	
	<script type="text/javascript">
		$(document).ready(function(){
		
			//THUMBS
			$('figure .cycle-slideshow').cycle('pause');
			$('figure .cycle-slideshow').mouseenter(function() {
				$(this).cycle('resume').cycle('goto',0);
				$('.reveal', this).each(function() {
					var reveal = $(this).attr('data-src');
					$(this).fadeIn(500).attr('src',reveal);
				});
			}).mouseleave(function() {
				var shown = $('.shown', this).attr('src');
				$(this).cycle('pause').cycle('goto',0);
				$('.reveal', this).each(function() {
					$(this).stop().fadeOut(200).attr('src',shown);
				});
			});
			
		});
	
		//RESOLUTION
		function windowResize(){
			windowWidth = $(window).width();
			windowHeight = $(window).height();
			$('#resolution').text(windowWidth+' x '+windowHeight);
		};
		$(window).resize(windowResize);
		
		//PRELOAD
		window.onload = showBody;
		function showBody(){
			windowResize();
			swipeHeight();
			$('#pre_load').fadeOut();
		}
	</script>

	
</body>
</html>
