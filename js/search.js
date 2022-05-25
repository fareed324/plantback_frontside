// Search

var Search = window.Search || {};

Search.MerchantSlider = null;
Search.PageSize = 9;
Search.PageNo = 0;
Search.TotalPages = 0;

Search.Ajax = function () {

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


Search.Common = function () {
    return {
		InitSearch:function(){

				Search.Action.DoMerchantSearch();
				Search.Action.DoProductSearch();			

				$("#drpCategory, #drpFilter, #drpSortOrder").change(function(){
					Search.PageNo = 0;
					Search.Action.DoProductSearch();	
				});
				
	      						
               
				$("#chxStock,#chxFreeDelivery").bind("click", function(){
					Search.PageNo = 0;
				   Search.Action.DoProductSearch();	
					
				});
				
			
			
				
				$("#btnLoadMore").bind("click",function(){
					
					if(Search.PageNo < (Search.TotalPages - 1))
					{
						Search.PageNo++;
						Search.Action.DoProductSearch();	
					}

				});

		}
	}
}();



Search.Action = function () {
    return {
		DoProductSearch:function(){
			
			var userid = $('#hdnUserId').val();
		
			var search_term = $("#txtSearch").val();
			var search_category = $("#drpCategory").val();
			var filter = $("#drpFilter").val();
			var order = $("#drpSortOrder").val();
			
		
					
			//var stock = $("#chxStock").prop("ckecked") ? true : "";
			
            var stock = $('input[name="chk[]"]:checked').length > 0;
	        //alert(stock);	
			
			//var freedelivery = $("#chxFreeDelivery").prop("ckecked") ? "true" : "";
			
			 var freedelivery = $('input[name="chkfree[]"]:checked').length > 0;
		    //alert(freedelivery);			
	
			var pageno = Search.PageNo;
			var pagesize = Search.PageSize;
			
			var orderby = "";
			var merchantid = "";
	
			var requestType = "POST";
            var postData = {action: "searchproducts", search_term:search_term, search_category : search_category,
			filter: filter, order: order,  stock:stock, freedelivery: freedelivery, pageno: pageno, pagesize:pagesize,
			orderby:orderby, merchantid:merchantid			
			 };
            var actionUrl = "/searchcontroller.php";
            var successCallback = Search.Action.HandleProductSearchResponse;

            Search.Ajax.Request(requestType, postData, actionUrl, successCallback);
			
		},
		HandleProductSearchResponse: function(response, status)
		{
			var html = "";
			var cathtml = "";

			if(response != null && response.status)
			{
				if(response.data != null && response.data.categories != null && response.data.categories.length > 0)
				{
					cathtml+= '<option value="All">All</option>' ;
					
					for(var x in response.data.categories)
					{
						category = response.data.categories[x];
						var selected = "";
						
						if(category.selected)
						{
							selected = "  selected ";
						}
						
						cathtml+=' <option value="'+category.name+'" '+selected+' >'+category.name+' ['+category.count+'] </option> ';
					}
					
					$("#drpCategory").html(cathtml);
					
				}
				
				
				
				if(response.data != null && response.data.resultcount != null && response.data.resultcount > 0)
				{
					
					
					Search.TotalPages = response.data.totalpages;
					
					if(Search.PageNo < (Search.TotalPages - 1))
					{
						$("#divLoadMore").show();
					}
					else
					{
						$("#divLoadMore").hide();
					}
					
					
					var counter = 1;
					if(response.data.result.length > 0)
					{	
						for(var x in response.data.result)
						{
							var product = response.data.result[x];
														
							if(counter == 1)
							{
								html+= '<div class="productrow">';
							}
							
							var details = product.details;
							
							if(product.details != null && product.details.length > 100)
							{
								details = product.details.substring(0, 100) + "..."; 
							}
							
							var name = product.prod_name;
							
							if(product.prod_name != null && product.prod_name.length > 25)
							{
								name = product.prod_name.substring(0, 21) + "..."; 
							}
							
						
							var url = 'product.php?prodid='+product.id+'&advertid='+product.advertId;
							//var friendid = $("#hdnAffiliateId").val();
							var userid = $("#hdnUserId").val();
							var companyurl = "company.php?id="+product.advertId;
							var getdealurl = "click.php?prodid="+product.id;
							var getdealcssclass = "";
						
							
					/* 	 	if(friendid != "0")
							{
								url+="&friend="+friendid;
								companyurl+="&friend="+friendid;
							} 
							 */
							if(userid == "0")
							{
								getdealurl = "#modallogin";
								getdealcssclass = "login-btn";
							}
							
						
							html+= '<div class="productcol">';
							html+= '<div class="productimg productimagpaid"> <a  href="'+url+'"><img class="productimagpaid" src="'+product.aw_img+'"></a> </div>';
							html+= '<div class="productdesc">';
							html+= '<h3 class="textcolor">'+name+'</h3>';
							html+= '<p>'+details+'</p>';
							html+= '<p><span>Available at: </span><a  href="'+companyurl+'">'+product.companyname+'</a></p>';
							html+= '<p><strong>£'+product.fee+'</strong></p>';
							html+= '<ul class="productlinks">';
							html+= '<li><a  href="'+url+'" class="custombtn">More Details</a></li>';
							html+= '<li><a target="_blank" href="'+getdealurl+'" class="custombtn '+getdealcssclass+'">Get Deal</a></li>';
							html+= '<li><a  href="'+url+'" class="custombtn2 login-btn">'+product.pay_out+' Cashback</a></li>';
							html+= '</ul>';
							html+= '</div>';
							html+= '</div>';
							
							
							if(counter % 3 == 0 || counter == response.data.result.length)
							{
								html+= '</div>';
								
								if(counter < response.data.result.length)
								{
									html+= '<div class="productrow">';
								}						
							}
							
							counter++;
						}
						
						if(Search.PageNo > 0)
						{
							$("#divSearchrResults").append(html);
						}
						else
						{
							$("#divSearchrResults").html(html);
						}
						
						
							//For login Register Box
						//var loginModal = $(".login-btn").leanModal({
							//top: 100,
							//overlay: 0.6,
							//closeButton: ".modal_close"
						//});
						
					}
					else
					{
						$("#divLoadMore").hide();
						html+='<center><h3>No products available</h3></center>';
						$("#divSearchrResults").html(html);
					}	
				}
				else
				{
					$("#divLoadMore").hide();
					html+='<center><h3>No products available</h3></center>';
						$("#divSearchrResultsdivSearchrResults").html(html);
				}
		
			}
		
		
			
		},
		DoMerchantSearch:function(){
			
			var userid = $('#hdnUserId').val();
			var search_term = $("#txtSearch").val();
			
			var requestType = "POST";
            var postData = {action: "searchmerchant", search_term:search_term};
            var actionUrl = "/searchcontroller.php";
            var successCallback = Search.Action.HandleMerchantSearchResponse;

            Search.Ajax.Request(requestType, postData, actionUrl, successCallback);
			
		},
		HandleMerchantSearchResponse: function(response, status)
		{
			var html = "";
		
			if(response != null && response.status)
			{
				if(response.data != null && response.data.list != null && response.data.list.length > 0)
				{
					for(var x in response.data.list)
					{	
						var merchant = response.data.list[x];
						
						var url = 'company.php?id='+merchant.id;
					/* 	var friendid = $("#hdnAffiliateId").val();
						if(friendid != "0")
						{
							url+="&friend="+friendid;
						} */
						
						
						
						
						html+='<li><a  href="'+url+'"><img src="'+merchant.buttonimage+'" titte="'+merchant.companyname+'" /></a></li>';
					}
					
					
					if(Search.MerchantSlider == null)
					{
						$('.partnerslide').html(html)
						
						Search.MerchantSlider = j('.partnerslide').bxSlider({
								slideWidth: 170,
								minSlides: 1,
								maxSlides: 7,
								slideMargin:10,
								adaptiveHeight: true,
								auto : true,
								responsive : true
							});
					}
					else
					{
						$('.bxslider').html(html)
						Search.MerchantSlider.reloadSlider();
					}

					
				}
			}
		},
	}
}();
