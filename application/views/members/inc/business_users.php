<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="user_tbl" width="100%">
	<thead>
		<tr style="font-weight:bold">
			<th style="width:5%;min-width:40px"></th>
				<th style="width:30%">Name</th>
			<th style="width:10%">User Type</th>
			<th style="width:25%">Location</th>
			<th style="width:20%">Date of Birth</th>
			<th style="width:10%;min-width:100px;text-align:right"></th>
		</tr>
	</thead>
	<tbody>

		<?php echo $this->members_model->get_business_users($bus_id); ?>

	</tbody>
</table>