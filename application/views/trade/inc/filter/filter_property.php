<?php 

//++++++++++++++++++++
//LOAD PROPERTY FILTER
//++++++++++++++++++++

if($sub_cat_id == 0){ $sub_cat_id = 3409; }

?>



  <div class="heading">
    <h2 data-icon="fa-newspaper-o">Filter <strong>Properties</strong></h2>
    <p>Find the perfect property.</p>
  </div>

<section id="filter">    

<div class="col-md-12">

<form name="search" action="<?php echo site_url('/');?>trade/search" method="post" enctype="multipart/form-data"> 

  <input type="hidden" name="main_cat_id" value="3408" >
  <input type="hidden" name="sub_cat_id" id="sub_cat_id_" value="<?php echo $sub_cat_id;?>" >
  <input type="hidden" name="sort" value="">
  <input type="hidden" name="offset" value="0">
  <input type="hidden" name="limit" value="15">  

  <div class="row" style="margin-bottom:20px">

      <div class="col-md-3">
        <div class="clearfix">&nbsp;</div>
        <div class="btn-group" data-toggle="buttons-radio">
          <button type="button"  onclick="togglecheck(3409);" class="btn btn-dark btn-lg <?php if(isset($sub_cat_id) && $sub_cat_id != 0){ if($sub_cat_id == '3409'){echo 'active';}}else{ echo 'active';}?>"><i class="fa fa-home icon-light"></i> For Sale</button>
          <button type="button" onclick="togglecheck(3410);" class="btn btn-dark btn-lg <?php if(isset($sub_cat_id)){ if($sub_cat_id == '3410'){echo 'active';}}else{ echo '';}?>"><i class="fa fa-share icon-light"></i> To Rent</button>
        </div>
      </div>

      <div class="col-md-2">
        <small>&nbsp;Land Type<i class="icon-question-sign pull-right" rel="tooltip" title="The property sectional type"></i></small>
          <select name="sub_sub_cat_id" class="form-control" id="sel_sub_sub_cat_id">
            <?php 
             if(isset($sub_cat_id) && $sub_cat_id != 0){
                $this->trade_model->get_categories_select('sub_cat_id',  $sub_cat_id, $sub_sub_cat_id);
             }else{
                echo '<option value="0">Please Select</option>';
             }
            ?>
          </select>
      </div> 

      <div class="col-md-2">
        <small>&nbsp;Property Type<i class="icon-question-sign pull-right" rel="tooltip" title="The type of property"></i></small>
        <select name="sub_sub_sub_cat_id" class="form-control" id="sel_sub_sub_sub_cat_id" <?php if(!isset($sub_sub_cat_id) || $sub_sub_cat_id == 0){ echo 'disabled="disabled"';}?>>
          <?php 
            if(isset($sub_sub_cat_id) && $sub_sub_cat_id != 0){
              $this->trade_model->get_categories_select('sub_sub_cat_id', $sub_sub_cat_id, $sub_sub_sub_cat_id);
            }else{
              echo '<option value="0">Please Select</option>';
            } 
          ?>
        </select>
      </div> 

      <div class="col-md-2 room_div">
        <small>&nbsp;Bedrooms<i class="icon-question-sign pull-right" rel="tooltip" title="The number of bedrooms"></i></small>
        <select class="form-control" name="bedrooms">
            <option value="">Bedrooms</option>
            <option value="1 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 1);?>>1 Bedroom</option>
            <option value="2 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 2);?>>2 Bedroom</option>
            <option value="3 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 3);?>>3 Bedroom</option>
            <option value="4 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 4);?>>4 Bedroom</option>
            <option value="5 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 5);?>>5 Bedroom</option>
            <option value="6 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 6);?>>6 Bedroom</option>
            <option value="7 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 7);?>>7 Bedroom</option>
            <option value="8 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 8);?>>8 Bedroom</option>
            <option value="9 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 9);?>>9 Bedroom</option>
            <option value="10 bedrooms" <?php $this->trade_model->test_extras($extras ,'bedrooms', 'selected', 10);?>>10 Bedrooms</option>
        </select>
      </div>

      <div class="col-md-2 bath_div">
        <small>&nbsp;Bathrooms<i class="icon-question-sign pull-right" rel="tooltip" title="The number of bathrooms"></i></small>
        <select class="form-control" name="bathrooms">
            <option value="">Bathrooms</option>
            <option value="1 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 1);?>>1 Bathroom</option>
            <option value="2 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 2);?>>2 Bathroom</option>
            <option value="3 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 3);?>>3 Bathroom</option>
            <option value="4 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 4);?>>4 Bathroom</option>
            <option value="5 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 5);?>>5 Bathroom</option>
            <option value="6 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 6);?>>6 Bathroom</option>
            <option value="7 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 7);?>>7 Bathroom</option>
            <option value="8 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 8);?>>8 Bathroom</option>
            <option value="9 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 9);?>>9 Bathroom</option>
            <option value="10 bathrooms" <?php $this->trade_model->test_extras($extras ,'bathrooms', 'selected', 10);?>>10 Bathrooms</option>
        </select>
      </div>      
  </div>

 <div class="row <?php if($extras == '?'){ echo 'd-none';}elseif(is_array($extras)){ if(!array_key_exists('features', $extras)){ echo 'd-none';}}?>" id="extra_div_toggle"> 
      <div class="col-md-12">
                <div class="clearfix">&nbsp;</div>
                  <select name="features[]" data-placeholder="Type Property Features" class="extra_slect col-md-12" multiple="" size="6">
                      <option value="Scullery" <?php $this->trade_model->test_extras($extras ,'Scullery','selected', 'Scullery');?>>Scullery</option>
                      <option value="Gym" <?php $this->trade_model->test_extras($extras ,'Gym','selected', 'Gym');?>>Gym</option>
                      <option value="Lapa" <?php $this->trade_model->test_extras($extras ,'Lapa','selected', 'Lapa');?>>Lapa</option>
                      <option value="Swimming-pool" <?php $this->trade_model->test_extras($extras ,'Swimming-pool','selected', 'Swimming-pool');?>>Swimming-pool</option>
                      <option value="Braai" <?php $this->trade_model->test_extras($extras ,'Braai','selected', 'Braai');?>>Braai</option>
                      <option value="Wine Cellar" <?php $this->trade_model->test_extras($extras ,'Wine Cellar','selected', 'Wine Cellar');?>>Wine Cellar</option>
                      <option value="Jaccuzzi" <?php $this->trade_model->test_extras($extras ,'Jaccuzzi','selected', 'Jaccuzzi');?>>Jaccuzzi</option>
                      <option value="Airconditioning" <?php $this->trade_model->test_extras($extras ,'Airconditioning','selected', 'Airconditioning');?>>Airconditioning</option>
                      <option value="Sauna" <?php $this->trade_model->test_extras($extras ,'Sauna','selected', 'Sauna');?>>Sauna</option>
                      <option value="Bar area" <?php $this->trade_model->test_extras($extras ,'Bar area','selected', 'Bar area');?>>Bar area</option>
                      <option value="Garden" <?php $this->trade_model->test_extras($extras ,'Garden','selected', 'Garden');?>>Garden</option>
                      <option value="Entertainment Area" <?php $this->trade_model->test_extras($extras ,'Entertainment Area','selected', 'Entertainment Area');?>>Entertainment Area</option>
                      <option value="DSTV dish" <?php $this->trade_model->test_extras($extras ,'DSTV dish','selected', 'DSTV dish');?>>DSTV dish</option>
                      <option value="Solar Geyser" <?php $this->trade_model->test_extras($extras ,'Solar Geyser','selected', 'Solar Geyser');?>>Solar Geyser</option>
                      <option value="Walk-in-Wardrobe" <?php $this->trade_model->test_extras($extras ,'Walk-in-Wardrobe','selected', 'Walk-in-Wardrobe');?>>Walk-in-Wardrobe</option>
                      <option value="Study" <?php $this->trade_model->test_extras($extras ,'Study','selected', 'Study');?>>Study</option>
                      <option value="Skylight" <?php $this->trade_model->test_extras($extras ,'Skylight','selected', 'Skylight');?>>Skylight</option>
                      <option value="Home automation" <?php $this->trade_model->test_extras($extras ,'Home automation','selected', 'Home automation');?>>Home automation</option>
                      <option value="Electric gates" <?php $this->trade_model->test_extras($extras ,'Electric gates','selected', 'Electric gates');?>>Electric gates</option>
                      <option value="Skylight" <?php $this->trade_model->test_extras($extras ,'Skylight','selected', 'Skylight');?>>Skylight</option>
                      <option value="Alarm System" <?php $this->trade_model->test_extras($extras ,'Alarm System','selected', 'Alarm System');?>>Alarm System</option>
                      <option value="Intercom" <?php $this->trade_model->test_extras($extras ,'Intercom','selected', 'Intercom');?>>Intercom</option>
                      <option value="Electrical fencing" <?php $this->trade_model->test_extras($extras ,'Electrical fencing','selected', 'Electrical fencing');?>>Electrical fencing</option>
                      <option value="Fireplace" <?php $this->trade_model->test_extras($extras ,'Fireplace','selected', 'Fireplace');?>>Fireplace</option>
                      <option value="Workshop" <?php $this->trade_model->test_extras($extras ,'Workshop','selected', 'Workshop');?>>Workshop</option>
                      <option value="Staff Quarters" <?php $this->trade_model->test_extras($extras ,'Staff Quarters','selected', 'Staff Quarters');?>>Staff Quarters</option>
                      <option value="Old World Charm" <?php $this->trade_model->test_extras($extras ,'Old World Charm','selected', 'Old World Charm');?>>Old World Charm</option>
                      <option value="Very Modern" <?php $this->trade_model->test_extras($extras ,'Very Modern' ,'selected','Very Modern');?>>Very Modern</option>
                      <option value="Newly Renovated" <?php $this->trade_model->test_extras($extras,'Newly Renovated' ,'selected','Newly Renovated');?>>Newly Renovated</option>
                      <option value="Laundry" <?php $this->trade_model->test_extras($extras ,'Laundry',  'selected','Laundry');?>>Laundry</option>
                      <option value="Open Plan" <?php $this->trade_model->test_extras($extras ,'Open Plan' ,  'selected','Open Plan');?>>Open Plan</option>
                      <option value="Bachelor Flat" <?php $this->trade_model->test_extras($extras ,'Bachelor Flat', 'selected','Bachelor Flat');?>>Bachelor Flat</option>
                      <option value="1 Bedroom Flat" <?php $this->trade_model->test_extras($extras ,'1 Bedroom Flat', 'selected','1 Bedroom Flat');?>>1 Bedroom Flat</option>
                      <option value="2 Bedroom Flat" <?php $this->trade_model->test_extras($extras ,'2 Bedroom Flat', 'selected','2 Bedroom Flat');?>>2 Bedroom Flat</option>
                      <option value="Outstanding View" <?php $this->trade_model->test_extras($extras ,'Outstanding View',  'selected','Outstanding View');?>>Outstanding View</option>
                      <option value="North Facing" <?php $this->trade_model->test_extras($extras ,'North Facing','selected','North Facing');?>>North Facing</option>
                      <option value="Water Cooler" <?php $this->trade_model->test_extras($extras ,'Water Cooler', 'selected','Water Cooler');?>>Water Cooler</option>
                      <option value="Guest Toilette" <?php $this->trade_model->test_extras($extras ,'Guest Toilette',  'selected','Guest Toilette');?>>Guest Toilette</option>
                  </select>
      </div>
  </div> 

  <div class="row">
    
    <div class="col-md-3">
      <div class="row">
        <div class="col-md-6"><br>
            <div class="input-group-append">
              <button class="add-on btn-dark"><i class="fa fa-minus icon-light"></i></button>
              <input name="price_from" class="form-control" type="text" placeholder="N$"  rel="tooltip" title="The minimum amount in N$" value="<?php if($price_from != 'n' && is_numeric($price_from)){ echo number_format($price_from);}?>">
            </div>         
        </div>
        <div class="col-md-6"><br>
            <div class="input-group-prepend">
              <input name="price_to" class="form-control" type="text" placeholder="N$" rel="tooltip" title="The maximum amount to search for" value="<?php if($price_to != 'n' && is_numeric($price_to)){ echo number_format($price_to);}?>">
              <button class="add-on btn-dark"><i class="fa fa-plus icon-light"></i></button>
            </div>
        </div>
      </div>
    </div>

    <div class="col-md-3">
        <small class="hidden-desktop hidden-tablet">&nbsp;Location <i class="icon-question-sign pull-right" rel="tooltip" title="Where do you want to find the item? Select a city"></i></small>
      <?php $this->trade_model->populate_city($location);?> 
    </div>

    <div class="col-md-3">
      <small class="hidden-desktop hidden-tablet">&nbsp;Suburb <i class="icon-question-sign pull-right" rel="tooltip" title="Where do you want to find the item? Select a city"></i></small>
      <div id="suburb_div">
        <?php if($suburb != 'all'){
            echo $this->trade_model->populate_suburb_name($location ,$suburb);
          }else{
            echo '<input type="hidden" name="suburb" value="all">
            <select id="suburb" class="form-control" disabled="disabled" placeholder="Select Suburb"></select>';
          }
        ?>
      </div>
    </div>
            
    <div class="col-md-2 text-right"><br>
      <div class="btn-group">
        <button class="btn btn-dark btn-lg hidden-tablet hidden-phone" type="button" id="toggle_feat_btn"><i class="fa fa-chevron-down icon-light"></i></button>
        <button class="btn btn-dark btn-lg btn-block" type="submit" id="search_submit"><i class="fa fa-search icon-light"></i> Search</button>
      </div>
    </div>    

  </div>  

