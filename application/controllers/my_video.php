<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_video extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	 function my_video()
	{
		parent::__construct();
		$this->load->model('owner_model');
		$this->load->helper('ssl_helper');
		//force_ssl();
	}
	public function index()
	{
		 if($this->session->userdata('pro_id')){
			 	
				$data['pro_id'] = $this->session->userdata('pro_id');
				
				$this->load->view('profile_books/upload-video', $data);	
				//echo 'Owner is logged in';
		
		}elseif($this->session->userdata('teach_id')){
		
				$data['teach_id'] = $this->session->userdata('teach_id');
				//$data['info'] = $this->owner_model->get_profile($data['pro_id']);
				//$data['teachers'] = $this->owner_model->get_teachers($data['pro_id']);
				//$this->load->view('owners/owners-home', $data);
				$this->load->view('profile_books/upload-video', $data);	
		
		}elseif($this->session->userdata('parent_id')){
			
				$data['teach_id'] = $this->session->userdata('teach_id');
				//$data['info'] = $this->owner_model->get_profile($data['pro_id']);
				//$data['teachers'] = $this->owner_model->get_teachers($data['pro_id']);
				//$this->load->view('owners/owners-home', $data);
				$this->load->view('profile_books/upload-video', $data);	
				
			  
		 }else{
			 
			 $this->load->view('login');
		 }	 
		
	}
	
public function upload()
	{
		 if($this->session->userdata('pro_id')){
			 	
				$data['pro_id'] = $this->session->userdata('pro_id');
				$data['nav'] = 'inc/nav';
				$this->load->view('profile_books/upload-video', $data);	
				//echo 'Owner is logged in';
		
		}elseif($this->session->userdata('teacher_id')){
		
				$data['teacher_id'] = $this->session->userdata('teacher_id');
				$data['nav'] = 'inc/nav';
				$this->load->view('profile_books/upload-video', $data);	
		
		}elseif($this->session->userdata('parent_id')){
			
				$data['teach_id'] = $this->session->userdata('teach_id');
				//$data['info'] = $this->owner_model->get_profile($data['pro_id']);
				//$data['teachers'] = $this->owner_model->get_teachers($data['pro_id']);
				//$this->load->view('owners/owners-home', $data);
				$data['nav'] = 'inc/nav';
				$this->load->view('profile_books/upload-video', $data);	
				
			  
		 }else{
			 
			 $this->load->view('login');
		 }	 
		
	}
	
	
public function upload_widget()
	{
		 if($this->session->userdata('pro_id')){
			 	
				$data['pro_id'] = $this->session->userdata('pro_id');
				$data['nav'] = 'inc/nav';
				$this->load->view('profile_books/upload-video-widget', $data);	
				//echo 'Owner is logged in';
		
		}elseif($this->session->userdata('teacher_id')){
		
				$data['teacher_id'] = $this->session->userdata('teacher_id');
				$data['nav'] = 'inc/nav';
				echo 'Teacher is logged in';	
		
		}elseif($this->session->userdata('parent_id')){
			
				$data['teach_id'] = $this->session->userdata('teach_id');
				//$data['info'] = $this->owner_model->get_profile($data['pro_id']);
				//$data['teachers'] = $this->owner_model->get_teachers($data['pro_id']);
				//$this->load->view('owners/owners-home', $data);
				echo 'Teacher is logged in';	
				
			  
		 }else{
			 
			 $this->load->view('login');
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
/*function add_video(){
	 
	 $this->load->library('upload');
	 $img = $this->input->post('userfile', TRUE);
	 $child_id = $this->input->post('child_id', TRUE);
	 $story_id = $this->input->post('story_id1', TRUE);
	 $pro_id = $this->input->post('pro_id', TRUE);
	
	   
	   $config['upload_path'] = './assets/' . $pro_id . '/';
	   $config['allowed_types'] = 'mov|avi|mp4|ogg|wmv';
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
						  
						  //$this->load->model('gallery_model');
						  //$str = 'children';	 
						  //$this->gallery_model->downsize_image($file,$pro_id,$str);
								  
				  }
  					
  				  
				  //populate array with values
				  $data = array(
					  'child_id' => $child_id,
					  'story_id' => $story_id,  
					  'video_file'=> $file
				   
				  );
				  //IF NEW LS
				  if($story_id == '0'){
				 
					  //insert into database
					  
					  $this->db->insert('video',$data);
				  }else{
					  
					  $this->db->insert('video',$data);
				  }
				  //load respective view 
				 $data['pro_id'] = $pro_id;
				 
				 //crop 
				  $data['filename'] = $file;
				  $data['width'] = $this->upload->image_width;
				  $data['height'] = $this->upload->image_height;
				  $data['info'] = $this->owner_model->get_child($child_id);
				  $data['parents'] = $this->owner_model->get_parents($pro_id);
				  $image = base_url('/') . 'assets/' . $pro_id.'/'.$file;
				 //redirect 
				  $data['basicmsg'] = 'Video added successfully!';
				  echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  '. $data['basicmsg'].'
					   </div>
					   <script type="text/javascript">
					  
					   show_video('.$story_id.');
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
				 </div><script type="text/javascript">
					console.log("error");
					$("#vid-cover").hide();
				</script>'; 
			
		  }

}*/


public function add_video(){
         
		 ini_set('memory_limit', '1024M');
		 $child_id = $this->input->post('child_id', TRUE);
		 $story_id = $this->input->post('story_id_vid', TRUE);
		 $pro_id = $this->input->post('pro_id', TRUE);
		
		if (isset($_FILES['video']['name']) && $_FILES['video']['name'] != '') {
            unset($config);
            $date = date("ymd");
               $config['upload_path'] = './assets/videos/';
			   $config['allowed_types'] = 'mov|avi|mp4|ogg|wmv|mpeg4';
			   $config['overwrite']     = FALSE;
			   $config['max_size']	= '120000';
			   $config['max_width']  = '8324';
			   $config['max_height']  = '8550';
			   $config['min_width']  = '200';
			   $config['min_height']  = '200';
			   $config['remove_spaces']  = TRUE;
			   $config['encrypt_name']  = TRUE;
			   

            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('video')) {
               //ERROR
				$data['pro_id'] = $pro_id;
				$data['error'] =  $this->upload->display_errors();
				echo 
				'<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>'
				 . $data['error'].'
				 </div><script type="text/javascript">
					console.log("error");
					$("#vid-cover").hide();
				</script>'; 
            } else {
                //$file = array('upload_data'
			  $data = array('upload_data' => $this->upload->data());
			  $file =  $this->upload->file_name;
			  $width = $this->upload->image_width;
			  $height = $this->upload->image_height;	
			  //delete old photo
			  //$this->delete_old_child_photo($child_id,$pro_id);
			  //$this->update_pro_book_image($child_id,$pro_id,$file);
					   
				  if (($width > 850) || ($height > 700)){
						  
						  //$this->load->model('gallery_model');
						  //$str = 'children';	 
						  //$this->gallery_model->downsize_image($file,$pro_id,$str);
								  
				  }
  					
  				  
				  //populate array with values
				  $data = array(
					  'child_id' => $child_id,
					  'story_id' => $story_id,  
					  'video_file'=> $file
				   
				  );
				  //IF NEW LS
				  if($story_id == '0'){
				 
					  //insert into database
					  
					  $this->db->insert('video',$data);
				  }else{
					  
					  $this->db->insert('video',$data);
				  }
				  //load respective view 
				 $data['pro_id'] = $pro_id;
				 
				  //get details
				  $data['filename'] = $file;
				  $data['width'] = $this->upload->image_width;
				  $data['height'] = $this->upload->image_height;
				  $data['ext'] = $this->upload->file_ext;
				  $data['info'] = $this->owner_model->get_child($child_id);
				  $data['parents'] = $this->owner_model->get_parents($pro_id);
				  $image = base_url('/') . 'assets/videos/'.$file;
				  
				  $clean_file = str_replace('.','-',$file);
				  $clean_ext = str_replace('.','-',$data['ext']);
				  //COnvert To FLV
				  //$this->owner_model->convert_to_flv($file,$data['ext']);
				  $this->session->set_flashdata('video',  'show_video_conversion("'.$clean_file.'","'.$clean_ext . '","'.$story_id.'"); $("#sho_vid").hide();');
				 echo '<script type="text/javascript">
					   window.location = "'.site_url('/').'learningstories/edit/'.$story_id.'";
					  
					   </script> ';
			      //redirect(site_url('/').'learningstories/edit/'.$story_id,'refresh');
				  //$this->output->set_header("HTTP/1.0 200 OK");
            }
			
		//NO FILE SELECTED	
        }else{
			echo 
				'<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>Please select a video file
				 </div><script type="text/javascript">
					console.log("error");
					$("#vid-cover").hide();
				</script>'; 
			
		}
}




//SHOW VIDEO on Edit pages			
function show_video($story_id)
	{
			$query = $this->db->select('video_file, video_id');
			$query = $this->db->from('video');
			$query = $this->db->where('story_id',$story_id);
			
			$query = $this->db->get();

        	if($query->num_rows() > 0){
				$x =0;
				
				$row = $query->row_array();
				$vid_file = $row['video_file'];
				
				$format = substr($vid_file,(strlen($vid_file) - 4),4);
				$str = substr($vid_file,0,(strlen($vid_file) - 4));
				
				//poster="'.base_url('/').'assets/videos/'.$str.'.jpg"		
				echo '<video style="width:100%;height:100%" width="100%" height="320px" id="player'.$story_id.'"  controls="controls" preload="none">
						<!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
						<source type="video/mp4" src="'.base_url('/').'assets/videos/'.$str.'.mp4" />
						<!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
						<source type="video/webm" src="'.base_url('/').'assets/videos/'.$str.'.webm" />
						<!-- Ogg/Vorbis for older Firefox and Opera versions -->
						<source type="video/ogg" src="'.base_url('/').'assets/videos/'.$str.'.ogv" />
						<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
						<object width="100%" height="320px" type="application/x-shockwave-flash" data="' . base_url('/').'video/src/flash/flashmediaelement.swf">
							<param name="movie" value="' . base_url('/').'video/src/flash/flashmediaelement.swf" />
							<param name="flashvars" value="controls=true&file='.base_url('/').'assets/videos/'.$str.'.mp4" />
							<!-- Image as a last resort -->
							<img src="'.base_url('/').'assets/videos/'.$str.'.jpg" width="100%" height="100%" title="No video playback capabilities" />
						</object>
					</video>
					<script type="text/javascript">
						$("video").mediaelementplayer();
					</script>';
				
			}else{
			
				return '0';
			}			
			
			
	}

//SHOW VIDEO Modal		
function show_video_modal()
	{
			$id = $this->input->post('vid_id',TRUE);
			$query = $this->db->select('video_file, video_id');
			$query = $this->db->from('video');
			$query = $this->db->where('video_id',$id);
			
			$query = $this->db->get();

        	if($query->num_rows() > 0){
				
				//IE glitch
				$iestr = '';
				if ($this->agent->browser() == 'Internet Explorer'){
					
					$iestr = 'style="width:100%;height:100%"';
				
				}
				
				$row = $query->row_array();
				$vid_file = $row['video_file'];
				
				$format = substr($vid_file,(strlen($vid_file) - 4),4);
				$str = substr($vid_file,0,(strlen($vid_file) - 4));
				//poster="'.base_url('/').'assets/videos/'.$str.'.jpg"
				echo '<div class="modal-body" style="overflow:hidden">
						<video '.$iestr.'  width="100%" height="310px" id="player'.$id.'"  controls="controls" preload="none">
								<!-- MP4 for Safari, IE9, iPhone, iPad, Android, and Windows Phone 7 -->
								<source type="video/mp4" src="'.base_url('/').'assets/videos/'.$str.'.mp4" />
								<!-- WebM/VP8 for Firefox4, Opera, and Chrome -->
								<source type="video/webm" src="'.base_url('/').'assets/videos/'.$str.'.webm" />
								<!-- Ogg/Vorbis for older Firefox and Opera versions -->
								<source type="video/ogg" src="'.base_url('/').'assets/videos/'.$str.'.ogv" />
								<!-- Flash fallback for non-HTML5 browsers without JavaScript -->
								<object width="100%" height="310px" type="application/x-shockwave-flash" data="' . base_url('/').'video/src/flash/flashmediaelement.swf">
									<param name="movie" value="' . base_url('/').'video/src/flash/flashmediaelement.swf" />
									<param name="flashvars" value="controls=true&file='.base_url('/').'assets/videos/'.$str.'.mp4" />
									<!-- Image as a last resort -->
									<img src="'.base_url('/').'assets/videos/'.$str.'.jpg" width="100%" title="No video playback capabilities" />
								</object>
							</video>
						</div>
						<script type="text/javascript">
						
							$("video").mediaelementplayer();
						</script>';						
				
			}else{
			
				return '0';
			}			
			
			
	}
	
	
//echo '<video width="640" height="360" id="player2" poster="'. base_url('/').'video/media/echo-hereweare.jpg" controls="controls" preload="none">
//
//				<source type="video/mp4" src="'. base_url('/').'assets/'.$pro_id.'/'.$vid_file.'" />
//
//				<source type="video/webm" src="'.base_url('/').'video/media/echo-hereweare.webm" />
//
//				<source type="video/ogg" src="'.base_url('/').'video/media/echo-hereweare.ogv" />
//
//				<object width="640" height="360" type="application/x-shockwave-flash" data="'.base_url('/').'video/build/flashmediaelement.swf"> 		
//					<param name="movie" value="'.base_url('/').'video/build/flashmediaelement.swf" /> 
//					<param name="flashvars" value="controls=true&poster='. base_url('/').'video/media/echo-hereweare.jpg&file='. base_url('/').'assets/'.$pro_id.'/'.$vid_file.'" /> 		
//					<img src="'.base_url('/').'video/media/echo-hereweare.jpg" width="640" height="360" alt="Here we are" 
//						title="No video playback capabilities" />
//				</object>';	
	
	
	
function video_delete($vid_id)
	{
		 
			$this->db->where('video_id' , $vid_id);
			$query = $this->db->get('video');
			$row = $query->row_array();
			
			$video_file = $row['video_file'];
			$child_id = $row['child_id'];
			$story_id = $row['story_id'];
			$pro_id = $this->get_child_pro_id($child_id);
			
			if($row['video_file'] != '0'){
				
				$format = substr($vid_file,(strlen($video_file) - 4),4);
				$str = substr($vid_file,0,(strlen($video_file) - 4));
				
				//ORIGINAL
				$file_large =  './assets/videos/' . $row['video_file']; # build the full path		
		
					   if (file_exists($file_large)) {
							unlink($file_large);
						}
				
				//MP$
				$file_mp4 =  './assets/videos/' . $str.'.mp4'; # build the full path		
		
					   if (file_exists($file_mp4)) {
							unlink($file_mp4);
						}
				//OGV
				$file_ogv =  './assets/videos/' . $str.'.ogv'; # build the full path		
		
					   if (file_exists($file_ogv)) {
							unlink($file_ogv);
						}
				//WEBM
				$file_webm =  './assets/videos/' . $str.'.webm'; # build the full path		
		
					   if (file_exists($file_webm)) {
							unlink($file_webm);
						}		
						//delete video
									
						$this->db->where('video_id' , $vid_id);
						$this->db->delete('video');
						//$data['story'] = $this->stories_model->get_story($story_id);
						$data['child_id'] = $child_id;
						
						
						redirect(site_url('/').'learningstories/edit/'.$story_id,'refresh');
				
			//no existing image	
			}else{
				
				return;
			}			
	
	}	


function convert_video($clean_file,$clean_ext,$story_id){
	
		 ini_set('memory_limit', '1024M');
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));

		
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;

		$old_path = getcwd();
		chdir('/var/www/vhosts/my-child.co.nz/ebooks/bash/');
		
	    $output = system("./convertHTML5.sh /var/www/vhosts/my-child.co.nz/ebooks/assets/videos/".$file);
	    echo "<pre>$output</pre>";

		chdir($old_path);
		echo '<script type="text/javascript">show_video("'.$story_id.'");</script>';
		
}

