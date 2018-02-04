<?php
class Advert_model extends CI_Model{
	
	
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function advert_model(){
  		//parent::CI_model();
		self::__construct();	
 	}

	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function get_adverts()
	{

		$query = $this->db->query("SELECT * FROM adverts" ,FALSE);
		if($query->result()){
			
			echo'
			
			<h4>Adverts<small> Your current adverts</small></h4>
			<a onclick="toggle_advert_add()" class="btn pull-right"><i class="icon-plus-sign"></i> Add New Advert</a>
			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="advert_tbl" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:30%">Title</th>

						<th style="width:22%">Start</th>
						<th style="width:23%">End</th>
						<th style="width:12%">Q</th>

						<th style="width:20%;min-width:100px"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){
				
				if($row->ADVERTS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = S3_URL.'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;
					
				}
				
				if($row->IS_ACTIVE == 'Y'){
					
					$active = '<a class="btn btn-mini btn-success" title="Advert is live" rel="tooltip"><i class="icon-ok icon-white"></i></a>';
					
				}else{
					
					$active = '<a class="btn btn-mini btn-warning" title="Not approved" rel="tooltip"><i class="icon-time icon-white"></i></a>';
					
				}
				
				if(date('Y-m-d',strtotime($row->ADVERTS_EXPIRE_DATE)) < date('Y-m-d')){
					
					$active = '<a class="btn btn-mini btn-warning" title="Advert is expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					
				}
						
				echo '<tr>
						<td style="width:5%;min-width:40px"><img src="'.$img.'" 
							alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:30%">'.$row->ADVERTS_HEADER .'</td>

						<td style="width:22%">'.date('Y-m-d',strtotime($row->ADVERTS_STARTING_DATE)) .'</td>
						<td style="width:23%">'.date('Y-m-d',strtotime($row->ADVERTS_EXPIRE_DATE)).'</td>
						<td style="width:12%">'.$row->URL.'</td>
						
					  	<td style="width:20%;min-width:100px;text-align:right">  
							'.$active.'
							
							<a onclick="update_advert('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-pencil icon-white"></i></a> 
							<a onclick="delete_advert('.$row->ID.');" class="btn btn-mini btn-inverse"><i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			$exit_str = "javascript:$('#modal-advert-delete').modal('hide')"; 
			echo '</tbody>
				</table>
				<hr />
				<div id="modal-advert-delete" class="modal hide fade">

					<div class="modal-header">
					  <a href="#" onclick="'.$exit_str.'" class="close">&times;</a>
					  <h3>Delete the Advert</h3>
					</div>
					 <div class="modal-body">
					   <p>Are you sure you want to completely remove the current advert and all of its resources?</p>
						
					</div>
				
					<div class="modal-footer">
					  <a href="#" class="btn btn-primary">Delete</a> 
					  <a href="#" onclick="'.$exit_str.'" class="btn btn-secondary">No</a>
					</div>
				 
				</div>
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					$("[rel=tooltip]").tooltip();
					$("#step_1").click(function () {
						 $("#tna_step_2_li").addClass("active");
						 $("#tna_step_1_li").removeClass("active");
					});
					
					function update_advert(id){
	
						var cont = $("#admin_content");
						cont.empty();
						cont.addClass("loading_img"); 
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'my_admin/update_advert/"+id ,
								success: function (data) {
										cont.removeClass("loading_img"); 
										cont.html(data);
										
								}
							});	 
						
					}  
					function delete_advert(id){
	
						
						$("#modal-advert-delete").bind("show", function() {
							var removeBtn = $(this).find(".btn-primary"),
								href = removeBtn.attr("href");
								
								removeBtn.click(function(e) { 
										
									e.preventDefault();
					
											$.ajax({
												type: "post",
												url: "'.site_url('/').'adverts/delete_advert/" ,
												data: {advert_id: id},
												success: function (data) {
													 
													 $("#modal-advert-delete").modal("hide");
													 $("#advert_img").html(data);
													 load_ajax("adverts");
												}
											});
								});
						}).modal({ backdrop: true });
					}					
					function advert_stats(id){
	
						var cont = $("#admin_content");
						cont.empty();
						cont.addClass("loading_img"); 
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url("/").'adverts/advert_stats/"+id ,
								success: function (data) {
										cont.removeClass("loading_img"); 
										cont.html(data);
										
								}
							});	 
						
					}
				</script>';
			
		 }else{
			
			echo '<div class="alert">
				<a onclick="toggle_advert_add()" class="btn pull-right"><i class="icon-plus-sign"></i> Add New Advert</a>
				 <h4>No Adverts added</h4> No adverts have been added.
				 
				</div>'; 
			 
			 
		 }
		  	  
		
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET RANDOM ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_sdvert($query = ''){
		
		
		$query = $this->db->query("SELECT * FROM adverts WHERE IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() AND TYPE = 'B' ORDER BY RAND() LIMIT 1" ,FALSE);
		if($query->result()){
			echo '
				 ';
			
			foreach($query->result() as $row){
				
				if($row->ADVERTS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = S3_URL.'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;
					
				}
				
				if($row->URL == ''){
					
					$link1 = '';
					$link2 = '';
					
				}else{
					
					$link1 = '<a href="'.prep_url($row->URL).'" target="_blank">';
					$link2 = '</a>';
					
				}

				
				echo ' <div class="row-fluid">
							<div class="span12  results_div">
								'.$link1.'<img class="lazy" style="width:100%" src="'.base_url('/').'img/advert_place_load.gif" alt="'.strip_tags($row->ADVERTS_HEADER).'" data-original="'.$img.'" />'.$link2.'
							</div>
							
						</div>	
					  </div>';
				
			}
			
			$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
			echo ' <script type="text/javascript">

						$(document).ready(function(){
							$("img.lazy").lazyload({
								  effect : "fadeIn"
							  });
						
						});
					  </script>';
			
			
		 }else{
		
		 }
	
	}
	
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+ADD ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function add_advert($bus_id = 0){
		
		$advert_id = $this->input->post('advert_id',TRUE);
		$title = $this->input->post('advert_title',TRUE);
		$start = $this->input->post('dpstart',TRUE);
		$end = $this->input->post('dpend',TRUE);
		$cont = $this->input->post('advert_content',TRUE);
		$category = $this->input->post('advert_cat',TRUE);
		$link = $this->input->post('advert_link',TRUE);
		$advert_loc = $this->input->post('advert_loc',TRUE);
		$advert_type = $this->input->post('advert_type',TRUE);
		$product_cat = $this->input->post('product_cat',TRUE);
		//$product_cat = $this->input->post('_cat',TRUE);

		if($this->input->post('advert_cat_sub')){
			
			$sub = array();
			foreach($this->input->post('advert_cat_sub') as $row){
				
				array_push($sub, $row);
				//echo $row;
				
			}
			$sub_id = json_encode($sub);	
			
		}
		$sub_sub_id = '';
		if($this->input->post('advert_cat_sub_sub')){
			
			$sub_sub = array();
			foreach($this->input->post('advert_cat_sub_sub') as $row2){
				
				array_push($sub_sub, $row2);
				//echo $row;
				
			}
			$sub_sub_id = json_encode($sub_sub);	
			
		}
		
		//IF NEW DEAL
		if($advert_id == '0'){
			
			//INSERT
			$insertdata = array(
				'BUSINESS_ID'=> $bus_id ,
				'ADVERTS_HEADER'=> $title ,
				 'ADVERTS_CONTENT'=> $cont,
				'ADVERTS_STARTING_DATE'=> $start,
				'ADVERTS_EXPIRE_DATE'=> $end,
				'IS_ACTIVE' => 'N',
				'CATEGORY_SUB_ID'=> $category,
				'MAIN_CAT_ID' => $product_cat,
				'SUB_CAT_ID' => $sub_id,
				'SUB_SUB_CAT_ID' => $sub_sub_id,
				'LOCATION' => $advert_loc,
				'TYPE' => $advert_type,
				'URL' => $link
			);
			
			$this->db->insert('adverts', $insertdata);
			
			//GET NEW DEAL ID
			$this->db->select_max('ID');
			$this->db->where('BUSINESS_ID',$bus_id);
			$query = $this->db->get('adverts');
			$row = $query->row_array();
			$advert_id =  $row['ID'];
			
			echo '<div class="alert alert-success">Advert saved</div>
			<script type="text/javascript">
				$("#btn_add_advert_img").fadeIn();
				$("#advert_id").val('.$advert_id.');
				$("#advert_id_advert_img").val('.$advert_id.');
				
				var x = $("#btn_add_advert_img");
						x.popover({  delay: { show: 100, hide: 3000 },
						 placement:"top",html: true,trigger: "manual",
						 title:"Add a Graphic", content:"Great, advert has been added. Please upload the advert graphic"});
						x.popover("show");
						$("html, body").animate({
							 scrollTop: (x.offset().top - 200)
						 }, 300);
			</script>'
			;
			
			
		}else{

			//UPDATE
			$insertdata = array(
				'BUSINESS_ID'=> $bus_id ,
				'ADVERTS_HEADER'=> $title ,
				 'ADVERTS_CONTENT'=> $cont,
				'ADVERTS_STARTING_DATE'=> $start,
				'ADVERTS_EXPIRE_DATE'=> $end,
				'CATEGORY_SUB_ID'=> $category,
				'MAIN_CAT_ID' => $product_cat,
				'SUB_CAT_ID' => $sub_id,
				'SUB_SUB_CAT_ID' => $sub_sub_id,
				'LOCATION' => $advert_loc,
				'TYPE' => $advert_type,
				'URL' => $link
			);
			
			$this->db->where('ID', $advert_id);
			$this->db->update('adverts', $insertdata);

			echo '<div class="alert alert-success">Advert updated</div>
			<script type="text/javascript">
				$("#btn_add_advert_img").fadeIn();
				$("#advert_id").val('.$advert_id.');
				$("#advert_id_advert_img").val('.$advert_id.');
			
			</script>'
			;			
		}

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD ADVERT IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function add_advert_img()
	{
		    $img = $this->input->post('userfile', TRUE);
			$advert_id = $this->input->post('advert_id_advert_img', TRUE);
			$bus_id = $this->input->post('bus_id_advert_img', TRUE);
			//CHECK IF NEW OR UPDATE
			if($advert_id != '0'){
				$this->db->where('ID', $advert_id);
				$query = $this->db->get('adverts');
				if($query->result()){
					
					$row = $query->row_array();
					
					$img_file = $row['ADVERTS_IMAGE_NAME'];
					
					if($img_file != ''){
						
							$file_large =  BASE_URL.'assets/adverts/images/' . $img_file; # build the full path		
			
						   if (file_exists($file_large)) {
								unlink($file_large);
							}
					}
						
				}
			}
			//upload file
			
			$config['upload_path'] = BASE_URL.'assets/adverts/images/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					
					$data['error'] =  $this->upload->display_errors();
					echo 
					'<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>'
           			 . $data['error'].'
       				 </div><script type="text/javascript">
					 	$("#gal-cover").hide();
				    </script>'; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{	
			
			
			//$file = array('upload_data'
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	//delete old photo
			//$this->delete_old_child_photo($child_id,$pro_id);
			//$this->update_pro_book_image($child_id,$pro_id,$file);
					 
				if (($width > 850) || ($height > 700)){
						
						 $this->downsize_image($file);
								
				}


			   //populate array with values
				$data = array(
					
			     	'ADVERTS_IMAGE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID',$advert_id);
				$this->db->update('adverts',$data);
				
				//SEND TO BUCKET
				//$this->load->model('gcloud_model');
				//$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
				$this->load->model('cron_model');
				//UPLOAD S3
				if(file_exists(BASE_URL.'/assets/adverts/images/' . $file)){
					
					$data['out'] = $this->cron_model->upload_s3('assets/adverts/images/' . $file);
				}else{
					
					$data['out'] = 'Not Uploaded';
					
				}
				
				$image = S3_URL . 'assets/adverts/images/'.$file;
			   //redirect 
			    $data['basicmsg'] = 'Graphic added successfully!';
				echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'. $data['basicmsg'].'
       				 </div>
					 <script type="text/javascript">
					 show_advert_img("'.$advert_id.'");
					 </script>
					 ';
			
		}
	}	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE ADVERT IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file){
		$this->load->library('image_lib');
		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => (BASE_URL .'assets/adverts/images/'. $file),
		   'master_dim' => 'auto',
		   'width' => '800',
		   'height' => '800',
		   'maintain_ratio' => true
		  ); 
		 
		 
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['gallmsg'] = $this->image_lib->display_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
	}
	
	function show_advert_img($id)
	{
		$this->db->where('ID', $id);
		$query = $this->db->get('adverts');
		if($query->result()){
			
			$row = $query->row_array();
			
			$var = '<img src="'.S3_URL.'assets/adverts/images/'.$row['ADVERTS_IMAGE_NAME'].'" class="img-polaroid" style="width:95%;margin-bottom:20px"/>';
			return $var;
			
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function delete_advert($id){
		
		$id = $this->input->post('advert_id',TRUE);
		
			$this->db->where('ID' , $id);
			$query = $this->db->get('adverts');
			
			if($query->result()){
				$row = $query->row_array();
				
				$img_file = $row['ADVERTS_IMAGE_NAME'];
				$bus_id = $row['BUSINESS_ID'];
				
				//DELETE IMAGE
				$this->delete_advert_img($img_file);	
									
				  $this->db->where('ID' , $id);
				  $this->db->delete('adverts');
				  echo 
				  '<div class="alert alert-success">
				  <button type="button" class="close" data-dismiss="alert">×</button><p>Advert deleted successfully!</p>
				   </div>
				   <script type="text/javascript">
					  
				  </script>'; 
						
				
			//no existing deal	
			}else{
				
				echo 
						'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Advert could not be deleted!</p></div>
						 </div><script type="text/javascript">
							
						</script>'; 
			}			
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE ADVERT IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function delete_advert_img($img_file){
		
							
		  $file_large =  BASE_URL.'assets/adverts/images/' . $img_file; # build the full path		
  
				 if (file_exists($file_large)) {
					  unlink($file_large);
				  }

	}	
		

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS CATEGORIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
    //Get Main Categories
	function get_product_categories(){
      	
		$this->db->where('main_cat_id', 0);
		$test = $this->db->get('product_categories');
		return $test;	  
    }
	
    //Get SUB Categories
	function get_product_categories_sub($main_cat_id, $curr){
      	
		$this->db->where('main_cat_id', $main_cat_id);
		$this->db->where('sub_cat_id', 0);
		$cats = $this->db->get('product_categories');
		$curr = json_decode($curr);
		foreach($cats->result() as $row){
                                                               
			//echo $var;
			if(in_array($row->cat_id, $curr)){
				
				echo '<option value="'.$row->cat_id.'" selected="selected">'.$row->category_name.'</option>';	
					
			}else{
				
				echo '<option value="'.$row->cat_id.'" >'.$row->category_name.'</option>';	
				
			}	
			
		}

			  
    }
	
	    //Get SUB Categories
	function get_product_categories_sub_sub($curr){
      	
		$this->db->where('main_cat_id !=', '0');
		$this->db->where('sub_cat_id !=', '0');
		$this->db->where('sub_sub_cat_id', 0);
		$cats = $this->db->get('product_categories');
		$curr = json_decode($curr);
		foreach($cats->result() as $row){
                                                               
			//echo $var;
			if(in_array($row->cat_id, $curr)){
				
				echo '<option value="'.$row->cat_id.'" selected="selected">'.$row->category_name.'</option>';	
					
			}else{
				
				echo '<option value="'.$row->cat_id.'" >'.$row->category_name.'</option>';	
				
			}	
			
		}

			  
    }

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//METRICS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function track($ad_id, $rand)
	{
		   
		 $this->db->where('ID', $ad_id);
		 $advert = $this->db->get('adverts');
		 if($advert->result()){
			 
			 $advert = $advert->row();
			 $this->load->library('user_agent');
			 $data['advert_id'] = $ad_id;
			 $data['IP'] = $this->input->ip_address();
			 $data['client'] = $this->agent->agent_string();
			 $data['referrer'] = $this->agent->referrer();
			 $this->db->insert('advert_tracking', $data);
			 
			 redirect(prep_url($advert->URL) , 301); 
			 
		 }else{
			 
			redirect(current_url('/'), 301); 
			 
		 }
		  
	}

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS CATEGORIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
    //Get Main Categories
	function get_main_categories(){
      	
		$test = $this->db->get('a_tourism_category');
		return $test;	  
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET CITIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
    //Get Main Categories
	function get_cities(){
      	
		$test = $this->db->get('a_map_location');
		return $test;	  
    }
	    //Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
	

}
?>