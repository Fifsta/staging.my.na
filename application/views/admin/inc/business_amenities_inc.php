 <?php 
 //+++++++++++++++++
 //My.Na Business amenities
 //+++++++++++++++++
 //Roland Ihms


if($IS_NTB_MEMBER == 'Y'){
	
	$bus_details['bus_id'] = $ID; 
	
	$this->load->view('admin/inc/business_amenities_ntb_inc', $bus_details);

}else{
	
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
<h2>Business Amenities <small>My Namibia Members</small></h2>

<div class="alert alert-block">
	<h4>Please Note</h4>
	Please select the amenities that are relevant to your business. You can select multiple selections by clicking on each field and selecting the amenities.
</div>

<form action="<?php echo site_url('/');?>members/update_amenities/" name="amenity_frm_s" method="post" class="amenity_frm" />
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

<div class="row-fluid">
        <div class="well">
            <div class="span4">
                Attraction Type
            </div>
            <div class="span8">
            <select name="amenity_sub_id-1[]" data-placeholder="Please Select" class="amenity_slect span12" multiple="" size="6">
                <option value="Archaeological Site" <?php test_amenities($existing,  0, 1, 'Archaeological Site');?>>Archaeological Site</option>
                <option value="Arts &amp; Culture" <?php test_amenities($existing,  0, 1, 'Arts &amp; Culture');?>>Arts &amp; Culture</option>
                <option value="Cities &amp; Towns" <?php test_amenities($existing,  0, 1, 'Cities &amp; Towns');?>>Cities &amp; Towns</option>
                <option value="Community Based Tourism" <?php test_amenities($existing,  0, 1, 'Community Based Tourism');?>>Community Based Tourism</option>
                <option value="Historic Attractions" <?php test_amenities($existing,  0, 1, 'Historic Attractions');?>>Historic Attractions</option>
                <option value="Museum" <?php test_amenities($existing,  0, 1, 'Museum');?>>Museum</option>
                <option value="Naitonal Parks" <?php test_amenities($existing,  0, 1, 'Naitonal Parks');?>>Naitonal Parks</option>
                <option value="Safari &amp; Tours" <?php test_amenities($existing,  0, 1, 'Safari &amp; Tours');?>>Safari &amp; Tours</option>
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

<button type="submit" class="amenity_btn_submit btn btn-inverse pull-right clearfix" id="amenity_btn_submit">Save</button>
</form>
<div id="amenity_msg" style="margin-top:40px;"></div>
<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">


	$(document).ready(function(){
		

		$("form.amenity_frm").bind('submit',function(e) {

			e.preventDefault();
			var btn = $('#amenity_btn_submit');

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
<?php } ?>                