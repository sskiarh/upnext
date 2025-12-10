<?php
session_start();
require '../includes/config.php';   // <<< pindah ke includes

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ambil data dari form
    $judul         = mysqli_real_escape_string($conn, $_POST['judul']);
    $kategori      = mysqli_real_escape_string($conn, $_POST['kategori']);
    $poster        = mysqli_real_escape_string($conn, $_POST['poster']);
    $deskripsi     = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $benefit       = mysqli_real_escape_string($conn, $_POST['benefit']);
    $register_link = mysqli_real_escape_string($conn, $_POST['register_link']);
    $detail_link   = mysqli_real_escape_string($conn, $_POST['detail_link']);

    // query insert (simple, nanti bisa diperketat lagi sama bagian validasi)
    $sql = "INSERT INTO events
            (judul, kategori, poster, deskripsi, benefit, register_link, detail_link)
            VALUES
            ('$judul', '$kategori', '$poster', '$deskripsi', '$benefit', '$register_link', '$detail_link')";

    if (mysqli_query($conn, $sql)) {
        header('Location: list.php'); // masih satu folder (admin/)
        exit;
    } else {
        $error = 'Gagal menyimpan data: ' . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Event - UPNext</title>
  <link rel="stylesheet" href="../css/admin.css"> <!-- <<< path baru -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="admin-wrapper">
    <div class="admin-header">
      <div>
        <h1 class="admin-title">Tambah Event Baru</h1>
        <p class="admin-subtitle">Lengkapi informasi event yang akan ditampilkan ke mahasiswa.</p>
      </div>
      <a href="list.php" class="btn btn-outline">← Kembali ke daftar</a>
    </div>

    <?php if (!empty($error)) : ?>
      <p style="color:red;"><?= $error; ?></p>
    <?php endif; ?>

    <form method="post" class="admin-form">
      <div>
        <label>Judul Event</label>
        <input type="text" name="judul" required>
      </div>

      <div>
        <label>Kategori</label>
        <select name="kategori" required>
          <option value="">-- Pilih Kategori --</option>
          <option value="seminar">Seminar</option>
          <option value="workshop">Workshop</option>
          <option value="lomba">Lomba</option>
          <option value="sosial">Sosial</option>
        </select>
      </div>

      <div>
        <label>Poster (URL / path gambar)</label>
        <input type="text" name="poster" placeholder="contoh: assets/multimedia-action.png">
      </div>

      <div>
        <label>Deskripsi</label>
        <textarea name="deskripsi" required></textarea>
      </div>

      <div>
        <label>Benefit</label>
        <textarea name="benefit"></textarea>
      </div>

      <div>
        <label>Link Pendaftaran</label>
        <input type="url" name="register_link" placeholder="https://...">
      </div>

      <div>
        <label>Link Detail (opsional)</label>
        <input type="url" name="detail_link" placeholder="https://...">
      </div>

      <div class="form-actions">
        <a href="list.php" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Event</button>
      </div>
    </form>
  </div>
</body>
</html>
