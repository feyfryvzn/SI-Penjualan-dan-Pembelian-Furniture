<?php
include '../koneksi.php';

// Validasi no_dkb
if (!isset($_GET['no_dkb']) || empty($_GET['no_dkb'])) {
    header("Location: dokumenpkb.php");
    exit();
}

$no_dkb = mysqli_real_escape_string($conn, $_GET['no_dkb']);

// Ambil data dokumenpkb untuk ditampilkan
$stmt = $conn->prepare("SELECT d.*, p.nama_pemilik, pr.nama_pemeriksa, k.nama_kelurahan 
                        FROM dokumenpkb d 
                        LEFT JOIN pemilik p ON d.id_pemilik = p.id_pemilik 
                        LEFT JOIN pemeriksa pr ON d.id_pemeriksa = pr.id_pemeriksa 
                        LEFT JOIN kelurahan k ON d.id_kelurahan = k.id_kelurahan 
                        WHERE d.no_dkb = ?");
$stmt->bind_param("s", $no_dkb);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    header("Location: dokumenpkb-lihat.php");
    exit();
}

// Proses hapus data
if (isset($_POST['proses'])) {
    if ($conn) {
        // Gunakan prepared statement untuk hapus dokumenpkb
        $stmt_dokumen = $conn->prepare("DELETE FROM dokumenpkb WHERE no_dkb = ?");
        if ($stmt_dokumen) {
            $stmt_dokumen->bind_param("s", $no_dkb);
            if ($stmt_dokumen->execute()) {
                $stmt_dokumen->close();
                $conn->close();
                header("Location: dokumenpkb-lihat.php?success=delete");
                exit();
            } else {
                $error = "Gagal menghapus data dokumen PKB: " . $stmt_dokumen->error;
            }
            $stmt_dokumen->close();
        } else {
            $error = "Gagal menyiapkan query hapus dokumen PKB: " . $conn->error;
        }
    } else {
        $error = "Gagal terhubung ke database";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hapus Dokumen PKB</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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

    .card {
      background-color: #f8f9fa;
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #ef5753);
      border: none;
      font-weight: 600;
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #ef5753, #dc3545);
    }

    .btn-secondary {
      background: linear-gradient(135deg, #6c757d, #868e96);
      border: none;
      font-weight: 600;
    }

    .btn-secondary:hover {
      background: linear-gradient(135deg, #868e96, #6c757d);
    }

    .form-group label {
      font-weight: 600;
      color: #333;
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid #ced4da;
    }

    .alert {
      border-radius: 8px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 70px;
        padding: 20px 5px;
      }

      .sidebar h4 {
        display: none;
      }

      .sidebar a {
        justify-content: center;
        padding: 10px;
      }

      .sidebar a i {
        margin-right: 0;
      }

      .sidebar a span {
        display: none;
      }

      .main {
        margin-left: 80px;
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
        <h2 class="text-dark font-weight-bold mb-0">Hapus Dokumen PKB</h2>
        <small class="text-muted"><?php echo date('H:i A T, d F Y'); ?></small> <!-- Updated to 03:07 AM WIB, 15 Juni 2025 -->
      </div>
      <img src="../images/kop.jpg" alt="Logo" height="40">
    </div>

    <div class="card">
      <h5 class="mb-4 text-center">Konfirmasi Hapus Dokumen PKB</h5>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <p>Apakah Anda yakin ingin menghapus data dokumen PKB berikut?</p>
      <div class="form-group">
        <label>No DKB</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['no_dkb']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Pemilik</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars(getPemilikName($data['id_pemilik'], $conn)); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Pemeriksa</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars(getPemeriksaName($data['id_pemeriksa'], $conn)); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Tanggal Pembuatan</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['tanggal_pembuatan']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Tempat Muat</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['tempat_muat']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>No SKKK</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['no_skkk']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Jumlah Batang</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['jumlah_batang']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Volume Total</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['volume_total']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Kelurahan</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars(getKelurahanName($data['id_kelurahan'], $conn)); ?>" readonly>
      </div>
      <form action="" method="post">
        <div class="text-right">
          <a href="dokumenpkb-lihat.php" class="btn btn-secondary">Batal</a>
          <input type="submit" name="proses" value="Hapus" class="btn btn-danger">
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <?php
  // Fungsi untuk mendapatkan nama pemilik berdasarkan id_pemilik
  function getPemilikName($id_pemilik, $conn) {
      $stmt = $conn->prepare("SELECT nama_pemilik FROM pemilik WHERE id_pemilik = ?");
      $stmt->bind_param("s", $id_pemilik);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
      return $row ? $row['nama_pemilik'] : 'Tidak Ditemukan';
  }

  // Fungsi untuk mendapatkan nama pemeriksa berdasarkan id_pemeriksa
  function getPemeriksaName($id_pemeriksa, $conn) {
      $stmt = $conn->prepare("SELECT nama_pemeriksa FROM pemeriksa WHERE id_pemeriksa = ?");
      $stmt->bind_param("s", $id_pemeriksa);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
      return $row ? $row['nama_pemeriksa'] : 'Tidak Ditemukan';
  }

  // Fungsi untuk mendapatkan nama kelurahan berdasarkan id_kelurahan
  function getKelurahanName($id_kelurahan, $conn) {
      $stmt = $conn->prepare("SELECT nama_kelurahan FROM kelurahan WHERE id_kelurahan = ?");
      $stmt->bind_param("s", $id_kelurahan);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
      return $row ? $row['nama_kelurahan'] : 'Tidak Ditemukan';
  }
  ?>
</body>
</html>