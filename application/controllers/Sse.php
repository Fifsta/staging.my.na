<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sse extends CI_Controller {

	/**
	 * CSV CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
 	function __construct() {
        parent::__construct();

    }
 
    function index() {
      
	  	echo 'Going Nowhere Slowly!';
	  
    }
 
 	//+++++++++++++++++++++++++++
	//PRODUCT PAGES
	//++++++++++++++++++++++++++
	public function product($product_id = 0, $current_bid)
	{

        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //GET CURRENT PRODUCT STATUS // Only run if logged in
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        if($id = $this->session->userdata('id')){



            $query = $this->db->query("SELECT products.*, MAX(product_auction_bids.bid_id) as max_bid, MAX(product_auction_bids.amount) as amount,
									(SELECT client_id FROM product_auction_bids WHERE product_id = '".$product_id."' ORDER BY bid_id DESC LIMIT 1) as bidder_id
                                  FROM products
                                  LEFT JOIN product_extras on products.product_id = product_extras.product_id
                                  LEFT JOIN product_auction_bids ON products.product_id = product_auction_bids.product_id AND
                                  (product_auction_bids.type = 'bid' OR product_auction_bids.type = 'auto')
                                  WHERE products.product_id = '".$product_id."'
                                  GROUP BY products.product_id
                                  ORDER BY product_auction_bids.bid_id DESC
                                  ", FALSE);
            ////AND product_auction_bids.bid_id > '".$current_bid."'
            //AND product_auction_bids.client_id != '".$id."'
            $str2 = '';
            if($query->result())
            {
               // echo 'Has row !@';
                foreach ($query->result() as $rowv)
                {
                    $now = date('Y-m-d H:i:s');
                    $end = date('Y-m-d H:i:s', strtotime($rowv->end_date));

                    //CHECK WHAT TYPE BUY NOW or AUCTION
                    if($rowv->listing_type == 'A'){

                        //CHECK IF STILL ACTIVE

                        if($end > $now){
                            //echo ' is still active '.$id .' == '.$rowv->bidder_id;
                            //IF NEWEST BID IS MINE
                            if($id != $rowv->bidder_id){

                                $str2 .="event: new_bid". PHP_EOL;
                                $str2 .= 'data: '.json_encode($rowv) . PHP_EOL . PHP_EOL;

                            }
                            //SHOW TIME LEFT AND NEW BIDS
                            //if($rowv->bid_id > $current_bid){


                            //}

                        }else{

                            $str2 .="event: ending_soon". PHP_EOL;
                            $str2 .= 'data: '.json_encode($rowv) . PHP_EOL . PHP_EOL;

                        }

                    //BUY NOW
                    }else{

                        if($end > $now){



                        }else{

                            $str2 .="event: ending_soon". PHP_EOL;
                            $str2 .= 'data: '.json_encode($rowv) . PHP_EOL . PHP_EOL;

                        }

                    }



                    echo $str2;
                }


            }


        }



	}//END PRODUCT



    //+++++++++++++++++++++++++++
    //PRODUCT PAGES
    //++++++++++++++++++++++++++
    public function signage_stream($product_id = 0, $current_bid = 0)
    {

        $HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];

        if ($HTTP_ORIGIN == "http://intouch.com.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$HTTP_ORIGIN);
        }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
        $this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
        $this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

        $this->output->_display();


        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //GET CURRENT PRODUCT STATUS // Only run if logged in
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



        $query = $this->db->query("SELECT * FROM signage_stream
                              ", FALSE);
        ////AND product_auction_bids.bid_id > '".$current_bid."'
        //AND product_auction_bids.client_id != '".$id."'
        $str2 = '';
        if($query->result())
        {
            // echo 'Has row !@';
            foreach ($query->result() as $rowv)
            {
                $now = date('Y-m-d H:i:s');
                $end = date('Y-m-d H:i:s', strtotime($rowv->created_at));



                $str2 .="event: broadcast". PHP_EOL;
                $str2 .= 'data: '.json_encode($rowv) . PHP_EOL . PHP_EOL;

                echo $str2;
            }


        }





    }//END SIGNAGE

//+++++++++++++++++++++++++++
    //PRODUCT PAGES
    //++++++++++++++++++++++++++
    public function signage_poll($product_id = 0, $current_bid = 0)
    {

        $HTTP_ORIGIN = $_SERVER['HTTP_ORIGIN'];

        if ($HTTP_ORIGIN == "http://intouch.com.na")
        {
            $this->output->set_header("Access-Control-Allow-Origin: ".$HTTP_ORIGIN);
        }



        //$this->output->set_header("Access-Control-Allow-Origin: https://ncci.my.na");
        $this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
        $this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
        $this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );

        $this->output->_display();


        //header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        //GET CURRENT PRODUCT STATUS // Only run if logged in
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++



        $query = $this->db->query("SELECT * FROM signage_stream
                              ", FALSE);
        ////AND product_auction_bids.bid_id > '".$current_bid."'
        //AND product_auction_bids.client_id != '".$id."'
        $str2 = '';
        if($query->result())
        {
            // echo 'Has row !@';
            foreach ($query->result() as $rowv)
            {
                $now = date('Y-m-d H:i:s');
                $end = date('Y-m-d H:i:s', strtotime($rowv->created_at));

                $str2 .= json_encode($rowv) . PHP_EOL . PHP_EOL;

                echo $str2;
            }


        }





    }//END SIGNAGE


}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */