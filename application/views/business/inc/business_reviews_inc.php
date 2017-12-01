<div class="heading">
	<h2 data-icon="fa-envelope-o">Review <strong>Agency</strong></h2>
</div>

<section role="tabpanel" class="tab-pane active" id="Review-Agency">
	
		<div class="alert alert-warning" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>

			<h4><span class="na_script" style="font-size:20px">Leaving a Review</span></h4>
			Please note that you will only receive your 3 x MyNa points , once this review has been authorised !
			Reviews are authorised according a real experience only!
			We will block your profile if we find that you are misusing this process !
			<br><br>
			<h4 class="na_script" style="font-size:16px">Exapmle review:</h4>

			My family and I stayed at the guesthouse in July for 3 days and the service we received was fantastic.
			The guest house facilities where cleaned daily and the food served was great aswell. Will be back. <small>Joseph Gustaf</small>				   
		</div>

		<?php $this->rating_model->rate_business($bus_id);?>
	
</section>