<?php

//+++++++++++++++++
//LOAD SEARCH BOX
//+++++++++++++++++
$data['bus_id'] = $bus_id;

if($step == 'step0'){

    if($type == 'auction'){

        $type_str = '&type=auction';

    }elseif($type == 'motor'){
        $type_str = '&type=motor';


    }elseif($type == 'property'){
        $type_str = '&type=property';


    }elseif($type == 'service'){
        $type_str = '&type=service';


    }else{
        $type_str = '&type=general';


    }


}
$next_hide = 'hide';

//TEMP PATCH FOR NMH LISTING CLASSIFIEDS
$qstr = '';
if($this->input->get('nmh_classifieds')){

    $qstr = '&nmh_classifieds=true';
}


// PRIVATE
if($bus_id == 0 && $private == 'yes') {

    echo '<div style="min-height:90px">';
    $next_hide = '';
    $selB = $this->my_na_model->get_businesses($bus_id, $typestr ='', $type = $type_str);
    echo '<div class="row" id="sel_bus_none">
                                            <div class="col-lg-4 col-xs-4">
                                            </div>
                                            <div class="col-lg-4 col-xs-4 text-center">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-default">' . $this->session->userdata('u_name') . '</a>
                                                <a href="javascript:void(0)" onclick="change_select(2)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                                            </div>
                                            <div class="col-lg-4 col-xs-4">
                                            </div>
                                       </div>
                                ';

    echo '<div class="row" style="display:none" id="sel_bus_yes">
                                        <div class="row">
                                            <div class="col-lg-5 col-xs-5 text-right">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-default" onclick="change_select(0)">' . $this->session->userdata('u_name') . '</a>
                                            </div>
                                            <div class="col-lg-2 col-xs-2">
                                                <h1 style="margin-top:20px">OR</h1>
                                            </div>
                                            <div class="col-lg-5 col-xs-5 text-left">
                                                ' . $selB . '
                                            </div>
                                        </div>
                                        <div class="row  help-text">
                                            <div class="col-lg-8 col-xs-8 col-lg-offset-2">
                                                <div class="alert clearfix">
                                                    <h3>List Your Product Privately or Under Business?</h3>
                                                    <p>There are two different ways to list a product. You can list a product privately or under a business you manage.</p>
                                                    <p>Please select if you want to proceed listing a product privately or under a business.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ';

    echo '</div>';
    //BUSINESS OR PRIVATE
}elseif($bus_id == 0){

    echo '<div style="min-height:90px">';

    $selB = $this->my_na_model->get_businesses($bus_id,  $typestr ='', $type = $type_str);
    echo '<div class="row hide" id="sel_bus_none">
                                            <div class="col-lg-4 col-xs-4">
                                            </div>
                                            <div class="col-lg-4 col-xs-4 text-center">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-default">' . $this->session->userdata('u_name') . '</a>
                                                <a href="javascript:void(0)" onclick="change_select(2)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </div>
                                            <div class="col-lg-4 col-xs-4">
                                            </div>
                                       </div>
                                ';

    echo '<div id="sel_bus_yes">
                                        <div class="row">
                                            <div class="col-lg-5 col-xs-5 text-right">

                                                <img src="' . $this->my_na_model->get_user_avatar_str('60', '60') . '" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-default" onclick="change_select(0)">' . $this->session->userdata('u_name') . '</a>
                                            </div>
                                            <div class="col-lg-2 col-xs-2">
                                                <h1 style="margin-top:20px">OR</h1>
                                            </div>
                                            <div class="col-lg-5 col-xs-5 text-left">
                                                ' . $selB . '
                                            </div>
                                        </div>
                                        <div class="row  help-text">
                                            <div class="col-lg-8 col-xs-8 col-xs-offset-2 col-lg-offset-2">
                                                <div class="alert clearfix">
                                                    <h3>List Your Product Privately or Under Business?</h3>
                                                    <p>There are two different ways to list a product. You can list a product privately or under a business you manage.</p>
                                                    <p>Please select if you want to proceed listing a product privately or under a business.</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                ';

    echo '</div>';

    //BUSINESS
}else{

    $next_hide = '';
    echo '<div style="min-height:90px">';

    $selB = $this->my_na_model->get_businesses($bus_id, $typestr ='',  $type = $type_str);
    echo '<div class="row" id="sel_bus_none">
                                            <div class="col-lg-4 col-xs-4">
                                            </div>
                                            <div class="col-lg-4 col-xs-4 text-center">

                                                <img src="'. $this->my_na_model->get_business_logo($bus_id, 60, 60, $logo).'" style="width:60px;height:60px;margin:10px 10px 10px 0px" class="img-polaroid img-circle" />
                                                <a class="btn btn-default">'. $business_name.'</a>
                                                <a href="javascript:void(0)" onclick="change_select(2)"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                                            </div>
                                            <div class="col-lg-4">
                                            </div>
                                       </div>
                                ';

    echo '<div style="display:none" id="sel_bus_yes">
                                        <div class="row">
                                            <div class="col-lg-5 col-xs-5 text-right">


                                                <a class="btn btn-default" href="'.site_url('/').'sell/classifieds/0/?private=true'.$type_str.$qstr.'" >'. $this->session->userdata('u_name').'</a>
                                                <img src="'. $this->my_na_model->get_user_avatar_str('60','60').'" style="width:60px;height:60px;margin:10px 0px 10px 10px" class="img-polaroid img-circle" />
                                            </div>
                                            <div class="col-lg-2 col-xs-2 ">
                                                <h1 style="margin-top:20px">OR</h1>
                                            </div>
                                            <div class="col-lg-5 col-xs-5 text-left">
                                                '. $selB.'
                                            </div>
                                        </div>
                                        <div class="row help-text">
                                            <div class="col-lg-8 col-xs-8 col-xs-offset-2 col-lg-offset-2">
                                                <div class="alert clearfix">
                                                    <h3>List Your Product Privately or Under Business?</h3>
                                                    <p>There are two different ways to list a product. You can list a product privately or under a business you manage.</p>
                                                    <p>Please select if you want to proceed listing a product privately or under a business.</p>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                ';

    echo '</div>';




}

//HEading Box

?>