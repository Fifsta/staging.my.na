<?php
class Classifieds_model extends CI_Model{

	public function __construct() {
  		//parent::CI_model();
		$this->load->database();	
 	}
	

 //+++++++++++++++++++++++++++
	//GET Main Categories
	//++++++++++++++++++++++++++
	public function get_main_categories_select($mcid="")
	{


		$query = $this->db->order_by('cat_name', 'ASC');
		$query = $this->db->group_by('cat_name');
		
		$query = $this->db->get('classifieds_categories');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->cl_cat_id == $mcid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->cl_cat_id.'" '.$selected.'>'.$row->cat_name.'</option>';

			}

		}

	}

	//+++++++++++++++++++++++++++
    //CLASSIFIEDS SEARCH ? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function get_classifieds($featured = false)
	{

		 $sql = '';
		 $query['cat_name'] = '';
		 $query['cl_cat_id'] = '';

		 if($cl_cat_id = $this->input->get_post('cl_cat_id',TRUE)){
			 if(is_numeric($cl_cat_id)){
			 	$sql = ' AND classifieds.cl_cat_id = '.$cl_cat_id.'';
			 }
			 $query['cl_cat_id'] = $cl_cat_id;
			 $query['cat_name'] = $this->input->get_post('cat_name', true);
			 
		 }

		$query['location'] = 'Namibia';
		$query['location_id'] = 'all';

		if($location =$this->input->get_post('location',TRUE)){
			 
			 if($location != 'all'){
				 $clean = substr($location,strpos($location,'_',0) +1, strlen($location));
				 $clean_id = substr($location,0, strpos($location,'_',0));
				 $sql .= " AND classifieds.location_id = '".$clean_id."'";
				 $query['location'] = $clean;
				 $query['location_id'] = $clean_id;
			 }
			  
		} 

		$query['q'] = '';

		if($query['q'] =$this->input->get_post('q',TRUE)){
			 
			 if(explode(' ',$query['q']) > 1){
				 $a = explode(' ',$query['q']);
				 $x = 0;
				 foreach($a as $qrow){
					 
					 if(strlen($qrow) > 3){
						 
						 if($x > 0){
							 
							 $sql .= " OR (classifieds.title LIKE '%".$qrow."%' OR classifieds.content LIKE '%".$qrow."%' OR classifieds.adbooking_id LIKE '%".$qrow."%')";
						 }else{
							 
							 $sql .= " AND (classifieds.title LIKE '%".$qrow."%' OR classifieds.content LIKE '%".$qrow."%' OR classifieds.adbooking_id LIKE '%".$qrow."%')";
							 
						 }
						 
						 
					 }else{
						 
						 
					 }
					 
					 $x ++;
				 }
				 
				 
			 }else{
				 
				  $sql .= " AND (classifieds.title LIKE '%".$query['q']."%' OR classifieds.content LIKE '%".$query['q']."%' OR classifieds.adbooking_id LIKE '%".$query['q']."%')";
			 }
		 }

		if(!$query['limit'] =$this->input->get_post('limit',TRUE)){
			 
			 $query['limit'] = 20;
		 }
		  
		 if(!$query['offset'] = $this->input->get_post('offset',TRUE)){
			 
			$query['offset'] = 0;
		 } 
		
		 if($featured){
			 
			 $sql = " AND classifieds.is_featured = 'Y' AND u_business.BUSINESS_LOGO_IMAGE_NAME != ''";
			 
		 }
		 
		 $sqlgo = "SELECT classifieds.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			cat.cat_name ,a_map_location.MAP_LOCATION as location,a_map_location.ID as location_id,
					group_concat(pub.bus_id) as pubs,
					(
					  SELECT COUNT(classifieds.classified_id) FROM classifieds WHERE classifieds.status = 'live' ".$sql." 
					) as total_rows
		 			FROM classifieds 
		 			LEFT JOIN u_business ON u_business.ID = classifieds.bus_id
					LEFT JOIN classifieds_categories as cat ON cat.cl_cat_id = classifieds.cl_cat_id
					LEFT JOIN a_map_location ON a_map_location.ID = classifieds.location_id
					LEFT JOIN classifieds_publication_int as pub ON pub.classified_id = classifieds.classified_id
		 			WHERE status = 'live' ".$sql." AND listing_date <= CURDATE()
					GROUP BY classifieds.classified_id
					ORDER BY classifieds.listing_date DESC
					LIMIT ".$query['limit']." OFFSET ".$query['offset']."";

		 $query['query'] = $this->db->query($sqlgo, true);
		 
		 return $query;
		 
	}


	//+++++++++++++++++++++++++++++++++
    //CLASSIFIEDS RENDER ? RESULTS PAGE
    //+++++++++++++++++++++++++++++++++
	public function render_classifieds($query)
	{
		

		 $this->load->model('my_model');

		 $o = '<div class="row">';
		 if($query->result()){
			 $x = 0;
			foreach($query->result() as $row){
				
				$b = $this->render_business($row);
				//$b = '';
				$fb = "postToFeed(" . $row->classified_id . ", '" . ucwords(trim($this->my_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_model->shorten_string(strip_tags($this->my_model->clean_url_str($row->content, " ", " ")), 50)))) . "', '" . site_url('/') . 'classifieds/view/' . $row->classified_id . '/' . trim($this->my_model->clean_url_str($row->title)) . "')";

				//$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";

				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
				$tweet_url = 'https://twitter.com/share?url=' . site_url('/') .'classifieds/view/'. $this->my_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
				


				$loc = '';

				if(is_numeric($row->location_id)){
					
					$loc .= '<p><i class="icon-map-marker"></i><em>'. $row->location;
					
				}else{
					
					$loc .=	'<p><em>';
				}
				
				if($row->BUSINESS_NAME != ''){
					
					$loc .= ' - '.$row->BUSINESS_NAME.'</em></p>';
				}else{
					
					$loc .=  '</em></p>';
				}

				$cat = '';
				if($row->cat_name != ''){
					
					$cat = '<span class="badge badge-inverse">'.$row->cat_name. '</span>';
				}
				
				$subs = '';

				//PUBLICATIONS
				if(strlen($row->pubs) > 0){
					
					$pubA = explode(',',$row->pubs);
					foreach($pubA as $prow){
						
							if($prow != 0 || $prow != 1 || $prow != 2){
						
								$subs .= '<img src="'.HUB_URL.'img/publications/'.$prow.'.png" style="width:25px;height:25px; margin:2px" width="25">';
							}
						
					}
					
				}
				
				$o .= '<div class="col-sm-12 col-md-6 col-lg-6 col-xl-4">
						<figure>
							<div class="product_ribbon_sml"><small>'.$row->cat_name.' &nbsp;</small>'.date('jS \of F Y',strtotime($row->listing_date)).'<span></span></div>
							<span class="pull-right" style="margin-top:0px">
							<a onClick="' . $fb . '" class="facebook"></a>
							' . anchor_popup('https://twitter.com/share?url=' . trim($tweet_url), ' ', $tweet) . '
							</span>
							<div style="margin-top:80px">
								<h2 class="font-weight-bold">'.$row->title.'</h2>
							</div>
							<div>
								<p>'.$this->my_model->shorten_string(strip_tags($row->content), 30).'</p>
								<p class="muted">'.$row->adbooking_id.'</p>
							</div>
							<div class="text-right">
								<div class="pull-left">'.$subs.'</div>
								<a href="'.site_url('/').'classifieds/view/'.$row->classified_id.'/'.$this->my_model->clean_url_str($row->title).'/" class="btn btn-dark">View</a>
							</div>
						</figure>
					   </div>
				      ';				
				$x ++;
			}
			 
		 }else{
			 
			 
			 
		 }
		  $o .= '</div>';
		  
		  return $o;
	}



//+++++++++++++++++++++++++++++++++
    //CLASSIFIEDS RENDER ? RESULTS PAGE
    //+++++++++++++++++++++++++++++++++
	public function render_latest_classifieds($query)
	{
		

		 $this->load->model('my_model');

		 $o = '<div class="owl-carousel" style="margin-top:20px">';
		 if($query->result()){
			 $x = 0;
			foreach($query->result() as $row){
				
				$b = $this->render_business($row);
				//$b = '';
				$fb = "postToFeed(" . $row->classified_id . ", '" . ucwords(trim($this->my_model->clean_url_str($row->title, " ", " "))) . "','" . trim('') . "', '" . ucwords(trim($this->my_model->clean_url_str($row->title, " ", " "))) . " - My Namibia','" . preg_replace("/[^0-9a-zA-Z -]/", "", ucwords(trim($this->my_model->shorten_string(strip_tags($this->my_model->clean_url_str($row->content, " ", " ")), 50)))) . "', '" . site_url('/') . 'classifieds/view/' . $row->classified_id . '/' . trim($this->my_model->clean_url_str($row->title)) . "')";

				//$fb = "window.open('https://www.facebook.com/sharer/sharer.php?app_id=287335411399195&u=". rawurlencode(site_url('/').'product/'.$row->product_id.'/'.$this->clean_url_str($row->title)) ."', '_blank', 'width=800,height=600,scrollbars=yes,status=yes,resizable=yes,screenx=20%,screeny=20%')";

				$tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter');
				$tweet_url = 'https://twitter.com/share?url=' . site_url('/') .'classifieds/view/'. $this->my_model->clean_url_str($row->title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($row->title), 0, 100))) . '&via=MyNamibia';
				


				$loc = '';

				if(is_numeric($row->location_id)){
					
					$loc .= '<p><i class="icon-map-marker"></i><em>'. $row->location;
					
				}else{
					
					$loc .=	'<p><em>';
				}
				
				if($row->BUSINESS_NAME != ''){
					
					$loc .= ' - '.$row->BUSINESS_NAME.'</em></p>';
				}else{
					
					$loc .=  '</em></p>';
				}

				$cat = '';
				if($row->cat_name != ''){
					
					$cat = '<span class="badge badge-inverse">'.$row->cat_name. '</span>';
				}
				
				$subs = '';

				//PUBLICATIONS
				if(strlen($row->pubs) > 0){
					
					$pubA = explode(',',$row->pubs);
					foreach($pubA as $prow){
						
							if($prow != 0 || $prow != 1 || $prow != 2){
						
								$subs .= '<img src="'.HUB_URL.'img/publications/'.$prow.'.png" style="width:25px;height:25px; margin:2px; float:left">';
							}
						
					}
					
				}

				$social = '<span class="pull-right" style="margin-top:0px">
							<a onClick="' . $fb . '" class="facebook"></a>
							' . anchor_popup('https://twitter.com/share?url=' . trim($tweet_url), ' ', $tweet) . '
						   </span>';

				$social = '';		   
				
				$o .= '<div>
						<figure>
							<div class="product_ribbon_sml"><small style="color:#ff9900">'.$row->cat_name.' &nbsp;</small>'.date('jS \of F Y',strtotime($row->listing_date)).'<span></span></div>
							'.$social.'
							<div style="margin-top:80px">
								<h2 class="font-weight-bold">'.$row->title.'</h2>
							</div>
							<div>
								<p>'.$this->my_model->shorten_string(strip_tags($row->content), 30).'</p>
								<p class="muted">'.$row->adbooking_id.'</p>
							</div>
							<div class="text-right">
								'.$subs.'
								<a href="'.site_url('/').'classifieds/view/'.$row->classified_id.'/'.$this->my_model->clean_url_str($row->title).'/" class="btn btn-dark">View</a>
							</div>
						</figure>
					   </div>
				      ';				
				$x ++;
			}
			 
		 }else{
			 	 
			 
		 }

		 $o .= '</div>';
		  
		 return $o;
	}	



	//+++++++++++++++++++++++++++
    //CAREERS RENDER BUSINESS? RESULTS PAGE
    //++++++++++++++++++++++++++
	public function render_business($row)
	{
		  $o = '';	
		  if($row->bus_id != 0 && $row->bus_id != null){
		   		
				$t = '';
				$grade = $this->render_education($row);
				
		   		if($row->COVER != '' && $row->COVER != null){
					
					
					if(strpos($row->COVER, '.')){
						$t = "'".S3_URL."assets/business/photos/".$row->COVER."'";
						
					}else{
						
						$t = "'".S3_URL."assets/business/photos/".$row->COVER.".jpg'";
						
					}
					
				}else{
					
					$t = "'".base_url('/')."img/business_cover_blank.jpg'";
				}
				if($row->LOGO != '' && $row->LOGO != null){
					
					if(strpos($row->LOGO, '.')){
						$l = base_url('/') . 'img/timbthumb.php?src=' . S3_URL . 'assets/business/photos/' . $row->LOGO. '&w=200&h=200';
						
					}else{
						
						$l = base_url('/') . 'img/timbthumb.php?src=' . S3_URL . 'assets/business/photos/' . $row->LOGO. '.jpg&w=200&h=200';
						
					}
					
					
				}else{
					
					$l = base_url('/')."img/bus_blank.jpg";
				}
				
				$o .= '<div class="row-fluid  bottom-black" style="height:200px;background-image:url('.$t.');background-size:cover; z-index:88; position:relative;">
							<div class="row-fluid " style="; padding:5px 0">
								
								<div class="span3 vlogo" style="padding-left:25px;">
									<img src="'.$l.'" class="blogo img-responsive img-polaroid">
								</div>
								<div class="span9 vtitle">
									<h3 class="upper na_script white">'.$row->title.'</h3>
									<p class="white"><i class="icon-map-marker icon-white"></i><em>'. $row->location.' - '.$row->BUSINESS_NAME.'</em></p>
									<p class="white">'.$grade.'</p>
								</div>
							</div>
						</div>';
		  }
		  return $o;
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//PREFETCH TYEHEAD
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function load_typehead($type, $cat){

        $str = array();
		$sql = '';
		if($q =$this->input->get_post('query',TRUE)){
			 
			 if(explode(' ',$q) > 1){
				 $a = explode(' ',$q);
				 $x = 0;
				 foreach($a as $qrow){
					 
					 if(strlen($qrow) > 2){
						 
						 if($x > 0){
							 
							 $sql .= " OR (classifieds.title LIKE '%".$qrow."%' OR classifieds.content LIKE '%".$qrow."%' OR classifieds.adbooking_id LIKE '%".$qrow."%' )";
						 }else{
							 
							 $sql .= " AND (classifieds.title LIKE '%".$qrow."%' OR classifieds.content LIKE '%".$qrow."%' OR classifieds.adbooking_id LIKE '%".$qrow."%')";
							 
						 }
						 
						 
					 }else{
						 
						 
					 }
					 
					 $x ++;
				 }
				 
				 
			 }else{
				 
				  $sql .= " AND (classifieds.title LIKE '%".$q."%' OR classifieds.content LIKE '%".$q."%' OR classifieds.adbooking_id LIKE '%".$q."%')";
			 }
		 }
		
		$sql = "SELECT classifieds.*, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME as LOGO, u_business.BUSINESS_COVER_PHOTO as COVER,
		 			cat.cat_name ,a_map_location.MAP_LOCATION as location,a_map_location.ID as location_id,
					(
					  SELECT COUNT(classifieds.classified_id) FROM classifieds WHERE classifieds.status = 'live' ".$sql." 
					) as total_rows
		 			FROM classifieds 
		 			LEFT JOIN u_business ON u_business.ID = classifieds.bus_id
					LEFT JOIN classifieds_categories as cat ON cat.cl_cat_id = classifieds.cl_cat_id
					LEFT JOIN a_map_location ON a_map_location.ID = classifieds.location_id
		 			WHERE status = 'live' ".$sql."  AND listing_date <= CURDATE()
					ORDER BY classifieds.listing_date DESC
					LIMIT 100";
					
	
		$test = $this->db->query($sql, true);			
		$x2 = 1;
		if($test->result()){

			foreach($test->result() as $row2){

				$name2 =  $row2->title;
				$array2 = explode(" ",$name2);
				$temp2 = implode('","' , $array2);
				$link = site_url('/').'classifieds/view/'.$row2->classified_id.'/'.$this->my_na_model->clean_url_str($name2).'/';
				$img = $row2->LOGO;
				//Build image string
				$format = substr($img,(strlen($img) - 4),4);
				$strT = substr($img,0,(strlen($img) - 4));

				if($img != ''){

					if(strpos($img,'.') == 0){

						$format = '.jpg';
						$img_str = base_url('/').'img/timbthumb.php?w=20&h=20&src='.S3_URL.'assets/business/photos/'.$img . $format;

					}else{

						$img_str =  base_url('/').'img/timbthumb.php?w=20&h=20&src='.S3_URL.'assets/business/photos/'.$img;

					}

				}else{

					$img_str = base_url('/').'img/timbthumb.php?w=20&h=20&src='.base_url('/').'img/bus_blank.png';

				}


				$t = array(

					"year" => $x2,
					"image" => $img_str,
					"type" => "Classifieds",
					"body" => $name2,
					"link1" => "javascript:go_url('".$link."')",
					"value" => $name2,
					"tokens" => $array2

				);
				array_push($str, $t);

				$x2 ++;
			}

		}

        echo json_encode($str);

		$this->output->set_content_type('application/json');
			  
    }
	
}
?>