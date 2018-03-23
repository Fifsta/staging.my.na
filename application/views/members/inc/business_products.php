<style>
#appadd {
    white-space: nowrap;
    overflow: hidden;
    width: 200px;
    height: 30px;
    text-overflow: ellipsis; 
}
</style>
      
<table id="product_table" class="table datatable table-striped" id="" width="100%" style="table-layout:fixed;">
  <thead>
    <tr style="font-weight:bold">
      <th style="width:100px"></th>
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
        <tr id="row-'.$row->product_id.'">
          <td style="width:100px"><img rel="tooltip"src="' . $img_url . '" alt="' . $row->title . '" class="pull-right img-thumbnail" /></td>
          <td id="appadd">'.$row->title.'</td>
          <td style="">'.$price.'</td>
          <td style="">'.date('Y-m-d',strtotime($row->end_date)).'</td>
          <td></td>
          <td class="text-right">

              <div class="btn-group dropleft text-left">
                  <button class="btn btn-sm btn-dark dropdown-toggle" title="Open the print options" rel="tooltip" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-flip="false"><i class="fa fa-download"></i> <span class="caret"></span></button>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="'.site_url('/').'trade/print_product/'.$row->product_id.'/" data-id="'.$row->product_id.'" class="btnPrint_single"><i class="icon-print"></i> Print Option 1</a>
                    <a class="dropdown-item" href="'.site_url('/').'trade/print_product2/'.$row->product_id.'/" data-id2="'.$row->product_id.'" class="btnPrint_single"><i class="icon-print"></i> Print Option 2</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="'.site_url('/').'trade/print_pdf/'.$row->product_id.'/" target="_blank"><i class="icon-share"></i> Export PDF 1</a>
                    <a class="dropdown-item" href="'.site_url('/').'trade/print_pdf/'.$row->product_id.'/2" target="_blank"><i class="icon-share"></i> Export PDF 2</a>
                  </div>
              </div>
              <div class="btn-group dropleft text-left">
                  <button class="btn btn-sm btn-dark dropdown-toggle" title="Open the product menu" rel="tooltip" data-toggle="dropdown"><i class="fa fa-cog"></i></button>
                  <div class="dropdown-menu">
                    <a href="'.site_url('/').'sell/update_product/'.$row->product_id.'/" id="upd_'.$row->product_id.'" onclick="update_product('.$row->product_id.');" class="dropdown-item"><i class="icon-pencil"></i> Update Item</a>
                    <a href="javascript:void(0)" data-id="'.$row->product_id.'" class="dropdown-item dbtn"><i class="icon-trash"></i> Remove Item</a>
                    <a href="'.site_url('/').'product/'.$row->product_id.'/" target="_blank" class="dropdown-item"><i class="icon-search"></i> View Item</a>
                  </div>
              </div>
          </td>
        </tr>
      ';

    }

  ?> 
  </tbody>
</table>

    <!-- Delete Product -->
    <div class="modal fade" id="modal-product-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Remove Product</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to remove the user from the business?</p>
          </div>
          <div class="modal-footer mdl-cont">
            <button type="button" class="btn btn-secondary p-btn-rmv">Remove</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
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




//Remove Business User
$(document).on('click', '.dbtn', function(e) {

  var id = $(this).attr("data-id");

  $("#modal-product-delete").appendTo("body").bind("show", function() {}).modal({ backdrop: true });

  $('.p-btn-rmv').attr('data-id', id);

});


$(document).on('click', '.p-btn-rmv', function(e) {

  var id = $(this).attr("data-id");
  var bus_id = $(this).attr("data-bus");

  $.ajax({
    type: "POST",
    url: "<?php echo site_url('/'); ?>trade/delete_product/",
      data: { 
          'id': id
      },    
    success: function (data) {

       $("#modal-product-delete").modal("hide");
       $('#row-'+id).remove();
       $("#msg").html(data).fadeIn().delay(3000).fadeOut();
    }
  }); 

});


</script>       