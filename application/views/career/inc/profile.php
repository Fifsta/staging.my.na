<?php

	$bio = $this->vacancy_model->get_biography(); 

?>
<section id="listing">
	
    <div class="heading" style="margin-bottom:15px;">
      <h2 data-icon="fa-briefcase">My Career profile</h2>
      <ul class="options">    
        <li><a href="#Enquiry-Form" data-icon="fa-envelope text-dark">Contact Agency</a></li>
        <li><a href="#Gallery" data-icon="fa-file-image-o text-dark" onClick="load_gallery();">Gallery</a></li>
        <li><a href="#Reviews" data-icon="fa-star text-dark">Reviews</a></li>
        <li><a href="#QR" data-icon="fa-qrcode text-dark">QR Code</a></li>
      </ul>
    </div>
            

	<div class="row">
		<div class="col-md-12">
			<section class="results-item">
				<div>
					<figure>
						<img src="<?php echo $this->my_na_model->get_user_avatar_str('200','200'); ?>" class="img-responsive">
					</figure>
				</div>
				<div>
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label>Job Title</label>
								<input type="text" class="form-control input-sm" placeholder="Job Title" value="<?php echo $bio['job_title']; ?>">
							</div>
						</div>
					</div>	
				</div>
			</section>
		</div>
	</div>
	
</section>