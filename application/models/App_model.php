<?php
class App_model extends CI_Model{
		
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	/*function app_model(){
  		//parent::CI_model();
		self::__construct();
 	}*/


//++++++++++++++++++++++++++++++ 
    //FIND USER TYPEHEAD
    //++++++++++++++++++++++++++++++
    public function find_users($key)
    {
		if(strlen($key) < 2){
			
			return;
		}
        $key = $this->db->escape_like_str(urldecode($key));
		
		$str2 = " (u_client.CLIENT_NAME like '%" . $key . "%' OR u_client.CLIENT_SURNAME like '%" . $key . "%' 
							OR u_client.CLIENT_EMAIL like '%" . $key . "%' OR u_client.CLIENT_CELLPHONE like '%" . $key . "%' ) ";
		//MORE THAN 2 WoRDS
		if (str_word_count($key) > 1)
		{
			$str1 = explode(" ", $key);
			//echo var_dump($str1);
			$str2 = '';	
			
			$c = 0;
			foreach ($str1 as $keys)
			{
				if (count($str1) - 1 == $c)
				{
					$end = '';
				}
				else
				{
					$end = ' AND ';

				}
				$str2 .= " (u_client.CLIENT_NAME like '%" . $keys . "%' OR u_client.CLIENT_SURNAME like '%" . $keys . "%' 
							OR u_client.CLIENT_EMAIL like '%" . $keys . "%' OR u_client.CLIENT_CELLPHONE like '%" . $keys . "%' ) " . $end;
				$c++;
			}
		}

		$test = $this->db->query("SELECT u_client.ID as ID,u_client.IS_ACTIVE,u_client.FB_ID, u_client.CLIENT_NAME as FNAME,u_client.VERIFIED,u_client.CLIENT_SURNAME as SNAME,CLIENT_EMAIL as EMAIL,
								CLIENT_CELLPHONE as CELL, u_client.CLIENT_PROFILE_PICTURE_NAME as IMG
							 FROM u_client
							 WHERE ".$str2." LIMIT 15 ", true);
							 
		$o['success'] = false;
		$o['result'] = array();
		if ($test->result())
		{
			$a = array();
			$this->load->library('encrypt');
			$o['success'] = true;
			foreach($test->result() as $row){
				
				$row->ACC_link = $this->encrypt->encode(json_encode($row));
				array_push($a, $row);
				
			}
			
			$o['result'] = $a;
			

		} 


        $this->output->set_content_type('application/json');

    }




	//+++++++++++++++++++++++++++
	//REGISTER TOURISM  FUNCTIONS
	//++++++++++++++++++++++++++
	function register_tourism($email, $fname, $sname, $dial_code,$cell,$pass,$company,$title,$workshop)
	{

		$result['msg'] = '';
		$result['success'] = false;

		$this->load->model('members_model');

		//VALIDATE INPUT
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$val = FALSE;
			$error = 'Email address is not valid.';
		} elseif (($fname == '')) {
			$val = FALSE;
			$error = 'Please provide us with your full name.';
		} else {
			$val = TRUE;
		}


		if ($val == TRUE) {

			$this->load->library('user_agent');

			$agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();

			$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];

			$insertdata = array(
				'CLIENT_NAME' => $fname,
				'CLIENT_SURNAME' => $sname,
				'CLIENT_EMAIL' => $email,
				'CLIENT_OCCUPATION' => $title,
				'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass),
				'CLIENT_CELLPHONE' => $cell,
				'DIAL_CODE' => $dial_code,
				'CLIENT_UA' => $agent,
				'CLIENT_IP' => $IP,				
				'IS_ACTIVE' => 'N'
			);


			$this->db->where('CLIENT_EMAIL', $email);
			$this->db->from('u_client');
			$query = $this->db->get();
 
			//IF email already exists
			if ($query->num_rows() > 0) {

				$row = $query->row();

				$result['msg'] = 'A member with the email address ' . $email . ' already exists!';
				$result['success'] = false;
				$result['client_id'] = $row->ID;
				$result['email'] = $email;
				$result['vcard_link'] = '<a href="'.site_url('/').'app/user_code_tourism/?client_id='.$row->ID.'">Get Vcard</a>';


				//UPDATE CERTAIN FIELDS
				//1. First update u_client_table

				$updatedata = array(
					'CLIENT_OCCUPATION' => $title
				);
				$this->db->where('ID', $row->ID);
				$this->db->update('u_client', $updatedata);

				
				//2. Check if user is listed in the extended table
				$this->db->where('client_id', $row->ID);
				$this->db->from('u_client_extend');
				$query2 = $this->db->get();


				//IF entry already exists
				if ($query2->num_rows() > 0) {

				} else {

					$insertdata2 = array(
						'client_id' => $row->ID,
						'company' => $company,
						'workshop' => $workshop
					);
					$this->db->insert('u_client_extend', $insertdata2);

					$result['success-company'] = true;
					$result['client_id'] = $row->ID;
					$result['email'] = $email;
					$result['vcard_link'] = '<a href="'.site_url('/').'app/user_code_tourism/?client_id='.$row->ID.'">Get Vcard</a>';

				}

			} else {

				//Insert into u_client
				$this->db->insert('u_client', $insertdata);
				$member_id = $this->db->insert_id();

				//Insert into u_client_extend
				$insertdata2 = array(
					'client_id' => $member_id,
					'company' => $company,
					'workshop' => $workshop
				);
				$this->db->insert('u_client_extend', $insertdata2);


				//success redirect
				$result['msg'] = 'Thank you ' . $fname . '';
				$result['success'] = true;
				$result['success-company'] = true;
				$result['client_id'] = $member_id;
				$result['email'] = $email;
				$result['vcard_link'] = '<a href="'.site_url('/').'app/user_code_tourism/?client_id='.$member_id.'">Get Vcard</a>';

			}


		} else {

			$result['msg'] = $error;
			$result['success'] = false;

		}

		return $result;

	}


//+++++++++++++++++++++++++++
	//CREATE USER QR CODE
	//++++++++++++++++++++++++++
	function get_qrcode_tourism_user($id)
	{
		

		$link = S3_URL.'assets/users/qr/'.$id.'_trsm_vcard.jpg';

		
		//CHECK IF EXISTING FILE EXISTS
		if (file_exists( $link )) {

			$vcard2 = $link;				
			$o['success'] = true;
			$o['qr_code_file'] = $link;
			$o['code'] = $id.'-MYNA';
			$o['msg'] = '';
			
		} else {
			
			//GET CLIENT
			//$this->db->where('ID', $id);
			//$subscr = $this->db->get('u_client');


			$subscr = $this->db->query("SELECT A.CLIENT_NAME, A.CLIENT_SURNAME, A.CLIENT_TELEPHONE, A.CLIENT_CELLPHONE, A.CLIENT_EMAIL, A.CLIENT_OCCUPATION, B.company
									   FROM u_client AS A 
									   LEFT JOIN u_client_extend AS B ON A.ID = B.client_id
									   WHERE A.ID = '".$id."'
									   ", TRUE);



			if($subscr->result()){
				$this->load->library('ciqrcode');
				$subscr_row = $subscr->row();
				//BUILD DATA
				$url = site_url('/').'vcard/'.$subscr_row->CLIENT_NAME.' ' .$subscr_row->CLIENT_SURNAME.'/'.$id.'/';
				$web = '';$tel = '';
				if($subscr_row->CLIENT_TELEPHONE != ''){

					$tel = 'TEL;WORK;VOICE:' . trim($subscr_row->CLIENT_TELEPHONE) . "\n";

				}
				if($subscr_row->CLIENT_CELLPHONE != ''){

					$tel = 'TEL;WORK;VOICE:' . trim($subscr_row->CLIENT_CELLPHONE) . "\n";

				}

				// here our data
				$vcard1 = 'BEGIN:VCARD'."\n";
				$vcard1 .= 'N:' . ucwords(trim($subscr_row->CLIENT_NAME.' ' .$subscr_row->CLIENT_SURNAME)) . "\n";
				$vcard1 .= 'EMAIL:' . trim($subscr_row->CLIENT_EMAIL) . "\n";
				$vcard1 .= $tel;
				$vcard1 .= 'ORG:' . trim($subscr_row->company) . "\n";
				$vcard1 .= 'END:VCARD';

				$params['data'] = $vcard1;
				$params['level'] = 'Q';
				$params['size'] = 4;
				$params['savename'] = BASE_URL .'assets/users/qr/'.$id.'_trsm_vcard.jpg';
				$this->ciqrcode->generate($params);
				//SEND TO BUCKET
				$this->load->model('gcloud_model');
				$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , '/assets/users/qr/');
				
				$vcard2 = $link;
				$o['success'] = true;
				$o['qr_code_file'] = $link;
				$o['code'] = $id.'-MYNA';
				$o['msg'] = '';
				
			}else{
		
				$o['success'] = false;
				$o['qr_code_file'] = '';
				$o['code'] = $id.'-MYNA';
				$o['msg'] = 'User not found';
		
			
			}
				
		}
		return $o;
	}



	//+++++++++++++++++++++++++++
	//CREATE QR CODE
	//++++++++++++++++++++++++++
	function get_categories()
	{


		$db = $this->nmh_model->connect_nmh_db();


		$q = $db->query("SELECT * FROM categories", true);


		$o = $q->result();

		return $o;

	}



	//+++++++++++++++++++++++++++
	//CREATE QR CODE
	//++++++++++++++++++++++++++
	function client_get($params)
	{
		if($params['client_id'] == 0 && $params['number'] == null){
			$o['success'] = false;
			$o['msg'] = 'No criteria';
			return $o;		
		}
		
		if($params['client_id'] != 0){
			
			$sql = " a.ID = ".$params['client_id']." ";
		}

		if($params['number'] != null){
			
			$params['number'] = preg_replace( '/[^0-9]/', '',$params['number']);
			if(strlen($params['number']) < 9 ){
				$o['success'] = false;
				$o['msg'] = 'No valid number';
				return $o;		
			}
			
			//WITH dial code
			if(strlen($params['number']) > 10){
				
				$code = substr($params['number'],0,3);
				$num = substr($params['number'],3,strlen($params['number']));
				//echo substr($num,0,1);
				if((strlen($num) >= 10) && substr($num,0,1) == '0'){
					
					$num = substr($num,1,strlen($num));
				}
				$sql = " a.CLIENT_CELLPHONE LIKE '%".$num."' AND a.DIAL_CODE = '".$code."' ";
			
			}elseif(strlen($params['number']) == 10){
				$num = $params['number'];
				if((strlen($num) >= 10) && substr($num,0,1) == '0'){
					
					$num = substr($num,1,strlen($num));
				}
				$sql = " a.CLIENT_CELLPHONE LIKE '%".$num."' AND a.DIAL_CODE = '264' ";
			}else{
				$num = $params['number'];

				$sql = " a.CLIENT_CELLPHONE LIKE '%".$params['number']."' AND a.DIAL_CODE = '264' ";
			}
			
		}
		$q = $this->db->query("SELECT a.ID as my_id, CONCAT(a.DIAL_CODE,a.CLIENT_CELLPHONE) as mobile,a.VERIFIED as mobile_verified, a.CLIENT_EMAIL as email, 
							a.CLIENT_GENDER as gender,a.CLIENT_DATE_OF_BIRTH as dob, a.CLIENT_PROFILE_PICTURE_NAME as pic, 
							a.CLIENT_NAME as name,a.CLIENT_SURNAME as lastname, a.CLIENT_OCCUPATION as profession,
							a_map_location.MAP_LOCATION as city,a_map_suburb.SUBURB_NAME as suburb,a_country.COUNTRY_NAME as country
							FROM u_client as a
							LEFT JOIN a_country ON a_country.ID = a.CLIENT_COUNTRY
							LEFT JOIN a_map_location ON a_map_location.ID = a.CLIENT_CITY
							LEFT JOIN a_map_suburb ON a_map_suburb.ID = a.CLIENT_SUBURB
							WHERE ".$sql."", true);
		//echo $this->db->last_query();
		//TEST MULTIPLE VALIDATED RESULTS
		$o['data'] = array();
		if($q->result()){
			if($q->num_rows() > 1){
				
				foreach($q->result() as $row){
					
					if($row->mobile_verified == 'Y'){
						
						$row->pic = $this->my_na_model->get_user_avatar_id(0 ,200, 200, $row->pic);
						//$row->pic = S3_URL .'assets/users/photos/'.$row->pic;
						$o['success'] = true;
						array_push($o['data'], $row);
						
					}
					
				}
			
			}else{
				$o['success'] = true;
				$row = $q->row();	
				$row->pic = $this->my_na_model->get_user_avatar_id(0 ,200, 200, $row->pic);
				array_push($o['data'], $row);
			}
		}else{
			$o['success'] = false;
			$o['msg'] = 'No results';	
			
		}
		return $o;

	}
	
	//+++++++++++++++++++++++++++
	//CREATE USER QR CODE
	//++++++++++++++++++++++++++
	function get_qrcode_user($id)
	{
		

		$link = S3_URL.'assets/users/qr/'.$id.'_vcard.jpg';

		
		//CHECK IF EXISTING FILE EXISTS
		if (file_exists( $link )) {

			$vcard2 = $link;				
			$o['success'] = true;
			$o['qr_code_file'] = $link;
			$o['code'] = $id.'-MYNA';
			$o['msg'] = '';
			
		} else {
			
			//GET CLIENT
			$this->db->where('ID', $id);
			$subscr = $this->db->get('u_client');
			if($subscr->result()){
				$this->load->library('ciqrcode');
				$subscr_row = $subscr->row();
				//BUILD DATA
				$url = site_url('/').'vcard/'.$subscr_row->CLIENT_NAME.' ' .$subscr_row->CLIENT_SURNAME.'/'.$id.'/';
				$web = '';$tel = '';
				if($subscr_row->CLIENT_TELEPHONE != ''){

					$tel = 'TEL;WORK;VOICE:' . trim($subscr_row->CLIENT_TELEPHONE) . "\n";

				}
				if($subscr_row->CLIENT_CELLPHONE != ''){

					$tel = 'TEL;WORK;VOICE:' . trim($subscr_row->CLIENT_CELLPHONE) . "\n";

				}
				// here our data

				$vcard1 = 'BEGIN:VCARD'."\n";
				$vcard1 .= 'N:' . ucwords(trim($subscr_row->CLIENT_NAME.' ' .$subscr_row->CLIENT_SURNAME)) . "\n";
				$vcard1 .= 'EMAIL:' . trim($subscr_row->CLIENT_EMAIL) . "\n";
				$vcard1 .= $tel;
				$vcard1 .= 'END:VCARD';

				$params['data'] = $vcard1;
				$params['level'] = 'H';
				$params['size'] = 5;
				$params['savename'] = BASE_URL .'assets/users/qr/'.$id.'_vcard.jpg';
				$this->ciqrcode->generate($params);
				//SEND TO BUCKET
				$this->load->model('gcloud_model');
				$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , '/assets/users/qr/');
				
				$vcard2 = $link;
				$o['success'] = true;
				$o['qr_code_file'] = $link;
				$o['code'] = $id.'-MYNA';
				$o['msg'] = '';
				
			}else{
		
				$o['success'] = false;
				$o['qr_code_file'] = '';
				$o['code'] = $id.'-MYNA';
				$o['msg'] = 'User not found';
		
			
			}
			

			
		}
		return $o;
	}
	
	//+++++++++++++++++++++++++++
	//CREATE QR CODE
	//++++++++++++++++++++++++++
	function get_qrcode($type, $data)
	{
		//CHECK IF EXISTING FILE EXISTS
		$this->load->library('encrypt');
		$file = 'voucher_'.$data->voucher_id;
		$code = rand(9999,9999).'-'.$data->voucher_id.'-'.rand(9999,9999).
		$voucher = $this->encrypt->encode($data->voucher_id);
		if (file_exists(S3_URL.'assets/qr/'.$file.'_url.jpg')) {

			  $out = '<img src="'.S3_URL.'assets/qr/'.$file.'_url.jpg"  style="width:100%;height:auto"/><p class="text-grey" style:"text-align:center">Voucher: <strong class="text-black font-110">'.$data->voucher.'</strong></p>';

		} else {
			//save QR file
			$this->load->library('ciqrcode');
			$out = site_url('/').'voucher/'.$voucher.'/';

			//$config['black']        = array(0,113,132); // array, default is array(255,255,255)
			//$config['white']        = array(70,130,180); // array, default is array(0,0,0)
			//$this->ciqrcode->initialize($config);

			$params['data'] = $voucher;
			$params['level'] = 'L';
			$params['size'] = 10;
			$params['savename'] = BASE_URL .'assets/qr/' .$file. '_url.jpg';
			$this->ciqrcode->generate($params);
			//SEND TO BUCKET
			$this->load->model('gcloud_model');
			$out = $this->gcloud_model->upload_gc_bucket($params['savename'] , '/assets/qr/');
			
			$out = '<img src="'. S3_URL.'assets/qr/'.$file.'_url.jpg" style="width:100%;height:auto"/><p class="text-grey" style:"text-align:center">Voucher: <strong class="text-black font-110">'.$data->voucher.'</strong></p>';

		}
		return $out;
	}
	//+++++++++++++++++++++++++++
	//GET PRIZE IMAGE
	//++++++++++++++++++++++++++
	function get_prize($win_id)
	{
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();

		$prize = $db->query("SELECT scratch_prizes.* FROM scratch_winners
							JOIN scratch_prizes ON scratch_prizes.ID = scratch_winners.PRIZE_ID
							WHERE HAS_CLAIMED = 0 AND scratch_winners.ID = ".$win_id."
							");
		$out = '';
		if($prize->result()){

			$row = $prize->row();
			$out = '<img src="'.EVENTS_URL.'assets/prizes/'.$row->IMAGE_URL.'" style="width:100%;height:auto;" />';


		}
		return $out;
	}
	//+++++++++++++++++++++++++++
	//GET VOUCHER IMAGE
	//++++++++++++++++++++++++++
	function get_voucher_image($promo_id)
	{
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();

		$prize = $db->query("SELECT scratch_prizes.* FROM scratch_promotion
							JOIN scratch_prizes ON scratch_prizes.PROMOTION_ID = scratch_promotion.ID
							WHERE scratch_promotion.ID = ".$promo_id." ORDER BY RAND() LIMIT 1
							");
		$out = '';
		if($prize->result()){

			$row = $prize->row();
			$out = '<img src="'.EVENTS_URL.'assets/prizes/'.$row->IMAGE_URL.'" style="width:100%;height:auto;" />';


		}
		return $out;
	}

	//+++++++++++++++++++++++++++
	//GET ALL CURRENT PROMOTIONS POST
	//+++++++++++++++++++++++++++
	public function current_promotions($user_id)
	{

		$uSQL = '';

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();
		
		if($user_id != 0){

			$uSQL = "AND scratch_promotion_scans.client_id  = ".$user_id."";
		}
		//!!!WARNING
		//REMEMBER TO STATICALLY TOGGLE THIS NUMBE TO CALCULATE BADGES FROM
		//app.php  submit_rating
		//+++++++++++++++++++++++++++++
		$query = $db->query("SELECT scratch_promotion.*, COUNT(scratch_promotion_scans.client_id) as badges
						FROM scratch_promotion
						LEFT JOIN scratch_promotion_scans ON scratch_promotion_scans.promo_id = scratch_promotion.ID  ".$uSQL." AND scratch_promotion_scans.voucher_id IS NULL
						WHERE scratch_promotion.IS_ACTIVE = 1  AND DATE(scratch_promotion.START_DATE) <= CURDATE() AND DATE(scratch_promotion.END_DATE) >= CURDATE()
						GROUP BY scratch_promotion.ID
						ORDER BY scratch_promotion.ID ASC");

		if($query->result()){

			$o['promotions'] = $query->result();
			$o['success'] = true;



		}else{

			$o['success'] = true;
			$o['msg'] = 'There are no current active promotions';


		}
		return $o;
	}

	//+++++++++++++++++++++++++++
	//GET INTERESTS
	//++++++++++++++++++++++++++
	function get_interests($id)
	{

		$o['publications'] = array();
		$o['categories'] = array();
		$match['publications'] = array();
		$match['categories'] = array();
		$o['success'] = true;
		if($id != 0){

			//CURRENT INTERESTS
			$q = $this->db->query("SELECT * FROM my_na_interests WHERE client_id = '".$id."'",TRUE);
			$o['publications'] = array();
			$o['categories'] = array();
			$match['publications'] = array();
			$match['categories'] = array();
			if($q->result()){

				//PUBLICATIONS
				foreach($q->result() as $prow){
					//PUBLICATIONS
					if($prow->type == 'publications'){

						//array_push($o['publications'], $prow->type_id);
						$match['publications'][$prow->type_id] =  $prow->type_id;
					}
					//CATEGORIES
					if($prow->type == 'categories'){

						//array_push($o['publications'], $prow->type_id);
						$match['categories'][$prow->type_id] =  $prow->type_id;
					}

				}

			}

		}


		//PUBLICATIONS
		$db = $this->nmh_model->connect_nmh_db();
		//PUBLICATIONS
		$pubs = $db->select('pub_id, title,img_file, edition_id, bus_id, body');
		$pubs = $db->where('status', 'live');
		$pubs = $db->get('publications');

		if($pubs->result()){

			foreach($pubs->result() as $row){
				$t = array(
						'pub_id' => $row->pub_id,
						'img' => $row->img_file,
						'title' => $row->title,
						'body' => $row->body

				);
				if(array_key_exists($row->pub_id, $match['publications'])){
					$t['selected'] = true;
				}else{
					$t['selected'] = false;

				}
				array_push($o['publications'], $t);

			}

		}

		//CATEGORIES
		$cat = $db->query("SELECT cat_id, cat_name, cat_name_afrikaans, cat_name_german, cat_name_group,group_concat(cat_id) as category_ids FROM categories WHERE cat_name_group != '' GROUP BY cat_name_group");


		if($cat->result()){

			foreach($cat->result() as $crow){
				$t = array(
						'cat_id' => $crow->cat_id,
						'title' => $crow->cat_name,
						'title_afrikaans' => $crow->cat_name_afrikaans,
						'title_german' => $crow->cat_name_german,
						'title_group' => $crow->cat_name_group,
						'category_ids' => $crow->category_ids,

				);
				if(array_key_exists($crow->cat_id, $match['categories'])){
					$t['selected'] = true;
				}else{
					$t['selected'] = false;

				}
				array_push($o['categories'], $t);

			}

		}

		//var_dump($o);
		return $o;

	}



	//+++++++++++++++++++++++++++
	//GET CATEGORIES CONTENT
	//++++++++++++++++++++++++++
	function get_category_content($id,$pub_id, $limit, $offset, $title_group, $post_id)
	{
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('api_get_category_content'.$id.'_'.$pub_id.'_'.$limit.'_'.$offset.'_'.$title_group.'_'.$post_id))
		{

			$sql = "";
			if(!is_null($post_id)){
				
				
			}
			
			if ($title_group != '')
			{
				$sql = " AND categories.cat_name_group = '" . trim(urldecode($title_group)) . "' ";

			}
			elseif ($id != 0)
			{
				$sql = " AND categories.cat_id IN (" . $id . ") ";


			}
			$pubSQL = '';
			if($pub_id != 0){

				$pubSQL = " AND publications.pub_id IN (" . $pub_id . ") ";

			}
			if(!is_null($post_id)){
				
				$sql = " AND posts.post_id = ".$post_id;
			}


			if($pub_id == 12) {

				$editions = [118, 110, 125, 126, 127];

				$edSQL = " AND posts.edition_id IN (" . $editions . ") ";	

			}


			$db = $this->nmh_model->connect_nmh_db();

			//".$pubSQL."
			$str = "SELECT posts.*,posts.slug as post_slug,publications.pub_id,posts.hits,posts.location,publications.title as publication,
							  (select group_concat(images.img_file) FROM images WHERE images.type_id = posts.post_id and images.type = 'post') as images,
							  (select images.img_file FROM images WHERE images.type_id = posts.post_id and images.type = 'post' LIMIT 1) as image,
							  (select COUNT(my_na_na_int.type_id) FROM my_na_na_int WHERE my_na_na_int.type_id = posts.post_id AND my_na_na_int.type = 'post') as total_na,
							  (select group_concat(categories.cat_name) from post_cat_int LEFT JOIN categories ON categories.cat_id = post_cat_int.cat_id 
								   WHERE post_cat_int.post_id = posts.post_id
							  ) categoriesall,categories.cat_name, categories.cat_name_afrikaans ,categories.cat_name_german, categories.slug,categories.cat_name_group,
							  (select group_concat(DISTINCT(keywords.keyword))from keyword_content_int LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id
								   WHERE keyword_content_int.type_id = posts.post_id AND keyword_content_int.type = 'post'
							  ) keywords
						FROM posts
						INNER JOIN publication_content_int ON publication_content_int.type_id = posts.post_id AND publication_content_int.type = 'post'
                        INNER JOIN publications ON publications.bus_id = publication_content_int.bus_id
						INNER JOIN post_cat_int ON post_cat_int.post_id = posts.post_id
						INNER JOIN categories ON categories.cat_id = post_cat_int.cat_id
						
						WHERE posts.status = 'live' ".$sql." ".$pubSQL." ".$edSQL." AND posts.show_myinfo = 'Y'
						AND posts.datetime > DATE_SUB(NOW(), INTERVAL 3 MONTH)
						AND  exists ( select 1 from images 
							where images.type_id = posts.post_id
							AND images.type = 'post'
                        )
	                    ORDER BY posts.datetime DESC, posts.priority_rev DESC, posts.pub_id ASC LIMIT " . $limit . " OFFSET " . $offset;

			//echo $str;
			/*$str = "SELECT posts.*,publication_content_int.bus_id,publications.pub_id,posts.hits,posts.location,publications.title as publication,group_concat(images.img_file) as images,images.img_file as image,
									group_concat(DISTINCT(keywords.keyword)) as keywords, COUNT(my_na_na_int.type_id) as total_na,
									categories.cat_name, categories.cat_name_afrikaans ,categories.cat_name_german, categories.slug_afrikaans,categories.cat_name_group
									FROM posts
									JOIN publication_content_int ON publication_content_int.type_id = posts.post_id AND publication_content_int.type = 'post'
									JOIN publications ON publications.bus_id = publication_content_int.bus_id
									LEFT JOIN my_na_na_int ON my_na_na_int.type_id = posts.post_id AND my_na_na_int.type = 'post'
									JOIN images ON images.type_id = posts.post_id and images.type = 'post'
									JOIN post_cat_int ON post_cat_int.post_id = posts.post_id
									JOIN categories ON categories.cat_id = post_cat_int.cat_id
									LEFT JOIN keyword_content_int ON keyword_content_int.type_id = posts.post_id AND keyword_content_int.type = 'post'
									LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id
									WHERE posts.status = 'live' " . $sql . " AND posts.show_myinfo = 'Y'
									AND posts.datetime > DATE_SUB(NOW(), INTERVAL 7 DAY)
									GROUP BY posts.post_id
	                                ORDER BY posts.breaking_news DESC, posts.datetime DESC, posts.priority LIMIT " . $limit . " OFFSET " . $offset;
									*/

			$cat = $db->query($str, false);
			$o = array();
			if ($cat->result())
			{

				$o = $cat->result();

			}
			//$o['query'] = $str;
			$this->cache->save('api_get_category_content'.$id.'_'.$pub_id.'_'.$limit.'_'.$offset.'_'.$title_group.'_'.$post_id,$o, 3600);
			//var_dump($o);

		}
		return $o;
	}


	//+++++++++++++++++++++++++++
	//GET PUBLICATION CONTENRT
	//++++++++++++++++++++++++++
	function get_publication_content($id, $limit, $offset)
	{

		/*$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('api_get_publication_content'.$id.'_'.$limit.'_'.$offset))
		{*/
			$db = $this->nmh_model->connect_nmh_db();
			$str = "SELECT 
							  posts.*,publication_content_int.bus_id,publications.pub_id,posts.hits,posts.location,publications.title as publication,
							
							  (select group_concat(images.img_file) FROM images WHERE images.type_id = posts.post_id and images.type = 'post') as images,
							  (select images.img_file FROM images WHERE images.type_id = posts.post_id and images.type = 'post' LIMIT 1) as image,
							  (select COUNT(my_na_na_int.type_id) FROM my_na_na_int WHERE my_na_na_int.type_id = posts.post_id AND my_na_na_int.type = 'post') as total_na,
							  (select group_concat(categories.cat_name) from post_cat_int LEFT JOIN categories ON categories.cat_id = post_cat_int.cat_id 
								   WHERE post_cat_int.post_id = posts.post_id
							  ) categoriesall,categories.cat_name, categories.cat_name_afrikaans ,categories.cat_name_german, categories.slug_afrikaans,categories.cat_name_group,
							  (select group_concat(DISTINCT(keywords.keyword))from keyword_content_int LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id
								   WHERE keyword_content_int.type_id = posts.post_id AND keyword_content_int.type = 'post'
							  ) keywords
						FROM posts
						INNER JOIN publication_content_int ON publication_content_int.type_id = posts.post_id AND publication_content_int.type = 'post'
                        INNER JOIN publications ON publications.bus_id = publication_content_int.bus_id
						INNER JOIN post_cat_int ON post_cat_int.post_id = posts.post_id
						JOIN categories ON categories.cat_id = post_cat_int.cat_id
						WHERE posts.status = 'live' AND publications.pub_id IN (" . $id . ") AND posts.show_myinfo = 'Y'
						AND posts.datetime > DATE_SUB(NOW(), INTERVAL 3 MONTH)
						AND  exists ( select 1 from images 
							where images.type_id = posts.post_id
							AND images.type = 'post'
                        )
	                    ORDER BY posts.datetime DESC, posts.priority_rev DESC LIMIT " . $limit . " OFFSET " . $offset;


			/*$str = "SELECT posts.*,publication_content_int.bus_id,posts.hits,posts.location,publications.pub_id,publications.title as publication,group_concat(images.img_file) as images,images.img_file as image,
									COUNT(my_na_na_int.type_id) as total_na,categories.cat_name, categories.cat_name_afrikaans ,categories.cat_name_german, categories.slug_afrikaans,categories.cat_name_group,
									group_concat(DISTINCT(keywords.keyword)) as keywords
									FROM posts
									JOIN publication_content_int ON publication_content_int.type_id = posts.post_id AND publication_content_int.type = 'post'
									JOIN publications ON publications.bus_id = publication_content_int.bus_id
									LEFT JOIN my_na_na_int ON my_na_na_int.type_id = posts.post_id AND my_na_na_int.type = 'post'
									JOIN images ON images.type_id = posts.post_id and images.type = 'post'
									JOIN post_cat_int ON post_cat_int.post_id = posts.post_id
									JOIN categories ON categories.cat_id = post_cat_int.cat_id
									LEFT JOIN keyword_content_int ON keyword_content_int.type_id = posts.post_id AND keyword_content_int.type = 'post'
									LEFT JOIN keywords ON keywords.key_id = keyword_content_int.key_id
									WHERE posts.status = 'live' AND publications.pub_id IN (" . $id . ") AND posts.show_myinfo = 'Y'
									AND posts.datetime > DATE_SUB(NOW(), INTERVAL 14 DAY)
									GROUP BY posts.post_id
	                                ORDER BY posts.datetime DESC LIMIT " . $limit . " OFFSET " . $offset;*/

			$cat = $db->query($str, false);
			$o = array();
			if ($cat->result())
			{

				$o = $cat->result();

			}

			//$this->cache->save('api_get_publication_content'.$id.'_'.$limit.'_'.$offset,$o, 600);
		//}

		return $o;

	}

	//+++++++++++++++++++++++++++
	//SCAN PROMOTION VOUCHER 
	//+++++++++++++++++++++++++++
	public function scan_promo($client_id, $promo_id)
	{
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();
		
	}
	//+++++++++++++++++++++++++++
	//DO VOUCHER BADGES CALCULATIONS
	//+++++++++++++++++++++++++++
	public function rating_vouchers_badges($client_id, $promo_id)
	{
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();

		$q = $db->where('promotion_id', $promo_id);
		$q = $db->where('user_id', $client_id);
		$q = $db->where('is_actioned', 'N');
		$q = $db->group_by('rating_hash');
		$q = $db->get('exhibitor_ratings');

		if($q->result()){
			//!!!WARNING
			//REMEMBER TO STATICALLY TOGGLE THIS NUMBE TO CALCULATE BADGES FROM
			//app.php  submit_rating
			//+++++++++++++++++++++++++++++

			//DYNAMIC = GET PROMOTION BADGES
			$promo = $db->where('ID', $promo_id);
			$promo = $db->get('scratch_promotion');

			//ONLY IF PROMO AVAILABLE
			if($promo->result()){

				$promorow = $promo->row();
				//IF RATING RESULT
				//statiic old method
				//if($q->num_rows() >= 1){

				//NEW method dynamic check the DB record
				if($q->num_rows() >= $promorow->MAX_BADGES)
                {
					//GET ROW
					$row = $q->row();

					//INSERT VOUCHERS
					$voucher = $client_id.'-'.$promo_id.'-'.$row->event_id.rand(999,9999);
					$in = array(
						'event_id' => $row->event_id,
						'client_id' => $client_id,
						'promotion_id' => $promo_id,
						'voucher' => $voucher,
						'claimed' => 'N',
						'type' => 'touch_n_win'
					);
					$db->insert('scratch_promotion_vouchers', $in);
					$vid = $db->insert_id();
					//UPDATE PROMOTION SCANS BADGES
					$pdata = array(
						'voucher_id' => $vid
					);
					//$q1 = $db->where('promo_id', $promo_id);
					//$q1 = $db->where('client_id', $client_id);
					//$q1 = $db->where('voucher_id', 'NULL');
					$q1 = $db->query("UPDATE scratch_promotion_scans SET voucher_id = ".$vid." WHERE promo_id = ".$promo_id." AND client_id = ".$client_id." AND voucher_id IS NULL");
					//UPDATE RATINGS LOG
					$u = array(

						'is_actioned' => 'Y',
						'voucher_id' => $vid
					);
					$q = $db->where('promotion_id', $promo_id);
					$q = $db->where('user_id', $client_id);
					$q = $db->update('exhibitor_ratings', $u);

				}

			}



		}

	}
	//+++++++++++++++++++++++++++
	//DO VOUCHER BADGES CALCULATIONS
	//+++++++++++++++++++++++++++
	public function single_vouchers_badges($client_id, $promo_id)
	{
		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_events_db();

		$q = $db->where('promotion_id', $promo_id);
		$q = $db->where('client_id', $client_id);
		$q = $db->get('scratch_promotion_vouchers');

		if($q->result()){

			$o['success'] = false;
			$o['msg'] = 'You have already entered the promotion';


		}else{

			//GET ROW
			//$row = $q->row();

			//INSERT VOUCHERS
			$voucher = $client_id.'-'.$promo_id.'-'.rand(999,9999);
			$in = array(
				'event_id' => 0,
				'client_id' => $client_id,
				'promotion_id' => $promo_id,
				'voucher' => $voucher,
				'claimed' => 'N',
				'type' => 'touch_n_win'
			);
			$db->insert('scratch_promotion_vouchers', $in);
			$vid = $db->insert_id();
			$o['success'] = true;
			$o['msg'] = 'Voucher has been created';

		}
		return $o;
	}

	//+++++++++++++++++++++++++++
	//FORGOT PASSWORD
	//++++++++++++++++++++++++++
	function forgot_password($email)
	{
		error_reporting(E_ALL);
		$u = $this->db->where('CLIENT_EMAIL', $email);
		$u = $this->db->get('u_client');

		if($u->result()){
			$this->load->model('members_model');
			$row = $u->row();
			$temp = substr($row->CLIENT_EMAIL,0, 4).rand(999,9999).strtoupper('m');
			$pass = $this->members_model->hash_password($row->CLIENT_EMAIL, $temp);
			//sms
			if($row->VERIFIED == 'Y'){


				$txt = 'Here is your temporary My.na password: '.$temp;
				$to = $row->CLIENT_CELLPHONE;


				//LOAD LIBRARIES FOR API AND SEND SMS
				$this->load->library('curl');
				$this->load->library('rest', array(
					'server'    => 'https://sms.my.na/api/sms/',
					'http_user' => 'myna_ma$ster',
					'http_pass' => '#$5_jh56_hdgd',
					'http_auth' => 'basic' // or 'digest'
				));

				$user = $this->rest->get('send', array('number' => $to, 'msg' => $txt), 'json');
				//print_r($user);
				$o['success'] = true;
				$o['msg'] = 'Please look in your SMS messages for your new password';
				$o['title'] = 'Please look in your SMS messages for your new password';
				$o['content'] = '';

				//email
			}else{

				//SEND EMAIL
				$rowarray = $u->row_array();

				$this->members_model->new_password_email($rowarray);
				$o['success'] = true;
				$o['msg'] = 'Please look in your email inbox for a link';
				$o['title'] = 'Please look in your email inbox for a link';
				$o['content'] = '';
			}


			//UPDATE NEW PASSWORD
			$in['CLIENT_PASSWORD'] = $pass;
			$this->db->where('ID', $row->ID);
			$this->db->update('u_client', $in);

		}else{

			$o['success'] = false;
			$o['msg'] = 'Email not found please register';
			$o['title'] = 'Email not found please register';
			$o['content'] = '';

		}

		return $o;

	}

	//+++++++++++++++++++++++++++
	//SEARCH NMH/My.na
	//++++++++++++++++++++++++++
	function search($q, $type = '',$limit, $offset)
	{
    	$out = array();

		$key = $this->db->escape_like_str(urldecode($q));

		if($type == 'prefetch'){

			$o = $this->search_nmh($key);
		}else{

			$o = $this->search_my_na($key,$limit, $offset);

		}
		return $o;
	}
	//+++++++++++++++++++++++++++
	//SEARCH on My.na DB
	//++++++++++++++++++++++++++
	function search_my_na($key,$limit, $offset)
	{

		//INSERT TERM FOR CAPTURE
		if(strlen($key) > 15){

			if(str_word_count($key) > 1) {
				$idata = array(

					'client_id' => $this->session->userdata('id'),
					'search_term' => $key,
					'tokens' => '',
					'location' => $this->session->userdata('country')

				);
				//$this->db->insert('search_terms', $idata);
			}
		}
		$strSQL = "";
		$out = array();$o = array();
		//MORE THAN 1 WORD
		if(str_word_count($key) > 1){

			$keys = str_replace(" ", "+", trim($key));
			$keyA = explode("+", $keys);
			$keyF = '';
			foreach($keyA as $r){
				if(strlen($r) >= 3){
					$keyF .= '+'.$r.' ';
				}
			}

			$tq1 = "SELECT title ,link, type,type_id, img_file ,body,
													MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance,
													MATCH(title) AGAINST ('".$keyF."' IN BOOLEAN MODE) AS relevance2
													FROM search_index
                                                    WHERE MATCH(title, body) AGAINST ('".$keyF."' IN BOOLEAN MODE)
													ORDER BY relevance2 DESC, relevance DESC LIMIT ".$limit." OFFSET ".$offset;
			//echo $tq1;
			$query = $this->db->query($tq1, TRUE);
			$go = true;


			//BIGGER THAN 2 CHARS
		}elseif(str_word_count($key) == 1 && strlen($key) > 3){

			$tq1 = "SELECT title ,link, type,type_id, img_file ,body FROM search_index WHERE ".$strSQL." (body LIKE '%".$key."%' OR title LIKE '%".$key."%') ORDER BY title ASC LIMIT ".$limit." OFFSET ".$offset;
			$query = $this->db->query($tq1, TRUE);
			$go = true;
			//BIGGER THAN 2 CHARS
		}elseif(strlen($key) > 2){

			$tq1 = "SELECT title ,link, type,type_id, img_file ,body FROM search_index WHERE ".$strSQL." (body LIKE '%".$key."%' OR title LIKE '%".$key."%') ORDER BY title ASC LIMIT ".$limit." OFFSET ".$offset;
			$query = $this->db->query($tq1, TRUE);
			$go = true;
		}else{


			$out['success'] = false;
			$out['msg'] = 'No results found';
			$out['results'] = $o;
			$tq1 = '';
			$query = false;
			$go = false;

		}


		$x = 1;
		if($go) {
			if ($query->result()) {

				foreach ($query->result() as $row) {

					$name = $row->title;
					$body = $this->my_na_model->shorten_string(strip_tags(str_replace($name, " ", $row->body)), 20);
					$array = explode(" ", $name . " " . $body);
					$temp = implode('","', $array);
					//$link1 = "<a href='".site_url('/').$row->link.'">';
					$t = array(

						"order" => $x,
						"id" => $row->type_id,
						"image" => base_url('/') . 'img/timbthumb.php?src=' . base_url('/') . $row->img_file . '&w=20&h=20',
						"type" => $row->type,
						"body" => $body,
						"link1" => "javascript:go_url('" . site_url('/') . $row->link . "')",
						"value" => $name,
						"tokens" => $array

					);
					array_push($o, $t);

					$x++;
				}
				$out['success'] = true;
				$out['results'] = $o;


			}else{

				$out['success'] = false;
				$out['msg'] = 'No results found';
				$out['results'] = $o;

			}
		}

		return $out;

	}
	//+++++++++++++++++++++++++++
	//SEARCH on NMH DB
	//++++++++++++++++++++++++++
	function search_nmh($str)
	{
		$limit = 20;
		$offset = 0;
		//BREAK SEARCH TERM IF MORE THAN A WORD
		if(str_word_count($str) > 1){
			$sql = '';
			$a = explode(' ',$str);
			foreach($a as $key){

				//fallback for key must be 2 or bigger
				if(strlen($key) > 2){
					$sql .= " AND (posts.title LIKE '%".$key."%' OR posts.body LIKE '%".$key."%' OR categories.cat_name LIKE '%".$key."%' OR categories.cat_name_afrikaans LIKE '%".$key."%' )";

				}


			}


		}else{
			$sql = " AND (posts.title LIKE '%".$str."%' OR posts.body LIKE '%".$str."%' OR categories.cat_name LIKE '%".$str."%' OR categories.cat_name_afrikaans LIKE '%".$str."%' )";

		}

		$this->load->model('nmh_model');
		$db = $this->nmh_model->connect_nmh_db();
		//PAGES
		//$pages = $this->db->query("SELECT * FROM pages WHERE bus_id = '".BUS_ID."' AND  body LIKE '%".$str."%'", FALSE);
		$pages = $db->query("SELECT posts.*,images.img_file as image, group_concat(categories.cat_name_afrikaans) as categoriesall, categories.cat_name_afrikaans as categories,
										categories.slug_afrikaans, categories.cat_id ,COUNT(my_na_na_int.type_id) as total_na FROM posts
										JOIN publication_content_int ON publication_content_int.type_id = posts.post_id AND publication_content_int.type = 'post'
										JOIN images ON images.type_id = posts.post_id and images.type = 'post'
										LEFT JOIN my_na_na_int ON my_na_na_int.type_id = posts.post_id AND my_na_na_int.type = 'post'
										JOIN post_cat_int ON post_cat_int.post_id = posts.post_id
										JOIN categories ON categories.cat_id = post_cat_int.cat_id
										WHERE posts.status = 'live' ".$sql."
										GROUP BY posts.post_id
                                        ORDER BY posts.datetime DESC LIMIT ".$limit." OFFSET ".$offset, FALSE);

		//echo $this->db->last_query();

		$out = array();$o = array();
		$val = FALSE;
		if($pages->result()){
			$x = 1;
			$val = TRUE;
			foreach($pages->result() as $row){


				$img = CDN_URL . 'my_images/set/310/175/90/?src=assets/images/' . $row->image;
				$sizestr = 'col-md-12 col-lg-12 col-sm-12';
				$cat = '';
				$cat_c = '';
				$catAll = '';
				$cat_cAll = '';

				if ($row->categories != '')
				{

					$cat =  $row->cat_id;
					$cat_name =  $row->categories;
				}

				$name = $row->title;
				$body = $this->my_na_model->shorten_string(strip_tags(str_replace($name, " ", $row->body)), 7);
				$array = explode(" ", $name . " " . $body);
				$temp = implode('","', $array);
				//$link1 = "<a href='".site_url('/').$row->link.'">';
				$t = array(

					"order" => $x,
					"image" => $img,
					"type" => "post",
					"type_id" => $cat,
					"cat_id" => $cat,
					"cat_name" => $cat_name,
					"body" => $body,
					"link1" => "",
					"value" => $name,
					"tokens" => $array

				);
				array_push($o, $t);


			}
			$out['success'] = true;
			$out['results'] = $o;
		}


		if($val == FALSE){


			$out['success'] = false;
			$out['msg'] = 'No results found';
			$out['results'] = $o;

		}

		return $out;


	}

	//+++++++++++++++++++++++++++
	//REGISTER FUNCTIONS
	//++++++++++++++++++++++++++
	function register($email, $fname, $sname, $dial_code,$cell,$pass)
	{
		$result['msg'] = '';
		$result['success'] = false;
		//$dob = strtotime($new_date_format);
		$this->load->model('members_model');
		//VALIDATE INPUT
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$val = FALSE;
			$error = 'Email address is not valid.';

		} elseif (($fname == '')) {
			$val = FALSE;
			$error = 'Please provide us with your full name.';

		} else {
			$val = TRUE;
		}


		if ($val == TRUE) {

			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
			//$IP = $this->input->ip_address();
			$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
			$insertdata = array(
				'CLIENT_NAME' => $fname,
				'CLIENT_SURNAME' => $sname,
				'CLIENT_EMAIL' => $email,
				'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass),
				'CLIENT_UA' => $agent,
				'CLIENT_IP' => $IP,
				'CLIENT_CELLPHONE' => $cell,
				'DIAL_CODE' => $dial_code,
				'IS_ACTIVE' => 'N'/*,
				'CLIENT_COUNTRY' => $country,
				'CLIENT_CITY' => $city,
				'CLIENT_SUBURB' => $suburb*/
			);

			$this->db->where('CLIENT_EMAIL', $email);
			$this->db->from('u_client');
			$query = $this->db->get();


			//IF email already exists
			if ($query->num_rows() > 0) {

				$result['msg'] = 'A member with the email address ' . $email . ' already exists!';

				$result['success'] = false;

				//$this->response($result, 200);

			} else {

				$this->db->insert('u_client', $insertdata);
				//get ID

				$member_id = $this->db->insert_id();

				//BUILD ARRAY 4 email

				$data['fname'] = $fname;
				$data['img'] = '0';
				$data['member_id'] = $member_id;
				$data['email'] = $email;
				$data['sname'] = $sname;

				$data['base'] = base_url('/');
				$data['confirm_link'] = site_url('/') . 'members/activate/' . $member_id;
				//SEND EMAIL LINK
				$this->load->model('email_model');

				$data['fname'] = $fname;
				$data['img'] = '0';
				$data['member_id'] = $member_id;
				$data['email'] = $email;
				$data['sname'] = $sname;
				/*              $data['cell'] = $cell;
								$data['pass1'] = $pass1;
								$data['dob'] = $dob;*/
				$data['agent'] = $agent;
				$data['IP'] = $IP;
				$data['base'] = base_url('/');
				$data['confirm_link'] = site_url('/') . 'members/activate/'.$member_id;
				//SEND EMAIL LINK
				$this->load->model('email_model');
				$this->email_model->send_register_link($data);
				/*//BUILD BODY
				$body = 'Hi ' . $fname . ',<br /><br />
									<p>You have successfully created your My.Na account and are now an official ambassador of Namibia.</p>
										<p>To verify your email address and activate your account please click on the link below or copy and paste it into the address bar of your browser.</p>
										<p></p>
										<p>' . $data['confirm_link'] . '</p>
										<p>If you have any questions please email us at info@my.na.</p>
										<p>Have a !na day</p>
										<br /><br />
										My Namibia';

				$data_view['body'] = $body;
				$body_final = $this->load->view('email/body_news', $data_view, true);
				$subject = 'Your Account Verification Link';
				$fromEMAIL = 'no-reply@my.na';
				$fromNAME = 'My Namibia';
				$TAG = array('tags' => 'member_registration');
				$emailTO = array(array('email' => $email));

				//SEND EMAIL LINK
				$this->load->model('email_model');
				$this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);*/

				//success redirect
				$result['msg'] = 'Thank you ' . $fname . '';

				$result['success'] = true;
				$result['client_id'] = $member_id;
				$result['email'] = $email;


			}

		} else {

			$result['msg'] = $error;
			$result['success'] = false;



		}

		return $result;

	}

	//+++++++++++++++++++++++++++
	//UPDATE FUNCTIONS
	//++++++++++++++++++++++++++
	function update_client($client_id,$email, $fname)
	{
		$o['msg'] = '';
		$o['success'] = false;
		//$dob = strtotime($new_date_format);
		error_reporting(E_ALL);
		//VALIDATE INPUT
		if (($fname == '')) {
			$val = FALSE;
			$error = 'Please provide us with your full name.';

		} else {
			$val = TRUE;
		}


		if ($val == TRUE)
		{

			$this->load->model('members_model');
			$this->load->library('user_agent');
			$agent = $agent = $this->agent->browser() . ' ver : ' . $this->agent->version();
			//$IP = $this->input->ip_address();
			$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];

			/*$sess['id'] = $client_id;
			$sess['email'] = $email;
			$sess['city_id'] = '';
			$sess['city'] = '';
			$sess['country_id'] = '';
			$sess['country'] = '';
			$sess['suburb_id'] = '';
			$sess['suburb'] = '';
			$sess['medical_aid_name'] = '';
			$sess['medical_aid_type'] = '';
			$sess['medical_aid_number'] = '';
			$sess['emergency_contact_name'] = '';
			$sess['emergency_contact_mobile'] = '';
			$sess['emergency_contact_email'] = '';*/
			$insertdata = array(
				'CLIENT_NAME'      => $fname,
				'CLIENT_UA'        => $agent,
				'CLIENT_IP'        => $IP

			);
			$pass_new = false;
			if($pass = $this->input->post('password'))
			{
				$pass_new = true;
			}
			//NEW PASSWORD
			if ($pass_new)
			{
				$insertdata['CLIENT_PASSWORD'] = $this->members_model->hash_password($email, $pass);

			}

			if($sname = $this->input->post('lastname'))
			{
				$insertdata['CLIENT_SURNAME'] = $sname;
			}
			if($gender = $this->input->post('gender'))
			{
				if($gender == 'female'){
					$gender = 'F';
				}else{
					$gender = 'M';
				}
				$insertdata['CLIENT_GENDER'] = $gender;
			}

			if($dob = $this->input->post('born_at'))
			{
				$insertdata['CLIENT_DATE_OF_BIRTH'] = $dob;

			}
			if($cell = $this->input->post('cellphone'))
			{
				$insertdata['CLIENT_CELLPHONE'] = $cell;

			}
			if($dial_code = $this->input->post('dial_code'))
			{
				$insertdata['DIAL_CODE'] = $dial_code;
			}

			if($occupation = $this->input->post('occupation'))
			{
				$insertdata['CLIENT_OCCUPATION'] = $occupation;
			}
			if($location['city_id'] = $this->input->post('city_id'))
			{
				$insertdata['CLIENT_CITY'] = $location['city_id'];
				$sess['city_id'] = $location['city_id'];

			}
			if($location['city'] = $this->input->post('city'))
			{
				//$insertdata['CLIENT_CITY'] = $sname;
				$sess['city'] = $location['city'];

			}
			if($location['country_id'] = $this->input->post('country_id'))
			{
				$insertdata['CLIENT_COUNTRY'] = $location['country_id'];
				$sess['country_id'] = $location['country_id'];

			}
			if($location['country'] = $this->input->post('country'))
			{
				//$insertdata['CLIENT_COUNTRY'] = $sname;
				$sess['country'] = $location['country'];

			}
			if($location['suburb_id'] = $this->input->post('suburb_id'))
			{
				$insertdata['CLIENT_SUBURB'] = $location['suburb_id'];

				$sess['suburb_id'] = $location['suburb_id'];
			}
			if($location['suburb'] = $this->input->post('suburb'))
			{
				//$insertdata['CLIENT_SUBURB'] = $sname;
				$sess['suburb'] = $location['suburb'];

			}
			if(!$med['medical_aid_name'] = $this->input->post('medical_aid_name'))
			{
				$med['medical_aid_name'] = '';
			}
			if(!$med['medical_aid_number'] = $this->input->post('medical_aid_number'))
			{
				$med['medical_aid_number']= '';
			}
			if(!$med['medical_aid_type'] = $this->input->post('medical_aid_type'))
			{
				$med['medical_aid_type'] = '';
			}
			if(!$contact['contact_name'] = $this->input->post('emergency_contact_name'))
			{
				$contact['contact_name'] = '';
			}
			if(!$contact['contact_email'] = $this->input->post('emergency_contact_email'))
			{
				$contact['contact_email'] = '';
			}
			if(!$contact['contact_mobile'] = $this->input->post('emergency_contact_mobile'))
			{
				$contact['contact_mobile'] = '';
			}


			$this->db->where('ID', $client_id);
			if($this->db->update('u_client', $insertdata)){


				//MEDICAL
				if($med['medical_aid_number'] != ''){
					$mexist = $this->db->where('client_id', $client_id);
					$mexist = $this->db->get('u_client_medical');

					if($mexist->result()){
						$m = $this->db->where('client_id', $client_id);
						$m = $this->db->update('u_client_medical', $med);

					}else{

						$med['client_id'] = $client_id;
						$c = $this->db->insert('u_client_medical', $med);

					}


				}

				//Emergency Contact
				if($contact['contact_name'] != ''){

					$cexist = $this->db->where('client_id', $client_id);
					$cexist = $this->db->get('u_client_contacts');
					if($cexist->result()){
						$c = $this->db->where('client_id', $client_id);
						$c = $this->db->update('u_client_contacts', $contact);

					}else{

						$contact['client_id'] = $client_id;
						$c = $this->db->insert('u_client_contacts', $contact);

					}


				}


				//BUILD SESSION DATA


				//GET CLIENT FULL DETAILS AND CONTACT
				$user = $this->db->query("SELECT u_client.*, u_client_medical.medical_aid_type,
											u_client_medical.medical_aid_name,u_client_medical.medical_aid_number, 
											a_map_location.MAP_LOCATION,a_map_suburb.SUBURB_NAME,a_country.COUNTRY_NAME,
											u_client_contacts.contact_id,u_client_contacts.contact_name,u_client_contacts.contact_mobile,u_client_contacts.contact_email
											FROM u_client
											LEFT JOIN u_client_medical ON u_client_medical.client_id = u_client.ID
											LEFT JOIN a_country ON a_country.ID = u_client.CLIENT_COUNTRY
											LEFT JOIN a_map_location ON a_map_location.ID = u_client.CLIENT_CITY
											LEFT JOIN a_map_suburb ON a_map_suburb.ID = u_client.CLIENT_SUBURB
											LEFT JOIN u_client_contacts ON u_client_contacts.client_id = u_client.ID
											WHERE u_client.ID = '".$client_id."'
											");



				if($user->result()){

					$urow = $user->row_array();

					//$contacts = explode(',', $urow->contacts);
					$sess['id'] = $client_id;
					$sess['email'] = $urow['CLIENT_EMAIL'];
					$sess['u_name'] = $urow['CLIENT_NAME']. ' ' .$urow['CLIENT_SURNAME'];
					$sess['fb_id'] =  $urow['FB_ID'];
					$sess['img_file'] = $urow['CLIENT_PROFILE_PICTURE_NAME'];
					$sess['points'] = $this->my_na_model->count_points($urow['ID']);
					$sess['login'] = 'no';
					$sess['first_login'] = 'N';
					$sess['name'] = $urow['CLIENT_NAME'];
					$sess['surname'] = $urow['CLIENT_SURNAME'];
					$sess['dob'] = $urow['CLIENT_DATE_OF_BIRTH'];
					$sess['gender'] = $urow['CLIENT_GENDER'];
					$sess['city_id'] = $urow['CLIENT_CITY'];
					$sess['city'] = $urow['MAP_LOCATION'];
					$sess['country_id'] = $urow['CLIENT_COUNTRY'];
					$sess['country'] = $urow['COUNTRY_NAME'];
					$sess['suburb_id'] = $urow['CLIENT_SUBURB'];
					$sess['suburb'] = $urow['SUBURB_NAME'];
					$sess['occupation'] = $urow['CLIENT_OCCUPATION'];
					$sess['mobile'] = $urow['CLIENT_CELLPHONE'];
					$sess['dial_code'] = $urow['DIAL_CODE'];
					$sess['medical_aid_name'] = $urow['medical_aid_name'];
					$sess['medical_aid_type'] = $urow['medical_aid_type'];
					$sess['medical_aid_number'] = $urow['medical_aid_number'];
					$sess['emergency_contact_name'] = $urow['contact_name'];
					$sess['emergency_contact_mobile'] = $urow['contact_mobile'];
					$sess['emergency_contact_email'] = $urow['contact_email'];

				}


				//$contacts = explode(',', $urow->contacts);
				/*$sess['name'] = $fname;
				$sess['surname'] = $sname;
				$sess['dob'] = $dob;
				$sess['gender'] = $gender;

				$sess['occupation'] = $occupation;
				$sess['mobile'] = $cell;
				$sess['dial_code'] = $dial_code;
				$sess['medical_aid_name'] = $med['medical_aid_name'];
				$sess['medical_aid_type'] = $med['medical_aid_type'];
				$sess['medical_aid_number'] = $med['medical_aid_number'];
				$sess['emergency_contact_name'] = $contact['contact_name'];
				$sess['emergency_contact_mobile'] = $contact['contact_mobile'];
				$sess['emergency_contact_email'] = $contact['contact_email'];*/

				$o['user'] = $sess;

				$o['success'] = true;
				$o['msg'] = 'Updated successful';
				$o['error'] = false;

			}else{

				$o['success'] = true;
				$o['msg'] = 'Something went wrong.';
				$o['error'] = '';
			}





		}
		return $o;

	}

	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login($uname, $pass)
	{

		$o['success'] = false;
		$o['error'] = true;

		$this->load->model('members_model');

		$o['success'] = false;
		$o['error'] = true;
		//MATCH CREDENTIALS
		$row = $this->members_model->validate_password($uname,$pass);
		if($row['bool'] === 'YES'){

			//HASH PASSWORD AGAIN
			$pass_new = $this->members_model->hash_password($uname,$pass);
			//create user array
			$data = array(
				'CLIENT_UA' => $this->agent->browser() . ' ver ' . $this->agent->version(),
				'CLIENT_IP' => $this->input->ip_address(),
				'LAST_LOGIN' => date("Y-m-d H:i:s"),
				'CLIENT_PASSWORD' => $pass_new
			);


			$sess = array(

				'id' => $row['ID'],
				'email' => $row['CLIENT_EMAIL'],
				'u_name' => $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'],
				'name' =>$row['CLIENT_NAME'],
				'surname' => $row['CLIENT_SURNAME'],
				'dob' => $row['CLIENT_DATE_OF_BIRTH'],
				'gender' => $row['CLIENT_GENDER'],
				'country' => $row['CLIENT_COUNTRY'],
				'city' => $row['CLIENT_CITY'],
				'occupation' => $row['CLIENT_OCCUPATION'],
				'mobile' => $row['CLIENT_CELLPHONE'],
				'fb_id' => $row['FB_ID'],
				'img_file' => $row['CLIENT_PROFILE_PICTURE_NAME'],
				'points' => $this->my_na_model->count_points($row['ID']),
				'login' => 'yes',
				'first_login' => 'N'

			);

			//GET CLIENT FULL DETAILS AND CONTACT
			$user = $this->db->query("SELECT u_client.CLIENT_NAME,u_client_medical.medical_aid_type,u_client_medical.medical_aid_name,u_client_medical.medical_aid_number, u_client.CLIENT_SURNAME, u_client.CLIENT_CELLPHONE,u_client.DIAL_CODE, u_client.CLIENT_CITY,u_client.CLIENT_COUNTRY,
										u_client.CLIENT_SUBURB,a_country.COUNTRY_NAME, a_map_location.MAP_LOCATION,a_map_suburb.SUBURB_NAME,u_client.CLIENT_DATE_OF_BIRTH,u_client.CLIENT_OCCUPATION,
										u_client.DIAL_CODE,u_client.CLIENT_GENDER,u_client.CLIENT_OCCUPATION,
										u_client_contacts.contact_id,u_client_contacts.contact_name,u_client_contacts.contact_mobile,u_client_contacts.contact_email
			                            FROM u_client
			                            LEFT JOIN u_client_medical ON u_client_medical.client_id = u_client.ID
			                            LEFT JOIN a_country ON a_country.ID = u_client.CLIENT_COUNTRY
			                            LEFT JOIN a_map_location ON a_map_location.ID = u_client.CLIENT_CITY
			                            LEFT JOIN a_map_suburb ON a_map_suburb.ID = u_client.CLIENT_SUBURB
										LEFT JOIN u_client_contacts ON u_client_contacts.client_id = u_client.ID
										WHERE u_client.ID = '".$row['ID']."'
			                            ");



			if($user->result()){

				$urow = $user->row_array();

				//$contacts = explode(',', $urow->contacts);
				$sess['name'] = $urow['CLIENT_NAME'];
				$sess['surname'] = $urow['CLIENT_SURNAME'];
				$sess['dob'] = $urow['CLIENT_DATE_OF_BIRTH'];
				$sess['gender'] = $urow['CLIENT_GENDER'];
				$sess['city_id'] = $urow['CLIENT_CITY'];
				$sess['city'] = $urow['MAP_LOCATION'];
				$sess['country_id'] = $urow['CLIENT_COUNTRY'];
				$sess['country'] = $urow['COUNTRY_NAME'];
				$sess['suburb_id'] = $urow['CLIENT_SUBURB'];
				$sess['suburb'] = $urow['SUBURB_NAME'];
				$sess['occupation'] = $urow['CLIENT_OCCUPATION'];
				$sess['mobile'] = $urow['CLIENT_CELLPHONE'];
				$sess['dial_code'] = $urow['DIAL_CODE'];
				$sess['medical_aid_name'] = $urow['medical_aid_name'];
				$sess['medical_aid_type'] = $urow['medical_aid_type'];
				$sess['medical_aid_number'] = $urow['medical_aid_number'];
				$sess['emergency_contact_name'] = $urow['contact_name'];
				$sess['emergency_contact_mobile'] = $urow['contact_mobile'];
				$sess['emergency_contact_email'] = $urow['contact_email'];

			}

			//IF LAST LOGIN = NULL
			//FIRST TIME LOG IN
			if($row['LAST_LOGIN'] == ''){

				$sess['first_login'] = 'Y';
			}

			$this->db->where('ID', $row['ID']);
			$this->db->update('u_client', $data);

			$o['success'] = true;
			$o['msg'] = 'You have been verified.';
			$o['user'] = $sess;
			$o['error'] = false;

		}elseif($row['bool'] === 'NO'){

			$o['msg'] = 'Your password did not match our records!';
			$o['success'] = false;
			$o['error'] = true;
			//NO MATCHING CREDENTIALS
		}else{

			$o['msg'] = 'No account found! Please create a new user account';
			$o['success'] = false;
			$o['error'] = true;
		}
		return $o;

	}


	//+++++++++++++++++++++++++++
	//SINGLE PRODUCT
	//++++++++++++++++++++++++++
	function product($id)
	{
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('api_product'.$id))
		{
			$query = $this->db->query("SELECT products.*, product_extras.extras, product_images.img_file,main_cat.category_name as maincat,sub_cat.category_name as subcat,
														sub_sub_cat.category_name as subsubcat,sub_sub_sub_cat.category_name as subsubsubcat,
														 MAX(product_auction_bids.bid_id) as max_bid, MAX(product_auction_bids.amount) as amount, product_extras.featured,
														 product_extras.property_agent,u_client.DIAL_CODE as dial_code,u_client.CLIENT_CELLPHONE as mobile, u_client.CLIENT_EMAIL as email,
														 group_concat(product_images.img_file) as images
														 FROM products
														 LEFT JOIN u_client on u_client.ID = products.client_id
														LEFT JOIN product_categories main_cat on main_cat.cat_id = products.main_cat_id AND main_cat.main_cat_id = 0
														LEFT JOIN product_categories sub_cat on sub_cat.cat_id = products.sub_cat_id AND sub_cat.sub_cat_id = 0
														LEFT JOIN product_categories sub_sub_cat on sub_sub_cat.cat_id = products.sub_sub_cat_id AND sub_sub_cat.sub_sub_cat_id = 0
														LEFT JOIN product_categories sub_sub_sub_cat on sub_sub_sub_cat.cat_id = products.sub_sub_sub_cat_id AND sub_sub_sub_cat.sub_sub_sub_cat_id = 0
														LEFT JOIN product_extras on products.product_id = product_extras.product_id
														LEFT JOIN product_images on products.product_id = product_images.product_id
														LEFT JOIN product_auction_bids ON products.product_id = product_auction_bids.product_id AND product_auction_bids.type = 'bid'
														WHERE products.product_id = '".$id."'
														GROUP BY products.product_id
														LIMIT 1", TRUE);

			 if($query->result()){

					$row = $query->row_array();
					$o['product'] = $row;
					$o['msg'] = '';
					$o['success'] = true;
					$o['error'] = false;

			 }else{
					$o['msg'] = 'No product found!';
					$o['success'] = false;
					$o['error'] = true;

			 }


			$this->cache->save('api_product'.$id,$o, 600);
		}
		return $o;

	}

	//+++++++++++++++++++++++++++
	//PRODUCT CATEGORIES
	//++++++++++++++++++++++++++
	function product_category($main_id, $sub_id, $sub_sub_id,$sub_sub_sub_id , $limit , $offset )
	{
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('api_product_category'.$main_id.'_'.$sub_id.'_'.$sub_sub_id.'_'.$sub_sub_sub_id.'_'.$limit.'_'.$offset))
		{
			$csql = " WHERE products.is_active = 'Y' AND products.end_date > CURDATE() AND products.main_cat_id = ".$main_id." ";
			if($sub_id != 0){
				$csql .= " AND products.sub_cat_id = ".$sub_id." ";
			}
			if($sub_sub_id != 0){
				$csql .= " AND products.sub_sub_cat_id = ".$sub_sub_id." ";
			}
			if($sub_sub_sub_id != 0){
				$csql .= " AND products.sub_sub_sub_cat_id = ".$sub_sub_sub_id." ";
			}
			$osql = " LIMIT ".$limit." OFFSET ".$offset;

			$query = $this->db->query("SELECT products.*, product_extras.extras, product_images.img_file,main_cat.category_name as maincat,sub_cat.category_name as subcat,
										sub_sub_cat.category_name as subsubcat,sub_sub_sub_cat.category_name as subsubsubcat,
										 MAX(product_auction_bids.bid_id) as max_bid, MAX(product_auction_bids.amount) as amount, product_extras.featured,
										 product_extras.property_agent, u_client.DIAL_CODE as dial_code,u_client.CLIENT_CELLPHONE as mobile, u_client.CLIENT_EMAIL as email,
										 group_concat(product_images.img_file) as images
										 FROM products
										 LEFT JOIN u_client on u_client.ID = products.client_id
										LEFT JOIN product_categories main_cat on main_cat.cat_id = products.main_cat_id AND main_cat.main_cat_id = 0
										LEFT JOIN product_categories sub_cat on sub_cat.cat_id = products.sub_cat_id AND sub_cat.sub_cat_id = 0
										LEFT JOIN product_categories sub_sub_cat on sub_sub_cat.cat_id = products.sub_sub_cat_id AND sub_sub_cat.sub_sub_cat_id = 0
										LEFT JOIN product_categories sub_sub_sub_cat on sub_sub_sub_cat.cat_id = products.sub_sub_sub_cat_id AND sub_sub_sub_cat.sub_sub_sub_cat_id = 0
										LEFT JOIN product_extras on products.product_id = product_extras.product_id
										LEFT JOIN product_images on products.product_id = product_images.product_id
										LEFT JOIN product_auction_bids ON products.product_id = product_auction_bids.product_id AND product_auction_bids.type = 'bid'
										".$csql."
										GROUP BY products.product_id
										".$osql."", TRUE);

			 if($query->result()){

					$row = $query->result_array();
					$o['product'] = $row;
					$o['msg'] = '';
					$o['success'] = true;
					$o['error'] = false;

			 }else{
					$o['msg'] = 'No product found!';
					$o['success'] = false;
					$o['error'] = true;

			 }


			$this->cache->save('api_product_category'.$main_id.'_'.$sub_id.'_'.$sub_sub_id.'_'.$sub_sub_sub_id.'_'.$limit.'_'.$offset,$o, 3600);
		}
		return $o;

	}

	//+++++++++++++++++++++++++++
	//SINGLE BUSINESS
	//++++++++++++++++++++++++++
	function business($id)
	{
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('api_business'.$id))
		{
			$query = $this->db->query("SELECT u_business.*,group_concat(a_tourism_category_sub.CATEGORY_NAME) as categories,group_concat(a_tourism_category.CATEGORY_NAME) as top_categories,
														u_business_map.BUSINESS_MAP_LATITUDE as latitude, u_business_map.BUSINESS_MAP_LONGITUDE as longitude,
														a_map_location.MAP_LOCATION as city,a_map_suburb.SUBURB_NAME as suburb
														FROM u_business 
														LEFT JOIN a_map_location ON a_map_location.ID = u_business.BUSINESS_MAP_CITY_ID
														LEFT JOIN a_map_suburb ON a_map_suburb.ID = u_business.BUSINESS_SUBURB_ID
														LEFT JOIN u_business_map ON u_business_map.BUSINESS_ID = u_business.ID
														LEFT JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
														LEFT JOIN a_tourism_category_sub ON a_tourism_category_sub.ID = i_tourism_category.CATEGORY_ID
														LEFT JOIN a_tourism_category ON a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
														WHERE u_business.ID = '".$id."'
														GROUP BY u_business.ID
														LIMIT 1", TRUE);

			 if($query->result()){

					$row = $query->row_array();
					$o['business'] = $row;
					$o['msg'] = '';
					$o['success'] = true;
					$o['error'] = false;

			 }else{
					$o['msg'] = 'No business found!';
					$o['success'] = false;
					$o['error'] = true;

			 }


			$this->cache->save('api_business'.$id,$o, 600);
		}
		return $o;

	}

	//+++++++++++++++++++++++++++
	//EMERGENCY TRIGGER
	//++++++++++++++++++++++++++
	function emergency()
	{
		if(! $this->input->get_post('type',true)){
			$o['emergency_id'] = null;
			$o['success'] = false;
			$o['msg'] = 'No User Type';
			return $o;

		}

		$data['type'] = $this->input->get_post('type',true);

		$data['user_id'] = $this->input->get_post('user_id',true);

		$data['latitude'] = $this->input->get_post('latitude',true);

		$data['longitude'] = $this->input->get_post('longitude',true);

		$data['accuracy'] = $this->input->get_post('accuracy',true);
		$data['altitude_accuracy'] = 0;//mysql_real_escape_string($_REQUEST['altitude_accuracy'], MySqlConnection::getConnection());
		$data['heading'] = 0; //mysql_real_escape_string($_REQUEST['heading'], MySqlConnection::getConnection());
		$data['speed'] = 0; //mysql_real_escape_string($_REQUEST['speed'], MySqlConnection::getConnection());
		$timestamp = null;//mysql_real_escape_string($_REQUEST['timestamp'], MySqlConnection::getConnection());

		$data['user_fullname'] = $this->input->get_post('user_fullname',true);

		$data['user_email'] = $this->input->get_post('user_email',true);

		$data['user_cellphone'] = $this->input->get_post('user_cellphone',true);

		$data['user_born_at'] = $this->input->get_post('user_born_at',true);

		$data['user_gender'] = $this->input->get_post('user_gender',true);

		$data['medical_aid_name'] = $this->input->get_post('medical_aid_name',true);

		$data['medical_aid_number'] = $this->input->get_post('medical_aid_number',true);

		$data['emergency_contact_name'] = $this->input->get_post('emergency_contact_name',true);

		$data['emergency_contact_mobile'] = $this->input->get_post('emergency_contact_mobile',true);

		$data['emergency_contact_email'] = $this->input->get_post('emergency_contact_email',true);

		$data['source'] = $this->input->get_post('source',true);

		$session = time() .'_'. $type .'_'. $data['user_id'];
		if(isset($_REQUEST['session'])) {
			//$session = mysql_real_escape_string($_REQUEST['session'], MySqlConnection::getConnection());
			$data['session'] = $this->input->get_post('session',true);
		}
		unset($data['created_at']);

		$tz = 'Africa/Windhoek';
		$timestamp = time();
		$dt = new DateTime("now", new DateTimeZone($tz)); //first argument "must" be a string
		$dt->setTimestamp($timestamp); //adjust the object to correct timestamp
		
		$data['created_at'] = $dt->format('Y-m-d H:i:s');
		$data['session'] = $dt->format('Y-m-d H:i:s');
		//$this->db->query("SET @@session.time_zone='Africa/Windhoek'");

		$session = sha1($session);

		$time = $_SERVER['REQUEST_TIME'];
		/**
		 * for a 30 minute timeout, specified in seconds
		 */
		$timeout_duration = 5;

		/**
		 * Here we look for the user’s LAST_ACTIVITY timestamp. If
		 * it’s set and indicates our $timeout_duration has passed, 
		 * blow away any previous $_SESSION data and start a new one.
		 */


	  	if($this->db->insert('emergencies', $data)){

			$o['emergency_id'] = $this->db->insert_id();
			$o['success'] = true;

		}else{
			$o['emergency_id'] = null;
			$o['success'] = false;
			$o['msg'] = 'Something Went Wrong';
		}    

		

		/*$sql = "INSERT INTO emergencies
		(emergency_type, user_id, session, latitude, longitude, accuracy, altitude_accuracy,
		 heading, speed, timestamp, user_fullname, user_email, user_cellphone, user_born_at,
		 user_gender, medical_aid_name, medical_aid_number, emergency_contact_name,
		 emergency_contact_mobile, emergency_contact_email, created_at, source) VALUES
		(\"$type\", \"$user_id\", \"$session\", \"$latitude\", \"$longitude\", \"$accuracy\", \"$altitude_accuracy\",
		\"$heading\",  \"$speed\", \"$timestamp\", \"$user_fullname\", \"$user_email\",
		\"$user_cellphone\", \"$user_born_at\", \"$user_gender\", \"$medical_aid_name\", \"$medical_aid_number\",
		\"$emergency_contact_name\", \"$emergency_contact_mobile\", \"$emergency_contact_email\",NOW(), \"$source\")";*/

		return $o;

	}




}
?>