<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tna_mail extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function Tna_mail()
	{
		parent::__construct();
		$this->load->model('email_model');
	}
	
	
	public function index()
	{
		echo 'Going nowhere slowly';
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//TNA MAIL
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//INBOX
	//++++++++++++++++++++++++++
	public function inbox($bus_id)
	{
		
		if($this->session->userdata('id')){
			 	$this->load->model('members_model');
				
				$data['id'] = $this->session->userdata('id');
				$data['bus_id'] = $bus_id;
				$this->load->view('members/inbox', $data);	
		
		}else{
			
				$this->load->view('login');
			  
		 }
	
	}
		
	//+++++++++++++++++++++++++++
	//BUILD MAIL
	//++++++++++++++++++++++++++
	public function tna_mail_build($bus_id)
	{
		
		if($this->session->userdata('id')){
			 	
				$msg = $this->un_clean_url($this->uri->segment(4));
				
				$data['id'] = $this->session->userdata('id');
				$data['bus_id'] = $bus_id;
				if($msg != ''){
					$data['basicmsg'] = $msg;
				}
				$this->load->view('members/build_mail', $data);	
		
		}else{
			
				$this->load->view('login');
			  
		 }
	
	}
	
	
	
	//+++++++++++++++++++++++++++
	//LOAD MAILBOX TYPE, INBOX,SENT etc FOR BUSINESS
	//++++++++++++++++++++++++++
	public function load_mail($bus_id,$status)
	{
		
		if($this->session->userdata('id')){
			 	
				$this->load->model('email_model');
				if($status == ''){
			
					$status = 'all';
				
				}
				$this->email_model->get_business_enquiries_status($bus_id ,$status);
		
		}else{
			
				$this->load->view('login');
			  
		 }
	
	}
	//+++++++++++++++++++++++++++
	//LOAD MAILBOX TYPE, INBOX,SENT etc for MEMBERS
	//++++++++++++++++++++++++++
	public function load_mail_member($status)
	{
		
		if($this->session->userdata('id')){
			 	
				$this->load->model('email_model');
				if($status == ''){
			
					$status = 'all';
				
				}
				$this->email_model->get_messages_status($this->session->userdata('id') ,$status);
		
		}else{
			
				$this->load->view('login');
			  
		 }
	
	}
	
	
	//+++++++++++++++++++++++++++
	//RELOAD NOTIFICATIONS
	//++++++++++++++++++++++++++
	//TOTAL = ALL
	public function reload_notify_count()
	{
		$this->my_na_model->msg_notifications_count();
	}
	//BUSINESS SPECIFIC
	public function reload_notify_count_business($bus_id)
	{
		$this->my_na_model->msg_notifications_business($bus_id);
	}
	//ONLY MEMBER
	public function reload_notify_count_member()
	{
		$this->my_na_model->msg_notifications_member();
	}
	
	
	//+++++++++++++++++++++++++++
	//UPDATE MSG STATUS
	//++++++++++++++++++++++++++
	public function update_msg_status($status, $type)
	{
		if(!empty($_POST['messages'])) {
			 $x = 0;
				foreach($_POST['messages'] as $value) {
						 	
							if($type == 'Business'){
							
							 $data = array(
								   'status' => $status
								);
							
							}else{
								
								$data = array(
								   'status_client' => $status
								);
								
							}
							$this->db->where('msg_id', $value);
							$this->db->update('u_business_messages', $data);
							$x++;
				
				}
			echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
			Succesfully updated Emails!</div>";
		
					 
		 }else{
			 
			echo $status."<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>
			Error </div>"; 
			 
		 }
		
	
	}
	
	//+++++++++++++++++++++++++++
	//VIEW MESSAGE BUSINESS
	//++++++++++++++++++++++++++		
	function view_msg_business($msg_id, $bus_id, $status)
	{
         
		  if($this->session->userdata('id')){
			  
					
				$this->email_model->update_msg_status($msg_id, 'read','Business');
		
				 
				 $data = $this->email_model->get_message($msg_id);
				 $click = "load_mail('".$bus_id."','all')";
			
		 		 
				 if($data['client_id'] != '0'){

					 if($data['client_id_logo'] != '0')
					 {
						 $avatar = $this->get_avatar($data['client_id']);
					 }else{

						 $avatar = $this->get_avatar($data['client_id']);

					 }
				 }else{
				   $avatar = base_url('/').'img/user_blank.jpg';
				 }
				 
				 echo '<div class="row-fluid">
							<div class="span8">
							   <div id="view_msg">
								   <h3>'.$data['subject'].'</h3>'
								  .'<p>'.$data['body'].'</p>'
								  .'<p style="font-size:10px;font-style:italic">'. date('l jS \of F Y h:i:s A', strtotime($data['timestamp'])) .'</p>
								  <hr />
								   <a onclick="reply_message()" class="btn"><i class="icon-arrow-left"></i> Reply</a>
							   	   <a onClick="'.$click.'" class="btn"><i class="icon-envelope"></i> Inbox</a>
							   </div>
							   
							   <div id="reply_msg" style="display:none">
							   		<h3>'.$data['subject'].'</h3>
									<form id="replymail" name="replymail" >
										<input type="hidden" name="cur_state" id="cur_state" value="'.$data['status'].'">
										<input type="hidden" name="bus_id_reply" id="bus_id_reply" value="'.$bus_id.'">
										<input type="hidden" name="msg_id_reply" id="msg_id_reply" value="'.$msg_id.'">
										<input type="hidden" name="client_id_reply" id="client_id_reply" value="'.$data['client_id'].'">
										<input type="hidden" name="emailTO" id="emailTO" value="'.$data['email'].'">
										<input type="hidden" name="emailFROM" id="emailFROM" value="'.$data['emailTO'].'">
										<input type="hidden" name="subject" id="subject" value="'.$data['subject'].'">
										<input type="hidden" name="name_from" id="name_from" value="'.$data['nameFROM'].'">
										<input type="hidden" name="name_to" id="name_to" value="'.$data['nameTO'].'">
										<textarea id="reply_redactor_content" name="reply_content">
										<br /><br /><br />
										-------------------------------------------------------<br />'
										.date('l jS \of F Y h:i:s A', strtotime($data['timestamp'])).'<br />
										-------------------------------------------------------<br />
										<p>'.$data['body'].'</p><em>'.date('l jS \of F Y h:i:s A', strtotime($data['timestamp'])).'</em>
										 </textarea>
										<br />
										<div id="reply_msg"></div>
										<hr />
										<a id="reply_email_yes" class="btn"><i class="icon-envelope"></i> Reply</a>
										<a onClick="'.$click.'" class="btn"><i class="icon-envelope"></i> Inbox</a>
									</form> 
								</div>	  	
								
							</div>
							<div class="span4">
								
									 <div class="popover right" style="display:block;position:relative">
										<div class="arrow"></div>
										<h3 class="popover-title">From: </h3>
										<div class="popover-content">
										  <img src="'.$avatar .'" alt="" style="width:40px;height:40px;float:left;margin:0px 5px 5px 0px" class="img-polaroid" />
										  <p>'.$data['nameFROM'].'</p><small style="color:#CCC">'.date('M d',strtotime($data['timestamp'])).'</small>
										  <div class="clearfix" style="height:15px;"></div>
										</div>
									  
								</div>
								  		
							</div>	
						</div>
						<div class="clearfix" style="height:30px;"></div>
				
						<script data-cfasync="false" type="text/javascript">
							function reply_message(){
							
								$("#view_msg").hide();
								$("#reply_msg").fadeIn();
								$("#reply_redactor_content").prepend();
								$("#reply_redactor_content").focus();
							}
							$("#reply_redactor_content").redactor({ 	
				
									buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
									"unorderedlist", "orderedlist", "outdent", "indent", "|",
									"video", "table","|",
									 "alignment", "|", "horizontalrule"]
							});
							$("#reply_email_yes").live("click", function() { 	
								
								var frm = $("#replymail");
								frm.attr("action","'. site_url('/').'tna_mail/reply_email/");

								$("#reply_email_yes").html("Sending...");
									
									$.ajax({
										type: "post",
										cache: false,
										data: frm.serialize(),
										url: "'.site_url('/').'tna_mail/reply_email/" ,
										success: function (data) {
											$("#reply_email_yes").html("Sent!");
											$("#reply_msg").html(data);
											
										}
									});	
								
						});		
						</script>';
					   	
				  
		  }else{
			
				redirect('/members/logout', 'refresh');
			  
		  }
		 
	}
	//+++++++++++++++++++++++++++
	//VIEW MESSAGE MEMBER
	//++++++++++++++++++++++++++		
	function view_msg($msg_id, $bus_id, $status)
	{
         
		  if($this->session->userdata('id')){
			  
					
				$this->email_model->update_msg_status($msg_id, 'read','Client');
		
				 
				 $data = $this->email_model->get_message($msg_id);
				 $click = "load_mail('all')";
			
		 		 
				 if($data['status'] == 'sent' || $data['status'] == 'replied' ){
					 
					 if($data['bus_id'] != 0 && $data['bus_id_logo'] != 0){
						 
					 	$avatar = $this->get_business_logo($data['bus_id']);
					 }else{

                         if($data['client_id_logo'] != 0){

                             $avatar = $this->get_user_avatar($data['client_id_logo']);
                         }else{

                             $avatar = $this->get_user_avatar($data['client_id']);
                         }

					 }
				 }elseif($data['status'] == 'unread'){
                     if($data['client_id_logo'] != 0){

                         $avatar = $this->get_user_avatar($data['client_id_logo']);
                     }else{

                         $avatar = $this->get_user_avatar($data['client_id']);
                     }
				 }else{
				   $avatar = base_url('/').'img/user_blank.jpg';
				 }
				 
				 echo '<div class="row-fluid">
							<div class="span8">
							   <div id="view_msg">
								   <h3>'.$data['subject'].'</h3>'
								  .'<p>'.$data['body'].'</p>'
								  .'<p style="font-size:10px;font-style:italic">'. date('l jS \of F Y h:i:s A', strtotime($data['timestamp'])) .'</p>
								  <hr />
								   <a onclick="reply_message()" class="btn"><i class="icon-arrow-left"></i> Reply</a>
							   	   <a onClick="'.$click.'" class="btn"><i class="icon-envelope"></i> Inbox</a>
							   </div>
							   
							   <div id="reply_msg" style="display:none">
							   		<h3>'.$data['subject'].'</h3>
									<form id="replymail" name="replymail" >
									    <input type="hidden" name="cur_state" id="cur_state" value="'.$data['status'].'">
										<input type="hidden" name="bus_id_reply" id="bus_id_reply" value="'.$bus_id.'">
										<input type="hidden" name="msg_id_reply" id="msg_id_reply" value="'.$msg_id.'">
										<input type="hidden" name="client_id_reply" id="client_id_reply" value="'.$data['client_id'].'">
										<input type="hidden" name="emailTO" id="emailTO" value="'.$data['email'].'">
										<input type="hidden" name="emailFROM" id="emailFROM" value="'.$data['emailTO'].'">
								        <input type="hidden" name="name_from" id="name_from" value="'.$data['nameFROM'].'">
										<input type="hidden" name="name_to" id="name_to" value="'.$data['nameTO'].'">
										<textarea id="reply_redactor_content" name="reply_content">
										<br /><br /><br />
										-------------------------------------------------------<br /><em>'
										.date('l jS \of F Y h:i:s A', strtotime($data['timestamp'])).'</em><br />
										-------------------------------------------------------<br />
										<p>'.$data['body'].'</p>
										 </textarea>
										<br />
										<div id="reply_msg"></div>
										<hr />
										<a id="reply_email_yes" class="btn"><i class="icon-envelope"></i> Reply</a>
										<a onClick="'.$click.'" class="btn"><i class="icon-envelope"></i> Inbox</a>
									</form> 
								</div>	  	
								
							</div>
							<div class="span4">
								
									 <div class="popover right" style="display:block;position:relative">
										<div class="arrow"></div>
										<h3 class="popover-title">From: </h3>
										<div class="popover-content">
										  <img src="'.$avatar['image'] .'" alt="" style="width:40px;height:40px;float:left;margin:0px 5px 5px 0px" class="img-polaroid" />
										  <p>'.$data['nameFROM'].'</p><small style="color:#CCC">'.date('M d',strtotime($data['timestamp'])).'</small>
										  <div class="clearfix" style="height:15px;"></div>
										</div>
									  
								</div>
								  		
							</div>	
						</div>
						<div class="clearfix" style="height:30px;"></div>
				
						<script data-cfasync="false" type="text/javascript">
							function reply_message(){
							
								$("#view_msg").hide();
								$("#reply_msg").fadeIn();
								$("#reply_redactor_content").prepend();
								$("#reply_redactor_content").focus();
							}
							$("#reply_redactor_content").redactor({ 	
				
									buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
									"unorderedlist", "orderedlist", "outdent", "indent", "|",
									"video", "table","|",
									 "alignment", "|", "horizontalrule"]
							});
							$("#reply_email_yes").live("click", function() { 	
								
								var frm = $("#replymail");
								frm.attr("action","'. site_url('/').'tna_mail/reply_email/");

								$("#reply_email_yes").html("Sending...");
									
									$.ajax({
										type: "post",
										cache: false,
										data: frm.serialize(),
										url: "'.site_url('/').'tna_mail/reply_email/" ,
										success: function (data) {
											$("#reply_email_yes").html("Sent!");
											$("#reply_msg").html(data);
											
										}
									});	
								
						});		
						</script>';
					   	
				  
		  }else{
			
				redirect('/members/logout', 'refresh');
			  
		  }
		 
	}
	//++++++++++++++++++++++++++++++++++++++++++++
	//REPLY EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++	
	function reply_email()
	{
		 if($this->session->userdata('id')){
			//GET EMAIL FIELDS 	
			$emailTO = $this->input->post('emailTO',TRUE);
			$emailFROM = $this->input->post('emailFROM',TRUE);
			$subject = $this->input->post('subject',TRUE);
			$body = $this->input->post('reply_content',FALSE);
			$bus_id = $this->input->post('bus_id_reply',TRUE);
			$msg_id = $this->input->post('msg_id_reply',TRUE);
			$client_id = $this->input->post('client_id_reply',TRUE);	
			$nameTO = $this->input->post('name_to',TRUE);
			$nameFROM = $this->input->post('name_from',TRUE);
			$status = $this->input->post('cur_state',TRUE);
			//INSERT SENT MESSAGE DATABASE
			//$data2['bus_id_logo'] = $bus_id;
//			$data2['bus_id'] = $bus_id;
//			$data2['client_id'] = $client_id;
//			$data2['email'] = $emailFROM;
//			$data2['nameTO'] = $name;
//			$data2['subject'] = $subject;
//			$data2['body'] = $body;
//			$data2['status'] = 'unread';
//			$data2['status_client'] = 'sent';
//			$data2['emailTO'] = $emailTO;
		
			//$this->db->insert('u_business_messages',$data2);
			//BUSINESS SENT TO CLIENT
			if($status == 'sent'){
				
				//UPDATE EXISTING MSG IF USER IS REGISTERED	
				$dataUpdate['status_client'] = 'replied';
				$dataUpdate['status'] = 'unread';
				$dataUpdate['body'] = $body;
				$dataUpdate['nameFROM'] = $nameTO;
				$dataUpdate['nameTO'] = $nameFROM;
					
				$this->db->where('msg_id',$msg_id);
				$this->db->update('u_business_messages', $dataUpdate);
				
				$redirect = 'members/home/msgs';
			
			//BUSINESS REPLIED TO CLIENT	
			}elseif($status == 'replied'){
				
				//UPDATE EXISTING MSG IF USER IS REGISTERED	
				$dataUpdate['status_client'] = 'replied';
				$dataUpdate['status'] = 'unread';
				$dataUpdate['body'] = $body;
				$dataUpdate['nameFROM'] = $nameTO;
				$dataUpdate['nameTO'] = $nameFROM;
					
				$this->db->where('msg_id',$msg_id);
				$this->db->update('u_business_messages', $dataUpdate);
				
				$redirect = 'members/home/msgs';
				
			
			}else{
				
				//UPDATE EXISTING MSG IF USER IS REGISTERED	
				$dataUpdate['status_client'] = 'unread';
				$dataUpdate['status'] = 'replied';
				$dataUpdate['body'] = $body;
				$dataUpdate['nameFROM'] = $nameTO;
				$dataUpdate['nameTO'] = $nameFROM;
					
				$this->db->where('msg_id',$msg_id);
				$this->db->update('u_business_messages', $dataUpdate);
				
				$redirect = 'members/tna_mail/'.$bus_id;
				
			}
			
			
		
			
			$this->email_model->send_email($emailTO, $emailFROM  , $nameTO , $body , $subject );
			
			$this->session->set_flashdata('msg','Your reply was sent successfully.');
			$str = "<div class='alert alert-success'>
					<button type='button' class='close' data-dismiss='alert'>×</button>Your reply was sent successfully.</div>";		
			echo $str;
			//REDIRECT BUSINESS
			if($bus_id != '0'){
				
				echo '<script data-cfasync="false" type="text/javascript">
						window.location = "'.site_url('/').$redirect.'";
						</script>';
			//REDIRECT MEMBER	
			}else{
				
				echo '<script data-cfasync="false" type="text/javascript">
						window.location = "'.site_url('/').$redirect.'";

						</script>';
			}
			
		
		//NOT LOGGED IN
		}else{
			
				redirect('/members/logout/', 'refresh');	
			  
		 }
		
	}
	//+++++++++++++++++++++++++++
	//PREVIEW MESSAGE
	//++++++++++++++++++++++++++	
	function preview_message($bus_id)
	{	
		$data['preview'] = 'true';
		$data['bus_id'] = $bus_id;
		$data['logo'] = $this->get_email_logo($bus_id);
		$data['body'] = $this->input->post('mailbody',TRUE);
		//$data['body'] = urldecode($body);
		
		$this->load->view('email/body_news', $data);	

		
	}
	//+++++++++++++++++++++++++++
	//GET EMAIL LOGO
	//++++++++++++++++++++++++++		 
		 
	function get_email_logo($bus_id){
		
		$this->db->where('ID', $bus_id);
		$query = $this->db->get('u_business');
		
		if($query->result()){
			
			$row = $query->row_array();
  
				  $img = $row['BUSINESS_LOGO_IMAGE_NAME'];
				  $title = $row['BUSINESS_NAME'];
				 //Build image string
				  $format = substr($img,(strlen($img) - 4),4);
				  $str = substr($img,0,(strlen($img) - 4));
				  
				  if($img != ''){
					  
					  if(strpos($img,'.') == 0){
			  
						  $format = '.jpg';
						  $fake_file ='<img src="'. base_url('/').'img/timbthumb.php?w=100&h=100&src='.S3_URL.'assets/business/photos/'.$img . $format.'" alt="'.$title.'" title="'.$title.'" style="border:3px solid #FFF;float:left;width:auto;margin:10px 20px 15px 20px" />';
						  
					  }else{
						  
						  $fake_file = '<img src="'.base_url('/').'img/timbthumb.php?w=100&h=100&src='.S3_URL.'assets/business/photos/'.$img.'" alt="'.$title.'" title="'.$title.'" style="border:3px solid #FFF; float:left;width:auto;margin:10px 20px 15px 20px" />';
					  }
					  
				  }else{
					  
					  $fake_file = '<img src="'.base_url('/').'img/timbthumb.php?w=100&h=100&src='.base_url('/').'img/bus_blank.png" alt="'.$title.'" title="'.$title.'" style="border:3px solid #FFF;float:left;width:auto;margin:10px 20px 15px 20px" />';
					  
				  }
				  return $fake_file;
		
			
		}else{
			
			return '<img src="'.base_url('/').'img/my-na-logo-black.png" style="border:3px solid #FFF;float:left;width:auto;margin:10px 20px 15px 20px" />';
		}

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_email()
	{
		 if($this->session->userdata('id')){
			//GET EMAIL FILDS 	
			$recipients = $this->input->post('recipients',TRUE);
			$subject = $this->input->post('title',TRUE);
			$body = $this->input->post('content',FALSE);
			$bus_id = $this->input->post('bus_id_tna_mail',TRUE);
			$bus_email = $this->input->post('bus_email_tna_mail',TRUE);
			$bus_name = $this->input->post('bus_name',TRUE);		
			$count = 0;

				  //ONLY SELECTED
				  if(!empty($_POST['recipients'])) {
					  $num = count($_POST['recipients']);
					   foreach($_POST['recipients'] as $value) {
						  
						  $row = $this->get_client_row($value);
						  //INSERT INTO EMAIL QUEUE
						  $data['CLIENT_ID'] = $this->session->userdata('id');
						  $data['ADMIN_ID'] = '0';
						  $data['TO'] = $row['CLIENT_EMAIL'];
						  $data['FROM'] = 'no-reply@my.na';
						  $data['ID'] = $data['CLIENT_ID'].'-'.$count; 
						  $data['SUBJECT'] = $subject;
						  $data['BODY'] = $body;
						  $data['NAME'] = $row['CLIENT_NAME'];
						  //echo $row['fname'] .' '.$row['sname'].'<br />'; 
						 
						  $this->db->insert('email_queue',$data);
						  
						  
						  //INSERT INTO MESSAGES FOLDER
						  $data_inbox['client_id'] = $value;
						  $data_inbox['bus_id'] = $bus_id; 
						  $data_inbox['bus_id_logo'] = $bus_id;
						  $data_inbox['nameTO'] = $row['CLIENT_NAME'];
						  $data_inbox['nameFROM'] = $bus_name;
						  $data_inbox['email'] = $bus_email;
						  $data_inbox['emailTO'] = $row['CLIENT_EMAIL'];
						  $data_inbox['body'] = $body;
						  $data_inbox['subject'] = $subject;
						  $data_inbox['status'] = 'sent';
						  $data_inbox['status_client'] = 'unread';
						 
						  $this->db->insert('u_business_messages',$data_inbox);	
						  //$array_mail[$count][$row->email];
						  //echo $row['CLIENT_EMAIL'].'<br/>'; 
						  
						  
						  	//BUILD MANDRILL ARRAY  
							$mandrill = array(array('email' => $row['CLIENT_EMAIL'] ));
							$business = $bus_name;
							//$business['EMAIL'] = $bus_email;
							//SEND MANDRILL
							$data2['body'] = $body;
							$data2['logo'] = $this->get_email_logo($bus_id);
							$body1 = $this->load->view('email/body_news',$data2,true);  
							$this->send_newsletter_do($body1, $body, $subject, $mandrill, $business);
							  
						  $count ++;    
					   }
					  
					  ////INSERT AS SENT EMAIL INTO BUSINESS FOLDER
//					  $data_sent['client_id'] = '0';
//					  $data_sent['bus_id'] = $bus_id;
//					  $data_sent['bus_id_logo'] = $bus_id;
//					  $data_sent['name'] = $row['CLIENT_NAME'];
//					  $data_sent['email'] = 'group@my.na';
//					  $data_sent['emailTO'] = $bus_email;
//					  $data_sent['body'] = $body;
//					  $data_sent['subject'] = $subject;
//					  $data_sent['status'] = 'sent';
//						 
//					  $this->db->insert('u_business_messages',$data_sent);	
					  
				  }else{
					  
					  $this->session->set_flashdata('msg',$count.' emails have been sent.');
					  $str = "<div class='alert'>
							  <button type='button' class='close' data-dismiss='alert'>×</button>
							  Please select some recipients
							  </div>";		
					  echo $str.'<script data-cfasync="false" type="text/javascript">
									 $("#send_email_yes").html("Emails Sent");
									 $("#modal-email").modal("hide");
									 window.location = "'.site_url('/').'members/tna_mail/'.$bus_id.'";
							    </script>';
					  //return;
					  
				  }
				  //echo 'Only selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count .' = ' .$num; 
  
				  //TEST IF LESS THAN 100 IF LESS, SEND EMAILS DIRECTLY
				  if($num < 21){
					  unset($_POST); unset($_REQUEST);
					  //SEND EMAILS
					  //$this->send_newsletter_do('0',$count);
					  $this->session->set_flashdata('msg',$count.' emails have been sent.');
					  echo '<script data-cfasync="false" type="text/javascript">
					  $("#send_email_yes").html("Emails Sent");
					  $("#modal-email").modal("hide");
					  window.location = "'.site_url('/').'members/tna_mail/'.$bus_id.'";
					  </script>';
				  }else{
				  		
					  $this->session->set_flashdata('msg',$count.' emails have been sent.');
					  $str = "<div class='alert alert-success'>
							  <button type='button' class='close' data-dismiss='alert'>×</button>" . $count . " emails have been sent.</div>";		
					  echo $str.'<script data-cfasync="false" type="text/javascript">
					  $("#send_email_yes").html("Emails Sent");
					  $("#modal-email").modal("hide");
					  window.location = "'.site_url('/').'members/tna_mail/'.$bus_id.'";
					  </script>';
					  
				  }						
		
		//NOT LOGGED IN
		}else{
			
				redirect('/members/logout/', 'refresh');	
			  
		 }
		
	}
	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL INSTANT
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_newsletter_do($HTML, $TEXT, $subject, $mandrill, $business){

			$this->load->config('mandrill');
	
			$this->load->library('mandrill');
			
			$mandrill_ready = NULL;
			
			try {
			
				$this->mandrill->init( $this->config->item('mandrill_api_key') );
				$mandrill_ready = TRUE;
			
			} catch(Mandrill_Exception $e) {
			
				$mandrill_ready = FALSE;
				
			}
			
			if( $mandrill_ready ) {
				
				//Send us some email!
				  $email = array(
					  'html' => $HTML, //Consider using a view file
					  'text' =>  $TEXT,
					  'subject' => $subject,
					  'from_email' => 'no-reply@my.na',
					  'from_name' => $business,
					  'to' => $mandrill
					  );
					  
				  $result = $this->mandrill->messages_send($email);	
				
			}
			
			
		
	}
	
    //++++++++++++++++++++++++++++++++++++++++++++
	//DELETE EMAILS
	//++++++++++++++++++++++++++++++++++++++++++++	
	function delete_msg()
	{
         
    if(!empty($_POST['messages'])) {
			 
		$x = 0;
		if($this->session->userdata('id')){
			  foreach($_POST['messages'] as $value) {
							
							 $this->db->where('msg_id', $value);
							 $this->db->delete('u_business_messages');
							$x++;
				
				}
				
				
		  }else{
			
				redirect('/owners/logout', 'refresh');
			  
		  }
				
		echo "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>×</button>
		Succesfully removed " .$x ." Emails!</div>";
		
					 
 	}else{
			 
		echo"<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>
		Error </div>"; 
			 
	}
		 
		 
}
	
	//Get CLIENT ROW
	function get_client_row($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');
		return $test->row_array();		  
    }
		
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET USER AVATAR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_avatar($id){
		
		$this->db->select('ID , CLIENT_PROFILE_PICTURE_NAME as PIC');
		$this->db->where('ID',$id);
		$query = $this->db->get('u_client');
		$row = $query->row_array();
		
		if($row['PIC'] != '' || $row['PIC'] != NULL){
			
			//Build image string
			$format = substr($row['PIC'],(strlen($row['PIC']) - 4),4);
			$str = substr($row['PIC'],0,(strlen($row['PIC']) - 4));
			
			if(strstr($row['PIC'], "http")){
					
				$avatar = $row['PIC'].'?width=100&height=100';
				
			}elseif(strpos($row['PIC'],'.') == 0){
	
				$format = '.jpg';
				$avatar = S3_URL.'assets/users/photos/'.$row['PIC'] . $format;
				
			}else{
				
				$avatar =   S3_URL.'assets/users/photos/'.$row['PIC'];
				
			}

			
		}else{
			
			$avatar = base_url('/').'img/user_blank.jpg';
			
		}
		
		return $avatar;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS LOGO
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
				$avatar['image'] = base_url('/').'img/timbthumb.php?w=100&h=100&src='.S3_URL.'assets/business/photos/'.$row['PIC'] . $format;
				
			}else{
				
				$avatar['image'] =  base_url('/').'img/timbthumb.php?w=100&h=100&src='.S3_URL.'assets/business/photos/'.$row['PIC'];
				
			}
			
			
		}else{
			
			$avatar['image'] = base_url('/').'img/timbthumb.php?w=100&h=100&src='.base_url('/').'img/user_blank.jpg';
			
		}
		$avatar['name'] = $row['BUSINESS_NAME'];
		return $avatar;
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET USER AVATAR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_user_avatar($client_id){
		
		$this->db->select('ID , CLIENT_NAME, CLIENT_SURNAME, CLIENT_PROFILE_PICTURE_NAME as PIC');
		$this->db->where('ID',$client_id);
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
				$avatar['image'] = base_url('/').'img/timbthumb.php?w=100&h=100&src='.  S3_URL.'assets/users/photos/'.$row['PIC'] . $format;
				
			}else{
				
				$avatar['image'] = base_url('/').'img/timbthumb.php?w=100&h=100&src='.  S3_URL.'assets/users/photos/'.$row['PIC'];
				
			}
			
			
		}else{
			
			$avatar['image'] = base_url('/').'img/timbthumb.php?w=100&h=100&src='. base_url('/').'img/user_blank.jpg';
			
		}
		$avatar['name'] = $row['CLIENT_NAME'].' '.$row['CLIENT_SURNAME'];
		return $avatar;
		
	}
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */