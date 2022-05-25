$(document).ready(function() {
  /************************

Rating load page onclick

************************/

  $(".rattingvote_close img").click(function(e) {
    e.preventDefault();
    location.reload();
  });

  /*****************************

Rating load page onclick End

******************************/

  /************************

show pop up 

************************/
// function navigate(href, newTab) {
//   var a = document.createElement('a');
//   a.href = href;
//   if (newTab) {
//      a.setAttribute('target', '_blank');
//   }
//   a.click();
// }
//   $("#buyproductbtnnn").click(function(e) {
//     e.preventDefault();
//     navigate('www.google.com',true);
//    });

  $("#goproductbtn").click(function(e) {
   e.preventDefault();
   var producturl = JSON.parse(sessionStorage.getItem('productbuyurl'));
    window.open( producturl.url, '_blank');
    //$("#modelpopup").modal("hide");
  });

  $("#buyproductbtn").click(function(e) {
    e.preventDefault();
    var productinsert = $("#buynowform").serializeArray();
    var pathname = window.location.href;
    $.ajax({
      type: "POST",
      url: "ajax.php",
      data: productinsert,
      success: function(response) {
        $("#modelpopup").modal("show");
        sessionStorage.setItem("productbuyurl", response);
        openWindow(pathname);    
      },
      error: function(err) {
        console.log(err);
      }
    });
  });

  function openWindow(pathname){
    var win = window.open("click.php");
    if (win){
      window.focus();
    }
  }

/*****************************

show pop up End

******************************/




/*****************************

check out pop up

******************************/
$("#checkoffermodelpopup").click(function(e) {
  e.preventDefault();
  $("#offermodelpopup").modal("show");
  sellerWindow();    
});

function sellerWindow(){
  var win = window.open("sellerclick.php");
  if (win){
    window.focus();
  }
}


$("#sellerproductbtn").click(function(e) {
  e.preventDefault();
  var sellersiteurl = sessionStorage.getItem('sellerbuyurl');
   window.open( sellersiteurl, '_blank');
 });
 
/*****************************

check out pop up End

******************************/
});
