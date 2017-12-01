<?php
$existing = $this->trade_model->get_extras($product_id);
//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS SELECT
//++++++++++++++++++++++++++
function test_extras($existing, $extra, $product_id, $type)
{

    if ($existing != '') {

        foreach ($existing as $row => $value) {

            // if Array
            if (is_array($value)) {

                foreach ($value as $finalrow => $final_val) {

                    if ($final_val == $extra) {

                        //if Output selected , value or checked
                        if ($type == 'output') {

                            echo $final_val;

                        } else {

                            echo $type;

                        }


                    }

                }

            } else {

                if ($value == $extra) {

                    //if Output selected , value or checked
                    if ($type == 'output') {

                        echo $value;

                    } else {

                        echo $type;

                    }

                }

            }


        }

    }
}

//+++++++++++++++++++++++++++
//TEST PRODUCT EXTRAS
//++++++++++++++++++++++++++
function test_extras_output($existing, $extra, $product_id, $type)
{

    if ($existing != '') {

        if (array_key_exists($extra, $existing)) {

            //if Output selected , value or checked
            if ($type == 'output') {

                echo $existing[$extra];

            } else {

                echo $type;

            }

        }


    }
}

?>

<div class="control-group">
    <label class="control-label" for="year">Year</label>

    <div class="controls">
        <input type="text" class="span12"
               value="<?php test_extras_output($existing['extras'], 'year', $product_id, 'output'); ?>" name="year"
               placeholder="Year make of the car">
        <span class="help-block" style="font-size:11px">What year model is the car? What year was it built</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="kilometres">Kilometers</label>

    <div class="controls">
        <input type="text" class="span12" name="kilometres" placeholder="Kilometres"
               value="<?php test_extras_output($existing['extras'], 'kilometres', $product_id, 'output'); ?>">
        <span class="help-block" style="font-size:11px">The vehicle’s odometer reading in kilometres. </span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="color">Color</label>

    <div class="controls">

        <input type="text" class="span12" name="color"
               value="<?php test_extras_output($existing['extras'], 'color', $product_id, 'output'); ?>"
               placeholder="Color">
                                                <span class="help-block" style="font-size:11px">
                                                What colour is the item? eg: blue, red, metallic silver</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="doors">Doors</label>

    <div class="controls">

        <select name="doors" data-placeholder="Please Select" class="extra_slect span12">
            <option value="" <?php test_extras($existing, 'Dont Know', $product_id, 'selected'); ?>>Don't Know</option>
            <option value="1 door" <?php test_extras($existing, '1 door', $product_id, 'selected'); ?>>1 door</option>
            <option value="2 door" <?php test_extras($existing, '2 door', $product_id, 'selected'); ?>>2 door</option>
            <option value="3 door" <?php test_extras($existing, '3 door', $product_id, 'selected'); ?>>3 door</option>
            <option value="4 door" <?php test_extras($existing, '4 door', $product_id, 'selected'); ?>>4 door</option>
            <option value="5 door" <?php test_extras($existing, '5 door', $product_id, 'selected'); ?>>5 door</option>
            <option value="6 door" <?php test_extras($existing, '6 door', $product_id, 'selected'); ?>>6 door</option>
            <option value="7 door" <?php test_extras($existing, '7 door', $product_id, 'selected'); ?>>7 door</option>
        </select>
                                                <span class="help-block" style="font-size:11px">
                                               How many doors does the vehicle have </span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="body_style">Body Style</label>

    <div class="controls">
        <select name="body_style" data-placeholder="Please Select" class="extra_slect span12">
            <option value="" <?php test_extras($existing, 'Dont know', $product_id, 'selected'); ?>>Don't Know</option>
            <option value="Convertible" <?php test_extras($existing, 'Convertible', $product_id, 'selected'); ?>>
                Convertible
            </option>
            <option value="Coupe" <?php test_extras($existing, 'Coupe', $product_id, 'selected'); ?>>Coupe</option>
            <option value="Hatchback" <?php test_extras($existing, 'Hatchback', $product_id, 'selected'); ?>>Hatchback
            </option>
            <option value="Sedan" <?php test_extras($existing, 'Sedan', $product_id, 'selected'); ?>>Sedan</option>
            <option value="Station Wagon" <?php test_extras($existing, 'Station Wagon', $product_id, 'selected'); ?>>
                Station Wagon
            </option>
            <option value="RV/SUV" <?php test_extras($existing, 'RV/SUV', $product_id, 'selected'); ?>>RV/SUV</option>
            <option value="Bakkie" <?php test_extras($existing, 'Bakkie', $product_id, 'selected'); ?>>Bakkie</option>
            <option value="Panel Van" <?php test_extras($existing, 'Panel Van', $product_id, 'selected'); ?>>Panel Van
            </option>
            <option value="Other" <?php test_extras($existing, 'Other', $product_id, 'selected'); ?>>Other</option>
        </select>
                                                <span class="help-block" style="font-size:11px">
                                               What body type is the vehicle</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="fuel_type">Fuel Type</label>

    <div class="controls">
        <select name="fuel_type" data-placeholder="Please Select" class="extra_slect span12">
            <option value=""  <?php test_extras($existing, 'Dont know', $product_id, 'selected'); ?>>Don't Know</option>
            <option value="Petrol"  <?php test_extras($existing, 'Petrol', $product_id, 'selected'); ?>>Petrol</option>
            <option value="Diesel" <?php test_extras($existing, 'Diesel', $product_id, 'selected'); ?>>Diesel</option>
            <option value="CNG" <?php test_extras($existing, 'CNG', $product_id, 'selected'); ?>>CNG</option>
            <option value="LPG" <?php test_extras($existing, 'LPG', $product_id, 'selected'); ?>>LPG</option>
            <option value="Alternative" <?php test_extras($existing, 'Alternative', $product_id, 'selected'); ?>>
                Alternative
            </option>
        </select>
                                                <span class="help-block" style="font-size:11px">
                                               What fuel does it run on</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="cylinders">Cylinders</label>

    <div class="controls">
        <select name="cylinders" data-placeholder="Please Select" class="extra_slect span12">
            <option selected="selected" value="">Don't Know</option>
            <option value="Rotary" <?php test_extras($existing, 'Rotary', $product_id, 'selected'); ?>>Rotary</option>
            <option value="4 cylinder" <?php test_extras($existing, '4 cylinder', $product_id, 'selected'); ?>>4
                cylinder
            </option>
            <option value="5 cylinder" <?php test_extras($existing, '5 cylinder', $product_id, 'selected'); ?>>5
                cylinder
            </option>
            <option value="6 cylinder" <?php test_extras($existing, '6 cylinder', $product_id, 'selected'); ?>>6
                cylinder
            </option>
            <option value="8 cylinder" <?php test_extras($existing, '8 cylinder', $product_id, 'selected'); ?>>8
                cylinder
            </option>
            <option value="10 cylinder" <?php test_extras($existing, '10 cylinder', $product_id, 'selected'); ?>>10
                cylinder
            </option>
            <option value="12 cylinder" <?php test_extras($existing, '12 cylinder', $product_id, 'selected'); ?>>12
                cylinder
            </option>
        </select>
                                                <span class="help-block" style="font-size:11px">
                                               How many cylinders does the engine have</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="engine_size">Engine Size</label>

    <div class="controls">

        <input class="span12" type="text" name="engine_size"
               value="<?php test_extras_output($existing['extras'], 'engine_size', $product_id, 'output'); ?>"
               placeholder="Engine Size cc">
                                                <span class="help-block" style="font-size:11px">
                                                How much cubic capacity is the engine in cc</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="transmission">Transmission</label>

    <div class="controls">
        <select name="transmission" data-placeholder="Please Select" class="extra_slect span12">
            <option value="" <?php test_extras($existing, 'Dont Know', $product_id, 'selected'); ?>>Dont Know</option>
            <option value="Manual" <?php test_extras($existing, 'Manual', $product_id, 'selected'); ?>>Manual</option>
            <option value="Automatic" <?php test_extras($existing, 'Automatic', $product_id, 'selected'); ?>>Automatic
            </option>
            <option value="Tiptronic" <?php test_extras($existing, 'Tiptronic', $product_id, 'selected'); ?>>Tiptronic
            </option>
            <option value="Tiptronic" <?php test_extras($existing, '8 Speed Tiptronic', $product_id, 'selected'); ?>>8
                Speed Tiptronic
            </option>
            <option value="S/tronic" <?php test_extras($existing, 'S/tronic', $product_id, 'selected'); ?>>S/tronic
            </option>
            <option value="M/tronic" <?php test_extras($existing, 'M/tronic', $product_id, 'selected'); ?>>M/tronic
            </option>
        </select>
                                                <span class="help-block" style="font-size:11px">
                                               What transmission is the vehicle</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="4wd">4WD</label>

    <div class="controls">
        <input type="checkbox" name="4wd"
               value="4 Wheel Drive" <?php test_extras_output($existing['extras'], '4wd', $product_id, 'checked'); ?>>
                                                <span class="help-block" style="font-size:11px">
                                               Is the vehicle 4 Wheel Drive</span>
    </div>
