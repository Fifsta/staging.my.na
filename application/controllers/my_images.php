<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_images extends CI_Controller {
	/**
	 OWNERS
	 */
	function my_images()
	{
		parent::__construct();
		$this->load->model('image_model');
		
	}

	public function index()
	{
		echo 'Going Nowhere slowly!';
		
	}
	
	public function thumbor($file = '')
	{
		
		if($file == ''){
			
			if(!$file = $this->input->get('file', true)){
				
				echo 'error';
			}
			
			
			
		}
		$param['file'] = $file;
		if(!$param['width'] = $this->input->get('width', true)){
			
			$param['width'] = 'auto';
		}
		if(!$param['height'] = $this->input->get('height', true)){
			
			$param['height'] = 'auto';
		}
		
		if(!$param['crop'] = $this->input->get('crop', true)){
			unset($param['crop']);
		}
		if(!$param['filter'] = $this->input->get('filter', true)){
			unset($param['filter']);
		}
		$this->load->library('thumborp');
		
		
		$url =  $this->thumborp->get_image_url($param);
		//var_dump($this->thumbor());
		
		/*$p = '50x50/smart/https://d3rp5jatom3eyn.cloudfront.net/assets/business/photos/intouch-interactive-marketing-980-cover.jpg';
		$s = hash_hmac('sha1', $p, 'hwn80200ymF57s2YQU7bd3Y61xnF', true);
		$url = 'http://52.212.64.167:8001/'.strtr( base64_encode($s), '/+', '_-').'/'.$p;
		*/
		echo '<img src="'.$url.'" /><br />';
		echo $url;
		
		
	}
    //ADD DOCUMENT FROM REDACTOR
	function redactor_add_document()
	{
		
		//$file = $_POST['redactor_file'];
		$img = $this->input->post('file', TRUE);
		if(isset($_FILES['file']['name'])){
			
				   $_FILES['userfile']['name']    = $_FILES['file']['name'];
				   $_FILES['userfile']['type']    = $_FILES['file']['type'];
				   $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				   $_FILES['userfile']['error']       = $_FILES['file']['error'];
				   $_FILES['userfile']['size']    = $_FILES['file']['size'];
				
				
		}
			
			//upload file

			$config['upload_path'] = BASE_URL.'assets/documents/';
			$config['allowed_types'] = 'pdf|xls|xlsx|doc|docx|ppt|pptx';

			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					//$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'{ "filelink": "" }' . $data['error'].$config['upload_path']; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{	
			
			
				//$file = array('upload_data'
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;

				 //populate array with values
				$insertdata = array(
					
					'type' => 'doc',
					'doc_file' => $file

        		);
				//insert into database
				
				$this->db->insert('documents',$insertdata);
				
			   	$data['filename'] = $file;
				
				$doc = base_url('/') . 'assets/documents/'.$file;
			   //redirect 
			    echo '{"filelink": "'.$doc.'"}';
		}	
		
	}
	
    //ADD IMAGE FROM REDACTOR
	function redactor_add_image()
	{
		
		//$file = $_POST['redactor_file'];
		$img = $this->input->post('file', TRUE);
		if(isset($_FILES['file']['name'])){
			
				   $_FILES['userfile']['name']    = $_FILES['file']['name'];
				   $_FILES['userfile']['type']    = $_FILES['file']['type'];
				   $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				   $_FILES['userfile']['error']       = $_FILES['file']['error'];
				   $_FILES['userfile']['size']    = $_FILES['file']['size'];
				
				
		}
			
			//upload file

			$config['upload_path'] = BASE_URL.'assets/business/photos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';

			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					//$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'{ "filelink": "" }' . $data['error'].$config['upload_path']; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{	
			
			
			//$file = array('upload_data'
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	//delete old photo
			//$this->delete_old_child_photo($child_id,$pro_id);
			//$this->update_cover_book_image($child_id,$pro_id,$file);
					 
				if (($width > 1200) || ($height > 1400)){
 
					    $this->image_model->downsize_image($config['upload_path'].$file);
								
				}
 
				 //populate array with values
				$insertdata = array(
					
					'type' => 'img',
					'img_file' => $file

        		);
				//insert into database
				
				$this->db->insert('images',$insertdata);
				
				 //SEND TO BUCKET
			  //$this->load->model('gcloud_model');
			  //$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
			  $this->load->model('cron_model');
			  //UPLOAD S3
			  if(file_exists($config['upload_path'].$file)){

				  $data['out'] = $this->cron_model->upload_s3('assets/business/photos/' . $file);
			  }else{

				  $data['out'] = 'Not Uploaded';

			  }

			   	$data['filename'] = $file;
				
				$image = S3_URL . 'assets/business/photos/'.$file;
			   //redirect 
			    echo '{"filelink": "'.$image.'"}';
		}	
		
	}

 
