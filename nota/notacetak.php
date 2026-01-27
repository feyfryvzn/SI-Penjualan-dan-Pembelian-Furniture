<!DOCTYPE html>
<style>
    h1, h2 {
        text-align: center;
    }
    .transaction-details {
        margin-bottom: 20px;
    }
    .medicine-list table {
        width: 100%;
        border-collapse: collapse;
    }
    .medicine-list th, .medicine-list td {
        padding: 8px;
        border: 1px solid #ccc;
        text-align: center;
    }
    .total-amount {
        text-align: right;
        margin-top: 20px;
    }
    .ttd1 {
        display: flex;
        align-items: center;
    }
    p {
        margin: 0;
    }
    strong {
        font-weight: bold;
    }
    .kanan {
        margin-left: auto;
    }
    .kanann {
        margin-left: 150px;
    }
    .kanan2 {
        margin-left: 80px;
    }
</style>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AUTO SERVICE</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="font-family: Arial, sans-serif; background-color: #f1f1f1;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #fff; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <?php
        include '../koneksi.php';
        $query = mysqli_query($conn, "SELECT * from nota n ,pelanggan p where n.nopol=p.nopol AND nota_no = '$_GET[nota_no]'");
        $data = mysqli_fetch_array($query);
        // Mengubah format tanggal ke dd/mm/yyyy
        $tanggal = date('d/m/Y', strtotime($data['tanggal']));
        ?>
        <div style=" display: flex; align-items: center;">
            <div>
                <p style="text-align: center; font-size: 0.7rem; width: 310px;">
                    <img src="../images/kop.png" alt="" style="width: 300px; height: auto;"><br>
                    <strong>COMPUTER ANALIZER SYSTEM, TUNEUP, GANTI OLI <br>
                        REPARASI SERVICE AC MOBIL, DLL <br>
                        JL. KEDOYA RAYA NO.11A JAKARTA-BARAT <br>
                        HP. 08118503792
                    </strong>
                </p>
                <div style="text-align:start;">
                    <img src="../images/anantaa.png" alt="" style="width: 120px; height: auto;"> <br>
                    <strong style="font-size:large;">
                        BON/NOTA No. <?php echo $data['nota_no']; ?>
                    </strong>
                </div>
            </div>
            <div style="margin-left:auto; text-align: center; font-weight:bold; font-size:medium;">
                <pre>
Jakarta,    <?php echo $tanggal; ?>

Kepada Yth,
<?php echo $data['nama']; ?>

Tipe: <?php echo $data['tipe']; ?>

KM : <?php echo $data['km_mobil']; ?>

NOPOL : <?php echo $data['nopol']; ?>
<hr style="height:1px;background-color: #000;">
                    </pre>
            </div>
        </div>

        <div class="medicine-list">
            <table>
                <thead>
                    <tr>
                        <th>Banyaknya</th>
                        <th>Nama Barang</th>
                        <th>Harga Satuan</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include '../koneksi.php';
                    $index = 1;
                    $nota_no = $_GET['nota_no'];
                    $query = mysqli_query($conn, "SELECT B.nama_barang, B.harga_satuan, DB.banyaknya, DB.jumlah, N.nota_no
                    FROM nota N
                    JOIN detailbarang DB ON N.nota_no = DB.nota_no
                    JOIN barang B ON DB.no_barang = B.no_barang
                    WHERE N.nota_no = '$nota_no'");
                    $jumlah_rp = 0; // Inisialisasi grand total
                    $rowCount = 0; // Counter untuk baris

                    while ($data = mysqli_fetch_array($query)) {
                        $jumlah = $data['harga_satuan'] * $data['banyaknya'];
                        $jumlah_rp += $jumlah;
                        $rowCount++; // Increment counter
                    ?>
                        <tr>
                            <td><?php echo $data['banyaknya']; ?></td>
                            <td style="text-align: start;"><?php echo $data['nama_barang']; ?></td>
                            <td><?php echo number_format($data['harga_satuan'], 0, ',', '.'); ?></td>
                            <td><?php echo number_format($data['jumlah'], 0, ',', '.'); ?></td>
                        </tr>
                    <?php }

                    // Menambahkan baris kosong jika kurang dari 15 baris
                    for ($i = $rowCount; $i < 11; $i++) {
                        echo "<tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Jumlah Rp.</strong></td>
                        <td><?php echo number_format($jumlah_rp, 0, ',', '.'); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div style="display: flex; justify-content: flex-end;">
            <div style="position: relative; display: inline-block; text-align: center;">
                <pre style="margin: 0;">
            
<strong>Hormat Kami,</strong>
<img src="../images/ttds.png" alt="" style="width: 90px; height: auto;">
<strong>Satya Putra</strong>
                </pre>
                <div style="position: absolute; top: 50px; left: 50%; transform: translate(-50%, -50%) rotate(-15deg); opacity: 0.4;">
                    <img src="../images/stempel.png" alt="" style="width: 90px; height: auto;">
                </div>
            </div>
        </div>
    </div>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/sidebar.js"></script>
</body>

</html>
