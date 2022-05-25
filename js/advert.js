// Home Screen
 //header('Content-Type: application/json; charset=utf-8;');

var Advert = window.Advert || {};

Advert.SelectedCategory = 0;
Advert.CurrentPage = 0;

Advert.Ajax = function () {

    return {

        Request: function (POST, postData, actionUrl, successCallback, errorCallback, completeCallback) {

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
                type: POST,
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


Advert.Common = function () {
    return {

	InitCategoryScreen:function(){
			
		$("#divCategoryAdverts").on("click", ".removefrommyoffer", function () {
				
				Advert.Action.RemoveFromMyOffers($(this).data("advertid"));
                
            });
			
			$("#divCategoryAdverts").on("click", ".addtomyoffer", function () {
                
				Advert.Action.AddToMyOffers($(this).data("advertid"));
				
            });
		
			
			 $(".divPaging").on("click", ".btnPrevious", function () {
				
				
				if(currentPage > 0)
				{
					currentPage = currentPage - 1;
					Advert.Action.GetAdvertByCategory(currentCategoryId , currentPage);
					
				}
			
            });

            $(".divPaging").on("click", ".btnPageNo", function () {

				currentPage = $(this).data("pageno");
                Advert.Action.GetAdvertByCategory(currentCategoryId , currentPage);

            });

            $(".divPaging").on("click", ".btnNext", function () {
                
				if(currentPage < totalPages)
				{
					currentPage = currentPage + 1;
					Advert.Action.GetAdvertByCategory(currentCategoryId , currentPage);
					
				}
				
            });
		},
	InitCompanyScreen: function(){
		
		
		$("#lnkCheckOutOffer").bind("click", function(){
			
			if($(this).attr("href") !=  "#modallogin")
			{
				
				Advert.Action.DoAdvertVisit($(this).data("advertid"));
				
			}
			
		});
		
		$("#lnkRememberOffer").bind("click", function(){
			
			if($(this).attr("href") !=  "#modallogin")
			{
				
				if($(this).hasClass("removeoffer"))
				{
					//var $hello = $(this).data("advertid");
					//alert($hello);
					
					Advert.Action.ForgetOffer($(this).data("advertid"));
				}
				else
				{
					
					Advert.Action.RememberOffer($(this).data("advertid"));
				}
				
				
				
				
			}	
		});
		
		var rateModal = $("#lnkRateAdvert").leanModal({
					top: 100,
					overlay: 0.6,
					closeButton: ".modal_close"
				});
				
				
				
			$("#frmRateAdvert").validate(
					{
				   debug: false,
				   focusInvalid: false,
				   onfocusout: false,
				   onkeyup: false,
				   onclick: false,
				   submitHandler: function (form) {
				
		                //var tests = $('[name="adscore"]:checked').val();
						//alert (tests);
						if(typeof($('[name="adscore"]:checked').val()) != "undefined")
						{
		                  
                         
					   var options = {
						   clearForm: false,
						   url: "/advertcontroller.php",
						   type: 'POST',
						   dataType: 'json',
						   success: function (response) {
							 
								if(response.status)
								{
									$("#lblAdvertRatingMessage").html("Thank you for rating us!");
								}
								else
								{
									$("#lblAdvertRatingMessage").html("Please try again later");
								}
		
						   },
					   };
		
					   $('#frmRateAdvert').ajaxSubmit(options); 
				}
				else
				{
					$("#lblAdvertRatingMessage").html("Please select a value");
				}
		
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
				
		
	}
		
	}
}();

Advert.Action = function () {
    return {
        GetAdvertDetails: function (advertid) {
			
			var requestType = "POST";
            var postData = {action: "getadvertdetails", advertid: advertid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Advert.Action.HandleGetAdvertDetailsResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);

        },
		HandleGetAdvertDetailsResponse: function (response, status) {
			
			var html = "";
			
			if(response != null && response.status)
			{
				var advert = response.data.list[0];
				
				$("#lblCompanyName").html(advert.companyname);
				$("#imgLogo").attr("src",advert.buttonimage);
				$("#divDescription").html(advert.smalldesc);
				$("#divHowToEarn").html(advert.howearn);
				$("#divpayout").html(advert.pay_out);
				$("#divOfferDetails").html(advert.largedesc);
				
				var rateHTML = "";
				
					if(parseInt(advert.count) !=0 )
					{

								var floorVal = Math.floor(advert.rate);
								for(var i = 1; i <= floorVal; i++)
								{
									 
									rateHTML+="<img src='/images/star-whole.png'/>";
									 
									
								}
								 
								if (advert.rate - floorVal == 0.5)
								{
									floorVal = floorVal + 1;
									rateHTML+= "<img src='/images/star-half.png'/>";
								}
								 
								for(var j = floorVal ; j <  5; j++)
								{
									 
									rateHTML+= "<img src='/images/star-empty.png'/>";
									 
									
								}
								
					}
					else 
					{ 
						rateHTML = "<img src='/images/star-empty.png'/><img src='/images/star-empty.png'/><img src='/images/star-empty.png'/><img src='/images/star-empty.png'/><img src='/images/star-empty.png'/>"; 
					}
							
				$("#lnkRateAdvert").html(rateHTML);
				
				var cssClass = advert.isMyOffer ? " removeoffer ":" addoffer ";
				var text = advert.isMyOffer ? " Remove this Frootfal Offer ":" Remember this Paidcash Offer ";
				
				$("#lnkRememberOffer").text(text).addClass(cssClass);
				
			}
        },
		GetAdvertLatestProducts: function (advertid) {
			
			var requestType = "POST";
            var postData = {action: "getadvertlatestproducts", advertid: advertid, limit:5};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Advert.Action.HandleGetAdvertLatestProductsResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);

        },
		HandleGetAdvertLatestProductsResponse: function (response, status) {
			
			var html = "";
			
			if(response != null && response.status)
			{
				var html = "";
				
				if(response.data != null && response.data.list != null && response.data.list.length > 0)
				{	
					var counter = 1;
				
					for(var x in response.data.list)
					{
					
						var product = response.data.list[x];		
						
						if(counter == 1)
						{
							html+= '<div  class="productrow">';
						}
						
						var url = 'product.php?prodid='+product.id+'&advertid='+product.advertId;
						var friendid = $("#hdnAffiliateId").val();
						if(friendid != "0")
						{
							url+="&friend="+friendid;
						}

						
						html+='<div class="productcol">';
						html+='<div class="productimg">';
						html+='<a href="'+url+'"><img class="latestproductimg" src="'+product.aw_img+'"></a>';
						html+='</div>';
						html+='<div class="productdesc">';
						html+='<h3 class="textcolor">'+product.prod_name+'</h3>';
						html+='</div>';
						html+='</div>';		
						
						if(counter % 3 == 0 || counter == response.data.list.length)
						{
							html+= '</div>';
							
							if(counter < response.data.list.length)
							{
								html+= '<div  class="productrow">';
							}						
						}
						
						counter++;
										
					}
				}
				else
				{
					html+='<center><h3>No products available</h3></center>';
				}
				
				
				
				$("#divLatestProducts").html(html);
				
			}
        },
		
		GetAdvertByCategory: function (categoryid, pageno) {
			
			
			Advert.SelectedCategory = categoryid;
			Advert.CurrentPage = pageno;
			
			var pageSize = 12;
			
			var requestType = "POST";
            var postData = {action: "getadvertbycategory", catid: categoryid, pageno: pageno, pagesize: pageSize};
			
            var actionUrl = "/advertcontroller.php";
			
            var successCallback = Advert.Action.HandleGetAdvertByCategoryResponse;
			
			

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);

        },
		HandleGetAdvertByCategoryResponse: function (response, status){
			
			if(response.status && response.data.error == 0)
			{
				totalPages = response.data.totalpages;
							

				var html = "";
				
				var counter = 1;
				if(response.data.list.length > 0)
				{	
					for(var x in response.data.list)
					{
						var advert = response.data.list[x];
						
					   // console.log(advert);
						
						if(counter == 1)
						{
							html+= '<div  class="four-offer-block">';
						}
						
						var url = 'company.php?id='+advert.id.toString();
                   
						//var friendid = $("#hdnAffiliateId").val();
						/* if(friendid != "0")
						{
							url+="&friend="+friendid;
						} */
					
						html+= '<div class="four-half">';
						html+= '	<div class="offer-img">';
						html+= '	<img class="homegettopimg" src="'+advert.buttonimage+'" alt="">';
						html+= '	</div>';
						html+= '	<h3>'+advert.companyname+'</h3>';
						//html+= '	<p>'+advert.smalldesc+'</p>';
						html+= '	<p>'+advert.smalldesc.substring(0,90)+'...</p>';
						html+= '	<a class="view-btn" href="'+url+'" >View</a>';
						
						if($("#hdnIsUserLoggedIn").val() == "true")
						{
						
						if(advert.isMyOffer)
						{
							html+= '	<a style="margin-left:20dp;"  data-advertid="'+advert.id+'" class="view-btn removefrommyoffer" href="javascript:void(0)" >Remove</a>';
						}
						else
						{
							html+= '	<a style="margin-left:20dp;"  data-advertid="'+advert.id+'" class="view-btn addtomyoffer" href="javascript:void(0)" >Add To My Offers</a>';
						}
						
						}
						
						html+= '</div>'
						
						
						if(counter % 4 == 0 || counter == response.data.list.length)
						{
							html+= '</div>';
							
							if(counter < response.data.list.length)
							{
								html+= '<div  class="four-offer-block">';
							}						
						}
						
						counter++;
					}
					
					$("#divCategoryAdverts").html(html);
				}
				else
				{
					html+='<center><h3>No products available</h3></center>';
				}
				
				
				
				$("#divLatestProducts").html(html);
				
				
				Advert.Action.HandleCategoryPaging(response.data.totalpages, response.data.pageno);
			}
		},
		HandleCategoryPaging: function(totalpages, pageno){
			
			

            if (totalpages > 1) {


                var pagingHtml = '<span><a href="javascript:void(0)" class="btnPrevious Previous"> < </a></span>';

                var pagingStart = pageno - 2;
                if (pagingStart <= 0) {
                    pagingStart = 1;
                }

                var pagingEnd = pagingStart + 4;

                if (pagingEnd > totalpages) {
                    pagingEnd = totalpages;
                    pagingStart = pagingEnd - 4;

                    if (pagingStart <= 0) {
                        pagingStart = 1;
                    }

                }


                for (var i = pagingStart; i <= pagingEnd; i++) {
                    var style = (pageno+1) == i ? " class='active' " : "";

                    pagingHtml += '<span ' + style + ' ><a href="javascript:void(0)" class="btnPageNo" data-pageno="' + i + '" >' + i + ' </a></span>';
                }

                pagingHtml += '<span ><a href="javascript:void(0)" class="btnNext Next"> > </a></span>';

                $(".divPaging").find(".container").html(pagingHtml);

                $(".divPaging").show();

                if (pageno == totalpages) {
                    $(".btnNext").hide();
                    $(".btnPrevious").show();

                }
                else if (pageno == 1) {
                    $(".btnNext").show();
                    $(".btnPrevious").hide();

                }
                else {
                    $(".btnNext").show();
                    $(".btnPrevious").show();
                }

            }
            else {
                $(".divPaging").hide();

            }

        
			
		},
		AddToMyOffers: function(advertId)
		{
			var userid = $('#hdnUserId').val();
			var requestType = "POST";
            var postData = {action: "addtomyoffer", advertid: advertId, userid: userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Advert.Action.HandleAddToMyOffersResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleAddToMyOffersResponse: function(response, status)
		{
			if(response.status)
			{
				Advert.Action.GetAdvertByCategory(Advert.SelectedCategory, Advert.CurrentPage);	
			}
			else
			{
				alert(response.data.msg);
			}
			
		},
		RemoveFromMyOffers: function(advertId)
		{
			var userid = $('#hdnUserId').val();
			var requestType = "POST";
            var postData = {action: "removefrommyoffer", advertid: advertId, userid: userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Advert.Action.HandleRemoveFromMyOffersResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleRemoveFromMyOffersResponse: function(response, status)
		{
			if(response.status)
			{
				Advert.Action.GetAdvertByCategory(Advert.SelectedCategory, Advert.CurrentPage);	
			}
			else
			{
				alert(response.data.msg);
			}
		},
		DoAdvertVisit: function(advertid){
		
			var userid = $('#hdnUserId').val();
			var requestType = "POST";
            var postData = {action: "advertvisit", advertid: advertid, userid: userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Advert.Action.HandleDoAdvertVisitResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleDoAdvertVisitResponse: function(response)
		{
			if(response !=null && response.status)
			{
				//alert(data);
					var splitdata= response.data.returnurl.split("*");
					
					var clicks=splitdata[0];
					var url=splitdata[1];
					//alert(clicks);
					//alert(url);
					if(clicks < 10){
					//window.location.href=url;
					window.open(url,'_blank');
					}
					if(clicks == 10){
						$('#lblCompanyMessage').html('<ul id="warning_error"><li>WARNING: you have already clicked this advert <b> 3 </b>times within the last 24 hours. If you wish to continue you can, but the site will be alerted to your activity which may result in a ban.</li></ul>')
					//window.location.href=url;
					window.open(url,'_blank');
					}
					if((clicks >= 11 ) && (clicks <= 13)){
						$('#lblCompanyMessage').html('<ul id="warning_error"><li>NOTICE: you have already clicked this advert  <b>'+clicks+'</b> times within the last 24 hours and the site has been alerted to your high activity level. If you click the advert 10 times within 24 hours your account will be automatically suspended. </li></ul>').attr("class","alert alert-danger");
						//window.location.href=url;
						window.open(url,'_blank');
					}
					if(clicks == 14){
						$('#lblCompanyMessage').html('<ul id="warning_error"><li>FINAL WARNING: you have already clicked this advert   <b>'+clicks+'</b> times within the last 24 hours. If you continue your account will be suspended . </li></ul>').attr("class","alert alert-danger");
						//window.location.href=url;
						window.open(url,'_blank');
					}	
					if(clicks == 15)
					{
					// SUSPEND TH USER IF CLICKS MORE THAN 10 IN 24 HOURS
					window.location="suspended.php";
					}
			}
		},
		
		RememberOffer: function(advertId)
		{
			var userid = $('#hdnUserId').val();			
			var requestType = "POST";
            var postData = {action: "addtomyoffer", advertid: advertId, userid: userid};
            var actionUrl = "advertcontroller.php";
            var successCallback = Advert.Action.HandleRememberOffersResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleRememberOffersResponse: function(response, status){
			
			$("#lnkRememberOffer").removeClass("addoffer").addClass("removeoffer");
			
				
			$("#lnkRememberOffer").text("Remove this Frootfal Offer");
			
		},
		ForgetOffer: function(advertId)
		{
			var userid = $('#hdnUserId').val();
			//var userid = 642;
			var requestType = "POST";
            var postData = {action: "removefrommyoffer", advertid: advertId, userid: userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Advert.Action.HandleForgetOfferResponse;

            Advert.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleForgetOfferResponse: function(response){
			
			$("#lnkRememberOffer").addClass("addoffer").removeClass("removeoffer");
			$("#lnkRememberOffer").text("Remember this Frootfal Offer");
			
		}
    };
} ();
