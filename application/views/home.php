<?php $this->load->view('inc/header');?>
<?php $this->load->view('inc/top_bar');?>

	<div class="container">
		<div class="row content">
			<!--RIGHT-->
			<div class="right col-sm-4 col-md-3 pull-right">
            
				<?php $this->load->view('inc/profile');?>
				
				<?php $this->load->view('inc/weather');?>
				
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
				<section id="latest_products">
					<?php 
                    echo $this->my_model->get_items('product');
                    ?>
            	</section>
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
			
				<?php $this->load->view('inc/categories');?>
				
				<?php $this->load->view('inc/map');?>
				
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
				
				<?php $this->load->view('inc/news');?>	
				
				<?php $this->load->view('inc/trending');?>	
					
			</div>
			<!--LEFT-->
		</div>
	</div>
	
	
	<?php $this->load->view('inc/footer');?>	


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
