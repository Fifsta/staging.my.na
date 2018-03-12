<div class="row">

      <div class="col-md-12">
        <h4>Listings<small> Your current Products items</small></h4>
      </div>

      <div class="clearfix" style="height:20px"></div>
      <table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" id="product_table" class="table table-striped datatable" id="" width="100%">
        <thead>
          <tr style="font-weight:bold">
            <th style=""></th>
            <th style="">Title</th>
            <th style="">Price</th>
            <th style="">End</th>
            <th style="">Agent</th>
            <th style=""></th>
          </tr>
        </thead>
        <tbody>

        <?php

          $thumbnailUrlFactory = $this->image_model->thumborp->create_factory();
          $width = 60;
          $height = 60;   

          foreach($products->result() as $row){ 

            $t = explode(',', $row->images);
            $image_path = reset($t);

            if($image_path != ''){
              
              $img = 'assets/products/images/'.$image_path;
              $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img,$width,$height, $crop = '');

            }else{
              
              $img = 'assets/products/images/product_blank.jpg';
              $img_url = $this->image_model->get_image_url_param($thumbnailUrlFactory, $img,$width,$height, $crop = '');

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

            echo '
              <tr>
                <td style=""><img rel="tooltip"src="' . $img_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" /></td>
                <td style="">'.$row->title .'</td>
                <td style="">'.$price.'</td>
                <td style="">'.date('Y-m-d',strtotime($row->end_date)).'</td>
                <td></td>
                <td style=""></td>
              </tr>
            ';

          }

        ?> 
        </tbody>
      </table>  
</div>               