</form>
<br> 
</div>
</section>

<script type="text/javascript">

$(document).ready(function(){
  
  $('#sel_sub_cat_id').bind('change', function(){
      $.get("<?php echo site_url('/');?>trade/get_categories_select/sub_cat_id/"+$(this).val()  , function(data){
          $("#sel_sub_sub_cat_id").html( data ).prop("disabled", false);
          $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true);   
      }); 
  });
  
  $('#sel_sub_sub_cat_id').bind('change', function(){
      var val = $(this).val();
      if(val == 3411 || val == 3435){
        $.get("<?php echo site_url('/');?>trade/get_categories_select/sub_sub_cat_id/"+val  , function(data){
            $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", false);
            $('.room_div').slideDown();
        }); 
      }else{
        $.get("<?php echo site_url('/');?>trade/get_categories_select/sub_sub_cat_id/"+val  , function(data){
            $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", false);
            $('.room_div').slideUp();
        }); 
      }

  });

  $('#location_slct').on('change', function(){
      $("#suburb_div").html('Getting Suburbs...');
      
      $.ajax({
       url: "<?php echo site_url('/');?>trade/populate_suburb_name/"+$(this).val()+"/<?php echo $suburb;?>/",
      success: function(data) {
        $("#suburb_div").html(data);
        
      }
      });
  });  

  /*$('select').select2({
                placeholder: "Please Select",
                allowClear: true,
        width: "95%"
          
  });*/
  
  $('#toggle_feat_btn').bind('click', function(e){
    
    if($('#extra_div_toggle').is(":visible")){
      
      $(this).html('<i class=" fa fa-chevron-up icon-light"></i>');
      
    }else{
      $(this).html('<i class=" fa fa-chevron-down icon-light"></i>');
      
    }
    
    $('#extra_div_toggle').slideToggle(); 
    
  });
  
});

function show_features(){
  
  $('#extra_div_toggle').slideToggle(); 
  return false;
}

function togglecheck(id){
  
  $('#sub_cat_id_').val(id);
  $.get("<?php echo site_url('/');?>trade/get_categories_select/sub_cat_id/"+id  , function(data){
      $("#sel_sub_sub_cat_id").html( data ).prop("disabled", false);
      $("#sel_sub_sub_sub_cat_id").html( data ).prop("disabled", true);   
  });
  
  
}

</script>