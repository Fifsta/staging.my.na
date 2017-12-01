<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Han extends CI_Controller {

	/**
	 * HAN Controller for My.na.
	 *
	 * Roland Ihms
	 */
	function Han()
	{
		parent::__construct();
	}

	
	public function index()
	{
		if($this->session->userdata('id')){
			 	
			redirect('/ntb/landing/', 301);
		
		}else{
			
			     $this->load->view('ntb/login');
		 }			

	}

	//Get Account Details
	function get_client_account($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');
		return $test->row_array();		  
    }
	//Get Business Details
	function get_business($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_business');
		return $test->row_array();		  
    }


/**
++++++++++++++++++++++++++++++++++++++++++++
//EMAIL FUNCTIONS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
    //+++++++++++++++++++++++++++
	//COMPOSE NEWSLETTER
	//++++++++++++++++++++++++++	
	function build_mail()
	{	
			$this->load->model('admin_model');
			$this->load->model('email_model');
			$data['admin_id'] = $this->session->userdata('admin_id');
			$this->load->view('han/build_mail', $data);	
		
	}		

    //+++++++++++++++++++++++++++
	//PREVIEW NEWSLETTER
	//++++++++++++++++++++++++++	
	function preview_news()
	{	
		$data['preview'] = 'true';
		$data['body'] = $this->input->post('mailbody',TRUE);
		//$data['body'] = urldecode($body);
		
		$this->load->view('email/body_news_han', $data);	

		
	}		

	function show_email_recipients($type){
      	
		$this->load->model('admin_model');
		$this->admin_model->show_email_recipients($type);  
    }	

	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_email()
	{
		 //if($this->session->userdata('admin_id')){
			//GET EMAIL FILDS 	
			$recipients = $this->input->post('recipients',TRUE);
			$subject = $this->input->post('title',TRUE);
			$body = $this->input->post('content',FALSE);
			$type = $this->input->post('stype',FALSE);		
			$count = 0;
			$mandrill[] = array();
			$this->load->model('admin_model');
			
			//CHECK IF ALL CLIENTS SELECTED
			if(empty($_POST['selectall'])){
						//ONLY SELECTED
						if(!empty($_POST['recipients'])) {
							$num = count($_POST['recipients']);
							 foreach($_POST['recipients'] as $value) {
								
								if($type == 'business' || $type == 'ntb' || $type == 'han'){
									
									$row = $this->admin_model->get_business_row($value);
									$toname = $row['BUSINESS_NAME'];
									$toemail = $row['BUSINESS_EMAIL'];
								}else{
									
									$row = $this->admin_model->get_client_row($value);
									$toname = $row['CLIENT_NAME'];
									$toemail = $row['CLIENT_EMAIL'];
								}
								
								$data2['body'] = $body;
								$body1 = $this->load->view('email/body_news_han',$data2,true);
								$data['ADMIN_ID'] = $this->session->userdata('admin_id');
								
								$data['FROM'] = 'no-reply@my.na';
								$data['FROM_NAME'] = 'Hospitality Association of Namibia';
								$data['ID'] = $data['ADMIN_ID'].'-'.$count; 
								$data['SUBJECT'] = $subject;
								$data['BODY'] = $body1;
								$data['TO'] = $toemail;
								$data['NAME'] = $toname;
								//echo $row['fname'] .' '.$row['sname'].'<br />'; 
							    
								$this->db->insert('email_queue',$data);	
										
								  //BUILD MANDRILL ARRAY  
								 $mandrill = array(array('email' => $toemail )); 
								 //SEND MANDRILL	
								  
							    //$this->send_newsletter_do($body1, $body, $subject, $mandrill);
								$count ++;    
							 }
							
						}else{
							
							$str = "<div class='alert'>
									<button type='button' class='close' data-dismiss='alert'>×</button>Please select some recipients</div>";		
							echo $str.'<script type="text/javascript">$("#send_email_yes").html("Send");</script>';
							return;
							
						}

						
							
						$str = "<div class='alert alert-success'>
								<button type='button' class='close' data-dismiss='alert'>×</button>Succesfully added " . $count . " Emails to the email queue!</div>";		
						echo $str.'<script type="text/javascript">
						$("#send_email_yes").html("Emails Sent");</script>';
								
				
				
			}else{//ALL CLIENTS
				//ADD ALLL CLIENTS TO THE EMAIL QUEUE
				if($type == 'business'){
				
					$query = $this->db->get('u_business');
				
				}elseif($type == 'ntb'){
					
					$query = $this->db->where('IS_NTB_MEMBER', 'Y');
					$query = $this->db->get('u_business');

				}elseif($type == 'han'){
					
					$query = $this->db->where('IS_HAN_MEMBER', 'Y');
					$query = $this->db->get('u_business');
				
				}else{
				
					$query = $this->db->get('u_client');
				}
				
				foreach($query->result() as $row){
					
						if($type == 'business' || $type == 'ntb' || $type == 'han'){
							
							$toname = $row->BUSINESS_NAME;
							$toemail = $row->BUSINESS_EMAIL;
						}else{
							
							$toname = $row->CLIENT_NAME;
							$toemail = $row->CLIENT_EMAIL;
						}
						$data2['body'] = $body;
					    $body1 = $this->load->view('email/body_news_han',$data2,true); 
						$data['ADMIN_ID'] = $this->session->userdata('admin_id');
						$data['TO'] = $toemail;
						$data['FROM'] = 'no-reply@my.na';
						$data['FROM_NAME'] = 'Hospitality Association of Namibia';
						$data['ID'] = $data['ADMIN_ID'].'-'.$count;
						$data['SUBJECT'] = $subject;
						$data['BODY'] = $body1;
						$data['NAME'] = $toname;
					   
						$this->db->insert('email_queue',$data);	
						$count ++;
						
						//BUILD MANDRILL ARRAY  
						$mandrill = array(array('email' => $toemail )); 
						//SEND MANDRILL
					     
					    //$this->send_newsletter_do($body1, $body, $subject, $mandrill);
						//echo $toname;
				}
				
			 
		  
			  $str = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Succesfully added " . $count . " Emails to the email queue!</div>";		
			  echo $str.'<script type="text/javascript">
			  $("#send_email_yes").html("Emails Sent");
			  </script>';

				
			}//END IF ALL CLIENTS
		
				
		
		//NOT LOGGED IN
		//}else{
			
				//redirect('/my_admin/logout/', 'refresh');	
			  
		// }
		
	}
	

    //+++++++++++++++++++++++++++
	//UPLOAD GALLERY IMAGES     
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		$this->output->set_header("Access-Control-Allow-Origin: http://www.namibiatourism.com.na");
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
			 $bus_id = $this->input->post('bus_id_gal', TRUE);
			 $id = $this->input->post('user_id', TRUE);
			 //var_dump($_FILES['files']);
			 if(isset($_FILES['files']['name'])){

					
					$this->total_count_of_files = count($_FILES['files']['name']);
					/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
			 
					 for($i=0; $i<$this->total_count_of_files; $i++)
					 {
					   
					   $_FILES['userfile']['name']    = $_FILES['files']['name'][$i];
					   $_FILES['userfile']['type']    = $_FILES['files']['type'][$i];
					   $_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
					   $_FILES['userfile']['error']       = $_FILES['files']['error'][$i];
					   $_FILES['userfile']['size']    = $_FILES['files']['size'][$i];
					
					   
					   $config['upload_path'] = BASE_URL.'assets/business/gallery/';
					   $config['allowed_types'] = 'jpg|jpeg|gif|png';
					   $config['overwrite']     = FALSE;
					   $config['max_size']	= '0';
					   $config['max_width']  = '8324';
					   $config['max_height']  = '8550';
					   $config['min_width']  = '200';
					   $config['min_height']  = '200';
					   $config['remove_spaces']  = TRUE;
					   $config['encrypt_name']  = TRUE;
					   
					
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
									   
								  if (($width > 850) || ($height > 700)){
										    
										  $this->members_model->downsize_gallery_image($file);
												  
								  }
								//WATERMARK IMAGE	
								$this->members_model->watermark_gallery_image($file);	
								  
								  //populate array with values
								  $data = array(
									  'BUSINESS_ID' => $bus_id,  
									  'GALLERY_PHOTO_NAME'=> $file
								   
								  );
								 
								 //insert into database
								 $this->db->insert('u_gallery_component',$data);
								 
								 if ($this->is_han_member($bus_id)){
									 
									  //Tourism DB
									 $db2 = $this->connect_tourism_db();
									 $db2->insert('u_gallery_component',$data);
									 
								 }
	
								 
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = "<div class='item'><a class='thumbnail'><img src='".S3_URL . "assets/business/gallery/".$file."' alt=''></a><div class='actions'><div class='actions-inner'><a title='' id='4223' class='tip-top removeImageAjax' data-original-title='Remove'><i class='glyphicon glyphicon-trash icon-white'></i></a></div></div></div>";
								  
								  echo '<script type="text/javascript">
											$("#content_here_please").append("'.$image.'");
										</script>';
										
						  }else{
							//ERROR
								$val = FALSE;
								$data['error'] =  $this->upload->display_errors();
								 
							
						  }
					 }
					
					 //redirect
					 if($val == TRUE){
						  
						 $data['basicmsg'] = $i .' Photos added successfully!';
						 echo '<div class="alert alert-success">
								 <button type="button" class="close" data-dismiss="alert">×</button>
								'. $data['basicmsg'].'
								 </div>
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
							 No Files Selected - Please select some files and try again
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

	function delete_gallery_image($img_id){

		$this->output->set_header("Access-Control-Allow-Origin: http://www.namibiatourism.com.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		
		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();

			$this->db->where('ID' , $img_id);
			$query = $this->db->get('u_gallery_component');
			$row = $query->row_array();
			
			$img_file = $row['GALLERY_PHOTO_NAME'];
			$bus_id = $row['BUSINESS_ID'];
			
			if($row['GALLERY_PHOTO_NAME'] != '0'){
				
					   $file_large = BASE_URL .'assets/business/gallery/' . $img_file; # build the full path		
		
					   if (file_exists($file_large)) {
							
							if(unlink($file_large)){
													
									//delete image
												
									$this->db->where('ID' , $img_id);
									$this->db->delete('u_gallery_component');
									//Tourism DB
									$db2 = $this->connect_tourism_db();
									$db2->where('GALLERY_PHOTO_NAME' , $img_file);
									$db2->delete('u_gallery_component');
									
									echo 
									'<div class="alert alert-success">
									<button type="button" class="close" data-dismiss="alert">×</button><p>Image Deleted successfully!</p>
									 </div><script type="text/javascript">
										show_gallery();
									</script>';	
								
							
							}
						
						
						}else{
							
							//delete image
												
									$this->db->where('ID' , $img_id);
									$this->db->delete('u_gallery_component');
									//Tourism DB
									$db2 = $this->connect_tourism_db();
									$db2->where('GALLERY_PHOTO_NAME' , $img_file);
									$db2->delete('u_gallery_component');
							
							echo 
									'<div class="alert alert-error">
									<button type="button" class="close" data-dismiss="alert">×</button><p>Image Deleted successfully</p>
									 </div>
									 <script type="text/javascript">
										show_gallery();
									</script>';	
							
						}
 
						
				
			//no existing image	
			}else{
				
				echo 
						'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button><p>Image could not be deleted!</p>
						 </div><script type="text/javascript">
							show_gallery();
						</script>'; 
			}	
		
	}
	
	
	
   //+++++++++++++++++++++++++++
	//UPLOAD COVER IMAGE     
	//++++++++++++++++++++++++++
	
	function add_cover_image()
	{
		$this->output->set_header("Access-Control-Allow-Origin: http://www.namibiatourism.com.na");
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
					   $config['encrypt_name']  = TRUE;
					   
					
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
								 
								 if ($this->is_han_member($bus_id)){
									 
									  //Tourism DB
									 $db2 = $this->connect_tourism_db();
									 //insert into database
									 $db2->where('ID', $bus_id);
									 $db2->update('u_business',$data);
									 
								 }
	
								 
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = base_url('/') . "assets/business/photos/".$file;
								  
								 echo '<script type="text/javascript">
											$("#logo_img_pre").attr("src","'.$image.'");
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
	//UPLOAD COVER IMAGE     
	//++++++++++++++++++++++++++
	
	function add_logo_image()
	{
		$this->output->set_header("Access-Control-Allow-Origin: http://www.namibiatourism.com.na");
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
			 $bus_id = $this->input->post('bus_id_logo', TRUE);
			 $name = $this->input->post('bus_name_logo', TRUE);
			 $name1 = str_replace('--','-', preg_replace('/[^A-Za-z0-9\-]/', '-', $name)). rand(9,99999);
			 
			 //var_dump($_FILES['files']);
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
					   $config['min_width']  = '750';
					   $config['min_height']  = '300';
					   $config['remove_spaces']  = TRUE;
					   $config['encrypt_name']  = TRUE;
					   
					
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
											 
											$this->downsize_logo($file,$bus_id);
													
									}
								//Watermark image
								$this->members_model->watermark_logo($file);
								
								  
								  $data = array( 
									'BUSINESS_LOGO_IMAGE_NAME'=> $file
								   
								  );
								  //insert into database
								  $this->db->where('ID', $bus_id);
								  $this->db->update('u_business',$data);
								 
								 if ($this->is_han_member($bus_id)){
									 
									  //Tourism DB
									 $db2 = $this->connect_tourism_db();
									 //insert into database
									 $db2->where('ID', $bus_id);
									 $db2->update('u_business',$data);
									 
								 }
	
								 
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = base_url('/') . "assets/business/photos/".$file;
								  
								 echo '<script type="text/javascript">
											$("#logo_img_pre").attr("src", "'.$image.'");
										</script>';
										
						  }else{
							//ERROR
								$val = FALSE;
								$data['error'] =  $this->upload->display_errors();
								 
							
						  }
					 }
					
					 //redirect
					 if($val == TRUE){
						  
						 $data['basicmsg'] = $i .' Logo added successfully!';
						 echo '<div class="alert alert-success">
								 <button type="button" class="close" data-dismiss="alert">×</button>
								'. $data['basicmsg'].'
								 </div>
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

/**
++++++++++++++++++++++++++++++++++++++++++++
//PHONE NUMBER VALIDATIONS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
  //+++++++++++++++++++++++++++
	//PREPEND CELL
	//++++++++++++++++++++++++++	
	function clean_contact($nr)
	{	
		//$nr = '+264 (0) 8171717 23';
		//remove ' ' , (, ), +
		$str1 = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('+','',$nr))));
		//get 1st 3 digits
		$str2 = substr($str1,0,3);
		
		if($str2 == '264'){

			$str3 = str_replace("264","",$str1);
			
		}else{

			$str3 = $str1;
		}
		
		return $str3;
		
		
	}		
    //+++++++++++++++++++++++++++
	//VALIDATE CELL
	//++++++++++++++++++++++++++	
	function validate_cell($nr)
	{
		switch($nr)
			{
			case '081':
			  
			  $val = FALSE;
			  return $val;
			  break;
			case '085':
			 
			 $val = FALSE;
			 return $val;
			 break;
			case '060':
			  
			 $val = FALSE;
			 return $val;
			 break;
			default:
			  $val = TRUE;
			  return $val;
			  
			}	
	}
/**
++++++++++++++++++++++++++++++++++++++++++++
//VALIDATE EMAIL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function CheckAndValidateEmail($mail){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        // ok
        //list($user,$domaine)=split("@",$mail,2);
        //if(!checkdnsrr($domaine,"MX")&& !checkdnsrr($domaine,"A")){
            return FALSE;
        //}
       // else {
           // return FALSE;
        //}
    }
    else {
        return TRUE;
    }
}


/**
++++++++++++++++++++++++++++++++++++++++++++
//CLEAN URLS 4 MESSAGING
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function clean_url($str)
	{
		$str2 = str_replace(' ','-',str_replace("'","_",$str));
		return $str2;
	}
	
function un_clean_url($str)
	{
		$str2 = str_replace('-',' ',str_replace("_","'",$str));
		return $str2;
	}			



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */