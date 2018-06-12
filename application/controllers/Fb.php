<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Fb extends CI_Controller {

	/**
	 * My Na Page for this controller.
	 *Roland ihms
	 *
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('fb_model');
	
	}
	
	public function index()
	{
		$this->load->view('facebook/app1.php');
	}
	
	public function pagetab()
	{
		$this->load->view('facebook/page_tab.php');
	}

  	//+++++++++++++++++++++++++++
	//SAND BOX
	//++++++++++++++++++++++++++
	function sandbox()
	{
			
		$this->load->view('facebook/sandbox');	
			
			
	}


  //+++++++++++++++++++++++++++
	//REGISTER MEMBER WITHOUT AJAX
	//++++++++++++++++++++++++++
	function login_test()
	{
					$this->session->set_userdata('id', 1806);
					$this->session->set_userdata('u_name', 'jonny' );
					
					$this->session->set_userdata('img_file', 'https://graph.facebook.com/10152320160580965/picture/?width=60&height=60');
					$this->session->set_userdata('points', $this->my_na_model->count_points(1806));
					$this->session->set_flashdata('login', 'yes');	
	}
	

    //+++++++++++++++++++++++++++
	//FACEBOOK LOGIN
	//++++++++++++++++++++++++++
	function login2()
	{

	}
	
	

	
    //+++++++++++++++++++++++++++
	//FACEBOOK LOGIN
	//++++++++++++++++++++++++++
	function login($status = '')
	{
		//error_reporting(E_ALL);
		
		
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
		
		//KILL IF EMAIL EMPTY
		if($email == ''){
			die();
			echo 'FALSE';	
		}
		
		if($gender == 'male'){
			$gender = 'M';	
		}else{
			
			$gender = 'F';	
		}
		
		
		//NO SESSION
		if(!$this->session->userdata('id')){
			
			//GET USER IF EMAIL MATCHES 
			$this->db->where('CLIENT_EMAIL' , $email);
			$this->db->from('u_client');
			$query = $this->db->get();
			
			//IF EMAIL FOUND
			if($query->result()){
				$row = $query->row_array();
				
				if($row['FB_LOGOUT'] == 'N'){
					
					//UPDATE MY>NA WITH NEW CREDENTIALS
					$this->fb_model->update_existing($row['ID']);	
					echo 'TRUE';		  
				}elseif($status == 'register'){
					
					//UPDATE MY>NA WITH NEW CREDENTIALS
					$this->fb_model->update_existing($row['ID']);	
					echo 'TRUE';
				}else{
					
					echo 'FALSE';
				}

			//REGISTER NEW
			}else{
				
				if($status == 'register'){
					//REGISTER NEW ON MY.NA
					$this->fb_model->register_fb();	
					echo 'TRUE';
				}else{
					
					echo 'FALSE';
				}
				
			}
			
		
		//LOGGED IN
		}else{

			//MATCH SESSION AND MAKE SURE NOT 0
			if($this->session->userdata('fb_id') == $id && $this->session->userdata('fb_id') != 0){
				
				//echo 'Logged in';
				//UPDATE SESSION

                $data = array(

                        'id' => $this->session->userdata('id'),
                        'u_name' => $fname. ' ' .$sname ,
                        'img_file' => $pic,
                        'fb_id' => $id,
                        'points' => $this->my_na_model->count_points($this->session->userdata('id')),


                );
                $this->session->set_userdata($data);
                $this->session->set_flashdata('login', 'yes');
				//UPDATE MY>NA WITH NEW CREDENTIALS
				//$this->fb_model->update_existing($this->session->userdata('id'));
			}
			echo 'FALSE';
		}
	  

	}


	//+++++++++++++++++++++++++++
	//FACEBOOK GET ACCESS TOKEN
	//++++++++++++++++++++++++++
	function logout()
	{


		$this->session->unset_userdata('fb_token');
		$this->session->unset_userdata('fb_id');
		$this->session->unset_userdata('id');
		if($this->input->get('redirect')){

			redirect($this->input->get('redirect'), 301);
		}else{
			session_unset();
			session_destroy();
			header('Refresh: 2; URL=https://www.my.na/NEW/facebook/post_to_page.php');
		}



	}

	//+++++++++++++++++++++++++++
	//FACEBOOK POST TO PAGE
	//++++++++++++++++++++++++++
	function long_term()
	{
		error_reporting(E_ALL);
		$this->load->library('facebook_long');
		//get your access token for the app that you will use in
		$this->facebook_long->get_pages();
	}


	//+++++++++++++++++++++++++++
	//FACEBOOK GET ACCESS TOKEN
	//++++++++++++++++++++++++++
	function get_code()
	{


		if($this->input->get('code'))
		{


			return $this->input->get('code');

		}

		//$this->input->get('code');

	}
	//+++++++++++++++++++++++++++
	//FACEBOOK GET ACCESS TOKEN
	//++++++++++++++++++++++++++
	function get_user()
	{


		$this->load->library('facebook');
		//$login_url = $this->facebook->get_user();
		//echo $login_url;https://www.facebook.com/logout.php?next=http%3A%2F%2Flocalhost%2Fclients.my.na%2Ffb%2Flogout%2F%3Fredirect%3Dhttp%3A%2F%2Flocalhost%2Fclients.my.na%2Findex.php%2Ffb%2Fpost_to_page&access_token=CAAEFVH0guhsBAK9sBZAVCMO1NyZBgOLa6r4FKZCxauJDqPrFZC75SS8dE0vF2ujtyd4OfJ7jeobDwa13pWcJtRHQwS4uvZAsd6q49NV3AgOlm37bhA3UuPnCz8cdMFwfcrOZCJg16p0Wsb6vLQcqf5HqPI4ZCtSM93jQDRmAuecZAIyFFunvFyZAKCdXNXS8JsYDssK4z6gAw2be8YVEnSyaA

		$this->facebook->get_user();



	}

	//+++++++++++++++++++++++++++
	//FACEBOOK POST TO PAGE
	//++++++++++++++++++++++++++
	function post_to_my_page($title = 'Test', $caption = 'This is my caption', $message = 'Here is my message', $link = '' , $image = '')
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
		$var['title'] = $title;
		$var['message'] = $message;
		$var['caption'] = $caption;
		$var['image'] = $image;
		$var['link'] = $link;
		$page_post = $this->facebook_long->post_to_page($var);
		print_r( $page_post );

		//NEW TOKEN
		$new = $this->facebook_long->get_new_token();
		//UPDATE DB
		$data['fb_token'] = $new;
		$this->db->where('fb_token', $token);
        $this->db->where('type', 'page');
		$this->db->update('facebook', $data);

	}

	//+++++++++++++++++++++++++++
	//FACEBOOK POST PRODUCT TO PAGE
	//++++++++++++++++++++++++++
	function post_product_to_my_page($id)
	{
        $page_post  = $this->fb_model->post_product_to_my_page($id);
        print_r( $page_post );

		//print_r( $page_post );
	}

    //+++++++++++++++++++++++++++
    //FACEBOOK POST PRODUCT TO PAGE
    //++++++++++++++++++++++++++
    function post_product_to_my_group($id)
    {
        $page_post  = $this->fb_model->post_product_to_my_group($id);
        print_r( $page_post );
    }


	//+++++++++++++++++++++++++++
	//TESTING
	//++++++++++++++++++++++++++
	function test()
	{


		error_reporting(E_ALL);
        $config = array('redirect_url' => current_url('/'));
        $this->load->library('facebook', $config);

		//echo $login_url;

		//$this->facebook->post_page();


		if($this->session->userdata('fb_token')){
			print_r($this->facebook->get_user());
			//print_r($this->facebook->post_page());
			echo 'Token: '.$this->session->userdata('fb_token').'<br />';
			echo '<a href="' . $this->facebook->logout_url() . '">Logout</a>';
		}else{

			echo 'No Token <br />';
			echo '<a href="' . $this->facebook->login_url() . '">Login</a>';

		}
		$sections = array(
			'session'  => TRUE,
			'queries' => FALSE
		);

		$this->output->set_profiler_sections($sections);
		$this->output->enable_profiler(TRUE);

	}




	//+++++++++++++++++++++++++++
	//FACEBOOK POST TO PAGE
	//++++++++++++++++++++++++++
	function post_to_page_static()
	{


		/*session_start();
		//require(BASE_URL."application/third_party/facebook/php_SDK/autoload.php"); // set the right path
		define('FACEBOOK_SDK_V4_SRC_DIR', BASE_URL.'application/third_party/facebook/php_SDK/');


		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookSession.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookRedirectLoginHelper.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookRequest.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookResponse.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookSDKException.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookRequestException.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/FacebookAuthorizationException.php' );
		require_once( FACEBOOK_SDK_V4_SRC_DIR.'src/Facebook/GraphObject.php' );


		use Facebook\FacebookRedirectLoginHelper;
		use Facebook\FacebookRequest;
		use Facebook\FacebookResponse;
		use Facebook\FacebookSDKException;
		use Facebook\FacebookRequestException;
		use Facebook\FacebookAuthorizationException;
		use Facebook\GraphObject;


		FacebookSession::setDefaultApplication('287335411399195', '379f840088107330185ff812bb7ff829');


		// login helper with redirect_uri
		$helper = new FacebookRedirectLoginHelper( site_url('/').'fb/get_code/' );

		try {
			$session = $helper->getSessionFromRedirect();
		} catch( FacebookRequestException $ex ) {
			// When Facebook returns an error
		} catch( Exception $ex ) {
			// When validation fails or other local issues
		}

		// see if we have a session
		if ( isset( $session ) ) {
			// graph api request for user data
			$request = new FacebookRequest( $session, 'GET', '/me' );
			$response = $request->execute();
			// get response
			$graphObject = $response->getGraphObject();

			// print data
			echo  print_r( $graphObject, 1 );
		} else {
			// show login url
			echo '<a href="' . $helper->getLoginUrl() . '">Login</a>';
		}*/



	}

	//+++++++++++++++++++++++++++
	//REWARD USER FOR SHARING VIA SDK
	//++++++++++++++++++++++++++
	function fb_share_callback() {

		if($this->session->userdata('id')){

			$post_id = $this->input->post('post_id');

			echo $post_id;

			$user_id = substr($post_id,0,strpos($post_id, '_'));
			$postID = substr($post_id, strpos($post_id, '_') + 1, strlen($post_id));

			$url = 'https://www.facebook.com/'.$user_id.'/posts/'.$postID;


			$q = $this->db->get('facebook');
			if($q->result()){

				$row = $q->row();
				$token = $row->fb_token;
			}else{
				$token = 'CAAEFVH0guhsBAAHU6LXcmtz4sW0nTTZBMoNQJKWDbjhavPGyfJ9Amr2kfmluZBIwR2Q9WQfQuMiz6opZAuqhEDZArTKtZA2ou2YQPdrClaZB3HxgROf3XpjrhC815ou7PlLMhDuQhkLG3cXBGCLlf4xagGzBltLBgO2m6wSyP3oJmYGbSEO4lbd06vbSFWCxq1yml7HgIZCx4tLr2oVmkg0';
			}

			$config = array('token' => $token, 'redirect_url' => current_url('/'));
			$this->load->library('facebook_long', $config);

			$out = $this->facebook_long->post_exists($post_id);
			//print_r($out);

			if(is_array($out)){

				//echo 'Yessss';
				//GIVE CLIENT 3 FREE POINTS
				$this->load->model('business_model');
				$this->business_model->update_client_point($this->session->userdata('id'), '3', $post_id, 'fb_share');

			}


		}


	}


	//+++++++++++++++++++++++++++
	//REWARD USER FOR SHARING VIA SDK
	//++++++++++++++++++++++++++
	function fb_share_callback_($post_id) {

		//if($this->session->userdata('id')){

			//$post_id = $this->input->post('post_id');

			echo $post_id;

			$user_id = substr($post_id,0,strpos($post_id, '_'));
			$postID = substr($post_id, strpos($post_id, '_') + 1, strlen($post_id));

			$url = 'https://www.facebook.com/'.$user_id.'/posts/'.$postID;

			echo $url;


			$q = $this->db->get('facebook');
			if($q->result()){

				$row = $q->row();
				$token = $row->fb_token;
			}else{
				$token = 'CAAEFVH0guhsBAAHU6LXcmtz4sW0nTTZBMoNQJKWDbjhavPGyfJ9Amr2kfmluZBIwR2Q9WQfQuMiz6opZAuqhEDZArTKtZA2ou2YQPdrClaZB3HxgROf3XpjrhC815ou7PlLMhDuQhkLG3cXBGCLlf4xagGzBltLBgO2m6wSyP3oJmYGbSEO4lbd06vbSFWCxq1yml7HgIZCx4tLr2oVmkg0';
			}

			$config = array('token' => $token, 'redirect_url' => current_url('/'));
			$this->load->library('facebook_long', $config);

			$out = $this->facebook_long->post_exists( $post_id);
			print_r($out);
			/*$out = (get_headers($url));

			print_r($out);

			echo $out[0];

			if($out[0] == 'HTTP/1.1 200 Ok'){*/

			//GIVE CLIENT 3 FREE POINTS
			//$this->load->model('business_model');
			//$this->business_model->update_client_point($this->session->userdata('id'), '3', $post_id, 'fb_share');

			/*}*/


		//}


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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */