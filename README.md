# GlowCare Skincare Store

GlowCare adalah aplikasi web dinamis berbasis PHP Native MVC untuk tugas UAS. Tema aplikasi adalah e-commerce skincare sederhana dengan proses bisnis pembelian produk, pengelolaan stok, pengelolaan pesanan, pembayaran, pelacakan paket, laporan penjualan, dan pembagian hak akses Admin serta User.

## Kesesuaian Dengan Instruksi UAS

- Menggunakan PHP Native dan arsitektur MVC buatan sendiri.
- Menggunakan `index.php` sebagai single gateway routing.
- Menggunakan PDO dan prepared statements untuk akses database.
- Menggunakan autentikasi password dengan `password_hash()` dan `password_verify()`.
- Memiliki RBAC dengan dua role: `admin` dan `user`.
- User biasa tidak dapat mengakses URL admin secara paksa.
- Memiliki CRUD data berelasi: produk, kategori, pesanan, user, review.
- Memiliki upload foto produk dengan validasi server-side.
- Memiliki dump database `database.sql`.
- Memiliki dokumentasi instalasi dan akun demo.

## Teknologi

- PHP Native
- MySQL
- PDO
- Bootstrap 5
- HTML, CSS, JavaScript
- Laragon untuk environment lokal

## Struktur Folder

```text
skincare_store/
|-- app/
|   |-- controllers/
|   |-- models/
|   |-- views/
|   `-- middleware/
|-- assets/
|   `-- css/
|-- config/
|-- routes/
|-- uploads/
|-- database.sql
|-- index.php
`-- README.md
```

## Cara Instalasi Lokal

1. Letakkan folder project di:

```text
C:\laragon\www\skincare_store
```

2. Jalankan Apache dan MySQL melalui Laragon.

3. Import database menggunakan file:

```text
database.sql
```

4. Buka aplikasi di browser:

```text
http://localhost/skincare_store/
```

Clean URL juga dapat digunakan jika `.htaccess` aktif:

```text
http://localhost/skincare_store/admin_reports
```

## Akun Demo

Admin:

```text
Email: admin@glowcare.test
Password: password
```

User:

```text
Email: user@glowcare.test
Password: password
```

## Fitur Admin

- Login admin.
- Dashboard admin: jumlah produk, jumlah pengguna, jumlah pesanan, total pendapatan, statistik penjualan, peringatan stok.
- CRUD produk skincare: nama produk, foto produk, harga, deskripsi, kategori, stok, berat produk.
- CRUD kategori.
- Kelola stok: melihat stok, update stok, peringatan stok habis atau menipis.
- Kelola pesanan: melihat pesanan masuk, detail pembelian, mengubah status paket.
- Kelola pembayaran: melihat COD atau transfer bank, melihat pilihan bank, mengubah status pembayaran.
- Melihat bukti pembayaran transfer dari user.
- Manajemen user: melihat daftar pengguna, menghapus akun user, mengubah role user.
- Laporan penjualan: total transaksi, produk terlaris, pendapatan, riwayat transaksi.

## Fitur User

- Register, login, dan logout.
- Register menyimpan nama, email, password, nomor HP, dan alamat.
- Home produk dengan navbar user.
- Detail produk: foto, harga, deskripsi, stok, berat.
- Search produk berdasarkan nama.
- Filter produk berdasarkan kategori, harga termurah, dan harga termahal.
- Keranjang belanja.
- Checkout dengan metode pembayaran COD atau Transfer Bank.
- Pilihan bank transfer: BCA, BRI, Mandiri, BNI.
- Upload bukti pembayaran untuk transfer bank.
- Riwayat pembelian.
- Lacak paket berdasarkan status pesanan.
- Profil user: edit nama, email, nomor HP, alamat, password, dan foto profil.
- Review produk.

## Validasi dan Keamanan

- Password user disimpan menggunakan hash.
- Controller admin selalu memeriksa role `admin`.
- User biasa diarahkan kembali jika mencoba membuka halaman admin.
- Upload foto produk divalidasi maksimal 2MB.
- Format upload foto hanya JPG, PNG, atau WEBP.
- Input penting divalidasi di sisi server.

## Alur Demo Singkat

1. Login sebagai admin.
2. Tunjukkan Dashboard Admin.
3. Buka CRUD Produk, tambah/edit produk beserta foto.
4. Buka CRUD Kategori.
5. Buka Kelola Stok dan update stok.
6. Buka Kelola Pesanan dan ubah status paket.
7. Buka Pembayaran dan ubah status pembayaran.
8. Buka Manajemen User dan ubah role user.
9. Buka Laporan Penjualan.
10. Logout.
11. Login sebagai user.
12. Cari dan filter produk.
13. Buka detail produk.
14. Tambahkan produk ke keranjang.
15. Checkout dan pilih COD atau transfer bank.
16. Buka riwayat pembelian.
17. Buka lacak paket.
18. Buka dan edit profil user.
19. Tambahkan review produk.
20. Coba akses URL admin sebagai user untuk menunjukkan RBAC.

## Pembagian Tugas

Silakan sesuaikan nama anggota sebelum dikumpulkan:

```text
Anggota 1: Backend MVC, database, autentikasi, RBAC.
Anggota 2: UI, halaman admin/user, validasi, dokumentasi.
```

## Catatan Pengumpulan

- Upload semua source code ke GitHub.
- Sertakan `database.sql` di repository.
- Pastikan repository memiliki riwayat commit yang terlihat.
- Jangan lupa update bagian pembagian tugas sesuai anggota kelompok.
