<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manajemen User - GlowCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css?v=20260714-4">
</head>
<body class="bg-light">
<?php include "app/views/layouts/sidebar.php"; ?>
<div class="admin-shell">
<?php include "app/views/layouts/navbar.php"; ?>
<main class="container-fluid p-4">
    <h2 class="h4 fw-bold mb-4">Manajemen User</h2>
    <div class="panel-card table-responsive">
        <table class="table mb-0 align-middle">
            <thead><tr><th>Nama</th><th>Email</th><th>No HP</th><th>Alamat</th><th>Role</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?= htmlspecialchars($user['username']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['nomor_hp'] ?? '-'); ?></td>
                        <td><?= htmlspecialchars($user['alamat'] ?? '-'); ?></td>
                        <td>
                            <form action="index.php?page=admin_user_role" method="POST" class="d-flex gap-2">
                                <input type="hidden" name="id_user" value="<?= (int) $user['id_user']; ?>">
                                <select name="role" class="form-select form-select-sm">
                                    <option value="user" <?= $user['role'] == 'user' ? 'selected' : ''; ?>>user</option>
                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : ''; ?>>admin</option>
                                </select>
                                <button class="btn btn-brand btn-sm">Ubah</button>
                            </form>
                        </td>
                        <td>
                            <?php if ($user['role'] != 'admin') { ?>
                                <a href="index.php?page=admin_user_delete&id=<?= (int) $user['id_user']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</a>
                            <?php } else { ?>
                                <span class="text-muted small">Admin</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</main>
</div>
</body>
</html>
