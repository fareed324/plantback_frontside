// Common

$(document).ready(function(){
	
	HelperCommon.Common.Init();
	
});

var HelperCommon = window.HelperCommon || {};


HelperCommon.Ajax = function () {

    return {

        Request: function (requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {
			//alert(errorCallback);

			if(errorCallback == undefined)
			{
				errorCallback = function (jqXHR, textStatus, errorThrown) {
                    console.log('ERROR: ' + jqXHR.status);
                };
			}
			
			if(completeCallback == undefined)
			{
				completeCallback = function (jqXHR, textStatus) {
					
                }
			}

            $.ajax({
                type: requestType,
                data: postData,
                url: actionUrl,
                contentType: "application/x-www-form-urlencoded",
                dataType: "json",
                success: eval(successCallback),
                error: eval(errorCallback),
                complete: eval(completeCallback)
            });

        }
    };

}();

HelperCommon.Common = function () {
    return {
        Init: function () {
				
				//For login Register Box
				//var loginModal = $(".signin-btn, .login-btn").leanModal({
					///top: 100,
					//overlay: 0.6,
					//closeButton: ".modal_close"
				//});
				

				
				//var paymentModal = $("#lblAvailableBalance").leanModal({
					//top: 100,
					//overlay: 0.6,
					//closeButton: ".modal_close"
				//});
				
			
				
				$("#rbtnCheque").bind("click", function(){
					$("#divPayPalEmail").hide();		
					$("#txtPaypalEmail").val("");
				});
			
				$("#rbtnPaypal").bind("click", function(){
					$("#divPayPalEmail").show();
					$("#txtPaypalEmail").val("");
				});
				
				
			//$("#frmPaymentRequest").validate(
					//{
				  // debug: false,
				   //focusInvalid: false,
				   //onfocusout: false,
				   //onkeyup: false,
				   //onclick: false,
				   //submitHandler: function (form)
				   //{
				
		
					   var options = {
						   clearForm: false,
						   url: "/myprofilecontroller.php",
						   type: 'POST',
						   dataType: 'json',
						   success: function (response) {
							   
								if(response.status)
								{
									
									$("#lblAvailableBalance").html("&pound;"+response.data.availablebal+" <span>available</span>");
									$("#lblPaymentRequestMessage").html("Payment request processed");
									
									var style = "";
									if(parseFloat(response.data.availablebal) > parseFloat(response.data.minpaybalance))
									{
										style = "background:green none repeat scroll 0 0;";
									}
									else
									{
										$("#lblAvailableBalance").unbind("click");
										$("#lblAvailableBalance").attr("href", "javascript:void(0)");
									}
								
									$("#lblAvailableBalance").attr("style", style);
									$("#lblAvailableBalance").html("&pound;"+response.data.list.availablebal+"<span>available</span>");
									
									
								}
								else
								{
									$("#lblPaymentRequestMessage").html("Payment request failed, please contact administrator");
								}
		
						   },
					   };
		
					   $('#frmPaymentRequest').ajaxSubmit(options);
		
				   },
				   errorPlacement: function (error, element) {
		
		
		
				   },
				   showErrors: function (errorMap, errorList) {
		
					   var messageHTML = "";
					   if (errorList.length == 0) {
		
					   }
					   this.defaultShowErrors();
		
				   },
				   highlight: function (element, errorClass, validClass) {
					   jQuery(element).addClass('alert-error');
				   },
				   unhighlight: function (element, errorClass, validClass) {
					   jQuery(element).removeClass('alert-error');
				   }
}		
});
				
				
				
					
				
				// for Logout
				
				$(".logout-btn").bind("click", function(){
					
						var requestType = "POST";
						var postData = {action: "logout"};
						var actionUrl = "/usercontroller.php";
						var successCallback = function(response){
					
							if(response.status)
							{
								window.location.href = window.location.href;
								
								/*
								$('.header-right .ul-link, .products-priceblock').hide();
								$('.header-right .logout-btn, .postlogin').hide();
								$('.header-right .signin-btn').show();
								*/
								
							
							}
						
						};
			
						HelperCommon.Ajax.Request(requestType, postData, actionUrl, successCallback);
					
				});
			
				//For Login Button
					$("#login_form").click(function() {
							//$(".social_login").hide();
							$(".user_register").hide();
							$(".user_login").show();
							return false;
					});
			
					// Calling Register Form
					$("#register_form").click(function() {
							//$(".social_login").hide();
							$(".user_login").hide();
							$(".user_register").show();
							$(".header_title").text('Register');
							return false;
					});
			
					/*
					// Going back to Social Forms
					$(".back_btn").click(function() {
							$(".user_login").hide();
							$(".user_register").hide();
							$(".social_login").show();
							$(".header_title").text('Login');
							return false;
					});
					*/

				$("#frmLogin").validate(
					{
				   debug: false,
				   focusInvalid: false,
				   onfocusout: false,
				   onkeyup: false,
				   onclick: false,
				   submitHandler: function (form) {
		
					   var options = {
						   clearForm: true,
						   url: "/usercontroller.php",
						   type: 'POST',
						   dataType: 'json',
						   success: function (response) {
							   
								if(response.status && response.data.login == "0")
								{
									window.location.href = window.location.href;
									/*
									
									$('.header-right .ul-link, .products-priceblock').show();
									$('.header-right .logout-btn, .postlogin').show();
									$('.header-right .signin-btn').hide();
									
									$("#lean_overlay").fadeOut(200);
        							$("#modallogin").css({ 'display' : 'none' });
									
									$('#hdnIsUserLoggedIn').val("true");
									$('#hdnUserId').val(response.data.list.id);
									
									
									$("#lblAvailableBalance").html("&pound;"+response.data.list.availablebal+"<span>available</span>");
									$("#lblPendingBalance").html("&pound;"+response.data.list.pendingbal+"<span>pending</span>");
									*/
								}
								else
								{
									$("#lblLoginMessage").html(response.data.msg);
								}
		
						   },
					   };
		
					   $('#frmLogin').ajaxSubmit(options);
		
				   },
				   errorPlacement: function (error, element) {
		
		
		
				   },
				   showErrors: function (errorMap, errorList) {
		
					   var messageHTML = "";
					   if (errorList.length == 0) {
		
					   }
					   this.defaultShowErrors();
		
				   },
				   highlight: function (element, errorClass, validClass) {
					   jQuery(element).addClass('alert-error');
				   },
				   unhighlight: function (element, errorClass, validClass) {
					   jQuery(element).removeClass('alert-error');
				   }
		
			   });
			   
			   $("#frmRegister").validate(
					{
				   debug: false,
				   focusInvalid: false,
				   onfocusout: false,
				   onkeyup: false,
				   onclick: false,
				   submitHandler: function (form) {
		
					   var options = {
						   clearForm: true,
						   url: "/usercontroller.php",
						   type: 'POST',
						   dataType: 'json',
						   success: function (response) {
							   
								$("#lblRegisterMessage").html(response.data.msg).fadeIn();

						   },
					   };
		
					   $('#frmRegister').ajaxSubmit(options);
		
				   },
				   errorPlacement: function (error, element) {
		
		
		
				   },
				   showErrors: function (errorMap, errorList) {
		
					   var messageHTML = "";
					   if (errorList.length == 0) {
		
					   }
					   this.defaultShowErrors();
		
				   },
				   highlight: function (element, errorClass, validClass) {
					   jQuery(element).addClass('alert-error');
				   },
				   unhighlight: function (element, errorClass, validClass) {
					   jQuery(element).removeClass('alert-error');
				   }
		
			   });
				

			HelperCommon.Action.GetUserSession();
			HelperCommon.Action.GetCategoriesMenuData(HelperCommon.Action.HandleCategoriesMenudata);

        }
		
    };
} ();


HelperCommon.Action = function () {
    return {
        GetUserSession: function () {
			
			var requestType = "POST";
            var postData = {action: "getsession"};
            var actionUrl = "/usercontroller.php";
            var successCallback = HelperCommon.Action.HandleGetUserSessionResponse;

            HelperCommon.Ajax.Request(requestType, postData, actionUrl, successCallback);

        },
		HandleGetUserSessionResponse: function (response, status) {
			
			if(response.status && response.data != null)
			{
				
				
				
				$('.header-right .ul-link, .products-priceblock').show();
				$('.header-right .signin-btn').hide();
				$('.header-right .logout-btn, .postlogin').show();
				$('#hdnIsUserLoggedIn').val("true");
				$('#hdnUserId').val(response.data.list.id);
				
				$("#txtRequestAmount").attr("max", response.data.list.availablebal);
				$("#txtRequestAmount").val(response.data.list.availablebal);
			
				var style = "";
			
				if(parseFloat(response.data.list.availablebal) > parseFloat(response.data.list.minpaybalance))
				{
					style = "background:green none repeat scroll 0 0;";
				}
				else
				{
					$("#lblAvailableBalance").unbind("click");
					$("#lblAvailableBalance").attr("href", "javascript:void(0)");
				}
			
				$("#lblAvailableBalance").attr("style", style);
				$("#lblAvailableBalance").html("&pound;"+response.data.list.availablebal+"<span>available</span>");
				
				
				$("#lblPendingBalance").html("&pound;"+response.data.list.pendingbal+"<span>pending</span>");
				
				$("#lblLoggedInUsername").html(response.data.list.name);

				
			}
			else
			{
				$('.header-right .ul-link, .products-priceblock').hide();
				$('.header-right .signin-btn').show();
				$('.header-right .logout-btn, .postlogin').hide();
				$('#hdnIsUserLoggedIn').val("false");
				$("#lblAvailableBalance").html("&pound;0.00 <span>available</span>");
				$("#lblPendingBalance").html("&pound;0.00 <span>pending</span>");
				$("#lblLoggedInUsername").html("");
			}

        },
		GetPageContent: function (pageref, successCallback) {
			
			var requestType = "POST";
            var postData = { action: "getpagecontent","pageref" : pageref };
            var actionUrl = "/cmscontroller.php";

            HelperCommon.Ajax.Request(requestType, postData, actionUrl, successCallback);

        },
		HandleAboutUsPageResponse: function (response, status) {
			
			if(response.status)
			{
				$("#header").after(response.data.pagebody);
			}

        },
		GetCategoriesMenuData: function(successCallback){
			
			var requestType = "POST";
            var postData = { action: "getcategoriesmenudata"};
            var actionUrl = "/commoncontroller.php";

            HelperCommon.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleCategoriesMenudata: function(response, status)
		{
			if(response != null && response.data.error == 0)
			{
				var main_cat = [];
				var main_id = [];
				var main_id_only = [];
		
				for(var x in response.data.list)
				{
					var catdata = response.data.list[x];
					
					var test = jQuery.inArray(catdata.id, main_id_only);
					if(test == -1)
					{
						main_id_only.push(catdata.id);
						main_id.push(catdata);
					}
					
					main_cat.push(catdata);
				}
				
				
				
				
				var html = "";
				var index = 0;
		
				for(var i=0; i < main_id.length; i++){
					var count = 0;
					var j = index;
		
					for(; j < main_cat.length; j++)
					{
						if(main_cat[j].id ==  main_id[i].id){
							
						catname = main_cat[j].catname.replace("&","and" );
						
							if(count == 0){
								
								html+= '<li><a class="cat_main" >'+main_cat[j].name+'&raquo;</a>';					
								html+= '<ul class="nav_menu_sub" ><li><a href="/category.php?catid='+main_cat[j].catid+'&cattype='+main_cat[j].name+'&catname='+catname+'">'+main_cat[j].catname+'</a></li>';
								
								index++;
							}
							else{				
								html+= '<li><a href="/category.php?catid='+main_cat[j].catid+'&cattype='+main_cat[j].name+'&catname='+catname+'">'+main_cat[j].catname+'</a></li>';
								index++;
							}
							count++;
						}
						else break;
		
					}
					html+= '</ul></li>';
				}
			
				$("#ulCategories").html(html);
					
			}
		}
		
    };
} ();


