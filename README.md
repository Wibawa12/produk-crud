# CRUD Produk – Tugas 1 Back-End

Aplikasi CRUD sederhana untuk entitas **Produk**, tanpa autentikasi.

## 1. Deskripsi Aplikasi

Aplikasi ini merupakan sistem manajemen data Produk berbasis PHP sederhana, tanpa autentikasi login. Dibuat sebagai implementasi operasi CRUD (Create, Read, Update, Delete) terhadap satu entitas utama: produk.

Entitas produk memiliki atribut:

- nama → teks (wajib, maks. 100 karakter)
- harga → angka desimal (≥ 0)
- kategori → pilihan: elektronik atau pakaian
- status → pilihan: tersedia atau habis
- gambar → file gambar (JPG/PNG, maks. 2 MB; hanya path-nya yang disimpan ke database)

Tujuan utamanya adalah menunjukkan integrasi antara aplikasi back-end dengan basis data relasional, menggunakan struktur modular dan pendekatan OOP dasar, semua dalam lingkungan pengembangan lokal yang ringan.

## 2. Spesifikasi Teknis

- Bahasa: PHP 8.x (dijalankan via built-in web server)
- Basis Data: MySQL / MariaDB
- Driver DB: PDO (PHP Data Objects) — aman dari SQL injection
- Arsitektur: Modular sederhana (bukan MVC penuh), dengan pemisahan logika konfigurasi, akses data, dan tampilan
- Berikut adalah struktur folder secara ringkas:<br>
  produk-crud/<br>
  │<br>
  ├─ class/ # Kelas inti aplikasi<br>
  │├─ Database.php → koneksi & eksekusi query ke database<br>
  │├─ Product.php → entitas produk (CRUD)<br>
  │└─ Utility.php → fungsi bantu: navigasi, redirect, flash message<br>
  │<br>
  ├─ inc/ # Konfigurasi inti<br>
  │└─ config.php → session, konstanta, autoload, koneksi DB<br>
  │<br>
  ├─ css/ # Gaya tampilan<br>
  │└─ style.css → CSS eksternal, responsif & rapi<br>
  │<br>
  ├─ uploads/ # Penyimpanan file gambar yang diunggah<br>
  │<br>
  ├─ \*.php # Halaman aplikasi: index, list, create, edit, save, update, delete<br>
  │<br>
  ├─ schema.sql # Skema tabel `products`<br>
  └─ README.md # Dokumentasi ini<br>

- Penjelasan class utama:
  Class | Deskripsi
  ----------|----------
  Database | Bertugas membuka koneksi ke MySQL via PDO dan menjalankan query dengan prepared statement. Digunakan sebagai “jembatan” antara aplikasi dan database — satu-satunya tempat koneksi dibuat.
  Product | Sebagai representasi dari entitas produk dalam kode. Memiliki atribut sesuai kolom tabel (nama, harga, dll.) dan method untuk operasi CRUD: getAll(), setById(), save() (insert/update), dan remove(). Bekerja langsung dengan Database.
  Utility | Bukan Repository dalam arti ketat, melainkan helper class berisi method static untuk memudahkan tampilan dan navigasi: showNav(), redirect(), showFlash(), dan getPrefill() — membantu memisahkan logika presentasi dari logika bisnis.

## 3. Instruksi Menjalankan Aplikasi

- Persiapan

1. Membuat database di MySQL, misalnya:
   ```sql
   CREATE DATABASE produk_crud;
   ```
2. Impor skema tabel:

- Jalankan perintah berikut di terminal (pastikan mysql bisa diakses):
  ```bash
  mysql -u root -p produk_crud < schema.sql
  ```
- Atau salin isi schema.sql dan eksekusi via phpMyAdmin/MySQL Workbench.

3. Atur koneksi database:

- Buka file inc/config.php
- Sesuaikan konstanta berikut:

  ```php
  const DB_USER = 'root';      // ganti jika user MySQL berbeda
  const DB_PASS = '';          // ganti jika pakai password
  const DB_NAME = 'produk_crud';
  ```

4. Buat folder uploads:

- Buat folder bernama uploads di root proyek.
- Pastikan folder ini dapat ditulisi oleh PHP (jika di Windows, biasanya tidak perlu izin khusus).

**Menjalankan Aplikasi**

1. Buka terminal, masuk ke direktori proyek:

   ```bash
   cd path/ke/produk-crud
   ```

2. Jalankan server PHP bawaan:

   ```
   php -S localhost:8000
   ```

3. Buka browser dan akses:
   ```
   http://localhost:8000/
   ```

- Halaman awal: index.php
- Daftar produk: list.php
- Tambah produk: create.php

## 4. Contoh Skenario Uji Singkat

Berikut adalah contoh alur pengujian sederhana yang bisa dilakukan:
|No. | Langkah | Tindakan | Hasil yang Diharapkan
|----|--------|----------|----------------------
|1. | Tambah data | Buka create.php, isi semua field (mis. nama: Laptop, harga: 15000000, kategori: elektronik, status: tersedia), unggah gambar opsional, lalu klik Simpan. | Data akan muncul di halaman list.php. Gambar tersimpan di folder uploads/, path-nya tercatat di database.
|2. | Tampilkan data | Buka /list.php atau mengklik navigasi produk. | Tabel menampilkan semua produk, termasuk yang baru ditambahkan. Kolom: ID, nama, harga, kategori, status, gambar (thumbnail), dan tombol Edit / Hapus.
|3. | Ubah data | Klik **Edit** di kolom aksi, ubah misalnya status menjadi habis, lalu klik **Perbarui**. | Data di tabel berubah sesuai dengan perubahan. Tidak ada error, dan pesan “Data berhasil diperbarui” muncul.
|4. | Hapus data | Klik **Delete** di kolom aksi, konfirmasi saat muncul dialog. | Baris produk menghilang dari tabel. Pesan “Produk berhasil dihapus” muncul. File gambar (jika ada) tetap ada di folder uploads ini opsional dan tidak wajib dihapus menurut.
