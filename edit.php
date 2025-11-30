<?php
require 'inc/config.php';

// Ambil ID dari URL
$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    Utility::redirect('list.php', 'ID produk tidak valid.');
}

// Load produk berdasarkan ID
$product = new Product();
if (!$product->setById($id)) {
    Utility::redirect('list.php', 'Produk tidak ditemukan.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk #<?= $product->getId() ?></title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <header>
    <h1>Edit Produk #<?= $product->getId() ?></h1>
  </header>

  <?php Utility::showNav(); ?>

  <main>
    <?php Utility::showFlash(); ?>

    <form class="edit-form" method="POST" action="update.php" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $product->getId() ?>">

      <!-- Nama Produk -->
      <div class="form-group">
        <label for="nama">Nama Produk</label>
        <input type="text" id="nama" name="nama" 
               value="<?= htmlspecialchars($product->nama) ?>" 
               required maxlength="100">
      </div>

      <!-- Harga -->
      <div class="form-group">
        <label for="harga">Harga (Rp)</label>
        <input type="number" id="harga" name="harga" step="0.01" min="0"
               value="<?= htmlspecialchars($product->harga) ?>" 
               required>
      </div>

      <!-- Kategori -->
      <div class="form-group">
        <label for="kategori">Kategori</label>
        <select id="kategori" name="kategori" required>
          <option value="">-- Pilih --</option>
          <option value="elektronik" <?= $product->kategori === 'elektronik' ? 'selected' : '' ?>>
            Elektronik
          </option>
          <option value="pakaian" <?= $product->kategori === 'pakaian' ? 'selected' : '' ?>>
            Pakaian
          </option>
        </select>
      </div>

      <!-- Status -->
      <div class="form-group">
        <label for="status">Status</label>
        <select id="status" name="status" required>
          <option value="tersedia" <?= $product->status === 'tersedia' ? 'selected' : '' ?>>
            Tersedia
          </option>
          <option value="habis" <?= $product->status === 'habis' ? 'selected' : '' ?>>
            Habis
          </option>
        </select>
      </div>

      <!-- Gambar Saat Ini -->
      <?php if ($product->gambar_path && file_exists($product->gambar_path)): ?>
        <div class="current-image-container">
          <span class="current-image-label">Gambar Saat Ini:</span><br>
          <img src="<?= htmlspecialchars($product->gambar_path) ?>" alt="Gambar produk">
        </div>
      <?php endif; ?>

      <!-- Upload Gambar Baru -->
      <div class="form-group">
        <label for="gambar">Ganti Gambar (JPG/PNG, <= 2 MB)</label>
        <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png">
        <p class="image-hint">Biarkan kosong untuk mempertahankan gambar lama.</p>
      </div>

      <div class="btn-group">
        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="list.php" class="btn btn-cancel">Batal</a>
      </div>
    </form>
  </main>
</body>
</html>