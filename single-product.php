<?php 
  include 'header2.php';
  include_once ('connect.php');
  include_once ('function.php');

 session_start();
// echo $_SESSION['name'];
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      $id = NULL;
    }
    $query = mysqli_query($conn, "SELECT * FROM add_product WHERE id = ". $id ." order by id  ASC");
    $result=mysqli_fetch_object($query);
     
   if(isset($_POST['save']))
{
  $user_id = $_SESSION['id'];
  $image = $result->image;
  $name = $result->name;
  $price = $result->price;
  $quantity = $_POST['quantity'];
  $total=$price*$quantity;
 
  $insertdate = date("Y-m-d H:i:s");
    $sql = "INSERT INTO add_cart (user_id,image,name,price,quantity,total,datetime)
    VALUES ('$user_id','$image','$name','$price','$quantity','$total','$insertdate')";
}
if (mysqli_query($conn, $sql)) {

  header("location:shop.php");
 }
  else {
  $message="<div class='alert alert-danger'>Error: " . $sql . "</div>" . mysqli_error($conn);
 }
 mysqli_close($conn);
     ?>

    <section class="pt-135">
      <div class="container">
        
        <div class="row">
          <div class="col-md-12">
            <div class="row">
              <div class="col-md-5">
                <div class="tab-content" id="pills-tabContent">
                  <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                    <div class="mag">
      
                      <div class="tree-zoom">
                        <img data-toggle="magnify" name="image" src="https://plantback.co.uk/Admin/upload/<?php echo $result->image; ?>" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="mag">
                      <div class="tree-zoom">
                        <img data-toggle="magnify" src="images/product-06.jpg" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="mag">
                      <div class="tree-zoom">
                        <img data-toggle="magnify" src="images/product-07.jpg" alt="">
                      </div>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                    <div class="mag">
                      <div class="tree-zoom">
                        <img data-toggle="magnify" src="images/product-08.jpg" alt="">
                      </div>
                    </div>
                  </div>
                </div>
                <ul class="nav nav-pills justify-content-center" id="pills-tab" role="tablist">
                  <li class="nav-item me-3" role="presentation">
                    <button class="nav-link cus-nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true"><img src="images/nav.png" alt=""></button>
                  </li>
                  <li class="nav-item me-3" role="presentation">
                    <button class="nav-link cus-nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><img src="images/nav1.png" alt=""></button>
                  </li>
                  <li class="nav-item me-0" role="presentation">
                    <button class="nav-link cus-nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false"><img src="images/nav2.png" alt=""></button>
                  </li>
                </ul>
              </div>
              <div class="col-md-7">
                <div class="tree-content mx-5">
                  <h3 name="name"><?php echo $result->name ?></h3>
                  <span class="tree-span" name="price">$<?php echo $result->price ?></span>
                  <ul class="d-flex my-3">
                    <li class="star"><i class="fas fa-star"></i></li>
                    <li class="star"><i class="fas fa-star"></i></li>
                    <li class="star"><i class="fas fa-star"></i></li>
                    <li class="star"><i class="fas fa-star"></i></li>
                    <li class="star"><i class="fas fa-star"></i></li>
                    <li class=""><p>(1 REVIEW)</p></li>
                  </ul>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisic elit,
                    sed do eiusmod tempo incid ut labore et dolore magna 
                    aliqua. Ut enim ad minim veniam, quis nostru exercitation 
                    Duis aute irure dolor in reprehenderit in voluptate
                  </p>
                  <div class="my-3">
                    <label for="exampleFormControlInput1" class="form-label">ORDER LOCATION *</label>
                    <input type="location" class="form-control" id="exampleFormControlInput1" placeholder="">
                  </div>
                  <div class="add-to-cart d-flex mt-34">
                      <form id='myform' method='POST' class='quantity me-3' action='#'>
                        <input type='button' value='-'  onclick="Subs()" class='qtyminus minus' field='quantity' />
                        <input type='text' id="quantity" name="quantity"  value="0" min="1"  class='qty' />
                        <input type='button' onclick="Add()" value='+' class='qtyplus plus' field='quantity' />
                        <button type="submit" name="save" class="btn btn-add bg-grn m">Add to Cart</button>
                      </form>
                      <!-- <a href="shop.php?id=<?php echo $result->id ?>" type='button' class="btn btn-add bg-grn m">Add to cart</a> -->
                    
                      <button class="btn btn-add w-49 me-3"><i class="fas fa-heart"></i></button>
                      <button class="btn btn-add w-49 me-3"><i class="fas fa-search"></i></button>
                  </div>
                  <div class="shipping-sec">
                    <ul class="d-flex justify-content-between">
                      <li class="d-flex me-2">
                        <div class="shipping-img me-2"><img src="images/truck.png" alt=""></div>
                        <p>Free<br>
                          Shipping</p>
                      </li>
                      <li class="d-flex me-2">
                        <div class="shipping-img me-2"><img src="images/card.png" alt=""></div>
                        <p>Safe<br>   
                          Payment</p>
                      </li>
                      <li class="d-flex">
                        <div class="shipping-img me-2"><img src="images/heartcards.png" alt=""></div>
                        <p>Free<br>
                          Shipping</p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-12">
            <div class="dff d-flex mt-4">
              <div class="col-md-5">

              </div>
              <div class="col-md-7">
                <div class="Category-txt mx-5">
                  <p><span class="me-2"style="color: #959595;">Category: </span>Free plants</p>
                  <p><span class="me-2"style="color: #959595;">Tags: </span>philosophy, photo</p>
                  <p>
                    <span class="me-2"style="color: #959595;">Share: </span>
                    <span class="me-2"><i class="fab fa-pinterest-p"></i></span>
                    <span class="me-2"><i class="fab fa-twitter"></i></span>
                    <span class="me-2"><i class="fab fa-facebook-f"></i></span>
                    <span class="me-2"><i class="fab fa-instagram"></i></span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="mt-100">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <ul class="nav pb-1 mb-3 nav-tabs" id="myTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link border-0 ps-0 active" id="Description-tab" data-bs-toggle="tab" data-bs-target="#Description" type="button" role="tab" aria-controls="Description" aria-selected="true">Description</button>
              </li>
              <li class="nav-item disabled" role="presentation">
                <a class="nav-link border-0 ps-0 disabled col-lit-gry" href="#" tabindex="-1" aria-disabled="true"> Reviews (0)</a>
              </li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade show active" id="Description" role="tabpanel" aria-labelledby="Description-tab">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam fringilla augue nec est tristique auctor. Donec non est at libero 
                  vulputate rutrum. Morbi ornare lectus quis justo gravida semper. Nulla tellus mi, vulputate adipiscing cursus eu, suscipit id 
                  nulla. Donec a neque libero.</p>
                  <br>
                  <p>
                    Pellentesque aliquet, sem eget laoreet ultrices, ipsum metus feugiat sem, quis fermentum turpis eros eget velit. Donec ac 
                    tempus ante. Fusce ultricies massa massa. Fusce aliquam, purus eget sagittis vulputate, sapien libero hendrerit est, sed 
                    commodo augue nisi non neque. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed tempor, lorem et placerat 
                    vestibulum, metus nisi posuere nisl, in accumsan elit odio quis mi.
                </p>
              </div>
              <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">...</div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <section class="my-50">
      <div class="container">
        <div class="row">
            <h2 class="common-h2 mb-2">RELATED PRODUCTS</h2>
            <p class="text-center mb-5">Contrary to popular belief, Lorem Ipsum is not simply random<br> 
              text. It has roots in a piece of classical Latin literature</p>
        <div class="owl-carousel owl-theme">
          <div class="item">
            <div class="products-card">
              <div class="pro-img">
                <img src="images/slider (1).jpg" alt="">
              </div>
              <div class="pro-text">
                <h5>American  Marigold</h5>
                <span>$23.45</span>
                <ul class="d-flex justify-content-center my-3">
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="products-card">
              <div class="pro-img">
                <img src="images/slider (2).jpg" alt="">
              </div>
              <div class="pro-text">
                <h5>American  Marigold</h5>
                <span>$23.45</span>
                <ul class="d-flex justify-content-center my-3">
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="products-card">
              <div class="pro-img">
                <img src="images/slider (3).jpg" alt="">
              </div>
              <div class="pro-text">
                <h5>American  Marigold</h5>
                <span>$23.45</span>
                <ul class="d-flex justify-content-center my-3">
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="products-card">
              <div class="pro-img">
                <img src="images/slider (4).jpg" alt="">
              </div>
              <div class="pro-text">
                <h5>American  Marigold</h5>
                <span>$23.45</span>
                <ul class="d-flex justify-content-center my-3">
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="products-card">
              <div class="pro-img">
                <img src="images/slider (2).jpg" alt="">
              </div>
              <div class="pro-text">
                <h5>American  Marigold</h5>
                <span>$23.45</span>
                <ul class="d-flex justify-content-center my-3">
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                  <li class="star"><i class="fas fa-star"></i></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
   
    <?php include 'footer.php'; ?>

    <?php
   
    // $data=$result;
?>

   
<!-- <script type="text/javascript">
   $(document).ready(function(){
console.log("Ready");
  });
    let newValue=0;
    let intialValue=0;

    var product = <?php echo json_encode($data); ?>;
    const data=[];
    
    console.log("Data Fetch Query",product);
 
     //get= JSON.parse(localStorage.getItem('product'));
 //console.log("dtatatat",get);
    // get.push(product);
    data.push(product);
  function Add(){

 localStorage.setItem('product',JSON.stringify(data));
 console.log("products session",product);
  //----------------Add---------------------//  
    intialValue =  parseInt($('#quantity').val());
    console.log("intialValue",parseInt(intialValue)+1);
    console.log("added value",intialValue+1);

    localStorage.setItem('quantity',parseInt(intialValue)+1);
  }
  function Subs(){

    intialValue =  parseInt($('#quantity').val());
    console.log("intialValue",parseInt(intialValue)-1);
    console.log("added value",intialValue-1);
    
  }
</script> -->