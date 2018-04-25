<?php
class Map_model extends CI_Model{
	
 	function map_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET BUSINESS RESULTS
	//++++++++++++++++++++++++++
	public function get_business_results($cat, $type, $l_id = 0, $loc = ''){
		
		$catSQL ='';
        $limitSQL = ' LIMIT 100';
        if($type == 'main' && $cat != 'all'){

            //$cat_id = 3;
            $catSQL = " AND a_tourism_category_sub.CATEGORY_TYPE_ID = '".$cat."'";
            $limitSQL = ' ';
        }elseif($type == 'sub'  && $cat != 'all'){

            $catSQL = " AND a_tourism_category_sub.ID = '".$cat."'";

        }else{


        }
		$lSQL = " ";
		if($l_id != 0 &&  $l_id != 'all' ){
			
			if($catSQL != ''){
			 	$lSQL = " AND u_business.BUSINESS_MAP_CITY_ID = '".$l_id."'";
			}else{
				
				$lSQL = " AND u_business.BUSINESS_MAP_CITY_ID = '".$l_id."'";
			}
			
		}

		$q = "SELECT u_business.ID,u_business.STAR_RATING,u_business.BUSINESS_NAME,  u_business_map.BUSINESS_MAP_LATITUDE as LAT,
								  u_business_map.BUSINESS_MAP_LONGITUDE as LON FROM u_business											
								  JOIN u_business_map ON u_business.ID = u_business_map.BUSINESS_ID
								  LEFT JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
								  JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
								  JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
								  WHERE u_business_map.BUSINESS_MAP_LATITUDE != ''
								 ".$catSQL." ".$lSQL."
								  GROUP BY u_business.ID
								  ".$limitSQL."";

		//Get FEATURED PRODUCTS
		$main = $this->db->query($q);
		
		$output = array();
		if($main->result()){
			$x = 0;
			
			
			foreach($main->result() as $row){
				
				
			}
			
			$output = json_encode($main->result());
		
		}else{
			
				
			
		}
		return $output;
		$this->output->set_content_type('application/json');
		
	}


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //PREFETCH TYEHEAD
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function category_typehead(){


        $test = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), a_tourism_category_sub.CATEGORY_NAME, a_tourism_category_sub.ID
									FROM a_tourism_category_sub
									JOIN i_tourism_category ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID GROUP BY a_tourism_category_sub.ID
									", FALSE);
        $str = '';
        $x = 1;
        $str .= '[';
        if($test->result()){

            foreach($test->result() as $row){
                $comma = ',';
                if($x >= count($test->result_array())){
                    $comma = '';

                }
                $name =  trim(preg_replace("/[^a-z0-9.]+/i", " ", $row->CATEGORY_NAME));
                $array = explode(" ",$name);
                $temp = implode('","' , $array);
                $str .= '{
					  "link1":"javascript:load_results('."'sub'".','.$row->ID.')",
					  "value": "'.$name.'",
						"tokens": [ "'. str_replace(',""' ,'' , $temp). '"]
					}'.$comma;
                $x ++;
            }

        }

        $str .= ']';
        echo $str;

        $this->output->set_content_type('application/json');

    }


    //++++++++++++++++++++++++++++++
    //Instant Search
    //++++++++++++++++++++++++++++++
    public function instant_search_json()
    {
        if($this->input->get('query')){

            if($this->input->get('location') != 'national'){
                $locationSQL = " AND location = '".$this->input->get('location')."' ";
            }
            $strSQL = '';
            if($this->input->get('sub_cat_id') != 0){
                $strSQL = " sub_cat_id = '".$this->input->get('sub_cat_id')."' ";
            }

            if($this->input->get('main_cat_id') != 0){
                if($strSQL == ''){

                    $strSQL = " main_cat_id = '".$this->input->get('main_cat_id')."' AND ";
                }else{
                    $strSQL = $strSQL. " AND main_cat_id = '".$this->input->get('main_cat_id')."' AND ";
                }

            }
            $str = $this->input->get('query');
            $key = $this->db->escape_like_str(urldecode($str));

            /*$query = $this->db->query("SELECT title as name, link
                               FROM search_index LIMIT 10", FALSE);*/

            /*					$query = $this->db->query("SELECT title as name ,link, type, img_file ,body, MATCH(title, body) AGAINST ('".$key."' IN BOOLEAN MODE) as Relevance
                                                   FROM search_index WHERE ".$strSQL." MATCH (title, body) AGAINST('".$key."' IN BOOLEAN MODE)
                                                   HAVING Relevance > 0.2 ORDER BY Relevance DESC LIMIT 10", FALSE);*/

            $query = $this->db->query("SELECT title as name ,link, type, img_file ,body,
														MATCH(title) AGAINST ('".$key."') AS relevance,
														MATCH (title) AGAINST ('".$key."') AS title_relevance
														FROM search_index
														WHERE MATCH (title) AGAINST ('".$key."')
														ORDER BY title_relevance DESC, relevance DESC LIMIT 5", FALSE);

            $str = '[';
            $x = 1;
            if($query->result()){

                foreach($query->result() as $row){
                    $comma = ',';
                    if($x >= count($query->result_array())){
                        $comma = '';

                    }
                    $name =  trim(preg_replace("/[^a-z0-9.]+/i", " ", strip_tags($row->name)));
                    $body =  trim(preg_replace("/[^a-z0-9.]+/i", " ", strip_tags($row->body)));
                    $array = explode(" ",$name);
                    $temp = implode('","' , $array);
                    //$link1 = "<a href='".site_url('/').$row->link.'">';

                    $str .= '{
								  "year":"'.$x.'",
								  "image":"'.base_url('/').'img/timbthumb.php?src='.base_url('/').$row->img_file.'&w=40&h=40",
								  "type":"'.ucwords(str_replace("_"," ",$row->type)).'",
								  "body":"'.substr($body, 0 , 40).'",
								  "link1":"javascript:go_url('."'".site_url('/').$row->link."'".')",
								  "value": "'.$name.'",
									"tokens": [ "'. str_replace(',""' ,'' , $temp). '"]
								}'.$comma;
                    $x ++;
                }

            }
            $str .= ']';


            if($query){
                //var_dump($arr);
                //echo json_encode($arr);
                echo $str;
            }



            $this->output->set_content_type('application/json');
        }
    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//GET BUSINESS CATEGORIES FOR TYPEHEAD
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//Get Main Categories
    function load_category_typehead(){

        $test = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), a_tourism_category_sub.CATEGORY_NAME, a_tourism_category_sub.ID
									FROM a_tourism_category_sub
									JOIN i_tourism_category ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID GROUP BY a_tourism_category_sub.ID
									", FALSE);

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

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET POPULAR CATS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function show_popular_cats($type){

        $this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

        if ( ! $output = $this->cache->get('map_'.$type))
        {
            //$output = '';
            $main = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), COUNT(i_tourism_category.CATEGORY_ID) as num,
                                    a_tourism_category_sub.CATEGORY_TYPE_ID,a_tourism_category.* FROM i_tourism_category
                                    JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
                                    JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
                                    GROUP BY a_tourism_category.ID
                                    ORDER BY num DESC LIMIT 10", FALSE);



            $output .= '<div class="accordion" id="map_accordion">';

            foreach($main->result() as $row){

                $main_id = $row->ID;
                //$main_name = $row->CATEGORY_NAME;
                $main_name = $this->my_na_model->shorten_string($row->CATEGORY_NAME,3) ;
                //break simplified
                if($main_id == 13){

                    continue;
                }
                $sub = $this->db->query("SELECT DISTINCT(i_tourism_category.CATEGORY_ID), COUNT(i_tourism_category.CATEGORY_ID) as num,
                                    a_tourism_category_sub.* FROM i_tourism_category
                                    JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
                                    JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
                                    WHERE a_tourism_category_sub.CATEGORY_TYPE_ID = '".$main_id."'
                                    GROUP BY i_tourism_category.CATEGORY_ID
                                    ORDER BY num DESC LIMIT 10", FALSE);

                $output .= '<span class="notification-small count-res pull-right btn-inverse">'.$row->num.'</span>
                            <div class="accordion-group">

                                    <div class="accordion-heading">
                                      <a class="accordion-toggle" data-toggle="collapse" data-parent="#map_accordion" href="#map_accordion'.$main_id.'">
                                        ' . $main_name . '
                                      </a>
                                    </div>
                                    <div id="map_accordion'.$main_id.'" class="accordion-body collapse">
                                      <div class="accordion-inner">';
                $output .= '<ul class="nav">
                              <li><a href="javascript:void(0)" onclick="load_results('."'main','".$main_id."'".')"><span class="notification-small count-res-sml pull-right btn-inverse">'.$row->num.'</span>All </a></li>';
                    foreach($sub->result() as $subrow){

                        $sub_name = $this->my_na_model->shorten_string($subrow->CATEGORY_NAME,3) ;

                        $output .= '<li><a href="javascript:void(0)" onclick="load_results('."'sub','".$subrow->ID."'".')"><span class="notification-small count-res-sml pull-right btn-inverse">'.$subrow->num.'</span>'.$sub_name.'</a></li>';
                }
                $output .= '</ul>';

                $output .= '           </div>
                                    </div>
                                </div>';


            }


            $output .= '</div>';

            $this->cache->save('map_'.$type, $output, 172800);
        }else{

            echo $output;

        }
        //return $this->output->set_output($output);
        //echo $output;

    }


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW MAP INFOWINDOIW CONTENT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function show_map_info($id, $size){


        $this->load->model('image_model'); 
        $this->load->library('thumborp');

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 320;
        $height = 320;
			
			//$query = $this->db->where('ID',$id);
			$query = $this->db->query("SELECT u_business.*, group_concat(u_gallery_component.GALLERY_PHOTO_NAME) as GALLERY_IMAGES,
										group_concat(DISTINCT(a_tourism_category_sub.CATEGORY_NAME)) as CATEGORIES
										FROM u_business
										LEFT JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
										LEFT JOIN a_tourism_category_sub ON i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
										LEFT JOIN u_gallery_component ON u_business.ID = u_gallery_component.BUSINESS_ID
										WHERE u_business.ID = '".$id."'
										GROUP BY u_business.ID  
										");
			$sizeSTR = '';
            $imgS = '320';
            $csize = '320';
            $logo = '80';
            $name_offset = '';
            if($size == 'small'){

                $sizeSTR = ' d-none';
                $imgS = '240';
                $csize = '240';
                $logo = '60';
                $name_offset = 'margin-left:75px;width:100%';
            }

			//If has results
			if($query->num_rows() != 0){
					
					$row = $query->row();
					
					$id = trim($row->ID);
					$name = str_replace("'",' ',preg_replace("[^A-Za-z0-9]", '', $row->BUSINESS_NAME));
					$img = $row->BUSINESS_LOGO_IMAGE_NAME;
					$cover_img = $row->BUSINESS_COVER_PHOTO;
					$email = $row->BUSINESS_EMAIL;
					$tel = $row->BUSINESS_TELEPHONE;
					$description = str_replace("'",' ',preg_replace("[^A-Za-z0-9]", '', filter_var(utf8_decode($row->BUSINESS_DESCRIPTION), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW)));
					$url = $row->BUSINESS_URL;
					$address = $row->BUSINESS_PHYSICAL_ADDRESS;
					
					//GET CATEGORIES
					$cats = '';
					if($row->CATEGORIES != null){
						$ac = 0;
						$catA = explode(',',$row->CATEGORIES);
						foreach($catA as $catR){

                            if($ac >= 2){

                            }else{
                                $cats .= '<span class="badge btn-dark">'.$catR.'</span> ';

                            }

							
						}
						//$cats = $catA;
						
					}
					
					//Build image string
					$format = substr($img,(strlen($img) - 4),4);
					$str = substr($img,0,(strlen($img) - 4));
					
					if($img != ''){
						
						if(strpos($img,'.') == 0){

                            $format = '.jpg';
                            $img_str = 'assets/business/photos/' . $img . $format;
                            $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
							
						}else{
							
                            $img_str = 'assets/business/photos/' . $img;
                            $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
							
						}
						
					}else{
						
                        $img_str = 'assets/business/photos/bus_blank.jpg';
                        $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,'300','300', $crop = '');
						
					}


					if($cover_img != ''){
						
						if(strpos($cover_img,'.') == 0){
				
                            $format2 = '.jpg';
                            $cover_str = 'assets/business/photos/' . $cover_img . $format2;
                            $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,'340','180', $crop = '');
							
						}else{
							
                            $cover_str = 'assets/business/photos/' . $cover_img;
                            $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,'340','180', $crop = '');
							
						}
						
					}else{
						
						$cover_str = 'assets/business/photos/business_cover_blank.jpg';	
                        $cover_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $cover_str,'340','180', $crop = '');
						
					}


	
	 				if($tel == ''){
					   $btn_1 = '<a class="btn btn-mini white_back '.$sizeSTR.'" href="'.site_url('/') . 'b/'. $id .'/'.$this->my_na_model->clean_url_str($name).'/contact/" rel="tooltip"
											title="Contact: '.$name.'">
											<i class="icon-envelope"></i> 
											Contact Us
										</a>';
					}else{
						
					  $btn_1 = '<a class="btn btn-mini white_back '.$sizeSTR.'"
					  			href="'.site_url('/') . 'b/'. $id .'/'.$this->my_na_model->clean_url_str($name).'/contact/" 
								rel="tooltip" title="Click for full contact details"><i class="icon-bullhorn"></i> '.substr($tel, 0,8).'</a>';
					}

                    $star = '';
                    if($row->STAR_RATING != null && $row->STAR_RATING != 0){

                        $star = '<img src="'.base_url('/').'img/icons/star'.round($row->STAR_RATING).'.png" alt="'.round($row->STAR_RATING) .' Stars Rating">';
                    }



                    $html = '
                    <div class="container-fluid">
                        <div class="row text-center">
                            <img class="img-thumbnail" src="'.$img_url.'" alt="'.$name.'" style="width: '.$logo.'px; height:'.$logo.'px;">
                        </div>
                        <div class="row text-center">
                            <h4 class="upper na_script">'.$name.'</h4>
                        </div>
                        <div class="row text-center">
                            <small><em>'. $this->my_na_model->shorten_string($address, 5) .'</em></small>
                        </div>
                        <div class="row text-center">
                            '.$cats.'
                        </div>
                        <div class="row text-center">
                            <a class="btn btn-xs btn-dark btn-block" href="'.site_url('/') . 'b/'. $id .'/'.$this->my_na_model->clean_url_str($name).'/">
                                <i class="fa fa-info-circle"></i> View
                            </a>
                        </div>                        
                    </div>
                    ';



					/*$html = '<div class="container-fluid" style="max-width:'.$csize.'px;min-width:'.$imgS.'px;margin:0;padding:0;overflow:hidden">
								<div class="row" style="background:url('.$cover_url.') no-repeat; background-size:contain;width:320px;min-height:180px;">
								</div>
								<div class="row">

									<div class="col-md-4" style="margin-top:-80px;">
										<a class="" href="#">
											<img class="img-thumbnail" src="'.$img_url.'" alt="'.$name.'" style="width: '.$logo.'px; height:'.$logo.'px;">
										</a>
									</div>
									
									<div class="col-md-8" style="margin-top:-80px;">
										<h4 class="upper na_script" style="'.$name_offset.' ">'.$name.'</h4>
										<a class="btn btn-mini white_back" style="'.$name_offset.'" href="'.site_url('/') . 'b/'. $id .'/'.$this->my_na_model->clean_url_str($name).'/">
											<i class="icon-info-sign"></i> View
										</a>
										
										'.$btn_1 .'
										<a class="btn btn-mini white_back '.$sizeSTR.'" href="'.site_url('/') . 'b/'. $id .'/'.$this->my_na_model->clean_url_str($name).'/reviews/" rel="tooltip"
											title="View full reviews for '.$name.'">
											<i class="icon-comment"></i> Reviews
										</a><br/>
										<i class="icon-map-marker '.$sizeSTR.'"></i>
											<small><em>'. $this->my_na_model->shorten_string($address, 5) .'</em></small>
									</div>
									
								</div>
								<div class="row clearfix '.$sizeSTR.'">

									<div class="col-md-12">

                                        '.preg_replace( '/\s+/', ' ',strip_tags($this->my_na_model->shorten_string($description, '10'))).'
                                        <div class="clearfix">&nbsp;</div>
                                        <div class="row clearfix">

                                            <div class="col-md-8">

                                                '.$cats.'

                                            </div>
                                             <div class="col-md-4 text-right '.$size.'">

                                                '.$star.'

                                            </div>
									</div>

								</div>	
							</div>
						</div>';*/

			
				//DISPLAY
				echo $html;

				
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
	
	
}
?>