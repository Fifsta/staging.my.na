 <?php 
 //+++++++++++++++++
 //My.Na Business amenities
 //+++++++++++++++++
 //Roland Ihms
 // NTB specififc amenities
 $existing = $this->members_model->get_amenities($ID);

	
	function test_amenities($existing, $top_id, $sub_id, $amenity){
	 
		 foreach($existing->result() as $row){
			 
			 //var_dump($row);
			 if($row->amenity == $amenity){
				
				if($row->amenity_top_id == $top_id){
					
					if($row->amenity_sub_id == $sub_id){
					
						echo 'selected'; 
					}
					
				}
			
			 }
			 
		 }
	 	
 	}
 	
 ?>
   
<link href="<?php echo base_url('/');?>css/select/select2.css" rel="stylesheet" type="text/css" /> 
<div class="row-fluid">
<h2>Business Amenities <small>NTB Members</small></h2>
<div class="alert alert-block">
	<h4>Please Note</h4>
	Please select the amenities that are relevant to your business. You can select multiple selections by clicking on each field and selecting the amenities.
</div>
      <div class="navbar">
        <div class="navbar-inner" style="margin:0;padding:0">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".navbar-responsive-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a>
            
            <div class="nav-collapse navbar-responsive-collapse in collapse" style="height: auto;">
              <ul class="nav">
                <li class="active"><a href="#amnety_acc" data-toggle="tab"><i class="icon-asterisk"></i> Accommodation</a></li>
                <li><a href="#amnety_attr" data-toggle="tab"><i class="icon-asterisk"></i> Attraction</a></li>
                <li><a href="#amnety_recre" data-toggle="tab"><i class="icon-asterisk"></i> Recreation</a></li>
                <li><a href="#amnety_trans" data-toggle="tab"><i class="icon-asterisk"></i> Transportation</a></li>
                <li><a href="#amnety_serv" data-toggle="tab"><i class="icon-asterisk"></i> Visitor Service</a></li>                        
              </ul>
             
              
            </div><!-- /.nav-collapse -->
          </div>
        </div><!-- /navbar-inner -->
      </div>



</div>

