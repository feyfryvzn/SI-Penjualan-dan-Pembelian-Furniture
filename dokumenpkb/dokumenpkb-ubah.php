<?php
include '../koneksi.php';

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

$error = '';
$success = '';

// Sanitasi no_dkb dari GET
$no_dkb_get = isset($_GET['no_dkb']) ? mysqli_real_escape_string($conn, $_GET['no_dkb']) : '';
if (empty($no_dkb_get)) {
    header("Location: dokumenpkb-lihat.php");
    exit();
}

// Ambil data dokumenpkb
$stmt = $conn->prepare("SELECT * FROM dokumenpkb WHERE no_dkb = ?");
$stmt->bind_param("s", $no_dkb_get);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    header("Location: dokumenpkb-lihat.php");
    exit();
}

// Ambil data referensi
$pemilik_result = mysqli_query($conn, "SELECT id_pemilik, nama_pemilik FROM pemilik");
$pemeriksa_result = mysqli_query($conn, "SELECT id_pemeriksa, nama_pemeriksa FROM pemeriksa");
$kelurahan_result = mysqli_query($conn, "SELECT id_kelurahan, nama_kelurahan FROM kelurahan");

if (!$pemilik_result || !$pemeriksa_result || !$kelurahan_result) {
    $error = "Gagal mengambil data referensi: " . mysqli_error($conn);
}

