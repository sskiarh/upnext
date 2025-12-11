<?php
session_start();
require 'includes/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pengguna = trim($_POST['nama_pengguna']);
    $kata_sandi = trim($_POST['kata_sandi']);

    $user = query("SELECT * FROM users WHERE nama_pengguna = '$nama_pengguna'");
    
    if ($user && password_verify($kata_sandi, $user[0]['kata_sandi'])) {
        // Login sukses, simpan session
        $_SESSION['id_user'] = $user[0]['id_user'];
        $_SESSION['nama_pengguna'] = $user[0]['nama_pengguna'];
        $_SESSION['email'] = $user[0]['email'];
        $_SESSION['photo'] = $user[0]['photo'] ?: 'assets/foto profile.png';

        header("Location: index.php");
        exit;
    } else {
        header("Location: pages/login.html?error=Nama pengguna atau kata sandi salah");
        exit;
    }
}
