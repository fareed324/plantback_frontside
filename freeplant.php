<?php include 'header2.php'; ?>
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

    <?php include 'footer.php'; ?>