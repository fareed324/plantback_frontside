<?php 
  include 'header2.php';
  include_once ('connect.php');
  include_once ('function.php');

session_start();
    if (isset($_GET['id'])) {
      $id = $_GET['id'];
    } else {
      $id = NULL;
    }
    $id=$_SESSION['id'];
    $result = mysqli_query($conn, "SELECT * FROM add_cart where user_id=$id");
    print_r($result);

   
     ?>

 <section class="pt-135 pb-5">
      <div class="container">
        <div class="row">
          <div class="col-md-12 col-lg-8">
            <div class="table-wrap">
                <table class="table table-responsive table-borderless">
                    <thead class="cus-thead">
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>total</th>
                        <th>&nbsp;</th>
                    </thead>
                    <tbody >
                      <?php
                      
                      while($row = mysqli_fetch_array($result))
                      {
                        $total=$row['quantity'] * $row['price'];
                     $show='<tr class="align-middle alert border-bottom" role="alert">
                     <td> <input type="checkbox" id="check"> </td>
                     <td class="text-center"> <img class="pic" src="https://plantback.co.uk/Admin/upload/'.$row['image'].'" alt=""> </td>
                     <td>
                         <div>
                             <p class="m-0 fw-bold">Lorem Ipsum is simply dummy.</p>
                             <p class="m-0 text-muted">Text of the printing and typesetting industry.</p>
                         </div>
                     </td>
                     <td>
                         <div class="fw-600">$'.$row['price'].'</div>
                     </td>
                     <td class="d-"> <input class="input" type="text" value="'.$row['quantity'].'"> </td>
                     <td> $ '.$total.' </td>
                     <td>
                         <div class="btn" >
                         <a href="delete-process.php?id='.$row["id"].'"> 
                         <span class="fas fa-times"></span>
                         </a>
                         </div>
                     </td>
                 </tr>';
                 echo $show;
                      }
                 ?>
                     
                    </tbody>
                </table>
            </div>
          </div>
          <div class="col-md-12 col-lg-4 ps-0">
            <div class="sub-totle-info2">
              <h5 class="main-title">Cart totals</h5>
              <ul>
                <li class="cart-li cus-brdr">
                  <h6>Sub Total</h6>
                  <p>
                 <?php
                    $id=$_SESSION['id'];
                    $result = mysqli_query($conn, "SELECT SUM(total) AS value_sum from add_cart where user_id=$id");
                    $row = mysqli_fetch_assoc($result); 
                   $sum = $row['value_sum'];
                    echo "<strong>$".$sum."</strong>";
                 ?>

                  </p>
                </li>
                <?php  
                $result = mysqli_query($conn, "SELECT * FROM add_slipdeatils limit 1");

                while($row = mysqli_fetch_array($result))
                {
                  $total=$sum+$row['shipping']+$row['discount']+$row['tax'];

                  $_SESSION['totals']=$total['totals'];
                  
                  $show='<li class="cart-li d-block p-rem">
                  <div class="cart-content pb-3 p-0 border-0">
                    <h6 class="d-flex align-items-center">Shipping</h6>
                    <div class="flat cus-flat">
                      <div class="form-check cus-check">
                        <label class="form-check-label cus-check-label" for="flexRadioDefault1">Free Shipping</label>
                        <input class="form-check-input cus-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">  
                      </div>
                      <div class="form-check cus-check">
                        <label class="form-check-label cus-check-label" for="flexRadioDefault2">Flat rate:$'.$row['shipping'].'</label>
                        <input class="form-check-input cus-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                      </div>
                    </div>
                  </div>
                  <div class="cart-content pb-3 ">
                    <h6 class="d-flex align-items-center">Discount</h6>
                    <p>$'.$row['discount'].'</p>
                  </div>
                  <div class="cart-content pb-3 ">
                    <h6 class="d-flex align-items-center">Tax</h6>
                    <p>$'.$row['tax'].'</p>
                  </div>
                </li>
                <li class="cart-li border-0">
                  <h6>Total</h6>
                  <b>$'.$total.'</b>
                </li>';
                echo $show;
                }
                ?>
                
                
                <li class="cart-li border-0">
                  <a href="checkout.php?amount=<?php echo $total ?>" type="button" class="btn btn-checkout">Proceed to checkout</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </div>
    </section>
    
    <?php include 'footer.php'; ?>

    <!-- <script type="text/javascript">
      let table='';
      let row='';
      let Quantity=JSON.parse(localStorage.getItem('quantity'));
      const ids=[];
       let products= JSON.parse(localStorage.getItem('product'));

       for(let i=0; i<products.length; i++){
        row=products[i];
        
         if(ids.indexOf(row.id)!=-1){
          ids.push(row.id);
  
        }
         else{
           let total=row.price * Quantity;
        table='<tr class="align-middle alert border-bottom" role="alert">'+
                  '<td> <input type="checkbox" id="check"> </td>'+
                  '<td class="text-center"> <img class="pic" src="/plantback_admin/plantback_admin/upload/'+row.image+'" alt=""> </td>'+
                  '<td><div><p class="m-0 fw-bold">Lorem Ipsum is simply dummy.</p>'+
                          '<p class="m-0 text-muted">Text of the printing and typesetting industry.</p>'+
                      '</div>'+
                  '</td>'+
                  '<td>'+
                      '<div class="fw-600">$ '+row.price+' </div>'+
                  '</td>'+
                  '<td class="d-"> <input class="input" type="text" value="'+Quantity+'" disabled> </td>'+
                  '<td> $ '+total+' </td>'+
                  '<td>'+
                      '<div class="btn" data-bs-dismiss="alert"> <span class="fas fa-times"></span> </div>'+
                  '</td>'+
              '</tr>';
              $('#appendTable').append(table);

      

         
    
         }
       }
       let quantity= JSON.parse(localStorage.getItem('quantity'));
      console.log(products);
      console.log(quantity); -->

   
    </script>