 <?php 
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = '';
 $header['metaD'] = '';
 $this->load->view('members/inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag
 
 ?>
<link rel="stylesheet" href="<?php echo base_url('/');?>redactor/redactor/redactor.css" />
 
 <style type="text/css">
 

 
 </style>
</head>
<body>

 <?php 
 //+++++++++++++++++
 //LOAD NAVIGATION
 //+++++++++++++++++
 $nav['section'] = 'account';
 $this->load->view('inc/navigation', $nav);
 
   //+++++++++++++++++
   //My.Na Business Details
   //+++++++++++++++++
   //Roland Ihms
   //Get Business Details
 
	?>	
    <!-- END Navigation -->
   <!-- Part 1: Wrap all content here -->
    <div id="wrap">
		<div class="container">
         	<div class="clearfix" style="height:100px;"></div>
		 		<div class="row">
				<?php 
                 //+++++++++++++++++
                 //LOAD HOME SEARCH BOX
                 //+++++++++++++++++
                 
                 $this->load->view('inc/home_search');
                 ?>

         		</div>
       </div>
      <!-- Begin page content -->
      <div class="container white_box padding10">
      
	  <div class="row">
      	
        <div class="span12">
        	
          <h1>Add a Business</h1>  
             <ul class="breadcrumb">
              <li><a href="<?php echo site_url('/');?>members/home/">My Account</a> <span class="divider">/</span></li>
              <li><a href="#">Add a Business</a> <span class="divider">/</span></li>
              <li><?php if($this->session->userdata('u_name')){ echo ucfirst($this->session->userdata('u_name'));}?></li>
            </ul>
        </div>
		      
      </div>
       	
      <div class="row">
      
       <div class="span3">
            <?php 
                 //+++++++++++++++++
                 //LOAD MEMBERS NAVIGATION
                 //+++++++++++++++++
                  $subnav['subsection'] = 'add_business';
				 $this->load->view('members/inc/account_nav', $subnav);
				 //+++++++++++++++++
                 //LOAD MY NA BUTTONS
                 //+++++++++++++++++
				// $this->load->view('members/inc/my_na_buttons');
             ?>
       
       	 
        </div>
      
      
        <div class="span9">
        <section>
         <?php if(isset($error)){ ?>
              <div class="alert alert-error">
               <button type="button" class="close" data-dismiss="alert">×</button>
                  <?php echo $error; ?>
              </div>
              <?php
              }//end error
              if(isset($basicmsg)){ ?>
              <div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert">×</button>
                  <?php echo $basicmsg; ?>
              </div>
              <?php
              }
              ?>	


     
    
    <form id="business-add" name="business-add" method="post" action="<?php echo site_url('/');?>members/add_business_do" class="form-horizontal">
     <fieldset>
        
                 <div class="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                             <h4>Please Note!</h4> Please make sure the business does not already exist by searching through the existing Businesses above
                        </div>
                  <div class="control-group">
                    <label class="control-label" for="name">Business Name</label>
                    <div class="controls">
                            <input type="text" class="span4" id="name" name="name" placeholder="Business Name" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
                    </div>
                  </div>

                  <div class="control-group">
                    <label class="control-label" for="email">Email</label>
                    <div class="controls">
                             <input type="text" class="span4" id="email" name="email" placeholder="Email" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">   
                    </div>
                  </div>
                  
                 
	              <div class="control-group">
	                <label class="control-label" for="tel">Telephone</label>
	                <div class="controls">
		                    <?php echo $this->my_na_model->get_countries($TEL_DIAL_CODE, true, true, $class = 'span2', $id = 'tel_dial_code');?>
	                  		<input  onkeypress="return isNumberKey(event)" type="text" id="tel" class="span2" name="tel" placeholder="eg: 61231234" maxlength="12" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>">
	                </div>
	              </div>
	              
	              <div class="control-group">
	                <label class="control-label" for="fax">Fax</label>
	                <div class="controls">
		                    <?php echo $this->my_na_model->get_countries($FAX_DIAL_CODE, true, true, $class = 'span2', $id = 'fax_dial_code');?>
	                  		<input  onkeypress="return isNumberKey(event)" type="text" id="fax" class="span2" name="fax" placeholder="eg: 61231234" maxlength="12" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>">
	                </div>
	              </div>
	              
	              <div class="popover top" id="cell_err" style="margin:700px 0px 0px 53%">
	                  <div class="arrow"></div>
	                    <h3 class="popover-title">Cellular reqiuired<i class="icon-info-sign" style="float:right"></i></h3>
	                    <div class="popover-content" id="cell_err_msg">
	                      <p>We require your unique cell number to send you periodic updates, specials and announcements</p>
	                 </div>
	              </div>

				 <div class="control-group">
					 <label class="control-label" for="cell">Cellphone</label>
					 <div class="controls">

						 <?php echo $this->my_na_model->get_countries($CEL_DIAL_CODE, true, true, $class = 'span2', $id = 'cell_dial_code');?>
						 <input  onkeypress="return isNumberKey(event)" type="text" id="cell" class="span2"  name="cell" placeholder="eg: 811234567" maxlength="12" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>">

						 <span class="help-block" style="font-size:11px">Please only give us your complete cellular number without<br /> any prefixes or dialling codes.</span>
					 </div>
				 </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="url">Website</label>
                    <div class="controls">
                            <input type="text" id="url" class="span4" name="url" placeholder="eg: www.example.com.na" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
                    </div>
                  </div>
                   
                    <div class="control-group">
                    <label class="control-label" for="pobox">PO BOX</label>
                    <div class="controls">
                            <input type="text" id="pobox" class="span4" name="pobox" placeholder="eg: 9012 Windhoek" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">
                    </div>
                  </div>
                  
                  <div class="control-group">
                    <label class="control-label" for="address">Physical Address</label>
                    <div class="controls">
                        
                            <input type="text" id="address" class="span4" name="address" placeholder="eg: 12 Sam Nujoma Drive" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>"/>
                    </div>
                  </div>

				     <div class="control-group">
					     <label class="control-label" for="country">Country</label>
					     <div class="controls">

						     <select onchange="populateRegion(this.value);" id="country" name="country" class="span10">
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


				     <?php //POPULATE REGION PLACEHOLDER ?>
				     <div id="region_div">
					     <?php echo $this->members_model->populate_city(0,0);?>
				     </div>

				     <?php //POPULATE SUBURB PLACEHOLDER ?>
				     <div id="suburb_div">
					     <?php echo $this->members_model->populate_suburb(0,0);?>
				     </div>

	              <legend>Add Your Business Description</legend>
                   
                  <textarea id="redactor_content" name="content" style="display:none" ><?php if(isset($BUSINESS_DESCRIPTION)){echo $BUSINESS_DESCRIPTION;}?></textarea>
             
                  
                 <div style="height:20px; clear:both"></div>
                  <input type="hidden" name="id" value="<?php echo $this->session->userdata('id');?>">
                  <div id="result_msg"></div>
                  <div style="height:20px; clear:both"></div>
                  <button type="submit" class="btn-large btn pull-right" name="submit" id="but"><b>Add</b> <img src="<?php echo base_url('/');?>img/icons/my-na-favicon.png" ></button>
                   
       </fieldset> 
     </form>

			
         </section> 
        </div>
       
       
       
      </div>
     	
	 </div> 
     <!-- /container - end content --> 
		<div class="clearfix" style="height:40px;"></div>
      
  <?php 
 //+++++++++++++++++
 //LOAD FOOTER
 //+++++++++++++++++
 $footer['foo'] = '';
 $this->load->view('inc/footer', $footer);
 ?>  
 </div><!-- /wrap--> 

    <!-- JAvascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url('/')?>redactor/redactor/redactor.min.js?v=1"></script> 
    <script src="<?php echo base_url('/');?>js/jquery.form.min.js"></script>
     <script type="text/javascript">
	  $(document).ready( function()
	  {


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

				  //}else if($('#tel').val().length < 6){
//
//    	$('#tel').focus();
//		$('#tel_err_msg').html('Your cellular number is less than 10 digits long!');
//		$('#tel_err').slideDown().delay(4000).slideUp();

				  //}else if($('#cell').val().length < 10){
//
//    	$('#cell').focus();
//		$('#cell_err_msg').html('Your cellular number is less than 10 digits long!');
//		$('#cell_err').slideDown().delay(4000).slideUp();

				  //}else if(checkCellphoneValidity()){
//
//    	$('#cell').focus();
//		$('#cell_err_msg').html('Your cellular number does not have a correct prefix. Cellular numbers must begin with a 081/085 or 060!');
//		$('#cell_err').slideDown().delay(4000).slideUp();
//

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
		$('#but').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Working...');
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