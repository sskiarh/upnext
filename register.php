<?php
session_start();
require 'includes/db_functions.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama_pengguna = trim($_POST['nama_pengguna']);
    $email = trim($_POST['email']);
    $kata_sandi = trim($_POST['kata_sandi']);
    $konfirmasi = trim($_POST['konfirmasi_kata_sandi']);

    // Validasi
    if(strlen($nama_pengguna) < 5){
        header("Location: pages/register.html?error=Nama Pengguna minimal 5 karakter");
        exit;
    }

    if(!preg_match("/^[\w.+-]+@(mahasiswa\.)?upnvj\.ac\.id$/", $email)){
        header("Location: pages/register.html?error=Email harus @mahasiswa.upnvj.ac.id atau @upnvj.ac.id");
        exit;
    }

    if(strlen($kata_sandi) < 8 || !preg_match("/[A-Za-z]/", $kata_sandi) || !preg_match("/[0-9]/", $kata_sandi)){
        header("Location: pages/register.html?error=Password minimal 8 karakter & harus ada huruf & angka");
        exit;
    }

    if($kata_sandi !== $konfirmasi){
        header("Location: pages/register.html?error=Konfirmasi Kata Sandi tidak sama");
        exit;
    }

    // Cek nama pengguna/email unik
    $cek_user = query("SELECT * FROM users WHERE nama_pengguna = '$nama_pengguna' OR email = '$email'");
    if($cek_user){
        header("Location: pages/register.html?error=Nama Pengguna atau Email sudah digunakan");
        exit;
    }

    // Hash password
    $hash = password_hash($kata_sandi, PASSWORD_DEFAULT);

    // Simpan ke database
    $sql = "INSERT INTO users (nama_pengguna, email, kata_sandi) VALUES ('$nama_pengguna', '$email', '$hash')";
    mysqli_query($conn, $sql);

    // Login otomatis
    $user_id = mysqli_insert_id($conn);
    $_SESSION['id_user'] = $user_id;
    $_SESSION['nama_pengguna'] = $nama_pengguna;
    $_SESSION['email'] = $email;

    header("Location: index.php");
    exit;
}
?>
