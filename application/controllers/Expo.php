<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Expo extends CI_Controller {

	/**
	 * Adverts Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function Expo()
	{
		parent::__construct();
		
	}
	
	
	//+++++++++++++++++++++++++++
	//LOGIN EXPO
	//++++++++++++++++++++++++++
	public function login()
	{
			$this->load->model('members_model');
			
			$email = $this->input->post('email', TRUE);
			$first = $this->input->post('first_log', TRUE);
			$pass = $this->input->post('pass', TRUE);
			$sess = $this->input->post('rememberme', TRUE);
			$redirect = $this->input->post('redirect', TRUE);
			
			$this->session->unset_userdata('id');
			
			//MATCH CREDENTIALS
			$row = $this->members_model->validate_password($email,$pass);
			if($row['bool'] == TRUE){
					
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
					$this->session->set_userdata('id', $row['ID']);
					$this->session->set_userdata('u_name', $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] );
					$this->session->set_userdata('last_login', $row['LAST_LOGIN']);
					$this->session->set_userdata('img_file', $row['CLIENT_PROFILE_PICTURE_NAME']);
					$this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));
					$this->session->set_flashdata('login', 'yes');
					$this->db->where('ID', $row['ID']);
					$this->db->update('u_client', $data); 
					//SEE IF 1st Login
					if($first == 'Y'){
						
						$this->session->set_flashdata('first_login', 'Y');
							
					}
					
					//--------------
					
						
					echo '<div class="alert alert-block">
							<h3>Logging in</h3>
							Please wait while we load the game
							</div>
							<script type="text/javascript">
							
								step2.hide();
								step4.slideDown("fast");
								$(".keyboard > ul").hide();
							</script>';
				
				
			//NO MATCHING CREDENTIALS
			}else{
			
				$data['error'] = 'No matching records found!';
				//echo $this->encode($pass) .' ' ;
				echo '<div class="alert alert-block">
							<h3>No matching records found!</h3>
							No matching records found!
							</div>';
			
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//LOAD SIGNUP FORM
	//++++++++++++++++++++++++++
	public function load_registration()
	{

		$this->load->view('expo/register');
	}
	//+++++++++++++++++++++++++++
	//REGISTER MEMBER WITHOUT AJAX
	//++++++++++++++++++++++++++
	function register_do_ajax()
	{		
			$rep_id = $this->input->post('rep_id', TRUE);
          	$email = $this->input->post('email', TRUE);
			$fname = $this->input->post('fname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$cell = $this->input->post('cell', TRUE);
			$rep_id = $this->input->post('rep_id', TRUE);
			
			$this->session->unset_userdata('id');
			
			$dob = $this->input->post('dob', TRUE);
			$pass1 = 'expo_'.rand(5000, 9999);
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
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
					
				$insertdata = array(
							  'CLIENT_NAME'=> $fname ,
							  'CLIENT_SURNAME'=> $sname ,
							   'CLIENT_EMAIL'=> $email,
							   'CLIENT_CELLPHONE'=> $cell, 
							  'CLIENT_PASSWORD'=> $this->hash_password($email,$pass1),
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
					
					
				
				$this->db->where('CLIENT_EMAIL' , $email);
				$this->db->from('u_client');
				$query = $this->db->get();
					
					
					
					$this->db->insert('u_client', $insertdata);
					//get ID
					$this->db->where('CLIENT_EMAIL' , $email);
					$this->db->from('u_client');
					$query = $this->db->get();
					$row = $query->row_array();
					$member_id = $row['ID'];	
					$this->session->set_userdata('id', $row['ID']);
					$this->session->set_userdata('u_name', $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] );
					
					
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
					$data['confirm_link'] = site_url('/') . 'members/activate/'.$member_id;
					//SEND EMAIL LINK
					$this->load->model('email_model');	
					$this->email_model->send_register_link($data);
					//success redirect		
					$data['basicmsg'] = 'Thank you, ' . $fname .' you have successfully registered.';
					
					//CONNECT USER TO BUSINESS
					//CLICK BUTTON
					//BUSINESS_ID = 5916 // Warehouse Theatre
					//$this->my_na_click('5916', $member_id);
					//BUSINESS_ID = 514 // CYMOT
					$this->my_na_click('514', $member_id);
					
					
					
					//INSERT REP TABLE for TRACKING
					$insertdata2 = array(
							  'rep_id'=> $rep_id,
							  'client_id'=> $member_id
					);
					$this->db->insert('scratch_rep_promo', $insertdata2);
					
					echo '<div class="alert">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
							
								step3.hide();
								step4.slideDown("fast");
								$(".keyboard > ul").hide();
					</script>
					';
					
				}
			
			}else{
					
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
			
			}
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//na BUSINESS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 function my_na_click($bus_id, $client_id) {
		
		$query = $this->db->query("select * FROM u_business_na  
					WHERE CLIENT_ID = '".$client_id."' AND BUSINESS_ID = '".$bus_id."'");
						   
		if($query->num_rows() == 0){		   
				
				$data = array(
						
						'BUSINESS_ID' => $bus_id,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_business_na',$data);
				
				//UPDATE CLIENT POINTS
				$this->update_client_point($client_id, '10', $bus_id, 'na');
				
				
				
		}else{
			
		
		}
	}
	
	 //UPDATE USER POINTS
	function update_client_point($client_id, $points, $bus_id, $type) {
		
		$this->db->where('CLIENT_ID',$client_id);
	   
				
				$data = array(
						
						'BUSINESS_ID' => $bus_id,
						'POINTS' => $points,
						'TYPE' => $type,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_client_points',$data);
				
				//UPDATE SUMMARY TABLE
				$this->update_client_point_summary($client_id, $points);

	}
	
	
	//UPDATE USER POINTS SUMMARY
	function update_client_point_summary($client_id, $points) {
		
		$this->db->where('CLIENT_ID',$client_id);
		$query = $this->db->get('u_client_points_summary');
						   
		if($query->num_rows() == 0){		   
				
				if($points < 0){
					
					$points = 0;
				
				}
				$data = array(
						
						'POINTS' => $points,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_client_points_summary',$data);
				
				
		}else{

			
			$query = $this->db->query("UPDATE u_client_points_summary SET POINTS = GREATEST(POINTS + ".$points." ,0) WHERE CLIENT_ID = '".$client_id."'");
		}	
		$this->session->set_userdata('points',$points);
		
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
	
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */