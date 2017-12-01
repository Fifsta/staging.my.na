<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( session_status() == PHP_SESSION_NONE ) {
	session_start();
}

// Autoload the required files
//require_once( APPPATH . 'libraries/facebook/vendor/autoload.php' );

require_once( APPPATH . 'libraries/facebook/Facebook/HttpClients/FacebookHttpable.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/HttpClients/FacebookCurl.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/HttpClients/FacebookCurlHttpClient.php' );

require_once( APPPATH . 'libraries/facebook/Facebook/Entities/AccessToken.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/Entities/SignedRequest.php' );

require_once( APPPATH . 'libraries/facebook/Facebook/FacebookSession.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRedirectLoginHelper.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRequest.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookResponse.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookSDKException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRequestException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookOtherException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookAuthorizationException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/GraphObject.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/GraphSessionInfo.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookPermissionException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookRequestException.php' );
require_once( APPPATH . 'libraries/facebook/Facebook/FacebookServerException.php' );


use Facebook\HttpClients\FacebookHttpable;
use Facebook\HttpClients\FacebookCurl;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\Entities\AccessToken;
use Facebook\Entities\SignedRequest;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
use Facebook\FacebookPermissionException;
use Facebook\FacebookServerException;

class Facebook_long {
	var $ci;
	var $helper;
	var $session;
	var $permissions;

	public function __construct($token) {
		$this->ci =& get_instance();
		$this->ci->load->config('facebook');
		$this->permissions = $this->ci->config->item('permissions');

		// Initialize the SDK
		FacebookSession::setDefaultApplication( $this->ci->config->item('api_id'), $this->ci->config->item('app_secret') );


		$this->helper = new FacebookRedirectLoginHelper( $token['redirect_url'] );

		//$a = file_get_contents('https://graph.facebook.com/oauth/access_token?client_id='. $this->ci->config->item('api_id').'&client_secret='.$this->ci->config->item('app_secret').'&grant_type=client_credentials&redirect_uri=https://www.my.na/');
		$accessToken = $token['token'];


		if ( $token['token'] != '' ) {
			$this->session = new FacebookSession( $token['token'] );
			//EXTEND SESSION
			$response = (new FacebookRequest($this->session, 'POST', '/oauth/access_token', array(
				'grant_type' => 'fb_exchange_token',
				'client_id' => $this->ci->config->item('api_id'),
				'client_secret' => $this->ci->config->item('app_secret') ,
				'fb_exchange_token' => $accessToken)))->execute()->getGraphObject()->asArray();

			//var_dump($response);
			$this->access_token = $response['access_token'];

			//echo 'Second: '.$this->access_token.'<br />';
			$this->session = new FacebookSession($this->access_token);
			// Validate the access_token to make sure it's still valid
			try {
				if ( ! $this->session->validate() ) {
					$this->session = null;
				}
			} catch ( Exception $e ) {
				// Catch any exceptions
				$this->session = null;
			}
		} else {
			// No session exists
			try {
				$this->session = $this->helper->getSessionFromRedirect();
				//echo 'redirect attempt';
			} catch( FacebookRequestException $ex ) {
				// When Facebook returns an error
				//echo 'no ';
			} catch( Exception $ex ) {
				// When validation fails or other local issues
				//echo 'fail ';
			}
		}

		if ( $this->session ) {
			//$this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );

			$this->session = new FacebookSession( $this->session->getToken() );

			//EXTEND SESSION
			$response = (new FacebookRequest($this->session, 'POST', '/oauth/access_token', array(
				'grant_type' => 'fb_exchange_token',
				'client_id' => $this->ci->config->item('api_id'),
				'client_secret' => $this->ci->config->item('app_secret') ,
				'fb_exchange_token' => $this->session->getToken())))->execute()->getGraphObject()->asArray();

			$this->access_token = $response['access_token'];

			//echo 'Second: '.$this->access_token.'<br />';
			$this->session = new FacebookSession($this->access_token);
			// Validate the access_token to make sure it's still valid
			//echo 'Session Exists';
		}else{

			echo 'No Session';

		}
		//var_dump($this->session);

	}



	/**
	 * GET NEW TOKEN
	 */
	public function get_new_token() {

		//get My User ID if you don't know

		return $this->access_token;

	}

