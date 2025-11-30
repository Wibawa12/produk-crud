<?php
// class/Utility.php

class Utility {
    // Menampilkan navigasi
    public static function showNav() {
        echo '<nav>';
        echo '<ul>';
        foreach ($pages as $item) {
            $title = htmlspecialchars($item['title']);
            $url = htmlspecialchars($item['url']);
            echo "<li><a href='$url'>$title</a></li>";
        }
        echo '</ul></nav>';
    }

    // Redirect + flash + prefill
    public static function redirect($url, $msg = '', $prefill = []) {
        if ($msg) $_SESSION['flash'] = $msg;
        if (!empty($prefill)) $_SESSION['prefill'] = $prefill;
        header("Location: " . BASE_URL . $url);
        exit;
    }

    // Tampilkan flash message
    public static function showFlash() {
        if (isset($_SESSION['flash'])) {
            echo '<p style="background:#e6f7ff; color:#00509d; padding:8px; margin:10px 0; border-left:4px solid #1890ff;">' . $_SESSION['flash'] . '</p>';
            unset($_SESSION['flash']);
        }
    }

    // Ambil data prefill
    public static function getPrefill($keys = []) {
        $data = [];
        foreach ($keys as $key) {
            $data[$key] = $_SESSION['prefill'][$key] ?? '';
        }
        return $data;
    }

    // Bersihkan prefill
    public static function clearPrefill() {
        unset($_SESSION['prefill']);
    }
}
