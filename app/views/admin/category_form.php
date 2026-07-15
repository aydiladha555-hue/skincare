<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $kategori ? 'Edit' : 'Tambah'; ?> Kategori - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <div class="panel-card p-4 mx-auto" style="max-width: 640px;">
        <h2 class="h4 fw-bold mb-4"><?= $kategori ? 'Edit' : 'Tambah'; ?> Kategori</h2>
        <form method="POST">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" value="<?= htmlspecialchars($kategori['nama_kategori'] ?? ''); ?>" required>
            <div class="mt-4 d-flex gap-2">
                <button class="btn btn-brand">Simpan</button>
                <a href="index.php?page=admin_categories" class="btn btn-light">Kembali</a>
            </div>
        </form>
    </div>
</main>
</div>
</body>
</html>
