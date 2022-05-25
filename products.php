<?php
include_once('function.php');

$scriptsList[] = '<script src="js/home.js" type="text/javascript"></script> ';
$jScript = "<script>$(document).ready(function(){";
$jScript .= "Home.Common.Init();";
$jScript .= "});";
$jScript .= "</script>";

//count products
$qp = "SELECT id FROM products";
$qpa = mysqli_query($conn, $qp);
$qpn = mysqli_num_rows($qpa);

// count clicks
$qc = "SELECT * FROM click";
$qpc = mysqli_query($conn, $qc);
$qpcn = mysqli_num_rows($qpc);

// count users
$qu = "SELECT * FROM users";
$qpu = mysqli_query($conn, $qu);
$qpun = mysqli_num_rows($qpu);

?>

<?php include 'header1.php'; ?>


<section class="banner">
  <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="images/slider-section.jpg" class="d-block cus-wh" alt="...">
        <div class="carousel-caption cus-carousel d-none d-md-block">
          <h5>SHOP ONLINE FOR TOP BRANDS<br> FOR A CAUSE, HELP US MAKE EUROPE GREEN.</h5>
          <p>Every time you buy at our partner stores and brands<br> we get a portion of their profit margin to plant<br> a tree across coutryside in UK.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/slider-section.jpg" class="d-block cus-wh" alt="...">
        <div class="carousel-caption cus-carousel d-none d-md-block">
          <h5>SHOP ONLINE FOR TOP BRANDS<br> FOR A CAUSE, HELP US MAKE EUROPE GREEN.</h5>
          <p>Every time you buy at our partner stores and brands<br> we get a portion of their profit margin to plant<br> a tree across coutryside in UK.</p>
        </div>
      </div>
      <div class="carousel-item">
        <img src="images/slider-section.jpg" class="d-block cus-wh" alt="...">
        <div class="carousel-caption cus-carousel d-none d-md-block">
          <h5>SHOP ONLINE FOR TOP BRANDS<br> FOR A CAUSE, HELP US MAKE EUROPE GREEN.</h5>
          <p>Every time you buy at our partner stores and brands<br> we get a portion of their profit margin to plant<br> a tree across coutryside in UK.</p>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
</section>
<section class="partner-info">
  <div class="container">
    <div class="row d-flex justify-content-center">
      <div class="col-md-8">
        <div class="search">
          <form class="search-container">
            <input type="text" id="search-bar" placeholder="WHAT WOULD YOU LIKE TO BUY? SEARCHH FOR STRORES">
            <a href="#">
              <div class="search-icon"><i class="fas fa-search"></i></div>
            </a>
          </form>
        </div>
      </div>
    </div>
   <h1>Products</h1>
</div>
      </div>


    </div>
  </div>
</section>
<!-- <section class="partner-name pt-35">


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