<?php
if (!isset($_SESSION['id_user'])) {
    header("Location:index.php?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard User - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body>
    <main class="container py-5">
        <div class="panel-card p-5">
            <h1 class="fw-bold">Halo, <?= htmlspecialchars($_SESSION['username']); ?></h1>
            <p class="text-muted mb-4">Selamat datang di GlowCare. Lanjutkan belanja skincare pilihanmu.</p>
            <a href="index.php?page=home" class="btn btn-brand">Lihat Produk</a>
            <a href="index.php?page=cart" class="btn btn-outline-brand">Keranjang</a>
            <a href="index.php?page=logout" class="btn btn-light">Logout</a>
        </div>
    </main>
</body>
</html>
