<?php
class Sell_model extends CI_Model{

	public function __construct()
    {
        // Constructor's functionality here, if you have any.
    }
	
 	/*function sell_model(){
  		//parent::CI_model();
		self::__construct();	
 	}*/

 	//++++++++++++++++++++++++++++++
    //FIND USER TYPEHEAD
    //++++++++++++++++++++++++++++++
    public function find_users($key)
    {
		if(strlen($key) < 2){
			
			return;
			
		}

        $key = $this->db->escape_like_str(urldecode($key));
		
		$str2 = " (u_client.CLIENT_NAME like '%" . $key . "%' OR u_client.CLIENT_SURNAME like '%" . $key . "%' 
							OR u_client.CLIENT_EMAIL like '%" . $key . "%' OR u_client.CLIENT_CELLPHONE like '%" . $key . "%' ) ";
		//MORE THAN 2 WoRDS
		if (str_word_count($key) > 1)
		{
			$str1 = explode(" ", $key);
			//echo var_dump($str1);
			$str2 = '';	
			
			$c = 0;
			foreach ($str1 as $keys)
			{
				if (count($str1) - 1 == $c)
				{
					$end = '';
				}
				else
				{
					$end = ' AND ';

				}
				$str2 .= " (u_client.CLIENT_NAME like '%" . $keys . "%' OR u_client.CLIENT_SURNAME like '%" . $keys . "%' 
							OR u_client.CLIENT_EMAIL like '%" . $keys . "%' OR u_client.CLIENT_CELLPHONE like '%" . $keys . "%' ) " . $end;
				$c++;
			}
		}

		$test = $this->db->query("SELECT u_client.ID as ID,u_client.IS_ACTIVE,u_client.FB_ID, u_client.CLIENT_NAME as FNAME,u_client.VERIFIED,u_client.CLIENT_SURNAME as SNAME,CLIENT_EMAIL as EMAIL,
								CLIENT_CELLPHONE as CELL, u_client.CLIENT_PROFILE_PICTURE_NAME as IMG
							 FROM u_client
							 WHERE ".$str2." LIMIT 15 ", true);
							 
		$o['success'] = false;
		$o['result'] = array();
		if ($test->result())
		{
			$a = array();
			$this->load->library('encrypt');
			$o['success'] = true;
			foreach($test->result() as $row){
				
				$row->ACC_link = $this->encrypt->encode(json_encode($row));
				array_push($a, $row);
				
			}
			
			$o['result'] = $a;
			

		}


        echo json_encode($o);

        $this->output->set_content_type('application/json');

    }


	//++++++++++++++++++++++++++++++
	//FIND USER TYPEHEAD
	//++++++++++++++++++++++++++++++
	public function find_business($key)
	{
		if(strlen($key) < 2){

			return;
		}
		$key = $this->db->escape_like_str(urldecode($key));

		$str2 = " (u_business.BUSINESS_NAME like '%" . $key . "%' OR u_business.BUSINESS_DESCRIPTION like '%" . $key . "%'
							OR u_business.BUSINESS_EMAIL like '%" . $key . "%' OR u_business.BUSINESS_TELEPHONE like '%" . $key . "%' ) ";
		//MORE THAN 2 WoRDS
		if (str_word_count($key) > 1)
		{
			$str1 = explode(" ", $key);
			//echo var_dump($str1);
			$str2 = '';

			$c = 0;
			foreach ($str1 as $keys)
			{
				if (count($str1) - 1 == $c)
				{
					$end = '';
				}
				else
				{
					$end = ' AND ';

				}
				$str2 .= " (u_business.BUSINESS_NAME like '%" . $keys . "%' OR u_business.BUSINESS_DESCRIPTION like '%" . $keys . "%'
							OR u_business.BUSINESS_EMAIL like '%" . $keys . "%' OR u_business.BUSINESS_TELEPHONE like '%" . $keys . "%' ) " . $end;
				$c++;
			}
		}

		$test = $this->db->query("SELECT u_business.ID as ID,u_business.ISACTIVE,u_business.BUSINESS_NAME as NAME,BUSINESS_EMAIL as EMAIL,
								 u_business.BUSINESS_LOGO_IMAGE_NAME as IMG, u_business.BUSINESS_TELEPHONE as TE
							 FROM u_business
							 WHERE ".$str2." LIMIT 20 ", true);

		$o['success'] = false;
		$o['result'] = array();
		if ($test->result())
		{
			$a = array();
			$this->load->library('encrypt');
			$o['success'] = true;
			foreach($test->result() as $row){

				$row->ACC_link = $this->encrypt->encode(json_encode($row));
				array_push($a, $row);

			}

			$o['result'] = $a;


		}


		return $o;

		//$this->output->set_content_type('application/json');

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_business_deals(){
		
		
		
		
	}



	public function get_client_products($bus_id, $section){

		$id = $this->session->userdata('id');
		$out = '';
		
		if($section == ''){
			$section = 'live';	
		}

		//JOUBERT BALT PRIVATE && JUST PROPERTY
		$strSQL = '';
		if($bus_id == 8848 || $bus_id == 9016){
			
			$strSQL= " AND products.client_id = '".$id."'";
			
		}

        $pSQL = "SELECT products.*,products_buy_now.amount,products_buy_now.buy_now_id, trade_rating.rating, trade_rating.review, trade_rating.created_at,
                                      product_extras.*,product_images.img_file, product_questions.question_id, product_categories.category_name,
                                      group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
                                      group_concat(trade_rating.rating,'-_-',trade_rating.type,'-_-',REPLACE(trade_rating.review, ',', ' '),'-_-',trade_rating.created_at) as rating_a,
                                      MAX(product_auction_bids.amount) as current_bid
                                      FROM products
                                      JOIN product_extras ON products.product_id = product_extras.product_id
                                      LEFT JOIN products_buy_now ON products.product_id = products_buy_now.product_id
                                      LEFT JOIN product_categories ON product_categories.cat_id = products.sub_sub_cat_id
                                      LEFT JOIN trade_rating ON trade_rating.buy_now_id = products_buy_now.buy_now_id
                                      LEFT JOIN product_images ON products.product_id = product_images.product_id
                                      LEFT JOIN product_questions ON product_questions.product_id = products.product_id
                                      LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                      ";

        if($section == 'bought') {
            $data['col4H'] = '<th style="width:12%">Q</th>';
            $data['bstr'] = '';
            $query = $this->db->query($pSQL."
                                      WHERE products_buy_now.client_id = '".$id."' AND products.bus_id = '0' AND products.status = 'sold'
                                      GROUP BY products.product_id ORDER BY products.product_id DESC" ,FALSE);

        }elseif($bus_id == 0){
			$data['col4H'] = '<th style="width:12%">Q</th>';
			$data['bstr'] = '';$xtraSQL = '';

            if($section == 'live'){
               $xtraSQL = "OR products.status = 'moderate'";
            }

			$query = $this->db->query($pSQL."
                                      WHERE products.client_id = '".$id."' AND products.bus_id = '0' AND (products.status = '".$section."' ".$xtraSQL.")
                                      GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);
		
		}elseif($section == 'live_agent'){
			$data['col4H'] = '<th style="width:12%">Agent</th>';
			$data['bstr'] = 'Agency';
			$query = $this->db->query($pSQL."
                                       WHERE product_extras.property_agent = '".$id."' AND products.bus_id = '".$bus_id."'  AND products.status = 'live'
                                       GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);
		
		}elseif($section == 'sold_agent'){
			$data['col4H'] = '<th style="width:12%">Agent</th>';
			$data['bstr'] = 'Agency';
			$query = $this->db->query($pSQL." WHERE product_extras.property_agent = '".$id."' AND products.bus_id = '".$bus_id."'  AND products.status = 'sold'
                                       GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}else{
			$data['col4H'] = '<th style="width:12%">Agent</th>';
			$data['bstr'] = 'Business';
			$query = $this->db->query($pSQL." WHERE products.bus_id = '".$bus_id."' AND products.status = '".$section."' ".$strSQL."
                                      GROUP BY products.product_id ORDER BY products.product_id DESC" ,FALSE);
		}

		if($query->result()){

			$data['section'] = $section;
			$data['id'] = $id;
			$data['bus_id'] = $bus_id;	

			$this->load->model('image_model'); 
			$this->load->library('thumborp');		

			$data['products'] = $query;
			$out = $this->load->view('members/inc/business_products', $data, true);

		} else {

			$out = 'There are no '.$section.' product items';

		}

		echo $out;

	}








	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+GET PRODUCTS FOR EDIT
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	public function get_client_products2($bus_id, $section){
		
		$id = $this->session->userdata('id');
		
		if($section == ''){
			$section = 'live';	
		}
		
		//JOUBERT BALT PRIVATE && JUST PROPERTY
		$strSQL = '';
		if($bus_id == 8848 || $bus_id == 9016){
			
			$strSQL= " AND products.client_id = '".$id."'";
			
		}
		
		$legend = '<div class="well well-mini">
					<small class="muted"><strong>What do the buttons do?</strong> Move the mouse over each button for descriptions <i class="icon-question-sign icon-white"></i></small>
					<div class="pull-right">
						<a class="btn btn-mini btn-success" title="The item is live and not expired" rel="tooltip" href="javascript:void(0)"><i class="icon-ok icon-white"></i></a>
						<a href="javascript:void(0)" class="btn btn-mini btn-warning" title="Listing date. Is product expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>
						<a class="btn btn-mini btn-success" href="javascript:void(0)" title="Mark item as sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>
						<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the print options" rel="tooltip" data-toggle="dropdown">Export <span class="caret"></span></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a ><i class="icon-print"></i> Print Option 1</a></li>
				                  <li><a ><i class="icon-print"></i> Print Option 2</a></li>
				                  <li class="divider"></li>
				                  <li><a ><i class="icon-share"></i> Export PDF 1</a></li>
				                  <li><a ><i class="icon-share"></i> Export PDF 2</a></li>
				                </ul>
				            </div>
							<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the product menu" rel="tooltip" data-toggle="dropdown"><i class="icon-cog"></i></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a><i class="icon-pencil"></i> Update Item</a></li>
				                  <li><a><i class="icon-trash"></i> Remove Item</a></li>
								  <li><a><i class="icon-search"></i> View Item</a></li>
				                </ul>
				            </div>
						<a href="javascript:void(0)" class="btn btn-mini btn-inverse" title="Preview the current item" rel="tooltip"> View</a>
					</div>	
				 </div>';

        $pSQL = "SELECT products.*,products_buy_now.amount,products_buy_now.buy_now_id, trade_rating.rating, trade_rating.review, trade_rating.created_at,
                                      product_extras.*,product_images.img_file, product_questions.question_id, product_categories.category_name,
                                      group_concat(product_images.img_file ORDER BY product_images.sequence ASC) as images,
                                      group_concat(trade_rating.rating,'-_-',trade_rating.type,'-_-',REPLACE(trade_rating.review, ',', ' '),'-_-',trade_rating.created_at) as rating_a,
                                      MAX(product_auction_bids.amount) as current_bid
                                      FROM products
                                      JOIN product_extras ON products.product_id = product_extras.product_id
                                      LEFT JOIN products_buy_now ON products.product_id = products_buy_now.product_id
                                      LEFT JOIN product_categories ON product_categories.cat_id = products.sub_sub_cat_id
                                      LEFT JOIN trade_rating ON trade_rating.buy_now_id = products_buy_now.buy_now_id
                                      LEFT JOIN product_images ON products.product_id = product_images.product_id
                                      LEFT JOIN product_questions ON product_questions.product_id = products.product_id
                                      LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
                                      ";

        if($section == 'bought') {
            $col4H = '<th style="width:12%">Q</th>';
            $bstr = '';
            $query = $this->db->query($pSQL."
                                      WHERE products_buy_now.client_id = '".$id."' AND products.bus_id = '0' AND products.status = 'sold'
                                      GROUP BY products.product_id ORDER BY products.product_id DESC" ,FALSE);

        }elseif($bus_id == 0){
			$col4H = '<th style="width:12%">Q</th>';
			$bstr = '';$xtraSQL = '';
            if($section == 'live'){
               $xtraSQL = "OR products.status = 'moderate'";

            }
			$query = $this->db->query($pSQL."
                                        WHERE products.client_id = '".$id."' AND products.bus_id = '0' AND (products.status = '".$section."' ".$xtraSQL.")
                                      GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);
		
		}elseif($section == 'live_agent'){
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query($pSQL."
                                        WHERE product_extras.property_agent = '".$id."' AND products.bus_id = '".$bus_id."'  AND products.status = 'live'
                                       GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);
		
		}elseif($section == 'sold_agent'){
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Agency';
			$query = $this->db->query($pSQL." WHERE product_extras.property_agent = '".$id."' AND products.bus_id = '".$bus_id."'  AND products.status = 'sold'
                                       GROUP BY products.product_id ORDER BY products.product_id DESC " ,FALSE);

		}else{
			$col4H = '<th style="width:12%">Agent</th>';
			$bstr = 'Business';
			$query = $this->db->query($pSQL." WHERE products.bus_id = '".$bus_id."' AND products.status = '".$section."' ".$strSQL."
                                         GROUP BY products.product_id ORDER BY products.product_id DESC" ,FALSE);
		}
		if($query->result()){
			
			echo $legend.'
			<div class="row-fluid">
				<div class="span8">
					<h4>Listings<small> Your current '.$bstr.' items</small></h4>
				</div>
				<div class="span4 text-right">

					<div class="btn-group text-left">
						<button class="btn">Export</button>
		                <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
		                <ul class="dropdown-menu pull-right">
		                  <li><a href="javascript:void(0);" class="btnPrint" data-section="'.$section.'"><i class="icon-print"></i> Print</a></li>
		                  <li><a href="javascript:void(0);" class="btnExport" data-section="'.$section.'"><i class="icon-share"></i> Export PDF</a></li>
		                  <li><a href="javascript:void(0);" class="btnCsv" data-section="'.$section.'"><i class="icon-share"></i> Export CSV</a></li>

		                </ul>
		            </div>

				</div>
			</div>
			
			<div class="clearfix" style="height:20px"></div>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" id="product_table" class="table table-striped datatable" id="" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:8%;min-width:40px"></th>
           				<th style="width:15%">Title</th>
						<th style="width:10%">Type</th>
						<th style="width:15%">Price</th>
						<th style="width:10%">End</th>
						'.$col4H .'
						<th style="width:30%;min-width:140px"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				//AGENCY COLUMN
                $agent_ref = '';
                $col4 = '<td style="width:5%">'.$row->quantity.'</td>';
				if($section == 'live_agent' || $section == 'sold_agent' || $bus_id != 0){
					$col4 = '<td style="width:12%">None</td>';

					//PROPERTY REFERENCE
					if(count(json_decode($row->extras)) > 0){

						foreach(json_decode($row->extras) as $exr => $exv){

							if($exr == 'agency' && $exv != ''){

								$agent_ref = '<span  class="label" rel="tooltip"  title="Product Reference">Ref: <strong itemprop="sku">'.$exv.'</strong></span>';
								//$col4 = $agent_ref;
							}

						}

					}

					//GET AGENT DETAILS
					if($row->property_agent != 0){
						$this->db->where('ID', $row->property_agent);
						$agent = $this->db->get('u_client');
						if($agent->result()){
							
							$agentR = $agent->row();	
							$col4 = '<td style="width:12%">'.$agent_ref.' '.$agentR->CLIENT_NAME. ' ' .$agentR->CLIENT_SURNAME.'</td>';
						}
					}else{

						$col4 = '<td style="width:12%">'.$agent_ref.'</td>';

					}
					
					
				}
				
				//get images

				$t = explode(',', $row->images);
				$image_path = reset($t);

				if($image_path != ''){
					

					$img = S3_URL.'assets/products/images/'.$image_path;
					$imgS3 = S3_URL.'assets/products/images/'.$image_path;

				}else{
					
					$img = base_url('/').'img/product_blank.jpg';
					$imgS3 = $img;
				}
				

				
				//Check Price
				//Fixed price
				if($row->listing_type == 'S'){
					
					$type = '<span class="label">Buy Now</span>';
					$price = 'N$ '. $row->sale_price;
					
					$bids = '';
				//Auction	
				}else{
					
					//GET CURRENT BID
					$bids = $this->trade_model->get_current_bid($row->current_bid);
					$type = '<span class="label">Auction</span>';
					$price = 'Current Bid: N$ '.$bids['current'].' Res: ' .$row->reserve;
					
				}
				
				if($row->is_active == 'Y'){
					if($bus_id != 0){
						$active = '<a onclick="activate_product('.$row->product_id.', '. "'N'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-success" title="Product is live - click to deactivate" rel="tooltip"><i class="icon-play icon-white"></i></a>';
					}else{
						
						$active = '<a class="btn btn-mini btn-success" title="Product is live" id="act_'.$row->product_id.'" rel="tooltip"><i class="icon-play icon-white"></i></a>';
					}
				}else{
					if($bus_id != 0){
						$active = '<a onclick="activate_product('.$row->product_id.', '. "'Y'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Not approved - Click to make it live" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					}else{
						
						$active = '<a class="btn btn-mini btn-warning" id="act_'.$row->product_id.'" title="Not approved" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
					}
				}
                $extend = '';
				//SEE IF EXPIRED
				if(date('Y-m-d',strtotime($row->end_date)) < date('Y-m-d')){
					
					if($bus_id != 0){
						//$active = '<a onclick="activate_product('.$row->product_id.', '. "'Y'".');" id="act_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Item is expired - Click to activate" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
                        $extend = '<a onclick="extend_product('.$row->product_id.','."'".$row->listing_type."'".');" id="ext_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Item is expired - Click to extend by another 30 days" rel="tooltip"><i class="icon-time icon-white"></i></a>';
                    }else{
						
						//$active = '<a class="btn btn-mini btn-warning" id="act_'.$row->product_id.'" title="Item is Expired" rel="tooltip"><i class="icon-pause icon-white"></i></a>';
                        $extend = '<a onclick="extend_product('.$row->product_id.','."'".$row->listing_type."'".');" id="ext_'.$row->product_id.'" class="btn btn-mini btn-warning" title="Item is expired - Click to extend by another 30 days" rel="tooltip"><i class="icon-time icon-white"></i></a>';
					}
				}

                $questions = '';
				if($row->client_id == $id){

                    if($row->question_id != null){

                            $questions = ' <a onclick="get_questions('.$row->product_id.');" class="btn btn-mini btn-danger" rel="tooltip" title="Click to view questions"><i class="icon-question-sign icon-white"></i></a> ';


                    }

                }

                //COLORS
                $row_C = '';$moderate = '';
                if($row->status == 'moderate'){

                    $row_C = ' error';
                    $moderate = '<span class="label label-important" title="Item is currently being Moderated" rel="tooltip">Under Moderation</span> ';

                }

                //CHECK SOLD BUTTON
                $soldBTN = '';
                if($bus_id != 0){
                    $soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status('.$row->product_id.', '. "'live'".');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star icon-white"></i></a>';
                    if($row->status == 'live'){
                        $soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status('.$row->product_id.', '. "'sold'".');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>';
                    }else{
                        $soldBTN = '<a class="btn btn-mini btn-warning" onclick="update_product_status('.$row->product_id.', '. "'live'".');" title="Mark Item as Live" rel="tooltip"><i class="icon-star icon-white"></i></a>';

                    }
                }
                //CHECK SOLD BUTTON
                //$soldBTN = '';
                if($bus_id != 0 || $row->status != 'moderate'){
                    $soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status('.$row->product_id.', '. "'live'".');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star icon-white"></i></a>';
                    if($row->status == 'live'){
                        $soldBTN = '<a class="btn btn-mini btn-success" onclick="update_product_status('.$row->product_id.', '. "'sold'".');" title="Mark Item as Sold" rel="tooltip"><i class="icon-star-empty icon-white"></i></a>';
                    }else{
                        $soldBTN = '<a class="btn btn-mini btn-warning" onclick="update_product_status('.$row->product_id.', '. "'live'".');" title="Mark Item as Live" rel="tooltip"><i class="icon-star icon-white"></i></a>';

                    }
                }
				echo '<tr id="row_'.$row->product_id.'" class="'.$row_C.'" data-image="'.base_url('/').'img/timbthumb.php?src='.$imgS3.'&w=300&h=200" data-content="'.htmlentities($this->my_na_model->shorten_string(strip_tags($row->description), 20)) .'" data-title="'.htmlentities($row->title) .'">

						<td style="width:8%;min-width:40px"><img src="'.base_url('/').'img/timbthumb.php?src='.$img.'&w=190&h=130"
							alt="" style="width:80%;height:auto" class="img-polaroid"/> </td>
						<td style="width:15%">'.$row->category_name.' > '.$row->title .'</td>
						<td style="width:10%">'.$type.'</td>
						<td style="width:15%">'.$price .'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->end_date)).'</td>
						'.$col4.'
					  	<td style="width:30%;min-width:140px;text-align:right;">
							'.$moderate.$questions. $soldBTN. ' ';

                //IF SOLD
                if($section == 'bought') {

                    if($row->rating_a != null){

                        //echo $row->rating_a;
                        //GET ARRAY
                        $Array = explode(',',$row->rating_a);
                        $Array1 = explode('-_-', $Array[0]);

                        $t_true = false;$b_true = true;
                        //echo $row->rating;
                        //2 reviews seller and buyer
                        if(count($Array) > 1){
                            $Array2 = explode('-_-', $Array[1]);
                            //var_dump($Array2);

                            if($Array2[1] == 'Buyer'){

                                $Seller = $Array2;
                                $Buyer = $Array1;
                                $t_true = true;
                                $b_true = false;
                            }elseif($Array1[1] == 'Buyer'){

                                $Seller = $Array1;
                                $Buyer = $Array2;
                                $t_true = true;
                                $b_true = false;
                            }
                        //only 1 review
                        }else{

                            if($Array1[1] == 'Buyer'){

                                $Seller = $Array1;
                                $t_true = true;
                            }else{
                                $b_true = true;

                            }
                            //var_dump($Array1);
                        }


                        if($t_true){

                            $t_t = 'Feedback Left: ' .$this->time_ago(strtotime($Seller[3]));
                            echo '<a class="btn review_p_btn" data-toggle="popover" data-placement="top" data-content="'.ucwords($this->clean_url_str($Seller[2],'',' ')).'" title="" data-original-title="'.$t_t.'" data-trigger="hover">'
                                .implode($this->get_review_stars(round($Seller[0]),$row->buy_now_id)).'</a> <span class="btn btn-mini btn-success" title="Seller has reviewed You" rel="tooltip"><i class="icon-thumbs-up icon-white"></i></span>';

                        }else{

                            echo '<a class="btn btn-mini btn-danger" title="No feedback has been left from the selling party" rel="tooltip"><i class="icon-star icon-white"></i> No feedback</a>';
                        }
                        if($b_true) {

                            echo ' <a onclick="review_participant(' . $row->buy_now_id . ');" class="btn btn-mini btn-danger" rel="tooltip" title="Please Review the Seller"><i class="icon-thumbs-down icon-white"></i> Review Me</a>
                                    ';

                        }else{
                            echo ' <a onclick="review_participant(' . $row->buy_now_id . ');" class="btn btn-mini btn-danger" rel="tooltip" title="Please Review the Buyer"><i class="icon-thumbs-down icon-white"></i> Review Me</a>
                                    ';

                        }
                    }else{
                        echo '<a class="btn btn-mini btn-danger" title="No feedback has been left from the selling party" rel="tooltip"><i class="icon-star icon-white"></i> No feedback</a>
                            <a onclick="review_participant(' . $row->buy_now_id . ');" class="btn btn-mini btn-danger" rel="tooltip" title="Please Review the Seller"><i class="icon-thumbs-down icon-white"></i> Review Me</a>
                          <span class="btn btn-mini btn-success">Yours!</span>';

                    }

                }elseif($section == 'sold'){

                    if($row->rating_a != null){

                        //GET ARRAY
                        $Array = explode(',',$row->rating_a);
                        $Array1 = explode('-_-', $Array[0]);

                        $t_true = false;$b_true = true;
                        //echo $row->rating;
                        //2 reviews seller and buyer
                        if(count($Array) > 1){
                            $Array2 = explode('-_-', $Array[1]);
                            //var_dump($Array2);

                            if($Array2[1] == 'Seller'){

                                $Seller = $Array2;
                                $Buyer = $Array1;
                                $t_true = true;
                                $b_true = true;
                            }elseif($Array1[1] == 'Seller'){

                                $Seller = $Array1;
                                $Buyer = $Array2;
                                $t_true = true;
                                $b_true = true;
                            }
                            //only 1 review
                        }else{

                            if($Array1[1] == 'Seller'){

                                $Seller = $Array1;
                                $t_true = true;
                                $b_true = false;
                            }else{
                                $b_true = true;

                            }
                            //var_dump($Array1);
                        }
                        if($t_true){

                            $t_t = 'Feedback Left: ' .$this->time_ago(strtotime($Seller[3]));
                            echo '<div  class="btn white review_p_btn" data-toggle="popover" data-placement="top" data-content="'.ucwords($this->clean_url_str($Seller[2],'',' ')).'" title="" data-original-title="'.$t_t.'" data-trigger="hover">'
                                .implode($this->get_review_stars(round($Seller[0]),$row->buy_now_id)).'</div> <span class="btn btn-mini btn-success" title="Buyer has reviewed You" rel="tooltip"><i class="icon-thumbs-up icon-white"></i></span>';

                        }else{

                            echo '<a class="btn btn-mini btn-danger" title="No feedback has been left from the buying party" rel="tooltip"><i class="icon-star icon-white"></i> No feedback</a>';
                        }
                        if($b_true) {

                            echo ' <a class="btn btn-mini btn-success" rel="tooltip" title="You have Reviewed the Buyer"><i class="icon-thumbs-up icon-white"></i></a>
                                    ';

                        }else{
                            echo ' <a onclick="review_participant(' . $row->buy_now_id . ');" class="btn btn-mini btn-danger" rel="tooltip" title="Please Review the Buyer"><i class="icon-thumbs-down icon-white"></i> Review Me</a>
                                    ';

                        }

                    }else{
                        echo '<a class="btn btn-mini btn-danger" title="No feedback has been left from the buying party" rel="tooltip"><i class="icon-star icon-white"></i> No feedback</a>
                                <a onclick="review_participant(' . $row->buy_now_id . ');" class="btn btn-mini btn-danger" rel="tooltip" title="Please Review the Buyer"><i class="icon-thumbs-down icon-white"></i> Review Me</a>';

                    }


                }else{


                    echo    $active. ' '. $extend.' '

                            .'<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the print options" rel="tooltip" data-toggle="dropdown">Export <span class="caret"></span></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a href="'.site_url('/').'trade/print_product/'.$row->product_id.'/" data-id="'.$row->product_id.'" class="btnPrint_single"><i class="icon-print"></i> Print Option 1</a></li>
				                  <li><a href="'.site_url('/').'trade/print_product2/'.$row->product_id.'/" data-id2="'.$row->product_id.'" class="btnPrint_single"><i class="icon-print"></i> Print Option 2</a></li>
				                  <li class="divider"></li>
				                  <li><a href="'.site_url('/').'trade/print_pdf/'.$row->product_id.'/" target="_blank"><i class="icon-share"></i> Export PDF 1</a></li>
				                  <li><a href="'.site_url('/').'trade/print_pdf/'.$row->product_id.'/2" target="_blank"><i class="icon-share"></i> Export PDF 2</a></li>
				                </ul>
				            </div>
							<div class="btn-group text-left">
				                <button class="btn btn-mini dropdown-toggle" title="Open the product menu" rel="tooltip" data-toggle="dropdown"><i class="icon-cog"></i></button>
				                <ul class="dropdown-menu pull-right">
				                  <li><a href="'.site_url('/').'sell/update_product/'.$row->product_id.'/" id="upd_'.$row->product_id.'" onclick="update_product('.$row->product_id.');" ><i class="icon-pencil"></i> Update Item</a></li>
				                  <li><a onclick="delete_product('.$row->product_id.');" id="del_'.$row->product_id.'" class=""><i class="icon-trash"></i> Remove Item</a></li>
								  <li><a href="'.site_url('/').'product/'.$row->product_id.'/" target="_blank" class=""><i class="icon-search"></i> View Item</a></li>
				                </ul>
				            </div>';

                }
				echo '
						</td>
					  </tr>';
			}



			$exit_str = "javascript:$('#modal-product-delete').modal('hide')"; 
			$table_str = "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>";

			echo '</tbody>
				</table>
				<hr />
				<div id="modal-review-participant" class="modal hide fade">
					<div class="modal-header">
					  <a data-dismiss="modal" aria-hidden="true" class="close">&times;</a>
					  <h3>Review the Buyer/Seller</h3>
					</div>
					 <div class="modal-body">
					</div>
				</div>
				<div id="modal-product-delete" class="modal hide fade">

					<div class="modal-header">
					  <a data-dismiss="modal" aria-hidden="true" class="close">&times;</a>
					  <h3>Delete the Product</h3>
					</div>
					 <div class="modal-body">
					   <p>Are you sure you want to completely remove the current product and all of its resources?</p>
						
					</div>
				
					<div class="modal-footer">
					  <a href="#" class="btn btn-primary">Delete</a> 
					  <a data-dismiss="modal" aria-hidden="true" class="btn btn-secondary">No</a>
					</div>
				 
				</div>
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					$("[rel=tooltip]").tooltip();		
					$(".datatable").dataTable( {
					  "sDom": "'.$table_str.'",
					  "sPaginationType": "bootstrap",
					  "oLanguage": {
						  "sLengthMenu": "_MENU_ records per page"
					  },
					  "aaSorting":[],
					  "bSortClasses": false
	
					} );
					function update_product(id){
	
							var cont = $("#admin_content");
							$.get("'.site_url('/'). 'trade/update_product/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);
									  
							});
							
					}
					function get_questions(id){

                            var cont = $("#admin_content");
							$.get("'.site_url('/'). 'trade/product_questions/"+id, function(data) {
									  cont.removeClass("loading_img").html(data);


							});

					}
					function review_participant(id){

                            var cont = $("#modal-review-participant > .modal-body");
							$.get("'.site_url('/'). 'trade/review_participant/"+id, function(data) {


                                    $("#modal-review-participant").appendTo("body").unbind("show").bind("show", function()  {

                                        cont.removeClass("loading_img").html(data);

                                    }).modal({ backdrop: true });

							});

					}
					function update_product_status(id, str){

						var cont = $("#admin_content");
						cont.addClass("loading_img").css("background-color","white");  
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'trade/update_product_status/"+id+"/"+str ,
								success: function (data) {
									cont.removeClass("loading_img"); 
									cont.html(data);	
									 window.setInterval(window.location.reload(), 1500);
								}
							});	 
						
					}
					function extend_product(id, type){

						var cont = $("#admin_content");

						cont.addClass("loading_img").css("background-color","white");
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'trade/extend_product_status/"+id+"/"+type ,
								success: function (data) {
									//cont.removeClass("loading_img");
									//cont.html(data);
									 window.setInterval(window.location.reload(), 1500);
									cont.removeClass("loading_img");
								}
							});

					}

					function activate_product(id, str){

						var cont = $("#admin_content");

						cont.addClass("loading_img").css("background-color","white");
						$.ajax({
								type: "get",
								cache: false,
								url: "'.site_url('/').'trade/activate_product_status/"+id+"/"+str ,
								success: function (data) {
									//cont.removeClass("loading_img");
									//cont.html(data);
									 window.setInterval(window.location.reload(), 1500);
									cont.removeClass("loading_img");
								}
							});

					}
					function delete_product(id){
	
						$("#modal-product-delete").appendTo("body").unbind("show").bind("show", function()  {
							var removeBtn = $(this).find(".btn-primary"),
								href = removeBtn.attr("href");
								
								removeBtn.click(function(e) { 
										
									e.preventDefault();
					
											$.ajax({
												type: "get",
												url: "'.site_url('/').'trade/delete_product/"+id ,
												success: function (data) {
													 $("#row_"+id).fadeOut();
													 $("#modal-product-delete").modal("hide");
													 $("#msg").html(data).fadeIn().delay(3000).fadeOut();
													 //window.setInterval(window.location.reload(), 3500);	
												}
											});
								});
						}).modal({ backdrop: true });
					}
				</script>';
			
		 }else{
			
				if($section == 'sold'){
					echo '<div class="alert">
						 <h4>No Items have been Sold</h4> No items have been sold. Once you sell an item it will be saved here.
						 
						</div>';
				
				}elseif($section == 'bought'){
					echo '<div class="alert">
						 <h4>No Bought items</h4>You havent bought any items. Once you purchase an item it will be saved here.
						 
						</div>';
				}else{
					
					$str = "'sell'";
					echo '<div class="alert">
						
						 <h4>No '.$bstr.' Products added</h4> No items have been added. Please add a new product below.<br /><br />
						 <a href="'.site_url('/').'sell/index/'.$bus_id.'/"  class="btn btn-inverse"><i class="icon-plus icon-white"></i> Add a New Product</a>
						</div>'; 
				}
	 
			 
		 }
		  	  
		
	}


    function get_review_stars($rating,$id){

        $x = 1;
        $rating = round($rating);
        while($x <= 5){

            if($rating == $x){

                $str = 'checked="checked"';
            }else{

                $str = '';

            }

            $arr[$x] = '<input name="'.$id.'-'.$rating.'" type="radio" value="'.$x.'" class="star" disabled="disabled" '.$str.'/>
			';
            $x++;
        }
        return $arr;
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

    function time_ago($time) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();

        $difference     = $now - $time;
        $tense         = "ago";

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return $difference." ". $periods[$j] ." ago ";
    }

}
?>