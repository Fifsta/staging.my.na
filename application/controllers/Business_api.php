<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//header("Access-Control-Allow-Origin: *");
require APPPATH.'/libraries/REST_Controller.php';

class Business_api extends REST_Controller{

	/**
	 * REST Controller for My.na App.
	 *
	 * Roland Ihms
	 */
	//++++++++++++++++++++++++++++++++++++++++
	//PRE FLIGHT OPTIONS REQUEST
	public function index_options() {
		return $this->response(NULL, 200);
	}


	public function index_get()
	{

		$this->response('Going Nowhere Slowly!!', 200);
	}

	public function index_post()
	{

		$this->response('Going Nowhere Slowly!!', 200);
	}
	
	public function update_business_post()
	{
		$this->load->model('business_model');
		$o = $this->business_model->update_business();
		$this->response($o, 200);
	}	

	public function update_map_coordinates_post()
	{
		$this->load->model('business_model');
		$o = $this->business_model->update_map_coordinates();
		$this->response($o, 200);
	}	


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */