

var _throttleTimer = 10;
var _throttleDelay = 1500;
var _scroll_news = 0;
var _scroll_feed = 0;
var home_feed = true;
//var base = 'https://www.my.na/';
var base = '';



//load products
$(document).on('click', '.load-products', function(e) {



}); 





//Update Business Details
$(document).on('click', '.details-update', function(e) {

	$('#details-progress').show();

    $.ajax({
        type: "POST",
        url: base+'members/business_update_do_ajax/',
        cache: false,
        data: $('#business-update').serialize(),
        success: function (result) {

        	$('#details-progress').hide();
        	$('#details-result').html(result);
           
        },
        error: function (err) {
            
        }
    });

}); 



//Update Business Description
$(document).on('click', '.desc-update', function(e) {

	$('#desc-progress').show();

    $.ajax({
        type: "POST",
        url: base+'members/business_desc_update_do_ajax/',
        cache: false,
        data: $('#bus-desc-update').serialize(),
        success: function (result) {

        	$('#desc-progress').hide();
        	$('#desc-result').html(result);
           
        },
        error: function (err) {
            
        }
    });

}); 


//Remove Business User
$(document).on('click', '.usr-remove', function(e) {

	var id = $(this).attr("data-id");
	var bus_id = $(this).attr("data-bus");

	$("#modal-user-delete").appendTo("body").bind("show", function() {}).modal({ backdrop: true });

	$('.btn-rmv').attr('data-id', id);
	$('.btn-rmv').attr('data-bus', bus_id);


});

$(document).on('click', '.btn-rmv', function(e) {

	var id = $(this).attr("data-id");
	var bus_id = $(this).attr("data-bus");

	$.ajax({
		type: "POST",
		url: base+"members/delete_user_business/",
	    data: { 
	        'user_id': id, 
	        'bus_id': bus_id
	    },		
		success: function (data) {

			 $("#modal-user-delete").modal("hide");
			 $('#usr-row-'+id).remove();
		}
	});	

}); 



function site_wizard(){
		
		$.getScript(base_+"js/bootstrap-tour.js", function(data, textStatus, jqxhr) {
			
			setTimeout(load_whizz, 100);
			
		});	
	    //console.log('run_whizz');
}


function load_whizz(){
	
	$.ajax({
		type: 'get',
		cache: false,
		dataType: "script",
		url: base_+'js/site-wizard/home_member.js' ,
		success: function (data) {

		}
	});	
	
	
}


//LOAD TRADE
function load_trade(str, bus_id, section){
   
    home_feed = false;
	var n =$('#admin_content');
	n.empty().addClass('loading_img');		  
	$.ajax({
			type: 'get',
			cache: false,
			url: base+'trade/'+str+'/'+bus_id+"/"+section ,
			success: function (data) {
				n.removeClass('loading_img');	
				n.html(data);	
					
			}
		});	 	 
 }



//CLAIM A BUSINESS
function claim_a_business(){
	
	$('#modal-claim').unbind('show').bind('show', function() {
		$.ajax({
			type: 'get',
			cache: false,
			url: base+'members/load_claim_business/',
			success: function (data) {	
				
				$('#claim_modal').html(data).removeClass('loading_img');
				
			}
		});	
		
	}).modal({ backdrop: true });
}


//LOAD HOME FEED
function load_home_feed(x){
		
	var cont = $('#admin_content'), loader = $('#feed_loader');
	$('i.id_arr').hide();
	if(x == 0){ 
		cont.empty();
	}
	
	if(home_feed == true){
			loader.addClass('loading_img');
			$.ajax({
				type: 'get',
				cache: false,
				url: base+'members/load_home_feed/'+x ,
				success: function (data) {	
					
					cont.append(data).fadeIn('300');
					loader.removeClass('loading_img');
					_scroll_feed ++;
					//console.log(_scroll_feed);
				}
			});	
	}
}


//LOAD NEWS
function load_news(x, limit, type){
		
	$('i.id_arr').hide();
	var cont = $('#admin_content'), loader = $('#feed_loader');
	if(x == 0){ 
		cont.empty();
	}
	_scroll_news ++;
	if(limit == 6){ 
		_scroll_news ++;
		//console.log(_scroll_news);
	}
	
	$(".nav-collapse>ul.nav>li.active").removeClass("active");
	$("li#news_btn").addClass("active");
	loader.addClass('loading_img');
	$.ajax({
		type: 'get',
		cache: false,
		url: base+'members/load_world_news/'+x+'/'+limit+'/'+type ,
		success: function (data) {	
			
			cont.append(data).fadeIn('300');
			loader.removeClass('loading_img');
			
			//console.log(x);
		}
	});	
}


//LOAD ENTERTAINMENT
function load_entertainment(x, limit, type){
		
	$('i.id_arr').hide();
	var cont = $('#admin_content'), loader = $('#feed_loader');
	if(x == 0){ 
		cont.empty();
	}
	_scroll_news ++;
	if(limit == 6){ 
		_scroll_news ++;
		//console.log(_scroll_news);
	}
	
	$(".nav-collapse>ul.nav>li.active").removeClass("active");
	$("li.entertainment_btn").addClass("active");
	loader.addClass('loading_img');
	$.ajax({
		type: 'get',
		cache: false,
		url: base+'members/load_entertainment/'+x+'/'+limit+'/'+type ,
		success: function (data) {	
			
			cont.append(data).fadeIn('300');
			loader.removeClass('loading_img');
			
			//console.log(x);
		}
	});	
}


