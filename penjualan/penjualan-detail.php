<?php
include '../koneksi.php';

if (!isset($_GET['no_nota'])) {
    header('Location: penjualan-lihat.php');
    exit;
}
$no_nota = mysqli_real_escape_string($conn, $_GET['no_nota']);

//Query header penjualan (penjualan JOIN customer JOIN pegawai) dengan prepared statement
$sql_header = "
    SELECT 
        p.no_nota,
        p.tanggal,
        p.jumlah_Rp,
        p.DP,
        p.sisa,
        c.nama_customer,
        pg.nama_pegawai
    FROM penjualan p
    JOIN customer c ON p.id_customer = c.id_customer
    JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai
    WHERE p.no_nota = ?
";
$stmt_header = $conn->prepare($sql_header);
if ($stmt_header === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt_header->bind_param("s", $no_nota);
$stmt_header->execute();
$result_header = $stmt_header->get_result();
if ($result_header->num_rows == 0) {
    // Jika no_nota tidak ditemukan, redirect kembali ke daftar
    header('Location: penjualan-lihat.php');
    exit;
}
$data_header = $result_header->fetch_assoc();
$stmt_header->close();

//Query detail barang (detail_penjualan JOIN barang) dengan prepared statement
$sql_detail = "
    SELECT 
        dp.id_barang,
        b.nama_barang,
        dp.banyaknya,
        dp.jumlah
    FROM detail_penjualan dp
    JOIN barang b ON dp.id_barang = b.id_barang
    WHERE dp.no_nota = ?
";
$stmt_detail = $conn->prepare($sql_detail);
if ($stmt_detail === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt_detail->bind_param("s", $no_nota);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>

<!doctype html>
<html lang="en">

<head>
  <title>Detail Penjualan - Nota <?= htmlspecialchars($data_header['no_nota']) ?></title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
        <a href="#" class="img logo rounded-circle mb-5"
           style="background-image: url(../img/oip.jpg); display: block; width: 80px; height: 80px; background-size: cover;"></a>
        <ul class="list-unstyled components mb-5">
          <li><a href="../home.php">Home</a></li>
          <li><a href="../customer/customer-lihat.php">Customer</a></li>
          <li><a href="../barang/barang-lihat.php">Barang</a></li>
          <li><a href="../pegawai/pegawai-lihat.php">Pegawai</a></li>
          <li><a href="../pemeriksa/pemeriksa-lihat.php">Pemeriksa</a></li>
          <li><a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php">Jenis Hasil Hutan</a></li>
          <li><a href="../pemilik/pemilik-lihat.php">Pemilik</a></li>
          <li class="active"><a href="./penjualan-lihat.php">Penjualan</a></li>
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
          <h5>Detail Penjualan (No. Nota: <?= htmlspecialchars($data_header['no_nota']) ?>)</h5>
          <a href="penjualan-lihat.php" class="btn btn-secondary btn-sm">← Kembali ke Daftar</a>
        </div>

        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-4">
              <table class="table table-borderless table-sm">
                <tr>
                  <th style="width: 40%;">No. Nota</th>
                  <td><?= htmlspecialchars($data_header['no_nota']) ?></td>
                </tr>
                <tr>
                  <th>Tanggal</th>
                  <td><?= htmlspecialchars($data_header['tanggal']) ?></td>
                </tr>
                <tr>
                  <th>Customer</th>
                  <td><?= htmlspecialchars($data_header['nama_customer']) ?></td>
                </tr>
                <tr>
                  <th>Pegawai</th>
                  <td><?= htmlspecialchars($data_header['nama_pegawai']) ?></td>
                </tr>
              </table>
            </div>
            <div class="col-md-4">
              <table class="table table-borderless table-sm">
                <tr>
                  <th>Jumlah (Rp)</th>
                  <td><?= number_format(floatval(str_replace('.', '', $data_header['jumlah_Rp'])), 0, ',', '.') ?></td>
                </tr>
                <tr>
                  <th>DP (Rp)</th>
                  <td><?= number_format(floatval(str_replace('.', '', $data_header['DP'])), 0, ',', '.') ?></td>
                </tr>
                <tr>
                  <th>Sisa (Rp)</th>
                  <td><?= number_format(floatval(str_replace('.', '', $data_header['sisa'])), 0, ',', '.') ?></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="mb-3">
            <a href="penjualan-detail-tambah.php?no_nota=<?= urlencode($no_nota) ?>" 
               class="btn btn-success btn-sm">
              <i class="fa fa-plus-circle"></i> Tambah Detail
            </a>
          </div>

          <h6>Daftar Barang:</h6>
          <div class="table-responsive">
            <table id="detailTable" class="table table-striped table-bordered table-hover" 
                   style="width:100%; text-align: center;">
              <thead class="thead-dark">
                <tr>
                  <th>No</th>
                  <th>ID Barang</th>
                  <th>Nama Barang</th>
                  <th>Banyaknya</th>
                  <th>Jumlah (Rp)</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while ($row = $result_detail->fetch_assoc()) {
                ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['id_barang']) ?></td>
                    <td style="text-align: left;"><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><?= htmlspecialchars($row['banyaknya']) ?></td>
                    <td style="text-align: right;"><?= number_format(floatval(str_replace('.', '', $row['jumlah'])), 0, ',', '.') ?></td>
                    <td>
                      <a href="penjualan-detail-ubah.php?no_nota=<?= urlencode($no_nota) ?>&id_barang=<?= urlencode($row['id_barang']) ?>"
                         class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit Detail">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="penjualan-detail-hapus.php?no_nota=<?= urlencode($no_nota) ?>&id_barang=<?= urlencode($row['id_barang']) ?>"
                         class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus Detail">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
                <?php if ($result_detail->num_rows == 0) : ?>
                  <tr>
                    <td colspan="6">Tidak ada detail barang untuk nota ini.</td>
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
$conn->close();
?>