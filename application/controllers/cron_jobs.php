<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_jobs extends CI_Controller {

	/**
	 * Adverts Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */

	function __construct()
	{
		parent::__construct();
		//$this->load->model('cron_model');
		$this->load->model('cron_model');
	}
	
	function index()
	{
		echo 'index';
	}
	//+++++++++++++++++++++++++++
	//OPTIMIZE DATABASE
	//++++++++++++++++++++++++++
	public function optimize_db()
	{
		$out = $this->cron_model->optimize_db();
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "Database OPTIMIZE Notification";
		$message = "We have succesfully optimized system database.".$out;
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1);
	}
	
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE OTHER
	//++++++++++++++++++++++++++
	public function backup_db_system()
	{
		$out = $this->cron_model->backup_db_system();
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "SYSTEM Backup DB Notification";
		$message = "We have succesfully backed up the system database.".print_r($out);
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup'); 
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1);
	}
	
	
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE
	//++++++++++++++++++++++++++
	public function backup_db()
	{
		$this->cron_model->backup_db();
		$to1 = array(array('email' => 'roland@my.na' )); 
		$subject1 = "Backup DB Notification";
		$message = "We have succesfully backed up the database";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup'); 
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1); 
	}
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE ANALYTICS
	//++++++++++++++++++++++++++
	public function backup_db_analytics()
	{
		$this->cron_model->backup_db_analytics();
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "Backup DB Notification Analytics";
		$message = "We have succesfully backed up the products database";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1);
	}
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE BUSINESS
	//++++++++++++++++++++++++++
	public function backup_db_business()
	{
		$this->cron_model->backup_db_business();
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "Backup DB Notification Analytics";
		$message = "We have succesfully backed up the products database";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1);
	}
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE PRODUCTS
	//++++++++++++++++++++++++++
	public function backup_db_products()
	{
		$this->cron_model->backup_db_products();
		$to1 = array(array('email' => 'roland@my.na' )); 
		$subject1 = "Backup DB Notification Products";
		$message = "We have succesfully backed up the products database";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup'); 
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1); 
	}
	
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE OTHER
	//++++++++++++++++++++++++++
	public function backup_db_other()
	{
		$this->cron_model->backup_db_other();
		$to1 = array(array('email' => 'roland@my.na' )); 
		$subject1 = "Backup DB Notification Other";
		$message = "We have succesfully backed up the products database";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup'); 
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1,  $from1, 'My Backup Cron', $TAG1); 
	}
	
	public function test_aws(){
		
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "Test Amazon AWS Cron Job Notification";
		$message = "Test Amazon AWS Cron Job Notification";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->load->model('email_model');	
		$this->email_model->send_mail($message, $subject1, $to1,  $from1, 'My Analytics Cron', $TAG1);
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE BUSINESS ANALYTICS IMPRESSIONS MONTHLY ROUTINE
	//++++++++++++++++++++++++++
	public function clean_impressions_monthly()
	{
		
		$date = date('m');

        echo $date. '<br />';
 		//CREATE TABLE
	   $tbl = "CREATE TABLE IF NOT EXISTS `u_business_impressions_" . date( 'Y_m') . "` (
				 `IMP_ID` int(11) NOT NULL AUTO_INCREMENT,
				  `BUSINESS_ID` int(11) NOT NULL,
				  `TIMESTAMP` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`IMP_ID`),
				  KEY `BUSINESS_ID` (`BUSINESS_ID`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";

	    $out = $this->db->query($tbl);

		$res = $this->db->query("SELECT * FROM u_business_impressions where date_format(TIMESTAMP,'%m') = " . $date . " AND  date_format(TIMESTAMP,'%Y') = " . date('Y') . "");
		
		print_r($res->result());
		if($res->result()){
			
			$array = $res->result_array();
			
			$this->db->insert_batch("u_business_impressions_" . date( 'Y_m'), $array);
			$out .= $this->db->query("DELETE FROM u_business_impressions WHERE date_format(TIMESTAMP,'%m') = " . $date . " AND  date_format(TIMESTAMP,'%Y') = " . date('Y') . "");
		}
		echo ' Total rows: '.count($res->result_array());
		//$clean = mysql_query('TRUNCATE TABLE `u_business_impressions`');
		
		
		/*$out .= json_encode($this->db->query('OPTIMIZE TABLE `u_business_impressions`'));
		$out .= json_encode($this->db->query('OPTIMIZE TABLE `u_business_impressions'. date( 'Y_m', time()) . '`'));
		$out .= json_encode($this->db->query('OPTIMIZE TABLE `u_business_imp_queue`'));
        $out .= json_encode($this->db->query('OPTIMIZE TABLE `u_business`'));*/
		
		echo $out;
		
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "Business Clean Impressions Database OPTIMIZE Notification";
		$message = "We have succesfully optimized business search database.".$out;
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->load->model('email_model');	
		$this->email_model->send_mail($message, $subject1, $to1,  $from1, 'My Analytics Cron', $TAG1);
		
	}
	//+++++++++++++++++++++++++++
	//UPDATE BUSINESS ANALYTICS IMPRESSIONS DAILY
	//++++++++++++++++++++++++++
	public function update_impressions_hourly()
	{
		error_reporting(E_ALL);
		//INSERT SOME IMPRESSIONS
		/*$dummy_query = "SELECT * FROM u_business";
		$result = $this->db->query("INSERT INTO u_business_imp_queue (QUERY)
								VALUES ('".$dummy_query."')");*/
		
		
		//mysql_select_db("my_na", $con);
		//GET ALL RESULTS FROM THE IMPRESSION QUEUE TABLE
		$result = $this->db->query('SELECT IMP_Q_ID,QUERY  FROM u_business_imp_queue ORDER BY IMP_Q_ID ASC LIMIT 100');
		$body1 = '';
		$total = 0;
		$total_searches = $result->num_rows();
		$x =0;
        echo $total_searches;
		if($total_searches > 0){
			$arr = array();
			 foreach($result->result_array() as $row)
	
			 {
				//for each profile run the loop functions
				$id = $row['IMP_Q_ID'];
				$query = $row['QUERY'];

				$x = $total + $this->update_business_search_impressions($id, $query,$total_searches); 
				//$x = 0; 
				$query4 = $this->db->query("DELETE FROM u_business_imp_queue WHERE IMP_Q_ID = '".$id."'");
				//$temp = array($id);
				array_push($arr, $id);
			 }
			 var_dump($arr);
			 echo implode(',', $arr);
			//$this->db->where_in('IMP_Q_ID', $arr);	 
			//$this->db->delete('u_business_imp_queue');
			
			echo "DELETE FROM u_business_imp_queue WHERE IMP_Q_ID IN ('".implode(',', $arr)."')";
			if(count($arr) > 0){
				$this->db->query("DELETE FROM u_business_imp_queue WHERE IMP_Q_ID IN (".implode(',', $arr).")");
			}
			
			$total = $x;	 
			//email_result($total,$total_searches);
			$body1.=   "Searches made today: " . $total_searches . "<br />";
			$body1.=   "Impressions made today: " . $total . "<br />";
			echo $body1; 
				
				 
		}else{
			
			echo 'No Searches Made';	
			
		}
		
		
		$to1 = array(array('email' => 'roland@my.na' ));
		$subject1 = "Business Impression hourly optimize Notification";
		$message = "We have succesfully optimized business search database.".$body1;
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->load->model('email_model');	
		
		$this->email_model->send_mail($message, $subject1, $to1,  $from1, 'My Analytics Cron', $TAG1);
		
	}
	//++++++++++++++++++++++++++++++++++++++++
	//LOOP THROUGH EADCH QUERY
	//++++++++++++++++++++++++++++++++++++++++			 
	function update_business_search_impressions($id, $query,$total_searches)
	{
		$total = 0;
		$this->db->db_debug = FALSE;
		if($result2 = $this->db->query($query)){
		
			$arr = array();
			if($result2->result()){
				
				foreach($result2->result_array() as $row2)
				{
					//for each query
					
					$data = array(
						'BUSINESS_ID' => $row2['ID']
					);
					
					/*$query3 = "INSERT INTO u_business_impressions (BUSINESS_ID)
								VALUES
								('" . $data['BUSINESS_ID'] . "')";  
							
					$result4 = $this->db->query($query3);*/			
					array_push($arr, $data);
					$total ++;
				 }
				
				
			}
	
			// var_dump($arr);
			// $this->db->set('BUSINESS_ID', $arr); 
			if(count($arr) > 0){
				
				if($this->db->insert_batch('u_business_impressions', $arr)){
				 
				 
				}
			}
		}
		$this->db->db_debug = TRUE;
		return $total;
	
	}	
	//+++++++++++++++++++++++++++
	//LIST S3 Buckets
	//++++++++++++++++++++++++++
	public function test_s3()
	{

	    $this->load->spark('amazon-sdk/0.2.0');
		$s3 = $this->awslib->get_s3();
		$result = $s3->list_buckets();
		echo '<pre>' . print_r($result, TRUE) . '</pre>';	 
	}
	
	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function upload_s32()
	{
		$filename = BASE_URL.'license.txt';
	    $this->load->spark('amazon-sdk/0.2.0');
		$s3 = $this->awslib->get_s3();
		
		//endpoint:   my.na.s3-website-eu-west-1.amazonaws.com
		$result = $s3->initiate_multipart_upload($bucket = 'mynamibia-eu', $filename, $opt = null);
		echo '<pre>' . print_r($result, TRUE) . '</pre>';	 
	}
	
	//+++++++++++++++++++++++++++
	//SEND TO S3 via AWS library
	//++++++++++++++++++++++++++
	public function upload_s3()
	{
		  error_reporting(E_ALL); 
		  
		  if($file = $this->input->get('file')){
			  
			  $filename = $file;
		  }else{
				 $filename = 'backup/post_1960.json';  
			  
		  }
		  
			//UPLOAD S3
		echo $this->cron_model->upload_s3($filename);
	}
	
	
	//+++++++++++++++++++++++++++
	//EXCTRACT GZIP FILE
	//++++++++++++++++++++++++++
	public function extract_gz($file = '')
	{
		error_reporting(E_ALL); 
		$path = BASE_URL.'backup/'.$file;
		system("gunzip ".$path."");
	}


	//+++++++++++++++++++++++++++
	//EXCTRACT GZIP FILE
	//++++++++++++++++++++++++++
	public function import_sql($file = '')
	{
		error_reporting(E_ALL); 

/*		define('DB_HOST', 'localhost');
		define('DB_NAME', 'mynamplt_new');
		define('DB_USER', 'mynamplt_mynew');
		define('DB_PASSWORD', 'yM*IimHd.uo2');*/

		define('DB_HOST', '127.0.0.1');
		define('DB_NAME', 'mynamplt_new');
		define('DB_USER', 'root');
		define('DB_PASSWORD', 'my_na$erv3r');
		
		
		$path = BASE_URL.'backup/'.$file;
		//$command = 'mysqldump --opt -h ' . DB_HOST . ' -u ' . DB_USER . ' -p\'' . DB_PASSWORD . '\' ' . DB_NAME . ' | gzip > ' . $backupFile;
		system("mysql -h " . DB_HOST . " -u ".DB_USER." -p".DB_PASSWORD." ". DB_NAME ." < ".$path);
		echo "mysql -h " . DB_HOST . " -u ".DB_USER." -p".DB_PASSWORD." ". DB_NAME ." < ".$path;
		
		//mysql -u root -ppakdwyejwxac mynamplt_new < /var/www/my.na/public_html/backup/products_my_db_2014-11-13.sql

	}

	//+++++++++++++++++++++++++++
	//EXCTRACT GZIP FILE
	//++++++++++++++++++++++++++
	public function import_sql2($file = '')
	{
		$file_name = 'products_my_db_2015-02-26.sql';
		$folder_name = '';
		$path = BASE_URL.'backup/'; // Codeigniter application /assets
		$file_restore = $this->load->file($path . $file_name, true);
		$file_array = explode(';', $file_restore);
		foreach ($file_array as $query)
		{
			$this->db->query("SET FOREIGN_KEY_CHECKS = 0");
			$this->db->query($query);
			$this->db->query("SET FOREIGN_KEY_CHECKS = 1");
			//echo $query;
		}

	}

	
	//+++++++++++++++++++++++++++
	//DAILY CLIENT EMAIL
	//++++++++++++++++++++++++++
	public function preview_email($id )
	{
		//$id = '1806';
		//GET ALL CLIENTS
		$this->db->where('ID', $id);
		$query = $this->db->get('u_client');
		
		if($query->result()){
			
			foreach($query->result() as $row){
				

				$data['client_id'] = $row->ID;
			    $data['preview_mail'] = 'yes';
				$this->load->view('email/body_client_daily',$data);
				
			}
		
			
		} 
		
		
		 
	}
	

	//+++++++++++++++++++++++++++
	//DAILY CLIENT EMAIL
	//++++++++++++++++++++++++++
	public function send_daily_email()
	{

		
		$id = '1806';
		$this->db->where('ID', $id);
		$this->db->where('EMAIL_NOTIFICATION', 'Y');
		$query = $this->db->get('u_client');
		$count = 0;
		if($query->result()){
						
			foreach($query->result() as $row){
				
				$data['client_id'] = $row->ID;
				$data['name'] = $row->CLIENT_NAME;
				
				//CACHE CONTENT
				$content = site_url('/').'cron_jobs/daily_email_body/';

				$cache = $this->cacheObject($content ,'daily_email.html',3600);
				
				echo $count . ' ' .$row->CLIENT_EMAIL .'<br />';
						  
				//BUILD MANDRILL ARRAY  
				$mandrill = array(array('email' => $row->CLIENT_EMAIL ));
				$data['client_id'] = $row->ID;
				$subject = 'My Namibia Daily';
				//SEND MANDRILL
				$body = 'Plain Email';
				$email = $this->load->view('email/body_client_daily',$data, TRUE);
				$this->send_email_do($email, $body, $subject, $mandrill);
				
				$count ++;
			}
		
			
		}
		
		echo 'Emails sent ' .$count;
		 
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL INSTANT
	//++++++++++++++++++++++++++++++++++++++++++++	
	function daily_email_body(){

		$this->cron_model->daily_email_body();
			
		
	}





	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL INSTANT
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_email_do($HTML, $TEXT, $subject, $mandrill){

			$this->load->config('mandrill');
	
			$this->load->library('mandrill');
			
			$mandrill_ready = NULL;
			
			try {
			
				$this->mandrill->init( $this->config->item('mandrill_api_key') );
				$mandrill_ready = TRUE;
				echo 'Ready';
				
			} catch(Mandrill_Exception $e) {
			
				$mandrill_ready = FALSE;
				echo $e;
			}
			
			if( $mandrill_ready ) {
				
				//Send us some email!
				  $email = array(
					  'html' => $HTML, //Consider using a view file
					  'text' =>  $TEXT,
					  'subject' => $subject,
					  'from_email' => 'no-reply@my.na',
					  'from_name' => 'My Namibia',
					  'to' => $mandrill
					  );
					  
				  $result = $this->mandrill->messages_send($email);	
				
			}else{
				
				echo 'Error';
				
			}
			
			
		
	}


    //++++++++++++++++++++++++++++++++++++++++++++
    //SEND EMAIL QUEUE
    //++++++++++++++++++++++++++++++++++++++++++++
    function send_email_queue()
    {
        error_reporting(E_ALL);

        //$query = $this->db->limit('200');
        $q = $this->db->query("SELECT DISTINCT(EMAIL_ID) FROM email_queue GROUP BY EMAIL_ID LIMIT 1");
        $x = 0;
        $temp = '';
        $out = '';

        if ($q->result()) {
            //var_dump($q->result());
            foreach ($q->result() as $row1) {

                $query = $this->db->query("SELECT * FROM email_queue WHERE EMAIL_ID = '" . $row1->EMAIL_ID . "' LIMIT 500");

                $array_to = array();
                $global_merge = array();
                $merge = array();
                $to = array();
                foreach ($query->result() as $row) {

                    if (trim($row->TO) != '') {

                        $HTML = $row->BODY;
                        $subject = $row->SUBJECT;

                        //BUILD ARRAY FOR EMAILS
                        $d = array(
                            'email' => $row->TO
                        );
                        array_push($array_to, $d);

                        //$mandrill = array(array('email' => $row->TO ));

                        //BUILD MERGE VARIABLES
                        $global = array(

                            'name' => 'link1',
                            'content' => 'global_content'

                        );
                        array_push($global_merge, $global);

                        $m = array(

                            'rcpt' => $row->TO,
                            'vars' => array(array(

                                'name' => 'name',
                                'content' => $row->NAME

                            ))

                        );
                        array_push($merge, $m);

                        $TAG['client_id'] = $row->EMAIL_ID;


                        $FROM_EMAIL = $row->FROM;
                        $FROM_NAME = $row->FROM_NAME;

                        //insert log
                        $this->db->insert('email_queue_log', $row);

                        //delete
                        $this->db->where('MAIL_ID', $row->MAIL_ID);
                        $this->db->delete('email_queue');

                        $out .= $row->TO . '<br />';


                        $x++;

                        //blank email - only delete
                    } else {

                        //delete
                        $this->db->where('MAIL_ID', $row->MAIL_ID);
                        $this->db->delete('email_queue');

                    }

                }

                echo '<br /><br />';
                var_dump($array_to);
                //ADD EMAIL LIST TO MANDRILL ARRAY
                $mandrill = $array_to;
                $TAG = array($row->EMAIL_ID);
                //var_dump($array_to);
                //SEND MASS EMAIL
                if($this->send_email($HTML, $subject, $mandrill,  $FROM_EMAIL, $FROM_NAME, $TAG, true, $global_merge, $merge, $row1->EMAIL_ID)){


                }else{

                    $out .= '!!!!!Double Up'.$row->TO.'<br />';

                }

                echo ' : ' . $row1->EMAIL_ID . '<br />';
                echo $x . '<br /><br />';

                $email_id = $row1->EMAIL_ID;
            }


        }

        echo $x . ' emails sent';

        //ONLY SEND IF BIG LIST
        if ($x > 1) {

            $to1 = array(array('email' => 'roland@my.na', 'email' => 'info@my.na'));
            $subject1 = "My.na Email Queue";
            $message = "We have succesfully sent " . $x . " mass emails. From: " . $FROM_EMAIL . " Subject: " . $subject . '<br /><br />' . $out;
            $from1 = "no-reply@my.na";
            $headers = "From:" . $from1 . "\r\n" .
                "CC: wilko@intouch.com.na";
            $TAG1 = array('tags' => 'cron_note');
            //mail($to,$subject,$message,$headers);
            $this->send_email($message, $subject1, $to1, $from1, 'My Namibia', $TAG1, $important = false, $global_merge = '', $merge = '', $email_id);
        }

    }
    //++++++++++++++++++++++++++++++++++++++++++++
    //PASS PARAMETERS AND SEND EMAIL
    //++++++++++++++++++++++++++++++++++++++++++++
    function send_email($HTML, $subject, $mandrill,$FROM_EMAIL, $FROM_NAME, $TAG, $important = false, $global_merge = '', $merge = '', $email_id){

        $this->load->config('mandrill');

        $this->load->library('mandrill');

        $mandrill_ready = NULL;

        try {

            $this->mandrill->init( $this->config->item('mandrill_api_key') );
            $mandrill_ready = TRUE;

        } catch(Mandrill_Exception $e) {

            $mandrill_ready = FALSE;

        }

        if( $mandrill_ready ) {

            //Send us some email!
            $email = array(
                'html' => $HTML, //Consider using a view file
                'text' =>  $this->strip_html_tags($HTML),
                'subject' => $subject,
                'from_email' => 'no-reply@my.na',
                'headers' => array('Reply-To' => $FROM_EMAIL),
                'from_name' => $FROM_NAME,
                'tags' => $TAG,
                'to' => $mandrill,
                'google_analytics_domains' => array('my.na'),
                'google_analytics_campaign' => 'mail',
                'important' => true ,
                'global_merge_vars' => $global_merge,
                'merge_vars' => $merge
            );
			
			if($FROM_NAME == 'My Namibia'){
				$template_content = array(
	
					'template_content' => array(
	
						'name' => 'BODY',
						'content' => $HTML
					),
					array(
	
						'name' => 'LINK',
						'content' =>  'Email not displaying properly? <a href="'.site_url('/').'feeds/email/'.$email_id.'">View it in your browser</a>'
					),
					array(
	
						'name' => 'SUBJECT',
						'content' =>  $subject
					)
	
				);
				//$result = $this->mandrill->messages_send($email);
				$result = $this->mandrill->messages_send_template('my-na', $template_content, $email);
			}else{
				
				$result = $this->mandrill->messages_send($email);
				
			}
        }

        return $mandrill_ready;

    }



	//+++++++++++++++++++++++++++++
	//Monthly Business reports
	//++++++++++++++++++++++++++++
	function business_reports(){

		$o = $this->cron_model->business_reports();
		echo json_encode($o);

	}

	//+++++++++++++++++++++++++++++
	//Monthly Business reports
	//++++++++++++++++++++++++++++
	function generate_business_report($bus_id, $period){

		$o = $this->cron_model->generate_business_report($bus_id, $period);
		echo json_encode($o);

	}


	//+++++++++++++++++++++++++++++
	//PROCESS WORKER REQUEST QUEUE
	//++++++++++++++++++++++++++++
	function worker_requests(){

		/*if(isset($_SERVER['MY_WORKER']) && $_SERVER['MY_WORKER'] == 'YES')
		{*/
			$o = $this->cron_model->worker_requests();
			echo json_encode($o);
		/*}else{

			echo json_encode({'success': false, 'msg': 'Can Only be requested by the My.na Worker Machine'});
		}*/
	}




    //To remove all the hidden text not displayed on a webpage
    function strip_html_tags($str){
        $str = preg_replace('/(<|>)\1{2}/is', '', $str);
        $str = preg_replace(
            array(// Remove invisible content
                '@<head[^>]*?>.*?</head>@siu',
                '@<style[^>]*?>.*?</style>@siu',
                '@<script[^>]*?.*?</script>@siu',
                '@<noscript[^>]*?.*?</noscript>@siu',
            ),
            "", //replace above with nothing
            $str );
        $str = $this->replaceWhitespace($str);
        $str = strip_tags($str);
        return $str;
    } //function strip_html_tags ENDS

    //To replace all types of whitespace with a single space
    function replaceWhitespace($str) {
        $result = $str;
        foreach (array(
                     "  ", " \t",  " \r",  " \n",
                     "\t\t", "\t ", "\t\r", "\t\n",
                     "\r\r", "\r ", "\r\t", "\r\n",
                     "\n\n", "\n ", "\n\t", "\n\r",
                 ) as $replacement) {
            $result = str_replace($replacement, $replacement[0], $result);
        }
        return $str !== $result ? $this->replaceWhitespace($result) : $result;
    }

	//+++++++++++++++++++++++++++
	//HOURLY TRADE EMAIL SCRIPT
	//++++++++++++++++++++++++++
	public function trade_houseworking()
	{
		//$id = '1806';
		//GET ALL CLIENTS
		$this->db->where('ID', $id);
		$query = $this->db->get('u_client');
		
		if($query->result()){
			
			foreach($query->result() as $row){
				

				$data['client_id'] = $row->ID;
			    $data['preview_mail'] = 'yes';
				$this->load->view('email/body_client_daily',$data);
				
			}
		
			
		} 
		
		
		 
	}	
	
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//TRADE MAINTENANCE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//DAILY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		
	function daily_trade_maintenance()
    { 
		

		
		//WATCHLIST EXPIRE
		$q2 = $this->db->query("SELECT * FROM products 
								JOIN products_watchlist ON products.product_id = products_watchlist.product_id
								JOIN u_client ON products_watchlist.client_id = u_client.ID
								WHERE products.is_active = 'Y' AND status = 'live'
								AND DATE(products.end_date) = '".date('Y-m-d')."'
								");
		$x = 0;
		if($q2->result()){
			
			foreach($q2->result() as $row2){
				
				//WATCHLIST EXPIRE
				if($this->cron_model->watchlist_expired_products($row2)){
					
					$x ++;
				}
				
				//NEXT ...
				
				
			}
			
			
		}
		//THEN, UPDATE PRODUCTS WHICH HAVE BEEN LISTED FOR 30 DAYS ISACTIVE = N
		$q = $this->db->query("SELECT products.*,product_extras.extas  FROM products
								JOIN u_client ON products.client_id = u_client.ID
								LEFT JOIN product_extras on products.product_id = product_extras.product_id
								WHERE DATE(products.end_date) = '".date('Y-m-d')."' AND products.is_active = 'Y' AND status = 'live'");
		//SEE IF ITEM IS OLDER THAN 30 DAYS
        //$list_date = strtotime($row->start_date);
        //$expire_date = date('Y-m-d', strtotime($row->end_date));
        //$next_date = date('Y-m-d', strtotime($row->end_date . ' + 30 days'));

        $z = 0;
		if($q->result()){
			
			foreach($q->result() as $row){
				
				//UPDATE PRODUCT STATUS AFTER 30 DAYS IF NOT SOLD
				if($this->cron_model->expired_products($row)){
					
					$z ++;
				}
				
				//NEXT ...
				
				
			}
			
			
		}

		
		//SEND NOTIFICATION OF CHANGE
		$emailTO =  array(array('email' => 'roland@my.na')); 
		$emailFROM = 'no-reply@my.na';
		$name = 'My Namibia Trade';
		$subject = 'Daily Trade Maintenance';
		$body = "Daily trade maintenance has run. <br />".$z." products expired today.<br /><br />".$x." watchlist email have been sent today
				  My Namibia";
	   
		$TAGS = array('tags' => 'cron_job');
		$this->load->model('email_model');	
		
		$this->email_model->send_mail($body, $subject, $emailTO, $emailFROM, $name, $TAGS);
		
		
		echo $body."<br /><br /><br />Mail Sent.";

    }   
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//HOURLY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function hourly_trade_maintenance()
    { 
		$this->db->where('is_active', 'Y');
		$this->db->where('status', 'live');	
		$q = $this->db->get("products");
		if($q->result()){
			
			foreach($q->result() as $row){
				
				var_dump($row);
				//WATCHLIST EXPIRE
				//$this->cron_model->expired_products($row);
				
				
				//OUTBID ON AUCTION
				
				//NEXT ...
				
				
			}
			
			
		}
    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //5 MINUTE MAINTENANCE
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function minute_auction_trade_maintenance()
    {
        $this->load->model(array('trade_model', 'email_model'));
        $this->load->library('curl');

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //CHECK AUCTION ITEMS , RESERVE MET and BUYER CONFIRMED - MARK as SOLD
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $query = $this->db->query("SELECT products.*, u_client.CLIENT_NAME, u_client.CLIENT_CELLPHONE,u_client.ID as seller_id,
                                  u_client.VERIFIED, u_client.CLIENT_EMAIL,product_images.img_file, MAX(product_auction_bids.bid_id) as max_bid, MAX(product_auction_bids.amount) as amount
                                  FROM products
                                  LEFT JOIN product_extras on products.product_id = product_extras.product_id
                                  LEFT JOIN product_images on products.product_id = product_images.product_id
                                  LEFT JOIN product_auction_bids ON products.product_id = product_auction_bids.product_id
                                  JOIN u_client on products.client_id = u_client.ID
                                  WHERE products.listing_type = 'A' AND products.status = 'live' AND products.is_active = 'Y'
                                  AND products.end_date < NOW()
                                  GROUP BY products.product_id
                                  ORDER BY products.end_date DESC
                                  ", FALSE);


        if($query->result()){
            echo 'Wohoo, we have items ';
            foreach($query->result() as $row){
                echo $row->product_id;

                //SELLER DETAILS
                $seller_email = $row->CLIENT_EMAIL;
                $seller_id = $row->seller_id;
                $product_id = $row->product_id;
                $seller_name = $row->CLIENT_NAME;
                $seller_verified = $row->VERIFIED;
                $seller_cell = $row->CLIENT_CELLPHONE;
                $product = $row->title;
                $productD = $row->description;

                //TEST RESRVE is MET
                if($row->amount > $row->reserve){

                    //CHECK IF BUYER
                    if($row->max_bid != null){


                        $s = $this->db->query("SELECT product_auction_bids.*, u_client.CLIENT_NAME, u_client.CLIENT_CELLPHONE, u_client.ID as buyer_id,
                                              u_client.VERIFIED, u_client.CLIENT_EMAIL
                                              FROM product_auction_bids
                                              JOIN u_client on product_auction_bids.client_id = u_client.ID
                                              WHERE product_auction_bids.product_id = '".$row->product_id."'
                                              ORDER BY product_auction_bids.amount  DESC LIMIT 1
                                              ", FALSE);
                        //MARK AS SOLD AND SEND EMAIL
                        if($s->result()){
                            $buyer = $s->row();
                            $buyer_email = $buyer->CLIENT_EMAIL;
                            $buyer_name = $buyer->CLIENT_NAME;
                            $buyer_verified = $buyer->VERIFIED;
                            $buyer_cell = $buyer->CLIENT_CELLPHONE;
                            $buyer_id = $buyer->buyer_id;
                            //SEN SMS TO BUYER
                            if($buyer_verified == 'Y'){

                                //SEND SMS
                                $SMS = 'You have won the auction for '.$this->trade_model->shorten_string($product,3).'. Final bid is N$' .$buyer->amount.' http://my.na/u/p/'.$buyer->product_id;

                                //LOAD LIBRARIES FOR API AND SEND SMS
                                $this->load->library('rest', array(
                                    'server' => 'http://sms.my.na/api/sms/',
                                    'http_user' => 'myna_ma$ster',
                                    'http_pass' => '#$5_jh56_hdgd',
                                    'http_auth' => 'basic' // or 'digest'
                                ));
                                $sms_out = $this->rest->get('send', array('number' => $buyer_cell, 'msg' => $SMS), 'json');

                            }

                            //SEND EMAIL
                            //SEND NOTIFICATION OF SOLD to BUYER
                            $this->cron_model->auction_winner_email($buyer, $row);


                            //SEN SMS TO BUYER
                            if($seller_verified == 'Y'){

                                //SEND SMS
                                $SMS2 = 'Your item on auction: '.$this->trade_model->shorten_string($product,3).'. has been sold for N$' .$buyer->amount.' http://my.na/u/p/'.$buyer->product_id;

                                //LOAD LIBRARIES FOR API AND SEND SMS
                                $this->load->library('rest', array(
                                    'server' => 'http://sms.my.na/api/sms/',
                                    'http_user' => 'myna_ma$ster',
                                    'http_pass' => '#$5_jh56_hdgd',
                                    'http_auth' => 'basic' // or 'digest'
                                ));
                                $sms_out2 = $this->rest->get('send', array('number' => $seller_cell, 'msg' => $SMS2), 'json');

                            }


                            //SEND NOTIFICATION OF SOLD to SELLE
                            $this->cron_model->auction_seller_email($buyer, $row);

                            //UPDATE STATUS to SOLD
                            $d['status'] = 'sold';

                            //INSERT INTO PRODUCTS BUY NOW TABLE as ACUTION
                            $buynow['product_id'] = $product_id;
                            $buynow['client_id'] = $buyer_id;
                            $buynow['seller_id'] = $seller_id;
                            $buynow['bus_id'] = $row->bus_id;
                            $buynow['amount'] = $buyer->amount;
                            $buynow['type'] = 'auction';
                            $this->db->insert('products_buy_now', $buynow);

                        }//END IF BID WAS PLACES


                    }//END TEST IF BID WAS POLACED


                }else{//REZSERVE NOT MET

                    //SEND RESERVE NOT MET EMAIL
                    $this->cron_model->auction_reserve_not_met($row);

                }//END IF RESRVE NOT ET

                //UPDATE PRODUCT STATUS TO N
                $d['is_active'] = 'N';

                $this->db->where('product_id', $product_id);
                $this->db->update('products', $d);

            }//END FOREACH EXPIRING PRODUCTS


        }//END IF EXPIRING PRODUCTS
    }



    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //5 MINUTE MAINTENANCE NOTIFICATIONS
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function hour_product_notifications()
    {
        error_reporting(E_ALL);
        $this->load->model(array('trade_model', 'email_model'));
        $this->load->library('curl');

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //CHECK AUCTION ITEMS , RESERVE MET and BUYER CONFIRMED - MARK as SOLD
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        $now = date('Y-m-d H:i:s');
        $hour = date('Y-m-d H:i:s', strtotime("+ 1 hour"));

        echo $now. ' ' .$hour;

        $query = $this->db->query("SELECT products.*, u_client.CLIENT_NAME, u_client.CLIENT_CELLPHONE,u_client.ID as seller_id,
                                  u_client.VERIFIED, u_client.CLIENT_EMAIL,product_images.img_file, MAX(product_auction_bids.bid_id) as max_bid, MAX(product_auction_bids.amount) as amount
                                  FROM products
                                  LEFT JOIN product_extras on products.product_id = product_extras.product_id
                                  LEFT JOIN product_images on products.product_id = product_images.product_id
                                  LEFT JOIN product_auction_bids ON products.product_id = product_auction_bids.product_id
                                  JOIN u_client on products.client_id = u_client.ID
                                  WHERE products.status = 'live' AND products.is_active = 'Y' AND products.end_date BETWEEN '".$now."' AND '".$hour."'
                                  GROUP BY products.product_id
                                  ORDER BY products.end_date DESC
                                  ", FALSE);
        //AND products.end_date >= (NOW() - INTERVAL 1 HOUR)
        //WHERE products.status = 'live' AND products.is_active = 'Y' AND products.end_date BETWEEN '".$now."' AND '".$hour."'

        if($query->result()) {


            echo 'Wohoo, we have items ';
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            //FOREACH PRODUCT
            //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            foreach ($query->result() as $row) {

                //SETUP MAIL MERGE
                $array = array();
                $global_merge = array();
                $merge = array();

                $expiry = date('l jS \of F Y h:i:s A', strtotime($row->end_date));
                $product_id = $row->product_id;
                $product_title = $row->title;
                $product_d = $row->description;

                $image = base_url('/').'img/product_blank.jpg';

                if(strlen($row->img_file) > 1){

                    $image = base_url('/').'img/timbthumb.php?src='.CDN_URL.'assets/products/images/'.$row->img_file.'&w=580&h=300';

                }
                //ADD SELLER TO EMAIL ARRAY
                $a = array(
                    'email' =>    $row->CLIENT_EMAIL
                );


                array_push($array, $a);
                //BUILD MERGE VARIABLES
                $global = array(

                    'name' => 'link1',
                    'content' => 'global_content'

                );
                array_push($global_merge, $global);

                $a2 = array(

                    'rcpt' => $row->CLIENT_EMAIL,
                    'vars' => array(
                        array(

                            'name' => 'name',
                            'content' => $row->CLIENT_NAME

                        ),
                        array(
                            'name' => 'product_title',
                            'content' => $product_title

                        ),
                        array(
                            'name' => 'image',
                            'content' => $image

                        ), array(
                            'name' => 'product_id',
                            'content' => $product_id

                        ), array(
                            'name' => 'expiry',
                            'content' => $expiry

                        ), array(
                            'name' => 'description',
                            'content' =>  $product_d

                        )
                    )

                );
                array_push($merge, $a2);


                echo 'Item: '.$row->product_id. ' '. $row->title.' ' .date('Y-m-d H:i:s', strtotime($row->end_date)).'<br />';
                //GET ALL WATCHLIST PEOLPE AND
                $s = $this->db->query("SELECT DISTINCT(products_watchlist.client_id) as watch_client_id, u_client.ID, u_client.CLIENT_EMAIL,u_client.CLIENT_NAME, u_client.VERIFIED, u_client.CLIENT_CELLPHONE
                                        FROM u_client
                                        JOIN products_watchlist ON products_watchlist.client_id = u_client.ID
                                        WHERE products_watchlist.product_id = '".$row->product_id."'
                                        ");
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                //FOREACH WATCHLIST ITEM
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if($s->result()){


                    foreach($s->result() as $srow){

                        //$d['email'] =  $srow->CLIENT_EMAIL;
                        //$d['']
                        $d = array(
                            'email' =>    $srow->CLIENT_EMAIL
                        );


                        array_push($array, $d);
                        //BUILD MERGE VARIABLES
                        $global = array(

                            'name' => 'link1',
                            'content' => 'global_content'

                        );
                        array_push($global_merge, $global);

                        $m = array(

                            'rcpt' => $srow->CLIENT_EMAIL,
                            'vars' => array(
                                array(

                                    'name' => 'name',
                                    'content' => $srow->CLIENT_NAME

                                ),
                                array(
                                    'name' => 'product_title',
                                    'content' => $product_title

                                ),
                                array(
                                    'name' => 'image',
                                    'content' => $image

                                ), array(
                                    'name' => 'product_id',
                                    'content' => $product_id

                                ), array(
                                    'name' => 'expiry',
                                    'content' => $expiry

                                ), array(
                                    'name' => 'description',
                                    'content' =>  $product_d

                                )
                            )

                        );
                        array_push($merge, $m);

                    }//end for all watchlist

                }//end if result watchlist


                //GET ALL BIDDERS
                //GET ALL WATCHLIST PEOLPE AND
                $ss = $this->db->query("SELECT DISTINCT(product_auction_bids.client_id) as watch_client_id, u_client.ID, u_client.CLIENT_EMAIL,u_client.CLIENT_NAME, u_client.VERIFIED, u_client.CLIENT_CELLPHONE
                                        FROM u_client
                                        JOIN product_auction_bids ON product_auction_bids.client_id = u_client.ID
                                        WHERE product_auction_bids.product_id = '".$row->product_id."'
                                        ");



                $array2 = array();
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                //FOREACH BIDDER
                //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                if($ss->result()){

                    foreach($ss->result() as $s2row){

                        $dd = array(
                            'email' =>    $s2row->CLIENT_EMAIL
                        );

                        //$dd['email'] =  $s2row->CLIENT_EMAIL;
                        if(in_array($dd,$array)){

                            echo 'Already Present '.$s2row->CLIENT_EMAIL;
                        }else{

                            array_push($array, $dd);
                            //BUILD MERGE VARIABLES
                            $global = array(

                                'name' => 'link1',
                                'content' => 'global_content'

                            );
                            array_push($global_merge, $global);

                            $m = array(

                                'rcpt' => $s2row->CLIENT_EMAIL,
                                'vars' => array(
                                    array(

                                    'name' => 'name',
                                    'content' => $s2row->CLIENT_NAME

                                    ),
                                    array(
                                        'name' => 'product_title',
                                        'content' => $product_title

                                    ),
                                    array(
                                        'name' => 'image',
                                        'content' => $image

                                    ), array(
                                        'name' => 'product_id',
                                        'content' => $product_id

                                    ), array(
                                        'name' => 'expiry',
                                        'content' => $expiry

                                    ), array(
                                        'name' => 'description',
                                        'content' =>  $product_d

                                    )
                                )

                            );
                            array_push($merge, $m);

                        }


                    }//end for all bidding

                }//end if result bidding

                //ADD info@my.na
                $f = array(
                    'email' => 'info@my.na'
                );

                array_push($array, $f);
                //print_r($array);
                //echo ' <br /> 1----------------- <br />';
               // var_dump($merge);
               // echo ' <br /> 2----------------- <br />';
                //BUILD EMAIL

                $emailTO =  $array;
                //echo ' <br /> FINAL------- <br />';
                //var_dump($emailTO);

                $emailFROM = 'no-reply@my.na';
                $name = 'My Namibia Trade Notification';
                $subject = 'Ending Soon - '.$product_title;
                $body = 'Hi *|name|*, <br /><br />
							The product on My Namibia Trade&trade;: *|product_title|* is expiring Soon.

							<br /><br />
							<h1 align="center" style="text-align:center; color:#900; font-size:400%" class="upper yellow big_icon">EXPIRING SOON!</h1>
							<h2 align="center" style="text-align:center; font-size:200%" class="upper yellow big_icon">*|expiry|*</h2>
							<table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
									 <tr>
										<td style="width:100%" class="white_box"><img src="*|image|*" alt="download picture to view"></td>
									 </tr>
							</table><br />
							<br />
							*|description|*
							<br /><br />

							Hurry up to avoid disappointment.
							<br /><br />
							View the product <a href="https://www.my.na/product/*|product_id|*/">here.</a><br /><br />
							<br />
							Have a !tna day!<br />
							My Namibia';
                $data_view['body'] = $body;
                $body_final = $this->load->view('email/body_news',$data_view,true);
                $TAGS = array('tags' => 'product_expiry_notification');
                $out = $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS, $important = true, $global_merge, $merge);

                //var_dump($out);

                //echo $body_final;



            }



        }


    }

    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //first night registration email set   EMAIL SEQUENCE
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    function user_email_sequence()
    {
        error_reporting(E_ALL);
        $this->load->model(array('trade_model', 'email_model'));
        $this->load->library('curl');

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //   1.  DAY OF REGISTERING
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //COMING soon
        $now = date('Y-m-d');


        //FIX FOR HOW TO LIST PRODUCT
        if($now < '2015-08-13'){

            return;
            die();

        }

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //  2.  3 Days After registering
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //GET REGSITERED USERS

        $days = date('Y-m-d', strtotime("- 3 days"));
        echo $days;

        $ss = $this->db->query("SELECT * FROM u_client WHERE DATE(REGISTER_DATE) = '".$days."' AND EMAIL_NOTIFICATION = 'Y'");

        if($ss->result()){

            $array = array();
            //BUILD EMAIL ARRAY
            foreach($ss->result() as $row){

                $t = array('email' => $row->CLIENT_EMAIL);
                array_push($array, $t);

            }

            var_dump($array);

            $body = '<h1 align="center" style="text-align:center;  font-size:300%" class="upper yellow big_icon">How to List Your First Product</h1>
                    <p>We thought you could use a little step by step instructions to get you started selling your old items online.</p>
                    <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
                             <tr>
                                <td style="width:100%" class="white_box"><img src="'. base_url('/').'img/email/list/step1.jpg" alt="download picture to view step 1"></td>
                             </tr>
                    </table><br />
                    <em>On the Main Navigation Bar</em></p>
                    <ul>
                     <li>Click List Anything </li>
                     <li>On drop down click - Sell Anything</li>
                    </ul>
                    <h2 class="upper yellow big_icon">Select What to Sell</h2>
                    <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
                             <tr>
                                <td style="width:100%" class="white_box"><img src="'. base_url('/').'img/email/list/step2.jpg" alt="download picture to view step 2"></td>
                             </tr>
                    </table><br />
                    <ul>
                     <li>You can choose to list your product via your  personal profile or business</li>
                     <li>Choose either General Items, Car Boat Bike or  Property and click List now</li>
                     <li>Select product Category</li>
                    </ul>
                    <h2 class="upper yellow big_icon">Select a Relevant Category</h2>
                        <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
                                 <tr>
                                    <td style="width:100%" class="white_box"><img src="'. base_url('/').'img/email/list/step3.jpg" alt="download picture to view step 3"></td>
                                 </tr>
                        </table><br />
                    <ul>
                     <li>Choose sub category and click Next</li>
                     <li>Item – Add the Product title </li>
                     <li>Item Description - Please describe the item or  product with specific detail like condition and relevant specifications</li>
                    </ul>
                     <h2 class="upper yellow big_icon">Item Specifics &amp; Description</h2>
                        <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
                                 <tr>
                                    <td style="width:100%" class="white_box"><img src="'. base_url('/').'img/email/list/step4.jpg" alt="download picture to view step 4"></td>
                                 </tr>
                        </table><br />
                    <ul>
                     <li>Add Location and Suburb of the location</li>
                     <li>Click Fixed Price or Auction</li>
                    </ul>
                    <p>If you want to <strong>Auction</strong> the  product, please put in the starting bid and the reserve value. If the reserve  bid hasn&rsquo;t been matched at the end of the auction the item is not sold.  Your auction will run automatically for 7  Days</p>
                    <ul>
                     <li>Add the quantities available</li>
                     <li>Please provide specific payment instruction for  when the item is bought</li>
                     <li>Click Next</li>
                     <li>Please add some photos or images </li>
                    </ul>

                    <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
                             <tr>
                                <td style="width:100%" class="white_box"><img src="'. base_url('/').'img/email/list/step5.jpg" alt="download picture to view step 5"></td>
                             </tr>
                    </table><br />

                    <p>Click Add Files,  select photos/images, click start upload</p>
                    <h2 class="upper yellow big_icon">Add Images</h2>
                    <table border="0" cellpadding="5"  cellspacing="0" width="100%;max-width:580px">
                             <tr>
                                <td style="width:100%" class="white_box"><img src="'. base_url('/').'img/email/list/step6.jpg" alt="download picture to view step 6"></td>
                             </tr>
                    </table><br />
                    <ul>
                     <li>Click Next</li>
                     <li>Only for Properties, Cars and Bikes you can add  Extras (Engine size, bedrooms etc)</li>
                     <li>Click Next</li>
                     <li>Please click Publish so we can approve it and  make it live</li>
                    </ul>
                    <p><strong><em>NB: Items with a proper description and detailed photos sell far  quicker than ones without. </em></strong><br />
                     Please note that your product will be live within 8 hours of  listing</p>
                      <br />
                      <p style="text-align:center"><a href="'.site_url('/').'sell/index/" style="color:#fff;font-size:150%; text-decoration:none" class="btn">List Your First Product Here</a></p>
                       <br />
                      Have a great time buying and selling in Namibia<br />
                      My Namibia';

                $emailTO =  $array;
                //echo ' <br /> FINAL------- <br />';
                //var_dump($emailTO);

                $emailFROM = 'no-reply@my.na';
                $name = 'My Namibia';
                $subject = 'How To List Your First Product';

                $data_view['body'] = $body;
                $body_final = $this->load->view('email/body_news',$data_view,true);
                $TAGS = array('tags' => 'user_email_sequence2');
                $out = $this->email_model->send_mail($body_final, $subject, $emailTO, $emailFROM, $name, $TAGS, $important = true, $global_merge = '', $merge = '');

                echo $body_final;

        }




    }


    //+++++++++++++++++++++++++++
    //EMAIL STATS PER TAG
    //++++++++++++++++++++++++++
    //
    //
    //
    //+++++++++++++++++++++++++++
    //EMAIL STATS PER TAG
    //++++++++++++++++++++++++++
    public function get_email_tags_stats($id = '')
    {
        $this->load->model('cron_model');
        $this->cron_model->get_email_tags_stats();


    }
    //+++++++++++++++++++++++++++
    //EMAIL WEBHOOK FOR EVERY EVENT
    //++++++++++++++++++++++++++
    //
    //
    //
    //+++++++++++++++++++++++++++
    //EMAIL STATS PER TAG
    //++++++++++++++++++++++++++
    //+++++++++++++++++++++++++++
    //EMAIL WEBHOOK TO MANDRILL
    //++++++++++++++++++++++++++
    function email_events()
    {

        /* $http_origin = $_SERVER['HTTP_ORIGIN'];

         if ($http_origin == "https://teamnamibia.my.na" || $http_origin == "https://ncci.my.na")
         {
             //$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
         }*/

        $this->output->set_header("Access-Control-Allow-Origin: * ");
        $this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
        $this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

        $this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
        //PReflight
        if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

            //$this->output->set_output( "*" );
            //$this->output->set_header("Access-Control-Allow-Credentials: true");
            //echo 'OPTIONS';

        }elseif($_SERVER['REQUEST_METHOD'] == "POST") {


            /**/

            $this->insert_email_events();


        }

    }

    //+++++++++++++++++++++++++++
    //INSERT EMAIL EVENTS
    //++++++++++++++++++++++++++
    function insert_email_events()
    {

        if(isset($_POST['mandrill_events'])){
            $x = 0;
            //foreach(json_decode($_POST['mandrill_events']) as $pe){

                $data['mandrill_events'] = json_decode($_POST['mandrill_events']);

                //$this->db->insert('email_events', $data);
                //$row = $pe;
                $row = json_decode($_POST['mandrill_events']);

                $x2 = 0;

                //test tags ARRAY
                if (is_array($row[0]->msg->tags)) {

                    //LOOP TAGS
                    foreach ($row[0]->msg->tags as $trow) {

                        if ($x2 == 0) {


                            $email_id = $trow;
                            $in['email_id'] = $email_id;
                            $in['tag'] = $trow;

                            $x2++;


                        }

                    }

                }
                $in['status'] = $row[0]->event;
                $in['mandrill_events'] = json_encode($row[0]);
                $this->db->insert('email_events', $in);

                // echo $row[0]->event . ' ' . $row[0]->msg->subject . ' Tags: - ' . $email_id . '< br />';
                $x++;

            //}



        }else{


        }

        //echo $x .' Records';

    }
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CACHE EMAIL FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function cacheObject($url,$name,$age = 86400)
    { 
        // directory in which to store cached files
        $cacheDir = BASE_URL."application/views/email/cache/";
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

	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */