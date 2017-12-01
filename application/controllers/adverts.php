<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Adverts extends CI_Controller {

	/**
	 * Adverts Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function Adverts()
	{
		parent::__construct();
		$this->load->model('advert_model');
	}
	
	
	//+++++++++++++++++++++++++++
	//GET ALL ADVERTS
	//++++++++++++++++++++++++++
	public function get_adverts()
	{
		
		$this->advert_model->get_adverts(); 
	}
	//+++++++++++++++++++++++++++
	//ADD ADVERT
	//++++++++++++++++++++++++++
	public function add_advert()
	{
		
		$this->advert_model->add_advert(); 
	}
  	//+++++++++++++++++++++++++++
	//UPDATE ADVERT
	//++++++++++++++++++++++++++
	public function update_advert($advert_id)
	{

		$this->load->model('advert_model');
		$this->db->where('ID', $advert_id);
		$query = $this->db->get('adverts');
		if($query->result()){
			$row = $query->row_array();
			
			$data['bus_id'] = $row['BUSINESS_ID'];
			$data['title'] = $row['ADVERTS_HEADER'];
			$data['start'] = $row['ADVERTS_STARTING_DATE'];
			$data['end'] = $row['ADVERTS_EXPIRE_DATE'];
			$data['body'] = $row['ADVERTS_CONTENT'];
			$data['link'] = $row['URL'];
			$data['img_file'] = $row['ADVERTS_IMAGE_NAME'];
			$data['advert_id'] = $advert_id;
			$data['cat_advert'] = $row['CATEGORY_SUB_ID'];
			$data['is_active'] = $row['IS_ACTIVE'];
			$data['advert_loc'] = $row['LOCATION'];
			$data['advert_type'] = $row['TYPE'];
			$data['main_cat_id'] = $row['MAIN_CAT_ID'];
			$data['sub_cat_id'] = $row['SUB_CAT_ID'];
			$data['sub_sub_cat_id'] = $row['SUB_SUB_CAT_ID'];
			
			$this->load->view('admin/inc/adverts_inc', $data);
			echo '<script type="text/javascript">
					$(document).ready(function(){
						
						initialise();
					});
					
					
				  </script>';	
			
		}else{
			
			echo '<div class="alert">
					<h3>Advert not found</h3> The advert could not be found</div>';
			
		}
	 	

		
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD ADVERT IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function add_advert_img()
	{
		   
		 $this->advert_model->add_advert_img(); 
		  
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW ADVERT IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_advert_img($id)
	{
		
		echo $this->advert_model->show_advert_img($id);
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE ADVERT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function delete_advert(){
		
		$this->advert_model->delete_advert();
		
	}
		
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//MAKE ADVERT LIVE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	


	function set_status($id){
		
		$this->db->where('ID', $id);
		$query = $this->db->get('adverts');
		
		if($query->result()){
			
			$row = $query->row_array();
			if($row['IS_ACTIVE'] == 'Y'){
				
				$data['IS_ACTIVE'] = 'N';
				$this->db->where('ID', $id);
				$this->db->update('adverts', $data);
				
			}else{
				
				$data['IS_ACTIVE'] = 'Y';
				$this->db->where('ID', $id);
				$this->db->update('adverts', $data);
				
			}
			
		}
		
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//LOAD SUB CATEGORIES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function get_product_categories_sub($main_cat_id, $curr_id = ''){
		
		$this->advert_model->get_product_categories_sub($main_cat_id, $curr_id);
				
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//METRICS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function track($ad_id, $rand)
	{
		   
		 $this->advert_model->track($ad_id, $rand); 
		  
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//BUY AND SELL ADVERT 1
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function buy_sell($rand = '')
	{

		$this->load->view('adverts/ad1');

	}
	
		
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */