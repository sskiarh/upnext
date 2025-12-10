<?php
session_start();
require '../includes/config.php'; // path baru ke config

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: list.php");
    exit;
}

// paksa jadi integer untuk mencegah injection via id
$id = (int) $id;

$sql = "DELETE FROM events WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: list.php");
    exit;
} else {
    echo "Gagal menghapus data: " . mysqli_error($conn);
}