	/**
	 * GET MY USER ID
	 */
	public function get_account() {

		//get My User ID if you don't know

		$response = (new FacebookRequest( $this->session, 'GET', '/me' ,  array( 'fields' => 'id' ) ))
			->execute()->getGraphObject()->asArray();

		return $meId=$response['id'];

	}

	/**
	 * GET MY ACCOUNTS/PAGES
	 */
	public function get_pages() {


		//get Tokes for all my pages the page that you are usig will have a never expire token
		//you can prove on https://developers.facebook.com/tools/debug/
		$meId = $this->get_account();
		$response = (new FacebookRequest( $this->session, 'GET', '/'.$meId.'/accounts' ))
			->execute()->getGraphObject()->asArray();

		var_dump($response);

	}
	/**
	 * FACEBOOK POST TO PAGE
	 */
	function post_to_page($var)
	{

		//var_dump( $this->helper );
		// make api call
		if ( $this->session ) {


			// get page access token
			$access_token = (new FacebookRequest( $this->session, 'GET', '/'.$this->ci->config->item('page_id'),  array( 'fields' => 'access_token' ) ))
						->execute()->getGraphObject()->asArray();

			// save access token in variable for later use
			$access_token = $access_token['access_token'];
			/**
			 */
			// post to page
			$page_post = (new FacebookRequest( $this->session, 'POST', '/'.$this->ci->config->item('page_id').'/feed', array(
				'access_token' => $access_token,
				'name' => $var['title'],
				'link' => $var['link'],
				'caption' => $var['caption'],
				'message' => $var['message'],
				'picture' => $var['image']
			) ))->execute()->getGraphObject()->asArray();


			return $page_post;
		}
		return false;

	}
    /**
     * FACEBOOK POST TO GROUP
     */
    function post_to_group($var)
    {
        error_reporting(E_ALL);
        //print_r( $this->session['accessToken'] );
        // make api call
        if ( $this->session ) {

            $access_token = $this->access_token;
            /**
             */
            // post to group
            $page_post = (new FacebookRequest( $this->session, 'POST', '/'.$this->ci->config->item('group_id').'/feed', array(
                'access_token' => $access_token,
                'name' => $var['title'],
                'link' => $var['link'],
                'caption' => $var['caption'],
                'message' => $var['message'],
                'picture' => $var['image']
            ) ))->execute()->getGraphObject()->asArray();


            return $page_post;
        }
        return false;

    }
	/**
	 * Returns the login URL.
	 */
	public function login_url() {
		return $this->helper->getLoginUrl( $this->permissions );

	}
	/**
	 * Returns the logout URL.
	 */
	public function logout_url() {
		return $this->helper->getLogoutUrl( $this->session, 'https://www.my.na/fb/logout/?redirect='.current_url('/') );
	}

	/**
	 * POST TO PAGE NEWS FEED
	 */
	public function post_page(){

	}

	/**
	 * Returns the current user's info as an array.
	 */
	public function get_user() {
		if ( $this->session ) {
			/**
			 * Retrieve User’s Profile Information
			 */
			// Graph API to request user data
			$request = ( new FacebookRequest( $this->session, 'GET', '/me' ) )->execute();

			// Get response as an array
			$user = $request->getGraphObject()->asArray();

			return $user;
		}
		return false;
	}
    /**
     * Returns the current user's Groups as an array.
     */
    public function get_groups() {
        if ( $this->session ) {
            /**
             * Retrieve User’s Profile Information
             */
            // Graph API to request user data
            $request = ( new FacebookRequest( $this->session, 'GET', '/me/groups' ) )->execute();

            // Get response as an array
            $user = $request->getGraphObject()->asArray();

            return $user;
        }
        return false;
    }

	/**
	 * TEST if Post Exists
	 */
	public function post_exists( $post_id) {
		if ( $this->session ) {
			/**
			 * Retrieve User’s Profile Information
			 */
			// Graph API to request user data
			$request = ( new FacebookRequest( $this->session, 'GET', '/'.$post_id ) )->execute();

			// Get response as an array
			$user = $request->getGraphObject()->asArray();

			return $user;
		}
		return false;
	}


}