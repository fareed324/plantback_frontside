<?php
///database connection///
error_reporting(E_ERROR | E_PARSE);
$conn = mysqli_connect("localhost","pbuser","@@estk-9A","db_plantback");


if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


///Get Config Constants///
$site_name = "Plantback Admin Area";

//Date Standard
$today = date("Y-m-d H:i:s");

// Get Comm Details
$c = "SELECT * FROM config WHERE varname='commission_user'";
$ca = mysqli_query($conn,$c);
$carow = mysqli_fetch_assoc($ca);
$user_comm = $carow['value'];

$c = "SELECT * FROM config WHERE varname='commission_friend'";
$ca = mysqli_query($conn,$c);
$carow = mysqli_fetch_assoc($ca);
$friend_comm = $carow['value'];
?>