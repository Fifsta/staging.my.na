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
<form id="search-main_b" name="search-main-b" method="post" action="<?php echo site_url('/');?>a/results/" class="form-horizontal">
    <fieldset>
        <div class="row-fluid">
            <div class="span4">
                <input type="hidden" name="sortby" id="sortby" value="<?php if(isset($sortby)){ echo $sortby;}else{ echo '';}?>" />

                <select name="srch_category" class="span12">
                    <?php
					if($c_type == 'main'){  
						echo $this->search_model->get_categories_select($c_type, 0,$main_c_id);
					}else{
						
						echo $this->search_model->get_categories_select($c_type, 0,$c_id);
					}
					?>
                </select>
                <span class="help-block" >&nbsp;<i class="icon-question-sign icon-white" rel="tooltip" title="Select What sort of business you are looking for eg: Accommodation, Electrician"></i></span>

            </div>
            <div class="span4">
                <div>
                    <select name="srch_location" class="span12">
                        <?php echo  $this->search_model->get_cities_select($l_id);?>
                    </select>
                </div>

                <span class="help-block" >&nbsp;<i class="icon-question-sign icon-white" rel="tooltip" title="Select where in Namibia you are looking for eg: Windhoek, Swakopmund"></i></span>

            </div>
            <div class="span4">

                <input class="span12" name="srch_business" id="srch_business" style="padding:15px;" type="text" value="<?php if(isset($busM)){ echo $busM;}else{ echo '';}?>" autocomplete="off" placeholder="Business Name? eg: My Namibia">

                <span class="help-block" >&nbsp;<i class="icon-question-sign icon-white" rel="tooltip" title="If you are looking for a particular business starte typing the name"></i></span>

            </div>

        </div>
        <div class="row-fluid">
            <div class="span12">
                <button type="submit" id="btn_find_b" class="btn btn-inverse pull-right "><i class="icon-search icon-white"></i> Search</button>

            </div>
        </div>
    </fieldset>
</form>
<div id="typehead_diva"></div>

<script type="text/javascript">

    $(document).ready(function() {

        $.getScript('<?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
            $('input').placeholder();

        });


        var business = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
/*            datumTokenizer: function (d) {
                return d.tokens;
            },*/
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


        });

        $('select').select2({
            placeholder: "Please Select",
            allowClear: true,
            width: "95%"

        });

    });



</script>