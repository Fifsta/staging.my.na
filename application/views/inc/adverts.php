<div class="spacer"></div>
<div class="adverts hidden-sm-down" id="advert-box">
	
<div class="row" style="margin-bottom:40px">
    <div class="col-md-12">
		<a href="https://survey.my.na/999/survey/10" target="_blank"><img class="lazy" style="width:100%" alt="Customer Feedback Survey" src="<?php echo base_url('/'); ?>images/adverts/survey_advert.jpg" /></a>
    </div>
</div>	

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