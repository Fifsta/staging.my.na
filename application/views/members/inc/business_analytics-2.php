<?php 
 //+++++++++++++++++
 //My.Na Business Analytics
 //+++++++++++++++++
 //Roland Ihms
 
 $impJAN = $this->members_model->get_business_impressions($bus_id,'MONTH', '1');
 $impFEB = $this->members_model->get_business_impressions($bus_id,'MONTH', '2');
 $impMAR = $this->members_model->get_business_impressions($bus_id,'MONTH', '3');
 $impAPR = $this->members_model->get_business_impressions($bus_id,'MONTH', '4');
 $impMAY = $this->members_model->get_business_impressions($bus_id,'MONTH', '5');
 $impJUN = $this->members_model->get_business_impressions($bus_id,'MONTH', '6');
 $impJUL = $this->members_model->get_business_impressions($bus_id,'MONTH', '7');
 $impAUG = $this->members_model->get_business_impressions($bus_id,'MONTH', '8');
 $impSEP = $this->members_model->get_business_impressions($bus_id,'MONTH', '9');
 $impOCT = $this->members_model->get_business_impressions($bus_id,'MONTH', '10');
 $impNOV = $this->members_model->get_business_impressions($bus_id,'MONTH', '11');
 $impDEC = $this->members_model->get_business_impressions($bus_id,'MONTH', '12');
 
 $clickJAN = $this->members_model->get_business_clicks($bus_id,'MONTH', '1');
 $clickFEB = $this->members_model->get_business_clicks($bus_id,'MONTH', '2');
 $clickMAR = $this->members_model->get_business_clicks($bus_id,'MONTH', '3');
 $clickAPR = $this->members_model->get_business_clicks($bus_id,'MONTH', '4');
 $clickMAY = $this->members_model->get_business_clicks($bus_id,'MONTH', '5');
 $clickJUN = $this->members_model->get_business_clicks($bus_id,'MONTH', '6');
 $clickJUL = $this->members_model->get_business_clicks($bus_id,'MONTH', '7');
 $clickAUG = $this->members_model->get_business_clicks($bus_id,'MONTH', '8');
 $clickSEP = $this->members_model->get_business_clicks($bus_id,'MONTH', '9');
 $clickOCT = $this->members_model->get_business_clicks($bus_id,'MONTH', '10');
 $clickNOV = $this->members_model->get_business_clicks($bus_id,'MONTH', '11');
 $clickDEC = $this->members_model->get_business_clicks($bus_id,'MONTH', '12');
 
 $enqJAN = $this->members_model->get_business_enquiries($bus_id,'MONTH', '1');
 $enqFEB = $this->members_model->get_business_enquiries($bus_id,'MONTH', '2');
 $enqMAR = $this->members_model->get_business_enquiries($bus_id,'MONTH', '3');
 $enqAPR = $this->members_model->get_business_enquiries($bus_id,'MONTH', '4');
 $enqMAY = $this->members_model->get_business_enquiries($bus_id,'MONTH', '5');
 $enqJUN = $this->members_model->get_business_enquiries($bus_id,'MONTH', '6');
 $enqJUL = $this->members_model->get_business_enquiries($bus_id,'MONTH', '7');
 $enqAUG = $this->members_model->get_business_enquiries($bus_id,'MONTH', '8');
 $enqSEP = $this->members_model->get_business_enquiries($bus_id,'MONTH', '9');
 $enqOCT = $this->members_model->get_business_enquiries($bus_id,'MONTH', '10');
 $enqNOV = $this->members_model->get_business_enquiries($bus_id,'MONTH', '11');
 $enqDEC = $this->members_model->get_business_enquiries($bus_id,'MONTH', '12');
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
<script data-cfasync="false" type="text/javascript" src="<?php echo base_url('/');?>js/jquery.flot.js"></script>
<script data-cfasync="false" type="text/javascript" src="<?php echo base_url('/');?>js/jquery.flot.categories.js"></script>
<script data-cfasync="false" type="text/javascript">



$(function() {

		
		var imp = [['Jan', <?php echo $impJAN;?>], ['Feb',<?php echo $impFEB;?>], ['Mar', <?php echo $impMAR;?>], ['Apr', <?php echo $impAPR;?>], ['May', <?php echo $impMAY;?>], ['Jun', <?php echo $impJUN;?>], ['Jul',<?php echo $impJUL;?>], ['Aug', <?php echo $impAUG;?>], ['Sep', <?php echo $impSEP;?>], ['Oct', <?php echo $impOCT;?>], ['Nov', <?php echo $impNOV;?>], ['Dec', <?php echo $impDEC;?>]];
		
		var clicks =  [['Jan', <?php echo $clickJAN;?>], ['Feb',<?php echo $clickFEB;?>], ['Mar',<?php echo $clickMAR;?>], ['Apr', <?php echo $clickAPR;?>], ['May', <?php echo $clickMAY;?>], ['Jun', <?php echo $clickJUN;?>], ['Jul', <?php echo $clickJUL;?>], ['Aug', <?php echo $clickAUG;?>], ['Sep', <?php echo $clickSEP;?>], ['Oct', <?php echo $clickOCT;?>], ['Nov', <?php echo $clickNOV;?>], ['Dec',<?php echo $clickDEC;?>]];
		
		var enq =  [['Jan', <?php echo $enqJAN;?>], ['Feb',<?php echo $enqFEB;?>], ['Mar',<?php echo $enqMAR;?>], ['Apr',<?php echo $enqAPR;?>], ['May', <?php echo $enqMAY;?>], ['Jun', <?php echo $enqJUN;?>], ['Jul',<?php echo $enqJUL;?>], ['Aug', <?php echo $enqAUG;?>], ['Sep',<?php echo $enqSEP;?>], ['Oct', <?php echo $enqOCT;?>], ['Nov', <?php echo $enqNOV;?>], ['Dec', <?php echo $enqDEC;?>]];
		
		var xAxisLabels = [ "January", "February", "March", "April", "May" ,"June", "July", "August", "September", "October", "November", "December" ];
		
		var plot = $.plot("#placeholder", [
			{ data: imp, label: "Impressions", lines: { show: true, fill:false ,lineWidth: 3}},
			{ data: clicks, label: "Clicks", lines: { show: true, fill:false ,lineWidth: 3}},
			{ data: enq, label: "Enquiries", lines: { show: true, fill:false ,lineWidth: 3}}
		], {
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

		function showTooltip(x, y, contents) {
			$("<div id='tooltip'  title='"+contents+"'>" + contents + "</div>").css({
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
						y = item.datapoint[1].toFixed(2);

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


	});
	</script>
	
    <a onclick="$.plot('#placeholder',{ data: clicks, label: 'Clicks', lines: { show: true, fill:false ,lineWidth: 3}})" class="btn">Test</a> 
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
  		interval: 4000
	})
</script>