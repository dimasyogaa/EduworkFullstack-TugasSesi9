<?php
require_once __DIR__ . "/../helpers/helpers.php";
require_once __DIR__ . "/../repositories/product_repo.php";

$id = (int)($_GET["id"] ?? 0);
if ($id <= 0) redirect("index.php");

product_delete($conn, $id);
redirect("index.php?msg=" . urlencode("Produk berhasil dihapus."));
