<?php 

error_reporting(E_ALL); 
ini_set('memory_limit','512M');
set_time_limit(1000);

define('BASE_URL', '/var/www/my.na/public_html/');

$src = '';
if(isset($_GET["src"])){

	$src = 	$_GET["src"].'/';

}



require 'aws-autoloader.php';
use Aws\S3\S3Client;

try {
	// echo 'POES1';
	//encryption password for server 2 lzfwxzzzphhd
	$client = S3Client::factory(array(
		'key'    => 'AKIAJDJ43LVB5PMFA2FA',
		'secret' => '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'
	));
	// echo 'POES2';
	//$client->uploadDirectory(BASE_URL.'assets/documents/', 'mynamibia-eu');
	//var_dump($client);
	$dir = BASE_URL.'';
	$bucket = 'mynamibia-eu';
	$keyPrefix = 'assets/products/'.$src;
	$options = array(
		'params'      => array('ACL' => 'public-read'),
		'concurrency' => 20,
		'debug'       => true
	);
	// echo 'POES3';
	$client->downloadBucket($dir, $bucket, $keyPrefix, $options);

}catch(Exception $e) {
    echo $e->getMessage();
}

//echo BASE_URL;
$to = "roland@my.na";
$subject = "Assets Sync Amazon S3 D.O.";
$message = "We have succesfully synced the assets on the slave Digital Ocean";
$from = "no-reply@my.na";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";


?>