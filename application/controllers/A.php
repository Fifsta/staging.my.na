<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class A extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
		$this->load->library('pagination');

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAIN SEARCH POST FUNCTION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function results($offset = '')
	{


		//Get Input
		//SORT
		if (!$this->input->post('sortby')) {
				
			$sort = '';
			$sortURL = 'none';
							
		}else{
								
			$sort = $this->input->post('sortby', TRUE);
			$sortURL = $this->input->post('sortby', TRUE); 					
		}


		$scat = $this->input->post('srch_category', TRUE);

		//Category
		if (!$scat || $scat == 'all') {
				
			$category = '';
			$categoryURL = 'all';
            $c_id = 'all';
            $c_type = 'all';
			$main_cat_id = 'all';
			$main_category = 'all';
			$main_categoryURL = 'all';

		}else{
								
			$c = $this->input->post('srch_category', TRUE);
			$t = json_decode($c);
			$c_id = $t->cat_id;
			$c_type = $t->c_type;
			$category = $t->cat_name;
			$main_cat_id = $t->main_cat_id;
			$main_category = $t->main_cat_name;
			$categoryURL = $this->url_encode(trim($category));
			$main_categoryURL = $this->url_encode(trim($main_category));
						
		}

		//Location
		if (!$this->input->post('srch_location')) {
				
			$location = '';
			$locationURL = 'all';
            $l_id = 'national';
							
		}else{

            $l = $this->input->post('srch_location', TRUE);
            $l_id = substr($l,0,strpos($l, '_'));
            $location = substr($l,strpos($l, '_')+1, strlen($l));
			$locationURL = $this->url_encode(trim($location));
								
		}
		//Location
		if (!$this->input->post('srch_business')) {
				
			$business = '';
			$businessURL = 'all';
							
		}else{
								
			$business = $this->input->post('srch_business', TRUE);
			$businessURL = $this->url_encode($business);					
		}

		if(trim($c_type) == 'main'){
			
			if($l_id == 'national'){
				$l_id = 'all';
				$locationURL = 'namibia';
					
			}else{
				$l_id = $l_id;
				$locationURL = $locationURL;
			}
			//PAGINATION

			$config['base_url'] = site_url('/'). 'a/d/'.$main_cat_id.'/'.$main_categoryURL.'/'.$l_id.'/'.$locationURL.'/'.$businessURL.'/'.$sortURL.'/';
		}else{

			//PAGINATION
			$config['base_url'] = site_url('/'). 'a/show/'.$main_cat_id.'/'.$main_categoryURL.'/'.$c_id.'/'.$categoryURL.'/'.$l_id.'/'.$locationURL.'/'.$businessURL.'/'. $sortURL;
			
		}
		
		
        //echo $location.' <br />'.$category.'<br />' .$c_type.'- <br />'.$business.' <br />'.$config['base_url'];


		redirect($config['base_url']);

	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAIN SEARCH POST FUNCTION PAGINATION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function show()
	{
		//Get Input
		$limit = 10;
  		$offset = ($this->uri->segment(11));
  		$offsetorg = ($this->uri->segment(11));
		//$x = $this->uri->segment(3);
		//MAIN CATS
		if($main_cat_id = $this->url_decode($this->uri->segment(3))){
            //NO CATEGORY BUT ID THEN 301 redirect
            if(!$main_category = $this->url_decode($this->uri->segment(4))) {

                $main_category = $this->search_model->get_main_category_name($main_cat_id);
                redirect(site_url('/').'a/d/'.$main_cat_id.'/'.$this->url_encode($main_category) , 301);
            }
			
			//REDIRECT TO TOP LEVEL CATEGRY
			if(!$this->uri->segment(5)){
				redirect(site_url('/').'a/d/'.$main_cat_id.'/'.$this->url_encode($main_category) , 301);
			}
        }else{
            $main_cat_id = 'all';

        }
        if($main_category = $this->url_decode($this->uri->segment(4))) {

        }else{
            $main_category = 'all';

        }
		//SUB CATS
        if($c_id = $this->url_decode($this->uri->segment(5))){
            //NO CATEGORY BUT ID THEN 301 redirect
            if(!$category = $this->url_decode($this->uri->segment(6))) {

                $category = $this->search_model->get_category_name($c_id);
                redirect(site_url('/').'a/show/'.$main_cat_id.'/'.$this->url_encode($main_category).'/'.$c_id.'/'.$this->url_encode($category) , 301);
            }
        }else{
            $c_id = 'all';

        }
        if($category = $this->url_decode($this->uri->segment(6))) {

        }else{
            $category = 'all';

        }
        if($l_id =  $this->url_decode($this->uri->segment(7))) {
            //NO LOCATION BUT ID THEN 301 redirect
            if(!$location =  $this->url_decode($this->uri->segment(8))){

                $location = $this->search_model->get_location_by_id($l_id);
				redirect(site_url('/').'a/show/'.$main_cat_id.'/'.$this->url_encode($main_category).'/'.$c_id.'/'.$this->url_encode($category).'/'.$l_id.'/'.$this->url_encode($location)  , 301);
    
            }
        }else{

            $l_id = 'all';
        }
		if($location =  $this->url_decode($this->uri->segment(8))){


        }else{
            $location = 'all';

        }
		if($business =  $this->url_decode($this->uri->segment(9))) {

        }else{
            $business = 'all';

        }
  		if($sortURL = $this->uri->segment(10)){


        }else{
            $sortURL = 'none';

        }
		
		if($sortURL == 'none'){
			
			$sort = '';
		
		}else{
			
			$sort = $sortURL;
		
		}
		
		// 1 - All 3
		if(($category != 'all') && ($location != 'all') && ($business != 'all')){

            $data['heading'] = $category.' in '. $location . ' - '. $business;
            $data['query'] = $this->search_model->get_cat_loc_bus($category, $c_id, $location, $l_id ,$business, $limit, $offset, $sort);
            $count = $this->search_model->Cget_cat_loc_bus($category, $c_id, $location, $l_id ,$business);
			//$data['queryA'] = $this->search_model->Aget_cat_loc_bus($category, $location ,$business, $limit, $offset);
            $data['businessT'] = $category . ' Businesses: '.$business;
            $data['locationT'] = $location;
		// 2 - Category & Location
		}elseif(($category != 'all') && ($location != 'all')){
			
			$data["heading"] = $category. " in " . $location;
			$data['query'] = $this->search_model->get_cat_loc($category, $c_id, $location, $l_id , $limit, $offset, $sort);
			$count = $this->search_model->Cget_cat_loc($category, $c_id, $location, $l_id);
			//$data['queryA'] = $this->search_model->Aget_cat_loc($category, $location);
            $data['businessT'] = $category;
            $data['locationT'] = $location;
		// 3 - Category & business
		}elseif(($category != 'all') && ($business != 'all')){
			
			$data['heading'] = $category . ' - in Namibia - '. $business;
			$data['query'] = $this->search_model->get_cat_bus($category, $c_id ,$business, $limit, $offset, $sort);
			$count = $this->search_model->Cget_cat_bus($category, $c_id,$business);
			//$data['queryA'] = $this->search_model->Aget_cat_bus($category ,$business);
            $data['businessT'] = $category . ' Businesses: '.$business;
            $data['locationT'] = 'Namibia';
		// 4 - Location & Business
		}elseif(($location != 'all') && ($business != 'all')){
			
			$data['heading'] = $business . ' in '. $location;
			$data['query'] = $this->search_model->get_loc_bus($location, $l_id  ,$business, $limit, $offset, $sort);
			$count = $this->search_model->Cget_loc_bus($location, $l_id  ,$business);
			//$data['queryA'] = $this->search_model->Aget_loc_bus($location ,$business);
            $data['businessT'] = 'Businesses: '.$business;
            $data['locationT'] = $location;
		// 5 - Only Location
		}elseif(($location != 'all')){
			
			$data['heading'] = 'Businesses in '. $location;
			$data['query'] = $this->search_model->get_loc($location, $l_id , $limit, $offset, $sort);
			$count = $this->search_model->Cget_loc($location, $l_id );
			//$data['queryA'] = $this->search_model->Aget_loc($location);
            $data['businessT'] = 'Businesses';
            $data['locationT'] = $location;
			
		// 6 - Only category
		}elseif(($category != 'all')){
			
			$data['heading'] = $category . ' in Namibia';
			$data['query'] = $this->search_model->get_category($category, $c_id, $limit, $offset, $sort);
			$count = $this->search_model->Cget_category($category, $c_id);
			//$data['queryA'] = $this->search_model->Aget_category($category);
            $data['businessT'] = $category;
            $data['locationT'] = 'Namibia';
			//
		// 7 - Only Business
		}elseif(($business != 'all')){
			
			$data['heading'] = 'Businesses in Namibia Named: '. $business;
			$data['query'] = $this->search_model->get_bus($business, $limit, $offset, $sort);
			$count = $this->search_model->Cget_bus($business);
			//$data['queryA'] = $this->search_model->Aget_bus($business);
            $data['businessT'] = 'Businesses: '.$business;
            $data['locationT'] = 'Namibia';
		// 8 - No Criteria
		}else{
			
			$data['heading'] = 'Businesses in Namibia';
			$data['query'] = $this->search_model->get_all($limit, $offset, $sort);
			$count = $this->search_model->count_get_all();
			//$data['queryA'] = $this->search_model->Aget_all();
            $data['businessT'] = 'Businesses';
            $data['locationT'] = 'Namibia';
		}

        //PAGEINATION PARAMETER
        $pT = '';
        if($offset != ''){

            $pT = ' - Page '.(($offset / $limit) +1);

        }
        $data['heading'] = $data['heading'] .$pT;
		//PAGINATION
		$config['base_url'] = site_url('/'). 'a/show/'.$main_cat_id.'/'.$this->url_encode($main_category).'/'.$c_id.'/'.$this->url_encode($category).'/'.$l_id.'/'.$this->url_encode($location).'/'.$this->url_encode($business).'/'. $sortURL ;
		$config['total_rows'] = $count;
		$config['per_page'] = $limit; 
		$config['num_links'] = 2; 
		//Styling
		$config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
		$config['full_tag_close'] = '</ul></nav>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li class="page-item">';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<i class="fa fa-chevron-left icon-light"></i>';
		$config['prev_tag_open'] = '<li class="page-item prev">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<i class="fa fa-chevron-right icon-light"></i>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] =  '<li class="page-item bg-light text"><a href="#" class="page-link bg-light text-dark">';
		$config['cur_tag_close'] = '</a></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['uri_segment'] = 11;
		$this->pagination->initialize($config);
		
		$data['pages'] = $this->pagination->create_links();
		$data['count'] = $count;
		
		if($location == 'all'){
			
			$location = '';
		
		}
		if($category == 'all'){
			
			$category = '';
		 
		}
		
		if($business == 'all'){
			
			$business = '';
		
		}
		
		$data['locM'] = $location;
		$data['catM'] = $category;
		$data['busM'] = $business;
        $data['l_id'] = $l_id;
        $data['location'] = $location;
        $data['c_type'] = '';
		$data['c_id'] = $c_id;
        $data['category'] = $category;
		$data['main_c_id'] = $main_cat_id;
        $data['main_category'] = $main_category;
        $data['business'] = $business;
        $data['busM'] = $business;
		$data['MAINlocM'] = '0';
		$data['MAINcatM'] = '0';
		$data['sortby'] = $sort;
		$this->load->view('results',$data);
		
	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEARCH  BY CATEGORY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	public function cat($cat_id, $cat_name, $sort = '', $offset = '')
	{
        //GET TOP LEVEL
        $q = $this->db->query("SELECT a_tourism_category_sub.CATEGORY_TYPE_ID, a_tourism_category.CATEGORY_NAME,a_tourism_category.ID
                            FROM a_tourism_category_sub
                            JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
                            WHERE a_tourism_category_sub.ID = '".$cat_id."'"
                            );

        if($q->result()){

            $row = $q->row();
            //echo site_url('/').'a/show/'.$row->ID.'/'.$this->search_model->url_encode($row->CATEGORY_NAME).'/'.$cat_id.'/'. $cat_name.'/';
            redirect(site_url('/').'a/show/'.$row->ID.'/'.$this->search_model->url_encode($row->CATEGORY_NAME).'/'.$cat_id.'/'. $cat_name.'/', 301);


        }else{

            show_404();
        }

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEARCH BY CATEGORY AND LOCATION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function b($cat_id, $cat_name, $location, $offset = '')
	{

        $l_id = $this->search_model->get_category_id($this->url_decode($location));
        redirect(site_url('/').'a/show/'.$cat_id.'/'. $cat_name.'/'.$l_id.'/'.$location);
		
		
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEARCH  BY MAIN CATEGORY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	public function c($cat_id, $cat_name, $sort = '', $offset = '')
	{
		
        redirect(site_url('/').'a/show/'.$cat_id.'/'.$cat_name, 301);

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEARCH  BY MAIN CATEGORY && LOCATION
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	public function d($cat_id, $cat_name,$l_id, $location,$business = 'all', $sort = 'none', $offset = '')
	{


		//Get Input
		$limit = 10;
		//PAGEINATION PARAMETER
		$pT = '';
		if($offset != ''){

			$pT = ' - Page '.(($offset / $limit) +1);

		}
		//$cat_id = $this->uri->segment(3);
	    //$cat_name = $this->uri->segment(5);
		if(!$sort = $this->uri->segment(8)){

            $sort = 'none';
        }
        if(($location == 'all' || $location == 'national' || $location == '' ) ){

            redirect(site_url('/').'a/d/'.$cat_id.'/'.$cat_name.'/all/namibia/'.$business.'/'.$sort.'/'.$offset, 301);
        }

		if($business == 'all'){

			$count = $this->search_model->count_get_cat_main_loc($cat_id,$l_id, $location);
			$data['heading'] = ucwords(str_replace('-',' ', $cat_name)) . ' in ' .ucwords($location)  .$pT;
			$data['query'] = $this->search_model->get_cat_main_loc($cat_id, $limit, $l_id,$location, $offset ,$sort);
		}else{

			$count = $this->search_model->count_get_cat_main_loc_bus($cat_id,$l_id, $location, $business);
			$data['heading'] = ucwords(str_replace('-',' ', $cat_name)) . ' in ' .ucwords($location) .' : '.$business.' ' .$pT;
			$data['query'] = $this->search_model->get_cat_main_loc_bus($cat_id, $limit, $l_id,$location,$business, $offset ,$sort);
		}


        $data['businessT'] = $this->url_encode($cat_name);
        $data['locationT'] = $location;
		//PAGINATION
		$config['base_url'] = site_url('/'). 'a/d/'.$cat_id.'/'.$cat_name.'/'.$l_id.'/'.$location.'/'.$business.'/' . $sort .'/';
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
		$config['uri_segment'] = 9;
		$this->pagination->initialize($config);

		if($business == 'all'){

			$business = '';
		}
		$data['locM'] = '';
		$data['catM'] = '';
		$data['busM'] = '';
		$data['MAINlocM'] = $location;
		$data['MAINcatM'] = $cat_id;
        $data['l_id'] = $l_id;
        $data['location'] = $location;
        $data['c_id'] = 0;
		$data['c_type'] = 'main';
		$data['main_c_id'] = $cat_id;
        $data['category'] = $cat_name;
		$data['main_category'] = $cat_name;
        $data['business'] = $business;
		$data['busM'] = $business;
		$data['sortby'] = $sort;
		$data['pages'] = $this->pagination->create_links();
		$data['count'] = $count;
		$data['str'] = $cat_id . ' '. $offset .' '.$cat_name;
		$this->load->view('results',$data);
		
		
		
	}

	function url_encode($string){
        //URLS +
		//return urlencode(utf8_encode(  str_replace('(','_', str_replace(')','~',$string))));
		return str_replace('%20', '-', rawurlencode(utf8_encode(  str_replace('(','_', str_replace(')','~',$string)))));
    }
    
    function url_decode($string){
        //URLS +
		//return utf8_decode(urldecode(str_replace('_','(', str_replace('~',')',$string))));
		return utf8_decode(rawurldecode(str_replace('-', '%20',str_replace('_','(', str_replace('~',')',$string)))));
    }
	public function home()
	{
		$this->load->view('template');
	}
	
	
	public function show_map_info($id)
	{
		$this->search_model->show_map_info($id);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */