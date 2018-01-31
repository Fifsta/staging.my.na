<?php
class Search_model extends CI_Model{

	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
	//MODEL USED FOR SEARCHING FROM THE HOME PAGE

	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 1 Category Location & Business
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_cat_loc_bus($category,$c_id, $location, $l_id ,$business, $limit, $offset, $sort){
			
			
			if($offset == ''){
				
				$offset = 0;
				
			}else{
				
				$offset = $offset;
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{  
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
            //LIKE STR
            $likeSQL = $this->get_like_string($business);
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID 
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."' ".$likeSQL."
							GROUP BY i_tourism_category.BUSINESS_ID " .$sort."  LIMIT ".$limit." OFFSET ".$offset." ";
							
			$impquery = "SELECT  u_business.ID,(AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL
                            FROM u_business
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."' ".$likeSQL."
							GROUP BY i_tourism_category.BUSINESS_ID " .$sort."  LIMIT ".$limit." OFFSET ".$offset." ";
        //echo $query;
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $impquery;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query, FALSE);
			
			return $query;
	
	}
	
	function Cget_cat_loc_bus($category,$c_id, $location, $l_id, $business){
            //LIKE STR
            $likeSQL = $this->get_like_string($business);
            $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."' ".$likeSQL."
							GROUP BY u_business.ID ";
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query->num_rows();
	
	}
	
	
	function Aget_cat_loc_bus($category, $location ,$business){
            //LIKE STR
            $likeSQL = $this->get_like_string($business);
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$likeSQL." AND
							i_tourism_category.CATEGORY_ID = '". $this->get_category_id($category)."' AND u_business.BUSINESS_NAME like '%".$business."%' 
							GROUP BY u_business.ID ";
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query;
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 2 Category & Location
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_cat_loc($category, $c_id, $location, $l_id , $limit, $offset, $sort){
			
			if($offset == ''){
				
				$offset = 0;
				
			}else{
				
				$offset = $offset;
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
			//$query = $this->db->query("SELECT * FROM u_business JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID WHERE i_tourism_category.CATEGORY_ID = '". $this->get_category_id($category)."' AND (u_business.ISACTIVE = 'Y' AND u_business.BUSINESS_PHYSICAL_ADDRESS LIKE '%".$location."%') LIMIT ".$limit." OFFSET ".$offset." ",FALSE);				
		    
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."'
							GROUP BY u_business.ID " .$sort."  LIMIT ".$limit." OFFSET ".$offset." ";
		    //AND ( a_map_location.ID = '".$l_id."' OR u_business.BUSINESS_PHYSICAL_ADDRESS LIKE '%".$location."%')


			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query, FALSE);	

			return $query;
	
	}
	
	function Cget_cat_loc($category, $c_id, $location, $l_id ){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."'
							GROUP BY u_business.ID";			
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query->num_rows();
	
	}
	
	
	function Aget_cat_loc($category, $c_id, $location, $l_id ){

        $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."'
							GROUP BY u_business.ID";
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);	
			
			return $query;
	
	}
	//FOR category searches
	function Bget_cat_loc($category, $c_id, $location, $l_id ){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND ( a_map_location.ID = '".$l_id."') AND
							i_tourism_category.CATEGORY_ID = '". $c_id."'
							GROUP BY u_business.ID";
			
						
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);	
			
			return $query;
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 3 Category & BUsiness
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_cat_bus($category, $c_id, $business, $limit, $offset ,$sort){
			
			if($offset == ''){
				
				$offset = 0;
				
			}else{
				
				$offset = $offset;
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = '';
					
			}
            //LIKE STR
            $likeSQL = $this->get_like_string($business);
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
					  WHERE i_tourism_category.CATEGORY_ID = '". $c_id."'
					   AND u_business.ISACTIVE = 'Y' ".$likeSQL." ".$sort." LIMIT ".$limit." OFFSET ".$offset." ";
			//echo $query;
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query, FALSE);				

			return $query;
	
	}
	
	function Cget_cat_bus($category, $c_id, $business){
            //LIKE STR
            $likeSQL = $this->get_like_string($business);
			$query = "SELECT u_business.* FROM u_business JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
						WHERE i_tourism_category.CATEGORY_ID = '". $c_id."'
						AND u_business.ISACTIVE = 'Y' ".$likeSQL."";
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);	
			
			$query = $this->db->query($query,FALSE);	
			
			return $query->num_rows();
	
	}
	
	function Aget_cat_bus($category, $c_id ,$business){

            //LIKE STR
            $likeSQL = $this->get_like_string($business);
            $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE i_tourism_category.CATEGORY_ID = '". $c_id."'
						AND u_business.ISACTIVE = 'Y' ".$likeSQL."";
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);	
			
			$query = $this->db->query($query,FALSE);
			
			return $query;
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 4 Location & BUsiness
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_loc_bus($location, $l_id ,$business, $limit, $offset, $sort){
			
			if($offset == ''){
				
				$offset = 0;
				
			}else{
				
				$offset = $offset;
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}

            //LIKE STR
            $likeSQL = $this-> get_like_string($business);

			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y' AND (
						a_map_location.ID = '".$l_id."' ".$likeSQL.")
						GROUP BY u_business.ID ".$sort ." LIMIT ".$limit." OFFSET ".$offset." ";

			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);

			$query = $this->db->query($query, FALSE);		

			return $query;
	
	}
	
	function Cget_loc_bus($location, $l_id, $business){


            //LIKE STR
            $likeSQL = $this->get_like_string($business);
            $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
                            LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
						LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y' AND (
						a_map_location.ID = '".$l_id."' ".$likeSQL.")
						GROUP BY u_business.ID "; 
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);	
				
			$query = $this->db->query($query,FALSE);	
					
			return $query->num_rows();
	
	}
	
	
	function Aget_loc_bus($location, $l_id ,$business){
            //LIKE STR
            $likeSQL = $this-> get_like_string($business);
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y' ".$likeSQL." AND ( a_map_location.ID = '".$l_id."')
						GROUP BY u_business.ID ";
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);	
			
			$query = $this->db->query($query,FALSE);		
			return $query;
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 5 Location 
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_loc($location, $l_id, $limit, $offset, $sort){
			
			if($offset == ''){
				
				$offset = 0;
				
			}else{
				
				$offset = $offset;
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y'
						AND ( a_map_location.ID = '".$l_id."')
						GROUP BY u_business.ID ".$sort ." LIMIT ".$limit." OFFSET ".$offset." ";
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);

			$query = $this->db->query($query, FALSE);					

			return $query;
	
	}
	
	function Cget_loc($location, $l_id){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
						LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
						LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y'
						AND ( a_map_location.ID = '".$l_id."')
						GROUP BY u_business.ID ";			
			
						
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query->num_rows();
	
	}
	
	function Aget_loc($l_id, $location){

             $q = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y'
						AND ( a_map_location.ID = '".$l_id."')
						GROUP BY u_business.ID ";
            $query = $this->db->query($q);
			return $query;
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 6 Category
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_category($category, $c_id, $limit, $offset, $sort){
			
			if($offset == ''){
				
				$offset = ' OFFSET 0';
				
			}else{
				
				$offset = ' OFFSET ' . $offset;	
			}
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
					WHERE u_business.ISACTIVE = 'Y' AND
					i_tourism_category.CATEGORY_ID = '".$c_id."'
					GROUP BY u_business.ID ".$sort." LIMIT ".$limit." ".$offset." ";
			//echo $query;
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query ,FALSE);			

			return $query;
	
	}
	
	function Cget_category($category, $c_id){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
					LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
					JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
					WHERE u_business.ISACTIVE = 'Y' AND
					i_tourism_category.CATEGORY_ID = '".$c_id."'
					GROUP BY u_business.ID ";			
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query->num_rows();
	
	}
	
	function Aget_category($category, $c_id){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
					WHERE u_business.ISACTIVE = 'Y' AND
					i_tourism_category.CATEGORY_ID = '".$c_id."'
					GROUP BY u_business.ID ";	
					
			$query = $this->db->query($query,FALSE);
			
			return $query;
	
	}
	
	function Bget_category($cat_id){
			
			$query = $this->db->query("SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                                      WHERE i_tourism_category.CATEGORY_ID = '".$cat_id."'
                                      AND (u_business.ISACTIVE = 'Y') ",FALSE);
			return $query;
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 7 ONLY business Name
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_bus($business, $limit, $offset, $sort){


            if($offset == ''){

                $offset = 0;

            }else{

                $offset = $offset;
            }

            if ($sort != ''){

                $sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';

            }else{

                $sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';

            }
            //like SQL
            $likeSQL = $this-> get_like_string($business);
            $q = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
						WHERE u_business.ISACTIVE = 'Y' ".$likeSQL."
						GROUP BY u_business.ID ".$sort." LIMIT ".$limit." OFFSET ".$offset." ";


            $query = $this->db->query($q,FALSE);
            return $query;
	
	}
	
	function Cget_bus($business){

            //like SQL
            $likeSQL = $this-> get_like_string($business);
            $q = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
                            LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
                            LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$likeSQL."
                            GROUP BY u_business.ID ";
            $query = $this->db->query($q,FALSE);

            //INSERT IMPRESSION COUNT
            $data['QUERY'] = $q;
            $this->db->insert('u_business_imp_queue',$data);

			
			return $query->num_rows();
	
	}
	
	
	function Aget_bus($business){
			
			//$this->db->limit($limit,$offset);
			$this->db->where('ISACTIVE','Y');
			$this->db->like('BUSINESS_NAME', $business); 
			$query = $this->db->get('u_business');
			return $query;
	
	}
				   

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// 8 No Criteria - All businesses
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_all($limit, $offset, $sort){
			
			if($offset == ''){
				
				$offset = ' OFFSET 0';
				
			}else{
				
				$offset = ' OFFSET ' . $offset;	
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                              WHERE u_business.ISACTIVE = 'Y'
                              GROUP BY u_business.ID ".$sort." LIMIT ".$limit.$offset;
	
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query);
			return $query;
	
	}
	function count_get_all(){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
                              LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
                              WHERE u_business.ISACTIVE = 'Y'
                              GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC";
			
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query->num_rows();
	
	}
	function Aget_all(){
			
			$query = $this->db->query("SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_IDWHERE u_business.ISACTIVE = 'Y'
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC");
			return $query;
	
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//All businesses For Category
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_cat($cat_id, $limit, $offset, $sort){
			

			if($offset == ''){
				
				$offset = ' OFFSET 0';
				
			}else{
				
				$offset = ' OFFSET ' . $offset;	
			}
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
					WHERE u_business.ISACTIVE = 'Y' AND
					i_tourism_category.CATEGORY_ID = '".$cat_id."'
					GROUP BY u_business.ID ".$sort." LIMIT ".$limit.$offset;	
			
						
			 //$this->db->order_by('RAND()');
			//$query = $this->db->get('u_business');
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query ,FALSE);	
			
			return $query;
	
	}
	function count_get_cat($cat_id){
			
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business
					LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID 
					JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
					WHERE u_business.ISACTIVE = 'Y' AND
					i_tourism_category.CATEGORY_ID = '".$cat_id."'
					GROUP BY u_business.ID ";	
			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query->num_rows();
	
	}
	


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//All businesses For MAIN Category
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_cat_main($cat_id, $limit, $offset ,$sort){
			

			if($offset == ''){
			
				$str = ' OFFSET 0';
			
			}else{
				
				$str = ' OFFSET ' . $offset;
				
			}
			
			if ($sort != ''){
			
				$sort = ' ORDER BY u_business.BUSINESS_NAME ' .$sort . ' ';
			
			}else{
				
				$sort = ' ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC ';
					
			}
					
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND
							a_tourism_category_sub.CATEGORY_TYPE_ID = '".$cat_id."'
							GROUP BY u_business.ID ".$sort." LIMIT ".$limit.$str ;				
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			
			return $query;
	
	}
	
	function count_get_cat_main($cat_id){
			
	
				 $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.* FROM u_business 
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID 
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
                            WHERE u_business.ISACTIVE = 'Y' AND
							a_tourism_category_sub.CATEGORY_TYPE_ID = '".$cat_id."'
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC";
				 

			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			$z = $query->num_rows();
			return $z;
	
	}
	//MAP
	function Bget_cat_main($cat_id){
			
	
			$query = $this->db->query("SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND
							a_tourism_category_sub.CATEGORY_TYPE_ID = '".$cat_id."'
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC" ,FALSE);
				 

			
			return $query;
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//All businesses For MAIN Category
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function get_cat_main_loc($cat_id, $limit, $l_id, $location, $offset){
			

			if($offset == ''){
			
				$str = ' OFFSET 0';
			
			}else{
				
				$str = ' OFFSET ' . $offset;
				
			}
			
			if($location == 'namibia'){
					
				$loc_str = "";
					
			}else{
					
				$loc_str = "AND u_business.BUSINESS_MAP_CITY_ID = ".$l_id."";
					
			}
					
			$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$loc_str." AND
							cat_names.CATEGORY_TYPE_ID = '".$cat_id."'
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC LIMIT ".$limit.$str;
			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
			$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query ,FALSE);				

			return $query;
	
	}
	
	function count_get_cat_main_loc($cat_id,$l_id, $location){
			
				if($location == 'namibia'){
					
					$loc_str = "";
					
				}else{
					
					$loc_str = "AND u_business.BUSINESS_MAP_CITY_ID = ".$l_id."";
					
				}
	
				 $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$loc_str." AND
							cat_names.CATEGORY_TYPE_ID = '".$cat_id."'
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC"   ;
				 

			
			//INSERT IMPRESSION COUNT
			//$data['QUERY'] = $query;
			//$this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);
			$z = $query->num_rows();
			return $z;
	
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//BUSINESS QUERY, LOCATION AND MAIN CATEGORY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_cat_main_loc_bus($cat_id, $limit, $l_id,$location, $business, $offset ,$sort){


		if($offset == ''){

			$str = ' OFFSET 0';

		}else{

			$str = ' OFFSET ' . $offset;

		}

		if($location == 'namibia'){

			$loc_str = "";

		}else{

			$loc_str = "AND u_business.BUSINESS_MAP_CITY_ID = ".$l_id."";

		}
		$likeSQL = $this-> get_like_string($business);
		$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$loc_str." AND
							cat_names.CATEGORY_TYPE_ID = '".$cat_id."' ".$likeSQL."
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC LIMIT ".$limit.$str;

		//INSERT IMPRESSION COUNT
		$data['QUERY'] = $query;
		$this->db->insert('u_business_imp_queue',$data);

		$query = $this->db->query($query ,FALSE);

		return $query;

	}

	function count_get_cat_main_loc_bus($cat_id,$l_id, $location, $business){

		if($location == 'namibia'){

			$loc_str = "";

		}else{

			$loc_str = "AND u_business.BUSINESS_MAP_CITY_ID = ".$l_id."";

		}
		$likeSQL = $this-> get_like_string($business);
		$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$loc_str." AND
							cat_names.CATEGORY_TYPE_ID = '".$cat_id."' ".$likeSQL."
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC"   ;



		//INSERT IMPRESSION COUNT
		//$data['QUERY'] = $query;
		//$this->db->insert('u_business_imp_queue',$data);

		$query = $this->db->query($query,FALSE);
		$z = $query->num_rows();
		return $z;

	}

	//MAP
	function Bget_cat_main_loc($cat_id, $location){
				
				if($location == 'namibia'){
					
					$loc_str = "";
					
				}else{
					
					$loc_str = "AND u_business.BUSINESS_PHYSICAL_ADDRESS like '%".$location."%'";
					
				}
	
			
			 $query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' ".$loc_str." AND
							cat_names.CATEGORY_TYPE_ID = '".$cat_id."'
							GROUP BY u_business.ID ORDER BY u_business.PAID_STATUS DESC, TOTAL DESC"   ;
				 

			
			//INSERT IMPRESSION COUNT
			$data['QUERY'] = $query;
		    $this->db->insert('u_business_imp_queue',$data);
			
			$query = $this->db->query($query,FALSE);

			return $query;
	
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW RESULTS - LOOP THROUGH EACH RESULT IN QUERY ARRAY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_results($query, $main_c_id = '', $main_category = '', $category = '', $heading = ''){
			

			$this->load->model('image_model'); 

			$this->load->library('thumborp');
			$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
			$width = 360;
			$height = 230;

			$l_width = 100;
			$l_height = 100;

			//If has results
			if($query->num_rows() != 0){
		
				$x =0;
				foreach($query->result() as $row){

					//$name = filter_var(utf8_decode($row->BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
					$name = $row->BUSINESS_NAME;
					$img = $row->BUSINESS_LOGO_IMAGE_NAME;
					$id = $row->ID;
					$email = $row->BUSINESS_EMAIL;
					$tel = $row->BUSINESS_TELEPHONE;
					$description = $row->BUSINESS_DESCRIPTION;
					$url = $row->BUSINESS_URL;
					$address = $row->BUSINESS_PHYSICAL_ADDRESS;
					$advertorial = $row->ADVERTORIAL;
					
					//Build image string
					$format = substr($img,(strlen($img) - 4),4);
					$str = substr($img,0,(strlen($img) - 4));
					
					if($img != ''){
						
						if(strpos($img,'.') == 0){

							$format = '.jpg';
							$img_str = 'assets/business/photos/'.$img . $format;
							$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$l_width,$l_height, $crop = '');


							
						}else{
							
							$img_str = 'assets/business/photos/'.$img;
							$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$l_width,$l_height, $crop = '');
							
						}
						
					}else{
						
						$img_str = base_url('/').'images/bus_blank.jpg';	
						$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$l_width,$l_height, $crop = '');
						
					}

					//COVER IMAGE
					$cover_img = $row->BUSINESS_COVER_PHOTO;

					if($cover_img != ''){

						if(strpos($cover_img,'.') == 0){

							$format2 = '.jpg';
							$cover_str = S3_URL.'assets/business/photos/'.$cover_img . $format2.'?=';

						}else{

							$cover_str =  S3_URL.'assets/business/photos/'.$cover_img.'?=';

						}

					}else{

						$cover_str = base_url('/').'images/business_cover_blank.jpg';

					}
					//get Categories
					//$cats = $row->cats;
					$catstr = '';
					$cx = 0;
					if($row->cats){

                        $catA = explode(',',$row->cats);

                        foreach($catA as $crow){

							if($cx < 6){

								$catstr .= ' <span class="label label-inverse">'.$crow.'</span> ';
							}

							$cx ++;
                        }

                    }

					//get RATING
					///$rating = $this->get_rating($id);
					
					$ad ='';
					if($advertorial != '' || $row->PAID_STATUS == '1'){
						   
						$ad = '<img src="'.base_url('/').'images/bground/reviewed_2_sml.png" class="pull-right" style="margin:-40px 0px 0 0px; position:absolute" />';

					}

					$sponsor ='';
					if($row->PAID_STATUS == '1'){

						$sponsor = '<small class="muted">Sponsored Listing</small>';
					}
					//get MAP Coordinates
					//$cordinates = $this->get_map_coordinates($id);
					//Build resultset HTML
					$UA = 'href="javascript:void(0)"';
					if($this->agent->is_mobile()){
						
						$UA = 'href="tel:'.substr($tel,0,8).substr($tel,8,strlen($tel)).'"';
					}
					if($tel == ''){
						$temp = '';
					}else{

						$java = "phone_click($(this),'".$id."','phone')";
						$temp = ' <a class="btn white_back" onClick="'.$java.'" rel="tooltip" '. $UA.' title="Click for full contact details"><i class="icon-bullhorn"></i> <abbr title="Telephone Number">C:</abbr>'.substr($tel,0,8).'<font style="display:none">'.substr($tel,8,strlen($tel)).'</font></a>';
					}
					$des = trim(strip_tags(trim($description)));
					$html = '<div class="container results_div" id="business_result_'.$row->ID.'">

							 	<div class="row">
							 		<div class="col-md-9">
										<div class="corner_ribbon">
											<div id="'.$id.'" class="my_na_c"></div>
										</div>

										<h3 class="upper na_script" style="text-indent:10px;height:25px;">'.$name.'</h3>
										'.$sponsor.'
										<p><i class="fa fa-map-marker text-dark"></i> <em>'. $address .'</em></p>
										<p>'.$this->shorten_string($des, 35).'</p>
							 		</div>
							 		<div class="col-md-3">
							 			<div class="row">
							 				<div class="col-md-12 text-center">
												<a class="pull-right" href="#" style="margin:10px 0px 10px 10px ">
													<img class="img-thumbnail" src="'.$img_url.'" alt="'.$name.'" style="width: 100px; height:100px;">
													'.$ad.'
												</a>
							 				</div>

							 			</div>

							 		</div>
							 	</div>
							 	<div class="row">
							 		<div class="col-md-12">

							 		</div>
							 	</div>
							 	<div class="row-fluid">
							 		<div class="col-md-12">
										<p>'.$this->get_review_stars($row->ID, $row->STAR_RATING,$row->NO_OF_REVIEWS).'
 										'. $catstr.'</p>

									 	 <a class="btn white_back" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/"><i class="icon-info-sign"></i> View listing &raquo;</a>
 										 <a class="btn white_back" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/" rel="tooltip" title="Contact: '.$name.'"><i class="icon-envelope"></i> Contact Us</a>
 										 <a class="btn white_back" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/" rel="tooltip" title="View full reviews for '.$name.'"><i class="icon-comment"></i> Reviews</a>
							 			'.$temp.'

							 		</div>
							 	</div>

							 </div>
							 ';


						echo $html;
					
					 
					$x ++;
				}

				
			//No Results	
			}else{
				
				echo "<div class='alert text-center'>
							  <h1>Ooops, no results found for: </h1>
							  <h3>".$heading."</h3>
							  <p>We could'nt find any results for the specified criteria. Please try broaden your search results or look under top level categories.</p>
							  <p></p>
					  </div>";

				if($main_c_id != ''){
					echo '<h3 class="upper na_script">But Here are some other great business results in '.$main_category.'</h3>';
					//SHOW OTHER TOP LEVEL MATCHES
					$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y' AND cat_names.CATEGORY_TYPE_ID = '".$main_c_id."'
							GROUP BY u_business.ID ORDER BY RAND(), TOTAL DESC LIMIT 10"   ;
				}else{
					echo '<h3 class="upper na_script">But Here are some other great business results</h3>';
					//SHOW RANDOM RESULTS
					$query = "SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL, u_business.*,
                            group_concat(DISTINCT(cat_names.CATEGORY_NAME)) as cats
                            FROM u_business
							LEFT JOIN u_business_vote ON u_business_vote.BUSINESS_ID = u_business.ID
							JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN i_tourism_category as categories ON u_business.ID = categories.BUSINESS_ID
							JOIN a_tourism_category_sub as cat_names ON cat_names.ID = categories.CATEGORY_ID
							LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
                            WHERE u_business.ISACTIVE = 'Y'
							GROUP BY u_business.ID ORDER BY RAND() LIMIT 10"   ;
				}


				$query = $this->db->query($query);
//				/echo $this->my_na_model->show_sdvert();

				$this->show_results($query);
			}
	
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SIDEBAR - LOOP THROUGH CATEGORIES
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_sidebar($query){
			
		//Get Main
		$main = $this->db->query("SELECT i_tourism_category.CATEGORY_ID, COUNT(i_tourism_category.CATEGORY_ID) as num,
								a_tourism_category_sub.*,a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME,
								group_concat(DISTINCT(sub_table.ID),'_-_',sub_table.CATEGORY_NAME) as cats
								 FROM i_tourism_category 
								JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID 
								JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
								LEFT JOIN a_tourism_category_sub as sub_table ON sub_table.CATEGORY_TYPE_ID = a_tourism_category.ID  
								GROUP BY a_tourism_category_sub.CATEGORY_TYPE_ID ORDER BY num DESC LIMIT 30", FALSE);
		
		echo '<div class="accordion" id="category_acc">';
			
		foreach($main->result() as $row){
		
			$main_id = $row->CATEGORY_TYPE_ID;
			$main_name = $row->MAIN_CAT_NAME;
			
			echo '<div class="accordion-group">
						<div class="accordion-heading">
						  <a class="accordion-toggle" data-toggle="collapse" data-parent="#category_acc" href="#cat'.$main_id.'">
							'.$main_name.'<i class="icon-zoom-in pull-right"></i>
						  </a>
				  </div>
				  <div id="cat'.$main_id.'" class="accordion-body collapse">
                      <div class="accordion-inner">
                        <ul class="nav nav-pills nav-stacked">';
						//$sub = $this->get_sub_categories($main_id);
						$subA = explode(',',$row->cats);
						foreach($subA as $sub_row){
							//echo $sub_row;
							$id = substr($sub_row, 0, strpos($sub_row,'_-_', 0));
							$name = substr($sub_row, stripos($sub_row,'_-_') + 3, strlen($sub_row));
							
							echo '<li><a href="'.site_url('/').'a/show/'.$main_id.'/'.$this->url_encode($main_name).'/'.$id.'/'.$this->url_encode($name).'/">'.$name.'<i class="icon-chevron-right pull-right"></i></a></li>';
							
						}
						
						
				echo ' </ul>
                      </div>
                    </div>
				  </div>';		
	
			
		}
		echo '</div>';
			
			
	}

	//SHOW SUB CATEGORIES ON HOME PAGE
	function show_sub_cats($id){
			
		$sub = $this->get_sub_categories($id);	
		
			foreach($sub->result() as $sub_row){
				
				$sub_id = $sub_row->ID;
				$sub_name = $sub_row->CATEGORY_NAME;
				echo '<a class="btn" style="margin:5px" href="'.site_url('/').'a/cat/'.$sub_id.'/'.$this->clean_url_str($sub_name).'/">'.$sub_name.' <i class="icon-share-alt"></i></a>';
				
			}
		echo '<br /><a class="btn btn-mini btn-inverse pull-right" id="reload_main"><i class="icon-arrow-left"></i> Go Back</a>';	
			
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function get_main_categories(){
      	
		$test = $this->db->get('a_tourism_category');
		return $test;	  
    }
	//Get Main Categories
	function get_categories_populated(){
      	
		$test = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), COUNT(i_tourism_category.CATEGORY_ID) as num,
								a_tourism_category_sub.*,a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME
								 FROM i_tourism_category 
								JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID 
								JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID 
								GROUP BY i_tourism_category.CATEGORY_ID ORDER BY num DESC LIMIT 20", FALSE);
		return $test;	  
    }		 	
	//GEt sub Categories
	function get_sub_categories($cat_id){
      	
		$test = $this->db->query("SELECT a_tourism_category_sub.CATEGORY_NAME, a_tourism_category_sub.ID
									FROM a_tourism_category_sub
									JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
									WHERE a_tourism_category_sub.CATEGORY_TYPE_ID = '".$cat_id."'", FALSE);
		return $test;
				  
    }

	//GEt sub Categories
	function get_sub_categories_populated(){
      	
		$test = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), a_tourism_category_sub.CATEGORY_NAME, a_tourism_category_sub.ID
									FROM a_tourism_category_sub
									JOIN i_tourism_category ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID GROUP BY a_tourism_category_sub.ID
									", FALSE);
		return $test;
				  
    }


	//GEt CATEGORY NAME
	public function get_category_name($cat_id){
      	
		$test = $this->db->where('ID', $cat_id);
		$test = $this->db->get('a_tourism_category_sub');
		
		
		if($test->result()){
			
			$row = $test->row_array();
			return $row['CATEGORY_NAME'];
			
		}else{
			
			return 'Businesses in Namibia';
			
		}
		
		
				  
    }
	//GEt CATEGORY NAME
	public function get_main_category_name($cat_id){
      	
		$test = $this->db->where('ID', $cat_id);
		$test = $this->db->get('a_tourism_category');
		
		
		if($test->result()){
			
			$row = $test->row_array();
			return $row['CATEGORY_NAME'];
			
		}else{
			
			return 'Businesses in Namibia';
			
		}
		
		
				  
    }
	//GEt CATEGORY NAME
	public function get_category_id($category){
      	
		$test = $this->db->like('CATEGORY_NAME', $category);
		$test = $this->db->get('a_tourism_category_sub');
		
		
		if($test->result()){
			
			$row = $test->row_array();
			return $row['ID'];
			
		}else{
			
			return '0';
			
		}
		
		
				  
    }

    //GEt LOCATION BY ID
    public function get_location_by_id($id){

        $test = $this->db->where('ID', $id);
        $test = $this->db->get('a_map_location');


        if($test->result()){

            $row = $test->row_array();
            return $row['MAP_LOCATION'];

        }else{

            return 'Businesses in Namibia';

        }



    }
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS RATING STARS
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
   //GET BUSINESS RATING
	public function get_rating($id){
      	
		$query = $this->db->query("SELECT AVG(RATING)as TOTAL FROM u_business_vote WHERE BUSINESS_ID ='".$id."' AND IS_ACTIVE = 'Y' AND TYPE = 'review' ORDER BY TOTAL ");
			
		
		if($query->result()){
			
			$row = $query->row_array();
			return round($row['TOTAL']);
			
		}else{
			
			return 0;
			
		}
		
		
				  
    }

	//GET BUSINESS RATING COUNT
	public function get_rating_count($id){
      	
		$query = $this->db->query("SELECT RATING FROM u_business_vote WHERE BUSINESS_ID ='".$id."' AND IS_ACTIVE = 'Y' AND TYPE = 'review'");
			
		return $query->num_rows();
		  
    }

    function get_review_stars_img($rating){

        $x = 1;
        $rating = round($rating);
        if($rating > 5){
            $rating = 5;
        }elseif($rating < 1){
            $rating = 1;

        }
        $str = '<img src="'.base_url('/').'images/icons/star'.$rating.'.png">';

        return $str;
    }

    function get_review_stars($id, $rating,$count){
		 
		$x = 1;
		if(($count > 0)){

            $rating = round($rating);
            if($rating > 5){
                $rating = 5;
            }elseif($rating < 1){
                $rating = 1;

            }
            $str = '<img src="'.base_url('/').'images/icons/star'.$rating.'.png">';
			$arr = '<div style="float:right;font-size:10px;margin-bottom:0;font-style:italic;" class="well well-small"><span class="pull-right">'. $str.'<br />Based on: <b>'.$count.'</b> reviews</span></div>';
			return $arr;
			
		}else{
			
			$arr = '<a class="pull-right clearfix" href="'.site_url('/') . 'b/'. $id .'/reviews/"><span class="label label-warning" title="Review this business to help them feature" rel="tooltip">No reviews yet. Be the first</span></a>';
			return $arr;
			
		}
    }	

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES FOR TYPEHEAD
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function load_category_typehead(){
      	
		$test = $this->get_sub_categories_populated();
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->ID;
			$cat = $row->CATEGORY_NAME;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$cat."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	
	
	//Get Main Categories
	function load_city_typehead(){
      	
		$test = $this->db->get('a_map_location');
		
		$result = 'var subjects_location = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->ID;
			$cat = $row->MAP_LOCATION;
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$cat."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	

	//Get Business Typehead
	function load_business_typehead(){
      	
		$test = $this->db->where('ISACTIVE','Y');
		$test = $this->db->get('u_business');
		
		$result = 'var subjects_business = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->ID;
			$name = str_replace("'",' ',preg_replace("[^A-Za-z0-9]", '', $row->BUSINESS_NAME));
			
			if($x == ($test->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$name."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }

    //+++++++++++++++++++++++++++
    //POPULATE FILTERS PER CATEGORY
    //++++++++++++++++++++++++++
    public function get_categories_select($type, $id, $current_id){

        $out = '';
        if($type == 'main'){

            $test = $this->db->query("SELECT DISTINCT(a_tourism_category_sub.ID) as ID,a_tourism_category_sub.CATEGORY_TYPE_ID,
										a_tourism_category_sub.CATEGORY_NAME, a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME
										FROM a_tourism_category_sub
                                      	JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
                                     ", TRUE);
            $str = 'main';
      
        }else{

            $test = $this->db->query("SELECT DISTINCT(a_tourism_category_sub.ID) as ID, a_tourism_category_sub.*, a_tourism_category.CATEGORY_NAME as MAIN_CAT_NAME
										FROM a_tourism_category_sub
                                      	JOIN a_tourism_category ON a_tourism_category.ID = a_tourism_category_sub.CATEGORY_TYPE_ID
                                     ", TRUE);
            $str = '';
        }

        if($test->num_rows() > 0){

            $out .= '<option value="">Looking For...</option>';
			$temp_main_cat = 0;
            foreach($test->result() as $row){
				
				$cat_id = $row->ID;
				$arrT = array(
						'cat_id' => $cat_id,
						'cat_name' => htmlentities($row->CATEGORY_NAME),
						'main_cat_id' => $row->CATEGORY_TYPE_ID,
						'main_cat_name' => htmlentities($row->MAIN_CAT_NAME),
						'c_type' => 'main'
				);
				//SHO TOP LEVEl
				if($temp_main_cat == $row->CATEGORY_TYPE_ID){
					if($type == 'main' && $row->CATEGORY_TYPE_ID == $current_id){
						//$out .= "<option value='".json_encode($arrT) ."' selected='selected'>".htmlentities($row->MAIN_CAT_NAME)."</option>";
						
					}
					
				}else{
					
					
					if($type == 'main' && $row->CATEGORY_TYPE_ID  == $current_id){
						$out .= "<option value='".json_encode($arrT) ."' selected='selected'>".htmlentities($row->MAIN_CAT_NAME)."</option>";
						
					}else{
						$out .= "<option value='".json_encode($arrT) ."'>".htmlentities($row->MAIN_CAT_NAME)."</option>";
						
					}
						
					
					
				}
			
				$arr = array(
					'cat_id' => $cat_id,
					'cat_name' => htmlentities($row->CATEGORY_NAME),
					'main_cat_id' => $row->CATEGORY_TYPE_ID,
					'main_cat_name' => htmlentities($row->MAIN_CAT_NAME),
					'c_type' => ''
				);
				//$arr = "[{'cat_id':".$cat_id.", 'cat_name':'".htmlentities($row->CATEGORY_NAME)."','main_cat_id':".$row->CATEGORY_TYPE_ID.",'main_cat_name':'".htmlentities($row->MAIN_CAT_NAME)."'}]";
				if($cat_id == $current_id && $type != 'main'){

					$out .= "<option value='".json_encode($arr) ."' selected='selected'>".htmlentities($row->CATEGORY_NAME)."</option>";

				}else{

					$out .= "<option value='".json_encode($arr) ."'>".htmlentities($row->CATEGORY_NAME)."</option>";

				}
				$temp_main_cat = $row->CATEGORY_TYPE_ID;

            }

            $out .= '';

        }else{


            $out .= '<option value="0">No options</option>';

        }
        return $out;
    }
    //+++++++++++++++++++++++++++
    //POPULATE FILTERS PER CATEGORY
    //++++++++++++++++++++++++++
    public function get_cities_select($current_id){

        $test = $this->db->get('a_map_location');

        $out ='';

        if($test->num_rows() > 0){
            $out .= '
					<option value="">Where...in Namibia?</option>
			';
            foreach($test->result() as $row){

                $cat_id = $row->ID;

                if($cat_id == $current_id){

                    $out .= '<option value="'.$cat_id.'_'. htmlentities($row->MAP_LOCATION) .'" selected="selected">'.htmlentities($row->MAP_LOCATION).'</option>';

                }else{

                    $out .= '<option value="'.$cat_id.'_'. htmlentities($row->MAP_LOCATION) .'">'.htmlentities($row->MAP_LOCATION).'</option>';

                }



            }

            $out .= '

			';

        }else{


            $out .= '<option value="0">No options</option>';

        }
        return $out;
    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //GET BUSINESS COORDINATES FOR MAP
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Get Main Categories
	function get_map_coordinates($id){
      	
		$test = $this->db->where('BUSINESS_ID', $id);
		$test = $this->db->get('u_business_map');
		
		$result = $test->row_array();
		if($test->result()){
		
			return $result;
		
		}else{
			
			$result['BUSINESS_MAP_LATITUDE'] = '';
			$result['BUSINESS_MAP_LONGITUDE'] = '';
			return $result;
		}
		
			  
    }	

//+++++++++++++++++++++++++++
	//GET BUSINESS NAME
	//++++++++++++++++++++++++++
	public function get_business_name($bus_id)	
	{
		$this->db->select('BUSINESS_NAME');
		$this->db->where('ID' , $bus_id);
		$query = $this->db->get('u_business');
		
		if($query->num_rows() > 0){
			
			$row = $query->row_array();
			$name = $row['BUSINESS_NAME'];
				
			return $name;
			
		}else{
			
			$data = 'No Name';
			return $data;
			
				
		}

	}




    //+++++++++++++++++++++++++++
    //GET PRODUCT EXTRAS
    //++++++++++++++++++++++++++
    public function build_canonical()
    {
        $url = '';

		if($this->uri->segment(9) != '0' && $this->uri->segment(9) != '') {
			$url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' . $this->uri->segment(7) . '/'. $this->uri->segment(8) . '/'.$this->uri->segment(9).'/';

		}elseif($this->uri->segment(8) != '0' && $this->uri->segment(8) != '') {

            $url = $this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $this->uri->segment(3) . '/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '/' . $this->uri->segment(6) . '/' . $this->uri->segment(7) . '/'. $this->uri->segment(8) . '/';

        }elseif($this->uri->segment(7) != '0' && $this->uri->segment(7) != ''){

            $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/' .$this->uri->segment(6).'/'.$this->uri->segment(7).'/';

        }elseif($this->uri->segment(6) != 'all' && $this->uri->segment(6) != ''){

            $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/' .$this->uri->segment(6).'/';

        }elseif($this->uri->segment(5) != 'all' && $this->uri->segment(5) != ''){

            $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/';

        }elseif($this->uri->segment(4) != 'all' && $this->uri->segment(4) != ''){

            $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/';

        }elseif($this->uri->segment(3) != 'all' && $this->uri->segment(3) != ''){

            $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/';

        }elseif($this->uri->segment(2) != 'all' && $this->uri->segment(2) != ''){

            $url = $this->uri->segment(1).'/'.$this->uri->segment(2).'/';

        }elseif($this->uri->segment(1) != 'all' && $this->uri->segment(1) != ''){

            $url = $this->uri->segment(1).'/';

        }

        echo site_url('/').$url;

    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET PRODUCT PAGE BREADCRUMBS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function show_categories_breadcrumb($main_c_id, $main_category, $c_id, $category, $l_id, $location, $business){


        /*$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('trade/show_categories_breadcrumb_'.$main_cat_id.'_'. $sub_cat_id.'_'. $sub_sub_cat_id.'_'. $sub_sub_sub_cat_id.'_'. $location .'_'. $suburb))
        {*/
            $output = '';
            $output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'" itemprop="url"><span itemprop="title">My</span></span></a><span class="divider">/</span></li>';

            $output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'a/show/" itemprop="url"><span itemprop="title">Business</span></span></a><span class="divider">/</span></li>';
			
			if($main_c_id != 'all'){
				
				$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" 
								href="'.site_url('/').'a/show/'.$main_c_id.'/'.$this->url_encode($main_category).'/"  
								itemprop="url"><span itemprop="title">'.$main_category.'</span></a><span class="divider">/</span></li>';
				
				if($c_id != 'all'){
	
					if($category != 'all'){
	
						$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" 
									href="'.site_url('/').'a/show/'.$main_c_id.'/'.$this->url_encode($main_category).'/'.$c_id.'/'.$this->url_encode($category).'"  
									itemprop="url"><span itemprop="title">'.$category.'</span></a><span class="divider">/</span></li>';
	
						if($l_id != 'all'){
	
							//$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'a/show/'.$c_id.'/"  itemprop="url"><span itemprop="title"></span></a><span class="divider">/</span></li>';
	
							if($location != '' && $location != 'all' && $location != 'national'){
	
								$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" 
											href="'.site_url('/').'a/show/'.$main_c_id.'/'.$this->url_encode($main_category).'/'.$c_id.'/'.$this->url_encode($category).'/'.$l_id.'/'.$this->clean_url_str($location).'"  
											itemprop="url"><span itemprop="title">'.$location.'</span></a><span class="divider">/</span></li>';
	
								/*if($location != '' && $location != 'national'){
	
									$output .= '<li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a class="label label-warning" href="'.site_url('/').'a/show/'.$c_id.'/"  itemprop="url"></a><span itemprop="title">'.ucwords($location).'</li>';
								}*/
	
							}
						}
	
	
					}
	
				}
			}
            /*$this->cache->save('trade/show_categories_breadcrumb_'.$main_cat_id.'_'. $sub_cat_id.'_'. $sub_sub_cat_id.'_'. $sub_sub_sub_cat_id.'_'. $location .'_'. $suburb, $output, 3600);
        }
        //$this->output->set_output($output);
        */
        echo $output;

    }

    //+++++++++++++++++++++++++++
    //GET LIKE STRING SQL
    //++++++++++++++++++++++++++
    public function get_like_string($str)
    {
        $nameA = explode(" ", stripslashes($str));
        $xxx = 0;$t = '';
        foreach($nameA as $nrow){

            if(strtolower($nrow) == 'cc' || strtolower($nrow) == 'pty' || strtolower($nrow) == 'ltd' ||  strlen($nrow) < 3 ){

            }else{


                if($xxx == 0) {

                    $t .= ' AND u_business.BUSINESS_NAME LIKE "%'.$nrow.'%" ';
                }else{

                    if(count($nameA) > 4){
                        $t .= ' AND u_business.BUSINESS_NAME LIKE "%'.$nrow.'%" ';
                    }else{
                        $t .= ' AND u_business.BUSINESS_NAME LIKE "%'.$nrow.'%" ';

                    }


                }
                $xxx ++;
            }




        }

        return $t;

    }

	function url_encode($string){
        //URLS +
		//return urlencode(utf8_encode(  str_replace('(','_', str_replace(')','~',$string))));
		return str_replace('%20', '-', rawurlencode(utf8_encode(  str_replace('(','_', str_replace(')','~',trim($string))))));
    }
    
    function url_decode($string){
        //URLS +
		//return utf8_decode(urldecode(str_replace('_','(', str_replace('~',')',$string))));
		return utf8_decode(rawurldecode(str_replace('-', '%20',str_replace('_','(', str_replace('~',')',trim($string))))));
    }

	//CLEAN URL
	function clean_url_str($str, $replace=array(), $delimiter='-') {

		setlocale(LC_ALL, 'en_US.UTF8');
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
		$clean = filter_var(utf8_decode($str), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
		//$clean = iconv('UTF-8', 'ASCII//IGNORE', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}


	//Shorten String
	function shorten_string($phrase, $max_words) {

		$phrase_array = explode(' ',$phrase);
		//var_dump($phrase_array);
		//echo count($phrase_array);
		if(count($phrase_array) > $max_words && $max_words > 0){

			$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}

		return $phrase;

	}

}

?>