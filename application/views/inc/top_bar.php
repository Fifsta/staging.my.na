<!--<div id="pre_load">
	<div>
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
	</div>
</div>--> 
<header id="header" class="grad-orange">
	<div class="container">
		<div class="row">
            <div style="width:auto;display:none" id="tstbox"></div>
			<div class="col-sm-1">
				<div class="slogo">
					<a href="<?php echo site_url('/'); ?>"><img src="images/logo-main.png"></a>
					<div>find • list • buy • sell</div> 
				</div>
			</div>
			<div class="col-sm-10">
			
                <form class="input-group input-group-lg" id="search-main" name="search-main" method="post" action="<?php echo site_url('/'); ?>my_na/search">

                  <div class="input-group-prepend">
                    <select class="form-control" id="search_type" style="border-radius: 4px 0px 0px 4px; height:100%; background: #efefef; width:60px; font-size:12px">
                        <option value="all">All</option>
                        <option value="business" style="font-weight: bold">Businesses</option>
                        <option value="vehicle" style="font-weight: bold">Cars, Bikes & Boats</option>
                        <option value="car">&nbsp;&nbsp;&nbsp;Cars</option>
                        <option value="boat">&nbsp;&nbsp;&nbsp;Boats</option>
                        <option value="bike">&nbsp;&nbsp;&nbsp;Bikes</option>
                        <option value="property" style="font-weight: bold">Properties</option>
                        <option value="for-sale">&nbsp;&nbsp;&nbsp;Properties for Sale</option>
                        <option value="to-rent">&nbsp;&nbsp;&nbsp;Properties for Rent</option>
                        <option value="classified" style="font-weight: bold">Classifieds</option>                        
                    </select>  
                  </div>                                  

                    <input type="text" class="form-control typeahead" id="search-bar" name="srch_bar" type="text" value="<?php if (isset($str)) { echo htmlspecialchars($str); } else { echo ''; } ?>" autocomplete="off" placeholder="Search Anything Namibian">

                    <input type="hidden" id="search_type_val" value="<?php if (isset($type)) { echo $type; echo 'none'; } ?>" name="type">
                    <input type="hidden" value="<?php if (isset($location)) { echo $location; } else { echo 'national'; } ?>" name="location">
                    <input type="hidden" value="<?php if (isset($main_cat_id)) { echo $main_cat_id; } else { echo '0'; } ?>" id="main_cat_id" name="main_cat_id">
                    <input type="hidden" value="<?php if (isset($sub_cat_id)) { echo $sub_cat_id; } else { echo '0'; } ?>" id="sub_cat_id" name="sub_cat_id">

					<!--<div class="near input-group-addon">Near:</div>
					<input type="text" class="near form-control" id="search-main2" placeholder="Windhoek">-->
					<span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search" role="button"></button></span>
                    
                </form>
				

			</div>
			<div class="col-sm-1 text-right">
                <nav id="menu" class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-icon="fa-bars"></button>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">My Namibia Menu</li>
                        <li><a href="#">Business</a>
                            <ul>
                                <?php $this->my_na_model->show_popular_cats($t = true); ?>
                            </ul>    
                        </li>
                        <li><a href="<?php echo site_url('/'); ?>classifieds">Classifieds</a></li>
                        <li><a href="<?php echo site_url('/'); ?>buy/property">Properties</a></li>
                        <li><a href="<?php echo site_url('/'); ?>buy/car-bikes-and-boats">Vehicles</a></li>
                        <!--<li><a href="<?php echo site_url('/'); ?>deals/">Deals</a></li>-->
                        <li><a href="<?php echo site_url('/'); ?>trade/auctions/">Auctions</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a href="<?php echo site_url('/'); ?>members/add_business">List a Business</a></li>
                        <li><a href="<?php echo site_url('/'); ?>sell/index/0/motor">Sell a Car</a></li>
                        <li><a href="<?php echo site_url('/'); ?>sell/index/0/property">Sell a Property</a></li>
                        <li><a href="<?php echo site_url('/'); ?>sell/index/0/general">Sell Anything</a></li>
                        <li><a href="<?php echo site_url('/'); ?>sell/index/0/auction">Create an Auction</a></li>
                    </ul>                  
                </nav>
			</div>
		</div>
	</div>
</header>


