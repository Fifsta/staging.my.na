<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_admin extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function my_admin()
	{
		parent::__construct();
		$this->load->model('admin_model');
		//$this->load->library('encrypt');
		//$this->load->library('PasswordHash',array(8, FALSE));
	}
	
	
	public function index()
	{
		if($this->session->userdata('admin_id')){
			 	
				$data['admin_id'] = $this->session->userdata('admin_id');
				$this->load->view('admin/home', $data);	
		
		}else{
			
				$this->load->view('admin/login');
			  
		 }
	}
	
	//+++++++++++++++++++++++++++
	//ADMIN HOME
	//++++++++++++++++++++++++++
	public function home()
	{
		
		if($this->session->userdata('admin_id')){
			 	
				$redirect = $this->un_clean_url($this->uri->segment(3));
				
				if($redirect != ''){
					$data['redirect'] = $redirect;
				}
				
				$data['admin_id'] = $this->session->userdata('admin_id');
				$this->load->view('admin/home', $data);	
		
		}else{
			
				redirect('/my_admin/logout/Please-log-in', 'refresh');	
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//MEMBER DETAILS
	//++++++++++++++++++++++++++
	public function member($id)
	{
		
		if($this->session->userdata('admin_id')){
			 	
				$data['admin_id'] = $this->session->userdata('admin_id');
				$data['id'] = $id;
				$this->load->view('admin/members_details', $data);	
		
		}else{
			
				redirect('/my_admin/logout/Please-log-in', 'refresh');	
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER ACCOUNT
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
			$email = $this->input->post('email', TRUE);
			$fname = $this->input->post('fname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$cell = $this->input->post('cell', TRUE);
			$pass1 = $this->input->post('pass1', TRUE);
			$pass2 = $this->input->post('pass2', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('dob', TRUE);
			$id = $this->input->post('id', TRUE);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';	

			}elseif($this->validate_cell($cellNum)){
				$val = FALSE;
				$error = 'Your cell number is not valid. A 081/085/060 number is required!';	
				
			}elseif(($fname == '') && ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			
			}elseif(($pass1 != $pass2)){
				$val = FALSE;
				$error = 'Your password is not matching';
							
			}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
				$val = FALSE;
				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';	
			
			}else{
				$val = TRUE;
			}
			
		
			
			//CHECK IF NEW PASSWORD
			if(($pass1 == $pass2) && ($pass1 != '')){
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'CLIENT_NAME'=> $fname ,
								  'CLIENT_SURNAME'=> $sname ,
								   'CLIENT_EMAIL'=> $email,
								   'CLIENT_CELLPHONE'=> $cell, 
								  'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
								  'CLIENT_GENDER'=> $gender,
								  'CLIENT_DATE_OF_BIRTH'=> $dob,
								  'CLIENT_COUNTRY' => $country,
								  'CLIENT_CITY' => $city,
								  'CLIENT_SUBURB' => $suburb,
								  'CLIENT_UA' => $agent,
								  'CLIENT_IP' => $IP,
								  'IS_ACTIVE' => 'N'
					);
			
			}else{
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'CLIENT_NAME'=> $fname ,
								  'CLIENT_SURNAME'=> $sname ,
								   'CLIENT_EMAIL'=> $email,
								   'CLIENT_CELLPHONE'=> $cell, 
								  'CLIENT_GENDER'=> $gender,
								  'CLIENT_DATE_OF_BIRTH'=> $dob,
								  'CLIENT_COUNTRY' => $country,
								  'CLIENT_CITY' => $city,
								  'CLIENT_SUBURB' => $suburb,
								  'CLIENT_UA' => $agent,
								  'CLIENT_IP' => $IP,
								  'IS_ACTIVE' => 'N'
					);
		
			}
			
			if($val == TRUE){
				
					$this->db->where('ID' , $id);
					$this->db->update('u_client', $insertdata);
					//success redirect	
					$this->session->set_flashdata('msg', 'Your account has been updated successfully<script type="text/javascript">load_ajax("general");</script>');
					echo '<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong> Member account has been updated successfully
						  </div>';
			}else{
					echo '<div class="alert alert-error">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong>'.$error.'
						  </div>';
				
			}
	}
	
	//DELETE MEMBER
	function delete_member($id){
      	
		if($this->session->userdata('admin_id')){
			
			$this->db->where('ID', $id);
			$this->db->delete('u_client');
			
			//INSERT INTO LOG TABLE
			$logdata = array(
						  'USER_ID' => $this->session->userdata('admin_id'),
						  'USER_NAME' => $this->session->userdata('u_name') ,
						   'TYPE' => 'delete_member-'.$id
			);
			$this->db->insert('a_sysuser_log', $logdata);
					
			echo '<div class="alert alert-success">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <strong>Notice!</strong> Member has been removed from the system
						  </div>';
				
		
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//LOAD USERS FOR THE BUSINESS
	//++++++++++++++++++++++++++
	public function business_users($bus_id)
	{
			 	
		$data['bus_id'] = $bus_id;
		$this->load->model('members_model');
		$this->members_model->get_business_users($bus_id);	
	}
	//+++++++++++++++++++++++++++
	//SYSTEM USERS
	//++++++++++++++++++++++++++		
	//VIEW	
	function sys_users(){
		
		if($this->session->userdata('admin_id')){
			 	
				$data['admin_id'] = $this->session->userdata('admin_id');
				$this->load->view('admin/sys_users', $data);	

		
		}else{
			
				$this->logout();
			  
		 }
		
	}
	//GET USER
	function get_sys_user($id){

		$this->db->where('ID', $id);
		$query = $this->db->get('a_sysuser');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="user-update" name="user-update" method="post" action="'.site_url('/').'my_admin/update_sys_user_do" class="form-horizontal">
    						<input type="hidden" id="user_id" name="user_id" value="'.$row['ID'].'">  
							<div class="control-group">
								  <label class="control-label" for="uname">User Name</label>
								<div class="controls">
								   <input type="text" id="uname" name="uname" placeholder="User Name" value="'.$row['FULL_NAME'].'">                    
								</div>
							 </div>
							  <div class="control-group">
								  <label class="control-label" for="uposition">User Position</label>
								<div class="controls">
									<select name="uposition" id="uposition">
									  <option value="Super Admin">Super Admin</option>
									  <option value="Tester">Tester - Student</option>
									 
									</select>                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uemail">User Email</label>
								<div class="controls">
								   <input type="text" id="uemail" name="uemail" placeholder="User Email" value="'.$row['EMAIL_ADDRESS'].'">                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uuserpass">User Password</label>
								<div class="controls">
								   <input type="password" id="uuserpass" name="uuserpass" placeholder="User Password" value="">                    
								</div>
							 </div>  
							   
								
						</form>';
					

			}else{
					
				$this->session->set_flashdata('error', 'User not found');	
			}
	}
	
	
	//ADD	
	function add_sys_user_do(){
			
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$position = $this->input->post('position', TRUE);
			$pass = $this->input->post('userpass', TRUE);
			//TEST IF EXISTING
			$this->db->where('EMAIL_ADDRESS', $email);
			$query = $this->db->get('a_sysuser');
			//EMAIL EXISTS
			if($query->result()){
				
				$this->session->set_flashdata('error', 'Email addres already in use');		

			}else{
					
				$insertdata = array(
								  'FULL_NAME'=> $name ,
								  'EMAIL_ADDRESS'=> $email ,
								  'POSITION_NAME'=> $position,
								  'CREATEDBY'=> $this->session->userdata('u_name'),
								  'CREATED'=> date('Y-m-d h:i:s'), 
								  'PASSWORD_CRYPT'=> $this->admin_model->hash_password($email,$pass),
								  'IS_ACTIVE'=> 'Y'
					);
					$this->db->insert('a_sysuser',$insertdata);
					$this->session->set_flashdata('msg', 'Successfully added system user');	
			}
			


	}
	//UPDATE	
	function update_sys_user_do(){
			
			$email = $this->input->post('uemail', TRUE);
			$name = $this->input->post('uname', TRUE);
			$position = $this->input->post('uposition', TRUE);
			$pass = $this->input->post('uuserpass', TRUE);
			$id = $this->input->post('user_id', TRUE);
			
			if($pass == ''){
				
				$insertdata = array(
								  'FULL_NAME'=> $name ,
								  'EMAIL_ADDRESS'=> $email ,
								  'POSITION_NAME'=> $position,
								  'CREATEDBY'=> $this->session->userdata('u_name'), 
								  'IS_ACTIVE'=> 'Y'
					);
				
				
				
			}else{
				
				$insertdata = array(
								  'FULL_NAME'=> $name ,
								  'EMAIL_ADDRESS'=> $email ,
								  'POSITION_NAME'=> $position,
								  'CREATEDBY'=> $this->session->userdata('u_name'), 
								  'PASSWORD_CRYPT'=> $this->admin_model->hash_password($email,$pass),
								  'IS_ACTIVE'=> 'Y'
					);
				
				
			}
			
			  $this->db->where('ID', $id);
			  $this->db->update('a_sysuser',$insertdata);
			  $this->session->set_flashdata('msg', 'Successfully updated system user');	
			


	}
	
	//+++++++++++++++++++++++++++
	//BUSINESS SECTION
	//++++++++++++++++++++++++++		
	//ADD BUSINESSES	
	function add_business(){

		$data['admin_id'] = $this->session->userdata('admin_id');
		$this->load->view('admin/add_business', $data);	

	}
	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS
	//++++++++++++++++++++++++++	
	function add_business_do()
	{
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$web = $this->input->post('url', TRUE);
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description = $this->input->post('content', TRUE);
			$id = $this->input->post('admin_id', TRUE);
			
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
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
				
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
		//	}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
			
			//}elseif(isset($web) && (!filter_var(prep_url($web), FILTER_VALIDATE_URL))){
//						
//				$val = FALSE;
//				$error = 'Please provide us with a valid website address or URL';
						
			}elseif(str_word_count($description) < 10){
				$val = FALSE;
				$error = 'Please provide a minimum of 10 words for your business description. Currently: '.str_word_count($description).' words.';	
				
			}else{
				$val = TRUE;
			}
				
			
			//Test if Email Exists
			$test = $this->db->where('BUSINESS_EMAIL', $email);
			$test = $this->db->get('u_business');
			if($test->num_rows() > 0){
				
				$val = FALSE;
				$error = 'The email address '.$email .' is already in use. Please use a unique email.';
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
				
					//insert
					$this->db->insert('u_business', $insertdata);
					//Get Business ID
					$test = $this->db->where('BUSINESS_EMAIL', $email);
					$test = $this->db->get('u_business');
					$test2 = $test->row_array();		
					
					//INSERT INTO LOG TABLE
					$logdata = array(
								  'USER_ID'=> $this->session->userdata('admin_id'),
								  'USER_NAME'=> $this->session->userdata('u_name') ,
								   'TYPE'=> 'add-business-'.$test2['ID']
					);
					$this->db->insert('a_sysuser_log', $logdata);
					
					
					//success redirect	
					$data['bus_id'] = $test2['ID'];
					$data['id'] = $this->session->userdata('id');
					//insert into intersection table
					//$this->admin_model->add_business_member($data['bus_id'],$data['id']);
					 
					$data['basicmsg'] = $name . ' has been registered successfully';
					redirect('/my_admin/business_details/'.$test2['ID'].'/'.$this->clean_url($data['basicmsg']), 'refresh');
			}else{
					$data['admin_id'] = $this->session->userdata('admin_id');
					$data['BUSINESS_NAME'] = $name;
					$data['BUSINESS_TELEPHONE'] = $tel2;
					$data['BUSINESS_EMAIL'] = $email;
					$data['BUSINESS_FAX'] = $fax2;
					$data['BUSINESS_DESCRIPTION'] = $description;
					$data['BUSINESS_POSTAL_BOX'] = $pobox;
					$data['BUSINESS_URL'] = $web;
					$data['BUSINESS_PHYSICAL_ADDRESS'] = $address;
					$data['BUSINESS_CELLPHONE'] = $cell;
					$data['error'] = $error;
					$this->load->view('admin/add_business',$data);
				
			}
	}
	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS
	//++++++++++++++++++++++++++	
	function add_business_do_ajax()
	{
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$web = $this->input->post('url', TRUE);
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description = $this->input->post('content', TRUE);
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
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
				
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
			
			//}elseif(isset($web) && (!filter_var(prep_url($web), FILTER_VALIDATE_URL))){
//						
//				$val = FALSE;
//				$error = 'Please provide us with a valid website address or URL';
						
			}elseif(str_word_count($description) < 10){
				$val = FALSE;
				$error = 'Please provide a minimum of 10 words for your business description. Currently: '.str_word_count(strip_tags($description)).' words.';	
				
			}else{
				$val = TRUE;
			}
				
			
			//Test if Email Exists
			$test = $this->db->where('BUSINESS_EMAIL', $email);
			$test = $this->db->get('u_business');
			if($test->num_rows() > 0){
				
				$val = FALSE;
				$error = 'The email address '.$email .' is already in use. Please use a unique email.';
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
				
					//insert
					$this->db->insert('u_business', $insertdata);
					//Get Business ID
					$test = $this->db->where('BUSINESS_EMAIL', $email);
					$test = $this->db->get('u_business');
					$test2 = $test->row_array();		
					
					//INSERT INTO LOG TABLE
					$logdata = array(
								  'USER_ID'=> $this->session->userdata('admin_id'),
								  'USER_NAME'=> $this->session->userdata('u_name') ,
								   'TYPE'=> 'add-business-'.$test2['ID']
					);
					$this->db->insert('a_sysuser_log', $logdata);
					
					//success redirect	
					$data['bus_id'] = $test2['ID'];
					$data['id'] = $this->session->userdata('id');
					
					//$this->members_model->add_business_member($data['bus_id'],$data['id']);
					
					$data['basicmsg'] = 'Thank you ' . $name .' has been successfully registered';
					
					$this->session->set_flashdata('msg', $data['basicmsg']);
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					redirectbusiness('.$test2['ID'].',"'.$this->clean_url($data['basicmsg']).'");
					</script>
					';
					$this->output->set_header("HTTP/1.0 200 OK");
			}else{
					$data['id'] = $this->session->userdata('id');
					
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	//+++++++++++++++++++++++++++
	//BUSINESS DETAILS EDIT
	//++++++++++++++++++++++++++
	public function business_details($bus_id)
	{
		
		if($this->session->userdata('admin_id')){
			 	
				$data['bus_id'] = $bus_id;
				$this->load->view('admin/business_details', $data);	
		
		}else{
			
				$this->logout();
			  
		 }
	
	}
	 //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++	
	function business_update_do_ajax()
	{
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description = $this->input->post('content', TRUE);
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
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
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
					//success redirect	
					$data['bus_id'] = $bus_id;
					$data['id'] = $this->session->userdata('id');
					$data['basicmsg'] = $name . ' has been updated successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	
	 //+++++++++++++++++++++++++++
	//UPLOAD MAP COORDINATES
	//++++++++++++++++++++++++++
	
	public function update_map_coordinates($bus_id)
	{
		
		if($this->session->userdata('admin_id')){
			 	
				$this->admin_model->update_map_coordinates();
				$data['basicmsg'] = 'Co-ordinates updated successfully';
				$this->session->set_flashdata('msg', $data['basicmsg']);
				$data['bus_id'] = $bus_id;
				$data['admin_id'] = $this->session->userdata('admin_id');
				redirect('/my_admin/business_details/'.$bus_id.'/');
		
		}else{
				
				$data['error'] = 'Sorry, you have been logged out of My.Na';
				$this->load->view('login' , $data);
			  
		 }
		
		
	}
	
	
	//+++++++++++++++++++++++++++
	//CONTENT PAGES
	//++++++++++++++++++++++++++
	public function page($page_id)
	{
		
		if($this->session->userdata('admin_id')){
			 	
				$data['page_id'] = $page_id;
				$data['content'] = 'page_detail';
				$this->load->view('admin/page', $data);	
		
		}else{
			
				$this->logout();
			  
		 }
	
	}
	//+++++++++++++++++++++++++++
	//ADD PAGE
	//++++++++++++++++++++++++++
	public function add_page()
	{
		
		if($this->session->userdata('admin_id')){
			 	
				$data['content'] = 'page_add';
				$this->load->view('admin/page', $data);	
		
		}else{
			
				$this->logout();
			  
		 }
	
	}
	 //+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = $this->input->post('content', TRUE);
			//$fax = $this->input->post('fax', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($body == ''){
				$val = FALSE;
				$error = 'Page Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'heading'=> $title ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('pages', $insertdata);
					//success redirect	
		
					$data['basicmsg'] = 'Page has been updated successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'my_admin/home/pages/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	 //+++++++++++++++++++++++++++
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = $this->input->post('content', TRUE);
			//$fax = $this->input->post('fax', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('page_id', TRUE);

			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($body == ''){
				$val = FALSE;
				$error = 'Page Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('page_id' , $id);
					$this->db->update('pages', $insertdata);
					//success redirect	
					$data['page_id'] = $id;
					$data['id'] = $this->session->userdata('id');
					$data['basicmsg'] = 'Page has been updated successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}
	

//DELETE CATEGROY
	function delete_page($page_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('page_id', $page_id);
			  $this->db->delete('pages');
			 
			  echo '<div class="alert alert-success">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Page Deleted!</strong> The page was deleted successfully.
				  </div>
				  <script type="text/javascript">
				   window.location = "'.site_url('/').'my_admin/home/pages/";
				  </script>';
						
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }

/**
++++++++++++++++++++++++++++++++++++++++++++
//BACKBONE AJAX CALLS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	//GET USERS	
	function users(){

		$this->admin_model->get_users();
	

	}	
	//GET BUSINESSES	
	function businesses(){

		$query = $this->admin_model->get_businesses();
		

	}		
	
	//GET MAIN VATEGORIES	
	function categories(){

		$query = $this->admin_model->get_main_categories();
		

	}	
		
	//GET BUSINESS DEALS	
	function deals(){

		$query = $this->admin_model->get_deals();


	}
	
	//GET REVIEWS	
	function reviews(){

		$query = $this->admin_model->get_all_reviews();
		

	}
	
	//GET PAGS	
	function pages(){

		$query = $this->admin_model->get_all_pages();
		

	}
		
	//GET SYSTEM LOG	
	function system_log(){

		$query = $this->admin_model->get_system_log();
		

	}
	//GET SUB CATEGORIES	
	function categories_sub($cat_id){

		$query = $this->admin_model->get_categories_sub($cat_id);
		

	}
	
	//ADD MAIN CATEGORY
	function add_category_main(){
		
		if($this->session->userdata('admin_id')){
			
			if($this->input->post('main_cat_name')){
				
				$name = $this->input->post('main_cat_name', TRUE);
				$data['CATEGORY_NAME'] = $name;
				$this->db->insert('a_tourism_category', $data);
				
				echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>'.$name.'</strong> category added successfully.
					</div>';
				
			}else{
				
				echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning!</strong> Unknown Error.
					</div>';
				
			}
		
			
			
		}else{
			
			$this->logout();
			
		}
			
		

	}
	
	//ADD SUB CATEGORY
	function add_category_sub(){
		
		if($this->session->userdata('admin_id')){
			
			if($this->input->post('cat_name')){
				
				$cat_id = $this->input->post('main_cat_id', TRUE);
				$name = $this->input->post('cat_name', TRUE);
				$data['CATEGORY_NAME'] = $name;
				$data['CATEGORY_TYPE_ID'] = $cat_id;
				$this->db->insert('a_tourism_category_sub', $data);
				
				echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>'.$name.'</strong> - sub category added successfully.
					</div>';
				
			}else{
				
				echo '<div class="alert alert-error">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <strong>Warning!</strong> Unknown Error.
					</div>';
				
			}
		
			
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
			
		}
			
		

	}
	
	//DELETE CATEGROY
	function delete_category($cat_id, $str){
      	
		if($this->session->userdata('admin_id')){
			
			$x = 0;		
			if($str == 'main'){
				
				$this->db->where('CATEGORY_TYPE_ID', $cat_id);
				$query = $this->db->get('a_tourism_category_sub', $cat_id);
				
				if($query->result()){
					
					foreach($query->result() as $row){
						
						$this->db->where('ID', $row->ID);
						$this->db->delete('a_tourism_category_sub');
						$x ++;
					}
					
				}
				
					$x = 1;
					//delete from database
					$test = $this->db->where('ID', $cat_id);
					$this->db->delete('a_tourism_category');
					$str = "'categories'";
					echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Category Deleted!</strong> The category was deleted successfully.
						</div>
						<script type="text/javascript">
						load_ajax('.$str.');;
						</script>';
						
			}else{
				$x = 1;
				$str = "'".$this->admin_model->get_main_category_id($cat_id)."'";
				//delete from database
				$test = $this->db->where('ID', $cat_id);
				$this->db->delete('a_tourism_category_sub');
				
				echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Sub Category Deleted!</strong> The category was deleted successfully.
						</div>
						<script type="text/javascript">
						load_ajax_cat_sub('.$str.');
						</script>';
			}
		
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }


    //UPDATE MAIN CATEGROY
	function update_category_main($cat_id){
      	
		if($this->session->userdata('admin_id')){
			
			$this->db->where('ID',$cat_id);
			$query = $this->db->get('a_tourism_category');
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="main-cat-update" name="main-cat-update" method="post" action="'.site_url('/').'my_admin/update_cat_main_do" class="form-horizontal">
    						<input type="hidden" id="main_cat_id" name="main_cat_id" value="'.$row['ID'].'">  
							<div class="control-group">
								  <label class="control-label" for="main_cat_name">Category Name</label>
								<div class="controls">
								   <input type="text" id="main_cat_name" name="main_cat_name" value="'.$row['CATEGORY_NAME'].'">                    
								</div>
							 </div>	  		
						</form>';
				
			}
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }
	
	function update_cat_main_do(){
      	
		if($this->session->userdata('admin_id')){
			
			$data['CATEGORY_NAME'] = $this->input->post('main_cat_name',TRUE);
			$id = $this->input->post('main_cat_id',TRUE);
			
			$this->db->where('ID', $id);
			$this->db->update('a_tourism_category', $data);
			
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }
	
	 //UPDATE MAIN CATEGROY
	function update_category_sub($cat_id){
      	
		if($this->session->userdata('admin_id')){
			
			$this->db->where('ID',$cat_id);
			$query = $this->db->get('a_tourism_category_sub');
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="sub-cat-update" name="sub-cat-update" method="post" action="'.site_url('/').'my_admin/update_cat_sub_do" class="form-horizontal">
    						<input type="hidden" id="sub_cat_id" name="sub_cat_id" value="'.$row['ID'].'">  
							<div class="control-group">
								  <label class="control-label" for="main_cat_name">Category Name</label>
								<div class="controls">
								   <input type="text" id="sub_cat_name" name="sub_cat_name" value="'.$row['CATEGORY_NAME'].'">                    
								</div>
							 </div>	  		
						</form>';
				
			}
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }
	
	function update_cat_sub_do(){
      	
		if($this->session->userdata('admin_id')){
			
			$data['CATEGORY_NAME'] = $this->input->post('sub_cat_name',TRUE);
			$id = $this->input->post('sub_cat_id',TRUE);
			
			$this->db->where('ID', $id);
			$this->db->update('a_tourism_category_sub', $data);
			
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
    }
/**
++++++++++++++++++++++++++++++++++++++++++++
//REVIEWS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	//UPDATE REVIEW STATUS
	function update_review($id, $str){
      	
		if($this->session->userdata('admin_id')){
			
			if($str == 'yes'){
				
				$v = 'Y';
				
			}else{
				
				$v = 'N';
				
			}
				$data['IS_ACTIVE'] = $v;
				$this->db->where('ID', $id);
				$query = $this->db->update('u_business_vote', $data);
				
				echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Review Updated!</strong> The review has been updated successfully.
						</div>';
		
		}else{
			
			redirect('/my_admin/logout/','refresh');
				
		}
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
		if($this->session->userdata('admin_id')){
			
			$this->load->model('email_model');
			$data['admin_id'] = $this->session->userdata('admin_id');
			$this->load->view('admin/build_mail', $data);	
			
			
		}else{
			
			redirect('/my_admin/logout/','refresh');
			
		}
		
		
	}		

    //+++++++++++++++++++++++++++
	//PREVIEW NEWSLETTER
	//++++++++++++++++++++++++++	
	function preview_news()
	{	
		$data['preview'] = 'true';
		$data['body'] = $this->input->post('mailbody',TRUE);
		//$data['body'] = urldecode($body);
		
		$this->load->view('email/body_news', $data);	

		
	}		


	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_email()
	{
		 if($this->session->userdata('admin_id')){
			//GET EMAIL FILDS 	
			$recipients = $this->input->post('recipients',TRUE);
			$subject = $this->input->post('title',TRUE);
			$body = $this->input->post('content',FALSE);	
			$count = 0;
			
			//CHECK IF ALL CLIENTS SELECTED
			if(empty($_POST['selectall'])){
						//ONLY SELECTED
						if(!empty($_POST['recipients'])) {
							$num = count($_POST['recipients']);
							 foreach($_POST['recipients'] as $value) {
								
								$row = $this->admin_model->get_client_row($value);
								$data['ADMIN_ID'] = $this->session->userdata('admin_id');
								$data['TO'] = $row['CLIENT_EMAIL'];
								$data['FROM'] = 'no-reply@my.na';
								$data['ID'] = $data['ADMIN_ID'].'-'.$count; 
								$data['SUBJECT'] = $subject;
								$data['BODY'] = $body;
								$data['NAME'] = $row['CLIENT_NAME'];
								//echo $row['fname'] .' '.$row['sname'].'<br />'; 
							   
								$this->db->insert('email_queue',$data);			
								//$array_mail[$count][$row->email];
								//echo $row['CLIENT_EMAIL'].'<br/>'; 
								$count ++;    
							 }
							
						}else{
							
							$str = "<div class='alert'>
									<button type='button' class='close' data-dismiss='alert'>×</button>Please select some recipients</div>";		
							echo $str.'<script type="text/javascript">$("#send_email_yes").html("Send");</script>';
							return;
							
						}
						//echo 'Only selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count .' = ' .$num; 
		
						//TEST IF LESS THAN 100 IF LESS, SEND EMAILS DIRECTLY
						if($num < 21){
							unset($_POST); unset($_REQUEST);
							//SEND EMAILS
							$this->send_newsletter_do('0',$count);
							
						}else{
						
							$str = "<div class='alert alert-success'>
									<button type='button' class='close' data-dismiss='alert'>×</button>Succesfully added " . $count . " Emails to the email queue!</div>";		
							echo $str.'<script type="text/javascript">
							$("#send_email_yes").html("Emails Sent");</script>';
							
						}			
				
				
			}else{//ALL CLIENTS
				//ADD ALLL CLIENTS TO THE EMAIL QUEUE
				
				$query = $this->db->get('u_client');
				foreach($query->result() as $row){
					
						$data['ADMIN_ID'] = $this->session->userdata('admin_id');
						$data['TO'] = $row->CLIENT_EMAIL;
						$data['FROM'] = 'no-reply@my.na';
						$data['ID'] = $data['ADMIN_ID'].'-'.$count;
						$data['SUBJECT'] = $subject;
						$data['BODY'] = $body;
						$data['NAME'] = $row->CLIENT_NAME;
					   
						$this->db->insert('email_queue',$data);	
						$count ++;  
					
				}
				//echo 'All selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count.' = ' .$num;
				
				    $str = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Succesfully added " . $count . " Emails to the email queue!</div>";		
		 		    echo $str.'<script type="text/javascript">
					$("#send_email_yes").html("Emails Sent");
					</script>';

				
			}//END IF ALL CLIENTS
		
				
		
		//NOT LOGGED IN
		}else{
			
				redirect('/my_admin/logout/', 'refresh');	
			  
		 }
		
	}
	
	function send_newsletter_do($count, $limit){

				 
			$id = $this->session->userdata('admin_id').'-'.$count;
			$this->db->where('ID', $id);
			$query = $this->db->get('email_queue');
				  
		
		if($query->num_rows() == 0){

			//$data['pro_id'] = $this->session->userdata('pro_id');
			$data['count'] = $count;
			//$data['mails'] = $mails;
			//$data['email'] = $email;
			//$data['count'] = $count;
			$data1['string'] = 'Succesfully sent ' . $count . ' Emails!';
			$data1['progress'] = '100';
			echo "<div class='alert'>
				  <button type='button' class='close' data-dismiss='alert'>×</button>".$data1['string']."</div>";
			echo '<script type="text/javascript">$("#send_email_yes").html("Emails Sent");$(".bar").css({width: "100%"});
			
			</script>';
 			
		   
		}else{
			
	  
			  $row = $query->row_array();			
			  $mail = $row['TO'];
			  $data['name'] = $row['NAME'];
			 
			 //echo $data['name'];
			  $data1['progress'] = ($count / $limit) * 100;
			  $data1['string'] = $row['NAME'] . ' - ' .$row['TO'] ;
			  //SEND HTML
			  
			  	echo '<script type="text/javascript">$(".bar").animate({width: "'.$data1['progress'].'%"});
				$("#result_cover").html("<p>'.$data1['string'].'</p>");
				</script>
				';
			    
			  			  
				  $this->load->library('email');
				  $config['mailtype'] = 'html';
				  $config['protocol']='smtp';  
				  $config['smtp_host']='smtp.mandrillapp.com';  
				  $config['smtp_port']='587';  
				  $config['smtp_timeout']='30';  
				  $config['smtp_user']='roland@my.na';  
				  $config['smtp_pass']='d3tAlotpZNobGiCfRk3Miw';
				  $this->email->initialize($config);
				  //$data['link'] = $link;
				  $data['body'] = $row['BODY'];
				  $this->email->from( $row['FROM'],'My Namibia');
				  $this->email->to($row['TO']); 
					
				  $body1 = $this->load->view('email/body_news',$data,true);
		  
				  $this->email->subject($row['SUBJECT']);
				  $this->email->message($body1);

		  		  //$this->email->send();
		  
				  $this->db->where('MAIL_ID', $row['MAIL_ID']);
				  $this->db->delete('email_queue'); 
				  $count = $count + 1;
		  //sleep(2);
		  //redirect('/my_admin/send_newsletter_do/' . $count . '/' . $limit, 'refresh',301);
		  $this->send_newsletter_do($count,$limit);
		}
	
}
	

	
	
	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL AJAX
	//++++++++++++++++++++++++++++++++++++++++++++		

	function send_email_ajax()
	{
		 if($this->session->userdata('admin_id')){
			//GET EMAIL FILDS 	
			$recipients = $this->input->post('recipients',TRUE);
			$subject = $this->input->post('title',TRUE);
			$body = $this->input->post('content',FALSE);	
			$count = 0;
			$num = count($_POST['recipients']);
			//CHECK IF ALL CLIENTS SELECTED
			if(empty($_POST['selectall'])){
				//ONLY SELECTED
				if(!empty($_POST['recipients'])) {
					 foreach($_POST['recipients'] as $value) {
						
						$row = $this->admin_model->get_client_row($value);
						$data['ADMIN_ID'] = $this->session->userdata('admin_id');
						$data['TO'] = $row['CLIENT_EMAIL'];
						$data['FROM'] = 'no-reply@my.na';
						$data['ID'] = $data['ADMIN_ID']; 
						$data['SUBJECT'] = $subject;
						$data['BODY'] = $body;
						$data['NAME'] = $row['CLIENT_NAME'];
						//echo $row['fname'] .' '.$row['sname'].'<br />'; 
					   
						$this->db->insert('email_queue',$data);			
						//$array_mail[$count][$row->email];
						echo $row['CLIENT_EMAIL'].'<br/>'; 
						$count ++;    
					 }
					
				}
				//echo 'Only selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count .' = ' .$num; 

							
				//TEST IF LESS THAN 100 IF LESS, SEND EMAILS DIRECTLY
				if($num < 101){
					unset($_POST); unset($_REQUEST);
					//SEND EMAILS
					$this->send_newsletter_ajax_do('0',$count);
					
					exit;
				}else{
					
				}
				
			}else{//ALL CLIENTS
				//ADD ALLL CLIENTS TO THE EMAIL QUEUE
				
				$query = $this->db->get('u_client');
				foreach($query->result() as $row){
					
						$data['ADMIN_ID'] = $this->session->userdata('admin_id');
						$data['TO'] = $row->CLIENT_EMAIL;
						$data['FROM'] = 'no-reply@my.na';
						$data['ID'] = $data['ADMIN_ID']; 
						$data['SUBJECT'] = $subject;
						$data['BODY'] = $body;
						$data['NAME'] = $row->CLIENT_NAME;
					   
						$this->db->insert('email_queue',$data);	
						$count ++;  
					
				}
				//echo 'All selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count.' = ' .$num;
				
			}//END IF ALL CLIENTS

		//NOT LOGGED IN
		}else{
			
				redirect('/my_admin/logout/', 'refresh');	
			  
		 }
		
	}

function send_newsletter_ajax_do($count, $total){

		$id = $this->session->userdata('admin_id');
		$this->db->where('ADMIN_ID', $id);
        $query = $this->db->get('email_queue');
		
		if($query->num_rows() == 0){

			$data['admin_id'] = $id;
			$data['count'] = $count;
			//$data['mails'] = $mails;
			//$data['email'] = $email;
			//$data['count'] = $count;
			$data['basicmsg'] = 'Succesfully sent ' . $count . 'Emails!';
			
			$data1['java'] = '<script type="text/javascript">$("#save_story").html("Send");</script>';
			
			
		}else{
				$x = 0;
	  			foreach($query->result() as $row){
						 		
					  $mail = $row->TO;
					  $data['name'] = $row->NAME;
					 
					 //echo $data['name'];
					  
					  if($x == ($total -1)){
						  $progress = '100';
						  $data1['string'] = $row->NAME . ' - ' .$row->TO;
					  //SEND HTML
						 echo '<script type="text/javascript">$("#barProgress").css("width", "'.$progress.'%");$("#result_msg").html("");</script>';
						  
					  }else{
						  $progress = ($x / $total) * 100;
						 $data1['string'] = $row->NAME . ' - ' .$row->TO ;
					  //SEND HTML
						 echo '<script type="text/javascript">$("#barProgress").css("width", "'.$progress.'%");</script>';  
						  
					  }
						 
						 
								  
					  $this->load->library('email');
					  $config['mailtype'] = 'html';
					  $config['protocol']='smtp';  
					  $config['smtp_host']='smtp.mandrillapp.com';  
					  $config['smtp_port']='587';  
					  $config['smtp_timeout']='30';  
					  $config['smtp_user']='roland@my.na';  
					  $config['smtp_pass']='d3tAlotpZNobGiCfRk3Miw';
					  $this->email->initialize($config);
					  //$data['link'] = $link;
					  $data['body'] = $row->BODY;
					  $this->email->from( $row->FROM,'My Namibia');
					  $this->email->to($row->TO); 
						
					  $body1 = $this->load->view('email/body_news',$data,true);
			  
					  $this->email->subject($row->SUBJECT);
					  $this->email->message($body1);
			
					  //$this->email->send();
					  
					  
					  $this->db->where('MAIL_ID', $row->MAIL_ID);
					  $this->db->delete('email_queue'); 
					  $count = $count + 1;
					  
					  $x ++;
					  sleep(2);
				}
		 $str = "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>Succesfully sent " . $x . " Emails!</div>";		
		 echo 'Succesfully sent ' . $x . ' Emails!<script type="text/javascript">$("#modal-email").modal("hide");$("#msg").html("'.$str.'");</script>';
		 
		}
	
}

    //+++++++++++++++++++++++++++
	//UPDATE BUSINESS STATUS
	//++++++++++++++++++++++++++	
	function set_business_status($id, $status)
	{	
		
		if($this->session->userdata('admin_id')){
			 	
				$data['ISACTIVE'] = $status;
				$this->db->where('ID', $id);
				$this->db->update('u_business', $data);
				echo '<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					Business has been updated</div>';
		
		}else{
			
				$this->session->set_flashdata('error','You have been logged out');
				echo '<script type="text/javascript">
						
						window.location = "'.site_url('/').'my_admin/logout/";
				
					</script>';
			  
		 }
		
	}	
     //+++++++++++++++++++++++++++
	//UPDATE DEAL
	public function update_deal($deal_id)
	{
		$this->load->model('deal_model');
		$this->db->where('ID', $deal_id);
		$query = $this->db->get('u_special_component');
		if($query->result()){
			$row = $query->row_array();
			
			$data['bus_id'] = $row['BUSINESS_ID'];
			$data['title'] = $row['SPECIALS_HEADER'];
			$data['start'] = $row['SPECIALS_STARTING_DATE'];
			$data['end'] = $row['SPECIALS_EXPIRE_DATE'];
			$data['body'] = $row['SPECIALS_CONTENT'];
			$data['quantity'] = $row['QUANTITY'];
			$data['price'] = $row['SPECIALS_PRICE'];
			$data['price_u'] = $row['NORMAL_PRICE'];
			$data['img_file'] = $row['SPECIALS_IMAGE_NAME'];
			$data['deal_id'] = $deal_id;
			$data['cat_deal'] = $row['CATEGORY_SUB_ID'];
			$data['is_active'] = $row['IS_ACTIVE'];
			$data['deal_loc'] = $row['LOCATION'];
			$this->load->view('admin/inc/deals_inc', $data);
			
			echo '<link rel="stylesheet" href="'.base_url('/').'redactor/redactor/redactor.css" />
			<script src="'.base_url('/').'redactor/redactor/redactor.js"></script>
			<link href="'.base_url('/').'css/datepicker.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="'.base_url('/').'js/bootstrap-datepicker.js" ></script>
				  <script type="text/javascript">
					$(document).ready(function(){
						
						$("#deal_content").redactor({ 	
									
						buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
						"unorderedlist", "orderedlist", "outdent", "indent", "|",
						"video", "table","|",
						 "alignment", "|", "horizontalrule"]
						});
					
						$("#dpstart").datepicker()
						
						$("#dpend").datepicker()
					});
					
					
				  </script>';	
			
		}else{
			
			echo '<div class="alert">
					<h3>Deal not found</h3> The deal could not be found</div>';
			
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
				
/**
++++++++++++++++++++++++++++++++++++++++++++
//ENCODING ENCRYPTION 
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
	public  function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
		
    public  function encode($username, $pasword){
		return $this->hash_password($username, $password);
    }

    public function decode($value){
		return $this->encrypt->sha1($value);
    }
	
/*	
    public  function encode($value){
		$skey = $this->config->item('encryption_key'); // you can change it 
        if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey , $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext)); 
    }

    public function decode($value){
		 $skey = $this->config->item('encryption_key'); // you can change it
        if(!$value){return false;}
        $crypttext = $this->safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey , $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }*/



	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login()
	{
			
			$email = $this->input->post('email', TRUE);
			$pass = $this->input->post('pass', TRUE);
			$sess = $this->input->post('rememberme', TRUE);
			$redirect = $this->input->post('redirect', TRUE);
			
			//MATCH CREDENTIALS
			$row = $this->admin_model->validate_password($email,$pass);
			if($row['bool'] == TRUE){
					
					//HASH PASSWORD AGAIN
					$pass_new = $this->admin_model->hash_password($email,$pass);
					//create user array
					 $data = array(
					  /* 'user_agent' => $this->agent->browser() . ' ver ' . $this->agent->version(),*/
					   'LAST_LOGIN' => date("Y-m-d H:i:s"),
					   'PASSWORD_CRYPT' => $pass_new
					);
					
					if ($sess == TRUE) {
					//$this->session->cookie_monster();	
					}
					$this->session->set_userdata('admin_id', $row['ID']);
					$this->session->set_userdata('u_name', $row['FULL_NAME']);
					$this->session->set_userdata('last_login', $row['LAST_LOGIN']);
					$this->session->set_userdata('u_position', $row['POSITION_NAME']);
					$this->db->where('ID', $row['ID']);
					$this->db->update('a_sysuser', $data); 
					//--------------
					//Redirect
					if($this->input->post('redirect')){
						
						redirect($redirect, 'refresh');
						
					}else{
						
						
						redirect('/my_admin/home/', 'refresh');	
						
					}
				
				
			//NO MATCHING CREDENTIALS
			}else{
			
				$data['error'] = 'No matching records found!';
				//echo $this->encode($pass) .' ' ;
				$this->load->view('admin/login' , $data);
			
			}
				
	}


	function logout(){

		$this->session->sess_destroy();  
		redirect(site_url('/').'my_admin','refresh');

	}


	public function encrypt()
	{
		//$str = str_replace('_-_','@',$str);
		$str = 'roland@my.na';
		$pass = '123';
		echo $this->admin_model->hash_password($str,$pass);	
		
	}
	
	public function decrypt()
	{
		
		$str = 'roland@my.na';
		$pass = '123';
		
		$row = $this->admin_model->validate_password($str,$pass);
		if($this->admin_model->validate_password($str,$pass)){
			
			echo 'YES';
		
		}else{
			
			echo 'No';
			
		}
		
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
	
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_db_business() {
		$this->admin_model->clean_db_business();
	}


	function connect_intouch_db(){
		
		//connect to main database
		$config_db['hostname'] = '65.98.90.82';
		$config_db['username'] = 'ntouchim_admin';
		$config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
		$config_db['database'] = 'ntouchim_debmarine';
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
/* Location: ./application/controllers/welcome.php */?>