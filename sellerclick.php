<?php
//include "header.php"; 
include "function.php";
$productbuydata = sellerclickadvertdata($_SESSION['advertproductid']);
	
?>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>PaidCash - The UK Cashback Site With A Difference</title>
   <!-- CSS LINK --->
   <link href="css/style.css" rel="stylesheet" type="text/css">
   <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>

<body>
   <div class="sectionone login-sectiontwo loginmyffer_sec purchasemain_sec">
      <!-- Container -->
      <div class="container">
         <p style="text-align: center; padding-top:10%">we won't be a moment... we're just tracking your visit so you can earn cashback with our partner.</p>
         <h2 style="text-align: center; color:green">Simply complete your purchase and we'll do the rest.</h2>
         <a href="/"><img src="images/LOGO.png" alt="" style="height:100px; width:200px;"></a>
         <img src="images/redirecting.gif" alt="" style="height:100px; width:200px;">
         <div class="purchasedata_sec">
            <?php
            foreach ($productbuydata as $getproductbuyrow) {
            ?>
               <div class="sitelogosec border_sec">
                  <a href="/"><img src="images/LOGO.png" alt=""></a>
               </div>
               <div class="rightarrowimag">
                  <img src="images/redirecting.gif" alt="">
               </div>
               <div class="productbuyimg border_sec">
                  <img src="<?php echo $getproductbuyrow['buttonimage']; ?>">
               </div>
               <div class="productbuytxt">
                  <p class="textcenter redirecttxt">If you are not redirect after 3 seconds please continue <a id="continueseller" class="continuelink" href="/"><span id="prodsellername"> <?php echo $getproductbuyrow['name']; ?> </span></a></p>
               </div>
            <?php
            }
            ?>

         </div>
      </div>
      <!-- End Container -->
   </div>
   <!-- [if IE]>-->
   <script src="js/jquery-1.11.3.min.js"></script>
   <script src="js/main.js"></script>
   <script src="js/bootstrap.min.js"></script>
   <script>
      $(document).ready(function() {
         var producturl = sessionStorage.getItem('sellerbuyurl');
         window.setTimeout(function() {
            window.location.href = producturl;
         }, 3000);
      });
   </script>
</body>

</html>