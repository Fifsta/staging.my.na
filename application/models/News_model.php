<?php

class News_model extends CI_Model
{

    public function __construct()
    {
        //parent::CI_model();

    }
 	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET NMH NEWS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_nmh_news()
    { 

        $this->load->model('image_model'); 

        $this->load->library('thumborp');

        $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
        $width = 360;
        $height = 230;

		$output = file_get_contents(NA_URL.'app/category_content/');
		
		if($output){
			
			$o = '<div class="owl-carousel" style="margin-top:20px">';
						
			foreach(json_decode($output) as $row){	

                $img_str = 'assets/images/' . $row->image;

                $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img_str,$width,$height, $crop = '');


				$o .= '<figure>
                            <div class="product_ribbon_sml"><small style="color:#ff9900">'.$row->publication.' &nbsp;</small>Listed: '.$this->my_model->time_passed(strtotime($row->datetime)).'<span></span></div>
							<a href="" class="shown lazyload">
								<img class="owl-lazy" data-src="'.$img_url.'" src="images/16x9.png" />
							</a>
                            <div>
                                <h2><a href="#">' . ucwords(strtolower($this->my_model->shorten_string($row->title, 6))) . '</a></h2>
                                <div class="details">
                                    <p>'. ucwords(strtolower($this->my_model->shorten_string(strip_tags($row->body), 24))) . '</p>
                                </div>
                            </div>
						</figure>
						';
			}
			$o .= '</div>';
		}
		return $o;
		var_dump(json_decode($output));

	}
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET MYNA DB NEWS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_home_news($offset = 0, $limit = 0, $type, $span = 4)
    {


        if ($offset != 0) {
            $offset = ($offset * 3);
        }
        $limit = $limit - 1;
        switch ($type) {
            case "new_era":
                $xml = ("https://www.newera.com.na/feed/");
                $has_img = 'Y';
                //$channel = ''
                break;

            default:
                $xml = 'http://www.namibian.com.na/rssfeed.php';
                $xml = site_url('/').'my_na/get_local_links/?url='.$xml;
                $has_img = 'N';
        }

        $xml2 = $this->cacheObject($xml, $type . '_rss.xml', 3600);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml2);

        //get elements from "<channel>"
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);


        if ($channel->getElementsByTagName('title')->item(0) !== null) {

            $channel_title = $channel->getElementsByTagName('title')
                ->item(0)->childNodes->item(0)->nodeValue;
        } else {

            $channel_link = '';
        }
        $channel_desc = $channel->getElementsByTagName('description')
            ->item(0)->childNodes->item(0)->nodeValue;

        //get and output "<item>" elements
        $rss = $xmlDoc->getElementsByTagName('item');

        if ($xmlDoc->getElementsByTagName('item')->length >= ($offset + $limit)) {
            echo '
				
				<div class="row-fluid">
					  
				';
            $x2 = 0;

            for ($i = $offset; $i <= ($offset + $limit); $i++) {

                if ($x2 > $offset + $limit) break;

                if ($rss->item($i)->getElementsByTagName('enclosure')->item(0) !== null) {

                    $title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
                    $link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                    $body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);

                    if ($has_img == 'Y') {

                        if ($rss->item($i)->getElementsByTagName('enclosure')->item(0) !== null) {
                            $img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
                            $img = '<div style="min-height:180px"><img class="lazy" src="' . base_url('/') . 'img/deal_place_load.gif" alt="' . strip_tags($title) . '" data-original="' . base_url('/') . 'img/external/timbthumb.php?src=' . trim($img_link) . '&w=360&h=230" /></div>';

                        } else {

                            $img = '';
                        }

                    } else {
                        $img = '';

                    }
                    $pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue);

                    if ($type == 'new_era') {

                        $source = 'New Era';
                    } else {

                        $source = 'Namibian.com.na';//trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);
                    }


                    $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
                    );
                    $tweet_url = $link . $this->clean_url_str($title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($title . ' ' . $body), 0, 100))) . '&via=MyNamibia';
                    if (($x2 % 4 == 0) && ($x2 != 0)) {
                        echo '
                   </div>
                   <div class="row-fluid clearfix">
                           ';
                    }
                    echo ' <div class="span' . $span . ' white_box padding10" >
                                    <div>
                                        ' . $img . '
                                            <p>
                                            <span class="pull-right" style="margin:-55px 5px 0 0">
                                            ' . anchor_popup('https://twitter.com/share?url=' . $tweet_url, ' ', $tweet) . '
                                            </span>
                                            <h4 class="upper na_script">' . $title . '</h4>

                                            <div class="clearfix" style="height:5px;"></div>
                                            <div style="font-size:13px;margin-bottom:10px;">' . $this->shorten_string(strip_tags($body), 40) . '</div>
                                            <div><span style="font-size:11px;"><a href="' . $link . '" target="_blank" rel="nofollow" class="mute">
                                                 ' . $source . '</a></span>
                                                <span style="font-size:10px;font-style:italic;float:right">' . date('l jS \of F', strtotime($pubDate)) . '</span></div>
                                            </p>
                                    </div>
                              </div>
                              ';

                    $x2++;
                } else {

                    $limit++;

                }//has image
            }
            $type_str = "'" . $type . "'";
            echo '
			</div>
			
			<script data-cfasync="false" type="text/javascript">
				
				$("img.lazy").lazyload({
						 effect : "fadeIn"
					});
			</script>		
			';
            $load_img = "<img src='" . base_url('/') . "img/load.gif' />";


        } else {


        }


    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET ENTERTAINMENT FEEDS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_entertainment($offset, $limit, $type)
    {

        if ($offset > 2) {
            $offset = ($offset * 4) + 4;
        } elseif ($offset == 2) {
            $offset = ($offset * 4);
        } elseif ($offset != 0) {
            $offset = ($offset * 4);
        }
        $limit = $limit - 1;

        //ONLY 20 items
        if ($offset == 16) {

            $limit = 3;
        }

        $xml = ("http://www.entertainmentwise.com/rss/news.rss");
        $has_img = 'Y';

        $xml2 = $this->cacheObject($xml, 'entertainment_' . $type . '_rss.xml', 3600);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml2);

        //get elements from "<channel>"
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $channel_title = $channel->getElementsByTagName('title')
            ->item(0)->childNodes->item(0)->nodeValue;
        //$channel_link = $channel->getElementsByTagName('link')
        // ->item(0)->childNodes->item(0)->nodeValue;
        $channel_desc = $channel->getElementsByTagName('description')
            ->item(0)->childNodes->item(0)->nodeValue;

        //get and output "<item>" elements
        $rss = $xmlDoc->getElementsByTagName('item');

        if ($xmlDoc->getElementsByTagName('item')->length >= ($offset + $limit)) {
            echo '
				
				<div class="row-fluid">
					  
				';
            $x2 = 0;

            for ($i = $offset; $i <= ($offset + $limit); $i++) {

                if ($i > $offset + $limit) break;

                $title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
                $link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                $body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);

                if ($has_img == 'Y') {

                    $img_link = trim($rss->item($i)->getElementsByTagName('content')->item(0)->getAttribute('src'));
                    $img = '<div style="min-height:180px"><img class="lazy" src="' . base_url('/') . 'img/deal_place_load.gif" alt="' . strip_tags($title) . '" data-original="' . base_url('/') . 'img/external/timbthumb.php?src=' . trim($img_link) . '&w=360&h=230" /></div>';
                } else {
                    $img = '';

                }
                $pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue);
                $source = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);


                $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
                );
                $tweet_url = $link . $this->clean_url_str($title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($title . ' ' . $body), 0, 100))) . '&via=MyNamibia';
                if (($x2 % 4 == 0) && ($x2 != 0)) {
                    echo '
					   </div>
					   <div class="row-fluid clearfix">
					   ';
                }
                echo ' <div class="span3 white_box padding10" >
								<div>
									' . $img . '
										<p>
										<span class="pull-right" style="margin-top:10px">
										' . anchor_popup('https://twitter.com/share?url=' . $tweet_url, ' ', $tweet) . '
										</span>
										<h4 class="upper na_script">' . $title . '</h4>
										
										<div class="clearfix" style="height:5px;"></div>
										<div style="font-size:13px;margin-bottom:10px;">' . $this->shorten_string(strip_tags($body), 40) . '</div>
										<div><span style="font-size:11px;"><a href="' . $source . '" target="_blank" rel="nofollow" class="mute">
											 ' . $channel_title . '</a></span>
											<span style="font-size:10px;font-style:italic;float:right">' . date('l jS \of F', strtotime($pubDate)) . '</span></div>
										</p>
								</div>			
						  </div>
						  ';

                $x2++;
            }
            $type_str = "'" . $type . "'";
            echo '
			</div>
			<div class="clearfix" style="height:20px;text-align:center">
			  <a onmouseover="load_entertainment(_scroll_news, 8, ' . $type_str . ')" href="javascript:void(0)"><i onClick="load_news(_scroll_news, 3, ' . $type_str . ')" class="icon icon-arrow-down id_arr"></i></a>
			</div>
			<script data-cfasync="false" type="text/javascript">
				
				$("img.lazy").lazyload({
						 effect : "fadeIn"
					});
			</script>		
			';
            $load_img = "<img src='" . base_url('/') . "img/load.gif' />";
            if ($offset == 0) {
                echo
                    '<script data-cfasync="false" type="text/javascript">
					   
						_scroll_news = 2;

								$(window)
								  .off("scroll", ScrollHandlerN)
								  .on("scroll", ScrollHandlerN);
								function ScrollHandlerN(e) {
										//throttle event:
										clearTimeout(_throttleTimer);
										_throttleTimer = setTimeout(function () {
									
											//do work
											if ($(window).scrollTop() + $(window).height() > getDocHeight() - 600) {
												load_entertainment(_scroll_news, 8, "' . $type . '");
												
											}
									
										}, _throttleDelay);
									}
									
							  function getDocHeight() {
								  var D = document;
								  return Math.max(
									  Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
									  Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
									  Math.max(D.body.clientHeight, D.documentElement.clientHeight)
								  );
							  }
									
					</script>';
            }

        } else {


            echo '<div class="alert"><h3 class="na_script">Come back in 30 minutes</h3>
					      Please come back in about 30 minutes time for a fresh update on whats happening</div>';

        }


    }

    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET SKY SPORTS NEWS FEEDS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_sky_sports_news($offset, $limit, $type)
    {

        if ($offset != 0) {
            $offset = ($offset * 4);
        }
        $limit = $limit - 1;
        switch ($type) {
            case "formula1":
                $xml = ("http://www.skysports.com/rss/0,20514,12433,00.xml");
                $has_img = 'Y';
                break;
            case "rugby":
                $xml = ("http://www.skysports.com/rss/0,20514,12321,00.xml");
                $has_img = 'Y';
                break;
            case "super_rugby":
                $xml = ("http://www.skysports.com/rss/0,20514,12334,00.xml");
                $has_img = 'Y';
                break;

            case "premier_league":
                $xml = ("http://www.skysports.com/rss/0,20514,11661,00.xml");
                $has_img = 'Y';
                break;
            default:
                $xml = ("http://rss.wn.com/English/top-stories");
                $has_img = 'Y';
        }

        $xml2 = $this->cacheObject($xml, 'sky_sports_' . $type . '_rss.xml', 3600);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml2);

        //get elements from "<channel>"
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $channel_title = $channel->getElementsByTagName('title')
            ->item(0)->childNodes->item(0)->nodeValue;
        $channel_link = $channel->getElementsByTagName('link')
            ->item(0)->childNodes->item(0)->nodeValue;
        $channel_desc = $channel->getElementsByTagName('description')
            ->item(0)->childNodes->item(0)->nodeValue;

        //get and output "<item>" elements
        $rss = $xmlDoc->getElementsByTagName('item');

        if ($xmlDoc->getElementsByTagName('item')->length >= ($offset + 3)) {
            echo '
				
				<div class="row-fluid">
					  
				';
            $x2 = 0;

            for ($i = $offset; $i <= ($offset + $limit); $i++) {

                if ($i > $offset + $limit) break;

                $title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
                $link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                $body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);

                if ($has_img == 'Y') {

                    $img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
                    $img = '<div style="min-height:180px"><img  class="lazy" src="' . base_url('/') . 'img/deal_place_load.gif" alt="' . strip_tags($title) . '" data-original="' . base_url('/') . 'img/external/timbthumb.php?src=' . trim($img_link) . '&w=360&h=230" /></div>';
                } else {
                    $img = '';

                }
                $pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue);
                $source = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);


                $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
                );
                $tweet_url = $link . $this->clean_url_str($title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($title . ' ' . $body), 0, 100))) . '&via=MyNamibia';
                if (($x2 % 4 == 0) && ($x2 != 0)) {
                    echo '
					   </div>
					   <div class="row-fluid clearfix">
					   ';
                }
                echo ' <div class="span3 white_box padding10" >
								<div>
									' . $img . '
										<p>
										<span class="pull-right" style="margin-top:10px">
										' . anchor_popup('https://twitter.com/share?url=' . $tweet_url, ' ', $tweet) . '
										</span>
										<h4 class="upper na_script">' . $title . '</h4>
										
										<div class="clearfix" style="height:5px;"></div>
										<div style="font-size:13px;margin-bottom:10px;">' . $this->shorten_string(strip_tags($body), 40) . '</div>
										<div><span style="font-size:11px;"><a href="' . $source . '" target="_blank" rel="nofollow" class="mute">
											 ' . $channel_title . '</a></span>
											<span style="font-size:10px;font-style:italic;float:right">' . date('l jS \of F', strtotime($pubDate)) . '</span></div>
										</p>
								</div>			
						  </div>
						  ';

                $x2++;
            }
            $type_str = "'" . $type . "'";
            echo '
			</div>
			<div class="clearfix" style="height:20px;text-align:center">
			  <a onmouseover="load_sky_news(_scroll_news, 3, ' . $type_str . ')" href="javascript:void(0)"><i onClick="load_news(_scroll_news, 3, ' . $type_str . ')" class="icon icon-arrow-down id_arr"></i></a>
			</div>
			<script data-cfasync="false" type="text/javascript">
				
				$("img.lazy").lazyload({
						 effect : "fadeIn"
					});
			</script>		
			';
            $load_img = "<img src='" . base_url('/') . "img/load.gif' />";
            if ($offset == 0) {
                echo
                    '<script data-cfasync="false" type="text/javascript">
					   
						_scroll_news = 2;

								$(window)
								  .off("scroll", ScrollHandlerN)
								  .on("scroll", ScrollHandlerN);
								function ScrollHandlerN(e) {
										//throttle event:
										clearTimeout(_throttleTimer);
										_throttleTimer = setTimeout(function () {
									
											//do work
											if ($(window).scrollTop() + $(window).height() > getDocHeight() - 600) {
												load_sky_news(_scroll_news,4, "' . $type . '");
												
											}
									
										}, _throttleDelay);
									}
									
							  function getDocHeight() {
								  var D = document;
								  return Math.max(
									  Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
									  Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
									  Math.max(D.body.clientHeight, D.documentElement.clientHeight)
								  );
							  }
									
					</script>';
            }

        } else {


        }


    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET NAMIBIAN NEWS FEEDS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_namibian_stories($offset, $limit, $type)
    {

        // enable user error handling
        //libxml_use_internal_errors(true);
        $xml = 'http://www.namibian.com.na/rssfeed.php';
        $xml = site_url('/').'my_na/get_local_links/?url='.$xml;

        $xml2 = $this->cacheObject($xml,'namibian_rss.xml',3600);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml2);

        //get elements from "<channel>"
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $channel_title = $channel->getElementsByTagName('title')
            ->item(0)->childNodes->item(0)->nodeValue;
        $channel_link = $channel->getElementsByTagName('link')
            ->item(0)->childNodes->item(0)->nodeValue;
        $channel_desc = $channel->getElementsByTagName('description')
            ->item(0)->childNodes->item(0)->nodeValue;


        //get and output "<item>" elements
        $rss = $xmlDoc->getElementsByTagName('item');

        if ($xmlDoc->getElementsByTagName('item')->length >= ($offset + 3)) {
            echo '

                <div class="row-fluid">
                    <div class="slideshow cycle-slideshow" 
                                data-cycle-pause-on-hover="true"
                                data-cycle-speed="1000" data-cycle-slides="> div">
                ';
            $x2 = 0;

            for ($i = $offset; $i <= ($offset + $limit); $i++) {

                if ($i > $offset + $limit) break;

                $title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
                $link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                $body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);

                if(!$rss->item($i)->getElementsByTagName('pubDate')){

                    $pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue);

                }else{

                    $pubDate = date('Y-d-m');
                }
                $source = 'Namibian.com.na';//trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);

                $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
                );
                $tweet_url = $link . $this->clean_url_str($title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($title . ' ' . $body), 0, 100))) . '&via=MyNamibia';

                echo ' <div class="span4 padding10 item">

                                        <strong class="upper yellow na_script">' . $this->shorten_string($title, 8) . '</strong>
                                        <p>' . $this->shorten_string(strip_tags($body), 20) . '</p>
                                        <p>
                                            <span style="font-size:10px;font-style:italic;float:right">' . date('l jS \of F', strtotime($pubDate)) . '</span>
                                            &nbsp;
                                           <span style="font-size:10px;font-style:italic;float:right;min-height:30px;"><a href="' . $link . '" target="_blank" rel="nofollow" class="mute">
                                             The ' . $source . ' </a></span>
                                        </p>



                          </div>
                          ';


                $x2++;
            }
            $type_str = "'" . $type . "'";
            echo '</div>
            <!--<a href="http://www.namibian.com.na" target="_blank" rel="nofollow" class="mute pull-right">' . $channel_title . '-->
            </div>';


        } else {


        }


    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET NAMIBIAN NEWS FEEDS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_namibian($offset = 0, $limit = 0, $type, $span = 4)
    {


        if ($offset != 0) {
            $offset = ($offset * 3);
        }
        $limit = $limit - 1;
        switch ($type) {
            case "new_era":
                $xml = ("https://www.newera.com.na/feed/");
                $has_img = 'Y';
                //$channel = ''
                break;

            default:
                $xml = 'http://www.namibian.com.na/rssfeed.php';
                $xml = site_url('/').'my_na/get_local_links/?url='.$xml;
                $has_img = 'N';
        }

        $xml2 = $this->cacheObject($xml, $type . '_rss.xml', 3600);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml2);

        //get elements from "<channel>"
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);


        if ($channel->getElementsByTagName('title')->item(0) !== null) {

            $channel_title = $channel->getElementsByTagName('title')
                ->item(0)->childNodes->item(0)->nodeValue;
        } else {

            $channel_link = '';
        }
        $channel_desc = $channel->getElementsByTagName('description')
            ->item(0)->childNodes->item(0)->nodeValue;

        //get and output "<item>" elements
        $rss = $xmlDoc->getElementsByTagName('item');

        if ($xmlDoc->getElementsByTagName('item')->length >= ($offset + $limit)) {
            echo '

                <div class="row-fluid">

                ';
            $x2 = 0;

            for ($i = $offset; $i <= ($offset + $limit); $i++) {

                if ($i > $offset + $limit) break;

                $title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
                $link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                $body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);

                if ($has_img == 'Y') {

                    if ($rss->item($i)->getElementsByTagName('enclosure')->item(0) !== null) {
                        $img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
                        $img = '<div style="min-height:180px"><img class="lazy" src="' . base_url('/') . 'img/deal_place_load.gif" alt="' . strip_tags($title) . '" data-original="' . base_url('/') . 'img/external/timbthumb.php?src=' . trim($img_link) . '&w=360&h=230" /></div>';

                    } else {

                        $img = '';
                    }

                } else {
                    $img = '';

                }
                $pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue);

                if ($type == 'new_era') {

                    $source = 'New Era';
                } else {

                    $source = 'Namibian.com.na';//trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);
                }


                $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
                );
                $tweet_url = $link . $this->clean_url_str($title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($title . ' ' . $body), 0, 100))) . '&via=MyNamibia';
                if (($x2 % 3 == 0) && ($x2 != 0)) {
                    echo '
               </div>
               <div class="row-fluid clearfix">
                       ';
                }
                echo ' <div class="span' . $span . ' white_box padding10" >
                                <div>
                                    ' . $img . '
                                        <p>
                                        <span class="pull-right" style="margin-top:10px">
                                        ' . anchor_popup('https://twitter.com/share?url=' . $tweet_url, ' ', $tweet) . '
                                        </span>
                                        <h4 class="upper na_script">' . $title . '</h4>

                                        <div class="clearfix" style="height:5px;"></div>
                                        <div style="font-size:13px;margin-bottom:10px;">' . $this->shorten_string(strip_tags($body), 40) . '</div>
                                        <div><span style="font-size:11px;"><a href="' . $link . '" target="_blank" rel="nofollow" class="mute">
                                             ' . $source . '</a></span>
                                            <span style="font-size:10px;font-style:italic;float:right">' . date('l jS \of F', strtotime($pubDate)) . '</span></div>
                                        </p>
                                </div>
                          </div>
                          ';

                $x2++;
            }
            $type_str = "'" . $type . "'";
            echo '
            </div>
            <div class="clearfix" style="height:20px;text-align:center">
              <a onmouseover="load_news(_scroll_news, 3, ' . $type_str . ')" href="javascript:void(0)"><i onClick="load_news(_scroll_news, 3, ' . $type_str . ')" class="icon icon-arrow-down id_arr"></i></a>
            </div>
            <script data-cfasync="false" type="text/javascript">

                $("img.lazy").lazyload({
                         effect : "fadeIn"
                    });
            </script>
            ';
            $load_img = "<img src='" . base_url('/') . "img/load.gif' />";
            if ($offset == 0) {
                echo
                    '<script data-cfasync="false" type="text/javascript">

                        _scroll_news = 2;

                                $(window)
                                  .off("scroll", ScrollHandlerN)
                                  .on("scroll", ScrollHandlerN);
                                function ScrollHandlerN(e) {
                                        //throttle event:
                                        clearTimeout(_throttleTimer);
                                        _throttleTimer = setTimeout(function () {

                                            //do work
                                            if ($(window).scrollTop() + $(window).height() > getDocHeight() - 600) {
                                                load_news(_scroll_news,3, "' . $type . '");

                                            }

                                        }, _throttleDelay);
                                    }

                              function getDocHeight() {
                                  var D = document;
                                  return Math.max(
                                      Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
                                      Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
                                      Math.max(D.body.clientHeight, D.documentElement.clientHeight)
                                  );
                              }

                    </script>';
            }

        } else {


        }


    }
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //+GET WORLD NEWS FEEDS
    //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    public function get_world_news($offset, $limit, $type)
    {

        if ($offset != 0) {
            $offset = ($offset * 3);
        }
        $limit = $limit - 1;
        switch ($type) {
            case "sport":
                $xml = ("http://rss.wn.com/English/keyword/sport");
                $has_img = 'N';
                break;
            case "health":
                $xml = ("http://rss.wn.com/English/keyword/health");
                $has_img = 'N';
                break;
            case "politics":
                $xml = ("http://rss.wn.com/English/keyword/mideast");
                $has_img = 'N';
                break;
            case "business":
                $xml = ("http://rss.wn.com/English/keyword/business");
                $has_img = 'N';
                break;
            case "africa":
                $xml = ("http://rss.wn.com/English/keyword/africa");
                $has_img = 'N';
                break;
            case "afrikaans":
                $xml = ("http://rss.wn.com/Afrikaans/top-stories");
                $has_img = 'Y';
                break;
            case "german":
                $xml = ("http://rss.wn.com/german/top-stories");
                $has_img = 'Y';
                break;
            case "environmental":
                $xml = ("http://rss.wn.com/English/keyword/environment");
                $has_img = 'N';
                break;
            case "premier_league":
                $xml = ("http://www.skysports.com/rss/0,20514,11661,00.xml");
                $has_img = 'Y';
                break;
            default:
                $xml = ("http://rss.wn.com/English/top-stories");
                $has_img = 'Y';
        }


        $xml2 = $this->cacheObject($xml, 'world_news_' . $type . '_rss.xml', 3600);
        $xmlDoc = new DOMDocument();
        $xmlDoc->load($xml2);

        //get elements from "<channel>"
        $channel = $xmlDoc->getElementsByTagName('channel')->item(0);
        $channel_title = $channel->getElementsByTagName('title')
            ->item(0)->childNodes->item(0)->nodeValue;
        $channel_link = $channel->getElementsByTagName('link')
            ->item(0)->childNodes->item(0)->nodeValue;
        $channel_desc = $channel->getElementsByTagName('description')
            ->item(0)->childNodes->item(0)->nodeValue;

        //get and output "<item>" elements
        $rss = $xmlDoc->getElementsByTagName('item');

        if ($xmlDoc->getElementsByTagName('item')->length >= ($offset + 3)) {
            echo '

                <div class="row-fluid">

                ';
            $x2 = 0;

            for ($i = $offset; $i <= ($offset + $limit); $i++) {

                if ($i > $offset + $limit) break;

                $title = trim($rss->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
                $link = trim($rss->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue);
                $body = trim($rss->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue);

                if ($has_img == 'Y') {

                    $img_link = trim($rss->item($i)->getElementsByTagName('enclosure')->item(0)->getAttribute('url'));
                    $img = '<div style="min-height:180px"><img class="lazy" src="' . base_url('/') . 'img/deal_place_load.gif" alt="' . strip_tags($title) . '" data-original="' . base_url('/') . 'img/external/timbthumb.php?src=' . trim($img_link) . '&w=360&h=230" /></div>';
                } else {
                    $img = '';

                }
                $pubDate = trim($rss->item($i)->getElementsByTagName('pubDate')->item(0)->childNodes->item(0)->nodeValue);
                $source = trim($rss->item($i)->getElementsByTagName('source')->item(0)->childNodes->item(0)->nodeValue);


                $tweet = array('scrollbars' => 'yes', 'status' => 'yes', 'resizable' => 'yes', 'screenx' => '20%', 'screeny' => '20%', 'class' => 'twitter'
                );
                $tweet_url = $link . $this->clean_url_str($title) . '&text=' . trim(str_replace("'", " ", substr(strip_tags($title . ' ' . $body), 0, 100))) . '&via=MyNamibia';
                if (($x2 % 3 == 0) && ($x2 != 0)) {
                    echo '
               </div>
               <div class="row-fluid clearfix">
                       ';
                }
                echo ' <div class="span4 white_box padding10" >
                                <div>
                                    ' . $img . '
                                        <p>
                                        <span class="pull-right" style="margin-top:10px">
                                        ' . anchor_popup('https://twitter.com/share?url=' . $tweet_url, ' ', $tweet) . '
                                        </span>
                                        <h4 class="upper na_script">' . $title . '</h4>

                                        <div class="clearfix" style="height:5px;"></div>
                                        <div style="font-size:13px;margin-bottom:10px;">' . $this->shorten_string(strip_tags($body), 40) . '</div>
                                        <div><span style="font-size:11px;"><a href="' . $link . '" target="_blank" rel="nofollow" class="mute">
                                             ' . $source . '</a></span>
                                            <span style="font-size:10px;font-style:italic;float:right">' . date('l jS \of F', strtotime($pubDate)) . '</span></div>
                                        </p>
                                </div>
                          </div>
                          ';

                $x2++;
            }
            $type_str = "'" . $type . "'";
            echo '
            </div>
            <div class="clearfix" style="height:20px;text-align:center">
              <a onmouseover="load_news(_scroll_news, 3, ' . $type_str . ')" href="javascript:void(0)"><i onClick="load_news(_scroll_news, 3, ' . $type_str . ')" class="icon icon-arrow-down id_arr"></i></a>
            </div>
            <script data-cfasync="false" type="text/javascript">

                $("img.lazy").lazyload({
                         effect : "fadeIn"
                    });
            </script>
            ';
            $load_img = "<img src='" . base_url('/') . "img/load.gif' />";
            if ($offset == 0) {
                echo
                    '<script data-cfasync="false" type="text/javascript">

                        _scroll_news = 2;

                                $(window)
                                  .off("scroll", ScrollHandlerN)
                                  .on("scroll", ScrollHandlerN);
                                function ScrollHandlerN(e) {
                                        //throttle event:
                                        clearTimeout(_throttleTimer);
                                        _throttleTimer = setTimeout(function () {

                                            //do work
                                            if ($(window).scrollTop() + $(window).height() > getDocHeight() - 600) {
                                                load_news(_scroll_news,3, "' . $type . '");

                                            }

                                        }, _throttleDelay);
                                    }

                              function getDocHeight() {
                                  var D = document;
                                  return Math.max(
                                      Math.max(D.body.scrollHeight, D.documentElement.scrollHeight),
                                      Math.max(D.body.offsetHeight, D.documentElement.offsetHeight),
                                      Math.max(D.body.clientHeight, D.documentElement.clientHeight)
                                  );
                              }

                    </script>';
            }

        } else {


        }


    }



    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    //CACHE FEED FILE
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    function cacheObject($url, $name, $age = 86400)
    {
        // directory in which to store cached files
        $cacheDir = BASE_URL . "application/cache/feeds/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir . $name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename)) {
            $cache = (filemtime($filename) < (time() - $age));
        }
        // fetch the file if required
        if ($cache) {

            if (copy($url, $filename)) {
                // update timestamp to now
                touch($filename);
            } else {
                echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
            }

        }
        // return the cache filename
        return $filename;
    }

    function connect_intouch_db()
    {

        //connect to main database


        if ($_SERVER["HTTP_HOST"] == 'localhost') {
            $config_db['hostname'] = 'localhost';
            $config_db['username'] = 'root';
            $config_db['password'] = '';
            $config_db['database'] = 'ntouchim_debmarine';

            /*}elseif($_SERVER['SERVER_ADDR'] == '162.243.31.128'){
                $config_db['hostname'] = '162.243.31.128';
                $config_db['username'] = 'ntouchim_admin';
                $config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
                $config_db['database'] = 'ntouchim_debmarine';*/
        } else {
            $config_db['hostname'] = '154.0.162.107';
            $config_db['username'] = 'ntouchim_admin';
            $config_db['password'] = 'cyc9h50v%&*+e`3@nFis';
            $config_db['database'] = 'ntouchim_debmarine';
        }

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
    function shorten_string($phrase, $max_words)
    {

        $phrase_array = explode(' ', $phrase);

        if (count($phrase_array) > $max_words && $max_words > 0) {

            $phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
        }

        return $phrase;

    }

//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
//CLEAN BUSINESS URL SLUG
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

    //setlocale(LC_ALL, 'en_US.UTF8');
    function clean_url_str($str, $replace = array(), $delimiter = '-')
    {
        if (!empty($replace)) {
            $str = str_replace((array)$replace, ' ', $str);
        }

        $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
        $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
        $clean = strtolower(trim($clean, '-'));
        $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

        return $clean;
    }

    /**
     * ++++++++++++++++++++++++++++++++++++++++++++
     * //ENCODING ENCRYPTION
     * //Functions
     * ++++++++++++++++++++++++++++++++++++++++++++ */


    public function decrypt($string)
    {
        $this->load->library('encrypt');
        $data = str_replace('_-_', '/', str_replace('-_-', '+', str_replace('-a-', '=', ($this->encrypt->decode($string)))));
        //$data =  $this->encrypt->decode($string);
        return $data;
    }

    public function encrypt($string)
    {
        $this->load->library('encrypt');

        $data = str_replace('/', '_-_', str_replace('+', '-_-', str_replace('=', '-a-', ($this->encrypt->encode($string)))));
        //$data = $this->encrypt->encode($string);
        return $data;
    }

}

?>