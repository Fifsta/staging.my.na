<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="user_tbl">
	<thead style="border-top:none">
		<tr style="font-weight:bold;border-top:none">
			<th></th>
			<th>Name</th>
			<th>User Type</th>
			<th>Location</th>
			<th style="min-width:100px;text-align:right"></th>
		</tr>
	</thead>
	<tbody>
		<?php echo $this->members_model->get_business_users($bus_id); ?>
	</tbody>
</table>

<!-- Delete User -->
<div class="modal fade" id="modal-user-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Remove User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to remove the user from the business?</p>
      </div>
      <div class="modal-footer mdl-cont">
        <button type="button" class="btn btn-secondary btn-rmv">Remove</button>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
      </div>
    </div>
  </div>
</div>