<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header("Access-Control-Allow-Origin: https://nmh.my.na");

class Clients extends CI_Controller {

	/**
	 * Verify Clients Controller
	 */

	function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		$this->load->view('login');
	}

	public function verify()
	{
		if($this->session->userdata('id')){

			$this->load->model('members_model');
			$data = $this->members_model->get_my_account($this->session->userdata('id'));

			if($data['VERIFIED'] == 'Y'){

				redirect(site_url('/').'members/');

			}else{

				$this->load->view('members/verify', $data);

			}


		}else{

			redirect(site_url('/').'members/');

		}

	}


	public function send_mobile_otp_code()
	{
		if($data['client_id'] =  $this->input->get('client_id')){

			//$data['client_id'] = $this->session->userdata('id');
			$number = $this->input->get('number');
			//$dial_code = $this->input->get('dial_code');
			$dial_code = '264';
			$url = $this->input->get('url');
			$data['user_agent'] = $this->agent->browser().' '.$this->agent->version();
			$data['ip_address'] = $this->input->ip_address();
			$data['code'] = rand(1111, 9999);



			//TEST VERIFICTAION
			$this->db->where('client_id', $data['client_id']);
			$q = $this->db->get('u_client_verify');

			if($q->result()){

				$this->db->where('client_id', $data['client_id']);
				$this->db->update('u_client_verify', $data);

			}else{

				$this->db->insert('u_client_verify', $data);
			}

			$msg = 'Your My Namibia OTP is '.$data['code'];

			//CLEAN NUMBER
			if(substr($number,0,1) == 0){

				$number = substr($number,1,strlen($number));
			}

			//LOAD LIBRARIES FOR API AND SEND SMS
			$this->load->library('curl');
			$this->load->library('rest', array(
				'server' => 'http://sms.my.na/api/sms/',
				'http_user' => 'myna_ma$ster',
				'http_pass' => '#$5_jh56_hdgd',
				'http_auth' => 'basic' // or 'digest'
			));

			$user = $this->rest->get('send', array('number' => $dial_code.$number, 'msg' => $msg), 'json');

			$o['msg'] = '<div class="alert alert-success">Your OTP has been sent.</div>';
			$o['success'] = true;

		}else{

			$o['success'] = false;
			$o['msg'] = 'No data';
		}
		echo json_encode($o);
	}


	public function verify_mobile_otp_code()
	{
		if($data['client_id'] =  $this->input->get('client_id')){

			$code = $this->input->get('code');
			$url = $this->input->get('url');
			$this->db->where('client_id', $data['client_id']);
			$this->db->where('code', $code);
			$q = $this->db->get('u_client_verify');

			if($q->result()){

				if($url == ''){

					$url = site_url('/').'members/';
				}

				$this->db->where('client_id', $data['client_id']);
				$this->db->delete('u_client_verify');

				$o['success'] = true;
				$o['msg'] = '<div class="alert alert-success">Thank you, OTP verified.</div>';

			}else{

				$o['success'] = false;
				$o['msg'] = '<div class="alert alert-danger">Sorry, OTP does not match.</div>';
			}


		}else{

			$o['success'] = false;
			$o['msg'] = 'No data';
		}
		echo json_encode($o);
	}


	public function send_mobile_code_plain()
	{
		if($data['client_id'] =  $this->input->get('client_id')){

			//$data['client_id'] = $this->session->userdata('id');
			$number = $this->input->get('number');
			//$dial_code = $this->input->get('dial_code');
			$dial_code = '264';
			$url = $this->input->get('url');
			$data['user_agent'] = $this->agent->browser().' '.$this->agent->version();
			$data['ip_address'] = $this->input->ip_address();
			$data['code'] = rand(1111, 9999);

			//TEST NUMBER EXISTS
			/*$a = $this->db->where('CLIENT_CELLPHONE', ltrim($number, '0'));
			$a = $this->db->where('ID !=', $data['client_id']);
			$a = $this->db->where('VERIFIED', 'Y');
			$a = $this->db->get('u_client');*/
			$a = $this->db->query("SELECT * FROM u_client
									WHERE (CLIENT_CELLPHONE = '".ltrim($number, '0')."' OR CLIENT_CELLPHONE = '".$number."')
									AND VERIFIED = 'Y' AND ID != ".$data['client_id']."
									", true);
			//NUMBER EXISTS
			if($a->result()){

				$row = $a->row();
				$o['success'] = false;
				$o['msg'] = '<div class="alert alert-danger">Number is already verified to another account. Please contact us at info@my.na to resolve this.</div>';



				//NUMBER NOT YET VERIFIED
			}else{

				//TEST VERIFICTAION
				$this->db->where('client_id', $data['client_id']);
				$q = $this->db->get('u_client_verify');

				if($q->result()){

					$this->db->where('client_id', $data['client_id']);
					$this->db->update('u_client_verify', $data);

				}else{

					$this->db->insert('u_client_verify', $data);
				}

				$msg = 'Your My Namibia verification code is '.$data['code'];

				//CLEAN NUMBER
				if(substr($number,0,1) == 0){

					$number = substr($number,1,strlen($number));
				}

				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server' => 'http://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$user = $this->rest->get('send', array('number' => $dial_code.$number, 'msg' => $msg), 'json');

				//UPDATE USER CELL NUMBER
				$data2['CLIENT_CELLPHONE'] = $number;
				$data2['DIAL_CODE'] = $dial_code;
				$this->db->where('ID', $data['client_id']);
				$this->db->update('u_client', $data2);
				$o['msg'] = '<div class="alert alert-success">Your code has been sent.</div>';
				$o['success'] = true;

			}



		}else{

			$o['success'] = false;
			$o['msg'] = 'No data';
		}
		echo json_encode($o);
	}

	public function verify_mobile_code_plain()
	{
		if($data['client_id'] =  $this->input->get('client_id')){

			$code = $this->input->get('code');
			$url = $this->input->get('url');
			$this->db->where('client_id', $data['client_id']);
			$this->db->where('code', $code);
			$q = $this->db->get('u_client_verify');

			if($q->result()){

				if($url == ''){

					$url = site_url('/').'members/';
				}

				$this->db->where('client_id', $data['client_id']);
				$this->db->delete('u_client_verify');

				//UPDATE USER CELL NUMBER
				$data2['VERIFIED'] = 'Y';
				$data2['IS_ACTIVE'] = 'Y';
				$this->db->where('ID', $data['client_id']);
				$this->db->update('u_client', $data2);

				$o['success'] = true;
				$o['msg'] = '<div class="alert alert-success">Thank you, Account verified.</div>';

			}else{

				$o['success'] = false;
				$o['msg'] = '<div class="alert alert-danger">Sorry, code does not match.</div>';
			}


		}else{

			$o['success'] = false;
			$o['msg'] = 'No data';
		}
		echo json_encode($o);
	}

	public function verify_mobile()
	{

		if($this->session->userdata('id')){

			$data['client_id'] = $this->session->userdata('id');
			$number = $this->input->post('number');
			$dial_code = $this->input->post('dial_code');
			$url = $this->input->post('url');
			$data['user_agent'] = $this->agent->browser().' '.$this->agent->version();
			$data['ip_address'] = $this->input->ip_address();
			$data['code'] = rand(1111, 9999);

			//TEST NUMBER EXISTS
			$a = $this->db->query("SELECT * FROM u_client
								   WHERE (CLIENT_CELLPHONE = '".ltrim($number, '0')."' OR CLIENT_CELLPHONE = '".$number."')
								   AND VERIFIED = 'Y' AND ID != ".$data['client_id']."
								   ", true);
			//NUMBER EXISTS
			if($a->result()){

				$row = $a->row();
				$o['html'] = '<div class="alert">Number is already verified to another account. Please contact us at info@my.na to resolve this.</div>';
				$o['success'] = false;
				echo json_encode($o);
				return;


				//NUMBER NOT YET VERIFIED
			}else{

				//TEST VERIFICTAION
				$this->db->where('client_id', $data['client_id']);
				$q = $this->db->get('u_client_verify');

				if($q->result()){

					$this->db->where('client_id', $data['client_id']);
					$this->db->update('u_client_verify', $data);

				}else{

					$this->db->insert('u_client_verify', $data);
				}

				$msg = 'Your My Namibia verification code is '.$data['code'];

				//CLEAN NUMBER
				if(substr($number,0,1) == 0){
					
					$number = substr($number,1,strlen($number));
				}

				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server' => 'http://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$user = $this->rest->get('send', array('number' => $dial_code.$number, 'msg' => $msg), 'json');

				if($number > 5){

					//UPDATE USER CELL NUMBER
					$data2['CLIENT_CELLPHONE'] = $number;
					$data2['DIAL_CODE'] = $dial_code;
					$this->db->where('ID', $data['client_id']);
					$this->db->update('u_client', $data2);

					$o['html'] = '<div class="alert">Your code has been sent.</div>';
					$o['success'] = true;

				}else{

					$o['html'] = '<div class="alert">Number is not a mobile number</div>';
					$o['success'] = false;

				}

				echo json_encode($o);

			}


		}else{

			redirect(site_url('/'));

		}

	}

	public function verify_mobile_lock()
	{
		if($this->session->userdata('id')){

			$data['client_id'] = $this->session->userdata('id');
			$code = $this->input->post('number');
			$url = $this->input->post('url');
			$this->db->where('client_id', $data['client_id']);
			$this->db->where('code', $code);
			$q = $this->db->get('u_client_verify');

			if($q->result()){

				if($url == ''){

					$url = site_url('/').'members/';
				}

				$this->db->where('client_id', $data['client_id']);
				$this->db->delete('u_client_verify');

				//UPDATE USER CELL NUMBER
				$data2['VERIFIED'] = 'Y';
				$data2['IS_ACTIVE'] = 'Y';
				$this->db->where('ID', $data['client_id']);
				$this->db->update('u_client', $data2);



				echo '<div class="alert alert-success">Thank you, Account verified.</div>';
				echo "<script data-cfasync='false' type='text/javascript'>
						$('.add-on').html('+264');
						$('#cell').val('').attr('placeholder', 'eg: 081886373');
						$('#verify_btn').html('<i class=".'"icon-ok icon-white"'."></i> Verified').addClass('btn-success').removeClass('btn-inverse').attr('onclick', '');
						window.setTimeout(window.location.href = '".$url."', 2000);
						</script>";

			}else{
				echo '<div class="alert">Sorry, code does not match.</div>';
				echo "<script data-cfasync='false' type='text/javascript'>
						$('.add-on').html('+264');
						$('#cell').val('').attr('placeholder', 'eg: 081886373');
						$('#verify_btn').html('<i class=".'"icon-remove icon-white"'."></i> Verify').addClass('btn-danger').removeClass('btn-inverse').attr('onclick', 'do_verify()');
						</script>";

			}



		}else{

			redirect(site_url('/'));

		}

	}



    public function alert_server($msg = '')
    {

        if(!$this->input->get('u')){

            $data['error'] = 'No Access, incorrect Key!';
            echo json_encode($data);
            die();

        }else{

            $u = $this->input->get('u');
            $msg = $this->input->get('msg');
            if(!$this->input->get('msg')){

                $msg = 'The Primary Server is currently down';

            }

            //LOAD LIBRARIES FOR API AND SEND SMS
            $this->load->library('curl');
            $this->load->library('rest', array(
                'server' => 'http://sms.my.na/api/sms/',
                'http_user' => $u,
                'http_pass' => '#$5_jh56_hdgd',
                'http_auth' => 'basic' // or 'digest'
            ));

            $user = $this->rest->get('send', array('number' => '0818863437', 'msg' => $msg), 'json');
            var_dump($user);
        }



    }



	public function send_sms_test()
	{
		/*error_reporting(E_ALL);
		$this->load->library('curl');
		$this->load->library('rest', array(
			'server' => 'http://sms.my.na/api/sms/',
			'http_user' => 'myna_ma$ster',
			'http_pass' => '#$5_jh56_hdgd',
			'http_auth' => 'basic' // or 'digest'
		));

		$user = $this->rest->get('send', array('number' => '264818863437', 'msg' => 'Perfect, here is your code.'), 'json');

		echo json_encode($user);*/
		//var_dump($user);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */