<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($judul ?? 'Inventaris') ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="topbar">
    <div class="container">
        <a class="brand" href="index.php">📦 Inventaris</a>
        <nav>
            <a href="index.php">Daftar Produk</a>
            <a href="tambah.php">+ Tambah Produk</a>
        </nav>
    </div>
</header>
<main class="container">
    <?php showFlash(); ?>