if (isset($_POST['proses'])) {
    $no_dkb = mysqli_real_escape_string($conn, $_POST['no_dkb']);
    $id_pemilik = mysqli_real_escape_string($conn, $_POST['id_pemilik']);
    $id_pemeriksa = mysqli_real_escape_string($conn, $_POST['id_pemeriksa']);
    $tanggal_pembuatan = mysqli_real_escape_string($conn, $_POST['tanggal_pembuatan']);
    $tempat_muat = mysqli_real_escape_string($conn, $_POST['tempat_muat']);
    $no_skkk = mysqli_real_escape_string($conn, $_POST['no_skkk']); 
    $jumlah_batang = mysqli_real_escape_string($conn, $_POST['jumlah_batang']);
    $volume_total = mysqli_real_escape_string($conn, $_POST['volume_total']);
    $id_kelurahan = mysqli_real_escape_string($conn, $_POST['id_kelurahan']);

    // Validasi sederhana
    if ($no_dkb !== $no_dkb_get) {
        $error = "No DKB tidak sesuai.";
    } elseif (empty($no_dkb) || empty($id_pemilik) || empty($id_pemeriksa) || empty($tanggal_pembuatan) || 
             empty($tempat_muat) || empty($no_skkk) || empty($jumlah_batang) || empty($volume_total) || empty($id_kelurahan)) {
        $error = "Semua field harus diisi.";
    } elseif (!is_numeric($jumlah_batang) || $jumlah_batang < 0) {
        $error = "Jumlah batang harus berupa angka positif.";
    } elseif (!is_numeric($volume_total) || $volume_total < 0) {
        $error = "Volume total harus berupa angka positif.";
    } else {
        // Update data
        $stmt = $conn->prepare("UPDATE dokumenpkb SET id_pemilik = ?, id_pemeriksa = ?, tanggal_pembuatan = ?, tempat_muat = ?, no_skkk = ?, jumlah_batang = ?, volume_total = ?, id_kelurahan = ? WHERE no_dkb = ?");
        $stmt->bind_param("sssssidss", $id_pemilik, $id_pemeriksa, $tanggal_pembuatan, $tempat_muat, $no_skkk, $jumlah_batang, $volume_total, $id_kelurahan, $no_dkb);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            header("Location: dokumenpkb-lihat.php?success=update");
            exit();
        } else {
            $error = "Gagal memperbarui data: " . htmlspecialchars($stmt->error);
            error_log("Update dokumenpkb gagal: " . $stmt->error);
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ubah Dokumen PKB</title>
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

    .alert {
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
        <h2 class="text-dark font-weight-bold mb-0">Ubah Dokumen PKB</h2>
        <small class="text-muted"><?php echo date('d F Y, H:i A T'); ?></small>
      </div>
      <img src="../images/kop.jpg" alt="Logo" height="40">
    </div>

    <div class="card">
      <div class="card-header">
        <h5>Ubah Dokumen PKB</h5>
      </div>
      <div class="card-body">
        <?php if ($error): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form action="" method="post">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="no_dkb">No DKB</label>
                <input type="text" name="no_dkb" id="no_dkb" class="form-control" value="<?php echo htmlspecialchars($data['no_dkb']); ?>" readonly>
              </div>
              <div class="form-group">
                <label for="id_pemilik">Pemilik</label>
                <select name="id_pemilik" id="id_pemilik" class="form-control" required>
                  <option value="">-- Pilih Pemilik --</option>
                  <?php while ($pemilik = mysqli_fetch_assoc($pemilik_result)): ?>
                    <option value="<?php echo htmlspecialchars($pemilik['id_pemilik']); ?>" <?php echo ($data['id_pemilik'] == $pemilik['id_pemilik']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($pemilik['nama_pemilik']); ?>
                    </option>
                  <?php endwhile; mysqli_data_seek($pemilik_result, 0); ?>
                </select>
              </div>
              <div class="form-group">
                <label for="id_pemeriksa">Pemeriksa</label>
                <select name="id_pemeriksa" id="id_pemeriksa" class="form-control" required>
                  <option value="">-- Pilih Pemeriksa --</option>
                  <?php while ($pemeriksa = mysqli_fetch_assoc($pemeriksa_result)): ?>
                    <option value="<?php echo htmlspecialchars($pemeriksa['id_pemeriksa']); ?>" <?php echo ($data['id_pemeriksa'] == $pemeriksa['id_pemeriksa']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($pemeriksa['nama_pemeriksa']); ?>
                    </option>
                  <?php endwhile; mysqli_data_seek($pemeriksa_result, 0); ?>
                </select>
              </div>
              <div class="form-group">
                <label for="tanggal_pembuatan">Tanggal Pembuatan</label>
                <input type="date" name="tanggal_pembuatan" id="tanggal_pembuatan" class="form-control" value="<?php echo htmlspecialchars($data['tanggal_pembuatan']); ?>" required>
              </div>
              <div class="form-group">
                <label for="tempat_muat">Tempat Muat</label>
                <input type="text" name="tempat_muat" id="tempat_muat" class="form-control" value="<?php echo htmlspecialchars($data['tempat_muat']); ?>" placeholder="Masukkan Tempat Muat" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <label for="no_skkk">No SKKK</label>
                <input type="text" name="no_skkk" id="no_skkk" class="form-control" value="<?php echo htmlspecialchars($data['no_skkk']); ?>" placeholder="Masukkan No SKKK" required>
              </div>
              <div class="form-group">
                <label for="jumlah_batang">Jumlah Batang</label>
                <input type="number" name="jumlah_batang" id="jumlah_batang" class="form-control" value="<?php echo htmlspecialchars($data['jumlah_batang']); ?>" placeholder="Masukkan Jumlah Batang" min="0" required>
              </div>
              <div class="form-group">
                <label for="volume_total">Volume Total (m³)</label>
                <input type="number" name="volume_total" id="volume_total" class="form-control" value="<?php echo htmlspecialchars($data['volume_total']); ?>" placeholder="Masukkan Volume Total" min="0" step="0.01" required>
              </div>
              <div class="form-group">
                <label for="id_kelurahan">Kelurahan</label>
                <select name="id_kelurahan" id="id_kelurahan" class="form-control" required>
                  <option value="">-- Pilih Kelurahan --</option>
                  <?php while ($kelurahan = mysqli_fetch_assoc($kelurahan_result)): ?>
                    <option value="<?php echo htmlspecialchars($kelurahan['id_kelurahan']); ?>" <?php echo ($data['id_kelurahan'] == $kelurahan['id_kelurahan']) ? 'selected' : ''; ?>>
                      <?php echo htmlspecialchars($kelurahan['nama_kelurahan']); ?>
                    </option>
                  <?php endwhile; mysqli_data_seek($kelurahan_result, 0); ?>
                </select>
              </div>
            </div>
          </div>
          <div class="text-right">
            <a href="dokumenpkb-lihat.php" class="btn btn-danger">Kembali</a>
            <button type="submit" name="proses" class="btn btn-success">Ubah</button>
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