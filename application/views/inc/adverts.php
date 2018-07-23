<div class="spacer"></div>

<div class="adverts hidden-sm-down" id="advert-box">

</div>

<div class="spacer"></div>

<script>

$(document).ready(
	function()
	{

		load_yzx('all', 4, 'side_block_1');

	}
);

/*function load_advert(){
		
	$.ajax({
		type: 'post',
		url: '<?php echo site_url('/').'my_na/load_advert/'; ?>' ,
		success: function (data) {
			
			 $('#advert-box').append(data);
			
		}
	});	

}*/

	function load_yzx(q, l, b){

		$.getJSON( "<?php echo HUB_URL;?>main/get_adverts/"+q+"/"+l+"/?bus_id=0<?php //echo BUS_ID;?>&keywords="+encodeURI(keywords)+"&category="+encodeURI(category), function( data ) {

			var adb = $('#'+b), xx = 0;
			for(var i = 0; i < data.length; i++) {
				var obj = data[i];
				adb.append(obj.body);
				adverts.push(obj);
				agent = obj.user_agent;
			}

			//MOBILE FIX
			if(agent == 'mobile'){

				for(var ii = 0; ii < data.length; ii++) {
					var obj = data[ii];

					$('#advert-box').append(obj.body);

					//$('#adholder_'+ii).html(obj.body);

				}

			}
			//load_content_ads();
		});


	}


</script>