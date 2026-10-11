<?php
require_once __DIR__ . '/config/Database.php';
require_once __DIR__ . '/includes/helpers.php';

$db = Database::getConnection();

$kategori = $db->query("SELECT id, nama FROM kategori ORDER BY nama")->fetchAll();
$supplier = $db->query("SELECT id, nama FROM supplier ORDER BY nama")->fetchAll();

$errors = [];
$old = ['nama' => '', 'stok' => '', 'harga' => '', 'kategori_id' => '', 'supplier_id' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = [
        'nama'        => trim($_POST['nama'] ?? ''),
        'stok'        => trim($_POST['stok'] ?? ''),
        'harga'       => trim($_POST['harga'] ?? ''),
        'kategori_id' => trim($_POST['kategori_id'] ?? ''),
        'supplier_id' => trim($_POST['supplier_id'] ?? ''),
    ];

    // Validasi sisi server
    if ($old['nama'] === '') {
        $errors[] = 'Nama produk wajib diisi.';
    }
    if (filter_var($old['stok'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]) === false) {
        $errors[] = 'Stok harus berupa angka bulat 0 atau lebih.';
    }
    if (!is_numeric($old['harga']) || (float)$old['harga'] < 0) {
        $errors[] = 'Harga harus berupa angka 0 atau lebih.';
    }
    if (filter_var($old['kategori_id'], FILTER_VALIDATE_INT) === false) {
        $errors[] = 'Kategori wajib dipilih.';
    }
    if (filter_var($old['supplier_id'], FILTER_VALIDATE_INT) === false) {
        $errors[] = 'Supplier wajib dipilih.';
    }

    if (empty($errors)) {
        try {
            $stmt = $db->prepare(
                "INSERT INTO produk (nama, stok, harga, kategori_id, supplier_id)
                 VALUES (:nama, :stok, :harga, :kategori_id, :supplier_id)"
            );
            $stmt->execute([
                ':nama'        => $old['nama'],
                ':stok'        => (int)$old['stok'],
                ':harga'       => $old['harga'],
                ':kategori_id' => (int)$old['kategori_id'],
                ':supplier_id' => (int)$old['supplier_id'],
            ]);
            setFlash('success', 'Produk berhasil ditambahkan.');
        } catch (PDOException $ex) {
            setFlash('error', 'Gagal menambahkan produk. Periksa kembali data yang diisi.');
        }
        redirect('index.php');
    }
}

$judul  = 'Tambah Produk';
$action = 'tambah.php';
$tombol = 'Simpan';
require __DIR__ . '/includes/header.php';
?>

<h1>Tambah Produk</h1>
<?php require __DIR__ . '/includes/form_produk.php'; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>