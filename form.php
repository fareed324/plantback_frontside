<?php
include 'header2.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Paypal</title>
</head>
<body>
<section class="py-165">
      <div class="container">
        <div class="row">
            <center>
            <!-- <h1 style="color: #0070ba;">Paypal</h1> -->
                       
        <div class="form" >
        <img src="images/paypal.png" alt="" style="height:150px; width:200px;">
        <form action="charge.php" method="post"  class="login-form">
        <input type="text" name="amount" value="<?php echo $_GET['amount']?>"  />
        <!-- <input type="submit" name="submit" value="Pay Now"> -->
                  <button type="submit" name="submit">Pay Now</button>
                  <p class="message">Not registered? <a href="https://www.paypal.com/signin">Create an account</a></p>
        </form>
        </div>
        </center>
        </div>
      </div>
    </section>
<!-- <form action="charge.php" method="post">
    <input type="text" name="amount" value="20.00" />
    <input type="submit" name="submit" value="Pay Now">
</form> -->

</body>
</html>

<?php include 'footer.php'; ?>