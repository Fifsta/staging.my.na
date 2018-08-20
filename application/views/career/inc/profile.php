<?php

	$bio = $this->vacancy_model->get_biography(); 

?>
<section id="listing">
	
    <div class="heading" style="margin-bottom:15px;">
      <h2 data-icon="fa-briefcase">My Career Profile</h2>
      <ul class="options">    
        <li><a href="#Documents" data-icon="fa-file-o text-dark">Documents</a></li>
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
					<form action="<?php echo site_url('/')?>vacancy/update_general_details" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Job Title</label>
								<input type="text" class="form-control input-sm" placeholder="Job Title" name="job_title" value="<?php echo $bio['job_title']; ?>">
							</div>
						</div>

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Highest Qualification</label>
								<input type="text" name="qualification" class="form-control input-sm" placeholder="Qualification" value="<?php echo $bio['qualification']; ?>">
							</div>
						</div>

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Marital Status</label>
				                    <select class="form-control" name="marital" id="marital">
				                        <option value="">Choose a Option</option>
				                        <option value="Single" <?php if($bio['marital_status'] == 'Single') { echo 'selected'; } ?>>Single</option>
				                        <option value="Married" <?php if($bio['marital_status'] == 'Married') { echo 'selected'; } ?>>Married</option>
				                        <option value="Divorced" <?php if($bio['marital_status'] == 'Divorced') { echo 'selected'; } ?>>Divorced</option>
				                        <option value="Common Law" <?php if($bio['marital_status'] == 'Common Law') { echo 'selected'; } ?>>Common Law</option>
				                        <option value="Widow" <?php if($bio['marital_status'] == 'Widow') { echo 'selected'; } ?>>Widow</option>
				                    </select>
							</div>
						</div>

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Nationality</label>
								<input type="text" class="form-control input-sm" name="nationality" placeholder="Nationality" value="<?php echo $bio['nationality']; ?>">
							</div>
						</div>	

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Current Salary</label>
								<input type="text" class="form-control input-sm" name="current_tcc" placeholder="Current Salary" value="<?php echo $bio['current_tcc']; ?>">
							</div>
						</div>

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>Expected Salary</label>
								<input type="text" class="form-control input-sm" name="expected_tcc" placeholder="Expected Salary" value="<?php echo $bio['expected_tcc']; ?>">
							</div>
						</div>	

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
								<label>ID Number</label>
								<input type="text" class="form-control input-sm" placeholder="ID Number" name="id_number" value="<?php echo $bio['id_number']; ?>">
							</div>
						</div>


						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
			                    <label>Are You Racially Disadvantaged:</label>
			                    <select class="form-control" name="bee" id="bee">
			                        <option value="RDA" <?php if($bio['bee'] == 'RDA') { echo 'selected'; } ?>>Yes</option>
			                        <option value="RA" <?php if($bio['bee'] == 'RA') { echo 'selected'; } ?>>No</option>
			                    </select>
							</div>
						</div>


						<div class="col-sm-12 col-md-6 col-lg-6">

							<div class="form-group">
								<label>Drivers License</label>
			                    <select class="form-control" name="drivers" id="drivers">
			                        <option value="N" <?php if($bio['drivers'] == 'N') { echo 'selected'; } ?>>No</option>
			                        <option value="Y" <?php if($bio['drivers'] == 'Y') { echo 'selected'; } ?>>Yes</option>
			                    </select>
							</div>

							<?php if($bio['drivers'] == 'N') { $dr_show = 'display:none'; } else { $dr_show = ''; } ?>

			                <div class="form-group" style="<?php echo $dr_show; ?>" id="dr_toggle">
			                    <label for="drivers_type">Type of License</label>
		                        <select class="form-control" name="drivers_type">
		                            <option value="B" <?php if($bio['drivers_type'] == 'B') { echo 'selected'; } ?>>B</option>
		                            <option value="BE" <?php if($bio['drivers_type'] == 'BE') { echo 'selected'; } ?>>BE</option>
		                            <option value="C" <?php if($bio['drivers_type'] == 'C') { echo 'selected'; } ?>>C</option>
		                            <option value="C1" <?php if($bio['drivers_type'] == 'C1') { echo 'selected'; } ?>>C1</option>
		                            <option value="C1E" <?php if($bio['drivers_type'] == 'C1E') { echo 'selected'; } ?>>C1E</option>
		                            <option value="CE" <?php if($bio['drivers_type'] == 'CE') { echo 'selected'; } ?>>CE</option>
		                            <option value="PDP"<?php if($bio['drivers_type'] == 'PDP') { echo 'selected'; } ?>>PDP</option>
		                        </select>
			                </div>

						</div>

						<div class="col-sm-12 col-md-6 col-lg-6">
							<div class="form-group">
			                    <label>Are You Disabled:</label>
			                    <select class="form-control" name="disabled" id="disabled">
			                        <option value="N" <?php if($bio['disabled'] == 'N') { echo 'selected'; } ?>>No</option>
			                        <option value="Y" <?php if($bio['disabled'] == 'Y') { echo 'selected'; } ?>>Yes</option>
			                    </select>
							</div>

							<?php if($bio['disabled'] == 'N') { $d_show = 'display:none'; } else { $d_show = ''; } ?>

		                    <div class="form-group" id="d_toggle" style="<?php echo $d_show; ?>">
		                        <label for="disability">What is the nature of your disability?</label>
		                        <textarea name="disability" cols="" rows="" class="form-control disability"></textarea>
	                    	</div>
						</div>				


                      <div class="col-sm-12">
                        <div class="form-group">
                          <button class="btn btn-primary btn-lg pull-right" id="but"><i class="fa fa-pencil"></i> Update Info</button>
                        </div>
                      </div>

					</div>	
					</form>
				</div>
			</section>
		</div>
	</div>




</section>