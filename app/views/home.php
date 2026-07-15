<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GlowCare Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <section class="hero">
        <div class="container">
            <span class="badge bg-light text-dark mb-3">GlowCare Skincare Store</span>
            <h1>Rawat kulitmu dengan pilihan skincare yang pas</h1>
            <p class="mt-3 mb-0">Cari cleanser, serum, moisturizer, dan sunscreen favorit lalu pantau pesananmu sampai diterima.</p>
        </div>
    </section>

    <main class="container py-5">
        <div class="row align-items-end g-3 mb-4">
            <div class="col-md-7">
                <span class="section-label">Belanja Skincare</span>
                <h2 class="fw-bold mb-1 mt-2">Katalog Produk</h2>
                <p class="text-muted mb-0">
                    <?= $_SESSION['role'] == 'admin' ? 'Admin dapat melihat katalog sekaligus mengelola produk.' : 'Pilih produk, cek detail, lalu masukkan ke keranjang.'; ?>
                </p>
            </div>
            <div class="col-md-5">
                <form method="GET" class="plain-filter">
                    <input type="hidden" name="page" value="home">
                    <div class="row g-2">
                        <div class="col-12">
                            <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? ''); ?>" class="form-control" placeholder="Cari nama produk...">
                        </div>
                        <div class="col-md-6">
                            <select name="kategori" class="form-select">
                                <option value="">Semua kategori</option>
                                <?php foreach ($categories as $cat) { ?>
                                    <option value="<?= (int) $cat['id_kategori']; ?>" <?= (($_GET['kategori'] ?? '') == $cat['id_kategori']) ? 'selected' : ''; ?>>
                                        <?= htmlspecialchars($cat['nama_kategori']); ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="sort" class="form-select">
                                <option value="">Terbaru</option>
                                <option value="harga_asc" <?= (($_GET['sort'] ?? '') == 'harga_asc') ? 'selected' : ''; ?>>Harga termurah</option>
                                <option value="harga_desc" <?= (($_GET['sort'] ?? '') == 'harga_desc') ? 'selected' : ''; ?>>Harga termahal</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-brand w-100">Cari & Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row g-4" id="produkList">
            <?php foreach ($products as $row) { ?>
                <div class="col-sm-6 col-lg-3 produk-item">
                    <article class="product-card">
                        <?php if ($row['foto'] != "") { ?>
                            <img src="uploads/products/<?= htmlspecialchars($row['foto']); ?>" class="product-image" alt="<?= htmlspecialchars($row['nama_produk']); ?>">
                        <?php } else { ?>
                            <div class="product-image d-flex align-items-center justify-content-center text-muted">No Image</div>
                        <?php } ?>
                        <div class="p-3">
                            <span class="badge text-bg-light mb-2"><?= htmlspecialchars($row['nama_kategori'] ?? 'Tanpa kategori'); ?></span>
                            <h3 class="h6 fw-bold mb-2"><?= htmlspecialchars($row['nama_produk']); ?></h3>
                            <div class="price mb-1">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></div>
                            <div class="small text-muted mb-3">Stok: <?= (int) $row['stok']; ?></div>
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                                <div class="d-grid gap-2">
                                    <a href="index.php?page=product_edit&id=<?= (int) $row['id_produk']; ?>" class="btn btn-brand">Edit Produk</a>
                                    <a href="index.php?page=detail&id=<?= (int) $row['id_produk']; ?>" class="btn btn-outline-secondary">Preview</a>
                                </div>
                            <?php } else { ?>
                                <a href="index.php?page=detail&id=<?= (int) $row['id_produk']; ?>" class="btn btn-brand w-100">Lihat Detail</a>
                            <?php } ?>
                        </div>
                    </article>
                </div>
            <?php } ?>
        </div>

        <?php if (!$products) { ?>
            <div class="panel-card p-4 text-center text-muted">Belum ada produk. Admin dapat menambahkan produk dari dashboard.</div>
        <?php } ?>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
