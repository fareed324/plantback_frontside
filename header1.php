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
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="owl/owl.carousel.min.css?v=2">
	<link rel="stylesheet" href="owl/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <title>Plantback</title>
  </head>
  <body>
      <div class="main_header bg-transparent">
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
                      <a class="bag-icon" href="cart.php"><img src="images/bag.png" alt=""> <span class="one"></span></a>
                    </li>
                    <li class="nav-item cus-item">
                    <b style="color: white;"><?php echo $_SESSION["first_name"] ?> <?php echo $_SESSION["last_name"] ?></b>
                      <a class="user-icon" href="login.php"><img src="images/user.png" alt=""></a>
                    </li>
                  </ul>
                </div>
              </div>
            </nav>
          </div>