<?php
class Vacancy_api_model extends CI_Model{
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function vacancy_api_model(){
  		//parent::CI_model();
		self::__construct();	
 	}






	function pass_update_two($bus_id, $token)
	{

		$query = $this->db->query("SELECT * FROM applicant_password_links WHERE bus_id = '".$bus_id."' AND token = '".$token."'", FALSE);

		if($query->result()){

			$row = $query->row();
			$data['step1'] = 'true';
			$data['token'] = $token;
			$data['applicant_id'] = $row->applicant_id;


		}else {

			$data['step1'] = 'false';
			$data['type'] = 'teacher';
			$data['error'] = 'error';

		}

		return $data;

	}



	//+++++++++++++++++++++++++++
	//RESET PASSWORD
	//++++++++++++++++++++++++++
	function new_password_email($bus_id,$email){

		//$this->load->library('user_agent');

		$query = $this->db->query("SELECT * FROM applicants AS a INNER JOIN u_client AS b on a.client_id = b.ID WHERE a.bus_id = '".$bus_id."' AND a.email = '".$email."'", FALSE);

		//VALIDATE INPUT
		if($query->result()){

			$row = $query->row();

			//create key
			//$token = $this->encrypt->sha1($row->ID);
			$token = hash( "sha256", $row->ID );

			//insert data
			$link = site_url('/').'careerupdatepass/pass_update_two/'.$token;

			$data['applicant_id'] = $row->applicant_id;
			$data['bus_id'] = $bus_id;
			$data['email'] = $row->email;
			$data['name'] = $row->CLIENT_NAME.' '.$row->CLIENT_SURNAME;
			$data['link'] = $link;
			$data['type'] = 'password';
			$data['token'] = $token;

			$this->db->insert('applicant_password_links',$data);

			//$this->reset_pass_email($row->email, $row->CLIENT_NAME, $row->CLIENT_SURNAME, $token);

			$data['success'] = 'Success';

		} else {

			$data['error'] = 'Error';

		}

		return $data;
	}



	function update_password($bus_id,$token,$pass,$app_id)
	{

		$query = $this->db->query("SELECT * FROM applicant_password_links WHERE bus_id = '".$bus_id."' AND token = '".$token."'", FALSE);


		if($query->result()){

			$row = $query->row();

			$password = $this->encrypt($row->email, $pass);

			$data['password'] = $password;

			$this->db->where('applicant_id', $app_id);
			$this->db->where('bus_id', $bus_id);
			$this->db->update('applicants',$data);

			$query2 = $this->db->query("SELECT * FROM applicants AS a INNER JOIN u_client AS b on a.client_id = b.ID WHERE a.bus_id = '".$bus_id."' AND a.email = '".$row->email."'", FALSE);

			if($query2->result()){

				$row2 = $query2->row();

				$data['applicant_id'] = $row2->applicant_id;
				$data['bus_id'] = $bus_id;
				$data['email'] = $row2->email;
				$data['name'] = $row2->CLIENT_NAME.' '.$row2->CLIENT_SURNAME;

				//DELETE link
				$this->db->where('bus_id', $bus_id);
				$this->db->where('token',$token);
				$this->db->delete('applicant_password_links');

				//redirect(site_url('/'), 301);
				$data['success'] = 'true';

			}

		} else {

			$data['error'] = 'expired';
			$this->load->view('login', $data);

		}

		return $data;

	}



	function user_login($email,$pass,$bus_id) {

		$query['success'] =	false;

		$row = $this->validate_password($email,$pass,$bus_id);

		if($row['bool'] == TRUE){

			//CHECK IF USER EXISTS IN CLIENTS
			$temp = $this->db->query("SELECT CLIENT_NAME, CLIENT_SURNAME FROM u_client WHERE CLIENT_EMAIL = '".$email."'", FALSE);

			$client = $temp->row();

			if($temp->result_array()){

				$query['success'] =	true;

			}

			$query['level'] = $row['level'];
			$query['status'] = $row['status'];
			$query['applicant_id'] = $row['applicant_id'];
			$query['client_id'] = $row['client_id'];
			$query['name'] = $client->CLIENT_NAME .' '.$client->CLIENT_SURNAME;

		} else {

			$query['error'] = 'Error';

		}

		return $query;

	}



