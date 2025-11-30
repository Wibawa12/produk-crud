<?php
require 'inc/config.php';

$id = (int)($_GET['id'] ?? 0);
if (!$id) {
    Utility::redirect('list.php', 'ID tidak valid.');
}

$product = new Product();
if (!$product->setById($id)) {
    Utility::redirect('list.php', 'Produk tidak ditemukan.');
}

// Menghapus gambar jika ada
if ($product->gambar_path && file_exists($product->gambar_path)) {
    unlink($product->gambar_path);
}

if ($product->remove()) {
    Utility::redirect('list.php', 'Produk berhasil dihapus.');
} else {
    Utility::redirect('list.php', 'Gagal menghapus produk.');
}