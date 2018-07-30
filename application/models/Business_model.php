<?php
class Business_model extends CI_Model{
			
	public function __construct(){
  		//parent::CI_model();
		$this->load->database();	
	
 	}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+MEMBER Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//Get all Countries For Registration Dropdown
	function get_countries(){
      	
		$test = $this->db->get('a_country');
		return $test;		  
    }
	
	//Get Account Details
	function get_my_account($id){
      	
		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');
		return $test->row_array();		  
    }


    //+++++++++++++++++++++++++++
	//GET BUSINESS ASSIGNED TO USER
	//++++++++++++++++++++++++++
	public function get_businesses($id)	
	{
		//$query = $this->db->query('SELECT u_business.*
									//FROM   u_business LEFT JOIN i_client_business USING (CLIENT_ID)
									//WHERE  u_business.CLIENT_ID = '.$id.' OR i_client_business.CLIENT_ID = '.$id,FALSE);
		$this->db->where('CLIENT_ID' , $id);
		$query = $this->db->get('i_client_business');
		
		if($query->num_rows() > 0){
			$x = 0;
			foreach($query->result() as $row){
				
				$bus_id = $row->BUSINESS_ID;
				$data[$x]['BUSINESS_ID'] = $bus_id;
				$this->db->select('ID, BUSINESS_NAME');
				$this->db->where('ID', $bus_id);
				$query2 = $this->db->get('u_business');
				if($query2->num_rows() > 0 ){
					$row2 = $query2->row_array();
					$data[$x]['BUSINESS_NAME'] = $row2['BUSINESS_NAME'];
					
				}
				$x++;
				
			}
			return $data;
			
		}else{
			
			$data = '';
			return $data;
			
				
		}
		
		
	}
		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//SHOW SIMILAR LISTINGS SIDEBAR
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	function show_similar($bus_id){
      	
		$test = $this->get_current_cats($bus_id);
		$count = $test->num_rows();

		echo '<div class="owl-carousel" id="similar" style="margin-top:20px">';
		
		foreach($test->result() as $row){
			//Get Cat ID
			$cat_id = $row->CATEGORY_ID;
			
			//GET BUSINESSES WITH THE SAME CAT ID's
			$this->db->select('BUSINESS_ID');
			$this->db->from('i_tourism_category');
			$this->db->where('CATEGORY_ID',$cat_id);
			$this->db->where('BUSINESS_ID !=', $bus_id);
			$this->db->limit('8');
			$result = $this->db->get();
			$x=0;
			
			
			foreach($result->result() as $row2){
				
				$business_id = $row2->BUSINESS_ID;
				$this->show_similar_list($business_id); 
				$x++;
			}
			
		}
		echo '</div>';
    }		
	
	function show_similar_list($bus_id){

		$this->load->model('image_model'); 
		$this->load->library('thumborp');

		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 360;
		$height = 230;

		$l_width = 60;
		$l_height = 60;

      	
		$details = $this->get_business_details($bus_id);
		
		if($details)
		{
			$name = $details['BUSINESS_NAME'];
			$logo = $details['BUSINESS_LOGO_IMAGE_NAME'];
			$cover = $details['BUSINESS_COVER_PHOTO'];
			$id = $details['ID'];
			$email = $details['BUSINESS_EMAIL'];
			$tel = $details['BUSINESS_TELEPHONE'];
			$description = $details['BUSINESS_DESCRIPTION'];
			$url = $details['BUSINESS_URL'];
			$address = $details['BUSINESS_PHYSICAL_ADDRESS'];

			//Build image string
			//$format = substr($img, (strlen($img) - 4), 4);
			//$str = substr($img, 0, (strlen($img) - 4));

			if ($logo != '')
			{

				if (strpos($logo, '.') == 0)
				{

					$format = '.jpg';
					$logo_str = 'assets/business/photos/' . $logo . $format;
					$logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
					$b_logo = '<img title="Product is listed by ' . $name . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $name . '" class="pull-right img-thumbnail" />';
				}
				else
				{

					$logo_str = 'assets/business/photos/' . $logo;
					$logo_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $logo_str,$l_width,$l_height, $crop = '');
					$b_logo = '<img title="Product is listed by ' . $name . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $name . '" class="pull-right img-thumbnail" />';

				}

			}
			else
			{
				$logo_url = base_url('/').'images/bus_blank.png';
				$b_logo = '<img title="' . $name . '" rel="tooltip" style="margin-top:-70px; margin-right:10px; z-index:1;position:relative;width:60px" src="' . $logo_url . '" alt="' . $name . '" class="pull-right img-thumbnail" />';

			}


			if ($cover != '')
			{

				if (strpos($cover, '.') == 0)
				{

					$format = '.jpg';
					$cover_str = 'assets/business/photos/' . $cover . $format;
					$cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');

				}
				else
				{

					$cover_str = 'assets/business/photos/' . $cover;
					$cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');

				}

			}
			else
			{
				$cover_str = 'assets/business/photos/listing-placeholder.jpg';
				$cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,$width,$height, $crop = '');

			}



			//Build resultset HTML
			$html = '<div>
						<figure class="loader">
							<div class="product_ribbon_sml"><small style="color:#ff9900; font-size:14px">'.$name.' '.$id.'</small></div>
							<div class="slideshow-block">
								<a href="' . site_url('/') . 'b/' . $id . '/' . $this->clean_url_str($name) . '/"><img class="" src="' . $cover_url . '" alt="' . $name . '"></a>
							</div>

							<div>
							
								'.$b_logo.'	

							</div>
						</figure>			
			  		</div>
					  ';


			echo $html;

		}
		
    }
	
	
	
	
	
	   //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++	
	function update_business()
	{
			//error_reporting(E_ALL);
			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$telcode = $this->input->post('tel_dial_code', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$faxcode = $this->input->post('fax_dial_code', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$cellcode = $this->input->post('cell_dial_code', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$han = $this->input->post('han', TRUE);
			$ntb = $this->input->post('ntb', TRUE);
			$ncci = $this->input->post('ncci', TRUE);
			$teamnam = $this->input->post('teamnam', TRUE);
			$isactive = $this->input->post('isactive', TRUE);
			$vt = $this->input->post('vt', TRUE);
			$estate_a = $this->input->post('estate_a', TRUE);
			$paid = $this->input->post('paid', TRUE);
			$paid_until = $this->input->post('paid_until', TRUE);
			
			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$val = FALSE;
				$error = 'Email address is not valid.';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($web != ''){
						
				if(!filter_var($web, FILTER_VALIDATE_URL)){
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				}else{
				   $val = TRUE;	
				}
			
			}elseif(str_word_count($description) < 10){
				$val = FALSE;
				$error = 'Please provide a minimum of 10 words for your business description. Currently: '.str_word_count($description).' words.';	
				
			}else{
				$val = TRUE;
			}
	
			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
			$IP = $this->input->ip_address();
			$insertdata = array(
						  'BUSINESS_NAME'=> $name ,
						  'BUSINESS_TELEPHONE'=> $tel2 ,
						  'TEL_DIAL_CODE'=> $telcode ,
						  'BUSINESS_EMAIL'=> $email,
						  'CEL_DIAL_CODE'=> $cellcode,
						  'BUSINESS_CELLPHONE'=> $cell,
						  'FAX_DIAL_CODE'=> $faxcode,
						  'BUSINESS_FAX'=> $fax2,
						  'BUSINESS_DESCRIPTION'=> $description,
						  'BUSINESS_POSTAL_BOX'=> $pobox,
						  'BUSINESS_URL' => $web,
						  'BUSINESS_PHYSICAL_ADDRESS' => $address,
						  'BUSINESS_COUNTRY_ID' => $country,
						  'BUSINESS_MAP_CITY_ID' => $city,
						  'BUSINESS_SUBURB_ID' => $suburb,
						  'ISACTIVE' => $isactive,
						  'IS_HAN_MEMBER' => $han,
						  'IS_NTB_MEMBER' => $ntb,
						  'IS_NCCI_MEMBER' => $ncci,
						  'IS_TEAMNAM_MEMBER' => $teamnam,
						  'IS_ESTATE_AGENT' => $estate_a,
						  'BUSINESS_VIRTUAL_TOUR_NAME' => $vt,
						  'PAID_STATUS' => $paid,
						  'PAID_UNTIL' => $paid_until
				);
			


			
			if($val == TRUE){
				
					$this->db->where('ID' , $bus_id);
					$this->db->update('u_business', $insertdata);
					
					//$this->sync_tourism_db($insertdata, $bus_id);
					//success redirect	
					$data['bus_id'] = $bus_id;
					$data['success'] = true;
					$data['msg'] = $name . ' has been updated successfully';
					
					//$this->output->set_header("HTTP/1.0 200 OK");
			}else{
					$data['success'] = false;
					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
	
				
			}
			return $data;
	}
		
	 //+++++++++++++++++++++++++++
	//ADD BUSINESS
	//++++++++++++++++++++++++++	
	function add_business()
	{
			//error_reporting(E_ALL);
			$email = trim($this->input->post('email', TRUE));
			$name = $this->input->post('name', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$telcode = $this->input->post('tel_dial_code', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$faxcode = $this->input->post('fax_dial_code', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$cellcode = $this->input->post('cell_dial_code', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description =  html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			//$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$han = $this->input->post('han', TRUE);
			$ntb = $this->input->post('ntb', TRUE);
			$ncci = $this->input->post('ncci', TRUE);
			$teamnam = $this->input->post('teamnam', TRUE);
			$isactive = $this->input->post('isactive', TRUE);
			$vt = $this->input->post('vt', TRUE);
			$estate_a = $this->input->post('estate_a', TRUE);
			$paid = $this->input->post('paid', TRUE);
			
			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$val = FALSE;
				$error = 'Email address is not valid.';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($web != ''){
						
				if(!filter_var($web, FILTER_VALIDATE_URL)){
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				}else{
				   $val = TRUE;	
				}
			
			}elseif(str_word_count($description) < 10){
				$val = FALSE;
				$error = 'Please provide a minimum of 10 words for your business description. Currently: '.str_word_count($description).' words.';	
				
			}else{
				$val = TRUE;
			}
	
			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
			$IP = $this->input->ip_address();
			$insertdata = array(
							  'BUSINESS_NAME'=> $name ,
							  'BUSINESS_TELEPHONE'=> $tel2 ,
							  'TEL_DIAL_CODE'=> $telcode ,
							  'BUSINESS_EMAIL'=> $email,
							  'CEL_DIAL_CODE'=> $cellcode,
							  'BUSINESS_CELLPHONE'=> $cell,
							  'FAX_DIAL_CODE'=> $faxcode,
							  'BUSINESS_FAX'=> $fax2,
							  'BUSINESS_DESCRIPTION'=> $description,
							  'BUSINESS_POSTAL_BOX'=> $pobox,
							  'BUSINESS_URL' => $web,
							  'BUSINESS_PHYSICAL_ADDRESS' => $address,
							  'BUSINESS_COUNTRY_ID' => $country,
							  'BUSINESS_MAP_CITY_ID' => $city,
							  'BUSINESS_SUBURB_ID' => $suburb,
							  'ISACTIVE' => $isactive,
							  'IS_HAN_MEMBER' => $han,
							  'IS_NTB_MEMBER' => $ntb,
							  'IS_NCCI_MEMBER' => $ncci,
							  'IS_TEAMNAM_MEMBER' => $teamnam,
							  'IS_ESTATE_AGENT' => $estate_a,
							  'BUSINESS_VIRTUAL_TOUR_NAME' => $vt,
							  'PAID_STATUS' => $paid
				);
			


			
			if($val == TRUE){
				
					//$this->db->where('ID' , $bus_id);
					$this->db->insert('u_business', $insertdata);
					$bus_id = $this->db->insert_id();
					//$this->sync_tourism_db($insertdata, $bus_id);
					//success redirect	
					$data['bus_id'] = $bus_id;
					$data['success'] = true;
					$data['msg'] = $name . ' has been added successfully';
					
					//$this->output->set_header("HTTP/1.0 200 OK");
			}else{
					$data['success'] = false;
					$data['bus_id'] = 0;
					$data['error'] = $error;
	
				
			}
			return $data;
	}
		
	
	//+++++++++++++++++++++++++++
	//GET BUSINESS NAME
	//++++++++++++++++++++++++++
	public function get_business_name($bus_id)	
	{
		$this->db->select('BUSINESS_NAME');
		$this->db->where('ID' , $bus_id);
		$query = $this->db->get('u_business');
		
		if($query->num_rows() > 0){
			
			$row = $query->row_array();
			$name = $row['BUSINESS_NAME'];
				
			return $name;
			
		}else{
			
			$data = 'No Name';
			return $data;
			
				
		}
		
		
	}
	//GEt Current Categories
	function get_current_cats($bus_id){
      	
      	$test = $this->db->limit('2');
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('i_tourism_category');
		
		return $test;
				  
    }
	
	
	 //+++++++++++++++++++++++++++
	//SHOW BUSINESS VIRTUAL TOUR
	//++++++++++++++++++++++++++
	public function show_virtual_tour($id)
	{
		
		$this->db->where('ID' , $id);
		$this->db->from('u_business');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		 	
			$tour = $query->row_array();
			//$this->load->library('user_agent');
			if ($this->agent->is_mobile())
			{
				echo '<iframe style="width:100%; height:400px;min-height:400px" allowtransparency="true" frameborder="0" src="https://tourism.my.na/tours/'.$tour['BUSINESS_VIRTUAL_TOUR_NAME'].'/html5/index.html" />'; 
				
			}else{
				
				echo '<iframe style="width:100%; height:100%;min-height:400px" allowtransparency="true" frameborder="0" src="https://tourism.my.na/tours/'.$tour['BUSINESS_VIRTUAL_TOUR_NAME'].'/" />'; 
			}
			
			
			
		}else{
		
		return;
		}
	}
	 //+++++++++++++++++++++++++++
	//POPULATE REGIONS FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_region($cunt_id)
	{
		
		$this->db->where('COUNTRY_ID' , $cunt_id);
		$this->db->from('a_map_region');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		
			echo '<div class="control-group">
                  <label class="control-label" for="region">Region</label>
                  <div class="controls">
               		 <div class="input-prepend">
  						<span class="add-on"><i class="icon-flag"></i></span>
              			<select onchange="populateSuburb(this.value);" id="region" name="region" class="span4">';
			
				foreach($query->result() as $row){
					
					$region = $row->REGION_NAME;
					$reg_id = $row->ID;
					
					echo '<option value="'.$reg_id.'">'.$region.'</option>';
						  
					
					
				}
		   echo '</select> 
		   		  </div>
                </div>
              </div>';
		}else{
		
		return;
		}
	}
	//+++++++++++++++++++++++++++
	//POPULATE CITIES FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_city($cunt_id, $city_current)
	{
		//SEE IF NAMIBIA
		if($cunt_id == '151'){
		
			$this->db->order_by('MAP_LOCATION', 'ASC');
			$query = $this->db->get('a_map_location');
			
			if($query->num_rows() > 0){
			
				echo '<div class="control-group">
					  <label class="control-label" for="city">City</label>
					  <div class="controls">
						 <div class="input-prepend">
							<span class="add-on"><i class="icon-flag"></i></span>
							<select onchange="populateSuburb(this.value);" id="city" name="city" class="span4">
							<option value="0">Please Select your City</option>';
							
					foreach($query->result() as $row){
						
						$city = $row->MAP_LOCATION;
						$city_id = $row->ID;
						
						if($city_current == $city_id){ $str = 'selected="selected"';}else{ $str ='';}
						
						echo '<option value="'.$city_id.'" '. $str .' >'.$city.'</option>';
							  
						
						
					}
			   echo '</select> 
					  </div>
					</div>
				  </div>';
			}else{
			
			return;
			}
		}
	}
	
	 //+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS
	//++++++++++++++++++++++++++
	public function populate_suburb($reg_id,$suburb_current)
	{
		
		$this->db->where('CITY_ID' , $reg_id);
		$this->db->from('a_map_suburb');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
		
			echo '<div class="control-group">
                  <label class="control-label" for="suburb">Suburb</label>
                  <div class="controls">
               		 <div class="input-prepend">
  						<span class="add-on"><i class="icon-flag"></i></span>
              			<select id="suburb" name="suburb" class="span4">
						<option value="0">Please Select your Suburb</option>';
			
				foreach($query->result() as $row){
					
					$suburb = $row->SUBURB_NAME;
					$sub_id = $row->ID;
					
					if($suburb_current == $sub_id){ $str = 'selected="selected"';}else{ $str ='';}
					
					echo '<option value="'.$sub_id.'" ' . $str . ' >'.$suburb.'</option>';
						  
					
					
				}
		   echo '</select> 
		   		  </div>
                </div>
              </div>';
		}else{
		
		return;
		}
	}
	
	
	/**
++++++++++++++++++++++++++++++++++++++++++++
//Upload AVATAR
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	
	function add_avatar()
	{
          	$img = $this->input->post('userfile', TRUE);
			$user_id = $this->input->post('id', TRUE);
			
			//upload file

			$config['upload_path'] = './assets/users/photos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['id'] = $user_id;
					$data['error'] =  $this->upload->display_errors();
					$this->load->view('members/home', $data);
					
			}	
			else
			{	
			//LOAD library
			$this->load->library('image_lib');	
			//delete old photo
			$this->delete_old_avatar($user_id);
			
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   			 
				if (($width > 850) || ($height > 700)){
						 
						$this->downsize_image($file,$user_id);
								
				}
			//Watermark image
			$this->watermark_avatar($file);
			
			   //populate array with values
				$data = array( 
			      'CLIENT_PROFILE_PICTURE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID', $user_id);
				$this->db->update('u_client',$data);

				//load respective view 
			   $data['id'] = $user_id;
			   
			   //get sizes 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
			   //redirect 

		}
			
			
	}
/**
++++++++++++++++++++++++++++++++++++++++++++
//Upload AVATAR AJAX
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	
	function add_avatar_ajax()
	{
          	$img = $this->input->post('userfile', TRUE);
			$user_id = $this->input->post('id', TRUE);
			
			//upload file

			$config['upload_path'] = './assets/users/photos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['id'] = $user_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>'
           			 . $data['error'].'
       				 </div>'; 
					
			}	
			else
			{	
			//LOAD library
			$this->load->library('image_lib');	
			//delete old photo
			$this->delete_old_avatar($user_id);
			
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   			 
				if (($width > 850) || ($height > 700)){
						 
						$this->downsize_image($file,$user_id);
								
				}
			//Watermark image
			$this->watermark_avatar($file);
			
			   //populate array with values
				$data = array( 
			      'CLIENT_PROFILE_PICTURE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID', $user_id);
				$this->db->update('u_client',$data);

				//load respective view 
			   $data['id'] = $user_id;
			   
			   //get sizes 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
			   $image = base_url('/') . 'assets/users/photos/'.$file;
			   //redirect 
			    $data['basicmsg'] = 'Avatar added successfully!';
				echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'. $data['basicmsg'].'
       				 </div>
					 <script data-cfasync="false" type="text/javascript">avatar_upload_success("'.$image.'");</script>
					 ';
				$this->output->set_header("HTTP/1.0 200 OK");

		}
			
			
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DOWNSIZE AVATAR
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file, $id){

		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => ('./assets/users/photos/'. $file),
		   'master_dim' => 'auto',
		   'width' => '800',
		   'height' => '800',
		   'maintain_ratio' => true
		  ); 
		 
		 
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['gallmsg'] = $this->image_lib->display_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
	}	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DELETE OLD AVATAR
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function delete_old_avatar($user_id){
		
			$this->db->where('ID' , $user_id);
			$this->db->from('u_client');
			$query = $this->db->get();
			$row = $query->row_array();
			//has existing image
			if($row['CLIENT_PROFILE_PICTURE_NAME'] != ''){
				
				$file_large =  './assets/users/photos/' . $row['CLIENT_PROFILE_PICTURE_NAME']; # build the full path		
		
					   if (file_exists($file_large)) {
							unlink($file_large);
						}
						
						//delete image
						$idata['CLIENT_PROFILE_PICTURE_NAME'] = '';	
						$this->db->where('ID' , $user_id);
						$this->db->update('u_client', $idata);
				return;
				
			//no existing image	
			}else{
				
				return;
			}
	
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//WATERMARK AVATAR
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//create a downsized thumbnail
	function watermark_avatar($file){
			
			//$id = $this->input->post('pro_id');
 
		  	$config['source_image'] = './assets/users/photos/'. $file;
			$config['wm_type'] = 'overlay';
			$config['wm_overlay_path'] = './img/icons/watermark.png';
			$config['padding'] = 30;
			$config['wm_opacity'] = 80;
			//$config['wm_font_color'] = 'ffffff';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'right';
			$config['wm_x_transp'] = 4;
			$config['wm_y_transp'] = 4;
			
			
			$this->image_lib->initialize($config); 

			$this->image_lib->watermark();
		 
		  //$this->load->library('image_lib'); 
		 
		  if ( ! $this->image_lib->watermark()) 
		  { 
			  $data['error'] = $this->image_lib->watermark_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		  return;
		 }	
		 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//BUSINESS 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//+++++++++++++++++++++++++++
	//BUSINESS DETAILS EDIT
	//++++++++++++++++++++++++++		 
		 
	function get_business_details($bus_id){

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		if ( ! $output = $this->cache->get('get_business_details_'.$bus_id))
		{


			//$this->db->where('ID', $bus_id);
			$test = $this->db->query("SELECT  u_business.*, a_map_location.MAP_LOCATION as city, a_map_region.REGION_NAME as region,
										u_business_map.BUSINESS_MAP_LATITUDE as latitude, u_business_map.BUSINESS_MAP_LONGITUDE as longitude
										FROM u_business
										LEFT JOIN a_map_location ON u_business.BUSINESS_MAP_CITY_ID = a_map_location.ID
										LEFT JOIN a_map_region ON a_map_location.MAP_REGION_ID = a_map_region.ID
										LEFT JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
										WHERE u_business.ID = '".$bus_id."'
										");
			//$test = $this->db->query("SELECT * FROM u_business WHERE ID = '". $bus_id."'", FALSE);
			//$this->db->close();

			$output = $test->row_array();

			$this->cache->save('get_business_details_'.$bus_id, $output, 600);

		}

		return $output;

	}			 
	
	
	/**
++++++++++++++++++++++++++++++++++++++++++++
//Upload LOGO
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	
	function add_logo()
	{
          	$img = $this->input->post('userfile', TRUE);
			$user_id = $this->input->post('id', TRUE);
			$bus_id = $this->input->post('bus_id', TRUE);
			$name = $this->input->post('bus_name', TRUE);
			$name1 = $name . rand(9,99999);
			//upload file

			$config['upload_path'] = BASE_URL .'assets/business/photos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			//$config['encrypt_name']  = TRUE;
			$config['file_name']  = $name1;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['id'] = $user_id;
					$data['bus_id'] = $bus_id;
					$data['error'] =  $this->upload->display_errors();
					$this->load->view('members/business_details', $data);
					
			}	
			else
			{	
			//LOAD library
			$this->load->library('image_lib');	
			//delete old photo
			$this->delete_old_logo($bus_id);
			

			
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	
			$format = substr($file,(strlen($file) - 4),4);
			$str = substr($file,0,(strlen($file) - 4));	
			//Convert To jpg
			$this->convert_logo_jpg($str, $file);
					 
				if (($width > 850) || ($height > 700)){
						 
						$this->downsize_logo($file,$bus_id);
								
				}
			//Watermark image
			$this->watermark_logo($file);
			
			   //populate array with values
				$data = array( 
			      'BUSINESS_LOGO_IMAGE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID', $bus_id);
				$this->db->update('u_business',$data);

				//load respective view 
			   $data['id'] = $user_id;
			   $data['bus_id'] = $bus_id;
			   //get sizes 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
			   //redirect 

		}
			
			
	}
	
	

	
	
/**
++++++++++++++++++++++++++++++++++++++++++++
//Upload AVATAR AJAX
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
	
	function add_logo_ajax()
	{
          	$img = $this->input->post('userfile', TRUE);
			$user_id = $this->input->post('id', TRUE);
			$bus_id = $this->input->post('bus_id', TRUE);
			$name = $this->input->post('bus_name', TRUE);
 			$name1 = $name . rand(9,99999);
			
			//upload file

			$config['upload_path'] = BASE_URL .'assets/business/photos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			//$config['encrypt_name']  = TRUE;
			$config['file_name']  = $name1;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['id'] = $user_id;
					$data['bus_id'] = $bus_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>'
           			 . $data['error'].'
       				 </div>'; 
					
			}	
			else
			{	
			//LOAD library
			$this->load->library('image_lib');	
			//delete old photo
			$this->delete_old_logo($bus_id);
			
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	
			$format = substr($file,(strlen($file) - 4),4);
			$str = substr($file,0,(strlen($file) - 4));	
			//Convert To jpg
			$this->convert_logo_jpg($str, $file);
					 
				if (($width > 850) || ($height > 700)){
						 
						$this->downsize_logo($file,$bus_id);
								
				}
			//Watermark image
			$this->watermark_logo($file);
			
			   //populate array with values
				$data = array( 
			      'BUSINESS_LOGO_IMAGE_NAME'=> $file
				 
        		);
				//insert into database
				$this->db->where('ID', $bus_id);
				$this->db->update('u_business',$data);

				//load respective view 
			   $data['id'] = $user_id;
			   $data['bus_id'] = $bus_id;
			   //get sizes 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
			   $image = base_url('/').'img/timbthumb.php?w=100&h=100&src='.base_url('/') . 'assets/business/photos/'.$file;
			   //redirect 
			    $data['basicmsg'] = 'Logo added successfully!';
				echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'. $data['basicmsg'].'
       				 </div>
					 <script data-cfasync="false" type="text/javascript">logo_upload_success("'.$image.'");</script>
					 ';
				$this->output->set_header("HTTP/1.0 200 OK");

		}
			
			
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DOWNSIZE LOGO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_logo($file, $id){

		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => (BASE_URL .'assets/business/photos/'. $file),
		   'master_dim' => 'auto',
		   'width' => '800',
		   'height' => '800',
		   'maintain_ratio' => true
		  ); 
		 
		 
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['error'] = $this->image_lib->display_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
	}	

		 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//CONVERT LOGO TO JPEG
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function convert_logo_jpg($str, $file){

		
		$config = array( 
		   'image_library' => 'ImageMagick',
		   'library_path' =>  '/usr/bin',
		   'source_image' => (BASE_URL .'assets/business/photos/'. $file),
		   'new_image' => './assets/business/photos/'. $str . '.jpg'
		  
		  ); 

		  $this->image_lib->initialize($config); 
		 
		  $this->image_lib->clear(); 
		 return;
	}			 
		

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DELETE OLD LOGO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function delete_old_logo($bus_id){
		
			$this->db->where('ID' , $bus_id);
			$this->db->from('u_business');
			$query = $this->db->get();
			$row = $query->row_array();
			//has existing image
			if($row['BUSINESS_LOGO_IMAGE_NAME'] != ''){
				
				$file_large =  './assets/business/photos/' . $row['BUSINESS_LOGO_IMAGE_NAME']; # build the full path		
		
					   if (file_exists($file_large)) {
							unlink($file_large);
						}
						
						//delete image
						$idata['BUSINESS_LOGO_IMAGE_NAME'] = '';	
						$this->db->where('ID' , $bus_id);
						$this->db->update('u_business', $idata);
				return;
				
			//no existing image	
			}else{
				
				return;
			}
	
	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//WATERMARK LOGO
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//create a downsized thumbnail
	function watermark_logo($file){
			
			//$id = $this->input->post('pro_id');
 
		  	$config['source_image'] = BASE_URL .'assets/business/photos/'. $file;
			$config['wm_type'] = 'overlay';
			$config['wm_overlay_path'] = BASE_URL .'img/icons/watermark.png';
			$config['padding'] = 30;
			$config['wm_opacity'] = 80;
			//$config['wm_font_color'] = 'ffffff';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'right';
			$config['wm_x_transp'] = 4;
			$config['wm_y_transp'] = 4;
			
			
			$this->image_lib->initialize($config); 

			$this->image_lib->watermark();
		 
		  //$this->load->library('image_lib'); 
		 
		  if ( ! $this->image_lib->watermark()) 
		  { 
			  $data['error'] = $this->image_lib->watermark_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		  return;
		 }
		 
 
		 
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DOWNSIZE GALLERY IMAGE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_gallery_image($file){

		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => (BASE_URL .'assets/business/gallery/'. $file),
		   'master_dim' => 'auto',
		   'width' => '800',
		   'height' => '800',
		   'maintain_ratio' => true
		  ); 
		 
		 
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['error'] = $this->image_lib->display_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
	}	

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//WATERMARK GALLERY IMAGE
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//create a downsized thumbnail
	function watermark_gallery_image($file){
			
			//$id = $this->input->post('pro_id');
 
		  	$config['source_image'] = BASE_URL .'assets/business/gallery/'. $file;
			$config['wm_type'] = 'overlay';
			$config['wm_overlay_path'] = BASE_URL .'img/icons/watermark.png';
			$config['padding'] = 30;
			$config['wm_opacity'] = 80;
			//$config['wm_font_color'] = 'ffffff';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'right';
			$config['wm_x_transp'] = 4;
			$config['wm_y_transp'] = 4;
			
			
			$this->image_lib->initialize($config); 

			$this->image_lib->watermark();
		 
		  //$this->load->library('image_lib'); 
		 
		  if ( ! $this->image_lib->watermark()) 
		  { 
			  $data['error'] = $this->image_lib->watermark_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		  return;
		 }
		 
	
	//SHOW ALL IMAGES IMAGE MANAGER		
	function show_all_gallery_images($bus_id)
	{
			
		$query = $this->db->where('BUSINESS_ID',$bus_id);
		$query = $this->db->get('u_gallery_component');

		//IF have children
		if($query->num_rows() > 0){

			echo '<h4>All Gallery Images</h4>';
			echo '<ul class="thumbnails">';
			$x =0;

			foreach($query->result() as $row){
				$id = $row->ID;
				$img_file = $row->GALLERY_PHOTO_NAME;
					
				if($img_file != ''){
					
					if(strpos($img_file,'.') == 0){
			
						$format = '.jpg';
						$img_str = S3_URL.'assets/business/gallery/'.$img_file . $format;
						
					}else{
						
						$img_str =  S3_URL.'assets/business/gallery/'.$img_file;
						
					}
					
				}else{
					
					$img_str = base_url('/').'img/bus_blank.jpg';	
					
				}
						
					
				//NO TIMBTHUMB
				echo '<li class="thumbnail"><img src="'.$img_str.'" style="width:180px;"/>
				<a style="float:left;margin:0 5px;" onclick="delete_gallery_img('.$id .');" href="#"><i class="icon-remove"></i></a>
			    </li>';
				$x++;
					
			}
				
			//show gallery
			echo '</ul>';
			
		}else{
		
			echo '<div class="alert alert-secondary">
					<h4>No Gallery Images Added</h4>
					Please add some gallery images to enhance your business listing by clicking on the select images button below
				  </div>';

		}			
	}
		 
			 
		 
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET M<AP
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get MAP Details
function get_map_details($ID){


  	
	$test = $this->db->where('BUSINESS_ID', $ID);
	$test = $this->db->get('u_business_map');
	return $test->row_array();		


}
    		 	
//UPDATE MAP COORDINATES
	function update_map_coordinates(){
      	
		$user_id = $this->input->post('id', TRUE);
		$bus_id = $this->input->post('bus_id', TRUE);
		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);
		
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('u_business_map');
		
		
		
		if($test->num_rows() > 0){
			
		       //populate array with values
				$data = array( 
						  'BUSINESS_MAP_LATITUDE'=> $lat,
						  'BUSINESS_MAP_LONGITUDE'=> $lng
						 
				);
			   
			    //update database
				$this->db->where('BUSINESS_ID', $bus_id);
				$this->db->update('u_business_map',$data);
		}else{
			
				//populate array with values
				$data = array( 
						  'BUSINESS_MAP_LATITUDE'=> $lat,
						  'BUSINESS_MAP_LONGITUDE'=> $lng,
						  'BUSINESS_ID' => $bus_id,
						  'BUSINESS_MAP_ZOOM_LEVEL' => '13'
				);

				$this->db->insert('u_business_map',$data);
		}
				
		return;
				  
    }		
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	


	//Get Main Categories
	function get_main_categories(){
   
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		if ( ! $output = $this->cache->get('bus_get_main_categories'))
		{

			$output = $this->db->get('a_tourism_category');

			$this->cache->save('bus_get_main_categories', $output, 43200);

		}
			
		return $output;	  
    }	


	//GEt sub Categories
	function get_sub_categories($cat_id){
      
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		if ( ! $output = $this->cache->get('bus_get_sub_categories'))
		{

			$this->db->where('CATEGORY_TYPE_ID', $cat_id);
			$output = $this->db->get('a_tourism_category_sub');

			$this->cache->save('bus_get_sub_categories', $output, 43200);

		}

		return $output;
				  
    }	


	//GEt Current Categories
	function get_current_categories($bus_id){

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		if ( ! $query = $this->cache->get('bus_get_current_categories_'.$bus_id))
		{		
      	
			$query = $this->db->query("SELECT a_tourism_category.CATEGORY_NAME as MAINCAT, a_tourism_category.ID as MAINCAT_ID, a_tourism_category_sub.CATEGORY_NAME as CATEGORY, a_tourism_category_sub.ID as SUBCAT_ID
									FROM  i_tourism_category 
									JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
									JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
									WHERE BUSINESS_ID = '".$bus_id."'", FALSE);


			$query = $query->result();

			$this->cache->save('bus_get_current_categories_'.$bus_id, $query, 43200);

		}


			if($query){
				$y = 0;
				foreach($query as $row){
					
					$cat_id = $row->SUBCAT_ID;
					$x['links'][$y] = '<a href="'.site_url('/').'a/cat/'.$cat_id.'/'.$this->clean_url_str($row->CATEGORY).'/"><span class="badge badge-secondary">'.$row->CATEGORY.'</span></a>';
					
					if($y == 0){
						
						$x['breadcrumb'][$y] = '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('/').'a/c/'.$row->MAINCAT_ID.'/'.$this->clean_url_str($row->MAINCAT).'/" itemprop="url"><span itemprop="title">'.$row->MAINCAT.'</span></a><span class="divider">/</span></li>
												<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('/').'a/cat/'.$row->SUBCAT_ID.'/'.$this->clean_url_str($row->CATEGORY).'/" itemprop="url"><span itemprop="title">'.$row->CATEGORY.'</span></a><span class="divider">/</span></li>
						';
					
					}
					$y ++;	
				}
				return $x;
				
			}else{
				
				$x['links'][0] = '<span class="label">No category</span>';
				$x['links'][1] = '';
				$x['breadcrumb'][0] = '';
				$x['breadcrumb'][1] = '';
				return $x;
				
			}
			
		
				  
    }

//GEt CATEGORY NAME
	function get_category_name($cat_id_cur){
      	
		$test = $this->db->where('ID', $cat_id_cur);
		$test = $this->db->get('a_tourism_category_sub');
		
		if($test->result()){
			
			$row = $test->row_array();
			return $row['CATEGORY_NAME'];
				
		}else{
			
			return '';
			
		}

				  
    }
	//GEt CATEGORY NAME
	function add_new_category($cat_id ,$bus_id){
      	
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//NEED TO VALIDATE HOW MANY CATEGORIES THE BUSINESS HAS
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++	
		
		$data = array( 
			      'BUSINESS_ID'=> $bus_id,
				  'CATEGORY_ID'=> $cat_id,
				  'IS_ACTIVE'=> 'N'
				 
        		);
		//insert into database
		$this->db->insert('i_tourism_category',$data);
		
		
    }
	//DELETE CATEGORY
	function delete_category($cat_id, $bus_id){
      	
		//test if it was ajax or POST
		$ajax = $this->uri->segment(5);
				
		if($ajax != 'ajax'){
			
			//delete from database
			$test = $this->db->where('CATEGORY_ID', $cat_id);
			$test = $this->db->where('BUSINESS_ID', $bus_id);
			$this->db->delete('i_tourism_category');
			return 'redirect';	
			
		}else{
	
			//delete from database
			$test = $this->db->where('CATEGORY_ID', $cat_id);
			$test = $this->db->where('BUSINESS_ID', $bus_id);
			$this->db->delete('i_tourism_category');
			return '';
		}
		
    }


//CLEAN URL

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

	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS GALLERY
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Business Gallery
	function get_gallery($bus_id){
      	
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('u_gallery_component');
		return $test;	  
    }
	
	//Show Gallery
	function show_gallery($bus_id){

		$this->load->model('image_model'); 

		$this->load->library('thumborp');

		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 720;

		$height = 460;
      	
		$query = $this->db->where('BUSINESS_ID',$bus_id);
			$query = $this->db->get('u_gallery_component');
			//IF have children
			if($query->num_rows() > 0){

				echo '<div class="owl-carousel" style="margin-top:20px">';
				$x =0;
				foreach($query->result() as $row){
					$id = $row->ID;
					$img_file = $row->GALLERY_PHOTO_NAME;
					//$title = $row->CLIENT_PHOTO_TITLE;
					
					if($x == 0){
						
						$start = 'active item';
					
					}else{
						
						$start = 'item';	
					
					}
							
					//Build image string
					$format = substr($img_file,(strlen($img_file) - 4),4);
					$str = substr($img_file,0,(strlen($img_file) - 4));
					
					if($img_file != ''){
						
						if(strpos($img_file,'.') == 0){
				
							$format = '.jpg';
							$img_str = 'assets/business/gallery/'.$img_file . $format;
							$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');
							$img_exp =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');
							
						}else{
							
							$img_str = 'assets/business/gallery/'.$img_file;
							$img_url =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');
							$img_exp =  $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');
							
						}
						
					}else{
						
						$img_str = base_url('/').'img/bus_blank.jpg';	
						
					}
					 
						//NO TIMBTHUMB
						echo '<figure class="loader"><div><a class="fancy-images" rel="gallery" href="'.$img_exp.'"><img src="'.$img_url.'" style="width:100%;" /></a></div></figure>';
						$x++;
							 
				}
					
				//show gallery
				echo '</div><div class="spacer"></div>';
				
			}else{
			
				echo '<div class="alert alert-secondary">
						<h4>No Gallery Images Added</h4>
						Please add some gallery images to enhance your business listing by clicking on the select images button below
					  </div>';
			}			
				  
    }	
			 	  	
//++++++++++++++++++++++++++++++++++++++++++++++++++++++
//ADD NEW CLIENT ID INTO INTERSECTION TABLE
//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function add_business_member($bus_id ,$id){

		$data = array( 
			      'BUSINESS_ID'=> $bus_id,
				  'CLIENT_ID'=> $id
        		);

		//insert into database
		$this->db->insert('i_client_business',$data);
			
    }
	
	
	


//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS RATING STARS
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

   //GET BUSINESS RATING
	public function get_rating($id){
      	

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $output = $this->cache->get('get_rating_'.$id))
		{		

			$query = $this->db->query("SELECT AVG(RATING) AS TOTAL FROM u_business_vote WHERE BUSINESS_ID ='".$id."' AND IS_ACTIVE = 'Y' AND TYPE = 'review' ORDER BY TOTAL");
			
			if($query->result()){
				
				$row = $query->row_array();
				$output = round($row['TOTAL']);
				
			}else{
				
				$output = 0;
				
			}

			$this->cache->save('get_rating_'.$id, $output, 1440);

		}

		return $output;	
			  
    }


	//GET BUSINESS RATING COUNT
	public function get_rating_count($id){
      	
  		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $output = $this->cache->get('get_rating_count'.$id))
		{	
		    	
			$query = $this->db->query("SELECT RATING FROM u_business_vote WHERE BUSINESS_ID ='".$id."' AND IS_ACTIVE = 'Y' AND TYPE = 'review'");

			$output = $query->num_rows();

			$this->cache->save('get_rating_count'.$id, $output, 1440);

		}	
			
		return $output;
						  
    }



    function get_review_stars_show($rating,$id){
		 
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $output = $this->cache->get('get_review_stars_show_'.$id.'_'.$rating))
		{

			$x = 1;
			if(($rating != '')){

				//$rating = round($rating);

				while($x <= 5){
					
					if($rating == $x){
						
						$str = 'checked="checked"';
					}else{
						
						$str = '';
						
					}
					
					$arr[$x] = '<input name="'.$id.'-'.$rating.'" type="radio" value="'.$x.'" class="star" disabled="disabled" '.$str.'/>';	
					$x++;

				}
				
				$output = '<div style=";font-size:10px;font-style:italic;text-align:center" class=""><span class="text-center">'. implode($arr).'<br />Based on: <b>'.$this->get_rating_count($id).'</b> reviews</span></div>';
				
			}else{
				
				//$arr = '<a class="clearfix" href="#reviews" data-toggle="tab"><span class="label label-warning" title="Review this business to help them feature" rel="tooltip">No reviews yet. Be the first</span></a><br /><br />';
				$output = '';
						
			}

			$this->cache->save('get_review_stars_show_'.$id.'_'.$rating, $output, 1440);

		}	

		return $output;
    }	

 /**
++++++++++++++++++++++++++++++++++++++++++++
//REVIEWS
//GET AVATAR
++++++++++++++++++++++++++++++++++++++++++++	
 */ 	
	
	function get_user_avatar($id){
		 
		
		if($id != '0'){
			
			$this->db->from('u_client');
			$this->db->where('ID', $id);
			$query = $this->db->get();
			$row = $query->row_array();
			
			if($query->result()){
			
				$img = $row['CLIENT_PROFILE_PICTURE_NAME'];

				//Build image string
				$format = substr($img,(strlen($img) - 4),4);
				$str = substr($img,0,(strlen($img) - 4));

				if(strstr($img, "http")){

					$data['image'] = $img.'?width=100&height=100';

				}elseif(strstr($img,'.')){

					$data['image']=  S3_URL.'assets/users/photos/'.$img;


				}elseif($img == '' || $img == null){

					$data['image'] =  base_url('/').'img/user_blank.jpg';


				}else{

					$format = '.jpg';
					$data['image']=  S3_URL.'assets/users/photos/'.$img . $format;

				}

				$data['name'] = $row['CLIENT_NAME'] . ' ' . $row['CLIENT_SURNAME'];
				return $data;

			}else{
				
				$data['image'] =  base_url('/').'img/user_blank.jpg';
				$data['name'] = 'user';
				return $data;
				
			}

		}

    }	

/**
++++++++++++++++++++++++++++++++++++++++++++
//REVIEWS
//GET LOGO
++++++++++++++++++++++++++++++++++++++++++++	
**/ 	
	
	function get_business_logo($id){
		 
		
		if($id != '0'){
			
				$this->db->from('u_business');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();
				
				if($query->result()){
				
					$img = $row['BUSINESS_LOGO_IMAGE_NAME'];
					
					//Build image string
					$format = substr($img,(strlen($img) - 4),4);
					$str = substr($img,0,(strlen($img) - 4));
					
					if($img != ''){
						
						if(strpos($img,'.') == 0){
				
							$format = '.jpg';
							$img_str = base_url('/').'img/timbthumb.php?w=60&h=60&src='.S3_URL.'assets/business/photos/'.$img . $format;
							
						}else{
							
							$img_str =  base_url('/').'img/timbthumb.php?w=60&h=60&src='.S3_URL.'assets/business/photos/'.$img;
							
						}
						
					}else{
						
						$img_str = base_url('/').'img/timbthumb.php?w=60&h=60&src='.base_url('/').'img/bus_blank.png';	
						
					}
						
					$data['name'] = $row['BUSINESS_NAME'];
					$data['image'] = $img_str;
					return $data;
					
				}else{
					
					$data['image'] =  base_url('/').'img/bus_blank.jpg';
					$data['name'] = 'Business';
					return $data;
					
				}
		}

    }

	function get_review_stars($rating,$id){
		 
		$x = 1;
		
		while($x <= 5){
			$rating = round($rating);
			if($rating == $x){
				
				$str = 'checked="checked"';
			}else{
				
				$str = '';
				
			}
			
			$arr[$x] = '<input name="'.$id.'-'.$rating.'" type="radio" value="'.$x.'" class="star" disabled="disabled" '.$str.'/>
			';	
			$x++;
		}
		return $arr;
    }	

//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
 /**
++++++++++++++++++++++++++++++++++++++++++++
//ANALYTICS
++++++++++++++++++++++++++++++++++++++++++++	
ANALYTICS SECTION
++++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++	
 */ 
    function add_business_view($bus_id) {
		
		$IP = $this->input->ip_address();
   		$date = (date("G")); 
		
		$query = $this->db->query("select HOUR(TIMESTAMP) FROM u_business_clicks  
					WHERE HOUR(TIMESTAMP) = '".$date."' AND BUSINESS_ID = '".$bus_id."' AND IP = '".$IP."' AND TYPE = 'view'");
				   
		if($query->num_rows() == 0){		   
    	
				$data = array(
						
						'BUSINESS_ID' => $bus_id,
						'TYPE' => 'view',
						'IP' => $IP			
					);
				
				$this->db->insert('u_business_clicks',$data);
				
		}
		
	}
	
    function add_business_phone_click($bus_id, $type) {
		
		$IP = $this->input->ip_address();
   		$date = (date("G")); 
		
		$query = $this->db->query("select HOUR(TIMESTAMP) FROM u_business_clicks  
					WHERE HOUR(TIMESTAMP) = '".$date."' AND BUSINESS_ID = '".$bus_id."' AND IP = '".$IP."' AND TYPE = '".$type."-click'");
						   
		if($query->num_rows() == 0){		   
				
				$data = array(
						
						'BUSINESS_ID' => $bus_id,
						'TYPE' => $type.'-click',
						'IP' => $IP			
					);
				
				$this->db->insert('u_business_clicks',$data);
		}
	}
 /**
++++++++++++++++++++++++++++++++++++++++++++
//MY NA LIKE CONNECT 
++++++++++++++++++++++++++++++++++++++++++++	
FUNCTIONS
++++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++	
 */ 
 	//LOAD BUTTON
	function my_na($bus_id, $client_id , $place) {
		
		/*$query = $this->db->query("SELECT u_business_na.*,user.ID, COUNT(u_business_na.BUSINESS_ID) as na_count,
									group_concat(CONCAT( u_client.CLIENT_NAME,' ',u_client.CLIENT_SURNAME),'_-_', u_client.CLIENT_PROFILE_PICTURE_NAME) as likers
									FROM u_business_na
									LEFT JOIN u_client ON u_business_na.CLIENT_ID = u_client.ID 
									LEFT JOIN u_client as user ON user.ID = u_business_na.CLIENT_ID AND u_business_na.BUSINESS_ID = '".$bus_id."' AND CLIENT_ID = '".$client_id."'
									WHERE  BUSINESS_ID = '".$bus_id."'");*/
									
		$query = $this->db->query("SELECT u_business_na.*, COUNT(u_business_na.BUSINESS_ID) as na_count,
									(SELECT CLIENT_ID FROM u_business_na WHERE u_business_na.CLIENT_ID AND u_business_na.BUSINESS_ID = '".$bus_id."' AND CLIENT_ID = '".$client_id."') as has_liked
									FROM u_business_na
									WHERE  BUSINESS_ID = '".$bus_id."'");
					   //CLIENT_ID = '".$client_id."'
		$row = $query->row();			   
		if($row->has_liked != $client_id){		   
			//var_dump($row);
			$connections = $this->get_my_na_connections($bus_id);
			$c = $row->na_count;
			if($row->na_count != null && $row->na_count == 0){
				$c = 0;
			}
			$str = "<span style='font-size:11px' class='muted'>".$c." <em>Connections:</em></span><br />".$connections['str']."";
				
			echo '<a onclick="my_na_yes('.$bus_id.')" class="my_na"><span></span></a>';
			echo '<script data-cfasync="false" type="text/javascript">$("#'.$bus_id.'").popover({ delay: { show: 100, hide: 3000 },
			placement:"'.$place.'",trigger: "hover", title:"!na THIS - My Na &trade;", 
			html: true, content:"<strong>!na</strong> this business to connect with them<br />'.$str.'"});</script>'; 
				
		}else{
			$c = $row->na_count;
			if($row->na_count != null && $row->na_count == 0){
				$c = 0;
			}
			echo '<a class="my_na na"><span></span></a>';
			echo '<script data-cfasync="false" type="text/javascript">$("#'.$bus_id.'").popover({ placement:"'.$place.'",
			trigger: "hover", title:"!na THIS - My Na &trade;", html: true, content:"You are already connected to this business<br /><span class='."'badge'".'>'.$c.'</span>"});
			</script>'; 	
			
		}
	}
	
	//CLICK BUTTON
	 function my_na_click($bus_id, $client_id, $place) {
		
		$query = $this->db->query("select * FROM u_business_na WHERE CLIENT_ID = '".$client_id."' AND BUSINESS_ID = '".$bus_id."'");
						   
		if($query->num_rows() == 0){		   
				
				$data = array(
						
						'BUSINESS_ID' => $bus_id,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_business_na',$data);
				
				//UPDATE CLIENT POINTS
				$this->update_client_point($client_id, '1', $bus_id, 'na');
				
				echo '<a class="my_na na"><span></span></a>';
				echo '<script data-cfasync="false" type="text/javascript">$("#'.$bus_id.'").popover("destroy");
				$("#'.$bus_id.'").popover({ placement:"'.$place.'",trigger: "manual",html: true, 
				title:"!na THIS - My Na &trade;", content:"You are now connected to this business and will receive updates and specials"});
				$("#'.$bus_id.'").popover("show");
				</script>';
				
		}else{
			
			echo '<a title="You are already connected to this business" rel="tooltip" class="my_na na"><span></span></a>';
			echo '<script data-cfasync="false" type="text/javascript">$("#'.$bus_id.'").popover({ placement:"'.$place.'",trigger: "hover",
			 title:"!na THIS - My Na &trade;",html: true, content:"You are already connected to this busines"});</script>';
		}
	}
		

    //GET CONNECTIONS
	function get_my_na_connections($bus_id) {
		
		$query = $this->db->query("select u_business_na.CLIENT_ID, u_client.CLIENT_PROFILE_PICTURE_NAME, u_client.CLIENT_NAME, u_client.CLIENT_SURNAME , 
									(SELECT COUNT(BUSINESS_ID) FROM u_business_na WHERE BUSINESS_ID = '".$bus_id."') as na_count
									FROM u_business_na
									JOIN u_client ON u_business_na.CLIENT_ID = u_client.ID  
									WHERE BUSINESS_ID = '".$bus_id."' ORDER BY RAND() LIMIT 4");
		$str = '';				   
		if($query->num_rows() != 0){		   
			$data = array();
			$x = 0;
			
			foreach($query->result() as $row){
				
					$img = $row->CLIENT_PROFILE_PICTURE_NAME;
					
					if($img != ''){
						
						 $str .= "<img src='". S3_URL."assets/users/photos/".$img."' rel='tooltip' title='".$row->CLIENT_NAME . " " . $row->CLIENT_SURNAME."' class='img-polaroid pop' style='width:38px;height:38px' />";
						 
					}else{
						
						 $str .= "<img src='".base_url('/')."img/user_blank.jpg' rel='tooltip' title='".$row->CLIENT_NAME . " " . $row->CLIENT_SURNAME."' class='img-polaroid pop' style='width:38px;height:38px' />";
					}
						
					
				$x ++;
				
			}
			$data['str'] = $str; 
			$data['count'] = $row->na_count;
			return $data;
		
		}else{
			
			$x['str'] = "<span class='label'>No Connections</span>";
			//$x[1] = '';
			$x['count'] = 0;
			return $x;
			
		}
	}

    //UPDATE USER POINTS
	function update_client_point($client_id, $points, $bus_id, $type) {
		
			  $this->db->where('CLIENT_ID',$client_id);
	 
			  //PRODUCT REVIEW
			  if($type == 'product_review')
			  {

				  $data = array(

					  'PRODUCT_ID'  => $bus_id,
					  'BUSINESS_ID' => 0,
					  'POINTS'      => $points,
					  'TYPE'        => $type,
					  'CLIENT_ID'   => $client_id
				  );
			  //FB POST SHARE
			  }elseif($type == 'fb_share'){

				  $data = array(

					  'FB_POST_ID' => $bus_id,
					  'POINTS' => $points,
					  'TYPE' => $type,
					  'CLIENT_ID' => $client_id
				  );

				  //BUSINESS REVIEW
			  }else{
				  
				  $data = array(

					  'BUSINESS_ID' => $bus_id,
					  'POINTS' => $points,
					  'TYPE' => $type,
					  'CLIENT_ID' => $client_id
				  );  
				  
				  
			  }

			  $this->db->insert('u_client_points',$data);
			  
			  //UPDATE SUMMARY TABLE
			  $this->update_client_point_summary($client_id, $points);

	}
	
	
	//UPDATE USER POINTS SUMMARY
	function update_client_point_summary($client_id, $points) {
		
		$this->db->where('CLIENT_ID',$client_id);
		$query = $this->db->get('u_client_points_summary');
						   
		if($query->num_rows() == 0){		   
				
				if($points < 0){
					
					$points = 0;
				
				}
				$data = array(
						
						'POINTS' => $points,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_client_points_summary',$data);
				
				
		}else{

			
			$query = $this->db->query("UPDATE u_client_points_summary SET POINTS = GREATEST(POINTS + ".$points." ,0) WHERE CLIENT_ID = '".$client_id."'");
		}	
		$this->session->set_userdata('points',$points);
		
	}
	
	//+++++++++++++++++++++++++++++++++++
	//SHOW CLAIM BUSINESS IF NO USERS ASSIGNED TO BUSINESS
	//++++++++++++++++++++++++++++++++++
	
	function claim_business($bus_id){
		
		$query = $this->db->query("SELECT u_client.*, i_client_business.USER_TYPE, i_client_business.ID as cID
									FROM u_client JOIN i_client_business ON u_client.ID = i_client_business.CLIENT_ID
									WHERE  i_client_business.BUSINESS_ID = '".$bus_id."'",FALSE);	
		if($query->result()){
			
					
			
		}else{
			
			
				echo '<div class="clearfix" style="height:20px;"></div><div class="alert"><h4>Is this your business?</h4> if this is your business you can claim it and take full control of it.
				 Promote your business with My Na online tools.<br /><br />
				<a href="#" class="btn btn-inverse" onclick="claim_business()">Claim business</a></div>';
				$exit_str1 = "javascript:$('#modal-claim').modal('hide')"; 
				echo '<div id="modal-claim" class="modal hide fade">
						<div class="modal-header">
						  <a href="javascript:void(0)" onclick="'.$exit_str1.'" class="close">&times;</a>
						  <h3>Claim this business listing</h3>
						</div>
						 <div class="modal-body">';
						 if($this->session->userdata('id')){
						 	$data['bus_id'] = $bus_id;
						 	$this->load->view('business/inc/business_claim_inc', $data); 
						   
						 }else{
							 
							echo '<div class="clearfix" style="height:20px;"></div><div class="alert"><h4>Please create a FREE account</h4> To claim a business you need to be logged in and have a FREE My Namibia account.
								Please login or create an account below.<br /><br />';
								$this->load->view('inc/login_form');
								echo '
								</div>';

						 }
						 
						echo '</div>
						<div class="modal-footer">
						  <a href="javascript:void(0)" onclick="'.$exit_str1.'" class="btn btn-secondary">Cancel</a>
						</div>
					</div>';
					echo 
					'<script data-cfasync="false" type="text/javascript">
						
						$(document).ready(function(){
							
							//$(body)append("");
							
						});
						function claim_business(){
	
							$("#modal-claim").appendTo("body").unbind("show").bind("show", function() {
								var Btn = $(this).find(".btn-secondary");
									
									Btn.unbind("click").click(function(e) { 
											
										$("#modal-claim").modal("hide");
													
									});
							}).modal({ backdrop: true });
							
						}
					
					</script>';
					
			
		}
	}
	


	//+++++++++++++++++++++++++++++++++++
	//SHOW CLAIM BUSINESS IF NO USERS ASSIGNED TO BUSINESS
	//++++++++++++++++++++++++++++++++++
	
	function show_business_deal($bus_id){
		
		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' 
									AND SPECIALS_EXPIRE_DATE > NOW() AND BUSINESS_ID = '".$bus_id."' ORDER BY SPECIALS_EXPIRE_DATE 
									ASC LIMIT 1" ,FALSE);
									
		if($query->result()){
				echo '<link rel="stylesheet" type="text/css" href="'.base_url('/').'css/jquery.countdown.css">
					  <script data-cfasync="false" type="text/javascript" src="'.base_url('/').'js/jquery.countdown.min.js"></script>
					  <div id="fb-root"></div>
					  <script data-cfasync="false" src="https://connect.facebook.net/en_US/all.js"></script>
					  <div id="deal_msg_"></div>
					 ';
				
				foreach($query->result() as $row){
					
					if($row->SPECIALS_IMAGE_NAME == ''){
						
						$img = base_url('/').'img/user_blank.jpg';
						
					}else{
						
						$img = base_url('/').'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
						
					}
					
					$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$row->SPECIALS_IMAGE_NAME."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".$this->clean_url_str($row->SPECIALS_HEADER)."')";
					$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
					);
	
					
					
					$tweet_url = 'http://my.na/deal/'.$this->clean_url_str($row->SPECIALS_HEADER).'&text='.substr(strip_tags($row->SPECIALS_HEADER . ' ' . $row->SPECIALS_CONTENT) ,0, 100).'&via=MyNamibia';
					
					echo ' <div class="row-fluid">
								<div class="span12  results_div">
								<div class="span8">
									<img class="lazy" src="'.base_url('/').'img/deal_place_load.gif" alt="'.strip_tags($row->SPECIALS_HEADER).'" data-original="'.$img.'" />
								</div>
								<div class="span4">
										<div style="width:100%;height:190px;">
										<div style="float:right;">
											<a onclick="'.$fb.'" class="facebook"></a>
											'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
										</div>
										<h1 style="font-size:50px;height:40px;color:#FF9F01;"><font style=" font-size:12px">N$</font>'.$row->SPECIALS_PRICE.'</h1>	
										<h3 style="font-size:16px;line-height:20px;height:40px;">'.$row->SPECIALS_HEADER.'</h3>
										<div class="clearfix" style="height:5px;"></div>
										<div style="font-size:10px;">'.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 37).'</div>
										</div>
										<div class="clearfix" style="height:20px;"></div>
										<div  id="ctdwn_'.$row->ID.'"></div>
										<div class="clearfix" style="height:15px;"></div>
										
										
										<div class="clearfix" style="height:20px;"></div>
										<a class="btn btn-warning" href="'.site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER).'/" > View Deal</a>
										
										<div class="clearfix" style="height:20px;"></div>
									</div>
							</div>	
						  </div>
						  <script data-cfasync="false" type="text/javascript">
						  $(function () {
								
								ctdwn_'.$row->ID.' = new Date('.date('Y',strtotime($row->SPECIALS_EXPIRE_DATE)).', '.(date('m',strtotime($row->SPECIALS_EXPIRE_DATE)) - 1).', ' .date('d',strtotime($row->SPECIALS_EXPIRE_DATE)).');
								$("#ctdwn_'.$row->ID.'").countdown({until: ctdwn_'.$row->ID.'});
								
							});
					
						  </script>';
					
				}
				$fb_share_key = '';//$this->encrypt('fb_share');
				$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
				$register_btn = "<a href='".site_url('/')."members/register/' class='btn btn-inverse btn-block'> Join My Na</a>";
				$claim_btn = "<a onclick='' href='javascript:void(0)' id='claim_btn_do' class='btn btn-block btn-inverse'><i class='icon-star-empty icon-white'></i> Grab Deal</a>";
				echo ' <script data-cfasync="false" type="text/javascript">
	
							$(document).ready(function(){
								$("img.lazy").lazyload({
									  effect : "fadeIn"
								  });
							
							});
						  </script>';
				
				
			 }else{
				
		
				 
			 }
	
	}
		
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+GEt QR VCARD Code TO CALL
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_qr_vcard($bus_id, $w, $h)
		{
		 
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		if ( ! $output = $this->cache->get('get_qr_vcard_'.$bus_id.'_'.$w.'_'.$h))
		{

			$this->db->from('u_business');
			$this->db->where('ID',$bus_id);
	       	$query = $this->db->get();	
			$row = $query->row_array();
			
			if ($query->row_array() > 0){
			
				$tel = $row['BUSINESS_TELEPHONE'];
				$org = $row['BUSINESS_NAME'];
				$street = $row['BUSINESS_PHYSICAL_ADDRESS'];
				$post = $row['BUSINESS_POSTAL_BOX'];
				$email = $row['BUSINESS_EMAIL'];
				$url = $row['BUSINESS_URL'];
				
				//CHECK IF EXISTING FILE EXISTS
				if (file_exists(S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'.jpg')) {
	  
	 				 $vcard2 = S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'.jpg" alt=" Vcard for' . $org . ' - My Namibia' . '" 
					title="Vcard for' . $org . ' - My Namibia' . '" style="width:'.$w.'px;height:'.$h.'px"/>';
		
				} else {
				    //save QR file	
					$this->load->library('Ciqrcode');
					$vcard1 = 'BEGIN:VCARD'."\n";
					$vcard1 .= 'ORG:' . trim($org) ."\n";
					$vcard1 .= 'TEL:' . trim($tel) ."\n";
					$vcard1 .= 'EMAIL:' . trim($email) ."\n";
					$vcard1 .= 'URL:' . trim($url) ."\n";
					$vcard1 .= 'ADR:;;' . trim($street). ';PO BOX:' . trim($post) ."\n";
					$vcard1 .= 'END:VCARD';
						
							
					/*$vcard2 = '<img src="http://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($vcard1) . '&amp;size=250x250" alt=" Vcard for' . $org . ' - My Child' . '" 
					title="Vcard for' . $org . ' - My Child' . '" />';*/
					
					
					$params['data'] = $vcard1;
					$params['level'] = 'H';
					$params['size'] = 10;
					$params['savename'] = BASE_URL .'assets/business/qr/' .$row['ID']. $this->clean_url_str($org) . '.jpg';
					$this->ciqrcode->generate($params);
					//SEND TO BUCKET
					$this->load->model('gcloud_model');
					$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , 'assets/business/qr/');
					
					$vcard2 = '<img src="'.S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'.jpg" alt=" Vcard for' . $org . ' - My Namibia' . '" 
					title="Vcard for' . $org . ' - My Namibia' . '" class="img-fluid" style="width:100%; height:100%;" />';

				}		
			}

			$this->cache->save('get_qr_vcard_'.$bus_id.'_'.$w.'_'.$h, $output, 600);
		}	
			
		return $vcard2;		  
			
}	

	function get_qr_vcard_src($bus_id)
		{
		 
		 $this->db->from('u_business');
		 $this->db->where('ID',$bus_id);
       	 $query = $this->db->get();	
		 $row = $query->row_array();
			
			if ($query->row_array() > 0){
			
				$tel = $row['BUSINESS_TELEPHONE'];
				$org = $row['BUSINESS_NAME'];
				$street = $row['BUSINESS_PHYSICAL_ADDRESS'];
				$post = $row['BUSINESS_POSTAL_BOX'];
				$email = $row['BUSINESS_EMAIL'];
				$url = $row['BUSINESS_URL'];
				
				//CHECK IF EXISTING FILE EXISTS
				if (file_exists(S3_URL .'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'.jpg')) {
	  
	 				 $vcard2 = S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'.jpg';
		
				} else {
				    //save QR file	
					$this->load->library('ciqrcode');
					$vcard1 = 'BEGIN:VCARD'."\n";
					$vcard1 .= 'ORG:' . trim($org) ."\n";
					$vcard1 .= 'TEL:' . trim($tel) ."\n";
					$vcard1 .= 'EMAIL:' . trim($email) ."\n";
					$vcard1 .= 'URL:' . trim($url) ."\n";
					$vcard1 .= 'ADR:;;' . trim($street). ';PO BOX:' . trim($post) ."\n";
					$vcard1 .= 'END:VCARD';
						
							
					/*$vcard2 = '<img src="http://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($vcard1) . '&amp;size=250x250" alt=" Vcard for' . $org . ' - My Child' . '" 
					title="Vcard for' . $org . ' - My Child' . '" />';*/
		
					$params['data'] = $vcard1;
					$params['level'] = 'H';
					$params['size'] = 10;
					$params['savename'] = BASE_URL .'assets/business/qr/' .$row['ID']. $this->clean_url_str($org) . '.jpg';
					$this->ciqrcode->generate($params);
					//SEND TO BUCKET
					$this->load->model('gcloud_model');
					$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , 'assets/business/qr/');
					$vcard2 = S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'.jpg';

				}		
			}
			
		return $vcard2;		  
			
}
		
	function get_qr_url_src($bus_id)
		{
		 $this->load->library('ciqrcode');
		 $this->db->from('u_business');
		 $this->db->where('ID',$bus_id);
       	 $query = $this->db->get();	
		 $row = $query->row_array();
			
			if ($query->row_array() > 0){
			
				$tel = $row['BUSINESS_TELEPHONE'];
				$org = $row['BUSINESS_NAME'];
				$street = $row['BUSINESS_PHYSICAL_ADDRESS'];
				$post = $row['BUSINESS_POSTAL_BOX'];
				$email = $row['BUSINESS_EMAIL'];
				$url = $row['BUSINESS_URL'];
				
				//CHECK IF EXISTING FILE EXISTS
				if (file_exists(BASE_URL .'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'_url.jpg')) {
	  
	 				 $vcard2 = base_url().'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'_url.jpg';
		
				} else {
				    //save QR file	
		
					$vcard1 = site_url('/').'b/'.$bus_id.'/'.$this->clean_url_str($org).'/';
						
		
					$params['data'] = $vcard1;
					$params['level'] = 'H';
					$params['size'] = 10;
					$params['savename'] = BASE_URL .'assets/business/qr/' .$row['ID']. $this->clean_url_str($org) . '_url.jpg';
					$this->ciqrcode->generate($params);
					//SEND TO BUCKET
					$this->load->model('gcloud_model');
					$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , 'assets/business/qr/');
					$vcard2 = base_url().'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'_url.jpg';

				}		
			}
			
		return $vcard2;		  
			
}		


	function get_qr_url($bus_id)
		{
		 
		 $this->db->from('u_business');
		 $this->db->where('ID',$bus_id);
       	 $query = $this->db->get();	
		 $row = $query->row_array();
			
			if ($query->row_array() > 0){
			
				$tel = $row['BUSINESS_TELEPHONE'];
				$org = $row['BUSINESS_NAME'];
				$street = $row['BUSINESS_PHYSICAL_ADDRESS'];
				$post = $row['BUSINESS_POSTAL_BOX'];
				$email = $row['BUSINESS_EMAIL'];
				$url = $row['BUSINESS_URL'];
				
				//CHECK IF EXISTING FILE EXISTS
				if (file_exists(S3_URL .'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'_url.jpg')) {
	  
	 				  $vcard2 = S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'_url.jpg" alt=" Vcard for' . $org . ' - My Namibia' . '" 
					title="Vcard for' . $org . ' - My Namibia' . '" style="width:295px;height:295px"/>';
		
				} else {
				    //save QR file	
		
					$vcard1 = site_url('/').'b/'.$bus_id.'/'.$this->clean_url_str($org).'/';
					$this->load->library('ciqrcode');	
		
					$params['data'] = $vcard1;
					$params['level'] = 'H';
					$params['size'] = 10;
					$params['savename'] = BASE_URL .'assets/business/qr/' .$row['ID']. $this->clean_url_str($org) . '_url.jpg';
					$this->ciqrcode->generate($params);
					//SEND TO BUCKET
					$this->load->model('gcloud_model');
					$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , 'assets/business/qr/');
					$vcard2 = S3_URL.'assets/business/qr/'.$row['ID']. $this->clean_url_str($org) .'_url.jpg" alt=" Vcard for' . $org . ' - My Namibia' . '" 
					title="Vcard for' . $org . ' - My Namibia' . '" style="width:295px;height:295px"/>';

				}		
			}
			
		return $vcard2;		  
			
}

//SAVE QR IMAGE TO PROFILE DIRECTORY
function save_vcard_qr($bus_id)
{
	
	if (file_exists('./profile/' . $bus_id . '/images/vcard_qr.jpg')) {
	  
	  //delete
		unlink('./profile/' . $bus_id . '/images/vcard_qr.jpg');
	  	copy($this->get_qr_vcard_url($bus_id), './profile/' . $bus_id . '/images/vcard_qr.jpg');
		
	} else {
	//save QR file	
	   copy($this->get_qr_vcard_url($bus_id), './profile/' . $bus_id . '/images/vcard_qr.jpg');
	}	
	

}


//PRINT BUSINESS ANALYTICS
function print_business_pdf($bus_id, $period = '', $title = ''){
	//error_reporting(0);
	//error_reporting(E_ALL);
	error_reporting(E_ALL);
	$key = $this->config->item('phantomjscloudjey');
	$url = 'https://PhantomJsCloud.com/api/browser/v2/'.$key.'/';
	//$url = 'http://PhantomJScloud.com/api/browser/v2/a-demo-key-with-low-quota-per-ip-address/';
	//$payload = file_get_contents ( 'request.json' );
	$payload =  array(
		"url" => 'https://www.my.na/business/analytics/'.$bus_id.'/'.$period,
	    "renderType" => "pdf",
	    "renderSettings" => array(
				"quality"=> 100,
				"pdfOptions"=> array(
					"border"=> null,
					"footer"=> array(
						"firstPage"=> null,
						"height"=> "1cm",
						"lastPage"=> null,
						"onePage"=> null,
						"repeating"=> "%pageNum%/%numPages%"
					),
					"format"=> "A4",
					"header"=> null,
					"height"=> null,
					"orientation"=> "portrait",
					"width"=> null
				),
				"clipRectangle"=> null,
				"renderIFrame"=> null,
				"viewport"=>  array(
					"height"=> 1280,
					"width"=> 1280
				),
				"zoomFactor"=> 1,
				"passThroughHeaders"=> false
			)	
	);
	//echo json_encode($payload);
	$options = array(
	    'http' => array(
	        'header'  => "Content-type: application/json\r\n",
	        'method'  => 'POST',
	        'content' => json_encode($payload)
		)
	);

	$context  = stream_context_create($options);

	//var_dump($context);
	$result = file_get_contents($url, false, $context);

	//var_dump($result);
	if ($result === FALSE) { 
		/* Handle error */ 
		//echo 'Error';
		$data['success'] = false;
		$data['error'] = json_encode($result);
		return $data;
	}else{

		if(!is_dir(BASE_URL."assets/business/pdf/")){
		  mkdir(BASE_URL."assets/business/pdf/");
		}

		if($title == ''){
			$final_url = 'assets/business/pdf/'.$bus_id.'_'.$period.'.pdf';
		}else{
			$final_url = 'assets/business/pdf/'.$this->my_na_model->clean_url_str($title).'_'.$period.'.pdf';
		}
		
		//Delete existing
		if(file_exists(BASE_URL.$final_url)){
			unlink(BASE_URL.$final_url);
		}
		if(file_put_contents(BASE_URL.$final_url , $result)){
			$data['success'] = true;
			//$data['pdf'] = base64_encode($result);
			$data['pdf_link'] = $final_url;
			return $data;
		}else{
			$data['success'] = false;
			$data['error'] = 'Could not save PDf';
			return $data;

		}
		
	}


}


	
	/**
++++++++++++++++++++++++++++++++++++++++++++
//PHONE NUMBER VALIDATIONS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */ 
  //+++++++++++++++++++++++++++
	//PREPEND CELL
	//++++++++++++++++++++++++++	
	function clean_contact($nr)
	{	
		//$nr = '+264 (0) 8171717 23';
		//remove ' ' , (, ), +
		$str1 = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('+','',$nr))));
		//get 1st 3 digits
		$str2 = substr($str1,0,3);
		
		if($str2 == '264'){

			$str3 = str_replace("264","",$str1);
			
		}else{

			$str3 = $str1;
		}
		
		return $str3;
		
		
	}		
    //+++++++++++++++++++++++++++
	//VALIDATE CELL
	//++++++++++++++++++++++++++	
	function validate_cell($nr)
	{
		switch($nr)
			{
			case '081':
			  
			  $val = FALSE;
			  return $val;
			  break;
			case '085':
			 
			 $val = FALSE;
			 return $val;
			 break;
			case '060':
			  
			 $val = FALSE;
			 return $val;
			 break;
			default:
			  $val = TRUE;
			  return $val;
			  
			}	
	}
/**
++++++++++++++++++++++++++++++++++++++++++++
//VALIDATE EMAIL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function CheckAndValidateEmail($mail){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        // ok
        //list($user,$domaine)=split("@",$mail,2);
        //if(!checkdnsrr($domaine,"MX")&& !checkdnsrr($domaine,"A")){
            return FALSE;
        //}
       // else {
           // return FALSE;
        //}
    }
    else {
        return TRUE;
    }
}

	
		 
}
?>