<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ntb extends CI_Controller {

	/**
	 * NTB Controller for My.na.
	 *
	 * Roland Ihms
	 */
	function __construct()
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
	public function register()
	{
		$this->load->model('members_model');
		$this->load->view('ntb/register');

	}
	//+++++++++++++++++++++++++++
	//NTB LANDING PAGE
	//++++++++++++++++++++++++++
	public function landing()
	{
		if($this->session->userdata('id')){
			 	
				$this->load->model('members_model');
				$data['id'] = $this->session->userdata('id');
				$this->load->view('ntb/landing', $data);
		
		}else{
			
			    $this->load->view('ntb/login');
		 }	

	}
	
	
	public function login()
	{
		if($this->session->userdata('id')){
			 	
				redirect('/ntb/landing', 301);	
		
		}else{
			
			    $this->load->view('ntb/login');
		 }	

	}
	
    //+++++++++++++++++++++++++++
	//REGISTER MEMBER WITH AJAX
	//++++++++++++++++++++++++++
	function register_do_ajax()
	{
          	$email = $this->input->post('email', TRUE);
			$bname = $this->input->post('bname', TRUE);
			$ntb_reg = $this->input->post('ntb_reg', TRUE);
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
			$security = $this->input->post('security', TRUE);
			
			$x = $this->input->post('x', TRUE);
			$y = $this->input->post('y', TRUE);
			//$dob = strtotime($new_date_format); 
			
			
			//VALIDATE INPUT
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';	
				
			}elseif(($fname == '') || ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			
			}elseif(($pass1 != $pass2)){
				$val = FALSE;
				$error = 'Your password is not matching';
					
			}elseif((strlen($pass1) < 3)){
				$val = FALSE;
				$error = 'Your password is not strong enough';		
				
			}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
				$val = FALSE;
				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($dob == ''){
				$val = FALSE;
				$error = 'Please provide us with your date of birth in the format YYYY-MM-DD.';	
			
			}elseif($security != ($x + $y)){
				$val = FALSE;
				$error = 'Please solve the math problem below. Your answer did not match';	
							
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
							  'CLIENT_COUNTRY' => $country,
							  'CLIENT_CITY' => $city,
							  'CLIENT_SUBURB' => $suburb,
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
					$data['bname'] = $bname;
					$data['ntb_reg'] = $ntb_reg;
					$data['img'] = '0';
					$data['member_id'] = $member_id;
					$data['email'] = $email;
					$data['sname'] = $sname;
					$data['cell'] = $cell;
					$data['pass1'] = $pass1;
					$data['dob'] = $dob;
					$data['base'] = base_url('/');
					$data['confirm_link'] = site_url('/') . 'ntb/activate/'.$member_id;
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
					$body_final = $this->load->view('email/body_news_ntb',$data_view, true);
					
					$emailTO = array(array('email' => $email));
					$subject = 'Welcome to NTB Online '.$fname;
					$fromEMAIL = 'no-reply@my.na';
					$fromNAME = 'My Namibia';
					$TAG = array('tags' => 'ntb_registration' );
					
						
	
					
					$body_admin = 'A new member has registered via the NTB portal on My Namibia. Please review and action as soon as possible.<br />	<br /><br />
							Client Name : '.$fname.' ' .$sname.'<br />
							Client Email : '.$email.'<br /><br />
							Business Name : '.$bname.'<br />
							NTB Reg: '.$ntb_reg.'<br /><br />
							
							
							<br /><br />
							
							Please action this ASAP.';
					
					$data_admin['body'] = $body_admin;
					$body_admin_final_ = $this->load->view('email/body_news_ntb',$data_admin, true);
					$emailTONTB =  array(array( 'email' => 'info@namibiatourism.com.na'), array('email' => 'info@my.na'));
					$subject_admin = 'New Member Registration : '.$fname;
					$TAG_admin = array('tags' => 'ntb_registration' );
					
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
	
	
	function test(){
		
						$body = 'Hi ,<br /><br />
							Welcome to My Namibia, your registration has been processed. Please confirm your email address by following the link below.
							<br /><br />
							Once your email has been verified and NTB reviews your membership you can find and manage your business accross all online tourism platforms in Namibia 
							directly from your dashboard. You will be able to review your HAN evaluations and completely control how google and other search engines
							find your business on the internet.
							<br /><br />
							Please follow the link below:<br /><br />
							<blockquote>This is a quote</blockquote>
							<br /><br />
							Have a !tna day!<br />
							My Namibia';
							
				$data_view['body'] = $body;
				$body_final = $this->load->view('email/body_news_ntb',$data_view);	
		
		
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
			
			//GIVE CLIENT 10 FREE POINTS
			$this->load->model('business_model');
			$this->business_model->update_client_point($row['ID'], '15', 0, 'sign_up');
			//Redirect to home page
			$data['basicmsg'] = 'Thank you, we have verified your account. Please login below';
			$data['id'] = $id;
			$data['first'] = 'Y';
			$this->load->view('ntb/login',$data);
			
		}else{
			
			$data['error'] = 'The link is expired and your account is already active.';
			$this->load->view('ntb/landing',$data);	
			
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
					$this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));
					$this->session->set_flashdata('login', 'yes');*/

                    $sess = array(

                        'id' => $row['ID'],
                        'u_name' => $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'],
                        'last_login' =>$row['LAST_LOGIN'],
                        'img_file' => $row['CLIENT_PROFILE_PICTURE_NAME'],
                        'points' => $this->my_na_model->count_points($row['ID']),
                        'login' => 'yes'

                    );
                    $this->session->set_userdata($sess);
                    $this->session->set_flashdata('login', 'Y');


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



	//+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++
	function business_update_do()
	{
		$this->output->set_header("Access-Control-Allow-Origin: http://www.namibiatourism.com.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		//$this->output->set_content_type( 'multipart/form-data' );
		//$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST") {

			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description = html_entity_decode(str_replace('&nbsp;', ' ', $this->input->post('content', FALSE)));
			$bus_id = $this->input->post('bus_id', TRUE);

			$isactive = $this->input->post('isactive', TRUE);
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);

			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);

			$str1 = str_replace(' ', '', $cell);
			$cellNum = substr($str1, 0, 3);

			//VALIDATE INPUT
			if ($this->CheckAndValidateEmail($email)) {
				$val = FALSE;
				$error = 'Email address is not valid.';

				//}elseif($this->validate_cell($cellNum)){
				//				$val = FALSE;
				//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			} elseif ($name == '') {
				$val = FALSE;
				$error = 'Please provide us with your business name.';

				//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
				//				$val = FALSE;
				//				$error = 'Please provide us with a valid cellular number.';

			} elseif ($web != '') {

				if (!filter_var($web, FILTER_VALIDATE_URL)) {
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				} else {
					$val = TRUE;
				}

				//}elseif(str_word_count($description) < 30){
				//				$val = FALSE;
				//				$error = 'Please provide a minimum of 30 words for your business description. Currently: '.str_word_count($description).' words.';
				//
			} else {
				$val = TRUE;
			}


			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
			$IP = $this->input->ip_address();
			$insertdata = array(
				'BUSINESS_NAME' => $name,
				'BUSINESS_TELEPHONE' => '+264 ' . $tel2,
				'BUSINESS_EMAIL' => $email,
				'BUSINESS_CELLPHONE' => '+264 ' . $cell,
				'BUSINESS_FAX' => '+264 ' . $fax2,
				'BUSINESS_DESCRIPTION' => $description,
				'BUSINESS_POSTAL_BOX' => $pobox,
				'BUSINESS_URL' => $web,
				'ISACTIVE' => $isactive,
				'BUSINESS_PHYSICAL_ADDRESS' => $address,
				'BUSINESS_COUNTRY_ID' => $country,
				'BUSINESS_MAP_CITY_ID' => $city,
				'BUSINESS_SUBURB_ID' => $suburb
			);


			if ($val == TRUE) {

				$this->db->where('ID', $bus_id);
				$this->db->update('u_business', $insertdata);
				$data['error'] = true;
				$data['bus_id'] = $bus_id;
				$data['msg'] = $error;
				echo json_encode($data);


			} else {
				$data['error'] = false;
				$data['bus_id'] = $bus_id;
				$data['msg'] = $error;

				echo json_encode($data);

			}
		}else{

			$data['error'] = false;
			$data['bus_id'] = '';
			$data['msg'] = 'Only POST is allowed, and Only NTB';

			echo json_encode($data);

		}
	}

	//+++++++++++++++++++++++++++
	//UPLOAD MAP COORDINATES
	//++++++++++++++++++++++++++

	public function update_map_coordinates($bus_id = 0)
	{

		$this->output->set_header("Access-Control-Allow-Origin: http://www.namibiatourism.com.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		//$this->output->set_content_type( 'multipart/form-data' );
		//$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST") {

			$this->load->model('admin_model');
			$this->admin_model->update_map_coordinates();
			$data['msg'] = 'Co-ordinates updated successfully';

			$data['bus_id'] = $bus_id;
			$data['error'] = false;
			//$data['admin_id'] = $this->session->userdata('admin_id');
			//redirect('/my_admin/business_details/' . $bus_id . '/');

		} else {
			$data['error'] = true;
			$data['msg'] = 'Sorry, updates only accepted from NTB';


		}

		echo json_encode($data);

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
			$this->load->model('ntb_model');
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
      	
		$this->load->model('ntb_model');
		$this->ntb_model->show_email_recipients($type);
    }
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING GET LIST EMAIL
	//++++++++++++++++++++++++++

	public function emails($status = '')
	{
		error_reporting(E_ALL);
		$this->load->model('ntb_model');
		$this->load->view('ntb/emails');
	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING GET LIST EMAIL
	//++++++++++++++++++++++++++

	public function get_emails($status = '')
	{
		$this->load->model('ntb_model');
		$this->ntb_model->get_emails($status);
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
			$email_id = $this->input->post('email_id', FALSE);
			$count = 0;
			$mandrill[] = array();
			$this->load->model(array('admin_model','ntb_model'));


			//INSERT INTO EMAILS
			$insert['bus_id'] = 0;
			$insert['title'] = $subject;
			$insert['body'] = $body;
			$insert['status'] = 'sent';
			$insert['ntb_email'] = 'Y';
			$insert['admin_id'] = $this->session->userdata('admin_id');
			//GET EMAIL OR NEW ID

			if ($email_id == 0) {
				$this->db->insert('emails', $insert);
				$email_id = $this->db->insert_id();
			} else {

				$this->db->where('email_id', $email_id);
				$r = $this->db->get('emails');
				$rr = $r->row_array();


			}

			//CHECK IF ALL CLIENTS SELECTED
			if(empty($_POST['selectall'])){
						//ONLY SELECTED
						if(!empty($_POST['recipients'])) {
							$num = count($_POST['recipients']);
							 foreach($_POST['recipients'] as $value) {

								if($type == 'business' || $type == 'ntb' || $type == 'industry' || $type == 'accommodation'){
									
									$row = $this->admin_model->get_business_row($value);
									$toname = $row['BUSINESS_NAME'];
									$toemail = $row['BUSINESS_EMAIL'];
									
								}elseif($type == 'ntb_subscribers' ){
											
									$db = $this->ntb_model->connect_ntb_db();
									$str = 'Email Subscribers';
									$query = $db->query("SELECT u_newsletter.id as ID, u_newsletter.name as NAME, email as EMAIL
								 					FROM u_newsletter WHERE ID = ".$value."");
													
									if($query->result()){
										
										$row = $query->row_array();
										$toname = $row['NAME'];
										$toemail = $row['EMAIL'];
									}else{
										
										continue;	
									}
													
								}elseif($type == 'ntb' ){
									
									/*$this->db->where('NTB_ID', $value);
									$r = $this->db->get('u_business_ntb');
									$row = $r->row_array();
									$toname = $row['BUSINESS_NAME'];
									$toemail = $row['BUSINESS_EMAIL'];*/

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
								$data['EMAIL_ID'] = $email_id;
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
				if($type == 'accommodation'){
					$str = 'Accommodation Providers';
					$query = $this->db->query("SELECT u_business.*, u_business.ID as ID, u_business.BUSINESS_NAME as NAME
										FROM u_business
										JOIN i_tourism_category ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
										WHERE a_tourism_category.ID = 3 AND u_business.IS_NTB_MEMBER = 'Y'
										");
				}elseif($type == 'ntb'){
					$str = 'NTB Members';
					$query = $this->db->query("SELECT u_business.*, ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE IS_NTB_MEMBER = 'Y'");


				}elseif($type == 'ntb_subscribers' ){
											
					$db = $this->ntb_model->connect_ntb_db();
					$str = 'Email Subscribers';
					$query = $db->query("SELECT u_newsletter.id as ID, u_newsletter.name as NAME, email as EMAIL
									FROM u_newsletter");
									
					

				}elseif($type == 'industry'){
					$str = 'Industry Providers';
					$query = $this->db->query("SELECT u_business.*, u_business.ID as ID, u_business.BUSINESS_NAME as NAME
										FROM u_business
										JOIN i_tourism_category ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
										WHERE (a_tourism_category.ID = 4 OR a_tourism_category.ID = 5 OR a_tourism_category.ID = 10) AND u_business.IS_NTB_MEMBER = 'Y'
										");

				}else{
					$str = 'NTB Members';
					$query = $this->db->query("SELECT u_business.*, ID as ID, BUSINESS_NAME as NAME FROM u_business WHERE IS_NTB_MEMBER = 'Y'");
				}
				
				foreach($query->result() as $row){
					
						if($type == 'business' || $type == 'ntb' || $type == 'industry' || $type == 'accommodation'){
							
							$toname = $row->BUSINESS_NAME;
							$toemail = $row->BUSINESS_EMAIL;
						
						}elseif($type == 'ntb_subscribers'){
							
							$toname = $row->NAME;
							$toemail = $row->EMAIL;
						
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
						$data['EMAIL_ID'] = $email_id;
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

			/*var_dump($_FILES);

			echo 'aaaand <br />';

			var_dump($_POST);*/
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
					
						  if($this->upload->do_upload('cover_file'))
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

								  $data['success'] = true;
								  $data['logo_file'] = $image;
								  echo json_encode($data);
								  return;
										
						  }else{
							//ERROR
								$val = FALSE;
								$data['error'] =  $this->upload->display_errors();
							    $data['success'] = false;
								  echo json_encode($data);
								  return;
							
						  }
					 }
					
					 //redirect
					 if($val == TRUE){
						  
						 $data['basicmsg'] = $i .' Cover added successfully!';
						 $data['success'] = true;
						 echo json_encode($data);
						 return;
						
					 }else{

						 $data['success'] = false;
						 echo json_encode($data);
						 return;
					 }
			 }else{

				 $data['success'] = false;
				 $data['error'] = 'No Files Selected - Please select a cover file and try again';
				 echo json_encode($data);
				 return;
			 }
			 
			 	
			 
		}else{

			$data['error'] = 'You do not have access rights';
			$data['success'] = false;
			echo json_encode($data);
			 
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
			 
			/* var_dump($_FILES);

			echo 'aaaand <br />';

			var_dump($_POST);*/
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
					   $config['file_name']  = $name1;
					   
					
					  $this->upload->initialize($config);
					
						  if($this->upload->do_upload('logo_file'))
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
								 
								/* if ($this->is_han_member($bus_id)){
									 
									  //Tourism DB
									 $db2 = $this->connect_tourism_db();
									 //insert into database
									 $db2->where('ID', $bus_id);
									 $db2->update('u_business',$data);
									 
								 }*/
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

							     $data['success'] = true;
							     $data['logo_file'] = $image;
								 echo json_encode($data);
							  return;
								 /*echo '<script type="text/javascript">
											$("#logo_img_pre").attr("src", "'.$image.'");
										</script>';*/
										
						  }else{
							//ERROR
								$val = FALSE;
							    $data['success'] = false;
								$data['error'] =  $this->upload->display_errors();
							    echo json_encode($data);
							  return;
							
						  }
					 }
					
					 //redirect
					 if($val == TRUE){
						  
						 $data['basicmsg'] = $i .' Logo added successfully!';
						 /*echo '<div class="alert alert-success">
								 <button type="button" class="close" data-dismiss="alert">×</button>
								'. $data['basicmsg'].'
								 </div>
							';*/
						 $data['success'] = false;
						 echo json_encode($data);
					 }else{
						 
						/* echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>'
								 . $data['error'].'
								 </div><script type="text/javascript">
									console.log("error");
									
								</script>';*/
						 $data['success'] = false;
						 echo json_encode($data);
					 }
			 }else{
				 /* echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							 No Files Selected - Please select a cover file and try again
							 </div><script type="text/javascript">
								console.log("error");
								
							</script>';*/
				 $data['error'] = 'No Files Selected - Please select a cover file and try again';
				 $data['success'] = false;
				 echo json_encode($data);
				 
			 }
			 
			 	
			 
		}else{
			

			$data['error'] = 'You do not have access rights';
			$data['success'] = false;
			echo json_encode($data);
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



   // ++++++++++++++++++++++++++++++++++++++++++++
    //IMPORT NTB
    //Functions
   // ++++++++++++++++++++++++++++++++++++++++++++
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SYNC NTB
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SYNC NTB
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function sync_ntb($offset = 0, $limit = 1000)
    {
        ini_set('memory_limit','128M');
        //$this->db->limit($limit);
        //$this->db->offset($offset);
        //$this->db->where('SYNCED', 'N');
        $this->db->limit($limit, $offset);
        $ncci = $this->db->get('u_business_ntb_2');
        //$this->db->query('SELECT * FROM MAP_LOCATION');
        $match_id = 0;
        $count = 0;$duplicate = 0;$inserts = 0;
        foreach($ncci->result() as $row){

            $t = $this->db->query("SELECT * FROM a_map_location WHERE MAP_LOCATION LIKE '%".trim($row->BUSINESS_TOWN)."%'");

            if($t->result()){

                $crow = $t->row();
                $d['BUSINESS_TOWN'] = $crow->ID;

                /*$this->db->where('NTB_ID', $row->NTB_ID);
                $this->db->update('u_business_ntb_2', $d);*/

                echo 'Yup, updated'. $row->BUSINESS_TOWN.'<br />';
                $count ++;
            }else{

                echo ' --- Nope , not updated'. $row->BUSINESS_TOWN.'<br />';
                $duplicate ++;
            }
            $inserts ++;
        }

        echo 'Total Updates: '. $count.'  Non updates: ' .$duplicate.'<br />
			  Totals Records :	'.$inserts.'<br />';

        echo '<a href="'.site_url('/').'ntb/sync_ntb/'.($offset + $limit).'/'.$limit.'/">Next</a>';
    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SYNC NTB
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function sync_ntb_($offset = 0, $limit = 500)
    {
        ini_set('memory_limit','128M');
        //$this->db->limit($limit);
        //$this->db->offset($offset);
        $this->db->where('SYNCED', 'N');
        $this->db->limit($limit, $offset);
        $ncci = $this->db->get('u_business_ntb_2');
        $match_id = 0;
        $count = 0;$duplicate = 0;$inserts = 0;

		$this->load->view('inc/header');
		echo '<p>&nbsp;</p><table class="table">';

        foreach($ncci->result() as $nccirow){

            //$match = $this->db->query('SELECT BUSINESS_NAME FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->name.'"', FALSE);
            //LIKE
            //$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME LIKE "%'.str_replace(" ", "%",str_replace("'"," ", str_replace('"', ' ', $nccirow->BUSINESS_NAME))).'" AND ID != '.$match_id.' ORDER BY ID LIMIT 5', FALSE);
            $namSQL = ' BUSINESS_NAME LIKE "%'.str_replace('"', ' ', $nccirow->BUSINESS_NAME).'%"';
            $t = '';$xxx = 0;
            if($nccirow->BUSINESS_NAME){

                $nameA = explode(" ", stripslashes($nccirow->BUSINESS_NAME));
				$cats = $this->identify_category_from_name($nameA);
                foreach($nameA as $nrow){

                    if(strtolower($nrow) == 'cc' || strtolower($nrow) == 'pty' || strtolower($nrow) == 'ltd' || strtolower($nrow) == 'namibia' || strlen($nrow) < 3 || $nrow == 'testrecord@asd.asd'){

                    }else{


                        if($xxx == 0) {

                            $t .= ' BUSINESS_NAME LIKE "%'.$nrow.'%" ';
                        }else{

                            if(count($nameA) > 4){
                                $t .= ' AND BUSINESS_NAME LIKE "%'.$nrow.'%" ';
                            }else{
                                $t .= ' AND BUSINESS_NAME LIKE "%'.$nrow.'%" ';

                            }


                        }
                        $xxx ++;
                    }




                }
                if(strlen($t) > 2){

                    $namSQL = $t;
                }


            }

            if($xxx > 2){

                $sql = "SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION,BUSINESS_TELEPHONE, ID, ISACTIVE FROM u_business WHERE ".$namSQL." AND ID != ".$match_id." ORDER BY ID LIMIT 1";
            }else{

                $sql = "SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_TELEPHONE, BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE ".$namSQL." AND ID != ".$match_id." ORDER BY ID LIMIT 1";

            }




            //echo $sql.'<br />';
            //EXACT
            $match = $this->db->query($sql, FALSE);
            //Duplicate - MERGE
            if($match->result()){

                foreach($match->result() as $match_row){

                    //echo 'NTB: ' . $nccirow->BUSINESS_NAME.' == My.na : '.$match_row->BUSINESS_NAME.'     -- !! '.$cats['cat'].'<br />++++++++++++++++++++++++++++++<br />';
					echo '<tr  id="'.$nccirow->NTB_ID.'">
							<td>NTB: ' . $nccirow->BUSINESS_NAME.' ' .$nccirow->BUSINESS_EMAIL.' - '. $nccirow->BUSINESS_TELEPHONE.' ==
								</a>
							</td>
							<td>My.na : '.$match_row->BUSINESS_NAME.' '.$match_row->BUSINESS_EMAIL.' - '.$match_row->BUSINESS_TELEPHONE.' ' .$cats['cat'].' </td>
							<td><a style="color:#750404" onclick="do_sync('.$nccirow->NTB_ID.')">Do Sync</a> || <a style="color:#cc0909" onclick="do_import('.$nccirow->NTB_ID.')">Import</a></td>
						 </tr>';
                    //Update existing My na Table
                    if($nccirow->BUSINESS_EMAIL != ''){

                        $update_my['BUSINESS_EMAIL'] = 	$nccirow->BUSINESS_EMAIL;
                    }
                    if($nccirow->BUSINESS_TELEPHONE != ''){

                        $update_my['BUSINESS_TELEPHONE'] =  $nccirow->BUSINESS_TELEPHONE;
                    }


                    if($nccirow->BUSINESS_POSTAL_BOX != ''){

                        $update_my['BUSINESS_POSTAL_BOX'] =  	$nccirow->BUSINESS_POSTAL_BOX;
                    }


                    if($nccirow->BUSINESS_PHYSICAL_ADDRESS != ''){

                        $update_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->BUSINESS_PHYSICAL_ADDRESS;
                    }
                    if($nccirow->BUSINESS_TOWN != ''){

                        $update_my['BUSINESS_MAP_CITY_ID'] =  $nccirow->BUSINESS_TOWN;
                    }
                    //MERGE BUSINESS
                    $update_my['IS_NTB_MEMBER'] = 'Y';
                    $update_my['NTB_REG'] = trim($nccirow->NTB_REG);

                   // $this->db->where('ID', $match_row->ID);
                    //$this->db->update('u_business', $update_my);


                    //ADD BUS_ID to NCCI table

                    $update_data['BUS_ID'] = $match_row->ID;
                    $update_data['SYNCED'] = 'Y';
                    //$this->db->where('NTB_ID', $nccirow->NTB_ID);
                    //$this->db->update('u_business_ntb_2', $update_data);


                    if(isset($cats['cat_id']) && $cats['cat_id'] > 0 && $cats['cat_id'] != ''){

                        //INSERT CATGORIES
                        $catA['BUSINESS_ID'] =  $match_row->ID;
                        $catA['CATEGORY_ID'] =  $cats['cat_id'];
                        $catA['IS_ACTIVE'] =  'Y';

                        //$this->insert('i_client_business', $catA);
                    }

                    $duplicate ++;
                }

                $match_id = $match_row->ID;

                //Insert as NEW
            }else{


                //$match2 = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME LIKE "%'.str_replace(" ", "%",str_replace("'"," ", str_replace('"', ' ', $nccirow->BUSINESS_NAME))).'" AND ID != '.$match_id.' ORDER BY ID', FALSE);
//
//					if($match2->result()){
//
//						foreach($match2->result() as $match_row2){
//
//							echo 'NTB Like result : ' . $nccirow->BUSINESS_NAME.' == My.na : '.$match_row2->BUSINESS_NAME.'<br />++++++++++++++++++++++++++++++<br />';
//
//							$duplicate ++;
//
//						}
//
//					}else{


				echo '<tr  id="'.$nccirow->NTB_ID.'">
							<td><strong>Imported:</strong>  '.$nccirow->BUSINESS_NAME.' '.$nccirow->BUSINESS_EMAIL.' ' .$nccirow->BUSINESS_TELEPHONE.'- !! '.$cats['cat'].'

							</td>
							<td> </td>
							<td> <a style="color:#F00" onclick="skip('.$nccirow->NTB_ID.')">Skip</a> || <a style="color:#cc0909" onclick="do_import('.$nccirow->NTB_ID.')">Import</a></td>
						 </tr>';
                $insert_my['IS_NTB_MEMBER'] = 'Y';
                $insert_my['ISACTIVE'] = 'Y';
                $insert_my['BUSINESS_NAME'] = strip_slashes($nccirow->BUSINESS_NAME);
                $insert_my['NTB_REG'] = trim($nccirow->NTB_REG);


                if($nccirow->BUSINESS_EMAIL != ''){
                    $insert_my['BUSINESS_EMAIL'] = $nccirow->BUSINESS_EMAIL;
                }
                if($nccirow->BUSINESS_TELEPHONE != ''){

                    $insert_my['BUSINESS_TELEPHONE'] =  $nccirow->BUSINESS_TELEPHONE;
                }


                if($nccirow->BUSINESS_POSTAL_BOX != ''){

                    $insert_my['BUSINESS_POSTAL_BOX'] =  	$nccirow->BUSINESS_POSTAL_BOX . ' ' .$nccirow->BUSINESS_TOWN;
                }


                if($nccirow->BUSINESS_PHYSICAL_ADDRESS != ''){

                    $insert_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->BUSINESS_PHYSICAL_ADDRESS;
                }

                if($nccirow->BUSINESS_TOWN != ''){

                    $insert_my['BUSINESS_MAP_CITY_ID'] =  $nccirow->BUSINESS_TOWN;
                }
                $insert_my['BUSINESS_DESCRIPTION'] = $nccirow->BUSINESS_NAME . ' located at '.$nccirow->BUSINESS_PHYSICAL_ADDRESS . ' in  , '.$nccirow->BUSINESS_REGION ;
                $insert_my['BUSINESS_URL'] =  $nccirow->BUSINESS_WEBSITE;

                //$this->db->insert('u_business', $insert_my);

                //Update NCCI TABLE WITH BUS ID
				$data_update['SYNCED'] = 'Y';
                $data_update['BUS_ID'] = $this->db->insert_id();
                //$this->db->where('NTB_ID', $nccirow->NTB_ID);
                //$this->db->update('u_business_ntb_2', $data_update);


                if(isset($cats['cat_id']) && $cats['cat_id'] > 0 && $cats['cat_id'] != ''){

                    //INSERT CATGORIES
                    $catA['BUSINESS_ID'] =  $data_update['BUS_ID'];
                    $catA['CATEGORY_ID'] =  $cats['cat_id'];
                    $catA['IS_ACTIVE'] =  'Y';

                    //$this->insert('i_client_business', $catA);
                }



                $match_id = 0;
                $inserts ++;


				

                //}

            }

            $count ++;

        }
		echo '</table>';
        echo 'Total Rows: '. $count.'  Duplicates: ' .$duplicate.'<br />
			  Totals Records Imported :	'.$inserts.'<br />';
        if($count == $limit){

            echo '<a href="'.site_url('/').'ntb/sync_ntb_/'.($offset + $limit).'/'.$limit.'/">Next</a>';
        }


		echo "<script>


					function skip(id){

						var loading = $('tr#'+id);
						loading.addClass('loading_img');
						//build content
						$.ajax({
							type: 'get',
							cache: false,
							url: '".site_url('/')."ntb/skip_import/'+id ,
							success: function (data) {
							//barcover.hide();


								loading.hide();
							}
						});

					}
					function do_import(id){

						var loading = $('tr#'+id);
						loading.addClass('loading_img');
						//build content
						$.ajax({
							type: 'get',
							cache: false,
							url: '".site_url('/')."ntb/do_import/'+id ,
							success: function (data) {
							//barcover.hide();

								loading.hide();

							}
						});

					}
					function do_sync(id){

						var loading = $('tr#'+id);
						//build content
						$.ajax({
							type: 'get',
							cache: false,
							url: '".site_url('/')."ntb/do_sync/'+id ,
							success: function (data) {
							//barcover.hide();


								loading.hide();
							}
						});

					}
			</script>";

    }


	//connect to tourism db
	function skip_import($id){
		error_reporting(E_ALL);
		$data_update['SYNCED'] = 'Y';
		$this->db->where('NTB_ID', $id);
		$this->db->update('u_business_ntb_2', $data_update);


	}

		//connect to tourism db
	function do_sync($id)
	{
		error_reporting(E_ALL);
		$this->db->where('NTB_ID', $id);

		$ncci = $this->db->get('u_business_ntb_2');
		$match_id = 0;
		$count = 0;$duplicate = 0;$inserts = 0;

		foreach($ncci->result() as $nccirow){

			//$match = $this->db->query('SELECT BUSINESS_NAME FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->name.'"', FALSE);
			//LIKE
			//$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME LIKE "%'.str_replace(" ", "%",str_replace("'"," ", str_replace('"', ' ', $nccirow->BUSINESS_NAME))).'" AND ID != '.$match_id.' ORDER BY ID LIMIT 5', FALSE);
			$namSQL = ' BUSINESS_NAME LIKE "%'.str_replace('"', ' ', $nccirow->BUSINESS_NAME).'%"';
			$t = '';$xxx = 0;
			if($nccirow->BUSINESS_NAME){

				$nameA = explode(" ", stripslashes($nccirow->BUSINESS_NAME));
				$cats = $this->identify_category_from_name($nameA);
				foreach($nameA as $nrow){

					if(strtolower($nrow) == 'cc' || strtolower($nrow) == 'pty' || strtolower($nrow) == 'ltd' || strtolower($nrow) == 'namibia' || strlen($nrow) < 3 || $nrow == 'testrecord@asd.asd'){

					}else{


						if($xxx == 0) {

							$t .= ' BUSINESS_NAME LIKE "%'.$nrow.'%" ';
						}else{

							if(count($nameA) > 4){
								$t .= ' AND BUSINESS_NAME LIKE "%'.$nrow.'%" ';
							}else{
								$t .= ' AND BUSINESS_NAME LIKE "%'.$nrow.'%" ';

							}


						}
						$xxx ++;
					}




				}
				if(strlen($t) > 2){

					$namSQL = $t;
				}


			}

			if($xxx > 2){

				$sql = "SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE ".$namSQL." AND ID != ".$match_id." ORDER BY ID LIMIT 1";
			}else{

				$sql = "SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE ".$namSQL." AND ID != ".$match_id." ORDER BY ID LIMIT 1";

			}




			//echo $sql.'<br />';
			//EXACT
			$match = $this->db->query($sql, FALSE);
			//Duplicate - MERGE
			if($match->result()){

				foreach($match->result() as $match_row){

					//echo 'NTB: ' . $nccirow->BUSINESS_NAME.' == My.na : '.$match_row->BUSINESS_NAME.'     -- !! '.$cats['cat'].'<br />++++++++++++++++++++++++++++++<br />';

					//Update existing My na Table
					if($nccirow->BUSINESS_EMAIL != ''){

						$update_my['BUSINESS_EMAIL'] = 	$nccirow->BUSINESS_EMAIL;
					}
					if($nccirow->BUSINESS_TELEPHONE != ''){

						$update_my['BUSINESS_TELEPHONE'] =  $nccirow->BUSINESS_TELEPHONE;
					}


					if($nccirow->BUSINESS_POSTAL_BOX != ''){

						$update_my['BUSINESS_POSTAL_BOX'] =  	$nccirow->BUSINESS_POSTAL_BOX;
					}


					if($nccirow->BUSINESS_PHYSICAL_ADDRESS != ''){

						$update_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->BUSINESS_PHYSICAL_ADDRESS;
					}
					if($nccirow->BUSINESS_TOWN != ''){

						$update_my['BUSINESS_MAP_CITY_ID'] =  $nccirow->BUSINESS_TOWN;
					}
					//MERGE BUSINESS
					$update_my['IS_NTB_MEMBER'] = 'Y';
					$update_my['NTB_REG'] = trim($nccirow->NTB_REG);

					$this->db->where('ID', $match_row->ID);
					$this->db->update('u_business', $update_my);


					//ADD BUS_ID to NCCI table

					$update_data['BUS_ID'] = $match_row->ID;
					$update_data['SYNCED'] = 'Y';
					$this->db->where('NTB_ID', $nccirow->NTB_ID);
					$this->db->update('u_business_ntb_2', $update_data);


					if(isset($cats['cat_id']) && $cats['cat_id'] > 0 && $cats['cat_id'] != ''){

						//INSERT CATGORIES
						$catA['BUSINESS_ID'] =  $match_row->ID;
						$catA['CATEGORY_ID'] =  $cats['cat_id'];
						$catA['IS_ACTIVE'] =  'Y';

						$this->insert('i_tourism_category', $catA);
					}

					$duplicate ++;
				}

				$match_id = $match_row->ID;


			}

			$count ++;

		}

	}
	//connect to tourism db
	function do_import($id){

		//$this->db->where('NTB_ID', $id);
		$q = $this->db->query("SELECT u_business_ntb_2.*, a_map_location.MAP_LOCATION FROM u_business_ntb_2
								LEFT JOIN a_map_location ON a_map_location.ID = u_business_ntb_2.BUSINESS_TOWN
								WHERE NTB_ID = '".$id."' ");

		foreach($q->result() as $nccirow){

			$nameA = explode(" ", stripslashes($nccirow->BUSINESS_NAME));
			$cats = $this->identify_category_from_name($nameA);
			//echo '<p id="'.$nccirow->NTB_ID.'">Imported: '.$nccirow->BUSINESS_NAME.'++++++++++++++++++++    -- !! '.$cats['cat'].' <a style="color:#F00" onclick="skip('.$nccirow->NTB_ID.')">Skip</a> || <a style="color:#cc0909" onclick="import('.$nccirow->NTB_ID.')">Import</a></p>';

			$insert_my['IS_NTB_MEMBER'] = 'Y';
			$insert_my['ISACTIVE'] = 'Y';
			$insert_my['BUSINESS_NAME'] = strip_slashes($nccirow->BUSINESS_NAME);
			$insert_my['NTB_REG'] = trim($nccirow->NTB_REG);


			if($nccirow->BUSINESS_EMAIL != ''){
				$insert_my['BUSINESS_EMAIL'] = $nccirow->BUSINESS_EMAIL;
			}
			if($nccirow->BUSINESS_TELEPHONE != ''){

				$tel = $this->validate_cell_final($nccirow->BUSINESS_TELEPHONE, '');

				if($tel['bool']){

					$insert_my['BUSINESS_TELEPHONE'] = $tel['phone'];
				}else{
					$insert_my['BUSINESS_TELEPHONE'] = $nccirow->BUSINESS_TELEPHONE;
					$data_update['BUSINESS_COMMENTS']  = $tel['error'];


				}
				//var_dump($tel);
			}


			if($nccirow->BUSINESS_POSTAL_BOX != ''){

				$insert_my['BUSINESS_POSTAL_BOX'] =  	$nccirow->BUSINESS_POSTAL_BOX . ' ' .$nccirow->MAP_LOCATION;
			}


			if($nccirow->BUSINESS_PHYSICAL_ADDRESS != ''){

				$insert_my['BUSINESS_PHYSICAL_ADDRESS'] =  str_replace($nccirow->MAP_LOCATION, '',$nccirow->BUSINESS_PHYSICAL_ADDRESS). ' ' .$nccirow->MAP_LOCATION;
			}

			if($nccirow->BUSINESS_TOWN != ''){

				$insert_my['BUSINESS_MAP_CITY_ID'] =  $nccirow->BUSINESS_TOWN;
			}
			$insert_my['BUSINESS_DESCRIPTION'] = $nccirow->BUSINESS_NAME . ' located at '.$nccirow->BUSINESS_PHYSICAL_ADDRESS . ' in  , '.$nccirow->BUSINESS_REGION .' ' .$nccirow->MAP_LOCATION;
			$insert_my['BUSINESS_URL'] =  $nccirow->BUSINESS_WEBSITE;

			$this->db->insert('u_business', $insert_my);

			//Update NCCI TABLE WITH BUS ID
			$data_update['SYNCED'] = 'Y';
			$data_update['BUS_ID'] = $this->db->insert_id();
			$this->db->where('NTB_ID', $nccirow->NTB_ID);
			$this->db->update('u_business_ntb_2', $data_update);


			if(isset($cats['cat_id']) && $cats['cat_id'] > 0 && $cats['cat_id'] != ''){

				//INSERT CATGORIES
				$catA['BUSINESS_ID'] =  $data_update['BUS_ID'];
				$catA['CATEGORY_ID'] =  $cats['cat_id'];
				$catA['IS_ACTIVE'] =  'Y';

				$this->db->insert('i_tourism_category', $catA);
			}



			$match_id = 0;
			//$inserts ++;






		}

	}


	//+++++++++++++++++++++++++++
	//EMAIL MARKETING - COMPOSE
	//++++++++++++++++++++++++++

	public function compose_email($id = 0)
	{


		$this->load->model('ntb_model');
		if($id == 0){

			$email = '';
		}else{

			$this->db->where('email_id', $id);
			$q = $this->db->get('emails');

			if($q->result()){

				$email = $q->row_array();
			}

		}

		$this->load->model('email_model');
		$this->load->view('ntb/build_mail', $email);




	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SVALIDATE CELL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//HTML
	function validate_cell_final($num, $txt)
	{

		//CLEAN
		$to = trim(preg_replace('/[^0-9]/', '', $num));
		$final = '';

		$first = substr($to ,0,1);
		$first2 = substr($to ,0,2);
		$first3 = substr($to, 0, 3);
		$val = FALSE;
		$data['error'] = 'Malformed';
		//REMOVE 0027
		if($first == '0' && $first2 == '0'){

			$to = substr($to,2,strlen($to));
		}
		//override
		$first = substr($to ,0,1);
		$first2 = substr($to ,0,2);
		$first3 = substr($to, 0, 3);
		$length = strlen($to);

		//STRIP 264
		if($first3 == '264'){

			$to = substr($to,3,strlen($to));
			//override
			$first = substr($to ,0,1);
			$first2 = substr($to ,0,2);
			$first3 = substr($to, 0, 3);
			$length = strlen($to);
			//remove leading 0


		}
		if($first == 0){

			$to = substr($to,1,strlen($to));
			//override
			$first = substr($to ,0,1);
			$first2 = substr($to ,0,2);
			$first3 = substr($to, 0, 3);
			$length = strlen($to);
		}
		//SMS
		if($to != '' && $length <= 13){

			//too long
			if($length >= 10 && $first != 0){

				$val = FALSE;
				$data['error'] = 'Too many digits';
				$final = $to;

			}elseif($length < 4){

				$val = FALSE;
				$data['error'] = 'Must be atleast 5 digits';
				$final = $to;

			/*	//REMOVE 0
			}elseif($length == 10 && ($first3 == '081' || $first3 == '085')){

				$final2 = substr($to, 1, strlen($to));
				$final = '264'.$final2;
				$val = TRUE;*/

			}elseif($length == 9 && ($first2 == '81' || $first2 == '85')){

				//$final2 = substr($to, 1, strlen($to));
				$final = '264'.$to;
				$val = TRUE;

				//IF NOT 081 or 085
			/*}elseif($first2 != '81' || $first2 != '85'){

				$data['error'] = 'Not a namibian 081 or 085 Number';
				$final = '264'.$to;
				$val = FALSE;*/

			}else{

				$final ='264'. $to;
				$val = TRUE;

			}




			//VALIDATE NUMBER
			if($val){

				$data['bool'] = true;
				$data['phone'] = $final;
				$data['error'] = '';
				return $data;

			}else{

				$data['bool'] = false;
				$data['phone'] = $final;

				return $data;
			}
			//echo $num .'     length: ' .$length.' first: '.$first.' first2: '.$first2.' first3: ' .$first3.' whole: ' .$final.'   == '.$data['error'].' <br />';

		}

	}



	//connect to tourism db
	function identify_category_from_name($name){
		
		foreach($name as $row){
			
			if(strtolower($row) == 'lodge'){
				$d['cat'] = 'Lodge';
				$d['cat_id'] = 8;
				return $d;

            }elseif(strtolower($row) == 'horse' || strtolower($row) == 'horseriding' ){
                $d['cat'] = 'Horse';
                $d['cat_id'] = 21;
                return $d;
			}elseif(strtolower($row) == 'camp' || strtolower($row) == 'campsite' || strtolower($row) == 'camping'){
				$d['cat'] = 'Camping';
				$d['cat_id'] = 11;
				return $d;
			}elseif(strtolower($row) == 'cottage' || strtolower($row) == 'catering' || strtolower($row) == 'self'){
				$d['cat'] = 'Cottage';
				$d['cat_id'] = 10;
				return $d;
			}elseif(strtolower($row) == 'travel' || strtolower($row) == 'operator' || strtolower($row) == 'agent' || strtolower($row) == 'safaris' || strtolower($row) == 'tour' || strtolower($row) == 'tours' ||strtolower($row) == 'adventures' || strtolower($row) == 'adventure' || strtolower($row) == 'explore' || strtolower($row) == 'explorers'){
				$d['cat_id'] = 431;
				$d['cat'] = 'Travel Agent';
				return $d;
			}elseif(strtolower($row) == 'farm' || strtolower($row) == 'guestfarm' || strtolower($row) == 'gaste farm' || strtolower($row) == 'ranch'){
				$d['cat_id'] = 5;
				$d['cat'] = 'Farm';
				return $d;
			}elseif(strtolower($row) == 'ranch'  ){
				$d['cat_id'] = 416;
				$d['cat'] = 'Ranch';
				return $d;
			}elseif(strtolower($row) == 'backpackers' || strtolower($row) == 'backpack'){
				$d['cat_id'] = 2;
				$d['cat'] = 'Backpackers';
				return $d;
			}elseif(strtolower($row) == 'guesthouse' || strtolower($row) == 'inn'){
				$d['cat_id'] = 4;
				$d['cat'] = 'Guest House';
				return $d;
			}elseif(strtolower($row) == 'bed and breakfast' || strtolower($row) == 'breakfast' || strtolower($row) == 'b n b' || strtolower($row) == 'b and b'){
				$d['cat_id'] = 3;
				$d['cat'] = 'B & B';
				return $d;
			}elseif(strtolower($row) == 'hotel'){
				$d['cat_id'] = 9;
				$d['cat'] = 'Hotel';
                return $d;
			}elseif(strtolower($row) == 'resort' || strtolower($row) == 'casino'){
				$d['cat_id'] = 7;
				$d['cat'] = 'Hotel Resort';
				return $d;

            }elseif(strtolower($row) == 'fishing' || strtolower($row) == 'angling'){
                $d['cat_id'] = 557;
                $d['cat'] = 'Fishing and Angling';
                return $d;
            }elseif(strtolower($row) == 'sky' || strtolower($row) == 'parachute' || strtolower($row) == 'diving'){
                $d['cat_id'] = 30;
                $d['cat'] = 'Sky Diving';
                return $d;
            }elseif(strtolower($row) == 'boat' || strtolower($row) == 'cruise' || strtolower($row) == 'catamaran'){
                $d['cat_id'] = 19;
                $d['cat'] = 'Boat Cruise';
                return $d;
            }elseif(strtolower($row) == 'sand' || strtolower($row) == 'sanboarding' || strtolower($row) == 'boarding'){
                $d['cat_id'] = 28;
                $d['cat'] = 'Sand Boarding';
                return $d;
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