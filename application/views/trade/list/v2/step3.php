<?php
//+++++++++++++++++++++++++++++++++
//STEP 2 Details
//+++++++++++++++++++++++++++++++++

$str = '';
if (isset($bus_id) && $bus_id != 0) {

    $str = ' for Business';

}

if (!isset($product_id)) {
    $step3 = '';
    $step4 = '';
    $step5 = '';
} else {

    $step3 = site_url('/') . 'sell/step3/' . $product_id . '/' . $bus_id . '/';
    $step4 = site_url('/') . 'sell/step4/' . $product_id . '/' . $bus_id . '/';
    $step5 = site_url('/') . 'sell/step5/' . $product_id . '/' . $bus_id . '/';
}

if(!isset($type)){

    $type = 'ITEM';
}

?>
<div id="anchor_me"></div>
<div class=" text-center">

    <a href="#" class="btn btn-warning disabled  step1" style="margin:5px"> 1 Select Category <i
            class="icon-ok icon-white"></i></a>
    <a href="" onclick="return false;" class="btn btn-success btn-large step2" style="margin:5px"> 2 Details <i
            class="icon-chevron-right icon-white"></i></a>
    <a href="<?php echo $step3; ?>" class="btn btn-default disabled step3" style="margin:5px"> 3 Attach Photos <i
            class="icon-chevron-right icon-white"></i></a>
    <a href="<?php echo $step4; ?>" class="btn btn-default disabled step4" style="margin:5px"> 4 Extras <i
            class="icon-chevron-right icon-white"></i></a>
    <a href="<?php echo $step5; ?>" class="btn btn-default disabled step5" style="margin:5px"> 5 Confirm and Publish <i
            class="icon-chevron-right icon-white"></i></a>

</div>


