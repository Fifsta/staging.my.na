<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Map extends CI_Controller {

	function map()
	{
		parent::__construct();
		$this->load->model('map_model');
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAP HOME
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function index()
	{

		$this->load->view('map/map');
		
	}

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //MAP HOME
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function test()
    {

        $this->load->view('map/test');

    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //CATEGORY TYPEAHEAD
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function category_typehead()
    {

        $this->map_model->category_typehead();
    }


    //++++++++++++++++++++++++++++++
    //Instant Search
    //++++++++++++++++++++++++++++++
    public function ajax_search_json()
    {
        $this->map_model->instant_search_json();

    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //TEST LOCATION
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function location()
    {

       // $this->load->library('user_agent');
       // $IP = $this->input->ip_address();
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){

            $IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }else{

            $IP = '41.182.24.129'; // Windhoek
            //$IP = '197.233.164.142'; // Walvis;
            //$IP = '105.232.202.207'; //Swakop;
        }
        //$tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$IP.'');
       // var_dump($tags);  // city name

        include(BASE_URL."geoip/geoipcity.inc");

        include(BASE_URL."geoip/geoipregionvars.php");

        $gi = geoip_open(BASE_URL."geoip/GeoLiteCity.dat",GEOIP_STANDARD); //,GEOIP_MEMORY_CACHE

        echo $IP;

        $record = geoip_record_by_addr($gi,$IP);

        //echo $IP;
        $data['city'] = $record->city;
        $data['c_code'] = $record->country_code;
        $data['country'] = $record->country_name;

        var_dump($data);
        //return $data;


        $this->output->enable_profiler(TRUE);



    }


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //GET MAP LOCATION HTML5
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function locate_me()
    {
        $data = '';
        $this->load->view('map/identify_location', $data);
    }


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //UPDATE SESSION WITH LOCATYION
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function update_location()
    {
        if($this->input->post()){
            if($this->input->post('city_sub')){
                $data['city_sub'] = $this->input->post('city_sub');

            }
            if($this->input->post('city')){

                $data['city'] = $this->input->post('city');
            }
            if($this->input->post('region')){

                $data['region'] = $this->input->post('region');

            }
            if($this->input->post('country')){

                $data['country'] = $this->input->post('country');
            }
            if($this->input->post('c_code')){

                $data['c_code'] = $this->input->post('c_code');

            }
            if($this->input->post('lat')){

                $data['lat'] = $this->input->post('lat');

            }
            if($this->input->post('lon')){

                $data['lon'] = $this->input->post('lon');

            }
            $this->session->set_userdata($data);
            //var_dump($this->input->post());
        }


    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //GEOLOCATION
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function geolocation()
    {


        $this->load->library('geolocation');

        $result = $this->geolocation->getAddress(51.0363935, 3.7121008);
        //var_dump($this->geolocation);
        // define result
        echo 'Address = ' . $result['label'] . '<br/>';
        //$this->output->enable_profiler(TRUE);



    }

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAP HOME
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	public function results($cat = '', $type = '', $l_id = 0, $loc = '')
	{
		echo $this->map_model->get_business_results($cat, $type, $l_id, $loc);
		
	}

    public function results_ajax()
    {


        $cat = $this->input->post('cat', true);
        $type = '';
        $l_id = 0;
        $loc = '';

        echo $this->map_model->get_business_results($cat, $type, $l_id, $loc);
        
    }


	function url_encode($string){
        return urlencode(utf8_encode(  str_replace('(','_', str_replace(')','~',$string))));
    }
    
    function url_decode($string){
        return utf8_decode(urldecode(str_replace('_','(', str_replace('~',')',$string))));
    }

	
	public function show_map_info($id, $size ='')
	{
		$this->map_model->show_map_info($id, $size);
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */