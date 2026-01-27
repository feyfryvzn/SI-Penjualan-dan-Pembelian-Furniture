<?php
include '../koneksi.php';
$no_dkb = $_GET['no_dkb'];

$stmt = $conn->prepare("
    SELECT d.no_dkb, d.tanggal_pembuatan, d.tempat_muat, d.no_skkk, d.jumlah_batang, d.volume_total,
           p.nama_pemilik, p.alamat_pemilik,
           pr.nama_pemeriksa, pr.no_registrasi, pr.instansi,
           kl.nama_kelurahan, kc.nama_kecamatan, kt.nama_kota, pv.nama_provinsi
    FROM dokumenpkb d
    JOIN pemilik p ON d.id_pemilik = p.id_pemilik
    JOIN pemeriksa pr ON d.id_pemeriksa = pr.id_pemeriksa
    JOIN kelurahan kl ON d.id_kelurahan = kl.id_kelurahan
    JOIN kecamatan kc ON kl.id_kecamatan = kc.id_kecamatan
    JOIN kota kt ON kc.id_kota = kt.id_kota
    JOIN provinsi pv ON kt.id_provinsi = pv.id_provinsi
    WHERE d.no_dkb = ?");
$stmt->bind_param("s", $no_dkb);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();
$stmt->close();

if (!$data) {
    die("Data dokumen PKB tidak ditemukan untuk no_dkb: " . htmlspecialchars($no_dkb));
}

$tanggal = date('d/m/Y', strtotime($data['tanggal_pembuatan']));

// Ambil detail hasil hutan
$stmt = $conn->prepare("
    SELECT dh.no_urut, dh.id_kayu, dh.tanggal, dh.volume, dh.panjang, dh.diameter, dh.keterangan, jh.jenis_hasil_hutan
    FROM detail_hasil_hutan dh
    JOIN jenis_hasil_hutan jh ON dh.id_kayu = jh.id_kayu
    WHERE dh.no_dkb = ?");
$stmt->bind_param("s", $no_dkb);
$stmt->execute();
$queryDetail = $stmt->get_result();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Dokumen PKB</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        @media print {
            @page {
                size: A4;
                margin: 10mm;
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
            align-items: flex-start;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            width: 100%;
            padding: 30px;
            background: #ffffff;
            border: 2px solid #1e3a8a;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            margin: 20px;
        }

        .container::after {
            content: '';
            position: absolute;
            top: -20%;
            left: -20%;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(212, 160, 23, 0.1) 0%, transparent 70%);
            z-index: -1;
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #d4a017;
        }

        .header .logo {
            flex: 0 0 150px;
        }

        .header .logo img {
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .header .logo img:hover {
            transform: scale(1.03);
        }

        .header .title {
            text-align: right;
            flex: 1;
        }

        .header h2 {
            color: #1e3a8a;
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin: 5px 0;
        }

        .header h3 {
            color: #4b5e97;
            font-size: 18px;
            font-weight: 500;
            margin: 5px 0;
        }

        .company-info {
            text-align: center;
            color: #333;
            font-size: 14px;
            line-height: 1.6;
            padding: 15px 0;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.95);
            border-top: 1px dashed #1e3a8a;
            border-bottom: 1px dashed #1e3a8a;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px; /* Mengurangi gap dari 15px ke 8px */
            margin-bottom: 15px; /* Mengurangi margin bawah dari 25px ke 15px */
            padding: 15px; /* Mengurangi padding dari 20px ke 15px */
            background: rgba(255, 255, 255, 0.95);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            border-left: 4px solid #d4a017;
        }

        .info p {
            margin: 5px 0; /* Mengurangi margin vertikal dari 8px ke 5px */
            color: #4b5e97;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: flex-start;
        }

        .info p:hover {
            color: #1e3a8a;
        }

        .info p::before {
            content: '★';
            color: #d4a017;
            margin-right: 6px; /* Mengurangi margin kanan dari 8px ke 6px */
            font-size: 10px;
            margin-top: 2px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        th, td {
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: center;
            font-size: 13px;
        }

        th {
            background: linear-gradient(90deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            font-weight: 600;
            text-transform: uppercase;
            border-bottom: 2px solid #d4a017;
        }

        td:nth-child(2) {
            text-align: left;
        }

        th:nth-child(1), td:nth-child(1) { width: 10%; }
        th:nth-child(2), td:nth-child(2) { width: 20%; }
        th:nth-child(3), td:nth-child(3) { width: 15%; }
        th:nth-child(4), td:nth-child(4) { width: 15%; }
        th:nth-child(5), td:nth-child(5) { width: 15%; }
        th:nth-child(6), td:nth-child(6) { width: 15%; }
        th:nth-child(7), td:nth-child(7) { width: 25%; }

        tr:hover td {
            background: #f9fafb;
        }

        tfoot td {
            font-weight: 600;
            background: #ffffff;
            border-top: 2px solid #1e3a8a;
            font-size: 14px;
            color: #1e3a8a;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            color: #4b5e97;
            font-size: 14px;
            position: relative;
            padding-right: 15px;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: -15px;
            right: 0;
            width: 80px;
            height: 2px;
            background: #d4a017;
        }

        .footer img {
            width: 120px;
            margin: 15px 0;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: rotate(-3deg);
            transition: transform 0.3s ease;
        }

        .footer img:hover {
            transform: rotate(-3deg) scale(1.03);
        }

        .footer p {
            margin: 8px 0;
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-size: 16px;
        }

        .print-btn {
            position: fixed;
            bottom: 15px;
            right: 15px;
            padding: 12px 25px;
            background: linear-gradient(90deg, #1e3a8a, #3b82f6);
            color: #ffffff;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            font-family: 'Poppins', sans-serif;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .print-btn:hover {
            background: linear-gradient(90deg, #3b82f6, #1e3a8a);
            transform: translateY(-2px) scale(1.03);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
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
                <h2>Dokumen PKB</h2>
                <h3>No: <?= htmlspecialchars($data['no_dkb']) ?></h3>
            </div>
        </div>

        <div class="company-info">
            <strong>KURNIA JATI FURNITURE<br>
                Kami Menjual Barang Berkualitas<br>
                JL. BELIMBING NO.6 CIKARANG<br>
                HP. 08118503792</strong>
        </div>

        <div class="info">
            <p><strong>Tanggal Pembuatan:</strong> <?= htmlspecialchars($tanggal) ?></p>
            <p><strong>Pemilik:</strong> <?= htmlspecialchars($data['nama_pemilik']) ?></p>
            <p><strong>Alamat Pemilik:</strong> <?= htmlspecialchars($data['alamat_pemilik']) ?></p>
            <p><strong>Lokasi:</strong> <?= htmlspecialchars($data['nama_kelurahan'] . ', ' . $data['nama_kecamatan'] . ', ' . $data['nama_kota'] . ', ' . $data['nama_provinsi']) ?></p>
            <p><strong>Tempat Muat:</strong> <?= htmlspecialchars($data['tempat_muat']) ?></p>
            <p><strong>No SKKK:</strong> <?= htmlspecialchars($data['no_skkk']) ?></p>
            <p><strong>Pemeriksa:</strong> <?= htmlspecialchars($data['nama_pemeriksa']) ?></p>
            <p><strong>No Registrasi:</strong> <?= htmlspecialchars($data['no_registrasi']) ?></p>
            <p><strong>Instansi:</strong> <?= htmlspecialchars($data['instansi']) ?></p>
            <p><strong>Jumlah Batang:</strong> <?= htmlspecialchars($data['jumlah_batang']) ?></p>
            <p><strong>Volume Total:</strong> <?= htmlspecialchars($data['volume_total']) ?> m³</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No Urut</th>
                    <th>Jenis Kayu</th>
                    <th>Tanggal</th>
                    <th>Volume (m³)</th>
                    <th>Panjang (cm)</th>
                    <th>Diameter (cm)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $queryDetail->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['no_urut']) ?></td>
                        <td><?= htmlspecialchars($row['jenis_hasil_hutan']) ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal'])) ?></td>
                        <td><?= number_format($row['volume'], 2, ',', '.') ?></td>
                        <td><?= number_format($row['panjang'], 2, ',', '.') ?></td>
                        <td><?= number_format($row['diameter'], 2, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;">Total Volume</td>
                    <td colspan="4"><?= htmlspecialchars($data['volume_total']) ?> m³</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer">
            <p>Hormat Kami,</p>
            <img src="../images/ttds.jpg" alt="Tanda Tangan">
            <p><strong><?= htmlspecialchars($data['nama_pemeriksa']) ?></strong></p>
        </div>
    </div>

    <button class="print-btn no-print" onclick="window.print()">Cetak Dokumen</button>
</body>
</html>