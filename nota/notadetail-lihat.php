<?php
include '../koneksi.php';

// Periksa apakah 'nota_no' ada di URL
if (isset($_GET['nota_no'])) {
    $nota_no = $_GET['nota_no'];
    $query = mysqli_query($conn, "SELECT * FROM nota n, pelanggan p WHERE n.nopol = p.nopol AND n.nota_no = '$nota_no'");
    $data = mysqli_fetch_array($query);
    // Mengubah format tanggal ke dd/mm/yyyy
    $tanggal = date('d/m/Y', strtotime($data['tanggal']));

    // Periksa apakah query SQL berhasil mengambil data
    if ($data) {
        // Lanjutkan dengan proses normal jika data ada
    } else {
        // Tangani kasus di mana data tidak ditemukan
        die("Nota tidak ditemukan.");
    }
} else {
    // Tangani kasus di mana 'nota_no' tidak ada di URL
    die("Nota nomor tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>notadetail-lihat</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>
    <form action="" method="post">
        <div class="wrapper d-flex align-items-stretch">
            <nav id="sidebar">
                <div class="p-4 pt-5">
                    <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../images/bengkel.png);"></a>
                    <ul class="list-unstyled components mb-5">
                        <li><a href="../home.php">Home</a></li>
                        <li><a href="../pelanggan/pelanggan-lihat.php">Pelanggan</a></li>
                        <li><a href="../barang/barang-lihat.php">Barang</a></li>
                        <li class="active"><a href="#" data-toggle="collapse" aria-expanded="false">Nota</a></li>
                        <li>
            <a href="../index.php" onclick="return confirm('yakin keluar?')">Logout</a>
          </li>
                    </ul>
                    <div class="footer">
          <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            Mbd &copy;<script>
              document.write(new Date().getFullYear());
            </script> <br>  <i class="icon-heart" aria-hidden="true"></i>
            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
        </div>
                </div>
            </nav>

            <!-- Page Content -->
            <div id="content" class="p-4 p-md-5">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <button type="button" id="sidebarCollapse" class="btn btn-primary">
                            <i class="fa fa-bars"></i>
                            <span class="sr-only">Toggle Menu</span>
                        </button>
                        <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="fa fa-bars"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="nav navbar-nav ml-auto">
                                <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
                                <li class="nav-item"><a class="nav-link" href="#pelanggan">Pelanggan</a></li>
                                <li class="nav-item"><a class="nav-link" href="../barang/barang-lihat.php">Barang</a></li>
                                <li class="nav-item active"><a class="nav-link" href="#">Nota</a></li>
                                
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="form">
                    <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">DETAIL NOTA: <?php echo htmlspecialchars($data['nota_no']); ?></label>
                    <hr>
                    <a class="btn btn-danger btn-sm" href="nota-lihat.php">Kembali</a>
                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">NO NOTA</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['nota_no']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
                        <input class="form-control" value="<?php echo $tanggal; ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">KM MOBIL</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['km_mobil']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">NOPOL</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['nopol']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>

                    <div class="form-element">
                        <label class="form-label" style="display: inline-block; width: 100px;">KASIR</label>
                        <input class="form-control" value="<?php echo htmlspecialchars($data['kasir']); ?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                    </div>
                </div>

                <br>

                <label class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TABEL DETAIL NOTA</label>
                <hr>
                <div class="mb-3">
                    <a type="button" class="btn btn-success" href="notadetail-tambah.php?nota_no=<?php echo htmlspecialchars($data['nota_no']); ?>">Tambah</a>
                    <a type="button" class="btn btn-warning" href="notacetak.php?nota_no=<?php echo htmlspecialchars($data['nota_no']); ?>" style="color:white;">Cetak</a>
                </div>
                <table width='100%' border=1 style="text-align: center;">
                    <tr class="table-primary" style="color: black; text-align: center;">
                        <th>No</th>
                        <th>Banyaknya</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>

                    <?php
                    include '../koneksi.php';

                    $index = 1;
                    $query = mysqli_query($conn, "SELECT B.no_barang, B.nama_barang, B.harga_satuan, DB.banyaknya, N.nota_no, DB.jumlah
                                              FROM nota N
                                              JOIN detailbarang DB ON N.nota_no = DB.nota_no
                                              JOIN barang B ON DB.no_barang = B.no_barang
                                              WHERE N.nota_no = '$nota_no'");

                    $jumlah_rp = 0; // Inisialisasi grand total

                    while ($data_barang = mysqli_fetch_array($query)) {
                        $jumlah = $data_barang['harga_satuan'] * $data_barang['banyaknya'];
                        $jumlah_rp += $jumlah;

                        $updateFakturQuery = "UPDATE nota SET jumlah_rp = '$jumlah_rp' WHERE nota_no = '$nota_no'";
                        mysqli_query($conn, $updateFakturQuery);
                    ?>

                        <tr>
                            <td><?php echo htmlspecialchars($index++); ?></td>
                            <td><?php echo htmlspecialchars($data_barang['banyaknya']); ?></td>
                            <td><?php echo htmlspecialchars($data_barang['nama_barang']); ?></td>
                            <td><?php echo htmlspecialchars($data_barang['harga_satuan']); ?></td>
                            <td><?php echo htmlspecialchars($jumlah); ?></td>
                            <td>
                                <a class="btn btn-primary btn-sm" type="button" href="notadetail-ubah.php?nota_no=<?php echo htmlspecialchars($data_barang['nota_no']); ?>&no_barang=<?php echo htmlspecialchars($data_barang['no_barang']); ?>">Ubah</a> |
                                <a class="btn btn-danger btn-sm" type="button" href="notadetail-hapus.php?nota_no=<?php echo htmlspecialchars($data_barang['nota_no']);
                                                                                                                    ?>&no_barang=<?php echo htmlspecialchars($data_barang['no_barang']); ?>" onclick="return confirm('Yakin hapus?')">Hapus</a>
                            </td>
                        </tr>

                    <?php } ?>
                    <tr>
                        <td colspan="4" style="text-align: center;"> <strong> TOTAL HARGA </strong> </td>
                        <td><?php echo htmlspecialchars($jumlah_rp); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </form>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/sidebar.js"></script>
</body>

</html>