<div id="item_details">
    <div class="clearfix">&nbsp;</div>
    <div class="row  white_box">
        <div class="clearfix">&nbsp;</div>
        <h4 class="text-center">
            <small class="clearfix">Product Descriptions</small>
            <?php echo strtoupper($type);?> DETAILS<span></span></h4>

        <div class="col-lg-12">
            <form id="item-add" name="item-add" method="post" action="<?php echo site_url('/'); ?>sell/add_general_item"
                  >
                <fieldset>
                   <input type="hidden" name="cat1" id="cat1" value="<?php /*echo $cat1; */?>"/>
                    <input type="hidden" name="cat1name" id="cat1name" value="<?php /*echo $cat1name; */?>"/>
                    <input type="hidden" name="cat2" id="cat2" value="<?php /*echo $cat2; */?>"/>
                    <input type="hidden" name="cat2name" id="cat2name" value="<?php /*echo $cat2name; */?>"/>
                    <input type="hidden" name="cat3" id="cat3" value="<?php /*echo $cat3; */?>"/>
                    <input type="hidden" name="cat3name" id="cat3name" value="<?php /*echo $cat3name; */?>"/>
                    <input type="hidden" name="cat4" id="cat4" value="<?php /*echo $cat4; */?>"/>
                    <input type="hidden" name="cat4name" id="cat4name" value="<?php /*echo $cat4name; */?>"/>
                    <input type="hidden" name="client_id" value="<?php echo $client_id; ?>"/>
                    <input type="hidden" name="listing_ref" id="listing_ref" value="nmh_classifieds"/>
                    <input type="hidden" name="bus_id" id="bus_id" value="<?php if (isset($bus_id)) {
                        echo $bus_id;
                    } else {
                        echo '0';
                    } ?>"/>
                    <input type="hidden" name="product_id" id="product_id" value="<?php if (isset($product_id)) {
                        echo $product_id;
                    } else {
                        echo '0';
                    } ?>"/>

                    <!--<div class="form-group">
                        <label  for="category">Category</label>

                        <div class="controls">
                            <input type="text" class="col-lg-12 form-control" value="<?php //echo $catname; ?>" disabled>
                            <span class="help-block" style="font-size:11px">Listed in which category.</span>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label  for="title">Item</label>


                            <input type="text" class="col-lg-12  keyboard-normal form-control" id="item_title" name="item_title" placeholder="Item title"
                                   value="<?php if (isset($title)) {
                                       echo $title;
                                   } ?>">
                            <span class="help-block" style="font-size:11px">The product title. Be specific, if it is a BMW a good title will be BMW 3 Series 320i</span>

                    </div>

                    <div class="form-group">
                        <label  for="item_content">Item Description:</label>

                        <div class="controls">

                            <textarea id="item_content" style="box-shadow:none" class="item_editor col-lg-12 keyboard-normal form-control" name="item_content"
                                      style="display:block"><?php if (isset($description)) {
                                    echo $description;
                                } ?></textarea>
                                                <span class="help-block" style="font-size:11px">
                                                Please describe the item or product. Please provide specific detail here. Condition and relevant specifications</span>
                        </div>
                    </div>


                    <!--<div class="form-group">
                        <label  for="item_loc">Location</label>

                        <div class="controls">

                            <select onchange="populateSuburb(this.value);" class="col-lg-12 form-control" id="item_loc" name="item_loc"
                                    placeholder="Location">
                                <option value="National">National</option>
                                <?php $cities = $this->trade_model->get_cities();
                                foreach ($cities->result() as $row2) {

                                    if (isset($location) && $location == $row2->MAP_LOCATION) {

                                        echo '<option value="' . $row2->MAP_LOCATION . '" selected="selected">' . $row2->MAP_LOCATION . '</option>';

                                    } else {

                                        echo '<option value="' . $row2->MAP_LOCATION . '">' . $row2->MAP_LOCATION . '</option>';

                                    }

                                }

                                ?>
                            </select>

                            <span class="help-block" style="font-size:11px">Please select a location for the item</span>

                        </div>
                    </div>-->

                   <!-- <div class="form-group">
                        <label  for="item_suburb">Suburb</label>

                        <div class="controls">

                            <?php //POPULATE SUBURB PLACEHOLDER ?>
                            <div id="suburb_div">
                                <?php if (isset($location)) {
                                    echo $this->trade_model->populate_suburb_name($location, $suburb);

                                } else {

                                    echo $this->trade_model->populate_suburb_name($location = '', $suburb = '');


                                }
                                ?>
                            </div>

                            <span class="help-block" style="font-size:11px">Please select a suburb if available</span>

                        </div>
                    </div>-->


                    <?php

                    //IF SERVICE DO NOT SHOW AUCTION OR SALE TYPE
                    if ($type != 'service') {
                        ?>
                        <!--<div class="form-group" id="listing_sel_type">
                            <label  for="gender">Listing Type</label>

                            <div class="controls">
                                <div class="btn-group" data-toggle="buttons-radio">
                                    <button type="button" id="sale_click" onclick="javascript:togglecheck('S');" class="btn
												  <?php if (isset($listing_type) && ($listing_type == 'S')) {
                                        echo 'btn-success active';
                                    } elseif (!isset($listing_type)) {
                                        echo 'btn-success active';
                                    }; ?>">Fixed Price
                                    </button>
                                    <button type="button" id="auction_click" onclick="javascript:togglecheck('A');"
                                            class="btn
                                                  <?php if (isset($listing_type) && ($listing_type == 'A')) {
                                                echo 'btn-success active';
                                            } ?>">Auction
                                    </button>

                                </div>
                                <input type="hidden" name="listing_type" id="listing_type"
                                       value="<?php if (isset($listing_type)) {
                                           echo $listing_type;
                                       } else {
                                           echo 'S';
                                       } ?>"/>
                                <span class="help-block" style="font-size:11px">Do you want to have a fixed price for the item or put it on auction.</span>
                            </div>
                        </div>-->

                    <?php }else{
                        //ADD A HIDDEN TYPE OF C for SERVICE
                        ?>

                        <input type="hidden" name="listing_type" id="listing_type" value="C">
                    <?php } ?>

                    <!-- Fixed Pricing -->
                    <?php //
                    if (!isset($sale_price)) {

                        $sale_price = 0;
                    }
                    if (strpos($sale_price, '.')) {

                        $cents = substr($sale_price, strpos($sale_price, '.') + 1, strlen($sale_price));
                        $dolla = substr($sale_price, 0, strpos($sale_price, '.'));
                    } else {

                        $cents = '00';
                        $dolla = $sale_price;

                    }
                    ?>
                    <div id="fixed_pricing" <?php if (isset($listing_type) && ($listing_type == 'A')) {
                        echo 'class="hide"';
                    } ?>>

                        <div class="form-group">
                            <label  for="price_u">Price N$</label>

                            <div class="controls">
                                <div class="col-lg-6 col-xs-6">
                                    <div class="row">
                                        <div class="col-lg-8 col-xs-8">

                                            <input type="text" class=" keyboard-numbers form-control" id="price" name="price"
                                                   onkeypress="return isNumberKey(event)" placeholder="N$ 500"
                                                   value="<?php if ($dolla != 0) {
                                                       echo $dolla;
                                                   } ?>">
                                        </div>
                                        <div class="col-lg-4 col-xs-4">
                                            <input type="number" class=" keyboard-numbers form-control" max="99" id="price_c" name="price_c"
                                                   onkeypress="return isNumberKey(event)" placeholder="99 cents"
                                                   value="<?php if ($cents != 0) {
                                                       echo $cents;
                                                   } ?>">

                                        </div>
                                    </div>


                                    <span class="help-block" style="font-size:11px">What is the fixed price of the item/product in N$ - Second box is for the cent value of the price if required</span>
                                </div>

                                <div class="col-lg-2 col-xs-2">
                                    <?php if ($bus_id != 0) { ?>
                                        <input type="checkbox" name="por"
                                               value="POR" <?php if (isset($por) && $por == 'Y') {
                                            echo 'checked="checked"';
                                        } ?>>
                                        <span class="help-block" style="font-size:11px">Is the price available on request?</span>

                                    <?php } ?>

                                </div>
                                <div class="col-lg-4 col-xs-4">

                                    <h1 id="money-preview" style="margin-top:0"
                                        class="yellow upper na_script"><?php if (isset($dolla)) {
                                            echo ' N$ ' . $dolla;
                                        } ?><?php if (isset($cents)) {
                                            echo '.' . $cents;
                                        } else {
                                            echo '.00';
                                        } ?></h1>

                                </div>

                            </div>
                        </div>

                    </div>

                    <!--  End Fixed Pricing -->


                    <!-- Auction Pricing -->
                    <div id="auction_pricing" <?php if (isset($listing_type) && ($listing_type == 'A')) {
                        echo '';
                    } else {
                        echo 'class="hide"';
                    } ?> >

                        <div class="form-group">
                            <label  for="start_price">Start Price</label>

                            <div class="controls">
                                <div class="col-lg-6">

                                    <input type="text" class="col-lg-12 keyboard-numbers form-control" id="start_price" name="start_price"
                                           onkeypress="return isNumberKey(event)" placeholder="Start Price"
                                           value="<?php if (isset($start_price)) {
                                               echo $start_price;
                                           } ?>">
                                    <span class="help-block" style="font-size:11px">What is the normal value of the item/promotion in N$</span>
                                </div>

                                <div class="col-lg-6">
                                    <input type="text" class="col-lg-12 keyboard-numbers form-control" id="reserve" name="reserve"
                                           onkeypress="return isNumberKey(event)" placeholder="Reserve"
                                           value="<?php if (isset($reserve)) {
                                               echo $reserve;
                                           } ?>">
                                    <span class="help-block" style="font-size:11px">What is the reserve value? If the reserve bid hasnt been matched at the end of the auction the item is not sold.</span>
                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label  for="slug">Duration</label>

                            <div class="controls">
                                <div class="input-append date col-lg-6" id="dpstart" data-date="102/2012"
                                     data-date-format="yyyy-mm-dd" data-date-minviewmode="months">
                                    <input class="col-lg-9" size="16" type="text" name="dpstart"
                                           value="<?php if (isset($start_date)) {
                                               echo date('Y-m-d', strtotime($start_date));
                                           } else {
                                               echo date('Y-m-d');
                                           } ?>" readonly>
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                                <div class="input-append date col-lg-6" id="dpend" data-date="102/2012"
                                     data-date-format="yyyy-mm-dd" data-date-minviewmode="months">
                                    <input class="col-lg-9" size="16" type="text" name="dpend"
                                           value="<?php if (isset($end_date)) {
                                               echo date('Y-m-d', strtotime($end_date));
                                           } else {
                                               echo date('Y-m-d', strtotime("+7 days"));
                                           } ?>" readonly>
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                </div>
                                <p>&nbsp;</p>

                                <div class="alert">Your auction will start when it is approved and will run for a
                                    duration of <strong>7 Days</strong> by default. Ends on
                                    <strong><?php if (isset($end_date)) {
                                            echo date('g:ia \o\n l jS', strtotime($end_date));
                                        } else {
                                            echo date('g:ia \o\n l jS', strtotime("+7 days"));
                                        } ?></strong></div>
                                <!--<span class="help-block" style="font-size:11px">From when to when is the listing available. </span>-->
                            </div>
                        </div>


                    </div>
                    <!--  End Auction Pricing -->
                    <?php

                    //IF SERVICE DO NOT SHOW QUANTITY
                    if ($type != 'service') {
                        ?>
                        <!--<div class="form-group" id="quantity_group">
                            <label  for="quantity">Quantity</label>

                            <div class="controls">
                                <input type="number" class="col-lg-1 keyboard-numbers form-control" id="quantity" name="quantity" placeholder="1"
                                       value="<?php if (isset($quantity)) {
                                           echo $quantity;
                                       } else {
                                           echo '1';
                                       } ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                <span class="help-block" style="font-size:11px">How many quantities are available Leave 0 if limitless. Please note:  A whole set of four tires are collectively 1 quantity.</span>

                            </div>
                        </div>-->

                    <?php }else{
                        //IF SERVICE SHOW QUANTITY 0
                        ?>
                        <input type="hidden" name="quantity" id="quantity" value="0">


                    <?php } ?>
    

                    <div id="msg_step2"></div>
                    <button type="submit" class="btn btn-success pull-right"
                            id="add_item_btn"><?php if ($product_id != 0) {
                            echo 'Update Item';
                        } else {
                            echo 'Add Item';
                        } ?> <i class="icon-chevron-right icon-white"></i></button>
                    <?php if (isset($product_id)) {

                        $str = 'disabled';
                        $java = '';

                    } else {

                        $str = '';
                        $java = 'onclick="back_to_1()"';
                    }
                    ?>
                    <!--<a href="<?php /*echo current_url('/'); */?>"
                       id="back_to_all" class="btn btn-default pull-right" style="margin-right:5px"><i
                            class="icon-list icon-white"></i> Back</a>-->
                    <a href="javascript:void(0)" <?php echo $java; ?>
                       class="btn btn-warning pull-right hide <?php echo $str; ?>" style="margin-right:5px"><i
                            class="icon-chevron-left icon-white"></i> Back</a>
                </fieldset>
            </form>
            <div class="row">
            	<div class="col-lg-12">
                
                	<div id="item_msg"></div>
                </div>
                
            </div>
        </div>
    </div>
</div>
