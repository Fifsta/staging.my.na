
<?php
//+++++++++++++++++++++++++++++++++
//STEP 1 Categories
//+++++++++++++++++++++++++++++++++

$str = '';
if(isset($bus_id) && $bus_id != 0){

    $str = ' for Business';

}

$data['type'] = $type;

?>
<div class="text-center">

    <a href="javascript:void(0);" class="btn btn-success btn-large step1" style="margin:5px"> 1 Select Category <i class="icon-chevron-right icon-white"></i></a>
    <a href="javascript:void(0);" class="btn btn-default disabled step2" style="margin:5px"> 2 Details <i class="icon-chevron-right icon-white"></i></a>
    <a href="javascript:void(0);" class="btn btn-default disabled step3" style="margin:5px"> 3 Attach Photos <i class="icon-chevron-right icon-white"></i></a>
    <a href="javascript:void(0);" class="btn btn-default disabled step4" style="margin:5px"> 4 Extras <i class="icon-chevron-right icon-white"></i></a>
    <a href="javascript:void(0);" class="btn btn-default disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="icon-chevron-right icon-white"></i></a>

</div>
<h4 class="text-center"><small class="clearfix">Please Choose a</small>PRODUCT CATEGORY<span></span></h4>
<div class="white_box padding10">

    <div class="clearfix" style="height:40px">&nbsp;</div>

    <form id="search-cat_b">
        <input type="text" class="col-lg-12 typeahead keyboard-normal-cat form-control"  data-min-length="0" id="search_category" name="search_category" type="text"
               value="" style="margin-bottom:0px;display:block" autocomplete="off"
               placeholder="Start typing here">


        <input type="text" class="col-lg-12 keyboard-normal-cat" data-min-length="0" id="search_category_test" name="search_category" type="text"
               value="" style="margin-bottom:0px; visibility: hidden" autocomplete="off"
               placeholder="Start typing here">
    </form>
    <div id="select_cats" style="min-height:200px;">
        <?php //$this->trade_model->load_product_categories($bus_id, $type);?>
    </div>
</div>

<div class="clearfix" style="height:200px;"></div>