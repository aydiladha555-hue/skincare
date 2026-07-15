<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lacak Paket - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <?php
        $steps = ['Menunggu Pembayaran', 'Diproses', 'Dikemas', 'Dikirim', 'Selesai'];
        $currentIndex = array_search($order['status'], $steps);
        if ($currentIndex === false) {
            $currentIndex = $order['status'] == 'Dibatalkan' ? -1 : 0;
        }
    ?>

    <main class="container py-5">
        <div class="user-section">
            <div class="d-flex flex-wrap justify-content-between gap-3 mb-4">
                <div>
                    <span class="section-label">Lacak Paket</span>
                    <h1 class="h3 fw-bold mt-2 mb-1">Pesanan #<?= (int) $order['id_pesanan']; ?></h1>
                    <p class="text-muted mb-0">Status saat ini: <?= htmlspecialchars($order['status']); ?></p>
                </div>
                <div class="text-md-end">
                    <div class="small text-muted">Metode Pembayaran</div>
                    <strong><?= htmlspecialchars($order['metode_pembayaran'] ?? 'COD'); ?></strong>
                    <?php if (!empty($order['bank_transfer'])) { ?>
                        <div><?= htmlspecialchars($order['bank_transfer']); ?></div>
                    <?php } ?>
                    <?php if (!empty($order['bukti_pembayaran'])) { ?>
                        <a href="uploads/payments/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" target="_blank" class="small">Lihat bukti pembayaran</a>
                    <?php } ?>
                </div>
            </div>

            <?php if ($order['status'] == 'Dibatalkan') { ?>
                <div class="alert alert-danger">Pesanan ini dibatalkan.</div>
            <?php } else { ?>
                <div class="tracking-line">
                    <?php foreach ($steps as $index => $step) { ?>
                        <div class="tracking-step <?= $index <= $currentIndex ? 'is-active' : ''; ?>">
                            <div class="tracking-dot"><?= $index + 1; ?></div>
                            <div>
                                <strong><?= $step; ?></strong>
                                <p class="text-muted mb-0">
                                    <?php
                                        $desc = [
                                            'Menunggu Pembayaran' => 'Pesanan dibuat dan menunggu konfirmasi pembayaran.',
                                            'Diproses' => 'Admin sedang memeriksa dan memproses pesanan.',
                                            'Dikemas' => 'Produk sedang disiapkan dan dikemas.',
                                            'Dikirim' => 'Paket sudah diserahkan ke kurir.',
                                            'Selesai' => 'Paket sudah diterima pelanggan.'
                                        ];
                                        echo $desc[$step];
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="mt-4">
                <a href="index.php?page=order_history" class="btn btn-outline-brand">Kembali ke Riwayat</a>
            </div>
        </div>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
