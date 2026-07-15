<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <main class="container py-5">
        <h1 class="h3 fw-bold mb-4">Checkout</h1>
        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php } ?>
        <div class="row g-4">
            <div class="col-lg-7">
                <form action="index.php?page=checkout" method="POST" enctype="multipart/form-data" class="plain-form">
                    <div class="mb-3">
                        <label class="form-label">Nama Penerima</label>
                        <input type="text" name="nama_penerima" class="form-control" value="<?= htmlspecialchars($_SESSION['username']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" rows="4" class="form-control" required></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan" rows="3" class="form-control" placeholder="Opsional"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Metode Pembayaran</label>
                        <div class="payment-choice">
                            <label class="payment-option">
                                <input type="radio" name="metode_pembayaran" value="COD" checked>
                                <span>
                                    <strong>COD</strong>
                                    <small>Bayar saat paket diterima</small>
                                </span>
                            </label>
                            <label class="payment-option">
                                <input type="radio" name="metode_pembayaran" value="Transfer Bank">
                                <span>
                                    <strong>Transfer Bank</strong>
                                    <small>Pilih bank tujuan pembayaran</small>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4" id="bankWrapper" style="display:none;">
                        <label class="form-label">Pilih Bank</label>
                        <select name="bank_transfer" class="form-select">
                            <option value="">Pilih bank</option>
                            <option value="BCA - 1234567890 a.n GlowCare">BCA - 1234567890 a.n GlowCare</option>
                            <option value="BRI - 0987654321 a.n GlowCare">BRI - 0987654321 a.n GlowCare</option>
                            <option value="Mandiri - 1122334455 a.n GlowCare">Mandiri - 1122334455 a.n GlowCare</option>
                            <option value="BNI - 5566778899 a.n GlowCare">BNI - 5566778899 a.n GlowCare</option>
                        </select>
                        <div class="form-text">Status pembayaran transfer akan dikonfirmasi admin.</div>
                    </div>
                    <div class="mb-4" id="proofWrapper" style="display:none;">
                        <label class="form-label">Upload Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" class="form-control" accept="image/jpeg,image/png,image/webp,application/pdf">
                        <div class="form-text">Format JPG, PNG, WEBP, atau PDF. Maksimal 2MB.</div>
                    </div>
                    <button class="btn btn-brand w-100">Buat Pesanan</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="order-summary">
                    <h2 class="h5 fw-bold mb-3">Ringkasan</h2>
                    <?php $total = 0; ?>
                    <?php foreach ($cartItems as $item) { ?>
                        <?php $subtotal = (int) $item['harga'] * (int) $item['jumlah']; $total += $subtotal; ?>
                        <div class="d-flex justify-content-between border-bottom py-2">
                            <span><?= htmlspecialchars($item['nama_produk']); ?> x <?= (int) $item['jumlah']; ?></span>
                            <strong>Rp <?= number_format($subtotal, 0, ',', '.'); ?></strong>
                        </div>
                    <?php } ?>
                    <div class="d-flex justify-content-between pt-3">
                        <span>Total</span>
                        <strong class="price fs-4">Rp <?= number_format($total, 0, ',', '.'); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include "app/views/layouts/user_footer.php"; ?>
    <script>
        const radios = document.querySelectorAll('input[name="metode_pembayaran"]');
        const bankWrapper = document.getElementById('bankWrapper');
        radios.forEach(function (radio) {
            radio.addEventListener('change', function () {
                const isTransfer = this.value === 'Transfer Bank';
                bankWrapper.style.display = isTransfer ? 'block' : 'none';
                document.getElementById('proofWrapper').style.display = isTransfer ? 'block' : 'none';
            });
        });
    </script>
</body>
</html>
