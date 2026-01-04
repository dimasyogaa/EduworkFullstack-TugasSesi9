<?php
$title = "Shop";
require_once __DIR__ . "/../layouts/header.php";
require_once __DIR__ . "/../repositories/product_repo.php";

$selectedCategory = $_GET["category"] ?? "all";
$search = $_GET["q"] ?? "";

// Dropdown kategori
$categories = product_categories($conn);

// Data produk (filter + search)
$result = product_all($conn, $selectedCategory, $search);

// Dipakai untuk redirect kembali setelah klik "+ Keranjang"
// Penting: nilai ini dipakai oleh cart/add.php (lokasinya di folder /cart)
// Jadi kita berikan path yang benar dari sudut pandang /cart.
$currentUrl = "../shop/index.php?" . http_build_query([
    "category" => $selectedCategory,
    "q" => $search,
]);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
    <div>
        <h1 class="h3 fw-bold mb-1">Katalog Produk</h1>
        <div class="text-muted">Cari produk, filter kategori, lalu tambahkan ke keranjang.</div>
    </div>

    <form method="GET" class="d-flex gap-2 flex-wrap">
        <select name="category" class="form-select" style="min-width: 180px;" onchange="this.form.submit()">
            <option value="all" <?= ($selectedCategory === "all") ? "selected" : "" ?>>Semua Kategori</option>

            <?php foreach ($categories as $cat): ?>
                <option value="<?= h($cat) ?>" <?= ($selectedCategory === $cat) ? "selected" : "" ?>>
                    <?= h($cat) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input
            type="text"
            name="q"
            value="<?= h($search) ?>"
            class="form-control"
            style="min-width: 220px;"
            placeholder="Search... (contoh: burger, keju, pedas)"
        >

        <button class="btn btn-primary" type="submit">Cari</button>

        <a class="btn btn-outline-secondary" href="index.php">Reset</a>
    </form>
</div>

<?php if (isset($_GET["msg"])): ?>
    <div class="alert alert-success"><?= h($_GET["msg"]) ?></div>
<?php endif; ?>

<?php if (!$result || $result->num_rows === 0): ?>
    <div class="alert alert-warning mb-0">Produk tidak ditemukan.</div>
<?php else: ?>
    <div class="row g-3">
        <?php while ($p = $result->fetch_assoc()): ?>
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($p["gambar"])): ?>
                        <img
                            src="<?= h($p["gambar"]) ?>"
                            class="card-img-top"
                            alt="<?= h($p["nama_produk"]) ?>"
                            style="height: 180px; object-fit: cover;"
                        >
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                            <h5 class="card-title mb-0"><?= h($p["nama_produk"]) ?></h5>
                            <span class="badge text-bg-primary"><?= h($p["kategori"] ?? "Umum") ?></span>
                        </div>

                        <div class="text-muted small mb-2">Stok: <?= (int)$p["stok"] ?></div>
                        <p class="card-text text-muted mb-3"><?= h($p["deskripsi"]) ?></p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <strong><?= rupiah($p["harga"]) ?></strong>

                            <form action="../cart/add.php" method="POST" class="m-0">
                                <input type="hidden" name="id" value="<?= (int)$p["id"] ?>">
                                <input type="hidden" name="redirect" value="<?= h($currentUrl) ?>">

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm"
                                    <?= ((int)$p["stok"] <= 0) ? "disabled" : "" ?>
                                >
                                    + Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
