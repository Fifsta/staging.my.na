<?php
class Fb_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function Fb_model(){
  		//parent::CI_model();
		self::__construct();
		//LOAD library
		//$this->load->library('image_lib');	
 	}
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//REGISTER FACEBOOK
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function register_fb(){
		
			
			$id = trim($this->input->post('id', TRUE));
			$email = trim($this->input->post('email', TRUE));
			$fname = $this->input->post('first_name', TRUE);
			$sname = $this->input->post('last_name', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$country = 151;
			$city = $this->input->post('location[name]', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('birthday', TRUE);
			$pic = 'https://graph.facebook.com/'.$id.'/picture/';
			//$dob = strtotime($new_date_format); 

			$this->load->library('user_agent');
			$agent = $this->agent->browser().' ver : '.$this->agent->version();
			$IP = $this->input->ip_address();
			if($gender == 'male'){
				$gender = 'M';	
			}else{
				
				$gender = 'F';	
			}
			$insertdata = array(
						  'CLIENT_NAME'=> $fname ,
						  'FB_ID'=> $id,
						  'CLIENT_SURNAME'=> $sname ,
						   'CLIENT_EMAIL'=> $email,
						  'CLIENT_GENDER'=> $gender,
						  'CLIENT_PROFILE_PICTURE_NAME'=> $pic,
						  'CLIENT_DATE_OF_BIRTH'=> $dob,
						  'CLIENT_UA' => $agent,
						  'CLIENT_IP' => $IP,
						  'IS_ACTIVE' => 'Y',
						  'FB_LOGOUT' => 'N'
			);

			$this->db->insert('u_client', $insertdata);
			//get ID
			$this->db->where('CLIENT_EMAIL' , $email);
			$this->db->from('u_client');
			$query = $this->db->get();
			$row = $query->row_array();
			$member_id = $row['ID'];	
			
			//BUILD ARRAY 4 email		
			$data['fname'] = $fname;
			$data['img'] = '0';
			$data['member_id'] = $member_id;
			$data['email'] = $email;
			$data['sname'] = $sname;
			$data['dob'] = $dob;
			$data['base'] = base_url('/');
			$data['confirm_link'] = site_url('/') . 'members/activate/'.$member_id;
			//SEND EMAIL LINK
			$this->load->model('email_model');	
			$this->email_model->send_register_link($data);
			
			
			//SET SESSION
			/*$this->session->set_userdata('id', $row['ID']);
			$this->session->set_userdata('u_name', $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'] );
			$this->session->set_userdata('fb_id', $row['FB_ID']);
			$this->session->set_userdata('img_file', $row['CLIENT_PROFILE_PICTURE_NAME']);
			$this->session->set_userdata('points', $this->my_na_model->count_points($row['ID']));
			$this->session->set_flashdata('login', 'yes');*/

            $dataS = array(

                'id'        => $row['ID'],
                'u_name'    => $row['CLIENT_NAME']. ' ' .$row['CLIENT_SURNAME'],
                'img_file'  => $row['CLIENT_PROFILE_PICTURE_NAME'],
                'fb_id'     => $row['FB_ID'],
                'points'    => $this->my_na_model->count_points($row['ID']),


            );
            $this->session->set_userdata($dataS);
            $this->session->set_flashdata('login', 'yes');
			//success redirect		
			$data['basicmsg'] = 'Thank you, ' . $fname .' you have successfully registered.';
			
			$redirect = $this->input->get('redirect');
			//redirect($redirect, 301);

			
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//UPDATE MY.NA ROW WITH FACEBOOK CREDENTIALS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function update_existing($client_id){
		
			$id = trim($this->input->post('id', TRUE));
			$email = trim($this->input->post('email', TRUE));
			$fname = $this->input->post('first_name', TRUE);
			$sname = $this->input->post('last_name', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$country = 151;
			$city = $this->input->post('location[name]', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$dob = $this->input->post('birthday', TRUE);
			$pic = 'https://graph.facebook.com/'.$id.'/picture/';

			$this->load->library('user_agent');
			$agent = $this->agent->browser().' ver : '.$this->agent->version();
			$IP = $this->input->ip_address();

			if($gender == 'male'){
				$gender = 'M';	
			}else{
				
				$gender = 'F';	
			}

			$insertdata = array(
						  'CLIENT_NAME'=> $fname ,
						  'CLIENT_SURNAME'=> $sname ,
						  'CLIENT_EMAIL'=> $email,
						  'LAST_LOGIN' => date("Y-m-d H:i:s"),
						  'CLIENT_GENDER'=> $gender,
						  'CLIENT_PROFILE_PICTURE_NAME'=> $pic,
						  'CLIENT_DATE_OF_BIRTH'=> $dob,
						  'CLIENT_UA' => $agent,
						  'CLIENT_IP' => $IP,
						  'IS_ACTIVE' => 'Y',
						  'FB_LOGOUT' => 'N',
						  'FB_ID'=> $id
			);
			
			$this->db->where('ID', $client_id);
			$this->db->update('u_client', $insertdata);


			//SET SESSION
			/*$this->session->set_userdata('id', $client_id);
			$this->session->set_userdata('u_name', $fname. ' ' .$sname );
			$this->session->set_userdata('img_file', $pic);
			$this->session->set_userdata('fb_id', $id);
			$this->session->set_userdata('points', $this->my_na_model->count_points($client_id));*/

            $dataS = array(

                'id'        => $client_id,
                'u_name'    => $fname. ' ' .$sname,
                'img_file'  => $pic,
                'fb_id'     => $id,
                'points'    => $this->my_na_model->count_points($client_id),


            );
            $this->session->set_userdata($dataS);
            $this->session->set_flashdata('login', 'yes');
			$redirect = $this->input->get('redirect');
			//redirect($redirect, 301);
			
			//echo $client_id. ' ' .$id;
		
		
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//TEST IF SESSION SET OTHERWISE ROLL FACEBOOK
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function load_fb(){
		
		
		
	}



    //+++++++++++++++++++++++++++
    //FACEBOOK POST PRODUCT TO PAGE
    //++++++++++++++++++++++++++
    function post_product_to_my_page($id)
    {
        error_reporting(E_ALL);
        $q = $this->db->where('type', 'page');
        $q = $this->db->get('facebook');
        if($q->result()){

            $row = $q->row();
            $token = $row->fb_token;
        }else{
            $token = 'CAAEFVH0guhsBAAHU6LXcmtz4sW0nTTZBMoNQJKWDbjhavPGyfJ9Amr2kfmluZBIwR2Q9WQfQuMiz6opZAuqhEDZArTKtZA2ou2YQPdrClaZB3HxgROf3XpjrhC815ou7PlLMhDuQhkLG3cXBGCLlf4xagGzBltLBgO2m6wSyP3oJmYGbSEO4lbd06vbSFWCxq1yml7HgIZCx4tLr2oVmkg0';
        }

        $config = array('token' => $token, 'redirect_url' => current_url('/'));
        $this->load->library('facebook_long', $config);
        $this->load->model('trade_model');
        $q = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,
                                        (SELECT img_file from product_images WHERE product_id = ".$id." ORDER BY sequence ASC LIMIT 1) as img_file,
                                        AVG(u_business_vote.RATING) as TOTAL,MAX(product_auction_bids.amount) as current_bid,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        WHERE products.product_id = '".$id."'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 1" ,FALSE);

        if($q->result()){

            $row = $q->row();

            $main_cat = $this->trade_model->get_category_name($row->main_cat_id);
            $sub_cat = $this->trade_model->get_category_name($row->sub_cat_id);
            $sub_sub_cat = $this->trade_model->get_category_name($row->sub_sub_cat_id);
            $sub_sub_sub_cat = $this->trade_model->get_category_name($row->sub_sub_sub_cat_id);
            $this->load->model('trade_model');
            $extras = strip_tags($this->trade_model->show_extras_short($row->extras));


            if($row->listing_type == 'A'){

                $price = $this->trade_model->get_current_bid($row->current_bid);

                if($price['str'] != 'No Bids'){
                    $priceF = 'Current BID '.$price['str'];

                }else{
                    $priceF = $price['str'];
                }


            }else{

                if($row->sub_cat_id == 3410){
                    $priceF = 'N$ '. $this->trade_model->smooth_price($row->sale_price).' pm';
                }else{
                    $priceF = 'N$ '. $this->trade_model->smooth_price($row->sale_price);
                }
                if($row->por == 'Y'){

                    $priceF = 'Price On Request';

                }

            }


            $var['title'] = strip_tags( $row->title);
            $var['message'] = strip_tags($sub_cat . ' '. $main_cat. ' ' .$row->description . ' ' .$extras . ' '.$priceF);
            $var['caption'] = strip_tags($row->title. ' '. $sub_sub_cat . ' '. $sub_sub_sub_cat. ' '.$priceF);
            $var['link'] = site_url('/').'product/'.$id.'/'.$this->trade_model->clean_url_str($row->title);
            if($row->img_file == '' ){
                $var['image'] = base_url('/').'img/product_blank.jpg';

            }else{

                $var['image'] = S3_URL.'assets/products/images/'.$row->img_file;
            }


            //var_dump($var);

            $page_post = $this->facebook_long->post_to_page($var);
            //echo $page_post['id'];

            //UPDATE DATABASE
            $data['fb_post_id'] = $page_post['id'];
            $this->db->where('product_id', $id);
            $this->db->update('products', $data);

            $l1 = str_replace("_", "/posts/", $page_post['id']);
            //echo 'https://www.facebook.com/'.$l1.'/';

            //NEW TOKEN
            /*$new = $this->facebook_long->get_new_token();
            //UPDATE DB
            $data['fb_token'] = $new;
            $this->db->where('fb_token', $token);
            $this->db->where('type', 'page');
            $this->db->update('facebook', $data);*/

        }

        return $page_post;
    }
    //+++++++++++++++++++++++++++
    //FACEBOOK POST PRODUCT TO PAGE
    //++++++++++++++++++++++++++
    function post_product_to_my_group($id)
    {
        error_reporting(E_ALL);
        $q = $this->db->where('type', 'group');
        $q = $this->db->get('facebook');
        if($q->result()){

            $row = $q->row();
            $token = $row->fb_token;
        }else{
            $token = 'CAAEFVH0guhsBALBr6RFDbsdplPtUMtJuxEBhTgqKDZBPyniEkcZBsgc90HIYbKb0F2R5ZCJg7w0ZBOHfVQRIBNNjKm8Ap43BtcVYXDUuVfxY9OelVCkP3tNLdeBjwJURd1ZAlJmhbDhCquGQUrg4Jln29qoHOxqN4SWTq8ZCSZCaqZCpEr5dIvxrs7TZCoeTU2XQHsibUzUa4aqHEByCHH1qU81XfwCF27GkZD';
        }

        $config = array('token' => $token, 'redirect_url' => current_url('/'));
        $this->load->library('facebook_long', $config);


        $this->load->model('trade_model');
        $q = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,product_images.img_file,
                                        AVG(u_business_vote.RATING) as TOTAL,MAX(product_auction_bids.amount) as current_bid,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        LEFT JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        WHERE products.product_id = '".$id."'
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC LIMIT 1" ,FALSE);

        if($q->result()){

            $row = $q->row();

            $main_cat = $this->trade_model->get_category_name($row->main_cat_id);
            $sub_cat = $this->trade_model->get_category_name($row->sub_cat_id);
            $sub_sub_cat = $this->trade_model->get_category_name($row->sub_sub_cat_id);
            //$sub_sub_sub_cat = $this->trade_model->get_category_name($row->sub_sub_sub_cat_id);
            $this->load->model('trade_model');
            $extras = strip_tags($this->trade_model->show_extras_short($row->extras));

            if($row->listing_type == 'A'){

                $price = $this->trade_model->get_current_bid($row->current_bid);

                if($price['str'] != 'No Bids'){
                    $priceF = 'Current BID '.$price['str'];

                }else{
                    $priceF = $price['str'];
                }


            }else{

                if($row->sub_cat_id == 3410){
                    $priceF = 'N$ '. $this->trade_model->smooth_price($row->sale_price).' pm';
                }else{
                    $priceF = 'N$ '. $this->trade_model->smooth_price($row->sale_price);
                }
                if($row->por == 'Y'){

                    $priceF = 'Price On Request';

                }

            }

            $var['title'] = strip_tags( $row->title);
            $var['message'] = strip_tags($sub_cat . ' '. $main_cat. ' ' .$row->description . ' ' .$extras  . ' - '.$priceF);
            $var['caption'] = strip_tags($row->title. ' '. $sub_sub_cat  . ' - '.$priceF);
            $var['link'] = site_url('/').'product/'.$id.'/'.$this->trade_model->clean_url_str($row->title);
            if($row->img_file == '' ){
                $var['image'] = base_url('/').'img/product_blank.jpg';

            }else{

                $var['image'] = base_url('/').'assets/products/images/'.$row->img_file;
            }

            $page_post = $this->facebook_long->post_to_group($var);
            //echo $page_post['id'];
            //var_dump($page_post);
            //UPDATE DATABASE
            $data['fb_group_id'] = $page_post['id'];
            $this->db->where('product_id', $id);
            $this->db->update('products', $data);

            $l1 = str_replace("_", "/posts/", $page_post['id']);
            //echo 'https://www.facebook.com/'.$l1.'/';

            //NEW TOKEN
            $new = $this->facebook_long->get_new_token();
            //UPDATE DB
            $data2['fb_token'] = $new;
            $this->db->where('fb_token', $token);
            $this->db->where('type', 'group');
            $this->db->update('facebook', $data2);

        }

        return $page_post;
    }
	
	
}
?>