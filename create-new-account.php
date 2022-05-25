<?php

include_once 'connect.php';
$message="";

extract($_POST);
$sql="SELECT * FROM register WHERE email=$email";
$result=mysqli_query($conn,$sql);

if(mysqli_num_rows($result)>0)
{
  $message="<center><div class='alert alert-success col-md-4'>Email Id Already Exists</div></center>"; 
	exit;
}

if(isset($_POST['save']))
{	 
	 $first_name = $_POST['first_name'];
	 $last_name = $_POST['last_name'];
	 $email = $_POST['email'];
   $phone = $_POST['phone'];
   $password =md5($_POST['password']);
   $address = $_POST['address'];
   date_default_timezone_set("Asia/karachi");
   $insertdate = date("Y-m-d H:i:s");

	 $sql = "INSERT INTO register (first_name,last_name,email,phone,password,address,datetime)
	 VALUES ('$first_name','$last_name','$email','$phone','$password','$address','$insertdate')";

	 if (mysqli_query($conn, $sql)) {
		$message="<center><div class='alert alert-success col-md-4'>Register Successfully !</div></center>";
    header("location:login.php");
	 } else {
		$message="<div class='alert alert-danger'>Error: " . $sql . "</div>
" . mysqli_error($conn);
	 }
	 mysqli_close($conn);
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
        <div class="accout-logo pb-3 text-center">
          <div class=""><img src="images/LOGO.png" alt=""></div>
        </div>
        <div class="message" align="center">
        <?php if($message!="") { echo $message; } ?>
    </div>
        <div class="row justify-content-center align-items-center"> 
          <div class="col-md-8">
            <form method="POST" action="create-new-account.php" class="new-account">
              <h2 class="text-center mb-3">CREATE NEW ACCOUNT</h2>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">First Name</label>
                    <input type="text" class="form-control form-input" name="first_name" placeholder="First Name" required >
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Email Address</label>
                    <input type="email" class="form-control form-input" name="email" placeholder="abc@example " required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Password</label>
                    <input type="password" class="form-control form-input" name="password" placeholder="*******" required>
                  </div>
                  <!-- <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Address</label>
                    <input type="email" class="form-control form-input" placeholder="Enter the Current Address" required>
                  </div> -->
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Last Name</label>
                    <input type="text" class="form-control form-input" name="last_name" placeholder="last_name" required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Phone No.</label>
                    <input type="text" class="form-control form-input" name="phone" placeholder="+91 915XXX5482" required>
                  </div>
                  <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Address</label>
                    <input type="text" class="form-control form-input" name="address" placeholder="Enter the Current Address" required>
                  </div>

                  <!-- <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label account-labal">Gender</label><br>
                    <input type="radio" name="gender" id=""> Male
                    <input type="radio" name="gender" id=""> Female
                  </div> -->
                </div>
                <label class="form-check-label" style="color: white;"><input type="checkbox" required="required"> Agree with the terms and conditions.</label><br><br>
                <div class="col-md-12"><input type="submit" name="save" class="btn btn-account" value="Create an Account"></div>
              </div><br>
              <div class="text-center" ><a href="login.php" style="color: white;">Sign In</a></div>
            </form>
          </div>
        </div>
      </div>
    </section>