/**
++++++++++++++++++++++++++++++++++++++++++++
//
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
GALLERY 	
++++++++++++++++++++++++++++++++++++++++++++
//
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
*/
function add_gallery(){
	
	 $this->load->library('upload');  // NOTE: always load the library outside the loop
	 $child_id = $this->input->post('child_id', TRUE);
	 $story_id = $this->input->post('story_id1', TRUE);
	 $pro_id = $this->input->post('pro_id', TRUE);
	 $this->total_count_of_files = count($_FILES['files']['name']);
	 /*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
	
	 for($i=0; $i<$this->total_count_of_files; $i++)
	 {
	
	   $_FILES['userfile']['name']    = $_FILES['files']['name'][$i];
	   $_FILES['userfile']['type']    = $_FILES['files']['type'][$i];
	   $_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
	   $_FILES['userfile']['error']       = $_FILES['files']['error'][$i];
	   $_FILES['userfile']['size']    = $_FILES['files']['size'][$i];
	
	   
	   $config['upload_path'] = './assets/' . $pro_id . '/children/';
	   $config['allowed_types'] = 'jpg|jpeg|gif|png';
	   $config['overwrite']     = FALSE;
	   $config['max_size']	= '0';
	   $config['max_width']  = '8324';
	   $config['max_height']  = '8550';
	   $config['min_width']  = '200';
	   $config['min_height']  = '200';
	   $config['remove_spaces']  = TRUE;
	   $config['encrypt_name']  = TRUE;
	   
	
	  $this->upload->initialize($config);
	
		  if($this->upload->do_upload())
		  {
			//$file = array('upload_data'
			  $data = array('upload_data' => $this->upload->data());
			  $file =  $this->upload->file_name;
			  $width = $this->upload->image_width;
			  $height = $this->upload->image_height;	
			  //delete old photo
			  //$this->delete_old_child_photo($child_id,$pro_id);
			  //$this->update_pro_book_image($child_id,$pro_id,$file);
					   
				  if (($width > 850) || ($height > 700)){
						  
						  $this->load->model('gallery_model');
						  $str = 'children';	 
						  $this->gallery_model->downsize_image($file,$pro_id,$str);
								  
				  }
  					
  				  
				  //populate array with values
				  $data = array(
					  'child_id' => $child_id,
					  'story_id' => $story_id,  
					  'img_file'=> $file
				   
				  );
				  //IF NEW LS
				  if($story_id == '0'){
				 
					  //insert into database
					  
					  $this->db->insert('gallery_images',$data);
				  }else{
					  
					  $this->db->insert('gallery_images',$data);
				  }
				  //load respective view 
				 $data['pro_id'] = $pro_id;
				 
				 //crop 
				  $data['filename'] = $file;
				  $data['width'] = $this->upload->image_width;
				  $data['height'] = $this->upload->image_height;
				  $data['info'] = $this->owner_model->get_child($child_id);
				  $data['parents'] = $this->owner_model->get_parents($pro_id);
				  $image = base_url('/') . 'assets/' . $pro_id.'/children/'.$file;
				 //redirect 
				  $data['basicmsg'] = 'Photo added successfully!';
				  echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  '. $data['basicmsg'].'
					   </div>
					   <script data-cfasync="false"  type="text/javascript">
					  
					   show_gallery('.$story_id.');
					   </script>
					   ';
				  //$this->output->set_header("HTTP/1.0 200 OK");
			
			
		  }else{
			//ERROR
				$data['pro_id'] = $pro_id;
				$data['error'] =  $this->upload->display_errors();
				echo 
				'<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>'
				 . $data['error'].'
				 </div><script data-cfasync="false"  type="text/javascript">
					console.log("error");
					$("#gal-cover").hide();
				</script>'; 
			
		  }
	 }
	

}



	 //+++++++++++++++++++++++++++
	//GET IMAGES FOR EDITOR
	//++++++++++++++++++++++++++
			
	function show_upload_images_json($bus_id)
	{

			$query = $this->db->select('ID, GALLERY_PHOTO_NAME');
			$query = $this->db->from('u_gallery_component');
			$query = $this->db->where('BUSINESS_ID',$bus_id);
			
			$query = $this->db->get();
			
        	if($query->num_rows() > 0){
				$x =0;
				echo '[';
				foreach($query->result() as $row){

					$img_file = $row->GALLERY_PHOTO_NAME;
					$gal_img_id = $row->ID;
					if(($query->num_rows() - $x) == 1){
						
						$close_tag = '';
					}else{
						
						$close_tag = ',';
					}
					
				 
					echo '
					{ "thumb": "'.base_url('/').'img/timbthumb.php?src='.S3_URL.'assets/business/gallery/'.$img_file.'&q=100&w=180&h=130", "image": "'.S3_URL.'assets/business/gallery/'.$img_file.'", "title": "imagetitle"}'.$close_tag;
					
					$x++;
				
				}
				echo ']';
			
				
			}else{
			
				return '0';
			}			
			
			
	}		
	 //+++++++++++++++++++++++++++
	//ADD GALLERY
	//++++++++++++++++++++++++++			
	function add_gallery_do()
	{
		$img = $this->input->post('userfile', TRUE);
			$child_id = $this->input->post('child_id', TRUE);
			$story_id = $this->input->post('story_id', TRUE);
			$pro_id = $this->input->post('pro_id', TRUE);
			//upload file

			$config['upload_path'] = './assets/' . $pro_id . '/children/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['file_name']	= $pro_id . '-' . $child_id . '-' .  date('m-y-d') . 'pro-pic' . rand(0,100). '.jpg';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>'
           			 . $data['error'].'
       				 </div><script data-cfasync="false"  type="text/javascript">
					 	$("#gal-cover").hide();
				    </script>'; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{	
			
			
			//$file = array('upload_data'
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	//delete old photo
			//$this->delete_old_child_photo($child_id,$pro_id);
			//$this->update_pro_book_image($child_id,$pro_id,$file);
					 
				if (($width > 850) || ($height > 700)){
						
						$this->load->model('gallery_model');
						$str = 'children';	 
						$this->gallery_model->downsize_image($file,$pro_id,$str);
								
				}


			   //populate array with values
				$data = array(
					'child_id' => $child_id,
					'story_id' => $story_id,  
			     	'img_file'=> $file
				 
        		);
				//insert into database
				
				$this->db->insert('gallery_images',$data);
				
				//load respective view 
			   $data['pro_id'] = $pro_id;
			   
			   //crop 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
				$data['info'] = $this->owner_model->get_child($child_id);
				$data['parents'] = $this->owner_model->get_parents($pro_id);
				$image = base_url('/') . 'assets/' . $pro_id.'/children/'.$file;
			   //redirect 
			    $data['basicmsg'] = 'Photo added successfully!';
				echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'. $data['basicmsg'].'
       				 </div>
					 <script data-cfasync="false"  type="text/javascript">show_gallery("'.$story_id.'");</script>
					 ';
				$this->output->set_header("HTTP/1.0 200 OK");
		}
	}	

	 //+++++++++++++++++++++++++++
	//EDIT IMAGE
	//++++++++++++++++++++++++++	

	function edit_image($img = '')
	{

		if($this->input->get('img')){

			$img = $this->input->get('img');
		}
		//echo $img. ' 1 ';
		$img = rawurldecode($this->encrypt->decode($img,  $this->config->item('encryption_key')));
		//echo $img. ' POES';
		//GET CURRENT URL
		$data['url'] = $this->agent->referrer();
		//BUILD ABSOLUTE PATH
		$data['absolute_path'] = BASE_URL.$img;
		 //Get Image path
		$data['folder'] = substr($img, 0 , (strlen($img) - strlen(basename($img))));
		$data['path'] = base_url('/').$img;
		
		//GET IMAGE DIMENSIONS ETC
		list($data['width'], $data['height'], $data['type'], $data['attr']) = getimagesize(base_url('/') . $img);
							
				
		$data['filename'] =	$img;
		$data['img'] = $img;

		//var_dump($data);
		$this->load->view('image/edit_image', $data);
				
			
	     	
	}		
		
	/**
	++++++++++++++++++++++++++++++++++++++++++++	
	 CROP IMAGE	
	++++++++++++++++++++++++++++++++++++++++++++
	*/

	//CROP COVER PHOTO
	function crop_cover()
	{
			
			$img = $this->input->post('filename', TRUE);
			$path = $this->input->post('path', TRUE);
			$url = $this->input->post('url', TRUE);
			$this->load->model('image_model');
			$this->image_model->crop_cover_photo($img);

			$data['error'] =  $this->image_lib->display_errors();
				
			$data['basicmsg'] = 'Image cropped successfully!';
			$data['filename'] =	$img;
			$data['img'] = $img;
			
			echo '
				<div class="alert alert-success">'.$data['basicmsg'].'</div>
				<script data-cfasync="false" type="text/javascript">
			
					$("#cropbox").attr("src" , "'.$path.'?'.rand(0,9999).'");
					window.location = "'.$url.'";
				  </script>';
			//redirect($url, 'refresh');	

	     	
	}



	/*
	++++++++++++++++++++++++++++++++++++++++++++
	// ROTATE IMAGES	
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
	*/

	//ROTATE GALLERY PHOTO
	function rotate()
	{
			$this->load->library('image_lib');	
			$angle = $this->input->post('angle', TRUE);
			$file = $this->input->post('img_file_rotate', TRUE);
			$path = $this->input->post('absolute_path_rotate',TRUE);
			$url = $this->input->post('url_rotate',TRUE);
			$config['image_library'] = 'GD2';
			$config['source_image']	= $path;
			
			$config['rotation_angle'] = $angle;
			//90 right =270
			//90 left = 90

			$this->image_lib->initialize($config); 
			
			if ( ! $this->image_lib->rotate())
			{
	
				echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$this->image_lib->display_errors() .'
       				 </div>';
			}else{
				
				$str = $file.'?v='.rand(0,999);
				echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Image rotated successfully.
       				 </div>
					 <script data-cfasync="false"  type="text/javascript">
					  $("#rotate_img_div").delay(3000).removeClass("loading_img");
					  $("#rotate_img").fadeIn("1000").attr("src", "'.$str.'");
					 </script>
					 ';
			}
			
			$this->image_lib->clear();

	     	
	}

	//ROTATE TRADE PHOTO
	function rotate_trade($angle, $filename, $str = '' )
	{
		
		//error_reporting(E_ALL);

		$final['has_image_local'] = false;
		echo $final['has_image_local'];
		//check if exists
		if(file_exists(BASE_URL.'assets/products/images/' . $filename)){

			$final['has_image_local'] = true;

		}else{

			$this->load->model('s3_model');
			$exists = $this->s3_model->exists_upload_s3('assets/products/images/' . $filename);
			$final['exists_object'] = $exists;
			if($exists){

				$final['has_image_local'] = 'on_s3';
				if(copy(S3_URL.'assets/products/images/' . $filename, BASE_URL.'assets/products/images/' . $filename)){
					$final['has_image_local'] = 'copied_from_s3';
				}else{
					$final['has_image_local'] = 'copied_from_s3_failed';
				}

			}else{

				$final['has_image_local'] = 'not_on_s3';

			}
		}

		if($str == '' || $str = 'undefined'){
			
			$str = rand(0,999);
			
		}else{
			
			$str = '';	
		}
		$this->load->library('image_lib');	
		$file = base_url('/').'assets/products/images/'.$filename;
		$path = BASE_URL.'assets/products/images/'.$filename;
		$url = base_url('/').'assets/products/images/'.$filename;

		$fileA = explode('.', $filename);
		
		$new_file = $fileA[0].'_'.$str.'.'.$fileA[1];

		$config['image_library'] = 'GD2';
		$config['source_image']	= $path;
		$config['new_image'] = $new_file;
		$config['rotation_angle'] = $angle;
		//90 right =270
		//90 left = 90

		$this->image_lib->initialize($config); 
		
		if ( ! $this->image_lib->rotate())
		{

			echo '<div class="alert alert-error">
					<button type="button" class="close" data-dismiss="alert">×</button>
					'.$this->image_lib->display_errors() .' '.json_encode($final).' '.$path.'
   				 </div>';
		}else{
			
			
			$newstr = rand(0,999);
			$final['old'] = $newstr;
			$final['src'] = base_url('/').'img/timbthumb.php?src='.'/assets/products/images/' .$new_file.'&w=190&h=130&ed='.$newstr;
			$final['new_filename'] = $new_file;
			$final['filename'] = trim($filename);
			//$final = array('old' => $str, 'src' => base_url('/').'img/timbthumb.php?src='.$file.'&w=190&h=130&ed='.$newstr);

			//SEND TO BUCKET
			//$this->load->model('gcloud_model');
			//$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file, '/assets/products/images/');
			$this->load->model('s3_model');
			//UPLOAD S3
			if(file_exists(BASE_URL.'assets/products/images/' . $new_file)){
				
				$final['s3upload'] = $this->s3_model->upload_s3('assets/products/images/' . $new_file);
				
				$data['edited'] = $str;
				$data['img_file'] = $new_file;
				$this->db->where('img_file', trim($filename));
				$this->db->update('product_images', $data);
				$final['s3_delete_old'] = false;
				//Delete OLD
				if($this->s3_model->delete_s3('assets/products/images/' .trim($filename))){
					$final['s3_delete_old'] = true;
				}
				
			}else{
				
				$final['s3upload'] = 'Not Uploaded';
				
			}

			echo json_encode($final);
		}
		
		$this->image_lib->clear();

	     	
	}




	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//Upload COVER IMAGE
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	function add_cover()
	{
		$img = $this->input->post('userfile1', TRUE);
		$id = $this->input->post('id', TRUE);
		$type = $this->input->post('type', TRUE);

		//$name1 = str_replace('.','_', str_replace('(','-',str_replace(')','-',$name))).'-' . rand(9,99999);

		//$name1 = str_replace('--','-', preg_replace('/[^A-Za-z0-9\-]/', '-', $name)). rand(9,99999);

		if(isset($_FILES['userfile1'])){

			$_FILES['userfile']['name']    = $_FILES['userfile1']['name'];
			$_FILES['userfile']['type']    = $_FILES['userfile1']['type'];
			$_FILES['userfile']['tmp_name'] = $_FILES['userfile1']['tmp_name'];
			$_FILES['userfile']['error']       = $_FILES['userfile1']['error'];
			$_FILES['userfile']['size']    = $_FILES['userfile1']['size'];


		}

		//upload file

		$config['upload_path'] = BASE_URL .'assets/content/photos/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png|JPG|PNG|GIF|JPEG';
		$config['max_size']	= '8024';
		$config['min_width']  = 750;
		$config['min_height']  = 300;
		$config['remove_spaces']  = TRUE;
		$config['encrypt_name']  = TRUE;
		//$config['file_name']  = $name1;

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$data['id'] = $id;
			$data['type'] = $type;
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


			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file,(strlen($file) - 4),4);
			$str = substr($file,0,(strlen($file) - 4));


			if (($width > 1850) || ($height > 800)){

				$this->downsize_cover($file);

			}

			//Watermark image
			// $this->watermark_logo($file);

			//populate array with values
			$data = array(
				'COVER_PHOTO'=> $file

			);

			$db = $this->identify_content($type);

			//insert into database
			$this->db->where('ID', $id);
			$this->db->update($db ,$data);

			//Tourism DB
			// $db2 = $this->connect_tourism_db();
			// $db2->where('ID', $bus_id);
			// $db2->update('u_business', $data);

			//load respective view
			$data['id'] = $id;

			//get sizes
			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = base_url('/') . 'assets/content/photos/'.$file;
			$btn_path = site_url('/').'my_images/edit_image/'. urlencode($this->encrypt->encode('assets/content/photos/'.$file));
			//redirect
			$data['basicmsg'] = '<h4>Do you want to crop the photo?</h4>Your cover photo has been uploaded, do you want to crop your photo to fit the box?
				 <a href="'.$btn_path.'" class="btn btn-inverse pull-right" rel="tooltip" title="Cover Image 750 pixels x 300 pixels" style="margin:5px"><i class="icon-retweet icon-white"></i> Crop Image Now</a>
				 <div class="clearfix" style="height:10px;"></div>
				 ';

			echo '<div class="alert alert-success alert-block">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  '. $data['basicmsg'].'
					   </div>
					   <script type="text/javascript">cover_upload_success("'.$image.'", "'.$btn_path.'");</script>
					   ';
			$this->output->set_header("HTTP/1.0 200 OK");

		}


	}


	function identify_content($type)
	{


		if ($type == 'regions')
		{

			$typeDB = 'a_map_region';

		}
		elseif ($type == 'towns')
		{

			$typeDB = 'a_map_location';

		}
		elseif ($type == 'culture')
		{

			$typeDB = 'culture';

		}
		elseif ($type == 'animals')
		{

			$typeDB = 'animals';

		}
		elseif ($type == 'birds')
		{

			$typeDB = 'birds';

		}
		elseif ($type == 'must_know')
		{

			$typeDB = 'must_know';

		}
		elseif ($type == 'plants')
		{
			$typeDB = 'plants';

		}
		return $typeDB;
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE COVER
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//downsize image
	function downsize_cover($file){

		$config = array(
			'image_library' => 'GD2',
			'source_image' => (BASE_URL .'assets/content/photos/'. $file),
			'master_dim' => 'width',
			'width' => '1000',
			'height' => '500',
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
	//ON DEMAND QR CODE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function qr($type, $id)
	{
		$qr = $this->image_model->qr($type, $id);
		//redirect($qr, 301);

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ON DEMAND QR CODE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function qr_url()
	{
		if($url = $this->input->get('url')){

			if(filter_var($url, FILTER_VALIDATE_URL)){

				$qr = $this->image_model->qr_url($url);

			}else{

				$qr = $this->image_model->qr_url(site_url('/').$url);
			}

		}else{

			//how_404();
		}
		
	}


	//IMAGES ON DEMAND TEST URL
	function test()
	{

		$a = $this->image_model->set(800,400,100, true, $url = 'assets/business/photos/uschi-diane-properties-65909.jpg');

		echo $a;
		$t = file_get_contents(base_url('/').'img_cache/uschi-diane-properties-65909_800x400_q100.jpg');

		//var_dump($t);

		$c = file_get_contents(site_url('/').'my_images/set/200/200/100/?src=assets/business/photos/uschi-diane-properties-65909.jpg');

		//var_dump($c);
		echo $c;
	}
	//IMAGES ON DEMAND
	function set($w, $h, $q = 90)
	{

		echo $this->image_model->set($w, $h, $q);


	}

	public function show_img($path)
	{
		$data = read_file($path);
		//echo $data;
		header("Content-Disposition: filename=".$this->img_name."_".$this->res_prop['width']."x".$this->res_prop['height']."x".$this->res_prop['master_dim'].".".$this->img_ext.";");
		$stuff = get_mime_by_extension($path);
		header("Content-Type: {$stuff}");
		header('Content-Transfer-Encoding: binary');
		header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
		//echo $data;
	}
}
	
	
	
	

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */