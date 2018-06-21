<?php
class Image_model extends CI_Model{
	
 	public function __construct() {
  		//parent::CI_model();
		//LOAD library
		$this->load->library('image_lib');	
 	}
	
	

	//+++++++++++++++++++++++++++
	//GET IMG URL
	//++++++++++++++++++++++++++
	function get_image_url()
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
		$thumbnailUrlFactory = $this->thumborp->create_factory();
		$url =  $this->thumborp->get_image_url($thumbnailUrlFactory,$param);
		
		echo '<img src="'.$url.'" /><br />';
		echo $url;


	}

	//+++++++++++++++++++++++++++
	//GET IMG URL BY PARAMETERS
	//++++++++++++++++++++++++++
	function get_image_url_param($thumbnailUrlFactory, $file,$width,$height, $filter = '', $crop = '')
	{
		
		if($file == ''){
			echo 'error';
		}
		$param['file'] = $file;
		if(!$param['width'] = $width){
			
			$param['width'] = '0';
		}
		if(!$param['height'] = $height){
			
			$param['height'] = '0';
		}
		
		if(!$param['crop'] = $crop){
			unset($param['crop']);
		}
		if(!$param['filter'] = $filter){
			unset($param['filter']);
		}
		
		$url =  $this->thumborp->get_image_url($thumbnailUrlFactory,$param);
		return $url;


	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE THE DRAG N DROP IMAGE UPLOAD
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file){

		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => $file,
		   'master_dim' => 'auto',
		   'width' => '800',
		  'height' => '1600',
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
	//CROP IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function crop_cover_photo(){
			
			$x = $this->input->post('x');
			$y = $this->input->post('y');
			$filename = $this->input->post('path');
			$path = $this->input->post('absolute_path');
			$folder = $this->input->post('folder');
			$targ_w = $this->input->post('targ_w');
			$targ_h = $this->input->post('targ_h');
			$o_wid = $this->input->post('o_wid');
			$o_hei = $this->input->post('o_hei');
			
			$x2 = $this->input->post('x2');
			$y2 = $this->input->post('y2');
			$w = $this->input->post('w');
			$h = $this->input->post('h');
				
				//THE MAGIC

				$configc['image_library'] = 'GD2';
				$configc['source_image'] = $path ;
				$config['new_image'] = $path;
				$configc['create_thumb'] = FALSE;
				$configc['maintain_ratio'] = FALSE;
				$configc['x_axis'] = $x;
				$configc['y_axis'] = $y;
				$configc['width'] = $w;
				$configc['height'] = $h;
	
				$this->image_lib->initialize($configc); 
				$this->image_lib->crop();
				
				$this->image_lib->clear();
				//Downsize
				$this->downsize_cover($path);

			//r$edirect
			return;
		
		}
		
		
		
			//downsize image
	function downsize_cover($file){

		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => $file,
		   'master_dim' => 'x',
		   'width' => '750',
		  'height' => '300',
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
	//CONVERT IMAGE TO JPEG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function convert_jpeg($inputJ, $outputJ){
								
			$input_file = $inputJ;
			$output_file = $outputJ;
			
			$input = imagecreatefrompng($input_file);
			list($width, $height) = getimagesize($input_file);
			$output = imagecreatetruecolor($width, $height);
			$white = imagecolorallocate($output,  255, 255, 255);
			imagefilledrectangle($output, 0, 0, $width, $height, $white);
			imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
			imagejpeg($output, $output_file);
			//imagedestroy(base_url('/').'assets/products/images/'.$file);

			if(file_exists($inputJ)){
				
				unlink( $inputJ);
				
			}
			return TRUE;
			 
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ON DEMAND IMAGES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function set($w, $h, $q, $out = FALSE, $url = '')
	{

		$no_image = 'img/product_blank.jpg';
		$no_imagep = 'img/product_blank.jpg';

		if($this->input->get('src') || $url != ''){

			$file = $this->input->get('src');
			$out = FALSE;
			//return only image path
			if($url != '')
			{
				$file = $url;
				$out = TRUE;

			}
			if( $this->input->get('url')){
				$out = TRUE;
				$file = $this->input->get('url');
			}

			//$file = base_url('/').$file;
			$path = BASE_URL.$file;
			$url = base_url('/').$file;

			$arr = explode('/',$file);

			$filename = $arr[count($arr) -1];

			$ext = substr($filename, strpos($filename, '.'), strlen($filename));

			$clean = substr($filename, 0, strpos($filename,'.'));

			$final = base_url('/').'img_cache/'.$clean. '_'.$w.'x'.$h.'_q'.$q.$ext;

			//echo $final;
			//var_dump($arr);

			//echo $path .'<br />'.$ext.'</br>'.$clean.'</br>';
			//echo 'poes';
			if(file_exists(BASE_URL.'img_cache/'.$clean. '_'.$w.'x'.$h.'_q'.$q.$ext)){

				$p = 'img_cache/'.$clean. '_'.$w.'x'.$h.'_q'.$q.$ext;
				$p2 = 'img_cache/'.$clean. '_'.$w.'x'.$h.'_q'.$q.$ext;
				if($out){

					return BASE_URL. $p2;
				}else{


					$this->show_img($p, $out);
				}


				//echo $stuff;

			}else{

				$this->load->library('image_lib');

				list($image['width'], $image['height'], $image['type'], $image['attr']) = getimagesize($path);
				//echo $path .'<br />'.$ext.'</br>'.$clean.'</br>';

				//var_dump($image);
				$config['image_library'] = 'GD2';
				$config['source_image']	= $path;

				//$config['create_thumb'] = FALSE;
				$config['quality'] = $q;
				$config['width'] = $w;
				$config['height'] = $h;
				$config['maintain_ratio'] = TRUE;
				//$config['thumb_marker'] = '_'.$w.'x'.$h;
				$config['new_image'] = BASE_URL.'img_cache/'.$clean. '_'.$w.'x'.$h.'_q'.$q.$ext;


				//WORK out ,master Dimensions
				$dim = (intval($image['width']) / intval($image['height'])) - ($config['width'] / $config['height']);
				$config['master_dim'] = ($dim > 0)? "height" : "width";


				//$config['dynamic_output'] = TRUE;


				$this->image_lib->initialize($config);

				if ( ! $this->image_lib->resize())
				{
					//echo $this->image_lib->display_errors();
					$this->show_img($no_imagep, $out);

				}else{

					//echo '<img src="'.$final.'"/>';
					//redirect($final, 301);

				}

				$this->image_lib->clear();

				//CROP TO RESIZE
				$image_config['image_library'] = 'gd2';
				$image_config['source_image'] = $config['new_image'];
				//$image_config['new_image'] = $upload_data["file_path"] . 'product.png';
				$image_config['quality'] = $q;
				$image_config['maintain_ratio'] = FALSE;
				$image_config['width'] = $w;
				$image_config['height'] = $h;
				$image_config['x_axis'] = '0';
				$image_config['y_axis'] = '0';
				//$image_config['dynamic_output'] = TRUE;

				$this->image_lib->initialize($image_config);

				if (!$this->image_lib->crop()){

					//echo $this->image_lib->display_errors();
					//redirect($no_image,301);
					$this->show_img($no_imagep, $out);
				}else{

					$this->show_img('img_cache/'.$clean. '_'.$w.'x'.$h.'_q'.$q.$ext, $out);
					//echo '<img src="'.$final.'"/>';
					//redirect($final, 301);
				}
				$this->image_lib->clear();

			}//if file doesnt exist

		//if src present
		}else{

			$this->show_img($no_imagep, $out);

		}


	}
		

	function show_img($p, $out){

		if($out){

			echo BASE_URL. $p;
			return BASE_URL.$p;
		}else{
			$p = BASE_URL.$p;
			//echo $p;
			$type = get_mime_by_extension($p);
			header('Content-Type:'.$type);
			header('Content-Length: ' . filesize($p));
			readfile($p);
			//echo $p;
		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ON DEMAND QR CODE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function qr($type, $id)
	{


		$path = 'assets/content/qr/'.$id.'_'. $type .'_rating.jpg';
		//CHECK IF EXISTING FILE EXISTS

			$this->load->library('ciqrcode');
			$this->load->model('image_model');

			if ($type == 'business')
			{

				$this->db->from('u_business');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();
				$name = $row['BUSINESS_NAME'];
                $_id = $row['ID'];
			}
			elseif ($type == 'product')
			{

				$this->db->from('products');
				$this->db->where('product_id', $id);
				$query = $this->db->get();
				$row = $query->row_array();
				$name = $row['title'];
                $_id = $row['product_id'];

			}
			elseif ($type == 'deal')
			{

				$this->db->from('u_special_component');
				$this->db->where('ID', $id);
				$query = $this->db->get();
				$row = $query->row_array();
				$name = $row['SPECIALS_HEADER'];
                $_id = $row['ID'];

			}


			if (count($row) > 0)
			{

				$name = $this->my_na_model->clean_url_str($name);

				//save QR file

				$vcard1 = site_url('/') . 'rate/rating/' . $type . '/' . $_id. '/' . $name . '/';


				$params['data'] = $vcard1;
				$params['level'] = 'H';
				$params['size'] = 10;
				//$params['savename'] = BASE_URL . $path;
				header("Content-Type: image/png");
				$this->ciqrcode->generate($params);
				//SEND TO BUCKET
				/*$this->load->model('gcloud_model');
				$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , 'assets/content/qr/');
				$vcard2 = S3_URL . $path;*/


			}
	

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ON DEMAND QR CODE 2
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function qr_url($url = '')
	{
		$this->load->library('ciqrcode');
		
		$params['data'] = $url;
		$params['level'] = 'H';
		$params['size'] = 10;
		//$params['savename'] = BASE_URL . $path;
		header("Content-Type: image/png");

		$this->ciqrcode->generate($params);

	}


}
?>