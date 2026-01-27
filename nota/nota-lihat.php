<!doctype html>
<html lang="en">

<head>
  <title>Nota Lihat</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../css/sidebar.css">
</head>

<body>

  <div class="wrapper d-flex align-items-stretch">
    <nav id="sidebar">
      <div class="p-4 pt-5">
        <a href="#" class="img logo rounded-circle mb-5" style="background-image: url(../images/bengkel.png);"></a>
        <ul class="list-unstyled components mb-5">
          <li>
            <a href="../home.php">Home</a>
          </li>
          <li>
            <a href="../pelanggan/pelanggan-lihat.php">Pelanggan</a>
          </li>
          <li>
          <a href="../barang/barang-lihat.php">Barang</a>
          </li>
          <li class="active">
            <a href="#" data-toggle="collapse" aria-expanded="false">Nota</a>
          </li>
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

    <!-- Page Content  -->
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
              <li class="nav-item">
                <a class="nav-link" href="../home.php">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#pelanggan">Pelanggan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../barang/barang-lihat.php">Barang</a>
              </li>
              <li class="nav-item active">
                <a class="nav-link" href="#">Nota</a>
              </li>
             
            </ul>
          </div>
        </div>
      </nav>

      <div style="text-align: end; margin-top:-25px;"><a href="nota-tambah.php" class="btn btn-warning" type="button">+ TAMBAHKAN</a></div>
       <div class="table-responsive" style="margin-top: 5px;">
        <table id="example" class="table table-striped table-bordered" style="width:100%; text-align: center;">
          <thead class="table-primary">
            <tr>
              <th>NOTA NO</th>
              <th>TANGGAL</th>
              <th>KM MOBIL</th>
              <th>NOPOL</th>
              <th>KASIR</th>
              <th>JUMLAH RP</th>
              <th>Aksi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php
            include '../koneksi.php';
            $query = mysqli_query($conn, "SELECT nota.nota_no, nota.tanggal, nota.km_mobil, pelanggan.nopol, nota.kasir
                        FROM nota 
                        INNER JOIN pelanggan ON nota.nopol = pelanggan.nopol");
            while ($data = mysqli_fetch_array($query)) {
              $query_jumlah_detail = mysqli_query($conn, "SELECT SUM(jumlah) AS total FROM detailbarang WHERE nota_no = '" . $data['nota_no'] . "'");
              $jumlah_detail = mysqli_fetch_assoc($query_jumlah_detail)['total'];
              // Mengubah format tanggal ke dd/mm/yyyy
              $tanggal = date('d/m/Y', strtotime($data['tanggal']));
            ?>
              <tr>
                <td><?php echo $data['nota_no']; ?></td>
                <td><?php echo $tanggal; ?></td>
                <td><?php echo $data['km_mobil']; ?></td>
                <td><?php echo $data['nopol']; ?></td>
                <td><?php echo $data['kasir']; ?></td>
                <td><?php echo $jumlah_detail; ?></td>
                <td>
                  <a class="btn btn-success" href="nota-ubah.php?nota_no=<?php echo $data['nota_no']; ?>">Ubah</a> |
                  <a class="btn btn-danger" href="nota-hapus.php?nota_no=<?php echo $data['nota_no']; ?>" onclick="return confirm('yakin hapus?')">Hapus</a>
                </td>
                <td>
                  <a class="btn btn-secondary" href="notadetail-lihat.php?nota_no=<?php echo $data['nota_no']; ?>">Detail</a> |
                  <a class="btn btn-primary" href="notacetak.php?nota_no=<?php echo $data['nota_no']; ?>">Cetak</a>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
  <script src="../js/sidebar.js"></script>
  <script>
    $(document).ready(function() {
      $('#example').DataTable();
    });
  </script>
</body>

</html>