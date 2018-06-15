// MY.NA FB SDk
	  // This is called with the results from from FB.getLoginStatus().
	  function statusChangeCallback(response) {
		// The response object is returned with a status field that lets the
		// app know the current login status of the person.
		// Full docs on the response object can be found in the documentation
		// for FB.getLoginStatus().
		if (response.status === 'connected') {
		  // Logged into your app and Facebook.
		  
		  goregister(response);
		} else if (response.status === 'not_authorized') {
		  // The person is logged into Facebook, but not your app.
		  //document.getElementById('msg').innerHTML = 'Please log ' +
			console.log('statusChangeCallback not_authorized');
		} else {
		  // The person is not logged into Facebook, so we're not sure if
		  // they are logged into this app or not.
		  ///document.getElementById('msg').innerHTML = 'Please log ' +
			//'into Facebook.';
		
		}
	  }
	
	  // This function is called when someone finishes with the Login
	  // Button.  See the onlogin handler attached to it in the sample
	  // code below.
	  function checkLoginState() {
		
		FB.getLoginStatus(function(response) {
		  statusChangeCallback(response);
		});
	  }

	  
      window.fbAsyncInit = function() {
			FB.init({
				//1504517666462894
			  appId      : '287335411399195',
			  xfbml      : true,
			  cookie     : true,
			  status     : true,  
			  version    : 'v2.1'
			});
	
			// ADD ADDITIONAL FACEBOOK CODE HERE
			function onLogin(response) {
			 
			  if (response.status == 'connected') {
				FB.api('/me', function(data) {
					gologin(response);
				});
			  }
			}
			
			FB.getLoginStatus(function(response) {
			  // Check login status on load, and if the user is
			  // already logged in, go directly to the welcome message.
			  if (response.status == 'connected') {
				onLogin(response);
			  } else {
				// Otherwise, show Login dialog first.
				//FB.login(function(response) {
//				  onLogin(response);
//				}, {scope: 'user_friends, email,user_birthday'});
			  }
			});

   	  };
	
	 (function(d, s, id){
		 var js, fjs = d.getElementsByTagName(s)[0];
		 if (d.getElementById(id)) {return;}
		 js = d.createElement(s); js.id = id;
		 js.src = "//connect.facebook.net/en_US/sdk.js";
		 fjs.parentNode.insertBefore(js, fjs);
	   }(document, 'script', 'facebook-jssdk'));

	
  
	  
	  function goregister(response){

		FB.api('/me', function(response) {
				$.ajax({
					type: 'POST',
					data: response,
					cache: false,
					url: 'https://beta.my.na/fb/login/register/',
					success: function (data) {

						if(data === 'TRUE'){
							
							window.location.reload();
							
						}   	
					}
				});
		});
		
		  
	  }


	  function gologin(response){
		
		FB.api('/me', function(response) {
				$.ajax({
					type: 'POST',
					data: response,
					cache: false,
					url: 'https://beta.my.na/fb/login/',
					success: function (data) {
	
						if(data === 'TRUE'){
							
							window.location.reload();
							
						}
					}
				});
		});
		  
	  }

	function postToFeed(id, name, pic, caption, body, linkt) {

		var obj = {
			method: "feed",
			//redirect_uri: "'.site_url('/').'deals/encfb/'.$fb_share_key.'",
			link: linkt,
			picture: pic,
			name: name,
			caption: caption,
			description: body
		};
		function callback(response) {
			if (response && response.post_id) {
				//POST WAS PUBLISHED
				console.log(response);
				fb_share_callback(response);
			} else {
				//POST NOT PUBLISHED
				console.log(response);
			}
		}

		FB.ui(obj, callback);
	}


	function fb_share_callback(response){

		$.ajax({
			type: 'post',
			data: response,
			url: 'https://www.my.na/fb/fb_share_callback/',
			success: function(data) {

				console.log(data);

			}
		});

	}