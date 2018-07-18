<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Careers extends CI_Controller {

	/**
	 * Members Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 

	function __construct()
	{
		parent::__construct();
        $this->load->model(array('vacancy_model', 'search_model', 'business_model'));
	}	
	

	function delete_applicant() {

		$doc_file =  'https://d3rp5jatom3eyn.cloudfront.net/assets/vacancies/documents/cv/Marusca%20Goliath.pdf'; # build the full path
		if (file_exists($doc_file)) {
			unlink($doc_file);
		}

	}

    //+++++++++++++++++++++++++++
    //CAREERS LANDING ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function index()
	{

         $query = $this->vacancy_model->get_jobs(true);
	     $o = $this->vacancy_model->render_jobs_slider($query['query'], '12');
		 $data['html'] = $o;
		 $data['sub_cat_name'] = $query['sub_cat_name'];
		 $data['sub_cat_id'] = $query['sub_cat_id'];
		 $data['location'] = $query['location'];
		 $data['location_id'] = $query['location_id'];
         $this->load->view('career/landing', $data);
		 

	}
	
	
	//+++++++++++++++++++++++++++
    //CAREERS SINGLE JOB/VACANCY
    //++++++++++++++++++++++++++
	public function job($id, $slug = '')
	{
		$sql = "SELECT vacancies.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			maincat.category_name as main_cat, subcat.category_name as sub_cat,subsubcat.category_name as sub_sub_cat,subsubsubcat.category_name as sub_sub_sub_cat
		 			FROM vacancies 
		 			LEFT JOIN u_business ON u_business.ID = vacancies.bus_id
					LEFT JOIN product_categories as maincat ON maincat.cat_id = vacancies.main_cat_id
					LEFT JOIN product_categories as subcat ON subcat.cat_id = vacancies.sub_cat_id
					LEFT JOIN product_categories as subsubcat ON subsubcat.cat_id = vacancies.sub_sub_cat_id
					LEFT JOIN product_categories as subsubsubcat ON subsubsubcat.cat_id = vacancies.sub_sub_sub_cat_id
		 			WHERE type = 'public' AND vacancy_id = ".$id."
					LIMIT 1";
		$res = $this->db->query($sql, true);		

		if($res->result()){

			$data['row'] = $res->row();
			$o = $this->vacancy_model->render_jobs($res);
			$data['html'] = $o;
			$this->load->view('career/single', $data);
			
		}else{
			
			
			show_404();	
		}
		
	}
	
    //+++++++++++++++++++++++++++
    //CAREERS LANDING ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function results()
	{
		 //if($this->input->get_post('');
		 
		 $query = $this->vacancy_model->get_jobs();
		 $count = 0;
		 if($query['query']->result()){
			
			 $row = $query['query']->row();
			 $count = $row->total_rows; 
			 
		 }
		 
		 $o = $this->vacancy_model->render_jobs($query['query'], '6');
		 $data['html'] = $o;
		 $data['sub_cat_name'] = $query['sub_cat_name'];
		 $data['sub_cat_id'] = $query['sub_cat_id'];
		 $data['location'] = $query['location'];
		 $data['location_id'] = $query['location_id'];
		 
	    $config['base_url'] = site_url('/'). 'careers/results/?q='.$query['q'].'&sortby=&sub_cat_id='.$query['sub_cat_id'].'&sub_cat_name=&location='.$query['location_id'].'&location_text='.$query['location'];
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
		//$config['uri_segment'] = 11;
		
		$this->load->library('pagination');
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
		 
        $this->load->view('career/results', $data);

	}
	
	

	//++++++++++++++++++++++++++++++
	//PREFETCH TYPEHEAD
	//++++++++++++++++++++++++++++++
	public function build_typehead($type = '', $cat = '')
	{
		echo $this->vacancy_model->load_typehead($type, $cat);

	}



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */