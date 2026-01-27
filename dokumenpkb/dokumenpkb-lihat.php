<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dokumen PKB</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
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
    padding: 20px 10px;
    position: fixed;
    width: 70px;
    top: 0;
    left: 0;
    box-shadow: 2px 0 8px rgba(0, 0, 0, 0.15);
    transition: width 0.3s ease, transform 0.3s ease;
    z-index: 1000;
  }

  .sidebar a {
    color: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 12px;
    margin: 5px 0;
    text-decoration: none;
    font-size: 1.1rem;
    border-radius: 8px;
    transition: background-color 0.3s ease;
  }

  .sidebar a i {
    font-size: 1.4rem;
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
    padding: 20px;
    transition: margin-left 0.3s ease;
  }

  .dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
  }

  .btn-warning {
    background: linear-gradient(135deg, #ffca2c, #ffda6a);
    border: none;
    color: #000;
    font-weight: 600;
    padding: 8px 16px;
  }

  .btn-warning:hover {
    background: linear-gradient(135deg, #ffda6a, #ffca2c);
    color: #000;
  }

  .btn-success, .btn-danger, .btn-secondary {
    padding: 6px 12px;
  }

  .card {
    background-color: #f8f9fa;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .table-responsive {
    border-radius: 10px;
    overflow-x: auto;
  }

  .table thead th {
    background: linear-gradient(180deg, #0b1e33, #0d2744);
    color: #fff;
    border: none;
  }

  .table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
  }

  .alert {
    border-radius: 8px;
  }

  /* Media Queries */
  @media (max-width: 992px) {
    .sidebar {
      width: 60px;
      padding: 15px 5px;
    }

    .sidebar a i {
      font-size: 1.2rem;
    }

    .main {
      margin-left: 70px;
    }
  }

  @media (max-width: 768px) {
    .sidebar {
      width: 50px;
      transform: translateX(0);
    }

    .sidebar.collapsed {
      transform: translateX(-100%);
    }

    .main {
      margin-left: 60px;
    }

    .main.collapsed {
      margin-left: 0;
    }

    .table-responsive {
      font-size: 0.9rem;
    }

    .btn-sm {
      padding: 5px 10px;
      font-size: 0.8rem;
    }
  }

  @media (max-width: 576px) {
    .sidebar {
      width: 45px;
    }

    .main {
      margin-left: 50px;
      padding: 15px;
    }

    .dashboard-header h2 {
      font-size: 1.5rem;
    }

    .dashboard-header img {
      height: 30px;
    }

    .table-responsive {
      font-size: 0.8rem;
    }

    .btn-warning {
      padding: 6px 12px;
      font-size: 0.9rem;
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
        <h2 class="text-dark font-weight-bold mb-0">Data Dokumen PKB</h2>
        <small class="text-muted">15 Juni 2025, 02:02 AM WIB</small>
      </div>
      <img src="../images/kop.jpg" alt="Logo" height="40">
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5>Data Dokumen PKB</h5>
        <a href="dokumenpkb-tambah.php" class="btn btn-warning">+ TAMBAHKAN</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
            <thead>
              <tr>
                <th>No DKB</th>
                <th>Pemilik</th>
                <th>Pemeriksa</th>
                <th>Tanggal Pembuatan</th>
                <th>Tempat Muat</th>
                <th>No SKKK</th>
                <th>Jumlah Batang</th>
                <th>Volume Total</th>
                <th>Kelurahan</th>
                <th>Aksi</th>
                <th>Keterangan</th>
              </tr>
            </thead>
            <tbody>
              <?php
              include '../koneksi.php';
              if (!$conn) {
                echo "<tr><td colspan='11'>Gagal terhubung ke database</td></tr>";
              } else {
                $stmt = $conn->prepare("
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
                ");
                if ($stmt) {
                  $stmt->execute();
                  $result = $stmt->get_result();
                  if ($result->num_rows == 0) {
                    echo "<tr><td colspan='11'>Tidak ada data dokumen PKB</td></tr>";
                  } else {
                    while ($data = $result->fetch_assoc()) {
              ?>
                      <tr>
                        <td><?php echo htmlspecialchars($data['no_dkb']); ?></td>
                        <td style="text-align: start;"><?php echo htmlspecialchars($data['nama_pemilik']); ?></td>
                        <td style="text-align: start;"><?php echo htmlspecialchars($data['nama_pemeriksa']); ?></td>
                        <td><?php echo htmlspecialchars($data['tanggal_pembuatan']); ?></td>
                        <td><?php echo htmlspecialchars($data['tempat_muat']); ?></td>
                        <td><?php echo htmlspecialchars($data['no_skkk']); ?></td>
                        <td><?php echo htmlspecialchars($data['jumlah_batang']); ?></td>
                        <td><?php echo htmlspecialchars($data['volume_total']); ?> m³</td>
                        <td><?php echo htmlspecialchars($data['nama_kelurahan']); ?></td>
                        <td>
                          <div class="btn-group" role="group">
                            <a class="btn btn-sm btn-success" href="dokumenpkb-ubah.php?no_dkb=<?php echo urlencode($data['no_dkb']); ?>" data-toggle="tooltip" title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                            <a class="btn btn-sm btn-danger" href="dokumenpkb-hapus.php?no_dkb=<?php echo urlencode($data['no_dkb']); ?>" data-toggle="tooltip" title="Hapus"><i class="fas fa-trash"></i></a>
                          </div>
                        </td>
                        <td>
                          <div class="btn-group" role="group">
                            <a class="btn btn-sm btn-secondary" href="dokumenpkb-detail.php?no_dkb=<?php echo urlencode($data['no_dkb']); ?>" data-toggle="tooltip" title="Detail"><i class="fas fa-eye"></i></a>
                             <a class="btn btn-sm btn-primary" href="dokumenpkbcetak.php?no_dkb=<?php echo urlencode($data['no_dkb']); ?>" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i></a>

                          </div>
                        </td>
                      </tr>
              <?php
                    }
                  }
                  $stmt->close();
                } else {
                  echo "<tr><td colspan='11'>Gagal menjalankan query</td></tr>";
                  error_log("Query dokumenpkb gagal: " . $conn->error);
                }
                $conn->close();
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.9/dist/sweetalert2.all.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });

      $('[data-toggle="tooltip"]').tooltip();

      <?php if (isset($_GET['success'])): ?>
        Swal.fire({
          icon: 'success',
          title: 'Berhasil!',
          text: '<?php 
            switch ($_GET['success']) {
              case 'add':
                echo 'Data dokumen PKB berhasil ditambahkan!';
                break;
              case 'update':
                echo 'Data dokumen PKB berhasil diubah!';
                break;
              case 'delete':
                echo 'Data dokumen PKB berhasil dihapus!';
                break;
              default:
                echo 'Aksi berhasil!';
            }
          ?>',
          showConfirmButton: false,
          timer: 3000
        });
      <?php endif; ?>
    });
  </script>
</body>
</html>