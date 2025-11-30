-- schema.sql
CREATE DATABASE IF NOT EXISTS produk_crud;
USE produk_crud;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  harga DECIMAL(10,2) NOT NULL CHECK (harga >= 0),
  kategori ENUM('elektronik', 'pakaian') NOT NULL,
  gambar_path VARCHAR(255) DEFAULT NULL,
  status ENUM('tersedia', 'habis') NOT NULL DEFAULT 'tersedia',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);