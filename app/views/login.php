<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="auth-page">
    <main class="auth-card p-4 p-md-5" style="width: min(100%, 460px);">
        <div class="text-center mb-4">
            <div class="brand-mark mb-3">GC</div>
            <h1 class="h3 fw-bold mb-1">GlowCare</h1>
            <p class="text-muted mb-0">Masuk untuk belanja skincare favoritmu.</p>
        </div>

        <?php if (isset($error)) { ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php } ?>

        <form action="index.php?page=login" method="POST">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-brand w-100 py-2">Login</button>
        </form>

        <div class="text-center mt-4">
            Belum punya akun? <a href="index.php?page=register">Daftar sekarang</a>
        </div>

        <div class="row g-2 mt-4">
            <div class="col-md-6">
                <div class="p-3 rounded bg-light border">
                    <strong class="d-block">Login Admin</strong>
                    <small>admin@glowcare.test</small><br>
                    <small>Password: password</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded bg-light border">
                    <strong class="d-block">Login User</strong>
                    <small>user@glowcare.test</small><br>
                    <small>Password: password</small>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
