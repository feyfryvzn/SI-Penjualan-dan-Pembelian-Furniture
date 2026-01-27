<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    .card-custom {
      border-radius: 20px;
      border: none;
      padding: 20px;
      color: #fff;
    }

    .card-blue {
      background: linear-gradient(135deg, #3a8dde, #007bff);
    }

    .card-lightblue {
      background: linear-gradient(135deg, #74b9ff, #0984e3);
    }

    .card-white {
      background-color: #f8f9fa;
      color: #000;
      border-radius: 20px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .card-white h5 {
      font-weight: 600;
    }

    .badge {
      padding: 5px 10px;
      font-size: 0.75rem;
      border-radius: 10px;
    }

    .dashboard-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
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
    <a href="#" class="active"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a>
    <a href="customer/customer-lihat.php"><i class="fas fa-users"></i><span>Customer</span></a>
    <a href="barang/barang-lihat.php"><i class="fas fa-box"></i><span>Barang</span></a>
    <a href="pegawai/pegawai-lihat.php"><i class="fas fa-user-tie"></i><span>Pegawai</span></a>
    <a href="pemeriksa/pemeriksa-lihat.php"><i class="fas fa-user-check"></i><span>Pemeriksa</span></a>
    <a href="jenis_hasil_hutan/jenis_hasil_hutan-lihat.php"><i class="fas fa-tree"></i><span>Jenis Hasil Hutan</span></a>
    <a href="pemilik/pemilik-lihat.php"><i class="fas fa-user-shield"></i><span>Pemilik</span></a>
    <a href="penjualan/penjualan-lihat.php"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
    <a href="dokumenpkb/dokumenpkb-lihat.php"><i class="fas fa-file-alt"></i><span>Dokumen PKB</span></a>
    <a href="index.php" onclick="return confirm('Yakin ingin logout?')"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
  </div>

  <div class="main">
    <div class="dashboard-header">
      <div>
        <h2 class="text-dark font-weight-bold mb-0">Dashboard</h2>
        <small class="text-muted">14 Juni 2025, 11:07 PM WIB</small>
      </div>
<img src="images/kop.jpg" alt="Logo MBD System" height="40">
      </div>

    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card card-custom card-blue">
          <h5>Jumlah Pelanggan</h5>
          <p class="display-4">
            <?php
            include 'koneksi.php';
            if (!$conn) {
              echo "0";
              error_log("Koneksi database gagal: " . mysqli_connect_error());
            } else {
              $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM customer");
              if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo htmlspecialchars($row['total']);
                $stmt->close();
              } else {
                echo "0";
                error_log("Gagal menyiapkan statement pelanggan: " . $conn->error);
              }
            }
            ?>
          </p>
          <i class="fas fa-users fa-2x"></i>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom card-lightblue">
          <h5>Jumlah Barang</h5>
          <p class="display-4">
            <?php
            if (!$conn) {
              echo "0";
            } else {
              $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM barang");
              if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo htmlspecialchars($row['total']);
                $stmt->close();
              } else {
                echo "0";
                error_log("Gagal menyiapkan statement barang: " . $conn->error);
              }
            }
            ?>
          </p>
          <i class="fas fa-box fa-2x"></i>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card card-custom card-blue">
          <h5>Jumlah Pegawai</h5>
          <p class="display-4">
            <?php
            if (!$conn) {
              echo "0";
            } else {
              $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM pegawai");
              if ($stmt) {
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                echo htmlspecialchars($row['total']);
                $stmt->close();
              } else {
                echo "0";
                error_log("Gagal menyiapkan statement pegawai: " . $conn->error);
              }
              $conn->close();
            }
            ?>
          </p>
          <i class="fas fa-user-tie fa-2x"></i>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-6">
        <div class="card card-white">
          <div class="card-body">
            <h5 class="mb-4">Grafik Penjualan</h5>
            <canvas id="myChart" height="150"></canvas>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card card-white">
          <div class="card-body">
            <h5>Distribusi Pelanggan</h5>
            <canvas id="statusChart" height="150"></canvas>
          </div>
        </div>
      </div>
    </div>

    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card card-white">
          <div class="card-body">
            <h5>Tabel Ringkasan - Pesanan Terbaru</h5>
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th>No. Nota</th>
                  <th>ID Customer</th>
                  <th>ID Pegawai</th>
                  <th>Tanggal</th>
                  <th>Jumlah (Rp)</th>
                  <th>DP (Rp)</th>
                  <th>Sisa (Rp)</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include 'koneksi.php';
                if (!$conn) {
                  echo "<tr><td colspan='8'>Gagal terhubung ke database</td></tr>";
                } else {
                  $stmt = $conn->prepare("
                    SELECT 
                      p.no_nota, 
                      p.id_customer, 
                      p.id_pegawai, 
                      p.tanggal, 
                      SUM(CAST(dp.jumlah AS DECIMAL(15,2))) AS jumlah_Rp, 
                      CAST(p.DP AS DECIMAL(15,2)) AS DP, 
                      (SUM(CAST(dp.jumlah AS DECIMAL(15,2))) - CAST(p.DP AS DECIMAL(15,2))) AS sisa
                    FROM penjualan p
                    JOIN detail_penjualan dp ON p.no_nota = dp.no_nota
                    GROUP BY p.no_nota, p.id_customer, p.id_pegawai, p.tanggal, p.DP
                    ORDER BY p.tanggal DESC 
                    LIMIT 5
                  ");
                  if ($stmt) {
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows === 0) {
                      echo "<tr><td colspan='8'>Tidak ada pesanan terbaru</td></tr>";
                    } else {
                      while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>#{$row['no_nota']}</td>";
                        echo "<td>{$row['id_customer']}</td>";
                        echo "<td>{$row['id_pegawai']}</td>";
                        echo "<td>{$row['tanggal']}</td>";
                        echo "<td>Rp" . number_format($row['jumlah_Rp'], 2, ',', '.') . "</td>";
                        echo "<td>Rp" . number_format($row['DP'], 2, ',', '.') . "</td>";
                        echo "<td>Rp" . number_format($row['sisa'], 2, ',', '.') . "</td>";
                        echo $row['sisa'] <= 0
                          ? "<td><span class='badge badge-success'>Lunas</span></td>"
                          : "<td><span class='badge badge-danger'>Belum Lunas</span></td>";
                        echo "</tr>";
                      }
                    }
                    $stmt->close();
                  } else {
                    echo "<tr><td colspan='8'>Gagal menyiapkan query</td></tr>";
                    error_log("Gagal menyiapkan statement tabel: " . $conn->error);
                  }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <footer class="mt-5 text-center text-muted">
      <small>© 2025 MBD System. All rights reserved.</small>
    </footer>
  </div>

  <script>
    // Grafik Penjualan
    const ctx = document.getElementById('myChart').getContext('2d');
    <?php
    include 'koneksi.php';
    $months = [
        'Jan 2025', 'Feb 2025', 'Mar 2025', 'Apr 2025', 'May 2025', 'Jun 2025',
        'Jul 2025', 'Aug 2025', 'Sep 2025', 'Oct 2025', 'Nov 2025', 'Dec 2025'
    ];
    $salesData = array_fill(0, 12, 0);

    if ($conn) {
      $startDate = '2025-01-01';
      $endDate = '2025-12-31';
      $stmt = $conn->prepare("
        SELECT DATE_FORMAT(p.tanggal, '%b %Y') AS month, SUM(CAST(dp.jumlah AS DECIMAL(15,2))) AS total 
        FROM penjualan p 
        JOIN detail_penjualan dp ON p.no_nota = dp.no_nota 
        WHERE p.tanggal BETWEEN ? AND ?
        GROUP BY DATE_FORMAT(p.tanggal, '%b %Y')
      ");
      if ($stmt) {
        $stmt->bind_param("ss", $startDate, $endDate);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          $monthIndex = array_search($row['month'], $months);
          if ($monthIndex !== false) {
            $salesData[$monthIndex] = $row['total'] ?? 0;
          }
        }
        $stmt->close();
      } else {
        error_log("Gagal menyiapkan statement grafik: " . $conn->error);
      }
    }

    $cities = ['KOTA ADM. JAKARTA UTARA', 'KOTA BEKASI'];
    $cityCounts = [1, 1];
    if ($conn) {
      $customerCities = [
        'P002' => 'KOTA ADM. JAKARTA UTARA', // ponol raya -> Penjaringan
        'P003' => 'KOTA BEKASI' // Kaliabang, pondok ungu permai -> Bekasi
      ];
      $cities = [];
      $cityCounts = [];
      $stmt = $conn->prepare("SELECT id_customer FROM customer");
      if ($stmt) {
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
          $city = $customerCities[$row['id_customer']] ?? 'Lainnya';
          $index = array_search($city, $cities);
          if ($index === false) {
            $cities[] = $city;
            $cityCounts[] = 1;
          } else {
            $cityCounts[$index]++;
          }
        }
        $stmt->close();
      } else {
        error_log("Gagal menyiapkan statement distribusi: " . $conn->error);
      }
      $conn->close();
    }
    // Fallback jika data kosong
    if (empty($cities)) {
      $cities = ['Tidak Ada Data'];
      $cityCounts = [1];
    }
    ?>
    console.log('Labels Penjualan:', <?php echo json_encode($months); ?>);
    console.log('Data Penjualan:', <?php echo json_encode($salesData); ?>);
    console.log('Labels Distribusi:', <?php echo json_encode($cities); ?>);
    console.log('Data Distribusi:', <?php echo json_encode($cityCounts); ?>);
    const myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
          label: 'Total Penjualan (Rp)',
          data: <?php echo json_encode($salesData); ?>,
          backgroundColor: 'rgba(0, 123, 255, 0.2)',
          borderColor: 'rgba(0, 123, 255, 1)',
          borderWidth: 2,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Jumlah (Rp)'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Bulan'
            }
          }
        }
      }
    });

    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
      type: 'doughnut',
      data: {
        labels: <?php echo json_encode($cities); ?>,
        datasets: [{
          data: <?php echo json_encode($cityCounts); ?>,
          backgroundColor: ['#007bff', '#74b9ff', '#dfe6e9'],
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          }
        }
      }
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>