function convert_video_thumb($clean_file,$clean_ext,$story_id){
		
		 ini_set('memory_limit', '1024M');
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));

		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $no_ext .'.jpg';
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;

		$old_path = getcwd();
		chdir('/var/www/vhosts/my-child.co.nz/ebooks/bash/');

	    $output = shell_exec("ffmpeg -i ".$inpath." -ss 00:00:04 -f image2 -vframes 1 ".$outpath);
	    echo "<pre>$output</pre>";

		chdir($old_path);
		echo '<script type="text/javascript">convert_ogv("'.$clean_file.'","'.$clean_ext.'","'.$story_id.'");</script>';
		
}


function convert_video_ogv($clean_file,$clean_ext,$story_id){
	
		 ini_set('memory_limit', '1024M');
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));

		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $no_ext .'.ogv';
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;

		$old_path = getcwd();
		chdir('/var/www/vhosts/my-child.co.nz/ebooks/bash/');
		
	    $output = shell_exec("ffmpeg -i ".$inpath." -acodec libvorbis -ac 2 -ab 96k -ar 44100 -b:v 345k ".$outpath);
	    echo "<pre>$output</pre>";

		chdir($old_path);
		echo '<script type="text/javascript">convert_webm("'.$clean_file.'","'.$clean_ext.'","'.$story_id.'");</script>';
		
}

function convert_video_webm($clean_file,$clean_ext,$story_id){
	
		 ini_set('memory_limit', '1024M');
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));

		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $no_ext .'.webm';
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;

		$old_path = getcwd();
		chdir('/var/www/vhosts/my-child.co.nz/ebooks/bash/');
		
	    $output = shell_exec("ffmpeg -i ".$inpath." -acodec libvorbis -ac 2 -ab 96k -ar 44100 -b:v 345k ".$outpath);
	    echo "<pre>$output</pre>";

		chdir($old_path);
		echo '<script type="text/javascript">convert_mp4("'.$clean_file.'","'.$clean_ext.'","'.$story_id.'");</script>';
		
}

function convert_video_mp4($clean_file,$clean_ext,$story_id){
	
	    ini_set('memory_limit', '1024M');
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));

		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $no_ext .'.mp4';
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;

		$old_path = getcwd();
		chdir('/var/www/vhosts/my-child.co.nz/ebooks/bash/');
		
	   //$output = shell_exec("ffmpeg -i ".$inpath." -acodec libfaac -ab 96k -vcodec libx264 -profile:v baseline -level 3 -refs 2 -b:v 345k -bt 345k -threads 0 ".$outpath);
	   //$output = shell_exec("ffmpeg -i ".$inpath." -acodec libfaac -ab 96k -vcodec libx264 -profile:v baseline ".$outpath);
	    $output = shell_exec("ffmpeg -i ".$inpath." -y -strict experimental -acodec aac -ac 2 -ab 160k -vcodec libx264 -s 640x480 -pix_fmt yuv420p -preset slow -profile:v baseline -level 30 -maxrate 10000000 -bufsize 10000000 -b 1200k -f mp4 -threads 0 ".$outpath ." 2>&1 > /var/www/vhosts/my-child.co.nz/ebooks/assets/".$no_ext.".log &");
		
		//echo "<pre>$output</pre>";

		chdir($old_path);
		echo '<script type="text/javascript">show_video("'.$story_id.'");</script>';
		
}
//http://localhost/websites/my-books/index.php/my_video/convert_video_webm/761c9e3334cf8c662ca66f9a0065e5bf-MOV/-MOV/148/
function convert_video_mp4_test($clean_file,$clean_ext){
	
	    ini_set('memory_limit', '1024M');
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));

		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/' . $no_ext .'.mp4';
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/' . $file;

		$old_path = getcwd();
		chdir('/var/www/vhosts/my-child.co.nz/ebooks/bash/');
		
	   //$output = shell_exec("ffmpeg -i ".$inpath." -acodec libfaac -ab 96k -vcodec libx264 -profile:v baseline -level 3 -refs 2 -b:v 345k -bt 345k -threads 0 ".$outpath);
	   $output = shell_exec("ffmpeg -i ".$inpath." -y -strict experimental -acodec aac -ac 2 -ab 160k -vcodec libx264 -s 640x480 -pix_fmt yuv420p -preset slow -profile:v baseline -level 30 -maxrate 10000000 -bufsize 10000000 -b 1200k -f mp4 -threads 0 ".$outpath ." 2>&1 > /var/www/vhosts/my-child.co.nz/ebooks/assets/".$no_ext.".log &");
	    echo "<pre>$output</pre>";
		echo $output;
		chdir($old_path);
		
		
}
    
