<?php
session_start();
require '../includes/config.php'; 

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: list.php");
    exit;
}

$id = (int)$id;

// Ambil data lama
$result = mysqli_query($conn, "SELECT * FROM events WHERE id = $id");
if (!$result) {
    die("Query error: " . mysqli_error($conn));
}

$event = mysqli_fetch_assoc($result);
if (!$event) {
    die("Event tidak ditemukan");
}

$error = '';

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul         = mysqli_real_escape_string($conn, $_POST['judul'] ?? '');
    $kategori      = mysqli_real_escape_string($conn, $_POST['kategori'] ?? '');
    $poster        = mysqli_real_escape_string($conn, $_POST['poster'] ?? '');
    $deskripsi     = mysqli_real_escape_string($conn, $_POST['deskripsi'] ?? '');
    $benefit       = mysqli_real_escape_string($conn, $_POST['benefit'] ?? '');
    $register_link = mysqli_real_escape_string($conn, $_POST['register_link'] ?? '');
    $detail_link   = mysqli_real_escape_string($conn, $_POST['detail_link'] ?? '');

    $sql = "UPDATE events SET
                judul         = '$judul',
                kategori      = '$kategori',
                poster        = '$poster',
                deskripsi     = '$deskripsi',
                benefit       = '$benefit',
                register_link = '$register_link',
                detail_link   = '$detail_link'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: list.php");
        exit;
    } else {
        $error = "Gagal mengupdate data: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Event - UPNext</title>
  <link rel="stylesheet" href="../css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="admin-wrapper">
    <div class="admin-header">
      <div>
        <h1 class="admin-title">Edit Event</h1>
        <p class="admin-subtitle">Perbarui informasi event jika ada perubahan.</p>
      </div>
      <a href="list.php" class="btn btn-outline">← Kembali ke daftar</a>
    </div>

    <?php if (!empty($error)): ?>
      <p style="color:red;"><?= $error; ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <div>
        <label>Judul Event</label>
        <input type="file" name="poster" accept="image/*">
               value="<?= htmlspecialchars($event['judul'] ?? ''); ?>" required>
      </div>

      <div>
        <label>Kategori</label>
        <select name="kategori" required>
          <option value="seminar"  <?= ($event['kategori'] ?? '') === 'seminar'  ? 'selected' : ''; ?>>Seminar</option>
          <option value="workshop" <?= ($event['kategori'] ?? '') === 'workshop' ? 'selected' : ''; ?>>Workshop</option>
          <option value="lomba"    <?= ($event['kategori'] ?? '') === 'lomba'    ? 'selected' : ''; ?>>Lomba</option>
          <option value="sosial"   <?= ($event['kategori'] ?? '') === 'sosial'   ? 'selected' : ''; ?>>Sosial</option>
        </select>
      </div>

      <div>
        <label>Poster (URL / path gambar)</label>
        <input type="text" name="poster"
               value="<?= htmlspecialchars($event['poster'] ?? ''); ?>">
      </div>

      <div>
        <label>Deskripsi</label>
        <textarea name="deskripsi" required><?= htmlspecialchars($event['deskripsi'] ?? ''); ?></textarea>
      </div>

      <div>
        <label>Benefit</label>
        <textarea name="benefit"><?= htmlspecialchars($event['benefit'] ?? ''); ?></textarea>
      </div>

      <div>
        <label>Link Pendaftaran</label>
        <input type="url" name="register_link"
               value="<?= htmlspecialchars($event['register_link'] ?? ''); ?>">
      </div>

      <div>
        <label>Link Detail</label>
        <input type="url" name="detail_link"
               value="<?= htmlspecialchars($event['detail_link'] ?? ''); ?>">
      </div>

      <div class="form-actions">
        <a href="list.php" class="btn btn-outline">Batal</a>
        <button type="submit" class="btn btn-primary">Update</button>
      </div>
    </form>
  </div>
</body>
</html>
