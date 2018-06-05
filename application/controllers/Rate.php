<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rate extends CI_Controller {

 

    function __construct()
    {
		parent::__construct();
		$this->load->model('rating_model');

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//RATING WIDGET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function rateme($bus_id, $embed = '', $external = '', $reviews = 'show'){

        //$this->output->set_header("Access-Control-Allow-Origin: *");
        //$this->output->set_header( "Access-Control-Allow-Methods: POST, GET" );
        //$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
       // $this->output->set_header( 'Access-Control-Allow-Credentials: true' );
        //$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        //$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		//$this->output->set_header( 'P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"' );
		//header('P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"');
        if(isset($bus_id)){


			$client_id = $this->session->userdata('id');
			$this->rating_model->rate($bus_id, $client_id, $embed, $external, $reviews);



		}

	}
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //RATING WIDGET
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function rate_sess(){

        $this->output->set_header("Access-Control-Allow-Origin: *");
        $this->output->set_header( "Access-Control-Allow-Methods: POST, GET" );
        $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
        $this->output->set_header( 'Access-Control-Allow-Credentials: true' );
        $this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		//$this->output->set_header( 'P3P: CP="CURa ADMa DEVa PSAo PSDo OUR BUS UNI PUR INT DEM STA PRE COM NAV OTC NOI DSP COR"' );

        if($id = $this->session->userdata('id')){


        };

    }
	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BUSINESS REVIEW & RATING
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	public function widget($bus_id, $embed = '', $external = '', $reviews = 'show')
	{

		redirect(base_url('/').'js/widget.js?v1.11&bus_id='.$bus_id.'', 301);

	}

	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BUSINESS REVIEW & RATING
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	public function preview($bus_id)
	{

		echo '<script src="'.base_url('/').'js/rating/widget.js?v1.11&bus_id='.$bus_id.'&embed=plugin&external=true" id="myna"></script>';


	}
	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BUSINESS REVIEW & RATING
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	public function submit_review($bus_id)
	{
		$this->rating_model->submit_review($bus_id);


	}

	public function submit_review_ajax($bus_id)
	{


		$this->rating_model->submit_review_ajax($bus_id);

	}


	public function clean_old()
	{

		/*$this->db->where('type', 'review');
		$q = $this->db->get('u_business_vote');*/

        $q = $this->db->query("SELECT u_business_vote.*,
									u_business.BUSINESS_NAME,u_business.ID, u_business.STAR_RATING
 									FROM u_business_vote
 									JOIN u_business ON u_business_vote.BUSINESS_ID = u_business.ID
 									LEFT JOIN u_client ON u_business_vote.CLIENT_ID = u_client.ID
 									WHERE u_business_vote.IS_ACTIVE = 'Y'
 									AND  u_business_vote.REVIEW_TYPE = 'business_review' AND u_business_vote.TYPE = 'review'
 									ORDER BY u_business_vote.TIME_VOTED DESC
									");
        $bus = array();
        $count = array();
        $avg = array();
        $sum = array();
        $Oavg = array();
        $Navg = array();
		if($q->result()){

            foreach($q->result() as $row1){

                $bus[$row1->BUSINESS_ID] = 0;
                $count[$row1->BUSINESS_ID] = 0;
                $avg[$row1->BUSINESS_ID] = 0;
                $sum[$row1->BUSINESS_ID] = 0;
                $Oavg[$row1->BUSINESS_ID] = 0;


            }


            foreach($q->result() as $row){

                //echo $row->BUSINESS_NAME. ' : ';

                $count[$row->BUSINESS_ID] = $count[$row->BUSINESS_ID] + 1;
                $sum[$row->BUSINESS_ID] = $sum[$row->BUSINESS_ID] + $row->RATING;
                $Oavg[$row->BUSINESS_ID] = $row->STAR_RATING;
                /*$data['RATING'] = $row->RATING / 2;

				$this->db->where('ID', $row->ID);
				$this->db->update('u_business_vote', $data);*/



			}
            //var_dump($bus);

            foreach($bus as $brow => $bkey){

                $Navg[$brow] = $sum[$brow] / $count[$brow];

                if(round($Navg[$brow], 2) != $Oavg[$brow]){

                    echo 'Proooobleeeeem Row: '.$brow .' ';

                    $i['STAR_RATING'] = round($Navg[$brow],2);

                    /*$this->db->where('ID', $brow);
                    $this->db->update('u_business', $i);*/


                }

                echo $brow . ' Total: '.$sum[$brow]. ' Count: '.$count[$brow]. ' Avg: '.round($Navg[$brow],2).'  -----  '.$Oavg[$brow].'<br/>';

            }




		}


	}
	public function rating($type, $id)
	{

		if($type == 'business'){

			redirect(site_url('/').'rate/rateme/'.$id.'/embed/external/', 301);

		}elseif($type == 'product'){

			echo 'Coming Soon...';

		}elseif($type == 'deal'){

			echo 'Coming Soon...';

		}

	}

    //+++++++++++++++++++++++++++
    //LOGIN FUNCTIONS
    //++++++++++++++++++++++++++
    function login()
    {


       /* $http_origin = $_SERVER['HTTP_ORIGIN'];

        if ($http_origin == "https://teamnamibia.my.na" || $http_origin == "https://ncci.my.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
        }*/



        $this->output->set_header("Access-Control-Allow-Origin: *");
        $this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
        $this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

        /*$this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();*/
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //$this->output->set_output( "*" );
            //$this->output->set_header("Access-Control-Allow-Credentials: true");
            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {

            $this->load->model('members_model');
            $email = trim($this->input->post('email', TRUE));
            $first = $this->input->post('first_log', TRUE);
            $pass = $this->input->post('pass', TRUE);
            $sess = $this->input->post('rememberme', TRUE);
            $redirect = $this->input->post('redirect', TRUE);

            //MATCH CREDENTIALS
            $row = $this->members_model->validate_password($email, $pass);
            if ($row['bool'] == 'YES') {

                //HASH PASSWORD AGAIN
                $pass_new = $this->members_model->hash_password($email, $pass);
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
                $this->session->set_userdata('fb_id', $row['FB_ID']);
                $this->session->set_userdata('img_file', $row['CLIENT_PROFILE_PICTURE_NAME']);
                $this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));
                $this->session->set_flashdata('login', 'yes');*/

                $sess = array(

                    'id' => $row['ID'],
                    'u_name' => $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'],
                    'fb_id' => $row['FB_ID'],
                    'img_file' => $row['CLIENT_PROFILE_PICTURE_NAME'],
                    'points' => $this->my_na_model->count_points($row['ID']),
                    'login' => 'yes'

                );
                $this->session->set_userdata($sess);
                $this->session->set_flashdata('login', 'Y');

                $this->db->where('ID', $row['ID']);
                $this->db->update('u_client', $data);
                //SEE IF 1st Login
                if ($first == 'Y') {

                    $this->session->set_flashdata('first_login', 'Y');

                }


                if ($this->input->is_ajax_request() || $this->agent->is_referral()) {
                    echo '<script type="text/javascript">
                                    location.reload();
                                    document.getElementById(FrameID).contentDocument.location.reload(true);
                           </script>';

                } else {

                    //--------------
                    //Redirect
                    if ($row['VERIFIED'] == 'N') {

                        redirect('/clients/verify/');

                    } elseif ($this->input->post('redirect')) {

                        $redirect = $this->input->post('redirect');
                        redirect($redirect, 301);
                    } else {

                        redirect('/members/home/');

                    }

                }


            } elseif ($row['bool'] == 'NO') {

                $data['error'] = 'Your password did not match our records! Please update your password for ' . $email;
                //echo $this->encode($pass) .' ' ;

                if ($this->input->is_ajax_request() || $this->agent->is_referral()) {
                    echo '<div class="alert alert-error">' . $data['error'] . '</div>';

                } else {

                    $this->load->view('login', $data);

                }


                //NO MATCHING CREDENTIALS
            } else {
                $data['redirect'] = $this->input->post('redirect');
                $data['error'] = 'No account found for ' . $email . '! Please create a new user account <a href="' . site_url('/') . 'members/register/">here</a>';
                //echo $this->encode($pass) .' ' ;
                if ($this->input->is_ajax_request() || $this->agent->is_referral()) {

                    echo '<div class="alert alert-error">' . $data['error'] . '</div>';
                } else {

                    $this->load->view('login', $data);

                }

            }
        }
    }



    //+++++++++++++++++++++++++++
    //REGISTER MEMBER WITHOUT AJAX
    //++++++++++++++++++++++++++
    function register_do_ajax()
    {

        $gender = $this->input->post('gender', TRUE);

        if(!$email = $this->session->userdata('email')){

            $email = $this->input->post('email_', TRUE);
        }
        if(!$client_id = $this->session->userdata('client_id')){

            $client_id = trim($this->input->post('client_id', TRUE));
        }

        $cell = $this->input->post('cell', TRUE);
        $pass1 = $this->input->post('pass1', TRUE);
        $pass2 = $this->input->post('pass2', TRUE);
        $country = $this->input->post('country', TRUE);
        $city = $this->input->post('city', TRUE);
        $suburb = $this->input->post('suburb', TRUE);
        $dob = $this->input->post('dob', TRUE);
        $security = $this->input->post('security', TRUE);

        //$dob = strtotime($new_date_format);

        //VALIDATE INPUT
        if(($pass1 != $pass2)){
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



            $insertdata = array(

                'CLIENT_CELLPHONE'=> $cell,
                'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
                'CLIENT_GENDER'=> $gender,
                'CLIENT_DATE_OF_BIRTH'=> $dob,
                'CLIENT_COUNTRY' => $country,
                'CLIENT_CITY' => $city,
                'CLIENT_SUBURB' => $suburb


            );

            $this->db->where('ID' , $client_id);
            $query = $this->db->update('u_client', $insertdata);

            //success redirect
            $data['basicmsg'] = 'Thank you,  you have successfully registered.';

            $result['success'] = true;

            $result['html'] =   '<div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        '.$data['basicmsg'].'</div>';

            echo json_encode($result);


        }else{

            $data['error'] = $error;

            $result['success'] = false;

            $result['html'] = '<div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    '.$data['error'].'</div>';

            echo json_encode($result);
        }
    }




    //+++++++++++++++++++++++++++
    //REGISTER STEP 1
    //++++++++++++++++++++++++++
    function register_1_do_ajax()
    {

        $email = trim($this->input->post('signup_email', TRUE));
        $fname = $this->input->post('fname', TRUE);
        $sname = $this->input->post('sname', TRUE);
        //TEST IF ROBOT
        if ($this->agent->is_robot())
        {

            $result['success'] = false;

            $result['html'] =   '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		Sorry, only humans can submit an enquiry!</div>';

            echo json_encode($result);
            //IS HUMAN
        }else {

            $this->load->library('recaptcha');
            $bool = json_decode($this->recaptcha->recaptcha_check_answer());

            //var_dump ($bool);
            //CAPTCHA FALSE
            if (!$bool->success) {

                $data['error'] = 'Are you a robot? PLease click on I am not a robot above.';

                $result['success'] = false;

                $result['html'] =  '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								' . $data['error'] . '</div>';

                echo json_encode($result);
            } else {

                //$dob = strtotime($new_date_format);

                //VALIDATE INPUT
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $val = FALSE;
                    $error = 'Email address is not valid.';

                } elseif (($fname == '') || ($sname == '')) {
                    $val = FALSE;
                    $error = 'Please provide us with your full name.';

                } else {
                    $val = TRUE;
                }


                if ($val == TRUE) {

                    $this->load->library('user_agent');
                    $agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
                    $IP = $this->input->ip_address();

                    $insertdata = array(
                        'CLIENT_NAME' => $fname,
                        'CLIENT_SURNAME' => $sname,
                        'CLIENT_EMAIL' => $email,
                        'CLIENT_UA' => $agent,
                        'CLIENT_IP' => $IP,
                        'IS_ACTIVE' => 'N'
                    );

                    $this->db->where('CLIENT_EMAIL', $email);
                    $this->db->from('u_client');
                    $query = $this->db->get();


                    //IF email already exists
                    if ($query->num_rows() > 0) {

                        $data['error'] = 'A member with the email address ' . $email . ' already exists!';

                        $result['success'] = false;

                        $result['html'] =  '<div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['error'] . '</div>';

                        echo json_encode($result);


                    } else {

                        $this->db->insert('u_client', $insertdata);
                        //get ID
                        $this->db->where('CLIENT_EMAIL', $email);
                        $this->db->from('u_client');
                        $query = $this->db->get();
                        $row = $query->row_array();
                        $member_id = $row['ID'];


                        //SEND EMAIL LINK
                        $this->load->model('email_model');

                        $data['fname'] = $fname;
                        $data['img'] = '0';
                        $data['member_id'] = $member_id;
                        $data['email'] = $email;
                        $data['sname'] = $sname;
                        $data['agent'] = $agent;
                        $data['base'] = base_url('/');
                        $data['confirm_link'] = site_url('/') . 'members/activate/'.$member_id;
                        //SEND EMAIL LINK
                        //$this->load->model('email_model');
                        //$this->email_model->send_register_link($data);

                        //BUILD BODY
                        $body = 'Hi ' . $fname . ',<br /><br />
                                   <p>You have successfully registered as a official reviewing party of Namibia.</p>
                                   <p><img class="white_box" src="'.S3_URL.'assets/business/photos/226a595cc02ca4b39495429cd048de7e.jpg" ></p>
                                       <p>To verify your email address and activate your account please click on the link below or copy and paste it into the address bar of your browser.</p>
                                       <p></p>
                                       <p>' . $data['confirm_link'] . '</p>
                                       <p>If you have any questions please email us at info@my.na.</p>
                                       <p>Have a !na day</p>
                                       <br /><br />
                                       My Namibia
                                       <p><img class="white_box" src="'.S3_URL.'assets/business/photos/3ee358379f50d9fb1e89a72d03ce4418.png" ></p>
                                       ';

                           $data_view['body'] = $body;
                           $body_final = $this->load->view('email/body_news', $data_view, true);
                           $subject = 'Your Email Verification Link';
                           $fromEMAIL = 'no-reply@my.na';
                           $fromNAME = 'My Namibia';
                           $TAG = array('tags' => 'irate_registration');
                           $emailTO = array(array('email' => $email));

                           //SEND EMAIL LINK
                           $this->load->model('email_model');
                           $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
                        //success redirect
                        $data['basicmsg'] = 'Thank you, ' . $fname . ' you have successfully registered. Please check your inbox for a verfification link.';

                        //SET SEMI SESSION
                        $sess = array(
                            'id' =>  $member_id,
                            'fname' => $fname,
                            'sname' => $sname,
                            'semi' => true,
                            'email' => $email,
                            'client_id' => $member_id

                        );
                        $this->session->set_userdata($sess);

                        $result['success'] = true;
                        $result['client_id'] = $member_id;
                        $result['email'] = $email;
                        $result['html'] = '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['basicmsg'] . '</div>';

                        echo json_encode($result);

                    }

                } else {

                    $data['error'] = $error;
                    $result['success'] = false;

                    $result['html'] =  '<div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['error'] . '</div>';

                    echo json_encode($result);

                }
            }
        }
    }


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */