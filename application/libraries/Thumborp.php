<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Thumbor class
 *
 * Library to utilize thumbor image processor
 *
 * @author  	Roland Ihms
 * @license		
 */
require(BASE_URL.'application/libraries/Thumbor/Url.php');
require(BASE_URL.'application/libraries/Thumbor/Url/Builder.php');
require(BASE_URL.'application/libraries/Thumbor/Url/BuilderFactory.php');
require(BASE_URL.'application/libraries/Thumbor/Url/CommandSet.php');
class Thumborp {

	 public function create_factory($param = array())
    {
		$server = 'https://img.my.na';
		$secret = 'hwn80200ymF57s2YQU7bd3Y61xnF';
		$thumbnailUrlFactory = Thumbor\Url\BuilderFactory::construct($server, $secret);
		
		return $thumbnailUrlFactory;
		
	}
    /**
     * See stringify()
     */
     public function get_image_url($thumbnailUrlFactory,$param = array())
    {
		error_reporting(E_ALL);
		
		if(!isset($param['height']) || !isset($param['width'])){
			
			
			echo 'no height or width';
			
		}
		//var_dump($param);
		if(isset($param['file'])){
			
			$server = 'https://img.my.na';
			$secret = 'hwn80200ymF57s2YQU7bd3Y61xnF';
			
			if(isset($param['filter']) && isset($param['crop'])){
				
				$url = $thumbnailUrlFactory
					->url($param['file'])
					->crop($param['crop'])
					->addFilter($param['filter']);
					
			}elseif(isset($param['filter'])){
			
				$url = $thumbnailUrlFactory
					->url($param['file'])
					->fitIn($param['width'], $param['height'])
					->addFilter($param['filter'] );
					
			}elseif(isset($param['crop'])){
				
				$url = $thumbnailUrlFactory
					->url($param['file'])
					->crop($param['crop']);
				
			}else{
				
				$url = $thumbnailUrlFactory
					->url($param['file'])
					->resize($param['width'], $param['height']);
				
			}
			
			
				
			return $url;	

			
		}else{
			
			return false;
		}
       

    }


}

/* End of file thumbor.php */
