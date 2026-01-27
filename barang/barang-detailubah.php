<?php
include '../koneksi.php';

// 1) Ambil id_barang & id_kayu dari GET
if (!isset($_GET['id_barang']) || !isset($_GET['id_kayu'])) {
    header('Location: barang-lihat.php');
    exit;
}
$id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);
$id_kayu = mysqli_real_escape_string($conn, $_GET['id_kayu']);

// 2) Query data lama dari detail_bahanbaku
$sql_lama = "
    SELECT db.*, j.jenis_hasil_hutan
    FROM detail_bahanbaku db
    LEFT JOIN jenis_hasil_hutan j ON db.id_kayu = j.id_kayu
    WHERE db.id_barang = '$id_barang'
      AND db.id_kayu = '$id_kayu'
";
$res_lama = mysqli_query($conn, $sql_lama);
if (mysqli_num_rows($res_lama) == 0) {
    header("Location: barang-detail.php?id_barang=$id_barang");
    exit;
}
$data_lama = mysqli_fetch_assoc($res_lama);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $unit_baru = mysqli_real_escape_string($conn, $_POST['unit']);
    $takaran_baru = mysqli_real_escape_string($conn, $_POST['takaran']);

    if ($unit_baru === '' || $takaran_baru === '') {
        $error = "Semua kolom wajib diisi.";
    } else {
        $update = "
            UPDATE detail_bahanbaku
            SET unit = '$unit_baru',
                takaran = '$takaran_baru'
            WHERE id_barang = '$id_barang'
              AND id_kayu = '$id_kayu'
        ";
        if (mysqli_query($conn, $update)) {
            header("Location: barang-detail.php?id_barang=" . urlencode($id_barang));
            exit;
        } else {
            $error = "Gagal memperbarui detail: " . mysqli_error($conn);
        }
    }
}

$jenis_query = mysqli_query($conn, "SELECT id_kayu, jenis_hasil_hutan FROM jenis_hasil_hutan");
?>

<!doctype html>
<html lang="en">

<head>
    <title>Edit Detail Bahan Baku - ID Barang <?= htmlspecialchars($id_barang) ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <div class="wrapper d-flex align-items-stretch">
        <nav id="sidebar">
            <div class="p-4 pt-5">
                <a href="#" class="img logo rounded-circle mb-5"
                   style="background-image: url(../img/oip.jpg); display: block; width: 80px; height: 80px; background-size: cover;"></a>
                <ul class="list-unstyled components mb-5">
                    <li><a href="../home.php">Home</a></li>
                    <li><a href="../customer/customer-lihat.php">Customer</a></li>
                    <li class="active"><a href="../barang/barang-lihat.php">Barang</a></li>
                    <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
                    <li><a href="../pemeriksa/pemeriksa-lihat.php">Pemeriksa</a></li>
                    <li><a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php">Jenis Hasil Hutan</a></li>
                    <li><a href="../pemilik/pemilik-lihat.php">Pemilik</a></li>
                    <li><a href="../penjualan/penjualan-lihat.php">Penjualan</a></li>
                    <li><a href="../dokumenpkb/dokumenpkb-lihat.php">Dokumen PKB</a></li>
                    <li>
                        <a href="index.php" onclick="return confirm('Yakin keluar?')">Logout</a>
                    </li>
                </ul>
                <div class="footer">
                    <p>
                        Mbd ©<script>document.write(new Date().getFullYear());</script> <br>
                        <i class="fa fa-heart" aria-hidden="true"></i>
                    </p>
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
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button"
                            data-toggle="collapse" data-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent" aria-expanded="false"
                            aria-label="Toggle navigation">
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
                    <h5>Edit Detail Bahan Baku (ID Barang: <?= htmlspecialchars($id_barang) ?>)</h5>
                    <a href="barang-detail.php?id_barang=<?= urlencode($id_barang) ?>" class="btn btn-secondary btn-sm">
                        ← Kembali
                    </a>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <input type="hidden" name="id_barang" value="<?= htmlspecialchars($id_barang) ?>">
                        <input type="hidden" name="id_kayu" value="<?= htmlspecialchars($id_kayu) ?>">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">ID Barang</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['id_barang']) ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Hasil Hutan</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['jenis_hasil_hutan']) ?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Unit</label>
                            <div class="col-sm-4">
                                <input type="text" name="unit" class="form-control"
                                       value="<?= htmlspecialchars($data_lama['unit']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Takaran</label>
                            <div class="col-sm-4">
                                <input type="text" name="takaran" class="form-control"
                                       value="<?= htmlspecialchars($data_lama['takaran']) ?>" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 text-right">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa fa-save"></i> Update
                                </button>
                                <a href="barang-detail.php?id_barang=<?= urlencode($id_barang) ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </div>
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