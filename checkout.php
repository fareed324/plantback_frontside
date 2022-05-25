<?php
 include 'header2.php'; 
 include_once ('connect.php');
 include_once ('function.php');
session_start();
 if(isset($_POST['save']))
{
   $first_name = $_POST['first_name'];
	 $last_name = $_POST['last_name'];
	 $company_name = $_POST['company_name'];
   $country = $_POST['country'];
   $address = $_POST['address'];
   $city = $_POST['city'];
   $state = $_POST['state'];
   $zip = $_POST['zip'];
   $phone = $_POST['phone'];
   $amount = $_GET['amount'];
   $payment_method = $_POST['payment'];
   $insertdate = date("Y-m-d H:i:s");
   
   if($payment_method=="PayPal"){
    redirect_page('form.php?amount='.$_GET['amount']);
  }
    $sql = "INSERT INTO billing_details (first_name,last_name,company_name,country,address,city,state,zip,phone,amount,payment_method,datetime)
    VALUES ('$first_name','$last_name','$company_name','$country','$address','$city','$state','$zip','$phone','$amount','$payment_method','$insertdate')";
}
if (mysqli_query($conn, $sql)) 
 {
  header('Location:thank-you.php');
 }
  else {
  $message="<div class='alert alert-danger'>Error: " . $sql . "</div>" . mysqli_error($conn);
 }
 mysqli_close($conn);


?>
    <section class="pt-135 pb-5">
      <div class="container">
      <form action="#" method="POST">
        <div class="row">
          <div class="col-md-12 col-lg-7 shopping-cart">
            <div class="shoppingcart">
              <h5 class="main-title">Billing Details</h5>
            </div>
           
            <div class="row"> 
              <div class="col-md-6">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">First Name*</label>
                  <input type="name" name="first_name" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">Last Name*</label>
                  <input type="name" name="last_name" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">Company Name (optional)</label>
                  <input type="name" name="company_name" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-4">
                  <select id="country" class="form-control cus-form-control" name="country" required>
                    <option value="Afganistan">Afghanistan</option>
                    <option value="Pakistan">Pakistan</option>
                    <option value="Algeria">Algeria</option>
                    <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                    <option value="Yemen">Yemen</option>
                    <option value="Zaire">Zaire</option>
                    <option value="Zambia">Zambia</option>
                    <option value="Zimbabwe">Zimbabwe</option>
                  </select>
                </div>
              </div>
              <div class="col-md-12">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">Address*</label>
                  <input type="name" name="address" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="Address House number and street name">
                </div>
                <!-- <div class="mb-4">
                  <input type="name" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="Apartment, suite, unit, etc. (optional)">
                </div> -->
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">Town/City*</label>
                  <input type="name" name="city" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">State*</label>
                  <input type="name" name="state" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">ZIP*</label>
                  <input type="name" name="zip" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-4">
                  <label for="exampleFormControlInput1" class="form-label">Phone*</label>
                  <input type="name" name="phone" class="form-control cus-form-control" id="exampleFormControlInput1" required placeholder="">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12 col-lg-5 ps-0">
            <div class="sub-totle-info">
              <h5 class="main-title">Order Reivew</h5>
              <ul>
              <li class="cart-li border-0">
                 <!-- <img class="order" src="images/pro1.png" alt=""> -->
                 <!-- <p class="price">$<?php echo $_GET['amount']; ?></p> -->
              </li>
              <li class="cart-li cus-brdr">
                <h6>Sub Total</h6>
                <b>$<?php echo $_GET['amount']; ?></b>
              </li>
              <!-- <li class="cart-li border-0">
              <h6>Order Total</h6>
              <p>$ <?php echo $_GET['amount']; ?></p>
            </li> -->
                
                <li class="cart-li d-block border-0" >
                  <h6 class="payment-method">Payment Method</h6>
                  <div class="form-check mb-4">
                    <input class="form-check-input" type="radio" name="payment" value="Cash on delivery" required id="flexCheckDefault">
                    <label class="form-check-label" for="flexCheckDefault">
                      Cash on delivery
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="payment" value="PayPal" required id="flexCheckChecked" >
                    <label class="form-check-label" for="flexCheckChecked">
                      PayPal <img src="images/payment.png" alt="">
                    </label>
                  </div>
                 
                </li>
                <li class="cart-li border-0">
                  <input type="submit" name="save" class="btn btn-checkout" value="Place Order">
                </li>
              </ul>
          
            </div>
          </div>
        </div>
      </form>
      </div>
    </section>
      
    <?php include 'footer.php'; ?>