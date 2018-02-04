<?php
class Scratch_model extends CI_Model{
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function scratch_model(){
  		//parent::Model();
		self::__construct();			
 	}
	//+++++++++++++++++++++++++++
	//SCRATCH & WIN MODEL
	//
	// 
	// Roland Ihms
	//++++++++++++++++++++++++++
	
    // find out if promotion has been expired or not
    public function checkPromotionExpired($promo_id) 
    {
        //GET PROMOTIONS
		$this->db->where('ID', $promo_id);
		$query = $this->db->get('scratch_promotion');
		
		if($query->result()){
			
			$promotion = $query->row_array();
			$endDate = strtotime($promotion['END_DATE']);
			if($endDate > time()) {
	
				return FALSE;
			}elseif(strtotime($promotion['START_DATE']) > time()){
				//NOT STARTED YET
				return TRUE;
			}else{
				//ALREADY EXPIRED
				return TRUE;
			}
			
		}else{
			
			return TRUE;
		}
		
        
    }
	
	//+++++++++++++++++++++++++++
	//GET PROMOTION DATE
	//++++++++++++++++++++++++++
	
    public function getPromotionDate($promo_id) 
    {
        //GET PROMOTIONS
		//$this->db->where('ID', '1');
		$query = $this->db->query("SELECT  THROTTLE, START_DATE,  END_DATE FROM `scratch_promotion` WHERE ID = '".$promo_id."'");
		
		if($query->result()){
			
			$promotion = $query->row_array();
			$endDate['END_DATE'] = $promotion['END_DATE'];
			$endDate['START_DATE'] = $promotion['START_DATE'];
			$endDate['THROTTLE'] = $promotion['THROTTLE'];
			if(strtotime($endDate['END_DATE']) > time()) {
	
				return $endDate;
				die();
			}else{
				
				return false;	
				
			}
			
		}else{
			
			return false;
			
		}
		
        
    }
	
	//+++++++++++++++++++++++++++
	//DO CALCULATIONS TO SEE IF USER CAN WIN
	//++++++++++++++++++++++++++
	
    public function canUserWinPrize_test($promo_id) 
    {
    
	   //$promo_id = '1';
	   //GET PROMOTION DATE
		$promoDate = $this->getPromotionDate($promo_id);
		
		//GET PROMO DURATION
		$promostart = new DateTime($promoDate['START_DATE']);
		$promoend = new DateTime($promoDate['END_DATE']);
		$now = new DateTime();
		$duration1 = $promostart->diff($promoend);
		$duration = $duration1->i;
		$PROMOminutes = $duration1->days * 24 * 60;
		$PROMOminutes += $duration1->h * 60;
		$PROMOminutes += $duration1->i;
		echo $PROMOminutes.' minutes   '. $duration1->d . ' days<br />';
		
		
		//GET MINUTES LEFT
		$timeLeft1 = $promoend->diff($now);
		$timeLeft =  $timeLeft1->days * 25 * 60;
		$timeLeft += $timeLeft1->h * 60;
		$timeLeft += $timeLeft1->format('%i');
		
		//GET DAYS LEFT
		$daysLeft1 = $promoend->diff($now);
		$daysLeft  = $daysLeft1->d;

		
		//TOTAL WINNERS TODAY
		$winnersToday = $this->getTodayWinners($promo_id);
		
		//LAST WINNER TIME
		$lastWin = $this->getLastWinner($promo_id);
		//LAST WINNER TIME IN MINUTES
		$lastwin1 = new DateTime($lastWin);
		$lastwin2 = $lastwin1->diff($now);
		$lastWinMin =  $lastwin2->days * 25 * 60;
		$lastWinMin += $lastwin2->h * 60;
		//$lastWinMin += $lastwin2->i + 60;
		$lastWinMin += $lastwin2->i;
		

		//GET PRIZE
		$prize = $this->nextPrize($promo_id);
		
		//WINS PER DAY
		//TOTAL quantirty of all prizes
		//$perDay = ($prize['QUANTITY'] / $duration);
		//$perDay = ($prize['total'] / $duration1->days);
		
		//SEE if 0 days left
		if($daysLeft < 1){
			
			$perDay = ($prize['total'] / 1);
			
		}else{
			
			$perDay = ($prize['total'] / $daysLeft);
			
		}
		
		
		//GET PRIZE NEXT WIN TIME INTERVAL
		//12 hours per day == 720 minutes 
		//16 hours per day == 960 minutes
		//8 hours per day == 960 minutes 
		$timeInterval = ($promoDate['THROTTLE'] / $perDay);
		//BUILD UNIQUE COUPON
		$coupon = rand(0,9999).'_'.$prize['NAME'].'_'. $prize['BUSINESS_ID'] .'_'. $prize['QUANTITY'] .'_'. $prize['ID'];
		
		echo 'PROMOTION ID :' .$prize['PROMOTION_ID']. ' <br />Current Throttle: '.$promoDate['THROTTLE']. '<br />Quantity TOTAL: '.$prize['total'].'<br />
		Promotion Days left: ' .$daysLeft . '  
		Minutes Left: ' . $timeLeft . ' seconds Left: ' . ($timeLeft * 60). '<br />
		
		Todays Winners: ' . $winnersToday . '<br /> Last Win Time: ' .$lastWin . ' - ' .date('Y-m-d h:i:s').  '<br /> 
		Last win ago in minutes: ' . $lastWinMin . '<br /> 
		Per Day: '.$perDay. '<br /> 
		Allowed time Interval: '.$timeInterval;
		
		
		echo '<br /> Quantity: '.$prize['QUANTITY'] . '<br /> Original Q: ' .$this->nextPrizeCountOriginal($prize['ID'],$prize['QUANTITY']);
		
		$q      = $prize['QUANTITY'];
		$totalQ = $this->nextPrizeCountOriginal($prize['ID'],$prize['QUANTITY']);

			
		//START LOGIC
		
			
	
		
		
		//If played x amounts and in tmp win table
		if($this->getTotalPlaysToday($promo_id)){
		
			//PRIZE WON
			//deduct Quantity and set Winner
			//$this->iAmWinner($prize['ID'],$prize['PROMOTION_ID'], $coupon);
			
			echo 'WIN TEMP';
			
		//If already won today 
		//}elseif($this->hasUserWonToday()){
//		
//			echo 'NO WIN - Already WON TODAY';
			//die();
		
		
		}elseif($promoDate === false){
			
			echo 'NO WIN - EXPIRED';
			
		//if daily target not met
		}elseif($winnersToday < $perDay)	{
		
			//check if time last won is bigger than todays limit
			if($lastWinMin > $timeInterval){
				
				//PRIZE WON
				//deduct Quantity and set Winner
				//$this->iAmWinner($prize['ID'],$prize['PROMOTION_ID'], $coupon);
				
				echo 'WIN';
				
			}else{
				
				//NO WIN
				echo 'NO WIN';	
			}
			
			
		}else{
		
			//NO WIN
			echo 'NO WIN';
		}
		
		
    }//end canUserWinPrize();
	
	
	//+++++++++++++++++++++++++++
	//DO CALCULATIONS TO SEE IF USER CAN WIN
	//++++++++++++++++++++++++++
	
