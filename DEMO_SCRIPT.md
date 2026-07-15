# Script Demo UAS GlowCare

Gunakan urutan ini saat presentasi 10-15 menit.

## 1. Pembukaan

Jelaskan singkat:

```text
Aplikasi ini adalah e-commerce skincare berbasis PHP Native MVC.
Ada dua role, yaitu Admin dan User.
Admin mengelola data toko, sedangkan User melakukan belanja produk.
```

## 2. Tunjukkan Struktur MVC

Tunjukkan folder:

```text
app/controllers
app/models
app/views
routes/web.php
config/Database.php
index.php
```

Poin yang disampaikan:

- `index.php` sebagai pintu masuk utama.
- `routes/web.php` sebagai routing.
- Controller memproses request.
- Model mengakses database menggunakan PDO.
- View menampilkan halaman.

## 3. Demo Login Admin

Login:

```text
Email: admin@glowcare.test
Password: password
```

Tunjukkan:

- Dashboard admin.
- Jumlah produk.
- Jumlah pengguna.
- Jumlah pesanan.
- Total pendapatan.
- Statistik penjualan.
- Peringatan stok.

## 4. Demo CRUD Produk

Buka menu Produk.

Tunjukkan:

- Daftar produk.
- Tambah produk.
- Upload foto produk.
- Edit produk.
- Hapus produk.
- Field produk: nama, foto, harga, deskripsi, kategori, stok, berat.

## 5. Demo CRUD Kategori

Buka menu Kategori.

Tunjukkan:

- Tambah kategori.
- Edit kategori.
- Hapus kategori.

## 6. Demo Kelola Stok

Buka menu Stok.

Tunjukkan:

- Daftar stok barang.
- Update jumlah stok.
- Label stok aman, menipis, atau habis.

## 7. Demo Kelola Pesanan

Buka menu Pesanan.

Tunjukkan:

- Pesanan masuk.
- Detail pembelian.
- Ubah status pesanan.
- Tunjukkan status paket: Menunggu Pembayaran, Diproses, Dikemas, Dikirim, Selesai.

## 8. Demo Kelola Pembayaran

Buka menu Pembayaran.

Tunjukkan:

- Metode COD.
- Metode Transfer Bank.
- Pilihan bank transfer.
- Lihat bukti pembayaran dari user.
- Update status pembayaran.

## 9. Demo Manajemen User

Buka menu User.

Tunjukkan:

- Daftar pengguna.
- Ubah role user.
- Hapus akun user.

## 10. Demo Laporan Penjualan

Buka menu Laporan.

Tunjukkan:

- Total transaksi.
- Pendapatan.
- Produk terlaris.
- Riwayat transaksi.

## 11. Demo Login User

Logout dari admin, lalu login user:

```text
Email: user@glowcare.test
Password: password
```

Tunjukkan:

- Home produk.
- Search produk.
- Filter kategori.
- Sort harga termurah dan termahal.
- Detail produk.
- Keranjang.
- Checkout dengan pilihan COD atau Transfer Bank.
- Upload bukti pembayaran saat memilih transfer.
- Riwayat pembelian.
- Lacak paket.
- Profil user dan ganti foto profil.
- Review produk.

## 12. Demo RBAC / Proteksi URL

Saat login sebagai user, coba buka URL admin:

```text
http://localhost/skincare_store/index.php?page=admin_reports
```

Jelaskan:

```text
User biasa tidak bisa mengakses halaman admin karena controller admin memeriksa session dan role.
```

## 13. Penutup

Sampaikan:

```text
Aplikasi sudah menerapkan PHP Native MVC, PDO, prepared statements, password hashing, RBAC, CRUD berelasi, upload file, validasi server-side, dump database, dan dokumentasi.
```
