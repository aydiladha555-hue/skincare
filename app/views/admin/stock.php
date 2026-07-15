<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Stok - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <h2 class="h4 fw-bold mb-4">Manajemen Stok</h2>

    <?php if ($lowStock) { ?>
        <div class="alert alert-warning">
            Ada <?= count($lowStock); ?> produk dengan stok habis atau menipis.
        </div>
    <?php } ?>

    <div class="panel-card table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Produk</th><th>Kategori</th><th>Stok</th><th>Status</th><th>Update Stok</th></tr></thead>
            <tbody>
                <?php foreach ($products as $produk) { ?>
                    <tr>
                        <td><?= htmlspecialchars($produk['nama_produk']); ?></td>
                        <td><?= htmlspecialchars($produk['nama_kategori'] ?? '-'); ?></td>
                        <td><?= (int) $produk['stok']; ?></td>
                        <td>
                            <?php if ((int) $produk['stok'] == 0) { ?>
                                <span class="badge text-bg-danger">Habis</span>
                            <?php } elseif ((int) $produk['stok'] <= 5) { ?>
                                <span class="badge text-bg-warning">Menipis</span>
                            <?php } else { ?>
                                <span class="badge text-bg-success">Aman</span>
                            <?php } ?>
                        </td>
                        <td>
                            <form action="index.php?page=admin_stock_update" method="POST" class="d-flex gap-2">
                                <input type="hidden" name="id_produk" value="<?= (int) $produk['id_produk']; ?>">
                                <input type="number" name="stok" class="form-control form-control-sm" value="<?= (int) $produk['stok']; ?>" min="0" style="max-width: 120px;">
                                <button class="btn btn-brand btn-sm">Update</button>
                            </form>
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
