<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A extends CI_Controller {

	function a()
	{
		parent::__construct();
		$this->load->model('search_model');
		$this->load->library('pagination');
		// should put this in the __construct() of this controller or in your MY_Controller.php
   		//$this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		//$this->load->driver('cache', array('adapter'=>'file'));
	}
	
	//GET POST DATA AND REDIRECT
	public function results($offset = '')
	{
		//Get Input
		$category = $this->input->post('category', TRUE);
		$location = $this->input->post('location', TRUE);
		$business = $this->input->post('business', TRUE);
		$limit = 10;
		
		if($offset == ''){
				
			$offset = 0;
				
		}else{
				
			$offset = $offset;
		}
		
		redirect('/a/b/'.$offset.'/'.$category.'/'.$location.'/'.$business.'/', 'location', 301);	
		
	}
	
	public function b($offset = '',$category = '', $location = '', $business = '')
	{
		//Get Input
		
		$limit = 10;
		
		// 1 - All 3
		if(($category != '') && ($location != '') && ($business != '')){
		
			$data['heading'] = 'Businesses in '. $location . ' - '. $business;
			$data['query'] = $this->search_model->get_cat_loc_bus($category, $location ,$business, $limit, $offset);
			$count = $this->search_model->Cget_cat_loc_bus($category, $location ,$business);
			
		// 2 - Category & Location
		}elseif(($category != '') && ($location != '')){
			
			$data["heading"] = $category. " in " . $location;
			$data['query'] = $this->search_model->get_cat_loc($category, $location , $limit, $offset);
			$count = $this->search_model->Cget_cat_loc($category, $location);
			
		// 3 - Category & business
		}elseif(($category != '') && ($business != '')){
			
			$data['heading'] = 'Businesses in Namibia';
			$data['query'] = '';
		
		// 4 - Location & Business
		}elseif(($location != '') && ($business != '')){
			
			$data['heading'] = 'Businesses in Namibia';
			$data['query'] = '';
		
		// 5 - Only Location
		}elseif(($location != '')){
			
			$data['heading'] = 'Businesses in Namibia';
			$data['query'] = '';
		
		// 6 - Only category
		}elseif(($category != '')){
			
			$data['heading'] = 'Businesses in Namibia';
			$data['query'] = '';
		
		// 7 - Only Business
		}elseif(($business != '')){
			
			$data['heading'] = 'Businesses named: '. $business;
			$data['query'] = $this->search_model->get_bus($business, $limit, $offset);
			$count = $this->search_model->Cget_bus($business);
		
		// 8 - No Criteria
		}else{
			
			$data['heading'] = 'Businesses in Namibia';
			$data['query'] = $this->search_model->get_all($limit, $offset);
			$count = $this->search_model->count_get_all(); 	
		}
		
		//PAGINATION
		$config['base_url'] = site_url('/'). 'a/results/';
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 2; 
		//Styling
		$config['full_tag_open'] = '<div class="pagination pull-right"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
		$data['count'] = $count;
		
		$this->load->view('results',$data);
		
		
		
	}
	
	
	

	public function cat($cat_id, $cat_name, $offset = '')
	{
		//Get Input
		$limit = 10;
	
		$cat_id = $this->uri->segment(3);
	    //$cat_name = $this->uri->segment(5);
		//$offset = urldecode($this->uri->segment(5));
		
		$data['query'] = $this->search_model->get_cat($cat_id, $limit, $offset);
		$count = $this->search_model->count_get_cat($cat_id);
		$data['heading'] = ucwords(str_replace('-',' ', $cat_name));
		
		//PAGINATION
		$config['base_url'] = site_url('/'). 'a/cat/'.$cat_id.'/'.$cat_name.'/';
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 2; 
		//Styling
		$config['full_tag_open'] = '<div class="pagination pull-right"><ul>';
		$config['full_tag_close'] = '</ul></div>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="icon-chevron-left"></i>';
		$config['prev_tag_open'] = '<li class="prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="icon-chevron-right"></i>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 5;
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
		$data['count'] = $count;
		$data['str'] = $cat_id . ' '. $offset .' '.$cat_name;
		$this->load->view('results',$data);
		
		
		
	}
	
	
	
	
	public function home()
	{
		$this->load->view('template');
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */