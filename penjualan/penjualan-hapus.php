<?php
include '../koneksi.php';

// Validasi no_nota
if (!isset($_GET['no_nota']) || empty($_GET['no_nota'])) {
    header("Location: penjualan-lihat.php");
    exit();
}

$no_nota = $_GET['no_nota'];

// Ambil data penjualan untuk ditampilkan
$stmt = $conn->prepare("SELECT * FROM penjualan WHERE no_nota = ?");
$stmt->bind_param("s", $no_nota);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    header("Location: penjualan-lihat.php");
    exit();
}

// Proses hapus data
if (isset($_POST['proses'])) {
    if ($conn) {
        // Gunakan prepared statement untuk hapus detail
        $stmt_detail = $conn->prepare("DELETE FROM detail_penjualan WHERE no_nota = ?");
        if ($stmt_detail) {
            $stmt_detail->bind_param("s", $no_nota);
            $stmt_detail->execute();
            $stmt_detail->close();
        }

        // Gunakan prepared statement untuk hapus penjualan
        $stmt_penjualan = $conn->prepare("DELETE FROM penjualan WHERE no_nota = ?");
        if ($stmt_penjualan) {
            $stmt_penjualan->bind_param("s", $no_nota);
            if ($stmt_penjualan->execute()) {
                header("Location: penjualan-lihat.php?success=delete");
                exit();
            } else {
                $error = "Gagal menghapus data penjualan: " . $stmt_penjualan->error;
            }
            $stmt_penjualan->close();
        } else {
            $error = "Gagal menyiapkan query hapus penjualan: " . $conn->error;
        }
        $conn->close();
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
  <title>Penjualan - Hapus</title>
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
      padding: 20px 15px;
      position: fixed;
      width: 250px;
      top: 0;
      left: 0;
      box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
      transition: width 0.3s ease;
      z-index: 1000;
    }

    .sidebar h4 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
      letter-spacing: 1px;
      color: #74b9ff;
    }

    .sidebar a {
      color: #fff;
      display: flex;
      align-items: center;
      padding: 12px 15px;
      margin: 5px 0;
      text-decoration: none;
      font-size: 1rem;
      border-radius: 8px;
      transition: all 0.3s ease;
    }

    .sidebar a i {
      margin-right: 10px;
      font-size: 1.2rem;
    }

    .sidebar a:hover {
      background-color: rgba(0, 123, 255, 0.3);
      color: #fff;
      transform: translateX(5px);
    }

    .sidebar a.active {
      background-color: #007bff;
      color: #fff;
      font-weight: 600;
    }

    .main {
      margin-left: 260px;
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
    <h4>MBD System</h4>
    <a href="../home.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
    <a href="../customer/customer-lihat.php"><i class="fas fa-users"></i><span>Customer</span></a>
    <a href="../barang/barang-lihat.php"><i class="fas fa-box"></i><span>Barang</span></a>
    <a href="../pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i><span>Pegawai</span></a>
    <a href="../pemeriksa/pemeriksa-lihat.php"><i class="fas fa-user-check"></i><span>Pemeriksa</span></a>
    <a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php"><i class="fas fa-tree"></i><span>Jenis Hasil Hutan</span></a>
    <a href="../pemilik/pemilik-lihat.php"><i class="fas fa-user-shield"></i><span>Pemilik</span></a>
    <a href="../penjualan/penjualan-lihat.php"class="active"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
    <a href="../dokumenpkb/dokumenpkb-lihat.php"><i class="fas fa-file-alt"></i><span>Dokumen PKB</span></a>
    <a href="../index.php" onclick="return confirm('Yakin keluar?')"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
  </div>

  <div class="main">
    <div class="dashboard-header">
      <div>
        <h2 class="text-dark font-weight-bold mb-0">Hapus Penjualan</h2>
        <small class="text-muted">01:42 AM WIB, 15 Juni 2025</small>
      </div>
      <img src="../images/kop.jpg" alt="Logo" height="40">
    </div>

    <div class="card">
      <h5 class="mb-4 text-center">Konfirmasi Hapus Penjualan</h5>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <p>Apakah Anda yakin ingin menghapus data penjualan berikut?</p>
      <div class="form-group">
        <label>No Nota</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['no_nota']); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Customer</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars(getCustomerName($data['id_customer'], $conn)); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Pegawai</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars(getPegawaiName($data['id_pegawai'], $conn)); ?>" readonly>
      </div>
      <div class="form-group">
        <label>Tanggal</label>
        <input type="text" class="form-control" value="<?php echo htmlspecialchars($data['tanggal']); ?>" readonly>
      </div>
      <form action="" method="post">
        <div class="text-right">
          <a href="penjualan-lihat.php" class="btn btn-secondary">Batal</a>
          <input type="submit" name="proses" value="Hapus" class="btn btn-danger">
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <?php
  // Fungsi untuk mendapatkan nama customer berdasarkan id_customer
  function getCustomerName($id_customer, $conn) {
      $stmt = $conn->prepare("SELECT nama_customer FROM customer WHERE id_customer = ?");
      $stmt->bind_param("s", $id_customer);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
      return $row ? $row['nama_customer'] : 'Tidak Ditemukan';
  }

  // Fungsi untuk mendapatkan nama pegawai berdasarkan id_pegawai
  function getPegawaiName($id_pegawai, $conn) {
      $stmt = $conn->prepare("SELECT nama_pegawai FROM pegawai WHERE id_pegawai = ?");
      $stmt->bind_param("s", $id_pegawai);
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $stmt->close();
      return $row ? $row['nama_pegawai'] : 'Tidak Ditemukan';
  }
  ?>
</body>
</html>