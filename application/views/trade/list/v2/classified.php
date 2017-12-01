<?php
//+++++++++++++++++++++++++++++++++
//STEP 3 Photos
//+++++++++++++++++++++++++++++++++

$str = '';
if (isset($bus_id) && $bus_id != 0) {

    $str = ' for Business';

}
?>

<div class="text-center">

   
    <a href="<?php echo site_url('/') . 'sell/update_product/' . $product_id . '/'; ?>"
       class="btn  btn-success disabled step2" style="margin:5px"> 1 Details <i class="icon-ok icon-white"></i></a>
    <a href="<?php echo site_url('/') . 'sell/step3/' . $product_id . '/' . $bus_id . '/'; ?>"
       class="btn btn-warning disabled btn-large step3" style="margin:5px"> 2 Attach Photos/Files <i
            class="icon-chevron-right icon-white"></i></a>
 
    <a href="<?php echo site_url('/') . 'sell/step5/' . $product_id . '/' . $bus_id . '/'; ?>"
       class="btn btn-inverse disabled step5" style="margin:5px"> 3 Confirm and Publish <i
            class="icon-chevron-right icon-white"></i></a>

</div>

        
<div class="clearfix">&nbsp;</div>
<h4 class="text-center">
    <small class="clearfix">Please add a notice title and description</small>
    SMALLS/CLASSIFIED/NOTICE<span></span></h4>
<div class="white_box padding10">
   
	<div class="col-lg-12">
            <form id="classified-add" name="classified-add" method="post" action="<?php echo site_url('/'); ?>sell/add_classified_item"
                  >
                <fieldset>
                    <input type="hidden" name="pub_id" id="pub_id" value=""/>
                    <input type="hidden" name="ed_id" id="ed_id" value=""/>
                    <input type="hidden" name="pub_bus_id" id="pub_bus_id" value="" />
                    <input type="hidden" name="cl_cat_id" id="cl_cat_id" value="" />
                    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>"/>
                    <input type="hidden" name="bus_id" id="bus_id" value="<?php if (isset($bus_id)) {
                        echo $bus_id;
                    } else {
                        echo '0';
                    } ?>"/>
                    <input type="hidden" name="product_id"  value="<?php if (isset($product_id)) {
                        echo $product_id;
                    } else {
                        echo '0';
                    } ?>"/>
                    
                     <div class="form-group">
                        <label  for="title">Category</label>


                            <input type="text" class="col-lg-12 typeahead keyboard-normal-cat form-control" id="search_cat_classified" name="search_cat_classified" type="text"
                           value="" style="margin-bottom:0px" autocomplete="off"
                           placeholder="Start typing here">
                           <span class="help-block" style="font-size:11px">Start typing for category suggestions</span>
                           <input type="text" class="col-lg-12 keyboard-normal-cat" data-min-length="0" id="search_cat_classified_test" name="search_cat_classified" type="text"
                           value="" style="margin-bottom:0px; visibility: hidden;margin-top:-35px" autocomplete="off"
                           placeholder="Start typing here">
                            

                    </div>
                    <div class="form-group" style="margin-top:-40px">
                        <label  for="title">Item</label>


                            <input type="text" class="col-lg-12  keyboard-normal form-control" id="classified_title" name="item_title" placeholder="Item title"
                                   value="<?php if (isset($title)) {
                                       echo $title;
                                   } ?>">
                            <span class="help-block" style="font-size:11px">The product title. Be specific, if it is a BMW a good title will be BMW 3 Series 320i</span>

                    </div>

					<div class="form-group">
                        <label>Publications:</label>

                        <div class="controls">

                            <div class="row text-center">
                            	<div class="col-lg-4 col-xs-4">
                                	<a onClick="" class="pub_select text-center" data-pub="1" data-edid="2" data-bus-id="3454">
                                    	<img src="<?php echo 'https://nmh.my.na/';?>img/publications/Nsun2-icon-1440px (1).png">
                                    </a>
                                </div>
                            	<div class="col-lg-4 col-xs-4">
                                	<a onClick="" class="pub_select text-center" data-pub="2" data-edid="1" data-bus-id="2713"><img src="<?php echo 'https://nmh.my.na/';?>img/publications/Rep-icon-1440px.png"></a>
                                </div>
                            	<div class="col-lg-4 col-xs-4">
                                	<a onClick="" class="pub_select text-center"  data-pub="3" data-edid="3" data-bus-id="4856"><img src="<?php echo 'https://nmh.my.na/';?>img/publications/AZ-icon-1440px.png"></a>
                                </div>
                            
                            </div>
                            <span class="help-block" style="font-size:11px">
                            Please describe the item or product. Please provide specific detail here. Condition and relevant specifications</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label  for="item_content">Item Description:</label>

                        <div class="controls">

                            <textarea id="classified_content" style="box-shadow:none" class="item_editor col-lg-12 keyboard-normal form-control" name="item_content"
                                      style="display:block"><?php if (isset($description)) {
                                    echo $description;
                                } ?></textarea>
                                                <span class="help-block" style="font-size:11px">
                                                Please describe the item or product. Please provide specific detail here. Condition and relevant specifications</span>
                        </div>
                    </div>
                    
                       <button type="submit" class="btn btn-success pull-right"
                            id="add_classified_btn"><?php if ($product_id != 0) {
                            echo 'Update Item';
                        } else {
                            echo 'Add Item';
                        } ?> <i class="icon-chevron-right icon-white"></i></button>
            	</fieldset>
            </form>



        <div class="clearfix">&nbsp;</div>
    </div>

</div>
<script type="text/javascript">
 

</script>
 
    