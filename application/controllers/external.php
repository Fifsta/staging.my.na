<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class External extends CI_Controller {

	/**
	 * External business Listing Functionality Controller for My.Na
	 * Roland Ihms
	 * Sites Allowed:
	 * Trip-Travel (http://trip.com.na/)
	 * NTB (http://namibiatourism.com.na)
	 * Intouch (http://intouch.com.na)
	 */
	 
	function External()
	{
		parent::__construct();
		$this->load->model('members_model');

	}
	
	
	public function index()
	{
		echo 'Going Nowhere slowly...';
	}


    //+++++++++++++++++++++++++++
	//GET CLIENT DETAILS
	//++++++++++++++++++++++++++	

	public function get_client()
	{
		error_reporting(E_ALL);
		$this->output->set_header("Access-Control-Allow-Origin: http://apps.namib.co");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		$this->output->set_content_type( 'text/html' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET"){
			
			if($id = $this->input->get_post('client_id', true)){
				
				$this->db->where('ID', $id);
				$user = $this->db->get('u_client');
				
				if($user->result()){
					
					$row = $user->row();
					$o['success'] = true;
					$o['name'] = $row->CLIENT_NAME.' '.$row->CLIENT_SURNAME;
					$o['mobile'] = $row->DIAL_CODE.' '.$row->CLIENT_CELLPHONE;
					$o['email'] = $row->CLIENT_EMAIL;
					$o['verified'] = $row->VERIFIED;
				}else{
					
					$o['success'] = false;
					$o['msg'] = 'User not found';
				}
				
			}else{
				
				$o['success'] = false;
				$o['msg'] = 'User ID not found';
			}
			
			echo json_encode($o);
			
		}

	}


    //+++++++++++++++++++++++++++
	//GET ALL TOURISM RELATED BUSINESS IN SELECT BOX
	//++++++++++++++++++++++++++	
	function get_tourism_businesses_select()
	{
			
			$this->output->set_header("Access-Control-Allow-Origin: http://www.intouch.com.na");
			$this->output->set_header("Access-Control-Allow-Origin: http://intouch.com.na");
			$this->output->set_header("Access-Control-Allow-Origin: http://trip.com.na");
			$this->output->set_header("Access-Control-Allow-Origin: http://www.trip.com.na");
			$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
			$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
			$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
			$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
			
			$this->output->set_content_type( 'multipart/form-data' );
			$this->output->_display();
			//GET ALL TOURISM CATEGORU+Y BUSINESSES
			//TORISM MAIN CATEGORIES = 3, 4, 5, 12, 9
			$query = $this->db->query("SELECT u_business.ID, u_business.BUSINESS_NAME FROM u_business JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID 
								JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
								WHERE a_tourism_category_sub.CATEGORY_TYPE_ID IN (3, 4, 5, 12, 9) GROUP BY u_business.ID", FALSE);
			
			if($query->result()){
				
				echo '<select>';
				
					foreach($query->result() as $row){
						
						$name = ucwords(filter_var(utf8_decode($row->BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
						echo '<option value="'.$row->ID.'">'.$name.'</option>';	
						
					}
				
				echo '</select>';
			}
			
			
	}

    //+++++++++++++++++++++++++++
	//GET ALL TOURISM RELATED BUSINESS IN ARRAY
	//++++++++++++++++++++++++++	
	function get_tourism_businesses()
	{

			error_reporting(E_ALL);
			//var_dump($_SERVER);
			$HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
			
			/*if ($HTTP_ORIGIN == "http://www.trip.com.na" || $HTTP_ORIGIN == "http://trip.com.na" || $HTTP_ORIGIN == "http://www.trip.com.na" || $HTTP_ORIGIN == "http://www.namibiatourism.com.na" || $HTTP_ORIGIN == "http://localhost")
			{ */
					header("Access-Control-Allow-Origin: *");
					//$this->output->set_header("Access-Control-Allow-Origin: http://www.okutala.com");
//					$this->output->set_header("Access-Control-Allow-Origin: http://okutala.com");
//					$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
//					$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
//					
//					$this->output->set_content_type( 'text/json' );
//					$this->output->_display();
//			/}

			//$this->output->_display();
			//GET ALL TOURISM CATEGORU+Y BUSINESSES
			//TORISM MAIN CATEGORIES = 3, 4, 5, 12, 9
			$query = $this->db->query("SELECT u_business_map.BUSINESS_MAP_LONGITUDE, u_business_map.BUSINESS_MAP_LATITUDE, u_business_map.BUSINESS_MAP_ZOOM_LEVEL, u_business.ID, u_business.BUSINESS_NAME
									FROM u_business JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
									JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
									JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
									WHERE a_tourism_category_sub.CATEGORY_TYPE_ID IN (3, 4, 5, 12, 9) GROUP BY u_business.ID ORDER BY u_business.BUSINESS_NAME", FALSE);

			$array = array();
			if($query->result()){

				foreach($query->result() as $row){

					$name = $row->BUSINESS_NAME;
					$lat = $row->BUSINESS_MAP_LATITUDE;
					$long = $row->BUSINESS_MAP_LONGITUDE;
					$zoom = $row->BUSINESS_MAP_ZOOM_LEVEL;
					array_push($array, $row->ID, $name, $lat, $long, $zoom);

				}

			}else{

				echo 'No Results';
			}
			
			echo json_encode($array);

	}





    //+++++++++++++++++++++++++++
	//GET ALL SINGLE BUSINESS IN ARRAY
	//++++++++++++++++++++++++++	
	function get_tourism_business($id)
	{
			
			$HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
			
			if ($HTTP_ORIGIN == "http://www.intouch.com.na" || $HTTP_ORIGIN == "http://intouch.com.na" || $HTTP_ORIGIN == "http://www.trip.com.na" || $HTTP_ORIGIN == "http://www.namibiatourism.com.na" || $HTTP_ORIGIN == "http://localhost")
			{  
				header("Access-Control-Allow-Origin: $HTTP_ORIGIN");
			}
			
			/*$this->output->set_header("Access-Control-Allow-Origin: http://www.intouch.com.na");
			$this->output->set_header("Access-Control-Allow-Origin: http://intouch.com.na");
			$this->output->set_header("Access-Control-Allow-Origin: http://trip.com.na");
			$this->output->set_header("Access-Control-Allow-Origin: http://www.trip.com.na");*/
			//GET ALL TOURISM CATEGORU+Y BUSINESSES
			//TORISM MAIN CATEGORIES = 3, 4, 5, 12, 9
			$query = $this->db->query("SELECT u_business.ID,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.BUSINESS_URL,u_business.BUSINESS_NAME,u_business.BUSINESS_EMAIL,u_business.BUSINESS_TELEPHONE
								,u_business.BUSINESS_FAX,u_business.BUSINESS_CELLPHONE,u_business.BUSINESS_DESCRIPTION, u_business.BUSINESS_POSTAL_BOX,
								u_business.BUSINESS_PHYSICAL_ADDRESS, u_business.BUSINESS_VIRTUAL_TOUR_NAME
								 , u_business_map.BUSINESS_MAP_LONGITUDE, u_business_map.BUSINESS_MAP_LATITUDE, u_business_map.BUSINESS_MAP_ZOOM_LEVEL FROM u_business 
								JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
								WHERE u_business.ID = '".$id."'", FALSE);
			
			$array = array();
			if($query->result()){

				$array = $query->row();
	
			}
			
			echo json_encode($array);
			//return $array;			
			
	}
	
	
    //+++++++++++++++++++++++++++
	//GET ALL BUSINESS GALLERY
	//++++++++++++++++++++++++++	
	function get_business_gallery($id)
	{
			
			$HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
			
			if ($HTTP_ORIGIN == "http://www.intouch.com.na" || $HTTP_ORIGIN == "http://intouch.com.na" || $HTTP_ORIGIN == "http://www.trip.com.na" || $HTTP_ORIGIN == "http://www.namibiatourism.com.na" || $HTTP_ORIGIN == "http://localhost")
			{  
				header("Access-Control-Allow-Origin: $HTTP_ORIGIN");
			}
			//GET ALL TOURISM CATEGORU+Y BUSINESSES
			//TORISM MAIN CATEGORIES = 3, 4, 5, 12, 9
			$query = $this->db->query("SELECT * FROM u_gallery_component 
								WHERE BUSINESS_ID = '".$id."'", FALSE);
			
			$array = array();
			if($query->result()){

					foreach($query->result() as $row){
						
						$file = S3_URL.'assets/business/gallery/'.$row->GALLERY_PHOTO_NAME;
						array_push($array, $file); 

					}
	
			}
			
			echo json_encode($array);
			//return $array;			
			
	}	
	
	
	
	
	
	
	
	
    //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++	
	function update_business_do()
	{
			
			$this->output->set_header("Access-Control-Allow-Origin: http://cms.my.na");
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);


			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';
					
		//	}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required! ' . $cellNum;
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
		//	}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($web != ''){
						
				if(!filter_var($web, FILTER_VALIDATE_URL)){
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				}else{
				   $val = TRUE;	
				}
			
			}elseif(str_word_count($description) < 30){
				$val = FALSE;
				$error = 'Please provide a minimum of 30 words for your business description. Currently: '.str_word_count($description).' words.';	
				
			}else{
				$val = TRUE;
			}
			
		
			
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'BUSINESS_NAME'=> $name ,
								  'BUSINESS_TELEPHONE'=> '+264 ' .$tel2 ,
								   'BUSINESS_EMAIL'=> $email,
								   'BUSINESS_CELLPHONE'=> '+264 ' .$cell, 
								  'BUSINESS_FAX'=> '+264 ' .$fax2,
								  'BUSINESS_DESCRIPTION'=> $description,
								  'BUSINESS_POSTAL_BOX'=> $pobox,
								  'BUSINESS_URL' => $web,
								  'BUSINESS_PHYSICAL_ADDRESS' => $address
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('ID' , $bus_id);
					$this->db->update('u_business', $insertdata);
					$this->sync_tourism_db($insertdata, $bus_id);
					//success redirect	
					$data['bus_id'] = $bus_id;
					$data['id'] = $this->session->userdata('id');
					$data['basicmsg'] = $name . ' has been updated successfully';
					redirect('/members/business/'.$bus_id.'/'.$this->clean_url($data['basicmsg']));
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					$this->load->view('members/business_details',$data);
				
			}
	}
	
	
    //+++++++++++++++++++++++++++
	//EXTERNAL USE TEAM NAMIBIA && NCCI 
	//++++++++++++++++++++++++++
	// TEAM NAMIBIA
	// NCCI
    //+++++++++++++++++++++++++++
	//UPLOAD COVER IMAGE     
	//++++++++++++++++++++++++++
	
	function add_cover_image()
	{
		
		
		$HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
			
		if ($HTTP_ORIGIN == "https://teamnamibia.my.na" || $HTTP_ORIGIN == "https://ncci.my.na" || $HTTP_ORIGIN == "https://nmh.my.na")
		{  
				$this->output->set_header("Access-Control-Allow-Origin: ".$HTTP_ORIGIN);
		}
		
		
		
		//$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		
		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';
			
		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			
			 $this->load->model('members_model');	
			 $this->load->library('image_lib');	
			 $this->load->library('upload');  // NOTE: always load the library outside the loop
			 $bus_id = $this->input->post('bus_id_cov', TRUE);
			 $name = $this->input->post('bus_name_cov', TRUE);
			 $name1 = str_replace('--','-', preg_replace('/[^A-Za-z0-9\-]/', '-', $name)). rand(9,99999);
			 
			 //var_dump($_FILES['files']);
			 if(isset($_FILES['cover_file']['name'])){
					
					$this->total_count_of_files = count($_FILES['cover_file']['name']);
					/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
			 
					 for($i=0; $i<$this->total_count_of_files; $i++)
					 {
					   
					   $_FILES['userfile']['name']    = $_FILES['cover_file']['name'][$i];
					   $_FILES['userfile']['type']    = $_FILES['cover_file']['type'][$i];
					   $_FILES['userfile']['tmp_name'] = $_FILES['cover_file']['tmp_name'][$i];
					   $_FILES['userfile']['error']       = $_FILES['cover_file']['error'][$i];
					   $_FILES['userfile']['size']    = $_FILES['cover_file']['size'][$i];
					
					   
					   $config['upload_path'] = BASE_URL.'assets/business/photos/';
					   $config['allowed_types'] = 'jpg|jpeg|gif|png';
					   $config['overwrite']     = FALSE;
					   $config['max_size']	= '0';
					   $config['max_width']  = '8324';
					   $config['max_height']  = '8550';
					   $config['min_width']  = '750';
					   $config['min_height']  = '300';
					   $config['remove_spaces']  = TRUE;
					   $config['file_name']  = $name1;
					   
					
					  $this->upload->initialize($config);
					
						  if($this->upload->do_upload())
						  {
							  //$file = array('upload_data'
							  $data = array('upload_data' => $this->upload->data());
							  $file =  $this->upload->file_name;
							  $width = $this->upload->image_width;
							  $height = $this->upload->image_height;	
							  //delete old photo
							  //$this->delete_old_child_photo($child_id,$pro_id);
							  //$this->update_pro_book_image($child_id,$pro_id,$file);
								
								//delete old photo
								$this->members_model->delete_old_cover($bus_id);	
									   
								  if (($width > 1850) || ($height > 800)){
										   
										  $this->members_model->downsize_cover($file,$bus_id);
												  
								  }
								
								  
								  $data = array( 
									'BUSINESS_COVER_PHOTO'=> $file
								   
								  );
								  //insert into database
								  $this->db->where('ID', $bus_id);
								  $this->db->update('u_business',$data);
								 
								 /*if ($this->is_han_member($bus_id)){
									 
									  //Tourism DB
									 $db2 = $this->connect_tourism_db();
									 //insert into database
									 $db2->where('ID', $bus_id);
									 $db2->update('u_business',$data);
									 
								 }*/
	
								 
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = S3_URL . "assets/business/photos/".$file;


								  //SEND TO BUCKET
								  //$this->load->model('gcloud_model');
								  //$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
								  $this->load->model('cron_model');
								  //UPLOAD S3
								  if(file_exists(BASE_URL.'/assets/business/photos/' . $file)){

									  $data['out'] = $this->cron_model->upload_s3('assets/business/photos/' . $file);
								  }else{

									  $data['out'] = 'Not Uploaded';

								  }
								  
								 echo '<script type="text/javascript">
											$("#cover_div").css("background-image","url('.$image.')");
										</script>';
										
						  }else{
							//ERROR
								$val = FALSE;
								$data['error'] =  $this->upload->display_errors();
								 
							
						  }
					 }
					
					 //redirect
					 if($val == TRUE){
						  
						 $data['basicmsg'] = $i .' Cover added successfully!';
						 echo '<div class="alert alert-success">
								 <button type="button" class="close" data-dismiss="alert">×</button>
								'. $data['basicmsg'].'
								 </div>
								 <script type="text/javascript">
								 
								$("#cover_div").css("background-image","url('.$image.')");
								 
								 
								 </script>
							';
						
					 }else{
						 
						 echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>'
								 . $data['error'].'
								 </div><script type="text/javascript">
									console.log("error");
									
								</script>';
					 }
			 }else{
				  echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							 No Files Selected - Please select a cover file and try again
							 </div><script type="text/javascript">
								console.log("error");
								
							</script>';
				 
			 }
			 
			 	
			 
		}else{
			
			echo 'You do not have access rights';
			 
		}//end preflight
	}

	
   //+++++++++++++++++++++++++++
	//UPLOAD LOGO IMAGE     
	//++++++++++++++++++++++++++
	
	function add_logo_image()
	{

		$HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];
			
		if ($HTTP_ORIGIN == "https://teamnamibia.my.na" || $HTTP_ORIGIN == "https://ncci.my.na" || $HTTP_ORIGIN == "https://nmh.my.na")
		{  
				$this->output->set_header("Access-Control-Allow-Origin: ".$HTTP_ORIGIN);
		}

		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		
		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';
			
		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			
			 $this->load->model('members_model');	
			 $this->load->library('image_lib');	
			 $this->load->library('upload');  // NOTE: always load the library outside the loop
			 $bus_id = $this->input->post('bus_id', TRUE);
			 $name = $this->input->post('bus_name_logo', TRUE);
			 $name1 = str_replace('--','-', preg_replace('/[^A-Za-z0-9\-]/', '-', $name)). rand(9,99999);
			 
			 //var_dump($_FILES);
			 if(isset($_FILES['logo_file']['name'])){

					
					$this->total_count_of_files = count($_FILES['logo_file']['name']);
					/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
			 
					 for($i=0; $i<$this->total_count_of_files; $i++)
					 {
					   
					   $_FILES['userfile']['name']    = $_FILES['logo_file']['name'][$i];
					   $_FILES['userfile']['type']    = $_FILES['logo_file']['type'][$i];
					   $_FILES['userfile']['tmp_name'] = $_FILES['logo_file']['tmp_name'][$i];
					   $_FILES['userfile']['error']       = $_FILES['logo_file']['error'][$i];
					   $_FILES['userfile']['size']    = $_FILES['logo_file']['size'][$i];
					
					   
					   $config['upload_path'] = BASE_URL.'assets/business/photos/';
					   $config['allowed_types'] = 'jpg|jpeg|gif|png';
					   $config['overwrite']     = FALSE;
					   $config['max_size']	= '0';
					   $config['max_width']  = '8324';
					   $config['max_height']  = '8550';
					   $config['min_width']  = '250';
					   $config['min_height']  = '250';
					   $config['remove_spaces']  = TRUE;
					   $config['file_name']  = $name1;
					   
					
					  $this->upload->initialize($config);
					
						  if($this->upload->do_upload())
						  {
							
								//delete old photo
								$this->members_model->delete_old_logo($bus_id);
								
								$data = array('upload_data' => $this->upload->data());
								$file =  $this->upload->file_name;
								$width = $this->upload->image_width;
								$height = $this->upload->image_height;	
								
								$format = substr($file,(strlen($file) - 4),4);
								$str = substr($file,0,(strlen($file) - 4));	
								//Convert To jpg
								$this->members_model->convert_logo_jpg($str, $file);
									 
									if (($width > 850) || ($height > 700)){
											 
											$this->members_model->downsize_logo($file,$bus_id);
													
									}
									
								
								//Watermark image
								//$this->members_model->watermark_logo($file);
								
								  
								  $data = array( 
									'BUSINESS_LOGO_IMAGE_NAME'=> $file
								   
								  );
								  //insert into database
								  $this->db->where('ID', $bus_id);
								  $this->db->update('u_business',$data);
								 
								 if ($this->is_han_member($bus_id)){
									 
									  //Tourism DB
									 //$db2 = $this->connect_tourism_db();
									 //insert into database
									 //$db2->where('ID', $bus_id);
									// $db2->update('u_business',$data);
									 
								 }
	
								 
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = S3_URL . "assets/business/photos/".$file;


								  //SEND TO BUCKET
								  //$this->load->model('gcloud_model');
								  //$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
								  $this->load->model('cron_model');
								  //UPLOAD S3
								  if(file_exists(BASE_URL.'assets/business/photos/' . $file)){

									  $data['out'] = $this->cron_model->upload_s3('assets/business/photos/' . $file);
								  }else{

									  $data['out'] = 'Not Uploaded';

								  }

								  
								 echo '<script type="text/javascript">
											$("#avatar").attr("src", "'.$image.'");
										</script>';
										
						  }else{
							//ERROR
								$val = FALSE;
								$data['error'] =  $this->upload->display_errors();
								 
							
						  }
					 }
					
					 //redirect
					 if($val == TRUE){
						  
						 $data['basicmsg'] = ' Logo added successfully!';
						 echo '<div class="alert alert-success">
								 <button type="button" class="close" data-dismiss="alert">×</button>
								'. $data['basicmsg'].'
								 </div>
								<script type="text/javascript">
											$("#avatar").attr("src", "'.$image.'");
								</script>
							';
						
					 }else{
						 
						 echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>'
								 . $data['error'].'
								 </div><script type="text/javascript">
									console.log("error");
									
								</script>';
					 }
			 }else{
				  echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							 No Files Selected - Please select a logo file and try again
							 </div><script type="text/javascript">
								console.log("error");
								
							</script>';
				 
			 }
			 
			 	
			 
		}else{
			
			echo 'You do not have access rights';
			 
		}//end preflight
	}
	

	//++++++++++++++++++++++++++++++++++++++++++++
	//IS HAN MEMBER
	//++++++++++++++++++++++++++++++++++++++++++++	

	function is_han_member($bus_id){

		$this->db->where('ID', $bus_id);
		$this->db->where('IS_HAN_MEMBER', 'Y');
		$query = $this->db->get('u_business');
		
		if($query->result()){
			
			return TRUE;
		
		}else{
			
			return FALSE;
				
		}
		
	}


    //+++++++++++++++++++++++++++
    //ADD PRODUCRT IMAGE
    //++++++++++++++++++++++++++

    function add_product_image()
    {

        $HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];

        if ($HTTP_ORIGIN == "https://teamnamibia.my.na" || $HTTP_ORIGIN == "https://ncci.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$HTTP_ORIGIN);
        }

        $this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
        $this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //$this->output->set_output( "*" );
            //$this->output->set_header("Access-Control-Allow-Credentials: true");
            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {

            $img = $this->input->post('userfile', TRUE);
            $bus_product_id = $this->input->post('bus_product_id');
            //upload file
            $config['upload_path'] = BASE_URL . 'assets/business/products/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '8024';
            $config['max_width'] = '8324';
            $config['max_height'] = '8550';
            $config['min_width'] = '200';
            $config['min_height'] = '200';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;


            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {

                $data['error'] = $this->upload->display_errors();

                echo '<div class="alert alert-error">' . $data['error'] . '</div>';


            } else {
                //LOAD library
                //$this->load->library('image_lib');

                $data = array('upload_data' => $this->upload->data());
                $file = $this->upload->file_name;
                $width = $this->upload->image_width;
                $height = $this->upload->image_height;

                $format = substr($file, (strlen($file) - 4), 4);
                $str = substr($file, 0, (strlen($file) - 4));

                /*if (($width > 1950) || ($height > 750)){

                        $this->load->model('image_model');
                        $this->image_model->downsize_image($file);

                }*/

                //populate array with values
                $data = array(
                    'img_file' => $file

                );
                //$my_db = $this->connect_my_db();

                //insert into database
                $this->db->where('bus_product_id', $bus_product_id);
                $this->db->update('u_business_products', $data);

                $data['filename'] = $file;
                $data['width'] = $this->upload->image_width;
                $data['height'] = $this->upload->image_height;
                $image = base_url('/') . 'assets/business/products/' . $file;
				
				  //SEND TO BUCKET
				  //$this->load->model('gcloud_model');
				  //$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
				  $this->load->model('cron_model');
				  //UPLOAD S3
				  if(file_exists(BASE_URL.'/assets/business/products/' . $file)){
	
					  $data['out'] = $this->cron_model->upload_s3('assets/business/products/' . $file);
				  }else{
	
					  $data['out'] = 'Not Uploaded';
	
				  }
				
				
                //redirect
                $data['basicmsg'] = 'Image added successfully!';
                $str = '<div id="feat_img"><div class="img-polaroid"><img src="' . $image . '" /><p style="padding:10px 10px 0px 0px;text-align:right"><a href="javascript:void(0);" onclick="remove_img(' . $bus_product_id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p></div></div>';
                echo '<div class="alert alert-success">' . $data['basicmsg'] . '</div>';
                echo "<script>

                          $('#feat_img').html('" . $str . "');
                          $('#add_img').fadeOut();
                          </script>";


            }
        }
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
	
	   	//connect to tourism db
	function connect_my_cms_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'cmsmy_user';
		$config_db['password'] = '6kT{#rpx@}R.';
		$config_db['database'] = 'cmsmy_db';
		
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

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */