<?php
error_reporting(E_ALL);

/*		define('DB_HOST', 'localhost');
		define('DB_NAME', 'mynamplt_new');
		define('DB_USER', 'mynamplt_mynew');
		define('DB_PASSWORD', 'yM*IimHd.uo2');*/
define('BASE_URL', '/var/www/my.na/public_html/');
define('DB_HOST', 'localhost');
define('DB_NAME', 'mynamplt_mynew');
//define('DB_USER', 'root');
//define('DB_PASSWORD', 'my_na$erv3r');
define('DB_USER', 'mynamplt_new');
define('DB_PASSWORD', 'yM*IimHd.uo2');


$date = date('Y-m-d');
//$date = date('Y-m-d', strtotime( '- 1 day'));
echo $date;

$pathGZ = BASE_URL.'backup/mynamplt_new_'.$date.'.sql.gz';
$pathSQL = BASE_URL.'backup/mynamplt_new_'.$date.'.sql';

//if unzipped
if(file_exists($pathSQL)){



//GUNZIP
}elseif(file_exists($pathGZ)){

	//UNZIP
	system("gunzip ".$pathGZ." -d ".$pathSQL);
	echo 'Unzipped ';

}

//IMPORT
if(file_exists($pathSQL)){

	//$command = 'mysqldump --opt -h ' . DB_HOST . ' -u ' . DB_USER . ' -p\'' . DB_PASSWORD . '\' ' . DB_NAME . ' | gzip > ' . $backupFile;
	system("mysql -h " . DB_HOST . " -u '".DB_USER."' -p'".DB_PASSWORD."' ". DB_NAME ." < ".$pathSQL);
	//echo "mysql -h " . DB_HOST . " -u ".DB_USER." -p".DB_PASSWORD." ". DB_NAME ." < ".$path;

	//mysql -u root -ppakdwyejwxac mynamplt_new < /var/www/my.na/public_html/backup/products_my_db_2014-11-13.sql
	//mysql -h localhost -u mynadb -p%^&YHU&*_pop mynamplt_new < /var/www/my.na/public_html/backup/mynamplt_new_2015-04-28.sql

	echo 'Imported ';
}


echo $date;
$to = "roland@my.na";
$subject = "Imported Database D.O.";
$message = "We have succesfully imported the database \n\n";
$from = "no-reply@my.na";
$headers = "From:" . $from;
mail($to,$subject,$message,$headers);
echo "Mail Sent.";


?>