<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register - My Nmaibia&trade;">
    <meta name="author" content="My Namibia">
    <link rel="icon" href="<?php echo base_url('/');?>favicon.ico">

    <title>Register - My Namibia&trade;</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url('/');?>bootstrap/css/bootstrap.min.css?v1" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="//getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url('/'); ?>css/flags/flags.css">
 
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
<body>

    <div class="container">
      	  <div class="row">
          		
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1 text-right">
                
               		 <a href="<?php echo site_url('/');?>nmh/register/" class="btn btn-default" style="margin-top:10px;"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                    
                </div>
           </div>  
           <p>&nbsp;</p>   
          <div class="row">
          		
                <div class="col-lg-8 col-md-10 col-sm-12 col-lg-offset-2 col-md-offset-1">

                    <form action="<?php echo site_url('/')?>main/register_do/" method="post" enctype="multipart/form-data" name="register" id="register" class="feedback">
                        <input type="hidden" name="reg_type" value="vacancy">


                        <label><strong class="indent">Membership Type *</strong>
                            <select name="level" id="level">
                                <?php //echo $this->vacancy_model->get_management_select(); ?>
                            </select>
                        </label>

                        <div style="display:none" id="specialist">
                            <label><strong class="indent">Specialist Position</strong>
                                <select name="specialist">
                                    <option value="Medical Doctor">Medical Doctor</option>
                                    <option value="Engineer">Engineer</option>
                                    <option value="Architect">Architect</option>
                                    <option value="Other">Other</option>
                                </select>
                            </label>
                        </div>

                        <div style="display:none" id="other">
                            <label><strong class="indent">Specialist Other</strong>
                                <input type="text" name="other" id="other" placeholder="Enter Specialist Position">
                            </label>
                        </div>

                        <label><strong class="indent">Name *</strong>
                            <input type="text" name="name" id="name" placeholder="Enter Name">
                        </label>

                        <label><strong class="indent">Middle Name</strong>
                            <input type="text" name="middle_name" id="middle_name" placeholder="Enter Middle Name">
                        </label>

                        <label><strong class="indent">Surname *</strong>
                            <input type="text" name="surname" id="surname" placeholder="Enter Surname">
                        </label>

                        <label><strong class="indent">Date of birth *</strong><br>
                            <input type="text" name="dd" id="dd" placeholder="dd" style="width:50px" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="2">
                            <input type="text" name="mm" id="mm" placeholder="mm" style="width:50px" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="2">
                            <input type="text" name="yyyy" id="yyyy" placeholder="yyyy" style="width:68px" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="4">
                        </label>

                        <label><strong class="indent">Gender *</strong>
                            <select name="gender" id="gender">
                                <option value="">Choose a Gender</option>
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                            </select>
                        </label>


                        <div class="form-group col-md-12" style="margin-bottom:20px">
                            <label for="bee">Are You:</label>
                            <input name="bee" type="radio" value="RDA"> Racially Disadvantaged<br>
                            <input name="bee" type="radio" value="RA"> Racially Advantaged
                        </div>

                        <div class="form-group col-md-12" style="margin-bottom:20px">
                            <label for="bee">Are You Disabled?</label>
                            <input name="disabled" id="dis" type="checkbox" value="Y"> Check if Yes

                            <div class="row-fluid" id="d_toggle" style="display:none">
                                <label for="disability">What is the nature of your disability?</label>
                                <textarea name="disability" cols="" rows="" class="form-control disability"></textarea>
                            </div>
                        </div>

                        <label><strong class="indent">Marital Status *</strong>
                            <select name="marital" id="marital">
                                <option value="">Choose a Option</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Common Law">Common Law</option>
                                <option value="Widow">Widow</option>
                            </select>
                        </label>

                        <label><strong class="indent">Current Job Title *</strong>
                            <input type="text" name="job_title" id="job_title" placeholder="Enter Job Title">
                        </label>

                        <label><strong class="indent">Highest Qualification *</strong>
                            <input type="text" name="qualification" id="qualification" placeholder="Enter Qualification">
                        </label>


                        <label><strong class="indent">Currency Code *</strong>
                            <select name="currency" id="currency">
                                <option value="AFA">Afghani</option><option value="AFN">Afghani</option><option value="ALK">Albanian old lek</option><option value="ALL">Lek</option><option value="DZD">Algerian Dinar</option><option value="USD">US Dollar</option><option value="ADF">Andorran Franc</option><option value="ADP">Andorran Peseta</option><option value="EUR">Euro</option><option value="AOR">Angolan Kwanza Readjustado</option><option value="AON">Angolan New Kwanza</option><option value="AOA">Kwanza</option><option value="XCD">East Caribbean Dollar</option><option value="ARA">Argentine austral</option><option value="ARS">Argentine Peso</option><option value="ARL">Argentine peso ley</option><option value="ARM">Argentine peso moneda nacional</option><option value="ARP">Peso argentino</option><option value="AMD">Armenian Dram</option><option value="AWG">Aruban Guilder</option><option value="AUD">Australian Dollar</option><option value="ATS">Austrian Schilling</option><option value="AZM">Azerbaijani manat</option><option value="AZN">Azerbaijanian Manat</option><option value="BSD">Bahamian Dollar</option><option value="BHD">Bahraini Dinar</option><option value="BDT">Taka</option><option value="BBD">Barbados Dollar</option><option value="BYR">Belarussian Ruble</option><option value="BEC">Belgian Franc (convertible)</option><option value="BEF">Belgian Franc (currency union with LUF)</option><option value="BEL">Belgian Franc (financial)</option><option value="BZD">Belize Dollar</option><option value="XOF">CFA Franc BCEAO</option><option value="BMD">Bermudian Dollar</option><option value="INR">Indian Rupee</option><option value="BTN">Ngultrum</option><option value="BOP">Bolivian peso</option><option value="BOB">Boliviano</option><option value="BOV">Mvdol</option><option value="BAM">Convertible Marks</option><option value="BWP">Pula</option><option value="NOK">Norwegian Krone</option><option value="BRC">Brazilian cruzado</option><option value="BRB">Brazilian cruzeiro</option><option value="BRL">Brazilian Real</option><option value="BND">Brunei Dollar</option><option value="BGN">Bulgarian Lev</option><option value="BGJ">Bulgarian lev A/52</option><option value="BGK">Bulgarian lev A/62</option><option value="BGL">Bulgarian lev A/99</option><option value="BIF">Burundi Franc</option><option value="KHR">Riel</option><option value="XAF">CFA Franc BEAC</option><option value="CAD">Canadian Dollar</option><option value="CVE">Cape Verde Escudo</option><option value="KYD">Cayman Islands Dollar</option><option value="CLP">Chilean Peso</option><option value="CLF">Unidades de fomento</option><option value="CNX">Chinese People's Bank dollar</option><option value="CNY">Yuan Renminbi</option><option value="COP">Colombian Peso</option><option value="COU">Unidad de Valor real</option><option value="KMF">Comoro Franc</option><option value="CDF">Franc Congolais</option><option value="NZD">New Zealand Dollar</option><option value="CRC">Costa Rican Colon</option><option value="HRK">Croatian Kuna</option><option value="CUP">Cuban Peso</option><option value="CYP">Cyprus Pound</option><option value="CZK">Czech Koruna</option><option value="CSK">Czechoslovak koruna</option><option value="CSJ">Czechoslovak koruna A/53</option><option value="DKK">Danish Krone</option><option value="DJF">Djibouti Franc</option><option value="DOP">Dominican Peso</option><option value="ECS">Ecuador sucre</option><option value="EGP">Egyptian Pound</option><option value="SVC">Salvadoran colón</option><option value="EQE">Equatorial Guinean ekwele</option><option value="ERN">Nakfa</option><option value="EEK">Kroon</option><option value="ETB">Ethiopian Birr</option><option value="FKP">Falkland Island Pound</option><option value="FJD">Fiji Dollar</option><option value="FIM">Finnish Markka</option><option value="FRF">French Franc</option><option value="XFO">Gold-Franc</option><option value="XPF">CFP Franc</option><option value="GMD">Dalasi</option><option value="GEL">Lari</option><option value="DDM">East German Mark of the GDR (East Germany)</option><option value="DEM">Deutsche Mark</option><option value="GHS">Ghana Cedi</option><option value="GHC">Ghanaian cedi</option><option value="GIP">Gibraltar Pound</option><option value="GRD">Greek Drachma</option><option value="GTQ">Quetzal</option><option value="GNF">Guinea Franc</option><option value="GNE">Guinean syli</option><option value="GWP">Guinea-Bissau Peso</option><option value="GYD">Guyana Dollar</option><option value="HTG">Gourde</option><option value="HNL">Lempira</option><option value="HKD">Hong Kong Dollar</option><option value="HUF">Forint</option><option value="ISK">Iceland Krona</option><option value="ISJ">Icelandic old krona</option><option value="IDR">Rupiah</option><option value="IRR">Iranian Rial</option><option value="IQD">Iraqi Dinar</option><option value="IEP">Irish Pound (Punt in Irish language)</option><option value="ILP">Israeli lira</option><option value="ILR">Israeli old sheqel</option><option value="ILS">New Israeli Sheqel</option><option value="ITL">Italian Lira</option><option value="JMD">Jamaican Dollar</option><option value="JPY">Yen</option><option value="JOD">Jordanian Dinar</option><option value="KZT">Tenge</option><option value="KES">Kenyan Shilling</option><option value="KPW">North Korean Won</option><option value="KRW">Won</option><option value="KWD">Kuwaiti Dinar</option><option value="KGS">Som</option><option value="LAK">Kip</option><option value="LAJ">Lao kip</option><option value="LVL">Latvian Lats</option><option value="LBP">Lebanese Pound</option><option value="LSL">Loti</option><option value="ZAR">Rand</option><option value="LRD">Liberian Dollar</option><option value="LYD">Libyan Dinar</option><option value="CHF">Swiss Franc</option><option value="LTL">Lithuanian Litas</option><option value="LUF">Luxembourg Franc (currency union with BEF)</option><option value="MOP">Pataca</option><option value="MKD">Denar</option><option value="MKN">Former Yugoslav Republic of Macedonia denar A/93</option><option value="MGA">Malagasy Ariary</option><option value="MGF">Malagasy franc</option><option value="MWK">Kwacha</option><option value="MYR">Malaysian Ringgit</option><option value="MVQ">Maldive rupee</option><option value="MVR">Rufiyaa</option><option value="MAF">Mali franc</option><option value="MTL">Maltese Lira</option><option value="MRO">Ouguiya</option><option value="MUR">Mauritius Rupee</option><option value="MXN">Mexican Peso</option><option value="MXP">Mexican peso</option><option value="MXV">Mexican Unidad de Inversion (UDI)</option><option value="MDL">Moldovan Leu</option><option value="MCF">Monegasque franc (currency union with FRF)</option><option value="MNT">Tugrik</option><option value="MAD">Moroccan Dirham</option><option value="MZN">Metical</option><option value="MZM">Mozambican metical</option><option value="MMK">Kyat</option><option value="NAD" selected>Namibia Dollar</option><option value="NPR">Nepalese Rupee</option><option value="NLG">Netherlands Guilder</option><option value="ANG">Netherlands Antillian Guilder</option><option value="NIO">Cordoba Oro</option><option value="NGN">Naira</option><option value="OMR">Rial Omani</option><option value="PKR">Pakistan Rupee</option><option value="PAB">Balboa</option><option value="PGK">Kina</option><option value="PYG">Guarani</option><option value="YDD">South Yemeni dinar</option><option value="PEN">Nuevo Sol</option><option value="PEI">Peruvian inti</option><option value="PEH">Peruvian sol</option><option value="PHP">Philippine Peso</option><option value="PLZ">Polish zloty A/94</option><option value="PLN">Zloty</option><option value="PTE">Portuguese Escudo</option><option value="TPE">Portuguese Timorese escudo</option><option value="QAR">Qatari Rial</option><option value="RON">New Leu</option><option value="ROL">Romanian leu A/05</option><option value="ROK">Romanian leu A/52</option><option value="RUB">Russian Ruble</option><option value="RWF">Rwanda Franc</option><option value="SHP">Saint Helena Pound</option><option value="WST">Tala</option><option value="STD">Dobra</option><option value="SAR">Saudi Riyal</option><option value="RSD">Serbian Dinar</option><option value="CSD">Serbian Dinar</option><option value="SCR">Seychelles Rupee</option><option value="SLL">Leone</option><option value="SGD">Singapore Dollar</option><option value="SKK">Slovak Koruna</option><option value="SIT">Slovenian Tolar</option><option value="SBD">Solomon Islands Dollar</option><option value="SOS">Somali Shilling</option><option value="ZAL">South African financial rand (Funds code) (discont</option><option value="ESP">Spanish Peseta</option><option value="ESA">Spanish peseta (account A)</option><option value="ESB">Spanish peseta (account B)</option><option value="LKR">Sri Lanka Rupee</option><option value="SDD">Sudanese Dinar</option><option value="SDP">Sudanese Pound</option><option value="SDG">Sudanese Pound</option><option value="SRD">Surinam Dollar</option><option value="SRG">Suriname guilder</option><option value="SZL">Lilangeni</option><option value="SEK">Swedish Krona</option><option value="CHE">WIR Euro</option><option value="CHW">WIR Franc</option><option value="SYP">Syrian Pound</option><option value="TWD">New Taiwan Dollar</option><option value="TJS">Somoni</option><option value="TJR">Tajikistan ruble</option><option value="TZS">Tanzanian Shilling</option><option value="THB">Baht</option><option value="TOP">Pa'anga</option><option value="TTD">Trinidata and Tobago Dollar</option><option value="TND">Tunisian Dinar</option><option value="TRY">New Turkish Lira</option><option value="TRL">Turkish lira A/05</option><option value="TMM">Manat</option><option value="RUR">Russian rubleA/97</option><option value="SUR">Soviet Union ruble</option><option value="UGX">Uganda Shilling</option><option value="UGS">Ugandan shilling A/87</option><option value="UAH">Hryvnia</option><option value="UAK">Ukrainian karbovanets</option><option value="AED">UAE Dirham</option><option value="GBP">Pound Sterling</option><option value="USN">US Dollar (Next Day)</option><option value="USS">US Dollar (Same Day)</option><option value="UYU">Peso Uruguayo</option><option value="UYN">Uruguay old peso</option><option value="UYI">Uruguay Peso en Unidades Indexadas</option><option value="UZS">Uzbekistan Sum</option><option value="VUV">Vatu</option><option value="VEF">Bolivar Fuerte</option><option value="VEB">Venezuelan Bolivar</option><option value="VND">Dong</option><option value="VNC">Vietnamese old dong</option><option value="YER">Yemeni Rial</option><option value="YUD">Yugoslav Dinar</option><option value="YUM">Yugoslav dinar (new)</option><option value="ZRN">Zairean New Zaire</option><option value="ZRZ">Zairean Zaire</option><option value="ZMK">Kwacha</option><option value="ZWD">Zimbabwe Dollar</option><option value="ZWC">Zimbabwe Rhodesian dollar</option>
                            </select>
                        </label>

                        <label><strong class="indent">Current Salary *</strong>
                            <input type="text" name="current_tcc" id="current_ttc" placeholder="Current Salary">
                        </label>

                        <div style="position: relative; width:400px; margin-bottom: 10px">
                            <label><strong class="indent">Expected Salary</strong>
                                <input type="text" name="expected_tcc" id="expected_ttc" placeholder="Expected Salary Optional">
                            </label>
                        </div>

                        <div>
                            <label for="id_number"><strong class="indent">ID Number *</strong>
                                <input type="text" name="id_number" id="id_number" placeholder="Enter ID Number">
                            </label>
                        </div>


                        <label for="email"><strong class="indent">Email *</strong>
                            <input type="email" name="email" id="email" placeholder="Enter Email">
                        </label>

                        <label for="tel"><strong class="indent">Telephone *</strong><br>
                            <input type="text" name="t_code" id="t_code" placeholder="Code" style="width:50px"><input type="text" name="tel" id="tel" placeholder="Enter Telephone" style="width:140px">
                        </label>


                        <label for="cell"><strong class="indent">Cellphone *</strong><br>
                            <input type="text" name="c_code" id="c_code" placeholder="Code" style="width:50px"><input type="text" name="cell" id="cell" placeholder="Enter Cellphone" style="width:140px">
                        </label>


                        <label><strong class="indent">Nationality *</strong>
                            <select name="nationality" id="nationality">
                                <option value="Namibian">Namibian</option>
                                <option value="Non Namibian">Non Namibian</option>
                            </select>
                        </label>

                        <label for="country"><strong class="indent">Country *</strong>
                            <select class="form-control" name="country" id="country">
                                <option value="">Select a Country</option>
                                <?php //echo $this->vacancy_model->get_country_select(); ?>
                            </select>
                        </label>

                        <label for="region"><strong class="indent">Region *</strong>
                            <input type="text"  name="region" id="region" placeholder="Enter Region">
                        </label>

                        <label for="city"><strong class="indent">City *</strong>
                            <input type="text"  name="city" id="city" placeholder="Enter City">
                        </label>


                        <label for="drivers"><strong class="indent">Drivers License *</strong>
                            <select class="form-control" name="drivers" id="drivers">
                                <option value="N">No</option>
                                <option value="Y">Yes</option>
                            </select>
                        </label>

                        <div style="display:none" id="dr_toggle">
                            <label for="drivers_type"><strong class="indent">Type of License *</strong>
                                <select class="form-control" name="drivers_type">
                                    <option value="B">B</option>
                                    <option value="BE">BE</option>
                                    <option value="C">C</option>
                                    <option value="C1">C1</option>
                                    <option value="C1E">C1E</option>
                                    <option value="CE">CE</option>
                                    <option value="PDP">PDP</option>
                                </select>
                            </label>
                        </div>

                        <label>

                            <input type="checkbox" value="Y" name="terms" id="terms" class="required"> I accept the <a href="javascript:void(0)" data-toggle="modal" data-target="#myTerms">Terms and Conditions</a>
                        </label>
                        <hr>
                        <div id="register-spot" style="display:none">
                            <?php //echo $this->vacancy_model->build_captcha(); ?>
                            <br>
                            <small><strong>An email with your career login details will be sent to you.</strong></small>
                            <br>
                            <label><input name="Register" class="submit button rounded5" type="submit" value="Register Now" style="height:50; font-size:18px"></label>
                        </div>

                        <div id="error-message"></div>
                    </form>
                
                </div>
          		
          </div>
    
    </div><!-- /.container -->

