<?php
// include database connection file
include '../koneksi.php';

// Get id from URL to delete that user
if (isset($_GET['nota_no']) && isset($_GET['no_barang'])) {
    $nota_no = mysqli_real_escape_string($conn, $_GET['nota_no']);
    $no_barang = mysqli_real_escape_string($conn, $_GET['no_barang']);
    
    // Delete user row from table based on given id with LIMIT 1
    $result = mysqli_query($conn, "DELETE FROM detailbarang WHERE nota_no = '$nota_no' AND no_barang = '$no_barang' LIMIT 1");

    if ($result) {
        // Calculate new total price after deletion
        $query = "SELECT SUM(jumlah) AS total FROM detailbarang WHERE nota_no = '$nota_no'";
        $totalResult = mysqli_query($conn, $query);
        
        if ($totalResult) {
            $row = mysqli_fetch_assoc($totalResult);
            $jumlah_rpBaru = $row['total'] ?? 0;

            // Update total price in nota table
            $updateResult = mysqli_query($conn, "UPDATE nota SET jumlah_rp = '$jumlah_rpBaru' WHERE nota_no = '$nota_no'");

            if ($updateResult) {
                // After delete redirect to Home, so that latest user list will be displayed.
                header("Location: notadetail-lihat.php?nota_no=$nota_no");
                exit();
            } else {
                echo "Error updating total price: " . mysqli_error($conn);
            }
        } else {
            echo "Error calculating new total: " . mysqli_error($conn);
        }
    } else {
        echo "Error deleting item: " . mysqli_error($conn);
    }
} else {
    echo "Invalid parameters.";
}
?>
