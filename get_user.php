<?php
session_start();
require 'includes/db_functions.php';

if(!isset($_SESSION['id_user'])){
    echo json_encode([]);
    exit;
}

$id_user = $_SESSION['id_user'];
$user = query("SELECT * FROM users WHERE id_user=$id_user")[0];

// Foto default kalau kosong
if(empty($user['photo'])){
    $user['photo'] = 'assets/foto profile.png';
}

echo json_encode($user);
