<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/includes/helpers.php';

// Hanya boleh lewat POST (bukan klik link biasa)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('index.php');
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id) {
    setFlash('error', 'ID produk tidak valid.');
    redirect('index.php');
}

try {
    $db   = Database::getConnection();
    $stmt = $db->prepare("DELETE FROM produk WHERE id = :id");
    $stmt->execute([':id' => $id]);

    if ($stmt->rowCount() > 0) {
        setFlash('success', 'Produk berhasil dihapus.');
    } else {
        setFlash('error', 'Produk tidak ditemukan.');
    }
} catch (PDOException $ex) {
    setFlash('error', 'Gagal menghapus produk.');
}

redirect('index.php');