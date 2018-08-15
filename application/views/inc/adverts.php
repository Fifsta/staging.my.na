<div class="adverts hidden-sm-down" id="advert-box">

</div>

<div class="spacer"></div>

<?php 

if($this->uri->segment(2) == '') {

	$amnt = 8;

} else {

	$amnt = 5;

}

?>
<script type="text/javascript">
    var site = '<?php echo site_url('/');?>';
    var base = '<?php echo base_url('/');?>';
    var _throttleTimer = 0,_throttleDelay = 0;
	var category = "<?php if(isset($categories)){echo $categories;}?>";
	var keywords = "<?php if(isset($keywords)){echo $keywords;}?>";
	var adverts = [];
	var agent = '';
    $(document).ready(function () {
        $('[rel=tooltip]').tooltip();

		/*$('#sub_cat_id').select2().on('change', function(e){
			
			console.log(this.value);
				
		});*/        
		
		
		load_yzx('all', <?php echo $amnt; ?>, 'advert-box');
    });

	function load_yzx(q, l, b){

		$.getJSON( "<?php echo HUB_URL;?>main/get_picsad_hub/"+q+"/"+l+"/?bus_id=0&keywords="+encodeURI(JSON.stringify(keywords))+"&category="+encodeURI(category), function( data ) {

			var adb = $('#'+b), xx = 0;
			for(var i = 0; i < data.length; i++) {

				if(i==0) { var size = 'margin-top:40px'; } else { var size = ''; }

				var obj = data[i];
				adb.append('<div class="row" style="margin-bottom:40px; '+size+'"><div class="col-md-12">'+obj.body+'</div></div>');
				adverts.push(obj);
				agent = obj.user_agent;


			}

			//MOBILE FIX
			/*if(agent == 'mobile'){

				for(var ii = 0; ii < data.length; ii++) {
					var obj = data[ii];

					$('#adholder_'+ii).html(obj.body);

				}

			}*/
			//load_content_ads();
		});


	}

</script>

<script>

/*$(document).ready(
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

}*/
 
</script>