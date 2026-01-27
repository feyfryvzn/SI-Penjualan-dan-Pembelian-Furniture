<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  header('Location: home.php');
  exit;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Kurnia Jati Furniture</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      background: #0056b3;
      position: relative;
      overflow: hidden;
    }

    /* Background Belah Kiri Putih Melengkung */
    .left-shape {
      position: absolute;
      left: 0;
      top: 0;
      width: 60%;
      height: 100%;
      background: white;
      clip-path: ellipse(80% 100% at 0% 50%);
      z-index: 0;
    }

    .login-box {
      position: relative;
      z-index: 1;
      width: 400px;
      padding: 40px;
      background: rgba(255, 255, 255, 0.9);
      border-radius: 20px;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
      text-align: center;
      backdrop-filter: blur(6px);
    }

    .login-box img.logo {
      width: 70px;
      margin-bottom: 20px;
    }

    .login-box h2 {
      color: #0056b3;
      font-weight: 600;
      margin-bottom: 20px;
    }

    .icon {
      width: 60px;
      height: 60px;
      background-color: #0056b3;
      border-radius: 50%;
      margin: 0 auto 20px;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .icon::before {
      content: '👤';
      font-size: 28px;
      color: white;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    input {
      padding: 12px 15px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: #f0f4f8;
    }

    button {
      padding: 12px;
      margin-top: 10px;
      background-color: #0056b3;
      color: white;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #003e8a;
    }

    .extra-links {
      text-align: center;
      margin-top: 15px;
    }

    .extra-links a {
      color: #0056b3;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .extra-links a:hover {
      text-decoration: underline;
    }

    footer {
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.8rem;
      color: white;
      z-index: 1;
    }

    footer a {
      color: white;
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="left-shape"></div>

  <div class="login-box">
    <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="user icon" class="logo" />
    <form method="POST">
  <input type="text" name="username" placeholder="Username" required />
  <input type="password" name="password" placeholder="Password" required />
  <button type="submit">SIGN IN</button>
  </form>

    <div class="extra-links">
      <a href="index.php">← Kembali ke Beranda</a>
    </div>
  </div>

  <footer>
    © 2025 Kurnia Jati Furniture | <a href="mailto:kurniajatifurniture@gmail.com">Email Kami</a>
  </footer>

</body>
</html>