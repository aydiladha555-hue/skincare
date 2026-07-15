<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($produk['nama_produk']); ?> - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <main class="container py-5">
        <a href="index.php?page=home" class="d-inline-block mb-4">Kembali ke katalog</a>

        <div class="product-detail-wrap overflow-hidden">
            <div class="row g-0">
                <div class="col-lg-5">
                    <?php if ($produk['foto'] != "") { ?>
                        <img src="uploads/products/<?= htmlspecialchars($produk['foto']); ?>" class="w-100 h-100" style="min-height: 360px; object-fit: cover;" alt="<?= htmlspecialchars($produk['nama_produk']); ?>">
                    <?php } else { ?>
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted h-100" style="min-height: 360px;">No Image</div>
                    <?php } ?>
                </div>
                <div class="col-lg-7 p-4 p-md-5">
                    <span class="badge text-bg-light mb-3"><?= htmlspecialchars($produk['nama_kategori'] ?? 'Tanpa kategori'); ?></span>
                    <h1 class="fw-bold"><?= htmlspecialchars($produk['nama_produk']); ?></h1>
                    <div class="price fs-3 my-3">Rp <?= number_format($produk['harga'], 0, ',', '.'); ?></div>
                    <p class="text-muted"><?= nl2br(htmlspecialchars($produk['deskripsi'])); ?></p>
                    <p>Stok tersedia: <strong><?= (int) $produk['stok']; ?></strong></p>
                    <p>Berat produk: <strong><?= (int) ($produk['berat_produk'] ?? 0); ?> gram</strong></p>

                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <div class="d-flex gap-2 mb-4">
                            <a href="index.php?page=product_edit&id=<?= (int) $produk['id_produk']; ?>" class="btn btn-brand">Edit Produk Ini</a>
                            <a href="index.php?page=products" class="btn btn-light">Kembali ke Admin Produk</a>
                        </div>
                    <?php } ?>

                    <?php if ((int) $produk['stok'] > 0) { ?>
                        <form action="index.php?page=cart_add" method="POST" class="row g-3 align-items-end">
                            <input type="hidden" name="id_produk" value="<?= (int) $produk['id_produk']; ?>">
                            <div class="col-5 col-md-3">
                                <label class="form-label">Jumlah</label>
                                <input type="number" name="jumlah" value="1" min="1" max="<?= (int) $produk['stok']; ?>" class="form-control">
                            </div>
                            <div class="col-7 col-md-5">
                                <button class="btn btn-brand w-100">Tambah ke Keranjang</button>
                            </div>
                        </form>
                    <?php } else { ?>
                        <button class="btn btn-secondary" disabled>Stok habis</button>
                    <?php } ?>
                </div>
            </div>
        </div>

        <section class="user-section mt-4">
            <h2 class="h5 fw-bold mb-3">Review Produk</h2>
            <?php if ($reviews) { ?>
                <?php foreach ($reviews as $review) { ?>
                    <div class="border-bottom py-3">
                        <strong><?= htmlspecialchars($review['username']); ?></strong>
                        <span class="badge text-bg-light"><?= (int) $review['rating']; ?>/5</span>
                        <p class="mb-0 text-muted"><?= nl2br(htmlspecialchars($review['komentar'])); ?></p>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-muted">Belum ada review.</p>
            <?php } ?>

            <form action="index.php?page=review_create" method="POST" class="mt-4">
                <input type="hidden" name="id_produk" value="<?= (int) $produk['id_produk']; ?>">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Rating</label>
                        <select name="rating" class="form-select">
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="col-md-9">
                        <label class="form-label">Komentar</label>
                        <textarea name="komentar" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-brand">Kirim Review</button>
                    </div>
                </div>
            </form>
        </section>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
