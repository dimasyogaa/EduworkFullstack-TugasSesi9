<?php
require_once __DIR__ . "/../helpers/helpers.php";
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= h($title ?? "Eduwork Shop") ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <nav class="navbar navbar-expand-lg bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand fw-bold" href="../shop/index.php">Eduwork Shop</a>

            <div class="ms-auto d-flex gap-2">
                <a class="btn btn-outline-secondary btn-sm" href="../shop/index.php">Shop</a>
                <a class="btn btn-outline-primary btn-sm" href="../products/index.php">CRUD Produk</a>
                <a class="btn btn-primary btn-sm" href="../cart/index.php">Keranjang</a>
            </div>
        </div>
    </nav>

    <div class="container py-4">