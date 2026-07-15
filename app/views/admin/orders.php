<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen Pesanan - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <h2 class="h4 fw-bold mb-4">Manajemen Pesanan</h2>
    <div class="panel-card table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>No</th><th>Pembeli</th><th>Pembayaran</th><th>Total</th><th>Status Paket</th><th>Tanggal</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td>#<?= (int) $order['id_pesanan']; ?></td>
                        <td><?= htmlspecialchars($order['username']); ?><br><small><?= htmlspecialchars($order['email']); ?></small></td>
                        <td>
                            <?= htmlspecialchars($order['metode_pembayaran'] ?? 'COD'); ?><br>
                            <small class="text-muted"><?= htmlspecialchars(($order['bank_transfer'] ?? '') ?: ($order['status_pembayaran'] ?? '-')); ?></small>
                        </td>
                        <td>Rp <?= number_format($order['total'], 0, ',', '.'); ?></td>
                        <td><span class="badge text-bg-light"><?= htmlspecialchars($order['status']); ?></span></td>
                        <td><?= htmlspecialchars($order['created_at']); ?></td>
                        <td><a href="index.php?page=admin_order_detail&id=<?= (int) $order['id_pesanan']; ?>" class="btn btn-brand btn-sm">Detail</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>
</div>
</body>
</html>
