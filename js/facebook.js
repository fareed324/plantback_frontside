// JavaScript Document

  // Load the SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));


  window.fbAsyncInit = function() {
  FB.init({
    appId      : '764341230255151',
    cookie     : true,  // enable cookies to allow the server to access 
                        // the session
    xfbml      : true,  // parse social plugins on this page
    version    : 'v2.1' // use version 2.1
  });
  
  

  };
  
 
 function doFacebookLogin() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }


// This is called with the results from from FB.getLoginStatus().
  function statusChangeCallback(response) {
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      getUserDetails();
    } else {
      
	  FB.login(function(response) {
  
		statusChangeCallback(response);
	  
	}, {scope: 'public_profile,email,user_birthday'});
	  
    }
  }


  function getUserDetails() {
    FB.api('/me', function(response) {
      
	  
        var requestType = "POST";
        var postData = response;
        var actionUrl = "/handleFacebookLogin.php";
        var successCallback = handleFacebookLoginCallback;
        doAjaxRequest(requestType, postData, actionUrl, successCallback);

    });
  }
  
  function handleFacebookLoginCallback(data, status)
  {
	  if(data.status)
	  {
		  window.location.href = data.redirecturl;
	  }
  }
  

