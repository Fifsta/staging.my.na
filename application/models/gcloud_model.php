<?php
 
class Gcloud_model extends CI_Model {
 		
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	

	//+++++++++++++++++++++++++++
	//UPLOAD FILE
	//++++++++++++++++++++++++++

	public function upload_gc_bucket($file, $path)
	{


		//UPLOAD S3
		if(file_exists( $file)){
			$this->load->model('cron_model');
			$path2 = str_replace(BASE_URL,'',$file);
			$out['out'] = $this->cron_model->upload_s3($path2);
		}else{

			$out['out'] = 'Not Uploaded';

		}

		//$out = system('gsutil cp '.$file.' gs://my-na-bucket-eu'.$path);
		return $out;

	}

}