	function validate_password($username, $password, $bus_id){

		$sql = $this->db->query("SELECT * FROM applicants WHERE bus_id = '".$bus_id."' AND email = '".$username."'", FALSE);

		$res = array();
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){

			$r = $sql->row_array();

			$res['applicant_id'] = $r['applicant_id'];
			$res['level'] = $r['level'];
			$res['client_id'] = $r['client_id'];
			$res['status'] = $r['status'];
			$res['bus_id'] = $r['bus_id'];
			$res['type'] = $r['type'];

			// The first 64 characters of the hash is the salt
			$salt = substr($r['password'], 0, 64);

			$hash = $salt . $password;

			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
				$hash = hash('sha256', $hash);
			}

			$hash = $salt . $hash;

			if ( $hash == $r['password'] ) {

				$res['bool'] = TRUE;
				//break;
			}else{

				$res['bool'] = FALSE;

			}
		}else{//no username match

			$res['bool'] = FALSE;
		}

		return $res;
	}



	function register_do($reg_array){


		extract($reg_array);

			///CHECK IF USER EXISTS IN CLIENTS///
			$query = $this->db->query("SELECT * FROM u_client WHERE CLIENT_EMAIL = '".$email."'", FALSE);


			if($query->result()){

				$row = $query->row();

				if(isset($row->ID)) {

					//CHECK IF USER EXISTS IN APPLICANTS
					$query2 = $this->db->query("SELECT applicant_id FROM applicants WHERE client_id = '".$row->ID."' AND bus_id = '".$bus_id."'", FALSE);

					if($query2->result()){

						$reg['error'] = 'email-error';

					} else {


						//$insertdata = array();

						$val = FALSE;


						if($gender != "") {
							$data['CLIENT_GENDER'] = $gender;
							$val = TRUE;
						}

						if($dob != "") {
							$data['CLIENT_DATE_OF_BIRTH'] = $dob;
							$val = TRUE;
						}

						if($tel != "") {
							$data['CLIENT_TELEPHONE'] = $t_code.$tel;
							$val = TRUE;
						}

						if($middle_name != "") {
							$data['CLIENT_MIDDLE_NAME'] = $middle_name;
							$val = TRUE;
						}

						if($row->VERIFIED == 'N') {
							if($cell != '') {
								$data['CLIENT_CELLPHONE'] = $c_code.$cell;
								$val = TRUE;
							}
						}

						if($val == TRUE) {

							$this->db->where('ID', $row->ID);
							$this->db->update('u_client', $data);

						}


						//--------------------

						$insertdata2 = array(
							'bus_id'=> $bus_id,
							'client_id'=> $row->ID,
							'email'=> $email,
							'password'=> $password,
							'type'=> $reg_type,
							'level'=> $level,
							'status'=> 'semi'
						);

						$this->db->insert('applicants', $insertdata2);
						$app_id = $this->db->insert_id();


						$insertdata3 = array(
							'marital_status'=> $marital,
							'client_id'=> $row->ID,
							'drivers'=> $drivers,
							'bee'=> $bee,
							'disabled'=> $disabled,
							'disability'=> $disability,
							'drivers_type'=> $drivers_type,
							'nationality'=> $nationality,
							'country'=> $country,
							'region'=> $region,
							'city'=> $city,
							'job_title'=> $job_title,
							'qualification'=> $qualification,
							'specialist'=> $specialist,
							'current_tcc'=> $current_tcc,
							'expected_tcc'=> $expected_tcc,
							'currency'=> $currency,
							'id_number'=> $id_number

						);


						//CHECK IF USER EXISTS IN APPLICANT BIO
						$querybio = $this->db->query("SELECT client_id FROM applicant_bio WHERE client_id = '".$row->ID."'", FALSE);

						if($querybio->result()) {

							$this->db->where('client_id', $row->ID);
							$this->db->update('applicant_bio', $insertdata3);

						} else {


							$this->db->insert('applicant_bio', $insertdata3);

						}



						//SEND CLIENT REGISTER CONFIRMATION EMAIL

						$this->send_validation_email($email, $name, $surname, $pass, $row->ID, $reg_type);

						$reg['success'] = 'success';
						$reg['app_id'] = $app_id;
						$reg['client_id'] = $row->ID;

						//redirect(site_url('/').'vacancy/wizard/step1/', 301);
					}

				} else {

					$reg['error'] = 'error';

				}

			} else {

				$insertdata = array(
					'CLIENT_EMAIL'=> $email,
					'CLIENT_PASSWORD'=> $password,
					'CLIENT_NAME'=> $name,
					'CLIENT_MIDDLE_NAME'=> $middle_name,
					'CLIENT_SURNAME'=> $surname,
					'CLIENT_CELLPHONE'=> $c_code.$cell,
					'CLIENT_TELEPHONE'=> $t_code.$tel,
					'CLIENT_GENDER'=> $gender,
					'CLIENT_DATE_OF_BIRTH'=> $dob
				);

				$this->db->insert('u_client', $insertdata);
				$client_id = $this->db->insert_id();

				if(isset($client_id)) {

					$insertdata2 = array(
						'bus_id'=> $bus_id,
						'client_id'=> $client_id,
						'email'=> $email,
						'password'=> $password,
						'type'=> $reg_type,
						'level'=> $level,
						'status'=> 'semi'
					);

					$this->db->insert('applicants', $insertdata2);
					$app_id = $this->db->insert_id();



					$insertdata3 = array(
						'client_id'=> $client_id,
						'marital_status'=> $marital,
						'bee'=> $bee,
						'drivers'=> $drivers,
						'drivers_type'=> $drivers_type,
						'nationality'=> $nationality,
						'country'=> $country,
						'region'=> $region,
						'city'=> $city,
						'job_title'=> $job_title,
						'qualification'=> $qualification,
						'specialist'=> $specialist,
						'current_tcc'=> $current_tcc,
						'expected_tcc'=> $expected_tcc,
						'currency'=> $currency,
						'disabled'=> $disabled,
						'disability'=> $disability,
						'id_number'=> $id_number
					);

					$this->db->insert('applicant_bio', $insertdata3);


					//SEND CLIENT REGISTER CONFIRMATION EMAIL

					$this->send_validation_email($email, $name, $surname, $pass, $client_id, $reg_type);

					$reg['success'] = 'success';
					$reg['app_id'] = $app_id;
					$reg['client_id'] = $client_id;

					//redirect(site_url('/').'vacancy/wizard/step1/', 301);

				} else {

					$reg['error'] = 'error';

				}
			}

		return $reg;

	}



	function send_validation_email($email, $name, $surname, $pass, $client_id, $reg_type)
	{


		$email2 = str_replace('@', "-_-", $email);

		if ($reg_type == 'vacancy') {

			$subject = 'My.na Jobs & Carrers Registration Confirmation Email';

			$msg = '<h1>Thank you for registering with My.na Careers</h1>
			 		You Login details are:<br>
					Username: ' .$email. '<br>
					Password: ' .$pass. '<br><br>
					Before you can log into your Account, you must first validate your email address.<br>
					After validating please complete your CV by updating all necessary details in your profile. A complete profile results in a higher ranking application.<br>
			';

			$msg2 = '<h1>The following user, <strong>'.$name.' '.$surname.'</strong> applied for Debmarine Careers</h1>';

			$cemail = array('christian@intouch.com.na');

		}

		$attachments[] = array();

		$data1 = array(
			'name'=>  $subject,
			'from_email'=> 'noreply@careers.my.na',
			'email'=> 'noreply@careers.my.na',
			'body'=> $msg,
			'type'=> 'confirmation',
			'email_to' => array($email),
			'subject' => $subject,
			'attachments'=>$attachments 
		);


		$data2 = array(
			'name'=>  $subject,
			'from_email'=> 'noreply@careers.my.na',
			'email'=> 'noreply@careers.my.na',
			'body'=> $msg2,
			'type'=> 'registration',
			'email_to' => $cemail,
			'subject' => $subject,
			'attachments'=>$attachments
		);

		//SEND EMAIL LINK

		$this->load->model('email_model');
		$this->email_model->send_enquiry($data1);
		$this->email_model->send_enquiry($data2);
	}



	function get_countries() {

		$temp = $this->db->query("SELECT * FROM a_country", FALSE);

		$query['success'] =	false;

		if($temp->result_array()){

			$query['success'] =	true;

		}

		$query['query'] = $temp->result_array();

		return $query;

	}



	function get_levels($bus_id) {

		$temp = $this->db->query("SELECT * FROM management_level WHERE bus_id = '".$bus_id."'", FALSE);

		$query['success'] =	false;

		if($temp->result_array()){

			$query['success'] =	true;

		}

		$query['query'] = $temp->result_array();

		return $query;

	}


	function get_vacancies($bus_id) {

		$temp = $this->db->query("SELECT * FROM vacancies WHERE bus_id = '".$bus_id."' AND end_date >= NOW() AND status = 'live' ORDER BY end_date ASC", FALSE);

		$query['success'] =	false;

		if($temp->result_array()){

			$query['success'] =	true;

		}

		$query['query'] = $temp->result_array();

		return $query;

	}


	function vacancy_apply($vid,$bus_id,$app_id,$client_id,$survey_id,$level,$motivation,$mr) {

		$weight = 0;

		if($mr != '') {

			foreach ($mr as $mid) {

				if ($mid == 'Y') {
					$weight++;
				}

			}

		}


		//CHECK IF USER ALREADY APPLIED//
		$temp = $this->db->query("SELECT va_id FROM vacancy_applicants WHERE vacancy_id = '".$vid."' AND bus_id = '".$bus_id."' ", FALSE);

		if($temp->result()){

			$query['error'] = true;

		} else {

			$insertdata = array(
				'bus_id' => $bus_id,
				'client_id' => $client_id,
				'applicant_id' => $app_id,
				'vacancy_id' => $vid,
				'weight' => $weight,
				'status' => 'long'
			);

			$this->db->insert('vacancy_applicants', $insertdata);
			$va_id = $this->db->insert_id();

			$insertdata2 = array(
				'va_id' => $va_id,
				'bus_id' => $bus_id,
				'level' => $level,
				'motivation' => $motivation
			);

			$this->db->insert('vacancy_applicant_requirements', $insertdata2);


			$try = $this->db->query("SELECT CLIENT_NAME, CLIENT_SURNAME, CLIENT_EMAIL FROM u_client WHERE ID = '".$client_id."'", FALSE);

            $row = $try->row();


            $try2 = $this->db->query("SELECT A.title, B.email FROM vacancies AS A LEFT JOIN vacancy_departments AS B ON A.department_id = B.department_id WHERE A.vacancy_id = '".$vid."'", FALSE);

            $row2 = $try2->row();

           $query['c_fname'] =	$row->CLIENT_NAME;
           $query['c_sname'] =	$row->CLIENT_SURNAME;
           $query['c_email'] =	$row->CLIENT_EMAIL;
           $query['v_title'] =	$row2->title;
		   $query['d_email'] =	$row2->email;
		   $query['success'] = true;

		}

		return $query;
	}



	function send_application_email($id, $client_id) {


		//GET USER DETAILS/
		$query = $this->db->query("SELECT CLIENT_NAME, CLIENT_SURNAME, CLIENT_EMAIL FROM u_client WHERE ID = '".$client_id."'", FALSE);

		if($query->result()){

			$row = $query->row();

			$query2 = $this->db->query("SELECT title FROM vacancies WHERE vacancy_id = '".$id."'", FALSE);

			$row2 = $query2->row();

			$subject = 'Vacancy Application Email';

			$msg = '<h1>The following member has applied for a vacancy</h1>
			 		 <br>
					 <strong>Name:</strong> '.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'<br>
					 <strong>Email:</strong> '.$row->CLIENT_EMAIL.'<br>
					 <strong>Vacancy:</strong> '.$row2->title.'<br><br>
					 Please click on the link provided to view Applicant details via the CMS. <br> <a href="http://www.cms.my.na/">Click to view applicant details</a>
				';


			$msg2 = '<h1>Debmarine Vacancy Application</h1>
			 		 <br>
					 <strong>Name:</strong> '.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'<br>
					 <strong>Email:</strong> '.$row->CLIENT_EMAIL.'<br>
					 <strong>Vacancy:</strong> '.$row2->title.'<br><br>
					 Please click on the link provided to view Applicant details via the CMS. <br> <a href="http://www.cms.my.na">Click to view applicant details</a>
				';

			$cemail = array('christian@intouch.com.na');

			$attachments[] = array();

			$data1 = array(
				'name'=>  $subject,
				'from_email'=> 'noreply@my.na',
				'email'=> 'noreply@my.na',
				'body'=> $msg2,
				'type'=> 'confirmation',
				'email_to' => array($row->CLIENT_EMAIL),
				'subject' => $subject,
				'attachments'=>$attachments
			);


			$data2 = array(
				'name'=>  $subject,
				'from_email'=> 'noreply@my.na',
				'email'=> 'noreply@my.na',
				'body'=> $msg,
				'type'=> 'registration',
				'email_to' => $cemail,
				'subject' => $subject,
				'attachments'=>$attachments
			);

			//SEND EMAIL LINK
			$this->load->model('email_model');
			$this->email_model->send_enquiry($data1);
			$this->email_model->send_enquiry($data2);

		}
	}






	function get_survey($vid, $bus_id) {

		$temp = $this->db->query("SELECT A.title,

							  		(SELECT group_concat(CONCAT(B.mr_question, '|', B.elaborate, '|', B.answer, '|',  B.mr_id) SEPARATOR '~') FROM vacancy_mr_int AS B WHERE B.mr_id = A.mr_id AND B.vacancy_id = '".$vid."') AS quests

							 		 FROM vacancy_mr AS A

							  		 WHERE A.bus_id = '".$bus_id."'

							  		 ", FALSE);

		$query['success'] =	false;

		if($temp->result_array()){

			$query['success'] =	true;

		}

		$query['query'] = $temp->result_array();

		return $query;

	}



	function get_vacancy($id) {

		$temp = $this->db->query("SELECT vacancies.*, management_level.level AS blevel,

									(select group_concat(CONCAT(vacancy_documents.title, '|', vacancy_documents.doc_file) SEPARATOR '~') from vacancy_documents WHERE vacancy_documents.vacancy_id = vacancies.vacancy_id) AS documents

									FROM vacancies

									LEFT JOIN management_level ON management_level.level_id = vacancies.level

									WHERE vacancies.vacancy_id = '".$id."'", FALSE);

		$query['success'] =	false;

		if($temp->result_array()){

			$query['success'] =	true;

		}

		$query['query'] = $temp->row();

		return $query;

	}



	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login($uname, $pass)
	{

		$o['success'] = false;
		$o['error'] = true;

		$password = md5($pass);
		$quest = array();
		$cand = array();
		$job = array();
		$c_docs = array();

		$query = $this->db->query("SELECT * FROM interview_panellist WHERE email = '".$uname."' AND password = '".$password."' AND status = 'live' ", TRUE);

		if($query->result()) {

			$row = $query->row();

			//GET CLIENT VACANCIES
			$query2 = $this->db->query("SELECT *, A.survey_id AS sur_id, C.title AS vacancy_title FROM interview_job_files AS A

 								   		LEFT JOIN interview_panellist_int AS B ON A.job_id = B.job_id

 								   		LEFT JOIN vacancies AS C ON A.vacancy_id = C.vacancy_id

 								   		LEFT JOIN vacancy_clients AS D ON C.client_id = D.vac_client_id

 								   		WHERE B.panellist_id = '".$row->panellist_id."' ", TRUE);

			if($query2->result()) {

				foreach($query2->result() as $row2) {


					//GET Interview Questions
					$query3 = $this->db->query("SELECT * FROM interview_survey_questions WHERE survey_id = '".$row2->sur_id."' ORDER BY sequence ASC", TRUE);

					if($query3->result()) {

						$i = 1;
						foreach($query3->result() as $row3) {

							array_push($quest, array('qid' => $row3->question_id, 'survey_id' => $row2->sur_id, 'job_id' => $row2->job_id, 'question' => $row3->question, 'sequence' => $i));

							$i++;
						}

					}

					//GET Interview Candidates
					$query4 = $this->db->query("SELECT * FROM vacancy_applicants AS A

 												LEFT JOIN u_client AS B ON A.client_id = B.ID

 												WHERE A.vacancy_id = '".$row2->vacancy_id."'", TRUE);

					if($query4->result()) {

						foreach($query4->result() as $row4) {

							array_push($cand, array('user_id' => $row4->client_id, 'vacancy_id' => $row2->vacancy_id, 'survey_id' => $row2->sur_id, 'job_id' => $row2->job_id, 'c_name' => $row4->CLIENT_NAME, 'c_middle_name' => $row4->CLIENT_MIDDLE_NAME, 'c_surname' => $row4->CLIENT_SURNAME, 'c_email' => $row4->CLIENT_EMAIL, 'c_gender' => $row4->CLIENT_GENDER));

						}

					}


					//GET Career Documents
					$query5 = $this->db->query("SELECT * FROM vacancy_documents WHERE vacancy_id = '".$row2->vacancy_id."'", TRUE);

					if($query5->result()) {

						foreach($query5->result() as $row5) {

							$path = BASE_URL.'assets/vacancies/documents/vacancies/'.$row5->doc_file;
							$p = base64_encode(file_get_contents($path));

							array_push($c_docs, array('doc_id' => $row5->doc_id, 'vacancy_id' => $row2->vacancy_id,  'survey_id' => $row2->sur_id, 'job_id' => $row2->job_id, 'doc_title' => $row5->title, 'doc_file' => $p));

						}

					}


					array_push($job, array('job_id' => $row2->job_id, 'client_name' => $row2->client_name, 'vac_id' => $row2->vacancy_id, 'vac_title' => $row2->vacancy_title, 'ref_no' => $row2->ref_no, 'vac_loc' => $row2->location, 'vac_desc' => $row2->body));

				}

			}




			$sess['id'] = $row->panellist_id;
			$sess['email'] = $row->email;
			$sess['name'] = $row->name;
			$sess['surname'] = $row->surname;
			$sess['u_password'] = $row->password;

			$o['success'] = true;
			$o['error'] = false;
			$o['msg'] = 'Login Successfull';
			$o['user'] = $sess;
			$o['job'] = $job;
			$o['quest'] = $quest;
			$o['cand'] = $cand;
			$o['c_docs'] = $c_docs;

		} else {

			$o['msg'] = 'No account found!';
			$o['success'] = false;
			$o['error'] = true;

		}

		return $o;

	}


	//+++++++++++++++++++++++++++
	//ENCRYPRION FUNCTIONS
	//++++++++++++++++++++++++++

	public function encrypt($email, $pass)
	{
		$str = str_replace('_-_','@',$email);
		return $this->hash_password($str,$pass);

	}

	public function decrypt($str,$pass)
	{

		//echo $this->encrypt_model->hash_password($str,$pass);

		$row = $this->validate_password($str,$pass);
		if($this->validate_password($str,$pass)){

			echo 'YES';

		}else{

			echo 'No';

		}

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
?>