<?php
session_start();
require '../includes/db_functions.php';

if(!isset($_SESSION['id_user'])){
    header("Location: login.php");
    exit;
}

// Ambil data user dari session
$user = [
    'id_user' => $_SESSION['id_user'],
    'nama_pengguna' => $_SESSION['nama_pengguna'],
    'email' => $_SESSION['email'],
    'photo' => $_SESSION['photo'] ?? '../assets/foto profile.png'
];

// Notifikasi
$notif = '';
if(isset($_GET['success'])){
    $notif = '<div class="notif success">'.htmlspecialchars($_GET['success']).'</div>';
} elseif(isset($_GET['error'])){
    $notif = '<div class="notif error">'.htmlspecialchars($_GET['error']).'</div>';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya | UPNext</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../assets/logo.png">
</head>
<body>

<?php include '../includes/navbar.php'; ?>

<section class="profile-container">
    <div class="profile-header">
        <img src="<?= $user['photo'] ?>" alt="Foto Profil">
        <h2><?= htmlspecialchars($user['nama_pengguna']) ?></h2>
        <p><?= htmlspecialchars($user['email']) ?></p>
    </div>

    <div class="profile-box">
        <?= $notif ?>

        <form action="../editprofile.php" method="POST" enctype="multipart/form-data">
            <label>Foto Profil</label>
            <input type="file" name="photo" accept="image/*">

            <label>Nama Lengkap</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($user['nama_pengguna']) ?>" required>

            <label>Nama pengguna</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['nama_pengguna']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Nomor Telepon</label>
            <input type="text" name="phone">

            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">

            <button type="submit" class="btn-main">Simpan Perubahan</button>
        </form>
    </div>
</section>

</body>
</html>
