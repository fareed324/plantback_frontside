<?php
   include 'header2.php'; 
   include_once ('connect.php');
   include_once ('function.php');
?>

<?php 

if ($_GET['action']=='shop'){
  session_start();
  if(isset($_SESSION['first_name'])) {
      header('Location: single-product.php?id='.$_GET['id']);
  }
  else
  {
    header('Location: login.php?id='.$_GET['id']);
  }  
}

	$result = mysqli_query($conn, "SELECT * FROM add_product limit 10");

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $id = NULL;
  }
  $data = mysqli_query($conn, "SELECT * FROM add_product WHERE id = '" . $id . "' order by id  ASC");
?>

    <section class="pt-135">
      <div class="container">
        <h2 class="common-h2 mb-2">Our Products</h2>
        <p class="text-center mb-5">Contrary to popular belief, Lorem Ipsum is not simply random<br> 
          text. It has roots in a piece of classical Latin literature</p>
         

        <div class="row">
          <div class="col-md-12">
            <div class="shop-upper-box d-flex clearfix mb-4">
              <div class="items-label pull-left">Showing <span><?php echo mysqli_num_rows($result) ?></span> Results</div>
              <div class="sort-by pull-right text-end ms-auto">
                <div class="dropdown">
                  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    Default Sorting
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
           <?php 
    
     

      while($row = mysqli_fetch_array($result))
        {
          $_SESSION['name'] = $row['name'];
          $_SESSION['image'] = $row['image'];
         $image_path='https://plantback.co.uk/Admin/upload';
         $show='
          <div class="col-sm-12 col-md-6 col-lg-3">
            <a href="shop.php?action=shop&id='. $row['id'] .'" title="Shop Now" class="pro-links" style="color:black;">
                <div class="products-card mb-4">
                  <div class="pro-img">
                    <img src="'.$image_path.'/'.$row['image'].'" height="160px" width="160px" alt="No Image">
                  </div>
                  <p></p>
                  <div class="pro-text">
                    <h5>'.$row['name'].'</h5>
                    <span>$'.$row['price'].'</span>
                    <ul class="d-flex justify-content-center my-3">
                      <li class="star"><i class="fas fa-star"></i></li>
                      <li class="star"><i class="fas fa-star"></i></li>
                      <li class="star"><i class="fas fa-star"></i></li>
                      <li class="star"><i class="fas fa-star"></i></li>
                      <li class="star"><i class="fas fa-star"></i></li>
                    </ul>
                  </div>
                </div>
            </a>
          </div>';
          echo $show;
         
         
        
      }
        ?>
          
        </div>
      </div>
    </section>
    <section class="py-35">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="styled-pagination text-center">
              <ul class="clearfix">
                  <li class="prev-post"><a href="#"><span class="fa fa-angle-left"></span> Prev</a></li>
                  <li><a href="#">1</a></li>
                  <li class="active"><a href="#">2</a></li>
                  <li><a href="#">3</a></li>
                  <li class="next-post"><a href="#"> Next <span class="fa fa-angle-right"></span> </a></li>
              </ul>
          </div>
          </div>
        </div>
      </div>
    </section>
    <?php include 'footer.php'; ?>

    <script>
    //  localStorage.removeItem('product');
    //  localStorage.clear()
    </script>