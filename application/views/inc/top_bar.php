<!--<div id="pre_load">
	<div>
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
	</div>
</div>--> 
<header id="header" class="grad-orange">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-2">
				<div class="slogo">
					<a href="#"><img src="images/logo-main.png"></a>
					<div>find • list • buy • sell</div>
				</div>
			</div>
			<div class="col-sm-8">
			
                <form class="input-group input-group-lg" id="search-main" name="search-main" method="post" action="<?php echo site_url('/'); ?>my_na/search">

                    <input type="text" class="form-control typeahead" name="srch_bar" type="text" value="<?php if (isset($str)) { echo htmlspecialchars($str); } else { echo ''; } ?>" autocomplete="off" placeholder="Search Anything Namibian">

                    <input type="hidden" value="<?php if (isset($type)) { echo $type; echo 'none'; } ?>" name="type">
                    <input type="hidden" value="<?php if (isset($location)) { echo $location; } else { echo 'national'; } ?>" name="location">
                    <input type="hidden" value="<?php if (isset($main_cat_id)) { echo $main_cat_id; } else { echo '0'; } ?>" id="main_cat_id" name="main_cat_id">
                    <input type="hidden" value="<?php if (isset($sub_cat_id)) { echo $sub_cat_id; } else { echo '0'; } ?>" id="sub_cat_id" name="sub_cat_id">

					<!--<div class="near input-group-addon">Near:</div>
					<input type="text" class="near form-control" id="search-main2" placeholder="Windhoek">-->
					<span class="input-group-btn"><button type="submit" class="btn btn-primary" data-icon="fa-search" role="button"></button></span>
    			    

                    
                </form>
				
				<div class="history">Search history: 
                    <a href="<?php echo site_url('/'); ?>buy/car-bikes-and-boats">cars</a>, 
                    <a href="<?php echo site_url('/'); ?>buy/property">properties</a>, 
                    <a href="<?php echo site_url('/'); ?>a/show/all/all/all/none/">businesses</a>, 
                </div>
			</div>
			<div class="col-sm-2 text-right">

			</div>
		</div>
	</div>
</header>

<script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.js"></script>
<script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
<script src="<?php echo base_url('/'); ?>js/custom/fb.js?v=2"></script>

<script type="text/javascript">

    $(document).ready(function () {
        var wait = 0;
        /*$.getScript('
        <?php echo base_url('/'). 'js/jquery.placeholder.min.js'; ?>', function(data) {
         $('input').placeholder();

         });*/

        $('#btn_find').bind('click', function (e) {
            e.preventDefault();
            if ($('.twitter-typeahead').text() != '') {

                $(this).addClass('disabled');
                $('#search-main').submit();
            }

        });

        go_search(<?php if(isset($main_cat_id) && $main_cat_id != 0){ echo $main_cat_id; }else{ echo '0';}?>, <?php if(isset($sub_cat_id) && $sub_cat_id != 0){ echo $sub_cat_id;}else{ echo '0';}?>);

    });
    

    function go_search(main_cat_id, sub_cat_id) {

        var myna = new Bloodhound({
            //datumTokenizer: Bloodhound.tokenizers.obj.whitespace('value'),
            datumTokenizer: function (d) {
                return d.tokens;
            },
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            //prefetch: '<?php echo base_url('/');?>cache/typehead.json?v=6',
            prefetch: '<?php echo site_url('/');?>my_na/typehead/location/',
            //remote: '<?php echo site_url('/');?>my_na/ajax_search_json/<?php if(isset($main_cat_id) && $main_cat_id != 0){ echo '?main_cat_id='.$main_cat_id.'&';}else{ echo '?';}if(isset($sub_cat_id) && $sub_cat_id != 0){ echo 'sub_cat_id='.$sub_cat_id.'&';} ?>query=%QUERY'
            remote: {
                url: '<?php echo site_url('/');?>my_na/ajax_search_json/' + main_cat_id + '/' + sub_cat_id + '/%QUERY',
                wildcard: '%QUERY'
            },
            limit: 10

        });

        myna.initialize();

        $('#search-main input.typeahead').typeahead({
            minLength: 1,
            highlight: true
        }, {
            name: 'my-na',
            displayKey: 'value',
            source: myna.ttAdapter(),
            highlight: true,
            limit: 10,
            templates: {
                empty: [
                    '<div class="alert">',
                    'unable to find any results that match the current query',
                    '</div>'
                ].join('\n'),
                footer: [
                    '<a href="javascript:search_more();" class="btn btn-block white_back" style="border:none">',
                    '<p class="bold text-center"><i class="icon-search"></i> More Results</p>',
                    '</a>'
                ].join('\n'),
                suggestion: Handlebars.compile('<a href="{{link1}}"><p><span class="bold">{{value}}</span></p>{{link2}}</a>')
            }
        });

    }

    function search_more() {

        //var str = $('#search-main input.typeahead').typeahead('val'));
        if ($('.twitter-typeahead').text() != '') {

            //$(this).addClass('disabled');
            $('#search-main').submit();
        }
    }

    function clear_cat(type) {

        if (type == 'main') {
            $('#in_d').hide();
        }
        $('#' + type + '_cat_id').val(0);
        $('#' + type + '_cat_indicator').fadeOut();
        //go_search(0, 0);
    }

    function go_url(url) {

        if (url != '') {
            window.location = url;
        } else {


        }


    }


</script>
