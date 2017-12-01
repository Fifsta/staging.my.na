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

class Facebook {
	var $ci;
	var $helper;
	var $session;
	var $permissions;

	public function __construct() {
		$this->ci =& get_instance();
		$this->ci->load->config('facebook');
		$this->permissions = $this->ci->config->item('permissions');

		// Initialize the SDK
		FacebookSession::setDefaultApplication( $this->ci->config->item('api_id'), $this->ci->config->item('app_secret') );

		// Create the login helper and replace REDIRECT_URI with your URL
		// Use the same domain you set for the apps 'App Domains'
		// e.g. $helper = new FacebookRedirectLoginHelper( 'http://mydomain.com/redirect' );
		$this->helper = new FacebookRedirectLoginHelper( $this->ci->config->item('redirect_url') );

		if ( $this->ci->session->userdata('fb_token') ) {
			$this->session = new FacebookSession( $this->ci->session->userdata('fb_token') );

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

			} catch( FacebookRequestException $ex ) {
				// When Facebook returns an error
				echo 'no ';
			} catch( Exception $ex ) {
				// When validation fails or other local issues
				echo 'fail ';
			}
		}

		if ( $this->session ) {
			$this->ci->session->set_userdata( 'fb_token', $this->session->getToken() );

			$this->session = new FacebookSession( $this->session->getToken() );
		}else{

			echo 'No Session';

		}
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
		return $this->helper->getLogoutUrl( $this->session, 'https://www.my.na/fb/logout/?redirect=' );
	}

	/**
	 * POST TO PAGE NEWS FEED
	 */
	public function post_page(){

		//var_dump( $this->helper );
		// make api call
		if ( $this->session ) {
			/**
			 * Retrieve User’s Profile Information
			 */
			// Graph API to request user data
			$response = (new FacebookRequest(
				$this->session, 'POST', '/me/feed', array(
					'message' => 'testing'
				)
			))->execute()->getGraphObject()->asArray();


			return $response;
		}
		return false;
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
}