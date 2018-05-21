<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Win extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	function Win()
	{
		parent::__construct();
        $this->load->model('members_model');
		$this->load->model('scratch_model');
	}

	
	
	public function index()
	{
		if($this->session->userdata('id')){
			 	
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/scratch_win', $data);	
		
		}else{
			
				$this->logout();
			  
		 }
	}
	
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN EXPO 2013
	//++++++++++++++++++++++++++
	public function cymot($id = '')
	{
		//echo $id;
		//if($this->session->userdata('id')){
			 	$data['rep_id'] = 1;//$id; 
				$data['id'] = $this->session->userdata('id');
				$this->load->view('expo/scratch_win', $data);	
		
		//}else{
			
				//redirect('/members/logout', 'refresh');
			  
		// }
	}
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN EXPO 2013 SHOW WINNER
	//++++++++++++++++++++++++++
	public function winners($id = '')
	{
		//echo $id;
		//if($this->session->userdata('id')){
			 	
				$query = $this->db->query("SELECT * FROM `scratch_plays`
								JOIN u_client ON scratch_plays.CLIENT_ID = u_client.ID
								WHERE scratch_plays.PROMOTION_ID = '3' ORDER BY RAND() LIMIT 1", FALSE);
				$data = $query->row();
				
				$this->load->view('expo/scratch_win_winner', $data);	
		
		//}else{
			
				//redirect('/members/logout', 'refresh');
			  
		// }
	}
	//+++++++++++++++++++++++++++
	//LOAD EXPO 2013 Scratch Game
	public function load_expo($rep_id = '')
	{
		  
		  //echo $rep_id;
		  $this->load->model('scratch_model_external');
		  //CHECK IF PROMOTION
		  if($this->scratch_model->checkPromotionExpired(3)){
			  
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
			  $valid = $this->scratch_model_external->canUserWinPrize('3');
			  if($valid['bool'] == TRUE){
					  
				  //WON PRIZE
				  
				  
			  }
			  
			  $data['bool'] = $valid['bool']; // set the winning variable
			  $data['img_file'] = $valid['img_file']; // set the scratch Image
			  $data['prize_id'] = $valid['prize_id']; // set the prize_id
			  $data['promo_id'] = $valid['promo_id']; // set the promo_id
			  $data['coupon'] = $valid['coupon']; // set the promo_id
			  $data['rep_id'] = $rep_id; // set the promo_id
			  
			  
		 	  $this->load->view('expo/scratch_win_inc_ipad', $data);	
					
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */