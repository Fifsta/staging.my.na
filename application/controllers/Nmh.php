<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nmh extends CI_Controller {

	/**
	 * My Na Page for this controller.
	 *Roland ihms
	 *
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('search_model');
	
	}
	
	public function index()
	{
		redirect('https://events.my.na/nmh/main.html', 301);
	}

	public function update_business()
	{
		error_reporting(E_ALL);
		$this->output->set_header("Access-Control-Allow-Origin: https://nmh.my.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		$this->output->set_content_type( 'text/html' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			
			$this->load->model('business_model');
			$o = $this->business_model->update_business();
			echo json_encode($o);
			
		}elseif($_SERVER['REQUEST_METHOD'] == "GET"){
			
			
			
		}

	}


	public function add_business()
	{
		error_reporting(E_ALL);
		$this->output->set_header("Access-Control-Allow-Origin: https://nmh.my.na");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		$this->output->set_content_type( 'text/html' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			
			$this->load->model('business_model');
			$o = $this->business_model->add_business();
			echo json_encode($o);
			
		}elseif($_SERVER['REQUEST_METHOD'] == "GET"){
			
			
			
		}

	}

	//+++++++++++++++++++++++++++
	//CHECK LOGIN STATUS
	//++++++++++++++++++++++++++

	function check_me()
	{

		$this->load->library('encrypt');


		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		$this->output->set_content_type( 'text/html' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "GET"){

			if($id = $this->session->userdata('id')){

				if($url = $this->input->get('url')){
					
					if($redirect = $this->input->get('redirect')){
						
						
					}
					
					$d['my_na_id'] = $id;
					$d['u_name'] = $this->session->userdata('u_name');
					$d['u_email'] = $this->session->userdata('u_email');
					$d['img_file'] = $this->session->userdata('img_file');
					$d['city'] = $this->session->userdata('city');
					$d['country'] = $this->session->userdata('country');
					$d['points'] = $this->session->userdata('points');
					$d['subscriptions'] = $this->session->userdata('subscriptions');
					$d['register_date'] = $this->session->userdata('register_date');
					echo "'".$url.'?redirect='.$redirect.'&sess='.$this->encrypt->encode(json_encode($d))."<br />Redirect: ".$redirect."
					<script>window.top.location.href = '".$url.'?redirect='.$redirect.'&sess='.$this->encrypt->encode(json_encode($d))."';</script>";
				}

				//echo json_encode($this->session->all_userdata());
			}else{

				//$d['success'] = false;
				//$d['msg'] = 'No session present';
				//echo json_encode($d);
			}


		}else{

			//echo 'You do not have access rights';

		}//end preflight
	}


	//+++++++++++++++++++++++++++
	//GET PRODUCTS
	//++++++++++++++++++++++++++

	function get_products()
	{




		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

		$this->output->set_content_type( 'application/json' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}elseif($_SERVER['REQUEST_METHOD'] == "GET"){

			$sql = '';$osql = ' LIMIT 5';
			if($main_c = $this->input->get('main_cat')){

				$sql .= " AND products.main_cat_id = '".$main_c."' ";

			}
			if($sub_c = $this->input->get('sub_cat')){

				if($sub_c != 'all'){

					$sql .= " AND products.sub_cat_id = '".$sub_c."' ";
				}


			}
			if($limit = $this->input->get('limit')){

				$osql = " LIMIT ".$limit." ";

			}
			if($offset = $this->input->get('offset')){

				$osql .= " OFFSET ".$offset." ";

			}
			$fsql = '';
			//check featured item
			if($featured = $this->input->get('featured')){

				$fsql = " AND products.is_featured = 'Y' AND products.featured_until > CURDATE() ";

			}

			//$query = $this->db->query("SELECT * FROM products WHERE is_active = 'Y' ORDER BY listing_date DESC" ,FALSE);
			/*$query = $this->db->query("SELECT products.*,product_extras.extras,product_extras.featured,main_cat.category_name as main_cat_name, sub_cat.category_name as sub_cat_name,sub_sub_cat.category_name as sub_sub_cat_name, sub_sub_sub_cat.category_name as sub_sub_sub_cat_name, product_extras.property_agent, u_business.ID,
                                        u_business.IS_ESTATE_AGENT, u_business.BUSINESS_NAME, u_business.BUSINESS_LOGO_IMAGE_NAME,group_concat(product_images.img_file) as images,
                                        MAX(product_auction_bids.amount) as current_bid,products_buy_now.amount,
                                        AVG(u_business_vote.RATING) as TOTAL,
                                        (
                                          SELECT COUNT(u_business_vote.ID) as TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id
                                        ) as TOTAL_REVIEWS

                                        FROM products
                                        JOIN product_extras ON products.product_id = product_extras.product_id
                                        JOIN product_categories as main_cat ON main_cat.cat_id = products.main_cat_id
                                        JOIN product_categories as sub_cat ON sub_cat.cat_id = products.sub_cat_id
                                        JOIN product_categories as sub_sub_cat ON sub_sub_cat.cat_id = products.sub_sub_cat_id
                                        LEFT JOIN product_categories as sub_sub_sub_cat ON sub_sub_sub_cat.cat_id = products.sub_sub_sub_cat_id
                                        LEFT JOIN u_business ON u_business.ID = products.bus_id
                                        JOIN product_images ON products.product_id = product_images.product_id
                                        LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                        LEFT JOIN products_buy_now ON products_buy_now.product_id = products.product_id
                                        LEFT JOIN u_business_vote ON u_business_vote.PRODUCT_ID = products.product_id
                                              AND u_business_vote.IS_ACTIVE = 'Y' AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
                                        WHERE products.is_active = 'Y' AND products.status = 'live' ".$sql."
                                        GROUP BY products.product_id
                                        ORDER BY products.listing_date DESC ".$osql, false);*/
			$query = $this->db->query("select products.*,
									       product_extras.featured,
									       product_extras.extras,
									       product_extras.property_agent,
									        u_business.ID,
									        u_business.IS_ESTATE_AGENT, 
									        u_business.BUSINESS_NAME, 
									        u_business.BUSINESS_PHYSICAL_ADDRESS, 
									        u_business.BUSINESS_TELEPHONE, 
									        u_business.BUSINESS_COVER_PHOTO, 
									        u_business.BUSINESS_LOGO_IMAGE_NAME,
									       (select group_concat(product_images.img_file ORDER BY product_images.sequence ASC) 
									          from product_images 
									         where products.product_id = product_images.product_id
									       ) AS images ,
									        agents.CLIENT_EMAIL, 
									        agents.CLIENT_PROFILE_PICTURE_NAME, 
									        agents.CLIENT_NAME, 
									        agents.CLIENT_SURNAME, 
									        agents.CLIENT_CELLPHONE,
									       (select MAX(product_auction_bids.amount) 
									          from product_auction_bids 
									         where product_auction_bids.product_id = products.product_id 
									               AND product_auction_bids.type = 'bid' 
									       ) AS current_bid,
									       (select AVG(u_business_vote.RATING) 
									          from u_business_vote 
									         where u_business_vote.PRODUCT_ID = products.product_id AND u_business_vote.IS_ACTIVE = 'Y' 
									                AND u_business_vote.TYPE = 'review' AND u_business_vote.REVIEW_TYPE = 'product_review'
									                AND products.status = 'live' AND products.is_active = 'Y'
									       ) as TOTAL,
									        ( SELECT COUNT(u_business_vote.ID) AS TOTAL_R FROM u_business_vote WHERE u_business_vote.PRODUCT_ID = products.product_id ) AS TOTAL_REVIEWS
									  FROM products
									  JOIN product_extras   ON products.product_id = product_extras.product_id
									  LEFT JOIN u_business ON u_business.ID = products.bus_id
									  LEFT JOIN u_client AS agents ON product_extras.property_agent = agents.ID
									  WHERE products.is_active = 'Y' AND products.status = 'live' ".$sql." ".$fsql."
                                      ORDER BY products.listing_date DESC ".$osql, false);





			$o = array();
			if($query->result()){

				$this->load->model('image_model'); 

				$this->load->library('thumborp');
				$this->load->library('encrypt');

				$thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
				$width = 360;
			
				$height = 230;
				

				$this->load->model('trade_model');
				foreach($query->result() as $row){

					//IMAGE
					if ($row->images != null)
					{

						$imgA = explode(',', $row->images);
						$img = $imgA[0];
					}else{
						$img = null;
					}

					

					$img_str = 'assets/products/images/' . $img;

					$img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');

					
					$row->image = $this->encrypt->encode($img_url);
					


					//LISTING TYPE
					if ($row->listing_type == 'S' || $row->listing_type == 'C')
					{
						if ($row->sub_cat_id == 3410)
						{
							$price = 'N$ ' . $this->trade_model->smooth_price($row->sale_price) . ' pm';
						}
						else
						{
							$price = 'N$ ' . $this->trade_model->smooth_price($row->sale_price);
						}
						if ($row->por == 'Y')
						{

							$price = 'Price On Request';

						}
						$row->price = $price;
					}
					elseif ($row->listing_type == 'A')
					{

						$price = $this->trade_model->get_current_bid($row->current_bid);
						$row->price = $price['str'];
					}

					//LISTING DATE
					$row->listing_date = $this->trade_model->time_passed(strtotime($row->listing_date));

					//LOCATION
					$location = '';
					if ($row->location != '')
					{

						$location = '' . $row->location . '';

						if ($row->suburb != 0 && $row->suburb != '')
						{
							$location = $row->location . ' / ' . $row->suburb . '';
						}

					}
					$row->location = $location;

					//extras
					//$row->extras = $this->trade_model->show_extras_short($row->extras);

					//RATING
					//get REVIEWS
					$rating = 0;
					$total_reviews = 0;
					if ($row->TOTAL != null)
					{

						$rating = $row->TOTAL;
						if (isset($row->TOTAL_REVIEWS))
						{
							$total_reviews = $row->TOTAL_REVIEWS;
						}
						else
						{
							$total_reviews = 0;
						}

					}
					$row->rating = $this->trade_model->get_review_stars_show($rating, $row->product_id, 0, $total_reviews);
					/*$row->cat_link = site_url('/').'buy/'.$this->trade_model->encode_url($row->main_cat_name).'/'
						.$this->trade_model->encode_url($row->sub_cat_name).'/';
						//.$this->trade_model->encode_url($row->sub_sub_cat_name).'/';

					$row->cat_name = $row->sub_cat_name;

					if($row->sub_sub_sub_cat_name == ''){

						$ln = 'no-name';
					}else{
						$ln = $this->trade_model->encode_url($row->sub_sub_sub_cat_name);

					}*/

					//$row->location_link = $row->cat_link.$this->trade_model->encode_url($row->sub_sub_cat_name).'/'.$ln.'/'.$location.'/';

					$row->location_link = '';
					$row->cat_link = '';
					$row->cat_name = '';

					array_push($o, $row);

				}

			}


			//$o = $query->result();

			echo json_encode($o);

		}else{

			//echo 'You do not have access rights';

		}//end preflight
	}

 	//+++++++++++++++++++++++++++
	//REGISTER MEMBER WITHOUT AJAX
	//++++++++++++++++++++++++++
	function register()
	{
		$data = $this->my_na_model->get_ip_location();
		$this->load->view('members/register_external', $data);
		
	}
 	//+++++++++++++++++++++++++++
	//INTERESTST
	//++++++++++++++++++++++++++
	function interests()
	{
		if($id = $this->session->userdata('id')){
			$this->load->model('nmh_model');
			$data['client_id'] = $id;
			$this->load->view('members/select_interests', $data);
		}
		
		
	}
 	//+++++++++++++++++++++++++++
	//UPADET INTERESTS
	//++++++++++++++++++++++++++
	function update_interests()
	{
		if($id = $this->session->userdata('id')){
			//$id = 1806;
			$publications = $this->input->post('publications', TRUE);
			$pubs = explode(',',$publications);
			
			$categories = $this->input->post('categories', TRUE);
			$cats = explode(',',$categories);
			//CLEAN CURRENT
			$i = $this->db->query("DELETE FROM my_na_interests WHERE client_id = '".$id."'",TRUE);
			if(count($pubs) > 0){
				
				foreach($pubs as $row){
					
					$insertdata = array(
                        'client_id' => $id,
                        'type' => 'publications',
                        'type_id' => $row,
						'created_at' => date('Y-m-d H;i:s'),
                    
					);
					$this->db->insert('my_na_interests', $insertdata);
				}
				
			}
			if(count($cats) > 0){
				
				foreach($cats as $row2){
					
					$insertdata2 = array(
                        'client_id' => $id,
                        'type' => 'categories',
                        'type_id' => $row2,
						'created_at' => date('Y-m-d H;i:s'),
                    
					);
					$this->db->insert('my_na_interests', $insertdata2);
				}
				
			}
			$o['success'] = true;
			$o['msg'] = 'Thanks, we have received your interests.';
			echo json_encode($o);
			
		}
		
		
	}	
	
	
    //+++++++++++++++++++++++++++
	//REGISTER MEMBER WITHOUT AJAX
	//++++++++++++++++++++++++++
	function register_me()
	{
		 	error_reporting(E_ALL);
		    $email = $this->input->post('email', TRUE);
		    $cell = $this->input->post('cell', TRUE);
		    $pass1 = $this->input->post('pass1', TRUE);
		    $security = $this->input->post('security', TRUE);
		    $fname = $this->input->post('fname', TRUE);
		    $sname = $this->input->post('lname', TRUE);
			$dial_code = $this->input->post('dial_code', TRUE);
			$country = $this->input->post('country', TRUE);
			$city = $this->input->post('city', TRUE);
			$suburb = $this->input->post('suburb', TRUE);
			$reg_ref = $this->input->post('register_ref', TRUE);
            $this->load->library('recaptcha');
            $bool = json_decode($this->recaptcha->recaptcha_check_answer());

            //var_dump ($bool);
            //CAPTCHA FALSE
            if (!$bool->success) {

                $data['error'] = 'Are you a robot? PLease click on I am not a robot above.';

                $result['success'] = false;

                $result['html'] =  '<div class="alert alert-danger" rel="alert">
								<button type="button" class="close" data-dismiss="alert">×</button>
								' . $data['error'] . '</div>';

                echo json_encode($result);
            } else {

                //$dob = strtotime($new_date_format);
				$this->load->model('members_model');
                //VALIDATE INPUT
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $val = FALSE;
                    $error = 'Email address is not valid.';

                } elseif (($fname == '') || ($sname == '')) {
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
						'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
                        'CLIENT_UA' => $agent,
                        'CLIENT_IP' => $IP,
						'CLIENT_CELLPHONE' => $cell,
						'DIAL_CODE' => $dial_code, 
                        'IS_ACTIVE' => 'N',
						'CLIENT_COUNTRY' => $country,
						'CLIENT_CITY' => $city,
						'CLIENT_SUBURB' => $suburb,
						'REGISTRATION_REF' => $reg_ref
                    );

                    $this->db->where('CLIENT_EMAIL', $email);
                    $this->db->from('u_client');
                    $query = $this->db->get();


                    //IF email already exists
                    if ($query->num_rows() > 0) {

                        $data['error'] = 'A member with the email address ' . $email . ' already exists!';

                        $result['success'] = false;

                        $result['html'] =  '<div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['error'] . '</div>';

                        echo json_encode($result);


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
/*                        $data['cell'] = $cell;
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
                        $data['basicmsg'] = 'Thank you ' . $fname . ', please complete the form above to complete your registration.';

                        //SET SEMI SESSION
                        $sess = array(

                            'fname' => $fname,
                            'sname' => $sname,
                            'semi' => true,
                            'email' => $email,
                            'client_id' => $member_id,
							'id' => $member_id

                        );
                        $this->session->set_userdata($sess);

                        $result['success'] = true;
                        $result['client_id'] = $member_id;
                        $result['email'] = $email;
                        $result['html'] = '<div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['basicmsg'] . '</div><script>window.location.href = "'.site_url('/').'nmh/interests/";</script>';

                        echo json_encode($result);

                    }

                } else {

                    $data['error'] = $error;
                    $result['success'] = false;

                    $result['html'] =  '<div class="alert alert-error">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            ' . $data['error'] . '</div>';

                   echo json_encode($result);

                }
            }//end if recaptcha
       
	  }
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */