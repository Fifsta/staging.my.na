<?php
 
class Csv_model extends CI_Model {
 		
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
    function __construct() {
        //parent::__construct();
		self::__construct();
    }

	//+++++++++++++++++++++++++++
	//UPLOAD CSV FILE
	//++++++++++++++++++++++++++

    function upload_csv() {     
			
			$file = $this->input->post('userfile', TRUE);
			
			//upload file
			$config['upload_path'] = BASE_URL .'assets/documents/csv/';
			$config['allowed_types'] = 'text/plain|text|csv|csv';
			$config['max_size']	= '8024';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload()){

					$data['error'] =  $this->upload->display_errors();

					 echo "<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				  	noty(options);
					
					</script>";	
					
					return FALSE;  
					
			}else{	
				
				
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
				return $config['upload_path'].$file;
			
			}

    }
 
    function insert_csv($data) {
        $this->db->insert('addressbook', $data);
    }

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EXPORT BUSINESS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function export_business($type = '')
	{

		if($type == 'HAN'){

			//GET EVENT INVITIEES
			$q = $this->db->query("SELECT ID as bus_id , BUSINESS_LOGO_IMAGE_NAME as logo, BUSINESS_COVER_PHOTO as cover, BUSINESS_NAME as name,
									BUSINESS_EMAIL as email, BUSINESS_TELEPHONE as telephone, BUSINESS_FAX as fax, BUSINESS_CELLPHONE as cellphone,
			                        BUSINESS_POSTAL_BOX as postal, BUSINESS_URL as website, BUSINESS_PHYSICAL_ADDRESS as address FROM
			                        u_business WHERE IS_HAN_MEMBER = 'Y'", FALSE);

		}else{

			//GET EVENT EXHIBITORS
			$q = $this->db->query("SELECT ID as bus_id , BUSINESS_LOGO_IMAGE_NAME as logo, BUSINESS_COVER_PHOTO as cover, BUSINESS_NAME as name,
								   BUSINESS_EMAIL as email, BUSINESS_TELEPHONE as telephone, BUSINESS_FAX as fax, BUSINESS_CELLPHONE as cellphone,
			                       BUSINESS_POSTAL_BOX as postal, BUSINESS_URL as website, BUSINESS_PHYSICAL_ADDRESS as address FROM
			                       u_business", FALSE);


		}


		$this->load->helper('csv');
		//var_dump($array);
		echo query_to_csv($q, TRUE, 'business_'.$type.'.csv');



	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EXPORT PRODUCTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function export_products($bus_id,$client_id, $type)
	{

		if($bus_id != '0'){

			//GET EVENT INVITIEES
			$q = $this->db->query("SELECT products.product_id , products.title, products.description, products.listing_type, products.sale_price, products.listing_date,
									location as area, product_categories.category_name as category, product_categories.sub_cat_id as category2 FROM products
									JOIN product_categories ON products.main_cat_id = product_categories.cat_id
			                        WHERE products.bus_id = '".$bus_id."'", FALSE);

		}elseif($this->session->userdata('id')){

			//GET EVENT INVITIEES
			$q = $this->db->query("SELECT products.product_id , products.title, products.description, products.listing_type, products.sale_price, products.listing_date,
									location as area, product_categories.category_name as category, product_categories.sub_cat_id as category2 FROM products
									JOIN product_categories ON products.main_cat_id = product_categories.cat_id
			                        WHERE products.client_id = '".$this->session->userdata('id')."'", FALSE);


		}elseif($this->session->userdata('admin_id')){

			//GET EVENT INVITIEES
			$q = $this->db->query("SELECT products.product_id , products.title, products.description, products.listing_type, products.sale_price, products.listing_date,
									location as area, product_categories.category_name as category, product_categories.sub_cat_id as category2 FROM products
									JOIN product_categories ON products.main_cat_id = product_categories.cat_id
			                        ", FALSE);


		}


		$this->load->helper('csv');
		//var_dump($array);
		echo query_to_csv($q, TRUE, 'products_'.$type.'.csv');



	}

}
