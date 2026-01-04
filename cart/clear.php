<?php
require_once __DIR__ . "/../helpers/helpers.php";
if (session_status() === PHP_SESSION_NONE) session_start();

$_SESSION["cart"] = [];
redirect("index.php?msg=" . urlencode("Keranjang dikosongkan."));
