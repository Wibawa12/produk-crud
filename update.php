<?php
require 'inc/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    Utility::redirect('list.php');
}

$id = (int)($_POST['id'] ?? 0);
if (!$id) {
    Utility::redirect('list.php', 'ID tidak valid.');
}

$product = new Product();
if (!$product->setById($id)) {
    Utility::redirect('list.php', 'Produk tidak ditemukan.');
}

// Mengammbil data baru
$nama = trim($_POST['nama'] ?? '');
$harga = $_POST['harga'] ?? 0;
$kategori = $_POST['kategori'] ?? '';
$status = $_POST['status'] ?? 'tersedia';

// Validasi
$errors = [];
if (empty($nama)) $errors[] = "Nama wajib diisi.";
if (!is_numeric($harga) || $harga < 0) $errors[] = "Harga harus angka ≥ 0.";
if (!in_array($kategori, ['elektronik', 'pakaian'])) $errors[] = "Kategori tidak valid.";
if (!in_array($status, ['tersedia', 'habis'])) $status = 'tersedia';

// Handle upload (jika ada file baru)
$gambar_path = $product->gambar_path;

if (!empty($_FILES['gambar']['name'])) {
    $file = $_FILES['gambar'];
    $allowed = ['image/jpeg', 'image/png'];
    $max_size = 2 * 1024 * 1024;

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = "Upload gambar gagal.";
    } elseif (!in_array($file['type'], $allowed)) {
        $errors[] = "Format gambar hanya JPG/PNG.";
    } elseif ($file['size'] > $max_size) {
        $errors[] = "Ukuran gambar maksimal 2 MB.";
    } else {
        // Hapus gambar lama jika ada
        if ($product->gambar_path && file_exists($product->gambar_path)) {
            unlink($product->gambar_path);
        }

        // Simpan baru
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

if (!empty($errors)) {
    $msg = implode('<br>', $errors);
    Utility::redirect("edit.php?id=$id", $msg);
}

// Update data
$product->nama = $nama;
$product->harga = $harga;
$product->kategori = $kategori;
$product->status = $status;
$product->gambar_path = $gambar_path;

if ($product->save()) {
    Utility::redirect('list.php', 'Data produk berhasil diperbarui.');
} else {
    Utility::redirect("edit.php?id=$id", 'Gagal memperbarui data.');
}