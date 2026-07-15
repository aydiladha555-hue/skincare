<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="auth-page">
    <main class="auth-card p-4 p-md-5" style="width: min(100%, 480px);">
        <div class="text-center mb-4">
            <div class="brand-mark mb-3">GC</div>
            <h1 class="h3 fw-bold mb-1">Buat Akun GlowCare</h1>
            <p class="text-muted mb-0">Nikmati katalog skincare yang mudah dipesan.</p>
        </div>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php } ?>

        <form action="index.php?page=register" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" minlength="6" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="nomor_hp" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Alamat</label>
                <textarea name="alamat" rows="3" class="form-control" required></textarea>
            </div>
            <button class="btn btn-brand w-100 py-2">Daftar</button>
        </form>

        <div class="text-center mt-4">
            Sudah punya akun? <a href="index.php?page=login">Login</a>
        </div>
    </main>
</body>
</html>
