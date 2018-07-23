<div class="spacer"></div>

<div class="adverts hidden-sm-down" id="advert-box">

</div>

<div class="spacer"></div>

<?php echo $this->uri->segment(3); ?>

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