</div>

<div class="control-group">
    <label class="control-label" for="agency">Car Reference</label>

    <div class="controls">

        <input type="text" class="span12" name="agency"
               value="<?php test_extras_output($existing['extras'], 'agency', $product_id, 'output'); ?>"
               placeholder="John Deere">
                                                                                        <span class="help-block"
                                                                                              style="font-size:11px">
                                                                                       Your unique car identification or SKU eg: #REF453</span>
    </div>
</div>

<?php //TEST IF ESTATE AGENT

$agents = $this->trade_model->property_agents($bus_id, $existing['property_agent']);

if ($agents != FALSE || $bus_id == 2706 || $bus_id == 2709 || $bus_id == 2666 || $bus_id == 5959 || $bus_id == 9120 || $bus_id == 4404 || $bus_id == 4608) { ?>
    <div class="control-group">
        <label class="control-label" for="featured">Is the Car Featured</label>

        <div class="controls">
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" onclick="javascript:toggleextra('Y', 'featured');"
                        class="btn btn-inverse <?php if ($existing['featured'] == 'Y') {
                            echo 'active';
                        }?>">Yes
                </button>
                <button type="button" onclick="javascript:toggleextra('N', 'featured');"
                        class="btn btn-inverse <?php if ($existing['featured'] == 'N') {
                            echo 'active';
                        }?>">No
                </button>

            </div>
            <input type="hidden" name="featured" id="toggle_featured" value="<?php if ($existing['featured'] == '0') {
                echo 'N';
            } else {
                echo $existing['featured'];
            }?>"/>
            <span class="help-block"
                  style="font-size:11px">Should the car be displayed as a featured vehicle?</span>

        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="seller_contact">Internal Notes</label>

        <div class="controls">
            <textarea name="seller_contact" class="span12" placeholder="Sellers Contact Details" cols="2"
                      rows="4"><?php echo $existing['seller_contact'];?></textarea>
                     <span class="help-block" style="font-size:11px">The sellers contact details and other notes. NB only for your Reference!</span>
        </div>
    </div>
