<?php require 'inc/config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Produk - Home</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Aplikasi Manajemen Produk</h1>
        <p>CRUD sederhana tanpa autentikasi</p>
    </header>

    <?php Utility::showNav(); ?>

    <main>
        <h2>Selamat Datang!</h2>
        <p>Gunakan menu di atas untuk:</p>
        <ul>
            <li>Melihat daftar produk</li>
            <li>Menambahkan produk baru</li>
            <li>Mengedit atau menghapus data</li>
        </ul>
        <p><em>File upload disimpan di folder <code>uploads/</code>, hanya path-nya yang masuk ke database.</em></p>
    </main>
</body>
</html>