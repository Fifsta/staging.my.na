<div class="row">

      <div class="col-md-12">
        <h4>Listings<small> Your current Products items</small></h4>
      </div>


      
      <table id="product_table" class="table datatable table-striped" id="" style="width:100%">
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


        <script type="text/javascript">

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
</script>             