    public function canUserWinPrize($promo_id) 
    {
       //$promo_id = '1';
		
		//GET PROMOTION DATE
		$promoDate = $this->getPromotionDate($promo_id);
		
		//GET PROMO DURATION
		$promostart = new DateTime($promoDate['START_DATE']);
		$promoend = new DateTime($promoDate['END_DATE']);
		$now = new DateTime();
		$duration1 = $promostart->diff($promoend);
		$duration = $duration1->i;
		$PROMOminutes = $duration1->days * 24 * 60;
		$PROMOminutes += $duration1->h * 60;
		$PROMOminutes += $duration1->i;

		
		//GET MINUTES LEFT
		$timeLeft1 = $promoend->diff($now);
		$timeLeft =  $timeLeft1->days * 25 * 60;
		$timeLeft += $timeLeft1->h * 60;
		$timeLeft += $timeLeft1->i;
		
		//GET DAYS LEFT
		$daysLeft1 = $promoend->diff($now);
		$daysLeft  = $daysLeft1->d;

		
		//TOTAL WINNERS TODAY
		$winnersToday = $this->getTodayWinners($promo_id);
		
		//LAST WINNER TIME
		$lastWin = $this->getLastWinner($promo_id);
		//LAST WINNER TIME IN MINUTES
		$lastwin1 = new DateTime($lastWin);
		$lastwin2 = $lastwin1->diff($now);
		$lastWinMin =  $lastwin2->days * 25 * 60;
		$lastWinMin += $lastwin2->h * 60;
		//$lastWinMin += $lastwin2->i + 60;
		$lastWinMin += $lastwin2->i;
		
		//GET PRIZE
		$prize = $this->nextPrize($promo_id);
		
		//WINS PER DAY
		//TOTAL quantirty of all prizes
		//$perDay = ($prize['QUANTITY'] / $duration);
		//$perDay = ($prize['total'] / $duration1->days);
		
		//SEE if 0 days left
		if($daysLeft < 1){
			
			$perDay = ($prize['total'] / 1);
			
		}else{
			
			$perDay = ($prize['total'] / $daysLeft);
			
		}

		//GET PRIZE NEXT WIN TIME INTERVAL
		//12 hours per day == 720 minutes 
		//16 hours per day == 960 minutes
		//8 hours per day == 480 minutes 
		$timeInterval = (720 / $perDay);
		
		//ARRAY TO SAVE AND RETURN VALUES
		$valid = array();
		$valid['bool'] = false;
		
		//BUILD UNIQUE COUPON
		$coupon = rand(0,9999).'_'.$prize['NAME'].'_'. $prize['BUSINESS_ID'] .'_'. $prize['QUANTITY'] .'_'. $prize['ID'];  
			
		//START LOGIC
		//If played x amounts and in tmp win table
		if($this->getTotalPlaysToday($promo_id)){
		
				//PRIZE WON
				//deduct Quantity and set Temp Winner
				$coupon = $coupon.'tmp';
				$this->iAmWinner_temp('22','1', $coupon);
				
				$valid['bool'] = TRUE;			
				$valid['prize_id'] = '22';
				$valid['promo_id'] = '1';
				$valid['coupon'] = '10 !na points tmp';
				//GET WINNING IMAGE
				$valid['img_file'] = 'raw/price_win_10points.jpg';
				$coupon = '10 !na points tmp';	
				//UPDATE SCRATCH PLAYS TABLE - DEDUCT 10 POINTS
				$this->log_new_play($prize['ID'],$prize['PROMOTION_ID'], $valid['img_file'], $coupon);	
		
		//If already won today 
		}elseif($this->hasUserWonToday($promo_id)){
		
			//PRIZE WON
				//deduct Quantity and set Temp Winner
				$coupon = 'Over limit for today';

				$valid['bool'] = FALSE;			
				$valid['prize_id'] = '0';
				$valid['promo_id'] = '1';
				$valid['coupon'] = 'Over limit for today';
				//GET WINNING IMAGE
				$valid['img_file'] = 'price_lost_'.rand(1,79).'.jpg';

				//UPDATE SCRATCH PLAYS TABLE - DEDUCT 10 POINTS
				$this->log_new_play($prize['ID'],$prize['PROMOTION_ID'], $valid['img_file'], $coupon);	
		
		
		//if daily target not met
		}elseif($winnersToday < $perDay)	{
		
			//check if time last won is bigger than todays limit
			if($lastWinMin > $timeInterval){
				
				//PRIZE WON
				//deduct Quantity and set Winner
				$this->iAmWinner($prize['ID'],$prize['PROMOTION_ID'], $coupon);
				
				$valid['bool'] = TRUE;			
				$valid['prize_id'] = $prize['ID'];
				$valid['promo_id'] = $prize['PROMOTION_ID'];
				$valid['coupon'] = $coupon;
				//GET WINNING IMAGE
				$valid['img_file'] = 'raw/'.$prize['IMAGE_URL'];
				
				//UPDATE SCRATCH PLAYS TABLE - DEDUCT 10 POINTS
				$this->log_new_play($prize['ID'],$prize['PROMOTION_ID'], $valid['img_file'], $coupon);
				
				
			}else{
				
				//NO WIN
				$valid['bool'] = FALSE;
				$valid['prize_id'] = $prize['ID'];
				$valid['promo_id'] = $prize['PROMOTION_ID'];
				$valid['coupon'] = $coupon;
				$valid['img_file'] = 'price_lost_'.rand(1,79).'.jpg';
				$coupon = 'no coupon';	
				//UPDATE SCRATCH PLAYS TABLE - DEDUCT 10 POINTS
				$this->log_new_play($prize['ID'],$prize['PROMOTION_ID'], $valid['img_file'], $coupon);	
			}
			
			
		}else{
		
			//NO WIN
			$valid['bool'] = FALSE;
			$valid['prize_id'] = $prize['ID'];
			$valid['promo_id'] = $prize['PROMOTION_ID'];
			$valid['coupon'] = $coupon;
			$valid['img_file'] = 'price_lost_'.rand(1,79).'.jpg';
			
			$coupon = 'no coupon';	
			//UPDATE SCRATCH PLAYS TABLE - DEDUCT 10 POINTS
			$this->log_new_play($prize['ID'],$prize['PROMOTION_ID'], $valid['img_file'], $coupon);
		}
		

		
		return $valid;
		
    }//end canUserWinPrize();
	
	
	
