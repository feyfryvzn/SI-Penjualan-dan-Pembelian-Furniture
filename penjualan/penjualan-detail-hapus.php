<?php
session_start();
include '../koneksi.php';

if (isset($_GET['no_nota']) && isset($_GET['id_barang'])) {
    $no_nota = mysqli_real_escape_string($conn, $_GET['no_nota']);
    $id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);
    
    $check_query = mysqli_query($conn, "SELECT * FROM detail_penjualan WHERE no_nota = '$no_nota' AND id_barang = '$id_barang'");
    if (mysqli_num_rows($check_query) > 0) {
        $result = mysqli_query($conn, "DELETE FROM detail_penjualan WHERE no_nota = '$no_nota' AND id_barang = '$id_barang' LIMIT 1");

        if ($result) {
            // Calculate new total price after deletion
            $query = "SELECT dp.banyaknya, b.harga_satuan 
                      FROM detail_penjualan dp 
                      JOIN barang b ON dp.id_barang = b.id_barang 
                      WHERE dp.no_nota = '$no_nota'";
            $totalResult = mysqli_query($conn, $query);
            
            $jumlahRp = 0;
            if ($totalResult) {
                while ($row = mysqli_fetch_assoc($totalResult)) {
                    $jumlahRp += $row['banyaknya'] * $row['harga_satuan'];
                }

                // Update total price in penjualan table
                $updateResult = mysqli_query($conn, "UPDATE penjualan SET jumlah_Rp = '$jumlahRp' WHERE no_nota = '$no_nota'");

                if ($updateResult) {
                    $_SESSION['success'] = "Data detail penjualan berhasil dihapus.";
                    header("Location: penjualan-detail.php?no_nota=" . urlencode($no_nota));
                    exit();
                } else {
                    $_SESSION['error'] = "Error updating total price: " . mysqli_error($conn);
                }
            } else {
                $_SESSION['error'] = "Error calculating new total: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "Error deleting item: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Data tidak ditemukan.";
    }
} else {
    $_SESSION['error'] = "Parameter tidak valid.";
}

header("Location: penjualan-detail.php?no_nota=" . urlencode($no_nota));
exit();
?>