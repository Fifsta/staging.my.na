<script src="<?php echo base_url('/');?>js/jquery.simpleWeather-2.1.2.min.js"></script>
<script type="text/javascript">
		$(function() {
			$.simpleWeather({
				zipcode: '',
				woeid: '1466719',
				country: 'Namibia',
				unit: 'c',
				success: function(weather) {
					var temp_c = '', tomo_t = Math.round((parseInt(weather.tomorrow.high) + parseInt(weather.tomorrow.low)) / 2);
					if(weather.temp > 17){
						temp_c = '#f6bf02';
						
					}else{
						temp_c = '#0bbdea';		
					}
					
					html = '<div><img style="margin-top:0px;" src="<?php echo base_url('/').'img/external/timbthumb.php?src=';?>'+weather.image+'&w=210">';
					html += '<h2 style="font-size:65px;margin-left:150px;margin-top:-140px;color:'+temp_c+'">'+weather.high+'&deg;<font style="font-size:12px;">'+weather.units.temp+'</font></h2>';
					html += '<div style=" width:200px; height:30px;text-align:right;margin-right:10px;float:right;">'+weather.currently+'<br /><a class="btn btn-info"> L: </a><a class="btn btn-info">'+weather.low+'&deg;</a>  <a class="btn btn-warning"> H: </a><a class="btn btn-warning">'+weather.high+'&deg;</a></div>';
					
					html += '<img style="position:absolute;width:110px;margin-top:120px" src="<?php echo base_url('/').'img/external/timbthumb.php?src=';?>'+weather.tomorrow.image+'&w=110">';
					html += '<h2 style="font-size:35px;line-height:10px;text-align:right;margin-right:20px;margin-top:120px;color:#ccc">'+tomo_t+'&deg;<font style="font-size:12px">'+weather.units.temp+'</font></h2>';
					html += '<div style=" width:90%; height:30px;text-align:right;margin-right:10px;float:right;">'+weather.tomorrow.forecast+'<br/><a class="btn btn-mini btn-info"> L: </a><a class="btn btn-mini  btn-info">'+weather.tomorrow.low+'</a>  <a class="btn btn-mini btn-warning"> H: </a><a class="btn btn-mini btn-warning">'+weather.tomorrow.high+'</a><br/><font style="text-shadow:none;">Tomorrow</font></div>';
					html += '<h4 style="padding-bottom:20px;">Windhoek</h4>';
					html += '<h4 style="font-size:10px;padding-bottom:5px;text-align:right">'+weather.updated+'</h4>';
					html += '<p style="margin-bottom:30px;"><a target="_blank" href="'+weather.link+'"><img style="float:right;" src="<?php echo base_url('/').'img/icons/yahoo_weather.png';?>"></a></p></div>';
					
					$("#weatherWHK").html(html);
					$(".weather_cont").removeClass('loading_img');
				},
				error: function(error) {
					$("#weatherWHK").html('<p>'+error+'</p>');
				}
			});
		});
	</script>
    <div class="nav-header">My Weather</div>
    <div class="weather_cont loading_img">
    	<div id="weatherWHK"></div>
    </div>
