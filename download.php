<?php
session_start();
require 'includes/config.php';

$file = $_GET['file'] ?? '';

if (empty($file)) {
    die("File tidak ditemukan");
}

// Validasi file ada di database (security!)
$file = mysqli_real_escape_string($conn, $file);
$result = mysqli_query($conn, "SELECT * FROM events WHERE poster = '$file'");

if (mysqli_num_rows($result) === 0) {
    die("File tidak valid");
}

// Path lengkap file
$filepath = __DIR__ . '/' . $file; // contoh: /var/www/upnext/assets/uploads/1234_poster.jpg

if (!file_exists($filepath)) {
    die("File tidak ditemukan di server");
}

// Ambil info file
$filename = basename($filepath);
$filesize = filesize($filepath);

// Tentukan MIME type berdasarkan ekstensi
$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
$mimeTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
];
$contentType = $mimeTypes[$ext] ?? 'application/octet-stream';

// Set headers untuk download
header('Content-Description: File Transfer');
header('Content-Type: ' . $contentType);
header('Content-Disposition: attachment; filename="poster_' . $filename . '"');
header('Content-Length: ' . $filesize);
header('Pragma: public');
header('Cache-Control: must-revalidate');
header('Expires: 0');

// Clear output buffer
if (ob_get_level()) {
    ob_end_clean();
}
flush();

// Baca file dan kirim ke browser
readfile($filepath);
exit;
?>