<?php

}


?>


<div class="control-group">
    <label class="control-label" for="warranty">Warranty</label>

    <div class="controls">
        <input type="checkbox" name="warranty"
               value="Warranty" <?php test_extras_output($existing['extras'], 'warranty', $product_id, 'checked'); ?>>
                                                <span class="help-block" style="font-size:11px">
                                               Does the vehicle come with a warranty</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="owners">New or Used</label>

    <div class="controls">
        <select name="owners" data-placeholder="Please Select" class="extra_slect span12">
            <option selected="selected" value="">Don't Know</option>
            <option value="New" <?php test_extras($existing, 'New', $product_id, 'selected'); ?>>New</option>
            <option value="1 owner" <?php test_extras($existing, '1 owner', $product_id, 'selected'); ?>>1 owner
            </option>
            <option value="2 owners" <?php test_extras($existing, '2 owners', $product_id, 'selected'); ?>>2 owners
            </option>
            <option value="3 owners" <?php test_extras($existing, '3 owners', $product_id, 'selected'); ?>>3 owners
            </option>
            <option value="4 owners" <?php test_extras($existing, '4 owners', $product_id, 'selected'); ?>>4 owners
            </option>
            <option
                value="5 owners or more" <?php test_extras($existing, '5 owners or more', $product_id, 'selected'); ?>>5
                owners or more
            </option>
        </select>
                                                <span class="help-block" style="font-size:11px">
                                               How many people have owned the vehicle or is it New</span>
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="features">Features</label>

    <div class="controls">
        <select name="features[]" data-placeholder="Please Select" class="extra_slect span12" multiple="" size="6">

            <option
                value="ABS brakes" <?php test_extras($existing['extras'], 'ABS brakes', $product_id, 'selected'); ?>>ABS
                brakes
            </option>
            <option
                value="Air conditioning" <?php test_extras($existing['extras'], 'Air conditioning', $product_id, 'selected'); ?>>
                Air conditioning
            </option>
            <option
                value="Alloy wheels" <?php test_extras($existing['extras'], 'Alloy wheels', $product_id, 'selected'); ?>>
                Alloy wheels
            </option>
            <option
                value="Central locking" <?php test_extras($existing['extras'], 'Central locking', $product_id, 'selected'); ?>>
                Central locking
            </option>
            <option
                value="Driver airbag" <?php test_extras($existing['extras'], 'Driver airbag', $product_id, 'selected'); ?>>
                Driver airbag
            </option>
            <option
                value="Passenger airbag" <?php test_extras($existing['extras'], 'Passenger airbag', $product_id, 'selected'); ?>>
                Passenger airbag
            </option>
            <option
                value="Passenger airbag" <?php test_extras($existing['extras'], 'Curtain Airbags', $product_id, 'selected'); ?>>
                Curtain Airbags
            </option>
            <option value="Sunroof" <?php test_extras($existing['extras'], 'Sunroof', $product_id, 'selected'); ?>>
                Sunroof
            </option>
            <option
                value="Power steering" <?php test_extras($existing['extras'], 'Power Steering', $product_id, 'selected'); ?>>
                Power steering
            </option>
            <option value="Towbar" <?php test_extras($existing['extras'], 'Towbar', $product_id, 'selected'); ?>>
                Towbar
            </option>
            <option value="Alarm" <?php test_extras($existing['extras'], 'Alarm', $product_id, 'selected'); ?>>Alarm
            </option>
            <option value="PDC" <?php test_extras($existing['extras'], 'PDC', $product_id, 'selected'); ?>>PDC</option>
            <option value="TPMS" <?php test_extras($existing['extras'], 'TPMS', $product_id, 'selected'); ?>>TPMS
            </option>
            <option
                value="Xenon Lights" <?php test_extras($existing['extras'], 'Xenon Lights', $product_id, 'selected'); ?>>
                Xenon Lights
            </option>
            <option
                value="Navigation System" <?php test_extras($existing['extras'], 'Navigation System', $product_id, 'selected'); ?>>
                Navigation System
            </option>
            <option
                value="Leather Seats" <?php test_extras($existing['extras'], 'Leather Seats', $product_id, 'selected'); ?>>
                Leather Seats
            </option>
            <option
                value="CD Changer" <?php test_extras($existing['extras'], 'CD Changer', $product_id, 'selected'); ?>>CD
                Changer
            </option>
            <option
                value="Climate Control" <?php test_extras($existing['extras'], 'Climate Control', $product_id, 'selected'); ?>>
                Climate Control
            </option>
            <option
                value="Cruise Control" <?php test_extras($existing['extras'], 'Cruise Control', $product_id, 'selected'); ?>>
                Cruise Control
            </option>
            <option
                value="Electronic Stability Control" <?php test_extras($existing['extras'], 'Electronic Stability Control', $product_id, 'selected'); ?>>
                Electronic Stability Control
            </option>
            <option
                value="Multi Function Steering" <?php test_extras($existing['extras'], 'Multi Function Steering', $product_id, 'selected'); ?>>
                Multi Function Steering
            </option>
            <option value="Fog Lamps" <?php test_extras($existing['extras'], 'Fog Lamps', $product_id, 'selected'); ?>>
                Fog Lamps
            </option>
            <option
                value="Electric Seats" <?php test_extras($existing['extras'], 'Electric Seats', $product_id, 'selected'); ?>>
                Electric Seats
            </option>
            <option
                value="Rear Diff Lock" <?php test_extras($existing['extras'], 'Rear Diff Lock', $product_id, 'selected'); ?>>
                Rear Diff Lock
            </option>
            <option
                value="Adaptive Cruise Control" <?php test_extras($existing['extras'], 'Adaptive Cruise Control', $product_id, 'selected'); ?>>
                Adaptive Cruise Control
            </option>
            <option
                value="Keyless Entry" <?php test_extras($existing['extras'], 'Keyless Entry', $product_id, 'selected'); ?>>
                Keyless Entry
            </option>
            <option
                value="Rear Mount Spare" <?php test_extras($existing['extras'], 'Rear Mount Spare', $product_id, 'selected'); ?>>
                Rear Mount Spare
            </option>
            <option
                value="Bang Olufsen Sound" <?php test_extras($existing['extras'], 'Bang Olufsen Sound', $product_id, 'selected'); ?>>
                Bang Olufsen Sound
            </option>
            <option
                value="Blue Tooth" <?php test_extras($existing['extras'], 'Blue Tooth', $product_id, 'selected'); ?>>
                Blue Tooth
            </option>
            <option
                value="3 Row Seats" <?php test_extras($existing['extras'], '3 Row Seats', $product_id, 'selected'); ?>>3
                Row Seats
            </option>
            <option
                value="Sport Pack" <?php test_extras($existing['extras'], 'Sport Pack', $product_id, 'selected'); ?>>
                Sport Pack
            </option>
            <option
                value="Full Spare Wheel" <?php test_extras($existing['extras'], 'Full Spare Wheel', $product_id, 'selected'); ?>>
                Full Spare Wheel
            </option>
            <option value="Bull Bar" <?php test_extras($existing['extras'], 'Bull Bar', $product_id, 'selected'); ?>>
                Bull Bar
            </option>
            <option value="Tow Bar" <?php test_extras($existing['extras'], 'Tow Bar', $product_id, 'selected'); ?>>Tow
                Bar
            </option>
            <option value="Canopy" <?php test_extras($existing['extras'], 'Canopy', $product_id, 'selected'); ?>>
                Canopy
            </option>
            <option
                value="Spotlights" <?php test_extras($existing['extras'], 'Spotlights', $product_id, 'selected'); ?>>
                Spotlights
            </option>
            <option value="IPOP Kit" <?php test_extras($existing['extras'], 'IPOP Kit', $product_id, 'selected'); ?>>
                IPOP Kit
            </option>
            <option value="Mud Flaps" <?php test_extras($existing['extras'], 'Mud Flaps', $product_id, 'selected'); ?>>
                Mud Flaps
            </option>
            <option value="Nudge Bar" <?php test_extras($existing['extras'], 'Nudge Bar', $product_id, 'selected'); ?>>
                Nudge Bar
            </option>
            <option
                value="Running Boards" <?php test_extras($existing['extras'], 'Running Boards', $product_id, 'selected'); ?>>
                Running Boards
            </option>
            <option value="Tralies" <?php test_extras($existing['extras'], 'Tralies', $product_id, 'selected'); ?>>
                Tralies
            </option>
            <option
                value="Tinted Windows" <?php test_extras($existing['extras'], 'Tinted Windows', $product_id, 'selected'); ?>>
                Tinted Windows
            </option>
            <option
                value="After Market Bumper" <?php test_extras($existing['extras'], 'After Market Bumper', $product_id, 'selected'); ?>>
                After Market Bumper
            </option>
            <option
                value="Auto Armor" <?php test_extras($existing['extras'], 'Auto Armor', $product_id, 'selected'); ?>>
                Auto Armor
            </option>
            <option value="VPS" <?php test_extras($existing['extras'], 'VPS', $product_id, 'selected'); ?>>VPS</option>
            <option
                value="Park Assist" <?php test_extras($existing['extras'], 'Park Assist', $product_id, 'selected'); ?>>
                Park Assist
            </option>
            <option
                value="Keyless Start" <?php test_extras($existing['extras'], 'Keyless Start', $product_id, 'selected'); ?>>
                Keyless Start
            </option>
            <option
                value="Front Camera" <?php test_extras($existing['extras'], 'Front Camera', $product_id, 'selected'); ?>>
                Front Camera
            </option>
            <option
                value="Rear Camera" <?php test_extras($existing['extras'], 'Rear Camera', $product_id, 'selected'); ?>>
                Rear Camera
            </option>
            <option
                value="After Market Bumper" <?php test_extras($existing['extras'], 'After Market Bumper', $product_id, 'selected'); ?>>
                After Market Bumper
            </option>

            <option
                value="EBD Electronic Brake-Pressure Distribution" <?php test_extras($existing['extras'], 'EBD Electronic Brake-Pressure Distribution', $product_id, 'selected'); ?>>
                EBD Electronic Brake-Pressure Distribution
            </option>
            <option
                value="ESP Electronic Stability Programme" <?php test_extras($existing['extras'], 'ESP Electronic Stability Programme', $product_id, 'selected'); ?>>
                ESP Electronic Stability Programme
            </option>
            <option
                value="ASR Anti Spin Regulation" <?php test_extras($existing['extras'], 'ASR Anti Spin Regulation', $product_id, 'selected'); ?>>
                ASR Anti Spin Regulation
            </option>
            <option
                value="EDL Electronic Differential lock" <?php test_extras($existing['extras'], 'EDL Electronic Differential lock', $product_id, 'selected'); ?>>
                EDL Electronic Differential lock
            </option>
            <option
                value="Disc Brakes" <?php test_extras($existing['extras'], 'Disc Brakes', $product_id, 'selected'); ?>>
                Disc Brakes
            </option>
            <option
                value="Keyless Access" <?php test_extras($existing['extras'], 'Keyless Access', $product_id, 'selected'); ?>>
                Keyless Access
            </option>
            <option
                value="Bluemotion Technology" <?php test_extras($existing['extras'], 'Bluemotion Technology', $product_id, 'selected'); ?>>
                Bluemotion Technology
            </option>
            <option
                value="Climate Control" <?php test_extras($existing['extras'], 'Climate Control', $product_id, 'selected'); ?>>
                Climate Control
            </option>
            <option
                value="Sport Seats" <?php test_extras($existing['extras'], 'Sport Seats', $product_id, 'selected'); ?>>
                Sport Seats
            </option>
        </select>
												
                                                <span class="help-block" style="font-size:11px">
                                               Please select additional features</span>

    </div>
