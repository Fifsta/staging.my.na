<?php
//+++++++++++++++++
//My.Na Navigation
//+++++++++++++++++
//Roland Ihms
?>
<div class="navbar navbar-fixed-top navbar-inverse" id="navbar" role="navigation">

    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a class="brand" href="<?php echo site_url('/'); ?>">
                <div class="logo"></div>
            </a>

            <form class="navbar-form pull-left" id="search-main" name="search-main" method="post"
                  action="<?php echo site_url('/'); ?>my_na/search">
                <input type="hidden" value="<?php if (isset($type)) {
                    echo $type;
                } else {
                    echo 'none';
                } ?>" name="type">
                <input type="hidden" value="<?php if (isset($location)) {
                    echo $location;
                } else {
                    echo 'national';
                } ?>" name="location">
                <input type="hidden" value="<?php if (isset($main_cat_id)) {
                    echo $main_cat_id; 
                } else {
                    echo '0';
                } ?>" id="main_cat_id" name="main_cat_id">
                <input type="hidden" value="<?php if (isset($sub_cat_id)) {
                    echo $sub_cat_id;
                } else {
                    echo '0';
                } ?>" id="sub_cat_id" name="sub_cat_id">


                <input type="text" class="span4 typeahead" name="srch_bar" type="text"
                       value="<?php if (isset($str)) {
                           echo htmlspecialchars($str);
                       } else {
                           echo '';
                       } ?>" autocomplete="off" 
                       placeholder="Search Anything Namibian">
                <button class="btn btn-inverse" type="submit" id="btn_find"><i class="icon-search icon-white"></i> <span
                        class="hidden-phone">Find</span></button>

            </form>
            <div class="nav-collapse collapse main_nav">


            </div>
            <!--/.nav-collapse -->
        </div>
    </div>
</div>
<script src="<?php echo base_url('/'); ?>js/typehead/dist/typeahead.bundle.min.js"></script>
<script src="<?php echo base_url('/'); ?>js/handlebars-1.0.rc.1.min.js"></script>
<script type="text/javascript">

    $(document).ready(function () {
        var wait = 0;
        /*$.getScript('
        <?php echo base_url('/'). 'js/jquery.placeholder.min.js';?>', function(data) {
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
                url: '<?php echo site_url('/');?>my_na/ajax_search_json/?main_cat_id=' + main_cat_id + '&sub_cat_id=' + sub_cat_id + '&query=%QUERY',
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
                suggestion: Handlebars.compile('<a href="{{link1}}"><p><img class="img-polaroid" src="{{image}}" /><span class="bold">{{value}}</span><span class="muted hidden-phone ">{{body}}</span></p>{{link2}}</a>')
            }
        });
        //$('.tt-hint').addClass('form-control');
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
