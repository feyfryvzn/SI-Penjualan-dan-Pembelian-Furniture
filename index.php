<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kurnia Jati Furniture</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      background: linear-gradient(to bottom, #e6f0ff, #ffffff);
      color: #001f3f;
      overflow-x: hidden;
    }

    header {
      background: linear-gradient(90deg, #001f3f, #00509e);
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      animation: slideDown 0.7s ease forwards;
    }

    @keyframes slideDown {
      from { transform: translateY(-100%); opacity: 0; }
      to { transform: translateY(0); opacity: 1; }
    }

    header h1 {
      color: #fff;
      font-size: 1.8rem;
      font-weight: 800;
    }

    nav a {
      margin-left: 20px;
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      transition: 0.2s ease;
    }

    nav a:hover {
      text-decoration: underline;
      color: #cce6ff;
    }

    .hero {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 60px 10%;
      background: linear-gradient(120deg, #001f3f, #0066cc);
      color: #fff;
      flex-wrap: wrap;
      animation: fadeIn 1.2s ease forwards;
    }

    .hero-text {
      max-width: 600px;
    }

    .hero-text h2 {
      font-size: 3rem;
      margin-bottom: 20px;
    }

    .hero-text p {
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    .buttons a {
      padding: 12px 24px;
      margin-right: 15px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s ease;
    }

    .buttons .login {
      background-color: #fff;
      color: #002147;
      border: 2px solid #fff;
    }

    .buttons .login:hover {
      background-color: transparent;
      color: #fff;
    }

    .buttons .paket {
      background-color: #0099ff;
      color: #fff;
    }

    .buttons .paket:hover {
      background-color: #007acc;
    }

    .hero-img img {
      max-width: 450px;
      width: 100%;
      border-radius: 20px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.25);
      animation: popUp 1.2s ease forwards;
    }

    @keyframes popUp {
      from { transform: scale(0.8); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }

    .promo {
      background-color: #fffae6;
      padding: 60px 10%;
      text-align: center;
      border-top: 2px dashed #ffd700;
      border-bottom: 2px dashed #ffd700;
      animation: fadeIn 1.5s ease;
    }

    .promo h3 {
      font-size: 2rem;
      color: #cc8800;
      margin-bottom: 15px;
    }

    .promo p {
      font-size: 1.1rem;
      color: #444;
      margin-bottom: 25px;
    }

    .btn-promo {
      display: inline-block;
      background-color: #ffc107;
      color: #000;
      padding: 12px 24px;
      text-decoration: none;
      font-weight: bold;
      border-radius: 8px;
      transition: 0.3s ease;
    }

    .btn-promo:hover {
      background-color: #e0a800;
    }

    section {
      padding: 80px 10%;
      text-align: center;
    }

    section h3 {
      font-size: 2.2rem;
      margin-bottom: 25px;
      color: #002147;
    }

    .gallery {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 25px;
      justify-content: center;
      margin-top: 40px;
      background: #f9f9f9;
      padding: 20px;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .gallery-item {
      position: relative;
      overflow: hidden;
      border-radius: 16px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.15);
      transition: transform 0.3s ease;
    }

    .gallery-item img {
      width: 100%;
      height: 270px;
      object-fit: cover;
      display: block;
    }

    .gallery-item:hover {
      transform: scale(1.03);
    }

    .gallery-item .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 31, 63, 0.7);
      opacity: 0;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      color: #fff;
      transition: opacity 0.3s ease;
      padding: 20px;
    }

    .gallery-item:hover .overlay {
      opacity: 1;
    }

    .gallery-item .overlay h4 {
      font-size: 1.2rem;
      margin-bottom: 10px;
      font-weight: 600;
    }

    .gallery-item .overlay p {
      font-size: 0.9rem;
      margin-bottom: 15px;
    }

    .gallery-item .overlay a {
      padding: 10px 20px;
      background-color: #0099ff;
      color: #fff;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }

    .gallery-item .overlay a:hover {
      background-color: #007acc;
    }

    /* Modal Styles */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.7);
      z-index: 1000;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: #fff;
      border-radius: 16px;
      max-width: 500px;
      width: 90%;
      padding: 20px;
      text-align: center;
      position: relative;
      animation: popUp 0.3s ease;
    }

    .modal-content img {
      width: 100%;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 15px;
    }

    .modal-content h4 {
      font-size: 1.5rem;
      color: #002147;
      margin-bottom: 10px;
    }

    .modal-content p {
      font-size: 1rem;
      color: #444;
      margin-bottom: 20px;
    }

    .modal-content .btn-close {
      position: absolute;
      top: 10px;
      right: 10px;
      background: #ff4444;
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 30px;
      height: 30px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .modal-content .btn-close:hover {
      background: #cc0000;
    }

    .modal-content .btn-contact {
      display: inline-block;
      background-color: #0099ff;
      color: #fff;
      padding: 10px 20px;
      text-decoration: none;
      border-radius: 8px;
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .modal-content .btn-contact:hover {
      background-color: #007acc;
    }

    /* Updated Contact Section Styles */
    .kontak {
      background: #f9f9f9;
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      padding: 60px 10%;
    }

    .kontak-container {
      display: flex;
      gap: 40px;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 40px;
    }

    .kontak-map, .kontak-details {
      flex: 1;
      min-width: 300px;
      animation: fadeIn 1s ease;
    }

    .kontak-map iframe {
      width: 100%;
      height: 400px;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    .kontak-details h4 {
      font-size: 1.5rem;
      color: #002147;
      margin-bottom: 20px;
    }

    .kontak-details p, .kontak-details a {
      font-size: 1rem;
      color: #444;
      margin-bottom: 15px;
      text-decoration: none;
      display: block;
    }

    .kontak-details a:hover {
      color: #0099ff;
    }

    .kontak-details form {
      display: flex;
      flex-direction: column;
      gap: 15px;
      margin-top: 20px;
    }

    .kontak-details input, .kontak-details textarea {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 8px;
      font-size: 1rem;
      width: 100%;
      outline: none;
      transition: border-color 0.3s ease;
    }

    .kontak-details input:focus, .kontak-details textarea:focus {
      border-color: #0099ff;
    }

    .kontak-details textarea {
      resize: vertical;
      min-height: 100px;
    }

    .kontak-details button {
      padding: 12px;
      background-color: #0099ff;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .kontak-details button:hover {
      background-color: #007acc;
    }

    footer {
      background: #001f3f;
      color: #ccc;
      text-align: center;
      padding: 30px 10%;
      font-size: 0.95rem;
    }

    footer .social {
      margin: 20px 0;
      line-height: 2;
    }

    footer .social a {
      color: #ccc;
      font-size: 1rem;
      display: block;
      margin: 5px 0;
      transition: 0.3s ease;
      text-decoration: none;
    }

    footer .social a:hover {
      color: #fff;
    }

    footer .info {
      margin-top: 15px;
      font-size: 0.95rem;
      color: #bbb;
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to { opacity: 1; }
    }

    @media (max-width: 768px) {
      .hero {
        flex-direction: column;
        text-align: center;
      }

      .hero-img {
        margin-top: 40px;
      }

      .gallery {
        grid-template-columns: 1fr;
      }

      .gallery-item img {
        width: 100%;
        height: auto;
      }

      .kontak-map iframe {
        height: 300px;
      }

      .modal-content {
        width: 95%;
      }
    }
  </style>
</head>
<body>

  <header>
    <h1>Kurnia Jati Furniture</h1>
    <nav>
      <a href="#">Beranda</a>
      <a href="#info">Tentang</a>
      <a href="#paket">Koleksi</a>
      <a href="#kontak">Kontak</a>
      <a href="login.php">Login</a>
    </nav>
  </header>

  <section class="hero">
    <div class="hero-text">
      <h2>Furniture Kayu Berkualitas Tinggi</h2>
      <p>Kurnia Jati Furniture menghadirkan solusi interior berbahan dasar kayu jati dan solid wood dengan desain premium dan pengerjaan profesional.</p>
      <div class="buttons">
        <a href="login.php" class="paket">Login</a>
        <a href="#paket" class="paket">Lihat Koleksi</a>
      </div>
    </div>
    <div class="hero-img">
      <img src="images/jatibiru.jpg" alt="Contoh Furniture">
    </div>
  </section>

  <section class="promo">
    <h3>🎉 Promo Spesial Bulan Ini!</h3>
    <p>Dapatkan <strong>diskon hingga 30%</strong> untuk pemesanan furniture custom selama bulan ini!</p>
    <a href="https://wa.me/6281234567890" class="btn-promo" target="_blank">Pesan Sekarang</a>
  </section>

  <section class="info" id="info">
    <h3>Mengapa Harus Memilih Furniture Kayu?</h3>
    <p>Kayu jati adalah pilihan utama dalam dunia furniture karena keindahannya yang alami, daya tahan tinggi, serta keunikan tiap seratnya. 
      Kami memastikan tiap produk dibuat dengan ketelitian dan kualitas terbaik.</p>
  </section>

  <section class="koleksi" id="paket">
    <h3>Koleksi Kami</h3>
    <div class="gallery">
      <div class="gallery-item">
        <img src="images/kursi.jpg" alt="Kursi Jati Klasik">
        <div class="overlay">
          <h4>Kursi Jati Klasik</h4>
          <p>Kursi berbahan kayu jati dengan desain elegan, cocok untuk ruang tamu atau ruang makan.</p>
          <a href="#" class="detail-btn" data-item='{
            "title": "Kursi Jati Klasik",
            "image": "images/kursi.jpg",
            "description": "Kursi ini terbuat dari kayu jati premium dengan finishing halus, memberikan sentuhan elegan untuk ruang tamu atau ruang makan Anda. Tahan lama dan nyaman untuk penggunaan sehari-hari.",
            "price": "Rp 2.500.000"
          }'>Lihat Detail</a>
        </div>
      </div>
      <div class="gallery-item">
        <img src="images/rak.jpg" alt="Rak Buku Minimalis">
        <div class="overlay">
          <h4>Rak Buku Minimalis</h4>
          <p>Rak buku dari kayu solid dengan desain modern, ideal untuk ruang kerja atau perpustakaan.</p>
          <a href="#" class="detail-btn" data-item='{
            "title": "Rak Buku Minimalis",
            "image": "images/rak.jpg",
            "description": "Rak buku minimalis ini dibuat dari kayu solid dengan desain modern, cocok untuk menyimpan buku atau dekorasi di ruang kerja atau rumah Anda.",
            "price": "Rp 3.200.000"
          }'>Lihat Detail</a>
        </div>
      </div>
      <div class="gallery-item">
        <img src="images/raktv.jpg" alt="Rak TV Jati">
        <div class="overlay">
          <h4>Rak TV Jati</h4>
          <p>Rak TV berbahan kayu jati dengan sentuhan rustic, sempurna untuk ruang keluarga.</p>
          <a href="#" class="detail-btn" data-item='{
            "title": "Rak TV Jati",
            "image": "images/raktv.jpg",
            "description": "Rak TV ini terbuat dari kayu jati dengan gaya rustic, dilengkapi dengan ruang penyimpanan untuk perangkat elektronik dan dekorasi ruang keluarga.",
            "price": "Rp 4.000.000"
          }'>Lihat Detail</a>
        </div>
      </div>
    </div>
  </section>

  <section class="kontak" id="kontak">
    <h3>Temukan Kami</h3>
    <div class="kontak-container">
      <div class="kontak-map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18..." allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
      <div class="kontak-details">
        <h4>Hubungi Kami</h4>
        <p><strong>Alamat:</strong> Jl. Belimbing No.6, Cikarang</p>
        <a href="tel:+6281234567890"><i class="fas fa-phone"></i> 0812-3456-7890</a>
        <a href="mailto:info@kurniajatifurniture.com"><i class="fas fa-envelope"></i> info@kurniajatifurniture.com</a>
        <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp: 0812-3456-7890</a>
        <form action="https://wa.me/6281234567890" target="_blank">
          <input type="text" name="name" placeholder="Nama Anda" required>
          <input type="email" name="email" placeholder="Email Anda" required>
          <textarea name="message" placeholder="Pesan Anda" required></textarea>
          <button type="submit">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </section>

  <footer>
    <div class="social">
      <a href="https://wa.me/6281234567890" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp: 0812-3456-7890</a>
      <a href="https://instagram.com/kurniajatifurniture" target="_blank"><i class="fab fa-instagram"></i> Instagram: @kurniajatifurniture</a>
      <a href="https://facebook.com/kurniajatifurniture" target="_blank"><i class="fab fa-facebook"></i> Facebook: Kurnia Jati Furniture</a>
    </div>
    <div class="info">
      <p><strong>Alamat:</strong> Jl. Belimbing No.6, Cikarang</p>
    </div>
    <p>© 2025 Kurnia Jati Furniture. All rights reserved.</p>
  </footer>

  <!-- Modal -->
  <div class="modal" id="detailModal">
    <div class="modal-content">
      <button class="btn-close">×</button>
      <img id="modalImage" src="" alt="Furniture">
      <h4 id="modalTitle"></h4>
      <p id="modalDescription"></p>
      <p><strong>Harga:</strong> <span id="modalPrice"></span></p>
      <a href="https://wa.me/6281234567890" class="btn-contact" target="_blank">Hubungi Kami</a>
    </div>
  </div>

  <script>
    // Get modal and buttons
    const modal = document.getElementById('detailModal');
    const detailButtons = document.querySelectorAll('.detail-btn');
    const closeButton = document.querySelector('.btn-close');

    // Open modal when "Lihat Detail" is clicked
    detailButtons.forEach(button => {
      button.addEventListener('click', (e) => {
        e.preventDefault();
        const item = JSON.parse(button.getAttribute('data-item'));
        document.getElementById('modalImage').src = item.image;
        document.getElementById('modalTitle').textContent = item.title;
        document.getElementById('modalDescription').textContent = item.description;
        document.getElementById('modalPrice').textContent = item.price;
        modal.style.display = 'flex';
      });
    });

    // Close modal when close button is clicked
    closeButton.addEventListener('click', () => {
      modal.style.display = 'none';
    });

    // Close modal when clicking outside the modal content
    window.addEventListener('click', (e) => {
      if (e.target === modal) {
        modal.style.display = 'none';
      }
    });
  </script>

</body>
</html>