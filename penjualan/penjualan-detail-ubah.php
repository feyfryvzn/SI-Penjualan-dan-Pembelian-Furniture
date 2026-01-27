<?php
include '../koneksi.php';

if (!isset($_GET['no_nota']) || !isset($_GET['id_barang'])) {
    header('Location: penjualan-lihat.php');
    exit;
}
$no_nota   = mysqli_real_escape_string($conn, $_GET['no_nota']);
$id_barang = mysqli_real_escape_string($conn, $_GET['id_barang']);

// Query data lama dari detail_penjualan dan harga_satuan dari barang
$sql_lama = "
    SELECT dp.*, b.nama_barang, b.harga_satuan
    FROM detail_penjualan dp
    JOIN barang b ON dp.id_barang = b.id_barang
    WHERE dp.no_nota = ?
      AND dp.id_barang = ?
";
$stmt_lama = $conn->prepare($sql_lama);
if ($stmt_lama === false) {
    die("Error preparing statement: " . $conn->error);
}
$stmt_lama->bind_param("ss", $no_nota, $id_barang);
$stmt_lama->execute();
$res_lama = $stmt_lama->get_result();
if ($res_lama->num_rows == 0) {
    header("Location: penjualan-lihat.php?no_nota=" . urlencode($no_nota));
    exit;
}
$data_lama = $res_lama->fetch_assoc();
$stmt_lama->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $banyaknya_baru = $_POST['banyaknya'];
    $jumlah_baru    = $_POST['jumlah'];

    if ($banyaknya_baru === '' || $jumlah_baru === '') {
        $error = "Semua kolom wajib diisi.";
    } else {
        // Hitung ulang jumlah berdasarkan banyaknya dan harga_satuan
        $jumlah_baru_calculated = $banyaknya_baru * $data_lama['harga_satuan'];
        
        // Jalankan UPDATE
        $update = "
            UPDATE detail_penjualan
            SET banyaknya = ?,
                jumlah     = ?
            WHERE no_nota   = ?
              AND id_barang = ?
        ";
        $stmt_update = $conn->prepare($update);
        if ($stmt_update === false) {
            $error = "Error preparing update: " . $conn->error;
        } else {
            $stmt_update->bind_param("iiss", $banyaknya_baru, $jumlah_baru_calculated, $no_nota, $id_barang);
            if ($stmt_update->execute()) {
                header("Location: penjualan-detail.php?no_nota=" . urlencode($no_nota));
                exit;
            } else {
                $error = "Gagal memperbarui detail: " . $stmt_update->error;
            }
            $stmt_update->close();
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <title>Edit Detail Penjualan - Nota <?= htmlspecialchars($no_nota) ?></title>
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
          <h5>Edit Detail Penjualan (Nota: <?= htmlspecialchars($no_nota) ?>)</h5>
          <a href="penjualan-lihat.php?no_nota=<?= urlencode($no_nota) ?>" class="btn btn-secondary btn-sm">
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
            <input type="hidden" name="no_nota" value="<?= htmlspecialchars($no_nota) ?>">
            <input type="hidden" name="id_barang" value="<?= htmlspecialchars($id_barang) ?>">

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">ID Barang</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['id_barang']) ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Nama Barang</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" value="<?= htmlspecialchars($data_lama['nama_barang']) ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Harga Satuan (Rp)</label>
              <div class="col-sm-4">
                <input type="text" class="form-control" value="<?= number_format($data_lama['harga_satuan'], 0, ',', '.') ?>" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Banyaknya</label>
              <div class="col-sm-4">
                <input type="number" name="banyaknya" id="banyaknya" class="form-control" min="1"
                       value="<?= htmlspecialchars($data_lama['banyaknya']) ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Jumlah (Rp)</label>
              <div class="col-sm-4">
                <input type="text" name="jumlah" id="jumlah" class="form-control" readonly
                       value="<?= number_format($data_lama['banyaknya'] * $data_lama['harga_satuan'], 0, ',', '.') ?>">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-8 text-right">
                <button type="submit" class="btn btn-warning">
                  <i class="fa fa-save"></i> Update
                </button>
                <a href="penjualan-lihat.php?no_nota=<?= urlencode($no_nota) ?>" class="btn btn-secondary">Batal</a>
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
  <script>
    // JavaScript untuk menghitung jumlah otomatis
    $(document).ready(function() {
      $('#banyaknya').on('input', function() {
        var banyaknya = $(this).val();
        var hargaSatuan = <?= $data_lama['harga_satuan'] ?>;
        var jumlah = banyaknya * hargaSatuan;
        $('#jumlah').val(number_format(jumlah, 0, ',', '.'));
      });

      // Fungsi number_format sederhana
      function number_format(number, decimals, dec_point, thousands_sep) {
        number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function(n, prec) {
              var k = Math.pow(10, prec);
              return '' + Math.round(n * k) / k;
            };
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }
    });
  </script>
</body>
</html>