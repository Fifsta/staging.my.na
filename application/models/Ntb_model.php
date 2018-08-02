<?php
class Ntb_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//SHOW EMAIL RECIPIENTS
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_email_recipients($type){

		if($type == 'accommodation'){
			$str = 'Accommodation Providers';
			$query = $this->db->query("SELECT u_business.ID as ID, u_business.BUSINESS_NAME as NAME
										FROM u_business
										JOIN i_tourism_category ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
										WHERE a_tourism_category.ID = 3 AND u_business.IS_NTB_MEMBER = 'Y'
										");
		}elseif($type == 'ntb'){
			$str = 'NTB Members';
			$query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE IS_NTB_MEMBER = 'Y'");


		}elseif($type == 'ntb_subscribers'){
			
			$db = $this->connect_ntb_db();
			$str = 'Email Subscribers';
			$query = $db->query("SELECT u_newsletter.id as ID, u_newsletter.name as NAME
								 FROM u_newsletter");

		}elseif($type == 'industry'){
			$str = 'Industry Providers';
			$query = $this->db->query("SELECT u_business.ID as ID, u_business.BUSINESS_NAME as NAME
										FROM u_business
										JOIN i_tourism_category ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
										WHERE (a_tourism_category.ID = 4 OR a_tourism_category.ID = 5 OR a_tourism_category.ID = 10) AND u_business.IS_NTB_MEMBER = 'Y'
										");

		}else{
			$str = 'NTB Members';
			$query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE IS_NTB_MEMBER = 'Y'");
		}

		//$this->db->limit('1000');
		echo '<input type="hidden" id="stype" name="stype" value="'. $type.'">';
		if($query->result()){
			echo'<h4>'.$str.' <small>My Namibia</small></h4>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:84%">Full Name </th>
						<th style="width:10%" rel="tooltip" title="Select All"><input type="checkbox" name="selectall" id="selectall"  /></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				$str = "'".$row->ID."','main'";
				$java = "load_ajax_cat_sub('".$row->ID."')";
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:84%">'.$row->NAME.'</td>
					  	<td style="width:10%"><input type="checkbox" class="case" name="recipients['.$row->ID.']" value="'. $row->ID.'"></td>
					  </tr>';
			}

			$str2 = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";

			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					$(document).ready(function(){
						$("#example").dataTable( {
										"sDom": "'.$str2.'",
										"sPaginationType": "bootstrap",
										"oLanguage": {
											"sLengthMenu": "_MENU_ "
										},
										 "aLengthMenu": [[10, 50, 100, 100, -1], [ 10, 50, 100, 1000,  "All"]],
										"aaSorting":[],
										"bSortClasses": false

						} );

						$(".dataTables_paginate").parent().removeClass("span6").addClass("span12");

						$("#selectall").click(function () {
							  $(".case").attr("checked", this.checked);
						});

						$(".case").click(function(){

							if($(".case").length == $(".caseT:checked").length) {
								$("#selectall").attr("checked", "checked");
							} else {
								$("#selectall").removeAttr("checked");
							}

						});
					});
				</script>';

		}

	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET EMAILS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_emails($status = '')
	{

		if($status == ''){
			$str = 'Emails';
			//$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('ntb_email', 'Y');
			$query = $this->db->get('emails');
		}else{

			$str = ucwords($status). ' emails ';
			// $bus_id = $this->session->userdata('bus_id');
			//$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('ntb_email', 'Y');
			$query = $this->db->where('status', $status);
			$query = $this->db->get('emails');

		}

		echo '';

		if($query->result()){
			echo'
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%">Status</th>
						<th style="width:10%">Subject</th>
           				<th style="width:20%">Body </th>
						<th style="width:5%">Sends </th>
						<th style="width:5%">Opens </th>
						<th style="width:5%">Bounces </th>
						<th style="width:5%">Clicks </th>
						<th style="width:5%">Complaints </th>
						<th style="width:5%">Unsubscribes </th>
						<th style="width:20%">Date</th>
						<th style="width:15%"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				$str = "'".$row->email_id."','yes' , 'product_reviews'";
				$str2 = "'".$row->email_id."','no' ,'product_reviews'";

				if($row->status == 'sent'){
					$tool = 'title="Stop this review" rel="tooltip"';
					$button = '<span class="badge badge-success"><i title="Has been sent" rel="tooltip" class="icon-play icon-white"></i> Sent</span>';
					$button2 = '<a href="javascript:approve_review('.$str2.')"><i class="icon-ban-circle"></i></a>';

				}else{
					$tool = 'title="Approve this review" rel="tooltip"';
					$button = '<span class="badge badge-important"><i title="Draft" rel="tooltip" class="icon-pause icon-white"></i> Draft</span>';
					$button2 = '<a href="javascript:approve_review('.$str.')"><i class="icon-ok"></i></a>';

				}

				$count = (array)(json_decode($row->recipients));
				$z = 0;

				if(count($count) > 0){
					foreach($count as $roww => $val){
						//echo $roww . '<br />';
						$z = $z + count($val);

					}

				}


				echo '<tr id="tr-'.$row->email_id.'">
						<td style="width:5%">'.$button.'</td>
						<td style="width:10%"><a href="javascript:compose_email('.$row->email_id.');">'.$row->title.'</a></td>
						<td style="width:20%">'.$this->shorten_string(strip_tags($row->body), 15).'</td>
						<td style="width:5%" id="sends-'.$row->email_id.'">'.$z.'</td>
						<td style="width:5%" id="opens-'.$row->email_id.'">'.$z.'</td>
						<td style="width:5%" id="bouncs-'.$row->email_id.'">'.$z.'</td>
						<td style="width:5%" id="clicks-'.$row->email_id.'">'.$z.'</td>
						<td style="width:5%" id="complaints-'.$row->email_id.'">'.$z.'</td>
						<td style="width:5%" id="unsubs-'.$row->email_id.'">'.$z.'</td>
						<td style="width:20%">'.date('Y-m-d h:i',strtotime($row->datetime)).'</td>

						<th style="width:15%; text-align:right"><a href="'.site_url('/').'ntb/build_mail/'.$row->email_id.'/"  title="Continue editing" rel="tooltip" class="btn btn-mini"><i class="icon-pencil"></i></a>
							<a target="_blank" href="javascript:load_logs('.$row->email_id.');" title="View the email Analytics" rel="tooltip" class="btn btn-mini btn-success"><i class="icon-random icon-white"></i></a>
							<a target="_blank" href="javascript:delete_email('.$row->email_id.');" title="Delete the email" rel="tooltip" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
						</th>
					  </tr>';
			}


			echo '</tbody>
				</table>

				<hr />
				<div class="clearfix" style="height:30px;"></div>
				';

		}else{


			echo '<div class="alert">No '.$str.' Saved</div>';

		}



	}

	//Shorten String
	function shorten_string($phrase, $max_words) {

		$phrase_array = explode(' ',$phrase);

		if(count($phrase_array) > $max_words && $max_words > 0){

			$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}

		return $phrase;

	}

	function connect_ntb_db(){
		
		//connect to main database
		$config_db['hostname'] = '154.0.162.107';
		$config_db['username'] = 'namibiat';
		$config_db['password'] = 'COqNTUVGb6k8KAfa76wq';
		$config_db['database'] = 'namibiat_beta';
		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}
}
?>