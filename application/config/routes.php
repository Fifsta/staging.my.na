<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'my_na';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//$controller_exceptions = array('a','my_admin','members','business');
//APP FORGOT PASSWORD
$route["app/index/hello"] = 'app/forgot-password/';

//$controller_exceptions = array('a','my_admin','members','business');
//CLEAN PAGES
$route["page/(:any)"] = 'my_na/pages/$1';

//CLEAN LISTING PAGES
$route["b/(:num)/(:any)"] = 'business/view/$1/$2';
$route["b/(:num)"] = 'business/view/$1/';

//CLEAN DEALS
$route["deal/(:num)/(:any)"] = 'deals/show/$1/$2';
//$route["^((?!\b".implode('\b|\b', $controller_exceptions)."\b).*)$"] = 'page/$1';

//CLEAN PRODUCTS
$route["product"] = 'trade/product/';
$route["product/(:num)/(:any)"] = 'trade/product/$1/$2';
$route["product/(:num)"] = 'trade/product/$1';

//CLEAN PRODUCT CATEGORIES
$route["cat/(:any)"] = 'trade/cat/$1';

//CLEAN PRODUCT CATEGORIES
$route["buy/(.+)"] = 'trade/results/$1';

//REDIRECT local assets to S3
$route["assets/(:any)"] = 'assets/index/$1';

//Restauran Guide
$route["restaurants"] = 'my_na/restaurants';

//URL SHORTENER
$route["u/(:any)"] = 'u/index/$1'; 