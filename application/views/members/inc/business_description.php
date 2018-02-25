<form id="business-update" name="business-update" method="post" action="<?php echo site_url('/');?>members/update_business_description">
  <div class="row">

    <div class="col-sm-12">
      <div class="form-group">
        <textarea id="redactor_content" name="content" style="display:block" class="form-control redactor"><?php echo $BUSINESS_DESCRIPTION;?></textarea>
      </div>
    </div> 

    <div class="col-sm-4">
      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" data-icon="fa-envelope-o">Update</button>
      </div>
    </div>         

   </div> 
</form>