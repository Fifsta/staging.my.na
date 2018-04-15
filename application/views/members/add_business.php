<?php 

if(isset($TEL_DIAL_CODE)) {

	$TEL_DIAL_CODE = $TEL_DIAL_CODE;

} else {

	$TEL_DIAL_CODE = '264';

}

if(isset($FAX_DIAL_CODE)) {

	$FAX_DIAL_CODE = $FAX_DIAL_CODE;

} else {

	$FAX_DIAL_CODE = '264';

}

if(isset($CEL_DIAL_CODE)) {

	$CEL_DIAL_CODE = $CEL_DIAL_CODE;

} else {

	$CEL_DIAL_CODE = '264';

}

$this->load->view('inc/header'); 

?>

<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
</head>

<body id="top">

<?php $this->load->view('inc/top_bar'); ?>

<nav id="bread">
	<div class="container">
		  <ol class="breadcrumb">
		    <li class="breadcrumb-item"><a href="#">My.na</a></li>
		  </ol>
	</div>
</nav>

<div class="container">
	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-3 col-xl-4 order-md-2 order-sm-1 order-lg-2 order-xl-3" id="sidebar">
			<?php $this->load->view('inc/login'); ?>
			<?php $this->load->view('inc/weather'); ?>
			<?php $this->load->view('inc/adverts'); ?>
		</div>

		<div class="col-sm-8 col-md-8 col-lg-9 col-xl-8 order-md-1 order-sm-2">
			<div class="row">
				<div class="col-md-12">

					<div class="heading">
						<h2 data-icon="fa-newspaper-o">Add a <strong>Business</strong></h2>
						<ul class="options">

						</ul>
					</div>
					<br>

					<form id="business-add" name="business-add" method="post" action="<?php echo site_url('/');?>members/add_business_do" class="form-horizontal">
					<fieldset>

					        <div class="alert alert-secondary">
			                    <button type="button" class="close" data-dismiss="alert">&times;</button>
			                     <strong>Please Note!</strong> Please make sure the business does not already exist by searching through the existing Businesses above
					        </div>

							<div class="form-group">
								<label class="control-label" for="name"><strong>Business Name</strong></label>
								<div class="controls">
								    <input type="text" class="form-control" id="name" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
								</div>
							</div>


							<div class="form-group">
								<label class="control-label" for="email"><strong>Email</strong></label>
								<div class="controls">
									<input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">   
								</div>
							</div>
					          
					         
							<div class="form-group">
								<label for="Telephone"><strong>Telephone</strong></label>
								<div class="form-group input-group">
									<?php echo $this->my_na_model->get_countries($TEL_DIAL_CODE, true, true, $class = '', $id = 'tel_dial_code');?> 
									<input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="tel" name="tel" placeholder="eg: 061231234" maxlength="12" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>">
								</div>
							</div>


							<div class="form-group">
								<label for="Telephone"><strong>Fax</strong></label>
								<div class="form-group input-group">
									<?php echo $this->my_na_model->get_countries($FAX_DIAL_CODE, true, true, $class = '', $id = 'fax_dial_code');?> 
									<input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="fax" name="fax" placeholder="eg: 061231234" maxlength="12" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>">
								</div>
							</div>


							<div class="form-group">
								<label for="Telephone"><strong>Cellphone</strong></label>
								<div class="form-group input-group">
									<?php echo $this->my_na_model->get_countries($CEL_DIAL_CODE, true, true, $class = '', $id = 'cell_dial_code');?> 
									<input class="form-control input-sm" onkeypress="return isNumberKey(event)" type="text" id="cell" name="cell" placeholder="eg: 811234567" maxlength="12" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>">
									
								</div>
								<div style="font-size:11px">Please only give us your complete cellular number without any prefixes or dialling codes.</div>
							</div>


							<div class="form-group">
								<label class="control-label" for="url"><strong>Website</strong></label>
								<div class="controls">
								    <input type="text" id="url" class="form-control" name="url" placeholder="eg: www.example.com.na" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
								</div>
							</div>

					           
							<div class="form-group">
								<label class="control-label" for="pobox"><strong>PO BOX</strong></label>
								<div class="controls">
								    <input type="text" id="pobox" class="form-control" name="pobox" placeholder="eg: 9012 Windhoek" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">
								</div>
							</div>

					          
							<div class="form-group">
								<label class="control-label" for="address">Physical Address</label>
								<div class="controls">
									<input type="text" id="address" class="form-control" name="address" placeholder="eg: 12 Sam Nujoma Drive" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>"/>
								</div>
							</div>


							<div class="form-group">
								<label class="control-label" for="country">Country</label>
								<div class="controls">
								<select onchange="populateRegion(this.value);" id="country" name="country" class="form-control">
								     <option value="0" selected="selected">Select a Country</option>
								     <?php
								     //Get all countries and loop through them
								     //for the select box
								     $countries = $this->members_model->get_countries();
								     if ($countries->num_rows() != 0 ) {
									     foreach($countries->result() as $row){
										     $country1 = $row->COUNTRY_NAME;
										     $code = $row->COUNTRY_CODE;

										     //see if country has been selected

										     if($row->ID == 0){ $x = 'selected="selected"';}else{ $x = '';}
										     ?>

										     <option <?php echo $x;?> value="<?php echo $row->ID ; ?>"><?php echo $country1; ?></option>

									     <?php
									     }//end foreach loop
								     } //end if rows for countries ?>

								 </select>
								 <span class="help-block" style="font-size:11px">Please select the country of residence</span>
								</div>
							</div>

							<div id="region_div">
							<?php echo $this->members_model->populate_city(0,0);?>
							</div>

							<div id="suburb_div">
							<?php echo $this->members_model->populate_suburb(0,0);?>
							</div>

							<textarea id="redactor_content" name="content" style="display:none" ><?php if(isset($BUSINESS_DESCRIPTION)){echo $BUSINESS_DESCRIPTION;}?></textarea>

							<div style="height:20px; clear:both"></div>

							<input type="hidden" name="id" value="<?php echo $this->session->userdata('id');?>">

							<div id="result_msg"></div>

							<button type="submit" class="btn-large btn pull-right btn-dark" name="submit" id="but"><b>Add</b> <img src="<?php echo base_url('/');?>images/icons/my-na-favicon.png" ></button>
					           
					</fieldset> 
					</form>


				</div>	
			</div>
		</div>
	</div>	
