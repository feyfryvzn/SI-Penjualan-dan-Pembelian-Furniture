<?php
include '../koneksi.php';

// Proses form sebelum ada output HTML
if (isset($_POST['proses'])) {
    $nota_no = $_POST['nota_no'];
    $no_barang = $_POST['no_barang'];
    $banyaknya = $_POST['banyaknya'];
    $jumlah = $_POST['jumlah'];

    $query_total = "SELECT jumlah_rp FROM nota WHERE nota_no = '$nota_no'";
    $result_total = mysqli_query($conn, $query_total);
    $row_total = mysqli_fetch_assoc($result_total);
    $total_sebelumnya = $row_total['jumlah_rp'];

    $query_insert = "INSERT INTO detailbarang VALUES('$nota_no','$no_barang','$banyaknya','$jumlah')";
    $result_insert = mysqli_query($conn, $query_insert);

    if ($result_insert) {
        // Mengupdate nilai total
        $total = $total_sebelumnya + $jumlah;
        $query_update_total = "UPDATE nota SET jumlah_rp='$total' WHERE nota_no = '$nota_no'";
        $result_update_total = mysqli_query($conn, $query_update_total);
        
        // Redirect ke halaman lain setelah sukses
        header("Location: notadetail-lihat.php?nota_no=$nota_no");
        exit;
    }
}

// Ambil data untuk tampilan form
if (isset($_GET['nota_no'])) {
    $nota_no = $_GET['nota_no'];
    $query = mysqli_query($conn, "SELECT * FROM nota WHERE nota_no = '$nota_no'");
    $data = mysqli_fetch_array($query);
} else {
    die("Nota nomor tidak disediakan.");
}
?>

<!doctype html>
<html lang="en">
<head>
    <title>Sidebar 01</title>
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
                            <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
                            <li class="nav-item"><a class="nav-link" href="#pelanggan">Pelanggan</a></li>
                            <li class="nav-item"><a class="nav-link" href="../barang/barang-lihat.php">Barang</a></li>
                            <li class="nav-item active"><a class="nav-link" href="#">Nota</a></li>
                            
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="form">
                <label for="tambahNota" class="form-label" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">FORM DETAIL NOTA : <?php echo htmlspecialchars($data['nota_no']);?></label>
                <hr>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">NO NOTA</label>
                    <input name="nota_no" class="form-control" value="<?php echo htmlspecialchars($data['nota_no']);?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <div class="form-element">
                    <label class="form-label"style="display: inline-block; width: 100px;">TANGGAL</label>
                    <input type="date" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($data['tanggal']);?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>

                <div class="form-element">
                    <label class="form-label"style="display: inline-block; width: 100px;">KM MOBIL</label>
                    <input type="number" name="km_mobil" class="form-control" value="<?php echo htmlspecialchars($data['km_mobil']);?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <div class="form-element">
                    <label class="form-label"style="display: inline-block; width: 100px;">NOPOL</label>
                    <input type="text" name="nopol" class="form-control" value="<?php echo htmlspecialchars($data['nopol']);?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <div class="form-element">
                    <label class="form-label"style="display: inline-block; width: 100px;">KASIR</label>
                    <input type="text" name="kasir" class="form-control" value="<?php echo htmlspecialchars($data['kasir']);?>" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <label for="tambahNota" class="form-label mt-4" style="display: flex; flex-direction: column; align-items: center; text-align: center; font-size: large;">TAMBAH DETAIL NOTA</label>
                <hr>
                <div class="form-element">
                    <label for="exampleDataList" class="form-label"style="display: inline-block; width: 100px;">BARANG</label>
                    <select class="form-control" name="no_barang" aria-label="Default select example" style="display: inline-block; width: calc(100% - 110px);">
                        <option selected disabled>---Pilih----</option>
                        <?php
                        $query = mysqli_query($conn, "SELECT * FROM barang");
                        while ($data_barang = mysqli_fetch_array($query)) {
                            echo "<option value='".htmlspecialchars($data_barang['no_barang'])."' data-harga='".htmlspecialchars($data_barang['harga_satuan'])."'>".htmlspecialchars($data_barang['no_barang'])." - ".htmlspecialchars($data_barang['nama_barang'])." - ".htmlspecialchars($data_barang['harga_satuan'])."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-element">
                    <label class="form-label" style="display: inline-block; width: 100px;">BANYAKNYA</label>
                    <input type="number" name="banyaknya" class="form-control" placeholder="Banyaknya" style="display: inline-block; width: calc(100% - 110px);">
                </div>
                <div class="form-element">
                    <label class="form-label"style="display: inline-block; width: 100px;">JUMLAH</label>
                    <input type="number" name="jumlah" class="form-control" style="display: inline-block; width: calc(100% - 110px);" readonly>
                </div>
                <br>
                <div class="tombol" style="text-align: right;">
                    <button type="submit" name="proses" class="btn btn-success">Simpan Detail</button>
                    <a href="notadetail-lihat.php?nota_no=<?php echo htmlspecialchars($data['nota_no']); ?>" class="btn btn-danger">Kembali</a>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/sidebar.js"></script>
</form>

<script>
    // Ambil elemen-elemen yang diperlukan
    var selectBarang = document.querySelector("select[name='no_barang']");
    var inputBanyaknya = document.querySelector("input[name='banyaknya']");
    var inputTotal = document.querySelector("input[name='jumlah']");

    // Fungsi untuk menghitung total
    function hitungTotal() {
        var hargaSatuan = selectBarang.options[selectBarang.selectedIndex].getAttribute("data-harga");
        var banyaknya = inputBanyaknya.value;
        var total = hargaSatuan * banyaknya;
        inputTotal.value = total;
    }
    // Panggil fungsi hitungTotal saat nilai input berubah
    selectBarang.addEventListener("change", hitungTotal);
    inputBanyaknya.addEventListener("input", hitungTotal);
</script>
</html>