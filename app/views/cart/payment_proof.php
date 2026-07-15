<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upload Bukti Pembayaran - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <main class="container py-5">
        <div class="user-section">
            <a href="index.php?page=order_history" class="small">Kembali ke riwayat</a>
            <h1 class="h3 fw-bold mt-2">Upload Bukti Pembayaran</h1>
            <p class="text-muted">Pesanan #<?= (int) $order['id_pesanan']; ?> menggunakan transfer bank.</p>

            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
            <?php } ?>

            <div class="row g-4">
                <div class="col-lg-6">
                    <form action="index.php?page=payment_proof" method="POST" enctype="multipart/form-data" class="plain-form">
                        <input type="hidden" name="id_pesanan" value="<?= (int) $order['id_pesanan']; ?>">
                        <div class="mb-3">
                            <label class="form-label">Bank Tujuan</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($order['bank_transfer']); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Total Pembayaran</label>
                            <input type="text" class="form-control" value="Rp <?= number_format($order['total'], 0, ',', '.'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Bukti Pembayaran</label>
                            <input type="file" name="bukti_pembayaran" class="form-control" accept="image/jpeg,image/png,image/webp,application/pdf" required>
                            <div class="form-text">JPG, PNG, WEBP, atau PDF. Maksimal 2MB.</div>
                        </div>
                        <button class="btn btn-brand">Upload Bukti</button>
                    </form>
                </div>
                <div class="col-lg-6">
                    <div class="user-note">
                        <strong>Catatan:</strong>
                        <p class="mb-0">Setelah bukti dikirim, status pembayaran akan menjadi "Menunggu Konfirmasi" dan admin dapat memeriksanya di menu Pembayaran.</p>
                    </div>
                    <?php if (!empty($order['bukti_pembayaran'])) { ?>
                        <div class="mt-3">
                            <a href="uploads/payments/<?= htmlspecialchars($order['bukti_pembayaran']); ?>" target="_blank" class="btn btn-outline-brand">Lihat Bukti Lama</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>

    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
