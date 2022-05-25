<?php
include_once ('connect.php');
include_once ('function.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
  } else {
    $id = NULL;
  }
$sql = "DELETE FROM add_cart WHERE id=$id ";
if (mysqli_query($conn, $sql)) {
    header("Location:cart.php");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}
mysqli_close($conn);

#----------------------------#



?>