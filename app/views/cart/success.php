<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pesanan Berhasil - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>
    <main class="container py-5">
        <div class="user-section text-center mx-auto" style="max-width: 620px;">
            <div class="brand-mark mb-3">OK</div>
            <h1 class="h3 fw-bold">Pesanan berhasil dibuat</h1>
            <p class="text-muted">Nomor pesanan: #<?= htmlspecialchars($_GET['id'] ?? '-'); ?>. Kamu bisa memantau status paket melalui halaman riwayat pembelian.</p>
            <a href="index.php?page=home" class="btn btn-brand">Kembali ke Toko</a>
            <a href="index.php?page=order_track&id=<?= htmlspecialchars($_GET['id'] ?? 0); ?>" class="btn btn-outline-brand">Lacak Paket</a>
        </div>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
