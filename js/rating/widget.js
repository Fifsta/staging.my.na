//My Namibia Rating widget
//by Roland Ihms
//08-2015

if (typeof jQuery == 'undefined' || typeof $ == 'undefined') {

	console.log('no jq');

	(function () {

		function loadScript(url, callback) {

			var script = document.createElement("script")
			script.type = "text/javascript";

			if (script.readyState) { //IE
				script.onreadystatechange = function () {
					if (script.readyState == "loaded" || script.readyState == "complete") {
						script.onreadystatechange = null;
						callback();
					}
				};
			} else { //Others
				script.onload = function () {
					callback();
				};
			}

			script.src = url;
			document.getElementsByTagName("head")[0].appendChild(script);
		}

		loadScript("//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js", function () {

			window.setTimeout(letsgo(), 1000);

		});


	})();

}else{

	window.setTimeout(letsgo(), 1000);

}

var bus_id = 0;
var ext = 'no';
var embed = 'no';
var base_url = 'https://www.my.na/';

function letsgo(){

	$(document).ready(function() {
			//Notice that both possible parameters are pre-defined.
			//Which is probably not required if using proper object notation
			//in query string, or if variable-variables are possible in js.
			var e;
			var id;
			//script gets the src attribute based on ID of page's script element:
			var requestURL = document.getElementById("myna").getAttribute("src");

			//next use substring() to get querystring part of src
			var queryString = requestURL.substring(requestURL.indexOf("?") + 1, requestURL.length);

			//Next split the querystring into array
			var params = queryString.split("&");



			//Next loop through params
			for(var i = 0; i < params.length; i++){
				var name  = params[i].substring(0,params[i].indexOf("="));
				var value = params[i].substring(params[i].indexOf("=") + 1, params[i].length);
				//console.log(value+" " +name);
				if(name == 'bus_id'){
					bus_id = value;
				}

				if(name == 'external' && value == 'true'){
					ext = 'external';

				}
				if(name == 'embed'){
					embed = value;
				}
				//Test if value is a number. If not, wrap value with quotes:
				if(isNaN(parseInt(value))) {
					params[i] = params[i].replace(value, "'" + value + "'");
				}

				// Finally, use eval to set values of pre-defined variables:
				eval(params[i]);
			}
			//console.log(bus_id);
			//Output to test that it worked:
			//document.getElementById("docTitle").innerHTML = e;
			//document.getElementById("docText").innerHTML = id;
			//++++++++++
			//MAGIC
			//+++++++++
			//console.log(bus_id);
			loadme(id,e, bus_id);
			/*var once_per_session=0
			//should be 0
			if (once_per_session==0)

				window.setTimeout((function(){
					console.log(bus_id);
					loadme(id,e, bus_id)}),1000);

			else
			{
				if (get_cookie('popunder')==''){
					loadme(id,e, bus_id)
					document.cookie="popunder=yes"
				}
			}*/

	});



}



/*function get_cookie(Name) {
  var search = Name + "="
  var returnvalue = "";
  if (document.cookie.length > 0) {
    offset = document.cookie.indexOf(search)
    if (offset != -1) { // if cookie exists
      offset += search.length
      // set index of beginning of value
      end = document.cookie.indexOf(";", offset);
      // set index of end of cookie value
      if (end == -1)
         end = document.cookie.length;
      returnvalue=unescape(document.cookie.substring(offset, end))
      }
   }
  return returnvalue;
}

function loadornot(){
	if (get_cookie('popunder')==''){
		window.setTimeout(loadchat(id,e),2000);
		document.cookie="popunder=yes"
	}
}*/

var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth || e.clientWidth || g.clientWidth,
    height = (w.innerHeight|| e.clientHeight|| g.clientHeight) - 40;

