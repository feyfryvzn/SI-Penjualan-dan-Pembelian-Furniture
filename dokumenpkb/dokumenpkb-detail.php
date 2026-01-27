<?php
include '../koneksi.php';

if (!isset($_GET['no_dkb'])) {
    header('Location: dokumenpkb-lihat.php');
    exit;
}
$no_dkb = $_GET['no_dkb'];

$stmt_header = $conn->prepare("
    SELECT 
        d.no_dkb,
        d.tanggal_pembuatan,
        d.tempat_muat,
        d.no_skkk,
        d.jumlah_batang,
        d.volume_total,
        p.nama_pemilik,
        pr.nama_pemeriksa,
        k.nama_kelurahan
    FROM dokumenpkb d
    JOIN pemilik p ON d.id_pemilik = p.id_pemilik
    JOIN pemeriksa pr ON d.id_pemeriksa = pr.id_pemeriksa
    JOIN kelurahan k ON d.id_kelurahan = k.id_kelurahan
    WHERE d.no_dkb = ?
");
$stmt_header->bind_param("s", $no_dkb);
$stmt_header->execute();
$result_header = $stmt_header->get_result();
if (mysqli_num_rows($result_header) == 0) {
    header('Location: dokumenpkb-lihat.php');
    exit;
}
$data_header = mysqli_fetch_assoc($result_header);
$stmt_header->close();

$stmt_detail = $conn->prepare("
    SELECT 
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
    WHERE dh.no_dkb = ?
");
$stmt_detail->bind_param("s", $no_dkb);
$stmt_detail->execute();
$result_detail = $stmt_detail->get_result();
?>

<!doctype html>
<html lang="en">
<head>
  <title>Detail Dokumen PKB - No. DKB <?= htmlspecialchars($data_header['no_dkb']) ?></title>
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
          <h5>Detail Dokumen PKB (No. DKB: <?= htmlspecialchars($data_header['no_dkb']) ?>)</h5>
          <a href="dokumenpkb-lihat.php" class="btn btn-secondary btn-sm">← Kembali ke Daftar</a>
        </div>

        <div class="card-body">
          <div class="row mb-4">
            <div class="col-md-4">
              <table class="table table-borderless table-sm">
                <tr>
                  <th style="width: 40%;">No. DKB</th>
                  <td><?= htmlspecialchars($data_header['no_dkb']) ?></td>
                </tr>
                <tr>
                  <th>Tanggal Pembuatan</th>
                  <td><?= htmlspecialchars($data_header['tanggal_pembuatan']) ?></td>
                </tr>
                <tr>
                  <th>Tempat Muat</th>
                  <td><?= htmlspecialchars($data_header['tempat_muat']) ?></td>
                </tr>
                <tr>
                  <th>No. SKKK</th>
                  <td><?= htmlspecialchars($data_header['no_skkk']) ?></td>
                </tr>
              </table>
            </div>
            <div class="col-md-4">
              <table class="table table-borderless table-sm">
                <tr>
                  <th>Pemilik</th>
                  <td><?= htmlspecialchars($data_header['nama_pemilik']) ?></td>
                </tr>
                <tr>
                  <th>Pemeriksa</th>
                  <td><?= htmlspecialchars($data_header['nama_pemeriksa']) ?></td>
                </tr>
                <tr>
                  <th>Kelurahan</th>
                  <td><?= htmlspecialchars($data_header['nama_kelurahan']) ?></td>
                </tr>
                <tr>
                  <th>Jumlah Batang</th>
                  <td><?= htmlspecialchars($data_header['jumlah_batang']) ?></td>
                </tr>
                <tr>
                  <th>Volume Total</th>
                  <td><?= htmlspecialchars($data_header['volume_total']) ?> m³</td>
                </tr>
              </table>
            </div>
          </div>

          <div class="mb-3">
            <a href="dokumenpkb-detailtambah.php?no_dkb=<?= urlencode($no_dkb) ?>" class="btn btn-success btn-sm">
              <i class="fa fa-plus-circle"></i> Tambah Detail
            </a>
          </div>

          <h6>Daftar Hasil Hutan:</h6>
          <div class="table-responsive">
            <table id="detailTable" class="table table-striped table-bordered table-hover" style="width:100%; text-align: center;">
              <thead class="thead-dark">
                <tr>
                  <th>No Urut</th>
                  <th>ID Kayu</th>
                  <th>Jenis Hasil Hutan</th>
                  <th>Tanggal</th>
                  <th>Volume (m³)</th>
                  <th>Panjang (m)</th>
                  <th>Diameter (cm)</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result_detail)) {
                ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($row['id_kayu']) ?></td>
                    <td style="text-align: left;"><?= htmlspecialchars($row['jenis_hasil_hutan']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal']) ?></td>
                    <td><?= htmlspecialchars($row['volume']) ?></td>
                    <td><?= htmlspecialchars($row['panjang']) ?></td>
                    <td><?= htmlspecialchars($row['diameter']) ?></td>
                    <td style="text-align: left;"><?= htmlspecialchars($row['keterangan']) ?></td>
                    <td>
                      <a href="dokumenpkb-detailubah.php?no_dkb=<?= urlencode($no_dkb) ?>&no_urut=<?= urlencode($row['no_urut']) ?>" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Ubah">
                        <i class="fa fa-pencil"></i>
                      </a>
                      <a href="dokumenpkb-detailhapus.php?no_dkb=<?= urlencode($no_dkb) ?>&no_urut=<?= urlencode($row['no_urut']) ?>" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Hapus" onclick="return confirm('Yakin hapus data ini?')">
                        <i class="fa fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php } ?>
                <?php if (mysqli_num_rows($result_detail) == 0) : ?>
                  <tr>
                    <td colspan="9">Tidak ada detail hasil hutan untuk dokumen ini.</td>
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