<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intranet extends CI_Controller {

	/**
	 * Intranet Controller for My.na.
	 *
	 * Roland Ihms
	 */
	function Intranet()
	{
		parent::__construct();
	}

	
	public function index()
	{
 		echo 'Going nowhere slowly!';
	}
	
	
    //+++++++++++++++++++++++++++
	//REGISTER MEMBER WITH AJAX
	//++++++++++++++++++++++++++
	function register_do_ajax()
	{
          	$email = $this->input->post('email', TRUE);
			$fname = $this->input->post('fname', TRUE);
			$sname = $this->input->post('lname', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$cell = $this->input->post('cphone', TRUE);
			$pass1 = $this->input->post('pass1', TRUE);
			$pass2 = $this->input->post('pass2', TRUE);
			//$country = $this->input->post('country', TRUE);
			//$city = $this->input->post('city', TRUE);
			//$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('dob', TRUE);
			//$security = $this->input->post('security', TRUE);
			
			//$x = $this->input->post('x', TRUE);
			//$y = $this->input->post('y', TRUE);
			//$dob = strtotime($new_date_format); 
			
			//GENERATE TEMPORARY PASSSWORD
			$pass1 = rand(0, 999).substr($fname, 1 , 2). rand(0, 999);
			
			//VALIDATE INPUT
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';	
				
			}elseif(($fname == '') || ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			
				
			}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
				$val = FALSE;
				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';	
							
			}else{
				$val = TRUE;
			}
				
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			//alert(cellphoneNumber.substring(0, 3));
			switch($cellNum)
			{
			case '081':
			  
			  $val = TRUE;
			  break;
			case '085':
			 
			 $val = TRUE;
			 break;
			case '060':
			  
			 $val = TRUE;
			 break;
			default:
			  $val = FALSE;
			  $error = 'Your cell number is not valid. A 081/085/060 number is required!';	
			  
			}
			
			if($val == TRUE){
				
				$this->load->model('members_model');
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
							  'CLIENT_UA' => $agent,
							  'CLIENT_IP' => $IP,
							  'IS_ACTIVE' => 'N'
				);
				
				$this->db->where('CLIENT_EMAIL' , $email);
				$this->db->from('u_client');
				$query = $this->db->get();
			
				
				//IF email already exists
				if($query->num_rows() > 0){
					
					$data['error'] = 'A member with the email address ' . $email . ' already exists!';
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
					
					
				}else{
					
					$this->db->insert('u_client', $insertdata);
					//get ID
					$this->db->where('CLIENT_EMAIL' , $email);
					$this->db->from('u_client');
					$query = $this->db->get();
					$row = $query->row_array();
					$member_id = $row['ID'];	
					
					//BUILD ARRAY 4 email		
					
					$data['fname'] = $fname;
					$data['img'] = '0';
					$data['member_id'] = $member_id;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['cell'] = $cell;
					$data['pass1'] = $pass1;
					$data['dob'] = $dob;
					$data['base'] = base_url('/');
					$data['confirm_link'] = site_url('/') . 'intranet/activate/'.$member_id;
					//SEND EMAIL LINK
					//BUILD BODY
					$body = '<h2>Hi '.$fname .',</h2>
							<h2>Welcome to My Namibia</h2> 
							<h3>Your registration has been processed.</h3>

							Once your email has been verified and NTB reviews your membership you can find and manage your business accross all online tourism platforms in Namibia 
							directly from your dashboard. You will be able to review your HAN evaluations and completely control how google and other search engines
							find your business on the internet.
							<br /><br />
							Please follow the link below:<br /><br />
							<a href="'.$data['confirm_link'].'" title="activate membership">'.$data['confirm_link'].'</a>
							<br /><br />
							Have a !tna day!<br />
							My Namibia';
							
			     	$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news',$data_view, true);
					
					$emailTO = array(array('email' => $email));
					$subject = 'Welcome to Your Intranet '.$fname;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = 'My Namibia';
					$TAG = array('tags' => 'intranet_registration' );
					
						
	
					
					$body_admin = 'A new member has registered via the Intranet portal on My Namibia. Please review and action as soon as possible.<br />	<br /><br />
							Client Name : '.$fname.' ' .$sname.'<br />
							Client Email : '.$email.'<br /><br />
		
							<br /><br />
							
							Please action this ASAP.';
					
					$data_admin['body'] = $body_admin;
					$body_admin_final_ = $this->load->view('email/body_news',$data_admin, true);
					$emailTONTB =  array(array('email' => 'roland@my.na'));
					$subject_admin = 'New Member Registration : '.$fname;
					$TAG_admin = array('tags' => 'intranet_registration' );
					
					//SEND EMAIL LINK TO USER
					$this->load->model('email_model');	
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	
					//SEND EMAIL LINK TO MY NA
					$this->email_model->send_mail($body_admin_final_, $subject_admin, $emailTONTB, $fromEMAIL, $fromNAME, $TAG_admin);	
					//success redirect		
					$data['basicmsg'] = 'Thank you, ' . $fname .' you have successfully registered.';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					redirectpreview();
					</script>
					';
					$this->output->set_header("HTTP/1.0 200 OK");
				}
			
			}else{
					
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
			
			}
	}
	
	
	
    //+++++++++++++++++++++++++++
	//REGISTER MEMBER WITH AJAX
	//++++++++++++++++++++++++++
	function register_user()
	{
          	
		$this->output->set_header("Access-Control-Allow-Origin: https://intranet.my.na");
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
		
			$email = $this->input->post('email', TRUE);
			$fname = $this->input->post('fname', TRUE);
			$sname = $this->input->post('lname', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$cell = $this->input->post('cphone', TRUE);
			$pass1 = $this->input->post('pass1', TRUE);
			$pass2 = $this->input->post('pass2', TRUE);
			$company = $this->input->post('intranet_title', TRUE);
			//$city = $this->input->post('city', TRUE);
			//$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('dob', TRUE);
			//GENERATE TEMPORARY PASSSWORD
			$pass1 = rand(0, 999).substr($fname, 1 , 2). rand(0, 999);
			
			//VALIDATE INPUT
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';	
				
			}elseif(($fname == '') || ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			
				
			}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
				$val = FALSE;
				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';	
							
			}else{
				$val = TRUE;
			}
				
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			//alert(cellphoneNumber.substring(0, 3));
			switch($cellNum)
			{
			case '081':
			  
			  $val = TRUE;
			  break;
			case '085':
			 
			 $val = TRUE;
			 break;
			case '060':
			  
			 $val = TRUE;
			 break;
			default:
			  $val = FALSE;
			  $error = 'Your cell number is not valid. A 081/085/060 number is required!';	
			  
			}
			
			if($val == TRUE){
				
				
				
				$this->load->model('members_model');
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
							  'CLIENT_UA' => $agent,
							  'CLIENT_IP' => $IP,
							  'IS_ACTIVE' => 'N'
				);
				
				$this->db->where('CLIENT_EMAIL' , $email);
				$this->db->from('u_client');
				$query = $this->db->get();
			
				
				//IF email already exists
				if($query->num_rows() > 0){
					
					$existing = $query->row();
					//BUILD ARRAY 4 email		
					
					$data['fname'] = $fname;
					$data['img'] = '0';
					$data['member_id'] = $member_id;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['cell'] = $cell;
					$data['pass1'] = $pass1;
					$data['dob'] = $dob;
					$data['base'] = base_url('/');
					$data['confirm_link'] = site_url('/') . 'intranet/activate/'.$existing->ID;
					//SEND EMAIL LINK
					//BUILD BODY
					$body = '<h2>Hi '.$fname .',</h2>
							<h2>Welcome to the '.$company.' Intranet</h2> 
							<h3>Your registration has been processed.</h3>
							To verify your email address and give you access to the intranet please follow the link below.
							Once confirmed you will be granted access.
							<br /><br />
							Your username is: '.$email.'<br />
							Your temporary password is: <em>your current my.na password</em>
							<br /><br />
							Please follow the link below:<br /><br />
							<a href="'.$data['confirm_link'].'" title="activate membership">'.$data['confirm_link'].'</a>
							<br /><br />
							Have a great day!<br />
							'.$company;
							
			     	$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news',$data_view, true);
					
					$emailTO = array(array('email' => $email));
					$subject = 'Welcome to the '.$company.' Intranet '.$fname;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = $company;
					$TAG = array('tags' => 'intranet_registration' );
					
					$body_admin = 'A new member has registered via the Intranet portal on My Namibia. Please review and action as soon as possible.<br />	<br /><br />
							Client Name : '.$fname.' ' .$sname.'<br />
							Client Email : '.$email.'<br /><br />
		
							<br /><br />
							
							Please action this ASAP.';
					
					$data_admin['body'] = $body_admin;
					$body_admin_final_ = $this->load->view('email/body_news',$data_admin, true);
					$emailTONTB =  array(array('email' => 'roland@my.na'));
					$subject_admin = 'New Member Registration : '.$fname;
					$TAG_admin = array('tags' => 'intranet_registration' );
					
					//SEND EMAIL LINK TO USER
					$this->load->model('email_model');	
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	
					//SEND EMAIL LINK TO MY NA
					$this->email_model->send_mail($body_admin_final_, $subject_admin, $emailTONTB, $fromEMAIL, $fromNAME, $TAG_admin);	
					
					
									
					//UPLOAD AVATAR
					$file = $this->add_avatar($existing->ID);
					
					
					echo 'TRUEAdding User!
					<script type="text/javascript">
					
						add_local_user('.$existing->ID.' , "'.$file.'");
					
					</script>';
					
				//INSERT NEW MY>NA USER	
				}else{
					
					$this->db->insert('u_client', $insertdata);
					//get ID
					$this->db->where('CLIENT_EMAIL' , $email);
					$this->db->from('u_client');
					$query = $this->db->get();
					$row = $query->row_array();
					$member_id = $row['ID'];	
					
					//UPLOAD AVATAR
					$file = $this->add_avatar($member_id);
					
					//BUILD ARRAY 4 email		
					
					$data['fname'] = $fname;
					$data['img'] = '0';
					$data['member_id'] = $member_id;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['cell'] = $cell;
					$data['pass1'] = $pass1;
					$data['dob'] = $dob;
					$data['base'] = base_url('/');
					$data['confirm_link'] = site_url('/') . 'intranet/activate/'.$member_id;
					//SEND EMAIL LINK
					//BUILD BODY
					$body = '<h2>Hi '.$fname .',</h2>
							<h2>Welcome to the '.$company.' Intranet</h2> 
							<h3>Your registration has been processed.</h3>
							To verify your email address and give you access to the intranet please follow the link below.
							Once confirmed you will be granted access.
							<br /><br />
							Your username is: '.$email.'<br />
							Your temporary password is: '.$pass1.'
							<br /><br />
							Please follow the link below:<br /><br />
							<a href="'.$data['confirm_link'].'" title="activate membership">'.$data['confirm_link'].'</a>
							<br /><br />
							Have a great day!<br />
							'.$company;
							
			     	$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news',$data_view, true);
					
					$emailTO = array(array('email' => $email));
					$subject = 'Welcome to the '.$company.' Intranet '.$fname;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = $company;
					$TAG = array('tags' => 'intranet_registration' );
					
					$body_admin = 'A new member has registered via the Intranet portal on My Namibia. Please review and action as soon as possible.<br />	<br /><br />
							Client Name : '.$fname.' ' .$sname.'<br />
							Client Email : '.$email.'<br /><br />
		
							<br /><br />
							
							Please action this ASAP.';
					
					$data_admin['body'] = $body_admin;
					$body_admin_final_ = $this->load->view('email/body_news',$data_admin, true);
					$emailTONTB =  array(array('email' => 'roland@my.na'));
					$subject_admin = 'New Member Registration : '.$fname;
					$TAG_admin = array('tags' => 'intranet_registration' );
					
					//SEND EMAIL LINK TO USER
					$this->load->model('email_model');	
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	
					//SEND EMAIL LINK TO MY NA
					$this->email_model->send_mail($body_admin_final_, $subject_admin, $emailTONTB, $fromEMAIL, $fromNAME, $TAG_admin);	
					//success redirect		
					$data['basicmsg'] = 'Thank you, ' . $fname .' you have successfully registered.';
					
					echo 'TRUE'.$data['basicmsg'].'
					<script type="text/javascript">
					
						add_local_user('.$member_id.' , "'.$file.'");
					
					</script>
					';
					//$this->output->set_header("HTTP/1.0 200 OK");
				}
			
			}else{
					
					$data['error'] = $error. ' ' .$email;
					echo 'FAIL'.$data['error'];
					//$this->output->set_header("HTTP/1.0 200 OK");
			
			}
			
			
		}//END POST
	}
	
