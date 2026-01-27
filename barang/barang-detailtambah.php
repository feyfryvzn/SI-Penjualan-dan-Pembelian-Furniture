<?php
include '../koneksi.php';

if (!isset($_GET['id_barang'])) {
    header('Location: barang-detail.php');
    exit;
}
$id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);

$check_query = mysqli_query($conn, "SELECT id_barang FROM barang WHERE id_barang = '$id_barang'");
if (mysqli_num_rows($check_query) == 0) {
    header('Location: barang-detail.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_kayu = mysqli_real_escape_string($conn, $_POST['id_kayu']);
    $unit = mysqli_real_escape_string($conn, $_POST['unit']);
    $takaran = mysqli_real_escape_string($conn, $_POST['takaran']);

    if (empty($id_kayu) || empty($unit) || empty($takaran)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM detail_bahanbaku WHERE id_barang = '$id_barang' AND id_kayu = '$id_kayu'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Detail untuk jenis kayu ini sudah ada pada barang tersebut.";
        } else {
            $insert = "
                INSERT INTO detail_bahanbaku (id_barang, id_kayu, unit, takaran)
                VALUES ('$id_barang', '$id_kayu', '$unit', '$takaran')
            ";
            if (mysqli_query($conn, $insert)) {
                header("Location: barang-detail.php?id_barang=" . urlencode($id_barang));
                exit;
            } else {
                $error = "Gagal menyimpan detail: " . mysqli_error($conn);
            }
        }
    }
}

$jenis_query = mysqli_query($conn, "SELECT id_kayu, jenis_hasil_hutan FROM jenis_hasil_hutan");
?>

<!doctype html>
<html lang="en">
<head>
    <title>Tambah Detail Bahan Baku - ID Barang <?= htmlspecialchars($id_barang) ?></title>
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
                    <p>Mbd ©<script>document.write(new Date().getFullYear());</script> <br>
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
                    <h5>Tambah Detail Bahan Baku (ID Barang: <?= htmlspecialchars($id_barang) ?>)</h5>
                    <a href="barang-detail.php?id_barang=<?= urlencode($id_barang) ?>" 
                       class="btn btn-secondary btn-sm">← Kembali</a>
                </div>
                <div class="card-body">
                    <?php if (isset($error)) : ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <input type="hidden" name="id_barang" value="<?= htmlspecialchars($id_barang) ?>">

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Jenis Kayu</label>
                            <div class="col-sm-6">
                                <select name="id_kayu" id="id_kayu" class="form-control" required>
                                    <option value="">-- Pilih Jenis Kayu --</option>
                                    <?php while ($jh = mysqli_fetch_assoc($jenis_query)) : ?>
                                        <option value="<?= htmlspecialchars($jh['id_kayu']) ?>">
                                            <?= htmlspecialchars($jh['jenis_hasil_hutan']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Unit</label>
                            <div class="col-sm-4">
                                <input type="text" name="unit" id="unit" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Takaran</label>
                            <div class="col-sm-4">
                                <input type="text" name="takaran" id="takaran" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-8 text-right">
                                <button type="submit" class="btn btn-success">
                                    <i class="fa fa-save"></i> Simpan
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