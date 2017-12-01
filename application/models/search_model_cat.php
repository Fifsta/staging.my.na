<?php
class Search_model_cat extends CI_Model{
	
 	function search_model_cat(){
  		//parent::Model();
					
 	}
//MODEL USED FOR SEARCHING CATEGORIES

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW RESULTS - LOOP THROUGH EACH RESULT IN ARRAY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_results($query){
			
			//If has results
			if(count($query)!= 0){
				echo count($query);
				$x =0;
				foreach($query as $row){
					
					
					$name = $row->BUSINESS_NAME;
					$img = $row->BUSINESS_LOGO_IMAGE_NAME;
					$id = $row->ID;
					$email = $row->BUSINESS_EMAIL;
					$tel = $row->BUSINESS_TELEPHONE;
					$description = $row->BUSINESS_DESCRIPTION;
					$url = $row->BUSINESS_URL;
					$address = $row->BUSINESS_PHYSICAL_ADDRESS;
					
					//Build image string
					$format = substr($img,(strlen($img) - 4),4);
					$str = substr($img,0,(strlen($img) - 4));
					
					if($img != ''){
						
						if(strpos($img,'.') == 0){

							$format = '.jpg';
							$img_str = base_url('/').'assets/business/photos/'.$img . $format;
							
						}else{
							
							$img_str =  base_url('/').'assets/business/photos/'.$img;
							
						}
						
					}else{
						
						$img_str = base_url('/').'img/bus_blank.jpg';	
						
					}	
					
					//get Categories
					 $cats = $this->get_current_categories($id);
					
					//get RATING
					 $rating = $this->get_rating($id);
					
					//get MAP Coordinates
					 //$cordinates = $this->get_map_coordinates($id);
					//Build resultset HTML
					
					$html = '<div class="results_div">
							   <a class="pull-right" href="#">
							    <span class="avatar-overlay100"></span>
								<img class="img-polaroid" src="'.$img_str.'" alt="'.$name.'" style="width: 100px; height:100px;">
							  </a>
							  <h3>'.$name.'</h3>
							  <div class="span6" style="min-height:100px;height:auto;margin-bottom:5px;">'.$this->shorten_string($description, '35').'<br /><br />
							  <i class="icon-map-marker"></i><em>'. $address .'</em>
							  </div>
							  <div class="clearfix">&nbsp;</div>
							  <div class="span4">'. implode(' ',$cats).'</div>
							  <div class="span3 pull-right">'.$this->get_review_stars($rating,$id).'</div>
							  <div class="clearfix">&nbsp;</div>
							  <div class="results-footer">
							      <a class="btn" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/"><i class="icon-info-sign"></i> View listing &raquo;</a>
								  <a class="btn" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/contact/" rel="tooltip" title="Contact: '.$name.'"><i class="icon-envelope"></i> Contact Us</a>
								  <a class="btn" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/reviews/" rel="tooltip" title="View full reviews for '.$name.'"><i class="icon-comment"></i> Reviews</a>';
								  if($tel == ''){
								  	 $html .= '';
								  }else{
									  
									$html .= '<a class="btn" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($name).'/contact/" rel="tooltip" title="Click for full contact details"><i class="icon-bullhorn"></i> '.substr($tel, 0,8).'</a>';
								  }
							$html .='</div>	  
						</div>';
						
						
						
						
						echo $html;
					
					 
					$x ++;
				}

				
			//No Results	
			}else{
				
				echo "<div style='text-align:center'>
							  <h1>Ooops, no results found</h1>
							  <p>We could'nt find any results for the specified criteria.</p>
								<img src='".base_url('/')."img/bground/my-na-700-silver.png' alt='My Namibia'/>
							  <p></p>
					  </div>";
				
			}
	
	}




	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW POPULAR CATEGORIES HOMEPAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_popular_cats(){
			
		//Get Main
		$main = $this->get_main_categories();	
		
		foreach($main->result() as $row){
		
			$main_id = $row->ID;
			$main_name = $row->CATEGORY_NAME;
			
			echo '<a class="btn" onclick="load_sub_cats(this.id)" style="margin:5px" id="'.$main_id.'-m_cat"> '.$main_name.' <i class="icon-chevron-right"></i></a>';	
	
			
		}
		
			
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

//CLEAN URL

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//IGNORE', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}


	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS CATEGORIES
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
//Get Main Categories
	function get_main_categories(){
      	
		$test = $this->db->get('a_tourism_category');
		return $test;	  
    }		 	
//GEt sub Categories
	function get_sub_categories($cat_id){
      	
		$test = $this->db->where('CATEGORY_TYPE_ID', $cat_id);
		$test = $this->db->get('a_tourism_category_sub');
		return $test;
				  
    }

	//GEt Current Categories
	function get_current_categories($bus_id){
      	
		$test = $this->db->where('BUSINESS_ID', $bus_id);
		$test = $this->db->get('i_tourism_category');
		
		if($test->num_rows() > 0){
			$y = 0;
			foreach($test->result() as $row){
				
				$cat_id = $row->CATEGORY_ID;
				$x[$y] = '<span class="label">'.$this->get_category_name($cat_id).'</span>';
				$y ++;	
			}
			return $x;
			
		}else{
			
			$x[0] = '<span class="label">No category</span>';
			$x[1] = '';
			return $x;
			
		}
			
				  
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
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET BUSINESS RATING STARS
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
   //GET BUSINESS RATING
	public function get_rating($id){
      	
		$query = $this->db->query("SELECT AVG(RATING)as TOTAL FROM u_business_vote WHERE BUSINESS_ID ='".$id."' ORDER BY TOTAL ");
			
		
		if($query->result()){
			
			$row = $query->row_array();
			return round($row['TOTAL']);
			
		}else{
			
			return 0;
			
		}
		
		
				  
    }
	//GET BUSINESS RATING COUNT
	public function get_rating_count($id){
      	
		$query = $this->db->query("SELECT RATING FROM u_business_vote WHERE BUSINESS_ID ='".$id."'");
			
			return $query->num_rows();
		
				  
    }
    function get_review_stars($rating,$id){
		 
		$x = 1;
		if(($rating != '')){
			
			while($x <= 10){
				
				if($rating == $x){
					
					$str = 'checked="checked"';
				}else{
					
					$str = '';
					
				}
				
				$arr[$x] = '<input name="'.$id.'-'.$rating.'" type="radio" value="'.$x.'" class="star" disabled="disabled" '.$str.'/>
				';	
				$x++;
			}
			
			$arr = '<div style="float:right;font-size:10px;font-style:italic;" class="well well-small"><span class="pull-right">'. implode($arr).'<br />Based on: <b>'.$this->get_rating_count($id).'</b> reviews</span></div>';
			return $arr;
			
		}else{
			
			$arr = '<a class="pull-right clearfix" href="'.site_url('/') . 'b/'. $id .'/'.$this->clean_url_str($this->get_business_name($id)).'/reviews/"><span class="label label-warning" title="Review this business to help them feature" rel="tooltip">No reviews yet. Be the first</span></a><br /><br />';
			return $arr;
			
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
}

?>