<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Business extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function __construct()
	{
		parent::__construct();
		$this->load->model('business_model');
		$this->load->model('my_na_model');
		$this->load->model('product_model');
	}
	
	
	public function index()
	{
		if($this->session->userdata('id')){
			 	
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/home', $data);	
		
		}else{
			
				$this->load->view('login');
			  
		 }
	}
	
	//+++++++++++++++++++++++++++
	//BUSINESS DETAILS EDIT
	//++++++++++++++++++++++++++
	public function edit()
	{
		
		if($this->session->userdata('id')){
			 	
				$data['id'] = $this->session->userdata('id');
				$this->load->view('members/home', $data);	
		
		}else{
			
				$this->load->view('login');
			  
		 }
		
		
	}
	
	//+++++++++++++++++++++++++++
	//BUSINESS PROFILE PAGE
	//++++++++++++++++++++++++++
	public function view($bus_id)
	{
		$this->load->model('image_model'); 

		$this->load->library('thumborp');

		//Temporary Redirect for Car publication 2017-08-29
		if($bus_id == 9318){

			$name = $this->clean_url_str($this->business_model->get_business_name($bus_id));
			redirect('/trade/agent/'.$bus_id.'/0/'.$name.'/','location',301);

		}elseif($bus_id == 5211){

			$name = $this->clean_url_str($this->business_model->get_business_name($bus_id));
			redirect('/trade/agent/'.$bus_id.'/0/'.$name.'/','location',301);

		}

		//echo $this->uri->segment(3);
		//redirect SEO friendly url
		if($this->uri->segment(3) != ''){
			if($this->uri->segment(4) != ''){
				
				$data['tab_section'] = $this->uri->segment(4);
				
			}else{
				
				$data['tab_section'] = 'info';
			}

			$this->load->model('rating_model');
			$data['bus_id'] = $bus_id;
			$this->load->model('trade_model');
			//ADD a VIEW LISTING COUNTER
			$this->business_model->add_business_view($bus_id);

            $data['query'] =  $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        MAX(product_auction_bids.amount) as current_bid,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                        SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                            AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'

                                        WHERE products.bus_id = '".$bus_id."' AND products.is_active = 'Y' AND products.status = 'live'
                                        GROUP BY products.product_id
                                        ORDER BY listing_date DESC LIMIT 8");

			//$data['location'] = 'natonal';
			//$data['suburb'] = 'all';
			//$data['business'] = TRUE;
			//$data['main_cat_id'] = 3408;
			//$data['main_cat'] = 'Property';
			$data['bus_details'] = $this->business_model->get_business_details($bus_id);
			$data['cats'] = $this->business_model->get_current_categories($bus_id);
			//get RATING
			$data['rating'] = $this->business_model->get_rating($bus_id);
			//$this->load->view('trade/business_products', $data);


			$this->load->view('business/profile', $data);
				
		}else{
			
			$name = $this->clean_url_str($this->business_model->get_business_name($bus_id));
			if($name == 'no-name'){

				redirect(site_url('/'),'location',301);
				
			}else{

				redirect('/b/'.$bus_id.'/'.$name.'/','location',301);
			}

		}

	}


	//+++++++++++++++++++++++++++
	//BUSINESS SHOW GALLERY
	//++++++++++++++++++++++++++
	public function load_gallery($bus_id)
	{

		$this->business_model->show_gallery($bus_id);

	}


	//+++++++++++++++++++++++++++
	//BUSINESS PROFILE PAGE 2
	//++++++++++++++++++++++++++
	public function view2($bus_id)
	{
		//redirect SEO friendly url
		if($this->uri->segment(3) != ''){
			if($this->uri->segment(4) != ''){
				
				$data['tab_section'] = $this->uri->segment(4);
				
			}else{
				
				$data['tab_section'] = 'info';
			}

			
			$data['bus_id'] = $bus_id;
			//ADD a VIEW LISTING COUNTER
			$this->business_model->add_business_view($bus_id);
			$this->load->view('business/profile2', $data);
				
		}else{
			
			$name = $this->clean_url_str($this->business_model->get_business_name($bus_id));
			redirect('/b2/'.$bus_id.'/'.$name.'/','location',301);
			
		}

	}
	
	//LOAD DEALS ON PROFILE PAGE
	public function show_business_deal($bus_id)
	{
		
		$this->business_model->show_business_deal($bus_id);

	}
	
	
	//+++++++++++++++++++++++++++
	//BUSINESS ENQUIRY
	//++++++++++++++++++++++++++
	public function contact($bus_id)
	{
		$this->load->library('user_agent');
		//TEST IF ROBOT
		if ($this->agent->is_robot())
		{
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		Sorry, only humans can submit an enquiry!</div>';	
		
		//IS HUMAN
		}else{

			$this->load->library('recaptcha');
			$bool = json_decode($this->recaptcha->recaptcha_check_answer());

			//var_dump ($bool);
			//CAPTCHA FALSE
			if(!$bool->success) {

				$data['error'] = 'PLease tick the box above to prove you are human';
				echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								'.$data['error'].'</div>';


				$email = $this->input->post('email', TRUE);
					$name = $this->input->post('name', TRUE);
					$msg = $this->input->post('msg', TRUE);
					$captcha = $this->input->post('captcha', TRUE);
					$x = $this->input->post('x', TRUE);
					$y = $this->input->post('y', TRUE);
					
					//VALIDATE INPUT
					if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
						$val = FALSE;
						$error = 'Email address is not valid.';	
						
					}elseif($name == ''){
						$val = FALSE;
						$error = 'Please provide us with your full name.';	
					//CORRECT CAPTCHA
					}elseif(($x + $y) != $captcha){
						$val = FALSE;
						$error = 'Your answer did not match.';
									
					}else{
						$val = TRUE;
					}
					
					//IF VALIDATED
					if($val == TRUE){
						
						$q = $this->db->query("SELECT u_business.*,u_client.CLIENT_EMAIL,u_client.CLIENT_NAME,u_client.CLIENT_SURNAME, a_country.COUNTRY_NAME
										,u_client.CLIENT_COUNTRY,u_client.CLIENT_PROFILE_PICTURE_NAME, u_business.BUSINESS_EMAIL,u_business.BUSINESS_NAME 
										,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.BUSINESS_NAME , u_business.BUSINESS_TELEPHONE
										,group_concat(u_client.CLIENT_EMAIL) as emails
										FROM u_business
										LEFT JOIN i_client_business ON i_client_business.BUSINESS_ID = u_business.ID
										LEFT JOIN u_client ON u_client.ID = i_client_business.CLIENT_ID
										LEFT JOIN a_country ON a_country.ID = u_client.CLIENT_COUNTRY
										WHERE u_business.ID = '".$bus_id."'
										GROUP BY u_business.ID
										
										");
					
					
					
						$row = $q->row_array();
						$bmail = $row['BUSINESS_EMAIL'];
						$bname = $row['BUSINESS_NAME'];
			
						
							$data1 = array(
							  'name'=> $name ,
							  'email'=> $email ,
							  'msg'=> $msg ,
							  'bmail'=> $bmail,
							  'bname'=> $bname
							);
							
						//SEND EMAIL LINK
						$this->load->model('email_model');	
						$this->email_model->send_enquiry($data1, $row);	
						
						if($this->session->userdata('id')){
							
							$client_id = $this->session->userdata('id');
						}else{
						
							$client_id = '0';	
						}
						
						//INSERT INTO MESSAGES TABLE
						$data2 = array(
							  'bus_id'=> $bus_id ,
							  'client_id'=> $client_id ,
							  'nameFROM'=> $name ,
							  'nameTO'=> $bname ,
							  'email'=> $email ,
							  'emailTO'=> $bmail ,
							  'body'=> $msg,
							  'status'=> 'unread',
							  'status_client'=> 'sent',
							  'subject' => 'Enquiry from ' .$name
							);
						
						$this->db->insert('u_business_messages',$data2);
						
						$data['bus_id'] = $bus_id;
						$data['basicmsg'] = 'Thanks, '. $name. '! We have succesfully sent your enquiry.' ;
						$data['fb_conversion'] = '
												<script  data-cfasync="false">(function() {
												  var _fbq = window._fbq || (window._fbq = []);
												  if (!_fbq.loaded) {
												    var fbds = document.createElement("script");
												    fbds.async = true;
												    fbds.src = "//connect.facebook.net/en_US/fbds.js";
												    var s = document.getElementsByTagName("script")[0];
												    s.parentNode.insertBefore(fbds, s);
												    _fbq.loaded = true;
												  }
												})();
												window._fbq = window._fbq || [];
												window._fbq.push(["track", "6020352901773", {"value":"10.00","currency":"ZAR"}]);
												</script>
												<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6020352901773&amp;cd[value]=0.00&amp;cd[currency]=ZAR&amp;noscript=1" /></noscript>';

						$this->load->view('business/profile', $data);		
				
					//IF NOT VALIDATED	
					}else{
						
						$data['bus_id'] = $bus_id;
						$data['error'] = $error;
						$this->load->view('business/profile', $data);	
						
					}
			}//RECAPTCHA VALID
		}
			
	}
	
	public function contact_ajax($bus_id)
	{
		
		$this->load->library('user_agent');
		//TEST IF ROBOT
		if ($this->agent->is_robot())
		{
			$e = '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		Sorry, only humans can submit an enquiry!</div>';
			$this->session->set_flashdata('msg' , $e);	
			redirect(site_url('/').'product/'.$id.'/', 301);		
		
		//IS HUMAN
		}else{

			$this->load->library('recaptcha');
			$bool = json_decode($this->recaptcha->recaptcha_check_answer());
			//echo $bool->error-codes;
			//$bool->success = true;
			//var_dump ($bool);
			//CAPTCHA FALSE
			if($bool->success === false) {
								
					$data['error'] = 'Please tick the box above to prove you are human';
					echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								'.$data['error'].'</div>';				
								
			} else {

				
				$email = $this->input->post('email', TRUE);
				$name = $this->input->post('name', TRUE);
				$msg = $this->input->post('msg', TRUE);
				$captcha = $this->input->post('captcha', TRUE);
				$x = $this->input->post('x', TRUE);
				$y = $this->input->post('y', TRUE);
				
				//VALIDATE INPUT
				if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
					$val = FALSE;
					$error = 'Email address is not valid.';	
					
				}elseif($name == ''){
					$val = FALSE;
					$error = 'Please provide us with your full name.';	
				
								
				}else{
					$val = TRUE;
				}
				
				//IF VALIDATED
				if($val == TRUE){
					
					
                	$q = $this->db->query("SELECT u_business.*,u_client.CLIENT_EMAIL,u_client.CLIENT_NAME,u_client.CLIENT_SURNAME, a_country.COUNTRY_NAME
										,u_client.CLIENT_COUNTRY,u_client.CLIENT_PROFILE_PICTURE_NAME, u_business.BUSINESS_EMAIL,u_business.BUSINESS_NAME 
										,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.BUSINESS_NAME , u_business.BUSINESS_TELEPHONE
										,group_concat(u_client.CLIENT_EMAIL) as emails
										FROM u_business
										LEFT JOIN i_client_business ON i_client_business.BUSINESS_ID = u_business.ID
										LEFT JOIN u_client ON u_client.ID = i_client_business.CLIENT_ID
										LEFT JOIN a_country ON a_country.ID = u_client.CLIENT_COUNTRY
										WHERE u_business.ID = '".$bus_id."'
										GROUP BY u_business.ID
										
										");
					
					
					
					$row = $q->row_array();
					$bmail = $row['BUSINESS_EMAIL'];
					$bname = $row['BUSINESS_NAME'];
		
					
						$data1 = array(
						  'name'=> $name ,
						  'email'=> $email ,
						  'msg'=> $msg ,
						  'bmail'=> $bmail,
						  'bname'=> $bname
						);
						
					//SEND EMAIL LINK
					$this->load->model('email_model');	
					$this->email_model->send_enquiry($data1, $row);	
					
					if($this->session->userdata('id')){
						
						$client_id = $this->session->userdata('id');
					}else{
					
						$client_id = '0';	
					}
					
					//INSERT INTO MESSAGES TABLE
					$data2 = array(
						  'bus_id'=> $bus_id ,
						  'client_id'=> $client_id ,
						  'nameFROM'=> $name ,
						  'nameTO'=> $bname ,
						  'email'=> $email ,
						  'emailTO'=> $bmail ,
						  'body'=> $msg,
						  'status'=> 'unread',
						  'status_client'=> 'sent',
						  'subject' => 'Enquiry from ' .$name
						);
					
					//$this->db->insert('u_business_messages',$data2);
					
					$data['bus_id'] = $bus_id;
					$data['basicmsg'] = 'Thanks, '. $name. '! We have succesfully sent your enquiry.' ;

					$data['fb_conversion'] = '
												<script  data-cfasync="false">(function() {
												  var _fbq = window._fbq || (window._fbq = []);
												  if (!_fbq.loaded) {
												    var fbds = document.createElement("script");
												    fbds.async = true;
												    fbds.src = "//connect.facebook.net/en_US/fbds.js";
												    var s = document.getElementsByTagName("script")[0];
												    s.parentNode.insertBefore(fbds, s);
												    _fbq.loaded = true;
												  }
												})();
												window._fbq = window._fbq || [];
												window._fbq.push(["track", "6020352901773", {"value":"10.00","currency":"ZAR"}]);
												</script>
												<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6020352901773&amp;cd[value]=0.00&amp;cd[currency]=ZAR&amp;noscript=1" /></noscript>';


					echo '<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							'.$data['basicmsg'].'</div>
							<script data-cfasync="false" type="text/javascript">
								//$("#msg").redactor("set", "");
							</script>
							'.$data['fb_conversion'];
				
				//IF NOT VALIDATED	
				}else{
					
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
					echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>
							'.$data['error'].'</div>';	
					
				}
				
			}//RECAPTHC CORRECT
		}
			
	}
	
	
	public function claim($bus_id)
	{

		$client_id = $this->session->userdata('id');
		$msg = $this->input->post('claim_msg', TRUE);
		$captcha = $this->input->post('claim_captcha', TRUE);
		$x = $this->input->post('claim_x', TRUE);
		$y = $this->input->post('claim_y', TRUE);
		
		//VALIDATE INPUT
		if(($x + $y) != $captcha){
			$val = FALSE;
			$error = 'Your security answer did not match. What is '.$x . ' + ' . $y;
						
		}else{
			$val = TRUE;
		}
		
		//IF VALIDATED
		if($val == TRUE){
			
			$this->db->where('ID' , $bus_id);
			$this->db->from('u_business');
			$query = $this->db->get();
			$row = $query->row_array();
			$bmail = $row['BUSINESS_EMAIL'];
			$bname = $row['BUSINESS_NAME'];
				
			$client_row = $this->get_client_account($this->session->userdata('id'));	
			$emailTO = array(array('email'=>'roland@my.na'),array('email' => 'info@my.na'));

			$emailFROM = $client_row['CLIENT_EMAIL'];
			$body = 'We have received a new business claim request. Please review and action as soon as possible.<br />	<br /><br />
					Client Name : '.$client_row['CLIENT_NAME'].' ' .$client_row['CLIENT_SURNAME'].'<br /><br />
				    Client Email : '.$client_row['CLIENT_EMAIL'].'<br /><br />
					Message: '.$msg.'
					
					<br /><br />
					Business : '.$row['BUSINESS_NAME'].'<br /><br />
					Email : '.$row['BUSINESS_EMAIL'].'<br /><br />
					Business ID : '.$bus_id.'<br /><br /> Please action this asap.';
					
			//SEND EMAIL LINK
			$this->load->model('email_model');	
			$this->email_model->send_email($emailTO, $emailFROM , 'My Namibia Business Claim' , $body , 'New Business Claim Request');	
			
			
			//INSERT INTO MESSAGES TABLE
			$data2 = array(
				  'BUSINESS_ID'=> $bus_id ,
				  'CLIENT_ID'=> $client_id 
				);
			
			$this->db->insert('i_client_business_claims',$data2);
			
			$data['bus_id'] = $bus_id;
			$data['basicmsg'] = 'Thanks, '. $client_row['CLIENT_NAME']. '! We have succesfully sent your claim. It will be reviewed within 24 hours.' ;
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script  data-cfasync="false" type="text/javascript">
					location.reload();
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
	
	public function claim_blank()
	{

		$client_id = $this->session->userdata('id');
		$msg = $this->input->post('claim_msg', TRUE);
		$captcha = $this->input->post('claim_captcha', TRUE);
		$x = $this->input->post('claim_x', TRUE);
		$y = $this->input->post('claim_y', TRUE);
		$business = $this->input->post('Cbusiness', TRUE);
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
			
				
			$client_row = $this->get_client_account($this->session->userdata('id'));	
			$emailTO = 'rolandihms@gmail.com';
			$emailFROM = $client_row['CLIENT_EMAIL'];
			$body = 'We have received a new business claim request. Please review and action as soon as possible.<br />	<br /><br />
					Client Name : '.$client_row['CLIENT_NAME'].' ' .$client_row['CLIENT_SURNAME'].'<br /><br />
				    Client Email : '.$client_row['CLIENT_EMAIL'].'<br /><br />
					Message: '.$msg.'
					
					<br /><br />
					Business : '.$business.'<br /><br />
					Please action this asap.';
					
			//SEND EMAIL LINK
			$this->load->model('email_model');	
			$this->email_model->send_email($emailTO, $emailFROM , 'My Namibia Business Claim' , $body , 'New Business Claim Request');	
			
			
			//INSERT INTO MESSAGES TABLE
			$data2 = array(
				  'BUSINESS_ID'=> $bus_id ,
				  'CLIENT_ID'=> $client_id 
				);
			
			$this->db->insert('i_client_business_claims',$data2);
			
			$data['bus_id'] = $bus_id;
			$data['basicmsg'] = 'Thanks, '. $client_row['CLIENT_NAME']. '! We have succesfully sent your claim. It will be reviewed within 24 hours.' ;
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script  data-cfasync="false" type="text/javascript">
					$("#claim_msg").setCode("");
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
/**
++++++++++++++++++++++++++++++++++++++++++++
//BUSINESS REVIEW & RATING
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */

	public function submit_review($bus_id)
	{
		$rating = $this->input->post('star1', TRUE);
		$review = strip_tags($this->input->post('reviewtxt', TRUE));
		$IP = $this->input->ip_address();
		$client_id = $this->input->post('client_id', TRUE);
		
		//VALIDATE INPUT
		if($review == ''){
			$val = FALSE;
			$error = 'Please provide us with a review';	
			
		}elseif(str_word_count($review) <= 10){
			$val = FALSE;
			$error = 'Please provide us with a informative review. Must be more than 10 words and no spelling mistakes are accepted!';	
	
		
		}elseif($rating == ''){
			$val = FALSE;
			$error = 'Please provide us with your star rating of 1-10.';	
	
		}else{
			$val = TRUE;
		}
		
		
		//IF VALIDATED
		if($val == TRUE){
			
			
			$query = $this->db->query("SELECT * FROM `u_business_vote` WHERE BUSINESS_ID = '".$bus_id."' AND (CLIENT_ID = '".$client_id."' OR IP = '".$IP."')");
			$row = $query->num_rows();
			

			//IF CLIENT NOT ALREADY REVIEWED BUSINESS
			if($row == 0){
				
					$data1 = array(
					  'BUSINESS_ID'=> $bus_id ,
					  'CLIENT_ID'=> $client_id ,
					  'IP'=> $IP ,
					  'RATING'=> $rating,
					  'REVIEW'=> $review
					);
				
				//INSERT INTO DB
				$this->db->insert('u_business_vote', $data1);
					
				//SEND EMAIL LINK
				$this->load->model('email_model');
				//EMAIL OFFICE	
				$this->email_model->send_review_notification($data1);
				//EMAIL BUSINESS	
				//$this->email_model->send_review_notification_business($data1);
				$data['bus_id'] = $bus_id;
				$data['basicmsg'] = 'Thanks! We have succesfully submitted your review. You will receive your points as soon as the review has been approved' ;
				$this->load->view('business/profile', $data);
		    
				//UPDATE CLIENT POINTS
				//$this->business_model->update_client_point($client_id, '3', $bus_id, 'review');
			//IF CLIENT ALREADY REVIEWED BUSINESS
			}else{
				
				$data['bus_id'] = $bus_id;
				$data['error'] = 'Sorry, it seems like you have already reviewed this business or we have a previously submitted review from your current IP address: '. $IP ;
				$this->load->view('business/profile', $data);
				
			}

		//IF NOT VALIDATED	
		}else{
			
			$data['bus_id'] = $bus_id;
			$data['error'] = $error;
			$this->load->view('business/profile', $data);	
			
		}
	
			
	}

	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//LOAD RESPONSE MODAL
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	function load_response_modal($rev_id){
      	
		$this->db->where('ID', $rev_id);
		$query = $this->db->get('u_business_vote');
		$data = $query->row_array();
		
		echo $this->load->view('business/inc/business_review_respond_inc', $data, TRUE);			
				  
    }
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SUBMIT REVIEW RESPONSE 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function submit_review_response($rev_id)
	{
		
		$review = strip_tags($this->input->post('response_msg', TRUE));
		$IP = $this->input->ip_address();
		$client_id = $this->input->post('client_id', TRUE);
		$bus_id = $this->input->post('bus_id', TRUE);
		
		//VALIDATE INPUT
		if($review == ''){
			$val = FALSE;
			$error = 'Please provide us with a response';	
			
		}elseif(str_word_count($review) <= 10){
			$val = FALSE;
			$error = 'Please provide us with a informative response. Must be more than 10 words and no spelling mistakes are accepted!';	
	
		}else{
			$val = TRUE;
		}

		
		//IF VALIDATED
		if($val == TRUE){
			
				  $data1 = array(
					'BUSINESS_ID'=> $bus_id ,
					'CLIENT_ID'=> $client_id ,
					'IP'=> $IP ,
					'RATING'=> '0',
					'REVIEW'=> $review,
					'TYPE'=> 'response', 
					'REVIEW_ID'=> $rev_id
				  );
			  
			  //INSERT INTO DB
			  $this->db->insert('u_business_vote', $data1);
				  
			  //SEND EMAIL LINK
			  $this->load->model('email_model');
			  //EMAIL OFFICE	
			  $this->email_model->send_review_notification($data1);	
			  //EMAIL BUSINESS	
			  //$this->email_model->send_review_notification_business($data1);
			  //UPDATE CLIENT POINTS
			  //$this->business_model->update_client_point($client_id, '3', $bus_id, 'review');
			  //NA BUSINESS
			  //$this->business_model->my_na_click($bus_id, $client_id, 'right');
			  
			  
			  $data['bus_id'] = $bus_id;
			  $data['basicmsg'] = 'Thanks! We have succesfully submitted your response. Your response will be visible once its been approved.' ;
			  echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  '.$data['basicmsg'].'</div>
					  <script  data-cfasync="false" type="text/javascript">
						  $("#response_msg").setCode("");
						  
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
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//RELOAD REVIEWS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function reload_reviews($bus_id) {
		
		$this->business_model->show_reviews($bus_id);
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SHOW VIRTUAL TOUR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	function load_virtual_tour($id) {
		
		$this->business_model->show_virtual_tour($id);
	}
	//Get Account Details
	function get_client_account($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');
		return $test->row_array();		  
    }
//Get Account Details
	function get_business($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_business');
		return $test->row_array();		  
    }
	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function load_similar($id) {
		
		$this->business_model->show_similar($id); 
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
//CLEAN BUSINESS TABLE TELEPHONE
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	function clean_tel($limit = 1000, $offset = 0){

		$query = $this->db->limit($limit, $offset);
		$query = $this->db->get('u_business');
		$x = 0;$x2 = 0;
		$upd = true;
		foreach($query->result() as $row){
			
			$tel = $row->BUSINESS_TELEPHONE;$cell = $row->BUSINESS_CELLPHONE; $fax = $row->BUSINESS_FAX;
			$bus_id = $row->ID;

			echo 'Tel: '.$tel.'   Fax: '.$fax.'  Cell: '.$cell.'<br />';

			if(strpos($tel,'/') != 0){

				$tel = substr($tel,0,strpos($tel, '/'));
				echo 'Sub numbers found    ======== New tel: '.$tel.'<br />';
			}


			$data['BUSINESS_TELEPHONE'] = $this->clean_contact($tel);
			$data['BUSINESS_FAX'] = $this->clean_contact($fax);
			$data['BUSINESS_CELLPHONE'] = $this->clean_contact($cell);

			if($upd){

				$this->db->where('ID', $bus_id);
				$this->db->update('u_business',$data);

			}
			echo $row->BUSINESS_NAME. ' -- Cleaned ::: Tel: '.$data['BUSINESS_TELEPHONE'].'   Fax: '.$data['BUSINESS_FAX'].'  Cell: '.$data['BUSINESS_CELLPHONE'].'<br />';


		}


		echo $x . ' Rows updated from NA, '.$x2.' Rows Updated for 264<br />';

		echo '<a href="'.site_url('/').'business/clean_tel/'.$limit.'/'.($limit + $offset).'/">Next</a>';
    }


	//+++++++++++++++++++++++++++
	//PREPEND CELL
	//++++++++++++++++++++++++++
	function clean_contact($nr)
	{
		//$nr = '+264 (0) 8171717 23';
		//remove ' ' , (, ), +
		$str1 = str_replace(' ','',preg_replace("/[^0-9]/","",$nr));
		//get 1st 3 digits
		$str2 = substr($str1,0,3);

		if($str2 == '264'){

			$o['success'] = true;
			$str3 = str_replace("264","",$str1);

		}else{
			$o['success'] = false;
			$str3 = $str1;
		}

		//REMOVE LEADING 0
		if(substr($str3, 0,1) == 0){

			$str3 = substr($str3,1,strlen($str3));
		}

		return $str3;


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MY NA LIKE FUNCTION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	
	function my_na($bus_id, $place) {
		
		if($this->session->userdata('id')){
			
			$client_id = $this->session->userdata('id');
			$this->business_model->my_na($bus_id, $client_id, $place);
			
		}else{
			$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : current_url();
			$connections = $this->business_model->get_my_na_connections($bus_id);
			$str = "<span class='badge'>".$connections['count']."</span><span style='font-size:11px' class='muted'><em> like these guys:</em></span><br />".$connections['str']."";
			echo '<a href="'.site_url('/').'members/?redirect_url='.$referer.'" class="my_na"><span></span></a>';
			echo '<script  data-cfasync="false" type="text/javascript">$("#'.$bus_id.'").popover({  delay: { show: 100, hide: 3000 },placement:"'.$place.'",html: true,trigger: "hover", title:"!na Us - My Na &trade;", content:"To n!ja this business and connect with them please register<br />'.$str.'"});</script>';
		}
		
		
	}
	function my_na_click($bus_id, $place) {
		
		if($this->session->userdata('id')){
			
			$client_id = $this->session->userdata('id');
			$this->business_model->my_na_click($bus_id, $client_id, $place);
			
		}else{
			
			echo '<a href="'.site_url('/').'members/" class="my_na"><span></span></a>';
			echo '<script  data-cfasync="false" type="text/javascript">$("#'.$bus_id.'").popover({ placement:"'.$place.'",html: true,trigger: "hover", title:"n!ja Us - My Na &trade;", content:"To !na this business and connect with them please register or login"});</script>';
		}
		
		
	}

 /**
++++++++++++++++++++++++++++++++++++++++++++
//ANALYTICS
++++++++++++++++++++++++++++++++++++++++++++	
ANALYTICS SECTION
++++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++	
 */ 
    function add_business_phone_click($bus_id, $type) {
		
		$this->business_model->add_business_phone_click($bus_id, $type);
		
	}



/**
++++++++++++++++++++++++++++++++++++++++++++
//BUSINESS ANALYTICS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	function analytics($bus_id,$period){
		error_reporting(E_ALL);
		$data['bus_id'] = $bus_id;
		$data['period'] = $period;

		$q = $this->db->where('ID', $bus_id);
		$q = $this->db->get('u_business');
		//echo 'poes';
		if($q->result()){

			$data['business'] = $q->result();
			$this->load->model('rating_model');
			$data['bus_id'] = $bus_id;
			$data['rating'] = $this->business_model->get_rating($bus_id);
			$this->load->model('members_model');
			$this->load->view('business/business_analytics',$data);

		}else{
			echo 'No Result Found';
		}

	}


	function analytics_email($bus_id,$period){
		error_reporting(E_ALL);
		$data['bus_id'] = $bus_id;
		$data['period'] = $period;

		$q = $this->db->where('ID', $bus_id);
		$q = $this->db->get('u_business');
		//echo 'poes';
		if($q->result()){

			$data['business'] = $q->result();
			$this->load->model('rating_model');
			$data['bus_id'] = $bus_id;
			$data['rating'] = $this->business_model->get_rating($bus_id);
			$this->load->model('members_model');
			$this->load->view('email/body_business_report',$data);

		}else{
			echo 'No Result Found';
		}

	}


	function get_business_analytics_month($bus_id){
		
		$data['bus_id'] = $bus_id;
		$this->load->view('members/inc/business_analytics_month',$data);
		
		
	}


	//PRINT BUSINESS ANALYTICS
	function print_business_pdf($bus_id, $period = '', $title = ''){
		//error_reporting(0);
		//error_reporting(E_ALL);
		//error_reporting(E_ALL);
		$result = $this->business_model->print_business_pdf($bus_id, $period, $title);
		
		//var_dump($result);
		if($result['success'] === false) { 
			/* Handle error */ 
			//echo 'Error';
			$data['success'] = false;
			$data['error'] = $result['error'];
			$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}else{

			$data['success'] = true;
			$data['pdf'] = '';//$result['pdf'];
			$data['pdf_link'] = $result['pdf_link'];
			//echo json_encode($data);
			$this->output
		        ->set_content_type('application/json')
		        ->set_output(json_encode($data));
		}
		
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
    }


	public  function decrypt($string) {
        $data = $this->decode($string);
        echo $data;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */