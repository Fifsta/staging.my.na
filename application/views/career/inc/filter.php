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
<form id="search-main_b" name="search-main-b" method="get" action="<?php echo site_url('/');?>careers/results/" class="form-horizontal">
    <fieldset>
        <div class="row-fluid">
            
  
            
            <div class="span4">

                <input class="span12" name="q" id="srch_vacancies" style="padding:15px;" type="text" value="<?php if(isset($busM)){ echo $busM;}else{ echo '';}?>" autocomplete="off" placeholder="Job Keywords? .. Accountant">
				<p>&nbsp;</p>
            </div>
            
			<div class="span4">
                <input type="hidden" name="sortby" id="sortby" value="<?php if(isset($sortby)){ echo $sortby;}else{ echo '';}?>" />

                <select name="sub_cat_id" id="sub_cat_id" class="span12">
                	<option value="all">Any Classification</option>
                    <?php
					echo $this->vacancy_model->get_main_categories_select($sub_cat_id);
					?>
                </select>
                <input type="hidden" id="sub_cat_name" name="sub_cat_name" value="<?php echo $sub_cat_name;?>"/>
              	<p>&nbsp;</p>
            </div>
            
             <div class="span4">
                <div>
                    <select name="location" id="location" class="span12">
                        <?php echo  $this->search_model->get_cities_select($location_id);?>
                    </select>
                    <input type="hidden" id="location_text" name="location_text" value="<?php echo $location;?>"/>
                </div>

				<p>&nbsp;</p>
            </div>
            
        </div>
        <div class="row-fluid">
            <div class="span12 text-right">
            	
                <button type="submit" id="btn_find_b" class="btn btn-inverse"><i class="icon-search icon-white"></i> Find Job</button>

            </div>
        </div>
    </fieldset>
</form>
<div id="typehead_diva"></div>

<script type="text/javascript">

    $(document).ready(function() {

		$('select#sub_cat_id').select2({
            placeholder: "Please Select",
            allowClear: true,
            width: "100%"

        }).on('change',function(e){
			
			var data = $('select#sub_cat_id').select2('data');
			$('#sub_cat_name').val(data.text);
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


        var business = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
/*            datumTokenizer: function (d) {
                return d.tokens;
            },*/
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            //local:statess,
            remote: '<?php echo site_url('/');?>careers/build_typehead/vacancies/?query=%QUERY',
            prefetch :  '<?php echo site_url('/');?>careers/build_typehead/vacancies/'
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
        $('#search-main_b .twitter-typeahead').css("width", "100%");



    });



</script>