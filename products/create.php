<?php
$title = "Tambah Produk";
require_once __DIR__ . "/../layouts/header.php";
?>

<h1 class="h3 fw-bold mb-3">Tambah Produk</h1>

<?php if (isset($_GET["err"])): ?>
    <div class="alert alert-danger"><?= h($_GET["err"]) ?></div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="store.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Nama Produk</label>
                <input class="form-control" name="nama_produk">
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea class="form-control" name="deskripsi" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input class="form-control" type="number" name="harga">
            </div>

            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input class="form-control" type="number" name="stok" value="0">
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input class="form-control" name="kategori" placeholder="Contoh: Burger" value="Umum">
                <div class="form-text">Isi bebas (misal: Burger, Minuman, Dessert)</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Gambar (opsional)</label>
                <input class="form-control" type="file" name="gambar" accept="image/*">
            </div>

            <button class="btn btn-primary" type="submit">Simpan</button>
            <a class="btn btn-secondary" href="index.php">Kembali</a>
        </form>
    </div>
</div>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>