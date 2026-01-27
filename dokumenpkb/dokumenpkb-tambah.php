<?php
if (isset($_POST['proses'])) {
    include '../koneksi.php';

    $no_dkb = mysqli_real_escape_string($conn, $_POST['no_dkb']);
    $id_pemilik = mysqli_real_escape_string($conn, $_POST['id_pemilik']);
    $id_pemeriksa = mysqli_real_escape_string($conn, $_POST['id_pemeriksa']);
    $tanggal_pembuatan = mysqli_real_escape_string($conn, $_POST['tanggal_pembuatan']);
    $tempat_muat = mysqli_real_escape_string($conn, $_POST['tempat_muat']);
    $no_skkk = mysqli_real_escape_string($conn, $_POST['no_skkk']);
    $jumlah_batang = mysqli_real_escape_string($conn, $_POST['jumlah_batang']);
    $volume_total = mysqli_real_escape_string($conn, $_POST['volume_total']);
    $id_kelurahan = mysqli_real_escape_string($conn, $_POST['id_kelurahan']);

    if (!empty($no_dkb) && !empty($id_pemilik) && !empty($id_pemeriksa) && !empty($tanggal_pembuatan) && 
        !empty($tempat_muat) && !empty($no_skkk) && !empty($jumlah_batang) && !empty($volume_total) && !empty($id_kelurahan)) {
        
        $stmt = $conn->prepare("INSERT INTO dokumenpkb (no_dkb, id_pemilik, id_pemeriksa, tanggal_pembuatan, tempat_muat, no_skkk, jumlah_batang, volume_total, id_kelurahan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssids", $no_dkb, $id_pemilik, $id_pemeriksa, $tanggal_pembuatan, $tempat_muat, $no_skkk, $jumlah_batang, $volume_total, $id_kelurahan);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: dokumenpkb-lihat.php?success=add");
            exit();
        } else {
            error_log("Insert dokumenpkb gagal: " . $stmt->error);
            $stmt->close();
        }
    } else {
        error_log("Data tidak lengkap untuk dokumenpkb");
    }
    $conn->close();
}

