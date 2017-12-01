<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Volleyball extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function Volleyball($rep_id = '')
	{
		parent::__construct();
		$this->load->model('members_model');
		$this->load->model('scratch_model');
	}
	
	
	public function index($rep_id = '')
	{
		$data['promo_id'] = '6';
		$this->load->view('win/scratch_win', $data);	
	}
	
	
	public function display()
	{
	
		$this->load->view('win/display');	
	}
	
	
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN VOLLEYBALL 2014
	//++++++++++++++++++++++++++
	public function winners($id)
	{
		//echo $id;
		//if($this->session->userdata('id')){
			 	
				$query = $this->db->query("SELECT * FROM `scratch_plays`
								JOIN u_client ON scratch_plays.CLIENT_ID = u_client.ID
								WHERE scratch_plays.PROMOTION_ID = '".$id."' ORDER BY RAND() LIMIT 1", FALSE);
				$data = $query->row();
				
				$this->load->view('win/scratch_win_winner', $data);	
		
		//}else{
			
				//redirect('/members/logout', 'refresh');
			  
		// }
	}
	//+++++++++++++++++++++++++++
	//LOAD GAME
	public function load_game($promo_id)
	{
		  $rep_id =0;
		  //echo $rep_id;
		  $this->load->model('scratch_model_external');
		  //CHECK IF PROMOTION
		  if($this->scratch_model->checkPromotionExpired($promo_id)){
			  
			  //NO PROMOTIONS 	
			  echo '<div class="alert alert-block">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<h3>No Game Available</h3>
						<strong>Sorry!</strong> There are no current Scratch and Win promotions available<br /><br />
						Please try again tomorrow.
					</div>';	
			  //NO PROMOTIONS -- END DIE
			  die();	
			  
		  }else{
		  
		  
		  
			  //GET WINNING CHANCE AND IMAGE
			  $valid = $this->scratch_model_external->canUserWinPrize($promo_id);
			  if($valid['bool'] == TRUE){
					  
				  //WON PRIZE
				  
				  
			  }
			  
			  $data['bool'] = $valid['bool']; // set the winning variable
			  $data['img_file'] = $valid['img_file']; // set the scratch Image
			  $data['prize_id'] = $valid['prize_id']; // set the prize_id
			  $data['promo_id'] = $valid['promo_id']; // set the promo_id
			  $data['coupon'] = $valid['coupon']; // set the promo_id
			  $data['rep_id'] = $rep_id; // set the promo_id
			  
			  
		 	  $this->load->view('win/scratch_win_inc', $data);	
					
		  }
		
	}
	
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN
	//++++++++++++++++++++++++++
	public function scratch_and_win()
	{
		//CHECK SESSION
		if($this->session->userdata('id')){
			 	
				
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/scratch_win', $data);
	
		
		}else{
			
				redirect('/members/logout', 'refresh');
			  
		 }
		
		
	}	
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN
	//++++++++++++++++++++++++++
	public function scratch_and_win_test()
	{
		//CHECK SESSION
		if($this->session->userdata('id')){
			 	
				//LOAD SCRATCH WIN MODEL
				$this->load->model('scratch_model');
				
				//CHECK IF PROMOTION
				if($this->scratch_model->checkPromotionExpired('1')){
						
					//NO PROMOTIONS -- END DIE
					die();	
					
				}
				
				//GET WINNING CHANCE RATIO
				
				if($this->scratch_model->canUserWinPrize_test('1')){
						
					//WON PRIZE
					$this->scratch_model->canUserWinPrize_test('1');
					
				}
				
				
				echo '<div class="alert alert-success">
						  <button type="button" class="close" data-dismiss="alert">&times;</button>
						  <strong>Notice!</strong> Member account has been updated successfully
					  </div>';
				//LOAD VIEW
				//$data['id'] = $this->session->userdata('id');
				//$this->load->view('members/scratch_win', $data);
	
		
		}else{
			
				redirect('/members/logout', 'refresh');
			  
		 }
		
		
	}
	//+++++++++++++++++++++++++++
	//LOAD
	public function load_scratch_win()
	{
		
		if($this->session->userdata('id')){
			 	
				//CHECK IF PROMOTION
				if($this->scratch_model->checkPromotionExpired('1')){
					
					//NO PROMOTIONS 	
					echo '<div class="alert alert-block">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <h3>No Game Available</h3>
							  <strong>Sorry!</strong> There are no current Scratch and Win promotions available<br /><br />
							  Please try again tomorrow.
						  </div>';	
					//NO PROMOTIONS -- END DIE
					die();	
					
				}
				
				$data['id'] = $this->session->userdata('id');
				//IF USER HAS ENOUGH POINTS
				if($this->get_points_test($data['id']) > 9){
					
					//GET WINNING CHANCE AND IMAGE
					$valid = $this->scratch_model->canUserWinPrize('1');
					if($valid['bool'] == TRUE){
							
						//WON PRIZE
						
						
					}
					
					$data['bool'] = $valid['bool']; // set the winning variable
					$data['img_file'] = $valid['img_file']; // set the scratch Image
					$data['prize_id'] = $valid['prize_id']; // set the prize_id
					$data['promo_id'] = $valid['promo_id']; // set the promo_id
					$data['coupon'] = $valid['coupon']; // set the promo_id
					$this->load->view('members/inc/scratch_win_inc', $data);	
					
				}else{
					
					//NOT ENOUGH POINTS	
					echo '<div class="alert alert-block">
							  <button type="button" class="close" data-dismiss="alert">&times;</button>
							  <h3>Not Enough Points</h3>
							  <strong>Sorry!</strong> You do not have enough points to play scratch and win today. Please review some businesses and connect with them to 
							  earn some points.<br /><br />
							  <ul>
							  	<li><font class="na_script" style="font-size:20px">!na</font> a business to receive 1 point</li>
								<li>Leave a business review and gain 3 points</li>
							  </ul>
							  <br /><br />
							  <a href="'.site_url('/').'a/results/" class="btn btn-inverse pull-right"><i class="icon-comment"></i> Review Businesses</a><br /><br />
						  </div>';
					
				}
				
	
		
		}else{
			
				redirect('/members/logout', 'refresh');
			  
		 }
		
		
	}
	
	//+++++++++++++++++++++++++++
	//GET MEMBER POINTS
	//+++++++++++++++++++++++++++
	public function get_points_test($id)
	{
		
		$this->db->where('CLIENT_ID', $id);
		$query = $this->db->get('u_client_points_summary');
		if($query->result()){
			
			$row = $query->row_array();
			return $row['POINTS'];	
			
		}else{
			
			return '0';
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//GET MEMBER POINTS
	//+++++++++++++++++++++++++++
	public function get_points($id)
	{
		
		$this->my_na_model->show_points();
		
	}
	//+++++++++++++++++++++++++++
	//GET MEMBER POINTS
	//+++++++++++++++++++++++++++
	public function get_points_sml($id)
	{
		
		$this->my_na_model->show_points($id);

	}
	
	
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN - CLAIM PRIZE
	//++++++++++++++++++++++++++
	public function claim_scratch_win()
	{
		//CHECK SESSION
		if($this->session->userdata('id')){
			 	
				//GET USER ID
				$data['id'] = $this->session->userdata('id');
				//GET PRIZE ID's
				$prize_id = $this->input->post('prize_id',TRUE);
				$prize_img = $this->input->post('prize_img',TRUE);
				$promo_id = $this->input->post('promo_id',TRUE);
				$coupon = $this->input->post('coupon',TRUE);
				
				//SEND NOTIFICATIONS 
				$this->scratch_model->sendWinNotifications($prize_id, $promo_id, $data['id'], $coupon, $prize_img);
				
				$this->session->set_flashdata('msg', 'Wohoo!, Congratulations on winning your prize. We have sent further instructions to your inbox.');
				echo '<div class="alert">
                     	<button type="button" class="close" data-dismiss="alert">×</button>
                        	Processing your prize...Please be patient
                      </div>
						
					  <script type="text/javascript">
						
						window.location = "'.site_url('/').'win/scratch_and_win/";
					  </script>';
				
		
		}else{
			
				redirect('/members/logout', 'refresh');
			  
		 }
		
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE DEAL
	public function update_prize($prize_id)
	{
		
		$this->db->where('ID', $prize_id);
		$query = $this->db->get('scratch_prizes');
		if($query->result()){
			$row = $query->row_array();
			
			
			$this->load->view('admin/inc/scratch_win_prize', $row);
			
		}else{
			
			echo '<div class="alert">
					<h3>Deal not found</h3> The prize could not be found</div>';
			
		}
	 	

		
	}
	
	//+++++++++++++++++++++++++++
	//ADD NEW Prize
	public function add_prize()
	{
		
			$this->scratch_model->add_prize();
			
		
		
	}	
	//+++++++++++++++++++++++++++
	//UPDATE PROMOTION
	public function update_promo()
	{
		$data['START_DATE'] = $this->input->post('dpstart', TRUE);
		$id = $this->input->post('promo_id', TRUE);
		$data['END_DATE'] = $this->input->post('dpend', TRUE);
		$data['THROTTLE'] = $this->input->post('throttle', TRUE);
		
		$this->db->where('ID', $id);
		$this->db->update('scratch_promotion', $data);	
		echo '<div class="alert">Promotion has been updated</div>';
		
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
					
					//TEST IF PLAYED TODAY
					$this->db->where('CLIENT_ID',$row['ID']);
					$this->db->where('PROMOTION_ID',6);
					$hasplayed = $this->db->get('scratch_plays'); 
					
//					if($hasplayed->result()){
//						
//						echo '<div class="alert alert-block">
//							<h3>Not So fast!</h3>
//							You are only allowed to play the game once every day!
//							</div>';	
//						die();
//					}
					
					
					
					
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
								//$(".keyboard > ul").hide();
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

		$this->load->view('win/register');
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
								//$(".keyboard > ul").hide();
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