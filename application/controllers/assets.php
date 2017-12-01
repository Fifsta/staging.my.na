<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Assets extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */

	
	
	public function test($type,$subtype,$subtype2 = '',$subtype3 = '')
	{
		if($subtype3 != ''){
			redirect(S3_URL.'assets/'.$type.'/'.$subtype.'/'.$subtype2 .'/'.$subtype3, 301);
			
		}elseif($subtype2 != ''){
			redirect(S3_URL.'assets/'.$type.'/'.$subtype.'/'.$subtype2 , 301);
		}elseif($subtype != ''){
			redirect(S3_URL.'assets/'.$type.'/'.$subtype, 301);
		}elseif($type != ''){	
			redirect(S3_URL.'assets/'.$type , 301);
		}
		
		
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */