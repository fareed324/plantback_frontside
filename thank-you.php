<?php include 'header2.php'; ?>
<?php
require_once 'config.php';
 
// Once the transaction has been approved, we need to complete it.
if (array_key_exists('paymentId', $_GET) && array_key_exists('PayerID', $_GET)) {
    $transaction = $gateway->completePurchase(array(
        'payer_id'             => $_GET['PayerID'],
        'transactionReference' => $_GET['paymentId'],
    ));
    $response = $transaction->send();
 
    if ($response->isSuccessful()) {
        // The customer has successfully paid.
        $arr_body = $response->getData();
 
        $payment_id = $arr_body['id'];
        $payer_id = $arr_body['payer']['payer_info']['payer_id'];
        $payer_email = $arr_body['payer']['payer_info']['email'];
        $amount = $arr_body['transactions'][0]['amount']['total'];
        $currency = PAYPAL_CURRENCY;
        $payment_status = $arr_body['state'];
 
        $db->query("INSERT INTO payments(payment_id, payer_id, payer_email, amount, currency, payment_status) VALUES('". $payment_id ."', '". $payer_id ."', '". $payer_email ."', '". $amount ."', '". $currency ."', '". $payment_status ."')");
 
        echo "Payment is successful. Your transaction id is: ". $payment_id;
    } else {
        echo $response->getMessage();
    }
} else {
    echo 'Transaction is declined';
}
?>
    <section class="py-165">
      <div class="container">
        <div class="row">
          <div class="thank-info">
            <div class="tick-icon"><i class="fas fa-check"></i></div>
            <h1 class="thank">Thank you!</h1>
            <p class="thank-txt">You Order has been received and will be dispatched to (AREA) very soon!</p>
            <a href="index.php" class="back"><i class="fas fa-long-arrow-alt-left"></i> BACK TO HOME</a>
          </div>
        </div>
      </div>
    </section>
    <?php include 'footer.php'; ?>