<?php
include '../koneksi.php';

// Ambil data pemeriksa berdasarkan id_pemeriksa
if (!isset($_GET['id_pemeriksa']) || empty($_GET['id_pemeriksa'])) {
    header("Location: pemeriksa-lihat.php");
    exit();
}

$id_pemeriksa = $_GET['id_pemeriksa'];
$stmt = $conn->prepare("SELECT * FROM pemeriksa WHERE id_pemeriksa = ?");
$stmt->bind_param("s", $id_pemeriksa);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    header("Location: pemeriksa-lihat.php");
    exit();
}

// Proses update data
if (isset($_POST['proses'])) {
    $nama_pemeriksa = $_POST['nama_pemeriksa'];
    $no_registrasi = $_POST['no_registrasi'];
    $instansi = $_POST['instansi'];

    // Validasi input
    if (empty($nama_pemeriksa) || empty($no_registrasi) || empty($instansi)) {
        $error = "Semua kolom harus diisi!";
    } else {
        if ($conn) {
            $stmt = $conn->prepare("UPDATE pemeriksa SET nama_pemeriksa = ?, no_registrasi = ?, instansi = ? WHERE id_pemeriksa = ?");
            if ($stmt) {
                $stmt->bind_param("ssss", $nama_pemeriksa, $no_registrasi, $instansi, $id_pemeriksa);
                if ($stmt->execute()) {
                    header("Location: pemeriksa-lihat.php?success=update");
                    exit();
                } else {
                    $error = "Gagal menyimpan data: " . $stmt->error;
                }
                $stmt->close();
            } else {
                $error = "Gagal menyiapkan query: " . $conn->error;
            }
            $conn->close();
        } else {
            $error = "Gagal terhubung ke database";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pemeriksa - Ubah</title>
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

    .btn-success {
      background: linear-gradient(135deg, #28a745, #38c172);
      border: none;
      font-weight: 600;
    }

    .btn-success:hover {
      background: linear-gradient(135deg, #38c172, #28a745);
    }

    .btn-danger {
      background: linear-gradient(135deg, #dc3545, #ef5753);
      border: none;
      font-weight: 600;
    }

    .btn-danger:hover {
      background: linear-gradient(135deg, #ef5753, #dc3545);
    }

    .form-group label {
      font-weight: 600;
      color: #333;
    }

    .form-control {
      border-radius: 8px;
      border: 1px solid #ced4da;
    }

    .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
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
    <a href="./pemeriksa-lihat.php" class="active"><i class="fas fa-user-check"></i><span>Pemeriksa</span></a>
    <a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php"><i class="fas fa-tree"></i><span>Jenis Hasil Hutan</span></a>
    <a href="../pemilik/pemilik-lihat.php"><i class="fas fa-user-shield"></i><span>Pemilik</span></a>
    <a href="../penjualan/penjualan-lihat.php"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
    <a href="../dokumenpkb/dokumenpkb-lihat.php"><i class="fas fa-file-alt"></i><span>Dokumen PKB</span></a>
    <a href="../index.php" onclick="return confirm('Yakin keluar?')"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
  </div>

  <div class="main">
    <div class="dashboard-header">
      <div>
        <h2 class="text-dark font-weight-bold mb-0">Ubah Pemeriksa</h2>
        <small class="text-muted">01:10 AM WIB, 15 Juni 2025</small>
      </div>
      <img src="../images/kop.jpg" alt="Logo" height="40">
    </div>

    <div class="card">
      <h5 class="mb-4 text-center">Form Ubah Pemeriksa</h5>
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form action="" method="post">
        <div class="form-group">
          <label for="id_pemeriksa">ID Pemeriksa</label>
          <input type="text" name="id_pemeriksa" id="id_pemeriksa" class="form-control" value="<?php echo htmlspecialchars($data['id_pemeriksa']); ?>" readonly>
        </div>
        <div class="form-group">
          <label for="nama_pemeriksa">Nama</label>
          <input type="text" name="nama_pemeriksa" id="nama_pemeriksa" class="form-control" placeholder="Masukkan Nama Pemeriksa" value="<?php echo htmlspecialchars($data['nama_pemeriksa']); ?>">
        </div>
        <div class="form-group">
          <label for="no_registrasi">No Registrasi</label>
          <input type="text" name="no_registrasi" id="no_registrasi" class="form-control" placeholder="Masukkan No Registrasi" value="<?php echo htmlspecialchars($data['no_registrasi']); ?>">
        </div>
        <div class="form-group">
          <label for="instansi">Instansi</label>
          <input type="text" name="instansi" id="instansi" class="form-control" placeholder="Masukkan Instansi" value="<?php echo htmlspecialchars($data['instansi']); ?>">
        </div>
        <div class="text-right">
          <a href="pemeriksa-lihat.php" class="btn btn-danger">Kembali</a>
          <input type="submit" name="proses" value="Ubah" class="btn btn-success">
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>