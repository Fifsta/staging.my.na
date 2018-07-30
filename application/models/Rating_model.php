<?php
class Rating_model extends CI_Model{

	
	public function __construct(){
  		//parent::CI_model();
		$this->load->database();	
 	}


	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//RATING WIDGET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function rate($bus_id, $client_id, $embed, $external, $reviews){


			$q = $this->db->query("SELECT u_business.*,
							group_concat(a_tourism_category_sub.CATEGORY_TYPE_ID) category FROM u_business
							LEFT JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN a_tourism_category_sub on i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
							JOIN a_tourism_category on a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
							WHERE u_business.ID = '".$bus_id."'
							");
			
            $type['bus_id'] = $bus_id;

			if($q->result()){

				//SEE IF LOGGED IN
				if($this->session->userdata('id'))
				{

					//SHOW RATING TAB ACTIVE
					if(!$type['rate_active'] = $this->input->get('rate')){

						$type['rate_active'] = '';

					}
					$row = $q->row();
					$cats = explode(',', $row->category);

					//echo $row->category;

					$type['type'] = $this->identify_business_type($cats);
					$type['bus_id'] = $bus_id;
					$type['client_id'] = $client_id;

					$type['reviews'] = '';
					$type['logged_in'] = TRUE;
					//SHOW REVIEWS
					if ($reviews == 'show')
					{

						$type['reviews'] = $this->show_reviews($bus_id, $external);

					}

					//INCLUDE CSS AN JS
					//INCLUDE HEADER
					if ($embed == 'embed' && $external != 'external')
					{
						$type['html'] = false;
                        $type['bus_id'] = $bus_id;
						
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
                        $type['bootstrap'] = true;
						$this->load->view('business/rate/header', $type);
						$this->load->view('business/rate/' . $type['type'], $type);

                    }//EXTERNAL EMBED
                    elseif ($embed == 'embed' && $external == 'external')
                    {

						$type['html'] = true;
                        $type['bus_id'] = $bus_id;
						
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
                        $type['bootstrap'] = true;
						$this->load->view('business/rate/header', $type);
						$this->load->view('business/rate/' . $type['type'], $type);

					}//PLUGIN
					elseif ($embed == 'plugin' && $external == 'external')
					{
						$type['overflow'] = true;
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$temp = $type['reviews'];
						$type['reviews'] = '';
                        $type['html'] = true;
                        $type['bootstrap'] = true;
						$this->load->view('business/rate/header', $type);
						$type['rate'] = $this->load->view('business/rate/' . $type['type'], $type, true);
						$type['reviews'] = $temp;
						$this->load->view('business/rate/plugin', $type);
						$this->load->view('business/rate/footer', $type);

					}
					elseif ($embed == 'plugin')
					{
                        $type['html'] = true;
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$temp = $type['reviews'];
						$type['reviews'] = '';
						$type['rate'] = $this->load->view('business/rate/' . $type['type'], $type, true);
						$type['reviews'] = $temp;
						$this->load->view('business/rate/plugin', $type);

					}

				}else{


					//SHOW RATING TAB ACTIVE
					if(!$type['rate_active'] = $this->input->get('rate')){

						$type['rate_active'] = '';

					}

					$row = $q->row();
					$cats = explode(',', $row->category);
					$type['reviews'] = '';
					$type['type'] = $this->identify_business_type($cats);
					$type['bus_id'] = $bus_id;
					$type['client_id'] = 0;
					$type['logged_in'] = FALSE;
					//SHOW REVIEWS
					if ($reviews == 'show')
					{
						$reviews = $this->show_reviews($bus_id, $external);
						$type['reviews'] = $reviews;

					}

					//INCLUDE CSS AN JS
					//INCLUDE HEADER
					if ($embed == 'embed' && $external != 'external')
					{
                        $type['html'] = false;
                        $type['bootstrap'] = true;
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$this->load->view('business/rate/header', $type);
						$this->load->view('business/rate/login', $type);


                    }//EXTERNAL EMBED
                    elseif ($embed == 'embed' && $external == 'external')
                    {

                        $type['html'] = true;
                        $type['bootstrap'] = true;
                        $type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
                        $type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
                        $this->load->view('business/rate/header', $type);
						$type['reviews'] = '';
						$type['rateHTML'] = $this->load->view('business/rate/' . $type['type'], $type, true);
						$type['reviews'] = $reviews;
                        $this->load->view('business/rate/login', $type);
						//PLUGIN
					}
					elseif ($embed == 'plugin' && $external == 'external')
					{
                        $type['html'] = true;
						$type['overflow'] = true;
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$temp = $type['reviews'];
						$type['reviews'] = '';
						$type['bootstrap'] = true;
						$this->load->view('business/rate/header', $type);
						$type['rateHTML'] = $this->load->view('business/rate/' . $type['type'], $type, true);
						$type['rate'] = $this->load->view('business/rate/login', $type, TRUE);
						
						$type['reviews'] = $temp;
						$this->load->view('business/rate/plugin', $type);
						$this->load->view('business/rate/footer', $type);

					}
					elseif ($embed == 'plugin')
					{
                        $type['html'] = true;
						$type['title'] = 'Rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$type['metaD'] = 'Leave feedback and rate ' . $row->BUSINESS_NAME . ' - My Namibia';
						$temp = $type['reviews'];
						$type['reviews'] = '';
						$type['rate'] = $this->load->view('business/rate/login', $type, TRUE);
						$type['reviews'] = $temp;
						$this->load->view('business/rate/plugin', $type);

					}


				}

				//echo $reviews;

				//INCLUDE CSS AN JS
				//INCLUDE FOOTER
				if($embed == 'embed'){

					$this->load->view('business/rate/footer', $type);

				}



			}



	}

	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BUSINESS REVIEW & RATING
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	public function widget($bus_id, $embed = '', $external = '', $reviews = 'show')
	{




	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//IDENTIFY BUSINESS RATING TYPE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function identify_business_type($cats){


		/*How to calculate rating for Places To Stay (Accommodation)? (catg_id = 3)
			How to calculate rating for Places To Eat & Drink? (catg_id = 6)
			How to calculate rating for Places To BUY? (catg_id = 9)
			How to calculate rating for Things To Do? (catg_id = 4,5)
			How to calculate rating for Places To SEE? (catg_id = 10)*/

		//ACCOMMODATION
		if(in_array('3', $cats)){

			return 'accommodation';

		//EAT BUY DRINK
		}elseif(in_array('6', $cats)){

			return 'eat';
		//to BUY ----- !!!!!!!!! NEEDS TO BE BUILT
		}elseif(in_array('9', $cats)){

			return 'all';

		//TO DO
		}elseif(in_array('4', $cats)){

			return 'todo';

		//TO SEE
		}elseif(in_array('10', $cats)  || in_array('5', $cats)){

			return 'tosee';

		}else{

			return 'all';
		}

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Show Reviews FRONT END
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_reviews($bus_id, $external = 'no'){

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'memcached'));

		if ( ! $output = $this->cache->get('show_reviews_'.$bus_id.'_'.$external))
		{

	        $query = $this->db->query("SELECT u_business_vote.*,
										(SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL FROM u_business WHERE ID = '".$bus_id."') as TOTAL,
										(SELECT AVG(u_business.STAR_RATING) as AVG_TOTAL FROM u_business WHERE ID = '".$bus_id."') as AVG_TOTAL,
										u_business.BUSINESS_NAME,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.IS_HAN_MEMBER,u_business.IS_NTB_MEMBER,
										u_client.CLIENT_NAME, u_client.CLIENT_SURNAME,
										u_client.CLIENT_PROFILE_PICTURE_NAME as user_image
	 									FROM u_business_vote
	 									JOIN u_business ON u_business_vote.BUSINESS_ID = u_business.ID
	 									LEFT JOIN u_client ON u_business_vote.CLIENT_ID = u_client.ID
	 									WHERE u_business_vote.BUSINESS_ID = '".$bus_id."' AND u_business_vote.IS_ACTIVE = 'Y'
	 									AND  u_business_vote.REVIEW_TYPE = 'business_review'
	 									ORDER BY u_business_vote.TIME_VOTED DESC
										");
 
			$output = '';
	        $response = array();
			if($query->num_rows() > 0){

				$summary = $this->get_summary($query);
				//echo $summary;

				$first = $query->row();
				$name = $first->BUSINESS_NAME;

				if($external == 'external'){
					$output .=  '<h4>'.$name.' Reviews <img src="'.base_url('/').'images/icons/fnb_irate.png" style="width:80px" class="pull-right"/></h4>';
				}else{
					$output .=  '<h4>'.$name.' Reviews</h4>';
				}
				
				$output .= $summary;

	            //LOOP RESPONSES FROM SAME DTATA SET
	            foreach($query->result() as $subrow) {

	                //IF RESPONSE
	                if ($subrow->TYPE == 'response') {

	                    $response[$subrow->REVIEW_ID]['ID'] = $subrow->ID;
	                    $response[$subrow->REVIEW_ID]['REVIEW_ID'] = $subrow->REVIEW_ID;
	                    $response[$subrow->REVIEW_ID]['REVIEW'] = $subrow->REVIEW;
	                    $response[$subrow->REVIEW_ID]['TIME_VOTED'] = $subrow->TIME_VOTED;
	                    $response[$subrow->REVIEW_ID]['CLIENT_ID'] = $subrow->CLIENT_ID;
	                    $response[$subrow->REVIEW_ID]['BUSINESS_ID'] = $subrow->BUSINESS_ID;

	                }
	            }
				$x =0;
				foreach($query->result() as $row){

	                //IF RESPONSE
	                if($row->TYPE == 'response'){



	                }else {


	                    $id = $row->ID;
	                    $client_id = $row->CLIENT_ID;
	                    $bus_id1 = $row->BUSINESS_ID;
	                    $review = $row->REVIEW;
	                    $review_date = $row->TIME_VOTED;
	                    $rating = $row->RATING;
	                    $user = $this->my_na_model->get_user_avatar_id($client_id, 100, 100, $row->user_image);

	                    //CHECK RESPONSE ARRAY FOR SUBS
	                    if(isset($response[$id]['REVIEW_ID'] )){

	                        $reply = $this->get_review_response($id, $row->BUSINESS_LOGO_IMAGE_NAME, $row->BUSINESS_NAME, $response[$id]);

	                    }else{

	                        $reply = '';
	                    }


	                    $r = $this->get_review_detail($row);
	                    if($r == ''){

	                        $r = $this->get_review_stars_img($rating);
	                    }


	                    $output .= '
							<div class="row review-item">
								<div class="col-xs-3 col-sm-2 col-md-1">
									<figure><a href="#"><img  alt="'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'" src="'.$user.'"></a></figure>
								</div>
								<div class="col-sm-10 col-md-5">
									<blockquote>
										<div class="rating">'.$this->get_review_stars($rating,$client_id).'</div>
										<p>'.$review.'</p>
										<footer>'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'<span>' .$this->time_passed(strtotime($review_date)).'</span></footer>
									</blockquote>

									'.$reply.'
								</div>
								 <time itemprop="dtreviewed" style="display:none;font-size:10px;font-style:italic" datetime="'.date('m-d-Y',strtotime($review_date)).'">'.date('F j, Y',strtotime($review_date)).'</time>
								 <span itemprop="rating" style="visibility:hidden">'.(round($rating)).'</span>
							</div>
	                    ';
	                }

				}//end for each

				$output .= '';

			}else{

				$output .= '<div class="alert alert-secondary">
							<h4>No Reviews Added</h4>
							No Reviews have been added for the current business.
						    </div>';
			}


			$this->cache->save('show_reviews_'.$bus_id.'_'.$external, $output, 1440);


		}

		return $output;


	} 





	function get_review_response($id, $pic, $name, $row ){

        if(count($row) > 0){

            $id = $row['ID'];
            $client_id = $row['CLIENT_ID'];
            $bus_id1 = $row['BUSINESS_ID'];
            $business_img = $this->my_na_model->get_business_logo($bus_id1, 100, 100, $pic);


            return '<hr>
						<div class="row">
							<div class="col-sm-2 col-md-2">
								<figure><a href="#"><img  alt="'.$name.'" src="'.$business_img.'"></a></figure>
							</div>
							<div class="col-sm-10 col-md-10">
								<blockquote>
									<p>'.$row['REVIEW'].'</p>
									<footer>'.$name.'<span>' .date('Y-m-d H:i', strtotime($row['TIME_VOTED'])).'</span></footer>
								</blockquote>
							</div>
						</div>

            ';


        }
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//Show Reviews FRONT END
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_reviews_short_email($bus_id, $external = 'no'){


        $query = $this->db->query("SELECT u_business_vote.*,
									(SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL FROM u_business WHERE ID = '".$bus_id."') as TOTAL,
									(SELECT AVG(u_business.STAR_RATING) as AVG_TOTAL FROM u_business WHERE ID = '".$bus_id."') as AVG_TOTAL,
									u_business.BUSINESS_NAME,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.IS_HAN_MEMBER,u_business.IS_NTB_MEMBER,
									u_client.CLIENT_NAME, u_client.CLIENT_SURNAME,
									u_client.CLIENT_PROFILE_PICTURE_NAME as user_image
 									FROM u_business_vote
 									JOIN u_business ON u_business_vote.BUSINESS_ID = u_business.ID
 									LEFT JOIN u_client ON u_business_vote.CLIENT_ID = u_client.ID
 									WHERE u_business_vote.BUSINESS_ID = '".$bus_id."' AND u_business_vote.IS_ACTIVE = 'Y'
 									AND  u_business_vote.REVIEW_TYPE = 'business_review'
 									ORDER BY u_business_vote.TIME_VOTED DESC
									");

		$out = '';
        $response = array();
		if($query->num_rows() > 0){

			$summary = $this->get_summary($query);
			//echo $summary;

			$first = $query->row();
			$name = $first->BUSINESS_NAME;
			if($external == 'external'){
				$out .=  '<h4>'.$name.' Reviews <img src="'.base_url('/').'images/icons/fnb_irate.png" style="width:80px" class="pull-right"/></h4>';
			}else{

				$out .=  '<h4>'.$name.' Reviews</h4>';

			}
			$out .= $summary;

            //LOOP RESPONSES FROM SAME DTATA SET
            foreach($query->result() as $subrow) {

                //IF RESPONSE
                if ($subrow->TYPE == 'response') {

                    $response[$subrow->REVIEW_ID]['ID'] = $subrow->ID;
                    $response[$subrow->REVIEW_ID]['REVIEW_ID'] = $subrow->REVIEW_ID;
                    $response[$subrow->REVIEW_ID]['REVIEW'] = $subrow->REVIEW;
                    $response[$subrow->REVIEW_ID]['TIME_VOTED'] = $subrow->TIME_VOTED;
                    $response[$subrow->REVIEW_ID]['CLIENT_ID'] = $subrow->CLIENT_ID;
                    $response[$subrow->REVIEW_ID]['BUSINESS_ID'] = $subrow->BUSINESS_ID;

                }
            }
			$x =0;
			foreach($query->result() as $row){

                //IF RESPONSE
                if($row->TYPE == 'response'){



                }else {


                    $id = $row->ID;
                    $client_id = $row->CLIENT_ID;
                    $bus_id1 = $row->BUSINESS_ID;
                    $review = $row->REVIEW;
                    $review_date = $row->TIME_VOTED;
                    $rating = $row->RATING;
                    $user = $this->my_na_model->get_user_avatar_id($client_id, 100, 100, $row->user_image);

                    //CHECK RESPONSE ARRAY FOR SUBS
                    if(isset($response[$id]['REVIEW_ID'] )){

                        $reply = '';//$this->get_review_response($id, $row->BUSINESS_LOGO_IMAGE_NAME, $row->BUSINESS_NAME, $response[$id]);

                    }else{

                        $reply = '';
                    }


                    $r = $this->get_review_detail($row);
                    if($r == ''){

                        $r = $this->get_review_stars_img($rating);
                    }


                     $out .= '<table class="table">
                     			<tr>
                     				<td style="width:90px">
                     					<span itemprop="itemreviewed" style="display:none">'.$row->BUSINESS_NAME.'</span>
										<img  title="Reviewed on '.date('F j, Y',strtotime($review_date)).'" class="media-object img-polaroid img-circle" style="width:60px; margin-right:10px; height:60px" alt="'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'" src="'.$user.'">
										  <br />
										  '.$this->get_review_stars($rating,$client_id).'
									</td>
                     				<td style="width:10px"></td>
                     				<td style="width:80%"><span itemprop="description" class="clearfix" style="line-height:15px;">'.$review .'</span>
										  <small class="muted" style="font-size:10px;"> ' .$this->time_passed(strtotime($review_date)).'</small>
										   <div style="font-size:10px;"><span itemprop="reviewer">'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</span></div>
											'.$reply.'
									</td>
                     			</tr>
                     		</table>
                     		';


                }
			}//end for each
			$out .= '';

		}else{

			$out .= '<div class="alert alert-secondary">
						<h4>No Reviews Added</h4>
						No Reviews have been added for the current business.
					  </div>';
		}

		return $out;
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++
//RATING WIDGET
//++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function rate_business($bus_id){

		if($this->session->userdata('id')){

			$q = $this->db->query("SELECT u_business.*,
							group_concat(a_tourism_category_sub.CATEGORY_TYPE_ID) category FROM u_business
							LEFT JOIN i_tourism_category ON u_business.ID = i_tourism_category.BUSINESS_ID
							JOIN a_tourism_category_sub on i_tourism_category.CATEGORY_ID = a_tourism_category_sub.ID
							JOIN a_tourism_category on a_tourism_category_sub.CATEGORY_TYPE_ID = a_tourism_category.ID
							WHERE u_business.ID = '".$bus_id."'
							");

			if($q->result())
			{

				$row = $q->row();
				$cats = explode(',', $row->category);

				$type['type'] = $this->identify_business_type($cats);
				$type['bus_id'] = $bus_id;
				$type['client_id'] = $this->session->userdata('id');

				$type['reviews'] = '';
				$type['logged_in'] = true;

				//echo $type['type'];
				$this->load->view('business/rate/'.$type['type'], $type);

			}


		}else{

			echo '<p>Only My.na users can review businesses. Please register or log in to review the business.<br />
					Create a free user account and stand a chance to win great prizes.</p>
					<br />';
			$this->load->view('inc/login_form');

		}


	}



	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BUSINESS REVIEW & RATING
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	public function submit_review($bus_id)
	{

		$rating = $this->input->post('star1', TRUE);
		$review = strip_tags($this->input->post('reviewtxt', TRUE));
		$IP = $this->input->ip_address();
		//$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
		$client_id = $this->input->post('client_id', TRUE);

		//NEW USER REVIEW -- NOT LOGGED IN
		if($client_id == 0){
			
			$client_id = $this->submit_review_ajax_new_user($bus_id);	
			
		}

		//VALIDATE INPUT
		if($review == ''){
			$val = FALSE;
			$error = 'Please provide us with a review';

		}elseif(str_word_count($review) <= 10){
			$val = FALSE;
			$error = 'Please provide us with a informative review. Must be more than 10 words and no spelling mistakes are accepted!';


		}elseif($rating == ''){
			$val = FALSE;
			$error = 'Please provide us with your star rating of 1-10.';

		}else{
			$val = TRUE;
		}


		//IF VALIDATED
		if($val == TRUE){


			$query = $this->db->query("SELECT * FROM `u_business_vote` WHERE BUSINESS_ID = '".$bus_id."' AND (CLIENT_ID = '".$client_id."' OR IP = '".$IP."')");
			$row = $query->num_rows();


			//IF CLIENT NOT ALREADY REVIEWED BUSINESS
			if($row == 0){

				$data1 = array(
					'BUSINESS_ID'=> $bus_id ,
					'CLIENT_ID'=> $client_id ,
					'IP'=> $IP ,
					'RATING'=> $rating,
					'REVIEW'=> $review
				);

				//INSERT INTO DB
				$this->db->insert('u_business_vote', $data1);

				//SEND EMAIL LINK
				$this->load->model('email_model');
				//EMAIL OFFICE
				$this->email_model->send_review_notification($data1);
				//EMAIL BUSINESS
				//$this->email_model->send_review_notification_business($data1);
				$data['bus_id'] = $bus_id;
				$data['basicmsg'] = 'Thanks! We have succesfully submitted your review. You will receive your points as soon as the review has been approved' ;
				$this->load->view('business/profile', $data);

				//UPDATE CLIENT POINTS
				//$this->business_model->update_client_point($client_id, '3', $bus_id, 'review');
				//IF CLIENT ALREADY REVIEWED BUSINESS
			}else{

				$data['bus_id'] = $bus_id;
				$data['error'] = 'Sorry, it seems like you have already reviewed this business or we have a previously submitted review from your current IP address: '. $IP ;
				$this->load->view('business/profile', $data);

			}

			//IF NOT VALIDATED
		}else{

			$data['bus_id'] = $bus_id;
			$data['error'] = $error;
			$this->load->view('business/profile', $data);

		}
	}


	public function submit_review_ajax($bus_id)
	{
		$type = $this->input->post('type', TRUE);
		$rating = $this->input->post('star1', TRUE);
		$review = strip_tags($this->input->post('reviewtxt', TRUE));
		$IP = $this->input->ip_address();
		//$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
		$client_id = $this->input->post('client_id', TRUE);

		//NEW USER REVIEW -- NOT LOGGED IN
		if($client_id == 0){
			
			$client_id = $this->submit_review_ajax_new_user($bus_id);
			
			
		}
		//echo $type;	
		$res = $this->validate_review_type($type);
		//VALIDATE INPUT
		if($res['bool'] == false){

			$val = FALSE;
			$error = 'Please provide us with a rating for the '.$res['error'].' category';


		}elseif(strlen($review) < 5){
			$val = FALSE;
			$error = 'Please provide us with a review';

		}elseif(str_word_count(strip_tags($review)) <= 3){
			$val = FALSE;
			$error = 'Please provide us with a informative review. Must be more than 3 words and no spelling mistakes are accepted!';


		/*}elseif($rating == ''){
			$val = FALSE;
			$error = 'Please provide us with your star rating of 1-10.';*/

		}else{
			$val = TRUE;
		}



		//IF VALIDATED
		if($val == TRUE){

			$query = $this->db->query("SELECT * FROM `u_business_vote` WHERE BUSINESS_ID = '".$bus_id."' AND CLIENT_ID = '".$client_id."' AND MONTH(TIME_VOTED) = '".date('m')."'");
			$row = $query->num_rows();


			//IF CLIENT NOT ALREADY REVIEWED BUSINESS
			if($row == 0){

				$data1 = array(
					'BUSINESS_ID'=> $bus_id ,
					'CLIENT_ID'=> $client_id ,
					'IP'=> $IP ,
					'RATING'=> $rating,
					'REVIEW'=> $review
				);
				//GET ALL CATEGORY VALUES
				//var_dump($res['value']);
				$total = 0;$x = 0;
				foreach($res['value'] as $r => $s){

					$data1[$r] = $s;
					//echo $r . ' '.$s .'<br />';
					$total = $total + $s;
					$x ++;
				}
				$data1['RATING'] = $total / $x;

				//INSERT INTO DB
				$this->db->insert('u_business_vote', $data1);

				//SEND EMAIL LINK
				$this->load->model('email_model');
				//EMAIL OFFICE
				$this->email_model->send_review_notification($data1);
				//EMAIL BUSINESS
				//$this->email_model->send_review_notification_business($data1);
				//UPDATE CLIENT POINTS
				//$this->business_model->update_client_point($client_id, '3', $bus_id, 'review');
				//NA BUSINESS
				//$this->business_model->my_na_click($bus_id, $client_id, 'right');


				$data['bus_id'] = $bus_id;
				$data['basicmsg'] = 'Thanks! We have succesfully submitted your review. It will be live as soon as the review has been moderated' ;
				echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$data['basicmsg'].'</div>
						<script  data-cfasync="false" type="text/javascript">
							//$("#reviewtxt").redactor("set", "");

						</script>
						';


				//IF CLIENT ALREADY REVIEWED BUSINESS
			}else{


				$data['bus_id'] = $bus_id;
				$data['error'] = 'Sorry, it seems like you have already reviewed this business, or someone from your current IP address: '. $IP ;
				echo '<div class="alert alert-error">
								<button type="button" class="close" data-dismiss="alert">×</button>
								'.$data['error'].'</div>';


			}

			//IF NOT VALIDATED
		}else{

			$data['bus_id'] = $bus_id;
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';

		}


	}


	public function submit_review_ajax_new_user($bus_id)
	{
		$fname = $this->input->post('fname', TRUE);
		$sname = $this->input->post('sname', TRUE);
		$email = $this->input->post('signup_email', TRUE);
		$val = FALSE;
		//VALIDATE INPUT
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';	
				
			}elseif(($fname == '') || ($sname == '')){
				$val = FALSE;
				$error = 'Please provide us with your full name.';	
			}else{
				
				$val = TRUE;
				
			}
			
			if($val){
				
				//TEST IF EMAIL EXISTS
				$this->db->where('CLIENT_EMAIL', trim($email));
				$e = $this->db->get('u_client');
				//EXISTING USER	
				if($e->result()){
					$erow = $e->row();
					return $erow->ID;
					
				//NEW USER	
				}else{
					$this->load->model('members_model');
					$this->load->library('user_agent');
					$agent = $agent = $this->agent->platform() .' '.$this->agent->browser().' ver : '.$this->agent->version();
					$IP = $_SERVER['HTTP_CF_CONNECTING_IP'];
					$pass1 = md5(time().$fname);
					$insertdata = array(
							  'CLIENT_NAME'=> $fname ,
							  'CLIENT_SURNAME'=> $sname ,
							   'CLIENT_EMAIL'=> $email,
							   
							   'CLIENT_PASSWORD'=> $this->members_model->hash_password($email,$pass1),
							  /*'CLIENT_COUNTRY' => $country,
							  'CLIENT_CITY' => $city,
							  'CLIENT_SUBURB' => $suburb,*/
							  'CLIENT_UA' => $agent,
							  'CLIENT_IP' => $IP,
							  'IS_ACTIVE' => 'N',
							  'EMAIL_NOTIFICATION' => 'N'
					);
					
					$this->db->insert('u_client', $insertdata);
					$client_id = $this->db->insert_id();

					  //SEND EMAIL LINK
					  $this->load->model('email_model');

					  $data['fname'] = $fname;
					  $data['img'] = '0';
					  $data['member_id'] = $client_id;
					  $data['email'] = $email;
					  $data['sname'] = $sname;
					  $data['agent'] = $agent;
					  $data['base'] = base_url('/');
					  $data['confirm_link'] = site_url('/') . 'rate/activate/'.$client_id;
					  //SEND EMAIL LINK
					  //$this->load->model('email_model');
					  //$this->email_model->send_register_link($data);

					  //BUILD BODY
					  $body = 'Hi ' . $fname . ',<br /><br />
								 <p>You have successfully registered as a official reviewing party of Namibia.</p>
								 <p><img class="white_box" src="'.S3_URL.'assets/business/photos/226a595cc02ca4b39495429cd048de7e.jpg" ></p>
									 <p>To verify your email address and activate your account please click on the link below or copy and paste it into the address bar of your browser.</p>
									 <p></p>
									 <p>' . $data['confirm_link'] . '</p>
									 <p>If you have any questions please email us at info@my.na.</p>
									 <p>Have a !na day</p>
									 <br /><br />
									 My Namibia
									 <p><img class="white_box" src="'.S3_URL.'assets/business/photos/3ee358379f50d9fb1e89a72d03ce4418.png" ></p>
									 ';

						 $data_view['body'] = $body;
						 $body_final = $this->load->view('email/body_news', $data_view, true);
						 $subject = 'Your Email Verification Link';
						 $fromEMAIL = 'no-reply@my.na';
						 $fromNAME = 'My Namibia';
						 $TAG = array('tags' => 'irate_registration');
						 $emailTO = array(array('email' => $email));

						 //SEND EMAIL LINK
						 $this->load->model('email_model');
						 $this->email_model->send_mail($body_final, $subject, $emailTO, $fromEMAIL, $fromNAME, $TAG);
						return $client_id;
					
				}
				
				
			}else{
				
				$data['error'] = $error;
				echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
				die();
				
			}
		
		
	}



	function validate_review_type($type)
	{

		$val['bool'] = true;
		$val['value'] = array();
		$val['error'] = '';
		$temp = '';
		//++++++++++++++++++++++++++++++
		//ACCOMODATION
		//+++++++++++++++++++++++++++++++
		if ($type == 'accommodation'){

			if($this->input->post('SERVICE')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Service';

			}
			if($this->input->post('VALUE_FOR_MONEY')){
				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Value for Money';

			}
			if($this->input->post('SLEEP_QUALITY')){
				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['SLEEP_QUALITY'] = $this->input->post('SLEEP_QUALITY');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Sleep Quality';

			}
			if($this->input->post('CLEANLINESS')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['SLEEP_QUALITY'] = $this->input->post('SLEEP_QUALITY');
				$val['value']['CLEANLINESS'] = $this->input->post('CLEANLINESS');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Cleanliness';

			}
			if($this->input->post('LOCATION')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['SLEEP_QUALITY'] = $this->input->post('SLEEP_QUALITY');
				$val['value']['CLEANLINESS'] = $this->input->post('CLEANLINESS');
				$val['value']['LOCATION'] = $this->input->post('LOCATION');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Location';

			}
			if($this->input->post('ROOMS')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['SLEEP_QUALITY'] = $this->input->post('SLEEP_QUALITY');
				$val['value']['CLEANLINESS'] = $this->input->post('CLEANLINESS');
				$val['value']['LOCATION'] = $this->input->post('LOCATION');
				$val['value']['ROOMS'] = $this->input->post('ROOMS');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Rooms';

			}
			if($this->input->post('FOOD_N_BEVERAGES')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['SLEEP_QUALITY'] = $this->input->post('SLEEP_QUALITY');
				$val['value']['CLEANLINESS'] = $this->input->post('CLEANLINESS');
				$val['value']['LOCATION'] = $this->input->post('LOCATION');
				$val['value']['ROOMS'] = $this->input->post('ROOMS');
				$val['value']['FOOD_N_BEVERAGES'] = $this->input->post('FOOD_N_BEVERAGES');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Food and beverages';
			}
			if($this->input->post('FACILITIES')){

				$val['bool'] = true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['SLEEP_QUALITY'] = $this->input->post('SLEEP_QUALITY');
				$val['value']['CLEANLINESS'] = $this->input->post('CLEANLINESS');
				$val['value']['LOCATION'] = $this->input->post('LOCATION');
				$val['value']['ROOMS'] = $this->input->post('ROOMS');
				$val['value']['FOOD_N_BEVERAGES'] = $this->input->post('FOOD_N_BEVERAGES');
				$val['value']['FACILITIES'] = $this->input->post('FACILITIES');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Facilities';

			}

			//FINAL
			if(in_array(false, $val['value'])){

				$val['bool'] = false;

			}

		//++++++++++++++++++++++++++++++
		//EAT
		//+++++++++++++++++++++++++++++++
		}elseif ($type == 'eat'){

			if($this->input->post('SERVICE')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Service';

			}
			if($this->input->post('YUMM_FACTOR')){
				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['YUMM_FACTOR'] = $this->input->post('YUMM_FACTOR');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Yumm Factor';

			}
			if($this->input->post('VALUE_FOR_MONEY')){
				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['YUMM_FACTOR'] = $this->input->post('YUMM_FACTOR');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Value for Money';

			}

			if($this->input->post('ATMOSPHERE')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['YUMM_FACTOR'] = $this->input->post('YUMM_FACTOR');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['ATMOSPHERE'] = $this->input->post('ATMOSPHERE');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Atmosphere';

			}

			//FINAL
			if(in_array(false, $val['value'])){

				$val['bool'] = false;

			}

		//++++++++++++++++++++++++++++++
		//TO BUY
		//+++++++++++++++++++++++++++++++
		//}elseif ($type == 'tobuy'){


		//++++++++++++++++++++++++++++++
		//TO DO
		//+++++++++++++++++++++++++++++++
		}elseif ($type == 'todo'){

			if($this->input->post('UNIQUENESS')){

				$val['bool'] =true;

				$val['value']['UNIQUENESS'] = $this->input->post('UNIQUENESS');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Uniqueness';

			}
			if($this->input->post('FUN_FACTOR')){
				$val['bool'] =true;

				$val['value']['UNIQUENESS'] = $this->input->post('UNIQUENESS');
				$val['value']['FUN_FACTOR'] = $this->input->post('FUN_FACTOR');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Fun Factor';

			}
			if($this->input->post('VALUE_FOR_MONEY')){
				$val['bool'] =true;

				$val['value']['UNIQUENESS'] = $this->input->post('UNIQUENESS');
				$val['value']['FUN_FACTOR'] = $this->input->post('FUN_FACTOR');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Value For Money';

			}

			//FINAL
			if(in_array(false, $val['value'])){

				$val['bool'] = false;

			}
		//++++++++++++++++++++++++++++++
		//TO SEE
		//+++++++++++++++++++++++++++++++
		}elseif ($type == 'tosee'){


			if($this->input->post('WOW_FACTOR')){

				$val['bool'] =true;

				$val['value']['WOW_FACTOR'] = $this->input->post('WOW_FACTOR');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Service';

			}
			if($this->input->post('VALUE_FOR_MONEY')){
				$val['bool'] =true;

				$val['value']['WOW_FACTOR'] = $this->input->post('WOW_FACTOR');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Value For Money';

			}
			if($this->input->post('LOCATION')){
				$val['bool'] =true;

				$val['value']['WOW_FACTOR'] = $this->input->post('WOW_FACTOR');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['LOCATION'] = $this->input->post('LOCATION');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Location';

			}
			//FINAL
			if(in_array(false, $val['value'])){

				$val['bool'] = false;

			}
		//++++++++++++++++++++++++++++++
		//TO SEE
		//+++++++++++++++++++++++++++++++
		}else{


			if($this->input->post('SERVICE')){

				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Service';

			}
			if($this->input->post('VALUE_FOR_MONEY')){
				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Value For Money';

			}
			if($this->input->post('PRODUCT_RATING')){
				$val['bool'] =true;

				$val['value']['SERVICE'] = $this->input->post('SERVICE');
				$val['value']['VALUE_FOR_MONEY'] = $this->input->post('VALUE_FOR_MONEY');
				$val['value']['PRODUCT_RATING'] = $this->input->post('PRODUCT_RATING');

			}else{
				$val['bool'] = false;
				$temp = false;
				$val['error'] = 'Product';

			}
			//FINAL
			if(in_array(false, $val['value'])){

				$val['bool'] = false;

			}

		}


		return $val;


	}



    //++++++++++++++++++++++++++++++
    //CONSOLIDATE REVIEWS
    //+++++++++++++++++++++++++++++++
    function consolidate_review($bus_id){

        $query = $this->db->query("SELECT u_business_vote.*,u_business.STAR_RATING, u_business.NO_OF_REVIEWS FROM u_business_vote
                                      JOIN u_business ON u_business_vote.BUSINESS_ID = u_business.ID
                                      WHERE u_business_vote.BUSINESS_ID = '".$bus_id."' AND u_business_vote.TYPE = 'review'");
        $v = true;
        //CHECK IF USER RATE ALREADY
        $no_reviews = 0;
        $star_rating = 0;
        $total = 0;
        $count = 0;
        if($query->result()){

            //loop each to mathc user ID has voted
            foreach($query->result() as $row){

                if($row->IS_ACTIVE == 'Y'){

                    $total = $total + $row->RATING;

					$count ++;
                }


            }
            $no_reviews =  $count;
            $star_rating = $row->STAR_RATING;
        }

        //echo $total;
        //UPDATE u_business table
        $bdata['NO_OF_REVIEWS'] = $no_reviews;
        if($count == 1){
            //ADD TOTALS AND AVERAGE
            $bdata['STAR_RATING'] = $total;


        }else{
            //ADD TOTALS AND AVERAGE
            $bdata['STAR_RATING'] = ($total / $count);

        }

        $this->db->where('ID', $bus_id);
        $this->db->update('u_business', $bdata);



    }

	//++++++++++++++++++++++++++++++
	//CONSOLIDATE PRODUCT REVIEWS
	//+++++++++++++++++++++++++++++++
	function consolidate_review_product($id){

		$query = $this->db->query("SELECT u_business_vote.*,products.star_rating, products.no_of_reviews FROM u_business_vote
                                      JOIN products ON u_business_vote.PRODUCT_ID = products.product_id
                                      WHERE u_business_vote.PRODUCT_ID = '".$id."' AND u_business_vote.TYPE = 'review'");
		$v = true;
		//CHECK IF USER RATE ALREADY
		$no_reviews = 0;
		$star_rating = 0;
		$total = 0;
		$count = 0;
		if($query->result()){

			//loop each to mathc user ID has voted
			foreach($query->result() as $row){

				if($row->IS_ACTIVE == 'Y'){

					$total = $total + $row->RATING;

					$count ++;
				}


			}
			$no_reviews =  $count;
			$star_rating = $row->star_rating;
		}

		//echo $total;
		//UPDATE u_business table
		$bdata['no_of_reviews'] = $no_reviews;
		if($count == 1){
			//ADD TOTALS AND AVERAGE
			$bdata['star_rating'] = $total;


		}else{
			//ADD TOTALS AND AVERAGE
			$bdata['star_rating'] = ($total / $count);

		}

		$this->db->where('product_id', $id);
		$this->db->update('products', $bdata);



	}


   //++++++++++++++++++++++++++++++
    //GET REVIEW DETAIL
    //+++++++++++++++++++++++++++++++
    function get_review_detail($row){

		$o ='';
      	//LOOP THROUGH ARRAY AND FIND RATING CRITERIA
		foreach($row as $r => $v){
			
			//echo $r . ' ' .$v;
			if($r == 'PRODUCT_RATING' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'ATMOSPHERE' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'YUMM_FACTOR' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}

			if($r == 'SOCIAL_AWARENESS_FACTOR' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'KNOWLEDGE' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'FRIENDLINESS' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'STAFF' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'WOW_FACTOR' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'FUN_FACTOR' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'UNIQUENESS' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'FACILITIES' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'FOOD_N_BEVERAGES' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'ROOMS' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'LOCATION' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'CLEANLINESS' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'SLEEP_QUALITY' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'VALUE_FOR_MONEY' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}
			if($r == 'SERVICE' && $v > 0){
				
				$o .= '<p><small>'.ucwords(str_replace('_', ' ', strtolower($r))).'</small><br />'.$this->get_review_stars_img($v).'</p>';
				
			}

		}
		
		return $o;


    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //Show Reviews  BACK END
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    function show_reviews_edit($bus_id){

        $query = $this->db->query("SELECT u_business_vote.*,
									(SELECT (AVG(u_business.STAR_RATING) * u_business.NO_OF_REVIEWS) as TOTAL FROM u_business WHERE ID = '".$bus_id."') as TOTAL,
									(SELECT AVG(u_business.STAR_RATING) as AVG_TOTAL FROM u_business WHERE ID = '".$bus_id."') as AVG_TOTAL,
									u_business.BUSINESS_NAME,u_business.BUSINESS_LOGO_IMAGE_NAME,u_business.IS_HAN_MEMBER,u_business.IS_NTB_MEMBER,
									u_client.CLIENT_NAME, u_client.CLIENT_SURNAME,
									u_client.CLIENT_PROFILE_PICTURE_NAME as user_image
 									FROM u_business_vote
 									JOIN u_business ON u_business_vote.BUSINESS_ID = u_business.ID
 									LEFT JOIN u_client ON u_business_vote.CLIENT_ID = u_client.ID
 									WHERE u_business_vote.BUSINESS_ID = '".$bus_id."' AND u_business_vote.IS_ACTIVE = 'Y'
 									AND  u_business_vote.REVIEW_TYPE = 'business_review'
 									ORDER BY u_business_vote.TIME_VOTED DESC
									");
		$out = '';


		$out .= $this->get_totals($query);
		$summary = $this->get_summary($query);
		$out .= $summary;
		$v['bus_id'] = $bus_id;
		$out .= $this->load->view('members/inc/rating_widget', $v, TRUE);
        $response = array();
        if($query->num_rows() > 0){


            //LOOP RESPONSES FROM SAME DTATA SET
            foreach($query->result() as $subrow) {

                //IF RESPONSE
                if ($subrow->TYPE == 'response') {

                    $response[$subrow->REVIEW_ID]['ID'] = $subrow->ID;
                    $response[$subrow->REVIEW_ID]['REVIEW_ID'] = $subrow->REVIEW_ID;
                    $response[$subrow->REVIEW_ID]['REVIEW'] = $subrow->REVIEW;
                    $response[$subrow->REVIEW_ID]['TIME_VOTED'] = $subrow->TIME_VOTED;
                    $response[$subrow->REVIEW_ID]['CLIENT_ID'] = $subrow->CLIENT_ID;
                    $response[$subrow->REVIEW_ID]['BUSINESS_ID'] = $subrow->BUSINESS_ID;


                }
            }

            $x =0;
            foreach($query->result() as $row){

                //IF RESPONSE
                if($row->TYPE == 'response'){

                }else{

                    $id = $row->ID;
                    $client_id = $row->CLIENT_ID;
                    $bus_id1 = $row->BUSINESS_ID;
                    $review = $row->REVIEW;
                    $review_date = $row->TIME_VOTED;
                    $rating = $row->RATING;
                    $user = $this->my_na_model->get_user_avatar_id($client_id, 100, 100, $row->user_image);

                    //CHECK RESPONSE ARRAY FOR SUBS
                    if(isset($response[$id]['REVIEW_ID'] )){

                        $reply = $this->get_review_response($id, $row->BUSINESS_LOGO_IMAGE_NAME, $row->BUSINESS_NAME, $response[$id]);

                    }else{

                        $reply = '<a class="btn pull-right btn-inverse" href="#" onclick="load_response('.$id.')">Respond</a>';
                    }



                    $r = $this->get_review_detail($row);

                    if(strlen($r) == 0){

                        $r = $this->get_review_stars_img($rating);
                    }



                    $out .= '<div class="row-fluid">
							<div class="span12">
								<div class="media">

									  <div itemscope itemtype="http://data-vocabulary.org/Review">
										  <span itemprop="itemreviewed" style="display:none">'.$row->BUSINESS_NAME.'</span>
										  <a class="popovers pull-left" href="#" title="Reviewed on '.date('F j, Y',strtotime($review_date)).'">
											<span class="popover-content d-none">'.$r.'</span>
											<img class="media-object img-polaroid img-circle" style="width:60px; margin-right:10px; height:60px" alt="'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'" src="'.$user.'">
										  </a>
										  <span itemprop="summary" style="display:none;height:0px">'.strip_tags($this->shorten_string($review,4)).'</span>
										  <div class="media-body">
										  '.$this->get_review_stars($rating,$client_id).'
										   <br/>

										  <span itemprop="description" class="clearfix" style="line-height:15px;">'.$review .'</span>
										  <small class="muted" style="font-size:10px;"> ' .$this->time_passed(strtotime($review_date)).'</small>
										   <div style="font-size:10px;"><span itemprop="reviewer">'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</span></div>
											'.$reply.'
										  <time itemprop="dtreviewed" style="display:none;font-size:10px;font-style:italic" datetime="'.date('m-d-Y',strtotime($review_date)).'">'
                        .date('F j, Y',strtotime($review_date)).'</time>
										  <span itemprop="rating" style="visibility:hidden">'.($rating).'</span>
										  </div>
									  </div>
								</div>
							</div>
					 </div>';

                }




            }//end for each


            $out .= '<script data-cfasync="false" data-cfasync="false" type="text/javascript">
							$(document).ready(function(){

								/*$.getScript("'. base_url('/'). 'js/jquery.rating.pack.js", function(data) {
									$("input .star").rating();
								});*/
								$(".popovers").popover({
                                        placement : "right",
                                        html : true,
                                        trigger : "hover", //<--- you need a trigger other than manual
                                        delay: {
                                           show: "500",
                                           hide: "100"
                                        },
                                        content: function() {

                                            return $(this).find("span.popover-content").html();
                                        }
                                });


							});

							function load_response(id){

									$.ajax({
										type: "get",
										cache: false,
										url: "'. site_url('/').'business/load_response_modal/"+id+"/" ,
										success: function (data) {


												 $("#modal-respond").appendTo("body").unbind("show").bind("show", function() {

												 }).modal({ backdrop: true });

												 $("#modal-respond").html(data);

										}
									});

							}

						</script>';


            //echo $this->load->view('business/inc/business_review_respond_inc', $data, TRUE);

        }else{

            $out .= '<div class="alert alert-secondary">
						<h4>No Reviews Added</h4>
						No Reviews have been added for the current business.
					  </div>';
        }
        echo $out;
    }

	function get_review_badge($rating, $name){

		$x = 1;
		$rating = round($rating);
		if($rating > 5){
			$rating = 5;
		}elseif($rating < 1){
			$rating = 1;

		}
		$str = '<img class="mobile_small" src="'.base_url('/').'images/icons/star_badge'.$rating.'.png?v3" alt="'.$rating.' Star Rating - '.$name.'" title="'.$rating.' Star Rating - '.$name.'">
				<h4><small>Rated:</small> '.$rating.' Stars</h4>';

		return $str;
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

    function get_review_stars($rating,$id){

		$x = 1;
		$rating = round($rating);
		while($x <= 5){

			$rating = round($rating);
			if($rating > 5){
				$rating = 5;
			}elseif($rating < 1){
				$rating = 1;

			}
			$str = '<img src="'.base_url('/').'images/icons/star'.$rating.'.png" rel="tooltip" title="Rated '.$rating .' Stars" alt="Rated '.$rating .' Stars">';
			return $str;
		}
//		/return $arr;
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET TOTAL RATINGS REPORT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_totals($q)
	{
		if($q->result()){

			//GET TOTAL RATINGS - Only reviews, no response
			$count = 0;
			foreach($q->result() as $crow){

				if($crow->CLIENT_ID != 0 && $crow->TYPE == 'review'){

					$count ++;
				}

			}

			$row = $q->row_array();
			$tmax = $row['TOTAL'] * 1.3;
			$cmax = $count * 1.3;
			$amax = round($row['AVG_TOTAL'] * 1.3);
			echo '<div class="container-fluid">
					<div class="row-fluid">
						<div class="span12">&nbsp;</div>
					</div>
					<div class="row-fluid">
						<div class="span4 text-center">
							<div class="circleStats">
									<div class="circleStatsItem orange count">

											<i class="fa fa-line-chart"></i>
											<input type="text" id="business_'.$row['BUSINESS_ID'].'_count" value="'.$count.'" class="orangeCircle" />

									</div>
							 </div>
							<strong>Total Reviews</strong>
							<p class="muted"><small>Total Number of Reviews</small></p>
						</div>
						<div class="span4 text-center" >
							<div class="circleStats" >
									<div class="circleStatsItem orange avg">

											<i class="fa fa-sliders"></i>
											<input type="text" id="business_'.$row['BUSINESS_ID'].'_avg" value="'.$row['AVG_TOTAL'].'" class="orangeCircle" />

									</div>
							 </div>
							<strong>Review Average</strong>
							<p class="muted"><small>Total average review rating 1 - 5</small></p><i class="icon-expeditedssl"></i>
						</div>
						<div class="span4 text-center">

							<div class="circleStats">
									<div class="circleStatsItem orange weight">

											<i class="fa fa-tachometer"></i>
											<input type="text" id="business_'.$row['BUSINESS_ID'].'_total" value="'.$row['TOTAL'].'" class="orangeCircle" />

									</div>
							 </div>
							<strong>Weighted Score</strong>
							<p class="muted"><small>The overall evaluation weight.</small></p>
						</div>
				</div>
			</div>

					<script type="text/javascript">
					$(document).ready(function() {
						//TOTAL WEIGHT

						$("#business_'.$row['BUSINESS_ID'].'_total").knob({
										"min":0,
										"max":'. $tmax.',
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.1,
										"tickColorizeValues": true,
										"skin":"tron"
						});

						$(".weight").mouseover(function(){

						  $(this).popover({ placement:"left",html: true, title:"Total Rating Weight",
						  	content:"This is your total weighting score: Average of all reviews multiplied by total number of reviews"});
						  	$(this).popover("show");
						  }).mouseout(function(){

						  	$(this).popover("destroy");
						});
						//TOTAL REVIEWS

						$("#business_'.$row['BUSINESS_ID'].'_count").knob({
										"min":0,
										"max":'. $cmax.',
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.1,
										"tickColorizeValues": true,
										"skin":"tron"
						});

						$(".count").mouseover(function(){

						  $(this).popover({ placement:"right",html: true, title:"Total Number of reviews",
						  	content:"This is your total reviews that have been left for the business"});
						  	$(this).popover("show");
						  }).mouseout(function(){

						  	$(this).popover("destroy");
						});
						//REVIEWS |AVERAGE

						$("#business_'.$row['BUSINESS_ID'].'_avg").knob({
										"min":0,
										"max":'. $amax.',
										"readOnly": true,
										"width": 80,
										"height": 80,
										"fgColor": "#fff",
										"dynamicDraw": true,
										"thickness": 0.1,
										"tickColorizeValues": true,
										"skin":"tron"
									});

						$(".avg").mouseover(function(){

						  $(this).popover({ placement:"bottom",html: true, title:"Total Rating Average",
						  content:"This is your total weighting average score"});
						  $(this).popover("show");
						  }).mouseout(function(){

						  $(this).popover("destroy");
						});
					});
					</script>';

		}


	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET TOTAL RATINGS SUMMARY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_summary($q)
	{
		$this->config->load('rating_criteria');
		$crit = $this->config->item('rating_criteria');
		$sum = array();
		$total = array();
		$count = array();
		$avg = array();
		$out = '';
		if($q->result()){
			$mainrow = $q->row();

			//GET HAN RATING BADGE
			if($mainrow->IS_HAN_MEMBER == 'Y'){

				$han = '<td style="width:30%; vertical-align:middle;text-align:center; "><div class="">'.$this->get_han_summary($q).'</div></td>';
				$w1 = '30%';
				$w2 = '40%';

			}else{
				$han = '';
				$w1 = '35%';
				$w2 = '65%';

			}


			//BUILD INDEX LOOP
			foreach($crit as $crow){
				$sum[$crow] = 0;
				$count[$crow] = 0;
				$total[$crow] = 0;
				$avg[$crow] = 0;
			}

			//CALCULATION LOOP
			foreach($q->result() as $row ){

				//ONLY FOR REVIEWS no RESPONSES
				if($row->CLIENT_ID != 0 && $row->TYPE == 'review'){

					//echo $row;
					foreach($row as $subrow => $v){

						//ONLY IF CRITERIA
						if(in_array($subrow, $crit) && $v > 0){

							//ONLY IF NOT 0
							if($v > 0){

								//echo $subrow.' - ' .$v.'<br />';
								//GATHER SUM
								$sum[$subrow] = $sum[$subrow] + $v;
								//GATHER RATING COUNT
								$count[$subrow] = $count[$subrow] + 1;
								//GET AVERAGE
								$avg[$subrow] = $sum[$subrow] / $count[$subrow];
							}


						}


					}

				}


			}

			$badge = $this->get_review_badge($mainrow->AVG_TOTAL, $mainrow->BUSINESS_NAME);
			
			$out .= '<table class="table table-responsive">';
			$out .= '<tr class="well well-mini">
						<td style="width:'.$w1.'; vertical-align:middle;text-align:center;">'.$badge.'</td>
						'.$han.'
						<td style="width:'.$w2.'; vertical-align:middle;">
							<table class="table table-responsive table-condensed" style="background:none;">';
			$old = 0;
			foreach($sum as $srow => $sv){

				if($sv > 0){
					$title = ucwords(str_replace('_',' ', strtolower($srow)));
					$out .= '<tr>';
					$out .= '<td style="width:50%; border:none;text-align:right">'.$title . '</td>
							 <td class="text-left"  style="border:none;width:50%">
							 '.$this->get_review_stars_img($avg[$srow]).' 
							 <span class="badge hidden-phone" title="Total Average for '.$title.'" rel="tooltip">' .round($avg[$srow], 1).'</span></td>';
					$out .= '</tr>';
				//OLD RATINGS	
				}
					
				//ONLY ONCE
				if($old == (count($sum)-1)){
					$title = 'Overall';
					$out .= '<tr>';
					$out .= '<td style="width:50%; border:none;text-align:right;font-weight:bold">'.$title . '</td>
							 <td class="text-left"  style="border:none;width:50%">
							 '.$this->get_review_stars_img($mainrow->AVG_TOTAL).' 
							 <span class="badge  hidden-phone" title="Total Average for '.$title.'" rel="tooltip">' .round($mainrow->AVG_TOTAL, 1).'</span></td>';
					$out .= '</tr>';
				}
				

				//echo $srow . ' : '.$sum[$srow].'<br />';
				$old ++;
			}				
							
							
			$out .= '		</table>
						</td>
					</tr>';
			$out .= '</table>';
			
			
			
			

		}
		return $out;

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET HAN TOTAL RATINGS SUMMARY
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_han_summary($q)
	{

		if($q->result()) {
			$mainrow = $q->row();

			$avg = $mainrow->AVG_TOTAL;
			$str = '';
			if($avg >= 4.5){
				//GOLD
				$str .='<img src="'.base_url('/').'images/icons/han_award5.png?5" title="Gold Excellence HAN Award" alt="Gold Excellence HAN Award" class="" >
							<h4><small>Rated:</small> Gold</h4>';

			}elseif($avg >= 4.0 & $avg <= 4.4){
				//SILVERR
				$str .='<img src="'.base_url('/').'images/icons/han_award4.png?5" title="Silver Excellence HAN Award" alt="Silver Excellence HAN Award" class="">
						<h4><small>Rated:</small> Silver</h4>';

			}elseif($avg >= 3.5 & $avg <= 4.0){

				//BRONZE
				$str .='<img src="'.base_url('/').'images/icons/han_award3.png?5" title="Bronze Excellence HAN Award" alt="Bronze Excellence HAN Award" class="">
						<h4><small>Rated:</small> Bronze</h4>';

			}elseif($avg >= 3.0 & $avg <= 3.4){

				//MERIT
				$str .='<img src="'.base_url('/').'images/icons/han_award2.png?5" title="Merit Excellence HAN Award" alt="Merit Excellence HAN Award" class="">
						<h4><small>Rated:</small> Merit</h4>';

			}else{

				$str .='<img src="'.base_url('/').'images/icons/han_award2.png?5" title="Merit Excellence HAN Award" alt="Merit Excellence HAN Award" class="">
						<h4><small>Rated:</small> Merit</h4>';

			}


			return $str;
		}


	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET TIME PAST
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function time_passed($timestamp){
		//type cast, current time, difference in timestamps
		$timestamp      = (int) $timestamp;
		$current_time   = time();
		$diff           = $current_time - $timestamp;
		
		//intervals in seconds
		$intervals      = array (
			'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
		);
		
		//now we just find the difference
		if ($diff == 0)
		{
			return 'just now';
		}    
	
		if ($diff < 60)
		{
			return $diff == 1 ? $diff . ' second ago' : $diff . ' seconds ago';
		}        
	
		if ($diff >= 60 && $diff < $intervals['hour'])
		{
			$diff = floor($diff/$intervals['minute']);
			return $diff == 1 ? $diff . ' minute ago' : $diff . ' minutes ago';
		}        
	
		if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
		{
			$diff = floor($diff/$intervals['hour']);
			return $diff == 1 ? $diff . ' hour ago' : $diff . ' hours ago';
		}    
	
		if ($diff >= $intervals['day'] && $diff < $intervals['week'])
		{
			$diff = floor($diff/$intervals['day']);
			return $diff == 1 ? $diff . ' day ago' : $diff . ' days ago';
		}    
	
		if ($diff >= $intervals['week'] && $diff < $intervals['month'])
		{
			$diff = floor($diff/$intervals['week']);
			return $diff == 1 ? $diff . ' week ago' : $diff . ' weeks ago';
		}    
	
		if ($diff >= $intervals['month'] && $diff < $intervals['year'])
		{
			$diff = floor($diff/$intervals['month']);
			return $diff == 1 ? $diff . ' month ago' : $diff . ' months ago';
		}    
	
		if ($diff >= $intervals['year'])
		{
			$diff = floor($diff/$intervals['year']);
			return $diff == 1 ? $diff . ' year ago' : $diff . ' years ago';
		}
	}
	//Shorten String
	function shorten_string($phrase, $max_words) {

		$phrase_array = explode(' ',$phrase);

		if(count($phrase_array) > $max_words && $max_words > 0){

			$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}

		return $phrase;

	}
}
?>