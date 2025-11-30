# CRUD Produk – Tugas 1 Back-End

Aplikasi CRUD sederhana untuk entitas **Produk**, tanpa autentikasi.

## #Entitas

- **Tabel**: `products`
- **Atribut**:
  - `nama` (teks, wajib, ≤100)
  - `harga` (numerik, ≥0)
  - `kategori` (dropdown: `elektronik`, `pakaian`)
  - `status` (dropdown: `tersedia`, `habis`)
  - `gambar_path` (string, opsional; menyimpan path ke file di `uploads/`)
  - `created_at` (otomatis)
