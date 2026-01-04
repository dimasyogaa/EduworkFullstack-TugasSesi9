<?php
require_once __DIR__ . "/../helpers/helpers.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$id  = (int)($_POST["id"] ?? 0);
$qty = (int)($_POST["qty"] ?? 1);

if ($id > 0 && $qty > 0) {
    $_SESSION["cart"][$id] = $qty;
}
redirect("index.php?msg=" . urlencode("Qty diperbarui."));
