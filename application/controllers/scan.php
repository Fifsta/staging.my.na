<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scan extends CI_Controller {

	/**
	 * Adverts Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function Scan()
	{
		parent::__construct();
		$this->load->model('app_model');
		$this->load->model('nmh_model');
	}

	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function index()
	{

		$this->load->view('scan_voucher');

	}

	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function claim()
	{

		$this->load->view('claim_voucher');

	}

	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function claim_voucher_scan()
	{

		$voucher = $this->input->post('vouch_code');

		$this->load->library('encrypt');

		$voucher = $this->encrypt->decode($voucher);

		$db = $this->nmh_model->connect_events_db();

		//echo $voucher;
		$q = $db->where('voucher_id', $voucher);
		$q = $db->get('scratch_promotion_vouchers');
		$o['voucher'] = $voucher;
		if($q->result()){

			$row = $q->row();
			if($row->claimed == 'Y'){

				$o['success'] = false;
				$o['msg'] = 'Voucher was claimed on '.date('Y-m-d H:i:s',strtotime($row->claimed_at));
			}else{

				$o['success'] = true;
				$o['voucher_id'] = $row->voucher_id;
				$o['msg'] = 'PLease release Prize and click on the Claim Voucher Button';

			}


		}else{

			$o['success'] = false;
			$o['msg'] = 'Voucher not Found';

		}

		echo json_encode($o);

	}
	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function claim_voucher()
	{
		
		$voucher = $this->input->post('vouch_code');

		$this->load->library('encrypt');

		//$voucher = $this->encrypt->decode($vouch);

		$db = $this->nmh_model->connect_events_db();

		//echo $voucher;
		$q = $db->where('voucher', $voucher);
		$q = $db->get('scratch_promotion_vouchers');

		if($q->result()){

			foreach($q->result() as $row){


				if($row->claimed == 'Y'){

					$o['success'] = false;
					$o['msg'] = 'Voucher was claimed on '.date('Y-m-d H:i:s',strtotime($row->claimed_at));
				}else{

					$o['success'] = true;
					$o['voucher_id'] = $row->voucher_id;
					$o['msg'] = 'PLease release Prize and click on the Claim Voucher Button';

				}


			}

		}else{

			$o['success'] = false;
			$o['msg'] = 'Voucher not Found';

		}

		echo json_encode($o);

	}

	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function claim_voucher_do()
	{

		$vouch = $this->input->post('voucher_id');

		$in['claimed'] = 'Y';
		$in['claimed_at'] = date('Y-m-d H:i:s', time());

		$db = $this->nmh_model->connect_events_db();
		$db->where('voucher_id', $vouch);

		if($db->update('scratch_promotion_vouchers', $in)){


			$o['success'] = true;
			$o['msg'] = 'Voucher was claimed!!';

		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong Please try again ';

		}


		echo json_encode($o);

	}
	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function test($str)
	{

		//$vouch = $this->input->post('vouch_code');

		$this->load->library('encrypt');

		$voucher = $this->encrypt->encode($str);

		echo $voucher;

	}
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */