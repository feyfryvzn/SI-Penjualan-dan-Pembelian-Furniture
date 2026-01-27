<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pegawai</title>
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
            transition: margin-left: 0.3s ease;
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

        .table-responsive {
            background-color: #f8f9fa;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
        <a href="../customer/customer.php"><i class="fas fa-users"></i><span>Customer</span></a>
        <a href="../barang/barang-lihat.php"><i class="fas fa-box"></i><span>Barang</span></a>
        <a href="../pegawai/pegawai-lihat.php" class="active"><i class="fas fa-user-tie"></i><span>Pegawai</span></a>
        <a href="../pemeriksa/pemeriksa-lihat.php"><i class="fas fa-user-check"></i><span>Pemeriksa</span></a>
        <a href="../jenis_hasil_hutan/jenis_hasil_hutan-lihat.php"><i class="fas fa-tree"></i><span>Jenis Hasil Hutan</span></a>
        <a href="../pemilik/pemilik-lihat.php"><i class="fas fa-user-shield"></i><span>Pemilik</span></a>
        <a href="../penjualan/penjualan-lihat.php"><i class="fas fa-shopping-cart"></i><span>Penjualan</span></a>
        <a href="../dokumenpkb/dokumenpkb-lihat.php"><i class="fas fa-file-alt"></i><span>Dokumen PKB</span></a>
        <a href="../index.php" onclick="return confirm('Yakin keluar?')"><i class="fas fa-sign-out-alt"></i><span>Logout</span></a>
    </div>

    <div class="main">
        <div class="dashboard-header">
            <div>
                <h2 class="text-dark font-weight-bold mb-0">Data Pegawai</h2>
                <small class="text-muted">15 Juni 2025, 12:22 AM WIB</small>
            </div>
            <img src="../images/kop.jpg" alt="Logo" height="40">
        </div>

        <div style="text-align: end; margin-bottom: 20px;">
            <a href="pegawai-tambah.php" class="btn btn-warning" type="button">+ TAMBAHKAN</a>
        </div>

        <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
                <thead class="table-primary">
                    <tr>
                        <th>ID Pegawai</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    if (!$conn) {
                        echo "<tr><td colspan='4'>Gagal terhubung ke database</td></tr>";
                    } else {
                        $query = mysqli_query($conn, "SELECT * FROM pegawai");
                        if ($query) {
                            if (mysqli_num_rows($query) == 0) {
                                echo "<tr><td colspan='4'>Tidak ada data pegawai</td></tr>";
                            } else {
                                while ($data = mysqli_fetch_array($query)) {
                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($data['id_pegawai']); ?></td>
                                        <td style="text-align: start;"><?php echo htmlspecialchars($data['nama_pegawai']); ?></td>
                                        <td><?php echo htmlspecialchars($data['jabatan']); ?></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-sm btn-success" href="pegawai-ubah.php?id_pegawai=<?php echo urlencode($data['id_pegawai']); ?>" data-toggle="tooltip" title="Ubah"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-sm btn-danger" href="pegawai-hapus.php?id_pegawai=<?php echo urlencode($data['id_pegawai']); ?>" data-toggle="tooltip" title="Hapus"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                    <?php
                                }
                            }
                            mysqli_free_result($query);
                        } else {
                            echo "<tr><td colspan='4'>Gagal menjalankan query</td></tr>";
                            error_log("Query pegawai gagal: " . mysqli_error($conn));
                        }
                        mysqli_close($conn);
                    }
                    ?>
                </tbody>
            </table>
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

            // Enable tooltips
            $('[data-toggle="tooltip"]').tooltip();

            // Tampilkan SweetAlert2 berdasarkan parameter success
            <?php if (isset($_GET['success'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '<?php 
                        switch ($_GET['success']) {
                            case 'add':
                                echo 'Data pegawai berhasil ditambahkan!';
                                break;
                            case 'update':
                                echo 'Data pegawai berhasil diubah!';
                                break;
                            case 'delete':
                                echo 'Data pegawai berhasil dihapus!';
                                break;
                            default:
                                echo 'Data pegawai berhasil ditambahkan!';
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