</body>



<!-- JAvascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>bootstrap/js/bootstrap.min.js?v1"></script>
<script type="text/javascript" src="<?php echo base_url('/'); ?>js/bootstrap-datepicker.js"></script>
<!--<script type="text/javascript" src="//select2.github.io/dist/js/select2.full.js"></script>-->
<!--<script src="<?php echo base_url('/'); ?>js/custom/fb.js"></script>-->

<script type="text/javascript">

    $(document).ready(function(){
		
		$('#fl_select').on('click', function(e){
			
			e.preventDefault();
		});

        $('#butt').on('click',function(e) {
            e.preventDefault();
			var check = $('#terms'), btn = $(this);
			if(check.prop('checked') == true) {
			
				 var frm = $('#member-register');
				//frm.submit();
				btn.html('Working...');
				$.ajax({
					type: 'post',
					url: '<?php echo site_url('/').'nmh/register_me/';?>' ,
					data: frm.serialize(),
					dataType: 'json',
					success: function (data) {
	
						if(data['success']){
							
							btn.html('Register');
							$('#result_msg').html(data['html']);
						}else{
							$('#result_msg').html(data['html']);
							grecaptcha.reset();
							btn.html('Register');
						}
					}
				});
			}else{
				btn.html('Register');
				$('#check_me').removeClass('text-success hide glyphicon-ok').addClass('text-danger glyphicon-remove');
				
				
			}
        });

		$("#terms").change(function() {
			if(this.checked) {
				$('#check_me').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
			}else{
				$('#check_me').removeClass('text-success hide glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
		});
		$('#email').on("change keyup", function() {

            var str = $(this), div = $('#email_help_div'), email = $('#email').val();
            if(str.val().length > 3 ){

                if(validateEmail(str.val())){

                    $.ajax({
                        type: 'post',
                        url: '<?php echo site_url('/').'members/validate_user_email';?>' ,
                        dataType: 'json',
                        data: {'email': email},
                        success: function (data) {
                            

                            if(data.success){
								div.html('<span class="text-success">'+data.msg+'</span>');
								str.siblings('span.glyphicon').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
                            }else{
								div.html('<span class="text-danger">'+data.msg+'</span>');
								str.siblings('span.glyphicon').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
                            }
                        }
                    });

                }else{

					str.siblings('span.glyphicon').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
                    div.html('<span class="alert-danger">Not a valid email format...</span>');
                }

            }else{
				
				str.siblings('span.glyphicon').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}

        });
		
		$('#fname').on("change keyup", function() {
			var str = $(this)
			if(str.val().length > 3){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
		});
		$('#lname').on("change keyup", function() {
			var str = $(this)
			if(str.val().length > 3){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
		});

		$('#pass').on("change keyup", function() {
			var str = $(this)
			if(str.val().length > 3){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
		});


    });


    function validateEmail(email) {
        // http://stackoverflow.com/a/46181/11236

        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    }

   
    function isNumberKey(evt){
        var str = $("#cell");
		var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
			return false;
		}else{
			
			if(str.val().length >= 9){
				
				str.siblings('span').removeClass('hide text-danger glyphicon-remove').addClass('text-success glyphicon-ok');
				if(str.val().length > 10){
					return false;	
				}
			}else if(str.val().length > 10){
				
				return false;
			}else{
				
				str.siblings('span').removeClass('hide text-success glyphicon-ok').addClass('text-danger glyphicon-remove');
			}
			
			return true;
			
		} 
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
    </script>
</html>