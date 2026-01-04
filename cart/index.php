<?php
$title = "Keranjang";
require_once __DIR__ . "/../layouts/header.php";
require_once __DIR__ . "/../repositories/product_repo.php";

$cart = $_SESSION["cart"] ?? [];
$items = [];
$grandTotal = 0;

foreach ($cart as $id => $qty) {
    $p = product_find($conn, (int)$id);
    if ($p) {
        $subtotal = (int)$p["harga"] * (int)$qty;
        $grandTotal += $subtotal;

        $items[] = [
            "id" => (int)$p["id"],
            "nama" => $p["nama_produk"],
            "harga" => (int)$p["harga"],
            "qty" => (int)$qty,
            "subtotal" => $subtotal,
            "gambar" => $p["gambar"]
        ];
    }
}
?>

<h1 class="h3 fw-bold mb-3">Keranjang</h1>

<?php if (isset($_GET["msg"])): ?>
    <div class="alert alert-success"><?= h($_GET["msg"]) ?></div>
<?php endif; ?>

<?php if (count($items) === 0): ?>
    <div class="alert alert-warning">Keranjang masih kosong.</div>
    <a class="btn btn-primary" href="../products/index.php">Kembali belanja</a>
<?php else: ?>
    <div class="card shadow-sm mb-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th style="width:160px;">Qty</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $it): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($it["gambar"])): ?>
                                            <img src="<?= h($it["gambar"]) ?>" class="rounded" style="width:48px;height:48px;object-fit:cover">
                                        <?php endif; ?>
                                        <div class="fw-semibold"><?= h($it["nama"]) ?></div>
                                    </div>
                                </td>
                                <td><?= rupiah($it["harga"]) ?></td>
                                <td>
                                    <form class="d-flex gap-2" action="update.php" method="POST">
                                        <input type="hidden" name="id" value="<?= (int)$it["id"] ?>">
                                        <input class="form-control form-control-sm" type="number" name="qty" min="1" value="<?= (int)$it["qty"] ?>">
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Update</button>
                                    </form>
                                </td>
                                <td><strong><?= rupiah($it["subtotal"]) ?></strong></td>
                                <td class="text-end">
                                    <a class="btn btn-sm btn-outline-danger" href="remove.php?id=<?= (int)$it["id"] ?>"
                                        onclick="return confirm('Hapus item ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center">
        <a class="btn btn-outline-secondary" href="../products/index.php">Lanjut belanja</a>
        <div class="text-end">
            <div class="text-muted">Total</div>
            <div class="h4 fw-bold mb-2"><?= rupiah($grandTotal) ?></div>
            <a class="btn btn-danger" href="clear.php" onclick="return confirm('Kosongkan keranjang?')">Clear</a>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>