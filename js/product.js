// Product

var Product = window.Product || {};

Product.Ajax = function () {

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



Product.Common = function () {
    return {
		InitScreen:function(){

			Product.Action.GetProductDetails();
			Product.Action.GetMoreProductsFromSeller();

		}
	}
}();



Product.Action = function () {
    return {
		GetProductDetails:function(){
			
			var productid = $('#hdnProdId').val();
			var advertid = $('#hdnAdvertId').val();
		
			
			var requestType = "POST";
            var postData = {action: "productdetails", productid:productid, advertid: advertid };
            var actionUrl = "/productcontroller.php";
            var successCallback = Product.Action.HandleGetProductDetailsResponse;

            Product.Ajax.Request(requestType, postData, actionUrl, successCallback);
			
		},
		HandleGetProductDetailsResponse: function(response, status)
		{
			
			if(response != null && response.status)
			{
				if(response.data != null && response.data.list != null && response.data.list.length > 0)
				{
					var product = response.data.list[0];
					
					
				    $("#lblProductName").html(product.prod_name);				
					$("#divProductDetails").html(product.details);
					$("#lblCategory").html(product.cat);
					$("#lblHowEarn").html(product.howearn);
					$("#lblpayout").html(product.pay_out);
					$("#lblFee").html(product.fee);
					$("#imgProduct").attr("src",product.aw_img);
					
					$("#imgProduct").parent().attr("href",product.aw_img);
					
					var url = "company.php?id="+product.advertId;
					
					var friendid = $("#hdnAffiliateId").val();
					if(friendid != "0")
					{
						url+="&friend="+friendid;
					} 
					 
					
					$("#lblCompanyName").html("Seller: <a href='"+url+"'>"+product.companyname+"</a>");
					$("#proCompanyName").html("<span class='productcompanyname'>"+product.companyname+"</span>");

					
					$('.jqzoom').fancybox();
				
				}
			}
		},
		GetMoreProductsFromSeller:function(){
			
			var productid = $('#hdnProdId').val();
			var advertid = $('#hdnAdvertId').val();
		
			var requestType = "POST";
            var postData = {action: "morefromseller", productid:productid, advertid: advertid };
            var actionUrl = "/productcontroller.php";
            var successCallback = Product.Action.HandleGetMoreProductsFromSellerResponse;

            Product.Ajax.Request(requestType, postData, actionUrl, successCallback);
			
		},
		HandleGetMoreProductsFromSellerResponse: function(response, status)
		{
			
			if(response != null && response.status)
			{
				if(response.data != null && response.data.list != null && response.data.list.length > 0)
				{
					var html = "";
					
					for(var x in response.data.list)
					{
						var product = response.data.list[x];
						
						html+='<div class="productcol">';
						html+='<div class="productimg">';
						html+='<a href="product.php?prodid='+product.id+'&advertid='+product.advertId+'"><img src="'+product.aw_img+'"></a>';
						html+='</div>';
						html+='<div class="productdesc">';
						html+='<h3 class="textcolor">11'+product.prod_name+'</h3>';
						html+='</div>';
						html+='</div>';
					
					}
					
					$("#divMoreFromSeller .productrow").html(html);
					$("#divMoreFromSeller").fadeIn();
					
				}
			}
		}
	}
}();
