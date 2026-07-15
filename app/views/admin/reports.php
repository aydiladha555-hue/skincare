<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Penjualan - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <h2 class="h4 fw-bold mb-4">Laporan Penjualan</h2>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card p-4" style="background:#d83f87;">
                <div class="fs-2 fw-bold"><?= count($orders); ?></div>
                <div>Total Transaksi</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card p-4" style="background:#141b34;">
                <div class="fs-2 fw-bold">Rp <?= number_format($totalRevenue, 0, ',', '.'); ?></div>
                <div>Pendapatan</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="panel-card p-4 h-100">
                <h3 class="h5 fw-bold">Produk Terlaris</h3>
                <table class="table mb-0">
                    <thead><tr><th>Produk</th><th>Terjual</th><th>Pendapatan</th></tr></thead>
                    <tbody>
                        <?php foreach ($bestSellers as $item) { ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nama_produk']); ?></td>
                                <td><?= (int) $item['total_terjual']; ?></td>
                                <td>Rp <?= number_format($item['total_pendapatan'], 0, ',', '.'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="panel-card table-responsive">
                <table class="table mb-0 align-middle">
                    <thead><tr><th>No</th><th>Pembeli</th><th>Bayar</th><th>Status</th><th>Total</th><th>Tanggal</th></tr></thead>
                    <tbody>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td>#<?= (int) $order['id_pesanan']; ?></td>
                                <td><?= htmlspecialchars($order['username']); ?></td>
                                <td><?= htmlspecialchars($order['metode_pembayaran'] ?? 'COD'); ?></td>
                                <td><?= htmlspecialchars($order['status']); ?></td>
                                <td>Rp <?= number_format($order['total'], 0, ',', '.'); ?></td>
                                <td><?= htmlspecialchars($order['created_at']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
</div>
</body>
</html>
