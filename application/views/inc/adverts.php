
<div class="adverts hidden-sm-down" id="advert-box">

</div>

<div class="spacer"></div>

<script>

$(document).ready(
	function()
	{

		load_advert();

	}
);

function load_advert(){
		
	$.ajax({
		type: 'post',
		url: '<?php echo site_url('/').'my_na/load_advert/'; ?>' ,
		success: function (data) {
			
			 $('#advert-box').append(data);
			
		}
	});	

}
 
</script>