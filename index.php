<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/includes/helpers.php';

$db = Database::getConnection();
$q  = trim($_GET['q'] ?? '');

// JOIN produk dengan kategori dan supplier
$sql = "SELECT p.id, p.nama, p.stok, p.harga,
               k.nama AS kategori, s.nama AS supplier
        FROM produk p
        JOIN kategori k ON p.kategori_id = k.id
        JOIN supplier s ON p.supplier_id = s.id";
$params = [];

if ($q !== '') {
    $sql .= " WHERE p.nama LIKE :q";
    $params[':q'] = '%' . $q . '%';
}
$sql .= " ORDER BY p.id DESC";

$stmt = $db->prepare($sql);
$stmt->execute($params);
$daftar = $stmt->fetchAll();

$judul = 'Daftar Produk';
require __DIR__ . '/includes/header.php';
?>

<h1>Daftar Produk</h1>

<form method="get" class="search">
    <input type="text" name="q" placeholder="Cari nama produk..." value="<?= e($q) ?>">
    <button type="submit" class="btn btn-primary">Cari</button>
    <?php if ($q !== ''): ?>
        <a href="index.php" class="btn btn-light">Reset</a>
    <?php endif; ?>
</form>

<table class="tabel">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Supplier</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
    <?php if (empty($daftar)): ?>
        <tr><td colspan="7" class="kosong">Data tidak ditemukan.</td></tr>
    <?php else: ?>
        <?php $no = 1; foreach ($daftar as $p): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= e($p['nama']) ?></td>
            <td><?= e($p['kategori']) ?></td>
            <td><?= e($p['supplier']) ?></td>
            <td><?= e($p['stok']) ?></td>
            <td>Rp <?= e(number_format((float)$p['harga'], 0, ',', '.')) ?></td>
            <td class="aksi">
                <a href="edit.php?id=<?= e($p['id']) ?>" class="btn btn-small btn-warning">Edit</a>
                <form method="post" action="hapus.php" class="inline"
                      onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                    <input type="hidden" name="id" value="<?= e($p['id']) ?>">
                    <button type="submit" class="btn btn-small btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>

<?php require __DIR__ . '/includes/footer.php'; ?>