<div class="tab-content">

	<div class="tab-pane active" id="amnety_acc">
    <h4>Accommodation</h4>
	<form action="<?php echo site_url('/');?>members/update_amenities/" method="post" class="amenity_frm" />
    <input type="hidden" name="bus_id" value="<?php echo $ID;?>" />
    <input type="hidden" name="amenity_top_id" value="0" />
        <div class="row-fluid">
            <div class="well">
                <div class="span4">
                    Payment Method
                </div>
                <div class="span8">
                  <select name="amenity_sub_id-0[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                      <option value="American Express" <?php test_amenities($existing,  0, 0, 'American Express');?>>American Express</option>
                      <option value="Cash" <?php test_amenities($existing,  0, 0, 'Cash');?>>Cash</option>
                      <option value="Cash Only" <?php test_amenities($existing,  0, 0, 'Cash Only');?>>Cash Only</option>
                      <option value="Diners Club" <?php test_amenities($existing,  0, 0, 'Diners Club');?>>Diners Club</option>
                      <option value="Discover" <?php test_amenities($existing,  0, 0, 'Discover');?>>Discover</option>
                      <option value="MasterCard" <?php test_amenities($existing,  0, 0, 'MasterCard');?>>MasterCard</option>
                      <option value="Personal Checks" <?php test_amenities($existing,  0, 0, 'Personal Checks');?>>Personal Checks</option>
                      <option value="Travelers Checks" <?php test_amenities($existing,  0, 0, 'Travelers Checks');?>>Travelers Checks</option>
                      <option value="Visa" <?php test_amenities($existing,  0, 0, 'Visa');?>>Visa</option>
                  </select>
            
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
                
        <div class="row-fluid">
            <div class="well">
                <div class="span4">
                    Type
                </div>
                <div class="span8">
                    <select name="amenity_sub_id-1[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                        <option value="Back-Packers"  <?php test_amenities($existing,  0, 1, 'Back-Packers');?>>Back-Packers</option>
                        <option value="Bed &amp; Breakfast"  <?php test_amenities($existing,  0, 1, 'Bed &amp; Breakfast');?>>Bed &amp; Breakfast</option>
                        <option value="Camping and Caravan Parks" <?php test_amenities($existing,  0, 1, 'Camping and Caravan Parks');?>>Camping and Caravan Parks</option>
                        <option value="Campsites" <?php test_amenities($existing,  0, 1, 'Campsites');?>>Campsites</option>
                        <option value="Guest Farms" <?php test_amenities($existing,  0, 1, 'Guest Farms');?>>Guest Farms</option>
                        <option value="Guest Houses" <?php test_amenities($existing,  0, 1, 'Guest Houses');?>>Guest Houses</option>
                        <option value="Hostels" <?php test_amenities($existing,  0, 1, 'Hostels');?>>Hostels</option>
                        <option value="Hotels" <?php test_amenities($existing,  0, 1, 'Hotels');?>>Hotels</option>
                        <option value="Lodges" <?php test_amenities($existing,  0, 1, 'Lodges');?>>Lodges</option>
                        <option value="Permanent Tented Camps" <?php test_amenities($existing,  0, 1, 'Permanent Tented Camps');?>>Permanent Tented Camps</option>
                        <option value="Resorts" <?php test_amenities($existing,  0, 1, 'Resorts');?>>Resorts</option>
                        <option value="Rest Camps" <?php test_amenities($existing,  0, 1, 'Rest Camps');?>>Rest Camps</option>
                        <option value="Self-Catering Establishments" <?php test_amenities($existing,  0, 1, 'Self-Catering Establishments');?>>Self-Catering Establishments</option>
                        <option value="Tented Lodges" <?php test_amenities($existing,  0, 1, 'Tented Lodges');?>>Tented Lodges</option>
                    </select>
            
                </div>
            <div class="clearfix"></div>
            </div>
        </div>        
        
        <div class="row-fluid">
            <div class="well">
                <div class="span4">   
                    Room type
                </div>
                <div class="span8">
                    <select name="amenity_sub_id-2[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6" >
                        <option value="1 Bedroom Units" <?php test_amenities($existing,  0, 2, '1 Bedroom Units');?>>1 Bedroom Units</option>
                        <option value="2 Bedroom Units" <?php test_amenities($existing,  0, 2, '2 Bedroom Units');?>>2 Bedroom Units</option>
                        <option value="3 Bedroom Units" <?php test_amenities($existing,  0, 2, '3 Bedroom Units');?>>3 Bedroom Units</option>
                        <option value="4 Bedroom Units" <?php test_amenities($existing,  0, 2, '4 Bedroom Units');?>>4 Bedroom Units</option>
                        <option value="Suites Available" <?php test_amenities($existing,  0, 2, 'Suites Available');?>>Suites Available</option>
                   </select>
            
                </div>
            <div class="clearfix"></div>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="well">
                <div class="span4">
                    Amenities
                </div>
                <div class="span8">
                    <select name="amenity_sub_id-3[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                        <option value="Air-Conditioning" <?php test_amenities($existing,  0, 3, 'Air-Conditioning');?>>Air-Conditioning </option>
                        <option value="Airstrip" <?php test_amenities($existing,  0, 3, 'Airstrip');?>>Airstrip</option>
                        <option value="Children Welcome" <?php test_amenities($existing,  0, 3, 'Children Welcome');?>>Children Welcome</option>
                        <option value="Conference Facilities" <?php test_amenities($existing,  0, 3, 'Conference Facilities');?>>Conference Facilities</option>
                        <option value="Credit Cards" <?php test_amenities($existing,  0, 3, 'Credit Cards');?>>Credit Cards</option>
                        <option value="Diesel Available" <?php test_amenities($existing,  0, 3, 'Diesel Available');?>>Diesel Available</option>
                        <option value="Excellent Views" <?php test_amenities($existing,  0, 3, 'Excellent Views');?>>Excellent Views</option>
                        <option value="Golf Course" <?php test_amenities($existing,  0, 3, 'Golf Course');?>>Golf Course</option>
                        <option value="Handicap Accessible" <?php test_amenities($existing,  0, 3, 'Handicap Accessible');?>>Handicap Accessible</option>
                        <option value="Liquor License" <?php test_amenities($existing,  0, 3, 'Liquor License');?>>Liquor License</option>
                        <option value="Parking" <?php test_amenities($existing,  0, 3, 'Parking');?>>Parking</option>
                        <option value="Petrol Available" <?php test_amenities($existing,  0, 3, 'Petrol Available');?>>Petrol Available</option>
                        <option value="Restaurant" <?php test_amenities($existing,  0, 3, 'Restaurant');?>>Restaurant</option>
                        <option value="Shuttle Bus Service" <?php test_amenities($existing,  0, 2, 'Shuttle Bus Service');?>>Shuttle Bus Service</option>
                        <option value="Swimming" <?php test_amenities($existing,  0, 3, 'Swimming');?>>Swimming</option>
                        <option value="Telephone" <?php test_amenities($existing,  0, 3, 'Telephone');?>>Telephone</option>
                        <option value="Wildlife Viewing" <?php test_amenities($existing,  0, 3, 'Wildlife Viewing');?>>Wildlife Viewing</option>
                        <option value="Wireless" <?php test_amenities($existing,  0, 3, 'Wireless');?>>Wireless</option>
                   </select>
            
                </div>
            <div class="clearfix"></div>
            </div>
        </div>
        
        <div class="row-fluid">
            <div class="well">
                <div class="span4">
                    Activities
                </div>
                <div class="span8">
                    <select name="amenity_sub_id-4[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                        <option value="4x4" <?php test_amenities($existing,  0, 4, '4x4');?>>4x4</option>
                        <option value="abseiling" <?php test_amenities($existing,  0, 4, 'abseiling');?>>abseiling</option>
                        <option value="arts and crafts markets" <?php test_amenities($existing,  0, 4, 'arts and crafts markets');?>>arts and crafts markets</option>
                        <option value="ballooning" <?php test_amenities($existing,  0, 4, 'ballooning');?>>ballooning</option>
                        <option value="birding" <?php test_amenities($existing,  0, 4, 'birding');?>>birding</option>
                        <option value="camping" <?php test_amenities($existing,  0, 4, 'camping');?>>camping</option>
                        <option value="canoeing and rafting" <?php test_amenities($existing,  0, 4, 'canoeing and rafting');?>>canoeing and rafting</option>
                        <option value="Catamaran" <?php test_amenities($existing,  0, 4, 'Catamaran');?>>Catamaran</option>
                        <option value="caving" <?php test_amenities($existing,  0, 4, 'caving');?>>caving</option>
                        <option value="communal conservancies" <?php test_amenities($existing,  0, 4, 'communal conservancies');?>>communal conservancies</option>
                        <option value="community campsites" <?php test_amenities($existing,  0, 4, 'community campsites');?>>community campsites</option>
                        <option value="diving" <?php test_amenities($existing,  0, 4, 'diving');?>>diving</option>
                        <option value="dolphin cruises" <?php test_amenities($existing,  0, 4, 'dolphin cruises');?>>dolphin cruises</option>
                        <option value="endurance" <?php test_amenities($existing,  0, 4, 'endurance');?>>endurance</option>
                        <option value="Fishing" <?php test_amenities($existing,  0, 4, 'Fishing');?>>Fishing</option>
                        <option value="flying" <?php test_amenities($existing,  0, 4, 'flying');?>>flying</option>
                        <option value="geology" <?php test_amenities($existing,  0, 4, 'geology');?>>geology</option>
                        <option value="gliding" <?php test_amenities($existing,  0, 4, 'gliding');?>>gliding</option>
                        <option value="hiking" <?php test_amenities($existing,  0, 4, 'hiking');?>>hiking</option>
                        <option value="horse riding" <?php test_amenities($existing,  0, 4, 'horse riding');?>>horse riding</option>
                        <option value="hunting" <?php test_amenities($existing,  0, 4, 'hunting');?>>hunting</option>
                        <option value="joint ventures" <?php test_amenities($existing,  0, 4, 'joint ventures');?>>joint ventures</option>
                        <option value="kitesurfing" <?php test_amenities($existing,  0, 4, 'kitesurfing');?>>kitesurfing</option>
                        <option value="motorcycle tours" <?php test_amenities($existing,  0, 4, 'motorcycle tours');?>>motorcycle tours</option>
                        <option value="mountain biking" <?php test_amenities($existing,  0, 4, 'mountain biking');?>>mountain biking</option>
                        <option value="mountaineering" <?php test_amenities($existing,  0, 4, 'mountaineering');?>>mountaineering</option>
                        <option value="paragliding" <?php test_amenities($existing,  0, 4, 'paragliding');?>>paragliding</option>
                        <option value="photography" <?php test_amenities($existing,  0, 4, 'photography');?>>photography</option>
                        <option value="quadbiking" <?php test_amenities($existing,  0, 4, 'quadbiking');?>>quadbiking</option>
                        <option value="safari" <?php test_amenities($existing,  0, 4, 'safari');?>>safari</option>
                        <option value="sandboarding" <?php test_amenities($existing,  0, 4, 'sandboarding');?>>sandboarding</option>
                        <option value="skydiving" <?php test_amenities($existing,  0, 4, 'skydiving');?>>skydiving</option>
                        <option value="stargazing" <?php test_amenities($existing,  0, 4, 'stargazing');?>>stargazing</option>
                        <option value="traditional villages" <?php test_amenities($existing,  0, 4, 'traditional villages');?>>traditional villages</option>
                 </select>
            
                </div>
            <div class="clearfix"></div>
            </div>
        </div> 
        <button type="submit" class="btn btn-inverse pull-right clearfix"> Save </button>
        </form>
    </div><!-- end Acc tab -->
    
    
    <div class="tab-pane" id="amnety_attr">
        <h4>Attraction</h4>
		<form action="<?php echo site_url('/');?>members/update_amenities/" method="post" class="amenity_frm" />
        <input type="hidden" name="bus_id" value="<?php echo $ID;?>" />
        <input type="hidden" name="amenity_top_id" value="1" />

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                       Attraction Activities
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-0[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                        <option value="4x4" <?php test_amenities($existing,  1, 0, '4x4');?>>4x4</option>
                        <option value="abseiling" <?php test_amenities($existing,  1, 0, 'abseiling');?>>abseiling</option>
                        <option value="arts and crafts markets" <?php test_amenities($existing,  1, 0, 'arts and crafts markets');?>>arts and crafts markets</option>
                        <option value="ballooning" <?php test_amenities($existing,  1, 0, 'ballooning');?>>ballooning</option>
                        <option value="birding" <?php test_amenities($existing,  1, 0, 'birding');?>>birding</option>
                        <option value="camping" <?php test_amenities($existing,  1, 0, 'camping');?>>camping</option>
                        <option value="canoeing and rafting" <?php test_amenities($existing,  1, 0, 'canoeing and rafting');?>>canoeing and rafting</option>
                        <option value="Catamaran" <?php test_amenities($existing,  1, 0, 'Catamaran');?>>Catamaran</option>
                        <option value="caving" <?php test_amenities($existing,  1, 0, 'caving');?>>caving</option>
                        <option value="communal conservancies" <?php test_amenities($existing,  1, 0, 'communal conservancies');?>>communal conservancies</option>
                        <option value="community campsites" <?php test_amenities($existing,  1, 0, 'community campsites');?>>community campsites</option>
                        <option value="diving" <?php test_amenities($existing,  1, 0, 'diving');?>>diving</option>
                        <option value="dolphin cruises" <?php test_amenities($existing,  1, 0, 'dolphin cruises');?>>dolphin cruises</option>
                        <option value="endurance" <?php test_amenities($existing,  1, 0, 'endurance');?>>endurance</option>
                        <option value="Fishing" <?php test_amenities($existing,  1, 0, 'Fishing');?>>Fishing</option>
                        <option value="flying" <?php test_amenities($existing,  1, 0, 'flying');?>>flying</option>
                        <option value="geology" <?php test_amenities($existing,  1, 0, 'geology');?>>geology</option>
                        <option value="gliding" <?php test_amenities($existing,  1, 0, 'gliding');?>>gliding</option>
                        <option value="hiking" <?php test_amenities($existing,  1, 0, 'hiking');?>>hiking</option>
                        <option value="horse riding" <?php test_amenities($existing,  1, 0, 'horse riding');?>>horse riding</option>
                        <option value="hunting" <?php test_amenities($existing,  1, 0, 'hunting');?>>hunting</option>
                        <option value="joint ventures" <?php test_amenities($existing,  1, 0, 'joint ventures');?>>joint ventures</option>
                        <option value="kitesurfing" <?php test_amenities($existing,  1, 0, 'kitesurfing');?>>kitesurfing</option>
                        <option value="motorcycle tours" <?php test_amenities($existing,  1, 0, 'motorcycle tours');?>>motorcycle tours</option>
                        <option value="mountain biking" <?php test_amenities($existing,  1, 0, 'mountain biking');?>>mountain biking</option>
                        <option value="mountaineering" <?php test_amenities($existing,  1, 0, 'mountaineering');?>>mountaineering</option>
                        <option value="paragliding" <?php test_amenities($existing,  1, 0, 'paragliding');?>>paragliding</option>
                        <option value="photography" <?php test_amenities($existing,  1, 0, 'photography');?>>photography</option>
                        <option value="quadbiking" <?php test_amenities($existing,  1, 0, 'quadbiking');?>>quadbiking</option>
                        <option value="safari" <?php test_amenities($existing,  1, 0, 'safari');?>>safari</option>
                        <option value="sandboarding" <?php test_amenities($existing,  1, 0, 'sandboarding');?>>sandboarding</option>
                        <option value="skydiving" <?php test_amenities($existing,  1, 0, 'skydiving');?>>skydiving</option>
                        <option value="stargazing" <?php test_amenities($existing,  1, 0, 'stargazing');?>>stargazing</option>
                        <option value="traditional villages" <?php test_amenities($existing,  1, 0, 'traditional villages');?>>traditional villages</option>
                     </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Attraction Type
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-1[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                    	<option value="Archaeological Site" <?php test_amenities($existing,  1, 1, 'Archaeological Site');?>>Archaeological Site</option>
                        <option value="Arts &amp; Culture" <?php test_amenities($existing,  1, 1, 'Arts &amp; Culture');?>>Arts &amp; Culture</option>
                        <option value="Cities &amp; Towns" <?php test_amenities($existing,  1, 1, 'Cities &amp; Towns');?>>Cities &amp; Towns</option>
                        <option value="Community Based Tourism" <?php test_amenities($existing,  1, 1, 'Community Based Tourism');?>>Community Based Tourism</option>
                        <option value="Historic Attractions" <?php test_amenities($existing,  1, 1, 'Historic Attractions');?>>Historic Attractions</option>
                        <option value="Museum" <?php test_amenities($existing,  1, 1, 'Museum');?>>Museum</option>
                        <option value="Naitonal Parks" <?php test_amenities($existing,  1, 1, 'Naitonal Parks');?>>Naitonal Parks</option>
                        <option value="Safari &amp; Tours" <?php test_amenities($existing,  1, 1, 'Safari &amp; Tours');?>>Safari &amp; Tours</option>
                    </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>
        <button type="submit" class="btn btn-inverse pull-right clearfix"> Save </button>
        </form>
    </div><!-- end Attr tab -->

    <div class="tab-pane" id="amnety_recre">

        <h4>Recreation</h4>
		<form action="<?php echo site_url('/');?>members/update_amenities/" method="post" class="amenity_frm" />
        <input type="hidden" name="bus_id" value="<?php echo $ID;?>" />
        <input type="hidden" name="amenity_top_id" value="2" />

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Air Activities
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-0[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                    	<option value="ballooning" <?php test_amenities($existing,  2, 0, 'ballooning');?>>ballooning</option>
                        <option value="flying" <?php test_amenities($existing,  2, 0, 'flying');?>>flying</option>
                        <option value="gliding" <?php test_amenities($existing,  2, 0, 'gliding');?>>gliding</option>
                        <option value="paragliding" <?php test_amenities($existing,  2, 0, 'paragliding');?>>paragliding</option>
                        <option value="skydiving" <?php test_amenities($existing,  2, 0, 'skydiving');?>>skydiving</option>
                    </select>                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Cultural Activities
                    </div>
                    <div class="span8">
                    <select name="amenity_sub_id-1[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                    	<option value="arts and crafts markets" <?php test_amenities($existing,  2, 1, 'arts and crafts markets');?>>arts and crafts markets</option>
                        <option value="communal conservancies " <?php test_amenities($existing,  2, 1, 'communal conservancies');?>>communal conservancies </option>
                        <option value="community campsites" <?php test_amenities($existing,  2, 1, 'community campsites');?>>community campsites</option>
                        <option value="joint ventures" <?php test_amenities($existing,  2, 1, 'joint ventures');?>>joint ventures</option>
                        <option value="traditional villages" <?php test_amenities($existing,  2, 1, 'traditional villages');?>>traditional villages</option>
                    </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>
        
        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Dune Activities
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-2[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                    	<option value="quadbiking" <?php test_amenities($existing,  2, 2, 'quadbiking');?>>quadbiking</option>
                        <option value="sandboarding" <?php test_amenities($existing,  2, 2, 'sandboarding');?>>sandboarding</option>
                    </select>               
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                       Land Activities
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-3[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                    	<option value="4x4" <?php test_amenities($existing,  2, 3, '4x4');?>>4x4</option>
                        <option value="abseiling" <?php test_amenities($existing,  2, 3, 'abseiling');?>>abseiling</option>
                        <option value="birding" <?php test_amenities($existing,  2, 3, 'birding');?>>birding</option>
                        <option value="camping" <?php test_amenities($existing,  2, 3, 'camping');?>>camping</option>
                        <option value="caving" <?php test_amenities($existing,  2, 3, 'carving');?>>caving</option>
                        <option value="endurance" <?php test_amenities($existing,  2, 3, 'endurance');?>>endurance</option>
                        <option value="geology <?php test_amenities($existing,  2, 3, 'geology');?>">geology</option>
                        <option value="hiking" <?php test_amenities($existing,  2, 3, 'hiking');?>>hiking</option>
                        <option value="horse riding" <?php test_amenities($existing,  2, 3, 'horse riding');?>>horse riding</option>
                        <option value="hunting" <?php test_amenities($existing,  2, 3, 'hunting');?>>hunting</option>
                        <option value="motorcycle tours" <?php test_amenities($existing,  2, 3, 'motorcycle tours');?>>motorcycle tours</option>
                        <option value="mountain biking" <?php test_amenities($existing,  2, 3, 'mountain biking');?>>mountain biking</option>
                        <option value="mountaineering" <?php test_amenities($existing,  2, 3, 'mountaineering');?>>mountaineering</option>
                        <option value="photography" <?php test_amenities($existing,  2, 3, 'photography');?>>photography</option>
                        <option value="safari" <?php test_amenities($existing,  2, 3, 'safari');?>>safari</option>
                        <option value="stargazing" <?php test_amenities($existing,  2, 3, 'stargazing');?>>stargazing</option>
                   </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                      Water  Activities
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-4[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                    	<option value="canoeing and rafting" <?php test_amenities($existing,  2, 4, 'canoeing and rafting');?>>canoeing and rafting</option>
                        <option value="catamaran" <?php test_amenities($existing,  2, 4, 'catamaran');?>>catamaran</option>
                        <option value="diving" <?php test_amenities($existing,  2, 4, 'diving');?>>diving</option>
                        <option value="dolphin cruises" <?php test_amenities($existing,  2, 4, 'dolphin cruises');?>>dolphin cruises</option>
                        <option value="fishing" <?php test_amenities($existing,  2, 4, 'fishing');?>>fishing</option>
                        <option value="kitesurfing" <?php test_amenities($existing,  2, 4, 'kitesurfing');?>>kitesurfing</option>
                   </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <button type="submit" class="btn btn-inverse pull-right clearfix"> Save </button>
        </form>

    </div><!-- end Recre tab -->    

    <div class="tab-pane" id="amnety_trans">

        <h4>Transportation</h4>
		<form action="<?php echo site_url('/');?>members/update_amenities/" method="post" class="amenity_frm" />
        <input type="hidden" name="bus_id" value="<?php echo $ID;?>" />
        <input type="hidden" name="amenity_top_id" value="3" />

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Air
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-0[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
						<option value="Helicopter Tours" <?php test_amenities($existing,  3, 0, 'Helicopter Tours');?>>Helicopter Tours</option>
                        <option value="Plane Tours" <?php test_amenities($existing,  3, 0, 'Plane Tours');?>>Plane Tours</option>
                        <option value="Tansfers" <?php test_amenities($existing,  3, 0, 'Transferss');?>>Tansfers</option>
                    </select>                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Rental
                    </div>
                    <div class="span8">
                    <select name="amenity_sub_id-1[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
						<option value="4x4" <?php test_amenities($existing,  3, 1, '4x4');?>>4x4</option>
                        <option value="Air Conditioning" <?php test_amenities($existing,  3, 1, 'Air Conditioning');?>>Air Conditioning</option>
                        <option value="Camping Equipment" <?php test_amenities($existing,  3, 1, 'Camping Equipment');?>>Camping Equipment</option>
                        <option value="Compact" <?php test_amenities($existing,  3, 1, 'Compact');?>>Compact</option>
                        <option value="Convertible" <?php test_amenities($existing,  3, 1, 'Convertible');?>>Convertible</option>
                        <option value="Delivery &amp; Pick Up" <?php test_amenities($existing,  3, 1, 'Delivery &amp; Pick Up');?>>Delivery &amp; Pick Up</option>
                        <option value="Emergency Service" <?php test_amenities($existing,  3, 1, 'Emergency Service');?>>Emergency Service</option>
                        <option value="Full Size" <?php test_amenities($existing,  3, 1, 'Full Size');?>>Full Size</option>
                        <option value="Jeep" <?php test_amenities($existing,  3, 1, 'Jeep');?>>Jeep</option>
                        <option value="Luxury" <?php test_amenities($existing,  3, 1, 'Luxury');?>>Luxury</option>
                        <option value="Mid Size" <?php test_amenities($existing,  3, 1, 'Mid Size');?>>Mid Size</option>
                        <option value="Minivan" <?php test_amenities($existing,  3, 1, 'Minivan');?>>Minivan</option>
                        <option value="Scooter" <?php test_amenities($existing,  3, 1, 'Scooter');?>>Scooter</option>
                        <option value="SUV" <?php test_amenities($existing,  3, 1, 'SUV');?>>SUV</option>
                        <option value="Truck " <?php test_amenities($existing,  3, 1, 'Truck');?>>Truck </option>
                        <option value="Van" <?php test_amenities($existing,  3, 1, 'Van');?>>Van</option>
                    </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>
        
        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Tours &amp; Transfers
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-2[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
 						<option value="Adventure "  <?php test_amenities($existing,  3, 2, 'Adventure');?>>Adventure </option>
                        <option value="Cultural Tours"  <?php test_amenities($existing,  3, 2, 'Cultural Tours');?>>Cultural Tours</option>
                        <option value="Eco Tours"  <?php test_amenities($existing,  3, 2, 'Eco Tours');?>>Eco Tours</option>
                        <option value="Safari"  <?php test_amenities($existing,  3, 2, 'Safari');?>>Safari</option>
                        <option value="Walking Tours"  <?php test_amenities($existing,  3, 2, 'Walking Tours');?>>Walking Tours</option>
                    </select>               
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <button type="submit" class="btn btn-inverse pull-right clearfix"> Save </button>
        </form>
    
    </div><!-- end Transp tab -->    

    <div class="tab-pane" id="amnety_serv">

        <h4>Visitor Service</h4>
		<form action="<?php echo site_url('/');?>members/update_amenities/" method="post" class="amenity_frm" />
        <input type="hidden" name="bus_id" value="<?php echo $ID;?>" />
        <input type="hidden" name="amenity_top_id" value="4" />

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Banking
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-0[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
						<option value="ATM" <?php test_amenities($existing,  4, 0, 'ATM');?>>ATM</option>
                    </select>                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                       Banking Currencies
                    </div>
                    <div class="span8">
                    <select name="amenity_sub_id-1[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
						<option value="Euro"  <?php test_amenities($existing,  4, 1, 'Euro');?>>Euro</option>
                        <option value="Nambian Dollar" <?php test_amenities($existing,  4, 1, 'Namibian Dollar');?>>Nambian Dollar</option>
                        <option value="South African Rand" <?php test_amenities($existing,  4, 1, 'South African Rand');?>>South African Rand</option>
                        <option value="USD" <?php test_amenities($existing,  4, 1, 'USD');?>>USD</option>
                    </select>
                
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>
        
        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Conventions &amp; Meetings
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-2[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
  						<option value="Business Center" <?php test_amenities($existing,  4, 2, 'Business Center');?>>Business Center</option>
                        <option value="Catering Available" <?php test_amenities($existing,  4, 2, 'Catering Available');?>>Catering Available</option>
                        <option value="Internet Access" <?php test_amenities($existing,  4, 2, 'Internet Access');?>>Internet Access</option>
                        <option value="Planning Services" <?php test_amenities($existing,  4, 2, 'Planning Services');?>>Planning Services</option>
                    </select>               
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <div class="row-fluid">
                <div class="well">
                    <div class="span4">
                        Information Types
                    </div>
                    <div class="span8">
					<select name="amenity_sub_id-3[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
 						<option value="Accommodation Directory" <?php test_amenities($existing,  4, 3, 'Accommodation Directory');?>>Accommodation Directory</option>
                        <option value="Area Information" <?php test_amenities($existing,  4, 3, 'Area Information');?>>Area Information</option>
                        <option value="Brochurs" <?php test_amenities($existing,  4, 3, 'Brochurs');?>>Brochurs</option>
                        <option value="Calendar of Events" <?php test_amenities($existing,  4, 3, 'Calendar of Events');?>>Calendar of Events</option>
                        <option value="City and Regional Maps" <?php test_amenities($existing,  4, 3, 'City and Regional Maps');?>>City and Regional Maps</option>
                        <option value="Cultural Information" <?php test_amenities($existing,  4, 3, 'Cultural Information');?>>Cultural Information</option>
                        <option value="Routing Information" <?php test_amenities($existing,  4, 3, 'Routing Information');?>>Routing Information</option>
                        <option value="Safety Information" <?php test_amenities($existing,  4, 3, 'Safety Information');?>>Safety Information</option>
                        <option value="Vacation Planners/Guides" <?php test_amenities($existing,  4, 3, 'Vacation Planners/Guides');?>>Vacation Planners/Guides</option>
                        <option value="Weather Updates" <?php test_amenities($existing,  4, 3, 'Weather Updates');?>>Weather Updates</option>
                    </select>               
                    </div>
                    <div class="clearfix"></div>
                </div>
                
        </div>

        <button type="submit" class="btn btn-inverse pull-right clearfix"> Save </button>
        </form>

    </div><!-- end Serv tab -->    

   
</div><!-- end tab content -->
<div id="amenity_msg" style="margin-top:10px;"></div>
<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){
		
		$('.amenity_btn_submit').bind('click', function(e){
			e.preventDefault();
			
			var btn = $(this), frm =  $('form.amenity_frm').find('input[type=hidden],select').serialize();

			btn.html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Saving...');
			$.ajax({
				  url: "<?php echo site_url('/');?>members/update_amenities/",
				  type: 'post',
				  data: frm,
				  success: function(data) {
						$("#amenity_msg").html(data);
						btn.html('Save');
				  }
				});
			
			
		});
		
		$("form.amenity_frm").on('submit',function(e) {
		
			e.preventDefault();
			
			var btn = $('form button.btn');
			btn.html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Saving...');
			$.ajax({
				  url: "<?php echo site_url('/');?>members/update_amenities/",
				  type: 'post',
				  data: $(this).serialize() ,
				  success: function(data) {
						$("#amenity_msg").html(data);
						btn.html('Save')
				  }
				});
			
		});
		
		
		$('select.amenity_slect').select2({
                placeholder: "Please Select",
                allowClear: true
          
		 });
	});
	

</script>