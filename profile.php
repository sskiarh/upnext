<?php
session_start();
require 'includes/db_functions.php';

// Redirect kalau belum login
if(!isset($_SESSION['id_user'])){
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data user dari database
$userData = query("SELECT * FROM users WHERE id_user=$id_user")[0];

// Default foto jika kosong
$photo = $userData['photo'] ?: 'assets/foto profile.png';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Profil Saya | UPNext</title>
<link rel="stylesheet" href="css/style.css">
<link rel="icon" type="image/png" href="assets/logo.png">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<section class="profile-container">
    <div class="profile-header">
        <img src="<?= $photo ?>" alt="Foto Profil" id="user-photo">
        <h2><?= htmlspecialchars($userData['nama_pengguna']) ?></h2>
        <p><?= htmlspecialchars($userData['email']) ?></p>
    </div>

    <div class="profile-box">
        <?php
        if(isset($_GET['success'])){
            echo '<div class="notif success">'.htmlspecialchars($_GET['success']).'</div>';
        } elseif(isset($_GET['error'])){
            echo '<div class="notif error">'.htmlspecialchars($_GET['error']).'</div>';
        }
        ?>

        <form action="editprofile.php" method="POST" enctype="multipart/form-data">
            <label>Foto Profil</label>
            <input type="file" name="photo" accept="image/*">

            <label>Nama Lengkap</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($userData['nama_lengkap']) ?>" required>

            <label>Nama Pengguna</label>
            <input type="text" name="username" value="<?= htmlspecialchars($userData['nama_pengguna']) ?>" required>

            <label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($userData['email']) ?>" required>

            <label>Nomor Telepon</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($userData['no_telp']) ?>">

            <label>Kata Sandi</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti">

            <button type="submit" class="btn-main">Simpan Perubahan</button>
        </form>
    </div>
</section>

</body>
</html>
