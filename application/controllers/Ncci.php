<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ncci extends CI_Controller {

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
	public function index()
	{
		
	}
	

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SYNC NTB
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function sync_ntb($offset = 0, $limit = 100)
	{
		ini_set('memory_limit','128M');
		//$this->db->limit($limit);
		//$this->db->offset($offset);
		$this->db->where('SYNCED', 'N');
		$ncci = $this->db->get('u_business_ntb');
		$match_id = 0;
		$count = 0;$duplicate = 0;$inserts = 0;
		foreach($ncci->result() as $nccirow){
			
			//$match = $this->db->query('SELECT BUSINESS_NAME FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->name.'"', FALSE);
			//LIKE
			//$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME LIKE "%'.str_replace(" ", "%",str_replace("'"," ", str_replace('"', ' ', $nccirow->BUSINESS_NAME))).'" AND ID != '.$match_id.' ORDER BY ID LIMIT 5', FALSE);
			
			//EXACT
			$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME = "'.str_replace("'"," ", str_replace('"', ' ', $nccirow->BUSINESS_NAME)).'" AND ID != '.$match_id.' ORDER BY ID LIMIT 5', FALSE);
			
			//Duplicate - MERGE
			if($match->result()){
				
				foreach($match->result() as $match_row){
					
					echo 'NTB: ' . $nccirow->BUSINESS_NAME.' == My.na : '.$match_row->BUSINESS_NAME.'<br />++++++++++++++++++++++++++++++<br />'; 
					
					//Update existing My na Table
					if($nccirow->BUSINESS_EMAIL != ''){
						
						$update_my['BUSINESS_EMAIL'] = 	$nccirow->BUSINESS_EMAIL;
					}
					if($nccirow->BUSINESS_TELEPHONE != ''){
						
						$update_my['BUSINESS_TELEPHONE'] =  $nccirow->BUSINESS_TELEPHONE;
					}

				
					if($nccirow->BUSINESS_POSTAL_BOX != ''){
						
						$update_my['BUSINESS_POSTAL_BOX'] =  	$nccirow->BUSINESS_POSTAL_BOX . ' ' .$nccirow->BUSINESS_TOWN;
					}			

					
					if($nccirow->BUSINESS_PHYSICAL_ADDRESS != ''){
						
						$update_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->BUSINESS_PHYSICAL_ADDRESS;
					}	
					
					//MERGE BUSINESS
					$update_my['IS_NTB_MEMBER'] = 'Y';
					$update_my['NTB_REG'] = trim($nccirow->NTB_REG);
					
					$this->db->where('ID', $match_row->ID);
					$this->db->update('u_business', $update_my);
					
					
					//ADD BUS_ID to NCCI table
					
					$update_data['BUS_ID'] = $match_row->ID;
					$update_data['SYNCED'] = 'Y';
					$this->db->where('NTB_ID', $nccirow->NTB_ID);
					$this->db->update('u_business_ntb', $update_data);
					
					$duplicate ++;
				}
				
				$match_id = $match_row->ID; 
				
			//Insert as NEW	
			}else{
				
					
					//$match2 = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME LIKE "%'.str_replace(" ", "%",str_replace("'"," ", str_replace('"', ' ', $nccirow->BUSINESS_NAME))).'" AND ID != '.$match_id.' ORDER BY ID', FALSE);
//					
//					if($match2->result()){
//						
//						foreach($match2->result() as $match_row2){
//							
//							echo 'NTB Like result : ' . $nccirow->BUSINESS_NAME.' == My.na : '.$match_row2->BUSINESS_NAME.'<br />++++++++++++++++++++++++++++++<br />'; 
//							
//							$duplicate ++;
//							
//						}
//						
//					}else{
						
							$insert_my['IS_NTB_MEMBER'] = 'Y';
							$insert_my['ISACTIVE'] = 'Y';
							$insert_my['BUSINESS_NAME'] = $nccirow->BUSINESS_NAME;
							$insert_my['NTB_REG'] = trim($nccirow->NTB_REG);
		
							
							if($nccirow->BUSINESS_EMAIL != ''){
								$insert_my['BUSINESS_EMAIL'] = $nccirow->BUSINESS_EMAIL;
							}
							if($nccirow->BUSINESS_TELEPHONE != ''){
								
								$insert_my['BUSINESS_TELEPHONE'] =  $nccirow->BUSINESS_TELEPHONE;
							}
							
							
							if($nccirow->BUSINESS_POSTAL_BOX != ''){
								
								$insert_my['BUSINESS_POSTAL_BOX'] =  	$nccirow->BUSINESS_POSTAL_BOX . ' ' .$nccirow->BUSINESS_TOWN;
							}			
							
							
							if($nccirow->BUSINESS_PHYSICAL_ADDRESS != ''){
								
								$insert_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->BUSINESS_PHYSICAL_ADDRESS;
							}
							
							$insert_my['BUSINESS_DESCRIPTION'] = $nccirow->BUSINESS_NAME . ' located at '.$nccirow->BUSINESS_PHYSICAL_ADDRESS; 
							
							$this->db->insert('u_business', $insert_my);
							
							//Update NCCI TABLE WITH BUS ID
							$data_update['BUS_ID'] = $this->db->insert_id();
							$this->db->where('NTB_ID', $nccirow->NTB_ID);
							$this->db->update('u_business_ntb', $data_update);
							
						    $match_id = $data_update['BUS_ID'];
						    $inserts ++;

						
					//}
					
			}
			
			$count ++;
			
		}
		
		echo 'Total Rows: '. $count.'  Duplicates: ' .$duplicate.'<br />
			  Totals Records Imported :	'.$inserts.'<br />';
		
		echo '<a href="'.site_url('/').'ncci/sync_ntb/'.($offset + $limit).'/'.$limit.'/">Next</a>';
	}	




	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN NTB TABLE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function clean_ntb($offset = 0, $limit = 100)
	{
		ini_set('memory_limit','128M');
		//$this->db->limit($limit);
		//$this->db->offset($offset);
		//$this->db->where('SYNCED', 'N');
		$ncci = $this->db->get('u_business_ntb');
		$match_id = 0;
		$count = 0;$duplicate = 0;$inserts = 0;
		foreach($ncci->result() as $nccirow){
			
			if($nccirow->BUSINESS_EMAIL != ''){

					$this->db->where('BUSINESS_NAME', $nccirow->BUSINESS_NAME);
					$this->db->where('NTB_ID !=', $nccirow->NTB_ID);
					$q = $this->db->get('u_business_ntb');
					
					if($q->result()){
						
						foreach($q->result() as $row2){
							
							echo 'Original: '.$nccirow->NTB_ID. '  ' . $nccirow->BUSINESS_NAME. '  ===  Duplicate: ' . $row2->NTB_ID. '  ' . $row2->BUSINESS_NAME. ' <br />'; 	
							
							//DLETE DUPLICATE
							$this->db->where('NTB_ID', $row2->NTB_ID);
							$this->db->delete('u_business_ntb');
							
							$count ++;
							
						}
							
						
					}

			}
			

			
			
			
		}
		
		echo 'Total Rows: '. $count.'  Duplicates: ' .$duplicate.'<br />
			  Totals Records Imported :	'.$inserts.'<br />';
		
		echo '<a href="'.site_url('/').'ncci/sync_ntb/'.($offset + $limit).'/'.$limit.'/">Next</a>';
	}	


	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SYNC TEAM NAMIBIA
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function sync_ncci($offset = 0, $limit = 100)
	{
		//$this->db->limit($limit);
		//$this->db->offset($offset);
		$ncci = $this->db->get('u_business_ncci');
		$match_id = 0;
		$count = 0;$duplicate = 0;
		foreach($ncci->result() as $nccirow){
			
			//$match = $this->db->query('SELECT BUSINESS_NAME FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->name.'"', FALSE);
			$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->name.'" AND ID != '.$nccirow->ncci_id .' AND ID != '.$match_id.' ORDER BY ID', FALSE);
			
			//Duplicate - MERGE
			if($match->result()){
				
				foreach($match->result() as $match_row){
					
					echo 'NCCI: ' . $nccirow->name.' == My.na : '.$match_row->BUSINESS_NAME.'<br />++++++++++++++++++++++++++++++<br />'; 
					
					//ADD BUS_ID to NCCI table
					
					$update_data['bus_id'] = $match_row->ID;
					//$update_data['bus_id'] = $match_row->ID;
					
					$this->db->where('ncci_id', $nccirow->ncci_id);
					$this->db->update('u_business_ncci', $update_data);
					
					
					//Update existing My na Table
					if($nccirow->email_to != ''){
						
						$update_my['BUSINESS_EMAIL'] = 	$nccirow->email_to;
					}
					if($nccirow->telephone != ''){
						
						$update_my['BUSINESS_TELEPHONE'] =  '+264 '.	$nccirow->telephone;
					}
					if($nccirow->mobile != ''){
						
						$update_my['BUSINESS_CELLPHONE'] =  '+264 '.	$nccirow->mobile;
					}	
					if($nccirow->fax != ''){
						
						$update_my['BUSINESS_FAX'] =  '+264 '.	$nccirow->fax;
					}
					
					if($nccirow->p_o_box != ''){
						
						$update_my['BUSINESS_POSTAL_BOX'] =  'PO BOX '.	$nccirow->p_o_box . ' ' .$nccirow->town;
					}			
					
					if($nccirow->webpage != ''){
						
						$update_my['BUSINESS_URL'] =  $nccirow->webpage;
					}	
					
					if($nccirow->physical_address != ''){
						
						$update_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->physical_address . ' ' .$nccirow->town . ' '. $nccirow->country;
					}	
					
					
					$update_my['IS_NCCI_MEMBER'] = 'Y';
					
					$this->db->where('ID', $match_row->ID);
					$this->db->update('u_business', $update_my);
					
					$duplicate ++;
				}
			
			//Insert as NEW	
			}else{
				
				
					$insert_my['IS_NCCI_MEMBER'] = 'Y';
					$insert_my['ISACTIVE'] = 'Y';
					$insert_my['BUSINESS_NAME'] = $nccirow->name;
					
					if($nccirow->email_to != ''){
						$insert_my['BUSINESS_EMAIL'] = $nccirow->email_to;
					}
					if($nccirow->telephone != ''){
						
						$insert_my['BUSINESS_TELEPHONE'] =  '+264 '.	$nccirow->telephone;
					}
					if($nccirow->mobile != ''){
						
						$insert_my['BUSINESS_CELLPHONE'] =  '+264 '.	$nccirow->mobile;
					}	
					if($nccirow->fax != ''){
						
						$insert_my['BUSINESS_FAX'] =  '+264 '.	$nccirow->fax;
					}
					
					if($nccirow->p_o_box != ''){
						
						$insert_my['BUSINESS_POSTAL_BOX'] =  'PO BOX '.	$nccirow->p_o_box . ' ' .$nccirow->town;
					}			
					
					if($nccirow->webpage != ''){
						
						$insert_my['BUSINESS_URL'] =  $nccirow->webpage;
					}	
					
					if($nccirow->physical_address != ''){
						
						$insert_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->physical_address . ' ' .$nccirow->town . ' '. $nccirow->country;
					}
					
					$insert_my['BUSINESS_DESCRIPTION'] = $nccirow->name . '. ' .$nccirow->products_services . ', '.$nccirow->gen_sector . '. In '.$nccirow->town . ', ' .$nccirow->country; 
					
					$this->db->insert('u_business', $insert_my);
					
					//Update NCCI TABLE WITH BUS ID
					$data_update['bus_id'] = $this->db->insert_id();
					$this->db->where('ncci_id', $nccirow->ncci_id);
					$this->db->update('u_business_ncci', $data_update);
					
				
			}
			
			$count ++;
			$match_id = $nccirow->ncci_id;
		}
		
		echo 'Total Rows: '. $count.'  Duplicates: ' .$duplicate.'  New: '.($count - $duplicate).'<br />';
		
		echo '<a href="'.site_url('/').'ncci/sync_ncci/'.($offset + $limit).'/'.$limit.'/"> Next </a>';
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SYNC TEAM NAMIBIA
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	public function sync_team($offset = 0, $limit = 100)
	{
		//$this->db->limit($limit);
		//$this->db->offset($offset);
		$ncci = $this->db->get('u_business_team');
		//var_dump($ncci);
		$match_id = 0;
		$count = 0;$duplicate = 0;$count_insert = 0;
		foreach($ncci->result() as $nccirow){
			
			//echo $nccirow->business_name;
			//var_dump($nccirow);
			//$match = $this->db->query('SELECT BUSINESS_NAME FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->name.'"', FALSE);
			$match = $this->db->query('SELECT BUSINESS_NAME,BUSINESS_DATE_CREATED ,BUSINESS_EMAIL , BUSINESS_DESCRIPTION, ID, ISACTIVE FROM u_business WHERE BUSINESS_NAME = "'.$nccirow->business_name.'" AND ID != '.$nccirow->team_id .' AND ID != '.$match_id.' ORDER BY ID', FALSE);
			
			//Duplicate - MERGE
			if($match->result()){
				
				foreach($match->result() as $match_row){
					
					echo 'Team Nam: ' . $nccirow->business_name.' == My.na : '.$match_row->BUSINESS_NAME.'++++++ '.$match_row->ID.'<br />++++++++++++++++++++++++++++++<br />'; 
					
					//ADD BUS_ID to NCCI table
					
					$update_data['bus_id'] = $match_row->ID;
					
					$this->db->where('team_id', $nccirow->team_id);
					$this->db->update('u_business_team', $update_data);
					
					//INSERT CONTACTS
					$contact['email'] = $nccirow->email;
					$contact['name'] = $nccirow->name . ' ' .$nccirow->sname;
					$contact['bus_id'] = $match_row->ID;
					$this->db->insert('business_contacts', $contact);
					
					//Update existing My na Table
					if($nccirow->email != ''){
						$update_my['BUSINESS_EMAIL'] = $nccirow->email;
					}
					if($nccirow->telephone != ''  && $nccirow->telephone != '#REF!'){
						
						$update_my['BUSINESS_TELEPHONE'] =  '+264 '.	$nccirow->telephone;
					}
					if($nccirow->mobile != ''  && $nccirow->mobile != '#REF!'){
						
						$update_my['BUSINESS_CELLPHONE'] =  '+264 '.	$nccirow->mobile;
					}	
					if($nccirow->fax != ''  && $nccirow->fax != '#REF!'){
						
						$update_my['BUSINESS_FAX'] =  '+264 '.	$nccirow->fax;
					}
					
					if($nccirow->p_o_box != ''  && $nccirow->p_o_box != '#REF!'){
						
						$update_my['BUSINESS_POSTAL_BOX'] =  $nccirow->p_o_box ;
					
					}elseif($nccirow->po_box_2 != ''  && $nccirow->po_box_2 != '#REF!'){
						
						$update_my['BUSINESS_POSTAL_BOX'] =  $nccirow->po_box_2 ;
					}
					
					if($nccirow->webpage != ''){
						
						$update_my['BUSINESS_URL'] =  $nccirow->webpage;
					}	
					
					if($nccirow->physical_address != '' && $nccirow->physical_address != '#REF!'){
						
						$update_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->physical_address;
					}	
					
					
					$update_my['IS_TEAMNAM_MEMBER'] = 'Y';
					
					$this->db->where('ID', $match_row->ID);
					$this->db->update('u_business', $update_my);
					
					$duplicate ++;
				}
			
			//Insert as NEW	
			}else{
				
	
					$insert_my['IS_TEAMNAM_MEMBER'] = 'Y';
					$insert_my['ISACTIVE'] = 'Y';
					$insert_my['BUSINESS_NAME'] = $nccirow->business_name;
					
					if($nccirow->email != ''){
						$insert_my['BUSINESS_EMAIL'] = $nccirow->email;
					}
					if($nccirow->telephone != ''  && $nccirow->telephone != '#REF!'){
						
						$insert_my['BUSINESS_TELEPHONE'] =  '+264 '.	$nccirow->telephone;
					}
					if($nccirow->mobile != ''  && $nccirow->mobile != '#REF!'){
						
						$insert_my['BUSINESS_CELLPHONE'] =  '+264 '.	$nccirow->mobile;
					}	
					if($nccirow->fax != ''  && $nccirow->fax != '#REF!'){
						
						$insert_my['BUSINESS_FAX'] =  '+264 '.	$nccirow->fax;
					}
					
					if($nccirow->p_o_box != ''  && $nccirow->p_o_box != '#REF!'){
						
						$insert_my['BUSINESS_POSTAL_BOX'] =  $nccirow->p_o_box ;
					
					}elseif($nccirow->po_box_2 != ''  && $nccirow->po_box_2 != '#REF!'){
						
						$insert_my['BUSINESS_POSTAL_BOX'] =  $nccirow->po_box_2 ;
					}
					
					if($nccirow->webpage != ''){
						
						$insert_my['BUSINESS_URL'] =  $nccirow->webpage;
					}	
					
					if($nccirow->physical_address != '' && $nccirow->physical_address != '#REF!'){
						
						$insert_my['BUSINESS_PHYSICAL_ADDRESS'] =  $nccirow->physical_address;
					}
					
					$insert_my['BUSINESS_DESCRIPTION'] = $nccirow->business_name .' located at '.$nccirow->physical_address; 
					
					$this->db->insert('u_business', $insert_my);
					
					//Update NCCI TABLE WITH BUS ID
					$data_update['bus_id'] = $this->db->insert_id();
					$this->db->where('team_id', $nccirow->team_id);
					$this->db->update('u_business_team', $data_update);
					
					//INSERT CONTACTS
					$contact['email'] = $nccirow->email;
					$contact['name'] = $nccirow->name . ' ' .$nccirow->sname;
					$contact['bus_id'] = $data_update['bus_id'];
					$this->db->insert('business_contacts', $contact);
					$count_insert ++;
				
			}
			
			$count ++;
			$match_id = $nccirow->team_id;
		}
		
		echo 'Total Rows: '. $count.'  Duplicates: ' .$duplicate.'  ' . $count_insert .' Rows inserted<br />';
		
		echo '<a href="'.site_url('/').'ncci/sync_team/'.($offset + $limit).'/'.$limit.'/">Next</a>';
	}	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CACHE FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function cacheObject($url,$name,$age = 3600)
    { 
        // directory in which to store cached files
        $cacheDir = BASE_URL."application/cache/my_admin/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
          $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {
		  
		    if ( copy($url, $filename) ) {
				 // update timestamp to now
         		 touch($filename);
			}else{
				echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
			}
         
        }
        // return the cache filename
        return $filename;
    } 
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */