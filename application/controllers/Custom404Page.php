<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom404Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
 
	}


	public function index()
	{
		$this->output->set_status_header('404');

		 $data['errorMessage'] = ' Ooops! Page not found';  
		$this->load->view('errors/html/error_404',$data);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */