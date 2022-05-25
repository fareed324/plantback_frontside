// My History

var MyHistory = window.MyHistory || {};


MyHistory.Ajax = function () {

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



MyHistory.Common = function () {
    return {
		InitMyHistoryScreen:function(){

			MyHistory.Action.GetMyHistoryList();
		}
	}
}();


MyHistory.Action = function () {
    return {
		GetMyHistoryList:function(){
			
			var userid = $('#hdnUserId').val();
			
			var requestType = "POST";
            var postData = {action: "getsearchhistory", userid:userid};
            var actionUrl = "/advertcontroller.php";
            var successCallback = MyHistory.Action.HandleGetMyHistoryListResponse;

            MyHistory.Ajax.Request(requestType, postData, actionUrl, successCallback);
			
		},
		HandleGetMyHistoryListResponse: function(response, status)
		{
			var html = "";
			
			


			
			if(response.status)
			{
				if(response.data.list != null && response.data.list.length > 0)
				{
					var counter = 1;
					
					for(var x in response.data.list)
					{
											
							var searchItem = response.data.list[x];	
																					 						 							      							
							if(counter == 1)
							{
								html+= '<div class="four-offer-block">';
							}														
							html+= '<div class="four-half">';
							html+= '<div class="offer-img">';
							html+= '<img src="'+searchItem.aw_img+'" alt="">';
							html+= '</div>';
							html+= '<p>Search for <strong>"'+searchItem.searchkey+'"</strong> returned <strong>"'+searchItem.total_result+'"</strong> on "'+searchItem.search_time+'"</p>';
							html+= '<a class="searchagain-btn" href="/search.php?search='+searchItem.searchkey+'">Search Again</a>';
							html+= '</div>';

							
													
							if(counter % 4 == 0 || counter == response.data.list.length)
							{
								html+= '</div>';
								
								if(counter < response.data.list.length)
								{
									html+= '<div class="four-offer-block">';
								}						
							}
							
							counter++;
						}
						
					$("#divMyHistory").html(html);
				}
			}
		}
	}
}();