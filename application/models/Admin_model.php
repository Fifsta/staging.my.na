<?php
class Admin_model extends CI_Model{
	
	
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function admin_model(){
  		//parent::CI_model();
		self::__construct();		
 	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+CONTENT UPDATES BACKEND
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_content_edit($type){


		if($type == 'regions'){

			$typeDB = 'a_map_region';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".REGION_NAME as title, ".$typeDB.".COVER_PHOTO as cover, ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);
			//var_dump($q);


		}elseif($type == 'towns'){

			$typeDB = 'a_map_location';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".MAP_LOCATION as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);

			//var_dump($q);

		}elseif($type == 'culture'){

			$typeDB = 'culture';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);

		}elseif($type == 'animals'){

			$typeDB = 'animals';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);

		}elseif($type == 'birds'){

			$typeDB = 'birds';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);

		}elseif($type == 'must_know'){

			$typeDB = 'must_know';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);

		}elseif($type == 'plants'){
			$typeDB = 'plants';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB."");
			$this->build_content_edit($type, $q);


		}



	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+CONTENT UPDATES BACKEND
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function build_content_edit($type, $query){

		echo '<h2>Update '.$type.'</h2>
		<a href="javascript:void(0);" class="btn" onclick="add_content('."'".$type."'".')"><i class="icon-plus"></i> Add Content</a>
		<div class="clearfix" style="height:20px"></div>
		<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="content_tbl" width="100%">
			<thead>
				<tr style="font-weight:bold">
					<th style="width:10%;min-width:40px">Cover</th>
                    <th style="width:40%">Title</th>
					<th style="width:30%">Body</th>

					<th style="width:20%;min-width:100px"></th>
				</tr>
			</thead>
			<tbody>';

		if($query->result())
		{
			foreach ($query->result() as $row)
			{

				$c = '<span class="badge">No</span>';
				if($row->cover != ''){

					$c = '<span class="badge badge-success">Yes</span>';

				}

				$body = strip_tags($row->body);
				echo '<tr>
							<td style="width:10%;">'.$c.'</td>
							<td style="width:40%;">' . $row->title . '</td>
							<td style="width:30%;">' . $this->shorten_string($body , 9) . '</td>
							<td style="width:20%;text-align:right"><a onclick="update_content(' . $row->ID . ",'" . $type . "'" . ');" class="btn btn-mini btn-inverse"><i class="icon-pencil icon-white"></i></a>
							<a onclick="delete_content(' . $row->ID . ",'" . $type . "'" . ');" class="btn btn-mini btn-inverse"><i class="icon-trash icon-white"></i></a></td>
					</tr>';


			}
		}

		$table_str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";

		echo '</tbody>
			</table>
			<hr />
			<div id="modal-content-delete" class="modal hide fade">

				<div class="modal-header">
				   <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				  <h3>Delete the Content</h3>
				</div>
				 <div class="modal-body">
				   <p>Are you sure you want to completely remove the current content and all of its resources?</p>

				</div>

				<div class="modal-footer">
				  <a href="#" class="btn btn-primary">Delete</a>
				  <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
				</div>

			</div>
			<div class="clearfix" style="height:30px;"></div>
			<script type="text/javascript">
				$(document).ready(function(){
					$("[rel=tooltip]").tooltip();

					$("#content_tbl").dataTable( {
							  "sDom": "'.$table_str.'",
							  "sPaginationType": "bootstrap",
							  "oLanguage": {
								  "sLengthMenu": "_MENU_ records per page"
							  },
							  "aaSorting":[],
							  "bSortClasses": false

					} );
				});


				function update_content(id, type){

					var cont = $("#admin_content");
					cont.empty();
					cont.addClass("loading_img");
					$.ajax({
							type: "get",
							cache: false,
							url: "'.site_url('/').'my_admin/content_single/"+id +"/"+ type,
							success: function (data) {
									cont.removeClass("loading_img");
									cont.html(data);

							}
						});

				}
				function delete_content(id, type1){


					$("#modal-content-delete").bind("show", function() {
						var removeBtn = $(this).find(".btn-primary"),
							href = removeBtn.attr("href");

							removeBtn.click(function(e) {

								e.preventDefault();

										$.ajax({
											type: "post",
											url: "'.site_url('/').'my_admin/delete_content/" ,
											data: {id: id, type: type1},
											success: function (data) {

												 $("#modal-content-delete").modal("hide");
												 //$("#deal_img").html(data);
												 load_ajax("content/"+type1);
											}
										});
							});
					}).modal({ backdrop: true });
				}

			</script>';




	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+CONTENT UPDATES BACKEND
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_content_edit_single($id, $type){



		if($type == 'regions'){

			$typeDB = 'a_map_region';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".REGION_NAME as title, ".$typeDB.".COVER_PHOTO as cover, ".$typeDB.".DESCRIPTION as body FROM ".$typeDB." WHERE  ".$typeDB.".ID = '".$id."'");


			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}

		}elseif($type == 'towns'){

			$typeDB = 'a_map_location';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".MAP_LOCATION as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB." WHERE  ".$typeDB.".ID = '".$id."'");

			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}

		}elseif($type == 'culture'){

			$typeDB = 'culture';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB." WHERE  ".$typeDB.".ID = '".$id."'");

			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}
		}elseif($type == 'animals'){
			$typeDB = 'animals';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,
									".$typeDB.".DESCRIPTION as body,  ".$typeDB.".CATEGORY_ID as cat_deal, ".$typeDB.".SCIENTIFIC_NAME as sname,
									".$typeDB.".DANGER_TEXT as dtext, ".$typeDB.".DIET as diet, ".$typeDB.".WEIGHt as weight, ".$typeDB.".SIZE as size
									FROM ".$typeDB."
									WHERE  ".$typeDB.".ID = '".$id."'");

			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}


		}elseif($type == 'birds'){

			$typeDB = 'birds';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB." WHERE  ".$typeDB.".ID = '".$id."'");

			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}
		}elseif($type == 'must_know'){
			$typeDB = 'must_know';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB." WHERE  ".$typeDB.".ID = '".$id."'");

			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}

		}elseif($type == 'plants'){

			$typeDB = 'plants';
			//$this->db->where('ID', $id);
			$q = $this->db->query("SELECT ".$typeDB.".*, ".$typeDB.".NAME as title, ".$typeDB.".COVER_PHOTO as cover,  ".$typeDB.".DESCRIPTION as body FROM ".$typeDB." WHERE  ".$typeDB.".ID = '".$id."'");

			if($q->result()){
				$data = $q->row_array();
				$data['type'] = $type;
				$data['id'] = $id;
				$this->load->view('admin/inc/content', $data);
			}else{



			}

		}



	}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+MEMBER Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//Get MAP Details
	function get_map_details($ID){
      	
		$test = $this->db->where('BUSINESS_ID', $ID);
		$test = $this->db->get('u_business_map');
		return $test->row_array();		  
    }		 	
	//UPDATE MAP COORDINATES
	function update_map_coordinates(){
      	
		$user_id = $this->input->post('admin_id', TRUE);
		$bus_id = $this->input->post('bus_id', TRUE);
		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);
		
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('u_business_map');
		
		//MY NA MAIN DB
		if($test->num_rows() > 0){
			
		       //populate array with values
				$data = array( 
						  'BUSINESS_MAP_LATITUDE'=> $lat,
						  'BUSINESS_MAP_LONGITUDE'=> $lng
						 
				);
			   
			    //update database
				$this->db->where('BUSINESS_ID', $bus_id);
				$this->db->update('u_business_map',$data);

		}else{
			
				//populate array with values
				$data = array( 
						  'BUSINESS_MAP_LATITUDE'=> $lat,
						  'BUSINESS_MAP_LONGITUDE'=> $lng,
						  'BUSINESS_ID' => $bus_id,
						  'BUSINESS_MAP_ZOOM_LEVEL' => '13'
				);

				$this->db->insert('u_business_map',$data);

				
		}
		
		/*$db2 = $this->connect_tourism_db();
		$test1 = $db2->where('ID', $bus_id);
		$test1 = $db2->get('u_business');

		
		if($test1->result()){
			
			$test2 = $db2->where('BUSINESS_ID', $bus_id);
			$test2 = $db2->get('u_business_map');
			//MY NA TOURISM DB
			if($test2->num_rows() > 0){
				
				   //populate array with values
					$data = array( 
							  'BUSINESS_MAP_LATITUDE'=> $lat,
							  'BUSINESS_MAP_LONGITUDE'=> $lng
							 
					);
				   
					$db2->where('BUSINESS_ID', $bus_id);
					$db2->update('u_business_map', $data);
			}else{
				
					//populate array with values
					$data = array( 
							  'BUSINESS_MAP_LATITUDE'=> $lat,
							  'BUSINESS_MAP_LONGITUDE'=> $lng,
							  'BUSINESS_ID' => $bus_id,
							  'BUSINESS_MAP_ZOOM_LEVEL' => '13'
					);
	
					$db2->insert('u_business_map',$data);
					
			}
		}*/
		return;
				  
    }

	//Get all Countries For Registration Dropdown
	function get_countries(){
      	
		$test = $this->db->get('a_country');
		return $test;		  
    }
	
	//Get Account Details
	function get_my_account($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');
		return $test->row_array();		  
    }

	//Get CLIENT ROW
	function get_client_row($id){
      	
		$this->db->where('ID', $id);
		$query = $this->db->get('u_client');
		if($query->result()){
			return $query->row_array();	
			
		}else{
			 $data['ID'] = 0;
			 $data['CLIENT_NAME'] = '';
			 $data['CLIENT_SURNAME'] = '';
			return $data;	
			
		}	  
    }
	//Get BUSINESS ROW
	function get_business_row($id){
      	
		$this->db->where('ID', $id);
		$query = $this->db->get('u_business');
		if($query->result()){
			return $query->row_array();	
			
		}else{
			 $data['ID'] = 0;
			 $data['CLIENT_NAME'] = '';
			 $data['CLIENT_SURNAME'] = '';
			return $data;	
			
		}	  
    }
	//+++++++++++++++++++++++++++
	//BUSINESS DETAILS EDIT
	//++++++++++++++++++++++++++		 
		 
	function get_business_details($bus_id){
			
		$test = $this->db->where('ID', $bus_id);
		$test = $this->db->get('u_business');
		return $test->row_array();	

	}		
    //+++++++++++++++++++++++++++
	//GET PAGE DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_page($page_id){
			
		$test = $this->db->where('page_id', $page_id);
		$test = $this->db->get('pages');
		return $test->row_array();	

	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET ALL DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_deals($str, $bus_id){
		
		if($str == 'active')
		{


			$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > CURDATE()", false);

		}elseif($bus_id != 0){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE SPECIALS_EXPIRE_DATE < CURDATE() AND BUSINESS_ID != 0", false);

		}elseif($str == 'expired'){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE SPECIALS_EXPIRE_DATE < CURDATE()", false);


		}elseif($str == 'specials'){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE SPECIAL_TYPE = 'special'", false);

		}elseif($str == 'deals'){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE SPECIAL_TYPE = 'deal'", false);

		}elseif($str == 'cymot'){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE BUSINESS_ID = '514'", false);

		}elseif($str == 'cymot_active'){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE BUSINESS_ID = '514' AND IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > CURDATE()", false);

		}elseif($str == 'cymot_expired'){

			$query = $this->db->query("SELECT * FROM u_special_component WHERE BUSINESS_ID = '514'  AND SPECIALS_EXPIRE_DATE < CURDATE()", false);

		}elseif($str == 'cymot_archive'){

			$query = $this->db->query("SELECT * FROM u_special_component_archive WHERE BUSINESS_ID = '514'", false);
		}else{

			$query = $this->db->query("SELECT * FROM u_special_component LIMIT 10" ,FALSE);


		}

		if($query->result()){
			
			echo'
					<div class="btn-group pull-right">
						<button class="btn">Filter</button>
		                <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		                <ul class="dropdown-menu">
		                  <li><a href="javascript:load_ajax('."'deals/'".');">All Live</a></li>
		                  <li><a href="javascript:load_ajax('."'deals/expired'".');">Expired</a></li>
		                  <li><a href="javascript:load_ajax('."'deals/active'".');">All Active</a></li>
		                  <li><a href="javascript:load_ajax('."'deals/specials'".');">Specials</a></li>
		                  <li><a href="javascript:load_ajax('."'deals/deals'".');">Deals</a></li>
		                  <li><a href="javascript:load_ajax('."'deals/live/1'".');">All Business Deals</a></li>
		                  <li class="nav-header">Cymot Deals</li>
		                  <li class="dropdown-submenu">
						    <a tabindex="-1" href="#">Cymot </a>
						    <ul class="dropdown-menu">
								  <li><a href="javascript:load_ajax('."'deals/cymot'".');">Cymot All</a></li>
								  <li><a href="javascript:load_ajax('."'deals/cymot_active'".');">Cymot Active</a></li>
								  <li><a href="javascript:load_ajax('."'deals/cymot_expired'".');">Cymot Expired</a></li>
								  <li><a href="javascript:load_ajax('."'deals/cymot_archive'".');">Cymot Archive</a></li>

						    </ul>
						  </li>

		                </ul>
		         </div>

		         <a href="'.site_url('/').'deals/clean_cymot/" target="_blank" class="btn btn-danger pull-right"><i class="icon-download-alt icon-white"></i> Archive Cymot Deals</a>&nbsp;
		         <a href="'.site_url('/').'deals/set_cymot_specials/" target="_blank" class="btn btn-danger pull-right"><i class="icon-pencil icon-white"></i>Cymot Deals to Specials</a>&nbsp;
                <a href="'.site_url('/').'deals/extend_cymot_deals/" target="_blank" class="btn btn-danger pull-right"><i class="icon-pencil icon-white"></i> Extend Cymot by 1 Week</a>&nbsp;
			<h4>Deals<small> Your current deals</small></h4>
			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="deal_tbl" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:30%">Title</th>
						<th style="width:10%">Price</th>
						<th style="width:12%">Start</th>
						<th style="width:13%">End</th>
						<th style="width:5%">Q</th>
						<th style="width:5%">Claims</th>
						<th style="width:20%;min-width:100px"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$no_img = '<span class="badge badge-danger">No</span>';
				if($row->SPECIALS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					$no_img = '<span class="badge badge-danger">No</span>';
				}else{
					
					$img = base_url('/').'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;

					$imgP = BASE_URL.'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					if(file_exists($imgP)){

						$no_img = '<span class="badge badge-success">Yes</span>';

					}


				}
				
				if($row->IS_ACTIVE == 'Y'){
					
					$active = '<a class="btn btn-mini btn-success" title="Deal is live" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					
				}else{
					
					$active = '<a class="btn btn-mini btn-warning" title="Not approved" rel="tooltip"><i class="icon-time icon-white"></i></a>';
					
				}
				
				if(date('Y-m-d',strtotime($row->SPECIALS_EXPIRE_DATE)) < date('Y-m-d')){
					
					$active = '<a class="btn btn-mini btn-warning" title="Deal is expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					
				}

				echo '<tr>
						<td style="width:5%;min-width:40px">'.$no_img.'</td>
						<td style="width:30%">'.$row->SPECIALS_HEADER .'</td>
						<td style="width:10%">N$ '.$row->SPECIALS_PRICE .'</td>
						<td style="width:12%">'.date('Y-m-d',strtotime($row->SPECIALS_STARTING_DATE)) .'</td>
						<td style="width:13%">'.date('Y-m-d',strtotime($row->SPECIALS_EXPIRE_DATE)).'</td>
						<td style="width:5%">'.$row->QUANTITY.'</td>
						<td style="width:5%"><span class="badge">'.$this->count_claims($row->ID).'</span></td>
					  	<td style="width:20%;min-width:100px;text-align:right">  
							'.$active.'
							<a onclick="deal_stats('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-cog icon-white"></i></a>
							<a onclick="update_deal('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-pencil icon-white"></i></a> 
							<a onclick="delete_deal('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}
			$table_str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			$exit_str = "javascript:$('#modal-deal-delete').modal('hide')"; 
			echo '</tbody>
				</table>
				<hr />
				<div id="modal-deal-delete" class="modal hide fade">

					<div class="modal-header">
					  <a href="#" onclick="'.$exit_str.'" class="close">&times;</a>
					  <h3>Delete the Deal</h3>
					</div>
					 <div class="modal-body">
					   <p>Are you sure you want to completely remove the current deal and all of its resources?</p>
						
					</div>
				
					<div class="modal-footer">
					  <a href="#" class="btn btn-primary">Delete</a> 
					  <a href="#" onclick="'.$exit_str.'" class="btn btn-secondary">No</a>
					</div>
				 
				</div>
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					$(document).ready(function(){
						$("[rel=tooltip]").tooltip();
						$("#step_1").click(function () {
							 $("#tna_step_2_li").addClass("active");
							 $("#tna_step_1_li").removeClass("active");
						});

						$("#deal_tbl").dataTable( {
								  "sDom": "'.$table_str.'",
								  "sPaginationType": "bootstrap",
								  "oLanguage": {
									  "sLengthMenu": "_MENU_ records per page"
								  },
								  "aaSorting":[],
								  "bSortClasses": false

						} );
					});



					function update_deal(id){
	
						var cont = $("#admin_content");
						cont.empty();
						cont.addClass("loading_img"); 
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'my_admin/update_deal/"+id ,
								success: function (data) {
										cont.removeClass("loading_img"); 
										cont.html(data);
										
								}
							});	 
						
					}  
					function delete_deal(id){
	
						
						$("#modal-deal-delete").bind("show", function() {
							var removeBtn = $(this).find(".btn-primary"),
								href = removeBtn.attr("href");
								
								removeBtn.click(function(e) { 
										
									e.preventDefault();
					
											$.ajax({
												type: "post",
												url: "'.site_url('/').'deals/delete_deal/" ,
												data: {deal_id: id},
												success: function (data) {
													 
													 $("#modal-deal-delete").modal("hide");
													 $("#deal_img").html(data);
													 load_ajax("deals");
												}
											});
								});
						}).modal({ backdrop: true });
					}					
					function deal_stats(id){
	
						var cont = $("#admin_content");
						cont.empty();
						cont.addClass("loading_img"); 
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url("/").'deals/deal_stats/"+id ,
								success: function (data) {
										cont.removeClass("loading_img"); 
										cont.html(data);
										
								}
							});	 
						
					}
				</script>';
			
		 }else{
			
			echo '<div class="alert">
				<a onclick="toggle_deal_add()" class="btn pull-right"><i class="icon-plus-sign"></i> Add New Deal</a>
				 <h4>No Deals added</h4> No deals have been added.
				 
				</div>'; 
			 
			 
		 }
		  	  
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//IS THE DEAL CLAIMED?
	//++++++++++++++++++++++++++
    public function count_claims($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('deal_id',$id);
		$query = $this->db->get('u_special_claims');
		if($query->result()){
		    return $query->num_rows;	
		}else{
			return 0;
		}		
    }
    //+++++++++++++++++++++++++++
	//GET ALL BUSINESSES
	//++++++++++++++++++++++++++
	public function get_businesses()	
	{
		//$this->load->library('cache');
		//TEST CACHE
		//if ( ! $output = $this->cache->get('businesses')){
			$output = '';
			 $query = $this->db->query("SELECT u_business.*, a_map_location.MAP_LOCATION, a_map_suburb.SUBURB_NAME FROM u_business
										LEFT JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
										LEFT JOIN a_map_suburb ON u_business.BUSINESS_SUBURB_ID = a_map_suburb.ID
										");
			 
			 //var_dump($query);
			  if($query->result()){
				$output ='<h3>Businesses <small>My Namibia</small></h3>
				<div class="btn-group pull-right">
				  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				    <i class="icon-download-alt"></i> Export
				    <span class="caret"></span>
				  </a>
				  <ul class="dropdown-menu">
				    <li><a href="'.site_url('/').'csv/export_business/" target="_blank">Export All</a></li>
				    <li><a href="'.site_url('/').'csv/export_business/HAN" target="_blank">Export HAN</a></li>
				  </ul>
				</div>
				<hr />
				<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
					<thead>
						<tr style="font-weight:bold">
							<th style="width:5%">ID</th>
							<th style="width:20%">Name </th>
							<th style="width:5%">Active</th>
							<th style="width:15%">Email </th>
							<th style="width:10%">Location </th>
							<th style="width:7%">NCCI</th>
							<th style="width:7%">NTB</th>
							<th style="width:7%">HAN</th>
							<th style="width:15%">Date</th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>';
				
				foreach($query->result() as $row){
					$active_str = "'Y'";
					$active = '<a onclick="set_business_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-important">NO</span></a>';
					$btn = '<a onclick="set_business_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-ok"></i></a>';
					if($row->ISACTIVE == 'Y'){
						$active_str = "'N'";
						$active = '<a onclick="set_business_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-success">YES</span></a>';
						$btn = '<a onclick="set_business_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-remove"></i></a>';
					}
					
					$del_str = "'businesses'";
					
					$output .= '<tr>
							<td style="width:5%">'.$row->ID.'</td>
							<td style="width:20%"><a href="'.site_url('/').'my_admin/business_details/'.$row->ID.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->BUSINESS_NAME .'</div></a></td>
							<td style="width:5%">'.$active.'</td>
							<td style="width:15%">'.$row->BUSINESS_EMAIL.'</td>
							<td style="width:10%">'.$row->MAP_LOCATION . ' '.$row->SUBURB_NAME.'</td>
							<td style="width:7%">NCCI-'.$row->IS_NCCI_MEMBER.'</td>
							<td style="width:7%">NTB-'.$row->IS_NTB_MEMBER.'</td>
							<td style="width:7%">HAN-'.$row->IS_HAN_MEMBER.'</td>
							<td style="width:15%">'.date('Y-m-d h:i:s', strtotime($row->BUSINESS_DATE_CREATED)).'</td>
							<td style="width:10%;min-width:60px;">
								<a href="'.site_url('/').'my_admin/business_details/'.$row->ID.'"><i class="icon-pencil"></i></a>
								'.$btn.'
								<a href="javascript:void(0);" onclick="delete_business('.$row->ID.', '.$del_str.')"><i style="margin-left:5px" class="icon-trash"></i></a>
							</td>
						  </tr>';
				}
				
				
				$output .= '</tbody>
					</table>
					<hr />
					<div class="clearfix" style="height:30px;"></div>
					<script type="text/javascript">
					
					function set_business_status(id, status){
	 
							  $.ajax({
								  type: "get",
								  cache: false,
								  url: "'.site_url('/').'my_admin/set_business_status/"+id+"/"+status ,
								  success: function (data) {
									 
									 $("#msg_admin").html(data);
									 window.setTimeout( load_ajax("businesses") , "2000");
										  
								  }
							  });	 					
					}
					
	
					
					</script>';
				
			 }else{
				  
				 $output .= '<div class="alert">NO Businesses Added</div>';
			 
			 }
			    // Save into the cache
     			//$this->cache->write('businesses', $output, 7200);
			
		//}
		
		echo $output;	 
		  
	}
	
	
	//+++++++++++++++++++++++++++
	//GET ALL BUSINESSES CLAIMS
	//++++++++++++++++++++++++++
	public function get_businesses_claims()	
	{
		//$this->load->library('cache');
		//TEST CACHE
		//if ( ! $output = $this->cache->get('businesses')){
			$output = '';
			 $this->db->order_by('ID', 'DESC');
			 $query = $this->db->get('i_client_business_claims');
			  if($query->result()){
				$output ='<h3>Business Claims <small>My Namibia</small></h3>
				
				<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
					<thead>
						<tr style="font-weight:bold">
							<th style="width:5%">ID</th>
							<th style="width:25%">Name </th>
							<th style="width:25%">Business </th>
							<th style="width:10%">Type </th>
							<th style="width:15%">Date </th>
							<th style="width:10%">Action </th>
							<th style="width:10%"></th>
						</tr>
					</thead>
					<tbody>';
				
				foreach($query->result() as $row){
					
					$client = $this->get_member_details($row->CLIENT_ID);
					
					$this->db->where('CLIENT_ID', $row->CLIENT_ID);
					$this->db->where('BUSINESS_ID', $row->BUSINESS_ID);
					$is_member = $this->db->get('i_client_business');
					
					if($is_member->result()){
						
						$is_member = '<span class="badge badge-success">Actioned</span>';	
						
					}else{
						
						$is_member = '<span class="badge badge-important">Not</span>';
						
					}
					
					$output .= '<tr>
							<td style="width:5%">'.$row->ID.'</td>
							<td style="width:25%"><a href="'.site_url('/').'my_admin/member/'.$row->CLIENT_ID.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$client['CLIENT_NAME'] .'</div></a></td>
							<td style="width:25%"><a href="'.site_url('/').'my_admin/business_details/'.$row->BUSINESS_ID.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$this->get_business_name($row->BUSINESS_ID) .'</div></a></td>
							<td style="width:10%">'.$row->USER_TYPE.'</td>
							<td style="width:15%">'.date('Y-m-d h:i:s', strtotime($row->DATETIME)).'</td>
							<td style="width:10%">'.$is_member.'</td>
							<td style="width:10%;min-width:60px;text-align:right">
								<a onclick="process_claim('.$row->ID.')" class="btn btn-mini btn-success" href="#" title="Approve" rel="tooltip"><i class="icon-play icon-white"></i></a>
								<a onclick="delete_claim('.$row->ID.')" class="btn btn-mini btn-danger" href="#"><i class="icon-trash icon-white"></i></a>
							</td>
						  </tr>';
				}
				
				
				$output .= '</tbody>
					</table>
					<hr />
					<div class="clearfix" style="height:30px;"></div>
					<script type="text/javascript">
					
					function delete_claim(id){
	 
							  $.ajax({
								  type: "get",
								  cache: false,
								  url: "'.site_url('/').'my_admin/delete_business_claim/"+id+"/",
								  success: function (data) {
									 
									 $("#msg_admin").html(data);
									 window.setTimeout( load_ajax("business_claims") , "2000");
										  
								  }
							  });	 					
					}
					
					
					function process_claim(id){
	 
							  $.ajax({
								  type: "get",
								  cache: false,
								  url: "'.site_url('/').'my_admin/process_business_claim/"+id+"/",
								  success: function (data) {
									 
									 $("#msg_admin").html(data);
									 window.setTimeout( load_ajax("business_claims") , "2000");
										  
								  }
							  });	 					
					}
					
					</script>';
				
			 }
			 
			    // Save into the cache
     			//$this->cache->write('businesses', $output, 7200);
			
		//}
		
		echo $output;	 
		  
	}
	//PROCESS BUSINESSES CLAIMS	
	function process_business_claim($id){

		$this->db->where('ID', $id);
		$claim = $this->db->get('i_client_business_claims');
		
		if($claim->result()){
			
			$row = $claim->row_array();
			
			$client = $this->get_client_row($row['CLIENT_ID']);
			$business = $this->get_business_name($row['BUSINESS_ID']);
			
			//INSERT DATABASE
			$this->add_business_member($row['BUSINESS_ID'] ,$row['CLIENT_ID']);
			
			//BUILD BODY
			$body = 'Hi '.$client['CLIENT_NAME'] .',<br /><br />
					We have processed your business claim request for '.$business.' and added you as an administrator.<br /><br />
					You can now fully administer the business online from your My Namibia dashboard.<br /><br />
					Find your business under the My business section in the <a href="'.site_url('/').'members/">dashboard</a>.<br /><br />
					If you have any questions or are experiencing difficulties please contact us by emailing info@my.na<br /><br />
					Have a !tna day!<br />
					My Namibia';
					
			$data_view['body'] = $body;
			$body_final = $this->load->view('email/body_news',$data_view,true);
			$subject = 'Business Claim '.$business;
			$fromEMAIL = 'no-reply@my.na';
			$fromNAME = 'My Namibia';
			$TAG = array('tags' => 'business_claim' );
			$emailTO = array(array('email' => $client['CLIENT_EMAIL'] )); 	
				
			//SEND EMAIL LINK
			$this->load->model('email_model');	
			$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);

			echo '<div class="alert alert-success">Business Claim actioned</div>';	
		}

	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET ALL DEALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_products($section = '', $bus_id = 0){

		//$id = $this->session->userdata('id');
		$this->load->model('trade_model');
		if($section == ''){
			$section = 'live';
		}
 
		$this->load->model('image_model'); 

		$this->load->library('thumborp');
		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 190;
		$height = 130;


		//JOUBERT BALT PRIVATE
		$strSQL = '';
		if($bus_id == 8848){

			$strSQL= " AND products.client_id = '".$id."'";

		}

		$legend = '<div class="well well-mini">
					<small class="muted"><strong>What do the buttons do?</strong> Move the mouse over each button for descriptions <i class="icon-question-sign icon-white"></i></small>
					<div class="pull-right">
						<a class="btn btn-mini btn-success" title="The item is live and not expired" rel="tooltip" href="javascript:void(0)"><i class="icon-ok icon-white"></i></a>
						<a href="javascript:void(0)" class="btn btn-mini btn-warning" title="Listing date. Is product expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>
						<a class="btn btn-mini btn-success" href="javascript:void(0)" title="Mark item as sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>
						<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the print options" rel="tooltip" data-toggle="dropdown">Export <span class="caret"></span></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a ><i class="icon-print"></i> Print Option 1</a></li>
				                  <li><a ><i class="icon-print"></i> Print Option 2</a></li>
				                  <li class="divider"></li>
				                  <li><a ><i class="icon-share"></i> Export PDF 1</a></li>
				                  <li><a ><i class="icon-share"></i> Export PDF 2</a></li>
				                </ul>
				            </div>
							<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the product menu" rel="tooltip" data-toggle="dropdown"><i class="icon-cog"></i></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a><i class="icon-pencil"></i> Update Item</a></li>
				                  <li><a><i class="icon-trash"></i> Remove Item</a></li>
								  <li><a><i class="icon-search"></i> View Item</a></td></li>
				                </ul>
				            </div>
						<a href="javascript:void(0)" class="btn btn-mini btn-inverse" title="Preview the current item" rel="tooltip"> View</a>
					</div>


				 </div>



				 ';
        $pSQL = "SELECT CONCAT(u_client.CLIENT_NAME, ' ' , u_client.CLIENT_SURNAME) as client_name, u_client.CLIENT_CELLPHONE,
        							  u_client.DIAL_CODE, u_business.BUSINESS_NAME,
                                      products.*,products_buy_now.amount,products_buy_now.buy_now_id, trade_rating.rating, trade_rating.review, trade_rating.created_at,
                                      product_extras.*,product_images.img_file, product_questions.question_id,product_categories.category_name,
                                      group_concat(trade_rating.rating,'-_-',trade_rating.type,'-_-',REPLACE(trade_rating.review, ',', ' '),'-_-',trade_rating.created_at) as rating_a,
                                      MAX(product_auction_bids.amount) as current_bid
                                      FROM products
                                      JOIN u_client ON u_client.ID = products.client_id
                                      LEFT JOIN product_extras ON products.product_id = product_extras.product_id
                                      LEFT JOIN product_categories ON product_categories.cat_id = products.sub_sub_cat_id
                                      LEFT JOIN products_buy_now ON products.product_id = products_buy_now.product_id
                                      LEFT JOIN u_business ON products.bus_id = u_business.ID
                                      LEFT JOIN trade_rating ON trade_rating.buy_now_id = products_buy_now.buy_now_id
                                      LEFT JOIN product_images ON products.product_id = product_images.product_id
                                      LEFT JOIN product_questions ON product_questions.product_id = products.product_id
                                      LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                      ";
		if($bus_id != 0){
			$col4H = '<th style="width:12%">Q</th>';
			$bstr = '';
			$query = $this->db->query($pSQL." WHERE  products.status = '".$section."' AND products.bus_id != 0 GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

        }elseif($section == 'moderate'){
            $col4H = '<th style="width:12%">Items To Moderate</th>';
            $bstr = 'Moderate';
            $query = $this->db->query($pSQL." WHERE products.status = 'moderate' GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);


		}elseif($section == 'properties'){
			$col4H = '<th style="width:12%">Properties</th>';
			$bstr = 'Live';
			$query = $this->db->query($pSQL." WHERE products.status = 'live' AND products.main_cat_id = 3408 GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}elseif($section == 'cars'){
			$col4H = '<th style="width:12%">Cars</th>';
			$bstr = 'Live';
			$query = $this->db->query($pSQL."  WHERE products.status = 'live' AND products.main_cat_id = 348 GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}elseif($section == 'auctions'){
			$col4H = '<th style="width:12%">Auctions</th>';
			$bstr = 'Live';
			$query = $this->db->query($pSQL." WHERE products.status = 'live' AND products.listing_type = 'A' GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);


		}elseif($section == 'live'){
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Live';
			$query = $this->db->query($pSQL." WHERE products.status = 'live'  GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}elseif($section == 'sold'){
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query($pSQL." WHERE products.status = 'sold' GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}elseif($section == 'expired'){
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query($pSQL." WHERE products.end_date < CURDATE()  GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}elseif($section == 'active'){
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query($pSQL." WHERE products.end_date > CURDATE() AND products.status = 'live' GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);



		}else{
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Business';
			$query = $this->db->query($pSQL."  WHERE products.status = '".$section."' ".$strSQL." ORDER BY products.product_id DESC" ,FALSE);
		}
		if($query->result()){

			echo $legend.'
			<div class="row-fluid">
				<div class="span7">
					<h4>Listings<small> Your current '.$bstr.' items</small></h4>
				</div>
				<div class="span5 text-right">
                     <a class="btn btn-danger" href="javascript:load_ajax('."'load_products/moderate'".');">! Under Moderation</a>

					  <div class="btn-group">
						<button class="btn">Filter</button>
		                <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		                <ul class="dropdown-menu pull-right">
		                  <li><a href="javascript:load_ajax('."'load_products/live'".');">All Live</a></li>
		                  <li><a href="javascript:load_ajax('."'load_products/expired'".');">Expired</a></li>
		                  <li><a href="javascript:load_ajax('."'load_products/active'".');">All Active</a></li>
		                  <li><a href="javascript:load_ajax('."'load_products/sold'".');">Sold</a></li>
		                  <li><a href="javascript:load_ajax('."'load_products/live/1'".');">All Business Products</a></li>
		                  <li class="dropdown-submenu">
						    <a tabindex="-1" href="#">Categories</a>
						    <ul class="dropdown-menu">
						      <li><a href="javascript:load_ajax('."'load_products/properties'".');">Properties</a></li>
						      <li><a href="javascript:load_ajax('."'load_products/cars'".');">Cars</a></li>
						      <li><a href="javascript:load_ajax('."'load_products/properties'".');">Spare</a></li>

						    </ul>
						  </li>
						  <li><a href="javascript:load_ajax('."'load_products/auctions'".');">All Auctions</a></li>
		                </ul>
		            </div>



					<div class="btn-group text-left">
						<button class="btn">Export</button>
		                <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		                <ul class="dropdown-menu pull-right">
		                  <li><a href="javascript:void(0);" class="btnPrint" data-section="'.$section.'"><i class="icon-print"></i> Print</a></li>
		                  <li><a href="javascript:void(0);" class="btnExport" data-section="'.$section.'"><i class="icon-share"></i> Export PDF</a></li>
		                  <li><a href="javascript:void(0);" class="btnCsv" data-section="'.$section.'"><i class="icon-share"></i> Export CSV</a></li>

		                </ul>
		            </div>



				</div>
			</div>

			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped datatable" id="" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:8%;min-width:40px"></th>
           				<th style="width:20%">Title</th>
						<th style="width:10%">Type</th>
						<th style="width:15%">Price</th>
						<th style="width:10%">End</th>
						<th style="width:5%">Q</th>
						'.$col4H .'
						<th style="width:25%;min-width:130px"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				//AGENCY COLUMN

				$col4 = '<td style="width:5%">'.$row->quantity.'</td>';
				//if($section == 'live_agent' || $section == 'sold_agent' || $bus_id != 0){
					$col4 = '<td style="width:12%">None</td>';
					$agent_ref = '';
					//PROPERTY REFERENCE
					if(count(json_decode($row->extras)) > 0){

						foreach(json_decode($row->extras) as $exr => $exv){

							if($exr == 'agency' && $exv != ''){

								$agent_ref = '<span  class="label" rel="tooltip"  title="Product Reference">Ref: <strong itemprop="sku">'.$exv.'</strong></span>';
								//$col4 = $agent_ref;
							}

						}

					}
                    $name = '';
                    if(isset($row->client_name)){

                        $name = ' > <a href="'.site_url('/').'/my_admin/member/'.$row->client_id.'/" target="_blank">'.$row->client_name.'</a>';
                    }
					//GET AGENT DETAILS
					if($row->property_agent != 0){
						$this->db->where('ID', $row->property_agent);
						$agent = $this->db->get('u_client');
						if($agent->result()){

							$agentR = $agent->row();
							$col4 = '<td style="width:12%">'.$row->BUSINESS_NAME . ' : ' .$agent_ref. ' ' .$agentR->CLIENT_NAME. ' ' .$agentR->CLIENT_SURNAME.' '.' +'.$row->DIAL_CODE .$row->CLIENT_CELLPHONE.'</td>';
						}
					}else{

						$col4 = '<td style="width:12%">'.$row->BUSINESS_NAME . $name.' '.$agent_ref.'  +'.$row->DIAL_CODE .$row->CLIENT_CELLPHONE.'</td>';

					}


				//}

                if($row->img_file != null){

					$img_str = 'assets/products/images/' . $row->img_file;

					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

                }else{

                    $img_url = base_url('/').'img/product_blank.jpg';
                }




				//CHECK SOLD BUTTON
				$soldBTN = '';
				//if($bus_id != 0){
					$soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status('.$row->product_id.', '. "'live'".');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star icon-white"></i></a>';
					if($row->status == 'live'){
						$soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status('.$row->product_id.', '. "'sold'".');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>';
					}else{
						$soldBTN = '<a class="btn btn-mini btn-warning" onclick="update_product_status('.$row->product_id.', '. "'live'".');" title="Mark Item as Live" rel="tooltip"><i class="icon-star icon-white"></i></a>';

					}
				//}

				//Check Price
				//Fixed price
				if($row->listing_type == 'S'){

					$type = '<span class="label">Buy Now</span>';
					$price = 'N$ '. $row->sale_price;

					$bids = '';
					//Auction
				}elseif($row->listing_type == 'A'){

					//GET CURRENT BID
					$bids = $this->trade_model->get_current_bid($row->current_bid);
					$type = '<span class="label">Auction</span>';
					$price = 'Current Bid: N$ '.$bids['current'].' Res: ' .$row->reserve;

				}elseif($row->listing_type == 'C'){

					$type = '<span class="label">Service</span>';
					$price = 'N$ '. $row->sale_price;

					$bids = '';

				}
                $approve = '';
				if($row->is_active == 'Y'){
					/*if($row->bus_id != 0){
						$active = '<a onclick="activate_product('.$row->product_id.', '. "'N'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-success" title="Product is live - click to deactivate" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					}else{

						$active = '<a class="btn btn-mini btn-success" title="Product is live" id="act_'.$row->product_id.'" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					}*/
                    $active = '<a onclick="activate_product('.$row->product_id.', '. "'N'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-success" title="Product is live - click to deactivate" rel="tooltip"><i class="icon-play icon-white"></i></a>';
				}else{
					/*if($row->bus_id != 0){
						$active = '<a onclick="activate_product('.$row->product_id.', '. "'Y'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Not approved - Click to make it live" rel="tooltip"><i class="icon-time icon-white"></i></a>';
					}else{

						$active = '<a class="btn btn-mini btn-warning" id="act_'.$row->product_id.'" title="Not approved" rel="tooltip"><i class="icon-time icon-white"></i></a>';
					}*/
                    if($row->status == 'moderate') {
                        $approve = ' <a onclick="approve_product_do('.$row->product_id.', '. "'Y'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-dnager" title="Not approved - Click to approve it and send email" rel="tooltip"><i class="icon-play"></i></a>';

                    }
                    $active =  $approve.' <a onclick="activate_product('.$row->product_id.', '. "'Y'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Click to make it live" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
				}
                $extend = '';
				//SEE IF EXPIRED
				if(date('Y-m-d',strtotime($row->end_date)) < date('Y-m-d')){

					/*if($row->bus_id != 0){
						$active = '<a onclick="activate_product('.$row->product_id.', '. "'Y'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Item is expired - Click to activate" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					}else{

						$active = '<a class="btn btn-mini btn-warning" id="act_'.$row->product_id.'" title="Item is Expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					}*/
                    $extend = '<a onclick="extend_product('.$row->product_id.','."'".$row->listing_type."'".');" id="ext_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Item is expired - Click to extend by another 30 days" rel="tooltip"><i class="icon-time icon-white"></i></a>';
				}

				//GET QUESTIONS
				$this->db->where('product_id', $row->product_id);
				$q = $this->db->get('product_questions');
				$questions = '';


                $questions = '';

                if($row->question_id){

                        $questions = ' <a onclick="get_questions('.$row->product_id.');" class="btn btn-mini btn-danger" rel="tooltip" title="Click to view questions"><i class="icon-question-sign icon-white"></i></a> ';

                }

				$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->trade_model->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";

				echo '<tr id="row_'.$row->product_id.'">
						<td style="width:8%;min-width:40px"><img src="'.$img_url.'"
							alt="" style="width:80%;height:auto" class="img-polaroid"/> </td>
						<td style="width:20%">'.$row->category_name.' > '.$row->title .'</td>
						<td style="width:10%">'.$type.'</td>
						<td style="width:15%">'.$price .'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->end_date)).'</td>
						<td style="width:5%">'.$row->quantity.'</td>
						'.$col4.'
					  	<td style="width:25%;min-width:130px;text-align:right">
									'.
                            $extend.' '.
							$questions.' '
							.$active. ' '.
							$soldBTN.
							'
							<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the print options" rel="tooltip" data-toggle="dropdown">Export <span class="caret"></span></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a href="'.site_url('/').'trade/print_product/'.$row->product_id.'/" data-id="'.$row->product_id.'" class="btnPrint_single"><i class="icon-print"></i> Print Option 1</a></li>
				                  <li><a href="'.site_url('/').'trade/print_product2/'.$row->product_id.'/" data-id2="'.$row->product_id.'" class="btnPrint_single"><i class="icon-print"></i> Print Option 2</a></li>
				                  <li class="divider"></li>
				                  <li><a href="'.site_url('/').'trade/print_pdf/'.$row->product_id.'/" target="_blank"><i class="icon-share"></i> Export PDF 1</a></li>
				                  <li><a href="'.site_url('/').'trade/print_pdf/'.$row->product_id.'/2" target="_blank"><i class="icon-share"></i> Export PDF 2</a></li>
				                  <li><a onclick="'.$fb.'" class="">Share facebook</a></li>
				                </ul>
				            </div>
							<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the product menu" rel="tooltip" data-toggle="dropdown"><i class="icon-cog"></i></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a href="'.site_url('/').'sell/update_product/'.$row->product_id.'/" target="_blank" id="upd_'.$row->product_id.'"><i class="icon-pencil"></i> Update Item</a></li>
				                  <li><a onclick="delete_product('.$row->product_id.');" id="del_'.$row->product_id.'" class=""><i class="icon-trash"></i> Remove Item</a></li>
								  <li><a href="'.site_url('/').'product/'.$row->product_id.'/" target="_blank" class=""><i class="icon-search"></i> View Item</a></td></li>
				                </ul>
				            </div>

						</td>
					  </tr>';
			}
			$exit_str = "javascript:$('#modal-product-delete').modal('hide')";
			$table_str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div id="modal-product-delete" class="modal hide fade">

					<div class="modal-header">
					  <a data-dismiss="modal" aria-hidden="true" class="close">&times;</a>
					  <h3>Delete the Product</h3>
					</div>
					 <div class="modal-body">
					   <p>Are you sure you want to completely remove the current product and all of its resources?</p>

					</div>

					<div class="modal-footer">
					  <a href="#" class="btn btn-primary">Delete</a>
					  <a data-dismiss="modal" aria-hidden="true" class="btn btn-secondary">No</a>
					</div>

				</div>
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					$(document).ready(function(){


							$(".btnPrint").printPage({

								url: "'.site_url("/").'trade/print_products/0/0/"+$(".btnPrint").attr("data-section"),
								attr: "href",
								message: "Your document is being created"
							});


							$(".btnPrint_single").printPage({

								//url: "<?php echo site_url("/");?>trade/print_product/" + $(this).data("id"),
								attr: "href",
								message: "Your document is being created"
							});




							$(".btnExport").bind("click", function(){

								$("#export_frame").attr("src", "'.site_url("/").'trade/print_pdfs/0/0/"+$(".btnExport").attr("data-section"));

							});

							$(".btnCsv").bind("click", function(){

							$("#export_frame").attr("src", "'.site_url("/").'csv/export_products/0/0/"+$(".btnCsv").attr("data-section"));

							});

							$("[rel=tooltip]").tooltip();
							$(".datatable").dataTable( {
							  "sDom": "'.$table_str.'",
							  "sPaginationType": "bootstrap",
							  "oLanguage": {
								  "sLengthMenu": "_MENU_ records per page"
							  },
							  "aaSorting":[],
							  "bSortClasses": false

							} );

					});


					function update_product(id){

							var cont = $("#admin_content");
							$.get("'.site_url('/'). 'trade/update_product/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);

							});

					}
					function get_questions(id){

							var cont = $("#product_q_div");

							$.get("'.site_url('/'). 'trade/product_questions/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);

									  $("#modal-product-question").bind("show", function() {



									}).modal({ backdrop: true });
							});

					}
					function update_product_status(id, str){

						var cont = $("#admin_content");
						cont.addClass("loading_img").css("background-color","white");
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'trade/update_product_status/"+id+"/"+str ,
								success: function (data) {
									cont.removeClass("loading_img");
									cont.html(data);
									load_ajax("load_products");
								}
							});

					}

					function extend_product(id, type){

						var cont = $("#admin_content");

						cont.addClass("loading_img").css("background-color","white");
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'trade/extend_product_status/"+id+"/"+type ,
								success: function (data) {
									//cont.removeClass("loading_img");
									//cont.html(data);
									load_ajax("load_products");
									cont.removeClass("loading_img");
								}
							});

					}

					function activate_product(id, str){

						var cont = $("#admin_content");

						cont.addClass("loading_img").css("background-color","white");
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'trade/activate_product_status/"+id+"/"+str ,
								success: function (data) {
									//cont.removeClass("loading_img");
									//cont.html(data);
									load_ajax("load_products");
									cont.removeClass("loading_img");
								}
							});

					}
					function delete_product(id){

						$("#modal-product-delete").appendTo("body").unbind("show").bind("show", function()  {
							var removeBtn = $(this).find(".btn-primary"),
								href = removeBtn.attr("href");

								removeBtn.click(function(e) {

									e.preventDefault();

											$.ajax({
												type: "get",
												url: "'.site_url('/').'trade/delete_product/"+id ,
												success: function (data) {
													 $("#row_"+id).fadeOut();
													 $("#modal-product-delete").modal("hide");
													 $("#msg").html(data).fadeIn().delay(3000).fadeOut();
													 //window.setInterval(window.location.reload(), 3500);
												}
											});
								});
						}).modal({ backdrop: true });
					}
				</script>';

		}else{

			if($section == 'sold'){
				echo '<div class="alert">
						 <h4>No Items have been Sold</h4> No items have been sold. Once you sell an item it will be saved here.

						</div>';

			}elseif($section == 'bought'){
				echo '<div class="alert">
						 <h4>No Bought items</h4>You havent bought any items. Once you purchase an item it will be saved here.

						</div>';
			}else{

				$str = "'sell'";
				echo '<div class="alert">

						 <h4>No '.$bstr.' Products added</h4> No items have been added. Please add a new product below.<br /><br />
						 <a href="'.site_url('/').'sell/index/'.$bus_id.'/"  class="btn btn-inverse"><i class="icon-plus icon-white"></i> Add a New Product</a>
						</div>';
			}


		}
		
	}
	//+++++++++++++++++++++++++++
	//SCRATCH AND WIN LOGS
	//++++++++++++++++++++++++++
	public function get_scratch_logs($id)
	{
		  $this->db->where('PROMOTION_ID', $id);
		  $this->db->order_by('CREATED_AT', 'DESC');
		  $query = $this->db->get('scratch_plays');
		  if($query->result()){
			  $str = "load_ajax('scratch')"; 

			echo'<h4>Play Logs for Promotion '.$id.' </h4>
			<a class="btn pull-right" style="margin:5px;" onclick="'.$str.'">Back </a>&nbsp;
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="tbl_scratch_logs table table-striped"  width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:10%">ID</th>
						<th style="width:10%">Winner</th>
           				<th style="width:25%">Name </th>
						<th style="width:15%">Prize ID</th>
						<th style="width:5%">Promotion </th>
						<th style="width:10%">Coupon </th>
						<th style="width:25%">Date</th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$client = $this->get_client_row($row->CLIENT_ID);
				
				$win = '<div class="label label-danger">NO WIN</div>';
				
				if(substr($row->PRIZE_IMAGE_URL,0,3) == 'raw'){
					
					$win = '<div class="label label-success">WINNER</div>';
					
				}
				
				$prize = $this->get_prize($row->PRIZE_FK);
				echo '<tr>
						<td style="width:10%">'.$row->ID.'</td>
						<td style="width:10%">'.$win.'</td>
						<td style="width:25%"><a style="cursor:pointer" 
						href="'.site_url('/').'my_admin/member/'.$client['ID'].'"><div style="top:0;left:0;right:0;bottom:0;border:none">
						'.$client['CLIENT_NAME'].' ' . $client['CLIENT_SURNAME'].'
						</div></a></td>
            			<td style="width:15%">'.$prize['NAME'].'</td>
						<td style="width:5%">'.$row->PROMOTION_ID.'</td>
						<td style="width:10%">'.$row->COUPON.'</td>
						<td style="width:25%;text-align:right">'.date('Y-m-d h:i:s',strtotime($row->CREATED_AT)).'</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				';
			
		 }
		  
		  
				
				
		
	}
	
	
	//+++++++++++++++++++++++++++
	//SCRATCH AND WIN WINNERS
	//++++++++++++++++++++++++++
	public function get_scratch_winners($id)
	{
		  $this->db->where('PROMOTION_ID', $id);
		  $this->db->order_by('CREATED_AT', 'DESC');
		  $query = $this->db->get('scratch_winners');
		  if($query->result()){
			$str = "load_ajax('scratch')"; 
			echo'<h4>Scratch Winners for Promotion '.$id.' </h4>
			<a class="btn pull-right" style="margin:5px;" onclick="'.$str.'">Back </a>&nbsp;
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="tbl_scratch_winners table table-striped"  width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:10%">ID</th>
						<th style="width:10%">Winner</th>
           				<th style="width:25%">Name </th>
						<th style="width:15%">Prize ID</th>
						<th style="width:5%">Promotion </th>
						<th style="width:10%">Coupon </th>
						<th style="width:25%">Date</th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$client = $this->get_client_row($row->CLIENT_ID);
				
				$win = '<div class="label label-success">WIN</div>';
				
				
				$prize = $this->get_prize($row->PRIZE_ID);
				echo '<tr>
						<td style="width:10%">'.$row->ID.'</td>
						<td style="width:10%">'.$win.'</td>
						<td style="width:25%"><a style="cursor:pointer" 
						href="'.site_url('/').'my_admin/member/'.$client['ID'].'"><div style="top:0;left:0;right:0;bottom:0;border:none">
						'.$client['CLIENT_NAME'].' ' . $client['CLIENT_SURNAME'].'
						</div></a></td>
            			<td style="width:15%">'.$prize['NAME'].'</td>
						<td style="width:5%">'.$row->PROMOTION_ID.'</td>
						<td style="width:10%">'.$row->COUPON.'</td>
						<td style="width:25%;text-align:right">'.date('Y-m-d h:i:s',strtotime($row->CREATED_AT)).'</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				';
			
		 }
		  
		  
				
				
		
	}
	//+++++++++++++++++++++++++++
	//SCRATCH AND WIN PRIZES
	//++++++++++++++++++++++++++
	public function get_scratch_prizes($id)
	{
		  
		  $this->db->where('PROMOTION_ID', $id);
		  $query = $this->db->get('scratch_prizes');
		  if($query->result()){
			  
			$str = "load_ajax('scratch')";  
			echo'<h4>Prizes for Promotion '.$id.'</h4>
			<a class="btn pull-right" style="margin:5px;" onclick="'.$str.'">Back </a>&nbsp;
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="tbl_scratch_prizes table table-striped" id="tbl_prizes" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%">ID</th>
						<th style="width:5%">Image</th>
						<th style="width:5%">Active </th>
						<th style="width:15%">Name </th>
           				<th style="width:20%">Description </th>
						<th style="width:5%">Quantity</th>
						<th style="width:10%">Promotion </th>
						<th style="width:5%">Date</th>
						<th style="width:10%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$active_str = "'1'";
				$active = '<a onclick="set_prize_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-important">NO</span></a>';
				$btn = '<a onclick="set_prize_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-play"></i></a>';
				if($row->IS_ACTIVE == '1'){
					$active_str = "'0'";
					$active = '<a onclick="set_prize_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-success">YES</span></a>';
					$btn = '<a onclick="set_prize_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-pause"></i></a>';
				}
				
				if($id == 2){
					$img = S3_URL.'scratch_card/expo2013/prizes/raw/'.str_replace('_win','',$row->IMAGE_URL);
					
				}elseif($id == 3){
					//RESERVED
					$img = S3_URL.'scratch_card/expo2013/prizes/raw/'.str_replace('_win','',$row->IMAGE_URL);
				
				}elseif($id == 6){
					//VOLLEYBALL 4 ALL
					$img = S3_URL.'scratch_card/volleyball/prizes/raw/'.str_replace('_win','',$row->IMAGE_URL);	
				}else{
					
					$img = S3_URL.'scratch_card/images/prizes/raw/'.str_replace('_win','',$row->IMAGE_URL);	
				}
				
				
				$promo = $this->get_promotion($row->PROMOTION_ID);
				echo '<tr>
						<td style="width:5%">'.$row->ID.'</td>
						<td style="width:5%"><img src="'.$img.'" class="img-polaroid" style="width:30px;height:30px;" /></td>
						<td style="width:5%">'.$active.'</td>
						<td style="width:15%">'.$row->NAME.'</td>
						<td style="width:20%">'.$row->DESCRIPTION.'</td>
            			<td style="width:5%">'.$row->QUANTITY.'</td>
						<td style="width:10%">'.$promo['NAME'].'</td>
						<td style="width:5%;">'.date('Y-m-d',strtotime($row->CREATED_AT)).'</td>
						<td style="width:10%;text-align:right">
							'.$btn.'
							<a href="javascript:void(0)" onclick="update_prize('.$row->ID.')"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
			    </script>';
			
		 }
		  
		  
				
				
		
	}
	//+++++++++++++++++++++++++++
	//SCRATCH AND WIN PROMOTIONS
	//++++++++++++++++++++++++++
	public function get_scratch_promotions()
	{
		   //$this->db->limit('1');
		  $query = $this->db->get('scratch_promotion');
		  if($query->result()){
			echo'<h4>Promotions</h4>
			<a class="btn pull-right" style="margin:5px;" onclick="load_ajax(scratch)">Back </a>&nbsp;
			
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="tbl_scratch table table-striped" id="tbl_promotions" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%">ID</th>
						<th style="width:15%">Business</th>
						<th style="width:5%">Active </th>
						<th style="width:15%">Name </th>
						<th style="width:10%">Start</th>
						<th style="width:10%">End</th>
						<th style="width:10%">Throttle</th>
						<th style="width:25%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$active_str = "'1'";
				$active = '<a onclick="set_promo_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-important">NO</span></a>';
				$btn = '<a onclick="set_promo_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-play"></i></a>';
				if($row->IS_ACTIVE == '1'){
					$active_str = "'0'";
					$active = '<a onclick="set_promo_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-success">YES</span></a>';
					$btn = '<a onclick="set_promo_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-pause"></i></a>';
				}
				
				$this->db->where('ID', $row->BUSINESS_ID);
				$bus = $this->db->get('u_business');
				$bus_row = $bus->row_array();
				echo '<tr>
						<td style="width:5%">'.$row->ID.'</td>
						<td style="width:15%">'.$bus_row['BUSINESS_NAME'].'</td>
						<td style="width:5%">'.$active.'</td>
						<td style="width:15%">'.$row->NAME.'</td>
						<td style="width:10%;">'.date('Y-m-d',strtotime($row->START_DATE)).'</td>
						<td style="width:10%;">'.date('Y-m-d',strtotime($row->END_DATE)).'</td>
						<td style="width:10%;">'.$row->THROTTLE.'</td>
						<td style="width:25%;text-align:right">
						<a href="javascript:void(0)" class="btn btn-mini" onclick="load_logs('.$row->ID.')">logs</a>
						<a href="javascript:void(0)" class="btn btn-mini" onclick="load_winners('.$row->ID.')">winners</a>
						<a href="javascript:void(0)" class="btn btn-mini" onclick="load_prizes('.$row->ID.')">prizes</a>
							'.$btn.'
							<a href="javascript:void(0)" onclick="update_promo('.$row->ID.')"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
			    </script>';
			
		 }
		  
		  
				
				
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE PROMOTIONS
	//++++++++++++++++++++++++++
	public function update_promotion($promo_id)
	{
		  $this->db->where('ID', $promo_id);
		  $query = $this->db->get('scratch_promotion');
		  if($query->result()){
			  $row = $query->row();
			echo'<form id="promo_update" name="promo_update" method="post" action="'.site_url('/').'win/update_promo" class="form-horizontal">
                   <fieldset>
                   <input  type="hidden" name="promo_id" id="promo_id" value="'.$promo_id.'" >
                                      
					<div class="row-fluid">
                        <div class="control-group">
                          <label class="control-label" for="dpstart">Start</label>
                          <div class="controls">
                                    <div class="input-append date span6" id="dpstart'.$promo_id.'" data-date="102/2012" data-date-format="yyyy-mm-dd" data-date-minviewmode="months">
                                      <input class="span6" size="16" type="text" id="starttxt" name="dpstart" value="'.date('Y-m-d',strtotime($row->START_DATE)).'">
                                      <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div>
                                   
                                    <span class="help-block" style="font-size:11px">When does the prompotion start</span>   
                          </div>
                        </div>
      				 <div class="control-group">
                          <label class="control-label" for="dpend">End</label>
                          <div class="controls">
                                    
                                    <div class="input-append date span6" id="dpend'.$promo_id.'" data-date="102/2012" data-date-format="yyyy-mm-dd"  data-date-minviewmode="months">
                                      <input class="span6" size="16" type="text" name="dpend" id="endtxt" value="'.date('Y-m-d',strtotime($row->END_DATE)).'">
                                      <span class="add-on"><i class="icon-calendar"></i></span>
                                    </div> 
                                    <span class="help-block" style="font-size:11px">Till when is the promotion available</span>   
                          </div>
                        </div>
						
						<div class="control-group">
                          <label class="control-label" for="throttle">Throttle</label>
                          <div class="controls">

                                   <select id="throttle" name="throttle">
								       <option value="2880">48 Hours per day (2880)</option>
								       <option value="2160">36 Hours per day (2160)</option>
									   <option value="1440">24 Hours per day (1440)</option>
									   <option value="960">16 Hours per day (960)</option>
									   <option value="720">12 Hours per day (720)</option>
									   <option value="600">10 Hours per day (600)</option>
									   <option value="480">8 Hours per day (480)</option>
									   <option value="360">6 Hours per day (360)</option>
									   <option value="240">4 Hours per day (240)</option>
								   </select>
                                    <span class="help-block" style="font-size:11px">
									Currently set at <strong>'.$row->THROTTLE.'</strong>
									<br />
										12 hours per day == 720 minutes 
										 16 hours per day == 960 minutes
										 8 hours per day == 960 minutes </span>   
                          </div>
                        </div>
						
                        <button type="button" onclick="update_promo_do()" class="btn btn-inverse pull-right" id="update_promo_btn">Update</button>';
						
						$this->scratch_model->canUserWinPrize_test($promo_id);
						
                    echo '</div>   
                     </fieldset> 
                   </form>
				   <script type="text/javascript">
				   		
						$("#dpstart'.$promo_id.'").datepicker()
			
						$("#dpend'.$promo_id.'").datepicker() 
				   
				   </script>
				   ';

			
		 }
			
		
	}
	
	
	
	
	
	//+++++++++++++++++++++++++++
	//SCRATCH AND WIN STATISTICS
	//++++++++++++++++++++++++++
	public function get_scratch_stats()
	{
		$this->load->model('scratch_model');
			
		
	}				
	function get_prize($id){
		
		$this->db->where('ID', $id);
		$query = $this->db->get('scratch_prizes');
		if($query->result()){
			return $query->row_array();	
			
		}else{
			 $data['NAME'] = 'Expired Prize';
			 $data['DESCRIPTION'] = 'Expired Prize Description';
			return $data;	
			
		}
		
	}
	function get_promotion($id){
		
		$this->db->where('ID', $id);
		$query = $this->db->get('scratch_promotion');
		if($query->result()){
			return $query->row_array();	
			
		}else{
			 $data['NAME'] = 'Expired Promotion';
			 $data['DESCRIPTION'] = 'Expired promotion';
			return $data;	
			
		}
		
	}
    //+++++++++++++++++++++++++++
	//GET ALL USERS
	//++++++++++++++++++++++++++
	public function get_users()	
	{
			error_reporting(E_ALL);
		  //$query = $this->db->get('u_client');
		  $query = $this->db->query("SELECT u_client.*, a_map_location.MAP_LOCATION, a_map_suburb.SUBURB_NAME FROM u_client
										LEFT JOIN a_map_location ON u_client.CLIENT_CITY = a_map_location.ID
										LEFT JOIN a_map_suburb ON u_client.CLIENT_SUBURB = a_map_suburb.ID
										ORDER BY REGISTER_DATE DESC LIMIT 10000 ");
		  if($query->result()){
			echo'<h3>Users <small>My Namibia</small></h3>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
						<th style="width:5%">FB ID</th>
						<th style="width:5%">Verfied </th>
						<th style="width:18%">Name </th>
						<th style="width:6%">Active</th>
						<th style="width:10%">Location </th>
						<th style="width:15%">Email </th>
						<th style="width:10%">Cell</th>
						<th style="width:15%">Register</th>
						<th style="width:10%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$active_str = "'Y'";
				$active = '<a onclick="set_user_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-important">NO</span></a>';
				$btn = '<a onclick="set_user_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-ok"></i></a>';
				if($row->IS_ACTIVE == 'Y'){
					$active_str = "'N'";
					$active = '<a onclick="set_user_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-success">YES</span></a>';
					$btn = '<a onclick="set_user_status('.$row->ID.','.$active_str.')" href="javascript:void(0)"><i class="icon-remove"></i></a>';
				}
	
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:5%">'.$row->FB_ID.'</td>
						<td style="width:5%">'.$row->VERIFIED.'</td>
						<td style="width:18%"><a style="cursor:pointer"
							href="'.site_url('/').'my_admin/member/'.$row->ID.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
							.$row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME.'</div></a></td>
						<td style="width:6%">'.$active.'</td>
						<td style="width:10%">'.$row->MAP_LOCATION. ' '. $row->SUBURB_NAME.'</td>
            			<td style="width:15%">'.$row->CLIENT_EMAIL.'</td>
						<td style="width:10%">'.$row->CLIENT_CELLPHONE.'</td>
						<td style="width:15%">'.date('Y-m-d h:i:s',strtotime($row->REGISTER_DATE)).'</td>
						<td style="width:10%;text-align:right"><a style="cursor:pointer" 
						href="'.site_url('/').'my_admin/member/'.$row->ID.'">
						<i class="icon-pencil"></i></a><a style="cursor:pointer" onclick="delete_member('.$row->ID.')"><i style="margin-left:5px" class="icon-trash"></i></a>
						'.$btn.'
						</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
					function set_user_status(id, status){
	 
							  $.ajax({
								  type: "get",
								  cache: false,
								  url: "'.site_url('/').'my_admin/set_user_status/"+id+"/"+status ,
								  success: function (data) {
									 
									 $("#msg_admin").html(data);
									 window.setTimeout( load_ajax("users") , "2000");
										  
								  }
							  });	 					
					}
					
	
					
					</script>';
			
		 }
		  
		  
				
				
		
	}

	
	//+++++++++++++++++++++++++++
	//GET ALL USERS
	//++++++++++++++++++++++++++
	public function get_all_pages()
	{

		  $query = $this->db->get('pages');
		  if($query->result()){
			echo'<a href="'.site_url('/').'my_admin/add_page" class="btn pull-right"><i class="icon-plus"></i> Add New page</a>
			<h3>Pages <small>My Namibia</small></h3>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:20%">Title </th>
						<th style="width:34%">Body </th>
						<th style="width:10%">Meta Title </th>
						<th style="width:20%">Meta Description </th>
						<th style="width:10%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
	
				echo '<tr>
						<td style="width:6%">'.$row->page_id.'</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="'.site_url('/').'my_admin/page/'.$row->page_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->heading.'</div></a></td>
            			<td style="width:34%">'.substr($row->body,0,80).'</td>
						<td style="width:10%">'.$row->metaT.'</td>
						<td style="width:20%">'.$row->metaD.'</td>
						<td style="width:10%;text-align:right"><a style="cursor:pointer" 
						href="'.site_url('/').'my_admin/page/'.$row->page_id.'"><i class="icon-pencil"></i></a><a style="cursor:pointer" onclick="delete_page('.$row->page_id.')"><i style="margin-left:5px" class="icon-remove"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				';
			
		 }
		  
		  
				
				
		
	}
	
	
	 //+++++++++++++++++++++++++++
	//GFET ALL SYSTEM USERS
	//++++++++++++++++++++++++++
	public function get_sys_users()	
	{

		  $query = $this->db->get('a_sysuser');
		  if($query->result()){
			
			echo '<script type="text/javascript" language="javascript" src="'. base_url('/').'js/jquery.dataTables.min.js"></script>';
			echo'<h3>System Users <small>My Namibia</small></h3>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:30%">Name </th>
						<th style="width:24%">Email </th>
						<th style="width:40%">Position</th>
						<th style="width:5%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
	
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:30%"><a style="cursor:pointer" onClick="update_sys_user('.$row->ID.')"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->FULL_NAME .'</div></a></td>
            			<td style="width:24%">'.$row->EMAIL_ADDRESS.'</td>
						<td style="width:40%">'.$row->POSITION_NAME.'</td>
						<td style="width:5%"><a class="btn btn-mini" onclick="delete_user('.$row->ID.')"><i class="icon icon-trash"></i></a></td>
					  </tr>';
			}
			
			$str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				 	 $("#example").dataTable( {
								  "sDom": "'.$str.'",
								  "sPaginationType": "bootstrap",
								  "oLanguage": {
									  "sLengthMenu": "_MENU_ records per page"
								  },
								  "aaSorting":[],
								  "bSortClasses": false
				
					} );
				</script>';
			
		 }

	}
	
	
	//+++++++++++++++++++++++++++
	//GET SYSTEM LOG
	//++++++++++++++++++++++++++
	public function get_system_log()	
	{

		  $query = $this->db->get('a_sysuser_log');
		  if($query->result()){
			echo'<h3>System Logs <small>My Namibia</small></h3>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:30%">Name </th>
						<th style="width:40%">Action</th>
						<th style="width:24%">Date</th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				if(substr($row->TYPE,0,12) == 'add-business'){
					
					$id = substr($row->TYPE,13,strlen($row->TYPE));
					$type = '<a style="cursor:pointer" href="'.site_url('/').'b/'.$id.'" target="_blank">
							 <div style="top:0;left:0;right:0;bottom:0;border:none">Add Business - id '.$id.'</div><a/>';	
					
				}else{
					
					$type = $row->TYPE;
				}
	
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:30%">'.$row->USER_NAME .'</td>
            			<td style="width:40%">'.$type.'</td>
						<td style="width:24%">'.date('Y-m-d h:i:s',strtotime($row->DATETIME)).'</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
			
		 }

	}
	
	
	 //+++++++++++++++++++++++++++
	//POPULATE REGIONS FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_region($cunt_id)
	{
		
		$this->db->where('COUNTRY_ID' , $cunt_id);
		$this->db->from('a_map_region');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		
			echo '<div class="control-group">
                  <label class="control-label" for="region">Region</label>
                  <div class="controls">
              			<select onchange="populateSuburb(this.value);" id="region" name="region" class="span4">';
			
				foreach($query->result() as $row){
					
					$region = $row->REGION_NAME;
					$reg_id = $row->ID;
					
					echo '<option value="'.$reg_id.'">'.$region.'</option>';
						  
					
					
				}
		   echo '</select> 
		   		 
                </div>
              </div>';
		}else{
		
		return;
		}
	}
	//+++++++++++++++++++++++++++
	//POPULATE CITIES FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_city($cunt_id, $city_current)
	{
		//SEE IF NAMIBIA
		if($cunt_id == '151'){
		
			$this->db->order_by('MAP_LOCATION', 'ASC');
			$query = $this->db->get('a_map_location');
			
			if($query->num_rows() > 0){
			
				echo '<div class="control-group">
					  <label class="control-label" for="city">City</label>
					  <div class="controls">
						
							<select onchange="populateSuburb(this.value);" id="city" name="city" class="span4">
							<option value="0">Please Select your City</option>';
							
					foreach($query->result() as $row){
						
						$city = $row->MAP_LOCATION;
						$city_id = $row->ID;
						
						if($city_current == $city_id){ $str = 'selected="selected"';}else{ $str ='';}
						
						echo '<option value="'.$city_id.'" '. $str .' >'.$city.'</option>';
							  
						
						
					}
			   echo '</select> 
					  
					</div>
				  </div>';
			}else{
			
			return;
			}
		}
	}
	
	 //+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS
	//++++++++++++++++++++++++++
	public function populate_suburb($reg_id,$suburb_current)
	{
		
		$this->db->where('CITY_ID' , $reg_id);
		$this->db->from('a_map_suburb');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		
			echo '<div class="control-group">
                  <label class="control-label" for="suburb">Suburb</label>
                  <div class="controls">
               		 <div class="input-prepend">
  						<span class="add-on"><i class="icon-flag"></i></span>
              			<select id="suburb" name="suburb" class="span4">
						<option value="0">Please Select your Suburb</option>';
			
				foreach($query->result() as $row){
					
					$suburb = $row->SUBURB_NAME;
					$sub_id = $row->ID;
					
					if($suburb_current == $sub_id){ $str = 'selected="selected"';}else{ $str ='';}
					
					echo '<option value="'.$sub_id.'" ' . $str . ' >'.$suburb.'</option>';
						  
					
					
				}
		   echo '</select> 
		   		  </div>
                </div>
              </div>';
		}else{
		
		return;
		}
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET PRODUCT CATEGORIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	//Get Main Categories
	function get_product_main_categories(){
      	
		$this->load->view('admin/inc/product_cats');
		  	  
    }
	//Get Main Categories
	function load_product_categories($cat1, $cat2, $cat3, $cat4){
      	
		//SE WHAT CATEGORY TYPE 1 = main; 2 = sub; 3 = sub sub
		if($cat4 > 0){

			$query = $this->db->query("SELECT cat_id as ID, main_cat_id, sub_cat_id, sub_sub_cat_id, category_name as CATEGORY_NAME FROM product_categories  WHERE sub_sub_sub_cat_id = '".$cat4."'", FALSE);
			$type = 'Sub Sub Sub Sub';
			
		}elseif($cat3 > 0){

			$query = $this->db->query("SELECT cat_id as ID, main_cat_id, sub_cat_id, sub_sub_cat_id, category_name as CATEGORY_NAME FROM product_categories  WHERE sub_sub_cat_id = '".$cat3."' AND sub_sub_sub_cat_id = '0'", FALSE);
			$type = 'Sub Sub Sub';
		
		}elseif($cat2 > 0){
			
			$query = $this->db->query("SELECT cat_id as ID, sub_cat_id, main_cat_id, category_name as CATEGORY_NAME FROM product_categories  WHERE sub_cat_id = '".$cat2."'  AND sub_sub_cat_id = '0'", FALSE);
			$type = 'Sub Sub';
		}elseif($cat1 > 0){
			
			$query = $this->db->query("SELECT cat_id as ID, main_cat_id, category_name as CATEGORY_NAME FROM product_categories WHERE main_cat_id = '".$cat1."' AND sub_cat_id = '0'", FALSE);
			$type = 'Sub';
		}else{

			$query = $this->db->query("SELECT cat_id as ID, category_name as CATEGORY_NAME FROM product_categories WHERE main_cat_id = '0'", FALSE);
			$type = '';
		}

		if($cat1 == 0){
			
		}else{
			
			echo '<a href="javascript:back_('.$cat1 .', '. $cat2.', '. $cat3.', '. $cat4.');" class="btn" ><i class="icon-chevron-left"></i> Back</a>';	
			
		}
		echo '<a href="javascript:add_product_category('.$cat1 .', '. $cat2.', '. $cat3.', '. $cat4.');" class="btn pull-right clearfix"><i class="icon-plus"></i> Add '.$type.'  Product Category</a>
			  <div class="clearfix" style="height:20px;"></div>';
		if($query->result()){
			echo'<h3>'.$type.' Product Categories <small>My Namibia</small></h3>
			
			
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:94%">Main category Name </th>
						<th style="width:4%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				//SE WHAT CATEGORY TYPE 1 = main; 2 = sub; 3 = sub sub
				if($cat4 > 0){
					
					$str = $row->ID. "," .$cat1. "," .$cat2. "," .$cat3. "," .$cat4;
					$java = "void(0)";
					
				}elseif($cat3 > 0){
					
					$str = $row->ID. "," .$cat1. "," .$cat2. "," .$cat3. "," .$cat4;
					//$java = "load_ajax_product_cat(".$row->main_cat_id." , ".$row->sub_cat_id." , ".$row->ID.", 0)";
					$java = "void(0)";
				
				}elseif($cat2 > 0){
					
					$str = $row->ID. "," .$cat1. "," .$cat2. "," .$cat3. "," .$cat4;
					$java = "load_ajax_product_cat(".$row->main_cat_id." , ".$row->sub_cat_id.",  ".$row->ID." , 0)";
				
				}elseif($cat1 > 0){
					
					$str = $row->ID. "," .$cat1. "," .$cat2. "," .$cat3. "," .$cat4;
					$java = "load_ajax_product_cat(".$row->main_cat_id.", ".$row->ID.", 0, 0)";
				
				}else{
					
					$str = $row->ID. "," .$cat1. "," .$cat2. "," .$cat3. "," .$cat4;
					$java = "load_ajax_product_cat(".$row->ID." , 0 , 0, 0)";
				}
				
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:84%"><a href="javascript:'.$java.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->CATEGORY_NAME .'</div></a></td>
					  	<td style="width:10%"><a href="javascript:delete_product_category('.$str.')"><i class="icon-remove"></i></a>
						<a  href="javascript:update_product_cat('.$str.')"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
			
		 }else{
			echo'<h3>'.$type.' Product Categories <small>My Namibia</small></h3>'; 
			echo '<div class="alert">No '.$type.'  Product Categories Added</div>'; 
		 }
		  	  
    }
	

	
	//Get Main Categories
	function get_main_categories_edit(){
      	
		$test = $this->db->get('a_tourism_category');
		return $test;	  
    }


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET BUSINESS CATEGORIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Get Main Categories
	function get_main_categories_db(){

		$test = $this->db->get('a_tourism_category');
		return $test;
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function get_main_categories(){
      	
		$query = $this->db->get('a_tourism_category');
		if($query->result()){
			echo'<h3>Main Categories <small>My Namibia</small></h3>
			<a href="javascript:add_cat_main();" class="btn pull-right clearfix"><i class="icon-plus"></i> Add New Category</a>
			<div class="clearfix" style="height:40px;"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:94%">Main category Name </th>
						<th style="width:4%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$str = "'".$row->ID."','main'";
				$java = "load_ajax_cat_sub('".$row->ID."')";
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:84%"><a href="javascript:'.$java.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->CATEGORY_NAME .'</div></a></td>
					  	<td style="width:10%"><a href="javascript:delete_cat('.$str.')"><i class="icon-remove"></i></a>
						<a  href="javascript:update_cat_main('.$row->ID.')"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
			
		 }
		  	  
    }
	//GEt sub Categories
	function get_all_categories_sub()	{

		//$this->db->where('CATEGORY_TYPE_ID', $cat_id);
		$query = $this->db->query("SELECT a_tourism_category_sub.*, a_tourism_category.CATEGORY_NAME as MAIN_CAT FROM a_tourism_category_sub
									JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID");
		if($query->result()){

			$str = "'categories'";
			echo'<h3>All Sub Categories<small>Sub Categories</small></h3>


			<div class="clearfix" style="height:40px;"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:40%">Sub category Name </th>
           				<th style="width:40%">Main category Name </th>
						<th style="width:10%"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				$str = "'".$row->ID."','sub'";
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:40%">'.$row->CATEGORY_NAME .'</td>
						<td style="width:40%">'.$row->MAIN_CAT .'</td>
					  	<td style="width:10%"><a href="javascript:delete_cat('.$str.')"><i class="icon-remove"></i></a>
						<a  href="javascript:update_cat_sub('.$row->ID.')"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				$("[rel=tooltip]").tooltip();
				</script>';

			//NO SUB CATS
		}else{

			$str = "'categories'";
			$str2 = "'".$cat_id."'";
			echo '<div class="alert alert-block">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <h4>No Sub categories Added!</h4>
					  No sub categories have been listed under the current Category. Add a new sub category by clicking on the button below or return to all categories<br /><br />
					  <a href="javascript:load_ajax('. $str.');" class="btn"><i class="icon-arrow-left"></i> Go back</a>
					  <a href="javascript:add_cat_sub('.$str2.');" class="btn clearfix"><i class="icon-plus"></i> Add New Sub Category</a>
					  <br />
				 </div>';


		}

	}
	 //GEt sub Categories
	function get_categories_sub($cat_id)	{
      	
		$this->db->where('CATEGORY_TYPE_ID', $cat_id);
		$query = $this->db->get('a_tourism_category_sub');
		if($query->result()){
			$str2 = "'".$cat_id."'";
			$str = "'categories'";
			echo'<h3>'.$this->get_main_category_name($cat_id).' <small>Sub Categories</small></h3>
			<a href="javascript:add_cat_sub('.$str2.');" class="btn pull-right clearfix" style="margin-left:5px;"><i class="icon-plus"></i> Add New Sub Category</a>
			<a href="javascript:load_ajax('. $str.');" class="btn pull-right"><i class="icon-arrow-left"></i> Go back</a>
			<div class="clearfix" style="height:40px;"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:6%">ID</th>
           				<th style="width:90%">Main category Name </th>
						<th style="width:4%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$str = "'".$row->ID."','sub'";
				echo '<tr>
						<td style="width:6%">'.$row->ID.'</td>
						<td style="width:84%">'.$row->CATEGORY_NAME .'</td>
					  	<td style="width:10%"><a href="javascript:delete_cat('.$str.')"><i class="icon-remove"></i></a>
						<a  href="javascript:update_cat_sub('.$row->ID.')"><i class="icon-pencil"></i></a>
						</td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				$("[rel=tooltip]").tooltip();
				</script>';
		
		 //NO SUB CATS	
		 }else{
			
			$str = "'categories'";
			$str2 = "'".$cat_id."'";
			echo '<div class="alert alert-block">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <h4>No Sub categories Added!</h4>
					  No sub categories have been listed under the current Category. Add a new sub category by clicking on the button below or return to all categories<br /><br />
					  <a href="javascript:load_ajax('. $str.');" class="btn"><i class="icon-arrow-left"></i> Go back</a>
					  <a href="javascript:add_cat_sub('.$str2.');" class="btn clearfix"><i class="icon-plus"></i> Add New Sub Category</a>
					  <br />  
				 </div>'; 
			 
			 
		 }
		  	  
    }	 	
    //GEt sub Categories
	function get_sub_categories($cat_id){
      	
		$test = $this->db->where('CATEGORY_TYPE_ID', $cat_id);
		$test = $this->db->get('a_tourism_category_sub');
		return $test;
				  
    }			
    //GEt Current Categories
	function get_current_categories($bus_id){
      	
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('i_tourism_category');
		return $test;
				  
    }
 //GEt MAIN CATEGORY NAME
	function get_main_category_name($cat_id){
      	
		$test = $this->db->where('ID', $cat_id);
		$test = $this->db->get('a_tourism_category');
		$row = $test->row_array();
		
		return $row['CATEGORY_NAME'];
				  
    }

     //GEt CATEGORY NAME
	function get_category_name($cat_id_cur){
      	
		$test = $this->db->where('ID', $cat_id_cur);
		$test = $this->db->get('a_tourism_category_sub');
		$row = $test->row_array();
		
		return $row['CATEGORY_NAME'];
				  
    }
	
	//GEt MAIN CAT ID
	function get_main_category_id($cat_id){
      	
		$test = $this->db->where('ID', $cat_id);
		$test = $this->db->get('a_tourism_category_sub');
		$row = $test->row_array();
		
		return $row['CATEGORY_TYPE_ID'];
				  
    }
	
	//GEt CATEGORY NAME
	function add_new_category($cat_id ,$bus_id){
      	
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//NEED TO VALIDATE HOW MANY CATEGORIES THE BUSINESS HAS
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		$data = array( 
			      'BUSINESS_ID'=> $bus_id,
				  'CATEGORY_ID'=> $cat_id,
				  'IS_ACTIVE'=> 'N'
				 
        		);
		//insert into database
		$this->db->insert('i_tourism_category',$data);
		
		
    }
	//DELETE CATEGORY
	function delete_category($cat_id, $bus_id){
      	
		//test if it was ajax or POST
		$ajax = $this->uri->segment(5);
				
		if($ajax != 'ajax'){
			
			//delete from database
			$test = $this->db->where('CATEGORY_ID', $cat_id);
			$test = $this->db->where('BUSINESS_ID', $bus_id);
			$this->db->delete('i_tourism_category');
			return 'redirect';	
			
		}else{
	
			//delete from database
			$test = $this->db->where('CATEGORY_ID', $cat_id);
			$test = $this->db->where('BUSINESS_ID', $bus_id);
			$this->db->delete('i_tourism_category');
			return '';
		}
		
    }
	
	 //GEt BUSINESS NAME
	function get_business_name($bus_id){
      	
		$test = $this->db->where('ID', $bus_id);
		$test = $this->db->get('u_business');
		if($test->result()){
			
			$row = $test->row_array();
			return $row['BUSINESS_NAME'];	
			
		}else{
			
			return 'No Name Found??';
			
		}
		

				  
    }
		 //GEt PRODUCT NAME
	function get_product($id){
      	
		$test = $this->db->where('product_id', $id);
		$test = $this->db->get('products');
		$row = $test->row_array();
		
		return $row;
				  
    }
 //GEt BUSINESS NAME
	function get_member_details($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');
		return $test->row_array();	
				  
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS REVIEWS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	public function get_all_reviews()	
	{
		  $this->db->where('REVIEW_TYPE', 'business_review');
		  $this->db->order_by('TIME_VOTED', 'DESC');
		  
		  $query = $this->db->get('u_business_vote');
		  if($query->result()){
			echo'<h3>Business Reviews <small>My Namibia</small></h3>
			
			<div class="alert">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Legend?</strong><br /> 
			  All business reviews are listed below and sorted by most recent first. Please only approve legitimate reviews that do not contain any swear words or foul language<br />
			  <i class="icon-ok"></i> - Approve Review <i class="icon-pause"></i> - Banned review <br /><i class="icon-ban-circle"></i> - Ban and keep Review hidden <i class="icon-play"></i> - Active review
			</div>
			<div class="clearfix" style="width:100%"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%"></th>
						<th style="width:10%">Client ID</th>
           				<th style="width:15%">Business </th>
						<th style="width:20%">Review </th>
						<th style="width:10%">Rating</th>
						<th style="width:10%">Date</th>
						<th style="width:10%"></th>
						<th style="width:15%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$str = "'".$row->ID."','yes' , 'reviews'";
				$str2 = "'".$row->ID."','no' ,'reviews'";
				
				if($row->IS_ACTIVE == 'Y'){
					$tool = 'title="Stop this review" rel="tooltip"';
					$button = '<span class="badge badge-success"><i  class="icon-play icon-white"></i></span>';
					$button2 = '<a href="javascript:approve_review('.$str2.')"  class="btn btn-mini btn-danger" title="Stope the Review Deactivate" rel="tooltip"><i class="icon-ban-circle icon-white"></i></a>';
					$button3 = '';
				}else{
					$tool = 'title="Approve this review" rel="tooltip"';
					$button = '<span class="badge badge-important"><i  class="icon-pause icon-white"></i></span>';
					$button2 = '<a href="javascript:approve_review('.$str.')" class="btn btn-mini btn-success"  title="Activate" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					$button3 = '<a href="javascript:delete_review('.$row->ID.')" class="btn btn-mini btn-danger"  title="Delete " rel="tooltip"><i class="icon-remove icon-white"></i></a>';
				}
				
				echo '<tr>
						<td style="width:5%">'.$button.'<div style="display:none">'.$row->IS_ACTIVE.'</div></td>
						<td style="width:10%"><a href="'.site_url('/').'my_admin/member/'.$row->CLIENT_ID.'/" target="_blank">'.$this->get_client_name($row->CLIENT_ID).'</a></td>
						<td style="width:15%">'.$this->get_business_name($row->BUSINESS_ID).'</td>
            			<td style="width:20%"><a  href="javascript:approve_review('.$str.')">'.$row->REVIEW.'</a></td>
						<td style="width:10%">'.$row->RATING.'</td>
						<td style="width:12%">'.date('Y-m-d',strtotime($row->TIME_VOTED)).'</td>
						<td style="width:10%">'.$row->TYPE.'</td>
						<th style="width:15%; min-width:60px">'.$button2.' ' . $button3.'</th>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				$("[rel=tooltip]").tooltip();
				</script>';
			
		 }
		  
		  
				
				
		
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS REVIEWS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	public function get_all_product_reviews()	
	{
		  $this->db->where('REVIEW_TYPE', 'product_review');
		  $this->db->order_by('TIME_VOTED', 'DESC');
		  
		  $query = $this->db->get('u_business_vote');
		  if($query->result()){
			echo'<h3>Product Reviews <small>My Namibia</small></h3>
			
			<div class="alert">
			  <button type="button" class="close" data-dismiss="alert">&times;</button>
			  <strong>Legend?</strong><br /> 
			  All product reviews are listed below and sorted by most recent first. Please only approve legitimate reviews that do not contain any swear words or foul language<br />
			  <i class="icon-ok"></i> - Approve Review <i class="icon-pause"></i> - Banned review <br /><i class="icon-ban-circle"></i> - Ban and keep Review hidden <i class="icon-play"></i> - Active review
			</div>
			<div class="clearfix" style="width:100%"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%"></th>
						<th style="width:10%">Client ID</th>
           				<th style="width:15%">Business </th>
						<th style="width:20%">Review </th>
						<th style="width:10%">Rating</th>
						<th style="width:12%">Date</th>
						<th style="width:10%"></th>
						<th style="width:15%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$str = "'".$row->ID."','yes' , 'product_reviews'";
				$str2 = "'".$row->ID."','no' ,'product_reviews'";
				
				
				if($row->IS_ACTIVE == 'Y'){
					$tool = 'title="Stop this review" rel="tooltip"';
					$button = '<span class="badge badge-success"><i  class="icon-play icon-white"></i></span>';
					$button2 = '<a href="javascript:approve_review('.$str2.')"  class="btn btn-mini btn-danger" title="Stope the Review Deactivate" rel="tooltip"><i class="icon-ban-circle icon-white"></i></a>';
					$button3 = '';
				}else{
					$tool = 'title="Approve this review" rel="tooltip"';
					$button = '<span class="badge badge-important"><i  class="icon-pause icon-white"></i></span>';
					$button2 = '<a href="javascript:approve_review('.$str.')" class="btn btn-mini btn-success"  title="Activate" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					$button3 = '<a href="javascript:delete_review('.$row->ID.')" class="btn btn-mini btn-danger"  title="Delete " rel="tooltip"><i class="icon-remove icon-white"></i></a>';
				}
				
				$product = $this->get_product($row->PRODUCT_ID);
				
				echo '<tr>
						<td style="width:5%">'.$button.'<div style="display:none">'.$row->IS_ACTIVE.'</div></td>
						<td style="width:10%">'.$this->get_client_name($row->CLIENT_ID).'</td>
						<td style="width:15%"><a href="'.site_url('/').'product/'.$row->PRODUCT_ID.'/" target="_blank">'.$product['title'].'</a></td>
            			<td style="width:20%"><a  href="javascript:approve_review('.$str.')">'.$row->REVIEW.'</a></td>
						<td style="width:10%">'.$row->RATING.'</td>
						<td style="width:15%">'.date('Y-m-d',strtotime($row->TIME_VOTED)).'</td>
						<td style="width:10%">'.$row->TYPE.'</td>
						<th style="width:15%" >'.$button2.' ' . $button3.'</th>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				$("[rel=tooltip]").tooltip();
				</script>';
			
		 }
		  
		  
				
	}
		
	

	
	function get_client_name($id){
		
		$this->db->where('ID', $id);
		$query = $this->db->get('u_client');
		if($query->result()){
			
			$row = $query->row_array();
			return $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];
				
		}else{
			
			return 'No Record';	
		}
		
	}
	
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//SHOW EMAIL RECIPIENTS
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function show_email_recipients($type){
      	
		if($type == 'business'){
			$str = 'Businesses';
			$query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business");
		}elseif($type == 'ntb'){
			$str = 'NTB Members';
			$query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE IS_NTB_MEMBER = 'Y'");
			
		}elseif($type == 'han'){
			$str = 'HAN Members';
			$query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE IS_HAN_MEMBER = 'Y'");

		}elseif($type == 'han_ntb'){
			$str = 'HAN &amp; NTB Members';
			$query = $this->db->query("SELECT ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE (IS_HAN_MEMBER = 'Y' OR IS_NTB_MEMBER = 'Y')");

		}else{
			$str = 'Users';
			$query = $this->db->query("SELECT ID as ID, CONCAT(CLIENT_NAME, ' ', CLIENT_SURNAME) as NAME FROM u_client WHERE EMAIL_NOTIFICATION = 'Y'");
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
//GET BUSINESS GALLERY
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Business Gallery
	function get_gallery($bus_id){
      	
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('u_gallery_component');
		return $test;	  
    }
	//SHOW ALL IMAGES IMAGE MANAGER		
function show_all_gallery_images($bus_id)
	{
			
			$query = $this->db->where('BUSINESS_ID',$bus_id);
			$query = $this->db->get('u_gallery_component');
			//IF have children
			if($query->num_rows() > 0){
				echo '<h4>All Gallery Images</h4>';
				echo '<ul class="thumbnails">';
				$x =0;
				foreach($query->result() as $row){
					$id = $row->ID;
					$img_file = $row->GALLERY_PHOTO_NAME;
					//$title = $row->CLIENT_PHOTO_TITLE;
					if($img_file != ''){
						
						if(strpos($img_file,'.') == 0){
				
							$format = '.jpg';
							$img_str = S3_URL.'assets/business/gallery/'.$img_file . $format;
							
						}else{
							
							$img_str =  S3_URL.'assets/business/gallery/'.$img_file;
							
						}
						
					}else{
						
						$img_str = base_url('/').'img/bus_blank.jpg';	
						
					}		
							//TIMBTHUMB
							//echo '<li class="thumbnail"><img src="'.base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/business/gallery/'.$img_file.'&q=100&w=180&h=100" />
//							<a style="float:right;margin:0 3px;" onclick="delete_gallery_img('.$id .');" href="#"><i class="icon-remove"></i></a>
//							</li>';
							
							//NO TIMBTHUMB
							echo '<li class="thumbnail"><img src="'.$img_str.'" style="width:180px;"/>
							<a style="float:left;margin:0 5px;" onclick="delete_gallery_img('.$id .');" href="#"><i class="icon-remove"></i></a>
						   </li>';
							$x++;
						
					 
					}
					
				//show gallery
				echo '</ul>';
				
			}else{
			
				echo '<div class="alert alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h4>No Gallery Images Added</h4>
					Please add some gallery images to enhance your business listing by clicking on the select images button below
				</div>';
			}			
			
		
	}		 	  	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++
//ADD NEW CLIENT ID INTO INTERSECTION TABLE
//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function add_business_member($bus_id ,$id){

		$this->db->where('BUSINESS_ID', $bus_id);
		$this->db->where('CLIENT_ID', $id);
		$exist = $this->db->get('i_client_business');
		
		if($exist->result()){
	
		}else{
			
			$data = array( 
					  'BUSINESS_ID'=> $bus_id,
					  'CLIENT_ID'=> $id
					);
			//insert into database
			$this->db->insert('i_client_business',$data);
		}
		
    }
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//BUSINESS ANALYTICS
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
   function get_business_analytics($bus_id){
	   
	   
	   
	   
   }
	
	function get_business_impressions($bus_id, $period, $value) {

			$query = "select COUNT(*) as TOTAL FROM u_business_impressions   
					WHERE ".$period."(TIMESTAMP) = '".$value."' AND BUSINESS_ID = '".$bus_id."'";
			
			$query = $this->db->query($query);
			
			if($query->result()){		   
    	
				$row = $query->row_array();
				return $row['TOTAL'];
				
			}else{
				
				return 0;
				
			}	
		
	}
	
	function get_business_clicks($bus_id, $period, $value) {
		
  
		$query = $this->db->query("select COUNT(*) as TOTAL FROM u_business_clicks   
					WHERE ".$period."(TIMESTAMP) = '".$value."' AND BUSINESS_ID = '".$bus_id."'");
				   
		if($query->result()){		   
    	
			$row = $query->row_array();
			return $row['TOTAL'];
				
		}else{
			
			return 0;
			
		}
		
	}
	function get_business_enquiries($bus_id, $period, $value) {
		
		
		$query = $this->db->query("select COUNT(*) as TOTAL FROM u_business_enquiries   
					WHERE ".$period."(TIMESTAMP) = '".$value."' AND BUSINESS_ID = '".$bus_id."'");
				   
		if($query->result()){		   
    	
			$row = $query->row_array();
			return $row['TOTAL'];
				
		}else{
			
			return 0;
			
		}
		
	}
	
	
	function get_business_impressions_30($bus_id) {

  		//GET LAST 30 DAYS
		$month = array();
		$total = array();
		
		//echo 'data: [';
		
		//IMPRESSIONS
		for($i = 0; $i < 15; $i++){ 
			
			
			
			$vmonth = date("n", strtotime('-'. $i .' days'));
			$vday = date("d", strtotime('-'. $i .' days'));
			
			//echo "['". date("d", strtotime('-'. $i .' days')) . " - " . date("m", strtotime('-'. $i .' days'))."',";
			
			$query = "select COUNT(*) as TOTAL FROM u_business_impressions   
				  WHERE MONTH(TIMESTAMP) = '".$vmonth."' AND DAY(TIMESTAMP) = '".$vday."' AND BUSINESS_ID = '".$bus_id."'";
			
			$query = $this->db->query($query);
			
			if($query->result()){		   
	  
  				$row = $query->row_array();
				$total[$i] = $row['TOTAL'];
			  	//echo "'".$total[$i] ."']".$comma;
			  
			}else{
				  
				 $total[$i] = 0;
				 //echo "'".$total[$i] ."']".$comma; 
			}		
			
			
		
		}
	  			
		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($total));

		echo 'data: [';	
		$x = 0;
		$y = 14;
		while($x <= 14){
			
			if($x == 14){
				
				$comma = '';
					
			}else{
				
				$comma = ',';
			}
			
			echo "['". date("d", strtotime('-'. ($y - $x) .' days')) . " - " . date("m", strtotime('-'. ($y - $x) .' days'))."',";
			//echo $reverted[$x] . ' ' . $x.'<br />';	
			echo "'".$reverted[$x] ."']".$comma; 
			$x ++;
		}
		
	  echo "]";	
	}

	function get_business_clicks_30($bus_id) {

  		//GET LAST 30 DAYS
		$month = array();
		$total = array();
		
		//echo 'data: [';
		
		//IMPRESSIONS
		for($i = 0; $i < 15; $i++){ 
			
			
			
			$vmonth = date("n", strtotime('-'. $i .' days'));
			$vday = date("d", strtotime('-'. $i .' days'));
			
			//echo "['". date("d", strtotime('-'. $i .' days')) . " - " . date("m", strtotime('-'. $i .' days'))."',";
			
			$query = "select COUNT(*) as TOTAL FROM u_business_clicks   
				  WHERE MONTH(TIMESTAMP) = '".$vmonth."' AND DAY(TIMESTAMP) = '".$vday."' AND BUSINESS_ID = '".$bus_id."' AND TYPE = 'view'";
			
			$query = $this->db->query($query);
			
			if($query->result()){		   
	  
  				$row = $query->row_array();
				$total[$i] = $row['TOTAL'];
			  	//echo "'".$total[$i] ."']".$comma;
			  
			}else{
				  
				 $total[$i] = 0;
				 //echo "'".$total[$i] ."']".$comma; 
			}		
			
			
		
		}
	  			
		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($total));

		echo 'data: [';	
		$x = 0;
		$y = 14;
		while($x <= 14){
			
			if($x == 14){
				
				$comma = '';
					
			}else{
				
				$comma = ',';
			}
			
			echo "['". date("d", strtotime('-'. ($y - $x) .' days')) . " - " . date("m", strtotime('-'. ($y - $x) .' days'))."',";
			//echo $reverted[$x] . ' ' . $x.'<br />';	
			echo "'".$reverted[$x] ."']".$comma; 
			$x ++;
		}
		
	  echo "]";	
	}	
	
	function get_business_enquiries_30($bus_id) {

  		//GET LAST 30 DAYS
		$month = array();
		$total = array();
		
		//echo 'data: [';
		
		//IMPRESSIONS
		for($i = 0; $i < 15; $i++){ 
			
			
			
			$vmonth = date("n", strtotime('-'. $i .' days'));
			$vday = date("d", strtotime('-'. $i .' days'));
			
			//echo "['". date("d", strtotime('-'. $i .' days')) . " - " . date("m", strtotime('-'. $i .' days'))."',";
			
			$query = "select COUNT(*) as TOTAL FROM u_business_enquiries   
				  WHERE MONTH(TIMESTAMP) = '".$vmonth."' AND DAY(TIMESTAMP) = '".$vday."' AND BUSINESS_ID = '".$bus_id."'";
			
			$query = $this->db->query($query);
			
			if($query->result()){		   
	  
  				$row = $query->row_array();
				$total[$i] = $row['TOTAL'];
			  	//echo "'".$total[$i] ."']".$comma;
			  
			}else{
				  
				 $total[$i] = 0;
				 //echo "'".$total[$i] ."']".$comma; 
			}		
			
			
		
		}
	  			
		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($total));

		echo 'data: [';	
		$x = 0;
		$y = 14;
		while($x <= 14){
			
			if($x == 14){
				
				$comma = '';
					
			}else{
				
				$comma = ',';
			}
			
			echo "['". date("d", strtotime('-'. ($y - $x) .' days')) . " - " . date("m", strtotime('-'. ($y - $x) .' days'))."',";
			//echo $reverted[$x] . ' ' . $x.'<br />';	
			echo "'".$reverted[$x] ."']".$comma; 
			$x ++;
		}
		
	  echo "]";	
	}

//X-AXIS LABELS
function get_business_xaxis_30($bus_id) {

  		//GET LAST 30 DAYS
		$vstr = array();
		$total = array();
		
		
		
		//IMPRESSIONS
		for($i = 0; $i < 15; $i++){ 
			
	
			$vstr[$i] = date("l", strtotime('-'. $i .' days')) .' the '. date("j", strtotime('-'. $i .' days')) .' ' .date("F", strtotime('-'. $i .' days'));
			
		
		}
	  			
		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($vstr));

		echo 'var xAxisLabels = [';
		$x = 0;
		$y = 14;
		while($x <= 14){
			
			if($x == 14){
				
				$comma = '';
					
			}else{
				
				$comma = ',';
			}
			
			echo "'".$reverted[$x]."'".$comma; 
			$x ++;
		}
		
	  echo "]";	
	}

    //+++++++++++++++++++++++++++
    //GET EMAIL CONTENT
    //++++++++++++++++++++++++++
    public function get_email_content($type = 'products')
    {

        if($type == 'products'){

            $q = $this->db->query("SELECT products.product_id as id, products.title as title FROM products JOIN product_extras ON products.product_id = product_extras.product_id ORDER BY listing_date DESC LIMIT 60" ,FALSE);

        }elseif($type == 'deals'){

            $q = $this->db->query("SELECT ID as id, SPECIALS_HEADER as title FROM u_special_component ORDER BY CREATED_AT DESC LIMIT 60" ,FALSE);

        }


        if($q->result()){
            echo '<div style="height:300px; overflow-y: scroll">
					<ul class="nav nav-pills nav-stacked">';
            foreach($q->result() as $row){

                $title = ucwords(filter_var(utf8_decode($row->title), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
                echo '<li id="'.$type.'_it-'.$row->id.'"><a href="javascript:add_content('."'".$type."',".$row->id.');">'.$this->shorten_string($title, 6).' <i class="icon-plus pull-right"></i></a></li>';
                //echo $row->TITLE;


            }
            echo '</ul>
				</div>
				<form class="form-search">
				  <input type="text" id="prod_add_id" class="input-large search-query" placeholder="Product ID: 887">
				  <button type="button" class="btn" onclick="add_content('."'products',document.getElementById('prod_add_id').value".')">Go!</button>
				</form>
				<br /><br />
				';
        }


    }

    //+++++++++++++++++++++++++++
    //EMAIL MARKETING BUILD CONTENT
    //++++++++++++++++++++++++++
    function build_email_content($type , $id)
    {


		$this->load->model('image_model'); 

		$this->load->library('thumborp');
		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 580;
		$height = 300;  	


        if($type == 'products') {

            $this->load->model('trade_model');
            //$q = $db->where('ID', $id);

            $q = $this->db->query("SELECT u_business.BUSINESS_NAME,
                                      products.*,products_buy_now.amount,products_buy_now.buy_now_id, trade_rating.rating, trade_rating.review, trade_rating.created_at,
                                      product_extras.*,product_images.img_file, product_questions.question_id,product_categories.category_name,
                                      group_concat(trade_rating.rating,'-_-',trade_rating.type,'-_-',REPLACE(trade_rating.review, ',', ' '),'-_-',trade_rating.created_at) as rating_a,
                                      MAX(product_auction_bids.amount) as current_bid
                                      FROM products
                                      JOIN u_client ON u_client.ID = products.client_id
                                      LEFT JOIN product_extras ON products.product_id = product_extras.product_id
                                      LEFT JOIN product_categories ON product_categories.cat_id = products.sub_sub_cat_id
                                      LEFT JOIN products_buy_now ON products.product_id = products_buy_now.product_id
                                      LEFT JOIN u_business ON products.bus_id = u_business.ID
                                      LEFT JOIN trade_rating ON trade_rating.buy_now_id = products_buy_now.buy_now_id
                                      LEFT JOIN product_images ON products.product_id = product_images.product_id
                                      LEFT JOIN product_questions ON product_questions.product_id = products.product_id
                                      LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
							        WHERE products.product_id = '" . $id . "' GROUP BY products.product_id LIMIT 1");
            $out = 'NONE';
            if ($q->result()) {


                $row = $q->row();

                //IMAGES
                if ($row->img_file != '') {

					$img_str = 'assets/products/images/' . $row->img_file;

					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');               	


                } else {

                    $img_url = base_url('/') . 'img/product_blank.jpg';
                }

                $url = site_url('/') . 'product/' . $row->product_id . '/' . $this->my_na_model->clean_url_str($row->title, '', '_') . '/';

                $date = date('Y-m-d', strtotime($row->start_date)) . ' til ' . date('Y-m-d', strtotime($row->end_date));
                $title = ucwords(filter_var(utf8_decode($row->title), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
                $descr = ucwords(filter_var(utf8_decode($row->description), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
                $extras = $this->trade_model->show_extras_short($row->extras);

                $ex_str = '<td colspan="2" style="width:45%;padding: 20px 10px;vertical-align:top">
									' . $this->shorten_string(strip_slashes(html_entity_decode($descr)), 100) . '
							</td>';
                if (strlen($extras) > 2) {

                    $ex_str = '<td style="width:45%;text-align:left ;padding: 10px">
									' . $extras . '
								</td>
								<td  style="width:45%;padding: 20px 10px;vertical-align:top">
									' . $this->shorten_string(strip_slashes(html_entity_decode($descr)), 100) . '
								</td>';

                }

                //IF BUY NOW
                if ($row->listing_type == 'S') {
                    if ($row->status == 'sold') {
                        $price['str'] = ' Sold';
                    } else {
                        if ($row->sub_cat_id == 3410) {
                            $price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span> pm';
                        } else {
                            $price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span>';
                        }
                        if ($row->por == 'Y') {

                            $price['str'] = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

                        }

                    }

                } else {

                    $price = $this->trade_model->get_current_bid($row->current_bid) ;
                    $price['str'] = $price['str'] .' <span style="font-size:10px">Current Bid</span>';

                }

                $ribbon = $this->trade_model->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');
                $out = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2" style="padding: 10px;text-align:center;" align="center">

									<h1 align="center" style="text-align:center; font-size:50px;color:#FF9F01;" class="upper yellow big_icon">' . $title . '</h1>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding: 10px">
									<h2>' . $ribbon . '</h2>
								</td>
							</tr>
							<tr >
								<td colspan="2" style="padding: 10px"  class="white_box">
									<img src="' . $img_url . '" class="inline_img" style="max-width:580px" alt="Download Image To view" title="Download Image To view">
									<br />
								</td>
							</tr>
							<tr>
							    ' . $ex_str . '
							</tr>
							<tr>
								<td style="width:45%;text-align:center ;padding: 10px">
									<h1> ' . $price['str'] . ' </h1>
								</td>
								<td style="width:45%;text-align:right;padding: 10px">
									<a href="' . $url . '/" class="btn" style="text-decoration:none;color:#fff">View Item</a>
								</td>
							</tr>
							<tr>
							    <td colspan="2"><p>&nbsp;</p></td>
							</tr>
						</table>
						<br />

						<p>&nbsp;</p>
						';


            }
            echo $out;

        }elseif($type == 'deals'){

            $q = $this->db->query("SELECT * FROM u_special_component
                                  WHERE ID = '".$id."'
                                  ORDER BY CREATED_AT DESC " ,FALSE);

            if ($q->result()) {


                $row = $q->row();

                //IMAGES
                if ($row->SPECIALS_IMAGE_NAME != '') {

					$img_str = 'assets/deals/images/' . $row->SPECIALS_IMAGE_NAME;

					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');    


                } else {

                    $img_url = base_url('/') . 'img/product_blank.jpg';
                }


                $date = 'Only valid from '.date('Y-m-d', strtotime($row->SPECIALS_STARTING_DATE)) . ' until ' . date('Y-m-d', strtotime($row->SPECIALS_EXPIRE_DATE));
                $title = ucwords(filter_var(utf8_decode($row->SPECIALS_HEADER), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
                $descr = ucwords(filter_var(utf8_decode($row->SPECIALS_CONTENT), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
                $url = site_url('/') . 'deal/' . $row->ID . '/' . $this->my_na_model->clean_url_str($title, '', '_') . '/';



                $ex_str = '<td colspan="2" style="width:45%;padding: 20px 10px;vertical-align:top">
									' . $this->shorten_string(strip_slashes(html_entity_decode($descr)), 100) . '
							</td>';



                 $out = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2" style="padding: 10px;text-align:center;" align="center">

									<h1 align="center" style="text-align:center; font-size:50px;color:#FF9F01;" class="upper yellow big_icon">' . $title . '</h1>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding: 10px">
									<h2>' . $date . '</h2>
								</td>
							</tr>
							<tr >
								<td colspan="2" style="padding: 10px"  class="white_box">
									<img src="' . $img_url . '" class="inline_img" style="max-width:580px" alt="Download Image To view" title="Download Image To view">
									<br />
								</td>
							</tr>
							<tr>
							    ' . $ex_str . '
							</tr>
							<tr>
								<td style="width:45%;text-align:center ;padding: 10px">
									<h1><span style="font-size:15px">N$</span> ' . number_format($row->SPECIALS_PRICE, 2) . ' </h1>
								</td>
								<td style="width:45%;text-align:right;padding: 10px">
									<a href="' . $url . '/" class="btn" style="text-decoration:none;color:#fff">View Deal</a>
								</td>
							</tr>
							<tr>
							    <td colspan="2"><p>&nbsp;</p></td>
							</tr>
						</table>
						<br />

						<p>&nbsp;</p>
						';


            }
            echo $out;


        }else{

            $this->load->model('my_namibia_model');

            $db = $this->my_namibia_model->connect_my_db();

            $db->where('DATE_TO >=', date("Y-m-d H:i:s",strtotime("-1 day")));
            $q = $db->get('u_specials_component');



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
            //$query = $this->db->where('bus_id', $bus_id);
            $query = $this->db->get('emails');
        }else{

            $str = ucwords($status). ' emails ';
           // $bus_id = $this->session->userdata('bus_id');
            //$query = $this->db->where('bus_id', $bus_id);
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

						<th style="width:15%; text-align:right"><a href="'.site_url('/').'my_admin/build_mail/'.$row->email_id.'/"  title="Continue editing" rel="tooltip" class="btn btn-mini"><i class="icon-pencil"></i></a>
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
//+++++++++++++++++++++++++++
    //GET EMAIL LOGS
    //++++++++++++++++++++++++++
    public function get_email_logs($query, $date_from , $date_to , $tags , $senders , $limit)
    {

        $this->load->model('email_model');
        $result = $this->get_email_logs_mandrill($query, $date_from , $date_to , $tags , $senders , $limit = 3000);
        var_dump($result);
        //echo $query;
        if(count($result) > 0){


            echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" id="email_logs_tbl" class="table table-striped datatable"  width="100%">
						<thead>
							<tr style="font-size:14px">

								<th style="width:20%;font-weight:bold">To</th>
								<th style="width:20%;font-weight:bold">Subject </th>
								<th style="width:10%;font-weight:bold">Date </th>
								<th style="width:10%;font-weight:bold">Status </th>
								<th style="width:5%;font-weight:bold">Opens </th>
								<th style="width:5%;font-weight:bold">Clicks </th>
								<th style="width:20%;font-weight:bold">Data</th>
								<th style="width:10%;font-weight:bold"></th>
							</tr>
						</thead>
						<tbody>';

            foreach($result as $row => $key){


                if(is_array($key)){
                    $str = '';
                    foreach($key as $subkey){

                        if(is_array($subkey)){
                            $x = 0;
                            foreach($subkey as $subsubkey){


                                foreach($subsubkey as $subsubsubkey => $s_key){

                                    if($subsubsubkey == 'destination_ip' || $subsubsubkey == 'location' || $subsubsubkey == 'ua'){

                                        if($x < 3){
                                            $str .= '<span class="badge">'.$s_key . ' </span> ';
                                        }
                                        $x ++;
                                    }

                                }
                            }


                        }

                    }


                }
                $open = '<span class="badge badge-success">'.$key['opens'].'</span>';
                if($key['opens'] == 0){

                    $open = '<span class="badge badge-important">'.$key['opens'].'</span>';

                }
                $clicks = '<span class="badge badge-success">'.$key['clicks'].'</span>';
                if($key['clicks'] == 0){

                    $clicks = '<span class="badge badge-important">'.$key['clicks'].'</span>';

                }
                echo '<tr>

								<td style="width:20%">'.$key['email'].'</td>
								<td style="width:20%">'.$key['subject'].'</td>
								<td style="width:10%">'.date("D d M Y h:i:s A",$key['ts']).'</td>
								<td style="width:10%">'.$key['state'].'</td>
								<td style="width:5%">'.$open.'</td>
								<td style="width:5%">'.$clicks.'</td>
								<td style="width:20%;text-align:right">'.$str.'</td>
								<td style="width:10%;text-align:right">
								<a title="View Content" rel="tooltip" class="btn btn-mini disabled" style="cursor:pointer"
								onclick="view_enquiry()"><i class="icon-zoom-in"></i></a>
								<a title="Re-send Email" rel="tooltip" class="btn btn-mini btn-danger disabled" style="cursor:pointer" onclick="delete_enquiry()">
								<i class="icon-play icon-white"></i></a></td>
							  </tr>';

            }


            echo '</tbody>
						</table>
						<hr />
						<div class="clearfix" style="height:30px;"></div>
						<script type="text/javascript">

						</script>';


        }else{

            echo '<div class="alert">No Emails have been sent in the last 30 days</div>';


        }


    }



    //+++++++++++++++++++++++++++
    //GET EMAIL LOGS
    //++++++++++++++++++++++++++
    public function get_email_logs_mandrill($query, $date_from , $date_to , $tags , $senders , $limit)
    {


        /*		echo "
                <div id='response'></div>
                <script type='text/javascript' src='https://mandrillapp.com/api/docs/js/mandrill.js'></script>
                <script type='text/javascript'>

                        function onSuccessLog(arr) {
                            $('#response').append('<h2>' + JSON.stringify(arr.length) + ' messages match your search</h2>');
                            if (arr.length >= 1) {
                              for (var i=0; i < arr.length; i++) {
                                $('#response').append('<h3>Message ' + (i+1) + ': ' + JSON.stringify(arr[i].email) + '</h3><ol>');
                                $('#response').append('<li>Date: ' + Date(JSON.stringify(arr[i].ts) * 1000).toString() + '</li>');
                                $('#response').append('<li>Subject: ' + JSON.stringify(arr[i].subject) + '</li>');
                                $('#response').append('<li>State: ' + JSON.stringify(arr[i].state) + '</li></ol>');
                                }
                            }
                        }

                        function onErrorLog(obj) {
                            $('#response').text(JSON.stringify(obj));
                        }

                        // create a new instance of the Mandrill class with your API key
                        var m = new mandrill.Mandrill('d3tAlotpZNobGiCfRk3Miw');

                        params = {

                            ".'"limit":"15",
                            "senders":["no-reply@bcxgroup.com"]'."
                        };
                        // get the results for messages.search using the parameters from above

                        m.messages.search(params, function(res) {
                                onSuccessLog(res);
                            }, function(err) {
                                onErrorLog(err);
                            }
                        );

                </script>
                ";*/



        $this->load->config('mandrill');

        $this->load->library('mandrill');

        $mandrill_ready = NULL;

        try {

            $this->mandrill->init( $this->config->item('mandrill_api_key') );
            $mandrill_ready = TRUE;
            $result = 'yes';
        } catch(Mandrill_Exception $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            $mandrill_ready = FALSE;
            $result = 'no';
            throw $e;
        }

        if( $mandrill_ready ) {



            $result = $this->mandrill->messages_search($query, $date_from , $date_to , $tags, $senders , $limit) ;

        }

        //var_dump($result);
        return $result;



    }


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//Clean EXISTING DB FIELDS
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	function clean_db_business(){
		
		$sql = $this->db->query("SELECT *
			  					FROM `u_business`
								",TRUE);
		
		$x = 0;	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
		
			foreach($sql->result() as $row){
				
				$data['BUSINESS_DESCRIPTION'] = filter_var(utf8_decode($row->BUSINESS_DESCRIPTION), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
				$data['BUSINESS_NAME'] = filter_var(utf8_decode($row->BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
				$this->db->where('ID', $row->ID);
				$this->db->update('u_business',$data);
				$x ++;
			}
			
			echo 'BUSINESS TABLE CLEANED records: '.$x;
		}else{//
			
			
		}

		//return $res;
	}
	
	//+++++++++++++++++++++++++++++++++++
	//FIND DUPLICATES
	//+++++++++++++++++++++++++++++++++++	

	public function find_duplicates()
	{
		ini_set('memory_limit','265M');
		//$this->load->library('MP_Cache');
		//TEST CACHE
		//$output = $this->mp_cache->get('duplicate_businesses');
		//if ($output === false){
			
			//if($limit == 0){
				//$this->db->limit($limit);
				$this->db->where('ID !=', 1675);
				$this->db->where('ID !=', 1678);
				$ncci = $this->db->get('u_business');
			//}else{
				//$ncci = $this->db->get('u_business_2');
			//}
			
			$count = 1;
			$match_id = 0;
			

			$output = '<h3>Duplicate Businesses <small>My Namibia</small></h3>
			
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:3%">Duplicates</th>
						<th style="width:45%">Original</th>
						<th style="width:45%">Duplicate </th>
						<th style="width:7%"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($ncci->result() as $nccirow){
			
	
				$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME like "%'.$nccirow->BUSINESS_NAME.'" AND ID != '.$nccirow->ID .' AND ID != '.$match_id.' ORDER BY ID', FALSE);
				$x = 1;
				if($match->result()){
					
					foreach($match->result() as $match_row){

						$del_str = "'find_duplicates'";
						$active_str = "'Y'";
						$active = '<a onclick="set_business_status('.$match_row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-important">NO</span></a>';
						$btn = '<a href="javascript:void(0);" onclick="delete_business('.$match_row->ID.','.$del_str.')"><i style="margin-left:5px" class="icon-trash"></i></a>';
						$active_str2 = "'Y'";
						$active2 = '<a onclick="set_business_status('.$match_row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-important">NO</span></a>';
						$btn2 = '<a href="javascript:void(0);" onclick="delete_business('.$nccirow->ID.','.$del_str.')"><i style="margin-left:5px" class="icon-trash"></i></a>';
						if($match_row->ISACTIVE == 'Y'){
							$active_str = "'N'";
							$active = '<a onclick="set_business_status('.$match_row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-success">YES</span></a>';
							$btn = '<a href="javascript:void(0);" onclick="delete_business('.$match_row->ID.','.$del_str.')"><i style="margin-left:5px" class="icon-trash"></i></a>';
						}
						if($nccirow->ISACTIVE == 'Y'){
							$active_str2 = "'N'";
							$active2 = '<a onclick="set_business_status('.$match_row->ID.','.$active_str.')" href="javascript:void(0)"><span class="label label-success">YES</span></a>';
							$btn2 = '<a href="javascript:void(0);" onclick="delete_business('.$nccirow->ID.','.$del_str.')"><i style="margin-left:5px" class="icon-trash"></i></a>';
						}
						
						$output .= '<tr>
								<td style="width:3%">'.$x .'</td>
								<td style="width:45%"><a href="'.site_url('/').'my_admin/business_details/'.$nccirow->ID.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$nccirow->ID.' ' .$nccirow->BUSINESS_NAME .' '.$active2.' ' . $btn2.'</div></a>
								
								'.$nccirow->BUSINESS_EMAIL.'  '.date('Y-m-d', strtotime($nccirow->BUSINESS_DATE_CREATED)).'
								</td>
								<td style="width:45%"><a href="'.site_url('/').'my_admin/business_details/'.$match_row->ID.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$match_row->ID.' ' .$match_row->BUSINESS_NAME .' '.$active.' ' . $btn.'</div></a>
								
								'.$match_row->BUSINESS_EMAIL.' '.date('Y-m-d', strtotime($match_row->BUSINESS_DATE_CREATED)).'
								</td>
	
								<td style="width:7%;min-width:60px;">
									
									<a href="javascript:void(0);" onclick="delete_business('.$match_row->ID.','.$del_str.')"><i style="margin-left:5px" class="icon-trash"></i></a>
								</td>
							  </tr>';
						
						
						
						//echo $x .' : '.$nccirow->ID.' ' . $nccirow->BUSINESS_NAME.' == Duplicate : '.$match_row->ID.' ' .$match_row->BUSINESS_NAME.'  is Active = '.$match_row->ISACTIVE.'<br />++++++++++++++++++++++++++++++<br />'; 
						$x ++;
						$count ++;
						
					}
	
					
					
				}
				$match_id = $nccirow->ID;
				
			}
							
			$output .= '</tbody>
						</table>
						<hr />
						<div class="clearfix" style="height:30px;"></div>
						<script type="text/javascript">
						
						function set_business_status(id, status){
		 
								  $.ajax({
									  type: "get",
									  cache: false,
									  url: "'.site_url('/').'my_admin/set_business_status/"+id+"/"+status ,
									  success: function (data) {
										 
										 $("#msg_admin").html(data);
										 window.setTimeout( load_ajax("duplicate_businesses") , "2000");
											  
									  }
								  });	 					
						}
						
		
						
						</script>';
						
			//$data['cache'] = $output;			
			//$this->load->view('cache',$data);			
			//$this->output->cache(4);
			// Save into the cache
     		//$this->mp_cache->write($output, 'duplicate_businesses',  7200);
			
		//}
		echo $output;
	}	


	//+++++++++++++++++++++++++++++++++++
	//FIND AND CLEAN DUPLICATES
	//+++++++++++++++++++++++++++++++++++	

	public function clean_duplicates()
	{
		
		//$this->load->library('MP_Cache');
		//TEST CACHE
		//$output = $this->mp_cache->get('duplicate_businesses');
		//if ($output === false){
			
			//if($limit == 0){
				//$this->db->limit($limit);
				$ncci = $this->db->get('u_business');
			//}else{
				//$ncci = $this->db->get('u_business_2');
			//}
			
			$count = 1;
			$match_id = 0;
			
			
			$output = '';
			
			foreach($ncci->result() as $nccirow){
			
	
				$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->BUSINESS_NAME.'" AND ID != '.$nccirow->ID .' AND ID != '.$match_id.' ORDER BY ID', FALSE);
				$x = 1;
				if($match->result()){
					
					foreach($match->result() as $match_row){

						
						echo $x .' : '.$nccirow->ID.' ' . $nccirow->BUSINESS_NAME.' == Duplicate : '.$match_row->ID.' ' .$match_row->BUSINESS_NAME.'  is Active = '.$match_row->ISACTIVE.'<br />++++++++++++++++++++++++++++++<br />'; 
						$x ++;
						$count ++;
						
					}
	
					
					
				}
				$match_id = $nccirow->ID;
				
			}

						
			//$data['cache'] = $output;			
			//$this->load->view('cache',$data);			
			//$this->output->cache(4);
			// Save into the cache
     		//$this->mp_cache->write($output, 'duplicate_businesses',  7200);
			
		//}
		echo $output;
	}


	
	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/*Hash password*/
	
	function hash_password($username, $password){
		
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));
		
		// Prefix the password with the salt
		$hash = $salt . $password;
		
		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		
		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
		return $hash;
		
	}
	

	/*Validate password*/
	
	function validate_password($username, $password){
		
		$sql = $this->db->query("SELECT *
			  					FROM `a_sysuser`
								WHERE
				  			   `EMAIL_ADDRESS` = '".$username."' AND IS_ACTIVE = 'Y' LIMIT 1",TRUE);
		
		$res = array();	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
				
			$r = $sql->row_array();
			//Store value for return
			$res['FULL_NAME'] = $r['FULL_NAME'];
			$res['ID'] = $r['ID'];
			$res['POSITION_NAME'] = $r['POSITION_NAME'];
			$res['LAST_LOGIN'] = $r['LAST_LOGIN'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['PASSWORD_CRYPT'], 0, 64);
			
			$hash = $salt . $password;
			
			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
			  $hash = hash('sha256', $hash);
			}
			
			$hash = $salt . $hash;
			
			if ( $hash == $r['PASSWORD_CRYPT'] ) {
			  
			   $res['bool'] = TRUE;
			   //break;
			}else{
			  
			   $res['bool'] = FALSE;
				
			}
		}else{//no username match
			
			$res['bool'] = FALSE;
		}

		return $res;
	}
	
	
	//connect to tourism db
	function connect_tourism_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'hannamib_devuser';
		$config_db['password'] = 'UI5TrephoWC0';
		$config_db['database'] = 'hannamib_mynatour_devdb';
		
		//$config_db['username'] = 'root';
	    //$config_db['password'] = '';
		//$config_db['database'] = 'my_na';
		
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