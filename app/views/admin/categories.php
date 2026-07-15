<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Kategori - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div><h2 class="h4 fw-bold mb-1">Manajemen Kategori</h2><p class="text-muted mb-0">Tambah, edit, dan hapus kategori skincare.</p></div>
        <a href="index.php?page=admin_category_create" class="btn btn-brand">Tambah Kategori</a>
    </div>
    <div class="panel-card table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>ID</th><th>Nama Kategori</th><th width="180">Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($categories as $cat) { ?>
                    <tr>
                        <td><?= (int) $cat['id_kategori']; ?></td>
                        <td><?= htmlspecialchars($cat['nama_kategori']); ?></td>
                        <td>
                            <a href="index.php?page=admin_category_edit&id=<?= (int) $cat['id_kategori']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="index.php?page=admin_category_delete&id=<?= (int) $cat['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>
</div>
</body>
</html>
