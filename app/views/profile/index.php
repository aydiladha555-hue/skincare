<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil Saya - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="user-page">
    <?php include "app/views/layouts/user_navbar.php"; ?>

    <main class="container py-5">
        <div class="user-section">
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="profile-side">
                        <?php if (!empty($user['foto_profil'])) { ?>
                            <img src="uploads/profiles/<?= htmlspecialchars($user['foto_profil']); ?>" class="profile-photo" alt="Foto profil">
                        <?php } else { ?>
                            <div class="profile-photo profile-placeholder"><?= strtoupper(substr($user['username'], 0, 1)); ?></div>
                        <?php } ?>
                        <h1 class="h4 fw-bold mt-3 mb-1"><?= htmlspecialchars($user['username']); ?></h1>
                        <p class="text-muted mb-0"><?= htmlspecialchars($user['email']); ?></p>
                        <span class="badge text-bg-light mt-2"><?= htmlspecialchars($user['role']); ?></span>
                    </div>
                </div>
                <div class="col-lg-8">
                    <h2 class="h4 fw-bold mb-3">Edit Profil</h2>

                    <?php if (isset($_GET['success'])) { ?>
                        <div class="alert alert-success">Profil berhasil diperbarui.</div>
                    <?php } ?>

                    <?php if (isset($error)) { ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                    <?php } ?>

                    <form action="index.php?page=profile_update" method="POST" enctype="multipart/form-data" class="plain-form p-0 border-0">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama</label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="nomor_hp" class="form-control" value="<?= htmlspecialchars($user['nomor_hp'] ?? ''); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Foto Profil</label>
                                <input type="file" name="foto_profil" class="form-control" accept="image/jpeg,image/png,image/webp">
                                <div class="form-text">Kosongkan jika tidak ingin mengganti foto.</div>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alamat</label>
                                <textarea name="alamat" rows="3" class="form-control" required><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-control" placeholder="Opsional">
                                <div class="form-text">Isi hanya kalau ingin mengganti password.</div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-brand">Simpan Profil</button>
                                <a href="index.php?page=home" class="btn btn-light">Kembali</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include "app/views/layouts/user_footer.php"; ?>
</body>
</html>
