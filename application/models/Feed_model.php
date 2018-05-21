<?php
class Feed_model extends CI_Model{
			
	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	function feed_model(){
  		//parent::CI_model();
		self::__construct();	
 	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET NEWS FEEDS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_world_news($offset, $limit){
		 
		 $limit = 2;
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
		
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($xml);
		
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

		
		if(count($rss) > 0){
			echo '
			<div id="news_msg_"></div>
			<div class="row-fluid">	  
			
			
				 ';
			$x2 = 0;

			for ($i=$offset; $i<=$limit; $i++){
				
				$title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
				$link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
				$body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);
				$img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
				$pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue); 
				$source = trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);   

				$img = '<img class="lazy" src="'.base_url('/').'img/deal_place_load.gif" alt="'.strip_tags($title).'" data-original="'.trim($img_link).'" />';
					

				$tweet = array('scrollbars' => 'yes','status'     => 'yes','resizable'  => 'yes','screenx'    => '20%','screeny'    => '20%','class'      => 'twitter'
				);
				$tweet_url = $link.$this->clean_url_str($title).'&text='.substr(strip_tags($title . ' ' . $body) ,0, 100).'&via=MyNamibia';
				if (($x2 % 3 == 0) && ($x2 != 0)) {
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
									<div><font style="font-size:10px;"><a href=""
										 '.$source.'</font>
										<font style="font-size:10px;font-style:italic;float:right">'. date('l jS \of F',strtotime($pubDate)).'</font></div>
									</p>
							</div>			
					  </div>
					  ';
				
				$x2 ++;
			}
			echo '
			</div>
			
			';
			$load_img = "<img src='". base_url('/'). "img/load.gif' />";
			echo 
			'<script data-cfasync="false" type="text/javascript">
				    $("img.lazy").lazyload({
						 effect : "fadeIn"
					});
					
			</script>';	
			
		 }else{
			
	
			 
		 }
	
		  	  
		
	}
	
	//+++++++++++++++++++++++++++
	//GET FEED
	//++++++++++++++++++++++++++
	public function test( $offset, $limit)
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
		
		$xmlDoc = new DOMDocument();
		$xmlDoc->load($xml);
		
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
		for ($i=$offset; $i<=$limit; $i++)
		  {
				  $item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
				  $item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
				  $item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
				  $item_pic=$x->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url');
				  
		  
		 
		  }
		
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
	
/**
++++++++++++++++++++++++++++++++++++++++++++
//ENCODING ENCRYPTION 
//Functions
++++++++++++++++++++++++++++++++++++++++++++ */	
 

	public  function decrypt($string) {
		$this->load->library('encrypt');
        $data =  str_replace('_-_','/', str_replace('-_-','+', str_replace('-a-','=',($this->encrypt->decode($string)))));
		//$data =  $this->encrypt->decode($string);
        return $data;
    }
	public  function encrypt($string) {
        $this->load->library('encrypt');
		
		$data = str_replace('/','_-_',  str_replace('+','-_-',  str_replace('=','-a-',($this->encrypt->encode($string)))));
		//$data = $this->encrypt->encode($string);
        return $data;
    }

}
?>