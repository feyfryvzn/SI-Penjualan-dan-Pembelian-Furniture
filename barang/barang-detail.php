<?php
session_start();
include '../koneksi.php';

// Ambil id_barang dari URL
if (!isset($_GET['id_barang'])) {
    $_SESSION['error'] = "ID Barang tidak valid.";
    header('Location: barang-lihat.php');
    exit;
}
$id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);

// Debugging: Tampilkan id_barang yang diterima
echo "<!-- Debug: id_barang = $id_barang -->";

// Query header barang
$stmt_header = $conn->prepare("
    SELECT 
        b.id_barang,
        b.nama_barang,
        b.harga_satuan
    FROM barang b
    WHERE b.id_barang = ?
");
if ($stmt_header === false) {
    $_SESSION['error'] = "Error preparing header query: " . $conn->error;
    header('Location: barang-lihat.php');
    exit;
}
$stmt_header->bind_param("s", $id_barang);
$stmt_header->execute();
$result_header = $stmt_header->get_result();
if ($result_header->num_rows == 0) {
    $_SESSION['error'] = "Barang tidak ditemukan.";
    header('Location: barang-lihat.php');
    exit;
}
$data_header = $result_header->fetch_assoc();
$stmt_header->close();

// Query detail bahan baku
$stmt_detail = $conn->prepare("
    SELECT 
        d.id_barang,
        d.id_kayu,
        j.jenis_hasil_hutan,
        d.unit,
        d.takaran
    FROM detail_bahanbaku d
    LEFT JOIN jenis_hasil_hutan j ON d.id_kayu = j.id_kayu
    WHERE d.id_barang = ?
");
if ($stmt_detail === false) {
    $_SESSION['error'] = "Error preparing detail query: " . $conn->error;
    header('Location: barang-lihat.php');
    exit;
}
$stmt_detail->bind_param("s", $id_barang);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();

// Debugging: Tampilkan jumlah baris yang ditemukan
echo "<!-- Debug: Jumlah baris detail = " . $result_detail->num_rows . " -->";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detail Barang - <?= htmlspecialchars($data_header['nama_barang']) ?></title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
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
                    <li class="active"><a href="../barang/barang-lihat.php">Barang</a></li>
                    <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
                    <li><a href="../pemeriksa/pemeriksa-lihat.php">Pemeriksa</a></li>
                    <li><a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php">Jenis Hasil Hutan</a></li>
                    <li><a href="../pemilik/pemilik-lihat.php">Pemilik</a></li>
                    <li><a href="../penjualan/penjualan-lihat.php">Penjualan</a></li>
                    <li><a href="../dokumenpkb/dokumenpkb-lihat.php">Dokumen PKB</a></li>
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
                    <h5>Detail Barang (<?= htmlspecialchars($data_header['nama_barang']) ?>)</h5>
                    <a href="barang-lihat.php" class="btn btn-secondary btn-sm">← Kembali ke Daftar</a>
                </div>

                <div class="card-body">
                    <?php if (isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
                    <?php endif; ?>

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <table class="table table-borderless table-sm">
                                <tr>
                                    <th style="width: 40%;">ID Barang</th>
                                    <td><?= htmlspecialchars($data_header['id_barang']) ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td><?= htmlspecialchars($data_header['nama_barang']) ?></td>
                                </tr>
                                <tr>
                                    <th>Harga Satuan (Rp)</th>
                                    <td><?= number_format($data_header['harga_satuan'], 0, ',', '.') ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a href="barang-detailtambah.php?id_barang=<?= urlencode($id_barang) ?>" 
                           class="btn btn-success btn-sm">
                            <i class="fa fa-plus-circle"></i> Tambah Detail
                        </a>
                    </div>

                    <h6>Daftar Bahan Baku:</h6>
                    <div class="table-responsive">
                        <table id="detailTable" class="table table-striped table-bordered table-hover" style="width:100%; text-align: center;">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Barang</th>
                                    <th>Kayu</th>
                                    <th>Unit</th>
                                    <th>Takaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                while ($row = $result_detail->fetch_assoc()) {
                                    // Debugging: Tampilkan nilai row
                                    echo "<!-- Debug: id_barang = " . $row['id_barang'] . ", id_kayu = " . $row['id_kayu'] . " -->";
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($data_header['nama_barang']) ?></td> <!-- Tampilkan nama_barang -->
                                        <td><?= htmlspecialchars($row['jenis_hasil_hutan']) ?></td>
                                        <td><?= htmlspecialchars($row['unit']) ?></td>
                                        <td><?= htmlspecialchars($row['takaran']) ?></td>
                                        <td>
                                            <a href="barang-detailubah.php?id_barang=<?= urlencode($id_barang) ?>&id_kayu=<?= urlencode($row['id_kayu']) ?>"
                                               class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit Detail">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a href="barang-detailhapus.php?id_barang=<?= urlencode($id_barang) ?>&id_kayu=<?= urlencode($row['id_kayu']) ?>"
                                               class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Detail"
                                               onclick="return confirm('Yakin ingin menghapus detail ini?')">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if ($result_detail->num_rows == 0): ?>
                                    <tr>
                                        <td colspan="6">Tidak ada detail bahan baku untuk barang ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
    <script src="../js/sidebar.js"></script>
    <script>
        $(document).ready(function() {
            $('#detailTable').DataTable({
                ordering: false,
                paging: false,
                searching: false,
                info: false
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</body>
</html>
<?php
$stmt_detail->close();
$conn->close();
?>