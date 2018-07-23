<?php
class Nmh_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function nmh_model(){
  		//parent::CI_model();
		self::__construct();	
 	}

	
	//GET Publications
	function get_publications($id)
	{

			//CURRENT INTERESTS
			$q = $this->db->query("SELECT * FROM my_na_interests WHERE client_id = '".$id."'",TRUE);
			$out = '';
			$o['publications'] = array();
			$pub_images = array();
			$o['categories'] = array();
			if($q->result()){
				
				//PUBLICATIONS
				foreach($q->result() as $prow){
					
					if($prow->type == 'publications'){
						
						//array_push($o['publications'], $prow->type_id);
						$o['publications'][$prow->type_id] =  $prow->type_id;
					}elseif($prow->type == 'categories'){
						$o['categories'][$prow->type_id] =  $prow->type_id;
						
					}
					
				}
		
			}
			
			$out .= '<input type="hidden" name="publications" id="publications" value="'.implode(',', $o['publications']).'">
					<input type="hidden" name="categories" id="categories" value="'.implode(',', $o['categories']).'">';
			
			//PUBLICATIONS								
			$db = $this->nmh_model->connect_nmh_db();
		
			$pubs = $db->select('pub_id, title,img_file, edition_id, bus_id');
			$pubs = $db->where('status', 'live');	
			$pubs = $db->get('publications');						

			if($pubs->result()){
				$out .= '<div class="row"><div class="mute col-lg-12  col-sm-12 col-xs-12">								
							<div class="page-header">
								  <h4>Publications <small>Select your favourite publications</small></h4>
								</div>
							</div>';
				foreach($pubs->result() as $row){
					

					//SKIP my.na
					if($row->pub_id == 11){
						
						continue;	
					}
					
					if(array_key_exists($row->pub_id, $o['publications'])){
						
						$out .= ' <div class="col-lg-3 col-xs-3">
											<img src="'. S3_URL.$row->img_file.'" data-selected="1" 
											data-pub-id="'.$row->pub_id.'"  class="thumbnail img-responsive border_yes"/>
										</div>';
					}else{
						
						$out .= ' <div class="col-lg-3 col-xs-3">
											<img src="'. S3_URL.$row->img_file.'" data-selected="0" 
											data-pub-id="'.$row->pub_id.'"  class="thumbnail img-responsive"/>
										</div>';
						
					}
					
				}
				$out .= '</div>';
			}
			
			//PUBLICATIONS								
			$db = $this->nmh_model->connect_nmh_db();
		
			/*$cats = $db->select('cat_id, cat_name, cat_name_afrikaans, cat_name_german, cat_name_group');
			$cats = $db->where('cat_name_group !=', '');
		    $cats = $db->group_by('cat_name_group');
			$cats = $db->get('categories');*/
			$cats = $db->query("SELECT cat_id, cat_name, cat_name_afrikaans, cat_name_german, cat_name_group,group_concat(cat_id) as category_ids FROM categories WHERE cat_name_group != '' GROUP BY cat_name_group");
			if($cats->result()){
				
				$result = $cats->result_array();		
				$len = count($result);
				$firsthalf = array_slice($result, 0, $len / 2);
				$secondhalf = array_slice($result, $len / 2);	
				$out .= '<div class="row">
							<div class="mute col-lg-12  col-sm-12 col-xs-12">
								<div class="page-header">
								  <h4>Categories <small>Select your favourite categories</small></h4>
								</div>
							</div>
							<div class="col-lg-6  col-sm-6 col-xs-6">
								<ul class="nav nav-pills nav-stacked">';	
				foreach($firsthalf  as $rows){
					
					if(array_key_exists($rows['cat_id'], $o['categories'])){
						
						$out .= '<li class="active"><a class="categories_select limit-txt" data-id="'.$rows['cat_id'].'" data-selected="true">
													'.$rows['cat_name_group'].'
													<span class="pull-right glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
												<input type="checkbox" class="pull-right hide" value="'.$rows['cat_id'].'" checked/>
											</a>		
										</li>';
					}else{
						
									$out .= '<li role="presentation"><a class="categories_select limit-txt" data-id="'.$rows['cat_id'].'" data-selected="false">
													'.$rows['cat_name_group'].'
													<span class="pull-right glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
													<input type="checkbox" class="pull-right hide" value="'.$rows['cat_id'].'" />
												</a></li>';
						
					}
					
				}
				$out .= '</ul>
				</div>';
				$out .= '<div class="col-lg-6 col-sm-6 col-xs-6">
						<ul class="nav nav-pills nav-stacked">';	
				foreach($secondhalf  as $rows2){
					
					if(array_key_exists($rows2['cat_id'], $o['categories'])){
						
						$out .= '<li class="active"><a class="categories_select limit-txt" data-id="'.$rows2['cat_id'].'" data-selected="true" >
													'.$rows2['cat_name_group'].'
													<span class="pull-right glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
													<input type="checkbox" class="pull-right hide" value="'.$rows2['cat_id'].'" checked/>
												</a>
											</li>';
					}else{
						
									$out .= '<li role="presentation"><a class="categories_select limit-txt" data-id="'.$rows2['cat_id'].'" data-selected="false">
													'.$rows2['cat_name_group'].'
													<span class="pull-right glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
													<input type="checkbox" class="pull-right hide" value="'.$rows2['cat_id'].'" />
												</a></li>';
						
					}
					
				}
				$out .= '</ul>
				</div>
				</div>';
			}
			
			echo $out;
			
	}
	
	//+++++++++++++++++++++++++++
	//NA CONTENT 
	//++++++++++++++++++++++++++
	function na_content($id, $type, $client_id,$social_type)
	{
		if($social_type == 'nja'){
			$db = $this->connect_nmh_db();
			$db->where('type_id', $id);
			$db->where('type', $type);
			$db->where('my_na_id', $client_id);
			$q = $db->get('my_na_na_int');

			if($q->result()){

				$o['result'] = false;
				$o['msg'] = 'Already Liked!';


			}else{

				$in = array(
					'my_na_id' => $client_id,
					'type' => $type,
					'type_id' => $id

				);
				$db->insert('my_na_na_int', $in);

				$o['result'] = true;
				$o['msg'] = 'Success';
			}
			
			
		}else{
			$db = $this->connect_nmh_db();
			
			if($social_type == 'facebook_share'){
				$stype = 'facebook_share';	
			}elseif($social_type == 'twitter_share'){
				$stype = 'twitter_mentions';
			}
			if($stype){
				
				if($type == 'post'){
				
					$q = $db->query("UPDATE posts SET ".$stype." = " .$stype." + 1 WHERE post_id = ".$id."'" );
				}
			}
			
			
			$o['result'] = true;
			$o['msg'] = 'Success';
		}
		return $o;
	}

	//connect to tourism db
	function connect_nmh_db()
	{
		if($_SERVER['HTTP_HOST'] == 'localhost'){
				//connect to main database
				$config_db['hostname'] = 'localhost';
				$config_db['username'] = 'root';
				$config_db['password'] = '';
				$config_db['database'] = 'nmh';
				
		}else{
			//connect to main database
				$config_db['hostname'] = 'nmh-db-1-cluster.cluster-cxonbylt4aio.eu-west-1.rds.amazonaws.com';
				$config_db['username'] = 'root';
				$config_db['password'] = 'OANdyn14784';
				$config_db['database'] = 'nmh';
				$config_db['port']     = 3306;
		}
		
		//$config_db['username'] = 'root';
		//$config_db['password'] = '';
		//$config_db['database'] = 'my_na';

		$config_db['dbdriver'] = 'mysqli';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = false;
		$config_db['db_debug'] = true;
		$config_db['cache_on'] = false;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = true;
		$config_db['stricton'] = false;
		$maindb = $this->load->database($config_db, true);
		$this->db->close();
		
				return $maindb;
	}

	//connect to tourism db
	function connect_events_db()
	{
		if($_SERVER['HTTP_HOST'] == 'localhost'){
			//connect to main database
			$config_db['hostname'] = 'localhost';
			$config_db['username'] = 'root';
			$config_db['password'] = '';
			$config_db['database'] = 'my_na_events';

		}else{
			//connect to main database
			$config_db['hostname'] = '154.0.162.107';
			$config_db['username'] = 'eventsmy_usr';
			$config_db['password'] = 'W$?~V!=A;?df';
			$config_db['database'] = 'eventsmy_na_db';

		}

		//$config_db['username'] = 'root';
		//$config_db['password'] = '';
		//$config_db['database'] = 'my_na';

		$config_db['dbdriver'] = 'mysqli';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = false;
		$config_db['db_debug'] = true;
		$config_db['cache_on'] = false;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = true;
		$config_db['stricton'] = false;
		$maindb = $this->load->database($config_db, true);
		$this->db->close();

		return $maindb;
	}
}
?>