include '../koneksi.php';
$data_pemilik = mysqli_query($conn, "SELECT id_pemilik, nama_pemilik FROM pemilik");
$data_pemeriksa = mysqli_query($conn, "SELECT id_pemeriksa, nama_pemeriksa FROM pemeriksa");
$data_kelurahan = mysqli_query($conn, "SELECT id_kelurahan, nama_kelurahan FROM kelurahan");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Dokumen PKB</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.min.css">
  <style>
    body {
      background-color: #ffffff;
      font-family: 'Segoe UI', sans-serif;
      color: #000;
      margin: 0;
      overflow-x: hidden;
    }

    .sidebar {
      height: 100vh;
      background: linear-gradient(180deg, #0b1e33, #0d2744);
      color: #fff;
      padding: 20px 5px;
      position: fixed;
      width: 70px;
      top: 0;
      left: 0;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
      transition: width 0.3s ease;
      z-index: 1000;
    }

    .sidebar a {
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px;
      margin: 5px 0;
      text-decoration: none;
      font-size: 1rem;
      border-radius: 8px;
      transition: background-color 0.3s ease;
    }

    .sidebar a i {
      font-size: 1.2rem;
    }

    .sidebar a:hover {
      background-color: rgba(0, 123, 255, 0.3);
    }

    .sidebar a.active {
      background-color: #007bff;
      font-weight: 600;
    }

    .main {
      margin-left: 80px;
      padding: 30px;
      transition: margin-left 0.3s ease;
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
    }

    .btn-warning {
      background: linear-gradient(135deg, #ffca2c, #ffda6a);
      border: none;
      color: #000;
      font-weight: 600;
    }

    .btn-warning:hover {
      background: linear-gradient(135deg, #ffda6a, #ffca2c);
      color: #000;
    }

    .btn-success {
      background: linear-gradient(135deg, #28a745, #38c172);
      border: none;
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #38c172, #28a745);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #ef5753);
      border: none;
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #ef5753, #dc3545);
    }

    .card {
      background-color: #f8f9fa;
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .form-group label {
      font-weight: 600;
    }

    .form-group select, .form-group input {
      border-radius: 8px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 50px;
        padding: 15px 5px;
      }

      .sidebar a i {
        font-size: 1rem;
      }

      .main {
        margin-left: 60px;
      }
    }
  </style>
</head>

<body>
  <div class="sidebar">
    <a href="../home.php"><i class="fas fa-tachometer-alt"></i></a>
    <a href="../customer/customer-lihat.php"><i class="fas fa-users"></i></a>
    <a href="../barang/barang-lihat.php"><i class="fas fa-box"></i></a>
    <a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i></a>
    <a href="../pemeriksa/pemeriksa-lihat.php"><i class="fas fa-user-check"></i></a>
    <a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php"><i class="fas fa-tree"></i></a>
    <a href="../pemilik/pemilik-lihat.php"><i class="fas fa-user-shield"></i></a>
    <a href="../penjualan/penjualan-lihat.php"><i class="fas fa-shopping-cart"></i></a>
    <a href="../dokumenpkb/dokumenpkb-lihat.php" class="active"><i class="fas fa-file-alt"></i></a>
    <a href="../index.php" onclick="return confirm('Yakin keluar?')"><i class="fas fa-sign-out-alt"></i></a>
  </div>
  <div class="main">
    <div class="dashboard-header">
      <div>
        <h2 class="text-dark font-weight-bold mb-0">Tambah Dokumen PKB</h2>
        <small class="text-muted">15 Juni 2025, 02:22 AM WIB</small>
      </div>
      <img src="../images/kop.jpg" alt="Logo" height="40">
    </div>

    <div class="card">
      <div class="card-header">
        <h5>Tambah Dokumen PKB</h5>
      </div>
      <div class="card-body">
        <form action="" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="no_dkb">No DKB</label>
                <input type="text" name="no_dkb" id="no_dkb" class="form-control" placeholder="Masukkan No DKB" required>
              </div>
              <div class="form-group">
                <label for="id_pemilik">Pemilik</label>
                <select name="id_pemilik" id="id_pemilik" class="form-control" required>
                  <option value="">-- Pilih Pemilik --</option>
                  <?php while ($pemilik = mysqli_fetch_assoc($data_pemilik)): ?>
                    <option value="<?php echo htmlspecialchars($pemilik['id_pemilik']); ?>">
                      <?php echo htmlspecialchars($pemilik['nama_pemilik']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_pemeriksa">Pemeriksa</label>
                <select name="id_pemeriksa" id="id_pemeriksa" class="form-control" required>
                  <option value="">-- Pilih Pemeriksa --</option>
                  <?php while ($pemeriksa = mysqli_fetch_assoc($data_pemeriksa)): ?>
                    <option value="<?php echo htmlspecialchars($pemeriksa['id_pemeriksa']); ?>">
                      <?php echo htmlspecialchars($pemeriksa['nama_pemeriksa']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tanggal_pembuatan">Tanggal Pembuatan</label>
                <input type="date" name="tanggal_pembuatan" id="tanggal_pembuatan" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="tempat_muat">Tempat Muat</label>
                <input type="text" name="tempat_muat" id="tempat_muat" class="form-control" placeholder="Masukkan Tempat Muat" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="no_skkk">No SKKK</label>
                <input type="text" name="no_skkk" id="no_skkk" class="form-control" placeholder="Masukkan No SKKK" required>
              </div>
              <div class="form-group">
                <label for="jumlah_batang">Jumlah Batang</label>
                <input type="number" name="jumlah_batang" id="jumlah_batang" class="form-control" placeholder="Masukkan Jumlah Batang" min="0" required>
              </div>
              <div class="form-group">
                <label for="volume_total">Volume Total (m³)</label>
                <input type="number" name="volume_total" id="volume_total" class="form-control" placeholder="Masukkan Volume Total" min="0" step="0.01" required>
              </div>
              <div class="form-group">
                <label for="id_kelurahan">Kelurahan</label>
                <select name="id_kelurahan" id="id_kelurahan" class="form-control" required>
                  <option value="">-- Pilih Kelurahan --</option>
                  <?php while ($kelurahan = mysqli_fetch_assoc($data_kelurahan)): ?>
                    <option value="<?php echo htmlspecialchars($kelurahan['id_kelurahan']); ?>">
                      <?php echo htmlspecialchars($kelurahan['nama_kelurahan']); ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>
            </div>
          </div>
          <div class="text-right">
            <a href="dokumenpkb-lihat.php" class="btn btn-danger">Kembali</a>
            <button type="submit" name="proses" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
</body>
</html>