<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class My_sitemap extends CI_Controller {
	
	function my_sitemap()
	{
		parent::__construct();
		
		$this->load->library('MY_GeoRss_writer');
		$this->load->helper('date');
	}
	
	function index($offset = '')
	{	

		echo 'Going Nowhere slowly...';
		
	}
	

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//GOOGLE GeoRss FEED
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function childcarein($reg_id,$dis_id)
	{	
// Load XML writer library

    $this->load->library('MY_Xml_writer');
     $this->load->helper('date');
    // Initiate class
    $xml = new MY_Xml_writer;
    $xml->setRootName("urlset");
    $xml->initiate();
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
	$xml->startBranch('url');	
			
				$this->load->model('child_model');
				$query = $this->child_model->get_district_sitemap($dis_id);
		// Start branch 1
				
		
		foreach ($query->result() as $row) {
				
								
						$title  = $row->center;
						$id  = $row->pro_id;
						$img  = $row->img_file;
						$phone  = $row->tel;
						$email  = $row->email;
						$region  = $row->reg_id;
						$district  = $row->dis_id;
						$latlong  = $row->latlong;
						$street  = $row->street;
						$suburb  = $row->sub_id;
						$post  = $row->postcode;
						$link = site_url() . 'profile/pro_view/' . $this->child_model->get_permalink($id);
						
						if ($row->img_file != ''){
							$imagestr = '<img src="' . base_url() . 'profile/' . $id . '/images/thumbs/' . $row->img_file .'" style="width:85px; height:auto;float:left;padding:5px"/>';
						
						}else{
							$imagestr = '<img src="' . base_url() . 'img/bground/no_image.jpg" style="width:85px; height:auto;float:left;padding:5px"/>';
						
						}
						
						$description = '<div>' . $imagestr . '<a href="' . $link . '"><strong>' . $this->child_model->get_title($id) . '</strong></a><br />'  . $street . '<br />' . $suburb . '<br />' . $district . '<br />' . $post . '</div>';
						
						$xml->startBranch('entry');
						
							$xml->addNode('title' ,$this->child_model->get_title_clean($id));	
							
							$xml->startBranch('author');
								$xml->addNode('name', $this->child_model->get_title_clean($id));	
								$xml->addNode('email', $email);	
							$xml->endBranch();
								
								$xml->addNode('georss:point',str_replace('(','',str_replace(')','',$latlong)));
								//$xml->addNode('description', $description);
								$xml->addNode('content', $description);
								$xml->addNode('link', $link);
								$xml->addNode('address', str_replace("'","",$street) . ' ' . $suburb . ' ' . $district . ' ' . $region . ' ' . $post . ' ' . 'New Zealand');
								$xml->addNode('phone', $phone);
								
								
						$xml->endBranch();
					
					}
	$xml->endBranch();
    // Print the XML to screen
    $xml->getXml(true);
}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GOOGLE GeoRss FEED for BUSINESS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function business()
	{	
		// Load XML writer library
	
		$this->load->library('MY_Xml_writer');
		 $this->load->helper('date');
		// Initiate class
		$xml = new MY_Xml_writer;
		$xml->setRootName("urlset");
		$xml->initiate();
		$xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$xml->writeAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');	
			
			$this->db->where('ISACTIVE', 'Y');	
			$query = $this->db->get('u_business');
			
			foreach ($query->result() as $row) {
					
									
							$title  = $row->BUSINESS_NAME;
							$id  = $row->ID;
							$img_file  = $row->BUSINESS_LOGO_IMAGE_NAME;
							$phone  = $row->BUSINESS_TELEPHONE;
							$email  = $row->BUSINESS_EMAIL;
							$region  = $this->get_city_by_id($row->BUSINESS_MAP_CITY_ID);
							$latlong  = $this->get_lat_long($id);
							$street  = $row->BUSINESS_PHYSICAL_ADDRESS;
							$post  = $row->BUSINESS_POSTAL_BOX;
							$link = site_url('/') . 'b/' .$id.'/'. $this->clean_url_str($title).'/';
							
												
								//Build image string
								$format = substr($img_file,(strlen($img_file) - 4),4);
								$str = substr($img_file,0,(strlen($img_file) - 4));
								
								if($img_file != ''){
									
									if(strpos($img_file,'.') == 0){
			
										$format = '.jpg';
										$img_str = S3_URL.'assets/business/photos/'.$img_file . $format;
										
									}else{
										
										$img_str =  S3_URL.'assets/business/photos/'.$img_file;
										
									}
									
								}else{
									
									$img_str = base_url('/').'img/bus_blank.jpg';	
									
								}
							
							$description = '<div><img src="' . $img_str . '" alt="'.$title .'" /><a href="' . $link . '"><strong>' . $title . '</strong></a><br />'  . $street . '<br />' .$post . '</div>';
							
							$xml->startBranch('url');
								$xml->addNode('loc', $link);
								
								$xml->startBranch('image:image');
									$xml->addNode('image:loc',$img_str);	
								$xml->endBranch();
							$xml->endBranch();
						}
		
		// Print the XML to screen
		$xml->getXml(true);
}
//+++++++++++++++++++++++++++++++++++
//SITEMAP INDEX FILE
//++++++++++++++++++++++++++++++++++
function main() {
    
	// Load XML writer library
    $this->load->library('MY_Xml_writer');
     $this->load->helper('date');
    // Initiate class
    $xml = new MY_Xml_writer;
    $xml->setRootName("sitemapindex");
    $xml->initiate();
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
	//GET TIME FOR LAST MOD
	$time = date("Y-m-d");
	$time_week = strtotime(date("Y-m-d", strtotime($time)) . " -7 day");
	$time_monthly = strtotime(date("Y-m-d", strtotime($time)) . " -30 day");
	//NORMAL WEBSITE SITEMAP
	$xml->startBranch('sitemap');		
						$xml->addNode('loc',site_url('/') . 'my_sitemap/main_website/');
						$xml->addNode('lastmod', $time);

	$xml->endBranch();				
	
	//BLOG
	$xml->startBranch('sitemap');		
						$xml->addNode('loc','http://blog.my.na/feed/');
						$xml->addNode('lastmod',  date("Y-m-d",$time_week));

	$xml->endBranch();	
	//PARENT INFO
	$xml->startBranch('sitemap');		
						$xml->addNode('loc',site_url('/') . 'my_sitemap/business/');
						$xml->addNode('lastmod',  date("Y-m-d",$time_week));

	$xml->endBranch();	

	//PRODUCTS
	$xml->startBranch('sitemap');		
						$xml->addNode('loc',site_url('/') . 'my_sitemap/products/');
						$xml->addNode('lastmod',  date("Y-m-d",$time_week));

	$xml->endBranch();	


	
    // Print the XML to screen
    $xml->getXml(true);
}

//+++++++++++++++++++++++
//NORMAL SITE
//+++++++++++++++++++++++
function main_website() {
    
	// Load XML writer library
    $this->load->library('MY_Xml_writer');
     $this->load->helper('date');
    // Initiate class
    $xml = new MY_Xml_writer;
    $xml->setRootName("urlset");
    $xml->initiate();
    $xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
	
	$time = date("Y-m-d");
	$time_week = strtotime(date("Y-m-d", strtotime($time)) . " -7 day");
	$time_monthly = strtotime(date("Y-m-d", strtotime($time)) . " -30 day");
	//date('Y-m-d', strtotime("+2 days"));
	//echo mdate($datestring, $time);
	$xml->startBranch('url');		
						$xml->addNode('loc',site_url('/'));
						$xml->addNode('lastmod', $time);
						$xml->addNode('changefreq', 'daily');
						$xml->addNode('priority', '1');
	$xml->endBranch();
					
	$xml->startBranch('url');		
						$xml->addNode('loc',site_url('/') . 'members/register/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();
	
	$xml->startBranch('url');		
						$xml->addNode('loc',site_url('/') . 'deals/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();	

	$xml->startBranch('url');		
						$xml->addNode('loc',site_url('/') . 'trade/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();

	$xml->startBranch('url');		
						$xml->addNode('loc',site_url('/') . 'buy/property/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();
	
	$xml->startBranch('url');		
						$xml->addNode('loc',site_url('/') . 'buy/car-bikes-and-boats/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();
	
	
			
	$xml->startBranch('url');		
						$xml->addNode('loc','https://tourism.my.na/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();
	
	$xml->startBranch('url');		
						$xml->addNode('loc','http://blog.my.na/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();

	$xml->startBranch('url');		
						$xml->addNode('loc','https://events.my.na/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();
	
	$xml->startBranch('url');		
						$xml->addNode('loc','http://events.my.na/');
						$xml->addNode('lastmod', date("Y-m-d",$time_week));
						$xml->addNode('changefreq', 'weekly');
						$xml->addNode('priority', '0.8');
	$xml->endBranch();
    // Print the XML to screen
    $xml->getXml(true);
}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GOOGLE GeoRss FEED for BUSINESS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function products()
	{	
		// Load XML writer library
	
		$this->load->library('MY_Xml_writer');
		 $this->load->helper('date');
		// Initiate class
		$xml = new MY_Xml_writer;
		$xml->setRootName("urlset");
		$xml->initiate();
		$xml->writeAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
		$xml->writeAttribute('xmlns:image', 'http://www.google.com/schemas/sitemap-image/1.1');	
			
			$this->db->where('type !=', 'business');	
			$query = $this->db->get('search_index');
			
			foreach ($query->result() as $row) {
					
									
							$title  = $row->title;
							$id  = $row->search_index_id;
							$img_file  = $row->img_file;
							
							$link = site_url('/') . $row->link;
							
												
								//Build image string
								$format = substr($img_file,(strlen($img_file) - 4),4);
								$str = substr($img_file,0,(strlen($img_file) - 4));
								
								if($img_file != ''){
									
									if(strpos($img_file,'.') == 0){
			
										$format = '.jpg';
										$img_str = base_url('/').'assets/products/photos/'.$img_file . $format;
										
									}else{
										
										$img_str =  base_url('/').'assets/products/photos/'.$img_file;
										
									}
									
								}else{
									
									$img_str = base_url('/').'img/product_blank.jpg';	
									
								}
							
							//$description = '<div><img src="' . $img_str . '" alt="'.$title .'" /><a href="' . $link . '"><strong>' . $title . '</strong></a><br />'  . $street . '<br />' .$post . '</div>';
							
							$xml->startBranch('url');
								$xml->addNode('loc', $link);
								
								$xml->startBranch('image:image');
									$xml->addNode('image:loc',$img_str);	
								$xml->endBranch();
							$xml->endBranch();
						}
		
		// Print the XML to screen
		$xml->getXml(true);
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
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//GET CITY BY ID
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function get_city_by_id($id)
	{
		$this->db->where('ID', $id);
		$query = $this->db->get('a_map_location');
		
		if($query->result()){
			
			$row = $query->row_array();
			return $row['MAP_LOCATION'];
		
		}else{
			
			return 'Namibia';
		}
		
	}
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//GET LAT LONG BY ID
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	
	function get_lat_long($id)
	{
		$this->db->where('BUSINESS_ID', $id);
		$query = $this->db->get('u_business_map');
		
		if($query->result()){
			
			$row = $query->row_array();
			return $row['BUSINESS_MAP_LATITUDE'] . ' , ' . $row['BUSINESS_MAP_LONGITUDE'];
		
		}else{
			
			return '-22.583741 , 17.093782';
		}
		
	}
	
	
	
	

}	
/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */