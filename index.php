<?php
include "db.php"; // koneksi database

// Daftar produk simulasi
$produkList = [
  "rockmaster" => [
    "nama"   => "Rockmaster 25",
    "harga"  => 749000,
    "stok"   => 8,
    "gambar" => "https://d1yutv2xslo29o.cloudfront.net/product/variant/media/web/small/83cd837c7040dc15e37b684fe4567adf.webp"
  ],
  "giant" => [
    "nama"   => "Giant Pangolin 4P",
    "harga"  => 3289000,
    "stok"   => 1,
    "gambar" => "https://d1yutv2xslo29o.cloudfront.net/product/photo/910009112_750e.jpg"
  ]
];

// Ambil produk dari query string
$idProduk = $_GET['produk'] ?? null;
$produk   = $idProduk ? ($produkList[$idProduk] ?? null) : null;

// Variabel hasil
$hasil = null;

// Proses checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doCheckout'])) {
  $nama     = $_POST['nama'] ?? '';
  $email    = $_POST['email'] ?? '';
  $telepon  = $_POST['telepon'] ?? '';
  $tanggal  = $_POST['tanggal'] ?? '';
  $produkNm = $_POST['produk'] ?? '';
  $warna    = $_POST['warna'] ?? '';
  $bayar    = $_POST['bayar'] ?? '';
  $tambahan = isset($_POST['tambahan']) ? implode(", ", $_POST['tambahan']) : '';
  $catatan  = $_POST['catatan'] ?? '';

  $sql = "INSERT INTO pesanan (nama, email, telepon, tanggal, produk, warna, bayar, tambahan, catatan)
          VALUES ('$nama', '$email', '$telepon', '$tanggal', '$produkNm', '$warna', '$bayar', '$tambahan', '$catatan')";

  if ($conn->query($sql) === TRUE) {
    $hasil = [
      'Nama'     => $nama,
      'Email'    => $email,
      'Telepon'  => $telepon,
      'Tanggal'  => $tanggal,
      'Produk'   => $produkNm,
      'Warna'    => $warna,
      'Bayar'    => $bayar,
      'Tambahan' => $tambahan,
      'Catatan'  => $catatan,
      'Status'   => "✅ Pesanan berhasil disimpan ke database!"
    ];
  } else {
    echo "<div class='alert alert-danger'>❌ Error: " . $conn->error . "</div>";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Eiger Adventure Clone</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">Eiger Adventure</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Produk</a></li>
        <li class="nav-item"><a class="nav-link" href="pesanan.php">Pesanan</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Hero -->
<section class="bg-light text-center p-5 mb-4">
  <div class="container">
    <h1 class="fw-bold">Temukan Peralatan Petualanganmu</h1>
    <p class="text-muted">Tas gunung, tenda, dan perlengkapan outdoor berkualitas tinggi.</p>
  </div>
</section>

<div class="container pb-5">

  <?php if (!$produk): ?>
    <!-- Grid Produk -->
    <div class="row">
      <?php foreach ($produkList as $id => $p): ?>
        <div class="col-md-6 mb-4">
          <div class="card h-100 shadow-sm">
            <img src="<?= $p['gambar'] ?>" class="card-img-top" alt="<?= $p['nama'] ?>">
            <div class="card-body">
              <h5 class="card-title"><?= $p['nama'] ?></h5>
              <p class="card-text">Rp <?= number_format($p['harga'], 0, ",", ".") ?></p>
              <a href="index.php?produk=<?= $id ?>#detail" class="btn btn-dark">Lihat Detail</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  <?php else: ?>
    <!-- Detail Produk -->
    <div id="detail" class="row mb-4">
      <div class="col-md-6">
        <img src="<?= $produk['gambar'] ?>" class="img-fluid rounded shadow" alt="<?= $produk['nama'] ?>">
      </div>
      <div class="col-md-6">
        <h2><?= $produk['nama'] ?></h2>
        <h4 class="text-danger">Rp <?= number_format($produk['harga'], 0, ",", ".") ?></h4>
        <p>Stok: <span class="text-success">Sisa <?= $produk['stok'] ?></span></p>
        <a href="#checkoutForm" class="btn btn-primary">Checkout</a>

        <!-- Pilihan warna -->
        <h5 class="mt-4">Pilihan Warna</h5>
        <div class="d-flex gap-2 flex-wrap pilihan-warna">
          <button type="button" data-color="red">Merah</button>            
          <button type="button" data-color="yellow">Kuning</button> 
          <button type="button" data-color="blue">Biru</button>    
          <button type="button" data-color="green">Hijau</button>
        </div>
        <p id="warnaDipilih" class="mt-2 text-muted">Belum ada warna dipilih</p>
        <input type="hidden" name="warna" id="inputWarna" value="">
      </div>
    </div>

    <!-- Accordion Info Produk -->
    <div class="accordion mb-5" id="infoProduk">
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingOne">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
            Tentang Produk
          </button>
        </h2>
        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#infoProduk">
          <div class="accordion-body">
            <?= ($idProduk == "rockmaster") 
              ? "Rockmaster 25 dirancang khusus untuk para pendaki, ringkas dengan kapasitas 25L." 
              : "Giant Pangolin 4P adalah tenda kapasitas besar, cocok untuk camping keluarga." ?>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingTwo">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
            Detail Teknis
          </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#infoProduk">
          <div class="accordion-body">
            <?= ($idProduk == "rockmaster") 
              ? "<ul><li>Kapasitas 25L</li><li>Bahan water-resistant</li><li>Berat 0.9kg</li></ul>" 
              : "<ul><li>Kapasitas 4 orang</li><li>Bahan polyester anti-air</li><li>Berat 6kg</li></ul>" ?>
          </div>
        </div>
      </div>
      <div class="accordion-item">
        <h2 class="accordion-header" id="headingThree">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
            Fitur
          </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#infoProduk">
          <div class="accordion-body">
            <?= ($idProduk == "rockmaster") 
              ? "<ul><li>Kompak untuk hiking singkat</li><li>Saku samping botol</li><li>Ventilasi punggung</li></ul>" 
              : "<ul><li>Sistem ventilasi ganda</li><li>Rangka alumunium</li><li>Lapisan UV protection</li></ul>" ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Formulir Checkout -->
    <h2 id="checkoutForm">Formulir Checkout</h2>
    <form action="index.php?produk=<?= urlencode($idProduk) ?>#checkoutForm" method="post" class="mb-4">
      <input type="hidden" name="doCheckout" value="1">
      <input type="hidden" name="produk" value="<?= $produk['nama'] ?>">
      <input type="hidden" name="warna" id="inputWarna" value="">
      
      <div class="row g-3">
        <div class="col-md-6">
          <label>Nama Lengkap</label>
          <input type="text" class="form-control" name="nama" required>
        </div>
        <div class="col-md-6">
          <label>Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="col-md-6">
          <label>Telepon</label>
          <input type="number" class="form-control" name="telepon" required>
        </div>
        <div class="col-md-6">
          <label>Tanggal Pemesanan</label>
          <input type="date" class="form-control" name="tanggal" required>
        </div>
      </div>

      <div class="mt-3">
        <label for="bayar">Metode Pembayaran</label><br>
        <select name="bayar" id="bayar" class="form-control" required>
          <option value="">-- Pilih Pembayaran --</option>
          <option value="Transfer">Transfer</option>
          <option value="COD">COD</option>
          <option value="E-Wallet">E-Wallet</option>
        </select>
      </div>

      <div class="mt-3">
        <label>Tambahan</label><br>
        <input type="checkbox" name="tambahan[]" value="Asuransi"> Asuransi
        <input type="checkbox" name="tambahan[]" value="Packing Kayu"> Packing Kayu
        <input type="checkbox" name="tambahan[]" value="Garansi"> Garansi
      </div>

      <div class="mt-3">
        <label>Catatan</label>
        <textarea name="catatan" class="form-control"></textarea>
      </div>

      <div class="mt-4">
        <button type="submit" class="btn btn-danger">Kirim Pesanan</button>
        <a href="pesanan.php" class="btn btn-success">📋 Lihat Semua Pesanan</a>
      </div>
    </form>

    <?php if ($hasil): ?>
      <h3 class="mt-4">Hasil Pesanan</h3>
      <ul class="list-group mb-4">
        <?php foreach ($hasil as $k => $v): ?>
          <li class="list-group-item"><?= $k ?>: <?= htmlspecialchars($v) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-3">
  <p class="mb-0">&copy; <?= date("Y") ?> Eiger Adventure </p>
</footer>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>
</body>
</html>