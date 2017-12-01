
//Date range picker
$(function () {
	$(".datepicker-birth").datetimepicker({
		format: 'DD MMMM YYYY',
		viewMode: 'years'
	});
});


$(function(){
	
	var nationalities = ["Afghan","Algerian","Angolan","Argentine","Austrian","Australian","Bangladeshi","Belarusian","Belgian","Bolivian","Bosnian","Brazilian","British","Bulgarian","Cambodian","Cameroonian","Canadian","Central African","Chadian","Chinese","Colombian","Costa Rican","Croatian","Czech","Congolese","Danish","Ecuadorian","Egyptian","Salvadoran","English","Estonian","Ethiopian","Finnish","French","German","Ghanaian","Greek","Guatemalan","Dutch","Honduran","Hungarian","Icelandic","Indian","Indonesian","Iranian","Iraqi","Irish","Israeli","Italian","Ivorian","Jamaican","Japanese","Jordanian","Kazakh","Kenyan","Lao","Latvian","Libyan","Lithuanian","Malagasy","Malaysian","Malian","Mauritanian","Mexican","Moroccan","Namibian","New Zealand","Nicaraguan","Nigerien","Nigerian","Norwegian","Omani","Pakistani","Panamanian","Paraguayan","Peruvian","Philippine","Polish","Portuguese","Congolese","Romanian","Russian","Saudi Arabian","Scottish","Senegalese","Serbian","Singaporean","Slovak","Somalian","South African","Spanish","Sudanese","Swedish","Swiss","Syrian","Thai","Tunisian","Turkish","Turkmen","Ukranian","Emirati","American","Uruguayan","Vietnamese","Welsh","Zambian","Zimbabwean"];
	
	var languages = ["Akan","Amharic","Arabic","Assamese","Awadhi","Azerbaijani","Balochi","Belarusian","Bengali","Bhojpuri","Burmese","Cebuano","Chewa","Chhattisgarhi","Chittagonian","Czech","Deccan","Dhundhari","Dutch","Eastern Min","English","French","Fula","Gan Chinese","German","Greek","Gujarati","Haitian Creole","Hakka","Haryanvi","Hausa","Hiligaynon","Hindi","Hmong","Hungarian","Igbo","Ilocano","Italian","Japanese","Javanese","Jin","Kannada","Kazakh","Khmer","Kinyarwanda","Kirundi","Konkani","Korean","Kurdish","Madurese","Magahi","Maithili","Malagasy","Malay/Indonesian","Malayalam","Mandarin","Marathi","Marwari","Mossi","Nepali","Northern Min","Odia","Oromo","Pashto","Persian","Polish","Portuguese","Punjabi","Quechua","Romanian","Russian","Saraiki","Serbo-Croatian","Shona","Sindhi","Sinhalese","Somali","Southern Min","Spanish","Sundanese","Swedish","Sylheti","Tagalog","Tamil","Telugu","Thai","Turkish","Turkmen","Ukrainian","Urdu","Uyghur","Uzbek","Vietnamese","Wu (Shanghainese)","Xhosa","Xiang (Hunnanese)","Yoruba","Yue (Cantonese)","Zhuang","Zulu","Oshiwambo","Kavango","Caprivi","Otjiherero","Nama/Damara","Afrikaans","San"];
	
	var countries = ["Afghanistan","Algeria","Angola","Argentina","Austria","Australia","Bangladesh","Belarus","Belgium","Bolivia","Bosnia and Herzegovina","Brazil","Britain","Bulgaria","Cambodia","Cameroon","Canada","Central African Republic","Chad","China","Colombia","Costa Rica","Croatia","the Czech Republic","Democratic Republic of the Congo","Denmark","Ecuador","Egypt","El Salvador","England","Estonia","Ethiopia","Finland","France","Germany","Ghana","Greece","Guatemala","Holland","Honduras","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Ivory Coast","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Laos","Latvia","Libya","Lithuania","Madagascar","Malaysia","Mali","Mauritania","Mexico","Morocco","Namibia","New Zealand","Nicaragua","Niger","Nigeria","Norway","Oman","Pakistan","Panama","Paraguay","Peru","The Philippines","Poland","Portugal","Republic of the Congo","Romania","Russia","Saudi Arabia","Scotland","Senegal","Serbia","Singapore","Slovakia","Somalia","South Africa","Spain","Sudan","Sweden","Switzerland","Syria","Thailand","Tunisia","Turkey","Turkmenistan","Ukraine","The United Arab Emirates","The United States of America","Uruguay","Vietnam","Wales","Zambia","Zimbabwe"];
	
	$('.keyboard-normal').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'q w e r t y u i o p',
				'a s d f g h j k l {bksp}',
				'{shift} z x c v b n m {shift}',
				'{space} - {accept}'
			],
			'shift' : [
				'Q W E R T Y U I O P',
				'A S D F G H J K L {bksp}',
				'{shift} Z X C V B N M {shift}',
				'{space} - {accept}'
			]
		}
	});
	
	$('.keyboard-nationalities').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'q w e r t y u i o p {bksp}',
				'a s d f g h j k l',
				'z x c v b n m ',
				'{space} {accept}'
			]
		}
	}).autocomplete({
		source: nationalities
		}
	).addAutocomplete({
		position : {
			of : null,        // when null, element will default to kb.$keyboard
			my : 'center bottom', // 'center top', (position under keyboard)
			at : 'center top',  // 'center bottom',
			collision: 'flip'
		}
	});
	
	$('.keyboard-languages').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'q w e r t y u i o p {bksp}',
				'a s d f g h j k l',
				'z x c v b n m ',
				'{space} {accept}'
			]
		}
	}).autocomplete({
		source: languages
		}
	).addAutocomplete({
		position : {
			of : null,        // when null, element will default to kb.$keyboard
			my : 'center bottom', // 'center top', (position under keyboard)
			at : 'center top',  // 'center bottom',
			collision: 'flip'
		}
	});
	
	$('.keyboard-countries').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'q w e r t y u i o p {bksp}',
				'a s d f g h j k l',
				'z x c v b n m ',
				'{space} {accept}'
			]
		}
	}).autocomplete({
		source: countries
		}
	).addAutocomplete({
		position : {
			of : null,        // when null, element will default to kb.$keyboard
			my : 'center bottom', // 'center top', (position under keyboard)
			at : 'center top',  // 'center bottom',
			collision: 'flip'
		}
	});
	
	$('.keyboard-email').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'1 2 3 4 5 6 7 8 9 0 {bksp}',
				'q w e r t y u i o p',
				'a s d f g h j k l',
				'z x c v b n m @ .',
				'{space} .com .com.na _ - {accept}'
			]
		}
	});
	
	$('.keyboard-passport').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'1 2 3 4 5 6 7 8 9 0 {bksp}',
				'Q W E R T Y U I O P',
				'A S D F G H J K L',
				'Z X C V B N M',
				'{space} {accept}'
			]
		}
	});
	
	$('.keyboard-numbers').keyboard({
		layout: 'custom',
		autoAccept : true,
		customLayout: {
			'default' : [
				'7 8 9',
				'4 5 6',
				'1 2 3',
				'0',
				'{bksp} {accept}'
			]
		}
	});
});

	
$(document).ready(function(){
	
	var count = $('.count').length;
	$('.count').text(count);
	$('.registration-form fieldset').each(function(i) {
		$(this).find('.index').text(i+1);
		
	});
	
	/*
        Fullscreen background
    */
    $.backstretch("images/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });
    
    /*
        Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('.registration-form input[type="text"], .registration-form input[type="password"], .registration-form textarea, .registration-form select').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // next step
    $('.registration-form .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	
    	parent_fieldset.find('input[type="text"], input[type="password"], textarea, select').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    	if( next_step ) {
    		parent_fieldset.fadeOut(400, function() {
	    		$(this).next().fadeIn();
	    	});
    	}
    	
    });
    
    // previous step
    $('.registration-form .btn-previous').on('click', function() {
    	$(this).parents('fieldset').fadeOut(400, function() {
    		$(this).prev().fadeIn();
    	});
    });
    
    // submit
    $('.registration-form').on('submit', function(e) {
    	
    	$(this).find('input[type="text"], input[type="password"], textarea, select').each(function() {
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });	

	
	
});