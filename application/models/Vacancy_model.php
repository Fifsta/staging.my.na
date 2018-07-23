<?php
class Vacancy_model extends CI_Model{
	
 	public function __construct(){
  	
  		//parent::CI_model();
			
 	}


	public function get_applicant_dump($client_id) {


		$this->load->library('zip');
		//$this->load->helper('download');

		$data='NO DOWNLOAD! :: File(s): ';

		$info_array = array();

		$query = $this->db->query("SELECT *,

							  (SELECT group_concat(CONCAT(F.type, ':', F.institution, ':', F.study_field, ':', F.qualification) SEPARATOR ',') FROM applicant_education AS F WHERE F.client_id = A.client_id) as edu,

							  (SELECT group_concat(G.skill SEPARATOR ', ') FROM applicant_skills AS G WHERE G.client_id = A.client_id) as skillz,

							  (SELECT group_concat(CONCAT(H.language, ':', H.prof_read, ':', H.prof_write, ':', H.prof_speak, ':', H.skill_read, ':', H.skill_write, ':', H.skill_speak, ':', H.first_language) SEPARATOR ',') FROM applicant_languages AS H WHERE H.client_id = A.client_id) as langs,

							  (SELECT group_concat(CONCAT(I.company, ':', I.business_type, ':', I.position, ':', I.level, ':', I.type, ':', I.salary_type, ':', I.benefits, ':', I.dur_from, ':', I.dur_to) SEPARATOR ',') FROM applicant_employment AS I WHERE I.client_id = A.client_id) as employ,

							  (SELECT group_concat(J.competency SEPARATOR ', ') FROM applicant_core_competencies AS J WHERE J.client_id = A.client_id) as comps

							  FROM applicants AS A

							  RIGHT JOIN u_client AS B ON A.client_id = B.ID

							  RIGHT JOIN applicant_bio AS C ON A.client_id = C.client_id

							  WHERE A.client_id = '".$client_id."' ", FALSE);

		if($query->result()){


			$row = $query->row();

			switch($row->CLIENT_GENDER) {
				case 'M':
					$gender = 'Male';
					break;
				case 'F':
					$gender = 'Female';
					break;
			}

			if($row->disabled == 'Y') { $disability = $row->disability; } else { $disability = ''; }


			//GET EDUCATION
			$edu = '';
			$edu2 = '';

			if($row->edu != '') {

				$go = explode(',',$row->edu);
				foreach( $go as $educ )
				{

					$go2 = explode(':',$educ);

					switch($go2[0]) {
						case 'secondary':
							$e_type = '<strong>Secondary Education:</strong>';
							break;
						case 'tertiary':
							$e_type = '<strong>Tertiary Education:</strong>';
							break;
						case 'course':
							$e_type = '<strong>Course:</strong>';
							break;
					}

					$edu.= $e_type.'<br>'.$go2[1].'<br>'.$go2[2].'<br>';
				}
				//END GET EDUCATION

			}


			//GET LANGUAGE
			$lng = '';
			$lng2 = '';

			if($row->langs != '') {

				$lgo = explode(',',$row->langs);
				foreach( $lgo as $langz )
				{

					$lgo2 = explode(':',$langz);


					$language = $lgo2[0];
					$pread = $lgo2[1];
					$pwrite = $lgo2[2];
					$pspeak = $lgo2[3];
					$sread = $lgo2[4];
					$swrite = $lgo2[5];
					$sspeak = $lgo2[6];
					$fl = $lgo2[7];

					if($sread != 'none') { $sr = '('.$sread.')'; } else { $sr = ''; }
					if($swrite != 'none') { $sw = '('.$swrite.')'; } else { $sw = ''; }
					if($sspeak != 'none') { $ss = '('.$sspeak.')'; } else { $ss = ''; }

					$lng.= '<strong>'.$language.'</strong><br>Read: '.$pread.' '.$sr.'<br>Write: '.$pwrite.' '.$sw.'<br>Speak: '.$pspeak.' '.$ss.'<br><br>';
				}
			}
			//END GET LANGUAGE

			//GET EMPLOYMENT
			$emp = '';
			$emp2 = '';

			if($row->employ != '') {

				$ego = explode(',',$row->employ);
				foreach( $ego as $employs )
				{

					$ego2 = explode(':',$employs);


					$company = $ego2[0];
					$position = $ego2[1];
					$btype = $ego2[2];
					$level = $ego2[3];
					$type = $ego2[4];
					$benefits = $ego2[5];
					$dur_from = $ego2[6];
					$dur_to = $ego2[7];


					$emp.= $type.' '.$level.' '.$position.' '.$btype.' at '.$company.' from '.date('Y', strtotime($dur_from)).' to '.date('Y', strtotime($dur_to)).'<br><strong>Benefits:</strong> '.$benefits;
				}
			}

			$doc_name = strtolower($row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'_career_bundle_'.date("dmYhis"));

			$html = '';
			$html.= $this->get_applicant_avatar($row->client_id);
			$html.= '<h1>'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</h1>';

			$html.= '
					<h2>Applicant Details:</h2>
					<table class="table table-striped">
						<tr><td><strong>Name: </strong></td><td>'.$row->CLIENT_NAME .' '. $row->CLIENT_SURNAME.'</td></tr>
						<tr><td><strong>Gender: </strong></td><td>'.$gender.'</td></tr>
						<tr><td><strong>Date of Birth: </strong></td><td>'.date('d M Y', strtotime($row->CLIENT_DATE_OF_BIRTH)).'</td></tr>
						<tr><td><strong>Email: </strong></td><td> '.$row->CLIENT_EMAIL.'</td></tr>
						<tr><td><strong>Tel: </strong></td><td> '.$row->CLIENT_TELEPHONE.'</td></tr>
						<tr><td><strong>Cell: </strong></td><td> '.$row->CLIENT_CELLPHONE.'</td></tr>
						<tr><td><strong>ID Number: </strong></td><td> '.$row->id_number.'</td></tr>
						<tr><td><strong>Job Title: </strong></td><td> '.$row->job_title.'</td></tr>
						<tr><td><strong>Qualification: </strong></td><td>'.$row->qualification.'</td></tr>
						<tr><td><strong>Current Salary: </strong></td><td>'.$row->currency.' '.$row->current_tcc.'</td></tr>
						<tr><td><strong>Expected Salary: </strong></td><td>'.$row->currency.' '.$row->expected_tcc.'</td></tr>
						<tr><td><strong>Marital Status: </strong></td><td> '.$row->marital_status.'</td></tr>
						<tr><td><strong>Nationality: </strong></td><td> '.$row->nationality.'</td></tr>
						<tr><td><strong>Ethnicity: </strong></td><td> '.$row->ethnic.'</td></tr>
						<tr><td><strong>Country: </strong></td><td> '.$row->country.'</td></tr>
						<tr><td><strong>Region: </strong></td><td> '.$row->region.'</td></tr>
						<tr><td><strong>City: </strong></td><td> '.$row->city.'</td></tr>
						<tr><td><strong>Racial Advantage: </strong></td><td>'. $row->bee.'</td></tr>
						<tr><td><strong>Drivers Licence: </strong></td><td> '.$row->drivers.' ('.$row->drivers_type.')</td></tr>
						<tr><td><strong>Disabiled: </strong></td><td> '.$row->disabled.'</tr>
						<tr><td><strong>Nature of Disability: </strong></td><td>'.$disability.'</td></tr>

					</table>
				<hr>
				';

			$html.= '<h2>Biography:</h2>'.$row->biography.'<hr>';

			$html.= '<h2>Leisure:</h2>'.$row->leisure.'<hr>';

			$html.= '<h2>Employment History:</h2>'.$emp.'<hr>';

			$html.= '<h2>Education:</h2>'.$edu.'<hr>';

			$html.= '<h2>Skills:</h2>'.$row->skillz.'<hr>';

			$html.= '<h2>Core Competencies:</h2>'.$row->comps.'<hr>';

			$html.= '<h2>Languages:</h2>'.$lng.'<hr>';


			// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
			$pdfFilePath = BASE_URL."assets/vacancies/documents/".$doc_name.".pdf";

			if (file_exists($pdfFilePath) == FALSE)
			{
				ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">


				$this->load->library('pdf');
				$pdf = $this->pdf->load();
				$pdf->WriteHTML($html); // write the HTML into the PDF
				$pdf->Output($pdfFilePath, 'F'); // save to file because we can

				$file =  BASE_URL."assets/vacancies/documents/".$doc_name.".pdf";


				$this->zip->read_file($file);


			}


			//ATTACH OTHER DOCUMENTS
			$query4 = $this->db->query("SELECT * FROM applicant_documents WHERE client_id = '".$client_id."'", FALSE);

			if($query->result()){

				foreach($query4->result() as $row){

					$pdfFilePathA = 'https://d3rp5jatom3eyn.cloudfront.net/assets/vacancies/documents/'.$row->doc_file;



					$this->zip->add_data($row->doc_file, file_get_contents($pdfFilePathA));

				}

			}

			$this->zip->download($doc_name.'.zip');


		}else{


		}




	}



	function add_applicant_docs()
	{

		$http_origin = $_SERVER['HTTP_ORIGIN'];

		$this->output->set_header("Access-Control-Allow-Origin: *");

		$this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST") {


			$this->load->library('upload');  // NOTE: always load the library outside the loop

			$client_id = $this->input->post('client_id');

			$img_allowed =  array('gif' , 'GIF' , 'png' , 'PNG' , 'jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'tiff' , 'TIFF' , 'bmp' , 'BMP' );
			$doc_allowed =  array('doc' , 'DOC' , 'docx' , 'DOCX' , 'pdf' , 'PDF' , 'xls' , 'XLS' , 'xlsx' , 'XLXS' , 'csv' , 'CSV' );


			if(isset($_FILES['file']['name'])){

				$this->total_count_of_files = count($_FILES['file']['name']);
				/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */

				$_FILES['userfile']['name']    = $_FILES['file']['name'];
				$_FILES['userfile']['type']    = $_FILES['file']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				$_FILES['userfile']['error']       = $_FILES['file']['error'];
				$_FILES['userfile']['size']    = $_FILES['file']['size'];

				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				//Check if document
				if(in_array($ext,$doc_allowed) ) {
					$dest_folder = "documents";
					$type = "document";
				}

				//Check if image
				if(in_array($ext,$img_allowed) ) {
					$dest_folder = "images/";
					$type = "image";
				}


				$config['upload_path'] = BASE_URL . 'assets/vacancies/documents';
				$config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF|tiff|TIFF|bmp|BMP|doc|DOC|docx|DOCX|pdf|PDF|xls|XLS|xlsx|XLSX|csv|CSV';
				$config['overwrite']     = FALSE;
				/*
				$config['max_size']	= '0';
				$config['max_width']  = '8324';
				$config['max_height']  = '8550';
				$config['min_width']  = '200';
				$config['min_height']  = '200';
				*/

				$config['remove_spaces']  = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->upload->initialize($config);


				if($this->upload->do_upload())
				{

					$data = array('upload_data' => $this->upload->data());
					$file =  $this->upload->file_name;
					$oname =  $this->upload->orig_name;
					$width = $this->upload->image_width;
					$height = $this->upload->image_height;

					$filename = BASE_URL.'assets/vacancies/documents/'.$file;
					$size = filesize($filename);
					$size = $this->FileSizeConvert($size);

					//populate array with values
					$data = array(
						'client_id' => $client_id,
						'type' => $type,
						'title' => $oname,
						'doc_file' =>$file,
						'doc_size' =>$size
					);

					//insert into database
					$this->db->insert('applicant_documents',$data);

					//crop
					$data['filename'] = $file;
					//$data['width'] = $this->upload->image_width;
					//$data['height'] = $this->upload->image_height;
					$val = TRUE;

					//SEND TO BUCKET
					//You need to set only the path, and name, no absolute path!!!
					//check if exists, then send it to s3
					$this->load->model('cron_model');
					//UPLOAD S3
					if(file_exists(BASE_URL.'assets/vacancies/documents/'.$file)){

						$data['out'] = $this->cron_model->upload_s3('assets/vacancies/documents/'.$file);
					}else{

						$data['out'] = 'Not Uploaded';

					}


				}else{
					//ERROR
					$val = FALSE;
					$data['error'] =  $this->upload->display_errors();

					echo $this->upload->display_errors();;

					echo '<br>'.BASE_URL . 'assets/vacancies/documents';

				}

				//redirect
				if($val == TRUE){

					//SUCESSS MESSAGE SCRIPT COMES HERE!!!!

				}else{

					//ERROR MESSAGE SCRIPT COMES HERE!!!!

				}

			}
		}
	}

	//+++++++++++++++++++++++++++
	//DELETE APPLICANT DOCUMENT DO
	//++++++++++++++++++++++++++
	function delete_applicant_document_do($did) {

		$http_origin = $_SERVER['HTTP_ORIGIN'];

		// if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
		//{
		$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
		//}

		//$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

		}elseif($_SERVER['REQUEST_METHOD'] == "GET") {

			$query = $this->db->query("SELECT type, doc_file FROM applicant_documents WHERE app_doc_id = '".$did."'", FALSE);

			$row = $query->row();

			$doc_file =  BASE_URL.'assets/vacancies/documents/'.$row->doc_file; # build the full path
			if (file_exists($doc_file)) {
				unlink($doc_file);
			}


			//delete from database
			$this->db->where('app_doc_id', $did);
			$this->db->delete('applicant_documents');

		}

	}

