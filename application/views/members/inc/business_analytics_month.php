<?php 
 //+++++++++++++++++
 //My.Na Business Analytics
 //+++++++++++++++++
 //Roland Ihms
 
//$imp = $this->members_model->get_business_impressions_30($bus_id);

 //$clickJAN = $this->members_model->get_business_clicks($bus_id,$period, '1');
 
 //$enqJAN = $this->members_model->get_business_enquiries($bus_id,$period, '1');

?>
<style type="text/css">

.demo-container {
	box-sizing: border-box;
	width:100%;
	height: 450px;
	padding: 20px 15px 15px 15px;
	margin: 15px auto 30px auto;
	border: 1px solid #ddd;
	background: #fff;
	background: linear-gradient(#f6f6f6 0, #fff 50px);
	background: -o-linear-gradient(#f6f6f6 0, #fff 50px);
	background: -ms-linear-gradient(#f6f6f6 0, #fff 50px);
	background: -moz-linear-gradient(#f6f6f6 0, #fff 50px);
	background: -webkit-linear-gradient(#f6f6f6 0, #fff 50px);
	box-shadow: 0 3px 10px rgba(0,0,0,0.15);
	-o-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	-ms-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	-moz-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
	-webkit-box-shadow: 0 3px 10px rgba(0,0,0,0.1);
}

.demo-placeholder {
	width: 100%;
	height: 100%;
	font-size: 14px;
	line-height: 14px;
}

.legend table {
	border-spacing: 5px;
}


</style>



<?php if ($this->input->get('embedded')){
?>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/');?>css/skin1-front.css?v5">
	<script src="<?php echo base_url('/');?>js/bootstrap.min.js?v=1"></script>
<?php 	
}
?>
<script data-cfasync="false" type="text/javascript" src="<?php echo base_url('/');?>js/jquery.flot.js"></script>
<script data-cfasync="false" type="text/javascript" src="<?php echo base_url('/');?>js/jquery.flot.categories.js"></script>
<script data-cfasync="false" type="text/javascript">

	
		var datasets = {
					"imp": {
						label: "Impressions",
						<?php echo $this->members_model->get_business_impressions_30($bus_id);?> , lines: { show: true, fill:false ,lineWidth: 3}
					},
					"click":{
						label: "Clicks",
						<?php echo $this->members_model->get_business_clicks_30($bus_id);?> , lines: { show: true, fill:false ,lineWidth: 3}
					},
					"enq":{
						label: "Enquiries",
						<?php echo $this->members_model->get_business_enquiries_30($bus_id);?> , lines: { show: true, fill:false ,lineWidth: 3}
					}
				};
		
		<?php echo $this->members_model->get_business_xaxis_30($bus_id);?>
		
		
		
		
		
		var i = 0;
		$.each(datasets, function(key, val) {
			val.color = i;
			++i;
		});

		// insert checkboxes 
		var choiceContainer = $("#choices");
		
		choiceContainer.find("input").click(plotAccordingToChoices);

		function plotAccordingToChoices() {

				var data = [];
	
				choiceContainer.find("input:checked").each(function () {
					var key = $(this).attr("name");
					if (key && datasets[key]) {
						data.push(datasets[key]);
					}
				});
	
				if (data.length > 0) {
					$.plot("#placeholder", data, {
						series: {
					
					points: {
						show: true,
						symbol: "circle",
						lineWidth: 5,
					}
					},
					
					grid: {
						hoverable: true,
						clickable: true,
						autoHighlight: true
					},
					colors: [
						'#FF9F01','#FFBF00','#B25900','#DED303'
					],
					legend: {
						show:true,
						position: "ne",
						backgroundOpacity: 0.1
					},
					xaxis: {
						mode: "categories",
						//categories: { "January": 1, "February": 2, "March": 3, "April": 4 ,"May": 5 ,"June": 6, "July": 7, "August": 8, "September": 9, "October": 10, "November": 11, "December": 12 },
					}
						});
					}
			}

		plotAccordingToChoices();

		function showTooltip(x, y, contents) {
			$("<div id='tooltip' class='tooltip'  title='"+contents+"'>" + contents + "</div>").css({
				position: "absolute",
				display: "none",
				top: y + 5,
				left: x + 5,
				border: "1px solid #fdd",
				padding: "4px",
				"background-color": "#000",
				color: "#fff",
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}

		var previousPoint = null;
		$("#placeholder").bind("plothover", function (event, pos, item) {

				if (item) {
					if (previousPoint != item.dataIndex) {

						previousPoint = item.dataIndex;

						$("#tooltip").remove();
						var x = xAxisLabelGenerator(item.datapoint[0]),
						y = item.datapoint[1];

						showTooltip(item.pageX, item.pageY,
						    item.series.label + " for " + x + " = " + y);
					}
			
			   }else{
				   
				   $("#tooltip").remove();
					previousPoint = null;
			   }
		});

		function xAxisLabelGenerator(x)
		{
			return xAxisLabels[x];
		}
	
		function togglecheck(id){
			
			var chk = $('#id'+id);
			chk.attr('checked', !chk.attr('checked'));
			plotAccordingToChoices();
		}
		




	
	
	</script>
	<?php $d = array();
		for($i = 0; $i < 30; $i++){ 
			
			$d[] = date("d-M-Y", strtotime('-'. $i .' days'));
			
			
			//echo $d[$i] .'<br />';	
		
		}
		?>
    <div class="btn-group" data-toggle="buttons-checkbox">
      <button type="button" id="imp_click" onclick="javascript:togglecheck('imp');" class="btn active">Impressions</button>
      <button type="button" id="click_click" onclick="javascript:togglecheck('click');" class="btn active">Clicks</button>
      <button type="button" id="enq_click" onclick="javascript:togglecheck('enq');" class="btn active">Enquiries</button>
    </div>
    <a class="btn pull-right" onClick="load_analytics(<?php echo $bus_id;?>, 'MONTH')">Yearly</a>
    <p id="choices" style="display:none;float:right; width:135px;"><input type="checkbox" name="imp" checked="checked" id="idimp"><input type="checkbox" name="click" checked="checked" id="idclick"><input type="checkbox" name="enq" checked="checked" id="idenq"></p>
    <div class="demo-container">
        <div id="placeholder" class="demo-placeholder"></div>
        
    </div>
 
   <div id="analyticsCarousel" class="carousel slide">
      
      <!-- Carousel items -->
      <div class="carousel-inner">
        <div class="active item">
        	<div class="alert alert-block">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Impressions?</h4>
              sometimes called a view or an ad view, is a term that refers to the point in which an ad is viewed once by a visitor, or displayed once on a web page. The number of impressions of a particular advertisement is determined by the number of times the particular page is located and loaded.
            </div>
        </div>
        <div class="item">
        	<div class="alert alert-block">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Clicks?</h4>
              a click is counted when your business listing page is loaded. A click is only incremented when a unique IP loads the page every hour. This gives you a more accurate estimate of how many times your page has been viewed.
            </div>
        </div>
        <div class="item">
        	<div class="alert alert-block">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <h4>Enquiries?</h4>
              an enquiry is counted when you receive an enquiry via the contact form on your profile page.
            </div>
        
        </div>
      </div>

    </div>
 <script data-cfasync="false" type="text/javascript">
   $('.carousel').carousel({
  		interval: 4000
	})
</script>

