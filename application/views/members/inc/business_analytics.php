<?php 
 //+++++++++++++++++
 //My.Na Business Analytics
 //+++++++++++++++++
 //Roland Ihms
 
 $impJAN = $this->members_model->get_business_impressions($bus_id,$period, '01');
 $impFEB = $this->members_model->get_business_impressions($bus_id,$period, '02');
 $impMAR = $this->members_model->get_business_impressions($bus_id,$period, '03');
 $impAPR = $this->members_model->get_business_impressions($bus_id,$period, '04');
 $impMAY = $this->members_model->get_business_impressions($bus_id,$period, '05');
 $impJUN = $this->members_model->get_business_impressions($bus_id,$period, '06');
 $impJUL = $this->members_model->get_business_impressions($bus_id,$period, '07');
 $impAUG = $this->members_model->get_business_impressions($bus_id,$period, '08');
 $impSEP = $this->members_model->get_business_impressions($bus_id,$period, '09');
 $impOCT = $this->members_model->get_business_impressions($bus_id,$period, '10');
 $impNOV = $this->members_model->get_business_impressions($bus_id,$period, '11');
 $impDEC = $this->members_model->get_business_impressions($bus_id,$period, '12');
 
 $clickJAN = $this->members_model->get_business_clicks($bus_id,$period, '1');
 $clickFEB = $this->members_model->get_business_clicks($bus_id,$period, '2');
 $clickMAR = $this->members_model->get_business_clicks($bus_id,$period, '3');
 $clickAPR = $this->members_model->get_business_clicks($bus_id,$period, '4');
 $clickMAY = $this->members_model->get_business_clicks($bus_id,$period, '5');
 $clickJUN = $this->members_model->get_business_clicks($bus_id,$period, '6');
 $clickJUL = $this->members_model->get_business_clicks($bus_id,$period, '7');
 $clickAUG = $this->members_model->get_business_clicks($bus_id,$period, '8');
 $clickSEP = $this->members_model->get_business_clicks($bus_id,$period, '9');
 $clickOCT = $this->members_model->get_business_clicks($bus_id,$period, '10');
 $clickNOV = $this->members_model->get_business_clicks($bus_id,$period, '11');
 $clickDEC = $this->members_model->get_business_clicks($bus_id,$period, '12');
 
 $enqJAN = $this->members_model->get_business_enquiries($bus_id,$period, '1');
 $enqFEB = $this->members_model->get_business_enquiries($bus_id,$period, '2');
 $enqMAR = $this->members_model->get_business_enquiries($bus_id,$period, '3');
 $enqAPR = $this->members_model->get_business_enquiries($bus_id,$period, '4');
 $enqMAY = $this->members_model->get_business_enquiries($bus_id,$period, '5');
 $enqJUN = $this->members_model->get_business_enquiries($bus_id,$period, '6');
 $enqJUL = $this->members_model->get_business_enquiries($bus_id,$period, '7');
 $enqAUG = $this->members_model->get_business_enquiries($bus_id,$period, '8');
 $enqSEP = $this->members_model->get_business_enquiries($bus_id,$period, '9');
 $enqOCT = $this->members_model->get_business_enquiries($bus_id,$period, '10');
 $enqNOV = $this->members_model->get_business_enquiries($bus_id,$period, '11');
 $enqDEC = $this->members_model->get_business_enquiries($bus_id,$period, '12');
?>
<style type="text/css">

.demo-container {
	box-sizing: border-box;
	width:94%;
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
						data: [['Jan', <?php echo $impJAN;?>], ['Feb',<?php echo $impFEB;?>], ['Mar', <?php echo $impMAR;?>], ['Apr', <?php echo $impAPR;?>], ['May', <?php echo $impMAY;?>], ['Jun', <?php echo $impJUN;?>], ['Jul',<?php echo $impJUL;?>], ['Aug', <?php echo $impAUG;?>], ['Sep', <?php echo $impSEP;?>], ['Oct', <?php echo $impOCT;?>], ['Nov', <?php echo $impNOV;?>], ['Dec', <?php echo $impDEC;?>]], lines: { show: true, fill:false ,lineWidth: 3}
					},        
					"click": {
						label: "Clicks",
						data: [['Jan', <?php echo $clickJAN;?>], ['Feb',<?php echo $clickFEB;?>], ['Mar',<?php echo $clickMAR;?>], ['Apr', <?php echo $clickAPR;?>], ['May', <?php echo $clickMAY;?>], ['Jun', <?php echo $clickJUN;?>], ['Jul', <?php echo $clickJUL;?>], ['Aug', <?php echo $clickAUG;?>], ['Sep', <?php echo $clickSEP;?>], ['Oct', <?php echo $clickOCT;?>], ['Nov', <?php echo $clickNOV;?>], ['Dec',<?php echo $clickDEC;?>]], lines: { show: true, fill:false ,lineWidth: 3}
					},
					"enq": {
						label: "Enquiries",
						data: [['Jan', <?php echo $enqJAN;?>], ['Feb',<?php echo $enqFEB;?>], ['Mar',<?php echo $enqMAR;?>], ['Apr',<?php echo $enqAPR;?>], ['May', <?php echo $enqMAY;?>], ['Jun', <?php echo $enqJUN;?>], ['Jul',<?php echo $enqJUL;?>], ['Aug', <?php echo $enqAUG;?>], ['Sep',<?php echo $enqSEP;?>], ['Oct', <?php echo $enqOCT;?>], ['Nov', <?php echo $enqNOV;?>], ['Dec', <?php echo $enqDEC;?>]], lines: { show: true, fill:false ,lineWidth: 3}
					}
				};
		
		var xAxisLabels = [ "January", "February", "March", "April", "May" ,"June", "July", "August", "September", "October", "November", "December" ];
		
		
		
		
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
	<?php    
	$imp_total = $impJAN + $impFEB+ $impMAR + $impAPR + $impMAY + $impJUN + $impJUL + $impAUG + $impSEP + $impOCT + $impNOV + $impDEC;
	$click_total = $clickJAN + $clickFEB+ $clickMAR + $clickAPR + $clickMAY + $clickJUN + $clickJUL + $clickAUG + $clickSEP + $clickOCT + $clickNOV + $clickDEC;
	$CTR = ( $click_total / $imp_total) * 100;


	echo $imp_total.'<br>';
	echo $click_total;

	?>

    <table class="table table-striped">
        <thead>
                <tr>
                  <th></th>
                  <th>Click Through Rate(CTR) %</th>
                  <th>Telephone Clicks</th>
                  <th>Cellphone Clicks</th>
                  <th>Fax Clicks</th>
                  <th>Website Clicks</th>
                </tr>
         </thead>
         <tbody>
                <tr>
                  <td></td>
                  <td><?php echo round($CTR, 2);?>%</td>
                  <?php $this->members_model->get_total_clicks($bus_id);?>
				  <td>Coming Soon</td>
                </tr>        
         </tbody> 
    </table>
    <div class="clearfix" style="height:30px;"></div>
    <div class="btn-group" data-toggle="buttons-checkbox">
      <button type="button" id="imp_click" onclick="javascript:togglecheck('imp');" class="btn active">Impressions</button>
      <button type="button" id="click_click" onclick="javascript:togglecheck('click');" class="btn active">Clicks</button>
      <button type="button" id="enq_click" onclick="javascript:togglecheck('enq');" class="btn active">Enquiries</button>
    </div>
    <a class="btn pull-right" onClick="load_analytics_30(<?php echo $bus_id;?>)">Last 15 days</a>
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
 <script type="text/javascript">  
   $('.carousel').carousel({
  		interval: 10000
	})
</script>

