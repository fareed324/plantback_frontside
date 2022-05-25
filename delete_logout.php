<?php
include_once ('connect.php');
include_once ('function.php');

if (isset($_GET['userid'])) {
    $userid = $_GET['userid'] ;
  } else {
    $id = NULL;
  }
$sql = "DELETE FROM add_cart WHERE user_id=$userid";
if (mysqli_query($conn, $sql)) {
    header("Location:logout.php");
 } else {
  echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);
?>