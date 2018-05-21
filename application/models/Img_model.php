<?php
class Img_model extends CI_Model
{

	function img_model(){
		//parent::CI_model();
		//LOAD library
		$this->load->library('image_lib');
	}

  public $path          = "";
  private $default      = "/test_images/default.jpg";
  public $img           = "";
  public $cache_folder  = "img_cache";
  public $img_name      = "";
  public $img_ext       = "";
  private $img_prop     = array();
  
  private $res_prop = array(
    "image_library"  => 'GD2',//
    "create_thumb"   => FALSE,
    "maintain_ratio" => TRUE,
    "dynamic_output" => FALSE
  );
  
  public function __construct()
  {
    //parent::Model();
    $this->load->library('image_lib');
    $this->load->helper('file');
	$this->path = BASE_URL;
    //$this->path = $this->config->item('path', 'img')."/";  // Old option if you want to control from config file
  }
  
  public function set_img($img) //dash as slash..  "/images/foo.jpg = images-foo.jpg"
  {
	//echo $img;
	$img = str_replace("_", "/", $img);
    $iprop = explode("/", $img);
    $iname = $iprop[count($iprop) - 1];
    $iname_part = explode(".", $iname);
    $this->img_name = $iname_part[0];
    $this->img_ext  = $iname_part[1];
    $this->img_pre  = str_replace($iname, '', $img);

	//echo $this->path.$img;

	if(file_exists($this->path.$img)) {
      $this->img = $this->path.$img;
    } else {
      $this->img = $this->path.$this->default;
    }

    $this->img_prop = getimagesize($this->img);

	//echo $this->img_prop;
  }
  
  
  /*
    CI IMG PROPS
    $config['image_library'] = 'gd2';
    $config['source_image']	= '/path/to/image/mypic.jpg';
    $config['create_thumb'] = TRUE;
    $config['maintain_ratio'] = TRUE;
    $config['width']	 = 75;
    $config['height']	= 50;
    $config['dynamic_output'] = TRUE;

    $this->load->library('image_lib', $config); 

    $this->image_lib->resize();
  */
  
  public function set_size($width=0, $height=0, $master = "auto")
  {
    $this->res_prop['master_dim'] = $master;
  
    // sEt Wdith
    if($width < $this->img_prop[0] && $width > 0) {
      $this->res_prop['width'] = $width;
    } else {
      $this->res_prop['width'] = $this->img_prop[0]-1;
    }
    
    //Set height
    if($height < $this->img_prop[1] && $height > 0) {
      $this->res_prop['height'] = $height;
    } else {
      $this->res_prop['height'] = $this->img_prop[1]-1;
    }
  }
  
	public function set_square($square = FALSE)
	{
		if($square == "s")
		{
			$this->res_prop['x_axis'] = $this->res_prop['height'];
			$this->res_prop['maintain_ratio'] = TRUE;
		}
	
	}

  public function get_img($raw = TRUE)
  {
    $this->res_prop['source_image'] = $this->img;
    $cache_image = $this->path.$this->img_pre.$this->cache_folder.'/'.$this->img_name.'_'.$this->res_prop['width'].'x'.$this->res_prop['height'].'x'.$this->res_prop['master_dim'].'.'.$this->img_ext;
    if(file_exists($cache_image))
    {
        $this->show_img($cache_image);
    }
    else
    {
      if(!is_dir($this->path.$this->img_pre.$this->cache_folder))
      {
        mkdir($this->path.$this->img_pre.$this->cache_folder, 0777);
      }
      
      $this->res_prop['new_image'] = $cache_image;
      $this->image_lib->initialize($this->res_prop);
      $this->image_lib->resize();
      

      $this->show_img($cache_image);
    }
	  //echo $cache_image;
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