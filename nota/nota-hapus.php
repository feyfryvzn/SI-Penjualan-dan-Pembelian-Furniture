<?php
// include database connection file
include '../koneksi.php';
 
// Get id from URL to delete that user
if (isset($_GET['nota_no'])) {
    $nota_no=$_GET['nota_no'];
}
 
// Delete user row from table based on given id
$result = mysqli_query($conn, "DELETE FROM nota WHERE nota_no='$nota_no'");
 
// After delete redirect to Home, so that latest user list will be displayed.
header("Location:nota-lihat.php");
?>