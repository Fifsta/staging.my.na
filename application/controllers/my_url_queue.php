<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_url_queue extends CI_Controller {
	
	function search()
	{
		parent::__construct();
		//$this->config->load('config-no-compression');
		//$this->load->library('pagination');
		$this->load->model('search_model');
		// should put this in the __construct() of this controller or in your MY_Controller.php
   		//$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
	
	}
	
	public function index($offset = '')
	{
	
		redirect(site_url('/'), 'location', 301);
	}
	
	
public function business_impression_queue()
{
	$query = $this->db->get('u_business_imp_queue');
		
		$total_searches = $query->num_rows();
		$total = 0;
		
		if($query->num_rows() != 0){
			
			foreach($query->result() as $row) {
				
				$id = $row->IMP_Q_ID;	
				$query1 = $row->QUERY;
				
				$query2 = $this->db->query($query1, FALSE);
				
				foreach($query2->result() as $row2){
					
					$data['BUSINESS_ID'] = $row2->ID;
					$this->db->insert('u_business_impressions',$data);
					echo $data['BUSINESS_ID'].'<br/>';
				}
				
				$total = $total + $query2->num_rows();
					
			$this->db->where('IMP_Q_ID', $id);
			$this->db->delete('u_business_imp_queue');
			}
			
		}else{
			
			echo 'No Searches made';	
		}
	$this->load->library('email');
	$config['mailtype'] = 'text';	
	$this->email->initialize($config);
	$this->email->from('info@my.na','My Namibia Cron');
	$this->email->to('rolandihms@gmail.com');	
	$this->email->subject('Business Impression Queue Updated');
	$body1 = "We have updated the impression queue table," . " \n\n";
	$body1.= "------------------------------------------------------------- \n\n";					
	$body1.=   "Searches made today: " . $total_searches . " \n\n";
	$body1.=   "Impressions made today: " . $total . " \n\n";
	
	$body1.= "------------------------------------------------------------- \n\n";
	$body1.= "Thank you.. \n\n";
	$body1.= "My Namibia \n";	
	$this->email->message($body1); 
	//$this->email->attach('./img/icons/logo.png');
	$this->email->send();	

}

}
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */
?>