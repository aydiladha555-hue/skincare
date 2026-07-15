<?php
if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location:index.php?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Produk - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
    <?php include "app/views/layouts/sidebar.php"; ?>

    <div class="admin-shell">
        <?php include "app/views/layouts/navbar.php"; ?>

        <main class="container-fluid p-4">
            <div class="d-flex flex-wrap gap-3 justify-content-between align-items-end mb-4">
                <div>
                    <h2 class="h4 fw-bold mb-1">Data Produk</h2>
                    <p class="text-muted mb-0">Kelola katalog skincare yang tampil untuk user.</p>
                </div>
                <a href="index.php?page=product_create" class="btn btn-brand">Tambah Produk</a>
            </div>

            <input type="text" id="search" class="form-control mb-3" placeholder="Cari produk...">

            <div class="panel-card table-responsive">
                <table class="table table-hover align-middle mb-0" id="productTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Foto</th>
                            <th>Produk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Berat</th>
                            <th width="170">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $row) { ?>
                            <tr>
                                <td><?= (int) $row['id_produk']; ?></td>
                                <td>
                                    <?php if ($row['foto'] != "") { ?>
                                        <img src="uploads/products/<?= htmlspecialchars($row['foto']); ?>" alt="<?= htmlspecialchars($row['nama_produk']); ?>">
                                    <?php } else { ?>
                                        <span class="text-muted small">No Image</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <strong><?= htmlspecialchars($row['nama_produk']); ?></strong>
                                    <div class="small text-muted"><?= htmlspecialchars(substr($row['deskripsi'], 0, 90)); ?></div>
                                </td>
                                <td><?= htmlspecialchars($row['nama_kategori'] ?? '-'); ?></td>
                                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td><?= (int) $row['stok']; ?></td>
                                <td><?= (int) ($row['berat_produk'] ?? 0); ?> gram</td>
                                <td>
                                    <a href="index.php?page=product_edit&id=<?= (int) $row['id_produk']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="index.php?page=product_delete&id=<?= (int) $row['id_produk']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <?php if (!$products) { ?>
                    <div class="p-4 text-center text-muted">Belum ada produk.</div>
                <?php } ?>
            </div>
        </main>
    </div>

    <script>
        document.getElementById("search").addEventListener("keyup", function () {
            const keyword = this.value.toLowerCase();
            document.querySelectorAll("#productTable tbody tr").forEach(function (row) {
                row.style.display = row.innerText.toLowerCase().includes(keyword) ? "" : "none";
            });
        });
    </script>
</body>
</html>
