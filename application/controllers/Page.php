<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page extends CI_Controller {

	/**
	 * My Na Page for this controller.
	 *Roland ihms
	 *
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
	
	}
	
	public function index()
	{
		
	}

	
	public function i($slug)
	{
		
		$this->db->where('slug',$slug);
		$page = $this->db->get('pages');
		
		if($page->num_rows() > 0){
			
			$page = $page->row_array();
		    $this->load->view('page', $page);
		
		}else{
			
			redirect(site_url('/'),'location',301);
			
		}
		
	}
	
	public function home()
	{
		$this->load->model('search_model');
		$this->load->view('template');
	}
	
	//CLEAN URL

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//IGNORE', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}


	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */