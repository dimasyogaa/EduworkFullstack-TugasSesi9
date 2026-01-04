<?php
// repositories/product_repo.php
// Semua query produk dikumpulkan di sini supaya file halaman tetap bersih.

require_once __DIR__ . "/../config/db.php";

/**
 * Ambil daftar kategori unik untuk dropdown filter.
 */
function product_categories(mysqli $conn): array
{
    $categories = [];

    // Jika kolom kategori belum ada, query ini akan error.
    // Pastikan tabel products punya kolom: kategori
    $res = $conn->query("SELECT DISTINCT kategori FROM products ORDER BY kategori");
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $categories[] = $row["kategori"]; 
        }
    }

    return $categories;
}

/**
 * Ambil list produk.
 * - Bisa filter kategori ("all" = semua)
 * - Bisa search (nama/deskripsi)
 */
function product_all(mysqli $conn, string $category = "all", string $search = ""): mysqli_result
{
    $category = trim($category);
    $search = trim($search);

    $baseSql = "SELECT id, nama_produk, harga, deskripsi, stok, kategori, gambar
                FROM products";
    $orderSql = " ORDER BY id DESC";

    // Tidak ada filter
    if ($category === "all" && $search === "") {
        return $conn->query($baseSql . $orderSql);
    }

    // Bangun WHERE secara sederhana
    $where = [];
    $types = "";
    $params = [];

    if ($category !== "all") {
        $where[] = "kategori = ?";
        $types .= "s";
        $params[] = $category;
    }

    if ($search !== "") {
        // Search di nama & deskripsi
        $where[] = "(nama_produk LIKE ? OR deskripsi LIKE ?)";
        $types .= "ss";
        $like = "%" . $search . "%";
        $params[] = $like;
        $params[] = $like;
    }

    $sql = $baseSql . " WHERE " . implode(" AND ", $where) . $orderSql;
    $stmt = $conn->prepare($sql);

    // Bind parameter dinamis
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    return $stmt->get_result();
}

function product_find(mysqli $conn, int $id): ?array
{
    $stmt = $conn->prepare(
        "SELECT id, nama_produk, harga, deskripsi, stok, kategori, gambar
         FROM products
         WHERE id = ?"
    );
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    return $row ?: null;
}

function product_create(
    mysqli $conn,
    string $nama,
    int $harga,
    string $deskripsi,
    int $stok,
    string $kategori,
    ?string $gambar
): bool {
    $stmt = $conn->prepare(
        "INSERT INTO products (nama_produk, harga, deskripsi, stok, kategori, gambar)
         VALUES (?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("sisiss", $nama, $harga, $deskripsi, $stok, $kategori, $gambar);
    return $stmt->execute();
}

function product_update(
    mysqli $conn,
    int $id,
    string $nama,
    int $harga,
    string $deskripsi,
    int $stok,
    string $kategori,
    ?string $gambar
): bool {
    if ($gambar) {
        $stmt = $conn->prepare(
            "UPDATE products
             SET nama_produk = ?, harga = ?, deskripsi = ?, stok = ?, kategori = ?, gambar = ?
             WHERE id = ?"
        );
        $stmt->bind_param("sisissi", $nama, $harga, $deskripsi, $stok, $kategori, $gambar, $id);
        return $stmt->execute();
    }

    $stmt = $conn->prepare(
        "UPDATE products
         SET nama_produk = ?, harga = ?, deskripsi = ?, stok = ?, kategori = ?
         WHERE id = ?"
    );
    $stmt->bind_param("sisisi", $nama, $harga, $deskripsi, $stok, $kategori, $id);
    return $stmt->execute();
}

function product_delete(mysqli $conn, int $id): bool
{
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}
