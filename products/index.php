<?php
$title = "CRUD Produk";
require_once __DIR__ . "/../layouts/header.php";
require_once __DIR__ . "/../repositories/product_repo.php";

// Halaman ini khusus CRUD (tambah/ubah/hapus). Tidak ada fitur cart di sini.
$result = product_all($conn);
?>

<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 mb-3">
    <div>
        <h1 class="h3 fw-bold mb-1">CRUD Produk</h1>
        <div class="text-muted">Kelola data produk (tambah, ubah, hapus).</div>
    </div>

    <a class="btn btn-primary" href="create.php">+ Tambah Produk</a>
</div>

<?php if (isset($_GET["msg"])): ?>
    <div class="alert alert-success"><?= h($_GET["msg"]) ?></div>
<?php endif; ?>

<?php if (!$result || $result->num_rows === 0): ?>
    <div class="alert alert-warning mb-0">Belum ada produk.</div>
<?php else: ?>
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width:70px;">ID</th>
                            <th style="width:90px;">Gambar</th>
                            <th>Nama Produk</th>
                            <th style="width:140px;">Kategori</th>
                            <th style="width:140px;">Harga</th>
                            <th style="width:90px;">Stok</th>
                            <th>Deskripsi</th>
                            <th style="width:170px;" class="text-end">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php while ($p = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$p["id"] ?></td>

                                <td>
                                    <?php if (!empty($p["gambar"])): ?>
                                        <img
                                            src="<?= h($p["gambar"]) ?>"
                                            alt="<?= h($p["nama_produk"]) ?>"
                                            class="rounded border"
                                            style="width:64px;height:48px;object-fit:cover;"
                                        >
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>

                                <td class="fw-semibold"><?= h($p["nama_produk"]) ?></td>

                                <td>
                                    <span class="badge text-bg-primary"><?= h($p["kategori"] ?? "Umum") ?></span>
                                </td>

                                <td><strong><?= rupiah($p["harga"]) ?></strong></td>
                                <td><?= (int)$p["stok"] ?></td>
                                <td class="text-muted"><?= h($p["deskripsi"]) ?></td>

                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                                        <a class="btn btn-outline-secondary btn-sm" href="edit.php?id=<?= (int)$p["id"] ?>">
                                            Edit
                                        </a>

                                        <a
                                            class="btn btn-outline-danger btn-sm"
                                            href="delete.php?id=<?= (int)$p["id"] ?>"
                                            onclick="return confirm('Yakin hapus produk ini?')"
                                        >
                                            Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . "/../layouts/footer.php"; ?>
