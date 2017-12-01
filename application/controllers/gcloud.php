<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gcloud extends CI_Controller {

	/**
	 * CSV CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
 	function __construct() {
        parent::__construct();
		$this->load->model('gcloud_model');
    }
 
    function index() {

		$file = BASE_URL.'assets/business/photos/My_Namibia-10599.png';
		$path = '/assets/';


	    $out = $this->gcloud_model->upload_gc_bucket($file, $path);
	    var_dump($out);
    }

	function test() {
		var_dump($_SERVER);
		phpinfo();
	}
}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */