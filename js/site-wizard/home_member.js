$(function() {
		
 $('body').append('<div class="modal-backdrop" id="modal_overlay" style="z-index:1012;display:none"></div>');	
 

	  	
  var $start = $('.start_wiz'),
      tour = new Tour({
        onStart: function() {
          //$start.hide();
		  $('#modal_overlay').fadeIn();
		  $('.navbar-fixed-top').fadeOut();
        },
        onEnd: function() {
          $start.show();
		  $('#modal_overlay').fadeOut();
		  $('.navbar-fixed-top').fadeIn();
        },
		 debug: true,
		
      });

  tour.addStep({
    element: '#admin_content',
    placement: "top",
    title: "Welcome to your NamFeed",
	next: 1,
	
	animation: true, 
    content: "<h5>Introduction</h5><p>Whats happening in Namibia?</p><p> This is your daily feed of great deals, promotions and latest " +
      "news. Dont miss out on the best deals daily. To continue please click on the arrow below.</p>" 
     
  });
   tour.addStep({
    element: '.general',
    placement: "right",
    title: "My Profile",
	next: 2,
  	prev: 0, 
  	animation: true, 
    content: "<h5>My profile</h5><p>Update your personal user account.</p><p> " +
      "Verfify your mobile phone and update your personal account </p>"
  });
  tour.addStep({
    element: '#wiz_business',
    placement: "right",
    title: "My business",
	next: 3,
  	prev: 1, 
  	animation: true, 
    content: "<h5>Your Business</h5><p>Find all the businesses you maintain and have access rights to.</p><p> " +
      "Upadte all business details</p>"
  });
  tour.addStep({
    element: '#general_scratch',
    placement: "right",
    title: "Scratch and Win",
	next: 4,
  	prev: 2, 
  	animation: true, 
    content: "<h5>Win prizes daily</h5><p>Play scratch and win daily and stand a chance to win FREE stuff!.</p><p> " +
      "Your account will be credited with 10 Na points daily. Each game cost 10 points! So let us try make your day a litle more exciting! </p>"
  });
  tour.addStep({
    element: '.msgs',
    placement: "bottom",
    title: "Your Na mail",
  	prev: 3, 
  	animation: true, 
    content: "<h5>Messages</h5><p>Stay connected in Namibia.</p><p> " +
      "All your messages will be kept right over here.</p>",
    onHide: function (tour) {end_tour()} // end
  });
  
  
 tour.start();

  if (tour.ended()) {
   tour.restart();       
  }
 
   function end_tour(){
	   
	 $('#modal_overlay').fadeOut(); $('.navbar-fixed-top').fadeIn();
	   
   }
  $(document).on('click', '.start', function(e) {
    e.preventDefault();
    tour.restart();
    $('.alert').alert('close');
  });
});