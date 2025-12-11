<?php
// Tentukan base path supaya link tetap benar di root & pages
$basePath = '';
if(str_contains($_SERVER['PHP_SELF'], '/pages/')) {
    $basePath = '../';
}

// Ambil info user dari session (session_start() harus dipanggil di halaman utama)
$user = $_SESSION['id_user'] ?? null;
$nama_pengguna = $_SESSION['nama_pengguna'] ?? '';
$email = $_SESSION['email'] ?? '';
$photo = $_SESSION['photo'] ?? $basePath . 'assets/foto profile.png';
?>

<nav class="navbar">
    <div class="navbar-left">
        <img src="<?= $basePath ?>assets/logo.png" alt="UPNext Logo" class="logo" />
        <h1 class="brand"><span class="upn">UPN</span><span class="ext">ext</span></h1>
    </div>

    <ul class="nav-links" id="navLinks">
        <li><a href="<?= $basePath ?>index.php">Beranda</a></li>
        <li><a href="<?= $basePath ?>acara.php">Acara</a></li>
        <li><a href="<?= $basePath ?>pages/tentangkami.php">Tentang Kami</a></li>

        <?php if($user): ?>
            <li>
                <img src="<?= $photo ?>" alt="Foto Profil" class="navbar-profile" id="navProfile">
            </li>
        <?php else: ?>
            <li><button class="btn-masuk" onclick="window.location.href='<?= $basePath ?>pages/login.php'">Masuk</button></li>
        <?php endif; ?>
    </ul>

    <div class="hamburger" id="hamburger">
        <i class="fa-solid fa-bars"></i>
    </div>
</nav>

<?php if($user): ?>
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="<?= $photo ?>" alt="Foto Profil" id="sidebar-photo">
        <h3 id="sidebar-name"><?= $nama_pengguna ?></h3>
        <p id="sidebar-email"><?= $email ?></p>
    </div>

    <div class="sidebar-menu">
        <a href="<?= $basePath ?>pages/profile.php"><i class="fa-regular fa-user"></i> Profil Saya</a>
        <a href="<?= $basePath ?>pages/bookmark.html"><i class="fa-regular fa-bookmark"></i> Bookmark Saya</a>
        <a href="<?= $basePath ?>admin/list.php"><i class="fa-solid fa-calendar-days"></i> Kelola Event</a>
        <a href="#"><i class="fa-solid fa-gear"></i> Pengaturan</a>
        <a href="<?= $basePath ?>logout.php" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
    </div>
</div>
<div class="overlay" id="overlay"></div>
<?php endif; ?>
