<?php
require_once __DIR__ . "/../helpers/helpers.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$id = (int)($_GET["id"] ?? 0);
if ($id > 0 && isset($_SESSION["cart"][$id])) {
    unset($_SESSION["cart"][$id]);
}
redirect("index.php?msg=" . urlencode("Item dihapus."));
