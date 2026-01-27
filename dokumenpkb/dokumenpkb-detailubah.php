<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['no_dkb']) || !isset($_GET['no_urut'])) {
    $_SESSION['error'] = "Parameter tidak valid.";
    header('Location: dokumenpkb-lihat.php');
    exit;
}
$no_dkb = mysqli_real_escape_string($conn, $_GET['no_dkb']);
$no_urut = mysqli_real_escape_string($conn, $_GET['no_urut']);

$stmt_lama = $conn->prepare("
    SELECT 
        dh.no_dkb,
        dh.no_urut,
        dh.id_kayu,
        j.jenis_hasil_hutan,
        dh.tanggal,
        dh.volume,
        dh.panjang,
        dh.diameter,
        dh.keterangan
    FROM detail_hasil_hutan dh
    JOIN jenis_hasil_hutan j ON dh.id_kayu = j.id_kayu
    WHERE dh.no_dkb = ? AND dh.no_urut = ?
");
$stmt_lama->bind_param("si", $no_dkb, $no_urut);
$stmt_lama->execute();
$result_lama = $stmt_lama->get_result();
if ($result_lama->num_rows == 0) {
    $_SESSION['error'] = "Detail hasil hutan tidak ditemukan.";
    header("Location: dokumenpkb-detail.php?no_dkb=" . urlencode($no_dkb));
    exit;
}
$data_lama = $result_lama->fetch_assoc();
$stmt_lama->close();

$jenis_query = mysqli_query($conn, "SELECT id_kayu, jenis_hasil_hutan FROM jenis_hasil_hutan");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kayu_baru = mysqli_real_escape_string($conn, $_POST['id_kayu']);
    $tanggal_baru = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $volume_baru = mysqli_real_escape_string($conn, $_POST['volume']);
    $panjang_baru = mysqli_real_escape_string($conn, $_POST['panjang']);
    $diameter_baru = mysqli_real_escape_string($conn, $_POST['diameter']);
    $keterangan_baru = mysqli_real_escape_string($conn, $_POST['keterangan']);

    if (empty($id_kayu_baru) || empty($tanggal_baru) || empty($volume_baru) || empty($panjang_baru) || empty($diameter_baru)) {
        $_SESSION['error'] = "Semua kolom wajib diisi.";
    } else {
        $stmt_update = $conn->prepare("
            UPDATE detail_hasil_hutan
            SET id_kayu = ?,
                tanggal = ?,
                volume = ?,
                panjang = ?,
                diameter = ?,
                keterangan = ?
            WHERE no_dkb = ? AND no_urut = ?
        ");
        $stmt_update->bind_param("ssdddssi", $id_kayu_baru, $tanggal_baru, $volume_baru, $panjang_baru, $diameter_baru, $keterangan_baru, $no_dkb, $no_urut);
        if ($stmt_update->execute()) {
            $update_query = "
                UPDATE dokumenpkb
                SET jumlah_batang = (SELECT COUNT(*) FROM detail_hasil_hutan WHERE no_dkb = ?),
                    volume_total = (SELECT SUM(volume) FROM detail_hasil_hutan WHERE no_dkb = ?)
                WHERE no_dkb = ?";
            $stmt_update_pkb = $conn->prepare($update_query);
            $stmt_update_pkb->bind_param("sss", $no_dkb, $no_dkb, $no_dkb);
            $stmt_update_pkb->execute();
            $stmt_update_pkb->close();

            $_SESSION['success'] = "Detail hasil hutan berhasil diperbarui.";
            header("Location: dokumenpkb-detail.php?no_dkb=" . urlencode($no_dkb));
            exit;
        } else {
            $_SESSION['error'] = "Gagal memperbarui detail: " . $stmt_update->error;
        }
        $stmt_update->close();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Detail Hasil Hutan - No. DKB <?= htmlspecialchars($no_dkb); ?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>
<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../img/oip.jpg); display: block; width: 80px; height: 80px; background-size: cover;"></a>
                <ul class="list-unstyled components mb-5">
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../customer/customer-lihat.php">Customer</a></li>
                    <li><a href="../barang/barang-lihat.php">Barang</a></li>
                    <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
                    <li><a href="../pemeriksa/pemeriksa-lihat.php">Pemeriksa</a></li>
                    <li><a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php">Jenis Hasil Hutan</a></li>
                    <li><a href="../pemilik/pemilik-lihat.php">Pemilik</a></li>
                    <li><a href="../penjualan/penjualan-lihat.php">Penjualan</a></li>
                    <li class="active"><a href="./dokumenpkb-lihat.php">Dokumen PKB</a></li>
                    <li><a href="../index.php" onclick="return confirm('Yakin keluar?')">Logout</a></li>
                </ul>
                <div class="footer">
                    <p>Mbd ©<script>document.write(new Date().getFullYear());</script> <br><i class="fa fa-heart" aria-hidden="true"></i></p>
                </div>
            </div>
        </nav>

        <div id="content" class="p-4 p-md-5">
            <nav class="navbar navbar-expand-lg navbar-light bg-light top-navbar">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-primary">
                        <i class="fa fa-bars"></i>
                        <span class="sr-only">Toggle Menu</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Edit Detail Dokumen PKB (No. DKB: <?= htmlspecialchars($no_dkb); ?>)</h5>
                    <a href="dokumenpkb-detail.php?no_dkb=<?= urlencode($no_dkb); ?>" class="btn btn-secondary btn-sm">← Kembali</a>
                </div>

                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
                    <?php endif; ?>

                    <form action="" method="POST">
                        <input type="hidden" name="no_dkb" value="<?= htmlspecialchars($no_dkb); ?>">
                        <input type="hidden" name="no_urut" value="<?= htmlspecialchars($no_urut); ?>">

                        <div class="form-group">
                            <label for="id_kayu">Jenis Hasil Hutan</label>
                            <select name="id_kayu" id="id_kayu" class="form-control" required>
                                <option value="">Pilih Jenis Hasil Hutan</option>
                                <?php while ($row = mysqli_fetch_assoc($jenis_query)): ?>
                                    <option value="<?= $row['id_kayu']; ?>" <?= $row['id_kayu'] == $data_lama['id_kayu'] ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($row['jenis_hasil_hutan']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= htmlspecialchars($data_lama['tanggal']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="volume">Volume (m³)</label>
                            <input type="number" step="0.01" name="volume" id="volume" class="form-control" value="<?= htmlspecialchars($data_lama['volume']); ?>" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="panjang">Panjang (m)</label>
                            <input type="number" step="0.01" name="panjang" id="panjang" class="form-control" value="<?= htmlspecialchars($data_lama['panjang']); ?>" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="diameter">Diameter (cm)</label>
                            <input type="number" step="0.01" name="diameter" id="diameter" class="form-control" value="<?= htmlspecialchars($data_lama['diameter']); ?>" required min="0">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" class="form-control"><?= htmlspecialchars($data_lama['keterangan']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
                        <a href="dokumenpkb-detail.php?no_dkb=<?= urlencode($no_dkb); ?>" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../js/sidebar.js"></script>
</body>
</html>
<?php
$conn->close();
?>