	//+++++++++++++++++++++++++++
	//USER WON PRIZE WOHOO!!
	//++++++++++++++++++++++++++
	
    public function iAmWinner($prizeID,$promoID, $coupon) 
    {
        //deduct quantity and set winner record
		//BUILD INSERT ARRAY
		$data = array(
						'CLIENT_ID' => $this->session->userdata('id'),
						'PRIZE_ID' => $prizeID,
						'HAS_CLAIMED' => '0',
						'PROMOTION_ID' => $promoID,
						'CREATED_AT' => date('y-m-d G:i:s', time()),
						'COUPON' => $coupon
					);
		//INSERT Winner			
		$this->db->insert('scratch_winners', $data);
		
		//ADD POINTS WHEN USER WINS !na POINTS AUTOMATICALLY
		if($prizeID == '21'){
			
			$this->update_client_point($this->session->userdata('id'), '20', 'scratch_win_20points');	
			
		}elseif($prizeID == '22'){
			
			$this->update_client_point($this->session->userdata('id'), '10', 'scratch_win_10points');
		}
		
		//UPDATE QUANTITY
		$this->db->query("UPDATE scratch_prizes SET QUANTITY = QUANTITY - 1 WHERE ID ='".$prizeID."'",FALSE);
		
		
    }
	
	//+++++++++++++++++++++++++++
	//USER WON TEMP PRIZE 
	//++++++++++++++++++++++++++
	
    public function iAmWinner_temp($prizeID,$promoID, $coupon) 
    {
        //deduct quantity and set winner record
		//BUILD INSERT ARRAY
/*		$data = array(
						'CLIENT_ID' => $this->session->userdata('id'),
						'PRIZE_ID' => $prizeID,
						'HAS_CLAIMED' => '0',
						'PROMOTION_ID' => $promoID,
						'CREATED_AT' => date('y-m-d G:i:s', time()),
						'COUPON' => $coupon
					);
		//INSERT Winner			
		$this->db->insert('scratch_winners', $data);*/
		
		//ADD POINTS WHEN USER WINS !na POINTS AUTOMATICALLY
		if($prizeID == '21'){
			
			$this->update_client_point($this->session->userdata('id'), '20', 'scratch_win_20points_tmp');	
			
		}elseif($prizeID == '22'){
			
			$this->update_client_point($this->session->userdata('id'), '10', 'scratch_win_10points_tmp');
		}
		
		//UPDATE QUANTITY
		//$this->db->query("UPDATE scratch_prizes SET QUANTITY = QUANTITY - 1 WHERE ID ='".$prizeID."'",FALSE);
		
		
    }
	//+++++++++++++++++++++++++++
	//GET ALL WINNERS FOR TODAY
	//++++++++++++++++++++++++++
	
