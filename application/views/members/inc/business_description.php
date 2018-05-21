<form id="bus-desc-update" name="bus-desc-update" method="post" action="<?php echo site_url('/');?>members/update_business_description">
  <input type="hidden" name="bus_id" value="<?php if(isset($ID)){echo $ID;}?>">
  <input type="hidden" name="name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
  <div class="row">

    <div class="col-sm-12">
      <div class="form-group">
        <textarea id="redactor_content" name="content" style="display:block" class="form-control redactor"><?php echo $BUSINESS_DESCRIPTION;?></textarea>
      </div>
    </div> 

    <div class="col-sm-4">
      <div class="form-group">
        <button type="button" class="btn btn-primary btn-lg btn-block desc-update" data-icon="fa-envelope-o">Update</button>
      </div>
    </div>         

   </div> 
</form>

<div id="desc-progress" style="display:none; text-align:center">
  Working...
  <div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 100%" aria-valuemin="0" aria-valuemax="100"></div>
  </div>
</div>

<div id="desc-result"></div>