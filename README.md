# Sistem Informasi Manajemen IKM Kurnia Jati Furniture

Sistem Informasi Manajemen berbasis web yang dirancang khusus untuk mengelola operasional bisnis pada **IKM Kurnia Jati Furniture**. Aplikasi ini membantu mengintegrasikan aliran data produksi, inventaris barang, hingga transaksi penjualan dan pembelian secara efisien.

## 🚀 Fitur Utama
Sistem ini mencakup berbagai modul penting untuk manajemen IKM, antara lain:
* **Manajemen Data Master**: Pengelolaan data barang, customer, pegawai, dan pemilik.
* **Transaksi Penjualan**: Pencatatan transaksi penjualan furnitur kepada pelanggan secara detail.
* **Manajemen Inventaris**: Fitur untuk melihat detail barang, menambah stok, serta memperbarui informasi hasil hutan sebagai bahan baku.
* **Pelaporan & Dokumen**: Kemampuan untuk mencetak struk transaksi, nota, dan dokumen PKB (Penatausahaan Hasil Hutan).
* **Sistem Keamanan**: Dilengkapi dengan fitur login untuk membatasi akses pengguna yang tidak berwenang.

## 🛠️ Teknologi yang Digunakan
Proyek ini dibangun menggunakan teknologi stack berikut:
* **Bahasa Pemrograman**: PHP
* **Database**: MySQL (MariaDB)
* **Frontend**: HTML5, CSS3 (Bootstrap 4), JavaScript (jQuery)
* **Pre-processor**: SCSS untuk manajemen gaya yang lebih terstruktur

## 📂 Struktur Repositori
* `/barang`: Modul manajemen data barang furnitur.
* `/customer`: Modul manajemen data pelanggan.
* `/dokumenpkb`: Modul khusus administrasi penatausahaan hasil hutan.
* `/images` & `/img`: Kumpulan aset gambar dan logo aplikasi.
* `/js` & `/css`: File library pendukung UI seperti Bootstrap dan jQuery.
* `/nota` & `/penjualan`: Modul inti untuk pemrosesan transaksi dan cetak bukti bayar.

## 💻 Cara Instalasi
1.  **Clone Repositori**:
    ```bash
    git clone [https://github.com/feyfryvzn/SI-Penjualan-dan-Pembelian-Furniture.git](https://github.com/feyfryvzn/SI-Penjualan-dan-Pembelian-Furniture.git)
    ```
2.  **Persiapan Database**:
    * Impor file `mbdnew (1).sql` ke dalam MySQL database kamu (misalnya menggunakan phpMyAdmin).
3.  **Konfigurasi Koneksi**:
    * Sesuaikan pengaturan database (host, user, password, db_name) pada file `koneksi.php`.
4.  **Jalankan Aplikasi**:
    * Pindahkan folder proyek ke direktori server lokal (seperti `htdocs` di XAMPP).
    * Akses melalui browser di `http://localhost/SI-Penjualan-dan-Pembelian-Furniture`.

---
*Dikembangkan oleh **Feyza Revalina** sebagai bagian dari portofolio Sistem Informasi Industri Otomotif.*
