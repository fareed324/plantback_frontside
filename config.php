<?php
require_once "vendor/autoload.php";
# -------------------Paypal-----------------------#
// PAYPAL_CLIENT_ID=ARfKSrSrwML6kbWq3Em5In1PJuJfYLZUYhfNMTmh1FCSXo3y3pD50xZu3kIEnwDUj6dYeX8YqhWyctu6
// PAYPAL_CLIENT_SECRET=EARZQBC_Uq8I-jlp8Xgz59dFYM0NVrktrtUYBZxzh4nbyQ0Bb4G8JSLx1KaMoo4U3NYwKivxz1adQ6eA
// PAYPAL_CURRENCY=USD 
use Omnipay\Omnipay;
 
define('CLIENT_ID', 'ARfKSrSrwML6kbWq3Em5In1PJuJfYLZUYhfNMTmh1FCSXo3y3pD50xZu3kIEnwDUj6dYeX8YqhWyctu6');
define('CLIENT_SECRET', 'EARZQBC_Uq8I-jlp8Xgz59dFYM0NVrktrtUYBZxzh4nbyQ0Bb4G8JSLx1KaMoo4U3NYwKivxz1adQ6eA');
 
define('PAYPAL_RETURN_URL', 'https://plantback.co.uk/plantback/thank-you.php');
define('PAYPAL_CANCEL_URL', 'https://plantback.co.uk/plantback/cancel.php');
define('PAYPAL_CURRENCY', 'USD'); // set your currency here
 
// Connect with the database
$db = new mysqli("localhost","pbuser","@@estk-9A","db_plantback"); 
 
if ($db->connect_errno) {
    die("Connect failed: ". $db->connect_error);
}
 
$gateway = Omnipay::create('PayPal_Rest');
$gateway->setClientId(CLIENT_ID);
$gateway->setSecret(CLIENT_SECRET);
$gateway->setTestMode(true); //set it to 'false' when go live