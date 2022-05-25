<?php
include_once('function.php');

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

<?php include 'header2.php'; ?>


    
    <section class="partner-info">
      <div class="container">
        <div class="row d-flex justify-content-center">
          <div class="col-md-8">
            <div class="search">
              <form class="search-container">
                <input type="text" id="search-bar" placeholder="WHAT WOULD YOU LIKE TO BUY? SEARCHH FOR STRORES">
                <a href="#"><div class="search-icon"><i class="fas fa-search"></i></div></a>
              </form>
            </div>
          </div>
        </div>
        <?php 
    	$result = mysqli_query($conn, "SELECT * FROM advert WHERE status=1  order by id  ASC");
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
              <button type="button" class="btn btn-view">View All Partnered Shops</button>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="partner-name pt-35">

    <div id="divTopOffers">
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

              $show.='<div class="partner-img"><a  href="company.php?id='.$row['id'].'"><img src='.$row['buttonimage'].' alt=""></a></div>
              <strong style="color:green">'.$row['companyname'].'</strong>
              <button type="button" class="btn btn-outline-chashback">'.substr($row['smalldesc'],0,100).'<i class="fas fa-caret-right"></i></button>
              <a href= href="company.php?id='.$row['id'].'" class="terms">View</a>
            </div>
          </div>'
      ;
      echo $show;
        }
    ?>
        </div></div>
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