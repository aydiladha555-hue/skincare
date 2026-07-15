<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="panel-card p-4">
                <h2 class="h5 fw-bold">Pesanan #<?= (int) $order['id_pesanan']; ?></h2>
                <p class="mb-1"><strong>Pembeli:</strong> <?= htmlspecialchars($order['username']); ?></p>
                <p class="mb-1"><strong>Telepon:</strong> <?= htmlspecialchars($order['telepon']); ?></p>
                <p class="mb-1"><strong>Alamat:</strong> <?= nl2br(htmlspecialchars($order['alamat'])); ?></p>
                <p class="mb-1"><strong>Total:</strong> Rp <?= number_format($order['total'], 0, ',', '.'); ?></p>
                <p class="mb-1"><strong>Pembayaran:</strong> <?= htmlspecialchars($order['metode_pembayaran'] ?? 'COD'); ?></p>
                <p class="mb-1"><strong>Bank:</strong> <?= htmlspecialchars(($order['bank_transfer'] ?? '') ?: '-'); ?></p>
                <p class="mb-3"><strong>Status Bayar:</strong> <?= htmlspecialchars($order['status_pembayaran'] ?? 'Belum Dibayar'); ?></p>
                <?php if (!empty($order['bukti_pembayaran'])) { ?>
                    <p class="mb-3">
                        <strong>Bukti:</strong>
                        <a href="uploads/payments/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" target="_blank">Lihat bukti pembayaran</a>
                    </p>
                <?php } ?>
                <form action="index.php?page=admin_order_status" method="POST">
                    <input type="hidden" name="id_pesanan" value="<?= (int) $order['id_pesanan']; ?>">
                    <label class="form-label">Ubah Status</label>
                    <select name="status" class="form-select mb-3">
                        <?php foreach (['Menunggu Pembayaran','Diproses','Dikemas','Dikirim','Selesai','Dibatalkan'] as $status) { ?>
                            <option value="<?= $status; ?>" <?= $order['status'] == $status ? 'selected' : ''; ?>><?= $status; ?></option>
                        <?php } ?>
                    </select>
                    <button class="btn btn-brand w-100">Update Status</button>
                </form>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="panel-card table-responsive">
                <table class="table mb-0">
                    <thead><tr><th>Produk</th><th>Harga</th><th>Jumlah</th><th>Subtotal</th></tr></thead>
                    <tbody>
                        <?php foreach ($items as $item) { ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nama_produk']); ?></td>
                                <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                <td><?= (int) $item['jumlah']; ?></td>
                                <td>Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
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
