<div class="adverts hidden-sm-down" id="advert-box">
	
		<!--<img alt="Feature Your Listing Online" src="https://www.my.na/img/adverts/featured_listing_banner.png" class="img-fluid">-->

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
			url: '<?php echo site_url('/').'my_na/load_advert/';?>' ,
			success: function (data) {
				
				 $('#advert-box').html(data);
				
			}
		});	

}

</script>	