<?php
session_start();
require 'includes/db_functions.php';

if(!isset($_SESSION['id_user'])){
    header("Location: pages/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$success = '';
$error = '';

// Upload foto
if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){
    $dir = __DIR__ . '/assets/users/';
    if(!is_dir($dir)) mkdir($dir, 0777, true);

    $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
    $newName = 'user_'.$id_user.'.'.$ext;
    $path = $dir.$newName;

    if(move_uploaded_file($_FILES['photo']['tmp_name'], $path)){
        // Simpan path relatif untuk img src
        $relPath = 'assets/users/'.$newName;
        mysqli_query($conn, "UPDATE users SET photo='$relPath' WHERE id_user=$id_user");
        $_SESSION['photo'] = $relPath;
    } else {
        $error = "Gagal upload foto!";
    }
}

// Ambil data POST
$fullname = trim($_POST['fullname']);
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone']);
$password = trim($_POST['password']);

// Validasi
if(strlen($fullname) < 5){
    $error = "Nama lengkap minimal 5 karakter!";
} elseif(strlen($username) < 5){
    $error = "Nama pengguna minimal 5 karakter!";
} elseif(!preg_match("/@upnvj.ac.id$/", $email) && !preg_match("/@mahasiswa.upnvj.ac.id$/", $email)){
    $error = "Email harus domain kampus!";
} else {
    $check = query("SELECT * FROM users WHERE (nama_pengguna='$username' OR email='$email') AND id_user != $id_user");
    if($check){
        $error = "Nama pengguna atau email sudah dipakai!";
    } else {
        // Password
        if($password != ''){
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $current = query("SELECT * FROM users WHERE id_user=$id_user")[0];
            $password_hash = $current['kata_sandi'];
        }

        // Update DB
        mysqli_query($conn, "UPDATE users SET
            nama_lengkap='$fullname',
            nama_pengguna='$username',
            email='$email',
            no_telp='$phone',
            kata_sandi='$password_hash'
            WHERE id_user=$id_user");

        $_SESSION['nama_pengguna'] = $username;
        $_SESSION['email'] = $email;
        $success = "Profil berhasil diperbarui!";
    }
}

// Redirect
if($error){
    header("Location: pages/profile.php?error=".urlencode($error));
} else {
    header("Location: pages/profile.php?success=".urlencode($success));
}
exit;
?>
