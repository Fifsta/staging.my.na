<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class U extends CI_Controller {

	/**
	 * Adverts Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function U()
	{
		parent::__construct();

	}
	
	
	//+++++++++++++++++++++++++++
	//URL Redirectewr
	//++++++++++++++++++++++++++
	public function index($type = '',$id = '')
	{
		if($id != ''){

            //BUSINESS
            if($type == 'b'){

                redirect(site_url('/').'b/'.$id, 'refresh');


           //PRODUCT
            }elseif($type == 'p'){

                redirect(site_url('/').'product/'.$id, 'refresh');
             //DEAL
            }elseif($type == 'd'){

                redirect(site_url('/').'deal/'.$id, 'refresh');
            }

        }



	}

	
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */