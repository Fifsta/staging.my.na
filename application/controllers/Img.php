<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Img extends CI_Controller
{
  public function __construct()
  {
	parent::__construct();
    //$this->load->model("img_model", "img");
	//ini_set("memory_limit", "64M"); // adjust to your own needs
  }
  public function index()
  {
    redirect('/');
  }
  public function size()
  { 
		//echo "here";
		$props = $this->uri->ruri_to_assoc();
		//print_r($props);
		$this->img->set_img($props['o']);
		$this->img->set_size($props['w'], $props['h'], $props['m']);
		$this->img->set_square($props['m']);
		$this->img->get_img();
  }
  //+++++++++++++++++++++++++++++
  //ON DEMAND QR CODES
  //+++++++++++++++++++++++++++++
  public function qrcode($type = 'voucher', $id = 0, $encrypt = false)
  { 
  		
		//CHECK IF EXISTING FILE EXISTS
		$this->load->library('encrypt');
		$file = $type.'_'.$id ;
		$voucher = $file;
		if($encrypt){
			$voucher = $this->encrypt->encode($data->voucher_id);
		}
		

		$out = site_url('/').'voucher/'.$voucher.'/';

		$config['black']        = array(0,113,132); // array, default is array(255,255,255)
		$config['white']        = array(70,130,180); // array, default is array(0,0,0)
		$this->load->library('ciqrcode', $config);
		//$this->ciqrcode->initialize($config);
		//$params['black'] = array(0,113,132);
		//$params['white'] = array(0,222,132);
		$params['data'] = $voucher;
		$params['level'] = 'L';
		$params['size'] = 1024;
		header("Content-Type: image/png");
		//$params['savename'] = BASE_URL .'assets/qr/' .$file. '_url.jpg';
		$this->ciqrcode->generate($params);
		
  }
  
}