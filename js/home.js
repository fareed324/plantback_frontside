// Home Screen


var Home = window.Home || {};
console.log("Home Screen",Home);

Home.Ajax = function () {

    return {

        Request: function (requestType, postData, actionUrl, successCallback, errorCallback, completeCallback) {

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



Home.Common = function(){
	return{
		Init: function()
		{
			Home.Action.GetTopOffers();	
		
            $("#divTopOffers").on("click", ".removefrommyoffer", function () {
				
				Home.Action.RemoveFromMyOffers($(this).data("advertid"));
                
            });
			
			$("#divTopOffers").on("click", ".addtomyoffer", function () {
                
				Home.Action.AddToMyOffers($(this).data("advertid"));
				
            });
			
					
		}
	};
}();

Home.Action = function () {
    return {
        GetTopOffers: function () {
			
			var requestType = "POST";
            var postData = {action: "gettopoffers"};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Home.Action.HandleGetTopOffersResponse;

            Home.Ajax.Request(requestType, postData, actionUrl, successCallback);

        },
		HandleGetTopOffersResponse: function (response, status) {
			console.log("Check data",response);
			var html = "";
			
			if(response != null && response.status)
			{
				var counter = 1;
				if(response.data.list != null && response.data.list.length > 0)
				{
					for(var x in response.data.list)
					{
						var advert = response.data.list[x];
						
						if(counter == 1)
						{
							html+= '<div  class="four-offer-block">';
						}
						
						var url = 'company.php?id='+advert.advertids.toString();
						
					/* 	var friendid = $("#hdnAffiliateId").val();
						if(friendid != "0")
						{
							url+="&friend="+friendid;
						} */
						
					
						html+= '<div class="four-half">';
						html+= '	<div class="offer-img">';
						//html+= '	<a href='+url+'><img src="'+advert.bannerimage+'" alt=""></a>';
						html+= '	<a href='+url+'><img class="homegettopimg" src="'+advert.buttonimage+'" alt=""></a>';
						
						html+= '	</div>';
						html+= '	<h3>'+advert.companyname+'</h3>';
						html+= '	<p>'+advert.smalldesc.substring(0,90)+'...</p>';
						html+= '	<a class="view-btn" href="'+url+'" >View</a>';
						
						
						if($("#hdnIsUserLoggedIn").val() == "true")
						{
						
						if(advert.isMyOffer)
						{
							html+= '	<a style="margin-left:20dp;" data-advertid="'+advert.advertids+'" class="view-btn removefrommyoffer" href="javascript:void(0)" >Remove</a>';
						}
						else
						{
							html+= '	<a style="margin-left:20dp;" data-advertid="'+advert.advertids+'"  class="view-btn addtomyoffer" href="javascript:void(0)" >Add To My Offers</a>';
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
					
					$("#divTopOffers").html(html);
					
				}
			}
        },
		AddToMyOffers: function(advertId)
		{
			var userid = $('#hdnUserId').val();
			var requestType = "POST";
            var postData = {action: "addtomyoffer", advertid: advertId, userid: userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = Home.Action.HandleAddToMyOffersResponse;

            Home.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleAddToMyOffersResponse: function(response, status)
		{
			if(response.status)
			{
				Home.Action.GetTopOffers();
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
            var actionUrl = "advertcontroller.php";
            var successCallback = Home.Action.HandleRemoveFromMyOffersResponse;

            Home.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleRemoveFromMyOffersResponse: function(response, status)
		{
			if(response.status)
			{
				Home.Action.GetTopOffers();
			}
			else
			{
				alert(response.data.msg);
			}
			
		}
    };
} ();
