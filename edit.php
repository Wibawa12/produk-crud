<?php
require 'inc/config.php';

$id = (int)($_GET['id'] ?? 0);
$product = new Product();

if (!$product->setById($id)) {
    Utility::redirect('list.php', 'Produk tidak ditemukan.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
</head>
<body>
    <header>
        <h1>Edit Produk #<?= $product->getId() ?></h1>
    </header>

    <?php Utility::showNav(); ?>

    <main style="padding:20px; max-width:600px; margin:0 auto;">
        <?php Utility::showFlash(); ?>

        <form method="POST" action="update.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $product->getId() ?>">

            <div class="nama-produk">
                <label>Nama Produk:</label><br>
                <input type="text" name="nama" 
                       value="<?= htmlspecialchars($product->nama) ?>" 
                       required maxlength="100">
            </div>

            <div class="harga-produk">
                <label>Harga (Rp):</label><br>
                <input type="number" name="harga" step="0.01" min="0"
                       value="<?= htmlspecialchars($product->harga) ?>" 
                       required>
            </div>

            <div class="kategori-produk">
                <label>Kategori:</label><br>
                <select name="kategori" required style="width:100%; padding:5px;">
                    <option value="">-- Pilih --</option>
                    <option value="elektronik" <?= $product->kategori === 'elektronik' ? 'selected' : '' ?>>Elektronik</option>
                    <option value="pakaian" <?= $product->kategori === 'pakaian' ? 'selected' : '' ?>>Pakaian</option>
                </select>
            </div>

            <div class="status-produk">
                <label>Status:</label><br>
                <select name="status" required style="width:100%; padding:5px;">
                    <option value="tersedia" <?= $product->status === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="habis" <?= $product->status === 'habis' ? 'selected' : '' ?>>Habis</option>
                </select>
            </div>

            <div class="gambar-produk">
                <label>Gambar Saat Ini:</label><br>
                <?php if ($product->gambar_path && file_exists($product->gambar_path)): ?>
                    <img src="<?= htmlspecialchars($product->gambar_path) ?>" width="100" style="border:1px solid #ccc;">
                    <p><em>Biarkan kosong untuk mempertahankan gambar.</em></p>
                <?php else: ?>
                    <p>— Tidak ada gambar —</p>
                <?php endif; ?>
            </div>

            <div class="ganti-gambar">
                <label>Ganti Gambar (jpg/png, <= 2MB):</label><br>
                <input type="file" name="gambar" accept="image/jpeg,image/png">
                <p style="font-size:0.9em; color:#666;">Opsional. Biarkan kosong jika tidak ingin mengganti.</p>
            </div>

            <button type="submit" style="padding:8px 20px; background:#28a745; color:#fff; border:none; cursor:pointer;">
                Perbarui
            </button>
            <a href="list.php" style="margin-left:10px;">Batal</a>
        </form>
    </main>
</body>
</html>