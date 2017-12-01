<?php
class Classified_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function classified_model(){
  		//parent::CI_model();
		self::__construct();	
 	}

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+ADD NEW ITEM
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function add_classified($data){

        //DATA
		$insertdata = array(
			'client_id'          => $data['client_id'],
			'bus_id'             => $data['bus_id'],
			'is_active'          => 'N',
			'title'              => $data['title'],
			'content'            => $data['body'],
			'listing_date'       => date('Y-m-d'),
			'cl_cat_id'          => $data['cl_cat_id']
			/*'start_date'         => $data['start'],*/
		/*	'location'           => $data['location'],
			'suburb'             => $data['suburb'],
			'quantity'           => $data['quantity'],
			'main_cat_id'        => $data['cat1'],
			'sub_cat_id'         => $data['cat2'],
			'sub_sub_cat_id'     => $data['cat3'],
			'sub_sub_sub_cat_id' => $data['cat4']*/
		);
		//$insertdata['client_id'] = $data['client_id'];
		//$insertdata['total_quantity'] = $data['quantity'];
		$bus_id = $data['bus_id'];
		//EXPIRY DATES auction none; sale = 30 days 1 month
		/*if ($bus_id == '2666' || $bus_id == '8785' || $bus_id == '2706')
		{
			//YEARLY EXPIRY
			$insertdata['end_date'] = date('Y-m-d', strtotime("+360 days"));

		}
		elseif ($bus_id != 0)
		{

			$insertdata['end_date'] = date('Y-m-d', strtotime("+91 days"));
		}
		else
		{
			$insertdata['status'] = 'moderate';
			$insertdata['end_date'] = date('Y-m-d', strtotime("+31 days"));
		}*/



		//INSERT
		$this->db->insert('classifieds', $insertdata);
		if($o['classified_id'] = $this->db->insert_id()){

			$pubA = explode(',',$data['pub_bus_id']);
			foreach($pubA as $prow){

				if($prow == '2713'){
					$ed_id = 2;
					$pub_id = 1;

				}elseif($prow == '3454'){
					$ed_id = 1;
					$pub_id = 2;

				}elseif($prow == '4856'){

					$ed_id = 3;
					$pub_id = 3;
				}else{

					continue;
				}

				//PRODUXCT EXTRA DATA
				$extradata = array(
					'classified_id' => $o['classified_id'],
					'pub_id'     => $pub_id,
					'edition_id' => $ed_id,
					'bus_id' => $prow

				);
				$this->db->insert('classifieds_publication_int', $extradata);

			}


			$o['success'] = true;
			
			
		}else{
			
			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}

		return $o;

    }

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND PRODUCT LINK AFTER LISTING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function send_user_classifieds_link($product_id){


		//GET
		$q = $this->db->query("SELECT classifieds.*,u_client.*, classifieds_images.img_file  FROM classifieds
								JOIN u_client ON classifieds.client_id = u_client.ID
								LEFT JOIN classifieds_images on classifieds.classified_id = classifieds_images.classified_id
								WHERE classifieds.classified_id = ".$product_id."");
		if($q->result()){

			$row = $q->row();
			$image = '';

			if(strlen($row->img_file) > 1){

				$image = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/products/images/'.$row->img_file.'&w=580&h=300';
				$image = '<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
										 <tr>
											<td style="width:100%" class="white_box"><img src="'. $image.'" alt="download picture sto view"></td>
										 </tr>
						  </table><br />';


			}
			$emailTO =  array(array('email' => $row->CLIENT_EMAIL) , array('email' => 'info@my.na'));
			$emailFROM = 'no-reply@my.na';
			$name = 'My Namibia Trade';
			$subject = 'Your Classified - '.$this->trade_model->shorten_string($row->title, 4);
			$body = 'Hi '.$row->CLIENT_NAME.', <br /><br />
								Your classified listing '.$row->title.' on My Namibia &trade; is live. Please review it online, add further detail
								and upload some images. Items that have images sell better.
								<br /><br />
								<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">I am Online</h1>
								'.$image.'
								<br />
								<strong>'.$row->title.'</strong>
								<p>'.$row->content.'</p>
								<br />


								Have a !tna day!<br />
								My Namibia';
			$data_view['body'] = $body;
			$body_final = $this->load->view('email/body_news',$data_view,true);
			$TAGS = array('tags' => 'classified_listing_upgrade');
			$this->load->model('email_model');
			$this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);

			$o['title'] = $row->title;
			$o['body'] = $row->content;
			$o['word_count'] = str_word_count($row->content);
			$o['images'] = $row->img_file;
			$o['success'] = true;
			$o['msg'] = 'Email Sent!';

			$o['html'] = '<strong>'.$row->title.'</strong><br /><p>'.$row->content.'</p><ul><li><strong>Words:</strong> '.$o['word_count'] .'</li></ul><p><strong>Please proceed to counter for Payment</strong></p>';


		}else{

			$o['success'] = false;
			$o['msg'] = 'Something went wrong';
		}

		return $o;

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+BUILD CATEGORY SEARCH
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function build_typehead($bus_id, $type)
	{


		$str = array();
		$q = $this->input->get('q');
		$test = $this->db->query("SELECT * FROM classifieds_categories ORDER BY cat_name ASC", false);
		//WHERE product_categories.category_name LIKE '%".$q."'
		$x = 1;
		//$str .= '[';
		if ($test->result())
		{

			foreach ($test->result() as $row)
			{

				$strt = '';
				


				
				$cat1 = $row->cl_cat_id;
				$cat1name = $row->cat_name .' > '.$row->cat_name_german. ' > '. $row->cat_name_afrikaans;

				
				$name = $row->cat_name;
				$array = explode(" ", str_replace(' > ', ' ', $cat1name . ' ' . $name));
				$temp = implode('","', $array);
				$t = array(

					"link1"  => "javascript:load_ajax_classified_cat(" . $cat1 . ",'" . $cat1name . "','" . $bus_id . "','" . $type . "')",
					"value"  => $name,
					"body"   => $cat1name,
					"tokens" => $array

				);
				array_push($str, $t);

				$x++;
			}

		}
		echo json_encode($str);

		$this->output->set_content_type('application/json');
	}

	//+++++++++++++++++++++++
	//DELETE PRODUCT AND IMAGES
	//+++++++++++++++++++++++
	function delete_classified($id)
	{

		$this->db->where('classified_id' , $id);
		$product = $this->db->get('classifieds');
	
		//IF exists
		if($product->result()){
	
			$rowP = $product->row();
			$count = 0;
			//get images
			$this->db->where('classified_id' , $id);
			$query = $this->db->get('classifieds_images');
	
			//if images
			if($query->result()){
	
				foreach($query->result() as $row){
	
					$file_large = BASE_URL.'assets/products/images/'.$row->img_file;
					if(file_exists($file_large)) {
	
						if(unlink($file_large)){
	
	
	
						}
	
				   }
				  //delete image
				  $this->db->where('img_id' , $row->img_id);
				  $this->db->delete('product_images');
				  
					$this->load->model('s3_model');
					//Delete  S3
					if($this->s3_model->delete_s3('assets/products/images/' .$row->img_file)){
						$final['s3_delete_old'] = true;
					}

				  $count ++;
	
				}
			}
	
		
	
			//DELETE PRODUCT
			$this->db->where('classified_id' , $id);
	
			if($this->db->delete('classifieds')){
	
				if($this->input->is_ajax_request()){
					
					$o['msg'] = 'Classified deleted, along with '.$count.' images and extras.';
						
				}else{
					
					$o['msg'] = 'Classified deleted, along with '.$count.' images and extras.';
					
	
				}
				$o['success'] = true;
			}
	
	
		}else{
			$o['success'] = false;
			$o['msg'] = 'Classified doesnt exist!';
	
		}
		
		return $o;
	}
	
	//+++++++++++++++++++++++
	//DELETE PRODUCT IMAGES
	//+++++++++++++++++++++++
	function delete_classified_image($id)
	{

		$this->db->where('img_id' , $id);
		$product = $this->db->get('classifieds_images');
	
		//IF exists
		if($product->result()){
	
			$rowP = $product->row();
			$count = 0;
	
			foreach($product->result() as $row){

				$file_large = BASE_URL.'assets/products/images/'.$row->img_file;
				if(file_exists($file_large)) {

					if(unlink($file_large)){



					}

			   }
			  //delete image
			  $this->db->where('img_id' , $row->img_id);
			  $this->db->delete('classifieds_images');

			  $count ++;

			}
		
	
		}else{
			$o['success'] = false;
			$o['msg'] = 'Classifieds image doesnt exist!';
	
		}
		
		return $o;
	}
}
?>