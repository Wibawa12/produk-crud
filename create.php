<?php
require 'inc/config.php';

// Ambil prefill jika ada
$prefill = Utility::getPrefill(['nama', 'harga', 'kategori', 'status']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Tambah Produk Baru</h1>
    </header>

    <?php Utility::showNav(); ?>

    <main>
        <?php Utility::showFlash(); ?>

        <form method="POST" action="save.php" enctype="multipart/form-data">
            <div>
                <label>Nama Produk:</label><br>
                <input type="text" name="nama" 
                       value="<?= htmlspecialchars($prefill['nama']) ?>" 
                       required maxlength="100">
            </div>

            <div>
                <label>Harga (Rp):</label><br>
                <input type="number" name="harga" step="0.01" min="0"
                       value="<?= htmlspecialchars($prefill['harga']) ?>" 
                       required>
            </div>

            <div>
                <label>Kategori:</label><br>
                <select name="kategori" required>
                    <option value="">-- Pilih --</option>
                    <option value="elektronik" <?= $prefill['kategori'] === 'elektronik' ? 'selected' : '' ?>>Elektronik</option>
                    <option value="pakaian" <?= $prefill['kategori'] === 'pakaian' ? 'selected' : '' ?>>Pakaian</option>
                </select>
            </div>

            <div>
                <label>Status:</label><br>
                <select name="status" required>
                    <option value="tersedia" <?= $prefill['status'] !== 'habis' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="habis" <?= $prefill['status'] === 'habis' ? 'selected' : '' ?>>Habis</option>
                </select>
            </div>

            <div>
                <label>Gambar (jpg/png, <=2MB):</label><br>
                <input type="file" name="gambar" accept="image/jpeg,image/png">
                <p style="font-size:0.9em; color:#666;">Opsional. Biarkan kosong jika tidak ada.</p>
            </div>

            <button type="submit">
                Simpan
            </button>
            <a href="list.php">Batal</a>
        </form>
    </main>
</body>
</html>