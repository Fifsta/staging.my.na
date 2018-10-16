<?php
class Cron_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	

	//+++++++++++++++++++++++++++
	//OPTIMIZE DATABASE
	//++++++++++++++++++++++++++
	public function optimize_db()
	{
		$this->load->dbutil();
		$result = $this->dbutil->optimize_database();
		//$result = $this->dbutil->optimize_table('u_business');
		$out = '';
		if ($result !== FALSE)
		{
			//print_r($result);

			foreach($result as $row => $key){

				if($row == 'Table'){

					//echo $row . ' '.$key. '<br />';

				}
				$out .=  $row . ' ';

				if(is_array($key)){

					foreach($key as $sub){

						$out .= $sub. ' -- ';


					}
					$out .=  '<br />';

				}

				//print_r($row).'<br />';

			}

		}
		echo $out;
		return $out;
	}




	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db_system()
	{

		/* 
		 * This script only works on linux.
		 * It keeps only 31 backups of past 31 days, and backups of each 1st day of past months.
		 */
		error_reporting(E_ALL);
		ini_set('memory_limit','1024M');
		set_time_limit(7200);
		//$this->load->database();
		//echo $this->db->username;

		$host = $this->db->hostname;
		$user = $this->db->username;
		$pass = $this->db->password;
		$dbname = $this->db->database;

		/*define('DB_HOST', 'localhost');
		define('DB_NAME', 'mynamplt_mynew');
		define('DB_USER', 'mynamplt_new');
		define('DB_PASSWORD', 'yM*IimHd.uo2');*/
		
		$date = date('Y-m-d');
		 
		$backupFile = BASE_URL . 'backup/' . $dbname . '_' . $date . '.sql.gz';
		if (file_exists($backupFile)) {
			unlink($backupFile);
		}
		$command = 'mysqldump --opt -h ' . $host . ' -u ' . $user . ' -p\'' . $pass . '\' ' . $dbname . ' | gzip > ' . $backupFile;

		echo $command;


		$out = system($command);

		//UPLOAD S3
		$this->upload_s3('backup/' . $dbname . '_' . $date . '.sql.gz');

		//SEND TO BUCKET
		//$this->load->model('gcloud_model');
		//$out = $this->gcloud_model->upload_gc_bucket($config['upload_path'] . $file , '/assets/users/photos/');

		return $out;
		
	}
	
	
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db()
	{
		error_reporting(E_ALL); 
		ini_set('memory_limit','512M');
		set_time_limit(7200);
		$this->load->dbutil();
		$name = 'general_my_db_'.date('Y-m-d');
		$prefs = array(
                'tables'      => array( 'u_client',
										'u_business',
										'u_business_map',
										'u_business_messages',
										'u_business_na',
										'u_business_vote',
	                                    /*'u_business_clicks',*/
										'u_client_points',
										'u_client_points_summary',
										'a_tourism_category',
										'a_tourism_category_sub',
										'business_contacts',
										'images',
										'i_client_business',
										'i_client_business_claims',
										'i_tourism_category',
										'news',
										'pages',

										),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'gzip',             // gzip, zip, txt
                'filename'    => $name.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs);

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file(BASE_URL.'backup/'.$name.'.sql.gz', $backup);
		
		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download($name.'.gz', $backup);
		
		//UPLOAD S3
		$this->upload_s3('backup/'.$name.'.sql.gz');
		 
	}


	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db_business()
	{
		error_reporting(E_ALL);
		ini_set('memory_limit','512M');
		set_time_limit(7200);
		$this->load->dbutil();
		$name = 'general_my_db_'.date('Y-m-d');
		$prefs = array(
			'tables'      => array( 'u_client',
				/*'u_business',
				'u_business_map',
				'u_business_messages',
				'u_business_na',
				'u_business_vote',*/
				'u_business_clicks',
				/*'u_business_enquiries',
				'u_client_points',
				'u_client_points_summary',
				'a_tourism_category',
				'a_tourism_category_sub',
				'business_contacts',
				'images',
				'i_client_business',
				'i_client_business_claims',
				'i_tourism_category',
				'news',
				'pages',*/

			),  // Array of tables to backup.
			'ignore'      => array(),           // List of tables to omit from the backup
			'format'      => 'gzip',             // gzip, zip, txt
			'filename'    => $name.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
			'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
			'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
			'newline'     => "\n"               // Newline character used in backup file
		);
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs);

		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file(BASE_URL.'backup/'.$name.'.sql.gz', $backup);

		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download($name.'.gz', $backup);

		//UPLOAD S3
		$this->upload_s3('backup/'.$name.'.sql.gz');

	}


	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db_analytics()
	{
		error_reporting(E_ALL); 
		ini_set('memory_limit','2048M');
		set_time_limit(7200);
		$this->load->dbutil();
		$name = 'analytics_2014_1-6_';//.date('Y-m-d');
		$prefs = array(
                'tables'      => array(	/*'email_queue_log',
										'u_business_clicks',
										'u_business_impressions',*/
										/*'u_business_impressions_2013_01',
										'u_business_impressions_2013_02',
										'u_business_impressions_2013_03',
										'u_business_impressions_2013_04',
										'u_business_impressions_2013_05',
										'u_business_impressions_2013_06',
										'u_business_impressions_2013_07',
										'u_business_impressions_2013_08',
										'u_business_impressions_2013_09',
										'u_business_impressions_2013_10',
										'u_business_impressions_2013_11',
										'u_business_impressions_2013_12',*/
										'u_business_impressions_2014_01',
										'u_business_impressions_2014_02',
										'u_business_impressions_2014_03',
										'u_business_impressions_2014_04',
										'u_business_impressions_2014_05',
										'u_business_impressions_2014_06',
/*										'u_business_impressions_2014_07',
										'u_business_impressions_2014_08',
										'u_business_impressions_2014_09',
										'u_business_impressions_2014_10'*/),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'gzip',             // gzip, zip, txt
                'filename'    => $name.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs); 
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file(BASE_URL.'backup/'.$name.'.sql.gz', $backup); 
		
		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download($name.'.gz', $backup);
		
		//UPLOAD S3
		$this->upload_s3('backup/'.$name.'.sql.gz');
		 
	}


	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db_products()
	{
		error_reporting(E_ALL); 
		ini_set('memory_limit','512M');
		set_time_limit(7200);
		$this->load->dbutil();
		$name = 'products_my_db_'.date('Y-m-d');
		$prefs = array(
                'tables'      => array( 'adverts', 
										'advert_tracking',
										'products',
										'products_buy_now',
										'products_watchlist',
										'product_auction_bids',
										'product_categories',
										'product_extras',
										'product_images',
										'product_questions'
										),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'gzip',             // gzip, zip, txt
                'filename'    => $name.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs); 
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file(BASE_URL.'backup/'.$name.'.sql.gz', $backup);
		
		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download($name.'.gz', $backup);
		
		//UPLOAD S3
		$this->upload_s3('backup/'.$name.'.sql.gz');
		 
	}

	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db_other()
	{
		error_reporting(E_ALL); 
		ini_set('memory_limit','1024M');
		set_time_limit(7200);
		$this->load->dbutil();
		$name = 'other_my_db_'.date('Y-m-d');
		$prefs = array(
                'tables'      => array( ),  // Array of tables to backup.
                'ignore'      => array( 'u_client', 
										'u_business',
										'u_business_map',
										'u_business_messages',
										'u_business_na',
										'u_business_vote',
										'u_client_points',
										'u_client_points_summary',
										'a_tourism_category',
										'a_tourism_category_sub',
										'business_contacts',
										'images',
										'i_client_business',
										'i_client_business_claims',
										'i_tourism_category',
										'news',
										'pages','adverts', 
										'advert_tracking',
										'products',
										'products_buy_now',
										'products_watchlist',
										'product_auction_bids',
										'product_categories',
										'product_extras',
										'product_images',
										'product_questions',
										/*Analytics*/
										'email_queue_log',
										'u_business_clicks',
										'u_business_impressions',
										'u_business_impressions_2013_01',
										'u_business_impressions_2013_02',
										'u_business_impressions_2013_03',
										'u_business_impressions_2013_04',
										'u_business_impressions_2013_05',
										'u_business_impressions_2013_06',
										'u_business_impressions_2013_07',
										'u_business_impressions_2013_08',
										'u_business_impressions_2013_09',
										'u_business_impressions_2013_10',
										'u_business_impressions_2013_11',
										'u_business_impressions_2013_12',
										'u_business_impressions_2014_01',
										'u_business_impressions_2014_02',
										'u_business_impressions_2014_03',
										'u_business_impressions_2014_04',
										'u_business_impressions_2014_05',
										'u_business_impressions_2014_06',
										'u_business_impressions_2014_07',
										'u_business_impressions_2014_08',
										'u_business_impressions_2014_09',
										'u_business_impressions_2014_10'),
										          // List of tables to omit from the backup
                'format'      => 'gzip',             // gzip, zip, txt
                'filename'    => $name.'.sql',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup($prefs); 
		
		// Load the file helper and write the file to your server
		$this->load->helper('file');
		write_file(BASE_URL.'backup/'.$name.'.sql.gz', $backup); 
		
		// Load the download helper and send the file to your desktop
		//$this->load->helper('download');
		//force_download($name.'.gz', $backup);
		
		//UPLOAD S3
		$this->upload_s3('backup/'.$name.'.sql.gz');
		 
	}


	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function send_s3($path)
	{

	    $this->load->spark('amazon-sdk/1.5.4');
		$s3 = $this->awslib->get_s3();
		$result = $s3->list_buckets();
		echo '<pre>' . print_r($result, TRUE) . '</pre>';	 
	}


	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function upload_s3($path)
	{
		  //error_reporting(E_ALL); 
		  $filename = $path;
		  $base = BASE_URL.$path;
	      // Load Library
		  $this->load->library('s3');
		/**
		 * Put an object
		 *
		 * @param mixed $input Input data
		 * @param string $bucket Bucket name
		 * @param string $uri Object URI
		 * @param constant $acl ACL constant
		 * @param array $metaHeaders Array of x-amz-meta-* headers
		 * @param array $requestHeaders Array of request headers or content type as a string
		 * @param constant $storageClass Storage class constant
		 * @param constant $serverSideEncryption Server-side encryption
		 * @return boolean
		 */
		  //$input = $this->s3->inputResource(fopen($base, "rb"), filesize($base));
		  $input = $this->s3->inputFile($filename);
		  return $this->s3->putObject($input, 'mynamibia-eu', $filename, 'public-read');
		  
		  
		  //var_dump($this->s3->putBucket('my.na', $this->s3->ACL_PUBLIC_READ));
		  
		  // List Buckets
		  //var_dump($this->s3->listBuckets());
	}

	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function exists_upload_s3($path)
	{
		  //error_reporting(E_ALL); 
		  $filename = $path;
		  $base = BASE_URL.$path;
	      // Load Library
		  $this->load->library('s3');
		/**
		 * Put an object
		 *
		 * @param mixed $input Input data
		 * @param string $bucket Bucket name
		 * @param string $uri Object URI
		 * @param constant $acl ACL constant
		 * @param array $metaHeaders Array of x-amz-meta-* headers
		 * @param array $requestHeaders Array of request headers or content type as a string
		 * @param constant $storageClass Storage class constant
		 * @param constant $serverSideEncryption Server-side encryption
		 * @return boolean
		 */
		  //$input = $this->s3->inputResource(fopen($base, "rb"), filesize($base));
		  //$input = $this->s3->inputFile($filename);
		  //return $this->s3->putObject($input, 'mynamibia-eu', $filename, 'public-read');
		  return $this->s3->getObjectInfo('mynamibia-eu', $filename, true);

	}

	//+++++++++++++++++++++++++++
	//DAILY CLIENT EMAIL PREVIEW
	//++++++++++++++++++++++++++
	
	public function preview_daily_email($client_id){
		
		//IF fisrt load
		$x = 0;
		/*echo '<link rel="stylesheet" type="text/css" href="'.base_url('/').'css/jquery.countdown.css">
			  <script type="text/javascript" src="'.base_url('/').'js/jquery.countdown.min.js"></script>
			  <div id="fb-root"></div>
			  <script src="http://connect.facebook.net/en_US/all.js"></script>
			  <div id="deal_msg_"></div>
			 ';*/
		
		$this->db->where('ID', $client_id);
		$query = $this->db->get('u_client');
		  
		$row = $query->row_array();
  		//ECHO FIRST PARAGRAPH
  		echo 'Hi '.$row['CLIENT_NAME'].',<em style="float:right" align="right">'.date('l jS \of F Y ').'</em>
			  <p>Here is your daily dose of news headlines from Namibia and around the world, some great promotions and everything !na.</p>';	
		
  		$this->show_points_sml($client_id);

		$this->show_sdvert_preview($query = '');
		$this->get_home_news_preview();
		$this->get_email_deal_preview($x);
		
		echo '<h2>News of the World</h2>';
		$this->get_world_news_preview($x, '3', 'world');
		echo '<h2>Sport Headlines</h2>';
		$this->get_world_news_preview($x, '3', 'sport');
		echo '<h2>Premier League</h2>';
		$this->get_sky_sports_news_preview($x, '4', 'premier_league');
		echo '<h2>Rugby</h2>';
		$this->get_sky_sports_news_preview($x, '4', 'rugby');
		$this->get_sky_sports_news_preview($x, '4', 'super_rugby');
		echo '<h2>Formula 1</h2>';
		$this->get_sky_sports_news_preview($x, '4', 'formula1');
		//ECHO na Day
  		echo '<p>Have a !na day</p>';	
	}
	
	
	//+++++++++++++++++++++++++++
	//DAILY CLIENT EMAIL
	//++++++++++++++++++++++++++
	
	public function send_daily_email($client_id, $name){
		
		//IF fisrt load
		$x = 0;

  		//ECHO FIRST PARAGRAPH
  		echo 'Hi '.$name.',<em style="float:right" align="right">'.date('l jS \of F Y ').'</em>
			  <p>Here is your daily dose of news headlines from Namibia and around the world, some great promotions and everything !na.</p>';	
		
  		$this->show_points_sml($client_id);
		//LOAD TYHE CACHED EMAIL HTML FILE
		$this->load->view('email/cache/daily_email.html');
	
	}
	
	//+++++++++++++++++++++++++++
	//DAILY CLIENT EMAIL GENERIC BODY
	//++++++++++++++++++++++++++
	
	public function daily_email_body(){
		
		
		$x = 0;
		
		$this->show_sdvert($query = '');
		$this->get_home_news();
		$this->get_email_deal($x);
		
		echo '<h2>News of the World</h2>';
		$this->get_world_news($x, '3', 'world');
		echo '<h2>Sport Headlines</h2>';
		$this->get_world_news($x, '3', 'sport');
		echo '<h2>Premier League</h2>';
		$this->get_sky_sports_news($x, '4', 'premier_league');
		echo '<h2>Rugby</h2>';
		$this->get_sky_sports_news($x, '4', 'rugby');
		$this->get_sky_sports_news($x, '4', 'super_rugby');
		echo '<h2>Formula 1</h2>';
		$this->get_sky_sports_news($x, '4', 'formula1');
		//ECHO na Day
  		echo '<p>Have a !na day</p>';	
	}
	
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET USER POINTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function show_points_sml($client_id){
		
		$this->db->where('CLIENT_ID', $client_id);
		$query = $this->db->get('u_client_points_summary');
		if($query->result()){
			
			$row = $query->row_array();
			//ADD 10 Daily POINTS if not 10
            if($row['POINTS'] < 10){
				
				$points = $this->update_client_point_summary($client_id, '10');	
				echo '<p><div align="right" style="float:right; display:inline-block"><img src="'.base_url('/').'img/na-icon.png" alt="My Na Points" style="display:inline-block" align="right" /><strong>'.($row['POINTS'] + 10).'</strong></div>Your current !na points are :</p><p>
				We have given you your daily 10 FREE my na points. Play scratch and win now.</p><p class="white_box"><a href="'.site_url('/').'win/scratch_and_win" target="_blank" title="Click here to play scratch and win"><img style="width:593px" width="593"  src="'.base_url('/').'img/scratch/scratch_win_big.jpg" alt="Scratch and Win online now" width="593" style="width:593px" /></a><p>';	
			}else{
				
				echo '<p><div align="right" style="float:right; display:inline-block"><img src="'.base_url('/').'img/na-icon.png" align="right" alt="My Na Points" style="float:left;display:inline-block"/><strong>'.$row['POINTS'].'</strong></div>Your current !na points are :</p><p>
				Play scratch and win now.</p><p class="white_box"><a href="'.site_url('/').'win/scratch_and_win" target="_blank" title="Click here to play scratch and win"><img src="'.base_url('/').'img/scratch/scratch_win_big.jpg" style="width:593px" width="593"  alt="Scratch and Win online now" /></a>
				<p>';
			}
                
			

			
		}else{
			
			$this->update_client_point_summary($client_id, '10');
				echo '<p><div align="right" style="float:right; display:inline-block"><img src="'.base_url('/').'img/na-icon.png" align="right" alt="My Na Points" /><strong>'.($row['POINTS'] + 10).'</strong></div>Your current !na points are :</p><p>
				We have given you your daily 10 FREE my na points. Play scratch and win now.</p><p class="white_box"><a href="'.site_url('/').'win/scratch_and_win" target="_blank" title="Click here to play scratch and win"><img style="width:593px" width="593"  src="'.base_url('/').'img/scratch/scratch_win_big.jpg" alt="Scratch and Win online now" /></a><p>';
			
		}
		
	}
	
		//UPDATE USER POINTS SUMMARY
	function update_client_point_summary($client_id, $points) {
		
		$this->db->where('CLIENT_ID',$client_id);
		$query = $this->db->get('u_client_points_summary');
						   
		if($query->num_rows() == 0){		   
				
				if($points < 0){
					
					$points = 0;
				
				}
				$data = array(
						
						'POINTS' => $points,
						'CLIENT_ID' => $client_id
					);
				
				$this->db->insert('u_client_points_summary',$data);
				
				
		}else{

			
			$query = $this->db->query("UPDATE u_client_points_summary SET POINTS = GREATEST(POINTS + ".$points." ,0) WHERE CLIENT_ID = '".$client_id."'");
		}	
		
	}
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET MYNA DB NEWS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_home_news_preview(){
		
		
		$limit = 3;
		$db2 = $this->connect_intouch_db();
		
		$query = $db2->query("SELECT * FROM news WHERE TITLE != '' AND DESCRIPTION != '' ORDER BY UPDATED_AT DESC LIMIT ".$limit."" ,FALSE);
		if($query->result()){
			echo '<div class="row-fluid">	  
			
				 ';
			$x2 = 0;

			foreach($query->result() as $row){
				
				$title = filter_var(utf8_decode(preg_replace("/[^a-z0-9.]+/i", " ",$row->TITLE)), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
				$body =filter_var(utf8_decode(preg_replace("/[^a-z0-9.]+/i", " ",strip_tags(html_entity_decode($row->DESCRIPTION)))), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);	
				if($row->IMAGE_LINK == ''){
					
					$img = '';
				}else{
					$img = '<img src="'.trim($row->IMAGE_LINK).'" alt="'.strip_tags($title).'" />';
					
					
				}
				
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
				$tweet_url = $row->IMAGE_LINK.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
				if ($x2 % 3 == 0) {
				   echo '
				   </div>
				   <div class="row-fluid">
				   ';
				}
				echo ' <div class="span4 white_box" >
							<div>'  .$img.'
      								<p>
									<span class="pull-right" style="margin-top:10px">
									'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
									</span>
									<h3 style="font-size:16px;line-height:20px;height:40px;">'.$title. '</h3>
									
									<div class="clearfix" style="height:5px;"></div>
									<div style="font-size:13px;margin-bottom:10px;">'.$this->shorten_string(strip_tags($body), 40).'</div>
									<div><font style="font-size:10px;">
										 '.strtoupper($row->TYPE).'</font>
										<font style="font-size:10px;font-style:italic;float:right">'. date('l jS \of F',strtotime($row->UPDATED_AT)).'</font></div>
									</p>
							</div>			
					  </div>
					  ';
				
				$x2 ++;
			}
			echo '</div>
			';
		
			
			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}
	
	
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET MYNA DB NEWS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_home_news(){

		
		$limit = 3;
		$db2 = $this->connect_intouch_db();
		
		$query = $db2->query("SELECT * FROM news WHERE TITLE != '' AND DESCRIPTION != '' ORDER BY UPDATED_AT DESC LIMIT ".$limit."" ,FALSE);
		if($query->result()){
			echo '
			<h2>Todays headlines</h2>
			<table width="593">
					<tr class="white_box">	  
			
				 ';
			$x2 = 0;

			foreach($query->result() as $row){
				
				$title = filter_var(utf8_decode(preg_replace("/[^a-z0-9.]+/i", " ",$row->TITLE)), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);
				$body =filter_var(utf8_decode(preg_replace("/[^a-z0-9.]+/i", " ",strip_tags(html_entity_decode($row->DESCRIPTION)))), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW);	
				if($row->IMAGE_LINK == ''){
					
					$img = '';
				}else{
					$img = '<img style="width:175px" width="175" src="'.trim($row->IMAGE_LINK).'" alt="'.strip_tags($title).'" />';
					
					
				}
				
				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
				$tweet_url = $row->IMAGE_LINK.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
				
				echo '<td width="196" style="border:2px solid #f1f1f1; padding:5px;vertical-align:top" border="1">'.$img.'<br /><br />
						<h3 style="font-size:16px;line-height:20px;height:40px;text-align:left"><a href="https://twitter.com/share?url='.$tweet_url.'"  style="float:right;" ><img src="'. base_url('/').'img/icons/twitter_sml.png" style="float:right;" align="right" alt="Share on twitter"/></a>'.$title. '</h3>
							<div class="clearfix" style="height:5px;"></div>
							<div style="font-size:13px;margin-bottom:10px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left">'.$this->shorten_string(strip_tags($body), 40).'</div>
						<font style="font-size:10px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left">
										 '.strtoupper($row->TYPE).'</font>
						<font style="font-size:10px;font-style:italic;float:right;font-family:Arial, Helvetica, sans-serif; color: #666;">'. date('l jS \of F',strtotime($row->UPDATED_AT)).'</font></td>';
				
				$x2 ++;
			}
			echo '</tr>
			</table> <br />
					 <br />
			';
		
			
			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}
		//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET SKY SPORTS NEWS FEEDS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_sky_sports_news_preview($offset, $limit, $type){
		 
		 if($offset != 0){
			$offset = ($offset * 4);
		 }
		 $limit = $limit -1;
		switch ($type)
		{
		case "formula1":
		 $xml=("http://www.skysports.com/rss/0,20514,12433,00.xml");
		 $has_img = 'Y'; 
		  break;
		case "rugby":
		 $xml=("http://www.skysports.com/rss/0,20514,12321,00.xml");
		 $has_img = 'Y'; 
		  break;
		case "super_rugby":
		 $xml=("http://www.skysports.com/rss/0,20514,12334,00.xml"); 
		 $has_img = 'Y'; 
		  break;

		case "premier_league":
		  $xml=("http://www.skysports.com/rss/0,20514,11661,00.xml"); 
		  $has_img = 'Y'; 
		  break;                  
		default:
		  $xml=("http://rss.wn.com/English/top-stories");
		  $has_img = 'Y';  
		}
		
		 
		
		  $xml2 = $this->cacheObject($xml,'sky_sports_'.$type.'_rss.xml',3600);
		  $xmlDoc = new DOMDocument();
		  $xmlDoc->load($xml2);
		  
		  //get elements from "<channel>"
		  $channel=$xmlDoc->getElementsByTagName('channel')->item(0);
		  $channel_title = $channel->getElementsByTagName('title')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_link = $channel->getElementsByTagName('link')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_desc = $channel->getElementsByTagName('description')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  
		  //get and output "<item>" elements
		  $rss=$xmlDoc->getElementsByTagName('item');
  		
			if($xmlDoc->getElementsByTagName('item')->length >= ($offset +3)){
				echo '
				
				<div class="row-fluid">
					  
				';
				$x2 = 0;
		
				for ($i=$offset; $i<=($offset + $limit); $i++){	
					
					if ($i > $offset + $limit) break;
					
					$title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
					$link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
					$body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);
					
					if($has_img == 'Y'){
					
						$img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
						$img = '<img src="'.trim($img_link).'" alt="'.strip_tags($title).'" />';
					}else{
						$img = '';
					
					}
					$pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue); 
					$source = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);   
	
					
						
	
					$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
					);
					$tweet_url = $link.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
					if (($x2 % 4 == 0) && ($x2 != 0)) {
					   echo '
					   </div>
					   <div class="row-fluid clearfix">
					   ';
					}
					echo ' <div class="span3 white_box" >
								<div>
									'  .$img.'
										<p>
										<span class="pull-right" style="margin-top:10px">
										'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
										</span>
										<h3 style="font-size:16px;line-height:20px;height:auto;">'.$title. '</h3>
										
										<div class="clearfix" style="height:5px;"></div>
										<div style="font-size:13px;margin-bottom:10px;">'.$this->shorten_string(strip_tags($body), 40).'</div>
										<div><font style="font-size:11px;"><a href="'.$source.'" target="_blank" rel="nofollow" class="mute">
											 '.$channel_title.'</a></font>
											<font style="font-size:10px;font-style:italic;float:right">'. date('l jS \of F',strtotime($pubDate)).'</font></div>
										</p>
								</div>			
						  </div>
						  ';
					
					$x2 ++;
				}
			$type_str ="'".$type."'";
			echo '
			</div>
			';
	
			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET SKY SPORTS NEWS FEEDS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_sky_sports_news($offset, $limit, $type){
		 
		 if($offset != 0){
			$offset = ($offset * 4);
		 }
		 $limit = $limit -1;
		switch ($type)
		{
		case "formula1":
		 $xml=("http://www.skysports.com/rss/0,20514,12433,00.xml");
		 $has_img = 'Y'; 
		  break;
		case "rugby":
		 $xml=("http://www.skysports.com/rss/0,20514,12321,00.xml");
		 $has_img = 'Y'; 
		  break;
		case "super_rugby":
		 $xml=("http://www.skysports.com/rss/0,20514,12334,00.xml"); 
		 $has_img = 'Y'; 
		  break;

		case "premier_league":
		  $xml=("http://www.skysports.com/rss/0,20514,11661,00.xml"); 
		  $has_img = 'Y'; 
		  break;                  
		default:
		  $xml=("http://rss.wn.com/English/top-stories");
		  $has_img = 'Y';  
		}
		
		 
		
		  $xml2 = $this->cacheObject($xml,'sky_sports_'.$type.'_rss.xml',3600);
		  $xmlDoc = new DOMDocument();
		  $xmlDoc->load($xml2);
		  
		  //get elements from "<channel>"
		  $channel=$xmlDoc->getElementsByTagName('channel')->item(0);
		  $channel_title = $channel->getElementsByTagName('title')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_link = $channel->getElementsByTagName('link')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_desc = $channel->getElementsByTagName('description')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  
		  //get and output "<item>" elements
		  $rss=$xmlDoc->getElementsByTagName('item');
  		
			if($xmlDoc->getElementsByTagName('item')->length >= ($offset +3)){
				echo '
				
				<table width="593">
					   <tr> 
					  
				';
				$x2 = 0;
		
				for ($i=$offset; $i<=($offset + $limit); $i++){	
					
					if ($i > $offset + $limit) break;
					
					$title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
					$link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
					$body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);
					
					if($has_img == 'Y'){
					
						$img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
						$img = '<img width="110" style="width:110px;" src="'.trim($img_link).'" alt="'.strip_tags($title).'" />';
					}else{
						$img = '';
					
					}
					$pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue); 
					$source = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);   
	
					
						
	
					$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
					);
					$tweet_url = $link.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
					
					echo '<td width="110" style="width:110px;border:2px solid #f1f1f1; padding:0px 10px;vertical-align:top">'.$img.'<br /><br />
							<h3 style="font-size:16px;line-height:20px;text-align:left"><a href="https://twitter.com/share?url='.$tweet_url.'" ><img src="'. base_url('/').'img/icons/twitter_sml.png" style="float:right;" align="right" alt="Share on twitter"/></a>'.$title. '</h3>
								<div class="clearfix" style="height:5px;"></div>
								<div style="font-size:13px;margin-bottom:10px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left">'.$this->shorten_string(strip_tags($body), 40).'</div>
							<font style="font-size:11px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left"><a href="'.site_url('/').'members/" target="_blank" rel="nofollow" class="mute">
												 '.$channel_title.'</a></font>
							<font style="font-size:10px;font-style:italic;float:right;font-family:Arial, Helvetica, sans-serif; color: #666;">'. date('l jS \of F',strtotime($pubDate)).'</font>
						</td>';
					
					
					
					$x2 ++;
				}
			$type_str ="'".$type."'";
			echo '</tr>
			</table> <br />
					 <br />';
	
			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET WORLD NEWS FEEDS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_world_news($offset, $limit, $type){
		
		$limit = $limit -1;
		switch ($type)
		{
		case "sport":
		 $xml=("http://rss.wn.com/English/keyword/sport");
		 $has_img = 'N'; 
		  break;
		case "health":
		 $xml=("http://rss.wn.com/English/keyword/health"); 
		 $has_img = 'N'; 
		  break;
		case "politics":
		  $xml=("http://rss.wn.com/English/keyword/mideast");
		  $has_img = 'N';  
		  break;
		case "business":
		  $xml=("http://rss.wn.com/English/keyword/business"); 
		  $has_img = 'N'; 
		  break;
		case "africa":
		  $xml=("http://rss.wn.com/English/keyword/africa"); 
		  $has_img = 'N'; 
		  break;
		case "afrikaans":
		  $xml=("http://rss.wn.com/Afrikaans/top-stories"); 
		  $has_img = 'Y'; 
		  break;
		case "german":
		  $xml=("http://rss.wn.com/german/top-stories");
		  $has_img = 'Y';  
		  break; 
		case "environmental":
		  $xml=("http://rss.wn.com/English/keyword/environment"); 
		  $has_img = 'N'; 
		  break;                 
		default:
		  $xml=("http://rss.wn.com/English/top-stories");
		  $has_img = 'Y';  
		}
		
		
		  $xml2 = $this->cacheObject($xml,'world_news_'.$type.'_rss.xml',3600);
		  $xmlDoc = new DOMDocument();
		  $xmlDoc->load($xml2);
		  
		  //get elements from "<channel>"
		  $channel=$xmlDoc->getElementsByTagName('channel')->item(0);
		  $channel_title = $channel->getElementsByTagName('title')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_link = $channel->getElementsByTagName('link')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_desc = $channel->getElementsByTagName('description')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  
		  //get and output "<item>" elements
		  $rss=$xmlDoc->getElementsByTagName('item');
  		
			if($xmlDoc->getElementsByTagName('item')->length >= ($offset +3)){
				echo '
				<table width="593">
					   <tr> ';
				$x2 = 0;
		
				for ($i=$offset; $i<=($offset + $limit); $i++){	
					
					if ($i > $offset + $limit) break;
					
					$title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
					$link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
					$body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);
					
					if($has_img == 'Y'){
					
						$img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
						$img = '<img style="width:175px" width="175" src="'.trim($img_link).'" alt="'.strip_tags($title).'" />';
					}else{
						$img = '';
					
					}
					$pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue); 
					$source = trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);   
	
					
						
	
					$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
					);
					$tweet_url = $link.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
					
					echo '<td width="180" style="width:180px;border:2px solid #f1f1f1; padding:0px 10px;vertical-align:top">'.$img.'<br /><br />
							<h3 style="font-size:16px;line-height:20px;text-align:left"><a href="https://twitter.com/share?url='.$tweet_url.'" ><img src="'. base_url('/').'img/icons/twitter_sml.png" style="float:right;" align="right" alt="Share on twitter"/></a>'.$title. '</h3>
								<div class="clearfix" style="height:5px;"></div>
								<div style="font-size:13px;margin-bottom:10px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left">'.$this->shorten_string(strip_tags($body), 40).'</div>
							<font style="font-size:11px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left"><a href="'.site_url('/').'members/" target="_blank" rel="nofollow" class="mute">
												 '.$source.'</a></font>
							<font style="font-size:10px;font-style:italic;float:right;font-family:Arial, Helvetica, sans-serif; color: #666;">'. date('l jS \of F',strtotime($pubDate)).'</font>
						</td>';
					
					
					
					$x2 ++;
				}
			$type_str ="'".$type."'";
			echo '</tr>
			</table> <br />
					 <br />';

			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET WORLD NEWS FEEDS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_world_news_preview($offset, $limit, $type){
		
		$limit = $limit -1;
		switch ($type)
		{
		case "sport":
		 $xml=("http://rss.wn.com/English/keyword/sport");
		 $has_img = 'N'; 
		  break;
		case "health":
		 $xml=("http://rss.wn.com/English/keyword/health"); 
		 $has_img = 'N'; 
		  break;
		case "politics":
		  $xml=("http://rss.wn.com/English/keyword/mideast");
		  $has_img = 'N';  
		  break;
		case "business":
		  $xml=("http://rss.wn.com/English/keyword/business"); 
		  $has_img = 'N'; 
		  break;
		case "africa":
		  $xml=("http://rss.wn.com/English/keyword/africa"); 
		  $has_img = 'N'; 
		  break;
		case "afrikaans":
		  $xml=("http://rss.wn.com/Afrikaans/top-stories"); 
		  $has_img = 'Y'; 
		  break;
		case "german":
		  $xml=("http://rss.wn.com/german/top-stories");
		  $has_img = 'Y';  
		  break; 
		case "environmental":
		  $xml=("http://rss.wn.com/English/keyword/environment"); 
		  $has_img = 'N'; 
		  break;                 
		default:
		  $xml=("http://rss.wn.com/English/top-stories");
		  $has_img = 'Y';  
		}
		
		
		  $xml2 = $this->cacheObject($xml,'world_news_'.$type.'_rss.xml',3600);
		  $xmlDoc = new DOMDocument();
		  $xmlDoc->load($xml2);
		  
		  //get elements from "<channel>"
		  $channel=$xmlDoc->getElementsByTagName('channel')->item(0);
		  $channel_title = $channel->getElementsByTagName('title')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_link = $channel->getElementsByTagName('link')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  $channel_desc = $channel->getElementsByTagName('description')
		  ->item(0)->childNodes->item(0)->nodeValue;
		  
		  //get and output "<item>" elements
		  $rss=$xmlDoc->getElementsByTagName('item');
  		
			if($xmlDoc->getElementsByTagName('item')->length >= ($offset +3)){
				echo '
				
				<div class="row-fluid">
					  
				';
				$x2 = 0;
		
				for ($i=$offset; $i<=($offset + $limit); $i++){	
					
					if ($i > $offset + $limit) break;
					
					$title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
					$link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
					$body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);
					
					if($has_img == 'Y'){
					
						$img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
						$img = '<img src="'.trim($img_link).'" alt="'.strip_tags($title).'" />';
					}else{
						$img = '';
					
					}
					$pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue); 
					$source = trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);   
	
					
						
	
					$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
					);
					$tweet_url = $link.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
					if (($x2 % 3 == 0) && ($x2 != 0)) {
					   echo '
			   </div>
			   <div class="row-fluid clearfix">
					   ';
					}
					echo ' <div class="span4 white_box" >
								<div>
									'  .$img.'
										<p>
										<span class="pull-right" style="margin-top:10px">
										'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
										</span>
										<h3 style="font-size:16px;line-height:20px;height:auto;">'.$title. '</h3>
										
										<div class="clearfix" style="height:5px;"></div>
										<div style="font-size:13px;margin-bottom:10px;">'.$this->shorten_string(strip_tags($body), 40).'</div>
										<div><font style="font-size:11px;"><a href="'.$link.'" target="_blank" rel="nofollow" class="mute">
											 '.$source.'</a></font>
											<font style="font-size:10px;font-style:italic;float:right">'. date('l jS \of F',strtotime($pubDate)).'</font></div>
										</p>
								</div>			
						  </div>
						  ';
					
					$x2 ++;
				}
			$type_str ="'".$type."'";
			echo '
			</div>';

			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}

	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CACHE FEED FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function cacheObject($url,$name,$age = 86400)
    { 
        // directory in which to store cached files
        $cacheDir = BASE_URL."application/cache/feeds/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
          $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {
		  
		    if ( copy($url, $filename) ) {
				 // update timestamp to now
         		 touch($filename);
			}else{
				echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
			}
         
        }
        // return the cache filename
        return $filename;
    }   
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BUSINESS DEALS FOR HOME FEED
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_email_deal($x){
		
		$limit = 1;
		//$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY SPECIALS_EXPIRE_DATE DESC LIMIT ".$limit." OFFSET ".$x."" ,FALSE);
		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit." " ,FALSE);
		if($query->result()){
			
			
			foreach($query->result() as $row){
				
				if($row->SPECIALS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = base_url('/').'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					
				}
				
				$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$row->SPECIALS_IMAGE_NAME."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".$this->clean_url_str($row->SPECIALS_HEADER)."')";				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);

				
				
				$tweet_url = 'http://my.na/deal/'.$this->clean_url_str($row->SPECIALS_HEADER).'&text='.substr(strip_tags($row->SPECIALS_HEADER . ' ' . $row->SPECIALS_CONTENT) ,0, 100).'&via=MyNamibia';
				$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				echo '
				<h2>Deal of the day</h2>
				<table width="593px" style="border:2px solid #f1f1f1;width:593px">
						<tr>
							<td width="450px">
								<img style="width:450px" width="450" src="'.$img.'" alt="'.strip_tags($row->SPECIALS_HEADER).'"  />
							</td>
							<td width="143px">
								<h1 style="font-size:50px;line-height:30px;height:20px;color:#FF9F01;text-align:left"><font style=" font-size:12px">N$</font>'.$row->SPECIALS_PRICE.'</h1>
								<h3 style="font-size:16px;line-height:20px;height:30px;text-align:left">'.$row->SPECIALS_HEADER.'</h3>
									<div class="clearfix" style="height:5px;"></div>
									<div style="font-size:10px;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left">'.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 20).'</div>
									<div class="clearfix" style="height:10px;font-family:Arial, Helvetica, sans-serif; color: #666;"></div>
									<a style="float:right;font-family:Arial, Helvetica, sans-serif; color: #666;text-align:left" href="'.site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER).'/" ><img src="'.base_url('/').'img/icons/view_deal.png'.'" align="right" style="float:right" alt="View Deal" /></a>
							</td>
						</tr>
					 </table>
					 <br />
					 <br />
							';
				
			}
		
			
			
		 }else{

			 
		 }
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET BUSINESS DEALS FOR HOME FEED
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_email_deal_preview($x){
		
		$limit = 1;
		//$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY SPECIALS_EXPIRE_DATE DESC LIMIT ".$limit." OFFSET ".$x."" ,FALSE);
		$query = $this->db->query("SELECT * FROM u_special_component WHERE IS_ACTIVE = 'Y' AND SPECIALS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT ".$limit." " ,FALSE);
		if($query->result()){
			
			
			foreach($query->result() as $row){
				
				if($row->SPECIALS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = base_url('/').'assets/deals/images/'.$row->SPECIALS_IMAGE_NAME;
					
				}
				
				$fb = "postToFeed(".$row->ID.", '". $row->SPECIALS_HEADER ."', '".$row->SPECIALS_IMAGE_NAME."', '".$row->SPECIALS_HEADER ." - My Namibia','".$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 50)."', '".$this->clean_url_str($row->SPECIALS_HEADER)."')";				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);

				
				
				$tweet_url = 'http://my.na/deal/'.$this->clean_url_str($row->SPECIALS_HEADER).'&text='.substr(strip_tags($row->SPECIALS_HEADER . ' ' . $row->SPECIALS_CONTENT) ,0, 100).'&via=MyNamibia';
				$c = ($this->count_claims($row->ID) / $row->QUANTITY) * 100;
				echo ' <div class="row-fluid">
							<div class="span12  white_box">
							<div class="span8">
								<img  src="'.$img.'" alt="'.strip_tags($row->SPECIALS_HEADER).'"  />
							</div>
							<div class="span4">
									<div style="width:100%;height:150px;">
									
									<h1 style="font-size:50px;height:20px;color:#FF9F01;"><font style=" font-size:12px">N$</font>'.$row->SPECIALS_PRICE.'</h1>
									<div style="float:right;">
										<a onclick="'.$fb.'" class="facebook"></a>
										'.anchor_popup('https://twitter.com/share?url='.$tweet_url, ' ', $tweet).'
									</div>	
									<h3 style="font-size:16px;line-height:20px;height:30px;">'.$row->SPECIALS_HEADER.'</h3>
									<div class="clearfix" style="height:5px;"></div>
									<div style="font-size:10px;">'.$this->shorten_string(strip_tags($row->SPECIALS_CONTENT), 20).'</div>
									</div>
									<div class="clearfix" style="height:20px;"></div>
									<div  id="ctdwn_'.$row->ID.'"></div>
									<div class="clearfix" style="height:15px;"></div>
									<div class="progress progress-striped progress-warning" title="'.($row->QUANTITY - $this->count_claims($row->ID)).' Deals Available" rel="tooltip">
									  <div class="bar" title="'.$c.'% of the deals are taken" rel="tooltip" style="width:'.$c.'%"></div>
									</div>
									<div class="clearfix" style="height:20px;"></div>
									<a class="btn btn-warning" href="'.site_url('/').'deal/'.$row->ID.'/'.$this->clean_url_str($row->SPECIALS_HEADER).'/" > View Deal</a>
									
									<div class="clearfix" style="height:20px;"></div>
								</div>
						</div>	
					  </div>';
				
			}
			
			if($x == 0){
				$fb_share_key = '';//$this->encrypt('fb_share');
				$load_img = "<img src='". base_url('/'). "img/load_white.gif' />";
				
			
			}
			
			
			
		 }else{

			 
		 }
	
	}
	
		//+++++++++++++++++++++++++++
	//IS THE DEAL CLAIMED?
	//++++++++++++++++++++++++++
    public function count_claims($id)
    {
        //GET SPONSOR DETAILS			
		$query = $this->db->where('deal_id',$id);
		$query = $this->db->get('u_special_claims');
		if($query->result()){
		    return $query->num_rows;	
		}else{
			return 0;
		}		
    }
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET ADVERTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_sdvert($query = ''){
		
		
		$query = $this->db->query("SELECT * FROM adverts WHERE IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 1" ,FALSE);
		if($query->result()){
			echo '
				 ';
			
			foreach($query->result() as $row){
				
				if($row->ADVERTS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = S3_URL.'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;
					
				}
				
				if($row->URL == ''){
					
					$link1 = '';
					$link2 = '';
					
				}else{
					
					$link1 = '<a href="'.prep_url($row->URL).'" target="_blank">';
					$link2 = '</a>';
					
				}

				
				echo ' <table width="593px">
							<tr>
								<td width="593px">
								'.$link1.'<img style="width:593px" width="593" style="width:100%" src="'.$img.'" alt="'.strip_tags($row->ADVERTS_HEADER).'" />'.$link2.'
								</td>
							</tr>
						</table><br /><br />	
					  ';
				
			}
			
			
			
		 }else{
		
		 }
	
	}
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET ADVERTS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function show_sdvert_preview($query = ''){
		
		
		$query = $this->db->query("SELECT * FROM adverts WHERE IS_ACTIVE = 'Y' AND ADVERTS_EXPIRE_DATE > NOW() ORDER BY RAND() LIMIT 1" ,FALSE);
		if($query->result()){
			echo '
				 ';
			
			foreach($query->result() as $row){
				
				if($row->ADVERTS_IMAGE_NAME == ''){
					
					$img = base_url('/').'img/user_blank.jpg';
					
				}else{
					
					$img = S3_URL.'assets/adverts/images/'.$row->ADVERTS_IMAGE_NAME;
					
				}
				
				if($row->URL == ''){
					
					$link1 = '';
					$link2 = '';
					
				}else{
					
					$link1 = '<a href="'.prep_url($row->URL).'" target="_blank">';
					$link2 = '</a>';
					
				}

				
				echo ' <div class="row-fluid">
							<div class="span12  white_box">
								'.$link1.'<img  style="width:593px" width="593" src="'.$img.'" alt="'.strip_tags($row->ADVERTS_HEADER).'" />'.$link2.'
							</div>
							
						</div>	
					  ';
				
			}
			
			
			
		 }else{
		
		 }
	
	}
	
		//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_email()
	{
		
			$count = 0;
						  
			//BUILD MANDRILL ARRAY  
			$mandrill = array($row['CLIENT_EMAIL']);
			$business = $bus_name;
			//$business['EMAIL'] = $bus_email;
			//SEND MANDRILL
			$data2['body'] = $body;
			$body1 = $this->load->view('email/body_news',$data2,true);  
			$this->send_newsletter_do($body1, $body, $subject, $mandrill, $business);
		

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CACHE EMAIL FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function cacheEmail($url,$name,$age = 86400)
    { 
        // directory in which to store cached files
        $cacheDir = BASE_URL."application/cache/emails/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
          $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {
		  
		    if ( copy($url, $filename) ) {
				 // update timestamp to now
         		 touch($filename);
			}else{
				echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
			}
         
        }
        // return the cache filename
        return $filename;
    }   



	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//TRADE MAINTENANCE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	


	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//UPDATE STATUS AFTER 30 DAYS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function expired_products($row)
    { 

		  //SEE IF ITEM IS OLDER THAN 30 DAYS	
		  $list_date = strtotime($row->start_date);
		  $expire_date = date('Y-m-d', strtotime($row->end_date)); 
		  $next_date = date('Y-m-d', strtotime($row->end_date . ' + 30 days'));
		  
		  
		  if($expire_date == date('Y-m-d')){
			  echo $row->title.'<br />';
			  echo 'Today: '.date('Y-m-d'). ' Listing: '.date('Y-m-d', $list_date). ' -- Expire: ' .$expire_date.'<br />';
			  //UPDATE STATUS TO NOT ACTIVE
			  $data['is_active'] = 'N';
			  //ADD #) DAYS SO ACTIVATING IT CAN EXTEND
			  $data['end_date'] = $next_date;
			  $this->db->where('product_id', $row->product_id);
			  $this->db->update('products', $data);

			  
			  //GHET PRODUCT IMAGES
			  $this->db->where('product_id', $row->product_id);
			  $this->db->limit(3);
			  $images = $this->db->get('product_images');
			  $img_str = '';
			  if($images->result()){
				  
				  $img_str = '<table border="0" cellpadding="5" cellspacing="0" width="100%;max-width:600px">
								  <tr>';
				  foreach($images->result() as $img_row){
					  
							  $img_str .= '<td><img src="'.base_url('/').'assets/products/images/'.$img_row->img_file.'" style="width:170px;height:auto" /></td>';	
						  
				  }
				  
				  $img_str .= '</tr>
						  </table>';
			  }

              $agent_ref = '';
              //PROPERTY REFERENCE
              if(count(json_decode($row->extras)) > 0){

                  foreach(json_decode($row->extras) as $exr => $exv){

                      if($exr == 'agency' && $exv != ''){

                          $agent_ref = 'Ref: '.$exv.'';
                      }

                  }

              }

			  //SEND NOTIFICATION OF CHANGE
			  $emailTO =  array($row->CLIENT_EMAIL); 
			  $emailFROM = 'no-reply@my.na';
			  $name = 'My Namibia Trade';
			  $subject = 'Your Product has Expired - '.$this->shorten_string($row->title, 3) . ' '.$agent_ref;
			  $body = 'Hi '.$row->CLIENT_NAME.', <br /><br /> 
			  		Your Product listed on My Namibia&trade; Trade has not been sold and has expired! The item will not be shown on the website 
					until it has been re-listed for another 30 days.

					<br />
					<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">ITEM EXPIRED!</h1>
					<br />
					'. $img_str.'		
					<font style="font-size:10px; font-style:italic">'.$row->description.'</font>
					<br />
					To re-list your item please login to your dashboard and update the product.
					<ol>
						<li>Login to My Namibia</li>
						<li>Go to the Dashboard</li>
						<li>Click on the My Items link under Buy/Sell</li>
						<li>Proceed to the Publish Item section</li>
						<li>And wait for the item to Sell</li>
					</ol>
					View the product page by clicking <a href="https://www.my.na/product/'.$row->product_id.'/">here.</a><br /><br />
					<br />
					Have a !tna day!<br />
					My Namibia';
		      echo $subject . '   -  '.$row->CLIENT_EMAIL;
			  $data_view['body'] = $body;
			  $body_final = $this->load->view('email/body_news',$data_view,true);
			  $TAGS = array('tags' => 'trade_expiry');
			  $this->load->model('email_model');	
			  
			  $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);
			  echo 'Expired Product Email Sent <br /><br /><br />';
			  return TRUE;	  
		  }else{
			  
			return FALSE;  
		  }
	
    }

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//SEND EMAIL TO WATCHING LIST ABOUT EXPIRY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function watchlist_expired_products($row)
    { 

		  //SEE IF ITEM IS OLDER THAN 30 DAYS	
		  $list_date = strtotime($row->start_date);
		  $expire_date = date('Y-m-d', strtotime($row->end_date )); 
		  
		  
		  if($expire_date == date('Y-m-d')){
			  echo $row->title.'  '. $row->product_id.'<br />';
			  echo 'Today: '.date('Y-m-d'). ' Listing: '.date('Y-m-d', $list_date). ' -- Expire: ' .$expire_date.'<br />';
			  
			  //GHET PRODUCT IMAGES
			  $this->db->where('product_id', $row->product_id);
			  $this->db->limit(3);
			  $images = $this->db->get('product_images');
			  $img_str = '';
			  if($images->result()){
				  
				  $img_str = '<table border="0" cellpadding="5" cellspacing="0" width="100%;max-width:600px"  class="white_box">
								  <tr>';
				  foreach($images->result() as $img_row){
					  
							  $img_str .= '<td><img src="'.base_url('/').'assets/products/images/'.$img_row->img_file.'" style="width:170px;height:auto" /></td>';
						  
				  }
				  
				  $img_str .= '</tr>
						  </table>';
			  }
			  $a = '';
			  if($row->listing_type == 'A'){
				  
				 $a = 'Auction ';  
			  }
			  
			  //SEND NOTIFICATION OF CHANGE
			  $emailTO =  array($row->CLIENT_EMAIL); 
			  $emailFROM = 'no-reply@my.na';
			  $name = 'My Namibia Trade';
			  $subject = $a.'Ending Soon - '.$row->title;
			  $body = 'Hi '.$row->CLIENT_NAME.', <br /><br /> 
			  		The item in your My Namibia&trade; watchlist '.$row->title .' is ending tomorrow and will no longer be available.
					Act now to avoid disappointment.
					<br /><br />
					<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">ENDING SOON!</h1>
					'. $img_str.'
					<br /><br />
					<em>'.$row->description.'</em>
					<br />
					View the product page by clicking <a href="https://www.my.na/product/'.$row->product_id.'/">here.</a><br /><br />
					<br />
					Have a !tna day!<br />
					My Namibia';
		      echo $subject . '   -  '. $row->CLIENT_EMAIL;
			  $data_view['body'] = $body;
			  $body_final = $this->load->view('email/body_news',$data_view,true);
			  $TAGS = array('tags' => 'trade_watchlist_expiry');
			  $this->load->model('email_model');	
			  
			  $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);
			  echo 'Watchlist expiry Email Sent <br />++++++++++++++++<br />';
			  
			  return TRUE; 	
				  
		  }else{
			  
			return FALSE;  
		  }
	
    }


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SEND AUCTION WINNER EMAIL
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function auction_winner_email($buyer, $seller)
    {

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //SEND WINNER EMAIL
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $image = base_url('/').'img/product_blank.jpg';

        if(strlen($seller->img_file) > 1){

            $image = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/products/images/'.$seller->img_file.'&w=580&h=300';

        }
        $emailTO =  array($buyer->CLIENT_EMAIL,'info@my.na');
        $emailFROM = 'no-reply@my.na';
        $name = 'My Namibia Trade';
        $subject = 'Auction Item is Yours';
        $body = 'Hi '.$buyer->CLIENT_NAME.', <br /><br />
							Your leading bid has secured you: '.$seller->title.' on My Namibia &trade;
							<br /><br />
							<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">I am Yours!</h1>
							<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
									 <tr>
										<td style="width:100%" class="white_box"><img src="'. $image.'" alt="download picture sto view"></td>
									 </tr>
							</table><br />
							<br />
							'.$seller->description.'
							<br />
							<br />
							<strong>Payment Details:</strong>
							'.$seller->email_instructions.'
							<br /><br />
							If you have any questions or need to arrange shipping please contact the seller below.<br />
                            <strong>Name:</strong> '.$seller->CLIENT_NAME.'<br/>
                            <strong>Email:</strong> '.$seller->CLIENT_EMAIL.'<br/>
                            <strong>Cell:</strong> '.$seller->CLIENT_CELLPHONE.'<br/><br/>
							Please be reminded to leave feedback about the selling party from your My Trade dashboard.
							The better your review the more trust you build in the online trading environment.
							<br /><br />
							View the auction <a href="https://www.my.na/product/'.$seller->product_id.'/">here.</a><br /><br />
							<br />
							Have a !tna day!<br />
							My Namibia';
        $data_view['body'] = $body;
        $body_final = $this->load->view('email/body_news',$data_view,true);
        $TAGS = array('tags' => 'auction_win_buyer');
        $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);
        echo $body_final;
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SEND AUCTION SELLE EMAIL
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function auction_seller_email($buyer, $seller)
    {

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //SEND WINNER EMAIL
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $image = base_url('/').'img/product_blank.jpg';

        if(strlen($seller->img_file) > 1){

            $image = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/products/images/'.$seller->img_file.'&w=580&h=300';

        }
        $emailTO =  array($seller->CLIENT_EMAIL,'info@my.na');
        $emailFROM = 'no-reply@my.na';
        $name = 'My Namibia Trade';
        $subject = 'Your Auction has Finished - Item is SOLD';
        $body = 'Hi '.$seller->CLIENT_NAME.', <br /><br />
							Your product has sold: '.$seller->title.' on My Namibia &trade;
							<br /><br />
							<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">SOLD!</h1>
							<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
									 <tr>
										<td style="width:100%" class="white_box"><img src="'. $image.'" alt="download picture sto view"></td>
									 </tr>
							</table><br />
							<br />
							'.$seller->description.'
							<br /><br />
							If you have any questions or need to arrange shipping please contact the buyer below.<br />
                            <strong>Name:</strong> '.$buyer->CLIENT_NAME.'<br/>
                            <strong>Email:</strong> '.$buyer->CLIENT_EMAIL.'<br/>
                            <strong> Cell:</strong> '.$buyer->CLIENT_CELLPHONE.'<br/><br/>
							<br /><br />

							<br /><br />
							Please be reminded to leave feedback about the buying party from your My Trade dashboard.
							The better your review the more trust you build in the online trading environment.
							<br /><br />
							View the auction <a href="https://www.my.na/product/'.$seller->product_id.'/">here.</a><br /><br />
							<br />
							Have a !tna day!<br />
							My Namibia';
        $data_view['body'] = $body;
        $body_final = $this->load->view('email/body_news',$data_view,true);
        $TAGS = array('tags' => 'auction_win_seller');
        $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);
        echo $body_final;
    }



    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //SEND AUCTION RESERVER NOT MET
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function auction_reserve_not_met( $seller)
    {

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //SEND RESERVE NOT MET
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $image = base_url('/').'img/product_blank.jpg';

        if(strlen($seller->img_file) > 1){

            $image = base_url('/').'img/timbthumb.php?src='.base_url('/').'assets/products/images/'.$seller->img_file.'&w=580&h=300';

        }
        $emailTO =  array($seller->CLIENT_EMAIL,'info@my.na');
        $emailFROM = 'no-reply@my.na';
        $name = 'My Namibia Trade';
        $subject = 'Your Auction has Finished - Reserve not Met';
        $body = 'Hi '.$seller->CLIENT_NAME.', <br /><br />
							Your product has auction has finished but the reserve has not been met: '.$seller->title.' on My Namibia &trade;
							<br /><br />
							<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">RESERVE NOT MET!</h1>
							<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
									 <tr>
										<td style="width:100%" class="white_box"><img src="'. $image.'" alt="download picture sto view"></td>
									 </tr>
							</table><br />
							<br />
							'.$seller->description.'
							<br /><br />

							<br /><br />
							Please extend the auction period from your My Trade dashboard.
							<br /><br />
							View the auction <a href="https://www.my.na/product/'.$seller->product_id.'/">here.</a><br /><br />
							<br />
							Have a !tna day!<br />
							My Namibia';
        $data_view['body'] = $body;
        $body_final = $this->load->view('email/body_news',$data_view,true);
        $TAGS = array('tags' => 'auction_reserve not_met');
        $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS);
        echo $body_final;
    }

	//+++++++++++++++++++++++++++
	//HOURLY TRADE EMAIL SCRIPT
	//++++++++++++++++++++++++++
	public function trade_houseworking()
	{
		
		
		
	}


    //+++++++++++++++++++++++++++
    //GET CLOUDFLARE ANALYRICS
    //++++++++++++++++++++++++++
    public function cloudflare_stats($headers, $url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $response = curl_exec($ch);
        // $response['errorC'] = curl_error($ch);
        // Close handle
        curl_close($ch);
        return $response;

    }



    //+++++++++++++++++++++++++++
    //EMAIL STATS PER TAG FROM MANDRILL
    //++++++++++++++++++++++++++
    public function get_email_tags_stats($id = '')
    {


        $q = $this->db->get('emails');

        $str = 'Email logs for: ';

        $emails = array();
        $emailsA = array();
        $x = 0;
        if($q->result()){

            //loop each
            foreach($q->result() as $erow){

                $t = ''.$erow->email_id;

                $emailsA[$t]['email_id'] = $t;
                $emailsA[$t]['opens'] = $erow->opens;
                $emailsA[$t]['unique_opens'] = $erow->unique_opens;
                $emailsA[$t]['clicks'] = $erow->clicks;
                $emailsA[$t]['unique_clicks'] = $erow->unique_clicks;
                $emailsA[$t]['sends'] = $erow->sends;
                $emailsA[$t]['soft_bounces'] = $erow->soft_bounces;
                $emailsA[$t]['hard_bounces'] = $erow->hard_bounces;
                $emailsA[$t]['unsubscribes'] = $erow->unsubscribes;
                $emailsA[$t]['complaints'] = $erow->complaints;
                $emailsA[$t]['reputation'] = $erow->reputation;
                $emailsA[$t]['rejects'] = $erow->rejects;
                array_push($emails, $t);
                //array_push($emailsA, $erow);
                $x ++;
            }


        }

        //var_dump($emails);

        $this->load->model('email_model');
        $x2 = 0;
        $result = $this->email_model->get_email_stats($query = '' , $date_from = '', $date_to = '', $tags = array(), $senders = array(), $limit = 1000);

        if(count($result) > 0){

            foreach($result as $row){

                if(in_array($row['tag'], $emails)){

                    $val = false;
                    //COMPARE EXISTING
                    if($emailsA[$row['tag']]['sends'] < $row['sent']){

                        $insert['sends'] = $row['sent'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['opens'] < $row['opens']){

                        $insert['opens'] = $row['opens'];
                        $val = true;

                    }
                    if($emailsA[$row['tag']]['unique_opens'] < $row['unique_opens']){

                        $insert['unique_opens'] = $row['unique_opens'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['unique_clicks'] < $row['unique_clicks']){

                        $insert['unique_clicks'] = $row['unique_clicks'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['clicks'] < $row['clicks']){

                        $insert['clicks'] = $row['clicks'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['complaints'] < $row['complaints']){

                        $insert['complaints'] = $row['complaints'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['unsubscribes'] < $row['unsubs']){

                        $insert['unsubscribes'] = $row['unsubs'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['reputation'] < $row['reputation']){

                        $insert['reputation'] = $row['reputation'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['rejects'] < $row['rejects']){

                        $insert['rejects'] = $row['rejects'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['soft_bounces'] < $row['soft_bounces']){

                        $insert['soft_bounces'] = $row['soft_bounces'];
                        $val = true;
                    }
                    if($emailsA[$row['tag']]['hard_bounces'] < $row['hard_bounces']){

                        $insert['hard_bounces'] = $row['hard_bounces'];
                        $val = true;
                    }

                    $clean_id = $row['tag'];

                    if($val){
                        $this->db->where('email_id', $clean_id);
                        $this->db->update('emails', $insert);

                        echo 'Existing Sends: '.$emailsA[$row['tag']]['sends'] . '  -  API Sends: '.$row['sent']. ' ';
                        echo 'Wohoo ' .$row['tag']. ' - <br />';
                    }else{

                        echo 'Not Updated: '.$emailsA[$row['tag']]['sends'] . '  -  API Sends: '.$row['sent']. ' ';


                    }

                }

                //echo $row['tag']. ' - ';
                //var_dump($row);


            }



        }



    }

 	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //MONTHLY BUSINESS REPORTS DEATURED BUSINESS CREATE PROCESS QUEUE
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function business_reports($bus_id = null)
    {
        //GET ALL Featured business plus members
    	$date = date('y-m-d');
    	$sql = '';
    	if($bus_id !== null){
    		$sql = "u_business.ID = ".$bus_id." AND ";
    	}
        $q = $this->db->query(
        	"SELECT u_business.*
        	FROM u_business
			WHERE ".$sql." u_business.PAID_STATUS > 0 AND u_business.PAID_UNTIL > '".$date."'
			", TRUE
        );
        $res['success'] = false;
        $res['msg'] = '';
        $x = 0;
    	if($q->result()){

    		$insertA = array();
        	foreach($q->result() as $row){

        		$data['req_url'] = 'cron_jobs/generate_business_report/'.$row->ID.'/MONTH/';
        		$data['type'] = 1;
        		array_push($insertA, $data);
        		$x ++;
        	}
        	$res['success'] = true;
        	//var_dump($insertA);
        	$this->db->insert_batch('worker_requests', $insertA);
        	$res['msg'] = $x.' Reports Processed into the queue';
        }

        return $res;

	}
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //MONTHLY BUSINESS REPORTS DEATURED BUSINESS
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function generate_business_report($bus_id = null, $period)
    {

        //GET ALL Featured business plus members
    	$date = date('y-m-d');
    	$sql = '';
    	if($bus_id !== null){
    		$sql = "u_business.ID = ".$bus_id." AND ";
    	}
        $q = $this->db->query(
        	"SELECT u_business.*, GROUP_CONCAT( u_client.CLIENT_EMAIL, '-_-', u_client.CLIENT_NAME) as users
        	FROM u_business
			LEFT JOIN i_client_business ON i_client_business.BUSINESS_ID = u_business.ID
			LEFT JOIN u_client ON i_client_business.CLIENT_ID = u_client.ID
			WHERE ".$sql." u_business.PAID_STATUS > 0 AND u_business.PAID_UNTIL > '".$date."'
			GROUP by u_business.ID
			", TRUE
        );

        //echo $this->db->last_query();
        if($q->result()){

            $global_merge = array();
            $merge = array();

        	foreach($q->result() as $row){

		        $array_to = array($row->BUSINESS_EMAIL);

		        $m = array(

                    'rcpt' => $row->BUSINESS_EMAIL,
                    'vars' => array(array(

                        'name' => 'name',
                        'content' => $row->BUSINESS_NAME

                    ))

                );
                array_push($merge, $m);
        		//echo $row;
        		//BUILD ALL EMAILS
        		if(strlen($row->users) > 0){

        			$uA = explode(',', $row->users);
        			foreach($uA as $urow){

        				//echo $urow .'<br />';

        				$a = explode('-_-',$urow);
        				if($a[0] !== $row->BUSINESS_EMAIL){

	 						//BUILD ARRAY FOR EMAILS
	                        $d = $a[0];
	                        array_push($array_to, $d);

	                        //BUILD MERGE VARIABLES
	                        //Link can go here
	                        $global = array(

	                            'name' => 'link1',
	                            'content' => 'global_content'

	                        );
	                        array_push($global_merge, $global);

	                        $m = array(

	                            'rcpt' => $a[0],
	                            'vars' => array(array(

	                                'name' => 'name',
	                                'content' => $a[1]

	                            ))

	                        );
	                        array_push($merge, $m);

	        			}

        			}

        		}
        		//var_dump($merge);
        		//var_dump($array_to);
        		//die();
        		//BUILD EMAIL AND CREATE PDF TO send
				$data['bus_id'] = $row->ID;
				$data['period'] = 'MONTH';

				$data['business'] = $q->result();
				$this->load->model(array('rating_model','members_model', 'email_model', 'business_model'));
				$data['bus_id'] = $row->ID;
				$data['rating'] = $this->business_model->get_rating($row->ID);
				$body = $this->load->view('email/body_business_report', $data, true);

        		//CREATE PDF Phantom JS
        		$url = site_url('/').'business/print_business_pdf/'.$row->ID.'/MONTH/'.$this->my_na_model->clean_url_str($row->BUSINESS_NAME);
				// Get cURL resource
				$curl = curl_init();
				// Set some options - we are passing in a useragent too here
				curl_setopt_array($curl, array(
				    CURLOPT_RETURNTRANSFER => 1,
				    CURLOPT_URL => $url,
				    CURLOPT_USERAGENT => 'My.na Agent'
				));
				// Send the request & save response to $resp
				$res = curl_exec($curl);

				// Close request to clear up some resources
				curl_close($curl);
				var_dump($res);
				$res = json_decode($res);
				var_dump($res);
				/*echo $res['success'];
				echo $res['pdf'];
				echo $res->pdf;*/
				//var_dump($res);
        		if($res->success === true){
					
	        		//var_dump($res);
	        		echo '<strong>EMAIL for '.$row->BUSINESS_NAME.'</strong><br />';
					//print_r($array_to);

					echo '<iframe srcdoc="'.$body.'" style="width:800px; height:600px"></iframe><br />';

					//Finally Sedn the MAIL
					$subject = 'Insights for '.$row->BUSINESS_NAME.' - '.date('M Y');
			 		$data_view['body'] = $body;
			 		if($attachment = file_get_contents(BASE_URL.$res->pdf_link)){
			 			 echo 'ATTACHMENT: <br />';
			 		}
			 		$file_name = $subject.'.pdf';
					$mime = 'application/pdf';
			        //$body_final = $this->load->view('email/body_news',$data_view,true);
			        $TAGS = array('tags' => 'business_report');
			        $emailRes = $this->email_model->send_mail($body, $subject, $array_to, 'reports@my.na', 'My Namibia', $TAGS, 
			        											$important = true, $global_merge , $merge , $from = 'reports', 
			        											base64_encode($attachment), $file_name , $mime);
			        
			       
			        //print_r($attachment);
			        echo 'MANDRILL RESPONSE: <br />';
			        print_r($emailRes);

        		}else{
 
        			echo 'PDF Failure<br />';
        		}
        		//echo $res['pdf'].'<br />';

				echo '+++++++++++++++++++++++<br />';
        	}
        	

        }
        $o['success'] = true;
        $o['msg'] = '';
        return $o;
    }


	//+++++++++++++++++++++++++++++
	//PROCESS WORKER REQUEST QUEUE
	//++++++++++++++++++++++++++++
    function worker_requests()
    {
        
        $q = $this->db->order_by('wreq_id', 'ASC');
        $q = $this->db->get('worker_requests');
       
        $res['success'] = false;
        $res['msg'] = '';
        $x = 0;
        $out = '';
    	if($q->result()){

        	foreach($q->result() as $row){

        		$URL = site_url('/').trim($row->req_url);
        		//echo $URL;
		        // Get cURL resource
		        $curl = curl_init();
		        // Set some options - we are passing in a useragent too here
		        curl_setopt_array($curl, array(
		            CURLOPT_RETURNTRANSFER => 1,
		            CURLOPT_URL => $URL,
		            CURLOPT_USERAGENT => 'My.na Worker Agent'
		        ));
		        // Send the request & save response to $resp
		        $resp = curl_exec($curl);
		        // Close request to clear up some resources
		        curl_close($curl);

		        if($resp === FALSE){
		        	$out .= json_encode($resp);
		        }else{
		        	$x ++;
		        }
        		
        		//Delete Queue item
        		$this->db->where('wreq_id', $row->wreq_id);
        		$this->db->delete('worker_requests');
        	}
        	$res['error'] = $out;
        	$res['success'] = true;
        	$res['msg'] = $x.' Records Processed from the queue of '.$q->num_rows();
        }else{

        	$res['msg'] = 'No requests in queue';
        }

        return $res;

	}

	
	function connect_intouch_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'ntouchim_admin';
		$config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
		$config_db['database'] = 'ntouchim_debmarine';
		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}	
	
    //Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}

}
?>