<?php 

include "connect.php";
session_start();

// echo $_SESSION["first_name"];

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/x-icon" href="images/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
		<link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <title>Plantback</title>
  </head>
  <body>
    <div class="main_header">
      <nav class="navbar navbar-expand-lg">
        <div class="container">
          <a class="navbar-brand logo" href="index.php"><img src="images/LOGO.png" alt=""></a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"><img src="images/menu.png" alt=""></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
              <li class="nav-item cus-item me-4">
                <a class="nav-link cus-link active" aria-current="page" href="index.php">HOME</a>
              </li>
              <li class="nav-item cus-item me-4">
                <a class="nav-link cus-link" href="about.php">ABOUT US</a>
              </li>
              <li class="nav-item cus-item me-4">
                <a class="nav-link cus-link" href="shop.php">SHOP</a>
              </li>
              <li class="nav-item cus-item me-4">
                <a class="nav-link cus-link" href="freeplant.php">FREE PLANTS</a>
              </li>
              <li class="nav-item cus-item me-4">
                <a class="nav-link cus-link" href="contact-us.php">CONTACT US</a>
              </li>
              <li class="nav-item cus-item me-4">
                <a class="bag-icon" href="cart.php"><img src="images/bag.png" alt=""> 
                <span class="one" >
                  <?php
                  $id=$_SESSION['id'];
                $result = mysqli_query($conn, "SELECT * FROM add_cart where user_id=$id");
                echo mysqli_num_rows($result);
                ?>
                </span>
              </a>
              </li>
              <li class="nav-item cus-item">
              <b style="color: white;"><?php echo $_SESSION["first_name"] ?>
               <?php 
               //echo $_SESSION['user_id']
                ?> </b>

                <a class="user-icon" href="delete_logout.php?userid=<?php echo $_SESSION['user_id'] ?>">
                  <img src="images/user.png" alt=""></a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
    