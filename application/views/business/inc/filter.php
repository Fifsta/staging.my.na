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
    <form id="search-main_b" name="search-main-b" method="post" action="<?php echo site_url('/');?>a/results/" class="input-group input-group-lg" style="margin:5px">
        <div class="btn-group bootstrap-select show-tick input-group-btn form-control"> 
        <input class="form-control" name="srch_business" id="srch_business" type="text" value="" autocomplete="off" placeholder="Keywords">
        </div>
        <div class="btn-group bootstrap-select show-tick input-group-btn form-control">                
            <select name="srch_category" id="srch_category">
                <option value="all">Any Category</option>
                    <?php
                    if($c_type == 'main'){  
                        echo $this->search_model->get_categories_select($c_type, 0,$main_c_id);
                    }else{
                        echo $this->search_model->get_categories_select($c_type, 0,$c_id);
                    }
                    ?>
            </select>
        </div>

         <div class="btn-group bootstrap-select show-tick input-group-btn form-control">                
            <select name="srch_location" id="location">
                <?php echo  $this->search_model->get_cities_select($location_id);?>
            </select>
        </div>                               
        <span class="input-group-btn"><button type="submit" id="btn_find_b" class="btn btn-primary" data-icon="fa-search"> </button></span>
    </form>
</div>

<div id="typehead_diva"></div>
<script type="text/javascript" src="<?php echo base_url('/');?>js/select2.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {

        /*var business = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            //local:statess,
            //remote: '<?php echo site_url('/');?>my_na/build_typehead/business/?query=%QUERY',
            prefetch :  '<?php echo site_url('/');?>my_na/build_typehead/business/'
        });
        business.initialize();
        $('#srch_business').typeahead({
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

        $('#search-main_b .twitter-typeahead').css("width", "100%");
        $('#btn_find_b').live('click', function(){

            $('#btn_find_b').html('<img src="<?php echo base_url('/'). 'img/load.gif';?>"/> Finding...');
            $('#search-main_b').delay(200).submit();


        });*/

        $('select#srch_category').select2({
            placeholder: "Please Select",
            allowClear: true,
            width: "100%"

        }).on('change',function(e){
            
            var data = $('select#srch_category').select2('data');
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

    });



</script>