    public function getTodayWinners($promo_id) 
    {
        //GET TOTAL TODAYS WINNERS
		$date = (date("Y-m-d")); 
		
		$query = $this->db->query("SELECT COUNT(ID) as total FROM scratch_winners  
					WHERE DATE_FORMAT(CREATED_AT,'%Y-%m-%d') = '".$date."' AND PROMOTION_ID = '".$promo_id."'");
		if($query->result()){
			
			$row = $query->row_array();
			return $row['total'];
			
		}else{
			
			return 0;
			
		}
		 			
		
    }
	
	//+++++++++++++++++++++++++++
	//HAS USER WON A PRIZE TODAY
	//++++++++++++++++++++++++++
	
    public function hasUserWonToday($promo_id) 
    {
        //GET TOTAL TODAYS WINNERS
		$date = (date("Y-m-d")); 
		
		$query = $this->db->query("SELECT ID FROM scratch_winners  
					WHERE CLIENT_ID = '".$this->session->userdata('id')."' AND DATE_FORMAT(CREATED_AT,'%Y-%m-%d') = '".$date."' AND PROMOTION_ID = '".$promo_id."'");
		if($query->result()){
			
			return TRUE;
		}else{
			
			return FALSE;
			
		}
		 			
		
    }
	
	//+++++++++++++++++++++++++++
	//GET TIME LAST PRIZE WAS WON
	//++++++++++++++++++++++++++
	
    public function getLastWinner($promo_id) 
    {
        //GET TOTAL TODAYS WINNERS
		$date = (date("Y-m-d")); 
		
		//$query = $this->db->query("SELECT CREATED_AT FROM scratch_winners  
//					WHERE DATE_FORMAT(CREATED_AT,'%Y-%m-%d') = '".$date."' ORDER BY CREATED_AT DESC");
		$query = $this->db->query("SELECT CREATED_AT FROM scratch_winners WHERE PROMOTION_ID = '".$promo_id."' 
					              ORDER BY CREATED_AT DESC LIMIT 1");
		if($query->result()){
			
			$row = $query->row_array();
			return $row['CREATED_AT'];
			
		}else{
			
			return date('1999-01-01');
		}
		 			
		
    }
	
	//+++++++++++++++++++++++++++
	//GET TOTAL PLAYS FOR USER TODAY
	//++++++++++++++++++++++++++
	
    public function getTotalPlaysToday($promo_id) 
    {
        
		$data['CLIENT_ID'] = $this->session->userdata('id');
		$data['PROMOTION_ID'] = '1';
		
		$this->db->insert('scratch_tmp_winners', $data);
		
		//GET TOTAL TODAYS PLAYS FOR USER

		//GET LAST 2 HOURS 
		//SELECT * FROM scratch_plays WHERE CLIENT_ID = 1 AND `CREATED_AT` > SUBDATE( CURRENT_TIMESTAMP, INTERVAL 2 HOUR)
		//GET TODAY
		//SELECT * FROM scratch_plays WHERE CLIENT_ID = 1 AND DATE(CREATED_AT) = DATE(NOW())
		//$query = $this->db->query("SELECT * FROM scratch_plays WHERE CLIENT_ID = '".$this->session->userdata('id')."' AND DATE(CREATED_AT) = DATE(NOW())");
		
		$query = $this->db->query("SELECT * FROM scratch_tmp_winners WHERE CLIENT_ID = '".$this->session->userdata('id')."' AND DATE(DATETIME) = DATE(NOW()) AND PROMOTION_ID = '".$promo_id."'");
		if($query->result()){
			//IF MORE THAN x Times played
			if($query->num_rows() > 4){
				
				//Delete tmp table
				$this->db->where('CLIENT_ID', $this->session->userdata('id'));
				$this->db->delete('scratch_tmp_winners');
				
				return TRUE;
				
			}else{
				
				return FALSE;
			}
			
		}else{
			
			return FALSE;
			
		}
		 			
		
    }
	//+++++++++++++++++++++++++++
	//GET ALL PRIZES
	//++++++++++++++++++++++++++
	
    public function prizes() 
    {
        //GET PRIZES
		$query = $this->db->get('scratch_prizes');
		//IF PRIZES AVAILABLE
		if($query->result()){
			
			//LOOP THROUGH ECH PRIZE
			$prizes = array();
			$x = 0;
			foreach($query->result() as $row){
				
				$prizes[$x] = $row;
				$x++; 
					
			}
			return $prizes;

			
		}//end if prizes available
		return '';
    }//end prizes();
	
	//+++++++++++++++++++++++++++
	//GET NEXT PRIZE
	//++++++++++++++++++++++++++
	
    public function nextPrize($promo_id) 
    {
        //GET PRIZE
		//quantity
		/*$query = $this->db->query("SELECT scratch_prizes.ID, scratch_prizes.PROMOTION_ID, scratch_prizes.NAME,scratch_prizes.IMAGE_URL,  scratch_prizes.QUANTITY,
							  	 scratch_promotion.NAME,scratch_promotion.BUSINESS_ID FROM scratch_prizes
 								 JOIN scratch_promotion ON scratch_prizes.PROMOTION_ID = scratch_promotion.ID WHERE scratch_prizes.IS_ACTIVE = 1 AND scratch_prizes.QUANTITY > 0
 								 ORDER BY scratch_prizes.QUANTITY DESC LIMIT 1", FALSE);*/
		 //random
		 $query = $this->db->query("SELECT scratch_prizes.ID, scratch_prizes.PROMOTION_ID, scratch_prizes.NAME,scratch_prizes.IMAGE_URL,  scratch_prizes.QUANTITY,
							  	 scratch_promotion.NAME,scratch_promotion.BUSINESS_ID FROM scratch_prizes
 								 JOIN scratch_promotion ON scratch_prizes.PROMOTION_ID = scratch_promotion.ID WHERE scratch_prizes.IS_ACTIVE = 1 AND scratch_prizes.QUANTITY > 0
 								 AND PROMOTION_ID = '".$promo_id."' ORDER BY RAND() LIMIT 1", FALSE);
		//IF PRIZES AVAILABLE
		if($query->result()){
			
			$query_Quantity = $this->db->query("SELECT SUM(scratch_prizes.QUANTITY) as total
 											   FROM scratch_prizes WHERE IS_ACTIVE = 1 AND PROMOTION_ID = '".$promo_id."'", FALSE);
			$total = $query_Quantity->row_array();
			$prize = $query->row_array();
			$prize['total'] = $total['total'];	
		
			return $prize;

			
		}//end if prizes available
		return '';
    }
	
	//+++++++++++++++++++++++++++
	//GET ORIGINAL QUANTITY
	//++++++++++++++++++++++++++
    public function nextPrizeCountOriginal($prize_id, $currQ) 
    {
        //GET PRIZES
		$this->db->where('PRIZE_FK', $prize_id);
		$query = $this->db->get('scratch_plays');
		
		return $query->num_rows() + $currQ;
    }

	//+++++++++++++++++++++++++++
	//LOG NEW PLAY AND DEDUCT POINTS
	//++++++++++++++++++++++++++
    public function log_new_play($prizeID, $promoID, $img_file , $coupon) 
    {
        //BUILD INSERT ARRAY
		$data = array(
						'CLIENT_ID' => $this->session->userdata('id'),
						'PRIZE_IMAGE_URL' => $img_file,
						'PRIZE_FK' => $prizeID,
						'PROMOTION_ID' => $promoID,
						'COUPON' => $coupon,
						'CREATED_AT' => date('y-m-d h:i:s', time())
					);
		//INSERT DATA			
		$this->db->insert('scratch_plays', $data);
		
		//DEDUCT POINTS			
		$this->update_client_point($this->session->userdata('id'), '-10', 'scratch');
		
    }


    //UPDATE USER POINTS
	function update_client_point($client_id, $points, $type) {
	   
				
		  $data = array(
				  
				  'BUSINESS_ID' => 0,
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
		
	}



	//+++++++++++++++++++++++++++
	//SEND WINNER NOTIFICATIONS
	//++++++++++++++++++++++++++
    public function sendWinNotifications($prize_id, $promo_id, $user_id, $coupon, $prize_img)
    {
        //GET WINNER DETAILS
		$user = $this->getUser($user_id);
		//GET PRIZE DETAILS
		$prize = $this->getPrize($prize_id);
		
		//GET PROMOTION BUSINESS DETAILS
		$business = $this->getBusiness($promo_id);
		$img = $business['BUSINESS_LOGO_IMAGE_NAME'];
		if($img != ''){
		
			if(strpos($img,'.') == 0){
	
				$format = '.jpg';
				$img_str = S3_URL.'assets/business/photos/'.$img . $format;
				
			}else{
				
				$img_str =  S3_URL.'assets/business/photos/'.$img;
				
			}
		
		}else{
			
			$img_str = base_url('/').'img/bus_blank.png';	
			
		}
		
		//SEND WINNER EMAIL
		//build body
		$body = '<img src="'.$prize_img.'" alt="Download Images to view Prize" style="float:right;"/>
				Hi ' . $user['CLIENT_NAME'].', <br /><br />You have won a scratch and win prize on My Namibia. Congratulations!
				<br /><br />
				Here is your unique coupon code which you will need to claim the prize from '. $business['BUSINESS_NAME'].'. <br /><br /><font style="font-size:12px;font-style:italic">'.
				$coupon . '</font><br /><br />';
				//IF NA POINTS
				if(($prize_id == '21') || ($prize_id == '22') ){
	
					
				}else{
					echo 'You can contact the business by replying to this email or by contacting them at <em>'.$business['BUSINESS_EMAIL'].'</em>. Please include the coupon code above for reference when claiming your prize. ';
					
				}
				echo '<h4>Special instructions</h4>'
				.$prize['DESCRIPTION'].'<br /><br />
				Have a !na day<br /><br /> <h3>'. $business['BUSINESS_NAME'].' 
				<img src="'.$img_str.'" alt="Download Images to view Deal" style="border:3px solid #666;margin-right:10px;width:120px;float:left" alt="'.$business['BUSINESS_NAME'].'"/></h3>
				<strong>P:</strong>'.$business['BUSINESS_TELEPHONE'].'<br /><strong>E:</strong>'.$business['BUSINESS_EMAIL'];
		$emailTO = $user['CLIENT_EMAIL'];
		$name    = $user['CLIENT_NAME'];
		$emailFROM = $business['BUSINESS_EMAIL'];
		$subject = $user['CLIENT_NAME']. ' Here is your Prize';		
		
		$this->send_email($emailTO, $emailFROM , $name , $body , $subject );
		
		
		//SEND WINNER BUSINESS
		//build body
		$body1 = '<img src="'.$prize_img.'" alt="Download Images to view Prize" style="float:right;"/>
				Hi, <br /><br />A member at My Namibia has just won a prize on the scratch and win game.
				<br /><br />
				Here is the unique coupon code which you will need to verify when '. $user['CLIENT_NAME'].' comes to claim his prize <br /><br /><font style="font-size:12px;font-style:italic">'.
				$coupon . '</font><br /><br /> You can contact the winner by replying to this email or by contacting them at <em>'.$user['CLIENT_EMAIL'].'</em> <br /><br />
				Have a !na day<br /><br /> My Namibia'; 
		$emailTO1 = $business['BUSINESS_EMAIL'];
		$name1    = $business['BUSINESS_NAME'];
		$emailFROM1 = $user['CLIENT_EMAIL'];
		$subject1 = $user['CLIENT_NAME']. ' has won your Prize';		
		
		$this->send_email($emailTO1, $emailFROM1 , $name1 , $body1 , $subject1 );
		
    }



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //HTML 
	function send_email($emailTO, $emailFROM , $name , $body , $subject )
	{
			$this->load->model('email_model');
			$this->email_model->send_email($emailTO, $emailFROM , $name , $body , $subject);
		
	}



	//+++++++++++++++++++++++++++
	//GET USER DETAILS
	//++++++++++++++++++++++++++
    public function getUser($id)
    {
        //GET WINNER DETAILS
		$this->db->where('ID',$id);
		$query = $this->db->get('u_client');
		return $query->row_array();
		
		
    }
	//+++++++++++++++++++++++++++
	//GET PRIZE DETAILS
	//++++++++++++++++++++++++++
    public function getPrize($id)
    {
        //GET WINNER DETAILS
		$this->db->where('ID',$id);
		$query = $this->db->get('scratch_prizes');
		return $query->row_array();
		
		
    }
	//+++++++++++++++++++++++++++
	//GET USER DETAILS
	//++++++++++++++++++++++++++
    public function getBusiness($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->query("SELECT u_business.* FROM `scratch_promotion` 
 									JOIN u_business ON scratch_promotion.BUSINESS_ID = u_business.ID
 									WHERE scratch_promotion.ID = '".$id."'", FALSE);
		$row = $query->row_array();
		return $row;
		
    }
	
	//+++++++++++++++++++++++++++
	//GET PRIZE SLIDER
	//++++++++++++++++++++++++++
    public function get_prize_slider()
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->query("SELECT ID, NAME, DESCRIPTION, IMAGE_URL, QUANTITY FROM `scratch_prizes` ORDER BY RAND()", FALSE);
		$row = $query->row_array();
		
		if($query->result()){
			$x =0;
			echo '
			<div class="prize_cover" style="width:250px; height:338px;"></div>
				   <div id="prizeCarousel" style="padding:0px 0px 0px 40px;text-align:center; margin-left:auto; margin-right:auto" class="carousel slide vertical">
			
					  <!-- Carousel items -->
					  
					  <div class="carousel-inner" style="text-align:center;height:340px">';	
			
				foreach($query->result() as $row){
					
					$active = '';
					if($x == 0){
						$active = 'active';
					}
					
					echo '<div class="item '.$active.'" style="text-align:center"><img src="'.S3_URL.'scratch_card/images/prizes/raw/'.str_replace('_win','',$row->IMAGE_URL).'" /></div>';
					$x ++;
				}
			
			echo '  </div>
				
						<!-- Carousel nav -->
					  <!--<a class="carousel-control left" href="#prizeCarousel" data-slide="prev">&lsaquo;</a>
					  <a class="carousel-control right" href="#prizeCarousel" data-slide="next">&rsaquo;</a>-->
					</div>';
		}
		
		
    }
	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+ADD DEAL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function add_prize(){
		
		$prize_id = $this->input->post('prize_id',TRUE);
		$title = $this->input->post('prize_title',TRUE);
		$cont = $this->input->post('prize_content',TRUE);
		$quantity = $this->input->post('prize_quantity',TRUE);

		//IF NEW DEAL
		if($prize_id == '0'){
		
			//INSERT
			$insertdata = array(
				//'BUSINESS_ID'=> $bus_id ,
				'NAME'=> $title ,
				 'DESCRIPTION'=> $cont,
				'QUANTITY' => $quantity
			);
			
			$this->db->insert('scratch_prizes', $insertdata);
			
			//GET NEW DEAL ID
			$this->db->select_max('ID');
			$query = $this->db->get('scratch_prizes');
			$row = $query->row_array();
			$prize_id =  $row['ID'];
			
			echo '<div class="alert alert-success">Prize saved</div>
			<script type="text/javascript">
				$("#btn_add_deal_img").fadeIn();
				$("#prize_id").val('.$prize_id.');
				$("#prize_id_prize_img").val('.$prize_id.');
				
				var x = $("#btn_add_prize_img");
						x.popover({  delay: { show: 100, hide: 3000 },
						 placement:"top",html: true,trigger: "manual",
						 title:"Add a Graphic", content:"Great, prize has been added. Please upload the prize graphic 173 x 338 pixels"});
						x.popover("show");
						$("html, body").animate({
							 scrollTop: (x.offset().top - 200)
						 }, 300);
			</script>'
			;
			
			
		}else{
			
			//UPDATE
			$insertdata = array(
				//'BUSINESS_ID'=> $bus_id ,
				'NAME'=> $title ,
				 'DESCRIPTION'=> $cont,
				'QUANTITY' => $quantity
			);
			
			$this->db->where('ID', $prize_id);
			$this->db->update('scratch_prizes', $insertdata);

			echo '<div class="alert alert-success">Prize updated</div>
			<script type="text/javascript">
				$("#btn_add_prize_img").fadeIn();
				$("#prize_id").val('.$prize_id.');
				$("#prize_id_prize_img").val('.$prize_id.');
			
			</script>'
			;			
		}

		
	}	
	
   

	                     

	
}
