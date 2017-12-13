$(document).ready(function(){
	
	$('[rel=tooltip]').tooltip();
	
	$.ajax({
			type: 'get',
			url:site+'my_na/load_slide/',
			success: function (data) {
				 var x = $('#scratch_slide');
				 x.html(data);
				 x.removeClass('loading_img');
				setTimeout(function(){ load_ajax_home('deals')},200);
			}
		});	
	
	$('#pop_cats_bt').bind('click', function(){
		
		$('#pop_cats').slideToggle();
	});
	setTimeout(function(){ load_advert()}, 1200);
	setTimeout(function(){ load_ajax_home('properties_new')}, 3200);
	setTimeout(function(){ load_ajax_home('trade')}, 4200);
	//setTimeout(function(){ load_ajax_home('auction')}, 6200);
	
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
	
	
});

function load_advert(){

		$.ajax({
			type: 'get',
			url: site+'my_na/load_advert/' ,
			success: function (data) {
				
				 $('#advert_big').html(data);
				
			}
		});	

}

function load_ajax_home(str){
	
	var cont = $('#'+str+'_div');
	$.ajax({
			type: 'get',
			url: site+'my_na/load_'+str+'_home/',
			success: function (data) {
				
				 cont.removeClass('loading_img');
				 cont.html(data);

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

