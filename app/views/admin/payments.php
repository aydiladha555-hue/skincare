<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pembayaran - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="h4 fw-bold mb-1">Manajemen Pembayaran</h2>
            <p class="text-muted mb-0">Pantau metode pembayaran COD atau transfer bank dari pesanan user.</p>
        </div>
    </div>

    <div class="panel-card table-responsive">
        <table class="table mb-0 align-middle">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pembeli</th>
                    <th>Metode</th>
                    <th>Bank</th>
                    <th>Bukti</th>
                    <th>Total</th>
                    <th>Status Bayar</th>
                    <th>Update</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order) { ?>
                    <tr>
                        <td>#<?= (int) $order['id_pesanan']; ?></td>
                        <td><?= htmlspecialchars($order['username']); ?><br><small><?= htmlspecialchars($order['email']); ?></small></td>
                        <td><?= htmlspecialchars($order['metode_pembayaran'] ?? 'COD'); ?></td>
                        <td><?= htmlspecialchars(($order['bank_transfer'] ?? '') ?: '-'); ?></td>
                        <td>
                            <?php if (!empty($order['bukti_pembayaran'])) { ?>
                                <a href="uploads/payments/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" target="_blank" class="btn btn-outline-brand btn-sm">Lihat Bukti</a>
                            <?php } else { ?>
                                <span class="text-muted">-</span>
                            <?php } ?>
                        </td>
                        <td>Rp <?= number_format($order['total'], 0, ',', '.'); ?></td>
                        <td><span class="badge text-bg-light"><?= htmlspecialchars($order['status_pembayaran'] ?? 'Belum Dibayar'); ?></span></td>
                        <td>
                            <form action="index.php?page=admin_payment_status" method="POST" class="d-flex gap-2">
                                <input type="hidden" name="id_pesanan" value="<?= (int) $order['id_pesanan']; ?>">
                                <select name="status_pembayaran" class="form-select form-select-sm">
                                    <?php foreach (['Belum Dibayar','Menunggu Transfer','Menunggu Konfirmasi','Sudah Dibayar','Bayar di Tempat','Gagal'] as $status) { ?>
                                        <option value="<?= $status; ?>" <?= (($order['status_pembayaran'] ?? '') == $status) ? 'selected' : ''; ?>><?= $status; ?></option>
                                    <?php } ?>
                                </select>
                                <button class="btn btn-brand btn-sm">Simpan</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php if (!$orders) { ?>
            <div class="p-4 text-center text-muted">Belum ada data pembayaran.</div>
        <?php } ?>
    </div>
</main>
</div>
</body>
</html>
