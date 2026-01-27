<?php
include '../koneksi.php';

if (!isset($_GET['no_nota'])) {
    header('Location: penjualan-detail.php');
    exit;
}
$no_nota = $_GET['no_nota'];

$sql_barang = "SELECT id_barang, nama_barang, harga_satuan FROM barang ORDER BY nama_barang ASC";
$result_barang = mysqli_query($conn, $sql_barang);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_barang = $_POST['id_barang'];
    $banyaknya = $_POST['banyaknya'];
    $jumlah = $_POST['jumlah'];

    if ($id_barang == '' || $banyaknya == '' || $jumlah == '') {
        $error = "Semua kolom wajib diisi.";
    } else {
        $cek = mysqli_query($conn, "SELECT * FROM detail_penjualan 
                                     WHERE no_nota = '$no_nota' 
                                       AND id_barang = '$id_barang'");
        if (mysqli_num_rows($cek) > 0) {
            $error = "Detail untuk barang ini sudah ada pada nota tersebut.";
        } else {
            $insert = "
                INSERT INTO detail_penjualan (no_nota, id_barang, banyaknya, jumlah)
                VALUES ('$no_nota', '$id_barang', '$banyaknya', '$jumlah')
            ";
            if (mysqli_query($conn, $insert)) {
                header("Location: penjualan-detail.php?no_nota=$no_nota");
                exit;
            } else {
                $error = "Gagal menyimpan detail: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <title>Tambah Detail Penjualan - Nota <?= htmlspecialchars($no_nota) ?></title>
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
          <h5>Tambah Detail Penjualan (Nota: <?= htmlspecialchars($no_nota) ?>)</h5>
          <a href="penjualan-detail.php?no_nota=<?= urlencode($no_nota) ?>" 
             class="btn btn-secondary btn-sm">← Kembali</a>
        </div>
        <div class="card-body">
          <?php if (isset($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php endif; ?>

          <form method="post" action="">
            <input type="hidden" name="no_nota" value="<?= htmlspecialchars($no_nota) ?>">

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">ID Barang</label>
              <div class="col-sm-6">
                <select name="id_barang" id="id_barang" class="form-control" required>
                  <option value="">-- Pilih Barang --</option>
                  <?php mysqli_data_seek($result_barang, 0); while ($br = mysqli_fetch_assoc($result_barang)) : ?>
                    <option value="<?= htmlspecialchars($br['id_barang']) ?>"
                            data-harga="<?= htmlspecialchars($br['harga_satuan']) ?>">
                      <?= htmlspecialchars($br['id_barang']) ?> ‒ <?= htmlspecialchars($br['nama_barang']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Harga Satuan (Rp)</label>
              <div class="col-sm-4">
                <input type="number" id="harga_satuan" class="form-control" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Banyaknya</label>
              <div class="col-sm-4">
                <input type="number" name="banyaknya" class="form-control" min="1" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Jumlah (Rp)</label>
              <div class="col-sm-4">
                <input type="number" name="jumlah" id="jumlah" class="form-control" min="0" readonly required>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-8 text-right">
                <button type="submit" class="btn btn-success">
                  <i class="fa fa-save"></i> Simpan
                </button>
                <a href="penjualan-detail.php?no_nota=<?= urlencode($no_nota) ?>" class="btn btn-secondary">Batal</a>
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

  <!-- Hitung Otomatis -->
  <script>
    $(document).ready(function () {
      const barangSelect = $('#id_barang');
      const hargaSatuanInput = $('#harga_satuan');
      const banyaknyaInput = $('input[name="banyaknya"]');
      const jumlahInput = $('#jumlah');

      function hitungJumlah() {
        const harga = parseFloat(barangSelect.find(':selected').data('harga')) || 0;
        const banyak = parseInt(banyaknyaInput.val()) || 0;
        const total = harga * banyak;

        hargaSatuanInput.val(harga);
        jumlahInput.val(total);
      }

      barangSelect.change(hitungJumlah);
      banyaknyaInput.on('input', hitungJumlah);
    });
  </script>
</body>
</html>
