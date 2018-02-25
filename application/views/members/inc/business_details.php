<form id="business-update" name="business-update" method="post" action="<?php echo site_url('/');?>members/update_business_do">
  <div class="row">

    <div class="col-sm-4">
      <div class="form-group">
        <label for="FullName">Business Name</label>
        <input class="form-control input-sm" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
      </div>
    </div> 

    <div class="col-sm-4">
      <div class="form-group">
        <label for="EmailAddress">Email Address</label>
        <input class="form-control input-sm" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label for="Website">Website</label>
        <input class="form-control input-sm" name="urls" placeholder="Website" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
      </div>
    </div>    

    <div class="col-sm-4">
      <div class="form-group">
        <label for="Telephone">Telephone</label>
        <div class="form-group input-group">
          <?php echo $this->my_na_model->get_countries($TEL_DIAL_CODE, false, false, $class = '', $id = '');?> 
          <input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="tel" name="tel" placeholder="eg: 061231234" maxlength="12" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>">
        </div>
      </div>
    </div>


    <div class="col-sm-4">
      <div class="form-group">
        <label for="fax">Fax</label>
        <div class="form-group input-group">
          <?php echo $this->my_na_model->get_countries($FAX_DIAL_CODE, false, false, $class = '', $id = '');?> 
          <input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="fax" name="fax" placeholder="eg: 061231234" maxlength="12" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>">
        </div>
      </div>
    </div>

    <div class="col-sm-4">
      <div class="form-group">
        <label for="cellphone">Cellphone</label>
        <div class="form-group input-group">
          <?php echo $this->my_na_model->get_countries($CEL_DIAL_CODE, false, false, $class = '', $id = '');?> 
          <input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="cell" name="cell" placeholder="eg: 0811234567" maxlength="12" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>">
        </div>
      </div>
    </div>


    <div class="col-sm-4">
      <div class="form-group">
        <label for="countries">Country</label>
        <input class="form-control input-sm" name="country" placeholder="Country" value="<?php if(isset($COUNTRY_NAME)){echo $COUNTRY_NAME;}?>">

      </div>
    </div> 

    <div class="col-sm-4">
      <div class="form-group">
        <label for="countries">City</label>
        <input class="form-control input-sm" name="city" placeholder="City" value="<?php if(isset($COUNTRY_CITY)){echo $COUNTRY_CITY;}?>">

      </div>
    </div>   


    <div class="col-sm-4">
      <div class="form-group">
        <label for="countries">Suburb</label>
        <input class="form-control input-sm" name="suburb" placeholder="Suburb" value="<?php if(isset($COUNTRY_SUBURB)){echo $COUNTRY_SUBURB;}?>">

      </div>
    </div>  

    <div class="col-sm-4">
      <div class="form-group">
        <label for="countries">PO Box</label>
        <input class="form-control input-sm" name="pobox" placeholder="PO Box" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">

      </div>
    </div>   

    <div class="col-sm-4">
      <div class="form-group">
        <label for="countries">Physical Address</label>
        <input class="form-control input-sm" name="address" placeholder="Address" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>">

      </div>
    </div>   

    <div class="col-sm-4">
      <div class="form-group">
        <label for="countries">Update Details</label>
        <button type="submit" class="btn btn-primary btn-lg btn-block" data-icon="fa-envelope-o">Update</button>

      </div>
    </div>           

  </div>
</form>