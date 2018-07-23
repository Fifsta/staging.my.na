<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/

if($_SERVER['HTTP_HOST'] == 'localhost'){

	define('FILE_READ_MODE', 0644);
	define('FILE_WRITE_MODE', 0666);
	define('DIR_READ_MODE', 0755);
	define('DIR_WRITE_MODE', 0777);
	define('BASE_URL', $_SERVER["DOCUMENT_ROOT"] .'/clients.my.na/');
	define('CMS_URL',  'http://localhost/My_cms/');
	define('CDN_URL',  'http://localhost/clients.my.na/');
	define('HUB_URL', 'https://localhost/nmh/');
}elseif($_SERVER['HTTP_HOST'] == 'aws.my.na'){

	define('FILE_READ_MODE', 0644);
	define('FILE_WRITE_MODE', 0666);
	define('DIR_READ_MODE', 0755);
	define('DIR_WRITE_MODE', 0777);
	define('BASE_URL', $_SERVER["DOCUMENT_ROOT"]);
	define('CMS_URL',  'http://cms.my.na/');
	define('CDN_URL',  'https://d3rp5jatom3eyn.cloudfront.net/');
	define('HUB_URL', 'https://nmh.my.na/');

}else{

	define('FILE_READ_MODE', 0644);
	define('FILE_WRITE_MODE', 0666);
	define('DIR_READ_MODE', 0755);
	define('DIR_WRITE_MODE', 0777);
	define('BASE_URL', $_SERVER["DOCUMENT_ROOT"]);
	define('CMS_URL',  'https://cms.my.na/');
	define('CDN_URL',  'https://d3rp5jatom3eyn.cloudfront.net/');
	define('HUB_URL', 'https://nmh.my.na/');

}
define('EVENTS_URL', 'https://events.my.na/');
define('BUS_ID', 1290);

define('S3_URL',  'https://d3rp5jatom3eyn.cloudfront.net/');
//http://d3rp5jatom3eyn.cloudfront.net/
///https://storage.googleapis.com/my-na-bucket-eu/'
/*http://mynamibia.s3-website-us-east-1.amazonaws.com/
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */