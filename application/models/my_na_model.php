<?php
class My_model extends CI_Model{

    public function __construct()
    {
  		//parent::CI_model();
			
 	}
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET NAMIBIAN NEWS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 public function get_namibian_stories($offset = 0, $limit = 10, $type = ''){

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('namibian_news_'.$type))
        {
			$this->load->model('news_model');
			if($output = $this->news_model->get_namibian_stories($offset = 0, $limit = 10, $type = '')){
				
				$this->cache->save('namibian_news_'.$type, $output, 3600);
			}else{
				
				
			}
           
			
		}
		 echo $output;
	
	}
	
	
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET LOCATION FROM IP
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	 public function get_ip_location(){


            if($country = $this->session->userdata('country')){
				
				$data['city'] = $this->session->userdata('city');
				$data['c_code'] = $this->session->userdata('c_code');
                $data['lat'] = $this->session->userdata('lat');
                $data['lon'] = $this->session->userdata('lon');
				$data['country'] = $country;
				return $data;
				
			}else{

                if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])){

                    $IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
                }else{

                    $IP = '41.182.24.129'; // Windhoek
                    //$IP = '105.232.202.207'; //Swakop;
                }
				include(BASE_URL."geoip/geoipcity.inc");
	
				include(BASE_URL."geoip/geoipregionvars.php");
	
				$gi = geoip_open(BASE_URL."geoip/GeoLiteCity.dat",GEOIP_STANDARD,GEOIP_MEMORY_CACHE);

				$record = geoip_record_by_addr($gi,$IP);
                //var_dump($record);
                //echo $IP;
				$data['city'] = $record->city;
				$data['c_code'] = $record->country_code;
				$data['country'] = $record->country_name;
                if($record->country_code == 'na' && $record->city != null){

                    $data['lon'] = $record->longitude;
                    $data['lat'] = $record->latitude;

                }else{
                    $data['lon'] = null;
                    $data['lat'] = null;

                }

				$this->session->set_userdata($data);
				return $data;
				
			}

		
	}

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET WEATHER
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_weather_report($time = ''){

        	
			$location = $this->get_ip_location();
            $this->load->model('weather_model');
            return $this->weather_model->get_weather($location['city'], $location['c_code'], $time);
            
       
    }
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET LOCAL LINKS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    public function get_local_links(){

			
			$location = $this->get_ip_location();
			$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

			
            //LOCAL IS LEKKER
/*			if($location['lat'] != null && $location['lon'] != null && $location['c_code'] == 'NA') {
                // if (!$output = $this->cache->get('local_results_' . $location['city'])) {
                //echo $location['city'];

                    $output = $location['lat'] .' '. $location['lon'];

                    $SQL = "SELECT *,(((acos(sin((" . $location['lat'] . "*pi()/180)) *
                                                    sin((BUSINESS_MAP_LATITUDE*pi()/180))+cos((" . $location['lat'] . "*pi()/180)) * cos((BUSINESS_MAP_LATITUDE*pi()/180)) * cos(((" . $location['lon'] . " - BUSINESS_MAP_LONGITUDE)*pi()/180))))*180/pi())*60*1.1515)
                                                    as distance
                                                    FROM u_business
                                                    JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
                                                    HAVING distance < 20
                                                    ORDER by distance";
                    $main = $this->db->query("SELECT u_business.*,(((acos(sin((" . $location['lat'] . "*pi()/180)) *
                                                    sin((BUSINESS_MAP_LATITUDE*pi()/180))+cos((" . $location['lat'] . "*pi()/180)) * cos((BUSINESS_MAP_LATITUDE*pi()/180)) * cos(((" . $location['lon'] . " - BUSINESS_MAP_LONGITUDE)*pi()/180))))*180/pi())*60*1.1515)
                                                    as distance
                                                    FROM u_business
                                                    JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
                                                    HAVING distance < 1
                                                    ORDER by distance LIMIT 10", FALSE);


                    $output .= $SQL.'<h4 class="yellow na_script upper">Current Location Not Found</h4>';




                //$this->cache->save('local_results_' . $location['city'], $output, 3600);
                //}

            //CITY
            }else*/

            if($location['country'] == 'Namibia' && $location['city'] != null){



                if (!$output = $this->cache->get('local_results_' . $location['city'])) {
                    //echo $location['city'];
                    $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), u_business.BUSINESS_NAME,
										COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category_sub.*
										FROM i_tourism_category
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN u_business ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
										WHERE a_map_location.MAP_LOCATION LIKE '%" . $location['city'] . "'
										GROUP BY i_tourism_category.CATEGORY_ID
										ORDER BY num DESC
										LIMIT 5", FALSE);
                    $output = '';
                    if ($main->result()) {
                        $output .= '<h4 class="yellow na_script upper">Local Results in ' . $location['city'] . '</h4>';
                        foreach ($main->result() as $row) {
                            $output .= '<a class="btn white_back na_script upper"
								href="' . site_url('/') . 'a/d/' . $row->CATEGORY_TYPE_ID . '/' . $this->clean_url_str($row->CATEGORY_NAME) . '/' . $location['city'] . '" style="margin:5px">
								 ' . $row->CATEGORY_NAME . ' <i class="icon-chevron-right"></i></a>';


                        }
                    }
                    $output .= '<a class="btn white_back na_script upper"
                                href="javascript:void(0)" onclick="locate_me()" style="margin:5px">
                                Locate Me <i class="icon-map-marker"></i></a>';
                    $this->cache->save('local_results_' . $location['city'], $output, 3600);
                }


            //NATIONAL
            }elseif($location['c_code'] == 'NA'){

                if (!$output = $this->cache->get('local_results_' . $location['c_code'])) {
                    //echo $location['city'];
                    $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), u_business.BUSINESS_NAME,
										COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category_sub.*
										FROM i_tourism_category
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN u_business ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
										WHERE a_map_location.MAP_LOCATION LIKE '%" . $location['city'] . "'
										GROUP BY i_tourism_category.CATEGORY_ID
										ORDER BY num DESC
										LIMIT 5", FALSE);
                    $output = '';
                    if ($main->result()) {
                        $output .= '<h4 class="yellow na_script upper">Local Results in Namibia</h4>';
                        foreach ($main->result() as $row) {
                            $output .= '<a class="btn white_back na_script upper"
								href="' . site_url('/') . 'a/d/' . $row->CATEGORY_TYPE_ID . '/' . $this->clean_url_str($row->CATEGORY_NAME) . '/' . $location['city'] . '" style="margin:5px">
								 ' . $row->CATEGORY_NAME . ' <i class="icon-chevron-right"></i></a>';


                        }
                    }
                    $output .= '<a class="btn white_back na_script upper"
                                href="javascript:void(0)" onclick="locate_me()" style="margin:5px">
                                Locate Me <i class="icon-map-marker"></i></a>';
                    $this->cache->save('local_results_' . $location['c_code'], $output, 3600);
                }

             //INTERNATIONAL
			}else{
				
				if ( ! $output = $this->cache->get('international_results_'))
				{
				
					$main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), u_business.BUSINESS_NAME,
										COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category_sub.* 
										FROM i_tourism_category 
										JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
										JOIN u_business ON i_tourism_category.BUSINESS_ID = u_business.ID
										JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID  
										GROUP BY i_tourism_category.CATEGORY_ID 
										ORDER BY num DESC 
										LIMIT 5", FALSE);
					$output = '';
					 if($main->result()){
							$output .= '<h4 class="yellow na_script upper">Local Results</h4>'; 
							foreach($main->result() as $row){
								$output .= '<a class="btn white_back na_script upper" 
								href="'.site_url('/').'a/cat/'.$row->CATEGORY_TYPE_ID.'/'.$this->clean_url_str($row->CATEGORY_NAME).'/'.'" 
								style="margin:5px">
								 '.$row->CATEGORY_NAME.' <i class="icon-chevron-right"></i></a>';
								
								
							}
					 }
					
									
					$this->cache->save('international_results_', $output, 3600);
				}
				
				
			}
		echo $output;
       
    }


    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET POPULAR CATS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function show_popular_cats($type){

        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('popular_cats_'.$type))
        {
            
			$this->load->model('search_model');
			//$output = '';
            $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), COUNT(i_tourism_category.CATEGORY_ID) as num, a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME,
                                    a_tourism_category_sub.* FROM i_tourism_category 
									JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID 
									JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID 
									GROUP BY i_tourism_category.CATEGORY_ID ORDER BY num DESC LIMIT 20", FALSE);


            foreach($main->result() as $row){

                    $main_id = $row->CATEGORY_TYPE_ID;
					$cat_id = $row->ID;
					$cat_name = $row->CATEGORY_NAME;
                    $main_name = $row->MAIN_CAT_NAME;
                    if($type === true) {

                        $output .= '<li><a href="' . site_url('/') . 'a/show/' . $main_id . '/' . $this->search_model->clean_url_str($main_name) . '/'. $cat_id . '/' . $this->search_model->clean_url_str($cat_name) . '"> ' . $cat_name . '</a></li>';


                    }else{
                        $output .= '<a class="btn white_back na_script upper" href="'. site_url('/') . 'a/show/' . $main_id . '/' . $this->search_model->clean_url_str($main_name) . '/'. $cat_id . '/' . $this->search_model->clean_url_str($cat_name) . '" style="margin:5px" id="'.$main_id.'-m_cat"> '.$cat_name.' <i class="icon-chevron-right"></i></a>';


                    }
                    //echo '<a class="btn" onclick="load_sub_cats('.$row->ID.')" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';

            }

            $this->cache->save('popular_cats_'.$type, $output, 172800);
        }else{

            echo $output;

        }
        //return $this->output->set_output($output);
        //echo $output;

    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET USER AVATAR
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_countries($selected = '', $tel = false, $select = false, $class = '', $id = '')
    {

        $q = $this->db->get('country');

        if($select){

            if($tel){

                echo '<select class="'.$class.'" name="'.$id.'"  id="'.$id.'">';
                foreach($q->result() as $row){

                    if($selected == $row->phonecode){

                        echo '<option value="'.strtolower($row->phonecode).'" selected>'.$row->nicename.' +'.$row->phonecode.'</option>';
                    }else{

                        echo '<option value="'.strtolower($row->phonecode).'">'.$row->nicename.' +'.$row->phonecode.'</option>';
                    }


                }
                echo '</select>';

            }else{
                echo '<select class="'.$class.'"  id="'.$id.'">';
                foreach($q->result() as $row){


                    echo '<option value="'.strtolower($row->iso).'">'.$row->nicename.'</option>';

                }
                echo '</select>';


            }




        }else{

            $code = $this->session->userdata('c_code');
            //echo $code;
            if($code == ''){

                $code = 'NA';
            }
            $found = false;
            //BUILD CURRENT VALUE
            foreach($q->result() as $row1){

                //OVERRIDE FOR PROVIDED C_CODE
                if($selected != '' && $selected != 0){

                    if($selected == $row1->phonecode )
                    {

                        echo '<input type="hidden" id="dial_code"  name="dial_code"  value="' . $row1->phonecode . '">
                            <div class="btn-group">
                              <button class="btn" id="fl_select"><img src="' . base_url('/') . 'img/blank.gif" class="flag flag-' . strtolower($row1->iso) . '" > +' . $row1->phonecode . ' </button>
                              <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" style="max-height:200px;overflow-y: scroll; overflow-x: hidden" role="menu" aria-labelledby="dLabel">';
                        $found = true;

                    }
                }elseif($row1->iso == $code){
                   
                    echo '<input type="hidden" id="dial_code"  name="dial_code"  value="'.$row1->phonecode.'">
                            <div class="btn-group">
                              <button class="btn" id="fl_select"><img src="'.base_url('/').'img/blank.gif" class="flag flag-'.strtolower($row1->iso).'" > +'.$row1->phonecode.' </button>
                              <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" style="max-height:200px;overflow-y: scroll; overflow-x: hidden" role="menu" aria-labelledby="dLabel">';
                    $found = true;

                }



            }

            if(!($found)){
                echo '<input type="hidden" id="dial_code"  name="dial_code"  value="264">
                        <div class="btn-group">
                              <button class="btn" id="fl_select">+264 <img src="'.base_url('/').'img/blank.gif" class="flag flag-na" ></button>
                              <button class="btn dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu" style="max-height:200px;overflow-y: scroll; overflow-x: hidden" role="menu" aria-labelledby="dLabel">';

            }

            foreach($q->result() as $row){


                echo '<li role="presentation">
                            <a id="fl_select_'.$row->id.'" href="javascript:select_country('.$row->id.');" data-phone="'.$row->phonecode.'" data-code="'.strtolower($row->iso).'" tabindex="-1">
                                <img src="'.base_url('/').'img/blank.gif" class="flag flag-'.strtolower($row->iso).'" > '.$row->nicename.' +' .$row->phonecode.'
                            </a>
                      </li>';

            }
            echo '</ul>
                </div>
                <script>

                    function select_country(id){


                        var sl = document.getElementById("fl_select_"+id),
                        but = document.getElementById("fl_select"),
                        dial = document.getElementById("dial_code"),
                        code = sl.getAttribute("data-code"),
                        phone = sl.getAttribute("data-phone"),
                        out = "<img src='."'".base_url('/')."img/blank.gif' class='flag flag-".'"+code+"'."'".'> +"+phone;
                        but.innerHTML = out;
                        dial.value = phone;



                    }
                </script>
                ';

        }



    }
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER AVATAR
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_user_avatar($w, $h){
		
		 if($this->session->userdata('id')){ 
			 		
				$img_file = $this->session->userdata('img_file');
				
				if(strstr($img_file, "http")){
					
					$img = $img_file;
				
				}elseif($img_file != ''){ 
				
					$img = base_url('/').'assets/users/photos/'.$img_file;
					
				}else{
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}
				
				//$avatar = '<img src="'.base_url('/').'img/timbthumb.php?src='.base_url('/').$img.'&q=100&w='.$w.'&h='.$h.'" class="img-polaroid" />';
				$avatar = '<img src="'.$img.'" style="width:'.$w.'px;height:'.$h.'px;margin:-5px 5px 5px 0px;padding:1px" class="img-polaroid pull-left" />';
				return $avatar;
		 }
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER AVATAR URL STRING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_user_avatar_str($w, $h){
		
		 if($this->session->userdata('id')){ 
			 		
				$img_file = $this->session->userdata('img_file');
				
				if(strstr($img_file, "http")){
					
					$img = $img_file.'?width='.$w.'&height='.$h;
				
				}elseif($img_file != ''){ 
				
					$img = base_url('/').'assets/users/photos/'.$img_file;
					
				}else{
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}
				
				//$avatar = base_url('/').'img/timbthumb.php?src='.base_url('/').$img.'&q=100&w='.$w.'&h='.$h;
				$avatar = $img;
				return $avatar;
		 }
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER AVATAR URL STRING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_user_avatar_id($id ,$w, $h, $img = ''){


			if($img == ''){


				$this->db->from('u_client');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();

				if($query->result())
				{

					$img_file = $row['CLIENT_PROFILE_PICTURE_NAME'];
				}else{

					$img_file = '';
				}

			}else{
				$img_file = $img;

			}

			if(strstr($img_file, "http")){

				$img = $img_file.'?width='.$w.'&height='.$h;

			}elseif($img_file != ''){

				$img = base_url('/').'assets/users/photos/'.$img_file;

			}else{

				$img = base_url('/').'img/user_blank.jpg';

			}

			//$avatar = base_url('/').'img/timbthumb.php?src='.base_url('/').$img.'&q=100&w='.$w.'&h='.$h;
			$avatar = $img;
			return $avatar;


	}

    //++++++++++++++++++++++++++++++++++++++++++++
    //
    //GET BUSINESSESES
    //++++++++++++++++++++++++++++++++++++++++++++


    function get_businesses($current = 0, $typestr ='', $auction = '')
    {
        $id = $this->session->userdata('id');
        //
        $query = $this->db->query("SELECT u_business.*,i_client_business.CLIENT_ID FROM u_business
                                    JOIN i_client_business ON u_business.ID = i_client_business.BUSINESS_ID
                                    WHERE i_client_business.CLIENT_ID = '".$id."'
                                    ");
        $type ='sell/index/';
        if($typestr == 'my_trade'){

            $type ='sell/my_trade/';

        }

        $output = '';
        $c = false;
        if($query->result()){
            $x = 0;$x1 = 0;$x2 = 0;

            foreach($query->result_array() as $row1) {

                if($current == $row1['ID']){

                    $output .= '<img src="'. $this->my_na_model->get_business_logo($row1['ID'], 60, 60, $row1['BUSINESS_LOGO_IMAGE_NAME']).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                      ';

                    $output .= '<div class="btn-group">
                                  <a class="btn dropdown-toggle  btn-inverse" data-toggle="dropdown" href="#">
                                     '.$row1['BUSINESS_NAME'].'
                                    <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu text-left">';

                    $c = true;
                }

                $x1 ++;
            }

            if($c === false){
                foreach($query->result_array() as $row2) {

                    if($x2 == 0){

                        $output .= '<img src="'. $this->my_na_model->get_business_logo($row2['ID'], 60, 60, $row2['BUSINESS_LOGO_IMAGE_NAME']).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                      ';

                        $output .= '<div class="btn-group">
                                  <a class="btn dropdown-toggle  btn-inverse" data-toggle="dropdown" href="#">
                                     '.$row2['BUSINESS_NAME'].'
                                    <span class="caret"></span>
                                  </a>
                                  <ul class="dropdown-menu text-left">';

                    }

                    $x2 ++;
                }


            }

            foreach($query->result_array() as $row){

                //$output .= '<li><a href="javascript:void(0)" onclick="">'.$row['BUSINESS_NAME'].'</a></li>';

                $output .= '<li><a href="'.site_url('/').$type.$row['ID'].'/?'.$auction.'" onclick="">'.$row['BUSINESS_NAME'].'</a></li>';


                $x++;

            }
            $output .= '</ul>
                     </div> ';



        }else{


           $output .= '<img src="'. base_url('/').'img/bus_blank.jpg" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                        <div class="btn-group">
                            <a class="btn btn-inverse">
                             No Businesses
                            </a>
                        </div>
                            ';


        }
        return $output;

    }

    //++++++++++++++++++++++++++++++++++++++++++++
    //GET BUSINESSESES DROPDOWN MENU
    //++++++++++++++++++++++++++++++++++++++++++++


    function get_businesses_nav()
    {
        $id = $this->session->userdata('id');

        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('clients/business_nav'.$id)) {
                $query = $this->db->query("SELECT u_business.*,i_client_business.CLIENT_ID FROM u_business
                                            JOIN i_client_business ON u_business.ID = i_client_business.BUSINESS_ID
                                            WHERE i_client_business.CLIENT_ID = '" . $id . "'
                                            ");

                $output = '';

                if ($query->result()) {
                    $x = 0;
                    $x1 = 0;
                    $x2 = 0;
                    $output .= '<li class="nav-header">My Business</li>';
                    foreach ($query->result_array() as $row) {
                        $output .= '<li><a href="' . site_url('/') . 'members/business/' . $row['ID'] . '/?">' . $this->shorten_string($row['BUSINESS_NAME'], 5) . '</a></li>';
                        $x++;
                    }

                }
                $this->cache->save('clients/business_nav'.$id, $output, 3600);
        }
        return $output;

    }

	//++++++++++++++++++++++++++++++++++++++++++++
	//GET BUSINESS LOGO
	//++++++++++++++++++++++++++++++++++++++++++++

	function get_business_logo($id, $w, $h, $img){


		if($id != '0'){

			if($img == ''){

				$this->db->from('u_business');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();

				if($query->result())
				{

					$img = $row['BUSINESS_LOGO_IMAGE_NAME'];
					$data['name'] = $row['BUSINESS_NAME'];
				}else
				{

					$img = '';
				}

			}else{

				$img = $img;

			}

			//Build image string
			$format = substr($img,(strlen($img) - 4),4);
			$str = substr($img,0,(strlen($img) - 4));

			if($img != ''){

				if(strpos($img,'.') == 0){

					$format = '.jpg';
					$img_str = base_url('/').'img/timbthumb.php?w=60&h=60&src='.base_url('/').'assets/business/photos/'.$img . $format;

				}else{

					$img_str =  base_url('/').'img/timbthumb.php?w=60&h=60&src='.base_url('/').'assets/business/photos/'.$img;

				}

			}else{

				$img_str = base_url('/').'img/timbthumb.php?w=60&h=60&src='.base_url('/').'img/bus_blank.png';

			}


			return $img_str;

		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS COUNT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function msg_notifications_count(){
		
		//GET ALL MESSAGES FOR USER
		$x = 0;
		$query1 = $this->db->query("SELECT COUNT(*) as TOTAL FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' AND status_client = 'unread'",FALSE); 
	    $row1 = $query1->row_array();
		$x = $x + $row1['TOTAL'];
		//GET ALL BUSINESSES FOR USER
	   	$this->db->where('CLIENT_ID' , $this->session->userdata('id'));
		$query = $this->db->get('i_client_business');
		
		if($query->num_rows() > 0){
			
			foreach($query->result() as $row){
				
				$bus_id = $row->BUSINESS_ID;
				//GET ALL MESSAGES PER BUSINESS
				$query = $this->db->query("SELECT COUNT(*) as TOTAL FROM u_business_messages WHERE bus_id = '".$bus_id."' AND status = 'unread'",FALSE);
				$row2 = $query->row_array();
				
				
				$x = $x + $row2['TOTAL'];
				
			}
			
			
		}else{
	
				
		}
	   
	   
		if($x == 0){
				echo '';
		}else{
				echo '<span class="notification-small yellow">'.$x.'</span>';
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS ALL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function msg_notifications(){
		
		//GET ALL MESSAGES FOR USER
		$x = 0;
		$query1 = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' AND status_client = 'unread' LIMIT 3",FALSE); 
	   
		
		
		if($query1->result()){
			
			foreach($query1->result() as $row_user){
				
				echo '<li style="border-bottom:1px solid #f1f1f1"><a href="'.site_url('/').'members/home/message/'.$row_user->msg_id.'"><i class="icon-envelope"></i> '.$row_user->nameFROM.'<font style="font-size:10px;"><br /> '.substr(strip_tags(str_replace('-','',$row_user->body)),0,50).'</font></a></li>';
				
			}
		}
		
		//GET ALL BUSINESSES FOR BUSINESS
		$this->db->where('CLIENT_ID' , $this->session->userdata('id'));
		$query = $this->db->get('i_client_business');
		
		if($query->num_rows() > 0){
			
			foreach($query->result() as $row){
				
				$bus_id = $row->BUSINESS_ID;
				//GET ALL MESSAGES PER BUSINESS
				$query = $this->db->query("SELECT * FROM u_business_messages WHERE bus_id = '".$bus_id."' AND status = 'unread' LIMIT 3",FALSE);
				
				foreach($query->result() as $row2){
					
					echo '<li style="border-bottom:1px solid #f1f1f1"><a href="'.site_url('/').'members/business/'.$bus_id.'/message/'.$row2->msg_id.'"><i class="icon-envelope"></i> '.$row2->nameFROM.'<font style="font-size:10px;"><br /> '.substr(strip_tags(str_replace('-','',$row2->body)),0,50).'</font></a></li>';	
					
				}
				
				
			}
			
			
		}
	   
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS  PER BUSINESS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function msg_notifications_business($bus_id){
		
			//GET ALL MESSAGES PER BUSINESS
			$query = $this->db->query("SELECT * FROM u_business_messages WHERE bus_id = '".$bus_id."' AND status = 'unread'",FALSE);
			
			if($query->num_rows() == 0){
				echo '';
			}else{
					echo '<span class="notification-small yellow">'.$query->num_rows().'</span>';
			}

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER NOTIFICATIONS FOR USER
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function msg_notifications_member(){
		
			//GET ALL MESSAGES PER BUSINESS
			$query = $this->db->query("SELECT * FROM u_business_messages WHERE client_id = '".$this->session->userdata('id')."' AND status_client = 'unread'",FALSE);
			
			if($query->num_rows() == 0){
				echo '';
			}else{
					echo '<span class="notification-small yellow">'.$query->num_rows().'</span>';
			}

		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_points(){
		
		$this->db->where('CLIENT_ID', $this->session->userdata('id'));
		$query = $this->db->get('u_client_points_summary');
		if($query->result()){
			
			$row = $query->row_array();
			
            $max = $row['POINTS'] * 1.9;               
                
			echo '<div class="circleStats pull-right"><div class="circleStatsItem orange">
					<a href="'.site_url('/').'win/scratch_and_win/" >
					<i class="icon-na"></i><input type="text" id="member_points" value="" class="orangeCircle" /></div></a></div>
						
					<script type="text/javascript">
					$(document).ready(function() {
						$("#member_points").val('.$row['POINTS'].');
						$(".orangeCircle").knob({
										"min":0,
										"max":'. $max.',
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.2,
										"tickColorizeValues": true,
										"skin":"tron"
									})
						});
						$(".na_points").mouseover(function(){ 
	
						  $(this).popover({ placement:"left",html: true, title:"Your My Namibia Points", 
						  content:"These are your current accumulated points. To earn more points you can review businesses and connect with businesses"});
						  $(this).popover("show");
						  }).mouseout(function(){
				  
						  $(this).popover("destroy");
						});
					
					</script>';
			
			
		}else{
			
			echo '<div class="circleStats pull-right"><div class="circleStatsItem orange">
					<a href="'.site_url('/').'win/scratch_and_win/" >
					<i class="icon-na"></i><input type="text" id="member_points" value="" class="orangeCircle" /></div></a></div>
						
					<script type="text/javascript">
					$(document).ready(function() {
						$("#member_points").val(0);
						$(".orangeCircle").knob({
										"min":0,
										"max":10,
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.2,
										"tickColorizeValues": true,
										"skin":"tron"
									})
						});
						$(".na_points").mouseover(function(){ 
	
						  $(this).popover({ placement:"left",html: true, title:"No Points", 
						  content:"You have gained no points. Review some companies and connect to earn points"});
						  $(this).popover("show");
						  }).mouseout(function(){
				  
						  $(this).popover("destroy");
						});
					
					</script>';
			
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_points_sml(){
		
		$this->db->where('CLIENT_ID', $this->session->userdata('id'));
		$query = $this->db->get('u_client_points_summary');
		if($query->result()){
			
			$row = $query->row_array();
			
            $max = $row['POINTS'] * 1.9;               
                
			echo ''.$row['POINTS'].'';
				
			
		}else{
			
			echo '';
			
		}
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+COUNT USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function count_points($id = ''){
		
		if($id == ''){
			
			$id = $this->session->userdata('id');	
		}
		$this->db->where('CLIENT_ID', $id);
		$query = $this->db->get('u_client_points_summary');
		 if($query->result()){
			$row = $query->row_array();
			return $row['POINTS'];
		 }else{
			 
			return '0'; 
		 }
	}
	
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+COUNT USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function scratch_win_slide(){
		
		echo '<h3>Play Scratch & Win</h3>';
		
		if($this->session->userdata('id')){
		
			$link = site_url('/').'win/scratch_and_win/';
			
		}else{
			
			$link = site_url('/').'members/register/';
			
		}
		 echo   '<div id="scratch_slider" class="carousel slide">
					  <div class="carousel-inner">
						<div class="active item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_1a.png" /></a></div>
						<div class="item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_2a.png" /></a></div>
						<div class="item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_3a.png" /></a></div>
					  </div>
					</div>';		
		 echo ' <script type="text/javascript">
		  $(document).ready(function(){
			  
				$("#scratch_slider").carousel()
			  
		  });
		    
		  </script>
		  ';
		  
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Scratch AND WIN IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function scratch_win_img(){
		
		echo '<h3>Play Scratch & Win</h3>';
		
		if($this->session->userdata('id')){
		
			$link = site_url('/').'win/scratch_and_win/';
			
		}else{
			
			$link = site_url('/').'members/register/';
			
		}
		 echo   '<div id="scratch_slider" class="carousel slide">
					  <div class="carousel-inner">
						<div class="active item"><a href="'.$link.'"><img src="'.base_url('/').'img/scratch/scratch_1a.png" /></a></div>
						
					  </div>
					</div>';		
 
	}

	
	
    //+++++++++++++++++++++++++++
	//SHOW NA CONNECTIONS
	//++++++++++++++++++++++++++
    public function show_na_count()
    {
        //GET NA COUNT DETAILS	
		//$query = $this->db->limit('100');		
		$query = $this->db->query("SELECT COUNT(*) as total from u_business_na");
		if($query->result()){
		   
		   echo '<h2 class="total-na-counter">';
				$row = $query->row();
				$total = $row->total;
			
				$strlen = strlen( trim($total) );
				for( $i = 0; $i <= $strlen; $i++ ) {
					$char = substr( $total, $i, 1 );
					if($char == ''){
						
					}else{
						echo '<span>'.$char.'</span>';
						
					}
					
					// $char contains the current character, so do your processing here
				}

		  echo '</h2><h2 class="na_script">Business Connections Made</h2>';
		   
		}else{
			return '';
		}		
    }
    //+++++++++++++++++++++++++++
	//SHOW SCRATCH WINNER COUNT
	//++++++++++++++++++++++++++
    public function show_winner_count()
    {
        //GET NA COUNT DETAILS			
		$query = $this->db->query("SELECT COUNT(*) as total from scratch_winners");
		if($query->result()){
		   
		   echo '<h2 class="total-na-counter">';

				$row = $query->row();
				$total = $row->total;
			
				$strlen = strlen( trim($total) );
				for( $i = 0; $i <= $strlen; $i++ ) {
					$char = substr( $total, $i, 1 );
					if($char == ''){
						
					}else{
						echo '<span>'.$char.'</span>';
						
					}
					
					// $char contains the current character, so do your processing here
				}

		  echo '</h2><h2 class="na_script">Scratch and Win Winners</h2>';
		   
		}else{
			return '';
		}		
    }
	
	    //+++++++++++++++++++++++++++
	//SHOW SCRATCH WINNER COUNT
	//++++++++++++++++++++++++++
    public function show_review_count()
    {
        //GET NA COUNT DETAILS			
		$query = $this->db->query("SELECT COUNT(*) as total from u_business_vote");
		if($query->result()){
		   
		   echo '<h2 class="total-na-counter">';

				$row = $query->row();
				$total = $row->total;
			
				$strlen = strlen( trim($total) );
				for( $i = 0; $i <= $strlen; $i++ ) {
					$char = substr( $total, $i, 1 );
					if($char == ''){
						
					}else{
						echo '<span>'.$char.'</span>';
						
					}
					
					// $char contains the current character, so do your processing here
				}

		  echo '</h2><h2 class="na_script">Business Reviews Made</h2>';
		   
		}else{
			return '';
		}		
    }
	//+++++++++++++++++++++++++++
	//IS THE DEAL CLAIMED?
	//++++++++++++++++++++++++++
    public function count_claims($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('deal_id',$id);
		$query = $this->db->get('u_special_claims');
		if($query->result()){
		    return $query->num_rows;	
		}else{
			return 0;
		}		
    }
	//+++++++++++++++++++++++++++
	//IS THE DEAL CLAIMED?
	//++++++++++++++++++++++++++
    public function is_deal_claimed($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('deal_id',$id);
		$query = $this->db->where('client_id',$this->session->userdata('id'));
		$query = $this->db->get('u_special_claims');
		if($query->result()){
		    return TRUE;	
		}else{
			return FALSE;
		}		
    }
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET RANDOM ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_advert($query = ''){
		

		if($query == '3')
		{
			$x = 3;
			$query = $this->db->query("SELECT * FROM adverts WHERE IS_ACTIVE = 'Y' AND TYPE = 'P' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 3", false);

		}elseif($query != '' && $query != 3){


		}else{
			$x = 1;
			$query = $this->db->query("SELECT * FROM adverts WHERE IS_ACTIVE = 'Y' AND TYPE = 'P' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 1" ,FALSE);

		}

		if($query->result()){
			$count = 0;
			if($x == 3){

				echo ' <div class="row-fluid">';
			}
			foreach($query->result() as $row){
				
				if($row->ADVERTS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = base_url('/').'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;
					
				}
				
				if($row->URL == ''){
					
					$link1 = '';
					$link2 = '';
					
				}else{
					
					$link1 = '<a href="'.site_url('/').'adverts/track/'.$row->ID.'/'.rand(99999, 99999999).'/" target="_blank">';
					$link2 = '</a>';

				}

				if($x == 3){

					echo '<div class="span4 white_box">'.$link1.'<img class="lazy" style="width:100%" alt="'.strip_tags($row->ADVERTS_HEADER).'" src="'.$img.'" />'.$link2.'</div>';

				}else{

					echo ' <div class="row-fluid">
							<div class="span12 white_box">
								'.$link1.'<img class="lazy" style="width:100%" alt="'.strip_tags($row->ADVERTS_HEADER).'" src="'.$img.'" />'.$link2.'
							</div>

						</div>
					  ';


				}


				$count ++;
			}
			if($x == 3){

				echo '</div>';
			}
			$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";

		 }else{
		
		 }
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET RANDOM ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_trade_advert($main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $limit = 1){
		
		$result = array();
		if($sub_sub_sub_cat_id != 0){
			//echo "SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%[".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT 1" ;
			//$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID = '0' AND SUB_SUB_SUB_CAT_ID LIKE '%[".'"'.$sub_sub_sub_cat_id.'"'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 1" ,FALSE);
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%[".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT ".$limit."" ,FALSE);
			
		}elseif($sub_sub_cat_id != 0){
			//echo "SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT 1";
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND SUB_SUB_CAT_ID LIKE '%".'"'.$sub_sub_cat_id.'"%'."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
			
		}elseif($sub_cat_id != 0){	
			//echo 'Sub Cat Advert'.$main_cat_id.' - '. $sub_cat_id .' - '.$sub_sub_cat_id .' - '.$sub_sub_sub_cat_id .'<br />';
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND (MAIN_CAT_ID = '".$main_cat_id."' OR SUB_CAT_ID LIKE '%".'"'.$sub_cat_id.'"%'."') AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
		
		}elseif($main_cat_id != 0){
			//echo '1 Top Level Advert'.$main_cat_id.' - '. $sub_cat_id .' - '.$sub_sub_cat_id .' - '.$sub_sub_sub_cat_id ;
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID = '".$main_cat_id."' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
			
		}else{
			//echo '2 Top Level Advert'.$main_cat_id.' - '. $sub_cat_id .' - '.$sub_sub_cat_id .' - '.$sub_sub_sub_cat_id ;
			$query = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID != '0' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit."" ,FALSE);
			
		}
	    $x = 0;
        //echo $this->db->last_query();
		if($query->result()){

            foreach($query->result() as $row){

                $result[$x] = $this->load_adverts($row);
                $x ++;
            }



		}else{
			 
			//echo '<br />No Advert -> Fallback to Top Level';
		 	
			$query2 = $this->db->query("SELECT * FROM adverts WHERE TYPE = 'P' AND MAIN_CAT_ID != '0' AND IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY IMPRESSIONS ASC LIMIT ".$limit."" ,FALSE);

			if($query2->result()){


                foreach($query2->result() as $row){

                    $result[$x] = $this->load_adverts($row);
                    $x ++;
                }


			}
				
			
		}
        $result['count'] = $x;
        //echo $this->db->last_query();

		return $result;
	}	
	
	
	

	//++++++++++++++++++++++++++++++
	//Process ADVERT
	//++++++++++++++++++++++++++++++
	public function load_adverts($row)
	{
		$result = '';	

				
        if($row->ADVERTS_IMAGE_NAME == ''){

            $img = base_url('/').'img/user_blank.jpg';

        }else{

            $img = base_url('/').'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;

        }

        if($row->URL == ''){

            $link1 = '';
            $link2 = '';

        }else{

            $link1 = '<a href="'.site_url('/').'adverts/track/'.$row->ID.'/'.rand(99999, 99999999).'/" target="_blank">';
            $link2 = '</a>';

        }
        //IMPRESSION COUNTER
        //$data['IMPRESSIONS'] = $row->ID + 1;
        //$this->db->where('ID', $row->ID);
        //$this->db->update('adverts', $data);
        $result =  '<div class="white_box">'.$link1.'<img class="lazy" style="width:100%" alt="'.strip_tags($row->ADVERTS_HEADER).'" src="'.$img.'" />'.$link2.'</div>';

		
		return $result;
		
	}
	
	//++++++++++++++++++++++++++++++
	//Instant Search 
	//++++++++++++++++++++++++++++++
	public function instant_search($key , $limit = 10)
	{
		
		if($limit == 100){
			$key = rawurldecode($key);

		}else{

			$key = preg_replace('/[^a-z0-9\.]/i', '', $this->db->escape_like_str(rawurldecode($key)));
		}

		
		if($this->input->get('location') != 'national'){
			$locationSQL = " AND location = '".$this->input->get('location')."' ";	
		}
		$strSQL = '';
		if($this->input->get('sub_cat_id') != 0){
			$strSQL = " sub_cat_id = '".$this->input->get('sub_cat_id')."' ";	
		}
		
		if($this->input->get('main_cat_id') != 0){
			if($strSQL == ''){
				
				$strSQL = " main_cat_id = '".$this->input->get('main_cat_id')."' AND ";	
			}else{
				$strSQL = $strSQL. " AND main_cat_id = '".$this->input->get('main_cat_id')."' AND ";		
			}
			
		}
		
		//MORE THAN 1 WORD
		if(str_word_count($key) > 1){
				
				$keys = str_replace(" ", "+", trim($key));
				$keyA = explode("+", $keys);
				$keyF = '';
				foreach($keyA as $r){
					if(strlen($r) > 3){
						$keyF .= ''.$r.' ';
					}
				}

                //INSERT TERM FOR CAPTURE
                if(strlen($key) > 15){


                        $idata = array(

                            'client_id' => $this->session->userdata('id'),
                            'search_term' => $key,
                            'tokens' => '',
                            'location' => $this->session->userdata('country')

                        );
                        $this->db->insert('search_terms', $idata);

                }
                $tq1 = "SELECT title ,link, type, img_file ,body,
														MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance,
														MATCH(title) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance2
														FROM search_index
                                                        WHERE MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE)
														ORDER BY relevance2 DESC, relevance DESC LIMIT ".$limit;
                //echo $tq1;
				$query = $this->db->query($tq1, FALSE);
				
		//BIGGER THAN 2 CHARS	
		}elseif(str_word_count($key) == 1 && strlen($key) > 3)
        {

            $query = $this->db->query("SELECT title ,link, type, img_file ,body FROM search_index WHERE " . $strSQL . " title LIKE '%" . $key . "%' OR body LIKE '%" . $key . "%' ORDER BY title ASC LIMIT " . $limit . "", false);

        }elseif(strlen($key) > 2){

            $query = $this->db->query("SELECT title ,link, type, img_file ,body FROM search_index WHERE ".$strSQL." title LIKE '%".$key."%' OR body LIKE '%".$key."%' ORDER BY title ASC LIMIT ".$limit. "", FALSE);

        }else{
            $query = $this->db->query("SELECT title ,link, type, img_file ,body FROM search_index ORDER BY title ASC LIMIT " . $limit . "", false);
        }
		// '".$key."'
	
		if($query){
			echo '<table class="table">';
			foreach($query->result() as $row){
				$wordsArray = array();
				$markedWords = array();
                $key1 = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $key);
                $body = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $row->body);

				$wordsArray = explode(' ', $key1);
                $bodyArray = explode(' ', $body);
				foreach ($wordsArray as $k => $word) {
				  $markedWords[$k]='<strong class="yellow">'.strtolower($word).'</strong>';
				}

				$text = str_ireplace($wordsArray, $markedWords, $body);
				
				echo '<tr class="padding10">
						<td style="width:150px;border:none"><img src="'.base_url('/').'img/timbthumb.php?src='.base_url('/').$row->img_file.'&w=120&h=120" class="img-polaroid"/></td>
						<td style="min-width:85%;border:none">

						    <h3>'.str_replace($key1, $text,$row->title).'</h3>

						    <p><span class="muted">'.$this->shorten_string($text, 40).'</span></p>

						    <a href="'.site_url('/').$row->link.'" class="btn"><i class="icon-search"></i> View '.ucwords(str_replace("_"," ",$row->type)).'</a>
						    <span class="badge pull-right">'.ucwords(str_replace("_"," ",$row->type)).'</span>
						</td>

					  </tr>';
			}
			echo '</table>';
			
		}
		
		//echo $key . ' ' . $str;
	}
	

	//++++++++++++++++++++++++++++++
	//Instant Search 
	//++++++++++++++++++++++++++++++
	public function instant_search_json()
	{
		$out = array();
        if($str = $this->input->get('query')){

					if($this->input->get('location') != 'national'){
						$locationSQL = " AND location = '".$this->input->get('location')."' ";	
					}
					$strSQL = '';
					if($this->input->get('sub_cat_id') != 0){
						$strSQL = " sub_cat_id = '".$this->input->get('sub_cat_id')."' ";	
					}
					
					if($this->input->get('main_cat_id') != 0){
						if($strSQL == ''){
							
							$strSQL = " main_cat_id = '".$this->input->get('main_cat_id')."' AND ";	
						}else{
							$strSQL = $strSQL. " AND main_cat_id = '".$this->input->get('main_cat_id')."' AND ";		
						}
						
					}

					$key = $this->db->escape_like_str(urldecode($str));

                    //INSERT TERM FOR CAPTURE
                    if(strlen($key) > 15){

                        if(str_word_count($key) > 1) {
                            $idata = array(

                                'client_id' => $this->session->userdata('id'),
                                'search_term' => $key,
                                'tokens' => '',
                                'location' => $this->session->userdata('country')

                            );
                            $this->db->insert('search_terms', $idata);
                        }
                    }

                    //MORE THAN 1 WORD
                    if(str_word_count($key) > 1){

                        $keys = str_replace(" ", "+", trim($key));
                        $keyA = explode("+", $keys);
                        $keyF = '';
                        foreach($keyA as $r){
                            if(strlen($r) >= 3){
                                $keyF .= '+'.$r.' ';
                            }
                        }

                        $tq1 = "SELECT title ,link, type, img_file ,body,
														MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance,
														MATCH(title) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance2
														FROM search_index
                                                        WHERE MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE)
														ORDER BY relevance2 DESC, relevance DESC LIMIT 8";
                        //echo $tq1;
                        $query = $this->db->query($tq1, FALSE);
                        $go = true;


                        //BIGGER THAN 2 CHARS
                    }elseif(str_word_count($key) == 1 && strlen($key) > 3){

                        $tq1 = "SELECT title ,link, type, img_file ,body FROM search_index WHERE ".$strSQL." body LIKE '%".$key."%' OR title LIKE '%".$key."%' ORDER BY title ASC LIMIT 8";
                        $query = $this->db->query($tq1, FALSE);
                        $go = true;
                        //BIGGER THAN 2 CHARS
                    }elseif(strlen($key) > 2){

                        $tq1 = "SELECT title ,link, type, img_file ,body FROM search_index WHERE ".$strSQL." body LIKE '%".$key."%' OR title LIKE '%".$key."%' ORDER BY title ASC LIMIT 8";
                        $query = $this->db->query($tq1, FALSE);
                        $go = true;
                    }else{

                        $tq1 = '';
                        $query = false;
                        $go = false;
                    }
									   



					$x = 1;
                    if($go) {
                        if ($query->result()) {

                            foreach ($query->result() as $row) {

                                $name = $row->title;
                                $body = $this->shorten_string(strip_tags(str_replace($name, " ", $row->body)), 7);
                                $array = explode(" ", $name . " " . $body);
                                $temp = implode('","', $array);
                                //$link1 = "<a href='".site_url('/').$row->link.'">';
                                $t = array(

                                    "year" => $x,
                                    "image" => base_url('/') . 'img/timbthumb.php?src=' . base_url('/') . $row->img_file . '&w=20&h=20',
                                    "type" => "Category",
                                    "body" => $body,
                                    "link1" => "javascript:go_url('" . site_url('/') . $row->link . "')",
                                    "value" => $name,
                                    "tokens" => $array

                                );
                                array_push($out, $t);

                                $x++;
                            }

                        }
                    }

		
			if($query){
				//var_dump($arr);
				//echo json_encode($arr);
				//echo json_encode($out);
			}

            echo json_encode($out);
			
			$this->output->set_content_type('application/json');
		}
	}
		

	//+++++++++++++++++++++++++++
	//BUILD CAPTCHA
	//++++++++++++++++++++++++++
	function build_captcha(){
		
		$this->load->library('recaptcha');
		if (empty($_SERVER['HTTPS'])) {
			
			echo $this->recaptcha->recaptcha_get_html($error = null, FALSE);	
			
		}else{
			
			echo $this->recaptcha->recaptcha_get_html($error = null, TRUE);	
			
		}
		
		

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//PREFETCH TYEHEAD
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function load_typehead($type, $cat){

        $str = array();
        if($type == 'location'){

            $test = $this->db->get('a_map_location');

            $x = 1;
            //$str .= '[';
            if($test->result()){

                foreach($test->result() as $row){

                    $name =  $row->MAP_LOCATION;
                    $array = explode(" ",$name);
                    $temp = implode('","' , $array);
                    $t = array(

                        "year" => $x,
                        "image" => base_url('/').'img/timbthumb.php?src='.base_url('/').'img/markers/map_marker.png&w=20&h=20',
                        "type" => "City",
                        "body" => $name,
                        "link1" => "javascript:void(0)",
                        "value" => $name,
                        "tokens" => $array

                    );
                    array_push($str, $t);

                    $x ++;
                }

            }
        }elseif($type == 'business'){

            $test2 = $this->db->where('ISACTIVE', 'Y');
            $test2 = $this->db->get('u_business');
            $x2 = 1;
            if($test2->result()){

                foreach($test2->result() as $row2){

                    $name2 =  $row2->BUSINESS_NAME;
                    $array2 = explode(" ",$name2);
                    $temp2 = implode('","' , $array2);
                    $link = site_url('/').'b/'.$row2->ID;
                    $img = $row2->BUSINESS_LOGO_IMAGE_NAME;
                    //Build image string
                    $format = substr($img,(strlen($img) - 4),4);
                    $strT = substr($img,0,(strlen($img) - 4));

                    if($img != ''){

                        if(strpos($img,'.') == 0){

                            $format = '.jpg';
                            $img_str = base_url('/').'img/timbthumb.php?w=20&h=20&src='.base_url('/').'assets/business/photos/'.$img . $format;

                        }else{

                            $img_str =  base_url('/').'img/timbthumb.php?w=20&h=20&src='.base_url('/').'assets/business/photos/'.$img;

                        }

                    }else{

                        $img_str = base_url('/').'img/timbthumb.php?w=20&h=20&src='.base_url('/').'img/bus_blank.png';

                    }


                    $t = array(

                        "year" => $x2,
                        "image" => $img_str,
                        "type" => "Business",
                        "body" => $name2,
                        "link1" => "javascript:go_url('".$link."')",
                        "value" => $name2,
                        "tokens" => $array2

                    );
                    array_push($str, $t);

                    $x2 ++;
                }

            }


        }elseif($type == 'category'){

            //$test2 = $this->db->where('type', 'business_location');
            $test2 = $this->db->get('a_tourism_category');
            $x2 = 1;
            if($test2->result()){

                foreach($test2->result() as $row2){

                    $name2 =  trim(preg_replace("/[^a-z0-9.]+/i", " ", $row2->CATEGORY_NAME));
                    $array2 = explode(" ",$name2);
                    $temp2 = implode('","' , $array2);
                    $t = array(

                        "year" => $x2,
                        "image" => base_url('/').'img/timbthumb.php?src='.base_url('/').'img/markers/map_marker.png&w=20&h=20',
                        "type" => "Category",
                        "body" => $name2,
                        "link1" => "javascript:go_url('".site_url('/').$row2->link."')",
                        "value" => $name2,
                        "tokens" => $array2

                    );
                    array_push($str, $t);

                    $x2 ++;
                }

            }


        }elseif($type == 'business_location'){

            $test2 = $this->db->where('type', 'business_location');
            $test2 = $this->db->get('search_index');
            $x = 1;
            if($test2->result()){

                foreach($test2->result() as $row2){

                    $name2 =  trim(preg_replace("/[^a-z0-9.]+/i", " ", $row2->title));
                    $array2 = explode(" ",$name2);
                    $temp2 = implode('","' , $array2);

                    $t = array(

                        "year" => $x,
                        "image" => base_url('/').'img/timbthumb.php?src='.base_url('/').'img/markers/map_marker.png&w=20&h=20',
                        "type" => "Business Location",
                        "body" => $name2,
                        "link1" => "javascript:void(0)",
                        "value" => $name2,
                        "tokens" => $array2

                    );
                    array_push($str, $t);


                    $x ++;
                }

            }

        }


        echo json_encode($str);

		$this->output->set_content_type('application/json');
			  
    }

    //++++++++++++++++++++++++++++++
    //PREFETCH USER TYPEHEAD
    //++++++++++++++++++++++++++++++
    public function typehead_users()
    {

        $test2 = $this->db->where('client_id', $this->session->userdata('id'));
        $test2 = $this->db->distinct();
        $test2 = $this->db->group_by('search_term');
        $test2 = $this->db->order_by('created_at', 'DESC');
        $test2 = $this->db->limit(3);
        $test2 = $this->db->get('search_terms');
        $x = 1;
        $str = array();
        if($test2->result()){

            foreach($test2->result() as $row2){

                $name2 =  trim( $row2->search_term);
                $array2 = explode(" ",$name2);
                $temp2 = implode('","' , $array2);

                $t = array(

                    "year" => $x,
                    "image" => base_url('/').'img/na-icon-sml.png',
                    "type" => "Business Location",
                    "body" => $name2,
                    "link1" => "javascript:void(0)",
                    "value" => $name2,
                    "tokens" => $array2

                );
                array_push($str, $t);


                $x ++;
            }

        }


        echo json_encode($str);

        $this->output->set_content_type('application/json');

    }

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CACHE FEED FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function cacheObject($url,$name,$age = 86400)
    { 
        // directory in which to store cached files
        $cacheDir = BASE_URL."cache/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
          $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {
		  
		    if ( copy($url, $filename) ) {
				 // update timestamp to now
         		 touch($filename);
			}else{
				echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
			}
         
        }
        // return the cache filename
        return $filename;
    } 

	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
	
}
?>