function loadme(id,e ,bus_id){
	
	
	
	console.log('wopppeee'+bus_id+" " +height);
	if(bus_id != 0){

		//CSS
		var css = '<style type="text/css">#place_hold_div_my_na{overflow:hidden;z-index:99999;position:fixed; bottom:0; right:20px; width:100%;height:40px;width:180px; max-height:'+height+'px; pdding-bottom:10px;background:transparent;-moz-box-shadow: 0 0 3px #000;-webkit-box-shadow:  0 0 3px #000;box-shadow:   0 0 3px #000; -moz-border-radius:5px 5px 0px 0px; -webkit-border-radius:5px 5px 0px 0px;border-radius:5px 5px 0px 0px; /* future proofing */ -khtml-border-radius:5px 5px 0px 0px; /* for old Konqueror browsers */}</style>';

		var html = '<div id="place_hold_div_my_na" style="overflow:hidden"></div>';

		$('head').append(css);
		$('body').append(html);
        var div = $('#place_hold_div_my_na');
        div.html('<a href="javascript:minimizeme(0);" id="widget_btn_min" class="close" style="position:absolute;float:right;margin:0;width:170px"><img src="https://www.my.na/img/icons/plus.png?v1" id="min_max_icon" style="margin-top:10px;padding:0;"></a><iframe style="display:block;height:'+height+'px;width:100%;overflow:hidden" allowtransparency="true" frameborder="0" src="'+base_url+'rate/rateme/'+bus_id+'/plugin/'+ext+'/show/"></iframe>');

	}

}

function clearme(x){
	x.value = ''; 
 }

function show_reviews(){

	var reviews = $('#plugin_myna_reviews').fadeIn();
	var rating = $('#plugin_myna_rating').fadeOut();
	var container = $('#place_hold_div_my_na').css("height", "360px");
	var minbtn = $('#widget_btn_min');


}

function toggle_widget(str){


	if(str == 'reviews'){

		var rating = $('#plugin_myna_rating').hide();
		var reviews = $('#plugin_myna_reviews').fadeIn();
		var minbtn = $('#widget_toggle_btn').attr("href","javascript:toggle_widget('rating')");

	}else{

		var reviews = $('#plugin_myna_reviews').hide();
		var rating = $('#plugin_myna_rating').fadeIn();
		var minbtn = $('#widget_toggle_btn').attr("href","javascript:toggle_widget('reviews')");

	}


}

function show_rating(){

	var reviews = $('#plugin_myna_reviews').fadeOut();
	var rating = $('#plugin_myna_rating').fadeIn();
	var container = $('#place_hold_div').css("height", height+"px");

}

function minimizeme(str){

	if(str == 'min'){

		var container = $('#place_hold_div_my_na').css({"height":"40px", "width":"180px"});
		var minbtn = $('#widget_btn_min').attr("href","javascript:minimizeme('max');");
        $('#min_max_icon').attr('src', 'https://www.my.na/img/icons/plus.png');
	}else{

		var container = $('#place_hold_div_my_na').css({"height":height+"px", "width":"481px"});
		var minbtn = $('#widget_btn_min').attr("href","javascript:minimizeme('min');");
        $('#min_max_icon').attr('src', 'https://www.my.na/img/icons/minus.png');
	}


}

function maximizeme(){

	var container = $('#place_hold_div_my_na').css("height", "360px");

}
function btn_action(){



	$("#btn_submit").click(function(e) {
		e.preventDefault();
		var frm = $("#login_frm");
		$(this).html("Processing...");
		$.ajax({
			type: "post",
			url: base_url+"rate/login/" ,
			data: frm.serialize(),
			success: function (data) {
				$("#msg").html(data);
				$("#btn_submit").html('<i class="icon-lock icon-white"></i> Sign in');

			}
		});
	});

}



function submit_review(){

    console.log('wohho');
    var frm = $("#reviewfrm");

    $("#reviewbut").html("Processing...");
    $.ajax({
        type: "post",
        url: base_url+"rate/submit_review_ajax/"+bus_id,
        data: frm.serialize(),
        success: function (data) {
            $("#review_msg").html(data);
            $("#reviewbut").html('<i class="icon-comment"></i> Submit Review');
            $("input .star").rating().fadeIn();
        }
    });


}

function pass_update(){

    $('#pass_update').slideToggle();
    window.setTimeout(scroller(), 1000)


}
function scroller(){

    window.scrollTo(0,$('#anchor').offset().top);
}