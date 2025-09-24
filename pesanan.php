
<?php
include "db.php"; // koneksi database

// Ambil semua data pesanan
$sql = "SELECT * FROM pesanan ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Eiger Adventure</a>
    <div>
      <a href="index.php" class="btn btn-outline-light btn-sm">Kembali ke Produk</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <h1 class="mb-4">📋 Daftar Pesanan</h1>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-striped table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Telepon</th>
            <th>Tanggal</th>
            <th>Produk</th>
            <th>Warna</th>
            <th>Pembayaran</th>
            <th>Tambahan</th>
            <th>Catatan</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= htmlspecialchars($row['telepon']) ?></td>
              <td><?= htmlspecialchars($row['tanggal']) ?></td>
              <td><?= htmlspecialchars($row['produk']) ?></td>
              <td><?= htmlspecialchars($row['warna']) ?></td>
              <td><?= htmlspecialchars($row['bayar']) ?></td>
              <td><?= htmlspecialchars($row['tambahan']) ?></td>
              <td><?= htmlspecialchars($row['catatan']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <div class="alert alert-info">Belum ada pesanan.</div>
  <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; <?= date("Y") ?> Eiger Adventure </p>
</footer>

</body>
</html>
