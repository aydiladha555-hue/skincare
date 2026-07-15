<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Keranjang - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <main class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-1">Keranjang Belanja</h1>
                <p class="text-muted mb-0">Periksa produk sebelum checkout.</p>
            </div>
            <a href="index.php?page=home" class="btn btn-outline-brand">Belanja Lagi</a>
        </div>

        <?php if (!$cartItems) { ?>
            <div class="empty-state text-center">
                <h2 class="h5">Keranjang masih kosong</h2>
                <p class="text-muted">Tambahkan produk dari katalog GlowCare.</p>
                <a href="index.php?page=home" class="btn btn-brand">Lihat Produk</a>
            </div>
        <?php } else { ?>
            <?php $total = 0; ?>
            <form action="index.php?page=cart_update" method="POST">
                <div class="table-responsive user-table">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th style="width: 150px;">Jumlah</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item) { ?>
                                <?php $subtotal = (int) $item['harga'] * (int) $item['jumlah']; $total += $subtotal; ?>
                                <tr>
                                    <td>
                                        <div class="d-flex gap-3 align-items-center">
                                            <?php if ($item['foto'] != "") { ?>
                                                <img src="uploads/products/<?= htmlspecialchars($item['foto']); ?>" class="cart-thumb" alt="<?= htmlspecialchars($item['nama_produk']); ?>">
                                            <?php } else { ?>
                                                <div class="cart-thumb d-flex align-items-center justify-content-center text-muted small">No Image</div>
                                            <?php } ?>
                                            <div>
                                                <strong><?= htmlspecialchars($item['nama_produk']); ?></strong>
                                                <div class="small text-muted">Stok: <?= (int) $item['stok']; ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
                                    <td>
                                        <input type="number" class="form-control" name="jumlah[<?= (int) $item['id_produk']; ?>]" value="<?= (int) $item['jumlah']; ?>" min="1" max="<?= (int) $item['stok']; ?>">
                                    </td>
                                    <td class="price">Rp <?= number_format($subtotal, 0, ',', '.'); ?></td>
                                    <td class="text-end">
                                        <a href="index.php?page=cart_remove&id=<?= (int) $item['id_produk']; ?>" class="btn btn-outline-danger btn-sm">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="row justify-content-end mt-4">
                    <div class="col-md-5">
                        <div class="order-summary">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Total</span>
                                <strong class="price fs-4">Rp <?= number_format($total, 0, ',', '.'); ?></strong>
                            </div>
                            <button class="btn btn-outline-brand w-100 mb-2">Update Keranjang</button>
                            <a href="index.php?page=checkout" class="btn btn-brand w-100">Checkout</a>
                        </div>
                    </div>
                </div>
            </form>
        <?php } ?>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
