<?php
class Email_model extends CI_Model{
			

	
 	function __construct(){
  		//parent::CI_model();
		parent::__construct();
		$this->load->library('email');		
 	}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+GMAIL SMTP
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//		$config['protocol']='smtp';  
//		$config['smtp_host']='ssl://smtp.googlemail.com';  
//		$config['smtp_port']='465';  
//		$config['smtp_timeout']='30';  
//		$config['smtp_user']='info@my-child.co.nz';  
//		$config['smtp_pass']='namibia1'; 
		
//MANDRILL		
//		$config['protocol']='smtp';  
//		$config['smtp_host']='smtp.mandrillapp.com';  
//		$config['smtp_port']='587';  
//		$config['smtp_timeout']='30';  
//		$config['smtp_user']='roland@my.na';  
//		$config['smtp_pass']='d3tAlotpZNobGiCfRk3Miw'; 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//SEND VERIFICATION LINK TO NEW MEMBER AFTER SIGNUP
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


	//NEW SERVER
	function send_enquiry2()
	{

		/*$toAddresses = $var['email_to'];
		$toNames = $var['email_to'];

		$mandrillTO = array_map( function ($toaddress, $toname) {
			return array(
				'email' => $toaddress,
				'name' => $toname,
				'type' => 'to'
			);
		},
			$toAddresses,
			$toNames
		);

		$sendTo = $mandrillTO;*/


		/*$this->load->library('email');

		$this->email->initialize(array(
		'protocol' => 'smtp',
		'mailtype'  => 'html', 
		'charset'   => 'iso-8859-1'
		'smtp_host' => 'ssl://email-smtp.eu-west-1.amazonaws.com',
		'smtp_port' => '465',
		'smtp_user' => 'AKIAIEDWIYXIABCFGGFQ',
		'smtp_pass' => 'Ahxb1+zvPa8Eq6zgDuZEkdhNwPBZSRQPOBSVQ/AqW7YA'));


		$this->email->set_newline("\r\n");

		$this->email->from('no-reply@intouchsrv.com');
		$this->email->to('christian@intouch.com.na');
		$this->email->subject('test');
		$this->email->message('test');

		$this->email->send();*/


		$config = Array(
		    'protocol' => 'smtp',
		    'smtp_host' => 'tls://email-smtp.eu-west-1.amazonaws.com',
		    'smtp_port' => 465,
		    'smtp_user' => 'AKIAIEDWIYXIABCFGGFQ',
		    'smtp_pass' => 'Ahxb1+zvPa8Eq6zgDuZEkdhNwPBZSRQPOBSVQ/AqW7YA',
		    'mailtype'  => 'html', 
		    'charset'   => 'iso-8859-1'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");

		// Set to, from, message, etc.

		$this->email->from('no-reply@intouchsrv.com');
		$this->email->to('christian@intouch.com.na');
		$this->email->subject('test');
		$this->email->message('test');

		$this->email->send();		

		//$result = $this->email->send();



		echo $this->email->print_debugger();

			/*$email = array(
				'html' => $var['body'], //Consider using a view file
				'subject' => $var['subject'],
				'headers' => array('Reply-To' => $var['from_email']),
				'from_email' => 'vw-no-reply@my.na',
				'from_name' => $var['name'],
				'to' => $sendTo
			);*/	

	}	


	//++++++++++++++++++++++++++++++++++++++++++++
	//PASS PARAMETERS AND SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++		
	function send_mail($HTML, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG, $important = true, $global_merge = '', $merge = '', $from = 'no-reply', $attachment = null, $file_name = '', $mime = ''){

			$this->load->config('mandrill');
	
			$this->load->library('mandrill');
			
			$mandrill_ready = NULL;
            $result = '';
			try {
			
				$this->mandrill->init( $this->config->item('mandrill_api_key') );
				$mandrill_ready = TRUE;
			
			} catch(Mandrill_Exception $e) {
			
				$mandrill_ready = FALSE;
				
			}
			
			if( $mandrill_ready ) {
				
				$attachments[] = array();
	            if($attachment != null){

					//echo 'Has attachment';
	                /*$attachment = str_replace('[removed]', '',   $attachment);
	                $raw = $attachment;
	                $attachment = substr($attachment,strpos($attachment, ',') +1,strlen($attachment));
	                //$encoded_string = rawurldecode( $attachment);
	                $encoded_string = $attachment;
	                $filedata = base64_decode($raw);

	                $f = finfo_open();

	                $mime_type = finfo_buffer($f, $filedata, FILEINFO_MIME_TYPE);

	                $ext = substr($mime_type,strpos($mime_type, '/') + 1, strlen($mime_type));
	                $ext = substr($mime,strpos($mime, '/') + 1, strlen($mime));*/

	                //$file_name = md5(date('Y-m-d h:i:s'));
	                //$file_path = BASE_URL.'assets/'.$file_name.'.'.$ext;
	                //file_put_contents($file_path, $filedata);

	                //echo $raw. ' ---- '.$file_name. ' - '.$ext.' - '. $mime_type . ' post mime: '.$mime;
	               //WORKING!!!
	               /* $tmp = str_replace('data:image/png;base64,', '',rawurldecode( $attachment));
	                $tmp = str_replace(' ', '', $tmp);
	                $tmp = str_replace('[removed]', '', $tmp);
	                $data = base64_decode($tmp);
	                file_put_contents(BASE_URL.'assets/test.png', $data);*/

	                $attachment_encoded =$attachment;
	                
	                //echo $raw;

	                $attachments[] = array(
	                    'content' => $attachment_encoded,
	                    'type' => $mime,
	                    'name' => $file_name
	                );
	            }


				//Send us some email!
				$email = array(
					  'html' => $HTML, //Consider using a view file
					  'text' =>  strip_tags(strip_tags($HTML)),
					  'headers' => array('Reply-To' => $FROM_EMAIL),
					  'subject' => $subject,
					  'from_email' => $from.'@my.na',
					  'from_name' => $FROM_NAME,
					  'tags' => $TAG,
					  'to' => $mandrill,
					  'signing_domain' => 'my.na',
					  'google_analytics_domains' => array('my.na'),
        			  'google_analytics_campaign' => 'mail',
                      'important' => $important ,
                      'global_merge_vars' => $global_merge,
                      'merge_vars' => $merge,
                      'attachments' => $attachments
					  );
					  
				  $result = $this->mandrill->messages_send($email);	
				
			}

            return $result;
		
	}



	//PLAIN TEXT
	function send_register_link_plain($member)
	{
			$config['mailtype'] = 'text';
			$this->email->initialize($config);
			$this->email->from('no-reply@my.na','My Namibia');
			$this->email->reply_to('support@my.na','My Namibia');
			$this->email->to($member['email']);
			//$this->email->cc('another@another-example.com'); 
			//$this->email->bcc('them@their-example.com'); 
			//build body
			$body1 = "Hi " . $member['fname'] . ":" . " \n\n";
			$body1.=  "We have published a new learning story on ".$member['fname']."'s profile book. \n\n";
		
			$body1.= "Have a look: \n";
			$body1.= "--------------------------------------- \n\n";
			//$body1.=  $comment . " \n\n\n";
		
			$body1.= "From: \n";
			$body1.= "--------------------------------------- \n\n";
			$body1.=   "Name: ";// . $teacher['fname'] . ' ' .$teacher['email'] . " \n\n";

			$body1.= "Have a fantastic day \n\n";
			$body1.= "My Namibia \n";
			//$body1 = $this->load->view('email/body_enquire',$data1 , true);
				
			$body1.= "You have received this email because we wanted to inform you that a new learning story has been published. Problems with this email? Get in touch by emailing us at info@my.na \n\n";
			
			//$body1 = $this->load->view('email/body_enquire',$data1 , true);
				
				
			$this->email->subject('Welcome to My Namibia');
			$this->email->message($body1); 
			//$this->email->attach('./img/icons/logo.png');
			
			$this->email->send();
			return;
		
	}
    //HTML 
	function send_register_link($member)
	{

			//build body
			if(isset($member['pass1'])){
				
				$data['pass'] = $member['pass1'];	
				
			}
            $location = '';
            if($country = $this->session->userdata('country')){
                $location .= $country .' ';
                if($city = $this->session->userdata('city')){

                    $location .= $city;

                }

            }

			$data['email'] = $member['email'];
			$data['base'] = $member['base'];
			$data['fname'] = $member['fname'];
			$data['confirm_link'] = $member['confirm_link'];
			//$body1 = $this->load->view('email/body_register1',$data , true);
            $body1 = "Hi " . $member['fname'] . "," . " \n\n";
            $body1.=  "You have successfully created your My.Na account and are now an official ambassador of Namibia. \n\n";

            $body1.= "To verify your email address and activate your account please click on the link below or copy and paste it into the address bar of your browser.\n\n";
            $body1.= $member['confirm_link']."\n\n";

            $body1.= "Enjoy Namibia Responsibly. \n\n";
            $body1.= "My Namibia \n\n\n\n";

            $body1.= "You have received this email because you have completed the registration form on My Namibia.\n\n Having problems? Get in touch by emailing us at info@my.na \n\n";
            $body1 .= "Registration was done on ".date('Y-m-d H:i')." with: ".$member['agent']." from ".$member['IP']." at ".$location." \n\n";

			$FROM_NAME = $data['fname'];
			$FROM_EMAIL = $member['email'];
			$mandrill = array(array('email' => $member['email']) , array('email' => 'info@my.na'));
			$subject = 'Welcome to My Namibia';
			$TAG = array('tags' => 'member_registration');

            $this->load->config('mandrill');

            $this->load->library('mandrill');

            $mandrill_ready = NULL;
            $result = '';
            try {

                $this->mandrill->init( $this->config->item('mandrill_api_key') );
                $mandrill_ready = TRUE;

            } catch(Mandrill_Exception $e) {

                $mandrill_ready = FALSE;

            }

            if( $mandrill_ready ) {

                //Send us some email!
                $email = array(
                    //Consider using a view file
                    'text' =>   $body1,
                    'subject' => $subject,
                    'from_email' => 'no-reply@my.na',
                    'headers' => array('Reply-To' => $FROM_EMAIL),
                    'from_name' => $FROM_NAME,
                    'tags' => $TAG,
                    'to' => $mandrill,
                    'google_analytics_domains' => array('my.na'),
                    'google_analytics_campaign' => 'mail',
                    'important' => true

                );

                $result = $this->mandrill->messages_send($email);

            }

            return $result;
		
	}
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND ENQUIRY EMAIL TO BUSINESS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //HTML 
	function send_enquiry($var, $row='')
	{
/*			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($var['email'],$var['name']);
			$this->email->reply_to($var['email'],$var['bname']);
			$this->email->to($var['bmail']);
			//$this->email->cc('another@another-example.com'); 
			//$this->email->bcc('them@their-example.com'); 
			//build body

			$data['email'] = $var['email'];
			$data['base'] = base_url('/');
			$data['name'] = $var['name'];
			$data['bname'] = $var['bname'];
			$data['bmail'] = $var['bmail'];
			$data['msg'] = $var['msg'];
			
			$body1 = $this->load->view('email/body_enquiry',$data , true);
				
				
			$this->email->subject('Enquiry via My Namibia');
			$this->email->message($body1); 
			//$this->email->attach('./img/icons/logo.png');
			
			$this->email->send();
			return;*/
            $location = '';
            if($country = $this->session->userdata('country')){
                $location .= $country .' ';
                if($city = $this->session->userdata('city')){

                    $location .= $city;

                }

            }
			if($row['BUSINESS_LOGO_IMAGE_NAME'] != ''){
			
				if(strpos($row['BUSINESS_LOGO_IMAGE_NAME'],'.') == 0){
		
					$format = '.jpg';
					$img_str = S3_URL.'assets/business/photos/'.$row['BUSINESS_LOGO_IMAGE_NAME'] . $format;
					
				}else{
					
					$img_str =  S3_URL.'assets/business/photos/'.$row['BUSINESS_LOGO_IMAGE_NAME'];
					
				}
			
			}else{
				
				$img_str = base_url('/').'img/bus_blank.png';	
				
			}
			$this->load->model('rating_model');
			if($this->session->userdata('id')){
				//USER AVAATER
				$u = $this->my_na_model->get_user_avatar_id($this->session->userdata('id'),60, 60, '');
				
			}else{
				$u = base_url('/').'img/user_blank.jpg';	
			}
			$claim = '';
			if(strlen($row['emails']) <= 0){
				$claim = '<p style="text-align:center">
                            	<a class="btn" href="https://www.my.na/b/'.$row['ID'].'">Claim Your Business</a>
							</p>';
				
			}
			$t_date = date('Y-m-d H:i:s', strtotime('-5 min'));
			//BUILD BODY EMAIL TO SELLER
			$body = 'Hi ,<br /><br />
						    <p>New Enquiry received for '.$row['BUSINESS_NAME'].'</p>
							<table border="0" cellpadding="0"  cellspacing="0" width="100%;max-width:580px">
							   <tr>
								  <td style="width:20%;text-align:center" ><img src="'.$u.'" alt="download picture to view" class="img-polaroid img-circle" style="width:60px;height:60px"><br /><small>'.$var['name'].'</small></td>
								  <td style="width:80%" class="white_box">'. $var['msg'].  '<br />
								    Name: <em>'.$var['name'].'</em><br />
                            		Email address: <em>'.$var['email'].'</em><br /><br />
								  <small style="font-style:italic">' .$this->rating_model->time_passed(strtotime($t_date)) . ' ' .$location.'</small></td>
								  
								  
							   </tr>
							</table><br />
                            <p>Sent from <em>'.$var['name'].'</em> via the my.na website</p>
							'.$claim.'
                            You have received this enquiry via your business profile page on My Namibia.
							<br /><br />
                            Manage your enquiries online at<br />
							<p style="text-align:center">
                            	<a class="btn" href="http://www.my.na/members/">Manage Business</a>
							</p>
                            <br /><br />
                            If you have any questions please email us at info@my.na.
                            <br /><br />
							<table cellpadding="5"  cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
							  <tr>
								<td style="width:20%"><img src="'.base_url('/').'img/timbthumb.php?src='.$img_str.'&w=100&h=100" alt="Download Images to view Business" class="img-polaroid img-rounded" alt="'.$row['BUSINESS_NAME'].'"/></td>
								<td style="width:80%">
									
									<strong>'. $row['BUSINESS_NAME'].'</strong><br />
									<strong>P:</strong>'.$row['BUSINESS_TELEPHONE'].'<br />
									<strong>E:</strong>'.$row['BUSINESS_EMAIL'].'</td>
							  </tr>
							  <tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
							  </tr>
							 
							</table>
                            Have a !na day.<br />

                            My Namibia';
			$emails = array();
			$bemail = array('email' => $row['BUSINESS_EMAIL']);
			array_push($emails, $bemail);
			if(strlen($row['emails']) > 0){
				
				$a = explode(',' ,$row['emails']);
				if(count($a) > 0){
					
					foreach($a as $row1){
						//$t = $d['email'] = $row;
						$t = array('email' => $row1);
						array_push($emails, $t);
							
					}
					
				}
				
			}
			//info
			$b = array('email' => 'info@my.na');
			array_push($emails, $b);
			$emailTO = $emails;
			$data_view['body'] = $body;
			$body_final = $this->load->view('email/body_news',$data_view,true);
			$subject = 'Enquiry via My Namibia';
			$fromEMAIL = $var['email'];
			$fromNAME = ucwords($var['name']);
			$TAG = array('tags' => 'business_enquiry' );

			//var_dump($emails);
			//echo $body_final ;
			//SEND EMAIL LINK
			$this->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG, $important = true, $global_merge = '', $merge = '', $from = 'business-no-reply');


		
	}
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL TO OFFICE AFTER REVIEW HAS BEEN SUBMITTED
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //HTML 
	function send_review_notification($var)
	{
			
			$data['rating'] = $var['RATING'];
			$data['review'] = $var['REVIEW'];
			$data['bus_id'] = $var['BUSINESS_ID'];
			$data['client_id'] = $var['CLIENT_ID'];
			$data['base'] = base_url('/');
			$body1 = $this->load->view('email/body_review_office',$data , true);

			$FROM_NAME = 'My Namibia';
			$FROM_EMAIL = 'no-reply@my.na';
			$mandrill = array(array('email' => 'roland@my.na') , array('email' => 'info@my.na'), array('email' => 'wilko@my.na'));
			$subject = 'Business Review via My Namibia';
			$TAG = array('tags' => 'review_notification');
			
			$this->send_mail($body1, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG);
			
		
	}
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL TO BUSINESS AFTER REVIEW HAS BEEN SUBMITTED
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //HTML 
	function send_review_notification_business($var)
	{

			
			$data['rating'] = $var['RATING'];
			$data['review'] = $var['REVIEW'];
			$data['bus_id'] = $var['BUSINESS_ID'];
			$data['client_id'] = $var['CLIENT_ID'];

			if($var['BUSINESS_LOGO_IMAGE_NAME'] != ''){
			
				if(strpos($var['BUSINESS_LOGO_IMAGE_NAME'],'.') == 0){
		
					$format = '.jpg';
					$img_str = S3_URL.'assets/business/photos/'.$var['BUSINESS_LOGO_IMAGE_NAME'] . $format;
					
				}else{
					
					$img_str =  S3_URL.'assets/business/photos/'.$var['BUSINESS_LOGO_IMAGE_NAME'];
					
				}
			
			}else{
				
				$img_str = base_url('/').'img/bus_blank.png';	
				
			}
			
			//USER AVAATER
			$u = $this->my_na_model->get_user_avatar_id($var['CLIENT_ID'],60, 60, $var['CLIENT_PROFILE_PICTURE_NAME']);
			
			$this->load->model('rating_model');
			$r = $this->rating_model->get_review_detail($var);
			$loc = '';
			if($var['COUNTRY_NAME'] != null){
				
				$loc = ' from '.$var['COUNTRY_NAME'];
			}
			//SEND WINNER EMAIL
			//build body
			$body = 'Hi , <br /><br />Your business '.$var['BUSINESS_NAME'] . ' has been reviewed by a user on My Namibia.<br /><br />
					<table border="0" cellpadding="0"  cellspacing="0" width="100%;max-width:580px">
					   <tr>
						  <td style="width:20%;text-align:center" ><img src="'.$u.'" alt="download picture to view" class="img-polaroid img-circle" style="width:60px;height:60px"><br /><small>'.$var['CLIENT_NAME'].' '.$var['CLIENT_SURNAME'].'</small></td>
						  <td style="width:60%" class="white_box">' .$this->rating_model->get_review_stars_img($var['RATING']) . ' <br />'. $var['REVIEW'].  '<br />
						  <small style="font-style:italic">' .$this->rating_model->time_passed(strtotime($var['TIME_VOTED'])) . ' ' .$loc.'</small></td>
						  <td style="width:20%" class="white_box">'.$r.' </td>
						  
					   </tr>
					</table><br />
					
					The team at our office has recieved a notification and will moderate the business review within 24 hours. The review will not be published if it contains offensive language 
					or doesnt offer any valued information about your business to My Namibia users. If you want to lodge a complaint or remove the review please notify us at info@my.na.<br /><br />
					<p style="text-align:center"><a href="'.site_url('/').'members/business/'.$var['BUSINESS_ID'].'/#reviews" style="color:#fff; text-decoration:none" class="btn">Respond To the Review</a></p>
					<br /><br />
					<table cellpadding="5"  cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
					  <tr>
					  	<td style="width:20%"><img src="'.base_url('/').'img/timbthumb.php?src='.$img_str.'&w=100&h=100" alt="Download Images to view Business" class="img-polaroid img-rounded" alt="'.$var['BUSINESS_NAME'].'"/></td>
						<td style="width:80%">
							
							<strong>'. $var['BUSINESS_NAME'].'</strong><br />
							<strong>P:</strong>'.$var['BUSINESS_TELEPHONE'].'<br />
							<strong>E:</strong>'.$var['BUSINESS_EMAIL'].'</td>
					  </tr>
					  <tr>
					  	<td>&nbsp;</td>
						<td>&nbsp;</td>
					  </tr>
					 
					</table>Have a !na day<br />'  
					
					;
			$emails = array();
			$bemail = array('email' => $var['BUSINESS_EMAIL']);
			array_push($emails, $bemail);
			if(strlen($var['emails']) > 0){
				
				$a = explode(',' ,$var['emails']);
				if(count($a) > 0){
					
					foreach($a as $row){
						//$t = $d['email'] = $row;
						$t = array('email' => $row);
						array_push($emails, $t);
							
					}
					
				}
				
			}
			//info
			$b = array('email' => 'info@my.na');
			array_push($emails, $b);
			$data['email'] = 'no-reply@my.na';
			$data['base'] = base_url('/');
			$data['body'] = $body;
			
			$body1 = $this->load->view('email/body_news',$data , true);
				
			$FROM_NAME = 'My Namibia';
			$FROM_EMAIL = 'no-reply@my.na';
			$mandrill = $emails;
			$subject = 'New Business Review via My Namibia';
			$TAG = array('tags' => 'review_notification');
			
			
			//var_dump($mandrill);
			//echo $body1;
			$this->send_mail($body1, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG);

		
	}
	
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL TO BUSINESS AFTER REVIEW HAS BEEN SUBMITTED
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //HTML 
	function send_review_notification_product($var)
	{

			


			//USER AVAATER
			$u = $this->my_na_model->get_user_avatar_id($var['CLIENT_ID'],60, 60, $var['CLIENT_PROFILE_PICTURE_NAME']);
			
			$this->load->model('rating_model');
			$r = $this->rating_model->get_review_detail($var);
			$loc = '';
			if($var['COUNTRY_NAME'] != null){
				
				$loc = ' from '.$var['COUNTRY_NAME'];
			}
			
			//GET PRODUCT && SLLER DETAILS
			$query1 = $this->db->query("SELECT products.*, u_client.*, product_images.img_file FROM products
										JOIN u_client ON u_client.ID = products.client_id
										LEFT JOIN product_images ON product_images.product_id = products.product_id
										WHERE products.product_id = '". $var['PRODUCT_ID']."'
										GROUP BY products.product_id 
										ORDER BY product_images.sequence ASC
										");
			if($query1->result()){
				
				$product = $query1->row_array();
				
				//GET PRODUCT IMAGES
				
				$images = '';
			
				if(strlen($product['img_file']) > 0){
					$images .= "<table>
									<tbody>
										<tr>";
					
					$images .= '<td style="" class="white_box"><img src="'.base_url('/').'img/timbthumb.php?src='.CDN_URL.'assets/products/images/'.$product['img_file'].'&w=580&h=300" style="width:100%; "></td>';
						
				
					$images .= "		</tr>
									</tbody>
								</table>";	
				}
			}
			

			//info
			$b = array('email' => 'info@my.na');
			//array_push($emails, $b);
			$emailTO = array(array('email' => $product['CLIENT_EMAIL'] )); 
				
			//BUILD BODY EMAIL TO SELLER
			$body_seller = 'Hi '.$product['CLIENT_NAME'] .',<br /><br />
					Your product '.$product['title'] . ' listed on My Namibia&trade; trade has been reviewed. <br /><br />
					<table border="0" cellpadding="0"  cellspacing="0" width="100%;max-width:580px">
					   <tr>
						  <td style="width:20%;text-align:center" ><img src="'.$u.'" alt="download picture to view" class="img-polaroid img-circle" style="width:60px;height:60px"><br /><small>'.$var['CLIENT_NAME'].' '.$var['CLIENT_SURNAME'].'</small></td>
						  <td style="width:80%" class="white_box">' .$this->rating_model->get_review_stars_img($var['RATING']) . ' <br />'. $var['REVIEW'].  '<br />
						  <small style="font-style:italic">' .$this->rating_model->time_passed(strtotime($var['TIME_VOTED'])) . ' ' .$loc.'</small></td>
						  
						  
					   </tr>
					</table><br /><br />
					'.$images.'<br /><br />
					<p style="text-align:center"><a href="'.site_url('/').'product/'.$var['PRODUCT_ID'].'/#reviews" style="color:#fff; text-decoration:none" class="btn">View the Review Here</a></p>

					<br /><br />
					Have a !na day!<br />
					My Namibia';
					
			$data_view['body'] = $body_seller;
			$body_seller_final = $this->load->view('email/body_news',$data_view,true);
			$subject = 'Review: '.$product['title'];
			$fromEMAIL = 'no-reply@my.na';
			$fromNAME = 'My Namibia Trade';
			$TAG = array('tags' => 'trade_review' );
				
			//SEND EMAIL LINK
	
			$this->send_mail($body_seller_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);

			//BUILD BODY EMAIL TO REVIEWER
			$body_reviewer = 'Hi '.$var['CLIENT_NAME'] .',<br /><br />
					Your product review for '.$product['title'] . ' listed on My Namibia&trade; trade has been authorized and published.
					Your account has been credited with 3 !na points.<br /><br />
					<table border="0" cellpadding="0"  cellspacing="0" width="100%;max-width:580px">
					   <tr>
						  <td style="width:20%;text-align:center" ><img src="'.$u.'" alt="download picture to view" class="img-polaroid img-circle" style="width:60px;height:60px"><br /><small>'.$var['CLIENT_NAME'].' '.$var['CLIENT_SURNAME'].'</small></td>
						  <td style="width:80%" class="white_box">' .$this->rating_model->get_review_stars_img($var['RATING']) . ' <br />'. $var['REVIEW'].  '<br />
						  <small style="font-style:italic">' .$this->rating_model->time_passed(strtotime($var['TIME_VOTED'])) . ' ' .$loc.'</small></td>
						  
						  
					   </tr>
					</table><br /><br />
					'.$images.'<br /><br />
					<p style="text-align:center"><a href="'.site_url('/').'product/'.$var['PRODUCT_ID'].'/#reviews" style="color:#fff; text-decoration:none" class="btn">View the Review Here</a></p>
					
					
					
					<br /><br />
					Have a !na day!<br />
					My Namibia';
			
			$emailTO_reviewer = array(array('email' => $var['CLIENT_EMAIL'] )); 		
			$data_view2['body'] = $body_reviewer;
			$body_reviewer_final = $this->load->view('email/body_news',$data_view2,true);
			$subject_reviewer = 'Your Review: '.$product['title'];
			$fromEMAIL_reviewer = 'no-reply@my.na';
			$fromNAME_reviewer = 'My Namibia Trade';
			$TAG = array('tags' => 'trade_review' );
				
			//SEND EMAIL LINK
			//var_dump($emailTO_reviewer);
			//var_dump($emailTO);
			//echo $body_reviewer_final;
			$this->send_mail($body_reviewer_final, $subject_reviewer, $emailTO_reviewer, $fromEMAIL_reviewer, $fromNAME_reviewer, $TAG);
		
	}	
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    //HTML 
	function send_email($emailTO, $emailFROM , $name , $body , $subject )
	{
			
			$data['email'] = $emailFROM;
			$data['base'] = base_url('/');
			$data['body'] = $body;
			
			$body1 = $this->load->view('email/body_news',$data , true);

            if(is_array($emailTO)){

                $mandrill = $emailTO;

            }else{

                $mandrill = array(array('email' => $emailTO));

            }


			$FROM_EMAIL = $emailFROM;
			$FROM_NAME = 'MY Namibia';
			$TAG = array('tags' => 'general');
			$this->send_mail($body1, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG);
			
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//UPDATE MSG STATUS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function update_msg_status($msg_id, $status, $type){
		
		if($type == 'Business'){
			
			$data = array(
               'status' => $status
            );
		
		}else{
			$data = array(
               'status_client' => $status
            );
		
			
		}
         
		$this->db->where('msg_id', $msg_id);
		$this->db->update('u_business_messages', $data);
			
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET MSG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_message($msg_id){
		
        $test = $this->db->from('u_business_messages');
		$test = $this->db->where('msg_id', $msg_id);
		//$test = $this->db->where('status', 'unread');
		$test = $this->db->get();
		return $test->row_array();		
		
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SHOW !na EMAIL for BUSINESS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function get_business_enquiries_status($bus_id,$status){
      	
		if($status == 'all'){
			
			$status =  " AND status != 'sent' AND status != 'trash'";
		}else{
			
			$status =  " AND status ='" . $status."'";	
		}
		
		$read = "update_msg('read');";$unread = "update_msg('unread');";$trash = "update_msg('trash');";$refresh = "load_mail(".$bus_id.",'all');";
		$inbox = "load_mail(".$bus_id.",'all')";$sent = "load_mail(".$bus_id.",'sent')";$trashlink = "load_mail(".$bus_id.",'trash')";

		if($bus_id == 0){

			$query = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' ".$status ." ORDER BY timestamp DESC" ,FALSE);

		}else{


			$query = $this->db->query("SELECT * FROM u_business_messages WHERE bus_id = '".$bus_id."' ".$status ." ORDER BY timestamp DESC" ,FALSE);

		}


		if($query->result()){
			echo'
			<h4>!na Mail<small> Inbox</small></h4>
			<div id="inbox_msg"></div>
			 <div class="btn-group">
			  <a class="btn" href="#"><input rel="tooltip" title="Select All" style="margin-top:-1px" type="checkbox" name="selectallM" id="selectallM"  /></a>
			  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				  Action
				<span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu">
				<li><a style="cursor:pointer;" onClick="'.$read.'">Mark as read</a></li>
				<li><a style="cursor:pointer;" onClick="'.$unread.'">Mark as unread</a></li>
				<li><a style="cursor:pointer;" onClick="'.$trash.'">Move to Trash</a></li>
				<li><a style="cursor:pointer;" onClick="delete_msg()">Delete</a></li>
				<li><a style="cursor:pointer;" onclick="'.$refresh.'">Refresh</a></li>
			  </ul>
			</div>
			<a onClick="'.$inbox.'" class="btn"><i class="icon-inbox"></i> Inbox</a> <a onclick="'.$sent.'" class="btn"><i class="icon-share"></i> Sent Mail</a> <a onclick="'.$trashlink.'" class="btn"><i class="icon-trash"></i> Trash</a>
       		 <div class="clearfix" style="height:10px;"></div>
			<form action="" id="frm_update_msg" name="frm_update_msg" method="post"/>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example1" width="100%">
				<thead>
					<tr style="font-weight:bold">
					    <th style="width:5%;min-width:20px"></th>
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:25%">Subject</th>
						<th style="width:25%">Message</th>
						<th style="width:20%">Time </th>
					</tr>
				</thead>
				<tbody>
				 
				';
			
			foreach($query->result() as $row){
				
				if($row->client_id != '0'){
					$avatar = $this->get_avatar($row->client_id);
				
				}else{
					 $avatar['image'] = base_url('/').'img/user_blank.jpg';
					 $avatar['name'] = $row->nameFROM;
				}
				$java = $row->msg_id.",".$row->bus_id.",'".$row->status."'";
				if($row->status == 'unread'){
					$subj = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;font-weight:bold">'.$row->subject.'<br /><font style="font-size:10px">'.$avatar['name'].'</font></div></a>';
					$body = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;font-weight:bold">'.strip_tags(str_replace('-','',$row->body)).'</div></a>';
				}else{
				    $subj = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;">'.$row->subject.'<br /><font style="font-size:10px">'.$avatar['name'].'</font></div></a>';
					$body = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;">'.strip_tags(str_replace('-','',$row->body)).'</div></a>';
				}
						
				echo '<tr>
				        <td style="width:5%;min-width:20px"><input type="checkbox" class="caseM" name="messages['.$row->msg_id.']" value="'. $row->msg_id.'"></td>
						<td style="width:5%;min-width:40px"><img src="'.$avatar['image'] .'" alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:25%">'.$subj .'</td>
						<td style="width:45%">'.$this->shorten_string($body ,12) .'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->timestamp)).'</td>
					  </tr>';
			}
			
			
			echo '
			</tbody>
				</table>
				</form>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				
				<script data-cfasync="false" type="text/javascript">
					$("#selectallM").click(function () {
						  $(".caseM").attr("checked", this.checked);
					});
					$(".caseM").click(function(){
				 		
						if($(".caseM").length == $(".caseM:checked").length) {
							$("#selectallM").attr("checked", "checked");
						} else {
							$("#selectallM").removeAttr("checked");
						}
						
					});
					function update_msg(str){
							$("#enquiries").addClass("loading_img");	
							var postdata = $("input[type=checkbox]").serialize();
									$.ajax({
										type: "post",
										url: "'.site_url('/').'tna_mail/update_msg_status/"+str+"/Business" ,
										data:  postdata,
										success: function (data) {
											 $("#inbox_msg").html(data);
											 load_mail('.$bus_id.',"all");
											 $("#enquiries").removeClass("loading_img");	
										}
									});	
					}
				
				</script>';
			
		 }else{
			echo'<h4>!na Mail<small> Inbox</small></h4>
			<div id="inbox_msg"></div>
			 <div class="btn-group">
			  <a class="btn" href="#"><input rel="tooltip" title="Select All" style="margin-top:-1px" type="checkbox" name="selectallM" id="selectallM"  /></a>
			  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				  Action
				<span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu">
				<li><a onClick="'.$read.'">Mark as read</a></li>
				<li><a onClick="'.$unread.'">Mark as unread</a></li>
				<li><a onClick="'.$trash.'">Move to Trash</a></li>
				<li><a id="mark_del" href="#">Delete</a></li>
				<li><a onclick="load_tab('.$bus_id.',"enquiries");">Refresh</a></li>
			  </ul>
			</div>
			<a onClick="'.$inbox.'" class="btn"><i class="icon-inbox"></i> Inbox</a> <a onclick="'.$sent.'" class="btn"><i class="icon-share"></i> Sent Mail</a> <a onclick="'.$trashlink.'" class="btn"><i class="icon-trash"></i> Trash</a>
       		 <div class="clearfix" style="height:10px;"></div>';
			echo "<div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button>
			<h3>No messages</h3>
			There are no messages  to display in the current folder.
			 </div>"; 
		 }
		  	  
    }
	


    function get_member_messages($id,$status) {

		$this->load->model('image_model'); 

		$this->load->library('thumborp');
		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 25;
		$height = 25;

    	$res = '';

		if($status == 'all'){
			$status =  " AND status_client != 'sent' AND status_client != 'trash'";
		}else{
			$status =  " AND status_client ='" . $status."'";	
		}

		$query = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$id."' ".$status ." ORDER BY timestamp DESC" ,FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				//GET BUSINESS LOGO
				if($row->bus_id_logo != '0'){

					$avatar = $this->get_business_logo($row->bus_id_logo);
					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory,$avatar['image'],$width,$height, $crop = '');

				}elseif($row->client_id != '0'){

					$avatar = $this->get_avatar($row->client_id);
					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory,$avatar['image'],$width,$height, $crop = '');

				}else{

				    $avatar['image'] = 'assets/business/photos/user_blank.jpg';
					$avatar['name'] = $row->nameFROM;

				}

