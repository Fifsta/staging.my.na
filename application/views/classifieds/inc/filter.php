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

<div id="filter" class="col-sm-12">
    <form id="search-main_b" name="search-main-b" method="get" action="<?php echo site_url('/');?>classifieds/results/" class="input-group input-group-lg">
        <div class="btn-group bootstrap-select show-tick input-group-btn form-control"> 
        <input class="form-control" name="q" id="srch_vacancies" type="text" value="<?php if(isset($q)){ echo $q;}else{ echo '';}?>" autocomplete="off" placeholder="Keywords">
        </div>
        <div class="btn-group bootstrap-select show-tick input-group-btn form-control">                
            <select name="cl_cat_id" id="cl_cat_id">
                <option value="all">Any Classification</option>
                <?php
                 echo $this->classifieds_model->get_main_categories_select($cl_cat_id);
                ?>
            </select>
        </div>

         <div class="btn-group bootstrap-select show-tick input-group-btn form-control">                
            <select name="location" id="location">
                <?php echo  $this->search_model->get_cities_select($location_id);?>
            </select>
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
            //alert(this);
        });

        $.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
            $('input').placeholder();

        });


 /*       var business = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php //echo base_url('/');?>cache/typehead.json?v=6',
            //local:statess,
            remote: '<?php //echo site_url('/');?>classifieds/build_typehead/vacancies/?query=%QUERY',
            prefetch :  '<?php //echo site_url('/');?>classifieds/build_typehead/vacancies/'
        });
        business.initialize();
        $('#srch_vacancies').typeahead({
                minLength: 0,
                highlight: true
            }, {
                name: 'business',
                displayKey: 'value',
                source: business.ttAdapter(),
                highlight: true,
                templates: {
                    empty: [
                        '<div class="alert">',
                        'unable to find any businesses',
                        '</div>'
                    ].join('\n'),
                    suggestion: Handlebars.compile('<a href="{{link1}}"><p><img class="img-polaroid" src="{{image}}" /><span class="bold">{{value}}</span><span class="muted hidden-phone ">{{body}}</span></p>{{link2}}</a>')
             }
        });
        $('#search-main_b .twitter-typeahead').css("width", "100%");*/



    });



</script>