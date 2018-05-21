<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Csv extends CI_Controller {

	/**
	 * CSV CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
 	function __construct() {
        parent::__construct();
        $this->load->model('csv_model');
        $this->load->library('csvimport');
    }
 
    function index() {
      
	  	echo 'Going Nowhere Slowly!';
	  
    }
 
 	//+++++++++++++++++++++++++++
	//IMPORT EXHIBITORS
	//++++++++++++++++++++++++++
	public function import_exhibitors($event_id = 0)
	{
		
		if($this->session->userdata('admin_id')){

				//UPLOAD CSV
				if($file_path = $this->csv_model->upload_csv()){
					
						if ($this->csvimport->get_array($file_path)) {
									
									$csv_array = $this->csvimport->get_array($file_path);
									$x = 0;$y = 0;
									
									foreach ($csv_array as $row) {
										
										//echo $row['exhibitor'] .' '.$y.' </br >';
										//validate empty row
										if($row['exhibitor'] != ''){
											//test if exists
											$exists = $this->db->where('bus_id', $this->session->userdata('bus_id'));
											$exists = $this->db->where('email',trim($row['email']));
											$exists = $this->db->where('exhibitor',trim($row['exhibitor']));
											$exists = $this->db->get('exhibitors'); 
											
											if($exists->result()){
												$curr = $exists->row();
												//echo 'Exists ' . $row['name'] . ' ' . $row['sname'] . '  ===  ' . $curr->name. ' ' .$curr->sname. ' <br />';
												//echo 'Problem record: '. $row['exhibitor'].' ' .$y.'<br />';
												$id = $curr->exhibitor_id;
												
											}else{
												
												if(trim($row['type']) == 0 || trim($row['type']) == ''){
													
													$row['type'] = 'exhibitor';	
													
												}
												$insert_data = array(
													'location_key'=>$row['location_id'],
													'location_size'=>$row['location_size'],
													'exhibitor'=>$row['exhibitor'],
													'exhibitor_name'=>$row['exhibitor_name'],
													'bus_id'=>$this->session->userdata('bus_id'),
													'city'=>$row['city'],
													'type'=>$row['type'],
													'address'=>$row['address'],
													'region'=>$row['region'],
													'contact_person'=>$row['contact_person'],
													'fax'=>$row['fax'],
													'post'=>$row['post'],
													'location'=>$row['location'],
													'email'=>$row['email'],
													'tell'=>$row['tell'],
													'cell'=>$row['cell'],
													
												);
												
												//INSERT NEW
												if($this->db->insert('exhibitors', $insert_data)){
												
												
													//get new sub id
													$id = $this->db->insert_id();	
													
												}else{
													
													echo 'Problem record: '. $row['exhibitor'].' ' .$y.'<br />';
													
												}

												
												$x ++;
											}
											
											//INSERT INTO EVENT 
											if($event_id != 0){
												
													$this->db->where('exhibitor_id', $id);
													$this->db->where('event_id', $event_id);	
													$query = $this->db->get('event_subscribers');
													
													if(!$query->result()){
															
														$data['event_id'] = $event_id;
														$data['exhibitor_id'] = $id;
															
														$this->db->insert('event_subscribers', $data);
														
														
													}else{
														
														
														
													}
																
											}
											
											
											$y ++;
										}

									}//foreach
									//echo 'Total records: '.$y,'  and '.$x .' records added';
									$this->session->set_flashdata('msg', 'Total records: '.$y.'  and '.$x .' records added ');
									
									if($event_id != 0){
										
										$java = 'reload_exhibitors()';
										
									}else{
										
										$java = 'reload_exhibitors()';
										
									}
									
									 echo "<script>
										  $.noty.closeAll()
										  var options = {'text':'Total records: ".$y." and ".$x ." records added of : ". count($csv_array)."','layout':'bottomLeft','type':'success'};
										  noty(options);
										  ".$java."
									  </script>";	
						} else {
							
							echo 'ERROR!';
						}				
			
				}else{
					
					echo 'Couldnt upload file';	
					
				}
			
		}else{
			
			echo 'Please Sign in again';
			
		}
	}	
	
	//+++++++++++++++++++++++++++
	//IMPORT SUBSCRIBERDS
	//++++++++++++++++++++++++++
	public function import_subscribers($event_id)
	{
		
		if($this->session->userdata('admin_id')){

				$bus_id = $this->session->userdata('bus_id');
				//UPLOAD CSV
				if($file_path = $this->csv_model->upload_csv()){
					
						if ($this->csvimport->get_array($file_path)) {
									
									$csv_array = $this->csvimport->get_array($file_path);
									$x = 0;$y = 0;$z = 0;
									foreach ($csv_array as $row) {
										
										//validate email
										//if(isset($row['email']) && $row['email'] != ''){
											//test if exists
											$exists = $this->db->where('bus_id', $bus_id);
											$exists = $this->db->where('email',trim($row['email']));
											$exists = $this->db->get('subscribers'); 
											
											if($exists->result()){
												$curr = $exists->row();
												//echo 'Exists ' . $row['name'] . ' ' . $row['sname'] . '  ===  ' . $curr->name. ' ' .$curr->sname. ' <br />';
												
												$id = $curr->subscriber_id;
												$insertdata2['name'] = $row['name'];
												$insertdata2['sname'] = $row['sname'];
												$insertdata2['bus_id'] = $bus_id;
												$insertdata2['city'] = $row['city'];
												$insertdata2['country'] = $row['country'];
												$insertdata2['fax'] = $row['fax'];
												$insertdata2['website'] = $row['website'];
												$insertdata2['sname'] = $row['sname'];
												$insertdata2['email'] = trim($row['email']);
												$insertdata2['type'] = trim($row['type']);
												$insertdata2['company'] = trim($row['company']);
												$insertdata2['abreviation'] = trim($row['abreviation']);
												
												//TYPE
												if(trim($curr->type) == ''){
													
													if(trim($row['type']) != ''){
														
														$insertdata2['type'] = $row['type'];
														//echo 'Type Updated ';
													}
													
												}
																								
												//PHONE
												if(trim($curr->phone) == ''){
													
													if(trim($row['phone']) != ''){
														
														$insertdata2['phone'] = trim($row['phone']);
														//echo 'Phone Updated ';
													}
													
												}
												//ADDRESS
												if(trim($curr->address) == ''){
													
													if(trim($row['address']) != ''){
														
														$insertdata2['address'] = $row['address'];
														//echo 'Address Updated ';
													}
													
												}
												//COMPANY
												if(trim($curr->company) == ''){
													
													if(trim($row['company']) != ''){
														
														$insertdata2['company'] = trim($row['company']);
														//echo 'Company Updated ';
													}
													
												}
												
												//STATUS
												if( $event_id != 0){

													
													$this->db->where('subscriber_id', $id);
													$this->db->where('event_id', $event_id);	
													$query = $this->db->get('event_subscribers');
													
													if(!$query->result()){
															
														$data2['event_id'] = $event_id;
														$data2['subscriber_id'] = $id;
														$data2['status'] = 'invited';
														$this->db->insert('event_subscribers', $data2);
														//echo 'Event Status Inserted <br />';
														
													}else{
														$erow = $query->row();
														$data2['status'] = $erow->status;
														$this->db->where('subscriber_id', $id);
														$this->db->where('event_id', $event_id);	
														$this->db->update('event_subscribers', $data2);
														//echo $row['status'].' Event Status Updated <br />';
													}
													
												}
												

												//UPDATE SUBSCRIBER
												$this->db->where('subscriber_id', $id);	
												$this->db->update('subscribers', $insertdata2);
												
												
												$z ++;
												
											//INSERT FRESH	
											}else{

												if($row['sname'] == ''){

													$row['sname'] == ' ';
												}

												$insert_data = array(
													'sname'=>$row['sname'],
													'name'=>$row['name'],
													'phone'=>$row['phone'],
													'email'=> trim($row['email']),
													'bus_id'=>  $bus_id,
													'company'=>$row['company'],
													'type'=>$row['type'],
													'city'=>$row['city'],
													'country'=>$row['country'],
													'website'=>$row['website'],
													'fax'=>$row['fax'],
													'region'=>$row['region'],
													'address'=>$row['address'],
													
												);
												
												//INSERT NEW
												$this->db->insert('subscribers', $insert_data);
												//get new sub id
												$id = $this->db->insert_id();
												
												$x ++;
											}
											
											//INSERT INTO EVENT 
											if($event_id != 0){
												
													$this->db->where('subscriber_id', $id);
													$this->db->where('event_id', $event_id);	
													$query = $this->db->get('event_subscribers');
													
													if(!$query->result()){
															
														$data['event_id'] = $event_id;
														$data['subscriber_id'] = $id;
														if(isset($row['status'])){
															$data['status'] = $row['status'];
														}else{

															$data['status'] = 'invited';
														}

														$this->db->insert('event_subscribers', $data);
														
														
													}else{
														
														
														
													}
																
											}
											
											
											$y ++;
										//}//end if email

									}
									//echo 'Total records: '.$y,'  and '.$x .' records added';
									$this->session->set_flashdata('msg', "Total records: ".$y." and ".$x ." records added and ".$z." records Updated!");
									
									if($event_id != 0){
										
										$java = 'reload_invities()';
										
									}else{
										
										$java = 'reload_members()';
										
									}
									
									 echo "<script>
										  $.noty.closeAll()
										  var options = {'text':'Total records: ".$y." and ".$x ." records added and ".$z." records Updated!','layout':'bottomLeft','type':'success'};
										  noty(options);
										  ".$java."
									  </script>";	
						} else {
							
							echo 'ERROR!';
						}				
			
				}
			
		}else{
			
			
		}
	}	
 
 
    function importcsv() {
        $data['addressbook'] = $this->csv_model->get_addressbook();
        $data['error'] = '';    //initialize image upload error array to empty
 
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'csv';
        $config['max_size'] = '1000';
 
        $this->load->library('upload', $config);
 
 
        // If upload failed, display error
        if (!$this->upload->do_upload()) {
            $data['error'] = $this->upload->display_errors();
 
            $this->load->view('csvindex', $data);
        } else {
            $file_data = $this->upload->data();
            $file_path =  './uploads/'.$file_data['file_name'];
 
            if ($this->csvimport->get_array($file_path)) {
                $csv_array = $this->csvimport->get_array($file_path);
                foreach ($csv_array as $row) {
                    $insert_data = array(
                        'firstname'=>$row['firstname'],
                        'lastname'=>$row['lastname'],
                        'phone'=>$row['phone'],
                        'email'=>$row['email'],
                    );
                    $this->csv_model->insert_csv($insert_data);
                }
                $this->session->set_flashdata('success', 'Csv Data Imported Succesfully');
                redirect(base_url().'csv');
                //echo "<pre>"; print_r($insert_data);
            } else 
                $data['error'] = "Error occured";
                $this->load->view('csvindex', $data);
            }
 
        }


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EXPORT BUSINESS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function export_business($type = '')
	{
		$this->load->model('csv_model');
		$this->csv_model->export_business($type);

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EXPORT PRODUCTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function export_products($bus_id, $client_id, $type = '')
	{
		$this->load->model('csv_model');
		$this->csv_model->export_products($bus_id, $client_id, $type);

	}
	
}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */