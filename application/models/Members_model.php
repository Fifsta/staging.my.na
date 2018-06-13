<?php

class Members_model extends CI_Model
{
		
	public function __construct()
    {
        $this->load->database();
    }
	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+MEMBER Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//Get all Countries For Registration Dropdown
	function get_countries()
	{

		$test = $this->db->get('a_country');

		return $test;
	}

	//Get Account Details
	function get_my_account($id)
	{

		$test = $this->db->where('ID', $id);
		$test = $this->db->get('u_client');

		return $test->row_array();
	}


	//+++++++++++++++++++++++++++
	//GET ALL USERS CONNECTED TO A BUSINESS
	//++++++++++++++++++++++++++
	public function get_business_users($bus_id)
	{
		$query = $this->db->query("SELECT u_client.*, i_client_business.USER_TYPE, i_client_business.ID as cID
								   FROM u_client JOIN i_client_business ON u_client.ID = i_client_business.CLIENT_ID
								   WHERE  i_client_business.BUSINESS_ID = '" . $bus_id . "'", false);


		if ($query->num_rows() > 0)
		{
			$x = 0;

			foreach ($query->result() as $row)
			{

				$location = $this->get_client_location($row->CLIENT_COUNTRY, $row->CLIENT_CITY, $row->CLIENT_SUBURB);
				$dob = '';
				if ($row->CLIENT_DATE_OF_BIRTH != '0')
				{

					$dob = date('Y-m-d', strtotime($row->CLIENT_DATE_OF_BIRTH));

				}

				$type = '<span class="badge badge-secondary">Employee</span>';
				if ($row->USER_TYPE == 'MANAGER')
				{

					$type = '<span class="badge badge-secondary">Manager</span>';

				}

				echo '<tr id="usr-row-'.$row->cID.'">
						<td style="width:8%;"><img src="' . $this->get_avatar($row->ID) . '" alt="" class="img-thumbnail"/> </td>
						<td style="width:32%" valign="middle">' . $row->CLIENT_NAME . ' ' . $row->CLIENT_SURNAME . '</td>
						<td style="width:20%">' . $type . '</td>
						<td style="width:30%">' . $location . '</td>				  	
						<td style="width:10%; text-align:right;min-width:100px;">
						   <a class="btn btn-sm btn-dark usr-remove" data-id="'.$row->cID.'" data-bus="'.$bus_id.'"><i class="fa fa-trash-o"></i></a>
						</td>
					  </tr>';

			}


		}
		else
		{

			$data = '';

		}

		

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET USERS FOR DROPDOWN
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function search_ajax_user($key)
	{

		$key = $this->db->escape_like_str(urldecode($key));
		
		if(filter_var($key, FILTER_VALIDATE_EMAIL)) {
        	// valid address
			//echo 'email'.$key;
			$test = $this->db->query("SELECT u_client.ID as ID, u_client.CLIENT_NAME as FNAME,u_client.CLIENT_SURNAME as SNAME, u_client.CLIENT_PROFILE_PICTURE_NAME as IMG
							 FROM u_client
							 WHERE ( u_client.CLIENT_EMAIL like '%".$key."%') LIMIT 30 ", true);
		
		//MORE THAN 2 WoRDS
		}elseif(str_word_count($key) > 1)
		{

			$str1 = explode(" ", $key);
			//echo var_dump($str1);

			$str2 = '';
			$c = 0;
			foreach ($str1 as $keys)
			{
				if (count($str1) - 1 == $c)
				{
					$end = '';
				}
				else
				{
					$end = ' AND ';

				}
				$str2 .= " u_client.CLIENT_NAME like '%" . $keys . "%' OR u_client.CLIENT_SURNAME like '%" . $keys . "%' " . $end;
				$c++;
			}
			$test = $this->db->query("SELECT u_client.ID as ID, u_client.CLIENT_NAME as FNAME,u_client.CLIENT_SURNAME as SNAME, u_client.CLIENT_PROFILE_PICTURE_NAME as IMG
							 FROM u_client
							 WHERE (" . $str2 . ") LIMIT 30 ", true);

	
 
		}
		else
		{

			$test = $this->db->query("SELECT u_client.ID as ID, u_client.CLIENT_NAME as FNAME,u_client.CLIENT_SURNAME as SNAME, u_client.CLIENT_PROFILE_PICTURE_NAME as IMG
							 FROM u_client
							 WHERE (u_client.CLIENT_NAME like '%" . $key . "%' OR u_client.CLIENT_SURNAME like '%" . $key . "%') LIMIT 30 ", true);
		}

		
		if ($test->result())
		{

			echo '<div style="padding:10px 10px 0px 10px"><table class="table table-striped table-hover">';
			$x = 0;
			foreach ($test->result() as $row)
			{

				if ($row->IMG != '' || $row->IMG != null)
				{

					//Build image string
					$format = substr($row->IMG, (strlen($row->IMG) - 4), 4);
					$str = substr($row->IMG, 0, (strlen($row->IMG) - 4));

					if (strstr($row->IMG, "http"))
					{

						$img = $row->IMG . '?width=100&height=100';

					}
					elseif (strpos($row->IMG, '.') == 0)
					{

						$format = '.jpg';
						$img =  S3_URL . 'assets/users/photos/' . $row->IMG . $format;

					}
					else
					{

						$img =  S3_URL . 'assets/users/photos/' . $row->IMG;

					}


				}
				else
				{

					$img = base_url('/') . 'img/user_blank.jpg';

				}
				$sub_id = $row->ID;
				$sub_name = $row->FNAME . ' ' . $row->SNAME;
				$str = '';
				if ($x == 0)
				{
					$str = ' style="border:0"';
				}
				echo '<tr>
									<td ' . $str . '>
									<div style="text-decoration:none;height:100%;width:100%;display:inline-block;"><div style="font-size:16px;color:#333;font-weight:bold">
										<img src="' . $img . '" class="img-polaroid pull-left" style="width:20px;height:20px;margin-right:10px"> ' . $sub_name . ' <a class="btn btn-inverse pull-right"
										onclick="add_user_do(' . $sub_id . ')" href="javascript:void(0)" id="add-' . $sub_id . '">Add</a></div>
									</div>
									</td>
								 </tr>';

				$x++;

			}
			echo ' </table></div>';

		}


	}

	//+++++++++++++++++++++++++++
	//GET ALL BUSINESS FOR USER
	//++++++++++++++++++++++++++
	public function get_businesses($id)
	{
		//$query = $this->db->query('SELECT u_business.*
		//FROM   u_business LEFT JOIN i_client_business USING (CLIENT_ID)
		//WHERE  u_business.CLIENT_ID = '.$id.' OR i_client_business.CLIENT_ID = '.$id,FALSE);

		$query = $this->db->query("SELECT * FROM u_business
                                    JOIN i_client_business ON u_business.ID = i_client_business.BUSINESS_ID
                                    WHERE i_client_business.CLIENT_ID = '" . $id . "'
                                    ");

		if ($query->num_rows() > 0)
		{
			$x = 0;
			foreach ($query->result_array() as $row)
			{

				$bus_id = $row['BUSINESS_ID'];
				$data[$x]['BUSINESS_ID'] = $bus_id;

				$data[$x]['BUSINESS_NAME'] = $row['BUSINESS_NAME'];
				$data[$x]['BUSINESS_LOGO_IMAGE_NAME'] = $row['BUSINESS_LOGO_IMAGE_NAME'];
				$data[$x]['BUSINESS_DESCRIPTION'] = $row['BUSINESS_DESCRIPTION'];

				$x++;

			}

			return $data;

		}
		else
		{

			$data = '';

			return $data;


		}


	}

	//+++++++++++++++++++++++++++
	//POPULATE REGIONS FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_region($cunt_id)
	{

		$this->db->where('COUNTRY_ID', $cunt_id);
		$this->db->from('a_map_region');
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{

			echo '<div class="control-group">
                  <label class="control-label" for="region">Region</label>
                  <div class="controls">
              			<select onchange="populateSuburb(this.value);" id="region" name="region" class="span4">';

			foreach ($query->result() as $row)
			{

				$region = $row->REGION_NAME;
				$reg_id = $row->ID;

				echo '<option value="' . $reg_id . '">' . $region . '</option>';


			}
			echo '</select>
                </div>
              </div>';
		}
		else
		{

			return;
		}
	}
	//+++++++++++++++++++++++++++
	//POPULATE CITIES FOR COUNTRIES
	//++++++++++++++++++++++++++
	public function populate_city($cunt_id, $city_current)
	{
		//SEE IF NAMIBIA
		if ($cunt_id == '151')
		{

			$this->db->order_by('MAP_LOCATION', 'ASC');
			$query = $this->db->get('a_map_location');

			if ($query->num_rows() > 0)
			{

				if ($this->agent->referrer() == site_url('/') . 'members/register/' || $this->agent->referrer() == site_url('/') . 'members/register' || $this->agent->referrer() == site_url('/') . 'my_admin/home/')
				{


				}
				else
				{

				}
				echo '<div class="form-group row">
					  <label for="city" class="col-sm-1 col-form-label">City</label>
					  	<div class="col-sm-10">
							<select onchange="populateSuburb(this.value);" id="city" name="city"  class="form-control">
							<option value="0">Please Select your City</option>';

				foreach ($query->result() as $row)
				{

					$city = $row->MAP_LOCATION;//ucwords(filter_var(utf8_encode($row->MAP_LOCATION), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));

					$city_id = $row->ID;

					if ($city_current == $city_id)
					{
						$str = 'selected="selected"';
					}
					else
					{
						$str = '';
					}

					echo '<option value="' . $city_id . '" ' . $str . ' >' . $city . '</option>';


				}
				echo '</select>
					</div>
				  </div>';
			}
			else
			{


			}
		}
	}

	//+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS
	//++++++++++++++++++++++++++
	public function populate_suburb($reg_id, $suburb_current)
	{

		$this->db->where('CITY_ID', $reg_id);
		$this->db->from('a_map_suburb');
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{

			if ($this->agent->referrer() == site_url('/') . 'members/register/' || $this->agent->referrer() == site_url('/') . 'members/register')
			{

			}
			else
			{

			}

			echo '<div class="form-group row">
					  <label for="city" class="col-sm-1 col-form-label">Suburb</label>
                  	  <div class="col-sm-10">
              			<select id="suburb" name="suburb" class="form-control">
						<option value="0">Please Select your Suburb</option>';

			foreach ($query->result() as $row)
			{

				$suburb = $row->SUBURB_NAME;
				$sub_id = $row->ID;

				if ($suburb_current == $sub_id)
				{
					$str = 'selected="selected"';
				}
				else
				{
					$str = '';
				}

				echo '<option value="' . $sub_id . '" ' . $str . ' >' . $suburb . '</option>';


			}
			echo '</select>

                </div>
              </div>';
		}
		else
		{

			return;
		}
	}



	
	//+++++++++++++++++++++++++++
	//POPULATE SUBURBS FOR REGIONS
	//++++++++++++++++++++++++++
	public function populate_suburb_name($reg, $suburb_current)
	{

//		$this->db->where('SUBURB_NAME' , $reg);
//		$this->db->from('a_map_suburb');
//		$query = $this->db->get();
		$query = $this->db->query("SELECT * FROM a_map_location JOIN a_map_suburb ON a_map_location.ID = a_map_suburb.CITY_ID WHERE a_map_location.MAP_LOCATION = '" . $reg . "'", false);
		if ($query->num_rows() > 0)
		{


			echo '<select id="suburb" name="suburb" class="span12">
						<option value="">Please Select</option>';

			foreach ($query->result() as $row)
			{

				$suburb = $row->SUBURB_NAME;
				$sub_id = $row->ID;

				if ($suburb_current == $suburb)
				{
					$str = 'selected="selected"';
				}
				else
				{
					$str = '';
				}

				echo '<option value="' . $suburb . '" ' . $str . ' >' . $suburb . '</option>';


			}
			echo '</select>

               ';
		}
		else
		{

			echo '<select id="suburb" name="suburb" class="span12" disabled="disabled"></select>';
		}
	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //Upload AVATAR
	 * //Functions
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */ 

	function add_avatar()
	{
		$img = $this->input->post('userfile', true);
		$user_id = $this->input->post('user_id', true);

		//upload file

		$config['upload_path'] = BASE_URL . 'assets/users/photos/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '8024';
		$config['max_width'] = '8324';
		$config['max_height'] = '8550';
		$config['min_width'] = '200';
		$config['min_height'] = '200';
		$config['remove_spaces'] = true;
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);

		if (! $this->upload->do_upload())
		{

			$data['id'] = $user_id;
			$data['error'] = $this->upload->display_errors();
			$this->load->view('members/home', $data);

		}
		else
		{
			//LOAD library
			$this->load->library('image_lib');
			//delete old photo
			$this->delete_old_avatar($user_id);

			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;
			$file_no_ext = $data['upload_data']['raw_name'];
			//CONVERT TO JPEG
			if (strtolower($type) != '.jpg')
			{

				//$input = $config['upload_path'].$file;
				//$output = $config['upload_path'].$file_no_ext.'.jpg';

				$input_file = $config['upload_path'] . $file;
				$output_file = $config['upload_path'] . $file_no_ext . '.jpg';
				$this->load->model('image_model');

				if ($this->image_model->convert_jpeg($input_file, $output_file))
				{

					$file = $file_no_ext . '.jpg';
				}

			}
			if (($width > 850) || ($height > 700))
			{

				$this->downsize_image($file, $user_id);

			}

			//UDATE SESSION
			$this->session->set_userdata('img_file', $file);
			//Watermark image
			$this->watermark_avatar($file);

			//populate array with values
			$data = array(
				'CLIENT_PROFILE_PICTURE_NAME' => $file

			);
			//insert into database
			$this->db->where('ID', $user_id);
			$this->db->update('u_client', $data);

			//Tourism DB
			/*$db2 = $this->connect_tourism_db();
			$db2->where('ID', $user_id);
			$db2->update('u_client', $data);*/

			//SEND TO BUCKET
			$this->load->model('gcloud_model');
			$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/users/photos/');
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
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //Upload AVATAR AJAX
	 * //Functions
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */

	function add_avatar_ajax()
	{
		$img = $this->input->post('userfile', true);
		$user_id = $this->input->post('user_id', true);

		//upload file
		$config['upload_path'] = BASE_URL . 'assets/users/photos/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size'] = '8024';
		$config['max_width'] = '8324';
		$config['max_height'] = '8550';
		$config['min_width'] = '200';
		$config['min_height'] = '200';
		$config['remove_spaces'] = true;
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);

		if (! $this->upload->do_upload())
		{

			$data['id'] = $user_id;
			$data['error'] = $this->upload->display_errors();
			echo
			'<div class="alert alert-error">
     			<button type="button" class="close" data-dismiss="alert">×</button>' . $data['error'] . '
   			 </div>';

		}
		else
		{

			//LOAD library
			$this->load->library('image_lib');

			//delete old photo
			$this->delete_old_avatar($user_id);

			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;
			$file_no_ext = $data['upload_data']['raw_name'];


			//CONVERT TO JPEG
			if (strtolower($this->upload->file_ext) != '.jpg')
			{
				$input_file = $config['upload_path'] . $file;
				$output_file = $config['upload_path'] . $file_no_ext . '.jpg';
				$this->load->model('image_model');

				if ($this->image_model->convert_jpeg($input_file, $output_file))
				{
					$file = $file_no_ext . '.jpg';
				}
			}


			if (($width > 850) || ($height > 700))
			{
				$this->downsize_image($file, $user_id);
			}

			//MEMBER LOGGED IN
			if ($this->session->userdata('id'))
			{
				//UDATE SESSION
				$this->session->set_userdata('img_file', $file);
			}

			//Watermark image
			$this->watermark_avatar($file);

			//populate array with values
			$data = array(
				'CLIENT_PROFILE_PICTURE_NAME' => $file
			);
			
			//insert into database
			$this->db->where('ID', $user_id);
			$this->db->update('u_client', $data);

			//SEND TO BUCKET
			$this->load->model('gcloud_model');
			$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/users/photos/');

			//load respective view
			$data['id'] = $user_id;

			//get sizes
			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = base_url('/') . 'assets/users/photos/' . $file;

			//redirect
			$data['basicmsg'] = 'Avatar added successfully!';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '
       			  </div>

				  <script type="text/javascript">avatar_upload_success("' . $image . '");</script>
				  ';

			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DOWNSIZE AVATAR
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file, $id)
	{

		$config = array(
			'image_library'  => 'GD2',
			'source_image'   => (BASE_URL . 'assets/users/photos/' . $file),
			'master_dim'     => 'auto',
			'width'          => '800',
			'height'         => '800',
			'maintain_ratio' => true
		);


		$this->image_lib->initialize($config);
		if (! $this->image_lib->resize())
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
	function delete_old_avatar($user_id)
	{

		$this->db->where('ID', $user_id);
		$this->db->from('u_client');
		$query = $this->db->get();
		$row = $query->row_array();
		//has existing image
		if ($row['CLIENT_PROFILE_PICTURE_NAME'] != '')
		{

			$file_large = BASE_URL . 'assets/users/photos/' . $row['CLIENT_PROFILE_PICTURE_NAME']; # build the full path

			if (file_exists($file_large))
			{
				unlink($file_large);
			}

			//delete image
			$idata['CLIENT_PROFILE_PICTURE_NAME'] = '';
			$this->db->where('ID', $user_id);
			$this->db->update('u_client', $idata);

			return;

			//no existing image	
		}
		else
		{

			return;
		}

	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//WATERMARK AVATAR
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//create a downsized thumbnail
	function watermark_avatar($file)
	{

		//$id = $this->input->post('pro_id');

		$config['source_image'] = BASE_URL . 'assets/users/photos/' . $file;
		$config['wm_type'] = 'overlay';
		$config['wm_overlay_path'] = BASE_URL . 'img/icons/watermark.png';
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

		if (! $this->image_lib->watermark())
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

	function get_business_details($bus_id)
	{

		$test = $this->db->where('ID', $bus_id);
		$test = $this->db->get('u_business');

		return $test->row_array();

	}


	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //Upload LOGO
	 * //Functions
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */

	function add_logo()
	{
		$img = $this->input->post('userfile', true);
		$user_id = $this->input->post('id', true);
		$bus_id = $this->input->post('bus_id', true);
		$name = $this->input->post('bus_name', true);
		$name1 = str_replace('.', '_', $this->clean_url_str($name)) . '-' . rand(9, 99999);
		//upload file

		$config['upload_path'] = BASE_URL . 'assets/business/photos/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';

		$config['max_size'] = '0';
		$config['max_width'] = '0';
		$config['max_height'] = '0';
		$config['min_width'] = '200';
		$config['min_height'] = '200';
		$config['remove_spaces'] = true;
		//$config['encrypt_name']  = TRUE;
		$config['file_name'] = $name1;

		$this->load->library('upload', $config);

		if (! $this->upload->do_upload())
		{

			$data['id'] = $user_id;
			$data['bus_id'] = $bus_id;
			$data['error'] = $this->upload->display_errors();
			$this->load->view('members/business_details', $data);

		}
		else
		{
			//LOAD library
			$this->load->library('image_lib');
			//delete old photo
			$this->delete_old_logo($bus_id);


			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;
			$file_no_ext = $data['upload_data']['raw_name'];

			$format = substr($file, (strlen($file) - 4), 4);
			$str = substr($file, 0, (strlen($file) - 4));
			//Convert To jpg
			$this->convert_logo_jpg($str, $file);

			if (($width > 850) || ($height > 700))
			{

				$this->downsize_logo($file, $bus_id);

			}
			//Watermark image
			//$this->watermark_logo($file);

			//populate array with values
			$data = array(
				'BUSINESS_LOGO_IMAGE_NAME' => $file

			);
			//insert into database
			$this->db->where('ID', $bus_id);
			$this->db->update('u_business', $data);
			//Tourism DB
			/*$db2 = $this->connect_tourism_db();
			$db2->where('ID', $bus_id);
			$db2->update('u_business', $data);*/
			//SEND TO BUCKET
			$this->load->model('gcloud_model');
			$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/business/photos/');

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
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //Upload AVATAR AJAX
	 * //Functions
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */

	function add_logo_ajax()
	{
		
		$img = $this->input->post('userfile', true);
		$user_id = $this->input->post('id', true);
		$bus_id = $this->input->post('bus_id', true);
		$name = $this->input->post('bus_name', true);
		$name1 = str_replace('.', '_', $this->clean_url_str($name)) . '-' . rand(9, 99999);

		//upload file

		$config['upload_path'] = BASE_URL . 'assets/business/photos/';
		//$config['upload_path'] = 'gs://my-na-bucket-eu/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|PNG|GIF|JPEG';
		$config['max_size'] = '8024';
		$config['max_width'] = '8324';
		$config['max_height'] = '8550';
		$config['min_width'] = '200';
		$config['min_height'] = '200';
		$config['remove_spaces'] = true;
		//$config['encrypt_name']  = TRUE;
		$config['file_name'] = $name1;

		$this->load->library('upload', $config);

		if (! $this->upload->do_upload())
		{
			$data['id'] = $user_id;
			$data['bus_id'] = $bus_id;
			$data['error'] = $this->upload->display_errors();

			if ($_SERVER['HTTP_REFERER'] == CMS_URL . 'admin/my_namibia/')
			{

				//$this->output->set_header("HTTP/1.0 200 OK");
				echo "<script>
						$.noty.closeAll()
						var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
						noty(options); 
						
						</script>";

			}
			else
			{

				echo
					'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>'
					. $data['error'] . '
						 </div>';
			}


		}
		else
		{
			//LOAD library
			$this->load->library('image_lib');
			//delete old photo
			$this->delete_old_logo($bus_id);

			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file, (strlen($file) - 4), 4);
			$str = substr($file, 0, (strlen($file) - 4));
			//Convert To jpg
			$this->convert_logo_jpg($str, $file);

			if (($width > 850) || ($height > 700))
			{

				$this->downsize_logo($file, $bus_id);

			}
			//Watermark image
			//$this->watermark_logo($file);

			//populate array with values
			$data = array(
				'BUSINESS_LOGO_IMAGE_NAME' => $file

			);
			//insert into database
			$this->db->where('ID', $bus_id);
			$this->db->update('u_business', $data);

			//Tourism DB
			/*$db2 = $this->connect_tourism_db();
			$db2->where('ID', $bus_id);
			$db2->update('u_business', $data);*/

			//UPLOAD TO BUCKET
			$this->load->model('gcloud_model');
			$out = $this->gcloud_model->upload_gc_bucket(BASE_URL.'assets/business/photos/' . $file , '/assets/business/photos/');

			//load respective view
			$data['id'] = $user_id;
			$data['bus_id'] = $bus_id;
			//get sizes
			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = S3_URL . 'assets/business/photos/' . $file;

			//redirect
			$data['basicmsg'] = 'Logo added successfully!';

			if ($_SERVER['HTTP_REFERER'] == CMS_URL . 'admin/')
			{

				$this->output->set_header("HTTP/1.0 200 OK");
				echo "<script>
						$.noty.closeAll()
						var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
						noty(options); 
						logo_upload_success('" . $image . "');
						</script>";

			}
			else
			{


				echo '<div class="alert alert-success">
							<button type="button" class="close" data-dismiss="alert">×</button>
							' . $data['basicmsg'] . '
							 </div>
							 <script type="text/javascript">logo_upload_success("' . $image . '");</script>
							 ';
				$this->output->set_header("HTTP/1.0 200 OK");
			}

		}


	}


	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //Upload COVER IMAGE
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */

	function add_cover()
	{
		$img = $this->input->post('userfile1', true);
		$user_id = $this->input->post('id1', true);
		$bus_id = $this->input->post('bus_id1', true);
		$name = $this->input->post('bus_name1', true);
		//$name1 = str_replace('.','_', str_replace('(','-',str_replace(')','-',$name))).'-' . rand(9,99999);

		$name1 = str_replace('--', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $name)) . rand(9, 99999);

		$this->load->library('encryption');

		if (isset($_FILES['userfile1']))
		{

			$_FILES['userfile']['name'] = $_FILES['userfile1']['name'];
			$_FILES['userfile']['type'] = $_FILES['userfile1']['type'];
			$_FILES['userfile']['tmp_name'] = $_FILES['userfile1']['tmp_name'];
			$_FILES['userfile']['error'] = $_FILES['userfile1']['error'];
			$_FILES['userfile']['size'] = $_FILES['userfile1']['size'];


		}

		//upload file

		$config['upload_path'] = BASE_URL . 'assets/business/photos/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|PNG|GIF|JPEG';
		$config['max_size'] = '8024';
		$config['min_width'] = 750;
		$config['min_height'] = 300;
		$config['remove_spaces'] = true;
		//$config['encrypt_name']  = TRUE;
		$config['file_name'] = $name1;

		$this->load->library('upload', $config);

		if (! $this->upload->do_upload())
		{
			$data['id'] = $user_id;
			$data['bus_id'] = $bus_id;
			$data['error'] = $this->upload->display_errors();

			if ($_SERVER['HTTP_REFERER'] == CMS_URL . 'admin/my_namibia/')
			{

				//$this->output->set_header("HTTP/1.0 200 OK");
				echo "<script>
						$.noty.closeAll()
						var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
						noty(options); 
						
						</script>";

			}
			else
			{

				echo
					'<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>'
					. $data['error'] . '
						 </div>';
			}


		}
		else
		{
			//LOAD library
			$this->load->library('image_lib');
			//delete old photo
			$this->delete_old_cover($bus_id);

			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file, (strlen($file) - 4), 4);
			$str = substr($file, 0, (strlen($file) - 4));


			if (($width > 1850) || ($height > 800))
			{

				$this->downsize_cover($file, $bus_id);

			}

			//Watermark image
			// $this->watermark_logo($file);

			//populate array with values
			$data = array(
				'BUSINESS_COVER_PHOTO' => $file

			);
			//insert into database
			$this->db->where('ID', $bus_id);
			$this->db->update('u_business', $data);

			//Tourism DB
			// $db2 = $this->connect_tourism_db();
			// $db2->where('ID', $bus_id);
			// $db2->update('u_business', $data);
			//SEND TO BUCKET
			$this->load->model('gcloud_model');
			$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/business/photos/');

			//load respective view
			$data['id'] = $user_id;
			$data['bus_id'] = $bus_id;
			//get sizes
			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = S3_URL . 'assets/business/photos/' . $file;
			$btn_path = site_url('/') . 'my_images/edit_image/' . urlencode($this->encryption->encrypt('assets/business/photos/' . $file));
			
			//redirect
			$data['basicmsg'] = '<h4>Do you want to crop the photo?</h4>Your cover photo has been uploaded, do you want to crop your photo to fit the box?
				 <a href="' . $btn_path . '" class="btn btn-inverse pull-right" rel="tooltip" title="Cover Image 750 pixels x 300 pixels" style="margin:5px"><i class="icon-retweet icon-white"></i> Crop Image Now</a>
				 <div class="clearfix" style="height:10px;"></div>
				 ';

			if ($_SERVER['HTTP_REFERER'] == CMS_URL . 'admin/')
			{

				$this->output->set_header("HTTP/1.0 200 OK");
				echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
					  noty(options); 
					  cover_upload_success('" . $image . "');
					  </script>";

			}
			else
			{


				echo '<div class="alert alert-success alert-block">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  ' . $data['basicmsg'] . '
						   </div>
						   <script type="text/javascript">cover_upload_success("' . $image . '", "' . $btn_path . '");</script>
						   ';
				$this->output->set_header("HTTP/1.0 200 OK");
				
			}

		}


	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE OLD COVER
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function delete_old_cover($bus_id)
	{

		$this->db->where('ID', $bus_id);
		$this->db->from('u_business');
		$query = $this->db->get();

		if ($query->result())
		{
			$row = $query->row_array();
			//has existing image
			if ($row['BUSINESS_COVER_PHOTO'] != '')
			{

				$file_large = BASE_URL . 'assets/business/photos/' . $row['BUSINESS_COVER_PHOTO']; # build the full path

				if (file_exists($file_large))
				{
					unlink($file_large);
				}

				//delete image
				$idata['BUSINESS_COVER_PHOTO'] = '';
				$this->db->where('ID', $bus_id);
				$this->db->update('u_business', $idata);

				return;

				//no existing image	
			}
			else
			{

				return;
			}
		}
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//DOWNSIZE COVER
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_cover($file, $id)
	{

		$config = array(
			'image_library'  => 'GD2',
			'source_image'   => (BASE_URL . 'assets/business/photos/' . $file),
			'master_dim'     => 'width',
			'width'          => '1000',
			'height'         => '500',
			'maintain_ratio' => true
		);


		$this->image_lib->initialize($config);
		if (! $this->image_lib->resize())
		{
			$data['error'] = $this->image_lib->display_errors();

			return $data;
		}
		$this->image_lib->clear();

		return;
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE LOGO
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_logo($file, $id)
	{

		$config = array(
			'image_library'  => 'GD2',
			'source_image'   => (BASE_URL . 'assets/business/photos/' . $file),
			'master_dim'     => 'auto',
			'width'          => '800',
			'height'         => '800',
			'maintain_ratio' => true
		);


		$this->image_lib->initialize($config);
		if (! $this->image_lib->resize())
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

	function convert_logo_jpg($str, $file)
	{


		$config = array(
			'image_library' => 'ImageMagick',
			'library_path'  => '/usr/bin',
			'source_image'  => ('./assets/business/photos/' . $file),
			'new_image'     => './assets/business/photos/' . $str . '.jpg'

		);

		$this->image_lib->initialize($config);

		$this->image_lib->clear();

		return;
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE OLD LOGO
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function delete_old_logo($bus_id)
	{

		$this->db->where('ID', $bus_id);
		$this->db->from('u_business');
		$query = $this->db->get();

		$row = $query->row_array();
		//has existing image
		if ($row['BUSINESS_LOGO_IMAGE_NAME'] != '')
		{

			$file_large = BASE_URL . 'assets/business/photos/' . $row['BUSINESS_LOGO_IMAGE_NAME']; # build the full path

			if (file_exists($file_large))
			{
				unlink($file_large);
			}

			//delete image
			$idata['BUSINESS_LOGO_IMAGE_NAME'] = '';
			$this->db->where('ID', $bus_id);
			$this->db->update('u_business', $idata);

			return;

			//no existing image	
		}
		else
		{

			return;
		}

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//WATERMARK LOGO
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//create a downsized thumbnail
	function watermark_logo($file)
	{

		//$id = $this->input->post('pro_id');

		$config['source_image'] = BASE_URL . 'assets/business/photos/' . $file;
		$config['wm_type'] = 'overlay';
		$config['wm_overlay_path'] = BASE_URL . 'img/icons/watermark.png';
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

		if (! $this->image_lib->watermark())
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
	function downsize_gallery_image($file)
	{

		$config = array(
			'image_library'  => 'GD2',
			'source_image'   => (BASE_URL . 'assets/business/gallery/' . $file),
			'master_dim'     => 'auto',
			'width'          => '800',
			'height'         => '800',
			'maintain_ratio' => true
		);


		$this->image_lib->initialize($config);
		if (! $this->image_lib->resize())
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
	function watermark_gallery_image($file)
	{

		//$id = $this->input->post('pro_id');

		$config['source_image'] = BASE_URL . 'assets/business/gallery/' . $file;
		$config['wm_type'] = 'overlay';
		$config['wm_overlay_path'] = BASE_URL . 'img/icons/watermark.png';
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

		if (! $this->image_lib->watermark())
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

		$this->load->model('image_model'); 

		$this->load->library('thumborp');
		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 360;
		$height = 230;


		$query = $this->db->where('BUSINESS_ID', $bus_id);
		$query = $this->db->get('u_gallery_component');
		//IF have children
		if ($query->num_rows() > 0)
		{


			$x = 0;
			foreach ($query->result() as $row)
			{
				$id = $row->ID;
				$img_file = $row->GALLERY_PHOTO_NAME;
				//$title = $row->CLIENT_PHOTO_TITLE;

				if ($img_file != '')
				{

					if (strpos($img_file, '.') == 0)
					{

						$format = '.jpg';
						$img_str = 'assets/business/gallery/' . $img_file . $format;
						$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

					}
					else
					{

						$img_str = 'assets/business/gallery/' . $img_file;
						$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

					}

				}
				else
				{

					$img_str = 'assets/business/gallery/bus_blank.jpg';
					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

				}


				//NO TIMBTHUMB
				echo '<div class="col-md-2" style="position:relative">
							<img src="' . $img_url . '" />
							<button style="position:absolute; margin:-35px 5px;" class="btn btn-dark gal-link" data-id="' . $id . '" data-toggle="modal" data-target="#modal-img-delete"><i class="fa fa-trash"></i></button>
					  </div>';
				$x++;


			}


		}
		else
		{

			echo '<div class="alert alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h4>No Gallery Images Added</h4>
					Please add some gallery images to enhance your business listing by clicking on the select images button below
				  </div>';
		}


	}




	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET M<AP
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	//Get MAP Details
	function get_map_details($ID)
	{

		$test = $this->db->where('BUSINESS_ID', $ID);
		$test = $this->db->get('u_business_map');

		return $test->row_array();
	}

	//UPDATE MAP COORDINATES
	function update_map_coordinates()
	{

		$user_id = $this->input->post('id', true);
		$bus_id = $this->input->post('bus_id', true);
		$lat = $this->input->post('lat', true);
		$lng = $this->input->post('lng', true);

		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('u_business_map');


		if ($test->num_rows() > 0)
		{

			//populate array with values
			$data = array(
				'BUSINESS_MAP_LATITUDE'  => $lat,
				'BUSINESS_MAP_LONGITUDE' => $lng

			);

			//update database
			$this->db->where('BUSINESS_ID', $bus_id);
			$this->db->update('u_business_map', $data);

			/*$db2 = $this->connect_tourism_db();
			$db2->where('ID', $bus_id);
			$has = $db2->get('u_business', $bus_id);

			if($has->result()){

				$db2->where('BUSINESS_ID', $bus_id);
				$db2->update('u_business_map', $data);

			}*/


		}
		else
		{

			//populate array with values
			$data = array(
				'BUSINESS_MAP_LATITUDE'   => $lat,
				'BUSINESS_MAP_LONGITUDE'  => $lng,
				'BUSINESS_ID'             => $bus_id,
				'BUSINESS_MAP_ZOOM_LEVEL' => '13'
			);

			$this->db->insert('u_business_map', $data);
			/*$db2 = $this->connect_tourism_db();
			$db2->where('ID', $bus_id);
			$has = $db2->get('u_business', $bus_id);

			if($has->result()){

				$db2->insert('u_business_map',$data);

			}*/


		}

		return;

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS CATEGORIES
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	//Get Main Categories
	function get_main_categories()
	{

		$test = $this->db->get('a_tourism_category');

		return $test;
	}

	//GEt sub Categories
	function get_sub_categories($cat_id)
	{

		$test = $this->db->where('CATEGORY_TYPE_ID', $cat_id);
		$test = $this->db->get('a_tourism_category_sub');

		return $test;

	}

	//GEt Current Categories
	function get_current_categories($bus_id)
	{

		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('i_tourism_category');

		return $test;

	}

	//GEt CATEGORY NAME
	function get_category_name($cat_id_cur)
	{

		$test = $this->db->where('ID', $cat_id_cur);
		$test = $this->db->get('a_tourism_category_sub');
		$row = $test->row_array();

		return $row['CATEGORY_NAME'];

	}

	//GEt CATEGORY NAME
	function add_new_category($cat_id, $bus_id)
	{

		//++++++++++++++++++++++++++++++++++++++++++++++++++++++
		//NEED TO VALIDATE HOW MANY CATEGORIES THE BUSINESS HAS
		//++++++++++++++++++++++++++++++++++++++++++++++++++++++	

		$data = array(
			'BUSINESS_ID' => $bus_id,
			'CATEGORY_ID' => $cat_id,
			'IS_ACTIVE'   => 'N'

		);
		//insert into database
		$this->db->insert('i_tourism_category', $data);


	}

	//DELETE CATEGORY
	function delete_category($cat_id, $bus_id)
	{

		//test if it was ajax or POST
		$ajax = $this->uri->segment(5);

		if ($ajax != 'ajax')
		{

			//delete from database
			$test = $this->db->where('CATEGORY_ID', $cat_id);
			$test = $this->db->where('BUSINESS_ID', $bus_id);
			$this->db->delete('i_tourism_category');

			return 'redirect';

		}
		else
		{

			//delete from database
			$test = $this->db->where('CATEGORY_ID', $cat_id);
			$test = $this->db->where('BUSINESS_ID', $bus_id);
			$this->db->delete('i_tourism_category');

			return '';
		}

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET BUSINESS GALLERY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	//Get Main Business Gallery
	function get_gallery($bus_id)
	{

		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('u_gallery_component');

		return $test;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD NEW CLIENT ID INTO INTERSECTION TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function add_business_member($bus_id, $id)
	{


		$data = array(
			'BUSINESS_ID' => $bus_id,
			'CLIENT_ID'   => $id
		);
		//insert into database
		$this->db->insert('i_client_business', $data);


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//BUSINESS 
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++			
	function get_business_($bus_id)
	{


	}

	function get_business_impressions($bus_id, $period, $value)
	{

		$table_date = date('Y') . '_' . $value;

		//IN FUTURE so SKIP
		if ($value > idate('m'))
		{


			return 0;

		}
		else
		{

			if($this->db->table_exists("u_business_impressions_" . $table_date)){
				$query = "select COUNT(*) as TOTAL FROM u_business_impressions_" . $table_date . "
							WHERE " . $period . "(TIMESTAMP) = '" . $value . "' AND BUSINESS_ID = '" . $bus_id . "'";

				$query = $this->db->query($query);

				if ($query->result())
				{

					$row = $query->row_array();

					return $row['TOTAL'];

				}
				else
				{

					return 0;

				}
			}else{

				return 0;
			}

		}


	}

	function get_business_clicks($bus_id, $period, $value)
	{

		$table_date = date('Y') . '_' . $value;

		//IN FUTURE so SKIP
		if ($value > idate('m'))
		{


			return 0;

		}
		else
		{

			$query = $this->db->query("select COUNT(*) as TOTAL FROM u_business_clicks
						  WHERE " . $period . "(TIMESTAMP) = '" . $value . "' AND BUSINESS_ID = '" . $bus_id . "'");

			if ($query->result())
			{

				$row = $query->row_array();

				return $row['TOTAL'];

			}
			else
			{

				return 0;

			}
		}

	}

	function get_business_enquiries($bus_id, $period, $value)
	{

		//IN FUTURE so SKIP
		if ($value > idate('m'))
		{


			return 0;

		}
		else
		{

			$query = $this->db->query("select COUNT(*) as TOTAL FROM u_business_enquiries   
						WHERE " . $period . "(TIMESTAMP) = '" . $value . "' AND BUSINESS_ID = '" . $bus_id . "'");

			if ($query->result())
			{

				$row = $query->row_array();

				return $row['TOTAL'];

			}
			else
			{

				return 0;

			}
		}
	}


	function get_business_impressions_30($bus_id)
	{

		//GET LAST 30 DAYS
		$month = array();
		$total = array();

		//echo 'data: [';
		$table_date = date('Y') . '_' . date('m');
		//IMPRESSIONS
		for ($i = 0; $i < 15; $i++)
		{


			$vmonth = date("n", strtotime('-' . $i . ' days'));
			$vday = date("d", strtotime('-' . $i . ' days'));

			//echo "['". date("d", strtotime('-'. $i .' days')) . " - " . date("m", strtotime('-'. $i .' days'))."',";

			$query = "select COUNT(*) as TOTAL FROM u_business_impressions_" . $table_date . "
				  WHERE MONTH(TIMESTAMP) = '" . $vmonth . "' AND DAY(TIMESTAMP) = '" . $vday . "' AND BUSINESS_ID = '" . $bus_id . "'";

			$query = $this->db->query($query);

			if ($query->result())
			{

				$row = $query->row_array();
				$total[$i] = $row['TOTAL'];
				//echo "'".$total[$i] ."']".$comma;

			}
			else
			{

				$total[$i] = 0;
				//echo "'".$total[$i] ."']".$comma;
			}


		}

		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($total));

		echo 'data: [';
		$x = 0;
		$y = 14;
		while ($x <= 14)
		{

			if ($x == 14)
			{

				$comma = '';

			}
			else
			{

				$comma = ',';
			}

			echo "['" . date("d", strtotime('-' . ($y - $x) . ' days')) . " - " . date("m", strtotime('-' . ($y - $x) . ' days')) . "',";
			//echo $reverted[$x] . ' ' . $x.'<br />';	
			echo "'" . $reverted[$x] . "']" . $comma;
			$x++;
		}

		echo "]";
	}

	function get_business_clicks_30($bus_id)
	{

		//GET LAST 30 DAYS
		$month = array();
		$total = array();

		//echo 'data: [';

		//IMPRESSIONS
		for ($i = 0; $i < 15; $i++)
		{


			$vmonth = date("n", strtotime('-' . $i . ' days'));
			$vday = date("d", strtotime('-' . $i . ' days'));

			//echo "['". date("d", strtotime('-'. $i .' days')) . " - " . date("m", strtotime('-'. $i .' days'))."',";

			$query = "select COUNT(*) as TOTAL FROM u_business_clicks   
				  WHERE MONTH(TIMESTAMP) = '" . $vmonth . "' AND DAY(TIMESTAMP) = '" . $vday . "' AND BUSINESS_ID = '" . $bus_id . "' AND TYPE = 'view'";

			$query = $this->db->query($query);

			if ($query->result())
			{

				$row = $query->row_array();
				$total[$i] = $row['TOTAL'];
				//echo "'".$total[$i] ."']".$comma;

			}
			else
			{

				$total[$i] = 0;
				//echo "'".$total[$i] ."']".$comma;
			}


		}

		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($total));

		echo 'data: [';
		$x = 0;
		$y = 14;
		while ($x <= 14)
		{

			if ($x == 14)
			{

				$comma = '';

			}
			else
			{

				$comma = ',';
			}

			echo "['" . date("d", strtotime('-' . ($y - $x) . ' days')) . " - " . date("m", strtotime('-' . ($y - $x) . ' days')) . "',";
			//echo $reverted[$x] . ' ' . $x.'<br />';	
			echo "'" . $reverted[$x] . "']" . $comma;
			$x++;
		}

		echo "]";
	}

	function get_business_enquiries_30($bus_id)
	{

		//GET LAST 30 DAYS
		$month = array();
		$total = array();

		//echo 'data: [';

		//IMPRESSIONS
		for ($i = 0; $i < 15; $i++)
		{


			$vmonth = date("n", strtotime('-' . $i . ' days'));
			$vday = date("d", strtotime('-' . $i . ' days'));

			//echo "['". date("d", strtotime('-'. $i .' days')) . " - " . date("m", strtotime('-'. $i .' days'))."',";

			$query = "select COUNT(*) as TOTAL FROM u_business_enquiries   
				  WHERE MONTH(TIMESTAMP) = '" . $vmonth . "' AND DAY(TIMESTAMP) = '" . $vday . "' AND BUSINESS_ID = '" . $bus_id . "'";

			$query = $this->db->query($query);

			if ($query->result())
			{

				$row = $query->row_array();
				$total[$i] = $row['TOTAL'];
				//echo "'".$total[$i] ."']".$comma;

			}
			else
			{

				$total[$i] = 0;
				//echo "'".$total[$i] ."']".$comma;
			}


		}

		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($total));

		echo 'data: [';
		$x = 0;
		$y = 14;
		while ($x <= 14)
		{

			if ($x == 14)
			{

				$comma = '';

			}
			else
			{

				$comma = ',';
			}

			echo "['" . date("d", strtotime('-' . ($y - $x) . ' days')) . " - " . date("m", strtotime('-' . ($y - $x) . ' days')) . "',";
			//echo $reverted[$x] . ' ' . $x.'<br />';	
			echo "'" . $reverted[$x] . "']" . $comma;
			$x++;
		}

		echo "]";
	}

//X-AXIS LABELS
	function get_business_xaxis_30($bus_id)
	{

		//GET LAST 30 DAYS
		$vstr = array();
		$total = array();


		//IMPRESSIONS
		for ($i = 0; $i < 15; $i++)
		{


			$vstr[$i] = date("l", strtotime('-' . $i . ' days')) . ' the ' . date("j", strtotime('-' . $i . ' days')) . ' ' . date("F", strtotime('-' . $i . ' days'));


		}

		//DISPLAY RESULTS FROM INVERTED ARRAY			
		$reverted = new ArrayIterator(array_reverse($vstr));

		echo 'var xAxisLabels = [';
		$x = 0;
		$y = 14;
		while ($x <= 14)
		{

			if ($x == 14)
			{

				$comma = '';

			}
			else
			{

				$comma = ',';
			}

			echo "'" . $reverted[$x] . "'" . $comma;
			$x++;
		}

		echo "]";
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET CTR, AND OVEALL CLICKS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function get_total_clicks($bus_id)
	{

		$query = $this->db->query("SELECT * FROM `u_business_clicks` WHERE BUSINESS_ID = '" . $bus_id . "'", false);

		if ($query->result())
		{
			$p = 0;
			$f = 0;
			$c = 0;
			foreach ($query->result() as $row)
			{

				if ($row->TYPE == 'phone-click')
				{

					$p++;
				}
				elseif ($row->TYPE == 'cell-click')
				{

					$c++;
				}
				elseif ($row->TYPE == 'fax-click')
				{

					$f++;
				}
			}

			echo '<td>' . $p . '</td>
					  <td>' . $c . '</td>
					  <td>' . $f . '</td>';

		}
		else
		{

			echo '<td>0</td>
					  <td>0</td>
					  <td>0</td>';

		}


	}

	function new_password_email($row)
	{

		//create key
		$token = $this->encrypt->sha1($row['ID']);

		//insert data
		$link = '<a href="'.site_url('/').'members/pass_update_two/'.$token.'" >Reset Password Here</a>';

		$data['client_id'] = $row['ID'];
		$data['email'] = $row['CLIENT_EMAIL'];
		$data['name'] = $row['CLIENT_NAME'];
		$data['link'] = $link;
		$data['type'] = 'password';
		$data['token'] = $token;
		$this->db->insert('password_links',$data);


		$data2['link'] = site_url('/').'members/pass_update_two/'.$token;
		$data2['custom'] = $link;
		$data2['name'] = $row['CLIENT_NAME'];

		$body1 = $this->load->view('email/body_email_password',$data2,true);


		$emailTO = array(array('email' => $row['CLIENT_EMAIL']));
		$subject = 'New Password Request - My Namibia';
		$fromEMAIL = 'no-reply@my.na';
		$fromNAME = 'My Namibia';
		$TAG = array('tags' => 'password_reset' );

		$this->load->model('email_model');
		$this->email_model->send_mail($body1, $subject, $emailTO, $fromEMAIL , $fromNAME, $TAG);


	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	/*Hash password*/

	function hash_password($username, $password)
	{

		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));

		// Prefix the password with the salt
		$hash = $salt . $password;

		// Hash the salted password a bunch of times
		for ($i = 0; $i < 100000; $i++)
		{
			$hash = hash('sha256', $hash);
		}

		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;

		return $hash;

	}


	/*Validate password*/

	function validate_password($username, $password)
	{

		$sql = $this->db->query("SELECT *
			  					FROM `u_client`
								WHERE
				  			   `CLIENT_EMAIL` = '" . $username . "' LIMIT 1", true);

		$res = array();
		//SEE IF ROW EVEN EXISTS
		if ($sql->num_rows() > 0)
		{

			$r = $sql->row_array();
			//Store value for return
			$res['CLIENT_NAME'] = $r['CLIENT_NAME'];
			$res['CLIENT_SURNAME'] = $r['CLIENT_SURNAME'];
			$res['ID'] = $r['ID'];
			$res['CLIENT_EMAIL'] = $r['CLIENT_EMAIL'];
			$res['CLIENT_CELLPHONE'] = $r['CLIENT_CELLPHONE'];
			$res['CLIENT_GENDER'] = $r['CLIENT_GENDER'];
			$res['CLIENT_DATE_OF_BIRTH'] = $r['CLIENT_DATE_OF_BIRTH'];
			$res['CLIENT_COUNTRY'] = $r['CLIENT_COUNTRY'];
			$res['CLIENT_CITY'] = $r['CLIENT_CITY'];
			$res['CLIENT_OCCUPATION'] = $r['CLIENT_OCCUPATION'];
			$res['FB_ID'] = $r['FB_ID'];
			$res['VERIFIED'] = $r['VERIFIED'];
			$res['CLIENT_PROFILE_PICTURE_NAME'] = $r['CLIENT_PROFILE_PICTURE_NAME'];
			$res['LAST_LOGIN'] = $r['LAST_LOGIN'];
			$res['REGISTER_DATE'] = $r['REGISTER_DATE'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['CLIENT_PASSWORD'], 0, 64);

			$hash = $salt . $password;

			// Hash the password as we did before
			for ($i = 0; $i < 100000; $i++)
			{
				$hash = hash('sha256', $hash);
			}

			$hash = $salt . $hash;

			if ($hash == $r['CLIENT_PASSWORD'])
			{

				$res['bool'] = 'YES';
				//break;
			}
			else
			{

				$res['bool'] = 'NO';

			}

		}
		else
		{//no username match

			$res['bool'] = false;
		}

		return $res;
	}



	//+++++++++++++++++++++++++++
	//GATE ALL TNA FOR BUSINESS
	//++++++++++++++++++++++++++
	public function get_business_tna($bus_id)
	{

		$query = $this->db->query("SELECT u_client.ID, u_client.CLIENT_EMAIL,u_client.CLIENT_GENDER,u_client.CLIENT_OCCUPATION,
									 u_client.CLIENT_CELLPHONE, CONCAT(u_client.CLIENT_NAME, ' ', u_client.CLIENT_SURNAME) as NAME, 
									u_client.CLIENT_PROFILE_PICTURE_NAME,IFNULL(u_client.CLIENT_DATE_OF_BIRTH,0) as DOB, IFNULL(u_client.CLIENT_CITY,0) as CLIENT_CITY, IFNULL(u_client.CLIENT_SUBURB, 0) as CLIENT_SUBURB,
									 IFNULL(u_client.CLIENT_COUNTRY, 0) as CLIENT_COUNTRY FROM u_client
									JOIN u_business_na ON u_client.ID = u_business_na.CLIENT_ID
									WHERE u_business_na.BUSINESS_ID = '" . $bus_id . "'", false);

		if ($query->result())
		{
			echo '<h3>!nas <small>My Namibia</small></h3>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="tna_list" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:25%">Full Name </th>
						<th style="width:25%">Occupation </th>
						<th style="width:25%">Current City </th>
						<th style="width:10%">DOB</th>
						<th style="width:10%; text-align:right"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row)
			{


				$location = $this->get_client_location($row->CLIENT_COUNTRY, $row->CLIENT_CITY, $row->CLIENT_SUBURB);
				$dob = '';
				if ($row->DOB != '0')
				{

					$dob = date('Y-m-d', strtotime($row->DOB));

				}

				echo '<tr>
						<td style="width:5%;min-width:40px"><img src="' . $this->get_avatar($row->ID) . '" alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:25%">' . $row->NAME . '</td>
						<td style="width:25%">' . $row->CLIENT_OCCUPATION . '</td>
						<td style="width:25%">' . $location . '</td>
						<td style="width:10%">' . $dob . '</td>
					  	<td style="width:10%; text-align:right"></td>
					  </tr>';

			}

			$tablestr = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:5px;"></div>
				<div id="tnaCarousel" class="carousel slide">
      
						  <!-- Carousel items -->
						  <div class="carousel-inner">
							<div class="active item">
								<div class="alert alert-block">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <h4>Impressions?</h4>
								  sometimes called a view or an ad view, is a term that refers to the point in which an ad is viewed once by a visitor, or displayed once on a web page. The number of impressions of a particular advertisement is determined by the number of times the particular page is located and loaded.
								</div>
							</div>
							<div class="item">
								<div class="alert alert-block">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <h4>Clicks?</h4>
								  a click is counted when your business listing page is loaded. A click is only incremented when a unique IP loads the page every hour. This gives you a more accurate estimate of how many times your page has been viewed.
								</div>
							</div>
							<div class="item">
								<div class="alert alert-block">
								  <button type="button" class="close" data-dismiss="alert">&times;</button>
								  <h4>Enquiries?</h4>
								  an enquiry is counted when you receive an enquiry via the contact form on your profile page.
								</div>
							
							</div>
						  </div>
					
				</div>
			    <script type="text/javascript">  
					$(document).ready(function(){   
						   $(".carousel").carousel({
								interval: 5000
							});
							$("#tna_list").dataTable( {
									"sDom": "' . $tablestr . '",
									"sPaginationType": "bootstrap",
									"oLanguage": {
										"sLengthMenu": "_MENU_"
									},
									"aaSorting":[],
									"bSortClasses": false
			
							} );
					} );	
				</script>';

		}

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SHOW !na EMAIL RECIPIENTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function show_tna_recipients($bus_id)
	{


		$query = $this->db->query("SELECT u_client.ID, u_client.CLIENT_EMAIL,u_client.CLIENT_GENDER,u_client.CLIENT_OCCUPATION,
									 u_client.CLIENT_CELLPHONE, CONCAT(u_client.CLIENT_NAME, ' ', u_client.CLIENT_SURNAME) as NAME, 
									u_client.CLIENT_PROFILE_PICTURE_NAME,IFNULL(u_client.CLIENT_DATE_OF_BIRTH,0) as DOB, IFNULL(u_client.CLIENT_CITY,0) as CLIENT_CITY, IFNULL(u_client.CLIENT_SUBURB, 0) as CLIENT_SUBURB,
									 IFNULL(u_client.CLIENT_COUNTRY, 0) as CLIENT_COUNTRY FROM u_client
									JOIN u_business_na ON u_client.ID = u_business_na.CLIENT_ID
									WHERE u_business_na.BUSINESS_ID = '" . $bus_id . "'", false);
		if ($query->result())
		{
			echo '<h4><small><font class="na_script" style="font-size:20px">!na</font> Recipients</small></h4>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="tna_recipient" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%;min-width:40px"></th>
           				<th style="width:25%">Full Name </th>
						<th style="width:25%">Occupation </th>
						<th style="width:25%">Current City </th>
						<th style="width:10%">DOB</th>
						<th style="width:10%; text-align:right"><input type="checkbox" name="selectall" id="selectall"  /></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row)
			{

				$location = $this->get_client_location($row->CLIENT_COUNTRY, $row->CLIENT_CITY, $row->CLIENT_SUBURB);
				$dob = '';
				if ($row->DOB != '0')
				{

					$dob = date('Y-m-d', strtotime($row->DOB));

				}

				echo '<tr>
						<td style="width:5%;min-width:40px"><img src="' . $this->get_avatar($row->ID) . '" alt="" style="width:25px;height:25px" class="img-polaroid"/> </td>
						<td style="width:25%">' . $row->NAME . '</td>
						<td style="width:25%">' . $row->CLIENT_OCCUPATION . '</td>
						<td style="width:25%">' . $location . '</td>
						<td style="width:10%">' . $dob . '</td>
					  	<td style="width:10%; text-align:right"><input type="checkbox" class="case" name="recipients[' . $row->ID . ']" value="' . $row->ID . '"></td>
					  </tr>';
			}

			$tablestr = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<a id="step_1" href="#tnacompose" data-toggle="tab" class="btn pull-right disabled">Next <i class="icon-arrow-right"></i></a>
				<script type="text/javascript">
					$(document).ready(function(){
						$("#step_1").click(function () {
							 $("#tna_step_2_li").addClass("active");
							 $("#tna_step_1_li").removeClass("active");
						});
						  
						$("#selectall").click(function () {
							  $(".case").attr("checked", this.checked);
							  $("#step_1").removeClass("disabled");
							  $("#tna_step_2").fadeIn();
							  if($(".case:checked").length == 0) {
								$("#step_1").addClass("disabled");
								$("#tna_step_2").fadeOut();
							}
						});
						$(".case").click(function(){
							$("#step_1").removeClass("disabled");
							$("#tna_step_2").fadeIn();
							if($(".case").length == $(".case:checked").length) {
								$("#selectall").attr("checked", "checked");
							} else {
								$("#selectall").removeAttr("checked");
							}
							
							if($(".case:checked").length == 0) {
								$("#step_1").addClass("disabled");
								$("#tna_step_2").fadeOut();
							}
						});
						$("#tna_recipient").dataTable( {
								"sDom": "' . $tablestr . '",
								"sPaginationType": "bootstrap",
								"oLanguage": {
									"sLengthMenu": "_MENU_"
								},
								"aaSorting":[],
								"bSortClasses": false
		
						} );
					});
				</script>';

		}

	}

	//+++++++++++++++++++++++++++++++++++
	//SHOW CLAIM BUSINESS
	//++++++++++++++++++++++++++++++++++


	//+++++++++++++++++++++++++++++++++++
	//LOAD SHOW CLAIM BUSINESS
	//++++++++++++++++++++++++++++++++++

	function load_claim_business()
	{

		$this->load->view('members/inc/business_claim_inc');

	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET USER AVATAR
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_avatar($id)
	{ 

		$this->load->model('image_model'); 
		$this->load->library('thumborp');

		$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
		$width = 60;
		$height = 60;

		$this->db->select('ID , CLIENT_PROFILE_PICTURE_NAME as PIC');
		$this->db->where('ID', $id);
		$query = $this->db->get('u_client');
		$row = $query->row_array();

		if ($row['PIC'] != '' || $row['PIC'] != null)
		{

			//Build image string
			$format = substr($row['PIC'], (strlen($row['PIC']) - 4), 4);
			$str = substr($row['PIC'], 0, (strlen($row['PIC']) - 4));

			if (strstr($row['PIC'], "http"))
			{

				$avatar_url = $row['PIC'];


			}
			elseif (strpos($row['PIC'], '.') == 0)
			{

				$format = '.jpg';
				$avatar =  'assets/users/photos/' . $row['PIC'] . $format;
				$avatar_url = $this->image_model->get_image_url_param($thumbnailUrlFactory,$avatar,$width,$height,$crop = '');

			}
			else
			{

				$avatar =  'assets/users/photos/' . $row['PIC'];
				$avatar_url = $this->image_model->get_image_url_param($thumbnailUrlFactory,$avatar,$width,$height,$crop = '');

			}


		}
		else
		{

			$avatar = 'assets/users/photos/user_blank.jpg';
			$avatar_url = $this->image_model->get_image_url_param($thumbnailUrlFactory,$avatar,$width,$height,$crop = '');

		}

		return $avatar_url;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET USER LOCATION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function get_client_location($cunt_id, $city_id, $sub_id)
	{


		//If suburb set
		if ($sub_id != '0')
		{

			$this->db->where('ID', $sub_id);
			$query = $this->db->get('a_map_suburb');
			$location = '';
			if ($query->result())
			{

				$row = $query->row_array();
				$location = $row['SUBURB_NAME'] . ', Windhoek';

			}

			//no suburb but city
		}
		elseif ($city_id != '0')
		{//end if suburb

			$this->db->where('ID', $city_id);
			$query = $this->db->get('a_map_location');
			$location = '';
			if ($query->result())
			{

				$row = $query->row_array();
				$location = $row['MAP_LOCATION'] . ', Namibia';

			}

			//no city but country
		}
		elseif ($cunt_id != '0')
		{//end if city

			$this->db->where('ID', $cunt_id);
			$query = $this->db->get('a_country');
			$location = '';
			if ($query->result())
			{

				$row = $query->row_array();
				$location = $row['COUNTRY_NAME'];

			}
			//nothing
		}
		else
		{

			$location = '';

		}

		return $location;
	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //AMENITIES
	 * //Functions
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */
	function update_amenities($bus_id)
	{
		//header("Content-Type: text/plain");
		$amenity_top_id = $this->input->post('amenity_top_id', true);

		$x = 0;
		//DELETE OLD RECORDS
		$this->db->where('bus_id', $bus_id);
		$this->db->where('amenity_top_id', $amenity_top_id);
		$this->db->delete('u_business_amenities');

		while ($x < 5)
		{

			if (! empty($_POST['amenity_sub_id-' . $x]))
			{

				$num = count($_POST['amenity_sub_id-' . $x]);
				$array = $_POST['amenity_sub_id-' . $x];

				foreach ($_POST['amenity_sub_id-' . $x] as $value)
				{

					$data['amenity_sub_id'] = $x;
					$data['amenity_top_id'] = $amenity_top_id;
					$data['bus_id'] = $bus_id;
					$data['amenity'] = $value;


					//INSERT NEW
					$this->db->insert('u_business_amenities', $data);


				}
			}

			$x++;

		}
		echo '<div class="alert alert-success">Amenities Updated successfully!</div>';

	}

	function get_amenities($bus_id)
	{

		//GET RECORDS
		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('u_business_amenities');

		if ($query->result())
		{

			return $query;

		}
		else
		{

			$query->amenity = '';

			return $query;
		}

	}

	//VALIDATE BUSINESS
	//Shorten String
	function check_business_user($bus_id)
	{

		if ($this->session->userdata('id'))
		{
			$this->db->where('i_client_business.CLIENT_ID', $this->session->userdata('id'));
			$this->db->where('i_client_business.BUSINESS_ID', $bus_id);
			$this->db->join('u_business', 'u_business.ID = i_client_business.BUSINESS_ID');
			$query = $this->db->get('i_client_business');

			if ($query->num_rows() > 0)
			{

				$row = $query->row_array();

				return $row;

			}
			else
			{
				$this->session->set_flashdata('error', 'You do not have access to that business. Goodbye!');

				return false;
			}
		}
		else
		{
			$this->session->set_flashdata('error', 'You do not have access to that business. Goodbye!');

			return false;
		}

	}

	//Shorten String
	function shorten_string($phrase, $max_words)
	{

		$phrase_array = explode(' ', $phrase);

		if (count($phrase_array) > $max_words && $max_words > 0)
		{

			$phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
		}

		return $phrase;

	}

	//CLEAN URL
	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace = array(), $delimiter = '-')
	{
		if (! empty($replace))
		{
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}


	//connect to tourism db
	function connect_tourism_db()
	{

		//connect to main database
		$config_db['hostname'] = '154.0.162.107';
		$config_db['username'] = 'hannamib_devuser';
		$config_db['password'] = 'UI5TrephoWC0';
		$config_db['database'] = 'hannamib_mynatour_devdb';

		//$config_db['username'] = 'root';
		//$config_db['password'] = '';
		//$config_db['database'] = 'my_na';

		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = true;
		$config_db['db_debug'] = true;
		$config_db['cache_on'] = false;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = true;
		$config_db['stricton'] = false;
		$maindb = $this->load->database($config_db, true);
		$this->db->close();

		return $maindb;
	}

}

?>