</div>
	
<?php $this->load->view('inc/footer');?>	

<script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
<script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>

<script src='<?php echo base_url('/')?>js/jquery.cycle2.min.js' type="text/javascript" language="javascript"></script>

<script type="text/javascript">

	$(document).ready(function(){	

 	$('#redactor_content').redactor({

			  buttons: [
				  'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
				  'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
				  'video', 'table', '|',
				  'alignment', '|', 'horizontalrule'
			  ]
		  });
		  $('[rel=tooltip]').tooltip();



		  $("#country").removeClass("span10");

		  $('#but').click(function (e)
		  {

			  e.preventDefault();

			  var cell = document.getElementById("cell").value;


			  //Validate
			  if (($('#name').val().length == 0))
			  {

				  var x = $('#name');
				  x.focus();
				  x.popover({
					  placement: "top", html: true, trigger: "manual",
					  title: "Business name required", content: "Please provide us with your full business name"
				  });
				  x.popover('show');
				  setTimeout(function ()
				  {
					  x.popover('hide');
				  }, 3000);
				  $('html, body').animate({
					  scrollTop: (x.offset().top - 200)
				  }, 300);

			  } else if ($('#email').val().length == 0)
			  {

				  var x = $('#email');
				  x.focus();
				  x.popover({
					  placement: "top",
					  html: true,
					  trigger: "manual",
					  title: "Business email required",
					  content: "Please provide us with a unique business email address"
				  });
				  x.popover('show');
				  setTimeout(function ()
				  {
					  x.popover('hide');
				  }, 3000);
				  $('html, body').animate({
					  scrollTop: (x.offset().top - 200)
				  }, 300);


			  } else if ($('#address').val().length < 6)
			  {

				  var x = $('#address');
				  x.focus();
				  x.popover({
					  placement: "top", html: true, trigger: "manual",
					  title: "Address required", content: "Where is your business located."
				  });
				  x.popover('show');
				  setTimeout(function ()
				  {
					  x.popover('hide');
				  }, 3000);
				  $('html, body').animate({
					  scrollTop: (x.offset().top - 200)
				  }, 300);

			  } else
			  {

				  //var frm = $('#business-add');
				  //frm.submit();
				  submit_form();

			  }
		  });

	});

	function submit_form(){
			
			var frm = $('#business-add');
			//frm.submit();
			$('#but').html('<img src="<?php echo base_url('/').'images/load.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				url: '<?php echo site_url('/').'members/add_business_do_ajax';?>' ,
				data: frm.serialize(),
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#but').html('<b>Add</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" />');
					
				}
			});	

	}

	function redirectbusiness(id,msg){
		
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Redirecting...');
		
		setTimeout(function() {
		  window.location.href = "<?php echo site_url('/');?>members/business/"+id+"/"+msg;
		}, 2000);
	
	}


	function checkCellphoneValidity()
		{
			var str1 = $('#cell').val();
			var str2 = str1.split(' ').join('');
			var cellNum = str2.substring(0, 3);
			//alert(cellphoneNumber.substring(0, 3));
			switch(cellNum)
			{
			case '081':
			  
			  return false;
			  break;
			case '085':
			 
			  return false;
			  break;
			case '060':
			  
			  return false;
			  break;
			default:
			  return true;
			}
			
		}


	function populateRegion(countryID)
	{

		if(countryID == 151){
			$("#region_div").html('<div class="control-group"><div class="span10" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Cities...</div></div>');
		}
		$.ajax({
			url: "<?php echo site_url('/');?>members/populate_city/"+countryID+"/0/",
			success: function(data) {
				$("#region_div").html(data);
				$("#city").removeClass("span8");
			}
		});
	}

	function populateSuburb(cityID)
	{
		$("#suburb_div").html('<div class="control-group"><div class="span10" style="text-align:center;"><img src="<?php echo base_url('/').'img/load.gif';?>" /> Getting Suburbs...</div></div>');
		$.ajax({
			url: "<?php echo site_url('/');?>members/populate_suburb/"+cityID+"/0",
			success: function(data) {
				$("#suburb_div").html(data);
				$("#suburb").removeClass("span8");
			}
		});
	}


</script>


</body>
</html>