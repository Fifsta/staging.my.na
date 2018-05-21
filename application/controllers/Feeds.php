<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feeds extends CI_Controller {

	/**
	 * Feeds Functionality Controller for My.Na
	 * Roland Ihms
	 * 
	 */
	 
	function feeds()
	{
		parent::__construct();
	}
	
	
	public function index()
	{
		
		echo 'Going Nowhere';
	}


    //+++++++++++++++++++++++++++
    //VIEW EMAIL
    //++++++++++++++++++++++++++
    public function email($id)
    {

        $this->db->where('email_id', $id);
        $q = $this->db->get('emails');

        if($q->result()){

            $row = $q->row();

            $data['body'] = $row->body;
            $data['subject'] = $row->subject;
            //SNIPPEt
            $data['snippet'] = $this->my_na_model->shorten_string(strip_tags($row->body), 18);
            $this->load->view('email/body_news', $data);
            //REPLACE snippet and Link with dynamic content


        }else{


            echo 'Email not found, please check back later';
            //$this->load->view('email/body_news', $data);

        }



    }

    //+++++++++++++++++++++++++++
	//GET FEED
	//++++++++++++++++++++++++++
	public function news_feed()
	{
		
		$this->load->library('rssparser', array($this, 'parseFile'));                         // load library
		$this->rssparser->set_feed_url('http://rss.wn.com/English/top-stories');  // get feed
		$this->rssparser->set_cache_life(30);                       // Set cache life time in minutes
		$rss = $this->rssparser->getFeed(6);                        // Get six items from the feed
		 
		 foreach ($rss as $item)
		{
			echo $item['title'];
			echo $item['description'];
			//echo $item['enclosure'];
			//$this->parseFile($rss, 'enclosure');
		}
		function parseFile($data, $item)
		{
			$data['enclosure'] = (string)$item->enclosure;
			return $data;
		}
		var_dump($rss);
		// Using a callback function to parse addictional XML fields

		//$this->load->library('rssparser', array($this, 'parseFile')); // parseFile method of current class
		
		
	}
	//+++++++++++++++++++++++++++
	//GET FEED
	//++++++++++++++++++++++++++
	public function test()
	{
		$q = 'Google';
		//find out which feed was selected
		if($q=="Google")
		  {
			$xml=("http://rss.wn.com/English/top-stories");  
		  //$xml=("http://news.google.com/news?ned=us&topic=h&output=rss");
		  }
		elseif($q=="MSNBC")
		  {
		  $xml=("http://rss.msnbc.msn.com/id/3032091/device/rss/rss.xml");
		  }

		
		$xml2 = $this->cacheObject($xml,'world_news_rss.xml',3600);
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
		$x=$xmlDoc->getElementsByTagName('item');
		for ($i=0; $i<=2; $i++)
		  {
				  $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				  $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
				  $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
				  $item_pic=$x->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url');
				  
		  
		 
		  }
		
	}


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
          $xml = file_get_contents($url);
		  //file_put_contents('world_news_rss.xml', $xml);
		  copy($url, $filename);
          // update timestamp to now
          touch($filename);
        }
        // return the cache filename
        return $filename;
    }    

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */