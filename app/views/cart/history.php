<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Riwayat Pembelian - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>
    <main class="container py-5">
        <h1 class="h3 fw-bold mb-4">Riwayat Pembelian</h1>
        <div class="table-responsive user-table">
            <table class="table mb-0 align-middle">
                <thead>
                    <tr>
                        <th>No Pesanan</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Lacak</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order) { ?>
                        <tr>
                            <td>#<?= (int) $order['id_pesanan']; ?></td>
                            <td><?= htmlspecialchars($order['created_at']); ?></td>
                            <td>Rp <?= number_format($order['total'], 0, ',', '.'); ?></td>
                            <td>
                                <?= htmlspecialchars($order['metode_pembayaran'] ?? 'COD'); ?><br>
                                <small class="text-muted"><?= htmlspecialchars($order['status_pembayaran'] ?? '-'); ?></small>
                                <?php if (!empty($order['bukti_pembayaran'])) { ?>
                                    <br><a href="uploads/payments/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" target="_blank" class="small">Bukti pembayaran</a>
                                <?php } elseif (($order['metode_pembayaran'] ?? '') === 'Transfer Bank') { ?>
                                    <br><a href="index.php?page=payment_proof&id=<?= (int) $order['id_pesanan']; ?>" class="small fw-bold">Upload bukti</a>
                                <?php } ?>
                            </td>
                            <td><span class="badge text-bg-light"><?= htmlspecialchars($order['status']); ?></span></td>
                            <td><a href="index.php?page=order_track&id=<?= (int) $order['id_pesanan']; ?>" class="btn btn-outline-brand btn-sm">Lacak Paket</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <?php if (!$orders) { ?>
                <div class="p-4 text-center text-muted">Belum ada riwayat pembelian.</div>
            <?php } ?>
        </div>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
