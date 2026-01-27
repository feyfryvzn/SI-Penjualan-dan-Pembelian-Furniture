-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 02:01 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mbd`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(20) NOT NULL,
  `nama_barang` varchar(100) DEFAULT NULL,
  `harga_satuan` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga_satuan`) VALUES
('11111', 'KAYU TREMBESI', '100000000'),
('123123', 'KAYU JATI', '1000000'),
('12312312', 'KAYO MAHONI', '1000000');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` varchar(20) NOT NULL,
  `nama_customer` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `no_hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `nama_customer`, `alamat`, `no_hp`) VALUES
('P002', 'feyza', 'ponol raya', '098765432123'),
('P003', 'Nandra Ayu ', 'Kaliabang, pondok ungu permai', '081386928225');

-- --------------------------------------------------------

--
-- Table structure for table `detail_bahanbaku`
--

CREATE TABLE `detail_bahanbaku` (
  `id_kayu` varchar(20) DEFAULT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `takaran` varchar(65) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_hasil_hutan`
--

CREATE TABLE `detail_hasil_hutan` (
  `no_dkb` varchar(20) DEFAULT NULL,
  `no_urut` int(11) DEFAULT NULL,
  `id_kayu` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `volume` varchar(30) DEFAULT NULL,
  `panjang` varchar(30) DEFAULT NULL,
  `diameter` varchar(30) DEFAULT NULL,
  `keterangan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `detail_penjualan`
--

CREATE TABLE `detail_penjualan` (
  `no_nota` varchar(20) DEFAULT NULL,
  `id_barang` varchar(20) DEFAULT NULL,
  `banyaknya` int(11) DEFAULT NULL,
  `jumlah` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dokumenpkb`
--

CREATE TABLE `dokumenpkb` (
  `no_dkb` varchar(20) NOT NULL,
  `id_pemilik` varchar(20) DEFAULT NULL,
  `id_pemeriksa` varchar(20) DEFAULT NULL,
  `tanggal_pembuatan` date DEFAULT NULL,
  `tempat_muat` varchar(100) DEFAULT NULL,
  `no_skkk` varchar(50) DEFAULT NULL,
  `jumlah_batang` int(11) DEFAULT NULL,
  `volume_total` varchar(10) DEFAULT NULL,
  `id_kelurahan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jenis_hasil_hutan`
--

CREATE TABLE `jenis_hasil_hutan` (
  `id_kayu` varchar(20) NOT NULL,
  `jenis_hasil_hutan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kecamatan`
--

CREATE TABLE `kecamatan` (
  `id_kecamatan` int(11) NOT NULL,
  `nama_kecamatan` varchar(100) DEFAULT NULL,
  `id_kota` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kecamatan`
--

INSERT INTO `kecamatan` (`id_kecamatan`, `nama_kecamatan`, `id_kota`) VALUES
(317107, 'Tanah Abang', 3171),
(317108, 'Johar Baru', 3171),
(317201, 'Penjaringan', 3172),
(317202, 'Tanjung Priok', 3172),
(317302, 'Grogol Petamburan', 3173),
(317303, 'Taman Sari', 3173),
(317401, 'Tebet', 3174),
(317402, 'Setiabudi', 3174),
(317502, 'Pulogadung', 3175),
(317503, 'Jatinegara', 3175),
(320201, 'Palabuhanratu', 3202),
(320202, 'Simpenan', 3202),
(320407, 'Cilengkrang', 3204),
(320408, 'Bojongsoang', 3204),
(327503, 'Bekasi Utara', 3275),
(327506, 'Medansatria', 3275),
(330101, 'Kedungreja', 3301),
(330102, 'Kesugihan', 3301),
(330201, 'Lumbir', 3302),
(330202, 'Wangon', 3302),
(352901, 'Kota Sumenep', 3529),
(352902, 'Kalianget', 3529),
(357102, 'Kota', 3571),
(357103, 'Pesantren', 3571),
(360225, 'Lebakgedong', 3602),
(360226, 'Cihara', 3602),
(367404, 'Ciputat', 3674),
(367406, 'Pamulang', 3674);

-- --------------------------------------------------------

--
-- Table structure for table `kelurahan`
--

CREATE TABLE `kelurahan` (
  `id_kelurahan` int(11) NOT NULL,
  `nama_kelurahan` varchar(100) DEFAULT NULL,
  `id_kecamatan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kelurahan`
--

INSERT INTO `kelurahan` (`id_kelurahan`, `nama_kelurahan`, `id_kecamatan`) VALUES
(317107106, 'Kampung Bali', 317107),
(317107107, 'Kebon Kacang', 317107),
(317108101, 'Johar Baru', 317108),
(317108102, 'Kampung Rawa', 317108),
(317201101, 'Penjaringan', 317201),
(317201102, 'Kamal Muara', 317201),
(317202101, 'Tanjung Priok', 317202),
(317202102, 'Sunter Jaya', 317202),
(317302103, 'Tomang', 317302),
(317302104, 'Jelambar', 317302),
(317303103, 'Maphar', 317303),
(317303104, 'Tangki', 317303),
(317401106, 'Manggarai Selatan', 317401),
(317401107, 'Manggarai', 317401),
(317402104, 'Karet', 317402),
(317402105, 'Menteng Atas', 317402),
(317502105, 'Rawamangun', 317502),
(317502106, 'Kayu Putih', 317502),
(317503103, 'Bali Mester', 317503),
(317503104, 'Rawa Bunga', 317503),
(320201209, 'Cimanggu', 320201),
(320201210, 'Jayanti', 320201),
(320202204, 'Cihaur', 320202),
(320202205, 'Cibuntu', 320202),
(320407201, 'Jatiendah', 320407),
(320407202, 'Cilengkrang', 320407),
(320408201, 'Lengkong', 320408),
(320408202, 'Bojongsoang', 320408),
(327503101, 'Kaliabang Tengah', 327503),
(327503102, 'Perwira', 327503),
(327506101, 'Medansatria', 327506),
(327506102, 'Harapanmulya', 327506),
(330101201, 'Tambakreja', 330101),
(330101202, 'Bumireja', 330101),
(330102201, 'Menganti', 330102),
(330102202, 'Slarang', 330102),
(330201201, 'Cirahab', 330201),
(330201202, 'Canduk', 330201),
(330202201, 'Randegan', 330202),
(330202202, 'Rawaheng', 330202),
(352901115, 'Kepanjin', 352901),
(352901116, 'Pajagalan', 352901),
(352902201, 'Pinggirpapas', 352902),
(352902202, 'Karanganyar', 352902),
(357102101, 'Semampir', 357102),
(357102102, 'Balowerti', 357102),
(357103101, 'Bangsal', 357103),
(357103102, 'Pakunden', 357103),
(360225205, 'Lebaksitu', 360225),
(360225206, 'Lebaksangka', 360225),
(360226201, 'Panyaungan', 360226),
(360226202, 'Cihara', 360226),
(367404105, 'Serua Indah', 367404),
(367404106, 'Jombang', 367404),
(367406101, 'Pamulang Barat', 367406),
(367406102, 'Benda Baru', 367406);

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` int(11) NOT NULL,
  `nama_kota` varchar(100) DEFAULT NULL,
  `id_provinsi` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`, `id_provinsi`) VALUES
(3171, 'KOTA ADM. JAKARTA PUSAT', 31),
(3172, 'KOTA ADM. JAKARTA UTARA', 31),
(3173, 'KOTA ADM. JAKARTA BARAT', 31),
(3174, 'KOTA ADM. JAKARTA SELATAN', 31),
(3175, 'KOTA ADM. JAKARTA TIMUR', 31),
(3202, 'KAB. SUKABUMI', 32),
(3204, 'KAB. BANDUNG', 32),
(3275, 'KOTA BEKASI', 32),
(3301, 'KAB. CILACAP', 33),
(3302, 'KAB. BANYUMAS', 33),
(3529, 'KAB. SUMENEP', 35),
(3571, 'KOTA KEDIRI', 35),
(3602, 'KAB. LEBAK', 36),
(3674, 'KOTA TANGERANG SELATAN', 36);

-- --------------------------------------------------------

--
-- Table structure for table `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` varchar(20) NOT NULL,
  `nama_pegawai` varchar(100) DEFAULT NULL,
  `jabatan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama_pegawai`, `jabatan`) VALUES
('PE001', 'SUGAID', 'Pegawai'),
('PEM001', 'DYLA', 'Pemilik');

-- --------------------------------------------------------

--
-- Table structure for table `pemeriksa`
--

CREATE TABLE `pemeriksa` (
  `id_pemeriksa` varchar(20) NOT NULL,
  `nama_pemeriksa` varchar(100) DEFAULT NULL,
  `no_registrasi` varchar(50) DEFAULT NULL,
  `instansi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemeriksa`
--

INSERT INTO `pemeriksa` (`id_pemeriksa`, `nama_pemeriksa`, `no_registrasi`, `instansi`) VALUES
('SA01', 'PURWADI', '09/12/12.03/P2SKSKB/Pur/KB', 'P25K5KB');

-- --------------------------------------------------------

--
-- Table structure for table `pemilik`
--

CREATE TABLE `pemilik` (
  `id_pemilik` varchar(20) NOT NULL,
  `nama_pemilik` varchar(100) DEFAULT NULL,
  `alamat_pemilik` text DEFAULT NULL,
  `id_kelurahan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pemilik`
--

INSERT INTO `pemilik` (`id_pemilik`, `nama_pemilik`, `alamat_pemilik`, `id_kelurahan`) VALUES
('LI001', 'PIPIN', 'LEBAK', 317107107),
('LI002', 'Feyza oke', 'poncol raya', 317201101);

-- --------------------------------------------------------

--
-- Table structure for table `penjualan`
--

CREATE TABLE `penjualan` (
  `no_nota` varchar(20) NOT NULL,
  `id_customer` varchar(20) DEFAULT NULL,
  `id_pegawai` varchar(20) DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `jumlah_Rp` varchar(30) DEFAULT NULL,
  `DP` varchar(30) DEFAULT NULL,
  `sisa` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` int(11) NOT NULL,
  `nama_provinsi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `nama_provinsi`) VALUES
(31, 'DKI JAKARTA'),
(32, 'JAWA BARAT'),
(33, 'JAWA TENGAH'),
(35, 'JAWA TIMUR'),
(36, 'BANTEN');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`);

--
-- Indexes for table `detail_bahanbaku`
--
ALTER TABLE `detail_bahanbaku`
  ADD KEY `id_kayu` (`id_kayu`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `detail_hasil_hutan`
--
ALTER TABLE `detail_hasil_hutan`
  ADD KEY `no_dkb` (`no_dkb`),
  ADD KEY `id_kayu` (`id_kayu`);

--
-- Indexes for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD KEY `no_nota` (`no_nota`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `dokumenpkb`
--
ALTER TABLE `dokumenpkb`
  ADD PRIMARY KEY (`no_dkb`),
  ADD KEY `id_pemilik` (`id_pemilik`),
  ADD KEY `id_pemeriksa` (`id_pemeriksa`),
  ADD KEY `id_kelurahan` (`id_kelurahan`);

--
-- Indexes for table `jenis_hasil_hutan`
--
ALTER TABLE `jenis_hasil_hutan`
  ADD PRIMARY KEY (`id_kayu`);

--
-- Indexes for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD PRIMARY KEY (`id_kecamatan`),
  ADD KEY `id_kota` (`id_kota`);

--
-- Indexes for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD PRIMARY KEY (`id_kelurahan`),
  ADD KEY `id_kecamatan` (`id_kecamatan`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`);

--
-- Indexes for table `pemeriksa`
--
ALTER TABLE `pemeriksa`
  ADD PRIMARY KEY (`id_pemeriksa`);

--
-- Indexes for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD PRIMARY KEY (`id_pemilik`),
  ADD KEY `id_kelurahan` (`id_kelurahan`);

--
-- Indexes for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD PRIMARY KEY (`no_nota`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_bahanbaku`
--
ALTER TABLE `detail_bahanbaku`
  ADD CONSTRAINT `detail_bahanbaku_ibfk_1` FOREIGN KEY (`id_kayu`) REFERENCES `jenis_hasil_hutan` (`id_kayu`),
  ADD CONSTRAINT `detail_bahanbaku_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `detail_hasil_hutan`
--
ALTER TABLE `detail_hasil_hutan`
  ADD CONSTRAINT `detail_hasil_hutan_ibfk_1` FOREIGN KEY (`no_dkb`) REFERENCES `dokumenpkb` (`no_dkb`),
  ADD CONSTRAINT `detail_hasil_hutan_ibfk_2` FOREIGN KEY (`id_kayu`) REFERENCES `jenis_hasil_hutan` (`id_kayu`);

--
-- Constraints for table `detail_penjualan`
--
ALTER TABLE `detail_penjualan`
  ADD CONSTRAINT `detail_penjualan_ibfk_1` FOREIGN KEY (`no_nota`) REFERENCES `penjualan` (`no_nota`),
  ADD CONSTRAINT `detail_penjualan_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`);

--
-- Constraints for table `dokumenpkb`
--
ALTER TABLE `dokumenpkb`
  ADD CONSTRAINT `dokumenpkb_ibfk_1` FOREIGN KEY (`id_pemilik`) REFERENCES `pemilik` (`id_pemilik`),
  ADD CONSTRAINT `dokumenpkb_ibfk_2` FOREIGN KEY (`id_pemeriksa`) REFERENCES `pemeriksa` (`id_pemeriksa`),
  ADD CONSTRAINT `dokumenpkb_ibfk_3` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`);

--
-- Constraints for table `kecamatan`
--
ALTER TABLE `kecamatan`
  ADD CONSTRAINT `kecamatan_ibfk_1` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id_kota`);

--
-- Constraints for table `kelurahan`
--
ALTER TABLE `kelurahan`
  ADD CONSTRAINT `kelurahan_ibfk_1` FOREIGN KEY (`id_kecamatan`) REFERENCES `kecamatan` (`id_kecamatan`);

--
-- Constraints for table `kota`
--
ALTER TABLE `kota`
  ADD CONSTRAINT `kota_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`);

--
-- Constraints for table `pemilik`
--
ALTER TABLE `pemilik`
  ADD CONSTRAINT `pemilik_ibfk_1` FOREIGN KEY (`id_kelurahan`) REFERENCES `kelurahan` (`id_kelurahan`);

--
-- Constraints for table `penjualan`
--
ALTER TABLE `penjualan`
  ADD CONSTRAINT `penjualan_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `penjualan_ibfk_2` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