</div>


<?php //CAR FEATUIRED
if ($bus_id == 2706 || $bus_id == 2709 || $bus_id == 2666 || $bus_id == 5959 || $bus_id == 9120 || $bus_id == 4404 || $bus_id == 4608) {
    ?>

    <!--<div class="control-group">
        <label class="control-label" for="featured">Is the Car Featured</label>

        <div class="controls">
            <div class="btn-group" data-toggle="buttons-radio">
                <button type="button" onclick="javascript:toggleextra('Y', 'featured');"
                        class="btn btn-inverse <?php /*if ($existing['featured'] == 'Y') {
                            echo 'active';
                        }*/?>">Yes
                </button>
                <button type="button" onclick="javascript:toggleextra('N', 'featured');"
                        class="btn btn-inverse <?php /*if ($existing['featured'] == 'N') {
                            echo 'active';
                        }*/?>">No
                </button>

            </div>
            <input type="hidden" name="featured" id="toggle_featured" value="<?php /*if ($existing['featured'] == '0') {
                echo 'N';
            } else {
                echo $existing['featured'];
            }*/?>"/>
            <span class="help-block" style="font-size:11px">Should the vehicle be displayed as a featured car?</span>

        </div>
    </div>-->

<?php } ?>

<?php //TEST IF AUTOHAUS - SHOW SPECIFICS

if ($bus_id == 2666) {
    ?>


    <div class="control-group">
        <label class="control-label" for="autohaus">Autohaus Windhoek</label>

        <div class="controls">
            <select name="autohaus[]" data-placeholder="Please Select" class="extra_slect span12" multiple="" size="6">

                <option
                    value="Mastercars" <?php test_extras($existing['extras'], 'Mastercars', $product_id, 'selected');?>>
                    Mastercars
                </option>
                <option
                    value="Audi Pre-owned" <?php test_extras($existing['extras'], 'Audi Pre-owned', $product_id, 'selected');?>>
                    Audi Pre-owned
                </option>
                <option value="Used" <?php test_extras($existing['extras'], 'Used', $product_id, 'selected');?>>Used
                </option>
                <option
                    value="Factory Warranty" <?php test_extras($existing['extras'], 'Factory Warranty', $product_id, 'selected');?>>
                    Factory Warranty
                </option>
                <option
                    value="Service Plan" <?php test_extras($existing['extras'], 'Service Plan', $product_id, 'selected');?>>
                    Service Plan
                </option>
                <option
                    value="Motor Plan" <?php test_extras($existing['extras'], 'Motor Plan', $product_id, 'selected');?>>
                    Motor Plan
                </option>
                <option value="Motorite" <?php test_extras($existing['extras'], 'Motorite', $product_id, 'selected');?>>
                    Motorite
                </option>
                <option
                    value="Optimum Warranty" <?php test_extras($existing['extras'], 'Optimum Warranty', $product_id, 'selected');?>>
                    Optimum Warranty
                </option>
                <option
                    value="Remainder of Service Plan" <?php test_extras($existing['extras'], 'Remainder of Service Plan', $product_id, 'selected');?>>
                    Remainder of Service Plan
                </option>
                <option
                    value="Remainder of Motor Plan" <?php test_extras($existing['extras'], 'Remainder of Motor Plan', $product_id, 'selected');?>>
                    Remainder of Motor Plan
                </option>
                <option
                    value="3-Year 120 000km Warranty" <?php test_extras($existing['extras'], '3-Year 120 000km Warranty', $product_id, 'selected');?>>
                    3-Year 120 000km Warranty
                </option>
                <option
                    value="12 Year Anti-Corrosion Warranty" <?php test_extras($existing['extras'], '12 Year Anti-Corrosion Warranty', $product_id, 'selected');?>>
                    12 Year Anti-Corrosion Warranty
                </option>
                <option
                    value="15 000 Service Intervals" <?php test_extras($existing['extras'], '15 000 Service Intervals', $product_id, 'selected');?>>
                    15 000 Service Intervals
                </option>
                <option
                    value="5-Year 100 000km AutoMotion Maintenance Plan" <?php test_extras($existing['extras'], '5-Year 100 000km AutoMotion Maintenance Plan', $product_id, 'selected');?>>
                    5-Year 100 000km AutoMotion Maintenance Plan
                </option>
                <option
                    value="3-Year 90 000km AutoMotion Maintenance Plan" <?php test_extras($existing['extras'], '3-Year 90 000km AutoMotion Maintenance Plan', $product_id, 'selected');?>>
                    3-Year 90 000km AutoMotion Maintenance Plan
                </option>
            </select>
                                                    
                                                    <span class="help-block" style="font-size:11px">
                                                   Please select specific Autohaus Windhoek features</span>

        </div>
    </div>

<?php
}

