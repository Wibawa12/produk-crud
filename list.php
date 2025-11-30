<?php
require 'inc/config.php';
$product = new Product();
$products = $product->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Produk</title>
</head>
<body>
    <header>
        <h1>Daftar Produk</h1>
    </header>

    <?php Utility::showNav(); ?>

    <main>
        <?php Utility::showFlash(); ?>

        <?php if (empty($products)): ?>
            <p>Belum ada data produk.</p>
        <?php else: ?>
            <table border="1" cellpadding="8" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr>
                        <td><?= htmlspecialchars($p['id']) ?></td>
                        <td><?= htmlspecialchars($p['nama']) ?></td>
                        <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($p['kategori']) ?></td>
                        <td><?= $p['status'] === 'tersedia' ? 'Tersedia' : 'Habis' ?></td>
                        <td>
                            <?php if ($p['gambar_path']): ?>
                                <img src="<?= htmlspecialchars($p['gambar_path']) ?>" 
                                     alt="Gambar produk" 
                                     width="50">
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $p['id'] ?>" style="color:blue;">Edit</a> |
                            <a href="delete.php?id=<?= $p['id'] ?>" 
                               onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </main>
</body>
</html>