<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Classifieds extends CI_Controller {

	/**
	 * Index Controller for Classified.
	 *
	 * Roland Ihms
	 */
	function __construct()
	{
		parent::__construct();

		$this->load->model(array('classifieds_model','search_model','my_na_model'));
	
	}
	

	
//+++++++++++++++++++++++++++
    //CAREERS LANDING ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function index()
	{

         $this->results();
		 
	}
	
	
	//+++++++++++++++++++++++++++
    //CAREERS SINGLE JOB/VACANCY
    //++++++++++++++++++++++++++
	public function view($id, $slug = '')
	{

		$this->load->database();

		$sql = "SELECT classifieds.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			cat.cat_name ,a_map_location.MAP_LOCATION as location,a_map_location.ID as location_id,group_concat(pub.bus_id) as pubs
					
		 			FROM classifieds 
		 			LEFT JOIN u_business ON u_business.ID = classifieds.bus_id
					LEFT JOIN classifieds_categories as cat ON cat.cl_cat_id = classifieds.cl_cat_id
					LEFT JOIN a_map_location ON a_map_location.ID = classifieds.location_id
					LEFT JOIN classifieds_publication_int as pub ON pub.classified_id = classifieds.classified_id
		 			WHERE classifieds.classified_id = ".$id."
					GROUP BY classifieds.classified_id
					LIMIT 1";
		$res = $this->db->query($sql, true);		

		if($res->result()){

			$data['row'] = $res->row();
			//$o = $this->classifieds_model->render_classifieds($res);
			//$data['html'] = $o;
			$this->load->view('classifieds/single', $data);
			
		}else{
			
			
			show_404();	
		}
		
	}
	
	
    //+++++++++++++++++++++++++++++++++
    //CLASSIFIED LANDING ? RESULTS PAGE
    //+++++++++++++++++++++++++++++++++

	public function get_latest()
	{ 

         $query = $this->classifieds_model->get_classifieds();

		 $count = 0;

		 if($query['query']->result()){
			
			 $row = $query['query']->row();
			 $count = $row->total_rows; 
			 
		 }

		 $o = $this->classifieds_model->render_latest_classifieds($query['query']);
		
		 /*$this->output
	        ->set_content_type('application/json')
	        ->set_output(json_encode(array('classifieds' => $o)));*/

	    return $o;    
	
	}

	
    //+++++++++++++++++++++++++++
    //CAREERS LANDING ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function results()
	{ 
		 

		 $query = $this->classifieds_model->get_classifieds();
		 $count = 0;
		 if($query['query']->result()){
			
			 $row = $query['query']->row();
			 $count = $row->total_rows; 
			 
		 }
		 
		$o = $this->classifieds_model->render_classifieds($query['query'], '3');
		$data['html'] = $o;
		$data['cat_name'] = $query['cat_name'];
		$data['cl_cat_id'] = $query['cl_cat_id'];
		$data['location'] = $query['location'];
		$data['location_id'] = $query['location_id'];
		$data['q'] = $query['q'];
		$config['base_url'] = site_url('/'). 'classifieds/results/?q='.$query['q'].'&sortby=&cl_cat_id='.$query['cl_cat_id'].'&cat_name=&location='.$query['location_id'].'&location_text='.$query['location'];
		$config['total_rows'] = $count;
		$config['per_page'] = $query['limit']; 
		$config['num_links'] = 2; 
		$config['page_query_string'] = true;
		$config['query_string_segment'] = 'offset';
		//Styling 
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = false;
		$config['last_link'] = false; 
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-chevron-left text-dark"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right text-dark"></i>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="page-item bg-light text"><a href="#" class="page-link bg-light text-dark">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
		 
        $this->load->view('classifieds/results', $data);

	}
	
	

	//++++++++++++++++++++++++++++++
	//PREFETCH TYPEHEAD
	//++++++++++++++++++++++++++++++
	public function build_typehead($type = '', $cat = '')
	{
		echo $this->classifieds_model->load_typehead($type, $cat);

	}

	
}

/* End of file Classified.php */
/* Location: ./application/controllers/Classified.php */