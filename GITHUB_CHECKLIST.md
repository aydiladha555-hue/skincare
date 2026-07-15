# Checklist Upload GitHub

## File yang wajib ikut repository

- `app/`
- `assets/`
- `config/`
- `routes/`
- `uploads/products/.gitkeep`
- `.htaccess`
- `.gitignore`
- `database.sql`
- `index.php`
- `README.md`
- `DEMO_SCRIPT.md`
- `GITHUB_CHECKLIST.md`

## File/folder yang tidak perlu ikut

- `server.out.log`
- `server.err.log`
- `.agents/`
- `.codex/`
- `uplouds/`
- File upload hasil testing di `uploads/products/`

## Cara upload via Git Bash

Jalankan di folder project:

```bash
cd /c/laragon/www/skincare_store
git init
git add .
git commit -m "Initial UAS skincare e-commerce project"
git branch -M main
git remote add origin https://github.com/USERNAME/NAMA_REPO.git
git push -u origin main
```

Ganti:

```text
USERNAME = username GitHub kamu
NAMA_REPO = nama repository kamu
```

## Catatan

Jika sebelumnya folder `.git` bermasalah, hapus atau rename folder `.git` lama melalui File Explorer, lalu jalankan `git init` lagi dari Git Bash.

## Sebelum dikumpulkan

- Pastikan repository GitHub bisa dibuka.
- Pastikan `database.sql` ada di repository.
- Pastikan `README.md` berisi akun login.
- Pastikan pembagian tugas di README sudah diganti dengan nama anggota kelompok.
- Pastikan ada beberapa commit, jangan hanya satu commit jika dosen menilai kontribusi.