/**
++++++++++++++++++++++++++++++++++++++++++++
//REMOVE AVATAR
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
*/	
	function add_avatar_do($user_id)
	{
		
		$this->output->set_header("Access-Control-Allow-Origin: https://intranet.my.na");
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
			echo 'OPTIONS';
			
		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){	
		
			
			$this->load->model('members_model');
			$file = $this->add_avatar($user_id);
			return $file;
		
		}
		
		
		
	}

/**
++++++++++++++++++++++++++++++++++++++++++++
//Upload AVATAR
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
*/	
	
	function add_avatar($user_id)
	{	
			
          	$img = $this->input->post('userfile', TRUE);

			//upload file

			$config['upload_path'] = BASE_URL .'assets/users/photos/';
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
					
					$data['id'] = $user_id;
					$data['error'] =  $this->upload->display_errors();
					//$this->load->view('members/home', $data);
					
			}	
			else
			{	
			//LOAD library
			$this->load->library('image_lib');	
			//delete old photo
			$this->members_model->delete_old_avatar($user_id);
			
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   			 
				if (($width > 850) || ($height > 700)){
						 
						$this->members_model->downsize_image($file,$user_id);
								
				}

			//Watermark image
			$this->members_model->watermark_avatar($file);
			
			   //populate array with values
				$data = array( 
			      'CLIENT_PROFILE_PICTURE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID', $user_id);
				$this->db->update('u_client',$data);
				
				//Tourism DB
				$db2 = $this->members_model->connect_tourism_db();
				$db2->where('ID', $user_id);
				$db2->update('u_client', $data);
				
				//load respective view 
			   $data['id'] = $user_id;
			   
			   //get sizes 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
			   //redirect 
			   
			   return $file;

		}
			
			
	}

			
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login_do()
	{
			$email = $this->input->post('email', TRUE);
			$first = $this->input->post('first_log', TRUE);
			$pass = $this->input->post('pass', TRUE);
			$sess = $this->input->post('rememberme', TRUE);
			$redirect = $this->input->post('redirect', TRUE);
			
			//MATCH CREDENTIALS
			$this->load->model('members_model');
			$row = $this->members_model->validate_password($email,$pass);
			if($row['bool'] == 'YES'){
					
					//HASH PASSWORD AGAIN
					$pass_new = $this->members_model->hash_password($email,$pass);
					//create user array
					 $data = array(
					   'CLIENT_UA' => $this->agent->browser() . ' ver ' . $this->agent->version(),
					   'CLIENT_IP' => $this->input->ip_address(),
					   'LAST_LOGIN' => date("Y-m-d H:i:s"),
					   'CLIENT_PASSWORD' => $pass_new
					);
					
					if ($sess == TRUE) {
					//$this->session->cookie_monster();	
					}
					/*$this->session->set_userdata('id', $row['ID']);
					$this->session->set_userdata('u_name', $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] );
					$this->session->set_userdata('last_login', $row['LAST_LOGIN']);
					$this->session->set_userdata('img_file', $row['CLIENT_PROFILE_PICTURE_NAME']);
					$this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));*/

					$sess_arra = array(

						'id' =>  $row['ID'],
						'u_name' => $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] ,
						'last_login' =>  $row['LAST_LOGIN'],
						'img_file' =>  $row['CLIENT_PROFILE_PICTURE_NAME'],
						'points' =>  $this->my_na_model->count_points($row['ID'])
					);

					$this->session->set_userdata($sess_arra);

					$this->session->set_flashdata('login', 'yes');



					$this->db->where('ID', $row['ID']);
					$this->db->update('u_client', $data); 
					//SEE IF 1st Login
					if($first == 'Y'){
						
						$this->session->set_flashdata('first_login', 'Y');
							
					}
					
					//--------------
					//Redirect
					if($this->input->post('redirect')){
						
						//redirect($redirect, 'refresh');
						redirect('/ntb/landing/');
					}else{
						
						redirect('/ntb/landing/');	
						
					}
				
			}elseif($row['bool'] == 'NO'){
				
				$data['error'] = 'Your password did not match our records! Please update your password for '.$email;
				//echo $this->encode($pass) .' ' ;
				$this->load->view('ntb/login' , $data);
				
			//NO MATCHING CREDENTIALS
			}else{
			
				$data['error'] = 'No account found for '.$email.'! Please create a new user account <a href="'.site_url('/').'members/register/">here</a>';
				//echo $this->encode($pass) .' ' ;
				$this->load->view('ntb/login' , $data);
			
			}
	}


	public function claim_blank()
	{

		$client_id = $this->session->userdata('id');
		$msg = $this->input->post('claim_msg', TRUE);
		$captcha = $this->input->post('claim_captcha', TRUE);
		$x = $this->input->post('claim_x', TRUE);
		$y = $this->input->post('claim_y', TRUE);
		$business = $this->input->post('Cbusiness', TRUE);
		$ntb_reg = $this->input->post('ntb_reg', TRUE);
		$bus_id = str_replace(' ','',substr($business, strpos($business, '~'),strlen($business)));
		$bus_id = preg_replace("/[^0-9]/","",$bus_id);
		
		//VALIDATE INPUT
		if(($x + $y) != $captcha){
			$val = FALSE;
			$error = 'Your security answer did not match. What is '.$x . ' + ' . $y ;
						
		}else{
			$val = TRUE;
		}
		
		//IF VALIDATED
		if($val == TRUE){
			
			$business = $this->get_business($bus_id);	
			$client_row = $this->get_client_account($this->session->userdata('id'));	
			$emailTO = 'roland@my.na';
			$emailTONTB =  array(array( 'email' => 'info@namibiatourism.com.na'));
			$emailFROM = $client_row['CLIENT_EMAIL'];
			$body = 'We have received a new business claim request. Please review and action as soon as possible.<br />	<br /><br />
					Client Name : '.$client_row['CLIENT_NAME'].' ' .$client_row['CLIENT_SURNAME'].'<br />
				    Client Email : '.$client_row['CLIENT_EMAIL'].'<br /><br />
					Business Name : '.$business['BUSINESS_NAME'].'<br />
					Business Email : '.$business['BUSINESS_EMAIL'].'<br />
					NTB Reg: '.$ntb_reg.'<br /><br />
					Message: '.$msg.'
					
					<br /><br />
					
					Please action this ASAP.';
			
			$data_view['body'] = $body;
			$body_final = $this->load->view('email/body_news_ntb',$data_view,true);
			$emailTONTB =  array(array( 'email' => 'info@namibiatourism.com.na'));
			$emailTO = array(array('email' => 'roland@my.na'));
			$subject = 'My Namibia Business Claim ';
			$fromEMAIL = 'no-reply@my.na';
			$fromNAME = 'My Namibia';
			$TAG = array('tags' => 'ntb_business_claim' );
			
				
			//SEND EMAIL LINK TO MY NA
			$this->load->model('email_model');	
			$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	
			
			//SEND EMAIL LINK TO NTB	
			$this->email_model->send_mail($body_final, $subject, $emailTONTB, $fromEMAIL, $fromNAME, $TAG);
			//success redirect	
			
			
			
			
			//INSERT INTO MESSAGES TABLE
			$data2 = array(
				  'BUSINESS_ID'=> $bus_id ,
				  'CLIENT_ID'=> $client_id ,
				  'REFERENCE'=> strtoupper($ntb_reg)  
				);
			
			$this->db->insert('i_client_business_claims',$data2);
			
			$data['bus_id'] = $bus_id;
			$data['basicmsg'] = 'Thanks, '. $client_row['CLIENT_NAME']. '! We have succesfully sent your claim. It will be reviewed within 24 hours.' ;
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					$(".redactor_content").setCode("");
					</script>
					';	
		
		//IF NOT VALIDATED	
		}else{
			
			$data['bus_id'] = $bus_id;
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';	
			
		}
	
			
	}



	//+++++++++++++++++++++++++++
	//ADD NEW BUSINESS VIEW
	//++++++++++++++++++++++++++
	public function add_business(){
		
		$this->load->view('ntb/inc/add_business');
		
		
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
			$ntb_reg = $this->input->post('ntb_reg', TRUE);
			
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
								  'IS_NTB_MEMBER' => 'Y',
								  'BUSINESS_PHYSICAL_ADDRESS' => $address
					);
			
	
			
			if($val == TRUE){
				
					//insert
					$this->db->insert('u_business', $insertdata);
					//Get Business ID
					$test = $this->db->where('BUSINESS_EMAIL', $email);
					$test = $this->db->get('u_business');
					$test2 = $test->row_array();		
					
					//success redirect	
					$data['bus_id'] = $test2['ID'];
					$data['id'] = $this->session->userdata('id');
					
					$this->load->model('members_model');
					$this->members_model->add_business_member($data['bus_id'],$data['id']);
					
					
					
					$client_row = $this->get_client_account($this->session->userdata('id'));	
					$emailTO = 'roland@my.na';
					$emailTONTB =  array(array( 'email' => 'info@namibiatourism.com.na'));
					$emailFROM = $client_row['CLIENT_EMAIL'];
					$body = 'A new business has been added. Please review and action as soon as possible.<br />	<br /><br />
							Client Name : '.$client_row['CLIENT_NAME'].' ' .$client_row['CLIENT_SURNAME'].'<br /><br />
							Client Email : '.$client_row['CLIENT_EMAIL'].'<br /><br />
							Business Name : '.$name.'<br /><br />
							Business Email : '.$email.'<br /><br />
							NTB Reg: : '.$ntb_reg.'<br /><br />

							<br /><br />
							
							Please action this asap.';
					
					$data_view['body'] = $body;
					$body_final = $this->load->view('email/body_news_ntb',$data_view,true);
					$emailTONTB =  array(array( 'email' => 'info@namibiatourism.com.na'));
					$emailTO = array(array('email' => 'roland@my.na'));
					$subject = 'New Business Added : '.$name;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = 'My Namibia';
					$TAG = array('tags' => 'add_new_business' );
					
						
					//SEND EMAIL LINK TO MY NA
					$this->load->model('email_model');	
					$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);	
					
					//SEND EMAIL LINK TO NTB	
					$this->email_model->send_mail($body_final, $subject, $emailTONTB, $fromEMAIL, $fromNAME, $TAG);
					
					
					
					
					$data['basicmsg'] = 'Thank you ' . $name .' has been successfully registered';
					
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
			$this->load->view('ntb/build_mail', $data);	
		
	}		

    //+++++++++++++++++++++++++++
	//PREVIEW NEWSLETTER
	//++++++++++++++++++++++++++	
	function preview_news()
	{	
		$data['preview'] = 'true';
		$data['body'] = $this->input->post('mailbody',TRUE);
		//$data['body'] = urldecode($body);
		
		$this->load->view('email/body_news_ntb', $data);	

		
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
								$body1 = $this->load->view('email/body_news_ntb',$data2,true);
								$data['ADMIN_ID'] = $this->session->userdata('admin_id');
								
								$data['FROM'] = 'no-reply@my.na';
								$data['FROM_NAME'] = 'Namibia Tourism Board';
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
					    $body1 = $this->load->view('email/body_news_ntb',$data2,true); 
						$data['ADMIN_ID'] = $this->session->userdata('admin_id');
						$data['TO'] = $toemail;
						$data['FROM'] = 'no-reply@my.na';
						$data['FROM_NAME'] = 'Namibia Tourism Board';
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
									
								
									 //SEND TO BUCKET
								  //$this->load->model('gcloud_model');
								  //$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
								  $this->load->model('cron_model');
								  //UPLOAD S3
								  if(file_exists(BASE_URL.'assets/business/gallery/' . $file)){
					
									  $data['out'] = $this->cron_model->upload_s3('assets/business/gallery/' . $file);
								  }else{
					
									  $data['out'] = 'Not Uploaded';
					
								  }
									
								 
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = "<div class='item'><a class='thumbnail'><img src='".base_url('/') . "assets/business/gallery/".$file."' alt=''></a><div class='actions'><div class='actions-inner'><a title='' id='4223' class='tip-top removeImageAjax' data-original-title='Remove'><i class='glyphicon glyphicon-trash icon-white'></i></a></div></div></div>";
								  
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
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = S3_URL . "assets/business/photos/".$file;
								  
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
								 //crop 
								  $data['filename'] = $file;
								  $data['width'] = $this->upload->image_width;
								  $data['height'] = $this->upload->image_height;
								  $val = TRUE;
								  $image = S3_URL . "assets/business/photos/".$file;
								  
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


	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login()
	{
			$email = $this->input->post('email', TRUE);
			$pass = $this->input->post('pass', TRUE);
			$sess = $this->input->post('rememberme', TRUE);
			$redirect = $this->input->post('redirect', TRUE);
			
			$this->load->model('members_model');
			//MATCH CREDENTIALS
			$row = $this->members_model->validate_password($email,$pass);
			if($row['bool'] == 'YES'){
					
					//HASH PASSWORD AGAIN
					$pass_new = $this->members_model->hash_password($email,$pass);
					//create user array
					 $data = array(
					   'CLIENT_UA' => $this->agent->browser() . ' ver ' . $this->agent->version(),
					   'CLIENT_IP' => $this->input->ip_address(),
					   'LAST_LOGIN' => date("Y-m-d H:i:s"),
					   'CLIENT_PASSWORD' => $pass_new
					);
					
					if ($sess == TRUE) {
					//$this->session->cookie_monster();	
					}
					//$this->session->sess_destroy();
/*					$this->session->set_userdata('id', $row['ID']);
					$this->session->set_userdata('u_name', $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] );
					$this->session->set_userdata('last_login', $row['LAST_LOGIN']);
					$this->session->set_userdata('img_file', $row['CLIENT_PROFILE_PICTURE_NAME']);
					$this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));
					$this->session->set_flashdata('login', 'yes');*/
					
					$this->db->where('ID', $row['ID']);
					$this->db->update('u_client', $data); 
				
					//--------------
					//Redirect
					if($this->input->post('redirect')){
						
						$this->load->library('encrypt');
						$redirect = $this->encrypt->encode($redirect,  $this->config->item('encryption_key'));
						
						//echo 'yes';
						redirect('https://intranet.my.na/main/login_sess/1/'.$row['ID'].'/'.$redirect, 301);	
					}else{
						
						$redirect = $this->encrypt->encode('https://intranet.my.na/',  $this->config->item('encryption_key'));
						
						//echo 'yes1';
						redirect('https://intranet.my.na/main/login_sess/1/'.$row['ID'].'/'.$redirect.'/' );	
						
					}
				
			}elseif($row['bool'] == 'NO'){
				
				$data['error'] = $this->encrypt->encode('Your password did not match our records for '.$email,  $this->config->item('encryption_key'));
				
				//echo 'Your password did not match our records!';
				redirect('https://intranet.my.na/main/login_sess/0/0/0/'.$data['error']);	
				
			//NO MATCHING CREDENTIALS
			}else{
				
				$data['error'] = $this->encrypt->encode('No account found for '.$email.'!',  $this->config->item('encryption_key'));
				
				//echo 'No account found for '.$email.'!';
				redirect('https://intranet.my.na/main/login_sess/0/0/0/'.$data['error']);
			
			}
			
		
			
	}

	public function activate($id)
	{
		$this->db->where('ID' , $id);
		$this->db->where('IS_ACTIVE' , 'N');
		$this->db->from('u_client');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$update['IS_ACTIVE'] = 'Y';
			$this->db->where('ID', $id);
			$this->db->update('u_client', $update); 
			
			$this->load->library('encrypt');
			
			//GIVE CLIENT 10 FREE POINTS
			$this->load->model('business_model');
			$this->business_model->update_client_point($row['ID'], '15', 0, 'sign_up');
			//Redirect to home page
			$msg = 'Thank you, we have verified your account. Please login below';
			
			redirect('https://intranet.my.na/main/home/'.$this->encrypt->encode($msg,  $this->config->item('encryption_key')), 'refresh');
			
		}else{
			
			$msg = 'The link is expired and your account is already active.';
			redirect('https://intranet.my.na/main/home/'.$this->encrypt->encode($msg,  $this->config->item('encryption_key')), 'refresh');
			
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