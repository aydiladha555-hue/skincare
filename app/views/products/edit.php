<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Produk - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
    <?php include "app/views/layouts/sidebar.php"; ?>

    <div class="admin-shell">
        <?php include "app/views/layouts/navbar.php"; ?>

        <main class="container-fluid p-4">
            <div class="panel-card p-4 mx-auto" style="max-width: 860px;">
                <h2 class="h4 fw-bold mb-4">Edit Produk</h2>

                <?php if (isset($error)) { ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                <?php } ?>

                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="id_kategori" class="form-select" required>
                            <?php foreach ($categories as $kategori) { ?>
                                <option value="<?= (int) $kategori['id_kategori']; ?>" <?= ($kategori['id_kategori'] == $produk['id_kategori']) ? "selected" : ""; ?>>
                                    <?= htmlspecialchars($kategori['nama_kategori']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="nama_produk" value="<?= htmlspecialchars($produk['nama_produk']); ?>" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4"><?= htmlspecialchars($produk['deskripsi']); ?></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Harga</label>
                            <input type="number" name="harga" value="<?= (int) $produk['harga']; ?>" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stok" value="<?= (int) $produk['stok']; ?>" class="form-control" min="0" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Berat Produk (gram)</label>
                            <input type="number" name="berat_produk" value="<?= (int) ($produk['berat_produk'] ?? 0); ?>" class="form-control" min="0" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Foto Saat Ini</label><br>
                        <?php if ($produk['foto'] != "") { ?>
                            <img src="uploads/products/<?= htmlspecialchars($produk['foto']); ?>" class="photo-preview" alt="<?= htmlspecialchars($produk['nama_produk']); ?>">
                        <?php } else { ?>
                            <div class="photo-preview-box">Belum ada foto</div>
                        <?php } ?>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Ganti / Edit Foto</label>
                        <div class="mb-2">
                            <div id="photoPlaceholder" class="photo-preview-box">Preview foto baru</div>
                            <img id="photoPreview" class="photo-preview d-none" alt="Preview foto baru">
                        </div>
                        <input type="file" name="foto" id="foto" class="form-control" accept="image/jpeg,image/png,image/webp">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-brand">Update Produk</button>
                        <a href="index.php?page=products" class="btn btn-light">Kembali</a>
                    </div>
                </form>
            </div>
        </main>
    </div>
    <script>
        document.getElementById("foto").addEventListener("change", function () {
            const file = this.files[0];
            const preview = document.getElementById("photoPreview");
            const placeholder = document.getElementById("photoPlaceholder");

            if (!file) {
                preview.classList.add("d-none");
                placeholder.classList.remove("d-none");
                return;
            }

            preview.src = URL.createObjectURL(file);
            preview.classList.remove("d-none");
            placeholder.classList.add("d-none");
        });
    </script>
</body>
</html>
