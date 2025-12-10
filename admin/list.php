<?php
session_start();
require '../includes/config.php'; // path baru ke config

$sql = "SELECT * FROM events ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Event - UPNext</title>
  <link rel="stylesheet" href="../css/admin.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="admin-wrapper">
    <div class="admin-header">
      <div>
        <h1 class="admin-title">Kelola Event UPNext</h1>
        <p class="admin-subtitle">Tambah, ubah, dan hapus event yang tampil di halaman Acara.</p>
      </div>
      <div>
        <a href="create.php" class="btn btn-primary">+ Tambah Event</a>
        <a href="../index.php" class="btn btn-outline">← Kembali ke Beranda</a>
      </div>
    </div>

    <div class="admin-table-wrapper">
      <table class="admin-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Poster</th>
            <th>Register</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) === 0): ?>
            <tr>
              <td colspan="6">Belum ada event. Klik "Tambah Event" untuk membuat yang pertama.</td>
            </tr>
          <?php else: ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td><?= $row['id']; ?></td>
                <td><?= htmlspecialchars($row['judul']); ?></td>
                <td><?= htmlspecialchars($row['kategori']); ?></td>
                <td><?= htmlspecialchars($row['poster']); ?></td>
                <td><?= htmlspecialchars($row['register_link']); ?></td>
                <td>
                  <div class="action-links">
                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn btn-outline">Edit</a>
                    <a href="delete.php?id=<?= $row['id']; ?>"
                       class="btn btn-danger"
                       onclick="return confirm('Yakin mau hapus event ini?')">
                      Hapus
                    </a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <div class="admin-footer-link">
      <a href="../index.php">← Kembali ke beranda utama</a>
    </div>
  </div>
</body>
</html>
