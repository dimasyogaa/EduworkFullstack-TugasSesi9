<?php
$title = "Edit Produk";
require_once __DIR__ . "/../layouts/header.php";
require_once __DIR__ . "/../repositories/product_repo.php";

$id = (int)($_GET["id"] ?? 0);
$product = product_find($conn, $id);

if (!$product) {
    echo "<div class='alert alert-danger'>Produk tidak ditemukan.</div>";
    require_once __DIR__ . "/../layouts/footer.php";
    exit;
}
?>

<h1 class="h3 fw-bold mb-3">Edit Produk</h1>

<?php if (isset($_GET["err"])): ?>
    <div class="alert alert-danger"><?= h($_GET["err"]) ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="update.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= (int)$product["id"] ?>">

            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input class="form-control" name="nama_produk" value="<?= h($product["nama_produk"]) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="3"><?= h($product["deskripsi"]) ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input class="form-control" type="number" name="harga" value="<?= (int)$product["harga"] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input class="form-control" type="number" name="stok" value="<?= (int)$product["stok"] ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input class="form-control" name="kategori" value="<?= h($product["kategori"] ?? "Umum") ?>">
            </div>

            <?php if (!empty($product["gambar"])): ?>
                <div class="mb-3">
                    <div class="small text-muted mb-1">Gambar saat ini:</div>
                    <img src="<?= h($product["gambar"]) ?>" class="img-fluid rounded" style="max-height:180px;">
                </div>
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Ganti Gambar (opsional)</label>
                <input class="form-control" type="file" name="gambar" accept="image/*">
            </div>

            <button class="btn btn-primary" type="submit">Update</button>
            <a class="btn btn-secondary" href="index.php">Kembali</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>