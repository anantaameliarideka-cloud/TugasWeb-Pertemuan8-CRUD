<?php if (!empty($errors)): ?>
    <div class="alert error">
        <ul>
            <?php foreach ($errors as $err): ?>
                <li><?= e($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= e($action) ?>" class="form">
    <label for="nama">Nama Produk</label>
    <input type="text" id="nama" name="nama" value="<?= e($old['nama']) ?>" required>

    <div class="row">
        <div>
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" min="0" value="<?= e($old['stok']) ?>" required>
        </div>
        <div>
            <label for="harga">Harga (Rp)</label>
            <input type="number" id="harga" name="harga" min="0" step="0.01" value="<?= e($old['harga']) ?>" required>
        </div>
    </div>

    <label for="kategori_id">Kategori</label>
    <select id="kategori_id" name="kategori_id" required>
        <option value="">-- Pilih Kategori --</option>
        <?php foreach ($kategori as $k): ?>
            <option value="<?= e($k['id']) ?>"
                <?= (string)$old['kategori_id'] === (string)$k['id'] ? 'selected' : '' ?>>
                <?= e($k['nama']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <label for="supplier_id">Supplier</label>
    <select id="supplier_id" name="supplier_id" required>
        <option value="">-- Pilih Supplier --</option>
        <?php foreach ($supplier as $s): ?>
            <option value="<?= e($s['id']) ?>"
                <?= (string)$old['supplier_id'] === (string)$s['id'] ? 'selected' : '' ?>>
                <?= e($s['nama']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="actions">
        <button type="submit" class="btn btn-primary"><?= e($tombol) ?></button>
        <a href="index.php" class="btn btn-light">Batal</a>
    </div>
</form>