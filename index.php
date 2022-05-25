<?php
include_once('function.php');
include_once('connect.php');
$scriptsList[] = '<script src="js/home.js" type="text/javascript"></script> ';
	$jScript = "<script>$(document).ready(function(){";
	$jScript.="Home.Common.Init();";
	$jScript.= "});";
	$jScript.= "</script>";
  
//count products
$qp = "SELECT id FROM products";
$qpa = mysqli_query($conn,$qp);
$qpn = mysqli_num_rows($qpa);

// count clicks
$qc = "SELECT * FROM click";
$qpc = mysqli_query($conn,$qc);
$qpcn = mysqli_num_rows($qpc);

// count users
$qu = "SELECT * FROM users";
$qpu = mysqli_query($conn,$qu);
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
                <input type="text" id="search-bar" class="search-input" placeholder="WHAT WOULD YOU LIKE TO BUY? SEARCH FOR STORES">
                <a href="#"><div class="search-icon"><i class="fas fa-search"></i></div></a>
              </form>
            </div>
          </div>
        </div>
        <?php 
    	$result = mysqli_query($conn, "SELECT * FROM advert WHERE status=1  order by id  ASC limit 10");
      ?>
        <div class="row">
          <div class="col-md-12">
            <div class="ethical-text text-center mb-5">
              <h2>Ethical / sustainable stores & brands</h2>
              <div class="divider-title text-center" style="background: #6bb42f;"><span class="span-1" style="background: #6bb42f;"></span></div>
              <p>Although, it's best to shop as little as possible, some shops & brands try to make<br> a true difference.</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="view-text text-start">
              <h4>Our Partnerd Shops</h4>
              <p>Browse <?php echo mysqli_num_rows($result) ?> shops</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="view-btn text-end">
              <a href="viewAllpartner.php" type="button" class="btn btn-view">View All Partnered Shops</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="partner-name pt-35">

    <div id="divTopOffers" class="main">
    <div class="container bg-gry">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex justify-content-center">
         
 

    <?php 
    
     

      while($row = mysqli_fetch_array($result))
        {
          
         $show='
      <div class="col">
            <div class="partner-card">';
            if($row['pay_out']!=''){

              $show.='<div class="flat-code">

              <span class="off">FLAT '.$row['pay_out'].'</span><i class="fas fa-caret-right"></i>
              </div><br>';
            }

              $show.='<div class="partner-img"><a href="company.php?id='.$row['id'].'"><img src='.$row['buttonimage'].' alt=""></a></div>
              <strong style="color:green" class="title">'.$row['companyname'].'</strong>
              <button type="button" class="btn btn-outline-chashback title">'.substr($row['smalldesc'],0,100).'<i class="fas fa-caret-right"></i></button>
              <a href="company.php?id='.$row['id'].'" class="terms">View</a>
            </div>
          </div>'
      ;
      echo $show;
        }
    ?>
        </div></div>
      </div>
    </section>
    <section class="work py-35">
      <div class="container">
         <div class="mb-5">
            <h2 class="common-h2">HOW IT WORKS</h2>
            <div class="divider-title text-center" style="background: #6bb42f;"><span class="span-1" style="background: #6bb42f;"></span></div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="work-detail-one d-flex justify-content-center">
              <div class="sec-one">
                <div class="sec-tow-img"><img src="images/hexagon.png" alt=""></div>
              </div>
              <div class="work-content ms-4">
                <div class="sec-tow-img w-150"><img src="images/search-icon.png" alt=""></div>
                <p class="content">Search for <span class=""style="color:#9cc042;">the store</span><br>you would like to shop.</p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="work-detail-two d-flex justify-content-center mt-100">
              <div class="sec-one">
                <img src="images/hexagon2.png" alt="">
              </div>
              <div class="sec-two ms-4">
                <div class="sec-tow-img w-150"><img src="images/online-shoping.png" alt=""></div>
                <p class="content">Click and open <span class=""style="color:#9cc042;">the online store of<br> Use chrome extension to<br> select the store</span></p>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="work-detail-one p-43 d-flex justify-content-center">
              <div class="sec-one">
                <div class="sec-tow-img"><img src="images/hexagon3.png" alt=""></div>
              </div>
              <div class="work-content2 ms-4">
                <div class="sec-tow-img w-150"><img src="images/store-image.png" alt=""></div>
                <p class="content">You need not to <span class=""style="color:#9cc042;">pay anything.</span><br>
                For every purchase you<br>
                make successfully, we<br>
                receive a portion of<br>
                profit to buy plants<br>
                and get these Planted<br>
                across various locations
                </p>
              </div>
            </div>
          </div>
          <!--<div class="col-md-6">-->
          <!--  <div class="work-detail-three d-flex justify-content-center">-->
          <!--    <div class="sec-one">-->
          <!--      <img src="images/hexagon3.png" alt="">-->
          <!--    </div>-->
          <!--    <div class="work-content2 ms-4">-->
          <!--      <div class="sec-tow-img w-150"><img src="images/store-image.png" alt=""></div>-->
          <!--      <p class="content"><span class=""style="color:#9cc042;">-->
          <!--        You need not to pay anything. For every purchase you<br>-->
          <!--        make successfully, we receive a portion of<br>-->
          <!--        profit to buy plants and get these Planted<br>-->
          <!--        across various locations</span>-->
          <!--        </p>-->
          <!--    </div>-->
          <!--  </div>-->
          <!--</div>-->
          <div class="col-md-6">
            <div class="work-detail-four d-flex justify-content-center mt-100">
              <div class="sec-one">
                <img src="images/hexagon4.png" alt="">
              </div>
              <div class="work-content3 ms-4">
                <div class="sec-tow-img w-70"><img src="images/tree-image.png" alt=""></div>
                <p class="content">Click and open <span class=""style="color:#9cc042;">the online store of<br> Use chrome extension to<br> select the store</span></p>
              </div>
            </div>
          </div>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-md-7">
            <div class="help-sec text-center">
              <div class="help-sec2">
                <h2 class="help">You can also help us plant a tree by buying directly from us.</h2>
                <button type="button" class="btn btn-buy2 mt-3">Buy Plants <i class="fas fa-long-arrow-alt-right"></i></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="comp-details">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="details-card d-flex mb-4">
              <div class="details-img d-flex justify-content-center align-items-center"><img src="images/plant.png" alt=""></div>
              <div class="details-text ms-4">
                <h4>Plants we planted</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <span class="num">1000 +</span>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="details-card d-flex mb-4">
              <div class="details-img d-flex justify-content-center align-items-center"><img src="images/sale.png" alt=""></div>
              <div class="details-text ms-4">
                <h4>Plants we planted</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <span class="num">1000 +</span>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="details-card d-flex mb-4">
              <div class="details-img d-flex justify-content-center align-items-center"><img src="images/store.png" alt=""></div>
              <div class="details-text ms-4">
                <h4>Plants we planted</h4>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <span class="num">1000 +</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="tree-with-us">
      <div class="container">
        <div class="row">
          <div class="col-md-7">
            <div class="planting-sec d-flex align-items-center h-100">
              <div class="df">
                <h2><span class="gre">PLANT EUROPE GREEN BY</span><br> PLANTEING A TREE WITH US</h2>
                <button type="button" class="btn btn-buy">Buy Plants <i class="fas fa-long-arrow-alt-right"></i></button>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="tree-img">
              <img src="images/tree.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="location py-35">
      <div class="container">
        <div class="mb-5">
            <h2 class="common-h2">Locations where we have planted</h2>
            <div class="divider-title text-center" style="background: #6bb42f;"><span class="span-1" style="background: #6bb42f;"></span></div>
        </div>
        <div class="row d-flex justify-content-center">
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="location-card">
              <img src="images/location-img.png" alt="">
                <div class="loaction-text">
                  <h4>Tanzanina Agroforestry</h4>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy  text ever since the 1500s</p>
                  <button type="button" class="btn btn-readmore mt-2"> Read More <i class="fas fa-angle-double-right"></i></button>                 
                </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="location-card">
              <img src="images/location1-img.png" alt="">
                <div class="loaction-text">
                  <h4>Tanzanina Agroforestry</h4>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy  text ever since the 1500s</p>
                  <button type="button" class="btn btn-readmore mt-2"> Read More <i class="fas fa-angle-double-right"></i></button>                       
                </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="location-card">
              <img src="images/location-img.png" alt="">
                <div class="loaction-text">
                  <h4>Tanzanina Agroforestry</h4>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy  text ever since the 1500s</p>
                  <button type="button" class="btn btn-readmore mt-2"> Read More <i class="fas fa-angle-double-right"></i></button>                       
                </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="location-card">
              <img src="images/location1-img.png" alt="">
                <div class="loaction-text">
                  <h4>Tanzanina Agroforestry</h4>
                  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy  text ever since the 1500s</p>
                  <button type="button" class="btn btn-readmore mt-2"> Read More <i class="fas fa-angle-double-right"></i></button>                       
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="emission-free py-35">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="emission-text text-center">
              <h2>Helping us make Europe Carbon Emission free</h2>
              <p>You can buy any product by our partner brands which help us  with<br> plants for every sale they get through us</p>
              <img src="images/team.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </section>
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

<script>
let searchInput = document.querySelector('.search-input');
searchInput.addEventListener('keyup', search);

// get all title
let titles = document.querySelectorAll('.main .title');
let searchTerm = '';
let tit = '';

function search(e) {
  // get input fieled value and change it to lower case
  searchTerm = e.target.value.toLowerCase();

  titles.forEach((title) => {
    // navigate to p in the title, get its value and change it to lower case
    tit = title.textContent.toLowerCase();
    // it search term not in the title's title hide the title. otherwise, show it.
    tit.includes(searchTerm) ? title.style.display = 'block' : title.style.display = 'none';
  });
}
</script>