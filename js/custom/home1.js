$(document).ready(function(){
	
	$('[rel=tooltip]').tooltip();
	
	
	
	/*$('#pop_cats_bt').bind('click', function(){
		
		$('#pop_cats').slideToggle();
	});

	setTimeout(weather_report,500);
    setTimeout(load_deals,500);
	$('#reload_main').live('click',function(){
	
		$('#pop_cats').html('<div style="text-align:center;padding-top:45%"><img src="'+base+'img/load.gif" /><br /><b>Reloading...</b></div>');
		$.ajax({
				type: 'get',
				url: site+'my_na/reload_main_cats/',
				success: function (data) {
					
					 $('#pop_cats').fadeIn().html(data);

				}
			});	
	});


    $('.inview').bind('inview', function (event, visible) {
        var type = $(this).data('type');
        var tt = $(this).data('display');

        if (visible == true) {
            if(tt == 0){
            }else{

                setTimeout(function(){

                    load_ajax_home(type);
                },500)
                $(this).data('display', 0);

            }

        } else {
            // element has gone out of viewport
        }
    });*/


});

function load_advert(){
		
		$.ajax({
			type: 'get',
			url: site+'my_na/load_advert/' ,
			success: function (data) {
				
				 $('#advert_div').html(data);
				
			}
		});	

}

function load_properties(){
		
	load_ajax_home('properties');

}

function load_auction(){
		
	load_ajax_home('auctions');

}

function load_deals(){
		
	load_ajax_home('deals');

}

function load_news(){

	load_ajax_home('news');

}

function load_slide(){
		
	$.ajax({
			type: 'get',
			url:site+'my_na/load_slide/',
			success: function (data) {
				 var x = $('#scratch_slide');
				 x.html(data);
				 x.removeClass('loading_img');
				
			}
		});
}
function weather_report(){
    var x = $('#weather_rep');
    var dtime = new Date();
    var n = dtime.getHours();
    console.log(dtime + ' ' + n);
    $.ajax({
        type: 'get',
        url:site+'my_na/get_weather_report/'+ n,
        success: function (data) {
            x.html(data);
            x.removeClass('loading_img');

        }
    });
}
function local_links(){
    var x = $('#local_links');
    $.ajax({
        type: 'get',
        url:site+'my_na/get_local_links/',
        success: function (data) {
            x.html(data);
            x.removeClass('loading_img');

        }
    });
}
function locate_me(){


    var x = $('#weather_rep');
    x.addClass('loading_img');
    $.ajax({
        type: 'get',
        url:site+'map/locate_me/',
        success: function (data) {

            x.html(data);
            x.removeClass('loading_img');

        }
    });
}

function load_ajax_home(str){

	$.ajax({
			type: 'get',
			url: site+'my_na/load_'+str+'_home/',
			success: function (data) {
				
				 $('#'+str+'_slide').html(data).removeClass('loading_img');
				 if(str == 'auctions' || str == 'properties'){
				 	alert('auction');
				 }
				
			}
		});	
}



function load_sub_cats(id){
	 
	$('#pop_cats').html('<div style="text-align:center;padding-top:45%"><img src="'+base+'img/load.gif" /><br /><b>Loading...</b></div>');
	$.ajax({
			type: 'get',
			url: site+'my_na/get_sub_cats/'+id ,
			success: function (data) {
				
				 $('#pop_cats').fadeIn().html(data);
				
				
			}
		});	
	
}
