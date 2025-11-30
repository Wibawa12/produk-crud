<?php
require 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Utility::redirect('create.php');
}

// Mengambil data
$nama = trim($_POST['nama'] ?? '');
$harga = $_POST['harga'] ?? 0;
$kategori = $_POST['kategori'] ?? '';
$status = $_POST['status'] ?? 'tersedia';

// Validasi dasar
$errors = [];
if (empty($nama)) $errors[] = "Nama wajib diisi.";
if (!is_numeric($harga) || $harga < 0) $errors[] = "Harga harus angka ≥ 0.";
if (!in_array($kategori, ['elektronik', 'pakaian'])) $errors[] = "Kategori tidak valid.";
if (!in_array($status, ['tersedia', 'habis'])) $status = 'tersedia';

// Simpan prefill (tanpa gambar)
$prefill = compact('nama', 'harga', 'kategori', 'status');

// Handle upload
$gambar_path = null;
if (!empty($_FILES['gambar']['name'])) {
    $file = $_FILES['gambar'];
    $allowed = ['image/jpeg', 'image/png'];
    $max_size = 2 * 1024 * 1024; // 2 MB

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Upload gambar gagal.";
    } elseif (!in_array($file['type'], $allowed)) {
        $errors[] = "Format gambar hanya JPG/PNG.";
    } elseif ($file['size'] > $max_size) {
        $errors[] = "Ukuran gambar maksimal 2 MB.";
    } else {
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = 'produk_' . time() . '_' . uniqid() . '.' . $ext;
        $target = 'uploads/' . $filename;

        if (move_uploaded_file($file['tmp_name'], $target)) {
            $gambar_path = $target;
        } else {
            $errors[] = "Gagal menyimpan file.";
        }
    }
}

// Jika ada error → kembali ke form
if (!empty($errors)) {
    $msg = implode('<br>', $errors);
    Utility::redirect('create.php', $msg, $prefill);
}

// Simpan ke DB
$product = new Product();
$product->nama = $nama;
$product->harga = $harga;
$product->kategori = $kategori;
$product->gambar_path = $gambar_path;
$product->status = $status;

if ($product->save()) {
    Utility::clearPrefill();
    Utility::redirect('list.php', '✅ Produk berhasil ditambahkan.');
} else {
    Utility::redirect('create.php', '❌ Gagal menyimpan data.', $prefill);
}