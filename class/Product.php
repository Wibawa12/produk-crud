<?php
// class/Product.php

class Product {
    // Public properties (boleh tampil di view)
    public $nama;
    public $harga;
    public $kategori;
    public $status;
    public $gambar_path;

    // Protected
    protected $id;
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getId() {
        return $this->id;
    }

    // Ambil data berdasarkan ID
    public function setById($id) {
        $sql = "SELECT * FROM products WHERE id = :id LIMIT 1";
        $stmt = $this->db->query($sql, ['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $this->id = $data['id'];
            $this->nama = $data['nama'];
            $this->harga = $data['harga'];
            $this->kategori = $data['kategori'];
            $this->status = $data['status'];
            $this->gambar_path = $data['gambar_path'];
            return true;
        }
        return false;
    }

    // Ambil semua data
    public function getAll() {
        $sql = "SELECT * FROM products ORDER BY id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Simpan (insert/update)
    public function save() {
        if (isset($this->id)) {
            // Update
            $sql = "UPDATE products SET 
                        nama = :nama,
                        harga = :harga,
                        kategori = :kategori,
                        status = :status,
                        gambar_path = :gambar_path
                    WHERE id = :id";
            $params = [
                'nama' => $this->nama,
                'harga' => $this->harga,
                'kategori' => $this->kategori,
                'status' => $this->status,
                'gambar_path' => $this->gambar_path,
                'id' => $this->id
            ];
        } else {
            // Insert
            $sql = "INSERT INTO products (nama, harga, kategori, gambar_path, status) 
                    VALUES (:nama, :harga, :kategori, :gambar_path, :status)";
            $params = [
                'nama' => $this->nama,
                'harga' => $this->harga,
                'kategori' => $this->kategori,
                'gambar_path' => $this->gambar_path,
                'status' => $this->status
            ];
        }

        $stmt = $this->db->query($sql, $params);
        if ($stmt) {
            if (!isset($this->id)) {
                $this->id = $this->db->conn->lastInsertId();
            }
            return true;
        }
        return false;
    }

    // Hapus
    public function remove() {
        if (isset($this->id)) {
            $sql = "DELETE FROM products WHERE id = :id";
            $params = ['id' => $this->id];
            return $this->db->query($sql, $params) !== false;
        }
        return false;
    }
}