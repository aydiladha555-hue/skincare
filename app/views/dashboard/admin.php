<?php
if (!isset($_SESSION['id_user'])) {
    header("Location:index.php?page=login");
    exit;
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
    <?php include "app/views/layouts/sidebar.php"; ?>

    <div class="admin-shell">
        <?php include "app/views/layouts/navbar.php"; ?>

        <main class="container-fluid p-4">
            <div class="p-4 mb-4 rounded text-white" style="background:linear-gradient(135deg,#141b34,#d83f87);">
                <div class="admin-badge bg-white mb-2">MODE ADMIN</div>
                <h2 class="fw-bold mb-1">Dashboard Admin GlowCare</h2>
                <p class="mb-0">Halaman ini hanya untuk admin: kelola produk, kategori, stok, pesanan, user, dan laporan penjualan.</p>
            </div>

            <div class="mb-4">
                <h2 class="h4 fw-bold mb-1">Ringkasan Toko</h2>
                <p class="text-muted mb-0">Pantau jumlah produk, kategori, pesanan, dan user GlowCare.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card p-4" style="background:#d83f87;">
                        <div class="fs-2 fw-bold"><?= (int) $jumlahProduk; ?></div>
                        <div>Produk</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card p-4" style="background:#141b34;">
                        <div class="fs-2 fw-bold"><?= (int) $jumlahKategori; ?></div>
                        <div>Kategori</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card p-4" style="background:#71758a;">
                        <div class="fs-2 fw-bold"><?= (int) $jumlahPesanan; ?></div>
                        <div>Pesanan</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card p-4" style="background:#8a2f5f;">
                        <div class="fs-2 fw-bold"><?= (int) $jumlahUser; ?></div>
                        <div>User</div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-3">
                    <div class="stat-card p-4" style="background:#202a4a;">
                        <div class="fs-2 fw-bold">Rp <?= number_format($totalPendapatan, 0, ',', '.'); ?></div>
                        <div>Total Pendapatan</div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-1">
                <div class="col-lg-6">
                    <div class="panel-card p-4 h-100">
                        <h3 class="h5 fw-bold">Statistik Penjualan</h3>
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead><tr><th>Status</th><th>Transaksi</th><th>Total</th></tr></thead>
                                <tbody>
                                    <?php foreach ($statistikPenjualan as $stat) { ?>
                                        <tr>
                                            <td><?= htmlspecialchars($stat['status']); ?></td>
                                            <td><?= (int) $stat['jumlah']; ?></td>
                                            <td>Rp <?= number_format($stat['total'], 0, ',', '.'); ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if (!$statistikPenjualan) { ?>
                                <div class="text-muted">Belum ada transaksi.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="panel-card p-4 h-100">
                        <h3 class="h5 fw-bold">Peringatan Stok Habis / Menipis</h3>
                        <?php foreach ($stokMenipis as $produk) { ?>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span><?= htmlspecialchars($produk['nama_produk']); ?></span>
                                <strong class="<?= ((int) $produk['stok'] == 0) ? 'text-danger' : 'text-warning'; ?>">
                                    <?= (int) $produk['stok']; ?> stok
                                </strong>
                            </div>
                        <?php } ?>
                        <?php if (!$stokMenipis) { ?>
                            <div class="text-muted">Stok produk masih aman.</div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="panel-card p-4 mt-4">
                <h3 class="h5 fw-bold">Menu Admin</h3>
                <div class="d-flex flex-wrap gap-2">
                    <a href="index.php?page=products" class="btn btn-brand">CRUD Produk</a>
                    <a href="index.php?page=admin_categories" class="btn btn-outline-brand">CRUD Kategori</a>
                    <a href="index.php?page=admin_stock" class="btn btn-outline-brand">Kelola Stok</a>
                    <a href="index.php?page=admin_orders" class="btn btn-outline-brand">Kelola Pesanan</a>
                    <a href="index.php?page=admin_payments" class="btn btn-outline-brand">Pembayaran</a>
                    <a href="index.php?page=admin_reports" class="btn btn-outline-brand">Laporan Penjualan</a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