//LOAD SKY NEWS
function load_sky_news(x, limit, type){
		
	$('i.id_arr').hide();
	var cont = $('#admin_content'), loader = $('#feed_loader');
	if(x == 0){ 
		cont.empty();
	}
	_scroll_news ++;
	if(limit == 6){ 
		_scroll_news ++;
		//console.log(_scroll_news);
	}
	
	$(".nav-collapse>ul.nav>li.active").removeClass("active");
	$("li#sky_news_btn").addClass("active");
	loader.addClass('loading_img');
	$.ajax({
		type: 'get',
		cache: false,
		url: base+'members/load_sky_sports_news/'+x+'/'+limit+'/'+type ,
		success: function (data) {	
			
			cont.append(data).fadeIn('300');
			loader.removeClass('loading_img');
			
			//console.log(x);
		}
	});	
}



// LOAD DEALS
function load_deals(x, limit, type){
		
	$('i.id_arr').hide();
	var cont = $('#admin_content'), loader = $('#feed_loader');
	if(x == 0){ 
		cont.empty();
	}
	_scroll_news ++;
	if(limit == 6){ 
		_scroll_news ++;
		//console.log(_scroll_news);
	}
	
	$(".nav-collapse>ul.nav>li.active").removeClass("active");
	$(".nav-collapse>ul.nav>li.deals").addClass("active");
	loader.addClass('loading_img');
	$.ajax({
		type: 'get',
		cache: false,
		url: base+'members/load_deals/'+x+'/'+limit+'/'+type ,
		success: function (data) {	
			
			cont.append(data).fadeIn('300');
			loader.removeClass('loading_img');
			
			//console.log(x);
		}
	});	
}


//LOAD AJAX
function load_ajax(str){
		
	var n = $('#admin_content');
	n.empty();
	n.addClass('loading_img');

	if(str == 'msgs'){
		$('.'+str).addClass('active');
		$(".nav-collapse>ul.nav>li.active").removeClass("active");
		load_mail('all');
		home_feed = false;
		
	}else{
		$(".nav-collapse>ul.nav>li.active").removeClass("active");
		$('.'+str).addClass('active');
		$.ajax({
			type: 'get',
			cache: false,
			url: base+'members/load_ajax_'+str+'/' ,
			success: function (data) {	

				n.html(data);
				n.removeClass('loading_img');
			}
		});	
	}
}


//LOAD MESSAGE
function load_msg(id, bus_id, status){
	
	home_feed = false;
	var n =$('#message-block');
	n.addClass('loading_img');

	$.ajax({
		type: "POST",
		url: base+"tna_mail/view_msg/",
		data: { msg_id: id, bus_id: bus_id, status: status },
		success: function(data){

			n.removeClass('loading_img');	
			$(n).html(data);

		}
	});		 
		 
 }
 

//LOAD INBOX 
function load_mail(status){

	var n =$('#inbox-body');
	n.empty().addClass('loading_img');		

	$.ajax({
		type: "POST",
		url: base+"tna_mail/load_mail_member",
		data: { status: status },
		dataType: "json",
		success: function(data){

			n.removeClass('loading_img');
			$(n).html(data.inbox);

		}
	});

}
 
 function load_notification(){
	 
	 $.ajax({
				type: 'get',
				cache: false,
				url: base+'tna_mail/reload_notify_count/',
				success: function (data) {
					$('.notification_msg_count').html(data);	
					
				}
			});
			
		 $.ajax({
				type: 'get',
				cache: false,
				url: base+'tna_mail/reload_notify_count_member/',
				success: function (data) {
					$('.notification_member_msg_count').html(data);	
					
				}
			});	
				 
 }
 
function delete_msg(){
	
	$('#modal-delete').bind('show', function() {

			var removeBtn = $(this).find('.btn-primary');
				
			removeBtn.click(function(e) { 
					
				e.preventDefault();

						var postdata = $("input[type=checkbox]").serialize();
						$.ajax({
							type: 'post',
							url: base+'tna_mail/delete_msg/' ,
							data: postdata,
							success: function (data) {
								 
								 $('#modal-delete').modal('hide');
								 $('#inbox_msg').html(data);
								 load_mail('all');
							}
						});
			});
			
	}).modal({ backdrop: true });	
	
} 

function soon(){
	
	 var x = $(".nav-collapse>ul.nav>li.trade");
		x.focus();
			x.popover({ 
			 placement:"bottom",html: true,trigger: "manual",
			  content:"Sell anything... Coming soon"});
			x.popover('show');
			setTimeout(function() {
				x.popover('hide');
			}, 3000);
			$('html, body').animate({
				 scrollTop: (x.offset().top - 200)
			 }, 300);
		
}

function find_bus(){
	
	 var x = $(".nav-collapse>ul.nav>li.search"), cont = $("#members_search");
	 cont.addClass('loading_img');
	 $.ajax({
			type: 'post',
			url: base+'members/load_search/' ,
			success: function (data) {

				 cont.removeClass('loading_img').html(data);
				 window.scrollTo(0, 0);
				}
		});	
		
}

function initiate_slides(){
	// Cycle plugin
	$('.slides').cycle({
		fx:     'fade',
		speed:   400,
		timeout: 200,
	}).cycle("pause");

	// Pause & play on hover
	$('.slideshow-block').hover(function(){

		$(this).find('.slides').addClass('active').cycle('resume');
		$(this).find('.slides li img').each(function (e) {
			$(this).attr('src', $(this).attr('data-original'));
		});

	}, function(){
		$(this).find('.slides').removeClass('active').cycle('pause');
	});

	//$("input .star").rating();
	$("[rel=tooltip]").tooltip();
	$("img.lazy").lazyload({
		effect : "fadeIn"
	});
	window.setTimeout(initiate_rating, 100);

}

function initiate_rating(){

	$.getScript(base+"js/jquery.rating.pack.js", function(){

		$("input .star").rating();

	});


}

function initiate_pagination(){

	initiate_slides();

}