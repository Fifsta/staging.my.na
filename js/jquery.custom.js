//Tooltip activate
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

//Date range picker
$(function () {
	$('#fromDate').datetimepicker({
		format : 'Do MMM YYYY',
		maxDate: moment("2015-10-23").format('L')
	});
	$('#toDate').datetimepicker({
		useCurrent: false, //Important! See issue #1075
		format : 'Do MMM YYYY',
		maxDate: moment("2015-10-23").format('L')
	});
	$("#fromDate").on("dp.change", function (e) {
		$('#toDate').data("DateTimePicker").minDate(e.date);
	});
	$("#toDate").on("dp.change", function (e) {
		$('#fromDate').data("DateTimePicker").maxDate(e.date);
	});
	$(".datepicker").datetimepicker({
		format: 'DD MMMM YYYY'
	});
	$(".datepicker-birth").datetimepicker({
		format: 'DD MMMM YYYY',
		viewMode: 'years'
	});
});

function swipeHeight(){
	$('.swipe').each(function(){
		var thisFlickity = $(this);
		var swipeHeight = $(this).find('.swipe-item').height();
		thisFlickity.find('.flickity-viewport').height(swipeHeight);
	});
}




$(document).ready(function(){
	
	//ICON APPENDER
	$('*[data-icon]').each(function(){
		var thisIcon = $(this).attr('data-icon');
		$(this).prepend('<i class="fa '+thisIcon+'"></i> ');
	});
	
	//OPTIONS to TABS JUMP IN LISTINGS
	$("#listing .options a[href*=#]").click(function(event){
		var link = $(this).attr('href');
		setTimeout(function() {
			$(link).trigger('click');
		}, 500);
		event.preventDefault();
		var full_url = this.href;
		var parts = full_url.split("#");
		var trgt = parts[1];
		$('.nav-tabs a[href="#'+trgt+'"]').tab('show');
		var target_offset = $("#"+trgt).offset();
		var header_height = $('#header').height();
		var target_top = target_offset.top-header_height-70;
		$('html, body').animate({scrollTop:target_top}, 500);
	});

	// BACK TO TOP
	$("a.jumper[href*=#]").click(function(event){
		var link = $(this).attr('href');
		setTimeout(function() {
			$(link).trigger('click');
		}, 500);
		event.preventDefault();
		var full_url = this.href;
		var parts = full_url.split("#");
		var trgt = parts[1];
		console.log(trgt);
		var target_offset = $("#"+trgt).offset();
		var target_top = target_offset.top;
		$('html, body').animate({scrollTop:target_top}, 500);
	});
	
	//DROP
	$('.main-menu > ul > li').has('ul').find(' > a').append('<i class="fa fa-angle-down"></i>');
	$('.main-menu > ul > li').hover(function() {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).find('> ul').stop(true,true).slideUp(200);
		}else{
			$(this).addClass('active');
			$('.active > ul').slideDown(200);
		}
	});
	
	//REVEAL BUTTON
	$('.reveal button').on('click', function(e) {
		//e.preventDefault();
		$(this).addClass('active');
	});
	
	//MOBILE BAR
	$('#mobile').on('click', function(e) {
		e.preventDefault();
		$('.menu-bar').removeClass('animate');
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.menu-bar').slideUp();
			$('.navigation').removeClass('scroll');
		}else{
			$(this).addClass('active');
			$('.menu-bar').slideDown();
			$('.navigation').addClass('scroll');
		}
	});
	
	//PROFILE TOGGLE
	$('#profile-toggle').on('click', function(e) {
		e.preventDefault();
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('#profile-accordion').slideUp().removeClass('active');
		}else{
			$(this).addClass('active');
			$('#profile-accordion').slideDown().addClass('active');
		}
	});
	
	//MAP TOGGLE
	$('#map-toggle').on('click', function(e) {
		e.preventDefault();
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.map-left').removeClass('active');
			$('.map-right').removeClass('active');
		}else{
			$(this).addClass('active');
			$('.map-left').addClass('active');
			$('.map-right').addClass('active');
		}
	});
	
	//BANNER MAP TOGGLE
	$('#list-map-toggle').on('click', function(e) {
		e.preventDefault();
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$('.list-map-left').removeClass('active');
			$('.list-map-right').removeClass('active');
		}else{
			$(this).addClass('active');
			$('.list-map-left').addClass('active');
			$('.list-map-right').addClass('active');
		}
	});
	
	//EMAIL	
	$('a.email').each(function() {
		var text = $(this).text();
		var address = text.replace(" at ", "@");
		$(this).attr('href', 'mailto:' + address);
		$(this).text(address);
	});
	
	// The "browse to" file inpur fields
	$('input[type=file]').bootstrapFileInput();
	$('.file-inputs').bootstrapFileInput();

	//FANCY BOX
	$(".fancy-images").fancybox({margin: 20, padding: 5});
	$(".fancy-media").fancybox({margin: 20, padding: 0, type: 'iframe', iframe: {preload: false}});
	$(".fancy-print").fancybox({width:150, height: 150, margin: 20, padding: 0, type: 'iframe', iframe: {preload: false}});
	
	
});