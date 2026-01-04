<?php
require_once __DIR__ . "/../helpers/helpers.php";
require_once __DIR__ . "/../repositories/product_repo.php";
require_once __DIR__ . "/../config/config.php";

$id = (int)($_POST["id"] ?? 0);
$nama = trim($_POST["nama_produk"] ?? "");
$deskripsi = trim($_POST["deskripsi"] ?? "");
$harga = (int)($_POST["harga"] ?? 0);
$stok  = (int)($_POST["stok"] ?? 0);
$kategori = trim($_POST["kategori"] ?? "Umum");

if ($kategori === "") {
    $kategori = "Umum";
}

if ($id <= 0 || $nama === "" || $deskripsi === "" || $harga <= 0) {
    redirect("edit.php?id={$id}&err=" . urlencode("Nama, deskripsi, dan harga wajib diisi (harga > 0)."));
}

$gambarPath = null;
if (!empty($_FILES["gambar"]["name"])) {
    if (!is_dir(UPLOAD_DIR)) mkdir(UPLOAD_DIR, 0777, true);

    $tmp = $_FILES["gambar"]["tmp_name"];
    $ext = strtolower(pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION));
    $ok = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($ext, $ok)) {
        redirect("edit.php?id={$id}&err=" . urlencode("Format gambar harus jpg/jpeg/png/webp."));
    }

    $fileName = "p_" . time() . "_" . rand(1000, 9999) . "." . $ext;
    if (!move_uploaded_file($tmp, UPLOAD_DIR . $fileName)) {
        redirect("edit.php?id={$id}&err=" . urlencode("Upload gambar gagal."));
    }

    $gambarPath = UPLOAD_URL . $fileName;
}

product_update($conn, $id, $nama, $harga, $deskripsi, $stok, $kategori, $gambarPath);
redirect("index.php?msg=" . urlencode("Produk berhasil diupdate."));
