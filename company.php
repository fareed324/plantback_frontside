<?php
include_once('function.php');

$scriptsList[] = '<script src="js/home.js" type="text/javascript"></script> ';
$jScript = "<script>$(document).ready(function(){";
$jScript .= "Home.Common.Init();";
$jScript .= "});";
$jScript .= "</script>";


if ($_GET['action']=='seller'){
  session_start();
  if(isset($_SESSION['first_name'])) {
      header('Location: sellerclick.php');
  }
  else
  {
    header('Location: login.php?id='.$_GET['id']);
  }  
}

if ($_GET['action']=='remeber'){
  session_start();
  if(isset($_SESSION['first_name'])) {
      header('Location: company.php?id='.$_GET['id']);
  }
  else
  {
    header('Location: login.php?id='.$_GET['id']);
  }  
}


?>

<?php include 'header2.php'; ?>



<section class="partner-info">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <br><br><br><br><br><br>
      <h2 class="common-h2 mb-2">Our Products</h2>
      <div class="col-md-8">
        <div class="search">
          <form class="search-container">
            <input type="text" id="search-bar" placeholder="WHAT WOULD YOU LIKE TO BUY? SEARCH FOR STORES">
            <a href="#">
              <div class="search-icon"><i class="fas fa-search"></i></div>
            </a>
          </form>
        </div>
      </div>
    </div>
    <?php
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      $id = NULL;
    }
    $result = mysqli_query($conn, "SELECT * FROM advert WHERE id = '" . $id . "' order by id  ASC");
       ?>
    <div class="row">
      <div class="col-md-12">
        <div class="ethical-text text-center mb-5">
      
        
         <?php
      
          
          while ($row = mysqli_fetch_array($result)) {
            $show = ' <div class="products-card mb-4">
      <div class="pro-img"><a href="company.php?id='. $row['id'] . '"><img src=' . $row['buttonimage'] . ' style="height:100px; width:150px;" class="img-responsive" alt=""></a></div><br>
      <a href="company.php?action=seller&id='. $row['id'] .'" target="_blank" type="button" type="button" class="btn btn-danger" aria-expanded="false"> Help Plant a tree (Click Here) </a>
      <!-----<a href="company.php?action=remeber&id='. $row['id'] .'" type="button" class="btn btn-primary" aria-expanded="false"> Remember this PlantBack Offer </a>--->
      </div>
      <div class="products-card mb-4">
		  <h3 style="color:green">Description</h3>
		  <div>' . $row['smalldesc'] . '</div></div>
      <div class="products-card mb-4">
		  <h3 style="color:green">How to Help</h3>
		  <div>' . $row['howearn'] . '</div></div>
      <div class="products-card mb-4">
		  <h3 style="color:green">Company Details</h3>
		  <div>' . $row['product'] . '</div></div>
      <div class="products-card mb-4">
		  <h3 style="color:green">Plant Back Will Be Recieve</h3>
		  <div>' . $row['pay_out'] . '</div></div>
      <!-----<div><a href="login.php" class="btn btn-warning">Sign Up</a> to see what your friends like.</div><br>---->
		  <div><img src=' . $row['bannerimage'] . ' style="height:100px; width:700px;" alt=""></div>';

            echo $show;
            break;
          }
          #products 
        //   echo "<br><h2 style='color:green'><u>Latest products from the Seller</u></h2><br>";
        //   $result = mysqli_query($conn, "SELECT * FROM products WHERE advertId='" . $_GET['id'] . "' order by id  ASC");
          
        //   $counter=1;
        //  if(mysqli_num_rows($result) <= 0)
        //  {
        //   echo '<center><h3 style="color:red">No products available</h3></center>';

        //  }
        //  else{
        //  echo "<div class='row'>" ;
        //   while ($row = mysqli_fetch_array($result)) {
           
        //     if($counter % 3 == 0 || $counter==mysqli_num_rows($result))
        //     {
                

        //       $show ="<div class='col-sm-3 col-md-3 col-lg-3' >
        //             <a href='company.php?id=" . $row['aw_id'] . "' class='pro-links' style='color:black;'>
        //                 <div class='products-card mb-4' >
        //                   <div class='pro-img'>
        //                   <img src='" . $row['aw_img'] . "' alt=''>
        //                   </div>
        //                   <div class='pro-text'><p></p>
        //                     <h5 style='color:green;'>'" . $row['prod_name'] . "'</h5>  
        //                   </div>
        //                 </div>
        //               </a>
        //             </div>";

        //     echo $show;
              
            				
        //     }  $counter++;	
        //   }
          
        //   echo "</div>";
      
      
         // }
        
          ?>
           </div>
      </div>


    </div>
  </div>
</section>
<!-- <section class="partner-name pt-35">

// <a  data-advertid="'.$row['id'].'" href="https://'.$_SERVER['HTTP_HOST'].'//login.php?redirect='.base64_encode($_SERVER['REQUEST_URI']).' "  type="button" class="btn btn-danger" aria-expanded="false"> Check Out This Plant Back Offer Now </a>


    <div id="divTopOffers">
    <div class="container bg-gry">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex justify-content-center">
         
 

    
        </div></div>
      </div>

    </section> -->


<section class="ftr-wedget">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-md-8">
        <h4 class="ftr-text">A free Chrome-extension where you shop at one of the 50,000+ shops
          and buying same price.</h4>
        <button type="button" class="btn btnchrome mt-3">Download Now For Chrome <img src="images/arrow.png" alt=""></button>
      </div>
    </div>
  </div>
</section>


<?php include 'footer.php'; ?>