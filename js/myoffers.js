// My Offers

var MyOffers = window.MyOffers || {};


MyOffers.Ajax = function () {

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



MyOffers.Common = function () {
    return {
		InitMyOffersScreen:function(){

			$("#divMyOffers").on("click", ".removefrommyoffer", function () {
				
				MyOffers.Action.RemoveFromMyOffers($(this).data("advertid"));
                
            });

			MyOffers.Action.GetMyOffersList();
			
		}
	}
}();


MyOffers.Action = function () {
    return {
		GetMyOffersList:function(){
			
			var userid = $('#hdnUserId').val();
			//alert(userid);
			var requestType = "POST";
            var postData = {action: "getmyoffers", userid:userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = MyOffers.Action.HandleGetMyOffersListResponse;

            MyOffers.Ajax.Request(requestType, postData, actionUrl, successCallback);
			
		},
		HandleGetMyOffersListResponse: function(response, status)
		{
			var html = "";
			
			if(response.status)
			{
				if(response.data.list != null && response.data.list.length > 0)
				{
					var counter = 1;
					
					for(var x in response.data.list)
					{
											
							var advert = response.data.list[x];
							
							if(counter == 1)
							{
								html+= '<div class="innersection nopadding">';
							}

							html+='<a class="logobox removefrommyoffer" href="javascript:void(0)" data-advertid="'+advert.advertid+'"><img src="'+advert.bannerimage+'">';
							html+='<span class="span-offerlink ">Remove</span></a>';
							
													
							if(counter % 7 == 0 || counter == response.data.list.length)
							{
								html+= '</div>';
								
								if(counter < response.data.list.length)
								{
									html+= '<div class="innersection nopadding">';
								}						
							}
							
							counter++;
						}
						
					$("#divMyOffers").html(html);
				}
			}
		},
		RemoveFromMyOffers: function(advertId)
		{
			var userid = $('#hdnUserId').val();
			var requestType = "POST";
            var postData = {action: "removefrommyoffer", advertid: advertId, userid: userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = MyOffers.Action.HandleRemoveFromMyOffersResponse;

            MyOffers.Ajax.Request(requestType, postData, actionUrl, successCallback);
		},
		HandleRemoveFromMyOffersResponse: function(response, status)
		{
			if(response.status)
			{
				MyOffers.Action.GetMyOffersList();	
			}
			else
			{
				alert(response.data.msg);
			}
		}
	}
}();