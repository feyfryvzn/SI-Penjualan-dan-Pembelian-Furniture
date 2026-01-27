<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id_barang']) && isset($_GET['id_kayu'])) {
    $id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);
    $id_kayu = mysqli_real_escape_string($conn, $_GET['id_kayu']);
    
    $check_query = mysqli_query($conn, "SELECT * FROM detail_bahanbaku WHERE id_barang = '$id_barang' AND id_kayu = '$id_kayu'");
    if (mysqli_num_rows($check_query) > 0) {
        $result = mysqli_query($conn, "DELETE FROM detail_bahanbaku WHERE id_barang = '$id_barang' AND id_kayu = '$id_kayu' LIMIT 1");

        if ($result) {
            $_SESSION['success'] = "Data detail bahan baku berhasil dihapus.";
            header("Location: barang-detail.php?id_barang=" . urlencode($id_barang));
            exit();
        } else {
            $_SESSION['error'] = "Error deleting item: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['error'] = "Data tidak ditemukan.";
    }
} else {
    $_SESSION['error'] = "Parameter tidak valid.";
}

header("Location: barang-detail.php?id_barang=" . urlencode($id_barang));
exit();
?>