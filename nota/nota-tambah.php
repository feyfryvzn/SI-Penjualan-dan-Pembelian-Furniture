<?php
if (isset($_POST['proses'])) {
  include '../koneksi.php';

  $nota_no = $_POST['nota_no'];
  $tanggal = $_POST['tanggal'];
  $km_mobil = $_POST['km_mobil'];
  $nopol = $_POST['nopol'];
  $kasir = $_POST['kasir'];

  // Memasukkan data ke dalam tabel nota
  mysqli_query($conn, "INSERT INTO nota VALUES ('$nota_no', '$tanggal', '$km_mobil', '$nopol', '$kasir',NULL)");
  //header("location:nota-lihat.php");
  // Gunakan nilai $kodenota untuk keperluan selanjutnya
  echo "<script>window.location.href = 'notadetail-lihat.php?nota_no=" . $nota_no . "';</script>";
}
?>
<!doctype html>
<html lang="en">

<head>
  <title>nota-tambah</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="../css/sidebar.css">
</head>
<form action="" method="post">

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

      <div class="form">
        <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH NOTA</label>
        <hr>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">NO NOTA</label>
          <input type="text" name="nota_no" class="form-control" placeholder="NO Nota" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label for="tanggal" class="form-label" style="display: inline-block; width: 100px;">TANGGAL</label>
          <input type="date" name="tanggal" class="form-control" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label class="form-label" style="display: inline-block; width: 100px;">KM MOBIL</label>
          <input type="number" name="km_mobil" class="form-control" placeholder="km Mobil" style="display: inline-block; width: calc(100% - 110px);">
        </div>

        <div class="form-element">
          <label for="exampleDataList" class="form-label" style="display: inline-block; width: 100px;">NOPOL</label>
          <select class="form-control" name="nopol" aria-label="Default select example" style="display: inline-block; width: calc(100% - 110px);">
            <option selected disabled>---Pilih----</option>
            <?php
            include '../koneksi.php';
            $query = mysqli_query($conn, "SELECT * FROM pelanggan");
            while ($data = mysqli_fetch_array($query)) {
            ?>
              <option value="<?php echo $data['nopol']; ?>">
                <?php echo $data['nopol']; ?></option>
            <?php
            }
            ?>
          </select>
        </div>

        <div class="form-element">
          <label for="exampleDataList" class="form-label" style="display: inline-block; width: 100px;">KASIR</label>
          <select class="form-control" name="kasir" aria-label="Default select example" style="display: inline-block; width: calc(100% - 110px);">
            <option selected disabled>---Pilih----</option>
            <option value="Ahmad">Ahmad</option>
            <option value="Budi">Budi</option>
            <option value="Cintia">Cintia</option>
            <option value="Deni">Deni</option>
            <option value="Elbert">Elbert</option>

          </select>
        </div>
        <br>
        <div class="tombol" style="text-align: right;">
          <button type="submit" name="proses" class="btn btn-success">Tambah</button>
          <a href="nota-lihat.php" class="btn btn-danger">Batal</a>

        </div>

      </div>

    </div>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/popper.js"></script>
  <script src="../js/bootstrap.min.js"></script>
  <script src="../js/sidebar.js"></script>
</form>

</html>