?>

<?php //TEST IF M+Z MOTORS - SHOW SPECIFICS

if ($bus_id == 2706 || $bus_id == 2709 || $bus_id == 4274 || $bus_id == 9333) {
    ?>


    <div class="control-group">
        <label class="control-label" for="mz_motors ">M+Z Motors</label>

        <div class="controls">
            <select name="mz_motors[]" data-placeholder="Please Select" class="extra_slect span12" multiple="" size="6">

                <option
                    value="Certified_pre_owned" <?php test_extras($existing['extras'], 'Certified_pre_owned', $product_id, 'selected');?>>
                    Certfified Pre-Owned
                </option>
                <!--<option
                    value="Commercial" <?php /*test_extras($existing['extras'], 'Commercial', $product_id, 'selected');*/?>>
                    Commercial Vehicle
                </option>-->
                <option
                    value="Pre_owned" <?php test_extras($existing['extras'], 'Pre_owned', $product_id, 'selected');?>>
                    Pre-Owned
                </option>
                <option
                    value="New_demo" <?php test_extras($existing['extras'], 'New_demo', $product_id, 'selected');?>>
                    New / Demo
                </option>
            </select>
                                                    
            <span class="help-block" style="font-size:11px">
           Please select specific M+Z features</span>

        </div>
    </div>

<?php
}

?>

<?php //TEST IF SPES BONA

if ($bus_id == 4608) {
    ?>


    <div class="control-group">
        <label class="control-label" for="spes_bona">Spes Bona</label>

        <div class="controls">
            <select name="spes_bona[]" data-placeholder="Please Select" class="extra_slect span12" multiple="" size="6">

                <option
                    value="Certified_pre_owned" <?php test_extras($existing['extras'], 'Certified_pre_owned', $product_id, 'selected');?>>
                    Certfified Pre-Owned
                </option>
                <option value="Platinum" <?php test_extras($existing['extras'], 'Platinum', $product_id, 'selected');?>>
                    Platinum
                </option>

            </select>
                                                    
                                                    <span class="help-block" style="font-size:11px">
                                                   Please select specific Spes Bona features</span>

        </div>
    </div>

<?php
}




?>


<script type="text/javascript">

    function toggleextra(val, id) {

        var chk = $('#toggle_' + id);
        chk.val(val);


    }
</script>