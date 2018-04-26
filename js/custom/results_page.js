$(document).ready(function(){



	$(document).on('click', '.map-link', function(e) {

			var cat_id = $(this).attr("data-id");

			  var locations = (function () { 

			      var json = null;
			      $.ajax({
			        'async': false,
			        'type': "get",
			        'url': base+"map/results/"+cat_id,
			        'dataType': "json",
			        'success': function (data) {
			          json = data;
			        }
			      });

			    return json;
			  })(); 

			  map = new google.maps.Map(document.getElementById(id), myOptions);

			 setMarkers(map, locations);

	});


	$(document).on('click', '.t-map', function(e) {

	        e.preventDefault();
	        var h = $(window).height();
	        console.log("height:"+h);
	        $('#home_container').slideUp('300');
	        $('#map_container').fadeIn('400');
	        $('#map-top').css("height",h+"px");
	        $('#map_results_div').fadeIn('400');
	        $('#map_results_div').css("height",h+"px").html($('#normal_results_div').html());
	        $('#btn_map_view').addClass('disabled');
	        $('#btn_list_view').removeClass('disabled');
			$('#btn_list_view2').fadeIn();
	        initialise_map("map-top");

	});

	$(document).on('click', '.t-list', function(e) {

	        e.preventDefault();
	        $('#btn_map_view').removeClass('disabled');
	        $('#btn_list_view').addClass('disabled');
	        $('#home_container').slideDown('600');
	        $('#map_container').slideUp('300');
			$(this).hide();

	});



    $('#sort_asc').on('click', function(e){

        $('#sortby').val('ASC');
        var frm = $('#search-main_b');

        frm.serialize();
        frm.submit();


    });
    $('#sort_desc').on('click', function(e){

        $('#sortby').val('DESC');
        var frm = $('#search-main_b');

        frm.serialize();
        frm.submit();


    });
    $('#sort_rate').on('click', function(e){

        $('#sortby').val('');
        var frm = $('#search-main_b');

        frm.serialize();
        frm.submit();


    });


});

 function phone_click(n, id , type){
		
		var num = n.find('font');
		num.slideDown();
		 console.log(n);
		$.ajax({
			type: 'get',
			url: base+'business/add_business_phone_click/'+id+'/'+type ,
			success: function (data) {	
				
			}
		});	

} 
function my_na(id){
		
		var n = $('#'+id);
		var place = 'right';  
		$.ajax({
			type: 'get',
			cache: false,
			url: base+'business/my_na/'+id+'/'+place+'/' ,
			success: function (data) {	
				
				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect(id);
				n.removeClass('loading_img');
			}
		});	
		
}

function my_na_yes(id){
		
		var n = $('#'+id);
		n.find(".my_na").hide();
		n.addClass('loading_img');
		n.popover('destroy');

		var place = 'right'; 
		$.ajax({
			type: 'get',
			cache: false,
			url: base+'business/my_na_click/'+id+'/'+place+'/' ,
			success: function (data) {	
				
				n.html(data);
				$('[rel=tooltip]').tooltip();
				my_na_effect(id);
				n.removeClass('loading_img');
				n.find(".my_na").show();
			}
		});	

}

function my_na_effect(id){
	
		$(function() {
			$("#"+id)
			.find("span")
			.hide()
			.end()
			.hover(function() {
				$(this).find("span").stop(true, true).fadeIn();
				
			}, function(){
				$(this).find("span").stop(true, true).fadeOut();
				
			});
		});	
	
}