<?php
session_start();
include '../koneksi.php';

if (isset($_GET['no_dkb']) && isset($_GET['no_urut'])) {
    $no_dkb = mysqli_real_escape_string($conn, $_GET['no_dkb']);
    $no_urut = mysqli_real_escape_string($conn, $_GET['no_urut']);

    $stmt_check = $conn->prepare("SELECT no_dkb, no_urut FROM detail_hasil_hutan WHERE no_dkb = ? AND no_urut = ?");
    $stmt_check->bind_param("si", $no_dkb, $no_urut);
    $stmt_check->execute();
    $check_result = $stmt_check->get_result();
    if ($check_result->num_rows > 0) {
        $stmt_delete = $conn->prepare("DELETE FROM detail_hasil_hutan WHERE no_dkb = ? AND no_urut = ? LIMIT 1");
        $stmt_delete->bind_param("si", $no_dkb, $no_urut);
        if ($stmt_delete->execute()) {
            // Update jumlah_batang and volume_total in dokumenpkb
            $stmt_update = $conn->prepare("
                UPDATE dokumenpkb
                SET jumlah_batang = (SELECT COUNT(*) FROM detail_hasil_hutan WHERE no_dkb = ?),
                    volume_total = (SELECT COALESCE(SUM(volume), 0) FROM detail_hasil_hutan WHERE no_dkb = ?)
                WHERE no_dkb = ?
            ");
            $stmt_update->bind_param("sss", $no_dkb, $no_dkb, $no_dkb);
            if ($stmt_update->execute()) {
                $_SESSION['success'] = "Data detail hasil hutan berhasil dihapus.";
                header("Location: dokumenpkb-detail.php?no_dkb=" . urlencode($no_dkb));
                exit();
            } else {
                $_SESSION['error'] = "Gagal memperbarui dokumen PKB: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            $_SESSION['error'] = "Gagal menghapus data: " . $stmt_delete->error;
        }
        $stmt_delete->close();
    } else {
        $_SESSION['error'] = "Data tidak ditemukan.";
    }
    $stmt_check->close();
} else {
    $_SESSION['error'] = "Parameter tidak valid.";
}

header("Location: dokumenpkb-detail.php?no_dkb=" . urlencode($no_dkb));
exit();
?>