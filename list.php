<?php
require 'inc/config.php';
$product = new Product();
$products = $product->getAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="css/style.css">
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
            <div class="table-container">
                <table border="1" cellpadding="10" cellspacing="0">
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
                                <a href="edit.php?id=<?= $p['id'] ?>" class="edit">Edit</a> |
                                <a href="delete.php?id=<?= $p['id'] ?>" 
                                onclick="return confirm('Yakin ingin menghapus produk ini?')" class="delete">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </main>
</body>
</html>