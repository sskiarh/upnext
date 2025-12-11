<?php
session_start();
require 'includes/db_functions.php';

// Ambil info user dari session
$user = null;
if(isset($_SESSION['id_user'])){
    $user = [
        'id_user' => $_SESSION['id_user'],
        'nama_pengguna' => $_SESSION['nama_pengguna'],
        'email' => $_SESSION['email'],
        'photo' => $_SESSION['photo'] ?? 'assets/foto profile.png'
    ];
}

// Ambil events dari database
$rows = query("SELECT * FROM events ORDER BY created_at DESC");
$eventsForJs = [];
foreach ($rows as $row) {
    $eventsForJs[] = [
        'title' => $row['judul'],
        'category' => $row['kategori'],
        'poster' => $row['poster'],
        'desc' => $row['deskripsi'],
        'benefit' => $row['benefit'],
        'registerLink' => $row['register_link'],
        'detailLink' => $row['detail_link'],
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>UPNext - Acara</title>
<link rel="stylesheet" href="css/style.css" />
<link rel="icon" type="image/png" href="assets/logo.png" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<script>
    window.eventsFromDb = <?= json_encode($eventsForJs); ?>;
</script>
<script src="script.js" defer></script>
</head>
<body>

<!-- ==== NAVBAR ==== -->
<nav class="navbar">
    <div class="navbar-left">
        <img src="assets/logo.png" alt="UPNext Logo" class="logo" />
        <h1 class="brand"><span class="upn">UPN</span><span class="ext">ext</span></h1>
    </div>

    <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Beranda</a></li>
        <li><a href="acara.php">Acara</a></li>
        <li><a href="tentangkami.php">Tentang Kami</a></li>

        <?php if($user): ?>
            <li>
                <img src="<?= $user['photo'] ?>" alt="Foto Profil" class="navbar-profile" id="navProfile">
            </li>
        <?php else: ?>
            <li><button class="btn-masuk" onclick="window.location.href='pages/login.html'">Masuk</button></li>
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
        <a href="pages/bookmark.html"><i class="fa-regular fa-bookmark"></i> Bookmark Saya</a>
        <a href="admin/list.php"><i class="fa-solid fa-calendar-days"></i> Kelola Event</a>
        <a href="#"><i class="fa-solid fa-gear"></i> Pengaturan</a>
        <a href="logout.php" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
    </div>
</div>
<div class="overlay" id="overlay"></div>
<?php endif; ?>

<!-- ==== HALAMAN ACARA ==== -->
<main class="event-page">
    <div class="search-filter">
        <div class="search-box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="searchInput" placeholder="Search event...">
        </div>
        <div class="filter-buttons">
            <button class="filter-btn active" data-category="all">Semua</button>
            <button class="filter-btn" data-category="seminar">Seminar</button>
            <button class="filter-btn" data-category="workshop">Workshop</button>
            <button class="filter-btn" data-category="lomba">Lomba</button>
            <button class="filter-btn" data-category="sosial">Sosial</button>
        </div>
    </div>

    <div id="eventList" class="event-list">
        <!-- Card event akan di-render lewat script.js -->
    </div>
</main>

<!-- ==== FOOTER ==== -->
<footer class="footer">
    <div class="footer-top">
        <div class="footer-brand">
            <div class="footer-logo">
                <img src="assets/logo.png" alt="UPNext Logo">
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
                <li><a href="index.php">Beranda</a></li>
                <li><a href="acara.php">Acara</a></li>
                <li><a href="tentangkami.html">Tentang Kami</a></li>
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
