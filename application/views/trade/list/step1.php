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

<div class="spacer"></div>

<div class="heading">
    <h2 data-icon="fa-list">Please Choose a <strong>Product Category</strong></h2>
    <ul class="options">

    </ul>
</div>
<br>

<div class="card">
    <div class="card-body">

        <a href="#" class="btn btn-success btn-large step1" style="margin:5px"> 1 Select Category <i class="fa fa-chevron-right text-light"></i></a> 
        <a href="#" class="btn btn-dark disabled step2" style="margin:5px"> 2 Details <i class="fa fa-chevron-right text-light"></i></a>
        <a href="#" class="btn btn-dark disabled step3" style="margin:5px"> 3 Attach Photos <i class="fa fa-chevron-right text-light"></i></a>
        <a href="#" class="btn btn-dark disabled step4" style="margin:5px"> 4 Extras <i class="fa fa-chevron-right text-light"></i></a>
        <a href="#" class="btn btn-dark disabled step5" style="margin:5px"> 5 Confirm and Publish <i class="fa fa-chevron-right text-light"></i></a>
        <hr>

        <form id="search-cat_b">
            <input type="text" class="form-control typeahead keyboard-normal" id="search_category" name="search_category" type="text"
                   value="<?php if(isset($str)){ echo $str;}else{ echo '';}?>" style="margin-bottom:0px" autocomplete="off"
                   placeholder="Start typing here">
        </form>

        <div id="select_cats" style="min-height:200px;">
            <?php $this->trade_model->load_product_categories($bus_id, $type);?>
        </div>

    </div> 
</div>      

<div class="clearfix" style="height:200px;"></div>

<script data-cfasync="false" type="text/javascript">

	$(document).ready(function(){

        init_keyboard();
		var contM = $('#home_container'), cont = $('#admin_content');
		cont.removeClass('slideLeft').addClass('loading_img');
		contM.removeClass('container-fluid').addClass('container');


        var cats = new Bloodhound({
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            //local:statess,
            //remote: '<?php echo site_url('/');?>my_na/build_typehead/business/?query=%QUERY',
            prefetch :  '<?php echo site_url('/');?>trade/build_typehead/<?php echo $bus_id.'/'.$type;?>',
            limit: 20
        });

        cats.initialize();

        $('#search_category').typeahead({
            minLength: 0,
            highlight: true
        }, {
            name: 'cats',
            displayKey: 'value',
            limit: 20,
            source: cats.ttAdapter(),
            highlight: true,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any category',
                    '</div>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}"><p style="padding:0px 10px"><span class="bold">{{value}}</span><span>{{body}}</span></p></a>')
            }
        });

        $('#search-cat_b .twitter-typeahead').css("width", "100%");
	});

</script>