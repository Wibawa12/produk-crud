<?php
// Mulai session (untuk flash message)
session_start();

// Konfigurasi database
const DB_HOST = 'localhost';
const DB_USER = 'root';
const DB_PASS = '';
const DB_NAME = 'produk_crud';

// Base URL
const BASE_URL = 'http://localhost:8000/';

// Autoload class
spl_autoload_register(function ($class_name) {
    include 'class/' . $class_name . '.php';
});

// Menu navigasi
const NAV_PAGES = [
    ['title' => 'Home',    'url' => 'index.php'],
    ['title' => 'Produk',  'url' => 'list.php'],
    ['title' => 'Tambah',  'url' => 'create.php'],
];