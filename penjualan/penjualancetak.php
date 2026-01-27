<?php
include '../koneksi.php';
$no_nota = $_GET['no_nota'];

$stmt = $conn->prepare("SELECT p.no_nota, p.tanggal, p.DP, c.nama_customer, pg.nama_pegawai 
                        FROM penjualan p 
                        JOIN customer c ON p.id_customer = c.id_customer 
                        JOIN pegawai pg ON p.id_pegawai = pg.id_pegawai 
                        WHERE p.no_nota = ?");
$stmt->bind_param("s", $no_nota);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

$tanggal = date('d/m/Y', strtotime($data['tanggal']));

// Hitung jumlah total dari detail_penjualan
$stmt = $conn->prepare("SELECT IFNULL(SUM(jumlah), 0) AS jumlah_Rp 
                        FROM detail_penjualan 
                        WHERE no_nota = ?");
$stmt->bind_param("s", $no_nota);
$stmt->execute();
$totalData = $stmt->get_result()->fetch_assoc();
$stmt->close();
$data['jumlah_Rp'] = $totalData['jumlah_Rp'];
$data['sisa'] = $data['jumlah_Rp'] - $data['DP'];

// Ambil detail barang
$stmt = $conn->prepare("SELECT b.nama_barang, b.harga_satuan, dp.banyaknya, dp.jumlah 
                        FROM detail_penjualan dp 
                        JOIN barang b ON dp.id_barang = b.id_barang 
                        WHERE dp.no_nota = ?");
$stmt->bind_param("s", $no_nota);
$stmt->execute();
$queryDetail = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Nota Penjualan</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: A4;
                margin: 15mm;
            }
            .no-print, .container::after {
                display: none;
            }
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 900px;
            width: 100%;
            padding: 50px;
            background: #ffffff;
            border: 3px solid #1e3a8a;
            border-radius: 25px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .container::after {
            content: '';
            position: absolute;
            top: -30%;
            left: -30%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(212, 160, 23, 0.1) 0%, transparent 70%);
            z-index: -1;
            animation: rotate 15s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 20px;
            border-bottom: 2px solid #d4a017;
        }

        .header .logo {
            flex: 0 0 180px;
        }

        .header .logo img {
            width: 100%;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .header .logo img:hover {
            transform: scale(1.05);
        }

        .header .title {
            text-align: right;
            flex: 1;
        }

        .header h2 {
            color: #1e3a8a;
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin: 10px 0;
        }

        .header h3 {
            color: #4b5e97;
            font-size: 22px;
            font-weight: 500;
            margin: 5px 0;
        }

        .company-info {
            text-align: center;
            color: #333;
            font-size: 15px;
            line-height: 1.7;
            padding: 20px 0;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px dashed #1e3a8a;
            border-bottom: 1px dashed #1e3a8a;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-bottom: 30px;
            padding: 25px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
            backdrop-filter: blur(5px);
            border-left: 5px solid #d4a017;
        }

        .info p {
            margin: 10px 0;
            color: #4b5e97;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .info p:hover {
            color: #1e3a8a;
        }

        .info p::before {
            content: '★';
            color: #d4a017;
            margin-right: 10px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse; /* Menggunakan collapse untuk garis yang menyatu */
            background: #ffffff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }

        th, td {
            border: 1px solid #e5e7eb; /* Garis pada semua sel tabel */
            padding: 15px;
            text-align: center;
        }

        th {
            background: linear-gradient(90deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 3px solid #d4a017; /* Garis bawah tebal untuk header */
        }

        td:nth-child(2) {
            text-align: left;
        }

        tr:hover td {
            background: #f9fafb;
            transform: translateY(-2px);
        }

        tfoot td {
            font-weight: 600;
            background: #ffffff;
            border-top: 3px solid #1e3a8a; /* Garis atas tebal untuk footer */
            font-size: 18px;
            color: #1e3a8a;
            border-left: 1px solid #e5e7eb;
            border-right: 1px solid #e5e7eb;
        }

        .footer {
            margin-top: 50px;
            text-align: right;
            color: #4b5e97;
            font-size: 16px;
            position: relative;
            padding-right: 20px;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: -20px;
            right: 0;
            width: 100px;
            height: 2px;
            background: #d4a017;
        }

        .footer img {
            width: 140px;
            margin: 20px 0;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            transform: rotate(-5deg);
            transition: transform 0.3s ease;
        }

        .footer img:hover {
            transform: rotate(-5deg) scale(1.05);
        }

        .footer p {
            margin: 10px 0;
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 18px;
        }

        .print-btn {
            position: fixed;
            bottom: 20px;
            right: 20px;
            padding: 15px 30px;
            background: linear-gradient(90deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
            font-family: 'Poppins', sans-serif;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: linear-gradient(90deg, #3b82f6, #1e3a8a);
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="../images/kop.jpg" alt="Logo">
            </div>
            <div class="title">
                <h2>Nota Penjualan</h2>
                <h3>No: <?= htmlspecialchars($data['no_nota']) ?></h3>
            </div>
        </div>

        <div class="company-info">
            <strong>KURNIA JATI FURNITURE<br>
                Kami Menjual Barang Berkualitas<br>
                JL. BELIMBING NO.6 CIKARANG<br>
                HP. 08118503792</strong>
        </div>

        <div class="info">
            <p><strong>Tanggal:</strong> <?= htmlspecialchars($tanggal) ?></p>
            <p><strong>Customer:</strong> <?= htmlspecialchars($data['nama_customer']) ?></p>
            <p><strong>Pegawai:</strong> <?= htmlspecialchars($data['nama_pegawai']) ?></p>
            <p><strong>DP:</strong> Rp <?= number_format($data['DP'], 0, ',', '.') ?> </p>
        </div>

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
                <?php while ($row = $queryDetail->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['banyaknya']) ?></td>
                        <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                        <td><?= number_format($row['harga_satuan'], 0, ',', '.') ?> Rp</td>
                        <td><?= number_format($row['jumlah'], 0, ',', '.') ?> Rp</td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total Rp</td>
                    <td><?= number_format($data['jumlah_Rp'], 0, ',', '.') ?> Rp</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">DP</td>
                    <td><?= number_format($data['DP'], 0, ',', '.') ?> Rp</td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: right;">Sisa</td>
                    <td><?= number_format($data['sisa'], 0, ',', '.') ?> Rp</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Hormat Kami,</p>
            <img src="../images/ttds.jpg" alt="Tanda Tangan">
            <p><strong><?= htmlspecialchars($data['nama_pegawai']) ?></strong></p>
        </div>
    </div>

    <button class="print-btn no-print" onclick="window.print()">Cetak Nota</button>
</body>
</html>