<?php 
include 'connect.php';
session_start();
$message="";
if(isset($_POST["save"]))
{
    $email = $_POST['email'];
    $password =  md5($_POST['password']);

    $query="SELECT * FROM register WHERE email='".$email."' and password='".$password."'";
    $resultset=mysqli_query($conn,$query);

    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      $id = NULL;
    }
    
   
    if(mysqli_num_rows($resultset) > 0 ){
        $row=mysqli_fetch_assoc($resultset); 
        $_SESSION['id'] = $row['id']; 
        $_SESSION['first_name'] = $row['first_name'];  
        $_SESSION['last_name'] = $row['last_name'];  
        
        header("Location:company.php?id=".$id);
        
    }

    else
    {
        $message="<center><span class='alert alert-danger col-md-4'>Invalid Username or Password! </span></center>";
    }
#shop
    $query="SELECT * FROM add_cart";
    $result=mysqli_query($conn,$query);

    if(mysqli_num_rows($result) > 0 ){
      $row=mysqli_fetch_assoc($result); 
      $_SESSION['user_id'] = $row['user_id']; 
     
      
      header("Location:shop.php?id=".$id);
      
  }

}
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="owl/owl.carousel.min.css?v=2">
	<link rel="stylesheet" href="owl/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/responsive.css">
    
    <section class="login py-100">
      <div class="container">
        <div class="row justify-content-center align-items-center">
          <div class="col-md-3">
            <img src="images/LOGO.png" alt="">
          </div>
          <div class="col-md-5">
            <div class="login-page">
            <div class="message" align="center">
                  <?php if($message!="") { echo $message; } ?>
              </div>
              <div class="form">
                <form  class="register-form">
                  <input type="text" placeholder="name"/>
                  <input type="password" placeholder="password"/>
                  <input type="text" placeholder="email address"/>
                  <button>create</button>
                  <p class="message">Already registered? <a href="#">Sign In</a></p>
                </form>
                
                <form action="" method="post"  class="login-form">
                  <input type="text" placeholder="username" name="email" required/>
                  <input type="password" placeholder="password" name="password" required/>
                  <button type="submit" name="save">login</button>
                  <p class="message">Not registered? <a href="create-new-account.php">Create an account</a></p>
                </form>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </section>