				$java = $row->msg_id.",".$row->bus_id.",'".$row->status."'";
				if($row->status_client == 'unread'){
					$subj = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;font-weight:bold">'.$row->subject.'<br /><font style="font-size:10px">'.$avatar['name'].'</font></div></a>';
					$body = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;font-weight:bold">'.strip_tags(str_replace('-','',$row->body)).'</div></a>';
				}else{
				    $subj = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;">'.$row->subject.'<br /><font style="font-size:10px">'.$avatar['name'].'</font></div></a>';
					$body = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;">'.strip_tags(str_replace('-','',$row->body)).'</div></a>';
				}

				$res .= '
			    <tr>
			      <td><input type="checkbox" class="caseM" name="messages['.$row->msg_id.']" value="'. $row->msg_id.'"></td>
			      <td><img src="'.$img_url.'" alt="" class="img-thumbnail"/></td>
			      <td>'.$subj.'</td>
			      <td>'.$this->shorten_string($body ,12).'</td>
			      <td>'.date('Y-m-d',strtotime($row->timestamp)).'</td>
			    </tr>				
				';

			}

		} else {

			$res .= '
			<tr>
				<td colspan="5">
					<h3><strong>No mail</strong></h3>
					There are no messages to display in the current folder.
				</td>
			</tr>
			';

		}

		return $res;

    }



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SHOW !na EMAIL for MEMBERS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function get_messages_status($id,$status){
      	 
		if($status == 'all'){
			
			$status =  " AND status_client != 'sent' AND status_client != 'trash'";
		}else{
			
			$status =  " AND status_client ='" . $status."'";	
		}
		
		$read = "update_msg('read');";
		$unread = "update_msg('unread');";
		$trash = "update_msg('trash');";
		$refresh = "load_mail('all');";
		$inbox = "load_mail('all')";
		$sent = "load_mail('sent')";
		$trashlink = "load_mail('trash')";
		
		$query = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$id."' ".$status ." ORDER BY timestamp DESC" ,FALSE);
		if($query->result()){
			echo'
			<h4>!na Mail<small> Inbox</small></h4>
			<div id="inbox_msg"></div>
			 <div class="btn-group">
			  <a class="btn" href="#"><input rel="tooltip" title="Select All" style="margin-top:-1px" type="checkbox" name="selectallM" id="selectallM"  /></a>
			  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				  Action
				<span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu">
				<li><a style="cursor:pointer;" onClick="'.$read.'">Mark as read</a></li>
				<li><a style="cursor:pointer;" onClick="'.$unread.'">Mark as unread</a></li>
				<li><a style="cursor:pointer;" onClick="'.$trash.'">Move to Trash</a></li>
				<li><a style="cursor:pointer;" onClick="delete_msg()">Delete</a></li>
				<li><a style="cursor:pointer;" onclick="'.$refresh.'">Refresh</a></li>
			  </ul>
			</div>
			<a onClick="'.$inbox.'" class="btn"><i class="icon-inbox"></i> Inbox</a> <a onclick="'.$sent.'" class="btn"><i class="icon-share"></i> Sent Mail</a> <a onclick="'.$trashlink.'" class="btn"><i class="icon-trash"></i> Trash</a>
       		 <div class="clearfix" style="height:10px;"></div>
			<form action="" id="frm_update_msg" name="frm_update_msg" method="post"/>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example1" width="100%">
				<thead>
					<tr style="font-weight:bold">
					    <th style="width:5%;min-width:20px"></th>
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:25%">Subject</th>
						<th style="width:25%">Message</th>
						<th style="width:20%">Time </th>
					</tr>
				</thead>
				<tbody>
				 
				';
			
			foreach($query->result() as $row){
				
				//GET BUSINESS LOGO
				if($row->bus_id_logo != '0'){
					$avatar = $this->get_business_logo($row->bus_id_logo);
				
				}elseif($row->client_id != '0'){
					$avatar = $this->get_avatar($row->client_id);
				}else{
				    $avatar['image'] = base_url('/').'img/user_blank.jpg';
					 $avatar['name'] = $row->nameFROM;
				}
			
				$java = $row->msg_id.",".$row->bus_id.",'".$row->status."'";
				if($row->status_client == 'unread'){
					$subj = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;font-weight:bold">'.$row->subject.'<br /><font style="font-size:10px">'.$avatar['name'].'</font></div></a>';
					$body = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;font-weight:bold">'.strip_tags(str_replace('-','',$row->body)).'</div></a>';
				}else{
				    $subj = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;">'.$row->subject.'<br /><font style="font-size:10px">'.$avatar['name'].'</font></div></a>';
					$body = '<a style="text-decoration:none;" onclick="load_msg('.$java.')"><div style="color:#666;cursor:pointer;width:100%;height:100%;">'.strip_tags(str_replace('-','',$row->body)).'</div></a>';
				}
						
				echo '<tr>
				        <td style="width:5%;min-width:20px"><input type="checkbox" class="caseM" name="messages['.$row->msg_id.']" value="'. $row->msg_id.'"></td>
						<td style="width:5%;min-width:40px"><img src="'.$avatar['image'] .'" alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:25%">'.$subj .'</td>
						<td style="width:45%">'.$this->shorten_string($body ,12) .'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->timestamp)).'</td>
					  </tr>';
			}
			
			
			echo '
			</tbody>
				</table>
				</form>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				
				<script data-cfasync="false" type="text/javascript">
					$("#selectallM").click(function () {
						  $(".caseM").attr("checked", this.checked);
					});
					$(".caseM").click(function(){
				 		
						if($(".caseM").length == $(".caseM:checked").length) {
							$("#selectallM").attr("checked", "checked");
						} else {
							$("#selectallM").removeAttr("checked");
						}
						
					});
					function update_msg(str){
							$("#enquiries").addClass("loading_img");	
							var postdata = $("input[type=checkbox]").serialize();
									$.ajax({
										type: "post",
										url: "'.site_url('/').'tna_mail/update_msg_status/"+str+"/Client" ,
										data:  postdata,
										success: function (data) {
											 $("#inbox_msg").html(data);
											 load_mail("all");
											 $("#enquiries").removeClass("loading_img");	
										}
									});	
					}
				
				</script>';
			
		 }else{
			echo'<h4><font class="na_script" style="font-size:20px">!na</font> Mail<small> Inbox</small></h4>
			<div id="inbox_msg"></div>
			 <div class="btn-group">
			  <a class="btn" href="#"><input rel="tooltip" title="Select All" style="margin-top:-1px" type="checkbox" name="selectallM" id="selectallM"  /></a>
			  <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
				  Action
				<span class="caret"></span>
			  </a>
			  <ul class="dropdown-menu">
				<li><a onClick="'.$read.'">Mark as read</a></li>
				<li><a onClick="'.$unread.'">Mark as unread</a></li>
				<li><a onClick="'.$trash.'">Move to Trash</a></li>
				<li><a id="mark_del" href="#">Delete</a></li>
				<li><a onclick="load_mail("all");">Refresh</a></li>
			  </ul>
			</div>
			<a onClick="'.$inbox.'" class="btn"><i class="icon-inbox"></i> Inbox</a> <a onclick="'.$sent.'" class="btn"><i class="icon-share"></i> Sent Mail</a> <a onclick="'.$trashlink.'" class="btn"><i class="icon-trash"></i> Trash</a>
       		 <div class="clearfix" style="height:10px;"></div>';
			echo "<div class='alert alert-block'><button type='button' class='close' data-dismiss='alert'>×</button>
			<h3>No messages</h3>
			There are no messages  to display in the current folder.
			 </div>"; 
		 }
		  	  
    }


    //+++++++++++++++++++++++++++
    //GET EMAIL LOGS
    //++++++++++++++++++++++++++
    public function get_email_stats($query, $date_from , $date_to , $tags , $senders , $limit)
    {


        $this->load->config('mandrill');

        $this->load->library('mandrill');

        $mandrill_ready = NULL;

        try {

            $this->mandrill->init( $this->config->item('mandrill_api_key') );
            $mandrill_ready = TRUE;
            $result = 'yes';
        } catch(Mandrill_Exception $e) {
            echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
            $mandrill_ready = FALSE;
            $result = 'no';
            throw $e;
        }

        if( $mandrill_ready ) {



            $result = $this->mandrill->tags_list();

        }

        //var_dump($result);
        return $result;


    }



    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET USER AVATAR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_avatar($id){
		
		$this->db->select('ID , CLIENT_PROFILE_PICTURE_NAME as PIC, CLIENT_NAME');
		$this->db->where('ID',$id);
		$query = $this->db->get('u_client');
		$row = $query->row_array();
		
		if($row['PIC'] != '' || $row['PIC'] != NULL){
			
			//Build image string
			$format = substr($row['PIC'],(strlen($row['PIC']) - 4),4);
			$str = substr($row['PIC'],0,(strlen($row['PIC']) - 4));
			
			if(strstr($row['PIC'], "http")){
					
				$avatar['image'] = $row['PIC'];
				
			}elseif(strpos($row['PIC'],'.') == 0){
	
				$format = '.jpg';
				$avatar['image'] = CDN_URL.'assets/users/photos/'.$row['PIC'] . $format;
				
			}else{
				
				$avatar['image'] =  CDN_URL.'assets/users/photos/'.$row['PIC'];
				
			}
			
			
		}else{
			
			$avatar['image'] = base_url('/').'img/user_blank.jpg';
			
		}
		$avatar['name'] = $row['CLIENT_NAME'];
		return $avatar;
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET USER AVATAR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_business_logo($bus_id){
		
		$this->db->select('ID , BUSINESS_LOGO_IMAGE_NAME as PIC, BUSINESS_NAME');
		$this->db->where('ID',$bus_id);
		$query = $this->db->get('u_business');
		$row = $query->row_array();
		
		if($row['PIC'] != '' || $row['PIC'] != NULL){
			
			//Build image string
			$format = substr($row['PIC'],(strlen($row['PIC']) - 4),4);
			$str = substr($row['PIC'],0,(strlen($row['PIC']) - 4));
			
			if(strpos($row['PIC'],'.') == 0){
	
				$format = '.jpg';
				$avatar['image'] = 'assets/business/photos/'.$row['PIC'] . $format;
				
			}else{
				
				$avatar['image'] = 'assets/business/photos/'.$row['PIC'];
				
			}
			
			
		}else{
			
			$avatar['image'] = 'assets/business/photos/bus_blank.jpg';
			
		}

		$avatar['name'] = $row['BUSINESS_NAME'];
		return $avatar;

	}
	
	
	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
	//+++++++++++++++++++++++++++
	//GET BUSINESS DETAILS
	//++++++++++++++++++++++++++
    public function getBusiness($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->query("SELECT * FROM u_business WHERE ID = '".$id."'", FALSE);
		$row = $query->row_array();
		return $row;
		
    }
}
?>