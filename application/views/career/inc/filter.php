<?php
//+++++++++++++++++
//My.Na Home Search
//+++++++++++++++++
//Roland Ihms

//IE placeholder
$IE = 'display:none;margin-top:-30px;z-index:-1';
if($this->agent->browser() == 'Internet Explorer'){

    $IE = 'display:block;margin-top:-30px;';

}
?>

<div id="filter" class="col-sm-12 d-none d-lg-block">
    <form id="search-main_b" name="search-main-b" method="get" action="<?php echo site_url('/');?>careers/results/" class="input-group input-group-lg">
        <div class="btn-group bootstrap-select show-tick input-group-btn form-control"> 
        <input class="form-control" name="q" id="srch_vacancies" type="text" value="<?php if(isset($q)){ echo $q;}else{ echo '';}?>" autocomplete="off" placeholder="Keywords">
        <input type="hidden" name="sortby" id="sortby" value="<?php if(isset($sortby)){ echo $sortby;}else{ echo '';}?>" />
        </div>
        <div class="btn-group bootstrap-select show-tick input-group-btn form-control">                
            <select name="cl_cat_id" id="cl_cat_id">
                <option value="all">Any Classification</option>
                <?php
                 echo $this->vacancy_model->get_main_categories_select($cl_cat_id);
                ?>
            </select>
            <input type="hidden" id="sub_cat_name" name="sub_cat_name" value="<?php echo $sub_cat_name;?>"/>
        </div>

         <div class="btn-group bootstrap-select show-tick input-group-btn form-control">                
            <select name="location" id="location">
                <?php echo  $this->search_model->get_cities_select($location_id);?>
            </select>
            <input type="hidden" id="location_text" name="location_text" value="<?php echo $location;?>"/>
        </div>                               
        <span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search"> </button></span>
    </form>
</div>

<div id="typehead_diva"></div>

<script type="text/javascript">

    $(document).ready(function() {

        $('select#cl_cat_id').select2({
            placeholder: "Please Select",
            allowClear: true,
            width: "100%"

        }).on('change',function(e){
            
            var data = $('select#cl_cat_id').select2('data');
            $('#cat_name').val(data.text);
            //alert(this);
        });
        $('select#location').select2({
            placeholder: "Please Select",
            allowClear: true,
            width: "100%"

        }).on('change',function(e){
            
            var data = $('select#location').select2('data');
            console.log(data.text);
            $('#location_text').val(data.text);
        });



    });



</script>