	//+++++++++++++++++++++++++++
	//BULK MULTI APPLICANT DOCS
	//++++++++++++++++++++++++++
	public function action_applicant_docs_bulk() {


		$http_origin = $_SERVER['HTTP_ORIGIN'];

		$this->output->set_header("Access-Control-Allow-Origin: *");

		$this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST") {

			$this->load->library('zip');

			$doc_files = $this->input->post('doc_files');

			$client_id = $this->input->post('client_id');

			$type = $this->input->post('bulk');
			$title = $this->input->post('title');
			$title = str_replace(' ','_',$title);

			if(!empty($doc_files)) {

				//Remove bulk entries
				if($type == 1) {

					foreach($doc_files as $did) {

						$query = $this->db->query("SELECT * FROM applicant_documents WHERE app_doc_id = '".$did."' AND client_id = '".$client_id."'", FALSE);

						$row = $query->row();

						switch($row->type) {
							case 'document':
								$dest_folder = 'documents/vacancies';
								break;
							case 'image':
								$dest_folder = 'images';
								break;
						}

						$doc_file =  BASE_URL.'assets/vacancies/'.$dest_folder.'/' . $row->doc_file; # build the full path

						if (file_exists($doc_file)) {
							unlink($doc_file);
						}


						$this->db->where('app_doc_id', $did);
						$this->db->delete('applicant_documents');


					}

				}

				if($type == 2) {

					$date = date('Y-m-d H:i:s');
					$zip_file = $title.'_'.$date;

					//$this->zip->add_dir(NA_BASE_URL.'assets/vacancies/zip/my_backup');

					foreach($doc_files as $did) {

						$query = $this->db->query("SELECT * FROM applicant_documents WHERE app_doc_id = '".$did."' AND client_id = '".$client_id."'", FALSE);

						if($query->result()){

							$row = $query->row();

							switch($row->type) {
								case 'document':
									$dest_folder = 'documents/vacancies';
									break;
								case 'image':
									$dest_folder = 'images';
									break;
							}


							$file = BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$row->doc_file; # build the full path


							$this->zip->read_file($file);


						} //end result
					} // end for each

					//$this->zip->read_file($file);

					$this->zip->download($zip_file);

				}

			}

		} // end if empty
	} // end function



	function check_apply($id) {

		$client_id = $this->session->userdata('id');

		if($client_id) {

			$query = $this->db->query("SELECT client_id FROM vacancy_applicants WHERE client_id = '".$client_id."' AND vacancy_id = '".$id."' ", FALSE);

			if(!$query->result()) {

				return '<button class="btn btn-dark btn-lg" id="form-submit">Apply</button>';

			} else {

				return '<strong>You have already applied for this Vacancy</strong>';

			}

		} else {

			return '<strong>You need to be logged in to apply online</strong>';

		}


	}


	//+++++++++++++++++++++++++++
	//APPLY DO
	//++++++++++++++++++++++++++
	public function apply_do()
	{

		$id = $this->input->post('vid', TRUE);
		$bus_id = $this->input->post('bus_id', TRUE);
		$title = $this->input->post('title', TRUE);
		$ref_no = $this->input->post('ref_no', TRUE);
		$client_id = $this->session->userdata('id');


		$val = 'true';


		//CHECK IF USER ALREADY APPLIED//
		$query = $this->db->query("SELECT A.va_id, B.title, B.ref_no, B.bus_id FROM vacancy_applicants AS A LEFT JOIN vacancies AS B ON A.va_id = B.vacancy_id WHERE A.vacancy_id = '".$id."' AND A.client_id = '".$client_id."' ", FALSE);

		if($query->result()){

			echo '<div class="alert alert-secondary"><strong>You already applied for this Vacancy</strong></div>';

		} else {

			$row = $query->row();

			if($val == 'true') {

				$insertdata = array(
					'bus_id' => $bus_id,
					'client_id' => $client_id,
					'vacancy_id' => $id,
					'status' => 'pending'
				);

				$this->db->insert('vacancy_applicants', $insertdata);


				//SEND EMAIL TO COMPANY
				//$this->send_application_email($title, $client_id, $ref_no);


				echo '<div class="alert alert-success"><strong>Congratulations, you qualified for the position of ' . $title . '. Application sent to our HR department for approval.</strong></div>';

			}

		}

	}


	/*function send_application_email($title, $client_id, $ref_no) {

		//$db2 = $this->connect_my_db();

		//GET USER DETAILS/
		$query = $this->db->query("SELECT CLIENT_NAME, CLIENT_SURNAME, CLIENT_EMAIL FROM u_client WHERE ID = '".$client_id."'", FALSE);

		if($query->result()){

			$row = $query->row();


			$body = 'Hi ' . $row['CLIENT_NAME'] . ',<br /><br />
									You have received a new question regarding your product ' . $title . ' <strong>(Ref: ' . $ref_no . ')</strong> listed on My Namibia&trade; Career.<br /><br />
								    <table border="0" cellpadding="5" cellspacing="0" width="100%;max-width:600px">


								    </table>
									<br /><br />
									<a style="text-decoration:none" href="' . site_url('/') . 'product/' . $product_id . '/">View ' . $product_title . '</a><br />
									Please answer the question by viewing it in your Buy and Sell section in the dashboard.<br /><br />
									<a style="text-decoration:none" href="' . site_url('/') . 'sell/my_trade/">Go to Dashboard</a><br />
									Have a !tna day!<br />
									My Namibia';

			$data_view['body'] = $body;
			$body_final = $this->load->view('email/body_news', $data_view, true);

			$fromEMAIL = 'no-reply@my.na';
			$fromEMAIL = $sender_email;
			$fromNAME = 'My Namibia Trade';
			$fromNAME = $sender_name;
			$TAG = array('tags' => 'trade_question');


			//SEND EMAIL LINK
			$this->load->model('email_model');
			$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);






			$subject = 'My.Na Careers - Vacancy Application';

			$msg = '<h1>The following member has applied for a vacancy</h1>
			 		<br>
					<strong>Name:</strong> '.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'<br>
					<strong>Email:</strong> '.$row->CLIENT_EMAIL.'<br>
					<strong>Vacancy:</strong> '.$title.'<br><br>
				';

			$data1 = array(
				'name'=>  'My.Na Careers - Vacancy Application',
				'email'=> $row->CLIENT_EMAIL,
				'body'=> $msg,
				'type'=> 'application',
				'email_to' => 'christian@intouch.com.na',
				'subject' => $subject
			);

			//SEND EMAIL LINK

			$this->load->model('email_model');
			$this->email_model->send_enquiry($data1);

		}
	}*/



	//+++++++++++++++++++++++++++
	//GET MY VACANCIES
	//++++++++++++++++++++++++++
	public function get_my_vacancies()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM vacancy_applicants AS A, vacancies AS B WHERE A.client_id = '".$client_id."' AND A.vacancy_id = B.vacancy_id AND B.start_date < NOW() AND B.end_date >= NOW() AND B.status = 'live' ORDER BY B.listing_date DESC", FALSE);


		if($query->result()){

			echo '<table class="table table-striped">';

			foreach($query->result() as $row){

				echo '<tr><td><a target="_blank" href="'.site_url('/').'careers/job/'.$row->vacancy_id.'/'.$row->slug.'/">'.$row->title.'</td><td><span class="label label-warning pull-right"><span class="glyphicon glyphicon-time" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Application pending for review"></span></span></a></li></td></tr>';

			}

			echo '</table>';

		}else{

			echo '<div class="alert">
			 		<h5>No Vacancies listed </h5>
				   </div>';

		}
	}


	//+++++++++++++++++++++++++++
	//ADD BIOGRAPHY
	//++++++++++++++++++++++++++
	public function add_bio()
	{

		$bio = $this->input->post('content', TRUE);

		$client_id = $this->session->userdata('id');

		$updatedata = array(
			'biography'=> $bio
		);

		//CHECK IF USER EXISTS IN CLIENTS
		$query2 = $this->db->query("SELECT * FROM applicant_bio WHERE client_id = '".$client_id."'", FALSE);

		if($query2->result()) {

			$this->db->where('client_id', $client_id);
			$this->db->update('applicant_bio', $updatedata);

		} else {

			$this->db->insert('applicant_bio', $updatedata);

		}

		echo 'Success';

	}



	//+++++++++++++++++++++++++++
	//GET PROFILE
	//++++++++++++++++++++++++++
	public function get_profile()
	{


		$client_id = $this->session->userdata('id');


		$query = $this->db->query("SELECT * FROM u_client AS A

									 LEFT JOIN applicant_bio AS B on A.ID = B.client_id

									 LEFT JOIN a_country AS C on A.CLIENT_COUNTRY = C.ID

									 LEFT JOIN a_map_region AS D on A.CLIENT_REGION = D.ID

									 LEFT JOIN a_map_location AS E on A.CLIENT_CITY = E.ID

									 WHERE A.ID = '".$client_id."'", FALSE);

		if($query->result()){

			return $query->row_array();

		}
	}


	//++++++++++++++++++++++++++
	//GET General Details
	//++++++++++++++++++++++++++
	public function get_general_details()
	{


		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM u_client AS A

								   LEFT JOIN applicant_bio AS B ON A.ID = B.client_id

								   WHERE A.ID = '".$client_id."'", FALSE);

		if($query->result()){

			return $query->row_array();

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE GENERAL DETAILS
	//++++++++++++++++++++++++++
	function update_general_details(){


		$client_id = $this->session->userdata('id');

		$name = $this->input->post('name', TRUE);
		$surname = $this->input->post('surname', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$marital = $this->input->post('marital', TRUE);
		$id_number = $this->input->post('id_number', TRUE);

		$email = $this->input->post('email', TRUE);
		$email = trim($email);

		$tel = $this->input->post('tel', TRUE);
		$cell = $this->input->post('cell', TRUE);

		$country = $this->input->post('country', TRUE);
		$region = $this->input->post('region', TRUE);
		$city = $this->input->post('city', TRUE);

		$nationality = $this->input->post('nationality', TRUE);

		$address = $this->input->post('address', TRUE);
		$box_address = $this->input->post('box_address', TRUE);

		$current_employee = $this->input->post('current_employee', TRUE);
		if($current_employee != 'Y') { $current_employee = 'N'; }

		$rpl = $this->input->post('rpl', TRUE);
		if($rpl != 'Y') { $rpl = 'N'; }

		$bee = $this->input->post('bee', TRUE);

		$disabled = $this->input->post('disabled', TRUE);
		if($disabled != 'Y') { $disabled = 'N'; }

		$disability = $this->input->post('disability', TRUE);


		$drivers = $this->input->post('drivers', TRUE);
		if($drivers != 'Y') { $drivers = 'N'; }

		$drivers_type = $this->input->post('drivers_type', TRUE);

		$temp_work = $this->input->post('temp_work', TRUE);
		if($temp_work != 'Y') { $temp_work = 'N'; }


		$dob = $this->input->post('dob', TRUE);
		$dob = date('Y-m-d', strtotime($dob));

		//CHECK IF USER EXISTS IN CLIENTS
		$query = $this->db->query("SELECT * FROM u_client WHERE ID = '".$client_id."'", FALSE);


		if($query->result()){

			$row = $query->row();

			$val = FALSE;


			//UPDATE U_CLIENT TABLE
			if($name != "") {
				$data['CLIENT_NAME'] = $name;
				$val = TRUE;
			}
			if($surname != "") {
				$data['CLIENT_SURNAME'] = $surname;
				$val = TRUE;
			}
			if($dob != "") {
				$data['CLIENT_DATE_OF_BIRTH'] = $dob;
				$val = TRUE;
			}
			if($country != "") {
				$data['CLIENT_COUNTRY'] = $country;
				$val = TRUE;
			}
			if($region != "") {
				$data['CLIENT_REGION'] = $region;
				$val = TRUE;
			}
			if($city != "") {
				$data['CLIENT_CITY'] = $city;
				$val = TRUE;
			}
			if($gender != "") {
				$data['CLIENT_GENDER'] = $gender;
				$val = TRUE;
			}

			if($tel != "") {
				$data['CLIENT_TELEPHONE'] = $tel;
				$val = TRUE;
			}

			if($row->VERIFIED == 'N') {
				if($cell != '') {
					$data['CLIENT_CELLPHONE'] = $cell;
					$val = TRUE;
				}
			}

			if($val == TRUE) {

				$this->db->where('ID', $row->ID);
				$this->db->update('u_client', $data);

			}

		}

		//CHECK IF USER EXISTS IN CLIENTS
		$query2 = $this->db->query("SELECT * FROM applicant_bio WHERE client_id = '".$client_id."'", FALSE);

		$bio_update = array(
			'client_id' => $client_id,
			'marital_status' => $marital,
			'nationality' => $nationality,
			'bee' => $bee,
			'disabled' => $disabled,
			'disability' => $disability,
			'drivers' => $drivers,
			'drivers_type' => $drivers_type,
			'id_number' => $id_number,
			'box_address' => $box_address,
			'address' => $address
		);

		if($query2->result()) {


			$this->db->where('client_id', $client_id);
			$this->db->update('applicant_bio', $bio_update);

		} else {

			$this->db->insert('applicant_bio', $bio_update);

		}


	}


	//++++++++++++++++++++++++++
	//GET General Details
	//++++++++++++++++++++++++++
	public function get_education($type)
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_education WHERE client_id = '".$client_id."' AND type = '".$type."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				if($type == 'secondary') {

					echo '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->app_education_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
					</tr>
					';

				}

				if($type == 'tertiary') {

					echo '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->app_education_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
						</tr>
					';

				}

				if($type == 'course') {

					echo '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->institution.'</td>
						<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->app_education_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
						</tr>
					';

				}

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET QUALIFICATIONS
	//++++++++++++++++++++++++++
	public function get_qualifications($type)
	{


		$query = $this->db->query("SELECT * FROM education WHERE education_type = '".$type."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->education.'">'.$row->education.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++++++++
	//DELETE EDUCATION
	//+++++++++++++++++++++++++++++++++
	function delete_education($id, $type){

		$this->db->where('app_education_id' , $id);
		$this->db->delete('applicant_education');

		if($type == 'secondary') {

			$this->db->where('education_id' , $id);
			$this->db->delete('applicant_scores');

		}


	}




	function get_subject_points($score, $qualification) {

		if($qualification == 'GRADE 10 JSC') {

			switch($score) {
				case 'A':
					$points = 7;
					break;
				case 'B':
					$points = 6;
					break;
				case 'C':
					$points = 5;
					break;
				case 'D':
					$points = 4;
					break;
				case 'E':
					$points = 3;
					break;
				case 'F':
					$points = 2;
					break;
				case 'G':
					$points = 1;
					break;
			}

		}

		if($qualification == 'STD. 8 (HG)') {

			switch($score) {
				case 'A':
					$points = 8;
					break;
				case 'B':
					$points = 7;
					break;
				case 'C':
					$points = 6;
					break;
				case 'D':
					$points = 5;
					break;
				case 'E':
					$points = 4;
					break;
				case 'F':
					$points = 3;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}

		if($qualification == 'STD. 8 (SG)') {

			switch($score) {
				case 'A':
					$points = 7;
					break;
				case 'B':
					$points = 6;
					break;
				case 'C':
					$points = 5;
					break;
				case 'D':
					$points = 4;
					break;
				case 'E':
					$points = 3;
					break;
				case 'F':
					$points = 2;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}

		if($qualification == 'STD. 8 (LG)') {

			switch($score) {
				case 'A':
					$points = 5;
					break;
				case 'B':
					$points = 4;
					break;
				case 'C':
					$points = 3;
					break;
				case 'D':
					$points = 2;
					break;
				case 'E':
					$points = 1;
					break;
				case 'F':
					$points = 1;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}

		if($qualification == 'GCE- A LEVELS') {

			switch($score) {
				case 'A':
					$points = 12;
					break;
				case 'B':
					$points = 11;
					break;
				case 'C':
					$points = 10;
					break;
				case 'D':
					$points = 9;
					break;
				case 'E':
					$points = 8;
					break;
				case 'F':
					$points = 0;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}

		if($qualification == 'IGCSE & GCE - O LEVELS') {

			switch($score) {
				case 'A':
					$points = 8;
					break;
				case 'B':
					$points = 7;
					break;
				case 'C':
					$points = 6;
					break;
				case 'D':
					$points = 5;
					break;
				case 'E':
					$points = 4;
					break;
				case 'F':
					$points = 3;
					break;
				case 'G':
					$points = 2;
					break;
			}

		}

		if($qualification == 'HIGCSE') {

			switch($score) {
				case '1':
					$points = 10;
					break;
				case '2':
					$points = 9;
					break;
				case '3':
					$points = 8;
					break;
				case '4':
					$points = 7;
					break;
			}

		}

		if($qualification == 'SENIOR CERTIFICATE HG') {

			switch($score) {
				case 'A':
					$points = 10;
					break;
				case 'B':
					$points = 9;
					break;
				case 'C':
					$points = 8;
					break;
				case 'D':
					$points = 7;
					break;
				case 'E':
					$points = 6;
					break;
				case 'F':
					$points = 4;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}

		if($qualification == 'SENIOR CERTIFICATE SG') {

			switch($score) {
				case 'A':
					$points = 8;
					break;
				case 'B':
					$points = 7;
					break;
				case 'C':
					$points = 6;
					break;
				case 'D':
					$points = 5;
					break;
				case 'E':
					$points = 4;
					break;
				case 'F':
					$points = 3;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}


		if($qualification == 'SENIOR CERTIFICATE LG') {

			switch($score) {
				case 'A':
					$points = 5;
					break;
				case 'B':
					$points = 4;
					break;
				case 'C':
					$points = 3;
					break;
				case 'D':
					$points = 2;
					break;
				case 'E':
					$points = 1;
					break;
				case 'F':
					$points = 1;
					break;
				case 'G':
					$points = 0;
					break;
			}

		}

		return $points;

	}


	function upload_subject($client_id, $ed_id, $subject, $level, $score) {

		$insertdata = array(
			'client_id'=> $client_id,
			'education_id'=> $ed_id,
			'subject'=>$subject,
			'level'=> $level,
			'score'=> $score
		);

		$this->db->insert('applicant_scores', $insertdata);

	}


	//+++++++++++++++++++++++++++
	//ADD EDUCATION
	//++++++++++++++++++++++++++
	function add_education() {

		$client_id = $this->session->userdata('id');

		$type = $this->input->post('education_type', TRUE);
		$institution = $this->input->post('institution', TRUE);
		$dur_from = $this->input->post('dur_from', TRUE);
		$dur_to = $this->input->post('dur_to', TRUE);


		if($type == 'secondary') {

			$qualification = $this->input->post('qualification', TRUE);
			$qualification_type = $this->input->post('qualification_type', TRUE);

			$insertdata = array(
				'client_id'=> $client_id,
				'institution'=> $institution,
				'type'=>$type,
				'dur_from'=> date('d-m-y', strtotime($dur_from)),
				'dur_to'=> date('d-m-y', strtotime($dur_to)),
				'qualification'=> $qualification
			);

			$this->db->insert('applicant_education', $insertdata);

			$ed_id = $this->db->insert_id() ;

			if($qualification_type == '10') {

				$subject1 = $this->input->post('subject1', TRUE);

				if($subject1 != '') {
					$score1 = $this->input->post('score1', TRUE);
					$points1 = $this->get_subject_points($score1, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject1, $qualification, $points1);
				}


				$subject2 = $this->input->post('subject2', TRUE);
				if($subject2 != '') {

					$score2 = $this->input->post('score2', TRUE);
					$points2 = $this->get_subject_points($score2, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject2, $qualification, $points2);

				}

				$subject3 = $this->input->post('subject3', TRUE);
				if($subject3 != '') {
					$score3 = $this->input->post('score3', TRUE);
					$points3 = $this->get_subject_points($score3, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject3, $qualification, $points3);
				}


				$subject4 = $this->input->post('subject4', TRUE);
				if($subject4 != '') {
					$score4 = $this->input->post('score4', TRUE);
					$points4 = $this->get_subject_points($score4, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject4, $qualification, $points4);
				}

				$subject5 = $this->input->post('subject5', TRUE);
				if($subject5 != '') {
					$score5 = $this->input->post('score5', TRUE);
					$points5 = $this->get_subject_points($score5, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject5, $qualification, $points5);
				}

				$subject6 = $this->input->post('subject6', TRUE);
				if($subject6 != '') {
					$score6 = $this->input->post('score6', TRUE);
					$points6 = $this->get_subject_points($score6, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject6, $qualification, $points6);
				}

				$subject7 = $this->input->post('subject7', TRUE);
				if($subject7 != '') {
					$score7 = $this->input->post('score7', TRUE);
					$points7 = $this->get_subject_points($score7, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject7, $qualification, $points7);
				}

			}

			if($qualification_type == '12') {

				$subject1 = $this->input->post('subject1', TRUE);
				if($subject1 != '') {
					$score1 = $this->input->post('score1', TRUE);
					$points1 = $this->get_subject_points($score1, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject1, $qualification, $points1);
				}


				$subject2 = $this->input->post('subject2', TRUE);
				if($subject2 != '') {
					$score2 = $this->input->post('score2', TRUE);
					$points2 = $this->get_subject_points($score2, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject2, $qualification, $points2);
				}

				$subject3 = $this->input->post('subject3', TRUE);
				if($subject3 != '') {
					$score3 = $this->input->post('score3', TRUE);
					$points3 = $this->get_subject_points($score3, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject3, $qualification, $points3);
				}


				$subject4 = $this->input->post('subject4', TRUE);
				if($subject4 != '') {
					$score4 = $this->input->post('score4', TRUE);
					$points4 = $this->get_subject_points($score4, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject4, $qualification, $points4);
				}

				$subject5 = $this->input->post('subject5', TRUE);
				if($subject5 != '') {
					$score5 = $this->input->post('score5', TRUE);
					$points5 = $this->get_subject_points($score5, $qualification);
					$this->upload_subject($client_id, $ed_id, $subject5, $qualification, $points5);
				}


			}


		}

		if($type == 'tertiary') {

			$qualification = $this->input->post('qualification', TRUE);
			$field = $this->input->post('study_field', TRUE);

			$insertdata = array(
				'client_id'=> $client_id,
				'institution'=> $institution,
				'study_field'=> $field,
				'type'=>$type,
				'dur_from'=> date('d-m-y', strtotime($dur_from)),
				'dur_to'=> date('d-m-y', strtotime($dur_to)),
				'qualification'=> $qualification
			);

			$this->db->insert('applicant_education', $insertdata);

		}

		if($type == 'course') {

			$field = $this->input->post('study_field', TRUE);

			$insertdata = array(
				'client_id'=> $client_id,
				'institution'=> $institution,
				'study_field'=> $field,
				'type'=>$type,
				'dur_from'=> date('d-m-y', strtotime($dur_from)),
				'dur_to'=> date('d-m-y', strtotime($dur_to)),
			);

			$this->db->insert('applicant_education', $insertdata);

		}

		echo 'Success';

	}




	//+++++++++++++++++++++++++++
	//GET Main Categories
	//++++++++++++++++++++++++++
	public function get_category_name($cat_id)
	{

		$query = $this->db->select('category_name');
		$query = $this->db->where('cat_id', $cat_id);
		$query = $this->db->get('product_categories');

		if($query->result()){


			foreach($query->result() as $row){


				return ' / '.$row->category_name;

			}

		}

	}

	//+++++++++++++++++++++++++++
	//REMOVE APP CAT
	//++++++++++++++++++++++++++
	public function remove_app_cat($id) {

		$client_id = $this->session->userdata('id');

		//delete from database
		$query = $this->db->where('app_cat_id', $id);
		$query = $this->db->where('client_id', $client_id);
		$query = $this->db->delete('applicant_categories');

	}

	//+++++++++++++++++++++++++++
	//GET MY VACANCIES
	//++++++++++++++++++++++++++
	public function get_app_categories()
	{
		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_categories WHERE client_id = '".$client_id."'", FALSE);


		if($query->result()){

			echo '<table class="table table-striped">';

			foreach($query->result() as $row){

				echo
				'<tr><td>';

				if($row->sub_cat != '0') { echo $row->sub_cat; }
				if($row->sub_sub_cat != '0') { echo ' / '.$row->sub_sub_cat; }
				if($row->sub_sub_sub_cat != '0') { echo ' / '.$row->sub_sub_sub_cat; }

				if($row->experience != '') {

					echo ' <small>('.$row->experience.' experience)</small>';

				}

				echo
					'<button type="button" class="close" onclick="remove_app_cat('.$row->app_cat_id.')"><span aria-hidden="true">&times;</span></button>
				</td></tr>';

			}

			echo '</table>';

		}else{

			echo '<div class="alert alert-danger alert-dismissible fade in">No Categories added</div>';

		}
	}


	//+++++++++++++++++++++++++++
	//ADD APPLICANT CATEGORY
	//++++++++++++++++++++++++++
	function add_app_cat() {


		$client_id = $this->session->userdata('id');

		$main_cats = $this->input->post('main_cats', TRUE);
		$sub_cats = $this->input->post('sub_cats', TRUE);
		$sub_sub_cats = $this->input->post('sub_sub_cats', TRUE);
		$experience = $this->input->post('experience', TRUE);

		if($main_cats != '0') { $main_cat = trim(str_replace('/','',$this->get_category_name($main_cats))); } else { $main_cat = '0'; }
		if($sub_cats != '0') { $sub_cat = trim(str_replace('/','',$this->get_category_name($sub_cats))); } else { $sub_cat = '0'; }
		if($sub_sub_cats != '0') { $sub_sub_cat = trim(str_replace('/','',$this->get_category_name($sub_sub_cats))); } else { $sub_sub_cat = '0'; }

		//CHECK IF CAT ALREADY EXISTS
		$query = $this->db->query("SELECT app_cat_id FROM applicant_categories WHERE client_id = '".$client_id."' AND sub_cat = '".$main_cat."' AND sub_sub_cat = '".$sub_cat."' AND sub_sub_sub_cat = '".$sub_sub_cat."'", FALSE);

		if($query->result()){

		} else {

			$insertdata = array(
				'client_id'=> $client_id,
				'main_cat'=> '2633',
				'sub_cat'=> $main_cat,
				'sub_sub_cat'=> $sub_cat,
				'sub_sub_sub_cat'=> $sub_sub_cat,
				'experience'=> $experience
			);

			$this->db->insert('applicant_categories', $insertdata);

			echo 'Success';

		}

	}


	//+++++++++++++++++++++++++++
	//ADD APPLICANT DISCIPLINE
	//++++++++++++++++++++++++++
	function add_app_dis() {


		$client_id = $this->session->userdata('id');
		$discipline = $this->input->post('discipline', TRUE);
		$experience = $this->input->post('experience', TRUE);

		//CHECK IF CAT ALREADY EXISTS
		$query = $this->db->query("SELECT app_dis_id FROM applicant_disciplines WHERE client_id = '".$client_id."' AND discipline_id = '".$discipline."' ", FALSE);

		if($query->result()){

		} else {

			$insertdata = array(
				'client_id'=> $client_id,
				'discipline_id'=> $discipline,
				'experience'=> $experience
			);

			$this->db->insert('applicant_disciplines', $insertdata);

			echo 'Success';

		}

	}

	//+++++++++++++++++++++++++++
	//REMOVE DISCIPLINE
	//++++++++++++++++++++++++++
	public function remove_app_dis($id) {

		$client_id = $this->session->userdata('id');

		//delete from database
		$this->db->where('app_dis_id', $id);
		$this->db->where('client_id', $client_id);
		$this->db->delete('applicant_disciplines');


	}

	//+++++++++++++++++++++++++++
	//GET MY DISCIPLINES
	//++++++++++++++++++++++++++
	public function get_app_disciplines()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_disciplines AS A

		  							INNER JOIN vacancy_disciplines AS B on A.discipline_id = B.discipline_id

									WHERE A.client_id = '".$client_id."'", FALSE);


		if($query->result()){

			echo '<table class="table table-striped">';

			foreach($query->result() as $row){

				echo
				'<tr><td>';

				echo $row->discipline;

				if($row->experience != '') {

					echo ' <small>('.$row->experience.' experience)</small>';

				}

				echo
					'<button type="button" class="close" onclick="remove_app_dis('.$row->app_dis_id.')"><span aria-hidden="true">&times;</span></button>
				</td></tr>';

			}

			echo '</table>';

		}else{

			echo '<div class="alert alert-danger alert-dismissible fade in">No Disciplines added</div>';

		}
	}


	//+++++++++++++++++++++++++++
	//GET SKILLS
	//++++++++++++++++++++++++++
	public function get_skills()
	{

		$query = $this->db->get('skills');

		if($query->result()){
			foreach($query->result() as $row){
				echo "'".$row->skill."',";
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET SKILLS
	//++++++++++++++++++++++++++
	public function get_app_skills()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->where('client_id', $client_id);
		$query = $this->db->get('applicant_skills');

		if($query->result()){
			foreach($query->result() as $row){
				echo '<span style="margin-right:5px;margin-bottom:5px;cursor:pointer; padding:5px;" class="label label-primary pull-left" onclick="remove_skill('.$row->app_skill_id.')"><i class="glyphicon glyphicon-remove-circle" style="margin-top:2px"></i>&nbsp;&nbsp;'.$row->skill.'</span>';
			}
		}
	}


	//+++++++++++++++++++++++++++
	//ADD SKILL
	//++++++++++++++++++++++++++
	public function add_skill()
	{

		$client_id = $this->session->userdata('id');

		$skill = $this->input->post('skill', TRUE);

		$skilldata= array(
			'client_id'=> $client_id,
			'skill'=>$skill
		);

		$this->db->insert('applicant_skills', $skilldata);

		echo 'Success';

	}

	//+++++++++++++++++++++++++++++++++
	//DELETE SKILL
	//+++++++++++++++++++++++++++++++++
	function delete_skill($id){

		$query = $this->db->where('app_skill_id' , $id);
		$query = $this->db->delete('applicant_skills');


	}



	//+++++++++++++++++++++++++++
	//GET Main Categories
	//++++++++++++++++++++++++++
	public function get_main_categories_select($mcid="")
	{


		$query = $this->db->order_by('category_name', 'ASC');
		$query = $this->db->group_by('category_name');
		$query = $this->db->where('main_cat_id', '2633');
		$query = $this->db->get('product_categories');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->cat_id == $mcid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->category_name.'</option>';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//GET Sub Categories
	//++++++++++++++++++++++++++
	public function get_sub_categories_select($cat_id, $scid="")
	{


		$query = $this->db->order_by('category_name', 'ASC');
		$query = $this->db->where('sub_cat_id', $cat_id);
		$query = $this->db->get('product_categories');


		if($query->result()){

			echo '
			   <option value="0">Select a Sub Category</option>
			   ';

			foreach($query->result() as $row){

				if($row->cat_id == $scid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->category_name.'</option>';

			}


		} else {

			echo '<script>$("#sub-cats-div").hide("slow");</script>';

		}

	}

	//+++++++++++++++++++++++++++
	//GET Sub Categories
	//++++++++++++++++++++++++++
	public function get_sub_sub_categories_select($cat_id, $scid="")
	{


		$query = $this->db->order_by('category_name', 'ASC');
		$query = $this->db->where('sub_sub_cat_id', $cat_id);
		$query = $this->db->get('product_categories');


		if($query->result()){

			echo '
			   <option value="0">Select a Sub Category</option>
			   ';

			foreach($query->result() as $row){

				if($row->cat_id == $scid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->category_name.'</option>';

			}

		} else {

			echo '<script>$("#sub-sub-cats-div").hide("slow");</script>';

		}

	}


	//++++++++++++++++++++++++++
	//GET COUNTRY SELECT
	//++++++++++++++++++++++++++
	public function get_discipline_select()
	{


		$query = $this->db->query("SELECT * FROM vacancy_disciplines", FALSE);


		if($query->result()){

			foreach($query->result() as $row){


				echo '<option value="'.$row->discipline_id.'">'.$row->discipline.'</option>';

			}

		}

	}



	//++++++++++++++++++++++++++
	//GET ACHIEVEMENTS
	//++++++++++++++++++++++++++
	public function get_achievements()
	{


		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_achievements WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->receive_date != '0000-00-00') { $receive= date('d.m.Y', strtotime($row->receive_date)); } else { $receive = ''; }

				echo '<tr id="row-'.$row->achievement_id.'">
					<td>'.$row->achievement.'</td>
					<td>'.$row->organisation.'</td>
					<td>'.$receive.'</td>
					<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->achievement_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
				</tr>
				';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//ADD ACHIEVEMENT
	//++++++++++++++++++++++++++
	function add_achievement() {


		$client_id = $this->session->userdata('id');

		$achievement = $this->input->post('achievement', TRUE);
		$organisation = $this->input->post('organisation', TRUE);
		$received = $this->input->post('received', TRUE);

		$insertdata = array(
			'client_id'=> $client_id,
			'achievement'=> $achievement,
			'organisation'=>$organisation,
			'receive_date'=> date('d-m-y', strtotime($received))
		);

		$this->db->insert('applicant_achievements', $insertdata);

		echo 'Success';

	}

	//+++++++++++++++++++++++++++++++++
	//DELETE ACHIEVEMENT
	//+++++++++++++++++++++++++++++++++
	function delete_achievement($id){

		$this->db->where('achievement_id' , $id);
		$this->db->delete('applicant_achievements');
	}



	//++++++++++++++++++++++++++
	//GET EMPLOYMENTS
	//++++++++++++++++++++++++++
	public function get_employments()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_employment WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				echo '<tr id="row-'.$row->employment_id.'">
					<td>'.$row->company.'</td>
					<td>'.$row->position.'</td>
					<td>'.$row->business_type.'</td>
					<td>'.$row->level.'</td>
					<td>'.$row->type.'</td>
					<td>'.$row->salary_type.'</td>
					<td>'.$row->salary.'</td>
					<td>'.$row->frequency.'</td>
					<td>'.$row->benefits.'</td>
					<td>'.$date_from.' - '.$date_to.'</td>
					<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->employment_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
				</tr>
				';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//ADD EMPLOYMENT
	//++++++++++++++++++++++++++
	function add_employment() {


		$client_id = $this->session->userdata('id');

		$company = $this->input->post('company', TRUE);
		$position = $this->input->post('position', TRUE);
		$bus_type = $this->input->post('bus_type', TRUE);

		$level = $this->input->post('level', TRUE);
		$type = $this->input->post('type', TRUE);
		$salary_type = $this->input->post('salary_type', TRUE);

		$salary = $this->input->post('salary', TRUE);
		$frequency = $this->input->post('frequency', TRUE);
		$benefits = $this->input->post('benefits', TRUE);

		$dur_from = $this->input->post('dur_from', TRUE);
		$dur_to = $this->input->post('dur_to', TRUE);

		$why_leave = $this->input->post('why_leave', TRUE);

		$insertdata = array(
			'client_id'=> $client_id,
			'company'=> $company,
			'position'=>$position,
			'business_type'=>$bus_type,
			'level'=>$level,
			'type'=>$type,
			'salary_type'=>$salary_type,
			'salary'=>$salary,
			'frequency'=>$frequency,
			'benefits'=>$benefits,
			'dur_from'=> date('d-m-y', strtotime($dur_from)),
			'dur_to'=> date('d-m-y', strtotime($dur_to)),
			'why_leave'=>$why_leave,
		);

		$this->db->insert('applicant_employment', $insertdata);

		echo 'Success';

	}

	//+++++++++++++++++++++++++++++++++
	//DELETE EMPLOYMENT
	//+++++++++++++++++++++++++++++++++
	function delete_employment($id){

		$this->db->where('employment_id' , $id);
		$this->db->delete('applicant_employment');

	}



	//++++++++++++++++++++++++++
	//GET LANGUAGES
	//++++++++++++++++++++++++++
	public function get_languages()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_languages WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				echo '<tr id="row-'.$row->app_language_id.'">
					<td>'.$row->language.'</td>
					<td>'.$row->prof_read.'</td>
					<td>'.$row->prof_write.'</td>
					<td>'.$row->prof_speak.'</td>
					<td>'.$row->first_language.'</td>
					<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->app_language_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
				</tr>
				';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//ADD LANGUAGE
	//++++++++++++++++++++++++++
	function add_language() {

		$client_id = $this->session->userdata('id');

		$language = $this->input->post('language', TRUE);
		$read = $this->input->post('read', TRUE);
		$write = $this->input->post('write', TRUE);
		$speak = $this->input->post('speak', TRUE);
		$first_lang = $this->input->post('first_lang', TRUE);

		if($read == 'Y') { $read = 'Y'; } else { $read = 'N'; }
		if($write == 'Y') { $write = 'Y'; } else { $write = 'N'; }
		if($speak == 'Y') { $speak = 'Y'; } else { $speak = 'N'; }
		if($first_lang == 'Y') { $first_lang = 'Y'; } else { $first_lang = 'N'; }

		$insertdata = array(
			'client_id'=> $client_id,
			'language'=> $language,
			'prof_read'=>$read,
			'prof_write'=>$write,
			'prof_speak'=>$speak,
			'first_language'=> $first_lang
		);

		$this->db->insert('applicant_languages', $insertdata);

		echo 'Success';

	}

	//+++++++++++++++++++++++++++++++++
	//DELETE LANGUAGE
	//+++++++++++++++++++++++++++++++++
	function delete_language($id){

		$this->db->where('app_language_id' , $id);
		$this->db->delete('applicant_languages');
	}


	//++++++++++++++++++++++++++
	//GET LANGUAGE List
	//++++++++++++++++++++++++++
	public function get_language_list()
	{

		$query = $this->db->query("SELECT * FROM languages", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->language.'">'.$row->language.'</option>';

			}

		}

	}



	//++++++++++++++++++++++++++
	//GET REFERENCES
	//++++++++++++++++++++++++++
	public function get_references()
	{


		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM applicant_references WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				echo '<tr id="row-'.$row->reference_id.'">
					<td>'.$row->first_name.' '.$row->last_name.'</td>
					<td>'.$row->organisation.'</td>
					<td>'.$row->tel.'</td>
					<td>'.$row->email.'</td>
					<td><button class="btn btn-xs btn-danger pull-right remove-itm" value="'.$row->reference_id.'"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span></button></td>
				</tr>
				';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//ADD REFERENCE
	//++++++++++++++++++++++++++
	function add_reference() {

		$client_id = $this->session->userdata('id');

		$fname = $this->input->post('fname', TRUE);
		$lname = $this->input->post('lname', TRUE);
		$organisation = $this->input->post('organisation', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$email = $this->input->post('email', TRUE);
		//$permission = $this->input->post('permission', TRUE);

		//if($permissi == 'Y') { $read = 'Y'; } else { $read = 'N'; }


		$insertdata = array(
			'client_id'=> $client_id,
			'first_name'=> $fname,
			'last_name'=>$lname,
			'organisation'=>$organisation,
			'tel'=>$tel,
			'email'=>$email
		);

		$this->db->insert('applicant_references', $insertdata);

		echo 'Success';

	}

	//+++++++++++++++++++++++++++++++++
	//DELETE REFERENCE
	//+++++++++++++++++++++++++++++++++
	function delete_reference($id){

		$this->db->where('reference_id' , $id);
		$this->db->delete('applicant_references');

	}


	//+++++++++++++++++++++++++++
	//GET MY VACANCIES
	//++++++++++++++++++++++++++
	public function get_applications()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT * FROM vacancy_applicants AS A, vacancies AS B WHERE A.client_id = '".$client_id."' AND A.vacancy_id = B.vacancy_id AND B.start_date < NOW() AND B.end_date >= NOW() AND B.status = 'live' ORDER BY B.listing_date DESC", FALSE);


		if($query->result()){


			foreach($query->result() as $row){

				echo '<tr>
				<td><a href="">'.$row->title.'</td>
				<td><a href="">'.date('d-m-Y', strtotime($row->listing_date)).'</td>
				<td><span class="label label-warning"><span class="glyphicon glyphicon-time" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Application pending for review"></span></span></a></li></td></tr>';

			}


		}else{

			echo '<div class="alert">
			 		<h3>No Vacancies listed </h3>
				   </div>';

		}
	}


	//+++++++++++++++++++++++++++
	//GET LEISURE
	//++++++++++++++++++++++++++
	public function get_leisure()
	{

		$client_id = $this->session->userdata('id');

		$query = $this->db->query("SELECT leisure FROM applicant_bio WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			return $query->row_array();

		}
	}


	function update_leisure() {

		$client_id = $this->session->userdata('id');
		$leisure = $this->input->post('leisure', TRUE);

		$insertdata = array(
			'leisure'=> $leisure
		);

		$this->db->where('client_id', $client_id);
		$this->db->update('applicant_bio', $insertdata);

	}


	//++++++++++++++++++++++++++
	//GET COUNTRY SELECT
	//++++++++++++++++++++++++++
	public function get_country_select($country="")
	{


		$query = $this->db->query("SELECT * FROM a_country", FALSE);


		if($query->result()){

			foreach($query->result() as $row){

				if($country == "") {
					if($row->COUNTRY_NAME == 'Namibia') { $selected = 'selected'; } else { $selected = '';}
				} else {
					if($row->ID == $country) { $selected = 'selected'; } else { $selected = '';}
				}

				echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->COUNTRY_NAME.'</option>';

			}

		}

	}

	//++++++++++++++++++++++++++
	//GET REGIONS SELECT
	//++++++++++++++++++++++++++
	public function get_region_select($region="")
	{

		$query = $this->db->query("SELECT ID, REGION_NAME FROM a_map_region", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->ID == $region) { $selected = 'selected'; } else { $selected = '';}

				echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->REGION_NAME.'</option>';

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET CITY SELECT
	//++++++++++++++++++++++++++
	public function get_city_select($city="")
	{


		$query = $this->db->query("SELECT ID, MAP_LOCATION FROM a_map_location", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->ID == $city) { $selected = 'selected'; } else { $selected = '';}

				echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->MAP_LOCATION.'</option>';

			}

		}

	}





	//+++++++++++++++++++++++++++
	//ID DOCUMENT MANAGER
	//++++++++++++++++++++++++++
	public function get_avatar() {


		$id = $this->session->userdata('id');

		$query = $this->db->query("SELECT CLIENT_PROFILE_PICTURE_NAME FROM u_client WHERE ID = '".$id."'", FALSE);

		$row = $query->row();

		if($row->CLIENT_PROFILE_PICTURE_NAME != ""){

			$str = "$('#feat_avatar_pic').html('');";

			echo '<div id="feat_avatar_pic"><img src="'.base_url('/').'assets/users/photos/'.$row->CLIENT_PROFILE_PICTURE_NAME.'" class="thumbnail img-responsive"></div>';

			$str = "$('#userfile4').click(); $('#avatarbut').removeClass('disabled');";
			echo '<div id="add_avatar_pic">
					 <form action="'. site_url('/').'vacancy/add_avatar_pic/" method="post" accept-charset="utf-8" id="add-avatar-pic" name="add-avatar-pic" enctype="multipart/form-data">
						<fieldset>
						<input type="file" class="" id="userfile4" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'. $id.'">

						<div id="avatar_msg4"></div>
						<div class="progress" id="procover4" style="display:none;margin-top:20px">
						  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						  </div>
						</div>

						<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default">Browse</a>
						<button type="submit" class="btn btn-primary" id="avatarbut">Upload</button>
						</fieldset>
					  </form>
					  </div>

				  ';

		}else{

			$str = "$('#userfile4').click();$('#avatarbut').removeClass('disabled');";
			echo '<div id="feat_avatar_pic"><img src="'.base_url('/').'graphics/avatar_placeholder.png" style="width:150px;" class="thumbnail"></div>
				<div id="add_id_doc">
				 <form action="'. site_url('/').'vacancy/add_avatar_pic/" method="post" accept-charset="utf-8" id="add-avatar-pic" name="add-avatar-pic" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile4" style="display:none" name="userfile">
					<input type="hidden" name="id" value="'. $id.'">
					<div id="avatar_msg4"></div>

					<div class="progress" id="procover4" style="display:none;margin-top:20px">
					  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					  </div>
					</div>

					<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default">Browse</a>
					<button type="submit" class="btn btn-primary disabled" id="avatarbut">Upload</button>
					</fieldset>
				  </form>
				  </div>';


		}

		echo ' <script type="text/javascript">

				  </script>';
	}



	//+++++++++++++++++++++++++++
	//CV DOCUMENT MANAGER
	//++++++++++++++++++++++++++
	public function get_cv_document() {

		$id = $this->session->userdata('id');

		$query = $this->db->query("SELECT cv FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

		$row = $query->row();

		if($row->cv != ""){

			$str = "$('#feat_doc').html('');";

			echo '<div id="feat_doc"><pre>'.$row->cv.' <a href="javascript:void(0);" onclick="remove_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre></div>';

			$str = "$('#userfile1').click(); $('#docbut').removeClass('disabled');";
			echo '<div id="add_doc" style="display:none">
					 <form action="'. site_url('/').'vacancy/add_cv_document/" method="post" accept-charset="utf-8" id="add-doc" name="add-doc" enctype="multipart/form-data">
						<fieldset>
						<input type="file" class="" id="userfile1" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'. $id.'">

						<div id="avatar_msg2"></div>
					<div class="progress" id="procover2" style="display:none;margin-top:20px">
					  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:0%;">
					  </div>
					</div>

						<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default"><span class=" glyphicon-search" aria-hidden="true"></span></a>
						<button type="submit" class="btn btn-primary" id="docbut">Add CV Document</button>
						</fieldset>
					  </form>
					  </div>

				  ';

		}else{

			$str = "$('#userfile1').click();$('#docbut').removeClass('disabled');";
			echo '<div id="feat_doc"><div class="alert alert-danger alert-dismissible fade in">No CV document selected</div></div>
				<div id="add_doc">
				 <form action="'. site_url('/').'vacancy/add_cv_document/" method="post" accept-charset="utf-8" id="add-doc" name="add-doc" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile1" style="display:none" name="userfile">
					<input type="hidden" name="id" value="'. $id.'">
					<div id="avatar_msg2"></div>

					<div class="progress" id="procover2" style="display:none;margin-top:20px">
					  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					  </div>
					</div>

					<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
					<button type="submit" class="btn btn-primary disabled" id="docbut">Add CV Document</button>
					</fieldset>
				  </form>
				  </div>';


		}

		echo ' <script type="text/javascript">
				  	function remove_doc(id){
						$("#add_doc").fadeIn();
				  		$("#feat_doc").empty();

						$.ajax({
							type: "get",

							url: "'. site_url('/').'vacancy/remove_cv_document/"+id ,
							success: function (data) {


							}
						});

					}
				  </script>';
		}




	//+++++++++++++++++++++++++++
	//ID DOCUMENT MANAGER
	//++++++++++++++++++++++++++
	public function get_id_document() {

		$id = $this->session->userdata('id');

		$query = $this->db->query("SELECT id_doc FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

		$row = $query->row();

		if($row->id_doc != ""){

			$str = "$('#feat_id_doc').html('');";

			echo '<div id="feat_id_doc"><pre>'.$row->id_doc.' <a href="javascript:void(0);" onclick="remove_id_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre></div>';

			$str = "$('#userfile2').click(); $('#iddocbut').removeClass('disabled');";
			echo '<div id="add_id_doc" style="display:none">
					 <form action="'. site_url('/').'vacancy/add_id_document/" method="post" accept-charset="utf-8" id="add-id-doc" name="add-id-doc" enctype="multipart/form-data">
						<fieldset>
						<input type="file" class="" id="userfile2" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'. $id.'">

						<div id="avatar_msg3"></div>
					<div class="progress" id="procover3" style="display:none;margin-top:20px">
					  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					  </div>
					</div>

						<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
						<button type="submit" class="btn btn-primary" id="iddocbut">Add ID Document</button>
						</fieldset>
					  </form>
					  </div>

				  ';

		}else{

			$str = "$('#userfile2').click();$('#iddocbut').removeClass('disabled');";
			echo '<div id="feat_id_doc"><div class="alert alert-danger alert-dismissible fade in">No ID document selected</div></div>
				<div id="add_id_doc">
				 <form action="'. site_url('/').'vacancy/add_id_document/" method="post" accept-charset="utf-8" id="add-id-doc" name="add-id-doc" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile2" style="display:none" name="userfile">
					<input type="hidden" name="id" value="'. $id.'">
					<div id="avatar_msg3"></div>

					<div class="progress" id="procover3" style="display:none;margin-top:20px">
					  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					  </div>
					</div>

					<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
					<button type="submit" class="btn btn-primary disabled" id="iddocbut">Add ID Document</button>
					</fieldset>
				  </form>
				  </div>';


		}

		echo ' <script type="text/javascript">
				  	function remove_id_doc(id){
						$("#add_id_doc").fadeIn();
				  		$("#feat_id_doc").empty();

						$.ajax({
							type: "get",

							url: "'. site_url('/').'vacancy/remove_id_document/"+id ,
							success: function (data) {


							}
						});

					}
				  </script>';
	}



	//+++++++++++++++++++++++++++
	//LICENSE DOCUMENT MANAGER
	//++++++++++++++++++++++++++
	public function get_license_document() {


		$id = $this->session->userdata('id');

		$query = $this->db->query("SELECT license_doc FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

		$row = $query->row();

		if($row->license_doc != ""){

			$str = "$('#feat_license_doc').html('');";

			echo '<div id="feat_license_doc"><pre>'.$row->license_doc.' <a href="javascript:void(0);" onclick="remove_license_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre></div>';

			$str = "$('#userfile6').click(); $('#licensedocbut').removeClass('disabled');";
			echo '<div id="add_license_doc" style="display:none">
					 <form action="'. site_url('/').'vacancy/add_license_document/" method="post" accept-charset="utf-8" id="add-license-doc" name="add-license-doc" enctype="multipart/form-data">
						<fieldset>
						<input type="file" class="" id="userfile6" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'. $id.'">

						<div id="avatar_msg6"></div>

						<div class="progress" id="procover6" style="display:none;margin-top:20px">
						  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
						  </div>
						</div>

						<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
						<button type="submit" class="btn btn-primary" id="licensedocbut">Add License Document</button>
						</fieldset>
					  </form>
					  </div>

				  ';

		}else{

			$str = "$('#userfile6').click();$('#licensedocbut').removeClass('disabled');";
			echo '<div id="feat_license_doc"><div class="alert alert-danger alert-dismissible fade in">No License document selected</div></div>
				<div id="add_license_doc">
				 <form action="'. site_url('/').'vacancy/add_license_document/" method="post" accept-charset="utf-8" id="add-license-doc" name="add-license-doc" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile6" style="display:none" name="userfile">
					<input type="hidden" name="id" value="'. $id.'">
					<div id="avatar_msg6"></div>

					<div class="progress" id="procover6" style="display:none;margin-top:20px">
					  <div class="progress-bar" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
					  </div>
					</div>

					<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
					<button type="submit" class="btn btn-primary disabled" id="licensedocbut">Add License Document</button>
					</fieldset>
				  </form>
				  </div>';


		}

		echo ' <script type="text/javascript">
				  	function remove_license_doc(id){
						$("#add_license_doc").fadeIn();
				  		$("#feat_license_doc").empty();

						$.ajax({
							type: "get",

							url: "'. site_url('/').'vacancy/remove_license_document/"+id ,
							success: function (data) {

							}
						});

					}
				  </script>';
	}




	function validate_password($username, $password){

			$this->db->where('email', $username);
			$this->db->limit('1');
			$sql = $this->db->get('vacancy_client_tokens');

			$res = array();
			//SEE IF ROW EVEN EXISTS
			if ($sql->num_rows() > 0) {

				$r = $sql->row_array();

				// The first 64 characters of the hash is the salt
				$salt = substr($r['pass'], 0, 64);

				$hash = $salt . $password;

				// Hash the password as we did before
				for ($i = 0; $i < 100000; $i++) {
					$hash = hash('sha256', $hash);
				}

				$hash = $salt . $hash;

				if ($hash == $r['pass']) {

					$res['bool'] = TRUE;
					//break;
				} else {

					$res['bool'] = FALSE;

				}
			} else {//no username match

				$res['bool'] = FALSE;
			}

			return $res;


	}


	function add_masterfiles()
	{

		$http_origin = $_SERVER['HTTP_ORIGIN'];

		if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
		{
			$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
		}

		$this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST") {


			$this->load->library('upload');  // NOTE: always load the library outside the loop

			$bus_id = $this->input->post('bus_id');
			$directory = $this->input->post('directory');


			$img_allowed =  array('gif' , 'GIF' , 'png' , 'PNG' , 'jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'tiff' , 'TIFF' , 'bmp' , 'BMP' );
			$doc_allowed =  array('doc' , 'DOC' , 'docx' , 'DOCX' , 'pdf' , 'PDF' , 'xls' , 'XLS' , 'xlsx' , 'XLXS' , 'csv' , 'CSV' );


			if(isset($_FILES['file']['name'])){

				$this->total_count_of_files = count($_FILES['file']['name']);
				/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */


				$_FILES['userfile']['name']    = $_FILES['file']['name'];
				$_FILES['userfile']['type']    = $_FILES['file']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				$_FILES['userfile']['error']       = $_FILES['file']['error'];
				$_FILES['userfile']['size']    = $_FILES['file']['size'];

				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);

				//Chech if document
				if(in_array($ext,$doc_allowed) ) {
					$dest_folder = "vacancies/documents/masterfiles";
					$type = "document";
				}

				//Chech if image
				if(in_array($ext,$img_allowed) ) {
					$dest_folder = "images/";
					$type = "image";
				}


				$config['upload_path'] = BASE_URL . 'assets/vacancies/documents/masterfiles/';
				$config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF|tiff|TIFF|bmp|BMP|doc|DOC|docx|DOCX|pdf|PDF|xls|XLS|xlsx|XLSX|csv|CSV';
				$config['overwrite']     = FALSE;
				/*
				$config['max_size']	= '0';
				$config['max_width']  = '8324';
				$config['max_height']  = '8550';
				$config['min_width']  = '200';
				$config['min_height']  = '200';
				*/

				$config['remove_spaces']  = TRUE;
				$config['encrypt_name']  = TRUE;

				$this->upload->initialize($config);

				if($this->upload->do_upload())
				{
					$data = array('upload_data' => $this->upload->data());
					$file =  $this->upload->file_name;
					$size =  $this->upload->file_size;
					$oname =  $this->upload->orig_name;
					//$width = $this->upload->image_width;
					//$height = $this->upload->image_height;

					//populate array with values
					$data = array(
						'bus_id' => $bus_id,
						'title'=>$oname,
						'masterfile' =>$file,
						'size' => $size
					);

					//insert into database
					$this->db->insert('masterfiles',$data);
					$id = $this->db->insert_id();

					$data2 = array(
						'bus_id' => $bus_id,
						'master_id'=>$id,
						'dir_id' =>$directory
					);

					//insert into database
					$this->db->insert('master_dir_int',$data2);


				}else{
					//ERROR
					$val = FALSE;
					$data['error'] =  $this->upload->display_errors();

					echo $this->upload->display_errors();;

				}

				//redirect
				if($val == TRUE){

					//SUCESSS MESSAGE SCRIPT COMES HERE!!!!

				}else{

					//ERROR MESSAGE SCRIPT COMES HERE!!!!

				}

			}
		}
	}



	function add_vacancy_docs()
	{
		
        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }

        $this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {		


			$this->load->library('upload');  // NOTE: always load the library outside the loop
	
			$bus_id = $this->input->post('bus_id');
			$vacancy_id = $this->input->post('vacancy_id');
	
			$level = $this->input->post('level');
	
			$img_allowed =  array('gif' , 'GIF' , 'png' , 'PNG' , 'jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'tiff' , 'TIFF' , 'bmp' , 'BMP' );
			$doc_allowed =  array('doc' , 'DOC' , 'docx' , 'DOCX' , 'pdf' , 'PDF' , 'xls' , 'XLS' , 'xlsx' , 'XLXS' , 'csv' , 'CSV' );
	
	
			if(isset($_FILES['file']['name'])){
	
				$this->total_count_of_files = count($_FILES['file']['name']);
				/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
	
				$_FILES['userfile']['name']    = $_FILES['file']['name'];
				$_FILES['userfile']['type']    = $_FILES['file']['type'];
				$_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				$_FILES['userfile']['error']       = $_FILES['file']['error'];
				$_FILES['userfile']['size']    = $_FILES['file']['size'];
	
				$filename = $_FILES['file']['name'];
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
	
				//Check if document
				if(in_array($ext,$doc_allowed) ) {
					$dest_folder = "documents";
					$type = "document";
				}
	
				//Check if image
				if(in_array($ext,$img_allowed) ) {
					$dest_folder = "images/";
					$type = "image";
				}
	
				
				$config['upload_path'] = BASE_URL . 'assets/vacancies/'.$dest_folder;
				$config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF|tiff|TIFF|bmp|BMP|doc|DOC|docx|DOCX|pdf|PDF|xls|XLS|xlsx|XLSX|csv|CSV';
				$config['overwrite']     = FALSE;
				/*
				$config['max_size']	= '0';
				$config['max_width']  = '8324';
				$config['max_height']  = '8550';
				$config['min_width']  = '200';
				$config['min_height']  = '200';
				*/
	
				$config['remove_spaces']  = TRUE;
				$config['encrypt_name']  = TRUE;
	
				$this->upload->initialize($config);

	
				if($this->upload->do_upload())
				{

					$data = array('upload_data' => $this->upload->data());
					$file =  $this->upload->file_name;
					$oname =  $this->upload->orig_name;
					$width = $this->upload->image_width;
					$height = $this->upload->image_height;
					
					$filename = BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$file;
					$size = filesize($filename);	
					$size = $this->FileSizeConvert($size);				
	
					//populate array with values
					$data = array(
						'bus_id' => $bus_id,
						'vacancy_id' => $vacancy_id,
						'level' => $level,
						'type' => $type,
						'title'=>$oname,
						'doc_file' =>$file,
						'doc_size' =>$size
					);
	
					//insert into database
					$this->db->insert('vacancy_documents',$data);
	
					//crop
					$data['filename'] = $file;
					//$data['width'] = $this->upload->image_width;
					//$data['height'] = $this->upload->image_height;
					$val = TRUE;
					
					//SEND TO BUCKET
					//You need to set only the path, and name, no absolute path!!!
					//check if exists, then send it to s3
					$this->load->model('cron_model');
					//UPLOAD S3
					if(file_exists(BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$file)){
						
						$data['out'] = $this->cron_model->upload_s3('assets/vacancies/'.$dest_folder.'/'.$file);
					}else{
						
						$data['out'] = 'Not Uploaded';
						
					}
	
	
				}else{
					//ERROR
					$val = FALSE;
					$data['error'] =  $this->upload->display_errors();
	
					echo $this->upload->display_errors();;
	
					echo '<br>'.BASE_URL . 'assets/vacancies/'.$dest_folder;
	
				}
	
				//redirect
				if($val == TRUE){
	
					//SUCESSS MESSAGE SCRIPT COMES HERE!!!!
	
				}else{
	
					//ERROR MESSAGE SCRIPT COMES HERE!!!!
	
				}
				
			}
		}
	}
	
	//+++++++++++++++++++++++++++
	//DELETE VACANCY DOCUMENT DO
	//++++++++++++++++++++++++++
	function delete_vacancy_document_do($did) {
		
        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }

        $this->output->set_header( "Access-Control-Allow-Methods: GET, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {			

			$query = $this->db->query("SELECT type, doc_file FROM vacancy_documents WHERE doc_id = '".$did."'", FALSE);
	
			$row = $query->row();
	
			//Get File Size
			switch($row->type) {
				case 'document':
					$dest_folder = 'documents';
					break;
				case 'image':
					$dest_folder = 'images';
					break;
			}
	
			$doc_file =  BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$row->doc_file; # build the full path
			if (file_exists($doc_file)) {
				unlink($doc_file);
			}
	
	
			//delete from database
			$this->db->where('doc_id', $did);
			$this->db->delete('vacancy_documents');
			
		}

	}	
	
	//+++++++++++++++++++++++++++
	//DOWNLOAD MULTI VACANCY
	//++++++++++++++++++++++++++
	public function action_vacancy_docs_bulk() {
		
		
        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }

        $this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {			

			$this->load->library('zip');
	
			$bus_id = $this->input->post('bus_id');
			$level = $this->input->post('level');
	
			$doc_files = $this->input->post('doc_files');
	
			$type = $this->input->post('bulk');
			$title = $this->input->post('title');
			$title = str_replace(' ','_',$title);
	
			if(!empty($doc_files)) {
	
				//Remove bulk entries
				if($type == 1) {
	
					foreach($doc_files as $did) {
	
						$query = $this->db->query("SELECT * FROM vacancy_documents WHERE doc_id = '".$did."' AND bus_id = '".$bus_id."'", FALSE);
	
						$row = $query->row();
	
						switch($row->type) {
							case 'document':
								$dest_folder = 'documents/vacancies';
								break;
							case 'image':
								$dest_folder = 'images';
								break;
						}
	
						$doc_file =  BASE_URL.'assets/vacancies/'.$dest_folder.'/' . $row->doc_file; # build the full path
	
						if (file_exists($doc_file)) {
							unlink($doc_file);
						}
	
	
						$this->db->where('doc_id', $did);
						$this->db->delete('vacancy_documents');
	
	
					}
	
				}
	
				if($type == 2) {
	
					$date = date('Y-m-d H:i:s');
					$zip_file = $title.'_'.$date;
	
					//$this->zip->add_dir(NA_BASE_URL.'assets/vacancies/zip/my_backup');
	
					foreach($doc_files as $did) {
	
						$query = $this->db->query("SELECT * FROM vacancy_documents WHERE doc_id = '".$did."' AND bus_id = '".$bus_id."'", FALSE);
	
						if($query->result()){
	
							$row = $query->row();
	
								switch($row->type) {
									case 'document':
										$dest_folder = 'documents/vacancies';
										break;
									case 'image':
										$dest_folder = 'images';
										break;
								}
	
	
								$file = BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$row->doc_file; # build the full path
	
	
								$this->zip->read_file($file);
	
	
						} //end result
					} // end for each
	
					//$this->zip->read_file($file);
	
					$this->zip->download($zip_file);
	
				}

			}

		} // end if empty
	} // end function	
	
	
	//+++++++++++++++++++++++++++
	//ADD VACANCY IMAGE
	//++++++++++++++++++++++++++

	function add_vacancy_image()
	{
		
        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }

        $this->output->set_header( "Access-Control-Allow-Methods: POST, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {			

			$bus_id = $this->input->post('bus_id');
	
			$img = $this->input->post('userfile', TRUE);
			$id = $this->input->post('id', TRUE);
	
			//upload file
			$config['upload_path'] = BASE_URL .'assets/vacancies/images/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '12000';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			//$config['file_name']  = trim(substr($img, 0, 80));
	
			$this->load->library('upload', $config);
	
			if ( ! $this->upload->do_upload())
			{
	
				$data['error'] =  $this->upload->display_errors();
	
	
			}
			else
			{
				//LOAD library
				$this->load->library('image_lib');
	
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
				$width = $this->upload->image_width;
				$height = $this->upload->image_height;
	
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));
	
				if (($width > 1950) || ($height > 900)){
	
					$this->load->model('image_model');
					$this->image_model->downsize_image($file, '1800', '1000');
	
				}

				//SEND TO BUCKET
				//You need to set only the path, and name, no absolute path!!!
				//check if exists, then send it to s3
				$this->load->model('cron_model');
				//UPLOAD S3
				if(file_exists(BASE_URL.'assets/vacancies/images/'.$file)){

					$data['out'] = $this->cron_model->upload_s3('assets/vacancies/images/'.$file);
				}else{

					$data['out'] = 'Not Uploaded';

				}

	
				//populate array with values
				$data = array(
					'image'=> $file,
				);

				//insert into database
				$this->db->where('vacancy_id', $id);
				$this->db->update('vacancies',$data);
	
				$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
				$image = S3_URL . 'assets/vacancies/images/'.$file;
				//redirect
				$data['basicmsg'] = 'Image added successfully!';
	
				$str = '<div id="feat_img"><div><img src="'.$image.'" class="superbox-img" style="width:500px" /><p style="padding:10px 10px 0px 0px;"><a href="javascript:void(0);" onclick="remove_img('.$id.')"><span class="btn btn-labeled btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a></p></div></div>';
	
				echo "<script>
	
				  $('#feat_img').html('".$str."');
				  $('#add_img').fadeOut();
				  </script>";
	
	
	
			}
		}
	}	
	
	
	public function remove_vacancy_image($id)
	{

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }

        $this->output->set_header( "Access-Control-Allow-Methods: GET, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: accept, cache-control, content-type, x-requested-with' );


        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {	

			$query = $this->db->select('image');
			$query = $this->db->where('vacancy_id', $id);
			$query = $this->db->get('vacancies');
	
			if($query->result()){
	
				$row = $query->row_array();
	
				$file =  BASE_URL.'assets/vacancies/images/' . $row['image']; # build the full path
	
				if (file_exists($file)) {
					unlink($file);
				}
	
				$this->db->set('image' , '');
				$this->db->where('vacancy_id' , $id);
				$this->db->update('vacancies');

			}

		}
	}	
	
	
	
	
	//+++++++++++++++++++++++++++
	//DOWNLOAD VACANCY DOCUMENT
	//++++++++++++++++++++++++++
	public function download_vacancy_document($did) {

		$http_origin = $_SERVER['HTTP_ORIGIN'];

		// if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
		//{
		$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
		//}

		//$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

		}elseif($_SERVER['REQUEST_METHOD'] == "GET") {


			$this->load->helper('download');

			$query = $this->db->query("SELECT * FROM vacancy_documents WHERE doc_id = '" . $did . "'", FALSE);

			$row = $query->row();

			switch ($row->type) {
				case 'document':
					$dest_folder = 'documents/vacancies';
					break;
				case 'image':
					$dest_folder = 'images';
					break;
			}

			$name = $row->title;
			$file = BASE_URL . 'assets/vacancies/' . $dest_folder . '/' . $row->doc_file; # build the full path
			$data = file_get_contents($file);

			force_download($name, $data);

		}

	} // end function


	//+++++++++++++++++++++++++++
	//DOWNLOAD VACANCY DOCUMENT
	//++++++++++++++++++++++++++
	public function download_applicant_document($did) {


		$http_origin = $_SERVER['HTTP_ORIGIN'];

		// if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
		//{
		$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
		//}

		//$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

		}elseif($_SERVER['REQUEST_METHOD'] == "GET") {

			$this->load->helper('download');

			$query = $this->db->query("SELECT * FROM applicant_documents WHERE app_doc_id = '" . $did . "'", FALSE);

			$row = $query->row();

			switch ($row->type) {
				case 'document':
					$dest_folder = 'documents';
					break;
				case 'image':
					$dest_folder = 'images';
					break;
			}

			$name = $row->title;
			$file = S3_URL . 'assets/vacancies/documents/' . $row->doc_file; # build the full path
			$data = file_get_contents($file);

			force_download($name, $data);

		}

	} // end function



	//+++++++++++++++++++++++++++
	//FILE SIZE CONVERT
	//+++++++++++++++++++++++++++

	function FileSizeConvert($bytes)
	{
		$bytes = floatval($bytes);
		$arBytes = array(
			0 => array(
				"UNIT" => "TB",
				"VALUE" => pow(1024, 4)
			),
			1 => array(
				"UNIT" => "GB",
				"VALUE" => pow(1024, 3)
			),
			2 => array(
				"UNIT" => "MB",
				"VALUE" => pow(1024, 2)
			),
			3 => array(
				"UNIT" => "KB",
				"VALUE" => 1024
			),
			4 => array(
				"UNIT" => "B",
				"VALUE" => 1
			),
		);

		foreach($arBytes as $arItem)
		{
			if($bytes >= $arItem["VALUE"])
			{
				$result = $bytes / $arItem["VALUE"];
				$result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
				break;
			}
		}
		return $result;
	}	


	//++++++++++++++++++++++++++
	//GET COUNTRY
	//++++++++++++++++++++++++++
	public function get_country($country)
	{


		$query = $this->db->query("SELECT COUNTRY_NAME FROM a_country WHERE ID = '".$country."'", FALSE);


		if($query->result()){

			$row = $query->row();

			return $row->COUNTRY_NAME;

		}

	}

	//++++++++++++++++++++++++++
	//GET REGION
	//++++++++++++++++++++++++++
	public function get_region($region)
	{

		$query = $this->db->query("SELECT REGION_NAME FROM a_map_region WHERE ID = '".$region."'", FALSE);

		if($query->result()){

			$row = $query->row();

			return $row->REGION_NAME;

		}

	}


	//++++++++++++++++++++++++++
	//GET CITY
	//++++++++++++++++++++++++++
	public function get_city($city)
	{


		$query = $this->db->query("SELECT MAP_LOCATION FROM a_map_location WHERE ID = '".$city."'", FALSE);

		if($query->result()){

			$row = $query->row();

			return $row->MAP_LOCATION;

		}

	}




	//+++++++++++++++++++++++++++
	//GET APPLICANT AVATAR
	//++++++++++++++++++++++++++

	function get_applicant_avatar($id){


		$query = $this->db->query("SELECT CLIENT_PROFILE_PICTURE_NAME FROM u_client WHERE ID = '".$id."'", FALSE);

		if($query->result()){

			$row = $query->row();

			if($row->CLIENT_PROFILE_PICTURE_NAME != "") {

				return '';

			} else {

				return '';

			}

		}

	}



	//++++++++++++++++++++++++++
	//GET EMPLOYMENTS DUMP
	//++++++++++++++++++++++++++
	public function get_employments_dump($client_id)
	{


		$str = '';

		$query = $this->db->query("SELECT * FROM applicant_employment WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				$str.= '
		  			<strong>Company: </strong>'.$row->company.'<br>
					<strong>Posotion: </strong>'.$row->position.'<br>
					<strong>Business Type: </strong>'.$row->business_type.'<br>
					<strong>Job Level: </strong>'.$row->level.'<br>
					<strong>Job Type: </strong>'.$row->type.'<br>
					<strong>Salary Type: </strong>'.$row->salary_type.'<br>
					<strong>Salary: </strong>'.$row->salary.'<br>
					<strong>Frequency: </strong>'.$row->frequency.'<br>
					<strong>Benefits: </strong>'.$row->benefits.'<br>
					<strong>Duration: </strong>'.$date_from.' - '.$date_to.'<br><br>
				';

			}

		} else {

			$str = 'No Employment History available';

		}

		return $str;

	}


	//++++++++++++++++++++++++++
	//GET ACHIEVEMENTS DUMP
	//++++++++++++++++++++++++++
	public function get_achievements_dump($client_id)
	{


		$query = $this->db->query("SELECT * FROM applicant_achievements WHERE client_id = '".$client_id."'", FALSE);

		$str = '';

		if($query->result()){

			foreach($query->result() as $row){

				if($row->receive_date != '0000-00-00') { $receive= date('d.m.Y', strtotime($row->receive_date)); } else { $receive = ''; }

				$str.= '<tr>
					<td style="width:200px">'.$row->achievement.'</td>
					<td style="width:200px">'.$row->organisation.'</td>
					<td style="width:200px">'.$receive.'</td>
					</tr>
				';

			}

		} else {

			$str = 'No Achievements available';

		}

		return $str;

	}


	//+++++++++++++++++++++++++++
	//GET APP CATEGORIES
	//++++++++++++++++++++++++++
	public function get_app_categories_dump($client_id)
	{

		$query = $this->db->query("SELECT * FROM applicant_categories WHERE client_id = '".$client_id."'", FALSE);


		if($query->result()){

			$str = '<table class="table table-striped">';

			foreach($query->result() as $row){

				$str.=
					'<tr><td>';

				if($row->sub_cat != '0') { $str.=  $row->sub_cat; }
				if($row->sub_sub_cat != '0') { $str.=  ' / '.$row->sub_sub_cat; }
				if($row->sub_sub_sub_cat != '0') { $str.=  ' / '.$row->sub_sub_sub_cat; }

				$str.=
					'</td><td> ('.$row->experience.' Experience)</td></tr>';

			}

			$str.=  '</table>';

		}else{

			$str.=  '<div class="alert alert-danger alert-dismissible fade in">No Experience Categories added</div>';

		}

		return $str;
	}


	//+++++++++++++++++++++++++++
	//GET DISCIPLINES
	//++++++++++++++++++++++++++
	public function get_app_disciplines_dump($client_id, $bus_id)
	{


		$query = $this->db->query("SELECT * FROM applicant_disciplines AS A
	  						JOIN vacancy_disciplines AS B on A.discipline_id = B.discipline_id
							WHERE A.client_id = '".$client_id."' AND A.bus_id = '".$bus_id."'", FALSE);

		if($query->result()){
			foreach($query->result() as $row){
				$str =  '<span style="margin-right:5px;margin-bottom:5px;padding:5px;" class="label label-primary pull-left">'.$row->discipline.' ('.$row->experience.' Experience)</span>';
			}
		} else {
			$str = 'No Disciplines available';
		}

		return $str;

	}


	//+++++++++++++++++++++++++++
	//GET SKILLS
	//++++++++++++++++++++++++++
	public function get_app_skills_dump($client_id)
	{


		$this->db->where('client_id', $client_id);
		$query = $this->db->get('applicant_skills');

		if($query->result()){
			foreach($query->result() as $row){
				$str = '<span style="margin-right:5px;margin-bottom:5px;padding:5px;" class="label label-primary pull-left">'.$row->skill.'</span>';
			}
		} else {
			$str = 'No skills available';
		}

		return $str;
	}






	//++++++++++++++++++++++++++
	//GET EDUCATION DUMP
	//++++++++++++++++++++++++++
	public function get_education_dump($type, $client_id)
	{


		$str = '';

		$query = $this->db->query("SELECT * FROM applicant_education WHERE client_id = '".$client_id."' AND type = '".$type."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				if($type == 'secondary') {

					$str = '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						</tr>
						';

				}

				if($type == 'tertiary') {

					$str = '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						</tr>
					';

				}

				if($type == 'course') {

					$str = '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->institution.'</td>
						</tr>
					';

				}

				return $str;

			}

		}

	}





	//+++++++++++++++++++++++++++
    //ADD CV DOCUMENT
    //++++++++++++++++++++++++++

    function add_cv_document()
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        //if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107" )
        //{
            $this->output->set_header("Access-Control-Allow-Origin: *");
        //}

		


        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {


			$doc = $this->input->post('userfile', TRUE);
			$name = $this->input->post('name', TRUE);
			$id = $this->input->post('id', TRUE);

			//upload file
			$config['upload_path'] = BASE_URL . 'assets/vacancies/documents/';
			$config['allowed_types'] = 'pdf|doc|docx';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['file_name']  = strtolower(str_replace(' ', '_', $name).'_cv_'.date("dmY"));
			//$config['file_name']  = 'cv_'.date("dmY");
			//$config['encrypt_name']  = TRUE;
			//$config['file_name']  = trim(substr($img, 0, 80));
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{

					$data['error'] =  $this->upload->display_errors();

					  
					
			}	
			else
			{	

				//$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
	
				
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				
					
				 //populate array with values
				  $data_doc = array( 
					'cv'=> $file,
				  );


				//CHECK IF USER EXISTS IN CLIENTS
				$query2 = $this->db->query("SELECT * FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

				if($query2->result()) {

					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio',$data_doc);

				} else {

					$this->db->insert('applicant_bio',$data_doc);

				}

				//SEND TO BUCKET
				//You need to set only the path, and name, no absolute path!!!
				//check if exists, then send it to s3
				$this->load->model('cron_model');
				//UPLOAD S3
				if(file_exists(BASE_URL.'assets/vacancies/documents/'.$file)){

					$data['out'] = $this->cron_model->upload_s3('assets/vacancies/documents/'.$file);
				}else{

					$data['out'] = 'Not Uploaded';

				}


				  $data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'CV Document added successfully!';
			  	  $str = '<pre>'.$file.' <a href="javascript:void(0);" onclick="remove_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre>';
				  echo "<script>
					  $('#feat_doc').html('".$str."');
					  $('#add_doc').fadeOut();
					  </script>";			 
						 
					

		}


        }//end METHOD POST
    }


    public function remove_cv_document($id)
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

       // if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
        //{
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        //}



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {


			$query = $this->db->select('cv');
			$query = $this->db->where('client_id', $id);
			$query = $this->db->get('applicant_bio');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				$file =  BASE_URL.'assets/vacancies/documents/' . $row['cv']; # build the full path
				
				if (file_exists($file)) {
					unlink($file);
				}
				
					$this->db->set('cv' , '');
					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio');
							 
								
				
			}


        }//end GET METHOD
    }	
	
	
	
	
	
	


    //+++++++++++++++++++++++++++
    //ADD ID DOCUMENT
    //++++++++++++++++++++++++++

    function add_id_document()
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        //if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107"  || $http_origin == "http://www.cic.com.na" )
        //{
            $this->output->set_header("Access-Control-Allow-Origin: *");
        //}

		error_reporting(E_ALL);


       // $this->output->set_header("Access-Control-Allow-Origin: http://www.cic.com.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {


			$doc = $this->input->post('userfile', TRUE);
			$name = $this->input->post('name', TRUE);
			$id = $this->input->post('id', TRUE);

			//upload file
			$config['upload_path'] = BASE_URL . 'assets/vacancies/documents/';
			$config['allowed_types'] = 'pdf|doc|docx|jpg';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['file_name']  = strtolower(str_replace(' ', '_', $name).'_id_'.date("dmY"));
			//$config['file_name']  = 'cv_'.date("dmY");
			//$config['encrypt_name']  = TRUE;
			//$config['file_name']  = trim(substr($img, 0, 80));
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{

					$data['error'] =  $this->upload->display_errors();

					  
					
			}	
			else
			{	

				//$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
	
				
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				
					
				 //populate array with values
				  $data_doc = array( 
					'id_doc'=> $file,
				  );


				//CHECK IF USER EXISTS IN CLIENTS
				$query2 = $this->db->query("SELECT * FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

				if($query2->result()) {

					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio',$data_doc);

				} else {

					$this->db->insert('applicant_bio',$data_doc);

				}

				//SEND TO BUCKET
				//You need to set only the path, and name, no absolute path!!!
				//check if exists, then send it to s3
				$this->load->model('cron_model');
				//UPLOAD S3
				if(file_exists(BASE_URL.'assets/vacancies/documents/'.$file)){

					$data['out'] = $this->cron_model->upload_s3('assets/vacancies/documents/'.$file);
				}else{

					$data['out'] = 'Not Uploaded';

				}

				$data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'ID Document added successfully!';
			  	  $str = '<pre>'.$file.' <a href="javascript:void(0);" onclick="remove_id_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre>';
				  echo "<script>
					  $('#feat_id_doc').html('".$str."');
					  $('#add_id_doc').fadeOut();
					  </script>";			 
						 
					

		}


        }//end METHOD POST
    }


    public function remove_id_document($id)
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        //if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
        //{
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
       // }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {


			$query = $this->db->select('id_doc');
			$query = $this->db->where('client_id', $id);
			$query = $this->db->get('applicant_bio');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				$file =  BASE_URL.'assets/vacancies/documents/' . $row['id_doc']; # build the full path
				
				if (file_exists($file)) {
					unlink($file);
				}
				
					$this->db->set('id_doc' , '');
					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio');
							 
								
				
			}


        }//end GET METHOD
    }	



	
	
	
	
	
	
    //+++++++++++++++++++++++++++
    //ADD LICENSE DOCUMENT
    //++++++++++++++++++++++++++

    function add_license_document()
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        //if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107" )
        //{
            $this->output->set_header("Access-Control-Allow-Origin: *");
       // }

		error_reporting(E_ALL);


        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {


			$doc = $this->input->post('userfile', TRUE);
			$name = $this->input->post('name', TRUE);
			$id = $this->input->post('id', TRUE);

			//upload file
			$config['upload_path'] = BASE_URL . 'assets/vacancies/documents/';
			$config['allowed_types'] = 'pdf|doc|docx|jpg';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['file_name']  = strtolower(str_replace(' ', '_', $name).'_license_'.date("dmY"));
			//$config['file_name']  = 'cv_'.date("dmY");
			//$config['encrypt_name']  = TRUE;
			//$config['file_name']  = trim(substr($img, 0, 80));
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{

					$data['error'] =  $this->upload->display_errors();

					  
					
			}	
			else
			{	

				//$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
	
				
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				




				 //populate array with values
				  $data_doc = array( 
					'license_doc'=> $file,
				  );


				//CHECK IF USER EXISTS IN CLIENTS
				$query2 = $this->db->query("SELECT * FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

				if($query2->result()) {

					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio',$data_doc);

				} else {

					$this->db->insert('applicant_bio',$data_doc);

				}

				//SEND TO BUCKET
				//You need to set only the path, and name, no absolute path!!!
				//check if exists, then send it to s3
				$this->load->model('cron_model');
				//UPLOAD S3
				if(file_exists(BASE_URL.'assets/vacancies/documents/'.$file)){

					$data['out'] = $this->cron_model->upload_s3('assets/vacancies/documents/'.$file);
				}else{

					$data['out'] = 'Not Uploaded';

				}


				$data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'Lisence Document added successfully!';
			  	  $str = '<pre>'.$file.' <a href="javascript:void(0);" onclick="remove_license_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre>';
				  echo "<script>
					  $('#feat_license_doc').html('".$str."');
					  $('#add_license_doc').fadeOut();
					  </script>";			 
						 
					

		}


        }//end METHOD POST
    }


    public function remove_license_document($id)
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        //if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
        //{
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
       // }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {


			$query = $this->db->select('license_doc');
			$query = $this->db->where('client_id', $id);
			$query = $this->db->get('applicant_bio');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				$file =  BASE_URL.'assets/vacancies/documents/license/' . $row['license_doc']; # build the full path		
				
				if (file_exists($file)) {
					unlink($file);
				}
				
					$this->db->set('license_doc' , '');
					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio');
							 
								
				
			}


        }//end GET METHOD
    }




	//+++++++++++++++++++++++++++
	//ADD QUALIFICATION DOCUMENT
	//++++++++++++++++++++++++++

	function add_qualification_document()
	{

		$http_origin = $_SERVER['HTTP_ORIGIN'];

		//if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107" )
		//{
		$this->output->set_header("Access-Control-Allow-Origin: *");
		// }

		error_reporting(E_ALL);


		//$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

		}elseif($_SERVER['REQUEST_METHOD'] == "POST") {


			$doc = $this->input->post('userfile', TRUE);
			$name = $this->input->post('name', TRUE);
			$id = $this->input->post('id', TRUE);

			//upload file
			$config['upload_path'] = BASE_URL . 'assets/vacancies/documents/';
			$config['allowed_types'] = 'pdf|doc|docx|jpg';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['file_name']  = strtolower(str_replace(' ', '_', $name).'_qualifications_'.date("dmY"));
			//$config['file_name']  = 'cv_'.date("dmY");
			//$config['encrypt_name']  = TRUE;
			//$config['file_name']  = trim(substr($img, 0, 80));

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{

				$data['error'] =  $this->upload->display_errors();



			}
			else
			{

				//$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;


				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));


				//populate array with values
				$data_doc = array(
					'qualification_doc'=> $file,
				);


				//CHECK IF USER EXISTS IN CLIENTS
				$query2 = $this->db->query("SELECT * FROM applicant_bio WHERE client_id = '".$id."'", FALSE);

				if($query2->result()) {

					$this->db->where('client_id' , $id);
					$this->db->update('applicant_bio',$data_doc);

				} else {

					$this->db->insert('applicant_bio',$data_doc);

				}

				//SEND TO BUCKET
				//You need to set only the path, and name, no absolute path!!!
				//check if exists, then send it to s3
				$this->load->model('cron_model');
				//UPLOAD S3
				if(file_exists(BASE_URL.'assets/vacancies/documents/'.$file)){

					$data['out'] = $this->cron_model->upload_s3('assets/vacancies/documents/'.$file);
				}else{

					$data['out'] = 'Not Uploaded';

				}

				$data['filename'] = $file;

				//redirect
				$data['basicmsg'] = 'Qualification Document added successfully!';
				$str = '<pre>'.$file.' <a href="javascript:void(0);" onclick="remove_qualify_doc('.$id.')" class="btn btn-sm btn-danger pull-right"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></pre>';
				echo "<script>
					  $('#feat_qualify_doc').html('".$str."');
					  $('#add_qualify_doc').fadeOut();
					  </script>";



			}


		}//end METHOD POST
	}


	public function remove_qualification_document($id)
	{

		$http_origin = $_SERVER['HTTP_ORIGIN'];

		//if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107")
		//{
		$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
		// }



		//$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

		}elseif($_SERVER['REQUEST_METHOD'] == "GET") {


			$query = $this->db->select('qualification_doc');
			$query = $this->db->where('client_id', $id);
			$query = $this->db->get('applicant_bio');

			if($query->result()){

				$row = $query->row_array();

				$file =  BASE_URL.'assets/vacancies/documents/' . $row['qualification_doc']; # build the full path

				if (file_exists($file)) {
					unlink($file);
				}

				$this->db->set('qualification_doc' , '');
				$this->db->where('client_id' , $id);
				$this->db->update('applicant_bio');



			}


		}//end GET METHOD
	}





	//+++++++++++++++++++++++++++
    //ADD LICENSE DOCUMENT
    //++++++++++++++++++++++++++

    function add_avatar_pic()
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

       // if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107" )
        //{
            $this->output->set_header("Access-Control-Allow-Origin: *");
       // }

		
		error_reporting(E_ALL);

        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {

			

			$doc = $this->input->post('userfile', TRUE);
			
			$id = $this->input->post('id', TRUE);

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
				
					echo $config['upload_path'];

					$data['error'] =  $this->upload->display_errors();
					
					echo $data['error'];
	
			} else {	

			$this->load->library('image_lib');
				
			$this->delete_old_avatar($id);

			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;
			$file_no_ext = $data['upload_data']['raw_name'];	
			//CONVERT TO JPEG
			if(strtolower($this->upload->file_ext) != '.jpg'){
					  
					  $input_file = $config['upload_path'].$file;
					  $output_file = $config['upload_path'].$file_no_ext.'.jpg';
					  $this->load->model('image_model');
					  
					  if($this->image_model->convert_jpeg($input_file, $output_file)){
						  
						  $file = $file_no_ext.'.jpg';	
					  }
 
				}
				
				
				if (($width > 850) || ($height > 700)){
						 
						$this->image_model->downsize_image($file,$user_id);
								
				}
				
					
				 //populate array with values
				  $data_doc = array( 
					'CLIENT_PROFILE_PICTURE_NAME'=> $file,
				  );
				  
				  
				  $this->db->where('ID' , $id);
				  $this->db->update('u_client',$data_doc);				  					


				  $data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'Avatar added successfully!';
			  	  $str = '<img src="'.base_url('/').'assets/users/photos/'.$file.'" style="width:100%;" class="thumbnail">';
				  echo "<script>
					  $('#feat_avatar_pic').html('".$str."');
					  </script>";			 
						 
					

		}


        }//end METHOD POST
    }	
	
	
	
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DELETE OLD AVATAR
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function delete_old_avatar($user_id){
		
			$query = $this->db->where('ID' , $user_id);
			$query = $this->db->get('u_client');
			
			$row = $query->row_array();
			
			//has existing image
			if($row['CLIENT_PROFILE_PICTURE_NAME'] != 'NULL'){
					
				
				$file = base_url('/') . 'assets/users/photos/' . $row['CLIENT_PROFILE_PICTURE_NAME']; # build the full path		
				
				if (file_exists($file)) {
					unlink($file);
				}
				
			//no existing image	
			}else{

			}
	
	}	
	

    //+++++++++++++++++++++++++++
    //ADD FEATURED IMAGE
    //++++++++++++++++++++++++++

    function add_featured_image()
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        //if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na" || $http_origin == "http://154.0.162.107" )
        //{
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        //}



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {


            $bus_id = $this->input->post('bus_id', TRUE);
            $img = $this->input->post('userfile', TRUE);
            $id = $this->input->post('id', TRUE);

            //upload file
            $config['upload_path'] = BASE_URL . 'assets/vacancies/images/';
            $config['allowed_types'] = 'gif|jpg|jpeg|png';
            $config['max_size'] = '12000';
            $config['max_width'] = '8324';
            $config['max_height'] = '8550';
            $config['min_width'] = '200';
            $config['min_height'] = '200';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;
            //$config['file_name']  = trim(substr($img, 0, 80));

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {

                $data['error'] = $this->upload->display_errors();

                echo "<script>
                        $.noty.closeAll()
                        var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
                        noty(options);

                        </script>";


            } else {
                //LOAD library
                $this->load->library('image_lib');

                $data = array('upload_data' => $this->upload->data());
                $file = $this->upload->file_name;
                $width = $this->upload->image_width;
                $height = $this->upload->image_height;

                $format = substr($file, (strlen($file) - 4), 4);
                $str = substr($file, 0, (strlen($file) - 4));

                if (($width > 1950) || ($height > 900)) {

                    $this->load->model('image_model');
                    $this->image_model->downsize_image($file, '1800', '1000');

                }

                //populate array with values
                $data = array(
                    'image' => $file,
                );
                //insert into database
                $this->db->where('vacancy_id', $id);
                $this->db->update('vacancies', $data);

                $data['filename'] = $file;
                $data['width'] = $this->upload->image_width;
                $data['height'] = $this->upload->image_height;
                $image = base_url('/') . 'assets/vacancies/images/' . $file;
                //redirect
                $data['basicmsg'] = 'Image added successfully!';
                $str = '<div id="feat_img"><div class="img-polaroid"><img src="' . $image . '" /><p style="padding:10px 10px 0px 0px;text-align:right"><a href="' . site_url('/') . 'my_images/edit/' . rawurlencode($this->encrypt->encode(NA_URL . 'assets/vacancies/images/' . $file, $this->config->item('encryption_key'), TRUE)) . '" style="margin-right:5px" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a><a href="javascript:void(0);" onclick="remove_img(' . $id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p></div></div>';
                echo "<script>
                          $.noty.closeAll()
                          var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
                          noty(options);
                          $('#feat_img').html('" . $str . "');
                          $('#add_img').fadeOut();
                          </script>";


            }
        }//end METHOD POST
    }


    public function remove_featured_image($id)
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {

            $query = $this->db->select('image');
            $query = $this->db->where('vacancy_id', $id);
            $query = $this->db->get('vacancies');

            if ($query->result()) {

                $row = $query->row_array();

                $file = BASE_URL . 'assets/vacancies/images/' . $row['image']; # build the full path

                if (file_exists($file)) {
                    unlink($file);
                }

                $this->db->set('image', '');
                $this->db->where('vacancy_id', $id);
                $this->db->update('vacancies');

                echo "<script>
                          $.noty.closeAll()
                          var options = {'text':'Image removed.','layout':'bottomLeft','type':'success'};
                          noty(options);

                          </script>";


            }
        }//end GET METHOD
    }



    public function remove_featured_document($id)
    {

        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "GET") {

            $query = $this->db->select('document');
            $query = $this->db->where('vacancy_id', $id);
            $query = $this->db->get('vacancies');

            if ($query->result()) {

                $row = $query->row_array();

                $file = BASE_URL . 'assets/vacancies/documents/vacancies/' . $row['document']; # build the full path

                if (file_exists($file)) {
                    unlink($file);
                }

                $this->db->set('document', '');
                $this->db->where('vacancy_id', $id);
                $this->db->update('vacancies');

                echo "<script>
                          $.noty.closeAll()
                          var options = {'text':'Document removed.','layout':'bottomLeft','type':'success'};
                          noty(options);

                          </script>";


            }
        }//END GET METHOD
    }


    //+++++++++++++++++++++++++++
    //ADD FEATURED DOCUMENT
    //++++++++++++++++++++++++++

    function add_featured_document()
    {


        $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://cms.my.na" || $http_origin == "http://cms.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
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

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {

            $doc = $this->input->post('userfile', TRUE);

            $id = $this->input->post('id', TRUE);
            $bus_id = $this->input->post('bus_id', TRUE);
            //upload file
            $config['upload_path'] = BASE_URL . 'assets/vacancies/documents/vacancies/';
            $config['allowed_types'] = 'pdf|doc|docx|csv|xls|xlsx';
            $config['max_size'] = '100000';
            $config['remove_spaces'] = TRUE;
            $config['encrypt_name'] = TRUE;
            //$config['file_name']  = trim(substr($img, 0, 80));

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload()) {

                $data['error'] = $this->upload->display_errors();

                echo "<script>
                        $.noty.closeAll()
                        var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
                        noty(options);

                        </script>";


            } else {

                //$data = array('upload_data' => $this->upload->data());
                $file = $this->upload->file_name;


                $format = substr($file, (strlen($file) - 4), 4);
                $str = substr($file, 0, (strlen($file) - 4));


                //populate array with values
                $data_doc = array(
                    'document' => $file,
                );


                $this->db->where('vacancy_id', $id);
                $this->db->update('vacancies', $data_doc);


                $data['filename'] = $file;

                //redirect
                $data['basicmsg'] = 'Document added successfully!';
                $str = '<pre>' . $file . '</pre><a href="javascript:void(0);" onclick="remove_doc(' . $id . ')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>';
                echo "<script>
                          $.noty.closeAll()
                          var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
                          noty(options);
                          $('#feat_doc').html('" . $str . "');
                          $('#add_doc').fadeOut();
                          </script>";


            }
        }//END POST METHOD
    }


	//+++++++++++++++++++++++++++
    //CAREERS SEARCH ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function get_jobs($featured = false)
	{
		 $sql = '';
		 $query['sub_cat_name'] = '';
		 $query['sub_cat_id'] = '';
		 if($sub_cat_id = $this->input->get_post('sub_cat_id',TRUE)){
			 if($sub_cat_id != 'all'){
			 	$sql = ' AND vacancies.sub_cat_id = '.$sub_cat_id.'';
			 }
			 $query['sub_cat_id'] = $sub_cat_id;
			 $query['sub_cat_name'] = $this->input->get_post('sub_cat_name', true);
			 
		 }
		$query['location'] = 'Namibia';
		$query['location_id'] = 'all';
		if($location =$this->input->get_post('location',TRUE)){
			 
			 if($location != 'all'){
				 $clean = substr($location,strpos($location,'_',0) +1, strlen($location));
				 $clean_id = substr($location,0, strpos($location,'_',0));
				 $sql .= " AND vacancies.location = '".$clean."'";
				 $query['location'] = $clean;
				 $query['location_id'] = $clean_id;
			 }
			  
		 } 
		$query['q'] = '';
		if($query['q'] =$this->input->get_post('q',TRUE)){
			 
			 if(explode(' ',$query['q']) > 1){
				 $a = explode(' ',$query['q']);
				 $x = 0;
				 foreach($a as $qrow){
					 
					 if(strlen($qrow) > 3){
						 
						 if($x > 0){
							 
							 $sql .= " OR (vacancies.title LIKE '%".$qrow."%' OR vacancies.body LIKE '%".$qrow."%')"; 
						 }else{
							 
							 $sql .= " AND (vacancies.title LIKE '%".$qrow."%' OR vacancies.body LIKE '%".$qrow."%')"; 
							 
						 }
						 
						 
					 }else{
						 
						 
					 }
					 
					 $x ++;
				 }
				 
				 
			 }else{
				 
				  $sql .= " AND (vacancies.title LIKE '%".$query['q']."%' OR vacancies.body LIKE '%".$query['q']."%')";
			 }
		 }

		if(!$query['limit'] =$this->input->get_post('limit',TRUE)){
			 
			 $query['limit'] = 10;
		 }
		  
		 if(!$query['offset'] = $this->input->get_post('offset',TRUE) && $this->input->get_post('offset',TRUE) != ''){
			 
			$query['offset'] = 0;
		 } 
		
		 if($featured){
			 
			 $sql = " AND vacancies.is_featured = 'Y' AND u_business.BUSINESS_LOGO_IMAGE_NAME != ''";
			 
		 }
		 
		 $sql = "SELECT vacancies.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			maincat.category_name as main_cat, subcat.category_name as sub_cat,subsubcat.category_name as sub_sub_cat,subsubsubcat.category_name as sub_sub_sub_cat,
					(SELECT COUNT(vacancies.vacancy_id) FROM vacancies WHERE vacancies.status = 'live' AND vacancies.type ='public' ".$sql." 
					AND start_date < NOW() AND end_date >= NOW()) as total_rows
		 			FROM vacancies 
		 			LEFT JOIN u_business ON u_business.ID = vacancies.bus_id
					LEFT JOIN product_categories as maincat ON maincat.cat_id = vacancies.main_cat_id
					LEFT JOIN product_categories as subcat ON subcat.cat_id = vacancies.sub_cat_id
					LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = vacancies.sub_sub_cat_id
					LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = vacancies.sub_sub_sub_cat_id
		 			WHERE status = 'live' AND type != 'internal' ".$sql." AND start_date < NOW() AND end_date >= NOW()
					ORDER BY vacancies.listing_date DESC
					LIMIT ".$query['limit']." OFFSET ".$query['offset']."";
		 $query['query'] = $this->db->query($sql, true);
		 
		 
		 return $query;
		 
	}
	//+++++++++++++++++++++++++++
    //CAREERS RENDER ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function render_jobs($query, $size = '12')
	{
		 $o = '<div class="row">';
		 if($query->result()){
			 $x = 0;
			foreach($query->result() as $row){
				
				$b = $this->render_business($row);
				
				$fb = "postToFeed(" . $row->vacancy_id . ", '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_na_model->shorten_string(strip_tags($this->my_na_model->clean_url_str($row->body, " ", " ")), 50)))) . "', '" . site_url('/') . 'careers/job/' . $row->vacancy_id . '/' . trim($this->my_na_model->clean_url_str($row->title)) . "')";
				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
				$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->my_na_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
				
				
				$o .= '<div class="col-lg-4 col-md-6 col-sm-12">'.$b.'</div>';
					  
								
				$x ++;
			}
			 
		 }else{
			 
			 $o .= '<div class="col-md-12"><div class="alert alert-secondary">No results Found for the current criteria.</div></div>'; 
			 
		 }
		  $o .= '</div>';
		  
		  return $o;
	}
	//+++++++++++++++++++++++++++
    //CAREERS RENDER ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function render_jobs_slider($query, $size = '12')
	{
		 $o = '<div class="owl-carousel career-carousel" id="career-carousel" style="margin-top:20px">';

		 if($query->result()){

			foreach($query->result() as $row){
				
				$b = $this->render_business($row);
				
				$fb = "postToFeed(" . $row->vacancy_id . ", '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_na_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_na_model->shorten_string(strip_tags($this->my_na_model->clean_url_str($row->body, " ", " ")), 50)))) . "', '" . site_url('/') . 'careers/job/' . $row->vacancy_id . '/' . trim($this->my_na_model->clean_url_str($row->title)) . "')";
				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
				$tweet_url = 'https://twitter.com/share?url=' . site_url('/') . $this->my_na_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
				

				$o .= '<div>'.$b.'</div>';

			}
			 
		 }else{
			 
			 $o .= '<div class="alert alert-secondary">No results Found for the current criteria.</div>'; 
			 
		 }

		 $o .= '</div>';
		  
		return $o;

	}


	//+++++++++++++++++++++++++++
    //CAREERS RENDER BUSINESS? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function render_business($row)
	{


	      $this->load->model('image_model'); 
	      $this->load->library('thumborp');

	      $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
	      $width = 360;
	      $height = 230;

	      $l_width = 100;
	      $l_height = 100;

		  $o = '';	
		  if($row->bus_id != 0 && $row->bus_id != null){
		   		
				$t = '';
				$grade = $this->render_education($row);
				
		   		if($row->COVER != '' && $row->COVER != null){
					
					
					if(strpos($row->COVER, '.')){

                        $cover_str = 'assets/business/photos/' . $row->COVER;
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');						
						
					}else{

                        $cover_str = 'assets/business/photos/' . $row->COVER.'.jpg';
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');	
						
					}
					
				}else{
	                    $cover_str = 'assets/business/photos/listing-placeholder.jpg';
	                    $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');
				}

				if($row->LOGO != '' && $row->LOGO != null){
					
					if(strpos($row->LOGO, '.')){

                        $logo_str = 'assets/business/photos/' . $row->LOGO;
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                         $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';                       

						
					}else{
						

                        $logo_str = 'assets/business/photos/' . $row->LOGO.'.jpg';
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';                        
						
					}
					
					
				}else{
					

                        $logo_str = 'assets/business/photos/bus_logo.png';
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';
				}
				
				$o .= '
                <div> 
                    <figure class="loader">
                        <div class="ribbon-wrapper">
                            <div class="product_ribbon_ft"><small style="color:#ff9900; font-size:14px">'.$row->title.'</small>'.$row->location.'</div>
                            <div class="product_ribbon_ft_orng"><small>'.$row->BUSINESS_NAME.'</small></div>
                        </div>
                        <div class="slideshow-block">
                            <a href="'.site_url('/').'careers/job/'.$row->vacancy_id.'/'.$row->slug.'/"><img class="" src="' . $cover_url . '" alt="' . $row->title . '"></a>
                        </div>
                        <div>      
                            '.$b_logo.'
                        </div>
                    </figure>           
                </div>
				';



				/*$o .= '<div class="row-fluid  bottom-black" style="height:200px;background-image:url('.$t.');background-size:cover; z-index:88; position:relative;">
							<div class="row-fluid " style="; padding:5px 0">
								
								<div class="span3 vlogo" style="padding-left:25px;">
									<img src="'.$l.'" class="blogo img-responsive img-polaroid">
								</div>
								<div class="span9 vtitle">
									<h3 class="upper na_script white">'.$row->title.'</h3>
									<p class="white"><i class="icon-map-marker icon-white"></i><em>'. $row->location.' - '.$row->BUSINESS_NAME.'</em></p>
									<p class="white">'.$grade.'</p>
								</div>
							</div>
						</div>';*/

		  }
		  return $o;
	}



	//+++++++++++++++++++++++++++
    //CAREERS RENDER BUSINESS? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function render_single_business($row)
	{


	      $this->load->model('image_model'); 
	      $this->load->library('thumborp');

	      $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
	      $width = 360;
	      $height = 230;

	      $l_width = 100;
	      $l_height = 100;

		  $o = '';	
		  if($row->bus_id != 0 && $row->bus_id != null){
		   		
				$t = '';
				$grade = $this->render_education($row);
				
		   		if($row->COVER != '' && $row->COVER != null){
					
					
					if(strpos($row->COVER, '.')){

                        $cover_str = 'assets/business/photos/' . $row->COVER;
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');						
						
					}else{

                        $cover_str = 'assets/business/photos/' . $row->COVER.'.jpg';
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');	
						
					}
					
				}else{
	                    $cover_str = 'assets/business/photos/listing-placeholder.jpg';
	                    $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');
				}

				if($row->LOGO != '' && $row->LOGO != null){
					
					if(strpos($row->LOGO, '.')){

                        $logo_str = 'assets/business/photos/' . $row->LOGO;
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                         $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';                       

						
					}else{
						

                        $logo_str = 'assets/business/photos/' . $row->LOGO.'.jpg';
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';                        
						
					}
					
					
				}else{
					

                        $logo_str = 'assets/business/photos/bus_logo.png';
                        $logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
                        $b_logo = '<img title="Product is listed by ' . $row->title . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" />';
				}
				


				$o .= '


				';





				$o .= '
                <div> 
                    <figure class="loader">
                        <div class="ribbon-wrapper">
                            <div class="product_ribbon_ft"><small style="color:#ff9900; font-size:14px">'.$row->title.'</small>'.$row->location.'</div>
                            <div class="product_ribbon_ft_orng"><small>'.$row->BUSINESS_NAME.'</small></div>
                        </div>
                        <div class="slideshow-block">
                            <a href="'.site_url('/').'careers/job/'.$row->vacancy_id.'/'.$row->slug.'/"><img class="" src="' . $cover_url . '" alt="' . $row->title . '"></a>
                        </div>
                        <div>      
                            '.$b_logo.'
                        </div>
                    </figure>           
                </div>
				';


		  }
		  return $o;
	}






	//+++++++++++++++++++++++++++
    //CAREERS RENDER EDUCATION? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function render_education($row)
	{
		 
			$grade = $row->grading.' ' .$row->skills. ' Secondary Education: Grade ' .$row->secondary_education;
			if($row->grading == 0 && $row->secondary_education == ''){
				
				$grade = $row->skills;
				
			}elseif($row->grading == 0){
				
				$grade = $row->skills. ' Secondary Education: Grade ' .$row->secondary_education;
			}else{
				
				
				
			}
			
				
		  return $grade;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//PREFETCH TYEHEAD
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function load_typehead($type, $cat){

        $str = array();
		$sql = '';
		if($q =$this->input->get_post('query',TRUE)){
			 
			 if(explode(' ',$q) > 1){
				 $a = explode(' ',$q);
				 $x = 0;
				 foreach($a as $qrow){
					 
					 if(strlen($qrow) > 2){
						 
						 if($x > 0){
							 
							 $sql .= " OR (vacancies.title LIKE '%".$qrow."%' OR vacancies.body LIKE '%".$qrow."%')"; 
						 }else{
							 
							 $sql .= " AND (vacancies.title LIKE '%".$qrow."%' OR vacancies.body LIKE '%".$qrow."%')"; 
							 
						 }
						 
						 
					 }else{
						 
						 
					 }
					 
					 $x ++;
				 }
				 
				 
			 }else{
				 
				  $sql .= " AND (vacancies.title LIKE '%".$q."%' OR vacancies.body LIKE '%".$q."%')";
			 }
		 }
		
		$sql = "SELECT vacancies.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			maincat.category_name as main_cat, subcat.category_name as sub_cat,subsubcat.category_name as sub_sub_cat,subsubsubcat.category_name as sub_sub_sub_cat
		 			FROM vacancies 
		 			LEFT JOIN u_business ON u_business.ID = vacancies.bus_id
					LEFT JOIN product_categories as maincat ON maincat.cat_id = vacancies.main_cat_id
					LEFT JOIN product_categories as subcat ON subcat.cat_id = vacancies.sub_cat_id
					LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = vacancies.sub_sub_cat_id
					LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = vacancies.sub_sub_sub_cat_id
		 			WHERE status = 'live' AND type != 'internal' ".$sql."
					ORDER BY vacancies.listing_date DESC
					LIMIT 100";
		$test = $this->db->query($sql, true);			
		$x2 = 1;
		if($test->result()){

			foreach($test->result() as $row2){

				$name2 =  $row2->title;
				$array2 = explode(" ",$name2);
				$temp2 = implode('","' , $array2);
				$link = site_url('/').'careers/job/'.$row2->vacancy_id.'/'.$row2->slug.'/';
				$img = $row2->LOGO;
				//Build image string
				$format = substr($img,(strlen($img) - 4),4);
				$strT = substr($img,0,(strlen($img) - 4));

				if($img != ''){

					if(strpos($img,'.') == 0){

						$format = '.jpg';
						$img_str = base_url('/').'img/timbthumb.php?w=20&h=20&src='.S3_URL.'assets/business/photos/'.$img . $format;

					}else{

						$img_str =  base_url('/').'img/timbthumb.php?w=20&h=20&src='.S3_URL.'assets/business/photos/'.$img;

					}

				}else{

					$img_str = base_url('/').'img/timbthumb.php?w=20&h=20&src='.base_url('/').'img/bus_blank.png';

				}


				$t = array(

					"year" => $x2,
					"image" => $img_str,
					"type" => "Vacancies",
					"body" => $name2,
					"link1" => "javascript:go_url('".$link."')",
					"value" => $name2,
					"tokens" => $array2

				);
				array_push($str, $t);

				$x2 ++;
			}

		}

        echo json_encode($str);

		$this->output->set_content_type('application/json');
			  
    }


}
?>