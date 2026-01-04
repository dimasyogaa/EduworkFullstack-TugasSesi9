
# Menjalankan File PHP Tanpa htdocs (Cara Eksekusi Langsung)

Cara ini **tidak perlu Virtual Host**, **tidak perlu pindah ke htdocs**, cukup jalankan server PHP dari folder project.

---

## Opsi 1: PHP Built-in Server (Paling Mudah)



### 1) Jalankan server PHP di port 8000

```bat
php -S localhost:8000
```

### 3) Buka di browser

* `http://localhost:8000/add_product.php`

> Catatan: Biarkan CMD tetap terbuka selama server berjalan.

---


### Buka di browser

* `http://localhost:8000/add_product.php`

---

## Catatan Koneksi MySQL

Agar PHP bisa menyimpan data ke MySQL:

* Pastikan **MySQL di XAMPP ON**
* Biasanya koneksi:

  * Host: `localhost`
  * User: `root`
  * Password: kosong (`""`) atau sesuai pengaturan kamu

---

```
```
