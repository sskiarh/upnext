<?php
session_start();
require '../includes/db_functions.php';

// Ambil info user dari session
$user = null;
if(isset($_SESSION['id_user'])){
    $user = [
        'id_user' => $_SESSION['id_user'],
        'nama_pengguna' => $_SESSION['nama_pengguna'],
        'email' => $_SESSION['email'],
        'photo' => $_SESSION['photo'] ?? '../assets/foto profile.png'
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tentang Kami | UPNext</title>
  <link rel="stylesheet" href="../css/style.css" />
  <link rel="icon" type="image/png" href="../assets/logo.png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <script src="../script.js" defer></script>
</head>
<body>

  <!-- ==== NAVBAR ==== -->
  <nav class="navbar">
    <div class="navbar-left">
      <img src="../assets/logo.png" alt="UPNext Logo" class="logo" />
      <h1 class="brand">
        <span class="upn">UPN</span><span class="ext">ext</span>
      </h1>
    </div>

    <ul class="nav-links" id="navLinks">
      <li><a href="../index.php">Beranda</a></li>
      <li><a href="../acara.php">Acara</a></li>
      <li><a href="tentangkami.php">Tentang Kami</a></li>

      <?php if($user): ?>
        <li>
          <img src="<?= $user['photo'] ?>" alt="Foto Profil" class="navbar-profile">
        </li>
      <?php else: ?>
        <li><button class="btn-masuk" onclick="window.location.href='login.php'">Masuk</button></li>
      <?php endif; ?>
    </ul>

    <div class="hamburger" id="hamburger">
      <i class="fa-solid fa-bars"></i>
    </div>
  </nav>

  <!-- ==== SIDEBAR PROFIL ==== -->
  <?php if($user): ?>
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <img src="<?= $user['photo'] ?>" alt="Foto Profil" id="sidebar-photo">
      <h3 id="sidebar-name"><?= $user['nama_pengguna'] ?></h3>
      <p id="sidebar-email"><?= $user['email'] ?></p>
    </div>

    <div class="sidebar-menu">
      <a href="profile.php"><i class="fa-regular fa-user"></i> Profil Saya</a>
      <a href="bookmark.php"><i class="fa-regular fa-bookmark"></i> Bookmark Saya</a>
      <a href="../admin/list.php"><i class="fa-solid fa-calendar-days"></i> Kelola Event</a>
      <a href="#"><i class="fa-solid fa-gear"></i> Pengaturan</a>
      <a href="logout.php" class="logout" id="logoutBtn">
        <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar
      </a>
    </div>
  </div>
  <div class="overlay" id="overlay"></div>
  <?php endif; ?>

  <!-- ==== HALAMAN TENTANG KAMI ==== -->
  <main class="tentang-kami">

    <!-- HERO SECTION -->
    <section class="about-hero">
      <div class="hero-bg" aria-hidden="true"></div>
      <div class="hero-overlay"></div>
      <div class="hero-inner">
        <h1 class="hero-title">#IniCeritaKami</h1>
      </div>
    </section>

    <section class="hero-about">
      <div class="hero-text">
        <h1>Ruang <span>Digital</span> Kegiatan Kampus</h1>
        <p>
          UPNext hadir sebagai platform acara kampus yang menghubungkan mahasiswa,
          panitia, dan komunitas untuk menciptakan pengalaman belajar yang
          menyenangkan, inklusif, dan berbasis teknologi digital.
        </p>
      </div>
      <div class="hero-images">
        <img src="../assets/kisahku.jpg" alt="Kegiatan Kampus" class="img1" />
        <img src="../assets/pemira.jpg" alt="Diskusi Mahasiswa" class="img2" />
        <img src="../assets/comvis.jpg" alt="Workshop Digital" class="img3" />
      </div>
    </section>

    <!-- STATISTIK SECTION -->
    <section class="statistik">
      <div class="stats-grid">
        <div class="stat-card">
          <i class="fas fa-user-graduate"></i>
          <h3>200+</h3>
          <p>Peserta Aktif</p>
        </div>
        <div class="stat-card">
          <i class="fas fa-trophy"></i>
          <h3>5</h3>
          <p>Kompetisi</p>
        </div>
        <div class="stat-card">
          <i class="fas fa-lightbulb"></i>
          <h3>15</h3>
          <p>Narasumber Inspiratif</p>
        </div>
        <div class="stat-card">
          <i class="fas fa-handshake"></i>
          <h3>9</h3>
          <p>Kolaborasi Organisasi</p>
        </div>
      </div>
    </section>

    <!-- VISI & MISI -->
    <section class="visi-misi">
      <div class="visi box">
        <img src="../assets/visi.jpg" alt="Visi Kegiatan" />
        <h2>VISI</h2>
        <p>
          Menjadi pusat kegiatan digital kampus yang menghubungkan mahasiswa,
          panitia, dan komunitas untuk menciptakan pengalaman belajar yang
          menyenangkan dan inklusif.
        </p>
      </div>
      <div class="misi box">
        <img src="../assets/misi.jpg" alt="Misi Kegiatan" />
        <h2>MISI</h2>
        <ul>
          <li>Mempermudah akses informasi kegiatan kampus.</li>
          <li>Menyediakan sistem pendaftaran efisien.</li>
          <li>Mendukung panitia dalam publikasi acara.</li>
          <li>Mendorong kolaborasi dan organisasi kampus.</li>
        </ul>
      </div>
    </section>

    <section class="why-section">
      <h2>Kenapa Kami Ada?</h2>
      <p>
        UPNext lahir dari semangat mahasiswa UPN Veteran Jakarta untuk menciptakan ruang digital yang menghubungkan semua kegiatan kampus dalam satu platform. 
        Kami percaya bahwa kolaborasi, inovasi, dan teknologi bisa membawa pengalaman kampus jadi lebih seru dan inklusif.
      </p>
    </section>

    <!-- TIM KAMI -->
    <section class="tim-kami">
      <h2>TIM <span>PENGEMBANG</span></h2>
      <p class="tim-desc">Kenalan sama orang-orang hebat di balik acara seru kami!</p>
      <div class="tim-grid">
        <div class="tim-card">
          <img src="../assets/nanaw.png" alt="Anggota 1" />
          <h3>Nawra Nashiramitha Fawza</h3>
          <p>2410512170</p>
        </div>
        <div class="tim-card">
          <img src="../assets/raisoy.png" alt="Anggota 2" />
          <h3>Raisa Nasifa Gustian</h3>
          <p>2410512190</p>
        </div>
        <div class="tim-card">
          <img src="../assets/kyul.png" alt="Anggota 3" />
          <h3>Saskia Rahma Putri</h3>
          <p>2410512193</p>
        </div>
        <div class="tim-card">
          <img src="../assets/princes.png" alt="Anggota 4" />
          <h3>Meidiana Maulidya</h3>
          <p>2410512195</p>
        </div>
      </div>
    </section>

  </main>

  <!-- ==== FOOTER ==== -->
  <footer class="footer">
    <div class="footer-top">
      <div class="footer-brand">
        <div class="footer-logo">
          <img src="../assets/logo.png" alt="UPNext Logo">
          <h2><span class="upn">UPN</span><span class="ext">ext</span></h2>
        </div>
        <p class="footer-desc">
          UPNext adalah platform informasi kegiatan kampus Universitas Pembangunan Nasional “Veteran” Jakarta (UPNVJ)
          yang memudahkan mahasiswa untuk menemukan, mengikuti, dan memantau berbagai event seperti seminar, workshop, dan lomba.
        </p>
        <div class="footer-email">
          <i class="fa-solid fa-envelope icon-email"></i>
          <span>upnext@upnvj.ac.id</span>
        </div>
      </div>

      <div class="footer-menu">
        <h3>Menu</h3>
        <ul>
          <li><a href="../index.php">Beranda</a></li>
          <li><a href="../acara.php">Acara</a></li>
          <li><a href="tentangkami.php">Tentang Kami</a></li>
        </ul>
      </div>

      <div class="footer-socials">
        <h3>Socials</h3>
        <div class="social-icons">
          <a href="https://instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
          <a href="https://twitter.com" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
          <a href="https://tiktok.com" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
          <a href="https://github.com" target="_blank"><i class="fa-brands fa-github"></i></a>
          <a href="https://linkedin.com" target="_blank"><i class="fa-brands fa-linkedin"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2025 UPNext | Developed by Cihuy Team</p>
    </div>
  </footer>

</body>
</html>
