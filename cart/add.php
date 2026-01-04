<?php
require_once __DIR__ . "/../helpers/helpers.php";
require_once __DIR__ . "/../repositories/product_repo.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$id = (int)($_POST["id"] ?? 0);

// Opsional: halaman yang akan dibuka setelah add to cart
$redirectTo = $_POST["redirect"] ?? "../shop/index.php";

// Sanitasi sederhana: hanya boleh redirect ke path lokal (bukan http/https)
$startsWithDoubleSlash = (substr($redirectTo, 0, 2) === "//");
if (preg_match('/^https?:/i', $redirectTo) || $startsWithDoubleSlash) {
    $redirectTo = "../shop/index.php";
}

if ($id <= 0) redirect($redirectTo);

$p = product_find($conn, $id);
if (!$p) {
    $joiner = (strpos($redirectTo, "?") !== false) ? "&" : "?";
    redirect($redirectTo . $joiner . "msg=" . urlencode("Produk tidak ditemukan."));
}

if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];
if (!isset($_SESSION["cart"][$id])) $_SESSION["cart"][$id] = 0;

$_SESSION["cart"][$id] += 1;

$joiner = (strpos($redirectTo, "?") !== false) ? "&" : "?";
redirect($redirectTo . $joiner . "msg=" . urlencode("Produk ditambahkan ke keranjang."));