function convert_to_flv($clean_file,$clean_ext,$story_id){
	
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));
		//$format = substr($video,(strlen($video) - 4),4);
//		$str = substr($video,0,(strlen($video) - 4));
//		echo $format .' ' .$str;
		
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;
		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $no_ext .'.flv';
		
		/*** convert video to flash ***/
		//exec();
		
		error_reporting(E_ALL);
		$src = $inpath;
		$command = "ffmpeg -i ".$inpath." ".$outpath."";
		echo "<B>",$command,"</B><br/>";
		$command = escapeshellcmd($command);
	
		echo "backtick:<br/><pre>";
		`$command`;
	
		echo "</pre><br/>system:<br/><pre>";
		echo system($command);
	
		echo "</pre><br/>shell_exec:<br/><pre>";
		echo shell_exec($command);
	
		echo "</pre><br/>passthru:<br/><pre>";
		passthru($command);
	
		echo "</pre><br/>exec:<br/><pre>";
		$output = array();
		exec($command,$output,$status);
		foreach($output AS $o)
		{
				echo $o , "<br/>";
		}
		echo "</pre><br/>popen:<br/><pre>";
		$handle = popen($command,'r');
		echo fread($handle,1048576);
		pclose($handle);
		echo "</pre><br/>";

	   //redirect 
		$data['basicmsg'] = 'Video added successfully!';
		//echo $data['width'] . ' ' . $data['height'] .' ' . $data['ext'];
		echo '<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			'. $data['basicmsg'].'
			 </div>
			 <script type="text/javascript">
			
			 show_video("'.$story_id.'");
			 </script>
			 ';
	
}


function convert_to_flv2($clean_file,$clean_ext,$story_id){
	
		$file = str_replace('-','.',$clean_file);
		$ext = str_replace('-','.',$clean_ext);
		$no_ext = substr($file,0,(strlen($file) - 4));
		//$format = substr($video,(strlen($video) - 4),4);
//		$str = substr($video,0,(strlen($video) - 4));
//		echo $format .' ' .$str;
		
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $file;
		$outpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $no_ext .'.flv';
		
		
		
		 /*** convert video to flash ***/
		exec("ffmpeg -i ".$inpath." -ar 22050 -ab 32 -f flv -s 640x320 ".$outpath."");
		
		
		 //$this->output->set_header("HTTP/1.0 200 OK");
				 //redirect 
				  $data['basicmsg'] = 'Video added successfully!';
				  //echo $data['width'] . ' ' . $data['height'] .' ' . $data['ext'];
				  echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  '. $data['basicmsg'].'
					   </div>
					   <script type="text/javascript">
					  
					   show_video("'.$story_id.'");
					   </script>
					   ';
	
}

function convert_to_mp4($video_id){
	
		$this->db->where('video_id', $video_id);
		$query = $this->db->get('video');
        $row = $query->row_array();
		$pro_id = $row['pro_id'];
		$video = $row['video_file'];
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $video;
		$inpath = '/var/www/vhosts/my-child.co.nz/ebooks/assets/videos/' . $video;


}


function get_child_pro_id($child_id){
	

        $this->db->select('pro_id');
		$this->db->from('children');
		$this->db->where('child_id', $child_id);
		$query = $this->db->get();
        $row = $query->row_array();
		$pro_id = $row['pro_id'];
		
		return $pro_id;
		
	
}


	
		
function connect_main_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'root';
		$config_db['password'] = 'my-child123';
		$config_db['database'] = 'child';
		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}	
function encrypt($a){
	echo $this->encode($a);
	
}
function decrypt($a){
echo $this->decode($a);	
	
}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */